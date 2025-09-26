<?php
/**
 * WooCommerce functions and shortcodes for lc-vyapparel2025.
 *
 * @package lc-vyapparel2025
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'woocommerce_checkout_fields', 'customize_billing_fields' );

add_filter( 'woocommerce_checkout_fields', 'customize_billing_fields' );

add_filter( 'woocommerce_checkout_is_block_checkout', '__return_false' );

// Disable WooCommerce Blocks scripts so gateways don't try to hook into them.
add_action(
    'enqueue_block_assets',
    function () {
        if ( is_checkout() ) {
            wp_dequeue_script( 'wc-stripe-blocks-integration' );
            wp_dequeue_script( 'wc-checkout-blocks' );
        }
    },
    20
);

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
    $fields['billing']['billing_state']['default']          = '';
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
