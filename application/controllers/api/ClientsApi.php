<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require(APPPATH . '/libraries/REST_Controller.php');

class ClientsApi extends REST_Controller {

  function __construct() {
      parent::__construct ();
      $this->load->model ( 'clients_model' );
  }

  function clients_get(){
      $data = $this->clients_model->getTable(-1,'');
      echo json_encode($data);
  }

  function clientDetails_get($client_id){
     $data = $this->clients_model->getClientDetails($client_id);
     echo json_encode($data);
 }

 function addClient_get(){
      unset($_REQUEST['_token']);
      unset($_REQUEST['building_id']);
      if(!isset($_REQUEST['abonues'])){
        $_REQUEST['abonues'] = 0;
      }  
      $_REQUEST['created_by'] = $_REQUEST['user_id'] ;
      $_REQUEST['create_date'] = time();
      $this->clients_model->insertDataCRM($_REQUEST);
 }

 function deleteClient_get($client_id){
    $this->clients_model->deleteClient($client_id);
 }

}