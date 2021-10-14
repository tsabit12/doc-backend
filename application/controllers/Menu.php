<?php
require(APPPATH.'/libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;

Class Menu extends REST_Controller{
     public function __construct(){
		parent::__construct();
        $this->load->model('model_menu');
    }

     public function index_get(){
          $response['status'] = false;
          $response['message']['global'] = "Menu not found";

          $params = $this->get();
          if(!isset($params['roleid'])){
               $response['message']['roleid'] = "Role is required";
               unset($response['message']['global']);
          }else{
               $data = $this->model_menu->get($params);
               if($data['status']){
                    $response['message']['global'] = new StdClass();
                    $response['status'] = true;
                    $response['menu'] = $data['menu'];
               }
          }

          $this->response($response, 200);
     }
}

?>