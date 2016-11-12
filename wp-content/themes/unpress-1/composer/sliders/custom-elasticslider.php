<?php 
/**
 * Custom Elastic Slider
 * Page Composer Section
 *
 * @package UnPress
 * @since 	UnPress 1.0
**/
?>

<!-- !Main slideshow -->
<?php if( get_sub_field( 'custom_add_new_slide' ) ): ?>

<div id="home-rotator-container">
  <div id="home-rotator">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div id="ei-slider" class="ei-slider">
            <ul class="ei-slider-large">
              <?php while( has_sub_field('custom_add_new_slide' ) ): ?>
              <?php if ( get_sub_field( 'slide_image' ) ): ?>
              <?php
                  $attachment_id = get_sub_field( 'slide_image' );
                  $image_url = wp_get_attachment_url($attachment_id);
                  $thumbnail = unpress_aq_resize($image_url, 998, 562, true);
              ?>
              <li> <img src="<?php echo $thumbnail; ?>" alt="<?php the_sub_field( 'slide_title' ); ?>"/>
                <div class="ei-title">
                  <h2 class="entry-title">
                    <?php the_sub_field( 'slide_title' ); ?>
                  </h2>
                  <h3>
                    <?php if ( get_sub_field( 'url' ) ): ?>
                    <a class="rsCLink" href="<?php the_sub_field( 'url' ); ?>"><span class="assistive-text"></span></a>
                    <?php endif; ?>
                  </h3>
                </div>
              </li>
              <?php endif; ?>
              <?php endwhile; ?>
            </ul>
            <!-- ei-slider-large -->
            <ul class="ei-slider-thumbs">
              <li class="ei-slider-element">Current</li>
              <?php while( has_sub_field('custom_add_new_slide' ) ): ?>
              <?php if ( get_sub_field( 'slide_image' ) ): ?>
              <?php
                  $attachment_id = get_sub_field( 'slide_image' );
                  $image_url = wp_get_attachment_url($attachment_id);
                  $thumbnail = unpress_aq_resize($image_url, 150, 84, true);
              ?>
              <li><a href="#">
                <?php the_sub_field( 'slide_title' ); ?>
                </a> <img src="<?php echo $thumbnail; ?>" alt="<?php the_sub_field( 'slide_title' ); ?>"/></li>
              <?php endif; ?>
              <?php endwhile; ?>
            </ul>
            <!-- ei-slider-thumbs --> 
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- #home-rotator --> 
</div>
<!-- #home-rotator-container -->
<?php endif; ?>
<?php wp_reset_query(); ?>