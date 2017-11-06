<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Companies extends CI_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'companies_model' );
	}
	
	public function index() {
		if ($this->session->userdata ( 'logged_in' )) {
			$session_data = $this->session->userdata ( 'logged_in' );
			$data ['username'] = $session_data ['name'];
			$data ['id'] = $session_data ['id'];
			$data['level'] = $session_data ['level'];
			
// 			$output ['companies'] = $this->companies_model->getTable ($session_data ['id']);
			$output ['companies'] = $this->companies_model->getCompanies ();

			$output['cities'] =  $this->companies_model->getCities();
			
			$data['output'] = $this->load->view('companies', $output, true);
			
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
			unset($_REQUEST['id']);
			
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
	
	public function delete($id) {

		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
		
			$_REQUEST['updated_by'] = $session_data ['id'];
			
			
		
			$this->companies_model->deleteData($id);
				
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
}