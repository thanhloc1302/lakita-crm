<div class="tab_container">
    <input id="tab1" type="radio" name="tabs" checked>
    <label for="tab1"><i class="fa fa-info-circle" aria-hidden="true"></i><span>Chi tiết</span></label>

    <input id="tab2" type="radio" name="tabs">
    <label for="tab2"><i class="fa fa-history" aria-hidden="true"></i><span>Lịch sử cuộc gọi</span></label>

    <section id="content1" class="tab-content">
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

        </div>
    </section>

    <section id="content2" class="tab-content">
        <div>
            <?php $this->load->view('common/content/call_log'); ?>
        </div>
    </section>
</div>
