<?php
/*
  Template Name: Resumes
 */
?>
<?php if (!$_REQUEST['id']): ?>
    <script>window.location.href = "<?php echo site_url(); ?>";</script>
<?php endif; ?>
<?php get_header(); ?>
<?php
global $wpdb;
$cat_id = $_REQUEST['id'];
$cat_name = $wpdb->get_row("SELECT * FROM wp_resume_category WHERE category_id = '$cat_id' LIMIT 1");
$resumes = $wpdb->get_results("SELECT * FROM $wpdb->pmpro_membership_orders WHERE resume_cat_id = '$cat_id' AND workflow_status = 6");
?>
<section class="resume_section">            
    <div class="container"> 
        <div class="page_title">
            <h1><?php echo $cat_name->category_name; ?></h1>
        </div>
        <div class="list_cat">
            <?php
            foreach ($resumes as $resume) {
                ?>
                <a href="<?php the_permalink(245); ?>?id=<?php echo $resume->id; ?>" ><?php echo $resume->name; ?></a>                                            
                <?php
            }
            ?> 
            <?php
            $args = array(
                'post_type' => 'resums',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'resume_cat',
                        'field' => 'name',
                        'terms' => $cat_name->category_name
                    )
                )
            );
            $site_resumes = new WP_Query($args);
            while ($site_resumes->have_posts()) : $site_resumes->the_post();
                ?>
                <a href="<?php the_permalink(); ?>" ><?php the_title(); ?></a>                                            
                <?php
            endwhile;
            ?> 
        </div>
    </div>
</section>
<?php get_footer(); ?>