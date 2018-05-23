<footer>
    <div class="footer_main">
        <div class="container">
            <div class="row">
                <div class="footer_top">
                    <?php if (of_get_option('location')) { ?>
                        <div class="col-sm-4">
                            <div class="icon_dec location ">
                                <p><?php echo of_get_option('location'); ?></p>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (of_get_option('mail_address')) { ?>
                        <div class="col-sm-4">
                            <div class="icon_dec email">
                                <p><a href="mailto:<?php echo of_get_option('mail_address'); ?>"><?php echo of_get_option('mail_address'); ?></a></p>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (of_get_option('phone_number')) { ?>
                        <div class="col-sm-4">
                            <div class="icon_dec phone">
                                <p><a href="tel:<?php echo of_get_option('phone_number'); ?>"><?php echo of_get_option('phone_number'); ?></a></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="footer_bottom">
                <div class="footer_bottom_left">
                    <p class="copyright">
                        <?php
                        echo of_get_option('copyright_text');
                        if (of_get_option('copylink_url')) {
                            echo ' <a href="' . of_get_option('copylink_url') . '" class="copyright">' . of_get_option('copylink_txt') . '</a>';
                        }
                        ?>
                    </p>
                </div>
                <?php if (of_get_option('twitter_link')) { ?>
                    <div class="footer_bottom_right"><a href="<?php echo of_get_option('twitter_link'); ?>" target="_blank" class="follow"><?php echo of_get_option('twitter_text'); ?></a> </div>
                <?php } ?>
            </div>
        </div>
    </div>
</footer>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-ui.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-1.12.4.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.flexslider.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/custom.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/global/scripts/customb.js" type="text/javascript"></script>
<?php wp_footer(); ?>
</body>
</html>