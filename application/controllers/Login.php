<?php
require(APPPATH.'/libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;

class Login extends REST_Controller{
    public function __construct(){
		parent::__construct();
        $this->load->model('model_login');
    }

    public function index_post(){
        $response['status']     = false;
        $response['message']['global'] = 'Internal server error';
        $data = $this->post();

        if(!isset($data['username'])){
            $response['message']['global'] = "Username required";
        }else{
            $config = array(
                array('field' => 'username', 'label' => 'Username', 'rules' => 'required|max_length[30]'), //max length sesuaikan dengan database
                array('field' => 'password', 'label' => 'Password', 'rules' => 'required')
            );
            $this->form_validation->set_data($data);
            $this->form_validation->set_rules($config);

            if($this->form_validation->run() === TRUE){
                $validate = $this->model_login->login($data);
                if($validate['success']){
                    $response['status']     = true;
                    $response['message']    = new StdClass();
                    $response['user']       = $validate['user'];
                }else{
                    $response['message']['global'] = "Invalid username or password";
                }
            }else{
                $response['message'] = $this->form_validation->error_array();
            }
        }

        $this->response($response, 200);
    }
}

?>