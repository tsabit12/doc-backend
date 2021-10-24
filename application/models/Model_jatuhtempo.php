<?php

class Model_jatuhtempo extends CI_Model {
    public function get($params){
        $result['exist'] = false;

        $reg = $params['regional'];
        $kprk = $params['kprk'];
        $date = date('Y-m-d');
        
        $this->db->select('types, regionid as region, location_code as nopend, connote_service as service, sum(total) as jumlah, hari_oversla');
        $this->db->from('summarybaru');
        $this->db->group_by(array('types', 'regionid', 'location_code', 'connote_service', 'hari_oversla'));
        
        $this->db->where('tgl_generate', $date);

        if($reg != '00'){ //not nasional 
            if($kprk == '00'){ //current regional with all kprk
                $this->db->where('regionid', $reg);
            }else{
                $this->db->where('location_code', $kprk);
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