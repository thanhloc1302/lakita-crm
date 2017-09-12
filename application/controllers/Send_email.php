<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Send_email
 *
 * @author phong
 */
class Send_email extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function send_banking_info() {
        $post = $this->input->post();
        if (!empty($post) && isset($post['contact_id'])) {
            $this->db->select('name, email, price_purchase');
            $contacts = $this->contacts_model->find($post['contact_id']);
            if (!empty($contacts)) {
                $contact = $contacts[0];
                $content = $this->load->view('email_template/send_banking_info', $contact, TRUE);
                //gửi email
                $this->load->library("email");
                $this->email->from('cskh@lakita.vn', "lakita.vn");
                $this->email->to($contact['email']);
                $this->email->subject('THÔNG TIN CHUYỂN KHOẢN LAKITA');
                $this->email->message($content);
                $this->email->send();

                //cập nhật đã gửi mail
                $where = array('id' => $post['contact_id']);
                $data = array('send_banking_info' => 1);
                $this->contacts_model->update($where, $data);
            }
        }
    }

    public function send_account_lakita() {
        $post = $this->input->post();
        if (!empty($post) && isset($post['contact_id'])) {
            $this->db->select('name, course_code, email, phone');
            $contacts = $this->contacts_model->find($post['contact_id']);
            if (!empty($contacts)) {
                $contact = $contacts[0];
                //tạo tài khoản
                $client = $this->_create_account_lakita($contact);
                if ($client->success != 0) {
                    $contact['password'] = $client->password;
                    $content = $this->load->view('email_template/send_account_lakita', $contact, TRUE);
                    
                    //gửi email
                    $this->load->library("email");
                    $this->email->from('cskh@lakita.vn', "lakita.vn");
                    $this->email->to($contact['email']);
                    $this->email->subject('V/v: Thông báo tài khoản học tập và cách thức học tập trên hệ thống Lakita.vn');
                    $this->email->message($content);
                    if (ENVIRONMENT == 'production') {
                        $this->email->attach('/home/lakita.com.vn/public_html/sub/crm2/public/other/huong-dan-hoc-tap.docx');
                    } else {
                        $this->email->attach('C:\xampp\htdocs\CRM2\public\other\huong-dan-hoc-tap.docx');
                    }
                    $this->email->send();

                    //cập nhật đã gửi mail
                    $where = array('id' => $post['contact_id']);
                    $data = array('send_account_lakita' => 1);
                    $this->contacts_model->update($where, $data);
                    echo json_encode($client);
                } else {
                    echo json_encode($client);
                }
            }
        }
    }

    private function _create_account_lakita($contact) {
        require_once APPPATH . "libraries/Rest_Client.php";
        $config = array(
            'server' => 'https://lakita.vn/',
            'api_key' => 'RrF3rcmYdWQbviO5tuki3fdgfgr4',
            'api_name' => 'lakita-key'
        );
        $restClient = new Rest_Client($config);
        $uri = "account_api/create_new_account";
        $client = $restClient->post($uri, $contact);
        return $client;
    }

}