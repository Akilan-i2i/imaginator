<?php get_header(); ?>

    <!-- BLOG -->
    <div class="container" id="blog">
    <div class="row" >

    <div class="col-sm-12 col-md-8" id="block-posts">

        <div class="row">

            <?php
            while( have_posts() ) : the_post();

                // Load the page content template
                get_template_part( 'content', 'page' );

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