<?php
//error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
//require APPPATH . '/libraries/dompdf/autoload.inc.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
	use Dompdf\Dompdf;
	use Dompdf\Options;
class Placement extends CI_Controller {
	
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
				 redirect('placement','refresh');
			 }else{
				 $data['mesg']=$this->session->set_flashdata('form_err','New Password and Confirm Password does not match!!','danger');
				 redirect('placement','refresh');
			 }
		 }else{
			$data['mesg']=$this->session->set_flashdata('form_err','Old Password does not match!!','danger'); 
			redirect('placement','refresh');
		 }
		}
    $this->load->view('template/placement/header');
    $this->load->view('template/placement/menubar');
    $this->load->view('template/placement/headerbar');
    $this->load->view('placement/dashbord',$data);
    $this->load->view('template/placement/footer');
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
		
	$this->load->view('template/placement/header');
    $this->load->view('template/placement/menubar');
    $this->load->view('template/placement/headerbar');
    $this->load->view('placement/studentResume',$data);
    $this->load->view('template/placement/footer');	
	}
}
