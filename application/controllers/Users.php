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
}

?>