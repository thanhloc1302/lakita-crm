<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Facebook_notification
 *
 * @author phong
 */
class Facebook_notification extends CI_Controller {

    function index() {
//        if ($_GET['hub_verify_token'] === 'lakita2018') {
//            echo $_GET['hub_challenge'];
//        }
        if (file_get_contents('php://input')) {
            $comment = json_decode(file_get_contents('php://input'));
            $commentId = $comment->entry[0]->changes[0]->value->id;
            $pageId = explode('_', $commentId);
            $input = [];
            $input['where'] = array('comment_id' => $commentId);
            $this->load->model('facebook_comment_plugin_model');
            $commentExist = $this->facebook_comment_plugin_model->load_all($input);
            if (empty($commentExist)) {
                $this->facebook_comment_plugin_model->insert(['comment_id' => $commentId, 'time' => date(_DATE_FORMAT_)]);
                $url = [
                '1633196606750778' => 'https://lakita.vn/ky-thuat-quyet-toan-thue.html',
                '1242593289171565' => 'https://lakita.vn/quyet-toan-thue-tu-a-den-z.html',
                '1298443350192736' => 'https://lakita.vn/ky-thuat-quyet-toan-thue.html',
                '1062159213912728' => 'https://lakita.vn/lap-bao-cao-tai-chinh-2017.html',
                '1665697290129137' => 'https://lakita.vn/tron-bo-lap-bao-cao-tai-chinh-2017.html',
                '1441397425925456' => 'https://lakita.vn/bi-quyet-lam-chu-excel-2017.html',
                '1436597719799600' => 'https://lakita.vn/ke-toan-cho-nguoi-moi-bat-dau.html',
                '1331503243639074' => 'https://lakita.vn/combo-ke-toan-excel-van-phong-2017.html'
                ];

                $replyComment = '';
                if (!empty($comment->entry[0]->changes[0]->value->parent)) {
                    $replyComment .= '<br> Trả lời comment: ' . $comment->entry[0]->changes[0]->value->parent->message .
                            '<br> của ' . $comment->entry[0]->changes[0]->value->parent->message->from->name;
                }
                $page = json_decode(file_get_contents('https://graph.facebook.com/v2.11/' . $pageId[0] . '?access_token=' . ACCESS_TOKEN));
                $urlTitle = isset($url[$pageId[0]]) ? $url[$pageId[0]] : $page->title;
                $this->load->library("email");
                $this->email->from('cskh@lakita.vn', "lakita.vn");
                $this->email->to('chuyenbka@gmail.com, ngoccongtt1@gmail.com, trinhnv@lakita.vn, phuongtravel46@gmail.com, maiduong250695@gmail.com');
                //$this->email->to('chuyenbka@gmail.com');
                $this->email->subject('Có cmt fb mới ở landing page ' . $page->title . ' (' . date(_DATE_FORMAT_) . ')');
                $this->email->message(
                        '<h2> Nội dung: ' . $comment->entry[0]->changes[0]->value->message . '</h2> '
                        . '<br> Được gửi từ: ' . $comment->entry[0]->changes[0]->value->from->name .
                        '<br> Landing page (click để đến landing page): <a href="' . $urlTitle . '"> ' . $page->title . '</a>' .
                        $replyComment);

                //   $this->email->message(file_get_contents('php://input'));
                $this->email->send();
                $this->email->clear(TRUE);
            }
        }
    }

}
