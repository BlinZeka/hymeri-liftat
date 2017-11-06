<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Settings extends CI_Controller{
	
	function __construct() {

		parent::__construct ();

		$this->load->model ( 'settings_model' );

	}

	public function index(){

		if ($this->session->userdata ( 'logged_in' )) {

			$session_data = $this->session->userdata ( 'logged_in' );

			$data ['username'] = $session_data ['name'];

			$data ['id'] = $session_data ['id'];
			$data ['level'] = $session_data ['level'];
			$output['admin_info'] = $this->settings_model->getAdmin($data ['id']);
			// echo print_r($output['admin_info']);
			$data['output'] = $this->load->view('settings', $output, true);

			$this->load->view('template', $data);
		} else{
			redirect('login', 'refresh');
		}	
	
	}

	public function editUser(){
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		
		

		if ($this->session->userdata ( 'logged_in' )) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
			$data ['level'] = $session_data ['level'];
			// $this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');
			// $this->form_validation->set_rules('last_name', 'Last Name', 'required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');

			if ($this->form_validation->run() == FALSE){
				// $data['output'] = $this->load->view('settings');
				// $this->load->view('template', $data);

				// $this->load->view('settings');
			}
			else{
				$this->settings_model->editUser($_REQUEST);
				$data['output'] = $this->load->view('success_form');
				$this->load->view('template', $data);
			}

			
			
		} else{
			redirect('login', 'refresh');
		}	
	
	}

}