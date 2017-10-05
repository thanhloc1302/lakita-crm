<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cron
 *
 * @author Phạm Ngọc Chuyển <chuyenpn at lakita.vn>
 */
class Cron extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        ini_set('max_execution_time', 300);
    }

    public function update_campain_cost($day = '0') {
        if ($day == '0') {
            $day = "-1 days";
        }
        $get = $this->input->get();
        if (!isset($get['key']) || $get['key'] != 'ACOPDreqidsadfs2') {
            die('token sai!');
        }
        $this->load->model('campaign_cost_model');
        $today = strtotime(date('d-m-Y', strtotime($day))); //tính theo giờ Mỹ
        $today_fb_format = date('Y-m-d', strtotime($day));
        /*
         * Lấy danh sách tất cả campain đang hoạt động
         */
        $this->load->model('campaign_model');
        $input = array();
        $input['where'] = array('active' => 1);
        $campaigns = $this->campaign_model->load_all($input);
        foreach ($campaigns as $value) {
            /*
             * Kiểm tra xem đã tồn tại giá ngày hôm nay chưa (nếu có rồi thì bỏ qua)
             */
            $where = array('campaign_id' => $value['id'], 'time' => $today);
            $this->campaign_cost_model->delete($where);

            $url = 'https://graph.facebook.com/v2.9/' . $value['campaign_id_facebook'] .
                    '/insights?fields=spend,reach,clicks&level=account'
                    . '&time_range={"since":"' . $today_fb_format . '","until":"' . $today_fb_format . '"}&access_token=' . ACCESS_TOKEN;
            $spend = get_fb_request($url);
            $param['time'] = $today;
            $param['campaign_id'] = $value['id'];
            $param['spend'] = isset($spend->data[0]->spend) ? $spend->data[0]->spend : 0;
            $param['total_C1'] = isset($spend->data[0]->reach) ? $spend->data[0]->reach : 0;
            $param['total_C2'] = isset($spend->data[0]->clicks) ? $spend->data[0]->clicks : 0;
            $this->campaign_cost_model->insert($param);
        }
    }

    public function update_channel_cost($day = '0') {
        if ($day == '0') {
            $day = "-1 days";
        }
        $get = $this->input->get();
        if (!isset($get['key']) || $get['key'] != 'ACOPDreqidsadfs2') {
            die('token sai!');
        }
        $this->load->model('channel_cost_model');
        $today = strtotime(date('d-m-Y', strtotime($day))); //tính theo giờ Mỹ
        $today_fb_format = date('Y-m-d', strtotime($day));
        /*
         * Lấy danh sách tất cả campain đang hoạt động
         */
        $this->load->model('channel_model');
        $input = array();
        $input['where'] = array('active' => 1);
        $channels = $this->channel_model->load_all($input);
        foreach ($channels as $value) {
            //Kênh facebook
            if ($value['id'] == 2) {
                /*
                 * Kiểm tra xem đã tồn tại giá ngày hôm nay chưa (nếu có rồi thì bỏ qua)
                 */
                $where = array('channel_id' => $value['id'], 'time' => $today);
                $this->channel_cost_model->delete($where);
                $url = 'https://graph.facebook.com/v2.9/act_512062118812690/' .
                        'insights?fields=spend,reach,clicks&level=account'
                        . '&time_range={"since":"' . $today_fb_format . '","until":"' . $today_fb_format . '"}&access_token=' . ACCESS_TOKEN;
                $spend = get_fb_request($url);
                $param['time'] = $today;
                $param['channel_id'] = $value['id'];
                $param['spend'] = isset($spend->data[0]->spend) ? $spend->data[0]->spend : 0;
                $param['total_C1'] = isset($spend->data[0]->reach) ? $spend->data[0]->reach : 0;
                $param['total_C2'] = isset($spend->data[0]->clicks) ? $spend->data[0]->clicks : 0;
                $this->channel_cost_model->insert($param);
            }
        }
    }

    public function update_adset_cost($day = '0') {
        if ($day == '0') {
            $day = "-1 days";
        }
        $get = $this->input->get();
        if (!isset($get['key']) || $get['key'] != 'ACOPDreqidsadfs2') {
            die('token sai!');
        }
        $this->load->model('adset_cost_model');
        $today = strtotime(date('d-m-Y', strtotime($day))); //tính theo giờ Mỹ
        $today_fb_format = date('Y-m-d', strtotime($day));
        /*
         * Lấy danh sách tất cả adset đang hoạt động
         */
        $this->load->model('adset_model');
        $input = array();
        $input['where'] = array('active' => 1);
        $adsets = $this->adset_model->load_all($input);
        foreach ($adsets as $value) {
            /*
             * Kiểm tra xem đã tồn tại giá ngày hôm nay chưa (nếu có rồi thì bỏ qua)
             */
            $where = array('adset_id' => $value['id'], 'time' => $today);
            $this->adset_cost_model->delete($where);
            $url = 'https://graph.facebook.com/v2.9/' . $value['adset_id_facebook'] .
                    '/insights?fields=spend,reach,clicks&level=account'
                    . '&time_range={"since":"' . $today_fb_format . '","until":"' . $today_fb_format . '"}&access_token=' . ACCESS_TOKEN;
            $spend = get_fb_request($url);
            $param['time'] = $today;
            $param['adset_id'] = $value['id'];
            $param['spend'] = isset($spend->data[0]->spend) ? $spend->data[0]->spend : 0;
            $param['total_C1'] = isset($spend->data[0]->reach) ? $spend->data[0]->reach : 0;
            $param['total_C2'] = isset($spend->data[0]->clicks) ? $spend->data[0]->clicks : 0;
            $this->adset_cost_model->insert($param);
        }
    }

    public function update_ad_cost($day = '0') {
        if ($day == '0') {
            $day = "-1 days";
        }
        $get = $this->input->get();
        if (!isset($get['key']) || $get['key'] != 'ACOPDreqidsadfs2') {
            die('token sai!');
        }
        $this->load->model('ad_cost_model');
        $today = strtotime(date('d-m-Y', strtotime($day))); //tính theo giờ Mỹ
        $today_fb_format = date('Y-m-d', strtotime($day));
        /*
         * Lấy danh sách tất cả ad đang hoạt động
         */
        $this->load->model('ad_model');
        $input = array();
        $input['where'] = array('active' => 1);
        $adsets = $this->ad_model->load_all($input);
        foreach ($adsets as $value) {
            /*
             * Kiểm tra xem đã tồn tại giá ngày hôm nay chưa (nếu có rồi thì bỏ qua)
             */
            $where = array('ad_id' => $value['id'], 'time' => $today);
            $this->ad_cost_model->delete($where);

            $url = 'https://graph.facebook.com/v2.9/' . $value['ad_id_facebook'] .
                    '/insights?fields=spend,reach,clicks&level=account'
                    . '&time_range={"since":"' . $today_fb_format . '","until":"' . $today_fb_format . '"}&access_token=' . ACCESS_TOKEN;
            $spend = get_fb_request($url);
            $param['time'] = $today;
            $param['ad_id'] = $value['id'];
            $param['spend'] = isset($spend->data[0]->spend) ? $spend->data[0]->spend : 0;
            $param['total_C1'] = isset($spend->data[0]->reach) ? $spend->data[0]->reach : 0;
            $param['total_C2'] = isset($spend->data[0]->clicks) ? $spend->data[0]->clicks : 0;
            $this->ad_cost_model->insert($param);
        }
    }

    function test_cost_campaign() {
        for ($i = 1; $i <= 30; $i++) {
            $day = "-" . $i . " days";
            $this->update_campain_cost($day);
        }
    }

    function test_cost_channel() {
        for ($i = 1; $i <= 30; $i++) {
            $day = "-" . $i . " days";
            $this->update_channel_cost($day);
        }
    }

    function test_cost_adset() {
        for ($i = 1; $i <= 30; $i++) {
            $day = "-" . $i . " days";
            $this->update_adset_cost($day);
        }
    }

    function test_cost_ads() {
        for ($i = 1; $i <= 30; $i++) {
            $day = "-" . $i . " days";
            $this->update_ad_cost($day);
        }
    }

}
