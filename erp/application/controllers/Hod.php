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
class Hod extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	//  error_reporting(0);
	  date_default_timezone_set("Asia/Calcutta");
	  $this->load->library('upload');
	  $this->load->config('email');
		$this->load->library('email');
	    $this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('pdf');
		$this->load->library('MY_Form_validation'); 
         
		 if ($this->session->userdata('user')['user_designation'] != 12) {
            redirect("employee_login", "refresh");
        }
	
	}


	public function rules_ica_tt()
    {
        $config = [
		[
                "field" => "ica",
                "label" => "ICA",
                "rules" => "required",
                "errors" => [
                    "required" => "You must provide a %s.",
                ],
            ],
			[
                "field" => "batch",
                "label" => "Batch",
                "rules" => "required",
                "errors" => [
                    "required" => "You must provide a %s.",
                ],
            ],
			[
                "field" => "sem",
                "label" => "Semester",
                "rules" => "required",
                "errors" => [
                    "required" => "You must provide a %s.",
                ],
            ],
            [
                "field" => "subject",
                "label" => "Subject",
                "rules" => "required|is_unique_multiple[ica_timetable, ICA.subject_id,ica.subject]",
                "errors" => [
                    "required" => "You must provide a %s.",
                    "is_unique_multiple" => "This %s has already been assigned.",
                ],
            ],
            [
                "field" => "date",
                "label" => "Date",
                "rules" => "required",
                "errors" => [
                    "required" => "You must provide a %s.",
                ],
            ],
        ];
        return $config;
    }

	public function index()
	{
		$data['user_id']=$this->session->userdata('user')['user_id'];
    $this->load->view('template/hod/header');
    $this->load->view('template/hod/menubar');
    $this->load->view('template/hod/headerbar');
    $this->load->view('hod/dashbord',$data);
    $this->load->view('template/hod/footer');
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
				 redirect('hod/updatePassword','refresh');
			 }else{
				 $data['mesg']=$this->session->set_flashdata('form_err','New Password and Confirm Password does not match!!','danger');
				 redirect('hod/updatePassword','refresh');
			 }
		 }else{
			$data['mesg']=$this->session->set_flashdata('form_err','Old Password does not match!!','danger'); 
			redirect('hod/updatePassword','refresh');
		 }
		}
    $this->load->view('template/hod/header');
    $this->load->view('template/hod/menubar');
    $this->load->view('template/hod/headerbar');
    $this->load->view('hod/update_password',$data);
    $this->load->view('template/hod/footer');
    }
	
	public function blockHallTicket()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$staff_det = $this->db->where('id',$user_id)->get('erp_employee_master')->row();
		
		$data['batch1']='';
		$data['stream']=$stream=$staff_det->emp_college_type_;
		$data['department']=$department=$staff_det->emp_dept_name_;
		$data['sem1']='';
		
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['sem1']=$sem = $this->input->post('sem');
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		//->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		}
		
	$this->load->view('template/hod/header');
    $this->load->view('template/hod/menubar');
    $this->load->view('template/hod/headerbar');
    $this->load->view('hod/block_hallTicket',$data);
    $this->load->view('template/hod/footer');
    }
	
	public function blockHt()
	{
		
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$batch = $this->input->post('batch');
		$batch_id = $this->db->where('batch_from',$batch)->get('erp_batchmaster')->row();
		    $data['batch_id']=$batch_id->id;
		    $data['batch_year']=$batch;
			$data['type']='HOD';
			$data['sem']=$sem = $this->input->post('sem');
			$data['main_id']=$stream = $this->input->post('stream');
			$data['course_id']=$department = $this->input->post('department');
			$data['student_id']=$student = $this->input->post('student');
			$data['status']= $this->input->post('status');
			$data['user_id']=$user_id;
			$data['created_at']=$add_date;
			
		$block_det = $this->db->where('type','HOD')->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$student)->get('erp_block_halltickets')->row();
		if(isset($block_det)){
		$data_edit['status']= $this->input->post('status');	
		$this->db->where('id',$block_det->id);
		$update = $this->db->update('erp_block_halltickets',$data_edit);
		}else{
		$insert = $this->db->insert('erp_block_halltickets',$data);
		}
		echo 'Success';
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
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->order_by('erp_existing_students.reg_no_','asc')
		->get('erp_existing_students')->result();
		
		/*if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->id==412 OR $get_sub->id==385  OR $get_sub->id==410 OR $get_sub->id==383  OR $get_sub->id==386  OR $get_sub->id==413 OR $get_sub->id==409 OR $get_sub->id==382 )){
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=1 OR erp_existing_students.cour_id=2)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->order_by('erp_existing_students.reg_no_','asc')
		->get('erp_existing_students')->result();
		}*/
		
		if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->sem==1 OR $get_sub->sem==2)){
			$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=1 OR erp_existing_students.cour_id=2 OR erp_existing_students.cour_id=3)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->order_by('erp_existing_students.reg_no_','asc')
		->get('erp_existing_students')->result();
		}
			
	 	if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->subCode=='MS/20C/303A' OR $get_sub->subCode=='MS/20ID/305A' OR $get_sub->subCode=='MS/20C/203A' OR $get_sub->subCode=='MS/20E/206A' OR $get_sub->subCode=='MS/20C/403A')){
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=1 OR erp_existing_students.cour_id=2)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->order_by('erp_existing_students.reg_no_','asc')
		->get('erp_existing_students')->result();
		}
			
	 	if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->subCode=='MO/21C/101' OR $get_sub->subCode=='MS/20C/203B' OR $get_sub->subCode=='MH/2OC/104' OR $get_sub->subCode=='MS/20E/206B')){
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=3)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->order_by('erp_existing_students.reg_no_','asc')
		->get('erp_existing_students')->result();
		}
		


		//print_r($this->db->last_query());exit;
		//print_r($data['stu_list']);exit;
		
		$data['sub_list']=$this->db->where('batch',$batch)->where('sem',$sem)->where('employee_id',$user_id)->get('erp_employee_subject')->result();
		}
    $this->load->view('template/hod/header');
    $this->load->view('template/hod/menubar');
    $this->load->view('template/hod/headerbar');
    $this->load->view('hod/student_attendance',$data);
    $this->load->view('template/hod/footer'); 
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
		$data['user']=$this->db->where('id',$user_id)->get('erp_employee_master')->row();
    $this->load->view('template/hod/header');
    $this->load->view('template/hod/menubar');
    $this->load->view('template/hod/headerbar');
    $this->load->view('hod/leaves',$data);
    $this->load->view('template/hod/footer');
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
		5 => 'leave_status'
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
		$sql .= " OR `leave_status` LIKE '" . $requestData['search']['value'] . "%')";
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
			$leaveSQL = $this->db->query("INSERT INTO `wy_leaves` (`emp_code`, `leave_subject`, `leave_dates`, `leave_message`, `leave_type`, `apply_date`) VALUES('" . $empData . "', '$leave_subject', '$leave_dates', '$leave_message', '$leave_type', '" . date('Y-m-d H:i:s') . "')");
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

public function holidays()
	{
		$data['user_id']=$this->session->userdata('user')['user_id'];
    $this->load->view('template/hod/header');
    $this->load->view('template/hod/menubar');
    $this->load->view('template/hod/headerbar');
    $this->load->view('hod/holidays',$data);
    $this->load->view('template/hod/footer');
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
    $this->load->view('template/hod/header');
    $this->load->view('template/hod/menubar');
    $this->load->view('template/hod/headerbar');
    $this->load->view('hod/salaries',$data);
    $this->load->view('template/hod/footer');
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
			$nestedData[] = '<form action="'.base_url().'payrolllogin/GeneratePaySlipEmployee/'.$user.'/'.$pay_month[0].'/'.$pay_month[1].'" method="post"><button type="submit" class="btn btn-success btn-xs"><i class="fa fa-download"></i></button></form>';

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


public function examiners()
	{
		$data['user_id'] = $user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
        $data['examiner_list'] = $this->db->where('user_id',$user_id)->get('erp_examiners')->result();		 
        $data['appr_stat'] = $this->db->where('user_id',$user_id)->where('login_status',1)->get('erp_examiners')->row(); 
		
    $this->load->view('template/hod/header');
    $this->load->view('template/hod/menubar');
    $this->load->view('template/hod/headerbar');
    $this->load->view('hod/examiners',$data);
    $this->load->view('template/hod/footer');
    }
	
	public function examinersAdd()
	{
		$data['user_id'] = $user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$user = $this->db->where('id',$user_id)->get('erp_employee_master')->row();
		$stream=$user->emp_college_type_;
	    $department=$user->emp_dept_name_;
		
		$config = array(
		array('field' => 'batch','label' => 'Batch','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'sem','label' => 'Sem','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'subject','label' => 'Subject','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'designation','label' => 'Designation','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'college','label' => 'College Name','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'company','label' => 'Company Name','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'first_name','label' => 'First Name','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
        array(
                'field' => 'mobile',
                'label' => 'Mobile No.',
                'rules' => 'required|is_unique[erp_examiners.mobile]',
				'errors' => array(
                        'required' => 'You must provide a %s.',
						'is_unique' => 'This %s for the sem already exists.'
						),
        ),
		array(
                'field' => 'email',
                'label' => 'Email ID',
                'rules' => 'required|is_unique[erp_examiners.email]',
				'errors' => array(
                        'required' => 'You must provide a %s.',
						'is_unique' => 'This %s for the sem already exists.'
						),
        ),
		);
		if(isset($_POST['submit'])){
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) { 
         $data['form_err']=$this->session->set_flashdata('form_err','Please check all the details','warning'); 
         } 
         else {
		
		$batch = $this->input->post('batch');
		$batch_id = $this->db->where('batch_from',$batch)->get('erp_batchmaster')->row();
		 $data_add = array(
		  'batch_id' => $batch_id->id,
		  'batch_year' => $batch,
		  'sem' => $this->input->post('sem'),
		  'subject_id' => $this->input->post('subject'),
		  'main_id' => $stream,
		  'course_id' => $department,
		  'designation' => $this->input->post('designation'),
		  'college' => $this->input->post('college'),
		  'company' => $this->input->post('company'),
		  'first_name' => $this->input->post('first_name'),
		  'last_name' => $this->input->post('last_name'),
		  'dob' => $this->input->post('dob'),
		  'mobile' => $this->input->post('mobile'),
		  'email' => $this->input->post('email'),
		  //'acc_no' => $this->input->post('acc_no'),
		  //'bank_name' => $this->input->post('bank_name'),
		  //'bank_branch' => $this->input->post('bank_branch'),
		  //'ifsc' => $this->input->post('ifsc'),
		  'experience' => $this->input->post('experience'),
		  'status' => $this->input->post('status'),
		  'user_id' => $user_id,
		  'created_at' => $add_date,
		 );
		 if($this->input->post('department') != 0){
		  $data_add['department_id'] = $this->input->post('department');
		 }
		  
		$insert = $this->db->insert('erp_examiners',$data_add);
		$data['msg']=$this->session->set_flashdata('success','Added Successfully','success'); 
		redirect('hod/examinersAdd','refresh');
		}
		 }		
		
    $this->load->view('template/hod/header');
    $this->load->view('template/hod/menubar');
    $this->load->view('template/hod/headerbar');
    $this->load->view('hod/examinersAdd',$data);
    $this->load->view('template/hod/footer');
    }
		public function leaveApprove()
		{

			$m=[];
			$user_id=$this->session->userdata('user')['user_id'];

			$user = $this->db->where('id',$user_id)->get('erp_employee_master')->row();
			$stream=$user->emp_college_type_;
			$department=$user->emp_dept_name_;
			
		$q=	$this->db->select("id")->from("erp_employee_master")->where("emp_designation_",23)->where("emp_college_type_",$stream)->where("emp_dept_name_",$department)->get();

$r = $q->num_rows();

if($r > 0){

$res = $q->result_array();

$last_names = array_column($res, 'id');
			$m = array_unique($last_names);


}



			 $data['user']=$user_id=$this->session->userdata('user')['user_id'];
			$add_date=date('Y-m-d H:i:s');
			
			$data['leave_list']=$this->db->select('l.*,e.emp_name_')->join('erp_employee_master e','l.emp_code=e.id','left')
			->where('e.emp_designation_ !=','30')
			->where_in("emp_code",$m)->order_by('l.leave_id','desc')->get('wy_leaves l')->result();
			
		$this->load->view('template/hod/header');
			$this->load->view('template/hod/menubar');
			$this->load->view('template/hod/headerbar');
			$this->load->view('hod/leave',$data);
			$this->load->view('template/hod/footer');	 
		}
		public function leaveApproveStatus()
	{
	$data['principal_id']=$user_id=$this->session->userdata('user')['user_id'];
	$id=$this->input->post('leave_id');
	$data['leave_status_hod']=$this->input->post('status');
	
      $this->db->where('leave_id',$id);
      $this->db->update('wy_leaves',$data);	
	  
	$leaveData = $this->db->where('leave_id',$id)->get('wy_leaves')->row();  
	$empData = $this->db->where('id',$leaveData->emp_code)->get('erp_employee_master')->row();  
	/* if($data['leave_status_principal']=='approve'){$stat='approved';}else{$stat='rejected';}
	  
				if ( $empData ) {
					$empName  = $empData->emp_name_;
					$empEmail = $empData->emp_mail_;
					$subject  = 'Leave application '.$stat.'';
					$message  = '<p>Hi ' . $empData->emp_name_ . '</p>';
					$message .= '<p>Your leave application is '.$stat.'.</p>';
					$message .= '<p>Application Details:</p>';
					$message .= '<p>Subject: ' . $leaveData->leave_subject . '</p>';
					$message .= '<p>Leave Date(s): ' . $leaveData->leave_dates . '</p>';
					$message .= '<p>Message: ' . $leaveData->leave_message . '</p>';
					$message .= '<p>Leave Type: ' . $leaveData->leave_type . '</p>';
					$message .= '<p>Status: ' . ucwords($leaveData->leave_status_principal) . '</p>';
					$message .= '<hr/>';
					$message .= '<p>Thank You,<br/>Wisely Online Services Private Limited</p>';
			$config = array(
	 'protocol' => 'smtp',
     'smtp_host' => 'ssl://smtp.gmail.com',
     'smtp_port' => 465,
     'smtp_user' => 'admission.mssw@gmail.com',
     'smtp_pass' => 'dqamafoawpedieqn',
     'mailtype' => 'html',
	 'charset' => 'iso-8859-1',  
	 'newline' => '\r\n',  
	 );

			$this->email->initialize($config);

            $this->email->set_mailtype("html");
            $this->email->from('admission.mssw@gmail.com');
            $this->email->to($email);
            $this->email->subject($subject);
            $this->email->message($message); */
	  
	echo 'Success';
    }
		
	public function examinersEdit()
	{
		$data['user_id'] = $user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['edit_id'] = $id = $this->uri->segment(3);
		$data['examiner'] = $this->db->where('id',$id)->get('erp_examiners')->row();
		
		$user = $this->db->where('id',$user_id)->get('erp_employee_master')->row();
		$data['stream']=$user->emp_college_type_;
	    $data['department']=$user->emp_dept_name_;
	
		$config = array(
		array('field' => 'batch','label' => 'Batch','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'sem','label' => 'Sem','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'subject','label' => 'Subject','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'designation','label' => 'Designation','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'college','label' => 'College Name','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'company','label' => 'Company Name','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'first_name','label' => 'First Name','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'mobile','label' => 'Mobile No.','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'email','label' => 'Email','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		);
		if(isset($_POST['submit'])){
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) { 
         $data['form_err']=$this->session->set_flashdata('form_err','Please check all the details','warning'); 
         } 
         else {
		 $edit_id = $this->input->post('edit_id');
		 $batch = $this->input->post('batch');
		 $batch_id = $this->db->where('batch_from',$batch)->get('erp_batchmaster')->row();
		 $data_edit = array(
		  'batch_id' => $batch_id->id,
		  'batch_year' => $batch,
		  'sem' => $this->input->post('sem'),
		  'subject_id' => $this->input->post('subject'),
		  'designation' => $this->input->post('designation'),
		  'college' => $this->input->post('college'),
		  'company' => $this->input->post('company'),
		  'first_name' => $this->input->post('first_name'),
		  'last_name' => $this->input->post('last_name'),
		  'dob' => $this->input->post('dob'),
		  'mobile' => $this->input->post('mobile'),
		  'email' => $this->input->post('email'),
		  //'acc_no' => $this->input->post('acc_no'),
		  //'bank_name' => $this->input->post('bank_name'),
		  //'bank_branch' => $this->input->post('bank_branch'),
		  //'ifsc' => $this->input->post('ifsc'),
		  'experience' => $this->input->post('experience'),
		  'status' => $this->input->post('status'),
		 );
		 if($this->input->post('department') != 0){
		  $data_edit['department_id'] = $this->input->post('department');
		 }else{
		  $data_edit['department_id'] = 0; 
		 }
		  
		  $this->db->where('id',$edit_id);
		$update = $this->db->update('erp_examiners',$data_edit);
		$data['msg']=$this->session->set_flashdata('success','Edited Successfully','success'); 
		redirect('hod/examiners','refresh');
		}
		 }		
		
    $this->load->view('template/hod/header');
    $this->load->view('template/hod/menubar');
    $this->load->view('template/hod/headerbar');
    $this->load->view('hod/examinersEdit',$data);
    $this->load->view('template/hod/footer');
    }
	public function examinersDelete()
	{
		$data['user_id'] = $user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$id = $this->uri->segment(3);
		$delete = $this->db->where('id',$id)->delete('erp_examiners');
		$data['msg']=$this->session->set_flashdata('success','Deleted Successfully','success'); 
		redirect('hod/examiners','refresh');
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
	$sub = $this->db->where('department',$dept)->where('stream',$stream)->get('erp_subjectmaster')->result();	
	
	$subject = '<option value="">Select Subject</option>';
	foreach($sub as $sub){
		$subject .= '<option value="'.$sub->id.'">'.$sub->subName.'</option>';
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
	$batch=$this->input->post('batch');
	$sem=$this->input->post('sem');
	//$sub = $this->db->where('department',$dept)->where('stream',$stream)->where('batch_year',$batch)->where('sem',$sem)->get('erp_subjectmaster')->result();	
	if($stream == 2 || $stream == 3){
	$sub = $this->db->where('batch_year',$batch)->where('stream',$stream)->where('sem',$sem)->get('erp_subjectmaster')->result();	
	}else{
	$sub = $this->db->where('department',$dept)->where('batch_year',$batch)->where('stream',$stream)->where('sem',$sem)->get('erp_subjectmaster')->result();	
	}
	
	$subject .= '<option value="">Select Subject</option>';
	foreach($sub as $sub){
		if (in_array($sub->id, $getsub)){
		$sele='selected';}else{$sele='';}
		$subject .= '<option value="'.$sub->id.'" '.$sele.'>'.$sub->subName.'</option>';
	}
	echo $subject;
    }
	public function allocateSubject()
    {
		$add_date=date('Y-m-d H:i:s');
		$user_id=$this->session->userdata("user")["user_id"];
		$user=$this->db->where('id',$user_id)->get('erp_employee_master')->row();
		$data['stream']=$user_main=$user->emp_college_type_;
		$data['department']=$user_course=$user->emp_dept_name_;
		
        $data['role']=$this->db->get('erp_role_master')->result();
        $data['subject']=$this->db->get('erp_subjectmaster')->result();
        //$data['subject2']=$this->db->where('stream',$user_main)->where('department',$user_course)->get('erp_subjectmaster')->result();
		$data['employee']='';
		
		/*if($user_main == 2 || $user_main == 3){
		$data['employee2']=$this->db->where('(emp_designation_= 23 or emp_designation_= 12)')->where('emp_college_type_',$user_main)->where('emp_working_status_','working')->get('erp_employee_master')->result();
		}else{
		$data['employee2']=$this->db->where('(emp_designation_= 23 or emp_designation_= 12)')->where('emp_college_type_',$user_main)->where('emp_dept_name_',$user_course)->where('emp_working_status_','working')->get('erp_employee_master')->result();
		}*/
		$data['employee2']=$this->db->where('(emp_designation_= 23 or emp_designation_= 12)')->where('emp_college_type_',$user_main)->where('emp_working_status_','working')->get('erp_employee_master')->result();
		//print_r($this->db->last_query());exit;
		
		$data['batch1'] = '';
		$data['sem1'] = '';
		$data['subject_b'] = '';
		
		if(isset($_POST['submit'])){
			$subject1=$this->input->post('subject');
			$data['subject1']=$subject=implode(',',$subject1);
			$data['employee']=$employee=$this->input->post('employee');
			$batch=$this->input->post('batch');
			$sem=$this->input->post('sem');
			
	  $data['subject2']=$this->db->where('stream',$user_main)->where('department',$user_course)->where('batch_year',$batch)->where('sem',$sem)->get('erp_subjectmaster')->result();
	   
	   $data_ins = array(
	   'subject_' => $subject,
	   );
	   $this->db->where('id',$employee);
	   $this->db->update('erp_employee_master',$data_ins);
	   
	   $emp_get = $this->db->where('id',$employee)->get('erp_employee_master')->row();
	   
	   foreach($subject1 as $subj){
		   $data_s = array(
		   'subject_id' => $subj,
		   'batch' => $batch,
		   'sem' => $sem,
		   'stream' => $emp_get->emp_college_type_,
		   'department' => $emp_get->emp_dept_name_,
		   'employee_id' => $employee,
		   'hod_id' => $user_id,
		   'created_at' => $add_date,
		   );
	   $emp_sub = $this->db->where('subject_id',$subj)->where('batch',$batch)->where('sem',$sem)->get('erp_employee_subject')->row();
	   if(isset($emp_sub)){
		   $this->db->where('id',$emp_sub->id);
		   $this->db->update('erp_employee_subject',$data_s);
	   }else{
		   $this->db->insert('erp_employee_subject',$data_s);
	   }
	   }
	   redirect('hod/allocateSubject','refresh');
		}
		
		if(isset($_POST['list_staff'])){
			$data['batch1'] = $batch = $this->input->post('batch');
			$data['sem1'] = $sem = $this->input->post('sem');
			
		//$data['emp_list']=$this->db->select('em.id,em.employee_id_,em.emp_name_,GROUP_CONCAT(es.subject_id SEPARATOR ", ") as subjects')->join('erp_employee_master em','em.id=es.employee_id','left')->where('es.stream',$user_main)->where('es.department',$user_course)->where('es.batch',$batch)->where('es.sem',$sem)->group_by('es.employee_id')->get('erp_employee_subject es')->result();
		$data['emp_list']=$this->db->select('em.id,em.employee_id_,em.emp_name_,GROUP_CONCAT(es.subject_id SEPARATOR ", ") as subjects')->join('erp_employee_master em','em.id=es.employee_id','left')->where('es.hod_id',$user_id)->where('es.batch',$batch)->where('es.sem',$sem)->group_by('es.employee_id')->get('erp_employee_subject es')->result();
		}
		
		if(isset($_POST['submit_edit'])){
			$id=$this->input->post('edit_id');
			$data['batch1'] = $batch=$this->input->post('batch');
			$data['sem1'] = $sem=$this->input->post('sem');
			$subject1=$this->input->post('subject_edit');
			$subject=implode(',',$subject1);
	   
	   $data_up = array(
	   'subject_' => $subject,
	   );
	   $this->db->where('id',$id);
	   $this->db->update('erp_employee_master',$data_up);
	   
	  //$this->db->where_not_in('subject_id',$subject1)->where('batch',$batch)->where('sem',$sem)->where('employee_id',$id)->where('stream',$user_main)->where('department',$user_course)->delete('erp_employee_subject');
	  $this->db->where_not_in('subject_id',$subject1)->where('batch',$batch)->where('sem',$sem)->where('employee_id',$id)->delete('erp_employee_subject');
	  
	  $emp_get = $this->db->where('id',$id)->get('erp_employee_master')->row();
	   
	   foreach($subject1 as $subj){
		   $data_s = array(
		   'subject_id' => $subj,
		   'batch' => $batch,
		   'sem' => $sem,
		   'stream' => $emp_get->emp_college_type_,
		   'department' => $emp_get->emp_dept_name_,
		   'employee_id' => $id,
		   'hod_id' => $user_id,
		   'created_at' => $add_date,
		   );
	   $emp_sub = $this->db->where('subject_id',$subj)->where('batch',$batch)->where('sem',$sem)->get('erp_employee_subject')->row();
	   if(isset($emp_sub)){
		   $this->db->where('id',$emp_sub->id);
		   $this->db->update('erp_employee_subject',$data_s);
	   }else{
		   $this->db->insert('erp_employee_subject',$data_s);
	   }
	   }
	   
	   $data['emp_list']=$this->db->select('em.id,em.employee_id_,em.emp_name_,GROUP_CONCAT(es.subject_id SEPARATOR ", ") as subjects')->join('erp_employee_master em','em.id=es.employee_id','left')->where('es.hod_id',$user_id)->where('es.batch',$batch)->where('es.sem',$sem)->group_by('es.employee_id')->get('erp_employee_subject es')->result();
	   
	   $data['mesg']=$this->session->set_flashdata('success','Edited Successfully!!');
	   //redirect('hod/allocateSubject','refresh');
		}
		
        $this->load->view("template/hod/header");
        $this->load->view("template/hod/menubar");
        $this->load->view("template/hod/headerbar");
        $this->load->view("hod/allocate_subject", $data);
        $this->load->view("template/hod/footer");
    }
	public function allocateSubjectEdit()
    {
		$add_date=date('Y-m-d H:i:s'); 
		$user_id=$this->session->userdata("user")["user_id"];
		
		$user=$this->db->where('id',$user_id)->get('erp_employee_master')->row();
		$data['stream']=$user_main=$user->emp_college_type_;
		$data['department']=$user_course=$user->emp_dept_name_;
		if(isset($_POST['submit_edit'])){
			$id=$this->input->post('edit_id');
			$batch=$this->input->post('batch');
			$sem=$this->input->post('sem');
			$subject1=$this->input->post('subject_edit');
			$subject=implode(',',$subject1);
	   
	   $data_up = array(
	   'subject_' => $subject,
	   );
	   $this->db->where('id',$id);
	   $this->db->update('erp_employee_master',$data_up);
	   
	   foreach($subject1 as $subj){
		   $data_s = array(
		   'subject_id' => $subj,
		   'batch' => $batch,
		   'sem' => $sem,
		   'stream' => $user_main,
		   'department' => $user_course,
		   'employee_id' => $id,
		   'hod_id' => $user_id,
		   'created_at' => $add_date,
		   );
	   $emp_sub = $this->db->where('subject_id',$subj)->where('batch',$batch)->where('sem',$sem)->get('erp_employee_subject')->row();
	   if(isset($emp_sub)){
		   $this->db->where('id',$emp_sub->id);
		   $this->db->update('erp_employee_subject',$data_s);
	   }else{
		   $this->db->insert('erp_employee_subject',$data_s);
	   }
	   }
	   
	   $data['mesg']=$this->session->set_flashdata('success','Edited Successfully!!');
	   redirect('hod/allocateSubject','refresh');
		}
    }
	public function delete_employee_subject()
	{
		if($this->input->post('type')==2)
		{
			$employee_id=$this->input->post('id');
	   $data_del = array(
	   'subject_' => null,
	   );		
	   $this->db->where('id',$employee_id);
	   $this->db->update('erp_employee_master',$data_del);
			echo "Deleted Successfully";
		} 
	}
	public function ICATimetable()
    {
		$user_id=$this->session->userdata("user")["user_id"];
		$user=$this->db->where('id',$user_id)->get('erp_employee_master')->row();
		$data['main_id']=$user_main=$user->emp_college_type_;
		$data['course_id']=$user_course=$user->emp_dept_name_;
		$add_date=date('Y-m-d H:i:s');
		
        //$data['subject']=$this->db->where('stream',$user_main)->where('department',$user_course)->get('erp_subjectmaster')->result();
        //$data['timetable']=$this->db->where('user_id',$user_id)->get('ica_timetable')->result();
		
		$data['batch1']='';
		$data['batch2']='';
		$data['subject1']='';
		$data['sem1']='';
		$data['sem2']='';
		$data['date1']='';
		$data['ica1']='';
		$data['ica2']='';
		
		$rules = $this->rules_ica_tt();
        $this->form_validation->set_rules($rules);
        if (isset($_POST["submit"])) {
			
			$data['batch1']=$batch=$this->input->post('batch');
			$data['subject1']=$subject=$this->input->post('subject');
			$data['sem1']=$sem=$this->input->post('sem');
			$data['ica1']=$ica=$this->input->post('ica');
			$data['date1']=$date=date('Y-m-d',strtotime($this->input->post('date')));
			
	   $batc = $this->db->where('id',$batch)->get('erp_batchmaster')->row();
	   if($user_main==2 OR $user_main==3){$this->db->where('department=1 OR department=2 OR department=3');}
	   else{$this->db->where('department',$user_course);}
		$data['subject']=$this->db->where('batch_year',$batc->batch_from)->where('sem',$sem)->where('stream',$user_main)->get('erp_subjectmaster')->result();
		
            if ($this->form_validation->run() == false) {
                $data["form_err"] = $this->session->set_flashdata(
                    "message",
                    "Enter Details Correctly",
                    "danger"
                );
            } 
			else {
			$stream=$this->input->post('stream');	
	        $department=$this->input->post('department');	
	   
	   $data_ins = array(
	   'ica' => $ica,
	   'batch_id' => $batch,
	   'batch' => $batc->batch_from,
	   'subject_id' => $subject,
	   'main_id' => $stream,
	   'course_id' => $department,
	   'date' => $date,
	   'user_id' => $user_id,
	   'created_at' => $add_date,
	   );
	   $this->db->insert('ica_timetable',$data_ins);
	   redirect('hod/ICATimetable','refresh');
			}
		}
		if (isset($_POST["list_tt"])) {
			$data['batch2'] = $batch = $this->input->post('batch');
			$data['sem2'] = $sem = $this->input->post('sem');
			$data['ica2'] = $ica = $this->input->post('ica');
	   $batc = $this->db->where('id',$batch)->get('erp_batchmaster')->row();
			$data['timetable'] = $this->db->where('batch',$batc->batch_from)->where('main_id',$user_main)->where('course_id',$user_course)->where('ICA',$ica)->get('ica_timetable')->result();
			
		}
		
        $this->load->view("template/hod/header");
        $this->load->view("template/hod/menubar");
        $this->load->view("template/hod/headerbar");
        $this->load->view("hod/ICATimetable", $data);
        $this->load->view("template/hod/footer");
    }
	public function getSubjectSemwise()
	{
	$batch=$this->input->post('batch');
	$stream=$this->input->post('stream');
	$dept=$this->input->post('dept');
	$sem=$this->input->post('sem');
	if($stream==2 OR $stream==3){$this->db->where('department=1 OR department=2 OR department=3');}
	else{$this->db->where('department',$dept);}
	$sub = $this->db->where('batch_id',$batch)->where('stream',$stream)->where('sem',$sem)->get('erp_subjectmaster')->result();	
	
	$subject = '<option value="">Select Subject</option>';
	foreach($sub as $sub){
		$subject .= '<option value="'.$sub->id.'">'.$sub->subName.'</option>';
	}
	echo $subject;
    }
	public function getICATimetable()
	{
	$id=$this->input->post('id');
	
	$this->db->where('id',$id);
	$data=$this->db->get('ica_timetable')->row();
	
	echo json_encode(['id'=>$data->id,'date'=>date('Y-m-d',strtotime($data->date))]);
    }
	public function updateICATimetable()
	{
	$id=$this->input->post('id');
	$date=date('Y-m-d',strtotime($this->input->post('date')));	
	$data['date']=$date;
	$this->db->where('id',$id);
	$this->db->update('ica_timetable',$data);
	echo $subject;
    }
	public function delete_ica_timetable()
	{
		if($this->input->post('type')==2)
		{
			$id=$this->input->post('id');
	   $this->db->where('id',$id);
	   $this->db->delete('ica_timetable');
			echo "Deleted Successfully";
		} 
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
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->order_by('erp_existing_students.reg_no_','asc')
		->get('erp_existing_students')->result();
		
		if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->sem==1 OR $get_sub->sem==2)){
			$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=1 OR erp_existing_students.cour_id=2 OR erp_existing_students.cour_id=3)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->order_by('erp_existing_students.reg_no_','asc')
		->get('erp_existing_students')->result();
		}
			
	 	if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->subCode=='MS/20C/303A' OR $get_sub->subCode=='MS/20ID/305A' OR $get_sub->subCode=='MS/20C/203A' OR $get_sub->subCode=='MS/20E/206A' OR $get_sub->subCode=='MS/20C/403A')){
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=1 OR erp_existing_students.cour_id=2)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->order_by('erp_existing_students.reg_no_','asc')
		->get('erp_existing_students')->result();
		}
			
	 	if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->subCode=='MO/21C/101' OR $get_sub->subCode=='MS/20C/203B' OR $get_sub->subCode=='MH/2OC/104' OR $get_sub->subCode=='MS/20E/206B')){
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=3)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->order_by('erp_existing_students.reg_no_','asc')
		->get('erp_existing_students')->result();
		}
		
		$data['ica_closing']=$this->db->where('batch_year',$batch)->where('sem',$get_sub->sem)->get('erp_ica_marks_closing')->row();
		}
		
	    $this->load->view("template/hod/header");
        $this->load->view("template/hod/menubar");
        $this->load->view("template/hod/headerbar");
        $this->load->view("hod/studentExamMarks", $data);
        $this->load->view("template/hod/footer");
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
		$det = $this->db->where('student_id',$ica1[$i])->where('subject_id',$subject_id)->get('erp_exammark')->row();
	 if(!isset($det)){	
	$data['batch']=$batch; 
	$data['sem']=$sem; 
	$data['subject_id']=$subject_id;
	$data['student_id']=$ica1[$i];
	$data['ica1Mark']=$icaval1[$i];
	$data['main_id']=$stu_id->main_id;
	$data['course_id']=$stu_id->cour_id;
	$data['hod_id']=$user_id;
	$data['created_at']=$add_date;
	$this->db->insert('erp_exammark',$data);
	 }else{	 
	$data['ica1Mark']=$icaval1[$i];	
	$data['hod_id']=$user_id;	
	 $this->db->where('id',$det->id);	
	$this->db->update('erp_exammark',$data);
	 }
	}
	
	if(!empty($ica1_not))
	for($ii=0; $ii<sizeof($ica1_not); $ii++){
		$delete = $this->db->where('student_id',$ica1_not[$ii])->where('subject_id',$subject_id)->get('erp_exammark')->row();
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
		$det = $this->db->where('student_id',$ica2[$i])->where('subject_id',$subject_id)->get('erp_exammark')->row();
	 if(!isset($det)){	
	$data['batch']=$batch; 
	$data['sem']=$sem; 
	$data['subject_id']=$subject_id; 
	$data['student_id']=$ica2[$i];
	$data['ica2Mark']=$icaval2[$i];
	$data['main_id']=$stu_id->main_id;
	$data['course_id']=$stu_id->cour_id;
	$data['hod_id']=$user_id;
	$data['created_at']=$add_date;
	$this->db->insert('erp_exammark',$data);
	 }else{
	$data['ica2Mark']=$icaval2[$i];	
	$data['hod_id']=$user_id;	
	 $this->db->where('id',$det->id);	
	$this->db->update('erp_exammark',$data);
	 }
	}
	
	if(!empty($ica2_not))
	for($ii=0; $ii<sizeof($ica2_not); $ii++){
		$delete = $this->db->where('student_id',$ica2_not[$ii])->where('subject_id',$subject_id)->get('erp_exammark')->row();
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
		$det = $this->db->where('student_id',$inclass[$i])->where('subject_id',$subject_id)->get('erp_exammark')->row();
	 if(!isset($det)){	
	$data['batch']=$batch; 
	$data['sem']=$sem; 
	$data['subject_id']=$subject_id; 
	$data['student_id']=$inclass[$i];
	$data['inClassMark']=$icval[$i];
	$data['main_id']=$stu_id->main_id;
	$data['course_id']=$stu_id->cour_id;
	$data['hod_id']=$user_id;
	$data['created_at']=$add_date;
	$this->db->insert('erp_exammark',$data);
	 }else{	 
	$data['inClassMark']=$icval[$i];	
	$data['hod_id']=$user_id;	
	 $this->db->where('id',$det->id);		
	$this->db->update('erp_exammark',$data);
	 }
	}
	
	if(!empty($inclass_not))
	for($ii=0; $ii<sizeof($inclass_not); $ii++){
		$delete = $this->db->where('student_id',$inclass_not[$ii])->where('subject_id',$subject_id)->get('erp_exammark')->row();
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
		$det = $this->db->where('student_id',$takehome[$i])->where('subject_id',$subject_id)->get('erp_exammark')->row();
	 if(!isset($det)){	
	$data['batch']=$batch; 
	$data['sem']=$sem; 
	$data['subject_id']=$subject_id; 
	$data['student_id']=$takehome[$i];
	$data['takeHomeMark']=$thval[$i];
	$data['main_id']=$stu_id->main_id;
	$data['course_id']=$stu_id->cour_id;
	$data['hod_id']=$user_id;
	$data['created_at']=$add_date;
	$this->db->insert('erp_exammark',$data);
	 }else{	 
	$data['takeHomeMark']=$thval[$i];	
	$data['hod_id']=$user_id;	
	 $this->db->where('id',$det->id);		
	$this->db->update('erp_exammark',$data);
	 }
	}
	
	if(!empty($takehome_not))
	for($ii=0; $ii<sizeof($takehome_not); $ii++){
		$delete = $this->db->where('student_id',$takehome_not[$ii])->where('subject_id',$subject_id)->get('erp_exammark')->row();
	 if(isset($delete)){	
	 $data1['takeHomeMark']=null;
	$this->db->where('id',$delete->id);	
	$this->db->update('erp_exammark',$data1);
	 }
	}
	echo 'Success';
    }
	
	public function submitToCoe()
	{
	$main_id=$this->input->post('main_id');
	$course_id=$this->input->post('course_id');
	$subject_id=$this->input->post('subject_id');
	$batch=$this->input->post('batch');
	$user_id=$this->session->userdata('user')['user_id'];
	$add_date=date('Y-m-d H:i:s');
	
	
	$data['batch']=$batch; 
	$data['subject_id']=$subject_id; 
	$data['main_id']=$main_id;
	$data['course_id']=$course_id;
	$data['hod_id']=$user_id;
	$data['status']=1;
	$data['created_at']=$add_date;
	$this->db->insert('erp_ica_to_coe',$data);
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
	
	public function getSubjectBatchAndSemwise()
	{
		$user_id=$this->session->userdata("user")["user_id"];
		$user=$this->db->where('id',$user_id)->get('erp_employee_master')->row();
		$stream=$user->emp_college_type_;
		$dept=$user->emp_dept_name_;
		
	$batch=$this->input->post('batch');
	$sem=$this->input->post('sem');
	if($stream == 2 || $stream == 3){
	$sub = $this->db->where('batch_year',$batch)->where('stream',$stream)->where('sem',$sem)->get('erp_subjectmaster')->result();	
	}else{
	$sub = $this->db->where('department',$dept)->where('batch_year',$batch)->where('stream',$stream)->where('sem',$sem)->get('erp_subjectmaster')->result();	
	}
	
	$subject = '<option value="">Select Subject</option>';
	foreach($sub as $sub){
		$subject .= '<option value="'.$sub->id.'">'.$sub->subName.'</option>';
	}
	echo $subject;
    }
	
	public function stuTamilName()
    {
		$user_id=$this->session->userdata("user")["user_id"];
		$user=$this->db->where('id',$user_id)->get('erp_employee_master')->row();
		$data['main_id']=$stream=$user->emp_college_type_;
		$data['course_id']=$department=$user->emp_dept_name_;
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		
        if (isset($_POST["submit"])) {
			
			$data['batch1']=$batch=$this->input->post('batch');
			
	   $data['stu_list'] = $this->db->select('erp_existing_students.*')
		//->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		
		}
		
        $this->load->view("template/hod/header");
        $this->load->view("template/hod/menubar");
        $this->load->view("template/hod/headerbar");
        $this->load->view("hod/stuTamilName", $data);
        $this->load->view("template/hod/footer");
    }
	
	public function tamilnameUpdate()
	{
		$user_id=$this->session->userdata("user")["user_id"];
		$user=$this->db->where('id',$user_id)->get('erp_employee_master')->row();
		$stream=$user->emp_college_type_;
		$dept=$user->emp_dept_name_;
		
		$id = $this->input->post('id');
		$reg_no = $this->input->post('reg_no');
		//$id = 2414;
		//$reg_no = 2115782021001;
		$admitted = $this->db->where('as_reg_num',$reg_no)->get('admitted_student')->row();
		$data_up['pr_Tamilname'] = $this->input->post('name');
		$data_up1['Tamilname'] = $this->input->post('name');
		
			$this->db->where('pr_user_id',$admitted->as_student_id);
		    if($stream=='5'){
				$this->db->update('new_preview',$data_up);
			}
			elseif($stream=='4'){
				$this->db->update('new_preview_dip',$data_up);
			}else{
				$this->db->update('new_preview_pg',$data_up);
			}
			
		$this->db->where('id',$id);	
		$this->db->update('erp_existing_students',$data_up1);
		
	echo 'Success';
    }
	
	public function languagePaperAllocation()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$user=$this->db->where('id',$user_id)->get('erp_employee_master')->row();
		$data['stream']=$stream=$user->emp_college_type_;
		$data['department']=$department=$user->emp_dept_name_;
		$date=date('Y-m-d');
		$data['batch1']='';
		$data['sem1']='';
		$data['subject1']='';
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['subject1']=$subject = $this->input->post('subject');
			$yr = substr($batch,-2);
		$stu_list = $data['stu_list'] = $this->db->select('erp_existing_students.*,erp_langallot.subject_id,erp_langallot.status,admitted_student.as_name,admitted_student.as_app_number')
		->join('erp_langallot','erp_langallot.existing_student_id=erp_existing_students.id and erp_langallot.subject_id="'.$subject.'"','left')
		->join('admitted_student','admitted_student.as_student_id=erp_existing_students.student_id','left')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		//print_r($this->db->last_query());exit;
		}
		
	$this->load->view('template/hod/header');
    $this->load->view('template/hod/menubar');
    $this->load->view('template/hod/headerbar');
    $this->load->view('hod/languagePaperAllocation',$data);
    $this->load->view('template/hod/footer');	
	}
	public function langAllot()
	{
	$students=$this->input->post('ids_alloted');
	$students_not=$this->input->post('ids_not_alloted');
	$subject=$this->input->post('subject');
	$batch=$this->input->post('batch');
	$sem=$this->input->post('sem');
	$add_date=date('Y-m-d H:i:s');
	
	    $user_id=$this->session->userdata('user')['user_id'];
		$user=$this->db->where('id',$user_id)->get('erp_employee_master')->row();
		$stream=$user->emp_college_type_;
		$department=$user->emp_dept_name_;
		
	$array = array(
	'stream' => $stream,
	'department' => $department,
	'subject_id' => $subject,
	'batch' => $batch,
	'sem' => $sem,
	'user_id' => $user_id,
	'created_at' => $add_date,
	);
	for($i=0; $i<sizeof($students); $i++){
	$data=array('status' => 1,'existing_student_id' => $students[$i]);
	$get_stu = $this->db->where('existing_student_id',$students[$i])->where('subject_id',$subject)->get('erp_langallot')->row();
	if(isset($get_stu)){
	 $this->db->where('existing_student_id',$students[$i]);	
	 $this->db->where('subject_id',$subject);	
	$this->db->update('erp_langallot',$data);
	}else{
		$data = array_merge($data,$array);
		$this->db->insert('erp_langallot',$data);
	}
	}
	for($ii=0; $ii<sizeof($students_not); $ii++){
	$data1['status']=0;
	$get_stu = $this->db->where('existing_student_id',$students_not[$ii])->where('subject_id',$subject)->get('erp_langallot')->row();
	if(isset($get_stu)){
	 $this->db->where('existing_student_id',$students_not[$ii]);	
	 $this->db->where('subject_id',$subject);
	$this->db->update('erp_langallot',$data1);
	}
	}
	echo 'Success';
    }
	public function getSubjectLanguagewise()
	{
		$user_id=$this->session->userdata("user")["user_id"];
		$user=$this->db->where('id',$user_id)->get('erp_employee_master')->row();
		$stream=$user->emp_college_type_;
		$dept=$user->emp_dept_name_;
		
	$batch=$this->input->post('batch');
	$sem=$this->input->post('sem');
	if($stream==2 OR $stream==3){$this->db->where('department=1 OR department=2 OR department=3');}
	else{$this->db->where('department',$dept);}
	//if($stream == 5){
	$sub = $this->db->where('batch_year',$batch)->where('stream',$stream)->where('sem',$sem)->where('(part=1 OR part=4)')->get('erp_subjectmaster')->result();	
	//}
	
	$subject = '<option value="">Select Subject</option>';
	foreach($sub as $sub){
		$subject .= '<option value="'.$sub->id.'">'.$sub->subName.'</option>';
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
	
	public function deleteAttendance()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
	$this->load->view('template/hod/header');
    $this->load->view('template/hod/menubar');
    $this->load->view('template/hod/headerbar');
    $this->load->view('hod/delete_attendance',$data);
    $this->load->view('template/hod/footer');	
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
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		
		if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->sem==1 OR $get_sub->sem==2)){
			$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=1 OR erp_existing_students.cour_id=2 OR erp_existing_students.cour_id=3)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->order_by('erp_existing_students.reg_no_','asc')
		->get('erp_existing_students')->result();
		}
			
	 	if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->subCode=='MS/20C/303A' OR $get_sub->subCode=='MS/20ID/305A' OR $get_sub->subCode=='MS/20C/203A' OR $get_sub->subCode=='MS/20E/206A' OR $get_sub->subCode=='MS/20C/403A')){
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=1 OR erp_existing_students.cour_id=2)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->order_by('erp_existing_students.reg_no_','asc')
		->get('erp_existing_students')->result();
		}
			
	 	if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->subCode=='MO/21C/101' OR $get_sub->subCode=='MS/20C/203B' OR $get_sub->subCode=='MH/2OC/104' OR $get_sub->subCode=='MS/20E/206B')){
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=3)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->order_by('erp_existing_students.reg_no_','asc')
		->get('erp_existing_students')->result();
		}
		
		$data['sub_list']=$this->db->where('employee_id',$user_id)->where('batch',$batch)->get('erp_employee_subject')->result();
		}
    $this->load->view('template/hod/header');
    $this->load->view('template/hod/menubar');
    $this->load->view('template/hod/headerbar');
    $this->load->view('hod/attendance_report',$data);
    $this->load->view('template/hod/footer');
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
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->order_by('erp_existing_students.reg_no_','asc')
		->get('erp_existing_students')->result();
		
		if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->sem==1 OR $get_sub->sem==2)){
			$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=1 OR erp_existing_students.cour_id=2 OR erp_existing_students.cour_id=3)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->order_by('erp_existing_students.reg_no_','asc')
		->get('erp_existing_students')->result();
		}
			
	 	if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->subCode=='MS/20C/303A' OR $get_sub->subCode=='MS/20ID/305A' OR $get_sub->subCode=='MS/20C/203A' OR $get_sub->subCode=='MS/20E/206A' OR $get_sub->subCode=='MS/20C/403A')){
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=1 OR erp_existing_students.cour_id=2)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->order_by('erp_existing_students.reg_no_','asc')
		->get('erp_existing_students')->result();
		}
			
	 	if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->subCode=='MO/21C/101' OR $get_sub->subCode=='MS/20C/203B' OR $get_sub->subCode=='MH/2OC/104' OR $get_sub->subCode=='MS/20E/206B')){
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=3)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->order_by('erp_existing_students.reg_no_','asc')
		->get('erp_existing_students')->result();
		}
		
		$data['sub_list']=$this->db->where('employee_id',$user_id)->where('batch',$batch)->get('erp_employee_subject')->result();
		}
    $this->load->view('template/hod/header');
    $this->load->view('template/hod/menubar');
    $this->load->view('template/hod/headerbar');
    $this->load->view('hod/attendance_report_monthwise',$data);
    $this->load->view('template/hod/footer');
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
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->order_by('erp_existing_students.reg_no_','asc')
		->get('erp_existing_students')->result();
		
		if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->sem==1 OR $get_sub->sem==2)){
			$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=1 OR erp_existing_students.cour_id=2 OR erp_existing_students.cour_id=3)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->order_by('erp_existing_students.reg_no_','asc')
		->get('erp_existing_students')->result();
		}
			
	 	if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->subCode=='MS/20C/303A' OR $get_sub->subCode=='MS/20ID/305A' OR $get_sub->subCode=='MS/20C/203A' OR $get_sub->subCode=='MS/20E/206A' OR $get_sub->subCode=='MS/20C/403A')){
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=1 OR erp_existing_students.cour_id=2)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->order_by('erp_existing_students.reg_no_','asc')
		->get('erp_existing_students')->result();
		}
			
	 	if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->subCode=='MO/21C/101' OR $get_sub->subCode=='MS/20C/203B' OR $get_sub->subCode=='MH/2OC/104' OR $get_sub->subCode=='MS/20E/206B')){
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=3)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->order_by('erp_existing_students.reg_no_','asc')
		->get('erp_existing_students')->result();
		}
		
		$data['sub_list']=$this->db->where('employee_id',$user_id)->where('batch',$batch)->get('erp_employee_subject')->result();
		}
    $this->load->view('template/hod/header');
    $this->load->view('template/hod/menubar');
    $this->load->view('template/hod/headerbar');
    $this->load->view('hod/consolidated_report',$data);
    $this->load->view('template/hod/footer');
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
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->order_by('erp_existing_students.reg_no_','asc')
		->get('erp_existing_students')->result();
		
		if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->sem==1 OR $get_sub->sem==2)){
			$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=1 OR erp_existing_students.cour_id=2 OR erp_existing_students.cour_id=3)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->order_by('erp_existing_students.reg_no_','asc')
		->get('erp_existing_students')->result();
		}
			
	 	if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->subCode=='MS/20C/303A' OR $get_sub->subCode=='MS/20ID/305A' OR $get_sub->subCode=='MS/20C/203A' OR $get_sub->subCode=='MS/20E/206A' OR $get_sub->subCode=='MS/20C/403A')){
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=1 OR erp_existing_students.cour_id=2)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->order_by('erp_existing_students.reg_no_','asc')
		->get('erp_existing_students')->result();
		}
			
	 	if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->subCode=='MO/21C/101' OR $get_sub->subCode=='MS/20C/203B' OR $get_sub->subCode=='MH/2OC/104' OR $get_sub->subCode=='MS/20E/206B')){
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=3)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->order_by('erp_existing_students.reg_no_','asc')
		->get('erp_existing_students')->result();
		}
		}
		
	$this->load->view('template/hod/header');
    $this->load->view('template/hod/menubar');
    $this->load->view('template/hod/headerbar');
    $this->load->view('hod/icaReport',$data);
    $this->load->view('template/hod/footer');	
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
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->order_by('erp_existing_students.reg_no_','asc')
		->get('erp_existing_students')->result();
		
		if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->sem==1 OR $get_sub->sem==2)){
			$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=1 OR erp_existing_students.cour_id=2 OR erp_existing_students.cour_id=3)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->order_by('erp_existing_students.reg_no_','asc')
		->get('erp_existing_students')->result();
		}
			
	 	if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->subCode=='MS/20C/303A' OR $get_sub->subCode=='MS/20ID/305A' OR $get_sub->subCode=='MS/20C/203A' OR $get_sub->subCode=='MS/20E/206A' OR $get_sub->subCode=='MS/20C/403A')){
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=1 OR erp_existing_students.cour_id=2)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->order_by('erp_existing_students.reg_no_','asc')
		->get('erp_existing_students')->result();
		}
			
	 	if(($get_sub->stream==2 OR $get_sub->stream==3) AND ($get_sub->subCode=='MO/21C/101' OR $get_sub->subCode=='MS/20C/203B' OR $get_sub->subCode=='MH/2OC/104' OR $get_sub->subCode=='MS/20E/206B')){
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('(erp_existing_students.cour_id=3)')
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->order_by('erp_existing_students.reg_no_','asc')
		->get('erp_existing_students')->result();
		}
		
            $html = $this->load->view("hod/icaReportPDF", $data, true);
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
			
			$canvas = $dompdf->get_canvas();
$canvas->page_text(750, 550, "Page {PAGE_NUM} of {PAGE_COUNT}", "bold", 10, array(0,0,0));
$canvas->page_script('
  // $pdf is the variable containing a reference to the canvas object provided by dompdf
  $pdf->line(10,730,800,730,array(0,0,0),1);
');

            ob_end_clean();
            $dompdf->stream("ICAMARKSHEET_".$subj->subCode."_".$batch.".pdf", ["Attachment" => 1]);
		
    //$this->load->view('employee/icaReportPDF',$data);
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
	$this->load->view('template/hod/header');
    $this->load->view('template/hod/menubar');
    $this->load->view('template/hod/headerbar');
    $this->load->view('hod/iqac',$data);
    $this->load->view('template/hod/footer');
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
	redirect('hod/iqacForm','refresh');
		 }
		 
	$this->load->view('template/hod/header');
    $this->load->view('template/hod/menubar');
    $this->load->view('template/hod/headerbar');
    $this->load->view('hod/iqacForm',$data);
    $this->load->view('template/hod/footer');
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
	redirect('hod/iqacFormEdit/'.$id.'','refresh');
		 }
		 
	$this->load->view('template/hod/header');
    $this->load->view('template/hod/menubar');
    $this->load->view('template/hod/headerbar');
    $this->load->view('hod/iqacFormEdit',$data);
    $this->load->view('template/hod/footer');
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
	if((($part==1 OR $part==4) AND $stream==5) OR ($catg=='Elective') OR ($stream==2 OR $stream==3)){
		$this->db->where('erp_stu_attendance.subject_id',$subject);
		$this->db->where('erp_stu_attendance.main_id',$stream);
	}
	else{
		$this->db->where('erp_stu_attendance.main_id',$stream);
		$this->db->where('erp_stu_attendance.course_id',$department);
	}
	}
	
	$getatt=$this->db->select('erp_stu_attendance.user_id as emp, erp_subjectmaster.subName as subjectname, erp_employee_master.emp_name_ as empname')->join('erp_subjectmaster','erp_subjectmaster.id=erp_stu_attendance.subject_id','left')->join('erp_employee_master','erp_employee_master.id=erp_stu_attendance.user_id','left')->where('erp_stu_attendance.user_id != '.$user_id.'')->where('erp_stu_attendance.period',$period)->where('erp_stu_attendance.batch_year',$batch)->where('erp_stu_attendance.sem',$sem)->where('DATE_FORMAT(erp_stu_attendance.att_date,"%Y-%m-%d")',$add_date)->get('erp_stu_attendance')->row();
	
	$getatt1=$this->db->select('erp_stu_attendance.user_id as emp, erp_subjectmaster.subName as subjectname, erp_employee_master.emp_name_ as empname')->join('erp_subjectmaster','erp_subjectmaster.id=erp_stu_attendance.subject_id','left')->join('erp_employee_master','erp_employee_master.id=erp_stu_attendance.user_id','left')->where('erp_stu_attendance.user_id = '.$user_id.'')->where('erp_stu_attendance.subject_id != '.$subject.'')->where('erp_stu_attendance.period',$period)->where('DATE_FORMAT(erp_stu_attendance.att_date,"%Y-%m-%d")',$add_date)->get('erp_stu_attendance')->row();
	
	$data = array();
	if(isset($getatt)){
	$data['empname'] = 	$getatt->empname;
	$data['subname'] = 	$getatt->subjectname;
		$value=json_encode($data);
	}
	elseif(isset($getatt1)){
	$data['empname'] = 	$getatt1->empname;
	$data['subname'] = 	$getatt1->subjectname;
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
		$data['stream']=$stream;
		$data['department']=$department;
		//$data['subject']=$this->db->select('s.id,s.subName')->join('erp_subjectmaster s','s.id=e.subject_id')->where('e.employee_id',$user_id)->where('s.part',5)->get('erp_employee_subject e')->result();
		
		if(isset($_POST['submit'])){








/* 
			$data['stream']=$stream = $this->input->post('batch');
			$data['department']=$department = $this->input->post('batch'); */
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
		$get_sub = $this->db->where('id',$subject)->get('erp_subjectmaster')->row();
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		//->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->where('erp_existing_students.main_id',$get_sub->stream)
		->where('erp_existing_students.cour_id',$get_sub->department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		



/* echo"<pre>";
print_r($data['stu_list']);
exit;
 */


	//	$data['subject']=$this->db->select('s.id,s.subName')->join('erp_subjectmaster s','s.id=e.subject_id')->where('s.batch_year',$batch)->where('s.sem',$sem)->where('e.employee_id',$user_id)->where('s.part',5)->get('erp_employee_subject e')->result();
		
		if($get_sub->stream==5){
			$data['subject']= $this->db->select('s.id,s.subName')->join('erp_subjectmaster s','s.id=e.subject_id')->where('s.batch_year',$batch)->where('s.sem',$sem)->where('e.employee_id',$user_id)->where('s.part',5)->get('erp_employee_subject e')->result();	
			
			}else{
		
				//$data['subject'] = $this->db->select('s.id,s.subName')->join('erp_subjectmaster s','s.id=e.subject_id')->where('s.batch_year',$batch)->where('s.sem',$sem)->where('e.employee_id',$user_id)->where('s.part',3)->get('erp_employee_subject e')->result();	
				$data['subject'] = $this->db->select('s.id,s.subName')->join('erp_subjectmaster s','s.id=e.subject_id')->where('s.batch_year',$batch)->where('s.sem',$sem)->where('e.employee_id',$user_id)->where('s.subCatg','Record')->get('erp_employee_subject e')->result();
				
			}
	
	
	
	
	}
		
	$this->load->view('template/hod/header');
    $this->load->view('template/hod/menubar');
    $this->load->view('template/hod/headerbar');
    $this->load->view('hod/partvMarks',$data);
    $this->load->view('template/hod/footer');	
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
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		
			






		if($get_sub->stream==5){
			$data['subject']= $this->db->select('s.id,s.subName')->join('erp_subjectmaster s','s.id=e.subject_id')->where('s.batch_year',$batch)->where('s.sem',$sem)->where('e.employee_id',$user_id)->where('s.part',5)->get('erp_employee_subject e')->result();	
			
			}else{
		
				$data['subject'] = $this->db->select('s.id,s.subName')->join('erp_subjectmaster s','s.id=e.subject_id')->where('s.batch_year',$batch)->where('s.sem',$sem)->where('e.employee_id',$user_id)->where('s.part',3)->get('erp_employee_subject e')->result();	
				
			}
	
	
	}
		
	$this->load->view('template/hod/header');
    $this->load->view('template/hod/menubar');
    $this->load->view('template/hod/headerbar');
    $this->load->view('hod/partvMarksReport',$data);
    $this->load->view('template/hod/footer');	
	}
	
	public function getSubjecPartv()
	{
	echo $user_id=$this->session->userdata('user')['user_id'];
	$batch=$this->input->post('batch');
	$sem=$this->input->post('sem');
	$stream=$this->input->post('stream');
	if($stream==5){
	$sub = $this->db->select('s.id,s.subName')->join('erp_subjectmaster s','s.id=e.subject_id')->where('s.batch_year',$batch)->where('s.sem',$sem)->where('e.employee_id',$user_id)->where('s.part',5)->get('erp_employee_subject e')->result();	
	
	}else{

		$sub = $this->db->select('s.id,s.subName')->join('erp_subjectmaster s','s.id=e.subject_id')->where('s.batch_year',$batch)->where('s.sem',$sem)->where('e.employee_id',$user_id)->where('s.part',3)->get('erp_employee_subject e')->result();	
		
	}

//print_r($sub);

 $subject = '<option value="">Select Subject</option>';
	foreach($sub as $sub){
		$subject .= '<option value="'.$sub->id.'">'.$sub->subName.'</option>';
	}
	echo $subject; 
	}

}
