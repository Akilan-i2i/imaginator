<?php
/*
 * Template name: Without sidebar
 */
?>
<?php get_header(); ?>

    <div class="page-wrap container without-sidebar">

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

    </div>

    <div class="clearfix"></div>

<?php get_footer(); ?>