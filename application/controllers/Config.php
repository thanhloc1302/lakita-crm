<?php

/**
 * Description of Common
 *
 * @author CHUYEN
 */
class Config extends MY_Controller {

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

    public function sale() {
        $sale_id = $this->input->post('sale_id');
        if (isset($sale_id)) {
            $this->load->model('staffs_model');
            $this->staffs_model->update([], array('active' => '0'));
            $where = array('id' => $sale_id);
            $data = array('active' => 1);
            $this->staffs_model->update_where_in($where, $data);
            show_error_and_redirect('Cập nhật thành công!');
        }
        $require_model = array(
            'staffs' => array(
                'where' => array(
                    'role_id' => 1
                )
            )
        );
        $data = array_merge($this->data, $this->_get_require_data($require_model));
        switch ($this->user_id) {
            case 1: {
                    $data['slide_menu'] = 'manager/common/slide-menu';
                    $data['top_nav'] = 'manager/common/top-nav';
                    break;
                }
        }

        $data['content'] = 'config/sale';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }
    
      public function course() {
        $course_id = $this->input->post('course_id');
        if (isset($course_id)) {
            $this->load->model('courses_model');
            $this->courses_model->update([], array('active' => '0'));
            $where = array('id' => $course_id);
            $data = array('active' => 1);
            $this->courses_model->update_where_in($where, $data);
            show_error_and_redirect('Cập nhật thành công!');
        }
        $require_model = array(
            'courses' => array()
        );
        $data = array_merge($this->data, $this->_get_require_data($require_model));
        switch ($this->user_id) {
            case 1: {
                    $data['slide_menu'] = 'manager/common/slide-menu';
                    $data['top_nav'] = 'manager/common/top-nav';
                    break;
                }
        }

        $data['content'] = 'config/course';
        $this->load->view(_MAIN_LAYOUT_, $data);
    }

}
