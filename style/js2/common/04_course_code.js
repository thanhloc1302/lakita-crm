/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


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

