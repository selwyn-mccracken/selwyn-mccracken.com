<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class us_state_comparisons extends CI_Controller {

	public function index()
	{		
		$this->load->view('templates/header');		
		$this->load->view('us_state_comparisons_view');
		$this->load->view('templates/explorer_warning');		
	}
}

