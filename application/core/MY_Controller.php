<?php

/**
 * Description of MY_Controller
 *
 * @author CHUYEN
 */
class MY_Controller extends CI_Controller {

    var $data = array();
    var $user_id = '';
    var $per_page = 0;
    var $controller = '';
    var $method = '';
    public $begin_paging = 0;
    public $end_paging = 0;
    public $total_paging = 0;
    protected $table = '';
    protected $role_id = 0;
    public $can_view_contact = 0;
    public $can_edit_contact = 0;

    function __construct() {
        parent::__construct();
        //echo file_get_contents('https://www.viettelpost.com.vn/Tracking?KEY=MKI17LA310504');
        //echo time();die;
        date_default_timezone_set('Asia/Ho_Chi_Minh'); //setup lai timezone
        //   echo strtotime(date("Y-m-d", strtotime("+1 day"))); die;
        //echo date('H:i:s d/m/Y', 1507947420);die;
        //  echo time(). '<br>';
        // echo strtotime('01-10-2017 00:00:00'); die;
        // echo strtotime(date("d-m-Y"));die;
        //echo $this->input->ip_address();die;
        //echo md5(md5('lakita_quantri_2017')); die;
        $this->controller = $this->router->fetch_class();
        $this->method = $this->router->fetch_method();
        $this->_check_login();
        $this->_set_default_variable();
        $this->_check_permission();
        $this->_check_permission_edit_view();
        $this->_slogan();
        if ($this->config->item('show_profiler') === TRUE) {
            // $this->output->enable_profiler(TRUE);
        }
        $this->load->vars($this->data);
       // phpinfo();
    }

    private function _check_login() {
        /*
         * Kiểm tra xem người dùng đã đăng nhập chưa
         */

        if ($this->controller == 'report') {
            return true;
        }
        $user_id = $this->session->userdata('user_id');
        if (!isset($user_id)) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url('dang-nhap.html'));
            die;
        }
    }

    private function _set_default_variable() {
        $this->user_id = $this->session->userdata('user_id');
        $this->role_id = $this->session->userdata('role_id');

        /*
         * Lấy controller và action
         */

        $this->data['controller'] = $this->controller;
        $this->data['action'] = $this->method;

        /*
         * lấy thành phần chung là slide_menu và top_nav
         */
        $this->data['slide_menu'] = $this->controller . '/common/slide-menu';
        $this->data['top_nav'] = 'manager/common/top-nav';

        /*
         * Lấy số contact trên 1 trang, nếu người dùng nhập vào số contact
         * thì lấy số đó, nếu không để mặc định là 1 hằng số
         */
        if (isset($_GET['filter_number_records']) && $_GET['filter_number_records'] != '') {
            $this->per_page = $_GET['filter_number_records'];
        } else {
            $this->per_page = _PER_PAGE_;
        }

        /*
         * Lấy tên chức vụ và id của người dùng hệ thống
         */
        $this->load->model('role_model');
        $input = array();
        $role = $this->role_model->load_all($input);
        foreach ($role as $value) {
            if ($value['id'] == $this->session->userdata('role_id')) {
                $this->data['role_name'] = $value['chuc_vu'];
                break;
            }
        }

        /*
         * Gán trường cần hiện của bảng contact
         */

        $this->table = 'selection name phone address course_code price_purchase ';
    }

    private function _check_permission() {
        if ($this->controller == 'report') {
            return true;
        }
        $input = array();
        $input['where'] = array('role_id' => $this->role_id);
        $this->load->model('permission_model');
        $permissions = $this->permission_model->load_all($input);

        $input = array();
        $input['where'] = array('id' => $this->user_id);
        $user = $this->staffs_model->load_all($input);
        if ($user[0]['active'] == 0) {
            echo 'Tài khoản của bạn đã bị khóa, vui lòng liên hệ với quản lý để đc giúp đỡ';
            echo '<a href="' . base_url('home/logout') . '"> Đăng xuất </a>';
            die;
        }

        if (empty($permissions)) {
            redirect(base_url('no_access'));
            die;
        } else {
            $perArr = explode(';', $permissions[0]['permission']);
            if (empty($perArr)) {
                redirect(base_url('no_access'));
                die;
            } else {
                $flag = false;
                foreach ($perArr as $value) {
                    $perClass = explode('.', $value)[0];
                    $perMethod = explode('.', $value)[1];
                    if (($perClass == '*' && $perMethod == '*') || ($perClass == $this->controller && $perMethod == '*') || ($perClass == '*' && $perMethod == $this->method) || ($perClass == $this->controller && $perMethod == $this->method)) {
                        $flag = true;
                        break;
                    }
                }
                if (!$flag) {
                    redirect(base_url('no_access'));
                    die;
                }
            }
        }
    }

    private function _check_permission_edit_view() {
        $this->load->model('permission_edit_view');
        $input = array();
        $input['where'] = array('controller' => $this->controller, 'method' => $this->method);
        $edit_view = $this->permission_edit_view->load_all($input);
        if (!empty($edit_view)) {
            $this->can_edit_contact = $edit_view[0]['can_edit'];
            $this->can_view_contact = $edit_view[0]['can_view'];
        }
    }

    /*
     * Lấy các data cần thiết (để truyền sang view)
     */

    protected function _get_require_data($require_model) {
        $data = array();
        foreach ($require_model as $key => $value) {
            $model = $key . '_model';
            if ($key != 'staffs' && $key != 'contacts') { // 2 model load tự động
                $this->load->model($model);
            }
            $data[$key] = $this->{$model}->load_all($value);
        }
        return $data;
    }

    /*
     * Hàm tạo data phân trang
     * @param: url trang hiện tại, tổng số dòng 
     * @return: link phân trang
     */

    protected function _create_pagination_link($total_contact, $baseurl = '', $uri_segment = 3) {
        $this->load->library("pagination");
        $config = array();
        $baseURL = ($baseurl == '') ? $this->controller . '/' . $this->method : $baseurl;
        $config['base_url'] = base_url($baseURL);
        if (count($_GET) > 0) {
            $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        }
        $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);
        $config['total_rows'] = $total_contact;
        $config['per_page'] = $this->per_page;
        $config['uri_segment'] = $uri_segment;
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }

    /*
     * Query theo các điều kiện như filter, order, search
     * @param: biến get từ client gửi lên, điều kiện lọc thêm vói từng trường hợp, limit, offset
     * @return: mảng chứa thông tin các contact và tổng số contact thỏa điều kiện
     */

    protected function _query_all_from_get($get, $condition = [], $limit = 0, $offset = 0, $viewContactStar = 1) {
        if (count($get)) {
            $result = array();
        }
        $input_get_arr = $this->_get_query_condition_arr($get);

        $input_get = $input_get_arr['input_get'];
        $has_user_order = $input_get_arr['has_user_order'];

        $input_init = array();
        if (!empty($condition)) {
            foreach ($condition as $key => $value) {
                if ($key == 'order' && $has_user_order == 1) {
                    continue;
                }
                if ($key == 'order') {
                    $has_user_order = 1;
                }
                $input_init[$key] = $value;
            }
        }

        $input = array_merge_recursive($input_init, $input_get);
        if (!$has_user_order) {
            $input['order']['id'] = 'DESC';
        }

        $total_row = $this->contacts_model->m_count_all_result_from_get($input);
        $result['total_row'] = $total_row; //lấy tổng dòng
        //lấy data sau khi phân trang
        $offset_max = intval($total_row / $limit) * $limit;  //vị trí tối đa
        $offset1 = ($offset > $offset_max) ? $offset_max : ((($offset < 0) ? 0 : $offset));

        if ($limit != 0 || $offset != 0) {
            $input['limit'] = array($limit, $offset1);
        }
        $result['data'] = $this->contacts_model->load_all($input);

        // echoQuery();

        /*
         * Lấy thông tin 1 contact đăng ký nhiều khóa học
         */
        if ($viewContactStar) {
            if ((isset($condition['select']) && strpos($condition['select'], "phone") !== FALSE) || !isset($condition['select'])) {
                foreach ($result['data'] as &$value) {
                    $input = array();
                    $input['select'] = 'id';
                    $input['where'] = array('phone' => $value['phone'], 'is_hide' => '0');
                    $courses = $this->contacts_model->load_all($input);
                    $value['star'] = count($courses);
                }
                unset($value);
            }
        }


        //lấy thông tin hiển thị contact đầu, contact cuối và tổng contact
        $this->begin_paging = ($total_row == 0) ? 0 : $offset + 1;
        $this->end_paging = (($offset + $this->per_page) < $total_row) ? ($offset + $this->per_page) : $total_row;
        $this->total_paging = $total_row;

        return $result;
    }

    /*
     * Query theo điều kiện filter để lấy số liệu báo cáo
     * @param: biến get từ client gửi lên
     * @return: số dòng query được
     */

    protected function _query_for_report($get, $condition = []) {
        $input = array();
        $input['select'] = 'id';
        if (!empty($condition)) {
            foreach ($condition as $key => $value) {
                $input[$key] = $value;
            }
        }
        $input_get_arr = $this->_get_query_condition_arr($get);
        $input = array_merge_recursive($input, $input_get_arr['input_get']);
        $total_row = count($this->contacts_model->load_all($input));
        return $total_row;
    }

    /*
     * Hàm lấy data tìm kiếm
     * @param: biến get từ client gửi lên, điều kiện (với từng user cụ thể)
     * @return: dữ liệu ocntact tìm kiếm đc
     */

    protected function _common_find_all($get, $conditional = '') {
        $data = array();
        $require_model = array(
            'staffs' => array(
                'where' => array(
                    'role_id' => 1
                )
            ),
            'courses' => array(),
            'call_status' => array(),
            'ordering_status' => array(),
            'cod_status' => array()
        );
        $data = array_merge($this->data, $this->_get_require_data($require_model));
        if (count($get) > 0) {
            $data['contacts'] = $this->_query_find_contact($get, $conditional);
            $data['total_contact'] = count($data['contacts']);
            $total_row = $data['total_contact'];
            $this->begin_paging = ($total_row == 0) ? 0 : 1;
            $this->end_paging = ($total_row == 0) ? 0 : $total_row;
            $this->total_paging = $total_row;
        }
        return $data;
    }

    /*
     * Hàm lấy data tìm kiếm từ điều kiện get 
     * @param: biến get từ client gửi lên, điều kiện (với từng user cụ thể)
     * @return: dữ liệu oontact tìm kiếm đc
     */

    private function _query_find_contact($get, $condition = '') {
        $data = array();
        if (!empty($get)) {
            $query = 'SELECT * FROM `tbl_contact`';
            if ($get['name'] != '') {
                $query .= " WHERE (`name` like '%" . $get['name'] . "%'";
            } else {
                $query .= " WHERE (`name` like '/'";
            }
            if ($get['email'] != '') {
                $query .= " OR `email` like '%" . $get['email'] . "%'";
            }
            if ($get['phone'] != '') {
                $query .= " OR `phone` like '%" . $get['phone'] . "%'";
            }
            if ($get['id_contact'] != '') {
                $query .= " OR `id` =" . $get['id_contact'];
            }
            if ($get['name'] == '' && $get['email'] == '' && $get['phone'] == '' && $get['id_contact'] == '') {
                $query = 'SELECT * FROM `tbl_contact`';
                $query .= " WHERE (`name` like '/'";
            }
            $query .= ')' . $condition . ' ORDER BY `id` DESC LIMIT 10 OFFSET 0';
        }
        $data = $this->contacts_model->query2($query);
        return $data;
    }

    protected function _find_dupliacte_contact($email = '', $phone = '', $course_code = '') {
        $dulicate = 0;
        $input = array();
        $input['select'] = 'id';
        $input['where'] = array(
            'phone' => $phone,
            'course_code' => $course_code
        );
        $input['order'] = array('id', 'ASC');
        $rs = $this->contacts_model->load_all($input);
        if (count($rs) > 0) {
            $dulicate = $rs[0]['id'];
        }
        return $dulicate;
    }

    /*
     * Hàm ghi lại lịch sử chăm sóc của 1 contact 
     * @param: ID của contact, nội dung thay đổi
     * @return: void
     */

    protected function _set_call_log_common($contact_id, $content_change) {
        $this->load->model('call_log_model');
        $param['contact_id'] = $contact_id;
        $param['staff_id'] = $this->user_id;
        $param['content_change'] = $content_change;
        $param['time'] = time();
        $this->call_log_model->insert($param);
    }

    /*
     * Hàm bắn contact L8 sang MOL khi đối soát COD
     * @param: mảng ID contact
     * @return: void
     */

    protected function _put_L8_to_MOL($receiveCOD) {
        if (!empty($receiveCOD)) {
            $this->load->library('REST');
            $config = array('server' => 'http://mol.lakita.vn/',
                'api_key' => 'SSeKfm7RXCJZxnFUleFsPf63o2ymZ93fWuCmvCjq',
                'api_name' => 'key'
            );
            $this->rest->initialize($config);
            foreach ($receiveCOD as $value) {
                $param['contact_id'] = $value;
                $this->rest->post('contact_collection_api/C3L8', $param);
            }
        }
    }

    /*
     * Hàm lấy điều kiện để query khi có biến get từ client truyền lên
     * @param: biến GET
     * @return: mảng điều kiện query trong hàm load_all (được viết theo quy tắc ở MY_Model)
     */

    protected function _get_query_condition_arr($get) {

        $input_get = array();
        $this->load->model('setting_filter_sort_model');
        $setting_filter_sort = $this->setting_filter_sort_model->load_all();
        $has_user_order = 0; //cờ kiểm tra nếu người dùng chọn order rồi thì ko order mặc định là id nữa
        foreach ($setting_filter_sort as $value) {
            $valueArr = array();
            foreach ($value as $value2) {
                $valueArr[] = $value2;
            }
            list($id, $operator, $get_name, $equal_value, $case_equal, $type_query, $column_name, $specific_value) = $valueArr;
            if (($operator == 'equal' && isset($get[$get_name]) && $get[$get_name] == $equal_value) || ($operator == 'not_equal' && isset($get[$get_name]) && $get[$get_name] != $equal_value) || ($operator == 'array' && isset($get[$get_name]))) {
                switch ($case_equal) {
                    case 'get': {
                            $condition_value = $get[$get_name];
                            break;
                        }
                    case 'specific_value': {
                            $condition_value = $specific_value;
                            break;
                        }
                    case 'date_from': {
                            $condition_value = strtotime($get[$get_name]);
                            break;
                        }
                    case 'date_end': {
                            $condition_value = strtotime($get[$get_name]) + 3600 * 24;
                            break;
                        }
                }
                $input_get[$type_query][$column_name] = $condition_value;
                if ($type_query == 'order') {
                    $has_user_order = 1;
                }
            }
        }
        /*
         * Các trường hợp đặc biệt
         * 1. Báo đỏ, báo vàng sau khi giao đơn cho đơn vị giao hàng
         * lớn hơn 3, 5 ngày mà vẫn chưa thu đc tiền
         */
        if (isset($get['filter_warning_cod']) && $get['filter_warning_cod'] != 'empty') {
            if ($get['filter_warning_cod'] == 'red') {
                $query = '((FLOOR((' . time() . ' - `date_print_cod`) / (60 * 60 * 24)) > 5 ' .
                        'AND `cod_status_id` = 1)'
                        . ' OR `weight_envelope` > 50)';
                $input_get['where'][$query] = 'NO-VALUE';
            }
            if ($get['filter_warning_cod'] == 'yellow') {
                $query = '(FLOOR((' . time() . ' - `date_print_cod`) / (60 * 60 * 24)) <= 5 AND '
                        . 'FLOOR((' . time() . ' - `date_print_cod`) / (60 * 60 * 24)) >= 3 '
                        . 'AND `cod_status_id` = 1)';
                $input_get['where'][$query] = 'NO-VALUE';
            }
        }

        /*
         * Filter date
         */
        foreach ($get as $key => $value) {
            if (strpos($key, "filter_date_") !== FALSE && $value != '') {
                $dateArr = explode('-', $value);
                $date_from = trim($dateArr[0]);
                $date_from = strtotime(str_replace("/", "-", $date_from));
                $date_end = trim($dateArr[1]);
                $date_end = strtotime(str_replace("/", "-", $date_end)) + 3600 * 24;
                $column_name = substr($key, strlen("filter_date_"));
                $input_get['where'][$column_name . '>='] = $date_from;
                $input_get['where'][$column_name . '<='] = $date_end;
            }
        }



        /* search every where */

        if (isset($get['search_all']) && $get['search_all'] != '') {
            $input_get['group_start_like']['phone'] = $get['search_all'];
            $input_get['or_like']['name'] = $get['search_all'];
            $input_get['or_like']['code_cross_check'] = $get['search_all'];
            $input_get['or_like']['email'] = $get['search_all'];
            $input_get['or_like']['address'] = $get['search_all'];
            $input_get['or_like']['matrix'] = $get['search_all'];
            $input_get['group_end_or_like']['id'] = $get['search_all'];
        }

        return array(
            'input_get' => $input_get,
            'has_user_order' => $has_user_order
        );
    }

    protected function _ajax_redirect($location = '') {
        $location = empty($location) ? '/' : $location;
        if (strpos($location, '/') !== 0 || strpos($location, '://') !== FALSE) {
            if (!function_exists('site_url')) {
                $this->load->helper('url');
            }
            $location = site_url($location);
        }
        $script = "window.location='{$location}';";
        $this->output->enable_profiler(FALSE)
                ->set_content_type('application/x-javascript')
                ->set_output($script);
    }

    protected function renderJSON($json) {
        // Resources are one of the few things that the json
        // encoder will refuse to handle.
        if (is_resource($json)) {
            throw new \RuntimeException('Unable to encode and output the JSON data.');
        }
        $this->output->enable_profiler(FALSE)
                ->set_content_type('application/json')
                ->set_output(json_encode($json));
    }

    public function search($offset = 0) {

        $require_model = array(
            'staffs' => array(
                'where' => array(
                    'role_id' => 1,
                    'active' => 1
                )
            ),
            'courses' => array(
                'where' => array(
                    'active' => 1
                )
            ),
            'call_status' => array(),
            'ordering_status' => array(),
            'cod_status' => array(),
            'providers' => array(),
            'payment_method_rgt' => array(),
            'sources' => array()
        );
        $data = array_merge($this->data, $this->_get_require_data($require_model));

        $get = $this->input->get();
        /*
         * Điều kiện lấy contact :
         * contact ở trang chủ là contact chưa được phân cho TVTS nào và chua gọi lần nào
         *
         */

        $conditional['order'] = ['last_activity' => 'DESC'];
        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);
        /*
         * Lấy danh sách contacts
         */
        $contacts = $data_pagination['data'];
        foreach ($contacts as &$value) {
            $value['marketer_name'] = $this->staffs_model->find_staff_name($value['marketer_id']);
        }
        unset($value);

        $data['contacts'] = $contacts;

        $data['total_contact'] = $data_pagination['total_row'];
        /*
         * Lấy link phân trang
         */
        $data['pagination'] = $this->_create_pagination_link($this->controller . '/' . $this->method, $data_pagination['total_row']);
        /*
         * Filter ở cột trái và cột phải
         */
        $data['left_col'] = array('tu_van', 'duplicate', 'date_rgt');
        $data['right_col'] = array('course_code');

        /*
         * Các trường cần hiện của bảng contact (đã có default)
         */
        $this->table .= 'date_last_calling call_stt ordering_stt last_activity matrix';
        $data['table'] = explode(' ', $this->table);

        /*
         * Các file js cần load
         */
        $data['load_js'] = array(
            'common_view_detail_contact', 'common_real_filter_contact',
            'm_delete_one_contact', 'm_divide_contact', 'm_view_duplicate', 'm_delete_multi_contact'
        );
        $data['content'] = 'common/search_all';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    
    private function _slogan(){
        $slogan = array(
            'Không có gì là không thể với một người luôn biết cố gắng',
//            'Hãy luyện tập như thể bạn chưa bao giờ chiến thắng. Hãy hành động như thể chưa bao giờ bạn thất bại',
//            'Chỉ cần bạn không dừng lại thì việc bạn tiến chậm cũng không là vấn đề',
//            'Giữ đôi mắt của bạn hướng lên bầu trời và đôi chân trên mặt đất',
//            'Hãy không ngừng học hỏi. Nếu bạn là người thông minh nhất trong phòng thì thực sự là bạn đã ở nhầm chỗ',
//            'Không chuẩn bị nghĩa là bạn đã sẵn sàng cho việc thất bại',
            'Không bao giờ, không bao giờ, không bao giờ từ bỏ',
//            '<img src="https://wikiphunu.vn/wp-content/uploads/2016/10/nhung-cau-noi-hay-ve-cuoc-song-hang-ngay-cho-ban-co-them-dong-luc-2.jpg" />',
//            'Chỉ cần biết rằng, khi bạn thực sự muốn thành công, bạn sẽ không bao giờ từ bỏ, dù cho mọi thứ có tồi tệ đến đâu đi chăng nữa',
//            'Hãy chịu trách nhiệm về cuộc đời mình. Nên biết rằng chính bạn chứ không ai khác sẽ là người đưa bạn tới nơi bạn muốn',
//            'Thách thức là điều làm cho cuộc sống trở nên thú vị và vượt qua thử thách chính là những gì tạo nên ý nghĩa cuộc sống',
//            'I am thankful for all of those who said NO to me. Its because of them I\'m doing it myself',
//            'Khi bạn nói "Khó quá" đồng nghĩa với việc "Tôi không đủ mạnh mẽ để đấu tranh vì nó". Hãy ngừng ngay việc kêu ca. Hãy suy nghĩ tích cực!',
//            '<img src="http://loinoihay.net/wp-content/uploads/2016/03/Nh%E1%BB%AFng-c%C3%A2u-n%C3%B3i-t%E1%BA%A1o-%C4%91%E1%BB%99ng-l%E1%BB%B1c-s%E1%BB%91ng-cho-gi%E1%BB%9Bi-tr%E1%BA%BB-t%E1%BB%AB-c%C3%A1c-t%E1%BB%89-ph%C3%BA-tr%C3%AAn-th%E1%BA%BF-gi%E1%BB%9Bi6.jpg" />'
        );
        $sloganNumber = rand(0, count($slogan)-1);
        $this->data['mySlogan'] = $slogan[$sloganNumber];
       
    }
    
}
