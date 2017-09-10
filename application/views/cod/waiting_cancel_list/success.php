<h1> Danh sách contact phát thành công  (<?php echo count($contact_success); ?>)</h1>
<?php if (empty($contact_success)) { ?>
   
<?php } else { ?>
    <table border="1" cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th style="background: #0C812D; color: #fff"> 
                    ID 
                </th>
                <th style="background: #0C812D; color: #fff">
                    Họ tên
                </th>
                <th style="background: #0C812D; color: #fff">
                    Email
                </th>
                <th style="background: #0C812D; color: #fff">
                    Số điện thoại
                </th>
                <th style="background: #0C812D; color: #fff">
                    Địa chỉ
                </th>
                <th style="background: #0C812D; color: #fff">
                    Ngày đăng ký
                </th>
                <th style="background: #0C812D; color: #fff">
                    Mã bill
                </th>
                <th style="background: #0C812D; color: #fff">
                    Trạng thái
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            foreach ($contact_success as $value) {
                $total += $value['price_purchase'];
                ?>
                <tr>
                    <td>
                        <?php echo $value['id']; ?>
                    </td>
                    <td>
                        <?php echo $value['name']; ?>
                    </td>
                    <td>
                        <?php echo $value['email']; ?>
                    </td>
                    <td>
                        <?php echo $value['phone']; ?>
                    </td>
                    <td>
                        <?php echo $value['address']; ?>
                    </td>
                    <td>
                        <?php echo date('d/m/Y H:i:s', $value['date_rgt']); ?>
                    </td>
                    <td>
                        <?php echo $value['code_cross_check']; ?>
                    </td>
                    <td>
                        <?php echo $value['status_viettel']; ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <h3> Tổng tiền thu COD: <?php echo display_money($total); ?></h3>
    <?php
}
