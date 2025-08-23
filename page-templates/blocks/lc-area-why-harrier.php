<?php
/**
 * Block template for LC Area Why Harrier.
 *
 * @package lc-harrier2025
 */

defined( 'ABSPATH' ) || exit;

?>
<section class="why-harrier py-5">
	<div class="container">
		<h2 class="mb-5"><?= esc_html( get_field( 'title' ) ); ?></h2>
		<div class="row g-4">
			<div class="col-md-6 col-lg-3">
				<div class="why-harrier__card">
					<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/icons/icon-family.svg' ); ?>" alt="" width="75" height="72" class="why-harrier__icon mb-3">
					<?php
					if (get_field('family_title')) {
						?>
						<h3 class="why-harrier__title"><?= esc_html( get_field( 'family_title' ) ); ?></h3>
						<?php
					}
					if (get_field('family')) {
						?>
						<div class="why-harrier__subtitle"><?= esc_html( get_field( 'family' ) ); ?></div>
						<?php
					}
					?>
				</div>
			</div>
			<div class="col-md-6 col-lg-3">
				<div class="why-harrier__card">
					<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/icons/icon-local.svg' ); ?>" alt="" width="75" height="72" class="why-harrier__icon mb-3">
					<?php
					if (get_field('local_title')) {
						?>
						<h3 class="why-harrier__title"><?= esc_html( get_field( 'local_title' ) ); ?></h3>
						<?php
					}
					if (get_field('local_expertise')) {
						?>
						<div class="why-harrier__subtitle"><?= esc_html( get_field( 'local_expertise' ) ); ?></div>
						<?php
					}
					?>
				</div>
			</div>
			<div class="col-md-6 col-lg-3">
				<div class="why-harrier__card">
					<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/icons/icon-entrance.svg' ); ?>" alt="" width="75" height="72" class="why-harrier__icon mb-3">
					<?php
					if (get_field('standards_title')) {
						?>
						<h3 class="why-harrier__title"><?= esc_html( get_field( 'standards_title' ) ); ?></h3>
						<?php
					}
					if (get_field('standards')) {
						?>
						<div class="why-harrier__subtitle"><?= esc_html( get_field( 'standards' ) ); ?></div>
						<?php
					}
					?>
				</div>
			</div>
			<div class="col-md-6 col-lg-3">
				<div class="why-harrier__card">
					<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/icons/icon-quality.svg' ); ?>" alt="" width="75" height="72" class="why-harrier__icon mb-3">
					<?php
					if (get_field('quality_title')) {
						?>
						<h3 class="why-harrier__title"><?= esc_html( get_field( 'quality_title' ) ); ?></h3>
						<?php
					}
					if (get_field('quality')) {
						?>
						<div class="why-harrier__subtitle"><?= esc_html( get_field( 'quality' ) ); ?></div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
</section>