<?php

/**
 * Plugin Name:       YWIG Club Contact Taxonomy
 * Version:           1.0.0
 * Author:            MOH
 * License:           GPL v2 or later
 *
 * TODO Something is wrong when creating a contact. It creates but thing spins forever
 */


function ywig_setup_club_contact_taxonomy() {
	add_action( 'init', 'ywig_register_club_contact_taxonomy' );
	// add_action( 'club_contact_add_form_fields', 'ywig_add_club_contact_social_meta' );
	// add_action( 'club_contact_edit_form_fields', 'ywig_edit_club_contact_social_meta' );
	// add_action( 'create_club_contact', 'ywig_save_club_contact_social_meta' );
	// add_action( 'edit_club_contact', 'ywig_save_club_contact_social_meta' );
}
ywig_setup_club_contact_taxonomy();

function ywig_register_club_contact_taxonomy() {
	$labels = array(
		'name'              => _x( 'Club Contact', 'taxonomy general name', 'text-domain' ),
		'singular_name'     => _x( 'Club Contact', 'taxonomy singular name', 'text-domain' ),
		'search_items'      => __( 'Search Club Contacts', 'text-domain' ),
		'all_items'         => __( 'All Club Contacts', 'text-domain' ),
		'parent_item'       => __( 'Parent Club Contact', 'text-domain' ),
		'parent_item_colon' => __( 'Parent Club Contact:', 'text-domain' ),
		'edit_item'         => __( 'Edit Club Contact', 'text-domain' ),
		'update_item'       => __( 'Update Club Contact', 'text-domain' ),
		'add_new_item'      => __( 'Add New Club Contact', 'text-domain' ),
		'new_item_name'     => __( 'New Club Contact Name', 'text-domain' ),
		'menu_name'         => __( 'Club Contact', 'text-domain' ),
	);

	register_taxonomy(
		'club_contact',
		'youthclub',
		array(
			'labels'       => $labels,
			'public'       => true,
			'show_in_rest' => true,
		)
	);
}


