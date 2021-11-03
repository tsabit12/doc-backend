<?php
class Model_notification extends CI_Model {
     public function getNotif(){
          $result = array();
          $sql      = $this->db->query("select * from users u where token <> ''");
          $users    = $sql->result_array();

          foreach($users as $key){
               $total    = $this->summary($key['roleid'], $key['office']);
               if($total > 0){
                    $body     = $this->getbody($total, $key['roleid']);
                    $result[] = array(
                         "to" => $key['token'],
                         "title" => "Halo ".$key["fullname"]."! Anda mendapatkan email baru📬",
                         "body" => $body,
                         "channelId" => "default-doc",
                         "categoryId" => "basic"
                    );
               }
          }

          return $result;
     }

     public function summary($level, $kantor){
          $date = date('Y-m-d');
          $result = 0;

          $this->db->select('coalesce(sum(total), 0) as jumlah');
          $this->db->from('summarybaru');

          if($level == '4'){ //regional
               $this->db->where('regionid', $kantor);
          }else if($level == '1'){//kprk
               $this->db->where('location_code', $kantor);
          }

          $this->db->where("tgl_generate", $date);
          $this->db->where("types", "jatuhtempo");

          $q = $this->db->get();
          if($q->num_rows() > 0){
               $data = $q->row_array();
               $result = $data['jumlah'];
          }

          return $result;
     }

     private function getbody($total, $level){
          $default = "Kiriman jatuh tempo di kantor saudara sebanyak : $total items. Mohon segera diantar dan dilakukan update status. Terimakasih";
          if($level == '4'){ //regional
               $default = "Total kiriman jatuh tempo di semua kantor kprk pada regional saudara sebanyak : $total items. Mohon segera diantar dan dilakukan update status. Terimakasih"; 
          }else if($level == '5' || $level == '2'){ //pusat
               $default = "Total kiriman jatuh tempo pada semua kantor saat ini sebanyak : $total";
          }

          return $default;
     }
}

?>