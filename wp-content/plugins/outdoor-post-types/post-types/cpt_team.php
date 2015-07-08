<?php

/***************************************************************************************
 * Register custom post type Team
 **************************************************************************************/
function outdoor_post_type_team() {
    $labels = array(
        'name'               => __( 'Team', 'outdoor' ),
        'singular_name'      => __( 'Team Item', 'outdoor' ),
        'add_new'            => __( 'Add New Item', 'outdoor' ),
        'add_new_item'       => __( 'Add New Team Item', 'outdoor' ),
        'edit_item'          => __( 'Edit Team Item', 'outdoor' ),
        'new_item'           => __( 'Add New Team Item', 'outdoor' ),
        'view_item'          => __( 'View Item', 'outdoor' ),
        'search_items'       => __( 'Search Team', 'outdoor' ),
        'not_found'          => __( 'No team items found', 'outdoor' ),
        'not_found_in_trash' => __( 'No team items found in trash', 'outdoor' )
    );

    $args = array(
        'labels'          => $labels,
        'public'          => true,
        'show_ui'         => true,
        'supports'        => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'author', 'custom-fields', 'revisions' ),
        'capability_type' => 'post',
        'hierarchical'    => false,
        'rewrite'         => array( 'slug' => 'team', 'with_front' => false ),
        'menu_position'   => '21.622',
        'has_archive'     => false
    );

    register_post_type( 'od-team', $args );
}
add_action( 'init', 'outdoor_post_type_team' );