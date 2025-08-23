<?php
/**
 * Block template for LC Related Services.
 *
 * @package lc-harrier2025
 */

defined( 'ABSPATH' ) || exit;

?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<section class="related py-5 has-secondary-100-background-color">
	<div class="container">
		<h2><?= esc_html( get_field( 'title' ) ); ?></h2>
		<div class="related__intro w-constrained-md mb-4"><?= esc_html( get_field( 'intro' ) ); ?></div>
		<?php
		// get child pages of 'services' excluding the current page
		$parent = get_page_by_path( 'services' );
		$parent_id = $parent ? $parent->ID : 0;
		$current_id = get_the_ID();
		$args = array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'post_parent'    => $parent_id,
			'post__not_in'   => array( $current_id ),
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
		);
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {
			echo '<div class="service-cards__swiper swiper mb-4">';
			echo '<div class="swiper-wrapper pb-4 pt-3">';
			while ( $query->have_posts() ) {
				$query->the_post();
				?>
				<div class="swiper-slide">
					<a class="service-cards__card" href="<?= esc_url( get_permalink( get_the_ID() ) ); ?>">
						<div class="service-cards__image-wrapper">
							<?= wp_get_attachment_image( get_post_thumbnail_id( get_the_ID() ), 'large', false, array( 'class' => 'service-cards__image' ) ); ?>
						</div>
						<div class="service-cards__content">
							<h3 class="service-cards__title fs-subtle mb-0"><?= esc_html( get_the_title( get_the_ID() ) ); ?></h3>
						</div>
					</a>
				</div>
				<?php
			}
			echo '</div>';
			echo '</div>';
			wp_reset_postdata();
		}
		?>
	</div>
</section>
<?php
add_action(
	'wp_footer',
	function() {
		?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var swiper = new Swiper('.service-cards__swiper.swiper', {
        loop: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        slidesPerView: 1,
        spaceBetween: 24,
        breakpoints: {
            768: {
                slidesPerView: 2,
            },
            992: {
                slidesPerView: 3,
            },
            1200: {
                slidesPerView: 4,
            }
        },
    });
});
</script>
		<?php
	}
);