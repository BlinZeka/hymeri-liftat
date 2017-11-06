<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Cardsemployer extends CI_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'companies_model' );
		$this->load->model ( 'cards_model' );
	}
	
	public function index($employer_id) {
		if ($this->session->userdata ( 'logged_in' )) {
			$session_data = $this->session->userdata ( 'logged_in' );
			$data ['username'] = $session_data ['name'];
			$data ['id'] = $session_data ['id'];
			$data ['level'] = $session_data ['level'];
			$data['employer_id'] = $employer_id;
			$data['companies'] = $this->db->query("SELECT id, name FROM `companies`")->result_array();
			$data['cards'] = $this->db->query("SELECT  c.card_no as card_no ,   c.id as id, c.site_code as site_code, c.floors as floors,c.site_no as site_no, concat(adm.first_name, ' ' , adm.last_name) as created_by, concat(adm.first_name, ' ' , adm.last_name) as updated_by FROM `cards` c
											INNER JOIN admin adm on adm.id = c.created_by
											INNER JOIN admin admn on admn.id = c.updated_by 
											where employer_id = '$employer_id'")->result();
			// echo print_r($data['cards']);
			$output ['cards'] = $this->cards_model->getTableEmployer($employer_id);
			$data['buildings'] = array();
			$data['entries'] = array();
			
			foreach($data['companies'] as $company) {
				$buildings = $this->db->query("SELECT id, name FROM `buildings` WHERE company_id=".$company['id'])->result_array();
				$data['buildings'][$company['id']] = array();
				foreach ($buildings as $building) {
					$data['buildings'][$company['id']][] = $building;
					$entries = $this->db->query("SELECT e.id as elevatorID, entry.id as id, entry.name as name FROM `entries` entry 
									INNER JOIN elevators e on e.entry_id  = entry.id
									WHERE building_id=".$building['id'])->result_array();
					$data['entries'][$building['id']] = array();
					foreach ($entries as $entry) {
						$data['entries'][$building['id']][] = $entry;
					}
				}
			}
			
			$data['output'] = $this->load->view('cardsEmployer', $data, true);
			
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

			$this->companies_model->insertData($_REQUEST);
			
			redirect('companies', 'refresh');
		} else {
			redirect('login', 'refresh');
		}
	}
	
	public function edit() {
		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
		
			$_REQUEST['updated_by'] = $session_data ['id'];
		
			$this->companies_model->editData($_REQUEST);
				
			redirect('companies', 'refresh');
		} else {
			redirect('login', 'refresh');
		}
	}
	
	public function disable() {
		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
		
			$_REQUEST['updated_by'] = $session_data ['id'];
		
			$this->companies_model->disableData($_REQUEST['id']);
		
			redirect('companies', 'refresh');
		} else {
			redirect('login', 'refresh');
		}
	}
	
	public function ajax() {
		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
	
			$result = $this->db->select('*')
			->from('companies')
			->where('id', $_REQUEST['id'])
			->get()
			->row();
			
			echo json_encode($result);
			
		} else {
			redirect('login', 'refresh');
		}
	}

	public function deleteEmployer($employerID){

		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
	
			$this->cards_model->deleteEmployer($employerID);
			
		} else {
			redirect('login', 'refresh');
		}

		
	}
}