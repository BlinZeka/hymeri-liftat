<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
  function __construct() {
    parent::__construct();
  }
  
	public function index() {
		if ($this->session->userdata ('logged_in')) {
			$this->load->view ( 'main' );
		} else {
			$this->load->helper(array('form'));
			$this->load->view('login');
		}		
	}
}
?>
