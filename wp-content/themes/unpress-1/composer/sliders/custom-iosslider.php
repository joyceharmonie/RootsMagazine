<?php 
/**
 * Custom IOS Slider
 * Page Composer Section
 *
 * @package UnPress
 * @since 	UnPress 1.0
**/
?>

<?php if( get_sub_field( 'custom_add_new_slide' ) ): ?>
<div id="home-rotator-container" class="">

	<!-- <div class="unpress-preloader fa-spin"></div> -->
	
    <div id="home-rotator">    
		<div class="fluidHeight">
			<div class="sliderContainer">
				<div class="iosSlider">
					<div class="slider">
					
					<?php while( has_sub_field('custom_add_new_slide' ) ): ?>	
                    <?php if ( get_sub_field( 'slide_image' ) ): ?>
                    
                    	<?php
							$attachment_id = get_sub_field( 'slide_image' );
							$image_url = wp_get_attachment_url($attachment_id);
                    		$thumbnail = unpress_aq_resize($image_url, 998, 562, true);
                       	?>    
                        <div class="item">
							<div class="inner">
                                <a title="<?php the_sub_field( 'slide_title' ); ?>" rel="bookmark" href="<?php the_sub_field( 'url' ); ?>">
                                    <img src="<?php echo $thumbnail; ?>" alt="<?php the_sub_field( 'slide_title' ); ?>"/>
                                
								<div class="selectorShadow"></div>
								
								<?php if( get_sub_field( 'slide_title' )) { ?>
								<div class="text-external-wrap">
									<div class="text-wrap">
										<div class="text1">
											<span class="post-title-name"><?php the_sub_field( 'slide_title' ); ?></span>
										</div>
									</div>
								</div>
								<?php } ?>

                                </a>		
							</div>
						</div><!-- item -->
                    <?php endif; ?>    
					<?php endwhile; ?>	
                    
					</div><!-- .slider -->
				</div><!-- .iosSlider -->
				
			</div><!-- .sliderContainer -->
		</div><!-- .fluidHeight -->
		<div class="home-rotator-navigation">
			<div class="sliderPrev" id="prev"><i class="fa fa-angle-left"></i></div>
			<div class="sliderNext" id="next"><i class="fa fa-angle-right"></i></div>
		</div>
	</div><!-- #home-rotator -->
</div><!-- #home-rotator-container -->
<?php endif; ?>