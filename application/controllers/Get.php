<?php
require(APPPATH.'/libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;

ini_set('max_execution_time', 0); 
ini_set('memory_limit','2048M'); 


class Get extends REST_Controller{

    public function index_get(){
        $connote    = $this->connote_get();
        $custom     = $this->customfield_get();
        $location   = $this->location_get();

        $this->db->insert_batch('connote', $connote);
        $this->db->insert_batch('connote_customfield', $custom);
        $this->db->insert_batch('location_data_created', $location);
        if ($this->db->affected_rows() > 0){
            $response['status'] = true;
            $response['message']['global'] = 'Simpan Data Sukses'; //must in object, if no message create empty object
            $response['result']  = '00';
        }
    }

    public function customfield_get(){
        $noresi     = $this->noresi();
        foreach ($noresi as $key) {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://apiexpos.mile.app/public/v1/connote/'.$key);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


            $headers = array();
            $headers[] = 'X-Api-Key: 04e5185fa9402cf4c06faac5dee754d40452f2c8';
            $headers[] = 'Accept: application/';
            $headers[] = 'Content-Type: application/';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            $data = json_decode($result, true);
            $field = $data['connote_customfield'];
            $loc = $data['location_data_created'];
            $connote_customfield[] = array (
                    'connote_id' => $data['connote_id'],
                    'id_pelanggan_korporat' => $field['id_pelanggan_korporat'],
                    'cn23' => $field['cn23'],
                    'pph' => $field['pph'],
                    'NONPPN' => $field['NONPPN'],
                    'statusRetur' => $field['statusRetur'],
                    'ppn' => $field['ppn'],
                    'bmtps' => $field['bm'],
                    'bm' => $field['bm'],
                    'COD' => $field['COD'],
                    'cod_value' => $field['cod_value'],
                    'fee_value' => $field['fee_value'],
                    'total_cod' => $field['total_cod'],
                    'lumpsum_connote_amount' => $field['lumpsum_connote_amount'],
                    'expired_pks' => $field['expired_pks'],
                    'minimumweight' => $field['minimumweight'],
                    'pks_no' => $field['pks_no'],
                    'rekening_no' => $field['rekening_no'],
                    'npwp_number' => $field['npwp_number'],
                    'tariff_field' => $field['tariff_field'],
                    'Jenis_Barang' => $field['Jenis_Barang'],
                    'ref_no' => $field['ref_no'],
                    'instruksi_pengiriman' => $field['instruksi_pengiriman'],
                    'idKorporatConnote' => $field['idKorporatConnote'],
                    'idUserSAP' => $field['idUserSAP'],
                    'nopen' => $field['nopen'],
                    'nokprk' => $field['nokprk'],
                    'regional' => $field['regional'],
                    'destination_reg' => $field['destination_reg'],
                    'destination_kprk' => $field['destination_kprk'],
                    'destination_nopen' => $field['destination_nopen'],
                    'destination_reg_new' => $field['destination_reg_new'],
                    'location_id' => $field['location_id'],
                    'location_name' => $field['location_name'],
                    'final_swp' => $field['final_swp'],
                    'virtual_account' => $field['virtual_account'],
                    'user' => $field['history_tracking']['user']['username'],
                    'fullname' => $field['history_tracking']['user']['full_name']
            );
            $connote[] = array (
                'connote_id' => $data['connote_id'],
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
                'bags' => $data['bags'],
                // 'connote_sender_custom_field' => $data['connote_sender_custom_field'],
                'connote_sla_date' => $data['connote_sla_date'],
                'total_discount' => $data['total_discount'],
                'connote_code_' => $data['connote_code_'],
            );
            $newLoc[] = array (
                'connote_id' => $data['connote_id'],
                'location_id' => $loc['location_id'],
                'location_name' => $loc['location_name'],
                'location_parent_id' => $loc['location_parent_id'],
                'location_type_id' => $loc['location_type_id'],
                'location_code' => $loc['location_code'],
                'location_phone' => $loc['location_phone'],
                'location_address' => $loc['location_address'],
                'organization_id' => $loc['organization_id'],
                'created_at' => $loc['created_at'],
                'updated_at' => $loc['updated_at'],
                'created_by' => $loc['created_by'],
                'is_deleted' => $loc['is_deleted'],
                'lat' => $loc['lat'],
                'lon' => $loc['lon'],
                'location_pickup_id' => $loc['location_pickup_id'],
                'location_type' => $loc['location_type'],
                'location_code_mile' => $loc['location_code_mile'],
                'attributes' => $loc['attributes'],
                'custom_field' => $loc['custom_field']
            );
        }

        $newData    = $connote_customfield;
        $newCon     = $connote;
        $loc        = $newLoc;
        // return $newData;
        // print_r($connote_customfield);
        $this->db->insert_batch('connote', $newCon);
        if ($this->db->affected_rows() > 0){
            $this->db->insert_batch('connote_customfield', $newData);
            if ($this->db->affected_rows() > 0) {
                $this->db->insert_batch('location_data_created', $loc);
                $response['status'] = true;
                $response['message']['global'] = 'Simpan Data Sukses'; //must in object, if no message create empty object
                $response['result']  = '00';
            }
        }
        $this->response($response, 200);
    }

    private function connote_get(){
        $noresi     = $this->noresi();
        foreach ($noresi as $key) {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://apiexpos.mile.app/public/v1/connote/'.$key);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


            $headers = array();
            $headers[] = 'X-Api-Key: 04e5185fa9402cf4c06faac5dee754d40452f2c8';
            $headers[] = 'Accept: application/';
            $headers[] = 'Content-Type: application/';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            $data = json_decode($result, true);
            $connote[] = array (
                    'connote_id' => $data['connote_id'],
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
                    'bags' => $data['bags'],
                    // 'connote_sender_custom_field' => $data['connote_sender_custom_field'],
                    'connote_sla_date' => $data['connote_sla_date'],
                    'total_discount' => $data['total_discount'],
                    'connote_code_' => $data['connote_code_'],
            );
        }
        $newData = $connote;
        return $newData;
        // $this->db->insert_batch('connote', $newData);
        // if ($this->db->affected_rows() > 0){
        //     return TRUE;
        // }
        // return FALSE;
    }

    private function location_get(){
        $noresi     = $this->noresi();
        foreach ($noresi as $key) {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://apiexpos.mile.app/public/v1/connote/'.$key);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


            $headers = array();
            $headers[] = 'X-Api-Key: 04e5185fa9402cf4c06faac5dee754d40452f2c8';
            $headers[] = 'Accept: application/';
            $headers[] = 'Content-Type: application/';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            $data = json_decode($result, true);
            $loc = $data['location_data_created'];
            $newLoc[] = array (
                    'connote_id' => $data['connote_id'],
                    'location_id' => $loc['location_id'],
                    'location_name' => $loc['location_name'],
                    'location_parent_id' => $loc['location_parent_id'],
                    'location_type_id' => $loc['location_type_id'],
                    'location_code' => $loc['location_code'],
                    'location_phone' => $loc['location_phone'],
                    'location_address' => $loc['location_address'],
                    'organization_id' => $loc['organization_id'],
                    'created_at' => $loc['created_at'],
                    'updated_at' => $loc['updated_at'],
                    'created_by' => $loc['created_by'],
                    'is_deleted' => $loc['is_deleted'],
                    'lat' => $loc['lat'],
                    'lon' => $loc['lon'],
                    'location_pickup_id' => $loc['location_pickup_id'],
                    'location_type' => $loc['location_type'],
                    'location_code_mile' => $loc['location_code_mile'],
                    'attributes' => $loc['attributes'],
                    'custom_field' => $loc['custom_field']
            );
        }
        $newData = $newLoc;
        return $newData;
        // print_r($loc);
        // $this->db->insert_batch('location_data_created', $newData);
        // if ($this->db->affected_rows() > 0){
        //     return TRUE;
        // }
        // return FALSE;
    }

    private function noresi() {
        $date   = date('ymd');
        for ($x = 1; $x <= 500; $x++) {
            $invID = str_pad($x, 7, '0', STR_PAD_LEFT);
            $resi[]   = 'P'.$date.''.$invID;
            $data = $resi;
          }
        return $data;
    }

    public function tes_get() {
        $data = array(
            array(
                    'title' => 'My title',
                    'name' => 'My Name',
                    'date' => 'My date'
            ),
            array(
                    'title' => 'Another title',
                    'name' => 'Another Name',
                    'date' => 'Another date'
            )
        );
        $this->db->insert_batch('tes', $data);
        if ($this->db->affected_rows() > 0){
            return TRUE;
        }
        return FALSE;
    }
}