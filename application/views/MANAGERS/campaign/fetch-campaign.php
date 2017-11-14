<div class="row" style="margin-right: 5px; margin-left: 5px;">
    <div class="col-md-12">
        <table class="table table-striped table-bordered table-hover table-1 table-view-1 heavyTable" style="height: 193px;">
            <thead>
            <th> Tài khoản </th>
            <th> Tên chiến dịch </th>
            <th> ID chiến dịch FB </th>
            <th> Marketer (nếu có) </th>
            <th> Thao tác </th>
            </thead>
            <tbody>
                <?php foreach ($campaigns as $value) { ?>
                    <tr>
                        <td> <?php echo $value['name_account']; ?></td>
                        <td> <?php echo $value['name']; ?> </td>
                        <td> <?php echo $value['id']; ?> </td>
                        <td>  <?php
                            if (isset($value['detail'][0])) {
                                foreach ($value['detail'] as $value2) {
                                    echo $marketers[$value2['marketer_id']] . '<br>';
                                }
                            }
                            ?></td>
                        <td>  <?php
                            if (!isset($value['detail'][0])) {
                                echo '<button class="create-campaign-from-fb btn btn-success" '
                                . 'id-fb="'. $value['id'] .'" campaign-name="'.$value['name'].'"> Tạo mới campaign </button>';
                            }
                            ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>