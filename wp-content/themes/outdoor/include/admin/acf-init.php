<?php
/***************************************************************************************
 * Main settings for the ACF plugin
 **************************************************************************************/
// Change path to the plugin
function outdoor_acf_settings_path( $path ) {
    $path = OUTDOOR_INC_DIR . '/admin/acf/';
    return $path;
}
add_filter('acf/settings/path', 'outdoor_acf_settings_path');

// Change dir to the plugin
function outdoor_acf_settings_dir( $dir ) {
    $dir = OUTDOOR_TPL_URI . '/include/admin/acf/';
    return $dir;
}
add_filter('acf/settings/dir', 'outdoor_acf_settings_dir');

// Hide ACF field group menu item
add_filter('acf/settings/show_admin', '__return_false');

// Include settings a custom fields
require_once( OUTDOOR_INC_DIR . '/admin/acf-fields.php' );