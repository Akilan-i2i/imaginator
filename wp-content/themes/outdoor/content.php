<?php
global $post;
$post_gallery   = ( get_field( 'gallery', $post->ID ) ) ? get_field( 'gallery', $post->ID ) : false;
$thumbnail_id   = get_post_thumbnail_id( $post->ID );
$thumbnail_url  = wp_get_attachment_url( $thumbnail_id );
?>

<div id="post-<?php the_ID(); ?>" <?php post_class( 'col-xs-12 posts' ); ?>>

    <?php
    if ( is_single() ) :
        the_title( '<h1 class="entry-title">', '</h1>' );
    else :
        the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
    endif;
    ?>

    <div class="post-info">
        <?php outdoor_post_meta(); ?>
    </div>
    <div class="clearfix"></div>

    <?php if( $post_gallery || $thumbnail_url ) : ?>

        <!-- carousel -->
        <div class="wrapper-carusel inpost-slider">
            <div class="carusel-3">
                <div class="row list-carousel responsive slider-foo-3 ">

                    <div class="preloader">
                        <div class="preload-img"></div>
                    </div>

                    <div class="carousel-box foo3">

                        <?php if( $thumbnail_url ) : ?>
                        <div class="col-xs-12">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="img-block">
                                        <a class="fancybox" rel="group<?php echo $post->ID; ?>" href="<?php echo esc_url( $thumbnail_url ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>">
                                            <img class="<?php echo outdoor_retina_class(); ?>" src="<?php echo esc_url( $thumbnail_url ); ?>" width="780" height="380" alt="<?php echo esc_attr( get_the_title() ); ?>">
                                        </a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if( $post_gallery ) : ?>
                            <?php foreach( $post_gallery as $photo ) : ?>
                                <div class="col-xs-12">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="img-block">
                                                <a class="fancybox" rel="group<?php echo $post->ID; ?>" href="<?php echo esc_url( $photo['url'] ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>">
                                                    <img class="<?php echo outdoor_retina_class(); ?>" src="<?php echo esc_url( $photo['url'] ); ?>" width="780" height="380" alt="<?php echo esc_attr( get_the_title() ); ?>">
                                                </a>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </div>

                </div>
            </div>
            <button class="prev prev3"><i class="fa fa-angle-left"></i></button>
            <button class="next next3"><i class="fa fa-angle-right"></i></button>
        </div><!-- /carousel -->

    <?php endif; ?>

    <div class="entry-content">
        <?php
        // Show the post content
        the_content( __( 'Read more', 'outdoor' ) . '<i class="fa fa-angle-right"></i>' ); ?>

        <?php wp_link_pages( array(
            'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'outdoor' ) . '</span>',
            'after'       => '</div>',
            'link_before' => '<span>',
            'link_after'  => '</span>',
            'pagelink'    => __( 'Page ', 'outdoor' ) . '%',
            'separator'   => ', ',
        ) ); ?>
    </div>

    <?php edit_post_link( __( 'Edit post', 'outdoor' ), '<div class="entry-footer"><span class="edit-link">', '</span></div><!-- /entry-footer -->' ); ?>

    <?php if( is_singular() ) : ?>
    <!-- Post-Soc-Icon -->
    <div class="post-soc-icon">
        <div class="count-shared text-center">
            <div class="quantity">0</div>
            <span><?php __( 'Shares', 'outdoor' ); ?></span>
        </div>

        <?php
        // Show GetShare social buttons
        outdoor_share_buttons(); ?>

    </div>
    <?php endif; ?>

</div><!-- andPosts -->