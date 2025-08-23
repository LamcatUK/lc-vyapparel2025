<?php
/**
 * Block template for LC Text Video.
 *
 * @package lc-harrier2025
 */

defined( 'ABSPATH' ) || exit;

$bg      = get_field( 'bg_colour' );
$fg      = get_field( 'fg_colour' );
$classes = array();
$style   = '';

if ( $bg ) {
	$classes[] = 'has-' . sanitize_html_class( $bg ) . '-background-color';
}
if ( $fg ) {
	$classes[] = 'has-' . sanitize_html_class( $fg ) . '-color';
}
?>
<section class="text-video <?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="container py-5">
		<div class="row g-4">
			<div class="col-lg-4">
				<h2 class="mt-0"><?= esc_html( get_field( 'title' ) ); ?></h2>
				<div>
					<?= wp_kses_post( get_field( 'content' ) ); ?>
				</div>
				<?php
				if ( get_field( 'link' ) ) {
					$link = get_field( 'link' );
					?>
					<div class="text-end">
						<a class="btn btn--primary mt-3 me-0" href="<?= esc_url( $link['url'] ); ?>" target="<?= esc_attr( $link['target'] ); ?>">
							<?= esc_html( $link['title'] ); ?>
						</a>
					</div>
					<?php
				}
				?>
			</div>
			<div class="col-lg-8">
				<div class="text-video__vimeo ratio ratio-16x9">
					<?= wp_oembed_get( 'https://player.vimeo.com/video/' . get_field( 'vimeo_id' ) ); ?>
				</div>
			</div>
		</div>
	</div>
</section>