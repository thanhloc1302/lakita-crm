<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Test2 extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
    }

    function print_r($arr) {
        echo '<pre>';
        print_r($arr);
    }

    function test13() {
        $input['select'] = 'name,email,phone,date_rgt,course_code,ordering_status_id,cod_status_id';
        $input['where'] = array('date_rgt >' => 1514739600, 'date_rgt <' => 1522515600);
        $contact = $this->contacts_model->load_all($input);

        echo '<table>';
        foreach ($contact as $value) {
            echo '<td>' . $value['name'] . '</td><td>' . $value['email'] . '</td><td>' . $value['phone'] . '</td><td>' . $value['date_rgt'] . '</td><td>' . $value['course_code'] . '</td>';
            switch ($value['ordering_status_id']) {
                case 0:
                    echo '<td>chưa chăm sóc</td>';
                    break;
                case 1:
                    echo '<td>Bận gọi lại sau</td>';
                    break;
                case 2:
                    echo '<td>Chăm sóc sau 1 thời gian nữa</td>';
                    break;
                case 3:
                    echo '<td>Từ chối mua</td>';
                    break;
                case 4:
                    echo '<td>Đồng ý mua</td>';
                    break;
                case 5:
                    echo '<td>Contact chết</td>';
                    break;
                case 6:
                    echo '<td>Lát nữa gọi lại</td>';
                    break;
                default:
                    echo '<td>không xác định</td>';
            }

            switch ($value['cod_status_id']) {
                case 0:
                    echo '<td>Chưa giao hàng</td>';
                    break;
                case 1:
                    echo '<td>Đang giao hàng</td>';
                    break;
                case 2:
                    echo '<td>Đã thu COD</td>';
                    break;
                case 3:
                    echo '<td>Đã thu Lakita</td>';
                    break;
                case 4:
                    echo '<td>Hủy đơn</td>';
                    break;
                default:
                    echo '<td>không xác định</td>';
            }
        }
        echo '</table>';
    }

    function test12() {

        $this->load->helper('manager_helper');
        $this->load->helper('common_helper');
        $get = $this->input->get();

        $data = '';

        $typeKPI = array(
            'L7+L8' => 10000000,
            'marketing' => 2000000,
            'priceC3' => 50000,
            'C1' => 15400,
            'C2' => 530,
            'C3' => 60,
            'L1' => 30,
            'L2' => 30,
            'L6' => 30,
            'L8' => 30,
        );


        /* các loại báo cáo */
        $typeReport = array(
            'user' => 'date_rgt',
            'marketing' => 'time',
            'C3' => 'date_rgt',
            'L1' => 'date_rgt',
            'L2' => 'date_rgt',
            'L6' => 'date_confirm',
            'L7_revenue' => 'date_receive_cod',
            'L8_revenue' => 'date_receive_lakita',
            //  're_buy' => 'date_rgt',
            'active' => 'date_active'
//            'L8/C3' => 'date_confirm',
//            'L8/L6' => 'date_receive_cancel_cod',
//            'AKPU' => 'date_receive_cod',
        );

        /* Mảng chứa các ngày lẻ */
        if (isset($get['filter_date_happen_from']) && $get['filter_date_happen_from'] != '' && isset($get['filter_date_happen_end']) && $get['filter_date_happen_end'] != '') {
            $startDate = strtotime($get['filter_date_happen_from']);
            $endDate = strtotime($get['filter_date_happen_end']);
        } else {
            $startDate = strtotime(date('01-m-Y'));
            $endDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        }
        $dateArray = h_get_time_range($startDate, $endDate);


        foreach ($dateArray as $key => $value) {
            $input = array();

            $input['where']['date_rgt >='] = $value;
            $input['where']['date_rgt <='] = $value + 86400 - 1;
            $input['select'] = 'phone,email,course_code';
            $input['where'] = array(
                'is_hide' => '0',
                'duplicate_id' => '',
                'ordering_status_id' => 4,
                'cod_status_id >' => 1,
                'cod_status_id <' => 4
            );
            $input['group_by'] = array('phone');
            $input['having'] = array('count(id) >' => 1);
            $input['order'] = array('id' => 'desc');
            $contact_list_buy = $this->contacts_model->load_all($input);

            $contact_re_buy = array();
            foreach ($contact_list_buy as $value) {
                $input = '';
                $input['select'] = 'phone,email,course_code,date_rgt';
                $input['where']['phone'] = $value['phone'];
                $input['where']['is_hide'] = '0';
                $input['where']['duplicate_id'] = '';
                $input['where']['ordering_status_id'] = 4;
                $input['order'] = array('id' => 'desc');
                $contact = '';
                $contact = $this->contacts_model->load_all($input);
                $count = count($contact);
                if ($count > 1) {
                    for ($i = 0; $i < $count - 1; $i++) {
                        if ($contact[$i]['date_rgt'] - $contact[$i + 1]['date_rgt'] < 172800) {
                            $contact_re_buy[] = $contact[$i];
                            break;
                        }
                    }
                }
            }


            echo '<pre>';
            print_r($contact_list_buy);
            print_r($contact_re_buy);
        }
    }

    function test9() {
        $email = 'thanhloc1302@gmail.com';
        $emailCheck = json_decode(file_get_contents('http://api.lakita.vn/email/check?email=' . $email));

        var_dump($emailCheck);
        die;
        if (!$emailCheck->result) {
            $result['message'] = 'Không tồn tại email này!';
            echo json_encode($result);
            die;
        }
    }

    function test5() {



        $input['select'] = 'id';
        $input['where']['email'] = 'thanhloc1302@gmail.com';
        $input['where']['phone'] = '0979487311';
        $input['where']['course_code'] = 'KT400';
        $input['where']['cod_status_id >'] = 1;
        $input['where']['cod_status_id <'] = 4;
        $input['where']['duplicate_id'] = '';
        $input['where']['is_hide'] = '0';
        $contact = $this->contacts_model->load_all($input);
        var_dump($contact);
    }

    function test4() {
        $this->load->model('contacts_model');
        // lấy tất cả contact đã mua hàng thành công trong khoang 1=>31/3
        $input['select'] = 'phone,email,course_code';
        $input['where'] = array(
            'date_rgt >' => 1519862400,
            'date_rgt <' => 1522224998,
            'is_hide' => '0',
            'duplicate_id' => '',
            'ordering_status_id' => 4
        );
        $input['group_by'] = array('phone');
        $input['having'] = array('count(id) >' => 1);
        $input['order'] = array('id' => 'desc');
        $contact_list_buy = $this->contacts_model->load_all($input);

        $contact_re_buy = array();
        foreach ($contact_list_buy as $value) {
            $input = '';
            $input['select'] = 'phone,email,course_code,date_rgt';
            $input['where']['phone'] = $value['phone'];
            $input['where']['is_hide'] = '0';
            $input['where']['duplicate_id'] = '';
            $input['where']['ordering_status_id'] = 4;
            $input['order'] = array('id' => 'desc');
            $contact = '';
            $contact = $this->contacts_model->load_all($input);
            $count = count($contact);
            if ($count > 1) {
                for ($i = 0; $i < $count - 1; $i++) {
                    if ($contact[$i]['date_rgt'] - $contact[$i + 1]['date_rgt'] < 172800) {
                        $contact_re_buy[] = $contact[$i];
                    }
                    break;
                }
            }
        }
        $this->print_r($contact_re_buy);
        $this->print_r($contact_list_buy);
    }

    function test3() {

        //gửi sms của esms.vn
        $APIKey = "62F004030D9DC59889E1537C2DEB35";
        $SecretKey = "FF7820AA1FF8B0C43AA6CF60694820";
        $YourPhone = "01663923279";
        $Content = "gửi sms mất tiền có được không anh";

        $SendContent = urlencode($Content);
        $data = "http://rest.esms.vn/MainService.svc/json/SendMultipleMessage_V4_get?Phone=$YourPhone&ApiKey=$APIKey&SecretKey=$SecretKey&Content=$SendContent&SmsType=3&IsUnicode=0";

        $curl = curl_init($data);
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);

        $obj = json_decode($result, true);
        if ($obj['CodeResult'] == 100) {
            print "<br>";
            print "CodeResult:" . $obj['CodeResult'];
            print "<br>";
            print "CountRegenerate:" . $obj['CountRegenerate'];
            print "<br>";
            print "SMSID:" . $obj['SMSID'];
            print "<br>";
        } else {
            print "ErrorMessage:" . $obj['ErrorMessage'];
        }
    }

    function test2() {

        $contact_new = array();
        $contact = array();
        $contact[] = array('name' => 'a', 'phone' => '1');
        $contact[] = array('name' => 'a', 'phone' => '2');
        $contact[] = array('name' => 'a', 'phone' => '3');
        $contact[] = array('name' => 'b', 'phone' => '1');
        $a = 0;
        foreach ($contact as $key => $value) {
            $found = FALSE;
            for ($i = 0; $i < count($contact); $i++) {
                if ($key != $i) {
                    if ($value['phone'] == $contact[$i]['phone'] && $found == FALSE) {
                        $found = true;
                        $contact[$i]['phone'] = '';
                    }
                }
            }

            $a += 1;
            echo '<pre>';
            echo 'lần ' . $a;
            print_r($contact);

//            if ($found == FALSE) {
//                $contact_new[] = $contact[$key];
//            }
        }

        echo '<pre>';
        print_r($contact);
        print_r($contact_new);
    }

    function test() {
        $this->load->model('campaign_model');
        $this->load->model('campaign_cost_model');
        $this->load->model('adset_model');
        $this->load->model('adset_cost_model');
        $this->load->model('contacts_model');

        $start_date = mktime(0, 0, 0, 11, 1, 2017);
        $end_date = mktime(0, 0, 0, 12, 1, 2017);

        //  1512082800
        //echo mktime(0, 0, 0, 12, 1, 2017);die;
        $input_adset_list = array();
        $input_adset_list['select'] = 'DISTINCT(adset_id)';
        $input_adset_list['where'] = array('time >=' => $start_date, 'time <=' => $end_date);
        $input_adset_list['order'] = array('adset_id' => 'ASC');

        $adset_list = $this->adset_cost_model->load_all($input_adset_list);

        $campaign_list = array();

        foreach ($adset_list as $key => $value) {
            $campaign_id = $this->adset_model->load_all(array('where' => array('id' => $value['adset_id'])));
            if (!in_array($campaign_id[0]['campaign_id'], $campaign_list)) {
                $campaign_list[] = $campaign_id[0]['campaign_id'];
            }
        }

        $campaign = array();

        foreach ($campaign_list as $key => $value) {
            $campaign_infor = $this->campaign_model->load_all(array('where' => array('id' => $value, 'channel_id' => 2)));
            if (!empty($campaign_infor)) {
                $campaign[] = $campaign_infor[0];
            }
        }

        echo '<pre>';
        print_r($campaign);


        unset($campaign[8]);
        unset($campaign[22]);


//        $input_campaign['where'] = array('channel_id' => 2, 'campaign_id_facebook !=' => '', 'time >=' => 1512082800);
//        $campaign = $this->campaign_model->load_all($input_campaign);

        $course_list = array();


        foreach ($campaign as $value) {
            $course = explode('_', $value['name']);
            if (!array_key_exists($course[1], $course_list)) {

                $course_list[$course[1]]['campaign'][] = $value['id'];
            } else {
                $course_list[$course[1]]['campaign'][] = $value['id'];
            }
        }

        echo '<pre>';
        print_r($course_list);
//        die;

        foreach ($course_list as $key => $value) {
            $spend = 0;
            foreach ($value['campaign'] as $key2 => $value2) {
                $a = $this->campaign_cost_model->load_all(array('where' => array('campaign_id' => $value2, 'time >=' => $start_date, 'time <=' => $end_date)));
                if (!empty($a)) {
                    foreach ($a as $key3 => $value3) {
                        $spend += $value3['spend'];
                    }
                }
            }
            $course_list[$key]['marketing_spend'] = $spend;

            $get = 0;
            $contact = $this->contacts_model->load_all(array('where' => array('channel_id' => 2, 'course_code' => $key, 'cod_status_id' => 3, 'date_receive_lakita >=' => $start_date, 'date_receive_lakita <=' => $end_date)));
            if (!empty($contact)) {
                foreach ($contact as $key4 => $value4) {
                    $get += $value4['price_purchase'];
                }
            }
            $course_list[$key]['get'] = $get;
        }



        echo '<table>';

        foreach ($course_list as $key5 => $value5) {
            echo '<tr>';
            echo '<td>' . $key5 . '</td><td>' . number_format($value5['get'], 0, ",", ".") . " VNĐ" . '</td><td>' . number_format($value5['marketing_spend'], 0, ",", ".") . " VNĐ" . '</td><td>' . number_format($value5['get'] - $value5['marketing_spend'], 0, ",", ".") . " VNĐ" . '</td>';
            echo '</tr>';
        }

        echo '</table>';

        echo '<pre>';
        print_r($course_list);
        die;




        echo '<table>';
        echo '<tr>';
        echo '<td>';
        echo '<pre>';
        print_r($campaign);
        echo '</td>';
        echo '<td>';
        echo '<pre>';
        print_r($course_list);
        echo '</td>';
        echo '</tr>';
        echo '</table>';
    }

    function test8() {
        $this->load->model('contacts_model');
        $input['select'] = 'name,email,phone,address,course_code,date_rgt';
        $input['where']['duplicate_id'] = '';
        $input['where']['ordering_status_id'] = 4;
        $input['where']['cod_status_id >'] = 1;
        $input['where']['cod_status_id <'] = 4;
        $input['order']['date_rgt'] = 'desc';
        $contact = $this->contacts_model->load_all($input);
        echo '<table>';
        foreach ($contact as $key => $value) {
            echo '<tr>';
            echo '<td>' . $value['name'] . '</td>';
            echo '<td>' . $value['email'] . '</td>';
            echo '<td>' . $value['phone'] . '</td>';
            echo '<td>' . $value['address'] . '</td>';
            echo '<td>' . $value['course_code'] . '</td>';
            echo '<td>' . $value['date_rgt'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';

//        echo '<pre>';
//        print_r($contact);
    }

}
