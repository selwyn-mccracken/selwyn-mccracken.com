<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Country_diet_similarity extends CI_Controller {

	public function index()
	{		
		$this->load->view('templates/header');		
		$this->load->view('country_diet_similarity_view');

	}
}

