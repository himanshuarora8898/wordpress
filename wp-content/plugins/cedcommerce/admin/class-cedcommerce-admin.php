<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       cedcommerce@work.com
 * @since      1.0.0
 *
 * @package    Cedcommerce
 * @subpackage Cedcommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cedcommerce
 * @subpackage Cedcommerce/admin
 * @author     Himanshu arora <himanshuarora@cedcoss.com>
 */
class Cedcommerce_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cedcommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cedcommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cedcommerce-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cedcommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cedcommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cedcommerce-admin.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( 'custom_js', plugin_dir_url( __FILE__ ) . 'js/custom.js', array( 'jquery' ), $this->version, false );

		wp_localize_script( 'custom_js', 'js_custom_object',
		array( 'ajax_url' => admin_url('admin-ajax.php'))
		);

	}

	//admin menu function
	public function cedcommerce_menu()
	{
		add_menu_page(
			"Boiler Page",//page title
			"Menu Boilerplate",//menu title
			"manage_options",//capability
			"cedcommerce",//slug
			array($this,"cedcommerce_dashboard"),//callback function
			"dashicons-admin-plugins",//menu icon
			5//position
		);
	}
	
	//callback function
	public function cedcommerce_dashboard()
	{
		echo "<h3>admin menu</h3>";
		$args = array(
			'public'   => true,
			'_builtin' => false
		 );
		   
		 $output = 'names'; // 'names' or 'objects' (default: 'names')
		 $operator = 'or'; // 'and' or 'or' (default: 'and')
		   
		 $post_types = get_post_types( $args, $output, $operator );
		   
		 if ( $post_types ) { // If there are any custom public post types.
		   
			 echo '<ul>';
		   
			 foreach ( $post_types  as $post_type ) {
				 
				 echo '<li><input type="checkbox" name='.$post_type.'>'. $post_type . '</li>';
			 }
		   
			 echo '<ul>';
		   
		 }
		echo "<input type='submit' name='submit' id='submit'> ";
	}


	//adding metabox to page edit
	function wporg_add_custom_box() {
		$screens = [ 'post', 'wporg_cpt' ];
		foreach ( $screens as $screen ) {
			add_meta_box(
				'boilerplate_id',                 // Unique ID
				'Custom Meta Box Title boilerplate',      // Box title
				array($this,'wporg_custom_box_html'),  // Content callback, must be of type callable
				$screen                            // Post type
			);
		}
	}
	
	function wporg_custom_box_html( $post ) {
		?>
		<label for="wporg_field">Description for this field</label>
			<input type="text" name="boilerinput" placeholder="brands">
		<?php
	}


	function wporg_save_postdata( $post_id ) {
		if ( array_key_exists( 'boilerinput', $_POST ) ) {
			update_post_meta(
				$post_id,
				'brand_boilerplate',
				$_POST['boilerinput']
			);
		}
	}

	

}
