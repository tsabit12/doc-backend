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

        //the report is need like this
        //total = 80
        //on time = 100
        //jatuh tempo = 92
        //over sla = 20
        //menginap = 10
        //and then for the chart
        //count resi by reg, kprk, agenpos (next)


        $this->response($response, 200);
    }
}

?>