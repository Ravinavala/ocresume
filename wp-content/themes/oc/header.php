<!DOCTYPE html>
<html <?php language_attributes(); ?>>    
    <head>        
        <title><?php
            wp_title('|', true, 'right');
            bloginfo('name');
            ?></title>        
        <meta charset="<?php bloginfo('charset'); ?>">        
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1, maximum-scale=1">    
        <link href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.css" rel="stylesheet" type="text/css"/>        
        <link href="<?php echo get_template_directory_uri(); ?>/style.css" rel="stylesheet" type="text/css"/>        
        <link href="<?php echo get_template_directory_uri(); ?>/css/flexslider.css" rel="stylesheet" type="text/css"/>        
        <link href="<?php echo get_template_directory_uri(); ?>/css/responsive.css" rel="stylesheet" type="text/css"/>    
        <link rel="shortcut icon"  href="<?php echo of_get_option('favicon_logo'); ?>"/>
        <?php wp_head(); ?>
    </head>    
    <body>   
        <input type="hidden" id="admin_url" value="<?php echo admin_url('admin-ajax.php'); ?>" />
        <header>            
            <div class="header header_main">                
                <div class="container">                    
                    <div class="row">                        
                        <div class="col-sm-4">                            
                            <div class="left_header">                                
                                <a href="<?php echo esc_url(home_url('/')); ?>"> 
                                    <?php if (of_get_option('header_logo')) : ?>
                                        <img src="<?php echo of_get_option('header_logo'); ?>" alt="Logo"/> 
                                    <?php else : ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/oc_logo.png" alt="Logo"/> 
                                    <?php endif; ?>
                                </a>                            
                            </div>                        
                        </div>                        
                        <div class="right_header">                            
                            <nav class="navbar">                                
                                <div class="navbar-header">                                    
                                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar1">                                        
                                        <span class="icon-bar"></span>                                        
                                        <span class="icon-bar"></span>                                        
                                        <span class="icon-bar"></span>                                    
                                    </button>                                    
                                    <div class="buttons">   
                                        <?php
                                        if (is_user_logged_in()) {
                                            $currentuser = wp_get_current_user();
                                            echo '<a class="heading_a login" href="' . wp_logout_url(home_url()) . '">Log out</a>';
                                            if ($currentuser->roles[0] == 'administrator') {
                                                echo '<a class="heading_a " href="' . get_site_url() . '/wp-admin/">' . $currentuser->user_firstname . ' ' . $currentuser->user_lastname . '</a>';
                                            } else {
                                                echo '<a class="heading_a " href="' . get_site_url() . '/' . $currentuser->roles[0] . '/dashboard">' . $currentuser->user_firstname . ' ' . $currentuser->user_lastname . '</a>';
                                            }
                                        } else {
                                            echo '<a class="heading_a login" href="' . get_permalink(83) . '">Log in </a></span>';
                                        }
                                        ?>

                                        <?php
                                        if ($currentuser->roles[0] != "administrator" && $currentuser->roles[0] != "reviewer") {
                                            ?>
                                            <span class="divider"></span> 
                                            <a href="javascript:void(0)" id="buy-now-package" class="heading_a item buy-now-package"></a>   
                                        <?php } ?>
                                    </div>                                
                                </div>                                
                                <div class="collapse navbar-collapse" id="myNavbar1"> 
                                    <div class="buttons_sticky">   
                                        <?php
                                        if (is_user_logged_in()) {
                                            $currentuser = wp_get_current_user();
                                            echo '<a class="heading_a login" href="' . wp_logout_url(home_url()) . '">Log out</a>';
                                            if ($currentuser->roles[0] == 'administrator') {
                                                echo '<a class="heading_a " href="' . get_site_url() . '/wp-admin/">' . $currentuser->user_firstname . ' ' . $currentuser->user_lastname . '</a>';
                                            } else {
                                                echo '<a class="heading_a " href="' . get_site_url() . '/' . $currentuser->roles[0] . '/dashboard">' . $currentuser->user_firstname . ' ' . $currentuser->user_lastname . '</a>';
                                            }
                                        }  else {
                                            echo '<a class="heading_a login" href="' . get_permalink(83) . '">Log in </a></span>';
                                        }
                                        ?>

                                        <?php
                                        $currentuser = wp_get_current_user();
                                        if ($currentuser->roles[0] != "administrator" && $currentuser->roles[0] != "reviewer") {
                                            ?>
                                            <span class="divider"></span>  
                                            <a href="javascript:void(0)" id="buy-now-package" class="heading_a item buy-now-package"></a>   
                                        <?php } ?>
                                    </div>
                                    <?php wp_nav_menu(array('menu' => 'main-menu', 'container' => false, 'menu_class' => 'nav navbar-nav', 'theme_location' => 'Main Menu')); ?>                                                               
                                </div>                            
                            </nav>                        
                        </div>                    
                    </div>                
                </div>            
            </div>        
        </header>    
        <?php if (!is_front_page()) { ?>
            <section>
                <div class="banner other_pages">
                    <div class="banner_content">
                    </div>
                </div>
            </section>
        <?php } ?>