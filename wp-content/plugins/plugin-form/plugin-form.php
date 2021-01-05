<?php
/*
Plugin Name: Form Plugin
Description: Used by millions, Form is quite possibly the best way in the world to <strong>protect your blog from spam</strong>. It keeps your site protected even while you sleep. To get started: activate the Akismet plugin and then go to your Akismet Settings page to set up your API key.
Version: 4.1.7
Author: Automattic
Author URI: https://automattic.com/wordpress-plugins/
License: GPLv2 or later
Text Domain: Form
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/
?>
<?php
//adding bootstrap for form
function ced_look_feel() 
{
    wp_enqueue_style('bootstrap4', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'); 
    wp_enqueue_script( 'boot1','https://code.jquery.com/jquery-3.3.1.slim.min.js');
    wp_enqueue_script( 'boot2','https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js');
    wp_enqueue_script( 'boot2','https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js');
}
add_action( 'wp_enqueue_scripts', 'ced_look_feel' );


//Creating shortcode for contact form
function ced_basic_form()
{
    $content="<h1>Have a query?Contact us</h1>
    <form method='POST'>
        <div>
            <input type='text' name='name' class='form-control w-50' placeholder='Name'>
        </div>
        <div>
            <input type='email' name='email' class='form-control w-50 mt-2' placeholder='Email'>
        </div>
        <div>
            <input type='number' name='phone' class='form-control w-50 mt-2' placeholder='Phone'>
        </div>
        <div>
            <input type='password' name='password' class='form-control w-50 mt-2' placeholder='Password'>
        </div>
        <div>
            <input type='submit' name='submit' class='btn-primary mt-2' value='Submit'>
        </div>
    </form>
    ";
    return $content;
}
add_shortcode('contact_form','ced_basic_form');


//capture and insert form values
function ced_basic_capture()
{
    if(isset($_POST['submit']))
    {
        $name=isset($_POST['name'])?$_POST['name']:'';
        $email=isset($_POST['email'])?$_POST['email']:'';
        $phone=isset($_POST['phone'])?$_POST['phone']:'';
        $pass=isset($_POST['password'])?$_POST['password']:'';
        $san_name = sanitize_text_field($name);
        $san_email = sanitize_text_field($email);
        $san_phone = sanitize_text_field($phone);
        $san_pass = sanitize_text_field($pass);
        global $wpdb;
        $table_name = $wpdb->prefix . "Contact_us";
        $wpdb->insert($table_name, 
        array('name' => $san_name,
         'email' => $san_email,
         'phone'=> $san_phone,
         'password'=>$san_pass) ); 

    }
  
}
add_action('wp_head','ced_basic_capture');


//Creates contact table as the plugin is activated
function ced_create_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'Contact_us';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(50) NOT NULL,
    `email`  varchar(50) NOT NULL,
    `phone`  varchar(50) NOT NULL,
    `password` varchar(50) NOT NULL,
    PRIMARY KEY  (id)
    ) $charset_collate;";
   
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
   }
   
register_activation_hook( __FILE__, 'ced_create_table' );


//function called from admin menu
function wporg_options_page_html() {
    // check user capabilities
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <table border='5' >
        <tr>
            <th><h3>ID</h3></th>
            <th><h3>NAME<h3></th>
            <th><h3>E-MAIL </h3></th>
            <th><h3>Mobile</h3></th>
        </tr>
        <?php
            global $wpdb;
            $result = $wpdb->get_results( "SELECT * FROM wp_Contact_us");
            foreach ( $result as $val )   
            {
        ?>
        <tr>
            <td><h3><?php echo $val->id; ?></h3></td>
            <td><h3><?php echo $val->name; ?></h3></td>
            <td><h3><?php echo $val->email; ?></h3></td>
            <td><h3><?php echo $val->phone; ?></h3></td>

        </tr>
        <?php 
        }
        // require_once('wp_list_table/wp_list_table.php');
        // $Customers_List = new Customers_List();
        // $Customers_List->prepare_items();
        // $Customers_List->display();
        ?>
    </table>
    </div>
    <div class="wrap">
        <h1>SUBSCRIBERS</h1>
        <table border='5' >
        <tr>
            <th><h3>ID</h3></th>
            <th><h3>E-MAIL </h3></th>
            <th><h3>DATE</h3></th>
        </tr>
        <?php
            global $wpdb;
            $result = $wpdb->get_results( "SELECT * FROM wp_Subscribers");
            foreach ( $result as $val )   
            {
        ?>
        <tr>
            <td><h3><?php echo $val->id; ?></h3></td>
            <td><h3><?php echo $val->email; ?></h3></td>
            <td><h3><?php echo $val->date; ?></h3></td>

        </tr>
        <?php 
        }
        ?>
    </table>
    </div>
    <?php
}

//Add Admin menus
function ced_admin_menu() {
    add_menu_page(
        'Admin Menu',//page title
        'Admin Menu',//menu title
        'manage_options',//capability
        'admin menu',//slug
        'wporg_options_page_html',//function
        0,//icon url
        5//position
    );
}
add_action( 'admin_menu', 'ced_admin_menu' );

function ced_admin_submenu()
{
    add_submenu_page(
        'admin menu',// parent slug
        'Page Title',//page title
        'submenu Title',//submenu title
        'manage_options',//capability
        'menu slug',//menu slug
        'wporg_options_page_html'//function
    );
}
add_action('admin_menu', 'ced_admin_submenu');


// WP_LIST_TABLE
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}


  

?>