<?php

/**
 * Description of Common
 *
 * @author CHUYEN
 */
class Common extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    public function view_detail_contact() {
        $post = $this->input->post();
        $id = $post['contact_id'];
        $this->_common_view_contact($id);
    }

    private function _common_view_contact($id) {
        $input = array();
        $input['where'] = array('id' => $id);
        $rows = $this->contacts_model->load_all_contacts($input);
        if (empty($rows)) {
            echo 'Không tồn tại contact này!';
            die;
        }
        $contact_code = $rows[0]['phone'] . '_' . $rows[0]['course_code'];
        $require_model = array(
            'staffs' => array(),
            'courses' => array(),
            'notes' => array(
                'where' => array('contact_code' => $contact_code),
                'order' => array('time' => 'ASC')
            ),
            'transfer_logs' => array(
                'where' => array('contact_id' => $id)
            ),
            'call_status' => array(
                'order' => array('sort' => 'ASC')
            ),
            'ordering_status' => array(
                'order' => array('sort' => 'ASC')
            ),
            'payment_method_rgt' => array(),
            'cod_status' => array(),
            'providers' => array(),
            'sources' => array()
        );
        $data = array_merge($this->data, $this->_get_require_data($require_model));
        $left_view = array(
            'contact_id' => 'view',
            'name' => 'view',
            'email' => 'view',
            'phone' => 'view',
            'address' => 'view',
            'course_code' => 'view',
            'price_purchase' => 'view',
            'date_rgt' => 'view',
            'matrix' => 'view',
            'sale' => 'view',
            'date_handover' => 'view',
            'source' => 'view'
        );
        $right_view = array(
            'transfer_log' => 'view',
            'date_last_calling' => 'view',
            'call_stt' => 'view',
            'date_recall' => 'view',
            'ordering_stt' => 'view',
            'date_confirm' => 'view',
            'payment_method_rgt' => 'view',
            'cod_status' => 'view',
            'date_print_cod' => 'view',
            'weight_envelope' => 'view',
            'cod_fee' => 'view',
            'fee_resend' => 'view',
            'provider' => 'view',
            'code_cross_check' => 'view',
            'note' => 'view',
            'note_cod' => 'view'
        );
        $data['view_edit_left'] = $left_view;
        $data['view_edit_right'] = $right_view;
        $input_call_log = array();
        $input_call_log['where'] = array('contact_id' => $id);
        $input_call_log['order'] = array('time' => 'ASC');
        $this->load->model('call_log_model');
        $data['call_logs'] = $this->call_log_model->load_all_call_log($input_call_log);
        $data['rows'] = $rows[0];
        $result = array();
        $result['success'] = 1;
        $result['message'] = $this->load->view('common/modal/view_detail_contact', $data, true);
        echo json_encode($result);
        die;
    }

    function show_edit_contact_modal() {
        $post = $this->input->post();
        if ($this->role_id == 1) {  //sale
            $left_edit = array(
                'contact_id' => 'view',
                'name' => 'edit',
                'email' => 'edit',
                'phone' => 'view',
                'address' => 'edit',
                'course_code' => 'edit',
                'price_purchase' => 'edit',
                'date_rgt' => 'view',
                'matrix' => 'view',
                'date_handover' => 'view',
            );
            $right_edit = array(
                'transfer_log' => 'view',
                'date_last_calling' => 'view',
                'date_confirm' => 'view',
                'payment_method_rgt' => 'edit',
                'script' => 'edit',
                'call_stt' => 'edit',
                'ordering_stt' => 'edit',
                'date_recall' => 'edit',
                'date_expect_receive_cod' => 'edit',
                'send_banking_info' => 'edit',
                'note' => 'edit',
                'note_cod' => 'edit'
            );
        }
        if ($this->role_id == 2) {
            $left_edit = array(
                'contact_id' => 'view',
                'name' => 'view',
                'email' => 'view',
                'phone' => 'view',
                'address' => 'edit',
                'course_code' => 'view',
                'price_purchase' => 'view',
                'date_rgt' => 'view',
                'matrix' => 'view',
                'date_handover' => 'view',
            );
            $right_edit = array(
                'sale' => 'view',
                'date_confirm' => 'view',
                'payment_method_rgt' => 'edit',
                'date_expect_receive_cod' => 'edit',
                'code_cross_check' => 'edit',
                'provider' => 'edit',
                'cod_status' => 'edit',
                'weight_envelope' => 'edit',
                'cod_fee' => 'edit',
                'fee_resend' => 'edit',
                'send_banking_info' => 'edit',
                'send_account_lakita' => 'edit',
                'note' => 'edit',
                'note_cod' => 'edit'
            );
        }
        $this->_common_edit_contact($post, $left_edit, $right_edit);
    }

    protected function _common_edit_contact($post, $left_edit, $right_edit) {
        $input = array();
        $input['where'] = array('id' => $post['contact_id']);
        $rows = $this->contacts_model->load_all_contacts($input);
        $result = array();
        if (empty($rows)) {
            $result['success'] = 0;
            $result['message'] = 'Không tồn tại khách hàng này!';
            echo json_encode($result);
            die;
        }

        if ($this->role_id == 1 && $rows[0]['sale_staff_id'] != $this->user_id) {
            $result['success'] = 0;
            $result['message'] = 'Contact này không được phân cho bạn!';
            echo json_encode($result);
            die;
        }

        if ($this->role_id != 1 && $this->role_id != 2) {
            $result['success'] = 0;
            $result['message'] = 'Bạn không có quyền chỉnh sửa contact này!';
            echo json_encode($result);
            die;
        }

        $id = $post['contact_id'];
        $contact_code = $rows[0]['phone'] . '_' . $rows[0]['course_code'];
        $require_model = array(
            'staffs' => array(),
            'courses' => array(),
            'notes' => array(
                'where' => array('contact_code' => $contact_code),
                'order' => array('time' => 'ASC')
            ),
            'transfer_logs' => array(
                'where' => array('contact_id' => $id)
            ),
            'call_status' => array(
                'order' => array('sort' => 'ASC')
            ),
            'ordering_status' => array(
                'order' => array('sort' => 'ASC')
            ),
            'payment_method_rgt' => array(),
            'cod_status' => array(),
            'providers' => array(),
            'scripts' => array('where' => array('course_code' => $rows[0]['course_code']))
        );
        $data = $this->_get_require_data($require_model);

        $data['view_edit_left'] = $left_edit;
        $data['view_edit_right'] = $right_edit;

        if ($this->role_id == 1) {
            $edited_contact = ( $this->_can_edit_by_sale($rows[0]['call_status_id'], $rows[0]['ordering_status_id']) && $this->_can_edit_by_cod($rows[0]['cod_status_id']));
        }
        if ($this->role_id == 2) {
            $edited_contact = $this->_can_edit_by_cod($rows[0]['cod_status_id']);
        }
        $data['contact_id'] = $id;
        $data['edited_contact'] = $edited_contact;
        $input_call_log = array();
        $input_call_log['where'] = array('contact_id' => $id);
        $input_call_log['order'] = array('contact_id' => 'ASC');
        $this->load->model('call_log_model');
        $data['call_logs'] = $this->call_log_model->load_all_call_log($input_call_log);
        $data['rows'] = $rows[0];
        $data['action_url'] = 'common/action_edit_contact/' . $id;
        $result['success'] = 1;
        $result['message'] = $this->load->view('common/modal/edit_contact', $data, true);
        echo json_encode($result);
        die;
    }

    private function _can_edit_by_sale($call_stt, $ordering_stt) {
        $this->load->model("call_status_model");
        $stop_care_call_stt_where = array();
        $stop_care_call_stt_where['where'] = array('stop_care' => 1);
        $stop_care_call_stt_id = $this->call_status_model->load_all($stop_care_call_stt_where);
        if (!empty($stop_care_call_stt_id)) {
            foreach ($stop_care_call_stt_id as $value) {
                if ($value['id'] == $call_stt) {
                    return false;
                }
            }
        }

        $stop_care_call_order_id = array(_TU_CHOI_MUA_, _CONTACT_CHET_);
        if (!empty($stop_care_call_order_id)) {
            foreach ($stop_care_call_order_id as $value) {
                if ($value == $ordering_stt) {
                    return false;
                }
            }
        }
        return true;
    }

    protected function _can_edit_by_cod($cod_status_id) {
        $this->load->model("cod_status_model");
        $stop_care_cod_stt_where = array();
        $stop_care_cod_stt_where['where'] = array('stop_care' => 1);
        $stop_care_call_stt_id = $this->cod_status_model->load_all($stop_care_cod_stt_where);
        if (!empty($stop_care_call_stt_id)) {
            foreach ($stop_care_call_stt_id as $value) {
                if ($value['id'] == $cod_status_id) {
                    return false;
                }
            }
        }
        return true;
    }

    function action_edit_contact($id) {
        $result = array();
        $input = array();
        $input['where'] = array('id' => $id);
        $rows = $this->contacts_model->load_all($input);
        if (empty($rows)) {
            $result['success'] = 0;
            $result['message'] = 'Không tồn tại contact này!';
            echo json_encode($result);
            die;
        }
        if ($this->role_id == 1) {
            if ($rows[0]['sale_staff_id'] != $this->user_id) {
                $result['success'] = 0;
                $result['message'] = "Contact này không được phân cho bạn, vì vậy bạn không thể chăm sóc!";
                echo json_encode($result);
                die;
            }
            $this->_action_edit_by_sale($id, $rows);
        } else if ($this->role_id == 2) {
            if ($rows[0]['ordering_status_id'] != _DONG_Y_MUA_ || $rows[0]['call_status_id'] != _DA_LIEN_LAC_DUOC_) {
                $result['success'] = 0;
                $result['message'] = "Contact không là L6, nên không thể chăm sóc!";
                echo json_encode($result);
                die;
            }
            $this->_action_edit_by_cod($id, $rows);
        } else {
            $result['success'] = 0;
            $result['message'] = "Bạn không có quyền chỉnh sửa contact";
            echo json_encode($result);
            die;
        }
    }

    private function _action_edit_by_sale($id, $rows) {
        $result = array();
        $edited_contact = $this->_can_edit_by_sale($rows[0]['call_status_id'], $rows[0]['ordering_status_id']);
        if (!$edited_contact) {
            $result['success'] = 0;
            $result['message'] = 'Contact này ở trạng thái không thể chăm sóc được nữa, vì vậy bạn không có quyền chăm sóc contact này nữa!';
            echo json_encode($result);
            die;
        }
        if (!empty($this->input->post())) {
            $post = $this->input->post();
            $param = array();
            $post_arr = array('name', 'email', 'address', 'course_code',
                'price_purchase', 'payment_method_rgt', 'call_status_id',
                'ordering_status_id', 'note_cod', 'script');

            foreach ($post_arr as $value) {
                if (isset($post[$value])) {
                    $param[$value] = $post[$value];
                }
            }
            $param['date_last_calling'] = time();
            $param['date_recall'] = (isset($post['date_recall']) && $post['date_recall'] != '') ? strtotime($post['date_recall']) : 0;
            $param['date_expect_receive_cod'] = (isset($post['date_expect_receive_cod']) && $post['date_expect_receive_cod'] != '') ? strtotime($post['date_expect_receive_cod']) : 0;

            /* Kiểm tra điều kiện các trạng thái và ngày hẹn gọi lại có logic ko */
            if (isset($post['call_status_id']) && $post['call_status_id'] == '0') {
                $result['success'] = 0;
                $result['message'] = 'Bạn phải cập nhật trạng thái cuộc gọi!';
                echo json_encode($result);
                die;
            }
            if (isset($post['course_code']) && $post['course_code'] == '0') {
                $result['success'] = 0;
                $result['message'] = 'Bạn phải chọn mã khóa học!';
                echo json_encode($result);
                die;
            }
            if (isset($post['price_purchase']) && $post['price_purchase'] == '') {
                $result['success'] = 0;
                $result['message'] = 'Bạn phải cập nhật giá tiền mua!';
                echo json_encode($result);
                die;
            }
            if (isset($post['note_cod']) && $post['note_cod'] != '' && $post['ordering_status_id'] != _DONG_Y_MUA_) {
                $result['success'] = 0;
                $result['message'] = 'Chỉ contact nào đồng ý mua mới có ghi chú khi giao hàng!';
                echo json_encode($result);
                die;
            }

            $check_rule = $this->_check_rule($param['call_status_id'], $param['ordering_status_id'], $param['date_recall']);

            if ($check_rule == false) {
                $result['success'] = 0;
                $result['message'] = 'Trạng thái gọi và trạng thái đơn hàng không logic!';
                echo json_encode($result);
                die;
            }

            if ($post['ordering_status_id'] == _DONG_Y_MUA_) {
                $param['date_confirm'] = time();
                if ($post['date_expect_receive_cod'] != '' && strtotime($post['date_expect_receive_cod']) < time()) {
                    $result['success'] = 0;
                    $result['message'] = 'Ngày dự kiến giao hàng không thể là quá khứ! Mã lỗi 69874514';
                    echo json_encode($result);
                    die;
                }
            } else {
                $param['date_confirm'] = 0;
            }
            $param['last_activity'] = time();
            $where = array('id' => $id);
            $this->contacts_model->update($where, $param);
            if ($post['note'] != '') {
                $param2 = array(
                    'contact_id' => $id,
                    'content' => $post['note'],
                    'time' => time(),
                    'sale_id' => $this->user_id,
                    'contact_code' => $this->contacts_model->get_contact_code($id)
                );
                $this->load->model('notes_model');
                $this->notes_model->insert($param2);
            }
            $this->_set_call_log($id, $post, $rows);
            $result['success'] = 1;
            $result['message'] = 'Chăm sóc thành công contact!';
            echo json_encode($result);

           
            $options = array(
                'cluster' => 'ap1',
                'encrypted' => true
            );
            $pusher = new Pusher(
                    'e37045ff133e03de137a', 'f3707885b7e9d7c2718a', '428500', $options
            );

            $data['message'] = $this->staffs_model->find_staff_name($this->user_id) . ' đã cập nhật cuộc gọi';
            $data['image'] =  $this->staffs_model->GetStaffImage($this->user_id);
            $pusher->trigger('my-channel', 'callLog', $data);

            die;
        }
    }

    private function _check_rule($call_status_id, $ordering_status_id, $date_recall) {
        if ($call_status_id == '0' || $call_status_id == _SO_MAY_SAI_ || $call_status_id == _KHONG_NGHE_MAY_ || $call_status_id == _NHAM_MAY_) {
            if ($ordering_status_id != _CHUA_CHAM_SOC_) {
                return false;
            }
        }
        if ($call_status_id == _DA_LIEN_LAC_DUOC_ && $ordering_status_id == _CHUA_CHAM_SOC_) {
            return false;
        }

        if ($date_recall != 0 && $date_recall < time()) {
            return false;
        }

        if ($this->_can_edit_true($call_status_id, $ordering_status_id) == false && $date_recall > time()) {
            return false;
        }

        return true;
    }

    private function _can_edit_true($call_stt, $ordering_stt) {
        $this->load->model("call_status_model");
        $stop_care_call_stt_where = array();
        $stop_care_call_stt_where['where'] = array('stop_care' => 1);
        $stop_care_call_stt_id = $this->call_status_model->load_all($stop_care_call_stt_where);
        if (!empty($stop_care_call_stt_id)) {
            foreach ($stop_care_call_stt_id as $value) {
                if ($value['id'] == $call_stt)
                    return false;
            }
        }
        $this->load->model("ordering_status_model");
        $stop_care_call_order_where = array();
        $stop_care_call_order_where['where'] = array('stop_care' => 1);
        $stop_care_call_order_id = $this->ordering_status_model->load_all($stop_care_call_order_where);
        if (!empty($stop_care_call_order_id)) {
            foreach ($stop_care_call_order_id as $value) {
                if ($value['id'] == $ordering_stt)
                    return false;
            }
        }
        return true;
    }

    /* ================== Chăm sóc 1 contact =========================== */

    function action_edit_multi_cod_contact() {
        $post = $this->input->post();
        $result = array();
        if (!isset($post['contact_id']) || empty($post['contact_id'])) {
            show_error_and_redirect('Bạn cần chọn contact!', '', FALSE);
        }
        foreach ($post['contact_id'] as $value) {
            $input = array();
            $input['where'] = array('id' => $value);
            $rows = $this->contacts_model->load_all($input);
            $this->_action_edit_by_cod($value, $rows, true);
        }
        $result['success'] = 1;
        $result['message'] = 'Chăm sóc thành công contact!';
        echo json_encode($result);
        die;
    }

    private function _action_edit_by_cod($id, $rows, $multi = false) {
        $result = array();
        // print_arr($rows);
        $edited_contact = $this->_can_edit_by_cod($rows[0]['cod_status_id']);
        if (!$edited_contact) {
            $result['success'] = 0;
            $result['message'] = 'Contact này ở trạng thái không thể chăm sóc được nữa, vì vậy bạn không có quyền chăm sóc contact này nữa!';
            echo json_encode($result);
            die;
        }
        if (!empty($this->input->post())) {
            $post = $this->input->post();
            $param = array();
            $post_arr = array('address', 'payment_method_rgt', 'provider_id', 'cod_status_id', 'code_cross_check',
                'note_cod', 'weight_envelope', 'cod_fee', 'fee_resend');
            foreach ($post_arr as $value) {
                if (isset($post[$value])) {
                    $param[$value] = $post[$value];
                }
            }

            if (isset($post['date_expect_receive_cod']) && $post['date_expect_receive_cod'] != '') {
                $param['date_expect_receive_cod'] = strtotime($post['date_expect_receive_cod']);
            }

            $cur_cod_status_id = $rows[0]['cod_status_id'];
            $cod_status_id = $post['cod_status_id'];
            // $this->_check_cod_stt_avalid($cod_status_id, $cur_cod_status_id);
            //nếu trạng thái là đang giao hàng và không có mã vận đơn (không phải tạo bằng tay) thì tạo mã vận đơn
            if ($cur_cod_status_id == 0 && $cod_status_id == 1) {
                if (!isset($post['code_cross_check']) || $post['code_cross_check'] == '') {
                    if (isset($post['provider_id']) && $post['provider_id'] != '' && $post['provider_id'] != 0) {
                        $param['code_cross_check'] = $this->_gen_code_cross_check($post, $id);
                        $param['date_print_cod'] = time();
                    } else {
                        $result['success'] = 0;
                        $result['message'] = 'Bạn cần chọn đơn vị giao hàng!';
                        echo json_encode($result);
                        die;
                    }
                } else {
                    $param['date_print_cod'] = time();
                }
            }
            //hạ cấp
//            if ($cod_status_id == 0) {
//                $this->load->model('cod_cross_check_model');
//                $where = array('contact_id' => $id);
//                $curr = $this->cod_cross_check_model->load_all(array('where' => $where));
//                if (!empty($curr)) {
//
//                    /*
//                     * Xóa contact đang xóa ở bảng tạm và cập nhật lại mã bill bằng rỗng
//                     */
//                    $this->cod_cross_check_model->delete($where);
//                    $this->contacts_model->update(array('id' => $id), array('code_cross_check' => NULL));
//                    /*
//                     * Lấy toàn bộ contact có số thứ tự lớn hơn STT contact dang xóa
//                     */
//                    $condition = array(
//                        'where' => array(
//                            'date_print_cod' => $curr[0]['date_print_cod'],
//                            'provider_id' => $curr[0]['provider_id'],
//                            'number >' => $curr[0]['number']
//                        )
//                    );
//                    $upper = $this->cod_cross_check_model->load_all($condition);
//
//                    /*
//                     * Cập nhật lại các contact đằng sau đúng số thứ tự (STT = STT - 1)
//                     */
//                    $this->load->model('providers_model');
//                    $input_provider = array();
//                    $input_provider['where'] = array('id' => $curr[0]['provider_id']);
//                    $provider = $this->providers_model->load_all($input_provider);
//                    $provider_prefix = $provider[0]['prefix'];
//                    if (!empty($upper)) {
//                        foreach ($upper as $value) {
//                            $u_num = $value['number'] - 1;
//                            if ($u_num < 10) {
//                                $u_num = '0' . $u_num;
//                            }
//                            $this->cod_cross_check_model->update(array('id' => $value['id']), array('number' => $u_num));
//                            $u_code = $provider_prefix . $value['date_print_cod'] . $u_num;
//                            $this->contacts_model->update(array('id' => $value['contact_id']), array('code_cross_check' => $u_code));
//                        }
//                    }
//                }
//                $param['code_cross_check'] = '';
//                $param['provider_id'] = '0';
//            }
            //nếu trạng thái đã thu COD, hủy đơn, đã thu Lakita thì cập nhật time
            // $receiveCOD = array();
            if ($cod_status_id > 1) {
                switch ($cod_status_id) {
                    case 2: {
                            //$receiveCOD[] = $rows[0]['contact_id'];
                            $param['date_receive_cod'] = time();
                            break;
                        }
                    case 3: {
                            // $receiveCOD[] = $rows[0]['contact_id'];
                            $param['date_receive_lakita'] = time();
                            break;
                        }
                    case 4: $param['date_receive_cancel_cod'] = time();
                        break;
                }
            } else {
                $param['date_receive_cod'] = 0;
                $param['date_receive_lakita'] = 0;
                $param['date_receive_cancel_cod'] = 0;
            }

            $where = array('id' => $id);
            $param['last_activity'] = time();
            $this->contacts_model->update($where, $param);

            if (isset($post['note']) && $post['note'] != '') {
                $param2 = array(
                    'contact_id' => $id,
                    'content' => $post['note'],
                    'time' => time(),
                    'sale_id' => $this->user_id,
                    'contact_code' => $this->contacts_model->get_contact_code($id)
                );
                $this->load->model('notes_model');
                $this->notes_model->insert($param2);
            }
            $this->_set_call_log($id, $post, $rows);

            if ($multi == false) {
                $result['success'] = 1;
                $result['message'] = 'Chăm sóc thành công contact!';
                echo json_encode($result);
                die;
            }
        }
    }

    private function _check_cod_stt_avalid($cod_status_id, $cur_cod_status_id) {
//        if ($cur_cod_status_id == 1 && $cod_status_id < 1) {
//            $error = 'Vui lòng cập nhật trạng thái giao COD';
//            show_error_and_redirect($error, base_url('error'));
//        }
//        if ($cur_cod_status_id == 0 && $cod_status_id > 1) {
//            $error = 'Contact đang ở trạng thái chưa giao hàng, nên không thể cập nhật thành đã thu COD, đã thu Lakita hoặc Hủy đơn được!';
//            show_error_and_redirect($error, base_url('error'));
//        }
        if (($cur_cod_status_id == 2 || $cur_cod_status_id == 3) && ($cod_status_id == 4 || $cod_status_id <= 1)) {
            $error = 'Contact đang ở trạng thái đã thu COD/ đã thu Lakita thì không thể cập nhật thành Hủy đơn hoặc Đang giao hàng được!';
            show_error_and_redirect($error, base_url('error'));
        }
    }

    private function _gen_code_cross_check($post, $id) {
        $code_cross_check = '';
        $this->load->model('providers_model');
        $input_provider = array();
        $input_provider['where'] = array('id' => $post['provider_id']);
        $provider = $this->providers_model->load_all($input_provider);
        $provider_prefix = $provider[0]['prefix'];

        $this->load->model('cod_cross_check_model');
        $today = date('dm'); //lấy định dạng ngày_tháng để ghép vào mã bill
        $input_cod_cross_check = array();
        $input_cod_cross_check['where'] = array('date_print_cod' => $today, 'provider_id' => $post['provider_id']);
        $input_cod_cross_check['order'] = array('id' => 'DESC');
        /* Kiểm tra trong bảng tạo mã Bill có contact tạo ngày hôm nay chưa, */
        $cod_cross_check = $this->cod_cross_check_model->load_all($input_cod_cross_check);

        if (empty($cod_cross_check)) { // nếu chưa thì gán STT = 01,
            $code_cross_check = $provider_prefix . $today . '01';
            $this->cod_cross_check_model->insert(array('contact_id' => $id, 'date_print_cod' => $today,
                'provider_id' => $post['provider_id'], 'number' => 1,
                'phone' => $this->contacts_model->get_contact_phone($id), 'code' => $code_cross_check, 'time' => date('Y/m/d H:i:s', time())));
        } else {
            //kiểm tra 1 khách hàng (cùng số đt) mua nhiều khóa học thì ko tạo mã vận đơn mới, mà dùng mã vận đơn cũ
            $input_duplicate = array();
            $input_duplicate['where'] = array('date_print_cod' => $today,
                'phone' => $this->contacts_model->get_contact_phone($id), 'provider_id' => $post['provider_id']);
            $contact_duplicate = $this->cod_cross_check_model->load_all($input_duplicate);
            if (!empty($contact_duplicate)) {
                $code_cross_check = $contact_duplicate[0]['code'];
            } else {
                // nếu có rồi thì gán STT = STT + 1 (tăng lên 1 đơn vị)
                $number = $cod_cross_check[0]['number'] + 1;
                if ($number < 10) {
                    $number = '0' . $number;
                }
                $code_cross_check = $provider_prefix . $today . '' . $number;
                $this->cod_cross_check_model->insert(array('contact_id' => $id, 'date_print_cod' => $today,
                    'provider_id' => $post['provider_id'], 'number' => $number,
                    'phone' => $this->contacts_model->get_contact_phone($id), 'code' => $code_cross_check, 'time' => date('Y/m/d H:i:s', time())));
            }
        }
        return $code_cross_check;
    }

    private function _set_call_log($id, $post, $rows) {
        $data = array();
        $data['contact_id'] = $id;
        $data['staff_id'] = $this->user_id;
        $statusArr = array('call_status_id', 'ordering_status_id', 'cod_status_id', 'payment_method_rgt', 'provider_id');
        foreach ($statusArr as $value) {
            if (isset($post[$value])) {
                $data[$value] = $post[$value];
            } else {
                $data[$value] = "-1";
            }
        }
        $data['time'] = time();
        $diffArr = array(
            '[Họ tên]: ' => 'name',
            '[Email]:' => 'email',
            '[Địa chỉ]: ' => 'address',
            '[Mã khóa học]:' => 'course_code',
            '[Giá tiền mua]:' => 'price_purchase'
        );
        $strDiff = '';
        foreach ($diffArr as $key => $value) {
            if (isset($post[$value])) {
                if (is_string($rows[0][$value])) {
                    $rows[0][$value] = trim($rows[0][$value]);
                    $post[$value] = trim($post[$value]);
                }
                if ($post[$value] !== $rows[0][$value]) {
                    $strDiff .= $key . $rows[0][$value] . ' ===> ' . $post[$value];
                }
            }
        }
        $data['content_change'] = $strDiff;
        $this->load->model('call_log_model');
        $this->call_log_model->insert($data);
    }

    function real_search() {
        $require_model = array(
            'staffs' => array(
                'where' => array(
                    'role_id' => 1
                )
            ),
            'call_status' => array(),
            'ordering_status' => array(),
            'cod_status' => array()
        );
        $data = $this->_get_require_data($require_model);
        $post = $this->input->post();
        if (!empty($post)) {
            $input = array();
            $input['like'] = array($post['type'] => $post['value']);
            $input['oder'] = array('id' => 'DESC');
            $input['limit'] = array(10, 0);
            $data['contacts'] = $this->contacts_model->load_all($input);
            $total_row = count($data['contacts']);
            $this->begin_paging = ($total_row == 0) ? 0 : 1;
            $this->end_paging = ($total_row == 0) ? 0 : $total_row;
            $this->total_paging = $total_row;
            $data['controller'] = 'manager';
        }
        switch ($this->role_id) {
            case 1: $data['controller'] = 'sale';
                break;
            case 2: $data['controller'] = 'cod';
                break;
            case 3: $data['controller'] = 'manager';
                break;
        }

        $this->table .= 'date_rgt date_last_calling call_stt ordering_stt action';
        $data['table'] = explode(' ', $this->table);
        $this->load->view('common/real_search', $data);
    }

    function ViewAllContactCourse() {
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
            'providers' => array()
        );
        $data = array_merge($this->data, $this->_get_require_data($require_model));

        $contact_id = $this->input->post('contact_id', true);
        $contact_phone = $this->contacts_model->get_contact_phone($contact_id);
        //$contact_course_code = $this->input->post('contact_course_code', true);

        $get = $this->input->get();
        /*
         * Điều kiện lấy contact :
         * contact ở trang chủ là contact chưa được phân cho TVTS nào và chua gọi lần nào
         *
         */
        $conditional['where'] = array('phone' => $contact_phone);
        $data_pagination = $this->_query_all_from_get($get, $conditional, $this->per_page, 0, 0);

        /*
         * Lấy link phân trang và danh sách contacts
         */
        $data['pagination'] = $this->_create_pagination_link($data_pagination['total_row']);
        $data['contacts'] = $data_pagination['data'];
        $data['total_contact'] = $data_pagination['total_row'];

        //print_arr( $data['contacts']);

        /*
         * Các trường cần hiện của bảng contact (đã có default)
         */
        $this->table .= 'date_rgt date_last_calling call_stt ordering_stt';
        $data['table'] = explode(' ', $this->table);
        $data['controller'] = $this->input->post('controller', true);
        $result = array();
        $result['success'] = 1;
        $result['message'] = $this->load->view('common/modal/view_all_contact_course', $data, true);
        echo json_encode($result);
        die;
    }

    function find_course_name() {
        $post = $this->input->post();
        $input = array();
        $input['where'] = array('course_code' => $post['course_code']);
        $this->load->model('courses_model');
        $courses = $this->courses_model->load_all($input);
        if (!empty($courses)) {
            echo $courses[0]['name_course'];
        }
    }

    function send_phone_to_mobile() {
        $post = $this->input->post();
        $where = array('user_id' => $this->user_id);
        $data = array('phone' => $post['contact_phone'], 'name' => $post['contact_name']);
        $this->load->model('get_mobile_phone_model');
        $this->get_mobile_phone_model->update($where, $data);
    }

    function get_phone_to_mobile() {
        $this->load->model('get_mobile_phone_model');
        $input = array();
        $input['where'] = array('user_id' => $this->user_id);
        $rs = $this->get_mobile_phone_model->load_all($input);
        echo json_encode($rs[0]);
    }

    public function ExportToExcel() {
        /* ====================xuất file excel============================== */
        $post = $this->input->post();
        if (empty($post['contact_id'])) {
            show_error_and_redirect('Vui lòng chọn contact cần xuất file excel', '', 0);
        }
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
        $objPHPExcel->getActiveSheet()->getStyle("A1:R1")->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("A1:R1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('548235');
        $objPHPExcel->getActiveSheet()->getStyle("A1:R1")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $objPHPExcel->getActiveSheet()->getStyle("A2:R200")->getFont()->setSize(15)->setName('Times New Roman');
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
        $objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(73);


        //set tên các cột cần in
        $rowCount = 1;
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, 'STT');
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, 'Họ tên');
        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, 'Email');
        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, 'Số điện thoại');
        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, 'Địa chỉ');
        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, 'Mã khóa học');
        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, 'Ngày đăng ký');
        $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, 'TVTS');
        $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, 'Giá tiền mua');
        $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, 'Nguồn contact');
        $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, 'Trạng thái gọi');
        $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, 'Trạng thái đơn hàng');
        $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, 'Trạng thái giao hàng');
        $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, 'Ghi chú cuộc gọi');
        $rowCount++;

        //đổ dữ liệu ra file excel
        $i = 1;
        $this->load->model('sources_model');
        $this->load->model('call_status_model');
        $this->load->model('ordering_status_model');
        $this->load->model('cod_status_model');
        foreach ($post['contact_id'] as $value) {
            $input = array();
            $input['where'] = array('id' => $value);
            $contact = $this->contacts_model->load_all($input);

            $this->load->model('notes_model');
            $input2 = array();
            $input2['where'] = array('contact_id' => $value);
            $input2['order'] = array('id' => 'DESC');
            $last_note = $this->notes_model->load_all($input2);
            $notes = '';
            if (!empty($last_note)) {
                foreach ($last_note as $value2) {
                    $notes .= date('d/m/Y', $value2['time']) . ' ==> ' . $value2['content'] . ' ------ ';
                }
            }
            $notes = html_entity_decode($notes);
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $i++);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $contact[0]['name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $contact[0]['email']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $contact[0]['phone']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $contact[0]['address']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $contact[0]['course_code']);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, date('d/m/Y', $contact[0]['date_rgt']));
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $this->staffs_model->find_staff_name($contact[0]['sale_staff_id']));
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $contact[0]['price_purchase']);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $this->sources_model->find_source_name($contact[0]['source_id']));
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $this->call_status_model->find_call_status_desc($contact[0]['call_status_id']));
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $this->ordering_status_model->find_ordering_status_desc($contact[0]['ordering_status_id']));
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $this->cod_status_model->find_cod_status_desc($contact[0]['cod_status_id']));
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $notes);
            $objPHPExcel->getActiveSheet()->getRowDimension($rowCount)->setRowHeight(35);
            $BStyle = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THICK,
                        'color' => array('rgb' => '151313')
                    )
                )
            );
            $objPHPExcel->getActiveSheet()->getStyle('A' . $rowCount . ':R' . $rowCount)->applyFromArray($BStyle);
            $rowCount++;
        }

        foreach (range('A', 'R') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                    ->setAutoSize(true);
        }

//die;
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Danh_sach_khach_hang v' . date('Y.m.d') . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        die;
        /* ====================xuất file excel (end)============================== */
    }

    // </editor-fold>
}
