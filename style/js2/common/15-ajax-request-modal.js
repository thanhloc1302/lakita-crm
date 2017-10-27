/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).on("click", ".ajax-request-modal", function (e) {
    e.stopPropagation();
    e.preventDefault();
    var _this = $(this);
    setTimeout(function () {
        $(".checked").removeClass("checked");
        _this.parent().parent().addClass("checked");

        var contact_id = _this.attr("data-contact-id");
        console.log(contact_id);
        var url = $("#base_url").val() + _this.attr("data-url");
        var modalName = _this.attr("data-modal-name");
        var controller = _this.attr("data-controller");
        $.ajax({
            url: url,
            type: "POST",
            data: {
                contact_id: contact_id,
                controller: controller
            },
            success: data => {
                $("." + modalName).remove();
                var newModal = `<div class="${modalName}"></div>`;
                $(".modal-append-to").append(newModal);
                $(`.${modalName}`).html(data);
            },
            complete: () => $(`.${modalName} .modal`).modal("show")
        });
    }, 100);
});
