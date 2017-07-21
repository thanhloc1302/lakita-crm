<div class="row real-search-result-replace">
    <div class="col-md-6">
        <table class="table table-striped table-bordered table-hover table-view-1">
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
        <table class="table table-striped table-bordered table-hover table-view-2">
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
    <div class="clearfix"></div>
    <h4 class="margintop45 text-center"> Lịch sử cuộc gọi </h4>
    <div>
        <?php $this->load->view('common/content/call_log'); ?>
    </div>
</div>