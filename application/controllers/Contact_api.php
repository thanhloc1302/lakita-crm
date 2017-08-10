<?php

/**
 * Description of Common
 *
 * @author CHUYEN
 */
require_once APPPATH . 'libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Contact_api extends REST_Controller {

    function contacts_get() {
        $input = array();
        $input['where'] = array('id' => '6001');
        $contacts = $this->contacts_model->load_all($input);
        $this->response(json_encode($contacts), 200);
    }

    function add_contact_post() {
        $input = $this->input->post();
        if (!empty($input)) {
            /* Lọc thông tin contact */
            $param['name'] = isset($input['name']) ? $input['name'] : '';
            $param['name'] = trim(str_replace('[RGT_FROM_MOBILE]', '', $param['name']));
            $param['phone'] = isset($input['phone']) ? trim($input['phone']) : '';
            if ($param['name'] == '' || $param['phone'] == '')
                die;
            $email = isset($input['email']) ? $input['email'] : '';
            $param['email'] = str_replace('NO_PARAM@gmail.com', '', $email);
            $address = isset($input['dia_chi']) ? $input['dia_chi'] : '';
            $address .= ' ';
            $address .= isset($input['quan']) ? $input['quan'] : '';
            $address .= ' ';
            $address .= isset($input['tinh']) ? $input['tinh'] : '';
            $param['address'] = trim(str_replace('NO_PARAM', '', $address));
            $param['is_consultant'] = (strpos($param['address'], 'TV_') !== false) ? 1 : 0;
            $param['course_code'] = isset($input['course_code']) ? $input['course_code'] : '';
            $param['price_purchase'] = isset($input['price_purchase']) ? $input['price_purchase'] : '';
            $param['matrix'] = isset($input['matrix']) ? $input['matrix'] : '';
            $param['payment_method_rgt'] = isset($input['payment_method_rgt']) ? $input['payment_method_rgt'] : 1;
            if (isset($input['cod_status_id'])) {
                $param['cod_status_id'] = $input['cod_status_id'];
                if ($input['cod_status_id'] == '3') {
                    $param['date_receive_lakita'] = time();
                }
            }
            if (isset($input['call_status_id'])) {
                $param['call_status_id'] = $input['call_status_id'];
            }
            if (isset($input['ordering_status_id'])) {
                $param['ordering_status_id'] = $input['ordering_status_id'];
            }
            if (isset($input['link_id'])) {
                $this->load->model('link_model');
                $input_link = array();
                $input_link['where'] = array('id' => $input['link_id']);
                $links = $this->link_model->load_all($input_link);
                if(!empty($links)) {
                   $param['marketer_id'] = $links[0]['marketer_id'];
                   $param['channel_id'] = $links[0]['channel_id'];
                   $param['campaign_id'] = $links[0]['campaign_id'];
                   $param['adset_id'] = $links[0]['adset_id'];
                   $param['ad_id'] = $links[0]['ad_id'];
                   $param['landingpage_id'] = $links[0]['landingpage_id'];
                   $param['link_id'] = $links[0]['id'];
                }
            }

            $param['date_rgt'] = time();
            $param['last_activity'] = time();
            if (isset($input['contact_cc'])) {
                $this->load->model('contact_cc_model');
                $this->contact_cc_model->insert_from_mol($param);
            } else {
                /* ======= Lọc trùng contact ============ */
                $param['duplicate_id'] = $this->_find_dupliacte_contact($input['phone'], $input['course_code']);

                //đếm số lần đăng ký khóa học
                $input_count = array();
                $input_count['where'] = array('phone' => $param['phone'], 'course_code !=' => $param['course_code'], 'is_hide' => '0');
                $contacts = $this->contacts_model->load_all($input_count);
                if (!empty($contacts)) {
                    $param['star'] = $contacts[0]['star'] + 1;
                    //update số lần contact đăng kí vào các contact
                    $where = array('phone' => $param['phone'], 'course_code !=' => $param['course_code']);
                    $data = array('star' => $param['star']);
                    $this->contacts_model->update($where, $data);
                }
                $this->contacts_model->insert_from_mol($param);
            }

            $this->load->model('last_contact_id_model');
            $this->last_contact_id_model->update(array(), array('id' => time()));
        }
    }

    function update_contact_active_lakita_post() {
        $post = $this->input->post();
        if (!empty($post)) {
            $where = array('phone' => $post['phone'], 'course_code' => $post['course_code']);
            $data = array('date_active' => time());
            $this->contacts_model->update($where, $data);
        }
        $this->response('success', 200);
    }

    private function _find_dupliacte_contact($phone = '', $course_code = '') {
        $dulicate = 0;
        $input = array();
        $input['where'] = array(
            'phone' => $phone,
            'course_code' => $course_code,
            'is_hide' => '0'
        );
        $input['order'] = array('id', 'ASC');
        $rs = $this->contacts_model->load_all($input);
        if (count($rs) > 0) {
            $dulicate = $rs[0]['id'];
        }
        return $dulicate;
    }

}
