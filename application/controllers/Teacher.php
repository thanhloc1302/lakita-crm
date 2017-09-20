<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Teacher
 *
 * @author phong
 */
class Teacher extends MY_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view('teacher/index');
    }

    public function ViewReport($offset = 0) {
        $get = $this->input->get();
//        $this->load->model('call_status_model');
//        $this->load->model('ordering_status_model');
//        $this->load->model('cod_status_model');
//        $this->load->model('providers_model');
//        $this->load->model('payment_method_rgt_model');
        $conditional['select'] = 'course_code,  price_purchase, date_receive_lakita';
        if ((isset($get['filter_date_date_rgt']) && $get['filter_date_date_rgt'] == '')) {
            $conditional['where'] = array('date_rgt >=' => strtotime(date('Y-m-01 00:00:00')), 'cod_status_id' => 3, 'is_hide' => '0');
        } else {
            $conditional['where'] = array('cod_status_id' => 3, 'is_hide' => '0');
        }
        $data_pagination = $this->_query_all_from_get($get, $conditional, 10000, $offset);
        $contacts = $data_pagination['data'];
        $rs = [];
        foreach ($contacts as $key => $value) {
             $rs[$key]['STT'] = $key +1;
            $rs[$key]['Mã khóa học'] = $value['course_code'];
            //$rs[$key]['Ngày nhận tiền'] = date('Y-m-d', $value['date_receive_lakita']);
            $rs[$key]['Giá mua khóa học'] = ($value['price_purchase']);
        }
        echo json_encode($rs);
        die;
    }

}
