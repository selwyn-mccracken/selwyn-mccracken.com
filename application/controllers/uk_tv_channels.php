<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Uk_tv_channels extends CI_Controller {

	public function index()
	{		
		$this->load->view('templates/header');		
		$this->load->view('uk_tv_channels_view');
		$this->load->view('templates/explorer_warning');		
	}
}

