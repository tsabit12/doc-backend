<?php
class Model_referensi extends CI_Model {
    public function getKprk($regional){
        $result = array();

        $this->db->select("CONCAT_WS(' - ', kprk, officename) as title, kprk as value");
        $this->db->from('office');
        $this->db->where(array(
            'regionid' => $regional,
            'officetype' => 'KPRK'
        ));
        $this->db->order_by('officename asc');

        $q = $this->db->get();
        if($q->num_rows() > 0){
            $result = $q->result_array();
        }

        return $result;

    }
}

?>