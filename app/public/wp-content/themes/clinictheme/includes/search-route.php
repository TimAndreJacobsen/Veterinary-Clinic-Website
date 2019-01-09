<?php

add_action('rest_api_init', 'clinic_register_search');

 // Add new custom route for REST api
function clinic_register_search(){
    register_rest_route('clinic/v1', 'search', array(  // (namespace/version, route, array of functions) ex: yoursite.com/wp-json/"namespace/version"/"route"
        'methods' => WP_REST_SERVER::READABLE, // crud: create, read, update, delete
        'callback' => 'clinic_search_results',
    )); 
}

/**
 * Custom REST api search result
 * @param data search term input
 * @return JSON_array structured JSON data
 * 
 * returns a JSON data structure and populates it by categories
 */
function clinic_search_results($data){
    $main_query = new WP_Query(array(
        'post_type' => array('post', 'page', 'employee', 'event', 'locale'), // post_type(s) to match against
        's' => sanitize_text_field($data['term']) //sanitize_text_field() = WP function to sanitize user input, prevent SQL injection.
    ));

    // create empty array structure
    $query_results = array(
        'articles' => array(),
        'pages' => array(),
        'employees' => array(),
        'locales' => array(),
        'events' => array(),
        'treatments' => array()
    );

    // populating JSON data structure by array categories
    while($main_query->have_posts()){
        $main_query->the_post();

        // post_type: post (articles)
        if(get_post_type() == 'post') {
            array_push($query_results['articles'], array(
                'title' => get_the_title(),
                'link' => get_the_permalink()
            ));
        }
        // post_type: page
        if(get_post_type() == 'page') {
            array_push($query_results['pages'], array(
                'title' => get_the_title(),
                'link' => get_the_permalink()
            ));
        }
        // post_type: employee
        if(get_post_type() == 'employee') {
            array_push($query_results['employees'], array(
                'title' => get_the_title(),
                'link' => get_the_permalink()
            ));
        }        
        // post_type: locales
        if(get_post_type() == 'locales') {
            array_push($query_results['locales'], array(
                'title' => get_the_title(),
                'link' => get_the_permalink()
            ));
        }        
        // post_type: event
        if(get_post_type() == 'event') {
            array_push($query_results['events'], array(
                'title' => get_the_title(),
                'link' => get_the_permalink()
            ));
        }        
        // post_type: treatment
        if(get_post_type() == 'treatment') {
            array_push($query_results['treatments'], array(
                'title' => get_the_title(),
                'link' => get_the_permalink()
            ));
        }        
    }
    return $query_results;
}


?>