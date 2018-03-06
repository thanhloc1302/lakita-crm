<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h3 class="text-center marginbottom20"> Báo cáo doanh thu 
            <?php
            if (count($_GET) == 0) {
                echo 'Tháng ' . date('m-Y');
            } else if ($_GET['filter_date_happen_from'] == '') {
                echo 'Tháng ' . date('m-Y',strtotime($_GET['filter_month_id']));
            } else {
                ?>
                từ ngày <?php echo date('d-m-Y', $startDate);
                ?> đến ngày <?php echo date('d-m-Y', $endDate); ?></h3>
        <?php } ?>
    </div>
</div>
<form action="#" method="GET" id="action_contact" class="form-inline">
    <?php $this->load->view('common/content/filter'); ?>
</form>
<table class="table table-bordered table-striped view_report gr4-table">
    <thead class="table-head-pos">
        <tr>
            <th style="background: none" class="staff_0"></th>
            <?php
            foreach ($Report['C3'] as $typeReport => $value) {
                if (is_array($value)) {
                    echo ' <th>' . $typeReport . '</th>';
                } else {
                    echo ' <th>' . $typeReport . '</th>';
                }
            }
            ?>
        </tr>

    </thead>
    <tbody>
        <?php foreach ($Report as $typeReport => $valueArr) {
            ?>
            <tr>
                <td> <?php echo $typeReport; ?> </td>
                <?php
                foreach ($valueArr as $key2 => $value) {
                    if (is_array($value)) {
                        foreach ($value as $key3 => $val) {
                                echo "<td>". number_format($val, 0, ",", ".") . " VNĐ". "</td>";
                        }
                    } else {
                        echo "<td>". number_format($value, 0, ",", ".") . " VNĐ"." </td>";
                    }
                }
                ?>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php //$this->load->view('common/script/view_detail_contact');   ?>
<?php //$this->load->view('common/content/pagination');  ?>


