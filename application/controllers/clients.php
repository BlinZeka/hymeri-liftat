<?php

if (! defined ( 'BASEPATH' ))

	exit ( 'No direct script access allowed' );



class Clients extends CI_Controller {

	function __construct() {

		parent::__construct ();

		$this->load->model ( 'clients_model' );
		
		

	}

	

	function breadcrumb($entry_id) {

		$r = $this->db->query("SELECT e.`name` as `entry_name`,

													b.`name` as `building_name`,

													c.`name` as `company_name`, b.id as 'buildingID'

													FROM entries e

													INNER JOIN buildings b ON e.building_id = b.id 

													INNER JOIN companies c ON b.company_id = c.id

													WHERE e.`id` = ".$entry_id)->result_array();

		if($r) {

			return "Ballina >   " . "<a href='http://213.163.123.246/lift_new/index.php/entries/index/".$r[0]['buildingID']."'> " . $r[0]['building_name'] . " </a>> "  . $r[0]['entry_name'];


		} else {

			return "Ballina > Banoret";

		}

	}

	public function entryDetail($entry_id){
		$r = $this->db->query("SELECT e.`notes` as entryNote FROM entries e WHERE e.`id` = ".$entry_id)->result_array();
		return $r;
	}

	

	public function index() {

		if ($this->session->userdata ( 'logged_in' )) {

			$session_data = $this->session->userdata ( 'logged_in' );

			$data ['username'] = $session_data ['name'];

			$data ['id'] = $session_data ['id'];
			$data ['level'] = $session_data ['level'];

			

			//$output ['clients'] = $this->clients_model->getTable($entry_id, $data['id']);

			$output ['breadcrumb'] = $this->breadcrumb(0);

			

			$output['server'] = 'server';

			//if($entry_id != -1)

				//$output['server'] = 'server/'.$entry_id;

				

			
			//if($entry_id != -1)

			$output ['flats'] = $this->clients_model->getFlats();

			

			$data['output'] = $this->load->view('clients', $output, true);

			

			$this->load->view('template', $data);

		} else {

			redirect('login', 'refresh');

		}

	}

	public function flatsByEntry($entry_id) {

		if ($this->session->userdata ( 'logged_in' )) {

			$session_data = $this->session->userdata ( 'logged_in' );
			
// 			echo $entry_id;

// print_r($session_data);
			
/*
			$checkBuilding = $this->cards_model->getBuildingAdmin($client_id);
			$building_id = $checkBuilding[0]->building_id;
			
			
			if (!in_array($building_id, $session_data['buildings']) && $session_data['level'] == 3) {
			 	redirect('buildings/', 'refresh');
			}
*/


			$data ['username'] = $session_data ['name'];
			$data ['level'] = $session_data ['level'];
			$data ['id'] = $session_data ['id'];
			$output['entry_id'] =$entry_id;
			$this->session->set_userdata ( 'entry_id', $entry_id );

			$output ['flats'] = $this->clients_model->getFlats();
			$output ['clients'] = $this->clients_model->flatsByEntry($entry_id, $data['id'], $data ['level']);
			$output['showAllFlatsByEntry'] = $this->clients_model->showAllFlatsByEntry($entry_id);
			// echo print_r($output['showAllFlatsByEntry']);

			$output ['breadcrumb'] = $this->breadcrumb($entry_id);
			$output ['entryDetail'] = $this->entryDetail($entry_id);
			
			

			

			$output['server'] = 'server';

			//if($entry_id != -1)

				//$output['server'] = 'server/'.$entry_id;

				

			
			//if($entry_id != -1)

			// $output ['flats'] = $this->clients_model->getFlats();

			
			$output ['level'] = $session_data ['level'];
			$data['output'] = $this->load->view('entry_flats', $output, true);

			

			$this->load->view('template', $data);


		} else {

			redirect('login', 'refresh');

		}

	}
	
	

	public function changeAllStatus($clientID) {
	  $this->load->model ('cards_model');
		
	  $this->cards_model->changeAllStatus($clientID);
	}
	

	public function insert() {

		if ($this->session->userdata ('logged_in')) {

			$session_data = $this->session->userdata ('logged_in');

			$data ['username'] = $session_data ['username'];
			$data ['level'] = $session_data ['level'];


			$_REQUEST['created_by'] = $session_data ['id'];

			$_REQUEST['create_date'] = time();

			unset($_REQUEST['id']);

			

			

			//w($_REQUEST);


			$this->clients_model->insertData($_REQUEST);
			redirect('clients/flatsByEntry/'. $this->session->userdata('entry_id') .'', 'refresh');

		} else {

			redirect('login', 'refresh');

		}

	}


		public function insertEmployer() {

		if ($this->session->userdata ('logged_in')) {

			$session_data = $this->session->userdata ('logged_in');

			$data ['username'] = $session_data ['username'];
			$data ['level'] = $session_data ['level'];


			$_REQUEST['created_by'] = $session_data ['id'];

			$_REQUEST['create_date'] = time();

			unset($_REQUEST['id']);
			
			
			$this->clients_model->insertDataEmployer($_REQUEST);
			
			
			redirect('access/', 'refresh');

		} else {

			redirect('login', 'refresh');

		}

	}

	

	public function edit() {

		if ($this->session->userdata ('logged_in')) {

			$session_data = $this->session->userdata ('logged_in');

			$data ['username'] = $session_data ['username'];
			$data ['level'] = $session_data ['level'];
		

			$_REQUEST['updated_by'] = $session_data ['id'];

			// echo print_r($_REQUEST);

			$this->clients_model->editData($_REQUEST);

				

			redirect('clients', 'refresh');

		} else {

			redirect('login', 'refresh');

		}

	}

	public function editFromEntries($id) {

		if ($this->session->userdata ('logged_in')) {

			$session_data = $this->session->userdata ('logged_in');

			$data ['username'] = $session_data ['username'];
			$data ['level'] = $session_data ['level'];
		

			$_REQUEST['updated_by'] = $session_data ['id'];

			// echo print_r($_REQUEST);

			$this->clients_model->editData($_REQUEST);

				

			redirect('clients/flatsByEntry/'.$id.'', 'refresh');

		} else {

			redirect('login', 'refresh');

		}

	}

	

	public function delete() {

		if ($this->session->userdata ('logged_in')) {

			$session_data = $this->session->userdata ('logged_in');

			$data ['username'] = $session_data ['username'];
			$data ['level'] = $session_data ['level'];
		

			$_REQUEST['updated_by'] = $session_data ['id'];

		

			$this->clients_model->disableData($_REQUEST['id']);

		

			redirect('buildings', 'refresh');

		} else {

			redirect('login', 'refresh');

		}

	}

	

	public function server($entry_id = -1) {
	
		if ($this->session->userdata ( 'logged_in' )) {

			$session_data = $this->session->userdata ( 'logged_in' );
			$data ['level'] = $session_data ['level'];
			
// 			print_r($session_data['buildings']);
	
			$ret['aaData'] = array();
			
			$getTableFunc = $this->clients_model->getTable($entry_id, $session_data['id'],$data ['level']);
			
			foreach ( $getTableFunc as $d) {

 				$ret['aaData'][] = array(

 						$d->buildingName,

						$d->building_name, 

						$d->fnumber,

						$d->name,

						$d->phone_1,

						$d->created_by,

						date("d.m.Y", $d->from),

						date("d.m.Y", $d->to),

						$d->flat_name,

						$d->status,

						$d->street,

						$d->id,
						
						$d->card_no,

						$d->site_code,

						$d->site_no,
						
						$d->floor

						); 

			}

			

			echo json_encode($ret);

		} else {

			echo null;

		}

	}

	

	public function ajax($id) {

		if ($this->session->userdata ('logged_in')) {

			$session_data = $this->session->userdata ('logged_in');

			$data ['username'] = $session_data ['username'];
			$data ['level'] = $session_data ['level'];


			$result = $this->db->select('clients.*,flats.number as number ,flats.floor as floor, flats.id as flatid,entries.id as entry_id')

			->from('clients')

			->join('flats', 'flats.id = clients.flat_id')
			->join('entries', 'entries.id = flats.entry_id')

			->where('clients.id', $id)

			->get()

			->row();

			

			$result->from = date("d.m.Y", $result->from);

			$result->to = date("d.m.Y", $result->to);

			

			echo json_encode($result);

		} else {

			redirect('login', 'refresh');

		}

	}

	public function deleteClient($clientID){
// 		$this->clients_model->deleteClient($clientID);
		
	}
	
	public function deleteClientUpdate($clientID){
		$this->clients_model->deleteClientUpdate($clientID);
	}

}