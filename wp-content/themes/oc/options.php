<?php

/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 */
function optionsframework_option_name() {
    // This gets the theme name from the stylesheet
    $themename = wp_get_theme();
    $themename = preg_replace("/\W/", "_", strtolower($themename));
    $optionsframework_settings = get_option('optionsframework');
    $optionsframework_settings['id'] = $themename;
    update_option('optionsframework', $optionsframework_settings);
}

function optionsframework_options() {

    //----------Create Packages array ------------//
    global $wpdb;
    $packages = $wpdb->get_results("SELECT * FROM $wpdb->pmpro_membership_levels");
    $package_array = array();
    foreach ($packages as $package) {
        $package_array[$package->id] = $package->name;
    }

    $options = array();
    $options[] = array(
        'name' => __('Header', 'options_framework'),
        'type' => 'heading');

    $options[] = array(
        'name' => __('Header Page Logo', 'options_framework_theme'),
        'desc' => __('Upload Home Page Header Logo.', 'options_framework_theme'),
        'id' => 'header_logo',
        'type' => 'upload');

    $options[] = array('name' => __('Favicon', 'options_framework_theme'),
        'desc' => __('Upload Favicon .ico file (width 16x16)', 'options_framework_theme'),
        'id' => 'favicon_logo', 'type' => 'upload');

    $options[] = array(
        'name' => __('Footer', 'options_framework'),
        'type' => 'heading');

    $options[] = array(
        'name' => __('Copy Right', 'options_framework_theme'),
        'desc' => __('Add Copy Right Text', 'options_framework_theme'),
        'id' => 'copyright_text',
        'type' => 'text');

    $options[] = array(
        'name' => __('Copy Right Link Text', 'options_framework_theme'),
        'desc' => __('Add Copy Right Link Text', 'options_framework_theme'),
        'id' => 'copylink_txt',
        'type' => 'text');

    $options[] = array(
        'name' => __('Copy Right Link ', 'options_framework_theme'),
        'desc' => __('Add Copy Right Link URL', 'options_framework_theme'),
        'id' => 'copylink_url',
        'type' => 'text');

    $options[] = array(
        'name' => __('Contact Details', 'options_framework'),
        'type' => 'heading');

    $options[] = array(
        'name' => __('Location', 'options_framework_theme'),
        'desc' => __('Add Location Address', 'options_framework_theme'),
        'id' => 'location',
        'type' => 'textarea');

    $options[] = array(
        'name' => __('Mail Address', 'options_framework_theme'),
        'desc' => __('Add Mail Address', 'options_framework_theme'),
        'id' => 'mail_address',
        'type' => 'text');

    $options[] = array(
        'name' => __('Phone Number', 'options_framework_theme'),
        'desc' => __('Add Phone Number', 'options_framework_theme'),
        'id' => 'phone_number',
        'type' => 'text');

    $options[] = array(
        'name' => __('Social Media', 'options_framework'),
        'type' => 'heading');

    $options[] = array(
        'name' => __('Twitter', 'options_framework_theme'),
        'desc' => __('Add Twitter Text', 'options_framework_theme'),
        'id' => 'twitter_text',
        'type' => 'text');

    $options[] = array(
        'name' => __('Twitter Link', 'options_framework_theme'),
        'desc' => __('Add Twitter Link', 'options_framework_theme'),
        'id' => 'twitter_link',
        'type' => 'text');

    $options[] = array(
        'name' => __('Dashboard', 'options_framework'),
        'type' => 'heading');

    $options[] = array(
        'name' => __('Dashboard Logo', 'options_framework_theme'),
        'desc' => __('Upload Dashboard Header Logo.', 'options_framework_theme'),
        'id' => 'dashboard_logo',
        'type' => 'upload');

    $options[] = array(
        'name' => __('Contact to Admin Text', 'options_framework_theme'),
        'desc' => __('Contact to Admin Text', 'options_framework_theme'),
        'id' => 'contact_admin',
        'type' => 'text');

    $options[] = array(
        'name' => __('Packages', 'options_framework'),
        'type' => 'heading');

    $options[] = array(
        'name' => __('Display Packages Options', 'theme-textdomain'),
        'desc' => __('Select Maximum 4 Packages To display', 'oc'),
        'id' => 'sel_package',
        'type' => 'multicheck',
        'options' => $package_array
    );
 $options[] = array(
        'name' => __('Stay Informed', 'options_framework'),
        'type' => 'heading');

    $options[] = array(
        'name' => __('Stay Informed Form Logo', 'options_framework_theme'),
        'desc' => __('Upload Stay Informed Form Logo.', 'options_framework_theme'),
        'id' => 'stayinformed_logo',
        'type' => 'upload');
    return $options;
}
