<?php
/**
 * Block template for LC Benefits List.
 *
 * @package lc-harrier2025
 */

defined( 'ABSPATH' ) || exit;

?>
<section class="benefits-list">
	<div class="container py-5">
		<div class="row g-5">
			<div class="col-lg-6">
				<h2><?= wp_kses_post( get_field( 'title_left' ) ); ?></h2>
				<div class="benefits-list__intro mb-4"><?= esc_html( get_field( 'intro_left' ) ); ?></div>
				<ul class="benefits-list__items fa-ul">
					<?php
					$i = 1;
					$style = get_field( 'list_type_left' );
					if ( have_rows( 'list_left' ) ) {
						while ( have_rows( 'list_left' ) ) {
							the_row();
							if ( 'Check' === $style ) {
								$icon = '<i class="fa-solid fa-check"></i>';
							} else {
								$icon = $i;
							}
							?>
							<li class="benefits-list__item mb-3">
								<span class="fa-li">
									<?= $icon; ?>
								</span>
								<h3><?= wp_kses_post( get_sub_field( 'title' ) ); ?></h3>
								<?= wp_kses_post( get_sub_field( 'content' ) ); ?>
							</li>
							<?php
							++$i;
						}
					}
					?>
				</ul>
			</div>
			<div class="col-lg-6">
				<h2><?= wp_kses_post( get_field( 'title_right' ) ); ?></h2>
				<div class="benefits-list__intro mb-4"><?= esc_html( get_field( 'intro_right' ) ); ?></div>
				<ul class="benefits-list__items fa-ul">
					<?php
					if ( have_rows( 'list_right' ) ) {
						$i = 1;
						$style = get_field( 'list_type_right' );
						while ( have_rows( 'list_right' ) ) {
							the_row();
							if ( 'Check' === $style ) {
								$icon = '<i class="fa-solid fa-check"></i>';
							} else {
								$icon = '<span class="list_number">' . $i . '</span>';
							}
							?>
							<li class="benefits-list__item mb-3">
								<span class="fa-li">
									<?= $icon; ?>
								</span>
								<h3><?= wp_kses_post( get_sub_field( 'title' ) ); ?></h3>
								<?= wp_kses_post( get_sub_field( 'content' ) ); ?>
							</li>
							<?php
							++$i;
						}
					}
					?>
				</ul>
			</div>
		</div>
	</div>
</section>