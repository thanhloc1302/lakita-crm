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

    function index($offset = 0) {

        $get = $this->input->get();

        $teacher_id = $this->session->userdata['user_id'];

        $teacher_course = $this->_get_all_require_data($teacher_id, '');
        $teacher_course = explode(';', $teacher_course['staffs'][0]['course']);
        
        $data = $this->_get_all_require_data('', $teacher_course);


        if (!count($get)) {
            $conditional['where'] = array(
                'ordering_status_id' => _DONG_Y_MUA_, 'is_hide' => '0', 'date_rgt >=' => strtotime(date('01-m-Y')));
            $conditional['where_in'] = array('course_code' => $teacher_course);
        } else {
            $conditional['where'] = array(
                'sale_level_id' => _DONG_Y_MUA_, 'is_deleted' => '0');
        }
        $conditional['order'] = array('date_rgt' => 'DESC');
        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);
        
        $data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
        $data['contacts'] = $data_pagination['data'];
        $data['total_contact'] = $data_pagination['total_row'];


        $data['left_col'] = array('course_code', 'l8_c3_switch');
        $data['right_col'] = array('date_rgt');
        //  $data['right_col'] = array('date_confirm');
        $this->table .= 'sale provider date_confirm date_expect_receive_cod note_cod action';
        $data['table'] = array('contact_id', 'name', 'phone', 'course_code', 'price_purchase', 'date_rgt'); //array('selection', 'contact_id');

        /*
         * Các file js cần load
         */
        $data['load_js'] = array('common_real_filter_contact');

        $data['titleListContact'] = 'Danh sách contact đã đăng ký';
        $data['actionForm'] = '';
        $data['content'] = 'common/list_contact';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    private function _get_all_require_data($id = '', $course = '') {
        if ($id != '') {
            $require_model = array(
                'staffs' => array(
                    'where' => array(
                        'id' => $id,
                        'role_id' => 8,
                        'active' => 1
                    )
                ),
            );
        }
        if ($course != '') {
            $require_model = array(
                'courses' => array(
                    'where_in' => array(
                        'course_code' => $course),
                    'where' => array(
                        'active' => 1
                    )
                ),
            );
        }
        return array_merge($this->data, $this->_get_require_data($require_model));
    }

    function view_report() {
        $this->load->helper('manager_helper');


        $get = $this->input->get();

        $query = $this->_get_query_condition_arr($get);
        $teacher_id = $this->session->userdata['user_id'];

        $teacher_course = $this->_get_all_require_data($teacher_id, '');
        $teacher_course = explode(';', $teacher_course['staffs'][0]['course']);

        $data = $this->_get_all_require_data('', $teacher_course);

        /* Mảng chứa các level cần lấy, và ngày phát sinh tương ứng */
        $typeReport = array(
            'C3' => 'date_rgt',
            'L1' => 'date_handover',
            'L7' => 'date_confirm',
            'L7.3' => 'date_receive_cancel_cod',
            'L8' => 'date_receive_cod',
            'L9' => 'date_receive_lakita'
        );

        /* Mảng chứa các ngày lẻ */
        if (isset($get['filter_date_happen_from']) && $get['filter_date_happen_from'] != '' && isset($get['filter_date_happen_end']) && $get['filter_date_happen_end'] != '') {
            $startDate = strtotime($get['filter_date_happen_from']);
            $endDate = strtotime($get['filter_date_happen_end']);
            $dateArray = h_get_time_range($startDate, $endDate);
        }


        // <editor-fold defaultstate="collapsed" desc="LỌC THEO TỪNG NGÀY LẺ">
        if (isset($get['filter_date_happen_from']) && $get['filter_date_happen_from'] != '' && isset($get['filter_date_happen_end']) && $get['filter_date_happen_end'] != '') {
            $Report = array();
            foreach ($typeReport as $level => $typeDate) {
                $total = 0;
                foreach ($dateArray as $dayName => $date) {
                    $input = array();
                    $input['select'] = 'price_purchase';
                    if ($level == 'L1') {
                        $input['where'] = array(
                            '(`sale_level_id` = 1 OR `sale_level_id` = ' . _CONTACT_CHAM_SOC_LAI_ .
                            ' OR `sale_level_id` = ' . _TU_CHOI_MUA_ . ''
                            . ' OR `sale_level_id` = ' . _DONG_Y_MUA_ . ')' => 'NO-VALUE');
                    }
                    if ($level == 'L1.1') {
                        $input['where']['sale_level_id'] = _SAI_SO_;
                    }
                    $input['where'][$typeDate . '>='] = $date;
                    $input['where'][$typeDate . '<='] = $date + 24 * 3600 - 1;
                    $input['where']['is_deleted'] = '0';
                    if (isset($get['filter_course_code']) && $get['filter_course_code'] != '') {
                        $input['where_in'] = array('course_code' => $get['filter_course_code']);
                    } else {
                        $input['where_in'] = array('course_code' => $teacher_course);
                    }
                    $input = array_merge_recursive($input, $query['input_get']);
                    $Report[$level][$dayName] = sum_L8($this->contacts_model->load_all($input));
                    $total += $Report[$level][$dayName];
                }
                $Report[$level]['Lũy kế'] = $total;
            }
            $Report3 = $Report;
        }
        // <editor-fold defaultstate="collapsed" desc="THEO TUẦN VÀ THEO THÁNG">
        else {
            //loc
            if (isset($get['filter_month_id']) && $get['filter_month_id'] != '') {
                $start = $get['filter_month_id'];
            } else {
                $start = date('d-m-Y');
            }
            $a = explode('-', $start);

            $num_of_days = date("t", mktime(0, 0, 0, $a[1], 1, $a[2]));
            $lastday = date("t", mktime(0, 0, 0, $a[1], 1, $a[2]));
            $no_of_weeks = 0;
            $count_weeks = 0;
            while ($no_of_weeks < $lastday) {
                $no_of_weeks += 7;
                $count_weeks++;
            }

            $weekArr = array();
            $day_start_week = 0;
            $day_end_week = 0;

            for ($i = 0; $i < $count_weeks; $i++) {
                if ($i != $count_weeks - 1) {
                    $day_start_week += 1;
                    $day_end_week = $day_start_week + 6;

                    $weekArr[$i] = array('month_id' => $a[1] . '-' . $a[2],
                        'week_id' => $i + 1,
                        'start_date' => $day_start_week . '-' . $a[1] . '-' . $a[2],
                        'end_date' => $day_end_week . '-' . $a[1] . '-' . $a[2],
                        'num_day' => $day_end_week - $day_start_week
                    );

                    $day_start_week = $day_end_week;
                } else {
                    $day_start_week += 1;
                    $day_end_week = $lastday;

                    $weekArr[$i] = array('month_id' => $a[1] . '-' . $a[2],
                        'week_id' => $i + 1,
                        'start_date' => $day_start_week . '-' . $a[1] . '-' . $a[2],
                        'end_date' => $lastday . '-' . $a[1] . '-' . $a[2],
                        'num_day' => $lastday - $day_start_week
                    );
                }
            }
            $weekMax = 0;
            $weekFullName = [];
            foreach ($weekArr as $value) {
                $weekFullName[$value['week_id']] = "Tuần " . $value['week_id'] . " (" . str_replace('-', '/', $value['start_date']) . " - " . str_replace('-', '/', $value['end_date']) . ')';
                $weekMax++;
            }
            //loc


            $dateArray = [];

            $Report = array();

            foreach ($typeReport as $level => $typeDate) {
                $total = 0;
                foreach ($weekArr as $week) {
                    $input = array();
                    $input['select'] = 'price_purchase';
                    if ($level == 'L1') {
                        $input['where'] = array(
                            '(`sale_level_id` = 1 OR `sale_level_id` = ' . _CONTACT_CHAM_SOC_LAI_ .
                            ' OR `sale_level_id` = ' . _TU_CHOI_MUA_ . ''
                            . ' OR `sale_level_id` = ' . _DONG_Y_MUA_ . ')' => 'NO-VALUE');
                    }
                    if ($level == 'L1.1') {
                        $input['where']['sale_level_id'] = _SAI_SO_;
                    }
                    $input['where'][$typeDate . '>='] = strtotime($week['start_date']);
                    $input['where'][$typeDate . '<='] = strtotime($week['end_date']) + 24 * 3600 - 1;
                    $input['where']['is_deleted'] = '0';
                    if (isset($get['filter_course_code']) && $get['filter_course_code'] != '') {
                        $input['where_in'] = array('course_code' => $get['filter_course_code']);
                    } else {
                        $input['where_in'] = array('course_code' => $teacher_course);
                    }
                    $input = array_merge_recursive($input, $query['input_get']); // Nếu có lọc khách thì thêm vào điều kiện query
                    // $weekName = 'Tuần ' . $week['week_id'];
                    $weekName = $weekFullName[$week['week_id']];
                    $Report[$level][$weekName]['Thực đạt'] = sum_L8($this->contacts_model->load_all($input));
                    $total += $Report[$level][$weekName]['Thực đạt'];
                }
                $Report[$level]['Tháng']['Thực đạt'] = $total;
                if (!isset($get['filter_month_id'])) {
                    foreach ($dateArray as $dayName => $date) {
                        $input = array();
                        $input['select'] = 'id';
                        if ($level == 'L1') {
                            $input['where'] = array(
                                '(`sale_level_id` = 1 OR `sale_level_id` = ' . _CONTACT_CHAM_SOC_LAI_ .
                                ' OR `sale_level_id` = ' . _TU_CHOI_MUA_ . ''
                                . ' OR `sale_level_id` = ' . _DONG_Y_MUA_ . ')' => 'NO-VALUE');
                        }
                        if ($level == 'L1.1') {
                            $input['where']['sale_level_id'] = _SAI_SO_;
                        }
                        $input['where'][$typeDate . '>='] = $date;
                        $input['where'][$typeDate . '<='] = $date + 24 * 3600 - 1;
                        $input['where']['is_deleted'] = '0';
                        if (isset($get['filter_course_code']) && $get['filter_course_code'] != '') {
                            $input['where_in'] = array('course_code' => $get['filter_course_code']);
                        } else {
                            $input['where_in'] = array('course_code' => $teacher_course);
                        }
                        $input = array_merge_recursive($input, $query['input_get']);
                        $Report[$level][$dayName] = count($this->contacts_model->load_all($input));
                    }
                }
            }


            $Report2 = array();
            foreach ($Report as $key => $value) {
                $Report2[$key]['Tháng'] = $value['Tháng'];
                foreach ($value as $key2 => $value2) {
                    if ($key2 == 'Tháng') {
                        continue;
                    }
                    $Report2[$key][$key2] = $value2;
                }
            }
            $Report = $Report2;
        }
        // </editor-fold>

        $data['Report'] = $Report;
        $data['startDate'] = isset($startDate) ? $startDate : '0';
        $data['endDate'] = isset($endDate) ? $endDate : '0';
        $data['left_col'] = array('month_id_teacher', 'date_happen');
        $data['right_col'] = array('course_code');
        $data['content'] = 'teacher/view_report';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    function top_revenue() {
        $this->load->helper('manager_helper');
        $get = $this->input->get();
        $data = $this->get_data_top_revenue();
        
        $teacher_id = $this->session->userdata['user_id'];

        $teacher_course = $this->_get_all_require_data($teacher_id, '');
        $teacher_course = explode(';', $teacher_course['staffs'][0]['course']);
        
        
        if (!count($get)) {
            $startDate = strtotime(date('01-m-Y'));
            $endDate = mktime(0, 0, 0, date('m') + 1, 0, date('Y'));
        } else {
            if (isset($get['filter_date_happen_from']) && $get['filter_date_happen_from'] != '' && isset($get['filter_date_happen_end']) && $get['filter_date_happen_end'] != '') {
                $startDate = strtotime($get['filter_date_happen_from']);
                $endDate = strtotime($get['filter_date_happen_end']);
            } else if (isset($get['filter_month_id']) && $get['filter_month_id'] != '') {
                $startDate = strtotime('1-' . date('m-Y', strtotime($get['filter_month_id'])));
                $endDate = mktime(0, 0, 0, date('m', strtotime($get['filter_month_id'])) + 1, 0, date('Y', strtotime($get['filter_month_id'])));
            }
        }

        foreach ($teacher_course as $key => $value) {
            $revenue = 0;

                $input = array();
                $input['select'] = 'price_purchase';
                $input['where'] = array('course_code' => $value,
                    'cod_status_id' => _DA_THU_LAKITA_,
                    'date_receive_lakita >=' => $startDate,
                    'date_receive_lakita <' => $endDate);

                $revenue += sum_L8($this->contacts_model->load_all($input));
          
            $data['course_revenue'][$value] = $revenue;
        }

        $data['left_col'] = array('month_id_teacher', 'date_happen');

        //  $data['right_col'] = array('date_confirm');

        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;
        
        
        $data['title_content'] = 'Danh sách đăng ký';
        $data['content'] = 'teacher/top_revenue';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    function array_sort($array, $on, $order = SORT_ASC) {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }

    private function get_data_top_revenue() {
        $require_model = array(
            'staffs' => array(
                'where' => array(
                    'role_id' => 7,
                    'active' => 1
                )
            )
        );
        return array_merge($this->data, $this->_get_require_data($require_model));
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
