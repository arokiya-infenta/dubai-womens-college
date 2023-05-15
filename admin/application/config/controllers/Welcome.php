<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
public function __construct()
	{
		parent::__construct();
	//  error_reporting(0);
	  date_default_timezone_set("Asia/Calcutta");
	  
	  
	

	}

	public function index()
	{
		$this->load->view('template/login');
	}


	public function LoginDetails(){


	$user = $this->input->post('username');
	$pass = $this->input->post('password');
	$qv = $this->App->login($user,$pass);

		//print_r($qv);




		if ($qv) {
  
			//$id = $data[0]->u_id;
			$session_data = array(
			   
			   'user_id'=> $qv[0]->ad_id,
			   'user_name'=> $qv[0]->ad_user_name,
			   'user_email_id'=> $qv[0]->ad_email,
			   'user_mobile'=> $qv[0]->ad_mobile,
			   'user_auth'=> $qv[0]->ad_auth,
			   'user_dep_status'=> $qv[0]->ad_status,
			  
			   //'user_gst_mode'=> $data[0]->ap_gst_mode,
			   //'user_id'=> $user[0]->ap_id,
			   
			   );
	   
			   if($qv[0]->ad_auth == 1 ){

			$this->session->set_userdata('user', $session_data);
			redirect('Admin', 'refresh');


			   }else if($qv[0]->ad_auth == 3){

				$this->session->set_userdata('user', $session_data);
				redirect('PgDiploma', 'refresh');


			   }else if($qv[0]->ad_auth == 4){
				$this->session->set_userdata('user', $session_data);
				redirect('PgMswAided', 'refresh');

			   }else if($qv[0]->ad_auth == 5){
				$this->session->set_userdata('user', $session_data);
				redirect('PgMswSelfFin', 'refresh');

			   } else if($qv[0]->ad_auth == 2) {

				$this->session->set_userdata('user', $session_data);
				redirect('PgSelfFinance', 'refresh');


			   }
	   }else{
		$this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Failed !</strong> User name or password incorrect .
		</div>');
		redirect('Welcome', 'refresh');
	   
	   } 




	}
	public function logOut(){


		$this->session->unset_userdata('user'); 
		redirect('Welcome', 'refresh');
		//$this->load->view('session_view'); 
	
	
	}
	
}
