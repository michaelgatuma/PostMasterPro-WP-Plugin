<?php

// includes/class-postmasterpro-cron.php

class PostMasterPro_Cron {
	private $api;

	public function __construct() {
		$this->api = new PostMasterPro_API();
		$this->setup_cron();
	}

	private function setup_cron(): void {
		if ( ! wp_next_scheduled( 'postmasterpro_fetch_and_publish' ) ) {
			wp_schedule_event( time(), 'postmasterpro_custom_interval', 'postmasterpro_fetch_and_publish' );
		}
		add_filter( 'cron_schedules', array( $this, 'custom_cron_schedules' ) );
		add_action( 'postmasterpro_fetch_and_publish', array( $this, 'fetch_and_publish_post' ) );
	}

	public function custom_cron_schedules( $schedules ) {
		$schedules['postmasterpro_custom_interval'] = array(
			'interval' => 517, // Roughly 167 times a day
			'display'  => __( 'PostMasterPro Custom Interval' )
//			'interval' => 60,
//			'display'  => __( 'Every 60 Seconds' )
		);

		return $schedules;
	}

	public function fetch_and_publish_post(): void {
		if ( ! $this->should_execute_cron() ) {
			return;
		}
		$token = get_option('postmasterpro_auth_token');
		if (!$token) {
			return;
		}

		$question = $this->api->fetch_post($token);

		$post_id = wp_insert_post(array(
			'post_title' => sanitize_text_field($question->title),
			'post_content' => wp_kses_post($question->body),
			'post_status' => 'publish',
			'post_author'  => 1,
			'post_type' => 'post',
		));


		if ($post_id) {
			$this->set_post_category($post_id, sanitize_text_field($question->source_field_of_study));
			// Add custom meta data if needed
			update_post_meta($post_id, 'budget', sanitize_text_field($question->budget));
			update_post_meta($post_id, 'currency', sanitize_text_field($question->currency));
			update_post_meta($post_id, 'source_field_of_study', sanitize_text_field($question->source_field_of_study));
			update_post_meta($post_id, 'source_created_at', sanitize_text_field($question->source_created_at));
			update_post_meta($post_id, 'published_by_postmasterpro', true);

			wp_send_json_success('Question published successfully.');
			$this->log_cron_action('Question published successfully. Post ID: ' . $post_id);
		} else {
			wp_send_json_error('Error publishing question.');
			$this->log_cron_action('Error publishing question.');
		}
	}

	private function should_execute_cron(): bool {
		$limit=5005;
		$count_posts = wp_count_posts();
		$published_posts = $count_posts->publish;
		if ($published_posts<$limit){
			return true;
		}else{
			return false;
		}
		// Define your condition here
		// For example, you can check for a specific time or day
		$current_hour = date('G');

		// Run the cron job only if the current hour is between 9 AM and 5 PM
		if ($current_hour >= 9 && $current_hour <= 17) {
			return true;
		} else {
			return false;
		}
	}

	private function log_cron_action($message): void {
		$logfile = plugin_dir_path(__FILE__) . 'postmasterpro_cron.log';
		$timestamp = date('Y-m-d H:i:s');
		file_put_contents($logfile, '[' . $timestamp . '] ' . $message . PHP_EOL, FILE_APPEND);
	}

	private function set_post_category(int $post_id, string $category_name): void {
		// Check if the category exists or create it
		$category = get_term_by('name', $category_name, 'category');

		if (!$category) {
			$new_category = wp_insert_term($category_name, 'category');

			if (!is_wp_error($new_category)) {
				$category_id = $new_category['term_id'];
			} else {
				return;
			}
		} else {
			$category_id = $category->term_id;
		}

		// Assign the category to the post
		wp_set_post_terms($post_id, $category_id, 'category');
	}
}
