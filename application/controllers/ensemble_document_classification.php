<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ensemble_document_classification extends CI_Controller {

	public function index()
	{		
		$this->load->view('templates/header');		
		$this->load->view('ensemble_document_classification_view');

	}
}

