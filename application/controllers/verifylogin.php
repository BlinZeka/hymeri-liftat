<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class VerifyLogin extends CI_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'user', '', TRUE );
	}
	
	function index() {
		// This method will have the credentials validation
		$this->load->library ('form_validation');
		
		$this->form_validation->set_rules ( 'username', 'Username', 'trim|required|xss_clean' );
		$this->form_validation->set_rules ( 'password', 'Password', 'trim|required|xss_clean|callback_check_database' );
		
		if ($this->form_validation->run () == FALSE) {
			// Field validation failed. User redirected to login page
			$this->load->view ('login');
		} else {
			// Go to private area
			redirect ( 'main', 'refresh' );
		}
	}
	
	function check_database($password) {
		// Field validation succeeded. Validate against database
		$username = $this->input->post ( 'username' );
		$id = 0;
		// query the database
		$result = $this->user->login ( $username, $password );
		if($result) {
			$id = $result[0]->id;
		}
				
		$buildings_access = $this->user->getBuildings($id);
		$builds = array();
		foreach($buildings_access as $buildings) {
			$builds[] = $buildings->building_id;
		}
	
		
		if ($result) {
			$sess_array = array ();
			foreach ( $result as $row ) {
				$sess_array = array (
						'id' => $row->id,
						'username' => $row->username,
						'name' => $row->first_name . ' ' . $row->last_name,
						'level' => $row->level,
						'buildings' => $builds
						
				);
				$this->session->set_userdata ( 'logged_in', $sess_array );
			}
			return TRUE;
		} else {
			$this->form_validation->set_message ( 'check_database', 'Invalid username or password' );
			return false;
		}
	}
}
?>
