<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Academics extends CI_Controller
{

	private $CI;
	protected $user_department;
	protected $user_main_stream;
	protected $user_course_stream;
	protected $user_register_number;
	protected $user_ref_number;
	protected $user_number;
	protected $user_semester;
	protected $user_batch;
	protected $user_ad_id;

    public function __construct()
    {
        parent::__construct();
		$this->CI =& get_instance();
      //  $this->CI->load->database();
     //  ini_set('display_errors', 0);
	   $this->CI->load->library("useracadamic");
       date_default_timezone_set('Asia/Calcutta');
       $this->load->library('Pdf');
	  // $this->load->library('calendar');
	   if ($this->session->userdata("user")["user_year"] == "" || $this->session->userdata("user")["user_year"] == "0000" ) {
		$this->asyear = "2021/04/01 00:00:00";
		$this->aeyear = "2022/04/01  00:00:00";
	} else {
		$this->asyear = $this->session->userdata("user")["user_year"]."/04/01  00:00:00";
		$this->aeyear = $this->session->userdata("user")["user_year"]+ 1 ."/04/01  00:00:00";
		$this->syear = $this->session->userdata("user")["user_year"];
		$this->eyear = $this->session->userdata("user")["user_year"]+1;
	}
	  
	
	
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




	/* 	echo $rests;
		echo $this->session->userdata("user")["user_id"];
		echo $this->session->userdata("user")["user_year"]; */


 		if($rests > 0){
$user_d = $stud_id->result();

//print_r($user_d);



$this->user_department = $user_d[0]->comp_name;
$this->user_main_stream = $user_d[0]->sl_main_id;
$this->user_course_stream = $user_d[0]->sl_course_id;
$this->user_register_number = $user_d[0]->as_reg_num;
$this->user_ref_number = date("y",strtotime($this->session->userdata("user")["user_year"]."-01-01")).$this->session->userdata("user")["user_id"];
$this->user_number =$this->session->userdata("user")["user_id"];
$this->user_semester =$this->session->userdata("user")["user_semester"];
$this->user_batch =$this->session->userdata("user")["user_year"];
$this->user_ad_id =$user_d[0]->sid;




		}else{

			redirect('Home/logOut', 'refresh');




		} 
	
	}
	public function index(){


		//print_r($_SESSION);


		$stud_id = $this->db->select("admitted_student.*,shotlisted_candidate.*,department_details.*")->from("shotlisted_candidate")
    
		->join('department_details', 'shotlisted_candidate.sl_main_id = department_details.main_id AND shotlisted_candidate.sl_course_id = department_details.cour_id')
		->join('admitted_student', 'shotlisted_candidate.sl_id = admitted_student.as_shotlist_ref_number ')
		->where("sl_student_id",$this->session->userdata("user")["user_id"])
			->where("shotlisted_candidate.principal_published",1)
			->where("shotlisted_candidate.reservation_status",1)
		//->where("sl_student_id",$this->session->userdata("user")["user_id"])
			->get();
	   
			$rests = $stud_id->num_rows();



			


			if($rests > 0){
	
				$rest = $stud_id->result();



				if($rest[0]->sl_main_id == 5){

					$data['selected'] = $rest;
					$this->load->view("Home/template/head_ug");
					$this->load->view("Home/site/ug/acadamics", $data);
					$this->load->view("Home/template/footer_ug");
			
				}elseif($rest[0]->sl_main_id == 1){
			
				  $data['selected'] = $rest;
				  $this->load->view("Home/template/head");
				  $this->load->view("Home/site/pg/acadamics", $data);
				  $this->load->view("Home/template/footer");
			
				}else if($rest[0]->sl_main_id == 2){
			
						$data['selected'] = $rest;
				  $this->load->view("Home/template/head");
				  $this->load->view("Home/site/pg/acadamics", $data);
				  $this->load->view("Home/template/footer");
			
			
			
			
				}else if($rest[0]->sl_main_id == 3){
			
			
						$data['selected'] = $rest;
				  $this->load->view("Home/template/head");
				  $this->load->view("Home/site/pg/acadamics", $data);
				  $this->load->view("Home/template/footer");
			
			
			
				}else if($rest[0]->sl_main_id == 4){
			
			
			
			
			
			
						
				}else{
			
			
					redirect('Home/logOut', 'refresh');
			
			
			
				} 
			
				
			}else{


				redirect('Home/logOut', 'refresh');


			} 




		//echo $this->useracadamic->studentAcadamicYear($this->session->userdata("user")["user_id"]);

		//print_r($this->useracadamic->myBatch());

	


	}
	public function selectSemester(){


$sem = $this->input->post("semester");

$data=array(
	'u_semester'=>$sem,
);

$this->db->where("u_id",$this->session->userdata("user")["user_id"]);
$this->db->update("stu_user",$data);


$user = $this->db->select("*")->from("stu_user")->where("u_id",$this->session->userdata("user")["user_id"])->get();

$data = $user->result();

	$session_data = array(
		
	
		'user_id'=> $data[0]->u_id,
		'user_m_course'=> $data[0]->u_course,
		'user_name'=> $data[0]->u_name,
		'user_email_id'=> $data[0]->u_email_id,
		'user_mobile'=> $data[0]->u_mobile,
		'user_email_valid'=> $data[0]->u_email_valid,
		'user_mobile_valid'=> $data[0]->u_mobile_valid,
		'user_year'=>$data[0]->u_year,
		'user_semester'=>$sem,
		);

	 $this->session->set_userdata('user', $session_data);
	 $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!</strong> Semester Updated SuccessFully.
  </div>');


	}

	public function test(){




		echo date("n");
	}

public function feedBack(){

if(
	$this->session->userdata("user")["user_semester"]==0
){

	$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Failed to proceed !</strong> Please Select the semester to proceed.
  </div>');
  redirect('Academics/', 'refresh');
}


$arr=[];
$a_subject=[];
$a_subject = $this->db->select("fr_subject_id")->from("feedback_course_report")->where("fr_batch",$this->user_batch)
->where("fr_main_id",$this->user_main_stream)
->where("fr_course_id",$this->user_course_stream)
->where("fr_sem",$this->user_semester)
->where("fr_stud_id",$this->user_number)
->get()->result_array();



$s_subject = $this->db->select("*")->from("feedback_course_report")

->join('erp_subjectmaster', 'feedback_course_report.fr_subject_id = erp_subjectmaster.id ')
->where("fr_batch",$this->user_batch)
->where("fr_main_id",$this->user_main_stream)
->where("fr_course_id",$this->user_course_stream)
->where("fr_sem",$this->user_semester)
->where("fr_stud_id",$this->user_number)
->get()->result();



   $arr = array_column($a_subject, "fr_subject_id");


	/*  var_dump($arr);
	 var_dump($a_subject);
	 var_dump($s_subject);
	 var_dump($this->user_main_stream);
	 var_dump($this->user_course_stream); */
	 //var_dump($arr);
if(sizeof($arr)!=0){
	$not_in=$this->db->where_not_in("id",$arr);
}else{
	$not_in="";
}

 $this->db->select("*");
$this->db->from("erp_subjectmaster");
$this->db->where("batch_year",$this->user_batch);
$this->db->where("stream",$this->user_main_stream);
$this->db->where("department",$this->user_course_stream);
$this->db->where("sem",$this->user_semester);
$not_in;
$subject =$this->db->get();

$data['feed_form'] = $this->db->select("*")->from("feedback_course_teacher")->get()->result();
$data['subject'] = $subject->result();
$data['s_subject'] = $s_subject;





$this->load->view("Home/template/head");
$this->load->view("Home/site/pg/feedback_form", $data);
$this->load->view("Home/template/footer");





}
public function feedBackSubject(){

$subject_id = $this->uri->segment(3);


$data['subject'] = $this->db->select("*")->from("erp_subjectmaster")->where("batch_year",$this->user_batch)

->where("id",$subject_id )
->get()->result();

$data['feedback'] = $this->db->select("*")->from("feedback_course_teacher")
->get()->result();








$this->load->view("Home/template/head");
$this->load->view("Home/site/pg/feedback_form_subject",$data);
$this->load->view("Home/template/footer");



}
public function submitFeedBack(){


$one = $this->input->post('1');
$two = $this->input->post('2');
$three = $this->input->post('3');
$four = $this->input->post('4');
$five = $this->input->post('5');
$six = $this->input->post('6');
$seven = $this->input->post('7');
$eight = $this->input->post('8');
$nine = $this->input->post('9');
$ten = $this->input->post('10');
$eleven = $this->input->post('11');
$twelve = $this->input->post('12');
$thirteen = $this->input->post('13');
$fourteen = $this->input->post('14');
$fifteen = $this->input->post('15');
$sixteen = $this->input->post('16');
$seventeen = $this->input->post('17');
$subj = $this->input->post('subj_id');


$array = array(
	
	'fr_batch'=>$this->user_batch,
	'fr_sem'=>$this->user_semester,
	'fr_main_id'=>$this->user_main_stream,
	'fr_course_id'=>$this->user_course_stream,
	'fr_subject_id'=>$subj,
	'fr_stud_id'=>$this->user_number,
	'fr_stud_ad_id'=>$this->user_ad_id,
	'fr_1'=>$one,
	'fr_2'=>$two,
	'fr_3'=>$three,
	'fr_4'=>$four,
	'fr_5'=>$five,
	'fr_6'=>$six,
	'fr_7'=>$seven,
	'fr_8'=>$eight,
	'fr_9'=>$nine,
	'fr_10'=>$ten,
	'fr_11'=>$eleven,
	'fr_12'=>$twelve,
	'fr_13'=>$thirteen,
	'fr_14'=>$fourteen,
	'fr_15'=>$fifteen,
	'fr_16'=>$sixteen,
	'fr_17'=>$seventeen,
);

$this->db->insert("feedback_course_report",$array);

$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Updated !</strong> Feedback Updated.
  </div>');
  redirect('Academics/feedBack', 'refresh');


}
public function calanderAttendence(){

	
	
	$attandance = $this->db->select("att_date, COUNT(*) AS tot")->from("erp_stu_attendance")->where("sem",$this->user_semester)->where("student_id",$this->user_ad_id)->group_by('att_date')->get()->result();
	
$sub_tot =[];
$my_sub_tot =[];
$sub_name =[];
$sub_id =[];



// $this->db->select("*")->from("erp_student_elective_subject")->where("e_admit_stu_id",$this->user_ad_id)->where("e_sem",$this->user_semester)->get();


	$data['attandance'] = 
	
	$this->db->select("erp_subjectmaster.*,erp_stu_attendance.*, COUNT(*) AS tot")
	->from("erp_subjectmaster")
	->join('erp_stu_attendance','erp_subjectmaster.id=erp_stu_attendance.subject_id','right')
	->where("erp_stu_attendance.sem",$this->user_semester)->where("erp_stu_attendance.student_id",$this->user_ad_id)->get()->result();
	

	
	$att_tot =$this->db->select("erp_subjectmaster.*")
	->from("erp_subjectmaster")
	
	->where("erp_subjectmaster.sem",$this->user_semester)
	->where("erp_subjectmaster.stream",$this->user_main_stream )
	->where("erp_subjectmaster.department",$this->user_course_stream )
	->where("erp_subjectmaster.batch_year",$this->session->userdata("user")["user_year"])

	->group_by('subName')

	->get()->result();
/* echo"<pre>";

echo $this->user_ad_id;

print_r($att_tot); */
foreach ($att_tot as $key => $value) {

/* echo $value->subName."<br>";
echo $value->id."<br>";
 */
	$attandancef = $this->db->select("COUNT(*) AS tot")->from("erp_stu_attendance")->where("subject_id",$value->id)->group_by('att_date')->group_by('period')->get()->result();
/* 	print_r($attandancef); */
$tothour = sizeof($attandancef);

//$sub_tot[$value->id][$tothour];

array_push($sub_tot, $tothour);
array_push($sub_name, $value->subName);
array_push($sub_id, $value->id);


$nt = $this->db->select("erp_subjectmaster.*, COUNT(*) AS tot")
->from("erp_stu_attendance")
->join('erp_subjectmaster','erp_subjectmaster.id=erp_stu_attendance.subject_id','right')

->where("erp_stu_attendance.student_id",$this->user_ad_id)
->where("erp_stu_attendance.subject_id",$value->id)
->where("erp_stu_attendance.attndnce_status",1)
->get()->result();
array_push($my_sub_tot, $nt[0]->tot);

//print_r($nt);

}
$data['total_hour']=$sub_tot;
$data['total_name']=$sub_name;
$data['total_id']=$sub_id;
$data['my_total_id']=$my_sub_tot;
$data['admiteduserid']=$this->user_ad_id;


foreach ($attandance as $key => $value) {
	$data['data'][$key]['title'] = $value->tot;
	$data['data'][$key]['start'] = $value->att_date;
	//$data['data'][$key]['end'] = $value->end_date;
	$data['data'][$key]['backgroundColor'] = "#00a65a";
}


//print_r($data);

//exit;
//echo $this->user_main_stream ;
 if($this->user_main_stream == 1 || $this->user_main_stream == 2 || $this->user_main_stream == 3){

 $this->load->view("Home/template/head");
$this->load->view("Home/site/pg/calander",$data);
$this->load->view("Home/template/footer"); 

}else if($this->user_main_stream == 5){
 $this->load->view("Home/template/head");
$this->load->view("Home/site/ug/calander",$data);
$this->load->view("Home/template/footer"); 

}else{





}
 



}
public function loadAttendence(){


	/* foreach($event_data->result_array() as $row)
	{
	 $data[] = array(
	  'id' => $row['id'],
	  'title' => $row['title'],
	  'start' => $row['start_event'],
	  'end' => $row['end_event']
	 );
	}
	echo json_encode($data); */
   //}

   $attandance = $this->db->select("att_date, COUNT(*) AS tot")->from("erp_stu_attendance")->where("sem",$this->user_semester)->where("student_id",$this->user_ad_id)->group_by('att_date')->get()->result();
   //$attandance = $this->db->select("att_date, COUNT(*) AS tot")->from("erp_stu_attendance")->where("sem",$this->user_semester)->where("student_id",$this->user_ad_id)->group_by('att_date')->get()->result();
	



   /* echo "<pre>";
   print_r($attandance) */;
   
   
   
   foreach ($attandance as $key => $value) {

	$data[] = array(
		//'id' => $row['id'],
		'title' => $value->tot." Hours",
		'start' => $value->att_date,
	///	'end' => $row['end_event']
	   );
	 /*   $data['data'][$key]['title'] = $value->tot;
	   $data['data'][$key]['start'] = $value->att_date;
	   //$data['data'][$key]['end'] = $value->end_date;
	   $data['data'][$key]['backgroundColor'] = "#00a65a"; */
   }
   echo json_encode($data);


}
public function getDayAttendence(){


$date = $this->input->post('start');




$dataattandance = 
	
	$this->db->select("erp_subjectmaster.*,erp_stu_attendance.*")
	->from("erp_stu_attendance")
	->join('erp_subjectmaster','erp_subjectmaster.id=erp_stu_attendance.subject_id','left')
	->where("erp_stu_attendance.sem",$this->user_semester)
	->where("erp_stu_attendance.att_date",$date)
	//->where("erp_stu_attendance.attndnce_status",1)
	->where("erp_stu_attendance.student_id",$this->user_ad_id)
	->order_by('period','ASC')
	->get()
	->result();

	//print_r($dataattandance);
if(sizeof($dataattandance) > 0){
	$html="<h1 style='align:center'>Date :  ".date('d-M-y',strtotime($date))."</h1><ul>";
	foreach ($dataattandance as $key => $value) {

		if($value->attndnce_status == 1){

		$html .= "<li style='color:green'>".$value->subName." : ".$value->period." Hour Present</li>";
		}else{
			$html .= "<li style='color:red'>".$value->subName." : ".$value->period." Hour Absent </li>";	
		}
	}
	$html.= "</ul>";

echo $html;
}else{
echo $html="No Attendence Available on this Date ".date('d-M-y',strtotime($date));

}

}
public function certificate(){


$data['certificate'] = $this->db->select("*")->where("sc_status",1)->get("student_request_certificate")->result();
$data['requested_certificate'] = $this->db->select("*")->from("student_requested_certificate")
->join("student_request_certificate","student_requested_certificate.sr_cert_id=student_request_certificate.cs_id")
->where("sr_student_id",$this->user_number)->get()->result();


$this->load->view("Home/template/head");
$this->load->view("Home/site/pg/certificate_request",$data);
$this->load->view("Home/template/footer");

}

public function postCertificate(){


$title =$this->input->post("title");
$cert_id =$this->input->post("certificate");


$q = $this->db->select("*")->from("student_requested_certificate")->where("sr_cert_id",$cert_id)->where("sr_student_id",$this->user_number)->get();



$m= $q->num_rows();

if($m == 0){




	$data= array(
		'sr_department'=>$this->user_department ,
		'sr_batch'=>$this->user_batch ,
		'sr_student_id'=>$this->user_number ,
		'sr_title'=>$title ,
		'sr_req_date'=>date("Y-m-d") ,
		'sr_cert_id'=>$cert_id ,
		
	);


$this->db->insert("student_requested_certificate",$data);




}else{

	$data= array(
		'sr_department'=>$this->user_department ,
		'sr_batch'=>$this->user_batch ,
		'sr_student_id'=>$this->user_number ,
		'sr_title'=>$title ,
		'sr_req_date'=>date("Y-m-d") ,
		'sr_status'=>0 ,
		'sr_cert_id'=>$cert_id ,
		
	);

$this->db->where("sr_cert_id",$cert_id);
$this->db->where("sr_student_id",$this->user_number);
$this->db->update("student_requested_certificate",$data);
}

$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>requested !</strong>requested Successfully.
  </div>');
  redirect('Academics/certificate', 'refresh');



}

public function electiveSubject(){

$data["my_elective"]=$this->db->select("*")->from("erp_student_elective_subject")
->join("erp_subjectmaster","erp_student_elective_subject.e_subject=erp_subjectmaster.id")
->where("e_stu_id",$this->user_number)->where("e_admit_stu_id",$this->user_ad_id)->where("e_sem",$this->user_semester)->where("e_batch",$this->user_batch)->get()->result();



$data["select_elective"] = $this->db->select("*")->from("erp_subjectmaster")->where("subCatg","Elective")->where("sem",$this->user_semester)->where("batch_year",$this->user_batch)->get()->result();


	$this->load->view("Home/template/head");
	$this->load->view("Home/site/pg/electivesubject",$data);
	$this->load->view("Home/template/footer");

}


public function selectElective(){

//print_r($_POST);

$subject_id = $this->input->post("elective_id");


$data = array(
	'e_stu_id'=>$this->user_number,
	'e_admit_stu_id'=>$this->user_ad_id,
	'e_sem'=>$this->user_semester,
	'e_batch'=>$this->user_batch,
	'e_subject'=>$subject_id,
);

$this->db->insert("erp_student_elective_subject",$data);

$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success !</strong>Successfully Selected.
  </div>');
  redirect('Academics/electiveSubject', 'refresh');

}

}
