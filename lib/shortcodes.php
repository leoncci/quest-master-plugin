<?php
add_shortcode('quest-master', 'embed_my_website_callback');

function embed_my_website_callback() {
    ob_start();
    // Start output buffering to capture the included file's content
    ?>
   <script type="text/javascript">
      window.location.href = "<?php echo plugins_url('../game/index.php', __FILE__); ?>";
 </script>-->

    <?php
//    $output = ob_get_clean(); // Get the included file's content and stop output buffering
//
//    return $output;
}
