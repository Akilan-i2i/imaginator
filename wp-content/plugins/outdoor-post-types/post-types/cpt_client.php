<?php

/***************************************************************************************
 * Register custom post type Client
 **************************************************************************************/
function outdoor_post_type_client() {
    $labels = array(
        'name'               => __( 'Clients', 'outdoor' ),
        'singular_name'      => __( 'Client Item', 'outdoor' ),
        'add_new'            => __( 'Add New Item', 'outdoor' ),
        'add_new_item'       => __( 'Add New Client Item', 'outdoor' ),
        'edit_item'          => __( 'Edit Client Item', 'outdoor' ),
        'new_item'           => __( 'Add New Client Item', 'outdoor' ),
        'view_item'          => __( 'View Item', 'outdoor' ),
        'search_items'       => __( 'Search Client', 'outdoor' ),
        'not_found'          => __( 'No client items found', 'outdoor' ),
        'not_found_in_trash' => __( 'No client items found in trash', 'outdoor' )
    );

    $args = array(
        'labels'          => $labels,
        'public'          => true,
        'show_ui'         => true,
        'supports'        => array( 'title', 'thumbnail', 'revisions' ),
        'capability_type' => 'post',
        'hierarchical'    => false,
        'rewrite'         => array( 'slug' => 'client', 'with_front' => false ),
        'menu_position'   => '21.1',
        'has_archive'     => false
    );

    register_post_type( 'od-client', $args );
}
add_action( 'init', 'outdoor_post_type_client' );

/***************************************************************************************
 * Add column shortcode to admin screen
 **************************************************************************************/
function outdoor_client_schortcode_column( $columns ) {
    $new_column = array( 'shortcode' => __( 'Shortcode', 'outdoor' ) );
    $columns = array_slice( $columns, 0, 2 ) + $new_column + array_slice( $columns, 1 );
    return $columns;
}

function outdoor_client_schortcode_column_content( $column ) {
    if ( 'shortcode' == $column ) {
        echo '[clients id="' . get_the_ID() . '"]';
    }
}

//add_filter( 'manage_od-client_posts_columns', 'outdoor_client_schortcode_column', 10, 1 );
//add_action( 'manage_od-client_posts_custom_column', 'outdoor_client_schortcode_column_content', 10, 1 );