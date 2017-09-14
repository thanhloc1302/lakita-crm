/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).on('click', '.btn-send-banking-info', function (e) {
    e.preventDefault();
    var contact_id = $(this).attr("contact_id");
    var url = $("#base_url").val() + "send_email/send_banking_info";
    $.ajax({
        url: url,
        type: "POST",
        data: {
            contact_id: contact_id,
            name: $(".edit-contact-name").val(),
            email: $(".edit-contact-email").val(),
            price_purchase: $(".edit-contact-price-purchase").val()
        },
        dataType: 'json',
        beforeSend: function () {
            $(".popup-wrapper").show();
        },
        success: function (data) {
            if (data.success == 1) {
                $("#send_email_sound")[0].play();
                $.notify('Gửi email thành công!', {
                    position: "top left",
                    className: 'success',
                    showDuration: 200,
                    autoHideDelay: 3000
                });
            } else {
                $("#send_email_error")[0].play();
                $.notify('Có lỗi xảy ra. Nội dung: ' + data.message, {
                    position: "top left",
                    className: 'error',
                    showDuration: 200,
                    autoHideDelay: 3000
                });
            }
        },
        complete: function () {
            $(".popup-wrapper").hide();
        },
        error: function () {
            $("#send_email_error")[0].play();
            $.notify('Có lỗi xảy ra trong quá trình gửi email!', {
                position: "top left",
                className: 'error',
                showDuration: 200,
                autoHideDelay: 3000
            });
        }
    });
});

