<form method="post" action="<?php echo base_url() . $this->controller_path . '/action_add_item'; ?>" class="form_submit">
    <div class="row" style="margin-right: 5px; margin-left: 5px;">
        <div class="col-md-6">
            <table class="table table-striped table-bordered table-hover table-1 table-view-1 heavyTable">                
                <?php
                foreach ($this->list_add['left_table'] as $key => $value) {
                    $data['key'] = $key;

                    if (!isset($value['type'])) {
                        $this->load->view('base/add_item/content/add_text', $data);
                    } else {
                        switch ($value['type']) {
                            case 'array' :
                                $data['arr'] = $value['value'];
                                $this->load->view($this->view_path .'/add_item/'. $key, $data);
                                break;
                            case 'textarea' :
                                $this->load->view('base/add_item/content/textarea', $data);
                                break;
                            case 'datetime' :
                                $this->load->view('base/add_item/content/add_datetime', $data);
                                break;
                            case 'custom' :
                                $this->load->view($this->view_path . '/add_item/' . $key, $data);
                                break;
                            case 'password' :
                                $this->load->view('base/add_item/content/password', $data);
                                break;
                        }
                    }
                }
                ?>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-striped table-bordered table-hover table-2 table-view-2">
                <?php
                foreach ($this->list_add['right_table'] as $key => $value) {
                    $data['key'] = $key;
                    if (!isset($value['type'])) {
                        $this->load->view('base/add_item/content/add_text', $data);
                    } else {
                        switch ($value['type']) {
                            case 'array' :
                                $data['arr'] = $value['value'];
                                $this->load->view($this->view_path .'/add_item/'. $key, $data);
                                break;
                            case 'textarea' :
                                $this->load->view('base/add_item/content/textarea', $data);
                                break;
                            case 'datetime' :
                                $this->load->view('base/add_item/content/edit_datetime', $data);
                                break;
                            case 'custom' :
                                $this->load->view($this->view_path . '/add_item/' . $key, $data);
                                break;
                            case 'password' :
                                $this->load->view('base/add_item/content/password', $data);
                                break;
                        }
                    }
                }
                ?>
            </table>
        </div>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-success btn-lg">Lưu Lại</button>
    </div>

</form>
