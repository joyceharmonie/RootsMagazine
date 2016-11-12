<?php
/*
 * Plugin Name: Latest Posts
 * Plugin URI: http://favethemes.com/
 * Description: A widget that shows latest posts slider or list
 * Version: 1.0
 * Author: Waqas Riaz
 * Author URI: http://favethemes.com/
 */
 
class unpress_latest_posts extends WP_Widget {
	
	
	/**
	 * Register widget
	**/
	public function __construct() {
		
		parent::__construct(
	 		'unpress_latest_posts', // Base ID
			__( 'UnPress: Latest Posts', 'favethemes' ), // Name
			array( 'description' => __( 'Show latest posts list or slider', 'favethemes' ), ) // Args
		);
		
	}

	
	/**
	 * Front-end display of widget
	**/
	public function widget( $args, $instance ) {
				
		extract( $args );

		$title = apply_filters('widget_title', $instance['title'] );
		$items_num = $instance['items_num'];
		$category = $instance['category'];
		$rest = $instance['widget_type'];
		$widget_type = isset( $instance['widget_type'] ) ? $instance['widget_type'] : false;
		
		echo $before_widget;
			
			
			if ( $title ) echo $before_title . $title . $after_title;
            ?>
            
            <?php
			/** 
			 * Latest Posts
			**/
			global $post;
			$unpress_latest_posts = new WP_Query(
				array(
					'post_type' => 'post',
					'cat'		=> $category,
					'posts_per_page' => $items_num
				)
			);
			?>
            
            <?php $unique_key = unpress_element_key(); ?>
            <script type="text/javascript">
			jQuery(document).ready(function($) {
                
				var owl = $('.widget-latest-post-carousel-<?php echo $unique_key; ?>');
				owl.owlCarousel({
					  autoPlay: 4000, //Set AutoPlay to 4 seconds
					  stopOnHover : true,
					  navigation : false,
					  pagination: false,
    				  goToFirstSpeed : 2000,
					  slideSpeed : 800,
					  responsive : true,
					  singleItem : true,
					  autoHeight : true,
    				  //transitionStyle:"fade",
			
				  });
				  
				  // Custom Navigation Events
				  $(".common-next-<?php echo $unique_key; ?>").click(function(){
					  owl.trigger('owl.next');
				  })
				  $(".common-prev-<?php echo $unique_key; ?>").click(function(){
					  owl.trigger('owl.prev');
				  })
				  				
            });
			</script>
            
			<div class="widget-content">
		
                
                <?php if($widget_type=="slider"):?>
                
                <div class="latest-post-carousel">
				
                        <div class="latest-post-gallery-carousel-arrows">
                            <a class="latest-post-gallery-carousel-prev common-prev-<?php echo $unique_key; ?>"><i class="fa fa-angle-left"></i></a>
                            <a class="latest-post-gallery-carousel-next common-next-<?php echo $unique_key; ?>"><i class="fa fa-angle-right"></i></a>
                        </div>
                    
                        <div class="widget-latest-post-carousel-<?php echo $unique_key; ?>">
                        <?php while ( $unpress_latest_posts->have_posts() ) : $unpress_latest_posts->the_post(); ?>
                            <?php if ( '' != get_the_post_thumbnail() ) { 

                            	    $thumb_id = get_post_thumbnail_id($post->ID);
				                    $image_url = wp_get_attachment_url($thumb_id);
				                    $image_url = unpress_aq_resize($image_url, 580, 580, true);

                            	?>
                                <div class="slide">
                                    <a href="<?php the_permalink(); ?>">
                                        <span class="gallery-carousel-slide-title"><?php the_title(); ?></span>
                                        <img src="<?php echo $image_url; ?>" class="gallery-carousel-slide-image" alt="<?php the_title(); ?>" />
                                        
                                    </a>
                                </div>
                            <?php } ?>
                        <?php endwhile; ?>
						
                    </div>
                
                
                </div>
                
				<?php else: ?>
                
                <?php while ( $unpress_latest_posts->have_posts() ) : $unpress_latest_posts->the_post(); 

                	  $thumb_id = get_post_thumbnail_id($post->ID);
	                    $image_url = wp_get_attachment_url($thumb_id);
	                    $image_url = unpress_aq_resize($image_url, 580, 580, true);

                ?>
                
                <div class="latest-post">
                    <a href="<?php the_permalink(); ?>">
                        <img src="<?php echo $image_url; ?>" alt="<?php the_title(); ?>" />
                    </a>
                    <div class="latest-post-body">
                        <h4 class="heading"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        
                    </div>
                </div>
                
				<?php endwhile; ?>
				
               
			   <?php endif; ?>
               
               
            </div><!-- .widget-content -->

	    <?php 
		echo $after_widget;
		
	}
	
	
	/**
	 * Sanitize widget form values as they are saved
	**/
	public function update( $new_instance, $old_instance ) {
		
		$instance = array();

		/* Strip tags to remove HTML. For text inputs and textarea. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['items_num'] = strip_tags( $new_instance['items_num'] );
		$instance['category'] = strip_tags( $new_instance['category'] );
		$instance['widget_type'] = $new_instance['widget_type'];
		
		return $instance;
		
	}
	
	
	/**
	 * Back-end widget form
	**/
	public function form( $instance ) {
		
		/* Default widget settings. */
		$defaults = array(
			'title' => 'Latest Posts',
			'items_num' => '3',
			'category'  => '',
			'widget_type' => 'slider'
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		
	?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'favethemes'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'items_num' ); ?>"><?php _e('Maximum posts to show:', 'favethemes'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'items_num' ); ?>" name="<?php echo $this->get_field_name( 'items_num' ); ?>" value="<?php echo $instance['items_num']; ?>" size="1" />
		</p>
		<?php
		$blog_cats = get_terms('category', array('hide_empty' => false));
		$cats_array = array();
		?>
		<p>
          <label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e('Category:', 'favethemes'); ?></label>
          <select class="widefat" name="<?php echo $this->get_field_name( 'category' ); ?>">
          
          <option value=""><?php _e( 'All', 'favethemes' ); ?></option>
          <?php foreach($blog_cats as $blog_cat) { ?>
				
		  		<option <?php echo ($instance['category'] == $blog_cat->term_id ) ? ' selected="selected"' : ''; ?> value="<?php echo $blog_cat->term_id; ?>"><?php echo $blog_cat->name; ?></option>

		  <?php } ?>
          
          </select>  
          
       </p>
		
        <p>            
        	<input type="radio" id="<?php echo $this->get_field_id( 'slider' ); ?>" name="<?php echo $this->get_field_name( 'widget_type' ); ?>" <?php if ($instance["widget_type"] == 'slider') echo 'checked="checked"'; ?> value="<?php _e('slider', 'favethemes'); ?>" />
            <label for="<?php echo $this->get_field_id( 'slider' ); ?>"><?php _e( 'Display posts as Slider', 'favethemes' ); ?></label><br />
            
			<input type="radio" id="<?php echo $this->get_field_id( 'entries' ); ?>" name="<?php echo $this->get_field_name( 'widget_type' ); ?>" <?php if ($instance["widget_type"] == 'entries') echo 'checked="checked"'; ?> value="<?php _e('entries', 'favethemes'); ?>" />
            <label for="<?php echo $this->get_field_id( 'entries' ); ?>"><?php _e( 'Display posts as List', 'favethemes' ); ?></label>
        </p>
	<?php
	}

}
register_widget( 'unpress_latest_posts' );