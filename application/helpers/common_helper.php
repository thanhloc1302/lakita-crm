<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of common
 *
 * @author CHUYEN
 */
function redirect_and_die($message = 'có lỗi xảy ra') {
    echo '<script> alert("' . $message . '");</script>';
    echo "<script>location.href='" . $_SERVER['HTTP_REFERER'] . "';</script>";
    die;
}

function show_error_and_redirect($msg = '', $redirect = '', $msg_success = true) {
    $ci = & get_instance();
    $ci->session->set_tempdata('message', $msg, 2);
    if (!$msg_success) {
        $ci->session->set_tempdata('msg_success', 0, 2);
    }
    $redirect2 = $redirect;
    if ($redirect == '') {
        $redirect2 = $_SERVER['HTTP_REFERER'];
    }
    header('Location: ' . $redirect2);
    die;
}

function print_arr($myArr) {
    echo '<pre>';
    print_r($myArr);
    die;
}

function echoQuery() {
    $ci = & get_instance();
    echo $ci->db->last_query() . '<br>';
}

function h_caculate_money($contact) {
    $money = 0;
    if (is_array($contact)) {
        foreach ($contact as $value) {
            $money += $value['price_purchase'];
        }
    }
    return $money;
}

function found_position_in_array($phone, $contacts) {
    $result = 0;
    if (is_array($contacts) && !empty($contacts)) {
        foreach ($contacts as $key => $value) {
            if ($phone == $value['phone']) {
                $result = $key;
                break;
            }
        }
    }
    return $result;
}

function h_sum_money($contacts) {
    $sum = 0;
    foreach ($contacts as $value) {
        $sum += $value['price_purchase'];
    }
    return $sum;
}
function h_sum_money_1($contacts) {
    $sum = 0;
    foreach ($contacts as $value) {
        $sum += $value['money'];
    }
    return $sum;
}

function h_find_name_display($column_name, $list_view) {
    $name = '';
    foreach ($list_view as $key => $value) {
        if ($key == $column_name) {
            $name = $value['name_display'];
            break;
        }
    }
    return $name;
}

function get_total_campaign_info($rows){
    $total_C3 = 0;
    $price_sum = 0;
    foreach ($rows as $value) {
        $total_C3 += $value['total_C3'];
        $price_sum += $value['price'];
    }
    
}

function get_fb_request($url)
{
  $options = array(
    CURLOPT_URL            => $url,
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_HEADER         => FALSE,
    CURLOPT_FOLLOWLOCATION => TRUE,
    CURLOPT_ENCODING       => '',
    CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.87 Safari/537.36',
    CURLOPT_AUTOREFERER    => TRUE,
    CURLOPT_CONNECTTIMEOUT => 150,
    CURLOPT_TIMEOUT        => 150,
    CURLOPT_MAXREDIRS      => 5,
    CURLOPT_SSL_VERIFYHOST => 2,
    CURLOPT_SSL_VERIFYPEER => 0
  );
  $ch = curl_init();
  curl_setopt_array($ch, $options);
  $response = curl_exec($ch);
  $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  unset($options);
  return $http_code === 200 ? json_decode($response) : FALSE;
}

function h_caculate_channel_cost($channel_cost){
    $costArr = array(
        'total_C1' => 0,
        'total_C2' => 0,
        'total_C3' => 0,
        'spend' => 0,
    );
    foreach ($channel_cost as $value){
        $costArr['total_C1'] += $value['total_C1'];
        $costArr['total_C2'] += $value['total_C2'];
        $costArr['total_C3'] += $value['total_C3'];
        $costArr['spend'] += $value['spend'];
    }
    return $costArr;
}
