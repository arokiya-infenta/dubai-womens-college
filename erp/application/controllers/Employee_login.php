<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_login extends CI_Controller {
public function __construct()
	{
		parent::__construct();
	//  error_reporting(0);
	  date_default_timezone_set("Asia/Calcutta");
	}

	public function index()
	{
		$this->load->view('template/loginemployee');
	}


	public function LoginDetails(){


	$user = $this->input->post('username');
	$pass = $this->input->post('password');
	$qv = $this->App->employee_login($user,$pass);

		//print_r($qv);




		if ($qv) {
  
			//$id = $data[0]->u_id;
			$session_data = array(
			   
			   'user_id'=> $qv[0]->id,
			   'user_name'=> $qv[0]->emp_name_,
			   'user_email_id'=> $qv[0]->emp_mail_,
			   'user_mobile'=> $qv[0]->emp_mobile_,
			   'user_designation'=> $qv[0]->emp_designation_,
			  
			   //'user_gst_mode'=> $data[0]->ap_gst_mode,
			   //'user_id'=> $user[0]->ap_id,
			   
			   );
			   
	   
	          if($qv[0]->emp_designation_ == 4 ){

			$this->session->set_userdata('user', $session_data);
			redirect('Subadmin', 'refresh');


			   }
			   elseif($qv[0]->emp_designation_ == 6 ){

			$this->session->set_userdata('user', $session_data);
			redirect('Coe', 'refresh');


			   }
			   /*elseif($qv[0]->emp_designation_ == 13 ){

			$this->session->set_userdata('user', $session_data);
			redirect('Hostellogin', 'refresh');


			   }*/
			   elseif($qv[0]->emp_designation_ == 24 ){

			$this->session->set_userdata('user', $session_data);
			redirect('Librarylogin/admin_dashboard', 'refresh');


			   }
			   elseif($qv[0]->emp_designation_ == 25 ){

			$this->session->set_userdata('user', $session_data);
			redirect('Alumnilogin', 'refresh');


			   }
			   elseif($qv[0]->emp_designation_ == 26 || $qv[0]->emp_designation_ == 13){

			$this->session->set_userdata('user', $session_data);
			redirect('Hosteladminlogin', 'refresh');


			   }
			   elseif($qv[0]->emp_designation_ == 27){

			$this->session->set_userdata('user', $session_data);
			redirect('Payrolllogin/attendance', 'refresh');


			   }
			   elseif($qv[0]->emp_designation_ == 28){

			$this->session->set_userdata('user', $session_data);
			redirect('Transportlogin', 'refresh');


			   }
			   elseif($qv[0]->emp_designation_ == 29){

			$this->session->set_userdata('user', $session_data);
			redirect('Accounts', 'refresh');


			   }
			   elseif($qv[0]->emp_designation_ == 12){

			$this->session->set_userdata('user', $session_data);
			redirect('Hod', 'refresh');


			   }
			   elseif($qv[0]->emp_designation_ == 18){

			$this->session->set_userdata('user', $session_data);
			redirect('Principal', 'refresh');


			   }
			   elseif($qv[0]->emp_designation_ == 17){

			$this->session->set_userdata('user', $session_data);
			redirect('Placement', 'refresh');


			   }elseif($qv[0]->emp_designation_ == 30){

			$this->session->set_userdata('user', $session_data);
			redirect('NonTeachingEmployee', 'refresh');


			   }
			   else{

			$this->session->set_userdata('user', $session_data);
			redirect('Employee', 'refresh');

			   }
	   }else{
		$this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Failed !</strong> User name or password incorrect .
		</div>');
		redirect('Employee_login', 'refresh');
	   
	   } 




	}
	public function logOut(){


		$this->session->unset_userdata('user'); 
		redirect('Employee_login', 'refresh');
		//$this->load->view('session_view'); 
	
	
	}
	
}
