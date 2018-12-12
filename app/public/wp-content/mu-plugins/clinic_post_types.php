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
            'all_items' => 'Events',
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
            'all_items' => 'Treatments',
            'singular_name' => 'Treatment',
        )
    ));

    // Locale Post Type
    register_post_type('locale', array(
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-admin-multisite',
        'supports' => array(
            'title', 'editor'
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

    // Employee Post Type
    register_post_type('employee', array(
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-groups',
        'supports' => array(
            'title', 'editor', 'thumbnail'
        ),
        'rewrite' => array('slug' => 'employees'),
        'labels' => array(
            'name' => 'Employees',
            'add_new_item' => 'Add new employee',
            'edit_item' => 'Edit employee',
            'all_items' => 'all employees',
            'singular_name' => 'employee',
        )
    ));
}

add_action('init', 'clinic_post_types');