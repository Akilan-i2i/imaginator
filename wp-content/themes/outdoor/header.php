<?php

$body_class = '';
if( is_front_page() ) {
    $body_class = 'front-page';
} elseif( is_singular() ) {
    $body_class = 'blog-post';
}

if( !is_front_page() ) {
    $body_class .= ' inner';
}

$header_class = '';
if( ! is_front_page() ) {
    $header_class = ' over-slider';
}

global $outdoor_opt;
$site_logo_url      = ( isset( $outdoor_opt['od-logo'] ) ) ? $outdoor_opt['od-logo']['url'] : '';
$menu_position      = ( isset( $outdoor_opt['od-nav-position'] ) && 'left' == $outdoor_opt['od-nav-position'] ) ? 'left' : 'right';
$wpml_switcher      = ( isset( $outdoor_opt['od-enable-switcher'] ) ) ? $outdoor_opt['od-enable-switcher'] : false;
$show_social_in_menu    = ( isset( $outdoor_opt['od-social-in-menu'] ) ) ? $outdoor_opt['od-social-in-menu'] : true;

// The main nav items
$locations = get_nav_menu_locations();
if( isset( $locations['main-nav'] ) ) {

    $main_menu_items = wp_get_nav_menu_items( $locations['main-nav'], array(
        'order'                  => 'ASC',
        'orderby'                => 'menu_order',
        'post_type'              => 'nav_menu_item',
        'post_status'            => 'publish',
        'output'                 => ARRAY_A,
        'output_key'             => 'menu_order',
        'nopaging'               => true,
        'update_post_term_cache' => false
    ));

} else {
    $main_menu_items = false;
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

    <link href='http://fonts.googleapis.com/css?family=Raleway:400,800,700,300' rel='stylesheet' type='text/css'>

    <?php if( isset( $outdoor_opt['od-favicon'] ) && $outdoor_opt['od-favicon']['url'] ) : ?>
        <link rel="shortcut icon" href="<?php echo esc_url( $outdoor_opt['od-favicon']['url'] ); ?>" type="image/x-icon">
    <?php endif; ?>

    <!--[if IE 8 ]>
    <link rel="stylesheet" type="text/css" href="<?php echo OUTDOOR_ASSETS_URI; ?>/css/ie8.css" />
    <![endif]-->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="<?php echo OUTDOOR_ASSETS_URI; ?>/js/html5shiv.js"></script>
    <script src="<?php echo OUTDOOR_ASSETS_URI; ?>/js/respond.min.js"></script>
    <![endif]-->

    <?php wp_head(); ?>

</head>
<body <?php body_class( $body_class ); ?>>

<!-- SLIDE MENU -->
<div id="slide-menu" class="position-<?php echo esc_attr( $menu_position ); ?>">
    <div id="background-slide-menu"></div>
    <button class="menu-close pull-right"><span class="glyphicon glyphicon-remove"></span></button>
    <div class="wrapper-slide-menu-content">
        <div id="slide-menu-content">

            <div class="block-inline hidden logo-mini">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr( bloginfo( 'description' ) ); ?>">
                    <?php if( $site_logo_url ) : ?>
                        <img class="logo-img" src="<?php echo esc_url( $site_logo_url ); ?>" alt="<?php esc_attr( bloginfo( 'description' ) ); ?>">
                    <?php else: ?>
                        <?php bloginfo( 'name' ); ?>
                    <?php endif; ?>
                </a>
            </div>

            <div class="subMenu nav " id="navigation-menu">
                <?php
                // Show the main navigation ?>
                <?php if( $main_menu_items ) : ?>
                <nav class="menu-main-menu-container">
                    <ul id="menu-main-menu" class="single-page-nav">
                    <?php
                    foreach( $main_menu_items as $item ) {
                        if( 'page' == $item->object ) {
                            $page_slug = get_post_field( 'post_name', $item->object_id );
                        } else {
                            $page_slug = rtrim( $item->url, '/' );
                            $page_slug = substr( $page_slug, strrpos( $page_slug, '/' ) );
                            $page_slug = str_replace( array( '#', '/' ), '', $page_slug );
                        }
                        echo '<li><a href="' . esc_url( home_url() ) . '/#' . $page_slug . '">' . $item->title . '</a></li>';
                    }
                    ?>
                    </ul>
                </nav>
                <?php endif; ?>
                <?php
                // Show the second navigation
                wp_nav_menu(array(
                    'theme_location'    => 'second-nav',
                    'fallback_cb'       => 'return__false'
                )); ?>

            </div><!-- /navigation-menu -->

            <?php if( $show_social_in_menu ) outdoor_social_buttons(); ?>

        </div><!-- /slide-menu-content -->
    </div>

</div><!-- / SLIDE MENU -->

<!-- WRAPPER HEADER -->
<div id="nav-anchor"></div>
<div class="container-fluid  position-<?php echo esc_attr( $menu_position ); ?> <?php echo esc_attr( $header_class ); ?> fixed" id="wrapper-header">
    <div  class="container-fluid" id="header">
        <div class="row">
            <div class="col-sm-4 hidden-xs"></div>
            <div class="col-sm-4 col-xs-5 text-center">
			<div class="block-inline logo-mini">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( bloginfo( 'description' ) ); ?>">
                        <?php if( $site_logo_url ) : ?>
                            <img class="logo-img" src="<?php echo esc_url( $site_logo_url ); ?>" alt="<?php echo esc_attr( bloginfo( 'description' ) ); ?>">
                        <?php else: ?>
                            <?php bloginfo( 'name' ); ?>
                        <?php endif; ?>
                    </a>
                </div>
			</div>
            <div class=" col-sm-4 col-xs-7 text-right">

                <?php
                // Output languages switcher
                outdoor_wpml_switcher(); ?>

                <div id="menu">

                    <div class="btn-group">
                        <button id="menu-open">
                            <i class="fa fa-reorder"></i>
                            <i class="fa fa-times"></i>
                        </button>
                    </div>

                </div>

                <!-- /menu-->
            </div>
        </div>
    </div><!-- /header-->
</div><!-- / WRAPPER HEADER -->

<!-- WRAPPER -->
<div class="container-fluid position-<?php echo esc_attr( $menu_position ); ?>" id="wrapper">