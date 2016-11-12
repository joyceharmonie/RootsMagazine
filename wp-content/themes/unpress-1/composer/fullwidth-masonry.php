<?php 
/**
 * Full Width Masonry
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

<section class="container module masonry">
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

							if ( get_sub_field( 'fullwidth_sidebar' ) == 'enable' ):
								$thumbnail = unpress_aq_resize($image_url, 450, 9999);
							else:
								$thumbnail = unpress_aq_resize($image_url, 610, 9999);
							endif;
							
						elseif ( get_sub_field( 'fullwidth_columns' ) == 'three_columns'):
							$columns = "post-holder col-lg-4 col-md-4 col-sm-6 col-xs-12";
							
							if ( get_sub_field( 'fullwidth_sidebar' ) == 'enable' ):
								$thumbnail = unpress_aq_resize($image_url, 290, 9999);
							else:
								$thumbnail = unpress_aq_resize($image_url, 397, 9999);
							endif;

						else:
							$columns = "post-holder col-lg-3 col-md-4 col-sm-6 col-xs-12";

							if ( get_sub_field( 'fullwidth_sidebar' ) == 'enable' ):
								$thumbnail = unpress_aq_resize($image_url, 210, 9999);
							else:
								$thumbnail = unpress_aq_resize($image_url, 290, 9999);
							endif;
							
						endif; 
				?>		
							
							<div id="post-<?php the_ID(); ?>" <?php post_class($columns); ?>>
							    <div class="featured-image image-holder holder">
							        
							     <?php if ( has_post_thumbnail() ): ?>
								        <a class="overlay" href="<?php the_permalink(); ?>">
								            <span class="hover">
								                <span class="hover-btn"><i class="fa fa-angle-right"></i></span>
								            </span><!-- .hover -->
								            
								            <img src="<?php echo $thumbnail; ?>" />
								        </a><!-- .overlay -->
								        <?php if( has_tag() ): ?>
								        <div class="tag-holder">
								            <?php esc_attr( unpress_post_tags() );?>
								        </div><!-- .tag-holder -->
								        <?php endif; ?>
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
								        
								<?php endif; ?>

							    </div><!-- .featured-image -->
							    
							    <div class="post-content-holder">
							        <header>
							            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							            
							            <?php unpress_author(); ?>
							            
							        </header>
							        
							        <?php if( get_sub_field( 'fullwidth_posts_excerpt' )=="enable" ): ?>
							        <div class="post-entry-holder">
							            <?php the_excerpt(); ?>
							        </div><!-- .post-entry-holder -->
							        <?php endif; ?>
							    </div><!-- .post-content-holder -->
							</div><!-- .post-holder -->

	        	
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