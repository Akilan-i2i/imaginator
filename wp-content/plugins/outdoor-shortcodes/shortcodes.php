<?php
/***************************************************************************************
 * Divider shortcode
 **************************************************************************************/
function outdoor_divider_shortcode( $atts, $content = '' ) {

    extract( shortcode_atts( array(
        'title'     => '',
        'color'   => ''
    ), $atts ) );

    ob_start();
// End php code ?>

    <div class="row">
        <div class="col-xs-12">
            <div class="titile-divider <?php echo esc_attr( $color ); ?>">
                <span><?php echo $title; ?></span>
            </div>
        </div>
    </div>

    <?php // Start php code
    return ob_get_clean();
}
add_shortcode( 'divider', 'outdoor_divider_shortcode' );

/***************************************************************************************
 * Alert shortcode
 **************************************************************************************/
function outdoor_alert_shortcode( $atts, $content = '' ) {

    extract( shortcode_atts( array(
        'type'      => 'success'
    ), $atts ) );

    switch( $type ) {
        case 'black':   $class_type = 'black'; $icon = 'times-circle'; break;
        case 'warning': $class_type = 'warning'; $icon = 'bolt'; break;
        case 'gray':    $class_type = 'gray'; $icon = 'times-circle'; break;
        case 'info':    $class_type = 'info'; $icon = 'check-circle'; break;
        case 'danger':  $class_type = 'danger'; $icon = 'times-circle'; break;
        default:        $class_type = 'success'; $icon = 'check-circle';
    }

    ob_start();
// End php code ?>

    <div class="alert alert-<?php echo esc_attr( $class_type ); ?> fade in">
        <i class="fa fa-<?php echo esc_attr( $icon ); ?> alert-icon"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $content; ?>
    </div>

    <?php // Start php code
    return ob_get_clean();
}
add_shortcode( 'alert', 'outdoor_alert_shortcode' );

/***************************************************************************************
 * Tabs shortcode
 **************************************************************************************/
$tabs_number = 0;
$tab_number = 0;
function outdoor_tabs_shortcode( $atts, $content = '' ) {
    global $tabs_number, $tab_number;

    extract( shortcode_atts( array(
        'id'        => '',
        'white'     => 'false',
        'class'     => '',
        'titles'    => '',
        'vertical'  => 'false'
    ), $atts ) );

    $id             = ( '' != $id ) ? 'id="' . esc_attr( $id ) . '"': '';
    $titles         = ( '' != $titles ) ? explode( ',', $titles ) : '';
    $white_class    = ( $white == 'true' ) ? 'white-tabs' : '';
    $tabs_number++;
    $tab_number = 0;
    ob_start();
// End php code ?>

    <?php if( is_array( $titles ) && $titles ) : ?>

        <?php if( 'true' == $vertical ) : ?>

            <div <?php echo $id; ?> class="vertical-tabs <?php echo rtrim( $white_class, 's' ); ?>">
                <div class="col-xs-12 col-sm-4">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs tabs-left myTab <?php echo esc_attr( $white_class ); ?>">
                        <?php $tab_index = 1; ?>
                        <?php foreach( $titles as $title ) : ?>
                            <li class="<?php echo ( 1 == $tab_index ) ? 'active' : ''; ?>"><a href="#od-tab-<?php echo esc_attr( $tabs_number ), '-', esc_attr( $tab_index ); ?>" role="tab" data-toggle="tab"><?php echo $title; ?></a></li>
                            <?php $tab_index++; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="hidden-xs col-sm-8">
                    <!-- Tab panes -->
                    <div class="tab-content <?php echo esc_attr( $white_class ); ?>">
                        <?php echo do_shortcode( $content ); ?>
                    </div>
                </div>
            </div> <!-- vertical-tabs -->

        <?php else: ?>

            <div <?php echo $id; ?> class="horizontal-tabs <?php echo rtrim( $white_class, 's' ); ?>">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs myTab <?php echo esc_attr( $white_class ); ?>" role="tablist">
                    <?php $tab_index = 1; ?>
                    <?php foreach( $titles as $title ) : ?>
                        <li class="<?php echo ( 1 == $tab_index ) ? 'active' : ''; ?>"><a href="#od-tab-<?php echo esc_attr( $tabs_number ), '-', esc_attr( $tab_index ); ?>" role="tab" data-toggle="tab"><?php echo $title; ?></a></li>
                        <?php $tab_index++; ?>
                    <?php endforeach; ?>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content <?php echo $white_class; ?>">
                    <?php echo do_shortcode( strip_tags( $content ) ); ?>
                </div>
            </div><!-- horizontal-tabs -->

        <?php endif; ?>

            <div class="clearfix"></div>
    <?php endif; ?>

    <?php // Start php code
    return ob_get_clean();
}
add_shortcode( 'tabs', 'outdoor_tabs_shortcode' );

/***************************************************************************************
 * Tab item shortcode
 **************************************************************************************/
function outdoor_tab_shortcode( $atts, $content = '' ) {
    global $tabs_number, $tab_number;

    extract( shortcode_atts( array(
        'class' => ''
    ), $atts ) );

    $tab_number++;
    ob_start();
// End php code ?>

    <div class="tab-pane <?php echo ( 1 == $tab_number ) ? 'active' : ''; ?> <?php echo esc_attr( $class ); ?>" id="od-tab-<?php echo esc_attr( $tabs_number ), '-', esc_attr( $tab_number ); ?>">
        <p><?php echo $content; ?></p>
    </div>

    <?php // Start php code
    return ob_get_clean();
}
add_shortcode( 'tab', 'outdoor_tab_shortcode' );

/***************************************************************************************
 * Accordion shortcode
 **************************************************************************************/
$accordion_number = 0;
$accordion_settings = array();
function outdoor_accordion_shortcode( $atts, $content = '' ) {
    global $accordion_number, $accordion_settings;

    extract( shortcode_atts( array(
        'id'    => '',
        'white' => 'false',
        'class' => ''
    ), $atts ) );

    $white_class = ( $white == 'true' ) ? 'white-accordion' : '';
    $accordion_number++;
    $accordion_settings[$accordion_number] = array(
        'id'    => $id
    );
    ob_start();
// End php code ?>

    <div class="panel-group accordion <?php echo esc_attr( $white_class ), ' ', esc_attr( $class ); ?>" <?php echo ( $id != '' ) ? 'id="' . esc_attr( $id ) . '"' : ''; ?>>
        <?php echo do_shortcode( strip_tags( $content ) ); ?>
    </div>

    <?php // Start php code
    return ob_get_clean();
}
add_shortcode( 'accordion', 'outdoor_accordion_shortcode' );

/***************************************************************************************
 * Accordion item shortcode
 **************************************************************************************/
function outdoor_accordion_item_shortcode( $atts, $content = '' ) {
    global $accordion_number, $accordion_settings;

    extract( shortcode_atts( array(
        'title' => ''
    ), $atts ) );

    $accordion_id = ( isset( $accordion_settings[$accordion_number]['id'] ) ) ? $accordion_settings[$accordion_number]['id'] : '';
    static $elem_id = 0; $elem_id++;
    ob_start();
// End php code ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#<?php echo esc_attr( $accordion_id ); ?>" href="#od-collapse-<?php echo esc_attr( $accordion_number ), '-', esc_attr( $elem_id ); ?>" class="collapsed">
                    <?php echo $title; ?>
                </a><i class="indicator glyphicon glyphicon-plus  pull-right"></i>
            </h4>
        </div>
        <div id="od-collapse-<?php echo esc_attr( $accordion_number ), '-', esc_attr( $elem_id ); ?>" class="panel-collapse collapse" style="height: 0px;">
            <div class="panel-body">
                <?php echo $content; ?>
            </div>
        </div>
    </div>

    <?php // Start php code
    return ob_get_clean();
}
add_shortcode( 'accordion_item', 'outdoor_accordion_item_shortcode' );

/***************************************************************************************
 * Newsletter shortcode
 **************************************************************************************/
function outdoor_newsletter_shortcode( $atts, $content = '' ) {

    extract( shortcode_atts( array(
        'class' => ''
    ), $atts ) );

    $class = ( '' != $class ) ? 'class="' . $class . '"' : '';
    ob_start();
// End php code ?>

    <form id="newsletters-form" <?php echo esc_attr( $class ); ?> method="POST">
        <div class="success hide"></div>
        <div class="row">
            <div class="col-xs-12 col-sm-9 fix-left">
                <input type="email" name="newsletters-email" class="form-control" id="newsletters-email" placeholder="<?php _e( 'Your e-mail', 'outdoor' ) ?>">
                <div class="form-message"></div>
                <div class="form-error"></div>
            </div>
            <div class="col-xs-12 col-sm-3 fix-right">
                <button id="newsletters-submit" type="submit" class="btn-default"><?php _e( 'SUBSCRIBE', 'outdoor' ) ?></button>
            </div>
        </div>
    </form>

    <?php // Start php code
    return ob_get_clean();
}
add_shortcode( 'newsletter', 'outdoor_newsletter_shortcode' );

/***************************************************************************************
 * Skill shortcode
 **************************************************************************************/
function outdoor_skill_shortcode( $atts, $content = '' ) {

    extract( shortcode_atts( array(
        'percent'       => 50,
        'title'         => '',
        'color'         => '#9eb533',
        'color_start'   => '',
        'width'         => '150',
        'height'        => '150'
    ), $atts ) );

    $percent = intval( $percent );
    if( $percent > 100 )
        $percent = 100;
    elseif( $percent < 0 )
        $percent = 0;

    $width  = ( '' != $width ) ? intval( $width ) : '';
    $height = ( '' != $height ) ? intval( $height ) : '';

    ob_start();
// End php code ?>

    <div class="skill-wrap text-center">
        <canvas class="skill-item" width="<?php echo esc_attr( $width ); ?>" height="<?php echo esc_attr( $height ); ?>"
                data-percent="<?php echo esc_attr( $percent ); ?>" data-color="<?php echo esc_attr( $color ); ?>"
                data-start-color="<?php echo esc_attr( $color_start ); ?>"
                data-width="<?php echo esc_attr( $width ); ?>" data-height="<?php echo esc_attr ( $height ); ?>"><?php echo $title; ?></canvas>
    </div>

    <?php // Start php code
    return ob_get_clean();
}
add_shortcode( 'skill', 'outdoor_skill_shortcode' );

/***************************************************************************************
 * Gap shortcode
 **************************************************************************************/
function outdoor_gap_shortcode( $atts, $content = '' ) {

    extract( shortcode_atts( array(
        'size'     => 0
    ), $atts ) );

    $size = intval( $size );
    $style = ( $size > 1 ) ? 'style="margin-bottom: ' . esc_attr( ( $size - 1 ) ) . 'px;"' : '';

    ob_start();
// End php code ?>

    <hr class="od-gap" <?php echo $style; ?>>

    <?php // Start php code
    return ob_get_clean();
}
add_shortcode( 'gap', 'outdoor_gap_shortcode' );

/***************************************************************************************
 * Row shortcode
 **************************************************************************************/
function outdoor_row_shortcode( $atts, $content = '' ) {

    extract( shortcode_atts( array(
        'id'        => '',
        'class'     => '',
        'center'    => 'false'
    ), $atts ) );

    $id          = ( '' != $id ) ? 'id="' . esc_attr( $id ) . '"' : '';
    $text_center = ( 'true' == $center ) ? 'text-center' : '';

    ob_start();
// End php code ?>

    <div <?php echo $id; ?> class="row <?php echo esc_attr( $text_center ), ' ', esc_attr( $class ); ?>"><?php echo do_shortcode( $content ); ?></div>

    <?php // Start php code
    return ob_get_clean();
}
add_shortcode( 'row', 'outdoor_row_shortcode' );

/***************************************************************************************
 * Col shortcode
 **************************************************************************************/
function outdoor_col_shortcode( $atts, $content = '' ) {

    extract( shortcode_atts( array(
        'id'        => '',
        'class'     => '',
        'type'      =>  '1x2',
        'center'    => 'false'
    ), $atts ) );

    $id          = ( '' != $id ) ? 'id="' . esc_attr( $id ) . '"' : '';
    $text_center = ( 'true' == $center ) ? ' text-center' : '';

    $col_class = 'col-xs-12 ';
    switch( $type ) {
        case '1x3': $col_class .= 'col-sm-4'; break;
        case '1x4': $col_class .= 'col-sm-3'; break;
        default: $col_class .= 'col-sm-6';
    }
    ob_start();
// End php code ?>

    <div <?php echo $id; ?> class="<?php echo esc_attr( $col_class ), esc_attr( $text_center ), ' ', esc_attr( $class ); ?>"><?php echo do_shortcode( $content ); ?></div>

    <?php // Start php code
    return ob_get_clean();
}
add_shortcode( 'col', 'outdoor_col_shortcode' );

/***************************************************************************************
 * Progress shortcode
 **************************************************************************************/
function outdoor_progress_shortcode( $atts, $content = '' ) {

    extract( shortcode_atts( array(
        'percent'   => '50',
        'color'     => '#86a200',
        'title'     => 'Progress'
    ), $atts ) );

    $percent    = ( '' != $percent ) ? intval( $percent ) : 50;
    $bg_color   = ( '' != $color ) ? 'style="background-color: #' . esc_attr( ltrim( $color, '#' ) ) . '"' : '';

    ob_start();
// End php code ?>

    <?php if( $percent ) : ?>

        <div class="progress" data-appear-progress-animation="<?php echo esc_attr( $percent ); ?>%">
            <div class="progress-bar" <?php echo $bg_color; ?>><?php echo $title; ?></div>
        </div>

    <?php endif; ?>

<?php // Start php code
    return ob_get_clean();
}
add_shortcode( 'progress', 'outdoor_progress_shortcode' );

/***************************************************************************************
 * Video shortcode
 **************************************************************************************/
function outdoor_video_shortcode( $atts, $content = '' ) {

    extract( shortcode_atts( array(
        'url'   => ''
    ), $atts ) );

    ob_start();
// End php code ?>

    <div id="video" class="row">
        <div class="col-xs-12">

            <div class="video-box text-center">
                <button class="play-video" id="play-button" data-video-url="<?php echo esc_url( $url ); ?>"><i class="fa fa-play-circle-o"></i></button>

                <div style="display:none;" class="video-block">
                    <button class="close-video"><i class="fa fa-times"></i></button>
                    <div class="video-body"> </div>
                </div>
            </div>

        </div>
    </div>

<?php // Start php code
    return ob_get_clean();
}
add_shortcode( 'video', 'outdoor_video_shortcode' );

/***************************************************************************************
 * Last posts shortcode
 **************************************************************************************/
function outdoor_last_posts_shortcode( $atts, $content = '' ) {

    extract( shortcode_atts( array(
        'ids'           => '',
        'limit'         => 10,
        'category_ids'  => '',
        'order'         => 'DESC',
        'order_by'      => 'post_date',
        'single'        => 'false'
    ), $atts ) );

    $args = array(
        'numberposts'   => $limit,
        'orderby'       => $order_by,
        'order'         => $order,
        'suppress_filters'  =>  false,
    );

    if( '' != $ids ) {
        $array_ids = explode( ',', $ids );
        $args['post__in'] = $array_ids;
    }

    if( '' != $category_ids ) {
        $args['category'] = $category_ids;
    }
    $posts = get_posts( $args );

    $data_item_attr = ( 'false' == $single ) ? 'data-item-max="3" data-item-width="350"' : '';
    $slider_class   = ( 'false' == $single ) ? 'post-slider' : 'posted-slider';
    $slider_foo     = ( 'false' == $single ) ? '1' : '2';

    ob_start();
// End php code ?>

    <?php if( $posts ) : ?>

    <div class="col-xs-12">
        <div class="<?php echo esc_attr( $slider_class ); ?>">
            <div class="row list-carousel responsive slider-foo-<?php echo esc_attr( $slider_foo ); ?>">

                <div class="preloader">
                    <div class="preload-img"></div>
                </div>

                <div class="carousel-box foo<?php echo esc_attr( $slider_foo ); ?>" <?php echo $data_item_attr; ?>>

                    <?php foreach( $posts as $post ) :
                        $thumb = get_the_post_thumbnail( $post->ID, 'full', array(
                            'class' => outdoor_retina_class(),
                            'alt'   => $post->post_title
                        )); ?>

                        <?php if( 'false' == $single ) : ?>

                            <div class="col-xs-12 col-sm-4 col-md-3">
                                <div class="img-block text-center-sm text-center-xs">
                                    <?php if( $thumb ) echo $thumb; ?>
                                </div>
                                <h6><a href="<?php echo esc_url( get_the_permalink( $post->ID ) ); ?>"><?php echo $post->post_title; ?></a></h6>
                                <p class="data-post"><?php outdoor_post_meta( $post->ID, true ); ?></p>
                                <p class="text-post"><?php echo mb_substr( strip_tags( $post->post_content ), 0, 120 ); ?></p>
                                <a href="<?php echo esc_url( get_the_permalink( $post->ID ) ); ?>" class="btn-default"><?php _e( 'Read More', 'outdoor' ); ?> <i class="fa fa-angle-right"></i></a>
                            </div>

                        <?php else: ?>

                            <div class="col-xs-12 col-sm-4 col-md-3">
                                <div class="row">
                                    <?php if( $thumb ) : ?>
                                    <div class="col-sm-5 col-xs-12 text-center-sm text-center-xs">
                                        <div class="img-block">
                                            <?php echo $thumb; ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <div class="col-sm-7 col-xs-12">
                                        <h2><a href="<?php echo esc_url( get_the_permalink( $post->ID ) ); ?>"><?php echo $post->post_title; ?></a></h2>
                                        <div class="post-info">
                                            <?php outdoor_post_meta( $post->ID, true ); ?>
                                        </div>
                                        <p class="text-post"><?php echo strip_tags( $post->post_content ); ?></p>
                                        <a href="<?php echo esc_url( get_the_permalink( $post->ID ) ); ?>" class="btn-default"><?php _e( 'Read More', 'outdoor' ); ?> <i class="fa fa-angle-right"></i></a>
                                    </div>
                                </div>
                            </div>

                        <?php endif; ?>

                    <?php endforeach; ?>
                    <?php wp_reset_postdata(); ?>

                </div>
                <div class="clearfix"></div>

                <?php if( 'true' == $single ) : ?>
                    <button class="prev"><i class="fa fa-angle-left"></i></button>
                    <button class="next"><i class="fa fa-angle-right"></i></button>
                <?php endif; ?>
            </div>
            <?php if( 'false' == $single ) : ?>
                <button class="prev"><i class="fa fa-angle-left"></i></button>
                <button class="next"><i class="fa fa-angle-right"></i></button>
            <?php endif; ?>
        </div><!-- /post-slider -->
    </div>

    <?php else: ?>
        <p><?php _e( 'Posts not found', 'outdoor' ); ?></p>
    <?php endif; ?>

    <?php // Start php code
    return ob_get_clean();
}
add_shortcode( 'lastposts', 'outdoor_last_posts_shortcode' );

/***************************************************************************************
 * Pricing shortcode
 **************************************************************************************/
function outdoor_pricing_shortcode( $atts, $content = '' ) {

    extract( shortcode_atts( array(
        'ids'           => '',
        'limit'         => 3,
        'order'         => 'ASC',
    ), $atts ) );

    $args = array(
        'numberposts'   => $limit,
        'orderby'       => 'menu_order',
        'order'         => $order,
        'post_type'     => 'od-pricetable',
        'suppress_filters'  =>  false,
    );

    if( '' != $ids ) {
        $array_ids = explode( ',', $ids );
        $args['post__in'] = $array_ids;
    }
    $pricing = get_posts( $args );

    ob_start();
// End php code ?>

    <?php if( $pricing ) : ?>

    <div class="text-center" id="block-pricing">
        <div class="clearfix"></div>

        <?php foreach( $pricing as $price ) :

            $price_bg       = ( get_field( 'bg_color', $price->ID ) ) ? get_field( 'bg_color', $price->ID ) : '';
            $bg_opacity     = ( get_field( 'bg_opacity', $price->ID ) ) ? (float) get_field( 'bg_opacity', $price->ID ) : '1';
            $icon_name      = ( get_field( 'icon', $price->ID ) ) ? get_field( 'icon', $price->ID ) : '';
            $price_bg       = ( $price_bg ) ? 'background-color: rgba(' . esc_attr( outdoor_hex_to_rgb( $price_bg ) ) . ',' . $bg_opacity . ')' : '';
            $color          = ( get_field( 'color', $price->ID ) ) ? get_field( 'color', $price->ID ) : '';
            $color_bg       = ( $color ) ? 'background-color: ' . esc_attr( $color ) . ' !important;' : '';
            $color_text     = ( $color ) ? 'style="color: ' . esc_attr( $color ) . ' !important;"' : '';
            $price_val      = ( get_field( 'price', $price->ID ) ) ? get_field( 'price', $price->ID ) : '';
            $price_label    = ( get_field( 'price_label', $price->ID ) ) ? get_field( 'price_label', $price->ID ) : '';
            $text_btn       = ( get_field( 'text_btn', $price->ID ) ) ? get_field( 'text_btn', $price->ID ) : '';
            $link           = ( get_field( 'link', $price->ID ) ) ? get_field( 'link', $price->ID ) : '#';
            $features       = ( get_field( 'features', $price->ID ) ) ? get_field( 'features', $price->ID ) : '';

            ?>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="cont-pricing" style="<?php echo $price_bg; ?>">
                    <div class="lollipop" style="<?php echo $color_bg; ?>">
                        <?php if( $icon_name ) : ?>
                            <span class="small-icon">
                                <img src="<?php echo OUTDOOR_ASSETS_URI; ?>/images/small-icons/<?php echo $icon_name; ?>.svg" alt="<?php echo esc_attr( $icon_name ); ?>">
                            </span>
                        <?php endif; ?>
                    </div>
                    <a class="sorting" href="#" <?php echo $color_text; ?> onclick="return false;"><?php echo $price->post_title; ?></a>
                    <ul>
                        <?php if( $features ) : ?>
                            <?php foreach( $features as $feature ) : ?>
                                <li><?php echo $feature['label']; ?></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <?php if( $price_val ) : ?>
                            <li>
                                <span class="price" <?php echo $color_text; ?>><?php echo $price_val; ?></span>
                                <span class="permonth"><?php echo $price_label; ?></span>
                            </li>
                        <?php endif; ?>
                        <?php if( $text_btn ) : ?>
                            <li><a href="<?php echo esc_url( $link ); ?>" class="join-now btn-default" style="<?php echo esc_attr( $color_bg ); ?>"><?php echo $text_btn; ?></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
        <?php wp_reset_postdata(); ?>

    </div>

    <?php else: ?>
        <p><?php _e( 'Posts not found', 'outdoor' ); ?></p>
    <?php endif; ?>

    <?php // Start php code
    return ob_get_clean();
}
add_shortcode( 'pricing', 'outdoor_pricing_shortcode' );

/***************************************************************************************
 * Quotes shortcode
 **************************************************************************************/
function outdoor_quotes_shortcode( $atts, $content = '' ) {

    extract( shortcode_atts( array(
        'ids'   => '',
        'limit' => 10
    ), $atts ) );

    $args = array(
        'numberposts'   =>  $limit,
        'post_type'     =>  'od-quote',
        'suppress_filters'  =>  false,
    );

    if( '' != $ids ) {
        $array_ids = explode( ',', $ids );
        $args['post__in'] = $array_ids;
    }
    $quotes = get_posts( $args );

    ob_start();
// End php code ?>

    <?php if( $quotes ) : ?>

        <div class="row elements-blockquote">
            <div class="col-xs-12">

                <!-- carousel -->
                <div class="wrapper-carusel blockquote-slider">
                    <div class="carusel-7">
                        <div class="row list-carousel responsive slider-foo-7 ">

                            <div class="preloader">
                                <div class="preload-img"></div>
                            </div>

                            <div class="carousel-box foo7" data-item-max="1" data-item-width="780">

                                <?php foreach( $quotes as $quote ) : ?>
                                    <div class="col-xs-12">
                                        <blockquote>
                                            <span><?php echo strip_tags( $quote->post_content ); ?></span>
                                            <footer><cite title="<?php echo esc_attr( $quote->post_title ); ?>"><?php echo $quote->post_title; ?></cite></footer>
                                        </blockquote>
                                    </div>
                                <?php endforeach; ?>
                                <?php wp_reset_postdata(); ?>

                            </div>

                        </div>
                    </div>
                    <button class="prev"><i class="fa fa-angle-left"></i></button>
                    <button class="next"><i class="fa fa-angle-right"></i></button>
                </div><!-- /carousel -->
            </div>
        </div>

    <?php endif; ?>

    <?php // Start php code
    return ob_get_clean();
}
add_shortcode( 'quotes', 'outdoor_quotes_shortcode' );

/***************************************************************************************
 * Clients shortcode
 **************************************************************************************/
function outdoor_clients_shortcode( $atts, $content = '' ) {

    extract( shortcode_atts( array(
        'ids'   => '',
        'limit' => 4
    ), $atts ) );

    $args = array(
        'numberposts'   =>  $limit,
        'post_type'     =>  'od-client',
        'suppress_filters'  =>  false,
    );

    if( '' != $ids ) {
        $array_ids = explode( ',', $ids );
        $args['post__in'] = $array_ids;
    }
    $clients = get_posts( $args );

    ob_start();
// End php code ?>

    <?php if( $clients ) : ?>
    <!-- Clients -->

    <div class="clients-gallery">
        <div class="row">
            <?php foreach( $clients as $client ) : ?>
                <?php
                $thumb = get_the_post_thumbnail( $client->ID, 'full', array(
                    'class' => outdoor_retina_class(),
                    'alt'   => $client->post_title
                ) ); ?>

                <?php if( $thumb ) : ?>
                <div class="col-xs-12 col-sm-3 text-center-xs appear-block" data-appear-animation="bounceInUp">
                    <a href="#"><?php echo $thumb; ?></a>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>

    <!-- / Clients -->
    <?php endif; ?>

<?php // Start php code
    return ob_get_clean();
}
add_shortcode( 'clients', 'outdoor_clients_shortcode' );

/***************************************************************************************
 * Team slider shortcode
 **************************************************************************************/
function outdoor_team_shortcode( $atts, $content = '' ) {

    extract( shortcode_atts( array(
        'ids'       => '',
        'limit'     => 10,
        'single'    => 'false'
    ), $atts ) );

    $args = array(
        'numberposts'   =>  $limit,
        'post_type'     =>  'od-team',
        'suppress_filters'  =>  false,
    );

    if( '' != $ids ) {
        $array_ids = explode( ',', $ids );
        $args['post__in'] = $array_ids;
    }
    $team = get_posts( $args );

    ob_start();
// End php code ?>

    <?php if( $team ) : ?>
        <!-- Team -->
        <?php if( 'false' == $single ) : ?>

            <div class="col-sx-12">
                <div class="clearfix"></div>

                <div class="wrapper-carusel carusel-5">
                    <div class="row list-carousel responsive slider-foo-5">
                        <div class="preloader">
                            <div class="preload-img"></div>
                        </div>
                        <div class="carousel-box foo5" data-item-max="4">

                            <?php foreach( $team as $people ) : ?>
                                <div class="col-xs-12 col-sm-4 col-md-3">
                                    <div class="img-block">
                                        <?php if( $photo = get_the_post_thumbnail( $people->ID, 'full', array(
                                            'class' => outdoor_retina_class(),
                                            'alt'   => $people->post_title
                                        ) ) )
                                            echo $photo; ?>
                                    </div>
                                    <h6><?php echo get_the_title( $people->ID ); ?></h6>
                                    <p><?php echo strip_tags( $people->post_content ); ?></p>
                                    <?php outdoor_people_social_buttons( $people->ID ); ?>
                                </div>
                            <?php endforeach; ?>
                            <?php wp_reset_postdata(); ?>

                        </div>
                    </div>
                    <button class="prev"><i class="fa fa-angle-left"></i></button>
                    <button class="next"><i class="fa fa-angle-right"></i></button>

                </div><!-- /carusel-5 -->
            </div>

        <?php else: ?>

            <div class="slider-people margin-bottom">
                <div class="col-xs-12">
                    <div class="row list-carousel responsive slider-foo-8">

                        <div class="preloader">
                            <div class="preload-img"></div>
                        </div>

                        <div class="carousel-box foo8">

                            <?php foreach( $team as $people ) :
                                $proff = ( get_field( 'profession', $people->ID ) ) ? get_field( 'profession', $people->ID ) : '';
                                $email = ( get_field( 'email', $people->ID ) ) ? get_field( 'email', $people->ID ) : '';
                                $phone = ( get_field( 'phone', $people->ID ) ) ? get_field( 'phone', $people->ID ) : '';
                                $skype = ( get_field( 'skype', $people->ID ) ) ? get_field( 'skype', $people->ID ) : '';
                                ?>
                                <div class="col-xs-12 col-sm-4 col-md-3">
                                    <div class="row">
                                        <div class="col-sm-4 col-xs-12 text-center-xs text-left-md text-left-lg">
                                            <div class="img-block">
                                                <?php if( $photo = get_the_post_thumbnail( $people->ID, 'full', array(
                                                    'class' => outdoor_retina_class(),
                                                    'alt'   => $people->post_title
                                                ) ) )
                                                    echo $photo; ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-8 col-xs-12 text-left-sm text-left-md text-left-lg">
                                            <h4><?php echo get_the_title( $people->ID ); ?></h4>
                                            <p class="profession"><?php echo $proff; ?></p>
                                            <p class="text-post"><?php echo strip_tags( $people->post_content ); ?></p>
                                            <div class="clearfix"></div>
                                            <?php if( $email ) : ?>
                                                <div class="info-contacts mail"><span>Email: </span><?php echo $email; ?></div>
                                            <?php endif; ?>
                                            <?php if( $phone ) : ?>
                                                <div class="info-contacts phone"><span>Phone: </span><?php echo $phone; ?></div>
                                            <?php endif; ?>
                                            <?php if( $skype ) : ?>
                                                <div class="info-contacts skype"><span>Skype: </span><?php echo $skype; ?></div>
                                            <?php endif; ?>
                                            <?php outdoor_people_social_buttons( $people->ID ); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <?php wp_reset_postdata(); ?>

                        </div>
                        <div class="clearfix"></div>
                        <div class="slider-nav">
                            <button class="prev"><i class="fa fa-angle-left"></i></button>
                            <button class="next"><i class="fa fa-angle-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>

        <?php endif; ?>
    <!-- / Team -->

    <?php endif; ?>

<?php // Start php code
    return ob_get_clean();
}
add_shortcode( 'team', 'outdoor_team_shortcode' );

/***************************************************************************************
 * Portfolio shortcode
 **************************************************************************************/
function outdoor_portfolio_shortcode( $atts, $content = '' ) {

    extract( shortcode_atts( array(
        'limit' => 10
    ), $atts ) );

    $args = array(
        'numberposts'   =>  $limit,
        'post_type'     =>  'od-portfolio',
        'suppress_filters'  =>  false,
    );

    $portfolios = get_posts( $args );
    $portfolio_categories = get_terms( 'portfolio-category' );

    ob_start();
// End php code ?>

    <?php if( $portfolios ) : ?>

    <!-- PORTFOLIO -->
    <div class="portfolio">

        <div id="filters" class="button-group isotop-filters">
            <button class="button is-checked" data-filter="*">All</button>

            <?php if( $portfolio_categories ) : ?>
                <?php foreach( $portfolio_categories as $cat ) : ?>
                    <button class="button" data-filter=".<?php echo esc_attr( $cat->slug ); ?>"><?php echo $cat->name; ?></button>
                <?php endforeach; ?>
            <?php endif; ?>

            <span id="back-top"></span>
        </div>

        <div class="sliders">
            <div class="sliders-preloader">
                <div class="full-width">
                    <div class="pre-img"></div>
                </div>
            </div>
            <div class="row">
                <!-- Sliders -->
                <div class="container">

                    <!-- top nav -->
                    <div class="a-slider-tcontrols album-controls row">
                        <a href="#filters" class="prev p-scroll">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a href="#portfolio" class="a-sliders-close">
                            <i class="fa fa-times"></i>
                        </a>
                        <a href="#filters" class="next p-scroll">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>

                    <!-- albums sliders -->
                    <div id="albom" class="album-sliders-container"></div>

                    <!-- bottom nav -->
                    <div class="a-slider-bcontrols album-controls row">
                        <a href="#filters" class="prev p-scroll">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a href="#portfolio" class="a-sliders-close">
                            <i class="fa fa-times"></i>
                        </a>
                        <a href="#filters" class="next p-scroll">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- /Slider -->
            </div>
        </div>

        <div class="isotope">

            <?php if( $portfolios ) : ?>
                <?php foreach( $portfolios as $portfolio ) :

                    $thumb = get_the_post_thumbnail( $portfolio->ID, 'full', array(
                        'class' => outdoor_retina_class(),
                        'alt'   => $portfolio->post_title
                    ) );
                    $portf_cats         = wp_get_post_terms( $portfolio->ID, 'portfolio-category' );
                    $portf_cats_names   = '';
                    $portf_cats_slugs   = '';
                    foreach( $portf_cats as $pCat ) {
                        $portf_cats_names .= $pCat->name . ',';
                        $portf_cats_slugs .= $pCat->slug . ' ';
                    }
                    $portf_cats_names = trim( $portf_cats_names, ',' );

                    ?>

                    <div data-albumid="<?php echo esc_attr( $portfolio->ID ); ?>" class="element-item <?php echo esc_attr( $portf_cats_slugs ); ?>">
                        <a class="p-scroll" href="#filters">
                            <?php if( $thumb ) : ?>
                                <?php echo $thumb; ?>
                            <?php endif; ?>
                            <div class="overlay">
                                <img class="p-target" src="<?php echo OUTDOOR_TPL_URI; ?>/assets/images/target.svg" alt="<?php echo esc_attr( $portfolio->post_title ); ?>">
                                <div class="p-title">
                                    <h3 class="name"><?php echo $portfolio->post_title; ?><br><span><?php echo $portf_cats_names; ?></span></h3>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
                <?php wp_reset_postdata(); ?>
            <?php endif; ?>

        </div><!-- /isotope -->
    
    </div>
    <!-- / PORTFOLIO -->

    <?php endif; ?>

<?php // Start php code
    return ob_get_clean();
}
add_shortcode( 'portfolio', 'outdoor_portfolio_shortcode' );

/***************************************************************************************
 * Services shortcode
 **************************************************************************************/
function outdoor_services_shortcode( $atts, $content = '' ) {

    extract( shortcode_atts( array(
        'ids'   => '',
        'limit' => 10,
        'type'  => 'slider'
    ), $atts ) );

    $args = array(
        'numberposts'   =>  $limit,
        'post_type'     =>  'od-service',
        'suppress_filters'  =>  false,
    );

    if( '' != $ids ) {
        $array_ids = explode( ',', $ids );
        $args['post__in'] = $array_ids;
    }
    $services = get_posts( $args );

    $show_type = ( 'box' == $type ) ? 'box' : $type;

    ob_start();
// End php code ?>

    <?php if( $services ) : ?>
        <!-- SERVICES -->
        <?php if( 'slider' == $show_type ) : // If show type slider ?>

            <div class="row wrapper-carusel carusel-4 services-slider">
                <div class="list-carousel responsive slider-foo-4">
                    <div class="preloader">
                        <div class="preload-img"></div>
                    </div>

                    <div class="carousel-box foo4" data-item-max="4">

                        <?php foreach( $services as $service ) :
                            $icon_name = ( get_field( 'icon_name', $service->ID ) ) ? get_field( 'icon_name', $service->ID ) : '';
                            ?>
                        <div class="col-xs-12 col-sm-4 col-md-3">
                            <?php if( $icon_name ) : ?>
                                <div class="img-block">
                                    <span class="small-icon" style="width:64px; height:64px;">
                                        <img src="<?php echo OUTDOOR_ASSETS_URI; ?>/images/small-icons/<?php echo $icon_name; ?>.svg" alt="<?php echo esc_attr( $icon_name ); ?>">
                                    </span>
                                </div>
                            <?php endif; ?>
                            <h6><a href="#"><?php echo get_the_title( $service->ID ); ?></a></h6>
                            <p><?php echo $service->post_content; ?></p>
                        </div>
                        <?php endforeach; ?>
                        <?php wp_reset_postdata(); ?>

                    </div>
                </div>
                <button class="prev"><i class="fa fa-angle-left"></i></button>
                <button class="next"><i class="fa fa-angle-right"></i></button>

            </div> <!-- /carusel-4 -->

        <?php else : // If show type box ?>

            <div class="row text-center services-grid">

                <?php $iterator = 0; ?>
                <?php foreach( $services as $service ) :
                    $icon_name = ( get_field( 'icon_name', $service->ID ) ) ? get_field( 'icon_name', $service->ID ) : '';
                    $first_class = ( $iterator == 0 || $iterator % 3 == 0 ) ? 'first': '';
                    ?>
                    <div class="col-xs-12 col-sm-4 <?php echo esc_attr( $first_class ); ?>">
                        <?php if( $icon_name ) : ?>
                            <div class="img-block">
                                <span class="small-icon appear-block" data-appear-animation="wobble">
                                    <img src="<?php echo OUTDOOR_ASSETS_URI; ?>/images/small-icons/<?php echo $icon_name; ?>.svg" alt="<?php echo esc_attr( $icon_name ); ?>">
                                </span>
                            </div>
                        <?php endif; ?>
                        <h6 class="appear-block" data-appear-animation="bounceInUp"><?php echo get_the_title( $service->ID ); ?></h6>
                        <p  class="appear-block" data-appear-animation="bounceInUp"><?php echo $service->post_content; ?></p>
                    </div>
                    <?php $iterator++; ?>
                <?php endforeach; ?>

            </div>

        <?php endif; // End if $show_type ?>
        <!-- / SERVICES -->
    <?php endif; ?>

    <?php // Start php code
    return ob_get_clean();
}
add_shortcode( 'services', 'outdoor_services_shortcode' );

/***************************************************************************************
 * Lightbox slider shortcode
 **************************************************************************************/
function outdoor_lightbox_slider_shortcode( $atts, $content = '' ) {

    extract( shortcode_atts( array(), $atts ) );

    ob_start();
// End php code ?>

    <div class="wrapper-carusel inpost-slider">
        <div class="carusel-3">
            <div class="row list-carousel responsive slider-foo-3">
                <div class="preloader">
                    <div class="preload-img"></div>
                </div>
                <div class="carousel-box foo3">
                    <?php echo do_shortcode( $content ); ?>
                </div>
            </div>
        </div>
        <button class="prev"><i class="fa fa-angle-left"></i></button>
        <button class="next"><i class="fa fa-angle-right"></i></button>
    </div><!-- /carousel -->

    <?php // Start php code
    return ob_get_clean();
}
add_shortcode( 'lightbox_slider', 'outdoor_lightbox_slider_shortcode' );

/***************************************************************************************
 * Lightbox slider item shortcode
 **************************************************************************************/
function outdoor_lightbox_slider_item_shortcode( $atts, $content = '' ) {

    extract( shortcode_atts( array(
        'title'     => '',
        'img'       => '',
        'img_mini'  => '',
        'width'     => '',
        'height'    => '',
    ), $atts ) );

    $img_mini   = ( '' != $img_mini )   ? $img_mini : $img;
    $width      = ( '' != $width )      ? ' width="' . esc_attr( $width ) . '"' : '';
    $height     = ( '' != $height )     ? ' height="' . esc_attr( $height ) . '"' : '';

    static $number = 0; $number++;
    ob_start();
// End php code ?>

    <?php if( $img != '' ) : ?>
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-12">
                <div class="img-block">
                    <a class="fancybox" rel="group-<?php echo esc_attr( $number ); ?>" href="<?php echo esc_url( $img ); ?>" title="<?php echo esc_attr( $title ); ?>">
                        <img class="<?php echo outdoor_retina_class(); ?>" src="<?php echo esc_url( $img_mini ); ?>" <?php echo $width, $height; ?> alt="<?php echo esc_attr( $title ); ?>">
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php // Start php code
    return ob_get_clean();
}
add_shortcode( 'lightbox_slider_item', 'outdoor_lightbox_slider_item_shortcode' );

/***************************************************************************************
 * Lightbox image shortcode
 **************************************************************************************/
function outdoor_lightbox_img_shortcode( $atts, $content = '' ) {

    extract( shortcode_atts( array(
        'title'     => '',
        'img'       => '',
        'img_mini'  => '',
        'width'     => '',
        'height'    => '',
        'img_style' => '',
        'group'     => ''
    ), $atts ) );

    $img_mini   = ( '' != $img_mini )   ? $img_mini : $img;
    $width      = ( '' != $width )      ? ' width="' . esc_attr( $width ) . '"' : '';
    $height     = ( '' != $height )     ? ' height="' . esc_attr( $height ) . '"' : '';
    $group      = ( '' != $group )      ? 'rel="' . esc_attr( $group ) . '"' : '';

    switch( $img_style ) {
        case 'rounded': $img_style = ' img-rounded'; break;
        case 'circle':  $img_style = ' img-circle'; break;
        case 'thumb':   $img_style = ' img-thumbnail'; break;
        default: $img_style = '';
    }

    ob_start();
// End php code ?>

    <?php if( $img != '' ) : ?>
        <a class="fancybox" <?php echo $group; ?> href="<?php echo esc_url( $img ); ?>" title="<?php echo esc_attr( $title ); ?>">
            <img class="<?php echo outdoor_retina_class(), esc_attr( $img_style ); ?>" src="<?php echo esc_url( $img_mini ); ?>" <?php echo $width, $height; ?> alt="<?php echo esc_attr( $title ); ?>">
        </a>
    <?php endif; ?>

    <?php // Start php code
    return ob_get_clean();
}
add_shortcode( 'lightbox_img', 'outdoor_lightbox_img_shortcode' );

/***************************************************************************************
 * Animate shortcode
 **************************************************************************************/
function outdoor_animate_shortcode( $atts, $content = '' ) {

    extract( shortcode_atts( array(
        'type'     => 'bounceInUp',
    ), $atts ) );

    ob_start();
// End php code ?>

    <?php if( '' != $type ) : ?>
    <div class="appear-block" data-appear-animation="<?php echo esc_attr( $type ); ?>"><?php echo do_shortcode( $content ); ?></div>
    <?php endif; ?>
    <?php // Start php code
    return ob_get_clean();
}
add_shortcode( 'animate', 'outdoor_animate_shortcode' );

/***************************************************************************************
 * Button shortcode
 **************************************************************************************/
function outdoor_button_shortcode( $atts, $content = '' ) {

    extract( shortcode_atts( array(
        'id'        => '',
        'class'     => '',
        'label'     => '',
        'link'      => '#'
    ), $atts ) );

    ob_start();
// End php code ?>

    <?php if( '' != $label ) : ?>
        <a <?php echo ( '' != $id ) ? 'id="' . esc_attr( $id ) . '"' : ''; ?> class="btn-default <?php echo esc_attr( $class ); ?>" href="<?php echo esc_url( $link ); ?>"><?php echo $label; ?></a>
    <?php endif; ?>
    <?php // Start php code
    return ob_get_clean();
}
add_shortcode( 'button', 'outdoor_button_shortcode' );