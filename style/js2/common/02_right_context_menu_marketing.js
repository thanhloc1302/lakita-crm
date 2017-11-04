/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



/*
 * Hiển thị menu chuột phải
 */
$("tr.custom_right_menu_item").on(
        {
            contextmenu: function (e) {
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
                /* var is_checked_input = $(this).find('input[type="checkbox"]');
                if (!is_checked_input[0].checked) {
                    $(".checked").removeClass("checked");
                    uncheck_checked();
                } else {
                    unselect_not_checked();
                }
                $(this).addClass('checked'); *//*.find('[name="contact_id[]"]').prop('checked', true); */
            }
           /* click: function () {
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
            } */
        });



