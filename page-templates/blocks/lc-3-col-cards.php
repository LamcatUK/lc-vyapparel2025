<?php
/**
 * Block template for LC 3 Col Cards.
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
<section class="col-cards <?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="container py-5">
		<h2><?= wp_kses_post( get_field( 'title' ) ); ?></h2>
		<div class="col-cards__intro w-constrained-md mb-4"><?= esc_html( get_field( 'intro' ) ); ?></div>
		<div class="row g-3">
			<?php
			if ( have_rows( 'cards' ) ) {
				while ( have_rows( 'cards' ) ) {
					the_row();
					?>
					<div class="col-md-4">
						<div class="col-card">
							<h3 class="fs-body"><?= wp_kses_post( get_sub_field( 'title' ) ); ?></h3>
							<div class="fs-sm fw-thin"><?= wp_kses_post( get_sub_field( 'content' ) ); ?></div>
						</div>
					</div>
					<?php
				}
			}
			?>
		</div>
	</div>
</section>