<?php
class Companies_Model extends CI_Model {
	
	public function getTable($admin_id) {
		echo $admin_id;
		$query = $this->db->query(
				sprintf(
				"SELECT c.`id`, c.`name`, a.`username` as `created_by`, u.`username` as `updated_by`,
					FROM_UNIXTIME(c.`create_date`) as `create_date`,
					FROM_UNIXTIME(c.`update_date`) as `update_date`,
					c.`owner`, c.`phone`, c.`fiscal_no`, c.`business_no`, t.`name` as `city`
					FROM `companies` c 
					INNER JOIN `admin`  a ON c.`created_by` = a.`id`
					INNER JOIN `admin`  u ON c.`updated_by` = u.`id`
					INNER JOIN `cities` t ON c.`city_id` = t.`id`
					WHERE c.`created_by` = %s", $admin_id));
		
		return $query->result();
	}
	
	public function getCompanies(){
		return $this->db->query('select c.id, c.name, q.name as city, c.created_by, c.create_date, c.updated_by, c.update_date from companies as c
INNER JOIN cities as q ON c.city_id = q.id where c.status= 0')->result();
	}
	
	public function insertData($arr) {
		$arr['create_date'] = time();
		$arr['update_date'] = $arr['create_date'];
		$arr['updated_by'] = $arr['created_by'];
		$arr['update_no'] = 0;
		
		return $this->db->insert('companies', $arr);
	}
	
	public function deleteData($id) {
		$this->db->query('UPDATE companies set status = 1 where id = '.$id);
	}
	
	public function editData($arr) {
		$id = $arr['id'];
		unset($arr['id']);
		
		$this->db->where('id', $id);
		$arr['update_date'] = time();
		return $this->db->update('companies', $arr);
	}
	
	public function disableData($id) {                                                
		$this->db->where('id', $id);
		return $this->db->delete('companies');
	}
	
	public function getCities() {
		return $this->db->query('SELECT * FROM `cities`')->result_array();
	}
	
}
?>