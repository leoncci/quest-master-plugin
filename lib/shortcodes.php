<?php
add_shortcode('my-website', 'embed_my_website_callback');

function embed_my_website_callback() {
    ob_start(); // Start output buffering to capture the included file's content
    include plugin_dir_path(__FILE__) . '../game/index.php'; // Replace 'game' with your subfolder name
    $output = ob_get_clean(); // Get the included file's content and stop output buffering

    return $output;
}