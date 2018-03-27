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
        if (!empty($input) && !isset($input['contact_cc'])) {
            /* Lọc thông tin contact */
            $param['name'] = isset($input['name']) ? $input['name'] : '';
            $param['name'] = trim(str_replace('[RGT_FROM_MOBILE]', '', $param['name']));
            $param['phone'] = isset($input['phone']) ? trim($input['phone']) : '';
            $email = isset($input['email']) ? $input['email'] : '';
            $param['email'] = trim(str_replace('NO_PARAM@gmail.com', '', $email));
            if (trim($param['phone']) == '') {
                die;
            }
            $address = isset($input['dia_chi']) ? $input['dia_chi'] : '';
            $address .= ' ';
            $address .= isset($input['quan']) ? $input['quan'] : '';
            $address .= ' ';
            $address .= isset($input['tinh']) ? $input['tinh'] : '';
            $address .= isset($input['street']) ? $input['street'] : '';
            $address .= isset($input['address']) ? $input['address'] : '';
            $address .= isset($input['select_combo']) ? ' - ' . $input['select_combo'] : '';
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
            /*
             * MOL
             */
            if (isset($input['link_id'])) {
                $this->load->model('link_model');
                $input_link = array();
                $input_link['where'] = array('id' => $input['link_id']);
                $links = $this->link_model->load_all($input_link);
                if (!empty($links)) {
                    $param['marketer_id'] = $links[0]['marketer_id'];
                    $param['channel_id'] = $links[0]['channel_id'];
                    $param['campaign_id'] = $links[0]['campaign_id'];
                    $param['adset_id'] = $links[0]['adset_id'];
                    $param['ad_id'] = $links[0]['ad_id'];
                    $param['landingpage_id'] = $links[0]['landingpage_id'];
                    $param['link_id'] = $links[0]['id'];
                }
            }
            if (isset($input['type-combo'])) {
                $param['course_code'] = $input['type-combo'];
            }

            $param['date_rgt'] = time();
            $param['last_activity'] = time();
            $param['duplicate_id'] = $this->_find_dupliacte_contact($param['phone'], $param['course_code']);
            $this->contacts_model->insert_from_mol($param);

//            $myfile = fopen(APPPATH . "../public/last_reg.txt", "w") or die("Unable to open file!");
//            fwrite($myfile, time());
//            fclose($myfile);
            $marketerId = isset($param['marketer_id']) ? $param['marketer_id'] : '0';
            $data2 = [];

            $title = 'Có 1 contact mới đăng ký';
            $message = 'Click để xem ngay';

            require_once APPPATH . 'libraries/Pusher.php';
            $options = array(
                'cluster' => 'ap1',
                'encrypted' => true
            );
            $pusher = new Pusher(
                    '32b339fca68db27aa480', '32f6731ad5d48264c579', '490390', $options
            );

            $inputMkt = [];
            $inputMkt['where'] = array('id' => $marketerId);
            $marketer = $this->staffs_model->load_all($inputMkt);

            if ($marketer[0]['targets'] != '') {
                $inputToday = [];
                $inputToday['select'] = 'id';
                $inputToday['where'] = array('marketer_id' => $marketerId, 'date_rgt >' => strtotime(date('d-m-Y')), 'is_hide' => '0');
                $today = $this->contacts_model->load_all($inputToday);
                $totalC3 = count($today);

                $data2['title'] = "C3 số " . $totalC3 . " của " . $marketer[0]['short_name'] . " hôm nay";

                if ($totalC3 < $marketer[0]['targets']) {
                    $data2['message'] = "Bạn còn " . ($marketer[0]['targets'] - $totalC3) . " C3 nữa là đạt mục tiêu hôm nay!";
                } else if ($totalC3 == $marketer[0]['targets']) {
                    $data2['message'] = "Xin chúc mừng, bạn đã đạt mục tiêu hôm nay. Cố gắng phát huy bạn nhé <3 <3 <3";
                } else {
                    $data2['message'] = "Xin chúc mừng, bạn đã vượt mục tiêu hôm nay. Cố gắng phát huy bạn nhé <3 <3 <3";
                }
                $title = $data2['title'];
                $message = $data2['message'];
            } else {
                $data2['title'] = 'Có contact mới đăng ký';
                $data2['message'] = 'Click để xem ngay';
            }
            $data2['image'] = $this->staffs_model->GetStaffImage($marketerId);
            $pusher->trigger('my-channel', 'notice', $data2);


            $url = 'https://crm2.lakita.vn';
            $apiToken = 'a7ea7dd9fe04ee2fe9745bc930e15213';
            $curlUrl = 'https://pushcrew.com/api/v1/send/all';
            //set POST variables
            $fields = array(
                'title' => $title,
                'message' => $message,
                'url' => $url
            );
            $httpHeadersArray = Array();
            $httpHeadersArray[] = 'Authorization: key=' . $apiToken;
            //open connection
            $ch = curl_init();
            //set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $curlUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeadersArray);
            //execute post
            curl_exec($ch);


            /*
             * Gửi email
             */
//            if (!in_array($input['email'], array('NO_PARAM@gmail.com', 'lakita@lakita.vn', 'NO_PARAM@gmai.com'
//                        , 'lakitavn@gmail.com', 'lakita.vn@gmail.com'))) {
//                $this->load->model('courses_model');
//                $data = array();
//                $data['e_name'] = $input['name'];
//                $data['e_phone'] = $input['phone'];
//                $data['e_address'] = $address;
//                $data['e_price_sale'] = $input['price_purchase'];
//                $data['e_course_name'] = $this->courses_model->find_course_name($input['course_code']);
//                $data['e_price_root'] = $this->courses_model->find_course_price_root($input['course_code']);
//                $content = $this->load->view('email', $data, TRUE);
//                $this->load->library("email");
//                $this->email->from('cskh@lakita.vn', "Hệ thống học trực tuyến lakita.vn");
//                $this->email->to($input['email']);
//                $this->email->subject('Lakita.vn Thông tin khóa học đã đăng ký.');
//                $this->email->message($content);
//                $this->email->send();
//            }
        }
    }

    function add_c2_post() {
        $input = $this->input->post();
        if (isset($input['link_id'])) {
            $this->load->model('c2_model');
            /*
             * Nếu người dùng F5 trong vòng 2 phút thì không tính là C2
             */
            $input_c2_exist = array();
            $input_c2_exist['select'] = 'id';
            $input_c2_exist['where'] = array('link_id' => $input['link_id'], 'ip' => $input['ip'],
                'date_rgt >=' => time() - 120);
            $input_c2_exist['limit'] = array('1', '0');
            $c2_exist = $this->c2_model->load_all($input_c2_exist);
            if (empty($c2_exist)) {
                $this->load->model('link_model');
                $input_link = array();
                $input_link['where'] = array('id' => $input['link_id']);
                $links = $this->link_model->load_all($input_link);
                if (!empty($links)) {
                    $param['marketer_id'] = $links[0]['marketer_id'];
                    $param['channel_id'] = $links[0]['channel_id'];
                    $param['campaign_id'] = $links[0]['campaign_id'];
                    $param['adset_id'] = $links[0]['adset_id'];
                    $param['ad_id'] = $links[0]['ad_id'];
                    $param['landingpage_id'] = $links[0]['landingpage_id'];
                    $param['link_id'] = $links[0]['id'];
                }
                $param['date_rgt'] = time();
                $param['ip'] = $input['ip'];
                $this->c2_model->insert($param);
            }
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
        $input['select'] = 'id';
        $input['where'] = array(
            'phone' => $phone,
            'course_code' => $course_code,
            'is_hide' => '0'
        );
        $input['order'] = array('id', 'ASC');
        $input['limit'] = array('1', '0');
        $rs = $this->contacts_model->load_all($input);
        if (count($rs) > 0) {
            $dulicate = $rs[0]['id'];
        }
        return $dulicate;
    }

}
