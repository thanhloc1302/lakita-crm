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
class Campaign extends MY_Table {

    public function __construct() {
        parent::__construct();
        $this->init();
        $this->load->model('campaign_cost_model');
    }

    public function init() {
        $this->controller_path = 'MANAGERS/campaign';
        $this->view_path = 'MANAGERS/campaign';
        $this->sub_folder = 'MANAGERS';
        /*
         * Liệt kê các trường trong bảng
         * - nếu type = text thì không cần khai báo
         * - nếu không muốn hiển thị ra ngoài thì dùng display = none
         * - nếu trường nào cần hiển thị đặc biệt (ngoại lệ) thì để là type = custom
         */
        $list_item = array(
            'id' => array(
                'name_display' => 'ID Campaign',
                'display' => 'none'
            ),
            'name' => array(
                'name_display' => 'Tên chiến dịch',
                'order' => '1'
            ),
            'campaign_id_facebook' => array(
                'name_display' => 'Campaign ID Facebook',
                'display' => 'none'
            ),
            'desc' => array(
                'name_display' => 'Mô tả',
                'display' => 'none'
            ),
            'spend' => array(
                'type' => 'currency',
                'name_display' => 'Đã tiêu',
            ),
            'total_C1' => array(
                'type' => 'currency',
                'name_display' => 'Số C1',
            ),
            'total_C2' => array(
                'type' => 'currency',
                'name_display' => 'Số C2',
            ),
            'total_C3' => array(
                'name_display' => 'Số C3',
            ),
            'C2pC1' => array(
                'name_display' => 'C2/C1',
            ),
            'C3pC2' => array(
                'name_display' => 'C3/C2',
            ),
            'pricepC1' => array(
                'name_display' => 'giá C1',
            ),
            'pricepC2' => array(
                'name_display' => 'giá C2',
            ),
            'pricepC3' => array(
                'name_display' => 'giá C3',
            ),
            'time' => array(
                'type' => 'datetime',
                'name_display' => 'Ngày tạo',
                'display' => 'none'
            ),
            'active' => array(
                'type' => 'custom',
                'name_display' => 'Hoạt động',
            )
        );
        $this->set_list_view($list_item);
        $this->set_model('campaign_model');
        $this->load->model('campaign_model');
    }

    protected function show_table() {
        parent::show_table();
        $get = $this->input->get();
        /*
         * Nếu có điều kiện đặc biệt thì thêm vào $row class css đặc biệt khi hiển thị
         * ví dụ: giá khóa học lớn hơn 4 triệu thì báo đỏ
         */
        $date_form = '';
        $date_end = '';
        if (!isset($get['date_from']) && !isset($get['date_end'])) {
            $date_form = strtotime(date('d-m-Y', strtotime("-1 days")));
            $date_end = strtotime(date('d-m-Y', strtotime("-1 days")));
        } else {
            $date_form = strtotime($get['date_from']);
            $date_end = strtotime($get['date_end']);
        }
        foreach ($this->data['rows'] as &$value) {
            /*
             * Lấy số C3 & số tiền tiêu
             */

            $input = array();
            $input['where'] = array('campaign_id' => $value['id'], 'time >=' => $date_form, 'time <=' => $date_end);
            $channel_cost = $this->campaign_cost_model->load_all($input);
            $channel_cost = h_caculate_channel_cost($channel_cost);
            if (!empty($channel_cost)) {
                $value['total_C1'] = $channel_cost['total_C1'];
                $value['total_C2'] = $channel_cost['total_C2'];
                $value['total_C3'] = $channel_cost['total_C3'];
                $value['C2pC1'] = ($value['total_C1'] > 0) ? round($value['total_C2'] / $value['total_C1'] * 100) . '%' : '#N/A';
                $value['C3pC2'] = ($value['total_C2'] > 0) ? round($value['total_C3'] / $value['total_C2'] * 100) . '%' : '#N/A';
                $value['spend'] = $channel_cost['spend'];
                $value['pricepC1'] = ($value['total_C1'] > 0) ? round($value['spend'] / $value['total_C1']) . ' đ' : '#N/A';
                $value['pricepC2'] = ($value['total_C2'] > 0) ? round($value['spend'] / $value['total_C2']) . ' đ' : '#N/A';
                $value['pricepC3'] = ($value['total_C3'] > 0) ? round($value['spend'] / $value['total_C3']) . ' đ' : '#N/A';
            } else {
                $value['total_C1'] = '#NA';
                $value['total_C2'] = '#NA';
                $value['total_C3'] = '#NA';
                $value['C2pC1'] = '#NA';
                $value['C3pC2'] = '#NA';
                $value['spend'] = '#NA';
                $value['pricepC1'] = '#NA';
                $value['pricepC2'] = '#NA';
                $value['pricepC3'] = '#NA';
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

    function index($offset = 0) {
        $this->list_filter = array(
            'left_filter' => array(
                'date' => array(
                    'type' => 'custom',
                ),
            ),
            'right_filter' => array(
                'active' => array(
                    'type' => 'binary',
                ),
            )
        );
        $conditional = array();
        $conditional['where'] = $this->set_conditional($conditional);
        $this->set_offset($offset);
        $this->show_table();
        $data = $this->data;
        $data['slide_menu'] = 'marketer/common/slide-menu';
        $data['top_nav'] = 'marketer/common/top-nav';
        $data['list_title'] = 'Danh sách chiến dịch (tính theo giờ Mỹ)';
        $data['edit_title'] = 'Sửa thông tin chiến dịch';
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
        $this->load->model('channel_model');
        $input = array();
        $input['where'] = array('active' => 1);
        $channels = $this->channel_model->load_all($input);
        $this->list_add = array(
            'left_table' => array(
                'name' => array(
                ),
                'channel_id' => array(
                    'type' => 'array',
                    'value' => $channels,
                ),
                'campaign_id_facebook' => array(
                ),
            ),
            'right_table' => array(
                'desc' => array(
                    'type' => 'textarea'
                ),
                'active' => array()
            ),
        );
        parent::show_add_item();
    }

    function action_add_item() {
        $post = $this->input->post();
        if (!empty($post)) {
            if ($this->{$this->model}->check_exists(array('name' => $post['add_name']))) {
                redirect_and_die('Tên chiến dịch đã tồn tại!');
            }
            $paramArr = array('name', 'channel_id', 'campaign_id_facebook', 'desc', 'active');
            foreach ($paramArr as $value) {
                if (isset($post['add_' . $value])) {
                    $param[$value] = $post['add_' . $value];
                }
            }
            $param['time'] = time();
            $param['marketer_id'] = $this->user_id;
            $this->{$this->model}->insert($param);
            show_error_and_redirect('Thêm chiến dịch thành công!');
        }
    }

    /*
     * Hiển thị modal sửa item
     */

    function show_edit_item() {
        /*
         * type mặc định là text nên nếu là text sẽ không cần khai báo
         */
        $this->load->model('channel_model');
        $input = array();
        $input['where'] = array('active' => 1);
        $channels = $this->channel_model->load_all($input);
        $this->list_edit = array(
            'left_table' => array(
                'name' => array(
                ),
                'channel_id' => array(
                    'type' => 'array',
                    'value' => $channels,
                ),
                'campaign_id_facebook' => array(
                )
            ),
            'right_table' => array(
                'desc' => array(
                    'type' => 'textarea'
                ),
                'active' => array()
            ),
        );
        parent::show_edit_item();
    }

    function action_edit_item($id) {
        $post = $this->input->post();
        if (!empty($post)) {
            $input['where'] = array('id' => $id);
            $paramArr = array('name', 'channel_id', 'campaign_id_facebook', 'desc', 'active');
            foreach ($paramArr as $value) {
                if (isset($post['edit_' . $value])) {
                    $param[$value] = $post['edit_' . $value];
                }
            }
            $this->{$this->model}->update($input['where'], $param);
        }
        show_error_and_redirect('Sửa chiến dịch thành công!');
    }

}