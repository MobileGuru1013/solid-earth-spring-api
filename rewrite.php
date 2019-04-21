<?php
add_filter('query_vars', 'SPRINGAPIWP_add_listingID', 0, 1);

function SPRINGAPIWP_add_listingID($vars){
    $vars[] = 'listingID';
    return $vars;
}
add_action( 'init', 'SPRINGAPIWP_add_listing_rules' );

function SPRINGAPIWP_add_listing_rules() {
  add_rewrite_rule('^property/([^/]*)/?','index.php?pagename=property&listingID=$matches[1]','top');
  flush_rewrite_rules();
}
?>