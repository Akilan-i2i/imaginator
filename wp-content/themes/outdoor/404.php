<?php get_header(); ?>

    <div class="home" id="home"></div>

    <!-- BLOG -->
    <div class="container" id="blog">
    <div class="row" >

    <div class="col-sm-12 col-md-8" id="block-posts">

        <div class="row">

            <div class="error-404 not-found">
                <div class="page-header">
                    <h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'outdoor' ); ?></h1>
                </div><!-- .page-header -->

                <div class="page-content">
                    <p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'outdoor' ); ?></p>

                    <?php get_search_form(); ?>
                </div><!-- .page-content -->
            </div><!-- .error-404 -->

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