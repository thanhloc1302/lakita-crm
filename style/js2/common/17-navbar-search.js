/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var modalName = "navbar-search-modal";
$(".btn-navbar-search").click(function (e) {
    e.preventDefault();
    $.ajax({
        url: $("#base_url").val() + $("#input_controller").val() + '/search',
        type: "GET",
        data: {
            search_all: $(".input-navbar-serach").val()
        },
        success: data => {
            $("." + modalName).remove();
            var newModal = `<div class="${modalName}"></div>`;
            if ($("#action_contact").length) {
                $("#action_contact").append(newModal);
            } else {
                $(".modal-append-to").append(newModal);
            }
            $(`.${modalName}`).html(data);
        },
        complete: () => $(`.${modalName} .navbar-search-modal`).modal("show")
    });
});
/*     <a href="#" class="anchor-navbar-search">6899</a> */
$(".anchor-navbar-search").click(function (e) {
    e.preventDefault();
    $.ajax({
        url: $("#base_url").val() + $("#input_controller").val() + '/search',
        type: "GET",
        data: {
            search_all: $.trim($(this).text())
        },
        success: data => {
            $("." + modalName).remove();
            var newModal = `<div class="${modalName}"></div>`;
            if ($("#action_contact").length) {
                $("#action_contact").append(newModal);
            } else {
                $(".modal-append-to").append(newModal);
            }
            $(`.${modalName}`).html(data);
        },
        complete: () => $(`.${modalName} .navbar-search-modal`).modal("show")
    });
});

$(document).on('hide.bs.modal', ".navbar-search-modal", function () {
    $("." + modalName).remove();
}); 