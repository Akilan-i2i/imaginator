<?php

/***************************************************************************************
 * Register custom post type Pricetable
 **************************************************************************************/
function outdoor_post_type_price() {
    $labels = array(
        'name'               => __( 'Price table', 'outdoor' ),
        'singular_name'      => __( 'Price table Item', 'outdoor' ),
        'add_new'            => __( 'Add Price Item', 'outdoor' ),
        'add_new_item'       => __( 'Add New Price Item', 'outdoor' ),
        'edit_item'          => __( 'Edit Price Item', 'outdoor' ),
        'new_item'           => __( 'Add New Price Item', 'outdoor' ),
        'view_item'          => __( 'View Item', 'outdoor' ),
        'search_items'       => __( 'Search Price', 'outdoor' ),
        'not_found'          => __( 'No price items found', 'outdoor' ),
        'not_found_in_trash' => __( 'No price items found in trash', 'outdoor' )
    );

    $args = array(
        'labels'          => $labels,
        'public'          => true,
        'show_ui'         => true,
        'supports'        => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'author', 'custom-fields', 'revisions', 'page-attributes' ),
        'capability_type' => 'post',
        'hierarchical'    => false,
        'rewrite'         => array( 'slug' => 'price', 'with_front' => false ),
        'menu_position'   => '21.3',
        'has_archive'     => false
    );

    register_post_type( 'od-pricetable', $args );
}
add_action( 'init', 'outdoor_post_type_price' );