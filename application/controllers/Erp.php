<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Erp extends CI_Controller {
public function __construct()
	{
		parent::__construct();
	//  error_reporting(0);
	  date_default_timezone_set("Asia/Calcutta");
	}

	public function index()
	{
		$this->load->view('Home/template/head');
		$this->load->view('Home/erp/login');
		$this->load->view('Home/template/footer');
	}



}