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
            switch ($role_id) {
                case 1: {
                        redirect(base_url('tu-van-tuyen-sinh/trang-chu.html'));
                        break;
                    }
                case 2: {
                        redirect(base_url('cod/trang-chu.html'));
                        break;
                    }
                case 3: {
                        redirect(base_url('quan-ly/trang-chu.html'));
                        break;
                    }
                case 4: {
                        redirect(base_url('admin'));
                        break;
                    }
                default : {
                        echo 'Có lỗi xảy ra!';
                        die;
                    }
            }
        } else {
            $this->load->view('home/login');
        }
    }

    function action_login() {
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
                switch ($result[0]['role_id']) {
                    case 1: {
                            redirect(base_url('tu-van-tuyen-sinh/trang-chu.html'));
                            break;
                        }
                    case 2: {
                            redirect(base_url('cod/trang-chu.html'));
                            break;
                        }
                    case 3: {
                            redirect(base_url('quan-ly/trang-chu.html'));
                            break;
                        }
                    case 4: {
                            redirect(base_url('admin'));
                            break;
                        }
                    default : {
                            echo 'Có lỗi xảy ra!';
                            die;
                        }
                }
            } else {
                echo '<script> alert("Username hoặc mật khẩu không đúng!");</script>';
                echo "<script>location.href='" . $_SERVER['HTTP_REFERER'] . "';</script>";
            }
        } else {
            echo '<script> alert("Username hoặc mật khẩu không đúng!");</script>';
            echo "<script>location.href='" . $_SERVER['HTTP_REFERER'] . "';</script>";
        }
    }

    function logout() {
        $this->session->sess_destroy();
        redirect(base_url());
    }

    function test_rest() {
        $this->load->library('rest');
        $config = array('server' => 'http://chuyenpn.com:8089/CRM_GIT/',
                'api_key'			=> '12345678',
                'api_name'		=> 'lakita-key'
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
