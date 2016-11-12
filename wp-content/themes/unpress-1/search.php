<?php 
/**
 * Search Results
 *
 * @package UnPress
 * @since 	UnPress 1.0
**/ 
?>

<?php get_header(); ?>

<div id="page-wrap">

	<section class="container">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-title"><?php _e("Search result for ","favethemes"); ?>: <?php echo get_search_query(); ?></h1>
			</div>
		</div>
		<div class="row">
			
            <div class="col-md-9">
				<?php if (have_posts()) : ?>
				<!-- search results -->
				<div class="row post-row">
					<?php while ( have_posts() ) : the_post(); 

						  $thumb_id = get_post_thumbnail_id($post->ID);
		                    $image_url = wp_get_attachment_url($thumb_id);
		                    $thumbnail = unpress_aq_resize($image_url, 290, 290, true);
					?>
					<div id="post-<?php the_ID(); ?>" <?php post_class("post-holder post-content-holder col-lg-12 col-md-12 col-sm-12 col-xs-12"); ?>>
						<div class="row">
							<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
								<div class="featured-image image-holder holder">
									<a class="overlay" href="<?php the_permalink(); ?>">
										<span class="hover">
								            <span class="hover-btn"><i class="fa fa-angle-right"></i></span>
								        </span><!-- .hover -->
										<img src="<?php echo $thumbnail; ?>" alt="<?php the_title(); ?>" />
									</a><!-- .overlay -->
									<?php if( has_tag() ): ?>
                                    <div class="tag-holder">
										<?php unpress_post_tags(); ?>
									</div><!-- .tag-holder -->
                                    <?php endif; ?>
								</div><!-- .featured-image -->
							</div><!-- col-lg-4 col-md-4 col-sm-12 col-xs-12 -->
							
							<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
								<header>
									<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									<?php unpress_author(); ?>
								</header>
								<div class="post-entry-holder">
									<?php 
										$get_the_excerpt = preg_replace( '|\[(.+?)\](.+?\[/\\1\])?|s', '', wp_trim_words( get_the_content(), '50', '...' ) );
										echo $get_the_excerpt; 
									?>
								</div><!-- .post-entry-holder -->
							</div><!-- col-lg-8 col-md-8 col-sm-12 col-xs-12 -->
						</div><!-- .row -->
					</div><!-- .post-holder -->
					<?php endwhile; ?>
                    <?php unpress_paging_nav(); ?>
				</div><!-- .row post-row -->	
				<?php else : ?>
					<p class="message"><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'favethemes' ); ?></p>
                    <?php get_search_form(); ?>
                <?php endif; ?>
			</div>
            
			<div class="col-md-3">
				<aside class="sidebar">
					<?php dynamic_sidebar("page-sidebar"); ?>
				</aside>
			</div>
		</div>
	</section>	
	
</div>

<?php get_footer(); ?>