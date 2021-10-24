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

     private function queryuser($params, $userid = null){
          $result['exist'] = false;
          $level = $params['level'];

          $this->db->select('a.userid, a.fullname, a.username, a.email, b.roledescription, b.roleid, c.officeid, c.officename, a.image, a.created_at');
          $this->db->from('users a');
          $this->db->join('ref_role b', 'a.roleid = b.roleid');
          $this->db->join('office c', 'a.office = c.officeid');
          $this->db->order_by('a.created_at', 'desc');

          if($userid == null){
               $this->db->limit($params['limit'], $params['offset']);
          }

          if($level !== 'all'){
               $this->db->where('a.roleid', $level);
          }

          $q = $this->db->get();
          if($q->num_rows() > 0){
               $result['exist']    = true;
               $result['data']     = $userid ? $q->row_array() : $q->result_array();
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

     public function add($data){
          $result['success'] = false;

          $userid = $this->getUserid();
          $this->db->insert('users', array(
               'userid' => $userid,
               'username' => $data['username'],
               'fullname' => $data['fullname'],
               'email' => $data['email'],
               'roleid' => $data['roleid'],
               'office' => $data['office'],
               'password' => md5($data['password']."-".$userid),
               'created_by' => $data['created_by']
          ));

          if($this->db->affected_rows() > 0){
               $result['success'] = true;
               $result['user'] = $this->queryuser(array('level' => 'all'), $userid)['data'];
          }

          return $result;
     }

     private function getUserid(){
          $this->db->select('userid');
          $this->db->from('users');
          $this->db->order_by('userid', 'desc');
          $this->db->limit(1);

          $q = $this->db->get();
          if($q->num_rows() > 0){
               $data = $q->row_array();
               return (int)$data['userid'] + 1;
          }else{
               return 1;
          }
     }
}

?>