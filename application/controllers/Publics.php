<?php


class Publics extends CI_Controller {

    public function getEmail() {
        $post = $this->input->post('email');
        $time = date('d-m-Y-h-i-s');
        $myfile = fopen(APPPATH . "../public/get-email/" . $time . ".txt", "w") or die("Unable to open file!");
        fwrite($myfile, $post);
        fclose($myfile);
    }

    public function test() {         
        $emailTo = 'chuyenbka@gmail.com';
        $this->load->library("email");
        $this->email->from('cskh@lakita.vn', "lakita.vn");
        $this->email->to($emailTo);
        $this->email->subject('hihi123');
        $this->email->message('haha');
        $this->email->send();
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
