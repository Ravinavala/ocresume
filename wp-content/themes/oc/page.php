<?php get_header(); ?>
<section class="faculty_section confrim <?php if (get_the_ID() != 107) echo "resume_section"; ?>">
    <div class="container">   
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                the_content();
            endwhile;
        endif;
        ?>           
    </div>
</section>    
<?php get_footer(); ?>