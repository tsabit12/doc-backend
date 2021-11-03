<?php
require(APPPATH.'/libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;

Class Notification extends REST_Controller{
     public function __construct(){
		parent::__construct();
        $this->load->model('model_notification');
    }

     public function index_post(){
          $res['status'] = false;
          $res['message']['global'] = "failed push notification";

          $payload = $this->model_notification->getNotif();
          
          
          $ch = curl_init();

     
          curl_setopt($ch, CURLOPT_URL, 'https://exp.host/--/api/v2/push/send');
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

          $headers = array();
          $headers[] = 'Accept: application/json';
          $headers[] = 'Content-Type: application/json';
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

          $server_output = json_decode(curl_exec($ch), true);
          $err = curl_error($ch);

          curl_close($ch);

          if(!$err){
               $res['status'] = true;
               $res['message']['global'] = "Push notification success";
               $res['output'] = $server_output;
          }
     

          $this->response($res, 200);


     }
}

?>