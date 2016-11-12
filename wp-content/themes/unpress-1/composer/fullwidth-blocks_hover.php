<?php 
/**
 * Full Width Blocks Hover
 * Page Composer Section
 *
 * @package UnPress
 * @since 	UnPress 1.0
**/
global $tf_option;

$posts_per_page = get_sub_field("fullwidth_number_of_posts");
$fullwidth_post_from = get_sub_field("fullwidth_post_from");
$fullwidth_category = get_sub_field("fullwidth_category");

global $query_string;
	if($fullwidth_post_from == 'select_specific_categories' ){
		$args = array(
			'category__in' 	  => $fullwidth_category,
			'posts_per_page'  => $posts_per_page,
			'post_type'       => 'post',
			'post_status'     => 'publish'
		);
	}else{
		$args = array(
			'posts_per_page'  => $posts_per_page,
			'post_type'       => 'post',
			'post_status'     => 'publish'
		);
	}
query_posts( $args );
?>

<section class="container module blocks">
	<div class="row">
		
        <?php
		if ( get_sub_field( 'fullwidth_sidebar' ) == 'enable' ):
			
			echo '<div class="col-lg-9 col-md-9 col-sm-8">';
		else:
			echo '<div class="col-lg-12 col-md-12 col-sm-12">';
		endif;
		?>

			<div class="row post-row">
				
				<?php 
					if (have_posts()) :
	                    while (have_posts()) : the_post();

	                	$thumb_id = get_post_thumbnail_id($post->ID);
	                	$image_url = wp_get_attachment_url($thumb_id);

	                    if ( get_sub_field( 'fullwidth_columns' ) == 'two_columns'):
							$columns = "post-holder col-lg-6 col-md-6 col-sm-6 col-xs-12";

								$thumbnail = unpress_aq_resize($image_url, 610, 610, true );
							
						elseif ( get_sub_field( 'fullwidth_columns' ) == 'three_columns'):
							$columns = "post-holder col-lg-4 col-md-4 col-sm-6 col-xs-12";
							
								$thumbnail = unpress_aq_resize($image_url, 397, 397, true );

						else:
							$columns = "post-holder col-lg-3 col-md-3 col-sm-6 col-xs-12";

								$thumbnail = unpress_aq_resize($image_url, 290, 290, true );
							
						endif; 
				?>		
							
							<div id="post-<?php the_ID(); ?>" <?php post_class($columns); ?>>
							    <div class="featured-image image-holder holder">
							        <ul>
							            <li class="overlay">
							                <div class="hover">
							                    <div class="post-content-holder">
							                        <div class="post-content-display">
							                            <header>
							                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							                                
															<?php unpress_author(); ?>
							                            
							                            </header>
							                            <?php if( get_sub_field( 'fullwidth_posts_excerpt' )=="enable" ): ?>
							                            <div class="post-entry-holder hidden-md hidden-sm">
							                                <?php the_excerpt(); ?>
							                            </div><!-- .post-entry-holder hidden-md hidden-sm hidden-sm-->
							                            <?php endif; ?>
							                            <a href="<?php the_permalink(); ?>" class="hover-btn"><i class="fa fa-angle-right"></i></a>
							                        </div>
							                    </div>
							                </div><!-- .hover -->
							                
							                <img src="<?php echo $thumbnail; ?>" alt="<?php the_title(); ?>" />
							            </li><!-- .overlay -->
							        </ul>
							        <?php
							        // Add icon to different post formats
							        if ( 'gallery' == get_post_format() ): // Gallery
							            echo '<div class="icon-post-holder"><i class="fa fa-picture-o"></i></div>';
							        elseif ( 'video' == get_post_format() ): // Video
							            echo '<div class="icon-post-holder"><i class="fa fa-video-camera"></i></div>';
							        elseif ( 'audio' == get_post_format() ): // Audio
							            echo '<div class="icon-post-holder"><i class="fa fa-microphone"></i></div>';
							        endif;
							        ?>	
							    </div><!-- .featured-image -->
							</div>

	        	
	        	<?php
	                	endwhile; 
	            endif;
				wp_reset_query();
	            ?> 
							
			</div><!-- .row -->
		</div><!-- .col-lg-12 -->

		<?php
        // Enable/Disable sidebar based on the field selection
		if ( get_sub_field( 'fullwidth_sidebar' ) == 'enable' ):
		?>
        	<aside class="sidebar">
	        	<div class="col-md-3 col-sm-4">
	            	<?php dynamic_sidebar( get_sub_field( 'page_sidebar_source' ) ); ?>
	            </div>
        	</aside>
        
        <?php endif; ?>
        
	</div><!-- .row -->
</section><!-- .container -->