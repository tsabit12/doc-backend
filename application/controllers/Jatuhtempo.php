<?php

require(APPPATH.'/libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;

class Jatuhtempo extends REST_Controller{
    public function __construct(){
		parent::__construct();
        $this->load->model('model_jatuhtempo');
    }

    public function index_get(){
        $response['status'] = false;
        $response['message']['global'] = "Data tidak ditemukan";

        $params = $this->get();
        if(!isset($params['regional'])){
            $response['message']['global'] = "Regional is required";
        }else{
            $config = array(
                array('field' => 'regional', 'label' => 'Reg', 'rules' => 'required|max_length[10]'),
                array('field' => 'kprk', 'label' => 'Kprk', 'rules' => 'required|max_length[10]'),
                array('field' => 'startdate', 'label' => 'Startdate', 'rules' => 'required|max_length[12]'),
                array('field' => 'enddate', 'label' => 'Enddate', 'rules' => 'required|max_length[12]')
            );

            $this->form_validation->set_data($params);
            $this->form_validation->set_rules($config);

            if($this->form_validation->run() === FALSE){
                $response['message'] = $this->form_validation->error_array();
            }else{
                $data = $this->model_jatuhtempo->get($params);
                if($data['exist']){
                    $response['status'] = true;
                    //$response['message'] = new StdClass();
                    $response['data'] = $data['result'];
                }else{
                    $response['message']['global'] = 'Data tidak ditemukan';
                }
            }
        }

        $this->response($response, 200);
    }
}

?>