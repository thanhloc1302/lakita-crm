/*
 * Copyright (C) 2017 Phạm Ngọc Chuyển <chuyenpn at lakita.vn>
 *
 */
/* global Notification */
/*
 var notify = '';
 Notification.requestPermission(function (p) {});
 setInterval(function () {
 $.ajax({
 url: $("#base_url").val() + "cron/listen",
 success: data2 => {
 //console.log(data2);
 if (data2 === '1') {
 $("#notificate")[0].play();
 notify = new Notification(
 'Có một contact mới đăng ký',
 {
 body: 'Click vào đây để xem ngay!',
 icon: $("#base_url").val() + 'public/images/logo2.png',
 tag: 'https://crm2.lakita.vn/quan-ly/trang-chu.html',
 sound: $("#base_url").val() + 'public/mp3/new-contact.mp3',
 image: $("#base_url").val() + 'public/images/contact-us.jpg'
 }
 );
 notify.onclick = function (event) {
 event.preventDefault();
 window.open('https://crm2.lakita.vn/quan-ly/trang-chu.html', '_blank');
 };
 if (($("#input_controller").val() === 'manager' && $("#input_method").val() === 'index')
 || $("#input_controller").val() === 'marketing' && $("#input_method").val() === 'index') {
 setTimeout(function () {
 location.reload();
 }, 4000);
 }
 }
 }
 });
 }, 3000);
 */
Pusher.logToConsole = true;
var pusher = new Pusher('e37045ff133e03de137a', {
    cluster: 'ap1',
    encrypted: true
});
var channel = pusher.subscribe('my-channel');
channel.bind('notice', function (data) {
    $("#notificate")[0].play();
    n = new Notification(
            'Có một contact mới đăng ký',
            {
                body: 'Click vào đây để xem ngay!',
                icon: $("#base_url").val() + 'public/images/logo2.png',
                tag: 'https://crm2.lakita.vn/quan-ly/trang-chu.html',
                sound: $("#base_url").val() + 'public/mp3/new-contact.mp3',
                image: data.image
            });

    var append = ` <div style="position: fixed; top:10px; left: 10px; z-index: 999999999; 
         background-color: #fff; display: inline-block; width: 30%; border-radius: 5px" id="my-notify">
        <div style="float:left; width: 35%; padding: 2%">
            <img src="https://crm2.lakita.vn/public/images/logo2.png" style="width: 70%"/>
        </div>
        <div style="float:left; width:65%; padding: 2%">
            <h4> Có một contact mới đăng ký </h4>
            <div>
                <img src="${data.image}" style="width: 90%"/>
            </div>
        </div>
    </div>`;

    $('body').append(append);
    setTimeout(function(){
        $("#my-notify").remove();
    }, 2000);

    if (($("#input_controller").val() === 'manager' && $("#input_method").val() === 'index')
            || $("#input_controller").val() === 'marketing' && $("#input_method").val() === 'index') {
        setTimeout(function () {
            location.reload();
        }, 4000);
    }
});

channel.bind('callLog', function (data) {
    n = new Notification(
            'Lịch sử trang web (beta)',
            {
                body: data.message,
                icon: $("#base_url").val() + 'public/images/logo2.png',
                tag: 'https://crm2.lakita.vn/quan-ly/trang-chu.html',
                image: data.image
            });

       var append = ` <div style="position: fixed; top:10px; left: 10px; z-index: 999999999; 
         background-color: #fff; display: inline-block; width: 30%; border-radius: 5px" id="my-notify">
        <div style="float:left; width: 35%; padding: 2%">
            <img src="https://crm2.lakita.vn/public/images/logo2.png" style="width: 70%"/>
        </div>
        <div style="float:left; width:65%; padding: 2%">
            <h4> ${data.message} </h4>
            <div>
                <img src="${data.image}" style="width: 90%"/>
            </div>
        </div>
    </div>`;

    $('body').append(append);
    setTimeout(function(){
        $("#my-notify").remove();
    }, 2000);
});