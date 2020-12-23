<?php

/**
 * Plugin Name:       YWIG Staff Taxonomy ACF
 * Version:           1.0.0
 * Author:            MOH
 * License:           GPL v2 or later
 */

// Uses ACF
// function ev_unregister_taxonomy(){
// 	register_taxonomy('post_tag', array());
// }
// add_action('init', 'ev_unregister_taxonomy');

function ywig_unregister_taxonomy(){
    global $wp_taxonomies;
    $taxonomy = 'staff';
    if ( taxonomy_exists( $taxonomy))
        unset( $wp_taxonomies[$taxonomy]);
}
function ywig_setup_staff_taxonomy() {
	add_action( 'init', 'ywig_register_staff_taxonomy' );
}
ywig_setup_staff_taxonomy();

function ywig_register_staff_taxonomy() {
	$labels = array(
		'name'              => _x( 'Staff Member', 'taxonomy general name', 'text-domain' ),
		'singular_name'     => _x( 'Staff', 'taxonomy singular name', 'text-domain' ),
		'search_items'      => __( 'Search Staff Members', 'text-domain' ),
		'all_items'         => __( 'All Staff Members', 'text-domain' ),
		'parent_item'       => __( 'Parent Staff', 'text-domain' ),
		'parent_item_colon' => __( 'Parent Staff:', 'text-domain' ),
		'edit_item'         => __( 'Edit Staff', 'text-domain' ),
		'update_item'       => __( 'Update Staff', 'text-domain' ),
		'add_new_item'      => __( 'Add New Staff Member', 'text-domain' ),
		'new_item_name'     => __( 'New Staff Member Name', 'text-domain' ),
		'menu_name'         => __( 'Staff', 'text-domain' ),

	);

	register_taxonomy(
		'staff',
		'project',
		array(
			'labels'       => $labels,
			'public'       => true,
			'show_in_rest' => true,
		)
	);
}




