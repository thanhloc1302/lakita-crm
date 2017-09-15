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

    public function add_contact() {
        $input = $this->input->post();
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

            $myfile = fopen(APPPATH . "../public/last_reg.txt", "w") or die("Unable to open file!");
            fwrite($myfile, time());
            fclose($myfile);
        }
    }

    private function _find_dupliacte_contact($email = '', $phone = '', $course_code = '') {
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

}
