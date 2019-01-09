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
                'post_type' => get_post_type(),
                'title' => get_the_title(),
                'author_name' => get_the_author(),
                'link' => get_the_permalink()
            ));
        }
        // post_type: page
        if(get_post_type() == 'page') {
            array_push($query_results['pages'], array(
                'post_type' => get_post_type(),
                'title' => get_the_title(),
                'link' => get_the_permalink()
            ));
        }
        // post_type: employee
        if(get_post_type() == 'employee') {
            array_push($query_results['employees'], array(
                'post_type' => get_post_type(),
                'title' => get_the_title(),
                'link' => get_the_permalink(),
                'img' => get_the_post_thumbnail_url(0, "employee-landscape")
            ));
        }
        // post_type: locale
        if(get_post_type() == 'locale') {
            array_push($query_results['locales'], array(
                'post_type' => get_post_type(),
                'title' => get_the_title(),
                'link' => get_the_permalink(),
                'id' => get_the_id()
            ));
        }
        if(get_post_type() == 'event') {
            $eventDate = new DateTime(get_field('event_date', false, false)); 
            array_push($query_results['events'], array(
                'post_type' => get_post_type(),
                'title' => get_the_title(),
                'link' => get_the_permalink(),
                'month' => $eventDate->format('M'),
                'day' => $eventDate->format('d')
            ));
        }

        // post_type: treatment
        if(get_post_type() == 'treatment') {
            array_push($query_results['treatments'], array(
                'post_type' => get_post_type(),
                'title' => get_the_title(),
                'link' => get_the_permalink()
            ));
        }        
    }

    // Logic for finding post_types with relationship to search-term
    if($query_results['locales']){
        $locale_meta_query = array('relation' => 'OR');

        foreach($query_results['locales'] as $item) {
            array_push($locale_meta_query, array(
                'key' => 'related_locales',
                'compare' => 'LIKE',
                'value' => '"' . $item['id'] . '"'
            ));
        }
        $locale_relationship_query = new WP_Query(array(
            'post_type' => array('employee', 'event'),
            'meta_query' => $locale_meta_query
        ));

        // push relationship based search results onto JSON output array
        while($locale_relationship_query->have_posts()) {
            $locale_relationship_query->the_post();

            // post_type: event
            if(get_post_type() == 'event') {
                $eventDate = new DateTime(get_field('event_date', false, false)); 
                array_push($query_results['events'], array(
                    'post_type' => get_post_type(),
                    'title' => get_the_title(),
                    'link' => get_the_permalink(),
                    'month' => $eventDate->format('M'),
                    'day' => $eventDate->format('d')
                ));
            }
            if(get_post_type() == 'employee') {
                array_push($query_results['employees'], array(
                    'post_type' => get_post_type(),
                    'title' => get_the_title(),
                    'link' => get_the_permalink(),
                    'img' => get_the_post_thumbnail_url(0, "employee-landscape")
                ));
            }
        }
    }
    
    // Trim duplicate results
    $query_results['employees'] = array_unique($query_results['employees'], SORT_REGULAR);
    $query_results['events'] = array_unique($query_results['events'], SORT_REGULAR);

    return $query_results;
}


?>