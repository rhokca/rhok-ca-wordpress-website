<section class="home-events">
  <div class="container cf">
    <div class="left">
      <h2>
        <?php
          $numberEvents = wp_count_posts('event')->publish;
          $numberCities = count($locations);
        ?>
        Past<br>
        <strong>Events</strong>
      </h2>
    </div>

    <ul class="event-locations">
      <?php
      $args = array(
        'post_type' => 'event',
        'orderby' => 'post_date',
        'order' => 'DESC',
        'numberposts' => '-1'
      );
      $posts = get_posts($args); ?>
      <?php if (count($posts) > 0): $n = 0; foreach($posts as $post): setup_postdata($post); ?>
      <?php 
        if($n==0){// skip first current one
          $n++;
          continue; 
        } 
       ?>
          <li>
            <a href="<?php the_permalink(); ?>" title="<?php the_title();?>">
              <span><?php the_title();?></span>
            </a>
          </li>
        <?php endforeach; ?>
        </ul>
    <ul class="event-locations">
        <li>
          <a href="<?php bloginfo('url'); ?>/events/" class="all-link">
            <span>View All Events</span>
          </a>
         </li>
        <li>
          <a href="<?php bloginfo('url'); ?>/projects/" class="all-link">
            <span>View All Projects</span>
          </a>
         </li>
      <?php endif; wp_reset_query(); ?>
    </ul>
  </div>
</section>
