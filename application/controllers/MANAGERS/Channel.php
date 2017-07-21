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
class Channel extends MY_Table {

    public function __construct() {
        parent::__construct();
        $this->init();
    }

    public function init() {
        $this->controller_path = 'MANAGERS/channel';
        $this->view_path = 'MANAGERS/channel';
        $this->sub_folder = 'MANAGERS';
        /*
         * Liệt kê các trường trong bảng
         * - nếu type = text thì không cần khai báo
         * - nếu không muốn hiển thị ra ngoài thì dùng display = none
         * - nếu trường nào cần hiển thị đặc biệt (ngoại lệ) thì để là type = custom
         */
        $list_item = array(
            'id' => array(
                'name_display' => 'ID Channel'
            ),
            'code' => array(
                'name_display' => 'Mã kênh',
                'order' => '1'
            ),
            'name' => array(
                'name_display' => 'Tên kênh',
                'order' => '1'
            ),
            'desc' => array(
                'name_display' => 'Mô tả',
            ),
            'time' => array(
                'type' => 'datetime',
                'name_display' => 'Ngày tạo',
                'order' => '1'
            ),
            'active' => array(
                'type' => 'custom',
                'name_display' => 'Hoạt động',
            )
        );
        $this->set_list_view($list_item);
        $this->set_model('channel_model');
        $this->load->model('channel_model');
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

    function index($offset = 0) {
        $this->list_filter = array(
            'left_filter' => array(
                'time' => array(
                    'type' => 'datetime',
                ),
            ),
            'right_filter' => array(
                'active' => array(
                    'type' => 'binary',
                ),
            )
        );
        $conditional = array();
        $this->set_conditional($conditional);
        $this->set_offset($offset);
        $this->show_table();
        //echoQuery();
        $data = $this->data;
        $data['slide_menu'] = 'marketing/common/slide-menu';
        $data['top_nav'] = 'marketing/common/top-nav';
        $data['list_title'] = 'Danh sách kênh quảng cáo';
        $data['edit_title'] = 'Sửa thông tin kênh quảng cáo';
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
                'code' => array(
                ),
                'name' => array(
                )
            ),
            'right_table' => array(
                'desc' => array(
                    'type' => 'textarea'
                )
            ),
        );
        parent::show_add_item();
    }

    function action_add_item() {
        $post = $this->input->post();
        if (!empty($post)) {
            /*
             * Kiểm tra mã channel đã tồn tại chưa 
             */
            if ($this->{$this->model}->check_exists(array('code' => $post['add_code']))) {
                redirect_and_die('Mã kênh đã tồn tại!');
            }
            $paramArr = array('code', 'name', 'desc');
            foreach ($paramArr as $value) {
                if (isset($post['add_' . $value])) {
                    $param[$value] = $post['add_' . $value];
                }
            }
            $param['time'] = time();
            $this->{$this->model}->insert($param);
            show_error_and_redirect('Thêm kênh quảng cáo thành công!');
        }
    }

    /*
     * Hiển thị modal sửa item
     */

    function show_edit_item() {
        /*
         * type mặc định là text nên nếu là text sẽ không cần khai báo
         */
        $this->list_edit = array(
            'left_table' => array(
                'code' => array(
                ),
                'name' => array(),
            ),
            'right_table' => array(
                'desc' => array(
                    'type' => 'textarea'
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
            if ($post['edit_code'] != $curr_code[0]['code'] && $this->{$this->model}->check_exists(array('code' => $post['edit_code']))) {
                redirect_and_die('Mã kênh đã tồn tại!');
            }
            $paramArr = array('code', 'name', 'desc', 'active');
            foreach ($paramArr as $value) {
                if (isset($post['edit_' . $value])) {
                    $param[$value] = $post['edit_' . $value];
                }
            }
            $this->{$this->model}->update( $input['where'], $param);
        }
        show_error_and_redirect('Sửa mã Bill thành công!');
    }

}
