<?php
/**
 * Block template for LC Page Hero.
 *
 * @package lc-harrier2025
 */

defined( 'ABSPATH' ) || exit;

?>
<section class="page-hero">
	<?= wp_get_attachment_image( get_field( 'background' ), 'full', false, array( 'class' => 'page-hero__image' ) ); ?>
	<div class="page-hero__overlay"></div>
	<div class="container">
		<div class="row h-100 align-items-center">
			<div class="col-md-8 col-lg-6 col-xl-4 page-hero__content">
				<h1><?= esc_html( get_field( 'title' ) ); ?></h1>
				<p class="subtitle"><?= esc_html( get_field( 'subtitle' ) ); ?></p>
				<?php
				$link = get_field( 'link' );
				if ( ! empty( $link ) && ! empty( $link['url'] ) ) {
					?>
					<a href="<?= esc_url( $link['url'] ); ?>" class="btn btn--primary mb-4"><?= esc_html( $link['title'] ); ?></a>
					<?php
				}
				?>
				<div class="d-flex gap-4 justify-content-start">
					<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/gate-safe-logo.webp' ); ?>" alt="Gate Safe" class="mb-4" width="118" height="74">
					<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/safecontractor-sticker.webp' ); ?>" alt="Safe Contractor" class="mb-4" width="74" height="74">
				</div>
			</div>
		</div>
	</div>
</section>