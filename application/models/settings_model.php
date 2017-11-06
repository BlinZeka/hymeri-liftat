<?php
class Settings_Model extends CI_Model {


	public function getAdmin($id){
		return $this->db->query("SELECT * FROM `admin` where id = '$id' ")->result_array();
	}

	public function editUser($arr){
		if ($arr['password'] == '' || strlen($arr['password']) < 5 ) {
			return false;
		} else {
			$this->db->where('id', $arr['id']);
			return $this->db->update('admin', $arr);
		}
	}

	public function editEmployerAction($arr,$employer_id) {
		
		$this->db->where('id', $employer_id);
		$arr['update_date'] = time();
		
		$this->db->update('employer', $arr);
	}


}