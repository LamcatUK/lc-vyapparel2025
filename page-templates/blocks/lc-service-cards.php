<?php
/**
 * Block template for LC Service Cards.
 *
 * @package lc-harrier2025
 */

defined( 'ABSPATH' ) || exit;

$parent = get_page_by_path( 'services', OBJECT, 'page' );

// get child pages of the parent service page
$services = get_posts( array(
	'post_type'      => 'page',
	'post_parent'    => $parent->ID,
	'posts_per_page' => -1,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
	'post_status'    => 'publish',
) );
if ( ! $services ) {
	return;
}
?>
<section class="service-cards">
	<div class="container py-5">
		<h2><?= esc_html( get_field( 'title' ) ); ?></h2>
		<div class="service-cards__intro w-constrained-md mb-5"><?= esc_html( get_field( 'intro' ) ); ?></div>
		<div class="row g-4">
			<?php
			foreach ( $services as $service ) {
				?>
				<div class="col-lg-4">
					<a class="service-cards__card" href="<?= esc_url( get_permalink( $service->ID ) ); ?>">
						<div class="service-cards__image-wrapper">
							<?= wp_get_attachment_image( get_post_thumbnail_id( $service->ID ), 'large', false, array( 'class' => 'service-cards__image' ) ); ?>
						</div>
						<div class="service-cards__content">
							<h3 class="service-cards__title"><?= esc_html( $service->post_title ); ?></h3>
							<div class="service-cards__subtitle"><?= esc_html( get_field( 'service_subtitle', $service->ID ) ); ?></div>
						</div>
					</a>
				</div>
			<?php
			}
			?>
		</div>
	</div>
</section>
