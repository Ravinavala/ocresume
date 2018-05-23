<?php get_header(); ?>
<section class="faculty_section">
    <div class="container">

        <?php while (have_posts()) : the_post(); ?>
            <div class="row">
                <div class="col-sm-3 right">
                    <?php get_sidebar('faculty'); ?>
                </div>
                <div class="col-sm-9">
                    <h3><?php the_title(); ?></h3>
                    <?php //the_post_thumbnail(); ?>

                    <p> Posted On <?php the_date(); ?> </p>
                     

                    <?php the_content(); ?>
                    <footer class="entry-footer">
                        Bookmark the <a href="<?php the_permalink(); ?>" rel="bookmark">permalink</a>.
                    </footer>
                    <div class="singl_post_pagination">
                        <div class="newer">
                            <?php next_post_link('%link', 'Next &rarr;') ?>
                        </div> 
                        <div class="older">
                            <?php previous_post_link('%link', '&larr; Previous') ?>
                        </div>
                    </div>
                </div>                
            </div>
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
        <?php endwhile; ?>
    </div>      
</section>
<?php get_footer(); ?>