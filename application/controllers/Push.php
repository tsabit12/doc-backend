<?php
class Push extends CI_Controller{
     public function __construct(){
		parent::__construct();
          $this->load->model('model_history');
     }

     public function index(){
          $response['Code'] = '000';
          $response['Status'] = 'Berhasil';     
          $request  = file_get_contents('php://input');
          $aDatax   = json_decode($request, true);

          $insertData   =  $this->getconnote($aDatax);
          if(count($insertData) > 0){
               $this->db->delete('dashboard', array('connote_id' => $insertData['connote_id']));
               $this->db->delete('jsons', array('connote_id' => $insertData['connote_id']));

               $this->db->insert('jsons', array(
                    'connote_id' => $insertData['connote_id'],
                    'history' => json_encode($aDatax['history']),
                    'fullbody' => json_encode($aDatax),
                    'connote_code' => $insertData['connote_code']
               ));
               $this->db->insert('dashboard', $insertData);
          }

          echo json_encode($response);
     }

     public function processing(){
          $this->dblacak = $this->load->database('dblacak', TRUE);
          $request  = file_get_contents('php://input');
          $aDatax   = json_decode($request, true);

          $petugas  = $aDatax['petugas'];
          $barcode  = $aDatax['barcode'];
          $extid    = $aDatax['extid'];
          $nodokumen = $aDatax['nodokumen'];
          $kantorasal = $aDatax['kantorasal'];
          $kantortujuan = $aDatax['kantortujuan'];
          $pengantar = $aDatax['pengantar'];
          $penerima = $aDatax['penerima'];
          $urut     = $aDatax['urut'];
          $idstatus = $aDatax['idstatus'];
          $tanggal  = date('Y-m-d h:i:s', strtotime($aDatax['tanggal']));
          $deskripsi = $aDatax['deskripsi'];

          $this->dblacak->query("EXEC SP_INS_H_KIRIMANPOS_PAKETID_1
               @PETUGAS = '$petugas', 
               @BARCODE = '$barcode', 
               @EXTID = '$extid', 
               @NO_DOKUMEN = '$nodokumen', 
               @KANTORA = '$kantorasal', 
               @KANTORT = '$kantortujuan', 
               @IDSTATUS = '$idstatus', 
               @TANGGAL = '$tanggal', 
               @PENGANTAR = '$pengantar', 
               @PENERIMA = '$penerima', 
               @DESKRIPSI = '$deskripsi', 
               @URUT = '$urut'
          ");

          $response['Code'] = '000';
          $response['Status'] = 'Berhasil';     

          echo json_encode($response);

     }

     public function paid(){
          $this->dblacak = $this->load->database('dblacak', TRUE);
          $request  = file_get_contents('php://input');
          $aDatax   = json_decode($request, true);

          $petugas  = $aDatax['petugas'];
          $barcode  = $aDatax['barcode'];
          $extid    = $aDatax['extid'];
          $pengirim = $aDatax['pengirim'];
          $penerima = $aDatax['penerima'];
          $kdproduk = $aDatax['kdproduk'];
          $isikiriman = $aDatax['isikiriman'];
          $deskripsi = $aDatax['deskripsi'];
          $tanggal  = date('Y-m-d h:i:s', strtotime($aDatax['tanggal']));
          $idstatus = $aDatax['idstatus'];
          $berat    = $aDatax['berat'];
          $beadasar = $aDatax['beadasar'];
          $htok     = $aDatax['htok'];
          $htnb     = $aDatax['htnb'];
          $ppn      = $aDatax['ppn'];
          $diskon   = $aDatax['diskon'];
          $bealain  = $aDatax['bealain'];
          $idpelanggan = $aDatax['idpelanggan'];
          $telppengirim = $aDatax['telppengirim'];
          $telppenerima = $aDatax['telppenerima'];

          $nodokumen = $aDatax['nodokumen'];
          $kantorasal = $aDatax['kantorasal'];
          $kantortujuan = $aDatax['kantortujuan'];
          $pengantar = $aDatax['pengantar'];
          $urut     = $aDatax['urut'];


          $this->dblacak->query("EXEC SP_INSERT_T_KIRIMANPOS_PAKETID_1 
               @PETUGAS = '$petugas', 
               @BARCODE = '$barcode', 
               @EXTID = '$extid', 
               @PENGIRIM = '$pengirim', 
               @PENERIMA = '$penerima', 
               @KDPRODUK = '$kdproduk', 
               @ISIKIRIMAN = '$isikiriman', 
               @DESKRIPSI = '$deskripsi', 
               @TANGGAL = '$tanggal', 
               @IDSTATUS = '$idstatus', 
               @BERAT = '$berat', 
               @BEADASAR = '$beadasar', 
               @HTOK = '$htok', 
               @HTNB = '$htnb', 
               @PPN = '$ppn', 
               @DISKON = '$diskon', 
               @BEALAIN = '$bealain', 
               @IDPELANGGAN = '$idpelanggan', 
               @TELPSIPENGIRIM = '$telppengirim', 
               @TELPSIPENERIMA = '$telppenerima'"
          );

          $this->dblacak->query("EXEC SP_INS_H_KIRIMANPOS_PAKETID_1
               @PETUGAS = '$petugas', 
               @BARCODE = '$barcode', 
               @EXTID = '$extid', 
               @NO_DOKUMEN = '$nodokumen', 
               @KANTORA = '$kantorasal', 
               @KANTORT = '$kantortujuan', 
               @IDSTATUS = '$idstatus', 
               @TANGGAL = '$tanggal', 
               @PENGANTAR = '$pengantar', 
               @PENERIMA = '$penerima', 
               @DESKRIPSI = '$deskripsi', 
               @URUT = '$urut'
          ");


          $this->dblacak->query("EXEC SP_INS_MAPITEM_PAKETID @BARCODE = '$barcode', @TANGGAL = '$tanggal'");

          $response['Code'] = '000';
          $response['Status'] = 'Berhasil';     

          echo json_encode($response);
     }

     private function getcreatedat($day, $sla_date){
          if($sla_date){
              return date('Y-m-d h:i:s', strtotime($sla_date . " -$day day"));
          }else{
              return null;
          }
      }
  
      private function getsladate($day, $createdat){
          return date('Y-m-d h:i:s', strtotime($createdat . " +$day day"));
      }

     private function getHistory($arr){
          if(count($arr) > 0){
              return end($arr);
          }else{
              return $arr;
          }
     }

     private function getStatuslist($arr){
          $status = array();
          foreach($arr as $key){
              $status[] = strtoupper($key['action']);
          }
  
          return implode(',', $status);
     }

     private function getconnote($data){
          $history    = isset($data['history']) ? $data['history'] : array();
          $create     = isset($data['created_at']) ? date('Y-m-d h:i:s', strtotime($data['created_at'])) : date('Y-m-d h:i:s');
          $sla_day    = isset($data['connote_sla_day']) ? (int)$data['connote_sla_day'] : 0;
          $sla_date   = isset($data['connote_sla_date']) ? date('Y-m-d h:i:s', strtotime($data['connote_sla_date'])) : $this->getsladate($sla_day, $create);
          $created_at = isset($data['created_at']) ? date('Y-m-d h:i:s', strtotime($data['created_at'])) : $this->getcreatedat($sla_day, $sla_date);
          $last       = $this->getHistory($history);

          $result = array(
               'connote_id' => isset($data['connote_id']) ? $data['connote_id'] : null,
               'connote_code' => isset($data['connote_code']) ? $data['connote_code'] : '00',
               'connote_state' => isset($data['connote_state']) ? $data['connote_state'] : '00',
               'connote_service' => isset($data['connote_service']) ? $data['connote_service'] : '00',
               'connote_service_price' => isset($data['connote_service_price']) ? $data['connote_service_price'] : 0,
               'created_at' => $created_at,
               'connote_sla_day' => $sla_day,
               'connote_sla_date' => $sla_date,
               'location_id' => isset($data['location_id']) ? $data['location_id'] : null,
               'location_code' => isset($data['zone_code']) ? $data['zone_code'] : '0',
               'location_region' => isset($data['location_region']) ? $data['location_region'] : '0',
               'last_connote_state' => isset($last['state']) ? strtoupper($last['state']) : 'UNKNOWN',
               'last_connote_update' =>  isset($last['date']) ? date('Y-m-d h:i:s', strtotime($last['date'])) : null,
               'last_connote_created' => isset($last['date']) ? date('Y-m-d h:i:s', strtotime($last['date'])) : null,
               'list_status' => $this->getStatuslist($history),
               'connote_booking_code' => isset($data['connote_booking_code']) ? $data['connote_booking_code'] : null,
               'customer_code' => isset($data['customer_code']) ? $data['customer_code'] : null,
               'kprk_destination' => isset($data['kprk_destination']) ? $data['kprk_destination'] : null
          );

          return $result;
     }
}
?>