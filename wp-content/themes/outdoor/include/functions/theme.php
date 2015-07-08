<?php

/***************************************************************************************
 * Stylize the comment form
 **************************************************************************************/

// insert html to before form
function outdoor_comment_form_before() {
// End php code ?>

    <div id="success"></div>
    <div class="row">

<?php // Start php code
}
add_action( 'comment_form_top', 'outdoor_comment_form_before' );

// insert html to after form
function outdoor_comment_form_after() {
// End php code ?>

    </div> <!-- /row -->

<?php // Start php code
}
add_action( 'comment_form', 'outdoor_comment_form_after' );

/***************************************************************************************
 * Custom template output comment
 *
 * Used how argument the function wp_list_comments()
 * 'calback' => 'outdoor_comment_template'
 **************************************************************************************/
if( !function_exists( 'outdoor_comment_template' ) ) :
    function outdoor_comment_template( $comment, $args, $depth ) {
        $GLOBALS['comment'] = $comment;
    // End php code ?>

        <li <?php comment_class( '' ); ?> id="li-comment-<?php comment_ID() ?>">
            <div id="comment-<?php comment_ID(); ?>">
                <?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>

                <div class="meta">
                    <?php printf( __( '<cite class="fn">%s</cite>' ), get_comment_author() ); ?>
                    <?php
                    /* translators: 1: date, 2: time */
                    printf( __( '<time> &nbsp;&mdash; &nbsp; %1$s at %2$s</time>' ), get_comment_date(),  get_comment_time() ); ?><?php edit_comment_link( __( '(Edit)' ), '&nbsp;&nbsp;', '' );
                    ?>
                    <?php
                    comment_reply_link( array_merge( $args, array(
                        'depth'     => $depth,
                        'max_depth' => $args['max_depth'],
                        'before'    => '',
                        'after'     => ''
                    ) ) );
                    ?>
                </div>

                <?php if ( '0' == $comment->comment_approved ) : ?>
                    <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ) ?></em>
                    <br>
                <?php endif; ?>

                <?php comment_text( get_comment_id(), array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>

            </div>

    <?php // Start php code
    }
endif;

/***************************************************************************************
 * Get comments nav
 **************************************************************************************/
if( !function_exists( 'outdoor_comment_nav' ) ) :
    function outdoor_comment_nav() {
        if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
            ?>
            <nav class="navigation comment-navigation" role="navigation">
                <div class="nav-links">
                    <?php
                    if ( $prev_link = get_previous_comments_link( __( 'Older Comments', 'outdoor' ) ) ) {
                        printf( '<div class="nav-previous"><i class="fa fa-angle-left"></i>%s</div>', $prev_link );
                    }
                    if ( $next_link = get_next_comments_link( __( 'Newer Comments', 'outdoor' ) ) ) {
                        printf( '<div class="nav-next">%s<i class="fa fa-angle-right"></i></div>', $next_link );
                    }
                    ?>
                </div><!-- //nav-links -->
            </nav><!-- //comment-navigation -->
        <?php
        endif;
    }
endif;
/***************************************************************************************
 * Show the post meta info
 **************************************************************************************/
if( !function_exists('outdoor_post_meta') ) :
    function outdoor_post_meta( $post_id = null, $small = false ) {
        global $post;

        if( $post_id != null )
            $post = get_post( $post_id );

        $return_html = '';
        if( !$small ) {
            $return_html .= '<div class="entry-meta">';
        }

        $author_id = $post->post_author;
        $return_html .= __( sprintf( 'Posted on %1$s by %2$s',
            '<a href="' . esc_url( get_permalink( $post->ID ) ) . '">' . get_the_date( '', $post ) . '</a>',
            '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID', $author_id ) ) ) . '">' . get_the_author_meta( 'nicename', $author_id ) . '</a>' ), 'outdoor' );

        if( !$small ) {
            $categories_list = get_the_category_list( ', ' );
            if ( $categories_list ) {
                $return_html .= '&nbsp; &mdash; &nbsp;' . $categories_list;
            }

            $tags_list = get_the_tag_list( '', ', ' );
            if ( $tags_list ) {
                $return_html .= '<span class="tags-links">&nbsp; &mdash; &nbsp;' . $tags_list . '</span>';
            }
            $return_html .= '</div>';
        }

        echo $return_html;

        if ( /*! is_single() && */ !$small && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
            echo '<div class="comments-link">&nbsp; &mdash; &nbsp;';
            comments_popup_link( __( 'Leave a comment', 'outdoor' ), __( '1 Comment', 'outdoor' ), __( '% Comments', 'outdoor' ) );
            echo '</div>';
        }
    }
endif;

/***************************************************************************************
 * Output the page navigation
 **************************************************************************************/
if( !function_exists( 'outdoor_pagenav' ) ) :
    function outdoor_pagenav() {
        global $wp_query;

        $big_num = 999999999;
        $max = $wp_query->max_num_pages;
        if ( ! $current = get_query_var('paged') ) $current = 1;

        $pager_args = array(
            'base'      =>  str_replace( $big_num, '%#%', get_pagenum_link( $big_num ) ),
            'total'     =>  $max,
            'current'   =>  $current,
            'mid_size'  =>  3,
            'end_size'  =>  1,
            'prev_text' =>  '<i class="fa fa-angle-left"></i> ' . __( 'Prev', 'outdoor' ),
            'next_text' =>  __( 'Next', 'outdoor' ) . '<i class="fa fa-angle-right pagination-next"></i>',
            'type'      =>  'list'
        );

        $pagination = paginate_links( $pager_args );
        $pagination = preg_replace( '/page-numbers/Ui', 'pagination', $pagination, 1 );

    ?>

        <div class="col-xs-12 ">
            <div class="pagination-box">
                <?php echo $pagination; ?>
            </div>
        </div><!-- .pagination -->

    <?php
    }
endif;

/***************************************************************************************
 * Add the class .btn-default for read more link
 **************************************************************************************/
function outdoor_more_link( $link ) {
    $link = preg_replace( '/more-link/', 'more-link btn-default', $link );
    return $link;
}
add_filter( 'the_content_more_link', 'outdoor_more_link' );

/***************************************************************************************
 * Add class .collapsed for parent nav elements
 **************************************************************************************/
function outdoor_has_sub( $menu_item_id, &$items ){
    foreach ( $items as $item ) {
        if ( $item->menu_item_parent && $item->menu_item_parent == $menu_item_id ) {
            return true;
        }
    }
    return false;
}

function outdoor_css_for_nav_parrent( $items ){
    foreach( $items as &$item ){
        if( outdoor_has_sub( $item->ID, $items ) ){
            $item->classes[] = 'collapsed';
        }
    }
    return $items;
}
add_filter('wp_nav_menu_objects', 'outdoor_css_for_nav_parrent');

/***************************************************************************************
 * Search results only post
 **************************************************************************************/
if( !function_exists( 'outdoor_search_filter' ) ) :
    function outdoor_search_filter($query) {
        if ( !is_admin() && $query->is_main_query() ) {
            if ($query->is_search) {
                $query->set( 'post_type', array( 'post' ) );
            }
        }
    }
    add_action( 'pre_get_posts', 'outdoor_search_filter' );
endif;
/***************************************************************************************
 * Get the social buttons
 **************************************************************************************/
if( !function_exists( 'outdoor_social_buttons' ) ) :
    function outdoor_social_buttons( $with_bg = false ) {
        global $outdoor_opt;
        $social_buttons = ( isset( $outdoor_opt['od-social-buttons'] ) ) ? $outdoor_opt['od-social-buttons'] : array();
        $bg = ( true === $with_bg ) ? ' bg' : '';

        if( $social_buttons ) {
            echo '<div class="block-inline text-center soc-icon ' . esc_attr( $bg ) . '">';
            foreach( $social_buttons as $name => $val ) {
                $url = $val['url'];
                if( '' == $url ) continue;

                if( ( 'custom' == substr( $name, 0, 6 ) ) ) {
                    $icon   = '<span class="custom-icon" style="background-image: url(' . esc_url( $val['img_url'] ) . ');"></span>';
                } else {
                    $icon   = '<i class="fa fa-' . esc_attr( $name ) . '"></i>';
                }
                ?>

                <div class="wrap-button"><a href="<?php echo esc_url( $url ); ?>" class="<?php echo esc_attr( $name ); ?>"><?php echo $icon; ?></a></div>
      <?php } // end foreach
            echo '</div>';
        }
    }
endif;

/***************************************************************************************
 * Get the share buttons
 **************************************************************************************/
if( !function_exists( 'outdoor_share_buttons' ) ) :
    function outdoor_share_buttons() {
        global $outdoor_opt;
        $share_buttons = ( isset( $outdoor_opt['od-getshare-buttons'] ) ) ? $outdoor_opt['od-getshare-buttons'] : array(); ?>

        <?php if( $share_buttons ) : ?>
        <div class="social-inp">
            <?php foreach( $share_buttons as $btn => $enable ) :
                if( 'on' !== $enable ) continue;
                switch( $btn ) {
                    case 'fb': $social_name = 'facebook'; break;
                    case 'tw': $social_name = 'twitter'; break;
                    case 'gp': $social_name = 'googleplus'; break;
                    case 'pt': $social_name = 'pinterest'; break;
                    case 'in': $social_name = 'linkedin'; break;
                    case 'vk': $social_name = 'vk'; break;
                    case 'st': $social_name = 'stumbleupon'; break;
                    default:   $social_name = '';
                } ?>
            <a href="#" class="shared-btn gt-<?php echo esc_attr( $btn ); ?>" data-network="<?php echo esc_attr( $social_name ); ?>"></a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

<?php // Start php code
    }
endif;

/***************************************************************************************
 * Get the people social buttons
 **************************************************************************************/
if( !function_exists( 'outdoor_people_social_buttons' ) ) :
    function outdoor_people_social_buttons( $people_id = null ) {

        if( !$people_id )
            return;

        $social_buttons = ( get_field( 'social_btns', $people_id ) ) ? get_field( 'social_btns', $people_id ) : ''; ?>

        <?php if( $social_buttons ) : ?>
        <div class="block-inline soc-icon">
            <?php foreach( $social_buttons as $btn => $link ) :
                if( '' === $link ) continue;
                switch( $btn ) {
                    case 'fb': $social_name = 'facebook'; break;
                    case 'tw': $social_name = 'twitter'; break;
                    case 'gp': $social_name = 'google-plus'; break;
                    case 'pt': $social_name = 'pinterest'; break;
                    case 'in': $social_name = 'linkedin'; break;
                    case 'vk': $social_name = 'vk'; break;
                    case 'st': $social_name = 'stumbleupon'; break;
                    default:   $social_name = '';
                } ?>
            <div class="wrap-button">
                <a href="<?php echo esc_url( $link ); ?>" class="<?php echo esc_attr( $social_name ); ?>" target="_blank">
                    <i class="fa fa-<?php echo esc_attr( $social_name ); ?>"></i>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

<?php // Start php code
    }
endif;

/***************************************************************************************
 * Add retina class
 **************************************************************************************/
function outdoor_retina_class() {
    global $outdoor_opt;
    $retina_support = ( isset( $outdoor_opt['od-retina-support'] ) ) ? $outdoor_opt['od-retina-support'] : false;
    if( $retina_support ) {
        return 'replace-2x';
    }
}

/***************************************************************************************
 * Show wpml language switcher
 **************************************************************************************/
if( !function_exists( 'outdoor_wpml_switcher' ) ) :
    function outdoor_wpml_switcher() {
        global $outdoor_opt;
        $show_langs_switcher = ( isset( $outdoor_opt['od-enable-switcher'] ) ) ? $outdoor_opt['od-enable-switcher'] : false;

        // if wpml activated and show switcher enabled
        if( function_exists( 'icl_object_id' ) && $show_langs_switcher ) {
            $languages = icl_get_languages('skip_missing=0');
            uasort( $languages, function($a, $b) {
                if ( $a['active'] == $b['active'] ) {
                    return 0;
                }
                return ( $a['active'] < $b['active'] ) ? 1 : -1;
            });
    ?>
            <?php if( is_array( $languages ) && !empty( $languages ) ) : ?>
            <div class="btn-group" id="languages">
                <button type="button" class="dropdown-toggle" data-toggle="dropdown"><?php echo ICL_LANGUAGE_CODE; ?></button>
                <ul class="dropdown-menu" role="menu">
                    <?php foreach( $languages as $lang ) : ?>
                        <li><a href="<?php echo esc_url( $lang['url'] ); ?>"><?php echo $lang['language_code']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

    <?php
        }
    }
endif;