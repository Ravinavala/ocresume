<?php get_header(); ?>
<section class="faculty_section resume_section serch_section">
    <div class="container">

        <div class="row">
            <div class="col-sm-3 right">
                <?php get_sidebar('faculty'); ?>
            </div>
            <div class="col-sm-9">
                <?php
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $limit = 10;
                $offset = ( $paged - 1 ) * $limit;
                $total = $wpdb->get_var("SELECT COUNT('id') FROM $wpdb->pmpro_membership_orders WHERE workflow_status= 6 AND name LIKE '%" . $_GET['s'] . "%'");
                $num_of_pages = ceil($total / $limit);
                $resumes = $wpdb->get_results("SELECT * FROM $wpdb->pmpro_membership_orders WHERE workflow_status= 6 AND name LIKE '%" . $_GET['s'] . "%' LIMIT $offset, $limit");
                ?>
                <?php if (have_posts() || $resumes) { ?>
                    <h2>Search Results for '<?php echo get_search_query(); ?>'</h2> 
                    <?php
                    if ($resumes) {
                        foreach ($resumes as $resume) {
                            ?>
                            <h4 class="serch_title"><?php echo $resume->name; ?></h4>
                            <p class="post_text"> Posted On <?php echo date("F d, Y", strtotime($resume->timestamp)); ?> </p>
                            <?php
                            $html = $resume->name;
                            if ($resume->degree)
                                $html .= ', ' . $resume->degree;
                            if ($resume->school)
                                $html .= ', ' . $resume->school;
                            if ($resume->city):
                                $html .= ', ' . $resume->city;
                            endif;
                            if ($resume->graduation_date)
                                $html .= ', Graduation Date: ' . date("d F, Y", strtotime($resume->graduation_date));
                            if ($resume->linkedin):
                                $html .= ' <a target="_blank" href="' . $resume->linkedin . '" class="pdf_a">LinkedIn</a>';
                            endif;
                            if ($resume->phone)
                                $html .= ', Cell Phone: ' . $resume->phone;
                            if ($resume->email)
                                $html .= ', Email: ' . $resume->email;
                            if ($resume->endorsement)
                                $html .= ', Endorsement: ' . $resume->endorsement;
                            if ($resume->jobdescription)
                                $html .= ', ' . $resume->jobdescription;
                            if ($resume->goals)
                                $html .= ', Objective: ' . $resume->goals;
                            echo '<p>' . $html . '[...]</p>';
                            ?>
                            <a href="<?php the_permalink(245); ?>?id=<?php echo $resume->id; ?>" >Read More</a>                                            
                            <?php
                        }
                        ?>                            
                        <div class="search_pagination">
                            <?php
                            if (function_exists("serch_pagination")) {
                                serch_pagination($paged, $num_of_pages, 0);
                            }
                            ?>                
                        </div>
                        <?php
                    }
                    ?>
                    <?php while (have_posts()) : the_post(); ?>                       
<!--                        <h4 class="serch_title"><?php the_title(); ?></h4>
                        <p class="post_text"> Posted On <?php echo get_the_date(); ?> </p>		
                        <?php the_excerpt(); ?>
                        <a href="<?php esc_url(the_permalink()); ?>">Read More</a>
                    <?php endwhile; ?>
                    <div class="search_pagination">
                        <?php previous_posts_link('<- Older posts'); ?>  
                        <?php next_posts_link('Newer posts ->'); ?>
                    </div>-->
                <?php }else { ?>
                    <h2>0 results found for '<?php echo get_search_query(); ?></h2>
                <?php } ?>
            </div>
        </div>      
    </div>                  
</section>
<?php get_footer(); ?>