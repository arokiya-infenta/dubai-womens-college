<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
//require APPPATH . '/libraries/dompdf/autoload.inc.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
	use Dompdf\Dompdf;
	use Dompdf\Options;
class NonTeachingEmployee extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	//  error_reporting(0);
	  date_default_timezone_set("Asia/Calcutta");
	  $this->load->library('upload');
	  $this->load->config('email');
		$this->load->library('email');
	    $this->load->helper(array('form', 'url'));
		$this->load->library('pdf');

	
	}



	public function index()
	{
		$data['user_id']=$this->session->userdata('user')['user_id'];
    $this->load->view('template/nonteaching/header');
    $this->load->view('template/nonteaching/menubar');
    $this->load->view('template/nonteaching/headerbar');
    $this->load->view('nonteaching/dashbord',$data);
    $this->load->view('template/nonteaching/footer');
    }
	public function updatePassword()
	{
		$data['user_id']=$user_id=$this->session->userdata('user')['user_id'];
		if(isset($_POST['submit'])){
			$old = $this->input->post('old');
			$new = $this->input->post('new');
			$confirm = $this->input->post('confirm');
		 $get_pwd = $this->db->where('password_',$old)->where('id',$user_id)->get('erp_employee_master')->row();
		 if(isset($get_pwd)){
			 if($new==$confirm){
				 $data_in['password_']=$confirm;
				 $this->db->where('id',$user_id)->update('erp_employee_master',$data_in);
				 $data['mesg']=$this->session->set_flashdata('success','Password Updated Successfully!!','success');
				 redirect('nonteaching/updatePassword','refresh');
			 }else{
				 $data['mesg']=$this->session->set_flashdata('form_err','New Password and Confirm Password does not match!!','danger');
				 redirect('nonteaching/updatePassword','refresh');
			 }
		 }else{
			$data['mesg']=$this->session->set_flashdata('form_err','Old Password does not match!!','danger'); 
			redirect('nonteaching/updatePassword','refresh');
		 }
		}
    $this->load->view('template/nonteaching/header');
    $this->load->view('template/nonteaching/menubar');
    $this->load->view('template/nonteaching/headerbar');
    $this->load->view('nonteaching/update_password',$data);
    $this->load->view('template/nonteaching/footer');
    }
		
	public function stuAttendance1()
	{
		$data['department']='';
		$data['program']='';
	if(isset($_POST['submit'])){
	  $department=$data['department']=$this->input->post('department');	
	  $program=$data['program']=$this->input->post('program');	
	  $data['stu_list']=$this->db->where('dept_',$program)->get('erp_studentdetails')->result();
	   if($department==1){
       $data['programm'] = $this->db->where('college_type_','Aided')->get('erp_department')->result();	}
	   else{
	   $data['programm'] = $this->db->where('college_type_','Self Finance')->get('erp_department')->result();	
	   }
	}
    $this->load->view('template/nonteaching/header');
    $this->load->view('template/nonteaching/menubar');
    $this->load->view('template/nonteaching/headerbar');
    $this->load->view('nonteaching/student_attendance1',$data);
    $this->load->view('template/nonteaching/footer');
    }
	public function stuAttendance()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$user=$this->db->where('id',$user_id)->get('erp_employee_master')->row();
		//$sub_list=explode(',',$user->subject_);
		//$data['sub_list']=array_filter($sub_list);
		
		$stream = $user->emp_college_type_;
		$department = $user->emp_dept_name_;
		//$data['stu_list']=$this->db->where('main_id',$user->emp_college_type_)->where('cour_id',$user->emp_dept_name_)->get('erp_existing_students')->result();
		
		$data['batch1']='';
		$data['subject1']='';
		$data['sem1']='';
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
		$get_sub = $this->db->where('id',$subject)->get('erp_subjectmaster')->row();
        if($get_sub->subCatg == 'Elective'){$this->db->join('erp_student_elective_subject','erp_student_elective_subject.e_admit_stu_id=erp_existing_students.id');
		$this->db->where('erp_student_elective_subject.e_subject',$subject);
		}
        if($get_sub->part==1 OR $get_sub->part==4){
			//$this->db->join('admitted_student','admitted_student.as_student_id=erp_existing_students.student_id');
			//$this->db->join('erp_langallot','erp_langallot.existing_student_id=admitted_student.as_id');
			$this->db->join('erp_langallot','erp_langallot.existing_student_id=erp_existing_students.id');
			$this->db->where('erp_langallot.subject_id',$subject);
			$this->db->where('erp_langallot.status',1);
			}	
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		//->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('erp_existing_students.cour_id',$get_sub->department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 OR erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		
		if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->subCode=='MS/20C/303A' OR $get_sub->subCode=='MS/20ID/305A')){
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=1 OR erp_existing_students.cour_id=2)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 OR erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		}
		
		if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->sem==1 OR $get_sub->sem==2)){
			$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=1 OR erp_existing_students.cour_id=2 OR erp_existing_students.cour_id=3)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 OR erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		}
		//print_r($this->db->last_query());exit;
		
		$data['sub_list']=$this->db->where('batch',$batch)->where('sem',$sem)->where('employee_id',$user_id)->get('erp_employee_subject')->result();
		}
    $this->load->view('template/nonteaching/header');
    $this->load->view('template/nonteaching/menubar');
    $this->load->view('template/nonteaching/headerbar');
    $this->load->view('nonteaching/student_attendance',$data);
    $this->load->view('template/nonteaching/footer');
    }
	
	public function getPgrm()
	{
	$dept=$this->input->post('dept');
	if($dept==1){
    $progrm = $this->db->where('college_type_','Aided')->get('erp_department')->result();	}
	else{
	$progrm = $this->db->where('college_type_','Self Finance')->get('erp_department')->result();	
	}
	$program = '<option value="">Select Program</option>';
	foreach($progrm as $progrm){
		$program .= '<option value="'.$progrm->id.'">'.$progrm->dept_name_.'</option>';
	}
	echo $program;
    }
	
	public function markAttendance1()
	{
	$add_date=date('Y-m-d H:i:s');
	$date=date('Y-m-d');
	$student_id=$this->input->post('student');
	$period=$this->input->post('period');
	$department=$this->input->post('dept');
	$user_id=$this->session->userdata['user']['user_id'];
	$sel_stu=$this->db->query('select * from erp_studentattendance where (1_period="1" or 2_period="1" or 3_period="1" or 4_period="1" or 5_period="1" or 6_period="1") and student_id='.$student_id.' and dept='.$department.' and DATE_FORMAT(created_at,"%Y-%m-%d")="'.$date.'" ')->row();
	$data=array(
	'student_id' => $student_id,
	'dept' => $department,
	''.$period.'_period' => 1,
	''.$period.'_created_by' => $user_id,
	'created_at' => $add_date,
	);
	if(isset($sel_stu)){
	$this->db->update('erp_studentattendance',$data);	
	}else{
    $this->db->insert('erp_studentattendance',$data);	
	}
	echo 'Success';
    }
	
	public function markAttendance()
	{
	$user_id=$this->session->userdata['user']['user_id'];
	$department=$this->db->where('id',$user_id)->get('erp_employee_master')->row();
	$date=str_replace('-','/',$this->input->post('date'));
	$add_date=date('Y-m-d',strtotime($date));
	$sem=$this->input->post('sem');
	$subject=$this->input->post('subject');
	$period=$this->input->post('period');
	$id_present=$this->input->post('id_present');
	$id_absent=$this->input->post('id_absent');
	$id_od=$this->input->post('id_od');
	if($id_present==''){$id_present=array();}
	if($id_absent==''){$id_absent=array();}
	if($id_od==''){$id_od=array();}
	$att1=implode(',',$id_present);
	$att2=implode(',',$id_absent);
	$attendance=$att1.','.$att2;
	$created_at=date('Y-m-d H:i:s');
	$get_sub=$this->db->where('id',$subject)->get('erp_subjectmaster')->row();
	
	$batch_year=$this->input->post('batch');
	$batch = $this->db->where('batch_from',$batch_year)->get('erp_batchmaster')->row();
	$batch_id = $batch->id;
	 
	$data=array(
	'dept' => $department->emp_dept_name_,
	'sem' => $sem,
	'subject' => $subject,
	'main_id' => $department->emp_college_type_,
	'course_id' => $department->emp_dept_name_,
	''.$period.'_period' => $attendance,
	''.$period.'_created_by' => $user_id,
	''.$period.'_created_at' => $add_date,
	);
	$getatt2=$this->db->where(''.$period.'_created_by',$user_id)->where('sem',$sem)->where('DATE_FORMAT('.$period.'_created_at,"%Y-%m-%d")',$add_date)->get('erp_studentattendance')->row();
	if(!isset($getatt2)){
    $this->db->insert('erp_studentattendance',$data);
	}else{
	$this->db->where(''.$period.'_created_by',$user_id);
    $this->db->where('sem',$sem);
    $this->db->where('DATE_FORMAT('.$period.'_created_at,"%Y-%m-%d")',$add_date);
    $this->db->update('erp_studentattendance',$data);  
	  }
	
	for($i=0; $i<sizeof($id_present); $i++){
		$att3=explode('-',$id_present[$i]);
	  $stu_id = $this->db->where('id',$att3[0])->get('erp_existing_students')->row();	
		$get_sub1=$this->db->where('subCode',$get_sub->subCode)->where('stream',$stu_id->main_id)->where('department',$stu_id->cour_id)->where('batch_year',$batch_year)->get('erp_subjectmaster')->row();
		$subject=$get_sub1->id;
	$data1=array(
	'batch_id' => $batch_id,
	'batch_year' => $batch_year,
	'sem' => $sem,
	'student_id' => $att3[0],
	'subject_id' => $subject,
	'main_id' => $stu_id->main_id,
	'course_id' => $stu_id->cour_id,
	'attndnce_status' => $att3[1],
	'period' => $period,
	'att_date' => $add_date,
	'user_id' => $user_id,
	'created_at' => $created_at,
	);
    $getatt=$this->db->where('batch_year',$batch_year)->where('period',$period)->where('sem',$sem)->where('student_id',$att3[0])->where('DATE_FORMAT(att_date,"%Y-%m-%d")',$add_date)->get('erp_stu_attendance')->row();
	  if(!isset($getatt)){
    $this->db->insert('erp_stu_attendance',$data1);
	  }else{
	$this->db->where('student_id',$att3[0]);
    $this->db->where('period',$period);
    $this->db->where('att_date',$add_date);
    $this->db->where('sem',$sem);
    $this->db->where('user_id',$user_id);
    $this->db->update('erp_stu_attendance',$data1);  
	  }
	}
	for($ii=0; $ii<sizeof($id_absent); $ii++){
		$att4=explode('-',$id_absent[$ii]);
	  $stu_id = $this->db->where('id',$att4[0])->get('erp_existing_students')->row();	
		$get_sub1=$this->db->where('subCode',$get_sub->subCode)->where('stream',$stu_id->main_id)->where('department',$stu_id->cour_id)->where('batch_year',$batch_year)->get('erp_subjectmaster')->row();
		$subject=$get_sub1->id;
	$data2=array(
	'batch_id' => $batch_id,
	'batch_year' => $batch_year,
	'sem' => $sem,
	'student_id' => $att4[0],
	'subject_id' => $subject,
	'main_id' => $stu_id->main_id,
	'course_id' => $stu_id->cour_id,
	'attndnce_status' => $att4[1],
	'period' => $period,
	'att_date' => $add_date,
	'user_id' => $user_id,
	'created_at' => $created_at,
	);
    $getatt1=$this->db->where('batch_year',$batch_year)->where('period',$period)->where('sem',$sem)->where('student_id',$att4[0])->where('DATE_FORMAT(att_date,"%Y-%m-%d")',$add_date)->get('erp_stu_attendance')->row();
	  if(!isset($getatt1)){
    $this->db->insert('erp_stu_attendance',$data2);
	  }else{
	$this->db->where('student_id',$att4[0]);
    $this->db->where('period',$period);
    $this->db->where('att_date',$add_date);
    $this->db->where('sem',$sem);
    $this->db->where('user_id',$user_id);
    $this->db->update('erp_stu_attendance',$data2);  
	  }
	}
	for($iii=0; $iii<sizeof($id_od); $iii++){
		$att5=explode('-',$id_od[$iii]);
	  $stu_id = $this->db->where('id',$att5[0])->get('erp_existing_students')->row();	
		$get_sub1=$this->db->where('subCode',$get_sub->subCode)->where('stream',$stu_id->main_id)->where('department',$stu_id->cour_id)->where('batch_year',$batch_year)->get('erp_subjectmaster')->row();
		$subject=$get_sub1->id;
	$data3=array(
	'batch_id' => $batch_id,
	'batch_year' => $batch_year,
	'sem' => $sem,
	'student_id' => $att5[0],
	'subject_id' => $subject,
	'main_id' => $stu_id->main_id,
	'course_id' => $stu_id->cour_id,
	'od_status' => $att5[1],
	'period' => $period,
	'att_date' => $add_date,
	'user_id' => $user_id,
	'created_at' => $created_at,
	);
    $getod=$this->db->where('batch_year',$batch_year)->where('period',$period)->where('sem',$sem)->where('student_id',$att4[0])->where('DATE_FORMAT(att_date,"%Y-%m-%d")',$add_date)->get('erp_stu_od')->row();
	  if(!isset($getod)){
    $this->db->insert('erp_stu_od',$data3);
	}else{
	$this->db->where('student_id',$att5[0]);
    $this->db->where('period',$period);
    $this->db->where('att_date',$add_date);
    $this->db->where('sem',$sem);
    $this->db->where('user_id',$user_id);
    $this->db->update('erp_stu_od',$data3);  
	  }
	}
	echo 'Success';
    }
	public function updateAttendance()
	{
	$user_id=$this->session->userdata['user']['user_id'];
	$department=$this->db->where('id',$user_id)->get('erp_employee_master')->row();
	$date=$this->input->post('date');
	//$date=str_replace('-','/',$this->input->post('date'));
	$add_date=date('Y-m-d',strtotime($date));
	$sem=$this->input->post('sem');
	$subject=$this->input->post('subject');
	$period=$this->input->post('period');
	$id_present=$this->input->post('id_present');
	$id_absent=$this->input->post('id_absent');
	$id_od=$this->input->post('id_od');
	if($id_present==''){$id_present=array();}
	if($id_absent==''){$id_absent=array();}
	if($id_od==''){$id_od=array();}
	$att1=implode(',',$id_present);
	$att2=implode(',',$id_absent);
	$attendance=$att1.','.$att2;
	$id=$this->input->post('id');
	$created_at=date('Y-m-d H:i:s');
	//$department=$this->db->where('id',$subject)->get('erp_subjectmaster')->row();
	
	$batch_year=$this->input->post('batch');
	$batch = $this->db->where('batch_from',$batch_year)->get('erp_batchmaster')->row();
	$batch_id = $batch->id;
	 
	$data=array(
	'dept' => $department->emp_dept_name_,
	'main_id' => $department->emp_college_type_,
	'course_id' => $department->emp_dept_name_,
	'subject' => $subject,
	'sem' => $sem,
	''.$period.'_period' => $attendance,
	''.$period.'_created_by' => $user_id,
	''.$period.'_created_at' => $add_date,
	);
	$this->db->where('id',$id);
    $this->db->update('erp_studentattendance',$data);
	
	
	for($ii=0; $ii<sizeof($id_absent); $ii++){
		$att4=explode('-',$id_absent[$ii]);
	$data2=array(
	'subject_id' => $subject,
	'attndnce_status' => $att4[1],
	);
    $this->db->where('student_id',$att4[0]);
    $this->db->where('period',$period);
    $this->db->where('att_date',$add_date);
    $this->db->where('user_id',$user_id);
    $this->db->update('erp_stu_attendance',$data2);
	}
	for($i=0; $i<sizeof($id_present); $i++){
		$att3=explode('-',$id_present[$i]);
	$data1=array(
	'subject_id' => $subject,
	'attndnce_status' => $att3[1],
	);
    $this->db->where('student_id',$att3[0]);
    $this->db->where('period',$period);
    $this->db->where('att_date',$add_date);
    $this->db->where('user_id',$user_id);
    $this->db->update('erp_stu_attendance',$data1);
	}
		
        $this->db->where('period',$period);
        $this->db->where('att_date',$add_date);
        $this->db->where('user_id',$user_id);
        $this->db->delete('erp_stu_od');
		
	for($iii=0; $iii<sizeof($id_od); $iii++){
		$att5=explode('-',$id_od[$iii]);
	  $stu_id = $this->db->where('id',$att5[0])->get('erp_existing_students')->row();
		
	$data3=array(
	'batch_id' => $batch_id,
	'batch_year' => $batch_year,
	'sem' => $sem,
	'student_id' => $att5[0],
	'subject_id' => $subject,
	'main_id' => $stu_id->main_id,
	'course_id' => $stu_id->cour_id,
	'od_status' => $att5[1],
	'period' => $period,
	'att_date' => $add_date,
	'user_id' => $user_id,
	'created_at' => $created_at,
	);
    $this->db->insert('erp_stu_od',$data3);
	}
	echo 'Success';
    }
	public function verifyAttendance()
	{
	$user_id=$this->session->userdata['user']['user_id'];
	//$department=$this->db->where('id',$user_id)->get('erp_employee_master')->row();
	$subject=$this->input->post('subject');
	$department=$this->db->where('id',$subject)->get('erp_subjectmaster')->row();
	$date=str_replace('-','/',$this->input->post('date'));
	$add_date=date('Y-m-d',strtotime($date));
	$period=$this->input->post('period');
	
	$det = $this->db->where('id',$user_id)->get('erp_employee_master')->row();
		$stream = $det->emp_college_type_;
		$department = $det->emp_dept_name_;
	
	$get_sub = $this->db->where('id',$subject)->get('erp_subjectmaster')->row();
    $part = $get_sub->part;
	$catg = $get_sub->subCatg;
	$batch = $get_sub->batch_year;
	$sem = $get_sub->sem;
	
	$getatt=$this->db->where('a.batch_year',$batch)->where('a.sem',$sem)->where('a.period',$period)->where('a.user_id',$user_id)->where('DATE_FORMAT(a.att_date,"%Y-%m-%d")',$add_date)->get('erp_stu_attendance a')->row();
	if(isset($getatt)){
	$value='Success';
	}else{
		$value=0;
	}
	echo $value;
    }
	
	public function leaves()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$data['user']=$user=$this->db->where('id',$user_id)->get('erp_employee_master')->row();
		$leave_arr = array('Sick Leave','Leave Without Pay');	
		$cas = $this->getLeave('Casual Leave',1);
		$ear = $this->getLeave('Earned Leave',1);
		$mat = $this->getLeave('Maternity Leave',3);
		$service = date('Y') - date('Y', strtotime($user->emp_doj_));
	    $desig = $user->emp_designation_;
		if($cas < 12){array_push($leave_arr,'Casual Leave');}
	    if($desig == 23){
		if($ear < 15){array_push($leave_arr,'Earned Leave');}
	    }else{
		if($ear < 30){array_push($leave_arr,'Earned Leave');}
	    }
	    if($mat < 2){array_push($leave_arr,'Maternity Leave');}
		$data['leave_arr']=$leave_arr;
    $leave_arr = array('Sick Leave','Leave Without Pay');
    $this->load->view('template/nonteaching/header');
    $this->load->view('template/nonteaching/menubar');
    $this->load->view('template/nonteaching/headerbar');
    $this->load->view('nonteaching/leaves',$data);
    $this->load->view('template/nonteaching/footer');
    }
	function getLeave($leave,$type){
		$user_id=$this->session->userdata('user')['user_id'];
		$where = '';
	if($type==1){$where = "AND DATE_FORMAT(`apply_date`, '%Y') = '" . date('Y') . "' ";}	
	/*if($type==2){
	 $stat = $this->db->where('emp_id',$user->id)->where('status',1)->order_by('id','desc')->limit(1)->get('wy_encash')->row();
     $encsh = isset($stat) ? date('m-Y',($stat->month)) :  date('m-Y',($user->emp_doj_));
	 $where = "AND DATE_FORMAT(`apply_date`, '%m-%Y') BETWEEN '".$encsh."' AND '" . date('m-Y') . "' ";
	 }*/
	$lea = $this->db->query("SELECT * FROM `wy_leaves` WHERE `emp_code` = ".$user_id." AND `leave_type` = '".$leave."' AND `leave_status_principal` = 'approve' ".$where." ")->result();	
	foreach($lea as $lea){
	$lea_n = explode(',',$lea->leave_dates);
	foreach($lea_n as $lea_n){
	$leav_n[] = 1;
	}
	}
	$lfp = isset($leav_n) ? array_sum($leav_n) : 0;
	
	$lea_taken = $this->db->query("SELECT * FROM `wy_leavecount` WHERE `emp_id` = ".$user_id." AND `type` = '".$leave."' ")->row();
	$lfp1 = isset($lea_taken) ? ($lea_taken->no_of_leave) : 0;
	
	return $lfp - $lfp1;
	}
	
	function LoadingMyLeaves() {
	$empData = $this->session->userdata('user')['user_id'];
	$requestData = $_REQUEST;
	$columns = array(
		0 => 'leave_id',
		1 => 'leave_subject',
		2 => 'leave_dates',
		3 => 'leave_message',
		4 => 'leave_type',
		5 => 'leave_status_principal'
	);

	$sql  = "SELECT `leave_id` ";
	$sql .= " FROM `wy_leaves` WHERE `emp_code` = '" . $empData . "'";
	$query = $this->db->query($sql);
	$totalData = $query->num_rows();
	$totalFiltered = $totalData;

	$sql  = "SELECT *";
	$sql .= " FROM `wy_leaves` WHERE `emp_code` = '" . $empData . "'";
	if ( !empty($requestData['search']['value']) ) {
		$sql .= " AND (`leave_id` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `leave_subject` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `leave_dates` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `leave_message` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `leave_type` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `leave_status_principal` LIKE '" . $requestData['search']['value'] . "%')";
	}
	$query = $this->db->query($sql);
	$totalFiltered = $query->num_rows();
	$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
	$query = $this->db->query($sql);

	$data = array();
	$i = 1 + $requestData['start'];
	$sno = 1;
	$row = $query->result_array();
	foreach ( $row as $row ) {
		$nestedData = array();
		//$nestedData[] = $row["leave_id"];
		$nestedData[] = $sno;
		$nestedData[] = $row["leave_subject"];
		$nestedData[] = $row["leave_dates"];
		$nestedData[] = $row["leave_message"];
		$nestedData[] = $row["leave_type"];
		if ( $row["leave_status"] == 'pending' ) {
			$nestedData[] = '<span class="label label-warning">' . ucwords($row["leave_status"]) . '</span>';
		} elseif ( $row['leave_status'] == 'approve' ) {
			$nestedData[] = '<span class="label label-success">' . ucwords($row["leave_status"]) . 'd</span>';
		} elseif ( $row['leave_status'] == 'reject' ) {
			$nestedData[] = '<span class="label label-danger">' . ucwords($row["leave_status"]) . 'ed</span>';
		}
		$data[] = $nestedData;
		$i++;
		$sno++;
	}
	$json_data = array(
		"draw"            => intval($requestData['draw']),
		"recordsTotal"    => intval($totalData),
		"recordsFiltered" => intval($totalFiltered),
		"data"            => $data
	);

	echo json_encode($json_data);
}
function ApplyLeaveToAdminApproval() {
	$result = array();
	global $db;

	//$adminData = GetAdminData(1);
	$empData   = $this->session->userdata('user')['user_id'];
	$desig   = $this->session->userdata('user')['user_designation'];

	$leave_subject = addslashes($_POST['leave_subject']);
	$leave_dates   = addslashes($_POST['leave_dates']);
	$leave_message = addslashes($_POST['leave_message']);
	$leave_type    = addslashes($_POST['leave_type']);
	if ( !empty($leave_subject) && !empty($leave_dates) && !empty($leave_message) && !empty($leave_type) ) {
		$AppliedDates = '';
		if ( strpos($leave_dates, ',') !== false ) {
			$dates = explode(',', $leave_dates);
			foreach ( $dates as $date ) {
				$checkLeaveSQL = $this->db->query("SELECT * FROM `wy_leaves` WHERE `leave_dates` LIKE '%$date%' AND `emp_code` = '" . $empData . "'");
				if ( $checkLeaveSQL ) {
					if ( $checkLeaveSQL->num_rows() > 0 ) {
						$AppliedDates .= $date . ', ';
					}
				}
			}
		}
		if ( empty($AppliedDates) ) {
			$leaveSQL = $this->db->query("INSERT INTO `wy_leaves` (`emp_code`,`emp_designation`, `leave_subject`, `leave_dates`, `leave_message`, `leave_type`, `apply_date`) VALUES('" . $empData . "','$desig', '$leave_subject', '$leave_dates', '$leave_message', '$leave_type', '" . date('Y-m-d H:i:s') . "')");
			if ( $leaveSQL ) {
					$result['code'] = 0;
					$result['result'] = 'Leave Application has been successfully sent to your employer.';
				} else {
					$result['code'] = 1;
					$result['result'] = 'Notice: Leave Application has not been sent, please try again.';
				}
			/*if ( $leaveSQL ) {
				$empName    = $empData['first_name'] . ' ' . $empData['last_name'];
				$empEmail   = $empData['email'];
				$adminEmail = $adminData['admin_email'];
				$subject 	= 'Leave Application: ' . $leave_subject;
				$message    = '<p>Employee: ' . $empName . ' (' . $empData['emp_code'] . ')' . '</p>';
				$message   .= '<p>Leave Message: ' . $leave_message . '</p>';
				$message   .= '<p>Leave Date(s): ' . $leave_dates . '</p>';
				$message   .= '<p>Leave Type: ' . $leave_type . '</p>';
				$message   .= '<hr/>';
				$message   .= '<p>Please click on the buttons below or log into the admin area to get an action:</p>';
				$message   .= '<form method="post" action="' . BASE_URL . 'ajax/?case=ApproveLeaveApplication&id=' . mysqli_insert_id() . '" style="display:inline;">';
				$message   .= '<input type="hidden" name="id" value="' . mysqli_insert_id() . '" />';
				$message   .= '<button type="submit" style="background:green; border:1px solid green; color:white; padding:0 5px 3px; cursor:pointer; margin-right:15px;">Approve</button>';
				$message   .= '</form>';
				$message   .= '<form method="post" action="' . BASE_URL . 'ajax/?case=RejectLeaveApplication&id=' . mysqli_insert_id() . '" style="display:inline;">';
				$message   .= '<input type="hidden" name="id" value="' . mysqli_insert_id() . '" />';
				$message   .= '<button type="submit" style="background:red; border:1px solid red; color:white; padding:0 5px 3px; cursor:pointer;">Reject</button>';
				$message   .= '</form>';
				$message   .= '<p style="font-size:85%;">After clicking the button, please click on OK and then Continue to make your action complete.</p>';
				$message   .= '<hr/>';
				$message   .= '<p>Thank You<br/>' . $empName . '</p>';
				$adminName 	= $adminData['admin_name'];
				$send = Send_Mail($subject, $message, $adminName, $adminEmail, $empName, $empEmail);
				if ( $send == 0 ) {
					$result['code'] = 0;
					$result['result'] = 'Leave Application has been successfully send to your employer through mail.';
				} else {
					$result['code'] = 1;
					$result['result'] = 'Notice: Leave Application not send through E-Mail, please try again.';
				}
			} else {
				$result['code'] = 1;
				$result['result'] = 'Something went wrong, please try again.';
			}*/
		} else {
			$alreadyDates = substr($AppliedDates, 0, -2);
			$result['code'] = 2;
			$result['result'] = 'You have already applied for leave on ' . $alreadyDates . '. Please change the leave dates.';
		}
	} else {
		$result['code'] = 3;
		$result['result'] = 'All fields are mandatory.';
	}

	echo json_encode($result);
}


	
	public function allocateSubject()
    {
        $data['role']=$this->db->get('erp_role_master')->result();
		
		$user_id=$this->session->userdata('user')['user_id']; 
	  $user=$this->db->where('id',$user_id)->get('erp_employee_master')->row();
	  $stream=$user->emp_college_type_;$department=$user->emp_dept_name_;
	  $data['teacher']=$teacher = $this->db->where('emp_college_type_',$stream)->where('emp_dept_name_',$department)->get('erp_employee_master')->result();
	  if($stream='AIDED'){$strm=1;}elseif($stream='SELF FINANCE'){$strm=2;}else{$strm='';}
      $data['subject3']=$this->db->where('dept_',$department)->where('shift_',$strm)->get('erp_subject')->result();
        $data['role1']='';
		$data['employee']='';
		$data['department']='';
		$data['stream']='';
		
		$data['emp_list']=$this->db->where('subject_!='.null.'')->where('emp_college_type_',$stream)->where('emp_dept_name_',$department)->where('emp_working_status_','working')->get('erp_employee_master')->result();
		
		if(isset($_POST['submit'])){
			//$data['role1']=$role=$this->input->post('role');
			$subject1=$this->input->post('subject');
			$data['subject1']=$subject=implode(',',$subject1);
			$data['employee']=$employee=$this->input->post('employee');
			/*$data['employee1']=$this->db->where('emp_designation_',$role)->where('emp_working_status_','working')->get('erp_employee_master')->result();	
			$stream=$data['stream']=$this->input->post('stream');	
	  $data['department']=$department=$this->input->post('department');	
	   if($stream==1){
       $data['department1'] = $this->db->where('college_type_','Aided')->get('erp_department')->result();	
	   $col_type='Aided';
	   }
	   else{
	   $data['department1'] = $this->db->where('college_type_','Self Finance')->get('erp_department')->result();	
	   $col_type='Self Finance';
	   }*/
	   
	   $data_ins = array(
	   'subject_' => $subject,
	   //'emp_dept_name_' => $department,
	   //'emp_college_type_' => $col_type,
	   );
	   $this->db->where('id',$employee);
	   $this->db->update('erp_employee_master',$data_ins);
	   redirect('nonteaching/allocateSubject','refresh');
		}
		
	$this->load->view('template/nonteaching/header');
    $this->load->view('template/nonteaching/menubar');
    $this->load->view('template/nonteaching/headerbar');
    $this->load->view('nonteaching/allocate_subject',$data);
    $this->load->view('template/nonteaching/footer');
    }
	public function allocateSubjectEdit()
    {
		if(isset($_POST['submit_edit'])){
			$id=$this->input->post('edit_id');
			$subject1=$this->input->post('subject_edit');
			$subject=implode(',',$subject1);
	   
	   $data_up = array(
	   'subject_' => $subject,
	   );
	   $this->db->where('id',$id);
	   $this->db->update('erp_employee_master',$data_up);
	   $data['mesg']=$this->session->set_flashdata('success','Edited Successfully!!');
	   redirect('nonteaching/allocateSubject','refresh');
		}
    }
	public function delete_employee_subject()
	{
		if($this->input->post('type')==2)
		{
			$employee_id=$this->input->post('id');
	   $data_del = array(
	   'subject_' => null,
	   //'emp_dept_name_' => null,
	   //'emp_college_type_' => '',
	   );		
	   $this->db->where('id',$employee_id);
	   $this->db->update('erp_employee_master',$data_del);
			echo "Deleted Successfully";
		} 
	}
	
	public function getEmp()
	{
	$role=$this->input->post('role');
	$emp = $this->db->where('emp_designation_',$role)->get('erp_employee_master')->result();	
	
	$employee = '<option value="">Select Employee</option>';
	foreach($emp as $emp){
		$employee .= '<option value="'.$emp->id.'">'.$emp->emp_name_.'</option>';
	}
	echo $employee;
    }
	
	public function getSubject()
	{
	$stream=$this->input->post('stream');
	$dept=$this->input->post('dept');
	$sub = $this->db->where('dept_',$dept)->where('shift_',$stream)->get('erp_subject')->result();	
	
	$subject = '<option value="">Select Subject</option>';
	foreach($sub as $sub){
		$subject .= '<option value="'.$sub->id.'">'.$sub->sub_name_.'</option>';
	}
	echo $subject;
    }
	
	public function getEmpSubject()
	{
	$user_id=$this->session->userdata('user')['user_id'];
	$batch=$this->input->post('batch');
	$sub = $this->db->where('batch',$batch)->where('employee_id',$user_id)->get('erp_employee_subject')->result();	
	
	$subject = '<option value="">Select Subject</option>';
	foreach($sub as $sub){
	$subj = $this->db->where('id',$sub->subject_id)->get('erp_subjectmaster')->row();	
		$subject .= '<option value="'.$subj->id.'">'.$subj->subName.'</option>';
	}
	echo $subject;
    }
	
	public function updateSubject()
	{
	$id=$this->input->post('id');
	$updateSubj=$this->db->where('id',$id)->get('erp_employee_master')->row();
	$getsub=explode(',',$updateSubj->subject_);
	
	$stream=$this->input->post('stream');
	$dept=$this->input->post('dept');
	$sub = $this->db->where('dept_',$dept)->where('shift_',$stream)->get('erp_subject')->result();	
	
	$subject .= '<option value="">Select Subject</option>';
	foreach($sub as $sub){
		if (in_array($sub->id, $getsub)){
		$sele='selected';}else{$sele='';}
		$subject .= '<option value="'.$sub->id.'" '.$sele.'>'.$sub->sub_name_.'</option>';
	}
	echo $subject;
    }
	
	public function holidays()
	{
		$data['user_id']=$this->session->userdata('user')['user_id'];
    $this->load->view('template/nonteaching/header');
    $this->load->view('template/nonteaching/menubar');
    $this->load->view('template/nonteaching/headerbar');
    $this->load->view('nonteaching/holidays',$data);
    $this->load->view('template/nonteaching/footer');
    }
	function LoadingHolidays() {
	$requestData = $_REQUEST;
	$columns = array(
		0 => 'holiday_id',
		1 => 'holiday_title',
		2 => 'holiday_desc',
		3 => 'holiday_date',
		4 => 'holiday_type',
	);

	$sql  = "SELECT `holiday_id` ";
	$sql .= " FROM `wy_holidays`";
	$query = $this->db->query($sql);
	$totalData = $query->num_rows();
	$totalFiltered = $totalData;

	$sql  = "SELECT *";
	$sql .= " FROM `wy_holidays` WHERE 1 = 1";
	if ( !empty($requestData['search']['value']) ) {
		$sql .= " AND (`holiday_id` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `holiday_title` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `holiday_desc` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `holiday_date` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `holiday_type` LIKE '" . $requestData['search']['value'] . "%')";
	}
	$query = $this->db->query($sql);
	$totalFiltered = $query->num_rows();
	$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
	$query = $this->db->query($sql);

	$data = array();
	$i = 1 + $requestData['start'];
	$row = $query->result_array();
	$sno=1;
	foreach ( $row as $row ) {
		$nestedData = array();
		$nestedData[] = $sno.'<input type="hidden" value="'.$row["holiday_id"].'">';
		$nestedData[] = $row["holiday_title"];
		$nestedData[] = $row["holiday_desc"];
		$nestedData[] = date('d-m-Y', strtotime($row["holiday_date"]));
		if ( $row["holiday_type"] == 'compulsory' ) {
			$nestedData[] = '<span class="label label-success">' . ucwords($row["holiday_type"]) . '</span>';
		} else {
			$nestedData[] = '<span class="label label-danger">' . ucwords($row["holiday_type"]) . '</span>';
		}
		$data[] = $nestedData;
		$i++;
		$sno++;
	}
	$json_data = array(
		"draw"            => intval($requestData['draw']),
		"recordsTotal"    => intval($totalData),
		"recordsFiltered" => intval($totalFiltered),
		"data"            => $data
	);

	echo json_encode($json_data);
}

public function salaries()
	{
		$data['user_id']=$this->session->userdata('user')['user_id'];
    $this->load->view('template/nonteaching/header');
    $this->load->view('template/nonteaching/menubar');
    $this->load->view('template/nonteaching/headerbar');
    $this->load->view('nonteaching/salaries',$data);
    $this->load->view('template/nonteaching/footer');
    }
function LoadingSalaries() {
	$requestData = $_REQUEST;
		$columns = array(
			0 => 'pay_month',
			1 => 'earning_total',
			2 => 'deduction_total',
			3 => 'net_salary'
		);
		$user=$this->session->userdata('user')['user_id'];
		$empData = $this->db->where('id',$user)->get('erp_employee_master')->row();
		$sql  = "SELECT * FROM `wy_salaries` WHERE `emp_code` = '" . $empData->id . "' GROUP BY `emp_code`, `pay_month` ";
		$query = $this->db->query($sql);
		$totalData = $query->num_rows();
		$totalFiltered = $totalData;

		$sql  = "SELECT `emp`.`employee_id_`, `emp`.`emp_name_`, `salary`.*";
		$sql .= " FROM `wy_salaries` AS `salary`, `erp_employee_master` AS `emp` WHERE `emp`.`id` = `salary`.`emp_code` AND `salary`.`emp_code` = '" . $empData->id . "'";
		if ( !empty($requestData['search']['value']) ) {
			$sql .= " AND (`salary`.`emp_code` LIKE '" . $requestData['search']['value'] . "%'";
			$sql .= " OR `emp`.`emp_name_` LIKE '" . $requestData['search']['value'] . "%'";
			$sql .= " OR `salary`.`pay_month` LIKE '" . $requestData['search']['value'] . "%'";
			$sql .= " OR `salary`.`earning_total` LIKE '" . $requestData['search']['value'] . "%'";
			$sql .= " OR `salary`.`deduction_total` LIKE '" . $requestData['search']['value'] . "%'";
			$sql .= " OR `salary`.`net_salary` LIKE '" . $requestData['search']['value'] . "%')";
		}
		$sql .= " GROUP BY `salary`.`emp_code`, `salary`.`pay_month`";

		$query = $this->db->query($sql);
		$totalFiltered = $query->num_rows();

		$data = array();
		$i = 1 + $requestData['start'];
		$row = $query->result_array();
		foreach ( $row as $row ) {
			$pay_month=explode(', ', $row['pay_month']);
			$nestedData = array();
			$nestedData[] = $row['pay_month'];
			$nestedData[] = number_format($row['earning_total'], 2, '.', ',');
			$nestedData[] = number_format($row['deduction_total'], 2, '.', ',');
			$nestedData[] = number_format($row['net_salary'], 2, '.', ',');
			$nestedData[] = '<form action="'.base_url().'payrolllogin/GeneratePaySlipnonteaching/'.$user.'/'.$pay_month[0].'/'.$pay_month[1].'" method="post"><button type="submit" class="btn btn-success btn-xs"><i class="fa fa-download"></i></button></form>';

			$data[] = $nestedData;
			$i++;
		}
	$json_data = array(
		"draw"            => intval($requestData['draw']),
		"recordsTotal"    => intval($totalData),
		"recordsFiltered" => intval($totalFiltered),
		"data"            => $data
	);

	echo json_encode($json_data);
}
public function studentExamMarks()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['sem1']='';
		
		$det = $this->db->where('id',$user_id)->get('erp_employee_master')->row();
		$stream = $det->emp_college_type_;
		$department = $det->emp_dept_name_;
		$data['stream']='';
		$data['department']='';
		//$data['subject']=$this->db->where('stream',$stream)->where('department',$department)->get('erp_subjectmaster')->result();
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
		$get_sub = $this->db->where('id',$subject)->get('erp_subjectmaster')->row();
		$data['stream']=$get_sub->stream;
		$data['department']=$get_sub->department;
        if($get_sub->subCatg == 'Elective'){$this->db->join('erp_student_elective_subject','erp_student_elective_subject.e_admit_stu_id=erp_existing_students.id');
		$this->db->where('erp_student_elective_subject.e_subject',$subject);
		}
        if($get_sub->part==1 OR $get_sub->part==4){
			//$this->db->join('admitted_student','admitted_student.as_student_id=erp_existing_students.student_id');
			//$this->db->join('erp_langallot','erp_langallot.existing_student_id=admitted_student.as_id');
			$this->db->join('erp_langallot','erp_langallot.existing_student_id=erp_existing_students.id');
			$this->db->where('erp_langallot.subject_id',$subject);
			$this->db->where('erp_langallot.status',1);
			}	
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		//->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('erp_existing_students.cour_id',$get_sub->department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 OR erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		
		if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->subCode=='MS/20C/303A' OR $get_sub->subCode=='MS/20ID/305A')){
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=1 OR erp_existing_students.cour_id=2)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 OR erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		}
		
		if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->sem==1 OR $get_sub->sem==2)){
			$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=1 OR erp_existing_students.cour_id=2 OR erp_existing_students.cour_id=3)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 OR erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		}
		
		$data['ica_closing']=$this->db->where('batch_year',$batch)->where('sem',$get_sub->sem)->get('erp_ica_marks_closing')->row();
		}
		
	$this->load->view('template/nonteaching/header');
    $this->load->view('template/nonteaching/menubar');
    $this->load->view('template/nonteaching/headerbar');
    $this->load->view('nonteaching/studentExamMarks',$data);
    $this->load->view('template/nonteaching/footer');	
	}
	public function ICA1Mark()
	{
	$ica1=$this->input->post('ica1');
	$icaval1=$this->input->post('icaval1');
	$main_id=$this->input->post('main_id');
	$course_id=$this->input->post('course_id');
	$subject_id=$this->input->post('subject_id');
	$ica1_not=$this->input->post('ica1_not');
	$batch=$this->input->post('batch');
	$sem=$this->input->post('sem');
	$user_id=$this->session->userdata('user')['user_id'];
	$add_date=date('Y-m-d H:i:s');
	$get_sub=$this->db->where('id',$subject_id)->get('erp_subjectmaster')->row();
	
	for($i=0; $i<sizeof($ica1); $i++){
		$data = array();
		$stu_id = $this->db->where('id',$ica1[$i])->get('erp_existing_students')->row();
	$get_sub1=$this->db->where('subCode',$get_sub->subCode)->where('stream',$stu_id->main_id)->where('department',$stu_id->cour_id)->where('batch_year',$batch)->get('erp_subjectmaster')->row();
		$subject_id=$get_sub1->id;
		$det = $this->db->where('batch',$batch)->where('sem',$sem)->where('student_id',$ica1[$i])->where('subject_id',$subject_id)->get('erp_exammark')->row();
	 if(!isset($det)){	
	$data['batch']=$batch;  
	$data['sem']=$sem; 
	$data['subject_id']=$subject_id;
	$data['student_id']=$ica1[$i];
	$data['ica1Mark']=$icaval1[$i];
	$data['main_id']=$stu_id->main_id;
	$data['course_id']=$stu_id->cour_id;
	$data['user_id']=$user_id;
	$data['created_at']=$add_date;
	$this->db->insert('erp_exammark',$data);
	 }else{	 
	$data['ica1Mark']=$icaval1[$i];	
	$data['user_id']=$user_id;	
	 $this->db->where('id',$det->id);	
	$this->db->update('erp_exammark',$data);
	 }
	}
	
	if(!empty($ica1_not))
	for($ii=0; $ii<sizeof($ica1_not); $ii++){
		$delete = $this->db->where('batch',$batch)->where('sem',$sem)->where('student_id',$ica1_not[$ii])->where('subject_id',$subject_id)->get('erp_exammark')->row();
	 if(isset($delete)){	
	 $data1['ica1Mark']=null;
	$this->db->where('id',$delete->id);	
	$this->db->update('erp_exammark',$data1);
	 }
	}
	echo 'Success';
    }
	public function ICA2Mark()
	{
	$ica2=$this->input->post('ica2');
	$icaval2=$this->input->post('icaval2');
	$main_id=$this->input->post('main_id');
	$course_id=$this->input->post('course_id');
	$subject_id=$this->input->post('subject_id');
	$ica2_not=$this->input->post('ica2_not');
	$batch=$this->input->post('batch');
	$sem=$this->input->post('sem');
	$user_id=$this->session->userdata('user')['user_id'];
	$add_date=date('Y-m-d H:i:s');
	$get_sub=$this->db->where('id',$subject_id)->get('erp_subjectmaster')->row();
	
	for($i=0; $i<sizeof($ica2); $i++){
		$data = array();
		$stu_id = $this->db->where('id',$ica2[$i])->get('erp_existing_students')->row();
	$get_sub1=$this->db->where('subCode',$get_sub->subCode)->where('stream',$stu_id->main_id)->where('department',$stu_id->cour_id)->where('batch_year',$batch)->get('erp_subjectmaster')->row();
		$subject_id=$get_sub1->id;
		$det = $this->db->where('batch',$batch)->where('sem',$sem)->where('student_id',$ica2[$i])->where('subject_id',$subject_id)->get('erp_exammark')->row();
	 if(!isset($det)){	
	$data['batch']=$batch;  
	$data['sem']=$sem; 
	$data['subject_id']=$subject_id; 
	$data['student_id']=$ica2[$i];
	$data['ica2Mark']=$icaval2[$i];
	$data['main_id']=$stu_id->main_id;
	$data['course_id']=$stu_id->cour_id;
	$data['user_id']=$user_id;
	$data['created_at']=$add_date;
	$this->db->insert('erp_exammark',$data);
	 }else{
	$data['ica2Mark']=$icaval2[$i];	
	$data['user_id']=$user_id;	
	 $this->db->where('id',$det->id);	
	$this->db->update('erp_exammark',$data);
	 }
	}
	
	if(!empty($ica2_not))
	for($ii=0; $ii<sizeof($ica2_not); $ii++){
		$delete = $this->db->where('batch',$batch)->where('sem',$sem)->where('student_id',$ica2_not[$ii])->where('subject_id',$subject_id)->get('erp_exammark')->row();
	 if(isset($delete)){	
	 $data1['ica2Mark']=null;
	$this->db->where('id',$delete->id);		
	$this->db->update('erp_exammark',$data1);
	 }
	}
	echo 'Success';
    }
	public function inClassMark()
	{
	$inclass=$this->input->post('inclass');
	$icval=$this->input->post('icval');
	$main_id=$this->input->post('main_id');
	$course_id=$this->input->post('course_id');
	$subject_id=$this->input->post('subject_id');
	$inclass_not=$this->input->post('inclass_not');
	$batch=$this->input->post('batch');
	$sem=$this->input->post('sem');
	$user_id=$this->session->userdata('user')['user_id'];
	$add_date=date('Y-m-d H:i:s');
	$get_sub=$this->db->where('id',$subject_id)->get('erp_subjectmaster')->row();
	
	for($i=0; $i<sizeof($inclass); $i++){
		$data = array();
		$stu_id = $this->db->where('id',$inclass[$i])->get('erp_existing_students')->row();
	$get_sub1=$this->db->where('subCode',$get_sub->subCode)->where('stream',$stu_id->main_id)->where('department',$stu_id->cour_id)->where('batch_year',$batch)->get('erp_subjectmaster')->row();
		$subject_id=$get_sub1->id;
		$det = $this->db->where('batch',$batch)->where('sem',$sem)->where('student_id',$inclass[$i])->where('subject_id',$subject_id)->get('erp_exammark')->row();
	 if(!isset($det)){	
	$data['batch']=$batch;  
	$data['sem']=$sem; 
	$data['subject_id']=$subject_id; 
	$data['student_id']=$inclass[$i];
	$data['inClassMark']=$icval[$i];
	$data['main_id']=$stu_id->main_id;
	$data['course_id']=$stu_id->cour_id;
	$data['user_id']=$user_id;
	$data['created_at']=$add_date;
	$this->db->insert('erp_exammark',$data);
	 }else{	 
	$data['inClassMark']=$icval[$i];	
	$data['user_id']=$user_id;	
	 $this->db->where('id',$det->id);		
	$this->db->update('erp_exammark',$data);
	 }
	}
	
	if(!empty($inclass_not))
	for($ii=0; $ii<sizeof($inclass_not); $ii++){
		$delete = $this->db->where('batch',$batch)->where('sem',$sem)->where('student_id',$inclass_not[$ii])->where('subject_id',$subject_id)->get('erp_exammark')->row();
	 if(isset($delete)){	
	 $data1['inClassMark']=null;
	$this->db->where('id',$delete->id);	
	$this->db->update('erp_exammark',$data1);
	 }
	}
	echo 'Success';
    }
	public function takeHomeMark()
	{
	$takehome=$this->input->post('takehome');
	$thval=$this->input->post('thval');
	$main_id=$this->input->post('main_id');
	$course_id=$this->input->post('course_id');
	$subject_id=$this->input->post('subject_id');
	$takehome_not=$this->input->post('takehome_not');
	$batch=$this->input->post('batch');
	$sem=$this->input->post('sem');
	$user_id=$this->session->userdata('user')['user_id'];
	$add_date=date('Y-m-d H:i:s');
	$get_sub=$this->db->where('id',$subject_id)->get('erp_subjectmaster')->row();
	
	for($i=0; $i<sizeof($takehome); $i++){
		$data = array();
		$stu_id = $this->db->where('id',$takehome[$i])->get('erp_existing_students')->row();
	$get_sub1=$this->db->where('subCode',$get_sub->subCode)->where('stream',$stu_id->main_id)->where('department',$stu_id->cour_id)->where('batch_year',$batch)->get('erp_subjectmaster')->row();
		$subject_id=$get_sub1->id;
		$det = $this->db->where('batch',$batch)->where('sem',$sem)->where('student_id',$takehome[$i])->where('subject_id',$subject_id)->get('erp_exammark')->row();
	 if(!isset($det)){	
	$data['batch']=$batch;  
	$data['sem']=$sem; 
	$data['subject_id']=$subject_id; 
	$data['student_id']=$takehome[$i];
	$data['takeHomeMark']=$thval[$i];
	$data['main_id']=$stu_id->main_id;
	$data['course_id']=$stu_id->cour_id;
	$data['user_id']=$user_id;
	$data['created_at']=$add_date;
	$this->db->insert('erp_exammark',$data);
	 }else{	 
	$data['takeHomeMark']=$thval[$i];	
	$data['user_id']=$user_id;	
	 $this->db->where('id',$det->id);		
	$this->db->update('erp_exammark',$data);
	 }
	}
	
	if(!empty($takehome_not))
	for($ii=0; $ii<sizeof($takehome_not); $ii++){
		$delete = $this->db->where('batch',$batch)->where('sem',$sem)->where('student_id',$takehome_not[$ii])->where('subject_id',$subject_id)->get('erp_exammark')->row();
	 if(isset($delete)){	
	 $data1['takeHomeMark']=null;
	$this->db->where('id',$delete->id);	
	$this->db->update('erp_exammark',$data1);
	 }
	}
	echo 'Success';
    }
	
	public function getSubj()
	{
	$stream=$this->input->post('stream');
	$department=$this->input->post('department');
	$batch=$this->input->post('batch');
	
    $subj = $this->db->where('batch_year',$batch)->where('stream',$stream)->where('department',$department)->get('erp_subjectmaster')->result();	
	
	$subject = '<option value="">Select Subject</option>';
	foreach($subj as $subj){
		$subject .= '<option value="'.$subj->id.'">'.$subj->subName.'</option>';
	}
	echo $subject;
    }
	
	public function getSubje()
	{
	$stream=$this->input->post('stream');
	$department=$this->input->post('department');
	$batch=$this->input->post('batch');
	$sem=$this->input->post('sem');
	
    $subj = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('stream',$stream)->where('department',$department)->get('erp_subjectmaster')->result();	
	
	$subject = '<option value="">Select Subject</option>';
	foreach($subj as $subj){
		$subject .= '<option value="'.$subj->id.'">'.$subj->subName.'</option>';
	}
	echo $subject;
    }
	
	public function getSubjec()
	{
	$user_id=$this->session->userdata('user')['user_id'];
	$batch=$this->input->post('batch');
	$sem=$this->input->post('sem');
	$sub = $this->db->where('batch',$batch)->where('sem',$sem)->where('employee_id',$user_id)->get('erp_employee_subject')->result();	
	
	$subject = '<option value="">Select Subject</option>';
	foreach($sub as $sub){
	$subj = $this->db->where('id',$sub->subject_id)->get('erp_subjectmaster')->row();	
		$subject .= '<option value="'.$subj->id.'">'.$subj->subName.'</option>';
	}
	echo $subject;
	}
	
	public function attendanceReport()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$user=$this->db->where('id',$user_id)->get('erp_employee_master')->row();
		//$sub_list=explode(',',$user->subject_);
		//$data['sub_list']=array_filter($sub_list);
		$data['sub_list']=array();
		
		$stream = $user->emp_college_type_;
		$department = $user->emp_dept_name_;
		
		$data['batch1']='';
		//$data['sem1']='';
		//$data['period1']='';
		$data['subject1']='';
		$data['date1']='';
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			//$data['sem1']=$sem = $this->input->post('sem');
			//$data['period1']=$period = $this->input->post('period');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['date1']=$date = $this->input->post('date');
		$get_sub = $this->db->where('id',$subject)->get('erp_subjectmaster')->row();
        if($get_sub->subCatg == 'Elective'){$this->db->join('erp_student_elective_subject','erp_student_elective_subject.e_admit_stu_id=erp_existing_students.id');
		$this->db->where('erp_student_elective_subject.e_subject',$subject);
		}
        if($get_sub->part==1 OR $get_sub->part==4){
			//$this->db->join('admitted_student','admitted_student.as_student_id=erp_existing_students.student_id');
			//$this->db->join('erp_langallot','erp_langallot.existing_student_id=admitted_student.as_id');
			$this->db->join('erp_langallot','erp_langallot.existing_student_id=erp_existing_students.id');
			$this->db->where('erp_langallot.subject_id',$subject);
			$this->db->where('erp_langallot.status',1);
			}	
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		//->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('erp_existing_students.cour_id',$get_sub->department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 OR erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		
		if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->subCode=='MS/20C/303A' OR $get_sub->subCode=='MS/20ID/305A')){
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=1 OR erp_existing_students.cour_id=2)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 OR erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		}
		
		if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->sem==1 OR $get_sub->sem==2)){
			$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=1 OR erp_existing_students.cour_id=2 OR erp_existing_students.cour_id=3)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 OR erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		}
		
		$data['sub_list']=$this->db->where('employee_id',$user_id)->where('batch',$batch)->get('erp_employee_subject')->result();
		}
    $this->load->view('template/nonteaching/header');
    $this->load->view('template/nonteaching/menubar');
    $this->load->view('template/nonteaching/headerbar');
    $this->load->view('nonteaching/attendance_report',$data);
    $this->load->view('template/nonteaching/footer');
    }
	
	public function attendanceReportMonthwise()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$user=$this->db->where('id',$user_id)->get('erp_employee_master')->row();
		//$sub_list=explode(',',$user->subject_);
		//$data['sub_list']=array_filter($sub_list);
		$data['sub_list']=array();
		
		$stream = $user->emp_college_type_;
		$department = $user->emp_dept_name_;
		
		$data['batch1']='';
		//$data['sem1']='';
		//$data['period1']='';
		$data['subject1']='';
		$data['month1']='';
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			//$data['sem1']=$sem = $this->input->post('sem');
			//$data['period1']=$period = $this->input->post('period');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['month1']=$month = $this->input->post('month');
		$get_sub = $this->db->where('id',$subject)->get('erp_subjectmaster')->row();
        if($get_sub->subCatg == 'Elective'){$this->db->join('erp_student_elective_subject','erp_student_elective_subject.e_admit_stu_id=erp_existing_students.id');
		$this->db->where('erp_student_elective_subject.e_subject',$subject);
		}
        if($get_sub->part==1 OR $get_sub->part==4){
			//$this->db->join('admitted_student','admitted_student.as_student_id=erp_existing_students.student_id');
			//$this->db->join('erp_langallot','erp_langallot.existing_student_id=admitted_student.as_id');
			$this->db->join('erp_langallot','erp_langallot.existing_student_id=erp_existing_students.id');
			$this->db->where('erp_langallot.subject_id',$subject);
			$this->db->where('erp_langallot.status',1);
			}	
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		//->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('erp_existing_students.cour_id',$get_sub->department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 OR erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		
		if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->subCode=='MS/20C/303A' OR $get_sub->subCode=='MS/20ID/305A')){
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=1 OR erp_existing_students.cour_id=2)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 OR erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		}
		
		if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->sem==1 OR $get_sub->sem==2)){
			$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=1 OR erp_existing_students.cour_id=2 OR erp_existing_students.cour_id=3)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 OR erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		}
		
		$data['sub_list']=$this->db->where('employee_id',$user_id)->where('batch',$batch)->get('erp_employee_subject')->result();
		}
    $this->load->view('template/nonteaching/header');
    $this->load->view('template/nonteaching/menubar');
    $this->load->view('template/nonteaching/headerbar');
    $this->load->view('nonteaching/attendance_report_monthwise',$data);
    $this->load->view('template/nonteaching/footer');
    }
	
	public function consolidatedReport()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$user=$this->db->where('id',$user_id)->get('erp_employee_master')->row();
		//$sub_list=explode(',',$user->subject_);
		//$data['sub_list']=array_filter($sub_list);
		$data['sub_list']=array();
		
		$stream = $user->emp_college_type_;
		$department = $user->emp_dept_name_;
		
		$data['batch1']='';
		$data['subject1']='';
		$data['from_date1']='';
		$data['to_date1']='';
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['to_date1']=$to_date = $this->input->post('to_date');
			$data['from_date1']=$from_date = $this->input->post('from_date');
		$get_sub = $this->db->where('id',$subject)->get('erp_subjectmaster')->row();
        if($get_sub->subCatg == 'Elective'){$this->db->join('erp_student_elective_subject','erp_student_elective_subject.e_admit_stu_id=erp_existing_students.id');
		$this->db->where('erp_student_elective_subject.e_subject',$subject);
		}
        if($get_sub->part==1 OR $get_sub->part==4){
			//$this->db->join('admitted_student','admitted_student.as_student_id=erp_existing_students.student_id');
			//$this->db->join('erp_langallot','erp_langallot.existing_student_id=admitted_student.as_id');
			$this->db->join('erp_langallot','erp_langallot.existing_student_id=erp_existing_students.id');
			$this->db->where('erp_langallot.subject_id',$subject);
			$this->db->where('erp_langallot.status',1);
			}
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		//->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('erp_existing_students.cour_id',$get_sub->department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 OR erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		
		if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->subCode=='MS/20C/303A' OR $get_sub->subCode=='MS/20ID/305A')){
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=1 OR erp_existing_students.cour_id=2)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 OR erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		}
		
		if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->sem==1 OR $get_sub->sem==2)){
			$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=1 OR erp_existing_students.cour_id=2 OR erp_existing_students.cour_id=3)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 OR erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		}
		
		$data['sub_list']=$this->db->where('employee_id',$user_id)->where('batch',$batch)->get('erp_employee_subject')->result();
		}
    $this->load->view('template/nonteaching/header');
    $this->load->view('template/nonteaching/menubar');
    $this->load->view('template/nonteaching/headerbar');
    $this->load->view('nonteaching/consolidated_report',$data);
    $this->load->view('template/nonteaching/footer');
    }
	
	public function icaReport()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['sem1']='';
		
		$det = $this->db->where('id',$user_id)->get('erp_employee_master')->row();
		$data['stream']=$stream = $det->emp_college_type_;
		$data['department']=$department = $det->emp_dept_name_;
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
$get_sub = $this->db->where('id',$subject)->get('erp_subjectmaster')->row();
        if($get_sub->subCatg == 'Elective'){$this->db->join('erp_student_elective_subject','erp_student_elective_subject.e_admit_stu_id=erp_existing_students.id');
		$this->db->where('erp_student_elective_subject.e_subject',$subject);
		}
        if($get_sub->part==1 OR $get_sub->part==4){
			//$this->db->join('admitted_student','admitted_student.as_student_id=erp_existing_students.student_id');
			//$this->db->join('erp_langallot','erp_langallot.existing_student_id=admitted_student.as_id');
			$this->db->join('erp_langallot','erp_langallot.existing_student_id=erp_existing_students.id');
			$this->db->where('erp_langallot.subject_id',$subject);
			$this->db->where('erp_langallot.status',1);
			}
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		//->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('erp_existing_students.cour_id',$get_sub->department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 OR erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		
		if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->subCode=='MS/20C/303A' OR $get_sub->subCode=='MS/20ID/305A')){
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=1 OR erp_existing_students.cour_id=2)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 OR erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		}
		
		if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->sem==1 OR $get_sub->sem==2)){
			$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=1 OR erp_existing_students.cour_id=2 OR erp_existing_students.cour_id=3)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 OR erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		}
		}
		
	$this->load->view('template/nonteaching/header');
    $this->load->view('template/nonteaching/menubar');
    $this->load->view('template/nonteaching/headerbar');
    $this->load->view('nonteaching/icaReport',$data);
    $this->load->view('template/nonteaching/footer');	
	}
	
	public function icaReportPDF()
	{
		$this->load->library("pdf");
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$det = $this->db->where('id',$user_id)->get('erp_employee_master')->row();
		$data['stream']=$stream = $det->emp_college_type_;
		$data['department']=$department = $det->emp_dept_name_;
		$data['batch'] = $batch = $this->input->post('batch');
		$data['sem'] = $sem = $this->input->post('sem');
		$data['subject'] = $subject = $this->input->post('subject');
		$subj = $this->db->where('id',$subject)->get('erp_subjectmaster')->row(); 
		
		$get_sub = $this->db->where('id',$subject)->get('erp_subjectmaster')->row();
        if($get_sub->subCatg == 'Elective'){$this->db->join('erp_student_elective_subject','erp_student_elective_subject.e_admit_stu_id=erp_existing_students.id');
		$this->db->where('erp_student_elective_subject.e_subject',$subject);
		}
        if($get_sub->part==1 OR $get_sub->part==4){
			//$this->db->join('admitted_student','admitted_student.as_student_id=erp_existing_students.student_id');
			//$this->db->join('erp_langallot','erp_langallot.existing_student_id=admitted_student.as_id');
			$this->db->join('erp_langallot','erp_langallot.existing_student_id=erp_existing_students.id');
			$this->db->where('erp_langallot.subject_id',$subject);
			$this->db->where('erp_langallot.status',1);
			}
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		//->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('erp_existing_students.cour_id',$get_sub->department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 OR erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		
		if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->subCode=='MS/20C/303A' OR $get_sub->subCode=='MS/20ID/305A')){
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=1 OR erp_existing_students.cour_id=2)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 OR erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		}
		
		if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->sem==1 OR $get_sub->sem==2)){
			$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=1 OR erp_existing_students.cour_id=2 OR erp_existing_students.cour_id=3)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 OR erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		}
		
            $html = $this->load->view("nonteaching/icaReportPDF", $data, true);
            //$this->pdf->createPDF($html, 'mypdf', false);
            // Get output html

            $options = new Options();
            $options->set("isRemoteEnabled", true);
            ob_start();
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
            $dompdf->stream("ICAMARKSHEET_".$subj->subCode."_".$batch.".pdf", ["Attachment" => 1]);
		
    //$this->load->view('nonteaching/icaReportPDF',$data);
	}
	
	public function deleteAttendance()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
	$this->load->view('template/nonteaching/header');
    $this->load->view('template/nonteaching/menubar');
    $this->load->view('template/nonteaching/headerbar');
    $this->load->view('nonteaching/delete_attendance',$data);
    $this->load->view('template/nonteaching/footer');	
	}
	
	public function delAttendance(){
		$user_id=$this->session->userdata('user')['user_id'];
		$subject=$this->input->post('subject');
	//$department=$this->db->where('id',$subject)->get('erp_subjectmaster')->row();
	$det = $this->db->where('id',$user_id)->get('erp_employee_master')->row();
		$stream = $det->emp_college_type_;
		$department = $det->emp_dept_name_;
	$date=str_replace('-','/',$this->input->post('date'));
	$add_date=date('Y-m-d',strtotime($date));
	$period=$this->input->post('period');
	$data_up = array(
	''.$period.'_period' => null,
	''.$period.'_created_by' => null,
	''.$period.'_created_at' => null,
	);
		$delatt=$this->db->where(''.$period.'_created_by',$user_id)->where('DATE_FORMAT('.$period.'_created_at,"%Y-%m-%d")',$add_date)->update('erp_studentattendance',$data_up);
		$delatt1=$this->db->where('period',$period)->where('user_id',$user_id)->where('DATE_FORMAT(att_date,"%Y-%m-%d")',$add_date)->delete('erp_stu_attendance');
	}
	
	public function partvMarks()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['sem1']='';
		
		$det = $this->db->where('id',$user_id)->get('erp_employee_master')->row();
		$stream = $det->emp_college_type_;
		$department = $det->emp_dept_name_;
		$data['stream']='';
		$data['department']='';
		//$data['subject']=$this->db->select('s.id,s.subName')->join('erp_subjectmaster s','s.id=e.subject_id')->where('e.employee_id',$user_id)->where('s.part',5)->get('erp_employee_subject e')->result();
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
		$get_sub = $this->db->where('id',$subject)->get('erp_subjectmaster')->row();
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		//->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('erp_existing_students.cour_id',$get_sub->department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 OR erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		
		$data['subject']=$this->db->select('s.id,s.subName')->join('erp_subjectmaster s','s.id=e.subject_id')->where('s.batch_year',$batch)->where('s.sem',$sem)->where('e.employee_id',$user_id)->where('s.part',5)->get('erp_employee_subject e')->result();
		}
		
	$this->load->view('template/nonteaching/header');
    $this->load->view('template/nonteaching/menubar');
    $this->load->view('template/nonteaching/headerbar');
    $this->load->view('nonteaching/partvMarks',$data);
    $this->load->view('template/nonteaching/footer');	
	}
	public function partvReport()
	{
	$ica1=$this->input->post('ica1');
	$main_id=$this->input->post('main_id');
	$course_id=$this->input->post('course_id');
	$subject_id=$this->input->post('subject_id');
	$ica1_not=$this->input->post('ica1_not');
	$batch=$this->input->post('batch');
	$sem=$this->input->post('sem');
	$user_id=$this->session->userdata('user')['user_id'];
	$add_date=date('Y-m-d H:i:s');
	
	for($i=0; $i<sizeof($ica1); $i++){
		$data = array();
		$det = $this->db->where('batch',$batch)->where('sem',$sem)->where('student_id',$ica1[$i])->where('subject_id',$subject_id)->get('erp_partvmark')->row();
		$stu_id = $this->db->where('id',$ica1[$i])->get('erp_existing_students')->row();
	 if(!isset($det)){	
	$data['batch']=$batch;  
	$data['sem']=$sem; 
	$data['subject_id']=$subject_id;
	$data['student_id']=$ica1[$i];
	$data['status']=1;
	$data['main_id']=$stu_id->main_id;
	$data['course_id']=$stu_id->cour_id;
	$data['user_id']=$user_id;
	$data['created_at']=$add_date;
	$this->db->insert('erp_partvmark',$data);
	 }else{	 
	$data['status']=1;	
	 $this->db->where('id',$det->id);	
	$this->db->update('erp_partvmark',$data);
	 }
	}
	
	for($ii=0; $ii<sizeof($ica1_not); $ii++){
		$data1 = array();
		$delete = $this->db->where('batch',$batch)->where('sem',$sem)->where('student_id',$ica1_not[$ii])->where('subject_id',$subject_id)->get('erp_partvmark')->row();
	 if(isset($delete)){	
	 $data1['status']=0;
	$this->db->where('id',$delete->id);	
	$this->db->update('erp_partvmark',$data1);
	 }else{
	  $data1['batch']=$batch;  
	$data1['sem']=$sem; 
	$data1['subject_id']=$subject_id;
	$data1['student_id']=$ica1_not[$ii];
	$data1['status']=0;
	$data1['main_id']=$stu_id->main_id;
	$data1['course_id']=$stu_id->cour_id;
	$data1['user_id']=$user_id;
	$data1['created_at']=$add_date;
	$this->db->insert('erp_partvmark',$data1);	 
	 }
	}
	echo 'Success';
    }
	public function partvMarksReport()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['sem1']='';
		
		$det = $this->db->where('id',$user_id)->get('erp_employee_master')->row();
		$data['stream']=$stream = $det->emp_college_type_;
		$data['department']=$department = $det->emp_dept_name_;
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
		$get_sub = $this->db->where('id',$subject)->get('erp_subjectmaster')->row();
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('erp_existing_students.cour_id',$get_sub->department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 OR erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		
		$data['subject']=$this->db->select('s.id,s.subName')->join('erp_subjectmaster s','s.id=e.subject_id')->where('s.batch_year',$batch)->where('s.sem',$sem)->where('e.employee_id',$user_id)->where('s.part',5)->get('erp_employee_subject e')->result();
		}
		
	$this->load->view('template/nonteaching/header');
    $this->load->view('template/nonteaching/menubar');
    $this->load->view('template/nonteaching/headerbar');
    $this->load->view('nonteaching/partvMarksReport',$data);
    $this->load->view('template/nonteaching/footer');	
	}
	
	public function getSubjecPartv()
	{
	$user_id=$this->session->userdata('user')['user_id'];
	$batch=$this->input->post('batch');
	$sem=$this->input->post('sem');
	$sub = $this->db->select('s.id,s.subName')->join('erp_subjectmaster s','s.id=e.subject_id')->where('s.batch_year',$batch)->where('s.sem',$sem)->where('e.employee_id',$user_id)->where('s.part',5)->get('erp_employee_subject e')->result();	
	
	$subject = '<option value="">Select Subject</option>';
	foreach($sub as $sub){
		$subject .= '<option value="'.$sub->id.'">'.$sub->subName.'</option>';
	}
	echo $subject;
	}
	
	public function iqac()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['from_date1']='';
	    $data['to_date1']='';
			
		if(isset($_POST['submit'])){
			$data['from_date1']=$from_date=$this->input->post('from_date');
			$data['to_date1']=$to_date=$this->input->post('to_date');
			$from = date('Y-m-d',strtotime($from_date));
			$to = date('Y-m-d',strtotime($to_date));
		$data['iqac_list']=$this->db->where('(event_date >= "'.$from.'" AND event_date <= "'.$to.'")')->where('employee_id',$user_id)->get('iqac')->result();
		}
	$this->load->view('template/nonteaching/header');
    $this->load->view('template/nonteaching/menubar');
    $this->load->view('template/nonteaching/headerbar');
    $this->load->view('nonteaching/iqac',$data);
    $this->load->view('template/nonteaching/footer');
	}
	public function do_upload_iqac(){

    	$config = array();
		$config['upload_path'] = './system/images/iqac/';
		$config['allowed_types'] = '*';
		$config['remove_spaces'] = TRUE;
		$config['overwrite'] = TRUE;
		return $config;
		
        }
	public function iqacForm()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$det = $this->db->where('id',$user_id)->get('erp_employee_master')->row();
		$stream = $det->emp_college_type_;
		$department = $det->emp_dept_name_;
		 
	if(isset($_POST['upload'])){
		
		$funded_by = $this->input->post('funded_by');
		$funded_by_other='';
		if(isset($funded_by)){
		if($funded_by=='Others'){$funded_by_other=$this->input->post('funded_by_other');}}else{$funded_by='';}
		
		$event_venue = $this->input->post('event_venue');
		$event_venue_other='';
		if(isset($event_venue)){
		if($event_venue=='Others'){$event_venue_other=$this->input->post('event_venue_other');}}else{$event_venue='';}
		
		$consulted = $this->input->post('consulted');
		if(isset($consulted)){$consulted=implode(',',$this->input->post('consulted'));}else{$consulted='';}
		
			$data_in = array(
			'employee_id' => $user_id,
			'stream' => $stream,
			'department' => $department,
			'activities' => $this->input->post('activities'),
			'event_name' => $this->input->post('event_name'),
			'funded_by' => $funded_by,
			'funded_by_other' => $funded_by_other,
			'event_nature' => $this->input->post('event_nature'),
			'event_date' => date('Y-m-d',strtotime($this->input->post('event_date'))),
			'event_time' => $this->input->post('event_time'),
			'event_venue' => $event_venue,
			'event_venue_other' => $event_venue_other,
			//'event_invitation' => $this->input->post('event_invitation'),
			'resource_name' => $this->input->post('resource_name'),
			'resource_desig' => $this->input->post('resource_desig'),
			'resource_org' => $this->input->post('resource_org'),
			'dept_seed' => $this->input->post('dept_seed'),
			'faculty_seed' => $this->input->post('faculty_seed'),
			'head_name' => $this->input->post('head_name'),
			'secretary_name' => $this->input->post('secretary_name'),
			'staff_name' => $this->input->post('staff_name'),
			'consulted' => $consulted,
			'informed_iqac' => $this->input->post('informed_iqac'),
			'fac_sanctioned' => $this->input->post('fac_sanctioned'),
			'fac_appointed' => $this->input->post('fac_appointed'),
			//'app_letter' => $this->input->post('app_letter'),
			'fac_name' => $this->input->post('fac_name'),
			'fac_experience' => $this->input->post('fac_experience'),
			'fac_designation' => $this->input->post('fac_designation'),
			'guests' => $this->input->post('guests'),
			'fac_phd_no' => $this->input->post('fac_phd_no'),
			'fac_mphil_no' => $this->input->post('fac_mphil_no'),
			'resource_no' => $this->input->post('resource_no'),
			'final_stu_appeared' => $this->input->post('final_stu_appeared'),
			'final_stu_passed' => $this->input->post('final_stu_passed'),
			'stu_placed_no' => $this->input->post('stu_placed_no'),
			'higher_studies_no' => $this->input->post('higher_studies_no'),
			'mentor_ratio' => $this->input->post('mentor_ratio'),
			'created_at' => $add_date,
			);
			
			if($_FILES['invitation']['size'] != 0) {
			$file_ext = pathinfo($_FILES["invitation"]["name"], PATHINFO_EXTENSION);
			$NewImageName = $user_id.'_'.rand().'_Invitation.'.$file_ext;
			
			$_FILES["file"]["name"] = $NewImageName;
			$_FILES["file"]["type"] = $_FILES["invitation"]["type"];
			$_FILES["file"]["tmp_name"] = $_FILES["invitation"]["tmp_name"];
			$_FILES["file"]["error"] = $_FILES["invitation"]["error"];
			$_FILES["file"]["size"] = $_FILES["invitation"]["size"];

			$config = $this->do_upload_iqac();
			$this->upload->initialize($config);
			if($this->upload->do_upload('file'))
			{
			 $ffff = $this->upload->data();
			  $image=$ffff['file_name'];
			  
			  $data_in['event_invitation'] = 'system/images/iqac/'.$NewImageName;
			  }
	 }
	 
	 if($_FILES['letter']['size'] != 0) {
			$file_ext = pathinfo($_FILES["letter"]["name"], PATHINFO_EXTENSION);
			$NewImageName = $user_id.'_'.rand().'_Letter.'.$file_ext;
			
			$_FILES["file"]["name"] = $NewImageName;
			$_FILES["file"]["type"] = $_FILES["letter"]["type"];
			$_FILES["file"]["tmp_name"] = $_FILES["letter"]["tmp_name"];
			$_FILES["file"]["error"] = $_FILES["letter"]["error"];
			$_FILES["file"]["size"] = $_FILES["letter"]["size"];

			$config = $this->do_upload_iqac();
			$this->upload->initialize($config);
			if($this->upload->do_upload('file'))
			{
			 $ffff = $this->upload->data();
			  $image=$ffff['file_name'];
			  
			  $data_in['app_letter'] = 'system/images/iqac/'.$NewImageName;
			  }
	 }
			$this->db->insert('iqac',$data_in);
			$insert_id=$this->db->insert_id();
			
		$data_ins = array(
			'employee_id' => $user_id,
			'stream' => $stream,
			'department' => $department,
			'iqac_id' => $insert_id,
			'created_at' => $add_date,
			);
			
			//Upload GPS Photos
		$i = 0 ;   
    foreach ($_FILES['photos']['name'] as $file){	
	$data_in1=array();
	if($_FILES['photos']['size'][$i] != 0) {
			$file_ext = pathinfo($_FILES["photos"]["name"][$i], PATHINFO_EXTENSION);
			$NewImageName = $user_id.'_'.rand().'_Image.'.$file_ext;
			
			$_FILES["file"]["name"] = $NewImageName;
			$_FILES["file"]["type"] = $_FILES["photos"]["type"][$i];
			$_FILES["file"]["tmp_name"] = $_FILES["photos"]["tmp_name"][$i];
			$_FILES["file"]["error"] = $_FILES["photos"]["error"][$i];
			$_FILES["file"]["size"] = $_FILES["photos"]["size"][$i];

			$config = $this->do_upload_iqac();
			$this->upload->initialize($config);
			if($this->upload->do_upload('file'))
			{
			 $ffff = $this->upload->data();
			  $image=$ffff['file_name'];
			  
			  $data_in1['type'] = 'photos';
			  $data_in1['path'] = 'system/images/iqac/'.$NewImageName;
			  }
			  $data_in1 = $data_in1 + $data_ins;
			  $this->db->insert('iqac_docs',$data_in1);
	 }
	 $i++;
	}
	
	//Upload Reports
	$r = 0 ;   
    foreach ($_FILES['reports']['name'] as $file){		
	$data_in2=array();
	if($_FILES['reports']['size'][$r] != 0) {
			$file_ext = pathinfo($_FILES["reports"]["name"][$r], PATHINFO_EXTENSION);
			$NewImageName = $user_id.'_'.rand().'_Report.'.$file_ext;
			
			$_FILES["file"]["name"] = $NewImageName;
			$_FILES["file"]["type"] = $_FILES["reports"]["type"][$r];
			$_FILES["file"]["tmp_name"] = $_FILES["reports"]["tmp_name"][$r];
			$_FILES["file"]["error"] = $_FILES["reports"]["error"][$r];
			$_FILES["file"]["size"] = $_FILES["reports"]["size"][$r];

			$config = $this->do_upload_iqac();
			$this->upload->initialize($config);
			if($this->upload->do_upload('file'))
			{
			 $ffff = $this->upload->data();
			  $image=$ffff['file_name'];
			  
			  $data_in2['type'] = 'reports';
			  $data_in2['path'] = 'system/images/iqac/'.$NewImageName;
			  }
			  $data_in2 = $data_in2 + $data_ins;
			  $this->db->insert('iqac_docs',$data_in2);
	 }
	 $r++;
	}
	
	//Upload Videos
	$v = 0 ;   
    foreach ($_FILES['videos']['name'] as $file){		
	$data_in3=array();
	if($_FILES['videos']['size'][$v] != 0) {
			$file_ext = pathinfo($_FILES["videos"]["name"][$v], PATHINFO_EXTENSION);
			$NewImageName = $user_id.'_'.rand().'_Video.'.$file_ext;
			
			$_FILES["file"]["name"] = $NewImageName;
			$_FILES["file"]["type"] = $_FILES["videos"]["type"][$v];
			$_FILES["file"]["tmp_name"] = $_FILES["videos"]["tmp_name"][$v];
			$_FILES["file"]["error"] = $_FILES["videos"]["error"][$v];
			$_FILES["file"]["size"] = $_FILES["videos"]["size"][$v];

			$config = $this->do_upload_iqac();
			$this->upload->initialize($config);
			if($this->upload->do_upload('file'))
			{
			 $ffff = $this->upload->data();
			  $image=$ffff['file_name'];
			  
			  $data_in3['type'] = 'videos';
			  $data_in3['path'] = 'system/images/iqac/'.$NewImageName;
			  }
			  $data_in3 = $data_in3 + $data_ins;
			  $this->db->insert('iqac_docs',$data_in3);
	 }
	 $v++;
	}
	
	//Upload Documents
	$d = 0 ;   
    foreach ($_FILES['docs']['name'] as $file){		
	$data_in4=array();
	if($_FILES['docs']['size'][$d] != 0) {
			$file_ext = pathinfo($_FILES["docs"]["name"][$d], PATHINFO_EXTENSION);
			$NewImageName = $user_id.'_'.rand().'_Doc.'.$file_ext;
			
			$_FILES["file"]["name"] = $NewImageName;
			$_FILES["file"]["type"] = $_FILES["docs"]["type"][$d];
			$_FILES["file"]["tmp_name"] = $_FILES["docs"]["tmp_name"][$d];
			$_FILES["file"]["error"] = $_FILES["docs"]["error"][$d];
			$_FILES["file"]["size"] = $_FILES["docs"]["size"][$d];

			$config = $this->do_upload_iqac();
			$this->upload->initialize($config);
			if($this->upload->do_upload('file'))
			{
			 $ffff = $this->upload->data();
			  $image=$ffff['file_name'];
			  
			  $data_in4['type'] = 'docs';
			  $data_in4['path'] = 'system/images/iqac/'.$NewImageName;
			  }
			  $data_in4 = $data_in4 + $data_ins;
			  $this->db->insert('iqac_docs',$data_in4);
	 }
	 $d++;
	}
	$data['msg']=$this->session->set_flashdata('success','Uploaded Successfully','success');
	redirect('nonteaching/iqacForm','refresh');
		 }
		 
	$this->load->view('template/nonteaching/header');
    $this->load->view('template/nonteaching/menubar');
    $this->load->view('template/nonteaching/headerbar');
    $this->load->view('nonteaching/iqacForm',$data);
    $this->load->view('template/nonteaching/footer');
	}	
	public function iqacDelete()
	{
		$id=$this->input->post('id');
		$this->db->where('id',$id)->delete('iqac');
		$delete = $this->db->where('iqac_id',$id)->get('iqac_docs')->result();
		foreach($delete as $delete){
		unlink($delete->path);
		}
		$this->db->where('iqac_id',$id)->delete('iqac_docs');
		echo 'Success';
	}
	public function iqacUpdateDoc()
	{
		$id=$this->input->post('id');
		$delete = $this->db->where('id',$id)->get('iqac_docs')->row();
		unlink($delete->path);
		$this->db->where('id',$id)->delete('iqac_docs');
		echo 'Success';
	}
	public function iqacFormEdit()
	{
		$id = $this->uri->segment(3);
		
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$det = $this->db->where('id',$user_id)->get('erp_employee_master')->row();
		$stream = $det->emp_college_type_;
		$department = $det->emp_dept_name_;
		
		$data['iqac']=$this->db->where('id',$id)->get('iqac')->row();
		 
	if(isset($_POST['upload'])){
		
		$funded_by = $this->input->post('funded_by');
		$funded_by_other='';
		if(isset($funded_by)){
		if($funded_by=='Others'){$funded_by_other=$this->input->post('funded_by_other');}}else{$funded_by='';}
		
		$event_venue = $this->input->post('event_venue');
		$event_venue_other='';
		if(isset($event_venue)){
		if($event_venue=='Others'){$event_venue_other=$this->input->post('event_venue_other');}}else{$event_venue='';}
		
		$consulted = $this->input->post('consulted');
		if(isset($consulted)){$consulted=implode(',',$this->input->post('consulted'));}else{$consulted='';}
			
			$data_in = array(
			'activities' => $this->input->post('activities'),
			'event_name' => $this->input->post('event_name'),
			'funded_by' => $funded_by,
			'funded_by_other' => $funded_by_other,
			'event_nature' => $this->input->post('event_nature'),
			'event_date' => date('Y-m-d',strtotime($this->input->post('event_date'))),
			'event_time' => $this->input->post('event_time'),
			'event_venue' => $event_venue,
			'event_venue_other' => $event_venue_other,
			//'event_invitation' => $this->input->post('event_invitation'),
			'resource_name' => $this->input->post('resource_name'),
			'resource_desig' => $this->input->post('resource_desig'),
			'resource_org' => $this->input->post('resource_org'),
			'dept_seed' => $this->input->post('dept_seed'),
			'faculty_seed' => $this->input->post('faculty_seed'),
			'head_name' => $this->input->post('head_name'),
			'secretary_name' => $this->input->post('secretary_name'),
			'staff_name' => $this->input->post('staff_name'),
			'consulted' => $consulted,
			'informed_iqac' => $this->input->post('informed_iqac'),
			'fac_sanctioned' => $this->input->post('fac_sanctioned'),
			'fac_appointed' => $this->input->post('fac_appointed'),
			//'app_letter' => $this->input->post('app_letter'),
			'fac_name' => $this->input->post('fac_name'),
			'fac_experience' => $this->input->post('fac_experience'),
			'fac_designation' => $this->input->post('fac_designation'),
			'guests' => $this->input->post('guests'),
			'fac_phd_no' => $this->input->post('fac_phd_no'),
			'fac_mphil_no' => $this->input->post('fac_mphil_no'),
			'resource_no' => $this->input->post('resource_no'),
			'final_stu_appeared' => $this->input->post('final_stu_appeared'),
			'final_stu_passed' => $this->input->post('final_stu_passed'),
			'stu_placed_no' => $this->input->post('stu_placed_no'),
			'higher_studies_no' => $this->input->post('higher_studies_no'),
			'mentor_ratio' => $this->input->post('mentor_ratio'),
			);
			
			if($_FILES['invitation']['size'] != 0) {
			$file_ext = pathinfo($_FILES["invitation"]["name"], PATHINFO_EXTENSION);
			$NewImageName = $user_id.'_'.rand().'_Invitation.'.$file_ext;
			
			$_FILES["file"]["name"] = $NewImageName;
			$_FILES["file"]["type"] = $_FILES["invitation"]["type"];
			$_FILES["file"]["tmp_name"] = $_FILES["invitation"]["tmp_name"];
			$_FILES["file"]["error"] = $_FILES["invitation"]["error"];
			$_FILES["file"]["size"] = $_FILES["invitation"]["size"];

			$config = $this->do_upload_iqac();
			$this->upload->initialize($config);
			if($this->upload->do_upload('file'))
			{
			 $ffff = $this->upload->data();
			  $image=$ffff['file_name'];
			  
			  $data_in['event_invitation'] = 'system/images/iqac/'.$NewImageName;
			  }
	 }
	 
	 if($_FILES['letter']['size'] != 0) {
			$file_ext = pathinfo($_FILES["letter"]["name"], PATHINFO_EXTENSION);
			$NewImageName = $user_id.'_'.rand().'_Letter.'.$file_ext;
			
			$_FILES["file"]["name"] = $NewImageName;
			$_FILES["file"]["type"] = $_FILES["letter"]["type"];
			$_FILES["file"]["tmp_name"] = $_FILES["letter"]["tmp_name"];
			$_FILES["file"]["error"] = $_FILES["letter"]["error"];
			$_FILES["file"]["size"] = $_FILES["letter"]["size"];

			$config = $this->do_upload_iqac();
			$this->upload->initialize($config);
			if($this->upload->do_upload('file'))
			{
			 $ffff = $this->upload->data();
			  $image=$ffff['file_name'];
			  
			  $data_in['app_letter'] = 'system/images/iqac/'.$NewImageName;
			  }
	 }
			$this->db->where('id',$id);
			$this->db->update('iqac',$data_in);
			
		$data_ins = array(
			'employee_id' => $user_id,
			'stream' => $stream,
			'department' => $department,
			'iqac_id' => $id,
			'created_at' => $add_date,
			);
			
			//Upload GPS Photos
		$i = 0 ;   
    foreach ($_FILES['photos']['name'] as $file){	
	$data_in1=array();
	if($_FILES['photos']['size'][$i] != 0) {
			$file_ext = pathinfo($_FILES["photos"]["name"][$i], PATHINFO_EXTENSION);
			$NewImageName = $user_id.'_'.rand().'_Image.'.$file_ext;
			
			$_FILES["file"]["name"] = $NewImageName;
			$_FILES["file"]["type"] = $_FILES["photos"]["type"][$i];
			$_FILES["file"]["tmp_name"] = $_FILES["photos"]["tmp_name"][$i];
			$_FILES["file"]["error"] = $_FILES["photos"]["error"][$i];
			$_FILES["file"]["size"] = $_FILES["photos"]["size"][$i];

			$config = $this->do_upload_iqac();
			$this->upload->initialize($config);
			if($this->upload->do_upload('file'))
			{
			 $ffff = $this->upload->data();
			  $image=$ffff['file_name'];
			  
			  $data_in1['type'] = 'photos';
			  $data_in1['path'] = 'system/images/iqac/'.$NewImageName;
			  }
			  $data_in1 = $data_in1 + $data_ins;
			  $this->db->insert('iqac_docs',$data_in1);
	 }
	 $i++;
	}
	
	//Upload Reports
	$r = 0 ;   
    foreach ($_FILES['reports']['name'] as $file){		
	$data_in2=array();
	if($_FILES['reports']['size'][$r] != 0) {
			$file_ext = pathinfo($_FILES["reports"]["name"][$r], PATHINFO_EXTENSION);
			$NewImageName = $user_id.'_'.rand().'_Report.'.$file_ext;
			
			$_FILES["file"]["name"] = $NewImageName;
			$_FILES["file"]["type"] = $_FILES["reports"]["type"][$r];
			$_FILES["file"]["tmp_name"] = $_FILES["reports"]["tmp_name"][$r];
			$_FILES["file"]["error"] = $_FILES["reports"]["error"][$r];
			$_FILES["file"]["size"] = $_FILES["reports"]["size"][$r];

			$config = $this->do_upload_iqac();
			$this->upload->initialize($config);
			if($this->upload->do_upload('file'))
			{
			 $ffff = $this->upload->data();
			  $image=$ffff['file_name'];
			  
			  $data_in2['type'] = 'reports';
			  $data_in2['path'] = 'system/images/iqac/'.$NewImageName;
			  }
			  $data_in2 = $data_in2 + $data_ins;
			  $this->db->insert('iqac_docs',$data_in2);
	 }
	 $r++;
	}
	
	//Upload Videos
	$v = 0 ;   
    foreach ($_FILES['videos']['name'] as $file){		
	$data_in3=array();
	if($_FILES['videos']['size'][$v] != 0) {
			$file_ext = pathinfo($_FILES["videos"]["name"][$v], PATHINFO_EXTENSION);
			$NewImageName = $user_id.'_'.rand().'_Video.'.$file_ext;
			
			$_FILES["file"]["name"] = $NewImageName;
			$_FILES["file"]["type"] = $_FILES["videos"]["type"][$v];
			$_FILES["file"]["tmp_name"] = $_FILES["videos"]["tmp_name"][$v];
			$_FILES["file"]["error"] = $_FILES["videos"]["error"][$v];
			$_FILES["file"]["size"] = $_FILES["videos"]["size"][$v];

			$config = $this->do_upload_iqac();
			$this->upload->initialize($config);
			if($this->upload->do_upload('file'))
			{
			 $ffff = $this->upload->data();
			  $image=$ffff['file_name'];
			  
			  $data_in3['type'] = 'videos';
			  $data_in3['path'] = 'system/images/iqac/'.$NewImageName;
			  }
			  $data_in3 = $data_in3 + $data_ins;
			  $this->db->insert('iqac_docs',$data_in3);
	 }
	 $v++;
	}
	
	//Upload Documents
	$d = 0 ;   
    foreach ($_FILES['docs']['name'] as $file){		
	$data_in4=array();
	if($_FILES['docs']['size'][$d] != 0) {
			$file_ext = pathinfo($_FILES["docs"]["name"][$d], PATHINFO_EXTENSION);
			$NewImageName = $user_id.'_'.rand().'_Doc.'.$file_ext;
			
			$_FILES["file"]["name"] = $NewImageName;
			$_FILES["file"]["type"] = $_FILES["docs"]["type"][$d];
			$_FILES["file"]["tmp_name"] = $_FILES["docs"]["tmp_name"][$d];
			$_FILES["file"]["error"] = $_FILES["docs"]["error"][$d];
			$_FILES["file"]["size"] = $_FILES["docs"]["size"][$d];

			$config = $this->do_upload_iqac();
			$this->upload->initialize($config);
			if($this->upload->do_upload('file'))
			{
			 $ffff = $this->upload->data();
			  $image=$ffff['file_name'];
			  
			  $data_in4['type'] = 'docs';
			  $data_in4['path'] = 'system/images/iqac/'.$NewImageName;
			  }
			  $data_in4 = $data_in4 + $data_ins;
			  $this->db->insert('iqac_docs',$data_in4);
	 }
	 $d++;
	}
	$data['msg']=$this->session->set_flashdata('success','Uploaded Successfully','success');
	redirect('nonteaching/iqacFormEdit/'.$id.'','refresh');
		 }
		 
	$this->load->view('template/nonteaching/header');
    $this->load->view('template/nonteaching/menubar');
    $this->load->view('template/nonteaching/headerbar');
    $this->load->view('nonteaching/iqacFormEdit',$data);
    $this->load->view('template/nonteaching/footer');
	}
	
	public function verifyAtt()
	{
	$user_id=$this->session->userdata['user']['user_id'];
	$subject=$this->input->post('subject');
	$date=str_replace('-','/',$this->input->post('date'));
	$add_date=date('Y-m-d',strtotime($date));
	$period=$this->input->post('period');
	
	$det = $this->db->where('id',$user_id)->get('erp_employee_master')->row();
		$stream = $det->emp_college_type_;
		$department = $det->emp_dept_name_;
	
	$get_sub = $this->db->where('id',$subject)->get('erp_subjectmaster')->row();
    $part = $get_sub->part;
	$catg = $get_sub->subCatg;
	$batch = $get_sub->batch_year;
	$sem = $get_sub->sem;
	
	if($part==2 AND (strtolower($catg)=='foundation')){
		$this->db->where('erp_stu_attendance.subject_id',$subject);
	}else{
	if(((($part==1 OR $part==4) AND $stream==5) OR ($catg=='Elective')) OR ($stream==2 OR $stream==3)){
		$this->db->where('erp_stu_attendance.subject_id',$subject);
		$this->db->where('erp_stu_attendance.main_id',$stream);
	}
	else{
		$this->db->where('erp_stu_attendance.main_id',$stream);
		$this->db->where('erp_stu_attendance.course_id',$department);
	}
	}
	
	$getatt=$this->db->select('erp_stu_attendance.user_id as emp, erp_subjectmaster.subName as subjectname, erp_employee_master.emp_name_ as empname')->join('erp_subjectmaster','erp_subjectmaster.id=erp_stu_attendance.subject_id','left')->join('erp_employee_master','erp_employee_master.id=erp_stu_attendance.user_id','left')->where('erp_stu_attendance.user_id != '.$user_id.'')->where('erp_stu_attendance.period',$period)->where('erp_stu_attendance.batch_year',$batch)->where('erp_stu_attendance.sem',$sem)->where('DATE_FORMAT(erp_stu_attendance.att_date,"%Y-%m-%d")',$add_date)->get('erp_stu_attendance')->row();
	
	$data = array();
	if(isset($getatt)){
	$data['empname'] = 	$getatt->empname;
	$data['subname'] = 	$getatt->subjectname;
		$value=json_encode($data);
	}else{
		$value=1;
	}
	echo $value;
    }
	
	public function getAttendance()
	{
	$user_id=$this->session->userdata['user']['user_id'];
	$subject=$this->input->post('subject');
	$date=str_replace('-','/',$this->input->post('date'));
	$add_date=date('Y-m-d',strtotime($date));
	$period=$this->input->post('period');
	
	$det = $this->db->where('id',$user_id)->get('erp_employee_master')->row();
		$stream = $det->emp_college_type_;
		$department = $det->emp_dept_name_;
	
	$get_sub = $this->db->where('id',$subject)->get('erp_subjectmaster')->row();
    $part = $get_sub->part;
	$catg = $get_sub->subCatg;
	$batch = $get_sub->batch_year;
	$sem = $get_sub->sem;
	
	$getatt=$this->db->where('erp_stu_attendance.attndnce_status',0)->where('erp_stu_attendance.user_id',$user_id)->where('erp_stu_attendance.period',$period)->where('erp_stu_attendance.sem',$sem)->where('DATE_FORMAT(erp_stu_attendance.att_date,"%Y-%m-%d")',$add_date)->get('erp_stu_attendance')->result();
	
	$value = array();
	$data = array();
	foreach($getatt as $getattn){
	$data[$getattn->student_id] = 	$getattn->attndnce_status;
	}
	array_push($value,$data);
	
	$getod=$this->db->where('erp_stu_od.od_status',1)->where('erp_stu_od.user_id',$user_id)->where('erp_stu_od.period',$period)->where('erp_stu_od.sem',$sem)->where('DATE_FORMAT(erp_stu_od.att_date,"%Y-%m-%d")',$add_date)->get('erp_stu_od')->result();
	
	$data1 = array();
	foreach($getod as $getod1){
	$data1[$getod1->student_id] = 	$getod1->od_status;
	}
	array_push($value,$data1);
	echo json_encode($value);
    }
}
