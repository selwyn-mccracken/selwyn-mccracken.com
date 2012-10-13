<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales_route_optimisation extends CI_Controller {

	public function index()
	{		
		$this->load->view('templates/header');		
		$this->load->view('sales_route_optimisation_view');
                $this->load->view('templates/explorer_warning');

	}
}

