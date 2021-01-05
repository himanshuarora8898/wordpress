<?php

/**
 * Fired during plugin activation
 *
 * @link       cedcommerce@work.com
 * @since      1.0.0
 *
 * @package    Cedcommerce
 * @subpackage Cedcommerce/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Cedcommerce
 * @subpackage Cedcommerce/includes
 * @author     Himanshu arora <himanshuarora@cedcoss.com>
 */
class Cedcommerce_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		
		
	}

	public static function is_plugin_active($plugin)
	{
		//check if dependent plugin is active 
		if (!in_array( $plugin, (array) get_option( 'active_plugins', array() ), true )){
			wp_die("<h1>Cannot activate this plugin before the dependent plugin</h1>");
			deactivate_plugins("cedcommerce/cedcommerce.php");
		}
	}
	

}
