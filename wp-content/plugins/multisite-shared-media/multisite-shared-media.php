<?php
/**
 * Plugin Name: Multisite Shared Media
 * Description: Synchronise uploaded media to other network sites instantly without duplicating the file itself. Save disk space and publish faster.
 * Author: Aikadesign Oy
 * Author URI: https://www.aikadesign.fi/
 * Plugin URI: https://codecanyon.net/item/wordpress-multisite-shared-media/19306250
 * Version: 1.3.1
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version.
 * @see SemVer - https://semver.org
 */
define( 'MSM_PLUGIN_VERSION', '1.3.1' );

/**
 * Path to plugin's root directory
 */
define( 'MSM_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

/**
 * URL to plugin's root
 */
define( 'MSM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * The plugin controller class.
 */
require_once MSM_PLUGIN_PATH . 'includes/class-multisite-shared-media-controller.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 */
function msm_run() {
	$msm = new MSMController();
	$msm->run();
}

msm_run();