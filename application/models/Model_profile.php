<?php

class Model_profile extends CI_Model {
    public function updateimage($filename, $userid){
        $result['success'] = false;
        $this->db->where('userid', $userid);
        $this->db->update('users', array('image' => $filename));
        if($this->db->affected_rows() > 0){
            $result['success'] = true;
        }

        return $result;
    }

    public function update($data){
        $result['success'] = false;
        $payload = array(
            'username' => $data['username'],
            'email' => $data['email'],
            'fullname' => $data['fullname']
        );

        $this->db->where('userid', $data['userid']);
        $this->db->update('users', $payload);
        if($this->db->affected_rows() > 0){
            $result['success'] = true;
        }
        
        return $result;
    }
}

?>