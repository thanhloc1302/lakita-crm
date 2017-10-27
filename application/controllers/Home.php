<?php

/**
 * Description of Home
 *
 * @author CHUYEN
 * test commit12
 */
class Home extends CI_Controller {
    /*
     * Ham khi khoi tao
     * demo git
     * hay quá
     */

    public function __construct() {
        parent::__construct();
    }

    function index() {
        $user_id = $this->session->userdata('user_id');
        if (isset($user_id)) {
            $role_id = $this->session->userdata('role_id');
            $input = array();
            $input['where'] = array('id' => $user_id);
            $user = $this->staffs_model->load_all($input);
            if($user[0]['active'] == 0){
                echo 'Tài khoản của bạn đã bị khóa, vui lòng liên hệ với quản lý để đc giúp đỡ';
                echo '<a href="'.base_url('home/logout').'"> Đăng xuất </a>';
                die;
            }
            switch ($role_id) {
                case 1:
                    redirect(base_url('tu-van-tuyen-sinh/trang-chu.html'));
                    break;

                case 2:
                    redirect(base_url('cod/trang-chu.html'));
                    break;

                case 3:
                    redirect(base_url('quan-ly/trang-chu.html'));
                    break;

                case 4:
                    redirect(base_url('admin'));
                    break;
                case 5:
                    redirect(base_url('marketing'));
                    break;
                case 6:
                    redirect(base_url('marketer'));
                    break;
                default :
                    echo 'Có lỗi xảy ra!';
                    die;
            }
        } else {
            $this->load->view('home/login');
        }
    }

    function action_login() {
        $alert = array();
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        if ($username != '' && $password != '') {
            $input = array();
            $input['where'] = array(
                'username' => $username,
                'password' => md5(md5($password))
            );
            $result = $this->staffs_model->load_all($input);
            if (!empty($result)) {
                $this->session->set_userdata('user_id', $result[0]['id']);
                $this->session->set_userdata('name', $result[0]['name']);
                $this->session->set_userdata('role_id', $result[0]['role_id']);
                $this->session->set_userdata('image_staff', $result[0]['image']);
                $last_page = $this->session->userdata('last_page');
                if (isset($last_page)) {
                    $this->session->unset_userdata('last_page');
                    $alert['success'] = 1;
                    $alert['redirect_page'] = base64_encode($last_page);
                    echo json_encode($alert);
                    die;
                }
                $redirect_page = '';
                $alert['success'] = 1;
                $alert['redirect_page'] = base64_encode(base_url().$redirect_page);
                echo json_encode($alert);
                die;
            } else {
                $alert['success'] = 0;
                $alert['message'] = "Username hoặc mật khẩu không đúng!";
                echo json_encode($alert);
                die;
            }
        } else {
            $alert['success'] = 0;
            $alert['message'] = "Username hoặc mật khẩu không đúng!";
            echo json_encode($alert);
            die;
        }
    }

    function logout() {
        $this->session->sess_destroy();
        redirect(base_url());
    }

    function test_rest() {
        $this->load->library('rest');
        $config = array('server' => 'http://chuyenpn.com:8089/CRM_GIT/',
            'api_key' => '12345678',
            'api_name' => 'lakita-key'
                //'http_user' 		=> 'username',
                //'http_pass' 		=> 'password',
                //'http_auth' 		=> 'basic',
                //'ssl_verify_peer' => TRUE,
                //'ssl_cainfo' 		=> '/certs/cert.pem'
        );

        $this->rest->initialize($config);
        $tweets = $this->rest->get('contact_api/contacts');

        print_arr($tweets);
    }

}
