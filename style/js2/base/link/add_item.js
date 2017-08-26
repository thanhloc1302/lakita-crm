$(document).ready(function () {
    $(document).on('change', '[name="add_channel_id"], [name="edit_channel_id"]', function () {
        var channel_id = $(this).val();
        $.ajax({
            url: $('#base_url').val() + 'MANAGERS/link/get_campaign',
            type: "POST",
            data: {
                channel_id: channel_id
            },
            success: function (data) {
                $(".ajax_campaign").html(data);
                $(".ajax_adset").html('');
                $(".ajax_ad").html('');
            },
            complete: function (jqXHR, textStatus) {
                $('.selectpicker').selectpicker({});
            }
        });
    });
    $(document).on('change', '[name="add_campaign_id"]', function () {
        var campagin_id = $(this).val();
        $.ajax({
            url: $('#base_url').val() + 'MANAGERS/link/get_adset',
            type: "POST",
            data: {
                campagin_id: campagin_id
            },
            success: function (data) {
                $(".ajax_adset").html(data);
                $(".ajax_ad").html('');
            },
            complete: function (jqXHR, textStatus) {
                $('.selectpicker').selectpicker({});
            }
        });
    });

    $(document).on('change', '[name="add_adset_id"]', function () {
        var adset_id = $(this).val();
        $.ajax({
            url: $('#base_url').val() + 'MANAGERS/link/get_ad',
            type: "POST",
            data: {
                adset_id: adset_id
            },
            success: function (data) {
                $(".ajax_ad").html(data);
            },
            complete: function (jqXHR, textStatus) {
                $('.selectpicker').selectpicker({});
            }
        });
    });
});
