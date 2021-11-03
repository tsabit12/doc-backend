<?php
require(APPPATH.'/libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;

class Update extends REST_Controller{
     function __construct(){
          parent::__construct();
          $this->db2 = $this->load->database('kemitraan', TRUE);
      }

     public function office_post(){
          $result['status'] = false;
          $result['message'] = "Internal server error";

          $nulloffice    = $this->nulloffice();
          $office        = $this->getoffice($nulloffice);

          if(count($office) > 0){
               $this->db->insert_batch('office', $office);
               if($this->db->affected_rows() > 0){
                    $result['status'] = true;
                    $result['message'] = "Oke";
               }
          }
          $this->response($result, 200);
     }

     private function getoffice($officearr){
          if(count($officearr) > 0){
               $this->db2->select("a.nopend as officeid, UPPER(a.NamaKtr) as officename, a.nopend as kprk, RIGHT(b.id_wilayah, 1) as regionid, 'KPRK' as officetype");
               $this->db2->from('ref_kantor a');
               $this->db2->join('ref_Wilayah b', 'a.idwilayah = b.nopend');
               $this->db2->where_in('a.nopend', $officearr);

               $q = $this->db2->get();
               if($q->num_rows() > 0){
                    $data = $q->result_array();

                    return $data;
               }else{
                    return array();
               }
          }else{
               return array();
          }
     }

     private function nulloffice(){
          $this->db->select('location_code');

          $this->db->from('dashboard');
          $this->db->where('location_region', '0');
          $this->db->group_by('location_code');

          $q = $this->db->get();
          if($q->num_rows() > 0){
               $data = $q->result_array();
               $result = array();
               foreach($data as $key){
                    $result[] = $key['location_code'];
               }
               
               return $result;
          }else{
               return array();
          }
     }
}

?>