<?php
/**
 * Template Name: Work Gallery
 *
 * @package lc-harrier2025
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="main">
	<section class="page-hero">
		<?= get_the_post_thumbnail( get_the_ID(), 'full', array( 'class' => 'page-hero__image' ) ); ?>
		<div class="page-hero__overlay"></div>
		<div class="container">
			<div class="row h-100 align-items-center">
				<div class="col-md-8 col-lg-6 col-xl-4 page-hero__content">
					<h1>Previous Work</h1>
					<p class="subtitle">Explore a selection of recent gate, barrier, and security installations across Surrey and West Sussex.</p>
					<a href="/request-survey/" class="btn btn--primary mb-4">Request a Survey</a>
					<div class="d-flex gap-4 justify-content-start">
						<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/gate-safe-logo.webp' ); ?>" class="mb-4" width="118" height="74">
						<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/safecontractor-sticker.webp' ); ?>" class="mb-4" width="74" height="74">
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="gallery">
		<div class="container pb-5">
			<?php
			// Fetch all work_type terms for filter dropdown
			$terms = get_terms(array(
				'taxonomy' => 'work_type',
				'hide_empty' => true,
			));
			?>
			<div class="gallery__filter py-5 d-flex flex-wrap gap-2">
				<button type="button" class="btn btn--filter btn--ghost active" data-filter="">All Work Types</button>
				<?php
				foreach ($terms as $term) {
					?>
					<button type="button" class="btn btn--filter btn--ghost" data-filter="<?= esc_attr($term->slug); ?>">
						<?= esc_html($term->name); ?>
					</button>
					<?php
				}
				?>
			</div>
			<?php
			// Fetch all attachments
			$args = array(
				'post_type'      => 'attachment',
				'post_status'    => 'inherit',
				'posts_per_page' => -1,
				'orderby'        => 'date',
				'order'          => 'DESC',
				'tax_query'      => array(
					array(
						'taxonomy' => 'work_type',
						'field'    => 'slug',
						'terms'    => wp_list_pluck($terms, 'slug'),
						'operator' => 'IN',
					),
				),
			);
			$query = new WP_Query($args);
			if ($query->have_posts()) {
			?>
			<div class="row" id="gallery_items">
				<?php
				while ($query->have_posts()) {
					$query->the_post();
					$work_type_terms = get_the_terms(get_the_ID(), 'work_type');
					$work_type_slugs = array();
					if ($work_type_terms && !is_wp_error($work_type_terms)) {
						foreach ($work_type_terms as $term) {
							$work_type_slugs[] = esc_attr($term->slug);
						}
					}
					$data_attr = !empty($work_type_slugs) ? 'data-work-type="' . implode(' ', $work_type_slugs) . '"' : '';
					?>
					<div class="col-md-4 mb-4 gallery-item-wrapper" <?php echo $data_attr; ?> >
						<a href="<?= esc_url( wp_get_attachment_image_url( get_the_ID(), 'full' ) ); ?>" class="work__link image-16x9 glightbox" data-gallery="work-gallery-all" data-type="image">
							<?= wp_get_attachment_image( get_the_ID(), 'large', false, array( 'class' => 'work__image' ) ); ?>
						</a>
					</div>
					<?php
				}
				?>
			</div>
			<?php
			}
			wp_reset_postdata();
			?>
		</div>
	</section>
	<section class="image-cta">
		<?= wp_get_attachment_image( 277, 'full', false, [ 'class' => 'image-cta__image' ] ); ?>
		<div class="image-cta__overlay"></div>
		<div class="image-cta__content container">
			<div class="row h-100 align-items-center">
				<div class="col-md-7">
					<h2 class="h1 image-cta__title">Inspired by our recent projects?</h2>
					<div class="image-cta__description">If a design has caught your eye, we can create a tailored solution for your property. From gates to full entrance installations, our team is here to help.</div>
				</div>
				<div class="col-md-5 text-center my-auto">
					<a class="btn btn--primary" href="/request-survey/" target="_self">Request a Survey</a>
				</div>
			</div>
		</div>
	</section>
</main>
<?php
add_action(
	'wp_footer',
	function() {
		?>
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
	var filterButtons = document.querySelectorAll('.btn--filter');
	var items = document.querySelectorAll('.gallery-item-wrapper');
	var lightbox;

	function getUrlParam(param) {
		var urlParams = new URLSearchParams(window.location.search);
		return urlParams.get(param);
	}

	function updateGalleryAttributes(val) {
		document.querySelectorAll('.glightbox').forEach(function(link) {
			if (!val) {
				link.setAttribute('data-gallery', 'work-gallery-all');
			} else {
				var workTypes = link.closest('.gallery-item-wrapper').getAttribute('data-work-type');
				if (workTypes && workTypes.split(' ').includes(val)) {
					link.setAttribute('data-gallery', 'work-gallery-' + val);
				} else {
					link.setAttribute('data-gallery', 'none');
				}
			}
		});
	}

	function updateLightbox(val) {
		if (lightbox) {
			lightbox.destroy();
		}
		var selector = '.glightbox[data-gallery="work-gallery-all"]';
		if (val) {
			selector = '.glightbox[data-gallery="work-gallery-' + val + '"]';
		}
		lightbox = GLightbox({
			selector: selector,
			touchNavigation: true,
			loop: true
		});
	}

	function setActiveButton(val) {
		filterButtons.forEach(function(btn) {
			if (btn.getAttribute('data-filter') === val) {
				btn.classList.add('active');
			} else {
				btn.classList.remove('active');
			}
		});
	}

	filterButtons.forEach(function(btn) {
		btn.addEventListener('click', function() {
			var val = btn.getAttribute('data-filter');
			setActiveButton(val);
			items.forEach(function(item) {
				if (!val || item.getAttribute('data-work-type') && item.getAttribute('data-work-type').split(' ').includes(val)) {
					item.style.display = '';
				} else {
					item.style.display = 'none';
				}
			});
			updateGalleryAttributes(val);
			updateLightbox(val);
		});
	});

	// Initial setup: check for work_type in URL
	var initialVal = getUrlParam('work_type') || '';
	setActiveButton(initialVal);
	items.forEach(function(item) {
		if (!initialVal || item.getAttribute('data-work-type') && item.getAttribute('data-work-type').split(' ').includes(initialVal)) {
			item.style.display = '';
		} else {
			item.style.display = 'none';
		}
	});
	updateGalleryAttributes(initialVal);
	updateLightbox(initialVal);
});
</script>
		<?php
	}
);

get_footer();