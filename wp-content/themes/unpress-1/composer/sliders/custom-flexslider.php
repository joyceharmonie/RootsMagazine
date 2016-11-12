<?php 
/**
 * Custom Flex Slider
 * Page Composer Section
 *
 * @package UnPress
 * @since 	UnPress 1.0
**/
?>

<?php if( get_sub_field( 'custom_add_new_slide' ) ): ?>

<div id="flexslider-rotator-container">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="flexslider">
					<ul class="slides">
					<?php while( has_sub_field('custom_add_new_slide' ) ): ?>	
                    <?php if ( get_sub_field( 'slide_image' ) ): ?>
                    
                    	<?php
							$attachment_id = get_sub_field( 'slide_image' );
							$image_url = wp_get_attachment_url($attachment_id);
                    		$thumbnail = unpress_aq_resize($image_url, 998, 562, true);
                       	?>
                        	
                        <li class="item">
							<div class="inner">
								<a title="<?php the_sub_field( 'slide_title' ); ?>" rel="bookmark" href="<?php the_sub_field( 'url' ); ?>">
                                    <img src="<?php echo $thumbnail; ?>" alt="<?php the_sub_field( 'slide_title' ); ?>"/>
                                
								<div class="selectorShadow"></div>
								
								<?php if( get_sub_field( 'slide_title' ) !="" ): ?>
                                <div class="text-external-wrap">
									<div class="text-wrap">
										<div class="text1">
											<span class="post-title-name"><?php the_sub_field( 'slide_title' ); ?></span>
										</div>
									</div>
								</div>
                                <?php endif; ?>
                                </a>		
							</div>
						</li>
						
						<?php endif; ?>    
						<?php endwhile; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>  
</div><!-- #home-rotator-container -->

<?php endif; ?>