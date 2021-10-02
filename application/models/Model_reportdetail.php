<?php

class Model_reportdetail extends CI_Model {
    public function getProduksi($params){
        $result['success'] = false;

        $this->query_produksi($params);
        
        $q = $this->db->get();

        // print_r($params);
        if($q->num_rows() > 0){
            $result['success'] = true;
            $result['data'] = $q->result_array();
        }

        return $result;
    }

    private function query_produksi($params){
        $reg = $params['regional'];
        $kprk = $params['kprk'];
        $startdate = $params['startdate'];
        $enddate = $params['enddate'];

        $whereValues = array();

        $this->db->select('location_region as region, location_code, connote_service, count(connote_code) as total, sum(chargeable_weight) as berat, sum(connote_service_price) as ongkir');
        $this->db->from('dashboard d');

        $this->db->group_by(array('d.location_region', 'd.location_code', 'd.connote_service'));

        $this->db->where("to_char(d.created_at, 'YYYY-MM-DD') >=", $startdate);
        $this->db->where("to_char(d.created_at, 'YYYY-MM-DD') <=", $enddate);

        if($reg != '00'){ //not nasional 
            if($kprk == '00'){ //current regional with all kprk
                $this->db->where('d.location_region', $reg);
            }else{
                $this->db->where('d.location_code', $kprk);
            }
        }
    }
}

?>