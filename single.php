<?php
/**
 * Template for displaying single posts.
 *
 * @package lc-harrier2025
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<main id="main" class="blog">
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<div class="post_hero">
					<?= get_the_post_thumbnail( get_the_ID(), 'full', array( 'class' => 'blog_hero__image' ) ); ?>
				</div>
		        <h1 class="h2"><?= esc_html( get_the_title() ); ?></h1>
				<?php
				// phpcs:disable
				// no read time at the moment as the articles are very short
				// $count = estimate_reading_time_in_minutes(get_the_content(), 200, true, true) ?? null;
				// if ($count) {
				//     echo $count;
				// }
				// phpcs:enable
				?>
				<div class="post_meta mb-4">
					<span><i class="fa-regular fa-calendar"></i> <?= esc_html( get_the_date( 'jS F Y' ) ); ?></span>
					<span><i class="fa-regular fa-clock"></i> <?= esc_html( estimate_reading_time_in_minutes( get_the_content() ) ); ?> minute read</span>
				</div>
				<?php
				echo wp_kses_post( get_the_content() );

				?>
				<div class="author_box mt-5 has-secondary-300-background-color p-4">
					<div class="row">
						<div class="col-md-2">
							<?= wp_get_attachment_image( get_field( 'author_photo', 'option' ), 'medium', false, array( 'class' => 'img-fluid rounded-circle' ) ); ?>
						</div>
						<div class="col-md-10">
							<h4 class="h3">About the Author</h4>
							<?= wp_kses_post( get_field( 'author_bio', 'option' ) ); ?>
						</div>
					</div>
				</div>

				<?php
				$prev = get_previous_post();
				$next = get_next_post();

				// Determine the correct Bootstrap class for alignment.
				if ( $prev && $next ) {
					$justify_class = 'justify-content-between'; // Both buttons → space them apart.
				} elseif ( $next ) {
					$justify_class = 'justify-content-end'; // Only Next → Align right.
				} else {
					$justify_class = 'justify-content-start'; // Only Previous → Align left.
				}
				?>

				<div class="post-navigation mt-4 d-flex <?= esc_attr( $justify_class ); ?>">
					<?php
					if ( $prev ) {
						?>
					<a href="<?= esc_url( get_permalink( $prev ) ); ?>" class="button button--outline">← Previous</a>
						<?php
					}
					if ( $next ) {
						?>
					<a href="<?= esc_url( get_permalink( $next ) ); ?>" class="button button--outline">Next →</a>
						<?php
					}
					?>
				</div>
			</div>
			<div class="col-md-3">
				<?php
				// other posts.
				$q = new WP_Query(
					array(
						'post_type'      => 'post',
						'posts_per_page' => 5,
						'post__not_in'   => array( get_the_ID() ),
						'order'          => 'DESC',
						'orderby'        => 'date',
					)
				);
				if ( $q->have_posts() ) {
					?>
					<div class="sidebar">
						<h2 class="h3">Latest News &amp; Advice</h2>
						<?php
						while ( $q->have_posts() ) {
							$q->the_post();
							$categories = get_the_category();
							if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
								$first_category = $categories[0];
							} else {
								$first_category = null;
							}
							?>
							<a class="latest_posts__item mb-4" href="<?= esc_url( get_permalink() ); ?>">
								<div class="latest_posts__image">
									<?php
									if ( $first_category ) {
										?>
										<span class="badge"><?= esc_html( $first_category->name ); ?></span>
										<?php
									} else {
										?>
										<span class="badge">News</span>
										<?php
									}
									?>
									<?= get_the_post_thumbnail( get_the_ID(), 'large', array( 'class' => 'img-fluid' ) ); ?>
								</div>
								<div class="post_meta ps-4">
									<span><i class="fa-regular fa-calendar"></i> <?= esc_html( get_the_date( 'jS F Y' ) ); ?></span>
									<span><i class="fa-regular fa-clock"></i> <?= esc_html( estimate_reading_time_in_minutes( get_the_content() ) ); ?> minute read</span>
								</div>
								<h3 class="latest_posts__title h4"><?= esc_html( get_the_title() ); ?></h3>
							</a>
							<?php
						}
						wp_reset_postdata();
						?>
					</div>
					<?php
				} else {
					echo '<p>No related posts found.</p>';
				}
				?>
			</div>
		</div>
    </div>
</main>
<?php
get_footer();
?>