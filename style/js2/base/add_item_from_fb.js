$(document).on('click', '.create-campaign-from-fb', function (e) {
    e.preventDefault();
    $(".add-name-from-fb").val($(this).attr("campaign-name"));
    $(".add-campaign-id-from-fb").val($(this).attr("id-fb"));
    console.log($(this).attr("id-fb"));
    $(".add_item_from_fb_modal").modal("show");
});

$(document).on('click', '.create-campaign-from-fb-2', function (e) {
    e.preventDefault();
    var _this = $(this);
    if ($(this).parent().parent().find('select.select-landing-page').val() == 0) {
        $.alert({
            theme: 'modern',
            type: 'red',
            title: 'Có lỗi xảy ra!',
            content: 'Vui lòng chọn landing page!'
        });
    } else {
        $.ajax({
            url: $("#url-add-item-from-fb-2").val(),
            type: "POST",
            beforeSend: () => $(".popup-wrapper").show(),
            data: {
                fb_campaign_id: $(this).attr('fb-campaign-id'),
                fb_campaign_name: $(this).attr('fb-campaign-name'),
                fb_adset_id: $(this).attr('fb-adset-id'),
                fb_adset_name: $(this).attr('fb-adset-name'),
                fb_ad_id: $(this).attr('fb-ad-id'),
                fb_ad_name: $(this).attr('fb-ad-name'),
                landing_page_id: $(this).parent().parent().find('select.select-landing-page').val()
            },
            success: function (data) {
                $.alert({
                    theme: 'modern',
                    title: 'Tạo thành công link',
                    content: data
                });
                _this.parent().parent().remove();
            },
            complete: function () {
                $(".popup-wrapper").hide();
            }
        });
    }
});

