<?php
/* Template Name:  support */
?>
<?php
global $wpdb;
if (isset($_REQUEST['id'])) {
    $statusid = $_REQUEST['id'];
    $statuss = $_REQUEST['status'];
    $selecteddata = $wpdb->get_results("SELECT message, sender_id, receiver_id, create_date FROM wp_student_support WHERE  sender_id = '$statusid' or receiver_id = '$statusid' ORDER BY pk_support_id ");
    foreach ($selecteddata as $data) {
        if ($data->receiver_id == $statusid) {
            $chat_class = "chat_left";
        } else {
            $chat_class = "chat_right";
        }
        ?>
        <div class="<?php echo $chat_class; ?>">
            <div class="chat_text">
                <p><?php echo $data->message; ?></p>
                <span><?php echo date("H:iA F d, Y", strtotime($data->create_date)); ?></span>
            </div>
        </div>
    <?php } ?>
    <?php
    $selecteddatas = $wpdb->get_results("SELECT * FROM wp_student_support WHERE  sender_id = '$statusid' && support_status != '0' ORDER BY pk_support_id DESC LIMIT 1");
    if ($selecteddatas[0]->support_status == 2) {
        ?>
        <div class="col-md-3" id="search-data">
            <?php $status = $wpdb->get_results("SELECT * FROM  wp_status_master ");
            ?>
            <label>Current Status*</label>
            <select name="statusname" class="generate_code_select txt-box" id = "square">
                <?php if ($statuss == $each->status_name) echo 'selected'; ?>
                <option value="-1">Select</option>
                <?php
                foreach ($status as $each) {
                    ?><option <?php if ($statuss == $each->status_name) echo 'selected'; ?> value="<?php echo $each->pk_statusmaster_id; ?>"><?php echo $each->status_name; ?></option>';
                <?php }
                ?>
            </select>
        </div><?php } ?>
    <?php
    if ($selecteddatas[0]->support_status == 1) {
        $adminuid = $results[0]->ID;
        
        ?>
        <form id="student-support-form" method="post" >
            <input type="hidden" name="supportstatus" id="supportstatus" value="2">
            <input type="hidden" name="receiver_id" id="receiver_id" value="<?php echo $selecteddatas[0]->sender_id; ?>">
            <div class="col-md-3">
                <?php $status = $wpdb->get_results("SELECT * FROM  wp_status_master");
                ?>
                <label>Current Status*</label>
                <select name="statusname" id = "square" class="generate_code_select txt-box">
                    <option value="-1">Select</option>
                    <?php
                    foreach ($status as $each) {
                        ?>
                        <option <?php if ($statuss == $each->status_name) echo 'selected'; ?> value="<?php echo $each->pk_statusmaster_id; ?>"><?php echo $each->status_name; ?></option>';
                    <?php }
                    ?>
                </select>
            </div>
            <div class="chat_form">
                <div class="w_revised">
                    <label>Message*</label>
                    <textarea placeholder="Type here" name="message" id="message" ></textarea>
                </div>
                <input type="submit" name="submit" id="student-support-form"  class="red_btn submitsupportcomment" value="Save">
            </div>
            <div class="support_msg"></div>
            <?php
            $admin_email = get_option('admin_email');
            $sql = "SELECT ID FROM wp_users WHERE user_email = '$admin_email'  LIMIT 1";
            $results = $wpdb->get_results($sql) or die(mysql_error());
            ?>
            <input type="hidden" name="sender_id" id="sender_id" value="<?php echo $results[0]->ID; ?>">
            <input type="hidden" name="adminemail" id="adminemail" value="<?php echo $admin_email; ?>">
        </form>
    <?php } ?>
    <?php
    $user_id = $_POST['receiver_id'];
    $adminid = $_POST['sender_id'];
    $supportmessage = $_POST['message'];
    $semail = $_POST['semail'];
    $studentname = $_POST['sname'];
    $sstatus = $_POST['statusname'];
    $adminemail = $_POST['adminemail'];
    $supportresult = $wpdb->get_results("SELECT * FROM wp_student_support WHERE sender_id = '$user_id' order by create_date DESC");
    if ($supportmessage != '') {
        $insert = $wpdb->insert(
                'wp_student_support', array(
            'receiver_id' => $user_id,
            'sender_id' => $adminid,
            'message' => $supportmessage,
            'create_date' => date('Y-m-d, h:i:s')
                )
        );
        if ($sstatus != '') {
            $updatedata = $wpdb->update(
                    'wp_student_support', array(
                'support_status' => $sstatus,
                    ), array(
                'sender_id' => $user_id,)
            );
        }
        $student_info = get_userdata($user_id);
       //$to = $student_info->user_email;
        $to = 'wadesolomon@yahoo.com';
        $subject = 'Solution' . $packagename . ' ' . $student_info->first_name . ' ' . $student_info->last_name;
        $msg = 'Student ' . $student_info->first_name . ' ' . $reviewer_info->last_name . 'has query on resume.<br/>';
        $msg .= 'Email: ' . $adminemail . '<br/>';
        $msg .= 'Message: ' . $supportmessage . '<br/>';
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: ' . $adminemail . ' ';
        wp_mail($to, $subject, $msg, $headers);
        if ($insert != 1) {
            echo '<span class="text-danger support_msg">not Saved successfully....</span>';
        } else {

            echo '<span class="text-success support_msg"> Saved successfully....</span>';
            ?>
            <script>
                location.reload();
            </script> 
            <?php
        }
        die;
    }
    ?>
<?php } ?>
            <?php
            $admin_email = get_option('admin_email');
            $sql = "SELECT ID FROM wp_users WHERE user_email = '$admin_email'  LIMIT 1";
            $results = $wpdb->get_results($sql) or die(mysql_error());
            ?>
<?php
global $wpdb;
global $current_user;
$current_user = wp_get_current_user();
$current_id = $current_user->ID;
$paged = ($_GET['paged']) ? $_GET['paged'] : 1;
$statusname1 = $_GET['statusname'];
if ($_GET['view']):
    $limit = $_GET['view'];
else:
    $limit = 5;
endif;
$offset = ( $paged - 1 ) * $limit;
$adminuid = $results[0]->ID;
if ($statusname1) {

//    echo "select count(*) FROM( SELECT count(*) FROM wp_student_support"
//            . " LEFT JOIN wp_status_master ON wp_student_support.support_status = wp_status_master.pk_statusmaster_id "
//            . "LEFT JOIN wp_users ON wp_student_support.sender_id = wp_users.ID GROUP BY unique_key WHERE support_status = '$statusname1') d1";
    $total = $wpdb->get_var("select count(*) FROM( SELECT count(*) FROM wp_student_support WHERE support_status = '$statusname1' GROUP BY unique_key) d1 ");
} else {
//    select count(*) FROM( SELECT count(*) FROM wp_student_support "
//            . "LEFT JOIN wp_status_master ON wp_student_support.support_status = wp_status_master.pk_statusmaster_id "
//            . "LEFT JOIN wp_users ON wp_student_support.sender_id = wp_users.ID GROUP BY unique_key) d1
//    select count(*) FROM wp_student_support WHERE support_status != '0'

    $total = $wpdb->get_var("select count(*) FROM( SELECT count(*) FROM wp_student_support WHERE unique_key != '' GROUP BY unique_key) d1
");
}
$num_of_pages = ceil($total / $limit);
if ($statusname1) {
    $supports = $wpdb->get_results("
select * from wp_student_support LEFT JOIN wp_users on wp_users.ID = wp_student_support.sender_id LEFT JOIN wp_status_master ON wp_status_master.pk_statusmaster_id=wp_student_support.support_status where pk_support_id in (SELECT max(pk_support_id) FROM `wp_student_support` WHERE sender_id !='$adminuid' GROUP by unique_key order by create_date DESC) AND wp_users.ID = wp_student_support.sender_id AND support_status = '$statusname1' GROUP by unique_key order by create_date DESC
LIMIT  $offset, $limit");
} else {
    $supports = $wpdb->get_results("select * from wp_student_support LEFT JOIN wp_users on wp_users.ID = wp_student_support.sender_id
        LEFT JOIN wp_status_master ON wp_status_master.pk_statusmaster_id=wp_student_support.support_status where pk_support_id in (SELECT max(pk_support_id) FROM `wp_student_support`
        WHERE sender_id !='$adminuid' GROUP by unique_key order by create_date DESC)
        AND wp_users.ID = wp_student_support.sender_id AND support_status != 0 GROUP by unique_key order by pk_support_id DESC
LIMIT  $offset, $limit ");
}
?>
<?php
if (isset($_POST['search'])) {
    $statusname = $_POST['statusname'];
    ?>
    <script>window.location.href = "<?php echo site_url() . '/wp-admin/admin.php?page=mt-sublevel-page-supports&statusname=' . $statusname; ?>"</script>
<?php } ?>
<?php if (($_REQUEST['id'] == '')) { ?>
    <form method="post" name="search_data" id="search_data" class="search-form" >
        <div class="support_srch">
        <div class="srch_select">
            <?php $status = $wpdb->get_results("SELECT * FROM  wp_status_master");
            ?>
            <label>Status</label>
            <select name="statusname" id = "square" class="generate_code_select txt-box">
                <option value="-1">Select</option>
                <?php
                foreach ($status as $each) {
                    ?>
                    <option <?php if ($_GET['statusname'] == $each->pk_statusmaster_id) echo 'selected'; ?> value="<?php echo $each->pk_statusmaster_id; ?>"><?php echo $each->status_name; ?></option>';
                <?php }
                ?>
            </select>
        </div>
        <div class="srch_status">
            <input type="submit" id="search_submit" value="Search" class="submit_btn" name="search" onclick="searchstatus()">
        </div>
    </div>
    </form>
    <div class="student_resume_list" id="status_list">
        <h1>Support List</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Tickit Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($supports) {
                    foreach ($supports as $support) {
                        ?>
                        <tr>
                            <td><?php echo $support->unique_key; ?></td>
                            <td><?php echo $support->user_login; ?></td>
                            <td><?php echo $support->user_email; ?></td>
                            <td><?php echo $support->subject; ?></td>
                            <td><?php echo $support->status_name; ?></td>
                            <td><a href="<?php echo site_url(); ?>/wp-admin/admin.php?page=mt-sublevel-page-supports&id=<?php echo $support->sender_id; ?>&status=<?php echo $support->status_name; ?>" class="editstatus">View</a></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
        if (function_exists("pagination")) {
            pagination($num_of_pages);
        }
    } else {
        ?>
        <tr>
            <td colspan="7">No record Found..</td>
        </tr>
    <?php } ?>
<?php } ?>
<?php

function pagination($pages = '', $range = 2) {
    // $showitems = ($range * 2) + 1;
    global $paged;
    if (isset($_REQUEST['paged'])) {
        $paged = $_REQUEST['paged'];
    } else {
        $paged = 1;
    }
    if ($pages == '') {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if (!$pages) {
            $pages = 1;
        }
    }
    if (1 != $pages) {
        echo "<ul class='pagination'>";
        if ($paged > 1 && $showitems < $pages)
            echo "<li class='prev_arrow'><a href='" . urldecode(get_pagenum_link($paged - 1)) . "'></a>";
        for ($i = 1; $i <= $pages; $i++) {
            if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems )) {
                echo ($paged == $i) ? "<li class='page_content current'><span>" . $i . "</span></li>" : "<li class='page_content'><a href='" . urldecode(get_pagenum_link($i)) . "' class='inactive' >" . $i . "</a></li>";
            }
        }
        if ($paged < $pages && $showitems < $pages)
            echo "<li class='next_arrow'><a href='" . get_pagenum_link($paged + 1) . "'></a></li>";
        echo "</ul>\n";
    }
    else {
        echo '<ul class="pagination"><li class="page_content"><a href="#">1</a></li></ul>';
    }
}
?>
<script>
    jQuery(document).on("click", ".submitsupportcomment", function () {
        debugger;
        jQuery('.msg_err').remove();
        var message = jQuery('#message').val();
        jQuery('.text-danger').remove();
        var square = jQuery('#square').val();
        var flage = true;
        if (jQuery('#square').val() <= 0) {
            jQuery('#search-data').append('<p class="text-danger" >Please Select Month...</p>');
        }
        if (message == '') {
            jQuery('#message').after('<label class="text-danger msg_err">The field is required.</label>');
            flage = false;
        }
        if (flage == true) {
            jQuery('#student-comment-form').submit();
            jQuery('.msg_err').remove();
            return true;
        } else {
            return false;
        }
    });
</script>
