<?php
/*
  Template Name: Student Notifications
 */
?>
<?php if (!is_user_logged_in()): ?>
    <script>window.location.href = "<?php echo site_url(); ?>";</script>
<?php endif; ?>
<?php get_header('dashboard'); ?>                        
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title"><?php echo get_the_title(); ?></h1>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
if ($_GET['view']):
    $limit = $_GET['view'];
else:
    $limit = 10;
endif;
$offset = ( $paged - 1 ) * $limit;

global $wpdb;

$notifications_table = $wpdb->prefix . 'notifications';

$total = $wpdb->get_var("select count(*) from $notifications_table where recipient_id = $current_user->ID");
$num_of_pages = ceil($total / $limit);

$get_pending_notifications = $wpdb->get_results("select * from $notifications_table where recipient_id = $current_user->ID  ORDER BY ID DESC LIMIT $offset, $limit");
?>
<form id="resume">
    <div class="notification_table">
        <table id="notification">
            <tbody>
                <?php
                foreach ($get_pending_notifications as $notification) {
                    $notification_time = $notification->datetime;
                    $time = strtotime($notification_time);
                    ?>
                    <tr>
                        <td class="table_contain"><a href="#"><?php echo $notification->notification; ?></a></td>
                        <td class="notificatin_table_td"><?php echo showTiming($time); ?></td>
                    </tr>
                    <?php
                }
                ?>	
            </tbody>
        </table>
    </div>
    <div class="table-pagination">                            
        <div class="view_select">
            <span>Page</span>
            <?php
            if (function_exists("custom_pagination")) {
                custom_pagination($paged, $num_of_pages, 0);
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
        </div>
    </div>                        
</form>
<?php get_footer('dashboard'); ?>