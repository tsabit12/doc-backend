<?php
require(APPPATH.'/libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;

class Test extends REST_Controller{
    public function index_get(){
        $this->response(array('status' => 'oke'), 200);
    }
}

?>