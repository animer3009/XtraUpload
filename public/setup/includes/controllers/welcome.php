<?php

class Welcome extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->load->view('header');
		$this->load->view('home');
		$this->load->view('footer');
	}
}

/* End of file welcome.php */
/* Location: ./setup/includes/controllers/welcome.php */