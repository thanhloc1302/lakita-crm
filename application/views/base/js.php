<?php
/*
 * Copyright (C) 2017 Phạm Ngọc Chuyển <chuyenpn at lakita.vn>
 *
 */
?>
<script src="<?php echo base_url(); ?>style/js/base/my_table.min.js"></script>

<script>
    $(document).ready(function () {
        $(document).on('change', '[name="add_channel_id"]', function () {
            var channel_id = $(this).val();
            $.ajax({
                url: $('#base_url').val() + 'MANAGERS/link/get_campaign',
                type: "POST",
                data: {
                    channel_id: channel_id
                },
                success: function (data) {
                    $(".ajax_campaign").html(data);
                },
                complete: function (jqXHR, textStatus) {
                    $('.selectpicker').selectpicker({});
                }
            });
        });
         $(document).on('change', '[name="add_campagin_id"]', function () {
            var campagin_id = $(this).val();
            alert(campagin_id);
            $.ajax({
                url: $('#base_url').val() + 'MANAGERS/link/get_campaign',
                type: "POST",
                data: {
                    channel_id: channel_id
                },
                success: function (data) {
                    $(".ajax_campaign").html(data);
                },
                complete: function (jqXHR, textStatus) {
                    $('.selectpicker').selectpicker({});
                }
            });
        });
    });

</script>