<?php
/**
 * @package Akismet
 */
/*
Plugin Name: First Plugin
Description: Used by millions, First is quite possibly the best way in the world to <strong>protect your blog from spam</strong>. It keeps your site protected even while you sleep. To get started: activate the Akismet plugin and then go to your Akismet Settings page to set up your API key.
Version: 4.1.7
Author: Automattic
Author URI: https://automattic.com/wordpress-plugins/
License: GPLv2 or later
Text Domain: First
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
*/?>

<!-- custom post type  -->
<?php
function ced_create_movie_review() {
    register_post_type( 'movie_reviews',
        array(
            'labels' => array(
                'name' => 'Movie Reviews',
                'singular_name' => 'Movie Review',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Movie Review',
                'edit' => 'Edit',
                'edit_item' => 'Edit Movie Review',
                'new_item' => 'New Movie Review',
                'view' => 'View',
                'view_item' => 'View Movie Review',
                'search_items' => 'Search Movie Reviews',
                'not_found' => 'No Movie Reviews found',
                'not_found_in_trash' => 'No Movie Reviews found in Trash',
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
add_action('init','ced_create_movie_review');

//Add Admin menus
function ced_admin_menu() {
    add_menu_page(
        'Page Title',//page title
        'Admin menu',//menu title
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


//function called from admin menu
function wporg_options_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "wporg_options"
            settings_fields( 'wporg_options' );
            // output setting sections and their fields
            // (sections are registered for "wporg", each field is registered to a specific section)
            do_settings_sections( 'wporg' );
            // output save settings button
            submit_button( __( 'Save Settings', 'textdomain' ) );
            ?>
        </form>
    </div>
    <?php
}


?>