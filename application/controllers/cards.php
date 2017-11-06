<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Cards extends CI_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'cards_model' );
		$this->load->model ( 'buildings_model' );
		$this->load->model ( 'clients_model' );
		$this->load->model ( 'payments_model' );
		$this->load->helper('language');
		$this->lang->load('en', 'english');
	}
	
	function breadcrumb($client_id) {
		$r = $this->db->query("SELECT 
                          CONCAT(k.`first_name`,  ' ', k.`last_name`) as `client_name`, f.number as 'number', e.id as entryID, b.id as buildingID,
                          e.`name` as `entry_name`,
                          b.`name` as `building_name`,
                          c.`name` as `company_name`
                          FROM clients k
                          INNER JOIN flats f ON k.flat_id = f.id
                          INNER JOIN entries e ON f.entry_id = e.id 
                          INNER JOIN buildings b ON e.building_id = b.id
                          INNER JOIN companies c ON b.company_id = c.id
                          WHERE k.`id` = ".$client_id)->result_array();
		
		return   "<a href=''>" . $r[0]['company_name'] . " </a>> " . 
													"<a href='http://213.163.123.246/lift_new/index.php/entries/index/".$r[0]['buildingID']."'>   " .$r[0]['building_name'] . " </a>> " .  
													"<a href='http://213.163.123.246/lift_new/index.php/clients/flatsByEntry/".$r[0]['entryID']."'>   " .$r[0]['entry_name'] . " </a>> " .  
													 "". $r[0]['client_name'] . " ".
													"(Banesa Nr: ".$r[0]['number'] . ")";


	}
	

	function getClientInfo($client_id) {
		$r = $this->db->query("SELECT 
                          CONCAT(k.`first_name`,  ' ', k.`last_name`) as `client_name`, 
                          e.`name` as `entry_name`,
                          b.`name` as `building_name`,
                          c.`name` as `company_name`
                          FROM clients k
                          INNER JOIN flats f ON k.flat_id = f.id
                          INNER JOIN entries e ON f.entry_id = e.id 
                          INNER JOIN buildings b ON e.building_id = b.id
                          INNER JOIN companies c ON b.company_id = c.id
                          WHERE k.`id` = ".$client_id)->result_array();
			
		return $r[0]['company_name']  ."," . $r[0]['building_name'] ."," . $r[0]['entry_name'] . ",".$r[0]['client_name'];


	}

	public function activateAll($client_id){
		if ($this->session->userdata ( 'logged_in' )) {
			$session_data = $this->session->userdata ('logged_in');
			$this->cards_model->activateAll($client_id,$session_data ['id']);
		}else {
			redirect('login', 'refresh');
		}

	}

	public function deActivateAll($client_id){
		if ($this->session->userdata ( 'logged_in' )) {
			$session_data = $this->session->userdata ('logged_in');
			$this->cards_model->deActivateAll($client_id,$session_data ['id']);
		}else {
			redirect('login', 'refresh');
		}

	}

	public function index($client_id) {
		if ($this->session->userdata ('logged_in')) {
			error_reporting(0);
			$session_data = $this->session->userdata ( 'logged_in' );
			
			
			
			$checkBuilding = $this->cards_model->getBuildingAdmin($client_id);
			
			$building_id = $checkBuilding[0]->building_id;

		

			if (!in_array($building_id, $session_data['buildings']) && $session_data['level'] == 3) {
			 	redirect('buildings/', 'refresh');
			}


// 			echo $session_data['id'];
			$data ['username'] = $session_data ['name'];
			$data ['id'] = $session_data ['id'];
			$data ['level'] = $session_data ['level'];
			$output ['level'] = $session_data ['level'];
			$output ['monthly_price'] = $this->clients_model->getMonthlyPrice($client_id);
			$getImei = $this->cards_model->getClientImei($client_id);
			$imei = $getImei[0]->imei;
			$output['ClientNotefromEntry'] = $this->cards_model->getClientNote($client_id);
			$output['floors'] = $this->cards_model->getFloorsElevator($imei);
			
			
//			$output ['payments'] = $this->cards_model->checkPayment($client_id);
			$output ['getPaymentsCurrentYear'] = $this->cards_model->checkPayment($client_id);
// 			$output ['getPaymentsCurrentYear'] = $this->cards_model->checksPayments($client_id, 1);
			$output ['getPaymentsNextYear'] = $this->cards_model->checkPaymentNextYear($client_id);
			
			
			$output ['client_id'] = $client_id;

			$output ['breadcrumb'] = $this->breadcrumb($client_id);
			
			$clientInfo = explode(",", $this->getClientInfo($client_id));
			$output ['user_id'] = $session_data ['id'];
			$output ['clientCompany']  = $clientInfo[0];
			$output ['clientBuilding']  = $clientInfo[1];
			$output ['clientEntry']  = $clientInfo[2];
			$output ['clientName']  = $clientInfo[3];	
			$output['notes'] = $this->cards_model->getNotes($client_id);
			$output['clientId'] = $client_id;
			$output['paymentHistory'] = $this->payments_model->paymentRaportClient($client_id);
			
			if($data ['level'] == 3) {
				$output ['buildingsList'] = $this->buildings_model->getBuildingsLvl3($data ['id']);
			}
			else {
				$output ['buildingsList'] = $this->buildings_model->getBuildings();
			}

			$output ['entriesList'] = $this->buildings_model->getEntries();

			//Give access cards to more than one entry 
			$output['companies'] = $this->db->query("SELECT id, name FROM `companies`")->result_array();
			$output['cards'] = $this->db->query("SELECT  c.card_no as card_no ,   c.id as id, c.site_code as site_code, c.floors as floors,c.site_no as site_no, concat(adm.first_name, ' ' , adm.last_name) as created_by, concat(adm.first_name, ' ' , adm.last_name) as updated_by FROM `cards` c
											INNER JOIN admin adm on adm.id = c.created_by
											INNER JOIN admin admn on admn.id = c.updated_by 
											where client_id = '$client_id'")->result();

			//var_dump($output['cards']);

			$output ['cards'] = $this->cards_model->getTable($client_id);
			//var_dump($output['cards']);
			$output['expired_date'] = $this->cards_model->getExpiredDate($client_id);
			
			$output['buildings'] = array();
			$output['entries'] = array();
			
			foreach($output['companies'] as $company) {
				$buildings = $this->db->query("SELECT id, name FROM `buildings` WHERE company_id=".$company['id'])->result_array();
				$output['buildings'][$company['id']] = array();
				foreach ($buildings as $building) {
					$output['buildings'][$company['id']][] = $building;
					$entries = $this->db->query("SELECT e.id as elevatorID, entry.id as id, entry.name as name FROM `entries` entry 
									INNER JOIN elevators e on e.entry_id  = entry.id
									WHERE building_id=".$building['id'])->result_array();
					$output['entries'][$building['id']] = array();
					foreach ($entries as $entry) {
						$output['entries'][$building['id']][] = $entry;
					}
				}
			}
			//end


			$totali = array();
			$total = 0;
			foreach ($output['paymentHistory'] as $key => $value) {
				$total = $total + $value->paguar;
			}
			// echo $total;
			$output['total'] = $total;
			$data['output'] = $this->load->view('cards', $output, true);
			$this->load->view('template', $data);
		} else {
			redirect('login', 'refresh');
		}
	}


	public function byYears($client_id , $currentYear ){
		$payments = $this->cards_model->checksPayments($client_id , $currentYear);
		echo json_encode($payments);
	}
	
	public function getPaymentByMonth($clientId,$month){
		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
			$data ['monthlyPayment'] = $this->cards_model->getPaymentByMonth($clientId,$month);
			// echo "<pre>", print_r($data ['monthlyPayment'] ) ."</pre>";
			// redirect('payments', 'refresh');
		} else {
			redirect('login', 'refresh');
		}
	}

	public function insert() {
		error_reporting(0);
		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
			$_REQUEST['created_by'] = $session_data ['id'];
			
			
			unset($_REQUEST['id']);
			$card_no =  self::generateCardNo($_REQUEST['site_code'], $_REQUEST['site_no']);
			$this->cards_model->insertData($_REQUEST,$card_no);
			
			// redirect('clients', 'refresh');
			redirect('cards/index/'.$_REQUEST['client_id'].'', 'refresh');
		} else {
			redirect('login', 'refresh');
		}
	}

	public function insertCardsEmployer() {
		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
			$card_id = $session_data ['id'];
			$arr['created_by'] = $session_data ['id'];
			$data = json_decode($_POST['myjson']);
			
			$this->cards_model->insertCardsEmployer($data,$card_id);
			
			// redirect('clients', 'refresh');
			// redirect('cards/index/'.$_REQUEST['client_id'].'', 'refresh');
		} else {
			redirect('login', 'refresh');
		}
	}

	public function deleteCardsEmployer($card_id) {
		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
			echo $card_id;
			$this->cards_model->deleteCardsEmployer($card_id);
			} else {
			redirect('login', 'refresh');
		}
		
	}
	

	public function insertEmployer() {
		if ($this->session->userdata ('logged_in')) {
			
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
			$_REQUEST['created_by'] = $session_data ['id'];
			unset($_REQUEST['id']);
			$card_no =  self::generateCardNo($_REQUEST['site_code'], $_REQUEST['site_no']);
// 			print_r($_REQUEST);
			$card_exists = self::checkCardExists($card_no);
			print_r($card_exists);
			if($card_exists == 0) {
				
			$this->cards_model->insertDataEmployer($_REQUEST,$card_no);
			redirect('cardsEmployer/index/'.$_REQUEST['employer_id'].'', 'refresh');
				
			}
			else {
				echo "Exists";
			}
			
		} else {
			redirect('login', 'refresh');
		}
	}

	public function checkIfExists($card_id,$elevator_id){
		echo  json_encode($this->cards_model->checkIfExists($card_id,$elevator_id)) ;
	}
	
	public function checkCardExists($card_no) {
		return  json_encode($this->cards_model->checkCardExists($card_no)) ;
	}
	public function checkCardExistsSC($site_code, $site_no) {
		$card_no =  self::generateCardNo($site_code, $site_no);
		$card_info = $this->cards_model->getInfoExsist($card_no);
// 		print_r($card_info);
		$fname = $card_info['first_name'];
// 		echo $fname;
		if($fname == "") {
			echo  json_encode($this->cards_model->checkCardExists($card_no))."+".$card_info['eid']."+".$card_info['fname']."+".$card_info['lname']."+2";
		}
		else {
			echo  json_encode($this->cards_model->checkCardExists($card_no))."+".$card_info['client_id']."+".$card_info['first_name']."+".$card_info['last_name']."+1";
		}
		
	}
	
	public function edit() {
		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
		
			$_REQUEST['updated_by'] = $session_data ['id'];
			$card_no =  self::generateCardNo($_REQUEST['site_code'], $_REQUEST['site_no']);
			$this->cards_model->editData($_REQUEST,$card_no);
			
			redirect('cards/index/'.$_REQUEST['client_id'].'', 'refresh');
		} else {
			redirect('login', 'refresh');
		}
	}
	
	public function status($id, $status) {
		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$this->cards_model->changeStatus($id, $status, $session_data ['id']);
			
		} else {
			redirect('login', 'refresh');
		}
	}
	
	public function ajax($id) {
		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
	
			$result = $this->db->select('*')
			->from('cards')
			->where('id', $id)
			->get()
			->row();
			echo json_encode($result);
		} else {
			redirect('login', 'refresh');
		}
	}


	public function deleteClientUpdate($clientID){
		$this->cards_model->deleteClientUpdate($clientID);
	}

	public function delete($cardId){

		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
			$data ['id'] = $session_data ['id'];
	
	
			$this->cards_model->delete($cardId,$data ['id']);
		} else {
			redirect('login', 'refresh');
		}

		
	}

	public function cancel_payment($payment_id,$note){

		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
	
			$this->cards_model->cancel_payment($payment_id,$note);
			
		} else {
			redirect('login', 'refresh');
		}

		
	}

	public function generateCardNo($siteCode,$siteNo){

		 $card_no = ($siteCode << 16) | $siteNo;
		return  $card_no;

	}

	public function insertNotes($client_id){
		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$_REQUEST['created_by'] = $session_data ['id'];
			$_REQUEST['client_id'] = $client_id;
			$_REQUEST['comment'] = $_REQUEST['comment'];
			$this->cards_model->insertNotes($_REQUEST);
			redirect('cards/index/'.$_REQUEST['client_id'].'', 'refresh');
		} else {
			redirect('login', 'refresh');
		}

		
	}

	public function deleteNote($note_id){
		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$_REQUEST['created_by'] = $session_data ['id'];
			$_REQUEST['client_id'] = $client_id;
			$this->cards_model->deleteNote($note_id);
			// redirect('cards/index/'.$_REQUEST['client_id'].'', 'refresh');
		} else {
			redirect('login', 'refresh');
		}

		
	}

	public function cardOtherAccess(){

		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
			$_REQUEST['created_by'] = $session_data ['id'];
			$this->cards_model->cardOtherAccess($_REQUEST);
			
			// redirect('clients', 'refresh');
			// redirect('cards/index/'.$_REQUEST['client_id'].'', 'refresh');
		} else {
			redirect('login', 'refresh');
		}


		
	}
	public function getCardAccess($card_id){

		if ($this->session->userdata ('logged_in')) {
			echo  json_encode( $this->cards_model->getCardAccess($card_id));	
		} else {
			redirect('login', 'refresh');
		}

		
	}

	public function deleteCardAccess($entry_id,$card_id){
		echo json_encode($this->cards_model->deleteCardAccess($entry_id,$card_id) );
	}


	public function getAccess($id){
		$this->cards_model->getAccess($id);
	}
	public function getFloorsElevator($imei){
		echo  json_encode( $this->cards_model->getFloorsElevator($imei));	
	}

	public function getImeiEntry($entry_id){
		echo json_encode($this->cards_model->getImeiEntry($entry_id));
	}

	public function changeAccessConfigForAllCards($IMEI){
		echo json_encode($this->cards_model->changeAccessConfigForAllCards($IMEI));
	}

	public function updateAccessConfig($id,$access){
		$this->cards_model->updateAccessConfig($id,$access);
	}
	

	
}