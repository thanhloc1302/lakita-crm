$(function () {
    var url = $("#base_url").val() + "sale/noti_contact_recall";
    var i = 0;
    noti = function noti() {
        $.ajax({
            url: url,
            type: "POST",
            dataType: 'json',
            success: function success(data) {
                $('#num_noti').html(data.num_noti);
                var content_noti = "";
                $.each(data.contacts_noti, function () {
                    content_noti += "<li class=\"content_noti\">";
                    content_noti += "<a href=\"#\"\n                                    title=\"Ch\u0103m s\xF3c contact\"\n                                    class=\"ajax-request-modal\"\n                                    data-contact-id =\"" + this.id + "\"\n                                    data-modal-name=\"edit-contact-modal\"\n                                    data-url=\"common/show_edit_contact_modal\"> " + this.name + "  - " + this.phone + " - Th\u1EDDi gian g\u1ECDi l\u1EA1i " + this.date_recall + " \n                                    </a>";
                    content_noti += "</li>";
                });
                $('#noti_contact_recall').html(content_noti);
                if (data.num_noti > 0) {
                    var title = '(' + data.num_noti + ')  CONTACT CẦN GỌI LẠI';
                    $("title").text(title);
                }
                if (typeof data.sound !== 'undefined') {
                    $("#notificate_sound")[0].play();
                    notify = new Notification('Có contact cần gọi lại ngay bây giờ!', {
                        body: 'Click vào đây để xem ngay!',
                        icon: $("#base_url").val() + 'public/images/logo2.png',
                        tag: 'https://crm2.lakita.vn/quan-ly/trang-chu.html',
                        sound: $("#base_url").val() + 'public/mp3/new-contact.mp3',
                        image: $("#base_url").val() + 'public/images/recall.jpg'
                    });
                    $.notify('Có một contact cần gọi lại ngay lúc này', {
                        position: "top middle",
                        className: 'success',
                        showDuration: 200,
                        autoHideDelay: 10000
                    });
                }
            }
        });
    };
    setInterval(noti, 10000);
});
