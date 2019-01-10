<div class="post-item">
    <li class="employee-card__list-item">
        <a class="employee-card" href="<?php the_permalink(); ?>">
            <img class="employee-card__image" src="<?php the_post_thumbnail_url($size="employee-landscape"); ?>">
            <span class="employee-card__name"><?php the_title(); ?></span>
        </a>
    </li>
</div>