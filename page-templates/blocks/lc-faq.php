<?php
/**
 * Block template for LC FAQ.
 *
 * @package lc-harrier2025
 */

defined( 'ABSPATH' ) || exit;

?>
<section class="faq py-5 has-secondary-100-background-color">
	<div class="container">
		<h2><?= esc_html( get_field( 'title' ) ); ?></h2>
		<div class="faq__intro w-constrained-md mb-5"><?= esc_html( get_field( 'intro' ) ); ?></div>
		<?php
		$accordion = random_str(5);

		echo '<div class="faq__inner">';
		echo '<div itemscope="" itemtype="https://schema.org/FAQPage" id="accordion' .  $accordion . '" class="accordion">';

		$counter = 0;
		$show = '';
		$collapsed = 'collapsed';

		$expanded = 'false';
		$collapse = '';
		$button = 'collapsed';

		while ( have_rows( 'faq_items' ) ) {
			the_row();

			$ac = $accordion . '_' . $counter;
            ?>
                <div itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question" class="accordion-item">
                    <div class="accordion-header">
                        <button class="accordion-button fs-500 <?= $button ?>"
                            itemprop="name" type="button" data-bs-toggle="collapse"
                            data-bs-target="#c<?= $ac ?>"
                            aria-expanded="<?= $expanded ?>"
                            aria-controls="c<?= $ac ?>">
                            <?= wp_kses_post( get_sub_field('question') ); ?>
                        </button>
                    </div>
                    <div id="c<?= $ac ?>"
                        class="collapse <?= $show ?>" itemscope=""
                        itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"
                        data-bs-parent="#accordion<?= $accordion ?>">
                        <div class="accordion-body" itemprop="text">
                            <?= wp_kses_post( get_sub_field('answer') ); ?>
                        </div>
                    </div>
                </div>
            <?php
			$counter++;
			$show = '';
			$collapsed = 'collapsed';
		}
		echo '</div>';
		echo '</div>';
		?>
	</div>
</section>