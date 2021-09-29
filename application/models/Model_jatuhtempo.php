<?php

class Model_jatuhtempo extends CI_Model {
    public function get($params){
        $result['exist'] = false;

        $reg = $params['regional'];
        $kprk = $params['kprk'];
        $startdate = $params['startdate'];
        $enddate = $params['enddate'];
        
        $this->db->select('types, region, nopend, service, sum(total) as jumlah');
        $this->db->from('summary');
        $this->db->group_by(array('types', 'region', 'nopend', 'service'));
        
        $this->db->where('periode >=', $startdate);
        $this->db->where('periode <=', $enddate);

        if($reg != '00'){ //not nasional 
            if($kprk == '00'){ //current regional with all kprk
                $this->db->where('region', $reg);
            }else{
                $this->db->where('nopend', $kprk);
            }
        }

        $q = $this->db->get();
        if($q->num_rows() > 0){
            $result['exist'] = true;
            $result['result'] = $q->result_array();
        }

        return $result;
    }
}

?>