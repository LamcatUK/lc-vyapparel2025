<?php
/**
 * Block template for LC Areas.
 *
 * @package lc-harrier2025
 */

defined( 'ABSPATH' ) || exit;

?>
<section class="areas py-5">
	<?= wp_get_attachment_image( get_field( 'background' ), 'full', false, array( 'class' => 'areas__image' ) ); ?>
	<div class="areas__overlay"></div>
	<div class="areas__content container">
		<h2><?= esc_html( get_field( 'title' ) ); ?></h2>
		<div class="areas__intro w-constrained-md mb-4"><?= esc_html( get_field( 'intro' ) ); ?></div>
		<div class="areas__areas">
			<?php
			// Display areas from areas taxonomy
			lc_render_areas_we_cover_from_taxonomy();
			?>
		</div>
	</div>
</section>