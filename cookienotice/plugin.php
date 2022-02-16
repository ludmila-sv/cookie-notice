<?php
/**
 * Cookie Notice
 *
 * @package       COOKIENOTICE
 * @author        Ludmila Sviridova
 * @version       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:   Cookie Notice
 * Plugin URI:    https://pressfoundry.com
 * Description:   Shows a custom exit notice when a user clicks an external link.
 * Version:       1.0.0
 * Author:        Ludmila Sviridova
 * Text Domain:   exit-notice
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Plugin name
define( 'COOKIENOTICE_NAME', 'Cookie Notice' );

// Plugin version
define( 'COOKIENOTICE_VERSION', '1.0.0' );

// Plugin Root File
define( 'COOKIENOTICE_PLUGIN_FILE', __FILE__ );

// Plugin Folder Path
define( 'COOKIENOTICE_PLUGIN_DIR', plugin_dir_path( COOKIENOTICE_PLUGIN_FILE ) );

// Plugin Folder URL
define( 'COOKIENOTICE_PLUGIN_URL', plugin_dir_url( COOKIENOTICE_PLUGIN_FILE ) );

/**
 * Load the main class for the core functionality
 */
require_once COOKIENOTICE_PLUGIN_DIR . 'classes/class-cookie-notice.php';

Cookie_Notice::init();
