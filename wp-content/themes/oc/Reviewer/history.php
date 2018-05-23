<?php
/*
  Template Name: Reviewer History
 */
?>
<?php if (!is_user_logged_in()): ?>
    <script>window.location.href = "<?php echo site_url(); ?>";</script>
<?php endif; ?>
<?php get_header('dashboard'); ?>
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title"> <?php the_title(); ?> </h1>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<?php
$current_id = $current_user->ID;
if ($_GET['view']):
    $limit = $_GET['view'];
else:
    $limit = 10;
endif;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$offset = ( $paged - 1 ) * $limit;
$total = $wpdb->get_var("SELECT COUNT(id) FROM wp_history WHERE reviewer_id = '$current_id'");
$num_of_pages = ceil($total / $limit);
$history = $wpdb->get_results("SELECT * FROM wp_history WHERE reviewer_id = '$current_id' ORDER BY  id DESC LIMIT $offset, $limit");
?>
<form id="resume">
    <div class="notification_table">
        <?php if ($history) { ?>
            <table id="notification">
                <?php foreach ($history as $histry) { ?>
                    <tr>
                        <td class="table_contain"><a href="javascript:void(0);"><?php echo $histry->history; ?></a></td>
                        <td class="notificatin_table_td"><?php echo date("d/m/Y", strtotime($histry->datetime)); ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } ?>
    </div>
    <div class="table-pagination">                            
        <div class="view_select">
            <?php if ($history) { ?>
                <span>Page</span>
                <?php
                if (function_exists(custom_pagination)) {
                    custom_pagination($paged, $num_of_pages, "");
                }
                ?>
                <span>of <?php echo $num_of_pages; ?> | View</span>
                <select name="view" id="view">
                    <option <?php if ($_GET['view'] == 10) echo 'selected'; ?> value="10">10</option>
                    <?php if ($total > 10) { ?>
                        <option <?php if ($_GET['view'] == 20) echo 'selected'; ?> value="20">20</option>
                    <?php } ?>
                    <?php if ($total > 20) { ?>
                        <option <?php if ($_GET['view'] == 30) echo 'selected'; ?> value="30">30</option>
                    <?php } ?>
                    <?php if ($total > 30) { ?>
                        <option <?php if ($_GET['view'] == 40) echo 'selected'; ?> value="40">40</option>
                    <?php } ?>
                </select>
                <span>records | Found total <?php echo $total; ?> records</span>
            <?php }else { ?>
                <span>No records Found</span>
            <?php } ?>
        </div>
    </div>   
</form>
</div>                                        
</div>
</div>                  
<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php get_footer('dashboard'); ?>