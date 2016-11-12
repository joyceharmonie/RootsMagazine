<?php 
/**
 * Latest Posts By Format
 * Page Composer Section
 *
 * @package UnPress
 * @since 	UnPress 1.0
**/
global $tf_option;

/**
 * Get the format name which will filter the section
 * Check if format is standard or something else
**/
$format_name = get_sub_field( 'format_section_name' );

$posts_per_page = get_sub_field("format_number_of_posts");

if ( get_sub_field( 'format_section_name' ) == 'standard' ):
	$format_args = array(
			'taxonomy' => 'post_format',
			'field' => 'slug',
			'terms' =>  array( 'post-format-video', 'post-format-gallery', 'post-format-audio' ),
			'operator' => 'NOT IN'
		);
else:
	$format_args = array(
			'taxonomy' => 'post_format',
			'field' => 'slug',
			'terms' => 'post-format-'.$format_name
		);
endif;

if(get_sub_field('format_posts_pagination')=="enable"){
	//adhere to paging rules
	if ( get_query_var('paged') ) {
		$paged = get_query_var('paged');
	} elseif ( get_query_var('page') ) { // applies when this page template is used as a static homepage in WP3+
		$paged = get_query_var('page');
	} else {
		$paged = 1;
	}
	
	$args = array(
		'posts_per_page' => $posts_per_page,
		'post_type'      => 'post',
		'tax_query' 	 => array( $format_args ),
		'paged'				=> $paged,
		'post_status'    => 'publish'
	);
}
else{
	$args = array(
		'posts_per_page' => $posts_per_page,
		'post_type'      => 'post',
		'tax_query' 	 => array( $format_args ),
		'post_status'    => 'publish'
	);
}
query_posts( $args );
?>

<section class="container module mosaic masonry">
	<div class="row">
		<?php 
		if(!get_sub_field( 'format_section_title_position' ) || get_sub_field( 'format_section_title_position' )=="left_side"):
        		$class_box_title = "title-box-left";
        elseif(get_sub_field( 'format_section_title_position' )=="right_side"):
        		$class_box_title = "title-box-right";
        endif; ?>
        
        <div class="col-lg-3 col-md-3 col-sm-4 sticky-col <?php echo $class_box_title; ?>">
			<div class="category-box sticky-box static_col">
            	<?php if( get_sub_field( 'format_main_title' ) ): ?>
						<h2><?php the_sub_field( 'format_main_title' ); ?></h2>
                <?php endif; ?>
                <?php if( get_sub_field( 'format_subtitle' ) ): ?>
                <p><?php the_sub_field( 'format_subtitle' ); ?></p>
                <?php endif; ?>
			</div>
		</div>
        
        
		<div class="col-lg-9 col-md-9 col-sm-8">
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
															<?php if( get_sub_field( 'format_posts_excerpt' )=="enable" ): ?>
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
        
      </div><!-- .row -->
</section><!-- .container -->
<?php
if(get_sub_field('format_posts_pagination')=="enable"):
		unpress_paging_nav(); 
endif;
?>
<?php wp_reset_query(); ?>