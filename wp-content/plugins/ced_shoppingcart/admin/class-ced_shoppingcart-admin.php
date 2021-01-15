<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       cedcommerce@work.com
 * @since      1.0.0
 *
 * @package    Ced_shoppingcart
 * @subpackage Ced_shoppingcart/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ced_shoppingcart
 * @subpackage Ced_shoppingcart/admin
 * @author     Himanshu arora <himanshuarora@cedcoss.com>
 */
class Ced_shoppingcart_Admin {

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
		 * defined in Ced_shoppingcart_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ced_shoppingcart_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ced_shoppingcart-admin.css', array(), $this->version, 'all' );

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
		 * defined in Ced_shoppingcart_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ced_shoppingcart_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ced_shoppingcart-admin.js', array( 'jquery' ), $this->version, false );

	}

	
	/**
	 * ced_custom_post
	 * 08-01-2021
	 * creating custom post named Products
	 * @return void
	 */
	public function ced_custom_post()
	{
		register_post_type( 'Products',
        array(
            'labels' => array(
                'name' => 'Products',
                'singular_name' => 'Product',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Product',
                'edit' => 'Edit',
                'edit_item' => 'Edit Product',
                'new_item' => 'New Product',
                'view' => 'View',
                'view_item' => 'View Product',
                'search_items' => 'Search Products',
                'not_found' => 'No Products found',
                'not_found_in_trash' => 'No Products found in Trash'
            ),
 
			'public' => true,
			'menu_icon'=> 'dashicons-cart',
            'menu_position' => 15,
            'supports' => array( 'title', 'editor', 'comments', 'thumbnail' ),
            'taxonomies' => array( '' ),
            'has_archive' => true
        )
    );
	}


		
	/**
	 * ced_metabox_inventory
	 * 08-01-2021
	 * Creating metabox for inventory and adding to post meta table
	 * @return void
	 */
	function ced_metabox_inventory() {
		$post_type = [ 'Products'];
		add_meta_box(
			'inventory_metabox',// Unique ID
			'Inventory',// Box title
			array($this,'ced_inventorybox_html'),  // Content callback, must be of type callable
			$post_type// Post type
		);
	}
		
	/**
	 * ced_inventorybox_html
	 * 08-01-2021
	 * html for inventory box
	 * @param  mixed $post
	 * @return void
	 */
	function ced_inventorybox_html( $post ) {
		?>
		<label for="inventory">Inventory</label>
			<input type="number" name="inventory" min="0" id="inventory" placeholder="Total Inventory" value="<?php echo $post->Inventory_Key;?>" required>
		    <p id="ierror" hidden></p>
		<?php
	}

	
	/**
	 * ced_save_inventorydata
	 * 08-01-2021
	 * Saving the metabox value to post_meta table
	 * @param  mixed $post_id
	 * @return void
	 */
	function ced_save_inventorydata( $post_id ) {
		if ( array_key_exists( 'inventory', $_POST ) && $_POST['inventory']>0 ) {
			update_post_meta(
				$post_id,
				'Inventory_Key',
				$_POST['inventory']
			);
		}
	}

	
	/**
	 * ced_metabox_pricing
	 * 08-01-2021
	 * Creating metabox for pricing and adding to post meta table
	 * @return void
	 */
	function ced_metabox_pricing() {
		$post_type = [ 'Products'];
		add_meta_box(
			'pricing_metabox',// Unique ID
			'Pricing',// Box title
			array($this,'ced_pricingbox_html'),  // Content callback, must be of type callable
			$post_type// Post type
		);
	}

	/**
	 * ced_pricingbox_html
	 * 08-01-2021
	 * html for pricing box
	 * @param  mixed $post
	 * @return void
	 */
	function ced_pricingbox_html( $post ) {
		?>
		<label for="dprice">Discounted Price</label>
			<input type="number" min="0" name="dprice" id="dprice" placeholder="Discounted Price" value="<?php echo $post->Dis_Pricing_Key;?>" required>
			<p id="derror" hidden></p>
			<h1>OR</h1>
		<label for="price">Original Price</label>	
			<input type="number" min="0" name="price" id="price" placeholder="Original Price" value="<?php echo $post->Pricing_Key;?>" required>
		    
		<?php
	}


	/**
	 * ced_save_pricingdata
	 * 08-01-2021
	 * Saving the discounted metabox value to post_meta table
	 * @param  mixed $post_id
	 * @return void
	 */
	function ced_save_pricingdata( $post_id ) {
		if ( array_key_exists( 'dprice', $_POST ) && $_POST['dprice']< $_POST['price']) {
			update_post_meta(
				$post_id,
				'Dis_Pricing_Key',
				$_POST['dprice']
			);
		}
		else{
			// echo "<script>alert('discount price cannot be greater than regular price')</script>";
		}
	}

	
	/**
	 * ced_save_oprice
	 * 08-01-2021
	 * Saving the original price value to post meta table
	 * @param  mixed $post_id
	 * @return void
	 */
	function ced_save_oprice($post_id){
		if(array_key_exists( 'price' ,$_POST) && $_POST['price']>$_POST['dprice']){
			update_post_meta(
				$post_id,
				'Pricing_Key',
				$_POST['price']
			);
		}
	}


	
 	
	/**
	 * ced_register_custom_fields
	 * 08-01-2021
	 * Creating custom taxonomy for the page products
	 * @return void
	 */
	function ced_register_custom_fields() {
		// custom field clothing
		$labels = array(
			'name'              => _x( 'Custom_Taxonomy', 'taxonomy general name' ),
			'singular_name'     => _x( 'Custom_Taxonomy', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Custom_Taxonomy' ),
			'all_items'         => __( 'All Custom_Taxonomy' ),
			'parent_item'       => __( 'Parent Custom_Taxonomy' ),
			'parent_item_colon' => __( 'Parent Custom_Taxonomy:' ),
			'edit_item'         => __( 'Edit Custom_Taxonomy' ),
			'update_item'       => __( 'Update Custom_Taxonomy' ),
			'add_new_item'      => __( 'Add New Custom_Taxonomy' ),
			'new_item_name'     => __( 'New Custom_Taxonomy Name' ),
			'menu_name'         => __( 'Custom_Taxonomy' ),
		);
		$args   = array(
			'hierarchical'      => true, 
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => [ 'slug' => 'Custom_Taxonomy' ],
		);
		register_taxonomy( 'Custom_Taxonomy', [ 'products' ], $args );
		
	  }

}