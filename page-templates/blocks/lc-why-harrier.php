<?php
/**
 * Block template for LC Why Harrier.
 *
 * @package lc-harrier2025
 */

defined( 'ABSPATH' ) || exit;

?>
<section class="why-harrier py-5">
	<div class="container">
		<h2 class="mb-4">Why Harrier Gates?</h2>
		<div class="why-harrier__intro w-constrained-md mb-5">Crafted installations, reliable automation, and a reputation built on trust. We combine family values with technical expertise to deliver gates that look exceptional and work flawlessly.</div>
		<div class="row g-4">
			<div class="col-md-6 col-lg-3">
				<div class="why-harrier__card">
					<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/icons/icon-family.svg' ); ?>" alt="" width="75" height="72" class="why-harrier__icon mb-3">
					<h3 class="why-harrier__title">Family-Run Since 2001</h3>
					<div class="why-harrier__subtitle">Trusted personal service.</div>
					<div class="why-harrier__description">Decades of hands-on experience with a commitment to craftsmanship and integrity.</div>
				</div>
			</div>
			<div class="col-md-6 col-lg-3">
				<div class="why-harrier__card">
					<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/icons/icon-local.svg' ); ?>" alt="" width="75" height="72" class="why-harrier__icon mb-3">
					<h3 class="why-harrier__title">Local Expertise</h3>
					<div class="why-harrier__subtitle">Surrey and South East Specialists.</div>
					<div class="why-harrier__description">In-depth knowledge of local properties, planning requirements, and customer needs.</div>
				</div>
			</div>
			<div class="col-md-6 col-lg-3">
				<div class="why-harrier__card">
					<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/icons/icon-entrance.svg' ); ?>" alt="" width="75" height="72" class="why-harrier__icon mb-3">
					<h3 class="why-harrier__title">Complete Entrance Solutions</h3>
					<div class="why-harrier__subtitle">From gates to access control.</div>
					<div class="why-harrier__description">One point of contact for design, manufacture, automation, and installation.</div>
				</div>
			</div>
			<div class="col-md-6 col-lg-3">
				<div class="why-harrier__card">
					<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/icons/icon-quality.svg' ); ?>" alt="" width="75" height="72" class="why-harrier__icon mb-3">
					<h3 class="why-harrier__title">Quality Without Compromise</h3>
					<div class="why-harrier__subtitle">Built to last.</div>
					<div class="why-harrier__description">Using premium materials and proven technology for long-term performance.</div>
				</div>
			</div>
		</div>
		<div class="row d-flex justify-content-center align-items-center g-4 mt-5">
			<div class="col-md-6">
				<h2 class="h3">Proudly recognised for excellence and innovation</h2>
			</div>
			<div class="col-md-6 d-flex justify-content-between flex-wrap">
				<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/logos/logo-sme.png' ); ?>" alt="SME Surrey Business Awards" width="150" height="105" class="mb-3">
				<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/logos/logo-surrey.png' ); ?>" alt="Invest in Surrey 40 under 40 Awards" width="150" height="105" class="mb-3">
				<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/logos/logo-corplivewire.png' ); ?>" alt="Corporate Livewire Innovation Awards" width="150" height="105" class="mb-3">
			</div>
		</div>
	</div>
</section>