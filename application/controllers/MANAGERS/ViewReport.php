<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ViewReport
 *
 * @author phong
 */
class ViewReport extends MY_Controller {

    public $L = array();

    function __construct() {
        parent::__construct();
        $input = array();
        $input['select'] = 'id';
        $input['where'] = array('call_status_id' => '0', 'sale_staff_id' => '0', 'is_hide' => '0');
        $this->L['L1'] = count($this->contacts_model->load_all($input));
        $input = array();
        $input['select'] = 'id';
        $input['where'] = array('is_hide' => '0');
        $this->L['all'] = count($this->contacts_model->load_all($input));
    }

    public function ViewGeneralReport() {
        $period = hGetTimeRange(strtotime(date('Y-m-01')), time());
        $period2 = [];
        foreach ($period as $dayName => $dayTimeStamp) {
            $input = array();
            $input['select'] = 'id';
            $input['where'] = array('date_rgt >=' => $dayTimeStamp, 'date_rgt <=' => $dayTimeStamp + 24 * 3600 - 1);
            $period2[$dayName] = count($this->contacts_model->load_all($input));
        }
        $data['period'] = $period2;
        $data['slide_menu'] = 'manager/common/menu';
        $data['top_nav'] = 'manager/common/top-nav';
        $data['content'] = 'MANAGERS/ViewReport/view-general-report-chart';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

}
