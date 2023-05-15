<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CommonFunction extends CI_Controller {




public function __construct()
{
	parent::__construct();
	 // error_reporting(0);
	  date_default_timezone_set("Asia/Calcutta");
$this->load->library('useracadamic');



	if ($this->session->userdata("user")["user_aca_year"] == "" || $this->session->userdata("user")["user_aca_year"] == "0000" ) {
		$this->asyear = "2021/04/01 00:00:00";
		$this->aeyear = "2022/04/01  00:00:00";
	} else {
		$this->asyear = $this->session->userdata("user")["user_aca_year"]."/04/01  00:00:00";
		$this->aeyear = $this->session->userdata("user")["user_aca_year"]+ 1 ."/04/01  00:00:00";
		$this->syear = $this->session->userdata("user")["user_aca_year"];
		$this->eyear = $this->session->userdata("user")["user_aca_year"]+1;
	}
}
public function index(){





    
}
public function updateRegNumber(){


$id = $_POST['reg_id'];
$number = $_POST['value'];


$nd = $this->db->select("*")->from("admitted_student")->where("as_id",$id)->get();

 $rs = $nd->num_rows();

if($rs > 0){

	$data = array(
		'as_reg_num'=>$number,
	);
	$this->db->where("as_id",$id);
	$this->db->update("admitted_student",$data);
	
	
	echo $this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Success !</strong>Register Updated Successfully .
	</div>');
	


}else{

	echo $this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Failed !</strong>Register number First Then Update .
						</div>');


}



}


public function admitStudentErp(){

$stud=[];
$studs=[];
$stude=[];
$main_id = $this->uri->segment(3);
$cour_id = $this->uri->segment(4);







	$user_exist = $this->db->select("student_id")->from("erp_existing_students")->where("main_id",$main_id)->where("cour_id",$cour_id)->get()->result_array();

	$studs= array_column($user_exist, 'student_id');
	$stude = array_filter($studs);
	$stud = array_values($stude);
	/* echo"<pre>";
	print_r($studs ); 
	print_r($stude ); 
	print_r($stud );  */

	$resu_q = $this->db->select("*")->from("admitted_student")
	->join("shotlisted_candidate","admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id")
	->join("stu_user","admitted_student.as_student_id=stu_user.u_id")
	->join("department_details","shotlisted_candidate.sl_main_id=department_details.main_id AND shotlisted_candidate.sl_course_id=department_details.cour_id")
   ->where('admitted_student.year',date('Y'))   
	->where('shotlisted_candidate.sl_main_id',$main_id)   
	->where('shotlisted_candidate.sl_course_id',$cour_id)   
	->where_not_in('admitted_student.as_student_id',$stud)   
	//->where('admitted_student.as_student_id',$stud)   
   
	->order_by('admitted_student.as_reg_num', 'asc')
	->get();
  
	$resu_n = $resu_q->num_rows(); 
	//echo"2014 Batch/BSW-14-01";
   
/*  echo"<pre>";
print_r($studs ); 
print_r($stude ); 
print_r($stud ); 
print_r($resu_q->result() ); 

exit;  */
  if($resu_n > 0){


	$resu = $resu_q->result();
 
	//print_r($resu);
  
  
  

  
	$sli=$resu_n;
	$slj=$resu_n;
	$slk=$resu_n;
	$sll=$resu_n;
	$slm=$resu_n;
	$sln=$resu_n;
	$slo=$resu_n;
	$mswai=$resu_n;
	$mswaj=$resu_n;
	$mswak=$resu_n;
	$mswsi=$resu_n;
	$mswsj=$resu_n;
	$mswsk=$resu_n;
	$pgdi=$resu_n;
	$pgdk=$resu_n;
   
	$m=$resu_n;
	$n=$resu_n;
  
  
  
  
  
  
  
  
	foreach ($resu as $key => $value) {
  
  
  if($value->sl_main_id == 1 ){
  
  
	if($value->sl_course_id ==5 ){
	$stud = $this->db->select("*")->from("new_preview_pg")->where('pr_user_id',$value->u_id)->get()->result();
	$batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-";
	$sli++;
	} else if($value->sl_course_id == 6 ){
  
	  $stud = $this->db->select("*")->from("new_preview_pg")->where('pr_user_id',$value->u_id)->get()->result();
	  $batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-";
	  $slj++;
  
	}else if($value->sl_course_id == 7 ){
  
	  $stud = $this->db->select("*")->from("new_preview_pg")->where('pr_user_id',$value->u_id)->get()->result();
	  $batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-";
	  $slk++;
	  
	}else if($value->sl_course_id == 8 ){
	  $stud = $this->db->select("*")->from("new_preview_pg")->where('pr_user_id',$value->u_id)->get()->result();
	  $batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-";
	  $sll++;
  
	  
	}else if($value->sl_course_id == 9 ){
  
	  $stud = $this->db->select("*")->from("new_preview_pg")->where('pr_user_id',$value->u_id)->get()->result();
	  $batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-";
	  $slm++;
	  
	}else if($value->sl_course_id == 15 ){
  
	  $stud = $this->db->select("*")->from("new_preview_pg")->where('pr_user_id',$value->u_id)->get()->result();
	  $batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-";
	  $sln++;
	  
	}
	else if($value->sl_course_id == 16 ){
  
		$stud = $this->db->select("*")->from("new_preview_pg")->where('pr_user_id',$value->u_id)->get()->result();
		$batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-";
		$slo++;
		
	  }
  
  
  }else if( $value->sl_main_id == 2 ){
  
	if($value->sl_course_id ==1 ){
	$stud = $this->db->select("*")->from("new_preview_pg")->where('pr_user_id',$value->u_id)->get()->result();
	$batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-";
	$mswai++;
	} else if($value->sl_course_id ==2 ){
	$stud = $this->db->select("*")->from("new_preview_pg")->where('pr_user_id',$value->u_id)->get()->result();
	$batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-";
	$mswaj++;
	}else if($value->sl_course_id ==3 ){
	$stud = $this->db->select("*")->from("new_preview_pg")->where('pr_user_id',$value->u_id)->get()->result();
	$batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-";
	$mswak++;
	}
  
  }else if( $value->sl_main_id == 3 ){
  
  
	if($value->sl_course_id ==1 ){
	  $stud = $this->db->select("*")->from("new_preview_pg")->where('pr_user_id',$value->u_id)->get()->result();
	  $batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-";
	  $mswsi++;
	  } else if($value->sl_course_id ==2 ){
	  $stud = $this->db->select("*")->from("new_preview_pg")->where('pr_user_id',$value->u_id)->get()->result();
	  $batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-";
	  $mswsj++;
	  }else if($value->sl_course_id ==3 ){
	  $stud = $this->db->select("*")->from("new_preview_pg")->where('pr_user_id',$value->u_id)->get()->result();
	  $batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-";
	  $mswsk++;
	  }
  
  
  }else if($value->sl_main_id == 4){
  
	if($value->sl_course_id == 10){
  
	  $stud = $this->db->select("*")->from("new_preview")->where('pr_user_id',$value->u_id)->get()->result();
	  $batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-";
	  $pgdi++;
	}else{
	
	  $stud = $this->db->select("*")->from("new_preview")->where('pr_user_id',$value->u_id)->get()->result();
	  $batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-";
	  $pgdk++;
	
	
	
	}
  
  }else if($value->sl_main_id == 5){
  
  if($value->sl_course_id == 1){
  
	$stud = $this->db->select("*")->from("new_preview")->where('pr_user_id',$value->u_id)->get()->result();
	$batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-";
	$m++;
  }else{
  
	$stud = $this->db->select("*")->from("new_preview")->where('pr_user_id',$value->u_id)->get()->result();
	$batch = $value->u_year." Batch/".$value->short_name."-".substr($value->u_year, -2)."-";
	$n++;
  
  
  
  }
   
  
  }
  
  
  //print_r($stud)."<br>";
  
  /* echo  $batch;
  
  echo"<br>"; */

  $newstring = substr($value->as_reg_num, -3);
  
	 $data=array(
	   "batch_"=>$batch.$newstring,
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
	   "admitted_batch"=>$value->u_year,
	   
	 );
	 $user_count = $this->db->select("student_id")->from("erp_existing_students")->where("student_id",$value->as_student_id)->get()->num_rows();
if( $user_count == 0){
$this->db->insert("erp_existing_students",$data);
}
 // print_r($data);
  
  
  
	}

	$this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Success !</strong> Data insert to ERP Updated Successfully .
	</div>');

}else{

	 $this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Failed !</strong>No data Found to push ERP
						</div>');


}
  redirect($_SERVER['HTTP_REFERER']);
  
  }
public function selectERPAdStud(){


	$user_exist = $this->db->select("id,batch_")->from("erp_existing_students")->get()->result();

echo"<pre>";
	foreach ($user_exist as $key => $value) {
		$data=array(
			"admitted_batch"=>substr($value->batch_, 0,4));
$this->db->where("id",$value->id);
$this->db->update("erp_existing_students",$data);
print_r($data);
			
	}






}




public function deleteAdmitedStudent(){

	$id = $_POST['reg_id'];

	$this->db->where('as_id', $id);
	$this->db->delete('admitted_student');
	
	echo $this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Deleted !</strong>Deleted successfully .
	</div>');



}
public function deleteAllAdmitedStudent(){



	$id = $_POST['reg_id'];

	$this->db->where('as_dep', $id);
	$this->db->where('year',  $this->session->userdata("user")["user_aca_year"]);
	$this->db->delete('admitted_student');

	echo $this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Deleted !</strong>Deleted successfully .
	</div>');
}

public function acadamicYear(){


$user_id = $this->input->post("user_id");

$ayear_id = $this->input->post("a_year");

$data = array(
	'ad_year'=>$ayear_id,
);

$this->db->where("ad_id",$user_id);
$this->db->update("admin",$data);


 $this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong> Successfully acadamic year Updated Login again.
</div>');


		redirect('Welcome/logOut', 'refresh');

}

public function excelImport($main_cour_id,$app_cour_id){



	$main_cour_id = $this->uri->segment(3);
	$app_cour_id = $this->uri->segment(4);
	
	
	
		/*$ma_dm=$this->db->select("user_id")->from("Applyed_Cources")->where("main_course_id",$main_cour_id)->where("applied_course_id",$app_cour_id)->get();
	 	$applied_ma_dm =$ma_dm->result_array();
			$arrma_dm = array_column($applied_ma_dm, "user_id");
			if( sizeof($arrma_dm) == 0 ){
			$arrma_dm = array('0');}
	 */
		
			$this->db->select('stu_user.*,shotlisted_candidate.*,Applyed_Cources.*,new_preview_pg.*,sub_preview_pg.*,student_complete_mark.personal_mark');
			$this->db->from('shotlisted_candidate');
			//$this->db->from('Applyed_Cources');
			$this->db->join('Applyed_Cources','shotlisted_candidate.sl_student_id=Applyed_Cources.user_id AND shotlisted_candidate.sl_main_id=Applyed_Cources.main_course_id and shotlisted_candidate.sl_course_id=Applyed_Cources.applied_course_id');
			$this->db->join('stu_user', 'shotlisted_candidate.sl_student_id=stu_user.u_id','right');
			$this->db->join('new_preview_pg', 'shotlisted_candidate.sl_student_id=new_preview_pg.pr_user_id','right');
			$this->db->join('sub_preview_pg', 'shotlisted_candidate.sl_student_id=sub_preview_pg.sb_u_id','right');
			$this->db->join('student_complete_mark', 'shotlisted_candidate.sl_main_id=student_complete_mark.main_course_id and shotlisted_candidate.sl_course_id=student_complete_mark.app_course_id and shotlisted_candidate.sl_student_id=student_complete_mark.stu_id','left');
			$this->db->where('shotlisted_candidate.reservation_status',1);
			$this->db->where('shotlisted_candidate.sl_main_id',$main_cour_id);
			$this->db->where('shotlisted_candidate.sl_course_id',$app_cour_id);
			$this->db->where('shotlisted_candidate.created >',$this->asyear);
			$this->db->where('shotlisted_candidate.created <',$this->aeyear);
			$st_dm =	$this->db->get();
		
			$data['applied'] = $st_dm->result();
			$data['course'] = 2;

	if($main_cour_id == 1){

		switch ($app_cour_id) {
	
			case "5":
		$data['subject']='MAHRM';
		$data['department']='M.A. Human Resource Management (SF)';
			break;
			case "6":
				$data['subject']='MAHRM';
				$data['department']='M.A. Human Resource And Organization Development (SF)';
			break;
			case "7":
				$data['subject']='MASE';
				$data['department']='M.A. Social Entrepreneurship (SF)';
			break;
			case "8":
				$data['subject']='MADM';
				$data['department']='M.A. Development Management (SF)';
			break;
			case "9":
				$data['subject']='MSCCF';
				$data['department']='M.Sc. Counselling Psychology (SF)';
			break;
			case "15":
				$data['subject']='MSW';
				$data['department']='M.S.W. Disability and Empowerment (SF)';
			break;
			case "16":
				$data['subject']='MSCCFA';
				$data['department']='M.Sc Family Counselling (SF)';
			break;
		  default:
		  $data['subject']='MSW';
		  $data['department']='';
			}

	}else if($main_cour_id == 2){
		switch ($app_cour_id) {
	
			case "1":
		$data['subject']='MSW AIDED';
		$data['department']='Community Development';
			break;
			case "2":
				$data['subject']='MSW AIDED';
				$data['department']='Medical & Psychiatric Social Work';
			break;
			case "3":
				$data['subject']='MSW AIDED';
				$data['department']='Human Resource Management';
			break;
		

		  default:
		  $data['subject']='MSW';
		  $data['department']='';
		}


	}else{

		switch ($app_cour_id) {
	
			case "1":
		$data['subject']='MSW SELF FIN';
		$data['department']='Community Development';
			break;
			case "2":
				$data['subject']='MSW SELF FIN';
				$data['department']='Medical & Psychiatric Social Work';
			break;
			case "3":
				$data['subject']='MSW SELF FIN';
				$data['department']='Human Resource Management';
			break;
		

		  default:
		  $data['subject']='MSW';
		  $data['department']='';
		}	



	}
		

	
	
			$this->load->view('template/admin/header');
		//	$this->load->view('template/admin/menubar');
		//	$this->load->view('template/admin/headerbar');
			//$this->load->view('admin/student_applied',$data);
			$this->load->view('admin/student_export',$data);
			$this->load->view('template/admin/footer',$data);
		

}
public function importExcelUg(){

	//$main_cour_id = $this->uri->segment(3);
	$app_cour_id = $this->uri->segment(3);

	switch ($app_cour_id) {
	
		case "1":
	$data['subject']='U.G.-B.S.W';
	$data['department']='Bachelor of Social Work (SF)';
		break;
		case "2":
			$data['subject']='U.G.-B.Sc';
			$data['department']='B.Sc Psychology (SF)';
		break;
	

	  default:
	  $data['subject']='MSW';
	  $data['department']='';
	}	





	$this->db->select('stu_user.*,shotlisted_candidate.*,Applyed_Cources.*,new_preview.*,sub_preview.*');
			$this->db->from('shotlisted_candidate');
			//$this->db->from('Applyed_Cources');
			$this->db ->join(
				"Applyed_Cources",
				"Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id" ,'right'
			)
	;
			$this->db->join('stu_user', 'shotlisted_candidate.sl_student_id=stu_user.u_id','right');
		//	$this->db->join('admitted_student', 'shotlisted_candidate.sl_id=admitted_student.as_shotlist_ref_number','right');

			$this->db->join(
				"new_preview",
				"shotlisted_candidate.sl_student_id=new_preview.pr_user_id",
				"right"
			);
			$this->db->join(
				"sub_preview",
				"shotlisted_candidate.sl_student_id=sub_preview.sb_u_id",
				"right");


	
			$this->db->where('shotlisted_candidate.reservation_status',1);
			$this->db->where('shotlisted_candidate.sl_main_id',5);
			$this->db->where('shotlisted_candidate.sl_course_id',$app_cour_id);
			$this->db->where('shotlisted_candidate.created >',$this->syear."-06-01");
			$this->db->where('shotlisted_candidate.created <',$this->eyear."-06-01");
		//	$this->db->where_in("Applyed_Cources.user_id",$arrma_dm );
			$user =	$this->db->get();

   
   $data['count'] =$user->num_rows();
		  $data['student'] =$user->result();

		  $data['title'] = "Reports of Student Applied ".$this->session->userdata('user')['user_name']." ".date('d-M-Y');
	 
	/* 	echo $this->syear."-06-01";
		echo"<pre>";
		
		print_r($data); 
	
		exit;
	  */
			$this->load->view('template/admin/header');
		 //  $this->load->view('template/admin/menubar');
		   //$this->load->view('template/admin/headerbar');
		   $this->load->view('admin/student_export_ug',$data);
		   $this->load->view('template/admin/footer',$data);  
}
public function videoTracking(){

	$dept = $this->uri->segment(3);
	$sid = $this->uri->segment(4);

$data['video'] = $this->db->select("*")->from("online_exam_video_tracker")->where("student_id",$sid)->order_by("o_v_id","ASC")->get()->result();




/* echo"<pre>";

print_r($data); */


if($dept==1){

	$data['title'] = "Reports of  ".$this->session->userdata('user')['user_name']." ".date('d-M-Y');
		
	$this->load->view("template/selffinance/header");
        $this->load->view("template/selffinance/menubar");
        $this->load->view("template/selffinance/headerbar");
        $this->load->view("common_function/video_record",$data);
        $this->load->view("template/selffinance/footer");
	}else if($dept==2){

		$data['title'] = "Reports of  ".$this->session->userdata('user')['user_name']." ".date('d-M-Y');

		$this->load->view("template/pgmswaided/header");
        $this->load->view("template/pgmswaided/menubar");
        $this->load->view("template/pgmswaided/headerbar");
		$this->load->view("common_function/video_record",$data);
        $this->load->view("template/pgmswaided/footer", ); 

	}else{
		$data['title'] = "Reports of  ".$this->session->userdata('user')['user_name']." ".date('d-M-Y');

		$this->load->view("template/pgmswselffin/header");
		$this->load->view("template/pgmswselffin/menubar");
		$this->load->view("template/pgmswselffin/headerbar");
		$this->load->view("common_function/video_record",$data);
		$this->load->view("template/pgmswselffin/footer"); 

	}






}

}
