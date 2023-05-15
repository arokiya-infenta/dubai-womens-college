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
class Examiner extends CI_Controller {
	
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



	
	public function profile()
	{
		$data['user_id'] = $user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['examiner'] = $this->db->where('id',$user_id)->get('erp_examiners')->row();
		
		$user = $this->db->where('id',$user_id)->get('erp_employee_master')->row();
		$data['stream']=$user->emp_college_type_;
	    $data['department']=$user->emp_dept_name_;
	
		$config = array(
		array('field' => 'acc_no','label' => 'Account No.','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'bank_name','label' => 'Bank Name','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'bank_branch','label' => 'Branch','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'ifsc','label' => 'IFSC Code','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'first_name','label' => 'First Name','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'mobile','label' => 'Mobile No.','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'email','label' => 'Email','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'password','label' => 'Password','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
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
		  //'designation' => $this->input->post('designation'),
		  //'college' => $this->input->post('college'),
		  //'company' => $this->input->post('company'),
		  'first_name' => $this->input->post('first_name'),
		  'last_name' => $this->input->post('last_name'),
		  'dob' => $this->input->post('dob'),
		  'mobile' => $this->input->post('mobile'),
		  'email' => $this->input->post('email'),
		  'acc_no' => $this->input->post('acc_no'),
		  'bank_name' => $this->input->post('bank_name'),
		  'bank_branch' => $this->input->post('bank_branch'),
		  'ifsc' => $this->input->post('ifsc'),
		  'experience' => $this->input->post('experience'),
		  'password' => $this->input->post('password'),
		 );
		  
		  $this->db->where('id',$edit_id);
		$update = $this->db->update('erp_examiners',$data_edit);
		$data['msg']=$this->session->set_flashdata('success','Updated Successfully','success'); 
		redirect('examiner/profile','refresh');
		}
		 }		
		
    $this->load->view('template/examiner/header');
    $this->load->view('template/examiner/menubar');
    $this->load->view('template/examiner/headerbar');
    $this->load->view('examiner/profile',$data);
    $this->load->view('template/examiner/footer');
    }
	/*public function examinersDelete()
	{
		$data['user_id'] = $user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$id = $this->uri->segment(3);
		$delete = $this->db->where('id',$id)->delete('erp_examiners');
		$data['msg']=$this->session->set_flashdata('success','Deleted Successfully','success'); 
		redirect('hod/examiners','refresh');
	}*/
	
	public function do_upload_exm(){

    	$config = array();
		$config['upload_path'] = './system/images/examiner/';
		$config['allowed_types'] = '*';
		$config['remove_spaces'] = TRUE;
		$config['overwrite'] = TRUE;
		return $config;
		
        }
	public function qpaperUpload()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$user = $this->db->select('*')->where('id',$user_id)->get('erp_examiners')->row();
		
		$data['qpaper'] = $get = $this->db->select('erp_examiners_qpaper.*')
		->where('erp_examiners_qpaper.batch_year',$user->batch_year)
		->where('erp_examiners_qpaper.sem',$user->sem)
		->where('erp_examiners_qpaper.subject_id',$user->subject_id)
		->where('erp_examiners_qpaper.main_id',$user->main_id)
		->where('erp_examiners_qpaper.course_id',$user->course_id)
		->get('erp_examiners_qpaper')->row();
		 
	if(isset($_POST['upload'])){
			
			$edit_id = $this->input->post('edit_id');
			
	if($_FILES['qpaper']['size'] != 0) {
			$file_ext = pathinfo($_FILES["qpaper"]["name"], PATHINFO_EXTENSION);
			$NewImageName = rand().'_Qpaper.'.$file_ext;
			
			$_FILES["file"]["name"] = $NewImageName;
			$_FILES["file"]["type"] = $_FILES["qpaper"]["type"];
			$_FILES["file"]["tmp_name"] = $_FILES["qpaper"]["tmp_name"];
			$_FILES["file"]["error"] = $_FILES["qpaper"]["error"];
			$_FILES["file"]["size"] = $_FILES["qpaper"]["size"];

			$config = $this->do_upload_exm();
			$this->upload->initialize($config);
			if($this->upload->do_upload('file'))
			{
			 $ffff = $this->upload->data();
			  $image=$ffff['file_name'];
			  
			  $data_up['file'] = 'system/images/examiner/'.$NewImageName;
			  }
	 }
	 if($edit_id != ''){	 
		unlink($get->file);
	 $this->db->where('id',$edit_id);
	$result=$this->db->update('erp_examiners_qpaper',$data_up);	 
	$data['msg']=$this->session->set_flashdata('success','Edited Successfully','success');
	 }else{
		    $data_up['batch_id']=$user->batch_id;
	        $data_up['batch_year']=$user->batch_year;
			$data_up['subject_id']=$user->subject_id;
			$data_up['sem']=$user->sem;
			$data_up['main_id']=$user->main_id;
			$data_up['course_id']=$user->course_id;
			$data_up['user_id']=$user_id;
			$data_up['created_at']=$add_date;
	$result=$this->db->insert('erp_examiners_qpaper',$data_up);
	$data['msg']=$this->session->set_flashdata('success','Added Successfully','success');
	 }
	redirect('examiner/qpaperUpload','refresh');
		 }
		 
	$this->load->view('template/examiner/header');
    $this->load->view('template/examiner/menubar');
    $this->load->view('template/examiner/headerbar');
    $this->load->view('examiner/qpaperUpload',$data);
    $this->load->view('template/examiner/footer');
	}
	
	public function filesDownload()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$user = $this->db->select('*')->where('id',$user_id)->get('erp_examiners')->row();
		
		$data['syll_templ'] = $get = $this->db->select('erp_syllbs_templt.*')
		->where('erp_syllbs_templt.batch_year',$user->batch_year)
		->where('erp_syllbs_templt.sem',$user->sem)
		->where('erp_syllbs_templt.subject_id',$user->subject_id)
		->where('erp_syllbs_templt.main_id',$user->main_id)
		->where('erp_syllbs_templt.course_id',$user->course_id)
		->get('erp_syllbs_templt')->row();
		
		$data['inspection'] = $this->db->select('*')->get('erp_inspection')->row();
		 
	$this->load->view('template/examiner/header');
    $this->load->view('template/examiner/menubar');
    $this->load->view('template/examiner/headerbar');
    $this->load->view('examiner/filesDownload',$data);
    $this->load->view('template/examiner/footer');
	}

}
