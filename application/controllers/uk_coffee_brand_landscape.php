<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class uk_coffee_brand_landscape extends CI_Controller {

	public function index()
	{		
		$this->load->view('templates/header');		
		$this->load->view('uk_coffee_brand_landscape_view');

	}
}

