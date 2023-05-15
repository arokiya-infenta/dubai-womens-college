<?php
defined("BASEPATH") or exit("No direct script access allowed");
use Dompdf\Dompdf;
use Dompdf\Options;
class MyExamination extends CI_Controller
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
	protected $user_name;

    public function __construct()
    {
        parent::__construct();

	//	include APPPATH . 'third_party/payment/TransactionRequestBean.php';	
	//	include APPPATH . 'third_party/payment/TransactionResponseBean.php';

		if(!isset($this->session->userdata("user")["user_id"] )){

			redirect('Home/logOut', 'refresh');
	
		 } 
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


		if($rests > 0){
$user_d = $stud_id->result();

//print_r($user_d);



$this->user_department = $user_d[0]->comp_name;
$this->user_main_stream = $user_d[0]->sl_main_id;
$this->user_course_stream = $user_d[0]->sl_course_id;
$this->user_register_number = $user_d[0]->as_reg_num;
$this->user_ref_number = date("y",strtotime($this->session->userdata("user")["user_year"]."-01-01")).$this->session->userdata("user")["user_id"];
$this->user_number =$this->session->userdata("user")["user_id"];
$this->user_semester = $this->session->userdata("user")["user_semester"];
$this->user_batch =$this->session->userdata("user")["user_year"];
$this->user_ad_id =$user_d[0]->sid;
$this->user_name =$user_d[0]->as_name;


if($this->session->userdata("user")["user_semester"] == 0 || $this->session->userdata("user")["user_semester"]=="" ){


	$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">
   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
   <strong>Failed!</strong> Please Select the Semester.
 </div>');


	redirect('Academics', 'refresh');


}

		}else{

			redirect('Home/logOut', 'refresh');




		}
	
	}


	public function index(){

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
					$this->load->view("Home/site/ug/examination", $data);
					$this->load->view("Home/template/footer_ug");
			
				}elseif($rest[0]->sl_main_id == 1){
			
				  $data['selected'] = $rest;
				  $this->load->view("Home/template/head");
				  $this->load->view("Home/site/pg/examination", $data);
				  $this->load->view("Home/template/footer");
			
				}else if($rest[0]->sl_main_id == 2){
			
						$data['selected'] = $rest;
				  $this->load->view("Home/template/head");
				  $this->load->view("Home/site/pg/examination", $data);
				  $this->load->view("Home/template/footer");
			
			
			
			
				}else if($rest[0]->sl_main_id == 3){
			
			
						$data['selected'] = $rest;
				  $this->load->view("Home/template/head");
				  $this->load->view("Home/site/pg/examination", $data);
				  $this->load->view("Home/template/footer");
			
			
			
				}else if($rest[0]->sl_main_id == 4){
			
			
			
			
			
			
						
				}else{
			
			
					redirect('Home/logOut', 'refresh');
			
			
			
				} 
			
				
			}else{


				redirect('Home/logOut', 'refresh');


			}

	}

	public function examPayment(){


if($this->user_main_stream == 1 || $this->user_main_stream == 2 || $this->user_main_stream  == 3){

$main = 1;


	$data['current_paper'] = $this->db->select("erp_subjectmaster.*,erp_subjectmaster.sem AS semester,erp_subjectmaster.id AS sub_id,erp_exam_fees.*,erp_particulars.*")->from("erp_subjectmaster")
	->join("erp_particulars","erp_subjectmaster.subNature = erp_particulars.particular_name","left")
	->join("erp_exam_fees","erp_particulars.id = erp_exam_fees.particular_id AND erp_exam_fees.main_id =".$main,"left")
	->where("erp_subjectmaster.batch_year",$this->user_batch)
	->where("erp_subjectmaster.stream",$this->user_main_stream)
	->where("erp_subjectmaster.department",$this->user_course_stream)
	->where("erp_subjectmaster.sem",$this->session->userdata("user")["user_semester"])
	
	->get()->result();

	$data['arr_paper'] = $this->db->select("erp_exammarkfinal.*,erp_subjectmaster.*,erp_exammarkfinal.sem AS semester,erp_exam_fees.*,erp_particulars.*")
	
	->from("erp_exammarkfinal")
	->join("erp_subjectmaster","erp_exammarkfinal.subject_id=erp_subjectmaster.id")
	->join("erp_particulars","erp_subjectmaster.subNature = erp_particulars.particular_name")
	->join("erp_exam_fees","erp_particulars.id = erp_exam_fees.particular_id AND erp_exam_fees.main_id =".$main)
	->where("erp_exammarkfinal.batch_year",$this->user_batch)
	->where("erp_exammarkfinal.main_id",$this->user_main_stream)
	->where("erp_exammarkfinal.course_id",$this->user_course_stream)
	->where("erp_exammarkfinal.student_id",$this->user_ad_id)
	->where("erp_exammarkfinal.result !=","P")
	
	->get()->result();

/* echo $this->user_semester;
print_r($data);
exit;  */
	$this->load->view("Home/template/head");
	$this->load->view("Home/site/pg/examination_payment", $data);
	$this->load->view("Home/template/footer");


	}else if($this->user_main_stream == 4){

		$main = 2;



	}else{

		$main = 3;







	}
}

public function myexamFees(){


//print_r($_POST);

if($_POST){

$data["dept"] = $this->user_department ;
$data["main"] = $this->user_main_stream ;
$data["applied"] = $this->user_course_stream ;
$data["register"] = $this->user_register_number ;
$data["referance"] = $this->user_ref_number ;
$data["user_num"] = $this->user_number;
$data["semester"] = $this->user_semester ;
$data["batch"] = $this->user_batch ;
$data["adt_id"] = $this->user_ad_id ;
//$data["cur_exam"] = $this->input->post("cur_exam") ;
$data["arr_exam"] = $this->input->post("arr_exam") ;
$data["exam_fees"] = $this->input->post("exam_fees") ;



$array = array(

	'ef_stu_ad_id'=>$this->user_ad_id,
	'ef_stu_id'=>$this->user_number,
	'ef_batch'=>$this->user_batch,
	'ef_main'=>$this->user_main_stream,
	'ef_course'=>$this->user_course_stream,
	
	'ef_arr_exam'=>implode(',',$this->input->post("arr_exam")),
	'ef_exam_fees'=>$this->input->post("exam_fees"),
	//'ef_paid_date'=>,
	'ef_department'=>$this->user_department,
	
);

if($this->user_main_stream ==1 ||$this->user_main_stream==2 || $this->user_main_stream==3){

	$main = 1;

}else if($this->user_main_stream == 4){

	$main = 2;

}else{

	$main = 3;
}

$this->db->insert("erp_exam_fees_master",$array);
$insert_id = $this->db->insert_id();

//$data['fees_id']=$insert_id;


redirect('MyExamination/payArrearFees/'.$insert_id.'/'.$main ,'refresh');

}else{


redirect('MyExamination/examPayment');

}



}
public function payArrearFees(){

	$data['fees_id']=$this->uri->segment(3);
	$data['main']=$this->uri->segment(4);
	$this->load->view("Home/template/head");
	$this->load->view("Home/site/fees/arr_fees", $data);
	$this->load->view("Home/template/footer_ug");
 

}

public function timeTable(){


$data['timetable']= $this->db->select("*")->from("erp_exam_schedule")
->join("erp_subjectmaster","erp_exam_schedule.subject_id=erp_subjectmaster.id")
->where("erp_exam_schedule.batch_year",$this->user_batch)
->where("erp_exam_schedule.main_id",$this->user_main_stream)
->where("erp_exam_schedule.course_id",$this->user_course_stream)
->where("erp_exam_schedule.sem",$this->user_semester)
->get()->result();

$this->load->view("Home/template/head");
	$this->load->view("Home/site/pg/time_table", $data);
	$this->load->view("Home/template/footer");

}
public function hallTicketPDF()
	{

		$hallticket = $this->db->select("*")->from("erp_block_halltickets")
	
		->where("erp_block_halltickets.student_id",$this->user_ad_id)
		->where("erp_block_halltickets.status",1)
		->get();
		
	$block=	$hallticket->num_rows();

if($block > 0){


	$data['blocked'] = $hallticket->result();

	$this->load->view("Home/template/head");
	$this->load->view("Home/site/pg/hallticket_blocked", $data);
	$this->load->view("Home/template/footer");


}else{



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
$data['profile'] = $stud_id->result();
		}



		$this->load->library("pdf");
		ob_start();
		$id = $data['student_id'] = $this->user_ad_id;
		$sem = $data['sem'] = $this->user_semester;
		$batch = $data['batch'] = $this->user_batch;
		$batch = $data['batch'] = $this->user_batch;
		//$id = $data['student_id'] = 2045;
		//$sem = $data['sem'] = 2;
		//$batch = $data['batch'] = 2020;
		
		//$data['user']=$this->user_ad_id;
		$date=date('Y-m-d');
		
		$data['stu_list'] = $studet = $this->db->query('select * from erp_existing_students where id='.$this->user_ad_id.' ')->row();
		
		
            $html = $this->load->view("Home/site/pg/hallTicketPDF", $data, true);
            //$this->pdf->createPDF($html, 'mypdf', false);
            // Get output html

            $options = new Options();
            $options->set("isRemoteEnabled", true);

            $dompdf = new \Dompdf\Dompdf($options);
            $contxt = stream_context_create([
                "ssl" => [
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                    "allow_self_signed" => true,
                ],
            ]);
            $dompdf->setHttpContext($contxt);
			$dompdf->load_html($html);
            $dompdf->setPaper("A4", "landscape");
            $dompdf->render();
            ob_end_clean();
            $dompdf->stream("HallTicket.pdf", ["Attachment" => 0]);
		
    //$this->load->view('coe/hallTicketPDF',$data);
	}
	}
	public function result(){
//echo $this->user_ad_id;

/* echo $this->user_batch;
echo $this->user_main_stream;
echo $this->user_course_stream;
echo $this->user_semester;
echo $this->user_ad_id; */



		$data['result'] = 
		$this->db->select("erp_exammarkfinal.*,erp_exammarkfinal.result as result,erp_subjectmaster.subName,erp_subjectmaster.subCode,erp_subjectmaster.subNature,erp_subjectmaster.msw_m_25")
		->from("erp_exammarkfinal")
		->join("erp_subjectmaster","erp_exammarkfinal.subject_id=erp_subjectmaster.id","left")
		//->join("erp_exammark","erp_exammarkfinal.student_id=erp_exammark.student_id",'left')
		->where("erp_exammarkfinal.batch_year",$this->user_batch)
		->where("erp_exammarkfinal.main_id",$this->user_main_stream)
		->where("erp_exammarkfinal.course_id",$this->user_course_stream)
		->where("erp_exammarkfinal.sem",$this->user_semester)
		->where("erp_exammarkfinal.student_id",$this->user_ad_id)
		->where("erp_subjectmaster.subCode !=","")
		->get()->result();



 
	/* 	echo"<pre>";
		print_r($data);
		exit;  */
		
			$this->load->view("Home/template/head");
			$this->load->view("Home/site/pg/result", $data);
			$this->load->view("Home/template/footer");  

	}

	public function retotlingExamination(){


		$data['result']= $this->db->select("erp_exammarkfinal.*,erp_subjectmaster.id AS s_id, erp_subjectmaster.subName,erp_subjectmaster.subCode,erp_subjectmaster.subNature")->from("erp_exammarkfinal")
		->join("erp_subjectmaster","erp_exammarkfinal.subject_id=erp_subjectmaster.id","left")
		->where("erp_exammarkfinal.batch_year",$this->user_batch)
		->where("erp_exammarkfinal.main_id",$this->user_main_stream)
		->where("erp_exammarkfinal.course_id",$this->user_course_stream)
		->where("erp_exammarkfinal.student_id",$this->user_ad_id)
		->get()->result();

		//print_r($data);
		
			$this->load->view("Home/template/head");
			$this->load->view("Home/site/pg/re_totling", $data);
			$this->load->view("Home/template/footer"); 
	}
	public function retotling(){


		
	$id= $this->input->post("retot");

	$ret = $this->db->select("erp_exammarkfinal.*")->from("erp_exammarkfinal")
		->where("erp_exammarkfinal.id",$id)
	->get()->result();

	$value = array(
		'main_id'=>$this->user_main_stream,
		'course_id'=>$this->user_course_stream,
		'student_id'=>$this->user_ad_id,
		'batch_year'=>$this->user_batch,
		'sem'=>$ret[0]->sem,
		'subject_id'=>$ret[0]->subject_id,
		'status'=>'open',
		'coe_id'=>'0',
		'created_at'=>date("Y-m-d H:i:s"),
	);

	if($ret[0]->retotalling_status == 0){
		$this->db->insert("erp_retotalling",$value);


		$arr = array(
			'retotalling_status'=>1,
		);
	
		$this->db->where("id",$ret[0]->id);
		$this->db->update("erp_exammarkfinal",$arr);

		echo $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Success !</strong> Successfully Requested.
	  </div>');

	}else if($ret[0]->retotalling_status == 1){

		echo $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Failed !</strong> Already Requested.
	  </div>');

	}else{

		echo $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Failed !</strong> Already Solved.
	  </div>');


	}


	}
	public function CondonationFees(){




$cond_fee =  $this->db->select("*")->from("condanation_fee_transaction")->where("student_id",$this->user_number)->where("semester",$this->user_semester)->where("paid_status",1)->get()->result();


if(sizeof($cond_fee) > 0){

$data['cond_fee'] = $cond_fee;


$con_arr_redo = [];
$con_arr_redo = $this->calculateCondanationFees();

$where ="";


if(sizeof($con_arr_redo) == 0){

	$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong> </strong> You have No Condanation Fees To pay for this Semester'.$this->session->userdata('user')['user_name'].'.
</div>');
redirect('MyExamination', 'refresh');


}else{


$where = $this->db->where_in("id",$con_arr_redo);

}
	
 $this->db->select("*");
 $this->db->from("erp_subjectmaster");

 $where;
$m =$this->db->get();
 $data['condanation'] = $m->result();





	$this->load->view("Home/template/head");
	$this->load->view("Home/site/pg/condonation_paid_status", $data);
	$this->load->view("Home/template/footer"); 




}
else{


$con_arr_redo = [];
$con_arr_redo = $this->calculateCondanationFees();

$where ="";

if(sizeof($con_arr_redo) == 0){

	$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong> </strong> You have No Condanation Fees To pay for this Semester'.$this->session->userdata('user')['user_name'].'.
</div>');
redirect('MyExamination', 'refresh');


}else{


$where = $this->db->where_in("id",$con_arr_redo);

}
	
 $this->db->select("*");
 $this->db->from("erp_subjectmaster");

 $where;
$m =$this->db->get();
 $data['condanation'] = $m->result();
 $this->load->view("Home/template/head");
 $this->load->view("Home/site/pg/condanation", $data);
 $this->load->view("Home/template/footer"); 
}
	}

	public function calculateCondanationFees(){

		$sub_tot =[];
		$my_sub_tot =[];
		$sub_name =[];
		$sub_id =[];
		$cond_id =[];

		$att_tot =$this->db->select("erp_subjectmaster.*")
		->from("erp_subjectmaster")
		
		->where("erp_subjectmaster.sem",$this->user_semester)
		->where("erp_subjectmaster.stream",$this->user_main_stream )
		->where("erp_subjectmaster.department",$this->user_course_stream )
		->where("erp_subjectmaster.batch_year",$this->session->userdata("user")["user_year"])
	
		->group_by('subName')
	
		->get()->result();

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
			$data['subject_id']=$sub_id;
			$data['my_total_attended']=$my_sub_tot;
			$data['admiteduserid']=$this->user_ad_id;

			foreach ($data['subject_id'] as $keys => $values) { 
				foreach ($data['total_hour'] as $key => $value) { 
				foreach ($data['my_total_attended'] as $keyid => $valueid) { 
				

					if($value !=0){  $percentage = round($valueid * 100 / $value) ;}else{ $percentage = 0; }
					if($percentage >=75){$status='Eligible';}
					 elseif($percentage >= 64 && $percentage < 75){
						
				 	if($key === $keyid &&  $keyid === $keys){
					
						array_push($cond_id, $values);
						} 
					}
					 elseif($percentage >= 49 && $percentage < 66){$status='Not Eligible';
					
					
					
					}
					 else{$status='Redo';
					
					/* 	if($key === $keyid &&  $keyid === $keys){
					
							array_push($cond_id, $values);
							} */
					
					
					
					}
			}
			}
			}

			return array_unique($cond_id);
		//	return $data;


	}
	public function PayCondanationFees(){






	
$sub_id ="";
$sub_code_id ="";
$sub_arr =[];
$arr_sub_code =[];
		if(!isset($_POST['cond_exam']) || sizeof($_POST['cond_exam']) > 0 || $_POST['exam_fees'] !="" || $_POST['exam_fees'] !=0 ){

			$data["dept"] = $this->user_department ;
			$data["main"] = $this->user_main_stream ;
			$data["applied"] = $this->user_course_stream ;
			$data["register"] = $this->user_register_number ;
			$data["referance"] = $this->user_ref_number ;
			$data["user_num"] = $this->user_number;
			$data["semester"] = $this->user_semester ;
			$data["batch"] = $this->user_batch ;
			$data["adt_id"] = $this->user_ad_id ;

			
			$sub_arr = $this->input->post("cond_exam") ;



			$att_tot =$this->db->select("subCode")
		->from("erp_subjectmaster")
		
		->where_in("erp_subjectmaster.id",$sub_arr)
			->get()->result_array();

		$arr_sub_code = array_column($att_tot, "subCode");

//var_dump($arr_sub_code);
		$sub_id =	implode(',',$sub_arr);
		$sub_code_id =	implode(',',$arr_sub_code);

			$array = array(
			
				'student_id'=>$this->user_number,
				'add_student_id'=>$this->user_ad_id,
			
				'semester'=>$this->user_semester,
				'stream'=>$this->user_main_stream,
				'department'=>$this->user_course_stream,
				'batch'=>$this->user_batch,
				'register_id'=>$this->user_register_number,
				'student_name'=>$this->user_name,
				'subject_id'=>$sub_id,
				'subject_code'=>$sub_code_id,
				'amount_total'=>$this->input->post("exam_fees"),
			
	
				
			);
			
		
			$this->db->insert("condanation_fee_transaction",$array);
			$insert_id = $this->db->insert_id();
			
			$data['fees_id']=$insert_id;
			
			redirect('OtherPayment/condanationMakePayment/'.$insert_id);

			
			}else{
			
			
			redirect('MyExamination/CondonationFees');
			
			}
			

		
	}
	/* public function condanationMakePayment(){

$id= $this->uri->segment(3);


if($id==0 || $id=="" || $id==null){

	redirect('MyExamination/CondonationFees');

}else{

	$sub_imp =[];

	$nd = $this->db->select("*")->from('condanation_fee_transaction')->where('id',$id)->get()->result();

$sub = $nd[0]->subject_id;
$sub_imp = explode(',',$sub);
$att_tot =$this->db->select("*")
		->from("erp_subjectmaster")
		
		->where_in("erp_subjectmaster.id",$sub_imp)
			->get()->result();





			$data['transaction'] = $nd;
			$data['subject'] = $att_tot;
			$data['department'] = $this->user_department;


}


$this->load->view("Home/template/head");
$this->load->view("Home/site/pg/condanation_transaction",$data);
$this->load->view("Home/template/footer"); 





	} */


	public function internalMarks(){


		$data['internal'] =$this->db->select("erp_subjectmaster.*,erp_exammark.*")
		->from("erp_subjectmaster")
		->join("erp_exammark","erp_subjectmaster.id = erp_exammark.subject_id",'left')
		
		->where("erp_subjectmaster.sem",$this->user_semester)
		->where("erp_subjectmaster.stream",$this->user_main_stream )
		->where("erp_subjectmaster.department",$this->user_course_stream )
		->where("erp_subjectmaster.batch_year",$this->session->userdata("user")["user_year"])
		->where("erp_exammark.student_id",$this->user_ad_id)
	
		->group_by('subName')
	
		->get()->result();
		$data['stream']=$this->user_main_stream;

/* echo"<pre>";
print_r($att_tot); */


$this->load->view("Home/template/head");
$this->load->view("Home/site/pg/internalMark",$data);
$this->load->view("Home/template/footer");



	}

}
