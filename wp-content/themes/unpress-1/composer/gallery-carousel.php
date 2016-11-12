<?php
$gallery_cats = get_sub_field("custom_gallery_categories");
global $query_string;
	
$args = array(
	'post_type' => 'gallery',
	'posts_per_page' => '-1',
	'tax_query' => array(
		array(
			'taxonomy' => 'gallery-categories',
			'field' => 'id',
			'terms' => $gallery_cats,
			'operator' => 'IN'
		)
	)
);
query_posts( $args );

$unique_key = unpress_element_key();

?>

<script>
	jQuery(document).ready(function($) {

		$('#unPress-Homepage-Gallery-Carousel_<?php echo $unique_key; ?>').carouFredSel({
			auto				: false,
			direction           : "left",
			prev				: '#gallery-carousel-prev_<?php echo $unique_key; ?>',
			next				: '#gallery-carousel-next_<?php echo $unique_key; ?>',
			scroll : {
				items           : 1,
				easing          : "quadratic",
				duration        : 500,                         
				pauseOnHover    : true
			},
			mousewheel: false,
			swipe: {
				onMouse: true,
				onTouch: true
			}                 
		});

	});
</script>


<div id="homepage-gallery-carousel">
	<div id="homepage-gallery-carousel-navigation-wrapper">
		<div class="homepage-gallery-carousel-navigation clearfix">
            <?php if( get_sub_field( 'gallery_section_title' ) ): ?>
                    <h3><?php the_sub_field( 'gallery_section_title' ); ?></h3>
            <?php endif; ?>
			<div class="homepage-gallery-carousel-arrows">
				<a href="#" id="gallery-carousel-prev_<?php echo $unique_key; ?>"><i class="fa fa-angle-left gallery-carousel-prev"></i></a>
				<a href="#" id="gallery-carousel-next_<?php echo $unique_key; ?>"><i class="fa fa-angle-right gallery-carousel-next"></i></a>
			</div>
		    
		</div>
	</div>
	<div id="unPress-Homepage-Gallery-Carousel_<?php echo $unique_key; ?>">
		
        <?php 
		if (have_posts()) :
		while (have_posts()) : the_post(); 
		if (has_post_thumbnail( $post->ID ) ):

			$thumb_id = get_post_thumbnail_id($post->ID);
            $image_url = wp_get_attachment_url($thumb_id);
			$thumbnail = unpress_aq_resize($image_url, 320, 320, true);
		?>
		
        	<div class="slide">
                <a href="<?php the_permalink(); ?>">
                    <div class="gallery-carousel-slide-title">
                    	<span class="galleries-slide-category"><?php echo unpress_taxonomy_strip("gallery-categories"); ?></span>
                    	<h4 class="galleries-slide-sub-title"><?php the_title(); ?></h4>	
                    </div>
                    <img class="gallery-carousel-slide-image waqas test" src="<?php echo $thumbnail; ?>" data-original="<?php echo $thumbnail; ?>" alt="image">
                </a>
            </div>		
				
		<?php
		endif;
		endwhile; 
		wp_reset_query();
		endif;
		?>
		
		
	</div>
</div>