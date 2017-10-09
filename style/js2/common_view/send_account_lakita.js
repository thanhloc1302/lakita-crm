/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).on('click', '.btn-send-account-lakita', function (e) {
    e.preventDefault();
    if ($("select.cod_status_id").val() != 3) {
        $("#send_email_error")[0].play();
        $.notify('Bạn cần chuyển trạng thái giao hàng là "Đã thu Lakita" trước khi thực hiện thao tác này!', {
            position: "top left",
            className: 'error',
            showDuration: 200,
            autoHideDelay: 7000
        });
        return false;
    }
    var contact_id = $(this).attr("contact_id");
    var url = $("#base_url").val() + "send_email/send_account_lakita";
    $.ajax({
        url: url,
        type: "POST",
        data: {
            contact_id: contact_id
        },
        dataType: 'json',
        beforeSend: () => $(".popup-wrapper").show(),
        success: data => {
            console.log(data.success);
            if (data.success == 0) {
                $("#send_email_error")[0].play();
                $.notify('Có lỗi xảy ra! Nội dung: ' + data.message, {
                    position: "top left",
                    className: 'error',
                    showDuration: 200,
                    autoHideDelay: 7000
                });
            } else {
                $("#send_email_sound")[0].play();
                $.notify('Gửi email thành công!', {
                    position: "top left",
                    className: 'success',
                    showDuration: 200,
                    autoHideDelay: 3000
                });
            }
        },
        complete: () => $(".popup-wrapper").hide(),
        error: () => {
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

