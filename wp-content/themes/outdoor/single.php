<?php get_header(); ?>

    <!-- nav-posts -->
    <div class="container" id="nav-posts">
        <div class="row text-center">
            <div class="pagination-box">
                <?php
                $blog_url = ( get_option( 'page_for_posts' ) ) ? get_permalink( get_option( 'page_for_posts' ) ) : '#'; ?>
                <ul class="pagination">
                    <li class="p-left"><?php previous_post_link( '%link', '<i class="fa fa-angle-left"></i>' . __( 'Prev post', 'outdoor' ) ); ?></li>
                    <li class="p-center"><a href="<?php echo esc_url( $blog_url ); ?>" class="pag-center"><i class="fa fa-th"></i></a></li>
                    <li class="p-right"><?php next_post_link( '%link', __( 'Next post', 'outdoor' ) . '<i class="fa fa-angle-right"></i>' ); ?></li>
                </ul>
            </div>
        </div>
    </div>  <!-- / nav-posts -->

    <!-- BLOG -->
    <div class="container" id="blog">
    <div class="row" >

    <div class="col-sm-12 col-md-8" id="block-posts">

        <div class="row">

            <?php
            while( have_posts() ) : the_post();

                // Load the page content template
                get_template_part( 'content', get_post_format() );

                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;

            endwhile;
            ?>

        </div> <!-- /row -->

    </div><!-- /block-posts -->

    <div class="col-sm-hidden col-md-1"></div>

    <?php
    // Get the default sidebar
    get_sidebar(); ?>

    </div><!-- /row -->
    </div><!-- /BLOG -->

    <div class="clearfix"></div>

<?php get_footer(); ?>