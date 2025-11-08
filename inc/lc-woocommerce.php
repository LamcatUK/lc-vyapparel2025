<?php
/**
 * WooCommerce functions and shortcodes for lc-vyapparel2025.
 *
 * @package lc-vyapparel2025
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'woocommerce_checkout_fields', 'customize_billing_fields' );

add_filter( 'woocommerce_checkout_is_block_checkout', '__return_false' );

// Enable Stripe Payment Request Buttons (Apple Pay/Google Pay).
// Configure in WP Admin > WooCommerce > Settings > Payments > Stripe.
// Look for "Payment Request Buttons" section and enable for checkout.

add_filter(
    'woocommerce_order_item_name',
    function ( $name, $item ) {
        if ( is_order_received_page() || is_wc_endpoint_url( 'view-order' ) ) {
            $name = $item->get_name(); // plain text, no link.
        }
        return $name;
    },
    10,
    2
);

add_filter(
    'woocommerce_order_item_display_meta_key',
    function ( $display_key, $meta, $item ) {
        if ( 'vy_num' === $meta->key ) {
            $display_key = 'Founder Number'; // new label.
        }
        return $display_key;
    },
    10,
    3
);


/**
 * Customize WooCommerce billing fields for the checkout page.
 *
 * @param array $fields The existing checkout fields.
 * @return array Modified checkout fields.
 */
function customize_billing_fields( $fields ) {
    $vy_num = '';

    if ( function_exists( 'WC' ) && ! is_admin() && is_checkout() ) {
        $cart = WC()->cart;
        if ( $cart && ! is_null( $cart ) ) {
            $vy_nums = array();
            foreach ( $cart->get_cart() as $item ) {
                if ( ! empty( $item['vy_num'] ) ) {
                    $vy_nums[] = $item['vy_num'];
                }
            }
        }
    }

    // Add section labels as pseudo-fields.
    $fields['billing']['section_label_contact'] = array(
        'type'        => 'html',
        'label'       => '',
        'priority'    => 1,
        'custom_html' => '<p class="form-row form-heading">' . esc_html( 'Your Contact Details:' ) . '</p>',
    );

    $fields['billing']['section_label_address'] = array(
        'type'        => 'html',
        'label'       => '',
		'class'       => array( 'col-12' ),
        'priority'    => 40,
        'custom_html' => '<p class="form-row form-heading mt-4">' . esc_html( 'Address:' ) . '</p>',
    );

	$fields['billing']['section_label_optional'] = array(
        'type'        => 'html',
        'label'       => '',
		'class'       => array( 'col-12' ),
        'priority'    => 99,
        'custom_html' => '<p class="form-row form-heading mt-4">' . esc_html( 'Optional Information:' ) . '</p>',
    );

	if ( ! empty( $vy_nums ) ) {
		$founder_numbers_html = '<h3 class="form-row mt-4 text-center">Founder Numbers: ' . esc_html( implode( ', ', $vy_nums ) ) . '</h3>';
	} else {
		$founder_numbers_html = '<h3 class="form-row mt-4 text-center">No Founder Numbers Selected</h3>';
	}

	$fields['billing']['section_label_founder'] = array(
        'type'        => 'html',
        'label'       => '',
		'class'       => array( 'col-12' ),
        'priority'    => 110,
        'custom_html' => $founder_numbers_html,
    );

    // Modify existing fields.
    $fields['billing']['billing_first_name']['class']       = array( 'form-group', 'col-md-6' );
    $fields['billing']['billing_first_name']['placeholder'] = 'John';
    $fields['billing']['billing_last_name']['class']        = array( 'form-group', 'col-md-6' );
    $fields['billing']['billing_last_name']['placeholder']  = 'Doe';
	$fields['billing']['billing_email']['placeholder']      = 'john.doe@example.com';
    $fields['billing']['billing_email']['priority']         = 30;
    $fields['billing']['billing_phone']['priority']         = 31;
    $fields['billing']['billing_phone']['required']         = true;
    $fields['billing']['billing_phone']['placeholder']      = '(555) 123-4567)';
    $fields['billing']['billing_phone']['class']            = array( 'form-group', 'col-md-6' );
    $fields['billing']['billing_email']['class']            = array( 'form-group', 'col-md-6' );
    $fields['billing']['billing_country']['class']          = array( 'd-none' );
    $fields['billing']['billing_city']['class']             = array( 'form-group', 'col-md-4' );
    $fields['billing']['billing_city']['label']             = '';
    $fields['billing']['billing_city']['placeholder']       = 'Town/city';
    $fields['billing']['billing_state']['default']          = 'CA';
    $fields['billing']['billing_state']['class']            = array( 'form-group', 'col-md-4' );
    $fields['billing']['billing_state']['label']            = '';
	$fields['billing']['billing_state']['placeholder']      = 'Select an option...';
    $fields['billing']['billing_postcode']['class']         = array( 'form-group', 'col-md-4' );
    $fields['billing']['billing_postcode']['label']         = '';
    $fields['billing']['billing_postcode']['placeholder']   = 'ZIP';

    // Add custom fields.
    $fields['billing']['billing_dob']    = array(
        'type'        => 'text',
        'label'       => 'Date of Birth',
        'placeholder' => '01/23/1990',
        'required'    => false,
        'class'       => array( 'col-md-4' ),
        'priority'    => 100,
    );
    $fields['billing']['billing_sex']    = array(
        'type'        => 'select',
        'label'       => 'Male or Female',
		'options'     => array(
			''       => 'Select an option...',
			'male'   => 'Male',
			'female' => 'Female',
			'other'  => 'Prefer not to say',
		),
        'placeholder' => '',
        'default'     => '',
        'required'    => false,
        'class'       => array( 'col-md-4' ),
        'priority'    => 101,
    );
    $fields['billing']['billing_size']   = array(
        'type'        => 'select',
        'label'       => 'Apparel Size',
		'options'     => array(
			''        => 'Select an option...',
			'xsmall'  => 'XS',
			'small'   => 'S',
			'medium'  => 'M',
			'large'   => 'L',
			'xlarge'  => 'XL',
			'xxlarge' => 'XXL',
		),
        'placeholder' => '',
        'required'    => false,
        'class'       => array( 'col-md-4' ),
        'priority'    => 102,
    );
    $fields['billing']['billing_social'] = array(
        'type'        => 'text',
        'label'       => 'Social Handles',
        'placeholder' => 'Instagram Preferred - (Optional but adds verification + future whitelist/promo power)',
        'required'    => false,
        'class'       => array( 'col-12' ),
        'priority'    => 103,
    );

    $fields['billing']['billing_founder_hidden'] = array(
        'type'    => 'hidden',
        'default' => $vy_num,
    );

    return $fields;
}

add_filter( 'woocommerce_form_field_html', 'render_custom_html_fields', 10, 4 );

/**
 * Render custom HTML fields in WooCommerce checkout.
 *
 * @param string $field The field HTML.
 * @param string $key The field key.
 * @param array  $args The field arguments.
 * @return string Modified field HTML.
 */
function render_custom_html_fields( $field, $key, $args ) {
    if ( isset( $args['custom_html'] ) ) {
        return $args['custom_html'];
    }
    return $field;
}

add_filter( 'woocommerce_checkout_get_value', 'set_billing_state_to_empty', 10, 2 );

/**
 * Set the default value of the billing_state field to empty.
 *
 * @param mixed  $value The current value of the field.
 * @param string $input The field key.
 * @return mixed The modified value.
 */
function set_billing_state_to_empty( $value, $input ) {
    if ( 'billing_state' === $input ) {
        return ''; // Set the default value to empty.
    }
    return $value;
}

// Add remove buttons to founder numbers in checkout order review.
add_filter( 'woocommerce_checkout_cart_item_quantity', 'lc_add_founder_remove_button_to_quantity', 10, 3 );

/**
 * Add remove button in the quantity column for founder numbers.
 *
 * @param string $quantity_html The quantity HTML.
 * @param array  $cart_item The cart item data.
 * @param string $cart_item_key The cart item key.
 * @return string Modified quantity HTML.
 */
function lc_add_founder_remove_button_to_quantity( $quantity_html, $cart_item, $cart_item_key ) {
    // Only for founder numbers.
    if ( empty( $cart_item['vy_num'] ) ) {
        return $quantity_html;
    }

    // Count total founder numbers in cart.
    $founder_count = 0;
    foreach ( WC()->cart->get_cart() as $item ) {
        if ( ! empty( $item['vy_num'] ) ) {
            ++$founder_count;
        }
    }

    // If only one founder number, show "Required" instead of remove button.
    if ( $founder_count <= 1 ) {
        return $quantity_html;
    }

    // Add remove button.
    return $quantity_html . ' <a href="#" class="remove-founder-number" data-cart-key="' . esc_attr( $cart_item_key ) . '" style="margin-left: 8px; color: #dc3545; text-decoration: none; font-size: 16px; font-weight: bold;" title="Remove this founder number">&times;</a>';
}

// Modify cart item name to show founder number prominently.
add_filter( 'woocommerce_cart_item_name', 'lc_modify_cart_item_name', 10, 3 );

/**
 * Modify cart item name to show founder number.
 *
 * @param string $name The cart item name.
 * @param array  $cart_item The cart item data.
 * @param string $cart_item_key The cart item key.
 * @return string Modified cart item name.
 */
function lc_modify_cart_item_name( $name, $cart_item, $cart_item_key ) {
    // Suppress unused parameter warning.
    unset( $cart_item_key );

    if ( ! empty( $cart_item['vy_num'] ) ) {
        $name = 'VY Founder #' . esc_html( $cart_item['vy_num'] );
    }
    return $name;
}

// Override WooCommerce shop URL to point to homepage instead.
add_filter( 'woocommerce_return_to_shop_redirect', 'lc_redirect_shop_to_homepage' );

/**
 * Redirect "Return to shop" links to homepage instead of shop page.
 *
 * @return string Homepage URL.
 */
function lc_redirect_shop_to_homepage() {
    return home_url();
}

// Also override the shop page URL used in notices.
add_filter( 'woocommerce_get_shop_url', 'lc_redirect_shop_to_homepage' );

// Override WooCommerce shop page permalink.
add_filter( 'woocommerce_get_page_permalink', 'lc_override_shop_permalink', 10, 2 );

/**
 * Override shop page permalink to return homepage.
 *
 * @param string $url  The page URL.
 * @param string $page The page slug.
 * @return string Modified URL.
 */
function lc_override_shop_permalink( $url, $page ) {
    if ( 'shop' === $page ) {
        return home_url();
    }
    return $url;
}

// Filter WooCommerce notices to replace shop links with homepage links.
add_filter( 'woocommerce_add_notice', 'lc_replace_shop_links_in_notices', 10, 2 );

/**
 * Replace shop links in WooCommerce notices with homepage links.
 *
 * @param string $message The notice message.
 * @param string $type    The notice type.
 * @return string Modified message.
 */
function lc_replace_shop_links_in_notices( $message, $type ) {
    // Suppress unused parameter warning.
    unset( $type );

    $home_url = home_url();

    // Replace common shop link patterns.
    $message = str_replace( '/shop/', '/', $message );
    $message = str_replace( 'shop"', '"', $message );

    // Replace "Return to shop" text to make it clearer.
    $message = str_replace( 'Return to shop', 'Return to homepage', $message );

    // Handle the specific session expired message.
    if ( strpos( $message, 'session has expired' ) !== false ) {
        $message = 'Sorry, your session has expired. <a href="' . esc_url( $home_url ) . '">Return to homepage</a>';
    }

    return $message;
}

// Also filter the notices that are already stored in session.
add_action( 'init', 'lc_filter_existing_notices' );

/**
 * Filter existing WooCommerce notices to replace shop links.
 */
function lc_filter_existing_notices() {
    if ( function_exists( 'wc_get_notices' ) ) {
        $notices = wc_get_notices();

        if ( ! empty( $notices ) ) {
            // Clear existing notices.
            wc_clear_notices();

            // Re-add them with our modifications.
            foreach ( $notices as $type => $type_notices ) {
                foreach ( $type_notices as $notice ) {
                    $message          = is_array( $notice ) ? $notice['notice'] : $notice;
                    $modified_message = lc_replace_shop_links_in_notices( $message, $type );
                    wc_add_notice( $modified_message, $type );
                }
            }
        }
    }
}

// Add JavaScript to catch any remaining shop links.
add_action( 'wp_footer', 'lc_add_shop_link_interceptor' );

/**
 * Add JavaScript to intercept shop links and redirect to homepage.
 */
function lc_add_shop_link_interceptor() {
    if ( is_checkout() || is_cart() ) {
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Find all links that point to /shop/ and redirect them to homepage
            var shopLinks = document.querySelectorAll('a[href*="/shop/"], a[href$="/shop"]');
            shopLinks.forEach(function(link) {
                link.href = '/';
            });
            
            // Also update any text that says "Return to shop"
            var notices = document.querySelectorAll('.woocommerce-message, .woocommerce-error, .woocommerce-info');
            notices.forEach(function(notice) {
                if (notice.innerHTML.includes('Return to shop')) {
                    notice.innerHTML = notice.innerHTML.replace(/Return to shop/g, 'Return to homepage');
                }
                if (notice.innerHTML.includes('/shop/')) {
                    notice.innerHTML = notice.innerHTML.replace(/\/shop\//g, '/');
                }
            });
        });
        </script>
        <?php
    }
}
