<?php
/*
  Template Name: Comment
 */
?>
<?php if (!is_user_logged_in()): ?>
    <script>window.location.href = "<?php echo site_url(); ?>";</script>
<?php endif; ?>
<?php get_header('dashboard'); ?>
<h1 class="page-title"> <?php the_title(); ?></h1>
<div class="commentbox_section">
    <div class="profile_account">
        <div class="portlet light bordered profile">
            <div class="portlet-title tabbable-line profile_border">
                <div class="caption">
                    <i class="icon-bubbles font-dark hide"></i>
                    <span class="caption-subject font-dark bold">Comment Box</span>
                </div>
            </div>
        </div>
        <div class="portlet-body content_body">
            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            if ($_GET['view']):
                $limit = $_GET['view'];
            else:
                $limit = 20;
            endif;
            $offset = ( $paged - 1 ) * $limit;
            global $wpdb;
            $userid = $current_user->ID;
            $package = $_GET['id'];
            $total = $wpdb->get_var("SELECT count(ID) FROM comments WHERE package_id = '$package' ");
            $num_of_pages = ceil($total / $limit);
            $comments = $wpdb->get_results("SELECT * FROM comments WHERE package_id = '$package' ORDER BY ID DESC LIMIT  $offset, $limit ");
            ?>
            <?php
            if ($comments):
                foreach ($comments as $comment) {
                    if ($comment->sender_id == $current_user->ID) {
                        $chat_class = "chat_right";
                    } else {
                        $chat_class = "chat_left";
                    }
                    ?>
                    <div class="comment_box <?php echo $chat_class;
                    ?>">
                        <div class="chat_image">
                            <?php
                            $profile_pic = get_user_meta($comment->sender_id, 'profile_image', TRUE);
                            if ($profile_pic) {
                                ?>
                                <img src="<?php echo $profile_pic; ?>" alt="image" class="comment_img" />
                            <?php } else { ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/layouts/layout/img/noimg.jpg"  alt="image"  class="comment_img">
                            <?php } ?>
                        </div>
                        <div class="chat_text">
                            <p><?php echo $comment->comment; ?></p>
                            <span><?php echo date("H:iA F d, Y", strtotime($comment->create_date)); ?></span>
                        </div>
                    </div>
                    <?php
                } else:
                echo "<p>No Comments..</p>";
            endif;
            ?>

        </div>
    </div>
    <div class="table-pagination">                            
        <div class="view_select">
            <span>Page</span>
            <?php
            if (function_exists("custom_pagination")) {
                custom_pagination($paged, $num_of_pages, 0);
            }
            ?>
            
            <span>records | Found total <?php echo $total; ?> records</span>
        </div>
    </div>  
</div>


<?php get_footer('dashboard'); ?>