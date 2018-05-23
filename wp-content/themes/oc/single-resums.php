<?php get_header(); ?>
<section class="resume_section reviewer_resume_section	copy_resume">  
    <div class="container">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                ?>
                <div class="row">
                    <div class="col-sm-12">
                        <h1 class="resume_title entry-title"><?php the_title(); ?></h1>                                
                    </div>
                </div>
                <?php the_content(); ?>
    <div class="row">
                <div class="col-sm-12">
                    <?php
                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) {
                        comments_template();
                    }
                    ?>
                </div>
            </div>
                <?php
            endwhile;
        endif;
        ?>           
    </div>
</section>    
<?php get_footer(); ?>