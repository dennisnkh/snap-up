$(function() {

    $('#newpassword').on('focus', function() {
        $('#passwordGuide').show();
    });

    $('#newpassword').on('blur', function() {
        $('#passwordGuide').hide();
    });

});