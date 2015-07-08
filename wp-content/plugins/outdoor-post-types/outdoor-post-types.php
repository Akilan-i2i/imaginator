<?php
/*
Plugin Name: OUTDOOR - post types
Plugin URI:
Description: Register custom post types for OUTDOOR theme
Author: InfoStyle
Author URI: http://themeforest.net/user/InfoStyle
Version: 1.0.0
*/

define( 'OD_CPT_PATH', dirname( __FILE__ ) );

// Include files
require_once( OD_CPT_PATH . '/post-types/cpt_client.php');
require_once( OD_CPT_PATH . '/post-types/cpt_portfolio.php');
require_once( OD_CPT_PATH . '/post-types/cpt_pricetable.php');
require_once( OD_CPT_PATH . '/post-types/cpt_quote.php');
require_once( OD_CPT_PATH . '/post-types/cpt_service.php');
require_once( OD_CPT_PATH . '/post-types/cpt_team.php');

function outdoor_cpt_init() {

    // Load plugin textdomain.
    load_plugin_textdomain( 'outdoor', false, OD_CPT_PATH . '/languages/' );

}
add_action( 'init', 'outdoor_cpt_init' );