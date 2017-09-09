<h1> Danh sách contact chờ duyệt chuyển hoàn (<?php echo count($contacts);?>) </h1>
<?php if (empty($contacts)) { ?>
    <h3> Xin chúc mừng, hôm nay không có contact chờ duyệt chuyển hoàn! </h3>
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
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($contacts as $value) {
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
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
<?php } 