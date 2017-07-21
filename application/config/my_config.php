<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (base_url() == 'http://chuyenpn.com/crm/' || base_url() == 'http://localhost/crm/') {
    $config['template_file_print'] = 'C:/xampp/htdocs/crm/public/upload/01Templatever3.xlsx';
} else {
    $config['template_file_print'] = '/home/lakita.com.vn/public_html/sub/crm2/public/upload/01Templatever3.xlsx';
}

$config['my_domain'] = 'http://crm2.lakita.vn/';

