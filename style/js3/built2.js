'use strict';

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

show_number_selected_row = function show_number_selected_row() {
    var numberOfChecked = $('input:checkbox:checked').length;
    var totalCheckboxes = $('input:checkbox').length;
    /*
     * Lấy tổng giá
     */
    var sum = 0;
    for (i = 0; i < numberOfChecked; i++) {
        sum += parseInt($($('input:checkbox:checked')[i]).parent().parent().find('.tbl_price_purchase').text());
    }
    $.notify('\u0110\xE3 ch\u1ECDn: ' + numberOfChecked + ' / ' + totalCheckboxes + '. t\u1ED5ng ti\u1EC1n = ' + sum.toLocaleString(), {
        position: "top left",
        className: 'success',
        showDuration: 200,
        autoHideDelay: 3000
    });
};

unselect_not_checked = function unselect_not_checked() {
    $('input[type="checkbox"]').each(function () {
        if (!$(undefined).is(":checked")) {
            $(undefined).parent().parent().removeClass('checked');
        }
    });
};

unselect_checked = function unselect_checked() {
    $('input[type="checkbox"]').each(function () {
        if ($(undefined).is(":checked")) {
            $(undefined).parent().parent().removeClass('checked');
        }
    });
};
uncheck_checked = function uncheck_checked() {
    $('input[type="checkbox"]').each(function () {
        if ($(undefined).is(":checked")) {
            $(undefined).prop("checked", false);
        }
    });
};
uncheck_not_checked = function uncheck_not_checked() {
    $('input[type="checkbox"]').each(function () {
        if (!$(undefined).is(":checked")) {
            $(undefined).prop("checked", false);
        }
    });
};

right_context_menu_display = function right_context_menu_display(controller, contact_id, contact_name, duplicate_id, contact_phone) {
    $(".action_view_detail_contact").attr('contact_id', contact_id);
    $("a.view_duplicate").attr("duplicate_id", duplicate_id);
    $("a.send_to_mobile").attr("contact_name", contact_name).attr("contact_phone", contact_phone);
    /*
     * Nếu chọn nhiều contact thì ẩn menu xem chi tiết contact 
     * và phân 1 contact
     */
    var numberOfChecked = $('input:checkbox:checked').length;
    if (numberOfChecked > 1) {
        $("a.view_duplicate, .action_view_detail_contact, .divide_one_contact_achor, " + ".edit_contact, .transfer_one_contact, .send_to_mobile").addClass("hidden");
        $(".divide_multi_contact,.transfer_contact, " + ".select_provider, .btn-export-excel, .btn-export-excel-for-viettel, .export_to_string").removeClass('hidden');
    } else {
        $(".action_view_detail_contact, .divide_one_contact_achor, a.view_duplicate, " + ".edit_contact, .transfer_one_contact, .send_to_mobile").removeClass("hidden");
        $(".divide_multi_contact, .transfer_contact, " + ".select_provider, .export_to_string").addClass('hidden');
        if (duplicate_id > 0) {
            $("a.view_duplicate").removeClass("hidden");
        } else {
            $("a.view_duplicate").addClass("hidden");
        }
    }

    if (controller === 'manager') {
        $(".divide_one_contact_achor").attr('contact_id', contact_id);
        $(".divide_one_contact_achor").attr('contact_name', contact_name);
        /*
         * Nếu contact trùng thì ẩn tính năng bàn giao contact
         */
        if (numberOfChecked < 1) {
            if (duplicate_id > 0) {
                $(".divide_one_contact_achor").addClass('hidden');
            }
            /*
             * Nếu contact không trùng thì ẩn tính năng xem contact trùng
             */
            else {
                    $(".divide_one_contact_achor").removeClass('hidden');
                }
        }
    } else if (controller === 'sale' || controller === 'cod') {
        $(".edit_contact").attr('contact_id', contact_id);
        $(".transfer_one_contact").attr('contact_id', contact_id);
        $(".transfer_one_contact").attr('contact_name', contact_name);
    }
};

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var _SO_MAY_SAI_ = 1;
var _KHONG_NGHE_MAY_ = 2;
var _NHAM_MAY_ = 3;
var _DA_LIEN_LAC_DUOC_ = 4;
var _CONTACT_CHET_ = 5;

var _CHUA_CHAM_SOC_ = 0;
var _TU_CHOI_MUA_ = 3;
var _DONG_Y_MUA_ = 4;

check_edit_contact = function check_edit_contact() {
    var call_status_id = $("select[name='call_status_id']").val();
    var ordering_status_id = $("select[name='ordering_status_id']").val();
    var date_recall = $(".date_recall").val();
    var course_code = $('select.select_course_code').val();
    var price_purchase = $('[name="price_purchase"]').val();
    if ($("select.edit_payment_method_rgt").val() == 0) {
        alert("Bạn cần cập nhật hình thức thanh toán!");
        return false;
    }
    if (call_status_id == 0) {
        alert("Bạn cần cập nhật trạng thái gọi!");
        return false;
    }
    if (check_rule_call_stt(call_status_id, ordering_status_id) == false) {
        alert("Trạng thái gọi và trạng thái đơn hàng không logic!");
        return false;
    }
    if (date_recall != '') {
        if (now_greater_than_input_date(date_recall)) {
            alert("Ngày gọi lại không thể là một ngày trước ngày hôm nay!");
            return false;
        }
        if (check_rule_call_stt_and_date_recall(call_status_id, ordering_status_id, date_recall)) {
            alert("Nếu contact không liên lạc được hoặc không thể chăm sóc được nữa thì không thể có ngày gọi lại lớn hơn ngày hiện tại!");
            return false;
        }
    }
    if (course_code == '0') {
        alert("Vui lòng chọn mã khóa học!");
        return false;
    }
    if (price_purchase == '') {
        alert("Vui lòng chọn giá tiền mua!");
        return false;
    }
    return true;
};

check_rule_call_stt = function check_rule_call_stt(call_status_id, ordering_status_id) {
    if (call_status_id == _SO_MAY_SAI_ || call_status_id == _KHONG_NGHE_MAY_ || call_status_id == _NHAM_MAY_) {
        if (ordering_status_id != _CHUA_CHAM_SOC_) {
            return false;
        }
    }
    if (call_status_id == _DA_LIEN_LAC_DUOC_) {
        if (ordering_status_id == _CHUA_CHAM_SOC_) {
            return false;
        }
    }
    //        if (call_status_id == _CONTACT_CHET_ && (ordering_status_id == _DONG_Y_MUA_ || ordering_status_id == _TU_CHOI_MUA_)) {
    //            return false;
    //        }
    return true;
};

check_rule_call_stt_and_date_recall = function check_rule_call_stt_and_date_recall(call_status_id, ordering_status_id, date_recall) {
    if (stop_care(call_status_id, ordering_status_id) && now_greater_than_input_date(date_recall)) {
        return true;
    }
    return false;
};

stop_care = function stop_care(call_status_id, ordering_status_id) {
    if (call_status_id == _SO_MAY_SAI_ || call_status_id == _NHAM_MAY_ || call_status_id == _KHONG_NGHE_MAY_ || ordering_status_id == _DONG_Y_MUA_ || ordering_status_id == _TU_CHOI_MUA_ || ordering_status_id == _CONTACT_CHET_) {
        return true;
    }
    return false;
};
now_greater_than_input_date = function now_greater_than_input_date(date_string) {
    var date_arr = date_string.split(/-/);
    var year = date_arr[2];
    var month = date_arr[1];
    var day = date_arr[0];
    var now_timestamp = new Date();
    now_timestamp = now_timestamp.getTime();
    var input_timestamp = new Date(year, month - 1, day);
    input_timestamp = input_timestamp.getTime();
    return now_timestamp > input_timestamp;
};

$(document).on('click', 'a.delete_one_contact_admin', function (e) {
    var r = confirm("Bạn có chắc chắn muốn xóa contact này không?");
    if (r == true) {
        var del = $(e.target);
        var contact_id = $(e.target).attr("contact_id");
        $.ajax({
            type: "POST",
            url: $("#base_url").val() + "admin/delete_one_contact",
            data: {
                contact_id: contact_id
            },
            success: function success(data) {
                console.log(data);
                if (data === '1') {
                    del.parent().parent().hide();
                    //location.reload();
                } else {
                    alert(data);
                }
            },
            error: function error(errorThrown) {
                return alert(errorThrown);
            }
        });
        return false;
    }
});
$(document).on('click', 'a.delete_forever_one_contact_admin', function (e) {
    var r = confirm("Bạn có chắc chắn muốn xóa contact này không?");
    if (r == true) {
        var del = $(this);
        var contact_id = $(this).attr("contact_id");
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $("#base_url").val() + "admin/delete_forever_one_contact",
            data: {
                contact_id: contact_id
            },
            success: function success(data) {
                if (data === '1') {
                    del.parent().parent().hide();
                    //location.reload();
                } else {
                    alert(data);
                }
            },
            error: function error(errorThrown) {
                return alert(errorThrown);
            }
        });
    }
});

/* 
 * Copyright (C) 2017 Phạm Ngọc Chuyển <chuyenpn at lakita.vn>
 *
 */
$(document).on('click', 'a.retrieve_contact', function (e) {
    var r = confirm("Bạn có chắc chắn muốn thu hồi contact này không?");
    if (r == true) {
        var del = $(this);
        var contact_id = $(this).attr("contact_id");
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $("#base_url").val() + "admin/retrieve_contact",
            data: {
                contact_id: contact_id
            },
            success: function success(data) {
                if (data === '1') {
                    alert('Thu hồi thành công contact');
                    //del.parent().parent().hide();
                    location.reload();
                } else {
                    alert(data);
                }
            },
            error: function error(errorThrown) {
                return alert(errorThrown);
            }
        });
    }
});

$(document).on('click', 'a.add_item', function (e) {
    e.preventDefault();
    var url = $("#url_add_item").val();
    $.ajax({
        url: url,
        type: "POST",
        success: function success(data) {
            $("div.replace_content_add_item_modal").html(data);
        },
        complete: function complete() {
            $(".add_item_modal").modal("show");
        }
    });
});

$(document).on('click', 'a.delete_item', function (e) {
    e.preventDefault();
    var r = confirm("Bạn có chắc chắn muốn xóa dòng này không?");
    if (r === true) {
        var del = $(this);
        var item_id = $(this).attr("item_id");
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $("#url_delete_item").val(),
            data: {
                item_id: item_id
            },
            success: function success(data) {
                console.log(data);
                if (data === '1') {
                    location.reload();
                } else {
                    alert(data);
                }
            },
            error: function error(errorThrown) {
                alert('Không thể xóa do foreign-key, liên hệ admin để biết thêm chi tiết');
            }
        });
    }
});
$("a.delete_multi_item").on('click', function (e) {
    e.preventDefault();
    var r = confirm("Bạn có chắc chắn muốn xóa các dòng đã chọn không?");
    if (r === true) {
        $("#form_item").attr("action", $("#url_delete_multi_item").val()).attr("method", "POST");
        $("#form_item").submit();
    }
});
$(document).on('click', 'a.edit_item', function (e) {
    e.preventDefault();
    var item_id = $(this).attr("item_id");
    var url = $("#url_edit_item").val();
    $.ajax({
        url: url,
        type: "POST",
        data: {
            item_id: item_id
        },
        success: function success(data) {
            $("div.replace_content_edit_item_modal").html(data);
        },
        complete: function complete() {
            $(".edit_item_modal").modal("show");
        }
    });
}); /*
    * Real order
    */
$('th[class^="order_new_"]').on('click', function () {
    var myclass = $(this).attr("class");
    myclass = myclass.split(/ /);
    myclass = myclass[0];
    $('input[class^="order_new_"]').not("input." + myclass).attr('value', '0');
    if ($("input." + myclass).val() === '0') {
        $("input." + myclass).attr('value', 'ASC').promise().done(function () {
            $("#form_item").submit();
        });
        return;
    }
    if ($("input." + myclass).val() === 'ASC') {
        $("input." + myclass).val('DESC').promise().done(function () {
            $("#form_item").submit();
        });
        return;
    }
    if ($("input." + myclass).val() === 'DESC') {
        $("input." + myclass).val('0').promise().done(function () {
            $("#form_item").submit();
        });
        return;
    }
});
/*
 * Real filter
 */
$(".real_filter").on('change', function () {
    $("#form_item").submit();
});

/*
 * Cố định thanh <thead> và phần search của table
 */
$(document).on('scroll', function () {
    /*
     * Khi cuộn chuột quá vị trí của phần thead thì thead ẩn đi và phần thead-fixed hiện lên
     */
    if ($(".table-head-pos").length) {
        if ($("body").scrollTop() > $(".table-head-pos").offset().top) {
            $(".fixed-table").css({
                "display": "block"
            });
        } else {
            $(".fixed-table").css({
                "display": "none"
            });
        }
        /*
         * Điều chỉnh lại kích cỡ của các th phần thead
         */
        $('[id^="th_"]').each(function () {
            var myID = $(this).attr("id");
            var mywidth = $(this).width();
            var myheight = $(this).height();
            $("#f_" + myID).width(mywidth);
            $("#f_" + myID).height(myheight);
        });
        /*
         * Điều chỉnh lại kích cỡ của các td phần tbody (các ô search)
         */
        $('[id^="td_"]').each(function () {
            var myID = $(this).attr("id");
            var mywidth = $(this).width();
            var myheight = $(this).height();
            $("#f_" + myID).width(mywidth);
            $("#f_" + myID).height(myheight);
        });
        /*
         * Căn chỉnh phần search cho khớp xuống dưới phần head 
         * (vì cùng là position fixed nên top mặc định bằn 0 => bị đè vị trí lên nhau)
         */
        $("tbody.fixed-table").css("top", $("thead.fixed-table").height());

        /*
         * Căn chỉnh lại cho thẳng hàng
         */
        //        var offsetLeft = $(".table-head-pos").offset().left - 1;
        //        $(".fixed-table").css("left", offsetLeft + "px");
    }
});$(document).on('click', 'a.delete_bill', function (e) {
    var r = confirm("Bạn có chắc chắn muốn xóa dòng đối soát này không?");
    if (r == true) {
        var del = $(this);
        var bill_id = $(this).attr("bill_id");
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $("#base_url").val() + "CODS/check_L8/delete_bill",
            data: {
                bill_id: bill_id
            },
            success: function success(data) {
                console.log(data);
                if (data === '1') {
                    del.parent().parent().parent().hide();
                    //location.reload();
                } else {
                    alert(data);
                }
            },
            error: function error(errorThrown) {
                return alert(errorThrown);
            }
        });
    }
});
$(document).on('click', 'a.edit_bill', function (e) {
    e.preventDefault();
    var bill_id = $(this).attr("bill_id");
    var url = $("#base_url").val() + "CODS/check_L8/show_edit_bill";
    $.ajax({
        url: url,
        type: "POST",
        data: {
            bill_id: bill_id
        },
        success: function success(data) {
            console.log(data);
            $("div.replace_content_edit_bill_modal").html(data);
        },
        complete: function complete() {
            return $(".edit_bill_modal").modal("show");
        }
    });
});
$(".btn-export-excel").on('click', function (e) {
    e.preventDefault();
    $("#action_contact").attr("action", $("#base_url").val() + "cod/export_for_print");
    $("#action_contact").submit();
});
$(".btn-export-excel-for-viettel").on('click', function (e) {
    e.preventDefault();
    $("#action_contact").attr("action", $("#base_url").val() + "cod/export_for_send_provider");
    $("#action_contact").submit();
});
$('.export_to_string').on('click', function (e) {
    e.preventDefault();
    var myCheckboxes = new Array();
    $("input:checked").each(function () {
        myCheckboxes.push($(this).val());
    });
    $.ajax({
        url: $("#base_url").val() + "cod/export_to_string",
        type: "POST",
        data: {
            contact_id: myCheckboxes
        },
        success: function success(data) {
            console.log(data);
            $(".replace_content_2").text(data);
        },
        complete: function complete() {
            $(".export_to_string_modal").modal("show");
        }
    });
});$(document).on('click', '.select_provider', function (e) {
    $("#action_contact").removeClass("form-inline");
    e.preventDefault();
    $(".edit_multi_cod_contact").modal("show");
});

$(".btn-modal_edit-multi-contact").on('click', function (e) {
    e.preventDefault();
    var error = false;

    if (!error) {
        var url = $("#base_url").val() + "common/action_edit_multi_cod_contact";
        /*
         * Lấy các contact chăm sóc để ẩn đi
         */
        var contactIdArray = [];
        $('input[type="checkbox"]').each(function () {
            if ($(this).is(":checked")) {
                contactIdArray.push($(this).val());
            }
        });
        $.ajax({
            url: url,
            type: "POST",
            dataType: 'json',
            data: $("#action_contact").serialize(),
            success: function success(data) {
                if (data.success == 1) {
                    $("#send_email_sound")[0].play();
                    $.notify(data.message, {
                        position: "top left",
                        className: 'success',
                        showDuration: 200,
                        autoHideDelay: 5000
                    });
                    $.each(contactIdArray, function () {
                        $('tr[contact_id="' + this + '"]').remove();
                    });
                    $(".edit_multi_cod_contact").modal("hide");
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
            complete: function complete() {}
        });
        //$("#action_contact").submit();
    }
});
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
        success: function success(data) {
            return $("div.replace_content").html(data);
        },
        complete: function complete() {
            return $(".edit_contact_modal").modal("show");
        }
    });
});

$(document).on('click', '.btn-edit-contact', function (e) {
    e.preventDefault();
    if (check_edit_contact() == false) {
        return false;
    }
    var url = $(this).parents('.form_edit_contact_modal').attr("action");
    var contact_id = $(this).parents('.form_edit_contact_modal').attr("contact_id");
    $.ajax({
        url: url,
        type: "POST",
        dataType: 'json',
        data: $(".form_edit_contact_modal").serialize(),
        success: function success(data) {
            if (data.success == 1) {
                $("#send_email_sound")[0].play();
                $.notify(data.message, {
                    position: "top left",
                    className: 'success',
                    showDuration: 200,
                    autoHideDelay: 5000
                });
                $(".edit_contact_modal").modal("hide");
                $('tr[contact_id="' + contact_id + '"]').remove();
            } else {
                $("#send_email_error")[0].play();
                $.notify('Có lỗi xảy ra! Nội dung: ' + data.message, {
                    position: "top left",
                    className: 'error',
                    showDuration: 200,
                    autoHideDelay: 7000
                });
            }
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
    if ($(".table-1").height() > $(".table-2").height()) {
        $(".table-2").height($(".table-1").height());
    } else {
        $(".table-1").height($(".table-2").height());
    }
}

$('.edit_contact_modal').on('shown.bs.modal', function () {
    $('.datetimepicker').datetimepicker({
        format: 'DD-MM-YYYY HH:mm'
    });
    if ($("select.edit_payment_method_rgt").val() != 2) {
        $(".tbl_bank").hide();
    }
    if ($("select.edit_payment_method_rgt").val() != 1) {
        $(".tbl_cod").hide();
    }
});$(function () {
    setTimeout(function () {
        if ($(".filter-tbl-1").height() > $(".filter-tbl-2").height()) {
            $(".filter-tbl-2").height($(".filter-tbl-1").height());
        } else {
            $(".filter-tbl-1").height($(".filter-tbl-2").height());
        }
    }, 300);
});
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
        beforeSend: function beforeSend() {
            return $(".popup-wrapper").show();
        },
        success: function success(data) {
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
        complete: function complete() {
            return $(".popup-wrapper").hide();
        },
        error: function error() {
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
        beforeSend: function beforeSend() {
            return $(".popup-wrapper").show();
        },
        success: function success(data) {
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
        complete: function complete() {
            return $(".popup-wrapper").hide();
        },
        error: function error() {
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

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//
//var nameArr = {
//    id: {
//        name: 'ID Contact',
//        type: 'text'
//    },
//    name: {
//        name: 'Họ và tên',
//        type: 'text'
//    },
//    email: {
//        name: 'Email',
//        type: 'text'
//    },
//    price_purchase: {
//        name: 'Giá tiền mua',
//        type: 'currency'
//    },
//    call_status_id: {
//        name: 'Trạng thái gọi',
//        type: 'array'
//    }
//};
//
//$(document).on('click', 'a.action_view_detail_contact', function (e) {
//    e.preventDefault();
//    var url = $("#base_url").val() + "common/view_detail_contact";
//    var contact_id = $(this).attr("contact_id");
//    $.ajax({
//        url: url,
//        type: "POST",
//        data: {
//            contact_id: contact_id
//        },
//        dataType: "json",
//        success: function (data) {
//            var result = gen_result(data);
//            $("div.replace_content_view_detail_contact").html(result);
//        },
//        complete: function () {
//            $(".view_detail_contact_modal").modal("show");
//        }
//    });
//});
//
//function gen_result(data) {
//    var result = `<div class="row real-search-result-replace">`;
//    result += `<div class="col-md-6">
//                    <table class="table table-striped table-bordered table-hover table-view-1">`;
//    for (var prop in data.view_edit_left) {
//        result += v_row(prop, data);
//    }
//    result += `</table></div>`;
//    result += `</div>`;
//    return result;
//}
//
//function v_row(prop, data) {
//    var result = ``;
//    console.log(prop);
//    console.log(nameArr[prop]);
//    result = `<tr>
//                      <td class="text-right"> ` + nameArr[prop]['name'] + `</td>
//                      <td>`;
//    if (nameArr[prop]['type'] === 'text') {
//        result += data['rows'][prop];
//        result += ` <input type="text" class="form-control datepicker date_recall" name="date_recall" />`;
//    }
//    if (nameArr[prop]['type'] === 'currency') {
//        result += digits(data['rows'][prop]) + ' VNĐ';
//    }
//   
//    result += `       </td>
//              </tr>`;
//
//    return result;
//}
//
//function v_call_status(call_status_id1, call_status_arr) {
//    var result = ``;
//    var name = '' + {call_status_id1} + '';
//    $.each(call_status_arr, function () {
//        if (call_status_id1 === this.id) {
//            result = `<tr>
//                        <td class="text-right"> ` + nameArr.name + `</td>
//                        <td> 
//                            ${this.name}
//                        </td>
//                      </tr>`;
//        }
//    });
//    return result;
//}
//
//function e_call_status(call_status_id, call_status_arr) {
//    console.log(call_status_id);
//    var result = `<tr>
//    <td class="text-right"> Trạng thái gọi </td>
//    <td>  
//        <select class="form-control call_status_id selectpicker" name="call_status_id">`;
//    $.each(call_status_arr, function () {
//        result += ` <option value="${this.id}" ${ (this.id === call_status_id) ? 'selected' : '' }>
//                ${ this.name}
//                </option>`;
//    });
//    result += `</select></td></tr>`;
//    return result;
//}
//
//
//function digits(number){ 
//    return number.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") ; 
//};
/* 
 * Copyright (C) 2017 Phạm Ngọc Chuyển <chuyenpn at lakita.vn>
 *
 */

$('.tbl_name').on('click', 'span.badge-star', function (e) {
    e.stopPropagation();
    e.preventDefault();
    var contact_phone = $(this).attr("contact_phone");
    var contact_course_code = $(this).attr("contact_course_code");
    var controller = $(this).attr("controller");
    var url = $("#base_url").val() + "common/view_contact_star";
    //console.log(url);
    $.ajax({
        url: url,
        type: "POST",
        data: {
            contact_phone: contact_phone,
            contact_course_code: contact_course_code,
            controller: controller
        },
        success: function success(data) {
            return $("div.replace_content_view_contact_star").html(data);
        },
        complete: function complete() {
            return $(".view_contact_star_modal").modal("show");
        }
    });
});

$('.view_contact_star_modal').on('hide.bs.modal', function () {
    return $("div.replace_content_view_contact_star").html("");
});$(document).on('click', 'a.action_view_detail_contact', function (e) {
    e.preventDefault();
    $(".checked").removeClass("checked");
    $(this).parent().parent().addClass("checked");
    var contact_id = $(this).attr("contact_id");
    var url = $("#base_url").val() + "common/view_detail_contact";
    //console.log(url);
    $.ajax({
        url: url,
        type: "POST",
        data: {
            contact_id: contact_id
        },
        success: function success(data) {
            return $("div.replace_content_view_detail_contact").html(data);
        },
        complete: function complete() {
            return $(".view_detail_contact_modal").modal("show");
        }
    });
});
$('.view_detail_contact_modal').on('shown.bs.modal', function () {
    if ($(".table-view-1").height() > $(".table-view-2").height()) {
        $(".table-view-2").height($(".table-view-1").height());
    } else {
        $(".table-view-1").height($(".table-view-2").height());
    }
});

$(document).on("click", ".view_contact_phone", function () {
    document.querySelector("#input-copy").select();
    document.execCommand('copy');
    $.notify("Copy thành công vào clipboard", {
        position: "top left",
        className: 'success',
        showDuration: 200,
        autoHideDelay: 2000
    });
});
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * Hiển thị menu chuột phải
 */
$(document).on('contextmenu', 'tr.custom_right_menu', function (e) {
    e.preventDefault();
    /*
     * Lấy các thuộc tính của contact
     */
    var contact_id = $(this).attr('contact_id');
    var contact_name = $(this).attr('contact_name');
    var duplicate_id = $(this).attr("duplicate_id");
    var contact_phone = $(this).attr("contact_phone");
    var controller = $("#input_controller").val();
    right_context_menu_display(controller, contact_id, contact_name, duplicate_id, contact_phone);

    var menu = $(".menu");
    menu.hide();
    var pageX = e.pageX;
    var pageY = e.pageY;
    menu.css({ top: pageY, left: pageX });
    var mwidth = menu.width();
    var mheight = menu.height();
    var screenWidth = $(window).width();
    var screenHeight = $(window).height();
    var scrTop = $(window).scrollTop();
    /*
     * Nếu "tọa độ trái chuột" + "chiều dài menu" > "chiều dài trình duyệt" 
     * thì hiển thị sang bên phải tọa độ click
     */
    if (pageX + mwidth > screenWidth) {
        menu.css({ left: pageX - mwidth });
    }
    /*
     * Nếu "tọa độ top chuột" + "chiều cao menu" > "chiều cao trình duyệt" + "chiều dài cuộn chuột"
     * thì hiển thị lên trên tọa độ click
     */
    if (pageY + mheight > screenHeight + scrTop) {
        menu.css({ top: pageY - mheight });
    }
    menu.show();
    /*
     * Nếu dòng đó đang không chọn (đã click trái) thì bỏ chọn và bỏ check những dòng đã chọn
     */
    var is_checked_input = $(this).find('input[type="checkbox"]');
    if (!is_checked_input[0].checked) {
        $(".checked").removeClass("checked");
        uncheck_checked();
    } else {
        unselect_not_checked();
    }
    $(this).addClass('checked'); /*.find('[name="contact_id[]"]').prop('checked', true); */
});

//$("tr.custom_right_menu").on(
//        {
//            contextmenu: function (e) {
//                e.preventDefault();
//                /*
//                 * Lấy các thuộc tính của contact
//                 */
//                var contact_id = $(this).attr('contact_id');
//                var contact_name = $(this).attr('contact_name');
//                var duplicate_id = $(this).attr("duplicate_id");
//                var contact_phone = $(this).attr("contact_phone");
//                var controller = $("#input_controller").val();
//                right_context_menu_display(controller, contact_id, contact_name, duplicate_id, contact_phone);
//
//                var menu = $(".menu");
//                menu.hide();
//                var pageX = e.pageX;
//                var pageY = e.pageY;
//                menu.css({top: pageY, left: pageX});
//                var mwidth = menu.width();
//                var mheight = menu.height();
//                var screenWidth = $(window).width();
//                var screenHeight = $(window).height();
//                var scrTop = $(window).scrollTop();
//                /*
//                 * Nếu "tọa độ trái chuột" + "chiều dài menu" > "chiều dài trình duyệt" 
//                 * thì hiển thị sang bên phải tọa độ click
//                 */
//                if (pageX + mwidth > screenWidth) {
//                    menu.css({left: pageX - mwidth});
//                }
//                /*
//                 * Nếu "tọa độ top chuột" + "chiều cao menu" > "chiều cao trình duyệt" + "chiều dài cuộn chuột"
//                 * thì hiển thị lên trên tọa độ click
//                 */
//                if (pageY + mheight > screenHeight + scrTop) {
//                    menu.css({top: pageY - mheight});
//                }
//                menu.show();
//                /*
//                 * Nếu dòng đó đang không chọn (đã click trái) thì bỏ chọn và bỏ check những dòng đã chọn
//                 */
//                var is_checked_input = $(this).find('input[type="checkbox"]');
//                if (!is_checked_input[0].checked) {
//                    $(".checked").removeClass("checked");
//                    uncheck_checked();
//                } else {
//                    unselect_not_checked();
//                }
//                $(this).addClass('checked'); /*.find('[name="contact_id[]"]').prop('checked', true); */
//            },
//            click: function () {
//
//            },
//            dblclick: function (e) {
//                var contact_id = $(this).attr('contact_id');
//                $(".edit_contact").attr('contact_id', contact_id);
//                e.preventDefault();
//                $("a.edit_contact").click();
//            }
//        });

/*
 * High light vào các dòng khi click trái để chọn 
 */
$(document).on("click", "td.tbl_name, td.tbl_address", function () {
    if ($(this).parent().hasClass('checked')) {
        $(this).parent().removeClass('checked');
    } else {
        $(this).parent().addClass('checked');
    }
    var input_checkbox = $(this).parent().find('[name="contact_id[]"]');
    if (input_checkbox.is(":checked")) {
        input_checkbox.prop('checked', false);
    } else {
        input_checkbox.prop('checked', true);
    }
    unselect_not_checked();
    show_number_selected_row();
});

$("html").on("click", function (e) {
    $(".menu").hide();
    $(".menu-item").hide();
    /*
     * Nếu click ra ngoài bảng thì bỏ chọn các contact
     */
    if (e.target.className.indexOf("form-inline") !== -1 || e.target.className.indexOf("number_paging") !== -1) {
        $("input[type='checkbox']").prop('checked', false);
        $('.checked').removeClass('checked');
    }
});

shortcut.add("Ctrl+s", function () {
    $(".btn-edit-contact").click();
});
shortcut.add("Ctrl+a", function () {
    $("input[type='checkbox']").prop('checked', true);
    $('.custom_right_menu').addClass('checked');
    show_number_selected_row();
});
shortcut.add("Esc", function () {
    $("input[type='checkbox']").prop('checked', false);
    $('.checked').removeClass('checked');
    $(".menu").hide();
}); /* 
    * To change this license header, choose License Headers in Project Properties.
    * To change this template file, choose Tools | Templates
    * and open the template in the editor.
    */

/*
 * Hiển thị menu chuột phải
 */
$("tr.custom_right_menu_item").on({
    contextmenu: function contextmenu(e) {
        e.preventDefault();
        /*
         * Lấy các thuộc tính của contact
         */
        var item_id = $(this).attr('item_id');
        $(".delete_item, .edit_item").attr('item_id', item_id);
        var menu = $(".menu-item");
        menu.hide();
        var pageX = e.pageX;
        var pageY = e.pageY;
        menu.css({ top: pageY, left: pageX });
        var mwidth = menu.width();
        var mheight = menu.height();
        var screenWidth = $(window).width();
        var screenHeight = $(window).height();
        var scrTop = $(window).scrollTop();
        /*
         * Nếu "tọa độ trái chuột" + "chiều dài menu" > "chiều dài trình duyệt" 
         * thì hiển thị sang bên phải tọa độ click
         */
        if (pageX + mwidth > screenWidth) {
            menu.css({ left: pageX - mwidth });
        }
        /*
         * Nếu "tọa độ top chuột" + "chiều cao menu" > "chiều cao trình duyệt" + "chiều dài cuộn chuột"
         * thì hiển thị lên trên tọa độ click
         */
        if (pageY + mheight > screenHeight + scrTop) {
            menu.css({ top: pageY - mheight });
        }
        menu.show();
        /*
         * Nếu dòng đó đang không chọn (đã click trái) thì bỏ chọn và bỏ check những dòng đã chọn
         */
        var is_checked_input = $(this).find('input[type="checkbox"]');
        if (!is_checked_input[0].checked) {
            $(".checked").removeClass("checked");
            uncheck_checked();
        } else {
            unselect_not_checked();
        }
        $(this).addClass('checked'); /*.find('[name="contact_id[]"]').prop('checked', true); */
    },
    click: function click() {
        if ($(this).hasClass('checked')) {
            $(this).removeClass('checked');
        } else {
            $(this).addClass('checked');
        }
        var input_checkbox = $(this).find('[name="item_id[]"]');
        if (input_checkbox.is(":checked")) {
            input_checkbox.prop('checked', false);
        } else {
            input_checkbox.prop('checked', true);
        }
        unselect_not_checked();
        show_number_selected_row();
    }
});

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * Khi check vào 1 item nào đó sẽ đánh dấu item đó (hiện màu xanh)
 */
$(document).on('change', 'input[type="checkbox"]', function () {
    if (this.checked) {
        $(this).parent().parent().addClass('checked');
    } else {
        $(this).parent().parent().removeClass('checked');
    }
    /*
     * Hiển thị số lượng dòng đã check
     */
    var numberOfChecked = $('input:checkbox:checked').length;
    var totalCheckboxes = $('input:checkbox').length;
    $.notify('Đã chọn: ' + numberOfChecked + '/' + totalCheckboxes, {
        position: "top left",
        className: 'success',
        showDuration: 200,
        autoHideDelay: 1000
    });
});

/*=============================chọn tất cả  ===========================================*/
var checked = true;
$(".check_all").on('click', function () {
    checked = !checked;
    if (checked) {
        $(".list_contact input[type='checkbox']").each(function () {
            $(this).prop("checked", false);
            $(this).parent().parent().removeClass('checked');
        });
    } else {
        $(".list_contact input[type='checkbox']").each(function () {
            $(this).prop("checked", true);
            $(this).parent().parent().addClass('checked');
        });
        var numberOfChecked = $('input:checkbox:checked').length;
        /*
         * Lấy tổng giá
         */
        var sum = 0;
        for (i = 0; i < numberOfChecked; i++) {
            sum += parseInt($($('input:checkbox:checked')[i]).parent().parent().find('.tbl_price_purchase').text());
        }
        $.notify('Đã chọn: ' + numberOfChecked + '/' + numberOfChecked + ' . Tổng tiền = ' + sum.toLocaleString(), {
            position: "top left",
            className: 'success',
            showDuration: 200,
            autoHideDelay: 10000
        });
    }
});
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * Hiển thị tên khóa học khi click vào mã khóa học
 */
$(document).on('click', '.find-course-code', function () {
    var _this = $(this);
    $.ajax({
        url: $("#base_url").val() + "common/find_course_name",
        type: 'POST',
        data: { course_code: $(this).text().trim() },
        success: function success(data) {
            if (_this.parent().attr('class') === 'view_course_code') {
                _this.notify(data, {
                    position: "top left",
                    className: 'success',
                    showDuration: 200,
                    autoHideDelay: 4000
                });
            } else {
                _this.notify(data, {
                    position: "top center",
                    className: 'success',
                    showDuration: 200,
                    autoHideDelay: 4000
                });
            }
        }
    });
});

$(".datepicker").datepicker({
    dateFormat: "dd-mm-yy"
});

/*
 * 
 * Tham khảo http://www.daterangepicker.com/#usage
 */
var d = new Date();
var currDate = d.getDate() + '-' + (d.getMonth() + 1) + '-' + d.getFullYear();
var pastDate = d.getDate() + '-' + d.getMonth() + '-' + d.getFullYear();
$(".daterangepicker").daterangepicker({
    "autoApply": true,
    autoUpdateInput: false,
    locale: {
        format: 'DD/MM/YYYY',
        cancelLabel: 'Clear'
    },
    ranges: {
        'Hôm nay': [moment(), moment()],
        'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        '7 ngày vừa qua': [moment().subtract(6, 'days'), moment()],
        '30 ngày vừa qua': [moment().subtract(29, 'days'), moment()],
        'Tuần này': [moment().startOf('isoWeek'), moment().endOf('isoWeek')],
        'Tuần trước': [moment().subtract(1, 'weeks').startOf('isoWeek'), moment().subtract(1, 'weeks').endOf('isoWeek')],
        'Tháng này': [moment().startOf('month'), moment().endOf('month')],
        'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    "alwaysShowCalendars": true,
    "startDate": pastDate,
    "endDate": currDate
}).on({
    'apply.daterangepicker': function applyDaterangepicker(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    },
    'cancel.daterangepicker': function cancelDaterangepicker(ev, picker) {
        $(this).val('');
    }
});

/*======================= reset datepicker ========================================================*/
$(".reset_datepicker").click(function (e) {
    e.preventDefault();
    $("#datepicker").val("");
});$(function () {
    var clipboard = new Clipboard('.btn-copy');
    clipboard.on('success', function () {
        $.notify("Copy thành công vào clipboard", {
            position: "top left",
            className: 'success',
            showDuration: 200,
            autoHideDelay: 2000
        });
    });
});Dropzone.options.dropzoneFileUpload = {
    dictDefaultMessage: "Thả file vào đây hoặc click vào đây để upload",
    acceptedFiles: ".xls, .xlsx",
    maxFilesize: 10,
    init: function init() {
        this.on("addedfile", function () {
            $(".popup-wrapper").show();
        }).on("success", function () {
            //console.log(e);
            location.href = $("#redirect-dropzone").val();
        }).on("error", function () {
            $(".popup-wrapper").hide();
        });
    }
};$(document).ready(function () {
    $("input.filter_contact").click(function (e) {
        e.preventDefault();
        $("#action_contact").attr("action", "#").attr("method", "GET");
        $("#action_contact").submit();
    });
    $("input.reset_form").click(function (e) {
        e.preventDefault();
        $('option[value=0]').attr('selected', 'selected');
        $('option[value="empty"]').attr('selected', 'selected');
        $(".datepicker").val('');
        $("input[type='text']").val('');
        // $("#action_contact option:selected").prop("selected", false);
        $('.selectpicker').selectpicker('deselectAll');
    });
    $('select.filter').on('change', function (e) {
        e.preventDefault();
        $("#action_contact").attr("action", "#").attr("method", "GET");
        $("#action_contact").submit();
    });

    /*========================= SORT =================================*/
    $('th[class^="order_"]').click(function () {
        var myclass = $(this).attr("class");
        myclass = myclass.split(/ /);
        myclass = myclass[0];
        $('input[class^="order_"]').not("input." + myclass).attr('value', '0');
        if ($("input." + myclass).val() === '0') {
            $("input." + myclass).attr('value', 'ASC').promise().done(function () {
                $("#action_contact").attr("action", "#").attr("method", "GET");
                $("#action_contact").submit();
            });
            return;
        }
        if ($("input." + myclass).val() === 'ASC') {
            $("input." + myclass).val('DESC').promise().done(function () {
                $("#action_contact").attr("action", "#").attr("method", "GET");
                $("#action_contact").submit();
            });
            return;
        }
        if ($("input." + myclass).val() === 'DESC') {
            $("input." + myclass).val('0').promise().done(function () {
                $("#action_contact").attr("action", "#").attr("method", "GET");
                $("#action_contact").submit();
            });
            return;
        }
    });
});
/* $(function () {
//    $(".real-search").on(
//            {'input': function () {
//                    var type = $(this).attr('type_search');
//                    $.ajax({
//                        url: $("#base_url").val() + "common/real_search",
//                        type: "POST",
//                        beforeSend: function () {
//                            $(".popup-wrapper").show();
//                        },
//                        data: {
//                            type: type,
//                            value: $(this).val()
//                        },
//                        success: function (data) {
//                            //console.log(data);
//                            $(".remove_content").html("");
//                            $(".real-search-replacement").html(data);
//                        }, complete: function () {
//                            $(".popup-wrapper").hide();
//                            $('.modal').on('shown.bs.modal', function () {
//                                $('.selectpicker').selectpicker({});
//                            });
//                        }
//                    });
//                }
//            }
//    );
//});

*/$(function () {

    /*
     * Sửa lại link phân trang nếu có các thao tác lọc, tìm kiếm, sắp xếp
     */
    //    if (location.search !== "") {
    //        $(".pagination a").each(
    //                function () {
    //                    var curr_href = $(this).attr("href");
    //                    $(this).attr('href', curr_href + location.search);
    //                });
    //    }

    /*
     * Hiển thị datepicker và selectpicker khi modal edit item đc bật lên
     */
    $('.modal').on('shown.bs.modal', function () {
        $('.selectpicker').selectpicker({});
        $(".datepicker").datepicker({ dateFormat: "dd-mm-yy" });
        $(".reset_datepicker").click(function (e) {
            e.preventDefault();
            $(".datepicker").val("");
            $(".datetimepicker").val('');
        });
        if ($(".table-1").height() > $(".table-2").height()) {
            $(".table-2").height($(".table-1").height());
        } else {
            $(".table-1").height($(".table-2").height());
        }
    });

    /*===================================== trờ về trang trước ========================================*/
    //    $("input[name='back_location']").val(document.referrer);
    //    $(".back_location").click(function () {
    //        location.href = document.referrer;
    //    });


    /*
     * Thêm hiệu ứng khi hover vào dropdown bootstrap 
     */
    $('.dropdown-hover').hover(function () {
        $(this).find('.dropdown-menu').stop(true, true).fadeIn(200);
        $(this).find('.child_menu').stop(true, true).fadeIn(200);
    }, function () {
        $(this).find('.dropdown-menu').stop(true, true).fadeOut(200);
        $(this).find('.child_menu').stop(true, true).fadeOut(200);
    });

    /*
     * Sửa lại value của thẻ input curr_url
     */
    $("#curr_url").val(location.href);

    //    var hide = 1;
    //    $(document).on('mousemove', function (e) {
    //
    //        if (e.pageX < 0.5) {
    //            $("body").removeClass("nav-sm");
    //            $("body").addClass("nav-md");
    //            hide = 0;
    //        }
    //
    //        if (e.pageX > 500 && hide == 0) {
    //            $("body").removeClass("nav-md");
    //            $("body").addClass("nav-sm");
    //            hide = 1;
    //        }
    //    });
});
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(".send_to_mobile").on('click', function (e) {
    e.preventDefault();
    var contact_phone = $(this).attr("contact_phone");
    var contact_name = $(this).attr("contact_name");
    $.ajax({
        url: $("#base_url").val() + 'common/send_phone_to_mobile',
        type: 'post',
        data: {
            contact_phone: contact_phone,
            contact_name: contact_name
        },
        success: function success() {
            $.notify('Gửi thành công đến mobile!', {
                position: "top left",
                className: 'success',
                showDuration: 200,
                autoHideDelay: 3000
            });
        }
    });
});
/*
 * Copyright (C) 2017 Phạm Ngọc Chuyển <chuyenpn at lakita.vn>
 *
 */
var notify = '';
Notification.requestPermission(function (p) {});
setInterval(function () {
    $.ajax({
        url: $("#base_url").val() + "common/listen",
        success: function success(data2) {
            //console.log(data2);
            if (data2 === '1') {
                $("#notificate")[0].play();
                notify = new Notification('Có một contact mới đăng ký', {
                    body: 'Click vào đây để xem ngay!',
                    icon: $("#base_url").val() + 'public/images/logo2.png',
                    tag: 'http://crm2.lakita.vn/quan-ly/trang-chu.html',
                    sound: $("#base_url").val() + 'public/mp3/new-contact.mp3',
                    image: $("#base_url").val() + 'public/images/contact-us.jpg'
                });
                notify.onclick = function (event) {
                    event.preventDefault();
                    window.open('http://crm2.lakita.vn/quan-ly/trang-chu.html', '_blank');
                };
                if ($("#input_controller").val() === 'manager' && $("#input_method").val() === 'index' || $("#input_controller").val() === 'marketing' && $("#input_method").val() === 'index') {
                    setTimeout(function () {
                        location.reload();
                    }, 4000);
                }
            }
        }
    });
}, 3000); /* 
          * To change this license header, choose License Headers in Project Properties.
          * To change this template file, choose Tools | Templates
          * and open the template in the editor.
          */
/*
 $(document).on({
 mousemove: function () {
 if ($('div.mega-dropdown-menu').is(":visible")) {
 $(".black-over").css('bottom', '0%');
 console.log(1);
 } else {
 $(".black-over").css('bottom', '100%');
 }
 },
 click: function () {
 if ($('div.mega-dropdown-menu').is(":visible")) {
 $(".black-over").css('bottom', '0%');
 console.log(1);
 } else {
 $(".black-over").css('bottom', '100%');
 }
 }
 }, 'body');
 */

$('li.mega-dropdown').mouseover(function () {
    return $(".black-over").css('bottom', '0%');
}).mouseout(function () {
    return $(".black-over").css('bottom', '100%');
});

/*
 setInterval(function(){
 if ($('div.mega-dropdown-menu').is(":visible")) {
 $(".black-over").css('bottom', '0%');
 } else {
 $(".black-over").css('bottom', '100%');
 }
 },100);
 */ /* 
    * To change this license header, choose License Headers in Project Properties.
    * To change this template file, choose Tools | Templates
    * and open the template in the editor.
    */

$('.modal').on('hide.bs.modal', function () {
    if ($(this).find(".modal-dialog").attr('class').search('btn-very-lg') != -1) {
        $(this).find(".modal-dialog").attr('class', 'modal-dialog fadeOut animated btn-very-lg');
    } else if ($(this).find(".modal-dialog").attr('class').search('btn-lg') != -1) {
        $(this).find(".modal-dialog").attr('class', 'modal-dialog fadeOut animated btn-lg');
    } else {
        $(this).find(".modal-dialog").attr('class', 'modal-dialog fadeOut animated');
    }
});
$('.modal').on('show.bs.modal', function () {
    if ($(this).find(".modal-dialog").attr('class').search('btn-very-lg') != -1) {
        $(this).find(".modal-dialog").attr('class', 'modal-dialog fadeIn animated btn-very-lg');
    } else if ($(this).find(".modal-dialog").attr('class').search('btn-lg') != -1) {
        $(this).find(".modal-dialog").attr('class', 'modal-dialog fadeIn animated btn-lg');
    } else {
        $(this).find(".modal-dialog").attr('class', 'modal-dialog fadeIn animated');
    }
});
$("a.cancel_one_contact").on('click', function (e) {
    var del = $(this);
    var sale_id = $(this).attr("sale_id");
    var total_contact_for_sale = $(".total_contact_sale_" + sale_id).text();
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: $("#base_url").val() + "manager/cancel_one_contact",
        data: {
            contact_id: $(this).attr("contact_id")
        },
        beforeSend: function beforeSend() {
            //$(".popup-wrapper").show();
        },
        success: function success(data) {
            if (data === '1') {
                del.parent().parent().hide();
                $(".total_contact_sale_" + sale_id).text(total_contact_for_sale - 1);
            } else {
                alert(data);
            }
        },
        error: function error(errorThrown) {
            alert(errorThrown);
        },
        complete: function complete() {
            //    $(".popup-wrapper").hide();
        }
    });
});
$(".cancel_multi_contact").on('click', function (e) {
    $("#action_contact").attr("action", $("#base_url").val() + "manager/cancel_multi_contact");
    $("#action_contact").submit();
});$("#delete_contact").on('click', function (e) {
    e.preventDefault();
    var r = confirm("Are you sure?");
    if (r === true) {
        $("#action_contact").attr("action", $("#base_url").val() + "manager/delete_contact");
        $("#action_contact").submit();
    }
});

$(document).on('click', 'a.delete_one_contact', function (e) {
    var del = $(this);
    var contact_id = $(this).attr("contact_id");
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: $("#base_url").val() + "manager/delete_one_contact",
        data: {
            contact_id: contact_id
        },
        success: function success(data) {
            if (data === '1') {
                //del.parent().parent().hide();
                $(".duplicate_" + contact_id).hide();
                //location.reload();
            } else {
                alert(data);
            }
        },
        error: function error() {
            alert(errorThrown);
        }
    });
});

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
        success: function success(data) {
            if (data.success == 1) {
                $("#send_email_sound")[0].play();
                $.notify(data.message, {
                    position: "top left",
                    className: 'success',
                    showDuration: 200,
                    autoHideDelay: 5000
                });
                $(".divide_one_contact_modal").modal("hide");
                $('tr[contact_id="' + contact_id + '"]').remove();
            } else {
                $("#send_email_error")[0].play();
                $.notify('Có lỗi xảy ra! Nội dung: ' + data.message, {
                    position: "top left",
                    className: 'error',
                    showDuration: 200,
                    autoHideDelay: 7000
                });
            }
        }
    });
});

$(document).on('click', '.btn-divide-multi-contact', function (e) {
    e.preventDefault();
    var url = $('#base_url').val() + "manager/divide_contact";
    /*
     * Lấy các contact chăm sóc để ẩn đi
     */
    var contactIdArray = [];
    $('input[type="checkbox"]').each(function () {
        if ($(this).is(":checked")) {
            contactIdArray.push($(this).val());
        }
    });
    $.ajax({
        url: url,
        type: "POST",
        dataType: 'json',
        data: $('#action_contact').serialize(),
        success: function success(data) {
            if (data.success == 1) {
                $("#send_email_sound")[0].play();
                $.notify(data.message, {
                    position: "top left",
                    className: 'success',
                    showDuration: 200,
                    autoHideDelay: 5000
                });
                $(".divide_multi_contact_modal").modal("hide");
                $.each(contactIdArray, function () {
                    $('tr[contact_id="' + this + '"]').remove();
                });
            } else {
                $("#send_email_error")[0].play();
                $.notify('Có lỗi xảy ra! Nội dung: ' + data.message, {
                    position: "top left",
                    className: 'error',
                    showDuration: 200,
                    autoHideDelay: 7000
                });
            }
        }
    });
}); /*
    $("a.view_duplicate").on('click', function (e) {
     e.preventDefault();
    // alert(1);
     var duplicate_id = $(this).attr("duplicate_id");
    // console.log(url);
     $.ajax({
         url: $("#base_url").val() + "manager/view_duplicate",
         type: "POST",
         data: {
             duplicate_id: duplicate_id
         },
         success: function (data) {
             // console.log(data);
             $("div.view_duplicate").html("").html(data);
         },
         complete: function () {
             $(".view_duplicate_modal").modal("show");
         }
     });
    });
    */$(document).on('scroll', function () {
    if ($(".table-head-pos").length) {
        if ($("body").scrollTop() > $(".table-head-pos").offset().top) {
            $(".fixed-table").css({
                "display": "block"
            });
        } else {
            $(".fixed-table").css({
                "display": "none"
            });
        }
        $('[class^="staff_"]').each(function () {
            var myClass = $(this).attr("class");
            var mywidth = $(this).width();
            var myheight = $(this).height();
            $(".f_" + myClass).width(mywidth);
            $(".f_" + myClass).height(myheight);
        });
        var offsetLeft = $(".table-head-pos").offset().left + 2;
        $("table thead.fixed-table").css("left", offsetLeft + "px");
    }
});

$("input.reset_form").on('click', function (e) {
    e.preventDefault();
    $('option[value=0]').attr('selected', 'selected');
    $('option[value="empty"]').attr('selected', 'selected');
    $(".datepicker").val('');
    $("input[type='text']").val('');
    // $("#action_contact option:selected").prop("selected", false);
    $('.selectpicker').selectpicker('deselectAll');
});

$(document).on('click', '.btn-edit-contact', function (e) {
    if ($("#input_controller").val() === 'sale') {
        //        e.preventDefault();
        //        var error = false;
        //        var call_status_id = $("select[name='call_status_id']").val();
        //       // console.log('call_status_id= ' + call_status_id);
        //        var ordering_status_id = $("select[name='ordering_status_id']").val();
        //       // console.log('ordering_status_id= ' + ordering_status_id);
        //        var date_recall = $(".date_recall").val();
        //        var course_code = $('select.select_course_code').val();
        //        var price_purchase = $('[name="price_purchase"]').val();
        //        if ($("select.edit_payment_method_rgt").val() == 0) {
        //            alert("Bạn cần cập nhật hình thức thanh toán!");
        //            error = true;
        //            return false;
        //        }
        //        if (call_status_id == 0) {
        //            alert("Bạn cần cập nhật trạng thái gọi!");
        //            error = true;
        //            return false;
        //        }
        //        if (check_rule_call_stt(call_status_id, ordering_status_id) == false) {
        //            alert("Trạng thái gọi và trạng thái đơn hàng không logic!");
        //            error = true;
        //            return false;
        //        }
        //        if (date_recall != '') {
        //            if (now_greater_than_input_date(date_recall)) {
        //                alert("Ngày gọi lại không thể là một ngày trước ngày hôm nay!");
        //                error = true;
        //                return false;
        //            }
        //            if (check_rule_call_stt_and_date_recall(call_status_id, ordering_status_id, date_recall)) {
        //                alert("Nếu contact không liên lạc được hoặc không thể chăm sóc được nữa thì không thể có ngày gọi lại lớn hơn ngày hiện tại!");
        //                error = true;
        //                return false;
        //            }
        //        }
        //        if (course_code == '0') {
        //            alert("Vui lòng chọn mã khóa học!");
        //            error = true;
        //            return false;
        //        }
        //        if (price_purchase == '') {
        //            alert("Vui lòng chọn giá tiền mua!");
        //            error = true;
        //            return false;
        //        }
        //        if (!error) {
        //            $(".form_submit").submit();
        //        }
    }
});

$(document).on('change', 'select.select_script', function () {
    //console.log($(this));
    var url = $("#base_url").val() + "sale/show_script_modal";
    if ($(this).val() != 0) {
        $.ajax({
            url: url,
            type: "POST",
            data: {
                script_id: $(this).val()
            },
            success: function success(data) {
                return $("div.replace_content_script").html(data);
            },
            complete: function complete() {
                return $(".script_modal").modal("show");
            }
        });
    }
});
$(document).on('click', 'a.transfer_contact, a.transfer_one_contact', function (e) {
    e.preventDefault();
    var action = $(this).attr("class").split(" ");
    if (action[0] == "transfer_contact") {
        $("#action_contact").removeClass("form-inline");
        $(".transfer_multi_contact_modal").modal("show");
    } else {
        $(".checked").removeClass("checked");
        $(this).parent().parent().addClass("checked");
        var contact_id = $(this).attr("contact_id");
        var contact_name = $(this).attr("contact_name");
        $("#contact_id_input").val(contact_id);
        $(".contact_name_replacement").text(contact_name);
        $(".transfer_one_contact_modal").modal("show");
    }
});
$(document).on('change', '[name="add_channel_id"], [name="edit_channel_id"]', function () {
    var channel_id = $(this).val();
    $.ajax({
        url: $('#base_url').val() + 'MANAGERS/link/get_campaign',
        type: "POST",
        data: {
            channel_id: channel_id
        },
        success: function success(data) {
            $(".ajax_campaign").html(data);
            $(".ajax_adset").html('');
            $(".ajax_ad").html('');
        },
        complete: function complete() {
            $('.selectpicker').selectpicker({});
        }
    });
});
$(document).on('change', '[name="add_campaign_id"]', function () {
    var campagin_id = $(this).val();
    $.ajax({
        url: $('#base_url').val() + 'MANAGERS/link/get_adset',
        type: "POST",
        data: {
            campagin_id: campagin_id
        },
        success: function success(data) {
            $(".ajax_adset").html(data);
            $(".ajax_ad").html('');
        },
        complete: function complete() {
            $('.selectpicker').selectpicker({});
        }
    });
});

$(document).on('change', '[name="add_adset_id"]', function () {
    var adset_id = $(this).val();
    $.ajax({
        url: $('#base_url').val() + 'MANAGERS/link/get_ad',
        type: "POST",
        data: {
            adset_id: adset_id
        },
        success: function success(data) {
            $(".ajax_ad").html(data);
        },
        complete: function complete() {
            $('.selectpicker').selectpicker({});
        }
    });
});

//# sourceMappingURL=built.js.map
//# sourceMappingURL=built2.js.map
