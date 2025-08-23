<?php
/**
 * Block template for LC Latest Insights.
 *
 * @package lc-harrier2025
 */

defined( 'ABSPATH' ) || exit;

$classes = is_front_page() ? 'bg-secondary-100' : '';
?>
<section class="latest-insights <?= esc_attr( $classes ); ?> py-5">
   <div class="container py-5">
	   <div class="d-flex justify-content-between flex-wrap">
		   <span>
			   <h2>Insights &amp; Resources</h2>
			   <div class="latest-insights__intro w-constrained-md mb-4">Guides, tips, and updates from the Harrier Gates team.</div>
		   </span>
		   <a href="/insights/" class="align-self-center btn btn--primary">All Insights</a>
	   </div>

	   <?php
	   $insights = new WP_Query(
		   array(
			   'post_type'      => 'post',
			   'post_status'    => 'publish',
			   'posts_per_page' => 6,
			   'orderby'        => 'date',
			   'order'          => 'DESC',
		   )
	   );

	   if ( $insights->have_posts() ) {
		   echo '<div class="swiper latest-insights__swiper pb-4">';
		   echo '<div class="swiper-wrapper">';
		   while ( $insights->have_posts() ) {
			   $insights->the_post();
			   ?>
			   <div class="swiper-slide px-2">
				   <a href="<?= esc_url( get_permalink() ) ?>" class="latest-insights__item">
						<div class="latest-insights__img-wrapper">
							<?= get_the_post_thumbnail( get_the_ID(), 'large', array( 'class' => 'img-fluid mb-3' ) ); ?>
						</div>
						<div class="latest-insights__inner">
							<h3><?= esc_html( get_the_title() ) ?></h3>
							<div class="latest-insights__meta">
								<span><i class="fa-regular fa-calendar"></i> <?= esc_html( get_the_date( 'jS F Y' ) ); ?></span>
								<span><i class="fa-regular fa-clock"></i> <?= wp_kses_post( estimate_reading_time_in_minutes( get_the_content() ) ); ?> minute read</span>
							</div>
							<div class="text-secondary-900"><?= esc_html( get_the_excerpt() ); ?></div>
						</div>
				   </a>
			   </div>
			   <?php
		   }
		   echo '</div>'; // .swiper-wrapper
		   echo '</div>'; // .swiper
		   wp_reset_postdata();
	   } else {
		   echo '<p>No insights found.</p>';
	   }
	   ?>

	   <script>
	   document.addEventListener('DOMContentLoaded', function() {
		   if (window.Swiper) {
			   new Swiper('.latest-insights__swiper', {
				   slidesPerView: 2,
				   spaceBetween: 24,
				   autoplay: true,
				   loop: true,
				   breakpoints: {
					   0: {
						   slidesPerView: 1,
					   },
					   768: {
						   slidesPerView: 2,
					   }
				   }
			   });
		   }
	   });
	   </script>
   </div>
</section>