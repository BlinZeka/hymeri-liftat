<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Reports extends CI_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'reports_model' );
		$this->load->model ( 'buildings_model' );
		$this->load->model ( 'payments_model' );
	}
	
	function breadcrumb($id, $arr) {
		foreach ($arr as $a) {
			if($a['id'] == $id)
				return "Ballina > ".$a['name'];
		}
		return "Ballina > Reports";
	}	
	
	public function index($company_id = -1) {
		if ($this->session->userdata ( 'logged_in' )) {

			$session_data = $this->session->userdata ( 'logged_in' );
			$data ['username'] = $session_data ['name'];
			$data ['id'] = $session_data ['id'];
			$data ['level'] = $session_data ['level'];
			$output ['allPendingPayments'] = $this->payments_model->paymentsPending();
			$output ['buildings'] = $this->reports_model->getTable ($session_data ['id'], $company_id);
			$output ['companies'] = $this->buildings_model->getCompanies ();
			
			$output ['entries'] = $this->buildings_model->getEntries ();

			$output['test'] = "Report page";
			$output['breadcrumb'] = $this->breadcrumb($company_id, $output['companies']);
			
			$data['output'] = $this->load->view('reports', $output, true);
			
			$this->load->view('template', $data);
		} else {
			redirect('login', 'refresh');
		}
	}

	public function getBuildingsByCompanyId($company_id){
		$output ['buildings'] = $this->buildings_model->getBuildingsByCompanyId ($company_id);
		echo json_encode($output ['buildings']);
	}

	public function getEntriesByBuildingId($building_id){
		$output ['entries'] = $this->buildings_model->getEntriesByBuildingId ($building_id);
		echo json_encode($output ['entries']);
	}

	public function getTotalbyEntryId($company_id,$building_id,$entry_id,$from,$to,$valute){
		$output ['total'] = $this->buildings_model->getTotalbyEntryId ($company_id, $building_id, $entry_id,$from,$to,$valute);
		echo json_encode($output ['total']);
	}

	public function getAllClientsEntry($company_id,$building_id,$entry_id,$from,$to,$valute){
		$output ['buildings'] = $this->buildings_model->getAllClientsEntry ($company_id, $building_id, $entry_id,$from,$to,$valute);
		echo json_encode($output ['buildings']);
	}

	public function clientsNotPaymentsByMonth($company_id,$building_id,$entry_id,$from,$to){
		$output ['notPayed'] = $this->buildings_model->clientsNotPaymentsByMonth ($company_id, $building_id, $entry_id,$from,$to);
		echo json_encode($output ['notPayed']);
	}

	public function getReportPaymentByYear($client_id,$year){
		if ($this->session->userdata ( 'logged_in' )) {
		
		$query = $this->db->query(" SELECT * FROM payments p
						inner join clients c on c.id = p.client_id
						inner join flats f on f.id = c.flat_id
						where  client_id = $client_id and year = $year ");
		
		echo json_encode($query->result());
		}
		else {
			redirect('login', 'refresh');
		}

	}

	public function getClientPaymentReport(){

		if ($this->session->userdata ( 'logged_in' )) {

			$filterByBuilding = '';
			$filterByEntries = '';

			if($_REQUEST['building_id'] != ''){
				$filterByBuilding = 'AND b.id = '. $_REQUEST['building_id']. '';
			}
			if( $_REQUEST['entry_id'] !=''){
				$filterByEntries = 'AND e.id = '. $_REQUEST['entry_id'].' ' ;
			}

			$query = $this->db->query("SELECT distinct c.id, c.first_name, c.last_name, f.number as flatNumber from clients c
				inner join flats f on f.id = c.flat_id
				inner join entries e on e.id = f.entry_id
				inner join buildings b on b.id = e.building_id WHERE TRUE $filterByBuilding $filterByEntries");

			echo json_encode($query->result());
		} else {
			redirect('login', 'refresh');
		}
	}
	
	
}