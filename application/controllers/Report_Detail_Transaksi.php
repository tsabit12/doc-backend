<?php
require(APPPATH.'/libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;

class Report_Detail_Transaksi extends REST_Controller{
    public function index_get(){
        $response['status'] = false; //default status
        $response['message']['global'] = 'Data tidak ditemukan'; //default message is object 

        $this->db->select("connote_code as connote, connote_service as layanan, connote_sender_name as nama_pengirim,
        cc.full_name as nama_petugas, c.location_name as nama_kantor, cc.username as user_petugas, 
        c.connote_service_price as Ongkir ,c.connote_surcharge_amount as ppn, c.connote_amount as total, 
        c.zone_code_from as asal_kantor_kirim,cc.regional , c.actual_weight as berat,
        c.location_type as jenis_kantor , 
        case when cc.ID_Pelanggan_Korporat is null then 'Ritel' else cc.ID_Pelanggan_Korporat end as jenis_cus");
        $this->db->from('connote c');
        $this->db->join('connote_customfield cc','c.connote_id = cc.connote_id','LEFT');

        $q = $this->db->get();
        if($q->num_rows() > 0){ //cek if data is extis
            //then return status true
            $response['status'] = true;
            $response['message']['global'] = new StdClass(); //must in object, if no message create empty object
            $response['result']  = $q->result_array();
        }
        
        $this->response($response, 200);

    }
}
