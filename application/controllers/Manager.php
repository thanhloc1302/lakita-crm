<?php

/**
 * Description of Common
 *
 * @author CHUYEN
 */
class Manager extends MY_Controller {

    public $L = array();

    function __construct() {
        parent::__construct();
        $input = array();
        $input['select'] = 'id';
        $input['where'] = array('call_status_id' => '0', 'sale_staff_id' => '0', 'is_hide' => '0');
        $this->L['L1'] = count($this->contacts_model->load_all($input));
        $input = array();
        $input['select'] = 'id';
        $input['where'] = array('is_hide' => '0');
        $this->L['all'] = count($this->contacts_model->load_all($input));
    }

    function index($offset = 0) {
        $data = $this->get_all_require_data();
        $get = $this->input->get();
        /*
         * Điều kiện lấy contact :
         * contact ở trang chủ là contact chưa được phân cho TVTS nào và chua gọi lần nào
         *
         */

        $conditional['where'] = array('call_status_id' => '0', 'sale_staff_id' => '0', 'is_hide' => '0');
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
        $data['progress'] = $this->GetProccessToday();
        $data['progressType'] = 'Tiến độ các team ngày hôm nay';

        $data['total_contact'] = $data_pagination['total_row'];
        /*
         * Lấy link phân trang
         */
        $data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
        /*
         * Filter ở cột trái và cột phải
         */
        $data['left_col'] = array('tu_van', 'duplicate', 'date_rgt');
        $data['right_col'] = array('course_code');

        /*
         * Các trường cần hiện của bảng contact (đã có default)
         */
        $this->table .= 'date_rgt matrix';
        $data['table'] = explode(' ', $this->table);

        $data['titleListContact'] = 'Danh sách contact mới';
        $data['actionForm'] = 'manager/divide_contact';
        $informModal = 'manager/modal/divide_contact';
        $data['informModal'] = explode(' ', $informModal);
        $outformModal = 'manager/modal/divide_one_contact';
        $data['outformModal'] = explode(' ', $outformModal);

        /*
         * Các file js cần load
         */

        $data['load_js'] = array(
            'common_view_detail_contact', 'common_real_filter_contact',
            'm_delete_one_contact', 'm_divide_contact', 'm_view_duplicate', 'm_delete_multi_contact'
        );
        $data['content'] = 'common/list_contact';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    function view_all_contact($offset = 0) {
        $data = $this->get_all_require_data();
        /*
         * Lấy danh sách các marketer
         */
        $input = array();
        $input['where'] = array(
            'role_id' => 6,
            'active' => 1);
        $data['marketers'] = $this->staffs_model->load_all($input);

        $get = $this->input->get();
        /*
         * Điều kiện lấy contact :
         * lấy tất cả contact nên $conditional là mảng rỗng
         *
         */
        $conditional['where'] = array('is_hide' => '0');
        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, $offset);
        /*
         * Lấy link phân trang và danh sách contacts
         */
        $data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
        $contacts = $data_pagination['data'];
        foreach ($contacts as &$value) {
            $value['marketer_name'] = $this->staffs_model->find_staff_name($value['marketer_id']);
        }
        unset($value);
        $data['contacts'] = $contacts;
        $data['progress'] = $this->GetProccessThisMonth();
        $data['progressType'] = 'Tiến độ các team tháng này';

        $data['total_contact'] = $data_pagination['total_row'];

        /*
         * Filter ở cột trái và cột phải
         */
        $data['left_col'] = array('tu_van', 'duplicate', 'course_code', 'sale', 'marketer', 'channel', 'payment_method_rgt', 'date_rgt', 'date_handover');
        $data['right_col'] = array('source', 'call_status', 'ordering_status', 'cod_status', 'provider');

        /*
         * Các trường cần hiện của bảng contact (đã có default)
         */
        $this->table .= 'call_stt ordering_stt last_activity matrix';
        $data['table'] = explode(' ', $this->table);

        /*
         * Các file js cần load
         */
        $data['load_js'] = array(
            'common_view_detail_contact', 'common_real_filter_contact',
            'm_delete_one_contact', 'm_divide_contact', 'm_view_duplicate', 'm_delete_multi_contact'
        );

        $data['titleListContact'] = 'Danh sách toàn bộ contact';
        $data['actionForm'] = 'manager/divide_contact';
        $informModal = 'manager/modal/divide_contact';
        $data['informModal'] = explode(' ', $informModal);
        $outformModal = 'manager/modal/divide_one_contact';
        $data['outformModal'] = explode(' ', $outformModal);

        $data['content'] = 'common/list_contact';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    function view_pivot_table() {
        $data = $this->data;
        $data['left_col'] = array('date_rgt',);
        $data['load_js'] = array('m_pivot_table');
        $data['content'] = 'manager/pivot_table';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    function view_duplicate() {
        $require_model = array(
            'staffs' => array(
                'where' => array(
                    'role_id' => 1
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
            'payment_method_rgt' => array()
        );
        $data = array_merge($this->data, $this->_get_require_data($require_model));
        $post = $this->input->post();
        $input = array();
        $input['where'] = array('duplicate_id' => $post['duplicate_id']);
        $input['limit'] = array('10', '0');
        $duplicate_contacts = $this->contacts_model->load_all($input);
        $data['rows'] = $duplicate_contacts;
        $input3 = array();
        $input3['where'] = array('id' => $post['duplicate_id']);
        $primary_contact = $this->contacts_model->load_all($input3);
        $data['primary_contact'] = $primary_contact;
        $data['total_contact'] = count($duplicate_contacts);
        $this->load->view('manager/modal/view_duplicate', $data);
    }

    // <editor-fold defaultstate="collapsed" desc="hàm add contact và các hàm phụ trợ">
    /* ========================  hàm add contact và các hàm phụ trợ =========================== */

    public function add_contact() {
        $input = $this->input->post();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Họ tên', 'trim|required|min_length[2]');
        $this->form_validation->set_rules('address', 'Địa chỉ', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('phone', 'Số điện thoại', 'required|min_length[2]|integer');
        $this->form_validation->set_rules('course_code', 'Mã khóa học', 'required|callback_check_course_code');
        $this->form_validation->set_rules('source_id', 'Nguồn contact', 'required|callback_check_source_id');
        if (!empty($input)) {
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_tempdata('message', 'Có lỗi xảy ra trong quá trình nhập liệu', 2);
                $this->session->set_tempdata('msg_success', 0, 2);
                $this->_view_add_contact();
            } else {
                $param['name'] = $input['name'];
                $param['email'] = $input['email'];
                $param['address'] = $input['address'];
                $param['phone'] = trim($input['phone']);
                $param['course_code'] = $input['course_code'];
                $param['source_id'] = $input['source_id'];
                $param['payment_method_rgt'] = $input['payment_method_rgt'];
                $param['price_purchase'] = $input['price_purchase'];
                $param['date_rgt'] = time();
                $param['duplicate_id'] = $this->_find_dupliacte_contact($input['email'], $input['phone'], $input['course_code']);
                $param['last_activity'] = time();
                $id = $this->contacts_model->insert_return_id($param, 'id');
                if ($input['note'] != '') {
                    $param2 = array(
                        'contact_id' => $id,
                        'content' => $input['note'],
                        'time' => time(),
                        'sale_id' => $this->user_id,
                        'contact_code' => $this->contacts_model->get_contact_code($id)
                    );
                    $this->load->model('notes_model');
                    $this->notes_model->insert($param2);
                }
                $data2 = [];

                $data2['title'] = 'Có 1 contact mới đăng ký';
                $data2['message'] = 'Click để xem ngay';

                require_once APPPATH . 'libraries/Pusher.php';
                $options = array(
                    'cluster' => 'ap1',
                    'encrypted' => true
                );
                $pusher = new Pusher(
                        'e37045ff133e03de137a', 'f3707885b7e9d7c2718a', '428500', $options
                );
                $pusher->trigger('my-channel', 'notice', $data2);
                show_error_and_redirect('Thêm thành công contact', $input['back_location']);
            }
        } else {
            $this->_view_add_contact();
        }
    }

    private function _view_add_contact() {
        $require_model = array(
            'courses' => array(
                'where' => ['active' => '1'],
                'order' => ['course_code' => 'DESC']
            ),
            'sources' => array()
        );
        $data = array_merge($this->data, $this->_get_require_data($require_model));
        $data['content'] = 'manager/add_contact';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    function check_course_code($str) {
        if ($str == 'empty') {
            $this->form_validation->set_message('check_course_code', 'Vui lòng chọn {field}!');
            return false;
        }
        return true;
    }

    function check_source_id($str) {
        if ($str == 0) {
            $this->form_validation->set_message('check_source_id', 'Vui lòng chọn {field}!');
            return false;
        }
        return true;
    }

    /* ========================  hàm add contact và các hàm phụ trợ (hết) =========================== */

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="hàm chia contact (chia riêng contact) và các hàm phụ trợ">
    /* ========================  hàm chia contact (chia riêng contact) và các hàm phụ trợ =========================== */
    function divide_contact() {
        $post = $this->input->post();

        $this->_action_divide_contact($post);
    }

    /*
     * Chia contact
     */

    private function _action_divide_contact($post) {
        $result = array();
        $this->load->model('Staffs_model');
        if (empty($post)) {
            $result['success'] = 0;
            $result['message'] = "Có lỗi xảy ra! Mã lỗi : 30201";
            echo json_encode($result);
            die;
        }
        if (!isset($post['contact_id'])) {
            $result['success'] = 0;
            $result['message'] = "Vui lòng chọn contact!";
            echo json_encode($result);
            die;
        }
        $sale_id = $post['sale_id'];
        $contact_ids = is_array($post['contact_id']) ? $post['contact_id'] : array($post['contact_id']);
        $note = $post['note'];
        if ($sale_id == 0) {
            $result['success'] = 0;
            $result['message'] = "Vui lòng chọn nhân viên TVTS!";
            echo json_encode($result);
            die;
        }
        if (empty($contact_ids)) {
            $result['success'] = 0;
            $result['message'] = "Vui lòng chọn contact!";
            echo json_encode($result);
            die;
        }
        $checkContactCanBeDivide = $this->_check_contact_can_be_divide($contact_ids);
        if (!empty($checkContactCanBeDivide)) {
            echo json_encode($checkContactCanBeDivide);
            die;
        }
        $data = array(
            'sale_staff_id' => $sale_id,
            'date_handover' => time(),
            'last_activity' => time()
        );
        foreach ($contact_ids as $value) {
            $where = array('id' => $value);
            $this->contacts_model->update($where, $data);
        }
        if ($note != '') {
            $this->load->model('notes_model');
            foreach ($contact_ids as $value) {
                $param2 = array(
                    'contact_id' => $value,
                    'content' => $note,
                    'time' => time(),
                    'sale_id' => $this->user_id,
                    'contact_code' => $this->contacts_model->get_contact_code($value)
                );
                $this->notes_model->insert($param2);
            }
        }
        $staff_name = $this->Staffs_model->find_staff_name($sale_id);

        $result['success'] = 1;
        $result['message'] = 'Phân contact thành công cho nhân viên ' . $staff_name;
        echo json_encode($result);
        die;
    }

    /*
     * Check điều kiện chia contact (Contact không bị trùng và contact chưa được phân cho ai)
     */

    private function _check_contact_can_be_divide($contact_ids) {
        $result = array();
        $this->load->model('Staffs_model');
        foreach ($contact_ids as $value) {
            $input = array();
            $input['select'] = 'sale_staff_id, id, duplicate_id, is_hide';
            $input['where'] = array('id' => $value);
            $rows = $this->contacts_model->load_all($input);

            if (empty($rows)) {
                $result['success'] = 0;
                $result['message'] = "Không tồn tại khách hàng này! Mã lỗi : 30203";
            }
            if ($rows[0]['is_hide'] == '1') {
                $result['success'] = 0;
                $result['message'] = "Contact này đã bị xóa, vì vậy không thể phân contact này được!";
            }

            if ($rows[0]['sale_staff_id'] > 0) {
                $name = $this->Staffs_model->find_staff_name($rows[0]['sale_staff_id']);
                $msg = 'Contact có id = ' . $rows[0]['id'] . ' đã được phân cho TVTS: ' . $name . '. Vì vậy không thể phân tiếp được nữa!';
                $result['success'] = 0;
                $result['message'] = $msg;
            }
//            if ($this->role_id == 3 && $rows[0]['duplicate_id'] > 0) {
//                $msg = 'Contact "' . $rows[0]['name'] . '" có id = ' . $rows[0]['id'] . ' bị trùng. '
//                        . 'Vì vậy không thể phân contact đó được! Vui lòng thực hiện lại';
//                $result['success'] = 0;
//                $result['message'] = $msg;
//            }
        }

        return $result;
    }

    /* ========================  hàm chia contact (chia riêng contact) và các hàm phụ trợ  (hết) =========================== */

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="hàm chia contact (chia đều contact) và các hàm phụ trợ">
    /* ========================  hàm chia contact (chia đều contact) và các hàm phụ trợ =========================== */
    function divide_contact_even() {
        $post = $this->input->post();
        if (empty($post)) {
            die('Có lỗi xảy ra! Mã lỗi : 30401');
        }
        $contact_ids = $post['contact_id'];

        if (count($contact_ids) == 0) {
            $msg = 'Không có contact nào được chọn';
            show_error_and_redirect($msg, base_url('manager'), false);
        }

        $this->_check_contact_can_be_divide($contact_ids);

        /* reset toàn bộ contact phân nháp trước đó mà người dùng chưa hủy nháp */
        $data1 = array('has_draft_divide' => '0');
        $this->contacts_model->update(array(), $data1);

        /* Lưu nháp các contact đã chọn */
        foreach ($contact_ids as $value) {
            $where = array('id' => $value);
            $data2 = array('has_draft_divide' => 1);
            $this->contacts_model->update($where, $data2);
        }

        $require_model = array(
            'contacts' => array(
                'where' => array('has_draft_divide' => 1),
                'order' => array('id' => 'DESC')
            ),
            'staffs' => array(
                'where' => array('role_id' => 1, 'active' => 1),
            ),
            'courses' => array()
        );
        $data = array_merge($this->data, $this->_get_require_data($require_model));

        $this->table .= 'date_rgt matrix';
        $data['table'] = explode(' ', $this->table);
        $data['content'] = 'manager/divide_contact_even';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    function draft_divide_contact_even3() {
        $this->load->model('Staffs_model');
        $input = array();
        $input['where'] = array(
            'has_draft_divide' => 1
        );
        $input['order'] = array('id' => 'DESC');
        $contacts = $this->contacts_model->load_all($input);
        shuffle($contacts); //trộn đều các contact

        $post = $this->input->post();
        if (!empty($post['max_contact'])) {
            /* ================cập nhật contact max cho mỗi nhân viên ======================== */
            foreach ($post['max_contact'] as $key => $value) {
                if ($value == '' || intval($value) < 0) {
                    $name = $this->Staffs_model->find_staff_name($key);
                    $msg = 'Vui lòng điền số lượng contact tối đa cho nhân viên "' . $name . '". Tối thiểu là 0 contact.';
                    die($msg);
                }
                $data1 = array('max_contact' => $value);
                $where = array('id' => $key);
                $this->staffs_model->update($where, $data1);
            }
            $this->_common_load_view_draft_divide($contacts);
        } else {
            $this->_common_load_view_draft_divide($contacts);
        }
    }

    private function _common_load_view_draft_divide($contacts) {
        $require_model = array(
            'staffs' => array(
                'where' => array('role_id' => 1, 'active' => 1)
            ),
            'courses' => array()
        );
        $data = array_merge($this->data, $this->_get_require_data($require_model));

        foreach ($data['staffs'] as $key => $value) {
            $data['staffs'][$key]['count'] = 0;
        }

        $this->draft_divide_contact_even1($data['staffs'], $contacts, 0);

        foreach ($data['staffs'] as $key => $value) {
            $input = array();
            $input['where'] = array('draft_sale_staff_id' => $value['id']);
            $input['order'] = array('id' => 'DESC');
            $data['staffs'][$key]['contacts'] = $this->contacts_model->load_all($input);
            $data['staffs'][$key]['cancel_contact'] = 1;
        }
        $data['total_contact'] = count($contacts);
        $table = 'selection contact_id name phone address course_code price_purchase ';
        $table .= 'date_rgt matrix action';
        $data['table'] = explode(' ', $table);
        $data['load_js'] = array('m_cancel_contact');
        $data['content'] = 'manager/draft_divide_contact_even';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    function draft_divide_contact_even1($staffs, $contacts, $i) {
        /*
         * Hàm đệ quy chia đều contact
         * Chia từng contact 1 cho các TVTS với số lượng max của từng TVTS
         * $i: số thứ tự của contact
         */
        $stop = true; // cờ kiểm tra dừng chia
        foreach ($staffs as $key => $value) {
            if (!isset($contacts[$i]))
                return false;
            if ($value['count'] < $value['max_contact']) {
                $where = array('id' => $contacts[$i]['id']);
                $data = array(
                    'draft_sale_staff_id' => $value['id']
                );
                $this->contacts_model->update($where, $data);
                $staffs[$key]['count'] ++;
                $i++;
                $stop = false;
            }
        }
        if (!$stop) {
            $this->draft_divide_contact_even1($staffs, $contacts, $i);
        }
    }

    function cancel_multi_contact() {
        $post = $this->input->post();
        if (empty($post['contact_id'])) {
            redirect_and_die('Vui lòng chọn Contact!');
        }
        foreach ($post['contact_id'] as $value) {
            $where = array('id' => $value);
            $data = array('has_draft_divide' => '0', 'draft_sale_staff_id' => '0');
            $this->contacts_model->update($where, $data);
        }
        $msg = 'Bỏ chọn contact thành công!';
        show_error_and_redirect($msg);
    }

    function cancel_one_contact() {
        $post = $this->input->post();
        $post['contact_id'];
        if ($post['contact_id'] > 0) {
            $where = array('id' => $post['contact_id']);
            $data = array('has_draft_divide' => '0', 'draft_sale_staff_id' => '0');
            if ($this->contacts_model->update($where, $data)) {
                echo 1;
            }
        }
    }

    function confirm_divide_contact_even() {
        $post = $this->input->post();
        if (isset($post['submit_ok']) && $post['submit_ok'] == 'OK') {
            $query1 = 'UPDATE `tbl_contact` set `sale_staff_id` = `draft_sale_staff_id`, `date_handover`=' . time()
                    . ', `last_activity` = ' . time() . ' WHERE `draft_sale_staff_id` > 0';
            $query2 = 'UPDATE `tbl_contact` set `draft_sale_staff_id` = 0, `has_draft_divide` = 0 WHERE `draft_sale_staff_id` > 0';
            $total = $this->contacts_model->query($query1);
            $this->contacts_model->query($query2);
            $msg = 'Phân thành công ' . $total . ' contact!';
            show_error_and_redirect($msg, base_url('manager'));
        }
        if (isset($post['submit_cancel']) && $post['submit_cancel'] == 'Cancel') {
            $query = 'UPDATE `tbl_contact` set `draft_sale_staff_id` = 0, `has_draft_divide` = 0 WHERE `draft_sale_staff_id` > 0';
            $this->contacts_model->query($query);
            $msg = 'Hủy bỏ thành công nghiệp vụ phân đều contact';
            show_error_and_redirect($msg, base_url('manager'));
        }
    }

    /* ========================  hàm chia contact (chia đều contact) và các hàm phụ trợ (hết) =========================== */

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="hàm xóa contact và các hàm phụ trợ">
    /* ========================  hàm xóa contact và các hàm phụ trợ =========================== */
    function delete_contact() {
        $post = $this->input->post();
        if (empty($post['contact_id'])) {
            redirect_and_die('Vui lòng chọn contact!');
        }
        $this->_check_contact_can_be_delete($post['contact_id']);
        foreach ($post['contact_id'] as $value) {
            $where = array('id' => $value);
            $data = array('is_hide' => 1, 'last_activity' => time());
            $this->contacts_model->update($where, $data);
        }
        $msg = 'Xóa thành công các contact vừa chọn!';
        show_error_and_redirect($msg);
    }

    function delete_one_contact() {
        $post = $this->input->post();
        if (!empty($post['contact_id'])) {
            $this->_check_contact_can_be_delete(array($post['contact_id']));
            $where = array('id' => $post['contact_id']);
            $data = array('is_hide' => 1, 'last_activity' => time());
            $this->contacts_model->update($where, $data);
            echo '1';
        }
    }

    private function _check_contact_can_be_delete($list) {
        $this->load->model('Staffs_model');
        foreach ($list as $value) {
            $input = array();
            $input['select'] = 'duplicate_id, sale_staff_id';
            $input['where'] = array('id' => $value);
            $rows = $this->contacts_model->load_all($input);
            if ($rows[0]['duplicate_id'] == 0) {
                redirect_and_die('Contact ' . $rows[0]['name'] . ' không bị trùng, vì vậy không thể xóa contact này!');
            }
            if ($rows[0]['sale_staff_id'] > 0) {
                $name = $this->Staffs_model->find_staff_name($rows[0]['sale_staff_id']);
                $msg = 'Contact này đã được bàn giao cho TVST: "' . $name . '", vì vậy không thể xóa contact này!';
                redirect_and_die($msg);
            }
        }
    }

    /* ========================  hàm xóa contact và các hàm phụ trợ (hết) =========================== */

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Tìm kiếm contact">
    function find_contact() {
        $get = $this->input->get();
        $data = $this->_common_find_all($get);
        $this->table .= 'date_rgt date_last_calling call_stt ordering_stt action';
        $data['table'] = explode(' ', $this->table);
        $data['content'] = 'manager/find_contact';
        $data['load_js'] = array('common_real_search');
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Báo cáo TVTS">
    function view_report_sale() {
        $require_model = array(
            'courses' => array()
        );
        $data = array_merge($this->data, $this->_get_require_data($require_model));
        $get = $this->input->get();

        $input = array();
        $input['where'] = array('role_id' => 1);
        $staffs = $this->staffs_model->load_all($input);

        $conditionArr = array(
            'CHUA_GOI' => array(
                'where' => array('call_status_id' => '0'),
                'sum' => 0
            ),
            'L1' => array(
                'where' => array(),
                'sum' => 0
            ),
            'L2' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_),
                'sum' => 0
            ),
            'L6' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_),
                'sum' => 0
            ),
            'TU_CHOI_MUA' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _TU_CHOI_MUA_),
                'sum' => 0
            ),
            'CHUA_GIAO_HANG_COD' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_,
                    'payment_method_rgt' => '1', 'cod_status_id' => '0'),
                'sum' => 0
            ),
            'CHUA_GIAO_HANG_TRANSFER' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_,
                    'payment_method_rgt >' => '1', 'cod_status_id' => '0'),
                'sum' => 0
            ),
            'DANG_GIAO_HANG' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_,
                    'cod_status_id' => _DANG_GIAO_HANG_),
                'sum' => 0
            ),
            'DA_THU_COD' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_,
                    'cod_status_id' => _DA_THU_COD_),
                'sum' => 0
            ),
            'L8' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_,
                    'cod_status_id' => _DA_THU_LAKITA_),
                'sum' => 0
            ),
            'L7L8' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_,
                    '(`cod_status_id` = ' . _DA_THU_COD_ . ' OR `cod_status_id` = ' . _DA_THU_LAKITA_ . ')' => 'NO-VALUE'),
                'sum' => 0
            ),
            'HUY_DON' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_,
                    'cod_status_id' => _HUY_DON_),
                'sum' => 0
            ),
            'LC' => array(
                'where' => array(
                    '(`call_status_id` = ' . _SO_MAY_SAI_ . ' OR `call_status_id` = ' . _NHAM_MAY_ . ' OR `ordering_status_id` = ' . _CONTACT_CHET_ . ')' => 'NO-VALUE'),
                'sum' => 0
            ),
            'CON_CUU_DUOC' => array(
                'where' => array(
                    '(`call_status_id` = ' . _KHONG_NGHE_MAY_ . ' OR `ordering_status_id` in (' . _BAN_GOI_LAI_SAU_ . ' , ' . _CHAM_SOC_SAU_MOT_THOI_GIAN_ . ',' . _LAT_NUA_GOI_LAI_ . '))' => 'NO-VALUE'),
                'sum' => 0
            ),
        );
        foreach ($staffs as $key => $value) {
            foreach ($conditionArr as $key2 => $value2) {
                $conditional = array();
                $conditional['where']['sale_staff_id'] = $value['id'];
                if (!count($get)) {
                    $conditional['where']['date_handover >='] = strtotime(date('01-m-Y'));
                }
                foreach ($value2['where'] as $key3 => $value3) {
                    $conditional['where'][$key3] = $value3;
                }
                $staffs[$key][$key2] = $this->_query_for_report($get, $conditional);
                $conditionArr[$key2]['sum'] += $staffs[$key][$key2];
            }
        }
        foreach ($conditionArr as $key => $value) {
            $data[$key] = $value['sum'];
        }
        $data['staffs'] = $staffs;
        $data['left_col'] = array('date_handover');
        $data['right_col'] = array('course_code');
        $data['load_js'] = array('m_view_report');
        $data['content'] = 'manager/view_report';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Báo cáo doanh thu theo ngày nhận tiền">
    function view_report_revenue() {
        $this->load->helper('manager_helper');
        $data = $this->data;
        $get = $this->input->get();
        $input = array();
        $this->load->model('courses_model');
        $courses = $this->courses_model->load_all($input);
        $L7 = 0;
        $L8 = 0;
        $L7L8 = 0;
        /*
         * Lấy ngày nhận tiền và ngày phát thành công
         */
        if (isset($get['filter_date_report']) && $get['filter_date_report'] != '') {
            $dateArr = explode('-', $get['filter_date_report']);
            $date_report_from = trim($dateArr[0]);
            $date_report_from = strtotime(str_replace("/", "-", $date_report_from));
            $date_report_end = trim($dateArr[1]);
            $date_report_end = strtotime(str_replace("/", "-", $date_report_end)) + 3600 * 24;
        }

        if (isset($get['filter_date_deliver_success']) && $get['filter_date_deliver_success'] != '') {
            $dateArr = explode('-', $get['filter_date_deliver_success']);
            $date_deliver_success_from = trim($dateArr[0]);
            $date_deliver_success_from = strtotime(str_replace("/", "-", $date_deliver_success_from));
            $date_deliver_success_end = trim($dateArr[1]);
            $date_deliver_success_end = strtotime(str_replace("/", "-", $date_deliver_success_end)) + 3600 * 24;
        }

        foreach ($courses as $key => $value) {
            $conditional = array();
            $conditional['select'] = 'course_code, cod_status_id, price_purchase';
            if (!count($get)) {
                $conditional['where']['date_receive_cod >='] = strtotime(date('01-m-Y'));
            } else {
                $conditional['where']['date_receive_cod >='] = $date_report_from;
                $conditional['where']['date_receive_cod <='] = $date_report_end;
            }
            $conditional['where']['course_code'] = $value['course_code'];
            $conditional['where']['cod_status_id'] = _DA_THU_COD_;

            $_L7 = $this->contacts_model->load_all($conditional);
            $courses[$key]['L7'] = sum_L8($_L7);
            $L7 += $courses[$key]['L7'];

            $conditional = array();
            $conditional['select'] = 'course_code, cod_status_id, price_purchase';
            if (!count($get)) {
                $conditional['where']['date_receive_lakita >='] = strtotime(date('01-m-Y'));
            } else {
                $conditional['where']['date_receive_lakita >='] = $date_report_from;
                $conditional['where']['date_receive_lakita <='] = $date_report_end;
            }
            $conditional['where']['course_code'] = $value['course_code'];
            $conditional['where']['cod_status_id'] = _DA_THU_LAKITA_;

            /*
             * Xem theo ngày phát thành công
             */
            if (isset($get['filter_date_deliver_success']) && $get['filter_date_deliver_success'] != '') {
                $conditional['where']['date_deliver_success >='] = $date_deliver_success_from;
                $conditional['where']['date_deliver_success <='] = $date_deliver_success_end;
            }

            $_L8 = $this->contacts_model->load_all($conditional);
            $courses[$key]['L8'] = sum_L8($_L8);
            $L8 += $courses[$key]['L8'];

            $courses[$key]['L7L8'] = $courses[$key]['L7'] + $courses[$key]['L8'];
            $L7L8 += $courses[$key]['L7L8'];
        }
        //  print_arr($courses);
        usort($courses, function($a, $b) {
            return $a['L7L8'] - $b['L7L8'];
        });
        $data['L7'] = $L7;
        $data['L8'] = $L8;
        $data['L7L8'] = $L7L8;

        $input = array();
        $staffs = $this->staffs_model->load_all($input);
        $L7_TVTS = 0;
        $L8_TVTS = 0;
        $L7L8_TVTS = 0;
        foreach ($staffs as $key => $value) {
            $conditional = array();
            $conditional['select'] = 'course_code, cod_status_id, price_purchase';
            if (!count($get)) {
                $conditional['where']['date_receive_cod >='] = strtotime(date('01-m-Y'));
            } else {
                $conditional['where']['date_receive_cod >='] = $date_report_from;
                $conditional['where']['date_receive_cod <='] = $date_report_end;
            }
            $conditional['where']['sale_staff_id'] = $value['id'];
            $conditional['where']['cod_status_id'] = _DA_THU_COD_;
            $_L7 = $this->contacts_model->load_all($conditional);
            $staffs[$key]['L7'] = sum_L8($_L7);
            $L7_TVTS += $staffs[$key]['L7'];

            $conditional = array();
            $conditional['select'] = 'course_code, cod_status_id, price_purchase';
            if (!count($get)) {
                $conditional['where']['date_receive_lakita >='] = strtotime(date('01-m-Y'));
            } else {
                $conditional['where']['date_receive_lakita >='] = $date_report_from;
                $conditional['where']['date_receive_lakita <='] = $date_report_end;
            }
            $conditional['where']['sale_staff_id'] = $value['id'];
            $conditional['where']['cod_status_id'] = _DA_THU_LAKITA_;
            $_L8 = $this->contacts_model->load_all($conditional);
            $staffs[$key]['L8'] = sum_L8($_L8);
            $L8_TVTS += $staffs[$key]['L8'];
            $staffs[$key]['L7L8'] = $staffs[$key]['L7'] + $staffs[$key]['L8'];
            $L7L8_TVTS += $staffs[$key]['L7L8'];
        }
        $data['L7_TVTS'] = $L7_TVTS;
        $data['L8_TVTS'] = $L8_TVTS;
        $data['L7L8_TVTS'] = $L7L8_TVTS;
        $data['staffs'] = $staffs;
        $data['courses'] = $courses;
        $data['content'] = 'manager/view_report_revenue';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Báo cáo doanh thu theo ngày đăng ký">
    function view_report_revenue_by_date_rgt() {
        $data = $this->data;
        $get = $this->input->get();
        $input = array();
        $this->load->model('courses_model');
        $courses = $this->courses_model->load_all($input);
        $L7 = 0;
        $L8 = 0;
        $L7L8 = 0;
        foreach ($courses as $key => $value) {
            $conditional = array();
            $conditional['select'] = 'course_code, cod_status_id, price_purchase';
            if (!count($get)) {
                $conditional['where']['date_rgt >='] = strtotime(date('01-m-Y'));
            }
            $conditional['where']['course_code'] = $value['course_code'];
            $conditional['where']['cod_status_id'] = _DA_THU_COD_;
            if (isset($get['filter_date_report_from']) && $get['filter_date_report_from'] != '') {
                $conditional['where']['date_rgt >='] = strtotime($get['filter_date_report_from']);
            }
            if (isset($get['filter_date_report_end']) && $get['filter_date_report_end'] != '') {
                $conditional['where']['date_rgt <='] = strtotime($get['filter_date_report_end']) + 3600 * 24;
            }
            $_L7 = $this->contacts_model->load_all($conditional);
            $courses[$key]['L7'] = sum_L8($_L7);
            $L7 += $courses[$key]['L7'];

            $conditional = array();
            $conditional['select'] = 'course_code, cod_status_id, price_purchase';
            if (!count($get)) {
                $conditional['where']['date_rgt >='] = strtotime(date('01-m-Y'));
            }
            $conditional['where']['course_code'] = $value['course_code'];
            $conditional['where']['cod_status_id'] = _DA_THU_LAKITA_;
            if (isset($get['filter_date_report_from']) && $get['filter_date_report_from'] != '') {
                $conditional['where']['date_rgt >='] = strtotime($get['filter_date_report_from']);
            }
            if (isset($get['filter_date_report_end']) && $get['filter_date_report_end'] != '') {
                $conditional['where']['date_rgt <='] = strtotime($get['filter_date_report_end']) + 3600 * 24;
            }
            $_L8 = $this->contacts_model->load_all($conditional);
            $courses[$key]['L8'] = sum_L8($_L8);
            $L8 += $courses[$key]['L8'];

            $courses[$key]['L7L8'] = $courses[$key]['L7'] + $courses[$key]['L8'];
            $L7L8 += $courses[$key]['L7L8'];
        }
        $data['L7'] = $L7;
        $data['L8'] = $L8;
        $data['L7L8'] = $L7L8;

        $input = array();
        $staffs = $this->staffs_model->load_all($input);
        $L7_TVTS = 0;
        $L8_TVTS = 0;
        $L7L8_TVTS = 0;
        foreach ($staffs as $key => $value) {
            $conditional = array();
            $conditional['select'] = 'course_code, cod_status_id, price_purchase';
            if (!count($get)) {
                $conditional['where']['date_rgt >='] = strtotime(date('01-m-Y'));
            }
            $conditional['where']['sale_staff_id'] = $value['id'];
            $conditional['where']['cod_status_id'] = _DA_THU_COD_;
            if (isset($get['filter_date_report_from']) && $get['filter_date_report_from'] != '') {
                $conditional['where']['date_rgt >='] = strtotime($get['filter_date_report_from']);
            }
            if (isset($get['filter_date_report_end']) && $get['filter_date_report_end'] != '') {
                $conditional['where']['date_rgt <='] = strtotime($get['filter_date_report_end']) + 3600 * 24;
            }
            $_L7 = $this->contacts_model->load_all($conditional);
            $staffs[$key]['L7'] = sum_L8($_L7);
            $L7_TVTS += $staffs[$key]['L7'];

            $conditional = array();
            $conditional['select'] = 'course_code, cod_status_id, price_purchase';
            if (!count($get)) {
                $conditional['where']['date_rgt >='] = strtotime(date('01-m-Y'));
            }
            $conditional['where']['sale_staff_id'] = $value['id'];
            $conditional['where']['cod_status_id'] = _DA_THU_LAKITA_;
            if (isset($get['filter_date_report_from']) && $get['filter_date_report_from'] != '') {
                $conditional['where']['date_rgt >='] = strtotime($get['filter_date_report_from']);
            }
            if (isset($get['filter_date_report_end']) && $get['filter_date_report_end'] != '') {
                $conditional['where']['date_rgt <='] = strtotime($get['filter_date_report_end']) + 3600 * 24;
            }
            $_L8 = $this->contacts_model->load_all($conditional);
            $staffs[$key]['L8'] = sum_L8($_L8);
            $L8_TVTS += $courses[$key]['L8'];

            $staffs[$key]['L7L8'] = $staffs[$key]['L7'] + $staffs[$key]['L8'];
            $L7L8_TVTS += $staffs[$key]['L7L8'];
        }
        $data['L7_TVTS'] = $L7_TVTS;
        $data['L8_TVTS'] = $L8_TVTS;
        $data['L7L8_TVTS'] = $L7L8_TVTS;
        $data['staffs'] = $staffs;
        $data['courses'] = $courses;
        $data['content'] = 'manager/view_report_revenue_by_date_rgt';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    // </editor-fold>

    /*
     * Hàm xem báo cáo tổng hợp theo loại (kênh, sản phẩm, TVTS, đơn vị giao hàng)
     * Tham số: loại báo cáo muốn xem
     * Đầu ra: không có
     */
    function view_general_report($view = 'course') {
        $this->load->helper('manager_helper');
        $model = '';
        $key_tb = '';
        $name_showing = '';
        switch ($view) {
            case 'course': {
                    $model = 'courses';
                    $prop = 'course_code';
                    $key_tb = 'course_code';
                    $name_showing = 'course_code';
                    break;
                }
            case 'tvts': {
                    $model = 'staffs';
                    $prop = 'sale_staff_id';
                    $key_tb = 'id';
                    $name_showing = 'name';
                    break;
                }
            case 'provider': {
                    $model = 'providers';
                    $prop = 'provider_id';
                    $key_tb = 'id';
                    $name_showing = 'name';
                    break;
                }
        }
        $this->_generate_report($model, $prop, $key_tb, $name_showing);
    }

    /*
     * Hàm tạo view xem báo cáo
     * Tham số: 
     * $model: model tương ứng với loại báo cáo, ví dụ: báo cáo theo sản phẩm thì model là courses
     * $prop: tên trường tương ứng trong bảng tbl_contact, ví dụ: báo cáo theo sản phẩm thì trường tương ứng là courses_code
     * $key_tb: Khóa chính trong bảng tương ứng
     * $name_showing: trường tên của bảng đó
     */

    private function _generate_report($model, $prop, $key_tb, $name_showing) {
        $require_model = array(
            $model => array()
        );
        $data = array_merge($this->data, $this->_get_require_data($require_model));
        $model_data = $data[$model];
        $get = $this->input->get();

        $sumL8 = 0;
        $conditionArr = array(
            'L1' => array(
                'sum' => 0
            ),
            'L2' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_),
                'sum' => 0
            ),
            'L6' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_),
                'sum' => 0
            ),
            'L8' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_,
                    'cod_status_id' => _DA_THU_LAKITA_),
                'sum' => 0
            )
        );
        // print_arr($model_data);
        foreach ($model_data as $key => $value) {
            /*
             * Tính số L1, L2, L6, L8 theo từng khóa học
             */
            foreach ($conditionArr as $key2 => $value2) {
                $conditional = array();
                /* Điều kiện ràng buộc (khóa ngoại) */
                $conditional['where'][$prop] = $value[$key_tb];
                if (isset($value2['where'])) {
                    foreach ($value2['where'] as $key3 => $value3) {
                        $conditional['where'][$key3] = $value3;
                    }
                }
                //Mặc định là lấy dữ liệu từ đầu tháng
                if (!count($get)) {
                    $conditional['where']['date_handover >='] = strtotime(date("1-m-Y"));
                }
                $model_data[$key][$key2] = $this->_query_for_report($get, $conditional);
                $conditionArr[$key2]['sum'] += $model_data[$key][$key2];
            }

            if ($model_data[$key]['L1'] == 0) {
                unset($model_data[$key]);
                continue;
            }
            $model_data[$key]['L2/L1'] = ($model_data[$key]['L1'] != 0) ? round(($model_data[$key]['L2'] / $model_data[$key]['L1']) * 100, 2) . '%' : 'Không thể chia cho 0';
            $model_data[$key]['L6/L2'] = ($model_data[$key]['L2'] != 0) ? round(($model_data[$key]['L6'] / $model_data[$key]['L2']) * 100, 2) . '%' : 'Không thể chia cho 0';
            $model_data[$key]['L8/L6'] = ($model_data[$key]['L6'] != 0) ? round(($model_data[$key]['L8'] / $model_data[$key]['L6']) * 100, 2) . '%' : 'Không thể chia cho 0';
            $model_data[$key]['L8/L1'] = ($model_data[$key]['L1'] != 0) ? round(($model_data[$key]['L8'] / $model_data[$key]['L1']) * 100, 2) . '%' : 'Không thể chia cho 0';

            /*
             * Tính doanh thu theo từng khóa học
             */
            $conditional = array();
            $conditional['select'] = 'course_code, cod_status_id, price_purchase';
            if (!count($get)) {
                $conditional['where']['date_handover >='] = strtotime(date("1-m-Y"));
            }
            if (isset($get['filter_date_handover_from']) && $get['filter_date_handover_from'] != '') {
                $conditional['where']['date_handover >='] = strtotime($get['filter_date_handover_from']);
            }
            if (isset($get['filter_date_handover_end']) && $get['filter_date_handover_end'] != '') {
                $conditional['where']['date_handover <='] = strtotime($get['filter_date_handover_end']) + 3600 * 24;
            }
            $conditional['where'][$prop] = $value[$key_tb];
            $conditional['where']['cod_status_id'] = _DA_THU_LAKITA_;
            $_L8 = $this->contacts_model->load_all($conditional);
            $money = sum_L8($_L8);
            $model_data[$key]['sumL8'] = number_format($money, 0, ",", ".") . " VNĐ";
            $sumL8 += $money;
        }
        foreach ($conditionArr as $key => $value) {
            $data[$key] = $value['sum'];
        }

        $data['sumL8'] = $sumL8;
        $data['view'] = $model_data;
        $data['view_key'] = $key_tb;
        $data['name_showing'] = $name_showing;
        $data['prop'] = $prop;
        $data['left_col'] = array('course_code', 'date_handover');
        $data['right_col'] = array('date_last_calling');
        $data['load_js'] = array('m_view_report');
        $data['content'] = 'manager/view_general_report';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    function click_see() {
        $post = $this->input->post();
        switch ($post['type']) {
            case 'L6/L2' : {
                    $this->_report_detail_by_sale($post);
                    break;
                }
            case 'L8/L6' : {
                    $this->_report_detail_by_cod($post);
                    break;
                }
        }
    }

    private function _report_detail_by_sale($post) {
        //print_arr($post);

        $input = array();
        $input['where'] = array('role_id' => 1);
        $staffs = $this->staffs_model->load_all($input);

        $conditionArr = array(
            'L2' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_),
                'sum' => 0
            ),
            'L6' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_),
                'sum' => 0
        ));
        foreach ($staffs as $key => $value) {
            foreach ($conditionArr as $key2 => $value2) {
                $conditional = array();
                $conditional['where']['sale_staff_id'] = $value['id'];
                foreach ($value2['where'] as $key3 => $value3) {
                    $conditional['where'][$key3] = $value3;
                }
                if ($post['course_code'] != 'total') {
                    $conditional['where']['course_code'] = $post['course_code'];
                }
                if (!isset($post['filter_date_handover_from'])) {
                    $conditional['where']['date_handover >='] = strtotime(date("1-m-Y"));
                }
                $staffs[$key][$key2] = $this->_query_for_report($post, $conditional);
                $conditionArr[$key2]['sum'] += $staffs[$key][$key2];
                //echoQuery();
            }
        }
        foreach ($conditionArr as $key => $value) {
            $data[$key] = $value['sum'];
        }
        $data['course_code'] = $post['course_code'];
        $data['staffs'] = $staffs;
        $this->load->view('manager/report/view_report', $data);
    }

    private function _report_detail_by_cod($post) {
        //print_arr($post);
        $input = array();
        $this->load->model('providers_model');
        $providers = $this->providers_model->load_all($input);

        $conditionArr = array(
            'L6' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_,
                    'date_handover >=' => strtotime(date("1-m-Y"))),
                'sum' => 0
            ),
            'L8' => array(
                'where' => array('call_status_id' => _DA_LIEN_LAC_DUOC_, 'ordering_status_id' => _DONG_Y_MUA_,
                    'cod_status_id' => _DA_THU_LAKITA_, 'date_handover >=' => strtotime(date("1-m-Y"))),
                'sum' => 0
        ));
        foreach ($providers as $key => $value) {
            foreach ($conditionArr as $key2 => $value2) {
                $conditional = array();
                $conditional['where']['provider_id'] = $value['id'];
                foreach ($value2['where'] as $key3 => $value3) {
                    $conditional['where'][$key3] = $value3;
                }
                if ($post['course_code'] != 'total') {
                    $conditional['where']['course_code'] = $post['course_code'];
                }
                $providers[$key][$key2] = $this->_query_for_report($post, $conditional);
                $conditionArr[$key2]['sum'] += $providers[$key][$key2];
                //echoQuery();
            }
        }
        foreach ($conditionArr as $key => $value) {
            $data[$key] = $value['sum'];
        }
        $data['course_code'] = $post['course_code'];
        $data['providers'] = $providers;
        $this->load->view('manager/report/view_report_cod', $data);
    }

    // <editor-fold defaultstate="collapsed" desc="get_all_require_data">
    private function get_all_require_data() {
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
                ),
                'order' => array(
                    'course_code' => 'ASC'
                )
            ),
            'call_status' => array(),
            'ordering_status' => array(),
            'cod_status' => array(),
            'providers' => array(),
            'payment_method_rgt' => array(),
            'sources' => array(),
            'channel' => array()
        );
        return array_merge($this->data, $this->_get_require_data($require_model));
    }

    function test_report() {
        $content = file_get_contents('http://chuyenpn.com/crm/quan-ly/xem-bao-cao-tu-van-tuyen-sinh.html');
        var_dump($content);
    }

    function export_for_send_provider() {
        /* ====================xuất file excel============================== */
        $post = $this->input->post();
        if (empty($post['contact_id'])) {
            show_error_and_redirect('Vui lòng chọn contact cần xuất file excel', '', 0);
        }
        $this->load->model('call_status_model');
        $this->load->model('ordering_status_model');
        $this->load->model('cod_status_model');
        $this->load->model('notes_model');
        $this->load->model('staffs_model');
        $this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // $objPHPExcel->getActiveSheet()->getStyle("A1:H1")->getFont()->setSize(11)->setBold(true)->setName('Times New Roman');
        //     ->getColor()->setRGB('FFFFFF')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $styleArray = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => 'FFFFFF'),
                'size' => 15,
                'name' => 'Times New Roman'
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle("A1:I1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("A1:I1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('548235');
        $objPHPExcel->getActiveSheet()->getStyle("A1:I1")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $objPHPExcel->getActiveSheet()->getStyle("A2:I100")->getFont()->setSize(15)->setName('Times New Roman');
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
        $objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(73);

        foreach (range('A', 'G') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                    ->setAutoSize(true);
        }

        //set độ rộng của các cột
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);

        //set tên các cột cần in
        $rowCount = 1;
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, 'Contact id');
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, 'Họ tên');
        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, 'Email');
        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, 'SĐT');
        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, 'Địa chỉ');
        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, 'Trạng thái gọi');
        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, 'Trạng thái đơn hàng');
        $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, 'Trạng thái giao hàng');
        $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, 'Ma trận');
        $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, 'Ghi chú');
        $rowCount++;

        //đổ dữ liệu ra file excel
        foreach ($post['contact_id'] as $key => $value) {
            $input = array();
            $input['where'] = array('id' => $value);
            $contact = $this->contacts_model->load_all($input)[0];

            $all_note = '';
            $note = array();
            $note['where'] = array('contact_id' => $value);
            $notes = $this->notes_model->load_all($note);
            if (!empty($notes)) {
                foreach ($notes as $value2) {
                    $all_note .= 'Ngày: ' . date('H:i:s d/m/Y', $value2['time']) . ' - Người viết: '
                            . $this->staffs_model->find_staff_name($value2['sale_id']) . ' - Nội dung: ' . html_entity_decode($value2['content']);
                }
            }

            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $contact['id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $contact['name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $contact['email']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $contact['phone']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $contact['address']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $this->call_status_model->find_call_status_desc($contact['call_status_id']));
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $this->ordering_status_model->find_ordering_status_desc($contact['ordering_status_id']));
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $this->cod_status_model->find_cod_status_desc($contact['cod_status_id']));
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $contact['matrix']);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $all_note);
            $objPHPExcel->getActiveSheet()->getRowDimension($rowCount)->setRowHeight(35);
            $BStyle = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THICK,
                        'color' => array('rgb' => '151313')
                    )
                )
            );
            $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount . ':H' . $rowCount)->applyFromArray($BStyle);
            $rowCount++;
        }
//die;
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="02.Lakita_gui_danh_sach_khach_hang v' . date('Y.m.d') . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        die;
        /* ====================xuất file excel (end)============================== */
    }

    // </editor-fold>

    protected function GetProccessToday() {
        $progress = [];
        $inputContact = array();
        $inputContact['select'] = 'id';
        $inputContact['where'] = array('date_rgt >' => strtotime(date('d-m-Y')), 'is_hide' => '0');
        $today = $this->contacts_model->load_all($inputContact);
        $progress['marketing'] = array(
            'count' => count($today),
            'kpi' => MARKETING_KPI_PER_DAY,
            'name' => 'Marketing',
            'type' => 'C3');
        $progress['marketing']['progress'] = round($progress['marketing']['count'] / $progress['marketing']['kpi'] * 100, 2);

        $inputContact = array();
        $inputContact['select'] = 'id';
        $inputContact['where'] = array('date_confirm >' => strtotime(date('d-m-Y')), 'is_hide' => '0');
        $today = $this->contacts_model->load_all($inputContact);
        $progress['sale'] = array(
            'count' => count($today),
            'kpi' => TVTS_KPI_PER_DAY,
            'name' => 'TVTS',
            'type' => 'L6');
        $progress['sale']['progress'] = round($progress['sale']['count'] / $progress['sale']['kpi'] * 100, 2);

        return $progress;
    }

    protected function GetProccessThisMonth() {
        $progress = [];
        $inputContact = array();
        $inputContact['select'] = 'id';
        $inputContact['where'] = array('date_rgt >' => strtotime(date('01-m-Y')), 'is_hide' => '0');
        $today = $this->contacts_model->load_all($inputContact);
        $progress['marketing'] = array(
            'count' => count($today),
            'kpi' => 38 * 30,
            'name' => 'Marketing',
            'type' => 'C3');
        $progress['marketing']['progress'] = round($progress['marketing']['count'] / $progress['marketing']['kpi'] * 100, 2);

        $inputContact = array();
        $inputContact['select'] = 'id';
        $inputContact['where'] = array('date_confirm >' => strtotime(date('01-m-Y')), 'is_hide' => '0');
        $today = $this->contacts_model->load_all($inputContact);
        $progress['sale'] = array(
            'count' => count($today),
            'kpi' => 23 * 30,
            'name' => 'TVTS',
            'type' => 'L6');
        $progress['sale']['progress'] = round($progress['sale']['count'] / $progress['sale']['kpi'] * 100, 2);

        $inputContact = array();
        $inputContact['select'] = 'id';
        $inputContact['where'] = array('date_receive_lakita >' => strtotime(date('01-m-Y')), 'is_hide' => '0');
        $today = $this->contacts_model->load_all($inputContact);
        $progress['cod'] = array(
            'count' => count($today),
            'kpi' => 38 * 30 * 0.5,
            'name' => 'COD',
            'type' => 'L8');
        $progress['cod']['progress'] = round($progress['cod']['count'] / $progress['cod']['kpi'] * 100, 2);

        return $progress;
    }

}
