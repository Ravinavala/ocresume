//validations for upload resume
$(document).on("click", ".search_submit", function () {
    $('.text-danger').remove();
    var goals = $('#goals').val();
    var uploaded_resume = $('#uploaded_resume').val();
    var flage = true;
    if (goals == '') {
        $('#goals').after('<label class="text-danger">The field is required.</label>');
        flage = false;
    }
    if (uploaded_resume == '') {
        $('#uploaded_resume').after('<label class="text-danger">The field is required.</label>');
        flage = false;
    }

    if (flage == true) {
        $('.text-danger').remove();
        return true;
    } else {
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
    if ($('#uploaded_resume')[0].files[0].size > 100000) {
        alert("Please upload max 1MB size file");
        flages = false;
    }
    if (flages == true) {

        return true;
    } else {
        $("#uploaded_resume").val('');
        return false;
    }
}

//Start Resume workspace Module
$(document).on("click", "#addnewproject", function (event) {
    event.preventDefault();
    $('#studentprojects .grey_row_left span').show();
    var counter = parseInt($('#addproject').val()) + 1;
    $('#addproject').val(counter);
    $('.clsProject').append(
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
    $(".alltxtfield").keypress(function (event) {
        var inputValue = event.which;
// allow letters and whitespaces only.
        if (!(inputValue > 47 && inputValue < 58) && !(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0 && inputValue != 46 && inputValue != 08)) {
            event.preventDefault();
        }
    });
    return false;
});

//------------ Remove Project ------------//]
function Deleteproject(id) {
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

//End Project Module

//Start work  Experience
$(document).on("click", "#addnewexperience", function (event) {
    event.preventDefault();
    $('#studentworks .grey_row_left span').show();
    var counter = parseInt($('#addexperience').val()) + 1;
    $('#addexperience').val(counter);
    $('.clsexperience').append('<div id="div_workexp_' + counter + '" class="panel-body experience">' +
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
    $(".alltxtfield").keypress(function (event) {
        var inputValue = event.which;
// allow letters and whitespaces only.
        if (!(inputValue > 47 && inputValue < 58) && !(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0 && inputValue != 46 && inputValue != 08)) {
            event.preventDefault();
        }
    });
$(".exp_years").keypress(function (e) {
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        return false;
    }
});
    return false;
});

//------------ Remove Work Experience ------------//]
function Deletework(id) {
    var work_count = $('#addexperience').val();
    work_count--;
    $("#div_workexp_" + id).remove();
    $('.experience').each(function (index) {
        var count = index + 1;
        var proj = this.id;

    });
    $('#addexperience').val(work_count);
}

//Start Student Skills
$(document).on("click", "#addstudentsskill", function (event) {
    event.preventDefault();
    $('#studentskill .grey_row_left span').show();
    var counter = parseInt($('#addstudentskills').val()) + 1;
    $('#addstudentskills').val(counter);
    var sf_class = '';
    if (counter % 2 == 0) {
        sf_class = 'c_right';
    } else {
        sf_class = 'c_left';
    }
    $('.clsstudentskills').find('.c_row').last().append('<div class="' + sf_class + '"  id="skill_' + counter + '">' +
            '<label>Skill ' + counter + '*</label>' +
            '<input type="text" class="studentskill alltxtfield" placeholder="Type here" id="student_skill_' + counter + '" name="student_skill_' + counter + '">' +
            ' <input type="hidden" class="pk_skill_id" name="pk_skill_id_' + counter + '" value="">' +
            '<a class="del_skill" href="javascript:void(0);" onclick="Deleteskill(' + counter + ');">Delete</a>' +
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

//------------ Remove skill------------//]
function Deleteskill(id) {
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

//Start Student Course
$(document).on("click", "#addstudentscourse", function (event) {
    event.preventDefault();
    $('#studentcource .grey_row_left span').show();
    var flage = parseInt($('#addcourse').val()) + 1;
    $('#addcourse').val(flage);
    var sf_class = '';
    if (flage % 2 == 0) {
        sf_class = 'c_right';
    } else {
        sf_class = 'c_left';
    }
    $('.clsCourse').find('.c_row').last().append(
            '<div class="' + sf_class + '" id="course_' + flage + '">' +
            '<label>Course ' + flage + '*</label>' +
            '<input type="text" class="studentcourse alltxtfield" placeholder="Type here" id="course_' + flage + '" name="course_' + flage + '">' +
            ' <input type="hidden" class="pk_course_id" name="pk_course_id_' + flage + '" value="">' +
            '<a class="del_course" href="javascript:void(0);" onclick="Deletecourse(' + flage + ');">Delete</a>' +
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

//------------ Remove Course------------//]
function Deletecourse(id) {
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




//validate email
function validateEmail(sEmail) {
    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (filter.test(sEmail)) {
        return true;
    } else {
        return false;
    }
}

$("#phone").keypress(function (e) {
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        return false;
    }
});

// allow only number
$("#studentphone").keypress(function (e) {
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        return false;
    }
});



$(document).ready(function () {
    if ($(".txtdecimalval").length > 0) {
        $(".txtdecimalval").keydown(function (e) {
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
    $(".alltxtfield").keypress(function (event) {
        var inputValue = event.which;
// allow letters and whitespaces only.
        if (!(inputValue > 47 && inputValue < 58) && !(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0 && inputValue != 46 && inputValue != 08)) {
            event.preventDefault();
        }
    });


    $("#studentgraduationdate").readOnly = true;

});

//Save Student Comment
$('#add_student_comment').click(function () {
    var comment = $('#comment').val();
    if (comment) {
        $("#comment").css('border', '1px solid #c2cad8');
        $('.comment_msg').remove();
        $('#loding').show();
        var package_id = $('#package_id').val();
        var admin_url = $('#admin_url').val();
        var user_id = $('#user_id').val();
        var currentuser_id = $('#currentuser_id').val();
        var reviewer_id = $('#reviewer_id').val();
        $.ajax({
            url: admin_url,
            type: "POST",
            data: {
                action: 'save_student_comment',
                user_id: user_id,
                package_id: package_id,
                comment: comment,
                reviewer_id: reviewer_id,
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
//final click validations
//final click validations

$('.submitresumeforms').click(function () {
    var personal_flag = $(".submitpersonalinfo").trigger("click", false).data("status");
    var about_flag = $(".submitfewthingaboutstudent").trigger("click", false).data("status");
    var project_flag = $(".submitstudentprojects").trigger("click", false).data("status");
    var work_flag = $(".submitstudentworkexperience").trigger("click", false).data("status");
    var skill_flag = $(".submitstudentskill").trigger("click", false).data("status");
    var cource_flag = $(".submitstudentcourse").trigger("click", false).data("status");
    var software_flag = $(".submitstudentsoftwareknowledge").trigger("click", false).data("status");
    var honor_flag = $(".submitstudenthonor").trigger("click", false).data("status");
    var activity_flag = $(".submitstudenactivity").trigger("click", false).data("status");
    var interest_flag = $(".submitstudeinterest").trigger("click", false).data("status");
    var references_flag = $(".submitstudentreferences").trigger("click", false).data("status");

    var goals = $('#goals').val();
    var is_submit = $('#is_submit').val();
    $('.error1').remove();
    if (goals == '') {
        $('#goals').after('<label class="text-danger error1">The field is required.</label>');
        return false;
    }
    if (goals != '' && personal_flag == 'true' && about_flag == 'true' && project_flag == 'true'
            && work_flag == 'true' && skill_flag == 'true' && cource_flag == 'true'
            && software_flag == 'true' && honor_flag == 'true' && activity_flag == 'true'
            && interest_flag == 'true' && references_flag == 'true') {
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

        var currentstatus = $('#currentstatus').val();
        var currentuser_id = $('#currentuser_id').val();
        var reviewer_id = $('#reviewer_id').val();
        var package_id = $('#package_id').val();
        var admin_url = $('#admin_url').val();
        var user_id = $('#user_id').val();
        var workflow_status = $('#workflow_status').val();
        $.ajax({
            url: admin_url,
            type: "POST",
            data: {
                action: 'save_resume_info',
                goals: goals,
                currentstatus: currentstatus,
                reviewer_id: reviewer_id,
                is_submit: is_submit,
                workflow_status: workflow_status,
                user_id: user_id,
                package_id: package_id
            },
            success: function (data) {
                $('.goal_msg').html(data);
                $(".goal_msg1").fadeOut(3000);
                window.setTimeout(function () {
                    $('#loding').hide();
                    location.reload();
                }, 3000);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }

        });
    } else {
        $('html,body').unbind().animate({scrollTop: $('.save_err:visible:first').offset().top - 50}, 'slow');
        return false;
    }
});

$(window).load(function ()
{
    $("#mCSB_1_container").mCustomScrollbar("update");
    setTimeout(function () {
        $("#commentArea").mCustomScrollbar("scrollTo", "bottom");
    }, 1000);
});

$('#sname').attr('readonly', true);
$('#semail').attr('readonly', true);

$(document).on("click", ".submitsupportform", function (event) {
    event.preventDefault();
    $('.support_err').remove();
    var user_id = $('#user_id').val();
    var ssubject = $('#ssubject').val();
    var message = $('#message').val();
    var semail = $('#semail').val();
    var sname = $('#sname').val();
    var supportstatus = $('#supportstatus').val();
    var admin_url = $('#admin_url').val();
    var adminemail = $('#adminemail').val();
    var adminid = $('#adminid').val();
    var flage = true;
    if (ssubject == '') {
        $('#ssubject').after('<label class="text-danger support_err">The field is required.</label>');
        flage = false;
    }
    if (message == '') {
        $('#message').after('<label class="text-danger support_err">The field is required.</label>');
        flage = false;
    }
    if (flage == true) {
        $('#loding').show();
        // $('.support_msg').remove();
        $.ajax({
            type: "POST",
            url: admin_url,
            data: {
                action: 'send_student_support',
                ssubject: ssubject,
                message: message,
                semail: semail,
                sname: sname,
                user_id: user_id,
                adminemail: adminemail,
                supportstatus: supportstatus,
                adminid: adminid,
            },
            success: function (data) {
                $('.support_msg').html(data);
                $(".support_msg1").fadeOut(5000);
                $('#loding').hide();
                location.reload();
                
            },
            
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    } else {
        return false;
    }
});
$(document).on("click", ".submitsupportcomment", function () {
    $('.msg_err').remove();
    var messages = $('#messages').val();
    var flage = true;
    if (messages == '') {
        $('#messages').after('<label class="text-danger msg_err">The field is required.</label>');
        flage = false;
    }
    if (flage == true) {
        $('#student-comment-form').submit();
        $('.msg_err').remove();
        return true;
    } else {
        return false;
    }
});

$('#addnewbutton').click(function (event) {
    $("#support_list").hide();
    $("#student-support-form").show();
});
$(".exp_years").keypress(function (e) {
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        return false;
    }
});