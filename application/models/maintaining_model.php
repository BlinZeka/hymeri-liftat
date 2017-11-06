<?php
class Maintaining_Model extends CI_Model {


	public function addUser($arr){

		$arr['create_date'] = time();
		$arr['update_date'] = $arr['create_date'];
		$arr['created_by'] = 2;
		$arr['status'] = 1;
		$arr['update_no'] = 0;
		$arr['level'] = 1;

		
		$this->db->insert('admin', $arr);


	}

	public function editUser($arr){

	
		
	}

	public function getUsers() {

		return $this->db->query('SELECT * FROM `admin`')->result_array();

	}

	public function getUsersBuildingAccess() {
		//nese don me i paraqit edhe userat ja hiq and level !=1'
		return $this->db->query(' SELECT * FROM `admin` WHERE level != 2 and level !=1')->result_array();

	}

	public function getLifts() {

		return $this->db->query('SELECT  c.name as company, b.name as buildingName, b.street as street , entry.name as entry, e.IMEI as imei, e.tel as phone  FROM elevators e
						   INNER JOIN entries entry on entry.id = e.entry_id
						   INNER JOIN buildings b on entry.building_id = b.id
						   INNER JOIN companies c on c.id = b.company_id')->result();
	}

	public function clientAccessBuilding($clientID,$companyID,$arr){
	  	
	  	$arr['admin_id'] = $clientID;
		$arr['building_id'] = $companyID;
		$arr['created_date'] = time();
		
		
		$this->db->insert('admin_buildings', $arr);

		return $this->db->query('SELECT b.name as name, b.id as building_id, ab.id as access_id from admin_buildings   ab inner join buildings b on b.id = ab.building_id where admin_id  = '.$clientID.' ')->result();
	  }

	  public function getClientsAccess($clientID){
	  	return $this->db->query('SELECT  b.name as name, b.id as building_id, ab.id as access_id from admin_buildings ab inner join buildings b on b.id = ab.building_id where admin_id  = '.$clientID.' ')->result();
	  }

	   public function deleteClientsAccess($id,$clientID){
	  	
	  	$this->db->where('id',$id);
		$this->db->delete('admin_buildings');

	  	return $this->db->query('SELECT  b.name as name, b.id as building_id, ab.id as access_id  from admin_buildings   ab inner join buildings b on b.id = ab.building_id where admin_id  = '.$clientID.' ')->result();
	  }

}