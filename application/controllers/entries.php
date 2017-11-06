<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Entries extends CI_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'entries_model' );
		$this->load->model ( 'cards_model' );
		
	}
	
	function breadcrumb($building_id) {
		$r = $this->db->query("SELECT 
													b.`name` as `building_name`,
													c.`name` as `company_name`
													FROM buildings b 
													INNER JOIN companies c ON b.company_id = c.id
													WHERE b.`id` = ".$building_id)->result_array();
		
		return "Ballina > " . $r[0]['building_name'];
	}	
	
	public function index($building_id) {
		
		if ($this->session->userdata ( 'logged_in' )) {
			$session_data = $this->session->userdata ( 'logged_in' );
// 			print_r($session_data['buildings']);
// 			echo $building_id;
			if (!in_array($building_id, $session_data['buildings']) && $session_data['level'] == 3) {
			 	redirect('buildings/', 'refresh');
			}
			$data ['username'] = $session_data ['name'];
			$data ['id'] = $session_data ['id'];
			$output ['level'] = $session_data ['level'];
			
			$output ['entries'] = $this->entries_model->getTable($building_id);
			$output ['cities'] = $this->entries_model->getCities();
			
			$output ['breadcrumb'] = $this->breadcrumb($building_id);
			$output ['building_id'] = $building_id;
			
			$data['output'] = $this->load->view('entries', $output, true);
			
			$this->load->view('template', $data);
		} else {
			redirect('login', 'refresh');
		}
	}
	
	public function insert() {
		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];

			$_REQUEST['created_by'] = $session_data ['id'];
			// unset($_REQUEST['id']);

			$arr = array('name' => $_REQUEST['name'], 'building_id'=>$_REQUEST['building_id'], 'created_by'=>$session_data ['id']);
// 			print_r($arr);
			$lastid = $this->entries_model->insertData($arr);
			 			
			$selectHKEmployee = $this->entries_model->selectAllHK(1);
// 			print_r($selectHKEmployee);
			foreach($selectHKEmployee as $shk) {
				$this->entries_model->insertNewCard($shk['id'], $lastid);
// 				echo $shk['fname']."<br>";
			}
			
			
			redirect('entries/index/'.$_REQUEST['building_id'], 'refresh');
		} else {
			redirect('login', 'refresh');
		}
	}

	
	public function edit() {
		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
		
			$_REQUEST['updated_by'] = $session_data ['id'];
		
			
			$this->entries_model->editData($_REQUEST);
			//print_r($_REQUEST);
				
			redirect('entries/index/'.$_REQUEST['building_id'], 'refresh');
		} else {
			redirect('login', 'refresh');
		}
	}
	
	public function delete() {
		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
		
			$_REQUEST['updated_by'] = $session_data ['id'];
		
			$this->entries_model->deleteData($_REQUEST['id']);
		
			redirect('entries', 'refresh');
		} else {
			redirect('login', 'refresh');
		}
	}

	public function getIMEI($entry_id){
		 $this->cards_model->getIMEI($entry_id);
	}

	public function get_monitor($imei,$startTime, $endTime){
		 echo json_encode($this->entries_model->get_monitor($imei,$startTime, $endTime));
	}

	public function get_checkins($imei,$startTime, $endTime){
		 echo json_encode($this->entries_model->get_checkins($imei,$startTime, $endTime));
	}

	public function ajax($id) {
		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
	
			$result = $this->db->select('*')
			->from('entries')
			->where('entries.id', $id)
			->join('elevators', 'elevators.entry_id = entries.id')
			->get()
			->row();
			
			echo json_encode($result);
			
		} else {
			redirect('login', 'refresh');
		}
	}

	public function deleteEntry($entry_id){
		$this->entries_model->deleteEntry($entry_id);
	}
	
	public function updateEntry($entry_id){
// 		echo $entry_id;		

// 		$this->deactivateCardsForEntry($entry_id);
		$this->entries_model->updateEntry($entry_id);
		
		header("Refresh:0");

	}

	public function configuration(){

		$data = array(
		   'IMEI' => $_POST['imei'] ,
		   'RFID1_ToRelays' => $_POST['rfid1ToRelays'],
		   'RFID2_ToRelays' => $_POST['rfid2ToRelays'],
		   'RFID3_ToRelays' => $_POST['rfid3ToRelays'],
		   'RFID4_ToRelays' => $_POST['rfid4ToRelays'],
		   'RFID5_ToRelays' => $_POST['rfid5ToRelays'],
		   'RFID6_ToRelays' => $_POST['rfid6ToRelays'],
		   'RFID7_ToRelays' => $_POST['rfid7ToRelays'],
		   'RFID8_ToRelays' => $_POST['rfid8ToRelays'],
		   'RFID9_ToRelays' => $_POST['rfid9ToRelays'],
		   'RFID10_ToRelays' => $_POST['rfid10ToRelays'],
		   'RFID11_ToRelays' => $_POST['rfid11ToRelays'],
		   'RFID12_ToRelays' => $_POST['rfid12ToRelays'],
		   'RFID13_ToRelays' => $_POST['rfid13ToRelays'],
		   'RFID14_ToRelays' => $_POST['rfid14ToRelays'],
		   'RFID15_ToRelays' => $_POST['rfid15ToRelays'],
		   'RFID16_ToRelays' => $_POST['rfid16ToRelays'],
		   'Relay1_Name' => $_POST['RFID1_Name'],
		   'Relay2_Name' => $_POST['RFID2_Name'],
		   'Relay3_Name' => $_POST['RFID3_Name'],
		   'Relay4_Name' => $_POST['RFID4_Name'],
		   'Relay5_Name' => $_POST['RFID5_Name'],
		   'Relay6_Name' => $_POST['RFID6_Name'],
		   'Relay7_Name' => $_POST['RFID7_Name'],
		   'Relay8_Name' => $_POST['RFID8_Name'],
		   'Relay9_Name' => $_POST['RFID9_Name'],
		   'Relay10_Name' => $_POST['RFID10_Name'],
		   'Relay11_Name' => $_POST['RFID11_Name'],
		   'Relay12_Name' => $_POST['RFID12_Name'],
		   'Relay13_Name' => $_POST['RFID13_Name'],
		   'Relay14_Name' => $_POST['RFID14_Name'],
		   'Relay15_Name' => $_POST['RFID15_Name'],
		   'Relay16_Name' => $_POST['RFID16_Name'],
		   'Relay1_tmr' => $_POST['RFID1_tmr'] * 10,
		   'Relay2_tmr' => $_POST['RFID2_tmr'] * 10,
		   'Relay3_tmr' => $_POST['RFID3_tmr'] * 10,
		   'Relay4_tmr' => $_POST['RFID4_tmr'] * 10, 
		   'Relay5_tmr' => $_POST['RFID5_tmr'] * 10,
		   'Relay6_tmr' => $_POST['RFID6_tmr']* 10,
		   'Relay7_tmr' => $_POST['RFID7_tmr']* 10,
		   'Relay8_tmr' => $_POST['RFID8_tmr']* 10,
		   'Relay9_tmr' => $_POST['RFID9_tmr']* 10,
		   'Relay10_tmr' => $_POST['RFID10_tmr']* 10,
		   'Relay11_tmr' => $_POST['RFID11_tmr']* 10,
		   'Relay12_tmr' => $_POST['RFID12_tmr']* 10,
		   'Relay13_tmr' => $_POST['RFID13_tmr']* 10,
		   'Relay14_tmr' => $_POST['RFID14_tmr']* 10,
		   'Relay15_tmr' => $_POST['RFID15_tmr']* 10,
		   'Relay16_tmr' => $_POST['RFID16_tmr']* 10

		);

		$this->entries_model->configuration($data);
	}

	public function checkIMEI($imei){
		$result = $this->entries_model->checkIMEI($imei);
		$info = $this->entries_model->informationIMEI($imei);

		$checkIfEntryExist = $this->entries_model->checkEntryName($_POST['entry_name'], $_POST['building_id']);
		
		if ($result) {
			echo  json_encode( array('statusi' => 1, 'info' =>$info));
		}  else if($checkIfEntryExist){
			echo  json_encode( array('statusi' => 2, 'msg' => "This entry name already exist on this building."));
			exit;
		}
			else {
			echo  json_encode( array('statusi' => 0));
		}
		
	}

	public function getRelayTimer($seconds,$imei){
		echo json_encode($this->entries_model->getRelayTimer2("Relay" . $seconds . "_tmr",$imei));
	}

	public function getImeiConfiguration($imei){
		echo json_encode($this->entries_model->getImeiConfiguration($imei));
	}
	public function deactivateCardsForEntry($entry_id){
		

		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
	
			$this->entries_model->deactivateCardsForEntry($entry_id,$session_data ['id']);
			
		} else {
			redirect('login', 'refresh');
		}

	}

}