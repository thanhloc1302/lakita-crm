$(document).on('click', 'a.edit_contact', function (e) {
    e.preventDefault();
    $(".checked").removeClass("checked");
    $(this).parent().parent().addClass("checked");
    var contact_id = $(this).attr("contact_id");
    var url = $("#base_url").val() + "common/show_edit_contact_modal";
    $.ajax({
        url: url,
        type: "POST",
        data: {
            contact_id: contact_id
        },
        success: function (data) {
            // console.log(data);
            $("div.replace_content").html(data);
        },
        complete: function () {
            $(".edit_contact_modal").modal("show");
        }
    });
});

$(document).on('click', '.btn-edit-contact', function (e) {
    e.preventDefault();
    if(check_edit_contact() == false) {
        return false;
    }
    var url = $(this).parents('.form_edit_contact_modal').attr("action");
    var contact_id = $(this).parents('.form_edit_contact_modal').attr("contact_id");
    $.ajax({
        url: url,
        type: "POST",
        dataType: 'json',
        data: $(".form_edit_contact_modal").serialize(),
        success: function (data) {
            if (data.success == 1) {
                $("#send_email_sound")[0].play();
                $.notify(data.message, {
                    position: "top left",
                    className: 'success',
                    showDuration: 200,
                    autoHideDelay: 5000
                });
                $(".edit_contact_modal").modal("hide");
                $('tr[contact_id="'+contact_id+'"]').html("");
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

$(document).on('change', 'select.edit_payment_method_rgt', function (e) {
    if ($(this).val() == 2) {
        $(".tbl_bank").show(1000);
    } else {
        $(".tbl_bank").hide();
    }
    if ($(this).val() == 1) {
        $(".tbl_cod").show(1000);
    } else {
        $(".tbl_cod").hide();
    }
    set_equal_table_height();
});


function set_equal_table_height() {
    if ($(".table-1").height() > $(".table-2").height())
    {
        $(".table-2").height($(".table-1").height());
    } else
    {
        $(".table-1").height($(".table-2").height());
    }
}

$('.edit_contact_modal').on('shown.bs.modal', function () {
    $('.datetimepicker').datetimepicker(
            {
                format: 'DD-MM-YYYY HH:mm'
            });
    if ($("select.edit_payment_method_rgt").val() != 2) {
        $(".tbl_bank").hide();
    }
    if ($("select.edit_payment_method_rgt").val() != 1) {
        $(".tbl_cod").hide();
    }
});