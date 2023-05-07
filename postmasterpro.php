<?php
/**
 * Plugin Name: PostMaster Pro
 * Plugin URI: https://gatuma.me/postmasterpro
 * Description: Fetches and publishes posts from an external API.
 * Version: 1.0.0
 * Author: Michael Gatuma
 * Author URI: https://gatuma.me
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: postmasterpro
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

// Register Tailwind CSS CDN
function postmasterpro_enqueue_styles(): void {
	wp_enqueue_style('tailwindcss', 'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css', array(), '2.2.16');
}
add_action('admin_enqueue_scripts', 'postmasterpro_enqueue_styles');

// Include plugin classes
require_once plugin_dir_path(__FILE__) . 'includes/class-postmasterpro.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-postmasterpro-api.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-postmasterpro-cron.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-postmasterpro-dashboard.php';

// Initialize the plugin
function run_postmasterpro(): void {
	$plugin = new PostMasterPro();
	$plugin->run();

	$dashboard = new PostMasterPro_Dashboard('1.0');
//	$posts=$dashboard->get_published_posts();
//	$posts->post_count

	// Initialize the PostMasterPro_Cron class
	$cron = new PostMasterPro_Cron();
}
run_postmasterpro();
