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
		if(!get_page_by_title('Checkout')){
			$Checkout = array(
				'post_title'    => 'Checkout',
				'post_content'  => '[Checkout_shortcode]',
				'post_status'   => 'publish',
				'post_author'   => 1,
				'post_type'     => 'page',
			  );
		  
			  // Insert the post into the database
			  wp_insert_post( $Checkout );
		}
		if(!get_page_by_title('Thankyou')){
			$Checkout = array(
				'post_title'    => 'Thankyou',
				'post_content'  => '[Thankyou_shortcode]',
				'post_status'   => 'publish',
				'post_author'   => 1,
				'post_type'     => 'page',
			  );
		  
			  // Insert the post into the database
			  wp_insert_post( $Checkout );
		}
		
		global $wpdb;
		$table_name = $wpdb->prefix . 'order_details';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			`order_id` int(11) NOT NULL AUTO_INCREMENT,
			`user_id` int(11) NOT NULL,
			`customer_details` varchar(50) NOT NULL,
			`customer_address` varchar(50) NOT NULL,
			`product_details` varchar(50) NOT NULL,
			`payment_method` varchar(50) NOT NULL,
			PRIMARY KEY (`order_id`)
		   )  $charset_collate;
		   ";
	
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

	}

}
