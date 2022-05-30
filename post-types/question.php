<?php

/**
 * Registers the `question` post type.
 */
function question_init() {
	register_post_type(
		'question',
		[
			'labels'                => [
				'name'                  => __( 'Questions', 'wp-page-access-counter' ),
				'singular_name'         => __( 'Question', 'wp-page-access-counter' ),
				'all_items'             => __( 'All Questions', 'wp-page-access-counter' ),
				'archives'              => __( 'Question Archives', 'wp-page-access-counter' ),
				'attributes'            => __( 'Question Attributes', 'wp-page-access-counter' ),
				'insert_into_item'      => __( 'Insert into question', 'wp-page-access-counter' ),
				'uploaded_to_this_item' => __( 'Uploaded to this question', 'wp-page-access-counter' ),
				'featured_image'        => _x( 'Featured Image', 'question', 'wp-page-access-counter' ),
				'set_featured_image'    => _x( 'Set featured image', 'question', 'wp-page-access-counter' ),
				'remove_featured_image' => _x( 'Remove featured image', 'question', 'wp-page-access-counter' ),
				'use_featured_image'    => _x( 'Use as featured image', 'question', 'wp-page-access-counter' ),
				'filter_items_list'     => __( 'Filter questions list', 'wp-page-access-counter' ),
				'items_list_navigation' => __( 'Questions list navigation', 'wp-page-access-counter' ),
				'items_list'            => __( 'Questions list', 'wp-page-access-counter' ),
				'new_item'              => __( 'New Question', 'wp-page-access-counter' ),
				'add_new'               => __( 'Add New', 'wp-page-access-counter' ),
				'add_new_item'          => __( 'Add New Question', 'wp-page-access-counter' ),
				'edit_item'             => __( 'Edit Question', 'wp-page-access-counter' ),
				'view_item'             => __( 'View Question', 'wp-page-access-counter' ),
				'view_items'            => __( 'View Questions', 'wp-page-access-counter' ),
				'search_items'          => __( 'Search questions', 'wp-page-access-counter' ),
				'not_found'             => __( 'No questions found', 'wp-page-access-counter' ),
				'not_found_in_trash'    => __( 'No questions found in trash', 'wp-page-access-counter' ),
				'parent_item_colon'     => __( 'Parent Question:', 'wp-page-access-counter' ),
				'menu_name'             => __( 'Questions', 'wp-page-access-counter' ),
			],
			'public'                => true,
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => [ 'title', 'editor' ],
			'has_archive'           => true,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_position'         => null,
			'menu_icon'             => 'dashicons-admin-post',
			'show_in_rest'          => true,
			'rest_base'             => 'question',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		]
	);

}

add_action( 'init', 'question_init' );

/**
 * Sets the post updated messages for the `question` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `question` post type.
 */
function question_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['question'] = [
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Question updated. <a target="_blank" href="%s">View question</a>', 'wp-page-access-counter' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'wp-page-access-counter' ),
		3  => __( 'Custom field deleted.', 'wp-page-access-counter' ),
		4  => __( 'Question updated.', 'wp-page-access-counter' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Question restored to revision from %s', 'wp-page-access-counter' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Question published. <a href="%s">View question</a>', 'wp-page-access-counter' ), esc_url( $permalink ) ),
		7  => __( 'Question saved.', 'wp-page-access-counter' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Question submitted. <a target="_blank" href="%s">Preview question</a>', 'wp-page-access-counter' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Question scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview question</a>', 'wp-page-access-counter' ), date_i18n( __( 'M j, Y @ G:i', 'wp-page-access-counter' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Question draft updated. <a target="_blank" href="%s">Preview question</a>', 'wp-page-access-counter' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages', 'question_updated_messages' );

/**
 * Sets the bulk post updated messages for the `question` post type.
 *
 * @param  array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                              keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param  int[] $bulk_counts   Array of item counts for each message, used to build internationalized strings.
 * @return array Bulk messages for the `question` post type.
 */
function question_bulk_updated_messages( $bulk_messages, $bulk_counts ) {
	global $post;

	$bulk_messages['question'] = [
		/* translators: %s: Number of questions. */
		'updated'   => _n( '%s question updated.', '%s questions updated.', $bulk_counts['updated'], 'wp-page-access-counter' ),
		'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 question not updated, somebody is editing it.', 'wp-page-access-counter' ) :
						/* translators: %s: Number of questions. */
						_n( '%s question not updated, somebody is editing it.', '%s questions not updated, somebody is editing them.', $bulk_counts['locked'], 'wp-page-access-counter' ),
		/* translators: %s: Number of questions. */
		'deleted'   => _n( '%s question permanently deleted.', '%s questions permanently deleted.', $bulk_counts['deleted'], 'wp-page-access-counter' ),
		/* translators: %s: Number of questions. */
		'trashed'   => _n( '%s question moved to the Trash.', '%s questions moved to the Trash.', $bulk_counts['trashed'], 'wp-page-access-counter' ),
		/* translators: %s: Number of questions. */
		'untrashed' => _n( '%s question restored from the Trash.', '%s questions restored from the Trash.', $bulk_counts['untrashed'], 'wp-page-access-counter' ),
	];

	return $bulk_messages;
}

add_filter( 'bulk_post_updated_messages', 'question_bulk_updated_messages', 10, 2 );
