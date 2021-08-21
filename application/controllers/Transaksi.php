<?php
require(APPPATH.'/libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;


class Transaksi extends REST_Controller{
    public function __construct(){
		parent::__construct();
        $this->load->model('model_transaksi');
    }

    public function index_post(){
        $response['status'] = false;
        $response['error'] = "Internal server error";

        $data = $this->post();
        if(!isset($data['values'])){
            $response['error'] = "Values body required";
        }else{
            $valueIsArray = $this->validateArray($data['values']);
            if($valueIsArray){
                $insert = $this->model_transaksi->insertData($data['values']);
                if($insert['success']){
                    $response['status'] = true;
                    $response['error'] = "";
                    $response['message'] = "Add transaction success";
                }else{
                    $response['error'] = "Insert failed! Please make sure the value must unique constraint (backsheet_id, mitra_id, service_id, office_code, transaction_date)";
                }
            }else{
                $response['error'] = 'Value not in array';
            }
        }


        $this->response($response, 200);
    }

    private function validateArray($mixed){
        return is_array($mixed) || $mixed instanceof Traversable ? true : false;
    }

    // private function isAssoc(array $arr){
    //     print_r($arr);
    //     if (array() === $arr) return false;
    //     return array_keys($arr) !== range(0, count($arr) - 1);
    // }
}