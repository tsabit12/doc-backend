<?php
require(APPPATH.'/libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;

class Lacak extends REST_Controller{

    public function insert_get(){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://apiexpos.mile.app/public/v1/connote/P2107200000146');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'X-Api-Key: 04e5185fa9402cf4c06faac5dee754d40452f2c8';
        $headers[] = 'Accept: application/';
        $headers[] = 'Content-Type: application/';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $data = json_decode($result, true);
        $insertconnote = array(
            'connote_id' =>$data['connote_id'],
            'connote_number' =>$data['connote_number'],
            'connote_sender_name' =>$data['connote_sender_name'],
            'connote_sender_phone' =>$data['connote_sender_phone'], 
            'connote_sender_email' =>$data['connote_sender_email'], 
            'connote_sender_address' =>$data['connote_sender_address'],
            'connote_sender_zipcode' =>$data['connote_sender_zipcode'],
            'connote_receiver_name' =>$data['connote_receiver_name'],
            'connote_receiver_phone' =>$data['connote_receiver_phone'],
            'connote_receiver_email' =>$data['connote_receiver_email'],
            'connote_receiver_address' =>$data['connote_receiver_address'],
            'connote_receiver_address_detail' =>$data['connote_receiver_address_detail'],
            'connote_receiver_zipcode' =>$data['connote_receiver_zipcode'],
            'connote_service' =>$data['connote_service'],
            'connote_service_price' =>$data['connote_service_price'],
            'connote_amount' =>$data['connote_amount'],
            'connote_code' =>$data['connote_code'],
            'connote_booking_code' =>$data['connote_booking_code'],
            'connote_order' =>$data['connote_order'],
            'connote_state' =>$data['connote_state'],
            'connote_state_id' =>$data['connote_state_id'],
            'zone_code_from' =>$data['zone_code_from'],
            'zone_code_to' =>$data['zone_code_to'],
            'surcharge_amount' =>$data['surcharge_amount'],
            'transaction_id' =>$data['transaction_id'],
            'actual_weight'=>$data['actual_weight'],
            'volume_weight'=>$data['volume_weight'],
            'chargeable_weight'=>$data['chargeable_weight'],
            'created_by'=>$data['created_by'],
            'created_at'=>$data['created_at'],
            'updated_at'=>$data['updated_at'],
            'organization_id'=>$data['organization_id'],
            'location_id'=>$data['location_id'],
            'connote_total_package' =>$data['connote_total_package'],
            'connote_surcharge_amount'=>$data['connote_surcharge_amount'],
            'location_name'=>$data['location_name'],
            'location_type'=>$data['location_type'],
            'source_tariff_db'=>$data['source_tariff_db'],
            'id_source_tariff' =>$data['id_source_tariff'],
            'is_locked'=>$data['is_locked'],
            'formula_name'=>$data['formula_name'],
            'create_from'=>$data['create_from'],
            'bags'=>$data['bags'],
            'connote_sla_date'=>$data['connote_sla_date'],
            'total_discount'=>$data['total_discount'],
            'connote_code_' =>$data['connote_code_']
        );

        $insertPOD =array(
            'connote_id' =>$data['connote_id'],
            'photo' =>$data['pod']['photo'],
            'signature' =>$data['pod']['signature'],
            'timeReceive' =>$data['pod']['timeReceive'],
            'receiver' =>$data['pod']['receiver'],
            'coordinate' =>$data['pod']['coordinate'],
        );

        $this->db->insert('connote', $insertconnote); 
        $this->db->insert('pod', $insertPOD); 
        
        $zone = $data['zone_destination_data'];
        foreach ($zone as $key) {
            $zona[] = array(
                'connote_id' => $data['connote_id'],
                'zone_name' =>$key['zone_name'],
                'zode_code' =>$key['zone_code'],
                'zone_type_code' =>$key['zone_type_code'],
                // 'cache'  =>$key['cache'],
            );
            
        }
        $this->db->insert_batch('zone_destination_data', $zona);

        $connote_customfield = $this->connote_customfield_get();
        $this->db->insert('connote_customfield', $connote_customfield); 

        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        return FALSE;

        
    }

    public function getData_get()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://apiexpos.mile.app/public/v1/connote/P2107200000146');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'X-Api-Key: 04e5185fa9402cf4c06faac5dee754d40452f2c8';
        $headers[] = 'Accept: application/';
        $headers[] = 'Content-Type: application/';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $data = json_decode($result, true);
        // $custom = json_decode($data['custom_field'], true);
        return $data;
        // print_r($data);
    }

    private function connote_customfield_get(){
        $data = $this->getData_get();
        $field = $data['connote_customfield'];
        $connote_customfield = array (
            'connote_id' =>$data['connote_id'],
            'statusRetur' =>$field['statusRetur'],
            'COD' =>$field['COD'],
            'ID_Pelanggan_Korporat' =>$field['ID Pelanggan Korporat'],
            'cod_value' =>$field['cod_value'],
            'fee_value' =>$field['fee_value'],
            'total_cod' =>$field['total_cod'],
            'lumpsum_connote_amount' =>$field['lumpsum_connote_amount'],
            'expired_pks' =>$field['expired_pks'],
            'minimumweight' =>$field['minimumweight'],
            'pks_no' =>$field['pks_no'],
            'rekening_no' =>$field['rekening_no'],
            'npwp_number' =>$field['npwp_number'],
            'tariff_field' =>$field['tariff_field'],
            'Jenis_Barang' =>$field['Jenis_Barang'],
            'ref_no' =>$field['ref_no'],
            'instruksi_pengiriman' =>$field['instruksi_pengiriman'],
            'idUserSAP' =>$field['idUserSAP'],
            'idKorporatConnote'=>$field['idKorporatConnote'],
            'billingStatus' =>$field['billingStatus'],
            'nopen'=>$field['nopen'],
            'nokprk' =>$field['nokprk'],
            'regional' =>$field['regional'],
            'destination_reg' =>$field['destination_reg'],
            'destination_kprk' =>$field['destination_kprk'],
            'destination_nopen' =>$field['destination_nopen'],
            'location_id' =>$field['location_id'],
            'location_name' =>$field['location_name'],
            'final_swp' =>$field['final_swp'],
            'virtual_account' =>$field['virtual_account'],
            'cod_collected'=>$field['cod_collected'],
            'timeArrived'=>$field['timeArrived'],
            'timePredictionArrived'=>$field['timePredictionArrived'],
            'destination_location'=>$field['destination_location'],
            'timeLate' =>$field['timeLate'],
            'is_over_sla' =>$field['is_over_sla'],
            'sla_duration' =>$field['sla_duration'],
            'sla_duration_minutes' =>$field['sla_duration_minutes'],
            'C_is_Late' =>$field['C_is_Late'],
            'C_Delivery'=>$field['C_Delivery'],
            'deliverySuccessTime' =>$field['deliverySuccessTime'],
            'first_attempt_time' =>$field['first_attempt_time'],
            'username' =>$field['history_tracking']['user']['username'],
            'full_name'=>$field['history_tracking']['user']['full_name'],
        );
        return $connote_customfield;
    }
}