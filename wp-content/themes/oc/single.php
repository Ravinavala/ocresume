<?php get_header(); ?>
<section class="faculty_section resume_section">
    <div class="container">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                ?>
                <div class="row">
                    <div class="col-sm-12">
                        <h3><?php the_title(); ?></h3>                   
                        <p> Posted On <?php the_date(); ?> </p>
                        <?php the_content(); ?>
                    </div>
                </div>
                <?php
            endwhile;
        endif;
        ?>           
    </div>
</section>    
<?php get_footer(); ?>