<div class="pagination">
    <?php echo isset($pagination) ? $pagination : ''; ?>
</div>
<div class="number_paging">
    <?php echo 'Hiển thị ' . $this->begin_paging . ' - ' . $this->end_paging . ' của ' . $this->total_paging . ' contacts'; ?>
</div>
<table class="table table-bordered table-striped list_contact">
    <thead>
        <tr>
            <?php
            if (isset($table)) {
                foreach ($table as $value) {
                    $this->load->view('common/content/table/head/' . $value);
                }
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php
            if (isset($table)) {
                foreach ($table as $value) {
                    $this->load->view('common/content/table/search/' . $value);
                }
            }
            ?>
        </tr>
        <?php
        if (isset($contacts)) {
            foreach ($contacts as $key => $value) {
                ?>
                <tr class="<?php
                if ($value['duplicate_id'] > 0) {
                    echo 'duplicate duplicate_' . $value['id'];
                }
                if ($value['date_transfer'] > 0) {
                    echo ' has_transfer';
                }
                $dayDiff = floor((time() - $value['date_print_cod']) / (60 * 60 * 24));
                if ($dayDiff > 3 && $dayDiff <= 5 && $value['cod_status_id'] == _DANG_GIAO_HANG_) {
                    echo ' bgyellow';
                }
                if ($dayDiff > 5 && $dayDiff <= 30 && $value['cod_status_id'] == _DANG_GIAO_HANG_) {
                    echo ' bgred';
                }
                if ($value['weight_envelope'] > 50) {
                    echo ' bgred';
                }
                if($value['is_hide'] == 1) {
                    echo ' is_hide';
                }
                ?>">
                        <?php
                        $data['value'] = $value;
                        foreach ($table as $value2) {
                            $this->load->view('common/content/table/body/' . $value2, $data);
                        }
                        ?>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>
<div class="number_paging" > 
    Tổng tiền: <?php echo isset($contacts) ? number_format(h_sum_money($contacts), 0, ",", ".") . " VNĐ" : 0; ?>
</div>
<div class="number_paging"> 
    <?php echo 'Hiển thị ' . $this->begin_paging . ' - ' . $this->end_paging . ' của ' . $this->total_paging . ' contacts'; ?>
</div>
<div class="pagination">
    <?php echo isset($pagination) ? $pagination : ''; ?>
</div>