<?php
require(APPPATH.'/libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;

Class Users extends REST_Controller{
     public function __construct(){
		parent::__construct();
          $this->load->model('model_user');
     }

     public function index_get(){
          $response['status'] = false;
          $response['message']['global'] = "user tidak ditemukan";

          $params = $this->get();

          if(!isset($params['level'])){
               $response['message']['level'] = "Level is required";
               unset($response['message']['global']);
          }else{
               $type = isset($params['type']) ? $params['type'] : NULL;
               $config = array(
                    array('field' => 'regional', 'label' => 'Regional', 'rules' => 'required'),
                    array('field' => 'kprk', 'label' => 'Kprk', 'rules' => 'required'),
                    array('field' => 'offset', 'label' => 'Offset', 'rules' => "integer|callback_validatepaging[$type]"),
                    array('field' => 'limit', 'label' => 'Limit', 'rules' => "integer|callback_validatepaging[$type]"),
                    array('field' => 'type', 'label' => 'Type', 'rules' => 'required'),
               );

               $this->form_validation->set_data($params);
               $this->form_validation->set_rules($config);
               if($this->form_validation->run() === FALSE){
                    $response['message'] = $this->form_validation->error_array();
               }else{
                    $data = $this->model_user->get($params);
                    if($data['status']){
                         $response['status'] = true;
                         $response['data'] = $data['result'];
                         unset($response['message']);
                    }
               }
          }

          $this->response($response, 200);
     }

     public function validatepaging($input, $type){
          if($type == 'count'){
               return true;
          }else{
               if($input || $input == '0'){
                    if(is_int((int)$input)){
                         return true;
                    }else{
                         $this->form_validation->set_message('validatepaging', '{field} must contain an integer.');
                         return false;
                    }
               }else{
                    $this->form_validation->set_message('validatepaging', '{field} is required');
                    return false;
               }
          }
     }

     public function index_post(){
          $response['status'] = false;
          $response['message']['global'] = "Internal server error";

          $data = $this->post();

          if(!isset($data['username'])){
               unset($response['message']['global']);
               $response['message']['username'] = "Username is required";
          }else{
               $config = array(
                    array('field' => 'username', 'label' => 'Username', 'rules' => 'required|max_length[15]|is_unique[users.username]'),
                    array('field' => 'fullname', 'label' => 'Fullname', 'rules' => 'required|max_length[70]'),
                    array('field' => 'roleid', 'label' => 'Role', 'rules' => 'required|max_length[1]'),
                    array('field' => 'office', 'label' => 'Office', 'rules' => 'required'),
                    array('field' => 'password', 'label' => 'Password', 'rules' => 'required'),
                    array('field' => 'email', 'label' => 'Email', 'rules' => 'required|valid_email|is_unique[users.email]'),
                    array('field' => 'created_by', 'label' => 'createdby', 'rules' => 'required')
               );
               $this->form_validation->set_data($data);
               $this->form_validation->set_rules($config);
               $this->form_validation->set_message('is_unique', '{field} sudah terdaftar');

               if($this->form_validation->run() === FALSE){
                    $response['message'] = $this->form_validation->error_array();
               }else{
                    $add = $this->model_user->add($data);
                    if($add['success']){
                         $response['status']      = true;
                         $response['message']     = new StdClass();
                         $response['user']        = $add['user'];
                    }else{
                         $response['message']['global'] = "Add user failed!";
                    }
               }
          }

          $this->response($response, 200);
     }
}

?>