<?php
class Entries_Model extends CI_Model {
	public function getTable($building_id) {
		$query = $this->db->query(
				sprintf("select e.id, e.name, elev.IMEI, concat(a.`first_name`,' ',a.`last_name`) as created_by, concat(u.`first_name`,' ',u.`last_name`) as updated_by,
									FROM_UNIXTIME(e.`create_date`) as `create_date`,
									FROM_UNIXTIME(e.`update_date`) as `update_date`,
									(SELECT COUNT(*) FROM logs WHERE time/1000 > UNIX_TIMESTAMP() - 86400 AND IMEI = elev.IMEI) as acs
									from entries e
									inner join admin a ON e.created_by = a.id
									left join admin u ON e.updated_by = u.id
									left join elevators elev on elev.entry_id = e.id
									where e.status = 0 and building_id = %s", $building_id));
		
		return $query->result();
	}
	
	public function insertData($arr) {
		$arr['create_date'] = time();
		$arr['update_date'] = $arr['create_date'];
		$arr['updated_by'] = $arr['created_by'];
		
		$this->db->insert('entries', $arr);
		$lastID = $this->db->insert_id();

		$arr2 = array('name' => $this->input->post('name'), 'status' => 1, 'IMEI'=>$this->input->post('imei'), 'phone_no' =>$this->input->post('phone_no'), 'entry_id'=>$lastID,'flag'=>1,'created_by'=>$arr['created_by']);

		$this->db->insert('elevators', $arr2);
		
		$last_id = $this->db->insert_id();
		return $last_id;
	}
	
	

	
	public function editData($arr) {
		
		$building_id = $arr['building_id'];
		// unset($arr['tel']);
		unset($arr['building_id']);

		for ($i=1; $i <17 ; $i++) { 

			unset($arr['rfidName'.$i.'']);
			unset($arr['rfidPulse'.$i.'']);
			unset($arr['rfid[]']);
			unset($arr['rfid']);
		}

		//print_r($arr);
		$this->db->where('elevators.id', $arr['id']);
		$this->db->update('elevators', $arr);
		unset($arr['phone_no']);
		
		$entry_id =  $this->db->select('entry_id')
			->from('elevators')
			->where('elevators.id', $arr['id'])
			->get()
			->row('entry_id');

		unset($arr['id']);
		unset($arr['imei']);

		$this->db->where('id', $entry_id);
		$arr['update_date'] = time();
		$arr['building_id'] = $building_id;
		$this->db->update('entries', $arr);
	}
	
	public function deleteData($id) {                                                
		$this->db->where('id', $id);
		return $this->db->delete('entries');
	}
	
	public function selectAllHK($id) {
		
		return $this->db->query('select cards.id, card_no, site_code, employer.id as emp_id, employer_id from employer JOIN cards ON employer.id = employer_id where employer.`status` = 1')->result_array();
	
	}
	
	public function insertNewCard($employer_id, $elevator_id) {
		$arr = 
	  array('card_id'=>  $employer_id,
			'elevator_id'=> $elevator_id,
			'status'=> 1 ,
			'created_by'=> 1 ,
			'create_date'=> time(),
			'updated_by'=> 3,
			'update_date'=> '' ,
			'update_no'=>0,
			'access'=>'1111111111111111',
			'action'=>1,
			'ack_fromBoard'=>0
			);
// 			print_r($arr);
		 $this->db->insert('elevators_cards', $arr);
		
	}

	public function deleteEntry($id) { 

		$this->db->where('entry_id', $id);
		$this->db->delete('elevators');        
		                                       
		$this->db->where('id', $id);
		$this->db->delete('entries');
	}
	
	public function updateEntry($entry_id) {
		
		
		$this->db->query('UPDATE entries SET status = 1 where id = '.$entry_id);
		
		$this->db->query('UPDATE elevators_cards SET status = 0 , updated_by = '.$updated_by.' , update_date = '. time() .' WHERE elevator_id  = ( SELECT id FROM elevators where entry_id = '.$entry_id.' ) ');
		
		
		
	}
	
	public function getCities() {
		return $this->db->query('SELECT * FROM `cities`')->result_array();
	}	

	public function get_monitor($imei,$startTime, $endTime){
		
		$this->db->select(" FROM_UNIXTIME(logs.time / 1000  ) as time , logs.description");
		$this->db->where('logs.IMEI', $imei);
		$this->db->where('logs.time >= ', strtotime($startTime) * 1000 );
		$this->db->where('logs.time <= ', strtotime($endTime) * 1000 );
		$this->db->order_by('logs.time', 'desc'); 

		// echo "start time: " .  strtotime($startTime);
		
		return $this->db->get('logs')->result_array();

	}

	public function get_checkins($imei,$startTime, $endTime){
		
		$this->db->select("CheckIn.SiteCode as siteCode ,CheckIn.Valid as Valid, CheckIn.SiteNo as siteNo, CheckIn.floor as floor, FROM_UNIXTIME(CheckIn.timestamp) as time");
		$this->db->where('CheckIn.IMEI', $imei);
		$this->db->where('CheckIn.timestamp >= ', strtotime($startTime) );
		$this->db->where('CheckIn.timestamp <= ', strtotime($endTime) );
		$this->db->order_by('CheckIn.timestamp', 'desc'); 
		
		return $this->db->get('CheckIn')->result_array();

	}

	public function configuration($data){
		$this->db->where('IMEI', $data['IMEI']);
		$this->db->delete('Configuration'); 

		$this->db->insert('Configuration', $data); 
	}

	public function checkIMEI($imei){

		 $query = $this->db->get_where('elevators', array('IMEI' => $imei));

		        $count = $query->num_rows(); //counting result from query

		        if ($count === 0) {
		          return false;
		        }else{
		        	return true;
		        }
	}

	public function checkIMEIConfiguration($imei){

		 $query = $this->db->get_where('Configuration', array('IMEI' => $imei));

		        $count = $query->num_rows(); //counting result from query

		        if ($count === 0) {
		          return false;
		        }else{
		        	return true;
		        }
	}

	public function checkEntryName($entry_name,$building_id){

		 $query = $this->db->get_where('entries', array('name' => $entry_name, 'building_id' => $building_id));

		        $count = $query->num_rows(); //counting result from query

		        if ($count === 0) {
		          return false;
		        }else{
		        	return true;
		        }
	}

	public function informationIMEI($imei){
		$this->db->select('elevators.IMEI as imei, elevators.name entry, buildings.name as building');
		$this->db->from('elevators');
		$this->db->join('entries', 'entries.id = elevators.entry_id');
		$this->db->join('buildings', 'buildings.id = entries.building_id');
		$this->db->where('IMEI', $imei);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getRelayTimer($relayTimer,$imei){
		    $this->db->select($relayTimer); 
		    $this->db->from('Configuration');   
		    $this->db->where('IMEI', $imei);
		    return $this->db->get()->row('id');
	}
	
	public function getRelayTimer2($relayTimer,$imei){
		    $this->db->select("Relay1_tmr,Relay2_tmr,Relay3_tmr,Relay4_tmr,Relay5_tmr,Relay6_tmr,Relay7_tmr,Relay8_tmr,Relay9_tmr,Relay10_tmr,Relay11_tmr,Relay12_tmr,Relay13_tmr,Relay14_tmr,Relay15_tmr,Relay16_tmr"); 
		    $this->db->from('Configuration');   
		    $this->db->where('IMEI', $imei);
		    return $this->db->get()->row('id');
	}


	public function getImeiConfiguration($imei){
		    $arr = array();
		    if (!self::checkIMEIConfiguration($imei)) {
		    	$arr['IMEI'] = $imei;
		    	$this->db->insert('Configuration', $arr);
		    }

		    $this->db->select('Configuration.*'); 
		    $this->db->from('Configuration');   
		    $this->db->where('IMEI', $imei);
		    $query = $this->db->get();
		    return $query->result_array();
	}

	public function deactivateCardsForEntry($entry_id,$updated_by){
		return $this->db->query('UPDATE elevators_cards SET status = 0 , updated_by = '.$updated_by.' , update_date = '. time() .' WHERE elevator_id  = ( SELECT id FROM elevators where entry_id = '.$entry_id.' ) ')->result_array();
	}

	

}
?>