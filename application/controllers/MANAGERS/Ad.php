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
class Ad extends MY_Table {

    public function __construct() {
        parent::__construct();
        $this->init();
        $this->load->model('ad_cost_model');
    }

    public function init() {
        $this->controller_path = 'MANAGERS/ad';
        $this->view_path = 'MANAGERS/ad';
        $this->sub_folder = 'MANAGERS';
        /*
         * Liệt kê các trường trong bảng
         * - nếu type = text thì không cần khai báo
         * - nếu không muốn hiển thị ra ngoài thì dùng display = none
         * - nếu trường nào cần hiển thị đặc biệt (ngoại lệ) thì để là type = custom
         */
        $list_item = array(
            'id' => array(
                'name_display' => 'ID ad',
                'display' => 'none'
            ),
            'active' => array(
                'type' => 'binary',
                'name_display' => 'Hoạt động'
            ),
            'name' => array(
                'name_display' => 'Tên ad',
                'order' => '1'
            ),
            'ad_id_facebook' => array(
                'name_display' => 'Ad ID Facebook',
            ),
            'marketer_id' => array(
                'name_display' => 'Marketer',
            ),
            'account_fb_id' => array(
                'name_display' => 'Tài khoản',
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
                'display' => 'none'
            ),
            'C3pC2' => array(
                'name_display' => 'C3/C2',
                'display' => 'none'
            ),
            'pricepC1' => array(
                'name_display' => 'giá C1',
            ),
            'pricepC2' => array(
                'name_display' => 'giá C2',
                'type' => 'currency',
            ),
            'pricepC3' => array(
                'name_display' => 'giá C3',
                'type' => 'currency',
            ),
            'time' => array(
                'type' => 'datetime',
                'name_display' => 'Ngày tạo',
                'display' => 'none'
            ),
            'channel' => array(
                'name_display' => 'Kênh',
                'order' => '1',
                'display' => 'none'
            ),
        );
        $this->set_list_view($list_item);
        $this->set_model('ad_model');
        $this->load->model('ad_model');
    }

    protected function show_table() {
        parent::show_table();
        $get = $this->input->get();

        $date_form = '';
        $date_end = '';
        /*
         * Nếu không có lọc ngày tháng từ người dùng thì chọn mặc định là hôm qua
         */
        if (!isset($get['date_from']) && !isset($get['date_end'])) {
            $date_form = strtotime(date('d-m-Y', strtotime("-1 days")));
            $date_end = strtotime(date('d-m-Y', strtotime("-1 days")));
        } else {
            $date_form = strtotime($get['date_from']);
            $date_end = strtotime($get['date_end']);
        }

        $this->load->model('account_fb_model');
        $account = $this->account_fb_model->getAccountArr();
        foreach ($this->data['rows'] as &$value) {
            /*
             * Lấy số C3 & số tiền tiêu
             */
            $total_c3 = array();
            $total_c3['select'] = 'id';
            /*
             * Giờ VN
             */
            if ($this->account_fb_model->getAccountTimeZone($value['account_fb_id']) == 'VN') {
                $total_c3['where'] = array(
                    'ad_id' => $value['id'],
                    'date_rgt >=' => $date_form,
                    'date_rgt <=' => $date_end + 24 * 3600 - 1);
            } else {
                $total_c3['where'] = array(
                    'ad_id' => $value['id'],
                    'date_rgt >=' => $date_form + 14 * 3600,
                    'date_rgt <=' => $date_end + 3600 * 38);
            }
            $value['total_C3'] = count($this->contacts_model->load_all($total_c3));
            $input = array();
            $input['where'] = array('ad_id' => $value['id'], 'time >=' => $date_form, 'time <=' => $date_end + 3600*24-1);
            $ad_cost = $this->ad_cost_model->load_all($input);
            $ad_cost = h_caculate_channel_cost($ad_cost);
            if (!empty($ad_cost)) {
                $value['total_C1'] = $ad_cost['total_C1'];
                $value['total_C2'] = $ad_cost['total_C2'];
                $value['C2pC1'] = ($value['total_C1'] > 0) ? round($value['total_C2'] / $value['total_C1'] * 100) . '%' : '#N/A';
                $value['C3pC2'] = ($value['total_C2'] > 0) ? round($value['total_C3'] / $value['total_C2'] * 100) . '%' : '#N/A';
                $value['spend'] = $ad_cost['spend'];
                $value['pricepC1'] = ($value['total_C1'] > 0) ? round($value['spend'] / $value['total_C1']) . ' đ' : '#N/A';
                $value['pricepC2'] = ($value['total_C2'] > 0) ? round($value['spend'] / $value['total_C2']) . ' đ' : '#N/A';
                $value['pricepC3'] = ($value['total_C3'] > 0) ? round($value['spend'] / $value['total_C3']) : '#N/A';
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
            $value['account_fb_id'] = $account[$value['account_fb_id']];
            $value['marketer_id'] = $this->staffs_model->find_staff_name($value['marketer_id']);
        }
        unset($value);
        usort($this->data['rows'], function($a, $b) {
            if ($a['active'] == '0' && $b['active'] == '1') {
                return +1;
            } else if ($a['active'] == '1' && $b['active'] == '0') {
                return -1;
            } else if ($a['active'] == '0' && $b['active'] == '0') {
                if (is_numeric($a['pricepC3']) && is_numeric($b['pricepC3'])) {
                    return $b['pricepC3'] - $a['pricepC3'];
                } else if (is_numeric($a['pricepC3']) && !is_numeric($b['pricepC3'])) {
                    return -1;
                } else if (!is_numeric($a['pricepC3']) && is_numeric($b['pricepC3'])) {
                    return +1;
                }
            } else {
                if (is_numeric($a['pricepC3']) && is_numeric($b['pricepC3'])) {
                    return $b['pricepC3'] - $a['pricepC3'];
                } else if (is_numeric($a['pricepC3']) && !is_numeric($b['pricepC3'])) {
                    return -1;
                } else if (!is_numeric($a['pricepC3']) && is_numeric($b['pricepC3'])) {
                    return +1;
                }
            }
        });
    }

    /*
     * Ghi đè hàm xóa lớp cha
     */

//    function delete_item() {
//        die('Không thể xóa, liên hệ admin để biết thêm chi tiết');
//    }
//
//    function delete_multi_item() {
//        show_error_and_redirect('Không thể xóa, liên hệ admin để biết thêm chi tiết', '', FALSE);
//    }

    function index($offset = 0) {
        $this->load->model('channel_model');
        $input = array();
        $input['where'] = array('active' => '1');
        $channels = $this->channel_model->load_all($input);
        $this->data['channel'] = $channels;

        $this->list_filter = array(
            'left_filter' => array(
                'date' => array(
                    'type' => 'custom',
                ),
                'channel' => array(
                    'type' => 'arr_multi'
                ),
            ),
            'right_filter' => array(
                'active' => array(
                    'type' => 'binary',
                ),
            )
        );
        $conditional = array();
        if ($this->role_id != 5) {
            $conditional['where']['marketer_id'] = $this->user_id;
        }
        $this->set_conditional($conditional);
        $this->set_offset($offset);
        $this->show_table();
        $data = $this->data;
        $data['slide_menu'] = 'marketer/common/slide-menu';
        $data['top_nav'] = 'manager/common/top-nav';
        $data['list_title'] = 'Danh sách các ads (tính theo giờ Mỹ)';
        $data['edit_title'] = 'Sửa thông tin ads';
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
        $this->load->model('adset_model');
        $input = array();
        $input['where'] = array('active' => 1, 'marketer_id' => $this->user_id);
        $adsets = $this->adset_model->load_all($input);
        $this->list_add = array(
            'left_table' => array(
                'name' => array(
                ),
                'adset_id' => array(
                    'type' => 'array',
                    'value' => $adsets,
                ),
                'ad_id_facebook' => array(
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
        $this->load->model('adset_model');
        $post = $this->input->post();
        if (!empty($post)) {
            if ($this->{$this->model}->check_exists(array('name' => $post['add_name'], 'marketer_id' => $this->user_id))) {
                redirect_and_die('Tên ad đã tồn tại!');
            }
             if ($post['add_ad_id_facebook'] != '' && $this->{$this->model}->check_exists(array('ad_id_facebook' => $post['add_ad_id_facebook']))) {
                redirect_and_die('Ad này đã được tạo từ FB!');
            }
            if($post['add_adset_id'] == 0){
                 redirect_and_die('Bạn cần chọn adset!');
            }
            $paramArr = array('name', 'adset_id', 'ad_id_facebook', 'desc', 'active');
            foreach ($paramArr as $value) {
                if (isset($post['add_' . $value])) {
                    $param[$value] = $post['add_' . $value];
                }
            }
            $param['marketer_id'] = $this->user_id;
            $param['time'] = time();
            $input = [];
            $input['select'] = 'channel_id';
            $input['where'] = array('id' => $param['adset_id']);
            $channel = $this->adset_model->load_all($input);
            if (!empty($channel)) {
                $param['channel_id'] = $channel[0]['channel_id'];
            }
            $this->{$this->model}->insert($param);
            show_error_and_redirect('Thêm ads thành công!');
        }
    }

    /*
     * Hiển thị modal sửa item
     */

    function show_edit_item($inputData = []) {
        /*
         * type mặc định là text nên nếu là text sẽ không cần khai báo
         */
        $this->load->model('adset_model');
        $input = array();
        $input['where'] = array('marketer_id' => $this->user_id);
        $adsets = $this->adset_model->load_all($input);
        $this->list_edit = array(
            'left_table' => array(
                'id' => array(
                    'type' => 'disable'
                ),
                'name' => array(
                ),
                'adset_id' => array(
                    'type' => 'array',
                    'value' => $adsets,
                ),
                'ad_id_facebook' => array(
                ),
            ),
            'right_table' => array(
                'desc' => array(
                    'type' => 'textarea'
                ),
                'active' => array()
            ),
        );
        $inputData['edit_title'] = 'Sửa thông tin ad';
        parent::show_edit_item($inputData);
    }

    function action_edit_item($id) {
        $this->load->model('adset_model');
        $post = $this->input->post();
        if (!empty($post)) {
            $input['where'] = array('id' => $id);
            $paramArr = array('name', 'adset_id', 'ad_id_facebook', 'desc', 'active');
            foreach ($paramArr as $value) {
                if (isset($post['edit_' . $value])) {
                    $param[$value] = $post['edit_' . $value];
                }
            }
            $input2 = [];
            $input2['select'] = 'channel_id';
            $input2['where'] = array('id' => $param['adset_id']);
            $channel = $this->adset_model->load_all($input2);
            if (!empty($channel)) {
                $param['channel_id'] = $channel[0]['channel_id'];
            }
            $this->{$this->model}->update($input['where'], $param);
        }
        show_error_and_redirect('Sửa ads thành công!');
    }

}
