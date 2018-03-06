<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Manage_course
 *
 * @author Phạm Ngọc Chuyển <chuyenpn at lakita.vn>
 */
class Teacher extends MY_Controller {

    public function __construct() {
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

    public function index($offset = 0) {
        $data = $this->data;
        $get = $this->input->get();
        $conditional = array();
        $conditional['where'] = array('role_id' => 8);
        $data_pagination = $this->query_all_from_get($get, $conditional, $this->per_page, $offset, 'staffs_model');
        /*
         * Lấy link phân trang và danh sách tvts
         */
        $data['pagination'] = $this->_create_pagination_link('MANAGERS/manage_teacher/index', $data_pagination['total_row'], 4);
        $data['teacher'] = $data_pagination['data'];
        $data['total_teacher'] = $data_pagination['total_row'];

        $data['content'] = 'manager/manager_teacher/index';
        $tableArr = 'username name email phone course active action';
        $data['load_js'] = array(
            'm_manage_teacher', 'm_delete_teacher'
        );
        $data['table'] = explode(' ', $tableArr);
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

    function show_edit_teacher() {

        $require_model = array(
            'courses' => array(
                'where' => array(
                    'active' => 1
                )
            )
        );
        $data = array_merge($this->data, $this->get_require_data($require_model));
        
        
        
        $post = $this->input->post();
        $input = array();
        $input['where'] = array('id' => $post['teacher_id']);
        $rows = $this->staffs_model->load_all($input);
        if (empty($rows)) {
            echo 'Không tồn tại giảng viên này!';
            die;
        }

        $data['rows'] = $rows[0];
        $this->load->view('manager/manager_teacher/load_ajax_html/edit_teacher', $data);
    }

    function action_edit_teacher($id) {
        if ($id == 0) {
            $this->action_add_teacher();
        } else {


            $where = array('id' => $id);
            $staff = $this->staffs_model->load_all(array('where' => $where));

            $post = $this->input->post();
            if ($post['username'] != $staff[0]['username'] &&
                    $this->staffs_model->check_exists(array('username' => $post['username']))) {
                // echo $staff[0]['username'];die;
                redirect_and_die('Username này đã tồn tại!');
            }

            $param = array();
            $editArr = array('username', 'name', 'email', 'phone', 'course', 'active');
            foreach ($editArr as $value) {
                if (isset($post[$value])) {
                    $param[$value] = $post[$value];
                }
            }
            
            $param['course'] =  implode(';', $param['course']);
            
            $this->staffs_model->update($where, $param);
            show_error_and_redirect('Sửa thông tin Giảng viên thành công!');
        }
    }

    function action_add_teacher() {
        $post = $this->input->post();
        if ($this->staffs_model->check_exists(array('username' => $post['username']))) {
            redirect_and_die('Username này đã tồn tại!');
        }
        $post['role_id'] = 8;
        if ($post['password'] != $post['re-password']) {
            redirect_and_die('Mật khẩu không khớp!');
        }
        if (strlen($post['password']) < 6) {
            redirect_and_die('Mật khẩu phải lớn hơn 5 kí tự!');
        }
        $post['password'] = md5(md5($post['password']));
        unset($post['re-password']);
        $post['course'] = implode(';', $post['course']);
        $this->staffs_model->insert($post);
        show_error_and_redirect('Thêm giảng viên thành công!');
    }

    function delete_teacher() {
        $post = $this->input->post();
        if (!empty($post['teacher_id'])) {
            $where = array('id' => $post['teacher_id']);
            $this->staffs_model->delete($where);
            echo '1';
        }
    }
    
    protected function query_all_from_get($get, $condition = [], $limit = 0, $offset = 0, $model = 'contacts_model') {
        if (count($get)) {
            $result = array();
        }
        $input_get_arr = $this->_get_query_condition_arr($get);
        $input_get = $input_get_arr['input_get'];
        $has_user_order = $input_get_arr['has_user_order'];

        $input_init = array();
        if (!empty($condition)) {
            foreach ($condition as $key => $value) {
                /*
                 * Nếu có order từ người dùng thì sẽ order theo người dùng
                 * Nếu không thì sẽ order mặc định theo id
                 */
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

        /*
         * Sau khi có các mảng query thì sẽ lấy số lượng tất cả các dòng
         * Dùng hàm count_all_result_from_get để tối ưu (chỉ select 'id')
         */
        if ($model != 'contacts_model') {
            $this->load->model($model);
        }
        $total_row = $this->$model->m_count_all_result_from_get($input);
        $result['total_row'] = $total_row;

        /*
         * Lấy các dòng nếu có phân trang với
         * $offset_max: vị trí tối đa (đề phòng người dùng nhập vào quá
         * vị trí tối đa thì quay lại vị trí tối đa đó)
         *
         */
        $offset_max = intval($total_row / $limit) * $limit;
        $offset = ($offset > $offset_max) ? $offset_max : ((($offset < 0) ? 0 : $offset));

        if ($limit != 0 || $offset != 0) {
            $input['limit'] = array($limit, $offset);
        }
        $result['data'] = $this->$model->load_all($input);


        /*
         * Lấy thông tin hiển thị course đầu, course cuối và tổng course
         * Vị trí đầu = offset + 1
         * Vị trí cuối = offset + limit
         */
        $this->begin_paging = ($total_row == 0) ? 0 : $offset + 1;
        $this->end_paging = (($offset + $this->per_page) < $total_row) ? ($offset + $this->per_page) : $total_row;
        $this->total_paging = $total_row;

        return $result;
    }
    
    function get_require_data($require_model) {
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


}
