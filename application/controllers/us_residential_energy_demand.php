<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Us_residential_energy_demand extends CI_Controller {

	public function index()
	{		
		$this->load->view('templates/header');		
		$this->load->view('us_residential_energy_demand_view');

	}
}

