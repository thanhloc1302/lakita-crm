<?php

class Api extends CI_Controller {

    function get_contact() {


        $this->load->model('contacts_model');
        $get = $this->input->get();

        $input['select'] = 'id, name, email, phone, course_code, price_purchase, date_rgt, date_receive_lakita, date_receive_cod, cod_status_id, id_lakita';

        $input['where'] = array('date_rgt >' => $get['start_date'], 'date_rgt <=' => $get['end_date'], 'cod_status_id >' => 1, 'cod_status_id <' => 4);


        $input['order'] = array('date_rgt' => 'desc');

        $contact = $this->contacts_model->load_all($input);

        echo json_encode($contact);
    }

    function get_id_lakita() {

        // for ($i = 0; $i <= 10; $i++) {
        $input = [];
        $input['select'] = 'id,email,phone,course_code,date_rgt';
        $input['where'] = array('cod_status_id >' => 1, 'cod_status_id <' => 4);
        $input['order'] = array('date_receive_lakita' => 'desc');
        $input['limit'] = array(100, 0);
        $contact = $this->contacts_model->load_all($input);
        $list_contact=array();
        foreach ($contact as $value) {
            $result = '';
            $result = file_get_contents('https://lakita.vn/api/check_exit_email?email=' . $value['email'] . '&phone=' . $value['phone'] . '&course_code=' . $value['course_code'].'&date_rgt='.$value['date_rgt']);
            $result = json_decode($result, true);
            
            if($result['error'] == '0' && $result['active'] != 'FALSE' ){
                $list_contact[]=$result;
                $where = array('id' => $value['id']);
                $data = array('id_lakita' => $result['active'][0]['id_lakita'],'date_active' => $result['active'][0]['date_active']);
                $this->contacts_model->update($where, $data);
           }
        }
        echo '<pre>';
        print_r($list_contact);

        echo '<script>alert("xong");</script>';
    }

}
