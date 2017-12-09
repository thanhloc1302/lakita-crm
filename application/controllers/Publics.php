<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Publics
 *
 * @author phong
 */
require_once APPPATH . '/vendor/autoload.php';

use Dompdf\Dompdf;

//
//use FacebookAds\Object\AdAccount;
//use FacebookAds\Object\AdsInsights;
//use FacebookAds\Api;
//use FacebookAds\Logger\CurlLogger;

class Publics extends CI_Controller {

    public function getEmail() {
        $post = $this->input->post('email');
        $time = date('d-m-Y-h-i-s');
        $myfile = fopen(APPPATH . "../public/get-email/" . $time . ".txt", "w") or die("Unable to open file!");
        fwrite($myfile, $post);
        fclose($myfile);
    }

    public function test() {
          $str = file_get_contents('http://localhost/CRM2/MANAGERS/ad');
         // echo $str;die;
// instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml($str);

// (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
        $dompdf->render();

// Output the generated PDF to Browser
        $dompdf->stream();
        //   $str = $html2pdf->output('001.pdf', FCPATH . 'public/report');
        //echo $str; die;
        $emailTo = 'chuyenpn@lakita.vn';
        $this->load->library("email");
        $this->email->from('cskh@lakita.vn', "lakita.vn");
        $this->email->to($emailTo);
        $this->email->subject('BÁO CÁO COD NGÀY ' . date('d-m-Y') . ' (BY CLI & CRON JOB)');
        $this->email->message($str);
        //$this->email->send();
    }

    public function index() {

//        Api::init(
//                '1659071634411828', // App ID
//                '70eadeff70366b88905151df276ed844', 'EAAXk6rdtETQBABFZBrxwbGNe7ZAr1NpVadlVbCXZCocrC0TAaSX1ZBJTHmL7ZCdSkcsPE8URqBYsAXKgoibZAiZCfo5x9RZAcPHDuZB0uQFSNC9nrJdloOvtANPRSG0x6c6nl9O9FKUPxiL0ddDoXZAcIX1S7eZCv49Q51t2bQAHTXBd0bfCZBhLoOK2CGoZCSBfjlpYZD' // Your user access token
//        );
//
//        $me = new AdAccountUser('me');
//        $my_adaccount = $me->getAdAccounts()->current();



        $access_token = 'EAAXk6rdtETQBAPOhGenIU6T7daqqgSniZArnfG9cmVDYZA7PeX0fSZCoZAZAk2ZA0fNhe7A8B6GPlvftCfjD0cyzopXOZCIyRNWQi3D3nvmZAg8vBz3tKnosgXwfDjPtuEcD9kuDZBTaFG6WGs0HZCtwoedixZCYCpo2wk01JYP4ZALfIn7phnt7mLER';
        $ad_account_id = 'act_512062118812690';
        $app_secret = '70eadeff70366b88905151df276ed844';
        $app_id = '1659071634411828';

        Api::init($app_id, $app_secret, $access_token);

        $fields = array(
            'reach',
            'spend',
        );
        $params = array(
            'level' => 'campaign',
            'filtering' => array(array('field' => 'adgroup.delivery_info', 'operator' => 'IN', 'value' => array('active', 'limited',
                        'scheduled', 'pending_review', 'recently_rejected', 'rejected', 'inactive', 'not_delivering',
                        'not_published', 'rejected', 'completed', 'recently_completed', 'archived', 'permanently_deleted'))),
            'breakdowns' => array()
        );
        print_arr((new AdAccount($ad_account_id))->getInsights(
                        $fields, $params
                )->getResponse()->getContent(), JSON_PRETTY_PRINT);
    }

}
