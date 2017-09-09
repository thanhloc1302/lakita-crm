/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).on('click', '.btn-send-account-lakita', function (e) {
    e.preventDefault();
    var contact_id = $(this).attr("contact_id");
    var url = $("#base_url").val() + "send_email/send_account_lakita";
    $.ajax({
        url: url,
        type: "POST",
        data: {
            contact_id: contact_id
        },
        beforeSend: function () {
            $(".popup-wrapper").show();
        },
        success: function (data) {
            console.log(data);
            $("#send_email_sound")[0].play();
            $.notify('Gửi email thành công!', {
                position: "top left",
                className: 'success',
                showDuration: 200,
                autoHideDelay: 3000
            });
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

