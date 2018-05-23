<?php
/*
  Template Name: Preview Resume
 */
?>
<?php if (!is_user_logged_in()): ?>
    <script>window.location.href = "<?php echo site_url(); ?>";</script>
<?php endif; ?>
<?php if (!$_REQUEST['id']): ?>
    <script>window.location.href = "<?php echo site_url(); ?>";</script>
<?php endif; ?>
<?php
$package_id = $_REQUEST['id'];

//Change job status
if (isset($_REQUEST['get_job'])) {
    $job = $_REQUEST['job'];
    $update = $wpdb->update(
            'wp_pmpro_membership_orders', array(
        'job_status' => $job,
            ), array('id' => $package_id)
    );
}

$packageobj = $wpdb->get_row("SELECT * FROM $wpdb->pmpro_membership_orders WHERE id = '$package_id' LIMIT 1");
if (!$_REQUEST['id'] || !$packageobj):
    ?>
    <script>window.location.href = "<?php echo site_url(); ?>";</script>
<?php endif; ?>

<?php get_header('dashboard'); ?>
<section class="resume_section preview reviewer_resume_section">                       
    <div class="row">                    
        <div class="col-sm-12"> 
            <h1 class="entry-title"><?php echo $packageobj->name; ?></h1>
        </div>
    </div>
    <div class="">
        <?php
        $profile_pic = get_user_meta($packageobj->user_id, 'profile_image', TRUE);
        if ($profile_pic):
            $profile_calss = "resume_img_text";
            ?>
            <div class="resume_img">
                <img src="<?php echo $profile_pic; ?>" />
            </div>
            <?php
        else:
            $profile_calss = "col-sm-12";
        endif;
        ?>
        <div class="<?php echo $profile_calss; ?>">
            <p>Degree: <?php echo $packageobj->degree; ?></p>
            <p>School: <?php echo $packageobj->school; ?></p>
            <?php if ($packageobj->city): ?>
                <p>City: <?php echo $packageobj->city; ?></p>
            <?php endif; ?>
            <p>Graduation Date: <?php echo date("F d, Y", strtotime($packageobj->graduation_date)); ?></p>
            <?php if ($packageobj->linkedin): ?>
                <a target="_blank" href="<?php echo $packageobj->linkedin; ?>" class="pdf_a">LinkedIn</a>
            <?php endif; ?>
            <?php
            if ($packageobj->resume_pdf) {
                $uploads = wp_upload_dir();
                $upload_path = $uploads['baseurl'];
                $name = $packageobj->name . '_resume.pdf';
                echo '<a title="' . $name . '" download="' . $name . '"   href="' . $upload_path . '/resumes/' . $packageobj->resume_pdf . '" class="pdf_a">Resume pdf</a>';
            }
            ?>
            <p>Cell Phone: <a href="tel:<?php echo $packageobj->phone; ?>"><?php echo $packageobj->phone; ?></a></p>
            <p>Email: <a href="mail:<?php echo $packageobj->email; ?>"><?php echo $packageobj->email; ?></a></p>
            <p>Endorsement: <?php echo $packageobj->endorsement; ?></p>
        </div>
    </div>
    <?php if ($packageobj->jobdescription != ''): ?>         
        <p><?php echo $packageobj->jobdescription; ?></p>          
    <?php endif; ?>
    <?php if ($packageobj->goals != ''): ?>
        <!--        <div class="w_revised">
                    <h3>Objective: <?php echo $packageobj->goals; ?></h3>
                </div>-->
    <?php endif; ?>
    <!------------------Few things about me ---------------->
    <?php
    $abouts = $wpdb->get_results("SELECT about_things FROM about_student WHERE fk_package_id = '$package_id'");
    if ($abouts):
        ?>
        <div class="project few_text">
            <h4 class="panel-title">A few things you should know about me:</h4>
            <ul class="resume_detail">
                <?php foreach ($abouts as $about) { ?>
                    <?php if ($about->about_things) { ?>
                        <li><?php echo $about->about_things; ?></li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </div>
    <?php endif; ?>
    <!------------------ Projects ---------------->
    <?php
    $projects = $wpdb->get_results("SELECT * FROM projects WHERE fk_package_id = '$package_id'");
    $project_count = count($projects);
    if ($project_count) {
        ?>
        <div class="project project_text">
            <h4 class="panel-title">Projects:</h4>
            <?php
            $count = 0;
            foreach ($projects as $project) {
                $count++;
                ?>
                <div class="project_detail kane_text">
                    <div class="col-sm-8">
                        <h4 class="panel-title"><?php echo $project->project_title; ?></h4>
                        <div class="detail">
                            <h6>Objective:</h6>
                            <ul class="resume_detail">
                                <li><?php echo $project->objective; ?></li>
                            </ul>
                        </div>
                        <div class="detail">
                            <h6>Background:</h6>
                            <ul class="resume_detail">
                                <li><?php echo $project->background; ?></li>
                            </ul>
                        </div>
                        <div class="detail">
                            <h6>Execution:</h6>
                            <ul class="resume_detail">
                                <li><?php echo $project->execution; ?></li>
                            </ul>
                        </div>
                        <div class="detail">
                            <h6>Results:</h6>
                            <ul class="resume_detail">
                                <li><?php echo $project->results; ?></li>
                            </ul>
                        </div>
                    </div>

                    <?php
                    if ($project->file_input) {
                        $uploads = wp_upload_dir();
                        $upload_path = $uploads['baseurl'];
                        if ($project->original_name)
                            $file_name = $project->original_name;
                        else
                            $file_name = $project->file_input;
                        ?>
                        <div class="col-sm-4">
                            <img src="<?php echo $upload_path . '/projects/' . $project->file_input; ?>" alt="<?php echo $file_name; ?>" />
                        </div>
                    <?php } ?>

                </div>
            <?php } ?>
        </div>
    <?php } ?>
    <div class="clearfix"></div>
    <!------------------ Work Experience(s) ---------------->
    <?php
    $works = $wpdb->get_results("SELECT * FROM work_experience WHERE fk_package_id = '$package_id'");
    $work_count = count($works);
    if ($work_count):
        ?>
        <div class="project">              
            <h4 class="panel-title">Work Experience:</h4>
            <?php
            $count = 0;
            foreach ($works as $work) {
                $count++;
                ?>
                <div class="project_detail">
                    <div class="detail">
                        <h6><?php echo $work->title . ', ' . $work->company . ', ' . $work->city . ', ' . $work->state . ' ' . $work->years.' years'; ?></h6>
                        <ul class="resume_detail">
                            <li><?php echo $work->description; ?></li>
                            <li><?php echo $work->years.' years'; ?></li>
                        </ul>
                    </div>                      
                </div>
            <?php } ?>
        </div>
    <?php endif; ?>

    <!------------------ Skills ---------------->
    <?php
    $skills = $wpdb->get_results("SELECT * FROM skills WHERE fk_package_id = '$package_id'");
    if ($skills):
        ?> 
        <div class="project">
            <h4 class="panel-title">Skills:</h4>
            <ul class="resume_detail">
                <?php foreach ($skills as $skill) { ?>
                    <?php if ($skill->skill) { ?>
                        <li><?php echo $skill->skill; ?></li>
                    <?php } ?>  
                <?php } ?>   
            </ul>
        </div>                                     
    <?php endif; ?>

    <!------------------ Courses and Certifications ---------------->
    <?php
    $courses = $wpdb->get_results("SELECT * FROM course WHERE fk_package_id = '$package_id'");
    if ($courses):
        ?>
        <div class="project">
            <h4 class="panel-title">Courses and Certifications:</h4>
            <ul class="resume_detail">
                <?php foreach ($courses as $course) { ?>
                    <?php if ($course->course) { ?>
                        <li><?php echo $course->course; ?></li>
                    <?php } ?>  
                <?php } ?>   
            </ul>
        </div>  
    <?php endif; ?>

    <!------------------ Knowledge and Software ---------------->
    <?php
    $softwares = $wpdb->get_results("SELECT * FROM knowledge_software WHERE fk_package_id = '$package_id'");
    if ($softwares):
        ?>
        <div class="project">
            <h4 class="panel-title"> Knowledge of Software:</h4>
            <ul class="resume_detail">
                <?php foreach ($softwares as $software) { ?>
                    <?php if ($software->software) { ?>
                        <li><?php echo $software->software; ?></li>
                    <?php } ?>  
                <?php } ?>   
            </ul>
        </div>  
    <?php endif; ?>

    <!------------------ Honors ---------------->
    <?php
    $honors = $wpdb->get_results("SELECT * FROM honor WHERE fk_package_id = '$package_id'");
    if ($honors):
        ?>
        <div class="project">
            <h4 class="panel-title">Honors:</h4>
            <ul class="resume_detail">
                <?php foreach ($honors as $honor) { ?>
                    <?php if ($honor->honor) { ?>
                        <li><?php echo $honor->honor; ?></li>
                    <?php } ?>  
                <?php } ?>   
            </ul>
        </div>
    <?php endif; ?>

    <!------------------ Activities ---------------->
    <?php
    $activitys = $wpdb->get_results("SELECT * FROM activity WHERE fk_package_id = '$package_id'");
    if ($activitys):
        ?>
        <div class="project">
            <h4 class="panel-title">Activities:</h4>
            <ul class="resume_detail">
                <?php foreach ($activitys as $activity) { ?>
                    <?php if ($activity->activity) { ?>
                        <li><?php echo $activity->activity; ?></li>
                    <?php } ?>  
                <?php } ?>   
            </ul>
        </div>
    <?php endif; ?>

    <!------------------ Interests ---------------->
    <?php
    $interests = $wpdb->get_results("SELECT * FROM interests WHERE fk_package_id = '$package_id'");
    if ($interests):
        ?>
        <div class="project">
            <h4 class="panel-title">Interests:</h4>
            <ul class="resume_detail">
                <?php foreach ($interests as $interest) { ?>
                    <?php if ($interest->interests) { ?>
                        <li><?php echo $interest->interests; ?></li>
                    <?php } ?>  
                <?php } ?>   
            </ul>
        </div>
    <?php endif; ?>

    <!------------------ References ---------------->
    <?php
    $references = $wpdb->get_results("SELECT * FROM `references` WHERE `fk_package_id` = $package_id");
    if ($references):
        ?>
        <div class="project">
            <h4 class="panel-title"> References:</h4>
            <ul class="resume_detail">
                <?php foreach ($references as $reference) { ?>
                    <?php if ($reference->details) { ?>
                        <li><?php echo $reference->details; ?></li>
                    <?php } ?>  
                <?php } ?>   
            </ul>
        </div>                 
    <?php endif; ?>
    <div class="project">
        <h4 class="panel-title">I look forward to meeting you.</h4>
        <p><?php echo $packageobj->name; ?></p>
        <?php if ($packageobj->city): ?>
            <p><?php echo $packageobj->city; ?></p>
        <?php endif; ?>
        <p>Phone: <a href="tel:<?php echo $packageobj->phone; ?>"><?php echo $packageobj->phone; ?></a></p>
        <p>Email: <a href="mail:<?php echo $packageobj->email; ?>"><?php echo $packageobj->email; ?></a></p>
        <?php
        if ($packageobj->resume_pdf) {
            $uploads = wp_upload_dir();
            $upload_path = $uploads['baseurl'];
            $name = $packageobj->name . '_resume.pdf';
            echo '<a title="' . $name . '" download="' . $name . '"   href="' . $upload_path . '/resumes/' . $packageobj->resume_pdf . '" class="pdf_a">Resume pdf</a>';
        }
        ?>  
    </div>    
    <p class="thank_text">Thank you for taking the time to review my resume.</p>
     <?php
    if ($packageobj->workflow_status == 6 && $packageobj->user_id == $current_user->ID) {
        ?>
        <form method="POST" >
            <div class="job">
                <p>Received a job?</p>
                <input type="hidden" name="id" value="<?php echo $packageobj->id; ?>">
                <input type="radio" name="job" value="Yes" <?php if ($packageobj->job_status == 'Yes') echo 'checked' ?> >Yes
                <input type="radio" name="job" value="No" <?php if ($packageobj->job_status == 'No') echo 'checked' ?>>No
                <input type="submit" value="Save" name="get_job" id="get_job">
            </div>
        </form>
        <?php
    }
    ?>
</section>
<?php get_footer('dashboard'); ?>   