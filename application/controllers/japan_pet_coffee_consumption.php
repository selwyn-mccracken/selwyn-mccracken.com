<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Japan_pet_coffee_consumption extends CI_Controller {

	public function index()
	{		
		$this->load->view('templates/header');		
		$this->load->view('japan_pet_coffee_consumption_view');

	}
}

