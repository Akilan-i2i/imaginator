<?php

// Include subscribers functions
require_once( OUTDOOR_INC_DIR . '/admin/subscribers.php' );

/***************************************************************************************
 * Enqueue styles and scripts
 **************************************************************************************/
function outdoor_admin_enqueue_scripts() {
    /*
     * JavaScripts
     */

    // Outdoor main script
    wp_enqueue_script( 'outdoor-admin-js', OUTDOOR_ASSETS_URI . '/admin/js/admin.js' );
    $outdoor_globals_js = array(
        'theme_url' => OUTDOOR_TPL_URI
    );
    wp_localize_script( 'outdoor-admin-js', 'outdoor', $outdoor_globals_js );

    /*
     * Stylesheets
     */

    // Outdoor main styles
    wp_enqueue_style( 'outdoor-admin-styles', OUTDOOR_ASSETS_URI . '/admin/css/admin.css' );

}
add_action( 'admin_enqueue_scripts', 'outdoor_admin_enqueue_scripts' );

/***************************************************************************************
 * Load the Redux framework
 **************************************************************************************/
// Load the TGM init if it exists
if ( file_exists( dirname(__FILE__) . '/tgm/tgm-init.php') ) {
    require_once( dirname(__FILE__) . '/tgm/tgm-init.php' );
}
// Load Redux extensions - MUST be loaded before your options are set
if ( file_exists( dirname(__FILE__) . '/redux-extensions/extensions-init.php') ) {
    require_once( dirname(__FILE__) . '/redux-extensions/extensions-init.php' );
}    
// Load the embedded Redux Framework
if ( file_exists( dirname(__FILE__) . '/redux-framework/ReduxCore/framework.php') ) {
    require_once( dirname(__FILE__) . '/redux-framework/ReduxCore/framework.php' );
}
// Load the theme/plugin options
if ( file_exists( dirname(__FILE__) . '/options-init.php') ) {
    require_once( dirname(__FILE__) . '/options-init.php' );
}

// Change description for the import/export section
add_filter( 'redux-backup-description', function( $desc ){
    return __( 'Here you can copy/download your current options settings. They can be also used as a backup, and if
    anything goes wrong on the site, you can use them to restore your settings.', 'outdoor' );
});

// Remove redux about page
function outdoor_remove_redux_about_page(){
    remove_submenu_page( 'tools.php', 'redux-about' );
}
add_action( 'admin_menu', 'outdoor_remove_redux_about_page' );
/***************************************************************************************
 * Load the ACF plugin
 **************************************************************************************/
if( file_exists( OUTDOOR_INC_DIR . '/admin/acf/acf.php' ) ) {
    require_once( OUTDOOR_INC_DIR . '/admin/acf/acf.php' );
}

if( file_exists( OUTDOOR_INC_DIR . '/admin/acf-init.php' ) ) {
    require_once( OUTDOOR_INC_DIR . '/admin/acf-init.php' );
}