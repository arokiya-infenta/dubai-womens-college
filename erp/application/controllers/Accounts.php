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
class Accounts extends CI_Controller {
	
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
    $this->load->view('template/accounts/header');
    $this->load->view('template/accounts/menubar');
    $this->load->view('template/accounts/headerbar');
    $this->load->view('accounts/dashbord');
    $this->load->view('template/accounts/footer');
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
		
	$this->load->view('template/accounts/header');
    $this->load->view('template/accounts/menubar');
    $this->load->view('template/accounts/headerbar');
    $this->load->view('accounts/block_hallTicket',$data);
    $this->load->view('template/accounts/footer');
    }
	
	public function blockHt()
	{
		
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$batch = $this->input->post('batch');
		$batch_id = $this->db->where('batch_from',$batch)->get('erp_batchmaster')->row();
		    $data['batch_id']=$batch_id->id;
		    $data['batch_year']=$batch;
			$data['type']='ACCOUNTS';
			$data['sem']=$sem = $this->input->post('sem');
			$data['main_id']=$stream = $this->input->post('stream');
			$data['course_id']=$department = $this->input->post('department');
			$data['student_id']=$student = $this->input->post('student');
			$data['status']= $this->input->post('status');
			$data['user_id']=$user_id;
			$data['created_at']=$add_date;
			
		$block_det = $this->db->where('type','ACCOUNTS')->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$student)->get('erp_block_halltickets')->row();
		if(isset($block_det)){
		$data_edit['status']= $this->input->post('status');	
		$this->db->where('id',$block_det->id);
		$update = $this->db->update('erp_block_halltickets',$data_edit);
		}else{
		$insert = $this->db->insert('erp_block_halltickets',$data);
		}
		echo 'Success';
    }
}
