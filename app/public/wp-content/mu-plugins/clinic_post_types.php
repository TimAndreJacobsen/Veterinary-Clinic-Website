<?php

function clinic_post_types()
{
    // Event Post Type
    register_post_type('event', array(
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-layout',
        'supports' => array(
            'title', 'editor', 'excerpt'
        ),
        'rewrite' => array('slug' => 'events'),
        'labels' => array(
            'name' => 'Events',
            'add_new_item' => 'Add new Event',
            'edit_item' => 'Edit Event',
            'all_items' => 'All Events',
            'singular_name' => 'Event',
        )
    ));

    // Treatment Post Type
    register_post_type('treatment', array(
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-heart',
        'supports' => array(
            'title', 'editor'
        ),
        'rewrite' => array('slug' => 'treatments'),
        'labels' => array(
            'name' => 'Treatments',
            'add_new_item' => 'Add new Treatment',
            'edit_item' => 'Edit Treatment',
            'all_items' => 'All Treatments',
            'singular_name' => 'Treatment',
        )
    ));
}

add_action('init', 'clinic_post_types');
