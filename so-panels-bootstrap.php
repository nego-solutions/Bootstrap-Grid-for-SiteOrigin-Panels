<?php
/*
Plugin Name: SO Panels Bootstrap
Plugin URI:  https://github.com/nego-solutions/Bootstrap-Grid-for-SiteOrigin-Panels
Description: Transform SiteOrigin Panels Grid to Bootstrap Grid
Version: 0.0.2-alpha
Author: Jantea Alexandru
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

class SO_Panels_Bootstrap {

	public function activate() {
		$this->check_dependencies();
		$this->define_constants();
		$this->load_includable_files();
	}

	/**
	 * Make sure Page Builder by SiteOrigin has been activated or else self-destruct
	 */
	private function check_dependencies() {
		// do nothing if class bbPress exists
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( !is_plugin_active( 'siteorigin-panels/siteorigin-panels.php' ) ) {
			trigger_error( 'This plugin requires <a href="https://wordpress.org/plugins/siteorigin-panels/">Page Builder by SiteOrigin</a>. Please install and activate Page Builder by SiteOrigin before activating this plugin.', E_USER_ERROR );
		}
	}

	public function bootstrap() {
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		add_action( 'plugins_loaded', array( $this, 'maybe_self_deactivate' ) );
	}

	/**
	 * If dependency requirements are not satisfied, self-deactivate
	 */
	public function maybe_self_deactivate() {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( !is_plugin_active( 'siteorigin-panels/siteorigin-panels.php' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			deactivate_plugins( plugin_basename( __FILE__ ) );
			add_action( 'admin_notices', array( $this, 'self_deactivate_notice' ) );
		}
	}

	/**
	 * Display an error message when the plugin deactivates itself.
	 */
	public function self_deactivate_notice() {
		echo '<div class="error"><p>SO Panles Bootstrap Plugin has deactivated itself because <a href="https://wordpress.org/plugins/siteorigin-panels/">Page Builder by SiteOrigin</a> is no longer active.</p></div>';
	}

	function load_includable_files() {
		//define('SO_PANELS_BOOTSTRAP_BASE_FILE', __FILE__);
		require_once plugin_dir_path(__FILE__) . 'includes/backend/hooks.php';
		require_once plugin_dir_path(__FILE__) . 'includes/backend/functions.php';
		require_once plugin_dir_path(__FILE__) . 'includes/frontend/hooks.php';
		require_once plugin_dir_path(__FILE__) . 'includes/frontend/functions.php';
	}

	function define_constants() {
		define('SO_PANELS_BOOTSTRAP_URL', plugin_dir_url(__FILE__));
	}

}

$so_panels_bootstrap = new SO_Panels_Bootstrap();
$so_panels_bootstrap->bootstrap();
