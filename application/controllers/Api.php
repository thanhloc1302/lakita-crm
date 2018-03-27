<?php

class Api extends CI_Controller {

    function get_contact() {

        
        $this->load->model('contacts_model');
        $get = $this->input->get();
      
        $input['select'] = 'id, name, email, phone, course_code, price_purchase, date_rgt, date_receive_lakita, date_receive_cod, cod_status_id, id_lakita';
         
        $input['where'] = array('date_rgt >=' => $get['start_date'], 'date_rgt <=' => $get['end_date'], 'cod_status_id >' => 1, 'cod_status_id <' => 4);


        $input['order'] = array('date_rgt' => 'desc');
        
        var_dump($get);
        var_dump($input);die;
        
        $contact = $this->contacts_model->load_all($input);


        echo json_encode($contact);
    }

}
