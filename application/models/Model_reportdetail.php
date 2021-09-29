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

        $this->db->select("r.regionid as region, b.location_code, c.connote_service, COUNT(c.connote_code) as total, SUM(c.chargeable_weight) as berat, SUM(c.connote_service_price) as ongkir");
        $this->db->from('connote c');
        $this->db->join('location_data_created b', 'c.connote_id = b.connote_id');
        $this->db->join('office r','b.location_code = r.kprk');

        $this->db->group_by(array('r.regionid', 'b.location_code', 'c.connote_service'));

        $this->db->where("DATE_FORMAT(c.created_at, '%Y-%m-%d') >=", $startdate);
        $this->db->where("DATE_FORMAT(c.created_at, '%Y-%m-%d') <=", $enddate);

        if($reg != '00'){ //not nasional 
            if($kprk == '00'){ //current regional with all kprk
                $this->db->where('r.regionid', $reg);
            }else{
                $this->db->where('r.location_code', $kprk);
            }
        }
    }
}

?>