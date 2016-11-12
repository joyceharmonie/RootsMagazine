<?php
/*
Name:  WordPress Post Like System
Description:  A simple and efficient post like system for WordPress.
Version:      0.3.2
Author:       Jon Masterson
Author URI:   http://jonmasterson.com/
*/
 
/**
 * (1) Enqueue scripts for like system
 */
function like_scripts() {
	wp_enqueue_script( 'jm_like_post', get_template_directory_uri().'/js/post-like.js', array('jquery'), '1.0', 1 );
	wp_localize_script( 'jm_like_post', 'ajax_var', array(
		'url' => admin_url( 'admin-ajax.php' ),
		'nonce' => wp_create_nonce( 'ajax-nonce' )
		)
	);
}
add_action( 'init', 'like_scripts' );

/**
 * (2) Add Fontawesome Icons
 */
function enqueue_icons () {
	wp_register_style( 'icon-style', 'http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css' );
    wp_enqueue_style( 'icon-style' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_icons' );

/**
 * (3) Save like data
 */
add_action( 'wp_ajax_nopriv_jm-post-like', 'jm_post_like' );
add_action( 'wp_ajax_jm-post-like', 'jm_post_like' );
function jm_post_like() {
	$nonce = $_POST['nonce'];
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ( 'Nope!' );
	
	if ( isset( $_POST['jm_post_like'] ) ) {
	
		$post_id = $_POST['post_id']; // post id
		$post_like_count = get_post_meta( $post_id, "_post_like_count", true ); // post like count
		
		if ( is_user_logged_in() ) { // user is logged in
			global $current_user;
			$user_id = $current_user->ID; // current user
			$meta_POSTS = ( is_multisite() ) ? get_user_option( "_liked_posts", $user_id  ) : get_user_meta( $user_id, "_liked_posts" ); // post ids from user meta
			$meta_USERS = get_post_meta( $post_id, "_user_liked" ); // user ids from post meta
			$liked_POSTS = NULL; // setup array variable
			$liked_USERS = NULL; // setup array variable
			
			if ( count( $meta_POSTS ) != 0 ) { // meta exists, set up values
				$liked_POSTS = $meta_POSTS[0];
			}
			
			if ( !is_array( $liked_POSTS ) ) // make array just in case
				$liked_POSTS = array();
				
			if ( count( $meta_USERS ) != 0 ) { // meta exists, set up values
				$liked_USERS = $meta_USERS[0];
			}		

			if ( !is_array( $liked_USERS ) ) // make array just in case
				$liked_USERS = array();
				
			$liked_POSTS['post-'.$post_id] = $post_id; // Add post id to user meta array
			$liked_USERS['user-'.$user_id] = $user_id; // add user id to post meta array
			$user_likes = count( $liked_POSTS ); // count user likes
	
			if ( !AlreadyLiked( $post_id ) ) { // like the post
				update_post_meta( $post_id, "_user_liked", $liked_USERS ); // Add user ID to post meta
				update_post_meta( $post_id, "_post_like_count", ++$post_like_count ); // +1 count post meta
				if ( is_multisite() ) { // if multisite support
					update_user_option( $user_id, "_liked_posts", $liked_POSTS ); // Add post ID to user meta
					update_user_option( $user_id, "_user_like_count", $user_likes ); // +1 count user meta
				} else {
					update_user_meta( $user_id, "_liked_posts", $liked_POSTS ); // Add post ID to user meta
					update_user_meta( $user_id, "_user_like_count", $user_likes ); // +1 count user meta
				}
				echo $post_like_count; // update count on front end

			} else { // unlike the post
				$pid_key = array_search( $post_id, $liked_POSTS ); // find the key
				$uid_key = array_search( $user_id, $liked_USERS ); // find the key
				unset( $liked_POSTS[$pid_key] ); // remove from array
				unset( $liked_USERS[$uid_key] ); // remove from array
				$user_likes = count( $liked_POSTS ); // recount user likes
				update_post_meta( $post_id, "_user_liked", $liked_USERS ); // Remove user ID from post meta
				update_post_meta($post_id, "_post_like_count", --$post_like_count ); // -1 count post meta
				if ( is_multisite() ) { // if multisite support
					update_user_option( $user_id, "_liked_posts", $liked_POSTS ); // Remove post ID from user meta			
					update_user_option( $user_id, "_user_like_count", $user_likes ); // -1 count user meta
				} else {
					update_user_meta( $user_id, "_liked_posts", $liked_POSTS ); // Add post ID to user meta
					update_user_meta( $user_id, "_user_like_count", $user_likes ); // +1 count user meta
				}
				echo "already".$post_like_count; // update count on front end
				
			}
			
		} else { // user is not logged in (anonymous)
			$ip = $_SERVER['REMOTE_ADDR']; // user IP address
			$meta_IPS = get_post_meta( $post_id, "_user_IP" ); // stored IP addresses
			$liked_IPS = NULL; // set up array variable
			
			if ( count( $meta_IPS ) != 0 ) { // meta exists, set up values
				$liked_IPS = $meta_IPS[0];
			}
	
			if ( !is_array( $liked_IPS ) ) // make array just in case
				$liked_IPS = array();
				
			if ( !in_array( $ip, $liked_IPS ) ) // if IP not in array
				$liked_IPS['ip-'.$ip] = $ip; // add IP to array
			
			if ( !AlreadyLiked( $post_id ) ) { // like the post
				update_post_meta( $post_id, "_user_IP", $liked_IPS ); // Add user IP to post meta
				update_post_meta( $post_id, "_post_like_count", ++$post_like_count ); // +1 count post meta
				echo $post_like_count; // update count on front end
				
			} else { // unlike the post
				$ip_key = array_search( $ip, $liked_IPS ); // find the key
				unset( $liked_IPS[$ip_key] ); // remove from array
				update_post_meta( $post_id, "_user_IP", $liked_IPS ); // Remove user IP from post meta
				update_post_meta( $post_id, "_post_like_count", --$post_like_count ); // -1 count post meta
				echo "already".$post_like_count; // update count on front end
				
			}
		}
	}
	
	exit;
}

/**
 * (4) Test if user already liked post
 */
function AlreadyLiked( $post_id ) { // test if user liked before
	if ( is_user_logged_in() ) { // user is logged in
		$user_id = get_current_user_id(); // current user
		$meta_USERS = get_post_meta( $post_id, "_user_liked" ); // user ids from post meta
		$liked_USERS = ""; // set up array variable
		
		if ( count( $meta_USERS ) != 0 ) { // meta exists, set up values
			$liked_USERS = $meta_USERS[0];
		}
		
		if( !is_array( $liked_USERS ) ) // make array just in case
			$liked_USERS = array();
			
		if ( in_array( get_current_user_id(), $liked_USERS ) ) { // True if User ID in array
			return true;
		}
		return false;
		
	} else { // user is anonymous, use IP address for voting
	
		$meta_IPS = get_post_meta( $post_id, "_user_IP" ); // get previously voted IP address
		$ip = $_SERVER["REMOTE_ADDR"]; // Retrieve current user IP
		$liked_IPS = ""; // set up array variable
		
		if ( count( $meta_IPS ) != 0 ) { // meta exists, set up values
			$liked_IPS = $meta_IPS[0];
		}
		
		if ( !is_array( $liked_IPS ) ) // make array just in case
			$liked_IPS = array();
		
		if ( in_array( $ip, $liked_IPS ) ) { // True is IP in array
			return true;
		}
		return false;
	}
	
}

/**
 * (5) Front end button
 */
function getPostLikeLink( $post_id ) {
	$like_count = get_post_meta( $post_id, "_post_like_count", true ); // get post likes
	$count = ( empty( $like_count ) || $like_count == "0" ) ? '' : '&nbsp;-&nbsp;'.$like_count;
	if ( AlreadyLiked( $post_id ) ) {
		$class = __(  ' liked', 'favethemes' );
		$title = __( 'Unlike', 'favethemes' );
		$heart = '<i class="fa fa-heart"></i>';
	} else {
		$class = __( ' classlike', 'favethemes' );
		$title = __( 'Like', 'favethemes' );
		$heart = '<i class="fa fa-heart"></i>';
	}
	$output = '<a href="#" class="jm-post-like'.esc_attr( $class ).' " data-post_id="'.esc_attr( $post_id ).'" title="'.esc_attr( $title ).'">'.$heart.'&nbsp;'.$title.$count.'</a><span class="jm-load"></span>';
	return $output;
}



/**
 * (6) Add a shortcode to your posts instead
 * type [jmliker] in your post to output the button
 */
function jm_like_shortcode() {
	return getPostLikeLink( get_the_ID() );
}
add_shortcode('jmliker', 'jm_like_shortcode');

/**
 * (7) Get total likes
 */
function totalLikes( $post_id ) {
	$like_count = get_post_meta( $post_id, "_post_like_count", true ); // get post likes
	$count = ( empty( $like_count ) || $like_count == "0" ) ?  __( 'Like', 'favethemes' ) : $like_count;
	if ( AlreadyLiked( $post_id ) ) {
		$class = __(  ' liked', 'favethemes' );
		$title = __( 'Unlike', 'favethemes' );
		$heart = '<i class="fa fa-heart"></i>';
	} else {
		$class = __( ' classlike', 'favethemes' );
		$title = __( 'Like', 'favethemes' );
		$heart = '<i class="fa fa-heart"></i>';
	}
	$output = '<a href="#" class="jm-post-like'.esc_attr( $class ).' " data-post_id="'.esc_attr( $post_id ).'" title="'.esc_attr( $title ).'">'.$heart.'&nbsp;'.$count.'</a><span class="jm-load"></span>';
	return $output;
}