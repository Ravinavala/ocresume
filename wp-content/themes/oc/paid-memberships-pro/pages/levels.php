<?php
global $wpdb, $pmpro_msg, $pmpro_msgt, $current_user;
$pmpro_levels = pmpro_getAllLevels(false, true);
$pmpro_level_order = pmpro_getOption('level_order');
//---------Get array of packages to dispaly-----------//
$packages = of_get_option('sel_package');

if (!empty($pmpro_level_order)) {
    $order = explode(',', $pmpro_level_order);
    $reordered_levels = array();
    foreach ($order as $level_id) {
        foreach ($pmpro_levels as $key => $level) {
            if ($level_id == $level->id) {
                if ($packages[$level->id] == 1) {
                    $reordered_levels[] = $pmpro_levels[$key];
                }
            }
        }
    }
    $pmpro_levels = $reordered_levels;
}
$pmpro_levels = apply_filters("pmpro_levels_array", $pmpro_levels);
if ($pmpro_msg) {
    ?>
    <div class="pmpro_message <?php echo $pmpro_msgt ?>"><?php echo $pmpro_msg ?></div>
<?php } ?>
<?php
$current_level = array();
$non_complete = array();
foreach ($pmpro_levels as $level) {
    $packagelist = $wpdb->get_results("SELECT * FROM $wpdb->pmpro_membership_orders WHERE user_id = '$current_user->ID' ");
    foreach ($packagelist as $list) {
        if ($list->membership_id == $level->id) {
            $current_level[] .= $list->membership_id;
            if ($list->workflow_status != 6) {
                $non_complete[] .= $list->membership_id;
            }
        }
    }
}
$count = 0;
foreach ($pmpro_levels as $level) {
    ?>
    <div class="col-sm-3 package">
        <div class="package_class_info">
            <div class="package_bg">
                <h2><?php echo $current_level ? "<strong>{$level->name}</strong>" : $level->name ?></h2>
            </div>
            <h3>
                <?php
                if (pmpro_isLevelFree($level))
                    $cost_text = "<strong>" . __("Free", "pmpro") . "</strong>";
                else
                    $cost_text = pmpro_getLevelCost($level, true, true);
                $expiration_text = pmpro_getLevelExpiration($level);

                if (!empty($cost_text) && !empty($expiration_text))
                    echo $cost_text . "<br />" . $expiration_text;
                elseif (!empty($cost_text))
                    echo $cost_text;
                elseif (!empty($expiration_text))
                    echo $expiration_text;
                ?>
            </h3>
            <div class="border-bottom"></div>
            <?php echo $level->description; ?>
            <?php
            if (is_user_logged_in()) {
                if ($current_user->roles[0] == 'student') {
                    if (empty($current_level)) {
                        if ($level->id < 3):
                            ?> 
                            <a  href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https") ?>"><?php _e('Sign-Up', 'pmpro'); ?></a>
                        <?php else: ?> 
                            <a onclick="alert('first subscribed in Package 1 or Package 2 to subscribe in this Package')" href="javascript:;"><?php _e('Buy-Now', 'pmpro'); ?></a>
                        <?php
                        endif;
                    } elseif (!in_array($level->id, $current_level)) {
                        if ($level->id < 3 && ((in_array(3, $current_level)) || (in_array(4, $current_level)))) {
                            ?> 
                            <a  href="javascript:;" style="pointer-events: none;"><?php _e('New Students Only', 'pmpro'); ?></a>
                            <?php
                        } else if ((in_array(1, $current_level)) && $level->id == 2) {
                            ?> 
                            <a onclick="alert('You cant subscribe in Package 2 because you allready subscribed in Package 1')" href="javascript:;"><?php _e('Buy-Now', 'pmpro'); ?></a>
                        <?php } elseif ((in_array(2, $current_level)) && $level->id == 1) { ?> 
                            <a onclick="alert('You cant subscribe in Package 1 because you allready subscribed in Package 2')" href="javascript:;"><?php _e('Buy-Now', 'pmpro'); ?></a>
                            <?php
                        } elseif ($level->id == 3) {
                            if ($current_level == 1 || $current_level == 2) {
                                ?> 
                                <a  href="javascript:;" style="pointer-events: none;"><?php _e('New Students Only', 'pmpro'); ?></a>
                                <?php
                            } else {
                                if ((in_array(1, $current_level)) || (in_array(2, $current_level))) {
                                    $status_list = $wpdb->get_results("SELECT workflow_status FROM $wpdb->pmpro_membership_orders WHERE user_id = '$current_user->ID' AND (membership_id = 1 OR membership_id = 2) LIMIT 1");
                                    if ($status_list[0]->workflow_status != '6') {
                                        ?>
                                        <a onclick="alert('first Completed Package 1 or Package 2 to subscribe in this Package')" href="javascript:;"><?php _e('Buy-Now', 'pmpro'); ?></a>
                                        <?php
                                    } else {
                                        if ($non_complete) {
                                            ?>
                                            <a onclick="alert('first complete purchased package to buy this Package')" href="javascript:;"><?php _e('Buy-Now', 'pmpro'); ?></a>
                                            <?php
                                        } else {
                                            ?>
                                            <a  href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https") ?>"><?php _e('Buy-Now', 'pmpro'); ?></a>
                                            <?php
                                        }
                                    }
                                } else {
                                    ?>
                                    <a onclick="alert('first subscribed in Package 1 or Package 2 to subscribe in this Package')" href="javascript:;"><?php _e('Buy-Now', 'pmpro'); ?></a>
                                    <?php
                                }
                            }
                        } elseif ($level->id == 4) {
                            if ($current_level == 1 || $current_level == 2) {
                                ?> 
                                <a  href="javascript:;" style="pointer-events: none;"><?php _e('New Students Only', 'pmpro'); ?></a>
                                <?php
                            } else {
                                if ($non_complete) {
                                    ?>
                                    <a onclick="alert('first complete purchased package to buy this Package')" href="javascript:;"><?php _e('Buy-Now', 'pmpro'); ?></a>
                                    <?php
                                } else {
                                    ?>
                                    <a  href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https") ?>"><?php _e('Buy-Now', 'pmpro'); ?></a>
                                    <?php
                                }
                            }
                        } else {
                            if ($non_complete) {
                                ?>
                                <a onclick="alert('first complete purchased package to buy this Package')" href="javascript:;"><?php _e('Buy-Now', 'pmpro'); ?></a>
                                <?php
                            } else {
                                ?>
                                <a  href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https") ?>"><?php _e('Buy-Now', 'pmpro'); ?></a>
                                <?php
                            }
                        }
                    } elseif (in_array($level->id, $current_level)) {
                        if (pmpro_isLevelExpiringSoon($current_user->membership_level) && $current_user->membership_level->allow_signups) {
                            ?>
                            <a class="pmpro_btn pmpro_btn-select" href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https") ?>"><?php _e('Renew', 'pmpro'); ?></a>
                            <?php
                        } else {
                            if ($level->id < 3) {
                                ?>
                                <a  href="javascript:;" style="pointer-events: none;"><?php _e('Purchase', 'pmpro'); ?></a>                                
                            <?php } else {
                                ?>
                                <a  href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https") ?>"><?php _e('Buy-Now', 'pmpro'); ?></a>
                                <?php
                            }
                        }
                    }
                } else {
                    ?> 
                    <a onclick="alert('Please login as a Student to  Sign-Up in this Package')" href="javascript:;"><?php _e('Sign-Up', 'pmpro'); ?></a>
                    <?php
                }
            } else {
                if ($level->id < 3):
                    ?> 
                    <a  href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https") ?>"><?php _e('Sign-Up', 'pmpro'); ?></a>
                <?php else: ?> 
                    <a  href="javascript:;" style="pointer-events: none;"><?php _e('Sign-Up', 'pmpro'); ?></a>
                <?php
                endif;
            }
            ?>
        </div>
    </div>
<?php } ?>