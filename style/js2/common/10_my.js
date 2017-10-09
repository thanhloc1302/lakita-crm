$(function () {

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
        $(".datepicker").datepicker({dateFormat: "dd-mm-yy"});
        $(".reset_datepicker").click(function (e) {
            e.preventDefault();
            $(".datepicker").val("");
            $(".datetimepicker").val('');
        });
        if ($(".table-1").height() > $(".table-2").height())
        {
            $(".table-2").height($(".table-1").height());
        } else
        {
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
