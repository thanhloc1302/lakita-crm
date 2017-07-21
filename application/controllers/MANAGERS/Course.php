<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Course
 *
 * @author CHUYENPN
 */
class Course extends MY_Table {

    public function __construct() {
        parent::__construct();
        $this->init();
    }

    public function init() {
        $this->controller_path = 'MANAGERS/course';
        $this->view_path  = 'MANAGERS/course';
        $this->sub_folder = 'MANAGERS';
        $list_view = array(
            'id' => array(
                'name_display' => 'ID khóa học',
                'order' => '1'
            ),
            'course_code' => array(
                'name_display' => 'Mã khóa học',
                'order' => '1'
            ),
            'name_course' => array(
                'name_display' => 'Tên khóa học',
                'order' => '1'
            ),
            'price' => array(
                'type' => 'currency',
                'name_display' => 'Giá gốc',
                'order' => '1',
            //'display' => 'none'
            ),
            'active' => array(
                'type' => 'custom',
                'name_display' => 'Hoạt động'),
        );
        $this->set_list_view($list_view);
        $this->set_model('courses_model');
        $this->load->model('courses_model');
    }

    public function index($offset = 0) {
        $conditional = array();
        $this->set_conditional($conditional);
        $this->set_offset($offset);
        $this->show_table();
        $data = $this->data;
        $data['slide_menu'] = 'cod/common/slide-menu';
        $data['top_nav'] = 'cod/common/top-nav';
        $data['list_title'] = 'Danh sách các khóa học';
        $data['edit_title'] = 'Sửa thông tin khóa học';
        $data['content'] = 'base/index';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    function edit_item() {
        /*
         * type mặc định là text nên nếu là text sẽ không cần khai báo
         */
        $this->list_edit = array(
            'left_table' => array(
                'id' => array(
                    'type' => 'disable'
                ),
                'course_code' => array(),
                'name_course' => array()
            ),
            'right_table' => array(
                'course_code' => array(),
                'active' => array()
            ),
        );
        parent::edit_item();
    }

    protected function show_table() {
        parent::show_table();
        /*
         * Nếu có điều kiện đặc biệt thì thêm vào $row class css đặc biệt khi hiển thị
         * ví dụ: giá khóa học lớn hơn 4 triệu thì báo đỏ
         */
        foreach ($this->data['rows'] as &$value) {
            if ($value['price'] > 4000000) {
                $value['warning_class'] = 'duplicate';
            }
        }
        unset($value);
    }

}
