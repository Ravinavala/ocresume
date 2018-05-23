<?php
/*
  Template Name: Student historyy
 */
?>
<?php if (!is_user_logged_in()): ?>
    <script>window.location.href = "<?php echo site_url(); ?>";</script>
<?php endif; ?>
<?php get_header('dashboard'); ?>
<h1 class="page-title"><?php the_title(); ?></h1>
<?php
$userid = $current_user->ID;
$currentuser = $current_user->roles[0];
$status == 6;
$result = $wpdb->get_results("SELECT wp_pmpro_membership_orders.id as order_id, wp_pmpro_membership_orders.name as username, wp_pmpro_membership_orders.reviewer_id, wp_pmpro_membership_orders.workflow_status, wp_workflow_status.status_name, wp_pmpro_membership_orders.resume_pdf, wp_pmpro_membership_orders.membership_id, wp_pmpro_membership_orders.timestamp, wp_pmpro_membership_levels.id, wp_pmpro_membership_levels.name, wp_pmpro_membership_levels.description, wp_pmpro_membership_levels.initial_payment, wp_pmpro_memberships_users.status FROM wp_pmpro_membership_orders LEFT JOIN wp_workflow_status ON wp_pmpro_membership_orders.workflow_status = wp_workflow_status.pk_status_id  LEFT JOIN wp_pmpro_membership_levels ON wp_pmpro_membership_orders.membership_id = wp_pmpro_membership_levels.id LEFT JOIN wp_pmpro_memberships_users ON wp_pmpro_membership_orders.user_id = wp_pmpro_memberships_users.user_id WHERE wp_pmpro_membership_orders.workflow_status='6' AND wp_pmpro_membership_orders.user_id = '$userid' GROUP BY wp_pmpro_membership_orders.id");
?>
<?php
if ($result[0]->workflow_status == 6) {
    foreach ($result as $results) {
        ?>
        <div class="student_history">
            <div class="package_white_section">
                <div class="profile_account">
                    <div class="portlet light bordered profile">
                        <div class="portlet-title tabbable-line profile_border">
                            <div class="caption">
                                <label for="inlineCheckbox1" class="caption-subject font-dark bold">
                                    Name of Completed Project2
                                </label>
                            </div>
                            <div class="Package_date">
                                <?php
                                $date = $results->timestamp;
                                ?>
                                Package Purchase Date:  <span><?php echo date(' F j, Y', strtotime($date)); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="portlet-body content_body">
                        <div class="package">
                            <div class="package_class_info">
                                <div class="package_bg">
                                    <h2><?php echo $results->name; ?></h2>
                                </div>
                                <h3><?php
                            $val = ($pmpro_currency_symbol);
                            echo $val;
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
                                            <div class="th">Workflow Status: </div>
                                            <div class="td"><?php echo $results->status_name; ?></div>
                                        </div>
                                        <div class="tr">
                                            <div class="th">Reviewer:</div>
                                            <div class="td"><?php 
                                             $user_info = get_userdata($results->reviewer_id);
                                   
                                            echo $user_info->first_name; ?> <?php echo $user_info->last_name; ?></div>
                                        </div>

                                        <div class="tr">
                                            <div class="th">View Resume:</div>
                                            <?php if ($results->resume_pdf != '') { ?>
                                                <div class="td"><a class="black_border" href="<?php the_permalink(245); ?>?id=<?php echo $results->order_id; ?>" target="_blank">View Now</a></div>

                                                <?php
                                            } else {
                                                echo '<div class="td">None</div>';
                                            }
                                            ?>   

                                        </div>
                                        <div class="tr">
                                            <div class="th">Download Resume:</div>
                                            <?php
                                            if ($results->resume_pdf) {
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

                            <a href="<?php the_permalink(243); ?>?id=<?php echo $results->order_id; ?>" class="red_btn gray_btn">View Comments</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
} else {

    echo 'No history Found';
}
?>
<?php get_footer('dashboard'); ?>