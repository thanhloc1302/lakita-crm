<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Contact_model
 *
 * @author CHUYEN
 */
class Call_status_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'call_stt';
    }

    public function find_call_status_desc($id) {
        $input2 = array();
        $input2['where'] = array('id' => $id);
        $result = $this->load_all($input2);
        if (!empty($result))
            return $result[0]['name'];
        return '';
    }

}
