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
		
		if($this->session->userdata('user')){

	if($this->session->userdata("user")["user_auth"] == 1){
	redirect('Admin', 'refresh');
			
	}else if($this->session->userdata("user")["user_auth"] ==2){
	redirect('PgSelfFinance', 'refresh');
			
		}else if($this->session->userdata("user")["user_auth"] == 3){
			redirect('PgDiploma', 'refresh');

			
		}else if($this->session->userdata("user")["user_auth"] == 4){
			redirect('PgMswAided', 'refresh');
			
		}else if($this->session->userdata("user")["user_auth"] == 5){
			redirect('PgMswSelfFin', 'refresh');
			
		}else if($this->session->userdata("user")["user_auth"] == 6){
			redirect('UgSelfFinance', 'refresh');
			
		}else if($this->session->userdata("user")["user_auth"] == 7){
			redirect('Accounts', 'refresh');
			
		}else if($this->session->userdata("user")["user_auth"] == 8){
			redirect('MswAided', 'refresh');
			
		}else{

			$this->logOut();

		}
	
	}else{

			$this->load->view('template/login');
			
		}

	}
	public function LoginDetails(){


	$user = $this->input->post('username');
	$pass = $this->input->post('password');
	$qv = $this->App->login($user,$pass);

		if ($qv) {
  
			//$id = $data[0]->u_id;
			$session_data = array(
			   
			   'user_id'=> $qv[0]->ad_id,
			   'user_name'=> $qv[0]->ad_user_name,
			   'user_email_id'=> $qv[0]->ad_email,
			   'user_mobile'=> $qv[0]->ad_mobile,
			   'user_auth'=> $qv[0]->ad_auth,
			   'user_dep_status'=> $qv[0]->ad_status,
			   'user_aca_year'=> $qv[0]->ad_year,
			  
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


			   }else if($qv[0]->ad_auth == 6) {

				$this->session->set_userdata('user', $session_data);
				redirect('UgSelfFinance', 'refresh');


			   }
			   else if($qv[0]->ad_auth == 7 ){

			$this->session->set_userdata('user', $session_data);
			redirect('Accounts', 'refresh');


			   }else if($qv[0]->ad_auth == 8 ){

					$this->session->set_userdata('user', $session_data);
					redirect('MswAided', 'refresh');
		
		
						 }
	   else{
		$this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Failed !</strong> User name or password incorrect .
		</div>');
		redirect('Welcome', 'refresh');
	   
	   } 
}
}
	public function logOut(){


		$this->session->unset_userdata('user'); 
		redirect('Welcome', 'refresh');
		//$this->load->view('session_view'); 
	
	
	}

	public function updateappdate(){



		$sta = $this->db
		->select("*")
		->from("Applyed_Cources")
		->join(
			"Applyed_Master",
			"Applyed_Master.id=Applyed_Cources.master_id",
			"left"
		) 
		
		->where(
			"Applyed_Cources.applied_date",
			"0000-00-00 00:00:00"
		)->get();

$usr = $sta->result();

/* echo "<pre>";
print_r($usr); */



foreach($usr as $ut){

echo $ut->date;
echo "<br>";
$array = array(
	'applied_date'=>$ut->date,
);

 
$this->db->where("master_id",$ut->id);
$this->db->update("Applyed_Cources",$array);
 

}

	}
	
}
