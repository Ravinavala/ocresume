<?php
/*
  Template Name: Reviewer Dashboard
 */
?>
<?php if (!is_user_logged_in()): ?>
    <script>window.location.href = "<?php echo site_url(); ?>";</script>
<?php endif; ?>
<?php get_header('dashboard'); ?>
<div class="all_pages_title">
    <h1 class="page-title"><?php the_title(); ?></h1>
</div>
<input type="hidden" id="dashboard" value="<?php echo get_site_url(); ?>/<?php echo $current_user->roles[0]; ?>/dashboard">
<input type="hidden" id="user_id" value="<?php echo $current_user->ID; ?>">
<input type="hidden" id="currentuser_id" value="<?php echo $current_user->ID; ?>" />

<div class="quick_links">
    <label>Quick Links: </label>
    <?php if ($_GET['open'] || $_GET['unassigned'] || $_GET['assigned']) { ?>
        <a class="red_btn" href="javascript:void(0);" id="all">All Jobs</a>
    <?php } else { ?>
        <a class="grey_btn" href="javascript:void(0);" style="pointer-events: none;" >All Jobs</a>
    <?php } ?> 
    <?php if ($_GET['open']) { ?>
        <a class="grey_btn" href="javascript:void(0);"  style="pointer-events: none;" >All open jobs</a>
    <?php } else { ?>
        <a class="red_btn" href="javascript:void(0);" id="open">All open jobs</a>
    <?php } ?>     
    <?php if ($_GET['unassigned']) { ?>
        <a class="grey_btn" href="javascript:void(0);"  style="pointer-events: none;" >Unassigned</a>
    <?php } else { ?>
        <a class="red_btn" href="javascript:void(0);" id="unassigned">Unassigned</a>
    <?php } ?>     
    <?php if ($_GET['assigned']) { ?>
        <a class="grey_btn" href="javascript:void(0);"  style="pointer-events: none;" >Jobs assigned to me</a>
    <?php } else { ?>
        <a class="red_btn" href="javascript:void(0);" id="assigned">Jobs assigned to me</a>
    <?php } ?>    
</div>

<div class="student_resume_list">
    <span>Students Resume list</span>
</div>
<?php
$where = '';
$order = '';
$current_id = $current_user->ID;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
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
if ($_GET['assigned'] != 0) {
    $assign = $_GET['assigned'];
    if ($where)
        $query = "where $where AND  o.is_assigned = 1 AND o.reviewer_id = $assign   $order ";
    else
        $query = "where   o.is_assigned = 1 AND o.reviewer_id = $assign   $order ";
} elseif ($_GET['unassigned']) {
    if ($where)
        $query = "WHERE $where AND  o.is_assigned = 0   $order ";
    else
        $query = "WHERE  o.is_assigned = 0   $order ";
} elseif ($_GET['open']) {
    if ($where)
        $query = "WHERE $where AND o.workflow_status != '1' AND o.workflow_status != '2' AND o.workflow_status != '3' AND o.workflow_status != '6'  $order ";
    else
        $query = "WHERE  o.workflow_status != '1' AND o.workflow_status != '2' AND o.workflow_status != '3' AND o.workflow_status != '6'  $order ";
} else {
    if ($where)
        $query = "WHERE  $where $order ";
    else
        $query = " $order ";
}

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
?>
<form id="resume" >
    <?php if ($_GET['assigned']) { ?>
        <input type="hidden" name="assigned" value="<?php echo $_GET['assigned']; ?>">
    <?php } ?>
    <?php if ($_GET['unassigned']) { ?>
        <input type="hidden" name="unassigned" value="<?php echo $_GET['unassigned']; ?>">
    <?php } ?>
    <?php if ($_GET['open']) { ?>
        <input type="hidden" name="open" value="<?php echo $_GET['open']; ?>">
    <?php } ?>
    <div class="students_resumes">
        <div class="table-pagination counts">  
            <?php if ($orders) { ?>                                    
                <div class="view_select">
                    <span>Page</span>
                    <?php
                    if (function_exists("custom_pagination")) {
                        custom_pagination($paged, $num_of_pages, 0);
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
                <?php if (!$_GET['assigned'] && !$_GET['unassigned']) { ?>
                    <option value="3" <?php if ($sort == 3) echo 'selected'; ?>>Reviewer </option>
                <?php } ?>               
                <option value="4" <?php if ($sort == 4) echo 'selected'; ?>>Status </option>
                <option value="5" <?php if ($sort == 5) echo 'selected'; ?>>Range </option>
                <option value="6" <?php if ($sort == 6) echo 'selected'; ?>>Received job </option>
                <option value="7" <?php if ($sort == 7) echo 'selected'; ?>>Package </option>
            </select>
            <input type="submit" value="Submit" class="red_btn">
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
                    <td> <?php if (!$_GET['assigned'] && !$_GET['unassigned']) { ?>
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
                        <?php } ?>
                    </td>
                    <td><select name="status">
                            <option value="0" >Select...</option>
                            <?php
                            $status_list = $wpdb->get_results("SELECT * FROM wp_workflow_status");
                            if ($status_list) {
                                foreach ($status_list as $stat) {
                                    if ($_GET['open']) {
                                        if ($stat->pk_status_id != 1 && $stat->pk_status_id != 2 && $stat->pk_status_id != 3) {
                                            ?>
                                            <option value="<?php echo $stat->pk_status_id; ?>" <?php if ($status == $stat->pk_status_id) echo 'selected'; ?>><?php echo $stat->status_name; ?></option>
                                            <?php
                                        }
                                    }else {
                                        ?>
                                        <option value="<?php echo $stat->pk_status_id; ?>" <?php if ($status == $stat->pk_status_id) echo 'selected'; ?>><?php echo $stat->status_name; ?></option>
                                        <?php
                                    }
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
                        <input type="submit" value="Filter" class="lightblue"><br>
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
                                    <a class="assign_dash assign red_btn select<?php echo $order->id; ?>"  data-bind="<?php echo $order->id; ?>">Select</a>
                                    <a class="grey_btn view<?php echo $order->id; ?>" href="<?php echo get_permalink(219) . '?id=' . $order->id; ?>" style="display: none;">View</a>
                                <?php } else { ?>
                                    <a class="grey_btn view<?php echo $order->id; ?>" href="<?php echo get_permalink(219) . '?id=' . $order->id; ?>">View</a>
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
        <?php } ?>
    </div>
</form>
</div>
</div>    
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
                        <form>
                            <select>
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
                            <input type="submit" class="red_btn" value="Assign Now" id="assignto">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT -->
<!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->
<?php get_footer('dashboard'); ?>
