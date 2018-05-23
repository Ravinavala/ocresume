<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>" />
        <title><?php
            wp_title('|', true, 'right');
            bloginfo('name');
            ?> </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1, maximum-scale=1">
        <meta content="" name="description" />
        <meta content="" name="author" />
        <link rel="icon" href="<?php echo of_get_option('favicon_logo'); ?>" type="image/x-icon" />
        <link rel="shortcut icon" href="<?php echo of_get_option('favicon_logo'); ?>" type="image/x-icon" />

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="<?php echo get_template_directory_uri(); ?>/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo get_template_directory_uri(); ?>/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo get_template_directory_uri(); ?>/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo get_template_directory_uri(); ?>/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <link href="<?php echo get_template_directory_uri(); ?>/assets/global/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" />

        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="<?php echo get_template_directory_uri(); ?>/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo get_template_directory_uri(); ?>/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo get_template_directory_uri(); ?>/assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo get_template_directory_uri(); ?>/assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo get_template_directory_uri(); ?>/assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->

        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?php echo get_template_directory_uri(); ?>/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?php echo get_template_directory_uri(); ?>/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo get_template_directory_uri(); ?>/assets/layouts/layout/css/bootstrap-responsive-tabs.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->

        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="<?php echo get_template_directory_uri(); ?>/assets/layouts/layout/css/bootstrap-responsive-tabs.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo get_template_directory_uri(); ?>/assets/layouts/layout/css/style.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo get_template_directory_uri(); ?>/assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo get_template_directory_uri(); ?>/assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo get_template_directory_uri(); ?>/assets/layouts/layout/css/customscroll.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo get_template_directory_uri(); ?>/assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="<?php echo get_template_directory_uri(); ?>/assets/layouts/layout/css/style_b.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo get_template_directory_uri(); ?>/assets/layouts/layout/css/style_t.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo get_template_directory_uri(); ?>/assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->

        <script src="<?php echo get_template_directory_uri(); ?>/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <?php wp_head(); ?>
    </head> 
    <!-- END HEAD -->
    <?php
    if (get_the_ID() == 184)
        $class = "profile_page_content";
    $header_class = "top_header";
    if (get_the_ID() == 151)
        $class = "notification_page_content";
    if (get_the_ID() == 206)
        $class = "profile_page_content";
    if (get_the_ID() == 238 || get_the_ID() == 243)
        $class = "shistory_section";
    if (get_the_ID() == 241)
        $hclass = "reviewer_history";
    if (get_the_ID() == 243)
        $hclass = "shistory1_section";
    ?>
    <body class="page-header-fixed page-sidebar-closed-hide-logo  page-content-white <?php echo $class; ?>">
        <?php
        global $current_user;
        $current_user = wp_get_current_user();
        ?>
        <input type="hidden" id="admin_url" value="<?php echo admin_url('admin-ajax.php'); ?>" />
        <input type="hidden" id="userid" value="<?php echo $current_user->ID; ?>" />


        <div class="page-wrapper page_notification <?php echo $hclass; ?>">

            <!-- BEGIN HEADER -->
            <div class="page-header navbar navbar-fixed-top">
                <!-- BEGIN HEADER INNER -->
                <div class="page-header-inner ">
                    <!-- BEGIN LOGO -->
                    <div class="page-logo">
                        <a href="<?php echo get_site_url(); ?>">
                            <?php if (of_get_option('dashboard_logo')) : ?>
                                <img src="<?php echo of_get_option('dashboard_logo'); ?>" alt="logo" class="logo-dashboard" /> 
                            <?php else : ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/layouts/layout/img/logo_dashboard.png" alt="Logo"/> 
                            <?php endif; ?>
                        </a>
                        <div class="menu-toggler sidebar-toggler">
                            <span></span>
                        </div>
                    </div>
                    <!-- END LOGO -->

                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"><span></span></a>
                    <!-- END RESPONSIVE MENU TOGGLER -->

                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu <?php echo $header_class; ?> ">
                        <ul class="nav navbar-nav pull-right">
                            <input type="hidden" id="userid" value="<?php echo $current_user->ID; ?>" />
                            <!-- BEGIN NOTIFICATION DROPDOWN -->
                            <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                                <a href="javascript:;" class="dropdown-toggle view-notificatons" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false">
                                    <i class=""><img src="<?php echo get_template_directory_uri(); ?>/assets/layouts/layout/img/bell_img.png" alt=""></i>
                                    <?php
                                    global $wpdb;
                                    $notifications_table = $wpdb->prefix . 'notifications';
                                    $count_notification = $wpdb->get_var("select count(*) from $notifications_table where recipient_id = $current_user->ID and is_view = 0 ");
                                    ?>

                                    <span class="badge badge-default hidenotfication"> <?php echo $count_notification; ?> </span>


                                </a>

                                <?php
                                if ($current_user->roles[0] == 'reviewer')
                                    $noti_id = 230;
                                else
                                    $noti_id = 290;
                                ?>
                                <ul class="dropdown-menu">
                                    <li class="external">
                                        <h3><span class="bold bold_pending"><?php echo $count_notification; ?> Pending</span> Notifications</h3>
                                        <a href="<?php echo get_permalink($noti_id); ?>" class="view-notificatons">View All</a>
                                    </li>
                                    <li>
                                        <div class="noti_scroll">
                                            <ul class="dropdown-menu-list scroller" style="height: 201px;" data-handle-color="#637283">
                                                <?php
                                                $get_pending_notifications = $wpdb->get_results("select * from $notifications_table where recipient_id = $current_user->ID and is_view = 0 ORDER BY ID DESC");
                                                foreach ($get_pending_notifications as $notification) {
                                                    ?>
                                                    <li>
                                                        <a href="javascript:;"><span class="details"><?php echo $notification->notification; ?></span></a>
                                                    </li>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!-- END NOTIFICATION DROPDOWN -->

                            <!-- BEGIN USER LOGIN DROPDOWN -->
                            <li class="dropdown dropdown-user">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <?php
                                    $profile_pic = get_user_meta($current_user->ID, 'profile_image', TRUE);
                                    if ($profile_pic) {
                                        ?>
                                        <img class="img-circle output" src="<?php echo $profile_pic; ?>" alt="" />
                                    <?php } else {
                                        ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/layouts/layout/img/no_img.png" class="img-circle output" alt="image">
                                        <?php
                                    }
                                    ?>
                                    <span class="username username-hide-on-mobile john_doe"><?php echo $current_user->user_firstname . ' ' . $current_user->user_lastname; ?></span>
                                    <i class=""> <img src="<?php echo get_template_directory_uri(); ?>/assets/layouts/layout/img/arrow.png" alt=""/></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    <li>
                                        <a href="<?php echo get_site_url(); ?>/<?php echo $current_user->roles[0]; ?>/profile">
                                            <i class="icon-user"></i> My Profile </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo wp_logout_url(home_url()); ?>">
                                            <i class="icon-key"></i> Log Out </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- END USER LOGIN DROPDOWN -->
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                <!-- END HEADER INNER -->
            </div>
            <!-- END HEADER -->

            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->

            <!-- BEGIN CONTAINER -->
            <div class="page-container">

                <!-- BEGIN SIDEBAR -->
                <?php get_sidebar('dashboard'); ?>
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper dashboard_section ">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                        <div class="load_overlay" id="loding">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/loader1.gif"/>
                        </div>
                        <!-- BEGIN PAGE HEADER-->
                        <!-- BEGIN PAGE BAR -->
                        <div class="page-bar">
                            <ul class="page-breadcrumb">                                
                                <li>
                                    <a href="<?php echo get_site_url(); ?>">Home</a>
                                    <i class=""> <img src="<?php echo get_template_directory_uri(); ?>/assets/layouts/layout/img/dot_img.png" alt=""/></i>
                                </li>
                                <?php
                                if (get_the_ID() == 219):
                                    ?> 
                                    <li>
                                        <a href="<?php echo get_site_url(); ?>/<?php echo $current_user->roles[0]; ?>/dashboard">Dashboard</a>
                                        <i class=""> <img src="<?php echo get_template_directory_uri(); ?>/assets/layouts/layout/img/dot_img.png" alt=""/></i>
                                    </li>
                                <?php endif; ?>

                                <?php
                                if (get_the_ID() == 219):
                                    $package_id = $_REQUEST['id'];
                                    $packageobj = $wpdb->get_row("SELECT * FROM $wpdb->pmpro_membership_orders WHERE id = '$package_id' LIMIT 1");
                                    ?> 
                                    <li>
                                        <span><?php echo $packageobj->billing_name; ?></span>
                                    </li>
                                <?php else: ?>
                                    <li>
                                        <span><?php the_title(); ?></span>
                                    </li>
                                <?php endif; ?>
                            </ul>
                            <div class="dat_calender">
                                <div class="page-toolbar">
                                    <div class="input-group input-medium " >
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button" ></button>
                                        </span>
                                        <input type="text" class="form-control" readonly placeholder="<?php echo date("F d, Y") ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END PAGE BAR -->