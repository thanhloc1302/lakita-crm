$(document).ready(function () {
    $(document).on('click', 'a.delete_one_contact_admin', function (e) {
        var del = $(this);
        var contact_id = $(this).attr("contact_id");
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $("#base_url").val() + "admin/delete_one_contact",
            data: {
                contact_id: contact_id
            },
            success: function (data) {
                if (data === '1')
                {
                    del.parent().parent().hide();
                    //location.reload();
                } else {
                    alert(data);
                }
            },
            error: function () {
                alert(errorThrown);
            }
        });
    });
});$(document).ready(function(){$(document).on("click","a.delete_one_contact_admin",function(t){var e=$(this),n=$(this).attr("contact_id");t.preventDefault(),$.ajax({type:"POST",url:$("#base_url").val()+"admin/delete_one_contact",data:{contact_id:n},success:function(t){"1"===t?e.parent().parent().hide():alert(t)},error:function(){alert(errorThrown)}})})});/* 
 * Copyright (C) 2017 Phạm Ngọc Chuyển <chuyenpn at lakita.vn>
 *
 */

$(document).ready(function () {
    $(document).on('click', 'a.retrieve_contact', function (e) {
        var del = $(this);
        var contact_id = $(this).attr("contact_id");
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $("#base_url").val() + "admin/retrieve_contact",
            data: {
                contact_id: contact_id
            },
            success: function (data) {
                if (data === '1')
                {
                    alert('Thu hồi thành công contact');
                    //del.parent().parent().hide();
                    location.reload();
                } else {
                    alert(data);
                }
            },
            error: function () {
                alert(errorThrown);
            }
        });
    });
});
$(document).ready(function(){$(document).on("click","a.retrieve_contact",function(t){$(this);var a=$(this).attr("contact_id");t.preventDefault(),$.ajax({type:"POST",url:$("#base_url").val()+"admin/retrieve_contact",data:{contact_id:a},success:function(t){"1"===t?(alert("Thu hồi thành công contact"),location.reload()):alert(t)},error:function(){alert(errorThrown)}})})});  $(function () {
    $(document).on('click', 'a.add_item', function (e) {
        e.preventDefault();
        var url = $("#url_add_item").val();
        $.ajax({
            url: url,
            type: "POST",
            success: function (data) {
                $("div.replace_content_add_item_modal").html(data);
            },
            complete: function () {
                $(".add_item_modal").modal("show");
            }
        });
    });
    $('.add_item_modal').on('shown.bs.modal', function () {
        if ($(".table-1").height() > $(".table-2").height())
        {
            $(".table-2").height($(".table-1").height());
        } else
        {
            $(".table-1").height($(".table-2").height());
        }
    });
});

$(function(){$(document).on("click","a.add_item",function(t){t.preventDefault();var e=$("#url_add_item").val();$.ajax({url:e,type:"POST",success:function(t){$("div.replace_content_add_item_modal").html(t)},complete:function(){$(".add_item_modal").modal("show")}})}),$(".add_item_modal").on("shown.bs.modal",function(){$(".table-1").height()>$(".table-2").height()?$(".table-2").height($(".table-1").height()):$(".table-1").height($(".table-2").height())})});$(document).ready(function () {
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
                    success: function (data) {
                        console.log(data);
                        if (data === '1')
                        {
                            del.parent().parent().parent().hide();
                        } else {
                            alert(data);
                        }
                    },
                    error: function (errorThrown) {
                        alert('Không thể xóa do foreign-key, liên hệ admin để biết thêm chi tiết');
                    }
                });
            }
        });
        $("a.delete_multi_item").click(function (e) {
            e.preventDefault();
            var r = confirm("Bạn có chắc chắn muốn xóa các dòng đã chọn không?");
            if (r === true) {
                $("#form_item").attr("action", $("#url_delete_multi_item").val()).attr("method", "POST");
                $("#form_item").submit();
            }
        });
    });$(document).ready(function(){$(document).on("click","a.delete_item",function(t){if(t.preventDefault(),!0===confirm("Bạn có chắc chắn muốn xóa dòng này không?")){var e=$(this),n=$(this).attr("item_id");t.preventDefault(),$.ajax({type:"POST",url:$("#url_delete_item").val(),data:{item_id:n},success:function(t){"1"===t?e.parent().parent().parent().hide():alert(t)},error:function(t){alert("Không thể xóa do foreign-key, liên hệ admin để biết thêm chi tiết")}})}}),$("a.delete_multi_item").click(function(t){t.preventDefault(),!0===confirm("Bạn có chắc chắn muốn xóa các dòng đã chọn không?")&&($("#form_item").attr("action",$("#url_delete_multi_item").val()).attr("method","POST"),$("#form_item").submit())})});  $(function () {
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
            success: function (data) {
                $("div.replace_content_edit_item_modal").html(data);
            },
            complete: function () {
                $(".edit_item_modal").modal("show");
            }
        });
    });
    $('.edit_item_modal').on('shown.bs.modal', function () {
        if ($(".table-1").height() > $(".table-2").height())
        {
            $(".table-2").height($(".table-1").height());
        } else
        {
            $(".table-1").height($(".table-2").height());
        }
    });
});$(function(){$(document).on("click","a.edit_item",function(t){t.preventDefault();var e=$(this).attr("item_id"),i=$("#url_edit_item").val();$.ajax({url:i,type:"POST",data:{item_id:e},success:function(t){$("div.replace_content_edit_item_modal").html(t)},complete:function(){$(".edit_item_modal").modal("show")}})}),$(".edit_item_modal").on("shown.bs.modal",function(){$(".table-1").height()>$(".table-2").height()?$(".table-2").height($(".table-1").height()):$(".table-1").height($(".table-2").height())})});$(function () {


    /*
     * Real order
     */
    $('th[class^="order_new_"]').click(function () {
        var myclass = $(this).attr("class");
        myclass = myclass.split(/ /);
        myclass = myclass[0];
        $('input[class^="order_new_"]').not("input." + myclass).attr('value', '0');
        if ($("input." + myclass).val() === '0')
        {
            $("input." + myclass).attr('value', 'ASC').promise().done(
                    function () {
                        $("#form_item").submit();
                    }
            );
            return;
        }
        if ($("input." + myclass).val() === 'ASC')
        {
            $("input." + myclass).val('DESC').promise().done(
                    function () {
                        $("#form_item").submit();
                    }
            );
            return;
        }
        if ($("input." + myclass).val() === 'DESC')
        {
            $("input." + myclass).val('0').promise().done(
                    function () {
                        $("#form_item").submit();
                    }
            );
            return;
        }

    });

    /*
     * Real filter
     */
    $(".real_filter").on('change', function () {
        $("#form_item").submit();
    });
});

/*
 * Cố định thanh <thead> và phần search của table
 */
$(document).on('scroll', function () {
    /*
     * Khi cuộn chuột quá vị trí của phần thead thì thead ẩn đi và phần thead-fixed hiện lên
     */
    if ($(".table-head-pos").length) {
        if ($("body").scrollTop() > ($(".table-head-pos").offset().top)) {
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
        var offsetLeft = $(".table-head-pos").offset().left - 1;
        $(".fixed-table").css("left", offsetLeft + "px");
    }
});$(function(){$('th[class^="order_new_"]').click(function(){var t=$(this).attr("class");t=(t=t.split(/ /))[0],$('input[class^="order_new_"]').not("input."+t).attr("value","0"),"0"!==$("input."+t).val()?"ASC"!==$("input."+t).val()?"DESC"!==$("input."+t).val()||$("input."+t).val("0").promise().done(function(){$("#form_item").submit()}):$("input."+t).val("DESC").promise().done(function(){$("#form_item").submit()}):$("input."+t).attr("value","ASC").promise().done(function(){$("#form_item").submit()})}),$(".real_filter").on("change",function(){$("#form_item").submit()})}),$(document).on("scroll",function(){if($(".table-head-pos").length){$("body").scrollTop()>$(".table-head-pos").offset().top?$(".fixed-table").css({display:"block"}):$(".fixed-table").css({display:"none"}),$('[id^="th_"]').each(function(){var t=$(this).attr("id"),i=$(this).width(),e=$(this).height();$("#f_"+t).width(i),$("#f_"+t).height(e)}),$('[id^="td_"]').each(function(){var t=$(this).attr("id"),i=$(this).width(),e=$(this).height();$("#f_"+t).width(i),$("#f_"+t).height(e)}),$("tbody.fixed-table").css("top",$("thead.fixed-table").height());var t=$(".table-head-pos").offset().left-1;$(".fixed-table").css("left",t+"px")}});$(function () {
    $(".btn-modal_edit-multi-contact").click(function (e) {
        e.preventDefault();
        var error = false;
        var modal_edit_provider_id = $('.edit_multi_cod_contact [name="provider_id"]').val();
        var modal_edit_cod_status_id = $('.edit_multi_cod_contact [name="cod_status_id"]').val();
        console.log(modal_edit_provider_id);
        if (modal_edit_cod_status_id == 0) {
            alert("Bạn cần chọn trạng thái giao COD!");
            error = true;
            return false;
        }
        if (modal_edit_provider_id == 0) {
            alert("Bạn cần chọn đơn vị giao hàng!");
            error = true;
            return false;
        }
        if (!error) {
            $("#action_contact").submit();
        }
    });
});
$(function(){$(".btn-modal_edit-multi-contact").click(function(t){t.preventDefault();var n=!1,c=$('.edit_multi_cod_contact [name="provider_id"]').val();return 0==$('.edit_multi_cod_contact [name="cod_status_id"]').val()?(alert("Bạn cần chọn trạng thái giao COD!"),n=!0,!1):0==c?(alert("Bạn cần chọn đơn vị giao hàng!"),n=!0,!1):void(n||$("#action_contact").submit())})});$(document).ready(function () {
    $(document).on('click', 'a.delete_bill', function (e) {
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
                success: function (data) {
                    console.log(data);
                    if (data === '1')
                    {
                        del.parent().parent().parent().hide();
                        //location.reload();
                    } else {
                        alert(data);
                    }
                },
                error: function (errorThrown) {
                    alert(errorThrown);
                }
            });
        }
    });
});$(document).ready(function(){$(document).on("click","a.delete_bill",function(e){if(1==confirm("Bạn có chắc chắn muốn xóa dòng đối soát này không?")){var n=$(this),t=$(this).attr("bill_id");e.preventDefault(),$.ajax({type:"POST",url:$("#base_url").val()+"CODS/check_L8/delete_bill",data:{bill_id:t},success:function(e){"1"===e?n.parent().parent().parent().hide():alert(e)},error:function(e){alert(e)}})}})});$(function () {
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
            success: function (data) {
                console.log(data);
                $("div.replace_content_edit_bill_modal").html(data);
            },
            complete: function () {
                $(".edit_bill_modal").modal("show");
            }
        });
    });
    $('.edit_bill_modal').on('shown.bs.modal', function () {
        if ($(".table-1").height() > $(".table-2").height())
        {
            $(".table-2").height($(".table-1").height());
        } else
        {
            $(".table-1").height($(".table-2").height());
        }
    });
});$(function(){$(document).on("click","a.edit_bill",function(t){t.preventDefault();var l=$(this).attr("bill_id"),e=$("#base_url").val()+"CODS/check_L8/show_edit_bill";$.ajax({url:e,type:"POST",data:{bill_id:l},success:function(t){$("div.replace_content_edit_bill_modal").html(t)},complete:function(){$(".edit_bill_modal").modal("show")}})}),$(".edit_bill_modal").on("shown.bs.modal",function(){$(".table-1").height()>$(".table-2").height()?$(".table-2").height($(".table-1").height()):$(".table-1").height($(".table-2").height())})});$(document).ready(function () {
    $(".btn-export-excel").click(function (e) {
        e.preventDefault();
        $("#action_contact").attr("action", $("#base_url").val() + "cod/export_for_print");
        $("#action_contact").submit();
    });
    $(".btn-export-excel-for-viettel").click(function (e) {
        e.preventDefault();
        $("#action_contact").attr("action", $("#base_url").val() + "cod/export_for_send_provider");
        $("#action_contact").submit();
    });
});$(document).ready(function(){$(".btn-export-excel").click(function(t){t.preventDefault(),$("#action_contact").attr("action",$("#base_url").val()+"cod/export_for_print"),$("#action_contact").submit()}),$(".btn-export-excel-for-viettel").click(function(t){t.preventDefault(),$("#action_contact").attr("action",$("#base_url").val()+"cod/export_for_send_provider"),$("#action_contact").submit()})});$(function () {
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
            success: function (data) {
                console.log(data);
                $(".replace_content_2").text(data);
            },
            complete: function () {
                $(".export_to_string_modal").modal("show");
            }
        });
    });
});$(function(){$(".export_to_string").on("click",function(t){t.preventDefault();var n=new Array;$("input:checked").each(function(){n.push($(this).val())}),$.ajax({url:$("#base_url").val()+"cod/export_to_string",type:"POST",data:{contact_id:n},success:function(t){$(".replace_content_2").text(t)},complete:function(){$(".export_to_string_modal").modal("show")}})})});$(document).ready(function(){
    $(document).on('click', '.select_provider', function(e){
         $("#action_contact").removeClass("form-inline");
         e.preventDefault();
         $(".edit_multi_cod_contact").modal("show");
    });
});$(document).ready(function(){$(document).on("click",".select_provider",function(o){$("#action_contact").removeClass("form-inline"),o.preventDefault(),$(".edit_multi_cod_contact").modal("show")})});/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(".send_to_mobile").click(function (e) {
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
        success: function () {
            $.notify('Gửi thành công đến mobile!', {
                position: "top left",
                className: 'success',
                showDuration: 200,
                autoHideDelay: 3000
            });
        }
    });
});
$(".send_to_mobile").click(function(t){t.preventDefault();var o=$(this).attr("contact_phone"),n=$(this).attr("contact_name");$.ajax({url:$("#base_url").val()+"common/send_phone_to_mobile",type:"post",data:{contact_phone:o,contact_name:n},success:function(){$.notify("Gửi thành công đến mobile!",{position:"top left",className:"success",showDuration:200,autoHideDelay:3e3})}})});$(function () {
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
                //console.log(data);
                $("div.replace_content").html(data);
            },
            complete: function () {
                $(".edit_contact_modal").modal("show");
            }
        });
    });
    $('.edit_contact_modal').on('shown.bs.modal', function () {
        if ($(".table-1").height() > $(".table-2").height())
        {
            $(".table-2").height($(".table-1").height());
        } else
        {
            $(".table-1").height($(".table-2").height());
        }
        var clipboard = new Clipboard('.btn-copy');
         $('.datetimepicker').datetimepicker(
                {
                    format: 'DD-MM-YYYY HH:mm'
                });
    });
});$(function(){$(document).on("click","a.edit_contact",function(t){t.preventDefault(),$(".checked").removeClass("checked"),$(this).parent().parent().addClass("checked");var e=$(this).attr("contact_id"),a=$("#base_url").val()+"common/show_edit_contact_modal";$.ajax({url:a,type:"POST",data:{contact_id:e},success:function(t){$("div.replace_content").html(t)},complete:function(){$(".edit_contact_modal").modal("show")}})}),$(".edit_contact_modal").on("shown.bs.modal",function(){$(".table-1").height()>$(".table-2").height()?$(".table-2").height($(".table-1").height()):$(".table-1").height($(".table-2").height());new Clipboard(".btn-copy");$(".datetimepicker").datetimepicker({format:"DD-MM-YYYY HH:mm"})})});$(function () {
    setTimeout(function () {
        if ($(".filter-tbl-1").height() > $(".filter-tbl-2").height())
        {
            $(".filter-tbl-2").height($(".filter-tbl-1").height());
        } else
        {
            $(".filter-tbl-1").height($(".filter-tbl-2").height());
        }
    }, 100);
});
$(function(){setTimeout(function(){$(".filter-tbl-1").height()>$(".filter-tbl-2").height()?$(".filter-tbl-2").height($(".filter-tbl-1").height()):$(".filter-tbl-1").height($(".filter-tbl-2").height())},100)});/* 
 * Copyright (C) 2017 Phạm Ngọc Chuyển <chuyenpn at lakita.vn>
 *
 */


$(function () {
    $(document).on('click', 'span.badge-star', function (e) {
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
                controller : controller
            },
            success: function (data) {
                // console.log(data);
                $("div.replace_content_view_contact_star").html(data);
            },
            complete: function () {
                $(".view_contact_star_modal").modal("show");
            }
        });
    });
});
$(function(){$(document).on("click","span.badge-star",function(t){t.preventDefault();var c=$(this).attr("contact_phone"),o=$(this).attr("contact_course_code"),a=$(this).attr("controller"),n=$("#base_url").val()+"common/view_contact_star";$.ajax({url:n,type:"POST",data:{contact_phone:c,contact_course_code:o,controller:a},success:function(t){$("div.replace_content_view_contact_star").html(t)},complete:function(){$(".view_contact_star_modal").modal("show")}})})});$(function () {
    $(document).on('click', 'a.action_view_detail_contact', function (e) {
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
            success: function (data) {
                // console.log(data);
                $("div.replace_content_view_detail_contact").html(data);
            },
            complete: function () {
                $(".view_detail_contact_modal").modal("show");
            }
        });
    });
    $('.view_detail_contact_modal').on('shown.bs.modal', function () {
        if ($(".table-view-1").height() > $(".table-view-2").height())
        {
            $(".table-view-2").height($(".table-view-1").height());
        } else
        {
            $(".table-view-1").height($(".table-view-2").height());
        }
    });
});
$(function(){$(document).on("click","a.action_view_detail_contact",function(t){t.preventDefault(),$(".checked").removeClass("checked"),$(this).parent().parent().addClass("checked");var e=$(this).attr("contact_id"),a=$("#base_url").val()+"common/view_detail_contact";$.ajax({url:a,type:"POST",data:{contact_id:e},success:function(t){$("div.replace_content_view_detail_contact").html(t)},complete:function(){$(".view_detail_contact_modal").modal("show")}})}),$(".view_detail_contact_modal").on("shown.bs.modal",function(){$(".table-view-1").height()>$(".table-view-2").height()?$(".table-view-2").height($(".table-view-1").height()):$(".table-view-1").height($(".table-view-2").height())})});$(function () {
    var clipboard = new Clipboard('.btn-copy');
    clipboard.on('success', function () {
        $.notify("Copy thành công vào clipboard", {
            position: "top left",
            className: 'success',
            showDuration: 200,
            autoHideDelay: 2000
        });
    });
});$(function(){new Clipboard(".btn-copy").on("success",function(){$.notify("Copy thành công vào clipboard",{position:"top left",className:"success",showDuration:200,autoHideDelay:2e3})})});$(function () {
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


function show_number_selected_row(){var e=$("input:checkbox:checked").length,t=$("input:checkbox").length;$.notify("Đã chọn: "+e+"/"+t,{position:"left middle",className:"success",showDuration:200,autoHideDelay:1e3})}function unselect_not_checked(){$('input[type="checkbox"]').each(function(){$(this).is(":checked")||$(this).parent().parent().removeClass("checked")})}function unselect_checked(){$('input[type="checkbox"]').each(function(){$(this).is(":checked")&&$(this).parent().parent().removeClass("checked")})}function uncheck_checked(){$('input[type="checkbox"]').each(function(){$(this).is(":checked")&&$(this).prop("checked",!1)})}function uncheck_not_checked(){$('input[type="checkbox"]').each(function(){$(this).is(":checked")||$(this).prop("checked",!1)})}function right_context_menu_display(e,t,c,n,a){$(".action_view_detail_contact").attr("contact_id",t),$("a.view_duplicate").attr("duplicate_id",n),$("a.send_to_mobile").attr("contact_name",c).attr("contact_phone",a);var o=$("input:checkbox:checked").length;o>1?($("a.view_duplicate, .action_view_detail_contact, .divide_one_contact_achor, .edit_contact, .transfer_one_contact, .send_to_mobile").addClass("hidden"),$(".divide_multi_contact,.transfer_contact, .select_provider, .btn-export-excel, .btn-export-excel-for-viettel, .export_to_string").removeClass("hidden")):($(".action_view_detail_contact, .divide_one_contact_achor, a.view_duplicate, .edit_contact, .transfer_one_contact, .send_to_mobile").removeClass("hidden"),$(".divide_multi_contact, .transfer_contact, .select_provider, .btn-export-excel, .btn-export-excel-for-viettel, .export_to_string").addClass("hidden"),n>0?$("a.view_duplicate").removeClass("hidden"):$("a.view_duplicate").addClass("hidden")),"manager"===e?($(".divide_one_contact_achor").attr("contact_id",t),$(".divide_one_contact_achor").attr("contact_name",c),o<1&&(n>0?$(".divide_one_contact_achor").addClass("hidden"):$(".divide_one_contact_achor").removeClass("hidden"))):"sale"!==e&&"cod"!==e||($(".edit_contact").attr("contact_id",t),$(".transfer_one_contact").attr("contact_id",t),$(".transfer_one_contact").attr("contact_name",c))}$(function(){$(".datepicker").datepicker({dateFormat:"dd-mm-yy"});var e=new Date,t=e.getDate()+"-"+(e.getMonth()+1)+"-"+e.getFullYear(),c=e.getDate()+"-"+e.getMonth()+"-"+e.getFullYear();$(".daterangepicker").daterangepicker({autoApply:!0,autoUpdateInput:!1,locale:{format:"DD/MM/YYYY",cancelLabel:"Clear"},ranges:{"Hôm nay":[moment(),moment()],"Hôm qua":[moment().subtract(1,"days"),moment().subtract(1,"days")],"7 ngày vừa qua":[moment().subtract(6,"days"),moment()],"30 ngày vừa qua":[moment().subtract(29,"days"),moment()],"Tuần này":[moment().startOf("isoWeek"),moment().endOf("isoWeek")],"Tuần trước":[moment().subtract(1,"weeks").startOf("isoWeek"),moment().subtract(1,"weeks").endOf("isoWeek")],"Tháng này":[moment().startOf("month"),moment().endOf("month")],"Tháng trước":[moment().subtract(1,"month").startOf("month"),moment().subtract(1,"month").endOf("month")]},alwaysShowCalendars:!0,startDate:c,endDate:t}).on({"apply.daterangepicker":function(e,t){$(this).val(t.startDate.format("DD/MM/YYYY")+" - "+t.endDate.format("DD/MM/YYYY"))},"cancel.daterangepicker":function(e,t){$(this).val("")}}),""!==location.search&&$(".pagination a").each(function(){var e=$(this).attr("href");$(this).attr("href",e+location.search)}),$(".modal").on("shown.bs.modal",function(){$(".selectpicker").selectpicker({}),$(".datepicker").datepicker({dateFormat:"dd-mm-yy"}),$(".reset_datepicker").click(function(e){e.preventDefault(),$(".datepicker").val("")})}),$(document).on("change",'input[type="checkbox"]',function(){this.checked?$(this).parent().parent().addClass("checked"):$(this).parent().parent().removeClass("checked");var e=$("input:checkbox:checked").length,t=$("input:checkbox").length;$(this).notify("Đã chọn: "+e+"/"+t,{position:"right middle",className:"success",showDuration:200,autoHideDelay:1e3})}),$(".reset_datepicker").click(function(e){e.preventDefault(),$("#datepicker").val("")}),$("li.current-page").parent().hasClass("child_menu")&&$("li.current-page").parent().css("display","none"),$("li.active").parent().hasClass("side-menu")&&$(this).removeClass("active");var n=!0;$(".check_all").css("cursor","pointer").click(function(){(n=!n)?$(".list_contact input[type='checkbox']").each(function(){$(this).prop("checked",!1),$(this).parent().parent().removeClass("checked")}):$(".list_contact input[type='checkbox']").each(function(){$(this).prop("checked",!0),$(this).parent().parent().addClass("checked")})}),$(".dropdown-hover").hover(function(){$(this).find(".dropdown-menu").stop(!0,!0).fadeIn(200),$(this).find(".child_menu").stop(!0,!0).fadeIn(200)},function(){$(this).find(".dropdown-menu").stop(!0,!0).fadeOut(200),$(this).find(".child_menu").stop(!0,!0).fadeOut(200)}),$(document).on("click",".find-course-code",function(){var e=$(this);$.ajax({url:$("#base_url").val()+"common/find_course_name",type:"POST",data:{course_code:$(this).text().trim()},success:function(t,c,n){"view_course_code"===e.parent().attr("class")?e.notify(t,{position:"top left",className:"success",showDuration:200,autoHideDelay:4e3}):e.notify(t,{position:"top center",className:"success",showDuration:200,autoHideDelay:4e3})}})}),$("#curr_url").val(location.href),$("tr.custom_right_menu").on({contextmenu:function(e){e.preventDefault();var t=$(this).attr("contact_id"),c=$(this).attr("contact_name"),n=$(this).attr("duplicate_id"),a=$(this).attr("contact_phone");right_context_menu_display($("#input_controller").val(),t,c,n,a);var o=$(".menu");o.hide();var i=e.pageX,s=e.pageY;o.css({top:s,left:i});var d=o.width(),r=o.height(),h=$(window).width(),l=$(window).height(),u=$(window).scrollTop();i+d>h&&o.css({left:i-d}),s+r>l+u&&o.css({top:s-r}),o.show(),$(this).find('input[type="checkbox"]')[0].checked?unselect_not_checked():($(".checked").removeClass("checked"),uncheck_checked()),$(this).addClass("checked")},click:function(){},dblclick:function(e){var t=$(this).attr("contact_id");$(".edit_contact").attr("contact_id",t),e.preventDefault(),$("a.edit_contact").click()}}),$("td.tbl_name, td.tbl_address").on("click",function(){$(this).parent().hasClass("checked")?$(this).parent().removeClass("checked"):$(this).parent().addClass("checked");var e=$(this).parent().find('[name="contact_id[]"]');e.is(":checked")?e.prop("checked",!1):e.prop("checked",!0),unselect_not_checked(),show_number_selected_row()}),$("html").on("click",function(e){$(".menu").hide(),-1===e.target.className.indexOf("form-inline")&&-1===e.target.className.indexOf("number_paging")||($("input[type='checkbox']").prop("checked",!1),$(".checked").removeClass("checked"))}),shortcut.add("Ctrl+s",function(){$(".btn-edit-contact").click()}),shortcut.add("Ctrl+a",function(){$("input[type='checkbox']").prop("checked",!0),$(".custom_right_menu").addClass("checked"),show_number_selected_row()}),shortcut.add("Esc",function(){$("input[type='checkbox']").prop("checked",!1),$(".checked").removeClass("checked"),$(".menu").hide()})});$(document).ready(function () {
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
        if ($("input." + myclass).val() === '0')
        {
            $("input." + myclass).attr('value', 'ASC').promise().done(
                    function () {
                        $("#action_contact").attr("action", "#").attr("method", "GET");
                        $("#action_contact").submit();
                    }
            );
            return;
        }
        if ($("input." + myclass).val() === 'ASC')
        {
            $("input." + myclass).val('DESC').promise().done(
                    function () {
                        $("#action_contact").attr("action", "#").attr("method", "GET");
                        $("#action_contact").submit();
                    }
            );
            return;
        }
        if ($("input." + myclass).val() === 'DESC')
        {
            $("input." + myclass).val('0').promise().done(
                    function () {
                        $("#action_contact").attr("action", "#").attr("method", "GET");
                        $("#action_contact").submit();
                    }
            );
            return;
        }

    });
});
$(document).ready(function(){$("input.filter_contact").click(function(t){t.preventDefault(),$("#action_contact").attr("action","#").attr("method","GET"),$("#action_contact").submit()}),$("input.reset_form").click(function(t){t.preventDefault(),$("option[value=0]").attr("selected","selected"),$('option[value="empty"]').attr("selected","selected"),$(".datepicker").val(""),$("input[type='text']").val(""),$(".selectpicker").selectpicker("deselectAll")}),$("select.filter").on("change",function(t){t.preventDefault(),$("#action_contact").attr("action","#").attr("method","GET"),$("#action_contact").submit()}),$('th[class^="order_"]').click(function(){var t=$(this).attr("class");t=(t=t.split(/ /))[0],$('input[class^="order_"]').not("input."+t).attr("value","0"),"0"!==$("input."+t).val()?"ASC"!==$("input."+t).val()?"DESC"!==$("input."+t).val()||$("input."+t).val("0").promise().done(function(){$("#action_contact").attr("action","#").attr("method","GET"),$("#action_contact").submit()}):$("input."+t).val("DESC").promise().done(function(){$("#action_contact").attr("action","#").attr("method","GET"),$("#action_contact").submit()}):$("input."+t).attr("value","ASC").promise().done(function(){$("#action_contact").attr("action","#").attr("method","GET"),$("#action_contact").submit()})})});$(function () {
    $(".real-search").on(
            {'input': function () {
                    var type = $(this).attr('type_search');
                    $.ajax({
                        url: $("#base_url").val() + "common/real_search",
                        type: "POST",
                        beforeSend: function () {
                            $(".popup-wrapper").show();
                        },
                        data: {
                            type: type,
                            value: $(this).val()
                        },
                        success: function (data) {
                            //console.log(data);
                            $(".remove_content").html("");
                            $(".real-search-replacement").html(data);
                        }, complete: function () {
                            $(".popup-wrapper").hide();
                            $('.modal').on('shown.bs.modal', function () {
                                $('.selectpicker').selectpicker({});
                            });
                        }
                    });
                }
            }
    );
});$(function(){$(".real-search").on({input:function(){var e=$(this).attr("type_search");$.ajax({url:$("#base_url").val()+"common/real_search",type:"POST",beforeSend:function(){$(".popup-wrapper").show()},data:{type:e,value:$(this).val()},success:function(e){$(".remove_content").html(""),$(".real-search-replacement").html(e)},complete:function(){$(".popup-wrapper").hide(),$(".modal").on("shown.bs.modal",function(){$(".selectpicker").selectpicker({})})}})}})});$(document).ready(function () {
    $("a.cancel_one_contact").click(function (e) {
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
            beforeSend: function () {
                //$(".popup-wrapper").show();
            },
            success: function (data) {
                if (data === '1')
                {
                    del.parent().parent().hide();
                    $(".total_contact_sale_" + sale_id).text(total_contact_for_sale - 1);
                } else {
                    alert(data);
                }
            },
            error: function (errorThrown) {
                alert(errorThrown);
            },
            complete: function () {
                //    $(".popup-wrapper").hide();
            }
        });
    });
    $(".cancel_multi_contact").click(function (e) {
        $("#action_contact").attr("action", $("#base_url").val() + "manager/cancel_multi_contact");
        $("#action_contact").submit();
    });
});$(document).ready(function(){$("a.cancel_one_contact").click(function(t){var c=$(this),a=$(this).attr("sale_id"),n=$(".total_contact_sale_"+a).text();t.preventDefault(),$.ajax({type:"POST",url:$("#base_url").val()+"manager/cancel_one_contact",data:{contact_id:$(this).attr("contact_id")},beforeSend:function(){},success:function(t){"1"===t?(c.parent().parent().hide(),$(".total_contact_sale_"+a).text(n-1)):alert(t)},error:function(t){alert(t)},complete:function(){}})}),$(".cancel_multi_contact").click(function(t){$("#action_contact").attr("action",$("#base_url").val()+"manager/cancel_multi_contact"),$("#action_contact").submit()})});$(document).ready(function () {
    $("#delete_contact").click(function (e) {
        e.preventDefault();
        var r = confirm("Are you sure?");
        if (r === true) {
            $("#action_contact").attr("action", $("#base_url").val() + "manager/delete_contact");
            $("#action_contact").submit();
        }
    });
});$(document).ready(function(){$("#delete_contact").click(function(t){t.preventDefault(),!0===confirm("Are you sure?")&&($("#action_contact").attr("action",$("#base_url").val()+"manager/delete_contact"),$("#action_contact").submit())})});$(document).ready(function () {
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
            success: function (data) {
                if (data === '1')
                {
                    //del.parent().parent().hide();
                    $(".duplicate_" + contact_id).hide();
                    //location.reload();
                } else {
                    alert(data);
                }
            },
            error: function () {
                alert(errorThrown);
            }
        });
    });
});$(document).ready(function(){$(document).on("click","a.delete_one_contact",function(t){$(this);var e=$(this).attr("contact_id");t.preventDefault(),$.ajax({type:"POST",url:$("#base_url").val()+"manager/delete_one_contact",data:{contact_id:e},success:function(t){"1"===t?$(".duplicate_"+e).hide():alert(t)},error:function(){alert(errorThrown)}})})});$(function () {
    /*=================================== chia contact đã chọn (form modal)================================================*/
    $("a.divide_contact").click(function (e) {
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
    $(".divide_contact_even").click(function (e) {
        e.preventDefault();
        $("#action_contact").attr("action", $("#base_url").val() + "manager/divide_contact_even");
        $("#action_contact").submit();
    });
});$(function(){$("a.divide_contact").click(function(t){t.preventDefault(),$("#action_contact").removeClass("form-inline"),$(".divide_multi_contact_modal").modal("show")}),$(document).on("click",".divide_one_contact_achor",function(t){t.preventDefault(),$("#action_contact").removeClass("form-inline");var c=$(this).attr("contact_id");$(".checked").removeClass("checked"),$(this).parent().parent().addClass("checked"),$("#contact_id_input").val(c);var a=$(this).attr("contact_name");$("span.contact_name").text(a),$(".divide_one_contact_modal").modal("show")}),$(".divide_contact_even").click(function(t){t.preventDefault(),$("#action_contact").attr("action",$("#base_url").val()+"manager/divide_contact_even"),$("#action_contact").submit()})});$("a.view_duplicate").click(function (e) {
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
});$("a.view_duplicate").click(function(a){a.preventDefault();var e=$(this).attr("duplicate_id");$.ajax({url:$("#base_url").val()+"manager/view_duplicate",type:"POST",data:{duplicate_id:e},success:function(a){$("div.view_duplicate").html("").html(a)},complete:function(){$(".view_duplicate_modal").modal("show")}})});$(document).on('scroll', function () {
    if ($(".table-head-pos").length) {
        if ($("body").scrollTop() > ($(".table-head-pos").offset().top)
                ) {
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
}).ready(function () {
    $("input.reset_form").click(function (e) {
        e.preventDefault();
        $('option[value=0]').attr('selected', 'selected');
        $('option[value="empty"]').attr('selected', 'selected');
        $(".datepicker").val('');
        $("input[type='text']").val('');
        // $("#action_contact option:selected").prop("selected", false);
        $('.selectpicker').selectpicker('deselectAll');
    });
});

$(document).on("scroll",function(){if($(".table-head-pos").length){$("body").scrollTop()>$(".table-head-pos").offset().top?$(".fixed-table").css({display:"block"}):$(".fixed-table").css({display:"none"}),$('[class^="staff_"]').each(function(){var e=$(this).attr("class"),t=$(this).width(),l=$(this).height();$(".f_"+e).width(t),$(".f_"+e).height(l)});var e=$(".table-head-pos").offset().left+2;$("table thead.fixed-table").css("left",e+"px")}}).ready(function(){$("input.reset_form").click(function(e){e.preventDefault(),$("option[value=0]").attr("selected","selected"),$('option[value="empty"]').attr("selected","selected"),$(".datepicker").val(""),$("input[type='text']").val(""),$(".selectpicker").selectpicker("deselectAll")})});var _SO_MAY_SAI_ = 1;
var _KHONG_NGHE_MAY_ = 2;
var _NHAM_MAY_ = 3;
var _DA_LIEN_LAC_DUOC_ = 4;
var _CONTACT_CHET_ = 5;

var _CHUA_CHAM_SOC_ = 0;
var _TU_CHOI_MUA_ = 3;
var _DONG_Y_MUA_ = 4;
$(document).on('click', '.btn-edit-contact', function (e) {
    if ($("#input_controller").val() === 'sale') {
        e.preventDefault();
        var error = false;
        var call_status_id = $("select[name='call_status_id']").val();
        console.log('call_status_id= ' + call_status_id);
        var ordering_status_id = $("select[name='ordering_status_id']").val();
        console.log('ordering_status_id= ' + ordering_status_id);
        var date_recall = $(".date_recall").val();
        var course_code = $('select.select_course_code').val();
        var price_purchase = $('[name="price_purchase"]').val();
        if ($("select.edit_payment_method_rgt").val() == 0) {
            alert("Bạn cần cập nhật hình thức thanh toán!");
            error = true;
            return false;
        }
        if (call_status_id == 0) {
            alert("Bạn cần cập nhật trạng thái gọi!");
            error = true;
            return false;
        }
        if (check_rule_call_stt(call_status_id, ordering_status_id) == false) {
            alert("Trạng thái gọi và trạng thái đơn hàng không logic!");
            error = true;
            return false;
        }
        if (date_recall != '') {
            if (now_greater_than_input_date(date_recall)) {
                alert("Ngày gọi lại không thể là một ngày trước ngày hôm nay!");
                error = true;
                return false;
            }
            if (check_rule_call_stt_and_date_recall(call_status_id, ordering_status_id, date_recall)) {
                alert("Nếu contact không liên lạc được hoặc không thể chăm sóc được nữa thì không thể có ngày gọi lại lớn hơn ngày hiện tại!");
                error = true;
                return false;
            }
        }
        if (course_code == '0') {
            alert("Vui lòng chọn mã khóa học!");
            error = true;
            return false;
        }
        if (price_purchase == '') {
            alert("Vui lòng chọn giá tiền mua!");
            error = true;
            return false;
        }
        if (!error) {
            $(".form_submit").submit();
        }
    }
});

// $(".btn-edit-contact").click();

function check_rule_call_stt(call_status_id, ordering_status_id) {
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
}

function check_rule_call_stt_and_date_recall(call_status_id, ordering_status_id, date_recall) {
    if (stop_care(call_status_id, ordering_status_id) && now_greater_than_input_date(date_recall)) {
        return true;
    }
    return false;
}

function stop_care(call_status_id, ordering_status_id) {
    if (call_status_id == _SO_MAY_SAI_ || call_status_id == _NHAM_MAY_ || call_status_id == _KHONG_NGHE_MAY_
            || ordering_status_id == _DONG_Y_MUA_ || ordering_status_id == _TU_CHOI_MUA_ || ordering_status_id == _CONTACT_CHET_) {
        return true;
    }
    return false;
}
function now_greater_than_input_date(date_string) {
    var date_arr = date_string.split(/-/);
    var year = date_arr[2];
    var month = date_arr[1];
    var day = date_arr[0];
    var now_timestamp = new Date();
    now_timestamp = now_timestamp.getTime();
    var input_timestamp = new Date(year, month - 1, day);
    input_timestamp = input_timestamp.getTime();
    return (now_timestamp > input_timestamp);
}
function check_rule_call_stt(_,t){return(_!=_SO_MAY_SAI_&&_!=_KHONG_NGHE_MAY_&&_!=_NHAM_MAY_||t==_CHUA_CHAM_SOC_)&&(_!=_DA_LIEN_LAC_DUOC_||t!=_CHUA_CHAM_SOC_)}function check_rule_call_stt_and_date_recall(_,t,n){return!(!stop_care(_,t)||!now_greater_than_input_date(n))}function stop_care(_,t){return _==_SO_MAY_SAI_||_==_NHAM_MAY_||_==_KHONG_NGHE_MAY_||t==_DONG_Y_MUA_||t==_TU_CHOI_MUA_||t==_CONTACT_CHET_}function now_greater_than_input_date(_){var t=_.split(/-/),n=t[2],e=t[1],r=t[0],a=new Date;a=a.getTime();var c=new Date(n,e-1,r);return c=c.getTime(),a>c}var _SO_MAY_SAI_=1,_KHONG_NGHE_MAY_=2,_NHAM_MAY_=3,_DA_LIEN_LAC_DUOC_=4,_CONTACT_CHET_=5,_CHUA_CHAM_SOC_=0,_TU_CHOI_MUA_=3,_DONG_Y_MUA_=4;$(document).on("click",".btn-edit-contact",function(_){if("sale"===$("#input_controller").val()){_.preventDefault();var t=!1,n=$("select[name='call_status_id']").val(),e=$("select[name='ordering_status_id']").val(),r=$(".date_recall").val(),a=$("select.select_course_code").val(),c=$('[name="price_purchase"]').val();if(0==$("select.edit_payment_method_rgt").val())return alert("Bạn cần cập nhật hình thức thanh toán!"),t=!0,!1;if(0==n)return alert("Bạn cần cập nhật trạng thái gọi!"),t=!0,!1;if(0==check_rule_call_stt(n,e))return alert("Trạng thái gọi và trạng thái đơn hàng không logic!"),t=!0,!1;if(""!=r){if(now_greater_than_input_date(r))return alert("Ngày gọi lại không thể là một ngày trước ngày hôm nay!"),t=!0,!1;if(check_rule_call_stt_and_date_recall(n,e,r))return alert("Nếu contact không liên lạc được hoặc không thể chăm sóc được nữa thì không thể có ngày gọi lại lớn hơn ngày hiện tại!"),t=!0,!1}if("0"==a)return alert("Vui lòng chọn mã khóa học!"),t=!0,!1;if(""==c)return alert("Vui lòng chọn giá tiền mua!"),t=!0,!1;t||$(".form_submit").submit()}});$(function () {
    var url = $("#base_url").val() + "sale/noti_contact_recall";
    setInterval(noti, 10000);
    function noti() {
        $.ajax({
            url: url,
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $('#num_noti').html(data.num_noti);
                var content_noti = '';
                $.each(data.contacts_noti, function () {
                    content_noti += '<li class="content_noti">';
                    content_noti += '<a href="#" class="edit_contact" contact_id="' + this.id + '" title="Chăm sóc contact"> ' +
                            this.name + ' - ' + this.phone + ' - Thời gian gọi lại ' + this.date_recall + '</a>';
                    content_noti += '</li>';
                });
                $('#noti_contact_recall').html(content_noti);
                if (typeof data.sound !== 'undefined') {
                    $("#notificate_sound")[0].play();
                    notify = new Notification(
                            'Có contact mới đăng ký',
                            {
                                body: 'Click vào đây để xem ngay!',
                                icon: $("#base_url").val() + 'public/images/logo2.png',
                                tag: 'http://crm2.lakita.vn/quan-ly/trang-chu.html',
                                sound: $("#base_url").val() + 'public/mp3/new-contact.mp3',
                                image: $("#base_url").val() + 'public/images/recall.jpg'
                            }
                    );
                }
            }
        });
    }
});$(function(){var t=$("#base_url").val()+"sale/noti_contact_recall";setInterval(function(){$.ajax({url:t,type:"POST",dataType:"json",success:function(t){$("#num_noti").html(t.num_noti);var a="";$.each(t.contacts_noti,function(){a+='<li class="content_noti">',a+='<a href="#" class="edit_contact" contact_id="'+this.id+'" title="Chăm sóc contact"> '+this.name+" - "+this.phone+" - Thời gian gọi lại "+this.date_recall+"</a>",a+="</li>"}),$("#noti_contact_recall").html(a),void 0!==t.sound&&($("#notificate_sound")[0].play(),notify=new Notification("Có contact mới đăng ký",{body:"Click vào đây để xem ngay!",icon:$("#base_url").val()+"public/images/logo2.png",tag:"http://crm2.lakita.vn/quan-ly/trang-chu.html",sound:$("#base_url").val()+"public/mp3/new-contact.mp3",image:$("#base_url").val()+"public/images/recall.jpg"}))}})},1e4)});$(function () {
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
                success: function (data) {
                    //console.log(data);
                    $("div.replace_content_script").html(data);
                },
                complete: function () {
                    $(".script_modal").modal("show");
                }
            });
        }
    });
});$(function(){$(document).on("change","select.select_script",function(){var t=$("#base_url").val()+"sale/show_script_modal";0!=$(this).val()&&$.ajax({url:t,type:"POST",data:{script_id:$(this).val()},success:function(t){$("div.replace_content_script").html(t)},complete:function(){$(".script_modal").modal("show")}})})});$(document).on('click', 'a.transfer_contact, a.transfer_one_contact', function (e) {
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
$(document).on("click","a.transfer_contact, a.transfer_one_contact",function(t){if(t.preventDefault(),"transfer_contact"==$(this).attr("class").split(" ")[0])$("#action_contact").removeClass("form-inline"),$(".transfer_multi_contact_modal").modal("show");else{$(".checked").removeClass("checked"),$(this).parent().parent().addClass("checked");var a=$(this).attr("contact_id"),c=$(this).attr("contact_name");$("#contact_id_input").val(a),$(".contact_name_replacement").text(c),$(".transfer_one_contact_modal").modal("show")}});
//# sourceMappingURL=built.js.map