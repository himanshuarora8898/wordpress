<?php
/**Plugin Name: Meta box Plugin
* Plugin URI: https://example.com/plugins/the-basics/
* Description: Basic Form with the plugin.
* Version: 1.0
* Requires at least: 00
* Requires PHP: 00
* Author: Himanshu arora
* Author URI: https://author.example.com/
* License: GPL v2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: my-basics-form-plugin
* Domain Path: /languages
*/

// 2-01-2021 Custom Meta box (function)
function wporg_add_custom_box()
{
    $screens = [ 'post', 'wporg_cpt' ];
foreach ( $screens as $screen ) {
add_meta_box(
'wporg_box_id', // Unique ID
'Custom Meta Box Title', // Box title
'wporg_custom_box_html', // Content callback, must be of type callable
$screen // Post type
);
}
}
add_action( 'add_meta_boxes', 'wporg_add_custom_box' );

// 2-01-2021 Custom Meta box (html)
function wporg_custom_box_html( $post )
{
?>
<label for="color_name">Description for this field--(Pick Color)</label>
<input type="text" name="color_name" value="<?php echo $post->color; ?>"></input>
</select>
<?php
}

// 2-01-2021 Custom Meta box (Saving Values)
function wporg_save_postdata( $post_id )
{
if ( array_key_exists( 'color_name', $_POST ) ) {
update_post_meta(
$post_id,
'color',
$_POST['color_name']
);
}
}
add_action( 'save_post', 'wporg_save_postdata' );

add_option('customcolors');

// 2-01-2021 Admin Menus
function wporg_options_page()
{
add_menu_page(
'Admin Menu Metabox display', //menu title
'Admin Menu Metabox', //menu name
'manage_options', // capabality
'menu', //slug
'wporg_options_page_html', //function
0,
9 //position
);

add_submenu_page(
'menu', // parent slug
// 'Submenu1', //menu title
'Submenu1', //menu name
'manage_options', // capabality
'submenu1', //slug
'wporg_options_page_html' //function
);
}
add_action( 'admin_menu', 'wporg_options_page' );

// 29-12-2020 MENU BY PLUGIN
function wporg_options_page_html()
{

?>
<div class="wrap">
<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
<?php

$args = array(
'public' => true,
'_builtin' => false
);

$checked='';
$output = 'names'; // 'names' or 'objects' (default: 'names')
$operator = 'or'; // 'and' or 'or' (default: 'and')

$post_types = get_post_types( $args, $output, $operator );

if (is_array( $post_types ))
{
// If there are any custom public post types.
echo '<form method="POST">';
foreach ( $post_types as $post_type )
{
if(in_array($post_type, get_option('customcolors')))
{
$checked="checked";
}
else
{
$checked="";
}
?>
<input type="checkbox"
name="posttype[]" value="<?php echo $post_type; ?>"
<?php echo $checked ?> />
<?php echo $post_type ?>
<?php
}
echo '<input type="submit" name="submit" value="Save">';
echo '</form>';
}
?>
</div>
<?php
}

if(isset($_POST['submit']))
{
$post_value = isset($_POST['posttype']) ? ($_POST['posttype']) : "";
update_option('customcolors', $post_value);
}
?>