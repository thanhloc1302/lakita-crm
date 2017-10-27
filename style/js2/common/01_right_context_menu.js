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
    
    if (e.target.className.indexOf("form-inline") !== -1 || e.target.className.indexOf("number_paging") !== -1)
    {
        $("input[type='checkbox']").prop('checked', false);
        $('.checked').removeClass('checked');

    } */

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