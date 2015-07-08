<?php
/***************************************************************************************
 * The blog page template
 **************************************************************************************/

global $outdoor_opt;
$show_header        = ( isset( $outdoor_opt['od-blog-header'] ) ) ? $outdoor_opt['od-blog-header'] : false;
$header_bg_img      = ( isset( $outdoor_opt['od-blog-header-img']['url'] ) &&
                        $outdoor_opt['od-blog-header-img']['url'] != '' )
                        ? 'background-image: url( ' . $outdoor_opt['od-blog-header-img']['url'] . ');' : '';
$header_bg_color    = ( isset( $outdoor_opt['od-blog-header-color'] ) )
                        ? 'background-color: ' . $outdoor_opt['od-blog-header-color'] . ';' : '';
$header_title       = ( isset( $outdoor_opt['od-blog-header-title'] ) ) ? $outdoor_opt['od-blog-header-title'] : '';
$show_social_header = ( isset( $outdoor_opt['od-social-in-blog-header'] ) ) ? $outdoor_opt['od-social-in-blog-header'] : true;
$sidebar_position   = ( isset( $outdoor_opt['od-blog-sidebar-pos'] ) ) ? $outdoor_opt['od-blog-sidebar-pos'] : '';
switch( $sidebar_position ) {
    case 'left':    $sidebar_position = 'left'; break;
    case 'without': $sidebar_position = 'without'; break;
    default:        $sidebar_position = 'right';
}
?>

<?php get_header(); ?>

<?php if( $show_header ) : ?>
    <!--  BLOG SLIDER -->
    <div class="container-fluid inside-pages white" id="primary-banner">
        <div class="row">

            <!-- title-blogtop -->
            <div class="col-xs-12" id="primary-banner-title">
                <div class="inner-info-block">
                    <div class="block-center">
                        <h1><span class="title"><?php echo $header_title; ?></span><br>
                            <div class="line-soc-icon">
                                <?php if( $show_social_header ) : ?>
                                    <?php outdoor_social_buttons(); ?>
                                <?php else: ?>
                                    <style type="text/css">
                                        #primary-banner .line-soc-icon:after {
                                            display: none !important;
                                        }
                                        #primary-banner .line-soc-icon:before {
                                            width: 100% !important;
                                            margin: 0 !important;
                                            left: 0 !important;
                                        }
                                    </style>
                                <?php endif; ?>
                            </div>
                        </h1>
                    </div>
                </div>
            </div>
            <!-- / title-blogtop -->

            <!-- background-topslider -->
            <div class="background">
                <div class="layer" style="<?php echo esc_attr( $header_bg_img ), esc_attr( $header_bg_color ); ?>"></div>
            </div>
            <!-- / background-topslider -->

        </div>
    </div>
    <!--  / BLOG SLIDER -->
<?php endif; ?>

    <!-- BLOG -->
    <div class="container" id="blog">
        <div class="row" >

            <?php if( 'left' == $sidebar_position ) : ?>

                <?php
                // Get the default sidebar
                get_sidebar(); ?>

                <div class="col-sm-hidden col-md-1"></div>
            <?php endif; ?>

            <div class="col-sm-12 <?php echo ( 'without' == $sidebar_position ) ? 'col-md-12' : 'col-md-8'; ?>" id="block-posts">
                <div class="row">

                    <?php if( have_posts() ) : ?>

                        <?php
                        while( have_posts() ) : the_post();

                            // Load the page content template
                            get_template_part( 'content', get_post_format() );

                        endwhile;
                        ?>

                        <?php outdoor_pagenav(); ?>
                    <?php else: ?>
                        <?php
                        // Load template "No posts found" if no content.
                        get_template_part( 'content', 'none' ); ?>

                    <?php endif; // End if have_posts() ?>

                </div> <!-- /row -->
            </div><!-- /block-posts -->

            <?php if( 'right' == $sidebar_position ) : ?>

                <div class="col-sm-hidden col-md-1"></div>

                <?php
                // Get the default sidebar
                get_sidebar(); ?>
            <?php endif; ?>

        </div><!-- /row -->
    </div><!-- /BLOG -->

    <div class="clearfix"></div>

<?php get_footer(); ?>