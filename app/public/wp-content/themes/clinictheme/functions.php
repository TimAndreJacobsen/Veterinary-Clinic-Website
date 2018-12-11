<?php

function clinic_resources()
{ /* function to load CSS and JavaScript */
    /* CSS */
    wp_enqueue_style('clinic_styles', get_stylesheet_uri());
    wp_enqueue_style('font_google_roboto', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font_awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    /* JavaScript */
    wp_enqueue_script('clinic_js', get_theme_file_uri('/js/scripts-bundled.js'), null, microtime(), true);
}

function clinic_features()
{
    /* Add title to pages */
    add_theme_support('title-tag');
    /* Add header menu to wp-admin */
    register_nav_menu('header_menu_location', 'Header Menu Location');
    register_nav_menu('footer_menu_location_left', 'Footer Menu Location Left');
    register_nav_menu('footer_menu_location_right', 'Footer Menu Location Right');
}

function clinic_custom_queries($query){
    /* Logic for sorting wp queries for post_type Locales */
    if (!is_admin() AND is_post_type_archive('locale') AND $query->is_main_query()) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);
    }

    /* Logic for sorting wp queries for post_type Treatment */
    if (!is_admin() AND is_post_type_archive('treatment') AND $query->is_main_query()) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);
    }

    /* Logic for sorting wp queries for post_type Event */
    if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(
            array(
              'key' => 'event_date',
              'compare' => '>=',
              'value' => date('Ymd'),/* loads todays date for use in meta_query */
              'type' => 'numeric'
            )));
    }
}

/* Add CSS and JS to be handled by wp */
add_action('wp_enqueue_scripts', 'clinic_resources');

/* function to load CSS and JavaScript */
add_action('after_setup_theme', 'clinic_features');

/* hooking custom queries to wp */
add_action('pre_get_posts', 'clinic_custom_queries')


?>