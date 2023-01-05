$(function() {

    $("#item").select2();
    $("#store").select2();
    $("#chain").select2();
    $("#brand").select2();
    $("#category").select2();

    $('#usernameCreate').on('focus', function() {
        $('#usernameGuide').show();
    });

    $('#usernameCreate').on('blur', function() {
        $('#usernameGuide').hide();
    });

    $('#passwordCreate').on('focus', function() {
        $('#passwordGuide').show();
    });

    $('#passwordCreate').on('blur', function() {
        $('#passwordGuide').hide();
    });

    $('.showMapBtn').on('click', function() {
        $(this).parent().next().toggle();
    })

});