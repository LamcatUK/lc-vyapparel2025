<?php
/**
 * Template Name: Page
 *
 * @package lc-harrier2025
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

?>
<main id="main" class="blog">
    <?php
if ( is_front_page() ) {
    ?>
<section class="sos">
    <div class="container">
        <div class="text-center">
            <a href="/gate-reset-instructions/"><strong>Gate not working?</strong> See our Emergency Reset Guides for quick fixes <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</section>
    <?php
}
 
    the_post();
    the_content();
	// phpcs:disable
    // $block_names = get_all_block_names_from_content(get_the_ID());
    // print_r($block_names);
	// phpcs:enable
    ?>
</main>
<?php
get_footer();
