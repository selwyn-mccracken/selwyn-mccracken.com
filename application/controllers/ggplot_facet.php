<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ggplot_facet extends CI_Controller {

	public function index()
	{		
		$this->load->view('templates/header');		
		$this->load->view('ggplot_facet_view');

	}
}

