<?php 
/**
 * Post Elastic Slider
 * Page Composer Section
 *
 * @package UnPress
 * @since 	UnPress 1.0
**/
global $ft_option;

/** 
 * Add posts to slider only if the 'Homepage Slider' 
 * custom field checkbox was checked on the Post edit page
**/
$slides_num = get_sub_field( 'slides_to_show' );

$unpress_posts_slider = new WP_Query(
	array(
		'post_type' => 'post',
		'meta_key' => 'homepage_slider',
		'meta_value' => '1',
		'posts_per_page' => $slides_num
	)
);
?>

<!-- !Main slideshow -->
<div id="home-rotator-container">
<?php if ( $unpress_posts_slider->have_posts() ) : ?>

    <div id="home-rotator">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-12">
			        <div id="ei-slider" class="ei-slider">
            <ul class="ei-slider-large">
            
            <?php while ( $unpress_posts_slider->have_posts() ) : $unpress_posts_slider->the_post(); 

                        $thumb_id = get_post_thumbnail_id($post->ID);
                          $image_url = wp_get_attachment_url($thumb_id);
                          $thumbnail = unpress_aq_resize($image_url, 998, 562, true);

            ?>
                
                <li>
                    <img src="<?php echo $thumbnail; ?>" alt="<?php echo get_the_title(); ?>" />
                    <div class="ei-title">
                         <h2 class="entry-title">
                            <?php the_title(); ?>
                        </h2>
                        <h3>
                          <a class="rsCLink" href="<?php the_permalink(); ?>"><span class="assistive-text"></span></a>
                        </h3>
                    </div>
                </li> 
            <?php endwhile; ?>
            <?php wp_reset_query(); ?>
            
            </ul><!-- ei-slider-large -->
            <ul class="ei-slider-thumbs">
                <li class="ei-slider-element">Current</li>
                <?php while ( $unpress_posts_slider->have_posts() ) : $unpress_posts_slider->the_post(); ?>
                
				<?php $thumb_id = get_post_thumbnail_id($post->ID);
                          $image_url = wp_get_attachment_url($thumb_id);
                          $thumbnail = unpress_aq_resize($image_url, 150, 84, true); ?>
                
                        <li><a href="#"><?php the_title(); ?></a>
                            <img src="<?php echo $thumbnail; ?>" alt="<?php the_title(); ?>" />
                        </li>
                
                <?php endwhile; ?>
                <?php wp_reset_query(); ?>
            </ul><!-- ei-slider-thumbs -->
        </div>
			    </div>
			</div>
		</div>	        
    </div><!-- #home-rotator -->
    
<?php endif; ?>
</div><!-- #home-rotator-container -->  