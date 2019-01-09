<?php

add_action('rest_api_init', 'clinic_register_search');

 // Add new custom route for REST api
function clinic_register_search(){
    register_rest_route('clinic/v1', 'search', array(  // (namespace/version, route, array of functions) ex: yoursite.com/wp-json/"namespace/version"/"route"
        'methods' => WP_REST_SERVER::READABLE, // crud: create, read, update, delete
        'callback' => 'clinic_search_results',
    )); 
}

function clinic_search_results(){
    return 'routing works!';
}


?>