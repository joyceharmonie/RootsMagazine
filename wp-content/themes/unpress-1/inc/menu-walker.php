<?php
/**
 * Walker class for for dropdown menu with latest posts
 * Add posts if 'latest_posts_menu' field is set to 'Add' 
 * and only for parent category.
 *
 * @package UnPress
 * @since 	UnPress 1.0
**/ 


/* Start Menu Walker */
class UnPress_Menu extends Walker_Nav_Menu {
	
	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output )
	{
		$id_field = $this->db_fields['id'];
		if ( is_object( $args[0] ) ) {
			$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
		}
		return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}
		
    function start_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);

        if ( $depth == 1 ) { $depth_class = "dropdown-menu"; } else { $depth_class = ''; }

        $output .= "\n$indent<div class=\"sub-links ".$depth_class." col-lg-3 col-md-3 col-sm-3 col-xs-12\"><ul class='list-unstyled'>\n";
		
		
    }
	
    function end_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul></div>\n";
    }
	
    function start_el( &$output, $item, $depth = 0, $args = array(), $current_object_id = 0 ) {
		
        global $wp_query;
		
		$cat = $item->object_id;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		
		$class_names = $value = '';
		
		if ( $depth == 0 && $item->object == 'category' ) {
			if ( $args->has_children ) {
				$item->classes[] = 'dropdown yamm-fw';
			}
		}else{
			if ( $args->has_children ) {
				$item->classes[] = 'dropdown';
			}
		}
		
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		
		$class_names_1 = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="' . esc_attr( $class_names_1 ) . '"';

		$class_names_for_cat = esc_attr( $class_names_1 );
        
		if ( $depth == 0 && $item->object == 'category' ) {
			$class_names_for_cat = ' class="dropdown yamm-fw ' . esc_attr( $class_names_for_cat ) . '"'; 
			$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names_for_cat .'>';
		}
		else{
			$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
		}
		
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		
		if ( $args->has_children || ( $depth == 0 && $item->object == 'category' ) ) {
			$attributes .= ' class="dropdown-toggle" href="' . esc_attr( $item->url ) .'"';
		}
		
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		if ( $args->has_children || ( $depth == 0 && $item->object == 'category') ) {
			$item_output .= '<i class="fa fa-angle-down"></i>';
		}
		$item_output .= '</a>';
		
		$children = get_posts(array('post_type' => 'nav_menu_item', 'nopaging' => true, 'numberposts' => 1, 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $item->ID));
		if ( ! empty( $children ) || ! get_field( 'latest_posts_menu', 'category_' . $cat ) || get_field( 'latest_posts_menu', 'category_' . $cat ) == 'latest_posts_on' ) {
			if ( $depth == 0 && $item->object == 'category' || $item->object == 'page' ) {
				$item_output  .= '<div class="dropdown-menu">
									<div class="yamm-content">
									  <div class="row">';
			}
		}
        $item_output .= $args->after;
		
		
		/* Add Mega menu only for: 
		 * Parent category && For categories
		 */
		if ( $depth == 0 && $item->object == 'category' ) { 
			
			$cat = $item->object_id;
			
			if ( ! get_field( 'latest_posts_menu', 'category_' . $cat ) || get_field( 'latest_posts_menu', 'category_' . $cat ) == 'latest_posts_on' ){ // Add Posts to menu if 'latest_posts' field is set to 'Add'
				
				$item_output .= '<div class="sub-posts pull-right col-lg-9 col-md-9 col-sm-9 col-xs-12">
								 <div class="row">';
					
					
					global $post;
					$post_args = array( 'numberposts' => 3, 'offset'=> 0, 'category' => $cat );
					$menuposts = get_posts( $post_args );
					
					foreach( $menuposts as $post ) : setup_postdata( $post );
					
						$post_title = get_the_title();
						$post_link = get_permalink();

						$thumb_id = get_post_thumbnail_id($post->ID);
	                    $image_url = wp_get_attachment_url($thumb_id);
	                    $post_image = unpress_aq_resize($image_url, 400, 225, true);
						
						if ( $post_image ){
							$menu_post_image = '<img src="' . $post_image. '" alt="' . $post_title . '" />';
						} elseif( unpress_first_post_image() ) {
							$menu_post_image = '<img src="' . unpress_first_post_image() . '" class="wp-post-image" alt="' . $post_title . '" />';
						} else {
							$menu_post_image = __( 'No image','themetext');
						}
						
						$item_output .= '
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<a href="' .$post_link . '">'.$menu_post_image.'</a>
									<a class="dropdown-post-title" href="' .$post_link . '">'. $post_title .'</a>
								</div>';
						
					endforeach;
					wp_reset_query();
					
				$item_output .= '</div></div>';
				
			}
			
		}
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
	
	
    function end_el( &$output, $item, $depth = 0, $args = array(), $current_object_id = 0 ) {
		$cat = $item->object_id;
		$children = get_posts(array('post_type' => 'nav_menu_item', 'nopaging' => true, 'numberposts' => 1, 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $item->ID));
		if ( ! empty( $children ) || ! get_field( 'latest_posts_menu', 'category_' . $cat ) || get_field( 'latest_posts_menu', 'category_' . $cat ) == 'latest_posts_on' ) {
			if ( $depth == 0 && $item->object == 'category' || $item->object == 'page' ) {
				$output .= "</div></div></div>\n";
			}
		}
		$output .= "</li>\n";
    }
	
}