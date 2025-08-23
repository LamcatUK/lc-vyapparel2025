<?php
/**
 * Block template for LC Text Image.
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
<section class="text-image <?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="container py-5">
		<div class="row g-5">
			<div class="col-md-6">
				<h2><?= wp_kses_post( get_field( 'title' ) ); ?></h2>
				<?= wp_kses_post( get_field( 'content' ) ); ?>
			</div>
			<div class="col-md-6">
				<div class="image-16x9">
					<?= wp_get_attachment_image( get_field( 'image' ), 'full', false, array( 'class' => '' ) ); ?>
				</div>
			</div>
		</div>
	</div>
</section>