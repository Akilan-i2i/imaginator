
<div id="post-<?php the_ID(); ?>" <?php post_class( 'col-xs-12 posts' ); ?>>

    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

    <div class="entry-content">
        <?php
        // Show the post content
        the_content(); ?>

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

</div><!-- andPosts -->