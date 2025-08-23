<?php
/**
 * Block template for LC Contact.
 *
 * @package lc-harrier2025
 */

defined( 'ABSPATH' ) || exit;

?>
<section class="contact">
	<div class="container py-5">
		<div class="row g-5">
			<div class="col-md-6">
				<?php
				if ( get_field( 'contact_title' ) ) {
					echo '<h2>' . esc_html( get_field( 'contact_title' ) ) . '</h2>';
				}
				if ( get_field( 'contact_intro' ) ) {
					echo '<div class="contact__intro mb-4">' . wp_kses_post( get_field( 'contact_intro' ) ) . '</div>';
				}
				?>
				<ul class="contact__details fa-ul">
					<li class="contact__detail mb-3">
						<span class="fa-li"><i class="fa-solid fa-phone"></i></span> <?= do_shortcode( '[contact_phone]' ); ?>
					</li>
					<li class="contact__detail mb-3">
						<span class="fa-li"><i class="fa-regular fa-envelope"></i></span> <?= do_shortcode( '[contact_email]' ); ?>
					</li>
					<li class="contact__detail mb-3">
						<span class="fa-li"><i class="fa-solid fa-map-marker-alt"></i></span>
						<div class="mb-2"><?= do_shortcode( '[contact_address]' ); ?></div>
						<?php if ( get_field( 'directions_url', 'option' ) ) {
							echo '<a href="' . esc_url( get_field( 'directions_url', 'option' ) ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( 'Get Directions' ) . '</a>';
						} ?>
					</li>
				</ul>
			</div>
			<div class="col-md-6">
				<?= do_shortcode( '[contact-form-7 id="' . esc_attr( get_field( 'form_id' ) ) . '" title="' . esc_attr( get_field( 'form_title' ) ) . '"]' ); ?>
			</div>
		</div>
	</div>
	<iframe src="https://www.google.com/maps/embed?pb=<?= esc_attr( get_field( 'map_embed_code', 'option' ) ); ?>" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</section>