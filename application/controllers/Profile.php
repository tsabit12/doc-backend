<?php
require(APPPATH.'/libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;

class Profile extends REST_Controller{
    public function __construct(){
		parent::__construct();
        $this->load->model('model_profile');
    }


    public function upload_post(){
        $response['status'] = false;
        $response['message']['global'] = 'Upload failed';

        $data = $this->post();
        if(!isset($data['userid'])){
            $response['message']['global'] = "Userid required";
        }else{
            $config['upload_path']          = './assets/profile/';
            $config['allowed_types']        = 'jpg|png|jpeg';
            $config['overwrite']			= FALSE;
            $config['max_size']             = 3024; //3 MB
            $config['allowed_types']        = '*';
            $config['remove_spaces']        = TRUE;
            $config['encrypt_name']         = TRUE;
            $this->load->library('upload', $config);

            $files = $_FILES; 

            if(!$this->upload->do_upload('photo')){ //upload fail
                $response['message']['global'] = $this->stripHTMLtags($this->upload->display_errors());
            }else{
                $uploaded = $this->upload->data();
                $update = $this->model_profile->updateimage($uploaded['file_name'], $data['userid']);
                if($update['success']){
                    $response['status'] = true;
                    $response['message']['global'] = 'Upload berhasil';
                    $response['image'] = $uploaded['file_name'];
                }else{
                    $response['message']['global'] = "Update failed"; 
                }
            }
        }

        $this->response($response, 200);
    }

    private function stripHTMLtags($str){
        $t = preg_replace('/<[^<|>]+?>/', '', htmlspecialchars_decode($str));
        $t = htmlentities($t, ENT_QUOTES, "UTF-8");
        return $t;
    }

    public function update_post(){
        $response['status'] = false;
        $response['message']['global'] = 'Internal server error';

        $data = $this->post();
        if(!isset($data['userid'])){
            $response['message']['global'] = 'Userid is required';
        }else{
            $config = array(
                array('field' => 'username', 'label' => 'username', 'rules' => 'required|max_length[30]'),
                array('field' => 'fullname', 'label' => 'fullname', 'rules' => 'required|max_length[60]'),
                array('field' => 'email', 'label' => 'email', 'rules' => 'required|max_length[100]')
            );

            $this->form_validation->set_data($data);
            $this->form_validation->set_rules($config);
            if($this->form_validation->run() === TRUE){
                $update = $this->model_profile->update($data);
                if($update['success']){
                    $response['status'] = true;
                    $response['message']['global'] = "Profile berhasil diupdate";
                }else{
                    $response['message']['global'] = 'Update failed';
                }
            }else{
                $response['message'] = $this->form_validation->error_array();
            }
        }

        $this->response($response, 200);
    }
}

?>