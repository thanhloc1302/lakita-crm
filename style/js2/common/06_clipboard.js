$(function () {
    var clipboard = new Clipboard('.btn-copy');
    clipboard.on('success', function () {
        $.notify("Copy thành công vào clipboard", {
            position: "top left",
            className: 'success',
            showDuration: 200,
            autoHideDelay: 2000
        });
    });
});
$(document).on("click", ".view_contact_phone", function () {
    var textCopy = document.getElementById("input-copy");
    textCopy.select();
    document.execCommand('copy');
    $.notify("Copy thành công vào clipboard", {
        position: "top left",
        className: 'success',
        showDuration: 200,
        autoHideDelay: 2000
    });
});