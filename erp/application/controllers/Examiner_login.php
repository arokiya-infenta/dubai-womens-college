<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Examiner_login extends CI_Controller {
public function __construct()
	{
		parent::__construct();
	//  error_reporting(0);
	  date_default_timezone_set("Asia/Calcutta");
	}

	public function index()
	{
		$this->load->view('template/loginexaminer');
	}


	public function LoginDetails(){


	$user = $this->input->post('username');
	$pass = $this->input->post('password');
	
	$query =$this->db->select('*')
          ->from('erp_examiners')
          ->where('username', $user)
          ->where('password', $pass)
          ->where('login_status', '1')
		  ->get();
		$query_r = $query->num_rows();
		$result = $query->result();
		
		if($query_r > 0) {

			$qv =  $result;
			
		}else{
			
			$qv =  false;
		}

		//print_r($qv);




		if ($qv) {
  
			$session_data = array(
			   
			   'user_id'=> $qv[0]->id,
			   'user_username'=> $qv[0]->username,
			   'user_firstname'=> $qv[0]->first_name,
			   'user_lastname'=> $qv[0]->last_name,
			   'user_email'=> $qv[0]->email,
			   'user_mobile'=> $qv[0]->mobile,
			   'user_designation'=> $qv[0]->designation,
			   
			   );
			   
	   
			$this->session->set_userdata('user', $session_data);
			redirect('Examiner/profile', 'refresh');exit;

	   }else{
		$this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Failed !</strong> User name or password incorrect .
		</div>');
		redirect('Examiner_login', 'refresh');
	   
	   } 




	}
	public function logOut(){


		$this->session->unset_userdata('user'); 
		redirect('Examiner_login', 'refresh');
		//$this->load->view('session_view'); 
	
	
	}
	
}
