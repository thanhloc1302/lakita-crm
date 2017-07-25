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
class Marketer extends MY_Table {

    public function __construct() {
        parent::__construct();
        $this->init();
    }

    public function init() {
        $this->controller_path = 'MANAGERS/marketer';
        $this->view_path = 'MANAGERS/marketer';
        $this->sub_folder = 'MANAGERS';
        $list_view = array(
            'id' => array(
                'name_display' => 'ID marketer',
                'order' => '1'
            ),
            'username' => array(
                'name_display' => 'Username',
                'order' => '1'
            ),
            'name' => array(
                'name_display' => 'Họ tên',
                'order' => '1'
            ),
            'email' => array(
                'name_display' => 'Email',
                'order' => '1'
            ),
            'phone' => array(
                'name_display' => 'Số điện thoại',
                'order' => '1'
            ),
            'active' => array(
                'type' => 'custom',
                'name_display' => 'Hoạt động',
                'order' => '1'
            ),
            'password' => array(
                'name_display' => 'Mật khẩu',
                'display' => 'none'
            ),
            're_password' => array(
                'name_display' => 'Nhập lại mật khẩu',
                'display' => 'none'
            )
        );
        $this->set_list_view($list_view);
        $this->set_model('staffs_model');
    }

    protected function show_table() {
        parent::show_table();
        /*
         * Nếu có điều kiện đặc biệt thì thêm vào $row class css đặc biệt khi hiển thị
         * ví dụ: giá khóa học lớn hơn 4 triệu thì báo đỏ
         */
        foreach ($this->data['rows'] as &$value) {
            if ($value['active'] == 0) {
                $value['warning_class'] = 'inactive';
            }
        }
        unset($value);
    }
    
     /*
     * Ghi đè hàm xóa lớp cha
     */

    function delete_item() {
        die('Không thể xóa, liên hệ admin để biết thêm chi tiết');
    }

    function delete_multi_item() {
        show_error_and_redirect('Không thể xóa, liên hệ admin để biết thêm chi tiết', '', FALSE);
    }


    public function index($offset = 0) {
        $conditional = array('where' => array('role_id' => '6'));
        $this->set_conditional($conditional);
        $this->set_offset($offset);
        $this->show_table();
        $data = $this->data;
        $data['slide_menu'] = 'marketing/common/slide-menu';
        $data['top_nav'] = 'marketing/common/top-nav';
        $data['list_title'] = 'Danh sách các Marketer';
        $data['edit_title'] = 'Sửa thông tin Marketer';
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
        $this->list_add = array(
            'left_table' => array(
                'username' => array(
                ),
                'password' => array(
                    'type' => 'password'
                ),
                're_password' => array(
                    'type' => 'password'
                )
            ),
            'right_table' => array(
                'name' => array(
                ),
                'email' => array(
                ),
                'phone' => array(
                ),
                'active' => array(
                ),
            ),
        );
        parent::show_add_item();
    }

    function action_add_item() {
        $post = $this->input->post();
        if (!empty($post)) {
            if ($this->{$this->model}->check_exists(array('username' => $post['add_username']))) {
                redirect_and_die('username đã tồn tại!');
            }
            if ($post['add_active'] != '0' && $post['add_active'] != '1') {
                redirect_and_die('Trạng thái hoạt động là 0 hoặc 1!');
            }
            if ($post['add_password'] != $post['add_re_password']) {
                redirect_and_die('Mật khẩu xác nhận không đúng!');
            }
            $paramArr = array('username', 'name', 'email', 'phone', 'active');
            foreach ($paramArr as $value) {
                if (isset($post['add_' . $value])) {
                    $param[$value] = $post['add_' . $value];
                }
            }
            $param['role_id'] = 6;
            $param['password'] = md5(md5($post['add_password']));
            $this->{$this->model}->insert($param);
            show_error_and_redirect('Thêm marketer thành công!');
        }
    }

    function show_edit_item() {
        /*
         * type mặc định là text nên nếu là text sẽ không cần khai báo
         */
        $this->list_edit = array(
            'left_table' => array(
                'id' => array(
                    'type' => 'disable'
                ),
                'username' => array(),
                'password' => array(
                    'type' => 'password'
                ),
                're_password' => array(
                    'type' => 'password'
                )
            ),
            'right_table' => array(
                'name' => array(),
                'email' => array(),
                'phone' => array(
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
            $input = array();
            $input['where'] = array('id' => $id);
            $curr_item = $this->{$this->model}->load_all($input);
            if ($post['edit_username'] != $curr_item[0]['username'] && $this->{$this->model}->check_exists(array('username' => $post['edit_username']))) {
                redirect_and_die('Username đã tồn tại!');
            }
            if ($post['edit_password'] != '' && ($post['edit_password'] != $post['edit_re_password'])) {
                redirect_and_die('Mật khẩu xác nhận không đúng!');
            }
            $paramArr = array('username', 'name', 'email', 'phone', 'active');
            foreach ($paramArr as $value) {
                if (isset($post['edit_' . $value])) {
                    $param[$value] = $post['edit_' . $value];
                }
            }
            if ($post['edit_password'] != '') {
                $param['password'] = md5(md5($post['edit_password']));
            }
            $this->{$this->model}->update($input['where'], $param);
        }
        show_error_and_redirect('Sửa thông tin marketer thành công!');
    }

}
