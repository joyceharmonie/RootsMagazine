<?php
/*
 * Plugin Name: Instagram
 * Plugin URI: http://favethemes.com/
 * Description: A widget that displays a slider with instagram images
 * Version: 1.0
 * Author: Waqas Riaz
 * Author URI: http://favethemes.com/
 */
 
class unpress_instagram extends WP_Widget {
	
	
	/**
	 * Register widget
	**/
	public function __construct() {
		
		parent::__construct(
	 		'unpress_instagram', // Base ID
			__( 'Unpress: Instagram Slider',  'favethemes'  ), // Name
			array( 'description' => __( 'A widget that displays a slider with instagram images',  'favethemes'  ), ) // Args
		);
		
	}

	
	/** @see WP_Widget::widget */
  function widget($args, $instance) {	
    extract( $args );

	$title        = apply_filters('widget_title', $instance['title'] );
	$userid = apply_filters('userid', $instance['userid']);
    $accessToken = apply_filters('accessToken', $instance['accessToken']);
	$link_to	  = isset( $instance['images_link'] ) ? $instance['images_link'] : 'image_url';
	/*$randomise 	  = isset( $instance['randomise'] ) ? true : false;*/
	$amount    = isset( $instance['images_number'] ) ? $instance['images_number'] : 5;
	$template	  = isset( $instance['template'] ) ? $instance['template'] : 'slider';
	
	
?>
<?php echo $before_widget; 
if ( $title )
echo $before_title . $title . $after_title; ?>
                 

<?php
	

		// Pulls and parses data.
		$result = $this->fetchData('https://api.instagram.com/v1/users/'.$userid.'/media/recent/?access_token='.$accessToken.'&count='.$amount);
		$result = json_decode($result);

		$unique_key = unpress_element_key();

		?>
			
			<script type="text/javascript">
			jQuery(document).ready(function($) { 
				
				var owl = $('.widget-instagram-slider-<?php echo $unique_key; ?>');
				owl.owlCarousel({
					  autoPlay: 4500, //Set AutoPlay to 4 seconds
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
		<?php
	
		//include the template based on user choice
        if(!empty($result->data)) {

        	// Randomise Images
            //$result = $this->fave_randomise( $result->data, $randomise );

	        if($template == "slider"){
			   $this->unpress_instagram_slider($template, $result, $link_to, $unique_key);
			}
			elseif($template == "slider-overlay"){
				$this->unpress_instagram_slider_overlay($template, $result, $link_to, $unique_key);
			}
			else{
				$this->unpress_instagram_slider_thumbs($template, $result, $link_to);
			}
		}
	?>

<?php wp_reset_query(); ?>
								
<?php echo $after_widget; ?>
			 
<?php }
	
	
	/** @see WP_Widget::update */
    function update($new_instance, $old_instance) {	
	
        return $new_instance;
    }
	
	
	/** @see WP_Widget::form */
    function form($instance) {
      /* Set up some default widget settings. */
      $defaults = array(
		 'title' 		=> __('Instagram Slider', 'favethemes'),
		 'userid' 		=> '',
		 'accessToken'  => '',
		 'template' 		=> 'slider',
		 'images_link' 	=> 'image_url',
		 /*'randomise'		=> 0,*/
		 'images_number' => 6
	 );
	 $instance = wp_parse_args( (array) $instance, $defaults );
			
			
    ?>
    	<p>Generate your Instagram user ID and Instagram access token on: <a target="_blank" href="http://www.pinceladasdaweb.com.br/instagram/access-token/">Instagram access token generator</a> website</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'favethemes'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title']); ?>" />
		</p>
		<p><label for="<?php echo $this->get_field_id('userid'); ?>"><?php _e('Instagram user ID:', 'wegotext'); ?> <input class="widefat" id="<?php echo $this->get_field_id('userid'); ?>" name="<?php echo $this->get_field_name('userid'); ?>" type="text" value="<?php echo $instance['userid']; ?>" /></label></p>
	  	<p><label for="<?php echo $this->get_field_id('accessToken'); ?>"><?php _e('Instagram access token:', 'wegotext'); ?> <input class="widefat" id="<?php echo $this->get_field_id('accessToken'); ?>" name="<?php echo $this->get_field_name('accessToken'); ?>" type="text" value="<?php echo $instance['accessToken']; ?>" /></label></p>
        <p>
          <label for="<?php echo $this->get_field_id( 'template' ); ?>"><?php _e( 'Images Layout', 'favethemes' ); ?>
          <select class="widefat" name="<?php echo $this->get_field_name( 'template' ); ?>">
          <option value="slider" <?php echo ($instance['template'] == 'slider') ? ' selected="selected"' : ''; ?>><?php _e( 'Slider - Normal', 'favethemes' ); ?></option>
          <option value="slider-overlay" <?php echo ($instance['template'] == 'slider-overlay') ? ' selected="selected"' : ''; ?>><?php _e( 'Slider - Overlay Text', 'favethemes' ); ?></option>
          <option value="thumbs" <?php echo ($instance['template'] == 'thumbs') ? ' selected="selected"' : ''; ?>><?php _e( 'Thumbnails', 'favethemes' ); ?></option>
          </select>  
          </label>
       </p>
       <p>
            <?php _e('Link Images To:', 'favethemes'); ?><br>
            <label><input type="radio" id="<?php echo $this->get_field_id( 'images_link' ); ?>" name="<?php echo $this->get_field_name( 'images_link' ); ?>" value="image_url" <?php checked( 'image_url', $instance['images_link'] ); ?> /> <?php _e('Instagram Image', 'favethemes'); ?></label><br />         
            <label><input type="radio" id="<?php echo $this->get_field_id( 'images_link' ); ?>" name="<?php echo $this->get_field_name( 'images_link' ); ?>" value="user_url" <?php checked( 'user_url', $instance['images_link'] ); ?> /> <?php _e('Instagram Profile', 'favethemes'); ?></label><br />
            
         </p>
		
        <!--  <p>
            <label for="<?php echo $this->get_field_id( 'randomise' ); ?>"><?php _e( 'Randomise Images:', 'favethemes' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'randomise' ); ?>" name="<?php echo $this->get_field_name( 'randomise' ); ?>" type="checkbox" value="1" <?php checked( '1', $instance['randomise'] ); ?> />
        </p>   -->     
		<p>
			<label  for="<?php echo $this->get_field_id( 'images_number' ); ?>"><?php _e('Number of Images to Show:', 'favethemes'); ?>
			<input  class="small-text" id="<?php echo $this->get_field_id( 'images_number' ); ?>" name="<?php echo $this->get_field_name( 'images_number' ); ?>" value="<?php echo $instance['images_number']; ?>" />
			<small><?php _e('( max 20 )', 'favethemes'); ?></small>
            </label>
		</p>

			
<?php }



	// Gets our data
	function fetchData($url){
	     $ch = curl_init();
	     curl_setopt($ch, CURLOPT_URL, $url);
	     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	     curl_setopt($ch, CURLOPT_TIMEOUT, 20);
	     $result = curl_exec($ch);
	     curl_close($ch); 
	     return $result;
	}

	function unpress_instagram_slider($template, $result, $link_to, $unique_key){?>

		<div class="widget-content">
				
		<div class="unpress-instagram-slider">
		    <div class="latest-post-gallery-carousel-arrows">
		        <a class="instagram-slider-prev common-prev-<?php echo $unique_key; ?>"><i class="fa fa-angle-left"></i></a>
		        <a class="instagram-slider-next common-next-<?php echo $unique_key; ?>"><i class="fa fa-angle-right"></i></a>
		    </div>
		    <div class="widget-instagram-slider-<?php echo $unique_key; ?>">
		        <?php

		        foreach ( $result->data as $post) {


		        		if ( $link_to == 'image_url' ) {
		                    $link = $post->link;
		                } else {
		                	$link = "http://instagram.com/".$post->user->username."";
		                }

		                if( isset( $post->caption->text ) ) {
		                	$text = $post->caption->text;
		                } else {
		                	$text = '';
		                }
		                
		                echo '<div class="slide">'. "\n";
		                echo '<a target="_blank" href="'.$link.'"><img src="'.$post->images->standard_resolution->url.'" alt="'.$text.'"></a>' . "\n";
		                if ( $post->created_time ) {
		                    echo '<div class="instatime">'. human_time_diff( $post->created_time ) . __(' ago', 'favethemes').'</div>' . "\n";
		                }
		                echo '</div>' . "\n";

		        }

		        ?>
		       
		    </div>
		</div>

		</div><!-- .widget-content -->

		<?
		}


		function unpress_instagram_slider_overlay($template, $result, $link_to, $unique_key){?>

		<div class="widget-content">
				
		<div class="unpress-instagram-slider">
		    <div class="latest-post-gallery-carousel-arrows">
		        <a class="instagram-slider-prev common-prev-<?php echo $unique_key; ?>"><i class="fa fa-angle-left"></i></a>
		        <a class="instagram-slider-next common-next-<?php echo $unique_key; ?>"><i class="fa fa-angle-right"></i></a>
		    </div>
		    <div class="widget-instagram-slider-<?php echo $unique_key; ?> instagram-overlay">
		        <?php 
		        
		        foreach ( $result->data as $post) {


		        		if ( $link_to == 'image_url' ) {
		                    $link = $post->link;
		                } else {
		                	$link = "http://instagram.com/".$post->user->username."";
		                }

		                if( isset( $post->caption->text ) ) {
		                	$text = $post->caption->text;
		                } else {
		                	$text = '';
		                }


		                echo '<div class="slide">'. "\n";
						echo '<a target="_blank" href="'.$link.'"><img src="'.$post->images->standard_resolution->url.'" alt="'.$text.'"></a>' . "\n";
						echo '<div class="unpress-instagram-wrap">' . "\n";					
						echo '<div class="unpress-instagram-datacontainer">' . "\n";
						if ( $post->created_time ) {
							echo '<span class="unpress-instagram-time">'. human_time_diff( $post->created_time ) . __(' ago', 'favethemes').'</span>' . "\n";
						}
						echo '<span class="unpress-instagram-username">by <a target="_blank" href="http://instagram.com/'.$post->user->username.'">'. $post->user->username .'</a></span>' . "\n";
						if ($text) {
							echo '<span class="unpress-instagram-desc">'.$text.'</span>' . "\n";
						}
						echo '</div>' . "\n";
						echo '</div>' . "\n";
						echo '</div>' . "\n";

		        }

		        ?>
		       
		    </div>
		</div>

		</div><!-- .widget-content -->

		<?php
		}


		function unpress_instagram_slider_thumbs($template, $result, $link_to){ ?>
	
		<div class="widget-content">
				
		<ul class="unpress-instagram-thumbnails">
			<?php

				foreach ( $result->data as $post) {

		        		if ( $link_to == 'image_url' ) {
		                    $link = $post->link;
		                } else {
		                	$link = "http://instagram.com/".$post->user->username."";
		                }
		                
		                echo '<li>'. "\n";
		                echo '<a target="_blank" href="' . $link . '"><img src="' . $post->images->standard_resolution->url . '" alt=""></a>' . "\n";
		                echo '</li>' . "\n";

		        }

		    ?>
		</ul>

		</div>
		    
		<?php	
		}

		/**
		 * Randomises an array using php shuffle() function
		 *	 
		 * @param    array     $data    	    Instagram data array
		 * @param    bolean    $randomise       True or false to randomise
		 *
		 * @return array of randomised data
		 */
		/*private function fave_randomise( $data, $randomise = false ) {

			if ( true == $randomise )  {
				shuffle( $data );
			}
			return $data;
		}*/


}// end .unpress_instagram

if ( ! function_exists( 'unpress_instagram_loader' ) ) {
    function unpress_instagram_loader (){
     register_widget( 'unpress_instagram' );
    }
     add_action( 'widgets_init', 'unpress_instagram_loader' );
}


