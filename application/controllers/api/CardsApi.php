<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require(APPPATH . '/libraries/REST_Controller.php');

class CardsApi extends REST_Controller {
 
  function __construct() {
    parent::__construct ();
    $this->load->model ( 'cards_model' );
  }

  function clientCards_get($client_id){
    $data = $this->cards_model->getTable($client_id);
    $this->response($data);
  }
  
  function cardDetails_get($client_id){
   $data = $this->cards_model->getClientDetails($client_id);
   $this->response($data);
 }

 function addCard_put(){
  $card_no =  self::generateCardNo($_REQUEST['site_code'], $_REQUEST['site_no']);
  $this->cards_model->insertData($_REQUEST,$card_no);
}

function deleteCard_get($card_id){
 $this->cards_model->delete($card_id);
}

function checkDuplicateCardNr_get($card_id){
  $data = $this->cards_model->checkDuplicateCardNr($card_id);
  $this->response($data);
}

function generateCardNo($siteCode,$siteNo){
 $card_no = ($siteCode << 16) | $siteNo;
 return  $card_no;
}

}