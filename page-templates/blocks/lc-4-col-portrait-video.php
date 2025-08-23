<?php
/**
 * Block template for LC 4 Col Portrait Video.
 *
 * @package lc-harrier2025
 */

defined( 'ABSPATH' ) || exit;

?>
<section class="four-col-video">
	<div class="container py-4">
		<div class="row g-3">
			<div class="col-md-6 col-lg-3 four-col-video__item">
				<h2><?= get_field( 'video_title_1' ); ?></h2>
				<!-- Video 1 -->
				<div class="ratio ratio-9x16">
				 	<?= wp_oembed_get( 'https://player.vimeo.com/video/' . get_field( 'vimeo_id_1' ), $args ); ?>
				</div>
			</div>
			<div class="col-md-6 col-lg-3 four-col-video__item">
				<h2><?= get_field( 'video_title_2' ); ?></h2>
				<!-- Video 2 -->
				<div class="ratio ratio-9x16">
					<?= wp_oembed_get( 'https://player.vimeo.com/video/' . get_field( 'vimeo_id_2' ), $args ); ?>
				</div>
			</div>
			<div class="col-md-6 col-lg-3 four-col-video__item">
				<h2><?= get_field( 'video_title_3' ); ?></h2>
				<!-- Video 3 -->
				<div class="ratio ratio-9x16">
					<?= wp_oembed_get( 'https://player.vimeo.com/video/' . get_field( 'vimeo_id_3' ), $args ); ?>
				</div>
			</div>
			<div class="col-md-6 col-lg-3 four-col-video__item">
				<h2><?= get_field( 'video_title_4' ); ?></h2>
				<!-- Video 4 -->
				<div class="ratio ratio-9x16">
					<?= wp_oembed_get( 'https://player.vimeo.com/video/' . get_field( 'vimeo_id_4' ), $args ); ?>
				</div>
			</div>
		</div>
	</div>
</section>