<?php
/*
Template Name: Before Event Homepage
*/
get_header();
?>

<?php if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); ?>

<section>
  <div class="container">
    <div class="main-content">
    <?php
    /* ///////////////////////////////////////////// MAIN CONTENT */
    the_content();
    ?>
    </div>

  <?php
  /* ///////////////////////////////////////////// PRESS */
  $press_link  = get_field('press_link');
  $press_link_check  = substr($press_link, 0, 4);
  $press_logos = get_field('press_logos');

  if (!empty($press_logos)) {
  echo '<div class="press-logos"><div class="press-context"><h4>As seen on</h4>';
    if (!empty($press_link)) {
      if($press_link_check !== 'http'){
        echo '<a href="http://' . $press_link . '">View all press</a>';
      } else {
        echo '<a href="' . $press_link . '">View all press</a>';
      }
    }
  echo '</div>';
  foreach($press_logos as $item) {
    //logo image is required
    $logo = $item['logo'];
    $link = $item['link'];
    $linkCheck = substr($linkCheck, 0, 4);
    if (!empty($link)) {
      if($linkCheck !== 'http'){
        echo '<a href="http://' . $link . '">';
      } else {
        echo '<a href="' . $link . '">';
      }
    }
    echo '<img src="' . $logo . '" alt="" />';
    if (!empty($link)) {
      echo '</a>';
    }
  }
  echo '</div>';
  }
  ?>


  </div>
</section>

<style>
  .email-signup .container {
    width:50%;
  }
  @media screen and (max-width: 960px) {
  .email-signup .container {
    width:90%;
  }
}
</style>
<section class="sponsors email-signup">
  <div class="container cf">

<!-- Begin MailChimp Signup Form -->
<link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
<style type="text/css">
  #mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
  /* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
     We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
</style>
<div id="mc_embed_signup">
<form action="//rhok-ottawa.us8.list-manage.com/subscribe/post?u=746a3f6265da9fe13c3359f9c&amp;id=fa19d343ee" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
    <div id="mc_embed_signup_scroll">
  <h2>Subscribe to our mailing list</h2>
<div class="indicates-required"><span class="asterisk">*</span> indicates required</div>
<div class="mc-field-group">
  <label for="mce-EMAIL">Email Address  <span class="asterisk">*</span>
</label>
  <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
</div>
  <div id="mce-responses" class="clear">
    <div class="response" id="mce-error-response" style="display:none"></div>
    <div class="response" id="mce-success-response" style="display:none"></div>
  </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_746a3f6265da9fe13c3359f9c_fa19d343ee" tabindex="-1" value=""></div>
    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
    </div>
</form>
</div>

</div>
</section>

<!--End mc_embed_signup-->

<?php
  /* ///////////////////////////////////////////// EVENTS */
  $show_events = get_field('show_events');
  if ($show_events) {
    include('part-events.php');
  }
?>

<section class="home-news">
<?php
  /* ///////////////////////////////////////////// CHALLENGES & NEWS */
  $show_challenges = get_field('show_challenges');
  if ($show_challenges) {
    include('part-challenges.php');
  }
  include('part-news.php');
?>
</section>

<section class="sponsors">
  <div class="container cf">
  <?php
    /* ///////////////////////////////////////////// SPONSORS */
    $sponsors_heading = get_field('sponsors_heading');
    $sponsors1        = get_field('sponsors1');
    $sponsors1_logos  = get_field('sponsors1_logos');
    $sponsors1b       = get_field('sponsors_1b_heading');
    $sponsors1b_logos = get_field('sponsors_1b_logos');
    $sponsors1c       = get_field('sponsors_1c_heading');
    $sponsors1c_logos = get_field('sponsors_1c_logos');
    $sponsors2        = get_field('sponsors2');
    $sponsors2_logos  = get_field('sponsors2_logos');
    $sponsors3        = get_field('sponsors3');
    $sponsors3_logos  = get_field('sponsors3_logos');
    $sponsors4        = get_field('sponsors4');
    $sponsors4_labels = get_field('sponsors4_labels');

    if (!empty($sponsors_heading)) {
      echo '<h2>' . $sponsors_heading . '</h2>';
    }
    if (!empty($sponsors1_logos)) {
      echo '<div class="sponsor-logos featured inline">';
      if (!empty($sponsors1)) {
        echo '<h3>' . $sponsors1 . '</h3>';
        echo '<div class="logos">';
      }
      foreach($sponsors1_logos as $item) {
        //logo image is required

        $logo = $item['logo'];
        $link = $item['link'];
        $description = $item['description'];
        $linkCheck = substr($link, 0, 4);
        if (!empty($link)) {
          if($linkCheck !== 'http'){
            echo '<a href="http://' . $link . '">';
          } else {
            echo '<a href="' . $link . '">';
          }
        }
        echo '<img src="' . $logo . '" alt="" />';
        if (!empty($link)) {
          echo '</a>';
        }
        if (!empty($description)) {
          echo $description;
        }
      }
      if (!empty($sponsors1)) {
        echo '</div>';
      }
      echo '</div>';
    }

    if (!empty($sponsors1b_logos)) {
      echo '<div class="sponsor-logos featured inline">';
      if (!empty($sponsors1b)) {
        echo '<h3>' . $sponsors1b . '</h3>';
        echo '<div class="logos">';
      }
      foreach($sponsors1b_logos as $item) {
        //logo image is required
        $logo = $item['logo'];
        $link = $item['link'];
        $linkCheck = substr($link, 0, 4);
        if (!empty($link)) {
          if($linkCheck !== 'http'){
            echo '<a href="http://' . $link . '">';
          } else {
            echo '<a href="' . $link . '">';
          }
        }
        echo '<img src="' . $logo . '" alt="" />';
        if (!empty($link)) {
          echo '</a>';
        }
      }
      if (!empty($sponsors1b)) {
        echo '</div>';
      }
      echo '</div>';
    }

    if (!empty($sponsors1c_logos)) {
      echo '<div class="sponsor-logos featured">';
      if (!empty($sponsors1)) {
        echo '<h3>' . $sponsors1c . '</h3>';
        echo '<div class="logos">';
      }
      foreach($sponsors1c_logos as $item) {
        //logo image is required
        $logo = $item['logo'];
        $link = $item['link'];
        $linkCheck = substr($link, 0, 4);
        if (!empty($link)) {
          if($linkCheck !== 'http'){
            echo '<a href="http://' . $link . '">';
          } else {
            echo '<a href="' . $link . '">';
          }
        }
        echo '<img src="' . $logo . '" alt="" />';
        if (!empty($link)) {
          echo '</a>';
        }
      }
      if (!empty($sponsors1c)) {
        echo '</div>';
      }
      echo '</div>';
    }


    if (!empty($sponsors2_logos)) {
      echo '<div class="sponsor-logos">';
      if (!empty($sponsors2)) {
        echo '<h3>' . $sponsors2 . '</h3>';
        echo '<div class="logos">';
      }
      foreach($sponsors2_logos as $item) {
        //logo image is required
        $logo = $item['logo'];
        $link = $item['link'];
        $linkCheck = substr($link, 0, 4);
        if (!empty($link)) {
          if($linkCheck !== 'http'){
            echo '<a href="http://' . $link . '">';
          } else {
            echo '<a href="' . $link . '">';
          }
        }
        echo '<img src="' . $logo . '" alt="" />';
        if (!empty($link)) {
          echo '</a>';
        }
      }
      if (!empty($sponsors2)) {
        echo '</div>';
      }
      echo '</div>';
    }
    if (!empty($sponsors3_logos)) {
      echo '<div class="sponsor-logos">';
      if (!empty($sponsors3)) {
        echo '<h3>' . $sponsors3 . '</h3>';
        echo '<div class="logos">';
      }
      foreach($sponsors3_logos as $item) {
        //logo image is required
        $logo = $item['logo'];
        $link = $item['link'];
        $linkCheck = substr($link, 0, 4);
        if (!empty($link)) {
          if($linkCheck !== 'http'){
            echo '<a href="http://' . $link . '">';
          } else {
            echo '<a href="' . $link . '">';
          }
        }
        echo '<img src="' . $logo . '" alt="" />';
        if (!empty($link)) {
          echo '</a>';
        }
      }
      if (!empty($sponsors3)) {
        echo '</div>';
      }
      echo '</div>';
    }
    if (!empty($sponsors4_labels)) {
      echo '<div class="sponsor-labels">';
      if (!empty($sponsors4)) {
        echo '<h3>' . $sponsors4 . '</h3>';
        echo '<div class="logos">';
      }
      foreach($sponsors4_labels as $item) {
        //label is required
        $label = $item['name'];
        $link = $item['link'];
        $linkCheck = substr($link, 0, 4);
        if (!empty($link)) {
          if($linkCheck !== 'http'){
            echo ' <a href="http://' . $link . '">';
          } else {
            echo ' <a href="' . $link . '">';
          }
        }
        echo ' <span>' . $label . '</span>';
        if (!empty($link)) {
          echo '</a>';
        }
      }
      if (!empty($sponsors4)) {
        echo '</div>';
      }
      echo '</div>';
    }
  ?>
	<?php /*<p><a href="<?php echo get_bloginfo('url').'/partners/'; ?>" class="btn">View all Organizations</a></p>*/ ?>
  </div>
</section>

<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
