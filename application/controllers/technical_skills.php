<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Technical_skills extends CI_Controller {

	public function index()
	{		
		$this->load->view('templates/header');		
		$this->load->view('technical_skills_view');

	}
}

