<?php get_header(); ?>

    <!-- BLOG -->
    <div class="container" id="blog">
    <div class="row" >

    <div class="col-sm-12 col-md-8" id="block-posts">

        <div class="row">

            <h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'outdoor' ), get_search_query() ); ?></h1>

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

    <div class="col-sm-hidden col-md-1"></div>

    <?php
    // Get the default sidebar
    get_sidebar(); ?>

    </div><!-- /row -->
    </div><!-- /BLOG -->

    <div class="clearfix"></div>

<?php get_footer(); ?>