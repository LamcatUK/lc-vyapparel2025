<?php
/**
 * Template Name: Founder Profile
 *
 * @package lc-vyapparel2025
 */

defined( 'ABSPATH' ) || exit;

// Start session BEFORE any headers are sent.
if ( ! session_id() && ! headers_sent() ) {
	session_start();
}

get_header();

// Get founder number from query var (set by rewrite rule).
$founder_number = get_query_var( 'founder_num', '' );

// Handle logout.
if ( ! empty( $founder_number ) && isset( $_GET['action'] ) && 'logout' === $_GET['action'] ) {
	// Clear the session verification
	if ( isset( $_SESSION ) && isset( $_SESSION['vy_verified_founder_number'] ) ) {
		unset( $_SESSION['vy_verified_founder_number'] );
	}
	wp_safe_redirect( '/founder/' . $founder_number );
	exit;
}

// Check if already authenticated via session.
$is_authenticated = false;
if ( isset( $_SESSION['vy_verified_founder_number'] ) && $_SESSION['vy_verified_founder_number'] === $founder_number ) {
	$is_authenticated = true;
}

// Handle password verification.
$auth_error = '';

if ( ! empty( $founder_number ) && isset( $_POST['vy_profile_password'] ) && ! $is_authenticated ) {
	$password = wp_unslash( $_POST['vy_profile_password'] );

	if ( VY_Numbers_Auth::verify_password( $founder_number, $password ) ) {
		// Store verification in session.
		$_SESSION['vy_verified_founder_number'] = $founder_number;
		$is_authenticated = true;
		// Redirect to clear POST data.
		wp_safe_redirect( '/founder/' . $founder_number );
		exit;
	} else {
		$auth_error = 'Incorrect password.';
	}
}
?>

<div class="container py-5">
	<?php if ( empty( $founder_number ) ) : ?>
		
		<!-- No founder number in URL -->
		<div class="founder-profile__empty" style="max-width: 600px; margin: 0 auto; text-align: center;">
			<h2>Founder Profiles</h2>
			<p>To view a founder profile, visit: <code>/founder/[number]</code></p>
			<p>Example: <a href="/founder/0001">/founder/0001</a></p>
		</div>

	<?php else : ?>

		<?php
		// Fetch profile data.
		global $wpdb;
		$table   = $wpdb->prefix . 'vy_numbers';
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching
		$profile = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table} WHERE num = %s", $founder_number ) );

		if ( ! $profile || 'sold' !== $profile->status ) {
			?>
			<div class="alert alert-warning" style="max-width: 600px; margin: 0 auto;">
				<h3>Founder Profile Not Found</h3>
				<p>Founder number <strong><?php echo esc_html( $founder_number ); ?></strong> is not available.</p>
			</div>
			<?php
		} elseif ( ! $is_authenticated ) {
			?>
			<!-- Password form -->
			<div class="founder-profile__auth" style="max-width: 400px; margin: 0 auto;">
				<h2 style="text-align: center; margin-bottom: 2rem;">Founder #<?php echo esc_html( $founder_number ); ?></h2>
				
				<?php if ( ! empty( $auth_error ) ) : ?>
					<div class="alert alert-danger" style="padding: 1rem; margin-bottom: 1rem; background: #fee; border: 1px solid #fcc; border-radius: 4px; color: #c33;">
						<?php echo esc_html( $auth_error ); ?>
					</div>
				<?php endif; ?>

				<form method="post" action="" style="display: flex; flex-direction: column; gap: 1.5rem;">
					
					<div>
						<label for="vy_profile_password" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Password</label>
						<input 
							type="password" 
							id="vy_profile_password" 
							name="vy_profile_password" 
							class="form-control" 
							style="width: 100%; padding: 0.75rem; font-size: 1rem; border: 1px solid #ddd; border-radius: 4px;"
							required 
							autofocus
						>
					</div>

					<button 
						type="submit" 
						class="button u-button" 
						style="padding: 0.75rem 2rem; font-size: 1rem; cursor: pointer;"
					>
						View Profile
					</button>
				</form>
			</div>
			<?php
		} else {
			// Authenticated - show profile.
			?>
			<div class="founder-profile__content" style="max-width: 800px; margin: 0 auto;">
				
				<!-- Navigation Links -->
				<div class="founder-profile__nav" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 1px solid #ddd;">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: #333; text-decoration: none; font-size: 0.875rem; font-weight: 500; transition: color 0.2s;">
						← Home
					</a>
					<a href="<?php echo esc_url( add_query_arg( 'action', 'logout' ) ); ?>" style="color: #666; text-decoration: none; font-size: 0.875rem; font-weight: 500; transition: color 0.2s;">
						Logout
					</a>
				</div>

				<!-- VY Logo -->
				<div class="founder-profile__logo" style="text-align: center; margin-bottom: 2rem;">
					<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/img/vy-logo.svg' ); ?>" alt="VY Logo" style="max-width: 120px; height: auto;" />
				</div>

				<!-- Name & Number -->
				<div class="founder-profile__header" style="text-align: center; margin-bottom: 3rem;">
					<?php if ( ! empty( $profile->first_name ) || ! empty( $profile->last_name ) ) : ?>
						<h1 style="font-size: 2.5rem; margin: 0 0 0.5rem 0; font-weight: 700;">
							<?php echo esc_html( trim( ( $profile->first_name ?? '' ) . ' ' . ( $profile->last_name ?? '' ) ) ); ?>
						</h1>
					<?php endif; ?>
					<p style="font-size: 1.25rem; color: #666; margin: 0; font-weight: 600;">Founder #<?php echo esc_html( $founder_number ); ?></p>
				</div>

				<!-- Profile Picture -->
				<?php if ( ! empty( $profile->profile_picture_url ) ) : ?>
					<div class="founder-profile__picture" style="text-align: center; margin-bottom: 2rem;">
						<img src="<?php echo esc_url( $profile->profile_picture_url ); ?>" alt="Founder #<?php echo esc_attr( $founder_number ); ?>" style="width: 200px; height: 200px; border-radius: 50%; object-fit: cover; border: 4px solid #000;" />
					</div>
				<?php endif; ?>

				<!-- Profile Details -->
				<div class="founder-profile__details" style="background: #f9f9f9; padding: 2rem; border-radius: 8px; margin-bottom: 2rem;">
					
					<?php if ( ! empty( $profile->city ) || ! empty( $profile->state ) || ! empty( $profile->country ) ) : ?>
						<div class="profile-field" style="margin-bottom: 1.5rem;">
							<strong style="display: block; color: #333; font-size: 0.875rem; text-transform: uppercase; margin-bottom: 0.5rem; letter-spacing: 0.05em;">Location</strong>
							<p style="font-size: 1.125rem; margin: 0; line-height: 1.6;">
								<?php
								$location_parts = array_filter( array( $profile->city, $profile->state, $profile->country ) );
								echo esc_html( implode( ', ', $location_parts ) );
								?>
							</p>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $profile->profession ) ) : ?>
						<div class="profile-field" style="margin-bottom: 1.5rem;">
							<strong style="display: block; color: #333; font-size: 0.875rem; text-transform: uppercase; margin-bottom: 0.5rem; letter-spacing: 0.05em;">Profession</strong>
							<p style="font-size: 1.125rem; margin: 0;"><?php echo esc_html( $profile->profession ); ?></p>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $profile->bio ) ) : ?>
						<div class="profile-field" style="margin-bottom: 1.5rem;">
							<strong style="display: block; color: #333; font-size: 0.875rem; text-transform: uppercase; margin-bottom: 0.5rem; letter-spacing: 0.05em;">Bio</strong>
							<p style="font-size: 1rem; line-height: 1.6; margin: 0; white-space: pre-line;"><?php echo esc_html( $profile->bio ); ?></p>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $profile->instagram ) || ! empty( $profile->twitter ) || ! empty( $profile->linkedin ) || ! empty( $profile->website ) ) : ?>
						<div class="profile-field" style="margin-top: 2rem;">
							<strong style="display: block; color: #333; font-size: 0.875rem; text-transform: uppercase; margin-bottom: 0.75rem; letter-spacing: 0.05em;">Connect</strong>
							<div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
								<?php if ( ! empty( $profile->instagram ) ) : ?>
									<a href="<?php echo esc_url( $profile->instagram ); ?>" target="_blank" rel="noopener" style="display: inline-block; padding: 0.5rem 1rem; background: #000; color: #fff; text-decoration: none; border-radius: 4px; font-size: 0.875rem; transition: opacity 0.2s;">
										Instagram
									</a>
								<?php endif; ?>
								<?php if ( ! empty( $profile->twitter ) ) : ?>
									<a href="<?php echo esc_url( $profile->twitter ); ?>" target="_blank" rel="noopener" style="display: inline-block; padding: 0.5rem 1rem; background: #000; color: #fff; text-decoration: none; border-radius: 4px; font-size: 0.875rem; transition: opacity 0.2s;">
										X
									</a>
								<?php endif; ?>
								<?php if ( ! empty( $profile->linkedin ) ) : ?>
									<a href="<?php echo esc_url( $profile->linkedin ); ?>" target="_blank" rel="noopener" style="display: inline-block; padding: 0.5rem 1rem; background: #000; color: #fff; text-decoration: none; border-radius: 4px; font-size: 0.875rem; transition: opacity 0.2s;">
										LinkedIn
									</a>
								<?php endif; ?>
								<?php if ( ! empty( $profile->website ) ) : ?>
									<a href="<?php echo esc_url( $profile->website ); ?>" target="_blank" rel="noopener" style="display: inline-block; padding: 0.5rem 1rem; background: #000; color: #fff; text-decoration: none; border-radius: 4px; font-size: 0.875rem; transition: opacity 0.2s;">
										Website
									</a>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>

			</div>
			<?php
		}
		?>

	<?php endif; ?>
</div>

<?php
get_footer();
