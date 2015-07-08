<!-- COMMENTS -->
<div class="col-xs-12 " id="comments">

    <?php if( have_comments() ) : ?>
        <h2 class="comments-title">
            <?php
            printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'outdoor' ),
                number_format_i18n( get_comments_number() ), get_the_title() );
            ?>
        </h2>

        <ul class="comment-list">
            <?php
            wp_list_comments( array(
                'style'         =>  'ul',
                'type'          =>  'comment',
                'short_ping'    =>  true,
                'avatar_size'   =>  70,
                'callback'      =>  'outdoor_comment_template'
            ) );
            ?>
        </ul><!-- /comment-list -->

        <?php outdoor_comment_nav(); // Get comments navigation ?>

    <?php endif; // have_comments() ?>

    <?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
        <p class="no-comments"><?php _e( 'Comments are closed.', 'outdoor' ); ?></p>
    <?php endif; ?>

    <?php
    $commenter = wp_get_current_commenter();
    $fields =  array(
        'author' => '<div class="col-xs-12"><div class="row">' .
                    '<div class="col-xs-12 col-sm-6 form-field fix-left"><input type="text" name="author" value="' . esc_attr( $commenter['comment_author'] ) . '" placeholder="Name" onfocus="this.placeholder = \'\'" onblur="this.placeholder = \'Name\'"></div>',
        'email'  => '<div class="col-xs-12 col-sm-6 form-field fix-right"><input type="email" name="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" placeholder="Email" onfocus="this.placeholder = \'\'" onblur="this.placeholder = \'Email\'"></div>' .
                    '</div></div>',
        'url'    => '',
    );

    $comment_form_args = array(
        'fields'                =>  apply_filters( 'comment_form_default_fields', $fields ),
        'comment_field'         =>  '<div class="col-xs-12 form-field"><textarea class="form-control" name="comment" cols="30" rows="4" placeholder="Comment" onfocus="this.placeholder = \'\'" onblur="this.placeholder = \'Comment\'" style="width:100%;"></textarea></div>' .
                                    '<div class="clearfix"></div>',
        'must_log_in'           => '<div class="must-log-in col-xs-12 form-field">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post->ID ) ) ) ) . '</div>',
        'logged_in_as'          => '<div class="logged-in-as col-xs-12 form-field">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post->ID ) ) ) ) . '</div>',
        'comment_notes_before'  => '<div class="comment-notes col-xs-12 form-field"><span id="email-notes">' . __( 'Your email address will not be published.' ) . '</span></div>',
        'comment_notes_after'   => '<div class="form-allowed-tags col-xs-12 form-field" id="form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ), ' <code>' . allowed_tags() . '</code>' ) . '</div>',
        'id_form'               => 'commentform',
        'class_submit'          => 'btn-default',
        'submit_button'         => '<button name="%1$s" id="%2$s" class="%3$s btn-default">%4$s</button>',
        'submit_field'          => '<div class="col-xs-12 form-field">%1$s %2$s</div>',
    );
    ?>
    <?php
    // Show comment form
    comment_form( $comment_form_args ); ?>
</div><!-- /comments -->