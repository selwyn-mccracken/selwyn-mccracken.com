<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Portfolio extends CI_Controller {

	public function index()
	{		
		$this->load->view('templates/header');		
		$this->load->view('portfolio_view');

	}
}

