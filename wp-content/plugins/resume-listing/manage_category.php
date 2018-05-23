<?php
/*
  Template Name:  settings
 */
?>
<?php
global $wpdb;
if (isset($_REQUEST['id'])) {
    $category_id = $_REQUEST['id'];
    $category_data = $wpdb->get_row("SELECT * FROM wp_resume_category WHERE category_id = '$category_id' LIMIT 1 ");
    if ($_REQUEST['action'] == 'edit') {
        ?>
        <div class="student_resume_list">
            <span>Edit Resume Category</span>
        </div>
        <form id="staus-form" action="<?php echo site_url(); ?>/wp-admin/admin.php?page=resume-category" method="post">
            <input type="hidden" name="cat_id" id="cat_id" value="<?php echo $category_data->category_id; ?>">
            <div class="c_row">
                <div class="c_left">
                    <label>Category*</label>
                    <input type="text" class="alltxtfield" id="resume_cat" name="resume_cat" maxlength="200" placeholder="Type here" value="<?php echo $category_data->category_name; ?>">
                </div>
                <div class="grey_row">
                    <div class="grey_row_right">
                        <input type="submit" name="submit_cat" id="submit_cat"  class="submitstatus" value="Save">
                    </div>
                </div>
            </div>
            <div class="cat_msg"></div>
        </form>
        <?php
    } else {
        ?>
        <form id="del_cat" action="<?php echo site_url(); ?>/wp-admin/admin.php?page=resume-category" method="post">
            <input type="hidden" name="cat_id" id="cat_id" value="<?php echo $category_data->category_id; ?>">
            <div class="c_row">
                <p> Are you sure to delete <?php echo $category_data->category_name; ?>?</p>
                <input type="submit" value="Yes" id="del_cat" name="del_cat" >
                <input type="submit" value="No" name="cancel_del"  id="cancel_del">
            </div>
            <div class="cat_msg"></div>
        </form>
        <?php
    }
}
?>
<form id="staus-form" action="" method="post" style='display:none;'>
    <input type="hidden" name="cat_id" id="cat_id" value="">
    <h3>Resume Category</h3>
    <div class="c_row">
        <div class="c_left">
            <label>Category*</label>
            <input type="text" class="alltxtfield" id="resume_cat" name="resume_cat" maxlength="200" placeholder="Type here">
        </div>
        <div class="grey_row">
            <div class="grey_row_right">
                <input type="submit" name="submit_cat"  id="submit_cat"  class="submitstatus" value="Save">
            </div>
        </div>
    </div>
    <div class="cat_msg"></div>
</form>

<?php
if (isset($_POST['del_cat'])) {
    global $wpdb;
    $cat_id = $_POST['cat_id'];
    $data = $wpdb->delete(wp_resume_category, array('category_id' => $cat_id));
    if ($data != 1) {
        echo '<span class="text-danger cat_msg1">Not Deleted</span>';
    } else {

        echo '<span class="text-success cat_msg1">Deleted successfully....</span>';
    }
}
if (isset($_POST['submit_cat'])) {
    global $wpdb;
    $resume_cat = $_POST['resume_cat'];
    $cat_id = $_POST['cat_id'];
    if ($resume_cat != '' && $cat_id == '') {
        $data = $wpdb->insert(
                'wp_resume_category', array(
            'category_name' => $resume_cat,
                )
        );
        if ($data != 1) {
            echo '<span class="text-danger cat_msg1"> not Saved successfully....</span>';
        } else {

            echo '<span class="text-success cat_msg1">Saved successfully....</span>';
        }
    } else if ($resume_cat != '' && $cat_id != '') {
        $updatedata = $wpdb->update(
                'wp_resume_category', array(
            'category_name' => $resume_cat,
                ), array(
            'category_id' => $cat_id,
                )
        );
        if ($updatedata == False) {
            echo '<span class="text-success about_msg1">Saved successfully....</span>';
        } else if ($updatedata != 1) {
            echo '<span class="text-danger about_msg1"> not Saved Successfully....</span>';
        } else {
            echo '<span class="text-success about_msg1">Saved successfully....</span>';
        }
    }
}
?>

<div class="student_resume_list" id="status_list">
    <h1>Categories</h1> 
    <input type="button" name="submit" id="addnewbutton"  class="addnewbutton" value="Add New Category">
    <?php
    $categories = $wpdb->get_results("SELECT * FROM wp_resume_category");
    if ($categories) {
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category) { ?>
                    <tr>
                        <td><?php echo $category->category_name; ?></td>
                        <td>
                            <a href="<?php echo site_url(); ?>/wp-admin/admin.php?page=resume-category&action=edit&id=<?php echo $category->category_id; ?>" class="editstatus">Edit</a>
                            <a href="<?php echo site_url(); ?>/wp-admin/admin.php?page=resume-category&action=delete&id=<?php echo $category->category_id; ?>" class="editstatus">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
    } else {
        echo '<h3>No Category Founds</h3>';
    }
    ?>
</div>
<script>
    jQuery(document).ready(function () {
        jQuery('#addnewbutton').click(function (event) {
            jQuery("#status_list").hide();
            jQuery("#staus-form").show();
        });

        jQuery('#cancel_del').click(function (event) {
            event.preventDefault();
            jQuery("#del_cat").hide();
        });

        jQuery(document).on("click", ".submitstatus", function () {
            jQuery('.text-danger').remove();
            var resume_cat = jQuery('#resume_cat').val();
            var flage = true;
            if (resume_cat == '') {
                jQuery('#resume_cat').after('<label class="text-danger cat_msg1">The field is required.</label>');
                flage = false;
            }
            if (flage == true) {
                jQuery('.text-danger').remove();
                return true;
            } else {
                return false;
            }
        });
        jQuery(".cat_msg1").fadeOut(5000);
    });
</script>