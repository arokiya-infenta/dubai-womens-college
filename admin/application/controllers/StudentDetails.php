<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StudentDetails extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	//  error_reporting(0);
	  date_default_timezone_set("Asia/Calcutta");
	    $this->load->library('upload');
	     $this->load->config('email');
		$this->load->library('email');
		$this->load->library('pdf');

	}

    public function index(){

		$user_id = '1786';
		$m_course = '2';


		$q = $this->db->select('*')->from('college_course')->where('mc_id',$m_course )->get();
		$pr_user = $this->db->select('*')->from('new_preview_pg')->where('pr_user_id',$user_id)->get();
		$pr_study = $this->db->select('*')->from('sub_preview_pg')->where('sb_u_id',$user_id)->get();
	
	
	
	
		$pr_study_app = $this->db->select('*')->from('stu_applied')->where('sa_st_id',$user_id)->get();
	
		$ren = $pr_study_app->num_rows();
		$data['cc'] = $q->result();
		$data['user'] = $pr_user->result();
		$data['Study'] = $pr_study->result();



		$this->load->view('template/studentdetails/header');
$this->load->view('template/studentdetails/menubar');
$this->load->view('template/studentdetails/headerbar');
$this->load->view('studentdetails/basicdetails_pg',$data);
$this->load->view('template/studentdetails/footer');



    }

public function StudentPreview(){



}


public function downloadBulkPg(){

	$this->load->library('zip');
$user_id = $this->uri->segment(3);


$cert = array();

$pr_user = $this->db->select('*')->from('new_preview_pg')->where('pr_user_id',$user_id)->get();
	
$cer = $pr_user->result();



	$certificates = array($cer[0]->pr_sslc,$cer[0]->pr_plus_one,$cer[0]->pr_plus_two,$cer[0]->pr_abled_certificate,$cer[0]->pr_semester_1, $cer[0]->pr_semester_2, $cer[0]->pr_semester_3, $cer[0]->pr_semester_4, $cer[0]->pr_semester_5, $cer[0]->pr_semester_6, $cer[0]->pr_semester_7, $cer[0]->pr_semester_8, $cer[0]->pr_provisional_pg_cer, $cer[0]->pr_ug_cer, $cer[0]->pr_cummulative_cer, $cer[0]->pr_community_cer, $cer[0]->pr_conduct_cer, $cer[0]->pr_transfer_cer);
	array_filter($certificates);

foreach ($certificates as $key => $value) {
	if($value !=""){

		array_push($cert, $value);

	}
}

print_r($cert);
	

	echo base_url().'/uploads/f16c72c24e56e42a652c1f1f12edbaf5.pdf';




foreach ($cert as $key => $value) {

	$path = 'uploads/'.$value;

	$this->zip->read_file($path);
	# code...
}

	


	
	// Download the file to your desktop. Name it "my_backup.zip"
	$this->zip->download($cer[0]->pr_applicant_name.'.zip');


//$this->zip->read_file($path, TRUE);
	





// Download the file to your desktop. Name it "my_backup.zip"
//$this->zip->download('my_backup.zip')	;























}





}