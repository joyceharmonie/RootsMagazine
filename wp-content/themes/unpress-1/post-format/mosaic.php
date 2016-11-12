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

                    $thumb_id = get_post_thumbnail_id($post->ID);
                    $image_url = wp_get_attachment_url($thumb_id);
                    $thumbnail = unpress_aq_resize($image_url, 610, 610, true);
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