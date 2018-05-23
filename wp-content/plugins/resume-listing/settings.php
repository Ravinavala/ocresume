<?php
/*
  Template Name:  settings
 */
?>
<?php
global $wpdb;
if (isset($_REQUEST['id'])) {
    $statusid = $_REQUEST['id'];
    $selecteddata = $wpdb->get_results("SELECT * FROM wp_workflow_status WHERE pk_status_id = '$statusid' ");
    ?>
    <div class="student_resume_list">
        <span>Edit Workflow Status</span>
    </div>
    <form id="staus-form" action="<?php echo site_url(); ?>/wp-admin/admin.php?page=mt-sublevel-page-settings" method="post">
        <input type="hidden" name="hdn" id="hdn" value="<?php echo $selecteddata[0]->pk_status_id; ?>">
        <div class="c_row">
            <div class="c_left">
                <label>Status*</label>
                <input type="text" class="alltxtfield" id="workflowstatus" name="workflowstatus" maxlength="200" placeholder="Type here" value="<?php echo $selecteddata[0]->status_name; ?>">
            </div>
            <div class="grey_row">
                <div class="grey_row_right">
                    <input type="submit" name="submit" id="submitstatus"  class="submitstatus" value="Save">
                </div>
            </div>
        </div>
        <div class="about_msg"></div>
    </form>
<?php } ?>
<form id="staus-form" action="" method="post" style='display:none;'>
    <title>Workflow Status</title>
    <input type="hidden" name="hdn" id="hdn" value="<?php echo $selecteddata[0]->pk_status_id; ?>">
    <div class="c_row">
        <div class="c_left">
            <label>Status*</label>
            <input type="text" class="alltxtfield" id="workflowstatus" name="workflowstatus" maxlength="200" placeholder="Type here">
        </div>
        <div class="grey_row">
            <div class="grey_row_right">
                <input type="submit" name="submit" id="submitstatus"  class="submitstatus" value="Save">
            </div>
        </div>
    </div>
    <div class="about_msg"></div>
</form>
<?php
global $wpdb;
$workflowstatus = $_POST['workflowstatus'];
$statusid = $_POST['hdn'];
if ($workflowstatus != '' && $statusid == '') {

    $data = $wpdb->insert(
            'wp_workflow_status', array(
        'status_name' => $workflowstatus,
            )
    );

    if ($data != 1) {
        echo '<span class="text-danger about_msg1"> not Saved successfully....</span>';
    } else {

        echo '<span class="text-success about_msg1">Saved successfully....</span>';
    }
} else if ($workflowstatus != '' && $statusid != '') {

    $updatedata = $wpdb->update(
            'wp_workflow_status', array(
        'status_name' => $workflowstatus,
            ), array(
        'pk_status_id' => $statusid,
            )
    );

    if ($updatedata == False) {
        echo '<span class="text-success about_msg1"> same data has been saved successfully....</span>';
    } else if ($updatedata != 1) {
        echo '<span class="text-danger about_msg1"> not Saved Successfully....</span>';
    } else {
        echo '<span class="text-success about_msg1">Saved successfully....</span>';
    }
}
?>

<div class="student_resume_list" id="status_list">
    <h1>Status Lists</h1> <input type="button" name="submit" id="addnewbutton"  class="addnewbutton" value="Add New Status">
    <?php
    $workflows = $wpdb->get_results("SELECT * FROM wp_workflow_status");

    if ($workflows != 0) {
        ?>

        <table class="table">

            <thead>

                <tr>

                    <th>Status</th>

                    <th>Action</th>

                </tr>

            </thead>

            <tbody>

                <?php foreach ($workflows as $workflow) { ?>

                    <tr>

                        <td><?php echo $workflow->status_name; ?></td>

                        <td><a href="<?php echo site_url(); ?>/wp-admin/admin.php?page=mt-sublevel-page-settings&id=<?php echo $workflow->pk_status_id; ?>" class="editstatus">Edit</a></td>

                    </tr>

                <?php } ?>

            </tbody>

        </table>

        <?php
    } else {

        echo '<h1>No Status Founds</h1>';
    }
    ?>

</div>

<script>

    jQuery(document).ready(function () {
        jQuery('#addnewbutton').click(function (event) {

            jQuery("#status_list").hide();

            jQuery("#staus-form").show();

        });

        jQuery(document).on("click", ".submitstatus", function () {
            debugger;
            jQuery('.text-danger').remove();
            var workflowstatus = jQuery('#workflowstatus').val();

            var flage = true;
            if (workflowstatus == '') {
                jQuery('#workflowstatus').after('<label class="text-danger">The field is required.</label>');
                flage = false;
            }

            if (flage == true) {
                jQuery('.text-danger').remove();
                return true;
            } else {
                return false;
            }
        });
        jQuery(".about_msg1").fadeOut(5000);

    });
</script>