<?php
global $current_user;
$current_user = wp_get_current_user();

global $wpdb;
$orders_table = $wpdb->prefix . 'pmpro_membership_orders';
$users_table = $wpdb->prefix . 'users';
$status_table = $wpdb->prefix . 'workflow_status';
?>	

<div class="student_resume_list">
    <span>Resume Listing</span>
</div>
<?php
$where = '';
$order = '';
$current_id = $current_user->ID;
$paged = ($_GET['paged']) ? $_GET['paged'] : 1;
if ($_GET['view']):
    $limit = $_GET['view'];
else:
    $limit = 10;
endif;
$offset = ( $paged - 1 ) * $limit; 

//----Sorting -----//
if ($_GET['sort'] != 0) {
    $sort = $_GET['sort'];
    if ($sort == 1)
        $order = 'ORDER BY  o.billing_name ASC';
    if ($sort == 2)
        $order = 'ORDER BY  o.billing_name DESC';
    if ($sort == 3)
        $order = 'ORDER BY  u.display_name ASC';
    if ($sort == 4)
        $order = 'ORDER BY  s.status_name ASC';
    if ($sort == 5)
        $order = 'ORDER BY  o.timestamp ASC';
    if ($sort == 6)
        $order = 'ORDER BY  o.job_status ASC';
    if ($sort == 7)
        $order = 'ORDER BY  o.membership_id ASC';
}

//----Searching -----//
if ($_GET['profile'] != '') {
    if ($where)
        $where .= ' AND o.billing_name LIKE "%' . $_GET['profile'] . '%"';
    else
        $where .= '  o.billing_name LIKE "%' . $_GET['profile'] . '%"';
}

if ($_GET['reviewer'] != ''|| $_GET['reviewer'] != 0) {
    if($_GET['reviewer'] == 'ua'){
     if ($where)
        $where .= ' AND o.is_assigned != 1';
    else
        $where .= '  o.is_assigned != 1';
    }else{
    if ($where)
        $where .= ' AND o.reviewer_id = "' . $_GET['reviewer'] . '"';
    else
        $where .= '  o.reviewer_id = "' . $_GET['reviewer'] . '"';
    }
}
if ($_GET['status'] != 0) {
    $status = $_GET['status'];
    if ($where)
        $where .= ' AND o.workflow_status = ' . $status;
    else
        $where .= '  o.workflow_status = ' . $status;
}
if ($_GET['range'] != 0) {
    if ($_GET['range'] == 1) {
        $date = date('Y-m-d');
        $pastdate = date('Y-m-d', strtotime('-7 days'));
        if ($where)
            $where .= ' AND (DATE(o.timestamp) = "' . $date . '" OR DATE(o.timestamp) >= "' . $pastdate . '") ';
        else
            $where .= '  (DATE(o.timestamp) = "' . $date . '" OR DATE(o.timestamp) >= "' . $pastdate . '") ';
    }
    if ($_GET['range'] == 2) {
        $date = date('Y-m-d', strtotime('-8 days'));
        $pastdate = date('Y-m-d', strtotime('-14 days'));
        if ($where)
            $where .= ' AND (DATE(o.timestamp) < "' . $date . '" AND DATE(o.timestamp) >= "' . $pastdate . '") ';
        else
            $where .= '  (DATE(o.timestamp) < "' . $date . '" AND DATE(o.timestamp) >= "' . $pastdate . '") ';
    }
    if ($_GET['range'] == 3) {
        $date = date('Y-m-d', strtotime('-15 days'));
        $pastdate = date('Y-m-d', strtotime('-21 days'));
        if ($where)
            $where .= ' AND (DATE(o.timestamp) < "' . $date . '" AND DATE(o.timestamp) >= "' . $pastdate . '") ';
        else
            $where .= '  (DATE(o.timestamp) < "' . $date . '" AND DATE(o.timestamp) >= "' . $pastdate . '") ';
    }
    if ($_GET['range'] == 4) {
        $date = date('Y-m-d', strtotime('-22 days'));
        $pastdate = date('Y-m-d', strtotime('-28 days'));
        if ($where)
            $where .= ' AND (DATE(o.timestamp) <"' . $date . '" AND DATE(o.timestamp) >= "' . $pastdate . '" )';
        else
            $where .= '  (DATE(o.timestamp) <"' . $date . '" AND DATE(o.timestamp) >= "' . $pastdate . '" )';
    }
    if ($_GET['range'] == 5) {
        $pastdate = date('Y-m-d', strtotime('-28 days'));
        if ($where)
            $where .= ' AND o.timestamp < "' . $pastdate . '" ';
        else
            $where .= '  o.timestamp < "' . $pastdate . '" ';
    }
}
if ($_GET['job'] != 0) {
    if ($_GET['job'] == 1) {
        if ($where)
            $where .= ' AND o.job_status = "None"';
        else
            $where .= '  o.job_status = "None"';
    } if ($_GET['job'] == 2) {
        if ($where)
            $where .= ' AND o.job_status = "Yes"';
        else
            $where .= '  o.job_status = "Yes"';
    }if ($_GET['job'] == 3) {
        if ($where)
            $where .= ' AND o.job_status = "No"';
        else
            $where .= '  o.job_status = "No"';
    }
}
if ($_GET['package'] != 0) {
    if ($where)
        $where .= ' AND o.membership_id = ' . $_GET['package'];
    else
        $where .= '  o.membership_id = ' . $_GET['package'];
}
if ($order == '') {
    $order = 'ORDER BY  o.id DESC';
}

if ($where)
    $query = "WHERE  $where $order ";
else
    $query = " $order ";

$total = $wpdb->get_var(
        "SELECT COUNT('o.id') " .
        "FROM $wpdb->pmpro_membership_orders AS o " .
        "LEFT JOIN $wpdb->users AS u ON o.reviewer_id = u.ID " .
        "LEFT JOIN wp_workflow_status AS s ON o.workflow_status = s.pk_status_id " .
        "$query"
);
$num_of_pages = ceil($total / $limit);
$orders = $wpdb->get_results(
        "SELECT * " .
        "FROM $wpdb->pmpro_membership_orders AS o " .
        "LEFT JOIN $wpdb->users AS u ON o.reviewer_id = u.ID " .
        "LEFT JOIN wp_workflow_status AS s ON o.workflow_status = s.pk_status_id " .
        "$query LIMIT $offset, $limit "
);

if (isset($_POST['search'])) {
    $sort = $_POST['sort'];
    $profile = $_POST['profile'];
    $reviewer = $_POST['reviewer'];
    $status = $_POST['status'];
    $range = $_POST['range'];
    $job = $_POST['job'];
    $package = $_POST['package'];
    $view = $_POST['view'];
    ?>
    <script>window.location.href = "<?php echo site_url() . '/wp-admin/admin.php?page=mt-top-level-handle-resume-listing&sort=' . $sort . '&profile=' . $profile . '&reviewer=' . $reviewer . '&status=' . $status . '&range=' . $range . '&job=' . $job . '&package=' . $package . '&view=' . $view; ?>"</script>
    <?php
} else if (isset($_POST['sort_btn'])) {
    $sort = $_POST['sort'];
    $profile = $_POST['profile'];
    $reviewer = $_POST['reviewer'];
    $status = $_POST['status'];
    $range = $_POST['range'];
    $job = $_POST['job'];
    $package = $_POST['package'];
    $view = $_POST['view'];
    ?>
    <script>window.location.href = "<?php echo site_url() . '/wp-admin/admin.php?page=mt-top-level-handle-resume-listing&sort=' . $sort . '&profile=' . $profile . '&reviewer=' . $reviewer . '&status=' . $status . '&range=' . $range . '&job=' . $job . '&package=' . $package . '&view=' . $view; ?>"</script>
    <?php
}
?>
<form id="resume" method="post" action="#">
    <input type="hidden" id="site_url" value="<?php echo site_url(); ?>" />
    <input type="hidden" id="admin_url" value="<?php echo admin_url('admin-ajax.php'); ?>" />
    <input type="hidden" id="currentuser_id" value="<?php echo $current_user->ID; ?>" />
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
        <div class="shorting">
            <label>Short By:</label>
            <select name="sort">
                <option value="0">All</option>
                <option value="1" <?php if ($sort == 1) echo 'selected'; ?>>Profile - Ascending</option>
                <option value="2" <?php if ($sort == 2) echo 'selected'; ?>>Profile - Descending</option>
                <option value="3" <?php if ($sort == 3) echo 'selected'; ?>>Reviewer </option>
                <option value="4" <?php if ($sort == 4) echo 'selected'; ?>>Status </option>
                <option value="5" <?php if ($sort == 5) echo 'selected'; ?>>Range </option>
                <option value="6" <?php if ($sort == 6) echo 'selected'; ?>>Received job </option>
                <option value="7" <?php if ($sort == 7) echo 'selected'; ?>>Package </option>
            </select>
            <input type="submit" value="Submit" name="sort_btn" class="red_btn">
        </div>
        <div class="dashboard_table">
            <table>
                <tr>
                    <th>Profile</th>
                    <th>Reviewer</th>
                    <th>Status</th>
                    <th>Range</th>
                    <th>Received job?</th>
                    <th>Package</th>
                    <th></th>
                </tr>
                <tr>
                    <td><input name="profile" type="text" value="<?php echo $_GET['profile']; ?>"></td>
                    <td> 
                        <select name="reviewer">                        
                            <option value="0">Select...</option>
                            <option value="ua" <?php if($_GET['reviewer'] == 'ua')echo 'selected'; ?>>Unassigned</option>
                            <?php
                            $blogusers = get_users('role=reviewer');
                            foreach ($blogusers as $user) {
                                ?> 
                                <option <?php if ($_GET['reviewer'] == $user->ID) echo 'selected'; ?> value="<?php echo $user->ID ?>"><?php echo $user->first_name . ' ' . $user->last_name; ?></option>
                            <?php } ?> 
                        </select>
                    </td>
                    <td>
                        <select name="status">
                            <option value="0" >Select...</option>
                            <?php
                            $status_list = $wpdb->get_results("SELECT * FROM wp_workflow_status");
                            if ($status_list) {
                                foreach ($status_list as $stat) {
                                    ?>
                                    <option value="<?php echo $stat->pk_status_id; ?>" <?php if ($status == $stat->pk_status_id) echo 'selected'; ?>><?php echo $stat->status_name; ?></option>
                                    <?php
                                }
                            }
                            ?>                           
                        </select>                       
                    </td>
                    <td><select name="range">
                            <option value="0">Select...</option>
                            <option value="1" <?php if ($_GET['range'] == 1) echo 'selected'; ?>>0 to 7 days</option>
                            <option value="2" <?php if ($_GET['range'] == 2) echo 'selected'; ?>>8 to 14 days</option>
                            <option value="3" <?php if ($_GET['range'] == 3) echo 'selected'; ?>>15 to 21 days</option>
                            <option value="4" <?php if ($_GET['range'] == 4) echo 'selected'; ?>>22 to 28 days</option>
                            <option value="5" <?php if ($_GET['range'] == 5) echo 'selected'; ?>>Over 28 days</option>
                        </select>
                    </td>
                    <td>
                        <select name="job">
                            <option value="0">Select...</option>
                            <option value="1" <?php if ($_GET['job'] == '1') echo 'selected'; ?>>None</option>
                            <option value="2" <?php if ($_GET['job'] == '2') echo 'selected'; ?>>Yes</option>
                            <option value="3" <?php if ($_GET['job'] == '3') echo 'selected'; ?>>No</option>                               
                        </select>
                    </td>
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
                        <input type="submit" value="Filter" name="search" class="lightblue"><br>
                        <input type="reset" value="Reset" class="lightred" id="all">
                    </td>
                </tr>
                <?php
                if ($orders) {
                    $flag = 0;
                    foreach ($orders as $order) {
                        $flag++;
                        ?>
                        <tr>
                            <td><?php echo $order->billing_name; ?></td>
                            <td>
                                <?php
                                if ($order->is_assigned == 1 && $order->reviewer_id != ''):
                                    $user_info = get_userdata($order->reviewer_id);
                                    echo '<span id="review' . $flag . '">' . $user_info->first_name . ' ' . $user_info->last_name . '</span>';
                                else:
                                    echo '<span id="review' . $flag . '">Unassigned</span>';
                                endif;
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($order->status_name) {
                                    echo $order->status_name;
                                } else {
                                    echo "None";
                                }
                                ?>
                            </td>
                            <td><?php echo dateDiff($order->timestamp); ?></td>
                            <td>
                                <?php
                                if ($order->job_status):
                                    echo $order->job_status;
                                else:
                                    echo "None";
                                endif;
                                ?>
                            </td>
                            <td>
                                <?php
                                $packages = $wpdb->get_row("SELECT * FROM $wpdb->pmpro_membership_levels WHERE id = '$order->membership_id' LIMIT 1");
                                echo $packages->name;
                                ?>
                            </td>
                            <td>                              
                                <?php if ($order->is_assigned == 0) { ?>                                
                                    <a class="assign_dash assign red_btn select<?php echo $order->id; ?>"  data-bind="<?php echo $order->id; ?>">Assign</a>
                                <?php } else { ?>
                                    <a class="grey_btn view<?php echo $order->id; ?>" href="<?php echo site_url() . '/wp-admin/admin.php?page=view-resume-listing&id=' . $order->id; ?>">View</a>
                                <?php } ?>
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
                    <select name="view" id="admin_view">
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

<div id="assign" class="modal fade modal_popup" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="popup_content">
                    <h4>Assign to</h4>
                    <div class="popup_data">
                        <form name="reviewer_assign" id="reviewer_assign" method="post" action="#">
                            <select name="reviewer_name" id="reviewer_name">
                                <option value="0">-Select other Reviewer-</option>
                                <?php
                                $blogusers = get_users('role=reviewer');
                                foreach ($blogusers as $user) {
                                    ?> 
                                    <option <?php if ($_GET['reviewer'] == $user->ID) echo 'selected'; ?> value="<?php echo $user->ID ?>"><?php echo $user->first_name . ' ' . $user->last_name; ?></option>
                                <?php } ?> 
                            </select>
                            <div class="assign_msg"></div>
                            <input type="hidden" id="package_id">
                            <input type="submit" class="red_btn" value="Assign Now" name="assignto" id="assignto">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
            echo "<li class='prev_arrow'><a href='" . urldecode(get_pagenum_link($paged - 1)) . "'></a>";

        for ($i = 1; $i <= $pages; $i++) {
            if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems )) {
                echo ($paged == $i) ? "<li class='page_content current'><span>" . $i . "</span></li>" : "<li class='page_content'><a href='" . urldecode(get_pagenum_link($i)) . "' class='inactive' >" . $i . "</a></li>";
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
