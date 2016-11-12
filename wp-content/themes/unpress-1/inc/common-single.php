<?php
/*
	Common file for single, audio, video, gallery
*/
global $ft_option;
?>


<div class="container">
    <div class="row">
        <?php
		if($ft_option['posts_default_sidebar_on']== 0 ): 
			if(! get_field( 'post_sidebar' ) || get_field( 'post_sidebar' ) == "post_sidebar_off"):
			
					echo '<div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">';
			else:
					echo '<div class="col-md-9 col-lg-9 col-sm-12 col-xs-12">';
			endif;
		else:
			echo '<div class="col-md-9 col-lg-9 col-sm-12 col-xs-12">';
		endif;
        ?>
        
            <div class="entry-content">

                <?php if ($ft_option['after_featured_image'] == 1 ) { ?>
                        <div class="unpress-single-ads">
                        <?php echo $ft_option['single_ads']; ?>
                        </div>
                <?php } ?>

                <?php the_content(); ?>
                <?php
                $args = array(
                    'before' => '<div class="link-pages">' . __( "Pages:", "favethemes" ),
                    'after' => '</div>',
                    'link_before' => '<span>',
                    'link_after' => '</span>'
                );
                wp_link_pages( $args );
                ?>

                <?php
                    if ($ft_option['end_of_post'] == 1 ) {
                        echo $ft_option['single_ads'];
                    }
                ?>

            </div>
            
            <?php if($ft_option['posts_default_sidebar_on']== 0 ): ?>
				<?php if(get_field( 'post_sidebar' ) == "post_sidebar_on"):?>
                        
                        <?php if( $ft_option['single_tags'] !=0 ) { ?>
                        <?php if( has_tag() ): ?>
                        <div class="tags-wrap ">
                            <h3><?php _e("Tags", "favethemes"); ?></h3>
                            <?php esc_attr( unpress_post_tags() );?>
                        </div><!-- .tags-wrap -->
                        <?php endif; ?>
                        <?php } ?>

                        <!-- .post-author-box -->
                        <?php if( $ft_option['single_author'] !=0 ) { ?>
                        <?php unpress_author_box(); ?>
                        <?php } ?>
                        <!-- .end post-author-box -->
                <?php endif; ?>
            <?php else: ?>
            		
                    <?php if( $ft_option['single_tags'] !=0 ) { ?>
                    <?php if( has_tag() ): ?>
                    <div class="tags-wrap ">
                        <h3><?php _e("Tags", "favethemes"); ?></h3>
                        <?php esc_attr( unpress_post_tags() );?>
                    </div><!-- .tags-wrap -->
                    <?php endif; ?>
                    <?php } ?>

                    <!-- .post-author-box -->
                    <?php if( $ft_option['single_author'] !=0 ) { ?>
                    <?php unpress_author_box(); ?>
                    <?php } ?>
                    <!-- .end post-author-box -->
            <?php endif; ?>
            
            <?php
			if($ft_option['posts_default_sidebar_on']== 0 ):
				if( get_field( 'post_sidebar' ) == "post_sidebar_on"):
					if($ft_option["single_related"]=="1"): 
						get_template_part( 'inc/related', 'posts' ); 
					endif;
					
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				?>	
					<?php if ( 'gallery' == get_post_format() ):?>
					<div class="article_nav single-gallery-article_nav">
						<?php if($ft_option["single_nav_arrows"]=="1"):?>
						<!-- Article nav -->
						<?php get_template_part( 'inc/article_nav' ); ?>
						<!-- End article nav -->
						<?php endif; ?>
					</div>
					<?php endif; ?>	
					
				<?php	
				endif; // post_sidebar_on
			else:
				
				if($ft_option["single_related"]=="1"): 
					get_template_part( 'inc/related', 'posts' ); 
				endif;
				
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
				?>
                <?php if ( 'gallery' == get_post_format() ):?>
                <div class="article_nav single-gallery-article_nav">
                    <?php if($ft_option["single_nav_arrows"]=="1"):?>
                    <!-- Article nav -->
                    <?php get_template_part( 'inc/article_nav' ); ?>
                    <!-- End article nav -->
                    <?php endif; ?>
                </div>
                <?php endif; ?>	
			<?php	
			endif;	
				?>
            
        </div><!-- End: .col-md-8 or col-md-9 -->
        
        <?php if($ft_option['posts_default_sidebar_on'] == 0): ?>
			<?php if(! get_field( 'post_sidebar' ) || get_field( 'post_sidebar' ) == "post_sidebar_off"):?>
                  <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
                   
                    <?php if( $ft_option['single_tags'] !=0 ) { ?>
                    <?php if( has_tag() ): ?>
                    <div class="tags-wrap ">
                        <h3><?php _e("Tags", "favethemes"); ?></h3>
                        <?php esc_attr( unpress_post_tags() );?>
                    </div><!-- .tags-wrap -->
                    <?php endif; ?>
                    <?php } ?>
                    
                    <!-- .post-author-box -->
                    <?php if( $ft_option['single_author'] !=0 ) { ?>
                    <?php unpress_author_box(); ?>
                    <?php } ?>
                    <!-- .end post-author-box -->
                </div> <!-- End .col-md-4-->
            <?php else: ?>
                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                    <?php get_sidebar(); ?>
                </div><!-- End: sidebar-->
           <?php endif; ?>
        <?php else: ?>
                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                    <?php get_sidebar(); ?>
                </div><!-- End: sidebar-->
       <?php endif; ?> 
        
    </div> <!-- End .row -->
</div><!-- End .container -->