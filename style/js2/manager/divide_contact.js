
/*=================================== chia contact đã chọn (form modal)================================================*/
$("a.divide_contact").on('click', function (e) {
    e.preventDefault();
    $("#action_contact").removeClass("form-inline");
    $(".divide_multi_contact_modal").modal("show");
});

/*=================================== chia từng contact một (form modal)================================================*/
$(document).on('click', '.divide_one_contact_achor', function (e) {
    e.preventDefault();
    $("#action_contact").removeClass("form-inline");
    var contact_id = $(this).attr("contact_id");
    $(".checked").removeClass("checked");
    $(this).parent().parent().addClass("checked");
    $("#contact_id_input").val(contact_id);
    var contact_name = $(this).attr("contact_name");
    $("span.contact_name").text(contact_name);
    $(".divide_one_contact_modal").modal("show");
});

/*=================================== chia đều contact đã chọn ================================================*/
$(".divide_contact_even").on('click', function (e) {
    e.preventDefault();
    $("#action_contact").attr("action", $("#base_url").val() + "manager/divide_contact_even");
    $("#action_contact").submit();
});

/*===================================== phân contact bằng ajax ==============*/

$(document).on('click', '.btn-divide-one-contact', function (e) {
    e.preventDefault();
    var url = $(this).parents('#transfer_one_contact').attr("action");
    var contact_id = $("#contact_id_input").val();
    $.ajax({
        url: url,
        type: "POST",
        dataType: 'json',
        data: $('#transfer_one_contact').serialize(),
        success: function (data) {
            if (data.success == 1) {
                $("#send_email_sound")[0].play();
                $.notify(data.message, {
                    position: "top left",
                    className: 'success',
                    showDuration: 200,
                    autoHideDelay: 5000
                });
                $(".divide_one_contact_modal").modal("hide");
                $('tr[contact_id="' + contact_id + '"]').hide();
            } else {
                $("#send_email_error")[0].play();
                $.notify('Có lỗi xảy ra! Nội dung: ' + data.message, {
                    position: "top left",
                    className: 'error',
                    showDuration: 200,
                    autoHideDelay: 7000
                });
            }
        },
        complete: function () {

        }
    });
});