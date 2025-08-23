<?php
/**
 * Block template for LC Home Hero.
 *
 * @package lc-harrier2025
 */

defined( 'ABSPATH' ) || exit;

?>
<section class="home-hero pb-5">
	<div class="container hero-grid">
        <div class="hero-title">
            <h1 class="mt-4 mb-0"><?= wp_kses_post( get_field( 'title' ) ); ?></h1>
            <p class="subtitle subtle mb-4"><?= wp_kses_post( get_field( 'subtitle' ) ); ?></p>
            <a href="#" class="btn btn--primary mb-4">Request a Survey</a>
			<div class="d-flex gap-4 justify-content-around">
				<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/gate-safe-logo.webp' ); ?>" alt="Gate Safe" class="mb-4" width="118" height="74">
				<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/safecontractor-sticker.webp' ); ?>" alt="Safe Contractor" class="mb-4" width="74" height="74">
			</div>
        </div>
		<div class="hero-image carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
			<div class="carousel-inner">
				<?php
				$active = 'active';
				foreach ( get_field( 'images' ) as $image ) {
					echo '<div class="carousel-item ' . esc_attr( $active ) . '">';
					echo wp_get_attachment_image($image, 'full', false, array('class' => 'hero-img'));
					echo '</div>';
					$active = ''; // Set active to empty for subsequent items
				}
				?>
			</div>
		</div>
		<div class="hero-spinner">
			<div class="hero-spinner__stat">
				<?php
				$stat_1 = get_field( 'stats_1' );
				?>
				<span class="hero-spinner__value"><?= esc_html( $stat_1['stat'] ); ?></span>
				<span class="hero-spinner__suffix"><?= esc_html( $stat_1['suffix'] ); ?></span>
				<div class="hero-spinner__title">
					<?= esc_html( $stat_1['stat_title'] ); ?>
				</div>
			</div>
			<div class="hero-spinner__stat">
				<?php
				$stat_2 = get_field( 'stats_2' );
				?>
				<span class="hero-spinner__value"><?= esc_html( $stat_2['stat'] ); ?></span>
				<span class="hero-spinner__suffix"><?= esc_html( $stat_2['suffix'] ); ?></span>
				<div class="hero-spinner__title">
					<?= esc_html( $stat_2['stat_title'] ); ?>
				</div>
			</div>
			<div class="hero-spinner__stat">
				<?php
				$stat_3 = get_field( 'stats_3' );
				?>
				<span class="hero-spinner__value"><?= esc_html( $stat_3['stat'] ); ?></span>
				<span class="hero-spinner__suffix"><?= esc_html( $stat_3['suffix'] ); ?></span>
				<div class="hero-spinner__title">
					<?= esc_html( $stat_3['stat_title'] ); ?>
				</div>
			</div>
		</div>
    </div>
</section>
<?php
add_action(
	'wp_footer',
	function () {
		?>
<script src="https://cdn.jsdelivr.net/npm/countup.js@2.6.2/dist/countUp.umd.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statSpinnerSection = document.querySelector('.hero-spinner');
    if (!statSpinnerSection) return;

    let hasAnimated = false;

    function animateStats() {
        if (hasAnimated) return;
        hasAnimated = true;

        document.querySelectorAll('.hero-spinner__value').forEach(function (el) {
            const rawValue = el.textContent.replace(/,/g, '');
            const value = parseFloat(rawValue);
            const decimalPlaces = (rawValue.split('.')[1] || '').length;

            // Use CountUp from UMD build (window.CountUp)
            var CountUpClass = window.CountUp || window.countUp.CountUp;
            if (typeof CountUpClass !== 'function') {
                el.textContent = value;
                return;
            }
            const countUpInstance = new CountUpClass(el, value, {
                decimalPlaces: decimalPlaces > 2 ? 2 : decimalPlaces,
                duration: 2,
                useGrouping: true
            });
            if (!countUpInstance.error) {
                countUpInstance.start();
            } else {
                el.textContent = value;
            }
        });
    }

    // Intersection Observer
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                animateStats();
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.5
    });

    observer.observe(statSpinnerSection);
});
</script>
		<?php
	}
);