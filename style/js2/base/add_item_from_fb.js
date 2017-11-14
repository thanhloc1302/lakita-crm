$(document).on('click', '.create-campaign-from-fb', function (e) {
    e.preventDefault();
    $(".add-name-from-fb").val($(this).attr("campaign-name"));
    $(".add-campaign-id-from-fb").val($(this).attr("id-fb"));
    console.log($(this).attr("id-fb"));
    $(".add_item_from_fb_modal").modal("show");
});
