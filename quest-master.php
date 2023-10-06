<?php
/*
Plugin Name: Quest Master
Description: Quest Master Game
Version: 1.0
Author: Leon Morival
*/

// Define the function to create the questmaster table
function enqueue_bootstrap_scripts_and_styles() {
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_bootstrap_scripts_and_styles');

function create_questmaster_table_on_activation() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'questmaster';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        username varchar(255) NOT NULL,
        score int(11) NOT NULL,
      
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
function create_shop_table_on_activation() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'shop';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        name varchar(50) NOT NULL,
        price int(11) NOT NULL,
        power int(11) NOT NULL,
        health  int(11) NOT NULL
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
// Define the function to create the shop table

// Hook the table creation functions into the activation hook
register_activation_hook(__FILE__, 'create_questmaster_table_on_activation');
register_activation_hook(__FILE__, 'create_shop_table_on_activation');

// Register a shortcode to embed the game
include 'lib/shortcodes.php';

// Add menu pages
function my_simple_plugin_menu() {
    // Add the main menu item
    add_menu_page(
        'Quest Master',
        'Quest Master',
        'manage_options',
        'quest-master',
        'my_simple_plugin_documentation_page'
    );

    // Add submenu page for the shop
    add_submenu_page(
        'quest-master', // Parent menu slug
        'Shop', // Page title
        'Shop', // Menu title
        'manage_options', // Capability required
        'quest-master-shop', // Menu slug
        'my_simple_plugin_shop_page' // Callback function for the shop page
    );
}
add_action('admin_menu', 'my_simple_plugin_menu');

// Callback function for the documentation page
function my_simple_plugin_documentation_page() {
    // Get the content of the documentation.html file
    $documentation_content = file_get_contents(plugin_dir_path(__FILE__) . 'game/templates/documentation.html');

    // Display the content
    echo $documentation_content;
}

// Callback function for the shop page
function my_simple_plugin_shop_page() {
    if (isset($_POST['submit_weapon'])) {
        if (isset($_POST['name']) && isset($_POST['power']) && isset($_POST['price']) && isset($_POST['health'])) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'shop';

            $name = sanitize_text_field($_POST['name']);
            $power = intval($_POST['power']);
            $price = intval($_POST['price']);
            $health = intval($_POST['health']); // Add the health value

            $wpdb->insert(
                $table_name,
                array(
                    'name' => $name,
                    'power' => $power,
                    'price' => $price,
                    'health' => $health, // Insert the health value into the database
                )
            );

            echo '<div class="updated"><p>Weapon added successfully!</p></div>';
        }
    }


    // Display the form for weapon creation
// Display the form for weapon creation
    echo '<div class="wrap">';
    echo '<h2 class="text-danger">Créez Votre Arme</h2>';
    echo '<form method="post">';

    echo '<label for="name">Nom: </label>';
    echo '<input type="text" name="name" required>';
    echo '<br>';
    echo '<br>';
    echo '<label for="power">Puissance: </label>';
    echo '<input type="number" name="power" required>';
    echo '<br>';
    echo '<br>';
    echo '<label for="price" class="text-white">Prix: </label>';
    echo '<input type="number" name="price" required>';
    echo '<br>';
    echo '<br>';
    echo '<label for="health" class="text-white">Santé: </label>';
    echo '<input type="number" name="health" required>'; // Add the health input field
    echo '<br>';
    echo '<br>';
    echo '<input type="submit" name="submit_weapon" class="button button-primary" value="Créer arme">';
    echo '</form>';
    echo '</div>';


    // Display all weapons in cards
    global $wpdb;
    $table_name = $wpdb->prefix . 'shop';
    $weapons = $wpdb->get_results("SELECT * FROM $table_name");

    echo '<h1>Toutes les armes</h1>';
    echo '<div class="weapons-container">';
    foreach ($weapons as $weapon) {
        echo '<div class="weapon-card" style="padding: 3px; border: 1px solid black; border-radius: 5px; width: 20%" >';
        echo '<p style="text-align: center; font-size: 15px"><strong>Nom: </strong>' . esc_html($weapon->name) . '</p>';  // Use esc_html to sanitize the output
        echo '<p style="text-align: center"><strong>Puissance:</strong> ' . $weapon->power . '</p>';
        echo '<p style="text-align: center"><strong>Prix:  </strong>'. $weapon->price . '</p>';
        echo '<p style="text-align: center"><strong>Vie:  </strong>'. $weapon->health . '</p>';
        echo '</div>';
    }
    echo '</div>';

}
