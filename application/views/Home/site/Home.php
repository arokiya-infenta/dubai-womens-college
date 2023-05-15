<?php

use Dompdf\Dompdf;

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {


	protected $c_date;
	protected $user_department;
	protected $user_main_stream;
	protected $user_course_stream;
	protected $user_register_number;
	protected $user_ref_number;
	protected $user_number;
	protected $user_semester;
	protected $user_batch;
	protected $user_ad_id;
	protected $user_current_year;






	public function __construct()
    {
    parent::__construct();
 	error_reporting(0);
	//ini_set('display_errors', 0);  
	$this->load->library('upload');
	$this->load->library('pdf');
	$this->load->helper('download');
	$this->load->library('email');
	$this->load->config('email');
	$this->load->library('form_validation');
	
		date_default_timezone_set('Asia/Calcutta');

		include APPPATH . 'third_party/payment/TransactionRequestBean.php';	
		include APPPATH . 'third_party/payment/TransactionResponseBean.php';
	


		$stud_id = $this->db->select("admitted_student.*,shotlisted_candidate.*,department_details.*,erp_existing_students.id AS sid")->from("shotlisted_candidate")
    
	->join('department_details', 'shotlisted_candidate.sl_main_id = department_details.main_id AND shotlisted_candidate.sl_course_id = department_details.cour_id')
	->join('admitted_student', 'shotlisted_candidate.sl_id = admitted_student.as_shotlist_ref_number ')
	->join('erp_existing_students', 'shotlisted_candidate.sl_student_id = erp_existing_students.student_id ')
	->where("sl_student_id",$this->session->userdata("user")["user_id"])
		->where("shotlisted_candidate.principal_published",1)
		->where("shotlisted_candidate.reservation_status",1)
	//->where("sl_student_id",$this->session->userdata("user")["user_id"])
		->get();
		$rests = $stud_id->num_rows();
		if($rests > 0){
			$user_d = $stud_id->result();
			
			//print_r($user_d);
			$this->c_date = date('Y-m-d');
			
			
			$this->user_department = $user_d[0]->comp_name;
			$this->user_main_stream = $user_d[0]->sl_main_id;
			$this->user_course_stream = $user_d[0]->sl_course_id;
			$this->user_register_number = $user_d[0]->as_reg_num;
			$this->user_ref_number = date("y",strtotime($this->session->userdata("user")["user_year"]."-01-01")).$this->session->userdata("user")["user_id"];
			$this->user_number =$this->session->userdata("user")["user_id"];
			$this->user_semester =$this->session->userdata("user")["user_semester"];
			$this->user_batch =$this->session->userdata("user")["user_year"];
			$this->user_ad_id =$user_d[0]->sid;
			$this->user_current_year = $this->myCurrentYear();
			
			
			
			
					}else{

	
						$this->user_department = "";
						$this->user_main_stream = "";
						$this->user_course_stream = "";
						$this->user_register_number = "";
						$this->user_ref_number ="";
						$this->user_number ="";
						$this->user_semester ="";
						$this->user_batch ="";
						$this->user_ad_id ="";
						$this->user_current_year ="";




					}

	}
	


public function testYear(){

echo $this->user_department."<br>";
echo $this->user_main_stream."<br>";
echo $this->user_course_stream."<br>";
echo $this->user_register_number."<br>";
echo $this->user_ref_number."<br>";
echo $this->c_date."<br>";
echo $this->user_batch."<br>";
echo $this->user_current_year."<br>";



}
public function myCurrentYear(){
	$user_year =  $this->user_batch."-04-01";
	$date1 = ($user_year);
	$date2 =($this->c_date);
	
	$ts1 = strtotime($date1);
	$ts2 = strtotime($date2);
	
	$year1 = date('Y', $ts1);
	$year2 = date('Y', $ts2);
	
	$month1 = date('m', $ts1);
	$month2 = date('m', $ts2);
	
	 $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
if($diff <=12){

	return 1;
}else if($diff <=24){

	return 2;
}else {

	return 3;

}

}



	public function index()
	{
		$this->load->view('Home/template/head.php');
		$this->load->view('Home/site/index.php');
		$this->load->view('Home/template/footer.php');

		//echo 'Welcome';
	}






	
	public function downloadFile($fileName = NULL){

		$fileName = $this->uri->segment(3);

		if ($file