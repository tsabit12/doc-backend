<?php
class Model_login extends CI_Model {
    public function login($params){
        $result['success'] = false;
        
        $finduserid = $this->getUserid($params['username']);
        if($finduserid['success']){
            $userid     = $finduserid['userid'];
            $password   = md5($params['password']."-".$userid);

            $this->db->select('a.userid, a.username, a.fullname, a.email, b.officeid, b.officename, a.image');
            $this->db->select('b.officetype, b.regionid, d.regiondescription, c.roleid, c.roledescription');
            $this->db->from('users a');
            $this->db->join('office b', 'a.office = b.officeid');
            $this->db->join('ref_role c', 'a.roleid = c.roleid');
            $this->db->join('region d', 'b.regionid = d.regionid');
            $this->db->where(array('a.username' => $params['username'], 'a.password' => $password));
            $sql = $this->db->get();
            if($sql->num_rows() > 0){
                $user = $sql->row_array();
                $result['success'] = true;
                $result['user'] = $user;
            }
        }

        return $result; 
    }

    private function getUserid($username){
        $result['success'] = false;

        $this->db->select('userid');
        $this->db->from('users');
        $this->db->where('username', $username);
        $sql = $this->db->get();
        if($sql->num_rows() > 0){
            $data = $sql->row_array();
            $result['success'] = true;
            $result['userid'] = $data['userid'];
        }

        return $result;
    }
}

?>