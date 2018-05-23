<?php
/*
  Template Name: Student support
 */
?>
<?php if (!is_user_logged_in()): ?>
    <script>window.location.href = "<?php echo site_url(); ?>";</script>
<?php endif; ?>
<?php get_header('dashboard'); ?>
<h1 class="page-title"><?php the_title(); ?></h1>
<?php
$currentuser = wp_get_current_user();
$user_id = $currentuser->ID;
?>
<?php
global $wpdb;
$supportresult = $wpdb->get_results("SELECT * FROM wp_student_support WHERE sender_id = '$user_id'  ");
if (empty($supportresult)) {
    ?>
    <form id="student-support-form" method="post" style="display:block">
        <input type="hidden" name="supportstatus" id="supportstatus" value="1" >
        <input type="hidden" name="user_id" id="user_id" value="<?php echo $currentuser->ID; ?>">
        <div class="c_row">
            <div class="w_revised ">
                <label>Name*</label>
                <input type="text" class="readonly_fields" id="sname" name="sname" maxlength="200" placeholder="Type here" value="<?php echo $currentuser->user_login; ?>">
            </div>
            <div class="w_revised ">
                <label>Email*</label>
                <input type="text" class="readonly_fields" id="semail" name="semail" maxlength="70" placeholder="Type here" value="<?php echo $currentuser->user_email; ?>">
            </div>
            <div class="w_revised ">
                <label>Subject*</label>
                <input type="text" class="" id="ssubject" name="ssubject" maxlength="200" placeholder="Type here" value="">
            </div>
            <div class="w_revised">
                <label>Message*</label>
                <textarea placeholder="Type here" name="message" id="message" ></textarea>
            </div>
            <div class="grey_row">
                <div class="grey_row_right">
                    <input type="submit" name="submit" id="student-support-form"  class="red_btn submitsupportform" value="Submit">
                </div>
            </div>
        </div>
        <?php
        $admin_email = get_option('admin_email');
        $sql = "SELECT ID FROM wp_users WHERE user_email = '$admin_email'  LIMIT 1";
        $results = $wpdb->get_results($sql) or die(mysql_error());
        ?>
        <input type="hidden" name="adminid" id="adminid" value="<?php echo $results[0]->ID; ?>">
        <input type="hidden" name="adminemail" id="adminemail" value="<?php echo $admin_email; ?>">
        <div class="support_msg"></div>
    </form>
<?php } else {
    ?>
    <form id="student-support-form" method="post" style="display:none">
        <input type="hidden" name="supportstatus" id="supportstatus" value="1" >
        <input type="hidden" name="user_id" id="user_id" value="<?php echo $currentuser->ID; ?>">

        <div class="c_row">
            <div class="w_revised ">
                <label>Name*</label>
                <input type="text" class="readonly_fields" id="sname" name="sname" maxlength="200" placeholder="Type here" value="<?php echo $currentuser->user_login; ?>">
            </div>
            <div class="w_revised ">
                <label>Email*</label>
                <input type="text" class="readonly_fields" id="semail" name="semail" maxlength="70" placeholder="Type here" value="<?php echo $currentuser->user_email; ?>">
            </div>
            <div class="w_revised ">
                <label>Subject*</label>
                <input type="text" class="" id="ssubject" name="ssubject" maxlength="200" placeholder="Type here" value="">
            </div>
            <div class="w_revised">
                <label>Message*</label>
                <textarea placeholder="Type here" name="message" id="message" ></textarea>
            </div>
            <div class="grey_row">
                <div class="grey_row_right">
                    <input type="submit" name="submit" id="student-support-form"  class="red_btn submitsupportform" value="Submit">
                </div>
            </div>
        </div>
        <?php
        $admin_email = get_option('admin_email');
        $sql = "SELECT ID FROM wp_users WHERE user_email = '$admin_email'  LIMIT 1";
        $results = $wpdb->get_results($sql) or die(mysql_error());
        ?>
        <input type="hidden" name="adminid" id="adminid" value="<?php echo $results[0]->ID; ?>">
        <input type="hidden" name="adminemail" id="adminemail" value="<?php echo $admin_email; ?>">
        <div class="support_msg"></div>
    </form>
<?php } ?>
<?php
$sql = "select * from wp_student_support LEFT JOIN wp_users on wp_users.ID = wp_student_support.sender_id LEFT JOIN wp_status_master ON wp_status_master.pk_statusmaster_id=wp_student_support.support_status where pk_support_id in (SELECT max(pk_support_id) FROM `wp_student_support` WHERE sender_id ='$user_id' AND support_status != '0' GROUP by unique_key order by create_date DESC) AND wp_users.ID = wp_student_support.sender_id GROUP by unique_key DESC
LIMIT 1";
$supports = $wpdb->get_results($sql);
?>
<?php if ($supports) { ?>
    <input type="hidden" name="studentsuppory" id="studentsuppory" value="<?php echo $supports[0]->support_status; ?>">
    <div class="student_resume_list" id="support_list">
        <h1>Support List</h1><input type="button" name="submit" id="addnewbutton"  class="addnewbutton" value="Add New Ticket">
        <div class="tbl_scroll">
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
                    <?php foreach ($supports as $support) { ?>
                        <tr><td><?php echo $support->unique_key; ?></td>
                            <td><?php echo $support->user_login; ?></td>
                            <td><?php echo $support->user_email; ?></td>
                            <td><?php echo $support->subject; ?></td>
                            <td><?php echo $support->status_name; ?></td>
                            <td><a href="<?php the_permalink(292); ?>?id=<?php echo $support->sender_id; ?>&status=<?php echo $support->status_name; ?>" class="viewstatus">View</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>
<?php get_footer('dashboard'); ?>

