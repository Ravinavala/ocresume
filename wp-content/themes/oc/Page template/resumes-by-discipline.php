<?php
/*
  Template Name: Resumes By Discipline
 */
?>
<?php get_header(); ?>
<section class="resume_section">            
    <div class="container">                
        <div class="page_title">
            <h1><?php the_title(); ?></h1>
        </div>
        <div class="list_cat">
            <?php
            $cat_list = $wpdb->get_results("SELECT * FROM wp_resume_category");
            if ($cat_list) {
                foreach ($cat_list as $cat) {
                    ?>
                    <a href="<?php the_permalink(277); ?>?id=<?php echo $cat->category_id; ?>" ><?php echo $cat->category_name; ?></a>                                            
                    <?php
                }
            }
            ?>  
        </div>
    </div>
</section>
<?php get_footer(); ?>