$(function () {
    $(".datepicker").datepicker(
            {
                dateFormat: "dd-mm-yy"
            }
    );

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
        'apply.daterangepicker': function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        },
        'cancel.daterangepicker': function (ev, picker) {
            $(this).val('');
        }
    });

    /*
     * Sửa lại link phân trang nếu có các thao tác lọc, tìm kiếm, sắp xếp
     */
    if (location.search !== "") {
        $(".pagination a").each(
                function () {
                    var curr_href = $(this).attr("href");
                    $(this).attr('href', curr_href + location.search);
                });
    }

    /*
     * Hiển thị datepicker và selectpicker khi modal edit item đc bật lên
     */
    $('.modal').on('shown.bs.modal', function () {
        $('.selectpicker').selectpicker({});
        $(".datepicker").datepicker({dateFormat: "dd-mm-yy"});
        $(".reset_datepicker").click(function (e) {
            e.preventDefault();
            $(".datepicker").val("");
        });
    });

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
        $(this).notify('Đã chọn: ' + numberOfChecked + '/' + totalCheckboxes, {
            position: "right middle",
            className: 'success',
            showDuration: 200,
            autoHideDelay: 1000
        });
    });
    /*===================================== trờ về trang trước ========================================*/
//    $("input[name='back_location']").val(document.referrer);
//    $(".back_location").click(function () {
//        location.href = document.referrer;
//    });


    /*======================= reset datepicker ========================================================*/
    $(".reset_datepicker").click(function (e) {
        e.preventDefault();
        $("#datepicker").val("");
    });

    /*
     * Chỉnh lại giao diện gốc
     */
    if ($("li.current-page").parent().hasClass("child_menu")) {
        $("li.current-page").parent().css("display", 'none');
    }
    if ($("li.active").parent().hasClass("side-menu")) {
        $(this).removeClass("active");
    }

    /*=============================chọn tất cả  ===========================================*/
    var checked = true;
    $(".check_all").css("cursor", "pointer").click(function () {
        checked = !checked;
        if (checked) {
            $(".list_contact input[type='checkbox']").each(
                    function () {
                        $(this).prop("checked", false);
                        $(this).parent().parent().removeClass('checked');
                    }
            );
        } else {
            $(".list_contact input[type='checkbox']").each(
                    function () {
                        $(this).prop("checked", true);
                        $(this).parent().parent().addClass('checked');
                    }
            );
        }
    });

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
     * Hiển thị tên khóa học khi click vào mã khóa học
     */
    $(document).on('click', '.find-course-code', function () {
        var _this = $(this);
        $.ajax({
            url: $("#base_url").val() + "common/find_course_name",
            type: 'POST',
            data: {course_code: $(this).text().trim()},
            success: function (data, textStatus, jqXHR) {
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

    /*
     * Sửa lại value của thẻ input curr_url
     */
    $("#curr_url").val(location.href);

    /*
     * Hiển thị menu chuột phải
     */
    $("tr.custom_right_menu").on(
            {
                contextmenu: function (e) {
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
                    menu.css({top: pageY, left: pageX});
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
                        menu.css({left: pageX - mwidth});
                    }
                    /*
                     * Nếu "tọa độ top chuột" + "chiều cao menu" > "chiều cao trình duyệt" + "chiều dài cuộn chuột"
                     * thì hiển thị lên trên tọa độ click
                     */
                    if (pageY + mheight > screenHeight + scrTop) {
                        menu.css({top: pageY - mheight});
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
                click: function () {

                },
                dblclick: function (e) {
                    var contact_id = $(this).attr('contact_id');
                    $(".edit_contact").attr('contact_id', contact_id);
                    e.preventDefault();
                    $("a.edit_contact").click();
                }
            });

    /*
     * High light vào các dòng khi click trái để chọn 
     */
    $("td.tbl_name, td.tbl_address").on("click", function () {
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
        /*
         * Nếu click ra ngoài bảng thì bỏ chọn các contact
         */
        if (e.target.className.indexOf("form-inline") !== -1 || e.target.className.indexOf("number_paging") !== -1)
        {
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
    });

});


function show_number_selected_row() {
    var numberOfChecked = $('input:checkbox:checked').length;
    var totalCheckboxes = $('input:checkbox').length;
    $.notify('Đã chọn: ' + numberOfChecked + '/' + totalCheckboxes, {
        position: "left middle",
        className: 'success',
        showDuration: 200,
        autoHideDelay: 1000
    });
}

function unselect_not_checked() {
    $('input[type="checkbox"]').each(
            function () {
                if (!$(this).is(":checked")) {
                    $(this).parent().parent().removeClass('checked');
                }
            });
}

function unselect_checked() {
    $('input[type="checkbox"]').each(
            function () {
                if ($(this).is(":checked")) {
                    $(this).parent().parent().removeClass('checked');
                }
            });
}
function uncheck_checked() {
    $('input[type="checkbox"]').each(
            function () {
                if ($(this).is(":checked")) {
                    $(this).prop("checked", false);
                }
            });
}
function uncheck_not_checked() {
    $('input[type="checkbox"]').each(
            function () {
                if (!$(this).is(":checked")) {
                    $(this).prop("checked", false);
                }
            });
}

function right_context_menu_display(controller, contact_id, contact_name, duplicate_id, contact_phone) {
    $(".action_view_detail_contact").attr('contact_id', contact_id);
    $("a.view_duplicate").attr("duplicate_id", duplicate_id);
    $("a.send_to_mobile").attr("contact_name", contact_name).attr("contact_phone", contact_phone);
    /*
     * Nếu chọn nhiều contact thì ẩn menu xem chi tiết contact 
     * và phân 1 contact
     */
    var numberOfChecked = $('input:checkbox:checked').length;
    if (numberOfChecked > 1) {
        $("a.view_duplicate, .action_view_detail_contact, .divide_one_contact_achor, "
                + ".edit_contact, .transfer_one_contact, .send_to_mobile").addClass("hidden");
        $(".divide_multi_contact,.transfer_contact, "
                + ".select_provider, .btn-export-excel, .btn-export-excel-for-viettel, .export_to_string").removeClass('hidden');
    } else {
        $(".action_view_detail_contact, .divide_one_contact_achor, a.view_duplicate, "
                + ".edit_contact, .transfer_one_contact, .send_to_mobile").removeClass("hidden");
        $(".divide_multi_contact, .transfer_contact, "
                + ".select_provider, .btn-export-excel, .btn-export-excel-for-viettel, .export_to_string").addClass('hidden');
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
}


