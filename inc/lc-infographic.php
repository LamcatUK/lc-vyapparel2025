<?php

defined( 'ABSPATH' ) || exit;

add_shortcode(
	'lc_infographic',
	function () {
		ob_start();
		?>
<style>
.infographic .ig-icon img {
	transform: scale(0.8);
}
.infographic .boxed {
	font-size: var(--fs-400);
}
.infographic .lock-box {
	font-family: var(--ff-sans-primary);
	font-size: 0.875rem;
	font-weight: 700;
	text-transform: uppercase;
	text-align: center;
	max-width: 180px;
	text-wrap: balance;
}
.infographic .lock-box img {
	transform: scale(0.8);
	margin-bottom: 1em;
}
</style>
<section class="infographic">
	<div class="text-center mb-4 ig-icon">
		<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/ig/icon.svg' ); ?>" width=197 height=183 alt="">
	</div>
	<h2 class="text-center u-headline text-uppercase"><span>Founder Membership</span></h2>
	<div class="text-center u-title-lg text-uppercase mb-4">$1,111 Annual Fee</div>
	<div class="d-flex flex-wrap gap-5 w-100 justify-content-center mb-4">
		<div class="align-self-center ig-icon">
			<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/ig/hat.svg' ); ?>" alt="" width=205 height=128>
		</div>
		<div class="align-self-end ig-arrow">
			<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/ig/arrow-down.svg' ); ?>" alt="" width=20 height=56>
		</div>
		<div class="align-self-center ig-icon">
			<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/ig/hoodie.svg' ); ?>" alt="" width=158 height=188>
		</div>
		<div class="align-self-end ig-arrow">
			<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/ig/arrow-down.svg' ); ?>" alt="" width=20 height=56>
		</div>
		<div class="align-self-center ig-icon">
			<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/ig/pants.svg' ); ?>" alt="" width=83 height=188>
		</div>
		<div class="align-self-end ig-arrow">
			<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/ig/arrow-down.svg' ); ?>" alt="" width=20 height=56>
		</div>
		<div class="align-self-center ig-icon">
			<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/ig/box.svg' ); ?>" alt="" width=147 height=158>
		</div>
	</div>
	<div class="text-uppercase boxed mb-4">Every founder receives four authenticated quarterly drops, packaged with preservation accessories and certification.</div>
	<div class="d-flex flex-wrap w-100 justify-content-between align-items-start gap-4">
		<div class="lock-box">
			<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/ig/lock.svg' ); ?>" alt="" width=70 height=57>
			<div class="text-center u-body-sm mt-2">30 % Founder<br>Discount</div>
		</div>
		<div class="lock-box">
			<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/ig/lock.svg' ); ?>" alt="" width=70 height=57>
			<div class="text-center u-body-sm mt-2">Direct<br>Mentorship</div>
		</div>
		<div class="lock-box">
			<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/ig/lock.svg' ); ?>" alt="" width=70 height=57>
			<div class="text-center u-body-sm mt-2">Access to all<br>VY platforms</div>
		</div>
		<div class="lock-box">
			<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/ig/lock.svg' ); ?>" alt="" width=70 height=57>
			<div class="text-center u-body-sm mt-2">Permanent listing<br>in the founder<br>registry portal</div>
		</div>
		<div class="lock-box">
			<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/ig/lock.svg' ); ?>" alt="" width=70 height=57>
			<div class="text-center u-body-sm mt-2">Access to a<br>network of<br>founders</div>
		</div>
		<div class="lock-box">
			<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/ig/lock.svg' ); ?>" alt="" width=70 height=57>
			<div class="text-center u-body-sm mt-2">Invitations to<br>private founder<br>events</div>
		</div>
		<div class="lock-box">
			<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/ig/lock.svg' ); ?>" alt="" width=70 height=57>
			<div class="text-center u-body-sm mt-2">Access to<br>future ventures</div>
		</div>
	</div>
</section>
		<?php
		return ob_get_clean();
	}
);