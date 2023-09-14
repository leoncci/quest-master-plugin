<?php
/*
Plugin Name: Quest Master
Description: Quest Master Game
Version: 1.0
Author: Leon Morival
*/
// Define the function to create the table
function create_custom_table_on_activation() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'questmaster';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        username varchar(255) NOT NULL,
        score int(11) NOT NULL
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Hook the table creation function into the activation hook
register_activation_hook(__FILE__, 'create_custom_table_on_activation');
// Register a shortcode to embed the game
include 'lib/shortcodes.php';

function my_simple_plugin_settings_page() {
    // Display your admin settings here
}


function my_simple_plugin_menu() {
add_menu_page(
    'My Simple Plugin',
    'Quest Master',
    'manage_options',
    'my-simple-plugin',
    'my_simple_plugin_settings_page'
);
}
add_action('admin_menu', 'my_simple_plugin_menu');
// Register the activation hook
register_activation_hook(__FILE__, 'create_empty_pages_on_activation');

function create_empty_pages_on_activation() {
    // Array of page titles
    $page_titles = array('game', 'win', 'view');

    // Loop through the page titles and create the pages
    foreach ($page_titles as $title) {
        $page = array(
            'post_title'    => $title,
            'post_content'  => '',
            'post_status'   => 'publish',
            'post_type'     => 'page'
        );

        // Insert the page into the database
        $page_id = wp_insert_post($page);

        // Assign the custom template to the newly created page
        update_post_meta($page_id, '_wp_page_template', 'custom-template.php');
    }
}