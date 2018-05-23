<?php
/* Template Name: Reset user Password */
get_header();
if (is_user_logged_in()) {
    echo '<script>window.location.href="' . site_url() . '"</script>';
}
$string = $_REQUEST['string'];
$encrypt_method = "AES-256-CBC";
$secret_key = 'This is my secret key';
$secret_iv = 'This is my secret iv';
// hash
$key = hash('sha256', $secret_key);
// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
$iv = substr(hash('sha256', $secret_iv), 0, 16);
$decrypted_string = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
if (email_exists($decrypted_string)) {
    $user = get_user_by('email', $decrypted_string);
    $user_id = $user->ID;
    $email = $user->user_email;
    $username = $user->user_login;
    $pass = md5($user->user_pass);
    ?>
    <section class="packages_section login_section_main">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page_title">
                        <h1 class="vc_custom_heading gen_heading text-center"> <?php the_title(); ?></h1>
                    </div>
                    <div class="row packages_info_signups login_page_main reset_form">
                    <div class="layout-978">
                        <div class="forgotpw">
                            <form class="" id="reset_pw" method="post" action="">
                                <input type="hidden" id="login_url" value="<?php echo the_permalink(83); ?>" />
                                <input type="hidden" name="email" id="email" value="<?php echo $email; ?>" />
                                <input type="hidden" name="oldpass" id="oldpass" value="<?php echo $pass; ?>" />
                                <input type="hidden" name="uname" id="uname" value="<?php echo $username; ?>" />
                                <div class="col-sm-12">
                                    <input type="password" name="password" id="password" placeholder="Password*" class="txtbox">
                                    <span id="password_error" style="color:red; font-size:14px; font-weight: normal; font-family: 'Montserrat-Light';"></span>
                                </div>
                                <div class="col-sm-12">
                                    <input type="password" name="conf_password" id="conf_password" placeholder="Confirmed Password*" class="txtbox">
                                    <span id="conf_password_error" style="color:red; font-size:14px; font-weight: normal; font-family: 'Montserrat-Light';"></span>
                                </div>
                                <div class="button_div reset_btn">
                                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>" />
                                    <input type="button" name="Submit" value="Submit" class="btn" onclick="submit_reset_pw()">
                                </div>
                            </form>
                            <span id="reset_pw_status" style="color:red; font-size:12px; font-style:italic; display:none;"></span>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </section>
    <?php
}
?>
<?php get_footer(); ?>
