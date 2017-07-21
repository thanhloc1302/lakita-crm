<?php

/**
 * Description of Contact
 *
 * @author CHUYEN
 */
class Contact extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }
    // <editor-fold defaultstate="collapsed" desc="add-contact">
    public function add_contact() {
        $input = $this->input->post();
        // print_arr($input);
        // $this->load->model('temp_model');
        if (!empty($input)) {

            /* Lọc thông tin contact */
            $param['name'] = isset($input['name']) ? $input['name'] : '';
            $param['phone'] = isset($input['phone']) ? $input['phone'] : '';
            if ($param['name'] == '' || $param['phone'] == '')
                die;
            $email = isset($input['email']) ? $input['email'] : '';
            $param['email'] = str_replace('NO_PARAM@gmail.com', '', $email);
            $address = isset($input['dia_chi']) ? $input['dia_chi'] : '';
            $address .= ' ';
            $address .= isset($input['quan']) ? $input['quan'] : '';
            $address .= ' ';
            $address .= isset($input['tinh']) ? $input['tinh'] : '';
            $param['address'] = str_replace('NO_PARAM', '', $address);
            $param['is_consultant'] = (strpos($param['address'], 'TV_') !== false) ? 1 : 0;
            $param['course_code'] = isset($input['course_code']) ? $input['course_code'] : '';
            $param['price_purchase'] = isset($input['price_purchase']) ? $input['price_purchase'] : '';
            $param['matrix'] = isset($input['matrix']) ? $input['matrix'] : '';
            $param['payment_method_rgt'] = isset($input['payment_method_rgt']) ? $input['payment_method_rgt'] : 1;
            $param['date_rgt'] = time();
            $param['contact_id'] = $input['contact_id'];

            if (isset($input['contact_cc'])) {
                $this->load->model('contact_cc_model');
                $this->contact_cc_model->insert_from_mol($param);
            } else {
                /* ======= Lọc trùng contact ============ */
                $param['duplicate_id'] = $this->_find_dupliacte_contact($input['email'], $input['phone'], $input['course_code']);
                $this->contacts_model->insert_from_mol($param);
            }

            $this->load->model('last_contact_id_model');
            $this->last_contact_id_model->update(array(), array('id' => time()));
        }
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="divide(back-up)">
//    public function divide($id) {
//        $user_id = $this->session->userdata('user_id');
//        if (!isset($user_id)) {
//            echo 'Bạn chưa đăng nhập!';
//            die;
//        }
//        if (!in_array($this->session->userdata('role_id'), array(3))) {
//            echo 'Bạn không có quyền bàn giao contact!';
//            die;
//        }
//        $input = array();
//        $input['where'] = array('id' => $id);
//        $rows = $this->contacts_model->load_all($input);
//
//        if (empty($rows)) {
//            echo 'Không tồn tại khách hàng này!';
//            die;
//        }
//
//        if ($rows[0]['sale_staff_id'] > 0) {
//            $input2 = array();
//            $input2['where'] = array('role_id' => 1, 'id' => $rows[0]['sale_staff_id']);
//            
//            $staff = $this->staffs_model->load_all($input2);
//            $this->session->set_tempdata('message', 'Contact này đã được phân cho TVTS: ' . $staff[0]['name'] . '. Vì vậy không thể phân tiếp được nữa!', 5);
//            $this->session->set_tempdata('msg_success', 0, 5);
//            echo "<script>location.href='" . $_SERVER['HTTP_REFERER'] . "';</script>";
//            die;
//        }
//
//        $input2 = array();
//        $input2['where'] = array('role_id' => 1);
//        
//        $staff = $this->staffs_model->load_all($input2);
//
//        $input3 = array();
//        $input3['where'] = array('contact_id' => $id);
//        $this->load->model('notes_model');
//        $note = $this->notes_model->load_all($input3);
//
//        $data = $this->data;
//        if (!empty($this->input->post())) {
//            $post = $this->input->post();
//            if ($post['sale_staff_id'] == 0) {
//                echo '<script> alert("Vui lòng chọn nhân viên sale!");</script>';
//                echo "<script>location.href='" . $_SERVER['HTTP_REFERER'] . "';</script>";
//                die;
//            }
//            $where = array('id' => $id);
//            $param = array(
//                'sale_staff_id' => $post['sale_staff_id'],
//                'date_handover' => time()
//            );
//            
//            $this->contacts_model->update($where, $param);
//
//            if ($post['note'] != '') {
//                $param2 = array(
//                    'contact_id' => $id,
//                    'content' => $post['note'],
//                    'time' => time(),
//                    'sale_id' => $user_id
//                );
//                $this->load->model('notes_model');
//                $this->notes_model->insert($param2);
//            }
//
//            $this->session->set_flashdata('message', 'Bàn giao thành công contact!');
//
//            $input = array();
//            $input['where'] = array('id' => $id);
//            $rows = $this->contacts_model->load_all($input);
//
//            $input3 = array();
//            $input3['where'] = array('contact_id' => $id);
//            $this->load->model('notes_model');
//            $note = $this->notes_model->load_all($input3);
//
//            $data['rows'] = $rows[0];
//            $data['note'] = $note;
//            $data['staff'] = $staff;
//            $data['content'] = 'contact/divide';
//            $this->load->view(_MAIN_LAYOUT_, $data);
//        } else {
//            $data['staff'] = $staff;
//            $data['note'] = $note;
//            $data['rows'] = $rows[0];
//            $data['content'] = 'contact/divide';
//            $this->load->view(_MAIN_LAYOUT_, $data);
//        }
//    }
    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="edit (back-up)">
//    public function edit($id) {
//        $user_id = $this->session->userdata('user_id');
//        if (!isset($user_id)) {
//            echo 'Bạn chưa đăng nhập!';
//            die;
//        }
//        if (!in_array($this->session->userdata('role_id'), array(1))) { /* chỉ nhân viên TVTS mới có quyền chăm sóc */
//            echo 'Bạn không có quyền chăm sóc contact này!';
//            die;
//        }
//        $input = array();
//        $input['where'] = array('id' => $id);
//        $rows = $this->contacts_model->load_all($input);
//
//        if (empty($rows)) {
//            echo 'Không tồn tại khách hàng này!';
//            die;
//        }
//
//        if ($rows[0]['sale_staff_id'] != $user_id) {
//            echo 'Contac này không được phân cho bạn!';
//            die;
//        }
//
//        $input3 = array();
//        $input3['where'] = array('contact_id' => $id);
//        $this->load->model('notes_model');
//        $note = $this->notes_model->load_all($input3);
//
//        $input2 = array();
//        
//        $staff = $this->staffs_model->load_all($input2);
//
//        $input4 = array();
//        $input4['where'] = array('contact_id' => $id);
//        $this->load->model("transfer_logs_model");
//        $transfer_log = $this->transfer_logs_model->load_all($input4);
//
//        $edited_contact = true;
//        if (in_array($rows[0]['call_status_id'], array(1, 3, 5)) || in_array($rows[0]['ordering_status_id'], array(3, 4))) {
//            $edited_contact = false;
//        }
//
//        if (!empty($this->input->post())) {
//            $post = $this->input->post();
//            $where = array('id' => $id);
//            $param = array(
//                'name' => $post['name'],
//                'email' => $post['email'],
//                'phone' => $post['phone'],
//                'address' => $post['address'],
//                'course_code' => $post['course_code'],
//                'price_purchase' => $post['price_purchase'],
//                'call_status_id' => $post['call_status_id'],
//                'ordering_status_id' => $post['ordering_status_id'],
//                'date_recall' => isset($post['date_recall']) ? strtotime($post['date_recall']) : 0
//            );
//
//            if ($post['call_status_id'] == 0) {
//                echo '<script> alert("Bạn phải cập nhật trạng thái cuộc gọi!");</script>';
//                echo "<script>location.href='" . $_SERVER['HTTP_REFERER'] . "';</script>";
//                die;
//            }
//
//            if (!$edited_contact) {
//                echo '<script> alert("Contact này đang ở trạng thái không thể chăm sóc được nữa!");</script>';
//                echo "<script>location.href='" . $_SERVER['HTTP_REFERER'] . "';</script>";
//                die;
//            }
//
//            if ($post['ordering_status_id'] == 4 && $rows[0]['date_last_calling'] == 0) {
//                $param['date_confirm'] = time();
//                $param['date_last_calling'] = time();
//            } else if (($post['ordering_status_id'] == 4 && $rows[0]['date_last_calling'] > 0)) {
//                $param['date_confirm'] = time();
//            } else {
//                $param['date_last_calling'] = time();
//            }
//            
//            $this->contacts_model->update($where, $param);
//
//            if ($post['note'] != '') {
//                $param2 = array(
//                    'contact_id' => $id,
//                    'content' => $post['note'],
//                    'time' => time(),
//                    'sale_id' => $user_id
//                );
//                $this->load->model('notes_model');
//                $this->notes_model->insert($param2);
//            }
//
//            echo "<script> window.close(); </script>";
//
////                    $this->session->set_flashdata('message', 'Cập nhật thành công contact!');
////
////                    $input = array();
////                    $input['where'] = array('id' => $id);
////                    $rows = $this->contacts_model->load_all($input);
////
////                    $input3 = array();
////                    $input3['where'] = array('contact_id' => $id);
////                    $this->load->model('notes_model');
////                    $note = $this->notes_model->load_all($input3);
////
////                    $data['staff'] = $staff;
////                    $data['note'] = $note;
////                    $data['rows'] = $rows[0];
////                    $data['content'] = 'contact/edit';
////                    $this->load->view(_MAIN_LAYOUT_, $data);
//        } else {
//            $data = $this->data;
//            $data['transfer_log'] = $transfer_log;
//            $data['edited_contact'] = $edited_contact;
//            $data['staff'] = $staff;
//            $data['note'] = $note;
//            $data['rows'] = $rows[0];
//            $data['content'] = 'contact/edit';
//            $this->load->view(_MAIN_LAYOUT_, $data);
//        }
//    }
// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="view(back-up)">
//    public function view($id) {
//        $user_id = $this->session->userdata('user_id');
//        if (!isset($user_id)) {
//            echo 'Bạn chưa đăng nhập!';
//            die;
//        }
//
//        if (!in_array($this->session->userdata('role_id'), array(1, 3, 4))) {
//            echo 'Bạn không có quyền xem contact này!';
//            die;
//        }
//
//        $input = array();
//        $input['where'] = array('id' => $id);
//        $rows = $this->contacts_model->load_all($input);
//
//        if (empty($rows)) {
//            echo 'Không tồn tại khách hàng này!';
//            die;
//        }
//
//        $role_id = $this->session->userdata('role_id');
//        if ($rows[0]['sale_staff_id'] != $user_id && $role_id != 3) {
//            echo 'Contact này không được phân cho bạn, vì vậy bạn không thể xem được contact này!';
//            die;
//        }
//
//        $input3 = array();
//        $input3['where'] = array('contact_id' => $id);
//        $this->load->model('notes_model');
//        $note = $this->notes_model->load_all($input3);
//
//        $input2 = array();
//        
//        $staff = $this->staffs_model->load_all($input2);
//
//        $input4 = array();
//        $input4['where'] = array('contact_id' => $id);
//        $this->load->model("transfer_logs_model");
//        $transfer_log = $this->transfer_logs_model->load_all($input4);
//
//        $data = $this->data;
//        $data['transfer_log'] = $transfer_log;
//        $data['staff'] = $staff;
//        $data['note'] = $note;
//        $data['rows'] = $rows[0];
//        $data['content'] = 'contact/view';
//        $this->load->view(_MAIN_LAYOUT_, $data);
//    }
// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="add-contact-2(back-up)">
//    public function add_contact_2() {
//        $user_id = $this->session->userdata('user_id');
//        if (!isset($user_id)) {
//            echo 'Bạn chưa đăng nhập!';
//            die;
//        }
//        $input = $this->input->post();
//        // print_arr($input);
//        // $this->load->model('temp_model');
//        if (!empty($input)) {
//
//            /* Lọc thông tin contact */
//            $param['name'] = isset($input['name']) ? $input['name'] : '';
//            $param['email'] = isset($input['email']) ? $input['email'] : '';
//            $param['address'] = isset($input['dia_chi']) ? $input['dia_chi'] : '';
//            $param['address'] .= ' - ';
//            $param['address'] .= isset($input['quan']) ? $input['quan'] : '';
//            $param['address'] .= ' - ';
//            $param['address'] .= isset($input['tinh']) ? $input['tinh'] : '';
//            $param['phone'] = isset($input['phone']) ? $input['phone'] : '';
//            $param['course_code'] = isset($input['course_code']) ? $input['course_code'] : '';
//            $param['price_purchase'] = isset($input['price_purchase']) ? $input['price_purchase'] : '';
//            $param['matrix'] = isset($input['matrix']) ? $input['matrix'] : '';
//            $param['date_rgt'] = time();
//
//            if ($param['name'] == '' || $param['phone'] == '')
//                die;
//
//            if (isset($input['contact_cc'])) {
//                $this->load->model('contact_cc_model');
//                $this->contact_cc_model->insert($param);
//            } else {
//                /* ======= Lọc trùng contact ============ */
//                $param['duplicate_id'] = $this->_find_dupliacte_contact($input['email'], $input['phone'], $input['course_code']);
//                $this->contacts_model->insert($param);
//            }
//        }
//
//        $data = $this->data;
//        $data['content'] = 'contact/add_contact_2';
//        $this->load->view(_MAIN_LAYOUT_, $data);
//    }
    // </editor-fold> 
    // <editor-fold defaultstate="collapsed" desc="private function">   

    private function _find_dupliacte_contact($email = '', $phone = '', $course_code = '') {
        $dulicate = 0;
        $input = array();
        $input['where'] = array(
            'phone' => $phone,
            'course_code' => $course_code
        );
        $input['order'] = array('id', 'ASC');
        $rs = $this->contacts_model->load_all($input);
        if (count($rs) > 0) {
            $dulicate = $rs[0]['id'];
        }
//        else {
//            if ($email != "" && $email != "lapbctc20164@gmail.com") {
//                $input2 = array();
//                $input2['where'] = array(
//                    'email' => $email,
//                    'course_code' => $course_code
//                );
//                $input2['order'] = array('id', 'ASC');
//                $rs2 = $this->contacts_model->load_all($input2);
//                if (count($rs2) > 0) {
//                    $dulicate = $rs2[0]['id'];
//                }
//            }
//        }
        return $dulicate;
    }

    // </editor-fold>
}
