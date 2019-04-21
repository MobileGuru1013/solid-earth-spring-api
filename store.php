<?php
  function SPRINGAPIWP_set_data($data, $option_name) {
    update_option($option_name,$data);
  }

  function SPRINGAPIWP_get_data($option_name) {
    return get_option($option_name);
  }

?>