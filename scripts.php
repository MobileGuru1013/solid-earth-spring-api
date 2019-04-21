<?php

add_action('wp_head', 'SPRINGAPIWP_child_add_scripts');

function SPRINGAPIWP_add_script($file) {
  $path = plugins_url('js/' . $file . '.js', __FILE__);
  $name = 'spring_api_' . $file;

  wp_register_script($name, $path);
  wp_enqueue_script($name);
}

function SPRINGAPIWP_add_style($file) {
  $path = plugins_url('css/' . $file . '.css', __FILE__);
  $name = 'spring_api_' . $file;

  wp_register_style($name, $path);
  wp_enqueue_style($name);
}

function SPRINGAPIWP_child_add_scripts() {
  $data = SPRINGAPIWP_get_data('listing_settings');

  wp_register_script( 'gmap', 'https://maps.googleapis.com/maps/api/js?key=' . $data[4] );
  wp_enqueue_script('gmap');

  SPRINGAPIWP_add_script('vendor');
  SPRINGAPIWP_add_script('api-client');
  SPRINGAPIWP_add_script('plugin');

  SPRINGAPIWP_add_style('slider');
  SPRINGAPIWP_add_style('search');
  SPRINGAPIWP_add_style('listing');
}
?>