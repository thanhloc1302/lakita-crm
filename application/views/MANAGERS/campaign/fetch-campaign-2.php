<div class="row" style="margin-right: 5px; margin-left: 5px;">
    <div class="col-md-12">
        <table class="table table-striped table-bordered table-hover table-1 table-view-1 heavyTable" style="height: 193px;">
            <thead>
            <th style="width: 25px;"> Tài khoản </th>
            <th style="width: 121px;"> Tên chiến dịch </th>
            <th style="width: 121px;"> Tên adset </th>
            <th style="width: 121px;"> Tên ad </th>
            <th> Thao tác </th>
            </thead>
            <tbody>
                <?php foreach ($campaigns as $value) { ?>
                    <tr>
                        <td> <?php echo $value['account']; ?></td>
                        <td> <?php echo $value['fb_campaign_name']; ?> </td>
                        <td> <?php echo $value['fb_adset_name']; ?> </td>
                        <td> <?php echo $value['fb_ad_name']; ?> </td>
                        <td>  <?php
                            echo '<button class="create-campaign-from-fb-2 btn btn-success" '
                            . 'id-fb="' . $value['fb_campaign_name'] . '" campaign-name="' . $value['fb_campaign_name'] . '"> Chọn campaign </button>';
                            ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>