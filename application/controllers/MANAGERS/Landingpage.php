<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Channel
 *
 * @author Phạm Ngọc Chuyển <chuyenpn at lakita.vn>
 */
class Landingpage extends MY_Table {

    public function __construct() {
        parent::__construct();
        $this->init();
    }

    public function init() {
        $this->controller_path = 'MANAGERS/landingpage';
        $this->view_path = 'MANAGERS/landingpage';
        $this->sub_folder = 'MANAGERS';
        /*
         * Liệt kê các trường trong bảng
         * - nếu type = text thì không cần khai báo
         * - nếu không muốn hiển thị ra ngoài thì dùng display = none
         * - nếu trường nào cần hiển thị đặc biệt (ngoại lệ) thì để là type = custom
         */
        $list_item = array(
            'id' => array(
                'name_display' => 'ID landingpage'
            ),
            'active' => array(
                'type' => 'binary',
                'name_display' => 'Hoạt động'
            ),
            'landingpage_code' => array(
                'name_display' => 'Mã landing page',
            ),
            'url' => array(
                'type' => 'custom',
                'name_display' => 'URL',
                'order' => '1'
            ),
            'course_code' => array(
                'type' => 'custom',
                'name_display' => 'Mã khóa học',
                'order' => '1'
            ),
            'total_C2' => array(
                'type' => 'currency',
                'name_display' => 'Số C2',
            ),
            'total_C3' => array(
                'name_display' => 'Số C3',
            ),
            'C3pC2' => array(
                'name_display' => 'C3/C2',
            ),
            'price_root' => array(
                'type' => 'currency',
                'name_display' => 'Giá gốc',
                'order' => '1'
            ),
            'price' => array(
                'type' => 'currency',
                'name_display' => 'Giá khuyến mại (giá bán)',
                'order' => '1'
            ), 'marketer_id' => array(
                'name_display' => 'Marketer',
            )
        );
        $this->set_list_view($list_item);
        $this->set_model('landingpage_model');
        $this->load->model('landingpage_model');
    }

    /*
     * Ghi đè hàm xóa lớp cha
     */

    protected function show_table() {
        parent::show_table();
        $get = $this->input->get();
        $date_form = '';
        $date_end = '';
        if ((!isset($get['date_from']) && !isset($get['date_end'])) || (isset($get['date_from']) && $get['date_from'] == '' && $get['date_end'] == '')) {
            $date_form = '0';
            $date_end = time();
        } else {
            $date_form = strtotime($get['date_from']);
            $date_end = strtotime($get['date_end']);
        }

        foreach ($this->data['rows'] as &$value) {
            if ($value['active'] == 1) {
                /*
                 * Lấy số C3 & số tiền tiêu
                 */
                $total_c3 = array();
                $total_c3['select'] = 'id';
                $total_c3['where'] = array(
                    'landingpage_id' => $value['id'],
                    'date_rgt >=' => $date_form,
                    'date_rgt <=' => $date_end + 24 * 3600 - 1);
                $value['total_C3'] = count($this->contacts_model->load_all($total_c3));
                $this->load->model('c2_model');
                $total_c2 = array();
                $total_c2['select'] = 'id';
                $total_c2['where'] = array(
                    'landingpage_id' => $value['id'],
                    'date_rgt >=' => $date_form,
                    'date_rgt <=' => $date_end + 24 * 3600 - 1);
                $value['total_C2'] = count($this->c2_model->load_all($total_c2));
                $value['C3pC2'] = ($value['total_C2'] > 0) ? round($value['total_C3'] / $value['total_C2'] * 100, 2) . '%' : '__';
            } else {
                $value['total_C3'] = '__';
                $value['total_C2'] = '__';
                $value['C3pC2'] = '__';
            }
            $value['marketer_id'] = $this->staffs_model->find_staff_name($value['marketer_id']);
        }
        unset($value);
        usort($this->data['rows'], function($a, $b) {
            if (is_numeric($a['total_C2']) && is_numeric($b['total_C2'])) {
                return $b['total_C2'] - $a['total_C2'];
            } else if (is_numeric($a['total_C2']) && !is_numeric($b['total_C2'])) {
                return -1;
            } else if (!is_numeric($a['total_C2']) && is_numeric($b['total_C2'])) {
                return +1;
            }
        });
        // print_arr($this->data['rows']);
    }

    function delete_item() {
        die('Không thể xóa, liên hệ admin để biết thêm chi tiết');
    }

    function delete_multi_item() {
        show_error_and_redirect('Không thể xóa, liên hệ admin để biết thêm chi tiết', '', FALSE);
    }

    function index($offset = 0) {

        $this->list_filter = array(
            'left_filter' => array(
                'date' => array(
                    'type' => 'custom',
                )
            ),
            'right_filter' => array(
                'active' => array(
                    'type' => 'binary',
                ),
            )
        );
        $conditional = array();
        if ($this->role_id != 5) {
            $conditional['where_in']['marketer_id'] = ['0', $this->user_id];
        }
//        $get = $this->input->get();
//         if(!isset($get['filter_binary_active']) || $get['filter_binary_active'] == '0'){
//            $conditional['where'] = array('active' => 1);
//        }
        $this->set_conditional($conditional);
        $this->set_offset($offset);
        $this->show_table();
        //echoQuery();
        $data = $this->data;
        $data['slide_menu'] = 'marketing/common/slide-menu';
        $data['top_nav'] = 'manager/common/top-nav';
        $data['list_title'] = 'Danh sách các Landingpage';
        $data['edit_title'] = 'Sửa thông tin Landingpage';
        $data['content'] = 'base/index';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    /*
     * Hiển thị modal thêm item
     */

    function show_add_item() {
        /*
         * type mặc định là text nên nếu là text sẽ không cần khai báo
         */
        $this->load->model('courses_model');
        $input = array();
        $input['where'] = array('active' => 1);
        $input['order'] = array('course_code' => 'ASC');
        $courses = $this->courses_model->load_all($input);
        $this->list_add = array(
            'left_table' => array(
                'url' => array(
                ),
                'course_code' => array(
                    'type' => 'array',
                    'value' => $courses,
                )
            ),
            'right_table' => array(
                'price_root' => array(
                ),
                'price' => array(
                ),
                'active' => array(
                )
            ),
        );
        parent::show_add_item();
    }

    function action_add_item() {
        $post = $this->input->post();
        if (!empty($post)) {
            /*
             * Kiểm tra URL đã tồn tại chưa 
             */
            if ($this->{$this->model}->check_exists(array('url' => $post['add_url']))) {
                redirect_and_die('URL đã tồn tại!');
            }
            if ($post['add_active'] != '0' && $post['add_active'] != '1') {
                redirect_and_die('Trạng thái hoạt động là 0 hoặc 1!');
            }
            $paramArr = array('url', 'course_code', 'price_root', 'price', 'active');
            foreach ($paramArr as $value) {
                if (isset($post['add_' . $value])) {
                    $param[$value] = $post['add_' . $value];
                }
            }
            $param['code'] = str_replace('.html', '', str_replace('https://lakita.vn/', '', $param['url']));
            $param['time'] = time();
            $this->{$this->model}->insert($param);
            show_error_and_redirect('Thêm landing page thành công!');
        }
    }

    /*
     * Hiển thị modal sửa item
     */

    function show_edit_item($inputData = []) {
        $this->load->model('courses_model');
        $input = array();
        $input['where'] = array('active' => 1);
        $input['order'] = array('course_code' => 'ASC');
        $courses = $this->courses_model->load_all($input);
        $this->list_edit = array(
            'left_table' => array(
                'url' => array(
                ),
                'course_code' => array(
                    'type' => 'array',
                    'value' => $courses,
                )
            ),
            'right_table' => array(
                'price_root' => array(
                ),
                'price' => array(
                ),
                'active' => array(
                )
            ),
        );
        parent::show_edit_item();
    }

    function action_edit_item($id) {
        $post = $this->input->post();
        if (!empty($post)) {
            /*
             * Kiểm tra mã channel đã tồn tại chưa 
             */
            $input = array();
            $input['where'] = array('id' => $id);
            $curr_code = $this->{$this->model}->load_all($input);
            if ($post['edit_url'] != $curr_code[0]['url'] && $this->{$this->model}->check_exists(array('url' => $post['edit_url']))) {
                redirect_and_die('URL landing page đã tồn tại!');
            }
            $paramArr = array('url', 'course_code', 'price_root', 'price', 'active');
            foreach ($paramArr as $value) {
                if (isset($post['edit_' . $value])) {
                    $param[$value] = $post['edit_' . $value];
                }
            }
            $param['code'] = str_replace('.html', '', str_replace('https://lakita.vn/', '', $param['url']));
            $this->{$this->model}->update($input['where'], $param);
        }
        show_error_and_redirect('Sửa Landing page thành công!');
    }

}
