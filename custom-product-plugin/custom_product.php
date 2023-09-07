<?php



/*
Plugin Name: Custom Product Plugin
Description: Adds a custom post type for Products and custom taxonomies.
Version: 1.0
Author: Rachana kumari panda
*/

//  prevent direct access
if( ! defined ( 'ABSPATH' ) ) {
    exit; //exit it accesses directly
 
 } 
 $dir = plugin_dir_path(__FILE__);
  $url = plugin_dir_url(__FILE__);
 //   echo plugin_dir_url(__FILE__);
 
 define("CUSTOM_PRODUCT_PLUGIN_PATH", plugin_dir_path(__FILE__));
 define("CUSTOM_PRODUCT_PLUGIN_URL", plugin_dir_url(__FILE__));
 
 
 include CUSTOM_PRODUCT_PLUGIN_PATH. "includes/class_custom_product.php";
//  echo "hiiiii";


?>