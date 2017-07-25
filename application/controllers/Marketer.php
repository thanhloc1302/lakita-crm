<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Marketer
 *
 * @author Phạm Ngọc Chuyển <chuyenpn at lakita.vn>
 */
class Marketer extends MY_Table{
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
            'channel_id' => array(
                'name_display' => 'Kênh',
            ),
            'duplicate_id' => array(
                'name_display' => 'Contact trùng', 
                'display' => 'none'
            )
        );
        $this->set_list_view($list_item);
        $this->set_model('contacts_model');
    }

    /*
     * override lại hàm show_table của lớp cha
     */

    protected function show_table() {
        parent::show_table();
        /*
         * Nếu có điều kiện đặc biệt thì thêm vào $row class css đặc biệt khi hiển thị
         * ví dụ: giá khóa học lớn hơn 4 triệu thì báo đỏ
         */
        foreach ($this->data['rows'] as &$value) {
            $class = '';
            if ($value['is_hide'] == 1) {
                $class .= ' is_hide';
            }
            if ($value['duplicate_id'] > 0) {
                $class .= ' duplicate';
            }
            if ($class != '') {
                $value['warning_class'] = $class;
            }
        }
        unset($value);
    }

    function index($offset = 0) {
         $this->list_filter = array(
            'left_filter' => array(
               'duplicate_id' => array(
                    'type' => 'binary',
                )
            ),
            'right_filter' => array(
                
            )
        );
        $conditional = array();
        $conditional['where']['marketer_id'] = $this->user_id;
        $conditional['where']['date_rgt >'] = strtotime(date('d-m-Y'));
        $this->set_conditional($conditional);
        $this->set_offset($offset);
        $this->show_table();
        //echoQuery();
        $data = $this->data;
        $data['list_title'] = 'Danh sách contact ngày hôm nay';
        $data['content'] = 'marketing/index';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }
}
