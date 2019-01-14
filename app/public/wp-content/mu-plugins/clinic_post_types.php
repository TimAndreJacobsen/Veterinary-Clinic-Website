<?php

function clinic_post_types()
{
    // Event Post Type
    register_post_type('event', array(
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-layout',
        'supports' => array(
            'title', 'editor', 'excerpt'
        ),
        'capability_type' => 'event',
        'map_meta_cap' => true,
        'rewrite' => array('slug' => 'events'),
        'labels' => array(
            'name' => 'Events',
            'add_new_item' => 'Add new Event',
            'edit_item' => 'Edit Event',
            'all_items' => 'Events',
            'singular_name' => 'Event',
        )
    ));

    // Treatment Post Type
    register_post_type('treatment', array(
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-heart',
        'supports' => array(
            'title', 'editor'
        ),
        'capability_type' => 'treatment',
        'map_meta_cap' => true,
        'rewrite' => array('slug' => 'treatments'),
        'labels' => array(
            'name' => 'Treatments',
            'add_new_item' => 'Add new Treatment',
            'edit_item' => 'Edit Treatment',
            'all_items' => 'Treatments',
            'singular_name' => 'Treatment',
        )
    ));

    // Locale Post Type
    register_post_type('locale', array(
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-admin-multisite',
        'supports' => array(
            'title', 'thumbnail'
        ),
        'rewrite' => array('slug' => 'locales'),
        'labels' => array(
            'name' => 'Locales',
            'add_new_item' => 'Add new Locale',
            'edit_item' => 'Edit Locale',
            'all_items' => 'Locales',
            'singular_name' => 'Locale',
        )
    ));

    // Point of interest Post Type
    register_post_type('poi', array(
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-location-alt',
        'supports' => array(
            'title', 'editor',
        ),
        'capability_type' => 'poi',
        'map_meta_cap' => true,
        'rewrite' => array('slug' => 'poi'),
        'labels' => array(
            'name' => 'Point of Interest',
            'add_new_item' => 'Add new PoI',
            'edit_item' => 'Edit PoI',
            'all_items' => 'All PoIs',
            'singular_name' => 'Point of Interest',
        )
    ));

    // Employee Post Type
    register_post_type('employee', array(
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-groups',
        'supports' => array(
            'title', 'editor', 'thumbnail'
        ),
        'capability_type' => 'employee',
        'map_meta_cap' => true,
        'rewrite' => array('slug' => 'employees'),
        'labels' => array(
            'name' => 'Employees',
            'add_new_item' => 'Add new employee',
            'edit_item' => 'Edit employee',
            'all_items' => 'all employees',
            'singular_name' => 'employee',
        )
    ));

    // Pet Post Type
    register_post_type('pet', array(
        'public' => false, // setting this to false makes them private and hides from public queries and search results. But this also hides post_type in admin dashboard, fixed by show_ui => true
        'show_ui' => true, // Enabling pet post_type in admin dashboard
        'has_archive' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-format-aside',
        'supports' => array(
            'title', 'editor', 'thumbnail', 'author'
        ),
        'capability_type' => 'pet',
        'map_meta_cap' => true,
        'labels' => array(
            'name' => 'Pet',
            'add_new_item' => 'Add new pet',
            'edit_item' => 'Edit pet',
            'all_items' => 'all pets',
            'singular_name' => 'pet',
        )
    ));


    // Note Post Type
    register_post_type('note', array(
        'public' => false,
        'show_ui' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-welcome-write-blog',
        'supports' => array(
            'title', 'editor', 'author'
        ),
        'labels' => array(
            'name' => 'Notes',
            'add_new_item' => 'Add new note',
            'edit_item' => 'Edit note',
            'all_items' => 'all notes',
            'singular_name' => 'note',
        )
    ));

    // TODO: Add post_type Owner - which syncs up with a registered user  ??? Will this be necessary?
    // Cannot create a relationship between registered_user and pet_post_type. Relationship only avaliable between different post_types.
    // GOAL: For a owner to be able to track their pets online. For staff to be able to update information.
}

add_action('init', 'clinic_post_types');