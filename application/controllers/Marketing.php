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
//            'id' => array(
//                'name_display' => 'ID'
//            ),
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
            'channel' => array(
                'name_display' => 'Kênh',
                'order' => '1'
            ),
            'marketer' => array(
                'name_display' => 'Marketer',
                'order' => '1'
            ),
            'duplicate_id' => array(
                'name_display' => 'Contact trùng',
                'display' => 'none'
            ),
            'course' => array(
                'name_display' => 'Mã khóa học',
                'display' => 'none'
            ),
            'landingpage' => array(
                'name_display' => 'Landing Page',
                'display' => 'none'
            ),
            'is_hide' => array(
                'name_display' => 'Đã xóa',
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

        $this->load->model('channel_model');
//        $this->load->model('campaign_model');
//        $this->load->model('adset_model');
//        $this->load->model('ad_model');
        $this->load->model('staffs_model');
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
            $value['channel'] = $this->channel_model->find_channel_name($value['channel_id']);
//            $value['campaign'] = $this->campaign_model->find_campaign_name($value['campaign_id']);
//            $value['adset'] = $this->adset_model->find_adset_name($value['adset_id']);
//            $value['ad'] = $this->ad_model->find_ad_name($value['ad_id']);
            $value['marketer'] = $this->staffs_model->find_staff_name($value['marketer_id']);
        }
        unset($value);
    }

    function delete_item() {
        die('Không thể xóa, liên hệ admin để biết thêm chi tiết');
    }

    function delete_multi_item() {
        show_error_and_redirect('Không thể xóa, liên hệ admin để biết thêm chi tiết', '', FALSE);
    }

    function index($offset = 0) {
        $this->load->model('channel_model');
        $input = array();
        $input['where'] = array('active' => '1');
        $channels = $this->channel_model->load_all($input);
        $this->data['channel'] = $channels;

        $input = array();
        $input['where'] = array('role_id' => '6', 'active' => '1');
        $this->data['marketer'] = $this->staffs_model->load_all($input);

        $this->load->model('courses_model');
        $input = array();
        $input['where'] = array('active' => '1');
        $input['order'] = array('course_code' => 'ASC');
        $this->data['course'] = $this->courses_model->load_all($input);

        $this->list_filter = array(
            'left_filter' => array(
                'marketer' => array(
                    'type' => 'arr_multi'
                ),
                'channel' => array(
                    'type' => 'arr_multi'
                ),
                'course' => array(
                    'type' => 'arr_multi',
                    'field_name' => 'course_code',
                    'field' => 'course_code',
                    'table_id' => 'course_code'
                ),
            ),
            'right_filter' => array(
                'duplicate_id' => array(
                    'type' => 'binary',
                ),
            )
        );
        $conditional = array();
        $conditional['where']['date_rgt >'] = strtotime(date('d-m-Y'));
        //$conditional['where']['source_id'] = '1';
        $this->set_conditional($conditional);
        $this->set_offset($offset);
        $this->show_table();
        //echoQuery();
        $data = $this->data;
        $progress = $this->GetProccessMarketerToday();
        $data['marketers'] = $progress['marketers'];
        $data['C3Team'] = $progress['C3Team'];
        $data['C3Total'] = MARKETING_KPI_PER_DAY;
        $data['progressType'] = 'Tiến độ của team hôm nay';
        $data['list_title'] = 'Danh sách contact ngày hôm nay';
        $data['content'] = 'marketing/index';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    function view_all($offset = 0) {
        $this->load->model('channel_model');
        $input = array();
        $input['where'] = array('active' => '1');
        $channels = $this->channel_model->load_all($input);
        $this->data['channel'] = $channels;


        $input = array();
        $input['where'] = array('role_id' => '6', 'active' => '1');
        $this->data['marketer'] = $this->staffs_model->load_all($input);

        $this->load->model('courses_model');
        $input = array();
        $input['where'] = array('active' => '1');
        $this->data['course'] = $this->courses_model->load_all($input);

        $this->load->model('landingpage_model');
        $input = array();
        $input['where'] = array('active' => '1');
        $this->data['landingpage'] = $this->landingpage_model->load_all($input);

        $this->list_filter = array(
            'left_filter' => array(
                'date_rgt' => array(
                    'type' => 'datetime',
                ),
                'marketer' => array(
                    'type' => 'arr_multi'
                ),
                'channel' => array(
                    'type' => 'arr_multi'
                ),
            ),
            'right_filter' => array(
                'course' => array(
                    'type' => 'arr_multi',
                    'field_name' => 'course_code',
                    'field' => 'course_code',
                    'table_id' => 'course_code'
                ),
                'landingpage' => array(
                    'type' => 'arr_multi',
                    'field_name' => 'url',
                ),
                'duplicate_id' => array(
                    'type' => 'binary',
                ),
                'is_hide' => array(
                    'type' => 'binary',
                )
            )
        );
        $conditional = array();
        //  $conditional['where']['source_id'] = '1';
        $this->set_conditional($conditional);
        $this->set_offset($offset);
        $this->show_table();
        echoQuery();
        $data = $this->data;
        $progress = $this->GetProccessMarketerThisMonth();
        $data['marketers'] = $progress['marketers'];
        $data['C3Team'] = $progress['C3Team'];
        $data['C3Total'] = MARKETING_KPI_PER_DAY * 30;
        $data['progressType'] = 'Tiến độ của team tháng này';
        $data['list_title'] = 'Danh sách toàn bộ contact';
        $data['content'] = 'marketing/index';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    function view_report_operation() {
        $this->load->helper('manager_helper');
        $this->load->helper('common_helper');
        $this->load->model('campaign_cost_model');
        $this->load->model('account_fb_model');
        $this->load->model('campaign_model');

        $get = $this->input->get();

        $data = '';


        if ((!isset($get['filter_date_happen_from']) && !isset($get['filter_date_happen_end'])) || (isset($get['filter_date_happen_from']) && $get['filter_date_happen_from'] == '' && $get['filter_date_happen_end'] == '')) {
            $startDate = strtotime(date('1-m-Y'));
            $endDate = strtotime(date('d-m-Y'));
        } else {
            $startDate = strtotime($get['filter_date_happen_from']);
            $endDate = strtotime($get['filter_date_happen_end']);
        }

        $dateArray = h_get_time_range($startDate, $endDate);

        $Report = array();

        $account = $this->account_fb_model->getAccountArr();

        $input_campaign = [];
        if (isset($get['filter_marketer_id'])) {
            $input_campaign['where_in']['marketer_id'] = $get['filter_marketer_id'];
        }
        $campaign = $this->campaign_model->load_all($input_campaign);



        foreach ($dateArray as $d_key => $d_value) {
            $perday = array();
            $spend = '';
            $c1 = '';
            $c2 = '';
            $c3 = '';
            foreach ($campaign as &$value) {
                $input = array();
                $input['where'] = array('campaign_id' => $value['id'], 'time >=' => $d_value, 'time <=' => $d_value + 24 * 3600 - 1, 'spend >' => '0');
                $campaign_cost = $this->campaign_cost_model->load_all($input);
                // $channel_cost = h_caculate_channel_cost($channel_cost);
                if (!empty($campaign_cost)) {
                    $campaign_cost = h_caculate_channel_cost($channel_cost);
                    $c1 += $campaign_cost['total_C1'];
                    $c2 += $campaign_cost['total_C2'];
                    $spend += $campaign_cost['spend'];
                } else {
                    $c1 += 0;
                    $c2 += 0;
                    $spend += 0;
                }
            }
            
            
            $input = [];
            $input['select'] = 'id';
            $input['where'] = array('channel_id' => 2,'date_rgt >' => $d_value, 'date_rgt <' => $d_value + 24 * 3600);
            if (isset($get['filter_marketer_id'])) {
                $input['where_in']['marketer_id'] = $get['filter_marketer_id'];
            }
            $c3 = count($this->contacts_model->load_all($input));

            $input = [];
            $input['select'] = 'id';
            $input['where'] = array('channel_id' => 2,'date_rgt >' => $d_value, 'date_rgt <' => $d_value + 24 * 3600, 'duplicate_id' => '');
            if (isset($get['filter_marketer_id'])) {
                $input['where_in']['marketer_id'] = $get['filter_marketer_id'];
            }
            $l1 = count($this->contacts_model->load_all($input));

            $perday['c1'] = $c1;
            $perday['c2'] = $c2;
            $perday['c3'] = $c3;
            $perday['spend'] = $spend;
            $perday['c2/c1'] = ($c1 == '0' || $c1 == '') ? '0' : round($c2 / $c1, 3) * 100;
            $perday['c3/c2'] = ($c2 == '0' || $c2 == '' ) ? '0' : round($c3 / $c2, 3) * 100;
            $perday['priceC3'] = ($c3 != '0') ? round($spend / $c3) : '0';
            $perday['l1'] = $l1;
            $arr_per_day[(string) $d_key] = $perday;
        }


        $total['total_C1'] = '';
        $total['total_C2'] = '';
        $total['total_C3'] = '';
        $total['total_Spend'] = '';

        foreach ($arr_per_day as $key => $value) {
            $total['total_C1'] += $value['c1'];
            $total['total_C2'] += $value['c2'];
            $total['total_C3'] += $value['c3'];
            $total['total_Spend'] += $value['spend'];
        }
        $total['total_C3/C2'] = ($total['total_C2'] != '0') ? round($total['total_C3'] / $total['total_C2'], 4) * 100 . '%' : 'N/A';
        $total['total_C2/C1'] = ($total['total_C1'] != '0') ? round($total['total_C2'] / $total['total_C1'], 2) * 100 . '%' : 'N/A';
        $total['total_price_C3'] = ($total['total_C3'] != '0') ? round($total['total_Spend'] / $total['total_C3']):0;

        $this->load->model('staffs_model');
        $data['marketers'] = $this->staffs_model->load_all(array('where' => array('role_id' => 6, 'active' => 1)));

        $data['left_col'] = array('date_happen', 'marketer');
        $data['total'] = $total;
        $data['startDate'] = isset($startDate) ? $startDate : '0';
        $data['endDate'] = isset($endDate) ? $endDate : '0';
        $data['per_day'] = $arr_per_day;
        $data['slide_menu'] = 'manager/common/menu';
        $data['top_nav'] = 'manager/common/top-nav';
        $data['content'] = 'marketing/view_report_operation';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

}
