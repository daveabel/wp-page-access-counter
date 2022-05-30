<?php

/**
 * Registers the `region` post type.
 */
function region_init() {
	register_post_type(
		'region',
		[
			'labels'                => [
				'name'                  => __( 'Regions', 'wp-page-access-counter' ),
				'singular_name'         => __( 'Region', 'wp-page-access-counter' ),
				'all_items'             => __( 'All Regions', 'wp-page-access-counter' ),
				'archives'              => __( 'Region Archives', 'wp-page-access-counter' ),
				'attributes'            => __( 'Region Attributes', 'wp-page-access-counter' ),
				'insert_into_item'      => __( 'Insert into region', 'wp-page-access-counter' ),
				'uploaded_to_this_item' => __( 'Uploaded to this region', 'wp-page-access-counter' ),
				'featured_image'        => _x( 'Featured Image', 'region', 'wp-page-access-counter' ),
				'set_featured_image'    => _x( 'Set featured image', 'region', 'wp-page-access-counter' ),
				'remove_featured_image' => _x( 'Remove featured image', 'region', 'wp-page-access-counter' ),
				'use_featured_image'    => _x( 'Use as featured image', 'region', 'wp-page-access-counter' ),
				'filter_items_list'     => __( 'Filter regions list', 'wp-page-access-counter' ),
				'items_list_navigation' => __( 'Regions list navigation', 'wp-page-access-counter' ),
				'items_list'            => __( 'Regions list', 'wp-page-access-counter' ),
				'new_item'              => __( 'New Region', 'wp-page-access-counter' ),
				'add_new'               => __( 'Add New', 'wp-page-access-counter' ),
				'add_new_item'          => __( 'Add New Region', 'wp-page-access-counter' ),
				'edit_item'             => __( 'Edit Region', 'wp-page-access-counter' ),
				'view_item'             => __( 'View Region', 'wp-page-access-counter' ),
				'view_items'            => __( 'View Regions', 'wp-page-access-counter' ),
				'search_items'          => __( 'Search regions', 'wp-page-access-counter' ),
				'not_found'             => __( 'No regions found', 'wp-page-access-counter' ),
				'not_found_in_trash'    => __( 'No regions found in trash', 'wp-page-access-counter' ),
				'parent_item_colon'     => __( 'Parent Region:', 'wp-page-access-counter' ),
				'menu_name'             => __( 'Regions', 'wp-page-access-counter' ),
			],
			'public'                => false,
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => [ 'title' ],
			'has_archive'           => true,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_position'         => null,
			'menu_icon'             => 'dashicons-admin-post',
			'show_in_rest'          => true,
			'rest_base'             => 'region',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		]
	);

}

add_action( 'init', 'region_init' );

/**
 * Sets the post updated messages for the `region` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `region` post type.
 */
function region_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['region'] = [
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Region updated. <a target="_blank" href="%s">View region</a>', 'wp-page-access-counter' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'wp-page-access-counter' ),
		3  => __( 'Custom field deleted.', 'wp-page-access-counter' ),
		4  => __( 'Region updated.', 'wp-page-access-counter' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Region restored to revision from %s', 'wp-page-access-counter' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Region published. <a href="%s">View region</a>', 'wp-page-access-counter' ), esc_url( $permalink ) ),
		7  => __( 'Region saved.', 'wp-page-access-counter' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Region submitted. <a target="_blank" href="%s">Preview region</a>', 'wp-page-access-counter' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Region scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview region</a>', 'wp-page-access-counter' ), date_i18n( __( 'M j, Y @ G:i', 'wp-page-access-counter' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Region draft updated. <a target="_blank" href="%s">Preview region</a>', 'wp-page-access-counter' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages', 'region_updated_messages' );

/**
 * Sets the bulk post updated messages for the `region` post type.
 *
 * @param  array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                              keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param  int[] $bulk_counts   Array of item counts for each message, used to build internationalized strings.
 * @return array Bulk messages for the `region` post type.
 */
function region_bulk_updated_messages( $bulk_messages, $bulk_counts ) {
	global $post;

	$bulk_messages['region'] = [
		/* translators: %s: Number of regions. */
		'updated'   => _n( '%s region updated.', '%s regions updated.', $bulk_counts['updated'], 'wp-page-access-counter' ),
		'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 region not updated, somebody is editing it.', 'wp-page-access-counter' ) :
						/* translators: %s: Number of regions. */
						_n( '%s region not updated, somebody is editing it.', '%s regions not updated, somebody is editing them.', $bulk_counts['locked'], 'wp-page-access-counter' ),
		/* translators: %s: Number of regions. */
		'deleted'   => _n( '%s region permanently deleted.', '%s regions permanently deleted.', $bulk_counts['deleted'], 'wp-page-access-counter' ),
		/* translators: %s: Number of regions. */
		'trashed'   => _n( '%s region moved to the Trash.', '%s regions moved to the Trash.', $bulk_counts['trashed'], 'wp-page-access-counter' ),
		/* translators: %s: Number of regions. */
		'untrashed' => _n( '%s region restored from the Trash.', '%s regions restored from the Trash.', $bulk_counts['untrashed'], 'wp-page-access-counter' ),
	];

	return $bulk_messages;
}

add_filter( 'bulk_post_updated_messages', 'region_bulk_updated_messages', 10, 2 );
