<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">

            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>
            <!-- END SIDEBAR TOGGLER BUTTON -->

            <li class="sidebar-search-wrapper">
                <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->

                <form class="sidebar-search  " action="page_general_search_3.html" method="POST">
                    <a href="javascript:;" class="remove">
                        <i class="icon-close"></i>
                    </a>
                </form>
                <!-- END RESPONSIVE QUICK SEARCH FORM -->
            </li>
            <?php $current_user = wp_get_current_user(); ?>
            <li class="nav-item start <?php if (get_the_ID() == 151 || get_the_ID() == 173) echo "active"; ?>  open">
                <a href="<?php echo get_site_url(); ?>/<?php echo $current_user->roles[0]; ?>/dashboard" class="nav-link nav-toggle">
                    <i class="icon-image-home"></i>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            <?php
            if ($current_user->roles[0] == student) {
                $userid = $current_user->ID;
                $package = $wpdb->get_row("SELECT * FROM $wpdb->pmpro_membership_orders WHERE user_id = $userid AND workflow_status!= 6 LIMIT 1");
                if ($package) {
                    ?>
                    <li class="nav-item start open <?php if (get_the_ID() == 179 || get_the_ID() == 186) echo "active"; ?>">

                         <?php
                        if ($package->membership_id == 1) {
                               if ($package->is_submit != 1) { ?>
                                    <a href="<?php the_permalink(179); ?>?id=<?php echo $package->id; ?>" class="nav-link nav-toggle">
                                    <i class="icon-resume"></i>
                                    <span class="title">Resume Workspace</span>
                                </a>
                                   
                              <?php  }
                    
                          else  if ($package->is_submit == 1 && $package->name == '') {
                            
                                ?>
                                <a href="<?php the_permalink(179); ?>?id=<?php echo $package->id; ?>" class="nav-link nav-toggle">
                                    <i class="icon-resume"></i>
                                    <span class="title">Resume Workspace</span>
                                </a>
                                <?php
                            } else {
                                ?>
                                <a href="<?php the_permalink(186); ?>?id=<?php echo $package->id; ?>" class="nav-link nav-toggle">
                                    <i class="icon-resume"></i>
                                    <span class="title">Resume Workspace</span>
                                </a>
                                <?php
                            }
                        } 
                        else {
                                ?>
                                <a href="<?php the_permalink(186); ?>?id=<?php echo $package->id; ?>" class="nav-link nav-toggle">
                                    <i class="icon-resume"></i>
                                    <span class="title">Resume Workspace</span>
                                </a>
                                <?php
                            }
                        ?>
                    </li>
                    <?php if ($package->membership_id == 1 && $package->is_submit != 1): else : ?>
                        <?php if ($package->name != ''): ?>
                            <li class="nav-item start open <?php if (get_the_ID() == 286) echo "active"; ?>">
                                <a href="<?php the_permalink(286); ?>?id=<?php echo $package->id; ?>" class="nav-link nav-toggle">
                                    <i class="icon-generate-resume"></i>
                                    <span class="title">Preview Resume</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php } else {
                    ?>
                    <li class="nav-item start open <?php if (get_the_ID() == 179 || get_the_ID() == 186) echo "active"; ?>">
                        <a href="<?php the_permalink(186); ?>" class="nav-link nav-toggle">
                            <i class="icon-resume"></i>
                            <span class="title">Resume Workspace</span>
                        </a>
                    </li>
                    <?php
                }
                ?>
                <li class="nav-item start open <?php if (get_the_ID() == 283) echo "active"; ?>">
                    <a href="<?php the_permalink(283); ?>" class="nav-link nav-toggle">
                        <i class="icon-generate-resume"></i>
                        <span class="title">Admin/Tech Support</span>
                    </a>
                </li>
            <?php } ?>
            <li class="nav-item start open <?php if (get_the_ID() == 238 || get_the_ID() == 241) echo "active"; ?>">
                <a href="<?php echo get_site_url(); ?>/<?php echo $current_user->roles[0]; ?>/history" class="nav-link nav-toggle">
                    <i class="icon-history"></i>
                    <span class="title">History</span>
                </a>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>