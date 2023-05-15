<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
	parent::__construct();
 //error_reporting(0);
//ini_set('display_errors', 0);  
$this->load->library('upload');
$this->load->library('pdf');
$this->load->helper('download');
$this->load->library('email');
$this->load->config('email');


	date_default_timezone_set('Asia/Calcutta');



}
	public function index()
	{
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Congratulation ! '.$this->session->userdata('user')['user_name'].'</strong> You successfully  wrote the exam .
  </div>');
    $this->session->unset_userdata('user_exam');
    redirect('Home/dashBoard', 'refresh');
	}


  public function markUpdate(){




$m = $this->db->select("*")->from("online_exam_pannel")->where("year","2022")->where('e_id >','2700')->get();

$res = $m->result();


$i = 1 ;

 foreach($res as $rn){

  $n = $this->db->select('*')->from("new_online_exam_answer")->where("user_id",$rn->student_id)->where("exam_",$rn->exam_category)->get();
    
 // echo $i ." ) ".$rn->exam_category . " : ".$m = $n->num_rows() ."<br>";
$mn = $this->db->select('*')->from("new_online_exam_answer")->where("user_id",$rn->student_id)->where("exam_",$rn->exam_category)->where('score',1)->get();
   
//echo $i .") - (".$rn->student_id.") ".$rn->exam_category . " : ".$tot = $mn->num_rows() ."<br>";
  $i++;






  $data=array(
    'question_attended'=>(int) $n->num_rows(),
    'total_mark'=>(int) $mn->num_rows(),
    'completed_status'=>1,
  );

  

/* if($n->num_rows() >50){
    echo"<pre>";
    echo $rn->e_id;
    print_r($data); 
}  */
  
 

 $this->db->where('e_id', $rn->e_id);
$this->db->update('online_exam_pannel', $data);  
  


} 






/* foreach($res as $rn){
$n = $this->db->select('*')->from("new_online_exam_answer")->where("user_id",$rn->student_id)->where("exam_",$rn->exam_category)->where('score',1)->get();
    
echo $i .") - (".$rn->student_id.") ".$rn->exam_category . " : ".$tot = $n->num_rows() ."<br>";


$i++;

}
 */









}

public function AnswerOnlineExam($userid){


    $n = $this->db->select('*')->from("new_online_exam_answer")->where("score",NULL)->where("user_id",$userid)->get();
    
    $m = $n->result();
    
    
    foreach($m as $d){
    
    $qan = $this->db->select('*')->from('online_exam_question_bank_answe')->where('q_id',$d->q_id)->get();
    $dres = $qan->result();
    
    if($d->answer_id ==  $dres[0]->option_ans ){
    
    $mar = 1;
    
    }else{
    
    $mar = 0;
    
    }
    $data = array(
        'score'=>$mar
    );
    
    $this->db->where('id_',$d->id_)->update('new_online_exam_answer',$data);
    
    
    
    
    
    }

    






    
    }

    public function checkAnswer(){




      $n = $this->db->select('*')->from("new_online_exam_answer")->where("checked",0)->get();



      $m = $n->result();
    
    $i=1;
      foreach($m as $d){
      
      $qan = $this->db->select('*')->from('online_exam_question_bank_answe')->where('q_id',$d->q_id)->get();
      $dres = $qan->result();
      $int_answer = (int)$d->answer_id ;
      $int_answer_def = (int)$dres[0]->option_ans ;
      if($int_answer ==   $int_answer_def ){
      
      $mar = 1;
      
      }else{
      
      $mar = 0;
      
      }
      $data = array(
          'score'=>$mar,
          'checked'=>1
      );
      
      $this->db->where('id_',$d->id_)->update('new_online_exam_answer',$data);
      
      
      echo $i."<br>";
      $i++;
      
      }








    }




public function studentMarkList(){

      $n = $this->db->select('*')->from("online_exam_pannel")
      ->join('new_preview_pg', 'new_preview_pg.pr_user_id = online_exam_pannel.student_id')->where("status",1)->where('question_attended !=',0)->get();


    $data['student'] = $n->result();

$this->load->view('Home/site/student_mark_list',$data);

    }

public function erpstudentMerge(){



$resu = $this->db->select("*")->from("erp_existing_students")->where('id >=',1462)->get()->result();


echo"<pre>";
print_r($resu);



$ug = 1;
$pg =1;
$pgd =1;
$other =1;
foreach($resu as $res){

if($res->main_id == 1 ||$res->main_id == 2 || $res->main_id == 3 ){

$pg++;

if($res->mobile_number_ != ""){

  $mobile= $res->mobile_number_;

}else{

  $mobile= rand(0,9999999999);

}

$array =array(
"u_course"=>2,
"u_name"=>$res->student_name_,
"u_pass"=>md5("123456"),
"u_email_id"=>$res->email_,
"u_mobile"=>$mobile,
"u_year"=>substr($res->batch_,0,4),

);

print_r($array);



}else if( $res->main_id == 4){
  if($res->mobile_number_ != ""){

    $mobile= $res->mobile_number_;
  
  }else{
  
    $mobile= rand(0,9999999999);
  
  }
  $array =array(
    "u_course"=>3,
    "u_name"=>$res->student_name_,
    "u_pass"=>md5("123456"),
    "u_email_id"=>$res->email_,
    "u_mobile"=>$mobile,
    "u_year"=>substr($res->batch_,0,4),
    
    );
 
 
    print_r($array);
 
 
 
  $pgd++;


}else if( $res->main_id == 5){

  if($res->mobile_number_ != ""){

    $mobile= $res->mobile_number_;
  
  }else{
  
    $mobile= rand(0,9999999999);
  
  }
  $array =array(
    "u_course"=>1,
    "u_name"=>$res->student_name_,
    "u_pass"=>md5("123456"),
    "u_email_id"=>$res->email_,
    "u_mobile"=>$mobile,
    "u_year"=>substr($res->batch_,0,4),
    
    );


    $this->db->insert('stu_user', $array); 








    print_r($array);
  $ug++;

}else{


$other++;


}






}
echo$ug."<br>";
echo$pg ."<br>";
echo$pgd ."<br>";
echo$other."<br>";

}public function admitStudentErp(){




  $resu = $this->db->select("*")->from("admitted_student")
  ->join("shotlisted_candidate","admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id")
  ->join("stu_user","admitted_student.as_student_id=stu_user.u_id")
  ->join("department_details","shotlisted_candidate.sl_main_id=department_details.main_id AND shotlisted_candidate.sl_course_id=department_details.cour_id")
    ->order_by('admitted_student.as_reg_num', 'asc')
  ->get()->result();


  //echo"2014 Batch/BSW-14-01";
 
  echo"<pre>";


  //print_r($resu);





  $sli=1;
  $slj=1;
  $slk=1;
  $sll=1;
  $slm=1;
  $sln=1;
  $mswai=1;
  $mswaj=1;
  $mswak=1;
  $mswsi=1;
  $mswsj=1;
  $mswsk=1;
  $pgdi=1;
  $pgdk=1;
 
  $m=1;
  $n=1;








  foreach ($resu as $key => $value) {


if($value->sl_main_id == 1 ){


  if($value->sl_course_id ==5 ){
  $stud = $this->db->select("*")->from("new_preview_pg")->where('pr_user_id',$value->u_id)->get()->result();
  $batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-".$sli;
  $sli++;
  } else if($value->sl_course_id == 6 ){

    $stud = $this->db->select("*")->from("new_preview_pg")->where('pr_user_id',$value->u_id)->get()->result();
    $batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-".$slj;
    $slj++;

  }else if($value->sl_course_id == 7 ){

    $stud = $this->db->select("*")->from("new_preview_pg")->where('pr_user_id',$value->u_id)->get()->result();
    $batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-".$slk;
    $slk++;
    
  }else if($value->sl_course_id == 8 ){
    $stud = $this->db->select("*")->from("new_preview_pg")->where('pr_user_id',$value->u_id)->get()->result();
    $batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-".$sll;
    $sll++;

    
  }else if($value->sl_course_id == 9 ){

    $stud = $this->db->select("*")->from("new_preview_pg")->where('pr_user_id',$value->u_id)->get()->result();
    $batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-".$slm;
    $slm++;
    
  }else if($value->sl_course_id == 15 ){

    $stud = $this->db->select("*")->from("new_preview_pg")->where('pr_user_id',$value->u_id)->get()->result();
    $batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-".$sln;
    $sln++;
    
  }


}else if( $value->sl_main_id == 2 ){

  if($value->sl_course_id ==1 ){
  $stud = $this->db->select("*")->from("new_preview_pg")->where('pr_user_id',$value->u_id)->get()->result();
  $batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-".$mswai;
  $mswai++;
  } else if($value->sl_course_id ==2 ){
  $stud = $this->db->select("*")->from("new_preview_pg")->where('pr_user_id',$value->u_id)->get()->result();
  $batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-".$mswaj;
  $mswaj++;
  }else if($value->sl_course_id ==3 ){
  $stud = $this->db->select("*")->from("new_preview_pg")->where('pr_user_id',$value->u_id)->get()->result();
  $batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-".$mswak;
  $mswak++;
  }

}else if( $value->sl_main_id == 3 ){


  if($value->sl_course_id ==1 ){
    $stud = $this->db->select("*")->from("new_preview_pg")->where('pr_user_id',$value->u_id)->get()->result();
    $batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-".$mswsi;
    $mswsi++;
    } else if($value->sl_course_id ==2 ){
    $stud = $this->db->select("*")->from("new_preview_pg")->where('pr_user_id',$value->u_id)->get()->result();
    $batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-".$mswsj;
    $mswsj++;
    }else if($value->sl_course_id ==3 ){
    $stud = $this->db->select("*")->from("new_preview_pg")->where('pr_user_id',$value->u_id)->get()->result();
    $batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-".$mswsk;
    $mswsk++;
    }


}else if($value->sl_main_id == 4){

  if($value->sl_course_id == 10){

    $stud = $this->db->select("*")->from("new_preview")->where('pr_user_id',$value->u_id)->get()->result();
    $batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-".$pgdi;
    $pgdi++;
  }else{
  
    $stud = $this->db->select("*")->from("new_preview")->where('pr_user_id',$value->u_id)->get()->result();
    $batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-".$pgdk;
    $pgdk++;
  
  
  
  }

}else if($value->sl_main_id == 5){

if($value->sl_course_id == 1){

  $stud = $this->db->select("*")->from("new_preview")->where('pr_user_id',$value->u_id)->get()->result();
  $batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-".$m;
  $m++;
}else{

  $stud = $this->db->select("*")->from("new_preview")->where('pr_user_id',$value->u_id)->get()->result();
  $batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-".$n;
  $n++;



}
 

}


//print_r($stud)."<br>";

echo  $batch;

echo"<br>";

   $data=array(
     "batch_"=>$batch,
     "dp_id"=>$value->dp_id,
     "main_id"=>$value->main_id,
     "cour_id"=>$value->cour_id,
     "short_name"=>$value->short_name,
     "comp_name"=>$value->comp_name,
     "reg_no_"=>$value->as_reg_num,
     "temp_reg"=>$value->as_shotlist_ref_number,
     //"shift_"=>$value,
     //"dept_"=>$value,
     "student_name_"=>$value->as_name,
     "father_name_"=>$stud[0]->pr_father_name,
     "dob_"=>$stud[0]->pr_dob,
     "gender_"=>$stud[0]->pr_gender,
     "caste_"=>$stud[0]->pr_caste,
     "community_"=>$stud[0]->pr_community,
     "religion_"=>$stud[0]->pr_religion,
     "address_"=>$stud[0]->pr_permanent_address,
     "pincode_"=>$stud[0]->pr_permanent_pincode,
     "mobile_number_"=>$value->u_mobile,
     "email_"=>$value->u_email_id,
     //"doj_"=>$value,
     "father_guardian_contactno_"=>$value->u_email_id,
     //"medium_"=>$value,
     "student_image"=>$value->as_profile,
     "student_id"=>$value->as_student_id,
     "admitted_by"=>1,
     
   );

//$this->db->insert("erp_existing_students",$data);

print_r($data);



  }



}
public function StudentErp(){




  $resu = $this->db->select("batch_")->from("erp_existing_students")
  ->get()->result();


  echo"<pre>";

  print_r($resu);




}


public function smsTesting(){


  $str = "Dear Candidate, You have submitted your application successfully. Check your login visit the website for more details. Regards, Principal, MSSW. www.mssw.in";
  
  
  $msg = str_replace(" ","%20",$str);
  
  $sms_mob ="9578884885";
  
  $smsmsg = "http://sms.dial4sms.com:6005/api/v2/SendSMS?SenderId=MSSWAO&Is_Unicode=false&Message=".$msg."&MobileNumbers=".$sms_mob."&PrincipleEntityId=1001042071762463166&TemplateId=1007671066997413080&ApiKey=w6cDSY8S%2FIvqr0STG4KJhQ7itInAWx2OfNpBR%2FuyV78%3D&ClientId=3cfc5042-9835-498c-b37f-0ee1a5a8393f";
  
  
  
  
echo $url = $smsmsg;
  
  $ch = curl_init();                       // initialize CURL
  curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $output = curl_exec($ch);
  curl_close($ch);  
  echo $output;
  
  
  }
public function addpliedDate(){

  $resu = $this->db->select("batch_")->from("erp_existing_students")
  ->get()->result();


  echo"<pre>";

  print_r($resu);


}


public function nonAttendExm(){


//print_r($this->studentNotAttendExam());

foreach ($this->studentNotAttendExam() as $key => $value) {
  $q = $this->db->select("*")->from('stu_user')->where('u_id',$value)->get();
  $m = $q->result();
	
	//$this->notattendExamemail($m[0]->u_name,$m[0]->u_email_id);
	//$this->notattendExam($m[0]->u_name,$m[0]->u_mobile);

/* echo"<pre>";
 print_r($m[0]->u_email_id); */
}

//$this->notattendExamemail("yuvaraj","yuvaraj@istudiotech.com");
}



public function studentNotAttendExam(){


$applied =[];
$exam_attended =[];
	
  $result =array();
	$this->db->distinct();
	$this->db->select('user_id');
	$this->db->from('Applyed_Cources');
	$this->db->where('applied_date >' ,'2022/04/01'); 
	$this->db->where('user_id !=' ,0); 
	$this->db->where_in('main_course_id',array(1,2,3)); 
	$query = $this->db->get()->result_array();
//	$ques = call_user_func_array('array_merge', $query);

	//print_r($ques);
	/*  echo"<pre>";
	print_r($ques);  */


foreach ($query as $key => $value) {
  array_push($applied,$value['user_id']);
}

/* echo"<pre>";
print_r($applied); 
 */


	$this->db->distinct();
	$this->db->select('student_id');
	$this->db->from('online_exam_pannel');
	$this->db->where('created_date >' ,'2022/04/01'); 
	$this->db->where_in('year','2022'); 
	$this->db->where_in('exam_mode','0'); 
	$queryy_exam = $this->db->get()->result_array();



  foreach ($queryy_exam as $key => $value) {
    array_push($exam_attended,$value['student_id']);
  }

  //echo"<br><br><pre>";
  //print_r($exam_attended); 

	$result=array_diff($applied,$exam_attended);
  $result=array_values($result);
  //print_r($result); 





//	$queryy_e = array_values($queryy_exam);

//	$result=array_diff($query,$queryy_exam);
/* 	echo"<pre>";
	print_r($queryy_e); */

return $result;



}



public function notattendExam($uname,$mobnum){




	$name=$uname;
	$thank="Entrance Test 2nd and 3rd July 2022";
	$msg=	"Dear ".$name.", Entrance exam is scheduled. Check your login %26 visit the website for more details. Regards, Principal, MSSW. ".$thank;
	
	$msg_1 = str_replace(" ","%20",$msg);
	
	//echo $msg_1;
	
	$mobile = $mobnum;
	$sms_mob = substr($mobile,-10);
	
	$smsmsg = "http://sms.dial4sms.com:6005/api/v2/SendSMS?SenderId=MSSWAO&Is_Unicode=false&Message=".$msg_1."&MobileNumbers=".$sms_mob."&PrincipleEntityId=1001042071762463166&TemplateId=1007538260357459577&ApiKey=w6cDSY8S%2FIvqr0STG4KJhQ7itInAWx2OfNpBR%2FuyV78%3D&ClientId=3cfc5042-9835-498c-b37f-0ee1a5a8393f";
	
	
		$url = $smsmsg;
		
		$ch = curl_init();                       // initialize CURL
		curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		echo $output = curl_exec($ch);
		curl_close($ch);  
		






}

public function notattendExamemail($name,$email){


	$emailsignature = "<br><br><b class='signature'>Regards,<br>


The Principal,<br>
Madras School Of Social Work,<br>
32, Casa Major Road,<br>
Egmore,Chennai-600 008.<br>
Ph - 044 28194566, 044 28195126</br>";

$smssignature="Madras School Of Social Work";
		$subject="Madras School Of Social Work ";
		$msg ="Dear ".strtoupper($name).",<br><br> Entrance Test is scheduled on 2nd and 3rd July 2022.  For More Details Check your login & visit the website (www.mssw.in) <br>
		<br><br> 
		<br> 
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
	<img class="em_img" alt="Welcome to Email" src="https://admission.mssw.in//landing/images/logo.png" width="700" border="0" height="110px">
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
		//		$this->email->attach($email_attachment);
				$this->email->send();
	
	}
public function enquiry(){


	$this->load->view('Home/template/head');
		$this->load->view('Home/site/enquiry');
		$this->load->view('Home/template/footer');


}
public function saveEnquirey(){



	$image_P = $this->input->post('ppimage');
	//$stu_certificate = $this->input->post('stu_certificate');
	$this->upload->initialize($this->do_upload($image_P));
	$hh =$this->upload->do_upload('profile-img');
	$dataInfo = $this->upload->data();
	

		if($hh){

		

			$filename =$dataInfo['file_name'];
		}else{
			if($image_P == null){
						$filename = "";
			}else{

				$filename = $image_P;

			}
		}


	$name = $this->input->post('name');
	$email = $this->input->post('email');
	$mobile = $this->input->post('mobile');
	$title = $this->input->post('title');
	$discription = $this->input->post('description');

	$array = array(
		'eq_name'=>$name,
		'eq_mobile'=>$mobile,
		'eq_email'=>$email,
		'eq_title'=>$title,
		'eq_discription'=>$discription,
		'eq_upload'=>$filename,
		'eq_oline_offline'=>1,
	);


	$this->db->insert('enquirey_form', $array);
	$insert_id = $this->db->insert_id();

	if($insert_id != 0){

		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success ! </strong> Enquirey Successfull submitted. 
  </div>');
	redirect('Welcome/enquiry', 'refresh');


	}else{
		
		$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Failed ! </strong> Enquirey Failed to submitted . 
  </div>');
	redirect('Welcome/enquiry', 'refresh');

	}
}
public function do_upload($image_P){


	$config = array();
	$config['upload_path'] = 'admin/uploads/';
	$config['allowed_types'] = '*';
	$config['remove_spaces'] = TRUE;
	$config['encrypt_name'] = TRUE;
	$config['file_name']=$image_P;
	return $config;
	
	}
}
