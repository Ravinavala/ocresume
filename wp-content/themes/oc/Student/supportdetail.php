<?php
/* Template Name:  Student Support details */
?>
<?php get_header('dashboard'); ?>
<?php
 $user_id = $_POST['user_ids'];
 $adminid = $_POST['adminids'];
$supportmessage = $_POST['messages'];
$semail = $_POST['semail'];
$studentname = $_POST['sname'];
$sstatus = $_POST['statusname'];
$adminemail = $_POST['adminemail'];
$supportresult = $wpdb->get_results("SELECT * FROM wp_student_support WHERE sender_id = '$user_id' ");
if (!empty($supportresult)) {
    $uniquenumber = $supportresult[0]->unique_number;
    $uniquekey = $supportresult[0]->unique_key;
}
if ($supportmessage != '') {

 $student_info = get_userdata($user_id);
    //$to = $adminemail;
     $to = 'wadesolomon@yahoo.com';
    $subject = 'Student ' . $student_info->first_name . ' ' . $student_info->last_name . ' has Query on resume';
    $msg = 'Student ' . $student_info->first_name . ' ' . $student_info->last_name . ' has query on resume.<br/>';
    $msg .= 'Email: ' . $semail. '<br/>';
    $msg .= 'Query: ' . $supportmessage . '<br/>';
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: ' . $semail . ' ';
    wp_mail($to, $subject, $msg, $headers);


    $insert = $wpdb->insert(
         'wp_student_support', array(
        'receiver_id' => $adminid,
        'sender_id' => $user_id,
        'message' => $supportmessage,
        'create_date' => date('Y-m-d, h:i:s')
            )
    );
    if ($sstatus != '') {
        $updatedata = $wpdb->update(
                'wp_student_support', array(
            'support_status' => $sstatus,
                ), array(
            'unique_key' => $uniquekey,)
        );
    }
    if ($insert != 1) {
        echo '<span class="text-danger support_msg">not Saved successfully....</span>';
    } else {
        echo '<span class="text-success support_msg"> Saved successfully....</span>';
    }
      
}
?>
<?php
if (isset($_REQUEST['id'])) {
    $currentuser = wp_get_current_user();
    $current_id = $currentuser->ID;
    $statusid = $_REQUEST['id'];
    $statusname = $_REQUEST['status'];
    ?>
    <div class="workspace_mainsuper_right support_msg_box">
        <div id="comment_scroll_id" class="comment_scroll_id">
            <div class="comment_box_main">
                <div class="comment_box_main_title">
                    <h2>Message Box</h2>
                </div>
                <div class="comment_box_main_content">
                    <?php
                    $comments = $wpdb->get_results("SELECT sender_id, receiver_id, message FROM wp_student_support WHERE  sender_id = '$statusid'  OR receiver_id = '$statusid'");
                    foreach ($comments as $comment) {
                        if ($comment->sender_id == $current_id) {
                            $chat_class = "chat_right";
                        } else {
                            $chat_class = "chat_left";
                        }
                        ?>
                        <div class="<?php echo $chat_class; ?>">
                            <div class="chat_text">
                                <p><?php echo $comment->message; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php
$statusname = $_REQUEST['status'];
$currentticket = $wpdb->get_results("SELECT * FROM wp_student_support WHERE  sender_id = '$statusid' && support_status != '0' ORDER BY pk_support_id DESC LIMIT 1");
if ($currentticket[0]->support_status == 2) {
    ?>
    <div class="col-md-3">
        <?php $status = $wpdb->get_results("SELECT * FROM  wp_status_master");
        ?>
        <label>Status</label>
        <select name="statusname" class="generate_code_select txt-box">
            <option>Select</option>
            <?php foreach ($status as $each) { ?>
                <option <?php
                if ($statusname == $each->status_name) {
                    echo 'Selected';
                }
                ?> value="<?php echo $each->pk_statusmaster_id; ?>"><?php echo $each->status_name; ?></option>';
                <?php }
                ?>
        </select>
    </div><?php } ?>
<?php
$statusname = $_REQUEST['status'];
if ($currentticket[0]->support_status == 1) {

    ?>
    <form id="student-support-form" method="post">
        <input type="hidden" name="supportstatus" id="supportstatus" value="1">
        <input type="hidden" name="user_ids" id="user_ids" value="<?php echo $current_id; ?>">
        <div class="col-md-3">
            <?php $status = $wpdb->get_results("SELECT * FROM  wp_status_master");
            ?>
            <label>Status</label>
            <select name="statusname" class="generate_code_select txt-box">
                <option>Select</option>
                <?php
                foreach ($status as $each) {
                    ?>
                    <option <?php
                    if ($statusname == $each->status_name) {
                        echo 'Selected';
                    }
                    ?> value="<?php echo $each->pk_statusmaster_id; ?>"><?php echo $each->status_name; ?></option>';
                    <?php }
                    ?>
            </select>
        </div>
        <div class="chat_form">
            <div class="w_revised">
                <label>Message*</label>
                <textarea placeholder="Type here" name="messages" id="messages" ></textarea>
            </div>
        </div>
        <input type="submit" name="submit" id="student-comment-form"  class="red_btn submitsupportcomment" value="Submit">
        <div class="support_msg"></div>
        <?php
        $admin_email = get_option('admin_email');
        $sql = "SELECT ID FROM wp_users WHERE user_email = '$admin_email'  LIMIT 1";
        $results = $wpdb->get_results($sql) or die(mysql_error());
        ?>
        <input type="hidden" name="adminids" id="adminids" value="<?php echo $results[0]->ID; ?>">
        <input type="hidden" name="adminemail" id="adminemail" value="<?php echo $admin_email; ?>">
    </form>
<?php } ?>

<?php get_footer('dashboard'); ?>