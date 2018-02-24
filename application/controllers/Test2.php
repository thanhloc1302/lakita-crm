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
        
        foreach ($course_list as $key5 => $value5){
            echo '<tr>';
            echo '<td>'.$key5.'</td><td>'.number_format($value5['get'], 0, ",", ".") . " VNĐ" .'</td><td>'.number_format($value5['marketing_spend'], 0, ",", ".") . " VNĐ" .'</td><td>'.number_format($value5['get'] - $value5['marketing_spend'], 0, ",", ".") . " VNĐ" .'</td>' ;
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

}
