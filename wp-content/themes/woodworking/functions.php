<?php
//Adding css to page
function woodworking()
{
    wp_enqueue_style('style', get_stylesheet_uri());

}
add_action('wp_enqueue_scripts', 'woodworking');

//Regiter Nav menus
function register_my_menus()
{
    register_nav_menus(array(
        'header-menu' => __('Header Menu')

    ));
}
add_action('init', 'register_my_menus');

function woodworking_theme_support()
{

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    // Custom background color.
    add_theme_support('custom-background', array(
        'default-color' => 'f5efe0',
    ));

    // Set content-width.
    global $content_width;
    if (!isset($content_width))
    {
        $content_width = 580;

    }

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
    */
    add_theme_support('post-thumbnails');

    // Set post thumbnail size.
    set_post_thumbnail_size(1200, 9999);

    // Add custom image size used in Cover Template.
    add_image_size('woodworking-fullscreen', 1980, 9999);

    // Custom logo.
    $logo_width = 120;
    $logo_height = 90;

    // If the retina setting is active, double the recommended width and height.
    if (get_theme_mod('retina_logo', false))
    {
        $logo_width = floor($logo_width * 2);
        $logo_height = floor($logo_height * 2);
    }

    add_theme_support('custom-logo', array(
        'height' => $logo_height,
        'width' => $logo_width,
        'flex-height' => true,
        'flex-width' => true,
    ));

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
    */
    add_theme_support('title-tag');

    /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.This is Wood Working , a free, fully standards-compliant CSS template designed by FreeCSSTemplates.org. The picture in this template is from PDPhoto.org. This free template is released under a Creative Commons Attributions license, so you’re pretty much free to do whatever you want with it (even use it commercially) provided you keep the links in the footer intact. Aside from that, have fun with it :)
    
    Sed lacus. Donec lectus. Nullam pretium nibh ut turpis. Nam bibendum. In nulla tortor, elementum ipsum. Proin imperdiet est. Phasellus dapibus semper urna. Pellentesque ornare, orci in felis. Donec ut ante. In id eros. Suspendisse lacus turpis at sem. Sed lacus. Donec lectus. Nullam pretium nibh ut turpis.
    */
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'script',
        'style',
        'navigation-widgets',
    ));

}

add_action('after_setup_theme', 'woodworking_theme_support');

//ADD portfolio to table items
function portfolio_register()
{
    $args = array(
        'label' => __('Portfolio') ,
        'singular_label' => __('Project') ,
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => true,
        'supports' => array(
            'title',
            'editor',
            'thumbnail'
        )
    );

    register_post_type('portfolio', $args);
}
// widgets
function themename_widgets_init()
{
    register_sidebar(array(
        'name' => __('Primary Sidebar', 'theme_name') ,
        'id' => 'sidebar-1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('Secondary Sidebar', 'theme_name') ,
        'id' => 'sidebar-2',
        'before_widget' => '<ul><li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li></ul>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'themename_widgets_init');

// custom post
function custom_post_type()
{

    // Set UI labels for Custom Post Type
    $labels = array(
        'name' => _x('Portfolio', 'Post Type General Name', 'woodworking') ,
        'singular_name' => _x('Portfolio', 'Post Type Singular Name', 'woodworking') ,
        'menu_name' => __('Portfolio', 'woodworking') ,
        'parent_item_colon' => __('Parent Portfolio', 'woodworking') ,
        'all_items' => __('All Portfolio', 'woodworking') ,
        'view_item' => __('View Portfolio', 'woodworking') ,
        'add_new_item' => __('Add New Portfolio', 'woodworking') ,
        'add_new' => __('Add New', 'woodworking') ,
        'edit_item' => __('Edit Portfolio', 'woodworking') ,
        'update_item' => __('Update Portfolio', 'woodworking') ,
        'search_items' => __('Search Portfolio', 'woodworking') ,
        'not_found' => __('Not Found', 'woodworking') ,
        'not_found_in_trash' => __('Not found in Trash', 'woodworking') ,
    );

    // Set other options for Custom Post Type
    $args = array(
        'label' => __('Portfolio', 'woodworking') ,
        'description' => __('Portfolio news and reviews', 'woodworking') ,
        'labels' => $labels,
        // Features this CPT supports in Post Editor
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'author',
            'thumbnail',
            'comments',
            'revisions',
            'custom-fields',
        ) ,
        // You can associate this CPT with a taxonomy or custom taxonomy.
        'taxonomies' => array(
            'genres'
        ) ,
        /* A hierarchical CPT is like Pages and can have
         * Parent and child items. A non-hierarchical CPT
         * is like Posts.
        */
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'show_in_rest' => true,

    );

    // Registering your Custom Post Type
    register_post_type('Portfolio', $args);

}

/* Hook into the 'init' action so that the function
 * Containing our post type registration is not
 * unnecessarily executed.
*/

add_action('init', 'custom_post_type', 0);

// Creating the widget
class wpb_widget extends WP_Widget
{

    function __construct()
    {
        parent::__construct(

        // Base ID of your widget
        'wpb_widget',

        // Widget name will appear in UI
        __('WPBeginner Widget', 'wpb_widget_domain') ,

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
        if (!empty($title)) echo $args['before_title'] . $title . $args['after_title'];

        // This is where you run the code and display the output
        // echo __( 'Hello, World!', 'wpb_widget_domain' );
        $loop = new WP_Query(array(
            'post_type' => 'Portfolio',
            'posts_per_page' => 10
        ));
        while ($loop->have_posts()):
            $loop->the_post();
            the_title('<h2 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></h2>');
        endwhile;
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
        // Widget admin form
        
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

    // Class wpb_widget ends here
    
}

// Register and load the widget
function wpb_load_widget()
{
    register_widget('wpb_widget');
}
add_action('widgets_init', 'wpb_load_widget');


//Adding custom taxonomy in portfolio
function wporg_register_taxonomy_category() {
  $labels = array(
      'name'              => _x( 'Categories', 'taxonomy general name' ),
      'singular_name'     => _x( 'Categories', 'taxonomy singular name' ),
      'search_items'      => __( 'Search Categories' ),
      'all_items'         => __( 'All Categories' ),
      'parent_item'       => __( 'Parent Categories' ),
      'parent_item_colon' => __( 'Parent Categories:' ),
      'edit_item'         => __( 'Edit Categories' ),
      'update_item'       => __( 'Update Categories' ),
      'add_new_item'      => __( 'Add New Categories' ),
      'new_item_name'     => __( 'New Categories Name' ),
      'menu_name'         => __( 'Categories' ),
  );
  $args   = array(
      'hierarchical'      => true, // make it hierarchical (like categories)
      'labels'            => $labels,
      'show_ui'           => true,
      'show_admin_column' => true,
      'query_var'         => true,
      'rewrite'           => [ 'slug' => 'Categories' ],
  );
  register_taxonomy( 'Categories', [ 'portfolio' ], $args );

  $labels = array(
    'name'              => _x( 'Tags', 'taxonomy general name' ),
    'singular_name'     => _x( 'Tags', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Tags' ),
    'all_items'         => __( 'All Tags' ),
    'parent_item'       => __( 'Parent Tags' ),
    'parent_item_colon' => __( 'Parent Tags:' ),
    'edit_item'         => __( 'Edit Tags' ),
    'update_item'       => __( 'Update Tags' ),
    'add_new_item'      => __( 'Add New Tags' ),
    'new_item_name'     => __( 'New Tags Name' ),
    'menu_name'         => __( 'Tags' ),
);
$args   = array(
    'hierarchical'      => false, // don't make it hierarchical, it should be unique(unlike categories)
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => [ 'slug' => 'Tags' ],
);
  register_taxonomy( 'Tags', [ 'portfolio' ], $args );
}
add_action( 'init', 'wporg_register_taxonomy_category' );


function name_title($title)
{
    if(is_single() && get_post_type()=="portfolio" && get_post_type()!='header-menu'){
        $title=$title.the_author();

    }
    
    return $title;
}

add_filter('the_title','name_title',10,1);



?>
