<?php

class Clients_Model extends CI_Model {



	
// SELECT `id` FROM `companies` WHERE `created_by` = %s )", $admin_id));    ket ia kam hiq ne menyr qe userat tjer ti shohin tdhanat, nese shtohet ky kod athere vetem qato usera qe i kan shtu recorde i shohin qato recorde te shtuara
	public function getTable($entry_id = -1, $admin_id,$level) {
		$filterByLevel = "";
		$filterByClientId ="";
		
		

		//if level is ndermejtsues filtroj clientet
		if ($level == 3) {
			$filterByLevel ="inner join admin_buildings ab on ab.building_id = b.id";
			$filterByClientId = "AND ab.admin_id = ".$admin_id."";
		}

		if($entry_id != -1) {

			$query = $this->db->query(

					sprintf("SELECT c.`id`, CONCAT(c.first_name, ' ', c.last_name) as `name`, c.phone_1,

							  c.email, CONCAT(adm.first_name ,' ',adm.last_name ) as created_by , c.status,  f.name as flat_name, f.number as fnumber,  c.`from`, c.`to`,

							  e.building_id, e.name as `building_name`

							  FROM clients c

							  INNER JOIN flats f ON c.flat_id = f.id
							  INNER JOIN entries e ON f.entry_id = e.id
							  INNER JOIN admin adm on adm.id = c.created_by

							WHERE e.`id` = %s OR c.card_no  = %s and c.status = 0", $entry_id));			

			return $query->result();

		} else {

			$query = $this->db->query(

					sprintf("SELECT c.`id`, CONCAT(c.first_name, ' ', c.last_name) as `name`, c.phone_1,

							  c.email, CONCAT(adm.first_name ,' ',adm.last_name ) as created_by ,c.status, f.name as flat_name, f.number as fnumber, f.floor as floor ,c.`from`, c.`to`,

							  cards.card_no , cards.client_id , cards.site_code , cards.site_no ,

							  e.building_id, e.name as `building_name`,  b.name as buildingName, b.street as street

							FROM clients c
						 	  INNER JOIN cards on cards.client_id = c.id
							  INNER JOIN flats f ON c.flat_id = f.id
							  INNER JOIN entries e ON f.entry_id = e.id
							  LEFT JOIN admin adm on adm.id = c.created_by

							  INNER JOIN buildings b on b.id = e.building_id
							  $filterByLevel
						  	WHERE c.status = 0 and e.`building_id` IN (

								SELECT `id` FROM `buildings` WHERE company_id IN (

									SELECT id FROM companies

									))
									$filterByClientId
									group by c.id" ));

			
			
			return $query->result();

		}

	}

	//API
	public function getClientDetails($client_id) {

			$query = $this->db->query(

					sprintf("SELECT c.`id`, CONCAT(c.first_name, ' ', c.last_name) as `name`, c.phone_1, c.monthly_price as 'monthly_price', c.client_type as client_type, c.gender as 'gender', c.birthday as 'birthday',c.personal_id as 'personal_id',

							  c.email, CONCAT(adm.first_name ,' ',adm.last_name ) as created_by ,c.status, f.name as flat_name, f.number as fnumber, c.`from`, c.`to`,

							  e.building_id, f.entry_id, e.name as `building_name`, COUNT(if(ec.status = 1, ec.status, NULL )) as status, b.name as buildingName, b.street as street,card.site_code as siteCode, card.site_no as siteNo,

							  (SELECT GROUP_CONCAT(ca.card_no) FROM cards ca where ca.client_id = c.id) as clientCards FROM clients c

							  INNER JOIN flats f ON c.flat_id = f.id
							  INNER JOIN entries e ON f.entry_id = e.id
							  INNER JOIN admin adm on adm.id = c.created_by
							  LEFT JOIN cards card on card.client_id =  c.id
							  LEFT JOIN elevators_cards ec on ec.card_id = card.id
							  inner join buildings b on b.id = e.building_id
							  WHERE c.id = '$client_id'
							  and e.`building_id` IN (

								SELECT `id` FROM `buildings` WHERE company_id IN (

									SELECT id FROM companies

									))
								
									group by c.id") );

			

			return $query->result();

		

	}


	
	public function flatsByEntry($entry_id,$admin_id, $level = 1){
// 		echo $entry_id;
		
		if($level == 1 || $level == 2) {
		$query = $this->db->query( "SELECT c.`id`, CONCAT(c.first_name, ' ', c.last_name) as `name`, c.phone_1,

							  c.email, CONCAT(adm.first_name ,' ',adm.last_name ) as created_by ,c.status, f.name as flat_name, f.number as fnumber ,f.floor as floor, c.`from`, c.`to`,

							  e.building_id, e.name as `building_name`, COUNT(if(ec.status = 1, ec.status, NULL )) as status

							  FROM clients c

							  INNER JOIN flats f ON c.flat_id = f.id
							  INNER JOIN entries e ON f.entry_id = e.id
							  INNER JOIN admin adm on adm.id = c.created_by
							  LEFT JOIN cards card on card.client_id =  c.id
							  LEFT JOIN elevators_cards ec on ec.card_id = card.id
				

						  	WHERE f.status = 0 and e.`building_id` IN (

								SELECT `id` FROM `buildings` WHERE company_id IN (

									SELECT id FROM companies

									)) AND e.id = $entry_id and c.status = 0
								
									group by c.id");

			}

			else if($level == 3 || $level == 4) {
				$query = $this->db->query( "SELECT c.`id`, CONCAT(c.first_name, ' ', c.last_name) as `name`, c.phone_1,

							  c.email, CONCAT(adm.first_name ,' ',adm.last_name ) as created_by ,c.status, f.name as flat_name, f.number as fnumber ,f.floor as floor, c.`from`, c.`to`,

							  e.building_id, e.name as `building_name`, COUNT(if(ec.status = 1, ec.status, NULL )) as status

							  FROM clients c

							  INNER JOIN flats f ON c.flat_id = f.id
							  INNER JOIN entries e ON f.entry_id = e.id
							  INNER JOIN admin adm on adm.id = c.created_by
							  LEFT JOIN cards card on card.client_id =  c.id
							  LEFT JOIN elevators_cards ec on ec.card_id = card.id
				

						  	WHERE f.status = 0 and e.`building_id` IN (

								select building_id from admin_buildings where admin_id = $admin_id) AND e.id = $entry_id and c.status = 0
								
									group by c.id");
			}			
		
			




			

			return $query->result();

	}

	public function showAllFlatsByEntry($entry_id){
		$query = $this->db->query("SELECT * FROM flats where entry_id = '$entry_id' ");

		return $query->result();
	}


	public function insertDataEmployer($arr) {

		
		$flat = array(
				'fname' => $arr['fname'],
				'lname' => $arr['lname'],
				'tel' => $arr['tel'],
				'create_date' => time(),
				'created_by' => $arr['created_by'],
				'status' => 1 
				
			 );
// 			 	print_r($flat);
				$this->db->insert("employer", $flat);
		}

	public function insertData($arr) {
		unset($arr['entry_id']);
		$flat = array(
				'name' => $arr['flat_id'],
				'number' => $arr['flat_id'],
				'floor' => $arr['floor'],
				'entry_id' => $this->session->userdata('entry_id'),
				'create_date' => time(),
				'update_date' => $arr['create_date'],
				'created_by' => $arr['created_by'],
				'updated_by' => $arr['created_by'],
				'update_no' => 0,
			 );


		$arr['create_date'] = time();

		$arr['update_date'] = $arr['create_date'];

		$arr['updated_by'] = $arr['created_by'];

		$arr['update_no'] = 0;

		

		
		$date = str_replace('/', '-', $arr['birthday']);

		$arr['birthday'] = date('Y-m-d', strtotime($date));

		

		// $arr['from'] = strtotime($arr['from']);

		// $arr['to'] = strtotime($arr['to']);

		

		//$card_no = $arr['card_no'];       unset($arr['card_no']);

		// $site_code = $arr['site_code'];   unset($arr['site_code']);

		// $site_no = $arr['site_no'];       unset($arr['site_no']);

		// echo self::checkFlatNumberEntry($arr['flat_id'],$this->session->userdata('entry_id'));
		echo $this->session->userdata('entry_id');
		// die;
		if (self::checkFlatNumberEntry($arr['flat_id'],$this->session->userdata('entry_id'), $arr['floor'] ) == 1) {
			echo " <div style = 'color:red'>The flat number you have given is already in use in this entry.</div>";
			die;
			
		} else {
			$this->db->insert('flats', $flat);
		}
		
		
		unset($arr['number']);
		unset($arr['floor']);
		$arr['flat_id'] = $this->db->insert_id();

		// unset($arr['flat_id']);
		$this->db->insert('clients', $arr);

		

		$client_id = mysql_insert_id();

		

		// for($i=0; $i<count($site_code); $i++) {

		// 	$card = array();

		// 	$card['site_code'] = $site_code[$i];

		// 	$card['site_no'] = $site_no[$i];

			

		// 	$card['card_no'] = hexdec(dechex($card['site_code']) . dechex($card['site_no']));

			

		// 	$card['status'] = 1;

		// 	$card['created_by'] = $arr['created_by'];

		// 	$card['create_date'] = $arr['create_date'];

		// 	$card['updated_by'] = $arr['created_by'];

		// 	$card['update_date'] = $arr['create_date'];

		// 	$card['update_no'] = 0;

		// 	$card['client_id'] = $client_id;

						

		// 	$this->db->insert("cards", $card);

		// }

		

		return 1;

	}

	public function insertDataCRM($arr) {

		if(isset($arr['abonues'])){

			$flat = array(
				'name' => $arr['flat_id'],
				'number' => $arr['flat_id'],
				'entry_id' =>  $arr['entry_id'],
				'create_date' => time(),
				'update_date' => $arr['create_date'],
				'created_by' => $arr['created_by'],
				'updated_by' => $arr['created_by'],
				'update_no' => 0,
			 );
			
			// if (self::checkFlatNumberEntry($arr['flat_id'],$this->session->userdata('entry_id')) == 1) {
			// 	echo " <div style = 'color:red'>The flat number you have given is already in use in this entry.</div>";
				
			// 	die;
			
			// } else {
			// 	$this->db->insert('flats', $flat);
			// }
				unset($arr['flat_id']);
				unset($arr['monthly_price']);
				unset($arr['name']);

		}else{
			unset($arr['flat_id']);
			unset($arr['entry_id']);
			unset($arr['birthday']);
		}
		


		$arr['create_date'] = time();

		$arr['update_date'] = $arr['create_date'];

		$arr['updated_by'] = $arr['created_by'];

		$arr['update_no'] = 0;



		unset($arr['user_id']);
		unset($arr['entry_id']);
	
		// unset($arr['client_category']);
		if (isset($arr['flat_id'])) {
			$arr['flat_id'] = $this->db->insert_id();
		}
		$this->db->insert('clients', $arr);

	

		$client_id = mysql_insert_id();

		

		return 1;

	}

	

	public function editData($arr) {


		if (self::checkFlatNumberEntryExceptCurrentFlat($arr['number'],$arr['entry_id'],$arr['flat_id'], $arr['floor']) == 1) {
			echo " <div style = 'color:red'>The flat number you have given is already in use in this entry.</div>";
			die;
			
		} 

		$id = $arr['id'];
		$flatID =$arr['flat_id'];
		$number =$arr['number'];
		$floor =$arr['floor'];

		unset($arr['id']);
		unset($arr['number']);
		unset($arr['entry_id']);
		unset($arr['floor']);
		$date = str_replace('/', '-', $arr['birthday']);

		$arr['birthday'] = date('Y-m-d', strtotime($date));

		$this->db->where('id', $id);

		$arr['update_date'] = time();

		$this->db->update('clients', $arr);

		unset($arr);
		$this->db->where('id', $flatID);

		$arr['update_date'] = time();

		$arr2 = array('number'=>$number,'floor'=>$floor);
		return $this->db->update('flats', $arr2);

	}

	

	public function disableData($id) {                                                

		$this->db->where('id', $id);

		return $this->db->delete('buildings');

	}

	

	public function getFlats() {

		return $this->db->query('SELECT f.id as id, f.name as name, e.name as entryName, b.name as buildingName FROM `flats` f
						INNER JOIN entries e ON e.id = f.entry_id 
						INNER JOIN buildings b ON b.id = e.building_id where f.status = 0')->result_array();

	}

	public function getMonthlyPrice($client_id) {

		return $this->db->query("SELECT monthly_price FROM `clients`  WHERE id = '$client_id' ")->result_array();

	}

	public function deleteClient($clientID){


		$this->db->query("DELETE FROM flats where id = (SELECT flat_id from clients where id = $clientID) ");


		$this->db->where('client_id',$clientID);
		$this->db->delete('client_notes');

		$this->db->where('id',$clientID);
		$this->db->delete('clients');

		$this->db->where('client_id',$clientID);
		$this->db->delete('cards');




	}
	
	public function updateClientStatus($clientID){


		$this->db->query("update clients set status = 1 where id = $clientID");
		

/*
		$this->db->where('client_id',$clientID);
		$this->db->delete('client_notes');

		$this->db->where('id',$clientID);
		$this->db->delete('clients');

		$this->db->where('client_id',$clientID);
		$this->db->delete('cards');
*/




	}
	
	
	public function deleteClientUpdate($clientID){


// 		$this->db->query("DELETE FROM flats where id = (SELECT flat_id from clients where id = $clientID) ");
		$result = mysql_query("select id from cards where client_id = $clientID OR employer_id = $clientID");
		$id = mysql_fetch_array($result);
		$id = $id['id'];
			
// 		$result = $this->db->query("select id from cards where client_id = $clientID OR employer_id = $clientID");

		
		$this->db->query("update cards set client_id = NULL, employer_id = NULL, card_no = CONCAT(card_no, $id) where client_id = $clientID OR employer_id = $clientID");
// 		$this->db->query("update cards set client_id = NULL, employer_id = NULL, card_no = $id where client_id = $clientID OR employer_id = $clientID");
		
		$this->db->query("update clients set status = 1 where id = $clientID");
		
		$this->db->query("update elevators_cards set status = 0, action = 3 where card_id = $id");
		
		


// 		$this->db->where('client_id',$clientID);
// 		$this->db->delete('client_notes');

// 		$this->db->where('id',$clientID);
// 		$this->db->delete('clients');

// 		$this->db->where('client_id',$clientID);
// 		$this->db->delete('cards');




	}

	public function checkFlatNumberEntry($flatNr,$entry_id,$floor){
		$result = $this->db->query("SELECT count(id) as exist FROM flats f WHERE f.number = '$flatNr' AND f.entry_id = '$entry_id' AND floor = '$floor' AND status = 0")->row();
		
		if ( $result->exist > 0) {
			return 1;
		} else {
			return 0;
		}
	}

	public function checkFlatNumberEntryExceptCurrentFlat($flatNr,$entry_id,$flat_id,$floor){
		$result = $this->db->query("SELECT count(id) as exist FROM flats f WHERE f.number = '$flatNr' AND f.entry_id = '$entry_id' AND id != '$flat_id' AND floor = '$floor' ")->row();
		
		if ( $result->exist > 0) {
			return 1;
		} else {
			return 0;
		}
	}

}

?>