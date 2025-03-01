<?php

namespace ArtistudioPopup;

require_once plugin_dir_path(__FILE__) . 'trait-singleton.php';

class PopupRestAPI
{
	use Singleton;

	protected function init()
	{
		// Modify the REST API response for the 'popup' post type
		add_filter('rest_prepare_popup', [$this, 'modify_popup_rest_api'], 10, 3);
		// Register custom REST API routes for the popup
		add_action('rest_api_init', [$this, 'register_popup_routes']);
	}

	// Modify REST API to Include Page Field
	public function modify_popup_rest_api($data, $post, $request)
	{
		$data->data['page'] = get_post_meta($post->ID, '_popup_page', true);
		return $data;
	}

	// Register Routes
	public function register_popup_routes()
	{
		register_rest_route('artistudio/v1', '/popups', array(
			'methods' => 'GET',
			'callback' => [$this, 'get_popups_by_page'],
			// 'permission_callback' => [$this, 'check_permissions'],
		));

		register_rest_route('artistudio/v1', '/latest', array(
			'methods' => 'GET',
			'callback' => [$this, 'get_latest_popup'],
			// 'permission_callback' => [$this, 'check_permissions'],
		));
	}

	// Allow only logged-in users (any role)
	public function check_permissions()
	{
		error_log('Current User ID: ' . get_current_user_id());
		error_log('Is User Logged In: ' . (is_user_logged_in() ? 'Yes' : 'No'));
		error_log('User Roles: ' . print_r(wp_get_current_user()->roles, true));

		if (is_user_logged_in()) {
			return true;
		}

		return new \WP_Error(
			'rest_forbidden',
			__('You must be logged in to access this endpoint.', 'popup-api'),
			array('status' => 401)
		);
	}

	// Fetch Popups by Page ID
	public function get_popups_by_page(\WP_REST_Request $request)
	{
		$page_id = $request->get_param('page_id');

		// Check if home or front page
		if (empty($page_id)) {
			if (is_front_page() || is_home()) {
				$page_id = 'home';
			}
		}

		$args = array(
			'post_type' => 'popup',
			'posts_per_page' => -1,
			'meta_query' => array('relation' => 'OR'),
		);

		if (!empty($page_id) && is_numeric($page_id)) {
			$args['meta_query'][] = array(
				'key' => '_popup_page',
				'value' => $page_id,
				'compare' => '='
			);
		}

		// Include popups available for all pages (empty '_popup_page')
		$args['meta_query'][] = array(
			'key' => '_popup_page',
			'compare' => 'NOT EXISTS'
		);

		// Also include popups where '_popup_page' is empty (stored as an empty string)
		$args['meta_query'][] = array(
			'key' => '_popup_page',
			'value' => '',
			'compare' => '='
		);

		$query = new \WP_Query($args);
		$popups = array();

		while ($query->have_posts()) {
			$query->the_post();

			$popups[] = array(
				'title' => get_the_title(),
				'description' => wp_kses_post(get_the_content()), // Safe HTML output
				'page' => get_post_meta(get_the_ID(), '_popup_page', true),
			);
		}
		wp_reset_postdata(); // Reset post data

		return new \WP_REST_Response($popups, 200);
	}

	// Fetch Latest Popup
	public function get_latest_popup()
	{
		$args = array(
			'post_type' => 'popup',
			'posts_per_page' => 1,
			'orderby' => 'date',
			'order' => 'DESC',
		);
		$query = new \WP_Query($args);

		if ($query->have_posts()) {
			$query->the_post();
			return new \WP_REST_Response(array(
				'title' => get_the_title(),
				'description' => wp_strip_all_tags(get_the_content()), // Clean description
			), 200);
		}

		return new \WP_REST_Response(array('message' => 'No popups found'), 404);
	}
}
