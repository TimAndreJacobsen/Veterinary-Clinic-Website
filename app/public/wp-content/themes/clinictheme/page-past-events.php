<?php
    get_header();
    page_banner(array(
        'title' => 'Event archive',
        'subtitle' => 'Archive of events that have completed'
    ));
?>

<br><br>
<div class="container container--narrow page section">
    <?php
$pastEvents = new WP_Query(array(
    'post_type' => 'event',
    'paged' => get_query_var('paged', 1), /*get information about query URL*/
    'orderby' => 'meta_value_num',
    'meta_key' => 'event_date',
    'order' => 'ASC',
    'meta_query' => array(
      array(
        'key' => 'event_date',
        'compare' => '<',
        'value' => date('Ymd'), /* loads todays date for use in meta_query */
        'type' => 'numeric'
      ))));
while ($pastEvents->have_posts()) {
    $pastEvents->the_post();  
    get_template_part('template-parts/events');
}
    echo paginate_links(array(
        'total' => $pastEvents->max_num_pages
    ));
    ?>
    
</div>

<?php
  get_footer();
?>