<?php

/**
 * Fired during plugin activation
 *
 * @link       cedcommerce@work.com
 * @since      1.0.0
 *
 * @package    Ced_shoppingcart
 * @subpackage Ced_shoppingcart/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Ced_shoppingcart
 * @subpackage Ced_shoppingcart/includes
 * @author     Himanshu arora <himanshuarora@cedcoss.com>
 */
class Ced_shoppingcart_Activator {

	/**
	 * Short Description. (use period)
	 * 
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		//Creating Custom Page on Plugin activation
		
		if(!get_page_by_title('Shop')){
			$Shop = array(
				'post_title'    => 'Shop',
				'post_content'  => '[Product_shortcode]',
				'post_status'   => 'publish',
				'post_author'   => 1,
				'post_type'     => 'page',
			  );
		  
			  // Insert the post into the database
			  wp_insert_post( $Shop );
		}
		if(!get_page_by_title('Cart')){
			$Cart = array(
				'post_title'    => 'Cart',
				'post_content'  => '[Cart_shortcode]',
				'post_status'   => 'publish',
				'post_author'   => 1,
				'post_type'     => 'page',
			  );
		  
			  // Insert the post into the database
			  wp_insert_post( $Cart );
		}
		

	}

}
