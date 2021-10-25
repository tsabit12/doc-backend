<?php
class Model_notification extends CI_Model {
     public function getToken(){
          $result = array();
          $sql = $this->db->query("select token from users u where token <> ''");
          $token = $sql->result_array();

          foreach($token as $key){
               $result[] = $key['token'];
          }

          return $result;
     }

     public function summary(){
          $result['success'] = false;

          $sql = $this->db->query("select sum(total) as jumlah, to_char(now(), 'YYYY-MM-DD HH24:MI:SS') as curentdate
          from summarybaru s where tgl_generate = to_char(now(), 'YYYY-MM-DD') and types = 'jatuhtempo'");

          if($sql->num_rows() > 0){
               $data = $sql->row_array();
               $result['data'] = $data;
               $result['success'] = true;
          }

          return $result;
     }
}

?>