<?php
/*
  Template Name: Stay Informed
 */
?>
<?php get_header(); ?>
<section class="faculty_section">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <div class="row">               
                <div class="col-sm-9 stay_infodiv">
                    <h3><?php the_title(); ?></h3>
                    <!--Begin CTCT Sign-Up Form-->                    
                    <div class="ctct-embed-signup" style="font: 16px Helvetica Neue, Arial, sans-serif; font: 1rem Helvetica Neue, Arial, sans-serif; line-height: 1.5; -webkit-font-smoothing: antialiased;">
                        <div class="main_stay">
                            <span id="success_message" style="display:none;">
                                <div style="text-align:center;">Thanks for signing up!</div>
                            </span>
                            <form data-id="embedded_signup:form" class="ctct-custom-form Form" name="embedded_signup" method="POST" action="https://visitor2.constantcontact.com/api/signup">
                            <div class="stay_head">
                             <?php if (of_get_option('stayinformed_logo')) : ?>
                                        <img src="<?php echo of_get_option('stayinformed_logo'); ?>" alt="Logo"/> 
                                    <?php else : ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/stay_logo.png" alt="Logo"/> 
                                    <?php endif; ?>
                                <h2 style="margin:0;">Subscribe to never miss a post:</h2>       
                                </div>                        
                                <!-- The following code must be included to ensure your sign-up form works properly. -->
                                <input data-id="ca:input" type="hidden" name="ca" value="3fb1dfc6-7f44-4202-a4ff-cdfaacd495fb">
                                <input data-id="list:input" type="hidden" name="list" value="1531157462">
                                <input data-id="source:input" type="hidden" name="source" value="EFD">
                                <input data-id="required:input" type="hidden" name="required" value="list,email">
                                <input data-id="url:input" type="hidden" name="url" value="">
                                <p data-id="First Name:p" >
                                    <label data-id="First Name:label" data-name="first_name">Name:</label> 
                                    <input data-id="First Name:input" type="text" name="first_name" value="" maxlength="50" placeholder="Please introduce yourself"></p>
                                <p data-id="Email Address:p" >
                                    <label data-id="Email Address:label" data-name="email" class="ctct-form-required">Your email address:</label>
                                    <input data-id="Email Address:input" type="text" name="email" value="" maxlength="80" placeholder="How can we reach you?">
                                </p>
                                <button type="submit" class="Button ctct-button Button--block Button-secondary" data-enabled="enabled">Subscribe »</button>
                                <div><p class="ctct-form-footer">By submitting this form, you are granting: Lelli's of Auburn Hills, 885 N. Opdyke Road, Auburn Hills, Michigan, 48326, United States, http://www.lellisrestaurant.com permission to email you. You may unsubscribe via the link found at the bottom of every email.  (See our <a href="http://www.constantcontact.com/legal/privacy-statement" target="_blank">Email Privacy Policy</a> for details.) Emails are serviced by Constant Contact.</p></div>
                            </form> 
                        </div>
                    </div>
                    <script type='text/javascript'>
                        var localizedErrMap = {};
                        localizedErrMap['required'] = 'Please enter your email address.';
                        localizedErrMap['ca'] = 'An unexpected error occurred while attempting to send email.';
                        localizedErrMap['email'] = 'Please enter valid email address.';
                        localizedErrMap['birthday'] = 'Please enter birthday in MM/DD format.';
                        localizedErrMap['anniversary'] = 'Please enter anniversary in MM/DD/YYYY format.';
                        localizedErrMap['custom_date'] = 'Please enter this date in MM/DD/YYYY format.';
                        localizedErrMap['list'] = 'Please select at least one email list.';
                        localizedErrMap['generic'] = 'This field is invalid.';
                        localizedErrMap['shared'] = 'Sorry, we could not complete your sign-up. Please contact us to resolve this.';
                        localizedErrMap['state_mismatch'] = 'Mismatched State/Province and Country.';
                        localizedErrMap['state_province'] = 'Select a state/province';
                        localizedErrMap['selectcountry'] = 'Select a country';
                        var postURL = 'https://visitor2.constantcontact.com/api/signup';
                    </script>
                    <script type='text/javascript' src='https://static.ctctcdn.com/h/contacts-embedded-signup-assets/1.0.2/js/signup-form.js'></script>
                    <!--End CTCT Sign-Up Form-->
                </div> 
                 <div class="col-sm-3 right">
                    <?php get_sidebar('faculty'); ?>
                </div>               
            </div>
        <?php endwhile; ?>
    </div>   
</section>
<?php get_footer(); ?>