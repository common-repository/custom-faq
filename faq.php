<?php
/**
* Plugin Name: Custom FAQ
* Plugin URI: http://pixeltoweb.com/
* Description: Frequently asked Question Plugin is helpfull to show topic wise Questions coming into mind and available Answers of it.Admin can Provide Questions and Answers into Admin side and can visible on front end for n number of users to clear their doubts of certain topic.
* Version: 1.0
* Author: Pixeltoweb
* Author URI: http://www.pixeltoweb.com
* License: GPL12
*/
define( 'PLUGIN_PATH', plugins_url().'/faq');
include("includes/function.php");
register_activation_hook(__FILE__,'faq_install');
add_action('init', 'faq_register_script');
add_action('wp_enqueue_scripts', 'faq_enqueue_style');
add_shortcode( 'custom_faq', 'get_faq' );
add_action( 'init', 'faq', 0 );
add_action('wp_print_scripts', 'faq_ajax_load_scripts');
add_action( 'wp_ajax_loadfaq', 'loadfaq' );
add_action( 'wp_ajax_nopriv_loadfaq', 'loadfaq' );
