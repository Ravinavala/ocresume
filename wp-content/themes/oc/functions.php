<?php
define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/');
require_once dirname(__FILE__) . '/inc/options-framework.php';

include(get_template_directory() . "/inc/custom-post.php");

if (!function_exists('oc_setup')) :

    function oc_setup() {

        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');

        add_theme_support('html5', array(
            'search-form',
            'gallery',
            'caption',
        ));

        add_theme_support('post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
            'gallery',
            'status',
            'audio',
            'chat',
        ));
    }

endif;
add_action('after_setup_theme', 'oc_setup');

/** Registers a widget area. */
function oc_widgets_init() {
    register_sidebar(array(
        'name' => __('Sidebar', 'oc'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here to appear in your sidebar.', 'oc'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => 'Faculty sidebar',
        'id' => 'faculty_sidebar',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
}

add_action('widgets_init', 'oc_widgets_init');

function register_my_menus() {
    register_nav_menus(
            array(
                'main-menu' => __('Main Menu')
    ));
}

add_action('init', 'register_my_menus');

//-----------------Redirect login failed ------------------------//
function login_failed() {
    $login_page = home_url('/login/');
    wp_redirect($login_page . '?login=failed');
    exit;
}

add_action('wp_login_failed', 'login_failed');

//-----------------Redirect login empty ------------------------//
function verify_username_password($user, $username, $password) {
    $login_page = home_url('/login/');
    if ($username == "" || $password == "") {
        wp_redirect($login_page);
        exit;
    }
}

add_filter('authenticate', 'verify_username_password', 1, 3);

//-----------------logout page link------------------------/
function logout_page() {
    $login_page = home_url();
    wp_redirect($login_page);
    exit;
}

add_action('wp_logout', 'logout_page');

//remove the existing string/level cost text
function my_pmpro_level_cost_text($r, $level, $tags, $short) {
    $r = '';
//initial payment
    if (!$short)
        $r = sprintf(__('The price for membership is <strong>%s</strong>', 'pmpro'), pmpro_formatPrice($level->initial_payment));
    else
        $r = sprintf(__('<strong>%s</strong> ', 'pmpro'), pmpro_formatPrice($level->initial_payment));
    return $r;
}

add_filter('pmpro_level_cost_text', 'my_pmpro_level_cost_text', 10, 4);

//-------Add workflow status for new order -------//
add_filter('pmpro_added_order', 'add_status', 10, 4);

function add_status() {
    global $current_user, $wpdb, $pmpro_checkout_id;

    $packagelevel = $_GET['level'];
    if ($packagelevel == 3) {
        $status = 3;
    } else if ($packagelevel == 4) {
        $status = 2;
    } else {
        $status = 1;
    }


    $wpdb->update(
            'wp_pmpro_membership_orders', array('workflow_status' => $status), array('checkout_id' => $pmpro_checkout_id), array('%s'), array('%d')
    );
}

add_action("pmpro_after_checkout", "update_user_meta_after_upgrade", 10, 1);

function update_user_meta_after_upgrade($user_id) {

    $bphone = get_user_meta($user_id, "pmpro_bphone", true);
    update_user_meta($user_id, 'phone', $bphone);

    return;
}

//----------redirerction after login --------//
function redirect_login_page($redirect_to, $request, $user) {
    if (strpos($redirect_to, 'membership-account') !== false) {
        return $redirect_to;
    } else {
        if (isset($user->roles) && is_array($user->roles)) {
            if (in_array('student', $user->roles)) {
                return home_url('student/dashboard/');
            } else if (in_array('reviewer', $user->roles)) {
                echo home_url('reviewer/dashboard/');
                return home_url('reviewer/dashboard/');
            } else {
                return $redirect_to;
            }
        }
    }
}

add_filter('login_redirect', 'redirect_login_page', 10, 3);

/* * *********** Pagignation Function ************** */

function custom_pagination($paged = '', $pages = '', $range = 2) {
    $showitems = ($range * 2) + 1;
    if (1 != $pages) {
        echo "<ul class='pagination'>";
        if ($paged > 1 && $showitems < $pages)
            echo "<li class='prev_arrow'><a href='" . urldecode(get_pagenum_link($paged - 1)) . "'></a>";
        for ($i = 1; $i <= $pages; $i++) {
            if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems )) {
                echo ($paged == $i) ? "<li class='page_content'><span>" . $i . "</span></li>" : "";
            }
        }
        if ($paged < $pages && $showitems < $pages)
            echo "<li class='next_arrow'><a href='" . get_pagenum_link($paged + 1) . "'></a></li>";
        echo "</ul>\n";
    } else {
        echo '<ul class="pagination"><li class="page_content"><span>1</span></li></ul>';
    }
}

//----- function to set range -------//
function dateDiff($range_date) {
    $newDate = date("Y-m-d", strtotime($range_date));
    $start = strtotime($newDate);
    $end = strtotime(date('Y-m-d'));
    $diff = $end - $start;
    $day = round($diff / 86400);
    if ($day <= 7) {
        return "0 to 7 days";
    } elseif ($day > 7 && $day <= 14) {
        return "8 to 14 days";
    } elseif ($day > 15 && $day <= 21) {
        return "15 to 21 days";
    } elseif ($day > 21 && $day <= 28) {
        return "22 to 28 days";
    } else {
        return "Over 28 days";
    }
}

//----------Add custom field to add user/edit user to admin ---------//
add_action('show_user_profile', 'extra_user_profile_fields');
add_action('edit_user_profile', 'extra_user_profile_fields');
add_action('user_new_form', 'extra_user_profile_fields');

function extra_user_profile_fields($user) {
    ?>
    <h3><?php _e("Extra profile information", "blank"); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="phone"><?php _e("Phone"); ?></label></th>
            <td>
                <input type="text" name="phone" id="phone" class="regular-text"
                       value="<?php echo esc_attr(get_the_author_meta('phone', $user->ID)); ?>" /><br />
                <span class="description"><?php _e("Please enter your phone."); ?></span>
            </td>
        </tr>
    </table>
    <?php
}

add_action('personal_options_update', 'save_extra_user_profile_fields');
add_action('edit_user_profile_update', 'save_extra_user_profile_fields');
add_action('user_register', 'save_extra_user_profile_fields');

function save_extra_user_profile_fields($user_id) {
    $saved = false;
    update_user_meta($user_id, 'phone', $_POST['phone']);
    $saved = true;
    return true;
}

/* Ajax call for save_profile */
add_action('wp_ajax_nopriv_save_profile', 'save_profile_callback');
add_action('wp_ajax_save_profile', 'save_profile_callback');

function save_profile_callback() {
    $user_ID = get_current_user_id();
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    update_user_meta($user_ID, 'first_name', $fname);
    update_user_meta($user_ID, 'last_name', $lname);
    update_user_meta($user_ID, 'phone', $phone);
    update_user_meta($user_ID, 'pmpro_bphone', $phone);
    $user_id = wp_update_user(array('ID' => $user_ID, 'user_email' => $email));
    if (is_wp_error($user_id)) {
        echo '<span class="text-danger profile_msg"> Personal Info  not updated successfully.......</span>';
    } else {
        echo '<span class="text-success profile_msg"> Personal Info  updated successfully.......</span>';
    }
    die;
}

/* End Ajax call for save_profile */

/* Ajax call for save_pass */
add_action('wp_ajax_nopriv_save_pass', 'save_pass_callback');
add_action('wp_ajax_save_pass', 'save_pass_callback');

function save_pass_callback() {
    require_once( ABSPATH . WPINC . '/class-phpass.php');
    $user_ID = get_current_user_id();
    $pass = $_POST['pass'];
    $new_pass = $_POST['new_pass'];
    $conf_pass = $_POST['conf_pass'];
    $user_info = get_userdata($user_ID);
    $wp_hasher = new PasswordHash(8, TRUE);
    if ($wp_hasher->CheckPassword($pass, $user_info->user_pass)) {
        $user_data = array(
            'ID' => $user_ID,
            'user_pass' => $new_pass
        );
        wp_update_user($user_data);
        echo '<span class="text-success pass_msg1">Password updated successfully......</span>';
    } else {
        echo '<span class="text-danger pass_msg1"> Current Password not matched</span>';
    }
    die;
}

/* End Ajax call for save_pass */

/* Ajax call for save_pic */
add_action('wp_ajax_nopriv_save_pic', 'save_pic_callback');
add_action('wp_ajax_save_pic', 'save_pic_callback');

function save_pic_callback() {

    $user_ID = get_current_user_id();
    if (0 < $_FILES['file']['error']) {
        $data = array('image' => '', 'message' => '<span class="text-danger pic_msg1">Profile not uploaded..</span>');
        echo json_encode($data);
    } else {
        $uploadFileName = $_FILES['file']['name'];
        if (isset($uploadFileName) && !empty($uploadFileName)) {
            $extension = pathinfo($uploadFileName, PATHINFO_EXTENSION);
            $tutorphotoname = $_FILES['file']['name'];
            $uploaddir = $_SERVER['DOCUMENT_ROOT'] . "/test/wp-content/uploads/profile/";
            $check_filetype = wp_check_filetype($tutorphotoname);
            $uploadfile = $uploaddir . $tutorphotoname;

            if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
                $src = $uploadfile;
                if ($extension == 'png') {
                    $dest = $uploaddir . $_FILES['file']['name'];
                    $source_image = imagecreatefrompng($src);
                    $width = imagesx($source_image);
                    $height = imagesy($source_image);
                    $virtual_image = imagecreatetruecolor(150, 150);
                    imagecopyresized($virtual_image, $source_image, 0, 0, 0, 0, 150, 150, $width, $height);
                    imagepng($virtual_image, $dest);
                } else {
                    $dest = $uploaddir . $_FILES['file']['name'];
                    $source_image = imagecreatefromjpeg($src);
                    $width = imagesx($source_image);
                    $height = imagesy($source_image);
                    $virtual_image = imagecreatetruecolor(150, 150);
                    imagecopyresized($virtual_image, $source_image, 0, 0, 0, 0, 150, 150, $width, $height);
                    imagejpeg($virtual_image, $dest);
                }
                $uploads = wp_upload_dir();
                $profile_pic = $uploads['baseurl'] . "/profile/" . $_FILES['file']['name'];

                //Delete old profile Picture
                $filename = get_user_meta($user_ID, 'profile_image', TRUE);
                $urlparts = parse_url($filename);
                $extracted = $urlparts['path'];
                ltrim($extracted, '/');
                $extracted = ABSPATH . $extracted;
                if (file_exists($extracted)) {
                    unlink($extracted);
                }
                update_user_meta($user_ID, 'profile_image', $profile_pic);
                $data = array('image' => $profile_pic, 'message' => '<span class="text-success pic_msg1">Profile updated successfully......</span>');
                echo json_encode($data);
            } else {
                $data = array('image' => '', 'message' => '<span class="text-danger pic_msg1">Profile not uploaded..</span>');
                echo json_encode($data);
            }
        }
    }
    die;
}

/* End Ajax call for save_pic */

/* ------------------- Forgot Password Email --------------------------------- */

function forgot_pw_ajax() {
    $email = $_POST['email'];
    if (email_exists($email)) {
        $to = $email;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'This is my secret key';
        $secret_iv = 'This is my secret iv';
// hash
        $key = hash('sha256', $secret_key);
// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $output = openssl_encrypt($email, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        $subject = 'Reset Password Link for Ocresume';
        $msg = 'Please click on the below link to reset password <br/>';
        $msg .= '<a href="' . site_url() . '/reset-password?string=' . $output . '">' . site_url() . '/reset-password?string=' . $output . '</a>';
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: Ocresume <mike@OCresume.net.com>' . "\r\n";
        wp_mail($to, $subject, $msg, $headers);
        echo '1';
    } else {
        echo '0';
    }
    die();
}

add_action('wp_ajax_nopriv_forgot_pw_ajax', 'forgot_pw_ajax');
add_action('wp_ajax_forgot_pw_ajax', 'forgot_pw_ajax');
/* ------------------- End Forgot Password Email --------------------------------- */

/* ------------------- Reset Password Email --------------------------------- */

function reset_pw_ajax() {
    $pass = $_POST['oldpass'];
    $password = $_POST['password'];
    $user_id = $_POST['user_id'];
    $email = $_POST['email'];
    $user_login = $_POST['uname'];
    if ($password != '' && $user_id != '' && $email != '' && $user_login != '' && $pass != $password) {
        wp_set_password($password, $user_id);
        $subject = 'New Password';
        $message = __('Your new password for the account at:') . "\r\n\r\n";
        $message .= get_option('siteurl') . "\r\n\r\n";
        $message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
        $message .= sprintf(__('Password: %s'), $password) . "\r\n\r\n";
        $message .= __('You can now login with your new password at: ') . get_permalink(83) . "\r\n\r\n";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: Ocresume <mike@OCresume.net.com>' . "\r\n";
        wp_mail($email, $subject, $message, $headers);
        echo '1';
    } else {
        echo '0';
    }
    die();
}

add_action('wp_ajax_nopriv_reset_pw_ajax', 'reset_pw_ajax');
add_action('wp_ajax_reset_pw_ajax', 'reset_pw_ajax');
/* ------------------- End Reset Password Email --------------------------------- */


/* Ajax call for Assign Reviewer */
add_action('wp_ajax_nopriv_assign_reviewer', 'assign_reviewer_callback');
add_action('wp_ajax_assign_reviewer', 'assign_reviewer_callback');

function assign_reviewer_callback() {

    global $wpdb;
    $assign = $_POST['assign'];
    $package_id = $_POST['package_id'];
    $currentuser_id = $_POST['currentuser_id'];

    $user_id = $wpdb->get_row("SELECT user_id FROM wp_pmpro_membership_orders WHERE id = $package_id LIMIT 1");
    $user_info = get_userdata($user_id->user_id);
    $reviewer_info = get_userdata($currentuser_id);
    $assignto_info = get_userdata($assign);

    $update = $wpdb->update(
            'wp_pmpro_membership_orders', array('is_assigned' => 1, 'reviewer_id' => $assign), array('id' => $package_id)
    );

    if ($currentuser_id == $assign) {
        $subject = 'You selected Resume of ' . $user_info->first_name . ' ' . $user_info->last_name;
        $history = $reviewer_info->first_name . ' ' . $reviewer_info->last_name . ' select Resume of  ' . $user_info->first_name . ' ' . $user_info->last_name;
    } else {
        $subject = $reviewer_info->first_name . ' ' . $reviewer_info->last_name . ' assigned  ' . $user_info->first_name . ' ' . $user_info->last_name . ' Resume to you';
        $history = $reviewer_info->first_name . ' ' . $reviewer_info->last_name . ' assigned  ' . $user_info->first_name . ' ' . $user_info->last_name . ' Resume to  ' . $assignto_info->first_name . ' ' . $assignto_info->last_name;
    }

//Send mail of assign resume to reviewer
    $to = $assignto_info->user_email;
    $subject = $subject;
    $msg = $subject . '<br/>';
    $msg .= 'Click here to see: ' . get_site_url() . '/reviewer/package/?id=' . $package_id;
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: Ocresume <mike@OCresume.net.com>' . "\r\n";
    wp_mail($to, $subject, $msg, $headers);

//Add Notification to reviewer for assign resume
    $table_notifications = $wpdb->prefix . 'notifications';
    $wpdb->insert(
            $table_notifications, array(
        'datetime' => date('Y-m-d, h:i:s'),
        'recipient_id' => $assign,
        'sender_id' => $currentuser_id,
        'notification' => $subject,
        'package_id' => $package_id,
        'action' => '',
        'is_view' => 0
            )
    );

//Add History of Reviewer for assign resume
    $table_history = $wpdb->prefix . 'history';
    $wpdb->insert(
            $table_history, array(
        'datetime' => date('Y-m-d, h:i:s'),
        'reviewer_id' => $currentuser_id,
        'history' => $history,
            )
    );

    //Add Notification to student for assign resume
    $noti = 'Yours resume assigend to ' . $assignto_info->first_name . ' ' . $assignto_info->last_name;
    $table_notifications = $wpdb->prefix . 'notifications';
    $wpdb->insert(
            $table_notifications, array(
        'datetime' => date('Y-m-d, h:i:s'),
        'recipient_id' => $user_id->user_id,
        'sender_id' => $currentuser_id,
        'notification' => $noti,
        'package_id' => $package_id,
        'action' => '',
        'is_view' => 0
            )
    );

    if ($update != 1) {
        $data = array('review' => '', 'message' => '<span class="text-danger assign_msg1">Not Assigned successfully....</span>');
        echo json_encode($data);
    } else {
        $user_info = get_userdata($assign);
        $review = $user_info->first_name . ' ' . $user_info->last_name;
        $data = array('review' => $review, 'message' => '<span class="text-success assign_msg1">Assigned successfully....</span>');
        echo json_encode($data);
    }
    die;
}

/* End Ajax call for save_profile */

//----- Disable Admin Bar for All Users Except for Administrators ---//
add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}

/* Ajax call for  Personal Informational  */
add_action('wp_ajax_nopriv_save_info', 'save_info_callback');
add_action('wp_ajax_save_info', 'save_info_callback');

function save_info_callback() {

    global $wpdb;
    $package_id = $_POST['package_id'];
    $update = $wpdb->update(
            'wp_pmpro_membership_orders', array(
        'name' => $_POST['studentname'],
        'phone' => $_POST['studentphone'],
        'email' => $_POST['studentemail'],
        'school' => $_POST['studentschool'],
        'city' => $_POST['studentcity'],
        'degree' => $_POST['studentdegree'],
        'graduation_date' => date('Y-m-d', strtotime($_POST['gdate'])),
        'linkedin' => $_POST['studentlinkedinprofile'],
        'endorsement' => $_POST['studentendorsment'],
        'jobdescription' => $_POST['jobdescription'],
            ), array('id' => $package_id)
    );
    $update = 1;
    if ($update != 1) {

        echo '<span class="text-danger info_msg1">Personal Informational not Saved successfully....</span>';
    } else {

        echo '<span class="text-success info_msg1">Personal Informational Saved successfully....</span>';
    }
    die;
}

/* End Ajax call for about thing  */

/* Ajax call for  about things  */
add_action('wp_ajax_nopriv_save_aboutthing', 'save_aboutthing_callback');
add_action('wp_ajax_save_aboutthing', 'save_aboutthing_callback');

function save_aboutthing_callback() {

    global $wpdb;
    $user_id = $_POST['user_id'];
    $package_id = $_POST['package_id'];
    $things = $_POST['things'];
    $count = 0;
    foreach ($things as $thing) {

        $count++;
        if ($_POST['is_submit'] == 1) {
            $about = $wpdb->get_row("SELECT pk_about_id FROM about_student WHERE fk_package_id = '$package_id' AND about_id = '$count' LIMIT 1");
            if ($about->pk_about_id) {
                $update = $wpdb->update(
                        'about_student', array(
                    'about_things' => $thing,
                    'about_id' => $count,
                    'fk_package_id' => $package_id,
                    'fk_user_id' => $user_id,
                        ), array(
                    'pk_about_id' => $about->pk_about_id,
                        )
                );
                $update = 1;
            } else {
                $update = $wpdb->insert(
                        'about_student', array(
                    'about_things' => $thing,
                    'about_id' => $count,
                    'fk_package_id' => $package_id,
                    'fk_user_id' => $user_id,
                        )
                );
            }
        } else {
            $update = $wpdb->insert(
                    'about_student', array(
                'about_things' => $thing,
                'about_id' => $count,
                'fk_package_id' => $package_id,
                'fk_user_id' => $user_id,
                    )
            );
        }
    }
    if ($update != 1) {
        echo '<span class="text-danger about_msg1"> not Saved successfully....</span>';
    } else {
        echo '<span class="text-success about_msg1">Saved successfully....</span>';
    }
    die;
}

/* End Ajax call for  about thing  */

/* Ajax call for  Save Skills  */
add_action('wp_ajax_nopriv_save_skills', 'save_skills_callback');
add_action('wp_ajax_save_skills', 'save_skills_callback');

function save_skills_callback() {

    global $wpdb;
    $user_id = $_POST['user_id'];
    $package_id = $_POST['package_id'];
    $skills = $_POST['skills'];
    $skills = stripslashes_deep($skills);
    $count = 0;
    foreach ($skills as $skill) {
        $skill = json_decode($skill, TRUE);
        $count++;
        if ($_POST['is_submit'] == 1) {
            if ($skill['s_id'] != '') {
                $update = $wpdb->update(
                        'skills', array(
                    'skill' => $skill['skill'],
                    'skill_id' => $count,
                    'fk_package_id' => $package_id,
                    'fk_user_id' => $user_id,
                        ), array(
                    'pk_skill_id' => $skill['s_id'],
                        )
                );
                $update = 1;
            } else {
                $update = $wpdb->insert(
                        'skills', array(
                    'skill' => $skill['skill'],
                    'skill_id' => $count,
                    'fk_package_id' => $package_id,
                    'fk_user_id' => $user_id,
                        )
                );
            }
        } else {
            $update = $wpdb->insert(
                    'skills', array(
                'skill' => $skill['skill'],
                'skill_id' => $count,
                'fk_package_id' => $package_id,
                'fk_user_id' => $user_id,
                    )
            );
        }
    }
    if ($update == 0) {
        echo '<span class="text-danger skill_msg1">Not Saved successfully....</span>';
    } else {
        echo '<span class="text-success skill_msg1">Saved successfully....</span>';
    }
    die;
}

/* End Ajax call for  Save Skills  */

/* Ajax call for Courses and Certifications   */



add_action('wp_ajax_nopriv_save_course', 'save_course_callback');
add_action('wp_ajax_save_course', 'save_course_callback');

function save_course_callback() {

    global $wpdb;
    $user_id = $_POST['user_id'];
    $package_id = $_POST['package_id'];
    $studentcourse = $_POST['studentcourse'];
    $studentcourse = stripslashes_deep($studentcourse);
    $count = 0;
    foreach ($studentcourse as $course) {
        $course = json_decode($course, TRUE);
        $count++;
        if ($_POST['is_submit'] == 1) {
            if ($course['c_id'] != '') {
                $update = $wpdb->update(
                        'course', array(
                    'course' => $course['course'],
                    'course_id' => $count,
                    'fk_package_id' => $package_id,
                    'fk_user_id' => $user_id,
                        ), array(
                    'pk_course_id' => $course['c_id']
                        )
                );
                $update = 1;
            } else {
                $update = $wpdb->insert(
                        'course', array(
                    'course' => $course['course'],
                    'course_id' => $count,
                    'fk_package_id' => $package_id,
                    'fk_user_id' => $user_id,
                        )
                );
            }
        } else {
            $update = $wpdb->insert(
                    'course', array(
                'course' => $course['course'],
                'course_id' => $count,
                'fk_package_id' => $package_id,
                'fk_user_id' => $user_id,
                    )
            );
        }
    }
    if ($update != 1) {
        echo '<span class="text-danger course_msg1">not Saved successfully....</span>';
    } else {
        echo '<span class="text-success course_msg1"> Saved successfully....</span>';
    }
    die;
}

/* End Ajax call for Courses and Certifications   */

/* Ajax call for  Save Software  */
add_action('wp_ajax_nopriv_save_software', 'save_software_callback');
add_action('wp_ajax_save_software', 'save_software_callback');

function save_software_callback() {

    global $wpdb;
    $user_id = $_POST['user_id'];
    $package_id = $_POST['package_id'];
    $studentsoftwares = $_POST['studentsoftwares'];
    $studentsoftwares = stripslashes_deep($studentsoftwares);
    $count = 0;
    foreach ($studentsoftwares as $software) {
        $software = json_decode($software, TRUE);
        $count++;
        if ($_POST['is_submit'] == 1) {

            if ($software['sw_id'] != '') {
                $update = $wpdb->update(
                        'knowledge_software', array(
                    'software' => $software['software'],
                    'software_id' => $count,
                    'fk_package_id' => $package_id,
                    'fk_user_id' => $user_id,
                        ), array(
                    'pk_software_id' => $software['sw_id']
                        )
                );
                $update = 1;
            } else {
                $update = $wpdb->insert(
                        'knowledge_software', array(
                    'software' => $software['software'],
                    'software_id' => $count,
                    'fk_package_id' => $package_id,
                    'fk_user_id' => $user_id,
                        )
                );
            }
        } else {
            $update = $wpdb->insert(
                    'knowledge_software', array(
                'software' => $software['software'],
                'software_id' => $count,
                'fk_package_id' => $package_id,
                'fk_user_id' => $user_id,
                    )
            );
        }
    }
    if ($update != 1) {
        echo '<span class="text-danger software_msg1">not Saved successfully....</span>';
    } else {
        echo '<span class="text-success software_msg1"> Saved successfully....</span>';
    }
    die;
}

/* End Ajax call for Save Software   */

/* Ajax call for call for Honors  */

add_action('wp_ajax_nopriv_save_honors', 'save_honors_callback');
add_action('wp_ajax_save_honors', 'save_honors_callback');

function save_honors_callback() {

    global $wpdb;
    $user_id = $_POST['user_id'];
    $package_id = $_POST['package_id'];
    $studenthonors = $_POST['studenthonors'];
    $studenthonors = stripslashes_deep($studenthonors);
    $count = 0;
    foreach ($studenthonors as $honor) {
        $honor = json_decode($honor, TRUE);
        $count++;
        if ($_POST['is_submit'] == 1) {
            if ($honor['h_id'] != '') {
                $update = $wpdb->update(
                        'honor', array(
                    'honor' => $honor['honor'],
                    'honor_id' => $count,
                    'fk_package_id' => $package_id,
                    'fk_user_id' => $user_id,
                        ), array(
                    'pk_honor_id' => $honor['h_id'],
                        )
                );
                $update = 1;
            } else {
                $update = $wpdb->insert(
                        'honor', array(
                    'honor' => $honor['honor'],
                    'honor_id' => $count,
                    'fk_package_id' => $package_id,
                    'fk_user_id' => $user_id,
                        )
                );
            }
        } else {
            $update = $wpdb->insert(
                    'honor', array(
                'honor' => $honor['honor'],
                'honor_id' => $count,
                'fk_package_id' => $package_id,
                'fk_user_id' => $user_id,
                    )
            );
        }
    }
    if ($update != 1) {
        echo '<span class="text-danger honor_msg1">not Saved successfully....</span>';
    } else {
        echo '<span class="text-success honor_msg1"> Saved successfully....</span>';
    }
    die;
}

/* End Ajax call for Honors  */

/* Ajax call for call for Activity  */

add_action('wp_ajax_nopriv_save_activitues', 'save_activitues_callback');
add_action('wp_ajax_save_activitues', 'save_activitues_callback');

function save_activitues_callback() {

    global $wpdb;
    $user_id = $_POST['user_id'];
    $package_id = $_POST['package_id'];
    $studentactivities = $_POST['studentactivities'];
    $studentactivities = stripslashes_deep($studentactivities);
    $count = 0;
    foreach ($studentactivities as $activity) {
        $activity = json_decode($activity, TRUE);
        $count++;
        if ($_POST['is_submit'] == 1) {
            if ($activity['a_id'] != '') {
                $update = $wpdb->update(
                        'activity', array(
                    'activity' => $activity['activity'],
                    'activity_id' => $count,
                    'fk_package_id' => $package_id,
                    'fk_user_id' => $user_id,
                        ), array(
                    'pk_activity_id' => $activity['a_id'],
                        )
                );
                $update = 1;
            } else {
                $update = $wpdb->insert(
                        'activity', array(
                    'activity' => $activity['activity'],
                    'activity_id' => $count,
                    'fk_package_id' => $package_id,
                    'fk_user_id' => $user_id,
                        )
                );
            }
        } else {
            $update = $wpdb->insert(
                    'activity', array(
                'activity' => $activity['activity'],
                'activity_id' => $count,
                'fk_package_id' => $package_id,
                'fk_user_id' => $user_id,
                    )
            );
        }
    }
    if ($update != 1) {
        echo '<span class="text-danger activity_msg1">not Saved successfully....</span>';
    } else {
        echo '<span class="text-success activity_msg1"> Saved successfully....</span>';
    }
    die;
}

/* End Ajax call for Activity  */

/* Ajax call for call for Interests  */
add_action('wp_ajax_nopriv_save_interest', 'save_interest_callback');
add_action('wp_ajax_save_interest', 'save_interest_callback');

function save_interest_callback() {

    global $wpdb;
    $user_id = $_POST['user_id'];
    $package_id = $_POST['package_id'];
    $studentinterests = $_POST['studentinterests'];
    $studentinterests = stripslashes_deep($studentinterests);
    $count = 0;
    foreach ($studentinterests as $interest) {
        $interest = json_decode($interest, TRUE);
        $count++;
        if ($_POST['is_submit'] == 1) {
            if ($interest['i_id'] != '') {
                $update = $wpdb->update(
                        'interests', array(
                    'interests' => $interest['intrest'],
                    'interest_id' => $count,
                    'fk_package_id' => $package_id,
                    'fk_user_id' => $user_id,
                        ), array(
                    'pk_interest_id' => $interest['i_id']
                        )
                );
                $update = 1;
            } else {
                $update = $wpdb->insert(
                        'interests', array(
                    'interests' => $interest['intrest'],
                    'interest_id' => $count,
                    'fk_package_id' => $package_id,
                    'fk_user_id' => $user_id,
                        )
                );
            }
        } else {
            $update = $wpdb->insert(
                    'interests', array(
                'interests' => $interest['intrest'],
                'interest_id' => $count,
                'fk_package_id' => $package_id,
                'fk_user_id' => $user_id,
                    )
            );
        }
    }
    if ($update != 1) {
        echo '<span class="text-danger interest_msg1">not Saved successfully....</span>';
    } else {
        echo '<span class="text-success interest_msg1"> Saved successfully....</span>';
    }
    die;
}

/* End Ajax call for Interests  */


/* Ajax call for call for References  */
add_action('wp_ajax_nopriv_save_references', 'save_references_callback');
add_action('wp_ajax_save_references', 'save_references_callback');

function save_references_callback() {

    global $wpdb;
    $user_id = $_POST['user_id'];
    $package_id = $_POST['package_id'];
    $studentreferences = $_POST['studentreferences'];
    $studentreferences = stripslashes_deep($studentreferences);
    $count = 0;
    foreach ($studentreferences as $reference) {
        $reference = json_decode($reference, TRUE);
        $count++;
        if ($_POST['is_submit'] == 1) {
            if ($reference['r_id'] != '') {
                $update = $wpdb->update(
                        'references', array(
                    'details' => $reference['reference'],
                    'reference_id' => $count,
                    'fk_package_id' => $package_id,
                    'fk_user_id' => $user_id,
                        ), array(
                    'pk_reference_id' => $reference['r_id']
                        )
                );
                $update = 1;
            } else {
                $update = $wpdb->insert(
                        'references', array(
                    'details' => $reference['reference'],
                    'reference_id' => $count,
                    'fk_package_id' => $package_id,
                    'fk_user_id' => $user_id,
                        )
                );
            }
        } else {
            $update = $wpdb->insert(
                    'references', array(
                'details' => $reference['reference'],
                'reference_id' => $count,
                'fk_package_id' => $package_id,
                'fk_user_id' => $user_id,
                    )
            );
        }
    }
    if ($update != 1) {
        echo '<span class="text-danger references_msg1">not Saved successfully....</span>';
    } else {
        echo '<span class="text-success references_msg1"> Saved successfully....</span>';
    }
    die;
}

/* End Ajax call for References  */


/* Ajax call for call for Projest  */
add_action('wp_ajax_nopriv_save_project', 'save_project_callback');
add_action('wp_ajax_save_project', 'save_project_callback');

function save_project_callback() {

    global $wpdb;
    $user_id = $_POST['user_id'];
    $package_id = $_POST['package_id'];
    $projects = $_POST['projects'];
    $projects = stripslashes_deep($projects);
    $count = 0;
    foreach ($projects as $project) {
        $count++;
        $project = json_decode($project, TRUE);
        $p_id = $project['p_id'];
        if ($_POST['is_submit'] == 1) {
            if ($p_id != '') {
                if ($project['original'] != 'undefined' && $project['upload'] != 'undefined' && $project['original'] != '' && $project['upload'] != '') {
                    $update = $wpdb->update(
                            'projects', array(
                        'project_title' => $project['name'],
                        'background' => $project['background'],
                        'objective' => $project['objective'],
                        'execution' => $project['execution'],
                        'results' => $project['results'],
                        'original_name' => $project['original'],
                        'file_input' => $project['upload'],
                        'project_id' => $count,
                        'fk_package_id' => $package_id,
                        'fk_user_id' => $user_id,
                            ), array(
                        'pk_project_id' => $p_id,
                            )
                    );
                } else {
                    $update = $wpdb->update(
                            'projects', array(
                        'project_title' => $project['name'],
                        'background' => $project['background'],
                        'objective' => $project['objective'],
                        'execution' => $project['execution'],
                        'results' => $project['results'],
                        'project_id' => $count,
                        'fk_package_id' => $package_id,
                        'fk_user_id' => $user_id,
                            ), array(
                        'pk_project_id' => $p_id,
                            )
                    );
                }
                $update = 1;
            } else {
                if ($project['original'] != 'undefined' && $project['upload'] != 'undefined' && $project['original'] != '' && $project['upload'] != '') {
                    $update = $wpdb->insert(
                            'projects', array(
                        'project_title' => $project['name'],
                        'background' => $project['background'],
                        'objective' => $project['objective'],
                        'execution' => $project['execution'],
                        'results' => $project['results'],
                        'original_name' => $project['original'],
                        'file_input' => $project['upload'],
                        'project_id' => $count,
                        'fk_package_id' => $package_id,
                        'fk_user_id' => $user_id,
                            )
                    );
                } else {
                    $update = $wpdb->insert(
                            'projects', array(
                        'project_title' => $project['name'],
                        'background' => $project['background'],
                        'objective' => $project['objective'],
                        'execution' => $project['execution'],
                        'results' => $project['results'],
                        'project_id' => $count,
                        'fk_package_id' => $package_id,
                        'fk_user_id' => $user_id,
                            )
                    );
                }
            }
        } else {
            if ($project['original'] != 'undefined' && $project['upload'] != 'undefined' && $project['original'] != '' && $project['upload'] != '') {
                $update = $wpdb->insert(
                        'projects', array(
                    'project_title' => $project['name'],
                    'background' => $project['background'],
                    'objective' => $project['objective'],
                    'execution' => $project['execution'],
                    'results' => $project['results'],
                    'original_name' => $project['original'],
                    'file_input' => $project['upload'],
                    'project_id' => $count,
                    'fk_package_id' => $package_id,
                    'fk_user_id' => $user_id,
                        )
                );
            } else {
                $update = $wpdb->insert(
                        'projects', array(
                    'project_title' => $project['name'],
                    'background' => $project['background'],
                    'objective' => $project['objective'],
                    'execution' => $project['execution'],
                    'results' => $project['results'],
                    'original_name' => $project['original'],
                    'file_input' => $project['upload'],
                    'project_id' => $count,
                    'fk_package_id' => $package_id,
                    'fk_user_id' => $user_id,
                        )
                );
            }
        }
    }
    if ($update != 1) {
        echo '<span class="text-danger project_msg1">not Saved successfully....</span>';
    } else {
        echo '<span class="text-success project_msg1"> Saved successfully....</span>';
    }
    die;
}

/* End Ajax call for Project  */

/* Ajax call for call for Experiance  */
add_action('wp_ajax_nopriv_save_experience', 'save_experience_callback');
add_action('wp_ajax_save_experience', 'save_experience_callback');

function save_experience_callback() {

    global $wpdb;
    $user_id = $_POST['user_id'];
    $package_id = $_POST['package_id'];
    $experiences = $_POST['experience'];
    $experiences = stripslashes_deep($experiences);
    $count = 0;
    foreach ($experiences as $experience) {
        $count++;
        $experience = json_decode($experience, TRUE);
        if ($_POST['is_submit'] == 1) {
            if ($experience['w_id'] != '') {
                $update = $wpdb->update(
                        'work_experience', array(
                    'title' => $experience['title'],
                    'company' => $experience['company'],
                    'city' => $experience['city'],
                    'state' => $experience['state'],
                    'years' => $experience['years'],
                    'description' => $experience['description'],
                    'experience_id' => $count,
                    'fk_package_id' => $package_id,
                    'fk_user_id' => $user_id,
                        ), array(
                    'pk_workexp_id' => $experience['w_id']
                        )
                );
                $update = 1;
            } else {
                $update = $wpdb->insert(
                        'work_experience', array(
                    'title' => $experience['title'],
                    'company' => $experience['company'],
                    'city' => $experience['city'],
                    'state' => $experience['state'],
                    'years' => $experience['years'],
                    'description' => $experience['description'],
                    'experience_id' => $count,
                    'fk_package_id' => $package_id,
                    'fk_user_id' => $user_id,
                        )
                );
            }
        } else {
            $update = $wpdb->insert(
                    'work_experience', array(
                'title' => $experience['title'],
                'company' => $experience['company'],
                'city' => $experience['city'],
                'state' => $experience['state'],
                'years' => $experience['years'],
                'description' => $experience['description'],
                'experience_id' => $count,
                'fk_package_id' => $package_id,
                'fk_user_id' => $user_id,
                    )
            );
        }
    }
    if ($update == 0) {
        echo '<span class="text-danger work_msg1">not Saved successfully....</span>';
    } else {
        echo '<span class="text-success work_msg1"> Saved successfully....</span>';
    }
    die;
}

/* End Ajax call for Experiance  */

function showTiming($time) {
    $time = time() - $time; // to get the time since that moment
    $time = ($time < 1) ? 1 : $time;
    $tokens = array(
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit)
            continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's ago' : ' ago');
    }
}

/* Ajax call for call for Experiance  */
add_action('wp_ajax_nopriv_check_notifications', 'check_notifications_callback');
add_action('wp_ajax_check_notifications', 'check_notifications_callback');

function check_notifications_callback() {
    $user_id = $_POST['user_id'];

    global $wpdb;
    $notifications_table = $wpdb->prefix . 'notifications';

    $update = $wpdb->update(
            $notifications_table, array(
        'is_view' => 1
            ), array('recipient_id' => $user_id)
    );

    die(0);
}

/* Ajax call for  Personal Informational  */
add_action('wp_ajax_nopriv_save_resume_info', 'save_resume_info_callback');
add_action('wp_ajax_save_resume_info', 'save_resume_info_callback');


/* Ajax call for  Personal Informational  */
add_action('wp_ajax_nopriv_save_resume_info', 'save_resume_info_callback');
add_action('wp_ajax_save_resume_info', 'save_resume_info_callback');

function save_resume_info_callback() {
    global $wpdb;
    $currentworkflowstatus = $_POST['currentstatus'];
    $user_id = $_POST['user_id'];
    $package_id = $_POST['package_id'];
    $student_info = get_userdata($user_id);
    $currentuser_id = $_POST['currentuser_id'];
    $reviewer_id = $_POST['reviewer_id'];
    $status = $_POST['is_submit'];
    $goals = $_POST['goals'];
    $workflow_status = $_POST['workflow_status'];
    $update = $wpdb->update(
            'wp_pmpro_membership_orders', array(
        'goals' => $goals,
        'is_submit' => $status,
        'workflow_status' => $workflow_status
            ), array('id' => $package_id)
    );

    if ($currentworkflowstatus == 5) {
        $smsg = "updated resume";
    } else {
        $smsg = "submited resume";
    }
    $user_info = get_userdata($reviewer_id);
    $to = $user_info->user_email;
    $subject = 'New updates From  ' . $student_info->user_login . ' on Resume';
    $msg = 'Student ' . $student_info->first_name . ' updated changes.<br/>';
    $msg .= 'Message:' . $student_info->first_name . ' ' . $student_info->last_name . ' ' . $smsg . ' <br/>';
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: Ocresume <mike@OCresume.net.com>' . "\r\n";
    wp_mail($to, $subject, $msg, $headers);
    $insert = $wpdb->insert(
            'wp_notifications', array(
        'datetime' => date('Y-m-d, h:i:s'),
        'recipient_id' => $reviewer_id,
        'sender_id' => $user_id,
        'notification' => $student_info->first_name . ' ' . $student_info->last_name . ' ' . $smsg . '',
        'package_id' => $package_id,
        'action' => '',
        'is_view' => 0
            )
    );

    if ($insert != 1) {
        echo '<span class="text-danger info_msg1">not Saved successfully....</span>';
    } else {
        echo '<span class="text-success info_msg1"> Saved successfully....</span>';
    }
    die;

    if ($update) {
        echo '<span class="text-danger info_msg1"> Information Saved successfully....</span>';
    } else {
        echo '<span class="text-success info_msg1"> Information not Saved successfully....</span>';
    }
    die;
}

/* Ajax call for Save Comments  */
add_action('wp_ajax_nopriv_save_comment', 'save_comment_callback');
add_action('wp_ajax_save_comment', 'save_comment_callback');

function save_comment_callback() {

    global $wpdb;
    $user_id = $_POST['user_id'];
    $package_id = $_POST['package_id'];
    $comment = $_POST['comment'];
    $currentuser_id = $_POST['currentuser_id'];
    $studentinfo = $_POST['reviewer_id'];
    $user_info = get_userdata($user_id);
    $reviewer_info = get_userdata($currentuser_id);

    $insert = $wpdb->insert(
            'comments', array(
        'package_id' => $package_id,
        'sender_id' => $currentuser_id,
        'recipient_id' => $user_id,
        'comment' => $comment,
        'create_date' => date('Y-m-d, h:i:s')
            )
    );

//Send mail of Comment to student
    $user_info = get_userdata($user_id);
    $reviewer_info = get_userdata($currentuser_id);
    $to = $user_info->user_email;
    $subject = 'New Comment From ' . $reviewer_info->first_name . ' ' . $reviewer_info->last_name . ' on your Resume';
    $msg = 'Reviewer ' . $reviewer_info->first_name . ' ' . $reviewer_info->last_name . ' commented on your resume.<br/>';
    $msg .= 'Comment: ' . $comment . '<br/>';
    $msg .= 'Click here for login ' . get_permalink(83);
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: Ocresume <mike@OCresume.net.com>' . "\r\n";
    wp_mail($to, $subject, $msg, $headers);

//Add Notification to comment Receiver
    $table_notifications = $wpdb->prefix . 'notifications';
    $wpdb->insert(
            $table_notifications, array(
        'datetime' => date('Y-m-d, h:i:s'),
        'recipient_id' => $user_id,
        'sender_id' => $currentuser_id,
        'notification' => 'Reviewer ' . $reviewer_info->first_name . ' ' . $reviewer_info->last_name . ' commented on your resume.',
        'package_id' => $package_id,
        'action' => '',
        'is_view' => 0
            )
    );


//Add History of Reviewer for commented on resume
    $table_history = $wpdb->prefix . 'history';
    $wpdb->insert(
            $table_history, array(
        'datetime' => date('Y-m-d, h:i:s'),
        'reviewer_id' => $currentuser_id,
        'history' => $reviewer_info->first_name . ' ' . $reviewer_info->last_name . ' commented on  ' . $user_info->first_name . ' ' . $user_info->last_name . '  Resume',
            )
    );

    if ($insert != 1) {
        echo '<span class="text-danger comment_msg">not Saved successfully....</span>';
    } else {
        echo '<span class="text-success comment_msg"> Saved successfully....</span>';
    }
    die;
}

/* End Ajax for Save Comments   */





/* Ajax call for Student Save Comments  */
add_action('wp_ajax_nopriv_save_student_comment', 'save_student_comment_callback');
add_action('wp_ajax_save_student_comment', 'save_student_comment_callback');

function save_student_comment_callback() {
    global $wpdb;
    $user_id = $_POST['user_id'];
    $package_id = $_POST['package_id'];
    $comment = $_POST['comment'];
    $currentuser_id = $_POST['currentuser_id'];
    $reviewer_id = $_POST['reviewer_id'];

    $insert = $wpdb->insert(
            'comments', array(
        'package_id' => $package_id,
        'sender_id' => $currentuser_id,
        'recipient_id' => $reviewer_id,
        'comment' => $comment,
        'create_date' => date('Y-m-d, h:i:s')
            )
    );

//Send mail of Comment to comment Receiver
    $user_info = get_userdata($reviewer_id);
    $student_info = get_userdata($currentuser_id);
    $to = $user_info->user_email;
    $subject = 'New Comment From ' . $student_info->first_name . ' ' . $student_info->last_name . ' on Resume';
    $msg = 'Student ' . $student_info->first_name . ' ' . $student_info->last_name . ' commented on resume.<br/>';
    $msg .= 'Comment: ' . $comment . '<br/>';
    $msg .= 'Click here for login ' . get_permalink(83);
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: Ocresume <mike@OCresume.net.com>' . "\r\n";
    wp_mail($to, $subject, $msg, $headers);


//Add Notification to comment reviewer
    $table_notifications = $wpdb->prefix . 'notifications';
    $wpdb->insert(
            $table_notifications, array(
        'datetime' => date('Y-m-d, h:i:s'),
        'recipient_id' => $reviewer_id,
        'sender_id' => $currentuser_id,
        'notification' => 'Student ' . $student_info->first_name . ' ' . $student_info->last_name . ' commented on resume.',
        'package_id' => $package_id,
        'action' => '',
        'is_view' => 0
            )
    );
    if ($insert != 1) {
        echo '<span class="text-danger comment_msg">not Saved successfully....</span>';
    } else {
        echo '<span class="text-success comment_msg"> Saved successfully....</span>';
    }
    die;
}

/* End Ajax for Save Comments   */


/* Ajax call for Send Return Resume  */
add_action('wp_ajax_nopriv_send_return', 'send_return_callback');
add_action('wp_ajax_send_return', 'send_return_callback');

function send_return_callback() {

    global $wpdb;
    $user_id = $_POST['user_id'];
    $package_id = $_POST['package_id'];
    $comment = $_POST['comment'];
    $currentuser_id = $_POST['currentuser_id'];

//Save Comment
    $insert = $wpdb->insert(
            'comments', array(
        'package_id' => $package_id,
        'sender_id' => $currentuser_id,
        'recipient_id' => $user_id,
        'comment' => $comment,
        'create_date' => date('Y-m-d, h:i:s')
            )
    );

//Update Package Status
    $update = $wpdb->update(
            'wp_pmpro_membership_orders', array(
        'workflow_status' => '5',
            ), array('id' => $package_id)
    );


    $user_info = get_userdata($user_id);
    $reviewer_info = get_userdata($currentuser_id);

//Send mail of Return resume to Student
    $to = $user_info->user_email;
    $subject = $reviewer_info->first_name . ' ' . $reviewer_info->last_name . ' returned your resume';
    $msg = $reviewer_info->first_name . ' ' . $reviewer_info->last_name . ' returned your resume<br/>';
    $msg .= 'Click here for login ' . get_permalink(83);
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: Ocresume <mike@OCresume.net.com>' . "\r\n";
    wp_mail($to, $subject, $msg, $headers);


//Send mail of Comment to Student
    $subject = 'New Comment From ' . $reviewer_info->first_name . ' ' . $reviewer_info->last_name . ' on your Resume';
    $msg = 'Reviewer ' . $reviewer_info->first_name . ' ' . $reviewer_info->last_name . ' commented on your resume.<br/>';
    $msg .= 'Comment: ' . $comment . '<br/>';
    $msg .= 'Click here for login ' . get_permalink(83);
    wp_mail($to, $subject, $msg, $headers);

//Add Notification of comment to student
    $table_notifications = $wpdb->prefix . 'notifications';
    $wpdb->insert(
            $table_notifications, array(
        'datetime' => date('Y-m-d, h:i:s'),
        'recipient_id' => $user_id,
        'sender_id' => $currentuser_id,
        'notification' => 'Reviewer ' . $reviewer_info->first_name . ' ' . $reviewer_info->last_name . ' commented on your resume.',
        'package_id' => $package_id,
        'action' => '',
        'is_view' => 0
            )
    );

//Add Notification to Student for return resume
    $table_notifications = $wpdb->prefix . 'notifications';
    $wpdb->insert(
            $table_notifications, array(
        'datetime' => date('Y-m-d, h:i:s'),
        'recipient_id' => $user_id,
        'sender_id' => $currentuser_id,
        'notification' => $reviewer_info->first_name . ' ' . $reviewer_info->last_name . '  returned your resume',
        'package_id' => $package_id,
        'action' => '',
        'is_view' => 0
            )
    );

//Add History of Reviewer for return resume
    $table_history = $wpdb->prefix . 'history';
    $wpdb->insert(
            $table_history, array(
        'datetime' => date('Y-m-d, h:i:s'),
        'reviewer_id' => $currentuser_id,
        'history' => $reviewer_info->first_name . ' ' . $reviewer_info->last_name . ' returned ' . $user_info->first_name . ' ' . $user_info->last_name . ' resume',
            )
    );

//Add History of Reviewer for commented on resume
    $table_history = $wpdb->prefix . 'history';
    $wpdb->insert(
            $table_history, array(
        'datetime' => date('Y-m-d, h:i:s'),
        'reviewer_id' => $currentuser_id,
        'history' => $reviewer_info->first_name . ' ' . $reviewer_info->last_name . ' commented on  ' . $user_info->first_name . ' ' . $user_info->last_name . '  Resume',
            )
    );

    if ($update != 1) {
        echo '<span class="text-danger comment_msg">not Saved successfully....</span>';
    } else {
        echo '<span class="text-success comment_msg"> Saved successfully....</span>';
    }
    die;
}

/* End Ajax for Send Return Resume  */


// add custom scripts to the options panel

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() {
    ?>

    <script type="text/javascript">
        jQuery(document).ready(function () {
            //------------Disable chechboxes on ready -----------//
            Checkpackages();

            //------------Disable chechboxes on change -----------//
            jQuery('#section-sel_package .checkbox').change(function () {
                Checkpackages();
            });

            //--------Function to check packages and disable/enable packages ----------//
            function Checkpackages() {
                var count = 0;
                jQuery("#section-sel_package ").find(".checkbox:checked").each(function () {
                    count++;
                });
                jQuery("#section-sel_package ").find(".checkbox").each(function () {
                    if (count >= 4) {
                        if (jQuery(this).prop('checked') != true) {
                            jQuery(this).attr('disabled', true);
                        }
                    } else {
                        jQuery(this).removeAttr("disabled");
                    }
                });
            }
        });
    </script>

    <?php
}

function fiu_upload_file() {

    $uploadFileName = $_FILES['file']['name'];
    if (isset($uploadFileName) && !empty($uploadFileName)) {
        $extension = pathinfo($uploadFileName, PATHINFO_EXTENSION);
        $tutorphotoname = "file_" . uniqid(rand(a, z), true) . '.' . $extension;
        $uploaddir = $_SERVER['DOCUMENT_ROOT'] . "/test/wp-content/uploads/projects/";
        $check_filetype = wp_check_filetype($tutorphotoname);
        $uploadfile = $uploaddir . $tutorphotoname;

        $moved = move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
        if ($moved && !isset($moved['error'])) {
            $data = array('original_name' => $uploadFileName, 'upload_name' => $tutorphotoname);
            echo json_encode($data);
        }
    }
    exit();
}

add_action('wp_ajax_fiu_upload_file', 'fiu_upload_file');
add_action('wp_ajax_nopriv_fiu_upload_file', 'fiu_upload_file');

/* Ajax call for Assign Resume Category */
add_action('wp_ajax_nopriv_assign_resume_category', 'assign_resume_category_callback');
add_action('wp_ajax_assign_resume_category', 'assign_resume_category_callback');

function assign_resume_category_callback() {
    global $wpdb;
    $cat_id = $_POST['cat_id'];
    $package_id = $_POST['package_id'];

    $update = $wpdb->update(
            'wp_pmpro_membership_orders', array('resume_cat_id' => $cat_id), array('id' => $package_id)
    );

    if ($update == False) {
        echo '<span class="text-success assign_msg1">Assigned successfully....</span>';
    } else if ($update != 1) {
        echo '<span class="text-danger assign_msg1"> Not Assigned</span>';
    } else {
        echo '<span class="text-success assign_msg1">Assigned successfully....</span>';
    }
    die;
}

/* End Ajax call for Resume Category */

/* Custom post type (faculty) */
add_action('init', 'register_faculty_post');

function register_faculty_post() {
    $labels = array(
        'name' => _x('faculty', 'Post Type General Name', 'oc'),
        'singular_name' => _x('faculty', 'Post Type Singular Name', 'oc'),
        'menu_name' => __('Faculty', 'oc'),
        'name_admin_bar' => __('Post Type', 'oc'),
        'archives' => __('Item Archives', 'oc'),
        'parent_item_colon' => __('Parent Item:', 'oc'),
        'all_items' => __('All Items', 'oc'),
        'add_new_item' => __('Add New Item', 'oc'),
        'add_new' => __('Add New', 'oc'),
        'new_item' => __('New Item', 'oc'),
        'edit_item' => __('Edit Item', 'oc'),
        'update_item' => __('Update Item', 'oc'),
        'view_item' => __('View Item', 'oc'),
        'search_items' => __('Search Item', 'oc'),
        'not_found' => __('Not found', 'oc'),
        'not_found_in_trash' => __('Not found in Trash', 'oc'),
        'featured_image' => __('Featured Image', 'oc'),
        'set_featured_image' => __('Set featured image', 'oc'),
        'remove_featured_image' => __('Remove featured image', 'oc'),
        'use_featured_image' => __('Use as featured image', 'oc'),
        'insert_into_item' => __('Insert into item', 'oc'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'oc'),
        'items_list' => __('Items list', 'oc'),
        'items_list_navigation' => __('Items list navigation', 'oc'),
        'filter_items_list' => __('Filter items list', 'oc'),
    );
    $args = array(
        'label' => __('faculty', 'oc'),
        'description' => __('Post Type Description', 'oc'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'publicly_queryable' => true,
        'capability_type' => 'page',
    );
    register_post_type('faculty', $args);
    flush_rewrite_rules();
}

/* Ajax call for Student support  */
add_action('wp_ajax_nopriv_send_student_support', 'send_student_support_callback');
add_action('wp_ajax_send_student_support', 'send_student_support_callback');

function send_student_support_callback() {

    global $wpdb;

    $user_id = $_POST['user_id'];
    $adminid = $_POST['adminid'];
    $packagename = $_POST['ssubject'];
    $supportmessage = $_POST['message'];
    $semail = $_POST['semail'];
    $studentname = $_POST['sname'];
    $sstatus = $_POST['supportstatus'];
    $adminemail = $_POST['adminemail'];
    $supportresult = $wpdb->get_results("SELECT * FROM wp_student_support WHERE sender_id = '$user_id' ");
    if (!empty($supportresult)) {
        $uniquenumber = $supportresult[0]->unique_number;
        $uniquekey = $supportresult[0]->unique_key;
    } else {
        $uniquenumber = $user_id;
        $uniquekey = 'OCS' . $uniquenumber;
    }
    $insert = $wpdb->insert(
            'wp_student_support', array(
        'receiver_id' => $adminid,
        'sender_id' => $user_id,
        'subject' => $packagename,
        'message' => $supportmessage,
        'support_status' => $sstatus,
        'unique_key' => $uniquekey,
        'unique_number' => $uniquenumber,
        'create_date' => date('Y-m-d, h:i:s')
            )
    );
//Send mail of Comment to student

    $student_info = get_userdata($user_id);
    // $to = $adminemail;
    $to = 'wadesolomon@yahoo.com';
    $subject = 'Query on ' . $packagename . ' ' . $student_info->first_name . ' ' . $student_info->last_name;
    $msg = 'Student ' . $student_info->first_name . ' ' . $student_info->last_name . 'has query on resume.<br/>';
    $msg .= 'Email: ' . $semail . '<br/>';
    $msg .= 'Query: ' . $supportmessage . '<br/>';
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    wp_mail($to, $subject, $msg, $headers);

    if ($insert != 1) {
        echo '<span class="text-danger support_msg">not Saved successfully....</span>';
    } else {
        echo '<span class="text-success support_msg"> Saved successfully....</span>';
    }
    die;
}

/* End Ajax for Save Comments   */

//Call Funtion to  sent mail to student on 7 day perioud
if (!wp_next_scheduled('my_scheduls_hook')) {
    wp_schedule_event(time(), 'daily', 'my_scheduls_hook');
}

add_action('my_scheduls_hook', 'my_scheduls_function');

function my_scheduls_function() {

    global $wpdb;
    $current_date = strtotime(date('Y-m-d'));
    $orders = $wpdb->get_results("SELECT * FROM $wpdb->pmpro_membership_orders WHERE is_submit != 1 ");
    foreach ($orders as $order) {
        $purchase_date = date("Y-m-d", strtotime($order->timestamp));
        $start = strtotime($purchase_date);
        $diff = $current_date - $start;
        $day = round($diff / 86400);
        if ($day % 7 == 0) {

            $user_info = get_userdata($order->user_id);
            $to = $user_info->user_email;

            $subject = 'Please Enter your Resume Detail';
            $msg = 'Please Enter your Resume Detail <br/>';
            $msg .= 'Click here for login ' . get_permalink(83);
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: Ocresume <mike@OCresume.net.com>' . "\r\n";

            wp_mail($to, $subject, $msg, $headers);
        }
    }
}

/* Ajax call for  Delete Project  */
add_action('wp_ajax_nopriv_delete_project', 'delete_project_callback');
add_action('wp_ajax_delete_project', 'delete_project_callback');

function delete_project_callback() {

    global $wpdb;
    $project_id = $_POST['project_id'];
    $delete = $wpdb->delete('projects', array('pk_project_id' => $project_id));
    echo $delete;
    die;
}

/* End Ajax call for Delete Project  */


/* Ajax call for  Delete work Experience  */
add_action('wp_ajax_nopriv_delete_work', 'delete_work_callback');
add_action('wp_ajax_delete_work', 'delete_work_callback');

function delete_work_callback() {

    global $wpdb;
    $work_id = $_POST['work_id'];
    $delete = $wpdb->delete('work_experience', array('pk_workexp_id' => $work_id));
    echo $delete;
    die;
}

/* End Ajax call for Delete work Experience  */

/* Ajax call for  Delete Skills  */
add_action('wp_ajax_nopriv_delete_skill', 'delete_skill_callback');
add_action('wp_ajax_delete_skill', 'delete_skill_callback');

function delete_skill_callback() {

    global $wpdb;
    $skill_id = $_POST['skill_id'];
    $delete = $wpdb->delete('skills', array('pk_skill_id' => $skill_id));
    echo $delete;
    die;
}

/* End Ajax call for Delete Skills  */

/* Ajax call for  Delete Course  */
add_action('wp_ajax_nopriv_delete_cources', 'delete_cources_callback');
add_action('wp_ajax_delete_cources', 'delete_cources_callback');

function delete_cources_callback() {

    global $wpdb;
    $course_id = $_POST['course_id'];
    $delete = $wpdb->delete('course', array('pk_course_id' => $course_id));
    echo $delete;
    die;
}

/* End Ajax call for Delete Course  */

/* Ajax call for  Delete Software  */
add_action('wp_ajax_nopriv_delete_sw', 'delete_sw_callback');
add_action('wp_ajax_delete_sw', 'delete_sw_callback');

function delete_sw_callback() {

    global $wpdb;
    $sw_id = $_POST['sw_id'];
    $delete = $wpdb->delete('knowledge_software', array('pk_software_id' => $sw_id));
    echo $delete;
    die;
}

/* End Ajax call for Delete Software  */


/* Ajax call for  Delete Honors  */
add_action('wp_ajax_nopriv_delete_honors', 'delete_honors_callback');
add_action('wp_ajax_delete_honors', 'delete_honors_callback');

function delete_honors_callback() {

    global $wpdb;
    $honor_id = $_POST['honor_id'];
    $delete = $wpdb->delete('honor', array('pk_honor_id' => $honor_id));
    echo $delete;
    die;
}

/* End Ajax call for Delete Honors  */

/* Ajax call for  Delete Activity  */
add_action('wp_ajax_nopriv_delete_activity', 'delete_activity_callback');
add_action('wp_ajax_delete_activity', 'delete_activity_callback');

function delete_activity_callback() {

    global $wpdb;
    $activity_id = $_POST['activity_id'];
    $delete = $wpdb->delete('activity', array('pk_activity_id' => $activity_id));
    echo $delete;
    die;
}

/* End Ajax call for Delete Activity  */

/* Ajax call for  Delete Intrest  */
add_action('wp_ajax_nopriv_delete_intrest', 'delete_intrest_callback');
add_action('wp_ajax_delete_intrest', 'delete_intrest_callback');

function delete_intrest_callback() {

    global $wpdb;
    $interest_id = $_POST['interest_id'];
    $delete = $wpdb->delete('interests', array('pk_interest_id' => $interest_id));
    echo $delete;
    die;
}

/* End Ajax call for Delete Reference  */

/* Ajax call for  Delete Intrest  */
add_action('wp_ajax_nopriv_delete_ref', 'delete_ref_callback');
add_action('wp_ajax_delete_ref', 'delete_ref_callback');

function delete_ref_callback() {

    global $wpdb;
    $ref_id = $_POST['ref_id'];
    $delete = $wpdb->delete('references', array('pk_reference_id' => $ref_id));
    echo $delete;
    die;
}

/* End Ajax call for Delete Reference  */

//-----------Display Comment on Faculty ----------------//

function mytheme_comment($comment, $args, $depth) {
    if ('div' === $args['style']) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'li';
        $add_below = 'div-comment';
    }
    ?>
    <<?php echo $tag ?> <?php comment_class(empty($args['has_children']) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
    <?php if ('div' != $args['style']) : ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
        <?php endif; ?>
        <div class="comment-author vcard">
            <?php if ($args['avatar_size'] != 0) echo get_avatar($comment, $args['avatar_size']); ?>
            <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()); ?>
        </div>
        <?php if ($comment->comment_approved == '0') : ?>
            <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.'); ?></em>
            <br />
        <?php endif; ?>

        <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>">
                <?php
                printf(__('%1$s at %2$s'), get_comment_date(), get_comment_time());
                ?></a><?php edit_comment_link(__('(Edit)'), '  ', '');
                ?>
            <?php comment_reply_link(array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
        </div>    

        <?php comment_text(); ?>
        <?php if ('div' != $args['style']) : ?>
        </div>
    <?php endif; ?>
    <?php
}

function filter_plugin_updates($value) {
    unset($value->response['paid-memberships-pro/paid-memberships-pro.php']);
    return $value;
}

add_filter('site_transient_update_plugins', 'filter_plugin_updates');


/* Custom post type (resumes) */
add_action('init', 'register_resumes_post');

function register_resumes_post() {
    $labels = array(
        'name' => _x('resume', 'Post Type General Name', 'oc'),
        'singular_name' => _x('resume', 'Post Type Singular Name', 'oc'),
        'menu_name' => __('Resume', 'oc'),
        'name_admin_bar' => __('Post Type', 'oc'),
        'archives' => __('Item Archives', 'oc'),
        'parent_item_colon' => __('Parent Item:', 'oc'),
        'all_items' => __('All Items', 'oc'),
        'add_new_item' => __('Add New Item', 'oc'),
        'add_new' => __('Add New', 'oc'),
        'new_item' => __('New Item', 'oc'),
        'edit_item' => __('Edit Item', 'oc'),
        'update_item' => __('Update Item', 'oc'),
        'view_item' => __('View Item', 'oc'),
        'search_items' => __('Search Item', 'oc'),
        'not_found' => __('Not found', 'oc'),
        'not_found_in_trash' => __('Not found in Trash', 'oc'),
        'featured_image' => __('Featured Image', 'oc'),
        'set_featured_image' => __('Set featured image', 'oc'),
        'remove_featured_image' => __('Remove featured image', 'oc'),
        'use_featured_image' => __('Use as featured image', 'oc'),
        'insert_into_item' => __('Insert into item', 'oc'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'oc'),
        'items_list' => __('Items list', 'oc'),
        'items_list_navigation' => __('Items list navigation', 'oc'),
        'filter_items_list' => __('Filter items list', 'oc'),
    );
    $args = array(
        'label' => __('resume', 'oc'),
        'description' => __('Post Type Description', 'oc'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'publicly_queryable' => true,
        'capability_type' => 'page',
    );
    register_post_type('resums', $args);
    flush_rewrite_rules();
}

// Register custom taxonomy for resumes custom post type
function resume_taxonomy() {
    register_taxonomy(
            'resume_cat', 'resums', array(
        'hierarchical' => true,
        'label' => 'Category',
        'query_var' => true,
        'rewrite' => array(
            'slug' => 'resume_cat',
            'with_front' => false
        )
            )
    );
}

add_action('init', 'resume_taxonomy');

// End resumes Type
//add class to prev/next post link
add_filter('next_posts_link_attributes', 'next_posts_link_attributes');
add_filter('previous_posts_link_attributes', 'previous_posts_link_attributes');

function next_posts_link_attributes() {
    return 'class="next_post"';
}

function previous_posts_link_attributes() {
    return 'class="prev_post"';
}

//custom serch Pagination
function serch_pagination($paged = '', $pages = '', $range = 2) {
    $showitems = ($range * 2) + 1;
    if (1 != $pages) {
        if ($paged > 1 && $showitems < $pages)
            echo "<a href='" . urldecode(get_pagenum_link($paged - 1)) . "' class='prev_post'><- Older posts</a>";
        if ($paged < $pages && $showitems < $pages)
            echo "<a href='" . get_pagenum_link($paged + 1) . "'  class='next_post'>Newer posts -></a></li>";
    }
}
