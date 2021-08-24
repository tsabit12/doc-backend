<?php
require(APPPATH.'/libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;

class Referensi extends REST_Controller{
    public function __construct(){
		parent::__construct();
        $this->load->model('model_referensi');
    }

    public function kprk_post(){
        $response['status'] = false;
        $response['message']['global'] = 'Internal server error';

        $params = $this->post();
        if(!isset($params['regional'])){
            $response['message']['global'] = 'Regional is required';
        }else{
            $data = $this->model_referensi->getKprk($params['regional']);
            $response['kprk']       = $data;
            $response['message']    = new StdClass();
            $response['status']    = true;
        }

        $this->response($response, 200);
    }
}
?>