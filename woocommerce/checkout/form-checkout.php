<?php
defined( 'ABSPATH' ) || exit;

/** @var WC_Checkout $checkout */
do_action( 'woocommerce_before_checkout_form', $checkout );

// stop if registration required and not logged in.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
    echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
    return;
}

// read founder number from cart (if present).
$vy_num = '';
foreach ( WC()->cart->get_cart() as $item ) {
    if ( ! empty( $item['vy_num'] ) ) {
        $vy_num = $item['vy_num'];
        break;
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
		<div class="u-body-lg">The luxury world is evolving &mdash; and resale is at the center.</div>
		<div class="u-body-lg">Vintage and authenticated peices are outperforming retail</div>
		<div class="u-body-lg">You'll hold access to drops that increase in value the moment they sell out &mdash; all tied to a global network of numbered founders.</div>

		<h2 class="u-headline text-uppercase col-accent">You're not just joining a brand.</h2>
		<p class="u-body-lg">You're joining a movement where <strong>your number becomes equity</strong>.</p>

		<?php
		if ( $vy_num ) {
			?>
		<div class="vy-pay-hero__number">Your founder number is <strong><?php echo esc_html( $vy_num ); ?></strong></div>
			<?php
		}
		?>

		<div class="u-body-lg col-accent">Secure your Founder Number for $1,111 TODAY</div>
	</div>
	<div class="lc-panel__scroll-cue" aria-hidden="true">
		<a href="#payment">
			<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/scroll-cue.svg' ); ?>" alt="Scroll Cue">
		</a>
	</div>
</section>
<section class="container" id="payment">
	<form name="checkout" method="post" class="checkout vy-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<div class="vy-checkout__grid">
		<div class="vy-checkout__col vy-checkout__col--left" id="customer_details">
		<h2 class="vy-checkout__heading">Contact information</h2>
		<?php
		// billing fields (we’ve pruned + reordered via filter below)
		do_action( 'woocommerce_checkout_billing' );
		?>

		<h2 class="vy-checkout__heading">Shipping address</h2>
		<?php
		// if you don’t ship, you can hide this with a filter; leaving here for the screenshot layout
		do_action( 'woocommerce_checkout_shipping' );
		?>
		</div>

		<div class="vy-checkout__col vy-checkout__col--right" id="order_review">
		<h2 class="vy-checkout__heading">Order summary</h2>
		<div class="woocommerce-checkout-review-order">
			<?php do_action( 'woocommerce_checkout_order_review' ); ?>
		</div>
		</div>
	</div>

	</form>
</section>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
