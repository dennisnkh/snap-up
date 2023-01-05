$(function() {

    $(".addBtn").on('click', function() {
        $('.add').show();
        $('.update').hide();
        $('.delete').hide();
        $('.adminResult').hide();
    });

    $(".updateBtn").on('click', function() {
        $('.update').show();
        $('.add').hide();
        $('.delete').hide();
        $('.adminResult').hide();
    });

    $(".deleteBtn").on('click', function() {
        $('.delete').show();
        $('.add').hide();
        $('.update').hide();
        $('.adminResult').hide();
    });

    $("#itemToUpdate").select2();
    $("#itemToDelete").select2();
    $("#storeToUpdate").select2();
    $("#storeToDelete").select2();

    $("#item").select2();
    $("#store").select2();
    $("#chain").select2();
    $("#brand").select2();
    $("#category").select2();

});