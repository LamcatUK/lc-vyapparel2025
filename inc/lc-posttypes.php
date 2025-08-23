<?php
/**
 * Custom Post Types Registration
 *
 * This file contains the code to register custom post types for the theme.
 *
 * @package lc-harrier2025
 */

/**
 * Register custom post types for the theme.
 *
 * This function registers a custom post type called 'people'.
 * The post type is set to be publicly queryable, has a UI in the admin,
 * and supports REST API.
 *
 * @return void
 */
function cb_register_post_types() {

	register_post_type(
		'testimonial',
		array(
			'labels'          => array(
				'name'               => 'Testimonials',
				'singular_name'      => 'Testimonial',
				'add_new_item'       => 'Add New Tetimonial',
				'edit_item'          => 'Edit Tetimonial',
				'new_item'           => 'New Tetimonial',
				'view_item'          => 'View Tetimonial',
				'search_items'       => 'Search Tetimonials',
				'not_found'          => 'No testimonials found',
				'not_found_in_trash' => 'No testimonials in trash',
			),
			'has_archive' 	  => true,
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => true,
			'show_in_rest'    => true,
			'menu_position'   => 25,
			'menu_icon'       => 'dashicons-feedback',
			'supports'        => array( 'title', 'editor' ),
			'capability_type' => 'post',
			'map_meta_cap'    => true,
			'rewrite'         => false,
		)
	);
}
// add_action( 'init', 'cb_register_post_types' );
