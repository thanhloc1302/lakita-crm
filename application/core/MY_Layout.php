<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_Layout
 *
 * @author phong
 */
class MY_Layout extends CI_Controller {

    //put your code here


    var $controller = '';
    var $method = '';

    public function __construct() {
        parent::__construct();
        $this->controller = $this->router->fetch_class();
        $this->method = $this->router->fetch_method();
        /*
         * Lấy controller và action
         */

        $data['controller'] = $this->controller;
        $data['action'] = $this->method;
    
        $this->load->vars($data);
    }

}
