<?php
class Model_history extends CI_Model {
    public function getResi(){
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

        $date   = date('ymd');
        for ($x = 1; $x <= 1300; $x++) {
            $invID = str_pad($x, 7, '0', STR_PAD_LEFT);
            $resi[]   = 'P'.$date.''.$invID;
            $data = $resi;
        }

        return $data;
    }
}
?>