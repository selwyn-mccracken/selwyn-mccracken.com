<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Heating_oil_price_seasonality extends CI_Controller {

	public function index()
	{		
		$this->load->view('templates/header');		
		$this->load->view('heating_oil_price_seasonality_view');

	}
}

