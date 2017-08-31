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
    $(this).notify('Đã chọn: ' + numberOfChecked + '/' + totalCheckboxes, {
        position: "right middle",
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