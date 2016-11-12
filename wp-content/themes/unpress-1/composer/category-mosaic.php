<?php 
/**
 * Latest Posts By Category
 * Page Composer Section
 *
 * @package UnPress
 * @since 	UnPress 1.0
**/
global $tf_option;

$posts_per_page = get_sub_field("category_number_of_posts");
$cat_id = get_sub_field( 'category_section_name' ); // get the category id which will filter the section

if(get_sub_field('category_pagination')=="enable"){
	//adhere to paging rules
	if ( get_query_var('paged') ) {
		$paged = get_query_var('paged');
	} elseif ( get_query_var('page') ) { // applies when this page template is used as a static homepage in WP3+
		$paged = get_query_var('page');
	} else {
		$paged = 1;
	}
	
	global $query_string;
		$args = array(
			'posts_per_page' => $posts_per_page,
			'cat'        	 =>  $cat_id,
			'post_type'      => 'post',
			'paged'				=> $paged,
			'post_status'    => 'publish'
		);
}
else
{
	global $query_string;
		$args = array(
			'posts_per_page' => $posts_per_page,
			'cat'        	 =>  $cat_id,
			'post_type'      => 'post',
			'post_status'    => 'publish'
		);
}
query_posts( $args );
?>

<section class="container module mosaic masonry">
	<div class="row">
		
		<?php 
		if(!get_sub_field( 'category_section_title_position' ) || get_sub_field( 'category_section_title_position' )=="left_side"):
        		$class_box_title = "title-box-left";
        elseif(get_sub_field( 'category_section_title_position' )=="right_side"):
        		$class_box_title = "title-box-right";
        endif; ?>
        
		<div class="col-lg-3 col-md-3 col-sm-4 sticky-col <?php echo $class_box_title; ?>">
			<div class="category-box sticky-box static_col">
				<?php if( get_sub_field( 'category_main_title' ) ): ?>
                        <h2><?php the_sub_field( 'category_main_title' ); ?></h2>
                <?php endif; ?>
                <?php if( get_sub_field( 'category_all_post' ) ): ?>
                <?php $category_link = get_category_link( $cat_id ); ?>
                <?php $category_name = get_the_category_by_ID( $cat_id ); ?> 
                <p><?php the_sub_field( 'category_all_post' ); ?> <a href="<?php echo esc_url( $category_link ); ?>"><?php echo esc_attr( $category_name ); ?></a></p>
                <?php endif; ?>
            </div>
		</div>
        
        <?php
		if ( get_sub_field( 'category_posts_sidebar' ) == 'enable' ):
			echo '<div class="col-lg-6 col-md-6 col-sm-4">';
			$with_sidebar = "mosaic_section_sidebar";
		else:
			echo '<div class="col-lg-9 col-md-9 col-sm-8">';
			$with_sidebar = "";
		endif;
		?>	

			<div class="row post-row">
				
				<?php 
					$i=0;
					
					if (have_posts()) :
                        while (have_posts()) : the_post(); 

                    		$i++;  
                        	
                    		$thumb_id = get_post_thumbnail_id($post->ID);
		                    $image_url = wp_get_attachment_url($thumb_id);
		                    

							if($i==2 || $i==4):
								echo '<div class="post-holder col-lg-8 col-md-8 col-sm-12 col-xs-12">';
								$thumbnail = unpress_aq_resize($image_url, 610, 610, true);
							else:
                            	echo '<div class="post-holder col-lg-4 col-md-4 col-sm-12 col-xs-12">';
                            	$thumbnail = unpress_aq_resize($image_url, 290, 290, true);
							endif;
							?>
                                
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
								                        <div class="post-entry-holder hidden-md hidden-sm">
															<?php if( get_sub_field( 'latest_posts_excerpt' )=="enable" 
																	  || get_sub_field( 'featured_posts_excerpt' )=="enable"
																	  || get_sub_field( 'category_posts_excerpt' )=="enable"
																	  || get_sub_field( 'format_posts_excerpt' )=="enable"
																	  ): ?>
								                                <?php the_excerpt(); ?>
								                            <?php endif; ?>
								                        </div><!-- .post-entry-holder hidden-md hidden-sm -->
								                        <a href="<?php the_permalink(); ?>" class="hover-btn"><i class="fa fa-angle-right"></i></a>
								                    </div>
								                </div>
								            </div><!-- .hover -->
								            <?php 
											if ( has_post_thumbnail() ) {
								                ?>
								                <img src="<?php echo $thumbnail; ?>" alt="<?php the_title(); ?>" />
											<?php
								            } else { ?>
								                <img class="alter_img" src="<?php echo get_template_directory_uri(); ?>/images/pixel.gif" alt="<?php the_title(); ?>" />
								            <?php } ?>
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
								</div>


                                <?php //get_template_part( 'post-format/mosaic', get_post_format() ); ?>
                                
                            </div>
            	
				<?php
						if($i==6){ $i=0; }
                    	endwhile; 
                endif;
                ?> 
							
			</div><!-- .row -->
		</div><!-- .col-lg-9 -->

		<?php
		// Enable/Disable sidebar based on the field selection
		if ( get_sub_field( 'category_posts_sidebar' ) == 'enable' ):
		?>
			<div class="col-md-3 col-sm-4">
				<aside class="sidebar">
            		<?php dynamic_sidebar( get_sub_field( 'section_sidebar_source' ) ); ?>
            	</aside>
			</div>
		
		<?php endif; ?>
        
      </div><!-- .row -->
</section><!-- .container -->
<?php
if(get_sub_field('category_pagination')=="enable"):
		unpress_paging_nav(); 
endif;
?>
<?php wp_reset_query(); ?>