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