<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hadoop_benchmarks extends CI_Controller {

	public function index()
	{		
		$this->load->view('templates/header');		
		$this->load->view('hadoop_benchmarks_view');

	}
}

