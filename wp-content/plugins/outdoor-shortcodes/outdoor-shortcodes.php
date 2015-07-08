<?php
/*
Plugin Name: OUTDOOR - shortcodes
Plugin URI:
Description: Register shortcodes for OUTDOOR theme
Author: InfoStyle
Author URI: http://themeforest.net/user/InfoStyle
Version: 1.0.0
*/

define( 'OD_SHORTCODES_PATH', dirname( __FILE__ ) );

// Include files
require_once( OD_SHORTCODES_PATH . '/shortcodes.php');

function outdoor_shortcodes_init() {

    // Load plugin textdomain.
    load_plugin_textdomain( 'outdoor', false, OD_SHORTCODES_PATH . '/languages/' );

}
add_action( 'init', 'outdoor_shortcodes_init' );