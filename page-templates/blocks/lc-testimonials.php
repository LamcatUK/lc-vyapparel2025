<?php
/**
 * Block template for LC Testimonials.
 *
 * @package lc-harrier2025
 */

defined( 'ABSPATH' ) || exit;

?>
<section class="testimonials py-5">
	<div class="container">
		<h2><?= esc_html( get_field( 'title' ) ); ?></h2>
		<div class="testimonials__intro w-constrained-md mb-4"><?= wp_kses_post( get_field( 'intro' ) ); ?></div>
		<div class="row g-5">
			<div class="col-md-8">
				<?php
				if ( have_rows( 'testimonials' ) ) {
					echo '<div class="testimonials__swiper swiper mb-4">';
					echo '<div class="swiper-wrapper pt-2 pb-3">';
					while ( have_rows( 'testimonials' ) ) {
						the_row();
						$testimonial = get_sub_field( 'quote' );
						$author = get_sub_field( 'attribution' );
						?>
						<div class="swiper-slide">
							<div class="testimonial mb-4">
								<div class="testimonial__icon"><i class="fa-solid fa-quote-left"></i></div>
								<div class="testimonial__text"><?= wp_kses_post( $testimonial ); ?></div>
								<div class="testimonial__author">&mdash; <?= esc_html( $author ); ?></div>
							</div>
						</div>
						<?php
					}
					echo '</div>';
					echo '<div class="swiper-pagination"></div>';
					echo '</div>';
				}
				?>
			</div>
			<div class="col-md-4">
				<?= do_shortcode( '[trustindex no-registration=google]'); ?>
				<div class="text-center">
					<a href="https://search.google.com/local/writereview?placeid=ChIJWauIEo7EdUgRwC-kZDHH-C8" target="_blank" class="btn btn--primary">Write a review</a>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
add_action(
	'wp_footer',
	function() {
		?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var swiper = new Swiper('.testimonials__swiper.swiper', {
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: true,
        },
		effect: 'fade',
		fadeEffect: {
			crossFade: true,
		},
        slidesPerView: 1,
        spaceBetween: 24,
		pagination: {
			el: '.swiper-pagination',
			clickable: true,
		},
    });
});
</script>
		<?php
	}
);