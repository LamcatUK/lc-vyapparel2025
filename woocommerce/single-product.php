<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Remove Stripe Express Checkout / Payment Request Buttons from product pages.
// All purchases should go via the cart.
remove_action( 'woocommerce_after_add_to_cart_button', 'wc_stripe_payment_request_button', 1 );
remove_action( 'woocommerce_after_add_to_cart_button', 'wc_stripe_upe_payment_request_button', 1 );
remove_action( 'woocommerce_after_add_to_cart_form', 'wc_stripe_payment_request_button', 1 );
remove_action( 'woocommerce_after_add_to_cart_form', 'wc_stripe_upe_payment_request_button', 1 );
remove_action( 'woocommerce_single_product_summary', 'wc_stripe_payment_request_button' );
remove_action( 'woocommerce_single_product_summary', 'wc_stripe_upe_payment_request_button' );

get_header( 'shop' ); ?>

<style>
	/* Hide Stripe Payment Request Buttons on product pages */
	.product .wc-stripe-payment-request-wrapper,
	.product .wc-stripe-payment-request-button-wrapper,
	.product #wc-stripe-payment-request-wrapper,
	.product #wc-stripe-payment-request-button-wrapper,
	.product .stripe-payment-request-button-separator,
	.product .payment-request-button-separator,
	.single-product .wc-stripe-payment-request-wrapper,
	.single-product .wc-stripe-payment-request-button-wrapper,
	.single-product #wc-stripe-payment-request-wrapper,
	.single-product #wc-stripe-payment-request-button-wrapper,
	.single-product .stripe-payment-request-button-separator,
	.single-product .payment-request-button-separator,
	#wc-stripe-payment-request-button,
	#wc-stripe-payment-request-wrapper,
	.wc-stripe-payment-request-button-separator,
	#payment-request-button {
		display: none !important;
		visibility: hidden !important;
		height: 0 !important;
		overflow: hidden !important;
	}
</style>

<script>
	// Aggressively prevent Stripe Payment Request buttons from appearing
	(function() {
		// Prevent initialization
		if (typeof window.wcStripePaymentRequest !== 'undefined') {
			window.wcStripePaymentRequest = null;
		}
		if (typeof window.wc_stripe_payment_request_params !== 'undefined') {
			window.wc_stripe_payment_request_params = null;
		}
		
		// Remove any buttons that appear
		function removeStripeButtons() {
			var selectors = [
				'#wc-stripe-payment-request-wrapper',
				'#wc-stripe-payment-request-button',
				'.wc-stripe-payment-request-wrapper',
				'.wc-stripe-payment-request-button-wrapper',
				'#payment-request-button',
				'.payment-request-button-separator',
				'.wc-stripe-payment-request-button-separator'
			];
			
			selectors.forEach(function(selector) {
				var elements = document.querySelectorAll(selector);
				elements.forEach(function(el) {
					el.remove();
				});
			});
		}
		
		// Run immediately
		removeStripeButtons();
		
		// Run on DOM ready
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', removeStripeButtons);
		} else {
			removeStripeButtons();
		}
		
		// Run periodically to catch dynamic additions
		var observer = new MutationObserver(removeStripeButtons);
		observer.observe(document.body, { childList: true, subtree: true });
		
		// Stop observing after 5 seconds to avoid performance issues
		setTimeout(function() {
			observer.disconnect();
		}, 5000);
	})();
</script>

	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>

			<?php wc_get_template_part( 'content', 'single-product' ); ?>

		<?php endwhile; // end of the loop. ?>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>

<?php
get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
