<?php

function clinic_resources(){ /* function to load CSS and JavaScript */
    /* CSS */
    wp_enqueue_style('clinic_styles', get_stylesheet_uri());
    wp_enqueue_style('font_google_roboto', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font_awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

    /* JavaScript */
    wp_enqueue_script('clinic_js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true);
}

function clinic_features(){
    add_theme_support('title-tag');
}

/* Add clinic_resources() to be handled by wp */
add_action('wp_enqueue_scripts', 'clinic_resources');

/* Add title to pages */
add_action('after_setup_theme', 'clinic_features')

?>