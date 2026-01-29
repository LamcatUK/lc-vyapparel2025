<?php
/**
 * Block: Panel
 *
 * @package lc-vyapparel2025
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param int|string $post_id The post ID this block is saved to.
 */

$variant = strtolower( get_field( 'variant' ) );
$image   = get_field( 'background_image' );
$focal_x = (int) get_field( 'focal_x' );
$focal_y = (int) get_field( 'focal_y' );
$focal_x = $focal_x >= 0 && $focal_x <= 100 ? $focal_x : 50;
$focal_y = $focal_y >= 0 && $focal_y <= 100 ? $focal_y : 50;

$classes = array( 'lc-panel' );
if ( $variant ) {
	$classes[] = 'lc-panel--' . esc_attr( $variant );
}
$attr_class = implode( ' ', $classes );

// set background via CSS vars.
$style  = '--fx:' . $focal_x . '%;';
$style .= '--fy:' . $focal_y . '%;';
if ( $image && ! empty( $image['url'] ) ) {
	// Use a CSS variable for background so the ::before pseudo-element can apply cover/no-repeat.
	$style .= '--bg:url(' . esc_url( $image['url'] ) . ');';
}
// read group data for the selected variant (if present). This returns an array of sub-fields.
$variant_data = is_string( $variant ) ? get_field( $variant ) : null;
?>
<section class="<?= esc_attr( $attr_class ); ?>" style="<?= esc_attr( $style ); ?>" role="region" aria-label="Hero panel" id="<?= esc_attr( get_field( 'section_id' ) ); ?>">
		<?php
		if ( 'opener' === $variant ) {
			echo '<div class="container text-center">';
			// Read opener group once.
			$opener = is_array( $variant_data ) ? $variant_data : array();

			// Small centered glyph (optional).
			if ( get_field( 'show_brand_glyph' ) ) {
				?>
				<div class="lc-panel__logo-wrap" aria-hidden="true">
					<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/vy-logo.svg' ); ?>" class="lc-panel__logo" width=95 height=93 alt="" />
				</div>
				<?php
			}
			if ( ! empty( $opener['eyebrow'] ) ) {
				?>
				<div class="u-eyebrow text-uppercase"><?= esc_html( $opener['eyebrow'] ); ?></div>
				<?php
			}

			// Main title with optional accent span.
			if ( ! empty( $opener['title_main'] ) ) {
				?>
				<h1 class="u-display text-uppercase col-accent">
					<?= esc_html( $opener['title_main'] ); ?>
				</h1>
				<?php
			}

			if ( ! empty( $opener['subtitle'] ) ) {
				?>
				<p class="u-subtitle"><?= esc_html( $opener['subtitle'] ); ?></p>
				<?php
			}

			echo '</div>';

			?>

			<a href="#coded" class="u-button button">
				Become a VY Elite Member Today
			</a>
			<?php
		}

		if ( 'claim' === $variant ) {
			echo '<div class="container text-center">';
			// Read opener group once.
			$claim = is_array( $variant_data ) ? $variant_data : array();
			if ( ! empty( $claim['eyebrow'] ) ) {
				?>
				<div class="u-title-lg text-uppercase"><?= wp_kses_post( $claim['eyebrow'] ); ?></div>
				<?php
			}
			if ( ! empty( $claim['intro_copy'] ) ) {
				?>
				<p class="u-body-lg">
					<?= $claim['intro_copy']; ?>
				</p>
				<?php
			}
			if ( ! empty( $claim['headline_main'] ) ) {
				?>
				<h2 class="u-headline text-uppercase">
					<?= wp_kses_post( $claim['headline_main'] ); ?>
				</h2>
				<?php
			}
			if ( ! empty( $claim['kicker'] ) ) {
				?>
				<h2 class="u-body-lg text-uppercase">
					<?= wp_kses_post( $claim['kicker'] ); ?>
				</h2>
				<?php
			}
			if ( ! empty( $claim['button_primary_text'] ) ) {
				?>
				<a href="#<?= esc_attr( $claim['button_primary_id'] ); ?>" class="u-button button">
					<?= esc_html( $claim['button_primary_text'] ); ?>
				</a>
				<?php
			}
			echo '</div>';
		}

		if ( 'coded_legacy' === $variant ) {
			echo '<div class="container text-center">';
			// Read opener group once.
			$coded_legacy = is_array( $variant_data ) ? $variant_data : array();

			if ( ! empty( $coded_legacy['title'] ) ) {
				?>
				<h2 class="u-headline text-uppercase">
					<?= wp_kses_post( $coded_legacy['title'] ); ?>
				</h2>
				<?php
			}
			if ( ! empty( $coded_legacy['intro'] ) ) {
				?>
				<h2 class="u-body-lg">
					<?= wp_kses_post( $coded_legacy['intro'] ); ?>
				</h2>
				<?php
			}
			if ( ! empty( $coded_legacy['pre_form'] ) ) {
				?>
				<p class="u-body-lg col-accent">
					<?= wp_kses_post( $coded_legacy['pre_form'] ); ?>
				</p>
				<?php
			}

			if ( ! empty( $coded_legacy['product_id'] ) ) {
				echo do_shortcode( '[vy_number_picker product_id="' . esc_attr( $coded_legacy['product_id'] ) . '" button_text="Secure my number"]' );
			}

			if ( ! empty( $coded_legacy['post_form'] ) ) {
				?>
				<p class="u-body-lg col-accent">
					<?= wp_kses_post( $coded_legacy['post_form'] ); ?>
				</p>
				<?php
			}
			echo '</div>';
		}

		if ( 'long_copy' === $variant ) {
			echo '<div class="container text-center">';
			// Read opener group once.
			$long_copy = is_array( $variant_data ) ? $variant_data : array();

			if ( ! empty( $long_copy['title'] ) ) {
				?>
				<h2 class="u-headline text-uppercase text-black">
					<?= wp_kses_post( $long_copy['title'] ); ?>
				</h2>
				<?php
			}
			if ( ! empty( $long_copy['copy'] ) ) {
				echo '<div class="u-body-lg text-black">' . wp_kses_post( $long_copy['copy'] ) . '</div>';
			}
			?>
			<div class="lc-panel__vy pt-5" aria-hidden="true">
				<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/visualize-yourself.svg' ); ?>" alt="Visualize Yourself">
			</div>
			<?php
			echo '</div>';
		}

		if ( 'merch' === $variant ) {
			echo '<div class="container d-block text-center">';
			// Read opener group once.
			$merch = is_array( $variant_data ) ? $variant_data : array();

			if ( ! empty( $merch['title'] ) ) {
				?>
			<h2 class="u-headline text-uppercase text-black boxed mb-5">
				<?= wp_kses_post( $merch['title'] ); ?>
			</h2>
				<?php
			}

			if ( have_rows( 'items' ) ) {
				while ( have_rows( 'items' ) ) {
					the_row();

					$layout = get_row_layout();

					if ( 'merchandise_items' === $layout ) {
						?>
			<div class="row g-5">
						<?php
						while ( have_rows( 'merchandise_items' ) ) {
							the_row();
							?>
				<div class="col-md-6 col-lg-4 mb-5">
					<div class="text-start merch__card">
							<?= wp_get_attachment_image( get_sub_field( 'image' ), 'large', false, array( 'class' => 'merch__image mb-4' ) ); ?>
						<h3 class="u-body-lg text-uppercase text-black fw-bold ff-gotham">
							<?= esc_html( get_sub_field( 'title' ) ); ?>
							<?php
							if ( get_sub_field( 'price' ) ) {
								?>
								&mdash; $<?= esc_html( get_sub_field( 'price' ) ); ?>
								<?php
							}
							?>
						</h3>
						<div class="u-body text-black">
							<?= wp_kses_post( get_sub_field( 'description' ) ); ?>
						</div>
					</div>
				</div>
							<?php
						}
						?>
			</div>
						<?php
					}

					if ( 'divider' === $layout ) {
						?>
			<h2 class="u-headline text-uppercase text-black boxed mb-5">
						<?= wp_kses_post( get_sub_field( 'divider' ) ); ?>
			</h2>
						<?php
					}
				}
			}
			echo '</div>';
		}

		if ( 'products' === $variant ) {
			echo '<div class="container d-block text-center">';
			// Read products group.
			$products = is_array( $variant_data ) ? $variant_data : array();

			if ( ! empty( $products['title'] ) ) {
				?>
			<h2 class="u-headline text-uppercase text-black boxed mb-5">
				<?= wp_kses_post( $products['title'] ); ?>
			</h2>
				<?php
			}

			// Get WooCommerce products if available.
			if ( ! empty( $products['product_ids'] ) && function_exists( 'wc_get_product' ) ) {
				$product_ids = is_array( $products['product_ids'] ) ? $products['product_ids'] : array( $products['product_ids'] );
				?>
			<div class="row g-5">
				<?php
				foreach ( $product_ids as $product_id ) {
					$product_id = (int) $product_id;
					if ( ! $product_id ) {
						continue;
					}
					$product = wc_get_product( $product_id );
					if ( ! $product ) {
						continue;
					}
					?>
				<div class="col-md-6 col-lg-4 mb-5">
					<a href="<?= esc_url( get_permalink( $product_id ) ); ?>" class="text-decoration-none">
						<div class="text-start merch__card">
							<?php
							if ( has_post_thumbnail( $product_id ) ) {
								echo get_the_post_thumbnail( $product_id, 'large', array( 'class' => 'merch__image mb-4' ) );
							}
							?>
							<h3 class="u-body-lg text-uppercase text-black fw-bold ff-gotham">
								<?= esc_html( $product->get_name() ); ?>
								<?php if ( $product->get_price() ) { ?>
									&mdash; <?= wp_kses_post( $product->get_price_html() ); ?>
								<?php } ?>
							</h3>
							<div class="u-body text-black">
							<?php
							$description = $product->get_short_description();
							if ( empty( $description ) ) {
								$description = $product->get_description();
							}
							echo wpautop( wp_kses_post( $description ) );
							?>
							</div>
						</div>
					</a>
				</div>
					<?php
				}
				?>
			</div>
				<?php
			}
			echo '</div>';
		}
		?>
	</div>

	<?php
	if ( get_field( 'show_scroll_cue' ) ) {
		?>
		<div class="lc-panel__scroll-cue" aria-hidden="true">
			<a href="#<?= esc_attr( get_field( 'scroll_cue_id' ) ); ?>">
				<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/scroll-cue.svg' ); ?>" alt="Scroll Cue">
			</a>
		</div>
		<?php
	}
	?>

</section>
