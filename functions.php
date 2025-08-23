<?php
/**
 * Understrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

define( 'LC_THEME_DIR', WP_CONTENT_DIR . '/themes/lc-harrier2025' );

require_once LC_THEME_DIR . '/inc/lc-theme.php';

/**
 * Removes the parent themes stylesheet and scripts from inc/enqueue.php
 */
function understrap_remove_scripts() {
	wp_dequeue_style( 'understrap-styles' );
	wp_deregister_style( 'understrap-styles' );

	wp_dequeue_script( 'understrap-scripts' );
	wp_deregister_script( 'understrap-scripts' );
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );


/**
 * Enqueue our stylesheet and javascript file
 */

// Enqueue child-theme.min.css late for override, with filemtime versioning.
function lc_enqueue_theme_css() {
	$rel = '/css/child-theme.min.css';
	$abs = get_stylesheet_directory() . $rel;
	wp_enqueue_style(
		'lc-theme',
		get_stylesheet_directory_uri() . $rel,
		[],
		file_exists( $abs ) ? filemtime( $abs ) : null
	);
}
add_action( 'wp_enqueue_scripts', 'lc_enqueue_theme_css', 20 );

// Enqueue child-theme.min.js with filemtime versioning.
function lc_enqueue_theme_js() {
    $rel = '/js/child-theme.min.js';
    $abs = get_stylesheet_directory() . $rel;
    if ( file_exists( $abs ) ) {
        wp_enqueue_script(
            'lc-theme-js',
            get_stylesheet_directory_uri() . $rel,
            [],
            filemtime( $abs ),
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'lc_enqueue_theme_js', 20 );


/**
 * Load the child theme's text domain
 */
function add_child_theme_textdomain() {
	load_child_theme_textdomain( 'lc-harrier2025', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );


/**
 * Overrides the theme_mod to default to Bootstrap 5
 *
 * This function uses the `theme_mod_{$name}` hook and
 * can be duplicated to override other theme settings.
 *
 * @return string
 */
function understrap_default_bootstrap_version() {
	return 'bootstrap5';
}
add_filter( 'theme_mod_understrap_bootstrap_version', 'understrap_default_bootstrap_version', 20 );



/**
 * Loads javascript for showing customizer warning dialog.
 */
function understrap_child_customize_controls_js() {
	wp_enqueue_script(
		'understrap_child_customizer',
		get_stylesheet_directory_uri() . '/js/customizer-controls.js',
		array( 'customize-preview' ),
		'20130508',
		true
	);
}
add_action( 'customize_controls_enqueue_scripts', 'understrap_child_customize_controls_js' );
