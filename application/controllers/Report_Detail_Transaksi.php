<?php
require(APPPATH.'/libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;

class Report_Detail_Transaksi extends REST_Controller{
    public function __construct(){
		parent::__construct();
        $this->load->model('model_reportdetail');
    }

    public function index_post(){
        $response['status'] = false; //default status
        $response['message']['global'] = 'Data tidak ditemukan'; //default message is object 
        $body = $this->post();

        if(!isset($body['regional'])){
            $response['message']['global'] = "Regional required";
        }else{
            $config  = array(
                array('field' => 'kprk', 'label' => 'kprk', 'rules' => 'required|max_length[6]'),
                array('field' => 'regional', 'label' => 'regional', 'rules' => 'required|max_length[6]'),
                array('field' => 'startdate', 'label' => 'startdate', 'rules' => 'required'),
                array('field' => 'enddate', 'label' => 'enddate', 'rules' => 'required')
            );
            $this->form_validation->set_data($body);
            $this->form_validation->set_rules($config);

            if($this->form_validation->run() === TRUE){
                $data = $this->model_reportdetail->getProduksi($body);
                if($data['success']){
                    $response['status'] = true;
                    $response['message'] = new StdClass();
                    $response['data'] = $data['data'];
                }else{
                    $response['message']['global'] = "Data not found";
                }
            }else{
                $response['message'] = $this->form_validation->error_array();
            }

        }
        
        $this->response($response, 200);

    }
}