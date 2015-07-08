<?php
/*
 * Template Name: Homepage
 */

global $outdoor_opt;

// Header options
$header_enable      = ( isset( $outdoor_opt['od-home-header-enable'] ) ) ? $outdoor_opt['od-home-header-enable'] : false;
$header_style       = ( isset( $outdoor_opt['od-home-header-style'] ) ) ? $outdoor_opt['od-home-header-style'] : 'style1';
$home_slides        = ( isset( $outdoor_opt['od-home-slides'] ) ) ? $outdoor_opt['od-home-slides'] : '';
$header_text        = ( isset( $outdoor_opt['od-header-text'] ) ) ? $outdoor_opt['od-header-text'] : '';
$header_text_color  = ( isset( $outdoor_opt['od-header-text-color'] ) ) ? $outdoor_opt['od-header-text-color'] : '';
$header_text_opac   = ( isset( $outdoor_opt['od-header-text-opacity'] ) ) ? $outdoor_opt['od-header-text-opacity'] : '';
$header_line_color  = ( isset( $outdoor_opt['od-header-socline-color'] ) ) ? $outdoor_opt['od-header-socline-color'] : '';
$header_line_opac   = ( isset( $outdoor_opt['od-header-socline-opacity'] ) ) ? $outdoor_opt['od-header-socline-opacity'] : '';
$header_subtext     = ( isset( $outdoor_opt['od-header-subtext'] ) ) ? $outdoor_opt['od-header-subtext'] : '';
$header_subtext_col = ( isset( $outdoor_opt['od-header-subtext-color'] ) ) ? $outdoor_opt['od-header-subtext-color'] : '';
$show_social        = ( isset( $outdoor_opt['od-social-in-slider'] ) ) ? $outdoor_opt['od-social-in-slider'] : true;
$video_mp4_url      = ( isset( $outdoor_opt['od-header-video-mp4-url'] ) ) ? $outdoor_opt['od-header-video-mp4-url'] : '';
$video_ogg_url      = ( isset( $outdoor_opt['od-header-video-ogg-url'] ) ) ? $outdoor_opt['od-header-video-ogg-url'] : '';
$video_webm_url     = ( isset( $outdoor_opt['od-header-video-webm-url'] ) ) ? $outdoor_opt['od-header-video-webm-url'] : '';
$video_autoplay     = ( isset( $outdoor_opt['od-header-video-autoplay'] ) ) ? $outdoor_opt['od-header-video-autoplay'] : true;
$video_loop         = ( isset( $outdoor_opt['od-header-video-loop'] ) ) ? $outdoor_opt['od-header-video-loop'] : true;
$video_muted        = ( isset( $outdoor_opt['od-header-video-muted'] ) ) ? $outdoor_opt['od-header-video-muted'] : true;
$video_attrs        = '';
$video_attrs       .= ( $video_autoplay ) ? 'autoplay="autoplay"' : '';
$video_attrs       .= ( $video_loop ) ? ' loop="loop"' : '';
$video_attrs       .= ( $video_muted ) ? ' muted="muted"' : '';

// Contacts options
$map_enable         = ( isset( $outdoor_opt['od-map-enable'] ) ) ? $outdoor_opt['od-map-enable'] : false;
$contact_text       = ( isset( $outdoor_opt['od-contact-text'] ) ) ? $outdoor_opt['od-contact-text'] : '';
$contact_address    = ( isset( $outdoor_opt['od-contact-address'] ) ) ? $outdoor_opt['od-contact-address'] : '';
$contact_emails     = ( isset( $outdoor_opt['od-contact-emails'] ) ) ? $outdoor_opt['od-contact-emails'] : array();
$contact_phones     = ( isset( $outdoor_opt['od-contact-phones'] ) ) ? $outdoor_opt['od-contact-phones'] : array();
$contact_form       = ( isset( $outdoor_opt['od-contact-form'] ) ) ? $outdoor_opt['od-contact-form'] : '';
?>

<?php get_header(); ?>

<?php if( $header_enable ) : ?>

    <!--  primary-banner -->
    <?php if( 'style1' == $header_style ) : ?>

        <section id="primary-banner">
            <div class="container-fluid slider-overlay-style" >
                <div class="row">

                    <?php if( $home_slides ) : ?>
                    <!-- Slider -->
                    <div class="background" id="r-slider">
                        <ul id="full-width-slider" class="rslides rslides-1">
                            <?php foreach( $home_slides as $slide ) : ?>
                                <li style="background-image: url(<?php echo esc_url( $slide['image'] ); ?>);"></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <!-- / Slider -->
                    <?php endif; ?>

                    <div class="primary-banner-text text-center">
                        <p><?php echo $header_subtext; ?></p>
                    </div>

                    <a class="go-down my-scroll" href="#"><i class="fa fa-angle-down"></i></a>

                    <!-- title-blogtop -->
                    <div class="col-xs-12" id="primary-banner-title">
                        <div class="inner-info-block">
                            <div class="block-center">
                                <div class="slider-overlay">
                                    <div class="slider-content">
                                        <div class="content-bg">
                                            <div class="bg"></div>
                                            <div class="bg"></div>
                                            <div class="bg"></div>
                                        </div>
                                        <div class="content-box">
                                            <div class="bg"></div>

                                            <div class="title-box">
                                                <h1 class="title"
                                                    data-fontsize="190"
                                                    data-fontweight=""
                                                    data-fontfamily=""
                                                    data-bg=""><?php echo $header_text; ?></h1>
                                                <div class="social-box">
                                                    <?php if( $show_social ) : ?>
                                                        <?php outdoor_social_buttons( true ); ?>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="bg bg-padding"></div>
                                            </div>
                                            <div class="bg"></div>
                                        </div>
                                        <div class="content-bg">
                                            <div class="bg"></div>
                                            <div class="bg"></div>
                                            <div class="bg"></div>
                                        </div>
                                    </div>
                                </div> <!-- .slider-overlay -->
                            </div>
                        </div>
                    </div>
                    <!-- / title-blogtop -->
                </div>
            </div>
        </section>

    <?php elseif( 'style2' == $header_style ) : ?>

        <section class="inside-pages white" id="primary-banner">
            <div class="container-fluid ">
                <div class="row">

                    <div class="primary-banner-text text-center">
                        <p><?php echo $header_subtext; ?></p>
                    </div>
                    <a class="go-down my-scroll" href="#"><i class="fa fa-angle-down"></i></a>

                    <!-- title-blogtop -->
                    <div class="col-xs-12 first-page" id="primary-banner-title">
                        <div class="inner-info-block">
                            <div class="block-center">
                                <h1><span class="title"><?php echo $header_text; ?></span><br>
                                <?php if( $show_social ) : ?>
                                    <div class="line-soc-icon">
                                        <?php outdoor_social_buttons(); ?>
                                    </div>
                                <?php endif; ?>
                                </h1>
                            </div>
                        </div>
                    </div>
                    <!-- / title-blogtop -->

                    <?php if( $home_slides ) : ?>
                        <!-- Slider -->
                        <div class="background" id="r-slider">
                            <ul id="full-width-slider" class="rslides rslides-1">
                                <?php foreach( $home_slides as $slide ) : ?>
                                    <li style="background-image: url(<?php echo esc_url( $slide['image'] ); ?>);"></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <!-- / Slider -->
                    <?php endif; ?>

                </div>
            </div>
        </section>
        <div class="clearfix"></div>

    <?php elseif( 'style3' == $header_style ) : ?>

        <section class="inside-pages red-style" id="primary-banner">
            <div class="container-fluid ">
                <div class="row">

                    <div class="primary-banner-text text-center">
                        <p><?php echo $header_subtext; ?></p>
                    </div>
                    <a class="go-down my-scroll" href="#"><i class="fa fa-angle-down"></i></a>

                    <!-- title-blogtop -->
                    <div class="col-xs-12 first-page" id="primary-banner-title">
                        <div class="inner-info-block">
                            <div class="block-center">
                                <h1><span class="title"><?php echo $header_text; ?></span><br>
                                    <?php if( $show_social ) : ?>
                                        <div class="line-soc-icon">
                                            <?php outdoor_social_buttons(); ?>
                                        </div>
                                    <?php endif; ?>
                                </h1>
                            </div>
                        </div>
                    </div>
                    <!-- / title-blogtop -->

                    <?php if( $home_slides ) : ?>
                        <!-- Slider -->
                        <div class="background" id="r-slider">
                            <ul id="full-width-slider" class="rslides rslides-1">
                                <?php foreach( $home_slides as $slide ) : ?>
                                    <li style="background-image: url(<?php echo esc_url( $slide['image'] ); ?>);"></li>
                                <?php endforeach; ?>
                            </ul>
                            <div class="layer" style="background: rgba(255, 255, 255, 0.9);"></div>
                        </div>
                        <!-- / Slider -->
                    <?php endif; ?>

                </div>
            </div>
        </section>

    <?php else : ?>

        <section class="inside-pages white" id="primary-banner">
            <div class="container-fluid ">
                <div class="row">

                    <div class="primary-banner-text text-center">
                        <p><?php echo $header_subtext; ?></p>
                    </div>
                    <a class="go-down my-scroll" href="#"><i class="fa fa-angle-down"></i></a>

                    <!-- title-blogtop -->
                    <div class="col-xs-12 first-page" id="primary-banner-title">
                        <div class="inner-info-block">
                            <div class="block-center">
                                <h1><span class="title"><?php echo $header_text; ?></span><br>
                                    <?php if( $show_social ) : ?>
                                        <div class="line-soc-icon">
                                            <?php outdoor_social_buttons(); ?>
                                        </div>
                                    <?php endif; ?>
                                </h1>
                            </div>
                        </div>
                    </div>
                    <!-- / title-blogtop -->

                    <!-- Slider -->
                    <div class="background bg-video">
                        <video <?php echo $video_attrs; ?>>
                            <?php if( is_array( $video_mp4_url ) && $video_mp4_url['url'] ) : ?>
                            <source src="<?php echo esc_url( $video_mp4_url['url'] ); ?>" type="video/mp4">
                            <?php endif; ?>
                            <?php if( is_array( $video_ogg_url ) && $video_ogg_url['url'] ) : ?>
                            <source src="<?php echo esc_url( $video_ogg_url['url'] ); ?>" type="video/ogg">
                            <?php endif; ?>
                            <?php if( is_array( $video_webm_url ) && $video_webm_url['url'] ) : ?>
                            <source src="<?php echo esc_url( $video_webm_url['url'] ); ?>" type="video/webm">
                            <?php endif; ?>
                        </video>
                    </div>
                    <!-- / Slider -->

                </div>
            </div>
        </section>
        <div class="clearfix"></div>

    <?php endif; ?>

    <?php if( '' != $header_text_color ) : ?>
        <style type="text/css" scoped>
            #primary-banner-title h1 {
                color: <?php echo $header_text_color; ?> !important;
            }
            <?php if( '' != $header_text_opac ) : ?>
            #primary-banner-title h1 .title {
                opacity: <?php echo $header_text_opac; ?>;
            }
            <?php endif; ?>
        </style>
    <?php endif; ?>

    <?php if( '' != $header_line_color ) : ?>
        <style type="text/css" scoped>
            #primary-banner-title h1 .line-soc-icon::before,
            #primary-banner-title h1 .line-soc-icon::after {
                background-color: rgba(<?php echo outdoor_hex_to_rgb( $header_line_color ); ?>, <?php echo $header_line_opac; ?>) !important;
            }
        </style>
    <?php endif; ?>

    <?php if( '' != $header_subtext_col ) : ?>
        <style type="text/css" scoped>
            #primary-banner .primary-banner-text {
                color: <?php echo $header_subtext_col; ?> !important;
            }
        </style>
    <?php endif; ?>

    <!--  /primary-banner -->

<?php endif; // End if $header_enable ?>

<?php
// Show the homepage sections
$locations = get_nav_menu_locations();
if( isset( $locations['main-nav'] ) ) {

    $menu_items = wp_get_nav_menu_items( $locations['main-nav'], array(
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
    $menu_items = false;
}

if( $menu_items ) {
    foreach( $menu_items as $item ) {
        if( 'page' != $item->object ) continue;
        // Load the content section template
        get_template_part( 'content', 'section' );
    }
}
?>

<?php if( $map_enable ) : ?>
<!-- CONTACTS -->
<section id="contacts">
    <div class="container-fluid" >
        <div id="mapa">
            <div id="map-canvas"></div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12" id="cont-info">

                    <h2 class="title-contacts"><?php _e( 'Contacts', 'outdoor' ); ?></h2>

                    <?php if( $contact_text ) : ?>
                    <div id="text-contact">
                        <p><?php echo $contact_text; ?></p>
                    </div>
                    <?php endif; ?>

                    <div class="row" id="info-cotact">

                        <div class="col-md-6 col-sm-6 col-xs-12">

                            <?php if( $contact_address ) : ?>
                            <h6><?php _e( 'Address', 'outdoor' ); ?></h6>
                            <p><?php echo $contact_address; ?></p>
                            <?php endif; ?>

                            <?php if( $contact_phones && $contact_phones[0] != '' ) : ?>
                                <p class="tel-contact">
                                    <?php foreach( $contact_phones as $phone ) : ?>
                                        <strong><?php _e( 'P:', 'outdoor' ); ?></strong><?php echo $phone; ?><br>
                                    <?php endforeach; ?>
                                </p>
                            <?php endif; ?>

                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php if( $contact_emails && $contact_emails[0] != '' ) : ?>
                            <h6><?php _e( 'Email', 'outdoor' ); ?></h6>
                                <?php foreach( $contact_emails as $email ) : ?>
                                    <p><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo $email; ?></a></p>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                    </div>

                    <h5><?php _e( 'Say Hello', 'outdoor' ) ?></h5>

                    <?php if( $contact_form ) : ?>
                        <?php
                        // Show a contact form 7 if set
                        echo do_shortcode( $contact_form ); ?>
                    <?php else: ?>

                    <form id="contactform" role="form" class="contact-form" method="POST">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12 fix-left">
                                <div class="form-group name">
                                    <input type="text" class="form-control" name="uname" placeholder="Name*">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 fix-right">
                                <div class="form-group email">
                                    <input type="email" class="form-control" name="email" placeholder="Email*">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="comment" rows="4" placeholder="Message*"></textarea>
                        </div>
                        <div class="hidden">
                            <?php wp_nonce_field( 'outdoor_contact_form', 'outdoor_contact_form_nonce' ); ?>
                        </div>
                        <button id="submit" type="submit" class="btn btn-default"><?php _e( 'SEND', 'outdoor' ) ?></button>
                        <span class="form-message" style="display: none;"></span>
                    </form>

                    <?php endif; ?>

                </div>
            </div>
        </div>

    </div>
</section>
<!-- / CONTACTS -->
<?php endif; ?>

<?php get_footer(); ?>