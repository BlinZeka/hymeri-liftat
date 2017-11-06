<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Access extends CI_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'companies_model' );
		$this->load->model ( 'settings_model' );
	}
	
	public function index() {
		if ($this->session->userdata ( 'logged_in' )) {
			$session_data = $this->session->userdata ( 'logged_in' );
			$data ['username'] = $session_data ['name'];
			$data ['id'] = $session_data ['id'];
			$data ['level'] = $session_data ['level'];
			
			
			$data['employers'] = $this->db->query("SELECT * FROM `employer`")->result();
			
			$data['output'] = $this->load->view('access', $data, true);
			
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
		public function returnAjax(){
		$emp = $this->db->query("SELECT * FROM `employer`")->result();
		echo json_encode($emp);
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

	public function editEmployer($id) {
		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
	
			$result = $this->db->select('*')
			->from('employer')
			->where('id', $id)
			->get()
			->row();
			
			echo json_encode($result);
			
		} else {
			redirect('login', 'refresh');
		}
	}

	public function editEmployerAction($employer_id) {
		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
		
			$_REQUEST['updated_by'] = $session_data ['id'];
			
			$this->settings_model->editEmployerAction($_REQUEST,$employer_id);
			
			redirect('access', 'refresh');
		} else {
			redirect('login', 'refresh');
		}
	}
	
	public function addEmploye () {
		
	}


}