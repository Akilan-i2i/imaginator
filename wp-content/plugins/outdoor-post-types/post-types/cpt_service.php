<?php

/***************************************************************************************
 * Register custom post type Service
 **************************************************************************************/
function outdoor_post_type_service() {
    $labels = array(
        'name'               => __( 'Services', 'outdoor' ),
        'singular_name'      => __( 'Service Item', 'outdoor' ),
        'add_new'            => __( 'Add New Item', 'outdoor' ),
        'add_new_item'       => __( 'Add New Service Item', 'outdoor' ),
        'edit_item'          => __( 'Edit Service Item', 'outdoor' ),
        'new_item'           => __( 'Add New Service Item', 'outdoor' ),
        'view_item'          => __( 'View Item', 'outdoor' ),
        'search_items'       => __( 'Search Service', 'outdoor' ),
        'not_found'          => __( 'No service items found', 'outdoor' ),
        'not_found_in_trash' => __( 'No service items found in trash', 'outdoor' )
    );

    $args = array(
        'labels'          => $labels,
        'public'          => true,
        'show_ui'         => true,
        'supports'        => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'author', 'custom-fields', 'revisions' ),
        'capability_type' => 'post',
        'hierarchical'    => false,
        'rewrite'         => array( 'slug' => 'service', 'with_front' => false ),
        'menu_position'   => '21.5',
        'has_archive'     => false
    );

    register_post_type( 'od-service', $args );
}
add_action( 'init', 'outdoor_post_type_service' );