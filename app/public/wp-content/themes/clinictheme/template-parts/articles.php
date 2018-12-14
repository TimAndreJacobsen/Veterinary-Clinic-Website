<div class="event-summary">
        <a class="event-summary__date t-center" href="<?php echo site_url(slugBuilder()) ?>">
          <span class="event-summary__month">
            <?php echo get_the_date('M'); ?></span>
          <span class="event-summary__day">
            <?php echo get_the_date('j'); ?></span>
        </a>
        <div class="event-summary__content">
          <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>">
              <?php the_title(); ?> </a></h5>
          <p>
            <?php if (has_excerpt()) {
            echo get_the_excerpt(); ?>
            <?php
        } else {
            echo wp_trim_words(get_the_content(), 30);
        } ?>
            <a href="<?php the_permalink(); ?>" class="nu c-blue">
              <br>Read more</a></p>
        </div>
      </div>