<?php
/*
  Template Name: Forgot Password
 */
get_header();
if (is_user_logged_in()) {
    echo '<script>window.location.href="' . site_url() . '"</script>';
}
?>
<div class="layout-978">
    <div class="forgotpw">
        <div class="container">
            <div class="forgot_pass">
                <div class="page_title">
                    <h1 class="vc_custom_heading gen_heading text-center"> Forget Password</h1>
                </div>
                <form class="" id="forget_pw" method="post" action="">

                    <input type="hidden" name="hdnf" id="hdnf" value="<?php echo admin_url('admin-ajax.php'); ?>">
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="text" name="email" id="email" placeholder="Email*" class="txtbox input">
                            <span id="email_error"></span>
                        </div>
                    </div>
                    <div class="button_div">
                        <input type="button" name="Submit" value="Submit" id="forgate_sub" class="btn" onclick="submit_forget_pw()">
                    </div>

                </form>
                <span id="forget_pw_status" style="color:red; font-size:12px; font-style:italic; display:none;"></span>
                <?php if (!is_user_logged_in()) { ?>
                    <div class="login_now">
                        <a id="login_url" href="<?php echo the_permalink(83); ?>" class="reg_now">Login Now</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div> 
<?php get_footer(); ?>
