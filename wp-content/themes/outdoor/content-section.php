<?php
/***************************************************************************************
 * Template for a section on homepage
 **************************************************************************************/
global $item;
$page = ( isset( $item->object_id ) ) ? get_post( $item->object_id ) : false;
if( isset( $page->ID ) ) : ?>

<?php
// The page settings
$pageID             = $page->ID;
$layout             = ( get_field( 'page_layout', $pageID ) ) ? get_field( 'page_layout', $pageID ) : 'container';
$invert_el          = ( get_field( 'invert_elements', $pageID ) ) ? get_field( 'invert_elements', $pageID ) : false;
$bg_color           = ( get_field( 'bg_color', $pageID ) ) ? 'background-color: ' . get_field( 'bg_color', $pageID ) . ';' : '';
$bg_image_url       = ( get_field( 'bg_image', $pageID ) ) ? get_field( 'bg_image', $pageID ) : '';
$bg_image           = ( $bg_image_url ) ? ' background-image: url(' . esc_url( $bg_image_url ) . ');' : '';
$height             = ( get_field( 'height', $pageID ) ) ? 'height: ' . get_field( 'height', $pageID ) . ';' : '';
$padding_top        = ( get_field( 'padding_top', $pageID ) ) ? 'padding-top: ' . get_field( 'padding_top', $pageID ) . ';' : '';
$padding_bottom     = ( get_field( 'padding_bottom', $pageID ) ) ? 'padding-bottom: ' . get_field( 'padding_bottom', $pageID ) . ';' : '';
$height             = ( get_field( 'height', $pageID ) ) ? 'height: ' . get_field( 'height', $pageID ) . ';' : '';
$show_border        = ( get_field( 'show_border', $pageID ) ) ? get_field( 'show_border', $pageID ) : false;

// Video background
$video_bg           = ( get_field( 'video_background', $pageID ) ) ? get_field( 'video_background', $pageID ) : false;
$video_mp4_url      = ( get_field( 'video_mp4_url', $pageID ) ) ? get_field( 'video_mp4_url', $pageID ) : '';
$video_ogg_url      = ( get_field( 'video_ogg_url', $pageID ) ) ? get_field( 'video_ogg_url', $pageID ) : '';
$video_webm_url     = ( get_field( 'video_webm_url', $pageID ) ) ? get_field( 'video_webm_url', $pageID ) : '';
$video_autoplay     = ( get_field( 'video_autoplay', $pageID ) ) ? get_field( 'video_autoplay', $pageID ) : false;
$video_loop         = ( get_field( 'video_loop', $pageID ) ) ? get_field( 'video_loop', $pageID ) : false;
$video_muted        = ( get_field( 'video_muted', $pageID ) ) ? get_field( 'video_muted', $pageID ) : false;

// Parallax
$parallax           = ( get_field( 'parallax', $pageID ) ) ? get_field( 'parallax', $pageID ) : false;
$parallax_speed     = ( get_field( 'parallax_speed', $pageID ) ) ? floatval( get_field( 'parallax_speed', $pageID ) ) : '150';
switch( $parallax_speed ) {
    case '1': $parallax_speed = '110'; break;
    case '2': $parallax_speed = '120'; break;
    case '3': $parallax_speed = '130'; break;
    case '4': $parallax_speed = '140'; break;
    case '6': $parallax_speed = '160'; break;
    case '7': $parallax_speed = '170'; break;
    case '8': $parallax_speed = '180'; break;
    case '9': $parallax_speed = '190'; break;
    default: $parallax_speed = '150';
}

// Overlay
$overlay            = ( get_field( 'show_overlay', $pageID ) ) ? get_field( 'show_overlay', $pageID ) : false;
$overlay_color      = ( get_field( 'overlay_color', $pageID ) ) ? 'background-color: ' . get_field( 'overlay_color', $pageID ) . ';' : '';
$overlay_opacity    = ( get_field( 'overlay_opacity', $pageID ) ) ? ' opacity: ' . get_field( 'overlay_opacity', $pageID ) . ';' : '';

// Title
$page_title         = ( get_field( 'page_title', $pageID ) ) ? get_field( 'page_title', $pageID ) : '';
$title_style        = ( get_field( 'title_size', $pageID ) ) ? 'font-size: ' . get_field( 'title_size', $pageID ) . ';' : '';
$title_style       .= ( get_field( 'title_color', $pageID ) ) ? ' color: ' . get_field( 'title_color', $pageID ) . ';' : '';
$title_style       .= ( get_field( 'title_weight', $pageID ) ) ? ' font-weight: ' . get_field( 'title_weight', $pageID ) . ';' : '';
$title_subcolor_style   = ( get_field( 'title_subcolor', $pageID ) ) ? ' color: ' . get_field( 'title_subcolor', $pageID ) . ';' : '';

// Text color
$text_color         = ( get_field( 'text_color', $pageID ) ) ? 'color: ' . get_field( 'text_color', $pageID ) . ';' : '';

// Styles
$styles     = '';
$styles    .= ( '' != $text_color ) ? '#' . $page->post_name . ' p {' . $text_color . '}' : '';
$styles    .= ( '' != $title_style ) ? '#' . $page->post_name . ' h1 {' . $title_style . '}' : '';
$styles    .= ( '' != $title_subcolor_style ) ? '#' . $page->post_name . ' h1 span {' . $title_subcolor_style . '}' : '';

?>

<section id="<?php echo esc_attr( $page->post_name ); ?>" class="cont-box <?php echo ( $invert_el ) ? 'invert-elements' : ''; ?>" style="<?php echo esc_attr( $height ), esc_attr( $padding_top ), esc_attr( $padding_bottom ); ?>">

    <?php if( '' != $styles ) : ?>
        <style type="text/css" scoped><?php echo $styles; ?></style>
    <?php endif; ?>

    <div class="background <?php echo ( $video_bg ) ? 'bg-video' : ''; ?>" <?php echo ( '' != $bg_color ) ? 'style="' . esc_attr ( $bg_color ) . '"' : ''; ?>>
        <?php if( $show_border ) : ?>
            <div style="background-size: auto !important; background: url(<?php echo OUTDOOR_ASSETS_URI; ?>/images/stripes2.svg) repeat-x 0 top" class="layer"></div>
            <div style="background-size: auto !important; background: url(<?php echo OUTDOOR_ASSETS_URI; ?>/images/stripes2.svg) repeat-x 0 bottom" class="layer"></div>
        <?php endif; ?>

        <?php if( !empty( $bg_image ) ) : ?>
            <?php if( $parallax ) : ?>
                <!-- Parallax -->
                <div class="dzsparallaxer auto-init out-of-bootstrap dzsprx-readyall" data-options="{ direction: 'normal'}">
                    <div class="divimage dzsparallaxer--target" style="width: 100%; height: <?php echo esc_attr( $parallax_speed ); ?>%; <?php echo $bg_image; ?>"></div>
                </div>
                <!-- /Parallax -->
            <?php else: ?>
                <div class="layer" style="<?php echo $bg_image; ?>"></div>
            <?php endif; ?>
        <?php endif; // if !empty( $bg_image ) ?>

        <?php if( $video_bg && ( !empty( $video_mp4_url ) || !empty( $video_ogg_url ) || !empty( $video_webm_url ) )) : ?>
            <video <?php echo ( $video_autoplay ) ? 'autoplay="autoplay"' : ''; ?>
                <?php echo ( $video_loop ) ? ' loop="loop"' : ''; ?>
                <?php echo ( $video_muted ) ? ' muted="muted"' : ''; ?>>

                <?php if( $video_mp4_url != '' ) : ?>
                    <source src="<?php echo esc_url( $video_mp4_url ); ?>" type="video/mp4">
                <?php endif; ?>
                <?php if( $video_ogg_url != '' ) : ?>
                    <source src="<?php echo esc_url( $video_ogg_url ); ?>" type="video/ogg">
                <?php endif; ?>
                <?php if( $video_webm_url != '' ) : ?>
                    <source src="<?php echo esc_url( $video_webm_url ); ?>" type="video/webm">
                <?php endif; ?>
            </video>
        <?php endif; ?>

        <?php if( $overlay ) : ?>
            <div class="layer" style="<?php echo esc_attr( $overlay_color ), esc_attr( $overlay_opacity ); ?>"></div>
        <?php endif; ?>

    </div>
    
    <div class="container-fluid">
        <?php if( 'container' == $layout ) : ?>
        <div class="container">
        <?php endif; ?>
            <div class="row">

            <?php if( $page_title ) : ?>
                <h1><?php echo $page_title; ?></h1>
            <?php endif; ?>

            <?php echo apply_filters( 'the_content', $page->post_content ); ?>
            </div>
        <?php if( 'container' == $layout ) : ?>
        </div> <!-- //.container -->
        <?php endif; ?>
    </div>

    <?php edit_post_link( '<i class="fa fa-pencil"></i>' . __( 'Edit block', 'outdoor' ), '<div class="od-edit-btn">', '</div>', $pageID ); ?>
</section>

<?php endif; ?>