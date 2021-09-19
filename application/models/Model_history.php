<?php
class Model_history extends CI_Model {
    public function getResi($params){
        $date = $params['date'];
        $rangeawal = $params['rangeawal'];
        $rangeakhir = $params['rangeakhir'];
        // $result = array();
        // $this->db->select('connote_code');
        // $this->db->from('connote');
        // $this->db->where('connote_code is not null', null, false);
        // $this->db->where("DATE_FORMAT(created_at, '%Y%m%d') = DATE_FORMAT(NOW() , '%Y%m%d')", null, false);
        // $this->db->limit(2);

        // $q = $this->db->get();
        // if($q->num_rows() > 0){
        //     $result = $q->result_array();
        // }

        // return $result;

        //$date   = date('ymd', strtotime("-1 days"));
        for ($x = $rangeawal; $x <= $rangeakhir; $x++) {
            $invID = str_pad($x, 7, '0', STR_PAD_LEFT);
            $resi[]   = 'P'.$date.''.$invID;
            $data = $resi;
        }

        return $data;
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