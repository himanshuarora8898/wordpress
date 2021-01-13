<?php
/**
 * Plugin Name: Create Posts
 * Description: A Plugin that helps you create pages Beautifully.
 * Version: 1.0.0
 * Author: Himanshu Arora
 * Text Domain: woocommerce
 * Domain Path: /i18n/languages/
 * Requires at least: 5.3
 * Requires PHP: 7.0
 *
 * @package Posts
 */

//Add Admin menus
function ced_admin_menu() {
    add_menu_page(
        'Page Title',//page title
        'Add Admin menu',//menu title
        'manage_options',//capability
        'admin menu',//slug
        'wporg_options_page_html',//function
        'dashicons-update-alt',//icon url
        10//position
    );
}
add_action( 'admin_menu', 'ced_admin_menu' );

//Form for creating page
function wporg_options_page_html()
{
    echo "<h1>Create your own custom page</h1>";
    echo "<form method='POST'>
    <input type='text' name='menu' placeholder='Menu Name' id='name'>
    <input type='submit' name='submit' id='id' value='Add menu'></form>";

    $get = get_option('Create new posts');
    foreach($get as $posts){
       echo"<form method='POST'>
       <input type='checkbox' name='posts'>$posts
       <a href='http://localhost/wordpress/wp-admin/admin.php?page=admin+menu&id=$posts'>Delete</a></form><br>";
    }

    if(isset($_GET['id']))
    {
        $del =$_GET['id'];
        $get = get_option('Create new posts');
        if (in_array($del, $get)) 
        {
            unset($get[array_search($del,$get)]);
        }
    update_option('Create new posts',$get);    
    }
}



function ced_create_post()
{
    if(isset($_POST['submit']))
    {
        $menu=isset($_POST['menu'])?($_POST['menu']):'';
        // add_option('Create new posts',$menu);
        $get_menu_value = get_option('Create new posts');
        if(!empty($get_menu_value))
        {
            $get_menu_value[]=$menu;
        }
        else
        {
            $get_menu_value = array($menu);
        }
        update_option('Create new posts',$get_menu_value);
    }
   
}
add_action('init','ced_create_post');

// custom post
function ced_create_custom_blog() {
    $get=get_option('Create new posts');
    foreach($get as $val){
        register_post_type($val,
        array(
            'labels' => array(
                'name' => $val,
                'singular_name' => $val,
                'add_new' => 'Add New'.$val,
                'add_new_item' => 'Add New Movie Review'.$val,
                'edit' => 'Edit'.$val,
                'edit_item' => 'Edit Movie Review'.$val,
                'new_item' => 'New Movie Review'.$val,
                'view' => 'View'.$val,
                'view_item' => 'View Movie Review'.$val,
                'search_items' => 'Search Blogs'.$val,
                'not_found' => 'No Blogs found'.$val,
                'not_found_in_trash' => 'No Blogs found in Trash'.$val,
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
    
}
add_action('init','ced_create_custom_blog');


?>