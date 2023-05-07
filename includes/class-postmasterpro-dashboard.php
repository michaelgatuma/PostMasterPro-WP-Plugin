<?php

// includes/class-postmasterpro-dashboard.php

use JetBrains\PhpStorm\NoReturn;

class PostMasterPro_Dashboard {
	private $plugin_name;
	private $version;
	private $api;

	public function __construct( $version ) {
		$this->plugin_name = 'postmasterpro';
		$this->version     = $version;
		$this->api         = new PostMasterPro_API();

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'admin_post_postmasterpro_enable_cron', array( $this, 'enable_cron' ) );
		add_action( 'admin_post_postmasterpro_disable_cron', array( $this, 'disable_cron' ) );
		add_action( 'wp_ajax_postmasterpro_save_token', array( $this, 'save_token' ) );
		add_action( 'wp_ajax_postmasterpro_logout', array( $this, 'logout' ) );
		add_action( 'wp_ajax_postmasterpro_publish_question', array( $this, 'publish_question' ) );
	}

	public function register_plugin_menu(): void {
		add_menu_page(
			'PostMaster-Pro Dashboard',
			'PostMaster Pro',
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_plugin_page' ),
			'dashicons-buddicons-replies'
		);
	}

	public function register_settings(): void {
		register_setting( $this->plugin_name, 'postmasterpro_options', array( $this, 'sanitize_options' ) );

		// Add sections and fields as needed
	}

	public function sanitize_options( $input ): array {
		$output = array();

		// Sanitize and validate input as needed

		return $output;
	}

	public function display_plugin_page(): void {
		// Check user capabilities
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Include the HTML template for the dashboard
		include_once plugin_dir_path( dirname( __FILE__ ) ) . 'templates/dashboard.php';
	}

	public function admin_enqueue_scripts(): void {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . '../assets/css/admin.css', array( 'tailwindcss' ), $this->version );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . '../assets/js/admin.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'alpinejs', 'https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js', array(), '2.x.x', true );
	}

	#[NoReturn] public function enable_cron(): void {
		update_option( 'postmasterpro_cron_status', 'enabled' );
		wp_redirect( admin_url( 'admin.php?page=' . $this->plugin_name . '&cron_status=enabled' ) );
		exit;
	}

	#[NoReturn] public function disable_cron(): void {
		update_option( 'postmasterpro_cron_status', 'disabled' );
		wp_redirect( admin_url( 'admin.php?page=' . $this->plugin_name . '&cron_status=disabled' ) );
		exit;
	}

	public function save_token(): void {
		check_ajax_referer( 'postmasterpro_save_token_nonce', '_ajax_nonce' );

		if ( ! empty( $_POST['token'] ) ) {
			update_option( 'postmasterpro_auth_token', sanitize_text_field( $_POST['token'] ) );
			wp_send_json_success( 'Token saved successfully.' );
		} else {
			wp_send_json_error( 'Error saving token.' );
		}
	}

	public function is_user_logged_in(): bool {
		$token = get_option( 'postmasterpro_auth_token' );

		return ! empty( $token );
	}

	public function logout(): void {
		check_ajax_referer( 'postmasterpro_logout_nonce', '_ajax_nonce' );
		delete_option( 'postmasterpro_auth_token' );
		wp_send_json_success( 'Logged out successfully.' );
	}

	public function publish_question(): void {
		check_ajax_referer( 'postmasterpro_publish_question_nonce', '_ajax_nonce' );

		if ( ! empty( $_POST['question'] ) ) {
			$question = json_decode( stripslashes( $_POST['question'] ) );

			$post_id = wp_insert_post( array(
				'post_title'   => sanitize_text_field( $question->title ),
				'post_content' => wp_kses_post( $question->body ),
				'post_status'  => 'publish',
				'post_author'  => 1, // TODO: Change this to the logged in user's ID
				'post_type'    => 'post',
			) );

			if ( $post_id ) {
				$this->set_post_category( $post_id, sanitize_text_field( $question->source_field_of_study ) );
				// Add custom meta data if needed
				update_post_meta( $post_id, 'budget', sanitize_text_field( $question->budget ) );
				update_post_meta( $post_id, 'currency', sanitize_text_field( $question->currency ) );
				update_post_meta( $post_id, 'source_field_of_study', sanitize_text_field( $question->source_field_of_study ) );
				update_post_meta( $post_id, 'source_created_at', sanitize_text_field( $question->source_created_at ) );
				update_post_meta( $post_id, 'published_by_postmasterpro', true );

				wp_send_json_success( 'Question published successfully.' );
			} else {
				wp_send_json_error( 'Error publishing question.' );
			}
		} else {
			wp_send_json_error( 'Error publishing question.' );
		}
	}

	public function get_published_posts(): WP_Query {
		$args = array(
			'post_type'  => 'post',
			'meta_query' => array(
				array(
					'key'     => 'published_by_postmasterpro',
					'value'   => true,
					'compare' => '=',
				),
			),
		);

		$query = new WP_Query( $args );
//		wp_reset_postdata(); // Reset the post data after the query is done.
		return $query;

	}

	private function set_post_category( int $post_id, string $category_name ): void {
		// Check if the category exists or create it
		$category = get_term_by( 'name', $category_name, 'category' );

		if ( ! $category ) {
			$new_category = wp_insert_term( $category_name, 'category' );

			if ( ! is_wp_error( $new_category ) ) {
				$category_id = $new_category['term_id'];
			} else {
				return;
			}
		} else {
			$category_id = $category->term_id;
		}

		// Assign the category to the post
		wp_set_post_terms( $post_id, $category_id, 'category' );
	}
}
