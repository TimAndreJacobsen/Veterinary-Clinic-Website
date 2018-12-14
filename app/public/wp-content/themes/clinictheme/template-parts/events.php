<?php $eventDate = new DateTime(get_field('event_date', false, false)); 
/*
 * template for displaying events in content section
 * Can be called with get_template_part('template-parts/events')
 */ ?>
 
<div class="event-summary">
        <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
          <span class="event-summary__month">
            <?php echo $eventDate->format('M'); ?></span>
          <span class="event-summary__day">
            <?php echo $eventDate->format('d'); ?></span>
        </a>
        <div class="event-summary__content">
          <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>">
              <?php the_title(); ?></a></h5>
          <p>
            <?php if (has_excerpt()) {
                echo get_the_excerpt(); ?>
            <?php
               } else {
                echo wp_trim_words(get_the_content(), 30);
            } ?>
            <a href="<?php the_permalink(); ?>" class="nu c-blue">
              <br>See more</a></p>
        </div>
      </div>