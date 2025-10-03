<?php
/**
 * Template Name: Temporary Landing Page
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Coming Soon</title>
	<meta property="og:title" content="VY Apparel – Coming Soon">
    <meta property="og:description" content="A new experience is on its way. Get ready to Visualise Yourself.">
    <meta property="og:url" content="https://vyapparel.com/">

	<?php wp_head(); ?>
	<style>
		html, body {
			margin: 0;
			padding: 0;
			font-family: sans-serif;
		}
		.page {
			width: 100vw;
			height: 100vh;
			position: relative;
			display: grid;
			place-content: center;
			isolation: isolate;
		}
		.cover {
			position: absolute;
			inset: 0;
			object-fit: cover;
			z-index: -1;
			width: 100%;
			height: 100%;
		}
		.overlay {
		    position: absolute;
		    inset: 0;
		    background: radial-gradient(circle, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.95) 100%);
	    	pointer-events: none;
	    	z-index: 0;
		}
		.page__inner {
			text-align: center;
			color: white;
			font-size: 2rem;
			z-index: 1;
			display: grid;
			place-content: center;
			text-align: center;
		}
		.logo {
			width: min(300px,50vw);
			margin-bottom: 1rem;
			margin-inline: auto;
			display: block;
		}
		.visualise {
		    width: min(500px, 90vw);
		    margin-bottom: 1rem;
		    margin-inline: auto;
			display: block;
		}
		.coming {
		    width: min(300px,60vw);
            margin-inline: auto;
            display: block;
		}
	</style>
</head>
<body <?php body_class(); ?>>

<div class="page">
	<img src="/wp-content/uploads/2025/10/VY-landing-page.jpg" class="cover" alt="Background">
	<div class="overlay"></div>
	<div class="page__inner">
		<img src="/wp-content/uploads/2025/10/vy-logo.png" class="logo" alt="VY">
		<img src="/wp-content/uploads/2025/10/vy-visualise.png" class="visualise" alt="Visualize Yourself">
		<img src="/wp-content/uploads/2025/10/vy-coming.png" class="coming" alt="Coming Soon">
	</div>
</div>

<?php wp_footer(); ?>
</body>
</html>