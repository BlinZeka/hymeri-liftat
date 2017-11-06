<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Buildings extends CI_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'buildings_model' );
	}
	
	function breadcrumb($id, $arr) {
		foreach ($arr as $a) {
			if($a['id'] == $id)
				return "Ballina > ".$a['name'];
		}
		return "Ballina > Komplekset";
	}	
	
	public function index($company_id = -1) {
		
		if ($this->session->userdata ( 'logged_in' )) {
			$session_data = $this->session->userdata ( 'logged_in' );
// 			print_r($session_data);
			$data ['username'] = $session_data ['name'];
			$data ['id'] = $session_data ['id'];
			$data ['level'] = $session_data ['level'];
			
			$output ['buildings'] = $this->buildings_model->getTable ($session_data ['id'], $company_id,$session_data ['level']);
			$output['user_level'] = $session_data ['level'];
			$output['zones'] = $this->buildings_model->getZones();
			$output['companies'] = $this->buildings_model->getCompanies();
			$output['countries'] = $this->buildings_model->getCountries();
			$output['cities'] = $this->buildings_model->getCities();
			
			
			$output ['level'] = $session_data ['level'];
			$output['breadcrumb'] = $this->breadcrumb($company_id, $output['companies']);
			
			$data['output'] = $this->load->view('buildings', $output, true);
		
			$this->load->view('template', $data);
		} else {
			redirect('login', 'refresh');
		}
	}
	//returns json array 
	public function getZonesJson($cityID){
		$this->buildings_model->getZonesjson($cityID);
	}


	public function getCitiesJson($countryID){
		$this->buildings_model->getCitiesJson($countryID);
	}

	public function getCompaniesJson(){
		$this->buildings_model->getCompaniesJson();
	}

	public function getZoneJson(){
		$this->buildings_model->getZoneJson();
	}

	public function getCityJson(){
		$this->buildings_model->getCityJson();
	}

	public function insert() {
		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
			$data ['level'] = $session_data ['level'];
			$_REQUEST['created_by'] = $session_data ['id'];
			unset($_REQUEST['id']);

			$this->buildings_model->insertData($_REQUEST);
			
			redirect('buildings', 'refresh');
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
			$arr['id'] = $_REQUEST['id'];
			$arr['lat'] = $_REQUEST['lat'];
			$arr['lon'] = $_REQUEST['lon'];
			$arr['name'] = $_REQUEST['name'];
			$arr['company_id'] = $_REQUEST['company_id'];
			$arr['zone_id'] = $_REQUEST['zone_id'];
			$arr['updated_by'] = $_REQUEST['updated_by'];
			$arr['street'] = $_REQUEST['street'];
			$this->buildings_model->editData($arr);
				
			redirect('buildings', 'refresh');
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
		
			$this->buildings_model->disableData($_REQUEST['id']);
		
			redirect('buildings', 'refresh');
		} else {
			redirect('login', 'refresh');
		}
	}
	
	public function insertBuilding(){
		
		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
			$data ['level'] = $session_data ['level'];
			
		
			$arr = array(

				'name' =>$this->input->post('name'),
				'owner' =>$this->input->post('owner'),
				'phone' =>$this->input->post('phone'),
				'business_no' =>$this->input->post('business_no'),
				'fiscal_no' =>$this->input->post('fiscal_no'),
				'city_id' =>$this->input->post('city_id'),
				'created_by' =>$session_data ['id'],

			);
		

			$this->buildings_model->insertBuilding($arr);
				
			// redirect('buildings', 'refresh');
		} else {
			redirect('login', 'refresh');
		}

		
	}
	public function deleteBuilding($id){
			$this->buildings_model->deleteBuilding($id);
	}


	public function insertZone(){
		
		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
			$data ['level'] = $session_data ['level'];
			
		
			$arr = array(

				'name' =>$this->input->post('name'),
				'city_id' =>$this->input->post('cityID'),
				'created_by' =>$session_data ['id'],
				'create_date' => time()

			);
		

			$this->buildings_model->insertZone($arr);
				
			// redirect('buildings', 'refresh');
		} else {
			redirect('login', 'refresh');
		}

		
	}

	public function ajax($id) {
		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
			$data ['level'] = $session_data ['level'];
			$result = $this->db->select('buildings.id as id, buildings.lat as lat, buildings.lon as lon,buildings.name as name,buildings.company_id as company_id, buildings.zone_id as zone_id, buildings.street as street,states.id as country, cities.id as city')
			->from('buildings')
			->join('zones', 'zones.id = buildings.zone_id')
			->join('cities', 'cities.id = zones.city_id')
			->join('states', 'states.id = cities.state_id')
			
			->where('buildings.id', $id)
			->get()
			->row();
			echo json_encode($result);
		} else {
			redirect('login', 'refresh');
		}
	}

	public function Company($id) {
		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
			$data ['level'] = $session_data ['level'];
			$result = $this->db->select('companies.id as id,companies.name as name,companies.city_id as city_id, companies.owner as owner ,companies.phone as phone, companies.business_no as business_no, companies.fiscal_no as fiscal_no')
			->from('companies')
			->join('cities', 'cities.id = companies.city_id')
			->where('companies.id', $id)
			->get()
			->row();
			echo json_encode($result);
		} else {
			redirect('login', 'refresh');
		}
	}

	public function deleteCompany($id) {     

		$this->buildings_model->deleteCompany($id);
	}

	public function editCompany($company_id){
		
		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
			$data ['level'] = $session_data ['level'];
			
		
			$arr = array(

				'name' =>$this->input->post('name'),
				'owner' =>$this->input->post('owner'),
				'phone' =>$this->input->post('phone'),
				'business_no' =>$this->input->post('business_no'),
				'fiscal_no' =>$this->input->post('fiscal_no'),
				'city_id' =>$this->input->post('city_id'),

			);

			$this->db->where('id', $company_id);
			$this->db->update('companies', $arr);
			$this->buildings_model->getCompaniesJson();
			// redirect('buildings', 'refresh');
		} else {
			redirect('login', 'refresh');
		}

		
	}
}