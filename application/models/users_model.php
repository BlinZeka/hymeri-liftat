<?php
class Users_Model extends CI_Model {
	function getAll(){
		$query = $this->db->query("SELECT * FROM admin where level = '4'")->result_array();

		echo json_encode($query);
	}

	function getBuildings(){
		$query = $this->db->query("SELECT bu.id , bu.name as bname , bu.street , zn.name as zname FROM buildings AS bu INNER JOIN zones AS zn ON bu.zone_id = zn.id")->result_array();

		return $query;
	}

	function insert_array($session_data){
	
  		$data = array();
  		foreach($this->input->post('building_id') as $bd){
  			$data[] = array('building_id' => $bd , 'user_id' => $session_data);
  		}
	
		$query = $this->db->insert_batch('test',$data);

		if($query){
			redirect('users');
		} else {
			return false;
		}
	}

	function get_checked($id){
		$query = $this->db->query("SELECT * from test where user_id = '$id'")->result_array();
		echo json_encode($query);
	}

	public function get_by_id($id){
		$query = $this->db->query(" SELECT bu.id , bu.name AS bname , bu.street , zn.name AS zname , ts.user_id , ts.building_id , ts.id as te_id  FROM buildings AS bu 
 			INNER JOIN zones AS zn ON bu.zone_id = zn.id
			INNER JOIN test  AS ts ON bu.id = ts.building_id
			WHERE ts.user_id = '$id'
		")->result_array();

		return $query;
	}

	public function delete_access($id){
		$this->db->where("id" , $id);
		$this->db->delete("test");
		redirect('users');

	}

}
?>	
