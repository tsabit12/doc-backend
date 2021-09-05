<?php

class Model_reportdetail extends CI_Model {
    public function getProduksi($params){
        $result['success'] = false;

        $this->query_produksi($params);
        
        $q = $this->db->get();

        // print_r($q);
        if($q->num_rows() > 0){
            $result['success'] = true;
            $result['data'] = $q->result_array();
        }

        return $result;
    }

    private function query_produksi($body){
        $reg    = $body['regional'];
        $kprk   = $body['kprk'];
        $start  = $body['startdate'];
        $end    = $body['enddate'];

        $whereValues = array();

        $this->db->select("c.connote_code, c.connote_service as service,cc.COD, c.connote_sender_name as pengirim, cc.user, 
                            cc.fullname as nama_pengguna,c.connote_service_price as ongkir,  cc.PPN , cc.pph ,cc.NONPPN ,
                            c.connote_surcharge_amount as asuransi, c.connote_amount as total , cc.cod_value, cc.fee_value,cc.total_cod,
                            cc.nopen, cc.regional , ldc.location_code , ldc.location_type ");
        $this->db->from('connote c');
        $this->db->join('connote_customfield cc','c.connote_id = cc.connote_id','LEFT');
        $this->db->join('location_data_created ldc','c.connote_id = ldc.connote_id','LEFT');

        if($reg == '00'){ //alll regional
            
        }else{
            if($kprk == '00'){ //all kprk
                $whereValues['cc.regional'] = $reg;
            }else{
                $whereValues['cc.nopen'] = $kprk;
            }
        }

        $this->db->where($whereValues);
        $this->db->where("date_format(c.created_at, '%Y-%m-%d') between '$start' and '$end'");

        $this->db->order_by('c.connote_id', 'ASC');
    }


    // private function all($params){
        
    //     return $q;
    // }

    // private function regional($regional,$start, $end){
    //     $this->db->select("c.connote_code, c.connote_service as service,cc.COD, c.connote_sender_name as pengirim, cc.user, 
    //     cc.fullname as nama_pengguna,c.connote_service_price as ongkir,  cc.PPN , cc.pph ,cc.NONPPN ,
    //     c.connote_surcharge_amount as asuransi, c.connote_amount as total , cc.cod_value, cc.fee_value,cc.total_cod,
    //     cc.nopen, cc.regional , ldc.location_code , ldc.location_type ");
    //     $this->db->from('connote c');
    //     $this->db->join('connote_customfield cc','c.connote_id = cc.connote_id','LEFT');
    //     $this->db->join('location_data_created ldc','c.connote_id = ldc.connote_id','LEFT');
    //     $this->db->where('cc.regional', $regional);
    //     $this->db->where("date_format(c.created_at, '%Y-%m-%d') between '$start' and '$end'");
    //     $this->db->order_by('c.connote_id', 'ASC');
    //     $q = $this->db->get()->result_array();
    //     return $q;
    // }

    // private function kprk($regional, $kprk,$start, $end){
    //     $this->db->select("c.connote_code, c.connote_service as service,cc.COD, c.connote_sender_name as pengirim, cc.user, 
    //     cc.fullname as nama_pengguna,c.connote_service_price as ongkir,  cc.PPN , cc.pph ,cc.NONPPN ,
    //     c.connote_surcharge_amount as asuransi, c.connote_amount as total , cc.cod_value, cc.fee_value,cc.total_cod,
    //     cc.nopen, cc.regional , ldc.location_code , ldc.location_type ");
    //     $this->db->from('connote c');
    //     $this->db->join('connote_customfield cc','c.connote_id = cc.connote_id','LEFT');
    //     $this->db->join('location_data_created ldc','c.connote_id = ldc.connote_id','LEFT');
    //     $this->db->where('cc.regional', $regional);
    //     $this->db->where('cc.nopen', $kprk);
    //     $this->db->where("date_format(c.created_at, '%Y-%m-%d') between '$start' and '$end'");
    //     $this->db->order_by('c.connote_id', 'ASC');
    //     $q = $this->db->get()->result_array();
    //     return $q;
    // }
}

?>