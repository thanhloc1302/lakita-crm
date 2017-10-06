<?php if ($this->total_paging > 0) { ?>
    <div class="pagination">
        <?php echo isset($pagination) ? $pagination : ''; ?>
    </div>

    <div class="number_paging">
        <?php echo 'Hiển thị ' . $this->begin_paging . ' - ' . $this->end_paging . ' của ' . $this->total_paging . ' contacts'; ?>
    </div>

    <table class="table table-bordered table-striped list_contact list_contact_2">
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
<!--            <tr>
                <?php
//                if (isset($table)) {
//                    foreach ($table as $value) {
//                        $this->load->view('common/content/table/search/' . $value);
//                    }
//                }
                ?>
            </tr>-->
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
                    if ($value['is_hide'] == 1) {
                        echo ' is_hide';
                    }
                    if ($value['cod_status_id'] == _HUY_DON_ || $value['ordering_status_id'] == _TU_CHOI_MUA_
                            || $value['ordering_status_id'] == _CONTACT_CHET_
                            || $value['call_status_id'] == _SO_MAY_SAI_ || $value['call_status_id'] == _NHAM_MAY_) {
                        echo ' ban';
                    }
                    if ($value['cod_status_id'] == _DA_THU_COD_){
                        echo ' receive-cod';
                    }
                    if($value['cod_status_id'] == _DA_THU_LAKITA_ ){
                         echo ' receive-lakita';
                    }
                    echo " custom_right_menu";
                    ?>" 
                        contact_id="<?php echo $value['id']; ?>" 
                        duplicate_id="<?php echo $value['duplicate_id']; ?>" 
                        contact_name="<?php echo $value['name']; ?>"
                        contact_phone="<?php echo $value['phone']; ?>">
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
<!--    <div class="number_paging" > 
        Tổng tiền: <?php //echo isset($contacts) ? number_format(h_sum_money($contacts), 0, ",", ".") . " VNĐ" : 0; ?>
    </div>-->
    <div class="number_paging"> 
        <?php echo 'Hiển thị ' . $this->begin_paging . ' - ' . $this->end_paging . ' của ' . $this->total_paging . ' contacts'; ?>
    </div>
    <div class="pagination">
        <?php echo isset($pagination) ? $pagination : ''; ?>
    </div>
<?php } ?>