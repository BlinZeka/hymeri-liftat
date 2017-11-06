<?php 
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

class Payments extends CI_Controller{

	function __construct() {
		parent::__construct ();
		$this->load->model ( 'payments_model' );
		$this->load->model ( 'maintaining_model' );
		$this->load->helper('language');
		$this->lang->load('en', 'english');
	}
	
	// function breadcrumb($id, $arr) {
	// 	foreach ($arr as $a) {
	// 		if($a['id'] == $id)
	// 			return "Ballina > ".$a['name'];
	// 	}
	// 	return "Ballina > Komplekset";
	// }	

		public function index($company_id = -1) {
		if ($this->session->userdata ( 'logged_in' )) {
			
			$session_data = $this->session->userdata ( 'logged_in' );
			$data ['username'] = $session_data ['name'];
			$data ['id'] = $session_data ['id'];
			$data ['level'] = $session_data ['level'];
			
			$output ['allPayments'] = $this->payments_model->getPayments ();
			$output ['users'] = $this->maintaining_model->getUsers();
			
			// echo print_r($output['allPayments']);
			// $output['zones'] = $this->buildings_model->getZones();
			// $output['companies'] = $this->buildings_model->getCompanies();
			
			// $output['breadcrumb'] = $this->breadcrumb($company_id, $output['companies']);
			
			$data['output'] = $this->load->view('payments', $output, true);
			
			$this->load->view('template', $data);
		} else {
			redirect('login', 'refresh');
		}
	}

	
	
	public function addPayment() {
		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];

			$_REQUEST['created_by'] = $session_data ['id'];
			

			$this->payments_model->addPayment($_REQUEST);
			
			// redirect('payments', 'refresh');
		} else {
			redirect('login', 'refresh');
		}
	}


	
	public function paymentHistory($clientId){

		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
			$_REQUEST['created_by'] = $session_data ['id'];
			$data ['level'] = $session_data ['level'];
			unset($_REQUEST['id']);
			$data['paymentHistory'] = $this->payments_model->paymentRaportClient($clientId);
			
			// $data['breadcrumb'] = $this->breadcrumb($company_id, $data['companies']);
			$data['output'] = $this->load->view('payment_history', $data, true);
			$this->load->view('template', $data);
		} else {
			redirect('login', 'refresh');
		}	

	}
	public function edit() {
		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
		
			$_REQUEST['updated_by'] = $session_data ['id'];
		
			$this->buildings_model->editData($_REQUEST);
				
			redirect('buildings', 'refresh');
		} else {
			redirect('login', 'refresh');
		}
	}
	
	public function delete() {
		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
		
			$_REQUEST['updated_by'] = $session_data ['id'];
		
			$this->buildings_model->disableData($_REQUEST['id']);
		
			redirect('buildings', 'refresh');
		} else {
			redirect('login', 'refresh');
		}
	}
	
	public function ajax($id) {
		if ($this->session->userdata ('logged_in')) {
			$session_data = $this->session->userdata ('logged_in');
			$data ['username'] = $session_data ['username'];
	
			$result = $this->db->select('*')
			->from('buildings')
			->where('id', $id)
			->get()
			->row();
			echo json_encode($result);
		} else {
			redirect('login', 'refresh');
		}
	}

	public function getPayementsByUser($userID,$start,$end,$valute){
		echo json_encode($this->payments_model->getPayementsByUser($userID,$start,$end,$valute));
	}
	
	public function getCardsByUser($userID,$start,$end){
		echo json_encode($this->payments_model->getCardsByUser($userID,$start,$end));
	}

	public function deletePayment($year,$month,$clientId,$note = false){

			$comment = $this->input->post('coment');
			
		if ($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['id'] = $session_data['id'];
			$data['username'] = $session_data['username'];
			$this->payments_model->deletePayment($year,$month,$clientId,$comment, $data['id']);
			redirect('cards/index/'.$clientId.'', 'refresh');
		} else {
			redirect('login', 'refresh');
		}
		//$this->output->enable_profiler(TRUE);


	}

	
}