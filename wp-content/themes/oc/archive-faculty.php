<?php
/**
 * The template for displaying archive pages
 */
get_header();
?>
<section class="archivs_page faculty_section">
    <div class="container">
        <div class="row">
            <div class="col-sm-3 right">
                <?php get_sidebar('faculty'); ?>
            </div>
            <?php if (have_posts()) : ?>
                <header class="page-header">
                    <?php
                    the_archive_title('<h1 class="page-title">', '</h1>');
                    the_archive_description('<div class="taxonomy-description">', '</div>');
                    ?>
                </header><!-- .page-header -->    
                <div class="banner_sliders1">
                    <?php
                    // Start the Loop.
                    while (have_posts()) : the_post();
                        ?>
                        <div class="col-sm-9">
                            <div class="left_slide_info">
                                <?php the_post_thumbnail(); ?>
                            </div>
                            <div class="right_slide_info">
                                <h4>
                                    <?php
                                    $len = strlen(get_the_title());
                                    if ($len > 50):
                                        echo substr(get_the_title(), 0, 45) . "...";
                                    else:
                                        echo get_the_title();
                                    endif;
                                    ?>
                                </h4>
                                <?php the_excerpt(); ?>
                                <a href="<?php the_permalink(); ?>">Read More</a>
                            </div>
                        </div>
                        <?php
                    endwhile;

                    // Previous/next page navigation.
                    the_posts_pagination(array(
                        'prev_text' => __('Previous page', 'twentyfifteen'),
                        'next_text' => __('Next page', 'twentyfifteen'),
                        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'twentyfifteen') . ' </span>',
                    ));

                else :
                    echo '<p>No Post Founds..</p>';
                endif;
                ?>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>