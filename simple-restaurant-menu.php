<?php
/**
 * Plugin Name: Simple Restaurant Menu
 * Plugin URI: https://github.com/gamedevsteve/Simple-Restaurant-Menu
 * Description: Make a simple daily menu to display on your site.
 * Version: 0.0.1
 * Author: Steve Clark
 * Author URI: https://beardbraingames.com
 */

defined( 'ABSPATH' ) or die();

//sets a vesion number to files to bust some caches
function set_plugin_version(){
    define('DAILY_MENU_VERSION', "0.0.1");

}
add_action('init', 'set_plugin_version');

//creates the daily menu post type
function create_daily_menu_post_type(){
    $labels = array(
        'name' =>                   'Daily Menu',
        'singular_name' =>          'Daily Menu',
        'menu_name' =>              'Daily Menu',
        'name_admin_bar' =>         'Daily Menu',
        'add_new' =>                'Add New Daily Menu',
        'add_new_item' =>           'Add New Daily Menu',
        'new_item' =>               'New Daily Menu',
        'edit_item' =>              'Edit Daily Menu',
        'view_item' =>              'View Daily Menu',
        'all_items' =>              'All Daily Menu',
        'search_items' =>           'Search Daily Menus',
        'parent_item_colon' =>      'Daily Menu:',
        'not_found' =>              'No Daily Menus found.',
        'not_found_in_trash' =>     'No Daily Menus found.'
    );
    $args = array(
        'labels' =>                 $labels,
        'hierarchical' =>           false,
        'exclude_from_search' =>    true,
        'menu_position' =>          19.5,
        'capability_type' =>        array('daily-menu', 'daily-menus'),
        'map_meta_cap' =>           true,
        'public' =>                 false,
        'show_ui' =>                true,
        'show_in_menu' =>           true,
        'description' =>            'The menu of the day',
        'has_archive' =>            false,
        'rewrite' =>                array('slug' => 'daily-menu'),
        'delete_with_user' =>       false,
        'taxonomies' =>             array('category'),
        'supports' =>               array('title', 'editor', 'revisions', 'thumbnail', 'page-attributes')
    );
    register_post_type('daily-menu', $args);
}
add_action('init', 'create_daily_menu_post_type');

//Gives privelages to add/view/edit daily menu
function add_privelages_to_daily_menu(){
    $roles = array('administrator', 'editor');
    foreach($roles as $the_role){
        $role = get_role($the_role);
        $role->add_cap('read');
        $role->add_cap('read_daily-menu');
        $role->add_cap('read_private_daily-menus');
        $role->add_cap('edit_daily-menu');
        $role->add_cap('edit_daily-menus');
        $role->add_cap('edit_others_daily-menus');
        $role->add_cap('edit_published_daily-menus');
        $role->add_cap('publish_daily-menus'); 
        $role->add_cap('publish_daily-menu'); 
        $role->add_cap('delete_others_daily-menus');
        $role->add_cap('delete_others_daily-menu');
        $role->add_cap('delete_private_daily-menus');
        $role->add_cap('delete_private_daily-menu');
        $role->add_cap('delete_published_daily-menus');
        $role->add_cap('delete_published_daily-menu');
    }
}
add_action('admin_init', 'add_privelages_to_daily_menu');

// live streaming widget
function daily_menu_widget() {
    wp_enqueue_script('daily-menu-widget', plugins_url( '/admin/dashboard-widget.js', __FILE__ ), array('jquery'), DAILY_MENU_VERSION);
?>
    <h1>Today's Menu</h1>
    <div class="daily-menu widget-footer">
        <label class="h3" for="food-category">Create a food category</label>
        <br>
        <input type="text" id="food-category" name="food-category">
        <br>
        <button class="button btn-primary">Add Category</button>
    </div>
<?php
}
function add_daily_menu_widget() {
    $user = wp_get_current_user();
    $role = $user->roles[0];
    if($role == 'administrator' | $role == 'editor'){
        wp_add_dashboard_widget('daily_menu_widget', 'Daily Specials', 'daily_menu_widget', 1);
    }
}
add_action('wp_dashboard_setup', 'add_daily_menu_widget', 1);