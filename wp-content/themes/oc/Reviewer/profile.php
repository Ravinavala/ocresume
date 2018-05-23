<?php
/*
  Template Name: Reviewer Profile
 */
?>
<?php if (!is_user_logged_in()): ?>
    <script>window.location.href = "<?php echo site_url(); ?>";</script>
<?php endif; ?>
<?php get_header('dashboard'); ?>
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title"><?php the_title(); ?></h1>
<div class="student_profile">
    <div class="girl_profile men_profile">
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
        <h4><?php echo $current_user->user_login; ?></h4>
        <span><?php echo $current_user->roles[0]; ?></span>
    </div>
</div>  
<div class="profile_account">
    <div class="portlet light bordered profile">
        <div class="portlet-title tabbable-line profile_border">
            <div class="caption">
                <i class="icon-bubbles font-dark hide"></i>
                <span class="caption-subject font-dark bold">Profile Account</span>
            </div>
            <ul class="nav nav-tabs responsive-tabs">
                <li class="active">
                    <a href="#portlet_comments_1" data-toggle="tab" aria-expanded="true"> Personal Info </a>
                </li>
                <li class="">
                    <a href="#portlet_comments_2" data-toggle="tab" aria-expanded="false"> Change Photo </a>
                </li>
                <li class="">
                    <a href="#portlet_comments_3" data-toggle="tab" aria-expanded="false"> Change Password </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="portlet-body">
        <div class="tab-content">
            <div class="tab-pane active" id="portlet_comments_1">                
                <form method="post" id="profile_acc" >
                    <div class="profile_information">
                        <div class="content">
                            <label>First Name</label>
                            <input type="text" class="name" value="<?php echo $current_user->user_firstname; ?>" id="fname" name="fname" maxlength="50" >
                        </div>
                        <div class="content">
                            <label>Last Name</label>
                            <input type="text" class="name" value="<?php echo $current_user->user_lastname; ?>" id="lname" name="lname"  maxlength="50">
                        </div>
                        <div class="content last_contact">
                            <label>Contact Number</label>
                            <input type="text"   maxlength="50" class="name" value="<?php echo esc_attr(get_the_author_meta('phone', $current_user->ID)); ?>" id="phone" name="phone">
                        </div>
                        <div class="content email_content">
                            <label>Email </label>
                            <input  maxlength="50" type="email" class="name" value="<?php echo $current_user->user_email; ?>" disabled="" id="email" name="email1">
                            <!--                            <button class="chng_btn">Change</button>-->
                        </div>
                        <div class="content acc_msg"></div>
                        <div class="save_cancle">
                            <input type="submit" class="save" value="Save changes">
                            <input type="reset" class="cancel" value="Cancel">
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane" id="portlet_comments_2">
                <div class="change_photo">
                    <form class="frmUpload" method="post" enctype="multipart/form-data">
                        <div class="no_img">   
                            <?php
                            $profile_pic = get_user_meta($current_user->ID, 'profile_image', TRUE);
                            if ($profile_pic) {
                                ?>
                                <img class="output" src="<?php echo $profile_pic; ?>" alt="" id="output"/>
                            <?php } else { ?>
                                <img id="output" src="<?php echo get_template_directory_uri(); ?>/assets/layouts/layout/img/no_img.png" class="image-responsive output" alt="image">
                            <?php } ?>
                        </div>
                        <div class="select_img">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <span class="btn btn-default btn-file">
                                    <span>Select image</span>
                                    <input type="file" name="profile_img" id="profile_img" onchange="allvalidateimageFile(this.value, 'profile_img')" >
                                </span>
                                <span class="fileinput-filename"></span><span class="fileinput-new"></span>
                            </div>
                        </div>

                        <div class="content pic_msg"></div>
                        <div class="save_cancle submit">
                            <input type="submit" class="save" value="Submit" id="pro_pic">
                            <input type="reset" class="cancel" value="Cancel" style="display: none;">
                        </div>
                    </form>
                </div>
            </div>
            <div class="tab-pane" id="portlet_comments_3">
                <form method="post" id="profile_pass" autocomplete="off">
                    <input type="password" id="prevent_autofill" style="display:none"/>
                    <div class="profile_information password_profile">
                        <div class="content password">
                            <label>Current Password</label>
                            <input type="password" class="name" name="pass" id="pass"  maxlength="50" autocomplete="off">
                        </div>
                        <div class="content password">
                            <label>New Password</label>
                            <input type="password" class="name" name="new_pass" id="new_pass"  maxlength="50">
                        </div>
                        <div class="content password conform">
                            <label>Confirm Password</label>
                            <input type="password" class="name" name="conf_pass" id="conf_pass"  maxlength="50">
                        </div>
                        <div class="content pass_msg"></div>
                        <div class="save_cancle">
                            <input type="submit" class="save" value="Change Password">
                            <input type="reset" class="cancel" value="Cancel" >
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="contact_info">
    <div class="caption">
        <i class="icon-bubbles font-dark hide"></i>
        <span class="caption-subject font-dark bold">Contact Info</span>
    </div>
    <div class="contect_information">
        <div class="mail">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/layouts/layout/img/mail_img.png" alt=""/>
            <a href='mailto:<?php echo $current_user->user_email; ?>'><?php echo $current_user->user_email; ?></a>
        </div>
        <div class="phone">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/layouts/layout/img/phn_img.png" alt=""/>
            <a href='tel:<?php echo esc_attr(get_the_author_meta('phone', $current_user->ID)); ?>'><?php echo esc_attr(get_the_author_meta('phone', $current_user->ID)); ?></a>
        </div>
    </div>
</div>
</div>
</div>                  
<!-- END CONTENT -->
<!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->
<?php get_footer('dashboard'); ?>