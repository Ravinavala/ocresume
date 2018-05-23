<?php
/*
 * Template Name: Home
 */
get_header();
?>
<?php
if (isset($_REQUEST['id']))
    $id = $_REQUEST['id'];
{
    ?>
    <input type="hidden" name="shdn" id="shdn" value="<?php echo $id; ?>">
<?php } ?>
<section>
    <div class="banner" style="background: url('<?php echo get_field('banner_image'); ?>'); background-repeat: no-repeat;background-size: 100% auto;background-attachment: fixed;">
        <div class="banner_content">
            <h1><?php echo get_field('banner_text'); ?></h1>
            <a href="<?php the_permalink(269); ?>" class="btn_a"><?php echo get_field('banner_button_text'); ?></a>
        </div>
    </div>
</section>
<section id="home_packages_section" class="packages_section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="resume_title">
                    <h3><?php echo get_field('resume_writing_options'); ?></h3>
                </div>
            </div>
        </div>

        <div class="row packages_info_signups">
<?php echo do_shortcode('[pmpro_levels]'); ?>
        </div>
    </div>
</section>

<section class="resume_work_bg">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 resume_work_corporate">
                <div class="resume_work">
                    <h2><?php echo get_field('resume_title'); ?></h2>
                    <h3><?php echo get_field('resume_sub_title'); ?></h3>
                    <p><?php echo get_field('resume_text'); ?> </p>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="resume_work_right_img">
                    <img src="<?php echo get_field('resume_image'); ?>"  alt="image" class="img-responsive"/>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="tips_for_job_bg">
    <div class="container">
        <div class="resume_title">
            <h3><?php echo get_field('tips_for_getting_the_job_you_want'); ?> </h3>
            <div class="row">
                <div class="col-sm-12">
                    <div class="banner_sliders">
                        <div class="flexslider" id="flexslider_patners_bottom">
                            <ul class="slides">
                                <?php
                                $args1 = array('post_type' => 'faculty', 'posts_per_page' => -1, 'order' => 'ASC',);
                                $loop1 = new WP_Query($args1);
                                while ($loop1->have_posts()) : $loop1->the_post();
                                    ?>
                                    <li>
                                        <div class="left_slide_info">
    <?php the_post_thumbnail(array(263, 249), array('class' => 'img-responsive')); ?>
                                        </div>
                                        <div class="right_slide_info">
                                            <h4>
                                                <?php
                                                $len = strlen(get_the_title());
                                                if ($len > 50):
                                                    echo substr(get_the_title(), 0, 45) . "...";
                                                else:
                                                    echo get_the_title();
                                                endif;
                                                ?>
                                            </h4>
                                            <?php
                                            $excerpt = get_the_excerpt();

                                            $excerpt = substr($excerpt, 0, 150);
                                            ?>
                                            <p><?php echo $excerpt; ?></p>
                                            <a href="<?php the_permalink(); ?>">Read More</a>
                                        </div>
                                    </li>
                                    <?php
                                endwhile;
                                wp_reset_query();
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="happy_clients_section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="flexslider happy_client_slider" id="happy_client_slider">
                    <div class="resume_title">
                        <h3><?php echo get_field('our_happy_clients'); ?></h3>
                        <div class="before_img_slide">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/before_img_slider.png" alt="" />
                        </div>
                    </div>
                    <ul class="slides">
                        <?php
                        $args = array('post_type' => 'happyclient', 'posts_per_page' => -1, 'order' => 'ASC');
                        $loop = new WP_Query($args);
                        while ($loop->have_posts()) : $loop->the_post();
                            ?>
                            <li>
                                <div class="happy_client_content">
                                    <?php echo '<p>' . get_the_content() . '</p>'; ?>
    <?php echo '<h5>' . get_the_title() . '</h5>'; ?>
                                </div>
                            </li>
                            <?php
                        endwhile;
                        wp_reset_query();
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="get_resume_section">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h3><?php echo get_field('get_your_resume_today_title'); ?></h3>
            </div>
            <div class="col-sm-6">
                <div class="image-right-resume">
                    <img src="<?php echo get_field('get_your_resume_today_image'); ?>"  alt="" class="image-mobile-resume img-responsive"/>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="contact_form" style="background:<?php echo get_field('contact_section_background'); ?>">
    <div class="container">
        <div class="bg_img">
            <div class="">
                <div class="col-sm-12">
                    <div class="resume_title">
                        <h3><?php echo get_field('contact_title'); ?></h3>
                    </div>
                    <div class="row">
<?php echo do_shortcode('[contact-form-7 id="208" title="Home Contact"]'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>