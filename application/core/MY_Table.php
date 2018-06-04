<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_Controller2
 *
 * @author chuyenpn ngày 09/07/2017
 *
 * Class dùng để thực hiện hiển thị danh sách item trong 1 bảng,
 * thêm, sửa, xóa các iteam trong bảng
 * bao gồm cả phân trang, lọc, tìm kiếm, sắp xếp
 *
 */
class MY_Table extends MY_Controller {
    /*
     * Các biến sử dụng gồm


     * 
     *      - kiểu text: hiển thị text (mặc định kiểu text nên ko cần truyền vào)
     *      - kiểu currency: kiểu giá cả ( 199.000 VNĐ)
     *      - kiểu datetime: giờ phút giây năm tháng ngày
     * $list_view_order: là 1 mảng các trường sẽ hiển thị (theo thứ tự)
     */

    /*
     * Biến chứa model tương ứng của danh mục
     */

    protected $model = '';

    /*
     * $conditional: biến lấy điều kiện khi hiển thị danh sách item,
     *      ví dụ khi hiển thị danh sách contact L8 thì điều kiện là cod_status_id = 3
     */
    private $conditional = '';

    /*
     *   $offset, $limit: dùng khi phân trang
     */
    private $offset = 0;
    private $limit = 0;

    /*
     * Biến khi hiển thị các trường thông tin của bảng ra ngoài view.
     * Mỗi trường là một mảng trong đó key là tên trường trong db, 
     * còn value là một mảng gồm các key: 
     * + type gồm có
     *      - type = text: hiển thị kiểu text (mặc định kiểu text nên cso thể ko cần truyền vào type = text)
     *      - type = currency: kiểu giá cả ( 199.000 VNĐ)
     *      - type = datetime: giờ phút giây năm tháng ngày
     *  + name_display: Tên hiển thị ra ngoài bảng
     *  + order (option): Sắp xếp theo trường đó
     *  + display = none : không hiển thị trường đó ra ngoài bảng
     */
    public $list_view = array();
    public $list_search = array();
    public $view_path = '';
    public $controller_path = '';
    /*
     * Phân trang
     */
    public $sub_folder = '';
    public $pagination_link = '';
    public $begin_paging = 0;
    public $end_paging = 0;
    public $total_paging = 0;
    public $num_segment = 3;

    /*
     * Chỉnh sửa item
     * Mỗi trường là một mảng trong đó key là tên trường trong db, 
     * còn value là một mảng gồm các key: 
     * + type gồm có
     *      - type = text: hiển thị kiểu text (mặc định kiểu text nên cso thể ko cần truyền vào type = text)
     *      - type = datetime: giờ phút giây năm tháng ngày (cho hiện datepicker)
     *      - type = custom
     *      - type = disable: không cho chỉnh sửa trường đó
     */
    public $list_edit = '';

    /*
     * Filter
     */
    public $list_filter = '';

    /*
     * add item
     */
    public $list_add = array();
    public $L = array(); //đếm số contact C3 hôm nay và tất cả 

    public function __construct() {
        parent::__construct();
        $this->limit = $this->per_page;
        $this->data['load_js'] = array('common_real_filter_contact');
        $this->_loadCountListContact();
    }

    /*
     * Hàm hiển thị bảng các danh sách item
     * - Đầu vào: điều kiện query, điều kiện lọc, tìm kiếm, sắp xếp
     * - Đầu ra: danh sách item (lưu trong $this->data['rows']), tổng số item ( $this->data['total_rows'])
     * thông tin link phân trang ($this->pagination_link, $this->begin_paging,  $this->end_paging, $this->total_paging)
     * - Nếu ở controller con có cần thông tin gì thì viết thêm vào ở controller đó
     */

    public function index($offset = 0) {
        $conditional = array();
        $this->set_conditional($conditional);
        $this->set_offset($offset);
        $this->show_table();
        $data = $this->data;
        $data['slide_menu'] = 'manager/common/slide-menu';
        $data['top_nav'] = 'manager/common/top-nav';
        $data['list_title'] = 'Danh sách các danh mục';
        $data['edit_title'] = 'Sửa thông tin danh mục';
        $data['content'] = 'base/index';
        $data['load_js'] = array('common_real_filter_contact');
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    protected function show_table() {
        /*
         * Lấy tổng các dòng
         */
        $get = $this->input->get();
        $input_get_arr = $this->_get_query_condition_arr($get);

        /*
         * Lấy điều kiện query từ các thao tác lọc, sắp xếp, tìm kiếm
         */
        $input_get = $input_get_arr['input_get'];
        $has_user_order = $input_get_arr['has_user_order'];

        $input_init = array();

        /*
         * Lấy điều kiện query do người dùng truyền vào, ví dụ chỉ hiển thị danh sách contacts đã thu Lakita
         */
        if (!empty($this->conditional)) {
            foreach ($this->conditional as $key => $value) {
                if ($key == 'order' && $has_user_order == 1) {
                    continue;
                }
                if ($key == 'order') {
                    $has_user_order = 1;
                }
                $input_init[$key] = $value;
            }
        }

        /*
         * Gộp 2 điều kiện query ta được điều kiện query tổng (lưu vào 1 mảng)
         */
        $input = array_merge_recursive($input_init, $input_get);

        $this->conditional = $input;
        $total_row = $this->{$this->model}->m_count_all_result_from_get($this->conditional);

        $this->data['total_rows'] = $total_row;

        /*
         * lấy data sau khi phân trang
         * $offset_max, $offset_std: dùng để đề phòng khi người dùng cố tình nhập sau offset trên thanh URL
         */
        $offset_max = intval($total_row / $this->limit) * $this->limit;
        $offset_std = ($this->offset > $offset_max) ? $offset_max : ((($this->offset < 0) ? 0 : $this->offset));
        $this->offset = $offset_std;
        if ($this->limit != 0 || $this->offset != 0) {
            $this->conditional['limit'] = array($this->limit, $this->offset);
        }
        //$this->conditional['limit'] = array(200, 0);
        //   print_arr($this->conditional);
        /*
         * kiểm tra xem $this->conditional đã có order chưa, nếu chưa thì để mặc định là order theo id desc
         */
        if (!$has_user_order) {
            $this->conditional['order'] = array('id' => 'DESC');
        }
        $this->data['rows'] = $this->{$this->model}->load_all($this->conditional);
         echoQuery();

        /*
         * Thấy thông tin hiển thị phân trang: thông tin hiển thị contact đầu, contact cuối và tổng contact
         */
        $base_url = ($this->sub_folder == '') ? $this->controller . '/' . $this->method : $this->sub_folder . '/' . $this->controller . '/' . $this->method;
        $this->num_segment = ($this->sub_folder == '') ? 3 : 4;

        $this->pagination_link = $this->_create_pagination_link($total_row, $base_url, $this->num_segment);
        $this->begin_paging = ($total_row == 0) ? 0 : $this->offset + 1;
        $this->end_paging = (($this->offset + $this->limit) < $total_row) ? ($this->offset + $this->limit) : $total_row;
        $this->total_paging = $total_row;
    }

    function show_add_item() {
        $this->load->view('base/add_item/ajax_content');
    }

    function show_edit_item($inputData = []) {
        $canEdited = 1;
        $data = $inputData;
        $post = $this->input->post();
        $input = array();
        $input['where'] = array('id' => $post['item_id']);
        $rows = $this->{$this->model}->load_all($input);
        if (empty($rows)) {
            echo 'Không tồn tại danh mục này!';
            die;
        }
        if ($this->role_id != 7) {
            if (isset($rows[0]['marketer_id']) && $rows[0]['marketer_id'] != $this->user_id) {
                $canEdited = 0;
            }
        }
        $data['edit_title'] = 'Chỉnh sửa';
        $data['row'] = $rows[0];
        $data['canEdited'] = $canEdited;
        $this->load->view('base/edit_item/ajax_content', $data);
    }

    public function delete_item() {
        $post = $this->input->post();
        if (!empty($post['item_id'])) {
            $where = array('id' => $post['item_id']);
            $this->{$this->model}->delete($where);
            echo '1';
        }
    }

    public function delete_multi_item() {
        $post = $this->input->post();
        if (!empty($post['item_id'])) {
            foreach ($post['item_id'] as $value) {
                $where = array('id' => $value);
                $this->{$this->model}->delete($where);
            }
        }
        show_error_and_redirect('Xóa thành công các dòng đã chọn!');
    }

    public function edit_active() {
        $post = $this->input->post();
        if (!empty($post['item_id'])) {
            $where = array('id' => $post['item_id']);
            $data = array('active' => $post['active']);
            $this->{$this->model}->update($where, $data);
            echo '1';
        }
    }

    protected function _get_query_condition_arr($get) {
        $input_get = array();
        $has_user_order = 0; //cờ kiểm tra nếu người dùng chọn order rồi thì ko order mặc định là id nữa
        //print_arr($get);
        if (is_array($get) && !empty($get)) {
            foreach ($get as $key => $value) {
                /*
                 * tìm kiếm tại ô trong bảng
                 */
                if (strpos($key, "find_") !== FALSE && $value != '') { //nếu tồn tại biến get tìm kiếm
                    $column_name = substr($key, strlen("find_"));
                    $input_get['like'][$column_name] = $value;
                }

                /*
                 * tìm kiếm tại ô trong bảng (các ô cố định khi người dùng cuộn chuột xuống)
                 */
                if (strpos($key, "search_") !== FALSE && $value != '') { //nếu tồn tại biến get tìm kiếm
                    $column_name = substr($key, strlen("search_"));
                    $input_get['like'][$column_name] = $value;
                }

                /*
                 * sắp xếp
                 */
                if (strpos($key, "order_new_") !== FALSE && $value != '0' && $value != '') { //nếu tồn tại biến get order
                    $column_name = substr($key, strlen("order_new_"));
                    $input_get['order'][$column_name] = $value;
                    $has_user_order = 1;
                }
                /*
                 * lọc theo các loại ngày
                 */
                if (strpos($key, "filter_date_from_") !== FALSE && $value != '') {
                    $column_name = substr($key, strlen("filter_date_from_"));
                    $input_get['where'][$column_name . '>='] = strtotime($value);
                }
                if (strpos($key, "filter_date_end_") !== FALSE && $value != '') {
                    $column_name = substr($key, strlen("filter_date_end_"));
                    $input_get['where'][$column_name . '<='] = strtotime($value) + 3600 * 24 - 1;
                }
                if (strpos($key, "filter_date_") !== FALSE && $value != '') {
                    $dateArr = explode('-', $value);
                    $date_from = trim($dateArr[0]);

                    $date_from = strtotime(str_replace("/", "-", $date_from));

                    $date_end = trim($dateArr[1]);
                    $date_end = strtotime(str_replace("/", "-", $date_end));
                    $column_name = substr($key, strlen("filter_date_"));
                    $input_get['where'][$column_name . '>='] = $date_from;
                    $input_get['where'][$column_name . '<='] = $date_end;
                }

                /*
                 * Lọc theo mảng (chọn nhiều)
                 */

                if (strpos($key, "filter_arr_multi_") !== FALSE && !empty($value)) {
                    $column_name = substr($key, strlen("filter_arr_multi_"));
                    $input_get['where_in'][$column_name] = $value;
                }

                /*
                 * 
                 * Lọc nhị phân
                 */
                if (strpos($key, "filter_binary_") !== FALSE && $value == 'yes') {
                    $column_name = substr($key, strlen("filter_binary_"));
                    $input_get['where'][$column_name . '!='] = '0';
                }
                if (strpos($key, "filter_binary_") !== FALSE && $value == 'no') {
                    $column_name = substr($key, strlen("filter_binary_"));
                    $input_get['where'][$column_name] = '0';
                }
            }
        }
        return array(
            'input_get' => $input_get,
            'has_user_order' => $has_user_order
        );
    }

    public function set_conditional($conditional) {
        $this->conditional = $conditional;
    }

    public function get_conditional() {
        return $this->conditional;
    }

    public function set_offset($offset) {
        $this->offset = $offset;
    }

    public function get_offset() {
        return $this->offset;
    }

    public function set_limit($limit) {
        $this->limit = $limit;
    }

    public function get_limit() {
        return $this->limit;
    }

    public function set_model($model) {
        $this->model = $model;
    }

    public function get_model() {
        return $this->model;
    }

    public function set_list_view($list_view) {
        $this->list_view = $list_view;
    }

    protected function _loadCountListContact() {
        $input = array();
        $input['select'] = 'id';
        $input['where']['date_rgt >'] = strtotime(date('d-m-Y'));
        $input['where']['is_hide'] = '0';
        $this->L['C3'] = count($this->contacts_model->load_all($input));

        $input = array();
        $input['select'] = 'id';
        $input['where']['is_hide'] = '0';
        $this->L['all'] = count($this->contacts_model->load_all($input));
    }

    protected function GetProccessMarketerToday() {
        $marketers = $this->staffs_model->GetActiveMarketers();

        foreach ($marketers as $key => &$marketer) {
            if ($marketer['username'] == 'trinhnv2' || $marketer['username'] == 'congnn2') {
                unset($marketers[$key]);
                continue;
            }
            $inputContact = array();
            $inputContact['select'] = 'id';
            $inputContact['where'] = array('marketer_id' => $marketer['id'], 'date_rgt >' => strtotime(date('d-m-Y')), 'is_hide' => '0');
            $today = $this->contacts_model->load_all($inputContact);
            $marketer['totalC3'] = count($today);
            $marketer['progress'] = ($marketer['targets'] > 0) ? round(($marketer['totalC3'] / $marketer['targets']) * 100, 2) : 'N/A';
        }
        unset($marketer);

        usort($marketers, function($a, $b) {
            return -$a['totalC3'] + $b['totalC3'];
        });
        $inputContact = array();
        $inputContact['select'] = 'id';
        $inputContact['where'] = array('date_rgt >' => strtotime(date('d-m-Y')), 'is_hide' => '0');
        $today = $this->contacts_model->load_all($inputContact);
        $C3Team = count($today);
        // print_arr($marketers);
        return array('marketers' => $marketers, 'C3Team' => $C3Team);
    }

    protected function GetProccessMarketerThisMonth() {
        $marketers = $this->staffs_model->GetActiveMarketers();
        foreach ($marketers as $key => &$marketer) {
            if ($marketer['username'] == 'trinhnv2' || $marketer['username'] == 'congnn2') {
                unset($marketers[$key]);
                continue;
            }
            $inputContact = array();
            $inputContact['select'] = 'id';
            $inputContact['where'] = array('marketer_id' => $marketer['id'], 'date_rgt >' => strtotime(date('01-m-Y')), 'is_hide' => '0');
            $today = $this->contacts_model->load_all($inputContact);
            $marketer['totalC3'] = count($today);
            $marketer['targets'] = $marketer['targets'] * 30;
            $marketer['progress'] = ($marketer['targets'] > 0) ? round(($marketer['totalC3'] / $marketer['targets']) * 100, 2) : 'N/A';
        }
        unset($marketer);
        usort($marketers, function($a, $b) {
            return -$a['totalC3'] + $b['totalC3'];
        });
        $inputContact = array();
        $inputContact['select'] = 'id';
        $inputContact['where'] = array('date_rgt >' => strtotime(date('01-m-Y')), 'is_hide' => '0');
        $today = $this->contacts_model->load_all($inputContact);
        $C3Team = count($today);
        // print_arr($marketers);
        return array('marketers' => $marketers, 'C3Team' => $C3Team);
    }

}
