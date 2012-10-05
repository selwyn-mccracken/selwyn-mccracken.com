<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rates extends CI_Controller {

	public function index()
	{		
		$this->load->view('templates/header');		
		$this->load->view('rates_view');

	}
}

