<?php
class Cards_Model extends CI_Model {
	
	public function getTable($client_id) {
		$query = $this->db->query(
				sprintf("SELECT DISTINCT ec.`status` as status, min(ec.id) as elevator_card_id, c.client_id as client_id, c.card_no as card_no ,   c.id as id, c.site_code as site_code, c.site_no as site_no, concat(adm.first_name, ' ' , adm.last_name) as created_by, concat(admn.first_name, ' ' , admn.last_name) as updated_by, c.floors as floor FROM `cards` c
					
					
					INNER JOIN admin adm on adm.id = c.created_by
					INNER JOIN admin admn on admn.id = c.updated_by
					inner join elevators_cards ec on ec.card_id = c.id
					WHERE `client_id` = %d GROUP BY ec.card_id "  ,  $client_id));
		
		return $query->result();
	}

	public function getTableEmployer($employer_id) {
		$query = $this->db->query(
				sprintf("SELECT ec.`status` as status, c.client_id as client_id, c.card_no as card_no ,   c.id as id, c.site_code as site_code, c.site_no as site_no, concat(adm.first_name, ' ' , adm.last_name) as created_by, concat(adm.first_name, ' ' , adm.last_name) as updated_by, c.floors as floor FROM `cards` c
					
					
					INNER JOIN admin adm on adm.id = c.created_by
					INNER JOIN admin admn on admn.id = c.updated_by
					inner join elevators_cards ec on ec.card_id = c.id
					WHERE `employer_id` = %d", $employer_id));
		
		return $query->result();
	}

	public function checkDuplicateCardNr($card_no){
		$result = $this->db->query("SELECT count(id) as exist FROM cards c WHERE c.card_no = '$card_no' and status = 0 ")->row();
		
		if ( $result->exist > 0) {
			return 1;
		} else {
			return 0;
		}
	}
	
/*
	public function checkDuplicateCardNr($card_no){
		$result = $this->db->query("SELECT count(id) as exist FROM cards c WHERE c.card_no= '$card_no' ")->row();
		
		if ( $result->exist > 0) {
			return 1;
		} else {
			return 0;
		}
	}
*/
	
	

	
	
	public function insertData($arr,$card_no) {
		$arr['create_date'] = time();
		$arr['update_date'] = $arr['create_date'];
		$arr['updated_by'] = $arr['created_by'];
		$access = $arr['access'];


		$status = 1;
		if($access == "0000000000000000" ){
			$access = $arr['conf'];
			$status = 0;	
		}
		

		unset($arr['access']);
		unset($arr['accessi']);
		unset($arr['conf']);
		$arr['update_no'] = 0;
		$arr['card_no'] = $card_no;

// 		print_r($arr);

		$query = $this->db->query("SELECT c.id as id, c.first_name as first_name, c.last_name as last_name from cards cr  inner join  clients c on c.id = cr.client_id where cr.card_no = ".$card_no."   ")->result_array();
		
		
		$queryEmp = $this->db->query("SELECT c.id as id, c.fname as first_name, c.lname as last_name from cards cr inner join  employer c on c.id = cr.employer_id where cr.site_code = ".$arr['site_code']." and cr.site_no = ".$arr['site_no']." limit 1")->result_array();
		
		
		
// 		echo $card_no;
		$getAccess = $this->getClientAccess($card_no);

		$session_data = $this->session->userdata ( 'logged_in' );
		$building_id = $getAccess[0]->building_id;
		
		

		
	
		if (self::checkDuplicateCardNr($card_no) >= 1) {
			if (in_array($building_id, $session_data['buildings']) && $session_data['level'] == 1 || $session_data['level'] == 2) {
				if($query[0]['id'] == "") {
					echo '<div style= "color:red">This card is already registered to <a href = " '.base_url() . 'index.php/cardsEmployer/index/'.$queryEmp[0]['id'].' "> '. $queryEmp[0]['first_name'] .' '.$queryEmp[0]['last_name'].'</a>.</div>';
				}
				else {
					echo '<div style= "color:red">This card is already registered to <a href = " '.base_url() . 'index.php/cards/index/'.$query[0]['id'].' "> '. $query[0]['first_name'] .' '.$query[0]['last_name'].'</a>.</div>';
				}
			} else {
				echo '<div style= "color:red">This card is already registered to another building/owner</a>.</div>';
			}
// 			redirect('clients', 'refresh');
			
			
			
			die;
		} else {
			$query = $this->db->insert('cards', $arr);
		}
		
		$cardID = $this->db->insert_id();
		$flat_id  = $this->getFlatID($arr['client_id']);
		$entry_id = $this->getEntryID($flat_id);
		
		$elevator_id =$this->getElevatorID($entry_id);

		$elevators_cards = array(	 
						 'card_id' => $cardID,
						  'elevator_id'=> $elevator_id,
						  'status' =>$status,
						  'created_by' => $arr['created_by'],
						  'create_date'=>time(), 
						  'updated_by' =>$arr['created_by'], 
						  'update_date' =>time(),
						  'update_no'=> 0,
						  'access' => $access
					);

		$this->db->insert('elevators_cards', $elevators_cards);

		
	}
	

	public function checkIfCardHasAccessInElevator($card_id, $elevator_id){

		$result = $this->db->query("SELECT count(id) as exist FROM elevators_cards ec WHERE ec.card_id = ' $card_id ' and ec.elevator_id = ' $elevator_id ' ")->row();

		if ( $result->exist > 0) {
			return 1;
		} else {
			return 0;
		}

	}

	public function cardOtherAccess($arr){
		$arr['create_date'] = time();
		$arr['update_date'] = $arr['create_date'];
		$arr['updated_by'] = $arr['created_by'];


		if(self::checkIfCardHasAccessInElevator($arr['card_id'],$arr['elevator_id']) == 1)
		{
			echo '<div style= "color:red">This card has already access in this entry </div>';
			$result = $this->db->query('UPDATE elevators_cards set updated_by = ' .$arr['updated_by']. ', update_date = ' .$arr['update_date']. ', access = \'' .$arr['access']. '\' where elevator_id = ' .$arr['elevator_id'].
				' and card_id = ' .$arr['card_id']);
			//echo $result;
			die;
		}

		$elevators_cards = array(	 
						 'card_id' => $arr['card_id'],
						  'elevator_id'=> $arr['elevator_id'],
						  'status' =>1,
						  'created_by' => $arr['created_by'],
						  'create_date'=>time(), 
						  'updated_by' =>$arr['created_by'], 
						  'update_date' =>time(),
						  'update_no'=> 0,
						  'access' => $arr['access']
					);

		$this->db->insert('elevators_cards', $elevators_cards);

	}

	public function insertDataEmployer($arr,$card_no) {
		$arr['create_date'] = time();
		$arr['update_date'] = $arr['create_date'];
		$arr['updated_by'] = $arr['created_by'];
		
		
		
		$arr['update_no'] = 0;
		$arr['card_no'] = $card_no;
		
		
// 		print_r($arr);
		
		$this->db->insert('cards', $arr);
		// $cardID = $this->db->insert_id();
		// $flat_id  = $this->getFlatID($arr['client_id']);
		// $entry_id = $this->getEntryID($flat_id);
		
		// $elevator_id =$this->getElevatorID($entry_id);

		// $elevators_cards = array(	 
		// 				 'card_id' => $cardID,
		// 				  'elevator_id'=> $elevator_id,
		// 				  'status' =>0,
		// 				  'created_by' => $arr['created_by'],
		// 				  'create_date'=>time(), 
		// 				  'updated_by' =>$arr['created_by'], 
		// 				  'update_date' =>time(),
		// 				  'update_no'=> 0
		// 			);

		// $this->db->insert('elevators_cards', $elevators_cards);
		
	}
	
	public function checkInsertedCard($card_id) {
		
		$result = $this->db->query("SELECT count(1) as exist FROM elevators_cards ec WHERE ec.card_id = '$card_no'")->row();
		
		if ( $result->exist > 0) {
			return 1;
		} else {
			return 0;
		}
		
		
	}

	public function insertCardsEmployer($arr,$card_id) {
	
		$data = array();
		foreach ($arr as $key => $value) {
			$data[] = array(
			      'card_id' => $value->card_id ,
			      'elevator_id' => $value->elevator_id ,
			      'status' =>1,
			      'access' => '1111111111111111',
			      'created_by' => $card_id,
			      'create_date'=>time(), 
			      'updated_by' =>$card_id, 
			      'update_date' =>time(),
			      'update_no'=> 0
			   );
		}
		
		$this->db->insert_batch('elevators_cards', $data);

		
		// $arr['create_date'] = time();
		// $arr['status'] = 1;
		// $arr['update_no'] = 0;
		// $arr['update_date'] = $arr['create_date'];
		// $arr['updated_by'] = $arr['created_by'];

		// $arr['update_no'] = 0;
		
	
		// print_r($elevators_cards);
		// $elevators_cards = array(	 
		// 				 'card_id' => $card_id,
		// 				  'elevator_id'=> $elevator_id,
		// 				  'status' =>1,
		// 				  'created_by' => $arr['created_by'],
		// 				  'create_date'=>time(), 
		// 				  'updated_by' =>$arr['created_by'], 
		// 				  'update_date' =>time(),
		// 				  'update_no'=> 0
		// 			);
		

		// $this->db->insert('elevators_cards', $elevators_cards);
		// $this->db->insert_batch('elevators_cards', $arr);
		
	}

	public function deleteCardsEmployer($card_id){
// 		$this->db->where('card_id',$card_id);
// 		$status = $this->db->delete('elevators_cards');

		$this->db->where('card_id', $card_id);
		$arr['status'] = 0;
		$arr['action'] = 3;
		$this->db->update('elevators_cards', $arr);
	}

	public function deleteEmployer($employerID){

		$this->db->where('id',$employerID);
		$this->db->delete('employer');

		$this->db->where('employer_id',$employerID);
		$this->db->delete('cards');
	}
	
	public function checkCardExists($card_no) {
		$result = $this->db->query("SELECT count(1) as exist FROM cards ec WHERE ec.card_no = '$card_no'")->row();
		
		if ( $result->exist > 0) {
			return 1;
		} else {
			return 0;
		}
		
	}
	
	public function getInfoExsist($card_no) {
		return $this->db->query("select card_no, client_id, first_name, last_name, fname, lname, employer.id as eid from cards LEFT JOIN clients ON client_id = clients.id  LEFT JOIN employer ON cards.employer_id = employer.id where card_no =  '$card_no'")->row_array();

	}



	public function checkIfExists($card_id,$elevator_id){
		$result = $this->db->query("SELECT count(id) as exist FROM elevators_cards ec WHERE ec.elevator_id = '$elevator_id' AND card_id = '$card_id' ")->row();
		
		if ( $result->exist > 0) {
			return 1;
		} else {
			return 0;
		}
	}

	public function getElevatorID($entry_id){
		    $this->db->select('id'); 
		    $this->db->from('elevators');   
		    $this->db->where('entry_id', $entry_id);
		    return $this->db->get()->row('id');
	}

	public function getFlatID($client_id){
		    $this->db->select('flat_id'); 
		    $this->db->from('clients');   
		    $this->db->where('id', $client_id);
		    return $this->db->get()->row('flat_id');
	}

	public function getEntryID($flat_id){
		    $this->db->select('entry_id'); 
		    $this->db->from('flats');   
		    $this->db->where('id', $flat_id);
		    return $this->db->get()->row('entry_id');
	}
	
	public function editData($arr,$card_no) {
		$id = $arr['id'];
		$access = $arr['access'];
		unset($arr['id']);
		unset($arr['access']);
		unset($arr['accessi']);
		unset($arr['conf']);
		
		$this->db->where('id', $id);
		$arr['update_date'] = time();
		$arr['card_no'] = $card_no;
		$this->db->update('cards', $arr);

		

		$this->db->where('card_id', $id);
		$arr2 = array("access" => $access);
		return $this->db->update('elevators_cards', $arr2);
	
	}

	public function checkPayment($client_id){
		return $this->db->query("SELECT * from payments where client_id = '$client_id' AND status = 1 AND year = YEAR(CURDATE())-1  order by month")->result_array();

	}

	public function checksPayments($client_id , $currentYear){
// 		return $this->db->query("SELECT * from payments where client_id = '$client_id' AND status = 1 AND year = '$currentYear' order by month")->result_array();
		return $this->db->query("SELECT * from payments where client_id = '$client_id' AND status = 1 AND year = '2015' order by month")->result_array();

	}

	public function checkPaymentNextYear($client_id){
		return $this->db->query("SELECT * from payments where client_id = '$client_id' AND status = 1 AND year = YEAR(CURDATE())  order by month")->result_array(); 
// 		return $this->db->query("SELECT * from payments where client_id = '$client_id' AND status = 1 AND year = YEAR(CURDATE())+1  order by month")->result_array(); 

	}

	public function getIMEI($entry_id){
		$query =  $this->db->query(" SELECT IMEI from elevators where entry_id = '$entry_id'  ")->result(); 
		echo json_encode($query);
	}
	
	public function getPaymentByMonth($client_id,$month){

		$month = $this->db->query("SELECT * FROM payments WHERE client_id = $client_id AND status = 1 AND MONTH = $month AND year = YEAR(CURDATE()) ");
		if ($month->num_rows() > 0) {
			return $month->result_array();
		} else {
			return 0;
		}
		

	}
	
	public function activateAll($client_id,$user_id){
	
		return $this->db->query( ' UPDATE elevators_cards set status = 1 , updated_by ='.$user_id.', update_date = '.time().'
			WHERE card_id IN (select id from cards where client_id = '.$client_id.') ');
	}

	public function deActivateAll($client_id,$user_id){
	
		return $this->db->query( ' UPDATE elevators_cards set status = 0 , updated_by = '.$user_id.', update_date =  '.time().'
			WHERE card_id IN (select id from cards where client_id = '.$client_id.') ');

	}
	
	public function changeStatus($id, $status,$updated_by) { 

		$query = $this->db->query("SELECT card_id from elevators_cards where id = ".$id." ")->result_array();
		$card_id = $query[0]['card_id'];

		$this->db->where('id', $card_id);
		$arr = array("updated_by" => $updated_by);
		$this->db->update('cards', $arr);       

		$this->db->where('card_id', $card_id);
		$arr2 = array("status" => $status, "updated_by" => $updated_by,"update_date" => time());
		
		//print_r($arr2);
				
		return $this->db->update('elevators_cards', $arr2);
	}
	


	public function delete($id,$user_id){

		$deletecard = $this->db->query("SELECT c.card_no FROM cards c WHERE c.id = $id ")->row();

	
		$arr3['card_no'] = $deletecard->card_no;
		$arr3['user_id'] = $user_id;
		$arr3['date'] = time();

		$this->db->insert('deleted_cards', $arr3);


		$this->db->where('card_id',$id);
		$status = $this->db->delete('elevators_cards');
		if ($status) {
			echo "Deleted";
		}
		else{
			echo "Could not be deleted";
		}

		
		$this->db->where('id',$id);
		$status = $this->db->delete('cards');
		if ($status) {
			echo "Deleted";
		}
		else{
			echo "Could not be deleted";
		}

		

	}
	
	
	public function changeAllStatus($clientID) {
		$this->db->query("update clients set status = 1 where id = $clientID");
		
		$resutls = $this->db->query("select id from cards where client_id = $clientID");
		
		
		foreach($resutls->result_array() as $res) {
			
			$this->db->query("update elevators_cards set status = 0 where card_id = ".$res['id']);
		}
		
		
		
		
	}
	
	
	public function getBuildingAdmin($id) {
		
		$query = $this->db->query("select clients.first_name, clients.last_name, flats.entry_id, entries.building_id, buildings.company_id from clients INNER JOIN flats ON flats.id = clients.flat_id 
		INNER JOIN entries ON entries.id = flats.entry_id
		INNER JOIN buildings ON buildings.id = entries.building_id where clients.status = 0 and clients.id = ".$id)->result();
		
		
		return $query;
		
	}
	
	public function getClientAccess($id) {
		
		$query = $this->db->query("select clients.first_name, clients.last_name, flats.entry_id, entries.building_id, buildings.company_id from clients INNER JOIN flats ON flats.id = clients.flat_id 
		INNER JOIN entries ON entries.id = flats.entry_id
		INNER JOIN buildings ON buildings.id = entries.building_id 
		INNER JOIN cards ON cards.client_id = clients.id where cards.status = 0 and cards.card_no = ".$id)->result();
		
		
		return $query;
		
	}
	
	public function deleteClientUpdate($clientID){


// 		$this->db->query("DELETE FROM flats where id = (SELECT flat_id from clients where id = $clientID) ");
		$result = mysql_query("select id from cards where client_id = $clientID OR employer_id = $clientID");
		$id = mysql_fetch_array($result);
		$id = $id['id'];
			
// 		$result = $this->db->query("select id from cards where client_id = $clientID OR employer_id = $clientID");


		$this->db->query("update cards set client_id = NULL, employer_id = NULL, card_no = CONCAT(card_no, $clientID) where id = $clientID");
		
		
		
		
		
		
// 		$this->db->query("update cards set client_id = NULL, employer_id = NULL, card_no = CONCAT(card_no, '2') where id = $clientID");
		
		
		
		$this->db->query("update elevators_cards set status = 0, action = 3 where card_id = $clientID");

		



// 		$this->db->where('client_id',$clientID);
// 		$this->db->delete('client_notes');

// 		$this->db->where('id',$clientID);
// 		$this->db->delete('clients');

// 		$this->db->where('client_id',$clientID);
// 		$this->db->delete('cards');




	}

	public function cancel_payment($id,$note){
		$data = array(
		               'status' => 2,
		               'note' => preg_replace('/<[^>]*>/', '', str_replace('%20', ' ', $note))
		            );

		$this->db->where('id', $id);
		$status = $this->db->update('payments', $data); 

		if ($status) {
			echo "Deleted";
		}
		else{
			echo "Could not be deleted";
		}

	}

	public function getNotes($client_id){
	
		return $this->db->query(" SELECT cn.id as id, cn.created_by as created_by, CONCAT(a.first_name,' ', a.last_name) as admin,cn.`comment` as comment FROM client_notes cn 
						INNER JOIN admin a on a.id = cn.created_by 
						WHERE cn.client_id = '$client_id' order by id asc")->result();
	}

	public function insertNotes($arr){

		$this->db->where('client_id',$arr['client_id']);
		$this->db->insert('client_notes', $arr);
	}

	public function deleteNote($note_id){

		$this->db->where('id',$note_id);
		$status = $this->db->delete('client_notes');
	}

	public function getAccess($id){

		  $query = $this->db->query(" SELECT REVERSE(access) as access FROM elevators_cards WHERE card_id = '$id' ")->result();
		  echo json_encode($query);

	}

	public function getFloorsElevator($imei){

		  $query = $this->db->query("select * from Configuration where IMEI = '$imei' ")->result();
		  return $query;

	}

	public function getImeiEntry($entry_id){

		  $query = $this->db->query("select * from elevators where entry_id = '$entry_id' ")->result();
		  return $query;

	}


	public function getClientImei($client_id){

		  $query = $this->db->query("SELECT el.IMEI as imei
					                          FROM clients k
					                          INNER JOIN flats f ON k.flat_id = f.id
					                          INNER JOIN entries e ON f.entry_id = e.id 
					                          INNER JOIN buildings b ON e.building_id = b.id
					                          INNER JOIN companies c ON b.company_id = c.id
					                          INNER JOIN elevators el on el.entry_id = e.id
					                          WHERE k.`id` = '$client_id' ")->result();
		  return $query;
		
	}

	public function getClientNote($client_id){

		  $query = $this->db->query("SELECT e.notes as notes
					                          FROM clients k
					                          INNER JOIN flats f ON k.flat_id = f.id
					                          INNER JOIN entries e ON f.entry_id = e.id 
					                          INNER JOIN buildings b ON e.building_id = b.id
					                          INNER JOIN companies c ON b.company_id = c.id
					                          INNER JOIN elevators el on el.entry_id = e.id
					                          WHERE k.`id` = '$client_id' ")->result();
		  return $query;
		
	}

	public function changeAccessConfigForAllCards($IMEI){

		 $query = $this->db->query("SELECT *
							FROM elevators_cards ec
							WHERE ec.card_id IN(
							SELECT c.id AS card_id
							FROM cards c
							INNER JOIN clients cli ON cli.id = c.client_id
							INNER JOIN flats f ON f.id = cli.flat_id
							INNER JOIN entries e ON e.id = f.entry_id
							INNER JOIN elevators el ON el.entry_id = e.id
							WHERE el.IMEI = ".$IMEI." ) ")->result();
		 return $query;
	}

	public function updateAccessConfig($id,$access){

		$data = array(
	               'access' => $access
	            );

		$this->db->where('id', $id);
		$this->db->update('elevators_cards', $data); 
	}

	public function getCardAccess($card_id){

		 $query = $this->db->query(" SELECT e.entry_id as entryId, en.name as entryName, b.name as buildingName from elevators_cards ec
						inner join elevators e on e.id = ec.elevator_id
						inner join entries en on en.id = e.entry_id
						inner join buildings b on b.id = en.building_id
						where card_id = ". $card_id ."  AND ec.status = 1  ")->result();
		 return $query;

	}

	public function deleteCardAccess($entry_id,$card_id){
	
		$query = $this->db->query("SELECT id from elevators where entry_id = ".$entry_id." ")->result_array();
		$elevator_id = $query[0]['id'];

		

		$this->db->where('elevator_id',$elevator_id);
		$this->db->where('card_id',$card_id);
		$this->db->delete('elevators_cards'); 

	  	return $this->db->query(" SELECT e.entry_id as entryId, en.name as entryName, b.name as buildingName from elevators_cards ec
						inner join elevators e on e.id = ec.elevator_id
						inner join entries en on en.id = e.entry_id
						inner join buildings b on b.id = en.building_id
						where card_id = ". $card_id ."  AND ec.status = 1 ")->result();
	}
	
	public function getExpiredDate($client_id) {
		

		  $query = $this->db->query("select MAX(payments.to) as p_to from payments where client_id = $client_id and status= 1")->row();
		  return $query;

		
	}

	
}
?>