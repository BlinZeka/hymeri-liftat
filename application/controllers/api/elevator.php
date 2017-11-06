<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require(APPPATH . '/libraries/REST_Controller.php');

class elevator extends REST_Controller {

	function __construct() {
		parent::__construct ();
		$this->load->model ( 'buildings_model' );
	}

	function getCompanies_get() {
		$data= $this->db->query('SELECT * FROM `companies`')->result_array();
		$this->response($data);
	}

	function getBuildings_get() {
		$data= $this->db->query('SELECT * FROM `buildings`')->result_array();
		echo json_encode($data);
	}

	function getBuildingsByCompanyId_get($company_id) {
		$data =  $this->db->query("SELECT * FROM `buildings` where company_id = '$company_id' ")->result_array();
		echo json_encode($data);
	}

	function getEntries_get() {
		$data =  $this->db->query('SELECT * FROM `entries`')->result_array();
		$this->response($data);
	}

	function getEntriesByBuildingId_get($building_id) {
		$data = $this->db->query("SELECT * FROM `entries`  where building_id ='$building_id' ")->result_array();
		echo json_encode($data);
	}
}