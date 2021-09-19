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
        if(!isset($params['date'])){
            $response['message']['global'] = "Date is required";
        }else{
            $config = array(
                array('field' => 'rangeawal', 'label' => 'Range awal', 'rules' => 'required|integer'),
                array('field' => 'rangeakhir', 'label' => 'Range akhir', 'rules' => 'required|integer')
            );
            $this->form_validation->set_data($params);
            $this->form_validation->set_rules($config);
            if($this->form_validation->run() === FALSE){
                $response['message'] = $this->form_validation->error_array();
            }else{
                $resi = $this->model_history->getResi($params);
                if(count($resi) > 0){
                    $connote        = array();
                    $custome_field  = array();
                    $history        = array();
                    $exitingResi    = array();
                    $location       = array();

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
                            $connote_id                         = isset($server_output['connote_id']) ? $server_output['connote_id'] : '';
                            if(strlen($connote_id) > 2){
                                $reslocation_field                  = $server_output['location_data_created'];
                                $reslocation_field['connote_id']    = $connote_id;
                                
                                //to update data delete first
                                $this->db->delete('connote_customfield', array('connote_id' => $connote_id));
                                $this->db->delete('location_data_created', array('connote_id' => $connote_id));
                                $this->db->delete('connote', array('connote_id' => $connote_id)); 
                                $this->db->delete('history', array('connote_code' => $server_output['connote_code']));

                                $custome_field[]        = $this->getCustomeField($server_output['connote_customfield'], $connote_id);
                                $location[]             = $reslocation_field;
                                $connote[]              = $this->getConnote($server_output);

                                foreach($server_output['connote_history'] as $key){
                                    $exitingResi[] = $key['connote_code'];
                                    $history[] = $key;
                                }
                            }
                        }
                    }

                    
                    // if(count($output) > 0){
                    //     $this->db->where_in('connote_code', $exitingResi);
                    //     $this->db->delete('history');
                        
                    //     $this->db->insert_batch('history', $output);
                    //     if($this->db->affected_rows() > 0){
                    //         $response['status'] = true;
                    //         $response['message'] = new StdClass();
                    //         $response['insterted'] = $this->db->affected_rows();
                    //     }                
                    // }
                    

                    $response['status']             = true;
                    $response['message']['global']  = "".count($connote)." Resi berhasil di insert";

                    $this->db->insert_batch('connote', $connote);
                    $this->db->insert_batch('connote_customfield', $custome_field);
                    $this->db->insert_batch('location_data_created', $location);
                    $this->db->insert_batch('history', $history);
                }
            }
        }

        $this->response($response, 200);
    }

    private function getConnote($data){
        return array(
            'connote_id' => isset($data['connote_id']) ? $data['connote_id'] : '',
            'connote_number' => $data['connote_number'],
            'connote_sender_name' => $data['connote_sender_name'],
            'connote_sender_phone' => $data['connote_sender_phone'],
            'connote_sender_email' => $data['connote_sender_email'],
            'connote_sender_address' => $data['connote_sender_address'],
            'connote_sender_zipcode' => $data['connote_sender_zipcode'],
            'connote_receiver_name' => $data['connote_receiver_name'],
            'connote_receiver_phone' => $data['connote_receiver_phone'],
            'connote_receiver_email' => $data['connote_receiver_email'],
            'connote_receiver_address' => $data['connote_receiver_address'],
            'connote_receiver_address_detail' => $data['connote_receiver_address_detail'],
            'connote_receiver_zipcode' => $data['connote_receiver_zipcode'],
            'connote_service' => $data['connote_service'],
            'connote_service_price' => $data['connote_service_price'],
            'connote_amount' => $data['connote_amount'],
            'connote_code' => $data['connote_code'],
            'connote_booking_code' => $data['connote_booking_code'],
            'connote_order' => $data['connote_order'],
            'connote_state' => $data['connote_state'],
            'connote_state_id' => $data['connote_state_id'],
            'zone_code_from' => $data['zone_code_from'],
            'zone_code_to' => $data['zone_code_to'],
            'surcharge_amount' => $data['surcharge_amount'],
            'transaction_id' => $data['transaction_id'],
            'actual_weight' => $data['actual_weight'],
            'volume_weight' => $data['volume_weight'],
            'chargeable_weight' => $data['chargeable_weight'],
            'created_by' => $data['created_by'],
            'created_at' => $data['created_at'],
            'updated_at' => $data['updated_at'],
            'organization_id' => $data['organization_id'],
            'location_id' => $data['location_id'],
            'connote_total_package' => $data['connote_total_package'],
            'connote_surcharge_amount' => $data['connote_surcharge_amount'],
            'connote_sla_day' => $data['connote_sla_day'],
            'location_name' => $data['location_name'],
            'location_type' => $data['location_type'],
            'source_tariff_db' => $data['source_tariff_db'],
            'id_source_tariff' => $data['id_source_tariff'],
            // 'pod' => $data['pod'],
            'is_locked' => $data['is_locked'],
            // 'tariff_formula_data' => $data['tariff_formula_data'],
            'formula_name' => $data['formula_name'],
            'create_from' => $data['create_from'],
            'bags' => isset($data['bags']) ? $data['bags'] : null,
            'connote_sla_date' => isset($data['connote_sla_date']) ? $data['connote_sla_date'] : null,
            'total_discount' => isset($data['total_discount']) ? $data['total_discount'] : null,
            'connote_code_' => isset($data['connote_code_']) ? $data['connote_code_'] : $data['connote_code'],
        );
    }

    private function getCustomeField($field, $connote_id){
        return array(
            'connote_id' => $connote_id,
            'id_pelanggan_korporat' => $field['id_pelanggan_korporat'],
            'cn23' => $field['cn23'],
            'pph' => isset($field['pph']) ? $field['pph'] : NULL,
            'NONPPN' => isset($field['NONPPN']) ? $field['NONPPN'] : NULL,
            'statusRetur' => isset($field['statusRetur']) ? $field['statusRetur'] : NULL,
            'ppn' => isset($field['ppn']) ? $field['ppn'] : NULL,
            'bmtps' => isset($field['bmtps']) ? $field['bmtps'] : NULL,
            'bm' => isset($field['bm']) ? $field['bm'] : NULL,
            'COD' => isset($field['COD']) ? $field['COD'] : NULL,
            'cod_value' => isset($field['cod_value']) ? $field['cod_value'] : NULL,
            'fee_value' => isset($field['fee_value']) ? $field['fee_value'] : NULL,
            'total_cod' => isset($field['total_cod']) ? $field['total_cod'] : NULL,
            'lumpsum_connote_amount' => isset($field['lumpsum_connote_amount']) ? $field['lumpsum_connote_amount'] : NULL,
            'expired_pks' => isset($field['expired_pks']) ? $field['expired_pks'] : NULL,
            'minimumweight' => isset($field['minimumweight']) ? $field['minimumweight'] : NULL,
            'pks_no' => isset($field['pks_no']) ? $field['pks_no'] : NULL,
            'rekening_no' => isset($field['rekening_no']) ? $field['rekening_no'] : NULL,
            'npwp_number' => isset($field['npwp_number']) ? $field['npwp_number'] : NULL,
            'tariff_field' => isset($field['tariff_field']) ? $field['tariff_field'] : NULL,
            'Jenis_Barang' => isset($field['Jenis_Barang']) ? $field['Jenis_Barang'] : NULL,
            'ref_no' => isset($field['ref_no']) ? $field['ref_no'] : NULL,
            'instruksi_pengiriman' => isset($field['instruksi_pengiriman']) ? $field['instruksi_pengiriman'] : NULL,
            'idKorporatConnote' => isset($field['idKorporatConnote']) ? $field['idKorporatConnote'] : NULL,
            'idUserSAP' => isset($field['idUserSAP']) ? $field['idUserSAP'] : NULL,
            'nopen' => isset($field['nopen']) ? $field['nopen'] : NULL,
            'nokprk' => isset($field['nokprk']) ? $field['nokprk'] : NULL,
            'regional' => isset($field['regional']) ? $field['regional'] : NULL,
            'destination_reg' => isset($field['destination_reg']) ? $field['destination_reg'] : NULL,
            'destination_kprk' => isset($field['destination_kprk']) ? $field['destination_kprk'] : NULL,
            'destination_nopen' => isset($field['destination_nopen']) ? $field['destination_nopen'] : NULL,
            'destination_reg_new' => isset($field['destination_reg_new']) ? $field['destination_reg_new'] : NULL,
            'location_id' => isset($field['location_id']) ? $field['location_id'] : NULL,
            'location_name' => isset($field['location_name']) ? $field['location_name'] : NULL,
            'final_swp' => isset($field['final_swp']) ? $field['final_swp'] : NULL,
            'virtual_account' => isset($field['virtual_account']) ? $field['virtual_account'] : NULL,
            'user' => isset($field['history_tracking']) ? $field['history_tracking']['user']['username'] : NULL,
            'fullname' => isset($field['history_tracking']) ? $field['history_tracking']['user']['full_name'] : NULL
        );
    }

    public function push_post(){
        $response['status'] = false;
        $response['message']['global'] = "Internal server error";

        $data = $this->post();

        $connote = $this->getConnote($data['connote']);
        $location_data = array(
            'connote_id' => $connote['connote_id'],
            'location_id' => isset($data['location_id']) ? $data['location_id'] : null,
            'location_name' => $connote['location_name'],
            'location_parent_id' => null,
            'location_type_id' => null,
            'location_code' => isset($data['origin_data']['zone_code']) ? $data['origin_data']['zone_code'] : null,
            'location_phone' => null,
            'location_address' => isset($data['origin_data']['customer_address' ]) ? $data['origin_data']['customer_address'] : null,
            'organization_id' => isset($data['origin_data']['organization_id' ]) ? $data['origin_data']['organization_id'] : null,
            'created_at' => isset($data['created_at']) ? $data['created_at'] : null,
            'updated_at' => isset($data['updated_at']) ? $data['updated_at'] : null,
            'created_by' => $connote['created_by'],
            'is_deleted' => 0,
            'lat' => null,
            'lon' => null,
            'location_pickup_id' => null,
            'location_type' => $connote['location_type'],
            'location_code_mile' => null,
            'attributes' => null,
            'custom_field' => null
        );
        $custome_field = array(
            'connote_id' => $connote['connote_id'],
            'id_pelanggan_korporat' => isset($data['custom_field']['ID Pelanggan Korporat']) ? $data['custom_field']['ID Pelanggan Korporat'] : null,
            'cn23' => 0,
            'pph' => null,
            'NONPPN' => null,
            'COD' => isset($data['custom_field']['COD']) ? $data['custom_field']['COD'] : NULL,
            'cod_value' => isset($data['custom_field']['cod_value']) ? $data['custom_field']['cod_value'] : NULL,
            'fee_value' => isset($data['custom_field']['fee_value']) ? $data['custom_field']['fee_value'] : NULL,
            'total_cod' => isset($data['custom_field']['total_cod']) ? $data['custom_field']['total_cod'] : NULL,
            'lumpsum_connote_amount' => isset($data['custom_field']['lumpsum_connote_amount']) ? $data['custom_field']['lumpsum_connote_amount'] : NULL,
            'expired_pks' => isset($data['custom_field']['expired_pks']) ? $data['custom_field']['expired_pks'] : NULL,
            'minimumweight' => isset($data['custom_field']['minimumweight']) ? $data['custom_field']['minimumweight'] : NULL,
            'pks_no' => isset($data['custom_field']['pks_no']) ? $data['custom_field']['pks_no'] : NULL,
            'rekening_no' => isset($data['custom_field']['rekening_no']) ? $data['custom_field']['rekening_no'] : NULL,
            'npwp_number' => isset($data['custom_field']['npwp_number']) ? $data['custom_field']['npwp_number'] : NULL,
            'tariff_field' => isset($data['custom_field']['tariff_field']) ? $data['custom_field']['tariff_field'] : NULL,
            'Jenis_Barang' => isset($data['custom_field']['Jenis_Barang']) ? $data['custom_field']['Jenis_Barang'] : NULL,
            'ref_no' => isset($data['custom_field']['ref_no']) ? $data['custom_field']['ref_no'] : NULL,
            'instruksi_pengiriman' => isset($data['custom_field']['instruksi_pengiriman']) ? $data['custom_field']['instruksi_pengiriman'] : NULL,
            'location_name' => $connote['location_name'],
            'location_id' => isset($data['location_id']) ? $data['location_id'] : null,
            'nopen' => isset($data['origin_data']['zone_code']) ? $data['origin_data']['zone_code'] : null,
            'user' => isset($data['currentLocation']['username']) ? $data['currentLocation']['username'] : null,
            'fullname' => isset($data['currentLocation']['full_name']) ? $data['currentLocation']['full_name'] : null,
            'nokprk' => isset($data['origin_data']['zone_code']) ? $data['origin_data']['zone_code'] : null,
            'regional' => $this->model_history->getReg($data['origin_data'])
        );
        $history = array();

        if(isset($data['connote']['history'])){
            foreach($data['connote']['history'] as $key){
                $history[] = array(
                    'connote_code' => $connote['connote_code'],
                    'created_at' => $key['date'],
                    'updated_at' => $key['date'],
                    'content' => $key['content'],
                    'action' => $key['action'],
                    'id' => null,
                    'date' => $key['date'],
                    'connote_state' => $key['state'],
                    'location_name' => isset($key['user']['location_name']) ? $key['user']['location_name'] : null,
                    'username' => isset($key['user']['username']) ? $key['user']['username'] : null,
                    'is_hide' => 0,
                    'coordinate' => $key['coordinate']
                );
            }
        }

        //checking the existing data 
        $isExist = $this->model_history->checkExistingData($connote['connote_id']);
        if($isExist){
            //only update history by delete first
            $this->db->delete('history', array('connote_code' => $connote['connote_code']));
            $this->db->insert_batch('history', $history);
            if($this->db->affected_rows() > 0){
                $response['status'] = true;
                $response['message']['global'] = "".count($history)." data history updated!";
            }else{
                $response['message']['global'] = "Update failed";
            }
        }else{
            $this->db->insert('connote', $connote);
            $this->db->insert('connote_customfield', $custome_field);
            $this->db->insert('location_data_created', $location_data);
            $this->db->insert_batch('history', $history);

            if($this->db->affected_rows() > 0){
                $response['status'] = true;
                $response['message']['global'] = "Insert Success!";
            }else{
                $response['message']['global'] = "Insert failed";
            }
        }

        $this->response($response, 200);
    }
}

?>