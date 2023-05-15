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
class Hostellogin extends CI_Controller {
	
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
		$this->load->library('session');
	
	}

	public function index()
	{
		$data['msg']="";
    $this->load->view('hostel/template/header');
    $this->load->view('hostel/edashboard',$data);
    $this->load->view('hostel/template/footer');
    }
	public function logOut(){
		$this->session->unset_userdata('user'); 
		redirect('employee_login', 'refresh');
	}
	public function announcement()
	{
		$data['user']='';
    $this->load->view('alumni/template/header');
    $this->load->view('alumni/announcement',$data);
    $this->load->view('alumni/template/footer');
    }
	public function addAnnouncement()
	{
		if(isset($_POST['addann']))
{
	$annid=$_POST['aid'];
	$annname=$_POST['aname'];
	$anndesc=$_POST['adesc'];
	$anntime=date("Y-m-d h:i:sa");
	
	if ($annid=='' || $annname=='' || $anndesc=='')
	{
		$data['error']=$this->session->set_flashdata('error','Please fill all the fields','success');	
		redirect('alumnilogin/addAnnouncement','refresh');
	}
	else
	{
				$sql = "INSERT INTO announcement (ann_id, ann_name, ann_desc, ann_time) VALUES('$annid', '$annname', '$anndesc', '$anntime')";
				if ($this->db->query($sql) === TRUE) 
				{
	    			$data['msg']=$this->session->set_flashdata('msg','Announcement added successfully','success');	
                    redirect('alumnilogin/announcement','refresh');
				} 
				else 
				{
					$data['error']=$this->session->set_flashdata('error',''.$this->db->error().'','success');	
                    redirect('alumnilogin/announcement','refresh');
				}
		
	}	
  }
    $this->load->view('alumni/template/header');
    $this->load->view('alumni/add_announcement');
    $this->load->view('alumni/template/footer');
    }
	public function deleteAnnouncement()
	{
		$annid = $this->uri->segment(3);
				$sql = "DELETE from announcement where ann_id = '$annid' ";
				if ($this->db->query($sql) === TRUE) 
				{
	    			$data['delete']=$this->session->set_flashdata('delete','Announcement deleted successfully','success');	
                    redirect('alumnilogin/announcement','refresh');
				} 
				else 
				{
					$data['error']=$this->session->set_flashdata('error',''.$this->db->error().'','success');	
                    redirect('alumnilogin/announcement','refresh');
				}
		
	}	
}
