<?php get_header('dashboard'); ?>
<h1 class="page-title"><?php the_title(); ?></h1>
<div class="workspace">
    <div class="workspace_top">
        <?php
        $userid = $current_user->ID;
        $order_id = $_GET['id'];
        $user_info = get_userdata($userid);
        $currentuser = $current_user->roles[0];
        $sql = "SELECT wp_pmpro_membership_orders.billing_name, wp_pmpro_membership_orders.id as orderid, wp_pmpro_membership_orders.reviewer_id, wp_pmpro_membership_orders.uploaded_resume, wp_pmpro_membership_orders.original_resume, wp_pmpro_membership_orders.is_submit, wp_pmpro_membership_orders.workflow_status, wp_pmpro_membership_orders.membership_id, wp_pmpro_membership_orders.timestamp, wp_pmpro_membership_levels.id, wp_pmpro_membership_levels.name, wp_pmpro_membership_levels.description, wp_pmpro_membership_levels.initial_payment, wp_workflow_status.status_name, wp_pmpro_memberships_users.status FROM wp_pmpro_membership_orders LEFT JOIN wp_workflow_status ON wp_pmpro_membership_orders.workflow_status = wp_workflow_status.pk_status_id LEFT JOIN wp_pmpro_membership_levels ON wp_pmpro_membership_orders.membership_id = wp_pmpro_membership_levels.id  LEFT JOIN wp_pmpro_memberships_users ON wp_pmpro_membership_orders.user_id = wp_pmpro_memberships_users.user_id WHERE wp_pmpro_membership_orders.id='$order_id' LIMIT 1";
        $result = $wpdb->get_results($sql) or die(mysql_error());
        $wpdb->flush();
        ?>
        <div class="workspace_left">
            <div class="package">
                <div class="package_class_info">
                    <div class="package_bg">
                        <h2><?php echo $result[0]->name; ?></h2>
                    </div>
                    <h3><?php
                        $val = ($pmpro_currency_symbol);
                        echo 'dsf' . $val;
                        ?><?php echo $result[0]->initial_payment; ?></h3>
                    <div class="border-bottom"></div>
                    <?php echo $result[0]->description; ?>
                </div>
            </div>
        </div>
        <div class="workspace_right">
            <div class="workflow_table">
                <div class="table">
                    <div class="tbody">
                        <div class="tr">
                            <div class="th">Purchase Date: </div>
                            <?php
                            $date = $result[0]->timestamp;
                            ?>
                            <div class="td"><?php echo date(' F j, Y', strtotime($date)); ?></div>
                        </div>
                        <div class="tr">
                            <div class="th">Workflow Status:  </div>
                            <div class="td">
                                <?php
                                if ($result[0]->status_name) {
                                    echo $result[0]->status_name;
                                } else {
                                    echo $status;
                                }
                                if ($result[0]->workflow_status == '4' || $result[0]->workflow_status == '6') {
                                    echo '<img class="lock_img" src="' . get_template_directory_uri() . '/images/lock.png" alt="lock" title="If you have any query please contact to admin." />';
                                }
                                ?>
                                <?php
                                if ($result[0]->uploaded_resume != ''):
                                    $uploads = wp_upload_dir();
                                    $upload_path = $uploads['baseurl'];
                                    if ($result[0]->original_resume)
                                        $file_name = $result[0]->original_resume;
                                    else
                                        $file_name = $result[0]->uploaded_resume;
                                    $name = $file_name;
                                    $len = strlen($file_name);
                                    if ($len > 10)
                                        $file_name = substr($file_name, 0, 10) . "...";
                                    echo '<a title="' . $name . '"  download="' . $name . '" class="red_text" href="' . $upload_path . '/files/' . $result[0]->uploaded_resume . '" >' . $file_name . '</a>';

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

                            <?php
                            if ($result[0]->resume_pdf != '') {
                                $uploads = wp_upload_dir();
                                $upload_path = $uploads['baseurl'];
                                echo ' <a target="_blank" class="red_text" href="' . $upload_path . '/files/' . $result[0]->resume_pdf . '" >' . $result[0]->resume_pdf . '</a>';
                            } else {
                                echo '<div class="td">None</div>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="th">Download Resume:</div>
                        <?php
                        if ($result[0]->resume_pdf != '') {
                            $uploads = wp_upload_dir();
                            $upload_path = $uploads['baseurl'];

                            echo ' <a target="_blank" class="red_text" href="' . $upload_path . '/files/' . $result[0]->resume_pdf . '" >' . $result[0]->resume_pdf . '</a>';
                        } else {
                            echo '<div class="td">None</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php
    if ($result[0]->workflow_status == 4) {
        echo '<label>You have already uploaded your resume. </label>';
    }
    if ($result[0]->workflow_status == 6) {
        echo '<label>Your Package is completed. </label>';
    }
    ?>
    <?php
    if ($result[0]->workflow_status != 4 && $result[0]->workflow_status != 6) {
        ?>
        <div class="workspace_bottom">
            <form method="post" id="upload-form"  name="resume" enctype="multipart/form-data" action="<?php echo get_site_url(); ?>/student/resume-workspace/?id=<?php echo $result[0]->orderid; ?>">
                <div class="portlet box red">
                    <div class="portlet-title">
                        <div class="caption"> Upload your Resume </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse" data-original-title="" title="" aria-describedby="tooltip213792"> </a>
                        </div>
                    </div>
                    <div class="portlet-body tabs-below" style="display: block;">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_4_1">
                                <label for="file_upload">Please upload your existing resume.*</label>
                                </br>
                                <label for="file_upload">eg. doc, pdf, docx,text, txt</label>
                                <input type="file" id="uploaded_resume" name="uploaded_resume"  onchange="allvalidateimageFiles(this.value, 'uploaded_resume')" value="">
                                <label>What are your goals with having a resume created/revised?*</label>
                                <textarea placeholder="Type here"  id="goals" name="goals" value="<?php echo (!empty($result) ? $result[0]->goals : '') ?>"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="submit_btnn">
                    <input type="submit" name="submit" id="search_submit" class="red_btn right_btn search_submit" value="Submit for Review">
                </div>
                <input type="hidden" id="hide" name="did" value="<?php echo $result[0]->user_id; ?>">
                <input type="hidden" id="workflowstatus" name="did" value="4">
            </form>
            <?php
            $userid = $current_user->ID;
            $currentuser = $current_user->roles[0];
            $submitstatus = $results->is_submit;
            global $wpdb;
            $goals = $_POST["goals"];
            $uploadFileName = $_FILES['uploaded_resume']['name'];
            $status = $_POST["did"];
            if (isset($uploadFileName) && !empty($uploadFileName)) {
                $extension = pathinfo($uploadFileName, PATHINFO_EXTENSION);
                $tutorphotoname = "file_" . md5($uploadFileName) . '.' . $extension;
                $uploaddir = './wp-content/uploads/files/';
                $people = array("pdf", "docx", "txt", "text", "doc");
                $check_filetype = wp_check_filetype($tutorphotoname);
                $uploadfile = $uploaddir . $tutorphotoname;
                if (in_array($check_filetype['ext'], $people)) {
                    move_uploaded_file($_FILES['uploaded_resume']['tmp_name'], $uploadfile);
                    if ($goals != '' && $uploadFileName != '') {
                        $result = $wpdb->update(
                                'wp_pmpro_membership_orders', array(
                            'goals' => $goals,
                            'original_resume' => $uploadFileName,
                            'uploaded_resume' => $tutorphotoname,
                            'workflow_status' => $status,
                            'is_submit' => 1,
                                ), array(
                            'user_id' => $userid,
                            'id' => $order_id));
                        if ($result > 0) {
                            echo "Successfully Updated";
                            ?>
                            <script>
                                $("#upload-form").hide();
                            </script>
                            <?php
                            $reviewer_users = get_users('role=Reviewer');
                            //print_r($reviewer_users);
                            foreach ($reviewer_users as $user) {
                                $to = $user->user_email;
                                $subject = 'New resume uploaded';
                                $msg = 'Student ' . $user_info->first_name . ' ' . $user_info->last_name . ' has uploaded resume.<br/>';
                                $msg .= 'Click here for login ' . get_permalink(83);
                                $headers = "MIME-Version: 1.0" . "\r\n";
                                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                $headers .= 'From: Ocresume <mike@OCresume.net.com>' . "\r\n";
                                wp_mail($to, $subject, $msg, $headers);

                                $table_notifications = $wpdb->prefix . 'notifications';
                                $wpdb->insert(
                                        $table_notifications, array(
                                    'datetime' => date('Y-m-d, h:i:s'),
                                    'recipient_id' => $user->ID,
                                    'sender_id' => $userid,
                                    'notification' => 'New student ' . $user_info->first_name . ' ' . $user_info->last_name . ' has submitted resume.',
                                    'package_id' => $order_id,
                                    'action' => '',
                                    'is_view' => 0
                                        )
                                );
                            }
                        } else {
                            exit(var_dump($wpdb->last_query));
                        }
                        $wpdb->flush();
                    }
                } else {
                    echo 'This  files type is  not allowed please upload valid file eg. pdf, docx ';
                }
            }
            ?>
        </div>
    <?php } ?>
</div>
<?php get_footer('dashboard'); ?>