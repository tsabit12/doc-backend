<?php

class Model_jatuhtempo extends CI_Model {
    public function get($params){
        $result['exist'] = false;

        $reg = $params['regional'];
        $kprk = $params['kprk'];
        $startdate = $params['startdate'];
        $enddate = $params['enddate'];
        
        $this->db->select('types, regionid as region, location_code as nopend, connote_service as service, sum(total) as jumlah');
        $this->db->from('summary');
        $this->db->group_by(array('types', 'regionid', 'location_code', 'connote_service'));
        
        $this->db->where('periode >=', $startdate);
        $this->db->where('periode <=', $enddate);

        // if($reg != '00'){ //not nasional 
        //     if($kprk == '00'){ //current regional with all kprk
        //         $this->db->where('regionid', $reg);
        //     }else{
        //         $this->db->where('location_code', $kprk);
        //     }
        // }

        $q = $this->db->get();
        print_r($q->row_array());
        print_r($q);
        if($q->num_rows() > 0){
            $result['exist'] = true;
            //$result['result'] = $q;
        }

        return $result;
    }
}

?>