/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(".jquery-confirm").confirm({
    theme: 'supervan', // 'material', 'bootstrap',
    title: 'Bạn có chắc chắn muốn gửi email cho Viettel không?',
    content: 'Hãy đảm bảo rằng các contact được chọn đang là trạng thái "đang giao hàng"!',
    buttons: {
        confirm: {
            text: 'Gửi',
            action: function () {
                var form = $('.change-form-submit-url2').data("form-id");
                var action = $('.change-form-submit-url2').data("action");
                var method = $('.change-form-submit-url2').data("method");
                var url = $("#base_url").val() + action;
                $("#" + form).attr("action", url).attr("method", method).submit();
            }},
        cancel: {
            text: 'Nope',
            action: function () {
            }},
        somethingElse: {
            text: 'Khác',
            btnClass: 'btn-blue',
            keys: ['enter', 'shift'],
            action: function () {

            }
        }
    }
});
$(document).on('click', '.change-form-submit-url', function (e) {
    e.preventDefault();
    var form = $(this).data("form-id");
    var action = $(this).data("action");
    var method = $(this).data("method");
    var url = $("#base_url").val() + action;
    $("#" + form).attr("action", url).attr("method", method).submit(); 
});


