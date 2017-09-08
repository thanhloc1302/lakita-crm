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
            $this->db->select('name, email');
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

}
