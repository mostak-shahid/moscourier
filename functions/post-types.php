<?php
//Layouts
add_action( 'init', 'moscourier_type_init' );
function moscourier_type_init() {
	$labels = array(
		'name'               => _x( 'Layouts', 'post type general name', 'excavator-template' ),
		'singular_name'      => _x( 'Layout', 'post type singular name', 'excavator-template' ),
		'menu_name'          => _x( 'Layouts', 'admin menu', 'excavator-template' ),
		'name_admin_bar'     => _x( 'Layout', 'add new on admin bar', 'excavator-template' ),
		'add_new'            => _x( 'Add New', 'layout', 'excavator-template' ),
		'add_new_item'       => __( 'Add New Layout', 'excavator-template' ),
		'new_item'           => __( 'New Layout', 'excavator-template' ),
		'edit_item'          => __( 'Edit Layout', 'excavator-template' ),
		'view_item'          => __( 'View Layout', 'excavator-template' ),
		'all_items'          => __( 'All Layouts', 'excavator-template' ),
		'search_items'       => __( 'Search Layouts', 'excavator-template' ),
		'parent_item_colon'  => __( 'Parent Layouts:', 'excavator-template' ),
		'not_found'          => __( 'No Layouts found.', 'excavator-template' ),
		'not_found_in_trash' => __( 'No Layouts found in Trash.', 'excavator-template' )
	);

	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Description.', 'excavator-template' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'layout' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 6,
		'menu_icon' => 'dashicons-welcome-widgets-menus',
		// 'supports'           => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
		'supports'           => array( 'title', 'editor'),
	);

	register_post_type( 'layout', $args );
}
add_action( 'after_switch_theme', 'flush_rewrite_rules' );
