/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

show_number_selected_row = () => {
    var numberOfChecked = $('input.tbl-item-checkbox:checked').length;
    var totalCheckboxes = $('input.tbl-item-checkbox').length;
    /*
     * Lấy tổng giá
     */
    var sum = 0;
    for (i = 0; i < numberOfChecked; i++) {
        sum += parseInt($($('input.tbl-item-checkbox:checked')[i]).parent().parent().find('.tbl_price_purchase').text());
    }
    sum *= 1000;
    $.notify(`Đã chọn: ${numberOfChecked} / ${totalCheckboxes}. tổng tiền = ${sum.toLocaleString()}`, {
        position: "top left",
        className: 'success',
        showDuration: 200,
        autoHideDelay: 3000
    });
};

unselect_not_checked = () => {
    $('input.tbl-item-checkbox').each(
            () => {
        if (!$(this).is(":checked")) {
            $(this).parent().parent().removeClass('checked');
        }
    });
};

unselect_checked = () => {
    $('input.tbl-item-checkbox').each(
            () => {
        if ($(this).is(":checked")) {
            $(this).parent().parent().removeClass('checked');
        }
    });
};
uncheck_checked = () => {
    $('input.tbl-item-checkbox').each(
            () => {
        if ($(this).is(":checked")) {
            $(this).prop("checked", false);
        }
    });
};
uncheck_not_checked = () => {
    $('input.tbl-item-checkbox').each(
            () => {
        if (!$(this).is(":checked")) {
            $(this).prop("checked", false);
        }
    });
};

right_context_menu_display = (controller, contact_id, contact_name, duplicate_id, contact_phone) => {
    $(".load-new-contact-id").attr('data-contact-id', contact_id);
    // $("a.view_duplicate").attr("duplicate_id", duplicate_id);
    $("a.send_to_mobile").attr("contact_name", contact_name).attr("contact_phone", contact_phone);
    /*
     * Nếu chọn nhiều contact thì ẩn menu xem chi tiết contact 
     * và phân 1 contact
     */
    var numberOfChecked = $('input.tbl-item-checkbox:checked').length;
    console.log(numberOfChecked);
    if (numberOfChecked > 1) {
        $("a.view_duplicate, .action_view_detail_contact, .divide_one_contact_achor, "
                + ".edit-one-contact, .transfer_one_contact, .send_to_mobile").addClass("hidden");
        $(".divide_multi_contact,.transfer_contact, "
                + ".select_provider, .btn-export-excel, .btn-export-excel-for-viettel, "+
                    + ".export_to_string, .send-banking-info-multi-course").removeClass('hidden');
    } else {
        $(".action_view_detail_contact, .divide_one_contact_achor, a.view_duplicate, "
                + ".edit-one-contact, .transfer_one_contact, .send_to_mobile").removeClass("hidden");
        $(".divide_multi_contact, .transfer_contact, "
                + ".select_provider, .export_to_string, .send-banking-info-multi-course").addClass('hidden');
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
        $(".transfer_one_contact").attr('contact_id', contact_id);
        $(".transfer_one_contact").attr('contact_name', contact_name);
    }
};

