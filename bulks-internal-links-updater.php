<?php
/**
 * Plugin Name: Bulks Internal Links Updater
 * Plugin URI: https://wordpress.org/plugins/bulks-internal-links-updater
 * Description: Bulks internal Links updater is a plugin to update internal link automaticly, support update use excel file.
 * Author: Mbulet Studio
 * Author URI: https://mbuletstudio.com/
 * Version: 1.0
 * Text Domain: bulk-internal-links-updater
 * Domain Path: /languages
 * License: GPL v2 - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Define constants
 *
 * @since 1.0
 */
if ( ! defined( 'MBULET_ILU_VERSION_NUM' ) ) 	define( 'MBULET_ILU_VERSION_NUM', '1.0' );
if ( ! defined( 'MBULET_ILU_PLUGIN_NAME' ) )	define( 'MBULET_ILU_PLUGIN_NAME', trim( dirname( plugin_basename( __FILE__ ) ), '/' ) );
if ( ! defined( 'MBULET_ILU_PLUGIN_DIR' ) )		define( 'MBULET_ILU_PLUGIN_DIR'	, plugin_dir_path( __FILE__ ) );
if ( ! defined( 'MBULET_ILU_PLUGIN_URL' ) )		define( 'MBULET_ILU_PLUGIN_URL'	, plugin_dir_url( __FILE__ ) );

/**
 * Database version upgrade
 *
 * @since 1.0
*/
function plugin_version_upgrader() {
	
	$current_ver = get_option( 'mbulet_ilu_plugin_version', '0.0' );
	if ( version_compare( $current_ver, MBULET_ILU_VERSION_NUM, '==' ) ) {
		return;
	} 
	update_option( 'mbulet_ilu_plugin_version', MBULET_ILU_VERSION_NUM );
}
add_action( 'admin_init', 'plugin_version_upgrader' );

/** 
 * Load all plugin files
 * 
 * @since v1.0
*/
require_once( MBULET_ILU_PLUGIN_DIR . 'loader.php' );