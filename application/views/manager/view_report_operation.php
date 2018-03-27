<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h3 class="text-center marginbottom20"> Báo cáo tổng hợp 
            <?php
            if (count($_GET) == 0) {
                echo 'Tháng ' . date('m-Y');
            } else if ($_GET['filter_date_happen_from'] == '') {
                echo 'Tháng ' . $_GET['filter_month_id'];
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
<table class="table table-bordered table-striped view_report gr4-table" style="overflow: scroll; display: block"> 
    <thead class="table-head-pos">
        <tr>
            <th style="background: none" class="staff_0"></th>
            <th>Lũy kế</th>
                <?php
                foreach ($date as $date => $time) {

                    echo '<th> ' . $date . '</th>';
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
                    if ($typeReport == 'L7+L8' || $typeReport == 'ARPU') {
                        if ($value != 'N/A') {
                            echo "<td>" . number_format(str_replace('.', '', $value)) . "</td>";
                        } else {
                            echo "<td> $value </td>";
                        }
                    } else {
                        echo "<td> $value </td>";
                    }
                }
                ?>
            </tr>
        <?php } ?>
    </tbody>
</table>



