/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//add-new-contact-modal
$(document).on("click", ".add-new-contact-modal", function (e) {
    e.preventDefault();
    var modalName = 'add-new-contact-modal-show';
    $.ajax({
        url: $(this).attr('href'),
        type: "POST",
        success: data => {
            $("." + modalName).remove();
            var newModal = `<div class="${modalName}"></div>`;
            $(".modal-append-to").append(newModal);
            $(`.${modalName}`).html(data);
        },
        complete: () => $(`.${modalName} .modal`).modal("show")
    });

});

$(document).on('click', '.btn-action-add-new-contact', function (e) {
    e.preventDefault();
    $.ajax({
        url: $(".form_add_new_contact_modal").attr('action'),
        type: "POST",
        data: $(".form_add_new_contact_modal").serialize(),
        dataType: 'json',
        beforeSend: () => $(".popup-wrapper").show(),
        success: data => {
            console.log(data);
            if (data.success == 1) {
                $("#send_email_sound")[0].play();
                $.notify(data.message, {
                    position: "bottom left",
                    className: 'success',
                    showDuration: 200,
                    autoHideDelay: 5000
                });
                $('.add-new-contact-modal-show .modal').modal("hide");
            } else {
                $("#send_email_error")[0].play();
                $.notify('Có lỗi xảy ra! Nội dung: ' + data.message, {
                    position: "top left",
                    className: 'error',
                    showDuration: 200,
                    autoHideDelay: 7000
                });

            }
            $(".popup-wrapper").hide();
        },
        complete: () => $(".popup-wrapper").hide()
    });
});

