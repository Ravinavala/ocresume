$(window).scroll(function () {
    if ($(window).width() >= 768) {
        if ($(window).scrollTop()) {
            $('.buttons').css("display", "none");
            $('.header_main').css({
                'background-color': '#282727',
                'padding': '1px 0px 12px',
                'opacity': 0.9
            });
            $('.buttons_sticky').css("display", "inline-block");
            $('div#myNavbar1').css({
                'margin-top': ' 22px'
            });
        } else {
            $('.buttons_sticky').css("display", "none");
            $('.buttons').css("display", "block");
            $('.header_main').css({
                'background-color': 'transparent',
                'padding': '14px 0px',
                'opacity': 1
            });
            $('div#myNavbar1').css({
                'margin-top': ' 0px'
            });
        }
    }
});
$(window).on("load resize", function () {
    var header_height = $('.header_main').outerHeight();
    if ($(window).width() <= 749) {
        $('.banner').css('padding-top', header_height);
    } else {
        $('.banner').css('padding-top', 0);
    }
});
$(window).load(function () {
    if ($(window).width() >= 1200 && $(window).width() < 1920) {
        $('#flexslider_patners_bottom').flexslider({
            animation: "slide",
            animationLoop: false,
            itemWidth: 550,
            itemMargin: 34,
            move: 1,
            maxItem: 2,
            minItem: 2
        });
    } else if ($(window).width() >= 991 && $(window).width() < 1199) {
        $('#flexslider_patners_bottom').flexslider({
            animation: "slide",
            animationLoop: false,
            itemWidth: 550,
            itemMargin: 34,
            move: 1,
            maxItems: 2,
            minItems: 2
        });
    } else if ($(window).width() >= 479 && $(window).width() < 991) {
        $('#flexslider_patners_bottom').flexslider({
            animation: "slide",
            animationLoop: false,
            itemWidth: 550,
            itemMargin: 34,
            move: 1,
            maxItems: 1,
            minItems: 1
        });
    } else if ($(window).width() >= 320 && $(window).width() < 480) {
        $('#flexslider_patners_bottom').flexslider({
            animation: "slide",
            animationLoop: false,
            itemWidth: 550,
            itemMargin: 34,
            move: 1,
            maxItems: 1,
            minItems: 1
        });
    }
});
$(window).load(function () {
    $('#happy_client_slider').flexslider({
        animation: "slide"
    });
});
// set maxlength for username password
$(document).ready(function () {
    //Phone No validation on checkout
    $("#bphone").keypress(function (e) {
        debugger;
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });

    jQuery('#user').attr('placeholder', 'Username');
    jQuery('#pass').attr('placeholder', 'Password');
    $('.disable_add input').prop('readonly', true);
    $('.disable_add select').css('pointer-events', 'none');
    $("#user").attr('maxlength', '100');
    $("#pass").attr('maxlength', '30');
});

// Forgot password
function submit_forget_pw() {
    debugger;
    $('#email_error .validation-error').remove();
    var email = document.getElementById('email').value;
    var url = $('#admin_url').val();

    var fogt_pw = 0;
    if (email == '') {
        $('#email_error').html('<label class="text-danger validation-error">Email is required.</label>');
        fogt_pw = 1;
    } else if (!validateEmail(email)) {
        $('#email_error').html('<label class="text-danger validation-error">Please enter valid email address.</label>');
        fogt_pw = 1;
    }
    if (fogt_pw == 0) {
        $.ajax({
            type: "POST",
            url: url,
            data: {
                action: 'forgot_pw_ajax',
                email: email,
            },
            dataType: "html",
            success: function (data) {
                if (data == 1) {
                    $('#email_error').html('<label class="text-success validation-error">A password reset email is send to your email id. Please check it.</label>');
                    $('#forgate_sub').prop('disabled', true);
                    window.setTimeout(function () {
                        window.location.href = $('#login_url').attr('href');
                    }, 1000);
                } else if (data == 0) {
                    $('#email_error').html('<label class="text-danger validation-error">Email id is not exists. Please check it.</label>');
                }
            }
        });
    }
}
//Reset password
function submit_reset_pw()
{
    var password = document.getElementById('password').value;
    var conf_password = document.getElementById('conf_password').value;
    var user_id = document.getElementById('user_id').value;
    var email = document.getElementById('email').value;
    var uname = document.getElementById('uname').value;
    var oldpass = document.getElementById('oldpass').value;

    var url = $('#admin_url').val();
    var password_count = password.length;
    var reset_pw = 0;
    if (password == '')
    {
        $('#password_error').html("Password is required");
        reset_pw = 1;
    } else if (password_count < 8 || password_count > 15)
    {
        $('#password_error').html('Password should be between 8 to 15 characters.');
        reset_pw = 1;
    } else
    {
        $('#password_error').hide();
    }
    if (conf_password == '')
    {
        $('#conf_password_error').html("Confirmed password is required");
        reset_pw = 1;
    } else
    {
        if (password != conf_password)
        {
            $('#conf_password_error').html("Password does not match");
            reset_pw = 1;
        } else
        {
            $('#conf_password').removeClass("validation-error");
            $('#conf_password_error').hide();
        }
    }
    if (reset_pw == 0)
    {
        debugger;
        $.ajax({
            type: "POST",
            url: url,
            data: {
                action: 'reset_pw_ajax',
                password: password,
                user_id: user_id,
                email: email,
                uname: uname,
                oldpass: oldpass
            },
            dataType: "html",
            success: function (data) {
                if (data == 1)
                {
                    $('#reset_pw_status').text('Password Successfully Updated.');
                    $('#reset_pw_status').show();
                    window.setTimeout(function () {
                        window.location.href = $('#login_url').val();
                    }, 1000);
                } else if (data == 0)
                {
                    $('#reset_pw_status').text('Password does not updated successfully. Please try again.');
                    $('#reset_pw_status').show();
                }
            }
        });
    }
}

//validation for login form
function validateEmail(user) {
    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (filter.test(user)) {
        return true;
    } else {
        return false;


    }
}

//validations for login resume
$(document).on("click", ".button-primary", function () {

    $('.text-danger').remove();
    var user = $('#user').val();
    var pass = $('#pass').val();
    var flage = true;
    var filter = /^[ A-Za-z0-9_@./]*$/;

    if (user == '') {
        $('#user').after('<label class="text-danger login_label">Username or Email is required.</label>');
        flage = false;
    } else if ($('#user').val() == "" || (!filter.test(user))) {
        $("#user").after('<label class="text-danger login_label ">Please enter valid username or email address</label>');
        flage = 'false';
    }


    if (pass == '') {
        $('#pass').after('<label class="text-danger login_label">Password is required.</label>');
        flage = false;
    }
    if (flage == true) {
        $('.text-danger').remove();
        return true;
    } else {
        $('.login_label').css('display', 'block');
        return false;
    }
});


var window_height = $(window).height();
var header_height = $('.other_pages').height();
var footer_height = $('footer').height();
var total_height = header_height + footer_height;
var section_height = window_height - total_height;
$('.login_section_main').css('min-height', section_height);


//validations for login resume
jQuery(document).ready(function () {
    if ($('#shdn').length) {
        if ($('#shdn').val() != '') {
            jQuery('html,body').unbind().animate({scrollTop: $('#home_packages_section').offset().top - 45}, 'slow');
        }
    }
    //jQuery('html, body').animate({scrollTop: $("#home_packages_section").position().top}, '600');
});
jQuery(document).ready(function () {
    $('#AccountNumber').attr('maxlength', 16);
    $("a.buy-now-package").click(function () {
        jQuery('html,body').unbind().animate({scrollTop: $('#home_packages_section').offset().top - 45}, 'slow');
    });
});
jQuery(window).on('load resize', function () {
    var page_height = jQuery(window).outerHeight();
    var content_height = page_height - jQuery('.banner').outerHeight() - jQuery('footer').outerHeight();
    jQuery('.resume_section').css('min-height', content_height);
});


//------Comment Validation -----//
jQuery.validator.addMethod("better_email", function (value, element) {
    // a better (but not 100% perfect) email validation
    return this.optional(element) || /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value);
}, 'Please enter a valid email address.');

jQuery(document).ready(function ($) {
    $('#commentform').validate({
        rules: {
            author: {
                required: true,
                minlength: 2
            },
            email: {
                required: true,
                email: true
            },
            comment: {
                required: true
            }
        },
        messages: {
            author: "Please enter your name",
            "email": {
                required: "Please enter your email address",
                email: "Please enter a valid email address"
            },
            comment: "Please type your comment"
        },
        errorElement: "span",
        errorClass: "text-danger",
        errorPlacement: function (error, element) {
            element.after(error);
        }
    });
});

//---------------Check Image type---------//
function allvalidateimageFile(file, imageName) {
    $('.frmUpload .cancel').show();
    var ext = file.split(".");
    ext = ext[ext.length - 1].toLowerCase();
    var arrayExtensions = ["jpg", "jpeg", "png"];
    if (arrayExtensions.lastIndexOf(ext) == -1) {
        $('#output').attr('src', '');
        $('#output').attr('src', $('#profile_pic').attr('src'));
        $(".pic_msg").html('<span class="text-danger pic_msg1 ">Wrong extension type.Please upload valid file</span>');
        $(".pic_msg1").fadeOut(5000);
        return false;
    } else if ($('#profile_img')[0].files[0].size > 5242880) {
        $('#output').attr('src', '');
        $('#output').attr('src', $('#profile_pic').attr('src'));
        $(".pic_msg").html('<span class="text-danger pic_msg1 ">Please upload max 5MB size file.</span>');
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