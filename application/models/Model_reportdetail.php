<?php

class Model_reportdetail extends CI_Model {
    public function getProduksi($params){
        $state  = $params['status'];
        $result['success'] = false;

        if ($state == '00') {
            $this->query_produksi($params);
        } elseif ($state == '1') {
            $this->query_menginap($params);
        }elseif ($state == '2') {
            $this->query_jatuhtempo($params);
        }elseif($state == '3') {
            $this->query_oversla($params);
        }    
        
        
        $q = $this->db->get();

        // print_r($params);
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
                            cc.fullname as nama_pengguna,c.chargeable_weight as berat, c.connote_service_price as ongkir, cc.pph ,cc.NONPPN ,
                            c.connote_surcharge_amount as asuransi, c.connote_amount as total , cc.cod_value, cc.fee_value,cc.total_cod,
                            cc.nokprk as nopen, cc.regional , ldc.location_code , ldc.location_type ");
        $this->db->select("COALESCE(cc.PPN, 0) AS ppn, date_format(c.created_at, '%Y-%m-%d') as created, d.action as status");
        $this->db->select("date_format(c.connote_sla_date, '%Y-%m-%d') as sla_date, date_format(now(), '%Y-%m-%d') as currentdate");
        $this->db->select("date_format(d.updated_at, '%Y-%m-%d') as updated_at");
        $this->db->from('connote c');
        $this->db->join('connote_customfield cc','c.connote_id = cc.connote_id','LEFT');
        $this->db->join('location_data_created ldc','c.connote_id = ldc.connote_id','LEFT');
        $this->db->join('lasthistory d', 'c.connote_code = d.connote_code');

        if($reg == '00'){ //alll regional
            
        }else{
            if($kprk == '00'){ //all kprk
                $whereValues['cc.regional'] = $reg;
            }else{
                $whereValues['cc.nokprk '] = $kprk;
            }
        }

        $this->db->where($whereValues);
        $this->db->where("date_format(c.created_at, '%Y-%m-%d') between '$start' and '$end'");

        $this->db->order_by('c.created_at', 'DESC');
    }

    private function query_menginap($body){
        $reg    = $body['regional'];
        $kprk   = $body['kprk'];
        $start  = $body['startdate'];
        $end    = $body['enddate'];

        $whereValues = array();

        $this->db->select("c.connote_code, c.connote_service as service,cc.COD, c.connote_sender_name as pengirim, cc.user, 
                            cc.fullname as nama_pengguna,c.chargeable_weight as berat, c.connote_service_price as ongkir, cc.pph ,cc.NONPPN ,
                            c.connote_surcharge_amount as asuransi, c.connote_amount as total , cc.cod_value, cc.fee_value,cc.total_cod,
                            cc.nokprk as nopen, cc.regional , ldc.location_code , ldc.location_type ");
        $this->db->select("COALESCE(cc.PPN, 0) AS ppn, date_format(c.created_at, '%Y-%m-%d') as created, c.connote_state as status");
        $this->db->from('connote c');
        $this->db->join('connote_customfield cc','c.connote_id = cc.connote_id','LEFT');
        $this->db->join('location_data_created ldc','c.connote_id = ldc.connote_id','LEFT');

        if($reg == '00'){ //alll regional
            
        }else{
            if($kprk == '00'){ //all kprk
                $whereValues['cc.regional'] = $reg;
            }else{
                $whereValues['cc.nokprk '] = $kprk;
            }
        }

        $this->db->where($whereValues);
        $this->db->where("date_format(c.created_at, '%Y-%m-%d') between '$start' and '$end'");
        $this->db->where("c.connote_state != 'R7'" );

        $this->db->order_by('c.connote_id', 'ASC');
    }

    private function query_jatuhtempo($body){
        $reg    = $body['regional'];
        $kprk   = $body['kprk'];
        $start  = $body['startdate'];
        $end    = $body['enddate'];

        $whereValues = array();

        $this->db->select("c.connote_code, c.connote_service as service,cc.COD, c.connote_sender_name as pengirim, cc.user, 
                            cc.fullname as nama_pengguna,c.chargeable_weight as berat, c.connote_service_price as ongkir, cc.pph ,cc.NONPPN ,
                            c.connote_surcharge_amount as asuransi, c.connote_amount as total , cc.cod_value, cc.fee_value,cc.total_cod,
                            cc.nokprk as nopen, cc.regional , ldc.location_code , ldc.location_type ");
        $this->db->select("COALESCE(cc.PPN, 0) AS ppn, date_format(c.created_at, '%Y-%m-%d') as created, c.connote_state as status");
        $this->db->from('connote c');
        $this->db->join('connote_customfield cc','c.connote_id = cc.connote_id','LEFT');
        $this->db->join('location_data_created ldc','c.connote_id = ldc.connote_id','LEFT');

        if($reg == '00'){ //alll regional
            
        }else{
            if($kprk == '00'){ //all kprk
                $whereValues['cc.regional'] = $reg;
            }else{
                $whereValues['cc.nokprk '] = $kprk;
            }
        }

        $in     = array('DELIVERED','CANCEL');        

        $this->db->where($whereValues);
        $this->db->where("date_format(c.created_at, '%Y-%m-%d') between '$start' and '$end'");
        $this->db->where("date_format(c.connote_sla_date, '%Y-%m-%d') = date_format(now(), '%Y-%m-%d')");
        $this->db->where("c.connote_state = 'PAID'");
        $this->db->where_not_in('c.connote_state', $in);

        $this->db->order_by('c.connote_id', 'ASC');
    }

    private function query_oversla($body){
        $reg    = $body['regional'];
        $kprk   = $body['kprk'];
        $start  = $body['startdate'];
        $end    = $body['enddate'];

        $whereValues = array();

        $this->db->select("c.connote_code, c.connote_service as service,cc.COD, c.connote_sender_name as pengirim, cc.user, 
                            cc.fullname as nama_pengguna,c.chargeable_weight as berat, c.connote_service_price as ongkir, cc.pph ,cc.NONPPN ,
                            c.connote_surcharge_amount as asuransi, c.connote_amount as total , cc.cod_value, cc.fee_value,cc.total_cod,
                            cc.nokprk as nopen, cc.regional , ldc.location_code , ldc.location_type ");
        $this->db->select("COALESCE(cc.PPN, 0) AS ppn, date_format(c.created_at, '%Y-%m-%d') as created, c.connote_state as status");
        $this->db->from('connote c');
        $this->db->join('connote_customfield cc','c.connote_id = cc.connote_id','LEFT');
        $this->db->join('location_data_created ldc','c.connote_id = ldc.connote_id','LEFT');

        if($reg == '00'){ //alll regional
            
        }else{
            if($kprk == '00'){ //all kprk
                $whereValues['cc.regional'] = $reg;
            }else{
                $whereValues['cc.nokprk '] = $kprk;
            }
        }

        $in     = array('DELIVERED','CANCEL');

        $this->db->where($whereValues);
        $this->db->where("date_format(c.created_at, '%Y-%m-%d') between '$start' and '$end'");
        $this->db->where("date_format(c.connote_sla_date, '%Y-%m-%d') > date_format(now(), '%Y-%m-%d')");
        $this->db->where_not_in('c.connote_state', $in);

        $this->db->order_by('c.connote_id', 'ASC');
    }

}

?>