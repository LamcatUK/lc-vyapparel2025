<?php
/**
 * Understrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

define( 'LC_THEME_DIR', WP_CONTENT_DIR . '/themes/lc-vyapparel2025' );

require_once LC_THEME_DIR . '/inc/lc-theme.php';


// Previously forced WooCommerce to use classic checkout which prevents
// block-based/payment-request integrations (Stripe UPE). Allow WooCommerce
// to decide which checkout to use so plugins can register their blocks and
// payment request buttons. If you need to force classic checkout again,
// re-enable this filter or scope it behind a theme option.
// add_filter( 'woocommerce_checkout_is_block_checkout', '__return_false' );


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
function lc_enqueue_theme_css() {
	$rel = '/css/child-theme.min.css';
	$abs = get_stylesheet_directory() . $rel;
	wp_enqueue_style(
		'lc-theme',
		get_stylesheet_directory_uri() . $rel,
		array(),
		file_exists( $abs ) ? filemtime( $abs ) : null
	);
}
add_action( 'wp_enqueue_scripts', 'lc_enqueue_theme_css', 20 );

/**
 * Enqueue child theme JavaScript files.
 */
function lc_enqueue_theme_js() {
    $rel = '/js/child-theme.min.js';
    $abs = get_stylesheet_directory() . $rel;
    if ( file_exists( $abs ) ) {
        wp_enqueue_script(
            'lc-theme-js',
            get_stylesheet_directory_uri() . $rel,
            array(),
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
	load_child_theme_textdomain( 'lc-vyapparel2025', get_stylesheet_directory() . '/languages' );
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


/**
 * Completely disable Stripe Express Checkout (Apple Pay, Google Pay, etc.) on product pages.
 * All purchases must go through the cart.
 */

// Disable payment request buttons on product pages at the earliest possible point.
add_action( 'init', function() {
	if ( class_exists( 'WC_Stripe_Payment_Request' ) ) {
		remove_action( 'woocommerce_after_add_to_cart_form', array( 'WC_Stripe_Payment_Request', 'display_payment_request_button_html' ), 1 );
	}
}, 1 );

add_action( 'wp', function() {
	if ( ! is_product() ) {
		return;
	}
	
	// Remove all Stripe payment request hooks.
	remove_all_actions( 'woocommerce_after_add_to_cart_form', 1 );
	remove_all_actions( 'woocommerce_after_add_to_cart_button', 1 );
}, 1 );

// Start output buffering on product pages to strip Stripe buttons from HTML.
add_action( 'template_redirect', function() {
	if ( is_product() ) {
		ob_start( function( $buffer ) {
			// Remove Stripe payment request button HTML.
			$patterns = array(
				'/<div[^>]*id=["\']wc-stripe-payment-request-wrapper["\'][^>]*>.*?<\/div>/is',
				'/<div[^>]*class=["\'][^"\']*wc-stripe-payment-request[^"\']*["\'][^>]*>.*?<\/div>/is',
				'/<div[^>]*id=["\']payment-request-button["\'][^>]*>.*?<\/div>/is',
				'/<div[^>]*class=["\'][^"\']*payment-request-button[^"\']*["\'][^>]*>.*?<\/div>/is',
			);
			
			foreach ( $patterns as $pattern ) {
				$buffer = preg_replace( $pattern, '', $buffer );
			}
			
			return $buffer;
		} );
	}
}, 1 );

// Flush output buffer.
add_action( 'shutdown', function() {
	if ( is_product() && ob_get_level() > 0 ) {
		ob_end_flush();
	}
}, 999 );

// Disable via filters.
add_filter( 'wc_stripe_payment_request_button_locations', function( $locations ) {
	if ( is_product() ) {
		return array();
	}
	return $locations;
}, 1 );

add_filter( 'wc_stripe_show_payment_request_on_product', '__return_false', 1 );
add_filter( 'wc_stripe_hide_payment_request_on_product_page', '__return_true', 1 );

// Dequeue scripts.
add_action( 'wp_enqueue_scripts', function() {
	if ( is_product() ) {
		wp_dequeue_script( 'wc-stripe-payment-request' );
		wp_dequeue_script( 'stripe' );
		wp_deregister_script( 'wc-stripe-payment-request' );
	}
}, 999 );
