<?php
class Model_menu extends CI_Model {
     public function get($params){
          $result['status'] = false;

          $this->db->from('menus');
          $this->db->where('roleid', $params['roleid']);
          $this->db->order_by('nomor', 'asc');

          $q = $this->db->get();
          if($q->num_rows() > 0){
               $result['status'] = true;
               $result['menu'] = $q->result_array();
          }

          return $result;
     }
}

?>