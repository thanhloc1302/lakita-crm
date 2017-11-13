<?php

/*
 * Copyright (C) 2017 Phạm Ngọc Chuyển <chuyenpn at lakita.vn>
 *
 */

/**
 * Description of Report
 *
 * @author Phạm Ngọc Chuyển <chuyenpn at lakita.vn>
 */
class Report extends MY_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        ini_set('max_execution_time', 300);
        if (!$this->input->is_cli_request()) {
            show_error('Access denied', 403);
        } else {
            echo '1';
        }
    }

    function send_report_sale_daily() {
        $get = [];
        $require_model = array(
            'courses' => array()
        );
        $data = $this->_get_require_data($require_model);
        $input = array();
        $input['where'] = array('role_id' => 1);
        $staffs = $this->staffs_model->load_all($input);

        $conditionArr = array(
            'CHUA_GOI' => array(
                'where' => array('call_status_id' => '0'),
                'sum' => 0
            ),
            'L1' => array(
                'where' => array('date_handover >=' => strtotime(date("d-m-Y"))),
                'sum' => 0
            ),
            'L2' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'date_handover >=' => strtotime(date("d-m-Y"))),
                'sum' => 0
            ),
            'L6' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_,
                    'date_handover >=' => strtotime(date("d-m-Y"))),
                'sum' => 0
            ),
            'L8' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_,
                    'cod_status_id' => _DA_THU_LAKITA_, 'date_handover >=' => strtotime(date("d-m-Y"))),
                'sum' => 0
            ),
            'LC' => array(
                'where' => array('(`call_status_id` = ' . _SO_MAY_SAI_ . ' OR `call_status_id` = ' . _NHAM_MAY_ .
                    ' OR `ordering_status_id` = ' . _CONTACT_CHET_ . ')' => 'NO-VALUE',
                    'date_handover >=' => strtotime(date("d-m-Y"))),
                'sum' => 0
            ),
            'CON_CUU_DUOC' => array(
                'where' => array('(`call_status_id` = ' . _KHONG_NGHE_MAY_ .
                    ' OR `ordering_status_id` in (' . _BAN_GOI_LAI_SAU_ . ' , ' . _CHAM_SOC_SAU_MOT_THOI_GIAN_ . ',' . _LAT_NUA_GOI_LAI_ . '))' => 'NO-VALUE',
                    'date_handover >=' => strtotime(date("d-m-Y"))),
                'sum' => 0
            ),
            'DANG_GIAO_HANG' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_,
                    'cod_status_id' => _DANG_GIAO_HANG_, 'date_handover >=' => strtotime(date("d-m-Y"))),
                'sum' => 0
            ),
            'HUY_DON' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_,
                    'cod_status_id' => _HUY_DON_, 'date_handover >=' => strtotime(date("d-m-Y"))),
                'sum' => 0
            ),
            'TU_CHOI_MUA' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _TU_CHOI_MUA_,
                    'date_handover >=' => strtotime(date("d-m-Y"))),
                'sum' => 0
            ),
            'DA_THU_COD' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_,
                    'cod_status_id' => _DA_THU_COD_, 'date_handover >=' => strtotime(date("d-m-Y"))),
                'sum' => 0
            ),
            'L1_luyke' => array(
                'where' => array('date_handover >=' => strtotime(date("1-m-Y"))),
                'sum' => 0
            ),
            'L2_luyke' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'date_handover >=' => strtotime(date("1-m-Y"))),
                'sum' => 0
            ),
            'L6_luyke' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_,
                    'date_handover >=' => strtotime(date("1-m-Y"))),
                'sum' => 0
            ),
            'L8_luyke' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_,
                    'cod_status_id' => _DA_THU_LAKITA_, 'date_handover >=' => strtotime(date("1-m-Y"))),
                'sum' => 0
            ),
            'LC_luyke' => array(
                'where' => array('(`call_status_id` = ' . _SO_MAY_SAI_ . ' OR `call_status_id` = ' . _NHAM_MAY_ .
                    ' OR `ordering_status_id` = ' . _CONTACT_CHET_ . ')' => 'NO-VALUE',
                    'date_handover >=' => strtotime(date("1-m-Y"))),
                'sum' => 0
            ),
            'CON_CUU_DUOC_luyke' => array(
                'where' => array('(`call_status_id` = ' . _KHONG_NGHE_MAY_ .
                    ' OR `ordering_status_id` in (' . _BAN_GOI_LAI_SAU_ . ' , ' . _CHAM_SOC_SAU_MOT_THOI_GIAN_ . ',' . _LAT_NUA_GOI_LAI_ . '))' => 'NO-VALUE',
                    'date_handover >=' => strtotime(date("1-m-Y"))),
                'sum' => 0
            ),
            'DANG_GIAO_HANG_luyke' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_,
                    'cod_status_id' => _DANG_GIAO_HANG_, 'date_handover >=' => strtotime(date("1-m-Y"))),
                'sum' => 0
            ),
            'HUY_DON_luyke' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_,
                    'cod_status_id' => _HUY_DON_, 'date_handover >=' => strtotime(date("1-m-Y"))),
                'sum' => 0
            ),
            'TU_CHOI_MUA_luyke' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _TU_CHOI_MUA_,
                    'date_handover >=' => strtotime(date("1-m-Y"))),
                'sum' => 0
            ),
            'DA_THU_COD_luyke' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_,
                    'cod_status_id' => _DA_THU_COD_, 'date_handover >=' => strtotime(date("1-m-Y"))),
                'sum' => 0
            ),
        );

        foreach ($staffs as $key => $value) {
            foreach ($conditionArr as $key2 => $value2) {
                $conditional = array();
                $conditional['where']['sale_staff_id'] = $value['id'];
                foreach ($value2['where'] as $key3 => $value3) {
                    $conditional['where'][$key3] = $value3;
                }
                $staffs[$key][$key2] = $this->_query_for_report($get, $conditional);
                $conditionArr[$key2]['sum'] += $staffs[$key][$key2];
            }
        }

        // print_arr($conditionArr);

        foreach ($conditionArr as $key => $value) {
            $data[$key] = $value['sum'];
        }

        $data['staffs'] = $staffs;
        $data['content'] = 'report/send_report';
        $this->load->view('report/send_report', $data);
    }

    function send_report_revenue_daily() {
        $this->load->helper('manager_helper');

        $input = array();
        $this->load->model('courses_model');
        $courses = $this->courses_model->load_all($input);
        $conditionArr = array(
            'L7' => array(
                'where' => array('date_receive_cod >=' => strtotime(date('d-m-Y')),
                    'cod_status_id' => _DA_THU_COD_
                ),
                'sum' => 0
            ),
            'L8' => array(
                'where' => array('date_receive_lakita >=' => strtotime(date('d-m-Y')),
                    'cod_status_id' => _DA_THU_LAKITA_
                ),
                'sum' => 0
            ),
            'L7_luyke' => array(
                'where' => array('date_receive_cod >=' => strtotime(date('01-m-Y')),
                    'cod_status_id' => _DA_THU_COD_
                ),
                'sum' => 0
            ),
            'L8_luyke' => array(
                'where' => array('date_receive_lakita >=' => strtotime(date('01-m-Y')),
                    'cod_status_id' => _DA_THU_LAKITA_
                ),
                'sum' => 0
            ),
        );
        $L7L8 = 0;
        $L7L8_luyke = 0;
        foreach ($courses as $key => $value) {
            foreach ($conditionArr as $key2 => $value2) {
                $conditional = array();
                $conditional['select'] = 'course_code, cod_status_id, price_purchase';
                $conditional['where']['course_code'] = $value['course_code'];
                foreach ($value2['where'] as $key3 => $value3) {
                    $conditional['where'][$key3] = $value3;
                }
                $_L7 = $this->contacts_model->load_all($conditional);
                $courses[$key][$key2] = sum_L8($_L7);
                $conditionArr[$key2]['sum'] += $courses[$key][$key2];
            }
            $courses[$key]['L7L8'] = $courses[$key]['L7'] + $courses[$key]['L8'];
            $L7L8 += $courses[$key]['L7L8'];
            $courses[$key]['L7L8_luyke'] = $courses[$key]['L7_luyke'] + $courses[$key]['L8_luyke'];
            $L7L8_luyke += $courses[$key]['L7L8_luyke'];
        }
        foreach ($conditionArr as $key => $value) {
            $data[$key] = $value['sum'];
        }

        $data['L7L8'] = $L7L8;
        $data['L7L8_luyke'] = $L7L8_luyke;
        $data['courses'] = $courses;
        $this->load->view('report/view_report_revenue', $data);
    }

    public function pending2() {

        require_once APPPATH . 'libraries/simple_html_dom.php';
        $this->load->model('viettel_log_model');
        $input = array();
        $input['distinct'] = 'code_cross_check';
        $input['where'] = array('cod_status_id' => _DANG_GIAO_HANG_, 'is_hide' => '0', 'provider_id' => 1);
        $input['order'] = array('date_print_cod' => 'DESC');
        $contacts = $this->contacts_model->load_all($input);
        foreach ($contacts as $contact) {
            $html = file_get_html('https://www.viettelpost.com.vn/Tracking?KEY=' . $contact['code_cross_check']);
            /*
             * Cập nhật trạng thái giao hàng viettel
             */
            if (!is_object($html->find('div[id=dnn_ctr507_Main_ViewKQ_PanelItem]', 0))) {
                continue;
            }
            $stt = $html->find('div[id=dnn_ctr507_Main_ViewKQ_PanelItem]', 0)->find("#dnn_ctr507_Main_ViewKQ_RepeaterView_Label5_0", 0)->plaintext;
            $where = ['code_cross_check' => $contact['code_cross_check']];
            $data = ['viettel_tracking_status' => $stt];
            $this->contacts_model->update($where, $data);

            /*
             * Chèn data vào bảng log
             */
            $rs = $html->find('div[id=dnn_ctr507_Main_ViewKQ_PanelItem] ul', 0);
            if (is_object($rs)) {
                foreach ($rs->find('li') as $row) {
                    $code_cross_check = $contact['code_cross_check'];
                    $dateInfo = strtotime(str_replace('/', '-', $row->find('span', 0)->plaintext));
                    $status = $row->find('span', 1)->plaintext;
                    $destination = $row->find('span', 2)->plaintext;
                    $insert = array(
                        'code_cross_check' => $code_cross_check,
                        'date_info' => $dateInfo,
                        'status' => $status,
                        'destination' => $destination
                    );
                    $input = array();
                    $input['where'] = ['code_cross_check' => $code_cross_check, 'date_info' => $dateInfo];
                    if (empty($this->viettel_log_model->load_all($input))) {
                        $this->viettel_log_model->insert($insert);
                    }
                }
            }
        }
    }

    public function pending3() {
        $this->load->helper('bill_helper');
        $this->load->model('call_log_model');
        $this->load->model('L7_check_model');


        $input = array();
        $input['select'] = 'code_cross_check';
        $input['where'] = array('cod_status_id' => _DANG_GIAO_HANG_, 'is_hide' => '0', 'provider_id' => 1);
        $contacts = $this->contacts_model->load_all($input);

        $all_code_cross_check = [];

        require_once APPPATH . 'libraries/simple_html_dom.php';
        $trackingText = '';
        foreach ($contacts as $value) {
            $trackingText .= $value['code_cross_check'] . ',';
            $all_code_cross_check[] = $value['code_cross_check'];
        }
        $html = file_get_html('https://www.viettelpost.com.vn/Tracking?KEY=' . $trackingText);
        $rs = $html->find('div[id=dnn_ctr507_Main_ViewKQ_PanelList]', 0);
        $contact_warning = array();
        $contact_other = array();
        $contact_success = array();
        $contact_cancel = array();
        $contact_other_key = 0;
        $viettel_code_cross_check = [];
        foreach ($rs->find('tr') as $key => $row) {
            if ($key == 0) {
                continue;
            }
            $code_cross_check = trim($row->find('td', 0)->plaintext);
            $status_date = strtotime(str_replace('/', '-', trim($row->find('td', 4)->plaintext)));
            $status = trim($row->find('td', 5)->plaintext);
            $weight = trim($row->find('td', 6)->plaintext);
            $viettel_code_cross_check[] = $code_cross_check;
            if ($status == 'Thanh cong - phat thanh cong' || $status == 'Phát thành công') {
                $where = array('code_cross_check' => $code_cross_check);
                $data = array('cod_status_id' => _DA_THU_COD_, 'date_receive_cod' => time(), 'last_activity' => time());
                $this->contacts_model->update($where, $data);
                $input_success = array();
                $input_success['select'] = 'id, name, email, phone, address, price_purchase, date_rgt, code_cross_check';
                $input_success['where'] = array('code_cross_check' => $code_cross_check, 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_);
                $contactSuccessArr = $this->contacts_model->load_all($input_success);
                foreach ($contactSuccessArr as $contactSuccess) {
                    $contact_success[] = $contactSuccess;
                }
            } else if ($status == 'Thanh cong chuyen tra nguoi gui' || $status == 'CHuyển trả người gửi') {
                $where = array('code_cross_check' => $code_cross_check);
                $data = array('cod_status_id' => _HUY_DON_, 'date_receive_cancel_cod' => time(), 'last_activity' => time());
                $this->contacts_model->update($where, $data);
                $input_cancel = array();
                $input_cancel['select'] = 'id, name, email, phone, address, price_purchase, date_rgt, code_cross_check';
                $input_cancel['where'] = array('code_cross_check' => $code_cross_check, 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_);
                $contactCancelArr = $this->contacts_model->load_all($input_cancel);
                foreach ($contactCancelArr as $contactCancel) {
                    $contact_cancel[] = $contactCancel;
                }
            } else if ($status == 'Chờ duyệt Chuyển hoàn') {
                $input_warning = array();
                $input_warning['select'] = 'id, name, email, phone, address, price_purchase, date_rgt, code_cross_check';
                $input_warning['where'] = array('code_cross_check' => $code_cross_check, 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_);
                $contactWarningArr = $this->contacts_model->load_all($input_warning);
                foreach ($contactWarningArr as $contactWarning) {
                    $contact_warning[] = $contactWarning;
                }
            } else {
                $input_other = array();
                $input_other['select'] = 'id, name, email, phone, address, price_purchase, date_rgt, code_cross_check';
                $input_other['where'] = array('code_cross_check' => $code_cross_check, 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_);
                $contactOtherArr = $this->contacts_model->load_all($input_other);
                foreach ($contactOtherArr as $contactOther) {
                    $contact_other[$contact_other_key] = $contactOther;
                    $contact_other[$contact_other_key]['status_viettel'] = $status;
                    $contact_other_key++;
                }
            }

            if ($status == 'Thanh cong - phat thanh cong' || $status == 'Phát thành công' || $status == 'Thanh cong chuyen tra nguoi gui' || $status == 'CHuyển trả người gửi') {
                $input = array();
                $input['select'] = 'code_cross_check, price_purchase, name, phone, address, id';
                $input['where'] = array('code_cross_check' => $code_cross_check, 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_);
                $contact = $this->contacts_model->load_all($input);
                $contact_id = $contact[0]['id'];
                $name = $contact[0]['name'];
                $phone = $contact[0]['phone'];
                $address = $contact[0]['address'];
                $price_purchase = $contact[0]['price_purchase'];
                $insert = array('code' => $code_cross_check, 'status' => $status, 'weight' => $weight, 'status_date' => $status_date,
                    'contact_id' => $contact_id, 'name' => $name, 'phone' => $phone, 'address' => $address,
                    'price_purchase' => $price_purchase, 'time' => time(), 'L7_check' => 1);
                $this->L7_check_model->insert($insert);

                /*
                 * Cập nhật lịch sử chăm sóc
                 */
                if ($status == 'Thanh cong - phat thanh cong' || $status == 'Phát thành công') {
                    $cod_status_id = _DA_THU_COD_;
                }
                if ($status == 'Thanh cong chuyen tra nguoi gui' || $status == 'CHuyển trả người gửi') {
                    $cod_status_id = _HUY_DON_;
                }
                $param['contact_id'] = $contact_id;
                $param['staff_id'] = 33;
                $param['cod_status_id'] = $cod_status_id;
                $param['time'] = time();
                $this->call_log_model->insert($param);
            }
        }



        $vietel_not_send = array_diff($all_code_cross_check, $viettel_code_cross_check);
        $contact_not_send = array();
        if (!empty($vietel_not_send)) {

            $vietel_not_send = ReArrangeBillCheck($vietel_not_send);

            foreach ($vietel_not_send as $code_cross_check) {
                $input_not_send = array();
                $input_not_send['select'] = 'id, name, email, phone, address, price_purchase, date_rgt, code_cross_check';
                $input_not_send['where'] = array('code_cross_check' => $code_cross_check, 'call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_);
                $contact_not_send[] = $this->contacts_model->load_all($input_not_send)[0];
            }
        }

        $data_load = [];
        $data_load['total_contacts'] = count($contacts);
        $data_load['contacts'] = ReArrangeContactsByBillCheck($contact_warning);
        $data_load['contact_other'] = ReArrangeContactsByBillCheck($contact_other);
        $data_load['contact_success'] = ReArrangeContactsByBillCheck($contact_success);
        $data_load['contact_cancel'] = ReArrangeContactsByBillCheck($contact_cancel);
        $data_load['contact_not_send'] = ReArrangeContactsByBillCheck($contact_not_send);
        $str = $this->load->view('cod/waiting_cancel_list/index', $data_load, true);
        //$emailTo = 'chuyenpn@lakita.vn';
        $emailTo = 'chuyenpn@lakita.vn, ngoccongtt1@gmail.com, trinhnv@lakita.vn, tund@bkindex.com, hoangthuy100995@gmail.com, lakitavn@gmail.com';
        $this->load->library("email");
        $this->email->from('cskh@lakita.vn', "lakita.vn");
        $this->email->to($emailTo);
        $this->email->subject('Các contact chờ duyệt chuyển hoàn (nguy cơ hủy đơn) ngày ' . date('d-m-Y') . ' (by cron job)');
        $this->email->message($str);
        $this->email->send();
    }

    function send_report_product_daily() {
        $get = [];
        $input = array();
        $this->load->model('courses_model');
        $courses = $this->courses_model->load_all($input);

        $conditionArr = array(
            'L1' => array(
                'where' => array('date_handover >=' => strtotime(date("d-m-Y"))),
                'sum' => 0
            ),
            'L2' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'date_handover >=' => strtotime(date("d-m-Y"))),
                'sum' => 0
            ),
            'L6' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_,
                    'date_handover >=' => strtotime(date("d-m-Y"))),
                'sum' => 0
            ),
            'L8' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_,
                    'cod_status_id' => _DA_THU_LAKITA_, 'date_handover >=' => strtotime(date("d-m-Y"))),
                'sum' => 0
            ),
            'L1_luyke' => array(
                'where' => array('date_handover >=' => strtotime(date("1-m-Y"))),
                'sum' => 0
            ),
            'L2_luyke' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'date_handover >=' => strtotime(date("1-m-Y"))),
                'sum' => 0
            ),
            'L6_luyke' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_,
                    'date_handover >=' => strtotime(date("1-m-Y"))),
                'sum' => 0
            ),
            'L8_luyke' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_,
                    'cod_status_id' => _DA_THU_LAKITA_, 'date_handover >=' => strtotime(date("1-m-Y"))),
                'sum' => 0
            ),
        );

        foreach ($courses as $key => $value) {
            foreach ($conditionArr as $key2 => $value2) {
                $conditional = array();
                $conditional['where']['course_code'] = $value['course_code'];
                foreach ($value2['where'] as $key3 => $value3) {
                    $conditional['where'][$key3] = $value3;
                }
                $courses[$key][$key2] = $this->_query_for_report($get, $conditional);
                $conditionArr[$key2]['sum'] += $courses[$key][$key2];
            }
        }

        // print_arr($conditionArr);

        foreach ($conditionArr as $key => $value) {
            $data[$key] = $value['sum'];
        }

        $data['courses'] = $courses;
        $this->load->view('report/send_report_product_daily', $data);
    }

    function view_general_report() {
        $this->load->helper('manager_helper');
        $input = array();
        $this->load->model('courses_model');
        $courses = $this->courses_model->load_all($input);
        $get = [];
        $conditionArr = array(
            'L1_td' => array(
                'where' => array('date_handover >=' => strtotime(date("d-m-Y"))),
                'sum' => 0
            ),
            'L2_td' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'date_handover >=' => strtotime(date("d-m-Y"))),
                'sum' => 0
            ),
            'L6_td' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_, 'date_handover >=' => strtotime(date("d-m-Y"))),
                'sum' => 0
            ),
            'L1' => array(
                'where' => array('date_handover >=' => strtotime(date("01-m-Y"))),
                'sum' => 0
            ),
            'L2' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'date_handover >=' => strtotime(date("01-m-Y"))),
                'sum' => 0
            ),
            'L6' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_, 'date_handover >=' => strtotime(date("01-m-Y"))),
                'sum' => 0
            ),
            'L8' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_,
                    'cod_status_id' => _DA_THU_LAKITA_, 'date_handover >=' => strtotime(date("01-m-Y"))),
                'sum' => 0
            )
        );

        $sumL8 = 0;
        foreach ($courses as $key => $value) {

            /*
             * Tính số L1, L2, L6, L8 theo từng khóa học
             */

            foreach ($conditionArr as $key2 => $value2) {
                $conditional = array();
                $conditional['where']['course_code'] = $value['course_code'];
                if (isset($value2['where'])) {
                    foreach ($value2['where'] as $key3 => $value3) {
                        $conditional['where'][$key3] = $value3;
                    }
                }
                $courses[$key][$key2] = $this->_query_for_report($get, $conditional);
                $conditionArr[$key2]['sum'] += $courses[$key][$key2];
            }

//            if ($courses[$key]['L1'] == 0 || $courses[$key]['L1_td'] == 0) {
//                unset($courses[$key]);
//                continue;
//            }

            $courses[$key]['L2/L1_td'] = ($courses[$key]['L1_td'] != 0) ? round(($courses[$key]['L2_td'] / $courses[$key]['L1_td']) * 100, 2) . '%' : 'Không thể chia cho 0';
            $courses[$key]['L6/L2_td'] = ($courses[$key]['L2_td'] != 0) ? round(($courses[$key]['L6_td'] / $courses[$key]['L2_td']) * 100, 2) . '%' : 'Không thể chia cho 0';

            $courses[$key]['L2/L1'] = ($courses[$key]['L1'] != 0) ? round(($courses[$key]['L2'] / $courses[$key]['L1']) * 100, 2) . '%' : 'Không thể chia cho 0';
            $courses[$key]['L6/L2'] = ($courses[$key]['L2'] != 0) ? round(($courses[$key]['L6'] / $courses[$key]['L2']) * 100, 2) . '%' : 'Không thể chia cho 0';
            $courses[$key]['L8/L6'] = ($courses[$key]['L6'] != 0) ? round(($courses[$key]['L8'] / $courses[$key]['L6']) * 100, 2) . '%' : 'Không thể chia cho 0';
            $courses[$key]['L8/L1'] = ($courses[$key]['L1'] != 0) ? round(($courses[$key]['L8'] / $courses[$key]['L1']) * 100, 2) . '%' : 'Không thể chia cho 0';


            /*
             * Tính doanh thu theo từng khóa học
             */
            $conditional = array();
            $conditional['select'] = 'course_code, cod_status_id, price_purchase';
            $conditional['where']['date_handover >='] = strtotime(date('01-m-Y'));
            $conditional['where']['course_code'] = $value['course_code'];
            $conditional['where']['cod_status_id'] = _DA_THU_LAKITA_;
            $_L8 = $this->contacts_model->load_all($conditional);
            $money = sum_L8($_L8);
            $courses[$key]['sumL8'] = number_format($money, 0, ",", ".") . " VNĐ";
            $sumL8 += $money;
        }
        // echo $this->db->last_query();

        foreach ($conditionArr as $key => $value) {
            $data[$key] = $value['sum'];
        }
        $data['sumL8'] = $sumL8;
        $data['courses'] = $courses;
        $data['content'] = 'report/view_general_report';

        // $this->load->view('report/view_general_report', $data);

        $str = $this->load->view('report/view_general_report', $data, true);
        $this->load->library("email");
        $this->email->from('cskh@lakita.vn', "lakita.vn");
        //$emailTo = 'chuyenbka@gmail.com';
        $emailTo = 'chuyenbka@gmail.com, ngoccongtt1@gmail.com, trinhnv@lakita.vn, tund@bkindex.com, hoangthuy100995@gmail.com, lakitavn@gmail.com';
        $this->email->to($emailTo);
        $this->email->subject('Báo cáo tổng hợp ngày ' . date('d-m-Y') . ' (by cron job)');
        $this->email->message($str);
        $this->email->send();
    }

    function json_pivot_table() {
        $this->load->model('call_status_model');
        $this->load->model('ordering_status_model');
        $this->load->model('cod_status_model');
        $this->load->model('providers_model');
        $this->load->model('payment_method_rgt_model');
        $input = array();
        $input['select'] = 'call_status_id, ordering_status_id, cod_status_id, sale_staff_id, course_code, '
                . 'provider_id, date_rgt, price_purchase, payment_method_rgt, date_receive_lakita';
        $input['where'] = array('date_rgt >=' => 1483203600, 'is_hide' => '0');
        $test = $this->contacts_model->load_all($input);
        $rs = [];
        foreach ($test as $key => $value) {
            $rs[$key]['C3'] = '1';
            $rs[$key]['L2'] = ($value['call_status_id'] == 4) ? '1' : '0';
            $rs[$key]['L6'] = ($value['ordering_status_id'] == 4) ? '1' : '0';
            $rs[$key]['L7'] = ($value['cod_status_id'] == 2) ? '1' : '0';
            $rs[$key]['L7L8'] = ($value['cod_status_id'] == 3 || $value['cod_status_id'] == 2) ? '1' : '0';
            $rs[$key]['L8'] = ($value['cod_status_id'] == 3) ? '1' : '0';
            $rs[$key]['TVTS'] = $this->staffs_model->find_staff_name($value['sale_staff_id']);
            $rs[$key]['Mã khóa học'] = $value['course_code'];
            //  $rs[$key]['Trạng thái gọi'] = $this->call_status_model->find_call_status_desc($value['call_status_id']);
            //$rs[$key]['Trạng thái đơn hàng'] = $this->ordering_status_model->find_ordering_status_desc($value['ordering_status_id']);
            //$rs[$key]['Trạng thái giao hàng'] = $this->cod_status_model->find_cod_status_desc($value['cod_status_id']);
            $rs[$key]['Đơn vị giao hàng'] = $this->providers_model->find_provider_name($value['provider_id']);
            $rs[$key]['Tháng đăng ký'] = date('Y-m', $value['date_rgt']);
            $rs[$key]['Tháng nhận tiền'] = date('Y-m', $value['date_receive_lakita']);
            $rs[$key]['Ngày đăng ký'] = date('Y-m-d', $value['date_rgt']);
            $rs[$key]['Giá mua khóa học'] = ($value['price_purchase']);
            $rs[$key]['Hinh thức thanh toán'] = $this->payment_method_rgt_model->find_payment_method_rgt_desc($value['payment_method_rgt']);
        }
        echo $response = json_encode($rs);
        die;
        $fp = fopen(APPPATH . '../public/results.json', 'w');
        fwrite($fp, json_encode($response));
        fclose($fp);
        die;
    }

    function json_pivot_table_2($offset = 0) {
        $get = $this->input->get();
        $this->load->model('call_status_model');
        $this->load->model('ordering_status_model');
        $this->load->model('cod_status_model');
        $this->load->model('providers_model');
        $this->load->model('payment_method_rgt_model');
        $conditional['select'] = 'phone, cod_status_id, sale_staff_id, course_code, '
                . 'provider_id, date_rgt, price_purchase, payment_method_rgt, date_receive_lakita';
        if ((isset($get['filter_date_date_rgt']) && $get['filter_date_date_rgt'] == '')) {
            $conditional['where'] = array('date_rgt >=' => strtotime(date('Y-m-01 00:00:00')), 'cod_status_id' => 3, 'is_hide' => '0');
        } else {
            $conditional['where'] = array('cod_status_id' => 3, 'is_hide' => '0');
        }
        $data_pagination = $this->_query_all_from_get($get, $conditional, 10000, $offset);
        $contacts = $data_pagination['data'];
        $rs = [];
        foreach ($contacts as $key => $value) {
            $rs[$key]['TVTS'] = $this->staffs_model->find_staff_name($value['sale_staff_id']);
            $rs[$key]['Mã khóa học'] = $value['course_code'];
            $rs[$key]['Ngày đăng ký'] = date('Y-m-d', $value['date_rgt']);
            $rs[$key]['Giá mua khóa học'] = ($value['price_purchase']);
        }
        echo json_encode($rs);
        die;
    }

    function view_pivot_table() {
        $this->load->view('pivot_table');
    }

}
