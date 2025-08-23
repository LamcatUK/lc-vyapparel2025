<?php
/**
 * Footer template for the Harrier Gates 2025 theme.
 *
 * This file contains the footer section of the theme, including navigation menus,
 * office addresses, and colophon information.
 *
 * @package lc-harrier2025
 */

defined( 'ABSPATH' ) || exit;
?>
<div id="footer-top"></div>

<footer class="footer py-4">
    <div class="container">
        <div class="row pb-4 g-4">
			<div class="col-sm-3 text-center">
				<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/harrier-gates--wo.webp' ); ?>" alt="Harrier Gates" class="w-100 mb-4 d-block" width="237" height="45">
				<div class="d-flex justify-content-around">
					<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/gate-safe-logo.webp' ); ?>" alt="Gate Safe" class="mb-4" width="118" height="74">
					<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/safecontractor-sticker.webp' ); ?>" alt="Safe Contractor" class="mb-4" width="74" height="74">
				</div>
				<div><a href="/request-survey/" class="btn btn--primary">Request a Survey</a></div>
            </div>
            <div class="col-sm-3">
				<div class="footer-title">Services</div>
                <?=
				wp_nav_menu(
					array(
						'theme_location' => 'footer_menu1',
						'menu_class'     => 'footer__menu',
					)
				);
				?>
            </div>
            <div class="col-sm-3">
				<div class="footer-title">Explore</div>
                <?=
				wp_nav_menu(
					array(
						'theme_location' => 'footer_menu2',
						'menu_class'     => 'footer__menu',
					)
				);
				?>
            </div>
            <div class="col-sm-3 footer__contact">
                <div class="footer-title">Get in touch</div>
				<ul class="fa-ul">
					<li><span class="fa-li"><i class="far fa-envelope"></i></span> <?= do_shortcode( '[contact_email]' ); ?></li>
					<li><span class="fa-li"><i class="fas fa-phone"></i></span> <?= do_shortcode( '[contact_phone]' ); ?></li>
					<li><span class="fa-li"><i class="fas fa-map-marker-alt"></i></span> <?= do_shortcode( '[contact_address]' ); ?></li>
				</ul>
				<div class="d-flex flex-wrap align-items-center social-icons gap-3">
					<span>Connect:</span>
					<?= do_shortcode( '[social_icons class="d-flex justify-content-center gap-3 fs-h3"]' ); ?>
				</div>
            </div>
        </div>

        <div class="colophon d-flex justify-content-between align-items-center flex-wrap">
            <div>
                &copy; <?= esc_html( gmdate( 'Y' ) ); ?> Harrier Gates Limited. Registered in England, no. 10910675
            </div>
            <div>
				Terms of use | Privacy & Cookies |
                Site by <a href="https://www.lamcat.co.uk/" rel="nofollow noopener" target="_blank">Lamcat</a>
            </div>
        </div>
</footer>
<?php wp_footer(); ?>
</body>

</html>