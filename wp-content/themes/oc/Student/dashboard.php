<?php
/*
  Template Name:  Student Dashboard
 */
?>
<?php if (!is_user_logged_in()): ?>
    <script>window.location.href = "<?php echo site_url(); ?>";</script>
<?php endif; ?>
<?php get_header('dashboard'); ?>
<h1 class="page-title"> <?php the_title(); ?></h1>
<?php
$userid = $current_user->ID;
$user_info = get_userdata($userid);
$currentuser = $current_user->roles[0];
$sql = "SELECT wp_pmpro_membership_orders.id as order_id, wp_pmpro_membership_orders.name as username, wp_pmpro_membership_orders.reviewer_id, wp_pmpro_membership_orders.resume_pdf, wp_pmpro_membership_orders.uploaded_resume, wp_pmpro_membership_orders.membership_id, wp_pmpro_membership_orders.original_resume, wp_pmpro_membership_orders.workflow_status, wp_pmpro_membership_orders.billing_name, wp_pmpro_membership_orders.timestamp, wp_pmpro_membership_levels.id, wp_pmpro_membership_levels.name, wp_pmpro_membership_levels.description, wp_pmpro_membership_levels.initial_payment, wp_workflow_status.status_name, wp_pmpro_memberships_users.status FROM wp_pmpro_membership_orders LEFT JOIN wp_workflow_status ON wp_pmpro_membership_orders.workflow_status = wp_workflow_status.pk_status_id LEFT JOIN wp_pmpro_membership_levels ON wp_pmpro_membership_orders.membership_id = wp_pmpro_membership_levels.id  LEFT JOIN wp_pmpro_memberships_users ON wp_pmpro_membership_orders.user_id = wp_pmpro_memberships_users.user_id WHERE wp_pmpro_membership_orders.user_id='$userid' GROUP BY wp_pmpro_membership_orders.membership_id ORDER BY wp_pmpro_membership_orders.workflow_status";
$result = $wpdb->get_results($sql) or die(mysql_error());
?>
<div class="student_side profile_page_content">
    <div class="student_profile">
        <div class="girl_profile">
            <?php
            $profile_pic = get_user_meta($current_user->ID, 'profile_image', TRUE);
            if ($profile_pic) {
                ?>
                <img src="<?php echo $profile_pic; ?>" alt="" id="profile_pic"/>
            <?php } else { ?>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/layouts/layout/img/no_img.png"  alt="image" id="profile_pic">
            <?php } ?>
        </div>
        <div class="profile_name">
            <h4><?php echo $user_info->first_name . ' ' . $user_info->last_name; ?></h4>
            <span><?php echo $currentuser; ?> </span>
        </div>
        <div class="view_profile">
            <a href="<?php echo get_site_url(); ?>/<?php echo $current_user->roles[0]; ?>/profile">View Profile </a>
        </div>
        <?php
        $sql = "SELECT * FROM wp_pmpro_membership_orders WHERE user_id='$userid' ORDER BY id DESC LIMIT 1";
        $res = $wpdb->get_results($sql) or die(mysql_error());
        if (($res[0]->workflow_status == 6 && $res[0]->membership_id == 1) ||
                ($res[0]->workflow_status == 6 && $res[0]->membership_id == 2) ||
                ($res[0]->workflow_status == 6 && $res[0]->membership_id == 3)) {
            ?>

            <div class="buy_package">
                <p>Your  <?php echo $res[0]->name; ?> is completed Now you can buy another Package</p>
                <a href="<?php echo get_site_url(); ?>?id=<?php echo $res[0]->membership_id; ?>" class="red_btn buy_packages">Buy-Now</a>
            </div>
        <?php } ?>
    </div>
    <?php
    foreach ($result as $results) {
        ?>
        <div class="profile_account profile_page_content">
            <div class="portlet light bordered profile">
                <div class="portlet-title tabbable-line profile_border">
                    <div class="caption">
                        <i class="icon-bubbles font-dark hide"></i>
                        <span class="caption-subject font-dark bold">
                            <?php
                            if ($results->workflow_status == 6)
                                echo "Completed Project";
                            else
                                echo 'Active Project';
                            ?>
                        </span>
                    </div>
                    <div class="Package_date">
                        <?php $date = $results->timestamp; ?>
                        Package Purchase Date:  <span><?php echo date(' F j, Y', strtotime($date)); ?></span>
                    </div>
                </div>
            </div>
            <div class="portlet-body content_body">
                <div class="package">
                    <div class="package_class_info">
                        <div class="package_bg">
                            <h2>
                                <?php echo $results->name; ?></h2>
                        </div>
                        <h3><?php
                            echo $pmpro_currency_symbol;
                            ?><?php echo $results->initial_payment; ?></h3>
                        <div class="border-bottom"></div>
                        <?php echo $results->description; ?>
                    </div>
                </div>
                <div class="workflow_table">
                    <div class="wtable_responsive">
                        <div class="table">
                            <div class="tbody">
                                <div class="tr">
                                    <div class="th">Workflow Status:</div>
                                    <div class="td">
                                        <?php
                                        if ($results->status_name) {
                                            echo $results->status_name;
                                        } else {
                                            echo $status;
                                        }
                                        if ($results->workflow_status == '4' || $results->workflow_status == '6') {
                                            echo '<img class="lock_img" src="' . get_template_directory_uri() . '/images/lock.png" alt="lock" title="' . of_get_option('contact_admin') . '" />';
                                        }
                                        ?>
                                        <?php
                                        if ($results->uploaded_resume != ''):
                                            $uploads = wp_upload_dir();
                                            $upload_path = $uploads['baseurl'];
                                            if ($results->original_resume)
                                                $file_name = $results->original_resume;
                                            else
                                                $file_name = $results->uploaded_resume;
                                            $name = $file_name;
                                            $len = strlen($file_name);
                                            if ($len > 10)
                                                $file_name = substr($file_name, 0, 10) . "...";
                                            echo ' <a title="' . $name . '" download="' . $name . '" class="red_text" href="' . $upload_path . '/files/' . $results->uploaded_resume . '" >' . $file_name . '</a>';
                                        endif;
                                        ?>
                                    </div>
                                </div>
                                <div class="tr">
                                    <div class="th">Reviewer:</div>

                                    <?php
                                    if ($results->reviewer_id != '') {
                                        $user_info = get_userdata($results->reviewer_id);
                                        echo '<div class="td">' . $user_info->first_name . '  ' . $user_info->last_name . '</div>';
                                    } else {
                                        echo '<div class="td">None</div>';
                                    }
                                    ?>
                                </div>
                                <div class="tr">
                                    <div class="th">View Resume:</div>
                                    <?php if ($results->resume_pdf != '' && $results->workflow_status == '6') { ?>
                                        <div class="td"><a class="black_border" href="<?php the_permalink(286); ?>?id=<?php echo $results->order_id; ?>" >View Now</a></div>

                                        <?php
                                    } else {
                                        echo '<div class="td">None</div>';
                                    }
                                    ?>


                                </div>
                                <div class="tr">
                                    <div class="th">Download Resume:</div>
                                    <?php
                                    if ($results->resume_pdf && $results->workflow_status == '6') {
                                        $uploads = wp_upload_dir();
                                        $upload_path = $uploads['baseurl'];
                                        $name = $results->username . '_resume.pdf';
                                        ?>
                                        <div class="td"><a class="red_text" href="<?php echo $upload_path; ?>/resumes/<?php echo $results->resume_pdf; ?>" download ><?php echo $name; ?> </a></div>
                                        <?php
                                    } else {
                                        echo '<div class="td">None</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($results->workflow_status == 1) {
                        if ($results->id == 1) {
                            ?>
                            <a href="<?php the_permalink(179); ?>?id=<?php echo $results->order_id; ?>" class="red_btn">Get Started</a>
                            <?php
                        }
                    }
                    ?>
                    <?php
                    if ($results->workflow_status == 4) {
                        if ($results->id == 1) {
                            ?>
                            <a href="<?php the_permalink(179); ?>?id=<?php echo $results->order_id; ?>" class="red_btn">View Resume Workspace</a>
                            <?php
                        }
                    }
                    ?>
                    <?php
                    if ($results->workflow_status == 5) {
                        if ($results->id == 1) {
                            ?>
                            <a href="<?php the_permalink(186); ?>?id=<?php echo $results->order_id; ?>" class="red_btn">View Resume Workspace</a>
                            <?php
                        }
                    }
                    ?>
                    <?php if ($results->workflow_status == 6) { ?> 
                        <?php if ($results->id == 1) { ?>
                            <a href="<?php the_permalink(243); ?>?id=<?php echo $results->order_id; ?>" class="red_btn gray_btn">View Comment</a>
                            <?php
                        }
                    }
                    ?>
                    <?php
                    if ($results->workflow_status == 1) {
                        if ($results->id == 2) {
                            ?>
                            <a href="<?php echo get_site_url(); ?>/student/student-workflow/?id=<?php echo $results->order_id; ?>" class="red_btn">Get started</a>
                            <?php
                        }
                    }
                    ?>
                    <?php
                    if ($results->workflow_status == 4) {
                        if ($results->id == 2) {
                            ?>
                            <a href="<?php the_permalink(186); ?>?id=<?php echo $results->order_id; ?>" class="red_btn">View Resume Workspace</a>
                            <?php
                        }
                    }
                    ?>
                    <?php if ($results->workflow_status == 5) { ?>
                        <?php if ($results->id == 2) { ?>
                            <a href="<?php the_permalink(186); ?>?id=<?php echo $results->order_id; ?>" class="red_btn">Review and Provide Feedback</a>
                            <?php
                        }
                    }
                    ?>

                    <?php if ($results->workflow_status == 6) { ?>
                        <?php if ($results->id == 2) { ?>
                            <a href="<?php the_permalink(243); ?>?id=<?php echo $results->order_id; ?>" class="red_btn gray_btn">View Comment</a>
                            <?php
                        }
                    }
                    ?>
                    <?php if ($results->workflow_status == 3) { ?>
                        <?php if ($results->id == 3) { ?>
                            <a href="<?php the_permalink(186); ?>?id=<?php echo $results->order_id; ?>" class="red_btn">Open workspace</a>
                            <?php
                        }
                    }
                    ?>
                    <?php if ($results->workflow_status == 5) { ?>
                        <?php if ($results->id == 3) { ?>
                            <a href="<?php the_permalink(186); ?>?id=<?php echo $results->order_id; ?>" class="red_btn">Review and Provide Feedback</a>
                            <?php
                        }
                    }
                    ?>
                    <?php if ($results->workflow_status == 4) { ?>
                        <?php if ($results->id == 3) { ?>
                            <a href="<?php the_permalink(186); ?>?id=<?php echo $results->order_id; ?>" class="red_btn">Review and Provide Feedback</a>
                            <?php
                        }
                    }
                    ?>
                    <?php if ($results->workflow_status == 6) { ?>
                        <?php if ($results->id == 3) { ?>
                            <a href="<?php the_permalink(243); ?>?id=<?php echo $results->order_id; ?>" class="red_btn gray_btn">View Comment</a>
                            <?php
                        }
                    }
                    ?>
                    <?php
                    if ($results->workflow_status == 2) {
                        if ($results->id == 4) {
                            ?>
                            <a href="<?php the_permalink(186); ?>?id=<?php echo $results->order_id; ?>" class="red_btn">Get Started</a>
                            <?php
                        }
                    }
                    ?>

                    <?php if ($results->workflow_status == 4) { ?>
                        <?php if ($results->id == 4) { ?>
                            <a href="<?php the_permalink(186); ?>?id=<?php echo $results->order_id; ?>" class="red_btn">View Resume Workspace</a>
                            <?php
                        }
                    }
                    ?>
                    <?php
                    if ($results->workflow_status == 5) {
                        if ($results->id == 4) {
                            ?>
                            <a href="<?php the_permalink(186); ?>?id=<?php echo $results->order_id; ?>" class="red_btn">Review and Provide Feedback</a>
                            <?php
                        }
                    }
                    ?>

                    <?php
                    if ($results->workflow_status == 6) {
                        if ($results->id == 4) {
                            ?>
                            <a href="<?php the_permalink(243); ?>?id=<?php echo $results->order_id; ?>" class="red_btn gray_btn">View Comment</a>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<?php get_footer('dashboard'); ?>