<?php
/**
 * Custom taxonomies for the CB TXP theme.
 *
 * This file defines and registers custom taxonomies such as 'Teams' and 'Offices'.
 *
 * @package lc-vyapparel2025
 */

use function Avifinfo\read;

/**
 * Register custom taxonomies for the theme.
 *
 * This function registers two custom taxonomies: 'Teams' and 'Offices'.
 * Both taxonomies are hierarchical and associated with the 'people' post type.
 * The taxonomies are set to be publicly queryable, have a UI in the admin,
 * and support REST API.
 *
 * @return void
 */
function lc_register_taxes() {

    $args = array(
        'labels'             => array(
            'name'          => 'Work Types',
            'singular_name' => 'Work Type',
        ),
        'public'             => true,
        'publicly_queryable' => true,
        'hierarchical'       => true,
        'show_ui'            => true,
        'show_in_nav_menus'  => true,
        'show_tagcloud'      => false,
        'show_in_quick_edit' => true,
        'show_admin_column'  => false,
        'show_in_rest'       => true,
        'rewrite'            => false,
    );
    register_taxonomy( 'work_type', array( 'attachment' ), $args );

    $args = array(
        'labels'             => array(
            'name'          => 'Areas',
            'singular_name' => 'Area',
        ),
        'public'             => false,
        'publicly_queryable' => false,
        'hierarchical'       => true,
        'show_ui'            => true,
        'show_in_nav_menus'  => true,
        'show_tagcloud'      => false,
        'show_in_quick_edit' => true,
        'show_admin_column'  => true,
        'show_in_rest'       => true,
        'rewrite'            => false,
    );
    register_taxonomy( 'area', array( 'attachment' ), $args );
        register_taxonomy_for_object_type( 'area', 'attachment' );

}
add_action( 'init', 'lc_register_taxes' );

add_action( 'restrict_manage_posts', function () {
    global $typenow;
    if ( 'attachment' !== $typenow ) { return; }

    $tax = 'work_type';
    $selected = isset( $_GET[ $tax ] ) ? sanitize_text_field( wp_unslash( $_GET[ $tax ] ) ) : '';

    $args = array(
        'show_option_all' => __( 'All Work Types', 'harrier' ),
        'taxonomy'        => $tax,
        'name'            => $tax,
        'orderby'         => 'name',
        'selected'        => $selected,
        'hierarchical'    => true,
        'depth'           => 3,
        'show_count'      => false,
        'hide_empty'      => false,
    );
    // Defensive: ensure taxonomy exists and is not WP_Error
    $terms = get_terms(array('taxonomy' => $tax, 'hide_empty' => false, 'fields' => 'ids'));
    if (is_wp_error($terms)) {
        return;
    }
    wp_dropdown_categories($args);
} );

/**
 * Bulk-assign Work Types to Media Library attachments.
 * Requires a hierarchical taxonomy 'work_type' registered for 'attachment'.
 */

/**
 * 1) Add bulk actions in Media Library (upload.php)
 */
add_filter( 'bulk_actions-upload', function ( array $actions ) : array {
    // Fetch work_type terms (limit to reasonable number)
    $terms = get_terms( array(
        'taxonomy'   => 'work_type',
        'hide_empty' => false,
        'number'     => 30, // adjust as needed
    ) );

    if ( is_wp_error( $terms ) || empty( $terms ) ) {
        return $actions;
    }

    // Group under a separator label
    $actions['lc_sep'] = '──────────';

    foreach ( $terms as $t ) {
        $actions[ 'lc_assign_work_type_' . (int) $t->term_id ] = sprintf(
            /* translators: %s: term name */
            __( 'Set Work Type: %s', 'harrier' ),
            $t->name
        );
    }

    // Clear option
    $actions['lc_clear_work_type'] = __( 'Clear Work Type', 'harrier' );

    return $actions;
} );

/**
 * 2) Handle the selected bulk action
 */
add_filter( 'handle_bulk_actions-upload', function ( string $redirect_url, string $action, array $ids ) : string {
    if ( empty( $ids ) ) {
        return $redirect_url;
    }

    // Clear all work_type terms
    if ( 'lc_clear_work_type' === $action ) {
        $updated = 0;
        foreach ( $ids as $id ) {
            if ( 'attachment' !== get_post_type( $id ) ) {
                continue;
            }
            $terms = wp_get_object_terms( (int) $id, 'work_type', array('fields' => 'ids') );
            if ( is_wp_error( $terms ) ) {
                $terms = array();
            }
            $res = wp_set_object_terms( (int) $id, array(), 'work_type', false );
            if ( ! is_wp_error( $res ) ) {
                $updated++;
            }
        }
        return add_query_arg(
            array( 'lc_work_type_cleared' => $updated ),
            $redirect_url
        );
    }

    // Set a specific work_type term
    if ( 0 === strpos( $action, 'lc_assign_work_type_' ) ) {
        $term_id = (int) substr( $action, strlen( 'lc_assign_work_type_' ) );
        if ( $term_id > 0 ) {
            $updated = 0;
            foreach ( $ids as $id ) {
                if ( 'attachment' !== get_post_type( $id ) ) {
                    continue;
                }
                $res = wp_set_object_terms( (int) $id, array( $term_id ), 'work_type', false ); // replace, don’t append
                if ( ! is_wp_error( $res ) ) {
                    $updated++;
                }
            }
            return add_query_arg(
                array( 'lc_work_type_set' => $updated, 'lc_work_type_term' => $term_id ),
                $redirect_url
            );
        }
    }

    return $redirect_url;
}, 10, 3 );

/**
 * 3) Admin notices for feedback
 */
add_action( 'admin_notices', function () : void {
    if ( ! empty( $_REQUEST['lc_work_type_cleared'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $n = (int) $_REQUEST['lc_work_type_cleared'];     // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        printf(
            '<div class="notice notice-success is-dismissible"><p>%s</p></div>',
            esc_html( sprintf( _n( 'Cleared Work Type on %d item.', 'Cleared Work Type on %d items.', $n, 'harrier' ), $n ) )
        );
    }
    if ( ! empty( $_REQUEST['lc_work_type_set'] ) && ! empty( $_REQUEST['lc_work_type_term'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $n       = (int) $_REQUEST['lc_work_type_set'];                                       // phpcs:ignore
        $term_id = (int) $_REQUEST['lc_work_type_term'];                                      // phpcs:ignore
        $term    = get_term( $term_id, 'work_type' );
        $label   = $term && ! is_wp_error( $term ) ? $term->name : __( 'selected term', 'harrier' );
        printf(
            '<div class="notice notice-success is-dismissible"><p>%s</p></div>',
            esc_html( sprintf( _n( 'Set Work Type "%2$s" on %1$d item.', 'Set Work Type "%2$s" on %1$d items.', $n, 'harrier' ), $n, $label ) )
        );
    }
} );

/**
 * Show Work Type terms as a column in the Media Library (list view).
 */

// 1) Register the column
add_filter( 'manage_upload_columns', function( $cols ) {
    $cols['work_type'] = __( 'Work Types', 'harrier' );
    return $cols;
} );

// 2) Populate the column
add_action( 'manage_media_custom_column', function( $col, $post_id ) {
    if ( 'work_type' === $col ) {
        $terms = get_the_terms( $post_id, 'work_type' );
        if ( is_wp_error( $terms ) || empty( $terms ) ) {
            echo '<span class="na">—</span>';
            return;
        }
        $out = array();
        foreach ( $terms as $t ) {
            $url = esc_url( add_query_arg( array(
                'post_type'   => 'attachment',
                'work_type'   => $t->slug,
                'mode'        => 'list',
            ), admin_url( 'upload.php' ) ) );
            $out[] = sprintf(
                '<a href="%s">%s</a>',
                $url,
                esc_html( $t->name )
            );
        }
        echo implode( ', ', $out );
    }
}, 10, 2 );

// 3) Make it sortable (optional)
add_filter( 'manage_upload_sortable_columns', function( $cols ) {
    $cols['work_type'] = 'work_type';
    return $cols;
} );

// 4) Adjust query for sorting (optional)
add_action( 'pre_get_posts', function( $query ) {
    if ( is_admin() && $query->is_main_query() ) {
        $orderby = $query->get( 'orderby' );
        if ( 'work_type' === $orderby ) {
            $query->set( 'orderby', 'taxonomy' );
            $query->set( 'taxonomy', 'work_type' );
        }
    }
} );


if ( defined( 'WP_CLI' ) && WP_CLI ) {
    WP_CLI::add_command( 'harrier recount_work_type', function() {
        $taxonomy = 'work_type';
        $object_type = 'attachment';
        $terms = get_terms( array( 'taxonomy' => $taxonomy, 'hide_empty' => false ) );
        $updated = 0;
        global $wpdb;
        foreach ( $terms as $term ) {
            // Get term_taxonomy_id for this term/taxonomy
            $term_taxonomy_id = $wpdb->get_var( $wpdb->prepare(
                "SELECT term_taxonomy_id FROM {$wpdb->term_taxonomy} WHERE term_id = %d AND taxonomy = %s",
                $term->term_id, $taxonomy
            ) );
            if ( ! $term_taxonomy_id ) {
                continue;
            }
            // Recount for this term
            $count = 0;
            $ids = get_objects_in_term( $term->term_id, $taxonomy );
            foreach ( $ids as $id ) {
                if ( get_post_type( $id ) === $object_type ) {
                    $count++;
                }
            }
            // Update the count in wp_term_taxonomy
            $wpdb->update( $wpdb->term_taxonomy, array( 'count' => $count ), array( 'term_taxonomy_id' => $term_taxonomy_id ) );
            $updated++;
            WP_CLI::log( sprintf( 'Term \"%s\" (%d) count set to %d', $term->name, $term->term_id, $count ) );
        }
        WP_CLI::success( sprintf( 'Recounted %d work_type terms.', $updated ) );
    } );
}