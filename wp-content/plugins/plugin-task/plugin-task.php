<?php
/**
 * @package Akismet
 */
/*
Plugin Name: Second Plugin
Description: Used by millions, Second is quite possibly the best way in the world to <strong>protect your blog from spam</strong>. It keeps your site protected even while you sleep. To get started: activate the Akismet plugin and then go to your Akismet Settings page to set up your API key.
Version: 4.1.7
Author: Automattic
Author URI: https://automattic.com/wordpress-plugins/
License: GPLv2 or later
Text Domain: Second
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
// custom post
function ced_create_custom_blog() {
    register_post_type( 'Blog',
        array(
            'labels' => array(
                'name' => 'Blogs',
                'singular_name' => 'Blog',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Movie Review',
                'edit' => 'Edit',
                'edit_item' => 'Edit Movie Review',
                'new_item' => 'New Movie Review',
                'view' => 'View',
                'view_item' => 'View Movie Review',
                'search_items' => 'Search Blogs',
                'not_found' => 'No Blogs found',
                'not_found_in_trash' => 'No Blogs found in Trash',
                'parent' => 'Parent Movie Review'
            ),
 
            'public' => true,
            'menu_position' => 15,
            'supports' => array( 'title', 'editor', 'comments', 'thumbnail', 'custom-fields' ),
            'taxonomies' => array( '' ),
            'has_archive' => true
        )
    );
}
add_action('init','ced_create_custom_blog');


// Creating custom the widget
class wpt_widget extends WP_Widget
{

    function __construct()
    {
        parent::__construct(

        // Base ID of your widget
        'wpt_widget',

        // Widget name will appear in UI
        __('WP_Custom Widget', 'wpb_widget_domain') ,

        // Widget description
        array(
            'description' => __('Sample widget based on WPBeginner Tutorial', 'wpb_widget_domain') ,
        ));
    }

    // Creating widget front-end
    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if(is_single()){
        if (!empty($title)) echo $args['before_title'] . $title . $args['after_title'];

        // This is where you run the code and display the output
        // echo __( 'Hello, World!', 'wpb_widget_domain' );
       
            $form="<form method='POST'>
            <div>
                <input type='email' name='email'  placeholder='Email'>
            </div>
            <div>
                <input type='submit' name='submit' value='Subscribe'>
            </div>
            <input type='hidden' name='id' value='".get_the_ID()."'>
            </form>";
            echo $form;
        }
       
        wp_reset_query();
        echo $args['after_widget'];
    }

    // Widget Backend
    public function form($instance)
    {
        if (isset($instance['title']))
        {
            $title = $instance['title'];
        }
        else
        {
            $title = __('New title', 'wpb_widget_domain');
        }
        if (isset($instance['postTypes'])) {
            $postTypes = $instance['postTypes'];
        } else {
            $postTypes = "";
        }
        // Widget admin form
        
?>
<?php
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
?>
<p>
    <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
        name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
</p>
<?php
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }

    // Class wpt_widget ends here
    
}

// Register and load the widget
function wpb_load_widgets()
{
    register_widget('wpt_widget');
}
add_action('widgets_init', 'wpb_load_widgets');



//capture and insert form values
function ced_subscriber_email()
{
    if(isset($_POST['submit']))
    {
        
        $email=isset($_POST['email'])?$_POST['email']:'';
        $page_id=$_POST['id'];
        $get_post_meta = get_post_meta($page_id, 'subscribe_us', 1);
        $arr = array();
        if(!empty($get_post_meta))
        {
            $arr[] = $email;
        }
        else
        {
            $arr = $email;
        }
        update_post_meta($page_id, 'subscribe_us', $arr);
    }
}
add_action('wp_head','ced_subscriber_email');


//Creates Subscriber table as the plugin is activated
function ced_create_Subscriber() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'Subscribers';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `email`  varchar(50) NOT NULL,
    `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY  (id)
    ) $charset_collate;";
   
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
   }
   
register_activation_hook( __FILE__, 'ced_create_Subscriber' );

?>
