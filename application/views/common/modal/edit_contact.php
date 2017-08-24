<form method="post" action="<?php echo base_url($action_url); ?>" class="form_submit">
    <?php if (!$edited_contact) echo'<fieldset disabled>'; ?>
    <div class="row" style="margin-right: 5px; margin-left: 5px;">
        <div class="col-md-6">
            <table class="table table-striped table-bordered table-hover table-1 table-view-1 edit_table">
                <?php
                if (isset($view_edit_left)) {
                    foreach ($view_edit_left as $key => $value) {
                        if ($value == 'view') {
                            $this->load->view('common/content/view_contact/' . $key);
                        }
                        if ($value == 'edit') {
                            $this->load->view('common/content/edit_contact/' . $key);
                        }
                    }
                }
                ?>    
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-striped table-bordered table-hover table-2 table-view-2 edit_table">
                <?php
                if (isset($view_edit_right)) {
                    foreach ($view_edit_right as $key => $value) {
                        if ($value == 'view') {
                            $this->load->view('common/content/view_contact/' . $key);
                        }
                        if ($value == 'edit') {
                            $this->load->view('common/content/edit_contact/' . $key);
                        }
                    }
                }
                ?>  
            </table>
        </div>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-success btn-lg btn-edit-contact">Lưu Lại</button>
    </div>
    <h4 class="margintop45 text-center"> Lịch sử cuộc gọi </h4> 
    <?php $this->load->view('common/content/call_log'); ?>
    <?php if (!$edited_contact) echo'</fieldset>'; ?>
</form>
