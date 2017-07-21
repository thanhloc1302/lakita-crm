$(function () {

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
    });
    /*===================================== trờ về trang trước ========================================*/
    $("input[name='back_location']").val(document.referrer);
    $(".back_location").click(function () {
        location.href = document.referrer;
    });


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
     * Thêm hiệu ứng khi ấn vào dropdown bootstrap
     */
    $('.dropdown-toggle').parent().on('show.bs.dropdown', function () {
        $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
    });

    $('.dropdown-toggle').parent().on('hide.bs.dropdown', function () {
        $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
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
});


