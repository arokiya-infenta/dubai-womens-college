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
class Principal extends CI_Controller {
	
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

	
	}



	public function index()
	{
    $this->load->view('template/principal/header');
    $this->load->view('template/principal/menubar');
    $this->load->view('template/principal/headerbar');
    $this->load->view('principal/dashbord');
    $this->load->view('template/principal/footer');
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
				 redirect('principal/updatePassword','refresh');
			 }else{
				 $data['mesg']=$this->session->set_flashdata('form_err','New Password and Confirm Password does not match!!','danger');
				 redirect('principal/updatePassword','refresh');
			 }
		 }else{
			$data['mesg']=$this->session->set_flashdata('form_err','Old Password does not match!!','danger'); 
			redirect('principal/updatePassword','refresh');
		 }
		}
    $this->load->view('template/principal/header');
    $this->load->view('template/principal/menubar');
    $this->load->view('template/principal/headerbar');
    $this->load->view('principal/update_password',$data);
    $this->load->view('template/principal/footer');
    }
	
	public function blockHallTicket()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['stream']='';
		$data['department']='';
		$data['sem1']='';
		
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		//->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->get('erp_existing_students')->result();
		}
		
	$this->load->view('template/principal/header');
    $this->load->view('template/principal/menubar');
    $this->load->view('template/principal/headerbar');
    $this->load->view('principal/block_hallTicket',$data);
    $this->load->view('template/principal/footer');
    }
	
	public function blockHt()
	{
		
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$batch = $this->input->post('batch');
		$batch_id = $this->db->where('batch_from',$batch)->get('erp_batchmaster')->row();
		    $data['batch_id']=$batch_id->id;
		    $data['batch_year']=$batch;
			$data['type']='PRINCIPAL';
			$data['sem']=$sem = $this->input->post('sem');
			$data['main_id']=$stream = $this->input->post('stream');
			$data['course_id']=$department = $this->input->post('department');
			$data['student_id']=$student = $this->input->post('student');
			$data['status']= $this->input->post('status');
			$data['user_id']=$user_id;
			$data['created_at']=$add_date;
			
		$block_det = $this->db->where('type','PRINCIPAL')->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$student)->get('erp_block_halltickets')->row();
		if(isset($block_det)){
		$data_edit['status']= $this->input->post('status');	
		$this->db->where('id',$block_det->id);
		$update = $this->db->update('erp_block_halltickets',$data_edit);
		}else{
		$insert = $this->db->insert('erp_block_halltickets',$data);
		}
		echo 'Success';
    }
	
	public function grievances()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['sem1']='';
		$data['stream']='';
		$data['department']='';
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
		$data['stu_list'] = $this->db->select('erp_existing_students.id as student_id,erp_existing_students.student_name_,erp_grievance.*')
		->join('erp_existing_students','erp_grievance.student_id=erp_existing_students.id','left')
		->where('erp_grievance.batch_year',$batch)
		->where('erp_grievance.subject_id',$subject)
		->where('erp_grievance.main_id',$stream)
		->where('erp_grievance.course_id',$department)
		->where('erp_grievance.status','open')
		->where('now() BETWEEN erp_grievance.created_at and date_add(erp_grievance.created_at,interval 10 day)')
		->order_by('erp_grievance.id','desc')
		->get('erp_grievance')->result();
		}
		
	$this->load->view('template/principal/header');
    $this->load->view('template/principal/menubar');
    $this->load->view('template/principal/headerbar');
    $this->load->view('principal/grievances',$data);
    $this->load->view('template/principal/footer');	
	}
	
	public function updateGrievance()
	{
	$data['principal_id']=$user_id=$this->session->userdata('user')['user_id'];
	$id=$this->input->post('grievance_id');
	$data['grievance_solution']=$this->input->post('solution');
	$data['status']=$this->input->post('status');
	$data1['ica']=$icamrk=$this->input->post('ica');if($icamrk==''){$data1['ica']=0;}
	$data1['internal']=$internal=$this->input->post('internal');if($internal==''){$data1['internal']=0;}
	$data1['external']=$external=$this->input->post('external');if($external==''){$data1['external']=0;}
	$data1['thirdparty']=$thirdparty=$this->input->post('thirdparty');if($thirdparty==''){$data1['thirdparty']=0;}
	$data1['average']=$mark=$this->input->post('average');
	$mark_id=$this->input->post('mark_id');
	$stream=$this->input->post('stream');
	
	$this->db->where('id',$id);
    $this->db->update('erp_grievance',$data);
	
	/*if($stream == 5){$rng = $this->db->where('main_id','UG')->get('erp_moderationrange')->row(); $mrk=40;}
	  else{$rng = $this->db->where('main_id','PG')->get('erp_moderationrange')->row(); $mrk=50;}
	  if(isset($rng)){ 
		$range_from = $rng->range_from;
		$range_to = $rng->range_to;
		if($mark >= $range_from && $mark <= $range_to){ 
	$data1['moderate_status']=1;
	$data1['moderated_mark']=$mrk;
		}else{
	$data1['moderate_status']=0;
	$data1['moderated_mark']='';		
		}
	  }*/
	
	if($stream == 5){
	  if($icamrk >= 40 && $mark >= 40){$data1['result'] = 'P';}
		else{
		 if($icamrk >= 40 && $mark < 40){$data1['result'] = 'R(E)';}
		 elseif($icamrk < 40 && $mark >= 40){$data1['result'] = 'R(I)';}
		 else{$data1['result'] = 'R(I + E)';}
	   }
	}else{
	  if($icamrk >= 50 && $mark >= 50){$data1['result'] = 'P';}
		else{
		 if($icamrk >= 50 && $mark < 50){$data1['result'] = 'R(E)';}
		 elseif($icamrk < 50 && $mark >= 50){$data1['result'] = 'R(I)';}
		 else{$data1['result'] = 'R(I + E)';}
		}
	  }
	$data1['grievance_status']=1;
		
      $this->db->where('id',$mark_id);
      $this->db->update('erp_exammarkfinal',$data1);	
	  
	echo 'Success';
    }
	
	public function getProgram()
	{
	$stream=$this->input->post('stream');
	
	$dept = $this->db->where('main_id',$stream)->get('department_details')->result();	
	
	$department = '<option value="">Select Department</option>';
	foreach($dept as $dept){
		$department .= '<option value="'.$dept->cour_id.'">'.$dept->comp_name.'</option>';
	}
	echo $department;
    }
	
	public function getSubjSemwise()
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
	
	public function studentResume()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['stream']='';
		$data['department']='';
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
		$data['stu_list'] = $this->db->select('erp_existing_students.id as student_id,erp_existing_students.student_name_,erp_existing_students.reg_no_,upload_stu_resume.r_resume as resume')
		->join('erp_existing_students','upload_stu_resume.r_stu_ad_id=erp_existing_students.id')
		->where('upload_stu_resume.r_main_id',$stream)
		->where('upload_stu_resume.r_cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->get('upload_stu_resume')->result();
		}
		
	$this->load->view('template/principal/header');
    $this->load->view('template/principal/menubar');
    $this->load->view('template/principal/headerbar');
    $this->load->view('principal/studentResume',$data);
    $this->load->view('template/principal/footer');	
	}
	
	public function feedbackStatusReport()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['sem1']='';
		$data['stream']='';
		$data['department']='';
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
		$data['stu_list'] = $this->db->select('erp_existing_students.id as student_id,erp_existing_students.student_name_,erp_existing_students.reg_no_')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->get('erp_existing_students')->result();
		}
		
	$this->load->view('template/principal/header');
    $this->load->view('template/principal/menubar');
    $this->load->view('template/principal/headerbar');
    $this->load->view('principal/feedbackStatusReport',$data);
    $this->load->view('template/principal/footer');	
	}
	
	public function feedbackTeacherReport()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']=array();
		$data['sem1']='';
		$data['stream']='';
		$data['department']='';
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
		
			$data['subject1']=$this->db->where('batch_year',$batch)->where('sem',$sem)->where('stream',$stream)->where('department',$department)->get('erp_subjectmaster')->result();
		}
		
	$this->load->view('template/principal/header');
    $this->load->view('template/principal/menubar');
    $this->load->view('template/principal/headerbar');
    $this->load->view('principal/feedbackTeacherReport',$data);
    $this->load->view('template/principal/footer');	
	}
	
	public function feedbackSubjectReport()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['sem1']='';
		$data['stream']='';
		$data['department']='';
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
		
		$data['feedbacks'] = $this->db->get('feedback_course_teacher')->result();
		}
		
	$this->load->view('template/principal/header');
    $this->load->view('template/principal/menubar');
    $this->load->view('template/principal/headerbar');
    $this->load->view('principal/feedbackSubjectReport',$data);
    $this->load->view('template/principal/footer');	
	}
	
	public function feedbackAllSubjectReport()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['sem1']='';
		$data['stream']='';
		$data['department']='';
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
		
		$data['feedbacks'] = $this->db->get('feedback_course_teacher')->result();
		$data['subject']=$this->db->where('sem',$sem)->where('batch_year',$batch)->where('stream',$stream)->where('department',$department)->get('erp_subjectmaster')->result();  
		}
		
	$this->load->view('template/principal/header');
    $this->load->view('template/principal/menubar');
    $this->load->view('template/principal/headerbar');
    $this->load->view('principal/feedbackAllSubjectReport',$data);
    $this->load->view('template/principal/footer');	
	}
	
	public function feedbackFacilitiesReport()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['sem1']='';
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['sem1']=$sem = $this->input->post('sem');
		
		$data['feedbacks'] = $this->db->where('id_f > 13')->get('feedback_course_teacher')->result();
		}
		
	$this->load->view('template/principal/header');
    $this->load->view('template/principal/menubar');
    $this->load->view('template/principal/headerbar');
    $this->load->view('principal/feedbackFacilitiesReport',$data);
    $this->load->view('template/principal/footer');	
	}
	
	public function leave()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['leave_list']=$this->db->select('l.*,e.emp_name_')->join('erp_employee_master e','l.emp_code=e.id','left')
		->where('e.emp_designation_ !=','30')->order_by('l.leave_id','desc')->get('wy_leaves l')->result();
		
	$this->load->view('template/principal/header');
    $this->load->view('template/principal/menubar');
    $this->load->view('template/principal/headerbar');
    $this->load->view('principal/leave',$data);
    $this->load->view('template/principal/footer');	
	}
	
	public function leaveApprove()
	{
	$data['principal_id']=$user_id=$this->session->userdata('user')['user_id'];
	$id=$this->input->post('leave_id');
	$data['leave_status_principal']=$this->input->post('status');
	
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
//}
	
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
		$data['iqac_list']=$this->db->where('(event_date >= "'.$from.'" AND event_date <= "'.$to.'")')->get('iqac')->result();
		}
	$this->load->view('template/principal/header');
    $this->load->view('template/principal/menubar');
    $this->load->view('template/principal/headerbar');
    $this->load->view('principal/iqac',$data);
    $this->load->view('template/principal/footer');
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
		 
		 
	$this->load->view('template/principal/header');
    $this->load->view('template/principal/menubar');
    $this->load->view('template/principal/headerbar');
    $this->load->view('principal/iqacFormEdit',$data);
    $this->load->view('template/principal/footer');
	}
}
