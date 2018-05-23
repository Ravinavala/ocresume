<?php
/*
  Template Name:  settings
 */
?>
<?php
if (isset($_POST['search'])) {
    $profile = $_POST['profile'];
    $category = $_POST['category'];
    $package = $_POST['package'];
    $view = $_POST['view'];
    ?>
    <script>window.location.href = "<?php echo site_url() . '/wp-admin/admin.php?page=assign-category&profile=' . $profile . '&package=' . $package . '&category=' . $category . '&view=' . $view; ?>"</script>
    <?php
}

global $wpdb;
global $current_user;
$where = '';
$current_user = wp_get_current_user();
$current_id = $current_user->ID;
$paged = ($_GET['paged']) ? $_GET['paged'] : 1;
if ($_GET['view']):
    $limit = $_GET['view'];
else:
    $limit = 10;
endif;
$offset = ( $paged - 1 ) * $limit;

//----Searching -----//
if ($_GET['profile'] != '') {
    $where .= ' AND o.billing_name LIKE "%' . $_GET['profile'] . '%"';
}
if ($_GET['package'] != 0) {
    $where .= ' AND o.membership_id = ' . $_GET['package'];
}
if ($_GET['category']) {
    $where .= ' AND o.resume_cat_id = ' . $_GET['category'];
}

$total = $wpdb->get_var(
        "SELECT COUNT('o.id') " .
        "FROM $wpdb->pmpro_membership_orders AS o " .
        "WHERE o.workflow_status = 6 $where ORDER BY  o.id DESC"
);
$num_of_pages = ceil($total / $limit);
$orders = $wpdb->get_results(
        "SELECT * " .
        "FROM $wpdb->pmpro_membership_orders AS o " .
        "WHERE o.workflow_status = 6 $where ORDER BY  o.id DESC LIMIT $offset, $limit "
);
?>
<h1>Assign Resume Category</h1>
<form id="resume" method="post" action="#">
    <img src="<?php echo get_template_directory_uri(); ?>/images/loader.gif" style="display: none;"  id="loding"/>
    <input type="hidden" id="site_url" value="<?php echo site_url(); ?>" />
    <input type="hidden" id="admin_url" value="<?php echo admin_url('admin-ajax.php'); ?>" />
    <div class="students_resumes">
        <div class="table-pagination counts">
            <?php if ($orders) { ?>
                <div class="view_select">
                    <span>Page</span>
                    <?php
                    if (function_exists("pagination_new")) {
                        pagination_new($num_of_pages, 0);
                    }
                    ?>
                </div>
            <?php } ?>
        </div>

        <div class="dashboard_table">
            <table>
                <tr>
                    <th>Profile</th>
                    <th>Package</th>
                    <th>Resume Category</th>
                    <th></th>
                </tr>
                <tr>
                    <td><input name="profile" type="text" value="<?php echo $_GET['profile']; ?>"></td>                       
                    <td>
                        <select name="package">
                            <option value="0">Select...</option>
                            <?php
                            $package_list = $wpdb->get_results("SELECT * FROM wp_pmpro_membership_levels");
                            if ($package_list) {
                                foreach ($package_list as $package) {
                                    ?>
                                    <option value="<?php echo $package->id; ?>" <?php if ($_GET['package'] == $package->id) echo 'selected'; ?>><?php echo $package->name; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <select name="category">
                            <option value="0" >None</option>
                            <?php
                            $cat_list = $wpdb->get_results("SELECT * FROM wp_resume_category");
                            if ($cat_list) {
                                foreach ($cat_list as $cat) {
                                    ?>
                                    <option value="<?php echo $cat->category_id; ?>" <?php if ($_GET['category'] == $cat->category_id) echo 'selected'; ?>><?php echo $cat->category_name; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <input type="submit" value="Filter" name="search" class="lightblue"><br>
                        <input type="reset" value="Reset" class="lightred" id="asn_cat">
                    </td>
                </tr>
                <?php
                if ($orders) {
                    $flag = 0;
                    foreach ($orders as $order) {
                        $flag++;
                        ?>
                        <tr >
                            <td><?php echo $order->name; ?></td>
                            <td>
                                <?php
                                $packages = $wpdb->get_row("SELECT * FROM $wpdb->pmpro_membership_levels WHERE id = '$order->membership_id' LIMIT 1");
                                echo $packages->name;
                                ?>
                            </td>
                            <td>
                                <select name="assign_cat" class="assign_cat" id="order_<?php echo $order->id; ?>">
                                    <option value="0" >None</option>
                                    <?php
                                    $cat_list = $wpdb->get_results("SELECT * FROM wp_resume_category");
                                    if ($cat_list) {
                                        foreach ($cat_list as $cat) {
                                            ?>
                                            <option value="<?php echo $cat->category_id; ?>" <?php if ($order->resume_cat_id == $cat->category_id) echo 'selected'; ?>><?php echo $cat->category_name; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <?php if ($order->resume_cat_id == 0) { ?>
                                    <a  class="grey_btn" onclick="save_cat(<?php echo $order->id; ?>)">Save</a>
                                <?php } else { ?>
                                    <a  class="red_btn" onclick="save_cat(<?php echo $order->id; ?>)">Update</a>
                                <?php } ?>
                                <div id="assign_msg_<?php echo $order->id; ?>"></div>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="7">No record Found..</td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <?php if ($orders) { ?>
            <div class="table-pagination">
                <div class="view_select">
                    <?php
                    if ($paged == 1)
                        $start = 1;
                    else
                        $start = $limit * ($paged - 1) + 1;
                    $end = $limit * $paged;
                    if ($end >= $total)
                        $end = $total;
                    ?>
                    <span>Showing <?php echo $start; ?> to <?php echo $end; ?> of <?php echo $total; ?> entries</span>
                    <select name="view" id="resume_view">
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
                    <?php
                    if (function_exists("pagination")) {
                        pagination($num_of_pages, 6);
                    }
                    ?>
                </div>
            </div>
        <?php } ?>
    </div>
</form>
<?php

function pagination($pages = '', $range = 2) {

    $showitems = ($range * 2) + 1;

    global $paged;
    if (isset($_REQUEST['paged'])) {
        $paged = $_REQUEST['paged'];
    } else {
        $paged = 1;
    }

    if ($pages == '') {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if (!$pages) {
            $pages = 1;
        }
    }

    if (1 != $pages) {
        echo "<ul class='pagination'>";
        if ($paged > 1 && $showitems < $pages)
            echo "<li><a href='" . urldecode(get_pagenum_link($paged - 1)) . "'>&lsaquo;</a>";

        for ($i = 1; $i <= $pages; $i++) {
            if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems )) {
                echo ($paged == $i) ? "<li class='current'><span>" . $i . "</span></li>" : "<li><a href='" . urldecode(get_pagenum_link($i)) . "' class='inactive' >" . $i . "</a></li>";
            }
        }

        if ($paged < $pages && $showitems < $pages)
            echo "<li><a href='" . get_pagenum_link($paged + 1) . "'>&rsaquo;</a></li>";
        echo "</ul>\n";
    }
    else {
        echo '<ul class="pagination"><li class="page_content"><a href="#">1</a></li></ul>';
    }
}

function pagination_new($pages = '', $range = 2) {

    $showitems = ($range * 2) + 1;

    global $paged;
    if (isset($_REQUEST['paged'])) {
        $paged = $_REQUEST['paged'];
    } else {
        $paged = 1;
    }
    if ($pages == '') {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if (!$pages) {
            $pages = 1;
        }
    }
    if (1 != $pages) {
        echo "<ul class='pagination'>";
        if ($paged > 1 && $showitems < $pages)
            echo "<li class='prev_arrow'><a href='" . urldecode(get_pagenum_link($paged - 1)) . "'></a>";

        for ($i = 1; $i <= $pages; $i++) {
            if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems )) {
                echo ($paged == $i) ? "<li class='page_content'><span>" . $i . "</span></li>" : "";
            }
        }

        if ($paged < $pages && $showitems < $pages)
            echo "<li class='next_arrow'><a href='" . get_pagenum_link($paged + 1) . "'></a></li>";
        echo "</ul>\n";
    }
    else {
        echo '<ul class="pagination"><li class="page_content"><a href="#">1</a></li></ul>';
    }
}
