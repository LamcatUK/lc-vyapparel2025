<?php
/**
 * Block template for LC Recent Projects.
 *
 * @package lc-harrier2025
 */

defined( 'ABSPATH' ) || exit;

$work_type = get_field('work_type'); // or get from query var, etc.
$args = array(
    'post_type'      => 'attachment',
    'post_status'    => 'inherit',
    'posts_per_page' => 12,
    'orderby'        => 'date',
    'order'          => 'DESC',
);
if ($work_type) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'work_type',
            'field'    => 'term_id',
            'terms'    => $work_type,
        )
    );
}
$query = new WP_Query($args);
if ($query->have_posts()) {
    ?>
<section class="recent-projects py-5 has-secondary-400-background-color">
    <div class="container">
        <h2><?= esc_html( get_field( 'title' ) ); ?></h2>
        <div class="recent-projects__intro w-constrained-md mb-4"><?= esc_html( get_field( 'intro' ) ); ?></div>
        <?php
        echo '<div class="recent-projects__attachments swiper mb-4">';
        echo '<div class="swiper-wrapper pt-2 pb-3">';
        while ($query->have_posts()) {
            $query->the_post();
            $terms = get_the_terms(get_the_ID(), 'work_type');
            $term_slug = '';
            if ($terms && !is_wp_error($terms) && !empty($terms)) {
                $term_slug = $terms[0]->slug;
            }
            echo '<a class="swiper-slide image-16x9" href="/work/?work_type=' . esc_attr($term_slug) . '">';
            echo wp_get_attachment_image(get_the_ID(), 'medium', false, ['class' => 'img-fluid mb-3']);
            echo '</a>';
        }
        echo '</div>';
        echo '</div>';
        wp_reset_postdata();
        ?>
        <div class="text-center"><a href="/work/" class="btn btn--primary">View more projects</a></div>
    </div>
</section>
    <?php
}
add_action(
    'wp_footer',
    function() {
        ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var swiper = new Swiper('.recent-projects__attachments.swiper', {
        loop: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        slidesPerView: 1,
        spaceBetween: 24,
        breakpoints: {
            768: {
                slidesPerView: 2,
            },
            992: {
                slidesPerView: 3,
            }
        },
    });
});
</script>
        <?php
    }
);