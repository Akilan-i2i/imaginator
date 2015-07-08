<?php
/***************************************************************************************
 * Initialize variables and constants
 **************************************************************************************/
define( 'OUTDOOR_TPL_DIR', get_stylesheet_directory() );
define( 'OUTDOOR_TPL_URI', get_stylesheet_directory_uri() );
define( 'OUTDOOR_INC_DIR', OUTDOOR_TPL_DIR . '/include' );
define( 'OUTDOOR_ASSETS_URI', OUTDOOR_TPL_URI . '/assets' );

/***************************************************************************************
 * Include php files
 **************************************************************************************/
// Admin init
require_once( OUTDOOR_INC_DIR . '/admin/admin-init.php' );

require_once( OUTDOOR_INC_DIR . '/outdoor-init.php' );
require_once( OUTDOOR_INC_DIR . '/functions/global.php' );
require_once( OUTDOOR_INC_DIR . '/functions/theme.php' );

// Include required/recommended plugins
require_once( OUTDOOR_INC_DIR . '/plugins.php' );

// Include MailChimp api class
require_once( OUTDOOR_INC_DIR . '/api/MCAPI.class.php' );

// Ajax functions
require_once( OUTDOOR_INC_DIR . '/functions/ajax.php' );

/***************************************************************************************
 * Set the content width based on the theme's design and stylesheet.
 **************************************************************************************/
if ( ! isset( $content_width ) ) {
    $content_width = 610;
}

/***************************************************************************************
 * Enqueue styles and scripts
 **************************************************************************************/
function outdoor_enqueue_scripts() {
    global $outdoor_opt;

    /*
     * JavaScripts
     */

    if( is_front_page() && !is_home() ) {
        wp_enqueue_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false', array(), true, true );
    }

    if ( is_singular() && comments_open() && ( get_option('thread_comments') == 1 ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'raphael-min', 'http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js', array(), true, true );
    wp_enqueue_script( 'jsapi', 'https://www.google.com/jsapi', array(), true, true );
    wp_enqueue_script( 'jq-validate', OUTDOOR_ASSETS_URI . '/js/jquery.validate.min.js', array( 'jquery' ), true, true );
    wp_enqueue_script( 'bootstrap', OUTDOOR_ASSETS_URI . '/js/bootstrap.js', array( 'jquery' ), true, true );
    wp_enqueue_script( 'jq-validate', OUTDOOR_ASSETS_URI . '/js/bootstrap-tabcollapse.js', array( 'bootstrap' ), true, true );
    wp_enqueue_script( 'jquery-formstyler-min', OUTDOOR_ASSETS_URI . '/js/jquery.formstyler.min.js', array( 'jquery' ), true, true );
    wp_enqueue_script( 'jquery-caroufredsel', OUTDOOR_ASSETS_URI . '/js/jquery.carouFredSel-6.2.1-packed.js', array( 'jquery' ), true, true );
    wp_enqueue_script( 'jquery-touchwipe', OUTDOOR_ASSETS_URI . '/js/jquery.touchwipe.min.js', array( 'jquery' ), true, true );
    wp_enqueue_script( 'isotope-min', OUTDOOR_ASSETS_URI . '/js/isotope.pkgd.min.js', array(), true, true );
    wp_enqueue_script( 'getshar-min', OUTDOOR_ASSETS_URI . '/js/getshar-0.8.0.min.js', array(), true, true );
    wp_enqueue_script( 'imagesloaded-min', OUTDOOR_ASSETS_URI . '/js/imagesloaded.pkgd.min.js', array(), true, true );
    wp_enqueue_script( 'responsiveslides', OUTDOOR_ASSETS_URI . '/js/responsiveslides/responsiveslides.js', array(), true, true );
    wp_enqueue_script( 'jquery-fancybox', OUTDOOR_ASSETS_URI . '/js/fancybox/source/jquery.fancybox.js', array( 'jquery' ), true, true );
    wp_enqueue_script( 'easy-circle-skill', OUTDOOR_ASSETS_URI . '/js/easy-circle-skill.js', array(), true, true );
    wp_enqueue_script( 'blur', OUTDOOR_ASSETS_URI . '/js/blur.js', array(), true, true );
    wp_enqueue_script( 'jquery-easing', OUTDOOR_ASSETS_URI . '/js/jquery.easing.1.3.js', array( 'jquery' ), true, true );
    wp_enqueue_script( 'jquery-appear', OUTDOOR_ASSETS_URI . '/js/jquery.appear.js', array( 'jquery' ), true, true );
    wp_enqueue_script( 'jquery-mcustom-scrollbar', OUTDOOR_ASSETS_URI . '/js/jquery.mCustomScrollbar.js', array( 'jquery' ), true, true );
    wp_enqueue_script( 'dzsparallaxer', OUTDOOR_ASSETS_URI . '/js/dzsparallaxer.js', array(), true, true );
    wp_enqueue_script( 'tween-max', OUTDOOR_ASSETS_URI . '/js/TweenMax.min.js', array(), true, true );
    wp_enqueue_script( 'scroll-to-plugin-min', OUTDOOR_ASSETS_URI . '/js/ScrollToPlugin.min.js', array(), true, true );
    wp_enqueue_script( 'nice-scroll', OUTDOOR_ASSETS_URI . '/js/jquery.nicescroll.min.js', array( 'jquery' ), true, true );

    // Outdoor main script
    wp_enqueue_script( 'outdoor-main-js', OUTDOOR_ASSETS_URI . '/js/main.js', array( 'jquery' ), true, true );

    // Add inline js settings
    $map_marker = ( isset( $outdoor_opt['od-map-marker'] ) ) ? $outdoor_opt['od-map-marker'] : '';
    $map_coords = ( isset( $outdoor_opt['od-map-coordinates'] ) ) ? $outdoor_opt['od-map-coordinates'] : '';
    $map_coords = ( $map_coords ) ? explode( ',', $map_coords ) : '';
    $outdoor_globals_js = array(
        'ajax_url'          => admin_url( 'admin-ajax.php' ),
        'map_lat'           => $map_coords[0],
        'map_lng'           => $map_coords[1],
        'map_marker_url'    => $map_marker
    );
    wp_localize_script( 'outdoor-main-js', 'outdoor', $outdoor_globals_js );

    // Custom script
    wp_enqueue_script( 'outdoor-custom-js', OUTDOOR_TPL_URI . '/custom.js', array( 'jquery' ), true, true );

    /*
     * Stylesheets
     */

    // Wordpress default styles
    wp_enqueue_style( 'wordpress-default', OUTDOOR_ASSETS_URI . '/css/wp-default.css' );

    // Other styles
    wp_enqueue_style( 'jquery-mcustom-scrollbar', OUTDOOR_ASSETS_URI . '/css/jquery.mCustomScrollbar.css' );
    wp_enqueue_style( 'bootstrap', OUTDOOR_ASSETS_URI . '/css/bootstrap.css' );
    wp_enqueue_style( 'font-awesome', OUTDOOR_ASSETS_URI . '/css/font-awesome.css' );
    wp_enqueue_style( 'jquery-fancybox', OUTDOOR_ASSETS_URI . '/js/fancybox/source/jquery.fancybox.css' );

    // Outdoor main styles
    wp_enqueue_style( 'outdoor-main-styles', OUTDOOR_ASSETS_URI . '/css/style.css' );

    $font_body          = ( isset( $outdoor_opt['od-typography-body'] ) ) ? $outdoor_opt['od-typography-body'] : '';
    $font_headings      = ( isset( $outdoor_opt['od-typography-headings'] ) ) ? $outdoor_opt['od-typography-headings'] : '';
    $font_paragraph     = ( isset( $outdoor_opt['od-typography-paragraph'] ) ) ? $outdoor_opt['od-typography-paragraph'] : '';
    $options_styles = "";

    // html, body font styles
    $options_styles .= 'html, body {';
    $options_styles .= ( isset( $font_body['font-family'] ) ) ? "font-family: {$font_body['font-family']};" : '';
    $options_styles .= ( isset( $font_body['font-size'] ) ) ? "font-size: {$font_body['font-size']};" : '';
    $options_styles .= ( isset( $font_body['font-weight'] ) ) ? "font-weight: {$font_body['font-weight']};" : '';
    $options_styles .= ( isset( $font_body['color'] ) ) ? "color: {$font_body['color']};" : '';
    $options_styles .= '}'; // End html, body {

    // headings font styles
    $options_styles .= 'h1,h2,h3,h4,h5,h6 {';
    $options_styles .= ( isset( $font_headings['font-family'] ) ) ? "font-family: {$font_headings['font-family']};" : '';
    $options_styles .= ( isset( $font_headings['font-weight'] ) ) ? "font-weight: {$font_headings['font-weight']};" : '';
    $options_styles .= ( isset( $font_headings['color'] ) ) ? "color: {$font_headings['color']};" : '';
    $options_styles .= '}'; // End h1,h2,h3,h4,h5,h6 {

    // paragraph font styles
    $options_styles .= 'p {';
    $options_styles .= ( isset( $font_paragraph['font-family'] ) ) ? "font-family: {$font_paragraph['font-family']};" : '';
    $options_styles .= ( isset( $font_paragraph['font-size'] ) ) ? "font-size: {$font_paragraph['font-size']};" : '';
    $options_styles .= ( isset( $font_paragraph['font-weight'] ) ) ? "font-weight: {$font_paragraph['font-weight']};" : '';
    $options_styles .= ( isset( $font_paragraph['color'] ) ) ? "color: {$font_paragraph['color']};" : '';
    $options_styles .= ( isset( $font_paragraph['line-height'] ) ) ? "line-height: {$font_paragraph['line-height']};" : '';
    $options_styles .= '}'; // End p {

    $custom_css_options = ( isset( $outdoor_opt['od-custom-css'] ) ) ? $outdoor_opt['od-custom-css'] : '';
    if( $custom_css_options ) {
        $options_styles .= "\n // Custom option styles:\n";
        $options_styles .= $custom_css_options;
    }

    // Menu collapse elements color
    if( isset( $outdoor_opt['od-nav-plus-color'] ) && $outdoor_opt['od-nav-plus-color'] ) {
        $options_styles .= '#menu-second-menu svg path {';
        $options_styles .= 'fill: ' . $outdoor_opt['od-nav-plus-color'] . ';';
        $options_styles .= '}'; // End #menu-second-menu {
    }

    // Menu background color
    if( isset( $outdoor_opt['od-nav-bg-color'] ) && $outdoor_opt['od-nav-bg-color'] ) {
        $options_styles .= '#slide-menu, #slide-menu #background-slide-menu {';
        $options_styles .= 'background-color: ' . $outdoor_opt['od-nav-bg-color'] . ';';
        $options_styles .= '}'; // End #slide-menu... {

        $options_styles .= '#menu button {';
        $options_styles .= 'border-color: rgba(' . outdoor_hex_to_rgb( $outdoor_opt['od-nav-bg-color'] ) . ', 0.6);';
        $options_styles .= 'color: ' . $outdoor_opt['od-nav-bg-color'] . ';';
        $options_styles .= '}'; // End #menu button {

        $options_styles .= '#menu button:hover {';
        $options_styles .= 'border-color: ' . $outdoor_opt['od-nav-bg-color'] . ';';
        $options_styles .= '}'; // End #menu button:hover {
    }

    // Menu link color
    if( isset( $outdoor_opt['od-nav-link-color'] ) && $outdoor_opt['od-nav-link-color'] ) {
        $options_styles .= '#slide-menu .wrapper-slide-menu-content #slide-menu-content #navigation-menu ul li span,
                            #slide-menu .wrapper-slide-menu-content #slide-menu-content #navigation-menu ul li a {';
        $options_styles .= 'color: ' . $outdoor_opt['od-nav-link-color'] . ';';
        $options_styles .= '}'; // End #slide-menu .wrapper-slide-menu-content... {
    }

    if( isset( $outdoor_opt['od-nav-link-act-color'] ) && $outdoor_opt['od-nav-link-act-color'] ) {
        $options_styles .= '#navigation-menu ul li a:hover, #navigation-menu ul li a.current, #navigation-menu ul li a.active.current {';
        $options_styles .= 'color: ' . $outdoor_opt['od-nav-link-act-color'] . ' !important;';
        $options_styles .= '}'; // End #navigation-menu ul li a:hover... {
    }

    wp_add_inline_style( 'outdoor-main-styles', $options_styles );

    // Custom styles
    wp_enqueue_style( 'outdoor-custom-styles', OUTDOOR_TPL_URI . '/custom.css' );

    // Style fix for IE 10-11
    wp_enqueue_style( 'outdoor-ie10-fix', OUTDOOR_ASSETS_URI . '/css/ie10.css' );
    wp_enqueue_style( 'outdoor-ie11-fix', OUTDOOR_ASSETS_URI . '/css/ie11.css' );

}
add_action( 'wp_enqueue_scripts', 'outdoor_enqueue_scripts' );

function outdoor_add_inline_js_options() {
    global $outdoor_opt;
    $custom_js = ( isset( $outdoor_opt['od-custom-js'] ) ) ? $outdoor_opt['od-custom-js'] : '';
    echo '<script>' . $custom_js . '</script>';
}
add_action( 'wp_footer', 'outdoor_add_inline_js_options', 100 );

/***************************************************************************************
 * Disable wp-emoji script
 **************************************************************************************/
if ( !function_exists('outdoor_disable_wp_emoji') ) {
    function outdoor_disable_wp_emoji() {
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
        remove_action( 'admin_print_styles', 'print_emoji_styles' );
        remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
        remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
        remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    }
    add_action( 'init', 'outdoor_disable_wp_emoji' );
}