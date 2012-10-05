<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cv extends CI_Controller {

	public function index()
	{		
		$this->load->view('templates/header');		
		$this->load->view('cv_view');

	}
}

