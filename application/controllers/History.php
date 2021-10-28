<?php
require(APPPATH.'/libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;

ini_set('max_execution_time', 0); 
ini_set('memory_limit','2048M'); 


class History extends REST_Controller{
    public function __construct(){
		parent::__construct();
        $this->load->model('model_history');
    }

    public function index_get(){
        $response['status']     = false;
        $response['message']['global'] = 'Internal server error';
        //for now
        $params = $this->get();
        $types  = isset($params['type']) ? $params['type'] : '';
        if(!isset($params['date'])){
            $response['message']['global'] = "Date is required";
        }else{
            $config = array(
                array('field' => 'rangeawal', 'label' => 'Range awal', 'rules' => 'required|integer'),
                array('field' => 'rangeakhir', 'label' => 'Range akhir', 'rules' => 'required|integer'),
                array('field' => 'type', 'label' => 'type', 'rules' => "required|callback_validatetype[$types]")
            );
            $this->form_validation->set_data($params);
            $this->form_validation->set_rules($config);
            if($this->form_validation->run() === FALSE){
                $response['message'] = $this->form_validation->error_array();
            }else{
                $resi = $this->model_history->getResi($params);
                $countnya  = 0;
                if(count($resi) > 0){
                    $connote        = array();
                    $exitingResi    = array();

                    foreach($resi as $key){
                        //$value = $key['connote_code'];
                        $value = $key;
                        $ch = curl_init();

                        curl_setopt($ch, CURLOPT_URL, 'https://apiexpos.mile.app/public/v1/connote/'.$value);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

                        $headers = array();
                        $headers[] = 'X-Api-Key: 04e5185fa9402cf4c06faac5dee754d40452f2c8';
                        $headers[] = 'Accept: application/';
                        $headers[] = 'Content-Type: application/';
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                        $server_output = json_decode(curl_exec($ch), true);
                        $err = curl_error($ch);

                        curl_close($ch);

                        if(!$err){
                            if(isset($server_output['message'])){ //data not found
                                //$response['message']
                                // print_r(array("kosong"));
                            }else{
                                $test = $this->addToJembatan($server_output);
                                print_r($test);

                                $connote_id                         = isset($server_output['connote_id']) ? $server_output['connote_id'] : '';
                                $connote_code                         = isset($server_output['connote_code']) ? $server_output['connote_code'] : '';
                                if(strlen($connote_id) > 2){ //makesure code is not empty string
                                    //to update data delete first
                                    $this->db->delete('dashboard', array('connote_id' => $connote_id));
                                    $this->db->delete('jsons', array('connote_id' => $connote_id));

                                    //save log
                                    $this->db->insert('jsons', array(
                                        'connote_id' => $connote_id,
                                        'history' => json_encode($server_output['connote_history']),
                                        'fullbody' => json_encode($server_output),
                                        'connote_code' => $connote_code
                                    ));

                                    //insert method here
                                    $connote  = $this->getConnote($server_output);
                                    $this->db->insert('dashboard', $connote);
                                    if($this->db->affected_rows() > 0){
                                        ++$countnya;
                                    }

                                }
                            }
                        }
                    }

                    $response['status'] = true;
                    $response['message']['global'] = "".$countnya." resi berhasil diinsert";
                }
            }
        }

        $this->response($response, 200);
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

    private function getConnote($data){
        $create     = isset($data['created_at']) ? date('Y-m-d h:i:s', strtotime($data['created_at'])) : date('Y-m-d h:i:s');
        $sla_day    = isset($data['connote_sla_day']) ? (int)$data['connote_sla_day'] : 0;
        $sla_date   = isset($data['connote_sla_date']) ? date('Y-m-d h:i:s', strtotime($data['connote_sla_date'])) : $this->getsladate($sla_day, $create);
        $created_at = isset($data['created_at']) ? date('Y-m-d h:i:s', strtotime($data['created_at'])) : $this->getcreatedat($sla_day, $sla_date);
        $history    = isset($data['connote_history']) ? $data['connote_history'] : array();
        $office     = isset($data['location_data_created']['location_code']) ? $data['location_data_created']['location_code'] : '00';
        $regional   = isset($data['connote_customfield']['regional']) ? $data['connote_customfield']['regional'] : $this->model_history->getRegByOffice($office);
        $last       = $this->getHistory($history);

        $result = array(
            'connote_id' => $data['connote_id'],
            'connote_code' => isset($data['connote_code']) ? $data['connote_code'] : '00',
            'connote_state' => isset($data['connote_state']) ? $data['connote_state'] : '00',
            'connote_service' => isset($data['connote_service']) ? $data['connote_service'] : '00',
            'connote_service_price' => isset($data['connote_service_price']) ? $data['connote_service_price'] : '00',
            'created_at' => $created_at,
            'connote_sla_day' => $sla_day,
            'connote_sla_date' => $sla_date,
            'location_id' => isset($data['location_id']) ? $data['location_id'] : null,
            'location_code' => $office,
            'location_region' => $regional,
            'last_connote_state' => isset($last['connote_state']) ? strtoupper($last['connote_state']) : 'UNKNOWN',
            'last_connote_update' =>  isset($last['updated_at']) ? date('Y-m-d h:i:s', strtotime($last['updated_at'])) : null,
            'last_connote_created' => isset($last['created_at']) ? date('Y-m-d h:i:s', strtotime($last['created_at'])) : null,
            'chargeable_weight' => isset($data['chargeable_weight']) ? $data['chargeable_weight'] : 0,
            'list_status' => $this->getStatuslist($history)
        );

        return $result;
    }

    public function validatetype($type){
        if($type == ''){
            $this->form_validation->set_message('validatetype', 'Type required');
            return false;
        }else{
            if($type == 'oncreate' || $type == 'onupdate' || $type == 'deliveryrunsheet'){
                return true;
            }else{
                $this->form_validation->set_message('validatetype', 'Type must in onupadate or oncreate');
                return false;
            }
        }
    }

    public function refresh_post(){
        $response['status'] = false;
        $response['message']['global'] = "Refresh failed";

        $sql = $this->db->query("REFRESH MATERIALIZED VIEW summarybaru");
        if($sql){
            $response['status'] = true;
            $response['message']['global'] = "oke";
        }

        $this->response($response, 200);
    }

    private function addToJembatan($jsonarr){
        $res['success'] = false;

        unset($jsonarr['@timestamp']);
        unset($jsonarr['@version']);

        $ch = curl_init();

        $field = $this->convert($jsonarr);

        curl_setopt($ch, CURLOPT_URL, 'http://10.29.41.109:8280/integration/v1/update');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($field));

        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'x-api-key: Bc3GbXAuge8ZbgVz6qzSPfrHuSsu29sp';
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

    private function convert($arr){
        $arr['connote']['history'] = $arr['connote_history'];
        $arr['connote']['connote_id'] = $arr['connote_id'];
        $arr['connote']['connote_number'] = $arr['connote_number'];
        $arr['connote']['connote_sender_name'] = $arr['connote_sender_name'];
        $arr['connote']['connote_sender_phone'] = $arr['connote_sender_phone'];
        $arr['connote']['connote_sender_email'] = $arr['connote_sender_email'];
        $arr['connote']['connote_sender_address'] = $arr['connote_sender_address'];
        $arr['connote']['connote_sender_zipcode'] = $arr['connote_sender_zipcode'];
        $arr['connote']['connote_receiver_name'] = $arr['connote_receiver_name'];
        $arr['connote']['connote_receiver_phone'] = $arr['connote_receiver_phone'];
        $arr['connote']['connote_receiver_email'] = $arr['connote_receiver_email'];
        $arr['connote']['connote_receiver_address'] = $arr['connote_receiver_address'];
        $arr['connote']['connote_receiver_address_detail'] = $arr['connote_receiver_address_detail'];
        $arr['connote']['connote_receiver_zipcode'] = $arr['connote_receiver_zipcode'];
        $arr['connote']['connote_service'] = $arr['connote_service'];
        $arr['connote']['connote_service_price'] = $arr['connote_service_price'];
        $arr['connote']['connote_amount'] = $arr['connote_amount'];
        $arr['connote']['connote_code'] = $arr['connote_code'];
        $arr['connote']['connote_booking_code'] = $arr['connote_booking_code'];
        $arr['connote']['connote_order'] = $arr['connote_order'];
        $arr['connote']['connote_state'] = $arr['connote_state'];
        $arr['connote']['connote_state_id'] = $arr['connote_state_id'];
        $arr['connote']['zone_code_from'] = $arr['zone_code_from'];
        $arr['connote']['zone_code_to'] = $arr['zone_code_to'];
        $arr['connote']['surcharge_amount'] = $arr['surcharge_amount'];
        $arr['connote']['transaction_id'] = $arr['transaction_id'];
        $arr['connote']['actual_weight'] = $arr['actual_weight'];
        $arr['connote']['volume_weight'] = $arr['volume_weight'];
        $arr['connote']['chargeable_weight'] = $arr['chargeable_weight'];
        $arr['connote']['created_by'] = $arr['created_by'];
        $arr['connote']['created_at'] = $arr['created_at'];
        $arr['connote']['updated_at'] = $arr['updated_at'];
        $arr['connote']['organization_id'] = $arr['organization_id'];
        $arr['connote']['location_id'] = $arr['location_id'];
        $arr['connote']['currentLocation'] = $arr['currentLocation'];
        $arr['connote']['connote_sla_day'] = $arr['connote_sla_day'];
        $arr['connote']['location_name'] = $arr['location_name'];
        $arr['connote']['location_type'] = $arr['location_type'];

        unset($arr['connote_history']);

        return $arr;
    }
}

?>