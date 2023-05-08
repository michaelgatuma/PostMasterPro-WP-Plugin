<?php
// includes/class-postmasterpro.php

class PostMasterPro {
	protected $loader;
	protected $plugin_slug;
	protected $version;

	public function __construct() {
		$this->plugin_slug = 'postmasterpro';
		$this->version     = '1.0.0';
		$this->load_dependencies();
		$this->define_admin_hooks();
	}

	public static function activate(): void {
		add_option('postmasterpro_cron_status', 'disabled');
	}

	private function load_dependencies(): void {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-postmasterpro-api.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-postmasterpro-cron.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-postmasterpro-dashboard.php';
	}

	private function define_admin_hooks(): void {
		$admin = new PostMasterPro_Dashboard( $this->get_version() );
		add_action( 'admin_menu', array( $admin, 'register_plugin_menu' ) );
		add_action( 'admin_init', array( $admin, 'register_settings' ) );
	}

	public function run(): void {
		add_action( 'init', array( $this, 'init' ) );
	}

	public function init(): void {
		// Initialize the PostMasterPro_Cron class
		$this->loader = new PostMasterPro_Cron();
	}

	public function get_version(): string {
		return $this->version;
	}
}
