<?php
class Model_history extends CI_Model {
    public function getResi($params){
        $date = $params['date'];
        $rangeawal = $params['rangeawal'];
        $rangeakhir = $params['rangeakhir'];
        $type       = $params['type'];

        if($type === 'onupdate'){
            $result = array();
            $this->db->select('connote_code');
            $this->db->from('v_pendingconnote');

            $q = $this->db->get();
            if($q->num_rows() > 0){
                $data = $q->result_array();
                foreach($data as $key){
                    $result[] = $key['connote_code'];
                }
            }

            return $result;
        }else{
            for ($x = $rangeawal; $x <= $rangeakhir; $x++) {
                $invID = str_pad($x, 7, '0', STR_PAD_LEFT);
                $resi[]   = 'P'.$date.''.$invID;
                $data = $resi;
            }
    
            return $data;
        }
    }

    public function getReg($origin){
        $result = null;
        if(isset($origin['zone_code'])){
            $kprk = $origin['zone_code'];
            $this->db->select('regionid');
            // select regionid from office o
            $this->db->from('office');
            $this->db->where('officeid', $kprk);
            $q = $this->db->get();
            if($q->num_rows() > 0){
                $data = $q->row_array();
                $result = $data['regionid'];
            }
        }

        return $result;
    }

    public function getRegByOffice($office){
        $result = 0;
        if($office){
            $this->db->select('regionid');
            // select regionid from office o
            $this->db->from('office');
            $this->db->where('officeid', $office);
            $q = $this->db->get();
            if($q->num_rows() > 0){
                $data = $q->row_array();
                $result = $data['regionid'];
            }
        }

        return $result;
    }

    public function checkExistingData($connote_id){
        $this->db->from('connote');
        $this->db->where('connote_id', $connote_id);

        $q = $this->db->get();
        if($q->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
}
?>