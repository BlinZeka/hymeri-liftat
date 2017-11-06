<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Users extends CI_Controller { 
	function __construct(){
		parent::__construct();
		$this->load->model('users_model');		
	}	

  	public function index() {
		if ($this->session->userdata ( 'logged_in' )) {

			$session_data = $this->session->userdata ( 'logged_in' );
			$data ['username'] = $session_data ['name'];
			$data ['id'] = $session_data ['id'];
			$data ['level'] = $session_data ['level'];

			// $output ['entries'] = $this->users_model->getAll();
			$data['output'] = $this->load->view('users', $data, true);
			
			$this->load->view('template', $data);
		}
  	}	

  	public function returnDatas () {
  		$query = $this->users_model->getAll();
  		echo json_decode($query);
  	}

  	public function buildaccess($id){
		if ($this->session->userdata ( 'logged_in' )) {

			$session_data = $this->session->userdata ( 'logged_in' );
			$data['accessId'] = $id;
			$data ['username'] = $session_data ['name'];
			$data ['id'] = $session_data ['id'];	
			$data ['level'] = $session_data ['level'];
			$data ['buildings'] = $this->users_model->getBuildings();
			
			// $output ['entries'] = $this->users_model->getAll();
			$data ['buildingsid'] = $this->users_model->get_by_id($id);
			$data['output'] = $this->load->view('buildingAccess', $data, true);
			$this->load->view('template', $data);
		}  		
  	}

  	public function test($id){
  		$query = $this->users_model->get_checked($id);
  		if($query){
  			return true;
  		}
  	}

  	public function gets($id){
  		$query = $this->users_model->get_buildings_by_id($id);
  		if($query){
  			return true;
  		}
  	}

  	public function choosen($id) {
  		  	
  		if($this->users_model->insert_array($id)){
  			return true;
  		} else {
  			return false;
  		}
  	}

  	public function delete_access($id){
  		$query = $this->users_model->delete_access($id);
  		if($query){
  			redirect('users');
  		}
  	}
}

?>