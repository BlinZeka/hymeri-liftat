<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Maintaining extends CI_Controller{
	
	function __construct() {

		parent::__construct ();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model ( 'maintaining_model' );
		$this->load->model ( 'buildings_model' );
		$this->load->library('grocery_CRUD');
	}


	 public function users(){
	 	if ($this->session->userdata ( 'logged_in' )) {

			$session_data = $this->session->userdata ( 'logged_in' );
			$data ['level'] = $session_data ['level'];
			$data ['username'] = $session_data ['name'];
			$data ['create_by'] = $session_data ['id'];
			$data ['level'] = $session_data ['level'];
			if ($data ['level'] !=2) {
				echo "You dont have access to this page.";
				die();
			}
			//$this->grocery_crud->set_theme('datatables');
			$this->grocery_crud->set_table('admin')->columns('first_name','last_name','username','password','email','level', 'status');
			$this->grocery_crud->fields('first_name','last_name', 'username', 'password','email','level');
			$this->grocery_crud->field_type('level','dropdown',array('2' => 'Admin','1' => 'Employee','3' => 'Client Access' ,  '4' => 'VIP Access'));
			$this->grocery_crud->field_type('status','dropdown',array('1' => 'Aktiv','0' => 'Deaktivizo'));
   			$this->grocery_crud->where('status','1');
   			$this->grocery_crud->unset_delete();
   			$this->grocery_crud->edit_fields('first_name','last_name','username','password','email','level', 'status');
   			$this->grocery_crud->required_fields('first_name','last_name','password','email','level');
   			// $this->grocery_crud->set_theme('twitter-bootstrap');
   			
		            $output['library'] = $this->grocery_crud->render();
		            $output['liftet'] = $this->maintaining_model->getLifts();
		            $output['users'] = $this->maintaining_model->getUsersBuildingAccess();
		            $output['buildings'] =  $this->buildings_model->getBuildings();
		            $this->maintainUsers($output);        

		} else{
			redirect('login', 'refresh');
		}

	        
	    }
 
	  public   function maintainUsers($output = null){

	  	if ($this->session->userdata ( 'logged_in' )) {

			$session_data = $this->session->userdata ( 'logged_in' );

			$data ['username'] = $session_data ['name'];
			$data ['create_by'] = $session_data ['id'];
			$data ['level'] = $session_data ['level'];
			

			$data['output'] = $this->load->view('maintaining', $output, true);
			$this->load->view('template', $data);

		} else{
			redirect('login', 'refresh');
		}

	  	
	    }

	  public function getBuildings(){
	  	echo json_encode($this->buildings_model->getBuildings());
	  }

	  public function clientAccessBuilding($clientID,$companyID){

	  	if ($this->session->userdata ( 'logged_in' )) {

			$session_data = $this->session->userdata ( 'logged_in' );
			$data ['created_by'] = $session_data ['id'];
			echo json_encode($this->maintaining_model->clientAccessBuilding($clientID,$companyID,$data) );

		} else{
			redirect('login', 'refresh');
		}

	  
	  }


	  public function getClientsAccess($clientID){
	  	echo json_encode($this->maintaining_model->getClientsAccess($clientID));
	  }

	  public function deleteClientsAccess($id,$clientID){
	  	echo json_encode($this->maintaining_model->deleteClientsAccess($id,$clientID) );
	  }
	  
	  
	  public function company()  {
		  
		  if ($this->session->userdata ( 'logged_in' )) {

			$session_data = $this->session->userdata ( 'logged_in' );

			$data ['username'] = $session_data ['name'];
			$data ['create_by'] = $session_data ['id'];
			$data ['level'] = $session_data ['level'];
			

			$data['output'] = $this->load->view('companies', $output, true);
			$this->load->view('template', $data);

		} else{
			redirect('login', 'refresh');
		}
	  }



}