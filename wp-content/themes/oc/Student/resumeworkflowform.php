<?php
/*
  Template Name: Student Resume workflow form
 */
?>
<?php if (!is_user_logged_in()): ?>
    <script>window.location.href = "<?php echo site_url(); ?>";
    </script>

<?php endif; ?>
<?php get_header('dashboard'); ?>
<script>
    $(window).on("load", function () {
        if (localStorage.getItem('active')) {
            var active = localStorage.getItem('active');
            if (active == 'head') {
                $('html,body').unbind().animate({scrollTop: $('.page-content-wrapper').offset().top - 100}, 'slow');
            } else {
                $('.' + active).removeClass('collapsed');
                $('.' + active).attr("aria-expanded", "true");
                $('.' + active).closest('div.panel-heading').addClass('active');
                var active_id = $('.' + active).attr('href');
                $(active_id).addClass('in');
                $(active_id).attr("aria-expanded", "true");
                $('html,body').unbind().animate({scrollTop: $('.' + active).offset().top - 100}, 'slow');
            }
        }
    });
</script>
<h1 class="page-title"><?php the_title(); ?></h1>
<?php
if (!$_REQUEST['id']):
    echo "There is currently no active package.";
else:
    ?>
    <?php
    global $wpdb;
    $userid = $current_user->ID;
    $packageid = $_GET['id'];
    $daatresult = $wpdb->get_row("SELECT * FROM $wpdb->pmpro_membership_orders WHERE id = '$packageid'  LIMIT 1");
    $packagedetails = $wpdb->get_row("SELECT * FROM $wpdb->pmpro_membership_levels WHERE id = '$daatresult->membership_id' LIMIT 1");
    $sql = "SELECT * FROM `wp_workflow_status` WHERE pk_status_id = '$daatresult->workflow_status' ";
    $workstatusname = $wpdb->get_results($sql) or die(mysql_error());
    ?>
    <?php
    if ($daatresult->workflow_status == 3 && $daatresult->membership_id == 3) {
        $completedpackage = $wpdb->get_row("SELECT * FROM $wpdb->pmpro_membership_orders WHERE user_id = '$userid' AND workflow_status = 6 LIMIT 1");
//    $sql = "SELECT * FROM `wp_workflow_status` WHERE pk_status_id = '$completedpackage->workflow_status' ";
//    $workflowstatusname = $wpdb->get_results($sql) or die(mysql_error());
//    print_r($workflowstatusname);
    } else {
        $packageobj = $wpdb->get_row("SELECT * FROM $wpdb->pmpro_membership_orders WHERE id = '$packageid'  LIMIT 1");
    }
    ?>
    <?php
    if ($daatresult->membership_id == 1 || $daatresult->membership_id == 2 || $daatresult->membership_id == 3 || $daatresult->membership_id == 4) {
        $workflowsttus = 4;
    }
//if ($daatresult->membership_id == 3) {
//    $workflowstatusname = $workflowstatusname->status_name;
//}
    $class = '';
    if ($packageobj->workflow_status == 4 || $packageobj->workflow_status == 6) {
        $class = "readonly_fields";
    }
    ?>
  
    <div id="workspace_mainsupers" class="workspace_mainsuper">
        <div class="workspace <?php echo $class; ?> ">
            <div class="workspace_top">
                <div class="workspace_left">
                    <div class="package">
                        <div class="package_class_info">
                            <div class="package_bg">
                                <h2><?php echo $packagedetails->name; ?></h2>
                            </div>
                            <h3><?php
                            $val = ($pmpro_currency_symbol);
                            echo $val;
                            ?><?php echo $packagedetails->initial_payment; ?></h3>
                            <div class="border-bottom"></div>
                            <?php echo $packagedetails->description; ?>
                        </div>
                    </div>
                </div>
                <div class="workspace_right">
                    <div class="workflow_table">
                        <div class="table">
                            <div class="tbody">
                                <div class="tr">
                                    <div class="th">Purchase Date: </div>
                                    <?php
                                    $date = $daatresult->timestamp;
                                    ?>
                                    <div class="td"><?php echo date(' F j, Y', strtotime($date)); ?></div>
                                </div>
                                <div class="tr">
                                    <div class="th">Workflow Status:</div>
                                    <div class="td">
                                        <?php
                                        if ($daatresult->workflow_status != '') {
                                            echo $workstatusname[0]->status_name;
                                        } else
                                            echo 'None';
                                        if ($daatresult->workflow_status == '4' || $daatresult->workflow_status == '6') {
                                            echo '<img class="lock_img" src="' . get_template_directory_uri() . '/images/lock.png" alt="lock" title="' . of_get_option('contact_admin') . '" />';
                                        }
                                        ?>
                                        <?php
                                        if ($daatresult->uploaded_resume != ''):
                                            $uploads = wp_upload_dir();
                                            $upload_path = $uploads['baseurl'];
                                            if ($daatresult->original_resume)
                                                $file_name = $daatresult->original_resume;
                                            else
                                                $file_name = $daatresult->uploaded_resume;
                                            $name = $file_name;
                                            $len = strlen($file_name);
                                            if ($len > 10)
                                                $file_name = substr($file_name, 0, 10) . "...";
                                            echo '<a title="' . $name . '" download="' . $name . '"  class="red_text" href="' . $upload_path . '/files/' . $daatresult->uploaded_resume . '" >' . $file_name . '</a>';

                                        endif;
                                        ?>
                                    </div>
                                </div>
                                <div class="tr">
                                    <div class="th">Reviewer:</div>
                                    <?php
                                    if ($daatresult->reviewer_id != 0) {
                                        $user_info = get_userdata($daatresult->reviewer_id);
                                        echo '<div class="td">' . $user_info->first_name . '  ' . $user_info->last_name . '</div>';
                                    } else {
                                        echo '<div class="td">None</div>';
                                    }
                                    ?>

                                </div>
                                <div class="tr">
                                    <div class="th">View Resume:</div>
                                    <?php if ($daatresult->resume_pdf != '') { ?>
                                        <div class="td"><a class="black_border" href="<?php the_permalink(286); ?>?id=<?php echo $daatresult->id; ?>" >View Now</a></div>

                                        <?php
                                    } else {
                                        echo '<div class="td">None</div>';
                                    }
                                    ?>


                                </div>
                            </div>
                            <div class="tr">
                                <div class="th">Download Resume:</div>
                                <?php
                                if ($daatresult->resume_pdf) {
                                    $uploads = wp_upload_dir();
                                    $upload_path = $uploads['baseurl'];
                                    $name = $daatresult->name . '_resume.pdf';
                                    ?>
                                    <div class="td"><a class="red_text" href="<?php echo $upload_path; ?>/resumes/<?php echo $daatresult->resume_pdf; ?>" download ><?php echo $name; ?> </a></div>
                                    <?php
                                } else {
                                    echo '<div class="td">None</div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" id="package_id" value="<?php echo $packageid; ?>" />
            <input type="hidden" id="user_id" value="<?php echo $packageobj->user_id; ?>" />
            <input type="hidden" id="currentstatus" value="<?php echo $daatresult->workflow_status; ?>" />
            <input type="hidden" id="is_submit" value="1" />
            <input type="hidden" id="workflow_status" value="<?php echo $workflowsttus; ?>" />
            <input type="hidden" id="currentuser_id" value="<?php echo $current_user->ID; ?>" />
            <input type="hidden" id="reviewer_id" value="<?php echo $packageobj->reviewer_id; ?>" />
            <div class="workspace_bottom">

                <div class="w_revised">
                    <label>What are your goals with having a resume created/revised?*</label>
                    <textarea placeholder="Type here" name="goals" id="goals" ><?php echo($daatresult->workflow_status == 3 && $daatresult->membership_id == 3 ? $completedpackage->goals : $packageobj->goals ); ?></textarea>
                </div>
                <input type="hidden" id="finalstatus" value="1">
                <div class="goal_msg"></div>
                <?php
                if ($daatresult->membership_id == 1 && $daatresult->workflow_status == 5) {
                    $uploaddir = '/wp-content/uploads/files/';
                    ?>
                    <h4>Resume originally submitted:</h4>
                    <a class="red_text" download="<?php echo $daatresult->original_resume; ?>"  href="<?php echo site_url(); ?><?php echo $uploaddir; ?><?php echo $daatresult->uploaded_resume; ?>"><?php echo $daatresult->original_resume; ?></a>
                <?php } ?>

                <p>Please complete the following fields and submit when ready for review.</p>
                <div class="workflow_form <?php echo $class; ?> ">
                    <div class="panel-group accordion" id="accordion3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle accordion-toggle-styled personal" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_1"> Personal Informational </a>
                                </h4>
                            </div>
                            <div id="collapse_3_1" class="panel-collapse" >
                                <div class="panel-body">
                                    <form id="personal_info">
                                        <div class="c_row">
                                            <div class="c_left">
                                                <label>Name*</label>
                                                <input type="text" class="alltxtfield" id="studentname" maxlength="300" name="studentname" placeholder="Type here" value="<?php echo($daatresult->workflow_status == 3 && $daatresult->membership_id == 3 ? $completedpackage->name : $packageobj->name ); ?>">

                                            </div>
                                            <div class="c_right">
                                                <label>Phone*</label>
                                                <input type="text" class="studentphone" id="studentphone" maxlength="15" maxlength="10"  placeholder="Type here" name="phone" value="<?php echo($daatresult->workflow_status == 3 && $daatresult->membership_id == 3 ? $completedpackage->phone : $packageobj->phone ); ?>">

                                            </div>
                                            <div class="c_row">
                                                <div class="c_left">
                                                    <label>Email*</label>
                                                    <input type="text" id="studentemail" maxlength="80" placeholder="Type here" name="email" value="<?php echo($daatresult->workflow_status == 3 && $daatresult->membership_id == 3 ? $completedpackage->email : $packageobj->email ); ?>">
                                                </div>

                                                <div class="c_right">
                                                    <label>School*</label>
                                                    <input type="text" class="alltxtfield"  id="studentschool" maxlength="300" placeholder="Type here" name="school"  value="<?php echo($daatresult->workflow_status == 3 && $daatresult->membership_id == 3 ? $completedpackage->school : $packageobj->school ); ?>">
                                                </div>
                                            </div>
                                            <div class="c_row">
                                                <div class="c_left">
                                                    <label>City</label>
                                                    <input type="text" class="alltxtfield" id="studentcity" maxlength="300"  placeholder="Type here" name="city" value="<?php echo($daatresult->workflow_status == 3 && $daatresult->membership_id == 3 ? $completedpackage->city : $packageobj->city ); ?>">
                                                </div>
                                                <div class="c_right">
                                                    <div class="c_right_left">
                                                        <label>Degree*</label>
                                                        <input type="text" class="alltxtfield" id="studentdegree" maxlength="300"  placeholder="Type here" name="degree" value="<?php echo($daatresult->workflow_status == 3 && $daatresult->membership_id == 3 ? $completedpackage->degree : $packageobj->degree ); ?>">
                                                    </div>
                                                    <div class="c_right_right">
                                                        <label>Graduation Date*</label>
                                                        <div class="input-group input-medium date date-picker" data-date="<?php
                                                        if ($packageobj->graduation_date != '0000-00-00')
                                                            echo date("d-m-Y", strtotime($daatresult->graduation_date));
                                                        else
                                                            echo date("d-m-Y");
                                                        ?>" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                                                            <input type="text"  id="studentgraduationdate" class="form-control" readonly="" value="<?php
                                                            if ($packageobj->graduation_date != '0000-00-00')
                                                                echo date("d-m-Y", strtotime($packageobj->graduation_date));
                                                            else
                                                                echo date("d-m-Y");
                                                            ?>" name="gdate">
                                                            <span class="input-group-btn">
                                                                <button class="btn default" type="button">
                                                                    <i class="fa fa-calendar"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="c_row">
                                                <div class="c_left">
                                                    <label>Link to LinkedIn</label>
                                                    <input  type="text" id="studentlinkedinprofile" maxlength="300"  placeholder="Type here" name="linkedin" value="<?php echo($daatresult->workflow_status == 3 && $daatresult->membership_id == 3 ? $completedpackage->linkedin : $packageobj->linkedin ); ?>">
                                                </div>
                                                <div class="c_right">
                                                    <label>Endorsement*</label>
                                                    <input class="alltxtfield"  type="text" maxlength="300"  id="studentendorsment" placeholder="Type here" name="endorsement" value="<?php echo($daatresult->workflow_status == 3 && $daatresult->membership_id == 3 ? $completedpackage->endorsement : $packageobj->endorsement ); ?>">
                                                </div>
                                            </div>
                                            <div class="c_row">
                                                <label>Description of Job They Want</label>
                                                <textarea placeholder="Type here" class="alltxtfield" id="studentdescforjob" maxlength="500"  name="jobdescription"><?php echo($daatresult->workflow_status == 3 && $daatresult->membership_id == 3 ? $completedpackage->jobdescription : $packageobj->jobdescription ); ?></textarea>
                                            </div>
                                            <div class="grey_row">
                                                <div class="grey_row_right">
                                                    <input type="submit" name="submit" id="submitpersonalinfo"  class="red_btn submitpersonalinfo" value="Save">
                                                </div>
                                            </div>
                                            <div class="info_msg"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <form method="post" id="aboutstudentform"  name="resume" enctype="multipart/form-data" >
                            <input type="hidden" id="addaboutyou" name="addaboutyou" value="1">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle accordion-toggle-styled collapsed about green-border" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_2"> Few Things About Me </a>
                                </h4>
                            </div>
                            <div id="collapse_3_2" class="panel-collapse collapse ">
                                <div class="panel-body" >
                                    <?php
                                    if ($daatresult->workflow_status == 3 && $daatresult->membership_id == 3) {

                                        $about = $wpdb->get_results("SELECT about_things FROM about_student WHERE fk_package_id = '$completedpackage->id'");
                                        $about_count = count($about);
                                    } else {
                                        $about = $wpdb->get_results("SELECT about_things FROM about_student WHERE fk_package_id = '$packageid'");
                                        $about_count = count($about);
                                    }
                                    ?>
                                    <div class="c_row">
                                        <div class="c_left">
                                            <label>Thing 1*</label>
                                            <input id="thing_1" type="text" maxlength="300"  placeholder="Type here" value="<?php if ($about_count >= 1) echo $about[0]->about_things; ?>" name="thing_1" class="thing alltxtfield first_thing">
                                        </div>
                                        <div class="c_right">
                                            <label> Thing 2</label>
                                            <input type="text" placeholder="Type here" maxlength="300" id="thing_2" name="thing_2" class="thing alltxtfield" value="<?php if ($about_count >= 2) echo $about[1]->about_things; ?>">
                                        </div>
                                    </div>
                                    <div class="c_row">
                                        <div class="c_left">
                                            <label>Thing 3</label>
                                            <input type="text"  placeholder="Type here" maxlength="300" id="thing_3" name="thing_3" class="thing alltxtfield" value="<?php if ($about_count >= 3) echo $about[2]->about_things; ?>">
                                        </div>
                                        <div class="c_right">
                                            <label>Thing 4</label>
                                            <input type="text"  placeholder="Type here" maxlength="300" id="thing_4" name="thing_4" class="thing alltxtfield" value="<?php if ($about_count >= 4) echo $about[3]->about_things; ?>">
                                        </div>
                                    </div>
                                    <div class="c_row">
                                        <div class="c_left">
                                            <label>Thing 5</label>
                                            <input type="text"  placeholder="Type here" maxlength="300" id="thing_5" naem="thing_5" class="thing alltxtfield" value="<?php if ($about_count >= 5) echo $about[4]->about_things; ?>">
                                        </div>
                                        <div class="c_right">
                                            <label>Thing 6</label>
                                            <input type="text" placeholder="Type here" maxlength="300" id="thing_6" name="thing_6" class="thing alltxtfield" value="<?php if ($about_count >= 6) echo $about[5]->about_things; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="grey_row">
                                    <div class="grey_row_left">
                                        <span>Please complete the above fields and click save to continue to the next section.</span>
                                    </div>
                                    <div class="grey_row_right">
                                        <input type="submit" name="submit" id="submitfewthingaboutstudent"  class="red_btn submitfewthingaboutstudent" value="Save">

                                    </div>
                                </div>
                            </div>
                            <div class="about_msg"></div>
                        </form>
                    </div>
                    <div class="panel panel-default">
                        <?php
                        if ($daatresult->workflow_status == 3 && $daatresult->membership_id == 3) {
                            $projects = $wpdb->get_results("SELECT * FROM projects WHERE fk_package_id = '$completedpackage->id'");
                            $project_count = count($projects);
                        } else {
                            $projects = $wpdb->get_results("SELECT * FROM projects WHERE fk_package_id = '$packageid'");
                            $project_count = count($projects);
                        }
                        ?>
                        <input type="hidden" id="addproject" name="addproject" value="<?php
                        if ($project_count > 0)
                            echo $project_count;
                        else
                            echo '1';
                        ?>">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle project accordion-toggle-styled collapsed green-border" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_3" > Project(s) </a>
                            </h4>
                        </div>
                        <form method="post" id="studentprojects"  name="resume" enctype="multipart/form-data" >
                            <div id="collapse_3_3" class="panel-collapse collapse">
                                <div class="clsProject">
                                    <?php
                                    if ($project_count > 0):
                                        $count = 0;
                                        foreach ($projects as $project) {
                                            $count++;
                                            ?>
                                            <div id="div_project_<?php echo $count; ?>" class="panel-body projects">
                                                <input type="hidden" class="pk_project_id" name="pk_project_id_<?php echo $count; ?>" value="<?php echo $project->pk_project_id; ?>">
                                                <div class="c_row">
                                                    <div class="c_left">
                                                        <label>Project <?php echo $count; ?>*</label>
                                                        <input class="projectname alltxtfield" maxlength="300"  type="text" placeholder="Type here" id="project_name_<?php echo $count; ?>" name="project_name_<?php echo $count; ?>" value="<?php echo $project->project_title; ?>" >
                                                    </div>
                                                    <div class="c_right">
                                                        <label>Background*</label>
                                                        <input type="text" class="background alltxtfield " maxlength="300"  placeholder="Type here" id="background_<?php echo $count; ?>" name="background_<?php echo $count; ?>" value="<?php echo $project->background; ?>">
                                                    </div>
                                                </div>
                                                <div class="c_row">
                                                    <div class="c_left">
                                                        <label>Objective*</label>
                                                        <input type="text" class="objective alltxtfield "  maxlength="300"   placeholder="Type here" id="objective_<?php echo $count; ?>" name="objective_<?php echo $count; ?>" value="<?php echo $project->objective; ?>">
                                                    </div>
                                                    <div class="c_right">
                                                        <label>Execution*</label>
                                                        <input type="text" class="execution alltxtfield "  maxlength="300"  placeholder="Type here" id="execution_<?php echo $count; ?>" name="execution_<?php echo $count; ?>" value="<?php echo $project->execution; ?>">
                                                    </div>
                                                </div>
                                                <div class="c_row">
                                                    <div class="c_left">
                                                        <label>Results*</label>
                                                        <input type="text" class="results alltxtfield"  maxlength="300"  placeholder="Type here" id="results_<?php echo $count; ?>" name="results_<?php echo $count; ?>" value="<?php echo $project->results; ?>">
                                                    </div>
                                                    <div class="c_right">
                                                        <label>Attach graphic*</label>
                                                        <input type="file"  class="file_upload" name="uploaded_file" id="uploaded_file_<?php echo $count; ?>" >
                                                        <?php
                                                        if ($project->file_input):
                                                            $uploads = wp_upload_dir();
                                                            $upload_path = $uploads['baseurl'];
                                                            if ($project->original_name)
                                                                $file_name = $project->original_name;
                                                            else
                                                                $file_name = $project->file_input;
                                                            ?>
                                                            <a class="origin_img"  download="<?php echo $file_name; ?>" target="_blank" href="<?php echo $upload_path . '/projects/' . $project->file_input; ?>" ><?php echo $file_name; ?></a>
                                                        <?php endif ?>
                                                        <span>jpg, jpeg, png Files allowed. File size upto 1mb.</span>
                                                        <input type="hidden" class="upload_name" value="<?php echo $project->file_input; ?>"/>
                                                        <input type="hidden" class="original_name" value="<?php echo $project->original_name; ?>" />                                                      
                                                    </div>
                                                </div>
                                                <a data-prj_id="<?php echo $project->pk_project_id; ?>" data-id="<?php echo $count; ?>" class="hide_del del_prj">delete</a>
                                            </div>
                                        <?php } else: ?>
                                        <div id="div_project_1" class="panel-body projects">
                                            <input type="hidden" class="pk_project_id" name="pk_project_id_<?php echo $count; ?>" value="">
                                            <div class="c_row">
                                                <div class="c_left">
                                                    <label>Project 1*</label>
                                                    <input class="projectname studentname alltxtfield " maxlength="300" type="text" placeholder="Type here" name="project_name_1">
                                                </div>
                                                <div class="c_right">
                                                    <label>Background*</label>
                                                    <input type="text" class="background studentname alltxtfield " maxlength="300" placeholder="Type here" id="background_1" name="background_1">
                                                </div>
                                            </div>
                                            <div class="c_row">
                                                <div class="c_left">
                                                    <label>Objective*</label>
                                                    <input type="text" class="objective studentname alltxtfield"  maxlength="300"  placeholder="Type here" id="objective_1" name="objective_1">
                                                </div>
                                                <div class="c_right">
                                                    <label>Execution*</label>
                                                    <input type="text" class="execution studentname alltxtfield" maxlength="300" placeholder="Type here" id="execution_1" name="execution_1">
                                                </div>
                                            </div>
                                            <div class="c_row">
                                                <div class="c_left">
                                                    <label>Results*</label>
                                                    <input type="text" class="results alltxtfield" maxlength="300" placeholder="Type here" id="results_1" name="results_1">
                                                </div>
                                                <div class="c_right">

                                                    <label>Attach graphic*</label>
                                                    <input type="file"  class="file_upload" name="uploaded_file" id="uploaded_file_1" >
                                                    <span>jpg, jpeg, png Files allowed. File size upto 1mb.</span>
                                                    <input type="hidden" class="upload_name" />
                                                    <input type="hidden" class="original_name" />
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="grey_row">
                                    <div class="grey_row_left">
                                        <button id="addnewproject" class="grey_btnnn"> + Add New Project</button><span>Please complete the above fields and click save to continue to the next section.</span>
                                    </div>
                                    <div class="grey_row_right">
                                        <input type="submit" name="submit" id="submitstudentprojects"  class="red_btn submitstudentprojects" value="Save">
                                    </div>
                                </div>
                            </div>
                            <div class="project_msg"></div>
                        </form>
                    </div>

                    <div class="panel panel-default">
                        <?php
                        if ($daatresult->workflow_status == 3 && $daatresult->membership_id == 3) {
                            $works = $wpdb->get_results("SELECT * FROM work_experience WHERE fk_package_id = '$completedpackage->id'");
                            $work_count = count($works);
                        } else {
                            $works = $wpdb->get_results("SELECT * FROM work_experience WHERE fk_package_id = '$packageid'");
                            $work_count = count($works);
                        }
                        ?>
                        <input type="hidden" id="addexperience" name="addexperience" value="<?php
                        if ($work_count > 0)
                            echo $work_count;
                        else
                            echo '1';
                        ?>">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle work accordion-toggle-styled collapsed green-border" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_4" > Work Experience</a>
                            </h4>
                        </div>
                        <form method="post" id="studentworks"  name="resume" enctype="multipart/form-data">
                            <div id="collapse_3_4" class="panel-collapse collapse">
                                <div class="clsexperience">
                                    <?php
                                    if ($work_count > 0):
                                        $count = 0;
                                        foreach ($works as $work) {
                                            $count++;
                                            ?>
                                            <div id="div_workexp_<?php echo $count; ?>" class="panel-body experience">
                                                <input type="hidden" class="pk_workexp_id" name="pk_workexp_id_<?php echo $count; ?>" value="<?php echo $work->pk_workexp_id; ?>">
                                                <div class="c_row">
                                                    <div class="c_left">
                                                        <label>Title*</label>
                                                        <input type="text" maxlength="300"  class="exp_title studentname alltxtfield" placeholder="Type here" id="exp_title_<?php echo $count; ?>" name="exp_title_<?php echo $count; ?>" value="<?php echo $work->title; ?>">
                                                    </div>

                                                    <div class="c_right">
                                                        <label>Company*</label>
                                                        <input type="text" maxlength="300"  class="exp_compny studentname alltxtfield"  placeholder="Type here" id="exp_compny_<?php echo $count; ?>" name="exp_compny_<?php echo $count; ?>" value="<?php echo $work->company; ?>">
                                                    </div>
                                                </div>
                                                <div class="c_row">
                                                    <div class="c_left">
                                                        <label>City*</label>
                                                        <input type="text" maxlength="300"  class="exp_city studentname alltxtfield" placeholder="Type here" id="exp_city_<?php echo $count; ?>" name="exp_city_<?php echo $count; ?>" value="<?php echo $work->city; ?>">
                                                    </div>

                                                    <div class="c_right">
                                                        <label>State*</label>
                                                        <input type="text" maxlength="300"  class="exp_state studentname alltxtfield" placeholder="Type here" id="exp_state_<?php echo $count; ?>" name="exp_state_<?php echo $count; ?>" value="<?php echo $work->state; ?>">
                                                    </div>
                                                </div>
                                                <div class="c_row">
                                                    <div class="c_left">
                                                        <label>Years*</label>
                                                        <input type="text" maxlength="300"  class="exp_years " placeholder="Type here" id="exp_years_<?php echo $count; ?>" name="exp_years_<?php echo $count; ?>" value="<?php echo $work->years; ?>">
                                                    </div>
                                                    <div class="c_right">
                                                        <label>Description</label>
                                                        <textarea placeholder="Type here" maxlength="300" class="exp_description studentname alltxtfield" id="exp_description_<?php echo $count; ?>" name="exp_description_<?php echo $count; ?>"><?php echo $work->description; ?></textarea>
                                                    </div>
                                                </div>
                                                <a data-work_id="<?php echo $work->pk_workexp_id; ?>" data-id="<?php echo $count; ?>" class="hide_del del_works">delete</a>
                                            </div>
                                        <?php } else: ?>
                                        <div id="div_workexp_1" class="panel-body experience">
                                            <input type="hidden" class="pk_workexp_id" name="pk_workexp_id_<?php echo $count; ?>" value="">
                                            <div class="c_row">
                                                <div class="c_left">
                                                    <label>Title*</label>
                                                    <input type="text" maxlength="300" class="exp_title studentname alltxtfield" placeholder="Type here" id="exp_title_1" name="exp_title_1">
                                                </div>

                                                <div class="c_right">
                                                    <label>Company*</label>
                                                    <input type="text" maxlength="300" class="exp_compny studentname alltxtfield" placeholder="Type here" id="exp_compny_1" name="exp_compny_1">
                                                </div>
                                            </div>
                                            <div class="c_row">
                                                <div class="c_left">
                                                    <label>City*</label>
                                                    <input type="text" maxlength="300"  class="exp_city studentname alltxtfield " placeholder="Type here" id="exp_city_1" name="exp_city_1">
                                                </div>

                                                <div class="c_right">
                                                    <label>State*</label>
                                                    <input type="text" maxlength="300" class="exp_state studentname alltxtfield" placeholder="Type here" id="exp_state_1" name="exp_state_1">
                                                </div>
                                            </div>
                                            <div class="c_row">
                                                <div class="c_left">
                                                    <label>Years*</label>
                                                    <input type="text" maxlength="300" class="exp_years " placeholder="Type here" id="exp_years_1" name="exp_years_1">
                                                </div>
                                                <div class="c_right">
                                                    <label>Description</label>
                                                    <textarea placeholder="Type here" maxlength="300" class="exp_description studentname alltxtfield" id="exp_description_1" name="exp_description_1"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="grey_row">
                                    <div class="grey_row_left">
                                        <button id="addnewexperience" class="grey_btnnn"> + Add New</button><span>Please complete the above fields and click save to continue to the next section.</span>
                                    </div>
                                    <div class="grey_row_right">
                                        <input type="submit" name="submit" id="submitstudentworkexperience"  class="red_btn submitstudentworkexperience" value="Save">
                                    </div>
                                </div>
                            </div>
                            <div class="work_msg"></div>
                        </form>
                    </div>

                    <div class="panel panel-default">
                        <?php
                        if ($daatresult->workflow_status == 3 && $daatresult->membership_id == 3) {

                            $skills = $wpdb->get_results("SELECT * FROM skills WHERE fk_package_id = '$completedpackage->id'");
                            $skill_count = count($skills);
                        } else {
                            $skills = $wpdb->get_results("SELECT * FROM skills WHERE fk_package_id = '$packageid' AND fk_user_id = '$userid'");
                            $skill_count = count($skills);
                        }
                        ?>
                        <form method="post" id="studentskill"  name="resume" enctype="multipart/form-data" >
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle accordion-toggle-styled collapsed green-border skill" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_5" > Skills </a>
                                </h4>
                            </div>
                            <input type="hidden" id="addstudentskills" name="addstudentskills" value="<?php
                            if ($skill_count > 0)
                                echo $skill_count;
                            else
                                echo '3';
                            ?>">
                            <div id="collapse_3_5" class="panel-collapse collapse " >
                                <div id="div_skills_1" class="panel-body clsstudentskills">
                                    <?php
                                    if ($skill_count > 0):
                                        echo '<div class="c_row">';
                                        $flag = 0;
                                        foreach ($skills as $skill) {
                                            $flag++;
                                            if ($flag % 2 == 0) {
                                                $class = 'c_right';
                                            } else {
                                                $class = 'c_left';
                                            }
                                            ?>
                                            <div class="<?php echo $class; ?>"  id="skill_<?php echo $flag; ?>">
                                                <label>Skill <?php echo $flag; ?>*</label>
                                                <input maxlength="300" type="text"  class="studentskill alltxtfield" placeholder="Type here" id="student_skill_<?php echo $flag; ?>" name="student_skill_<?php echo $flag; ?>" value="<?php echo $skill->skill; ?>">
                                                <input type="hidden" class="pk_skill_id" name="pk_skill_id_<?php echo $flag; ?>" value="<?php echo $skill->pk_skill_id; ?>">
                                                <a data-skill_id="<?php echo $skill->pk_skill_id; ?>" data-id="<?php echo $flag; ?>" class="hide_del del_skills">delete</a>
                                            </div>
                                            <?php
                                        }
                                        if ($skill_count > 0):
                                            echo '</div>';
                                        endif;
                                    else:
                                        ?>
                                        <div class="c_row">
                                            <div class="c_left" id="skill_1">
                                                <label>Skill 1*</label>
                                                <input type="text"  maxlength="300"  class="studentskill alltxtfield" placeholder="Type here" id="student_skill_1" name="student_skill_1">
                                                <input type="hidden" class="pk_skill_id" name="pk_skill_id_1" value="">
                                            </div>
                                            <div class="c_right"  id="skill_2">
                                                <label>Skill 2*</label>
                                                <input type="text"  maxlength="300"   class="studentskill alltxtfield" placeholder="Type here" id="student_skill_2" name="student_skill_2">
                                                <input type="hidden" class="pk_skill_id" name="pk_skill_id_2" value="">
                                            </div>
                                            <div class="c_left"  id="skill_3">
                                                <label>Skill 3*</label>
                                                <input type="text"  maxlength="300"  class="studentskill alltxtfield" placeholder="Type here" id="student_skill_3" name="student_skill_3">
                                                <input type="hidden" class="pk_skill_id" name="pk_skill_id_3" value="">
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="grey_row">
                                    <div class="grey_row_left">
                                        <button id="addstudentsskill" class="grey_btnnn"> + Add New Skill</button><span>Please complete the above fields and click save to continue to the next section.</span>
                                    </div>
                                    <div class="grey_row_right">
                                        <input type="submit" name="submit" id="submitstudentskill"  class="red_btn submitstudentskill" value="Save">
                                    </div>
                                </div>
                            </div>
                            <div class="skill_msg"></div>
                        </form>
                    </div>
                    <div class="panel panel-default">
                        <?php
                        if ($daatresult->workflow_status == 3 && $daatresult->membership_id == 3) {
                            $courses = $wpdb->get_results("SELECT * FROM course WHERE fk_package_id = '$completedpackage->id'");
                            $course_count = count($courses);
                        } else {
                            $courses = $wpdb->get_results("SELECT * FROM course WHERE fk_package_id = '$packageid'");
                            $course_count = count($courses);
                        }
                        ?>

                        <input type="hidden" id="addcourse" name="addcourse" value="<?php
                        if ($course_count > 0)
                            echo $course_count;
                        else
                            echo '3';
                        ?>">
                        <div class="panel-heading">

                            <h4 class="panel-title">
                                <a class="accordion-toggle cource accordion-toggle-styled collapsed green-border" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_6" >Courses and Certifications</a>
                            </h4>
                        </div>
                        <form method="post" id="studentcource"  name="resume" enctype="multipart/form-data" >
                            <div id="collapse_3_6" class="panel-collapse collapse " >
                                <div id="div_course_1" class="panel-body clsCourse">
                                    <?php
                                    if ($course_count > 0):
                                        $flag = 0;
                                        echo '<div class="c_row">';
                                        foreach ($courses as $course) {
                                            $flag++;
                                            if ($flag % 2 == 0) {
                                                $class = 'c_right';
                                            } else {
                                                $class = 'c_left';
                                            }
                                            ?>
                                            <div class="<?php echo $class; ?>"  id="course_<?php echo $flag; ?>">
                                                <label>Course <?php echo $flag; ?>*</label>
                                                <input maxlength="300" type="text" class="studentcourse studentname alltxtfield" placeholder="Type here" id="course_<?php echo $flag; ?>" name="course_<?php echo $flag; ?>" value="<?php echo $course->course; ?>">
                                                <input type="hidden" class="pk_course_id" name="pk_course_id_<?php echo $flag; ?>" value="<?php echo $course->pk_course_id; ?>">
                                                <a data-course_id="<?php echo $course->pk_course_id; ?>" data-id="<?php echo $flag; ?>" class="hide_del del_courses">delete</a>
                                            </div>
                                            <?php
                                        }
                                        if ($course_count > 0):
                                            echo '</div>';
                                        endif;
                                    else:
                                        ?>
                                        <div class="c_row">
                                            <div class="c_left"  id="course_1">
                                                <label>Course 1*</label>
                                                <input type="text" maxlength="300" class="studentcourse studentname alltxtfield" placeholder="Type here" id="course_1" name="course_1">
                                                <input type="hidden" class="pk_course_id" name="pk_course_id_1" value="">
                                            </div>
                                            <div class="c_right"  id="course_2">
                                                <label>Course 2*</label>
                                                <input type="text"  maxlength="300" class="studentcourse studentname alltxtfield" placeholder="Type here" id="course_2" name="course_2">
                                                <input type="hidden" class="pk_course_id" name="pk_course_id_2" value="">
                                            </div>
                                            <div class="c_left"  id="course_3">
                                                <label>Course 3*</label>
                                                <input type="text" maxlength="300"  class="studentcourse studentname alltxtfield" placeholder="Type here" id="course_3" name="course_3">
                                                <input type="hidden" class="pk_course_id" name="pk_course_id_3" value="">
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="grey_row">
                                    <div class="grey_row_left">
                                        <button id="addstudentscourse" class="grey_btnnn"> + Add New</button><span>Please complete the above fields and click save to continue to the next section.</span>
                                    </div>
                                    <div class="grey_row_right">
                                        <input type="submit" name="submit" id="submitstudentcourse"  class="red_btn submitstudentcourse" value="Save">
                                    </div>
                                </div>
                            </div>
                            <div class="course_msg"></div>
                        </form>
                    </div>
                    <div class="panel panel-default">
                        <?php
                        if ($daatresult->workflow_status == 3 && $daatresult->membership_id == 3) {
                            $softwares = $wpdb->get_results("SELECT * FROM knowledge_software WHERE fk_package_id = '$completedpackage->id'");
                            $software_count = count($softwares);
                        } else {
                            $softwares = $wpdb->get_results("SELECT * FROM knowledge_software WHERE fk_package_id = '$packageid'");
                            $software_count = count($softwares);
                        }
                        ?>

                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle software accordion-toggle-styled collapsed green-border" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_7" > Knowledge of Software </a>
                            </h4>
                        </div>
                        <form method="post" id="studentsoftware"  name="resume" enctype="multipart/form-data" >
                            <input type="hidden" id="addsoftware" name="addsoftware" value="<?php
                            if ($software_count > 0)
                                echo $software_count;
                            else
                                echo '3';
                            ?>">
                            <div id="collapse_3_7" class="panel-collapse collapse ">
                                <div id="div_software_1" class="panel-body Clssoftware">
                                    <?php
                                    if ($software_count > 0):
                                        echo '<div class="c_row">';
                                        $flag = 0;
                                        foreach ($softwares as $software) {
                                            $flag++;
                                            if ($flag % 2 == 0) {
                                                $class = 'c_right';
                                            } else {
                                                $class = 'c_left';
                                            }
                                            ?>
                                            <div class="<?php echo $class; ?>"  id="software_<?php echo $flag; ?>">
                                                <label>Software <?php echo $flag; ?>*</label>
                                                <input maxlength="300"  type="text" class="studentsoftware studentname alltxtfield" placeholder="Type here" id="software_<?php echo $flag; ?>" name="software_<?php echo $flag; ?>" value="<?php echo $software->software; ?>">
                                                <input type="hidden" class="pk_software_id" name="pk_software_id_<?php echo $flag; ?>" value="<?php echo $software->pk_software_id; ?>">
                                                <a data-sw_id="<?php echo $software->pk_software_id; ?>" data-id="<?php echo $flag; ?>" class="hide_del del_sw">delete</a>
                                            </div>

                                            <?php
                                        }
                                        if ($software_count > 0):
                                            echo '</div>';
                                        endif;
                                    else:
                                        ?>
                                        <div class="c_row">
                                            <div class="c_left" id="software_1">
                                                <label>Software 1*</label>
                                                <input maxlength="300"  type="text" class="studentsoftware studentname alltxtfield" placeholder="Type here" id="software_1" name="software_1">
                                                <input type="hidden" class="pk_software_id" name="pk_software_id_1" value="">
                                            </div>
                                            <div class="c_right" id="software_2">
                                                <label>Software 2*</label>
                                                <input maxlength="300"  type="text" class="studentsoftware studentname alltxtfield" placeholder="Type here" id="software_2" name="software_2">
                                                <input type="hidden" class="pk_software_id" name="pk_software_id_2" value="">
                                            </div>
                                            <div class="c_left" id="software_3">
                                                <label>Software 3*</label>
                                                <input maxlength="300"  type="text" class="studentsoftware studentname alltxtfield" placeholder="Type here" id="software_3" name="software_3">
                                                <input type="hidden" class="pk_software_id" name="pk_software_id_3" value="">
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="grey_row">
                                    <div class="grey_row_left">
                                        <button id="addstudentssoftware" class="grey_btnnn"> + Add New</button><span>Please complete the above fields and click save to continue to the next section.</span>
                                    </div>
                                    <div class="grey_row_right">
                                        <input type="submit" name="submit" id="submitstudentsoftwareknowledge"  class="red_btn submitstudentsoftwareknowledge" value="Save">
                                    </div>
                                </div>
                            </div>
                            <div class="software_msg"></div>
                        </form>
                    </div>

                    <div class="panel panel-default">
                        <?php
                        if ($daatresult->workflow_status == 3 && $daatresult->membership_id == 3) {
                            $honors = $wpdb->get_results("SELECT * FROM honor WHERE fk_package_id = '$completedpackage->id'");
                            $honor_count = count($honors);
                        } else {
                            $honors = $wpdb->get_results("SELECT * FROM honor WHERE fk_package_id = '$packageid'");
                            $honor_count = count($honors);
                        }
                        ?>
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle honor accordion-toggle-styled collapsed green-border" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_8" > Honors </a>
                            </h4>
                        </div>
                        <form method="post" id="studenthonor"  name="resume" enctype="multipart/form-data" >
                            <input type="hidden" id="addhonor" name="addhonor" value="<?php
                            if ($honor_count > 0)
                                echo $honor_count;
                            else
                                echo '3';
                            ?>">
                            <div id="collapse_3_8" class="panel-collapse collapse " >
                                <div id="div_honor_1" class="panel-body Clshonor">

                                    <?php
                                    if ($honor_count > 0):
                                        $flag = 0;
                                        echo '<div class="c_row">';
                                        foreach ($honors as $honor) {
                                            $flag++;
                                            if ($flag % 2 == 0) {
                                                $class = 'c_right';
                                            } else {
                                                $class = 'c_left';
                                            }
                                            ?>
                                            <div class="<?php echo $class; ?>" id="honor_<?php echo $flag; ?>">
                                                <label>Honor <?php echo $flag; ?>*</label>
                                                <input type="text" maxlength="300" class="studenthonor studentname alltxtfield" placeholder="Type here" id="honor_<?php echo $flag; ?>" name="honor_<?php echo $flag; ?>" value="<?php echo $honor->honor; ?>">
                                                <input type="hidden" class="pk_honor_id" name="pk_honor_id_<?php echo $flag; ?>" value="<?php echo $honor->pk_honor_id; ?>">
                                                <a data-honor_id="<?php echo $honor->pk_honor_id; ?>" data-id="<?php echo $flag; ?>" class="hide_del del_honors">delete</a>
                                            </div>

                                            <?php
                                        }
                                        if ($honor_count > 0):
                                            echo '</div>';
                                        endif;
                                    else:
                                        ?>
                                        <div  class="c_row">
                                            <div class="c_left" id="honor_1">
                                                <label>Honor 1*</label>
                                                <input type="text" maxlength="300" class="studenthonor studentname alltxtfield" placeholder="Type here" id="honor_1" name="honor_1">
                                                <input type="hidden" class="pk_honor_id" name="pk_honor_id_1" value="">
                                            </div>
                                            <div class="c_right"id="honor_2">
                                                <label>Honor 2*</label>
                                                <input type="text" maxlength="300" class="studenthonor studentname alltxtfield" placeholder="Type here" id="honor_2" name="honor_2">
                                                <input type="hidden" class="pk_honor_id" name="pk_honor_id_2" value="">
                                            </div>
                                            <div class="c_left" id="honor_3">
                                                <label>Honor 3*</label>
                                                <input type="text" maxlength="300" class="studenthonor studentname alltxtfield" placeholder="Type here" id="honor_3" name="honor_3">
                                                <input type="hidden" class="pk_honor_id" name="pk_honor_id_3" value="">
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="grey_row">
                                    <div class="grey_row_left">
                                        <button id="addstudentshonor" class="grey_btnnn"> + Add New</button><span>Please complete the above fields and click save to continue to the next section.</span>
                                    </div>
                                    <div class="grey_row_right">
                                        <input type="submit" name="submit" id="submitstudenthonor"  class="red_btn submitstudenthonor" value="Save">
                                    </div>
                                </div>
                            </div>
                            <div class="honor_msg"></div>
                        </form>
                    </div>
                    <div class="panel panel-default">
                        <?php
                        if ($daatresult->workflow_status == 3 && $daatresult->membership_id == 3) {
                            $activitys = $wpdb->get_results("SELECT * FROM activity WHERE fk_package_id = '$completedpackage->id'");
                            $activity_count = count($activitys);
                        } else {
                            $activitys = $wpdb->get_results("SELECT * FROM activity WHERE fk_package_id = '$packageid'");
                            $activity_count = count($activitys);
                        }
                        ?>
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle activity accordion-toggle-styled collapsed green-border" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_9" > Activities </a>
                            </h4>
                        </div>
                        <form method="post" id="studentactivity"  name="resume" enctype="multipart/form-data">
                            <input type="hidden" id="addactivity" name="addactivity" value="<?php
                            if ($activity_count > 0)
                                echo $activity_count;
                            else
                                echo '3';
                            ?>">
                            <div id="collapse_3_9" class="panel-collapse collapse " >
                                <div id="div_activity_1" class="panel-body Clsactivity">
                                    <?php
                                    if ($activity_count > 0):
                                        $flag = 0;
                                        echo '<div class="c_row">';
                                        foreach ($activitys as $activity) {
                                            $flag++;
                                            if ($flag % 2 == 0) {
                                                $class = 'c_right';
                                            } else {
                                                $class = 'c_left';
                                            }
                                            ?>
                                            <div class="<?php echo $class; ?>" id="activity_<?php echo $flag; ?>">
                                                <label>Activity <?php echo $flag; ?>*</label>
                                                <input maxlength="300" type="text" class="studentactivities studentname alltxtfield" placeholder="Type here" id="activity_<?php echo $flag; ?>" name="activity_<?php echo $flag; ?>" value="<?php echo $activity->activity; ?>">
                                                <input type="hidden" class="pk_activity_id" name="pk_activity_id_<?php echo $flag; ?>" value="<?php echo $activity->pk_activity_id; ?>">
                                                <a data-activity_id="<?php echo $activity->pk_activity_id; ?>" data-id="<?php echo $flag; ?>" class="hide_del del_activities">delete</a>
                                            </div>
                                            <?php
                                        }
                                        if ($activity_count > 0):
                                            echo '</div>';
                                        endif;
                                    else:
                                        ?>
                                        <div  class="c_row">
                                            <div class="c_left" id="activity_1">
                                                <label>Activity 1*</label>
                                                <input type="text" maxlength="300" class="studentactivities studentname alltxtfield" placeholder="Type here" id="activity_1" name="activity_1">
                                                <input type="hidden" class="pk_activity_id" name="pk_activity_id_1" value="">
                                            </div>
                                            <div class="c_right" id="activity_2">
                                                <label>Activity 2*</label>
                                                <input type="text" maxlength="300" class="studentactivities studentname alltxtfield" placeholder="Type here" id="activity_2" name="activity_2">
                                                <input type="hidden" class="pk_activity_id" name="pk_activity_id_2" value="">
                                            </div>
                                            <div class="c_left" id="activity_3">
                                                <label>Activity 3*</label>
                                                <input type="text" maxlength="300" class="studentactivities studentname alltxtfield" placeholder="Type here" id="activity_3" name="activity_3">
                                                <input type="hidden" class="pk_activity_id" name="pk_activity_id_3" value="">
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="grey_row">
                                    <div class="grey_row_left">
                                        <button id="addstudentsactivity" class="grey_btnnn"> + Add New</button><span>Please complete the above fields and click save to continue to the next section.</span>
                                    </div>
                                    <div class="grey_row_right">
                                        <input type="submit" name="submit" id="submitstudenactivity"  class="red_btn submitstudenactivity" value="Save">
                                    </div>
                                </div>
                            </div>
                            <div class="activity_msg"></div>
                        </form>
                    </div>
                    <div class="panel panel-default">
                        <?php
                        if ($daatresult->workflow_status == 3 && $daatresult->membership_id == 3) {
                            $interests = $wpdb->get_results("SELECT * FROM interests WHERE fk_package_id = '$completedpackage->id'");
                            $interest_count = count($interests);
                        } else {
                            $interests = $wpdb->get_results("SELECT * FROM interests WHERE fk_package_id = '$packageid'");
                            $interest_count = count($interests);
                        }
                        ?>
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle  interest accordion-toggle-styled collapsed green-border" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_10" > Interests </a>
                            </h4>
                        </div>
                        <form method="post" id="studentinterest"  name="resume" enctype="multipart/form-data">
                            <input type="hidden" id="addinterest" name="addinterest" value="<?php
                            if ($interest_count > 0)
                                echo $interest_count;
                            else
                                echo '3';
                            ?>">
                            <div id="collapse_3_10" class="panel-collapse collapse " >
                                <div id="div_interest_1" class="panel-body Clsinterest">
                                    <?php
                                    if ($interest_count > 0) {
                                        echo '<div class="c_row">';
                                        $flag = 0;
                                        foreach ($interests as $interest) {
                                            $flag++;
                                            if ($flag % 2 == 0) {
                                                $class = 'c_right';
                                            } else {
                                                $class = 'c_left';
                                            }
                                            ?>
                                            <div class="<?php echo $class; ?>"  id="interest_<?php echo $flag; ?>">
                                                <label>Interest <?php echo $flag; ?>*</label>
                                                <input type="text" maxlength="300"  class="studentinterest studentname alltxtfield " placeholder="Type here" id="interests_<?php echo $flag; ?>" name="interests_<?php echo $flag; ?>" value="<?php echo $interest->interests; ?>">
                                                <input type="hidden" class="pk_interest_id" name="pk_interest_id_<?php echo $flag; ?>" value="<?php echo $interest->pk_interest_id; ?>">
                                                <a data-interest_id="<?php echo $interest->pk_interest_id; ?>" data-id="<?php echo $flag; ?>" class="hide_del del_interests">delete</a>
                                            </div>

                                            <?php
                                        }
                                        if ($interest_count > 0):
                                            echo '</div>';
                                        endif;
                                    }else {
                                        ?>
                                        <div class="c_row">
                                            <div class="c_left">
                                                <label>Interest 1*</label>
                                                <input type="text" maxlength="300" class="studentinterest studentname alltxtfield" placeholder="Type here" id="interests_1" name="interests_1">
                                                <input type="hidden" class="pk_interest_id" name="pk_interest_id_1" value="">
                                            </div>
                                            <div class="c_right">
                                                <label>Interest 2*</label>
                                                <input type="text" maxlength="300" class="studentinterest studentname alltxtfield" placeholder="Type here" id="interests_2" name="interests_2">
                                                <input type="hidden" class="pk_interest_id" name="pk_interest_id_2" value="">
                                            </div>
                                            <div class="c_left">
                                                <label>Interest 3*</label>
                                                <input type="text"  maxlength="300" class="studentinterest studentname alltxtfield" placeholder="Type here" id="interests_3" name="interests_3">
                                                <input type="hidden" class="pk_interest_id" name="pk_interest_id_3" value="">
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="grey_row">
                                    <div class="grey_row_left">
                                        <button id="addstudentsinterest"  class="grey_btnnn"> + Add New</button><span>Please complete the above fields and click save to continue to the next section.</span>
                                    </div>
                                    <div class="grey_row_right">
                                        <input type="submit" name="submit" id="submitstudeinterest"  class="red_btn submitstudeinterest" value="Save">
                                    </div>
                                </div>
                            </div>
                            <div class="interest_msg"></div>
                        </form>
                    </div>

                    <div class="panel panel-default">
                        <?php
                        if ($daatresult->workflow_status == 3 && $daatresult->membership_id == 3) {
                            $references = $wpdb->get_results("SELECT * FROM `references` WHERE `fk_package_id` = $completedpackage->id");
                            $reference_count = count($references);
                        } else {
                            $references = $wpdb->get_results("SELECT * FROM `references` WHERE `fk_package_id` = $packageid");
                            $reference_count = count($references);
                        }
                        ?>
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle references accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_11" > References </a>
                            </h4>
                        </div>
                        <form method="post" id="studentreferences"  name="resume" enctype="multipart/form-data" >
                            <input type="hidden" id="addreferences" name="addreferences" value="<?php
                            if ($reference_count > 0)
                                echo $reference_count;
                            else
                                echo '2';
                            ?>">
                            <div id="collapse_3_11" class="panel-collapse collapse" >
                                <div id="div_references_1" class="panel-body Clsreferences">
                                    <?php
                                    if ($reference_count > 0):
                                        echo '<div class="c_row">';
                                        $flag = 0;
                                        foreach ($references as $reference) {
                                            $flag++;
                                            if ($flag % 2 == 0) {
                                                $class = 'c_right';
                                            } else {
                                                $class = 'c_left';
                                            }
                                            ?>
                                            <div class="<?php echo $class; ?> others_text" id="referenc_<?php echo $flag; ?>">
                                                <label>Reference <?php echo $flag; ?>*</label>
                                                <textarea id="references_<?php echo $flag; ?>" maxlength="300" class="studentreferences studentname" name="references_<?php echo $flag; ?>"><?php echo $reference->details; ?></textarea>
                                                <input type="hidden" class="pk_reference_id" name="pk_reference_id_<?php echo $flag; ?>" value="<?php echo $reference->pk_reference_id; ?>">
                                                <a data-ref_id="<?php echo $reference->pk_reference_id; ?>" data-id="<?php echo $flag; ?>" class="hide_del del_ref">delete</a>
                                            </div>
                                            <?php
                                        }
                                        if ($reference_count > 0):
                                            echo '</div>';
                                        endif;
                                    else:
                                        ?>
                                        <div class="c_row">
                                            <div class="c_left others_text" id="referenc_1">
                                                <label>Reference 1*</label>
                                                <textarea id="references_1" maxlength="300" class="studentreferences studentname" name="references_1"></textarea>
                                                <input type="hidden" class="pk_reference_id" name="pk_reference_id_1" value="">
                                            </div>
                                            <div class="c_right others_text" id="referenc_2">
                                                <label>Reference 2*</label>
                                                <textarea  id="references_2" maxlength="300" class="studentreferences studentname" name="references_2"></textarea>
                                                <input type="hidden" class="pk_reference_id" name="pk_reference_id_2" value="">
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="grey_row">
                                    <div class="grey_row_left">
                                        <button id="addnewrefernces" class="grey_btnnn"> + Add New</button>
                                        <span>Please complete the above fields and click save. </span>
                                    </div>
                                    <div class="grey_row_right">
                                        <input type="submit" name="submit" id="submitstudentreferences"  class="red_btn submitstudentreferences" value="Save">
                                    </div>
                                </div>
                            </div>
                            <div class="references_msg"></div>
                        </form>
                    </div>
                </div>
                <div class="submit_btnn workf_form">
                    <?php if ($packageobj->workflow_status == 4 && $packageobj->is_submit == 1):
                        ?>
                        <input type="submit" name="submit" id="submitresumeforms"  class="red_btn gray_btn submitresumeforms" value="Waiting on Reviewer">
                    <?php else: ?>
                        <input type="submit" name="submit" id="submitresumeforms"  class="red_btn right_btn submitresumeforms" value="Submit for Review">
                    <?php endif; ?>
                </div>
                <div class="fsub_msg"></div>
            </div>
        </div>
    </div>
    <?php
    if ($packageobj->workflow_status == 5 || $packageobj->workflow_status == 4) {
        ?>
        <div class="workspace_mainsuper_right">
            <div id="comment_scroll_id" class="comment_scroll_id">
                <div class="comment_box_main">
                    <div class="comment_box_main_title">
                        <h2>Comment Box</h2>
                    </div>
                    <div class="comment_box_main_content">
                        <?php
                        $comments = $wpdb->get_results("SELECT * FROM comments WHERE package_id = '$packageid'");

                        foreach ($comments as $comment) {
                            if ($comment->sender_id == $current_user->ID) {
                                $chat_class = "chat_left";
                            } else {
                                $chat_class = "chat_right";
                            }
                            ?>
                            <div class="<?php echo $chat_class; ?>">
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
                        <?php } ?>
                    </div>
                    <?php
                    if ($packageobj->workflow_status == 4) {
                        $class = "readonly_fields";
                    }
                    ?>
                    <div class="chat_form ">
                        <textarea placeholder="Type here" id="comment"></textarea>
                        <input type="submit" value="submit" class="red_btn" id="add_student_comment">
                        <div class="msg"></div>
                        <input type="hidden" id="comment_flag" />
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
<?php endif; ?>

<?php get_footer('dashboard'); ?>