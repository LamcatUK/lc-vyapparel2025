<?php
/**
 * Footer template for the Harrier Gates 2025 theme.
 *
 * This file contains the footer section of the theme, including navigation menus,
 * office addresses, and colophon information.
 *
 * @package lc-vyapparel2025
 */

defined( 'ABSPATH' ) || exit;
?>
<div id="footer-top"></div>

<footer class="footer py-5 bg-black">
	<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/bg-footer.jpg' ); ?>" alt="" class="footer-bg">
    <div class="container pt-5">
		<div class="row pb-5">
			<div class="col-md-8">
				<div class="u-headline text-uppercase mb-4">
					<span>The VY Elite List:</span> Your All-Access Pass to What's Next.
				</div>
				<?= do_shortcode( '[mc4wp_form id=' . esc_attr( get_field( 'mc4wp_form_id', 'option' ) ) . ']' ); ?>
			</div>
		</div>

        <div class="colophon fs-400 d-flex justify-content-between align-items-center flex-wrap pt-5">
            <div>
                &copy; <?= esc_html( gmdate( 'Y' ) ); ?> VY APPAREL. All rights reserved. |
				<a href="/privacy-policy/">Privacy Policy</a> |
				<a href="/terms-of-use/">Terms of Use</a>
            </div>
			<div>
				<?= do_shortcode( '[social_icons class="d-flex justify-content-center gap-3 u-body-lg"]' ); ?>
			</div>
        </div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>

</html>