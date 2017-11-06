<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Main extends CI_Controller {
	public function index() {
		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ( 'logged_in' );
			$data ['username'] = $session_data ['name'];
			$data ['level'] = $session_data ['level'];
			
			$data ['output'] = $this->load->view("main", '', TRUE);
			
			$this->load->view ( 'template', $data);
		} else {
			redirect ( 'login', 'refresh' );
		}
	}
	
	function map() {
		if ($this->session->userdata ( 'logged_in' )) {
			$this->load->model('buildings_model');
			$session_data = $this->session->userdata ( 'logged_in' );
			$data ['username'] = $session_data ['username'];
			$level =  $session_data ['level'];
			
			echo json_encode($this->buildings_model->getTable($session_data['id'],-1,$level));
			
		} else {
			// If no session, redirect to login page
			redirect ('login', 'refresh');
		}		
	}
	
	function logout() {
		$this->session->unset_userdata('logged_in');
		$this->session->sess_destroy();
		redirect('login','refresh');
	}
}