(function ($) {
    $(window).on("load", function () {
        $(".comment_box_main_content").mCustomScrollbar();
        $(".noti_scroll").mCustomScrollbar();
    });
})(jQuery);

//---------------View per Page ---------//
$('#view').on('change', function () {
    $('#resume').submit();
});

//---------------View assigned job ---------//
$('#assigned').click(function () {
    window.location.href = $('#dashboard').val() + '?assigned=' + $('#user_id').val();
});

//---------------View unassigned job ---------//
$('#unassigned').click(function () {
    window.location.href = $('#dashboard').val() + '?unassigned=1';
});

//---------------View open job ---------//
$('#open').click(function () {
    window.location.href = $('#dashboard').val() + '?open=1';
});

//---------------View all job ---------//
$('#all').click(function () {
    window.location.href = $('#dashboard').val();
});

//---------------tabs on profile page ---------//
$('.responsive-tabs').responsiveTabs({
    accordionOn: ['xs', 'sm', 'md'] // xs, sm, md, lg
});

//---------------enable email on profile page ---------//
$('#profile_acc .chng_btn').click(function (event) {
    event.preventDefault();
    $('#profile_acc #email').removeProp("disabled");
});

$(document).ready(function () {
    //---- Delete saved Project -------//
    $('.del_prj').click(function () {
        var project_id = $(this).attr("data-prj_id");
        var id = $(this).attr("data-id");
        $('#loding').show();
        var admin_url = $('#admin_url').val();
        $.ajax({
            url: admin_url,
            type: "POST",
            data: {
                action: 'delete_project',
                project_id: project_id
            },
            success: function (data) {
                if (data == 1) {
                    var project_count = $('#addproject').val();
                    project_count--;
                    $("#div_project_" + id).remove();
                    $('.projects').each(function (index) {
                        var count = index + 1;
                        var proj = this.id;
                        $('#' + proj + '  label:eq(0)').text('Project ' + count + '*');

                    });
                    $('#addproject').val(project_count);
                }
                $('#loding').hide();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });

    //---- Delete saved work experiance -------//
    $('.del_works').click(function () {
        var work_id = $(this).attr("data-work_id");
        var id = $(this).attr("data-id");
        $('#loding').show();
        var admin_url = $('#admin_url').val();
        $.ajax({
            url: admin_url,
            type: "POST",
            data: {
                action: 'delete_work',
                work_id: work_id
            },
            success: function (data) {
                if (data == 1) {
                    var work_count = $('#addexperience').val();
                    work_count--;
                    $("#div_workexp_" + id).remove();

                    $('.experience').each(function (index) {
                        var count = index + 1;
                        var proj = this.id;

                    });
                    $('#addexperience').val(work_count);
                }
                $('#loding').hide();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });

    //---- Delete saved skills -------//
    $('.del_skills').click(function () {
        var skill_id = $(this).attr("data-skill_id");
        var id = $(this).attr("data-id");
        $('#loding').show();
        var admin_url = $('#admin_url').val();
        $.ajax({
            url: admin_url,
            type: "POST",
            data: {
                action: 'delete_skill',
                skill_id: skill_id
            },
            success: function (data) {
                if (data == 1) {
                    var skill_count = $('#addstudentskills').val();
                    skill_count--;
                    $("#skill_" + id).remove();
                    $('.studentskill').each(function (index) {
                        var count = index + 1;
                        if ($(this).parent().hasClass("c_left")) {
                            $(this).parent().removeClass("c_left");
                        }
                        if ($(this).parent().hasClass("c_right")) {
                            $(this).parent().removeClass("c_right");
                        }
                        if (count % 2 == 0) {
                            $(this).parent().addClass("c_right");
                        } else {
                            $(this).parent().addClass("c_left");
                        }
                        $(this).parent().find('label').text('Skill ' + count + '*');

                    });
                    $('#addstudentskills').val(skill_count);

                }
                $('#loding').hide();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });

    //---- Delete saved Cources -------//
    $('.del_courses').click(function () {
        var course_id = $(this).attr("data-course_id");
        var id = $(this).attr("data-id");
        $('#loding').show();
        var admin_url = $('#admin_url').val();
        $.ajax({
            url: admin_url,
            type: "POST",
            data: {
                action: 'delete_cources',
                course_id: course_id
            },
            success: function (data) {
                if (data == 1) {
                    var course_count = $('#addcourse').val();
                    course_count--;
                    $("#course_" + id).remove();
                    $('.studentcourse').each(function (index) {
                        var count = index + 1;
                        if ($(this).parent().hasClass("c_left")) {
                            $(this).parent().removeClass("c_left");
                        }
                        if ($(this).parent().hasClass("c_right")) {
                            $(this).parent().removeClass("c_right");
                        }
                        if (count % 2 == 0) {
                            $(this).parent().addClass("c_right");
                        } else {
                            $(this).parent().addClass("c_left");
                        }
                        $(this).parent().find('label').text('Course ' + count + '*');

                    });
                    $('#addcourse').val(course_count);
                }
                $('#loding').hide();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });

    //---- Delete saved software -------//
    $('.del_sw').click(function () {
        var sw_id = $(this).attr("data-sw_id");
        var id = $(this).attr("data-id");
        $('#loding').show();
        var admin_url = $('#admin_url').val();
        $.ajax({
            url: admin_url,
            type: "POST",
            data: {
                action: 'delete_sw',
                sw_id: sw_id
            },
            success: function (data) {
                if (data == 1) {
                    var software_count = $('#addsoftware').val();
                    software_count--;
                    $("#software_" + id).remove();
                    $('.studentsoftware').each(function (index) {
                        var count = index + 1;
                        if ($(this).parent().hasClass("c_left")) {
                            $(this).parent().removeClass("c_left");
                        }
                        if ($(this).parent().hasClass("c_right")) {
                            $(this).parent().removeClass("c_right");
                        }
                        if (count % 2 == 0) {
                            $(this).parent().addClass("c_right");
                        } else {
                            $(this).parent().addClass("c_left");
                        }
                        $(this).parent().find('label').text('Software ' + count + '*');

                    });
                    $('#addsoftware').val(software_count);

                }
                $('#loding').hide();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });

    //---- Delete saved Honors -------//
    $('.del_honors').click(function () {
        var honor_id = $(this).attr("data-honor_id");
        var id = $(this).attr("data-id");
        $('#loding').show();
        var admin_url = $('#admin_url').val();
        $.ajax({
            url: admin_url,
            type: "POST",
            data: {
                action: 'delete_honors',
                honor_id: honor_id
            },
            success: function (data) {
                if (data == 1) {

                    var honor_count = $('#addhonor').val();
                    honor_count--;
                    $("#honor_" + id).remove();
                    $('.studenthonor').each(function (index) {
                        var count = index + 1;
                        if ($(this).parent().hasClass("c_left")) {
                            $(this).parent().removeClass("c_left");
                        }
                        if ($(this).parent().hasClass("c_right")) {
                            $(this).parent().removeClass("c_right");
                        }
                        if (count % 2 == 0) {
                            $(this).parent().addClass("c_right");
                        } else {
                            $(this).parent().addClass("c_left");
                        }
                        $(this).parent().find('label').text('Honor ' + count + '*');

                    });
                    $('#addhonor').val(honor_count);

                }
                $('#loding').hide();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });

    //---- Delete saved Activity -------//
    $('.del_activities').click(function () {
        var activity_id = $(this).attr("data-activity_id");
        var id = $(this).attr("data-id");
        $('#loding').show();
        var admin_url = $('#admin_url').val();
        $.ajax({
            url: admin_url,
            type: "POST",
            data: {
                action: 'delete_activity',
                activity_id: activity_id
            },
            success: function (data) {
                if (data == 1) {
                    var activity_count = $('#addactivity').val();
                    activity_count--;
                    $("#activity_" + id).remove();
                    $('.studentactivities').each(function (index) {
                        var count = index + 1;
                        if ($(this).parent().hasClass("c_left")) {
                            $(this).parent().removeClass("c_left");
                        }
                        if ($(this).parent().hasClass("c_right")) {
                            $(this).parent().removeClass("c_right");
                        }
                        if (count % 2 == 0) {
                            $(this).parent().addClass("c_right");
                        } else {
                            $(this).parent().addClass("c_left");
                        }
                        $(this).parent().find('label').text('Activity ' + count + '*');

                    });
                    $('#addactivity').val(activity_count);
                }
                $('#loding').hide();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });

    //---- Delete saved Interest -------//
    $('.del_interests').click(function () {
        var interest_id = $(this).attr("data-interest_id");
        var id = $(this).attr("data-id");
        $('#loding').show();
        var admin_url = $('#admin_url').val();
        $.ajax({
            url: admin_url,
            type: "POST",
            data: {
                action: 'delete_intrest',
                interest_id: interest_id
            },
            success: function (data) {
                if (data == 1) {
                    var interest_count = $('#addinterest').val();
                    interest_count--;
                    $("#interest_" + id).remove();
                    $('.studentinterest').each(function (index) {
                        var count = index + 1;
                        if ($(this).parent().hasClass("c_left")) {
                            $(this).parent().removeClass("c_left");
                        }
                        if ($(this).parent().hasClass("c_right")) {
                            $(this).parent().removeClass("c_right");
                        }
                        if (count % 2 == 0) {
                            $(this).parent().addClass("c_right");
                        } else {
                            $(this).parent().addClass("c_left");
                        }
                        $(this).parent().find('label').text('Interest ' + count + '*');

                    });
                    $('#addinterest').val(interest_count);
                }
                $('#loding').hide();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });

    //---- Delete saved Reference -------//
    $('.del_ref').click(function () {
        var ref_id = $(this).attr("data-ref_id");
        var id = $(this).attr("data-id");
        $('#loding').show();
        var admin_url = $('#admin_url').val();
        $.ajax({
            url: admin_url,
            type: "POST",
            data: {
                action: 'delete_ref',
                ref_id: ref_id
            },
            success: function (data) {
                if (data == 1) {
                    var referenc_count = $('#addreferences').val();
                    referenc_count--;
                    $("#referenc_" + id).remove();
                    $('.studentreferences').each(function (index) {
                        var count = index + 1;
                        if ($(this).parent().hasClass("c_left")) {
                            $(this).parent().removeClass("c_left");
                        }
                        if ($(this).parent().hasClass("c_right")) {
                            $(this).parent().removeClass("c_right");
                        }
                        if (count % 2 == 0) {
                            $(this).parent().addClass("c_right");
                        } else {
                            $(this).parent().addClass("c_left");
                        }
                        $(this).parent().find('label').text('Reference ' + count + '*');

                    });
                    $('#addreferences').val(referenc_count);
                }
                $('#loding').hide();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });

    $('#get_job').click(function (event) {
        if ($('input[name=job]:checked').length <= 0)
        {
            $('#get_job').before('<label class="text-danger return_msg1">Please Select Job option..</label>');
            $(".return_msg1").fadeOut(5000);
            return false;
        } else {
            return true;
        }
    });


    //-----------Check Validation ans save all form on Click Return for Feedback ------------//
    $('a.return_feedback').click(function (event) {
        event.preventDefault();
        $('.return_msg1').remove();
        $('#loding').show();

        var personal_flag = $(".submitpersonalinfo").trigger("click", [, "final"]).data("status");
        var about_flag = $(".submitfewthingaboutstudent").trigger("click", [, "final"]).data("status");
        var project_flag = $(".submitstudentprojects").trigger("click", [, "final"]).data("status");
        var work_flag = $(".submitstudentworkexperience").trigger("click", [, "final"]).data("status");
        var skill_flag = $(".submitstudentskill").trigger("click", [, "final"]).data("status");
        var cource_flag = $(".submitstudentcourse").trigger("click", [, "final"]).data("status");
        var software_flag = $(".submitstudentsoftwareknowledge").trigger("click", [, "final"]).data("status");
        var honor_flag = $(".submitstudenthonor").trigger("click", [, "final"]).data("status");
        var activity_flag = $(".submitstudenactivity").trigger("click", [, "final"]).data("status");
        var interest_flag = $(".submitstudeinterest").trigger("click", [, "final"]).data("status");
        var references_flag = $(".submitstudentreferences").trigger("click", [, "final"]).data("status");

        if (personal_flag == 'true' && about_flag == 'true' && project_flag == 'true' && work_flag == 'true' && skill_flag == 'true' && cource_flag == 'true' && software_flag == 'true' && honor_flag == 'true' && activity_flag == 'true' && interest_flag == 'true' && references_flag == 'true') {
            $('#feedback').modal('show');

        } else {
            $('#feedback').modal('hide');
            $('#loding').hide();
            $('.return_msg').html('<label class="text-danger return_msg1">Please complete the above fields</label>');
            $(".return_msg1").fadeOut(5000);
            $('html,body').unbind().animate({scrollTop: $('.save_err:visible:first').offset().top - 50}, 'slow');
            return false;
        }
    });

    //----------- Save final comment on click Return for Feedback and return resume -----------//
    $('#cmt_feed').click(function (event) {
        event.preventDefault();
        var comment = $('#comment_feed').val();
        var package_id = $('#package_id').val();
        var admin_url = $('#admin_url').val();
        var user_id = $('#user_id').val();
        var currentuser_id = $('#currentuser_id').val();
        if (comment) {
            $.ajax({
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
                    $('.comment_feed_msg').html(data);
                    $(".comment_feed1").fadeOut(5000);
                    $('#loding').hide();
                    location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
            });
        } else {
            $('#comment_feed').after('<label class="text-danger comment_feed1">First Enter Comment</label>');
            $(".comment_feed1").fadeOut(5000);
            return false;
        }
    });

    //-----------Check Validation ans save all form on Click Publish ------------//
    $('a.publis').click(function (event) {
        event.preventDefault();
        $(".return_msg1").remove();
        $('#loding').show();

        var personal_flag = $(".submitpersonalinfo").trigger("click", [, "final"]).data("status");
        var about_flag = $(".submitfewthingaboutstudent").trigger("click", [, "final"]).data("status");
        var project_flag = $(".submitstudentprojects").trigger("click", [, "final"]).data("status");
        var work_flag = $(".submitstudentworkexperience").trigger("click", [, "final"]).data("status");
        var skill_flag = $(".submitstudentskill").trigger("click", [, "final"]).data("status");
        var cource_flag = $(".submitstudentcourse").trigger("click", [, "final"]).data("status");
        var software_flag = $(".submitstudentsoftwareknowledge").trigger("click", [, "final"]).data("status");
        var honor_flag = $(".submitstudenthonor").trigger("click", [, "final"]).data("status");
        var activity_flag = $(".submitstudenactivity").trigger("click", [, "final"]).data("status");
        var interest_flag = $(".submitstudeinterest").trigger("click", [, "final"]).data("status");
        var references_flag = $(".submitstudentreferences").trigger("click", [, "final"]).data("status");

        if (personal_flag == 'true' && about_flag == 'true' && project_flag == 'true' && work_flag == 'true' && skill_flag == 'true' && cource_flag == 'true' && software_flag == 'true' && honor_flag == 'true' && activity_flag == 'true' && interest_flag == 'true' && references_flag == 'true') {
            $('#publish').modal('show');

        } else {
            $('#loding').hide();
            $('#feedback').modal('hide');
            $('.return_msg').html('<label class="text-danger return_msg1">Please complete the above fields</label>');
            $(".return_msg1").fadeOut(5000);
            $('html,body').unbind().animate({scrollTop: $('.save_err:visible:first').offset().top - 50}, 'slow');
            return false;
        }
    });

    //---------------Disable Resume fields on reviewer dashboard profile ---------//
    $('.readonly_fields input').prop('readonly', true);
    $('.readonly_fields textarea').prop('readonly', true);
    $('.readonly_fields select').css('pointer-events', 'none');
    $('.readonly_fields input[type="submit"]').attr('disabled', 'disabled');
    $(".readonly_fields textarea").prop('disabled', true);
    $(".readonly_fields input").prop('disabled', true);
    $(".readonly_fields a.assign").removeAttr('data-toggle');
    $(".readonly_fields a.assign").removeAttr('href');
    $(".readonly_fields button").prop('disabled', true);
    $('.readonly_fields a.hide_del').css('display', 'none');

    //---------------Personal Info validation---------//
    $("form#profile_acc").validate({
        rules: {
            fname: {
                required: true,
                specialChars: true
            },
            lname: {
                required: true,
                specialChars: true
            },
            email1: {
                required: true,
                email: true
            },
            phone: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 15
            }
        },
        messages: {
            "fname": {
                required: "This Field Is Required.",
                specialChars: "No Speacial Character Allowed"
            },
            "lname": {
                required: "This Field Is Required.",
                specialChars: "No Speacial Character Allowed"
            },
            "email": {
                required: "This Field Is Required.",
                email: "Enter valid email."
            },
            "phone": {
                required: "This Field Is Required.",
                number: "Numbers Only"
            }
        },
        errors: function () {
            var errorClass = this.settings.errorClass.split(" ").join(".");
            return $(this.settings.errorElement + "." + errorClass, this.errorContext);
        },
        submitHandler: function (form) {
            $('#loding').show();
            $('.profile_msg').remove();
            var admin_url = $('#admin_url').val();
            var fname = $('#fname').val();
            var lname = $('#lname').val();
            var phone = $('#phone').val();
            var email = $('#email').val();
            var uname = fname + ' ' + lname;
            $.ajax({
                url: admin_url,
                type: "POST",
                data: {
                    action: 'save_profile',
                    fname: fname,
                    lname: lname,
                    phone: phone,
                    email: email
                },
                dataType: "html",
                success: function (data) {
                    $('.profile_name h4').text(uname);
                    $('span.username').text(uname);
                    $('.mail a').text(email);
                    $('.mail a').attr("href", "mailto:" + email);
                    $('.phone a').text(phone);
                    $('.phone a').attr("href", "tel:" + phone);
                    $(".acc_msg").html(data);
                    $(".profile_msg").fadeOut(5000);
                    $('#loding').hide();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
            });
        }
    });

    //---------------Change Password validation---------//
    $("form#profile_pass").validate({
        rules: {
            pass: {
                required: true
            },
            new_pass: {
                required: true,
                minlength: 5
            },
            conf_pass: {
                required: true,
                minlength: 5
            }
        },
        messages: {
            "pass": "This Is Required.",
            "new_pass": {
                required: "This Is Required.",
                minlength: "Enter at least 5 characters."
            },
            "conf_pass": {
                required: "This Is Required.",
                minlength: "Enter at least 5 characters."
            }
        },
        errors: function () {
            var errorClass = this.settings.errorClass.split(" ").join(".");
            return $(this.settings.errorElement + "." + errorClass, this.errorContext);
        },
        submitHandler: function (form) {
            $('#loding').show();
            $('.pass_msg1').remove();
            var admin_url = $('#admin_url').val();
            var pass = $('#pass').val();
            var new_pass = $('#new_pass').val();
            var conf_pass = $('#conf_pass').val();
            if (new_pass != conf_pass) {
                $('.pass_msg1').remove();
                $('.pass_msg').append('<span class="text-danger pass_msg1">Confirm Password not match...</span>');
                $(".pass_msg1").fadeOut(5000);
                $('#loding').hide();
                return false;
            } else if (pass == new_pass) {
                $('.pass_msg1').remove();
                $('.pass_msg').append('<span class="text-danger pass_msg1">Old password and new password are same. entre different passweord.</span>');
                $(".pass_msg1").fadeOut(5000);
                $('#loding').hide();
                return false;
            } else {
                $.ajax({
                    url: admin_url,
                    type: "POST",
                    data: {
                        action: 'save_pass',
                        pass: pass,
                        new_pass: new_pass,
                        conf_pass: conf_pass
                    },
                    dataType: "html",
                    success: function (data) {
                        $('#pass').val('');
                        $('#new_pass').val('');
                        $('#conf_pass').val('');
                        $(".pass_msg").html(data);
                        $(".pass_msg1").fadeOut(5000);
                        $('#loding').hide();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                    }
                });
            }
        }
    });

    //Save Comment
    $('#add_comment').click(function (e) {
        e.preventDefault();
        var comment = $('#comment').val();
        if (comment) {
            $("#comment").css('border', '1px solid #c2cad8');
            $('.comment_msg').remove();
            $('#loding').show();
            var package_id = $('#package_id').val();
            var admin_url = $('#admin_url').val();
            var user_id = $('#user_id').val();
            var currentuser_id = $('#currentuser_id').val();
            $.ajax({
                url: admin_url,
                type: "POST",
                data: {
                    action: 'save_comment',
                    user_id: user_id,
                    package_id: package_id,
                    comment: comment,
                    currentuser_id: currentuser_id
                },
                success: function (data) {
                    $('.msg').html(data);
                    $(".comment_msg").fadeOut(5000);
                    $('#loding').hide();
                    location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
            });
        } else {
            $('#comment').after('<label class="text-danger comment_msg">First Enter Comment</label>');
            $(".comment_msg").fadeOut(5000);
            return false;
        }

    });

});

$('.frmUpload .cancel').click(function () {
    $('#output').attr('src', $('#profile_pic').attr('src'));
});

//---------------Check Image type---------//
function allvalidateimageFile(file, imageName) {
    $('.frmUpload .cancel').show();
    var ext = file.split(".");
    ext = ext[ext.length - 1].toLowerCase();
    var arrayExtensions = ["jpg", "jpeg", "png"];
    if (arrayExtensions.lastIndexOf(ext) == -1) {
        $('#output').attr('src', '');
        $(".pic_msg").html('<span class="text-danger pic_msg1 ">Wrong extension type.Please upload valid file</span>');
        $(".pic_msg1").fadeOut(5000);
        return false;
    } else if ($('#profile_img')[0].files[0].size > 1000000) {
        $('#output').attr('src', '');
        $(".pic_msg").html('<span class="text-danger pic_msg1 ">Please upload max 1MB size file.</span>');
        $(".pic_msg1").fadeOut(5000);
        $("#profile_img").val('');
        return false;
    } else {
        var reader = new FileReader();
        reader.onload = function () {
            var output = document.getElementById('output');
            output.src = reader.result;
        };
        reader.readAsDataURL($('#profile_img')[0].files[0]);
        return true;
    }
}

//---------------Change Profile Validation ---------//
$('#pro_pic').on('click', function (e) {
    e.preventDefault();
    $('#loding').show();
    var admin_url = $('#admin_url').val();
    if (!$('#output').attr('src')) {
        $(".pic_msg").html('<span class="text-danger pic_msg1 ">Select Profile Picture </span>');
        $(".pic_msg1").fadeOut(5000);
        $('#output').attr('src', '');
        $('#loding').hide();
        return false;
    }
    var img = document.getElementById('output');
    var width = img.naturalWidth;
    var height = img.naturalHeight;
    if (width < 100 || height < 100) {
        $(".pic_msg").html('<span class="text-danger pic_msg1 ">Image is small. enter image of 155X155 Dimensions</span>');
        $(".pic_msg1").fadeOut(5000);
        $('#output').attr('src', '');
        $('#loding').hide();

    } else if (width > 200 || height > 200) {
        $('#output').attr('src', '');
        $(".pic_msg").html('<span class="text-danger pic_msg1 ">Image is large. enter image of 155X155 Dimensions</span>');
        $(".pic_msg1").fadeOut(5000);
        $('#loding').hide();

    } else {
        if ($('#profile_img').val() == '') {
            $(".pic_msg").html('<span class="text-danger pic_msg1 ">Select different Profile Picture to change </span>');
            $(".pic_msg1").fadeOut(5000);
            $('#loding').hide();
            return false;
        }
        var file_data = $('#profile_img').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        form_data.append('action', 'save_pic');
        $.ajax({
            url: admin_url,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (data) {
                $('.frmUpload .cancel').hide();
                $('#profile_pic').attr('src', data['image']);
                $('.output').attr('src', data['image']);
                $(".pic_msg").html(data['message']);
                $(".pic_msg1").fadeOut(10000);
                window.setTimeout(function () {
                    $('#loding').hide();
                }, 500);
            }
        });
    }
});

//---------------Add validation for specialChars---------//
jQuery.validator.addMethod("specialChars", function (value, element) {
    var regex = new RegExp("^[a-zA-Z0-9].+$");
    var key = value;
    if (!regex.test(key)) {
        return false;
    }
    return true;
}, "please use only alphanumeric or alphabetic characters");

//----------- Package -------------//
$('.accordion .panel-title a').click(function () {
    // $('.accordion .panel-title a').parent().parent().removeClass('active');
    if ($(this).parent().parent().hasClass('active')) {

        $(this).parent().parent().removeClass('active').siblings();
    } else {
        $('.accordion .panel-title a').parent().parent().removeClass('active');
        $(this).parent().parent().addClass('active').siblings();
    }
});
(function ($) {
    $(window).on("load", function () {
        $(".comment_box_main_content").mCustomScrollbar();
        $(".noti_scroll").mCustomScrollbar();
    });
})(jQuery);

//Bind Package id to assign
$('.assign_dash').click(function (e) {
    e.preventDefault();
    var package_id = $(this).data().bind;
    $('#assign #package_id').val(package_id);
    $('#assign').modal('show');
});

$('#assignto').click(function (e) {
    e.preventDefault();
    $('#loding').show();

    var assign = $('#assign select').val();
    var currentuser_id = $('#currentuser_id').val();
    var package_id = '';
    if (assign == 0) {
        $(".assign_msg").html('<span class="text-danger assign_msg1 ">Select Reviewer...</span>');
        $('#loding').hide();
        $(".assign_msg1").fadeOut(5000);
    } else {
        var admin_url = $('#admin_url').val();
        package_id = $('#package_id').val();
        $.ajax({
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
                    if ($('#review').length) {
                        $('#review').text(data['review']);
                    }
                $(".assign_msg").html(data['message']);
                $(".assign_msg1").fadeOut(5000);
                $('#loding').hide();
                location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    }
});

// allow only number
$("#phone").keypress(function (e) {
    if (e.which == 8 && e.which == 0 && (e.which < 48 || e.which > 57)) {
        return false;
    }
});

//--------------- Personal Informational  validation---------//
$(document).on("click", ".submitpersonalinfo", function (event, parentform, final) {
    event.preventDefault();
    $('.personal_err').remove();
    var studentname = $('#studentname').val();
    var studentphone = $('#studentphone').val();
    var studentemail = $('#studentemail').val();
    var studentschool = $('#studentschool').val();
    var studentcity = $('#studentcity').val();
    var studentdegree = $('#studentdegree').val();
    var studentgraduationdate = $('#studentgraduationdate').val();
    var studentlinkedinprofile = $('#studentlinkedinprofile').val();
    var studentendorsment = $('#studentendorsment').val();
    var studentdescforjob = $('#studentdescforjob').val();

    var statusflag = 'true';
    if (studentname == '') {
        $('#studentname').after('<label class="text-danger personal_err">The field is required.</label>');
        statusflag = false;
    }
    if (studentphone == '') {
        $('#studentphone').after('<label class="text-danger personal_err">The field is required.</label>');
        statusflag = 'false';
    }
    if ($('#studentemail').val() == "" || !validateEmail($('#studentemail').val())) {

        $("#studentemail").after('<label class="text-danger personal_err">Please enter valid email address</label>');
        statusflag = 'false';
    }
    if (studentschool == '') {
        $('#studentschool').after('<label class="text-danger personal_err">The field is required.</label>');
        statusflag = false;
    }

    if (studentdegree == '') {
        $('#studentdegree').after('<label class="text-danger personal_err">The field is required.</label>');
        statusflag = false;
    }
    if (studentgraduationdate == '') {
        $('#studentgraduationdate').after('<label class="text-danger personal_err">The field is required.</label>');
        statusflag = false;
    }
    if (studentlinkedinprofile == '') {

    } else if (/(ftp|http|https):\/\/?(?:www\.)?linkedin.com(\w+:{0,1}\w*@)?(\S+)(:([0-9])+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/.test(studentlinkedinprofile)) {

    } else {
        $('#studentlinkedinprofile').after('<label class="text-danger personal_err">Please enter valid url</label>');
        statusflag = false;
    }
    if (studentendorsment == '') {
        $('#studentendorsment').after('<label class="text-danger personal_err">The field is required.</label>');
        statusflag = false;
    }

    $(this).data("status", statusflag);

    if (statusflag == 'true' && parentform == undefined) {
        $('a.personal').css('border', '1px solid #39a95e');
        $('#loding').show();
        var package_id = $('#package_id').val();
        var studentname = $('#studentname').val();
        var studentphone = $('#studentphone').val();
        var studentemail = $('#studentemail').val();
        var studentschool = $('#studentschool').val();
        var studentcity = $('#studentcity').val();
        var studentdegree = $('#studentdegree').val();
        var gdate = $('#studentgraduationdate').val();
        var studentlinkedinprofile = $('#studentlinkedinprofile').val();
        var studentendorsment = $('#studentendorsment').val();
        var jobdescription = $('#studentdescforjob').val();
        var admin_url = $('#admin_url').val();
        $.ajax({
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
                $('.info_msg').html(data);
                $(".info_msg1").fadeOut(5000);
                if (final == undefined) {
                    $('#loding').hide();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }

        });
    } else if (statusflag == 'true') {
        return true;
    } else {
        $('a.personal').css('border', '1px solid red');
        $('a.personal').addClass("save_err");
        return false;
    }
});

//validations for few things about student
$(document).on("click", ".submitfewthingaboutstudent", function (event, parentform, final) {
    event.preventDefault();
    $('.about_err').remove();
    var aboutstudent = $('#thing_1').val();
    var aboutstatus = 'true';
    if (aboutstudent == '') {
        $('#thing_1').after('<label class="text-danger about_err">The field is required.</label>');
        aboutstatus = false;
    }
    $(this).data("status", aboutstatus);
    if (aboutstatus == 'true' && parentform == undefined) {
        $('a.about').css('border', '1px solid #39a95e');
        $('#loding').show();
        var things = [];
        $("input.thing").each(function (index) {
            things[index] = $(this).val();
        });
        var is_submit = $('#is_submit').val();
        var package_id = $('#package_id').val();
        var admin_url = $('#admin_url').val();
        var user_id = $('#user_id').val();
        $.ajax({
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
                $('#aboutstudentform .grey_row_left span').hide();
                $('.about_msg').html(data);
                $(".about_msg1").fadeOut(5000);
                if (final == undefined) {
                    $('#loding').hide();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    } else if (aboutstatus == 'true') {
        return true;
    } else {
        $('a.about').css('border', '1px solid red');
        $('a.about').addClass("save_err");
        return false;
    }
});

//student skill
$(document).on("click", ".submitstudentskill", function (event, parentform, final) {
    event.preventDefault();
    $('.skill_err').remove();
    var statusflag = 'true';
    $('.studentskill').each(function () {
        if ($(this).val() == "") {
            if ($(this).next('label').text() == "") {
                $(this).next().remove('label');
            }
            statusflag = 'false';
            $(this).after('<label class="text-danger skill_err">The Field Is Required.</label>');
        } else {
            if ($(this).next('label').text() == "") {
                $(this).next().remove('label');
            }
        }
    });
    $(this).data("status", statusflag);
    if (statusflag == 'true' && parentform == undefined) {
        $('a.skill').css('border', '1px solid #39a95e');
        $('#loding').show();
        var is_submit = $('#is_submit').val();
        var package_id = $('#package_id').val();
        var admin_url = $('#admin_url').val();
        var user_id = $('#user_id').val();
        var skills = [];
        $("input.studentskill").each(function (index) {
            var s_id = $(this).parent().find('.pk_skill_id').val();
            var skill = $(this).val();
            skills[index] = '{"s_id":"' + s_id + '","skill":"' + skill + '"}';
        });
        $.ajax({
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
                $('#studentskill .grey_row_left span').hide();
                $('.del_skill').remove();
                $('.skill_msg').html(data);
                $(".skill_msg1").fadeOut(5000);
                if (final == undefined) {
                    $('#loding').hide();
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
        $('a.skill').css('border', '1px solid red');
        $('a.skill').addClass("save_err");
        return false;
    }
});


//student Coures and certifications
$(document).on("click", ".submitstudentcourse", function (event, parentform, final) {
    event.preventDefault();
    $('.course_err').remove();
    var statusflag = 'true';
    $('.studentcourse').each(function () {
        if ($(this).val() == "") {
            if ($(this).next('label').text() == "") {
                $(this).next().remove('label');
            }
            statusflag = 'false';
            $(this).after('<label class="text-danger course_err">The Field Is Required.</label>');
        } else {
            if ($(this).next('label').text() == "") {
                $(this).next().remove('label');
            }
        }
    });
    $(this).data("status", statusflag);
    if (statusflag == 'true' && parentform == undefined) {
        $('a.cource').css('border', '1px solid #39a95e');
        $('#loding').show();
        var is_submit = $('#is_submit').val();
        var package_id = $('#package_id').val();
        var admin_url = $('#admin_url').val();
        var user_id = $('#user_id').val();
        var studentcourse = [];
        $("input.studentcourse").each(function (index) {
            var c_id = $(this).parent().find('.pk_course_id').val();
            var course = $(this).val();
            studentcourse[index] = '{"c_id":"' + c_id + '","course":"' + course + '"}';
        });
        $.ajax({
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
                $('#studentcource .grey_row_left span').hide();
                $('.del_course').remove();
                $('.course_msg').html(data);
                $(".course_msg1").fadeOut(5000);
                if (final == undefined) {
                    $('#loding').hide();
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
        $('a.cource').css('border', '1px solid red');
        $('a.cource').addClass("save_err");
        return false;
    }
});

//Start Knowledge Software
$(document).on("click", "#addstudentssoftware", function (event) {
    event.preventDefault();
    $('#studentsoftware .grey_row_left span').show();
    var count = parseInt($('#addsoftware').val()) + 1;
    $('#addsoftware').val(count);
    var sf_class = '';
    if (count % 2 == 0) {
        sf_class = 'c_right';
    } else {
        sf_class = 'c_left';
    }
    $('.Clssoftware').find('.c_row').last().append(
            '<div class="' + sf_class + '" id="software_' + count + '">' +
            '<label>Software ' + count + '*</label>' +
            '<input type="text" class="studentsoftware alltxtfield" maxlength="100" placeholder="Type here" id="software_' + count + '" name="software_' + count + '">' +
            ' <input type="hidden" class="pk_software_id" name="pk_software_id_' + count + '" value="">' +
            '<a class="del_software" href="javascript:void(0);" onclick="Deletesoftware(' + count + ');">Delete</a>' +
            '</div>');

    $(".alltxtfield").keypress(function (event) {
        var inputValue = event.which;

// allow letters and whitespaces only.
        if (!(inputValue > 47 && inputValue < 58) && !(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0 && inputValue != 46 && inputValue != 08)) {
            event.preventDefault();
        }
    });
    return false;
});

//------------ Remove software------------//]
function Deletesoftware(id) {
    var software_count = $('#addsoftware').val();
    software_count--;
    $("#software_" + id).remove();
    $('.studentsoftware').each(function (index) {
        var count = index + 1;
        if ($(this).parent().hasClass("c_left")) {
            $(this).parent().removeClass("c_left");
        }
        if ($(this).parent().hasClass("c_right")) {
            $(this).parent().removeClass("c_right");
        }
        if (count % 2 == 0) {
            $(this).parent().addClass("c_right");
        } else {
            $(this).parent().addClass("c_left");
        }
        $(this).parent().find('label').text('Software ' + count + '*');

    });
    $('#addsoftware').val(software_count);
}
// for honor
$(document).on("click", "#addstudentshonor", function (event) {
    event.preventDefault();
    $('#studenthonor .grey_row_left span').show();
    var counts = parseInt($('#addhonor').val()) + 1;
    $('#addhonor').val(counts);
    var sf_class = '';
    if (counts % 2 == 0) {
        sf_class = 'c_right';
    } else {
        sf_class = 'c_left';
    }
    $('.Clshonor').find('.c_row').last().append(
            '<div class="' + sf_class + '" id="honor_' + counts + '">' +
            '<label>Honor ' + counts + '*</label>' +
            '<input type="text" class="studenthonor alltxtfield" maxlength="100"  placeholder="Type here" id="honor_' + counts + '" name="honor_' + counts + '">' +
            '   <input type="hidden" class="pk_honor_id" name="pk_honor_id_' + counts + '" value="">' +
            '<a class="del_honor" href="javascript:void(0);" onclick="Deletehonor(' + counts + ');">Delete</a>' +
            '</div>');
    $(".alltxtfield").keypress(function (event) {
        var inputValue = event.which;
// allow letters and whitespaces only.
        if (!(inputValue > 47 && inputValue < 58) && !(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0 && inputValue != 46 && inputValue != 08)) {
            event.preventDefault();
        }
    });
    return false;
});

//------------ Remove honor------------//]
function Deletehonor(id) {
    var honor_count = $('#addhonor').val();
    honor_count--;
    $("#honor_" + id).remove();
    $('.studenthonor').each(function (index) {
        var count = index + 1;
        if ($(this).parent().hasClass("c_left")) {
            $(this).parent().removeClass("c_left");
        }
        if ($(this).parent().hasClass("c_right")) {
            $(this).parent().removeClass("c_right");
        }
        if (count % 2 == 0) {
            $(this).parent().addClass("c_right");
        } else {
            $(this).parent().addClass("c_left");
        }
        $(this).parent().find('label').text('Honor ' + count + '*');

    });
    $('#addhonor').val(honor_count);
}

// for activity
$(document).on("click", "#addstudentsactivity", function (event) {
    event.preventDefault();
    $('#studentactivity .grey_row_left span').show();
    var counts = parseInt($('#addactivity').val()) + 1;
    $('#addactivity').val(counts);
    var sf_class = '';
    if (counts % 2 == 0) {
        sf_class = 'c_right';
    } else {
        sf_class = 'c_left';
    }
    $('.Clsactivity').find('.c_row').last().append(
            '<div class="' + sf_class + '" id="activity_' + counts + '">' +
            '<label>Activity ' + counts + '*</label>' +
            '<input type="text" class="studentactivities alltxtfield" maxlength="100" placeholder="Type here" id="activity_' + counts + '" name="activity_' + counts + '">' +
            '<input type="hidden" class="pk_activity_id" name="pk_activity_id_' + counts + '" value="">' +
            '<a class="del_activity" href="javascript:void(0);" onclick="Deleteactivity(' + counts + ');">Delete</a>' +
            '</div>');

    $(".alltxtfield").keypress(function (event) {
        var inputValue = event.which;
// allow letters and whitespaces only.
        if (!(inputValue > 47 && inputValue < 58) && !(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0 && inputValue != 46 && inputValue != 08)) {
            event.preventDefault();
        }
    });

    return false;
});

//------------ Remove activity------------//]
function Deleteactivity(id) {
    var activity_count = $('#addactivity').val();
    activity_count--;
    $("#activity_" + id).remove();
    $('.studentactivities').each(function (index) {
        var count = index + 1;
        if ($(this).parent().hasClass("c_left")) {
            $(this).parent().removeClass("c_left");
        }
        if ($(this).parent().hasClass("c_right")) {
            $(this).parent().removeClass("c_right");
        }
        if (count % 2 == 0) {
            $(this).parent().addClass("c_right");
        } else {
            $(this).parent().addClass("c_left");
        }
        $(this).parent().find('label').text('Activity ' + count + '*');

    });
    $('#addactivity').val(activity_count);
}

// for Interest
$(document).on("click", "#addstudentsinterest", function (event) {
    event.preventDefault();
    $('#studentinterest .grey_row_left span').show();
    var counts = parseInt($('#addinterest').val()) + 1;
    $('#addinterest').val(counts);
    var sf_class = '';
    if (counts % 2 == 0) {
        sf_class = 'c_right';
    } else {
        sf_class = 'c_left';
    }
    $('.Clsinterest').find('.c_row').last().append(
            '<div class="' + sf_class + '" id="interest_' + counts + '">' +
            '<label> Interest ' + counts + '*</label>' +
            '<input type="text" class="studentinterest alltxtfield" maxlength="100" placeholder="Type here" id="interests_' + counts + '" name="interests_' + counts + '">' +
            '  <input type="hidden" class="pk_interest_id" name="pk_interest_id_' + counts + '" value="">' +
            '<a class="del_interest" href="javascript:void(0);" onclick="Deleteinterest(' + counts + ');">Delete</a>' +
            '</div>');

    $(".alltxtfield").keypress(function (event) {
        var inputValue = event.which;
// allow letters and whitespaces only.
        if (!(inputValue > 47 && inputValue < 58) && !(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0 && inputValue != 46 && inputValue != 08)) {
            event.preventDefault();
        }
    });

    return false;
});

//------------ Remove interest------------//]
function Deleteinterest(id) {
    var interest_count = $('#addinterest').val();
    interest_count--;
    $("#interest_" + id).remove();
    $('.studentinterest').each(function (index) {
        var count = index + 1;
        if ($(this).parent().hasClass("c_left")) {
            $(this).parent().removeClass("c_left");
        }
        if ($(this).parent().hasClass("c_right")) {
            $(this).parent().removeClass("c_right");
        }
        if (count % 2 == 0) {
            $(this).parent().addClass("c_right");
        } else {
            $(this).parent().addClass("c_left");
        }
        $(this).parent().find('label').text('Interest ' + count + '*');

    });
    $('#addinterest').val(interest_count);
}

//Student software knowledge
$(document).on("click", ".submitstudentsoftwareknowledge", function (event, parentform, final) {
    event.preventDefault();
    $('.software_err').remove();
    var statusflag = 'true';
    $('.studentsoftware').each(function () {
        if ($(this).val() == "") {
            if ($(this).next('label').text() == "") {
                $(this).next().remove('label');
            }
            statusflag = 'false';
            $(this).after('<label class="text-danger software_err">The Field Is Required.</label>');
        } else {
            if ($(this).next('label').text() == "") {
                $(this).next().remove('label');
            }
        }
    });
    $(this).data("status", statusflag);
    if (statusflag == 'true' && parentform == undefined) {
        $('a.software').css('border', '1px solid #39a95e');
        $('#loding').show();
        var is_submit = $('#is_submit').val();
        var package_id = $('#package_id').val();
        var admin_url = $('#admin_url').val();
        var user_id = $('#user_id').val();
        var studentsoftwares = [];
        $("input.studentsoftware").each(function (index) {
            var sw_id = $(this).parent().find('.pk_software_id').val();
            var software = $(this).val();
            studentsoftwares[index] = '{"sw_id":"' + sw_id + '","software":"' + software + '"}';
        });
        $.ajax({
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
                $('#studentsoftware .grey_row_left span').hide();
                $('.del_software').remove();
                $('.software_msg').html(data);
                $(".software_msg1").fadeOut(5000);
                if (final == undefined) {
                    $('#loding').hide();
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
        $('a.software').css('border', '1px solid red');
        $('a.software').addClass("save_err");
        return false;
    }
});

//student honor
$(document).on("click", ".submitstudenthonor", function (event, parentform, final) {
    event.preventDefault();
    $('.honor_err').remove();
    var statusflag = 'true';
    $('.studenthonor').each(function () {
        if ($(this).val() == "") {
            if ($(this).next('label').text() == "") {
                $(this).next().remove('label');
            }
            statusflag = 'false';
            $(this).after('<label class="text-danger honor_err">The Field Is Required.</label>');
        } else {
            if ($(this).next('label').text() == "") {
                $(this).next().remove('label');
            }
        }
    });
    $(this).data("status", statusflag);
    if (statusflag == 'true' && parentform == undefined) {
        $('a.honor').css('border', '1px solid #39a95e');
        $('#loding').show();
        var package_id = $('#package_id').val();
        var admin_url = $('#admin_url').val();
        var user_id = $('#user_id').val();
        var is_submit = $('#is_submit').val();
        var studenthonors = [];
        $("input.studenthonor").each(function (index) {
            var h_id = $(this).parent().find('.pk_honor_id').val();
            var honor = $(this).val();
            studenthonors[index] = '{"h_id":"' + h_id + '","honor":"' + honor + '"}';
        });
        $.ajax({
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
                $('#studenthonor .grey_row_left span').hide();
                $('.del_honor').remove();
                $('.honor_msg').html(data);
                $(".honor_msg1").fadeOut(5000);
                if (final == undefined) {
                    $('#loding').hide();
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
        $('a.honor').css('border', '1px solid red');
        $('a.honor').addClass("save_err");
        return false;
    }
});

//student activities
$(document).on("click", ".submitstudenactivity", function (event, parentform, final) {
    event.preventDefault();
    $('.activity_err').remove();
    var statusflag = 'true';
    $('.studentactivities').each(function () {
        if ($(this).val() == "") {
            if ($(this).next('label').text() == "") {
                $(this).next().remove('label');
            }
            statusflag = 'false';
            $(this).after('<label class="text-danger activity_err">The Field Is Required.</label>');
        } else {
            if ($(this).next('label').text() == "") {
                $(this).next().remove('label');
            }
        }
    });
    $(this).data("status", statusflag);
    if (statusflag == 'true' && parentform == undefined) {
        $('a.activity').css('border', '1px solid #39a95e');
        $('#loding').show();
        var package_id = $('#package_id').val();
        var admin_url = $('#admin_url').val();
        var user_id = $('#user_id').val();
        var is_submit = $('#is_submit').val();
        var studentactivities = [];
        $("input.studentactivities").each(function (index) {
            var a_id = $(this).parent().find('.pk_activity_id').val();
            var activity = $(this).val();
            studentactivities[index] = '{"a_id":"' + a_id + '","activity":"' + activity + '"}';
        });
        $.ajax({
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
                $('#studentactivity .grey_row_left span').hide();
                $('.del_activity').remove();
                $('.activity_msg').html(data);
                $(".activity_msg1").fadeOut(5000);
                if (final == undefined) {
                    $('#loding').hide();
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
        $('a.activity').css('border', '1px solid red');
        $('a.activity').addClass("save_err");
        return false;
    }
});

//student interests
$(document).on("click", ".submitstudeinterest", function (event, parentform, final) {
    event.preventDefault();
    $('.interest_err').remove();
    var statusflag = 'true';
    $('.studentinterest').each(function () {
        if ($(this).val() == "") {
            if ($(this).next('label').text() == "") {
                $(this).next().remove('label');
            }
            statusflag = 'false';
            $(this).after('<label class="text-danger interest_err">The Field Is Required.</label>');
        } else {
            if ($(this).next('label').text() == "") {
                $(this).next().remove('label');
            }
        }
    });
    $(this).data("status", statusflag);
    if (statusflag == 'true' && parentform == undefined) {
        $('a.interest').css('border', '1px solid #39a95e');
        $('#loding').show();
        var package_id = $('#package_id').val();
        var admin_url = $('#admin_url').val();
        var user_id = $('#user_id').val();
        var is_submit = $('#is_submit').val();
        var studentinterests = [];
        $("input.studentinterest").each(function (index) {
            var i_id = $(this).parent().find('.pk_interest_id').val();
            var intrest = $(this).val();
            studentinterests[index] = '{"i_id":"' + i_id + '","intrest":"' + intrest + '"}';
        });
        $.ajax({
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
                $('#studentinterest .grey_row_left span').hide();
                $('.del_interest').remove();
                $('.interest_msg').html(data);
                $(".interest_msg1").fadeOut(5000);
                if (final == undefined) {
                    $('#loding').hide();
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
        $('a.interest').css('border', '1px solid red');
        $('a.interest').addClass("save_err");
        return false;
    }
});

// for references
$(document).on("click", "#addnewrefernces", function (event) {
    event.preventDefault();
    $('#studentreferences .grey_row_left span').show();
    var counts = parseInt($('#addreferences').val()) + 1;
    $('#addreferences').val(counts);
    var sf_class = '';
    if (counts % 2 == 0) {
        sf_class = 'c_right';
    } else {
        sf_class = 'c_left';
    }
    $(".Clsreferences").find('.c_row').last().append('<div class="' + sf_class + ' others_text"  id="referenc_' + counts + '">' +
            '<label>Reference ' + counts + '*</label>' +
            '<textarea maxlength="500" id="references_' + counts + '" class="studentreferences" name="references_' + counts + '">' +
            '</textarea>' +
            ' <input type="hidden" class="pk_reference_id" name="pk_reference_id_' + counts + '" value="">' +
            '<a class="del_referenc" href="javascript:void(0);" onclick="Deletereferenc(' + counts + ');">Delete</a>' +
            '</div>');

    return false;
});

//------------ Remove referenc------------//]
function Deletereferenc(id) {
    var referenc_count = $('#addreferences').val();
    referenc_count--;
    $("#referenc_" + id).remove();
    $('.studentreferences').each(function (index) {
        var count = index + 1;
        if ($(this).parent().hasClass("c_left")) {
            $(this).parent().removeClass("c_left");
        }
        if ($(this).parent().hasClass("c_right")) {
            $(this).parent().removeClass("c_right");
        }
        if (count % 2 == 0) {
            $(this).parent().addClass("c_right");
        } else {
            $(this).parent().addClass("c_left");
        }
        $(this).parent().find('label').text('Reference ' + count + '*');

    });
    $('#addreferences').val(referenc_count);
}

// references
$(document).on("click", ".submitstudentreferences", function (event, parentform, final) {
    event.preventDefault();
    $('.references_err').remove();
    var statusflag = 'true';
    $('.studentreferences').each(function () {
        if ($(this).val() == "") {
            if ($(this).next('label').text() == "") {
                $(this).next().remove('label');
            }
            statusflag = 'false';
            $(this).after('<label class="text-danger  references_err">The Field Is Required.</label>');
        } else {
            if ($(this).next('label').text() == "") {
                $(this).next().remove('label');
            }
        }
    });
    $(this).data("status", statusflag);
    if (statusflag == 'true' && parentform == undefined) {
        $('a.references').css('border', '1px solid #39a95e');
        $('#loding').show();
        var package_id = $('#package_id').val();
        var admin_url = $('#admin_url').val();
        var user_id = $('#user_id').val();
        var is_submit = $('#is_submit').val();
        var studentreferences = [];
        $("textarea.studentreferences").each(function (index) {
            var r_id = $(this).parent().find('.pk_reference_id').val();
            var reference = $(this).val();
            studentreferences[index] = '{"r_id":"' + r_id + '","reference":"' + reference + '"}';
        });
        $.ajax({
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
                $('#studentreferences .grey_row_left span').hide();
                $('.del_referenc').remove();
                $('.references_msg').html(data);
                $(".references_msg1").fadeOut(5000);
                if (final == undefined) {
                    $('#loding').hide();
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
        $('a.references').css('border', '1px solid red');
        $('a.references').addClass("save_err");
        return false;
    }
});

$(document).on("change", ".file_upload", function () {
    var id = $(this).closest('.projects').attr('id');
    var flag = true;
    var file = $(this);
    var file_name = file[0].files[0]['name'];
    var ext = file_name.split(".");
    ext = ext[ext.length - 1].toLowerCase();
    var arrayExtensions = ["jpg", "jpeg", "png"];
    if (arrayExtensions.lastIndexOf(ext) == -1) {
        $('#' + id + ' .file_upload').after('<label class="text-danger project_err">This is Wrong extension type.</label>');
        $(".project_err").fadeOut(5000);
        flag = false;
    } else if (file[0].files[0].size > 1000000) {
        $('#' + id + ' .file_upload').after('<label class="text-danger project_err">Please upload max 1MB size file.</label>');
        $(".project_err").fadeOut(5000);
        flag = false;
    }
    if (flag == true) {
        var fd = new FormData();
        var admin_url = $('#admin_url').val();
        var file = $(this);
        var individual_file = file[0].files[0];
        fd.append("file", individual_file);
        fd.append('action', 'fiu_upload_file');

        $.ajax({
            type: 'POST',
            url: admin_url,
            data: fd,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (data) {
                $('#loding').hide();
                $('#' + id + ' .original_name').val(data['original_name']);
                $('#' + id + ' .upload_name').val(data['upload_name']);
            }
        });
    } else {
        $(this).val('');
        return false;
    }
});

// Validations start for Project
$(document).on("click", ".submitstudentprojects", function (event, parentform, final) {
    event.preventDefault();
    $('.project_err').remove();
    var statusflag = 'true';
    $('.projectname').each(function () {
        if ($(this).val() == "") {
            if ($(this).next('label').text() == "") {
                $(this).next().remove('label');
            }
            statusflag = 'false';
            $(this).after('<label class="text-danger project_err">The Field Is Required.</label>');
        } else {
            if ($(this).next('label').text() == "") {
                $(this).next().remove('label');
            }
        }
    });
    $('.background').each(function () {
        if ($(this).val() == "") {
            if ($(this).next('label').text() == "") {
                $(this).next().remove('label');
            }
            statusflag = 'false';
            $(this).after('<label class="text-danger project_err">The Field Is Required.</label>');
        } else {
            if ($(this).next('label').text() == "") {
                $(this).next().remove('label');
            }
        }

    });

    $('.objective').each(function () {
        if ($(this).val() == "") {
            if ($(this).next('label').text() == "") {
                $(this).next().remove('label');
            }
            statusflag = 'false';
            $(this).after('<label class="text-danger project_err">The Field Is Required.</label>');
        } else {
            if ($(this).next('label').text() == "") {
                $(this).next().remove('label');
            }
        }
    });

    $('.execution').each(function () {
        if ($(this).val() == "") {
            if ($(this).next('label').text() == "") {
                $(this).next().remove('label');
            }
            statusflag = 'false';
            $(this).after('<label class="text-danger project_err">The Field Is Required.</label>');
        } else {
            if ($(this).next('label').text() == "") {
                $(this).next().remove('label');
            }
        }
    });

    $('.results').each(function () {
        if ($(this).val() == "") {
            if ($(this).next('label').text() == "") {
                $(this).next().remove('label');
            }
            statusflag = 'false';
            $(this).after('<label class="text-danger project_err">The Field Is Required.</label>');
        } else {
            if ($(this).next('label').text() == "") {
                $(this).next().remove('label');
            }
        }
    });
    $('.upload_name').each(function () {
        if ($(this).val() == "") {
            if ($(this).next('label').text() == "") {
                $(this).next().remove('label');
            }
            statusflag = 'false';
            $(this).after('<label class="text-danger project_err">The Field Is Required.</label>');
        } else {
            if ($(this).next('label').text() == "") {
                $(this).next().remove('label');
            }
        }
    });
    $(this).data("status", statusflag);
    if (statusflag == 'true' && parentform == undefined) {
        $('a.project').css('border', '1px solid #39a95e');
        $('#loding').show();
        var package_id = $('#package_id').val();
        var admin_url = $('#admin_url').val();
        var user_id = $('#user_id').val();
        var is_submit = $('#is_submit').val();
        var projects = [];

        $(".projects").each(function (i) {
            var id = this.id;
            var p_id = $('#' + id + '  .pk_project_id').val();
            var name = $('#' + id + ' .projectname').val();
            var background = $('#' + id + ' .background').val();
            var objective = $('#' + id + ' .objective').val();
            var execution = $('#' + id + ' .execution').val();
            var results = $('#' + id + ' .results').val();
            var original = '';
            var upload = ''
            if ($('#' + id + ' .original_name') && $('#' + id + ' .upload_name')) {
                original = $('#' + id + ' .original_name').val();
                upload = $('#' + id + ' .upload_name').val();
            }
            projects[i] = '{"name":"' + name + '","background":"' + background + '","objective":"' + objective + '","execution":"' + execution + '","results":"' + results + '","original":"' + original + '","upload":"' + upload + '","p_id":"' + p_id + '"}';
        });
        $.ajax({
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
                $('#studentprojects .grey_row_left span').hide();
                $('.del_project').remove();
                $('.project_msg').html(data);
                $(".project_msg1").fadeOut(5000);
                if (final == undefined) {
                    $('#loding').hide();
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
        $('a.project').css('border', '1px solid red');
        $('a.project').addClass("save_err");
        return false;
    }
});
//project validation validations end

/* Click on notification bell */
$(document).on('click', '.view-notificatons', function () {
    var admin_url = $('#admin_url').val();
    var user_id = $('#userid').val();

    $.ajax({
        url: admin_url,
        type: "POST",
        data: {
            action: 'check_notifications',
            user_id: user_id
        },
        success: function (data) {
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
        }
    });
});
/* End click on notification bell */

// Validations start for Work Experience
$(document).on("click", ".submitstudentworkexperience", function (event, parentform, final) {
    event.preventDefault();
    var statusflag = 'true';
    $('.work_err').remove();
    $('.exp_title').each(function () {
        if ($(this).val() == "") {
            if ($(this).next('label').text() != "") {
                $(this).next().remove('label');
            }
            statusflag = 'false';
            $(this).after('<label class="text-danger work_err">The Field Is Required.</label>');
        } else {
            if ($(this).next('label').text() != "") {
                $(this).next().remove('label');
            }
        }
    });

    $('.exp_compny').each(function () {
        if ($(this).val() == "") {
            if ($(this).next('label').text() != "") {
                $(this).next().remove('label');
            }
            statusflag = 'false';
            $(this).after('<label class="text-danger work_err">The Field Is Required.</label>');
        } else {
            if ($(this).next('label').text() != "") {
                $(this).next().remove('label');
            }
        }

    });

    $('.exp_city').each(function () {
        if ($(this).val() == "") {
            if ($(this).next('label').text() != "") {
                $(this).next().remove('label');
            }
            statusflag = 'false';
            $(this).after('<label class="text-danger work_err">The Field Is Required.</label>');
        } else {
            if ($(this).next('label').text() != "") {
                $(this).next().remove('label');
            }
        }
    });
    $('.exp_state').each(function () {
        if ($(this).val() == "") {
            if ($(this).next('label').text() != "") {
                $(this).next().remove('label');
            }
            statusflag = 'false';
            $(this).after('<label class="text-danger work_err">The Field Is Required.</label>');
        } else {
            if ($(this).next('label').text() != "") {
                $(this).next().remove('label');
            }
        }
    });
    $('.exp_years').each(function () {
        if ($(this).val() == "") {
            if ($(this).next('label').text() != "") {
                $(this).next().remove('label');
            }
            statusflag = 'false';
            $(this).after('<label class="text-danger work_err">The Field Is Required.</label>');
        } else {
            if ($(this).next('label').text() != "") {
                $(this).next().remove('label');
            }
        }
    });
    $('.exp_description').each(function () {
        if ($(this).val() == "") {
            if ($(this).next('label').text() != "") {
                $(this).next().remove('label');
            }
            statusflag = 'false';
            $(this).after('<label class="text-danger work_err">The Field Is Required.</label>');
        } else {
            if ($(this).next('label').text() != "") {
                $(this).next().remove('label');
            }
        }
    });
    $(this).data("status", statusflag);
    if (statusflag == 'true' && parentform == undefined) {
        $('a.work').css('border', '1px solid #39a95e');
        $('#loding').show();
        var is_submit = $('#is_submit').val();
        var package_id = $('#package_id').val();
        var admin_url = $('#admin_url').val();
        var user_id = $('#user_id').val();
        var experience = [];
        $(".experience").each(function (i) {
            var id = this.id;
            var w_id = $('#' + id + '  .pk_workexp_id').val();
            var title = $('#' + id + ' .exp_title').val();
            var company = $('#' + id + ' .exp_compny').val();
            var city = $('#' + id + ' .exp_city').val();
            var state = $('#' + id + ' .exp_state').val();
            var years = $('#' + id + ' .exp_years').val();
            var description = $('#' + id + ' .exp_description').val();
            experience[i] = '{"title":"' + title + '","company":"' + company + '","city":"' + city + '","state":"' + state + '","years":"' + years + '","description":"' + description + '","w_id":"' + w_id + '"}';
        });
        $.ajax({
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
                $('#studentworks .grey_row_left span').hide();
                $('.work_msg').html(data);
                $(".work_msg1").fadeOut(3000);
                if (final == undefined) {
                    $('#loding').hide();
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
        $('a.work').css('border', '1px solid red');
        $('a.work').addClass("save_err");
        return false;
    }
});

$(".alltxtfield").keypress(function (event) {
    var inputValue = event.which;
// allow letters and whitespaces only.
    if (!(inputValue > 47 && inputValue < 58) && !(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0 && inputValue != 46 && inputValue != 08)) {
        event.preventDefault();
    }
});