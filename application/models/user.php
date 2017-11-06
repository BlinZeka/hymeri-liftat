<?php
Class User extends CI_Model {
  function login($username, $password) {

    $this->db->select('*');
    $this->db->from('admin');
    $this->db->where('username', $username);
    $this->db->where('password', $password);
    $this->db->where('status', 1);
    $this->db->limit(1);
    $query = $this->db->get();
    
    if($query->num_rows() == 1) {
      return $query->result();
    } else {
      return false;
    }
  }
  function getBuildings($admin_id) {
	   $this->db->select('*');
	   $this->db->from('admin_buildings');
	   $this->db->where('admin_id', $admin_id);
	   $query = $this->db->get();
	   
	   return $query->result();
  }
}
?>

