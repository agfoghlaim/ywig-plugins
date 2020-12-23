<?php

/**
 * Plugin Name:       YWIG Resource Taxonomy ACF
 * Version:           1.0.0
 * Author:            MOH
 * License:           GPL v2 or later
 */

// Uses ACF
// function ev_unregister_taxonomy(){
// 	register_taxonomy('post_tag', array());
// }

function ywig_unregister_resource_taxonomy(){
	global $wp_taxonomies;
	$taxonomy = 'resource';
	if ( taxonomy_exists( $taxonomy))
	unset( $wp_taxonomies[$taxonomy]);
}
add_action('init', 'ywig_unregister_resource_taxonomy');

function ywig_setup_resource_taxonomy() {
	add_action( 'init', 'ywig_register_resource_taxonomy' );
}
ywig_setup_resource_taxonomy();

function ywig_register_resource_taxonomy() {
	$labels = array(
		'name'              => _x( 'Resource', 'taxonomy general name', 'text-domain' ),
		'singular_name'     => _x( 'Resource', 'taxonomy singular name', 'text-domain' ),
		'search_items'      => __( 'Search Resources', 'text-domain' ),
		'all_items'         => __( 'All Resources', 'text-domain' ),
		'parent_item'       => __( 'Parent Resource', 'text-domain' ),
		'parent_item_colon' => __( 'Parent Resource:', 'text-domain' ),
		'edit_item'         => __( 'Edit Resource', 'text-domain' ),
		'update_item'       => __( 'Update Resource', 'text-domain' ),
		'add_new_item'      => __( 'Add New Resource', 'text-domain' ),
		'new_item_name'     => __( 'New Resource Name', 'text-domain' ),
		'menu_name'         => __( 'Resource', 'text-domain' ),

	);

	register_taxonomy(
		'resource',
		'attachment',
		array(
			'labels'       => $labels,
			'public'       => true,
			'show_in_rest' => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'update_count_callback' 	=> '_update_generic_term_count'
		)
	);
}

// interested in the counts of unattached Media items, than in those attached to posts. In this case, you should force the use of _update_generic_term_count() by setting ‘_update_generic_term_count’ as the value for update_count_callback.


