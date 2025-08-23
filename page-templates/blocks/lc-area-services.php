<?php
/**
 * Block template for LC Area Services.
 *
 * @package lc-harrier2025
 */

defined( 'ABSPATH' ) || exit;

?>
<section class="service-cards">
	<div class="container py-5">
		<h2><?= esc_html( get_field( 'title' ) ); ?></h2>
		<div class="service-cards__intro w-constrained-md mb-5"><?= esc_html( get_field( 'intro' ) ); ?></div>
		<div class="row g-4">
			<?php
			while ( have_rows( 'services' ) ) {
				the_row();
				?>
				<div class="col-lg-4">
					<a class="service-cards__card" href="<?= esc_url( get_the_permalink( get_sub_field( 'service_page' ) ) ); ?>">
						<div class="service-cards__image-wrapper">
							<?= wp_get_attachment_image( get_post_thumbnail_id( get_sub_field( 'service_page' ) ), 'large', false, array( 'class' => 'service-cards__image' ) ); ?>
						</div>
						<div class="service-cards__content">
							<h3 class="service-cards__title fs-subtle"><?= esc_html( get_sub_field( 'service_card_title' ) ); ?></h3>
						</div>
					</a>
				</div>
			<?php
			}
			?>
		</div>
		<?php
		if ( get_field('after_content') ) {
			?>
			<div class="service-cards__after-content w-constrained-md mt-5">
				<?= wp_kses_post( get_field( 'after_content' ) ); ?>
			</div>
			<?php
		}
		?>
	</div>
</section>