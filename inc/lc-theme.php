<?php
/**
 * LC Theme Functions
 *
 * This file contains theme-specific functions and customizations for the LC Harrier 2025 theme.
 *
 * @package lc-vyapparel2025
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

require_once LC_THEME_DIR . '/inc/lc-utility.php';
require_once LC_THEME_DIR . '/inc/lc-acf-theme-palette.php';
require_once LC_THEME_DIR . '/inc/lc-blocks.php';
require_once LC_THEME_DIR . '/inc/lc-woocommerce.php';

// Remove unwanted SVG filter injection WP.
remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );

/**
 * Editor styles: opt-in so WP loads editor.css in the block editor.
 * With theme.json present, this just adds your custom CSS on top (variables, helpers).
 */
add_action(
    'after_setup_theme',
    function () {
        add_theme_support( 'editor-styles' );
        add_editor_style( 'css/editor.css' );
    },
    5
);

/**
 * Neutralise legacy palette/font-size support (if parent/Understrap adds them).
 * theme.json is authoritative, but some themes still register supports in PHP.
 * Remove them AFTER the parent has added them (high priority).
 */
add_action(
    'after_setup_theme',
    function () {
        remove_theme_support( 'editor-color-palette' );
        remove_theme_support( 'editor-gradient-presets' );
        remove_theme_support( 'editor-font-sizes' );
    },
    99
);

/**
 * (Optional) Ensure custom colours *aren’t* forcibly disabled by parent.
 * If Understrap disables custom colours, this re-enables them so theme.json works fully.
 */
add_filter( 'should_load_separate_core_block_assets', '__return_true' ); // performance nicety.

/**
 * Removes specific page templates from the available templates list.
 *
 * @param array $page_templates The list of page templates.
 * @return array The modified list of page templates.
 */
function child_theme_remove_page_template( $page_templates ) {
    unset(
        $page_templates['page-templates/blank.php'],
        $page_templates['page-templates/empty.php'],
        $page_templates['page-templates/left-sidebarpage.php'],
        $page_templates['page-templates/right-sidebarpage.php'],
        $page_templates['page-templates/both-sidebarspage.php']
    );
    return $page_templates;
}
add_filter( 'theme_page_templates', 'child_theme_remove_page_template' );

/**
 * Removes support for specific post formats in the theme.
 */
function remove_understrap_post_formats() {
    remove_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );
}
add_action( 'after_setup_theme', 'remove_understrap_post_formats', 11 );



if ( function_exists( 'acf_add_options_page' ) ) {
    acf_add_options_page(
        array(
            'page_title' => 'Site-Wide Settings',
            'menu_title' => 'Site-Wide Settings',
            'menu_slug'  => 'theme-general-settings',
            'capability' => 'edit_posts',
        )
    );
}

/**
 * Initializes widgets, menus, and theme supports.
 *
 * This function registers navigation menus, unregisters sidebars and menus,
 * and adds theme support for custom editor color palettes.
 */
function widgets_init() {

    register_nav_menus(
        array(
            'primary_nav'  => __( 'Primary Nav', 'lc-vyapparel2025' ),
            'footer_menu1' => __( 'Footer Nav 1', 'lc-vyapparel2025' ),
            'footer_menu2' => __( 'Footer Nav 2', 'lc-vyapparel2025' ),
        )
    );

    unregister_sidebar( 'hero' );
    unregister_sidebar( 'herocanvas' );
    unregister_sidebar( 'statichero' );
    unregister_sidebar( 'left-sidebar' );
    unregister_sidebar( 'right-sidebar' );
    unregister_sidebar( 'footerfull' );
    unregister_nav_menu( 'primary' );

    add_theme_support( 'disable-custom-colors' );
}
add_action( 'widgets_init', 'widgets_init', 11 );

remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );

/**
 * Registers a custom dashboard widget for the Lamcat theme.
 */
function register_lc_dashboard_widget() {
    wp_add_dashboard_widget(
        'lc_dashboard_widget',
        'Lamcat',
        'lc_dashboard_widget_display'
    );
}
add_action( 'wp_dashboard_setup', 'register_lc_dashboard_widget' );

/**
 * Displays the content of the Lamcat dashboard widget.
 */
function lc_dashboard_widget_display() {
    ?>
    <div style="display: flex; align-items: center; justify-content: space-around;">
        <img style="width: 50%;"
            src="<?= esc_url( get_stylesheet_directory_uri() . '/img/lc-full.jpg' ); ?>">
        <a class="button button-primary" target="_blank" rel="noopener nofollow noreferrer"
            href="mailto:hello@lamcat.co.uk/">Contact</a>
    </div>
    <div>
        <p><strong>Thanks for choosing Lamcat!</strong></p>
        <hr>
        <p>Got a problem with your site, or want to make some changes & need us to take a look for you?</p>
        <p>Use the link above to get in touch and we'll get back to you ASAP.</p>
    </div>
    <?php
}

// phpcs:disable
// add_filter('wpseo_breadcrumb_links', function( $links ) {
//     global $post;
//     if ( is_singular( 'post' ) ) {
//         $t = get_the_category($post->ID);
//         $breadcrumb[] = array(
//             'url' => '/guides/',
//             'text' => 'Guides',
//         );

//         array_splice( $links, 1, -2, $breadcrumb );
//     }
//     return $links;
// }
// );
// phpcs:enable


/**
 * Enqueues theme-specific scripts and styles.
 *
 * This function deregisters jQuery and disables certain styles and scripts
 * that are commented out for potential use in the theme.
 */
function lc_theme_enqueue() {
    $the_theme = wp_get_theme();
    // phpcs:disable
    // wp_enqueue_script('lightbox-scripts', get_stylesheet_directory_uri() . '/js/lightbox-plus-jquery.min.js', array(), $the_theme->get('Version'), true);
    // wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.6.3.min.js', array(), null, true);
    // wp_enqueue_script('parallax', get_stylesheet_directory_uri() . '/js/parallax.min.js', array('jquery'), null, true);
    // wp_enqueue_style( 'splide-stylesheet', 'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.3/dist/css/splide.min.css', array(), null );
    // wp_enqueue_script( 'splide-scripts', 'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.3/dist/js/splide.min.js', array(), null, true );
    // wp_enqueue_style('lightbox-stylesheet', get_stylesheet_directory_uri() . '/css/lightbox.min.css', array(), $the_theme->get('Version'));
    // wp_enqueue_script('lightbox-scripts', get_stylesheet_directory_uri() . '/js/lightbox.min.js', array(), $the_theme->get('Version'), true);
    // wp_enqueue_style( 'swiper', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css', array(), null );
    // wp_enqueue_script( 'swiper', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js', array(), null, true );
    // wp_enqueue_style( 'glightbox-style', 'https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.3.1/css/glightbox.min.css', array(), $the_theme->get( 'Version' ) );
    // wp_enqueue_script( 'glightbox', 'https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.3.1/js/glightbox.min.js', array(), $the_theme->get( 'Version' ), true );
    // phpcs:enable
    wp_enqueue_style( 'aos-style', 'https://unpkg.com/aos@2.3.1/dist/aos.css', array() );
    wp_enqueue_script( 'aos', 'https://unpkg.com/aos@2.3.1/dist/aos.js', array(), null, true );

    if ( is_checkout() ) {
        wp_enqueue_script( 'jquery' );
    } else {
        wp_deregister_script( 'jquery' );
    }
}
add_action( 'wp_enqueue_scripts', 'lc_theme_enqueue' );

// phpcs:disable
// function add_custom_menu_item($items, $args)
// {
//     if ($args->theme_location == 'primary_nav') {
//         $new_item = '<li class="menu-item menu-item-type-post_tyep menu-item-object-page nav-item"><a href="' . esc_url(home_url('/search/')) . '" class="nav-link" title="Search"><span class="icon-search"></span></a></li>';
//         $items .= $new_item;
//     }
//     return $items;
// }
// add_filter('wp_nav_menu_items', 'add_custom_menu_item', 10, 2);
// phpcs:enable

// VY Founders.

// remove coupon form at top.
add_action(
    'wp',
    function () {
        if ( is_checkout() && ! is_order_received_page() ) {
            remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
        }
    }
);

/*
// rename headings inside core field templates.
add_filter( 'woocommerce_checkout_fields', function( $fields ) {
    // email first
    $fields['billing']['billing_email']['priority'] = 5;
    $fields['billing']['billing_email']['label']    = 'Email address';

    // tidy labels / placeholders
    $fields['billing']['billing_first_name']['label'] = 'First name';
    $fields['billing']['billing_last_name']['label']  = 'Last name';
    $fields['shipping']['shipping_first_name']['label'] = 'First name';
    $fields['shipping']['shipping_last_name']['label']  = 'Last name';

    // optional phone
    if ( isset( $fields['billing']['billing_phone'] ) ) {
        $fields['billing']['billing_phone']['required'] = false;
        $fields['billing']['billing_phone']['label']    = 'Phone (optional)';
    }

    return $fields;
} );
*/

// show the chosen number nicely in the order items (checkout + emails).
add_filter(
    'woocommerce_cart_item_name',
    function ( $name, $cart_item, $key ) {
        if ( ! empty( $cart_item['vy_num'] ) ) {
            $name = 'VY Founder — ' . esc_html( $cart_item['vy_num'] );
        }
        return $name;
    },
    10,
    3
);

// hide the tiny “× 1” on checkout summary for founder line.
add_filter(
    'woocommerce_cart_item_quantity',
    function ( $qty_html, $cart_item, $key ) {
        if ( ! empty( $cart_item['vy_num'] ) ) {
            return '';
        }
        return $qty_html;
    },
    10,
    3
);

// button text.
add_filter(
    'woocommerce_order_button_text',
    function ( $txt ) {
        return 'Submit';
    }
);

add_filter( 'woocommerce_cart_needs_shipping', '__return_false' );
add_filter( 'woocommerce_ship_to_different_address_checked', '__return_false' );
