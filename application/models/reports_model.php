<?php
class Reports_Model extends CI_Model {
	public function getTable($building_id) {
		$query = $this->db->query(
				sprintf("select e.id, e.name, a.username as created_by, u.username as updated_by,
									FROM_UNIXTIME(e.`create_date`) as `create_date`,
									FROM_UNIXTIME(e.`update_date`) as `update_date`
									from entries e
									inner join admin a ON e.created_by = a.id
									left join admin u ON e.updated_by = u.id
									where building_id = %s", $building_id));
		
		return $query->result();
	}
	
	
}
?>