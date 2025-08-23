<?php
/**
 * Block template for LC Credentials.
 *
 * @package lc-harrier2025
 */

defined( 'ABSPATH' ) || exit;

?>
<section class="credentials py-5 has-secondary-900-background-color has-white-color">
	<div class="container">
		<h2>Expertise and credentials you can trust</h2>
		<div class="credentials__intro w-constrained-md mb-5">With decades of combined experience and industry-recognised approval, Harrier Gates delivers quality you can rely on.</div>
		<div class="row g-5">
			<div class="col-md-6">
				<div class="credentials__item">
					<i class="credentials__icon fas fa-map-marker-alt"></i>
					<div class="credentials__detail">
						<h3>Based in Shalford.</h3>
						Serving West Sussex, Surrey, and the Home Counties.
					</div>
				</div>
				<div class="credentials__item">
					<i class="credentials__icon fa-solid fa-shield"></i>
					<div class="credentials__detail">
						<h3>Gate Safe approved installer</h3>
						Meeting the highest safety and compliance standards.
					</div>
				</div>
				<div class="credentials__item">
					<i class="credentials__icon fas fa-award"></i>
					<div class="credentials__detail">
						<h3>Over 24 years of collective experience</h3>
						Technical skill and practical know-how on every project.
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="credentials__item">
					<i class="credentials__icon fa-solid fa-handshake"></i>
					<div class="credentials__detail">
						<h3> Trusted manufacturers.</h3>
						Working with proven systems from BFT, CAME, FAAC, Paxton, Telguard, and Videx.
						<div class="d-flex flex-wrap gap-3 mt-3 justify-content-center align-items-center">
							<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/logos/logo-bft--wo.png' ); ?>" class="credentials__logo" width="155" height="65" alt="BFT logo">
							<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/logos/logo-came--wo.png' ); ?>" class="credentials__logo" width="155" height="65" alt="CAME logo">
							<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/logos/logo-faac--wo.png' ); ?>" class="credentials__logo" width="155" height="65" alt="FAAC logo">
							<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/logos/logo-paxton--wo.png' ); ?>" class="credentials__logo" width="155" height="65" alt="Paxton logo">
							<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/logos/logo-telguard--wo.png' ); ?>" class="credentials__logo" width="155" height="65" alt="Telguard logo">
							<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/logos/logo-videx--wo.png' ); ?>" class="credentials__logo" width="155" height="65" alt="Videx logo">
						</div>
					</div>
				</div>
			</div>
		</div>			
	</div>
</section>