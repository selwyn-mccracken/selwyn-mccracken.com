<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class German_rubber_trade extends CI_Controller {

	public function index()
	{		
		$this->load->view('templates/header');		
		$this->load->view('german_rubber_trade_view');

	}
}

