jQuery(document).ready(function () {

    //---- Delete saved Project -------//
    jQuery('.del_prj').click(function () {
        var project_id = jQuery(this).attr("data-prj_id");
        var id = jQuery(this).attr("data-id");
        jQuery('#loding').show();
        var admin_url = jQuery('#admin_url').val();
        jQuery.ajax({
            url: admin_url,
            type: "POST",
            data: {
                action: 'delete_project',
                project_id: project_id
            },
            success: function (data) {
                if (data == 1) {
                    var project_count = jQuery('#addproject').val();
                    project_count--;
                    jQuery("#div_project_" + id).remove();
                    jQuery('.projects').each(function (index) {
                        var count = index + 1;
                        var proj = this.id;
                        jQuery('#' + proj + '  label:eq(0)').text('Project ' + count + '*');

                    });
                    jQuery('#addproject').val(project_count);
                }
                jQuery('#loding').hide();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });

    //---- Delete saved work experiance -------//
    jQuery('.del_works').click(function () {
        var work_id = jQuery(this).attr("data-work_id");
        var id = jQuery(this).attr("data-id");
        jQuery('#loding').show();
        var admin_url = jQuery('#admin_url').val();
        jQuery.ajax({
            url: admin_url,
            type: "POST",
            data: {
                action: 'delete_work',
                work_id: work_id
            },
            success: function (data) {
                if (data == 1) {
                    var work_count = jQuery('#addexperience').val();
                    work_count--;
                    jQuery("#div_workexp_" + id).remove();

                    jQuery('.experience').each(function (index) {
                        var count = index + 1;
                        var proj = this.id;

                    });
                    jQuery('#addexperience').val(work_count);
                }
                jQuery('#loding').hide();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });

    //---- Delete saved skills -------//
    jQuery('.del_skills').click(function () {
        var skill_id = jQuery(this).attr("data-skill_id");
        var id = jQuery(this).attr("data-id");
        jQuery('#loding').show();
        var admin_url = jQuery('#admin_url').val();
        jQuery.ajax({
            url: admin_url,
            type: "POST",
            data: {
                action: 'delete_skill',
                skill_id: skill_id
            },
            success: function (data) {
                if (data == 1) {
                    var skill_count = jQuery('#addstudentskills').val();
                    skill_count--;
                    jQuery("#skill_" + id).remove();
                    jQuery('.studentskill').each(function (index) {
                        var count = index + 1;
                        if (jQuery(this).parent().hasClass("c_left")) {
                            jQuery(this).parent().removeClass("c_left");
                        }
                        if (jQuery(this).parent().hasClass("c_right")) {
                            jQuery(this).parent().removeClass("c_right");
                        }
                        if (count % 2 == 0) {
                            jQuery(this).parent().addClass("c_right");
                        } else {
                            jQuery(this).parent().addClass("c_left");
                        }
                        jQuery(this).parent().find('label').text('Skill ' + count + '*');

                    });
                    jQuery('#addstudentskills').val(skill_count);

                }
                jQuery('#loding').hide();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });

    //---- Delete saved Cources -------//
    jQuery('.del_courses').click(function () {
        var course_id = jQuery(this).attr("data-course_id");
        var id = jQuery(this).attr("data-id");
        jQuery('#loding').show();
        var admin_url = jQuery('#admin_url').val();
        jQuery.ajax({
            url: admin_url,
            type: "POST",
            data: {
                action: 'delete_cources',
                course_id: course_id
            },
            success: function (data) {
                if (data == 1) {
                    var course_count = jQuery('#addcourse').val();
                    course_count--;
                    jQuery("#course_" + id).remove();
                    jQuery('.studentcourse').each(function (index) {
                        var count = index + 1;
                        if (jQuery(this).parent().hasClass("c_left")) {
                            jQuery(this).parent().removeClass("c_left");
                        }
                        if (jQuery(this).parent().hasClass("c_right")) {
                            jQuery(this).parent().removeClass("c_right");
                        }
                        if (count % 2 == 0) {
                            jQuery(this).parent().addClass("c_right");
                        } else {
                            jQuery(this).parent().addClass("c_left");
                        }
                        jQuery(this).parent().find('label').text('Course ' + count + '*');

                    });
                    jQuery('#addcourse').val(course_count);
                }
                jQuery('#loding').hide();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });

    //---- Delete saved software -------//
    jQuery('.del_sw').click(function () {
        var sw_id = jQuery(this).attr("data-sw_id");
        var id = jQuery(this).attr("data-id");
        jQuery('#loding').show();
        var admin_url = jQuery('#admin_url').val();
        jQuery.ajax({
            url: admin_url,
            type: "POST",
            data: {
                action: 'delete_sw',
                sw_id: sw_id
            },
            success: function (data) {
                if (data == 1) {
                    var software_count = jQuery('#addsoftware').val();
                    software_count--;
                    jQuery("#software_" + id).remove();
                    jQuery('.studentsoftware').each(function (index) {
                        var count = index + 1;
                        if (jQuery(this).parent().hasClass("c_left")) {
                            jQuery(this).parent().removeClass("c_left");
                        }
                        if (jQuery(this).parent().hasClass("c_right")) {
                            jQuery(this).parent().removeClass("c_right");
                        }
                        if (count % 2 == 0) {
                            jQuery(this).parent().addClass("c_right");
                        } else {
                            jQuery(this).parent().addClass("c_left");
                        }
                        jQuery(this).parent().find('label').text('Software ' + count + '*');

                    });
                    jQuery('#addsoftware').val(software_count);

                }
                jQuery('#loding').hide();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });

    //---- Delete saved Honors -------//
    jQuery('.del_honors').click(function () {
        var honor_id = jQuery(this).attr("data-honor_id");
        var id = jQuery(this).attr("data-id");
        jQuery('#loding').show();
        var admin_url = jQuery('#admin_url').val();
        jQuery.ajax({
            url: admin_url,
            type: "POST",
            data: {
                action: 'delete_honors',
                honor_id: honor_id
            },
            success: function (data) {
                if (data == 1) {

                    var honor_count = jQuery('#addhonor').val();
                    honor_count--;
                    jQuery("#honor_" + id).remove();
                    jQuery('.studenthonor').each(function (index) {
                        var count = index + 1;
                        if (jQuery(this).parent().hasClass("c_left")) {
                            jQuery(this).parent().removeClass("c_left");
                        }
                        if (jQuery(this).parent().hasClass("c_right")) {
                            jQuery(this).parent().removeClass("c_right");
                        }
                        if (count % 2 == 0) {
                            jQuery(this).parent().addClass("c_right");
                        } else {
                            jQuery(this).parent().addClass("c_left");
                        }
                        jQuery(this).parent().find('label').text('Honor ' + count + '*');

                    });
                    jQuery('#addhonor').val(honor_count);

                }
                jQuery('#loding').hide();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });

    //---- Delete saved Activity -------//
    jQuery('.del_activities').click(function () {
        var activity_id = jQuery(this).attr("data-activity_id");
        var id = jQuery(this).attr("data-id");
        jQuery('#loding').show();
        var admin_url = jQuery('#admin_url').val();
        jQuery.ajax({
            url: admin_url,
            type: "POST",
            data: {
                action: 'delete_activity',
                activity_id: activity_id
            },
            success: function (data) {
                if (data == 1) {
                    var activity_count = jQuery('#addactivity').val();
                    activity_count--;
                    jQuery("#activity_" + id).remove();
                    jQuery('.studentactivities').each(function (index) {
                        var count = index + 1;
                        if (jQuery(this).parent().hasClass("c_left")) {
                            jQuery(this).parent().removeClass("c_left");
                        }
                        if (jQuery(this).parent().hasClass("c_right")) {
                            jQuery(this).parent().removeClass("c_right");
                        }
                        if (count % 2 == 0) {
                            jQuery(this).parent().addClass("c_right");
                        } else {
                            jQuery(this).parent().addClass("c_left");
                        }
                        jQuery(this).parent().find('label').text('Activity ' + count + '*');

                    });
                    jQuery('#addactivity').val(activity_count);
                }
                jQuery('#loding').hide();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });

    //---- Delete saved Interest -------//
    jQuery('.del_interests').click(function () {
        var interest_id = jQuery(this).attr("data-interest_id");
        var id = jQuery(this).attr("data-id");
        jQuery('#loding').show();
        var admin_url = jQuery('#admin_url').val();
        jQuery.ajax({
            url: admin_url,
            type: "POST",
            data: {
                action: 'delete_intrest',
                interest_id: interest_id
            },
            success: function (data) {
                if (data == 1) {
                    var interest_count = jQuery('#addinterest').val();
                    interest_count--;
                    jQuery("#interest_" + id).remove();
                    jQuery('.studentinterest').each(function (index) {
                        var count = index + 1;
                        if (jQuery(this).parent().hasClass("c_left")) {
                            jQuery(this).parent().removeClass("c_left");
                        }
                        if (jQuery(this).parent().hasClass("c_right")) {
                            jQuery(this).parent().removeClass("c_right");
                        }
                        if (count % 2 == 0) {
                            jQuery(this).parent().addClass("c_right");
                        } else {
                            jQuery(this).parent().addClass("c_left");
                        }
                        jQuery(this).parent().find('label').text('Interest ' + count + '*');

                    });
                    jQuery('#addinterest').val(interest_count);
                }
                jQuery('#loding').hide();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });

    //---- Delete saved Reference -------//
    jQuery('.del_ref').click(function () {
        var ref_id = jQuery(this).attr("data-ref_id");
        var id = jQuery(this).attr("data-id");
        jQuery('#loding').show();
        var admin_url = jQuery('#admin_url').val();
        jQuery.ajax({
            url: admin_url,
            type: "POST",
            data: {
                action: 'delete_ref',
                ref_id: ref_id
            },
            success: function (data) {
                if (data == 1) {
                    var referenc_count = jQuery('#addreferences').val();
                    referenc_count--;
                    jQuery("#referenc_" + id).remove();
                    jQuery('.studentreferences').each(function (index) {
                        var count = index + 1;
                        if (jQuery(this).parent().hasClass("c_left")) {
                            jQuery(this).parent().removeClass("c_left");
                        }
                        if (jQuery(this).parent().hasClass("c_right")) {
                            jQuery(this).parent().removeClass("c_right");
                        }
                        if (count % 2 == 0) {
                            jQuery(this).parent().addClass("c_right");
                        } else {
                            jQuery(this).parent().addClass("c_left");
                        }
                        jQuery(this).parent().find('label').text('Reference ' + count + '*');

                    });
                    jQuery('#addreferences').val(referenc_count);
                }
                jQuery('#loding').hide();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });

    jQuery("#studentgraduationdate").datepicker({
        changeMonth: true,
        changeYear: true,
        format: 'd-m-yyyy',
        yearRange: "-100:+0"
    });

    jQuery('#admin_view').on('change', function () {
        var view = jQuery('#admin_view').val();
        var site_url = jQuery('#site_url').val();
        window.location.href = site_url + "/wp-admin/admin.php?page=mt-top-level-handle-resume-listing&view=" + view;
    });

    jQuery('#resume_view').on('change', function () {
        var view = jQuery('#resume_view').val();
        var site_url = jQuery('#site_url').val();
        window.location.href = site_url + "/wp-admin/admin.php?page=assign-category&view=" + view;
    });

//Bind Package id to assign
    jQuery('.assign_dash').click(function (e) {
        e.preventDefault();
        var package_id = jQuery(this).data().bind;
        jQuery('#assign #package_id').val(package_id);
        jQuery('#assign').modal('show');
    });


//---------------View all job ---------//
    jQuery('#all').click(function () {
        var site_url = jQuery('#site_url').val();
        window.location.href = site_url + "/wp-admin/admin.php?page=mt-top-level-handle-resume-listing";

    });

    jQuery('#asn_cat').click(function () {
        var site_url = jQuery('#site_url').val();
        window.location.href = site_url + "/wp-admin/admin.php?page=assign-category";

    });

    jQuery('#assignto').click(function (e) {
        e.preventDefault();
        jQuery('#loding').show();

        var assign = jQuery('#assign select').val();
        var currentuser_id = jQuery('#currentuser_id').val();
        var package_id = '';
        if (assign == 0) {
            jQuery(".assign_msg").html('<span class="text-danger assign_msg1 ">Select Reviewer...</span>');
            jQuery('#loding').hide();
            jQuery(".assign_msg1").fadeOut(5000);
        } else {
            var admin_url = jQuery('#admin_url').val();
            package_id = jQuery('#package_id').val();
            jQuery.ajax({
                url: admin_url,
                type: "POST",
                dataType: 'json',
                data: {
                    action: 'assign_reviewer',
                    assign: assign,
                    package_id: package_id,
                    currentuser_id: currentuser_id
                },
                success: function (data) {
                    if (data['review'] == '')
                        if (jQuery('#review').length) {
                            jQuery('#review').text(data['review']);
                        }
                    jQuery(".assign_msg").html(data['message']);
                    jQuery(".assign_msg1").fadeOut(5000);
                    jQuery('#loding').hide();
                    location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
            });
        }
    });

    //-----------Check Validation ans save all form on Click Return for Feedback ------------//
    jQuery('a.return_feedback').click(function (event) {
        event.preventDefault();

        var personal_flag = jQuery(".submitpersonalinfo").trigger("click", [, "final"]).data("status");
        var about_flag = jQuery(".submitfewthingaboutstudent").trigger("click", [, "final"]).data("status");
        var project_flag = jQuery(".submitstudentprojects").trigger("click", [, "final"]).data("status");
        var work_flag = jQuery(".submitstudentworkexperience").trigger("click", [, "final"]).data("status");
        var skill_flag = jQuery(".submitstudentskill").trigger("click", [, "final"]).data("status");
        var cource_flag = jQuery(".submitstudentcourse").trigger("click", [, "final"]).data("status");
        var software_flag = jQuery(".submitstudentsoftwareknowledge").trigger("click", [, "final"]).data("status");
        var honor_flag = jQuery(".submitstudenthonor").trigger("click", [, "final"]).data("status");
        var activity_flag = jQuery(".submitstudenactivity").trigger("click", [, "final"]).data("status");
        var interest_flag = jQuery(".submitstudeinterest").trigger("click", [, "final"]).data("status");
        var references_flag = jQuery(".submitstudentreferences").trigger("click", [, "final"]).data("status");

        if (personal_flag == 'true' && about_flag == 'true' && project_flag == 'true' && work_flag == 'true' && skill_flag == 'true' && cource_flag == 'true' && software_flag == 'true' && honor_flag == 'true' && activity_flag == 'true' && interest_flag == 'true' && references_flag == 'true') {
            jQuery('#feedback').modal('show');

        } else {
            jQuery('.return_msg').after('<label class="text-danger return_msg1">Please complete the above fields</label>');
            jQuery(".return_msg1").fadeOut(5000);
            jQuery('html,body').unbind().animate({scrollTop: jQuery('.save_err:visible:first').offset().top - 50}, 'slow');
            return false;
        }
    });

    //----------- Save final comment on click Return for Feedback and return resume -----------//
    jQuery('#cmt_feed').click(function (event) {
        event.preventDefault();
        var comment = jQuery('#comment_feed').val();
        var package_id = jQuery('#package_id').val();
        var admin_url = jQuery('#admin_url').val();
        var user_id = jQuery('#user_id').val();
        var currentuser_id = jQuery('#currentuser_id').val();
        if (comment) {
            jQuery.ajax({
                url: admin_url,
                type: "POST",
                data: {
                    action: 'send_return',
                    user_id: user_id,
                    package_id: package_id,
                    currentuser_id: currentuser_id,
                    comment: comment
                },
                success: function (data) {
                    jQuery('.comment_feed_msg').html(data);
                    jQuery(".comment_feed1").fadeOut(5000);
                    jQuery('#loding').hide();
                    location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
            });
        } else {
            jQuery('#comment_feed').after('<label class="text-danger comment_feed1">First Enter Comment</label>');
            jQuery(".comment_feed1").fadeOut(5000);
            return false;
        }
    });

    //---------------Disable Resume fields on reviewer dashboard profile ---------//
    jQuery('.readonly_fields input').prop('readonly', true);
    jQuery('.readonly_fields textarea').prop('readonly', true);
    jQuery('.readonly_fields select').css('pointer-events', 'none');
    jQuery('.readonly_fields input[type="submit"]').attr('disabled', 'disabled');
    jQuery(".readonly_fields input").prop('disabled', true);
    jQuery(".readonly_fields a.assign").removeAttr('data-toggle');
    jQuery(".readonly_fields a.assign").removeAttr('href')
    jQuery(".readonly_fields button").prop('disabled', true);
    jQuery('.readonly_fields a.hide_del').css('display', 'none');

//--------------- Personal Informational  validation---------//
    jQuery(document).on("click", ".submitpersonalinfo", function (event, parentform, final) {
        event.preventDefault();
        jQuery('.personal_err').remove();
        var studentname = jQuery('#studentname').val();
        var studentphone = jQuery('#studentphone').val();
        var studentemail = jQuery('#studentemail').val();
        var studentschool = jQuery('#studentschool').val();
        var studentcity = jQuery('#studentcity').val();
        var studentdegree = jQuery('#studentdegree').val();
        var studentgraduationdate = jQuery('#studentgraduationdate').val();
        var studentlinkedinprofile = jQuery('#studentlinkedinprofile').val();
        var studentendorsment = jQuery('#studentendorsment').val();
        var studentdescforjob = jQuery('#studentdescforjob').val();

        var statusflag = 'true';
        if (studentname == '') {
            jQuery('#studentname').after('<label class="text-danger personal_err">The field is required.</label>');
            statusflag = false;
        }
        if (studentphone == '') {
            jQuery('#studentphone').after('<label class="text-danger personal_err">The field is required.</label>');
            statusflag = 'false';
        }
        if (jQuery('#studentemail').val() == "" || !validateEmail(jQuery('#studentemail').val())) {

            jQuery("#studentemail").after('<label class="text-danger personal_err">Please enter valid email address</label>');
            statusflag = 'false';
        }
        if (studentschool == '') {
            jQuery('#studentschool').after('<label class="text-danger personal_err">The field is required.</label>');
            statusflag = false;
        }

        if (studentdegree == '') {
            jQuery('#studentdegree').after('<label class="text-danger personal_err">The field is required.</label>');
            statusflag = false;
        }
        if (studentgraduationdate == '') {
            jQuery('#studentgraduationdate').after('<label class="text-danger personal_err">The field is required.</label>');
            statusflag = false;
        }
        if (studentlinkedinprofile == '') {

        } else if (/(ftp|http|https):\/\/?(?:www\.)?linkedin.com(\w+:{0,1}\w*@)?(\S+)(:([0-9])+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/.test(studentlinkedinprofile)) {

        } else {
            jQuery('#studentlinkedinprofile').after('<label class="text-danger personal_err">Please enter valid url</label>');
            statusflag = false;
        }
        if (studentendorsment == '') {
            jQuery('#studentendorsment').after('<label class="text-danger personal_err">The field is required.</label>');
            statusflag = false;
        }

        jQuery(this).data("status", statusflag);

        if (statusflag == 'true' && parentform == undefined) {
            jQuery('a.personal').css('border', '1px solid #39a95e');
            if (final == undefined) {
                jQuery('#loding').show();
            }
            var package_id = jQuery('#package_id').val();
            var studentname = jQuery('#studentname').val();
            var studentphone = jQuery('#studentphone').val();
            var studentemail = jQuery('#studentemail').val();
            var studentschool = jQuery('#studentschool').val();
            var studentcity = jQuery('#studentcity').val();
            var studentdegree = jQuery('#studentdegree').val();
            var gdate = jQuery('#studentgraduationdate').val();
            var studentlinkedinprofile = jQuery('#studentlinkedinprofile').val();
            var studentendorsment = jQuery('#studentendorsment').val();
            var jobdescription = jQuery('#studentdescforjob').val();
            var admin_url = jQuery('#admin_url').val();
            jQuery.ajax({
                url: admin_url,
                type: "POST",
                data: {
                    action: 'save_info',
                    studentname: studentname,
                    studentphone: studentphone,
                    studentemail: studentemail,
                    studentschool: studentschool,
                    studentcity: studentcity,
                    studentdegree: studentdegree,
                    gdate: gdate,
                    studentlinkedinprofile: studentlinkedinprofile,
                    studentendorsment: studentendorsment,
                    jobdescription: jobdescription,
                    package_id: package_id
                },
                success: function (data) {
                    jQuery('.info_msg').html(data);
                    jQuery(".info_msg1").fadeOut(5000);
                    if (final == undefined) {
                        jQuery('#loding').hide();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }

            });
        } else if (statusflag == 'true') {
            return true;
        } else {
            jQuery('a.personal').css('border', '1px solid red');
            jQuery('a.personal').addClass("save_err");
            return false;
        }
    });

//validations for few things about student
    jQuery(document).on("click", ".submitfewthingaboutstudent", function (event, parentform, final) {
        event.preventDefault();
        jQuery('.about_err').remove();
        var aboutstudent = jQuery('#thing_1').val();
        var aboutstatus = 'true';
        if (aboutstudent == '') {
            jQuery('#thing_1').after('<label class="text-danger about_err">The field is required.</label>');
            aboutstatus = false;
        }
        jQuery(this).data("status", aboutstatus);
        if (aboutstatus == 'true' && parentform == undefined) {
            jQuery('a.about').css('border', '1px solid #39a95e');
            if (final == undefined) {
                jQuery('#loding').show();
            }
            var things = [];
            jQuery("input.thing").each(function (index) {
                things[index] = jQuery(this).val();
            });
            var is_submit = jQuery('#is_submit').val();
            var package_id = jQuery('#package_id').val();
            var admin_url = jQuery('#admin_url').val();
            var user_id = jQuery('#user_id').val();
            jQuery.ajax({
                url: admin_url,
                type: "POST",
                data: {
                    action: 'save_aboutthing',
                    things: things,
                    package_id: package_id,
                    user_id: user_id,
                    is_submit: is_submit
                },
                success: function (data) {
                    jQuery('#aboutstudentform .grey_row_left span').hide();
                    jQuery('.about_msg').html(data);
                    jQuery(".about_msg1").fadeOut(5000);
                    if (final == undefined) {
                        jQuery('#loding').hide();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
            });
        } else if (aboutstatus == 'true') {
            return true;
        } else {
            jQuery('a.about').css('border', '1px solid red');
            jQuery('a.about').addClass("save_err");
            return false;
        }
    });

//student skill
    jQuery(document).on("click", ".submitstudentskill", function (event, parentform, final) {
        event.preventDefault();
        jQuery('.skill_err').remove();
        var statusflag = 'true';
        jQuery('.studentskill').each(function () {
            if (jQuery(this).val() == "") {
                if (jQuery(this).next('label').text() == "") {
                    jQuery(this).next().remove('label');
                }
                statusflag = 'false';
                jQuery(this).after('<label class="text-danger skill_err">The Field Is Required.</label>');
            } else {
                if (jQuery(this).next('label').text() == "") {
                    jQuery(this).next().remove('label');
                }
            }
        });
        jQuery(this).data("status", statusflag);
        if (statusflag == 'true' && parentform == undefined) {
            jQuery('a.skill').css('border', '1px solid #39a95e');
            if (final == undefined) {
                jQuery('#loding').show();
            }
            var is_submit = jQuery('#is_submit').val();
            var package_id = jQuery('#package_id').val();
            var admin_url = jQuery('#admin_url').val();
            var user_id = jQuery('#user_id').val();
            var skills = [];
            jQuery("input.studentskill").each(function (index) {
                var s_id = jQuery(this).parent().find('.pk_skill_id').val();
                var skill = jQuery(this).val();
                skills[index] = '{"s_id":"' + s_id + '","skill":"' + skill + '"}';
            });
            jQuery.ajax({
                url: admin_url,
                type: "POST",
                data: {
                    action: 'save_skills',
                    skills: skills,
                    package_id: package_id,
                    user_id: user_id,
                    is_submit: is_submit
                },
                success: function (data) {
                    jQuery('#studentskill .grey_row_left span').hide();
                    jQuery('.del_skill').remove();
                    jQuery('.skill_msg').html(data);
                    jQuery(".skill_msg1").fadeOut(5000);
                    if (final == undefined) {
                        jQuery('#loding').hide();
                        location.reload();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
            });
        } else if (statusflag == 'true') {
            return true;
        } else {
            jQuery('a.skill').css('border', '1px solid red');
            jQuery('a.skill').addClass("save_err");
            return false;
        }
    });

//student Coures and certifications
    jQuery(document).on("click", ".submitstudentcourse", function (event, parentform, final) {
        event.preventDefault();
        jQuery('.course_err').remove();
        var statusflag = 'true';
        jQuery('.studentcourse').each(function () {
            if (jQuery(this).val() == "") {
                if (jQuery(this).next('label').text() == "") {
                    jQuery(this).next().remove('label');
                }
                statusflag = 'false';
                jQuery(this).after('<label class="text-danger course_err">The Field Is Required.</label>');
            } else {
                if (jQuery(this).next('label').text() == "") {
                    jQuery(this).next().remove('label');
                }
            }
        });
        jQuery(this).data("status", statusflag);
        if (statusflag == 'true' && parentform == undefined) {
            jQuery('a.cource').css('border', '1px solid #39a95e');
            if (final == undefined) {
                jQuery('#loding').show();
            }
            var is_submit = jQuery('#is_submit').val();
            var package_id = jQuery('#package_id').val();
            var admin_url = jQuery('#admin_url').val();
            var user_id = jQuery('#user_id').val();
            var studentcourse = [];
            jQuery("input.studentcourse").each(function (index) {
                var c_id = jQuery(this).parent().find('.pk_course_id').val();
                var course = jQuery(this).val();
                studentcourse[index] = '{"c_id":"' + c_id + '","course":"' + course + '"}';
            });
            jQuery.ajax({
                url: admin_url,
                type: "POST",
                data: {
                    action: 'save_course',
                    studentcourse: studentcourse,
                    package_id: package_id,
                    user_id: user_id,
                    is_submit: is_submit
                },
                success: function (data) {
                    jQuery('#studentcource .grey_row_left span').hide();
                    jQuery('.del_course').remove();
                    jQuery('.course_msg').html(data);
                    jQuery(".course_msg1").fadeOut(5000);
                    if (final == undefined) {
                        jQuery('#loding').hide();
                        location.reload();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
            });
        } else if (statusflag == 'true') {
            return true;
        } else {
            jQuery('a.cource').css('border', '1px solid red');
            jQuery('a.cource').addClass("save_err");
            return false;
        }
    });

//Start Knowledge Software
    jQuery(document).on("click", "#addstudentssoftware", function (event) {
        event.preventDefault();
        jQuery('#studentsoftware .grey_row_left span').show();
        var count = parseInt(jQuery('#addsoftware').val()) + 1;
        jQuery('#addsoftware').val(count);
        var sf_class = '';
        if (count % 2 == 0) {
            sf_class = 'c_right';
        } else {
            sf_class = 'c_left';
        }
        jQuery('.Clssoftware').find('.c_row').last().append(
                '<div class="' + sf_class + '" id="software_' + count + '">' +
                '<label>Software ' + count + '*</label>' +
                '<input type="text" class="studentsoftware alltxtfield" maxlength="100" placeholder="Type here" id="software_' + count + '" name="software_' + count + '">' +
                ' <input type="hidden" class="pk_software_id" name="pk_software_id_' + count + '" value="">' +
                '<a class="del_software" href="javascript:void(0);" onclick="Deletesoftware(' + count + ');">Delete</a>' +
                '</div>');

        jQuery(".alltxtfield").keypress(function (event) {
            var inputValue = event.which;

// allow letters and whitespaces only.
            if (!(inputValue > 47 && inputValue < 58) && !(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0 && inputValue != 46 && inputValue != 08)) {
                event.preventDefault();
            }
        });
        return false;
    });

// for honor
    jQuery(document).on("click", "#addstudentshonor", function (event) {
        event.preventDefault();
        jQuery('#studenthonor .grey_row_left span').show();
        var counts = parseInt(jQuery('#addhonor').val()) + 1;
        jQuery('#addhonor').val(counts);
        var sf_class = '';
        if (counts % 2 == 0) {
            sf_class = 'c_right';
        } else {
            sf_class = 'c_left';
        }
        jQuery('.Clshonor').find('.c_row').last().append(
                '<div class="' + sf_class + '" id="honor_' + counts + '">' +
                '<label>Honor ' + counts + '*</label>' +
                '<input type="text" class="studenthonor alltxtfield" maxlength="100"  placeholder="Type here" id="honor_' + counts + '" name="honor_' + counts + '">' +
                '   <input type="hidden" class="pk_honor_id" name="pk_honor_id_' + counts + '" value="">' +
                '<a class="del_honor" href="javascript:void(0);" onclick="Deletehonor(' + counts + ');">Delete</a>' +
                '</div>');
        jQuery(".alltxtfield").keypress(function (event) {
            var inputValue = event.which;
// allow letters and whitespaces only.
            if (!(inputValue > 47 && inputValue < 58) && !(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0 && inputValue != 46 && inputValue != 08)) {
                event.preventDefault();
            }
        });
        return false;
    });

// for activity
    jQuery(document).on("click", "#addstudentsactivity", function (event) {
        event.preventDefault();
        jQuery('#studentactivity .grey_row_left span').show();
        var counts = parseInt(jQuery('#addactivity').val()) + 1;
        jQuery('#addactivity').val(counts);
        var sf_class = '';
        if (counts % 2 == 0) {
            sf_class = 'c_right';
        } else {
            sf_class = 'c_left';
        }
        jQuery('.Clsactivity').find('.c_row').last().append(
                '<div class="' + sf_class + '" id="activity_' + counts + '">' +
                '<label>Activity ' + counts + '*</label>' +
                '<input type="text" class="studentactivities alltxtfield" maxlength="100" placeholder="Type here" id="activity_' + counts + '" name="activity_' + counts + '">' +
                '<input type="hidden" class="pk_activity_id" name="pk_activity_id_' + counts + '" value="">' +
                '<a class="del_activity" href="javascript:void(0);" onclick="Deleteactivity(' + counts + ');">Delete</a>' +
                '</div>');

        jQuery(".alltxtfield").keypress(function (event) {
            var inputValue = event.which;
// allow letters and whitespaces only.
            if (!(inputValue > 47 && inputValue < 58) && !(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0 && inputValue != 46 && inputValue != 08)) {
                event.preventDefault();
            }
        });

        return false;
    });


// for Interest
    jQuery(document).on("click", "#addstudentsinterest", function (event) {
        event.preventDefault();
        jQuery('#studentinterest .grey_row_left span').show();
        var counts = parseInt(jQuery('#addinterest').val()) + 1;
        jQuery('#addinterest').val(counts);
        var sf_class = '';
        if (counts % 2 == 0) {
            sf_class = 'c_right';
        } else {
            sf_class = 'c_left';
        }
        jQuery('.Clsinterest').find('.c_row').last().append(
                '<div class="' + sf_class + '" id="interest_' + counts + '">' +
                '<label> Interest ' + counts + '*</label>' +
                '<input type="text" class="studentinterest alltxtfield" maxlength="100" placeholder="Type here" id="interests_' + counts + '" name="interests_' + counts + '">' +
                '  <input type="hidden" class="pk_interest_id" name="pk_interest_id_' + counts + '" value="">' +
                '<a class="del_interest" href="javascript:void(0);" onclick="Deleteinterest(' + counts + ');">Delete</a>' +
                '</div>');

        jQuery(".alltxtfield").keypress(function (event) {
            var inputValue = event.which;
// allow letters and whitespaces only.
            if (!(inputValue > 47 && inputValue < 58) && !(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0 && inputValue != 46 && inputValue != 08)) {
                event.preventDefault();
            }
        });

        return false;
    });

//Student software knowledge
    jQuery(document).on("click", ".submitstudentsoftwareknowledge", function (event, parentform, final) {
        event.preventDefault();
        jQuery('.software_err').remove();
        var statusflag = 'true';
        jQuery('.studentsoftware').each(function () {
            if (jQuery(this).val() == "") {
                if (jQuery(this).next('label').text() == "") {
                    jQuery(this).next().remove('label');
                }
                statusflag = 'false';
                jQuery(this).after('<label class="text-danger software_err">The Field Is Required.</label>');
            } else {
                if (jQuery(this).next('label').text() == "") {
                    jQuery(this).next().remove('label');
                }
            }
        });
        jQuery(this).data("status", statusflag);
        if (statusflag == 'true' && parentform == undefined) {
            jQuery('a.software').css('border', '1px solid #39a95e');
            if (final == undefined) {
                jQuery('#loding').show();
            }
            var is_submit = jQuery('#is_submit').val();
            var package_id = jQuery('#package_id').val();
            var admin_url = jQuery('#admin_url').val();
            var user_id = jQuery('#user_id').val();
            var studentsoftwares = [];
            jQuery("input.studentsoftware").each(function (index) {
                var sw_id = jQuery(this).parent().find('.pk_software_id').val();
                var software = jQuery(this).val();
                studentsoftwares[index] = '{"sw_id":"' + sw_id + '","software":"' + software + '"}';
            });
            jQuery.ajax({
                url: admin_url,
                type: "POST",
                data: {
                    action: 'save_software',
                    studentsoftwares: studentsoftwares,
                    package_id: package_id,
                    user_id: user_id,
                    is_submit: is_submit
                },
                success: function (data) {
                    jQuery('#studentsoftware .grey_row_left span').hide();
                    jQuery('.del_software').remove();
                    jQuery('.software_msg').html(data);
                    jQuery(".software_msg1").fadeOut(5000);
                    if (final == undefined) {
                        jQuery('#loding').hide();
                        location.reload();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
            });
        } else if (statusflag == 'true') {
            return true;
        } else {
            jQuery('a.software').css('border', '1px solid red');
            jQuery('a.software').addClass("save_err");
            return false;
        }
    });

//student honor
    jQuery(document).on("click", ".submitstudenthonor", function (event, parentform, final) {
        event.preventDefault();
        jQuery('.honor_err').remove();
        var statusflag = 'true';
        jQuery('.studenthonor').each(function () {
            if (jQuery(this).val() == "") {
                if (jQuery(this).next('label').text() == "") {
                    jQuery(this).next().remove('label');
                }
                statusflag = 'false';
                jQuery(this).after('<label class="text-danger honor_err">The Field Is Required.</label>');
            } else {
                if (jQuery(this).next('label').text() == "") {
                    jQuery(this).next().remove('label');
                }
            }
        });
        jQuery(this).data("status", statusflag);
        if (statusflag == 'true' && parentform == undefined) {
            jQuery('a.honor').css('border', '1px solid #39a95e');
            if (final == undefined) {
                jQuery('#loding').show();
            }
            var package_id = jQuery('#package_id').val();
            var admin_url = jQuery('#admin_url').val();
            var user_id = jQuery('#user_id').val();
            var is_submit = jQuery('#is_submit').val();
            var studenthonors = [];
            jQuery("input.studenthonor").each(function (index) {
                var h_id = jQuery(this).parent().find('.pk_honor_id').val();
                var honor = jQuery(this).val();
                studenthonors[index] = '{"h_id":"' + h_id + '","honor":"' + honor + '"}';
            });
            jQuery.ajax({
                url: admin_url,
                type: "POST",
                data: {
                    action: 'save_honors',
                    studenthonors: studenthonors,
                    package_id: package_id,
                    user_id: user_id,
                    is_submit: is_submit
                },
                success: function (data) {
                    jQuery('#studenthonor .grey_row_left span').hide();
                    jQuery('.del_honor').remove();
                    jQuery('.honor_msg').html(data);
                    jQuery(".honor_msg1").fadeOut(5000);
                    if (final == undefined) {
                        jQuery('#loding').hide();
                        location.reload();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
            });
        } else if (statusflag == 'true') {
            return true;
        } else {
            jQuery('a.honor').css('border', '1px solid red');
            jQuery('a.honor').addClass("save_err");
            return false;
        }
    });

//student activities
    jQuery(document).on("click", ".submitstudenactivity", function (event, parentform, final) {
        event.preventDefault();
        jQuery('.activity_err').remove();
        var statusflag = 'true';
        jQuery('.studentactivities').each(function () {
            if (jQuery(this).val() == "") {
                if (jQuery(this).next('label').text() == "") {
                    jQuery(this).next().remove('label');
                }
                statusflag = 'false';
                jQuery(this).after('<label class="text-danger activity_err">The Field Is Required.</label>');
            } else {
                if (jQuery(this).next('label').text() == "") {
                    jQuery(this).next().remove('label');
                }
            }
        });
        jQuery(this).data("status", statusflag);
        if (statusflag == 'true' && parentform == undefined) {
            jQuery('a.activity').css('border', '1px solid #39a95e');
            if (final == undefined) {
                jQuery('#loding').show();
            }
            var package_id = jQuery('#package_id').val();
            var admin_url = jQuery('#admin_url').val();
            var user_id = jQuery('#user_id').val();
            var is_submit = jQuery('#is_submit').val();
            var studentactivities = [];
            jQuery("input.studentactivities").each(function (index) {
                var a_id = jQuery(this).parent().find('.pk_activity_id').val();
                var activity = jQuery(this).val();
                studentactivities[index] = '{"a_id":"' + a_id + '","activity":"' + activity + '"}';
            });
            jQuery.ajax({
                url: admin_url,
                type: "POST",
                data: {
                    action: 'save_activitues',
                    studentactivities: studentactivities,
                    package_id: package_id,
                    user_id: user_id,
                    is_submit: is_submit
                },
                success: function (data) {
                    jQuery('#studentactivity .grey_row_left span').hide();
                    jQuery('.del_activity').remove();
                    jQuery('.activity_msg').html(data);
                    jQuery(".activity_msg1").fadeOut(5000);
                    if (final == undefined) {
                        jQuery('#loding').hide();
                        location.reload();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
            });
        } else if (statusflag == 'true') {
            return true;
        } else {
            jQuery('a.activity').css('border', '1px solid red');
            jQuery('a.activity').addClass("save_err");
            return false;
        }
    });

//student interests
    jQuery(document).on("click", ".submitstudeinterest", function (event, parentform, final) {
        event.preventDefault();
        jQuery('.interest_err').remove();
        var statusflag = 'true';
        jQuery('.studentinterest').each(function () {
            if (jQuery(this).val() == "") {
                if (jQuery(this).next('label').text() == "") {
                    jQuery(this).next().remove('label');
                }
                statusflag = 'false';
                jQuery(this).after('<label class="text-danger interest_err">The Field Is Required.</label>');
            } else {
                if (jQuery(this).next('label').text() == "") {
                    jQuery(this).next().remove('label');
                }
            }
        });
        jQuery(this).data("status", statusflag);
        if (statusflag == 'true' && parentform == undefined) {
            jQuery('a.interest').css('border', '1px solid #39a95e');
            if (final == undefined) {
                jQuery('#loding').show();
            }
            var package_id = jQuery('#package_id').val();
            var admin_url = jQuery('#admin_url').val();
            var user_id = jQuery('#user_id').val();
            var is_submit = jQuery('#is_submit').val();
            var studentinterests = [];
            jQuery("input.studentinterest").each(function (index) {
                var i_id = jQuery(this).parent().find('.pk_interest_id').val();
                var intrest = jQuery(this).val();
                studentinterests[index] = '{"i_id":"' + i_id + '","intrest":"' + intrest + '"}';
            });
            jQuery.ajax({
                url: admin_url,
                type: "POST",
                data: {
                    action: 'save_interest',
                    studentinterests: studentinterests,
                    package_id: package_id,
                    user_id: user_id,
                    is_submit: is_submit
                },
                success: function (data) {
                    jQuery('#studentinterest .grey_row_left span').hide();
                    jQuery('.del_interest').remove();
                    jQuery('.interest_msg').html(data);
                    jQuery(".interest_msg1").fadeOut(5000);
                    if (final == undefined) {
                        jQuery('#loding').hide();
                        location.reload();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
            });
        } else if (statusflag == 'true') {
            return true;
        } else {
            jQuery('a.interest').css('border', '1px solid red');
            jQuery('a.interest').addClass("save_err");
            return false;
        }
    });

// for references
    jQuery(document).on("click", "#addnewrefernces", function (event) {
        event.preventDefault();
        jQuery('#studentreferences .grey_row_left span').show();
        var counts = parseInt(jQuery('#addreferences').val()) + 1;
        jQuery('#addreferences').val(counts);
        var sf_class = '';
        if (counts % 2 == 0) {
            sf_class = 'c_right';
        } else {
            sf_class = 'c_left';
        }
        jQuery(".Clsreferences").find('.c_row').last().append('<div class="' + sf_class + ' others_text"  id="referenc_' + counts + '">' +
                '<label>Reference ' + counts + '*</label>' +
                '<textarea maxlength="500" id="references_' + counts + '" class="studentreferences" name="references_' + counts + '">' +
                '</textarea>' +
                ' <input type="hidden" class="pk_reference_id" name="pk_reference_id_' + counts + '" value="">' +
                '<a class="del_referenc" href="javascript:void(0);" onclick="Deletereferenc(' + counts + ');">Delete</a>' +
                '</div>');

        return false;
    });

// references
    jQuery(document).on("click", ".submitstudentreferences", function (event, parentform, final) {
        event.preventDefault();
        jQuery('.references_err').remove();
        var statusflag = 'true';
        jQuery('.studentreferences').each(function () {
            if (jQuery(this).val() == "") {
                if (jQuery(this).next('label').text() == "") {
                    jQuery(this).next().remove('label');
                }
                statusflag = 'false';
                jQuery(this).after('<label class="text-danger  references_err">The Field Is Required.</label>');
            } else {
                if (jQuery(this).next('label').text() == "") {
                    jQuery(this).next().remove('label');
                }
            }
        });
        jQuery(this).data("status", statusflag);
        if (statusflag == 'true' && parentform == undefined) {
            jQuery('a.references').css('border', '1px solid #39a95e');
            if (final == undefined) {
                jQuery('#loding').show();
            }
            var package_id = jQuery('#package_id').val();
            var admin_url = jQuery('#admin_url').val();
            var user_id = jQuery('#user_id').val();
            var is_submit = jQuery('#is_submit').val();
            var studentreferences = [];
            jQuery("textarea.studentreferences").each(function (index) {
                var r_id = jQuery(this).parent().find('.pk_reference_id').val();
                var reference = jQuery(this).val();
                studentreferences[index] = '{"r_id":"' + r_id + '","reference":"' + reference + '"}';
            });
            jQuery.ajax({
                url: admin_url,
                type: "POST",
                data: {
                    action: 'save_references',
                    studentreferences: studentreferences,
                    package_id: package_id,
                    user_id: user_id,
                    is_submit: is_submit
                },
                success: function (data) {
                    jQuery('#studentreferences .grey_row_left span').hide();
                    jQuery('.del_referenc').remove();
                    jQuery('.references_msg').html(data);
                    jQuery(".references_msg1").fadeOut(5000);
                    if (final == undefined) {
                        jQuery('#loding').hide();
                        location.reload();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
            });
        } else if (statusflag == 'true') {
            return true;
        } else {
            jQuery('a.references').css('border', '1px solid red');
            jQuery('a.references').addClass("save_err");
            return false;
        }
    });

    jQuery(document).on("change", ".file_upload", function () {
        var id = jQuery(this).closest('.projects').attr('id');
        var flag = true;
        var file = jQuery(this);
        var file_name = file[0].files[0]['name'];
        var ext = file_name.split(".");
        ext = ext[ext.length - 1].toLowerCase();
        var arrayExtensions = ["jpg", "jpeg", "png"];
        if (arrayExtensions.lastIndexOf(ext) == -1) {
            jQuery('#' + id + ' .file_upload').after('<label class="text-danger project_err">This is Wrong extension type.</label>');
            jQuery(".project_err").fadeOut(5000);
            flag = false;
        } else if (file[0].files[0].size > 1000000) {
            jQuery('#' + id + ' .file_upload').after('<label class="text-danger project_err">Please upload max 1MB size file.</label>');
            jQuery(".project_err").fadeOut(5000);
            flag = false;
        }
        if (flag == true) {
            var fd = new FormData();
            var admin_url = jQuery('#admin_url').val();
            var file = jQuery(this);
            var individual_file = file[0].files[0];
            fd.append("file", individual_file);
            fd.append('action', 'fiu_upload_file');

            jQuery.ajax({
                type: 'POST',
                url: admin_url,
                data: fd,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (data) {
                    jQuery('#loding').hide();
                    jQuery('#' + id + ' .original_name').val(data['original_name']);
                    jQuery('#' + id + ' .upload_name').val(data['upload_name']);
                }
            });
        } else {
            jQuery(this).val('');
            return false;
        }
    });

// Validations start for Project
    jQuery(document).on("click", ".submitstudentprojects", function (event, parentform, final) {
        event.preventDefault();
        jQuery('.project_err').remove();
        var statusflag = 'true';
        jQuery('.projectname').each(function () {
            if (jQuery(this).val() == "") {
                if (jQuery(this).next('label').text() == "") {
                    jQuery(this).next().remove('label');
                }
                statusflag = 'false';
                jQuery(this).after('<label class="text-danger project_err">The Field Is Required.</label>');
            } else {
                if (jQuery(this).next('label').text() == "") {
                    jQuery(this).next().remove('label');
                }
            }
        });
        jQuery('.background').each(function () {
            if (jQuery(this).val() == "") {
                if (jQuery(this).next('label').text() == "") {
                    jQuery(this).next().remove('label');
                }
                statusflag = 'false';
                jQuery(this).after('<label class="text-danger project_err">The Field Is Required.</label>');
            } else {
                if (jQuery(this).next('label').text() == "") {
                    jQuery(this).next().remove('label');
                }
            }

        });

        jQuery('.objective').each(function () {
            if (jQuery(this).val() == "") {
                if (jQuery(this).next('label').text() == "") {
                    jQuery(this).next().remove('label');
                }
                statusflag = 'false';
                jQuery(this).after('<label class="text-danger project_err">The Field Is Required.</label>');
            } else {
                if (jQuery(this).next('label').text() == "") {
                    jQuery(this).next().remove('label');
                }
            }
        });

        jQuery('.execution').each(function () {
            if (jQuery(this).val() == "") {
                if (jQuery(this).next('label').text() == "") {
                    jQuery(this).next().remove('label');
                }
                statusflag = 'false';
                jQuery(this).after('<label class="text-danger project_err">The Field Is Required.</label>');
            } else {
                if (jQuery(this).next('label').text() == "") {
                    jQuery(this).next().remove('label');
                }
            }
        });

        jQuery('.results').each(function () {
            if (jQuery(this).val() == "") {
                if (jQuery(this).next('label').text() == "") {
                    jQuery(this).next().remove('label');
                }
                statusflag = 'false';
                jQuery(this).after('<label class="text-danger project_err">The Field Is Required.</label>');
            } else {
                if (jQuery(this).next('label').text() == "") {
                    jQuery(this).next().remove('label');
                }
            }
        });
        jQuery('.upload_name').each(function () {
            if (jQuery(this).val() == "") {
                if (jQuery(this).next('label').text() == "") {
                    jQuery(this).next().remove('label');
                }
                statusflag = 'false';
                jQuery(this).after('<label class="text-danger project_err">The Field Is Required.</label>');
            } else {
                if (jQuery(this).next('label').text() == "") {
                    jQuery(this).next().remove('label');
                }
            }
        });
        jQuery(this).data("status", statusflag);
        if (statusflag == 'true' && parentform == undefined) {
            jQuery('a.project').css('border', '1px solid #39a95e');
            if (final == undefined) {
                jQuery('#loding').show();
            }
            var package_id = jQuery('#package_id').val();
            var admin_url = jQuery('#admin_url').val();
            var user_id = jQuery('#user_id').val();
            var is_submit = jQuery('#is_submit').val();
            var projects = [];

            jQuery(".projects").each(function (i) {
                var id = this.id;
                var p_id = jQuery('#' + id + '  .pk_project_id').val();
                var name = jQuery('#' + id + ' .projectname').val();
                var background = jQuery('#' + id + ' .background').val();
                var objective = jQuery('#' + id + ' .objective').val();
                var execution = jQuery('#' + id + ' .execution').val();
                var results = jQuery('#' + id + ' .results').val();
                var original = '';
                var upload = ''
                if (jQuery('#' + id + ' .original_name') && jQuery('#' + id + ' .upload_name')) {
                    original = jQuery('#' + id + ' .original_name').val();
                    upload = jQuery('#' + id + ' .upload_name').val();
                }
                projects[i] = '{"name":"' + name + '","background":"' + background + '","objective":"' + objective + '","execution":"' + execution + '","results":"' + results + '","original":"' + original + '","upload":"' + upload + '","p_id":"' + p_id + '"}';
            });
            jQuery.ajax({
                url: admin_url,
                type: "POST",
                data: {
                    action: 'save_project',
                    projects: projects,
                    package_id: package_id,
                    user_id: user_id,
                    is_submit: is_submit
                },
                success: function (data) {
                    jQuery('#studentprojects .grey_row_left span').hide();
                    jQuery('.del_project').remove();
                    jQuery('.project_msg').html(data);
                    jQuery(".project_msg1").fadeOut(5000);
                    if (final == undefined) {
                        jQuery('#loding').hide();
                        location.reload();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
            });
        } else if (statusflag == 'true') {
            return true;
        } else {
            jQuery('a.project').css('border', '1px solid red');
            jQuery('a.project').addClass("save_err");
            return false;
        }
    });
//project validation validations end

// Validations start for Work Experience
    jQuery(document).on("click", ".submitstudentworkexperience", function (event, parentform, final) {
        event.preventDefault();
        var statusflag = 'true';
        jQuery('.work_err').remove();
        jQuery('.exp_title').each(function () {
            if (jQuery(this).val() == "") {
                if (jQuery(this).next('label').text() != "") {
                    jQuery(this).next().remove('label');
                }
                statusflag = 'false';
                jQuery(this).after('<label class="text-danger work_err">The Field Is Required.</label>');
            } else {
                if (jQuery(this).next('label').text() != "") {
                    jQuery(this).next().remove('label');
                }
            }
        });

        jQuery('.exp_compny').each(function () {
            if (jQuery(this).val() == "") {
                if (jQuery(this).next('label').text() != "") {
                    jQuery(this).next().remove('label');
                }
                statusflag = 'false';
                jQuery(this).after('<label class="text-danger work_err">The Field Is Required.</label>');
            } else {
                if (jQuery(this).next('label').text() != "") {
                    jQuery(this).next().remove('label');
                }
            }

        });

        jQuery('.exp_city').each(function () {
            if (jQuery(this).val() == "") {
                if (jQuery(this).next('label').text() != "") {
                    jQuery(this).next().remove('label');
                }
                statusflag = 'false';
                jQuery(this).after('<label class="text-danger work_err">The Field Is Required.</label>');
            } else {
                if (jQuery(this).next('label').text() != "") {
                    jQuery(this).next().remove('label');
                }
            }
        });
        jQuery('.exp_state').each(function () {
            if (jQuery(this).val() == "") {
                if (jQuery(this).next('label').text() != "") {
                    jQuery(this).next().remove('label');
                }
                statusflag = 'false';
                jQuery(this).after('<label class="text-danger work_err">The Field Is Required.</label>');
            } else {
                if (jQuery(this).next('label').text() != "") {
                    jQuery(this).next().remove('label');
                }
            }
        });
        jQuery('.exp_years').each(function () {
            if (jQuery(this).val() == "") {
                if (jQuery(this).next('label').text() != "") {
                    jQuery(this).next().remove('label');
                }
                statusflag = 'false';
                jQuery(this).after('<label class="text-danger work_err">The Field Is Required.</label>');
            } else {
                if (jQuery(this).next('label').text() != "") {
                    jQuery(this).next().remove('label');
                }
            }
        });
        jQuery('.exp_description').each(function () {
            if (jQuery(this).val() == "") {
                if (jQuery(this).next('label').text() != "") {
                    jQuery(this).next().remove('label');
                }
                statusflag = 'false';
                jQuery(this).after('<label class="text-danger work_err">The Field Is Required.</label>');
            } else {
                if (jQuery(this).next('label').text() != "") {
                    jQuery(this).next().remove('label');
                }
            }
        });
        jQuery(this).data("status", statusflag);
        if (statusflag == 'true' && parentform == undefined) {
            jQuery('a.work').css('border', '1px solid #39a95e');
            if (final == undefined) {
                jQuery('#loding').show();
            }
            var is_submit = jQuery('#is_submit').val();
            var package_id = jQuery('#package_id').val();
            var admin_url = jQuery('#admin_url').val();
            var user_id = jQuery('#user_id').val();
            var experience = [];
            jQuery(".experience").each(function (i) {
                var id = this.id;
                var w_id = jQuery('#' + id + '  .pk_workexp_id').val();
                var title = jQuery('#' + id + ' .exp_title').val();
                var company = jQuery('#' + id + ' .exp_compny').val();
                var city = jQuery('#' + id + ' .exp_city').val();
                var state = jQuery('#' + id + ' .exp_state').val();
                var years = jQuery('#' + id + ' .exp_years').val();
                var description = jQuery('#' + id + ' .exp_description').val();
                experience[i] = '{"title":"' + title + '","company":"' + company + '","city":"' + city + '","state":"' + state + '","years":"' + years + '","description":"' + description + '","w_id":"' + w_id + '"}';
            });
            jQuery.ajax({
                url: admin_url,
                type: "POST",
                data: {
                    action: 'save_experience',
                    experience: experience,
                    package_id: package_id,
                    user_id: user_id,
                    is_submit: is_submit
                },
                success: function (data) {
                    jQuery('#studentworks .grey_row_left span').hide();
                    jQuery('.work_msg').html(data);
                    jQuery(".work_msg1").fadeOut(3000);
                    if (final == undefined) {
                        jQuery('#loding').hide();
                        location.reload();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
            });
        } else if (statusflag == 'true') {
            return true;
        } else {
            jQuery('a.work').css('border', '1px solid red');
            jQuery('a.work').addClass("save_err");
            return false;
        }
    });

    //check uploaded file types
    function allvalidateimageFiles(file, imageName) {
        var ext = file.split(".");
        ext = ext[ext.length - 1].toLowerCase();
        var arrayExtensions = ["doc", "docx", "pdf", "txt", "text"];
        var flages = true;
        if (arrayExtensions.lastIndexOf(ext) == -1) {
            alert("Wrong extension type.");
            flages = false;
        }
        if (jQuery('#uploaded_resume')[0].files[0].size > 100000) {
            alert("Please upload max 1MB size file");
            flages = false;
        }
        if (flages == true) {

            return true;
        } else {
            jQuery("#uploaded_resume").val('');
            return false;
        }
    }

//Start Resume workspace Module
    jQuery(document).on("click", "#addnewproject", function (event) {
        event.preventDefault();
        jQuery('#studentprojects .grey_row_left span').show();
        var counter = parseInt(jQuery('#addproject').val()) + 1;
        jQuery('#addproject').val(counter);
        jQuery('.clsProject').append(
                ' <div id="div_project_' + counter + '" class="panel-body projects">' +
                ' <input type="hidden" class="pk_project_id" name="pk_project_id_' + counter + '" value="">' +
                '<div class="c_row">' +
                '<div class="c_left">' +
                '<label>Project ' + counter + '*</label>' +
                '<input type="text" class="projectname alltxtfield" maxlength="100" placeholder="Type here" id="project_name_' + counter + '" name="project_name_' + counter + '">' +
                '</div>' +
                '<div class="c_right">' +
                '<label>Background*</label>' +
                '<input type="text" class="background alltxtfield" maxlength="100" placeholder="Type here" id="background_' + counter + '" name="background_' + counter + '">' +
                '</div>' +
                '</div>' +
                '<div class="c_row">' +
                '<div class="c_left">' +
                '<label>Objective*</label>' +
                '<input type="text" class="objective alltxtfield" maxlength="100" placeholder="Type here" id="objective_' + counter + '" name="objective_' + counter + '">' +
                '</div>' +
                '<div class="c_right">' +
                '<label>Execution*</label>' +
                '<input type="text" class="execution alltxtfield" maxlength="100"" placeholder="Type here" id="execution_' + counter + '" name="execution_' + counter + '">' +
                '</div>' +
                '</div>' +
                '<div class="c_row">' +
                '<div class="c_left">' +
                '<label>Results*</label>' +
                '<input type="text" class="results alltxtfield"  maxlength="100" placeholder="Type here" id="results_' + counter + '" name="results_' + counter + '">' +
                '</div>' +
                '<div class="c_right">' +
                '<label>Attach graphic*</label>' +
                ' <input type="file"  class="file_upload" name="uploaded_file" id="uploaded_file_' + counter + '" >' +
                '  <span>jpg, jpeg, png Files allowed. File size upto 1mb.</span>' +
                ' <input type="hidden" class="upload_name" />' +
                '<input type="hidden" class="original_name" />' +
                '</div>' +
                '</div>' +
                '<a class="del_project" href="javascript:void(0);" onclick="Deleteproject(' + counter + ');">Delete</a>' +
                '</div>');
        jQuery(".alltxtfield").keypress(function (event) {
            var inputValue = event.which;
// allow letters and whitespaces only.
            if (!(inputValue > 47 && inputValue < 58) && !(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0 && inputValue != 46 && inputValue != 08)) {
                event.preventDefault();
            }
        });
        return false;
    });

//End Project Module

//Start work  Experience
    jQuery(document).on("click", "#addnewexperience", function (event) {
        event.preventDefault();
        jQuery('#studentworks .grey_row_left span').show();
        var counter = parseInt(jQuery('#addexperience').val()) + 1;
        jQuery('#addexperience').val(counter);
        jQuery('.clsexperience').append('<div id="div_workexp_' + counter + '" class="panel-body experience">' +
                '<input type="hidden" class="pk_workexp_id" name="pk_workexp_id_' + counter + '" value="">' +
                '<div class="c_row">' +
                '<div class="c_left">' +
                '<label>Title*</label>' +
                '<input type="text" placeholder="Type here" class="exp_title alltxtfield " maxlength="100" id="exp_title_' + counter + '" name="exp_title_' + counter + '">' +
                '</div>' +
                '<div class="c_right">' +
                '<label>Company*</label>' +
                '<input type="text" placeholder="Type here" class="exp_compny alltxtfield " maxlength="100" id="exp_compny_' + counter + '" name="exp_compny_' + counter + '">' +
                '</div>' +
                '</div>' +
                '<div class="c_row">' +
                '<div class="c_left">' +
                '<label>City*</label>' +
                '<input type="text" placeholder="Type here" class="exp_city alltxtfield " maxlength="100" id="exp_city_' + counter + '" name="exp_city_' + counter + '">' +
                '</div>' +
                '<div class="c_right">' +
                '<label>State*</label>' +
                '<input type="text" placeholder="Type here" class="exp_state alltxtfield " maxlength="100" id="exp_state_' + counter + '" name="exp_state_' + counter + '">' +
                '</div>' +
                '</div>' +
                '<div class="c_row">' +
                '<div class="c_left">' +
                '<label>Years*</label>' +
                '<input type="text" placeholder="Type here" class="exp_years " id="exp_years_' + counter + '" name="exp_years_' + counter + '">' +
                '</div>' +
                '<div class="c_right">' +
                '<label>Description of Job They Want*</label>' +
                '<textarea placeholder="Type here" class="exp_description alltxtfield" id="exp_description_' + counter + '" name="exp_description_' + counter + '">' + '</textarea>' +
                '</div>' +
                '</div>' +
                '<a class="del_work" href="javascript:void(0);" onclick="Deletework(' + counter + ');">Delete</a>' +
                '</div>'

                );
        jQuery(".alltxtfield").keypress(function (event) {
            var inputValue = event.which;
// allow letters and whitespaces only.
            if (!(inputValue > 47 && inputValue < 58) && !(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0 && inputValue != 46 && inputValue != 08)) {
                event.preventDefault();
            }
        });
jQuery(".exp_years").keypress(function (e) {
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        e.preventDefault();
    }
});
        return false;
    });

//Start Student Skills
    jQuery(document).on("click", "#addstudentsskill", function (event) {
        event.preventDefault();
        jQuery('#studentskill .grey_row_left span').show();
        var counter = parseInt(jQuery('#addstudentskills').val()) + 1;
        jQuery('#addstudentskills').val(counter);
        var sf_class = '';
        if (counter % 2 == 0) {
            sf_class = 'c_right';
        } else {
            sf_class = 'c_left';
        }
        jQuery('.clsstudentskills').find('.c_row').last().append('<div class="' + sf_class + '"  id="skill_' + counter + '">' +
                '<label>Skill ' + counter + '*</label>' +
                '<input type="text" class="studentskill alltxtfield" placeholder="Type here" id="student_skill_' + counter + '" name="student_skill_' + counter + '">' +
                ' <input type="hidden" class="pk_skill_id" name="pk_skill_id_' + counter + '" value="">' +
                '<a class="del_skill" href="javascript:void(0);" onclick="Deleteskill(' + counter + ');">Delete</a>' +
                '</div>');
        jQuery(".alltxtfield").keypress(function (event) {
            var inputValue = event.which;
// allow letters and whitespaces only.
            if (!(inputValue > 47 && inputValue < 58) && !(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0 && inputValue != 46 && inputValue != 08)) {
                event.preventDefault();
            }
        });

        return false;
    });

//Start Student Course
    jQuery(document).on("click", "#addstudentscourse", function (event) {
        event.preventDefault();
        jQuery('#studentcource .grey_row_left span').show();
        var flage = parseInt(jQuery('#addcourse').val()) + 1;
        jQuery('#addcourse').val(flage);
        var sf_class = '';
        if (flage % 2 == 0) {
            sf_class = 'c_right';
        } else {
            sf_class = 'c_left';
        }
        jQuery('.clsCourse').find('.c_row').last().append(
                '<div class="' + sf_class + '" id="course_' + flage + '">' +
                '<label>Course ' + flage + '*</label>' +
                '<input type="text" class="studentcourse alltxtfield" placeholder="Type here" id="course_' + flage + '" name="course_' + flage + '">' +
                ' <input type="hidden" class="pk_course_id" name="pk_course_id_' + flage + '" value="">' +
                '<a class="del_course" href="javascript:void(0);" onclick="Deletecourse(' + flage + ');">Delete</a>' +
                '</div>');
        jQuery(".alltxtfield").keypress(function (event) {
            var inputValue = event.which;
// allow letters and whitespaces only.
            if (!(inputValue > 47 && inputValue < 58) && !(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0 && inputValue != 46 && inputValue != 08)) {
                event.preventDefault();
            }
        });
        return false;
    });


//validate email
    function validateEmail(sEmail) {
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (filter.test(sEmail)) {
            return true;
        } else {
            return false;
        }
    }

    jQuery("#phone").keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });

// allow only number
    jQuery("#studentphone").keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });

    if (jQuery(".txtdecimalval").length > 0) {
        jQuery(".txtdecimalval").keydown(function (e) {
            var isEnable = (e.which != 110) ? false : true;
            if (((e.which == 9) || (e.which == 46) || (e.which == 8) || (e.which == 110) || (e.which >= 48 && e.which <= 57) || (e.which >= 96 && e.which <= 105))) {
                if (isEnable == false && e.which == 110) {
                    return false;
                }
            } else {
                return false
            }
            if (isEnable == true) {
                isEnable = (e.which == 110) ? false : true;
            }
        });
    }
    jQuery(".alltxtfield").keypress(function (event) {
        var inputValue = event.which;
// allow letters and whitespaces only.
        if (!(inputValue > 47 && inputValue < 58) && !(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0 && inputValue != 46 && inputValue != 08)) {
            event.preventDefault();
        }
    });
    
    jQuery(".exp_years").keypress(function (e) {
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
       e.preventDefault();
    }
});
    
    

    //-----------Check Validation ans save all form on Click Publish ------------//
    jQuery('a.publis').click(function (event) {
        event.preventDefault();

        var personal_flag = jQuery(".submitpersonalinfo").trigger("click", [, "final"]).data("status");
        var about_flag = jQuery(".submitfewthingaboutstudent").trigger("click", [, "final"]).data("status");
        var project_flag = jQuery(".submitstudentprojects").trigger("click", [, "final"]).data("status");
        var work_flag = jQuery(".submitstudentworkexperience").trigger("click", [, "final"]).data("status");
        var skill_flag = jQuery(".submitstudentskill").trigger("click", [, "final"]).data("status");
        var cource_flag = jQuery(".submitstudentcourse").trigger("click", [, "final"]).data("status");
        var software_flag = jQuery(".submitstudentsoftwareknowledge").trigger("click", [, "final"]).data("status");
        var honor_flag = jQuery(".submitstudenthonor").trigger("click", [, "final"]).data("status");
        var activity_flag = jQuery(".submitstudenactivity").trigger("click", [, "final"]).data("status");
        var interest_flag = jQuery(".submitstudeinterest").trigger("click", [, "final"]).data("status");
        var references_flag = jQuery(".submitstudentreferences").trigger("click", [, "final"]).data("status");

        if (personal_flag == 'true' && about_flag == 'true' && project_flag == 'true' && work_flag == 'true' && skill_flag == 'true' && cource_flag == 'true' && software_flag == 'true' && honor_flag == 'true' && activity_flag == 'true' && interest_flag == 'true' && references_flag == 'true') {
            jQuery('#publish').modal('show');

        } else {
            jQuery('#feedback').modal('hide');
            jQuery('.return_msg').after('<label class="text-danger return_msg1">Please complete the above fields</label>');
            jQuery(".return_msg1").fadeOut(5000);
            jQuery('html,body').unbind().animate({scrollTop: jQuery('.save_err:visible:first').offset().top - 50}, 'slow');
            return false;
        }
    });
});

//------------ Remove Project ------------//]
function Deleteproject(id) {
    var project_count = jQuery('#addproject').val();
    project_count--;
    jQuery("#div_project_" + id).remove();
    jQuery('.projects').each(function (index) {
        var count = index + 1;
        var proj = this.id;
        jQuery('#' + proj + '  label:eq(0)').text('Project ' + count + '*');

    });
    jQuery('#addproject').val(project_count);
}

//------------ Remove software------------//]
function Deletesoftware(id) {
    var software_count = jQuery('#addsoftware').val();
    software_count--;
    jQuery("#software_" + id).remove();
    jQuery('.studentsoftware').each(function (index) {
        var count = index + 1;
        if (jQuery(this).parent().hasClass("c_left")) {
            jQuery(this).parent().removeClass("c_left");
        }
        if (jQuery(this).parent().hasClass("c_right")) {
            jQuery(this).parent().removeClass("c_right");
        }
        if (count % 2 == 0) {
            jQuery(this).parent().addClass("c_right");
        } else {
            jQuery(this).parent().addClass("c_left");
        }
        jQuery(this).parent().find('label').text('Software ' + count + '*');

    });
    jQuery('#addsoftware').val(software_count);
}

//------------ Remove honor------------//]
function Deletehonor(id) {
    var honor_count = jQuery('#addhonor').val();
    honor_count--;
    jQuery("#honor_" + id).remove();
    jQuery('.studenthonor').each(function (index) {
        var count = index + 1;
        if (jQuery(this).parent().hasClass("c_left")) {
            jQuery(this).parent().removeClass("c_left");
        }
        if (jQuery(this).parent().hasClass("c_right")) {
            jQuery(this).parent().removeClass("c_right");
        }
        if (count % 2 == 0) {
            jQuery(this).parent().addClass("c_right");
        } else {
            jQuery(this).parent().addClass("c_left");
        }
        jQuery(this).parent().find('label').text('Honor ' + count + '*');

    });
    jQuery('#addhonor').val(honor_count);
}

//------------ Remove activity------------//]
function Deleteactivity(id) {
    var activity_count = jQuery('#addactivity').val();
    activity_count--;
    jQuery("#activity_" + id).remove();
    jQuery('.studentactivities').each(function (index) {
        var count = index + 1;
        if (jQuery(this).parent().hasClass("c_left")) {
            jQuery(this).parent().removeClass("c_left");
        }
        if (jQuery(this).parent().hasClass("c_right")) {
            jQuery(this).parent().removeClass("c_right");
        }
        if (count % 2 == 0) {
            jQuery(this).parent().addClass("c_right");
        } else {
            jQuery(this).parent().addClass("c_left");
        }
        jQuery(this).parent().find('label').text('Activity ' + count + '*');

    });
    jQuery('#addactivity').val(activity_count);
}

//------------ Remove interest------------//]
function Deleteinterest(id) {
    var interest_count = jQuery('#addinterest').val();
    interest_count--;
    jQuery("#interest_" + id).remove();
    jQuery('.studentinterest').each(function (index) {
        var count = index + 1;
        if (jQuery(this).parent().hasClass("c_left")) {
            jQuery(this).parent().removeClass("c_left");
        }
        if (jQuery(this).parent().hasClass("c_right")) {
            jQuery(this).parent().removeClass("c_right");
        }
        if (count % 2 == 0) {
            jQuery(this).parent().addClass("c_right");
        } else {
            jQuery(this).parent().addClass("c_left");
        }
        jQuery(this).parent().find('label').text('Interest ' + count + '*');

    });
    jQuery('#addinterest').val(interest_count);
}

//------------ Remove referenc------------//]
function Deletereferenc(id) {
    var referenc_count = jQuery('#addreferences').val();
    referenc_count--;
    jQuery("#referenc_" + id).remove();
    jQuery('.studentreferences').each(function (index) {
        var count = index + 1;
        if (jQuery(this).parent().hasClass("c_left")) {
            jQuery(this).parent().removeClass("c_left");
        }
        if (jQuery(this).parent().hasClass("c_right")) {
            jQuery(this).parent().removeClass("c_right");
        }
        if (count % 2 == 0) {
            jQuery(this).parent().addClass("c_right");
        } else {
            jQuery(this).parent().addClass("c_left");
        }
        jQuery(this).parent().find('label').text('Reference ' + count + '*');

    });
    jQuery('#addreferences').val(referenc_count);
}

//------------ Remove Work Experience ------------//]
function Deletework(id) {
    var work_count = jQuery('#addexperience').val();
    work_count--;
    jQuery("#div_workexp_" + id).remove();
    jQuery('.experience').each(function (index) {
        var count = index + 1;
        var proj = this.id;

    });
    jQuery('#addexperience').val(work_count);
}
//------------ Remove skill------------//]
function Deleteskill(id) {
    var skill_count = jQuery('#addstudentskills').val();
    skill_count--;
    jQuery("#skill_" + id).remove();
    jQuery('.studentskill').each(function (index) {
        var count = index + 1;
        if (jQuery(this).parent().hasClass("c_left")) {
            jQuery(this).parent().removeClass("c_left");
        }
        if (jQuery(this).parent().hasClass("c_right")) {
            jQuery(this).parent().removeClass("c_right");
        }
        if (count % 2 == 0) {
            jQuery(this).parent().addClass("c_right");
        } else {
            jQuery(this).parent().addClass("c_left");
        }
        jQuery(this).parent().find('label').text('Skill ' + count + '*');

    });
    jQuery('#addstudentskills').val(skill_count);
}


//------------ Remove Course------------//]
function Deletecourse(id) {
    var course_count = jQuery('#addcourse').val();
    course_count--;
    jQuery("#course_" + id).remove();
    jQuery('.studentcourse').each(function (index) {
        var count = index + 1;
        if (jQuery(this).parent().hasClass("c_left")) {
            jQuery(this).parent().removeClass("c_left");
        }
        if (jQuery(this).parent().hasClass("c_right")) {
            jQuery(this).parent().removeClass("c_right");
        }
        if (count % 2 == 0) {
            jQuery(this).parent().addClass("c_right");
        } else {
            jQuery(this).parent().addClass("c_left");
        }
        jQuery(this).parent().find('label').text('Course ' + count + '*');

    });
    jQuery('#addcourse').val(course_count);
}

//Assign resume category to completed Resume
function save_cat(package_id) {
    jQuery('#loding').show();
    var admin_url = jQuery('#admin_url').val();
    var cat_id = jQuery('#order_' + package_id).val();
    jQuery.ajax({
        url: admin_url,
        type: "POST",
        data: {
            action: 'assign_resume_category',
            cat_id: cat_id,
            package_id: package_id
        },
        success: function (data) {
            jQuery("#assign_msg_" + package_id).html(data);
            jQuery(".assign_msg1").fadeOut(5000);
            jQuery('#loding').hide();
            location.reload();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            jQuery('#loding').hide();
            console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
        }
    });
}
