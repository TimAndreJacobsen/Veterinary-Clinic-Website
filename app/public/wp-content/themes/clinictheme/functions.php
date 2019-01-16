<?php

/* INCLUDES */
require get_theme_file_path('/includes/search-route.php');

/**
 * page_banner() handles banner area of a page.
 * If no $args are passed, the function will use default values.
 * 
 * @args: associative array(dictionary)
 * @param: title, subtitle, banner_image
 * @returns: HTML and CSS snippet for banner area. 
 * dependencies: Advanced Custom Fields plugin for get_field() function
 */
function page_banner($args = NULL){
    if (!$args['title']){
        $args['title'] = get_the_title();
    }
    if (!$args['subtitle']){
        /* Grab subtitle from WP-admin area */
        $args['subtitle'] = get_field('page_banner_subtitle');
    }
    if (!$args['image']){
        if (get_field('page_banner_background_image')){
            /* Grab banner image from WP-admin area */
            $args['image'] = get_field('page_banner_background_image')['sizes']['page-banner'];
        } else {
            /* Default banner-image if all other options fail */
            $args['image'] = get_theme_file_uri('/images/dogs-whitebg.jpg');
        }
    } /* HTML/CSS snippet returned to function caller */?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php 
            echo $args['image']; ?>);">
        </div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"> <?php echo $args['title']; ?></h1>
            <div class="page-banner__intro">
                <p><?php echo $args['subtitle']; ?></p>
            </div>
        </div>
    </div> <?php
}

/**
 * function to load CSS and JavaScript 
 */
function clinic_resources(){
    /* JavaScript */
    wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyDzoEZVm8qLGy6Pog5Ob-xfh3Cv5YgwgrM', NULL, '1.0', true);
    wp_enqueue_script('clinic_js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, microtime(), true);
    wp_localize_script('clinic_js', 'clinic_data', array(
        'root_url' => get_site_url(),
        'nonce' => wp_create_nonce('wp_rest')  // nonce = rng number created at login. Used to prove login status(admin status for delete over JSON for example)
    ));
    /* CSS */
    wp_enqueue_style('font_google_roboto', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font_awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('clinic_styles', get_stylesheet_uri(), NULL, microtime());
}

/**
 * Theme Setup
 */
function clinic_features(){
    /* Add title to pages */
    add_theme_support('title-tag');
    /* enable featured images */
    add_theme_support('post-thumbnails');
    /* adding new image sizes */
    add_image_size('employee-landscape', 400, 260, true);
    add_image_size('employee-portrait', 480, 650, true);
    add_image_size('page-banner', 1500, 350, true);
    /* Add header menu to wp-admin */
    register_nav_menu('header_menu_location', 'Header Menu Location');
    register_nav_menu('footer_menu_location_left', 'Footer Menu Location Left');
    register_nav_menu('footer_menu_location_right', 'Footer Menu Location Right');
}

/**
 * Custom queries for fine grained filtering of custom post_types
 */
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

/* Google Maps API-key */
function acf_google_maps_api_key($api){
    $api['key'] = 'AIzaSyDzoEZVm8qLGy6Pog5Ob-xfh3Cv5YgwgrM';
    return $api;
}

/**
 * REST API - register custom JSON fields
 */
function clinic_custom_rest() {
    register_rest_field('post', 'author_name', array(
        'get_callback' => function(){return get_the_author();}
    ));
    register_rest_field('note', 'user_note_count', array(
        'get_callback' => function(){return count_user_posts(get_current_user_id(), 'note');}
    ));
    
    register_rest_field('pet', 'user_pet_count', array(
        'get_callback' => function(){return count_user_posts(get_current_user_id(), 'pet');}
    ));
    register_rest_field('pet', 'name', array(
        'get_callback' => function(){ return 'pet_name_here' ;}
    ));
    register_rest_field('pet', 'age', array(
        'get_callback' => function(){return 'pet_age_here' ;}
    ));
    register_rest_field('pet', 'breed', array(
        'get_callback' => function(){return 'pet_breed_here' ;}
    ));
}

/**
 * Redirect subscriber accounts from wp-admin to homepage
 * Pull current user role information and checks for 2 conditions:
 * Is users role subscriber AND is that the only role.
 * Redirects users to frontpage after logging in
 */
function redirect_sub_to_frontend(){
    $current_user = wp_get_current_user();
    if(count($current_user->roles) == 1 AND $current_user->roles[0] == 'subscriber') {
        wp_redirect(site_url('/'));
        exit;
    }
}

/**
 * Redirect log from wp-admin page to homepage
 * Pull current user role information and checks for 2 conditions:
 * Is users role subscriber AND is that the only role.
 * Redirects users to frontpage after logging in
 */
function auto_redirect_external_after_logout(){
    // check if user is leaving from admin
    // is_admin() check would not work here probably as we left the admin already
    if ( false !== strpos( $_SERVER['HTTP_REFERER'], 'wp-admin' ) ){
        wp_redirect(site_url('/'));
    } else {
        wp_redirect(site_url('/'));
    }
    exit;
}

function hide_admin_subscriber() {
    $current_user = wp_get_current_user();
    if(count($current_user->roles) == 1 AND $current_user->roles[0] == 'subscriber') {
        show_admin_bar(false);
    }
}

/***** Functions for customizing login page *****/
function clinic_header_url() { // Link to frontpage instead of WP - gets rid of WP link
    return esc_url(site_url('/'));
}
function login_css_image(){ // Use custom CSS instead of WP - gets rid of logo
    wp_enqueue_style('clinic_styles', get_stylesheet_uri(), NULL, microtime());
    wp_enqueue_style('font_google_roboto', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
}
function login_title() { // Use custom text instead of WP - gets rid of "powered by..." text
    return 'The Clinic';
}


/**************
 *  SECURITY  *
 **************/

/**
 * Intercepts incoming requests before they are saved to the database.
 * Sanitizes post_content(body) and post_title to remove HTML
 * Enforces "private" status on post_type note.
 * This prevents client side custom JavaScript from sending modified requests to break privacy.
 *  @param = incoming REST API request. create, read, update, delete note.
 *  @return = returns $data with enforced private or trash status
 */
function make_note_private($data, $post_array) {
    if ($data['post_type'] == 'note') {
        if (count_user_posts(get_current_user_id(), 'note') > 9 AND !$post_array['ID']) {
            die("Per user note limit is 10 notes, please delete a note to free up space.");
        }

        $data['post_title'] = sanitize_text_field($data['post_title']);
        $data['post_content'] = sanitize_textarea_field($data['post_content']);
    }
    if ($data['post_type'] == 'note' AND $data['post_status'] != 'trash') {
        $data['post_status'] = "private";
    }
    return $data;
}


/*********************
 * Hooks and scripts *
 *********************/
// customize login screen
add_filter('login_headertitle', 'login_title');
add_filter('login_headerurl', 'clinic_header_url');
add_action('login_enqueue_scripts', 'login_css_image');
// Hide admin bar for subsriber only accounts
add_action('wp_loaded', 'hide_admin_subscriber');
// Redirect subscriber accounts from wp-admin to homepage
add_action('admin_init', 'redirect_sub_to_frontend');
// redirect on logout
add_action( 'wp_logout', 'auto_redirect_external_after_logout');

/* Add CSS and JS to be handled by Wordpress */
add_action('wp_enqueue_scripts', 'clinic_resources');
/* function to load CSS and JavaScript */
add_action('after_setup_theme', 'clinic_features');

/* hooking custom queries to Wordpress */
add_action('pre_get_posts', 'clinic_custom_queries');

/* Google maps API key */
add_filter('acf/fields/google_map/api', 'acf_google_maps_API_key');

/* REST API hook */
add_action('rest_api_init', 'clinic_custom_rest');
// Force post_types: note to be private
add_filter('wp_insert_post_data', 'make_note_private', 10, 2); /* add_filter( WP_hook, our_function, prio_number(lower is earlier), args_number ) */

?>