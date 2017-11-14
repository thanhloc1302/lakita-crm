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
//            'id' => array(
//                'name_display' => 'ID Campaign',
//            ),
            'active' => array(
                'type' => 'binary',
                'name_display' => 'Hoạt động'
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
                'type' => 'currency',
                'name_display' => 'giá C3',
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
            $date_form = strtotime(date('01-m-Y'));
            $date_end = time();
        } else {
            $date_form = strtotime($get['date_from']);
            $date_end = strtotime($get['date_end']);
        }
        foreach ($this->data['rows'] as &$value) {
            /*
             * Lấy số C3 & số tiền tiêu
             */

            $total_c3 = array();
            $total_c3['select'] = 'id';
            $total_c3['where'] = array(
                'campaign_id' => $value['id'],
                'date_rgt >=' => $date_form + 14 * 3600,
                'date_rgt <=' => $date_end + 3600 * 38);
            $value['total_C3'] = count($this->contacts_model->load_all($total_c3));
            $input = array();
            $input['where'] = array('campaign_id' => $value['id'], 'time >=' => $date_form, 'time <=' => $date_end);
            $channel_cost = $this->campaign_cost_model->load_all($input);
            $channel_cost = h_caculate_channel_cost($channel_cost);
            if (!empty($channel_cost)) {
                $value['total_C1'] = $channel_cost['total_C1'];
                $value['total_C2'] = $channel_cost['total_C2'];
                // $value['total_C3'] = $channel_cost['total_C3'];
                $value['C2pC1'] = ($value['total_C1'] > 0) ? round($value['total_C2'] / $value['total_C1'] * 100) . '%' : '#N/A';
                $value['C3pC2'] = ($value['total_C2'] > 0) ? round($value['total_C3'] / $value['total_C2'] * 100) . '%' : '#N/A';
                $value['spend'] = $channel_cost['spend'];
                $value['pricepC1'] = ($value['total_C1'] > 0) ? round($value['spend'] / $value['total_C1']) : '#N/A';
                $value['pricepC2'] = ($value['total_C2'] > 0) ? round($value['spend'] / $value['total_C2']) : '#N/A';
                $value['pricepC3'] = ($value['total_C3'] > 0) ? round($value['spend'] / $value['total_C3']) : ( ($value['spend'] > 0) ? 9999999999 : '#N/A');
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
        usort($this->data['rows'], function($a, $b) {
            if (is_numeric($a['pricepC3']) && is_numeric($b['pricepC3'])) {
                return $b['pricepC3'] - $a['pricepC3'];
            } else if (is_numeric($a['pricepC3']) && !is_numeric($b['pricepC3'])) {
                return -1;
            } else if (!is_numeric($a['pricepC3']) && is_numeric($b['pricepC3'])) {
                return +1;
            } else {
                return $b['active'] - $a['active'];
            }
        });
        // print_arr($this->data['rows']);
    }

    /*
     * Ghi đè hàm xóa lớp cha
     */

//
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
//        if (!isset($get['filter_binary_active']) || $get['filter_binary_active'] == '0') {
//            $conditional['where']['active'] = 1;
//        }
        $this->set_conditional($conditional);
        $this->set_offset($offset);
        $this->show_table();

        $data = $this->data;
        $data['slide_menu'] = 'marketer/common/slide-menu';
        $data['top_nav'] = 'manager/common/top-nav';
        $data['list_title'] = 'Danh sách chiến dịch (tính theo giờ Mỹ)';
        $data['edit_title'] = 'Sửa thông tin chiến dịch';
        $data['content'] = 'MANAGERS/campaign/index';
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
            if ($this->{$this->model}->check_exists(array('name' => $post['add_name'], 'marketer_id' => $this->user_id))) {
                redirect_and_die('Tên chiến dịch đã tồn tại!');
            }
            if ($this->{$this->model}->check_exists(array('campaign_id_facebook' => $post['add_campaign_id_facebook']))) {
                redirect_and_die('Chiến dịch này đã được tạo từ Campaign FB!');
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

//            $url = 'https://graph.facebook.com/v2.11/' . $post['add_campaign_id_facebook'] . '/' .
//                    'adsets?limit=1000&fields=status,name&access_token=' . ACCESS_TOKEN;
//            $spend = get_fb_request($url);
//            $adsets = json_decode(json_encode($spend->data), true);
//            if (!empty($adsets)) {
//                $this->load->model('adset_model');
//                foreach ($adsets as $adset) {
//                    $data = [];
//                }
//            }
//            print_arr($adsets);
            show_error_and_redirect('Thêm chiến dịch và các adset con thành công!');
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

    public function AddItemFetch() {
        $accountFBADS = [
            'Lakita_cu' => '512062118812690',
            'Lakita_3.0' => '600208190140429',
            'Lakita_K3' => '817360198425226'];
        $campaigns = [];
        foreach ($accountFBADS as $key => $value2) {
            $url = 'https://graph.facebook.com/v2.11/act_' . $value2 . '/' .
                    'campaigns?limit=1000&fields=status,name&access_token=' . ACCESS_TOKEN;
            $spend = get_fb_request($url);
            //  print_arr($spend);
            //print_arr($spend);
            //$spend->data[0]->spend
            $campaigns[$key] = json_decode(json_encode($spend->data), true);
        }
        foreach ($campaigns as $key => $value) {
            foreach ($value as $key2 => $campaign) {
                $input = array();
                $input['where'] = array('campaign_id_facebook' => $campaign['id']);
                $campaigns[$key][$key2]['detail'] = $this->{$this->model}->load_all($input);
            }
        }

        $newCampaign = [];
        $i = 0;
        foreach ($campaigns as $key => $value) {
            foreach ($value as $value2) {
                //print_arr($value2);
                if ($value2['status'] == 'ACTIVE') {
                    $newCampaign[$i] = $value2;
                    $newCampaign[$i]['name_account'] = $key;
                }
                $i++;
            }
        }

        /*
         * Lấy danh sách các marketer
         */
        $input = [];
        $input['where'] = array('role_id' => 6, 'active' => '1');
        $marketerArr = $this->staffs_model->load_all($input);
        foreach ($marketerArr as $value) {
            $marketers[$value['id']] = $value['name'];
        }
        $data['marketers'] = $marketers;
        $data['campaigns'] = $newCampaign;
        //print_arr($newCampaign);
        echo $this->load->view('MANAGERS/campaign/fetch-campaign', $data, TRUE);
    }

    public function AddItemFromFb() {
        
    }

}
