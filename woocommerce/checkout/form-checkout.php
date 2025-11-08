<?php
/**
 * WooCommerce Checkout Form Template
 *
 * @package lc-vyapparel2025
 */

defined( 'ABSPATH' ) || exit;

/**
 * Checkout object instance.
 *
 * @var WC_Checkout $checkout
 */
do_action( 'woocommerce_before_checkout_form', $checkout );

// stop if registration required and not logged in.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
    echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
    return;
}

// read founder numbers from cart (if present).
$vy_nums = array();
foreach ( WC()->cart->get_cart() as $item ) {
    if ( ! empty( $item['vy_num'] ) ) {
        $vy_nums[] = $item['vy_num'];
    }
}
?>
<style>
.vy-pay-hero__number {
	text-transform: uppercase;
	color: var(--col-accent-400);
	font-size: var(--fs-subtitle);
	font-weight: var(--fw-light);
}
</style>

<section class="lc-panel vy-pay-hero" style="--bg:url(<?= esc_url( get_stylesheet_directory_uri() . '/img/vy-pay-hero.jpg' ); ?>);" role="region" aria-label="Hero panel">
  	<div class="container text-center">
		<h1 class="u-display--light text-uppercase">Welcome to the future of <span>luxury</span></h1>
		<div class="u-body-lg">The world of luxury is evolving &mdash; and exclusivity is at the center.</div>
		<div class="u-body-lg">Mass retail dilutes value. VY redefines it.</div>
		
		<div class="u-body-lg">When you claim your Founder Number, you're securing more than a membership. You're locking in your permanent place in the VY legacy &mdash; authenticated, traceable, and engineered to grow in value.</div>
		<div class="u-body-lg">Each Founder receives four exclusive drops a year, crafted in limited runs and verified through our three-layer authentication system. Lower numbers hold the most prestige. Once a number is claimed, it's gone forever.</div>

		<p class="u-body-lg">This is <strong>scarcity you can wear</strong> &mdash; and a movement you can own.</p>

		<?php
		if ( $vy_nums ) {
			foreach ( $vy_nums as $vy_num ) {
				?>
		<div class="vy-pay-hero__number">Your founder number is <strong><?php echo esc_html( $vy_num ); ?></strong></div>
				<?php
			}
		}
		?>

		<div class="u-body-lg fw-bold col-accent">Secure your Founder Number for $1,111 TODAY</div>

		<div class="u-sm">This is a one-time annual fee — not a monthly subscription.<br>
			Your payment includes:
			<ul class="u-body flex-list mt-3">
				<li>Four quarterly VY Elite drops (apparel + accessories)</li>
				<li>Permanent founder number ownership (as long as annual renewal is maintained)</li>
				<li>Exclusive 30% founder pricing + resale margin opportunity</li>
				<li>Access to VY's authenticated registry securing your legacy</li>
			</ul>
		</div>
	</div>
	<div class="lc-panel__scroll-cue" aria-hidden="true">
		<a href="#payment">
			<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/scroll-cue.svg' ); ?>" alt="Scroll Cue">
		</a>
	</div>
</section>
<section class="container py-5" id="payment">
	<form name="checkout" method="post" class="checkout woocommerce-checkout vy-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<div class="vy-checkout__grid">
		<div class="u-body-lg text-center w-md-50 mx-auto mb-5">To authenticate, prevent fraud, and set up future resale capabilities, please provide the following information:</div>
		<?php
		// billing fields (we’ve pruned + reordered via filter below).
		do_action( 'woocommerce_checkout_billing' );

		// if you don’t ship, you can hide this with a filter; leaving here for the screenshot layout.
		// do_action( 'woocommerce_checkout_shipping' );.


		$rows = get_field( 'messages', 'option' );
		if ( is_array( $rows ) ) {
			$total        = count( $rows );
			$random_index = wp_rand( 0, $total - 1 );
			$random_row   = $rows[ $random_index ];


			if ( ! empty( $random_row['primary'] ) ) {
				?>
				<div class="text-center mt-4 p-5 mb-5 mx-auto highlight d-flex flex-column align-items-center"" data-aos="fade-up" data-aos-duration="1000">
					<div class="u-title-lg mb-4"><?= esc_html( $random_row['primary'] ); ?></div>
					<div class="u-body-lg mb-2"><?= esc_html( $random_row['secondary'] ); ?></div>
				</div>
				<?php
			}
		}

		if ( $vy_nums ) {
			?>
		<div class="mt-4 mb-4" data-aos="fade" data-aos-duration="1000">
			<div class="u-subtitle text-center">Want to secure additional numbers?</div>
			<?php echo do_shortcode( '[vy_number_picker product_id="134" button_text="Add Another Number"]' ); ?>
		</div>
			<?php
		}
		?>
		</div>
		<h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>
		<div class="vy-checkout__col vy-checkout__col--right" id="order_review">
			<!-- <h2 class="vy-checkout__heading">Order summary</h2> -->
			<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
			
			<!-- Stripe Payment Request Button (Apple Pay/Google Pay) will appear here -->
			<?php do_action( 'woocommerce_review_order_before_payment' ); ?>
			
			<div class="woocommerce-checkout-review-order">
				<?php do_action( 'woocommerce_checkout_order_review' ); ?>
			</div>
			<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
		</div>
	</div>

	</form>
</section>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
