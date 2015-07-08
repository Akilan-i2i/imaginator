<?php

/***************************************************************************************
 * Sets up theme defaults and registers support for various WordPress features.
 **************************************************************************************/
if( !function_exists( 'outdoor_setup' ) ) :
    function outdoor_setup() {

        // Set the theme textdomain
        load_theme_textdomain( 'outdoor', OUTDOOR_TPL_DIR . '/languages' );

        // Enable support title-tag
        add_theme_support( 'title-tag' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        // Enable support HTML5 tags
        add_theme_support( 'html5', array( 'search-form' ) );

        // Enable support post thumbnails for post and page
        add_theme_support( 'post-thumbnails' );

        // Register nav menu location for the theme
        register_nav_menus(array(
            'main-nav'      =>  __( 'Main menu', 'outdoor' ),
            'second-nav'    =>  __( 'Second menu', 'outdoor' )
        ));

        // Enable supports for all default post formats
        add_theme_support( 'post-formats', array(
            'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
        ) );

    }
    add_action( 'after_setup_theme', 'outdoor_setup' );
endif;

/***************************************************************************************
 * Register widgets area
 **************************************************************************************/
function outdoor_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Default sidebar', 'outdoor' ),
        'id'            => 'default',
        'description'   => __( 'Add widgets here to appear in your sidebar.', 'outdoor' ),
        'before_widget' => '<div id="%1$s" class="col-xs-12 widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'outdoor_widgets_init' );