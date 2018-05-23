$(document).ready(function () {

    $('#search_submit').click(function () {
        $('.text-danger').remove();
        if ($('#goals').val() == '') {
            $('#search-form').append('<p class="text-danger" >Please Enter text...</p>');
            return false;
        }
    });
});
