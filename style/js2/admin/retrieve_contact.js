/* 
 * Copyright (C) 2017 Phạm Ngọc Chuyển <chuyenpn at lakita.vn>
 *
 */
$(document).on('click', 'a.retrieve_contact', function (e) {
    var r = confirm("Bạn có chắc chắn muốn thu hồi contact này không?");
    if (r == true) {
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
    }
});

