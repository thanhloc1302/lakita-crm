<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Marketing
 *
 * @author phong
 */
class Marketing extends MY_Table {

    public function __construct() {
        parent::__construct();
        $this->init();
    }

    public function init() {
        $this->controller_path = 'Marketing';
        $this->view_path = 'marketing';
        $this->sub_folder = '';
        /*
         * Liệt kê các trường trong bảng
         * - nếu type = text thì không cần khai báo
         * - nếu không muốn hiển thị ra ngoài thì dùng display = none
         * - nếu trường nào cần hiển thị đặc biệt (ngoại lệ) thì để là type = custom
         */
        $list_item = array(
            'id' => array(
                'name_display' => 'ID'
            ),
            'name' => array(
                'name_display' => 'Họ tên',
                'order' => '1'
            ),
            'phone' => array(
                'name_display' => 'Số đt'
            ),
            'address' => array(
                'name_display' => 'Địa chỉ'
            ),
            'course_code' => array(
                'name_display' => 'Mã khóa học'
            ),
            'price_purchase' => array(
                'type' => 'currency',
                'name_display' => 'Giá tiền mua',
                'order' => '1'
            ),
            
            'date_rgt' => array(
                'type' => 'datetime',
                'name_display' => 'Ngày đăng ký',
                'order' => '1'
            ),
            'matrix' => array(
                'name_display' => 'Ma trận',
            )
        );
        $this->set_list_view($list_item);
        $this->set_model('contacts_model');
    }

    //put your code here
    function index($offset = 0) {
        $conditional = array();
        $this->set_conditional($conditional);
        $this->set_offset($offset);
        $this->show_table();
        //echoQuery();
        $data = $this->data;
        $data['slide_menu'] = 'cod/check_L8/slide-menu';
        $data['top_nav'] = 'cod/common/top-nav';
        $data['list_title'] = 'Kết quả đối soát cước';
        $data['edit_title'] = 'Sửa thông tin dòng đối soát cước';
        $data['content'] = 'base/index';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

}
