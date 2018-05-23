<?php
/*
  Plugin Name: Resume Listing
  Plugin URI:
  Description: Simple resume listing
  Author: aliansoftware PHP Team
  Author URI:
  Version : 1.0
 */

ob_start();

define('ALIANWOCOMMERCESELL_PLUGIN_URL', plugins_url('', __FILE__));

add_action('admin_menu', 'mt_add_pages_resume_listing');
function mt_add_pages_resume_listing() {

    add_menu_page(__('Resume Listing', 'Resume Listing'), __('Resume Listing', 'Resume Listing'), 'manage_options', 'mt-top-level-handle-resume-listing', 'mt_toplevel_page_resume_listing');

    add_submenu_page(

            null, 'MyPlugin Details Page', 'MyPlugin Details Page', 'manage_options', 'view-resume-listing', 'view_resume_listing_callback'

    );

    add_submenu_page('mt-top-level-handle-resume-listing', 'Settings', 'Settings', 'manage_options', 'mt-sublevel-page-settings', 'mt_sublevel_page_setting');

    add_submenu_page('mt-top-level-handle-resume-listing', 'Resume Category', 'Resume Category', 'manage_options', 'resume-category', 'mt_sublevel_page_categories');

    add_submenu_page('mt-top-level-handle-resume-listing', 'Assign Category', 'Assign Category', 'manage_options', 'assign-category', 'mt_sublevel_page_assign_category');
    
    add_submenu_page('mt-top-level-handle-resume-listing', 'Supports', 'Supports', 'manage_options', 'mt-sublevel-page-supports', 'mt_sublevel_page_support');
   
}



function mt_toplevel_page_resume_listing() {

    include("display-resume-listing.php");

}



function view_resume_listing_callback() {

    include("view-resume-listing.php");

}



function mt_sublevel_page_setting() {

    include("settings.php");

}

function mt_sublevel_page_support(){
    include("supports.php");
}


function mt_sublevel_page_categories() {

    include("manage_category.php");

}



function mt_sublevel_page_assign_category() {

    include("assign_category.php");

}



function load_custom_wp_admin_style() {

    wp_enqueue_style('custom_wp_admin_css', plugins_url('assets/css/style_t.css', __FILE__), false, '1.0.0');

    wp_enqueue_style('bootstrap_min_css', plugins_url('assets/css/bootstrap.min.css', __FILE__), false, '1.0.0');

    wp_enqueue_style('style', plugins_url('assets/css/style.css', __FILE__), false, '1.0.0');

    wp_enqueue_style('style_b', plugins_url('assets/css/style_b.css', __FILE__), false, '1.0.0');

    wp_enqueue_style('style_t', plugins_url('assets/css/style_t.css', __FILE__), false, '1.0.0');

    wp_enqueue_style('datepicker3', plugins_url('assets/css/bootstrap-datepicker3.min.css', __FILE__), false, '1.0.0');

    wp_enqueue_script('custom_js', plugins_url('assets/js/resume-listing-custom.js', __FILE__), false, '1.0.0');

    wp_enqueue_script('bootstrap_js', plugins_url('assets/js/bootstrap.min.js', __FILE__), false, '1.0.0');

    wp_enqueue_script('datepicker', plugins_url('assets/js/bootstrap-datepicker.min.js', __FILE__), false, '1.0.0');

}



add_action('admin_enqueue_scripts', 'load_custom_wp_admin_style');


?>