<?php
class Buildings_Model extends CI_Model {
	// SELECT `id` FROM `companies` WHERE `created_by` = %s )", $admin_id));    ket ia kam hiq ne menyr qe userat tjer ti shohin tdhanat, nese shtohet ky kod athere vetem qato usera qe i kan shtu recorde i shohin qato recorde te shtuara
	public function getTable($admin_id, $company_id = -1, $user_level) {

		$joinAdminBuildingFilter = '';
		$filterByUser = '';
		if($company_id != -1) {
			$query = $this->db->query(
					sprintf(
							"SELECT b.`id`, b.`name`, z.`name` as zone, concat(a.`first_name`,' ',a.`last_name`) as `created_by`,
							 FROM_UNIXTIME(b.`create_date`) as `create_date`, concat(u.`first_name`,' ',u.`last_name`)as `updated_by`,
							 FROM_UNIXTIME(b.`update_date`) as `update_date`,
							 b.`lat`, b.`lon`
							 FROM `buildings` b, b.`street` as street
			         INNER JOIN `zones` z ON b.`zone_id` = z.`id`
			         INNER JOIN `admin` a ON b.`created_by` = a.`id`
			         INNER JOIN `admin` u ON b.`updated_by` = u.`id`
							 WHERE b.company_id = %s", $company_id));	
			return $query->result();
		} else {
			//per userat nese don me ja limitu qasjen e shton kete brenda if  statment || $user_level == 1
			if($user_level == 3 ){
				$joinAdminBuildingFilter = 'INNER JOIN admin_buildings ab on ab.building_id = b.id';
				$filterByUser = 'AND ab.admin_id = '.$admin_id.' ';
			}

			if($user_level == 4){
					$joinAdminBuildingFilter = 'INNER JOIN test t on t.building_id = b.id';
					$filterByUser = 'AND t.user_id = '.$admin_id.' ';
			}
			
			$query = $this->db->query(
					sprintf(
							"SELECT b.`id`, b.`name`, c.`name` as cname, z.`name` as zone, concat(a.`first_name`,' ',a.`last_name`) as `created_by`,
							 FROM_UNIXTIME(b.`create_date`) as `create_date`, concat(u.`first_name`,' ',u.`last_name`)as `updated_by`,
							 FROM_UNIXTIME(b.`update_date`) as `update_date`,
							 b.`lat`, b.`lon` ,b.`street` as street
							 FROM `buildings` b
			         INNER JOIN `zones` z ON b.`zone_id` = z.`id`
			         INNER JOIN `admin` a ON b.`created_by` = a.`id`
			         INNER JOIN `admin` u ON b.`updated_by` = u.`id`
			         INNER JOIN `companies` c ON b.`company_id` = c.`id`
			         $joinAdminBuildingFilter
			         WHERE b.`company_id` IN ( 
								SELECT `id` FROM `companies`
							 ) $filterByUser"));
			
			return $query->result();			
		}
	}
	public function insertData($arr) {
		$arr = array('name'=>  $this->input->post('name'),
			'company_id'=> $this->input->post('company_id'),
			'zone_id'=> $this->input->post('zone_id') ,
			'create_date'=> time(),
			'update_date'=> '' ,
			'lat'=>$this->input->post('lat'),
			'lon'=>$this->input->post('lon'),
			'created_by'=> 1 ,
			'updated_by'=> 1,
			'update_no'=>0,
			'street'=>$this->input->post('street'),
			);

		return $this->db->insert('buildings', $arr);
	}
	public function deleteBuilding($id){
		$this->db->where('id', $id);
		$this->db->delete('buildings');
	}

	public function editData($arr) {
		$id = $arr['id'];
		unset($arr['id']);
		
		$this->db->where('id', $id);
		$arr['update_date'] = time();

		return $this->db->update('buildings', $arr);
	}
	public function disableData($id) {                                                
		$this->db->where('id', $id);
		return $this->db->delete('buildings');
	}
	public function getZones() {
		return $this->db->query('SELECT * FROM `zones`')->result_array();
	}
	public function getCompanies() {
		return $this->db->query('SELECT * FROM `companies`')->result_array();
	}
	public function getBuildings() {
		return $this->db->query('SELECT * FROM `buildings`')->result_array();
	}
	public function getBuildingsLvl3($user_id) {
		return $this->db->query('SELECT buildings.id, buildings.name, buildings.lat, buildings.lon, buildings.company_id, buildings.zone_id, buildings.created_by, buildings.create_date, buildings.updated_by, buildings.update_date, buildings.update_no FROM `buildings` JOIN admin_buildings ON admin_buildings.building_id = buildings.id where admin_buildings.admin_id = '.$user_id)->result_array();
	}
	public function getBuildingsByCompanyId($company_id) {
		return $this->db->query("SELECT * FROM `buildings` where company_id = '$company_id' ")->result_array();
	}
	public function getEntries() {
		return $this->db->query('SELECT * FROM `entries`')->result_array();
	}
	public function getEntriesByBuildingId($building_id) {
		return $this->db->query("SELECT * FROM `entries`  where building_id ='$building_id' ")->result_array();
	}
	public function insertBuilding($arr){
		$query =  $this->db->insert('companies', $arr);

		if ($query) {
			$this->getCompaniesJson();
		}
	}
	public function insertZone($arr){
		$query = $this->db->insert('zones', $arr);
		if ($query) {
			$this->getZonesJson($arr['city_id']);
		}
	}
	public function getCountries() {
		return $this->db->query('SELECT * FROM `states`')->result_array();
	}
	public function getCities() {
		return $this->db->query('SELECT * FROM `cities`')->result_array();
	}

	public function getCitiesJson($countryID) {
		$arr = $this->db->query('SELECT c.name as cityName, c.id as cityID, c.state_id as countryID  from cities c
						inner join states s on s.id = c.state_id
						where s.id = ' .$countryID .' ')->result_array();
		echo json_encode($arr);
	}

	public function getZonesJson($cityID) {
		$arr = $this->db->query(' SELECT z.name as zoneName, z.city_id as cityID, z.id as zoneID, c.name as cityName from zones z
						inner join cities c on c.id = z.city_id
						where c.id = ' .$cityID .' ')->result_array();
		echo json_encode($arr);
	}

	public function getCompaniesJson() {
		$arr = $this->db->query(' SELECT * FROM `companies` ')->result_array();
		echo json_encode($arr);
	}



	public function getZoneJson() {
		$arr = $this->db->query(' SELECT * FROM `zones` ')->result_array();
		echo json_encode($arr);
	}

	public function getCityJson() {
		$arr = $this->db->query(' SELECT * FROM `cities` ')->result_array();
		echo json_encode($arr);
	}
	
	public function getCompanyName()
	{
	  return $this->db->query('SELECT companies.name FROM `companies`')->result_array();
	}

	public function getAllClientsEntry($company_id,$building_id,$entry_id,$from,$to,$valute){

		$filterbyCompanyId = "";
		$filterbyBuildingId = "";
		$filterbyEntryId="";
		

		if ($company_id != -1 && isset($building_id)) {
			
			$filterbyCompanyId = "AND com.id = '$company_id'";
		} 

		if ($building_id != -1 && $building_id != "null" ){
			
			$filterbyBuildingId = "AND b.id  = '$building_id'";
		} 

		if ($entry_id != -1 &&$entry_id != "null" ) {
			
			$filterbyEntryId = "AND e.id  = '$entry_id'";
		} 



		  return $this->db->query("SELECT com.name as companyName,com.id as companyID,  f.name as fName, b.name as buildingName , b.id as buildingID, f.number as flatNumber, f.name as flatName, c.id as ClientID , e.name as hyrja,  CONCAT(c.first_name, ' ' ,c.last_name) as clientName,
						p.month as month, p.from as fromDate , p.to as toDate, p.paid as pagesa, p.date as pagesaDate, c.phone_1 as phone, c.email as email
						from flats f

						inner join clients c on c.flat_id = f.id
						inner join payments p on p.client_id = c.id
						inner join entries e on e.id = f.entry_id
						inner join buildings b on b.id = e.building_id
						inner join companies com on com.id = b.company_id

						where TRUE  $filterbyCompanyId $filterbyBuildingId $filterbyEntryId AND p.status = 1
						and p.valute = '$valute' and p.date >= '$from' and p.date <='$to' and p.paid > 0 
						")->result_array();
	}

	public function getTotalbyEntryId($company_id,$building_id,$entry_id,$from,$to,$valute){

		$filterbyCompanyId = "";
		$filterbyBuildingId = "";
		$filterbyEntryId="";

		

		if ($company_id != -1 && isset($building_id)) {
			
			$filterbyCompanyId = "AND com.id = '$company_id'";
		} 

		if ($building_id != -1 && $building_id != "null" ){
			
			$filterbyBuildingId = "AND b.id  = '$building_id'";
		} 

		if ($entry_id != -1 &&$entry_id != "null" ) {
			
			$filterbyEntryId = "AND e.id  = '$entry_id'";
		} 

		  return $this->db->query("SELECT SUM(p.paid) AS totali
						from flats f

						inner join clients c on c.flat_id = f.id
						inner join payments p on p.client_id = c.id
						inner join entries e on e.id = f.entry_id
						inner join buildings b on b.id = e.building_id
						inner join companies com on com.id = b.company_id

						where TRUE  $filterbyCompanyId $filterbyBuildingId $filterbyEntryId AND p.status = 1
						and p.valute = '$valute' and p.date >= '$from' and p.date <='$to'
						/*and p.month between 1 and 4 */ ")->result_array();
	}

	public function clientsNotPaymentsByMonth($company_id,$building_id,$entry_id,$from,$to){

		$filterbyCompanyId = "";
		$filterbyBuildingId = "";
		$filterbyEntryId="";
		
		
		if ($company_id != -1 && isset($building_id)) {
			// echo " true company: ". $filterbyCompanyId;
			$filterbyCompanyId = "AND comp.id = '$company_id'";
		} 

		if ($building_id != -1 && $building_id != "null" ){
			// echo " true building_id: " . $filterbyBuildingId;
			$filterbyBuildingId = "AND b.id  = '$building_id'";
		} 

		if ($entry_id != -1 &&$entry_id != "null" ) {
			// echo " true entry_id: " .$filterbyEntryId ;
			$filterbyEntryId = "AND e.id  = '$entry_id'";
		} 

		  return $this->db->query("SELECT * from clients c inner join flats f on f.id = c.flat_id 
						inner join entries e on e.id = f.entry_id 
						inner join buildings b on b.id =e.building_id
						inner join companies comp on comp.id = b.company_id
						WHERE c.id NOT IN(select distinct pp.client_id 
						from payments pp WHERE and pp.from >= '$from' and pp.to <='$to' ) 
						  $filterbyCompanyId $filterbyBuildingId $filterbyEntryId
						 ")->result_array();
	
	}

	public function deleteCompany($id) {       

		$this->db->where('id', $id);
		$this->db->delete('companies');
		$this->getCompaniesJson();
	}

}
?>

