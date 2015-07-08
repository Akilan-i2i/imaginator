<?php

/***************************************************************************************
 * Register custom post type Portfolio
 **************************************************************************************/
function outdoor_post_type_portfolio() {

    // Register post type portfolio
    $labels = array(
        'name'               => __( 'Portfolio', 'outdoor' ),
        'singular_name'      => __( 'Portfolio Item', 'outdoor' ),
        'add_new'            => __( 'Add New Item', 'outdoor' ),
        'add_new_item'       => __( 'Add New Portfolio Item', 'outdoor' ),
        'edit_item'          => __( 'Edit Portfolio Item', 'outdoor' ),
        'new_item'           => __( 'Add New Portfolio Item', 'outdoor' ),
        'view_item'          => __( 'View Item', 'outdoor' ),
        'search_items'       => __( 'Search Portfolio', 'outdoor' ),
        'not_found'          => __( 'No portfolio items found', 'outdoor' ),
        'not_found_in_trash' => __( 'No portfolio items found in trash', 'outdoor' )
    );

    $args = array(
        'labels'          => $labels,
        'public'          => true,
        'show_ui'         => true,
        'supports'        => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'author', 'custom-fields', 'revisions' ),
        'capability_type' => 'post',
        'hierarchical'    => false,
        'rewrite'         => array( 'slug' => 'portfolio', 'with_front' => false ),
        'menu_position'   => '21.2',
        'has_archive'     => false,
    );

    register_post_type( 'od-portfolio', $args );

    // Register portfolio category taxonomy
    $taxonomy_portfolio_category_labels = array(
        'name'                       => __( 'Portfolio Categories', 'outdoor' ),
        'singular_name'              => __( 'Portfolio Category', 'outdoor' ),
        'search_items'               => __( 'Search Portfolio Categories', 'outdoor' ),
        'popular_items'              => __( 'Popular Portfolio Categories', 'outdoor' ),
        'all_items'                  => __( 'All Portfolio Categories', 'outdoor' ),
        'parent_item'                => __( 'Parent Portfolio Category', 'outdoor' ),
        'parent_item_colon'          => __( 'Parent Portfolio Category:', 'outdoor' ),
        'edit_item'                  => __( 'Edit Portfolio Category', 'outdoor' ),
        'update_item'                => __( 'Update Portfolio Category', 'outdoor' ),
        'add_new_item'               => __( 'Add New Portfolio Category', 'outdoor' ),
        'new_item_name'              => __( 'New Portfolio Category Name', 'outdoor' ),
        'separate_items_with_commas' => __( 'Separate portfolio categories with commas', 'outdoor' ),
        'add_or_remove_items'        => __( 'Add or remove portfolio categories', 'outdoor' ),
        'choose_from_most_used'      => __( 'Choose from the most used portfolio categories', 'outdoor' ),
        'menu_name'                  => __( 'Portfolio Categories', 'outdoor' ),
    );

    $taxonomy_portfolio_category_args = array(
        'labels'            => $taxonomy_portfolio_category_labels,
        'public'            => true,
        'show_in_nav_menus' => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_tagcloud'     => true,
        'hierarchical'      => true,
        'rewrite'           => array( 'slug' => 'portfolio-category', 'with_front' => false ),
        'query_var'         => true
    );

    register_taxonomy( 'portfolio-category', array( 'od-portfolio' ), $taxonomy_portfolio_category_args );
}
add_action( 'init', 'outdoor_post_type_portfolio' );