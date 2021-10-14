<?php

Class Model_user extends CI_Model{
     public function get($params){
          $result['status'] = false;

          $type = $params['type'];
          if($type == 'count'){
               $data = $this->count($params);
          }else{
               $data = $this->queryuser($params);
          }

          if($data['exist']){
               $result['status'] = true;
               $result['result'] = $data['data'];
          }

          return $result;
     }

     private function queryuser($params){
          $result['exist'] = false;
          $level = $params['level'];

          $this->db->select('a.userid, a.username, a.email, b.roledescription, b.roleid, c.officeid, c.officename, a.image, a.created_at');
          $this->db->from('users a');
          $this->db->join('ref_role b', 'a.roleid = b.roleid');
          $this->db->join('office c', 'a.office = c.officeid');
          $this->db->order_by('a.created_at', 'desc');
          $this->db->limit($params['limit'], $params['offset']);

          if($level !== 'all'){
               $this->db->where('a.roleid', $level);
          }

          $q = $this->db->get();
          if($q->num_rows() > 0){
               $result['exist']    = true;
               $result['data']     = $q->result_array();
          }

          return $result;
     }

     private function count($params){
          $result['exist'] = false;
          $level = $params['level'];

          if($level === 'all'){
               $sql = $this->db->query("SELECT COUNT(*) as total FROM users");
          }else{
               $sql = $this->db->query("SELECT COUNT(*) as total FROM users WHERE roleid = $level");
          }
          
          if($sql->num_rows() > 0){
               $data = $sql->row_array();
               $result['exist'] = true;
               $result['data'] = (int)$data['total'];
          }

          return $result;
     }
}

?>