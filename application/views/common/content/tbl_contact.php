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
            <?php
            if (isset($contacts)) {
                foreach ($contacts as $key => $value) {
                    ?>
                    <tr class="custom_right_menu <?php echo h_get_row_class($value);?>" 
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
    <div class="number_paging"> 
        <?php echo 'Hiển thị ' . $this->begin_paging . ' - ' . $this->end_paging . ' của ' . $this->total_paging . ' contacts'; ?>
    </div>
    <div class="pagination">
        <?php echo isset($pagination) ? $pagination : ''; ?>
    </div>
<?php } 