<?php
/*
  Template Name: Contact Us
 */
?>
<?php get_header(); ?>
<section class="packages_section">
    <div class="container">  
        <div class="page_title">
            <h1><?php the_title();?></h1>
        </div>
        <div class="contact_main">
        <?php while (have_posts()) : the_post(); ?>
            <?php echo the_content(); ?>
            <div class="icon_dec location1 ">
                <div class="group-form">
                    <div class="row">
                        <div class="col-sm-4">
                            <h4>Contact Info</h4>
                            
                             <div class="form_row">
                                <div class="icon_dec location">
                                    <p><?php echo of_get_option('location'); ?></p>
                                </div>
                            </div>                                                    
                            <div class="form_row">
                                <div class="icon_dec email">
                                    <p><a href="mailto:<?php echo of_get_option('mail_address'); ?>"><?php echo of_get_option('mail_address'); ?></a></p>
                                </div>
                            </div>
                            <div class="form_row">
                                <div class="icon_dec phone">
                                    <p><a href="tel:<?php echo of_get_option('phone_number'); ?>"><?php echo of_get_option('phone_number'); ?></a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <?php echo do_shortcode("[contact-form-7 id='15' title='Contact form']"); ?>
                        </div>
                    </div>
                </div>
            </div>
        
        
    <?php endwhile; ?>  
    </div>
        </div>
</section>  
<?php get_footer(); ?>