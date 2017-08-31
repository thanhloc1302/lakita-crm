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

    function send_report_sale_daily() {
        $require_model = array(
            'courses' => array()
        );
        $data = $this->_get_require_data($require_model);
        $get = $this->input->get();
        if (empty($get) || $get['key'] != 'ACOPDreqidsadfs') {
            die;
        }
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
        $get = $this->input->get();
        if (empty($get) || $get['key'] != 'ACOPDreqidsadfs') {
            die;
        }
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

    function send_report_product_daily() {
        $get = $this->input->get();
        if (empty($get) || !isset($get['key']) || $get['key'] != 'ACOPDreqidsadfs') {
            die;
        }
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
        $get = $this->input->get();
        if (empty($get) || $get['key'] != 'ACOPDreqidsadfs') {
            die;
        }
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
        $emailTo = 'chuyenbka@gmail.com, ngoccongtt1@gmail.com, '
                . 'trinhnv@bkindex.com, tund@bkindex.com';
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

    function view_pivot_table() {
        $this->load->view('pivot_table');
    }

}
