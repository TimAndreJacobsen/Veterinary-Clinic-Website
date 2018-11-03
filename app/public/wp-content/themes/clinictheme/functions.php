<?php

function clinic_resources(){
    wp_enqueue_style('clinic_styles', get_stylesheet_uri());
}

add_action('wp_enqueue_scripts', 'clinic_resources')

?>