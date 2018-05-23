<?php
/*
  Template Name: login page
 */
?>
<?php get_header(); ?>
<?php $current_user = wp_get_current_user(); ?>


<?php
if (is_user_logged_in()) {
    if ($current_user->roles[0] == 'student') {
        ?>
        <script>window.location.href = "<?php echo site_url(); ?>/student/dashboard/";</script>
    <?php } ?>
    <?php
    if ($current_user->roles[0] == 'reviewer') {
        ?>  
        <script>window.location.href = "<?php echo site_url(); ?>/reviewer/dashboard/";</script>
    <?php } ?>
    <?php
    if ($current_user->roles[0] == 'administrator') {
        ?>  
        <script>window.location.href = "<?php echo site_url(); ?>/wp-admin/";</script>
    <?php } ?>


<?php } ?>

<section class="packages_section login_section_main">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <?php while (have_posts()) : the_post(); ?>
                    <div class="page_title">
                        <h1 class="vc_custom_heading gen_heading text-center"> <?php the_title(); ?></h1>
                    </div>
                    <div class="row packages_info_signups login_page_main">
                        <?php
                        $prev_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
                        if (!is_user_logged_in()) {
                            $args = array(
                                'id_username' => 'user',
                                'id_password' => 'pass',
                                'redirect' => $prev_url,
                                'remember' => true,
                                'value_remember' => false
                            );
                            wp_login_form($args);
                            $login = (isset($_GET['login']) ) ? $_GET['login'] : 0;
                            if ($login === "failed") {
                                echo '<span class="login-msg text-danger">Invalid username or password.</span>';
                            } elseif ($login === "empty") {
                                echo '<span class="login-msg text-danger"> Username or Password is empty.</span>';
                            } elseif ($login === "false") {
                                echo '<span class="login-msg text-danger">You are logged out.</span';
                            }
                            echo '<a href="' . get_permalink(190) . '">Forget Password</a>';
                        }
                    endwhile;
                    ?>

                </div> 
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>