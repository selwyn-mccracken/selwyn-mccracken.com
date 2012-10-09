<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gapminder_animation extends CI_Controller {

	public function index()
	{		
		$this->load->view('templates/header');		
		$this->load->view('gapminder_animation_view');
                $this->load->view('templates/explorer_warning');

	}
}

