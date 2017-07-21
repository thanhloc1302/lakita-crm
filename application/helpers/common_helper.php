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
