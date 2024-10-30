<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/** 
 * Register activation hook (this has to be in the main plugin file or refer bit.ly/2qMbn2O)
 * 
 * @since v1.0
*/ 
function mbulet_ilu_activate_plugin() {
	
}
register_activation_hook( __FILE__, 'mbulet_ilu_activate_plugin' );

/** 
 * Admin init enqueue scripts
 * 
 * @since v1.0
*/
function mbulet_ilu_enqueue_scripts() {
    $scripts = array(

        // CSS files
        'font_preconnect' => array(
            'file' => 'https://fonts.googleapis.com',
            'dependencies' => [],
            'version' => null,
            'media' => 'all',
            'type' => 'css'
        ),
        'font_preconnect_crossorigin' => array(
            'file' => 'https://fonts.gstatic.com',
            'dependencies' => [],
            'version' => null,
            'media' => 'all',
            'type' => 'css'
        ),
        'font' => array(
            'file' => 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap',
            'dependencies' => [],
            'version' => null,
            'media' => 'all',
            'type' => 'css'
        ),
        'mbulet_ilu_taost_css' => array(
            'file' => MBULET_ILU_PLUGIN_URL . 'dist/vendors/toast/toast.style.min.css',
            'dependencies' => [],
            'version' => null,
            'media' => 'all',
            'type' => 'css'
        ),
        'mbulet_ilu_select2_css' => array(
            'file' => MBULET_ILU_PLUGIN_URL . 'dist/vendors/select2/css/select2.min.css',
            'dependencies' => [],
            'version' => null,
            'media' => 'all',
            'type' => 'css'
        ),
        'mbulet_ilu_admin_menu_css' => array(
            'file' => MBULET_ILU_PLUGIN_URL . 'dist/css/menu.css',
            'dependencies' => [],
            'version' => null,
            'media' => 'all',
            'type' => 'css'
        ),
        'mbulet_ilu_pages_css' => array(
            'file' => MBULET_ILU_PLUGIN_URL . 'dist/css/pages.css',
            'dependencies' => [],
            'version' => null,
            'media' => 'all',
            'type' => 'css'
        ),
        'mbulet_ilu_grid_css' => array(
            'file' => MBULET_ILU_PLUGIN_URL . 'dist/css/grid.css',
            'dependencies' => [],
            'version' => null,
            'media' => 'all',
            'type' => 'css'
        ),
        'mbulet_ilu_form_css' => array(
            'file' => MBULET_ILU_PLUGIN_URL . 'dist/css/form.css',
            'dependencies' => [],
            'version' => null,
            'media' => 'all',
            'type' => 'css'
        ),
        'mbulet_ilu_select2_core_css' => array(
            'file' => MBULET_ILU_PLUGIN_URL . 'dist/css/select2.css',
            'dependencies' => [],
            'version' => null,
            'media' => 'all',
            'type' => 'css'
        ),
        'mbulet_ilu_loader' => array(
            'file' => MBULET_ILU_PLUGIN_URL . 'dist/css/loader.css',
            'dependencies' => [],
            'version' => null,
            'media' => 'all',
            'type' => 'css'
        ),

        // JS files
        'mbulet_ilu_jquery' => array(
            'file' => MBULET_ILU_PLUGIN_URL . 'dist/vendors/jquery/jquery.min.js',
            'dependencies' => [],
            'version' => null,
            'in_footer' => false,
            'type' => 'js'
        ),
        'mbulet_ilu_toast_js' => array(
            'file' => MBULET_ILU_PLUGIN_URL . 'dist/vendors/toast/toast.script.js',
            'dependencies' => ['jquery'],
            'version' => null,
            'in_footer' => true,
            'type' => 'js'
        ),
        'mbulet_ilu_select2_js' => array(
            'file' => MBULET_ILU_PLUGIN_URL . 'dist/vendors/select2/js/select2.min.js',
            'dependencies' => ['jquery'],
            'version' => null,
            'in_footer' => false,
            'type' => 'js'
        ),
        'mbulet_ilu_xlsx_js' => array(
            'file' => MBULET_ILU_PLUGIN_URL . 'dist/vendors/xlsx/xlsx.min.js',
            'dependencies' => ['jquery'],
            'version' => null,
            'in_footer' => false,
            'type' => 'js'
        ),
        'mbulet_ilu_xls_js' => array(
            'file' => MBULET_ILU_PLUGIN_URL . 'dist/vendors/xlsx/xls.min.js',
            'dependencies' => ['jquery'],
            'version' => null,
            'in_footer' => false,
            'type' => 'js'
        ),
        'mbulet_ilu_function_js' => array(
            'file' => MBULET_ILU_PLUGIN_URL . 'dist/js/functions.js',
            'dependencies' => ['jquery'],
            'version' => null,
            'in_footer' => false,
            'type' => 'js'
        ),
        'mbulet_ilu_core_js' => array(
            'file' => MBULET_ILU_PLUGIN_URL . 'dist/js/main.js',
            'dependencies' => ['jquery'],
            'version' => null,
            'in_footer' => false,
            'type' => 'js'
        )
    );

    foreach ($scripts as $key => $script) {
        if( $script['type'] == "css" ) {
            wp_enqueue_style( $key, $script['file'], $script['dependencies'], $script['version'], $script['media'] );
        }
        else if( $script['type'] == "js" ) {
            wp_enqueue_script( $key, $script['file'], $script['dependencies'], $script['version'], $script['in_footer'] );
        }
    }

}
add_action( 'admin_init', 'mbulet_ilu_enqueue_scripts' );

/** 
 * Preload font style
 * 
 * @since v1.0
*/
add_filter( 'style_loader_tag',  'mbulet_ilu_preload_filter', 10, 2 );
function mbulet_ilu_preload_filter( $html, $handle ){
    if (strcmp($handle, 'font_preconnect') == 0) {
        $html = str_replace("rel='stylesheet'", "rel='preconnect' ", $html);
    }
    if (strcmp($handle, 'font_preconnect_crossorigin') == 0) {
        $html = str_replace("rel='stylesheet'", "rel='preconnect' crossorigin ", $html);
    }
    return $html;
}


/**
 * Load plugin text domain
 *
 * @since 1.0
 */
function mbulet_ilu_load_plugin_textdomain() {
    load_plugin_textdomain( MBULET_ILU_PLUGIN_NAME, false, '/' . MBULET_ILU_PLUGIN_NAME . '\/languages/' );
}
add_action( 'plugins_loaded', 'mbulet_ilu_load_plugin_textdomain' );

/** 
 * Add theme option menu
 * 
 * @since v1.0
*/
function mbulet_ilu_register_menu() {
    if( is_user_logged_in() ) {
        $user = wp_get_current_user();
        $roles = ( array ) $user->roles;
        
        $role = "administrator";
        if( in_array("administrator", $roles) ) {
            $role = "administrator";
        }
        elseif( in_array("editor", $roles) ) {
            $role = "editor";
        }

        add_menu_page( 
            'Bulks Internal Links Updater', 
            'Bulks Internal Links Updater', 
            $role, 
            'bulks_internal_links_updater', 
            'mbulet_ilu_internal_links_updater_callback',
            MBULET_ILU_PLUGIN_URL . "dist/images/logo.png" 
        );
    }
}
function mbulet_ilu_internal_links_updater_callback() { 
    require_once MBULET_ILU_PLUGIN_DIR . "admin/views/menu.php";
}
add_action('admin_menu', 'mbulet_ilu_register_menu');

/** 
 * Manual update content action
 * 
 * @since v1.0
*/
function render_mbulet_ilu_update_manual_content() {
    require_once MBULET_ILU_PLUGIN_DIR . "admin/views/menu_new-updates_manual.php";
}
add_action('mbulet_ilu_update_manual_content', "render_mbulet_ilu_update_manual_content");

/** 
 * excel update content action
 * 
 * @since v1.0
*/
function render_mbulet_ilu_update_excel_content() {
    require_once MBULET_ILU_PLUGIN_DIR . "admin/views/menu_new-updates_excel.php";
}
add_action('mbulet_ilu_update_excel_content', "render_mbulet_ilu_update_excel_content");