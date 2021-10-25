<?php
class Push extends CI_Controller{
     public function __construct(){
		parent::__construct();
          $this->load->model('model_history');
     }

     public function index(){
          $response['Code'] = '000';
          $response['Status'] = 'Berhasil';     

          ob_end_clean();

          //apache_setenv('no-gzip', 1);
          ini_set('zlib.output_compression', 0);
          ini_set('implicit_flush', 1);
          header("Content-Encoding: none");

          header('Content-Type: application/json');

          header("Connection: close");

          ignore_user_abort(); 

          ob_start();

          echo json_encode($response);

          $size = ob_get_length();
          header("Content-Length: $size");

          // clear ob* buffers
          for ($i = 0; $i < ob_get_level(); $i++) {
               ob_end_flush();
          }

          flush(); // clear php internal output buffer

          // start a time consuming task
          sleep(3);

          $request  = file_get_contents('php://input');
          $aDatax   = json_decode($request, true);

          $this->addToJembatan($aDatax);

          $insertData   =  $this->getconnote($aDatax);
          if(count($insertData) > 0){
               $this->db->delete('dashboard', array('connote_id' => $insertData['connote_id']));
               $this->db->delete('jsons', array('connote_id' => $insertData['connote_id']));

               $this->db->insert('jsons', array(
                    'connote_id' => $insertData['connote_id'],
                    'history' => json_encode($aDatax['connote']['history']),
                    'fullbody' => json_encode($aDatax),
                    'connote_code' => $insertData['connote_code']
               ));
               $this->db->insert('dashboard', $insertData);
          }
     }

     private function getcreatedat($day, $sla_date){
          if($sla_date){
              return date('Y-m-d h:i:s', strtotime($sla_date . " -$day day"));
          }else{
              return null;
          }
      }
  
      private function getsladate($day, $createdat){
          return date('Y-m-d h:i:s', strtotime($createdat . " +$day day"));
      }

     private function getHistory($arr){
          if(count($arr) > 0){
              return end($arr);
          }else{
              return $arr;
          }
     }

     private function getStatuslist($arr){
          $status = array();
          foreach($arr as $key){
              $status[] = strtoupper($key['action']);
          }
  
          return implode(',', $status);
     }

     private function getconnote($data){
          $history    = isset($data['connote']['history']) ? $data['connote']['history'] : array();
          $create     = isset($data['created_at']) ? date('Y-m-d h:i:s', strtotime($data['created_at'])) : date('Y-m-d h:i:s');
          $sla_day    = isset($data['connote']['connote_sla_day']) ? (int)$data['connote']['connote_sla_day'] : 0;
          $sla_date   = isset($data['connote_sla_date']) ? date('Y-m-d h:i:s', strtotime($data['connote_sla_date'])) : $this->getsladate($sla_day, $create);
          $created_at = isset($data['created_at']) ? date('Y-m-d h:i:s', strtotime($data['created_at'])) : $this->getcreatedat($sla_day, $sla_date);
          $office     = isset($data['origin_data']['zone_code']) ? $data['origin_data']['zone_code'] : null;
          $last       = $this->getHistory($history);

          $result = array(
               'connote_id' => isset($data['connote_id']) ? $data['connote_id'] : null,
               'connote_code' => isset($data['connote']['connote_code']) ? $data['connote']['connote_code'] : '00',
               'connote_state' => isset($data['connote']['connote_state']) ? $data['connote']['connote_state'] : '00',
               'connote_service' => isset($data['connote']['connote_service']) ? $data['connote']['connote_service'] : '00',
               'connote_service_price' => isset($data['connote']['connote_service_price']) ? $data['connote']['connote_service_price'] : 0,
               'created_at' => $created_at,
               'connote_sla_day' => $sla_day,
               'connote_sla_date' => $sla_date,
               'location_id' => isset($data['location_id']) ? $data['location_id'] : null,
               'location_code' => $office,
               'location_region' => $this->model_history->getReg($data['origin_data']),
               'last_connote_state' => isset($last['state']) ? strtoupper($last['state']) : 'UNKNOWN',
               'last_connote_update' =>  isset($last['date']) ? date('Y-m-d h:i:s', strtotime($last['date'])) : null,
               'last_connote_created' => isset($last['date']) ? date('Y-m-d h:i:s', strtotime($last['date'])) : null,
               'list_status' => $this->getStatuslist($history)
          );

          return $result;
     }

     private function addToJembatan($jsonarr){
          $res['success'] = false;

          unset($jsonarr['@timestamp']);
          unset($jsonarr['@version']);

          $ch = curl_init();

          curl_setopt($ch, CURLOPT_URL, 'http://10.29.41.109:8280/integration/v1/update');
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($jsonarr));

          $headers = array();
          $headers[] = 'Accept: application/json';
          $headers[] = 'Content-Type: application/json';
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

          $server_output = json_decode(curl_exec($ch), true);
          $err = curl_error($ch);

          curl_close($ch);

          if(!$err){
               $res['success'] = true;
               $res['output'] = $server_output;
          }

          return $res;

     }
}
?>