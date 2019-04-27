
<table>
<thead>
<tr>
  <th>Project</th>
  <th>Event</th>
  </tr>
</thead>
<tbody>
<?php while ( have_posts() ) : the_post();
  $challenge = get_field('challenge_id');
  $challenge_other = trim(get_field('challenge_name'));
  $event_id = get_field('event_id');
  $event = get_post($event_id);
  $event_slug = $event->post_name;
  $event_search_term = get_query_var('project-event');
  if (!$event_search_term || $event_slug == $event_search_term):
    $found_projects = true;
?>
<tr>
<td><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></td>
<td><?php echo $event->post_title; ?></td>
</tr>
<?php endif; endwhile; ?>


</tbody>
</table>

