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

		if ($fileName) {
			 $file = base_url()."admin/uploads/".$fileName;


			//exit;
			// check file exists    
		//	if (file_exists ( $file )) {
			 // get file content
			 $data = file_get_contents ( $file );
			 //force download
			 force_download ( $fileName, $data );
		//	} else {
			 // Redirect to base url
		//	 redirect ( base_url () );
		//	}
		   }


	}

	public function Register(){

		$cour = $this->db->select("*")->from("college_main_course")->where("status",1)->get();
$data["college_course"] = $cour->result();


		$this->load->view('Home/template/head');
		$this->load->view('Home/site/register',$data);
		$this->load->view('Home/template/footer');

	}	public function RegisterNew(){

		$cour = $this->db->select("*")->from("college_main_course")->where("status",1)->get();
$data["college_course"] = $cour->result();

/* 
print_r($data);
exit; */

		$this->load->view('Home/template/head');
		$this->load->view('Home/site/newregister',$data);
		$this->load->view('Home/template/footer');

	}


	public function newRegister(){


//print_r($_POST);


$this->load->library('form_validation');



$this->form_validation->set_rules('course', 'Program', 'required');
$this->form_validation->set_rules('first_name', 'First Name', 'required|min_length[2]');
$this->form_validation->set_rules('last_name', 'Last Name', 'required|min_length[1]');
$this->form_validation->set_rules('user_password', 'Password', 'required|min_length[8]');
$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required|matches[user_password]');
$this->form_validation->set_rules('email', 'Email', 'required|is_unique[stu_user.u_email_id]',array('is_unique' => 'This Email id is already Exists'));
//$this->form_validation->set_message('is_unique[stu_user.u_email_id]', 'The Email is already Exists');
$this->form_validation->set_rules('contact_no', 'Mobile Number', 'required|min_length[10]|regex_match[/^[0-9]{10}$/]|is_unique[stu_user.u_mobile]',array('is_unique' => 'This Mobile Number is already Exists'));
$this->form_validation->set_rules('aadhaarnumber', 'Aadhaar Number', 'required|min_length[12]|is_unique[stu_user.adhaar_number]|regex_match[/^[0-9]{12}$/]',array('is_unique' => 'This Aadhaar Number is already Exists'));
//$this->form_validation->set_message('is_unique[stu_user.adhaar_number]', 'The Aadhaar Number is already Exists');
$this->form_validation->set_rules('ack', 'Acknoledgement', 'required');
//$this->form_validation->set_rules('aadhaarfile', 'Upload Aadhaar Image', 'required');

if ($this->form_validation->run() == FALSE)
{
	$cour = $this->db->select("*")->from("college_main_course")->where("status",1)->get();
	$data["college_course"] = $cour->result();
	
	
			$this->load->view('Home/template/head');
			$this->load->view('Home/site/newregister',$data);
			$this->load->view('Home/template/footer');
}
else
{

	$this->upload->initialize($this->do_uploadAadhaar());
	$hh =$this->upload->do_upload('aadhaarfile');
	$dataInfo = $this->upload->data();

	$filename =$dataInfo['file_name'];
if($hh){

		
	$name = $this->input->post('first_name');
	$lastname 	 = $this->input->post('last_name');
	$pass = $this->input->post('user_password');
	$repass = $this->input->post('confirm_password');
	$email = $this->input->post('email');
	$mobile = $this->input->post('contact_no');
	$course = $this->input->post('course');
	$aadhaarnumber = $this->input->post('aadhaarnumber');
	$email_rand =rand(10,10000);
	$mob_rand =rand(10,10000);

	$data = array(
		'u_name'=>strtoupper($name),
		'u_lastname'=>strtoupper($lastname),
		'u_pass'=>md5($pass),
		'u_email_id'=>$email,
		'u_mobile'=>$mobile,
		'email_code'=>$email_rand,
		'mobile_code'=>$mob_rand,
		'u_course'=>$course,
		'adhaar_file'=>$filename,
		'adhaar_number'=>$aadhaarnumber,
		'u_ops'=>$pass,
		'u_year'=>date("Y"),
	);


	$resp =	$this->Home->registerUser($email,$mobile,$data);


	echo $resp;
	//echo	$this->Home->userExists($email,$mobile);

    if($resp == "inserted" ){
		$sms_mob = substr($mobile,-10);

$smsmsg = "http://sms.dial4sms.com:6005/api/v2/SendSMS?SenderId=MSSWAO&Is_Unicode=false&Message=Dear%20Candidate%2C%20Your%20registration%20is%20successful.%20Login%20ID%3A%20".$email ."%20Password%3A%20".$pass."%5CnRegards%2C%20Principal%2C%20MSSW.%20&MobileNumbers=".$sms_mob."&PrincipleEntityId=1001042071762463166&TemplateId=1007777626198772886&ApiKey=w6cDSY8S%2FIvqr0STG4KJhQ7itInAWx2OfNpBR%2FuyV78%3D&ClientId=3cfc5042-9835-498c-b37f-0ee1a5a8393f";




$url = $smsmsg;

$ch = curl_init();                       // initialize CURL
curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
curl_close($ch);  


		$emailsignature = "<br><br><b class='signature'>Regards,<br>


The Principal,<br>
Madras School Of Social Work,<br>
32, Casa Major Road,<br>
Egmore,Chennai-600 008.<br>
Ph - 044 28194566, 044 28195126</br>";

$smssignature="Madras School Of Social Work";
		$subject="Madras School Of Social Work ";
		$msg ="Dear ".strtoupper($name).",<br><br>You have successfully registered with Madras School Of Social Work, you can now carry on with the application submission process<br>
		<br>Your User Id : " .$email ."<br> 
		Your Password : " .$pass ."<br> 
		<br>". $emailsignature;


		$msg1 ="Dear ".$name.",
		
		
		
		You have successfully registered with Madras School Of Social Work, you can now carry on with the application submission process  ". $smssignature;



		$config = array(
			'protocol' => 'smtp', 
			'smtp_host' => 'ssl://smtp.gmail.com', 
			'smtp_port' => 465, 
			'smtp_user' => 'admission.mssw@gmail.com', 
			'smtp_pass' => 'dqamafoawpedieqn',
			'mailtype' => 'html', 
			'charset' => 'iso-8859-1'
	);
		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");
 		$this->testEmail( $email,$subject,$msg);


		 $this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
		
		 <strong>Success !</strong> Successfully Registered pls Login to Apply');

		 redirect('Home/login', 'refresh');


	}else{

		$this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Failed !</strong> Email or Mobile Number already Exists');

		redirect('Home/RegisterNew', 'refresh');



	} 

}else{

	$this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
		   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		   <strong>Failed !</strong> File not uploaded only jpg and pnd files upload');

		   redirect('Home/RegisterNew', 'refresh');

	
}


}




		
	}

	public function userRegister(){


			$name = $this->input->post('name1');
			$lastname 	 = $this->input->post('lastname');
			$pass = $this->input->post('pass');
			$repass = $this->input->post('repass');
			$email = $this->input->post('email');
			$mobile = $this->input->post('mobile');
			$course = $this->input->post('course');
			$email_rand =rand(10,10000);
			$mob_rand =rand(10,10000);

			$data = array(
				'u_name'=>strtoupper($name),
				'u_lastname'=>strtoupper($lastname),
				'u_pass'=>md5($pass),
				'u_email_id'=>$email,
				'u_mobile'=>$mobile,
				'email_code'=>$email_rand,
				'mobile_code'=>$mob_rand,
				'u_course'=>$course,
				'u_year'=>date("Y"),
			);

//print_r($_POST);






	 $resp =	$this->Home->registerUser($email,$mobile,$data);


	echo $resp;
	//echo	$this->Home->userExists($email,$mobile);

    if($resp == "inserted" ){
		$sms_mob = substr($mobile,-10);

$smsmsg = "http://sms.dial4sms.com:6005/api/v2/SendSMS?SenderId=MSSWAO&Is_Unicode=false&Message=Dear%20Candidate%2C%20Your%20registration%20is%20successful.%20Login%20ID%3A%20".$email ."%20Password%3A%20".$pass."%5CnRegards%2C%20Principal%2C%20MSSW.%20&MobileNumbers=".$sms_mob."&PrincipleEntityId=1001042071762463166&TemplateId=1007777626198772886&ApiKey=w6cDSY8S%2FIvqr0STG4KJhQ7itInAWx2OfNpBR%2FuyV78%3D&ClientId=3cfc5042-9835-498c-b37f-0ee1a5a8393f";




$url = $smsmsg;

$ch = curl_init();                       // initialize CURL
curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
curl_close($ch);  


		$emailsignature = "<br><br><b class='signature'>Regards,<br>


The Principal,<br>
Madras School Of Social Work,<br>
32, Casa Major Road,<br>
Egmore,Chennai-600 008.<br>
Ph - 044 28194566, 044 28195126</br>";

$smssignature="Madras School Of Social Work";
		$subject="Madras School Of Social Work ";
		$msg ="Dear ".strtoupper($name).",<br><br>You have successfully registered with Madras School Of Social Work, you can now carry on with the application submission process<br>
		<br>Your User Id : " .$email ."<br> 
		Your Password : " .$pass ."<br> 
		<br>". $emailsignature;


		$msg1 ="Dear ".$name.",
		
		
		
		You have successfully registered with Madras School Of Social Work, you can now carry on with the application submission process  ". $smssignature;



		$config = array(
			'protocol' => 'smtp', 
			'smtp_host' => 'ssl://smtp.gmail.com', 
			'smtp_port' => 465, 
			'smtp_user' => 'admission.mssw@gmail.com', 
			'smtp_pass' => 'dqamafoawpedieqn',
			'mailtype' => 'html', 
			'charset' => 'iso-8859-1'
	);
		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");
 		$this->testEmail( $email,$subject,$msg);

	} 
  
	}




	public function login(){

		$this->load->view('Home/template/head');
		$this->load->view('Home/site/login');
		$this->load->view('Home/template/footer');


	}

	public function forgotPassword(){

		$this->load->view('Home/template/head');
		$this->load->view('Home/site/forgotpassword');
		$this->load->view('Home/template/footer');


	}
	public function forgotpasswordAction(){


		$email = 	$this->input->post("first_name");

		$qs = $this->db->select("*")->from("stu_user")->where("u_email_id",$email)->get();

		$res = $qs->num_rows();

		//print_r($res_arr);
		 if($res > 0){
			$res_arr = $qs->result();
				$subject="MSSW Forgot Password";

				$msg="<h4>Forgot password<h4><br><br><a href='".base_url()."Home/updatePassword/".$res_arr[0]->u_id."/".$res_arr[0]->email_code."'>click the link to update password</a>";
			
			/* 	$config = array(
					'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
					'smtp_host' => 'ssl://smtp.gmail.com', 
					'smtp_port' => 465, 
					'smtp_user' => 'admission.mssw@gmail.com', 
					'smtp_pass' => 'loveindia@123', 
					'smtp_crypto' => 'security', //can be 'ssl' or 'tls' for example
					'mailtype' => 'html', //plaintext 'text' mails or 'html'
					'smtp_timeout' => '4', //in seconds
					'charset' => 'iso-8859-1',
					'wordwrap' => TRUE,
					'newline' => '\r\n'
				); */
			
				$config = array(
					'protocol' => 'smtp', 
					'smtp_host' => 'ssl://smtp.gmail.com', 
					'smtp_port' => 465, 
					'smtp_user' => 'admission.mssw@gmail.com', 
					'smtp_pass' => 'dqamafoawpedieqn',
					'mailtype' => 'html', 
					'charset' => 'utf-8',
					'newline' => 'rn'
			); 
		//	$this->load->library('email', $config);
				$this->load->library('email');
				$this->email->initialize($config);
				$this->email->set_mailtype("html");
$this->email->set_newline("\r\n");
			//	$this->email->set_mailtype("html");
				//$this->email->set_newline("\r\n");
			//	 $this->testEmail( $email,$subject,$msg);
			$this->testEmail( $email,$subject,$msg);

		$this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
		   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		   <strong>Success!</strong> Please check your email inbox or spam box to update your password</div>');

		   redirect('Home/forgotPassword', 'refresh');
		}else{


		$this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Success!</strong> Email not exists !</div>');

			redirect('Home/forgotPassword', 'refresh'); 

		} 

	}
	public function updatePassword(){

	
		$this->load->view('Home/template/head');
		$this->load->view('Home/site/updatepassword');
		$this->load->view('Home/template/footer');



	}
	public function updateCurrentPassword(){

		$pass = $this->input->post("pass");
		$retypepass = $this->input->post("repass");
		$user_id = $this->input->post("pass_id");
		$rond = $this->input->post("rond");

		if($pass != $retypepass){

			$this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Success!</strong> Password and Retype password not same</div>');
 
			redirect('Home/updatePassword/'.$user_id.'/'.$rond, 'refresh');


		}else{

			if( strlen ($pass )< 8){

				$this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Success!</strong> Type more than 8 Character </div>');
	 
				redirect('Home/updatePassword/'.$user_id.'/'.$rond, 'refresh');


			}else{
				$email_rand =rand(10,10000);
				$data = array(
					'u_pass'=>md5($pass),
					'email_code'=>$email_rand,
				);
				$this->db->where("u_id",$user_id);
				$this->db->update("stu_user",$data);
				

				$this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Success!</strong> Password Updated sucessfully</div>');
	 
				redirect('Home/login', 'refresh');



			}




		}


	}

	public function loginUser(){
//$id=null;
			$user_id = $this->input->post('name1');
			$user_password = md5($this->input->post('pass'));

		$data  = $this->Home->selectLogin($user_id,$user_password);
//print_r($data);
if (array_key_exists('0', $data)) {
   
	 //$id = $data[0]->u_id;
	 $session_data = array(
		
	
		'user_id'=> $data[0]->u_id,
		'user_m_course'=> $data[0]->u_course,
		'user_name'=> $data[0]->u_name,
		'user_email_id'=> $data[0]->u_email_id,
		'user_mobile'=> $data[0]->u_mobile,
		'user_email_valid'=> $data[0]->u_email_valid,
		'user_mobile_valid'=> $data[0]->u_mobile_valid,
		'user_year'=>$data[0]->u_year,
		'user_semester'=>$data[0]->u_semester,
		);

	 $this->session->set_userdata('user', $session_data);
	 $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!</strong> Login Successfull Welcome '.$this->session->userdata('user')['user_name'].'.
  </div>');

	 echo 1;
}else{


	echo 0;

} 

}


public function dashBoard(){

	 if(!isset($this->session->userdata('user')['user_id'])){
		redirect('Home/logOut', 'refresh');
		exit;
	} 
	$user_id = $this->session->userdata('user')['user_id'];
	$m_course = $this->session->userdata('user')['user_m_course'];
   




	$data['u_department'] = $this->user_department ;
	$data['u_main_stream'] =$this->user_main_stream ;
	$data['u_app_course'] =$this->user_course_stream ;
	$data['u_reg_num'] =$this->user_register_number ;
	$data['u_ref_num'] =$this->user_ref_number ;
	$data['u_num'] =$this->user_number ;
	$data['u_semester'] =$this->user_semester ;
	$data['u_batch'] =$this->user_batch ;
	$data['u_ad_id'] =$this->user_ad_id ;
	$data['u_cur_year'] =$this->user_current_year ;
	//$data['u_ad_id'] =$this->user_ad_id ;






	if($m_course == 1){


		/* $this->load->view('Home/template/head');
		$this->load->view('Home/site/dashboard_ug');
		$this->load->view('Home/template/footer'); */
		
		$this->load->view('Home/template/head_ug');
		$this->load->view('Home/site/ug/dashboard',$data);
		$this->load->view('Home/template/footer');



	}else if($m_course == 2){


		$this->load->view('Home/template/head');
		$this->load->view('Home/site/pg/dashboard',$data);
		$this->load->view('Home/template/footer');

	}else if($m_course == 3){


		$this->load->view('Home/template/head');
		$this->load->view('Home/site/dip/dashboard',$data);
		$this->load->view('Home/template/footer');
	




	}else{


		



	}





}
public function User(){

 if(!isset($this->session->userdata('user')['user_id'])){
	redirect('Home/logOut', 'refresh');
	exit;
} 

 $user_id = $this->session->userdata('user')['user_id'];
 $m_course = $this->session->userdata('user')['user_m_course'];




if($m_course == 1){
	$in_pr = $this->db->select('*')->from('new_preview')->where('pr_user_id',$user_id)->get();
	$r = $in_pr->num_rows();




	if($r == 0){
		$pre = array(
			'pr_user_id'=>$user_id,
			'pr_created'=>date("Y-m-d H:i:s"),
		);
		
		$sub_pre = array(
			'sb_u_id'=>$user_id,
		);
		
		$this->db->insert('new_preview',$pre);
		$this->db->insert('sub_preview',$sub_pre);

	}



		$q = $this->db->select('*')->from('college_course')->where('mc_id',$m_course )->get();
		$pr_user = $this->db->select('*')->from('new_preview')->where('pr_user_id',$user_id)->get();
		$pr_study = $this->db->select('*')->from('sub_preview')->where('sb_u_id',$user_id)->get();
	
	
	
	
		$pr_study_app = $this->db->select('*')->from('stu_applied')->where('sa_st_id',$user_id)->get();
	
		$ren = $pr_study_app->num_rows();
		$data['cc'] = $q->result();
		$data['user'] = $pr_user->result();
		$data['Study'] = $pr_study->result();
	
	
		$number = rand(100,100000);
		$t=time();
		$random = $number.$t;
	

		$this->load->view('Home/template/head');
		$this->load->view('Home/site/basicdetails_ug',$data);
		$this->load->view('Home/template/footer_ug'); 



} else if($m_course == 2){

	$in_pr = $this->db->select('*')->from('new_preview_pg')->where('pr_user_id',$user_id)->get();
	$r = $in_pr->num_rows();



	if($r == 0){
		$pre = array(
			'pr_user_id'=>$user_id,
			'pr_created'=>date("Y-m-d H:i:s"),
		);
		
		$sub_pre = array(
			'sb_u_id'=>$user_id,
		);
		
		$this->db->insert('new_preview_pg',$pre);
		$this->db->insert('sub_preview_pg',$sub_pre);

	}

	$q = $this->db->select('*')->from('college_course')->where('mc_id',$m_course )->get();
		$pr_user = $this->db->select('*')->from('new_preview_pg')->where('pr_user_id',$user_id)->get();
		$pr_study = $this->db->select('*')->from('sub_preview_pg')->where('sb_u_id',$user_id)->get();
	
	
	
	
		$pr_study_app = $this->db->select('*')->from('stu_applied')->where('sa_st_id',$user_id)->get();
		$pr_sfcourse = $this->db->select('cour_id,appliction_active')->from('department_details')->where('main_id',1)->get();
		$pr_mswsfcourse = $this->db->select('cour_id,appliction_active')->from('department_details')->where('main_id',3)->get();
		$pr_mswadcourse = $this->db->select('cour_id,appliction_active')->from('department_details')->where('main_id',2)->get();
		
	
		$ren = $pr_study_app->num_rows();
		$data['cc'] = $q->result();
		$data['user'] = $pr_user->result();
		$data['Study'] = $pr_study->result();
		$data['active_sf'] = $pr_sfcourse->result_array();
		$data['active_mswsf'] = $pr_mswsfcourse->result_array();
		$data['active_mswad'] = $pr_mswadcourse->result_array();


	$this->load->view('Home/template/head');
	$this->load->view('Home/site/basicdetails_pg',$data);
	$this->load->view('Home/template/footer'); 

}else{


	$in_pr = $this->db->select('*')->from('new_preview_dip')->where('pr_user_id',$user_id)->get();
	$r = $in_pr->num_rows();



	if($r == 0){
		$pre = array(
			'pr_user_id'=>$user_id,
			'pr_created'=>date("Y-m-d H:i:s"),
		);
		
		$sub_pre = array(
			'sb_u_id'=>$user_id,
		);
		
		$this->db->insert('new_preview_dip',$pre);
		$this->db->insert('sub_preview_dip',$sub_pre);

	}



	$q = $this->db->select('*')->from('college_course')->where('mc_id',$m_course )->get();
		$pr_user = $this->db->select('*')->from('new_preview_dip')->where('pr_user_id',$user_id)->get();
		$pr_study = $this->db->select('*')->from('sub_preview_dip')->where('sb_u_id',$user_id)->get();
	
	
	
	
		$pr_study_app = $this->db->select('*')->from('stu_applied')->where('sa_st_id',$user_id)->get();
	
		$ren = $pr_study_app->num_rows();
		$data['cc'] = $q->result();
		$data['user'] = $pr_user->result();
		$data['Study'] = $pr_study->result();



	$this->load->view('Home/template/head');
	$this->load->view('Home/site/basicdetails_dip',$data);
	$this->load->view('Home/template/footer_dip'); 



}
//echo $m_course;
}

public function SaveApplication(){

	//$image_P=NULL;

$payed=$this->uri->segment(3);
$apply = $this->input->post('appli');



	$image_P = $this->input->post('ppimage');
	$stu_certificate = $this->input->post('stu_certificate');


	$this->upload->initialize($this->do_upload());
	$hh =$this->upload->do_upload('profile-img');
	$dataInfo = $this->upload->data();
	

		if($hh){

		

			$filename =$dataInfo['file_name'];
		}else{
			if($image_P == null){
						$filename = null;
			}else{

				$filename = $image_P;

			}
		}
		//$this->upload->initialize($this->do_upload());

		///==================sslc=======================//
		$image_sslc = $this->input->post('stu_sslccert');
		$sslccert =$this->upload->do_upload('sslccert');
		$datasslccert = $this->upload->data();
		
	
			if($sslccert){
	
			
	
				$sslc =$datasslccert['file_name'];
			}else{
				if($image_sslc == null){
							$sslc = null;
				}else{
	
					$sslc = $image_sslc;
	
				}
			}
	
////=======================HSC FIRST=====================//
			$image_hs1 = $this->input->post('stu_hs_fir_certi');
			$hsc1 =$this->upload->do_upload('hs_fir_certi');
			$datahsc1 = $this->upload->data();
		
	
			if($hsc1){
	
			
	
				$certhsc1 =$datahsc1['file_name'];
			}else{
				if($image_hs1 == null){
							$certhsc1 = null;
				}else{
	
					$certhsc1 = $image_hs1;
	
				}
			}


////=======================HSC Second=====================//

$image_hs2 = $this->input->post('stu_hs_sec_certi');
$hsc2 =$this->upload->do_upload('hs_sec_certi');
$datahsc2 = $this->upload->data();


if($hsc2){



	$certhsc2 =$datahsc2['file_name'];
}else{
	if($image_hs2 == null){
				$certhsc2 = null;
	}else{

		$certhsc2 = $image_hs2;

	}
}

////=======================transfer_cer=====================//

$image_trans = $this->input->post('stud_transfer');
$trans_cer = $this->upload->do_upload('transfercert');
$datatrans = $this->upload->data();


if($trans_cer){



	$trans =$datatrans['file_name'];
}else{
	if($image_trans == null){
				$trans = null;
	}else{

		$trans = $image_trans;

	}
}

////=======================dessiabledr=====================//

$abled_cert_name = $this->input->post('abled_cert_name');
$abled_cer = $this->upload->do_upload('abled_certificate');
$dataabled = $this->upload->data();


if($abled_cer){



	$abled_certificate =$dataabled['file_name'];
}else{
	if($abled_cert_name == null){
				$abled_certificate = null;
	}else{

		$abled_certificate = $abled_cert_name;

	}
}




////=======================Comunity=====================//
			$image_cc = $this->input->post('stud_commcert');
			$ccc =$this->upload->do_upload('commcert');
			$dataInfod = $this->upload->data();
		
	
			if($ccc){
	
			
	
				$ccname =$dataInfod['file_name'];
			}else{
				if($image_cc == null){
							$ccname = null;
				}else{
	
					$ccname = $image_cc;
	
				}
			}


			////======================= Professional =====================//
			$image_cert_cc = $this->input->post('stu_prof_cert_name');
			$ccc_prof =$this->upload->do_upload('stu_prof_cert');
			$dataInfo_prof= $this->upload->data();
		
	
			if($ccc_prof){
	
			
	
				$ccname_prof =$dataInfo_prof['file_name'];
			}else{
				if($image_cert_cc == null){
							$ccname_prof = null;
				}else{
	
					$ccname_prof = $image_cert_cc;
	
				}
			}



			////======================= Conduct Certificate =====================//
			$image_conduct_name = $this->input->post('stu_conduct_cert_name');
			$cc_conduct =$this->upload->do_upload('stu_conduct_cert');
			$dataInfo_cond = $this->upload->data();
		
	
			if($cc_conduct){
	
			
	
				$cc_cunduct_name =$dataInfo_cond['file_name'];
			}else{
				if($image_conduct_name == null){
							$cc_cunduct_name = null;
				}else{
	
					$cc_cunduct_name = $image_conduct_name;
	
				}
			}




			////=======================Eligibility Certificate =====================//
			$image_elig_name = $this->input->post('stu_elig_certi_name');
			$ccc_elig =$this->upload->do_upload('stu_elig_certi');
			$dataInfoelig = $this->upload->data();
		
	
			if($ccc_elig){
	
			
	
				$ccname_elig =$dataInfoelig['file_name'];
			}else{
				if($image_elig_name == null){
							$ccname_elig = null;
				}else{
	
					$ccname_elig = $image_elig_name;
	
				}
			}	
			////=======================Migration Certificate =====================//


			$image_mig_name = $this->input->post('stu_migrate_cert_name');
			$mig =$this->upload->do_upload('stu_migrate_cert');
			$dataInfomig = $this->upload->data();
		
	
			if($mig){
	
			
	
				$migccname =$dataInfomig['file_name'];

			}else{
				if($image_mig_name == null){
							$image_mig_name = null;
				}else{
	
					$migccname = $image_mig_name;
	
				}
			}

		////=======================Income Certificate =====================//

		$image_income_name = $this->input->post('stud_pr_incom_cer');
		$income =$this->upload->do_upload('pr_incom_cer');
		$dataInfoincome = $this->upload->data();
	
	
		if($income){
	
		
	
			$incimeccname =$dataInfoincome['file_name'];
	
		}else{
			if($image_income_name == null){
						$image_income_name = null;
			}else{
	
				$incimeccname = $image_income_name;
	
			}
		}

//--------------------------------basic------------------//

$candidate_name = $this->input->post('candidate_name');
//$pr_Tamilname = $this->input->post('pr_Tamilname');
$candidate_email = $this->input->post('candidate_email');
$candidate_mobile = $this->input->post('candidate_mobile');


$course_one = $this->input->post('course_one');
$course_ug = implode(",",$course_one);


$language_offered = $this->input->post('language_offered');
$dob = $this->input->post('dob');
$age = $this->input->post('age');
$m_tounge = $this->input->post('m_tounge');
$place_of_birth = $this->input->post('place_of_birth');
$gender = $this->input->post('gender');
$Nationality = $this->input->post('Nationality');

//new --entery //
$country = $this->input->post('country');
$passportnumber = $this->input->post('passportnumber');
$pp_exp = $this->input->post('pp_exp');
$blood_group = $this->input->post('blood_group');


$Religion = $this->input->post('Religion');
$Caste = $this->input->post('Caste');
$Community = $this->input->post('Community');
$pr_fglearners = $this->input->post('pr_fglearners');
$pr_s_girl_child = $this->input->post('pr_s_girl_child');
$father_name = $this->input->post('father_name');
$mother_name = $this->input->post('mother_name');
$guardion_name = $this->input->post('guardion_name');
$father_mob_num = $this->input->post('father_mob_num');
$mother_mob_num = $this->input->post('mother_mob_num');
$guardion_mob_num = $this->input->post('guardion_mob_num');

//new --entery //
$father_email = $this->input->post('father_email');
$mother_email = $this->input->post('mother_email');
$guardion_email = $this->input->post('guardion_email');
$other_res = $this->input->post('other_res');
$other_special_reservation = $this->input->post('other_special_reservation');
$hostel = $this->input->post('hostel');

$tamilnadustate = $this->input->post('tamilnadustate');
$father_accupation = $this->input->post('father_accupation');
$mother_accupation = $this->input->post('mother_accupation');
$guardion_accupation = $this->input->post('guardion_accupation');
$father_anuval_income = $this->input->post('father_anuval_income');
$mother_anuval_income = $this->input->post('mother_anuval_income');
$guardion_anuval_income = $this->input->post('guardion_anuval_income');
$local_address = $this->input->post('local_address');
$local_area = $this->input->post('local_area');
$local_city = $this->input->post('local_city');
$local_state = $this->input->post('local_state');
$local_country = $this->input->post('local_country');
$local_pincode = $this->input->post('local_pincode');
$pr_address = $this->input->post('pr_address');
$pr_area = $this->input->post('pr_area');
$pr_city = $this->input->post('pr_city');
$pr_state = $this->input->post('pr_state');
$pr_country = $this->input->post('pr_country');
$pr_pincode = $this->input->post('pr_pincode');
$identification_one = $this->input->post('identification_one');
$identification_two = $this->input->post('identification_two');
$abled = $this->input->post('abled');
$abled_reason = $this->input->post('abled_reason');
$regnumber = $this->input->post('regnumber');
$institute = $this->input->post('institute');
$institutionname = $this->input->post('institutionname');
$study_bord = $this->input->post('study_bord');
$other_bord = $this->input->post('other_bord');
$medium = $this->input->post('medium');
$year_of_passing = $this->input->post('year_of_passing');
$break_in_study = $this->input->post('break_in_study');
$break_reason = $this->input->post('break_reason');
$stream = $this->input->post('stream');
$pass_in_first_att = $this->input->post('pass_in_first_att');
$lang_studied = $this->input->post('lang_studied');
$lang_others = $this->input->post('lang_others');
$sports_name = $this->input->post('sports_name');
$sports_psition = $this->input->post('sports_psition');
$extra_caricular_activities = $this->input->post('extra_caricular_activities');
$acknoledgement = $this->input->post('acknoledgement');
$pr_scolorship = $this->input->post('pr_scolorship');



$sslc_institution = $this->input->post('sslc_institution');
$sslc_medium = $this->input->post('sslc_medium');
$year_of_passing_sslc = $this->input->post('year_of_passing_sslc');
$sslc_lang_under_part_two = $this->input->post('sslc_lang_under_part_two');

$plus2_institution = $this->input->post('plus2_institution');
$plus2_medium = $this->input->post('plus2_medium');
$year_of_passing_plus2 = $this->input->post('year_of_passing_plus2');
$plus2_lang_under_part_two = $this->input->post('plus2_lang_under_part_two');


$update_details = array(
		'pr_applicant_name'=>$candidate_name,
		//'pr_Tamilname'=>$pr_Tamilname,
		'candidate_email'=>$candidate_email,
		'pr_scolorship'=>$pr_scolorship,
		'pr_incom_cer'=>$incimeccname,
		'candidate_mobile'=>$candidate_mobile,
		'pr_course_1'=>$course_ug,
		'pr_language'=>$language_offered,
		'pr_dob'=>$dob,
		'pr_age'=>$age,
		'pr_mother_toung'=>$m_tounge,
		'pr_place_of_birth'=>$place_of_birth,
		'pr_gender'=>$gender,
		'pr_nationality'=>$Nationality,
		'pr_country'=>$country,
		'pr_passportnumber'=>$passportnumber,
		'pr_pp_exp'=>$pp_exp,
		'pr_blood_group'=>$blood_group,
		'pr_s_girl_child'=>$pr_s_girl_child,
		'pr_fglearners'=>$pr_fglearners,
		'pr_tamilnadustate'=>$tamilnadustate,
		'pr_religion'=>$Religion,
		'pr_caste'=>$Caste,
		'pr_community'=>$Community,
		'pr_photo'=>$filename,
		'pr_father_name'=>$father_name,
		'pr_mother_name'=>$mother_name,
		'pr_gaurdion_name'=>$guardion_name,
		'pr_father_mobnum'=>$father_mob_num,
		'pr_mother_mobnum'=>$mother_mob_num,
		'pr_gaurdion_mobnum'=>$guardion_mob_num,
		
		'pr_father_email'=>$father_email,
		'pr_mother_email'=>$mother_email,
		'pr_gaurdion_email'=>$guardion_email,


		'pr_father_anuval_income'=>$father_anuval_income,
		'pr_mother_anuval_income'=>$mother_anuval_income,
		'pr_gaurdion_anuval_income'=>$guardion_anuval_income,
		'pr_father_accu'=>$father_accupation,
		'pr_mother_accu'=>$mother_accupation,
		'pr_gaurdion_accu'=>$guardion_accupation,
		'pr_local_address'=>$local_address,
		'pr_local_area'=>$local_area,
		'pr_local_city'=>$local_city,
		'pr_local_state'=>$local_state,
		'pr_local_country'=>$local_country,
		'pr_local_pincode'=>$local_pincode,
		'pr_permanent_address'=>$pr_address,
		'pr_permanent_area'=>$pr_area,
		'pr_permanent_city'=>$pr_city,
		'pr_permanent_state'=>$pr_state,
		'pr_permanent_country'=>$pr_country,
		'pr_permanent_pincode'=>$pr_pincode,
		'pr_identification_one'=>$identification_one,
		'pr_identification_two'=>$identification_two,
		'pr_differently_abled'=>$abled,
		'pr_differently_abled_reson'=>$abled_reason,
		'pr_abled_certificate'=>$abled_certificate,
		'pr_sslc_mark'=>$sslc,
		'pr_hse_certificate'=>$certhsc1,
		'pr_hse2_certificate'=>$certhsc2,
		'pr_transfer_cert'=>$trans,
		'pr_comunity_cert'=>$ccname,
		'pr_provisional_mark_sheet'=>$ccname_prof,
		'pr_conduct_certificate'=>$cc_cunduct_name,
		'pr_eligibility_certificate'=>$ccname_elig,
		'pr_migration_certificate'=>$migccname,
	
		'pr_certificate_regist_numb'=>$regnumber,
		////////////////////////
		'pr_institute_last_attanded'=>$institute,
		'pr_insti_name'=>$institutionname,
		'pr_board_study'=>$study_bord,
		'pr_bord_other'=>$other_bord,
		'pr_medium_of_instruct'=>$medium,
		'pr_month_year_pass'=>$year_of_passing,
		'pr_break_in_syudy'=>$break_in_study,
		'pr_break_reason'=>$break_reason,
		'pr_Stream'=>$stream,
		'pr_passed_in_first_attemt'=>$pass_in_first_att,
		'pr_languvage_studied'=>$lang_studied,
		'pr_others_lang'=>$lang_others,
		'pr_name_of_game'=>$sports_name,
		'pr_game_position'=>$sports_psition,
		'pr_extra_caricular_act'=>$extra_caricular_activities,
		'pr_acknoledge'=>$acknoledgement,
		'pr_other_res'=>$other_res,
		'pr_other_special_reservation'=>$other_special_reservation,
		'pr_hostel'=>$hostel,




		'pr_sslc_school'=>$sslc_institution,
		'pr_sslc_year_of_passing'=>$year_of_passing_sslc,
		'pr_sslc_medium_of_inst'=>$sslc_medium,
		'pr_sslc_lang_under_2'=>$sslc_lang_under_part_two,
		
		
		'pr_plus2_school'=>$plus2_institution,
		'pr_plus2_year_of_passing'=>$year_of_passing_plus2,
		'pr_plus2_medium_of_inst'=>$plus2_medium,
		'pr_plus2_lang_under_2'=>$plus2_lang_under_part_two,



);



//Markdheet details
//$candidate_name = $this->input->post('candidate_name');










$part_lang_1  = $this->input->post('part_lang_1');
$part_lang_2  = $this->input->post('part_lang_2');
$max_mark_lang_1  = $this->input->post('max_mark_lang_1');
$mark_lang_1  = $this->input->post('mark_lang_1');
$max_mark_lang_2  = $this->input->post('max_mark_lang_2');
$mark_lang_2  = $this->input->post('mark_lang_2');
$max_mark_pg  = $this->input->post('max_mark');
$total_subject  = $this->input->post('total_subject');
$total_mark_obt  = $this->input->post('total_mark');
$tot_percent  = $this->input->post('over_all_percentage');



$subject_mark = array(


	
	'lang_1'=>$part_lang_1,
	'lang_2'=>$part_lang_2,
	'lang_1_max_mark'=>$max_mark_lang_1,
	'lang_2_max_mark'=>$max_mark_lang_2,
	'lang_1_obt_mark'=>$mark_lang_1,
	'lang_2_obt_mark'=>$mark_lang_2,
	'ug_max_mark'=>$max_mark_pg,
	'total_subject'=>$total_subject,
	'total_mark_obt'=>$total_mark_obt,
	'tot_percent'=>$tot_percent,


);

$sub_name = $this->input->post("subject_name");
$obt_mark = $this->input->post("obt_mark");
$percentage = $this->input->post("percentage");

/* echo sizeof($sub_name);
print_r($sub_name); */

if(!empty( $sub_name)){



for ($i=0; $i < sizeof($sub_name); $i++) { 
	
	$main_mark = array(
		'student_id'=>$this->session->userdata('user')['user_id'],
		'ug_subject_name'=>$sub_name[$i],
		'ug_max_mark'=>$max_mark_pg[$i],
		'ug_mark_obtained'=>$obt_mark[$i],
		'ud_percentage'=>$percentage[$i],
	);

	$this->db->insert('sub_preview_ug_main_sub',$main_mark);
	
}

}



 

if($payed == "payment"){


	$this->db->where('pr_user_id',$this->session->userdata('user')['user_id']);
	$this->db->update('new_preview',$update_details);




	$this->db->where('sb_u_id',$this->session->userdata('user')['user_id']);
	$this->db->update('sub_preview',$subject_mark);


	
	redirect('Home/PaymentUg/'.$payed);

}else{

	
	$this->db->where('pr_user_id',$this->session->userdata('user')['user_id']);
	$this->db->update('new_preview',$update_details);




	$this->db->where('sb_u_id',$this->session->userdata('user')['user_id']);
	$this->db->update('sub_preview',$subject_mark);


	$this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Success !</strong> Application Updated Successfully .
	</div>');
	
	$pyp = $this->input->post("pay");

	if($pyp == ""){
		redirect('Home/User');

	}else{
		redirect('Home/User/pay');
	}

}  
}
public function deleteSubject(){


$id = $this->input->post('id');

$this->db->where('ug_ms_id',$id);
$this->db->delete('sub_preview_ug_main_sub');

echo $this->session->set_flashdata('message_del', ' <div class="alert alert-danger alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Deleted !</strong>  Deleted  Successfully .
</div>');

}

public function updateApplicationPg(){


/* echo"<pre>";
	print_r($_POST);
	exit;
 */
	$image_P = $this->input->post('ppimage');
	$stu_certificate = $this->input->post('stu_certificate');


	$this->upload->initialize($this->do_upload());
	$hh =$this->upload->do_upload('profile-img');
	$dataInfo = $this->upload->data();
	

		if($hh){

		

			$filename =$dataInfo['file_name'];
		}else{
			if($image_P == null){
						$filename = null;
			}else{

				$filename = $image_P;

			}
		}





	////=======================Income Certificate =====================//

	$image_income_name = $this->input->post('stud_pr_incom_cer');
	$income =$this->upload->do_upload('pr_incom_cer');
	$dataInfoincome = $this->upload->data();


	if($income){

	

		$incimeccname =$dataInfoincome['file_name'];

	}else{
		if($image_income_name == null){
					$image_income_name = null;
		}else{

			$incimeccname = $image_income_name;

		}
	}

//--------------------------------basic------------------//

$pr_scolorship = $this->input->post('pr_scolorship');

$candidate_name = $this->input->post('candidate_name');




$language_offered = $this->input->post('language_offered');
$dob = $this->input->post('dob');
$age = $this->input->post('age');
$m_tounge = $this->input->post('m_tounge');
$place_of_birth = $this->input->post('place_of_birth');
$gender = $this->input->post('gender');
$Nationality = $this->input->post('Nationality');

//new --entery //
$country = $this->input->post('country');
$passportnumber = $this->input->post('passportnumber');
$pp_exp = $this->input->post('pp_exp');
$blood_group = $this->input->post('blood_group');


$Religion = $this->input->post('Religion');
$Caste = $this->input->post('Caste');
$tamilnadustate = $this->input->post('tamilnadustate');
$Community = $this->input->post('Community');
$father_name = $this->input->post('father_name');
$mother_name = $this->input->post('mother_name');
$guardion_name = $this->input->post('guardion_name');
$father_mob_num = $this->input->post('father_mob_num');
$mother_mob_num = $this->input->post('mother_mob_num');
$guardion_mob_num = $this->input->post('guardion_mob_num');

//new --entery //
$father_email = $this->input->post('father_email');
$mother_email = $this->input->post('mother_email');
$guardion_email = $this->input->post('guardion_email');
$other_res = $this->input->post('other_res');
$other_special_reservation = $this->input->post('other_special_reservation');
$hostel = $this->input->post('hostel');


$father_accupation = $this->input->post('father_accupation');
$mother_accupation = $this->input->post('mother_accupation');
$guardion_accupation = $this->input->post('guardion_accupation');
$father_anuval_income = $this->input->post('father_anuval_income');
$mother_anuval_income = $this->input->post('mother_anuval_income');
$guardion_anuval_income = $this->input->post('guardion_anuval_income');
$local_address = $this->input->post('local_address');
$local_area = $this->input->post('local_area');
$local_city = $this->input->post('local_city');
$local_state = $this->input->post('local_state');
$local_country = $this->input->post('local_country');
$local_pincode = $this->input->post('local_pincode');
$pr_address = $this->input->post('pr_address');
$pr_area = $this->input->post('pr_area');
$pr_city = $this->input->post('pr_city');
$pr_state = $this->input->post('pr_state');
$pr_country = $this->input->post('pr_country');
$pr_pincode = $this->input->post('pr_pincode');
$identification_one = $this->input->post('identification_one');
$identification_two = $this->input->post('identification_two');
$abled = $this->input->post('abled');
$abled_reason = $this->input->post('abled_reason');





$sports_name = $this->input->post('sports_name');
$sports_psition = $this->input->post('sports_psition');
$extra_caricular_activities = $this->input->post('extra_caricular_activities');
$acknoledgement = $this->input->post('acknoledgement');




$update_details = array(

'pr_applicant_name'=>$candidate_name,

'pr_language'=>$language_offered,
'pr_dob'=>$dob,
'pr_age'=>$age,
'pr_mother_toung'=>$m_tounge,
'pr_place_of_birth'=>$place_of_birth,
'pr_gender'=>$gender,
'pr_nationality'=>$Nationality,
'pr_country'=>$country,
'pr_passportnumber'=>$passportnumber,
'pr_pp_exp'=>$pp_exp,
'pr_blood_group'=>$blood_group,
'pr_tamilnadustate'=>$tamilnadustate,
'pr_religion'=>$Religion,
'pr_caste'=>$Caste,
'pr_community'=>$Community,
'pr_photo'=>$filename,
'pr_father_name'=>$father_name,
'pr_mother_name'=>$mother_name,
'pr_gaurdion_name'=>$guardion_name,
'pr_father_mobnum'=>$father_mob_num,
'pr_mother_mobnum'=>$mother_mob_num,
'pr_gaurdion_mobnum'=>$guardion_mob_num,

'pr_father_email'=>$father_email,
'pr_mother_email'=>$mother_email,
'pr_gaurdion_email'=>$guardion_email,


'pr_father_anuval_income'=>$father_anuval_income,
'pr_mother_anuval_income'=>$mother_anuval_income,
'pr_gaurdion_anuval_income'=>$guardion_anuval_income,
'pr_father_accu'=>$father_accupation,
'pr_mother_accu'=>$mother_accupation,
'pr_gaurdion_accu'=>$guardion_accupation,
'pr_local_address'=>$local_address,
'pr_local_area'=>$local_area,
'pr_local_city'=>$local_city,
'pr_local_state'=>$local_state,
'pr_local_country'=>$local_country,
'pr_local_pincode'=>$local_pincode,
'pr_permanent_address'=>$pr_address,
'pr_permanent_area'=>$pr_area,
'pr_permanent_city'=>$pr_city,
'pr_permanent_state'=>$pr_state,
'pr_permanent_country'=>$pr_country,
'pr_permanent_pincode'=>$pr_pincode,
'pr_identification_one'=>$identification_one,
'pr_identification_two'=>$identification_two,
'pr_differently_abled'=>$abled,
'pr_differently_abled_reson'=>$abled_reason,
'pr_abled_certificate'=>$abled_certificate,



'pr_incom_cer'=>$incimeccname,
////////////////////////

'pr_name_of_game'=>$sports_name,
'pr_game_position'=>$sports_psition,
'pr_extra_caricular_act'=>$extra_caricular_activities,
'pr_acknoledge'=>$acknoledgement,
'pr_other_res'=>$other_res,
'pr_other_special_reservation'=>$other_special_reservation,
'pr_hostel'=>$hostel,
);








$sslc  = $this->input->post('sslc');
$plus_one  = $this->input->post('plus_one');
$plus_two  = $this->input->post('plus_two');
$ug  = $this->input->post('ug');



$sslc_ins  = $this->input->post('sslc_ins');
$plus_one_ins  = $this->input->post('plus_one_ins');
$plus_two_ins  = $this->input->post('plus_two_ins');
$ug_ins  = $this->input->post('ug_ins');


$sslc_max_mark  = $this->input->post('sslc_max_mark');
$sslc_mark_obtain  = $this->input->post('sslc_mark_obtain');
$sslc_grade  = $this->input->post('sslc_grade');
$sslc_percentage  = $this->input->post('sslc_percentage');

$plus_one_max_mark  = $this->input->post('plus_one_max_mark');
$plus_one_mark_obtain  = $this->input->post('plus_one_mark_obtain');
$plus_one_grade  = $this->input->post('plus_one_grade');
$plus_one_percentage  = $this->input->post('plus_one_percentage');

$plus_two_max_mark  = $this->input->post('plus_two_max_mark');
$plus_two_mark_obtain  = $this->input->post('plus_two_mark_obtain');
$plus_two_grade  = $this->input->post('plus_two_grade');
$plus_two_percentage  = $this->input->post('plus_two_percentage');

$UG_max_mark  = $this->input->post('UG_max_mark');
$UG_mark_obtain  = $this->input->post('UG_mark_obtain');
$UG_grade  = $this->input->post('UG_grade');
$UG_two_percentage  = $this->input->post('UG_two_percentage');








	
		
		$subject_mark = array(


			'sslc_subject'=>$sslc,
			'sslc_max_mark'=>$sslc_max_mark,
			'sslc_mark_obtain'=>$sslc_mark_obtain,
			'sslc_grade'=>$sslc_grade,
			'sslc_percentage'=>$sslc_percentage,
		
			'plus_one_subject'=>$plus_one,
			'plus_one_max_mark'=>$plus_one_max_mark,
			'plus_one_mark_obtain'=>$plus_one_mark_obtain,
			'plus_one_grade'=>$plus_one_grade,
			'plus_one_percentage'=>$plus_one_percentage,
		
		
			'plus_two_subjec'=>$plus_two,
			'plus_two_max_mark'=>$plus_two_max_mark,
			'plus_two_mark_obtain'=>$plus_two_mark_obtain,
			'plus_two_grade'=>$plus_two_grade,
			'plus_two_percentage'=>$plus_two_percentage,
		
		
			'UG_subject'=>$ug,
			'UG_max_mark'=>$UG_max_mark,
			'UG_mark_obtain'=>$UG_mark_obtain,
			'UG_grade'=>$UG_grade,
			'UG_two_percentage'=>$UG_two_percentage,
		
			'sslc_institution'=>$sslc_ins,
			'plus_one_institution'=>$plus_one_ins,
			'plus_two_institution'=>$plus_two_ins,
			'ug_institution'=>$ug_ins,
			
		
		);
		
		
	$this->db->where('pr_user_id',$this->session->userdata('user')['user_id']);
	$this->db->update('new_preview_pg',$update_details);




	$this->db->where('sb_u_id',$this->session->userdata('user')['user_id']);
	$this->db->update('sub_preview_pg',$subject_mark);


	$this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Success !</strong> Application Updated Successfully .
	</div>');
	

		redirect('Home/updateApplication');

	

		
}
public function SaveApplicationPg(){

	//$image_P=NULL;

$payed=$this->uri->segment(3);
$apply = $this->input->post('appli');



	$image_P = $this->input->post('ppimage');
	$stu_certificate = $this->input->post('stu_certificate');


	$this->upload->initialize($this->do_upload());
	$hh =$this->upload->do_upload('profile-img');
	$dataInfo = $this->upload->data();
	

		if($hh){

		

			$filename =$dataInfo['file_name'];
		}else{
			if($image_P == null){
						$filename = null;
			}else{

				$filename = $image_P;

			}
		}
		//$this->upload->initialize($this->do_upload());

		///==================Semester one=======================//
		$semester_1_name = $this->input->post('stu_pr_semester_1');
		$semester_1_file =$this->upload->do_upload('pr_semester_1');
		$upload_semester_1_file = $this->upload->data();
		
	
			if($semester_1_file){
	
			
	
				$pr_semester_1 =$upload_semester_1_file['file_name'];
			}else{
				if($semester_1_name == null){
							$pr_semester_1 = null;
				}else{
	
					$pr_semester_1 = $semester_1_name;
	
				}
			}

		///==================Semester two=======================//
		$semester_2_name = $this->input->post('stu_pr_semester_2');
		$semester_2_file =$this->upload->do_upload('pr_semester_2');
		$upload_semester_2_file = $this->upload->data();
		
	
			if($semester_2_file){
	
			
	
				$pr_semester_2 =$upload_semester_2_file['file_name'];
			}else{
				if($semester_2_name == null){
							$pr_semester_2 = null;
				}else{
	
					$pr_semester_2 = $semester_2_name;
	
				}
			}
		///==================Semester three=======================//
		$semester_3_name = $this->input->post('stu_pr_semester_3');
		$semester_3_file =$this->upload->do_upload('pr_semester_3');
		$upload_semester_3_file = $this->upload->data();
		
	
			if($semester_3_file){
	
			
	
				$pr_semester_3 =$upload_semester_3_file['file_name'];
			}else{
				if($semester_3_name == null){
							$pr_semester_3 = null;
				}else{
	
					$pr_semester_3 = $semester_3_name;
	
				}
			}
	
		///==================Semester Four=======================//
		$semester_4_name = $this->input->post('stu_pr_semester_4');
		$semester_4_file =$this->upload->do_upload('pr_semester_4');
		$upload_semester_4_file = $this->upload->data();
		
	
			if($semester_4_file){
	
			
	
				$pr_semester_4 =$upload_semester_4_file['file_name'];
			}else{
				if($semester_4_name == null){
							$pr_semester_4 = null;
				}else{
	
					$pr_semester_4 = $semester_4_name;
	
				}
			}



	///==================Semester Five=======================//
	$semester_5_name = $this->input->post('stud_pr_semester_5');
	$semester_5_file =$this->upload->do_upload('pr_semester_5');
	$upload_semester_5_file = $this->upload->data();
	

		if($semester_5_file){

		

			$pr_semester_5 =$upload_semester_5_file['file_name'];
		}else{
			if($semester_5_name == null){
						$pr_semester_5 = null;
			}else{

				$pr_semester_5 = $semester_5_name;

			}
		}


	///==================Semester SIX=======================//
	$semester_6_name = $this->input->post('stud_pr_semester_6');
	$semester_6_file =$this->upload->do_upload('pr_semester_6');
	$upload_semester_6_file = $this->upload->data();
	

		if($semester_6_file){

		

			$pr_semester_6 =$upload_semester_6_file['file_name'];
		}else{
			if($semester_6_name == null){
						$pr_semester_6 = null;
			}else{

				$pr_semester_6 = $semester_6_name;

			}
		}


	///==================Semester Seven=======================//
	$semester_7_name = $this->input->post('stud_pr_semester_7');
	$semester_7_file =$this->upload->do_upload('pr_semester_7');
	$upload_semester_7_file = $this->upload->data();
	

		if($semester_7_file){

		

			$pr_semester_7 =$upload_semester_7_file['file_name'];
		}else{
			if($semester_7_name == null){
						$pr_semester_7 = null;
			}else{

				$pr_semester_7 = $semester_7_name;

			}
		}


	///==================Semester Eight=======================//
	$semester_8_name = $this->input->post('stud_pr_semester_8');
	$semester_8_file =$this->upload->do_upload('pr_semester_8');
	$upload_semester_8_file = $this->upload->data();
	

		if($semester_8_file){

		

			$pr_semester_8 =$upload_semester_8_file['file_name'];
		}else{
			if($semester_8_name == null){
						$pr_semester_8 = null;
			}else{

				$pr_semester_8 = $semester_8_name;

			}
		}


////=======================dessiabledr=====================//

$abled_cert_name = $this->input->post('abled_cert_name');
$abled_cer = $this->upload->do_upload('abled_certificate');
$dataabled = $this->upload->data();


if($abled_cer){



	$abled_certificate =$dataabled['file_name'];
}else{
	if($abled_cert_name == null){
				$abled_certificate = null;
	}else{

		$abled_certificate = $abled_cert_name;

	}
}


	///==================Provisional=======================//
	$semester_9_name = $this->input->post('stud_pr_provisional_pg_cer');
	$semester_9_file =$this->upload->do_upload('pr_provisional_pg_cer');
	$upload_semester_9_file = $this->upload->data();
	

		if($semester_9_file){

		

			$pr_semester_9 =$upload_semester_9_file['file_name'];
		}else{
			if($semester_9_name == null){
						$pr_semester_9 = null;
			}else{

				$pr_semester_9 = $semester_9_name;

			}
		}


			///==================UG=======================//
	$semester_10_name = $this->input->post('stud_pr_ug_cer');
	$semester_10_file =$this->upload->do_upload('pr_ug_cer');
	$upload_semester_10_file = $this->upload->data();
	

		if($semester_10_file){

		

			$pr_semester_10 =$upload_semester_10_file['file_name'];
		}else{
			if($semester_10_name == null){
						$pr_semester_10 = null;
			}else{

				$pr_semester_10 = $semester_10_name;

			}
		}


			///==================Comunity =======================//
			$semester_11_name = $this->input->post('stud_pr_community_cer');
			$semester_11_file =$this->upload->do_upload('pr_community_cer');
			$upload_semester_11_file = $this->upload->data();
			
		
				if($semester_11_file){
		
		
					$pr_semester_11 =$upload_semester_11_file['file_name'];
				}else{
					if($semester_11_name == null){
								$pr_semester_11 = null;
					}else{
		
						$pr_semester_11 = $semester_11_name;
		
					}
				}
		
			///==================Cummulative=======================//
			$semester_12_name = $this->input->post('stud_pr_cummulative_cer');
			$semester_12_file =$this->upload->do_upload('pr_cummulative_cer');
			$upload_semester_12_file = $this->upload->data();
			
		
				if($semester_12_file){
		
				
		
					$pr_semester_12 =$upload_semester_12_file['file_name'];
				}else{
					if($semester_12_name == null){
								$pr_semester_12 = null;
					}else{
		
						$pr_semester_12 = $semester_12_name;
		
					}
				}	

	///==================Transfer=======================//
	$semester_13_name = $this->input->post('stud_pr_transfer_cer');
	$semester_13_file =$this->upload->do_upload('pr_transfer_cer');
	$upload_semester_13_file = $this->upload->data();
	

		if($semester_13_file){

		

			$pr_semester_13 =$upload_semester_13_file['file_name'];
		}else{
			if($semester_13_name == null){
						$pr_semester_13 = null;
			}else{

				$pr_semester_13 = $semester_13_name;

			}
		}
		
		



	///==================Transfer=======================//
	$semester_14_name = $this->input->post('stud_pr_conduct_cer');
	$semester_14_file =$this->upload->do_upload('pr_conduct_cer');
	$upload_semester_14_file = $this->upload->data();
	

		if($semester_14_file){

		

			$pr_semester_14 =$upload_semester_14_file['file_name'];
		}else{
			if($semester_14_name == null){
						$pr_semester_14 = null;
			}else{

				$pr_semester_14 = $semester_14_name;

			}
		}	
		
			////=======================Income Certificate =====================//

			$image_income_name = $this->input->post('stud_pr_incom_cer');
			$income =$this->upload->do_upload('pr_incom_cer');
			$dataInfoincome = $this->upload->data();
		
	
			if($income){
	
			
	
				$incimeccname =$dataInfoincome['file_name'];

			}else{
				if($image_income_name == null){
							$image_income_name = null;
				}else{
	
					$incimeccname = $image_income_name;
	
				}
			}

//--------------------------------basic------------------//

$pr_scolorship = $this->input->post('pr_scolorship');
$pr_ug_psy = $this->input->post('pr_ug_psy');
$candidate_name = $this->input->post('candidate_name');





$course_msw_aided = $this->input->post('msw_aided');
$course_aided = implode(",",(array)$course_msw_aided);


$course_msw_self = $this->input->post('msw_self_finance');
$course_self = implode(",",(array)$course_msw_self);


$course_one = $this->input->post('course_one');
$course_pg = implode(",",(array)$course_one);

$course_two = $this->input->post('course_two');
$course_three = $this->input->post('course_three');
$language_offered = $this->input->post('language_offered');
$dob = $this->input->post('dob');
$age = $this->input->post('age');
$m_tounge = $this->input->post('m_tounge');
$place_of_birth = $this->input->post('place_of_birth');
$gender = $this->input->post('gender');
$Nationality = $this->input->post('Nationality');

//new --entery //
$country = $this->input->post('country');
$passportnumber = $this->input->post('passportnumber');
$pp_exp = $this->input->post('pp_exp');
$blood_group = $this->input->post('blood_group');


$Religion = $this->input->post('Religion');
$Caste = $this->input->post('Caste');
$tamilnadustate = $this->input->post('tamilnadustate');
$Community = $this->input->post('Community');
$father_name = $this->input->post('father_name');
$mother_name = $this->input->post('mother_name');
$guardion_name = $this->input->post('guardion_name');
$father_mob_num = $this->input->post('father_mob_num');
$mother_mob_num = $this->input->post('mother_mob_num');
$guardion_mob_num = $this->input->post('guardion_mob_num');

//new --entery //
$father_email = $this->input->post('father_email');
$mother_email = $this->input->post('mother_email');
$guardion_email = $this->input->post('guardion_email');
$other_res = $this->input->post('other_res');
$other_special_reservation = $this->input->post('other_special_reservation');
$hostel = $this->input->post('hostel');


$father_accupation = $this->input->post('father_accupation');
$mother_accupation = $this->input->post('mother_accupation');
$guardion_accupation = $this->input->post('guardion_accupation');
$father_anuval_income = $this->input->post('father_anuval_income');
$mother_anuval_income = $this->input->post('mother_anuval_income');
$guardion_anuval_income = $this->input->post('guardion_anuval_income');
$local_address = $this->input->post('local_address');
$local_area = $this->input->post('local_area');
$local_city = $this->input->post('local_city');
$local_state = $this->input->post('local_state');
$local_country = $this->input->post('local_country');
$local_pincode = $this->input->post('local_pincode');
$pr_address = $this->input->post('pr_address');
$pr_area = $this->input->post('pr_area');
$pr_city = $this->input->post('pr_city');
$pr_state = $this->input->post('pr_state');
$pr_country = $this->input->post('pr_country');
$pr_pincode = $this->input->post('pr_pincode');
$identification_one = $this->input->post('identification_one');
$identification_two = $this->input->post('identification_two');
$abled = $this->input->post('abled');
$abled_reason = $this->input->post('abled_reason');





$sports_name = $this->input->post('sports_name');
$sports_psition = $this->input->post('sports_psition');
$extra_caricular_activities = $this->input->post('extra_caricular_activities');
$acknoledgement = $this->input->post('acknoledgement');




$update_details = array(
		'pr_ug_psy'=>$pr_ug_psy,
		'pr_applicant_name'=>$candidate_name,
		'pr_course_1'=>$course_pg,
		'pr_course_2'=>$course_aided,
		'pr_course_3'=>$course_self,
		'pr_language'=>$language_offered,
		'pr_dob'=>$dob,
		'pr_age'=>$age,
		'pr_mother_toung'=>$m_tounge,
		'pr_place_of_birth'=>$place_of_birth,
		'pr_gender'=>$gender,
		'pr_nationality'=>$Nationality,
		'pr_country'=>$country,
		'pr_passportnumber'=>$passportnumber,
		'pr_pp_exp'=>$pp_exp,
		'pr_blood_group'=>$blood_group,
		'pr_tamilnadustate'=>$tamilnadustate,
		'pr_religion'=>$Religion,
		'pr_caste'=>$Caste,
		'pr_community'=>$Community,
		'pr_photo'=>$filename,
		'pr_father_name'=>$father_name,
		'pr_mother_name'=>$mother_name,
		'pr_gaurdion_name'=>$guardion_name,
		'pr_father_mobnum'=>$father_mob_num,
		'pr_mother_mobnum'=>$mother_mob_num,
		'pr_gaurdion_mobnum'=>$guardion_mob_num,
		
		'pr_father_email'=>$father_email,
		'pr_mother_email'=>$mother_email,
		'pr_gaurdion_email'=>$guardion_email,


		'pr_father_anuval_income'=>$father_anuval_income,
		'pr_mother_anuval_income'=>$mother_anuval_income,
		'pr_gaurdion_anuval_income'=>$guardion_anuval_income,
		'pr_father_accu'=>$father_accupation,
		'pr_mother_accu'=>$mother_accupation,
		'pr_gaurdion_accu'=>$guardion_accupation,
		'pr_local_address'=>$local_address,
		'pr_local_area'=>$local_area,
		'pr_local_city'=>$local_city,
		'pr_local_state'=>$local_state,
		'pr_local_country'=>$local_country,
		'pr_local_pincode'=>$local_pincode,
		'pr_permanent_address'=>$pr_address,
		'pr_permanent_area'=>$pr_area,
		'pr_permanent_city'=>$pr_city,
		'pr_permanent_state'=>$pr_state,
		'pr_permanent_country'=>$pr_country,
		'pr_permanent_pincode'=>$pr_pincode,
		'pr_identification_one'=>$identification_one,
		'pr_identification_two'=>$identification_two,
		'pr_differently_abled'=>$abled,
		'pr_differently_abled_reson'=>$abled_reason,
		'pr_abled_certificate'=>$abled_certificate,




		'pr_semester_1'=>$pr_semester_1,
		'pr_semester_2'=>$pr_semester_2,
		'pr_semester_3'=>$pr_semester_3,
		'pr_semester_4'=>$pr_semester_4,
		'pr_semester_5'=>$pr_semester_5,
		'pr_semester_6'=>$pr_semester_6,
		'pr_semester_7'=>$pr_semester_7,
		'pr_semester_8'=>$pr_semester_8,

		'pr_provisional_pg_cer'=>$pr_semester_9,
		'pr_ug_cer'=>$pr_semester_10,
		'pr_community_cer'=>$pr_semester_11,
		'pr_cummulative_cer'=>$pr_semester_12,
		'pr_transfer_cer'=>$pr_semester_13,
		'pr_conduct_cer'=>$pr_semester_14,
		'pr_scolorship'=>$pr_scolorship,
		'pr_incom_cer'=>$incimeccname,
		////////////////////////
	
		'pr_name_of_game'=>$sports_name,
		'pr_game_position'=>$sports_psition,
		'pr_extra_caricular_act'=>$extra_caricular_activities,
		'pr_acknoledge'=>$acknoledgement,
		'pr_other_res'=>$other_res,
		'pr_other_special_reservation'=>$other_special_reservation,
		'pr_hostel'=>$hostel,
);



//Markdheet details
//$candidate_name = $this->input->post('candidate_name');






$sslc  = $this->input->post('sslc');
$plus_one  = $this->input->post('plus_one');
$plus_two  = $this->input->post('plus_two');
$ug  = $this->input->post('ug');



$sslc_ins  = $this->input->post('sslc_ins');
$plus_one_ins  = $this->input->post('plus_one_ins');
$plus_two_ins  = $this->input->post('plus_two_ins');
$ug_ins  = $this->input->post('ug_ins');


$sslc_max_mark  = $this->input->post('sslc_max_mark');
$sslc_mark_obtain  = $this->input->post('sslc_mark_obtain');
$sslc_grade  = $this->input->post('sslc_grade');
$sslc_percentage  = $this->input->post('sslc_percentage');

$plus_one_max_mark  = $this->input->post('plus_one_max_mark');
$plus_one_mark_obtain  = $this->input->post('plus_one_mark_obtain');
$plus_one_grade  = $this->input->post('plus_one_grade');
$plus_one_percentage  = $this->input->post('plus_one_percentage');

$plus_two_max_mark  = $this->input->post('plus_two_max_mark');
$plus_two_mark_obtain  = $this->input->post('plus_two_mark_obtain');
$plus_two_grade  = $this->input->post('plus_two_grade');
$plus_two_percentage  = $this->input->post('plus_two_percentage');

$UG_max_mark  = $this->input->post('UG_max_mark');
$UG_mark_obtain  = $this->input->post('UG_mark_obtain');
$UG_grade  = $this->input->post('UG_grade');
$UG_two_percentage  = $this->input->post('UG_two_percentage');

$subject_mark = array(


	'sslc_subject'=>$sslc,
	'sslc_max_mark'=>$sslc_max_mark,
	'sslc_mark_obtain'=>$sslc_mark_obtain,
	'sslc_grade'=>$sslc_grade,
	'sslc_percentage'=>$sslc_percentage,

	'plus_one_subject'=>$plus_one,
	'plus_one_max_mark'=>$plus_one_max_mark,
	'plus_one_mark_obtain'=>$plus_one_mark_obtain,
	'plus_one_grade'=>$plus_one_grade,
	'plus_one_percentage'=>$plus_one_percentage,


	'plus_two_subjec'=>$plus_two,
	'plus_two_max_mark'=>$plus_two_max_mark,
	'plus_two_mark_obtain'=>$plus_two_mark_obtain,
	'plus_two_grade'=>$plus_two_grade,
	'plus_two_percentage'=>$plus_two_percentage,


	'UG_subject'=>$ug,
	'UG_max_mark'=>$UG_max_mark,
	'UG_mark_obtain'=>$UG_mark_obtain,
	'UG_grade'=>$UG_grade,
	'UG_two_percentage'=>$UG_two_percentage,

	'sslc_institution'=>$sslc_ins,
	'plus_one_institution'=>$plus_one_ins,
	'plus_two_institution'=>$plus_two_ins,
	'ug_institution'=>$ug_ins,
	

);

$this->db->where('pr_user_id',$this->session->userdata('user')['user_id']);
	$this->db->update('new_preview_pg',$update_details);




	$this->db->where('sb_u_id',$this->session->userdata('user')['user_id']);
	$this->db->update('sub_preview_pg',$subject_mark);

/*  echo"<pre>";
print_r($_POST); */
 
 


if($payed == "payment"){


	$this->db->where('pr_user_id',$this->session->userdata('user')['user_id']);
	$this->db->update('new_preview_pg',$update_details);




	$this->db->where('sb_u_id',$this->session->userdata('user')['user_id']);
	$this->db->update('sub_preview_pg',$subject_mark);


	// $str = 'KVBAVICHI|'.$this->session->userdata('user')['user_id'].'|NA|100.00|NA|NA|NA|INR|NA|R|kvbavichi|NA|NA|F|NA|NA|NA|NA|NA|NA|NA|http://admission.avichicollege.edu.in/Home/viewResponse';

	//	$checksum = hash_hmac('sha256',$str,'PsbbPl3dR6HCRz432un1XozZkyuwNiBn', false);
	//	$checksum = strtoupper($checksum);
	//	echo $checksum; 
	//	$Strr = $str ."|". $checksum; 
		



	
	redirect('Home/PaymentPg/'.$payed);

}else{

	
	$this->db->where('pr_user_id',$this->session->userdata('user')['user_id']);
	$this->db->update('new_preview_pg',$update_details);




	$this->db->where('sb_u_id',$this->session->userdata('user')['user_id']);
	$this->db->update('sub_preview_pg',$subject_mark);


	$this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Success !</strong> Application Updated Successfully .
	</div>');
	
	$pyp = $this->input->post("pay");

	if($pyp == ""){
		redirect('Home/User');

	}else{
		redirect('Home/User/pay');
	}
		




}  

}public function SaveApplicationDip(){

	//$image_P=NULL;

$payed=$this->uri->segment(3);
$apply = $this->input->post('appli');



	$image_P = $this->input->post('ppimage');
	$stu_certificate = $this->input->post('stu_certificate');


	$this->upload->initialize($this->do_upload());
	$hh =$this->upload->do_upload('profile-img');
	$dataInfo = $this->upload->data();
	

		if($hh){

		

			$filename =$dataInfo['file_name'];
		}else{
			if($image_P == null){
						$filename = null;
			}else{

				$filename = $image_P;

			}
		}
		//$this->upload->initialize($this->do_upload());

		///==================Semester one=======================//
		$semester_1_name = $this->input->post('stu_pr_semester_1');
		$semester_1_file =$this->upload->do_upload('pr_semester_1');
		$upload_semester_1_file = $this->upload->data();
		
	
			if($semester_1_file){
	
			
	
				$pr_semester_1 =$upload_semester_1_file['file_name'];
			}else{
				if($semester_1_name == null){
							$pr_semester_1 = null;
				}else{
	
					$pr_semester_1 = $semester_1_name;
	
				}
			}

		///==================Semester two=======================//
		$semester_2_name = $this->input->post('stu_pr_semester_2');
		$semester_2_file =$this->upload->do_upload('pr_semester_2');
		$upload_semester_2_file = $this->upload->data();
		
	
			if($semester_2_file){
	
			
	
				$pr_semester_2 =$upload_semester_2_file['file_name'];
			}else{
				if($semester_2_name == null){
							$pr_semester_2 = null;
				}else{
	
					$pr_semester_2 = $semester_2_name;
	
				}
			}
		///==================Semester three=======================//
		$semester_3_name = $this->input->post('stu_pr_semester_3');
		$semester_3_file =$this->upload->do_upload('pr_semester_3');
		$upload_semester_3_file = $this->upload->data();
		
	
			if($semester_3_file){
	
			
	
				$pr_semester_3 =$upload_semester_3_file['file_name'];
			}else{
				if($semester_3_name == null){
							$pr_semester_3 = null;
				}else{
	
					$pr_semester_3 = $semester_3_name;
	
				}
			}
	
		///==================Semester Four=======================//
		$semester_4_name = $this->input->post('stu_pr_semester_4');
		$semester_4_file =$this->upload->do_upload('pr_semester_4');
		$upload_semester_4_file = $this->upload->data();
		
	
			if($semester_4_file){
	
			
	
				$pr_semester_4 =$upload_semester_4_file['file_name'];
			}else{
				if($semester_4_name == null){
							$pr_semester_4 = null;
				}else{
	
					$pr_semester_4 = $semester_4_name;
	
				}
			}



	///==================Semester Five=======================//
	$semester_5_name = $this->input->post('stud_pr_semester_5');
	$semester_5_file =$this->upload->do_upload('pr_semester_5');
	$upload_semester_5_file = $this->upload->data();
	

		if($semester_5_file){

		

			$pr_semester_5 =$upload_semester_5_file['file_name'];
		}else{
			if($semester_5_name == null){
						$pr_semester_5 = null;
			}else{

				$pr_semester_5 = $semester_5_name;

			}
		}


	///==================Semester SIX=======================//
	$semester_6_name = $this->input->post('stud_pr_semester_6');
	$semester_6_file =$this->upload->do_upload('pr_semester_6');
	$upload_semester_6_file = $this->upload->data();
	

		if($semester_6_file){

		

			$pr_semester_6 =$upload_semester_6_file['file_name'];
		}else{
			if($semester_6_name == null){
						$pr_semester_6 = null;
			}else{

				$pr_semester_6 = $semester_6_name;

			}
		}


	///==================Semester Seven=======================//
	$semester_7_name = $this->input->post('stud_pr_semester_7');
	$semester_7_file =$this->upload->do_upload('pr_semester_7');
	$upload_semester_7_file = $this->upload->data();
	

		if($semester_7_file){

		

			$pr_semester_7 =$upload_semester_7_file['file_name'];
		}else{
			if($semester_7_name == null){
						$pr_semester_7 = null;
			}else{

				$pr_semester_7 = $semester_7_name;

			}
		}


	///==================Semester Eight=======================//
	$semester_8_name = $this->input->post('stud_pr_semester_8');
	$semester_8_file =$this->upload->do_upload('pr_semester_8');
	$upload_semester_8_file = $this->upload->data();
	

		if($semester_8_file){

		

			$pr_semester_8 =$upload_semester_8_file['file_name'];
		}else{
			if($semester_8_name == null){
						$pr_semester_8 = null;
			}else{

				$pr_semester_8 = $semester_8_name;

			}
		}


////=======================dessiabledr=====================//

$abled_cert_name = $this->input->post('abled_cert_name');
$abled_cer = $this->upload->do_upload('abled_certificate');
$dataabled = $this->upload->data();


if($abled_cer){



	$abled_certificate =$dataabled['file_name'];
}else{
	if($abled_cert_name == null){
				$abled_certificate = null;
	}else{

		$abled_certificate = $abled_cert_name;

	}
}


	///==================Provisional=======================//
	$semester_9_name = $this->input->post('stud_pr_provisional_pg_cer');
	$semester_9_file =$this->upload->do_upload('pr_provisional_pg_cer');
	$upload_semester_9_file = $this->upload->data();
	

		if($semester_9_file){

		

			$pr_semester_9 =$upload_semester_9_file['file_name'];
		}else{
			if($semester_9_name == null){
						$pr_semester_9 = null;
			}else{

				$pr_semester_9 = $semester_9_name;

			}
		}


			///==================UG=======================//
	$semester_10_name = $this->input->post('stud_pr_ug_cer');
	$semester_10_file =$this->upload->do_upload('pr_ug_cer');
	$upload_semester_10_file = $this->upload->data();
	

		if($semester_10_file){

		

			$pr_semester_10 =$upload_semester_10_file['file_name'];
		}else{
			if($semester_10_name == null){
						$pr_semester_10 = null;
			}else{

				$pr_semester_10 = $semester_10_name;

			}
		}


			///==================Comunity =======================//
			$semester_11_name = $this->input->post('stud_pr_community_cer');
			$semester_11_file =$this->upload->do_upload('pr_community_cer');
			$upload_semester_11_file = $this->upload->data();
			
		
				if($semester_11_file){
		
		
					$pr_semester_11 =$upload_semester_11_file['file_name'];
				}else{
					if($semester_11_name == null){
								$pr_semester_11 = null;
					}else{
		
						$pr_semester_11 = $semester_11_name;
		
					}
				}
		
			///==================Cummulative=======================//
			$semester_12_name = $this->input->post('stud_pr_cummulative_cer');
			$semester_12_file =$this->upload->do_upload('pr_cummulative_cer');
			$upload_semester_12_file = $this->upload->data();
			
		
				if($semester_12_file){
		
				
		
					$pr_semester_12 =$upload_semester_12_file['file_name'];
				}else{
					if($semester_12_name == null){
								$pr_semester_12 = null;
					}else{
		
						$pr_semester_12 = $semester_12_name;
		
					}
				}	

	///==================Transfer=======================//
	$semester_13_name = $this->input->post('stud_pr_transfer_cer');
	$semester_13_file =$this->upload->do_upload('pr_transfer_cer');
	$upload_semester_13_file = $this->upload->data();
	

		if($semester_13_file){

		

			$pr_semester_13 =$upload_semester_13_file['file_name'];
		}else{
			if($semester_13_name == null){
						$pr_semester_13 = null;
			}else{

				$pr_semester_13 = $semester_13_name;

			}
		}
		
		



	///==================Transfer=======================//
	$semester_14_name = $this->input->post('stud_pr_conduct_cer');
	$semester_14_file =$this->upload->do_upload('pr_conduct_cer');
	$upload_semester_14_file = $this->upload->data();
	

		if($semester_14_file){

		

			$pr_semester_14 =$upload_semester_14_file['file_name'];
		}else{
			if($semester_14_name == null){
						$pr_semester_14 = null;
			}else{

				$pr_semester_14 = $semester_14_name;

			}
		}	
		
		

//--------------------------------basic------------------//

$candidate_name = $this->input->post('candidate_name');





$course_msw_aided = $this->input->post('msw_aided');
$course_aided = implode(",",(array)$course_msw_aided);


$course_msw_self = $this->input->post('msw_self_finance');
$course_self = implode(",",(array)$course_msw_self);


$course_one = $this->input->post('course_one');
$course_pg = implode(",",(array)$course_one);

$course_two = $this->input->post('course_two');
$course_three = $this->input->post('course_three');
$language_offered = $this->input->post('language_offered');
$dob = $this->input->post('dob');
$age = $this->input->post('age');
$m_tounge = $this->input->post('m_tounge');
$place_of_birth = $this->input->post('place_of_birth');
$gender = $this->input->post('gender');
$Nationality = $this->input->post('Nationality');

//new --entery //
$country = $this->input->post('country');
$passportnumber = $this->input->post('passportnumber');
$pp_exp = $this->input->post('pp_exp');
$blood_group = $this->input->post('blood_group');


$Religion = $this->input->post('Religion');
$tamilnadustate = $this->input->post('tamilnadustate');
$Caste = $this->input->post('Caste');
$Community = $this->input->post('Community');
$father_name = $this->input->post('father_name');
$mother_name = $this->input->post('mother_name');
$guardion_name = $this->input->post('guardion_name');
$father_mob_num = $this->input->post('father_mob_num');
$mother_mob_num = $this->input->post('mother_mob_num');
$guardion_mob_num = $this->input->post('guardion_mob_num');

//new --entery //
$father_email = $this->input->post('father_email');
$mother_email = $this->input->post('mother_email');
$guardion_email = $this->input->post('guardion_email');
$other_res = $this->input->post('other_res');
$other_special_reservation = $this->input->post('other_special_reservation');
$hostel = $this->input->post('hostel');


$father_accupation = $this->input->post('father_accupation');
$mother_accupation = $this->input->post('mother_accupation');
$guardion_accupation = $this->input->post('guardion_accupation');
$father_anuval_income = $this->input->post('father_anuval_income');
$mother_anuval_income = $this->input->post('mother_anuval_income');
$guardion_anuval_income = $this->input->post('guardion_anuval_income');
$local_address = $this->input->post('local_address');
$local_area = $this->input->post('local_area');
$local_city = $this->input->post('local_city');
$local_state = $this->input->post('local_state');
$local_country = $this->input->post('local_country');
$local_pincode = $this->input->post('local_pincode');
$pr_address = $this->input->post('pr_address');
$pr_area = $this->input->post('pr_area');
$pr_city = $this->input->post('pr_city');
$pr_state = $this->input->post('pr_state');
$pr_country = $this->input->post('pr_country');
$pr_pincode = $this->input->post('pr_pincode');
$identification_one = $this->input->post('identification_one');
$identification_two = $this->input->post('identification_two');
$abled = $this->input->post('abled');
$abled_reason = $this->input->post('abled_reason');





$sports_name = $this->input->post('sports_name');
$sports_psition = $this->input->post('sports_psition');
$extra_caricular_activities = $this->input->post('extra_caricular_activities');
$acknoledgement = $this->input->post('acknoledgement');
$pr_pourpose = $this->input->post('statement');




$update_details = array(
		'pr_applicant_name'=>$candidate_name,
		'pr_course_1'=>$course_pg,
		'pr_course_2'=>$course_aided,
		'pr_course_3'=>$course_self,
		'pr_language'=>$language_offered,
		'pr_dob'=>$dob,
		'pr_age'=>$age,
		'pr_mother_toung'=>$m_tounge,
		'pr_place_of_birth'=>$place_of_birth,
		'pr_gender'=>$gender,
		'pr_nationality'=>$Nationality,
		'pr_country'=>$country,
		'pr_passportnumber'=>$passportnumber,
		'pr_pp_exp'=>$pp_exp,
		'pr_blood_group'=>$blood_group,
		'pr_religion'=>$Religion,
		'pr_caste'=>$Caste,
		'pr_tamilnadustate'=>$tamilnadustate,
		'pr_community'=>$Community,
		'pr_photo'=>$filename,
		'pr_father_name'=>$father_name,
		'pr_mother_name'=>$mother_name,
		'pr_gaurdion_name'=>$guardion_name,
		'pr_father_mobnum'=>$father_mob_num,
		'pr_mother_mobnum'=>$mother_mob_num,
		'pr_gaurdion_mobnum'=>$guardion_mob_num,
		
		'pr_father_email'=>$father_email,
		'pr_mother_email'=>$mother_email,
		'pr_gaurdion_email'=>$guardion_email,


		'pr_father_anuval_income'=>$father_anuval_income,
		'pr_mother_anuval_income'=>$mother_anuval_income,
		'pr_gaurdion_anuval_income'=>$guardion_anuval_income,
		'pr_father_accu'=>$father_accupation,
		'pr_mother_accu'=>$mother_accupation,
		'pr_gaurdion_accu'=>$guardion_accupation,
		'pr_local_address'=>$local_address,
		'pr_local_area'=>$local_area,
		'pr_local_city'=>$local_city,
		'pr_local_state'=>$local_state,
		'pr_local_country'=>$local_country,
		'pr_local_pincode'=>$local_pincode,
		'pr_permanent_address'=>$pr_address,
		'pr_permanent_area'=>$pr_area,
		'pr_permanent_city'=>$pr_city,
		'pr_permanent_state'=>$pr_state,
		'pr_permanent_country'=>$pr_country,
		'pr_permanent_pincode'=>$pr_pincode,
		'pr_identification_one'=>$identification_one,
		'pr_identification_two'=>$identification_two,
		'pr_differently_abled'=>$abled,
		'pr_differently_abled_reson'=>$abled_reason,
		'pr_abled_certificate'=>$abled_certificate,




		'pr_semester_1'=>$pr_semester_1,
		'pr_semester_2'=>$pr_semester_2,
		'pr_semester_3'=>$pr_semester_3,
		'pr_semester_4'=>$pr_semester_4,
		'pr_semester_5'=>$pr_semester_5,
		'pr_semester_6'=>$pr_semester_6,
		'pr_semester_7'=>$pr_semester_7,
		'pr_semester_8'=>$pr_semester_8,

		'pr_provisional_pg_cer'=>$pr_semester_9,
		'pr_ug_cer'=>$pr_semester_10,
		'pr_community_cer'=>$pr_semester_11,
		'pr_cummulative_cer'=>$pr_semester_12,
		'pr_transfer_cer'=>$pr_semester_13,
		'pr_conduct_cer'=>$pr_semester_14,
		
		////////////////////////
	
		'pr_name_of_game'=>$sports_name,
		'pr_game_position'=>$sports_psition,
		'pr_extra_caricular_act'=>$extra_caricular_activities,
		'pr_acknoledge'=>$acknoledgement,
		'pr_other_res'=>$other_res,
		'pr_other_special_reservation'=>$other_special_reservation,
		'pr_pourpose'=>$pr_pourpose,
		'pr_hostel'=>$hostel,
);



//Markdheet details
//$candidate_name = $this->input->post('candidate_name');






$sslc  = $this->input->post('sslc');
$plus_one  = $this->input->post('plus_one');
$plus_two  = $this->input->post('plus_two');
$ug  = $this->input->post('ug');



$sslc_ins  = $this->input->post('sslc_ins');
$plus_one_ins  = $this->input->post('plus_one_ins');
$plus_two_ins  = $this->input->post('plus_two_ins');
$ug_ins  = $this->input->post('ug_ins');


$sslc_max_mark  = $this->input->post('sslc_max_mark');
$sslc_mark_obtain  = $this->input->post('sslc_mark_obtain');
$sslc_grade  = $this->input->post('sslc_grade');
$sslc_percentage  = $this->input->post('sslc_percentage');

$plus_one_max_mark  = $this->input->post('plus_one_max_mark');
$plus_one_mark_obtain  = $this->input->post('plus_one_mark_obtain');
$plus_one_grade  = $this->input->post('plus_one_grade');
$plus_one_percentage  = $this->input->post('plus_one_percentage');

$plus_two_max_mark  = $this->input->post('plus_two_max_mark');
$plus_two_mark_obtain  = $this->input->post('plus_two_mark_obtain');
$plus_two_grade  = $this->input->post('plus_two_grade');
$plus_two_percentage  = $this->input->post('plus_two_percentage');

$UG_max_mark  = $this->input->post('UG_max_mark');
$UG_mark_obtain  = $this->input->post('UG_mark_obtain');
$UG_grade  = $this->input->post('UG_grade');
$UG_two_percentage  = $this->input->post('UG_two_percentage');



$others_edu  = $this->input->post('others_edu');
$others_institution  = $this->input->post('others_institution');
$other_max_mark  = $this->input->post('other_max_mark');
$other_mark_obtain  = $this->input->post('other_mark_obtain');
$other_grade  = $this->input->post('other_grade');
$other_percentage  = $this->input->post('other_percentage');

$subject_mark = array(


	'sslc_subject'=>$sslc,
	'sslc_max_mark'=>$sslc_max_mark,
	'sslc_mark_obtain'=>$sslc_mark_obtain,
	'sslc_grade'=>$sslc_grade,
	'sslc_percentage'=>$sslc_percentage,

	'plus_one_subject'=>$plus_one,
	'plus_one_max_mark'=>$plus_one_max_mark,
	'plus_one_mark_obtain'=>$plus_one_mark_obtain,
	'plus_one_grade'=>$plus_one_grade,
	'plus_one_percentage'=>$plus_one_percentage,


	'plus_two_subjec'=>$plus_two,
	'plus_two_max_mark'=>$plus_two_max_mark,
	'plus_two_mark_obtain'=>$plus_two_mark_obtain,
	'plus_two_grade'=>$plus_two_grade,
	'plus_two_percentage'=>$plus_two_percentage,


	'UG_subject'=>$ug,
	'UG_max_mark'=>$UG_max_mark,
	'UG_mark_obtain'=>$UG_mark_obtain,
	'UG_grade'=>$UG_grade,
	'UG_two_percentage'=>$UG_two_percentage,

	'sslc_institution'=>$sslc_ins,
	'plus_one_institution'=>$plus_one_ins,
	'plus_two_institution'=>$plus_two_ins,
	'ug_institution'=>$ug_ins,



	'others_edu'=>$others_edu,
	'others_institution'=>$others_institution,
	'other_max_mark'=>$other_max_mark,
	'other_mark_obtain'=>$other_mark_obtain,
	'other_grade'=>$other_grade,
	'other_percentage'=>$other_percentage,

);




if (in_array("11", $course_one))
  {
 $company =[];
 $role =[];
 $from =[];
 $to =[];
 $tot =[];



	$company = $this->input->post('company');
	$role = $this->input->post('role');
	$from = $this->input->post('from');
	$to = $this->input->post('to');
	$tot = $this->input->post('tot');

	if(sizeof($company) > 0){

	for($i=0;$i < sizeof($company); $i++){

		if($company[$i] !=""){
		$data_exp = array(
			'user_id'=>$this->session->userdata('user')['user_id'],
			'company'=>$company[$i],
			'roll'=>$role[$i],
			'exp_from'=>$from[$i],
			'exp_to'=>$to[$i],
			'total_months'=>$tot[$i],
		);

		$this->db->insert('experiance_pg_dip',$data_exp);
	}
	}


	}
  }

	$this->db->where('pr_user_id',$this->session->userdata('user')['user_id']);
	$this->db->update('new_preview_dip',$update_details);

	$this->db->where('sb_u_id',$this->session->userdata('user')['user_id']);
	$this->db->update('sub_preview_dip',$subject_mark);

	if($payed == "payment"){


	$this->db->where('pr_user_id',$this->session->userdata('user')['user_id']);
	$this->db->update('new_preview_dip',$update_details);

	$this->db->where('sb_u_id',$this->session->userdata('user')['user_id']);
	$this->db->update('sub_preview_dip',$subject_mark);

	redirect('Home/PaymentDip/'.$payed);

	}else{

	
	$this->db->where('pr_user_id',$this->session->userdata('user')['user_id']);
	$this->db->update('new_preview_dip',$update_details);

	$this->db->where('sb_u_id',$this->session->userdata('user')['user_id']);
	$this->db->update('sub_preview_dip',$subject_mark);

	$this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Success !</strong> Application Updated Successfully .
	</div>');
	
	$pyp = $this->input->post("pay");

	if($pyp == ""){
		redirect('Home/User');

	}else{
		redirect('Home/User/pay');
	}
} 


}

	public function PaymentPg(){

	



	

		$this->load->view('Home/template/head');
		$this->load->view('Home/site/my_payment');
		$this->load->view('Home/template/footer');






		
	}
	
	public function PaymentUg(){

	



	

		$this->load->view('Home/template/head');
		$this->load->view('Home/site/my_payment_ug');
		$this->load->view('Home/template/footer');






		
	}	
	
	
	public function PaymentDip(){

	



	

		$this->load->view('Home/template/head');
		$this->load->view('Home/site/my_payment_dip');
		$this->load->view('Home/template/footer');






		
	}

	public function ResponsePaymentPg($id){

$id = $id;


if($id == 0){

	$this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Applied Failed !</strong> Try After Sometimes With Internet Banking.
			</div>');


	redirect('Home/dashBoard', 'refresh');


}else{





$m = $this->db->select("*")->from("Applyed_Master")->where("id",$id)->get();


 


$v = $m->result();
$user = $this->db->select("*")->from("stu_user")->where("u_id",$v[0]->user_id)->get();

$res = $user->result();

$session_data = array(
		
	
  'user_id'=> $res[0]->u_id,
  'user_m_course'=> $res[0]->u_course,
  'user_name'=> $res[0]->u_name,
  'user_email_id'=> $res[0]->u_email_id,
  'user_mobile'=> $res[0]->u_mobile,
  'user_email_valid'=> $res[0]->u_email_valid,
  'user_mobile_valid'=> $res[0]->u_mobile_valid,
  'user_mobile_valid'=> $res[0]->u_mobile_valid,
  'user_year'=>$res[0]->u_year,
  );

 $this->session->set_userdata('user', $session_data);


$prev_apply = $this->db->select("*")->from("Applyed_Cources")->where("master_id",$id)->get();


$count_prev_apply = $prev_apply->num_rows();



if($count_prev_apply == 0){



$user_id =$v[0]->user_id;

$arr_primary = array();
$arr_mswa = array();
$arr_mswf = array();


if($v[0]->pg_primary_course != "" || $v[0]->pg_primary_course != NULL){


	$arr_primary = explode(",",$v[0]->pg_primary_course);

foreach( $arr_primary as $pm ){
if($pm == 5){
	$count =  $this->count_app(1,$pm);
	$count = 000 + $count +1;
	$app_id = 	'MAHRM-23-'.$count;

	$course_name = 'M.A. Human Resource Management (SF)';

}else if($pm == 6){

	$count =  $this->count_app(1,$pm);
	$count = 000 + $count +1;
	$app_id = 	'MAHROD-23-'.$count;
	$course_name = 'M.A. Human Resource And Organization Development (SF)';
}else if($pm == 7){
	
	$count =  $this->count_app(1,$pm);
	$count = 000 + $count +1;
	$app_id = 	'MASE-23-'.$count;
	$course_name = 'M.A. Social Entrepreneurship (SF)';

}else if($pm == 8){

	$count =  $this->count_app(1,$pm);
	$count = 000 + $count +1;
	$app_id = 	'MADS-23-'.$count;
	$course_name = 'M.A. Development Studies (SF)';

}else if($pm == 9){
	
	$count =  $this->count_app(1,$pm);
	$count = 000 + $count +1;
	$app_id = 	'MSCCP-23-'.$count;
	$course_name = 'M.Sc. Counselling Psychology (SF)';

}else if($pm == 15){
	
	$count =  $this->count_app(1,$pm);
	$count = 000 + $count +1;
	$app_id = 	'MSWDE-23-'.$count;
	$course_name = 'M.S.W. Disability and Empowerment';

}else if($pm == 16){
	
	$count =  $this->count_app(1,$pm);
	$count = 000 + $count +1;
	$app_id = 	'MSCCFT-23-'.$count;
	$course_name = 'M.SC Counselling and Family Therapy(SF)';

}



$num = $this->user_count_app(1,$pm,$user_id);

if($num == 0){

$data = array(
	'master_id'=>$id,
	'main_course_id'=>1,
	'applied_course_id'=>$pm,
	'user_id'=>$user_id,
	'applied_date'=>date('Y-m-d H:i:s'),
	'application_number'=>$app_id,
	'course_name'=>$course_name,
);


$this->db->insert('Applyed_Cources',$data);
}

}
}





if($v[0]->pg_mssw_aided != "" || $v[0]->pg_mssw_aided != NULL){


	$arr_pg_mssw_aided = explode(",",$v[0]->pg_mssw_aided);





foreach( $arr_pg_mssw_aided as $pm ){
if($pm == 1){
	$count =  $this->count_app(2,$pm);
	$count = 000 + $count +1;
	$app_id = 	'MSWACD-23-'.$count;
	$course_name = 'MSW AIDED - Community Development';
}else if($pm == 2){

	$count =  $this->count_app(2,$pm);
	$count = 000 + $count +1;
	$app_id = 	'MSWAMPSW-23-'.$count;
	$course_name = 'MSW AIDED - Medical & Psychiatric Social Work';
}else if($pm == 3){
	
	$count =  $this->count_app(2,$pm);
	$count = 000 + $count +1;
	$app_id = 	'MSWAHRM-23-'.$count;
	$course_name = 'MSW AIDED - Human Resource Management';
}


$num = $this->user_count_app(2,$pm,$user_id);

if($num == 0){

$data = array(
	'master_id'=>$id,
	'main_course_id'=>2,
	'applied_course_id'=>$pm,
	'user_id'=>$user_id,
	'applied_date'=>date('Y-m-d H:i:s'),
	'application_number'=>$app_id,
	'course_name'=>$course_name,
	
);


$this->db->insert('Applyed_Cources',$data);
}

}
}



if($v[0]->pg_mssw_self != "" || $v[0]->pg_mssw_self != NULL){


	$arr_pg_mssw_self = explode(",",$v[0]->pg_mssw_self);





foreach( $arr_pg_mssw_self as $pm ){
if($pm == 1){
	$count =  $this->count_app(3,$pm);
	$count = 000 + $count +1;
	$app_id = 	'MSWSFCD-23-'.$count;
	$course_name = 'MSW SELF FIN - Community Development';
}else if($pm == 2){

	$count =  $this->count_app(3,$pm);
	$count = 000 + $count +1;
	$app_id = 	'MSWSFMPSW-23-'.$count;
	$course_name = 'MSW SELF FIN - Medical & Psychiatric Social Work';

}else if($pm == 3){
	
	$count =  $this->count_app(3,$pm);
	$count = 000 + $count +1;
	$app_id = 	'MSWSFHRM-23-'.$count;
	$course_name = 'MSW SELF FIN - Human Resource Management';

}


$num = $this->user_count_app(3,$pm,$user_id);

if($num == 0){

$data = array(
	'master_id'=>$id,
	'main_course_id'=>3,
	'applied_course_id'=>$pm,
	'user_id'=>$user_id,
	'applied_date'=>date("Y-m-d H:i:s"),
	'application_number'=>$app_id,
	'course_name'=>$course_name,
);


$this->db->insert('Applyed_Cources',$data);
}

}
}


////email//////

$usd = $this->db->select("u_name,u_email_id")->from("stu_user")->where("u_id",$user_id)->get();

$usd_res = $usd->result();



$appl = $this->db->select("course_name,application_number")->from("Applyed_Cources")->where("user_id",$user_id)->get();

$appl_res = $appl->result();


$i=1;

$html = "<table style='width:100%'>
<tr>
  <th>S.No</th>
  <th>Application Number</th>
  <th>Applied Programs</th>
</tr>";



foreach($appl_res as $apr){



	$html .= "<tr>
	  <td>".$i."</td>
	  <td>".$apr->application_number."</td>
	  <td>".$apr->course_name."</td>
	</tr>";
	


$i++;


}
$html .= "</table>";



$content="The following contact numbers / email IDs can be contacted for specific queries about the Programs<br> For any other information refer to the Prospectus or the General enquiry lines.
<b>Call Timings: 10 am-4 pm (Monday to Friday). Calls outside time and day specified will not be answered.
</b><br>
<table>
<tr>
  <th>COURSE</th>
  <th>PHONE NUMBER</th>
  <th>E-Mail</th>
</tr>
<tr>
<td>MASTER OF SOCIAL WORK (AIDED)</td>
<td>9840670517</td>
<td>KSM@MSSW.IN</td>
</tr>
<tr>
<td>MASTER OF SOCIAL WORK (SF)</td>
<td>9840580971</td>
<td>PROF.DAMEN@MSSW.IN</td>
</tr>
<tr>
<td>M.A. HUMAN RESOURCE MANAGEMENT</td>
<td>7502045805</td>
<td>HEMAKUMAR@MSSW.IN</td>
</tr>
<tr>
<td>M.A. HUMAN RESOURCES & OD</td>
<td>9710738384</td>
<td>VENKATESH@MSSW.IN</td>
</tr>
<tr>
<td>M.A. DEVELOPMENT STUDIES</td>
<td>9894190530</td>
<td>MOSES@MSSW.IN</td>
</tr>
<tr>
<td>M.A. SOCIAL ENTREPRENEURSHIP</td>
<td>9486425879</td>
<td>STEPHEN@MSSW.IN</td>
</tr>
<tr>
<td>M.SC. COUNSELLING PSYCHOLOGY</td>
<td>9884565739</td>
<td>SUBASREE@MSSW.IN</td>
</tr>
<tr>
<td>M.SC FAMILY COUNSELLING</td>
<td>9677035181</td>
<td>HANNAHJOHN@MSSW.IN</td>
</tr>
<tr>
<td>BACHELOR OF SOCIAL WORK</td>
<td>9791330837</td>
<td>THIRUMAGAL@MSSW.IN</td>
</tr>
<tr>
<td>B.SC. PSYCHOLOGY</td>
<td>8939617115</td>
<td>SANGEETH@MSSW.IN</td>
</tr>
</table>
<br>
<b>General Enquiries:</b> +91-44-28195126 / 28194566 (10 AM-4 PM)
<b>E-Mail Support:</b> admissions@mssw.in";

 $emailsignature = "<br><br><b class='signature'>Regards,<br>


The Principal,<br>
Madras School Of Social Work,<br>
32, Casa Major Road,<br>
Egmore,Chennai-600 008.<br>
Ph - 044 28194566,044 28195126</br>";


		$subject="Madras School Of Social Work ";
		$msg ="Dear " .$usd_res[0]->u_name.",<br><br>You have submitted the application successfully <br>
		<br> 
		<br>".$html." 
		<br>".$content." 
		<br> 
		<br>". $emailsignature;





		$config = array(
			'protocol' => 'smtp', 
			'smtp_host' => 'ssl://smtp.gmail.com', 
			'smtp_port' => 465, 
			'smtp_user' => 'admission.mssw@gmail.com', 
			'smtp_pass' => 'dqamafoawpedieqn',
			'mailtype' => 'html', 
			'charset' => 'iso-8859-1'
	);
	
 		


		$this->load->library('email');
		$this->email->initialize($config);
		$this->email->set_mailtype("html");
$this->email->set_newline("\r\n");




		$this->testEmail($usd_res[0]->u_email_id,$subject,$msg);



		$this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Success !</strong> Courses Applied Successfully .
			</div>');


	redirect('Home/dashBoard', 'refresh');



}else{

	$this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Already Applied !</strong> You Already Applied .
			</div>');


	redirect('Home/dashBoard', 'refresh');




}





}

	}


	public function ResponsePaymentUg($id){

		$id = $id;
		
		
		if($id == 0){
		
			$this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Applied Failed !</strong> Try After Sometimes.
					</div>');
		
		
			redirect('Home/dashBoard', 'refresh');
		
		
		}else{
		
		
		
		
		
		$m = $this->db->select("*")->from("Applyed_Master")->where("id",$id)->get();
		
		
		 
		
		
		$v = $m->result();
		
		
		$prev_apply = $this->db->select("*")->from("Applyed_Cources")->where("master_id",$id)->get();
		
		
		$count_prev_apply = $prev_apply->num_rows();
		
		
		
		if($count_prev_apply == 0){
		
		
		
		$user_id =$v[0]->user_id;
		
		$arr_primary = array();
		
		
		if($v[0]->pg_primary_course != "" || $v[0]->pg_primary_course != NULL){
		
		
			$arr_primary = explode(",",$v[0]->pg_primary_course);
		
		foreach( $arr_primary as $pm ){
		if($pm == 1){
			$count =  $this->count_app(5,$pm);
			$count = 000 + $count +1;
			$app_id = 	'BSW-23-'.$count;
		
			$course_name = 'B.S.W (SF)';
		
		}else if($pm == 2){
		
			$count =  $this->count_app(5,$pm);
			$count = 000 + $count +1;
			$app_id = 	'BSCPY-23-'.$count;
			$course_name = 'B.Sc Psychology (SF)';
		}
		
		
		
		$num = $this->user_count_app(5,$pm,$user_id);
		
		if($num == 0){
		
		$data = array(
			'master_id'=>$id,
			'main_course_id'=>5,
			'applied_course_id'=>$pm,
			'user_id'=>$user_id,
			'applied_date'=>date('Y-m-d H:i:s'),
			'application_number'=>$app_id,
			'course_name'=>$course_name,
		);
		
		
		$this->db->insert('Applyed_Cources',$data);
		}
		
		}
		}
		
		
		
		

		
		
		
		
		
		////email//////
		
		$usd = $this->db->select("u_id,u_name,u_email_id")->from("stu_user")->where("u_id",$user_id)->get();
		
		$usd_res = $usd->result();
		
		
		
		$appl = $this->db->select("course_name,application_number")->from("Applyed_Cources")->where("user_id",$user_id)->get();
		
		$appl_res = $appl->result();
		
		
		$i=1;
		
		$html = "<table style='width:100%'>
		<tr>
		  <th>S.No</th>
		  <th>Application Number</th>
		  <th>Applied Programs</th>
		</tr>";
		
		
		
		foreach($appl_res as $apr){
		
		
		
			$html .= "<tr>
			  <td>".$i."</td>
			  <td>".$apr->application_number."</td>
			  <td>".$apr->course_name."</td>
			</tr>";
			
		
		
		$i++;
		
		
		}
		$html .= "</table>";
		
		
		
		$content="The following contact numbers / email IDs can be contacted for specific queries about the Programs<br> For any other information refer to the Prospectus or the General enquiry lines.
		<b>Call Timings: 10 am-4 pm (Monday to Friday). Calls outside time and day specified will not be answered.
		</b><br>
		<table>
		<tr>
		  <th>COURSE</th>
		  <th>PHONE NUMBER</th>
		  <th>E-MAIL</th>
		</tr>
		<tr>
		<td>BACHELOR OF SOCIAL WORK</td>
		<td>9791330837</td>
		<td>THIRUMAGAL@MSSW.IN</td>
		</tr>
		<tr>
		<td>B.SC. PSYCHOLOGY</td>
		<td>8939617115</td>
		<td>SANGEETH@MSSW.IN</td>
		</tr>
		
		</table>
		<br>
		<b>General Enquiries:</b> +91-44-28195126 / 28194566 (10 AM-4 PM)
		<b>E-Mail Support:</b> admissions@mssw.in";
		
		 $emailsignature = "<br><br><b class='signature'>Regards,<br>
		
		
		The Principal,<br>
		Madras School Of Social Work,<br>
		32, Casa Major Road,<br>
		Egmore,Chennai-600 008.<br>
		Ph - 044 28194566,044 28195126</br>";
		
		
				$subject="Madras School Of Social Work ";
				$msg ="Dear " .$usd_res[0]->u_name." Reference number (23".sprintf("%'04d", $user_id)."),<br> <br>You have submitted the application successfully <br>
				<br> 
				<br>".$html." 
				<br>".$content." 
				<br> 
				<br>". $emailsignature;
		
		
		
		
		
				$config = array(
					'protocol' => 'smtp', 
					'smtp_host' => 'ssl://smtp.gmail.com', 
					'smtp_port' => 465, 
					'smtp_user' => 'admission.mssw@gmail.com', 
					'smtp_pass' => 'dqamafoawpedieqn',
					'mailtype' => 'html', 
					'charset' => 'iso-8859-1'
			);
				$this->email->initialize($config);
				$this->email->set_mailtype("html");
				$this->email->set_newline("\r\n");
				 
		
				$this->testEmail($usd_res[0]->u_email_id,$subject,$msg);
			//	$this->testEmail("yuvaraj@istudiotech.com",$subject,$msg);
		
					
				$this->smsContent1($usd_res[0]->u_mobile);
				
				/* 
					$this->testEmail("pgdhrm@mssw.in",$subject,$msg);

				


					$this->testEmail("hemakumar@mssw.in",$subject,$msg); */
				
				$dats = $this->db->select("*")->from("stu_user")->where("u_id",$user_id)->get();

				$data = $dats->result();

					$session_data = array(
		
	
						'user_id'=> $data[0]->u_id,
						'user_m_course'=> $data[0]->u_course,
						'user_name'=> $data[0]->u_name,
						'user_email_id'=> $data[0]->u_email_id,
						'user_mobile'=> $data[0]->u_mobile,
						'user_email_valid'=> $data[0]->u_email_valid,
						'user_mobile_valid'=> $data[0]->u_mobile_valid,
						'user_year'=>$data[0]->u_year,
						//'user_gst_mode'=> $data[0]->ap_gst_mode,
						//'user_id'=> $user[0]->ap_id,
						
						);
						$this->session->set_userdata('user', $session_data);
				$this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Success !</strong> Program Applied Successfully .
					</div>');
		
		
			redirect('Home/dashBoard', 'refresh');
		
		
		
		}else{
		
			$this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Already Applied !</strong> You Already Applied .
					</div>');
		
		
			redirect('Home/dashBoard', 'refresh');
		
		
		
		
		}
		
		
		
		
		
		}
		
			}

	public function ResponsePaymentDip($id){

		$id = $id;
		
		
		if($id == 0){
		
			$this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Applied Failed !</strong> Try After Sometimes.
					</div>');
		
		
			redirect('Home/dashBoard', 'refresh');
		
		
		}else{
		
		
		
		
		
		$m = $this->db->select("*")->from("Applyed_Master")->where("id",$id)->get();
		
		
		 
		
		
		$v = $m->result();
		
		
		$prev_apply = $this->db->select("*")->from("Applyed_Cources")->where("master_id",$id)->get();
		
		
		$count_prev_apply = $prev_apply->num_rows();
		
		
		
		if($count_prev_apply == 0){
		
		
		
		$user_id =$v[0]->user_id;
		
		$arr_primary = array();
		
		
		if($v[0]->pg_primary_course != "" || $v[0]->pg_primary_course != NULL){
		
		
			$arr_primary = explode(",",$v[0]->pg_primary_course);
		
		foreach( $arr_primary as $pm ){
		if($pm == 10){
			$count =  $this->count_app(4,$pm);
			$count = 000 + $count +1;
			$app_id = 	'PMIR-23-'.$count;
		
			$course_name = 'Personnel Management & Industrial Relations (SF)';
		
		}else if($pm == 11){
		
			$count =  $this->count_app(4,$pm);
			$count = 000 + $count +1;
			$app_id = 	'PGDHRM-23-'.$count;
			$course_name = 'Human Resource Management (SF)';
		}
		
		
		
		$num = $this->user_count_app(4,$pm,$user_id);
		
		if($num == 0){
		
		$data = array(
			'master_id'=>$id,
			'main_course_id'=>4,
			'applied_course_id'=>$pm,
			'user_id'=>$user_id,
			'applied_date'=>date('Y-m-d H:i:s'),
			'application_number'=>$app_id,
			'course_name'=>$course_name,
		);
		
		
		$this->db->insert('Applyed_Cources',$data);
		}
		
		}
		}

		
		////email//////
		
		$usd = $this->db->select("u_id,u_name,u_email_id")->from("stu_user")->where("u_id",$user_id)->get();
		
		$usd_res = $usd->result();
		
		
		
		$appl = $this->db->select("course_name,application_number")->from("Applyed_Cources")->where("user_id",$user_id)->get();
		
		$appl_res = $appl->result();
		
		
		$i=1;
		
		$html = "<table style='width:100%'>
		<tr>
		  <th>S.No</th>
		  <th>Application Number</th>
		  <th>Applied Programs</th>
		</tr>";
		
		
		
		foreach($appl_res as $apr){
		
		
		
			$html .= "<tr>
			  <td>".$i."</td>
			  <td>".$apr->application_number."</td>
			  <td>".$apr->course_name."</td>
			</tr>";
			
		
		
		$i++;
		
		
		}
		$html .= "</table>";
		
		
		
		$content="The following contact numbers / email IDs can be contacted for specific queries about the Programs<br> For any other information refer to the Prospectus or the General enquiry lines.
		<b>Call Timings: 10 am-4 pm (Monday to Friday). Calls outside time and day specified will not be answered.
		</b><br>
		<table>
		<tr>
		  <th>COURSE</th>
		  <th>PHONE NUMBER</th>
		  <th>E-MAIL</th>
		</tr>
		<tr>
		<td>Personnel Management & Industrial Relations</td>
		<td>7502045805</td>
		<td>hemakumar@mssw.in</td>
		</tr>
		<tr>
		<td>Human Resource Management</td>
		<td>8754488361</td>
		<td>pgdhrm@mssw.in</td>
		</tr>
		
		</table>
		<br>
		<b>General Enquiries:</b> +91-44-28195126 / 28194566 (10 AM-4 PM)
		<b>E-Mail Support:</b> admissions@mssw.in";
		
		 $emailsignature = "<br><br><b class='signature'>Regards,<br>
		
		
		The Principal,<br>
		Madras School Of Social Work,<br>
		32, Casa Major Road,<br>
		Egmore,Chennai-600 008.<br>
		Ph - 044 28194566,044 28195126</br>";
		
		
				$subject="Madras School Of Social Work ";
				$msg ="Dear " .$usd_res[0]->u_name." Reference number (23".sprintf("%'04d", $user_id)."),<br> <br>You have submitted the application successfully <br>
				<br> 
				<br>".$html." 
				<br>".$content." 
				<br> 
				<br>". $emailsignature;
		
		
		
		
		
				$config = array(
					'protocol' => 'smtp', 
					'smtp_host' => 'ssl://smtp.gmail.com', 
					'smtp_port' => 465, 
					'smtp_user' => 'admission.mssw@gmail.com', 
					'smtp_pass' => 'dqamafoawpedieqn',
					'mailtype' => 'html', 
					'charset' => 'iso-8859-1'
			);
				$this->email->initialize($config);
				$this->email->set_mailtype("html");
				$this->email->set_newline("\r\n");
				 
		
				$this->testEmail($usd_res[0]->u_email_id,$subject,$msg);
		
					
					
				$dats = $this->db->select("*")->from("stu_user")->where("u_id",$user_id)->get();

				$data = $dats->result();

					$session_data = array(
		
	
						'user_id'=> $data[0]->u_id,
						'user_m_course'=> $data[0]->u_course,
						'user_name'=> $data[0]->u_name,
						'user_email_id'=> $data[0]->u_email_id,
						'user_mobile'=> $data[0]->u_mobile,
						'user_email_valid'=> $data[0]->u_email_valid,
						'user_mobile_valid'=> $data[0]->u_mobile_valid,
						'user_year'=>$data[0]->u_year,
						//'user_gst_mode'=> $data[0]->ap_gst_mode,
						//'user_id'=> $user[0]->ap_id,
						
						);
						$this->session->set_userdata('user', $session_data);
				
				
					$this->testEmail("pgdhrm@mssw.in",$subject,$msg);

				


					$this->testEmail("hemakumar@mssw.in",$subject,$msg);

				

		
				$this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Success !</strong> Program Applied Successfully .
					</div>');
		
		
			redirect('Home/dashBoard', 'refresh');
		
		
		
		}else{
		
			$this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Already Applied !</strong> You Already Applied .
					</div>');
		
		
			redirect('Home/dashBoard', 'refresh');
		
		
		
		
		}
		
		
		
		
		
		}
		
			}



public function testCountCourse(){

echo $this->count_app(1,15);

	

}


public function count_app($pg_m,$course_id){



$m = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",$pg_m)->where("applied_course_id",$course_id)->where("id >","7056")->where("applied_date >","2023-03-31")->get();



return $m->num_rows();




}
public function user_count_app($pg_m,$course_id,$user_id){



$m = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",$pg_m)->where("applied_course_id",$course_id)->where("id >","7056")->where("user_id",$user_id)->where("applied_date >","2023-03-31")->get();



return $m->num_rows();




}



	public function previewWindow(){

		if(!isset($this->session->userdata('user')['user_id'])){
			redirect('Home/logOut', 'refresh');
			exit;
		} 

		$user_id = $this->session->userdata('user')['user_id'];
		$pr_user = $this->db->select('*')->from('new_preview')->where('pr_user_id',$user_id)->get();
		$pr_study = $this->db->select('*')->from('sub_preview')->where('sb_u_id',$user_id)->get();
	
		$q = $this->db->select('*')->from('college_course')->get();
	
	
		$data['cc'] = $q->result();
	
		$data['user'] = $pr_user->result();
		$data['Study'] = $pr_study->result();
		
		
		
		$this->load->view('Home/site/preview',$data);
	
	}
	public function previewWindowPg(){

		if(!isset($this->session->userdata('user')['user_id'])){
			redirect('Home/logOut', 'refresh');
			exit;
		} 

		$user_id = $this->session->userdata('user')['user_id'];
		$pr_user = $this->db->select('*')->from('new_preview_pg')->where('pr_user_id',$user_id)->get();
		$pr_study = $this->db->select('*')->from('sub_preview_pg')->where('sb_u_id',$user_id)->get();
	
		$q = $this->db->select('*')->from('college_course')->get();
	
	
		$data['cc'] = $q->result();
	
		$data['user'] = $pr_user->result();
		$data['Study'] = $pr_study->result();
		
		
		
		$this->load->view('Home/site/preview_pg',$data);
	
	}









	public function previewWindowDip(){

		if(!isset($this->session->userdata('user')['user_id'])){
			redirect('Home/logOut', 'refresh');
			exit;
		} 

		$user_id = $this->session->userdata('user')['user_id'];
		$pr_user = $this->db->select('*')->from('new_preview_dip')->where('pr_user_id',$user_id)->get();
		$pr_study = $this->db->select('*')->from('sub_preview_dip')->where('sb_u_id',$user_id)->get();
	
		$q = $this->db->select('*')->from('college_course')->get();
	
	
		$data['cc'] = $q->result();
	
		$data['user'] = $pr_user->result();
		$data['Study'] = $pr_study->result();
		
		
		
		$this->load->view('Home/site/preview_dip',$data);
	
	}public function previewWindowUg(){

		if(!isset($this->session->userdata('user')['user_id'])){
			redirect('Home/logOut', 'refresh');
			exit;
		} 

		$user_id = $this->session->userdata('user')['user_id'];
		$pr_user = $this->db->select('*')->from('new_preview')->where('pr_user_id',$user_id)->get();
		$pr_study = $this->db->select('*')->from('sub_preview')->where('sb_u_id',$user_id)->get();
		$pr_main_cc = $this->db->select('*')->from('sub_preview_ug_main_sub')->where('student_id',$user_id)->where("ug_mark_obtained !=",0)->get();
	
		$q = $this->db->select('*')->from('college_course')->get();
	
	
		$data['main_cc'] = $pr_main_cc->result();
		$data['cc'] = $q->result();
	
		$data['user'] = $pr_user->result();
		$data['Study'] = $pr_study->result();
		
		
		
		$this->load->view('Home/site/preview_ug',$data);
	
	}



	public function applyForm(){



	



		$rand = rand();
		

		$qt = $this->db->select('*')->from('stu_applied')->where('sa_st_id',$this->session->userdata('user')['user_id'])->get();


		$s = $qt->num_rows();
	
		
		if($s > 0){



			$this->session->set_flashdata('message', ' <div class="alert alert-info alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Already Applied !</strong> You already applied successfully .
			</div>');
			
			
				redirect('Home/User', 'refresh');


		}else{


			$data = array(
				'sa_st_id'=>$this->session->userdata('user')['user_id'],
				'sa_transaction_id'=>$rand,
				
			);

			$this->db->insert('stu_applied',$data);


			$this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Success !</strong> Applied successfully .
			</div>');


	redirect('Home/dashBoard', 'refresh');


		}



	}
	public function testPayment(){


		$this->load->view('Home/site/test');




 	

	}


	public function viewResponse(){

	$id_usr = $this->uri->segment(3);

			if($_POST['msg']){

			$_POST['msg'];
			$response = explode("|",$_POST['msg']);

			//print_r($response);

			$msg = $response[0];
			$user_id = $response[1];
			$refarance = $response[3];
			$amt = $response[4];
			$date_time = $response[13];
			$status = $response[14];
			$bank = $response[5];


			$pr_study_app = $this->db->select('*')->from('stu_applied')->where('sa_st_id',$user_id)->get();

			$ren = $pr_study_app->num_rows();

			if($id_usr == $this->session->userdata('user')['user_id']){

			$a_id = 1101 + (int)$this->session->userdata('user')['user_id'];
			$App_id = 'ACAS'.$a_id;


				$data = array(
					'sa_st_id'=>$this->session->userdata('user')['user_id'],
					'sa_bank'=>$bank,
					'sa_referance'=>$refarance,
					'sa_amount'=>$amt,
					'sa_date_time_trans'=>$date_time,
					'sa_response_status'=>$status,
					'sa_application_num'=>$App_id,
					'sa_tr_unique_num'=>$user_id,
					
					
				);

				$this->db->insert('stu_applied',$data);

		/* 		$emailsignature = "<br><br><b class='signature'>Regards,<br>

				Major Dr. I. Babu Rathinam <br>
				Principal<br>
				Avichi College of Arts and Science,<br>
				130A, Arcot Road, Virugambakkam,<br>
				Chennai – 600 092.<br>
				Ph - +91 44 2376 4227.</br>";

				$smssignature="Avichi  College(ACAS)";
						$subject="Avichi College of Arts and Science  - Application Submission";
						$msg ="Dear ".$this->session->userdata('user')['user_name'].",<br><br>We have received your application form, our interview panel will assess your academic details and get back to you if you get shortlisted for the online interview<br><br>". $emailsignature;
						$msg1 ="Dear ".$this->session->userdata('user')['user_name'].",  We have received your application form, our interview panel will assess your academic details and get back to you if you get shortlisted for the online interview  ". $smssignature;


						$this->testEmail( $this->session->userdata('user')['user_email_id'],$subject,$msg	);
						$this->smsInterface($this->session->userdata('user')['user_mobile'],$msg1); */

			$data['status'] = $status;



						$this->load->view('Home/site/paymentsuccess',$data);


			}else{



				$this->load->view('Home/site/paymentfailed');

			}
			}else{

				redirect('Home/dashBoard', 'refresh');

			}




}

public function downloadReceipt(){



	$appl = $this->db->select("main_course_id,course_name,application_number")->from("Applyed_Cources")->where("user_id",$this->session->userdata('user')['user_id'])->get();

	$appl_res = $appl->result();


	$user_com = $this->db->select("*")->from("new_preview_pg")->where("pr_user_id",$this->session->userdata('user')['user_id'])->get();

$my_com = $user_com->result();


	$table="";
	$i=1;



	$main =0;
$self =0;
$aided =0;
	foreach($appl_res as $apr){



	
  


if($apr->main_course_id  == 1){



$main++;
}
if($apr->main_course_id  == 2){



	$aided++;
}
if($apr->main_course_id  == 3){
	

$self++;
}


if($apr->main_course_id  == 1){

	$rs = 600;
}else if($apr->main_course_id  == 2){
	if($aided == 1){
		$rs = 600;
	}else if($aided == 2){
		$rs = 50;
	}else if($aided == 3){
		$rs = 50;
	}


}else if($apr->main_course_id  == 3){
	if($self == 1){
		$rs = 600;
	}else if($self == 2){
			$rs = 50;
	}else if($self == 3){
		$rs = 50;
	}
	
}




  
		$table .= "<tr>
		  <td>".$i."</td>
		  <td>".$apr->application_number."</td>
		  <td>".$apr->course_name."</td>
		  <td>".$rs." ₹ </td>
		 
		</tr>";
		
	  
	  
	  $i++;
	  
	  
	  }

	  $main_c = 0;
	  $aided_c = 0;	
	  $self_c = 0;	

	  $main_c =  $main * 600;


	  if($aided == 1){
		  $aided_c = 600;	
	  }else if($aided == 2){
		  $aided_c = 650;	
	  
	  
	  }else if($aided == 3){
		  $aided_c = 700;	
	  }else{
		  $aided_c = 0;		
	  }
	  
	  
	  if($self == 1){
		  $self_c = 600;	
	  }else if($self == 2){
		  $self_c = 650;	
	  
	  
	  }else if($self == 3){
		  $self_c = 700;	
	  }else{
		  $self_c = 0;		
	  }
	  $total = $main_c + $aided_c + $self_c;  
	  	//if($appl_res )

		  $htyml ="<table  style='width:100%'>
		  <tr>
			<th>S.No</th>
			<th>Details</th>
			<th>Fees (Rs.)</th>
		  </tr>";

		  $htyml .="<tr>
		  <td>1</td>
		  <td>Application Fees</td>
		  <td>   ".$total." ₹ </td>
		  </tr>";
		  $res_charge = 0;
if($my_com[0]->pr_community=='SC' || $my_com[0]->pr_community=='SC(A)' || $my_com[0]->pr_community=='ST'){

	(int)$res_charge = 50;


	$htyml .=" <tr>
	<td>2</td>
	<td>SC / ST Concession</td>
	<td> - ".$res_charge." ₹ </td>
	</tr>";
}
(int)$over_all_total = $total - $res_charge ;
		  $htyml .="<tr>
		  <td><b>#</b></td>
		  <td><b>Total</b></td>
		  <td><b>   ".$over_all_total." ₹ </b></td>
		  </tr></table>";

	$this->load->library('pdf');

/* 	$path = base_url().'https://admission.mssw.in//landing/images/logo.png';
	$type = pathinfo($path, PATHINFO_EXTENSION);
	$data = file_get_contents($path);
	$header = '<h2>Madras School of Social Work</h2>'; */



	$this->pdf->loadHtml('

	<!DOCTYPE html>

	<html lang="en">

	  <head>

		<meta charset="utf-8">

		<title>Application Status MSSW : '.$this->session->userdata('user')['user_name'].'</title>

		<link rel="stylesheet" href="style.css" media="all" />

	  </head>

	  <body style="margin:0px; padding:0px;">

		<header class="clearfix pdf-logo">

		<img src="https://admission.mssw.in//landing/images/mssw_logo.jpg" width="60%" height="75px;" alt="image">					

		<h2><u>Application Fees Receipt</u></h2>

		</header>
		<p>Student Name :  '.$this->session->userdata('user')['user_name'].'</p>
		<p>Reference Number :  23'.sprintf("%'04d", $this->session->userdata('user')['user_id']).'</p>

		<h4>Applied Program(s) </h4>

		<table style="width:100%">
		<tr>
		  <th>S.No</th>
		  <th>Application Number</th>
		  <th>Applied Programs</th>
		  <th>Fees (Rs.)</th>
		 
		</tr>
'.$table.'
</table>
<h4>Fees Details  </h4>
'.$htyml.'
		
<h4>Note </h4>

<p>This is a computer-generated document.  No signature is required</p>

	  </body>
	  <style>
	  header
  {
	  background-color: white;
  }
  
	  table {
  
		  border-collapse: collapse;
  
		  border-spacing: 0;
  
		  //width: 100%;
  
		  border: 1px solid #ddd;
  
		}
  
		body {
  
			  margin: 0 !important;
  
			  padding: 0 !important;
  
			font-family: Open Sans !important; 				
  
		  }
  
  
  
		th, td {
  
		  text-align: left;
  
		padding: 12px 25px;
  
		}
  
		.mark,th, td {
  
		  text-align: left;
  
		padding: 12px 10px;
  
		}
  
		.pdf-logo 
  
		{
  
		background: white;
  
		text-align :center;
  
		
  
		}
  
		.ttl 
  
		 {
  
		color:#e3000f;
  
		font-size:18px;
  
		text-transform:uppercase;	     
  
	   
  
		 }
  
		 tr:nth-child(even) {
  
  background-color: #f2f2f2;
  
  }
  
  .tbl
  
  {
  
  border:0px !important;
  
  width:100%;
  
  }
  
  
  
  #myTable
  
  {
  
  width:100%;
  
  }
  
  footer
  
  {
  
  color:#fff;
  
  padding:30px;
  
  Line-height:34px !important; 
  
  }
  
  h3
  
  {
  
  font-size:20px !important; 
  
  }
  
	  </style>
  
	</html>

	


	

	

	

	

	');
		$this->pdf->render();
		$this->pdf->stream("Madras School of Social Work Receipt :".$this->session->userdata('user')['user_name'].".pdf", array("Attachment"=>0));







}



public function TESTReceipt(){



	$appl = $this->db->select("main_course_id,course_name,application_number")->from("Applyed_Cources")->where("user_id",$this->session->userdata('user')['user_id'])->get();

	$appl_res = $appl->result();


	$user_com = $this->db->select("*")->from("new_preview_pg")->where("pr_user_id",$this->session->userdata('user')['user_id'])->get();

$my_com = $user_com->result();


	$table="";
	$i=1;



	$main =0;
$self =0;
$aided =0;
	foreach($appl_res as $apr){



	
  


if($apr->main_course_id  == 1){



$main++;
}
if($apr->main_course_id  == 2){



	$aided++;
}
if($apr->main_course_id  == 3){
	

$self++;
}


if($apr->main_course_id  == 1){

	$rs = 500;
}else if($apr->main_course_id  == 2){
	if($aided == 1){
		$rs = 500;
	}else if($aided == 2){
		$rs = 50;
	}else if($aided == 3){
		$rs = 50;
	}


}else if($apr->main_course_id  == 3){
	if($self == 1){
		$rs = 500;
	}else if($self == 2){
			$rs = 50;
	}else if($self == 3){
		$rs = 50;
	}
	
}




  
		$table .= "<tr>
		  <td>".$i."</td>
		  <td>".$apr->application_number."</td>
		  <td>".$apr->course_name."</td>
		  <td>".$rs." ₹ </td>
		 
		</tr>";
		
	  
	  
	  $i++;
	  
	  
	  }

	  $main_c = 0;
	  $aided_c = 0;	
	  $self_c = 0;	

	  $main_c =  $main * 500;


	  if($aided == 1){
		  $aided_c = 500;	
	  }else if($aided == 2){
		  $aided_c = 550;	
	  
	  
	  }else if($aided == 3){
		  $aided_c = 600;	
	  }else{
		  $aided_c = 0;		
	  }
	  
	  
	  if($self == 1){
		  $self_c = 500;	
	  }else if($self == 2){
		  $self_c = 550;	
	  
	  
	  }else if($self == 3){
		  $self_c = 600;	
	  }else{
		  $self_c = 0;		
	  }
	  $total = $main_c + $aided_c + $self_c;  
	  	//if($appl_res )

		  $htyml ="<table  style='width:100%'>
		  <tr>
			<th>S.No</th>
			<th>Details</th>
			<th>Fees</th>
		  </tr>";

		  $htyml .="<tr>
		  <td>1</td>
		  <td>Application Fees</td>
		  <td>   ".$total." ₹ </td>
		  </tr>";
		  $res_charge = 0;
if($my_com[0]->pr_community=='SC' || $my_com[0]->pr_community=='SC(A)' || $my_com[0]->pr_community=='ST'){

	(int)$res_charge = 50;


	$htyml .=" <tr>
	<td>2</td>
	<td>SC / ST Concession</td>
	<td> - ".$res_charge." ₹ </td>
	</tr>";
}
(int)$over_all_total = $total - $res_charge ;
		  $htyml .="<tr>
		  <td><b>#</b></td>
		  <td><b>Total</b></td>
		  <td><b>   ".$over_all_total." ₹ </b></td>
		  </tr></table>";

	$this->load->library('pdf');

	$path = base_url().'https://admission.mssw.in//landing/images/logo.png';
	$type = pathinfo($path, PATHINFO_EXTENSION);
	$data = file_get_contents($path);
	$header = '<h2>Madras School of Social Work</h2>';



//	$this->pdf->loadHtml('

$TTML ='	<!DOCTYPE html>

	<html lang="en">

	  <head>

		<meta charset="utf-8">

		<title>Application Status MSSW : '.$this->session->userdata('user')['user_name'].'</title>

		<link rel="stylesheet" href="style.css" media="all" />

	  </head>

	  <body style="margin:0px; padding:0px;">

		<header class="clearfix pdf-logo">

		<img src="https://admission.mssw.in//landing/images/mssw_logo.jpg" width="60%" height="75px;" alt="image">				

		<h2><u>Application Fees Receipt</u></h2>

		</header>
		<p>Student Name :  '.$this->session->userdata('user')['user_name'].'</p>
		<p>Reference Number :  23'.sprintf("%'04d", $this->session->userdata('user')['user_id']).'</p>

		<h4>Applied Cours(s) </h4>

		<table style="width:100%">
		<tr>
		  <th>S.No</th>
		  <th>Application Number</th>
		  <th>Applied Course</th>
		  <th>Fees</th>
		 
		</tr>
'.$table.'
</table>
<h4>Fees Details  </h4>
'.$htyml.'
		
<h4>Note </h4>

<p>This is a computer-generated document.  No signature is required</p>

	  </body>
	  <style>
	  header
  {
	  background-color: white;
  }
  
	  table {
  
		  border-collapse: collapse;
  
		  border-spacing: 0;
  
		  //width: 100%;
  
		  border: 1px solid #ddd;
  
		}
  
		body {
  
			  margin: 0 !important;
  
			  padding: 0 !important;
  
			font-family: Open Sans !important; 				
  
		  }
  
  
  
		th, td {
  
		  text-align: left;
  
		padding: 12px 25px;
  
		}
  
		.mark,th, td {
  
		  text-align: left;
  
		padding: 12px 10px;
  
		}
  
		.pdf-logo 
  
		{
  
		background: white;
  
		text-align :center;
  
		
  
		}
  
		.ttl 
  
		 {
  
		color:#e3000f;
  
		font-size:18px;
  
		text-transform:uppercase;	     
  
	   
  
		 }
  
		 tr:nth-child(even) {
  
  background-color: #f2f2f2;
  
  }
  
  .tbl
  
  {
  
  border:0px !important;
  
  width:100%;
  
  }
  
  #myTable
  
  {
  
  width:100%;
  
  }
  
  footer
  
  {
  
  color:#fff;
  
  padding:30px;
  
  Line-height:34px !important; 
  
  }
  
  h3
  
  {
  
  font-size:20px !important; 
  
  }
  
	  </style>
  
	</html>';
//);
	//	$this->pdf->render();
	//	$this->pdf->stream("Madras School of Social Work Receipt :".$this->session->userdata('user')['user_name'].".pdf", array("Attachment"=>0));
ECHO $TTML;
}





























public function downloadReceiptDip(){



	$appl = $this->db->select("main_course_id,course_name,application_number")->from("Applyed_Cources")->where("user_id",$this->session->userdata('user')['user_id'])->get();

	$appl_res = $appl->result();


	$user_com = $this->db->select("*")->from("new_preview_dip")->where("pr_user_id",$this->session->userdata('user')['user_id'])->get();

$my_com = $user_com->result();


	$table="";
	$i=1;



	$main =0;
$self =0;
$aided =0;
	foreach($appl_res as $apr){



	
  


if($apr->main_course_id  == 4){



$main++;
}



if($apr->main_course_id  == 4){

	$rs = 500;
}




  
		$table .= "<tr>
		  <td>".$i."</td>
		  <td>".$apr->application_number."</td>
		  <td>".$apr->course_name."</td>
		  <td>".$rs." ₹ </td>
		 
		</tr>";
		
	  
	  
	  $i++;
	  
	  
	  }

	  $main_c = 0;
	  $aided_c = 0;	
	  $self_c = 0;	

	  $main_c =  $main * 500;


	 
	  $total = $main_c ;  
	  	//if($appl_res )

		  $htyml ="<table  style='width:100%'>
		  <tr>
			<th>S.No</th>
			<th>Details</th>
			<th>Fees</th>
		  </tr>";

		  $htyml .="<tr>
		  <td>1</td>
		  <td>Application Fees</td>
		  <td>   ".$total." ₹ </td>
		  </tr>";
		  $res_charge = 0;
if($my_com[0]->pr_community=='SC' || $my_com[0]->pr_community=='SC(A)' || $my_com[0]->pr_community=='ST'){

	(int)$res_charge = 50;


	$htyml .=" <tr>
	<td>2</td>
	<td>SC / ST Concession</td>
	<td> - ".$res_charge." ₹ </td>
	</tr>";
}
(int)$over_all_total = $total - $res_charge ;
		  $htyml .="<tr>
		  <td><b>#</b></td>
		  <td><b>Total</b></td>
		  <td><b>   ".$over_all_total." ₹ </b></td>
		  </tr></table>";

	$this->load->library('pdf');

	//$path = base_url().'https://admission.mssw.in//landing/images/logo.png';
//	$type = pathinfo($path, PATHINFO_EXTENSION);
//	$data = file_get_contents($path);
	$header = '<h2>Madras School of Social Work</h2>';



	$this->pdf->loadHtml('

	<!DOCTYPE html>

	<html lang="en">

	  <head>

		<meta charset="utf-8">

		<title>Application Status MSSW : '.$this->session->userdata('user')['user_name'].'</title>

		<link rel="stylesheet" href="style.css" media="all" />

	  </head>

	  <body style="margin:0px; padding:0px;">

	  <header class="clearfix pdf-logo">

	  <img src="https://admission.mssw.in//landing/images/mssw_logo.jpg" width="60%" height="75px;" alt="image">				

		<h2><u>Application Fees Receipt</u></h2>

		</header>
		<p>Student Name :  '.$this->session->userdata('user')['user_name'].'</p>
		<p>Reference Number :  23'.sprintf("%'04d", $this->session->userdata('user')['user_id']).'</p>

		<h4>Applied Cours(s) </h4>

		<table style="width:100%">
		<tr>
		  <th>S.No</th>
		  <th>Application Number</th>
		  <th>Applied Course</th>
		  <th>Fees</th>
		 
		</tr>
'.$table.'
</table>
<h4>Fees Details  </h4>
'.$htyml.'
		
<h4>Note </h4>

<p>This is a computer-generated document.  No signature is required</p>

	  </body>

	</html>

	

	<style>
	header
{
    background-color: white;
}

	table {

		border-collapse: collapse;

		border-spacing: 0;

		//width: 100%;

		border: 1px solid #ddd;

	  }

	  body {

			margin: 0 !important;

			padding: 0 !important;

		  font-family: Open Sans !important; 				

		}



	  th, td {

		text-align: left;

	  padding: 12px 25px;

	  }

	  .mark,th, td {

		text-align: left;

	  padding: 12px 10px;

	  }

	  .pdf-logo 

	  {

	  background: white;

	  text-align :center;

	  

	  }

	  .ttl 

	   {

	  color:#e3000f;

	  font-size:18px;

	  text-transform:uppercase;	     

	 

	   }

	   tr:nth-child(even) {

background-color: #f2f2f2;

}

.tbl

{

border:0px !important;

width:100%;

}



#myTable

{

width:100%;

}

footer

{

color:#fff;

padding:30px;

Line-height:34px !important; 

}

h3

{

font-size:20px !important; 

}

	</style>
');
 	$this->pdf->render();
		$this->pdf->stream("Madras School of Social Work Receipt :".$this->session->userdata('user')['user_name'].".pdf", array("Attachment"=>0));

 





}

public function downloadReceiptUg(){



	$appl = $this->db->select("main_course_id,course_name,application_number")->from("Applyed_Cources")->where("user_id",$this->session->userdata('user')['user_id'])->get();

	$appl_res = $appl->result();


	$user_com = $this->db->select("*")->from("new_preview")->where("pr_user_id",$this->session->userdata('user')['user_id'])->get();

$my_com = $user_com->result();


	$table="";
	$i=1;



	$main =0;
$self =0;
$aided =0;
	foreach($appl_res as $apr){



	
  


if($apr->main_course_id  == 5){



$main++;
}



if($apr->main_course_id  == 5){

	$rs = 400;
}




  
		$table .= "<tr>
		  <td>".$i."</td>
		  <td>".$apr->application_number."</td>
		  <td>".$apr->course_name."</td>
		  <td>".$rs." ₹ </td>
		 
		</tr>";
		
	  
	  
	  $i++;
	  
	  
	  }

	  $main_c = 0;
	  $aided_c = 0;	
	  $self_c = 0;	

	  $main_c =  $main * 400;


	 
	  $total = $main_c ;  
	  	//if($appl_res )

		  $htyml ="<table  style='width:100%'>
		  <tr>
			<th>S.No</th>
			<th>Details</th>
			<th>Fees</th>
		  </tr>";

		  $htyml .="<tr>
		  <td>1</td>
		  <td>Application Fees</td>
		  <td>   ".$total." ₹ </td>
		  </tr>";
		  $res_charge = 0;
if($my_com[0]->pr_community=='SC' || $my_com[0]->pr_community=='SC(A)' || $my_com[0]->pr_community=='ST'){

	(int)$res_charge = 50;


	$htyml .=" <tr>
	<td>2</td>
	<td>SC / ST Concession</td>
	<td> - ".$res_charge." ₹ </td>
	</tr>";
}
(int)$over_all_total = $total - $res_charge ;
		  $htyml .="<tr>
		  <td><b>#</b></td>
		  <td><b>Total</b></td>
		  <td><b>   ".$over_all_total." ₹ </b></td>
		  </tr></table>";

	$this->load->library('pdf');

	//$path = base_url().'https://admission.mssw.in//landing/images/logo.png';
//	$type = pathinfo($path, PATHINFO_EXTENSION);
//	$data = file_get_contents($path);
	$header = '<h2>Madras School of Social Work</h2>';



	$this->pdf->loadHtml('

	<!DOCTYPE html>

	<html lang="en">

	  <head>

		<meta charset="utf-8">

		<title>Application Status MSSW : '.$this->session->userdata('user')['user_name'].'</title>

		<link rel="stylesheet" href="style.css" media="all" />

	  </head>

	  <body style="margin:0px; padding:0px;">

	
	  <header class="clearfix pdf-logo">

	  <img src="https://admission.mssw.in//landing/images/mssw_logo.jpg" width="60%" height="75px;" alt="image">				

		<h2><u>Application Fees Receipt</u></h2>

		</header>
		<p>Student Name :  '.$this->session->userdata('user')['user_name'].'</p>
		<p>Reference Number :  23'.sprintf("%'04d", $this->session->userdata('user')['user_id']).'</p>

		<h4>Applied Cours(s) </h4>

		<table style="width:100%">
		<tr>
		  <th>S.No</th>
		  <th>Application Number</th>
		  <th>Applied Course</th>
		  <th>Fees</th>
		 
		</tr>
'.$table.'
</table>
<h4>Fees Details  </h4>
'.$htyml.'
		
<h4>Note </h4>

<p>This is a computer-generated document.  No signature is required</p>

	  </body>

	</html>

	

	<style>
	header
{
    background-color: white;
}

	table {

		border-collapse: collapse;

		border-spacing: 0;

		//width: 100%;

		border: 1px solid #ddd;

	  }

	  body {

			margin: 0 !important;

			padding: 0 !important;

		  font-family: Open Sans !important; 				

		}



	  th, td {

		text-align: left;

	  padding: 12px 25px;

	  }

	  .mark,th, td {

		text-align: left;

	  padding: 12px 10px;

	  }

	  .pdf-logo 

	  {

	  background: white;

	  text-align :center;

	  

	  }

	  .ttl 

	   {

	  color:#e3000f;

	  font-size:18px;

	  text-transform:uppercase;	     

	 

	   }

	   tr:nth-child(even) {

background-color: #f2f2f2;

}

.tbl

{

border:0px !important;

width:100%;

}



#myTable

{

width:100%;

}

footer

{

color:#fff;

padding:30px;

Line-height:34px !important; 

}

h3

{

font-size:20px !important; 

}

	</style>

	

	

	

	

	');
	 $this->pdf->render();
		$this->pdf->stream("Madras School of Social Work Receipt :".$this->session->userdata('user')['user_name'].".pdf", array("Attachment"=>0));
 



//echo $htyml;


}


	public function downloadPdF(){

		$this->load->library('pdf');

		$path = base_url().'landing/images/logo.png';
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		
		$header = '<h2>Aavici college Application</h2>';


		$user_id = $this->session->userdata('user')['user_id'];
		$pr_user = $this->db->select('*')->from('new_preview')->where('pr_user_id',$user_id)->get();
		$pr_study = $this->db->select('*')->from('sub_preview')->where('sb_u_id',$user_id)->get();
	
		$q = $this->db->select('*')->from('college_course')->get();

		$cc = $q->result();
		$user = $pr_user->result();
		$Study = $pr_study->result();

				$cour_1 = $this->db->select("*")->from("college_course")->where("cs_id",$user[0]->pr_course_1)->get();
				$cour_2 = $this->db->select("*")->from("college_course")->where("cs_id",$user[0]->pr_course_2)->get();
				$cour_3 = $this->db->select("*")->from("college_course")->where("cs_id",$user[0]->pr_course_3)->get();


				$valid_cor_1 = $cour_1->num_rows();

			$valid_cor_2 = $cour_2->num_rows();

			$valid_cor_3 = $cour_3->num_rows();


			$r_cor_1 = $cour_1->result();

				$r_cor_2 = $cour_2->result();

				$r_cor_3 = $cour_3->result();


if($valid_cor_1 > 0){


$course_na_1 = $r_cor_1[0]->cs_name;


}else{

	$course_na_1 = "Not Selected";


}



if($valid_cor_2 > 0){


	$course_na_2 = $r_cor_2[0]->cs_name;
	
	
	}else{
	
		$course_na_2 = "Not Selected";
	
	
	}
					

	if($valid_cor_3 > 0){


		$course_na_3 = $r_cor_3[0]->cs_name;
		
		
		}else{
		
			$course_na_3 = "Not Selected";
		
		
		}
		






	$app = $this->db->select("*")->from("stu_applied")->where("sa_st_id",$user_id)->get();

	$appli =$app->num_rows();


	if($appli > 0){
		$applin =$app->result();

		$status = "<h2> ".$user[0]->pr_applicant_name." <br><br>  Applied Sucessfully on ".date('d-m-Y',strtotime($applin[0]->sa_date))."</h2>";



		if($applin[0]->sa_interview_date == "" || $applin[0]->sa_interview_date==null){
		$status .= "<h2> ".$user[0]->pr_applicant_name." <br><br> Interview Date Not scheduled Yet </h2>";


		}else{

			$status .= "<h2> ".$user[0]->pr_applicant_name." <br><br> Interview Date ".date('d-m-Y',strtotime($applin[0]->sa_interview_date))." And Time ".date('h : i A',strtotime($applin[0]->sa_interview_time))." </h2>";

		}


	}else{

		$status = "<h2>".$user[0]->pr_applicant_name." <br><br>  You Have Not Applied Yet ,Its a Preview </h2>";

	}
		


	$this->pdf->loadHtml('

	<!DOCTYPE html>

	<html lang="en">

	  <head>

		<meta charset="utf-8">

		<title>Application Status MSSW : '.$this->session->userdata('user')['user_name'].'</title>

		<link rel="stylesheet" href="style.css" media="all" />

	  </head>

	  <body style="margin:0px; padding:0px;">

		<header class="clearfix pdf-logo">

		<img src="'.base_url().'landing/images/mssw_logo.jpg" / >							

		

		</header>

		

		<div class="main-status">

		<table class="tbl">

		<tr>

		<td style=" width="50%;" >

		'.$status.'</td>

		<td style="float:right; width="50%;" ><img style="float:right" width="100px" src="'.base_url().'admin/uploads/'.$user[0]->pr_photo.'" /></td>			

		</tr>

		</table>

		</div>

	

		

	

		

		<main>













		<h2 class="ttl"> Basic Details</h2>





		

		<table class="table" id="myTable">

			 

				   

				


		<tr>

			<th>Preferred First Course</th>

			<td>'.$course_na_1.'</td>

		</tr>

		<tr>

			<th>Preferred Second Course</th>

			<td>'.$course_na_2.'</td>

		</tr>

		<tr>

			<th>Preferred Third Course</th>

			<td>'.$course_na_3.'</td>

		</tr>


		<tr>

			<th>Language </th>

			<td>'.$user[0]->pr_language.'</td>

		</tr>

		<tr>

			<th>Date of Birth</th>

			<td>'.date('d-M-Y',strtotime($user[0]->pr_dob)).'</td>

		</tr>

		<tr>

			<th>Age</th>

			<td>'.$user[0]->pr_age.'</td>

		</tr>

		<tr>

			<th>Gender</th>

			<td>'.$user[0]->pr_gender.'</td>

		</tr>

		<tr>

			<th>Nationality</th>

			<td>'.$user[0]->pr_nationality.'</td>

		</tr> 

		<tr>

			<th>Religion</th>

			<td>'.$user[0]->pr_religion.'</td>

		</tr>  <tr>

			<th>Caste</th>

			<td>'.$user[0]->pr_caste.'</td>

		</tr>  <tr>

			<th>Community</th>

			<td>'.$user[0]->pr_community.'</td>

		</tr>  

	</table>

	

	<h2 class="ttl">Parents / Guardians Details</h2>

	<table class="table" id="myTable">

	<tr>

<th>#</th>

<th>Father</th>

<th>Mother</th>

<th>Guardian</th>



<tr>

<th>Name</th>

<td>'.$user[0]->pr_father_name.'</td>

<td>'.$user[0]->pr_mother_name.'</td>

<td>'.$user[0]->pr_gaurdion_name.'</td>



</tr>

<tr>

<th>Mobile No.</th>

<td>'.$user[0]->pr_father_mobnum.'</td>

<td>'.$user[0]->pr_mother_mobnum.'</td>

<td>'.$user[0]->pr_gaurdion_mobnum.'</td>





</tr>

<tr>

<th>Occupation</th>

<td>'.$user[0]->pr_father_accu.'</td>

<td>'.$user[0]->pr_mother_accu.'</td>

<td>'.$user[0]->pr_gaurdion_accu.'</td>





</tr>

<tr>

<th>Annual

Income</th>

<td>'.$user[0]->pr_father_anuval_income.'</td>

<td>'.$user[0]->pr_mother_anuval_income.'</td>

<td>'.$user[0]->pr_gaurdion_anuval_income.'</td>





</tr>   



	</table>



	<h2 class="ttl">Address</h2>

	<table class="table" id="myTable">

	<tr>

<th>#</th>

<th>Local Address</th>

<th>Permanant</th>





<tr>

<th>Address</th>

<td>'.$user[0]->pr_local_address.'</td>

<td>'.$user[0]->pr_permanent_address.'</td>





</tr>

<tr>

<th>Area</th>

<td>'.$user[0]->pr_local_area.'</td>

<td>'.$user[0]->pr_permanent_area.'</td>







</tr>

<tr>

<th>City</th>

<td>'.$user[0]->pr_local_city.'</td>

<td>'.$user[0]->pr_permanent_city.'</td>



</tr>

<tr>

<th>State</th>

<td>'.$user[0]->pr_local_state.'</td>

<td>'.$user[0]->pr_permanent_state.'</td>







</tr>    

<tr>

<th>Country</th>

<td>'.$user[0]->pr_local_country.'</td>

<td>'.$user[0]->pr_permanent_country.'</td>





</tr>   

<tr>

<th>Pincode</th>

<td>'.$user[0]->pr_local_pincode.'</td>

<td>'.$user[0]->pr_permanent_pincode.'</td>



</tr>   



	</table>

  

	<h2 class="ttl">Identification Marks</h2>

	<table class="table" id="myTable">

	 

		   

		

	

	 <tr>

		 <th>1</th>

		 <td>'.$user[0]->pr_identification_one.'</td>

	 </tr>

	 <tr>

		 <th>2</th>

		 <td>'.$user[0]->pr_identification_two.'</td>

	 </tr>

   

	

 </table>

 <h2 class="ttl">Differently Abled</h2>
 <table class="table" id="myTable">

	 

 <tr>

	 <th>'.$user[0]->pr_differently_abled.'</th>

	 <td>'.$user[0]->pr_differently_abled_reson.'</td>

 </tr>

 
</table>



		<h2 class="ttl">School / Institution last attended</h2>

		<table class="table" id="myTable">

		   <tr>

			 <th>Institution</th>

			 

			 <td>'.$user[0]->pr_institute_last_attanded.'</td>

		 </tr>

		 <tr>

			 <th>Institution Name</th>

			 <td>'.$user[0]->pr_insti_name.'</td>

		 </tr>

		 <tr>

			 <th>Medium of Instruction (in+2)</th>

			 <td>'.$user[0]->pr_medium_of_instruct.'</td>

		 </tr>

		 <tr>

			 <th>Month and Year of Passing</th>

			 <td>'.$user[0]->pr_month_year_pass.'</td>

		 </tr>

		 <tr>

			 <th>Stream</th>

			 <td>'.$user[0]->pr_Stream.'</td>

		 </tr>

		 <tr>

			 <th>Passed in FIRST attempt</th>

			 <td>'.$user[0]->pr_passed_in_first_attemt.'</td>

		 </tr>

		  <tr>

			 <th>Break in Studies</th>

			 <td>'.$user[0]->pr_break_in_syudy.'</td>

		 </tr>

		 <tr>

			 <th> Reason</th>

			 <td>'.$user[0]->pr_break_reason.'</td>

		 </tr> 

		  <tr>

			 <th>Language Studied in School</th>

			 <td>'.$user[0]->pr_languvage_studied.'</td>

		 </tr>

		 <tr>

			 <th>Sports Category : Name of the Game(s)</th>

			 <td>'.$user[0]->pr_name_of_game.'</td>

		 </tr>

		 <tr>

			 <th>Position</th>

			 <td>'.$user[0]->pr_game_position.'</td>

		 </tr>

		  <tr>

			 <th>Extra - Curricular Activities</th>

			 <td>'.$user[0]->pr_extra_caricular_act.'</td>

		 </tr>

		 </table>



		 <h2 class="ttl">Mark Details</h2>

		 <table class="mark" id="myTable">

		 <tr>

		<th>Subjects</th>

		<th colspan="4">Plus One</th>

		<th colspan="3">Plus Two</th>

		

		</tr>

	<tr>

		<th>#</th>

		<th >Max. Marks</th>

		<th>Marks Obtained</th>

		<th>Class / Grade</th>

		<th>Status</th>

		<th >Max. Marks</th>

		<th>Marks Obtained</th>

		<th>Class / Grade</th>

	</tr>

	<tr>

		<td>'.$Study[0]->lang_1.'</td>

		<td >'.$Study[0]->lang_1_max_mark_plus_1.'</td>

		<td>'.$Study[0]->lang_1_mark__obtained_plus_1.'</td>

		<td>'.$Study[0]->lang_1_class_grade_plus_1.'</td>

		<td>'.$Study[0]->lang_1_status.'</td>

		<td>'.$Study[0]->lang_1_max_mark_plus_2.'</td>

		

		<td>'.$Study[0]->lang_1_mark__obtained_plus_2.'</td>

	   

		<td>'.$Study[0]->lang_1_class_grade_plus_2.'</td>

	</tr>

	<tr>

	<td>'.$Study[0]->lang_2.'</td>

		<td >'.$Study[0]->lang_2_max_mark_plus_1.'</td>

		<td>'.$Study[0]->lang_2_mark__obtained_plus_1.'</td>

		<td>'.$Study[0]->lang_2_class_grade_plus_1.'</td>

		<td>'.$Study[0]->lang_2_status.'</td>

		<td>'.$Study[0]->lang_2_max_mark_plus_2.'</td>

		<td>'.$Study[0]->lang_2_mark__obtained_plus_2.'</td>

		 <td>'.$Study[0]->lang_2_class_grade_plus_2.'</td>

	</tr>

	<tr>

		<td>'.$Study[0]->subj_1.'</td>

		<td >'.$Study[0]->subj_1_max_mark_plus_1.'</td>

		<td>'.$Study[0]->subj_1_mark__obtained_plus_1.'</td>

		<td>'.$Study[0]->subj_1_class_grade_plus_1.'</td>

		<td>'.$Study[0]->subj_1_status.'</td>

		<td>'.$Study[0]->subj_1_max_mark_plus_2.'</td>

	   

		<td>'.$Study[0]->subj_1_mark__obtained_plus_2.'</td>

	   

		<td>'.$Study[0]->subj_1_class_grade_plus_2.'</td>

	</tr>

	<tr>

	<td>'.$Study[0]->subj_2.'</td>

		<td >'.$Study[0]->subj_2_max_mark_plus_1.'</td>

		<td>'.$Study[0]->subj_2_mark__obtained_plus_1.'</td>

		<td>'.$Study[0]->subj_2_class_grade_plus_1.'</td>

		<td>'.$Study[0]->subj_2_status.'</td>

		<td>'.$Study[0]->subj_2_max_mark_plus_2.'</td>

	   

		<td>'.$Study[0]->subj_2_mark__obtained_plus_2.'</td>

	   

		<td>'.$Study[0]->subj_2_class_grade_plus_2.'</td>

	</tr>

	<tr>

		<td>'.$Study[0]->subj_3.'</td>

		<td >'.$Study[0]->subj_3_max_mark_plus_1.'</td>

		<td>'.$Study[0]->subj_3_mark__obtained_plus_1.'</td>

		<td>'.$Study[0]->subj_3_class_grade_plus_1.'</td>

		<td>'.$Study[0]->subj_3_status.'</td>

		<td>'.$Study[0]->subj_3_max_mark_plus_2.'</td>

		<td>'.$Study[0]->subj_3_mark__obtained_plus_2.'</td>

		<td>'.$Study[0]->subj_3_class_grade_plus_2.'</td>

	</tr> 

	<tr>

	<td>'.$Study[0]->subj_4.'</td>

		<td >'.$Study[0]->subj_4_max_mark_plus_1.'</td>

		<td>'.$Study[0]->subj_4_mark__obtained_plus_1.'</td>

		<td>'.$Study[0]->subj_4_class_grade_plus_1.'</td>

		<td>'.$Study[0]->subj_4_status.'</td>

		<td>'.$Study[0]->subj_4_max_mark_plus_2.'</td>

		<td>'.$Study[0]->subj_4_mark__obtained_plus_2.'</td>

		<td>'.$Study[0]->subj_4_class_grade_plus_2.'</td>

	</tr>

	<tr>

		<td>'.$Study[0]->g_total.'</td>

		<td >'.$Study[0]->g_total_max_mark_plus_1.'</td>

		<td>'.$Study[0]->g_total_mark__obtained_plus_1.'</td>

		<td>'.$Study[0]->g_total_class_grade_plus_1.'</td>

		<td></td>

		<td>'.$Study[0]->g_total_max_mark_plus_2.'</td>

		 <td>'.$Study[0]->g_total_mark__obtained_plus_2.'</td>

		<td>'.$Study[0]->g_total_class_grade_plus_2.'</td>

	</tr>

	<tr>

		<td>'.$Study[0]->m_total.'</td>

		<td >'.$Study[0]->m_total_max_mark_plus_1.'</td>

		<td>'.$Study[0]->m_total_mark__obtained_plus_1.'</td>

		<td>'.$Study[0]->m_total_class_grade_plus_1.'</td>

		<td></td>

		<td>'.$Study[0]->m_total_max_mark_plus_2.'</td>

		<td>'.$Study[0]->m_total_mark__obtained_plus_2.'</td>

		<td>'.$Study[0]->m_total_class_grade_plus_2.'</td>

	</tr>

</table>



		 

		</main>

		<footer style="background: #2F2481;">

			<h3 >Contact Us</h3>



 

	   

	



<h4><b>Address : </b>No.130A, Arcot Road,<br> Virugambakkam,<br> Chennai 600 092<br><br>



<b>Email us : </br>admissions@avichicollege.in<br>



<b>Call us : </b>044- 23764227<br>



<b>Website : </b>www.avichicollege.in</h4>



		</footer>

	  </body>

	</html>

	

	<style>

	table {

		border-collapse: collapse;

		border-spacing: 0;

		//width: 100%;

		border: 1px solid #ddd;

	  }

	  body {

			margin: 0 !important;

			padding: 0 !important;

		  font-family: Open Sans !important; 				

		}



	  th, td {

		text-align: left;

	  padding: 12px 25px;

	  }

	  .mark,th, td {

		text-align: left;

	  padding: 12px 10px;

	  }

	  .pdf-logo 

	  {

	  background: #2F2481;

	  text-align :center;

	  padding:10px 20px;

	  }

	  .ttl 

	   {

	  color:#e3000f;

	  font-size:18px;

	  text-transform:uppercase;	     

	 

	   }

	   tr:nth-child(even) {

background-color: #f2f2f2;

}

.tbl

{

border:0px !important;

width:100%;

}



#myTable

{

width:100%;

}

footer

{

color:#fff;

padding:30px;

Line-height:34px !important; 

}

h3

{

font-size:20px !important; 

}

	</style>

	

	

	

	

	');
		$this->pdf->render();
		$this->pdf->stream("Avivi college Application status :".$this->session->userdata('user')['user_name'].".pdf", array("Attachment"=>0));






	}




	
public function testEmail( $emailto,$subject,$msg){

	$html ='<html>
	<head>
	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	
	<!--[if !mso]><!-->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
	<!--<![endif]-->
	<style>
	body {
	margin: 0 !important;
	padding: 0 !important;
	-webkit-text-size-adjust: 100% !important;
	-ms-text-size-adjust: 100% !important;
	-webkit-font-smoothing: antialiased !important;
	}
	img {
	border: 0 !important;
	outline: none !important;
	}
	p {
	Margin: 0px !important; 
	padding: 0px !important;
	}
	table {
	border-collapse: collapse;
	mso-table-lspace: 0px; 
	mso-table-rspace: 0px; 
	}
	table.em_main_table {
	box-shadow: 2px 2px 11px 2px #b2acac;
	}
	td, a, span {
	border-collapse: collapse;
	mso-line-height-rule: exactly;
	}
	.ExternalClass * {
	line-height: 100%;
	}
	@media yahoo {
	.em_img {
	min-width:700px !important;
	}
	}
	.em_img {
	width: 300px !important;
	height: auto !important;
	}

	.em_defaultlink a {
	color: inherit !important;
	text-decoration: none !important;
	}
	span.MsoHyperlink {
	mso-style-priority: 99; 
	color: inherit;
	}
	span.MsoHyperlinkFollowed {
	mso-style-priority: 99; 
	color: inherit;
	}

	@media only screen and (min-width:481px) and (max-width:699px) {
	.em_main_table {
	width: 100% !important;
	}
	.em_wrapper {
	width: 100% !important;
	}
	.em_hide {
	display: none !important;
	}
	.em_img {
	width: 100% !important;
	height: auto !important;
	}
	.em_h20 {
	height: 20px !important;
	}
	.em_padd {
	padding: 20px 10px !important;
	}
	}
	
	@media screen and (max-width: 480px) {
	.em_main_table {
	width: 100% !important;
	}
	.em_wrapper {
	width: 100% !important;
	}
	.em_hide {
	display: none !important;
	}
	.em_img {
	width: 100% !important;
	height: auto !important;
	}
	.em_h20 {
	height: 20px !important;
	}
	.em_padd {
	padding: 20px 10px !important;
	}
	.em_text1 {
	font-size: 16px !important;
	line-height: 24px !important;
	}
	u + .em_body .em_full_wrap {
	width: 100% !important;
	width: 100vw !important;
	}
	}
	</style>
	</style>
	</head>
	<body class="em_body" style="margin:0px; padding:0px;" bgcolor="#efefef">
	<table class="em_full_wrap" valign="top" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#efefef" align="center">
	<tbody>
	<tr>
	<td valign="top" align="center">
	<table class="em_main_table" style="width:700px;" width="700" cellspacing="0" cellpadding="0" border="0" align="center">
	<!--Header section-->
	<tbody>
	
	<!--//Header section ends-->
	
	<!--Banner section-->
	<tr>
	<td valign="top" align="center">
	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" style="background:#eae8f9;">
	<tbody>
	<tr>
	<td valign="top" align="center">
	<img class="em_img" alt="Welcome to Email" src="https://admission.mssw.in//landing/images/mssw_logo.jpg" width="700" border="0" height="110px">
	</td>
	</tr>
	</tbody>
	</table>
	</td>
	</tr>
	<!--//Banner section ends-->
	
	<!--Content Text Section-->
	<tr>
	<td style="padding:35px 70px 30px;" class="em_padd" valign="top" bgcolor="#fff" align="center">
	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
	<tbody>
	<tr>
	<td style="font-family: Arial, sans-serif; font-size:16px; line-height:30px; " valign="top" align="">
	'.$msg.'
		
	</td>
	</tr>
	<tr>
	<td style="font-size:0px; line-height:0px; height:15px;" height="15">&nbsp;</td>
	<!--—this is space of 15px to separate two paragraphs ---->
	</tr>
	<tr>
	<td style="font-family: Arial, sans-serif; font-size:18px; line-height:22px; color:#2f2483; letter-spacing:2px; padding-bottom:12px;" valign="top" align="center">
	
	</td>
	</tr>
	<tr>
	<td class="em_h20" style="font-size:0px; line-height:0px; height:25px;" height="25">&nbsp;</td>
	<!--—this is space of 25px to separate two paragraphs ---->
	</tr>
	
	</tbody>
	</table>
	</td>
	</tr>
	
	
	<tr>
	</body>
	</html>
	';
	
		//$this->email->set_newline("\r\n");
				$this->email->from("admission.mssw@gmail.com");
				$this->email->to($emailto);
				$this->email->subject($subject);
				$this->email->message($html);
		
	
	
				
				if (!$this->email->send()){
				  $d = $this->email->print_debugger();

echo"Problem in server ";
				  print_r($d);
				}
	
	}

/* 	public function smsInterface($mobile,$msg){


		
		$stripped = str_replace(' ','%20',$msg);
		//$msg ="Thanks for Registering with us on Gamin Inztinct. OTP for mobile number verification is ". $mobile_rand;
				
		$url = "http://hpapi.dial4sms.com/SendSMS/sendmsg.php?uname=avichi&pass=Avichi@1&send=SMSINf&dest=".$mobile."&msg=".$stripped;

		$ch = curl_init();
		$timeout = 30;
		curl_setopt ($ch,CURLOPT_URL, $url) ;
		curl_setopt ($ch,CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch,CURLOPT_CONNECTTIMEOUT, $timeout) ;
		$response = curl_exec($ch) ;
		curl_close($ch) ;

	} */
public function logOut(){


	$this->session->unset_userdata('user'); 
	$this->session->unset_userdata('user_exam'); 
	redirect('Home', 'refresh');
	//$this->load->view('session_view'); 


}

public function online_payment(){







}
public function paymentProcess(){



	$image_P = $this->input->post('ppimage');
	$stu_certificate = $this->input->post('stu_certificate');


	$this->upload->initialize($this->do_upload());
	$hh =$this->upload->do_upload('profile-img');
	$dataInfo = $this->upload->data();
	

		if($hh){

		

			$filename =$dataInfo['file_name'];
		}else{
			if($image_P == null){
						$filename = null;
			}else{

				$filename = $image_P;

			}
		}
		//$this->upload->initialize($this->do_upload());

		///==================sslc=======================//
		$image_sslc = $this->input->post('stu_sslccert');
		$sslccert =$this->upload->do_upload('sslccert');
		$datasslccert = $this->upload->data();
		
	
			if($sslccert){
	
			
	
				$sslc =$datasslccert['file_name'];
			}else{
				if($image_sslc == null){
							$sslc = null;
				}else{
	
					$sslc = $image_sslc;
	
				}
			}
	
////=======================HSC FIRST=====================//
			$image_hs1 = $this->input->post('stu_hs_fir_certi');
			$hsc1 =$this->upload->do_upload('hs_fir_certi');
			$datahsc1 = $this->upload->data();
		
	
			if($hsc1){
	
			
	
				$certhsc1 =$datahsc1['file_name'];
			}else{
				if($image_hs1 == null){
							$certhsc1 = null;
				}else{
	
					$certhsc1 = $image_hs1;
	
				}
			}


////=======================HSC Second=====================//

$image_hs2 = $this->input->post('stu_hs_sec_certi');
$hsc2 =$this->upload->do_upload('hs_sec_certi');
$datahsc2 = $this->upload->data();


if($hsc2){



	$certhsc2 =$datahsc2['file_name'];
}else{
	if($image_hs2 == null){
				$certhsc2 = null;
	}else{

		$certhsc2 = $image_hs2;

	}
}





////=======================Comunity=====================//
			$image_cc = $this->input->post('stud_commcert');
			$ccc =$this->upload->do_upload('commcert');
			$dataInfod = $this->upload->data();
		
	
			if($ccc){
	
			
	
				$ccname =$dataInfod['file_name'];
			}else{
				if($image_cc == null){
							$ccname = null;
				}else{
	
					$ccname = $image_cc;
	
				}
			}


/* echo"<pre>";
print_r($dataInfo); */
//print_r($_POST);

//--------------------------------basic------------------//

$candidate_name = $this->input->post('candidate_name');
$course_one = $this->input->post('course_one');
$course_two = $this->input->post('course_two');
$course_three = $this->input->post('course_three');
$language_offered = $this->input->post('language_offered');
$dob = $this->input->post('dob');
$age = $this->input->post('age');
$gender = $this->input->post('gender');
$Nationality = $this->input->post('Nationality');
$Religion = $this->input->post('Religion');
$Caste = $this->input->post('Caste');
$Community = $this->input->post('Community');
$father_name = $this->input->post('father_name');
$mother_name = $this->input->post('mother_name');
$guardion_name = $this->input->post('guardion_name');
$father_mob_num = $this->input->post('father_mob_num');
$mother_mob_num = $this->input->post('mother_mob_num');
$guardion_mob_num = $this->input->post('guardion_mob_num');
$father_accupation = $this->input->post('father_accupation');
$mother_accupation = $this->input->post('mother_accupation');
$guardion_accupation = $this->input->post('guardion_accupation');
$father_anuval_income = $this->input->post('father_anuval_income');
$mother_anuval_income = $this->input->post('mother_anuval_income');
$guardion_anuval_income = $this->input->post('guardion_anuval_income');
$local_address = $this->input->post('local_address');
$local_area = $this->input->post('local_area');
$local_city = $this->input->post('local_city');
$local_state = $this->input->post('local_state');
$local_country = $this->input->post('local_country');
$local_pincode = $this->input->post('local_pincode');
$pr_address = $this->input->post('pr_address');
$pr_area = $this->input->post('pr_area');
$pr_city = $this->input->post('pr_city');
$pr_state = $this->input->post('pr_state');
$pr_country = $this->input->post('pr_country');
$pr_pincode = $this->input->post('pr_pincode');
$identification_one = $this->input->post('identification_one');
$identification_two = $this->input->post('identification_two');
$abled = $this->input->post('abled');
$abled_reason = $this->input->post('abled_reason');
$regnumber = $this->input->post('regnumber');
$institute = $this->input->post('institute');
$institutionname = $this->input->post('institutionname');
$study_bord = $this->input->post('study_bord');
$other_bord = $this->input->post('other_bord');
$medium = $this->input->post('medium');
$year_of_passing = $this->input->post('year_of_passing');
$break_in_study = $this->input->post('break_in_study');
$break_reason = $this->input->post('break_reason');
$stream = $this->input->post('stream');
$pass_in_first_att = $this->input->post('pass_in_first_att');
$lang_studied = $this->input->post('lang_studied');
$lang_others = $this->input->post('lang_others');
$sports_name = $this->input->post('sports_name');
$sports_psition = $this->input->post('sports_psition');
$extra_caricular_activities = $this->input->post('extra_caricular_activities');
$acknoledgement = $this->input->post('acknoledgement');




$update_details = array(
		'pr_applicant_name'=>$candidate_name,
		'pr_course_1'=>$course_one,
		'pr_course_2'=>$course_two,
		'pr_course_3'=>$course_three,
		'pr_language'=>$language_offered,
		'pr_dob'=>$dob,
		'pr_age'=>$age,
		'pr_gender'=>$gender,
		'pr_nationality'=>$Nationality,
		'pr_religion'=>$Religion,
		'pr_caste'=>$Caste,
		'pr_community'=>$Community,
		'pr_photo'=>$filename,
		'pr_father_name'=>$father_name,
		'pr_mother_name'=>$mother_name,
		'pr_gaurdion_name'=>$guardion_name,
		'pr_father_mobnum'=>$father_mob_num,
		'pr_mother_mobnum'=>$mother_mob_num,
		'pr_gaurdion_mobnum'=>$guardion_mob_num,
		'pr_father_anuval_income'=>$father_anuval_income,
		'pr_mother_anuval_income'=>$mother_anuval_income,
		'pr_gaurdion_anuval_income'=>$guardion_anuval_income,
		'pr_father_accu'=>$father_accupation,
		'pr_mother_accu'=>$mother_accupation,
		'pr_gaurdion_accu'=>$guardion_accupation,
		'pr_local_address'=>$local_address,
		'pr_local_area'=>$local_area,
		'pr_local_city'=>$local_city,
		'pr_local_state'=>$local_state,
		'pr_local_country'=>$local_country,
		'pr_local_pincode'=>$local_pincode,
		'pr_permanent_address'=>$pr_address,
		'pr_permanent_area'=>$pr_area,
		'pr_permanent_city'=>$pr_city,
		'pr_permanent_state'=>$pr_state,
		'pr_permanent_country'=>$pr_country,
		'pr_permanent_pincode'=>$pr_pincode,
		'pr_identification_one'=>$identification_one,
		'pr_identification_two'=>$identification_two,
		'pr_differently_abled'=>$abled,
		'pr_differently_abled_reson'=>$abled_reason,
		'pr_sslc_mark'=>$sslc,
		'pr_hse_certificate'=>$certhsc1,
		'pr_hse2_certificate'=>$certhsc2,
		'pr_comunity_cert'=>$ccname,
		'pr_certificate_regist_numb'=>$regnumber,
		////////////////////////
		'pr_institute_last_attanded'=>$institute,
		'pr_insti_name'=>$institutionname,
		'pr_board_study'=>$study_bord,
		'pr_bord_other'=>$other_bord,
		'pr_medium_of_instruct'=>$medium,
		'pr_month_year_pass'=>$year_of_passing,
		'pr_break_in_syudy'=>$break_in_study,
		'pr_break_reason'=>$break_reason,

//

		
		'pr_Stream'=>$stream,
		'pr_passed_in_first_attemt'=>$pass_in_first_att,
		'pr_languvage_studied'=>$lang_studied,
		'pr_others_lang'=>$lang_others,
		'pr_name_of_game'=>$sports_name,
		'pr_game_position'=>$sports_psition,
		'pr_extra_caricular_act'=>$extra_caricular_activities,
		'pr_acknoledge'=>$acknoledgement,
);



//Markdheet details
//$candidate_name = $this->input->post('candidate_name');






$result_lang_one  = $this->input->post('result_lang_one');
$result_lang_two  = $this->input->post('result_lang_two');
$result_sub_1  = $this->input->post('result_sub_1');
$result_sub_2  = $this->input->post('result_sub_2');
$result_sub_3  = $this->input->post('result_sub_3');
$result_sub_4  = $this->input->post('result_sub_4');





$lang_1  = $this->input->post('lang_1');
$lang_1_max_mark_plus_1  = $this->input->post('lang_1_max_mark_plus_1');
$lang_1_max_mark_plus_2  = $this->input->post('lang_1_max_mark_plus_2');
$lang_1_mark__obtained_plus_1  = $this->input->post('lang_1_mark__obtained_plus_1');
$lang_1_mark__obtained_plus_2  = $this->input->post('lang_1_mark__obtained_plus_2');
$lang_1_class_grade_plus_1  = $this->input->post('lang_1_class_grade_plus_1');
$lang_1_class_grade_plus_2  = $this->input->post('lang_1_class_grade_plus_2');



$lang_2  = $this->input->post('lang_2');
$lang_2_max_mark_plus_1  = $this->input->post('lang_2_max_mark_plus_1');
$lang_2_max_mark_plus_2  = $this->input->post('lang_2_max_mark_plus_2');
$lang_2_mark__obtained_plus_1  = $this->input->post('lang_2_mark__obtained_plus_1');
$lang_2_mark__obtained_plus_2  = $this->input->post('lang_2_mark__obtained_plus_2');
$lang_2_class_grade_plus_1  = $this->input->post('lang_2_class_grade_plus_1');
$lang_2_class_grade_plus_2  = $this->input->post('lang_2_class_grade_plus_2');

$subj_1  = $this->input->post('subj_1');
$subj_1_max_mark_plus_1  = $this->input->post('subj_1_max_mark_plus_1');
$subj_1_max_mark_plus_2  = $this->input->post('subj_1_max_mark_plus_2');
$subj_1_mark__obtained_plus_1  = $this->input->post('subj_1_mark__obtained_plus_1');
$subj_1_mark__obtained_plus_2  = $this->input->post('subj_1_mark__obtained_plus_2');
$subj_1_class_grade_plus_1  = $this->input->post('subj_1_class_grade_plus_1');
$subj_1_class_grade_plus_2  = $this->input->post('subj_1_class_grade_plus_2');

$subj_2  = $this->input->post('subj_2');
$subj_2_max_mark_plus_1  = $this->input->post('subj_2_max_mark_plus_1');
$subj_2_max_mark_plus_2  = $this->input->post('subj_2_max_mark_plus_2');
$subj_2_mark__obtained_plus_1  = $this->input->post('subj_2_mark__obtained_plus_1');
$subj_2_mark__obtained_plus_2  = $this->input->post('subj_2_mark__obtained_plus_2');
$subj_2_class_grade_plus_1  = $this->input->post('subj_2_class_grade_plus_1');
$subj_2_class_grade_plus_2  = $this->input->post('subj_2_class_grade_plus_2');

$subj_3  = $this->input->post('subj_3');
$subj_3_max_mark_plus_1  = $this->input->post('subj_3_max_mark_plus_1');
$subj_3_max_mark_plus_2  = $this->input->post('subj_3_max_mark_plus_2');
$subj_3_mark__obtained_plus_1  = $this->input->post('subj_3_mark__obtained_plus_1');
$subj_3_mark__obtained_plus_2  = $this->input->post('subj_3_mark__obtained_plus_2');
$subj_3_class_grade_plus_1  = $this->input->post('subj_3_class_grade_plus_1');
$subj_3_class_grade_plus_2  = $this->input->post('subj_3_class_grade_plus_2');


$subj_4  = $this->input->post('subj_4');
$subj_4_max_mark_plus_1  = $this->input->post('subj_4_max_mark_plus_1');
$subj_4_max_mark_plus_2  = $this->input->post('subj_4_max_mark_plus_2');
$subj_4_mark__obtained_plus_1  = $this->input->post('subj_4_mark__obtained_plus_1');
$subj_4_mark__obtained_plus_2  = $this->input->post('subj_4_mark__obtained_plus_2');
$subj_4_class_grade_plus_1  = $this->input->post('subj_4_class_grade_plus_1');
$subj_4_class_grade_plus_2  = $this->input->post('subj_4_class_grade_plus_2');


$g_total  = $this->input->post('g_total');
$g_total_max_mark_plus_1  = $this->input->post('g_total_max_mark_plus_1');
$g_total_max_mark_plus_2  = $this->input->post('g_total_max_mark_plus_2');
$g_total_mark__obtained_plus_1  = $this->input->post('g_total_mark__obtained_plus_1');
$g_total_mark__obtained_plus_2  = $this->input->post('g_total_mark__obtained_plus_2');
$g_total_class_grade_plus_1  = $this->input->post('g_total_class_grade_plus_1');
$g_total_class_grade_plus_2  = $this->input->post('g_total_class_grade_plus_2');

$m_total  = $this->input->post('m_total');
$m_total_max_mark_plus_1  = $this->input->post('m_total_max_mark_plus_1');
$m_total_max_mark_plus_2  = $this->input->post('m_total_max_mark_plus_2');
$m_total_mark__obtained_plus_1  = $this->input->post('m_total_mark__obtained_plus_1');
$m_total_mark__obtained_plus_2  = $this->input->post('m_total_mark__obtained_plus_2');
$m_total_class_grade_plus_1  = $this->input->post('m_total_class_grade_plus_1');
$m_total_class_grade_plus_2  = $this->input->post('m_total_class_grade_plus_2');



$subject_mark = array(


	'lang_1'=>$lang_1,
	'lang_1_max_mark_plus_1'=>$lang_1_max_mark_plus_1,
	'lang_1_max_mark_plus_2'=>$lang_1_max_mark_plus_2,
	'lang_1_mark__obtained_plus_1'=>$lang_1_mark__obtained_plus_1,
	'lang_1_mark__obtained_plus_2'=>$lang_1_mark__obtained_plus_2,
	'lang_1_class_grade_plus_1'=>$lang_1_class_grade_plus_1,
	'lang_1_class_grade_plus_2'=>$lang_1_class_grade_plus_2,

	'lang_2'=>$lang_2,
	'lang_2_max_mark_plus_1'=>$lang_2_max_mark_plus_1,
	'lang_2_max_mark_plus_2'=>$lang_2_max_mark_plus_2,
	'lang_2_mark__obtained_plus_1'=>$lang_2_mark__obtained_plus_1,
	'lang_2_mark__obtained_plus_2'=>$lang_2_mark__obtained_plus_2,
	'lang_2_class_grade_plus_1'=>$lang_2_class_grade_plus_1,
	'lang_2_class_grade_plus_2'=>$lang_2_class_grade_plus_2,

	'subj_1'=>$subj_1,
	'subj_1_max_mark_plus_1'=>$subj_1_max_mark_plus_1,
	'subj_1_max_mark_plus_2'=>$subj_1_max_mark_plus_2,
	'subj_1_mark__obtained_plus_1'=>$subj_1_mark__obtained_plus_1,
	'subj_1_mark__obtained_plus_2'=>$subj_1_mark__obtained_plus_2,
	'subj_1_class_grade_plus_1'=>$subj_1_class_grade_plus_1,
	'subj_1_class_grade_plus_2'=>$subj_1_class_grade_plus_2,


	'subj_2'=>$subj_2,
	'subj_2_max_mark_plus_1'=>$subj_2_max_mark_plus_1,
	'subj_2_max_mark_plus_2'=>$subj_2_max_mark_plus_2,
	'subj_2_mark__obtained_plus_1'=>$subj_2_mark__obtained_plus_1,
	'subj_2_mark__obtained_plus_2'=>$subj_2_mark__obtained_plus_2,
	'subj_2_class_grade_plus_1'=>$subj_2_class_grade_plus_1,
	'subj_2_class_grade_plus_2'=>$subj_2_class_grade_plus_2,

	'subj_3'=>$subj_3,
	'subj_3_max_mark_plus_1'=>$subj_3_max_mark_plus_1,
	'subj_3_max_mark_plus_2'=>$subj_3_max_mark_plus_2,
	'subj_3_mark__obtained_plus_1'=>$subj_3_mark__obtained_plus_1,
	'subj_3_mark__obtained_plus_2'=>$subj_3_mark__obtained_plus_2,
	'subj_3_class_grade_plus_1'=>$subj_3_class_grade_plus_1,
	'subj_3_class_grade_plus_2'=>$subj_3_class_grade_plus_2,

	'subj_4'=>$subj_4,
	'subj_4_max_mark_plus_1'=>$subj_4_max_mark_plus_1,
	'subj_4_max_mark_plus_2'=>$subj_4_max_mark_plus_2,
	'subj_4_mark__obtained_plus_1'=>$subj_4_mark__obtained_plus_1,
	'subj_4_mark__obtained_plus_2'=>$subj_4_mark__obtained_plus_2,
	'subj_4_class_grade_plus_1'=>$subj_4_class_grade_plus_1,
	'subj_4_class_grade_plus_2'=>$subj_4_class_grade_plus_2,

	'g_total'=>$g_total,
	'g_total_max_mark_plus_1'=>$g_total_max_mark_plus_1,
	'g_total_max_mark_plus_2'=>$g_total_max_mark_plus_2,
	'g_total_mark__obtained_plus_1'=>$g_total_mark__obtained_plus_1,
	'g_total_mark__obtained_plus_2'=>$g_total_mark__obtained_plus_2,
	'g_total_class_grade_plus_1'=>$g_total_class_grade_plus_1,
	'g_total_class_grade_plus_2'=>$g_total_class_grade_plus_2,

	'm_total'=>$m_total,
	'm_total_max_mark_plus_1'=>$m_total_max_mark_plus_1,
	'm_total_max_mark_plus_2'=>$m_total_max_mark_plus_2,
	'm_total_mark__obtained_plus_1'=>$m_total_mark__obtained_plus_1,
	'm_total_mark__obtained_plus_2'=>$m_total_mark__obtained_plus_2,
	'm_total_class_grade_plus_1'=>$m_total_class_grade_plus_1,
	'm_total_class_grade_plus_2'=>$m_total_class_grade_plus_2,


	'lang_1_status'=>$result_lang_one,
	'lang_2_status'=>$result_lang_two,
	'subj_1_status'=>$result_sub_1,
	'subj_2_status'=>$result_sub_2,
	'subj_3_status'=>$result_sub_3,
	'subj_4_status'=>$result_sub_4,

);



	$this->db->where('pr_user_id',$this->session->userdata('user')['user_id']);
	$this->db->update('new_preview',$update_details);




	$this->db->where('sb_u_id',$this->session->userdata('user')['user_id']);
	$this->db->update('sub_preview',$subject_mark);


echo 1 ;







}

public function do_upload(){


	$config = array();
	$config['upload_path'] = 'admin/uploads/';
	$config['allowed_types'] = '*';
	$config['remove_spaces'] = TRUE;
	$config['encrypt_name'] = TRUE;
	return $config;
	
	}
	
	public function do_uploadAadhaar(){


	$config = array();
	$config['upload_path'] = 'admin/aadhaar/';
	$config['allowed_types'] = '*';
	$config['remove_spaces'] = TRUE;
	$config['encrypt_name'] = TRUE;
	return $config;
	
	}

	public function UploadFile(){


		if(isset($_REQUEST["file"])){
			// Get parameters
			$file = urldecode($_REQUEST["file"]); // Decode URL-encoded string
		
			/* Test whether the file name contains illegal characters
			such as "../" using the regular expression */
			if(preg_match('/^[^.][-a-z0-9_.]+[a-z]$/i', $file)){
				$filepath = "admin/uploads/" . $file;
		
				// Process download
				if(file_exists($filepath)) {
					header('Content-Description: File Transfer');
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
					header('Expires: 0');
					header('Cache-Control: must-revalidate');
					header('Pragma: public');
					header('Content-Length: ' . filesize($filepath));
					flush(); // Flush system output buffer
					readfile($filepath);
					die();
				} else {
					http_response_code(404);
					die();
				}
			} else {
				die("Invalid file name!");
			}

	}

}
public function updateCertificatesPg($id){
	$user_id = $this->uri->segment(3);
   
   $pr_user = $this->db->select('*')->from('new_preview_pg')->where('pr_user_id',$user_id)->get();
   
   $data['user'] = $pr_user->result();
   

/* echo"<pre>";

print_r( $data['user']);
 */

    $this->load->view('Home/template/head');
   $this->load->view('Home/site/uploads_pg',$data);
   $this->load->view('Home/template/footer'); 
   
   
   
   
   
   
   }

   public function updateCertificatesUg($id){
	$user_id = $this->uri->segment(3);
   
   $pr_user = $this->db->select('*')->from('new_preview')->where('pr_user_id',$user_id)->get();
   
   $data['user'] = $pr_user->result();
   

/* echo"<pre>";

print_r( $data['user']);
 */

    $this->load->view('Home/template/head');
   $this->load->view('Home/site/uploads_ug',$data);
   $this->load->view('Home/template/footer'); 
   
   
   
   
   
   
   }
   public function updateCertificatesDip($id){
	$user_id = $this->uri->segment(3);
   
   $pr_user = $this->db->select('*')->from('new_preview_dip')->where('pr_user_id',$user_id)->get();
   
   $data['user'] = $pr_user->result();
   
   $this->load->view('Home/template/head');
   $this->load->view('Home/site/uploads_pg',$data);
   $this->load->view('Home/template/footer'); 
   
   
   
   
   
   
   }





public function getcheck(){


	$email="be.yuvaraj@gmail.com";
	$subject="Test payment";
	$msg="tested";

	$config = array(
		'protocol' => 'smtp', 
		'smtp_host' => 'ssl://smtp.gmail.com', 
		'smtp_port' => 465, 
		'smtp_user' => 'admission.mssw@gmail.com', 
		'smtp_pass' => 'dqamafoawpedieqn',
		'mailtype' => 'html', 
		'charset' => 'iso-8859-1'
);
	$this->email->initialize($config);
	$this->email->set_mailtype("html");
	$this->email->set_newline("\r\n");

	$this->testEmail( $email,$subject,$msg);


	echo $this->email->print_debugger();


}


public function testFun(){









	$config = array(
		'protocol' => 'smtp', 
		'smtp_host' => 'ssl://smtp.gmail.com', 
		'smtp_port' => 465, 
		'smtp_user' => 'admission.mssw@gmail.com', 
		'smtp_pass' => 'dqamafoawpedieqn',
		'mailtype' => 'html', 
		'charset' => 'iso-8859-1'
);


 
	//SMTP & mail configuration

	$this->email->initialize($config);
	$this->email->set_mailtype("html");
	$this->email->set_newline("\r\n");
	 
	//Email content
	$htmlContent = '<h1>Dont waste your time Raja</h1>';
	$htmlContent .= '<p>Do your work properly.</p>';
	 
	$this->email->to('be.yuvaraj@gmail.com');
	$this->email->from('admission.mssw@gmail.com','MyWebsite');
	$this->email->subject('How to send email via Gmail SMTP server in CodeIgniter');
	$this->email->message($htmlContent);
	 
	//Send email
	$this->email->send();















}



public function reApplyCourse($id){


//redirect($this->uri->uri_string());


$id = $id;

$m = $this->db->select("pr_course_1,pr_course_2,pr_course_3")->from("new_preview_pg")->where("pr_user_id",$this->session->userdata('user')['user_id'])->get();

$data['user'] = $m->result();

$d = $this->db->select("*")->from("new_preview_pg")->where("pr_user_id",$this->session->userdata('user')['user_id'])->get();

$data['user_details'] = $d->result();
$q = $this->db->select('*')->from('college_course')->where('mc_id',2 )->get();
$data['cc'] = $q->result();
//print_r($result);

$pr_sfcourse = $this->db->select('cour_id,appliction_active')->from('department_details')->where('main_id',1)->get();
$pr_mswsfcourse = $this->db->select('cour_id,appliction_active')->from('department_details')->where('main_id',3)->get();
$pr_mswadcourse = $this->db->select('cour_id,appliction_active')->from('department_details')->where('main_id',2)->get();

$data['active_sf'] = $pr_sfcourse->result_array();
$data['active_mswsf'] = $pr_mswsfcourse->result_array();
$data['active_mswad'] = $pr_mswadcourse->result_array();



$this->load->view('Home/template/head');
$this->load->view('Home/site/re_apply_pg',$data);
$this->load->view('Home/template/footer'); 


}
public function updateApplication(){



	$user_id = $this->session->userdata('user')['user_id'];
	$m_course = $this->session->userdata('user')['user_m_course'];
 
 
 
 
 if($m_course == 1){
	 $in_pr = $this->db->select('*')->from('new_preview')->where('pr_user_id',$user_id)->get();
	 $r = $in_pr->num_rows();
 
 
 
 
	 if($r == 0){
		 $pre = array(
			 'pr_user_id'=>$user_id,
			 'pr_created'=>date("Y-m-d H:i:s"),
		 );
		 
		 $sub_pre = array(
			 'sb_u_id'=>$user_id,
		 );
		 
		 $this->db->insert('new_preview',$pre);
		 $this->db->insert('sub_preview',$sub_pre);
 
	 }
 
 
 
		 $q = $this->db->select('*')->from('college_course')->where('mc_id',$m_course )->get();
		 $pr_user = $this->db->select('*')->from('new_preview')->where('pr_user_id',$user_id)->get();
		 $pr_study = $this->db->select('*')->from('sub_preview')->where('sb_u_id',$user_id)->get();
	 
	 
	 
	 
		 $pr_study_app = $this->db->select('*')->from('stu_applied')->where('sa_st_id',$user_id)->get();
	 
		 $ren = $pr_study_app->num_rows();
		 $data['cc'] = $q->result();
		 $data['user'] = $pr_user->result();
		 $data['Study'] = $pr_study->result();
	 
	 
		 $number = rand(100,100000);
		 $t=time();
		 $random = $number.$t;
	 
 
		 $this->load->view('Home/template/head');
		 $this->load->view('Home/site/basicdetails_ug',$data);
		 $this->load->view('Home/template/footer_ug'); 
 
 
 
 } else if($m_course == 2){
 
	 $in_pr = $this->db->select('*')->from('new_preview_pg')->where('pr_user_id',$user_id)->get();
	 $r = $in_pr->num_rows();
 
 
 
	 if($r == 0){
		 $pre = array(
			 'pr_user_id'=>$user_id,
			 'pr_created'=>date("Y-m-d H:i:s"),
		 );
		 
		 $sub_pre = array(
			 'sb_u_id'=>$user_id,
		 );
		 
		 $this->db->insert('new_preview_pg',$pre);
		 $this->db->insert('sub_preview_pg',$sub_pre);
 
	 }
 
	 $q = $this->db->select('*')->from('college_course')->where('mc_id',$m_course )->get();
		 $pr_user = $this->db->select('*')->from('new_preview_pg')->where('pr_user_id',$user_id)->get();
		 $pr_study = $this->db->select('*')->from('sub_preview_pg')->where('sb_u_id',$user_id)->get();
	 
	 
	 
	 
		 $pr_study_app = $this->db->select('*')->from('stu_applied')->where('sa_st_id',$user_id)->get();
		 $pr_sfcourse = $this->db->select('cour_id,appliction_active')->from('department_details')->where('main_id',1)->get();
		 $pr_mswsfcourse = $this->db->select('cour_id,appliction_active')->from('department_details')->where('main_id',3)->get();
		 $pr_mswadcourse = $this->db->select('cour_id,appliction_active')->from('department_details')->where('main_id',2)->get();
		 
	 
		 $ren = $pr_study_app->num_rows();
		 $data['cc'] = $q->result();
		 $data['user'] = $pr_user->result();
		 $data['Study'] = $pr_study->result();
		 $data['active_sf'] = $pr_sfcourse->result_array();
		 $data['active_mswsf'] = $pr_mswsfcourse->result_array();
		 $data['active_mswad'] = $pr_mswadcourse->result_array();
 
 
	 $this->load->view('Home/template/head');
	 $this->load->view('Home/site/update_application_pg',$data);
	 $this->load->view('Home/template/footer'); 
 
 }else if($m_course == 3){
 
 
	 $in_pr = $this->db->select('*')->from('new_preview_dip')->where('pr_user_id',$user_id)->get();
	 $r = $in_pr->num_rows();
 
 
 
	 if($r == 0){
		 $pre = array(
			 'pr_user_id'=>$user_id,
			 'pr_created'=>date("Y-m-d H:i:s"),
		 );
		 
		 $sub_pre = array(
			 'sb_u_id'=>$user_id,
		 );
		 
		 $this->db->insert('new_preview_dip',$pre);
		 $this->db->insert('sub_preview_dip',$sub_pre);
 
	 }
 
 
 
	 $q = $this->db->select('*')->from('college_course')->where('mc_id',$m_course )->get();
		 $pr_user = $this->db->select('*')->from('new_preview_dip')->where('pr_user_id',$user_id)->get();
		 $pr_study = $this->db->select('*')->from('sub_preview_dip')->where('sb_u_id',$user_id)->get();
	 
	 
	 
	 
		 $pr_study_app = $this->db->select('*')->from('stu_applied')->where('sa_st_id',$user_id)->get();
	 
		 $ren = $pr_study_app->num_rows();
		 $data['cc'] = $q->result();
		 $data['user'] = $pr_user->result();
		 $data['Study'] = $pr_study->result();
 
 
 
	 $this->load->view('Home/template/head');
	 $this->load->view('Home/site/basicdetails_dip',$data);
	 $this->load->view('Home/template/footer_dip'); 
 
 
 
 }else{



	redirect('Home/logOut', 'refresh');
 }






	

}

public function reApplyCourseDip($id){


	//redirect($this->uri->uri_string());
	
	
	$id = $id;
	
	$m = $this->db->select("pr_course_1")->from("new_preview_pg")->where("pr_user_id",$this->session->userdata('user')['user_id'])->get();
	
	$data['user'] = $m->result();
	$q = $this->db->select('*')->from('college_course')->where('mc_id',3 )->get();
	$data['cc'] = $q->result();
	//print_r($result);
	
	$this->load->view('Home/template/head');
	$this->load->view('Home/site/re_apply_dip',$data);
	$this->load->view('Home/template/footer'); 
	
	
	}

	public function reApplyCourseUg($id){


		//redirect($this->uri->uri_string());
		
		
		$id = $id;
		
		$m = $this->db->select("pr_course_1")->from("new_preview")->where("pr_user_id",$this->session->userdata('user')['user_id'])->get();
		
		$data['user'] = $m->result();
		$q = $this->db->select('*')->from('college_course')->where('mc_id',1 )->get();
		$data['cc'] = $q->result();
		//print_r($result);
		
		$this->load->view('Home/template/head');
		$this->load->view('Home/site/re_apply_ug',$data);
		$this->load->view('Home/template/footer_ug'); 
		
		
		}



public function reapplYPayment(){

$user_id = $this->session->userdata('user')['user_id'];
$main = array();
$self = array();
$aided = array();
if($_POST){

if($_POST['msw_aided']){
	$aided = $_POST['msw_aided'];

	$aided_cr = implode(",",$aided);





}else{
	$aided = array();
	$aided_cr = NULL;
}

if($_POST['msw_self_finance']){
	$self = $_POST['msw_self_finance'];
	$self_cr = implode(",",$self);




}else{
	$self = array();
	$self_cr = NULL;
}

if($_POST['course_one']){
	$main = $_POST['course_one'];
	$main_cr = implode(",",$main);
}else{
	$main = array();
	$main_cr = NULL;
}



$m = $this->db->select("*")->from("pg_fees_temp")->where("pr_user_id",$this->session->userdata('user')['user_id'])->get();


$rest = $m->num_rows();

if($rest > 0){

	$data = array(
		'pr_user_id'=>$this->session->userdata('user')['user_id'],
		'pr_course_1'=>$main_cr,
		'pr_course_2'=>$aided_cr,
		'pr_course_3'=>$self_cr,
		'primary_all_fee'=>$_POST['total_fee'],
		'previous_fee'=>$_POST['prev_fee'],
		'balance_fees'=>$_POST['ball_fee'],
	);


$this->db->where("pr_user_id",$this->session->userdata('user')['user_id']);
$this->db->update("pg_fees_temp",$data);

}else{


	$data = array(
		'pr_user_id'=>$this->session->userdata('user')['user_id'],
		'pr_course_1'=>$main_cr,
		'pr_course_2'=>$aided_cr,
		'pr_course_3'=>$self_cr,
		'primary_all_fee'=>$_POST['total_fee'],
		'previous_fee'=>$_POST['prev_fee'],
		'balance_fees'=>$_POST['ball_fee'],
	);
	
$this->db->insert("pg_fees_temp",$data);

}


redirect('Home/reApplyFeesPg/', 'refresh');




}else{


	redirect('Home', 'refresh');


}

}


public function reapplYPaymentDip(){

	$user_id = $this->session->userdata('user')['user_id'];
	$main = array();
	$self = array();
	$aided = array();
	if($_POST){
	
	
	
	if($_POST['course_one']){
		$main = $_POST['course_one'];
		$main_cr = implode(",",$main);
	}else{
		$main = array();
		$main_cr = NULL;


		//redirect('Home/reApplyFeesDip/', 'refresh');
	} 
	
	
	
	$m = $this->db->select("*")->from("pg_fees_temp")->where("pr_user_id",$this->session->userdata('user')['user_id'])->get();
	
	
	$rest = $m->num_rows();
	
	if($rest > 0){
	
		$data = array(
			'pr_user_id'=>$this->session->userdata('user')['user_id'],
			'pr_course_1'=>$main_cr,
			
			'primary_all_fee'=>$_POST['total_fee'],
			'previous_fee'=>$_POST['prev_fee'],
			'balance_fees'=>$_POST['ball_fee'],
		);
	
	
	$this->db->where("pr_user_id",$this->session->userdata('user')['user_id']);
	$this->db->update("pg_fees_temp",$data);
	
	}else{
	
	
		$data = array(
			'pr_user_id'=>$this->session->userdata('user')['user_id'],
			'pr_course_1'=>$main_cr,
		
			'primary_all_fee'=>$_POST['total_fee'],
			'previous_fee'=>$_POST['prev_fee'],
			'balance_fees'=>$_POST['ball_fee'],
		);
		
	$this->db->insert("pg_fees_temp",$data);
	
	}
	
	
	redirect('Home/reApplyFeesDip/', 'refresh');
	
	
	
	
	}else{
	
	
		redirect('Home', 'refresh');
	
	
	}
	
	}




public function reApplyFeesPg(){




	$m = $this->db->select("*")->from("pg_fees_temp")->where("pr_user_id",$this->session->userdata('user')['user_id'])->get();
$data['user'] = $m->result();

	$this->load->view('Home/template/head');
	$this->load->view('Home/site/reapply_payment',$data);
	$this->load->view('Home/template/footer'); 

}




public function reApplyFeesDip(){




	$m = $this->db->select("*")->from("pg_fees_temp")->where("pr_user_id",$this->session->userdata('user')['user_id'])->get();
$data['user'] = $m->result();

	$this->load->view('Home/template/head');
	$this->load->view('Home/site/reapply_payment_dip',$data);
	$this->load->view('Home/template/footer'); 

}


public function sendMail(){





$m = $this->db->select("*")->from("stu_user")->where("u_date  < ","2021-04-16")->where("u_email_valid",0)->get();

$result = $m->result();






 print_r($result); 



foreach($result as $r){


echo $r->u_email_id;


$emailsignature = "<br><br><b class='signature'>Regards,<br>


The Principal,<br>
Madras School Of Social Work,<br>
32, Casa Major Road,<br>
Egmore,Chennai-600 008.<br>
Ph-044 28194566, 044 28195126</br>";


		$subject="Madras School Of Social Work ";
		$msg ="Dear ". $r->u_name.",<br><br>You have successfully registered with Madras School Of Social Work, you can now carry on with the application submission process .<br> If you applied already check your status in DashBoard - My Application  <br> 
		<br>Your User Id : " .$r->u_email_id ."<br> and with your Password 
		
		<br>". $emailsignature;


	


		$config = array(
			'protocol' => 'smtp', 
			'smtp_host' => 'ssl://smtp.gmail.com', 
			'smtp_port' => 465, 
			'smtp_user' => 'admission.mssw@gmail.com', 
			'smtp_pass' => 'dqamafoawpedieqn',
			'mailtype' => 'html', 
			'charset' => 'iso-8859-1'
	);


		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");
 		$this->testEmail($r->u_email_id,$subject,$msg); 


$data = array(
	'u_email_valid'=>1,
);
		 $this->db->where("u_id",$r->u_id);
		 $this->db->update("stu_user",$data);


}




}


public function reapplYPaymentUg(){

	$user_id = $this->session->userdata('user')['user_id'];
	$main = array();
	$self = array();
	$aided = array();
	if($_POST){
	
	
	
	if($_POST['course_one']){
		$main = $_POST['course_one'];
		$main_cr = implode(",",$main);
	}else{
		$main = array();
		$main_cr = NULL;


		//redirect('Home/reApplyFeesDip/', 'refresh');
	} 
	
	
	
	$m = $this->db->select("*")->from("pg_fees_temp")->where("pr_user_id",$this->session->userdata('user')['user_id'])->get();
	
	
	$rest = $m->num_rows();
	
	if($rest > 0){
	
		$data = array(
			'pr_user_id'=>$this->session->userdata('user')['user_id'],
			'pr_course_1'=>$main_cr,
			
			'primary_all_fee'=>$_POST['total_fee'],
			'previous_fee'=>$_POST['prev_fee'],
			'balance_fees'=>$_POST['ball_fee'],
		);
	
	
	$this->db->where("pr_user_id",$this->session->userdata('user')['user_id']);
	$this->db->update("pg_fees_temp",$data);
	
	}else{
	
	
		$data = array(
			'pr_user_id'=>$this->session->userdata('user')['user_id'],
			'pr_course_1'=>$main_cr,
		
			'primary_all_fee'=>$_POST['total_fee'],
			'previous_fee'=>$_POST['prev_fee'],
			'balance_fees'=>$_POST['ball_fee'],
		);
		
	$this->db->insert("pg_fees_temp",$data);
	
	}
	
	
	redirect('Home/reApplyFeesUg/', 'refresh');
	
	
	
	
	}else{
	
	
		redirect('Home', 'refresh');
	
	
	}
	
	}
	public function reApplyFeesUg(){




		$m = $this->db->select("*")->from("pg_fees_temp")->where("pr_user_id",$this->session->userdata('user')['user_id'])->get();
	$data['user'] = $m->result();
	

/* echo"<pre>";
print_r($data);
 */


	 	$this->load->view('Home/template/head');
		$this->load->view('Home/site/reapply_payment_ug',$data);
		$this->load->view('Home/template/footer'); 
	
	}


public function instructionMockUp(){



	$this->load->view('Home/template/head');
	$this->load->view('Home/site/instruction_mockup');
	$this->load->view('Home/template/footer'); 



}
public function instructionOnlineExam(){



	$this->load->view('Home/template/head');
	$this->load->view('Home/site/instruction_online_exam');
	$this->load->view('Home/template/footer'); 



}

public function generalInstruction(){



	$this->load->view('Home/template/head');
	$this->load->view('Home/site/instruction_general');
	$this->load->view('Home/template/footer'); 


}


public function deleteExperiance(){


$id = $_POST['id'];
if($id != "" || $id != null){
$this->db->where('id',$id);
$this->db->delete('experiance_pg_dip');


echo 1;




}else{

	echo 0;

}
}

public function prac(){


$a = 20;
/* $a++; */
echo $a++; // 1 + 20

 //echo $i;
/*
echo"<br>";

$j = $i++; // 21 + 1

echo $i;
echo"<br>";
echo $j;
 */
}

public function smsTesting(){


$str = "Dear Candidate, You have submitted your application successfully. Check your login & visit the website for more details. Regards, Principal, MSSW. www.mssw.in";


$msg = str_replace(" ","%20",$str);

$sms_mob =8608679300;

$smsmsg = "http://sms.dial4sms.com:6005/api/v2/SendSMS?SenderId=MSSWAO&Is_Unicode=false&Message=".$msg."&MobileNumbers=".$sms_mob."&PrincipleEntityId=1001042071762463166&TemplateId=1007777626198772886&ApiKey=w6cDSY8S%2FIvqr0STG4KJhQ7itInAWx2OfNpBR%2FuyV78%3D&ClientId=3cfc5042-9835-498c-b37f-0ee1a5a8393f";




$url = $smsmsg;

$ch = curl_init();                       // initialize CURL
curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
curl_close($ch);  



}
public function smsContent1($mobile){


	$name="Yuvan";
	$thank="Thank You";
	$msg=	"Dear Candidate, You have submitted your application successfully. Check your login %26 visit the website for more details. Regards, Principal, MSSW. www.mssw.in";
	
	$msg_1 = str_replace(" ","%20",$msg);
	
	//echo $msg_1;
	
	$mobile = $mobile;
	$sms_mob = substr($mobile,-10);
	
	$smsmsg = "http://sms.dial4sms.com:6005/api/v2/SendSMS?SenderId=MSSWAO&Is_Unicode=false&Message=".$msg_1."&MobileNumbers=".$sms_mob."&PrincipleEntityId=1001042071762463166&TemplateId=1007671066997413080&ApiKey=w6cDSY8S%2FIvqr0STG4KJhQ7itInAWx2OfNpBR%2FuyV78%3D&ClientId=3cfc5042-9835-498c-b37f-0ee1a5a8393f";
	
	
		$url = $smsmsg;
		
		$ch = curl_init();                       // initialize CURL
		curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		echo $output = curl_exec($ch);
		curl_close($ch);  
		
	
	
	
	}
	public function studentPdf()
    {
        $user_id = $this->uri->segment(3);

        $pr_user = $this->db
            ->select("*")
            ->from("new_preview_pg")
            ->where("pr_user_id", $user_id)
            ->get();

        $usd = $pr_user->result();
        $pr_study = $this->db
            ->select("*")
            ->from("sub_preview_pg")
            ->where("sb_u_id", $user_id)
            ->get();

        $uss = $pr_study->result();

        $q = $this->db
            ->select("*")
            ->from("Applyed_Cources")
            ->where("main_course_id", 1)
            ->where("user_id", $user_id)
            ->where(
                "applied_course_id",
                $this->session->userdata("user")["user_dep_status"]
            )
            ->get();

        $app_id = $q->result();

        if (
            $usd[0]->pr_differently_abled == "" ||
            $usd[0]->pr_differently_abled == null
        ) {
            $abled = "<tr>
	<th>No</th>
	<td>-</td>
	</tr>";
        } elseif ($usd[0]->pr_differently_abled == "NO") {
            $abled = "<tr>
<th>No</th>
<td>-</td>
</tr>";
        } elseif ($usd[0]->pr_differently_abled == "YES") {
            $abled =
                "<tr>
  <th>" .
                $usd[0]->pr_differently_abled .
                "</th>
  <td>" .
                $usd[0]->pr_differently_abled_reson .
                "</td>
  </tr>";
        } else {
            $abled = "<tr>
<th>No</th>
<td>-</td>
</tr>";
        }

        if ($usd[0]->pr_other_res == "" || $usd[0]->pr_other_res == null) {
            $reservation = "<tr>
	<th>No</th>
	<td>-</td>
	</tr>";
        } elseif ($usd[0]->pr_other_res == "NO") {
            $reservation = "<tr>
<th>No</th>
<td>-</td>
</tr>";
        } elseif ($usd[0]->pr_other_res == "YES") {
            $reservation =
                "<tr>
  <th>" .
                $usd[0]->pr_other_res .
                "</th>
  <td>" .
                $usd[0]->pr_other_special_reservation .
                "</td>
  </tr>";
        } else {
            $reservation = "<tr>
	<th>No</th>
	<td>-</td>
	</tr>";
        }

        $dompdf = new Dompdf();
        $html =
            '
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>MSSW</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: x-small;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }
    .gray {
        background-color: lightgray
    }
	.center {
		display: block;
		margin: 10px auto 20px;
		
	  }

	  #center {  
		text-align: center;  
		border: 2px solid blue;  
		}  
	    
</style>

</head>
<body>
<div id ="center">  
<img src="https://admission.mssw.in//landing/images/mssw_logo.jpg" width="60%" height="75px;" alt="image">
</div>

<h3 align="center">Application Form For The Academic Year 2023 - 2024</h3>

<table width="100%">
    <tr>
        <td valign="top"><img src="' .
            base_url() .
            "admin/uploads/" .
            $usd[0]->pr_photo .
            '" alt="" width="100"/></td>
        <td align="right">
            <h3>Name : ' .
            $usd[0]->pr_applicant_name .
            '</h3>
            <h3>Reference Number : 23' .
            sprintf("%'04d", $usd[0]->pr_user_id) .
            '</h3>
            <h3>Application Number : ' .
            $app_id[0]->application_number .
            '</h3>
         
        </td>
    </tr>

  </table>

   <table width="100%">
    <thead style="background-color: lightgray;">
      <tr>
     
        <th>Mother Tongue</th>
        <th>Place of Birth </th>
        <th>Date of Birth</th>
        <th>Age</th>
        <th>Gender</th>
      
      </tr>
    </thead>
    <tbody>
      <tr align="center">
	  <td>' .
            $usd[0]->pr_mother_toung .
            '</td>
	  <td>' .
            $usd[0]->pr_place_of_birth .
            '</td>
	  <td>' .
            date("d-M-Y", strtotime($usd[0]->pr_dob)) .
            '</td>
	  <td>' .
            $usd[0]->pr_age .
            '</td>
	  <td>' .
            $usd[0]->pr_gender .
            '</td>
</tr>
</tbody>

</table>

<table width="100%">
    <thead style="background-color: lightgray;">
      <tr >
     
        <th>Nationality</th>
        <th>Religion</th>
        <th>Caste</th>
        <th>Community</th>
     
      
      </tr>
    </thead>
    <tbody>
      <tr align="center">
	  <td>' .
            $usd[0]->pr_nationality .
            '</td>
	  <td>' .
            $usd[0]->pr_religion .
            '</td>
	  <td>' .
            $usd[0]->pr_caste .
            '</td>
	  <td>' .
            $usd[0]->pr_community .
            '</td>
	
</tr>
</tbody>
</table>

<table class="table" width="100%">
<tr>
<th style="background-color: lightgray;">#</th>
<th style="background-color: lightgray;">Local Address</th>
<th style="background-color: lightgray;">Permanant Address</th>
<tr>
<th align="left">Address</th>
<td>' .
            $usd[0]->pr_local_address .
            '</td>
<td>' .
            $usd[0]->pr_permanent_address .
            '</td>
</tr>

<tr>
<th align="left">City</th>
<td>' .
            $usd[0]->pr_local_city .
            '</td>
<td>' .
            $usd[0]->pr_permanent_city .
            '</td>
</tr>
<tr>
<th align="left">State</th>
<td>' .
            $usd[0]->pr_local_state .
            '</td>
<td>' .
            $usd[0]->pr_permanent_state .
            '</td>
</tr>    
<tr>
<th align="left">Country</th>
<td>' .
            $usd[0]->pr_local_country .
            '</td>
<td>' .
            $usd[0]->pr_permanent_country .
            '</td>
</tr>   
<tr>
<th align="left">Pincode</th>
<td>' .
            $usd[0]->pr_local_pincode .
            '</td>
<td>' .
            $usd[0]->pr_permanent_pincode .
            '</td>
</tr>   
</table>

  <table width="100%">
    <thead style="background-color: lightgray;">
      <tr>
        <th>#</th>
        <th>Educational Details</th>
        <th>Institution</th>
        <th>Max. Marks</th>
        <th>Marks Obtained</th>
        <th>Class / Grade</th>
        <th>Percentage</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">1</th>
     
        <td >' .
            $uss[0]->sslc_subject .
            '</td>
        <td >' .
            $uss[0]->sslc_institution .
            '</td>
        <td >' .
            $uss[0]->sslc_max_mark .
            '</td>
        <td >' .
            $uss[0]->sslc_mark_obtain .
            '</td>
        <td >' .
            $uss[0]->sslc_grade .
            '</td>
        <td >' .
            $uss[0]->sslc_percentage .
            '</td>
      </tr>
      <tr>
	  <th scope="row">2</th>
	
	  <td >' .
            $uss[0]->plus_one_subject .
            '</td>
	  <td >' .
            $uss[0]->plus_one_institution .
            '</td>
	  <td >' .
            $uss[0]->plus_one_max_mark .
            '</td>
	  <td >' .
            $uss[0]->plus_one_mark_obtain .
            '</td>
	  <td >' .
            $uss[0]->plus_one_grade .
            '</td>
	  <td >' .
            $uss[0]->plus_one_percentage .
            '</td>
      </tr>
	  <tr>
      <th scope="row">3</th>
	
	  <td >' .
            $uss[0]->plus_two_subjec .
            '</td>
	  <td >' .
            $uss[0]->plus_two_institution .
            '</td>
	  <td >' .
            $uss[0]->plus_two_max_mark .
            '</td>
	  <td >' .
            $uss[0]->plus_two_mark_obtain .
            '</td>
	  <td >' .
            $uss[0]->plus_two_grade .
            '</td>
	  <td >' .
            $uss[0]->plus_two_percentage .
            '</td>
      </tr>
	  <tr>
	  <th scope="row">4</th>
	
	  <td >' .
            $uss[0]->UG_subject .
            '</td>
	  <td >' .
            $uss[0]->ug_institution .
            '</td>
	  <td >' .
            $uss[0]->UG_max_mark .
            '</td>
	  <td >' .
            $uss[0]->UG_mark_obtain .
            '</td>
	  <td >' .
            $uss[0]->UG_grade .
            '</td>
	  <td >' .
            $uss[0]->UG_two_percentage .
            '</td>
      </tr>
    </tbody>


  </table>

  <table  width="100%">
   <thead style="background-color: lightgray;">
      <tr style="background-color: lightgray;">
     
        <th>Differently Abled Person</th>
        <th>Differently Abled Details</th>
            
      </tr>
    </thead>
    <tbody>
      <tr align="center">
	  <td>' .
            $usd[0]->pr_differently_abled .
            '</td>
	  <td>' .
            $usd[0]->pr_differently_abled_reson .
            '</td>
	 
	</tr>
	</tbody>
  </table>
   <table  width="100%">
  
  <thead style="background-color: lightgray;">
      <tr style="background-color: lightgray;">
     
        <th>Reservation Required</th>
        <th>Reservation Required Details</th>
            
      </tr>
    </thead>
    <tbody>
      <tr align="center">
	  <td>' .
            $usd[0]->pr_other_res .
            '</td>
	  <td>' .
            $usd[0]->pr_other_special_reservation .
            '</td>
	 
	</tr>
	</tbody>
  </table>
  <table  width="100%">
  
  <thead style="background-color: lightgray;">
      <tr style="background-color: lightgray;">
     
        <th>Hostel Required</th>
        <th>IDENTIFICATION 1</th>
        <th>IDENTIFICATION 2</th>
    
            
      </tr>
    </thead>
    <tbody>
      <tr align="center">
	  <td>' .
            $usd[0]->pr_hostel .
            '</td>
	  <td>' .
            $usd[0]->pr_identification_one .
            '</td>
	  <td>' .
            $usd[0]->pr_identification_two .
            '</td>

	
	 
	</tr>
	</tbody>
  </table>

    <table class="table"  width="100%">
						
  <tr  style="background-color: lightgray;">
	  <th>Sports Category : Name of the Game(s)</th>
	  <th>Position</th>
	  <th>Extra - Curricular Activities</th>
	  </tr>
	  
  <tr>
  <td align="center">' .
            $usd[0]->pr_name_of_game .
            '</td>
	  <td  align="center">' .
            $usd[0]->pr_game_position .
            '</td>
	  <td  align="center">' .
            $usd[0]->pr_extra_caricular_act .
            '</td>	
  
  </tr>
  
  </table>
    <table class="table"  width="100%">
  <tr style="background-color: lightgray;">
<th>#</th>
<th>Father</th>
<th>Mother</th>
<th>Guardian</th>
<tr>
<th align="left">Name</th>
<td>' .
            $usd[0]->pr_father_name .
            '</td>
<td>' .
            $usd[0]->pr_mother_name .
            '</td>
<td>' .
            $usd[0]->pr_gaurdion_name .
            '</td>
</tr>
<tr>
<th align="left">E-Mail Id</th>
<td>' .
            $usd[0]->pr_father_email .
            '</td>
<td>' .
            $usd[0]->pr_mother_email .
            '</td>
<td>' .
            $usd[0]->pr_gaurdion_email .
            '</td>
</tr>
<tr>
<th align="left">Mobile No.</th>
<td>' .
            $usd[0]->pr_father_mobnum .
            '</td>
<td>' .
            $usd[0]->pr_mother_mobnum .
            '</td>
<td>' .
            $usd[0]->pr_gaurdion_mobnum .
            '</td>
</tr>
<tr>
<th align="left">Occupation</th>
<td>' .
            $usd[0]->pr_father_accu .
            '</td>
<td>' .
            $usd[0]->pr_mother_accu .
            '</td>
<td>' .
            $usd[0]->pr_gaurdion_accu .
            '</td>
</tr>
<tr>
<th align="left">Annual
Income</th>
<td>' .
            $usd[0]->pr_father_anuval_income .
            '</td>
<td>' .
            $usd[0]->pr_mother_anuval_income .
            '</td>
<td>' .
            $usd[0]->pr_gaurdion_anuval_income .
            '</td>
</tr>   
  </table>
</body>
</html>';

        $dompdf->load_html($html);
        $dompdf->render();

        $dompdf->stream("23" . sprintf("%'04d", $usd[0]->pr_user_id) . "pdf");
    }
	public function myApplication(){



		$th = $this->db->select("*")->from("Applyed_Cources")->where("user_id",$this->session->userdata('user')['user_id'])->get();
		$data['result'] = $th->result();
			$this->load->view('Home/template/head');
			$this->load->view('Home/site/applied_download',$data);
			$this->load->view('Home/template/footer');  
		 
		
		
		
		
		
		
		
		
		}	public function myUgApplication(){



		$th = $this->db->select("*")->from("Applyed_Cources")->where("user_id",$this->session->userdata('user')['user_id'])->get();
		$data['result'] = $th->result();
			$this->load->view('Home/template/head');
			$this->load->view('Home/site/applied_ug_download',$data);
			$this->load->view('Home/template/footer');  
		 
		
		
		
		
		
		
		
		
		}
	
		public function studentUgPdf()
		{
	
	
	
			$user_id = $this->uri->segment(3);
			$app_id = $this->uri->segment(4);
	
	
	
			$Sub = $this->db->select("*")->from("sub_preview")->where("sb_u_id",$user_id)->get();
	
	
	$lang_mark = $Sub->result();
	
		$lang_table= '<table class="table" width="100%">
		<thead>
		  <tr style="background-color: lightgray;">
			<th>Part One & Two Name</th>
			
			<th>Max Mark</th>
			<th>Mark Obtained</th>
		
		  </tr>
		</thead>
		<tbody id="append">
		<tr align="center">
		<td>'.$lang_mark[0]->lang_1.'</td>
		<td>'.$lang_mark[0]->lang_1_max_mark.'</td>
		<td>'.$lang_mark[0]->lang_1_obt_mark.'</td>
		
		</tr><tr align="center">
		<td>'.$lang_mark[0]->lang_2.'</td>
		<td>'.$lang_mark[0]->lang_2_max_mark.'</td>
		<td>'.$lang_mark[0]->lang_2_obt_mark.'</td>
		
		</tr>
		
		</tbody>
		</table>';
	
	
	
			$ind = $this->db->select("*")->from("sub_preview_ug_main_sub")->where("student_id",$user_id)->get();
	
	$res_num = $ind->num_rows();
	
	
	if($res_num > 0){
	
	$mark = $ind->result();
	
	$mm='<table class="table" width="100%">
	<thead>
	  <tr style="background-color: lightgray;">
		<th>Subject</th>
		
		<th>Marks Obtained</th>
		<th>Percentage</th>
	
	  </tr>
	</thead>
	<tbody id="append">';
	
	foreach ($mark as $key => $value) {
		$mm.='<tr align="center">
		<td>'.$value->ug_subject_name.'</td>
	
		<td>'.$value->ug_mark_obtained.'</td>
		<td>'.$value->ud_percentage.'</td>
	
	  </tr>';
	}
	
	$mm .='  </tbody>
	</table>';
	
	
	}else{
	
		$mm="";
	
	
	
	}
	
	
	
	
	
	
	
	
	
			$pr_user = $this->db
				->select("*")
				->from("new_preview")
				->where("pr_user_id", $user_id)
				->get();
	
			$usd = $pr_user->result();
			$pr_study = $this->db
				->select("*")
				->from("sub_preview")
				->where("sb_u_id", $user_id)
				->get();
	
			$uss = $pr_study->result();
	
			$q = $this->db
				->select("*")
				->from("Applyed_Cources")
				->where("main_course_id", 5)
				->where("user_id", $user_id)
				->where(
					"id",
					$app_id
				)
				->get();
	
			$app_id = $q->result();
	
			if (
				$usd[0]->pr_differently_abled == "" ||
				$usd[0]->pr_differently_abled == null
			) {
				$abled = "<tr>
		<th>No</th>
		<td>-</td>
		</tr>";
			} elseif ($usd[0]->pr_differently_abled == "NO") {
				$abled = "<tr>
	<th>No</th>
	<td>-</td>
	</tr>";
			} elseif ($usd[0]->pr_differently_abled == "YES") {
				$abled =
					"<tr>
	  <th>" .
					$usd[0]->pr_differently_abled .
					"</th>
	  <td>" .
					$usd[0]->pr_differently_abled_reson .
					"</td>
	  </tr>";
			} else {
				$abled = "<tr>
	<th>No</th>
	<td>-</td>
	</tr>";
			}
	
			if ($usd[0]->pr_other_res == "" || $usd[0]->pr_other_res == null) {
				$reservation = "<tr>
		<th>No</th>
		<td>-</td>
		</tr>";
			} elseif ($usd[0]->pr_other_res == "NO") {
				$reservation = "<tr>
	<th>No</th>
	<td>-</td>
	</tr>";
			} elseif ($usd[0]->pr_other_res == "YES") {
				$reservation =
					"<tr>
	  <th>" .
					$usd[0]->pr_other_res .
					"</th>
	  <td>" .
					$usd[0]->pr_other_special_reservation .
					"</td>
	  </tr>";
			} else {
				$reservation = "<tr>
		<th>No</th>
		<td>-</td>
		</tr>";
			}
	
			$dompdf = new DOMPDF();
			$html =
				'
	<!doctype html>
	<html lang="en">
	<head>
	<meta charset="UTF-8">
	<title>MSSW</title>
	
	<style type="text/css">
		* {
			font-family: Verdana, Arial, sans-serif;
		}
		table{
			font-size: x-small;
		}
		tfoot tr td{
			font-weight: bold;
			font-size: x-small;
		}
		.gray {
			background-color: lightgray
		}
		.center {
			display: block;
			margin: 10px auto 20px;
			
		  }
	
		  #center {  
			text-align: center;  
			border: 2px solid blue;  
			}  
			
	</style>
	
	</head>
	<body>
	<div id ="center">  
	<img src="https://admission.mssw.in//landing/images/mssw_logo.jpg" width="60%" height="75px;" alt="image">
	</div>
	
	<h3 align="center">Application Form For The Academic Year 2023 - 2024 </h3>
	<h3 align="center">' .
	$app_id[0]->course_name .
	'</h3>
	
	
	<table width="100%">
		<tr>
			<td valign="top"><img src="' .
				base_url() .
				"admin/uploads/" .
				$usd[0]->pr_photo .
				'" alt="" width="100"/></td>
			<td align="right">
				<h3>Name : ' .
				$usd[0]->pr_applicant_name .
				'</h3>
				<h3>Reference Number : 23' .
				sprintf("%'04d", $usd[0]->pr_user_id) .
				'</h3>
				<h3>Application Number : ' .
				$app_id[0]->application_number .
				'</h3>
			 
			</td>
		</tr>
	
	  </table>
	
	   <table width="100%">
		<thead style="background-color: lightgray;">
		  <tr>
		 
			<th>Mother Tongue</th>
			<th>Place of Birth </th>
			<th>Date of Birth</th>
			<th>Age</th>
			<th>Gender</th>
		  
		  </tr>
		</thead>
		<tbody>
		  <tr align="center">
		  <td>' .
				$usd[0]->pr_mother_toung .
				'</td>
		  <td>' .
				$usd[0]->pr_place_of_birth .
				'</td>
		  <td>' .
				date("d-M-Y", strtotime($usd[0]->pr_dob)) .
				'</td>
		  <td>' .
				$usd[0]->pr_age .
				'</td>
		  <td>' .
				$usd[0]->pr_gender .
				'</td>
	</tr>
	</tbody>
	
	</table>
	
	<table width="100%">
		<thead style="background-color: lightgray;">
		  <tr >
		 
			<th>Nationality</th>
			<th>Religion</th>
			<th>Caste</th>
			<th>Community</th>
		 
		  
		  </tr>
		</thead>
		<tbody>
		  <tr align="center">
		  <td>' .
				$usd[0]->pr_nationality .
				'</td>
		  <td>' .
				$usd[0]->pr_religion .
				'</td>
		  <td>' .
				$usd[0]->pr_caste .
				'</td>
		  <td>' .
				$usd[0]->pr_community .
				'</td>
		
	</tr>
	</tbody>
	</table>
	
	<table width="100%">
		<thead style="background-color: lightgray;">
		  <tr>
		 
			<th>SSLC School Name</th>
			<th>SSLC Medium of Instruction </th>
			<th>SSLC Year of Passing</th>
	   
			<th>SSLC Language under Part II</th>
		   
		  
		  </tr>
		</thead>
		<tbody>
		  <tr align="center">
		  <td>' .
				$usd[0]->pr_sslc_school .
				'</td>
		  <td>' .
				$usd[0]->pr_sslc_medium_of_inst .
				'</td>
		  <td>' .
		  $usd[0]->pr_sslc_year_of_passing  .
		 
				'<td>' .
				$usd[0]->pr_sslc_lang_under_2 .
				'</td>
	</tr>
	</tbody>
	
	</table>
	
	<table width="100%">
		<thead style="background-color: lightgray;">
		  <tr>
		 
			<th>+2 School Name</th>
			<th>+2 Medium of Instruction </th>
			<th>+2 Year of Passing</th>
			<th>+2 BOARD</th>
			<th>+2 If Others Board </th>
			<th>+2 Language under Part II</th>
		   
		  
		  </tr>
		</thead>
		<tbody>
		  <tr align="center">
		  <td>' .
				$usd[0]->pr_plus2_school .
				'</td>
		  <td>' .
				$usd[0]->pr_plus2_medium_of_inst .
				'</td>
		  <td>' .
		  $usd[0]->pr_plus2_year_of_passing  .
				'</td>
		  <td>' .
				$usd[0]->pr_board_study .
				'</td>
		  <td>' .
				$usd[0]->pr_bord_other .
				'</td>  
				
				<td>' .
				$usd[0]->pr_plus2_lang_under_2 .
				'</td>
	</tr>
	</tbody>
	
	</table>'.$lang_table.''.$mm.'
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	<table class="table" width="100%">
	<tr>
	<th style="background-color: lightgray;">#</th>
	<th style="background-color: lightgray;">Local Address</th>
	<th style="background-color: lightgray;">Permanant Address</th>
	<tr>
	<th align="left">Address</th>
	<td>' .
				$usd[0]->pr_local_address .
				'</td>
	<td>' .
				$usd[0]->pr_permanent_address .
				'</td>
	</tr>
	
	<tr>
	<th align="left">City</th>
	<td>' .
				$usd[0]->pr_local_city .
				'</td>
	<td>' .
				$usd[0]->pr_permanent_city .
				'</td>
	</tr>
	<tr>
	<th align="left">State</th>
	<td>' .
				$usd[0]->pr_local_state .
				'</td>
	<td>' .
				$usd[0]->pr_permanent_state .
				'</td>
	</tr>    
	<tr>
	<th align="left">Country</th>
	<td>' .
				$usd[0]->pr_local_country .
				'</td>
	<td>' .
				$usd[0]->pr_permanent_country .
				'</td>
	</tr>   
	<tr>
	<th align="left">Pincode</th>
	<td>' .
				$usd[0]->pr_local_pincode .
				'</td>
	<td>' .
				$usd[0]->pr_permanent_pincode .
				'</td>
	</tr>   
	</table>
	
	  
	
	  <table  width="100%">
	   <thead style="background-color: lightgray;">
		  <tr style="background-color: lightgray;">
		 
			<th>Differently Abled Person</th>
			<th>Differently Abled Details</th>
				
		  </tr>
		</thead>
		<tbody>
		  <tr align="center">
		  <td>' .
				$usd[0]->pr_differently_abled .
				'</td>
		  <td>' .
				$usd[0]->pr_differently_abled_reson .
				'</td>
		 
		</tr>
		</tbody>
	  </table>
	   <table  width="100%">
	  
	  <thead style="background-color: lightgray;">
		  <tr style="background-color: lightgray;">
		 
			<th>Reservation Required</th>
			<th>Reservation Required Details</th>
				
		  </tr>
		</thead>
		<tbody>
		  <tr align="center">
		  <td>' .
				$usd[0]->pr_other_res .
				'</td>
		  <td>' .
				$usd[0]->pr_other_special_reservation .
				'</td>
		 
		</tr>
		</tbody>
	  </table>
	  <table  width="100%">
	  
	  <thead style="background-color: lightgray;">
		  <tr style="background-color: lightgray;">
		 
			<th>Hostel Required</th>
			<th>IDENTIFICATION 1</th>
			<th>IDENTIFICATION 2</th>
		
				
		  </tr>
		</thead>
		<tbody>
		  <tr align="center">
		  <td>' .
				$usd[0]->pr_hostel .
				'</td>
		  <td>' .
				$usd[0]->pr_identification_one .
				'</td>
		  <td>' .
				$usd[0]->pr_identification_two .
				'</td>
	
		
		 
		</tr>
		</tbody>
	  </table>
	
		<table class="table"  width="100%">
							
	  <tr  style="background-color: lightgray;">
		  <th>Sports Category : Name of the Game(s)</th>
		  <th>Position</th>
		  <th>Extra - Curricular Activities</th>
		  </tr>
		  
	  <tr>
	  <td align="center">' .
				$usd[0]->pr_name_of_game .
				'</td>
		  <td  align="center">' .
				$usd[0]->pr_game_position .
				'</td>
		  <td  align="center">' .
				$usd[0]->pr_extra_caricular_act .
				'</td>	
	  
	  </tr>
	  
	  </table>
		<table class="table"  width="100%">
	  <tr style="background-color: lightgray;">
	<th>#</th>
	<th>Father</th>
	<th>Mother</th>
	<th>Guardian</th>
	<tr>
	<th align="left">Name</th>
	<td>' .
				$usd[0]->pr_father_name .
				'</td>
	<td>' .
				$usd[0]->pr_mother_name .
				'</td>
	<td>' .
				$usd[0]->pr_gaurdion_name .
				'</td>
	</tr>
	<tr>
	<th align="left">E-Mail Id</th>
	<td>' .
				$usd[0]->pr_father_email .
				'</td>
	<td>' .
				$usd[0]->pr_mother_email .
				'</td>
	<td>' .
				$usd[0]->pr_gaurdion_email .
				'</td>
	</tr>
	<tr>
	<th align="left">Mobile No.</th>
	<td>' .
				$usd[0]->pr_father_mobnum .
				'</td>
	<td>' .
				$usd[0]->pr_mother_mobnum .
				'</td>
	<td>' .
				$usd[0]->pr_gaurdion_mobnum .
				'</td>
	</tr>
	<tr>
	<th align="left">Occupation</th>
	<td>' .
				$usd[0]->pr_father_accu .
				'</td>
	<td>' .
				$usd[0]->pr_mother_accu .
				'</td>
	<td>' .
				$usd[0]->pr_gaurdion_accu .
				'</td>
	</tr>
	<tr>
	<th align="left">Annual
	Income</th>
	<td>' .
				$usd[0]->pr_father_anuval_income .
				'</td>
	<td>' .
				$usd[0]->pr_mother_anuval_income .
				'</td>
	<td>' .
				$usd[0]->pr_gaurdion_anuval_income .
				'</td>
	</tr>   
	  </table>
	</body>
	</html>';
	
			$dompdf->load_html($html);
			$dompdf->render();
	
			$dompdf->stream($app_id[0]->course_name."-"."23" . sprintf("%'04d", $usd[0]->pr_user_id) . "pdf");
		}
	
	
	
	
	public function studentAppliedPdf()
    {
        $user_id = $this->uri->segment(3);
        $application_id = $this->uri->segment(4);

        $pr_user = $this->db
            ->select("*")
            ->from("new_preview_pg")
            ->where("pr_user_id", $user_id)
            ->get();

        $usd = $pr_user->result();
        $pr_study = $this->db
            ->select("*")
            ->from("sub_preview_pg")
            ->where("sb_u_id", $user_id)
            ->get();

        $uss = $pr_study->result();

        $q = $this->db
            ->select("*")
            ->from("Applyed_Cources")
           
            ->where("user_id", $user_id)
            ->where(
                "id",
                $application_id
            )
            ->get();

        $app_id = $q->result();

        if (
            $usd[0]->pr_differently_abled == "" ||
            $usd[0]->pr_differently_abled == null
        ) {
            $abled = "<tr>
	<th>No</th>
	<td>-</td>
	</tr>";
        } elseif ($usd[0]->pr_differently_abled == "NO") {
            $abled = "<tr>
<th>No</th>
<td>-</td>
</tr>";
        } elseif ($usd[0]->pr_differently_abled == "YES") {
            $abled =
                "<tr>
  <th>" .
                $usd[0]->pr_differently_abled .
                "</th>
  <td>" .
                $usd[0]->pr_differently_abled_reson .
                "</td>
  </tr>";
        } else {
            $abled = "<tr>
<th>No</th>
<td>-</td>
</tr>";
        }

        if ($usd[0]->pr_other_res == "" || $usd[0]->pr_other_res == null) {
            $reservation = "<tr>
	<th>No</th>
	<td>-</td>
	</tr>";
        } elseif ($usd[0]->pr_other_res == "NO") {
            $reservation = "<tr>
<th>No</th>
<td>-</td>
</tr>";
        } elseif ($usd[0]->pr_other_res == "YES") {
            $reservation =
                "<tr>
  <th>" .
                $usd[0]->pr_other_res .
                "</th>
  <td>" .
                $usd[0]->pr_other_special_reservation .
                "</td>
  </tr>";
        } else {
            $reservation = "<tr>
	<th>No</th>
	<td>-</td>
	</tr>";
        }

        $dompdf = new Dompdf();
        $html =
            '
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>MSSW</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: x-small;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }
    .gray {
        background-color: lightgray
    }
	.center {
		display: block;
		margin: 10px auto 20px;
		
	  }

	  #center {  
		text-align: center;  
		border: 2px solid blue;  
		}  
	    
</style>

</head>
<body>
<div id ="center">  
<img src="https://admission.mssw.in//landing/images/mssw_logo.jpg" width="60%" height="75px;" alt="image">
</div>

<h3 align="center">Application Form For The Academic Year 2023 - 2024 </h3>
<h3 align="center">' .
$app_id[0]->course_name .
'</h3>

<table width="100%">
    <tr>
        <td valign="top"><img src="' .
            base_url() .
            "admin/uploads/" .
            $usd[0]->pr_photo .
            '" alt="" width="100"/></td>
        <td align="right">
            <h3>Name : ' .
            $usd[0]->pr_applicant_name .
            '</h3>
            <h3>Reference Number : 23' .
            sprintf("%'04d", $usd[0]->pr_user_id) .
            '</h3>
            <h3>Application Number : ' .
            $app_id[0]->application_number .
            '</h3>
         
        </td>
    </tr>

  </table>

   <table width="100%">
    <thead style="background-color: lightgray;">
      <tr>
     
        <th>Mother Tongue</th>
        <th>Place of Birth </th>
        <th>Date of Birth</th>
        <th>Age</th>
        <th>Gender</th>
      
      </tr>
    </thead>
    <tbody>
      <tr align="center">
	  <td>' .
            $usd[0]->pr_mother_toung .
            '</td>
	  <td>' .
            $usd[0]->pr_place_of_birth .
            '</td>
	  <td>' .
            date("d-M-Y", strtotime($usd[0]->pr_dob)) .
            '</td>
	  <td>' .
            $usd[0]->pr_age .
            '</td>
	  <td>' .
            $usd[0]->pr_gender .
            '</td>
</tr>
</tbody>

</table>

<table width="100%">
    <thead style="background-color: lightgray;">
      <tr >
     
        <th>Nationality</th>
        <th>Religion</th>
        <th>Caste</th>
        <th>Community</th>
     
      
      </tr>
    </thead>
    <tbody>
      <tr align="center">
	  <td>' .
            $usd[0]->pr_nationality .
            '</td>
	  <td>' .
            $usd[0]->pr_religion .
            '</td>
	  <td>' .
            $usd[0]->pr_caste .
            '</td>
	  <td>' .
            $usd[0]->pr_community .
            '</td>
	
</tr>
</tbody>
</table>

<table class="table" width="100%">
<tr>
<th style="background-color: lightgray;">#</th>
<th style="background-color: lightgray;">Local Address</th>
<th style="background-color: lightgray;">Permanant Address</th>
<tr>
<th align="left">Address</th>
<td>' .
            $usd[0]->pr_local_address .
            '</td>
<td>' .
            $usd[0]->pr_permanent_address .
            '</td>
</tr>

<tr>
<th align="left">City</th>
<td>' .
            $usd[0]->pr_local_city .
            '</td>
<td>' .
            $usd[0]->pr_permanent_city .
            '</td>
</tr>
<tr>
<th align="left">State</th>
<td>' .
            $usd[0]->pr_local_state .
            '</td>
<td>' .
            $usd[0]->pr_permanent_state .
            '</td>
</tr>    
<tr>
<th align="left">Country</th>
<td>' .
            $usd[0]->pr_local_country .
            '</td>
<td>' .
            $usd[0]->pr_permanent_country .
            '</td>
</tr>   
<tr>
<th align="left">Pincode</th>
<td>' .
            $usd[0]->pr_local_pincode .
            '</td>
<td>' .
            $usd[0]->pr_permanent_pincode .
            '</td>
</tr>   
</table>

  <table width="100%">
    <thead style="background-color: lightgray;">
      <tr>
        <th>#</th>
        <th>Educational Details</th>
        <th>Institution</th>
        <th>Max. Marks</th>
        <th>Marks Obtained</th>
        <th>Class / Grade</th>
        <th>Percentage</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">1</th>
     
        <td >' .
            $uss[0]->sslc_subject .
            '</td>
        <td >' .
            $uss[0]->sslc_institution .
            '</td>
        <td >' .
            $uss[0]->sslc_max_mark .
            '</td>
        <td >' .
            $uss[0]->sslc_mark_obtain .
            '</td>
        <td >' .
            $uss[0]->sslc_grade .
            '</td>
        <td >' .
            $uss[0]->sslc_percentage .
            '</td>
      </tr>
      <tr>
	  <th scope="row">2</th>
	
	  <td >' .
            $uss[0]->plus_one_subject .
            '</td>
	  <td >' .
            $uss[0]->plus_one_institution .
            '</td>
	  <td >' .
            $uss[0]->plus_one_max_mark .
            '</td>
	  <td >' .
            $uss[0]->plus_one_mark_obtain .
            '</td>
	  <td >' .
            $uss[0]->plus_one_grade .
            '</td>
	  <td >' .
            $uss[0]->plus_one_percentage .
            '</td>
      </tr>
	  <tr>
      <th scope="row">3</th>
	
	  <td >' .
            $uss[0]->plus_two_subjec .
            '</td>
	  <td >' .
            $uss[0]->plus_two_institution .
            '</td>
	  <td >' .
            $uss[0]->plus_two_max_mark .
            '</td>
	  <td >' .
            $uss[0]->plus_two_mark_obtain .
            '</td>
	  <td >' .
            $uss[0]->plus_two_grade .
            '</td>
	  <td >' .
            $uss[0]->plus_two_percentage .
            '</td>
      </tr>
	  <tr>
	  <th scope="row">4</th>
	
	  <td >' .
            $uss[0]->UG_subject .
            '</td>
	  <td >' .
            $uss[0]->ug_institution .
            '</td>
	  <td >' .
            $uss[0]->UG_max_mark .
            '</td>
	  <td >' .
            $uss[0]->UG_mark_obtain .
            '</td>
	  <td >' .
            $uss[0]->UG_grade .
            '</td>
	  <td >' .
            $uss[0]->UG_two_percentage .
            '</td>
      </tr>
    </tbody>


  </table>

  <table  width="100%">
   <thead style="background-color: lightgray;">
      <tr style="background-color: lightgray;">
     
        <th>Differently Abled Person</th>
        <th>Differently Abled Details</th>
            
      </tr>
    </thead>
    <tbody>
      <tr align="center">
	  <td>' .
            $usd[0]->pr_differently_abled .
            '</td>
	  <td>' .
            $usd[0]->pr_differently_abled_reson .
            '</td>
	 
	</tr>
	</tbody>
  </table>
   <table  width="100%">
  
  <thead style="background-color: lightgray;">
      <tr style="background-color: lightgray;">
     
        <th>Reservation Required</th>
        <th>Reservation Required Details</th>
            
      </tr>
    </thead>
    <tbody>
      <tr align="center">
	  <td>' .
            $usd[0]->pr_other_res .
            '</td>
	  <td>' .
            $usd[0]->pr_other_special_reservation .
            '</td>
	 
	</tr>
	</tbody>
  </table>
  <table  width="100%">
  
  <thead style="background-color: lightgray;">
      <tr style="background-color: lightgray;">
     
        <th>Hostel Required</th>
        <th>IDENTIFICATION 1</th>
        <th>IDENTIFICATION 2</th>
    
            
      </tr>
    </thead>
    <tbody>
      <tr align="center">
	  <td>' .
            $usd[0]->pr_hostel .
            '</td>
	  <td>' .
            $usd[0]->pr_identification_one .
            '</td>
	  <td>' .
            $usd[0]->pr_identification_two .
            '</td>

	
	 
	</tr>
	</tbody>
  </table>

    <table class="table"  width="100%">
						
  <tr  style="background-color: lightgray;">
	  <th>Sports Category : Name of the Game(s)</th>
	  <th>Position</th>
	  <th>Extra - Curricular Activities</th>
	  </tr>
	  
  <tr>
  <td align="center">' .
            $usd[0]->pr_name_of_game .
            '</td>
	  <td  align="center">' .
            $usd[0]->pr_game_position .
            '</td>
	  <td  align="center">' .
            $usd[0]->pr_extra_caricular_act .
            '</td>	
  
  </tr>
  
  </table>
    <table class="table"  width="100%">
  <tr style="background-color: lightgray;">
<th>#</th>
<th>Father</th>
<th>Mother</th>
<th>Guardian</th>
<tr>
<th align="left">Name</th>
<td>' .
            $usd[0]->pr_father_name .
            '</td>
<td>' .
            $usd[0]->pr_mother_name .
            '</td>
<td>' .
            $usd[0]->pr_gaurdion_name .
            '</td>
</tr>
<tr>
<th align="left">E-Mail Id</th>
<td>' .
            $usd[0]->pr_father_email .
            '</td>
<td>' .
            $usd[0]->pr_mother_email .
            '</td>
<td>' .
            $usd[0]->pr_gaurdion_email .
            '</td>
</tr>
<tr>
<th align="left">Mobile No.</th>
<td>' .
            $usd[0]->pr_father_mobnum .
            '</td>
<td>' .
            $usd[0]->pr_mother_mobnum .
            '</td>
<td>' .
            $usd[0]->pr_gaurdion_mobnum .
            '</td>
</tr>
<tr>
<th align="left">Occupation</th>
<td>' .
            $usd[0]->pr_father_accu .
            '</td>
<td>' .
            $usd[0]->pr_mother_accu .
            '</td>
<td>' .
            $usd[0]->pr_gaurdion_accu .
            '</td>
</tr>
<tr>
<th align="left">Annual
Income</th>
<td>' .
            $usd[0]->pr_father_anuval_income .
            '</td>
<td>' .
            $usd[0]->pr_mother_anuval_income .
            '</td>
<td>' .
            $usd[0]->pr_gaurdion_anuval_income .
            '</td>
</tr>   
  </table>
</body>
</html>';

        $dompdf->load_html($html);
        $dompdf->render();

        $dompdf->stream($app_id[0]->course_name.'-'."23" . sprintf("%'04d", $usd[0]->pr_user_id) . "pdf");
    }
    public function bulkDownloadCertificate()
    {
        $user_id = $this->uri->segment(3);

        $pr_user = $this->db
            ->select("*")
            ->from("new_preview_pg")
            ->where("pr_user_id", $user_id)
            ->get();

        $cer = $pr_user->result();

        $certificates = [
            $cer[0]->pr_semester_1,
            $cer[0]->pr_semester_2,
            $cer[0]->pr_semester_3,
            $cer[0]->pr_semester_4,
            $cer[0]->pr_semester_5,
            $cer[0]->pr_semester_6,
            $cer[0]->pr_semester_7,
            $cer[0]->pr_semester_8,
            $cer[0]->pr_provisional_pg_cer,
            $cer[0]->pr_ug_cer,
            $cer[0]->pr_cummulative_cer,
            $cer[0]->pr_community_cer,
            $cer[0]->pr_conduct_cer,
            $cer[0]->pr_transfer_cer,
        ];

        print_r($certificates);
    }

    public function certificateComments()
    {
        //print_r($_POST);

        $user_id = $this->input->post("user_id");
        $pr_sslc = $this->input->post("pr_sslc");
        $pr_plus_one = $this->input->post("pr_plus_one");
        $pr_plus_two = $this->input->post("pr_plus_two");
        $pr_abled_certificate = $this->input->post("pr_abled_certificate");
        $pr_semester_1 = $this->input->post("pr_semester_1");
        $pr_semester_2 = $this->input->post("pr_semester_2");
        $pr_semester_3 = $this->input->post("pr_semester_3");
        $pr_semester_4 = $this->input->post("pr_semester_4");
        $pr_semester_5 = $this->input->post("pr_semester_5");
        $pr_semester_6 = $this->input->post("pr_semester_6");
        $pr_semester_7 = $this->input->post("pr_semester_7");
        $pr_semester_8 = $this->input->post("pr_semester_8");
        $pr_provisional_pg_cer = $this->input->post("pr_provisional_pg_cer");
        $pr_ug_cer = $this->input->post("pr_ug_cer");
        $pr_cummulative_cer = $this->input->post("pr_cummulative_cer");
        $pr_community_cer = $this->input->post("pr_community_cer");
        $pr_conduct_cer = $this->input->post("pr_conduct_cer");
        $pr_transfer_cer = $this->input->post("pr_transfer_cer");

        $data = [
            "sslc_certificate" => $pr_sslc,
            "plus_one_cer" => $pr_plus_one,
            "plus_two_cer" => $pr_plus_two,
            "abled_cert" => $pr_abled_certificate,
            "pr_semester_1" => $pr_semester_1,
            "pr_semester_2" => $pr_semester_2,
            "pr_semester_3" => $pr_semester_3,
            "pr_semester_4" => $pr_semester_4,
            "pr_semester_5" => $pr_semester_5,
            "pr_semester_6" => $pr_semester_6,
            "pr_semester_7" => $pr_semester_7,
            "pr_semester_8" => $pr_semester_8,
            "pr_provisional_pg_cer" => $pr_provisional_pg_cer,
            "pr_ug_cer" => $pr_ug_cer,
            "pr_cummulative_cer" => $pr_cummulative_cer,
            "pr_community_cer" => $pr_community_cer,
            "pr_conduct_cer" => $pr_conduct_cer,
            "pr_transfer_cer" => $pr_transfer_cer,
            "status" => 1,
        ];

        $this->db->where("student_id", $user_id);
        $this->db->update("Certificate_comments", $data);

        $this->session->set_flashdata(
            "message",
            ' <div class="alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong> Updated Comments Successfully .
</div>'
        );

        redirect("PgSelfFinance/studentCertificate/" . $user_id, "refresh");
    }

    public function studentCertificate()
    {
        $user_id = $this->uri->segment(3);

        $pr_user = $this->db
            ->select("*")
            ->from("new_preview_pg")
            ->where("pr_user_id", $user_id)
            ->get();

        $data["user"] = $pr_user->result();

        $cer_com = $this->db
            ->select("*")
            ->from("Certificate_comments")
            ->where("student_id", $user_id)
            ->get();
        $cer = $cer_com->num_rows();

        if ($cer == 0) {
            $insert = [
                "student_id" => $user_id,
                "date" => date("Y-m-d"),
                //'status'=>1,
            ];
            $this->db->insert("Certificate_comments", $insert);
        }
        $cer_comm = $this->db
            ->select("*")
            ->from("Certificate_comments")
            ->where("student_id", $user_id)
            ->get();
        $data["user_certificate"] = $cer_comm->result();

        //$data['certificate'] = array($cer[0]->pr_semester_1, $cer[0]->pr_semester_2, $cer[0]->pr_semester_3, $cer[0]->pr_semester_4, $cer[0]->pr_semester_5, $cer[0]->pr_semester_6, $cer[0]->pr_semester_7, $cer[0]->pr_semester_8, $cer[0]->pr_provisional_pg_cer, $cer[0]->pr_ug_cer, $cer[0]->pr_cummulative_cer, $cer[0]->pr_community_cer, $cer[0]->pr_conduct_cer, $cer[0]->pr_transfer_cer, $cer[0]->pr_abled_certificate);

        //print_r($certificates);

        $this->load->view("template/selffinance/header");
        $this->load->view("template/selffinance/menubar");
        $this->load->view("template/selffinance/headerbar");
        $this->load->view("selffinance/certificates", $data);
        $this->load->view("template/selffinance/footer");
    }
    public function panelPdf()
    {
        $pannel_id = $this->uri->segment(3);

        $pr_user = $this->db
            ->select("*")
            ->from("zoom")
            ->where("id", $pannel_id)
            ->get();

        $usd = $pr_user->result();

        $m = $this->db
            ->select("*")
            ->from("zoom_alloc")
            ->join(
                "Applyed_Cources",
                "zoom_alloc.student_id=Applyed_Cources.user_id"
            )
            ->join(
                "new_preview_pg",
                "zoom_alloc.student_id=new_preview_pg.pr_user_id"
            )
            ->join(
                "sub_preview_pg",
                "zoom_alloc.student_id=sub_preview_pg.sb_u_id",
                "left"
            )
            ->join(
                "online_exam_pannel",
                "zoom_alloc.student_id=online_exam_pannel.student_id",
                "left"
            )
            ->Where("online_exam_pannel.exam_category", $this->Subject)
            ->Where("Applyed_Cources.main_course_id", 1)
            ->Where(
                "Applyed_Cources.applied_course_id",
                $this->session->userdata("user")["user_dep_status"]
            )
            ->where("zoom_alloc.link_id", $pannel_id)
            ->get();

        $nm = $m->result();

        $depname = $this->db
            ->select("*")
            ->from("college_course")
            ->Where("mc_id", 2)
            ->Where(
                "cs_id",
                $this->session->userdata("user")["user_dep_status"]
            )
            ->get();

        $dept_name = $depname->result();

        /* echo"<pre>";
         print_r($nm); */
        $temp = "";

        foreach ($nm as $key => $tnde) {
            $ug = number_format((float) $tnde->UG_two_percentage, 2, ".", "");

            $ent = number_format((float) $tnde->total_mark, 2, ".", "");

            $total = $ug + $ent;
            $totn = number_format((float) $total, 2, ".", "");

            $data = [
                "app_no" => $tnde->application_number,
                "app_name" => strtoupper($tnde->pr_applicant_name),
                "ref_id" => $tnde->pr_user_id,
                "date" => date("d-m-Y", strtotime($tnde->pr_dob)),
                "ug_mark" => $ug,
                "pg_mark" => $ent,
                "totak_mark" => $totn,
                "community" => $tnde->pr_community,
            ];

            $newArray[$key] = $data;
        }
        //$data = array_column($data, 'totak_mark');

        usort($newArray, function ($a, $b) {
            return $b["totak_mark"] > $a["totak_mark"] ? 1 : -1;
        });

        $i = 1;
        foreach ($newArray as $tnt) {
            $temp .=
                '   <tr align="center">
	<td>' .
                $i .
                '</td>
	<td>' .
                $tnt["app_no"] .
                '</td>
	<td>' .
                strtoupper($tnt["app_name"]) .
                '</td>
	<td>' .
                "23" .
                sprintf("%'04d", $tnt["ref_id"]) .
                '</td>
	<td>' .
                date("d-m-Y", strtotime($tnt["date"])) .
                '</td>
	<td>' .
                $tnt["ug_mark"] .
                '</td>
	<td>' .
                $tnt["pg_mark"] .
                '</td>
	<td>' .
                $tnt["totak_mark"] .
                '</td>
	<td>' .
                $tnt["community"] .
                '</td>
	
	</tr>';

            $i++;
        }

        $dompdf = new Dompdf();
	
        $html =
            '
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>MSSW</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: x-small;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }
    .gray {
        background-color: lightgray
    }
	.center {
		display: block;
		margin: 10px auto 20px;
		
	  }
	  #center {  
		text-align: center;  
		border: 2px solid blue;  
		}  


	 tr:nth-child(even){background-color: #f2f2f2;}

 tr:hover {background-color: #ddd;}
	  
</style>

</head>
<body>
<div id ="center">  
<img src="https://admission.mssw.in//landing/images/mssw_logo.jpg" width="60%" height="75px;" alt="image">
</div>  

<br>
<h3 align="center"> Interview Schedule For ' .
            $dept_name[0]->cs_name .
            '</h3>
<h5>  Interview Name :' .
            $usd[0]->title .
            '</h5>
<h5> Interview Date & Time : ' .
            date("d-m-Y", strtotime($usd[0]->start_date)) .
            " & " .
            date("H:i ", strtotime($usd[0]->start_time)) .
            " (24-hour), Duration : " .
            $usd[0]->duration .
            ' Mins</h5>
<h5>  Zoom Link :' .
            $usd[0]->link .
            '</h5>
  <table width="100%">
  <thead style="background-color: lightgray;">
	<tr>
	  <th  width="5%">Sno.</th>
	  <th width="15%">Application Number</th>
	  <th width="26%">Student Name</th>
	  <th width="9%">Reference Id</th>
	  <th width="15%">Date of Birth</th>
	  <th width="7%">UG Mark</th>
	  <th width="7%">Entrance Mark</th>
	  <th width="7%">Total</th>
	  <th width="9%">Community</th>
		 
	</tr>
  </thead>
  <tbody>
' .
            $temp .
            '
  </tbody>
  </table>
  
  <br>
  <br>
  <br>
  <br>
  <h5 align="right"> Sd/-</h5>
  
  <h5 align="right"> HoD/Program Head</h5>
  <br>
  <br>
  <br>
  <h6 align="center">Generated by MSSW Campus Management System.</h6>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
  $( document ).ready(function() {
  var $tbody = $("table tbody");
  $tbody.find("tr").sort(function(a,b){ 
	  var tda = $(a).find("td:eq(7)").text(); // can replace 1 with the column you want to sort on
	  var tdb = $(b).find("td:eq(7)").text(); // this will sort on the second column
			  
	  return tda > tdb ? 1 
			
			 : tda < tdb ? -1 
			
			 : 0;           
  }).appendTo($tbody);
});
  </script>
';

        $dompdf->load_html($html);
        $dompdf->render();
		//$dompdf->set('isRemoteEnabled', true);
        $dompdf->stream($usd[0]->title . "pdf");
    }

}	
