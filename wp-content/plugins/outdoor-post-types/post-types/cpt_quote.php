<?php

/***************************************************************************************
 * Register custom post type Quote
 **************************************************************************************/
function outdoor_post_type_quote() {
    $labels = array(
        'name'               => __( 'Quotes', 'outdoor' ),
        'singular_name'      => __( 'Quote Item', 'outdoor' ),
        'add_new'            => __( 'Add Quote Item', 'outdoor' ),
        'add_new_item'       => __( 'Add New Quote Item', 'outdoor' ),
        'edit_item'          => __( 'Edit Quote Item', 'outdoor' ),
        'new_item'           => __( 'Add New Quote Item', 'outdoor' ),
        'view_item'          => __( 'View Item', 'outdoor' ),
        'search_items'       => __( 'Search Quote', 'outdoor' ),
        'not_found'          => __( 'No quote items found', 'outdoor' ),
        'not_found_in_trash' => __( 'No quote items found in trash', 'outdoor' )
    );

    $args = array(
        'labels'          => $labels,
        'public'          => true,
        'show_ui'         => true,
        'supports'        => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'author', 'custom-fields', 'revisions' ),
        'capability_type' => 'post',
        'hierarchical'    => false,
        'rewrite'         => array( 'slug' => 'quote', 'with_front' => false ),
        'menu_position'   => '21.4',
        'has_archive'     => false
    );

    register_post_type( 'od-quote', $args );
}
add_action( 'init', 'outdoor_post_type_quote' );

/***************************************************************************************
 * Add column shortcode to admin screen
 **************************************************************************************/
function outdoor_quote_schortcode_column( $columns ) {
    $new_column = array( 'shortcode' => __( 'Shortcode', 'outdoor' ) );
    $columns = array_slice( $columns, 0, 2 ) + $new_column + array_slice( $columns, 1 );
    return $columns;
}

function outdoor_quote_schortcode_column_content( $column ) {
    if ( 'shortcode' == $column ) {
        echo '[quotes ids="' . get_the_ID() . '"]';
    }
}

//add_filter( 'manage_od-quote_posts_columns', 'outdoor_quote_schortcode_column', 10, 1 );
//add_action( 'manage_od-quote_posts_custom_column', 'outdoor_quote_schortcode_column_content', 10, 1 );