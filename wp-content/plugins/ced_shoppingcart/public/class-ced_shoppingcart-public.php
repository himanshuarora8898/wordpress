<?php
session_start();
/**
 * The public-facing functionality of the plugin.
 *
 * @link       cedcommerce@work.com
 * @since      1.0.0
 *
 * @package    Ced_shoppingcart
 * @subpackage Ced_shoppingcart/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ced_shoppingcart
 * @subpackage Ced_shoppingcart/public
 * @author     Himanshu arora <himanshuarora@cedcoss.com>
 */
class Ced_shoppingcart_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		//This is the shortcode hook for displaying products on shop page
		add_shortcode('Product_shortcode',array($this,'shop_page_content'));
		
		//Filter for overriding template's content file with plugin's single file
		add_filter('single_template',array($this,'ced_single_file_override'));

		//This is the shortcode hook for displaying products cart page
		add_shortcode('Cart_shortcode',array($this,'ced_cart_page_content'));

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ced_shoppingcart-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ced_shoppingcart-public.js', array( 'jquery' ), $this->version, false );

	}

		
	/**
	 * shop_page_content
	 * 08-01-2021
	 * This is the shortcode function for displaying products on shop page
	 * @return void
	 */
	function shop_page_content(){
		$loop = new WP_Query( array('posts_per_page'=>1, 'post_type'=>'Products','paged' => get_query_var('paged') ? get_query_var('paged') : 1) );

		while ( $loop->have_posts() ) : $loop->the_post();

		the_title('<h2 class="entry-title"><a href="'.get_permalink().'" title="'. the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></h2>' );
		the_post_thumbnail();
		the_content();
		$price = get_post_meta(get_the_ID(),'Pricing_Key',1);
		$dprice = get_post_meta(get_the_ID(),'Dis_Pricing_Key',1);
		if($dprice>0)
		{
			echo 'Price:$'.$dprice.'<br>';

		}
		else
		{
			echo 'Price:$'.$price;
		}


		 
		 endwhile;
		 echo paginate_links(array(
			'current' => max( 1, get_query_var('paged') ),
			'total' => $loop->max_num_pages
			));
		
	}


		
	/**
	 * ced_single_file_override
	 * 09-01-2021
	 * Overriding the theme's content.php file with plugin's single.php file
	 * @param  mixed $single
	 * @return void
	 */
	function ced_single_file_override($single)
	{
		if(is_single() && get_post_type()=='products'){
			return plugin_dir_path(dirname(__FILE__)).'public/partials/single-products.php';
		}
		else{
			return $single;
		}
	}



		
	/**
	 * ced_cart_page_content
	 * 11-01-2021
	 * Fetching cart data and displaying cart data on cart page
	 * @return void
	 */
	function ced_cart_page_content()
	{
		if (is_user_logged_in()) 
		{
			if (isset($_GET['del'])) 
			{
                $user_id=get_current_user_id();
                $meta_val=get_user_meta($user_id, 'Cart-Data', 1);
                $del=$_GET['del'];
                unset($meta_val[$del]);
                update_user_meta($user_id, 'Cart-Data', $meta_val);
            }
			if (isset($_POST['update'])) 
			{
                $user_id=get_current_user_id();
                $meta_val=get_user_meta($user_id, 'Cart-Data', 1);
                $Id=$_POST['hidden'];
                $Qty =$_POST['quant'];
				foreach ($meta_val as $meta=>$val) 
				{
					if ($Id == $val['Id']) 
					{
                        $meta_val[$meta]['Quantity']=$Qty;
                    }
                }
                update_user_meta($user_id, 'Cart-Data', $meta_val);
            }
            $user_id=get_current_user_id();
            $upd_id=get_the_ID();
			$meta_val=get_user_meta($user_id, 'Cart-Data', 1);
            $table ="<table><tr>
			<th>Product Name</th>
			<th>Product Image</th>
			<th>Product Quantity</th>
			<th>Product Price</th>
			<th>Action</th>
			<th>Action</th></tr><tr>";
			$total=0;
			
			foreach ($meta_val as $meta=>$val)
			{
				$del=$_SERVER['REQUEST_URI']."?del=".$val['Id'];
				$table.='<form method="POST">'."<td>".$val['Name']."</td>
				<td>".$val['Image']."</td>
				<td><input type='number' min='1' name='quant'  value=".$val['Quantity']."></td>
				<td>".$val['DPrice']*$val['Quantity']."</td>
				<td><button type='submit' name='update' >Update</button></td>
				'<input type='hidden' value=".$val['Id']." name='hidden'>'
				<td><a href='$del'>Delete</a></td></tr>";
				$total+=$val['DPrice']*$val['Quantity'];
		
				$table.="</form>";
			}
			$table.="</table>";
			echo $table;
			
			
			
			
				echo "CART TOTAL : $".$total;
		}

		if(!is_user_logged_in())
		{
			if (isset($_GET['del'])) 
			{
				$del=$_GET['del'];
                unset($_SESSION['cartdata'][$del]);
                
            }
			if (isset($_POST['update'])) 
			{
                $Id=$_POST['hidden'];
				$Qty =$_POST['quant'];
				foreach ($_SESSION['cartdata'] as $cart=>$data) 
				{
				
					if ($Id == $data['Id']) 
					{
                        $_SESSION['cartdata'][$Id]['Quantity']=$Qty;
                    }
                }
                
            }
			$table ="<table><tr>
			<th>Product Name</th>
			<th>Product Image</th>
			<th>Product Quantity</th>
			<th>Product Price</th>
			<th>Action</th>
			<th>Action</th></tr><tr>";
			$total=0;
			foreach($_SESSION['cartdata'] as $key=>$val)
			{
					$del=$_SERVER['REQUEST_URI']."?del=".$val['Id'];
					$table.="<form method='POST'>"."<td>".$val['Name']."</td>
					<td>".$val['Image']."</td>
					<td><input type='number' min='1' name='quant'  value=".$val['Quantity']."></td>
					<td>".$val['DPrice']*$val['Quantity']."</td>
					<td><button type='submit' name='update' >Update</button></td>
					'<input type='hidden' value=".$val['Id']." name='hidden'>'
					<td><a href='$del'>Delete</a></td></tr>";
					$total+=$val['DPrice']*$val['Quantity'];
			
					$table.="</form>";
				}
				$table.="</table>";
				echo $table;
			
			
			
			
				echo "CART TOTAL : $".$total;
			}
		
    }
    

}
