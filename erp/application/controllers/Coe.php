<?php
//require FCPATH.'hostelassets/inc/handyCam.php';
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
class Coe extends CI_Controller {
	
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
        
		if ($this->session->userdata('user')['user_designation'] != 6) {
            redirect("employee_login", "refresh");
        }
	
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
				 redirect('coe','refresh');
			 }else{
				 $data['mesg']=$this->session->set_flashdata('form_err','New Password and Confirm Password does not match!!','danger');
				 redirect('coe','refresh');
			 }
		 }else{
			$data['mesg']=$this->session->set_flashdata('form_err','Old Password does not match!!','danger'); 
			redirect('coe','refresh');
		 }
		}
    $this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/dashbord',$data);
    $this->load->view('template/coe/footer');
    }
	public function addSubject1()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$add_data=date('Y-m-d');
		$data['stream']='';
		$data['department']='';
		$data['subject_list']=$this->db->get('erp_subject')->result();
		$config = array(
        array(
                'field' => 'subject',
                'label' => 'Subject Name',
                'rules' => 'required|is_unique[erp_subject.sub_name_]',
				'errors' => array(
                        'required' => 'You must provide a %s.',
						'is_unique' => 'This %s already exists.'
						),
        ),
		);
		if(isset($_POST['submit_add'])){
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) { 
         $data['form_err']=$this->session->set_flashdata('form_err','Subject Name Already Exists','warning'); 
         } 
         else { 
			$data_add['sub_name_']=$this->input->post('subject');
			$data_add['shift_']=$this->input->post('stream');
			$data_add['dept_']=$this->input->post('department');
			$data_add['created_by']=$user_id;
			$data_add['created_at']=$add_data;
		$insert = $this->db->insert('erp_subject',$data_add);
		redirect('coe/addSubject','refresh');
		}
		 }
        if(isset($_POST['submit_edit'])){
			$data_upd['sub_name_']=$this->input->post('subject_edit');
			$data_upd['shift_']=$this->input->post('stream_edit');
			$data_upd['dept_']=$this->input->post('department_edit');
			$data_upd['created_by']=$user_id;
			$this->db->where('id',$this->input->post('edit_id'));
		$update = $this->db->update('erp_subject',$data_upd);	
		redirect('coe/addSubject','refresh');
		}			
		
    $this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/add_subject1',$data);
    $this->load->view('template/coe/footer');
    }
	public function updateSubject()
	{
	$id=$this->input->post('id');
	$subject=$this->db->where('id',$id)->get('erp_subject')->row();
	echo json_encode($subject);
    }
public function do_upload_exm(){

    	$config = array();
		$config['upload_path'] = './system/images/examiner/';
		$config['allowed_types'] = '*';
		$config['remove_spaces'] = TRUE;
		$config['overwrite'] = TRUE;
		return $config;
		
        }
		public function getPgrm()
	{
	$stream=$this->input->post('stream');
	if($stream==1){
    $dept = $this->db->where('college_type_','Aided')->get('erp_department')->result();	}
	else{
	$dept = $this->db->where('college_type_','Self Finance')->get('erp_department')->result();	
	}
	$department = '<option value="">Select Department</option>';
	foreach($dept as $dept){
		$department .= '<option value="'.$dept->id.'">'.$dept->dept_name_.'</option>';
	}
	echo $department;
    }
	public function subjectPolicy()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['policy_list']=$this->db->where('user_id',$user_id)->get('erp_subpolicy')->result();
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/subject_policy',$data);
    $this->load->view('template/coe/footer');	
	}
	public function addPolicy()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['policy_list']=$this->db->get('erp_subpolicy')->result();
		$config = array(
        array(
                'field' => 'name',
                'label' => 'Policy Name',
                'rules' => 'required|is_unique[erp_subpolicy.name]',
				'errors' => array(
                        'required' => 'You must provide a %s.',
						'is_unique' => 'This %s already exists.'
						),
        ),
		/*array('field' => 'name','label' => 'Policy Name','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'minMark','label' => 'Minimum Pass Mark','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'eseMaxMark','label' => 'ESE Max Mark','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'eseMinMark','label' => 'ESE Min Mark','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'eseMarkEntry','label' => 'ESE Mark Entry','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'icaMaxMark','label' => 'ICA Max Mark','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'icaMinMark','label' => 'ICA Min Mark','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'icaMarkEntry','label' => 'ICA Mark Entry','rules' => 'required','errors' => array('required' => 'You must provide a %s.',))*/
		);
		if(isset($_POST['submit'])){
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) { 
         $data['form_err']=$this->session->set_flashdata('form_err','Please check all the details','warning'); 
         } 
         else { 
		 if($this->input->post('hasESE')==''){$hasESE='no';}else{$hasESE='yes';}
		 if($this->input->post('hasICA')==''){$hasICA='no';}else{$hasICA='yes';}
		 if($this->input->post('intMark')==''){$intMark='no';}else{$intMark='yes';}
		 if($this->input->post('inCls')==''){$inCls='no';}else{$inCls='yes';}
		 if($this->input->post('intExam')==''){$intExam='no';}else{$intExam='yes';}
		 if($this->input->post('attendance')==''){$attendance='no';}else{$attendance='yes';}
		 if($this->input->post('takeHome')==''){$takeHome='no';}else{$takeHome='yes';}
		 if($this->input->post('onlyICA')==''){$onlyICA='no';}else{$onlyICA='yes';}
		 if($this->input->post('clsQuiz')==''){$clsQuiz='no';}else{$clsQuiz='yes';}
		 if($this->input->post('grpProj')==''){$grpProj='no';}else{$grpProj='yes';}
		 if($this->input->post('assgnmnts')==''){$assgnmnts='no';}else{$assgnmnts='yes';}
		 if($this->input->post('exam')==''){$exam='no';}else{$exam='yes';}
		 if($this->input->post('midTerm')==''){$midTerm='no';}else{$midTerm='yes';}
		 if($this->input->post('semExxam')==''){$semExxam='no';}else{$semExxam='yes';}
		 $data_add = array(
		  'name' => $this->input->post('name'),
		  'minMark' => $this->input->post('minMark'),
		  'hasESE' => $hasESE,
		  'eseMaxMark' => $this->input->post('eseMaxMark'),
		  'eseMinMark' => $this->input->post('eseMinMark'),
		  'eseMarkEntry' => $this->input->post('eseMarkEntry'),
		  'hasICA' => $hasICA,
		  'icaMaxMark' => $this->input->post('icaMaxMark'),
		  'icaMinMark' => $this->input->post('icaMinMark'),
		  'icaMarkEntry' => $this->input->post('icaMarkEntry'),
		  'intMark' => $intMark,
		  'inCls' => $inCls,
		  'intExam' => $intExam,
		  'attendance' => $attendance,
		  'takeHome' => $takeHome,
		  'onlyICA' => $onlyICA,
		  'clsQuiz' => $clsQuiz,
		  'grpProj' => $grpProj,
		  'assgnmnts' => $assgnmnts,
		  'exam' => $exam,
		  'midTerm' => $midTerm,
		  'semExxam' => $semExxam,
		  'clsTestAlc' => $this->input->post('clsTestAlc'),
		  'clsTestMin' => $this->input->post('clsTestMin'),
		  'intAlc' => $this->input->post('intAlc'),
		  'intMin' => $this->input->post('intMin'),
		  'attAlc' => $this->input->post('attAlc'),
		  'attMin' => $this->input->post('attMin'),
		  'THassAlc' => $this->input->post('THassAlc'),
		  'THassMin' => $this->input->post('THassMin'),
		  'icaAlc' => $this->input->post('icaAlc'),
		  'icaMin' => $this->input->post('icaMin'),
		  'quizAlc' => $this->input->post('quizAlc'),
		  'quizMin' => $this->input->post('quizMin'),
		  'projAlc' => $this->input->post('projAlc'),
		  'projMin' => $this->input->post('projMin'),
		  'assignAlc' => $this->input->post('assignAlc'),
		  'assignMin' => $this->input->post('assignMin'),
		  'examAlc' => $this->input->post('examAlc'),
		  'examMin' => $this->input->post('examMin'),
		  'midTermAlc' => $this->input->post('midTermAlc'),
		  'minTermMin' => $this->input->post('minTermMin'),
		  'semAlc' => $this->input->post('semAlc'),
		  'semMin' => $this->input->post('semMin'),
		  'user_id' => $user_id,
		  'add_date' => $add_date,
		 );
		  
		$insert = $this->db->insert('erp_subpolicy',$data_add);
		$id = $this->db->insert_id();
		
		$mark = $this->input->post('mark');
		if(isset($mark) && sizeof($mark)>0){
		$mark = $this->input->post('mark');
		$percFrom = $this->input->post('percFrom');
		$percTo = $this->input->post('percTo');
		for($i=0; $i<sizeof($mark); $i++){
			$data_add = array(
		  'policy_id' => $id,
		  'mark' => $mark[$i],
		  'percFrom' => $percFrom[$i],
		  'percTo' => $percTo[$i],
		  'user_id' => $user_id,
		  'add_date' => $add_date,
		 );
		 $insert = $this->db->insert('erp_subpolicymark',$data_add);
		}
		}
		$data['msg']=$this->session->set_flashdata('success','Added Successfully','success'); 
		redirect('coe/subjectPolicy','refresh');
		}
		 }		
		
    $this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/add_policy',$data);
    $this->load->view('template/coe/footer');
    }
	public function editPolicy()
	{
		$edit_id = $this->uri->segment(3);
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['policy_list']=$this->db->where('id',$edit_id)->get('erp_subpolicy')->row();
		$config = array(
        array(
                'field' => 'name',
                'label' => 'Policy Name',
                'rules' => 'required',
				'errors' => array(
                        'required' => 'You must provide a %s.',
						),
        ),
		/*array('field' => 'name','label' => 'Policy Name','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'minMark','label' => 'Minimum Pass Mark','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'eseMaxMark','label' => 'ESE Max Mark','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'eseMinMark','label' => 'ESE Min Mark','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'eseMarkEntry','label' => 'ESE Mark Entry','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'icaMaxMark','label' => 'ICA Max Mark','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'icaMinMark','label' => 'ICA Min Mark','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'icaMarkEntry','label' => 'ICA Mark Entry','rules' => 'required','errors' => array('required' => 'You must provide a %s.',))*/
		);
		if(isset($_POST['submit'])){
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) { 
         $data['form_err']=$this->session->set_flashdata('form_err','Please check all the details','warning'); 
         } 
         else { 
		 if($this->input->post('hasESE')==''){$hasESE='no';}else{$hasESE='yes';}
		 if($this->input->post('hasICA')==''){$hasICA='no';}else{$hasICA='yes';}
		 if($this->input->post('intMark')==''){$intMark='no';}else{$intMark='yes';}
		 if($this->input->post('inCls')==''){$inCls='no';}else{$inCls='yes';}
		 if($this->input->post('intExam')==''){$intExam='no';}else{$intExam='yes';}
		 if($this->input->post('attendance')==''){$attendance='no';}else{$attendance='yes';}
		 if($this->input->post('takeHome')==''){$takeHome='no';}else{$takeHome='yes';}
		 if($this->input->post('onlyICA')==''){$onlyICA='no';}else{$onlyICA='yes';}
		 if($this->input->post('clsQuiz')==''){$clsQuiz='no';}else{$clsQuiz='yes';}
		 if($this->input->post('grpProj')==''){$grpProj='no';}else{$grpProj='yes';}
		 if($this->input->post('assgnmnts')==''){$assgnmnts='no';}else{$assgnmnts='yes';}
		 if($this->input->post('exam')==''){$exam='no';}else{$exam='yes';}
		 if($this->input->post('midTerm')==''){$midTerm='no';}else{$midTerm='yes';}
		 if($this->input->post('semExxam')==''){$semExxam='no';}else{$semExxam='yes';}
		 $edit_id = $this->input->post('edit_id');
		 $data_up = array(
		  'name' => $this->input->post('name'),
		  'minMark' => $this->input->post('minMark'),
		  'hasESE' => $hasESE,
		  'eseMaxMark' => $this->input->post('eseMaxMark'),
		  'eseMinMark' => $this->input->post('eseMinMark'),
		  'eseMarkEntry' => $this->input->post('eseMarkEntry'),
		  'hasICA' => $hasICA,
		  'icaMaxMark' => $this->input->post('icaMaxMark'),
		  'icaMinMark' => $this->input->post('icaMinMark'),
		  'icaMarkEntry' => $this->input->post('icaMarkEntry'),
		  'intMark' => $intMark,
		  'inCls' => $inCls,
		  'intExam' => $intExam,
		  'attendance' => $attendance,
		  'takeHome' => $takeHome,
		  'onlyICA' => $onlyICA,
		  'clsQuiz' => $clsQuiz,
		  'grpProj' => $grpProj,
		  'assgnmnts' => $assgnmnts,
		  'exam' => $exam,
		  'midTerm' => $midTerm,
		  'semExxam' => $semExxam,
		  'clsTestAlc' => $this->input->post('clsTestAlc'),
		  'clsTestMin' => $this->input->post('clsTestMin'),
		  'intAlc' => $this->input->post('intAlc'),
		  'intMin' => $this->input->post('intMin'),
		  'attAlc' => $this->input->post('attAlc'),
		  'attMin' => $this->input->post('attMin'),
		  'THassAlc' => $this->input->post('THassAlc'),
		  'THassMin' => $this->input->post('THassMin'),
		  'icaAlc' => $this->input->post('icaAlc'),
		  'icaMin' => $this->input->post('icaMin'),
		  'quizAlc' => $this->input->post('quizAlc'),
		  'quizMin' => $this->input->post('quizMin'),
		  'projAlc' => $this->input->post('projAlc'),
		  'projMin' => $this->input->post('projMin'),
		  'assignAlc' => $this->input->post('assignAlc'),
		  'assignMin' => $this->input->post('assignMin'),
		  'examAlc' => $this->input->post('examAlc'),
		  'examMin' => $this->input->post('examMin'),
		  'midTermAlc' => $this->input->post('midTermAlc'),
		  'minTermMin' => $this->input->post('minTermMin'),
		  'semAlc' => $this->input->post('semAlc'),
		  'semMin' => $this->input->post('semMin'),
		  //'user_id' => $user_id,
		  //'add_date' => $add_date,
		 );
		  $this->db->where('id',$edit_id);
		$update = $this->db->update('erp_subpolicy',$data_up);
		
		$this->db->where('policy_id',$edit_id)->delete('erp_subpolicymark');
		$mark = $this->input->post('mark');
		if(isset($mark) && sizeof($mark)>0){
		$mark = $this->input->post('mark');
		$percFrom = $this->input->post('percFrom');
		$percTo = $this->input->post('percTo');
		for($i=0; $i<sizeof($mark); $i++){
			$data_add = array(
		  'policy_id' => $edit_id,
		  'mark' => $mark[$i],
		  'percFrom' => $percFrom[$i],
		  'percTo' => $percTo[$i],
		  'user_id' => $user_id,
		  'add_date' => $add_date,
		 );
		 $insert = $this->db->insert('erp_subpolicymark',$data_add);
		}
		}
		$data['msg']=$this->session->set_flashdata('success','Updated Successfully','success'); 
		redirect('coe/subjectPolicy','refresh');
		}
		 }		
		
    $this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/edit_policy',$data);
    $this->load->view('template/coe/footer');
    }
	public function deletePolicy()
	{
		$edit_id = $this->uri->segment(3);
		$delete = $this->db->where('id',$edit_id)->delete('erp_subpolicy');
		$delete = $this->db->where('policy_id',$edit_id)->delete('erp_subpolicymark');
		$data['msg']=$this->session->set_flashdata('success','Deleted Successfully','success'); 
		redirect('coe/subjectPolicy','refresh');
	}
	
	
	public function regulation()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['reg_list']=$this->db->where('user_id',$user_id)->get('erp_regulation')->result();
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/regulation',$data);
    $this->load->view('template/coe/footer');	
	}
	public function addRegulation()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['policy_list']=$this->db->get('erp_subpolicy')->result();
		$config = array(
        array(
                'field' => 'name',
                'label' => 'Regulation Name',
                'rules' => 'required|is_unique[erp_regulation.name]',
				'errors' => array(
                        'required' => 'You must provide a %s.',
						'is_unique' => 'This %s already exists.'
						),
        ),
		array('field' => 'fromYr','label' => 'From Year','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'toYr','label' => 'To Year','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		);
		if(isset($_POST['submit'])){
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) { 
         $data['form_err']=$this->session->set_flashdata('form_err','Please check all the details','warning'); 
         } 
         else { 
		 $data_add = array(
		  'name' => $this->input->post('name'),
		  'desc' => $this->input->post('desc'),
		  'fromYr' => $this->input->post('fromYr'),
		  'toYr' => $this->input->post('toYr'),
		  'user_id' => $user_id,
		  'add_date' => $add_date,
		 );
		  
		$insert = $this->db->insert('erp_regulation',$data_add);
		$data['msg']=$this->session->set_flashdata('success','Added Successfully','success'); 
		redirect('coe/regulation','refresh');
		}
		 }		
		
    $this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/add_regulation',$data);
    $this->load->view('template/coe/footer');
    }
	public function editRegulation()
	{
		$edit_id = $this->uri->segment(3);
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['reg_list']=$this->db->where('id',$edit_id)->get('erp_regulation')->row();
		$config = array(
        array(
                'field' => 'name',
                'label' => 'Policy Name',
                'rules' => 'required|is_unique[erp_subpolicy.name]',
				'errors' => array(
                        'required' => 'You must provide a %s.',
						'is_unique' => 'This %s already exists.'
						),
        ),
		array('field' => 'fromYr','label' => 'From Year','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'toYr','label' => 'To Year','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		);
		if(isset($_POST['submit'])){
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) { 
         $data['form_err']=$this->session->set_flashdata('form_err','Please check all the details','warning'); 
         } 
         else { 
		 $edit_id = $this->input->post('edit_id');
		 $data_up = array(
		  'name' => $this->input->post('name'),
		  'desc' => $this->input->post('desc'),
		  'fromYr' => $this->input->post('fromYr'),
		  'toYr' => $this->input->post('toYr'),
		 );
		  $this->db->where('id',$edit_id);
		$update = $this->db->update('erp_regulation',$data_up);
		$data['msg']=$this->session->set_flashdata('success','Updated Successfully','success'); 
		redirect('coe/regulation','refresh');
		}
		 }		
		
    $this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/edit_regulation',$data);
    $this->load->view('template/coe/footer');
    }
	public function deleteRegulation()
	{
		$edit_id = $this->uri->segment(3);
		$delete = $this->db->where('id',$edit_id)->delete('erp_regulation');
		$data['msg']=$this->session->set_flashdata('success','Deleted Successfully','success'); 
		redirect('coe/regulation','refresh');
	}
	
	public function subject()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['batch_list']=$this->db->get('erp_batchmaster')->result();
		
		if(isset($_POST['batch_submit'])){
			$batch = $data['batch_id'] = $this->input->post('batch');
			$sem = $data['sem'] = $this->input->post('sem');
		//$data['sub_list']=$this->db->where('user_id',$user_id)->where('batch_id',$batch)->order_by('subCode','asc')->get('erp_subjectmaster')->result();
		$data['sub_list']=$this->db->where('batch_id',$batch)->order_by('subCode','asc')->get('erp_subjectmaster')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/subject',$data);
    $this->load->view('template/coe/footer');	
	}
	public function createSubject()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$batch_id = $this->input->post('batch_edit');
		$batch = $this->db->where('id',$batch_id)->get('erp_batchmaster')->row();
		$year = '01-01-'.$batch->batch_from;
		$new_batch  =  date("Y",strtotime($year . "-1 year"));
		$sub=$this->db->where('batch_year',$new_batch)->get('erp_subjectmaster')->result();
		if(sizeof($sub)>0){
		foreach($sub as $sub){
			unset($sub->id);
		$insert = $this->db->insert('erp_subjectmaster',$sub);
		$insert_id=$this->db->insert_id();
		
		$data_up['batch_id']=$batch_id;
		$data_up['batch_year']=$year;
		$data_up['user_id']=$user_id;
		$data_up['add_date']=$add_date;
		$this->db->where('id',$insert_id);
		$this->db->update('erp_subjectmaster',$data_up);
		}
		}
		$data['msg']=$this->session->set_flashdata('success','Subjects Created Successfully','success'); 
		redirect('coe/subject','refresh');
	}
	public function addSubject()
	{
		$data['batch_id']=$this->uri->segment(3);
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['sub_list']=$this->db->get('erp_subjectmaster')->result();
		$config = array(
        array(
                'field' => 'subCode',
                'label' => 'Subject Code',
                //'rules' => 'required|is_unique[erp_subjectmaster.subCode]',
                'rules' => 'required',
				'errors' => array(
                        'required' => 'You must provide a %s.',
						//'is_unique' => 'This %s already exists.'
						),
        ),
		array('field' => 'subName','label' => 'Subject Name','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'regulation','label' => 'Regulation','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'policy','label' => 'Policy','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'part','label' => 'Part Type','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'stream','label' => 'Stream','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'department','label' => 'Department','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		);
		if(isset($_POST['submit'])){
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) { 
         $data['form_err']=$this->session->set_flashdata('form_err','Please check all the details','warning'); 
         } 
         else {
		 $batch_id = $this->input->post('batch_id');
		 $batch = $this->db->where('id',$batch_id)->get('erp_batchmaster')->row();
		 $year = $batch->batch_from;
		
		 $data_add = array(
		  'batch_id' => $batch_id,
		  'batch_year' => $year,
		  'regulation' => $this->input->post('regulation'),
		  'policy' => $this->input->post('policy'),
		  'subCode' => $this->input->post('subCode'),
		  'subNature' => $this->input->post('subNature'),
		  'subName' => $this->input->post('subName'),
		  'sem' => $this->input->post('sem'),
		  'creditPnt' => $this->input->post('creditPnt'),
		  'subCatg' => $this->input->post('subCatg'),
		  'part' => $this->input->post('part'),
		  'labSplitup' => $this->input->post('labSplitup'),
		  'stream' => $this->input->post('stream'),
		  'department' => $this->input->post('department'),
		  'user_id' => $user_id,
		  'add_date' => $add_date,
		 );
		  
		$insert = $this->db->insert('erp_subjectmaster',$data_add);
		$data['msg']=$this->session->set_flashdata('success','Added Successfully','success'); 
		redirect('coe/subject','refresh');
		}
		 }		
		
    $this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/add_subject',$data);
    $this->load->view('template/coe/footer');
    }
	public function editSubject()
	{
		$edit_id = $this->uri->segment(3);
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['sub_list']=$this->db->where('id',$edit_id)->get('erp_subjectmaster')->row();
		$config = array(
        array(
                'field' => 'subCode',
                'label' => 'Subject Code',
                'rules' => 'required',
				'errors' => array(
                        'required' => 'You must provide a %s.',
						),
        ),
		array('field' => 'subName','label' => 'Subject Name','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'regulation','label' => 'Regulation','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'policy','label' => 'Policy','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'part','label' => 'Part Type','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'stream','label' => 'Stream','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'department','label' => 'Department','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		);
		if(isset($_POST['submit'])){
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) { 
         $data['form_err']=$this->session->set_flashdata('form_err','Please check all the details','warning'); 
         } 
         else { 
		 $edit_id = $this->input->post('edit_id');
		 $data_up = array(
		  'regulation' => $this->input->post('regulation'),
		  'policy' => $this->input->post('policy'),
		  'subCode' => $this->input->post('subCode'),
		  'subNature' => $this->input->post('subNature'),
		  'subName' => $this->input->post('subName'),
		  'sem' => $this->input->post('sem'),
		  'creditPnt' => $this->input->post('creditPnt'),
		  'subCatg' => $this->input->post('subCatg'),
		  'part' => $this->input->post('part'),
		  'labSplitup' => $this->input->post('labSplitup'),
		  'stream' => $this->input->post('stream'),
		  'department' => $this->input->post('department'),
		  'msw_m_25' => $this->input->post('tot_mark25'),
		 );
		  $this->db->where('id',$edit_id);
		$update = $this->db->update('erp_subjectmaster',$data_up);
		$data['msg']=$this->session->set_flashdata('success','Updated Successfully','success'); 
		redirect('coe/subject','refresh');
		}
		 }		
		
    $this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/edit_subject',$data);
    $this->load->view('template/coe/footer');
    }
	public function deleteSubject()
	{
		$edit_id = $this->uri->segment(3);
		$delete = $this->db->where('id',$edit_id)->delete('erp_subjectmaster');
		$data['msg']=$this->session->set_flashdata('success','Deleted Successfully','success'); 
		redirect('coe/subject','refresh');
	}
	
	public function semwiseSubject()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['sub_list']=$this->db->select('erp_subjectmaster.*,erp_regulation.name as regulatn,erp_subpolicy.name as plcy')->join('erp_regulation','erp_regulation.id=erp_subjectmaster.regulation')->join('erp_subpolicy','erp_subpolicy.id=erp_subjectmaster.policy')->where('erp_subjectmaster.user_id',$user_id)->get('erp_subjectmaster')->result();
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/semwiseSubject',$data);
    $this->load->view('template/coe/footer');	
	}
	
	public function studentElective()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['course1']='';
		$data['subject1']='';
		
		if(isset($_POST['submit'])){
			$data['course1']=$course=$this->input->post('course');
			$data['subject1']=$subject=$this->input->post('subject');
			if($course=='UG'){
		$data['stu_list']=$this->db->get('new_preview')->result();
		}elseif($course=='PG'){
		$data['stu_list']=$this->db->get('new_preview_pg')->result();}
		else{
		$data['stu_list']=$this->db->get('new_preview_dip')->result();}
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/studentElective',$data);
    $this->load->view('template/coe/footer');	
	}
	public function update_elective()
	{
		$student=$this->input->post('id');
		$subject=$this->input->post('subject');
		$course=$this->input->post('course');
		$data1['pr_elective']='';
		
		for($i=0; $i<sizeof($student); $i++){
			$data['pr_elective']=$subject;
			if($course=='UG'){
		$this->db->where('pr_id',$student[$i]);
		$this->db->update('new_preview',$data);
		}elseif($course=='PG'){
		$this->db->where('pr_id',$student[$i]);	
		$this->db->update('new_preview_pg',$data);}
		else{
		$this->db->where('pr_id',$student[$i]);	
		$this->db->update('new_preview_dip',$data);}
		}
	}
	public function delete_elective()
	{
		$student=$this->input->post('id');
		$subject=$this->input->post('subject');
		$course=$this->input->post('course');
		$data['pr_elective']='';
		
			if($course=='UG'){
		$this->db->where('pr_id',$student);
		$this->db->update('new_preview',$data);
		}elseif($course=='PG'){
		$this->db->where('pr_id',$student);	
		$this->db->update('new_preview_pg',$data);}
		else{
		$this->db->where('pr_id',$student);	
		$this->db->update('new_preview_dip',$data);}
	}
	
	public function studentDetails()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['stream1']='';
		$data['department1']='';
		$data['batch1']='';
		
		if(isset($_POST['submit'])){
			$data['stream1']=$stream = $this->input->post('stream');
			$data['department1']=$department = $this->input->post('department');
			$data['batch1']=$batch = $this->input->post('batch');
			$yr = substr($batch,-2);
			if($stream=='5'){
				$this->db->select('admitted_student.*,new_preview.*,stu_user.u_mobile');
				$this->db->join('new_preview','admitted_student.as_student_id=new_preview.pr_user_id', 'left');
				$this->db->join('stu_user','admitted_student.as_student_id=stu_user.u_id', 'left');
			}
			elseif($stream=='4'){
				$this->db->select('admitted_student.*,new_preview_dip.*,stu_user.u_mobile');
				$this->db->join('new_preview_dip','admitted_student.as_student_id=new_preview_dip.pr_user_id', 'left');
				$this->db->join('stu_user','admitted_student.as_student_id=stu_user.u_id', 'left');
			}else{
				$this->db->select('admitted_student.*,new_preview_pg.*,stu_user.u_mobile');
				$this->db->join('new_preview_pg','admitted_student.as_student_id=new_preview_pg.pr_user_id', 'left');
				$this->db->join('stu_user','admitted_student.as_student_id=stu_user.u_id', 'left');
			}
		$data['stu_list'] = 
		$this->db
		->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id', 'left')
		->where('shotlisted_candidate.sl_main_id',$stream)
		->where('shotlisted_candidate.sl_course_id',$department)
		->where('RIGHT(SUBSTRING_INDEX(admitted_student.as_app_number, "-", 2),2)='.$yr.'')
		//->where('(admitted_student.left_status = 0 AND admitted_student.long_absent = 0)')
		->get('admitted_student')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/studentDetails',$data);
    $this->load->view('template/coe/footer');	
	}
	public function studentEdit()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$student_id = $this->uri->segment(3);
		$get_stu = $this->db->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')->where('admitted_student.as_id',$student_id)->get('admitted_student')->row();
		$stream = $get_stu->sl_main_id;
		
		if($stream=='5'){
				$this->db->select('admitted_student.*,new_preview.*');
				$this->db->join('new_preview','admitted_student.as_student_id=new_preview.pr_user_id', 'left');
			}
			elseif($stream=='4'){
				$this->db->select('admitted_student.*,new_preview_dip.*');
				$this->db->join('new_preview_dip','admitted_student.as_student_id=new_preview_dip.pr_user_id', 'left');
			}else{
				$this->db->select('admitted_student.*,new_preview_pg.*');
				$this->db->join('new_preview_pg','admitted_student.as_student_id=new_preview_pg.pr_user_id', 'left');
			}
		$data['stu_list'] = 
		$this->db
		->where('admitted_student.as_id',$student_id)
		->get('admitted_student')->row();
		
		if(isset($_POST['submit'])){
			$student_id_edit = $this->input->post('student_id');
			//$stream_edit = $this->input->post('stream');
			
			$data_in = array(
			'pr_applicant_name' => $this->input->post('pr_applicant_name'),
			'pr_dob' => $this->input->post('pr_dob'),
			'pr_age' => $this->input->post('pr_age'),
			'pr_mother_toung' => $this->input->post('pr_mother_toung'),
			'pr_place_of_birth' => $this->input->post('pr_place_of_birth'),
			'pr_gender' => $this->input->post('pr_gender'),
			'pr_nationality' => $this->input->post('pr_nationality'),
			'pr_blood_group' => $this->input->post('pr_blood_group'),
			'pr_religion' => $this->input->post('pr_religion'),
			'pr_caste' => $this->input->post('pr_caste'),
			'pr_community' => $this->input->post('pr_community'),
			'pr_father_name' => $this->input->post('pr_father_name'),
			'pr_father_mobnum' => $this->input->post('pr_father_mobnum'),
			'pr_father_email' => $this->input->post('pr_father_email'),
			'pr_father_accu' => $this->input->post('pr_father_accu'),
			'pr_father_anuval_income' => $this->input->post('pr_father_anuval_income'),
			'pr_mother_name' => $this->input->post('pr_mother_name'),
			'pr_mother_mobnum' => $this->input->post('pr_mother_mobnum'),
			'pr_mother_email' => $this->input->post('pr_mother_email'),
			'pr_mother_accu' => $this->input->post('pr_mother_accu'),
			'pr_mother_anuval_income' => $this->input->post('pr_mother_anuval_income'),
			'pr_gaurdion_name' => $this->input->post('pr_gaurdion_name'),
			'pr_gaurdion_mobnum' => $this->input->post('pr_gaurdion_mobnum'),
			'pr_gaurdion_email' => $this->input->post('pr_gaurdion_email'),
			'pr_gaurdion_accu' => $this->input->post('pr_gaurdion_accu'),
			'pr_gaurdion_anuval_income' => $this->input->post('pr_gaurdion_anuval_income'),
			'pr_local_address' => $this->input->post('pr_local_address'),
			'pr_local_city' => $this->input->post('pr_local_city'),
			'pr_local_state' => $this->input->post('pr_local_state'),
			'pr_local_country' => $this->input->post('pr_local_country'),
			'pr_local_pincode' => $this->input->post('pr_local_pincode'),
			'pr_permanent_address' => $this->input->post('pr_permanent_address'),
			'pr_permanent_city' => $this->input->post('pr_permanent_city'),
			'pr_permanent_state' => $this->input->post('pr_permanent_state'),
			'pr_permanent_country' => $this->input->post('pr_permanent_country'),
			'pr_permanent_pincode' => $this->input->post('pr_permanent_pincode'),
			);
			
			$data_in1 = array(
			'as_name' => $this->input->post('pr_applicant_name'),
			'as_blood_gp' => $this->input->post('pr_blood_group'),
			);
			
			$data_in2 = array(
			'student_name_' => $this->input->post('pr_applicant_name'),
			'father_name_' => $this->input->post('pr_blood_group'),
			'dob_' => $this->input->post('pr_dob'),
			'gender_' => $this->input->post('pr_gender'),
			'caste_' => $this->input->post('pr_caste'),
			'community_' => $this->input->post('pr_community'),
			'religion_' => $this->input->post('pr_religion'),
			'address_' => $this->input->post('pr_local_address'),
			'pincode_' => $this->input->post('pr_local_pincode'),
			'mobile_number_' => $this->input->post('pr_father_mobnum'),
			'email_' => $this->input->post('pr_father_email'),
			'father_guardian_contactno_' => $this->input->post('pr_gaurdion_mobnum'),
			);
			
			if($_FILES['profile']['size'] != 0) {
			$file_ext = pathinfo($_FILES["profile"]["name"], PATHINFO_EXTENSION);
			$NewImageName = rand().'.'.$file_ext;
			
			$_FILES["file"]["name"] = $_FILES["profile"]["name"];
			//$_FILES["file"]["name"] = $NewImageName;
			$_FILES["file"]["type"] = $_FILES["profile"]["type"];
			$_FILES["file"]["tmp_name"] = $_FILES["profile"]["tmp_name"];
			$_FILES["file"]["error"] = $_FILES["profile"]["error"];
			$_FILES["file"]["size"] = $_FILES["profile"]["size"];

	    $config = array();
		$config['upload_path'] = 'https://admission.mssw.in/admin/uploads/';
		$config['allowed_types'] = '*';
		$config['remove_spaces'] = TRUE;
		$config['overwrite'] = TRUE;
		
			$this->load->library('upload', $config);

			if($this->upload->do_upload('file'))
			{
			 $ffff = $this->upload->data();
			  $image=$ffff['file_name'];
			  
			  $data_in['pr_photo'] = $NewImageName;
			  $data_in1['as_profile'] = $NewImageName;
			  $data_in2['student_image'] = $NewImageName;
			  exit;
			  }
			  else{
				  $error = array('error' => $this->upload->display_errors());
				  print_r($error);exit;
			  }
	 }
	 
			$this->db->where('pr_user_id',$student_id_edit);
			if($stream=='5'){
				$this->db->update('new_preview',$data_in);
			}
			elseif($stream=='4'){
				$this->db->update('new_preview_dip',$data_in);
			}else{
				$this->db->update('new_preview_pg',$data_in);
			}
			
			$this->db->where('as_student_id',$student_id_edit);
			$this->db->update('admitted_student',$data_in1);
			
			$this->db->where('student_id',$student_id_edit);
			$this->db->update('erp_existing_students',$data_in2);
			
			$data['mesg'] = $this->session->set_flashdata('success','Student Details Updated Successfully!!','success');
			redirect('coe/studentEdit/'.$student_id.'','refresh');
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/studentEdit',$data);
    $this->load->view('template/coe/footer');	
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
	
	public function studentLeft()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['stream1']='';
		$data['department1']='';
		$data['batch1']='';
		
		if(isset($_POST['submit'])){
			$data['stream1']=$stream = $this->input->post('stream');
			$data['department1']=$department = $this->input->post('department');
			$data['batch1']=$batch = $this->input->post('batch');
			$yr = substr($batch,-2);
		$data['stu_list'] = $this->db->select('admitted_student.*')
		->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->where('shotlisted_candidate.sl_main_id',$stream)
		->where('shotlisted_candidate.sl_course_id',$department)
		->where('RIGHT(SUBSTRING_INDEX(admitted_student.as_app_number, "-", 2),2)='.$yr.'')
		//->where('(admitted_student.left_status = 0 AND admitted_student.long_absent = 0)')
		->get('admitted_student')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/studentLeft',$data);
    $this->load->view('template/coe/footer');	
	}
	public function markLeft()
	{
	$left=$this->input->post('ids_left');
	$left_n=$this->input->post('ids_not_left');
	$absent=$this->input->post('ids_absent');
	$absent_n=$this->input->post('ids_not_absent');
	if($left==''){$left=array();}
	if($left_n==''){$left_n=array();}
	if($absent==''){$absent=array();}
	if($absent_n==''){$absent_n=array();}
	
	for($i=0; $i<sizeof($left); $i++){
	$data['left_status']='1';
	 $this->db->where('as_id',$left[$i]);	
	$this->db->update('admitted_student',$data);
	
	 $adm_stu = $this->db->where('as_id',$left[$i])->get('admitted_student')->row();
	 $this->db->where('student_id',$adm_stu->as_student_id);	
	$this->db->update('erp_existing_students',$data); 
	}
	for($i_n=0; $i_n<sizeof($left_n); $i_n++){
	$data_n['left_status']='0';
	 $this->db->where('as_id',$left_n[$i_n]);	
	$this->db->update('admitted_student',$data_n);
	
	 $adm_stu = $this->db->where('as_id',$left_n[$i_n])->get('admitted_student')->row();
	 $this->db->where('student_id',$adm_stu->as_student_id);	
	$this->db->update('erp_existing_students',$data_n); 
	}
	for($ii=0; $ii<sizeof($absent); $ii++){
	$data1['long_absent']='1';
	 $this->db->where('as_id',$absent[$ii]);	
	$this->db->update('admitted_student',$data1);
	
	 $adm_stu = $this->db->where('as_id',$absent[$ii])->get('admitted_student')->row();
	 $this->db->where('student_id',$adm_stu->as_student_id);	
	$this->db->update('erp_existing_students',$data1); 
	}
	for($ii_n=0; $ii_n<sizeof($absent_n); $ii_n++){
	$data1_n['long_absent']='0';
	 $this->db->where('as_id',$absent_n[$ii_n]);	
	$this->db->update('admitted_student',$data1_n);
	
	 $adm_stu = $this->db->where('as_id',$absent_n[$ii_n])->get('admitted_student')->row();
	 $this->db->where('student_id',$adm_stu->as_student_id);	
	$this->db->update('erp_existing_students',$data1_n); 
	}
	echo 'Success';
    }
	
	public function studentHostel()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['stream1']='';
		$data['department1']='';
		$data['batch1']='';
		
		if(isset($_POST['submit'])){
			$data['stream1']=$stream = $this->input->post('stream');
			$data['department1']=$department = $this->input->post('department');
			$data['batch1']=$batch = $this->input->post('batch');
			$yr = substr($batch,-2);
		$data['stu_list'] = $this->db->select('admitted_student.*')
		->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->where('shotlisted_candidate.sl_main_id',$stream)
		->where('shotlisted_candidate.sl_course_id',$department)
		->where('RIGHT(SUBSTRING_INDEX(admitted_student.as_app_number, "-", 2),2)='.$yr.'')
		->where('(admitted_student.left_status = 0 AND admitted_student.long_absent = 0)')
		->get('admitted_student')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/studentHostel',$data);
    $this->load->view('template/coe/footer');	
	}
	public function markHostel()
	{
		$add_date = date('Y-m-d');
	$hostel=$this->input->post('ids_hostel');
	$not_hostel=$this->input->post('ids_not_hostel');
	$stream = $this->input->post('stream');
	$department = $this->input->post('department');
	$batch = $this->input->post('batch');
	//$hostel=array('117');
	//$not_hostel=array('');
	//$stream = 1;
	//$department = 6;
	//$batch = 2021;
	
	for($i=0; $i<sizeof($hostel); $i++){
	$data['hostel_status']='1';
	 $this->db->where('as_id',$hostel[$i]);	
	$this->db->update('admitted_student',$data);
	if($stream=='5'){
				$this->db->select('admitted_student.*,new_preview.*,department_details.short_name,stu_user.*');
				$this->db->join('new_preview','admitted_student.as_student_id=new_preview.pr_user_id', 'left');
			}
			elseif($stream=='4'){
				$this->db->select('admitted_student.*,new_preview_dip.*,department_details.short_name,stu_user.*');
				$this->db->join('new_preview_dip','admitted_student.as_student_id=new_preview_dip.pr_user_id', 'left');
			}else{
				$this->db->select('admitted_student.*,new_preview_pg.*,department_details.short_name,stu_user.*');
				$this->db->join('new_preview_pg','admitted_student.as_student_id=new_preview_pg.pr_user_id', 'left');
			}
	$get_stu = $this->db->join('department_details','(department_details.main_id='.$stream.' AND department_details.cour_id='.$department.')')->join('stu_user','admitted_student.as_student_id=stu_user.u_id', 'left')->where('admitted_student.as_id',$hostel[$i])->get('admitted_student')->row();
	if(isset($get_stu)){
	$uid2 = $this->db->order_by('serial','desc')->get('studentinfo')->row();	
		$uid1 = explode('U',$uid2->userId);
        $prefix = 'U';
		$index = $uid1[1]+1;
        $userIds = sprintf("%s%09s", $prefix, $index);
                    $handyCam = new \handyCam\handyCam();
                $dateNow=date("Y-m-d");
				
			$stu_hos = $this->db->where('admitId',$get_stu->as_id)->get('studentinfo')->row();
            if(!isset($stu_hos)){	
                $data2 = array(
                    'userId' => $userIds,
                    'userGroupId' => "UG004",
                    'name' => $get_stu->pr_applicant_name,
                    'studentId' => $get_stu->as_student_id,
                    'cellNo' => $get_stu->u_mobile,
                    'email' => $get_stu->u_email_id,
                    //'nameOfInst' => $get_stu->as_id,
                    'program' => $get_stu->short_name,
                    'batchNo' => $batch,
                    'gender' => $get_stu->pr_gender,
                    'dob' => $get_stu->pr_dob,
                    'bloodGroup' => $get_stu->pr_blood_group,
                    'nationality' => $get_stu->pr_nationality,
                    //'nationalId' => $get_stu->as_id,
                    'passportNo' => $get_stu->pr_passportnumber,
                    'fatherName' => $get_stu->pr_father_name,
                    'motherName' => $get_stu->pr_mother_name,
                    'fatherCellNo' => $get_stu->pr_father_mobnum,
                    'motherCellNo' => $get_stu->pr_mother_mobnum,
                    'localGuardian' => $get_stu->pr_gaurdion_name,
                    'localGuardianCell' => $get_stu->pr_gaurdion_mobnum,
                    'presentAddress' => $get_stu->pr_local_address,
                    'parmanentAddress' =>$get_stu->pr_permanent_address,
                    'admitDate' => $dateNow,
                    'admitId' => $get_stu->as_id,
                    'main_id' => $stream,
                    'course_id' => $department,
                    'perPhoto' => $get_stu->pr_photo,
                    'isActive' => 'Y'
                );		
				$this->db->insert('studentinfo',$data2);
			}else{
				$data2['isActive'] = 'Y';			
				$this->db->where('admitId',$hostel[$i]);
				$this->db->update('studentinfo',$data2);
			}
	}
	}
	for($ii=0; $ii<sizeof($not_hostel); $ii++){
	$data1['hostel_status']='0';
	 $this->db->where('as_id',$not_hostel[$ii]);	
	$this->db->update('admitted_student',$data1);
	$stu_hos1 = $this->db->where('admitId',$not_hostel[$ii])->get('studentinfo')->row();
            if(isset($stu_hos1)){		
                $data3['isActive'] = 'N';			
				$this->db->where('admitId',$not_hostel[$ii]);
				$this->db->update('studentinfo',$data3);
			}
	}
	echo 'Success';
    }
	
	public function studentExempted()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$date=date('Y-m-d');
		$data['stream1']='';
		$data['department1']='';
		$data['batch1']='';
		
		if(isset($_POST['submit'])){
			$data['stream1']=$stream = $this->input->post('stream');
			$data['department1']=$department = $this->input->post('department');
			$data['batch1']=$batch = $this->input->post('batch');
			$yr = substr($batch,-2);
		$stu_list = $data['stu_list'] = $this->db->select('admitted_student.*')
		->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->where('shotlisted_candidate.sl_main_id',$stream)
		->where('shotlisted_candidate.sl_course_id',$department)
		->where('DATE_FORMAT((CONCAT("20", (SUBSTRING_INDEX(SUBSTRING_INDEX(admitted_student.as_app_number,"-","-2"),"-","1")), "-06-01")),"%Y-%m-%d") <= "'.$date.'"')
		->where('DATE_ADD((DATE_FORMAT((CONCAT("20", (SUBSTRING_INDEX(SUBSTRING_INDEX(admitted_student.as_app_number,"-","-2"),"-","1")), "-12-01")),"%Y-%m-%d")), INTERVAL 6 MONTH) >= "'.$date.'"')
		->where('RIGHT(SUBSTRING_INDEX(admitted_student.as_app_number, "-", 2),2)='.$yr.'')
		->where('(admitted_student.left_status = 0 AND admitted_student.long_absent = 0)')
		->get('admitted_student')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/studentExempted',$data);
    $this->load->view('template/coe/footer');	
	}
	public function markExempted()
	{
	$exempted=$this->input->post('ids_exempted');
	
	for($i=0; $i<sizeof($exempted); $i++){
	$data['exempted_status']='1';
	 $this->db->where('as_id',$exempted[$i]);	
	$this->db->update('admitted_student',$data);
	}
	echo 'Success';
    }
	
	public function generateTransferCert()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['stream1']='';
		$data['department1']='';
		$data['batch1']='';
		
		if(isset($_POST['submit'])){
			$data['stream1']=$stream = $this->input->post('stream');
			$data['department1']=$department = $this->input->post('department');
			$data['batch1']=$batch = $this->input->post('batch');
			$yr = substr($batch,-2);
		$data['stu_list'] = $this->db->select('admitted_student.*')
		->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->where('shotlisted_candidate.sl_main_id',$stream)
		->where('shotlisted_candidate.sl_course_id',$department)
		->where('RIGHT(SUBSTRING_INDEX(admitted_student.as_app_number, "-", 2),2)='.$yr.'')
		->where('(admitted_student.left_status = 0 AND admitted_student.long_absent = 0)')
		->get('admitted_student')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/generateTransferCert',$data);
    $this->load->view('template/coe/footer');	
	}
	public function transferCertificate()
	{
		$this->load->library("pdf");
		$id = $this->uri->segment('3');
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$date=date('Y-m-d');
		
		$studet = $this->db->query('select shotlisted_candidate.sl_main_id from admitted_student join shotlisted_candidate on shotlisted_candidate.sl_id=admitted_student.as_shotlist_ref_number where admitted_student.as_id='.$id.' ')->row();
		
		if($studet->sl_main_id=='5'){
		$data['stu_list'] = $this->db->select('admitted_student.*, department_details.comp_name, new_preview.*')
		->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->join('department_details','department_details.main_id=shotlisted_candidate.sl_main_id and department_details.cour_id=shotlisted_candidate.sl_course_id')
		->join('new_preview','admitted_student.as_student_id=new_preview.pr_user_id', 'left')
		->where('admitted_student.as_id',$id)
		->get('admitted_student')->row();
		}elseif($studet->sl_main_id=='4'){
			$data['stu_list'] = $this->db->select('admitted_student.*, department_details.comp_name, new_preview_dip.*')
		->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->join('department_details','department_details.main_id=shotlisted_candidate.sl_main_id and department_details.cour_id=shotlisted_candidate.sl_course_id')
		->join('new_preview_dip','admitted_student.as_student_id=new_preview_dip.pr_user_id', 'left')
		->where('admitted_student.as_id',$id)
		->get('admitted_student')->row();
		}else{
			$data['stu_list'] = $this->db->select('admitted_student.*, department_details.comp_name, new_preview_pg.*')
		->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->join('department_details','department_details.main_id=shotlisted_candidate.sl_main_id and department_details.cour_id=shotlisted_candidate.sl_course_id')
		->join('new_preview_pg','admitted_student.as_student_id=new_preview_pg.pr_user_id', 'left')
		->where('admitted_student.as_id',$id)
		->get('admitted_student')->row();
		}
		ob_start();
            $html = $this->load->view("coe/transferCert", $data, true);
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
            $dompdf->stream("TransferCertificate.pdf", ["Attachment" => 1]);
		
    //$this->load->view('coe/transferCert',$data);
	}
	
	public function generateCourseCompletion()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['stream1']='';
		$data['department1']='';
		$data['batch1']='';
		
		if(isset($_POST['submit'])){
			$data['stream1']=$stream = $this->input->post('stream');
			$data['department1']=$department = $this->input->post('department');
			$data['batch1']=$batch = $this->input->post('batch');
			$yr = substr($batch,-2);
		$data['stu_list'] = $this->db->select('admitted_student.*')
		->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->where('shotlisted_candidate.sl_main_id',$stream)
		->where('shotlisted_candidate.sl_course_id',$department)
		->where('RIGHT(SUBSTRING_INDEX(admitted_student.as_app_number, "-", 2),2)='.$yr.'')
		->where('(admitted_student.left_status = 0 AND admitted_student.long_absent = 0)')
		->get('admitted_student')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/generateCourseCompletion',$data);
    $this->load->view('template/coe/footer');	
	}
	public function courseCompletionCertificate()
	{
		$this->load->library("pdf");
		$id = $this->uri->segment('3');
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$date=date('Y-m-d');
		
		$studet = $this->db->query('select shotlisted_candidate.sl_main_id from admitted_student join shotlisted_candidate on shotlisted_candidate.sl_id=admitted_student.as_shotlist_ref_number where admitted_student.as_id='.$id.' ')->row();
		
		if($studet->sl_main_id=='5'){
		$data['stu_list'] = $this->db->select('admitted_student.*, department_details.comp_name, new_preview.*')
		->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->join('department_details','department_details.main_id=shotlisted_candidate.sl_main_id and department_details.cour_id=shotlisted_candidate.sl_course_id')
		->join('new_preview','admitted_student.as_student_id=new_preview.pr_user_id', 'left')
		->where('admitted_student.as_id',$id)
		->get('admitted_student')->row();
		}elseif($studet->sl_main_id=='4'){
			$data['stu_list'] = $this->db->select('admitted_student.*, department_details.comp_name, new_preview_dip.*')
		->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->join('department_details','department_details.main_id=shotlisted_candidate.sl_main_id and department_details.cour_id=shotlisted_candidate.sl_course_id')
		->join('new_preview_dip','admitted_student.as_student_id=new_preview_dip.pr_user_id', 'left')
		->where('admitted_student.as_id',$id)
		->get('admitted_student')->row();
		}else{
			$data['stu_list'] = $this->db->select('admitted_student.*, department_details.comp_name, new_preview_pg.*')
		->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->join('department_details','department_details.main_id=shotlisted_candidate.sl_main_id and department_details.cour_id=shotlisted_candidate.sl_course_id')
		->join('new_preview_pg','admitted_student.as_student_id=new_preview_pg.pr_user_id', 'left')
		->where('admitted_student.as_id',$id)
		->get('admitted_student')->row();
		}
		ob_start();
            $html = $this->load->view("coe/crsCompltnCert", $data, true);
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
            $dompdf->stream("CourseCompletion.pdf", ["Attachment" => 1]);
		
    //$this->load->view('coe/transferCert',$data);
	}
	
	public function batch()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['batch_list']=$this->db->where('user_id',$user_id)->get('erp_batchmaster')->result();
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/batch',$data);
    $this->load->view('template/coe/footer');	
	}
	public function addBatch()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['policy_list']=$this->db->get('erp_subpolicy')->result();
		$config = array(
		array('field' => 'fromYr','label' => 'From Year','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		);
		if(isset($_POST['submit'])){
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) { 
         $data['form_err']=$this->session->set_flashdata('form_err','Please check all the details','warning'); 
         } 
         else { 
		 $data_add = array(
		  'batch_from' => $this->input->post('fromYr'),
		  'user_id' => $user_id,
		  'created_at' => $add_date,
		 );
		  
		$insert = $this->db->insert('erp_batchmaster',$data_add);
		$data['msg']=$this->session->set_flashdata('success','Added Successfully','success'); 
		redirect('coe/batch','refresh');
		}
		 }		
		
    $this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/add_batch',$data);
    $this->load->view('template/coe/footer');
    }
	public function editBatch()
	{
		$edit_id = $this->uri->segment(3);
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['batch_list']=$this->db->where('id',$edit_id)->get('erp_batchmaster')->row();
		$config = array(
		array('field' => 'fromYr','label' => 'From Year','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		);
		if(isset($_POST['submit'])){
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) { 
         $data['form_err']=$this->session->set_flashdata('form_err','Please check all the details','warning'); 
         } 
         else { 
		 $edit_id = $this->input->post('edit_id');
		 $data_up = array(
		  'batch_from' => $this->input->post('fromYr'),
		 );
		  $this->db->where('id',$edit_id);
		$update = $this->db->update('erp_batchmaster',$data_up);
		$data['msg']=$this->session->set_flashdata('success','Updated Successfully','success'); 
		redirect('coe/batch','refresh');
		}
		 }		
		
    $this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/edit_batch',$data);
    $this->load->view('template/coe/footer');
    }
	public function deleteBatch()
	{
		$edit_id = $this->uri->segment(3);
		$delete = $this->db->where('id',$edit_id)->delete('erp_batchmaster');
		$data['msg']=$this->session->set_flashdata('success','Deleted Successfully','success'); 
		redirect('coe/batch','refresh');
	}
	public function studentExamMarks()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['stream']='';
		$data['department']='';
		
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		//->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/studentExamMarks1',$data);
    $this->load->view('template/coe/footer');	
	}
	public function ICA1Mark()
	{
	$ica1=$this->input->post('ica1');
	$icaval1=$this->input->post('icaval1');
	$main_id=$this->input->post('main_id');
	$course_id=$this->input->post('course_id');
	$ica1_not=$this->input->post('ica1_not');
	$user_id=$this->session->userdata('user')['user_id'];
	$add_date=date('Y-m-d H:i:s');
	
	for($i=0; $i<sizeof($ica1); $i++){
		$data = array();
		$det = $this->db->where('student_id',$ica1[$i])->get('erp_exammark')->row();
	 if(!isset($det)){	
	$data['student_id']=$ica1[$i];
	$data['ica1Mark']=$icaval1[$i];
	$data['main_id']=$main_id;
	$data['course_id']=$course_id;
	$data['user_id']=$user_id;
	$data['created_at']=$add_date;
	$this->db->insert('erp_exammark',$data);
	 }else{
	$data['student_id']=$ica1[$i];	 
	$data['ica1Mark']=$icaval1[$i];	
	 $this->db->where('student_id',$ica1[$i]);	
	$this->db->update('erp_exammark',$data);
	 }
	}
	
	for($ii=0; $ii<sizeof($ica1_not); $ii++){
		$delete = $this->db->where('student_id',$ica1_not[$ii])->get('erp_exammark')->row();
	 if(isset($delete)){	
	 $data1['ica1Mark']=null;
	$this->db->where('student_id',$ica1_not[$ii]);	
	$this->db->update('erp_exammark',$data1);
	 }
	}
	echo 'Success';
    }
	
	
	public function examFeesClosingDate()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['batch1'] = '';
		$data['sem1'] = '';
		$config = array(
		array('field' => 'batch','label' => 'Batch','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'sem','label' => 'Semester','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		);
		if(isset($_POST['submit'])){
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) { 
         $data['form_err']=$this->session->set_flashdata('form_err','Please check all the details','warning'); 
         } 
         else {
		 $batch_id = $data['batch1'] = $this->input->post('batch');
		 $sem = $data['sem1'] = $this->input->post('sem');
		 $data['date_list'] = $this->db->where('batch_id',$batch_id)->where('sem',$sem)->get('erp_exam_fees_closing')->result();
		}
		 }	
        if(isset($_POST['submit_edit'])){
		 $edit_id = $this->input->post('edit_id');
		
		 $data_add = array(
		  'closing_date' => date('Y-m-d',strtotime($this->input->post('closing_date_edit'))),
		 );
		  
		$this->db->where('id',$edit_id);
		$update = $this->db->update('erp_exam_fees_closing',$data_add);
		$batch_id = $data['batch1'] = $this->input->post('batch');
		$sem = $data['sem1'] = $this->input->post('sem');
		$data['date_list'] = $this->db->where('batch_id',$batch_id)->where('sem',$sem)->get('erp_exam_fees_closing')->result();
		$data['msg']=$this->session->set_flashdata('success','Edited Successfully','success');
		 }			 
		
    $this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/exam_fees_closing_date',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function examFeesClosingDateAdd()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['sub_list']=$this->db->get('erp_subjectmaster')->result();
		$config = array(
		array('field' => 'batch','label' => 'Batch','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'sem','label' => 'Semester','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'stream','label' => 'Stream','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
        array(
                'field' => 'department',
                'label' => 'Department',
                'rules' => 'required|is_unique_multiple[erp_exam_fees_closing, batch_id.main_id.course_id.sem,batch.stream.department.sem]',
				'errors' => array(
                        'required' => 'You must provide a %s.',
						'is_unique_multiple' => 'This %s for the sem already exists.'
						),
        ),
		);
		if(isset($_POST['submit'])){
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) { 
         $data['form_err']=$this->session->set_flashdata('form_err','Please check all the details','warning'); 
         } 
         else {
		 $batch_id = $this->input->post('batch');
		 $batch = $this->db->where('id',$batch_id)->get('erp_batchmaster')->row();
		 $year = $batch->batch_from;
		
		 $data_add = array(
		  'batch_id' => $batch_id,
		  'batch_year' => $year,
		  'sem' => $this->input->post('sem'),
		  'main_id' => $this->input->post('stream'),
		  'course_id' => $this->input->post('department'),
		  'closing_date' => date('Y-m-d',strtotime($this->input->post('closing_date'))),
		  'user_id' => $user_id,
		  'created_at' => $add_date,
		 );
		  
		$insert = $this->db->insert('erp_exam_fees_closing',$data_add);
		$data['msg']=$this->session->set_flashdata('success','Added Successfully','success'); 
		redirect('coe/examFeesClosingDate','refresh');
		}
		 }		
		
    $this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/exam_fees_closing_date_add',$data);
    $this->load->view('template/coe/footer');
    }
	
	
	public function examFeesClosingDateDelete()
	{
		$id=$this->uri->segment(3);
		$this->db->where('id',$id);
		$this->db->delete('erp_exam_fees_closing');
		$data['msg']=$this->session->set_flashdata('success','Deleted Successfully','success'); 
		redirect('coe/examFeesClosingDate','refresh');
    }
	
	public function examFeesClosingDateUpdate()
	{
		$id=$this->input->post('id');
		$date = $this->db->where('id',$id)->get('erp_exam_fees_closing')->row();
		echo json_encode($date);
    }
	
	
	
	public function icaMarksClosingDate()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['batch1'] = '';
		$data['sem1'] = '';
		$data['date1'] = '';
		$config = array(
		array('field' => 'batch','label' => 'Batch','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'sem','label' => 'Semester','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		);	
        if(isset($_POST['submit'])){
			$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) { 
         $data['form_err']=$this->session->set_flashdata('form_err','Please check all the details','warning'); 
         } 
         else {
		 $edit_id = $this->input->post('edit_id');
		
		 $data_edit = array(
		  'closing_date' => date('Y-m-d',strtotime($this->input->post('closing_date'))),
		 );
		  
		if($edit_id!=''){
		$this->db->where('id',$edit_id);
		$update = $this->db->update('erp_ica_marks_closing',$data_edit);
		  }else{
			$batch_id = $this->input->post('batch');
		 $batch = $this->db->where('id',$batch_id)->get('erp_batchmaster')->row();
		 $year = $batch->batch_from;
		
		 $data_add = array(
		  'batch_id' => $batch_id,
		  'batch_year' => $year,
		  'sem' => $this->input->post('sem'),
		  'closing_date' => date('Y-m-d',strtotime($this->input->post('closing_date'))),
		  'user_id' => $user_id,
		  'created_at' => $add_date,
		 );
		  
		$insert = $this->db->insert('erp_ica_marks_closing',$data_add); 
		  }
		$batch_id = $data['batch1'] = $this->input->post('batch');
		$sem = $data['sem1'] = $this->input->post('sem');
		$data['date1'] = $this->input->post('closing_date');
		$data['msg']=$this->session->set_flashdata('success','Updated Successfully','success');
		//redirect('coe/icaMarksClosingDate','refresh');
		}
		 }			 
		
    $this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/ica_marks_closing_date',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function icaMarksClosingDateAdd()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['sub_list']=$this->db->get('erp_subjectmaster')->result();
		$config = array(
		array('field' => 'batch','label' => 'Batch','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'sem','label' => 'Semester','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		);
		if(isset($_POST['submit'])){
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) { 
         $data['form_err']=$this->session->set_flashdata('form_err','Please check all the details','warning'); 
         } 
         else {
		 $batch_id = $this->input->post('batch');
		 $batch = $this->db->where('id',$batch_id)->get('erp_batchmaster')->row();
		 $year = $batch->batch_from;
		
		 $data_add = array(
		  'batch_id' => $batch_id,
		  'batch_year' => $year,
		  'sem' => $this->input->post('sem'),
		  'closing_date' => date('Y-m-d',strtotime($this->input->post('closing_date'))),
		  'user_id' => $user_id,
		  'created_at' => $add_date,
		 );
		  
		$insert = $this->db->insert('erp_ica_marks_closing',$data_add);
		$data['msg']=$this->session->set_flashdata('success','Added Successfully','success'); 
		redirect('coe/icaMarksClosingDate','refresh');
		}
		 }		
		
    $this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/ica_marks_closing_date_add',$data);
    $this->load->view('template/coe/footer');
    }
	
	
	public function icaMarksClosingDateDelete()
	{
		$id=$this->uri->segment(3);
		$this->db->where('id',$id);
		$this->db->delete('erp_ica_marks_closing');
		$data['msg']=$this->session->set_flashdata('success','Deleted Successfully','success'); 
		redirect('coe/icaMarksClosingDate','refresh');
    }
	
	public function icaMarksClosingDateUpdate()
	{
		$batch=$this->input->post('batch');
		$sem=$this->input->post('sem');
		$date = $this->db->where('batch_id',$batch)->where('sem',$sem)->get('erp_ica_marks_closing')->row();
		echo json_encode($date);
    }
	
	public function getSubj()
	{
		$sem='';
	$stream=$this->input->post('stream');
	$department=$this->input->post('department');
	$batch=$this->input->post('batch');
	//$sem=$this->input->post('sem');
	
    $subj = $this->db->where('batch_year',$batch)->where('stream',$stream)->where('department',$department)->get('erp_subjectmaster')->result();	
	
	$subject = '<option value="">Select Subject</option>';
	foreach($subj as $subj){
		$subject .= '<option value="'.$subj->id.'">'.$subj->subName.'</option>';
	}
	echo $subject;
    }
	
	public function hallTicket()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['stream']='';
		$data['department']='';
		$data['sem1']='';
		
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		//->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/hallTicket',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function hallTicketPDF()
	{
		$this->load->library("pdf");
		$id = $data['student_id'] = $this->uri->segment('3');
		$sem = $data['sem'] = $this->uri->segment('4');
		$batch = $data['batch'] = $this->uri->segment('5');
		
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$date=date('Y-m-d');
		
		$data['stu_list'] = $studet = $this->db->query('select * from erp_existing_students where id='.$id.' ')->row();
		
		ob_start();
            $html = $this->load->view("coe/hallTicketPDF", $data, true);
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
            $dompdf->setPaper("A4", "portrait");
            $dompdf->render();
            ob_end_clean();
            $dompdf->stream("HallTicket.pdf", ["Attachment" => 0]);
		
    //$this->load->view('coe/hallTicketPDF',$data);
	}
	
	public function examSchedule()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['stream']='';
		$data['department']='';
		$data['sem1']='';
		
		
		$config = array(
		array('field' => 'batch','label' => 'Batch','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'sem','label' => 'Semester','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'stream','label' => 'Stream','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'department','label' => 'Department','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		);
		if(isset($_POST['submit'])){
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) { 
         $data['form_err']=$this->session->set_flashdata('form_err','Please check all the details','warning'); 
         } 
         else {
			$data['batch1']=$batch = $this->input->post('batch');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
		$data['date_list'] = $this->db->select('*')
		->where('main_id',$stream)
		->where('course_id',$department)
		->where('batch_year',$batch)
		->where('sem',$sem)
		//->where('subject',$subject)
		->get('erp_exam_schedule')->result();
		}
		}
		if(isset($_POST['submit_edit'])){
		 $edit_id = $this->input->post('edit_id');
		
		 $data_add = array(
		  'schedule_date' => date('Y-m-d',strtotime($this->input->post('schedule_date'))),
		  'section' => $this->input->post('section'),
		 );
		  
		$this->db->where('id',$edit_id);
		$update = $this->db->update('erp_exam_schedule',$data_add);
		$data['batch1']=$batch = $this->input->post('batch');
		$data['sem1']=$sem = $this->input->post('sem');
		$data['stream']=$stream = $this->input->post('stream');
		$data['department']=$department = $this->input->post('department');
		$data['date_list'] = $this->db->select('*')
		->where('main_id',$stream)
		->where('course_id',$department)
		->where('batch_year',$batch)
		->where('sem',$sem)
		//->where('subject',$subject)
		->get('erp_exam_schedule')->result();
		$data['msg']=$this->session->set_flashdata('success','Edited Successfully','success');
		 }	
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/examSchedule',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function examScheduleAdd()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['stream']='';
		$data['department']='';
		$data['sem1']='';
		$data['section1']='';
		
		
		$config = array(
        array(
                'field' => 'subject',
                'label' => 'Subject',
                'rules' => 'required|is_unique_multiple[erp_exam_schedule, batch_year.main_id.course_id.sem.subject_id,batch.stream.department.sem.subject]',
				'errors' => array(
                        'required' => 'You must provide a %s.',
						'is_unique_multiple' => 'This %s for the sem already exists.'
						),
        ),
		array('field' => 'batch','label' => 'Batch','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'sem','label' => 'Semester','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'stream','label' => 'Stream','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'department','label' => 'Department','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'schedule_date','label' => 'Schedule Date','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'section','label' => 'Section','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		);
		$this->form_validation->set_rules($config);
		if(isset($_POST['submit'])){
		if ($this->form_validation->run() === FALSE) { 
		    $data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
			$data['section1']=$section = $this->input->post('section');
         $data['form_err']=$this->session->set_flashdata('form_err','Please check all the details','warning'); 
         } 
         else {
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
			$data['schedule_date']=$schedule_date = date('Y-m-d',strtotime($this->input->post('schedule_date')));
			$data['section1']=$section = $this->input->post('section');
		
		$batch_id = $this->db->where('batch_from',$batch)->get('erp_batchmaster')->row();
		$data = array(
		'batch_id' => $batch_id->id,
		'batch_year' => $batch,
		'main_id' => $stream,
		'course_id' => $department,
		'subject_id' => $subject,
		'sem' => $sem,
		'schedule_date' => $schedule_date,
		'section' => $section,
		'user_id' => $user_id,
		'created_at' => $add_date,
		);
		
		$insert = $this->db->insert('erp_exam_schedule',$data);
		if($insert){
		$data['msg']=$this->session->set_flashdata('success','Added Successfully','success');
        redirect('coe/examScheduleAdd','refresh');		
		}
		}
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/examScheduleAdd',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function examScheduleDelete()
	{
		$id=$this->uri->segment(3);
		$this->db->where('id',$id);
		$this->db->delete('erp_exam_schedule');
		$data['msg']=$this->session->set_flashdata('success','Deleted Successfully','success'); 
		redirect('coe/examSchedule','refresh');
    }
	
	public function examScheduleUpdate()
	{
		$id=$this->input->post('id');
		$date = $this->db->where('id',$id)->get('erp_exam_schedule')->row();
		echo json_encode($date);
    }
	
	public function otherClosingDates()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['batch1'] = '';
		$data['sem1'] = '';
		$config = array(
		array('field' => 'batch','label' => 'Batch','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'sem','label' => 'Semester','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		);
		if(isset($_POST['submit'])){
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) { 
         $data['form_err']=$this->session->set_flashdata('form_err','Please check all the details','warning'); 
         } 
         else {
		 $batch_id = $data['batch1'] = $this->input->post('batch');
		 $sem = $data['sem1'] = $this->input->post('sem');
		 $data['date_list'] = $this->db->where('batch_id',$batch_id)->where('sem',$sem)->get('erp_examwise_other_closing_dates')->row();
		}
		 }	
        if(isset($_POST['submit_edit'])){
		 $edit_id = $this->input->post('edit_id');
		$batch_year = $this->db->where('id',$this->input->post('batch'))->get('erp_batchmaster')->row();
		$batchyear = $batch_year->batch_from;
		if($this->input->post('online_arrear')!=''){
		$online_arrear=date('Y-m-d',strtotime($this->input->post('online_arrear')));}else{$online_arrear=null;}
		if($this->input->post('result_publish')!=''){
		$result_publish=date('Y-m-d',strtotime($this->input->post('result_publish')));}else{$result_publish=null;}
		if($this->input->post('online_pay_start')!=''){
		$online_pay_start=date('Y-m-d',strtotime($this->input->post('online_pay_start')));}else{$online_pay_start=null;}
		if($this->input->post('online_pay_end_wo_penalty')!=''){
		$online_pay_end_wo_penalty=date('Y-m-d',strtotime($this->input->post('online_pay_end_wo_penalty')));}else{$online_pay_end_wo_penalty=null;}
		if($this->input->post('online_pay_end')!=''){
		$online_pay_end=date('Y-m-d',strtotime($this->input->post('online_pay_end')));}else{$online_pay_end=null;}
		if($this->input->post('payment_coe')!=''){
		$payment_coe=date('Y-m-d',strtotime($this->input->post('payment_coe')));}else{$payment_coe=null;}
		if($this->input->post('hallticket_issue')!=''){
		$hallticket_issue=date('Y-m-d',strtotime($this->input->post('hallticket_issue')));}else{$hallticket_issue=null;}
		if($this->input->post('revaluation_end')!=''){
		$revaluation_end=date('Y-m-d',strtotime($this->input->post('revaluation_end')));}else{$revaluation_end=null;}
		if($this->input->post('result_dspl_date')!=''){
		$result_dspl_date=date('Y-m-d',strtotime($this->input->post('result_dspl_date')));}else{$result_dspl_date=null;}
		if($this->input->post('result_dspl_time')!=''){
		$result_dspl_time=date('H:i:s',strtotime($this->input->post('result_dspl_time')));}else{$result_dspl_time=null;}
		if($this->input->post('reval_dspl_date')!=''){
		$reval_dspl_date=date('Y-m-d',strtotime($this->input->post('reval_dspl_date')));}else{$reval_dspl_date=null;}
		if($this->input->post('reval_dspl_time')!=''){
		$reval_dspl_time=date('H:i:s',strtotime($this->input->post('reval_dspl_time')));}else{$reval_dspl_time=null;}
		 $data_add = array(
		  'batch_id' => $this->input->post('batch'),
		  'batch_year' => $batchyear,
		  'sem' => $this->input->post('sem'),
		  'online_arrear' => $online_arrear,
		  'result_publish' => $result_publish,
		  'online_pay_start' => $online_pay_start,
		  'online_pay_end_wo_penalty' => $online_pay_end_wo_penalty,
		  'online_pay_end' => $online_pay_end,
		  'payment_coe' => $payment_coe,
		  'hallticket_issue' => $hallticket_issue,
		  'revaluation_end' => $revaluation_end,
		  'exam_conduction_mnth' => $this->input->post('exam_conduction_mnth'),
		  'exam_mode' => $this->input->post('exam_mode'),
		  'exam_conduction_year' => $this->input->post('exam_conduction_year'),
		  'result_dspl_date' => $result_dspl_date,
		  'result_dspl_time' => $result_dspl_time,
		  'reval_dspl_date' => $reval_dspl_date,
		  'reval_dspl_time' => $reval_dspl_time,
		 );
		  if($edit_id != '') {
		$this->db->where('id',$edit_id);
		$update = $this->db->update('erp_examwise_other_closing_dates',$data_add);
		  }else{
			 $data_add['user_id'] =  $user_id;
			 $data_add['created_at'] =  $add_date;
		$insert = $this->db->insert('erp_examwise_other_closing_dates',$data_add);	  
		  }
		$batch_id = $data['batch1'] = $this->input->post('batch');
		$sem = $data['sem1'] = $this->input->post('sem');
		$data['date_list'] = $this->db->where('batch_id',$batch_id)->where('sem',$sem)->get('erp_examwise_other_closing_dates')->row();
		$data['msg']=$this->session->set_flashdata('success','Updated Successfully','success');
		 }			 
		
    $this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/other_closing_dates',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function icaNotInitiated()
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
		
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/ica_not_initiated',$data);
    $this->load->view('template/coe/footer');	
	}
	
	public function condonationFee()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$fee = $this->db->get('erp_condonation_fee')->row();
		if(isset($fee)){
		$data['fees']=$fee->fees;
		$data['edit_id']=$fee->id;
		}else{
		$data['fees']='';
		$data['edit_id']='';	
		}
		
		
		if(isset($_POST['submit'])){
		$data['fees'] = $fees = $this->input->post('fees');	
		$data['edit_id'] = 	$edit_id = $this->input->post('edit_id');
			if($edit_id == ''){
			$data_add['fees']=$fees;
			$data_add['user_id']=$user_id;
			$data_add['created_at']=$add_date;
        $this->db->insert('erp_condonation_fee',$data_add);		
			}else{
			$data_add['fees']=$fees;
		$this->db->where('id',$edit_id);
        $this->db->update('erp_condonation_fee',$data_add);	
			}
		$data['msg']=$this->session->set_flashdata('success','Updated Successfully','success');	
		redirect('coe/condonationFee','refresh');
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/condonation_fee',$data);
    $this->load->view('template/coe/footer');	
	}
	
	
	public function blocks()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$get_block = $this->db->select_max('block_id')->from('erp_blocks')->get()->row();
		if($get_block->block_id != ''){
			$getblock = explode('K',$get_block->block_id);
 		$id = $getblock[1] + 1; 
        $data['block_id'] = $block_id = 'BLOCK' . str_pad($id, 3, "0", STR_PAD_LEFT);
		}else{
		$id = 1; 
        $data['block_id'] = $block_id = 'BLOCK' . str_pad($id, 3, "0", STR_PAD_LEFT);	
		}
		
		$data['block_list'] = $this->db->get('erp_blocks')->result();
		
		
		$config = array(
		array('field' => 'block_name','label' => 'Block Name','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		);
		if(isset($_POST['submit'])){
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) { 
         $data['form_err']=$this->session->set_flashdata('form_err','Please check all the details','warning'); 
         } 
         else {
			$data['block_id']= $block_id = $this->input->post('block_id');
			$data['block_name']= $block_name = $this->input->post('block_name');
			$data['edit_id']= $edit_id = $this->input->post('edit_id');
			
			if($edit_id == ''){
			$data_add = array(
			'block_id' => $block_id,
			'block_name' => $block_name,
			'user_id' => $user_id,
			'created_at' => $add_date,
			);
		 $this->db->insert('erp_blocks',$data_add);
		 $st = 'Added';
			}else{
			$data_add = array(
		  'block_name' => $this->input->post('block_name'),
		 );
		  
		$this->db->where('id',$edit_id);
		$update = $this->db->update('erp_blocks',$data_add);	
		$st = 'Edited';
			}		 
		}
		$data['msg']=$this->session->set_flashdata('success',''.$st.' Successfully','success');
		redirect('coe/blocks','refresh');
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/blocks',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function blocksUpdate()
	{
		$id=$this->input->post('id');
		$date = $this->db->where('id',$id)->get('erp_blocks')->row();
		echo json_encode($date);
    }
	
	public function blocksDelete()
	{
		$id=$this->uri->segment(3);
		$this->db->where('id',$id);
		$this->db->delete('erp_blocks');
		$data['msg']=$this->session->set_flashdata('success','Deleted Successfully','success'); 
		redirect('coe/blocks','refresh');
    }
	
	public function rooms()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['room_list'] = $this->db->get('erp_rooms')->result();
		
		
		$config = array(
		array('field' => 'room_no','label' => 'Room Number','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'room_name','label' => 'Room Name','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'block','label' => 'Block','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'seater','label' => 'Seater Type','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'capacity','label' => 'Capacity','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'rows','label' => 'Rows','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'columns','label' => 'Columns','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		);
		if(isset($_POST['submit'])){
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) { 
         $data['form_err']=$this->session->set_flashdata('form_err','Please check all the details','warning'); 
         } 
         else {
			$block = $this->input->post('block');
			$room_no = $this->input->post('room_no');
			$room_name = $this->input->post('room_name');
			$seater = $this->input->post('seater');
			$capacity = $this->input->post('capacity');
			$rows = $this->input->post('rows');
			$columns = $this->input->post('columns');
			$edit_id = $this->input->post('edit_id');
			
			if($edit_id == ''){
			$data_add = array(
			'block_id' => $block,
			'room_no' => $room_no,
			'room_name' => $room_name,
			'seater' => $seater,
			'capacity' => $capacity,
			'rows' => $rows,
			'columns' => $columns,
			'user_id' => $user_id,
			'created_at' => $add_date,
			);
		 $this->db->insert('erp_rooms',$data_add);
		 $st = 'Added';
			}else{
			$data_add = array(
		  'block_id' => $block,
		  'room_no' => $room_no,
		  'room_name' => $room_name,
		  'seater' => $seater,
		  'capacity' => $capacity,
		  'rows' => $rows,
		  'columns' => $columns,
		 );
		  
		$this->db->where('id',$edit_id);
		$update = $this->db->update('erp_rooms',$data_add);	
		$st = 'Edited';
			}		 
		}
		$data['msg']=$this->session->set_flashdata('success',''.$st.' Successfully','success');
		redirect('coe/rooms','refresh');
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/rooms',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function roomsUpdate()
	{
		$id=$this->input->post('id');
		$date = $this->db->where('id',$id)->get('erp_rooms')->row();
		echo json_encode($date);
    }
	
	public function roomsDelete()
	{
		$id=$this->uri->segment(3);
		$this->db->where('id',$id);
		$this->db->delete('erp_rooms');
		$data['msg']=$this->session->set_flashdata('success','Deleted Successfully','success'); 
		redirect('coe/rooms','refresh');
    }

	
	public function roomAllocation()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['sem1']='';
		$data['section1']='';
		
		
		$config = array(
		array('field' => 'batch','label' => 'Batch','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'sem','label' => 'Semester','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'section','label' => 'Section','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		);
		if(isset($_POST['submit'])){
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) { 
         $data['form_err']=$this->session->set_flashdata('form_err','Please check all the details','warning'); 
         } 
         else {
			$data['batch1']=$batch = $this->input->post('batch');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['section1']=$section = $this->input->post('section');
		$data['room_list'] = $this->db->select('*,sum(no_of_students) as total_students')
		->where('batch_year',$batch)
		->where('sem',$sem)
		->where('section',$section)
		->group_by('room_id')
		->get('erp_room_allocation')->result();
		}
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/roomAllocation',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function roomAllocationView()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['room1'] = $room_id=$this->uri->segment('3');
		$data['section1'] = $section=$this->uri->segment('4');
		$data['batch1'] = $batch_year=$this->uri->segment('5');
		$data['sem1'] = $sem=$this->uri->segment('6');
		$data['schedule_date1'] = $schedule_date=$this->uri->segment('7');
		$data['subject1'] = $subject=$this->uri->segment('8');
		$data['room_list'] = $rooms_list = $this->db->select('id,block_id,room_id,sem,subject_id,section,batch_year,main_id,course_id,schedule_date,sum(no_of_students) as total_students')->where('batch_year',$batch_year)->where('sem',$sem)->where('room_id',$room_id)->where('section',$section)->where('schedule_date',$schedule_date)->group_by('main_id,course_id,subject_id')->from('erp_room_allocation')->get()->result();
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/roomAllocationView',$data);
    $this->load->view('template/coe/footer');
    }
	
	
	public function roomAllocationAdd()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$year=date('Y');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['stream']='';
		$data['department']='';
		$data['sem1']='';
		$data['section1']='';
		$data['no_of_students1']='';
		$data['block1']='';
		$data['room1']='';
		$data['schedule_date1']='';
		$data['exam_type1']='';
		
		
		$config = array(
		array('field' => 'batch','label' => 'Batch','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'sem','label' => 'Semester','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'stream','label' => 'Stream','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'department','label' => 'Department','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'schedule_date','label' => 'Schedule Date','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'section','label' => 'Section','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'subject','label' => 'Subject','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'no_of_students','label' => 'No Of Students','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'block_id','label' => 'Block','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		//array('field' => 'room_id','label' => 'Rooms No.','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array(
                'field' => 'room_id',
                'label' => 'Room',
                'rules' => 'required|is_unique_multiple[erp_room_allocation, batch_year.sem.section.schedule_date.room_id.subject_id,batch.sem.section.schedule_date.room_id.subject]',
				'errors' => array(
                        'required' => 'You must provide a %s.',
						'is_unique_multiple' => 'This %s has already been allocated for the subject.'
						),
        ),
		);
		$this->form_validation->set_rules($config);
		if(isset($_POST['submit'])){
		if($this->input->post('exam_type')==0){
		if ($this->form_validation->run() === FALSE) { 
		    $data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
			$data['section1']=$section = $this->input->post('section');
			$data['no_of_students1']=$no_of_students = $this->input->post('no_of_students');
			$data['block1']=$block_id = $this->input->post('block_id');
			$data['room1']=$room_id = $this->input->post('room_id');
			$data['schedule_date1']=$schedule_date = $this->input->post('schedule_date');
			$data['exam_type1']=$exam_type = $this->input->post('exam_type');
         $data['form_err']=$this->session->set_flashdata('form_err','Please check all the details','warning'); 
         } 
         else {
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
			//$data['schedule_date']=$schedule_date = date('Y-m-d',strtotime($this->input->post('schedule_date')));
			$data['section1']=$section = $this->input->post('section');
			$data['no_of_students1']=$no_of_students = $this->input->post('no_of_students');
			$data['block1']=$block_id = $this->input->post('block_id');
			$data['room1']=$room_id = $this->input->post('room_id');
			$data['schedule_date1']=$schedule_date = $this->input->post('schedule_date');
			$data['exam_type1']=$exam_type = $this->input->post('exam_type');
		$same_seat = 0;
		$rows = $this->input->post('rows');
		for($s=0; $s<sizeof($rows); $s++){
		$cols = $this->input->post('cols_'.$s.'');
			if(!empty($cols)){
		//$columns = implode(',',$cols);
		$get_seat = $this->db
		            ->where('batch_year',$batch)
		            ->where('main_id',$stream)
		            ->where('course_id',$department)
		            //->where('subject_id',$subject)
		            ->where('sem',$sem)
		            ->where('section',$section)
		            ->where('schedule_date',$schedule_date)
		            ->where('block_id',$block_id)
		            ->where('room_id',$room_id)
		            ->where('rows',$rows[$s])
		            ->get('erp_rows_cols')->row();
		if(isset($get_seat)){
		$result=array_intersect(explode(',',$get_seat->columns),$cols);
		if(sizeof($result) > 0){
			$data['msg']=$this->session->set_flashdata('success','Seat Already Allocated for another subject in Row-'.$rows[$s].'','success');
            redirect('coe/roomAllocationAdd','refresh');
		}else{
		for($ss=0; $ss<sizeof($cols); $ss++){
			$get_seat = $this->db
		            ->where('batch_year',$batch)
		            ->where('main_id',$stream)
		            ->where('course_id',$department)
		            ->where('subject_id',$subject)
		            ->where('sem',$sem)
		            ->where('section',$section)
		            ->where('schedule_date',$schedule_date)
		            ->where('block_id',$block_id)
		            ->where('room_id',$room_id)
		            ->where('rows',$rows[$s])
		            ->get('erp_rows_cols')->row();
			if(isset($get_seat)){		
			if(in_array(($cols[$ss]-1),explode(',',$get_seat->columns)) OR in_array(($cols[$ss]+1),explode(',',$get_seat->columns))){
			$data['msg']=$this->session->set_flashdata('success','Seat Before or After Column-'.$cols[$ss].' were Allocated for same subject in Row-'.$rows[$s].'','success');
            redirect('coe/roomAllocationAdd','refresh');		
		}
			}
			}
		}
		}
			}
		}
		
		$batch_id = $this->db->where('batch_from',$batch)->get('erp_batchmaster')->row();
		$data = array(
		'batch_id' => $batch_id->id,
		'batch_year' => $batch,
		'main_id' => $stream,
		'course_id' => $department,
		'subject_id' => $subject,
		'sem' => $sem,
		'schedule_date' => $schedule_date,
		'section' => $section,
		'no_of_students' => $no_of_students,
		'block_id' => $block_id,
		'room_id' => $room_id,
		'user_id' => $user_id,
		'created_at' => $add_date,
		'manual' => 1,
		);
		
		$insert = $this->db->insert('erp_room_allocation',$data);
		$insert_id = $this->db->insert_id();
		
		$rows = $this->input->post('rows');
		for($i=0; $i<sizeof($rows); $i++){
		$cols = $this->input->post('cols_'.$i.'');
			if(!empty($cols)){
		$columns = implode(',',$cols);
		$data1 = array(
		'alloted_roomid' => $insert_id,
		'batch_id' => $batch_id->id,
		'batch_year' => $batch,
		'main_id' => $stream,
		'course_id' => $department,
		'subject_id' => $subject,
		'sem' => $sem,
		'schedule_date' => $schedule_date,
		'section' => $section,
		'no_of_students' => $no_of_students,
		'block_id' => $block_id,
		'room_id' => $room_id,
		'rows' => $rows[$i],
		'columns' => $columns,
		'user_id' => $user_id,
		'created_at' => $add_date,
		);
		
		$insert = $this->db->insert('erp_rows_cols',$data1);
			}
		}
		if($insert){
		$data['msg']=$this->session->set_flashdata('success','Added Successfully','success');
        redirect('coe/roomAllocationAdd','refresh');		
		}
		}
		}else{
			
			
		    $data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
			$data['section1']=$section = $this->input->post('section');
			$data['no_of_students1']=$no_of_students = $this->input->post('no_of_students');
			$data['block1']=$block_id = $this->input->post('block_id');
			$data['room1']=$room_id = $this->input->post('room_id');
			$data['schedule_date1']=$schedule_date = $this->input->post('schedule_date');
			$data['exam_type1']=$exam_type = $this->input->post('exam_type');
			
			$rows = $this->input->post('rows');
		for($i=0; $i<sizeof($rows); $i++){
		$cols = $this->input->post('cols_'.$i.'');
			if(!empty($cols)){
			//$columns = implode(',',$cols);	
			for($ii=0; $ii<sizeof($cols); $ii++){
			$stu_det = $this->db
	->where('applied_year',$year)
	//->where('main_id',$stream)
	//->where('course_id',$department)
	//->where('sem',$sem)
	//->where('subject_id',$subject)
	->where('schedule_date',$schedule_date)
	->where('section',$section)
	->where('room_id',$room_id)
	->where('rows',$rows[$i])
	->where('columns',$cols[$ii])
	//->where('student_id',$student_id)	
	->get('erp_rows_cols_arrear')->row();
	
			$batch_id = $this->db->where('batch_from',$batch)->get('erp_batchmaster')->row();
			$seat_no = $this->seatNo(($rows[$i]),$cols[$ii],$room_id);
	$data = array(
		//'applied_batch_id' => $batch_id->id,
		//'applied_batch_year' => $batch,
		'applied_year' => $year,
		'main_id' => $stream,
		'course_id' => $department,
		'subject_id' => $subject,
		//'student_id' => $student_id,
		'sem' => $sem,
		'schedule_date' => $schedule_date,
		'section' => $section,
		'seat_no' => $seat_no,
		'no_of_students' => '1',
		'block_id' => $block_id,
		'room_id' => $room_id,
		'rows' => $rows[$i],
		'columns' => $cols[$ii],
		'user_id' => $user_id,
		'created_at' => $add_date,
		);
	
	if(!isset($stu_det)){
		$insert = $this->db->insert('erp_rows_cols_arrear',$data);
	}else{
		$insert = $this->db
	->where('applied_year',$year)
	//->where('main_id',$stream)
	//->where('course_id',$department)
	//->where('sem',$sem)
	//->where('subject_id',$subject)
	->where('schedule_date',$schedule_date)
	->where('section',$section)
	->where('room_id',$room_id)
	->where('rows',$rows[$i])
	->where('columns',$cols[$ii])
	->update('erp_rows_cols_arrear',$data);
	}
			}
			}
		}
			
			if($insert){
		$data['msg']=$this->session->set_flashdata('success','Added Successfully','success');
        redirect('coe/roomAllocationAdd','refresh');		
		}
		
		}
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/roomAllocationAdd',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function arrearManualSeating()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$year=date('Y');
		
		$data['block1']='';
		$data['room1']='';
		$data['schedule_date1']='';
		
		if(isset($_POST['submit'])){
			$data['block1']=$block_id = $this->input->post('block_id');
			$data['room1']=$room_id = $this->input->post('room_id');
			$data['schedule_date1']=$schedule_date = $this->input->post('schedule_date');
			$data['alloted_seat']=$this->db->select('e.id as stu_id,e.reg_no_,e.student_name_,e.batch_,s.subName,r.room_name,ar.*')->join('erp_rooms r','r.id=ar.room_id')->join('erp_subjectmaster s','s.id=ar.subject_id')->join('erp_existing_students e','left(e.batch_,4)=s.batch_year')->join('erp_arrear_detail a','a.student_id=e.id and a.subject_id=ar.subject_id')->where('ar.applied_year',$year)->where('ar.schedule_date',$schedule_date)->where('ar.room_id',$room_id)->where('a.applied_year',$year)->group_by('ar.id,a.id')->order_by('ar.seat_no','asc')->get('erp_rows_cols_arrear ar')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/arrearManualSeating',$data);
    $this->load->view('template/coe/footer');
	
		}
		
		public function allocateArrSeat()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$year=date('Y');
		
		$room = $this->input->post('ids_room');
		$student = $this->input->post('ids_stu');
		
		for($i=0; $i<sizeof($room); $i++){
			$this->db->where('id',$room[$i]);
			$this->db->update('erp_rows_cols_arrear',array('student_id'=>$student[$i]));
		}
	     echo 'success';
		}
	
	public function roomAllocationEdit1()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$batch = $this->input->post('batch');
		$sem = $this->input->post('sem');
		$stream = $this->input->post('stream');
		$department = $this->input->post('department');
		$subject = $this->input->post('subject');
		$section = $this->input->post('section');
		$no_of_students = $this->input->post('no_of_students');
		$block_id = $this->input->post('block_id');
		$room_id = $this->input->post('room_id');
		$schedule_date = $this->input->post('schedule_date');
			
		$batch_id = $this->db->where('batch_from',$batch)->get('erp_batchmaster')->row();
		$data = array(
		'batch_id' => $batch_id->id,
		'batch_year' => $batch,
		'main_id' => $stream,
		'course_id' => $department,
		'subject_id' => $subject,
		'sem' => $sem,
		'schedule_date' => $schedule_date,
		'section' => $section,
		'no_of_students' => $no_of_students,
		'block_id' => $block_id,
		'room_id' => $room_id,
		'user_id' => $user_id,
		'created_at' => $add_date,
		);
		
		$insert = $this->db->insert('erp_room_allocation',$data);
		echo $this->db->insert_id();
    }
	
	public function roomAllocationEdit()
	{
		
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		
			$value = $this->input->post('val');
			$val = '';
			foreach($value as $key => $link) 
                { 
               if($link !== '') 
               { 
                 $val = $link; 
               }
                } 
			
			
			$data['batch1']=$batch = $this->input->post('batch_'.$val.'');
			$data['subject1']=$subject = $this->input->post('subject_'.$val.'');
			$data['sem1']=$sem = $this->input->post('sem_'.$val.'');
			$data['stream']=$stream = $this->input->post('main_id_'.$val.'');
			$data['department']=$department = $this->input->post('course_id_'.$val.'');
			$data['section1']=$section = $this->input->post('section_'.$val.'');
			$data['no_of_students1']=$no_of_students = $this->input->post('no_of_students_'.$val.'');
			$data['block1']=$block_id = $this->input->post('block_id_'.$val.'');
			$data['room1']=$room_id = $this->input->post('room_id_'.$val.'');
			$data['edit_id']=$edit_id = $this->input->post('edit_id_'.$val.'');
			$data['remaining_spaces']=$remaining_spaces = $this->input->post('remaining_spaces_'.$val.'');
			$data['remaining_students']=$remaining_students = $this->input->post('remaining_students_'.$val.'');
			$data['schedule_date']=$schedule_date = $this->input->post('schedule_date_'.$val.'');
				
			
		$config = array(
		array('field' => 'no_of_students','label' => 'No Of Students','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		);
		$this->form_validation->set_rules($config);
		if(isset($_POST['submit'])){
		if ($this->form_validation->run() === FALSE) { 
		    $data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
			$data['section1']=$section = $this->input->post('section');
			$data['no_of_students1']=$no_of_students = $this->input->post('no_of_students');
			$data['block1']=$block_id = $this->input->post('block_id');
			$data['room1']=$room_id = $this->input->post('room_id');
			$data['edit_id']=$edit_id = $this->input->post('edit_id');
			$data['remaining_spaces']=$remaining_spaces = $this->input->post('remaining_spaces');
			$data['remaining_students']=$remaining_students = $this->input->post('remaining_students');
			$data['schedule_date']=$schedule_date = $this->input->post('schedule_date');
         $data['form_err']=$this->session->set_flashdata('form_err','Please check all the details','warning'); 
         } 
         else {
			
		    $data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
			$data['section1']=$section = $this->input->post('section');
			$data['no_of_students1']=$no_of_students = $this->input->post('no_of_students');
			$data['block1']=$block_id = $this->input->post('block_id');
			$data['room1']=$room_id = $this->input->post('room_id');
			$data['edit_id']=$edit_id = $this->input->post('edit_id');
			$data['remaining_spaces']=$remaining_spaces = $this->input->post('remaining_spaces');
			$data['remaining_students']=$remaining_students = $this->input->post('remaining_students');
			$data['schedule_date']=$schedule_date = $this->input->post('schedule_date');
			
		
		$batch_id = $this->db->where('batch_from',$batch)->get('erp_batchmaster')->row();
		$data = array(
		'no_of_students' => $no_of_students,
		);
		
		$this->db->where('id',$edit_id);
		$insert = $this->db->update('erp_room_allocation',$data);
		
		$this->db->where('alloted_roomid',$edit_id);
		$this->db->delete('erp_rows_cols');
		
		$rows = $this->input->post('rows');
		for($i=0; $i<sizeof($rows); $i++){
		$cols = $this->input->post('cols_'.$i.'');
			if(!empty($cols)){
		$columns = implode(',',$cols);
		$data1 = array(
		'alloted_roomid' => $edit_id,
		'batch_id' => $batch_id->id,
		'batch_year' => $batch,
		'main_id' => $stream,
		'course_id' => $department,
		'subject_id' => $subject,
		'sem' => $sem,
		'schedule_date' => $schedule_date,
		'section' => $section,
		'no_of_students' => sizeof($cols),
		'block_id' => $block_id,
		'room_id' => $room_id,
		'rows' => $rows[$i],
		'columns' => $columns,
		'user_id' => $user_id,
		'created_at' => $add_date,
		);
		
		$insert = $this->db->insert('erp_rows_cols',$data1);
			}
		}
		
		$data['msg']=$this->session->set_flashdata('success','Edited Successfully','success');
        redirect('coe/roomAllocationView/'.$room_id.'/'.$section.'/'.$batch.'/'.$sem.'','refresh');		
		
		}
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/roomAllocationEdit',$data);
    $this->load->view('template/coe/footer');
    }
	
	
	public function getRooms()
	{
	$block_id=$this->input->post('block_id');
	
    $room = $this->db->where('block_id',$block_id)->get('erp_rooms')->result();	
	
	$rooms = '<option value="">Select Room</option>';
	foreach($room as $room){
		$rooms .= '<option value="'.$room->id.'">'.$room->room_name.'</option>';
	}
	echo $rooms;
    }
	
	public function getRemainingSpaces()
	{
	$block_id=$this->input->post('block_id');
	$room_id=$this->input->post('room_id');
	$batch_year=$this->input->post('batch_id');
	$sem=$this->input->post('sem');
	$section=$this->input->post('section');
	$schedule_date=$this->input->post('schedule_date');
	$year=date('Y');
	
    $room = $this->db->where('id',$room_id)->get('erp_rooms')->row();	
	
    //$rooms = $this->db->select('sum(no_of_students) as tot_no_of_students')->where('section',$section)->where('room_id',$room_id)->where('batch_year',$batch_year)->where('sem',$sem)->where('schedule_date',$schedule_date)->get('erp_room_allocation')->row();
    $rooms = $this->db->select('sum(no_of_students) as tot_no_of_students')->where('section',$section)->where('room_id',$room_id)->where('schedule_date',$schedule_date)->get('erp_room_allocation')->row();

	//$rooms_arrear = $this->db->where('section',$section)->where('room_id',$room_id)->where('applied_year',$year)->where('sem',$sem)->get('erp_rows_cols_arrear')->num_rows();
	$rooms_arrear = $this->db->where('section',$section)->where('room_id',$room_id)->where('applied_year',$year)->where('schedule_date',$schedule_date)->get('erp_rows_cols_arrear')->num_rows();

    $capacity = $room->capacity - ($rooms->tot_no_of_students + $rooms_arrear);
	
	echo $capacity;
    }
	
	public function getRemainingStudentsSubj()
	{
	$batch_year=$this->input->post('batch_id');
	$sem=$this->input->post('sem');
	$subject=$this->input->post('subject');
	$stream=$this->input->post('stream');
	$department=$this->input->post('department');
	$year=date('Y');
	
    $room = $this->db->where('id',$room_id)->get('erp_rooms')->row();	
	
    $rooms = $this->db->select('sum(no_of_students) as tot_no_of_students')->where('subject_id',$subject)->where('batch_year',$batch_year)->get('erp_room_allocation')->row();

	//$rooms_arrear = $this->db->where('subject_id',$subject)->where('applied_year',$year)->get('erp_rows_cols_arrear')->num_rows();
	
	$subj = $this->db->where('id',$subject)->get('erp_subjectmaster')->row();
	$tot_students = $this->db->where('main_id',$subj->stream)->where('cour_id',$subj->department)->where('LEFT(erp_existing_students.batch_, 4)="'.$batch_year.'"')->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')->get('erp_existing_students')->num_rows();
	if($subj->part==1 || $subj->part==4){
	$tot_students = $this->db->join('erp_langallot l','s.id=l.subject_id')->join('erp_existing_students e','e.id=l.existing_student_id')->where('s.subCode',$subj->subCode)->where('s.batch_year',$batch_year)->where('e.main_id',$stream)->where('e.cour_id',$department)->where('l.status',1)->where('(e.left_status = 0 AND e.long_absent = 0)')->get('erp_subjectmaster s')->num_rows();	
	}
	if($subj->subCatg=='Elective'){
	$tot_students = $this->db->join('erp_existing_students e','e.id=s.e_admit_stu_id')->where('s.e_subject',$subject)->where('e.main_id',$stream)->where('e.cour_id',$department)->where('(e.left_status = 0 AND e.long_absent = 0)')->get('erp_student_elective_subject s')->num_rows();	
	}

    //$capacity = $tot_students - ($rooms->tot_no_of_students + $rooms_arrear);
	$capacity = $tot_students - $rooms->tot_no_of_students;
	
	echo $capacity;
    }
	
	public function getRemainingSpacesEdit()
	{
	$id=$this->input->post('id');
	$block_id=$this->input->post('block_id');
	$room_id=$this->input->post('room_id');
	$batch_year=$this->input->post('batch_id');
	$sem=$this->input->post('sem');
	$section=$this->input->post('section');
	$schedule_date=$this->input->post('schedule_date');
	$year=date('Y');
	
    $room = $this->db->where('id',$room_id)->get('erp_rooms')->row();	
	
    //$rooms = $this->db->select('sum(no_of_students) as tot_no_of_students')->where('id!='.$id.'')->where('section',$section)->where('room_id',$room_id)->where('batch_year',$batch_year)->where('sem',$sem)->where('schedule_date',$schedule_date)->get('erp_room_allocation')->row();
    $rooms = $this->db->select('sum(no_of_students) as tot_no_of_students')->where('id!='.$id.'')->where('section',$section)->where('room_id',$room_id)->where('schedule_date',$schedule_date)->get('erp_room_allocation')->row();

	//$rooms_arrear = $this->db->where('section',$section)->where('room_id',$room_id)->where('applied_year',$year)->where('sem',$sem)->get('erp_rows_cols_arrear')->num_rows();
	$rooms_arrear = $this->db->where('section',$section)->where('room_id',$room_id)->where('applied_year',$year)->where('schedule_date',$schedule_date)->get('erp_rows_cols_arrear')->num_rows();

    $capacity = $room->capacity - ($rooms->tot_no_of_students + $rooms_arrear);
	
	echo $capacity;
    }
	
	public function getRemainingStudentsSubjEdit()
	{
	$id=$this->input->post('id');
	$batch_year=$this->input->post('batch_id');
	$sem=$this->input->post('sem');
	$subject=$this->input->post('subject');
	$stream=$this->input->post('stream');
	$department=$this->input->post('department');
	$year=date('Y');
	
    $room = $this->db->where('id',$room_id)->get('erp_rooms')->row();	
	
    $rooms = $this->db->select('sum(no_of_students) as tot_no_of_students')->where('id!='.$id.'')->where('subject_id',$subject)->where('batch_year',$batch_year)->get('erp_room_allocation')->row();

	//$rooms_arrear = $this->db->where('subject_id',$subject)->where('applied_year',$year)->get('erp_rows_cols_arrear')->num_rows();
	
	$subj = $this->db->where('id',$subject)->get('erp_subjectmaster')->row();
	$tot_students = $this->db->where('main_id',$subj->stream)->where('cour_id',$subj->department)->where('LEFT(erp_existing_students.batch_, 4)="'.$batch_year.'"')->get('erp_existing_students')->num_rows();
	if($subj->part==1 || $subj->part==2 || $subj->part==4){
	$tot_students = $this->db->join('erp_langallot l','s.id=l.subject_id')->join('erp_existing_students e','e.id=l.existing_student_id')->where('s.subCode',$subj->subCode)->where('e.main_id',$stream)->where('e.cour_id',$department)->where('l.status',1)->get('erp_subjectmaster s')->num_rows();
	}
	if($subj->subCatg=='Elective'){
	$tot_students = $this->db->where('subject_id',$subject)->where('cour_id',$subj->department)->get('erp_student_elective_subject')->num_rows();	
	}

    //$capacity = $tot_students - ($rooms->tot_no_of_students + $rooms_arrear);
	$capacity = $tot_students - $rooms->tot_no_of_students;
	
	echo $capacity;
    }
	
	public function roomAllocationDelete()
	{
		$main_id=$this->uri->segment(3);
		$course_id=$this->uri->segment(4);
		$sem=$this->uri->segment(5);
		$batch_year=$this->uri->segment(6);
		$section=$this->uri->segment(7);
		$room_id=$this->uri->segment(8);
		$subject_id=$this->uri->segment(9);
		$schedule_date=$this->uri->segment(10);
		$this->db->where('main_id',$main_id);
		$this->db->where('course_id',$course_id);
		$this->db->where('sem',$sem);
		$this->db->where('batch_year',$batch_year);
		$this->db->where('section',$section);
		$this->db->where('room_id',$room_id);
		$this->db->where('subject_id',$subject_id);
		$this->db->where('schedule_date',$schedule_date);
		$this->db->delete('erp_room_allocation');
		
		$this->db->where('main_id',$main_id);
		$this->db->where('course_id',$course_id);
		$this->db->where('sem',$sem);
		$this->db->where('batch_year',$batch_year);
		$this->db->where('section',$section);
		$this->db->where('room_id',$room_id);
		$this->db->where('subject_id',$subject_id);
		$this->db->where('schedule_date',$schedule_date);
		$this->db->delete('erp_rows_cols');
		$data['msg']=$this->session->set_flashdata('success','Deleted Successfully','success'); 
		redirect('coe/roomAllocationView/'.$room_id.'/'.$section.'/'.$batch_year.'/'.$sem.'','refresh');
    }
	
	public function getRows()
	{
	$room_id=$this->input->post('room_id');
	
    $row_det = $this->db->where('id',$room_id)->get('erp_rooms')->row();
    $rows_no = $row_det->rows;	
    $cols_no = $row_det->columns;	
	
	$rows = '';
	
	for($i=0; $i < $rows_no; $i++){
		$rows .= '<div class="col-lg-12 rows">';
		$rows .= '<label>Row '.($i + 1).' </label>';   
		$rows .= '<input type="hidden" name="rows[]" value="'.($i + 1).'">';   
		$rows .= '<select class="form-control row_col multiple-select" name="cols_'.$i.'[]" multiple="multiple">';
		
	  for($ii=0; $ii < $cols_no; $ii++){
		$rows .= '<option value="'.($ii + 1).'"> '.($ii + 1).' </option>';
	  }
	  
		$rows .= '</select>';
		$rows .= '</div>';
	}
	
	$data['rows'] = $rows;
	$data['seater'] = $row_det->seater;
	echo json_encode($data);
    }
	
	public function seatAllocation()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['stream']='';
		$data['department']='';
		$data['sem1']='';
		
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
			$data['sem1']=$sem = $this->input->post('sem');
		
		$sched = $this->db->where('subject_id',$subject)->where('batch_year',$batch)->where('main_id',$stream)->where('course_id',$department)->where('sem',$sem)->get('erp_exam_schedule')->row();	
			
			if(isset($sched)){
				$subj = $this->db->where('id',$subject)->get('erp_subjectmaster')->row();
				if($subj->part==1 || $subj->part==2 || $subj->part==4){
				    $this->db->join('erp_langallot l','erp_existing_students.id=l.existing_student_id','left');
					$this->db->where('l.subject_id',$subject);
					$this->db->where('l.status',1);
				}
				if($subj->subCatg=='Elective'){
				    $this->db->join('erp_student_elective_subject e','erp_existing_students.id=e.e_admit_stu_id','left');
					$this->db->where('e.e_subject',$subject);
				}
				$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->order_by('erp_existing_students.reg_no_','asc')
		->get('erp_existing_students')->result();
		
		$data['row_col_list'] = $row_col_list = $this->db->select('ra.no_of_students as tot_students,rc.*')
		->from('erp_room_allocation ra')
		->join('erp_rows_cols rc','rc.alloted_roomid=ra.id','left')
		->join('erp_rooms ro','rc.room_id=ro.id','left')
		->where('ra.batch_year',$batch)
		->where('ra.section',$sched->section)
		->where('ra.sem',$sem)
		->where('ra.subject_id',$subject)
		->where('ra.main_id',$stream)
		->where('ra.course_id',$department)
		->order_by('ro.room_name','asc')
		->order_by('rc.rows','asc')
		->get()->result();
		
		$seat_det = array();
		$room_id = '';	
		$room_id1 = '';	
		$seat_no = 1;
		for ($i=0; $i<sizeof($row_col_list); $i++) {
		 $cols = explode(',',$row_col_list[$i]->columns);
			for ($ii=0; $ii<sizeof($cols); $ii++) {
			$block = $this->db->where('id',$row_col_list[$i]->block_id)->get('erp_blocks')->row();
			$room = $this->db->where('id',$row_col_list[$i]->room_id)->get('erp_rooms')->row(); 
			$room_id = $room->id;
			$seat_no = $this->seatNo(($row_col_list[$i]->rows),($cols[$ii]),$room_id);
			//if($room_id != $room_id1){$seat_no = 1;}
			$data1['block_id'] = $block->id;
			$data1['block_name'] = $block->block_name;
			$data1['room_id'] = $room->id;
			$data1['room_name'] = $room->room_name;
			$data1['row_list'] = $row_col_list[$i]->rows; 
			$data1['col_list'] = $cols[$ii]; 
			$data1['section'] = $row_col_list[$i]->section; 
			//$data1['seat_no'] = $seat_no++; 
			$data1['seat_no'] = $seat_no; 
			array_push($seat_det,$data1);
			$room_id1 = $room_id;
			}
		}
		$data['seat_det']=$seat_det;
			}else{
			$data['msg']=$this->session->set_flashdata('success','Exam has not been scheduled for the Subject Yet!!','success'); 
		redirect('coe/seatAllocation','refresh');	
			}
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/seatAllocation',$data);
    $this->load->view('template/coe/footer');	
	}
	
	function seatNo($r,$c,$roomId){
		$room=$this->db->where('id',$roomId)->get('erp_rooms')->row();
		if(isset($room)){
		$rows=$room->rows;
		$columns=$room->columns;
		$seat_no=array();
	    $no=1;
		 for($i=1;$i<=$rows;$i++){
			 for($ii=1;$ii<=$columns;$ii++){
				 $seat_no[$i][$ii]=$no++;
			 }
		 }
		}
		return $seat_no[$r][$c];
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
	
	public function allocateSeat()
	{
		$student_id =[];

		$data['user_id']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$batch = $this->input->post('batch');
		$subject = $this->input->post('subject');
		$sem = $this->input->post('sem');
		$stream = $this->input->post('stream');
		$department = $this->input->post('department');
		$section = $this->input->post('section');
		
		$sched = $this->db->where('batch_year',$batch)->where('main_id',$stream)->where('course_id',$department)->where('sem',$sem)->where('subject_id',$subject)->get('erp_exam_schedule')->row();
		$data['schedule_date']=$sched->schedule_date;
			
		    $data['batch_year']=$batch;
			$data['subject_id']=$subject;
			$data['sem']=$sem;
			$data['main_id']=$stream;
			$data['course_id']=$department;
			$data['section']=$section;
			$data['created_at']=$add_date;
			
		
		$batch_id = $this->db->where('batch_from',$batch)->get('erp_batchmaster')->row();
		$data['batch_id']=$batch_id->id;
		
		$student_id = $this->input->post('student');
		$block_id = $this->input->post('block');
		$room_id = $this->input->post('room');
		$rows = $this->input->post('rows');
		$columns = $this->input->post('columns');
		$seat_no = $this->input->post('seat_no');
		
		for($i=0; $i<sizeof($student_id); $i++){
		$get_stu = $this->db->where('batch_year',$batch)->where('student_id',$student_id[$i])->where('section',$section)->where('sem',$sem)->where('subject_id',$subject)->get('erp_seat_allocation')->row();
		
			if(isset($get_stu)){
				
		$data_edit['block_id'] = $block_id[$i];
		$data_edit['room_id'] = $room_id[$i];
		$data_edit['rows'] = $rows[$i];
		$data_edit['columns'] = $columns[$i];
		$data_edit['seat_no'] = $seat_no[$i];
		
		$this->db->where('id',$get_stu->id);
		$insert = $this->db->update('erp_seat_allocation',$data_edit);
			}else{
				
		$data['student_id'] = $student_id[$i];
		$data['block_id'] = $block_id[$i];
		$data['room_id'] = $room_id[$i];
		$data['rows'] = $rows[$i];
		$data['columns'] = $columns[$i];
		$data['seat_no'] = $seat_no[$i];
		
		$insert = $this->db->insert('erp_seat_allocation',$data);		
			}
		}
		echo 'Success';
    }
	
	public function attendancePercentages()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['type1']='';
		$data['stream']='';
		$data['department']='';
		$data['sem1']='';
		
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['type1']=$type = $this->input->post('type');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		//->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/attendancePerc',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function markEligible()
	{
		
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$batch = $this->input->post('batch');
		$batch_id = $this->db->where('batch_from',$batch)->get('erp_batchmaster')->row();
		    $data['batch_id']=$batch_id->id;
		    $data['batch_year']=$batch;
			$data['subject_id']=$subject = $this->input->post('subject');
			$data['sem']=$sem = $this->input->post('sem');
			$data['main_id']=$stream = $this->input->post('stream');
			$data['course_id']=$department = $this->input->post('department');
			$data['student_id']=$student = $this->input->post('student');
			$data['status']=1;
			$data['user_id']=$user_id;
			$data['created_at']=$add_date;
		$insert = $this->db->insert('erp_not_eligible',$data);
		echo 'Success';
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
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/block_hallTicket',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function blockHt()
	{
		
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$batch = $this->input->post('batch');
		$batch_id = $this->db->where('batch_from',$batch)->get('erp_batchmaster')->row();
		    $data['batch_id']=$batch_id->id;
		    $data['batch_year']=$batch;
			$data['type']='COE';
			$data['sem']=$sem = $this->input->post('sem');
			$data['main_id']=$stream = $this->input->post('stream');
			$data['course_id']=$department = $this->input->post('department');
			$data['student_id']=$student = $this->input->post('student');
			$data['status']= $this->input->post('status');
			$data['user_id']=$user_id;
			$data['created_at']=$add_date;
			
		$block_det = $this->db->where('type','COE')->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$student)->get('erp_block_halltickets')->row();
		if(isset($block_det)){
		$data_edit['status']= $this->input->post('status');	
		$this->db->where('id',$block_det->id);
		$update = $this->db->update('erp_block_halltickets',$data_edit);
		}else{
		$insert = $this->db->insert('erp_block_halltickets',$data);
		}
		echo 'Success';
    }
	
	public function particulars()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$get_block = $this->db->select_max('particular_id')->from('erp_particulars')->get()->row();
		if($get_block->particular_id != ''){
			$getblock = explode('R',$get_block->particular_id);
 		$id = $getblock[1] + 1; 
        $data['particular_id'] = $particular_id = 'PAR' . str_pad($id, 3, "0", STR_PAD_LEFT);
		}else{
		$id = 1; 
        $data['particular_id'] = $particular_id = 'PAR' . str_pad($id, 3, "0", STR_PAD_LEFT);	
		}
		
		$data['particular_list'] = $this->db->get('erp_particulars')->result();
		
		
		$config = array(
		array('field' => 'particular_name','label' => 'Particular Name','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		);
		if(isset($_POST['submit'])){
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) { 
         $data['form_err']=$this->session->set_flashdata('form_err','Please check all the details','warning'); 
         } 
         else {
			$data['particular_id']= $particular_id = $this->input->post('particular_id');
			$data['particular_name']= $particular_name = $this->input->post('particular_name');
			$data['edit_id']= $edit_id = $this->input->post('edit_id');
			
			if($edit_id == ''){
			$data_add = array(
			'particular_id' => $particular_id,
			'particular_name' => $particular_name,
			'user_id' => $user_id,
			'created_at' => $add_date,
			);
		 $this->db->insert('erp_particulars',$data_add);
		 $st = 'Added';
			}else{
			$data_add = array(
		  'particular_name' => $this->input->post('particular_name'),
		 );
		  
		$this->db->where('id',$edit_id);
		$update = $this->db->update('erp_particulars',$data_add);	
		$st = 'Edited';
			}		 
		}
		$data['msg']=$this->session->set_flashdata('success',''.$st.' Successfully','success');
		redirect('coe/particulars','refresh');
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/particulars',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function particularsUpdate()
	{
		$id=$this->input->post('id');
		$date = $this->db->where('id',$id)->get('erp_particulars')->row();
		echo json_encode($date);
    }
	
	public function particularsDelete()
	{
		$id=$this->uri->segment(3);
		$this->db->where('id',$id);
		$this->db->delete('erp_particulars');
		$data['msg']=$this->session->set_flashdata('success','Deleted Successfully','success'); 
		redirect('coe/particulars','refresh');
    }
	
	
	public function examFees()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['batch1'] = '';
		$data['sem1'] = '';
		$config = array(
		array('field' => 'batch','label' => 'Batch','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'sem','label' => 'Semester','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		);
		if(isset($_POST['submit'])){
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) { 
         $data['form_err']=$this->session->set_flashdata('form_err','Please check all the details','warning'); 
         } 
         else {
		 $batch = $data['batch1'] = $this->input->post('batch');
		 $sem = $data['sem1'] = $this->input->post('sem');
		 $data['particular_list'] = $this->db->where('batch_year',$batch)->where('sem',$sem)->get('erp_exam_fees')->result();
		}
		 }	
        if(isset($_POST['submit_edit'])){
		 $edit_id = $this->input->post('edit_id');
		
		 $data_add = array(
		  'fees' => $this->input->post('fees_edit'),
		 );
		  
		$this->db->where('id',$edit_id);
		$update = $this->db->update('erp_exam_fees',$data_add);
		$batch = $data['batch1'] = $this->input->post('batch');
		$sem = $data['sem1'] = $this->input->post('sem');
		$data['particular_list'] = $this->db->where('batch_year',$batch)->where('sem',$sem)->get('erp_exam_fees')->result();
		$data['msg']=$this->session->set_flashdata('success','Edited Successfully','success');
		 }			 
		
    $this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/examFees',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function examFeesAdd1()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['sub_list']=$this->db->get('erp_subjectmaster')->result();
		$config = array(
		array('field' => 'batch','label' => 'Batch','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'particular','label' => 'Particular','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'fees','label' => 'Exam Fees','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'sem','label' => 'Semester','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'stream','label' => 'Stream','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
        array(
                'field' => 'department',
                'label' => 'Department',
                'rules' => 'required|is_unique_multiple[erp_exam_fees, batch_year.main_id.course_id.sem.particular_id,batch.stream.department.sem.particular]',
				'errors' => array(
                        'required' => 'You must provide a %s.',
						'is_unique_multiple' => 'This %s for the sem already exists.'
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
		  'main_id' => $this->input->post('stream'),
		  'course_id' => $this->input->post('department'),
		  'fees' => $this->input->post('fees'),
		  'particular_id' => $this->input->post('particular'),
		  'user_id' => $user_id,
		  'created_at' => $add_date,
		 );
		  
		$insert = $this->db->insert('erp_exam_fees',$data_add);
		$data['msg']=$this->session->set_flashdata('success','Added Successfully','success'); 
		redirect('coe/examFeesAdd','refresh');
		}
		 }		
		
    $this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/examFeesAdd1',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function examFeesAdd()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['fees_list'] = $this->db->select('id,particular_id')->group_by('particular_id')->get('erp_exam_fees')->result();
		   
		$data['sub_list']=$this->db->get('erp_subjectmaster')->result();
		$config = array(
		array('field' => 'particular','label' => 'Particular','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'stream','label' => 'Stream','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'fees','label' => 'Exam Fees','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		);
		if(isset($_POST['submit'])){
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) { 
         $data['form_err']=$this->session->set_flashdata('form_err','Please check all the details','warning'); 
         } 
         else {
		   $edit_id = $this->input->post('edit_id');
		
		if($edit_id == ''){
		 $data_add = array(
		  'fees' => $this->input->post('fees'),
		  'particular_id' => $this->input->post('particular'),
		  'main_id' => $this->input->post('stream'),
		  'user_id' => $user_id,
		  'created_at' => $add_date,
		 );
		  
		$insert = $this->db->insert('erp_exam_fees',$data_add);
		$data['msg']=$this->session->set_flashdata('success','Added Successfully','success'); 
		redirect('coe/examFeesAdd');
		}
		else{
		 $data_add = array(
		  'fees' => $this->input->post('fees')
		 );
		  
		  $this->db->where('id',$edit_id);
		$insert = $this->db->update('erp_exam_fees',$data_add);
		$data['msg']=$this->session->set_flashdata('success','Updated Successfully','success'); 
		redirect('coe/examFeesAdd');
		}
		//redirect('coe/examFeesAdd','refresh');
		}
		 }		
		
    $this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/examFeesAdd',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function getParticularFees()
	{
	$particular=$this->input->post('particular');
	$stream=$this->input->post('stream');
	
	$part = $this->db->where('particular_id',$particular)->where('main_id',$stream)->get('erp_exam_fees')->row();	
	
	if(isset($part)){
		$fees_det = array(
		  'fees' => $part->fees,
		  'id' => $part->id,
		);
		}
	else{
		$fees_det = array(
		);
	}
	
	echo json_encode($fees_det);
    }
	
	
	public function examFeesDelete()
	{
		$id=$this->uri->segment(3);
		$this->db->where('id',$id);
		$this->db->delete('erp_exam_fees');
		$data['msg']=$this->session->set_flashdata('success','Deleted Successfully','success'); 
		redirect('coe/examFees','refresh');
    }
	
	public function examFeesUpdate()
	{
		$id=$this->input->post('id');
		$date = $this->db->where('id',$id)->get('erp_exam_fees')->row();
		echo json_encode($date);
    }
	
	public function attendanceSheet()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['stream']='';
		$data['department']='';
		$data['sem1']='';
		$data['schedule_date1']='';
		
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
			$data['schedule_date1']=$schedule_date = $this->input->post('schedule_date');
		$data['room_list'] = $this->db->select('r.*')
		->join('erp_subjectmaster s','s.id=r.subject_id')
		->where('r.batch_year',$batch)
		->where('r.main_id',$stream)
		->where('r.course_id',$department)
		->where('r.sem',$sem)
		//->where('r.subject_id',$subject)
		//->where('r.schedule_date',$schedule_date)
		->get('erp_room_allocation r')->result();
		
		$data['exam_sched'] = $this->db->select('erp_exam_schedule.*')
		->where('erp_exam_schedule.batch_year',$batch)
		->where('erp_exam_schedule.sem',$sem)
		->where('erp_exam_schedule.subject_id',$subject)
		->get('erp_exam_schedule')->row();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/attendanceSheet',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function attendanceSheetView()
	{
		$room_id = $data['room_id'] = $this->uri->segment(3);
		$subject_id = $data['subject_id'] = $this->uri->segment(4);
		$rooms=$this->db->where('id',$room_id)->get('erp_room_allocation')->row();
		$block = $this->db->where('id',$rooms->block_id)->get('erp_blocks')->row();
		$room = $this->db->where('id',$rooms->room_id)->get('erp_rooms')->row();
		$subj = $this->db->where('id',$subject_id)->get('erp_subjectmaster')->row();
		$stream = $subj->stream;
		$department = $subj->department;
		$data['room_name'] = $room->room_name;
		$data['block_name'] = $block->block_name;
		$data['subject_name'] = $subj->subName;
		$data['schedule_date'] = $rooms->schedule_date;
		$data['session'] = $rooms->section;
		$data['seat_list'] = $this->db->select('a.*')
		->join('erp_existing_students e','e.id=a.student_id','left')
		->join('erp_subjectmaster s','s.id=a.subject_id')
		->where('a.batch_year',$rooms->batch_year)
		->where('a.sem',$rooms->sem)
		->where('a.main_id',$stream)
		->where('a.course_id',$department)
		//->where('a.subject_id',$rooms->subject_id)
		->where('a.block_id',$rooms->block_id)
		->where('a.room_id',$rooms->room_id)
		->order_by('e.reg_no_','asc')
		->get('erp_seat_allocation a')->result();
		
		
		$data['exam_sched'] = $this->db->select('erp_exam_schedule.*')
		->where('erp_exam_schedule.batch_year',$rooms->batch_year)
		->where('erp_exam_schedule.sem',$rooms->sem)
		->where('erp_exam_schedule.subject_id',$subject_id)
		->get('erp_exam_schedule')->row();
		
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['stream']='';
		$data['department']='';
		$data['sem1']='';
		$data['schedule_date1']='';
		
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
			$data['schedule_date1']=$schedule_date = $this->input->post('schedule_date');
		$data['room_list'] = $this->db->select('r.*')
		->join('erp_subjectmaster s','s.id=r.subject_id')
		->where('r.batch_year',$batch)
		->where('r.sem',$sem)
		->where('r.main_id',$stream)
		->where('r.course_id',$department)
		->where('r.subject_id',$subject)
		->where('r.schedule_date',$schedule_date)
		->get('erp_room_allocation r')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/attendanceSheetView',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function attendanceSheetPDF()
	{
		$this->load->library("pdf");
		$room_id = $data['room_id'] = $this->uri->segment(3);
		$subject_id = $data['subject_id'] = $this->uri->segment(4);
		$rooms=$this->db->where('id',$room_id)->get('erp_room_allocation')->row();
		$block = $this->db->where('id',$rooms->block_id)->get('erp_blocks')->row();
		$room = $this->db->where('id',$rooms->room_id)->get('erp_rooms')->row();
		$subj = $this->db->where('id',$subject_id)->get('erp_subjectmaster')->row();
		$stream = $subj->stream;
		$department = $subj->department;
		$data['room_name'] = $room_name = $room->room_name;
		$data['block_name'] = $block_name = $block->block_name;
		$data['subject_name'] = $subject_name = $subj->subName;
		$data['subject_code'] = $subject_code = $subj->subCode;
		$data['schedule_date'] = $schedule_date = $rooms->schedule_date;
		$data['session'] = $session = $rooms->section;
		$data['sem'] = $sem = $rooms->sem;
		$data['batch'] = $batch = $rooms->batch_year;
		$data['seat_list'] = $this->db->select('a.*')
		->join('erp_existing_students e','e.id=a.student_id','left')
		->join('erp_subjectmaster s','s.id=a.subject_id')
		->where('a.batch_year',$rooms->batch_year)
		->where('a.sem',$rooms->sem)
		->where('a.main_id',$stream)
		->where('a.course_id',$department)
		//->where('a.subject_id',$rooms->subject_id)
		->where('a.block_id',$rooms->block_id)
		->where('a.room_id',$rooms->room_id)
		->order_by('e.reg_no_','asc')
		->get('erp_seat_allocation a')->result();
		
		
		$data['exam_sched'] = $this->db->select('erp_exam_schedule.*')
		->where('erp_exam_schedule.batch_year',$rooms->batch_year)
		->where('erp_exam_schedule.sem',$rooms->sem)
		->where('erp_exam_schedule.subject_id',$subject_id)
		->get('erp_exam_schedule')->row();
		
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$date=date('Y-m-d');
		
		
			if($sem==1 || $sem==3 || $sem==5){
				$month = 'November';
			}else{
				$month = 'April';
			}
		
		ob_start();
            $html = $this->load->view("coe/attendanceSheetPDF", $data, true);
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
            $dompdf->setPaper("A4", "portrait");
            $dompdf->render();
            ob_end_clean();
            $dompdf->stream("ATTENDANCESHEET_".$subject_code."_".$month." ".$batch.".pdf", ["Attachment" => 1]);
		
    //$this->load->view('coe/hallTicketPDF',$data);
	}
	
	/*public function examiners()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
        $data['examiner_list'] = $this->db->get('erp_examiners')->result();		 
		
    $this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/examiners',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function examinersAdd()
	{
		$data['user_id'] = $user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$config = array(
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
		
		 $data_add = array(
		  'designation' => $this->input->post('designation'),
		  'college' => $this->input->post('college'),
		  'company' => $this->input->post('company'),
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
		  'status' => $this->input->post('status'),
		  'user_id' => $user_id,
		  'created_at' => $add_date,
		 );
		 if($this->input->post('department') != 0){
		  $data_add['department_id'] = $this->input->post('department');
		 }
		  
		$insert = $this->db->insert('erp_examiners',$data_add);
		$data['msg']=$this->session->set_flashdata('success','Added Successfully','success'); 
		redirect('coe/examinersAdd','refresh');
		}
		 }		
		
    $this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/examinersAdd',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function examinersEdit()
	{
		$data['user_id'] = $user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['edit_id'] = $id = $this->uri->segment(3);
		$data['examiner'] = $this->db->where('id',$id)->get('erp_examiners')->row();
		
		$config = array(
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
		 $data_edit = array(
		  'designation' => $this->input->post('designation'),
		  'college' => $this->input->post('college'),
		  'company' => $this->input->post('company'),
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
		redirect('coe/examiners','refresh');
		}
		 }		
		
    $this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/examinersEdit',$data);
    $this->load->view('template/coe/footer');
    }
	public function examinersDelete()
	{
		$data['user_id'] = $user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$id = $this->uri->segment(3);
		$delete = $this->db->where('id',$id)->delete('erp_examiners');
		$data['msg']=$this->session->set_flashdata('success','Deleted Successfully','success'); 
		redirect('coe/examiners','refresh');
	}*/
	
	public function examinerApprove()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['stream']='';
		$data['department']='';
		$data['sem1']='';
		
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
		$data['examiner_list'] = $this->db->select('erp_examiners.*')
		->where('erp_examiners.batch_year',$batch)
		->where('erp_examiners.sem',$sem)
		->where('erp_examiners.subject_id',$subject)
		->where('erp_examiners.main_id',$stream)
		->where('erp_examiners.course_id',$department)
		->get('erp_examiners')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/examinerApprove',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function updateExaminerStatus()
	{
		$id=$this->input->post('approve_id');
		$batch = $this->input->post('batch');
		$subject = $this->input->post('subject');
		$sem = $this->input->post('sem');
		$stream = $this->input->post('stream');
		$department = $this->input->post('department');
		
		$data_edit['approve_status'] = 0;
		$data_edit['login_status'] = 0;
		$this->db->where('batch_year',$batch);
		$this->db->where('sem',$sem);
		$this->db->where('main_id',$stream);
		$this->db->where('course_id',$department);
		$this->db->where('subject_id',$subject);
		$this->db->update('erp_examiners',$data_edit);
		
		$data_edit1['approve_status'] = 1;
		$data_edit1['login_status'] = 1;
		$this->db->where('id',$id);
		$update = $this->db->update('erp_examiners',$data_edit1);
		echo 'Success';
    }
	
	public function updateExaminerLogin()
	{
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		
		$data_edit['login_status'] = $status;
		$this->db->where('id',$id);
		$update = $this->db->update('erp_examiners',$data_edit);
		echo 'Success';
    }
	
	public function updateExaminerPwd()
	{
		$id=$this->input->post('id');
		$pwd=$this->input->post('pwd');
		$username=$this->input->post('username');
		
		$data_edit['username'] = $username;
		$data_edit['password'] = $pwd;
		$this->db->where('id',$id);
		$update = $this->db->update('erp_examiners',$data_edit);
		echo 'Success';
    }
	
	
	public function instructionUpload()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['inspection'] = $get = $this->db->select('*')->get('erp_inspection')->row();
		 
	if(isset($_POST['upload'])){
			
			$edit_id = $this->input->post('edit_id');
			
	if($_FILES['inspection']['size'] != 0) {
			$file_ext = pathinfo($_FILES["inspection"]["name"], PATHINFO_EXTENSION);
			$NewImageName = rand().'_Inspection.'.$file_ext;
			
			$_FILES["file"]["name"] = $NewImageName;
			$_FILES["file"]["type"] = $_FILES["inspection"]["type"];
			$_FILES["file"]["tmp_name"] = $_FILES["inspection"]["tmp_name"];
			$_FILES["file"]["error"] = $_FILES["inspection"]["error"];
			$_FILES["file"]["size"] = $_FILES["inspection"]["size"];

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
	$result=$this->db->update('erp_inspection',$data_up);	 
	$data['msg']=$this->session->set_flashdata('success','Edited Successfully','success');
	 }else{
			$data_up['user_id']=$user_id;
			$data_up['created_at']=$add_date;
	$result=$this->db->insert('erp_inspection',$data_up);
	$data['msg']=$this->session->set_flashdata('success','Added Successfully','success');
	 }
	redirect('coe/inspectionUpload','refresh');
		 }
		 
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/inspectionUpload',$data);
    $this->load->view('template/coe/footer');
	}
	
	public function sylbsTempltUpload()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['stream']='';
		$data['department']='';
		$data['sem1']='';
		
		$config = array(
		array('field' => 'batch','label' => 'Batch','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'sem','label' => 'Sem','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'stream','label' => 'Stream','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'department','label' => 'Department','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'subject','label' => 'Subject','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		);
		if(isset($_POST['submit'])){
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) { 
         $data['form_err']=$this->session->set_flashdata('form_err','Please check all the details','warning'); 
         } 
         else {
			 
			 $data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
		$data['syll_templ'] = $this->db->select('erp_syllbs_templt.*')
		->where('erp_syllbs_templt.batch_year',$batch)
		->where('erp_syllbs_templt.sem',$sem)
		->where('erp_syllbs_templt.subject_id',$subject)
		->where('erp_syllbs_templt.main_id',$stream)
		->where('erp_syllbs_templt.course_id',$department)
		->get('erp_syllbs_templt')->row();
		 }
		}
		
		if(isset($_POST['upload'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
			
			$edit_id = $this->input->post('edit_id');
			
	if($_FILES['syllabus']['size'] != 0) {
			$file_ext = pathinfo($_FILES["syllabus"]["name"], PATHINFO_EXTENSION);
			$NewImageName = rand().'_Syllabus.'.$file_ext;
			
			$_FILES["file"]["name"] = $NewImageName;
			$_FILES["file"]["type"] = $_FILES["syllabus"]["type"];
			$_FILES["file"]["tmp_name"] = $_FILES["syllabus"]["tmp_name"];
			$_FILES["file"]["error"] = $_FILES["syllabus"]["error"];
			$_FILES["file"]["size"] = $_FILES["syllabus"]["size"];

			$config = $this->do_upload_exm();
			$this->upload->initialize($config);
			if($this->upload->do_upload('file'))
			{
			 $ffff = $this->upload->data();
			  $image=$ffff['file_name'];
			  
			  $data_up['syllabus'] = 'system/images/examiner/'.$NewImageName;
			  }
	 }
	 if($_FILES['template']['size'] != 0) {
			$file_ext = pathinfo($_FILES["template"]["name"], PATHINFO_EXTENSION);
			$NewImageName = rand().'_Template.'.$file_ext;
			
			$_FILES["file"]["name"] = $NewImageName;
			$_FILES["file"]["type"] = $_FILES["template"]["type"];
			$_FILES["file"]["tmp_name"] = $_FILES["template"]["tmp_name"];
			$_FILES["file"]["error"] = $_FILES["template"]["error"];
			$_FILES["file"]["size"] = $_FILES["template"]["size"];

			$config = $this->do_upload_exm();
			$this->upload->initialize($config);
			if($this->upload->do_upload('file'))
			{
			 $ffff = $this->upload->data();
			  $image=$ffff['file_name'];
			  
			  $data_up['template'] = 'system/images/examiner/'.$NewImageName;
			  }
	 }
	 
	 if($edit_id != ''){	 
	  $get = $this->db->where('id',$edit_id)->get('erp_syllbs_templt')->row();	
		 if($_FILES['syllabus']['size'] != 0 || $_FILES['template']['size'] != 0) {
		  if($_FILES['syllabus']['size'] != 0) {if($get->syllabus != ''){unlink($get->syllabus);}}
		  if($_FILES['template']['size'] != 0) {if($get->template != ''){unlink($get->template);}}
	 $this->db->where('id',$edit_id);
	$result=$this->db->update('erp_syllbs_templt',$data_up);	 
	$data['msg']=$this->session->set_flashdata('success','Edited Successfully','success');
		 }else{
	$data['msg']=$this->session->set_flashdata('success','Please select a file','success');		 
		 }
		}else{
		 $batch_id = $this->db->where('batch_from',$batch)->get('erp_batchmaster')->row();
	        $data_up['batch_id']=$batch_id->id;
	        $data_up['batch_year']=$batch;
			$data_up['subject_id']=$subject;
			$data_up['sem']=$sem;
			$data_up['main_id']=$stream;
			$data_up['course_id']=$department;
			$data_up['user_id']=$user_id;
			$data_up['created_at']=$add_date;
	$result=$this->db->insert('erp_syllbs_templt',$data_up);
	
	$data['msg']=$this->session->set_flashdata('success','Added Successfully','success');
	 }
	
			$data['syll_templ'] = $this->db->select('erp_syllbs_templt.*')
		->where('erp_syllbs_templt.batch_year',$batch)
		->where('erp_syllbs_templt.sem',$sem)
		->where('erp_syllbs_templt.subject_id',$subject)
		->where('erp_syllbs_templt.main_id',$stream)
		->where('erp_syllbs_templt.course_id',$department)
		->get('erp_syllbs_templt')->row();
		 }
	 
	 $this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/sylbsTempltUpload',$data);
    $this->load->view('template/coe/footer');
	}
	
	public function filesDownload()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['stream']='';
		$data['department']='';
		$data['sem1']='';
		
		$config = array(
		array('field' => 'batch','label' => 'Batch','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'sem','label' => 'Sem','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'stream','label' => 'Stream','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'department','label' => 'Department','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'subject','label' => 'Subject','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		);
		if(isset($_POST['submit'])){
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) { 
         $data['form_err']=$this->session->set_flashdata('form_err','Please check all the details','warning'); 
         } 
         else {
			 
			 $data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
			
		$data['qpaper'] = $this->db->select('erp_examiners_qpaper.*')
		->where('erp_examiners_qpaper.batch_year',$batch)
		->where('erp_examiners_qpaper.sem',$sem)
		->where('erp_examiners_qpaper.subject_id',$subject)
		->where('erp_examiners_qpaper.main_id',$stream)
		->where('erp_examiners_qpaper.course_id',$department)
		->get('erp_examiners_qpaper')->row();
		 }
		}
		 
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/filesDownload',$data);
    $this->load->view('template/coe/footer');
	}
	
	public function finalize_qp()
	{
		$id = $this->input->post('id');
		$data['finalize'] = $this->input->post('status');
		
		$this->db->where('id',$id);	
	$this->db->update('erp_examiners_qpaper',$data);
	
	echo 'Success';
	}
	
	public function examMarksFinal()
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

			$elect_stud =[];

			$data['all_sub_details'] = $this->db->select("*")->from("erp_subjectmaster")->where("erp_subjectmaster.id",$subject)->get()->result();

	
if($data['all_sub_details'][0]->subCatg=="Elective"){


	$elect_stud = $this->db->select("e_admit_stu_id")->from("erp_student_elective_subject")
	->where("erp_student_elective_subject.e_batch",$batch)
	->where("erp_student_elective_subject.e_sem",$sem)
	->where("erp_student_elective_subject.e_subject",$subject)
	->get()->result_array();
	//print_r($elect_stud);

	$stud_ele = array_column($elect_stud, 'e_admit_stu_id');
	$m = array_unique($stud_ele);

}else if($data['all_sub_details'][0]->part==1 || $data['all_sub_details'][0]->part==4 ){
if($stream == 5){
	$elect_stud = $this->db->select("existing_student_id")->from("erp_langallot")
	->where("erp_langallot.batch",$batch)
	->where("erp_langallot.sem",$sem)
	->where("erp_langallot.subject_id",$subject)
	->where("erp_langallot.status",1)
	->get()->result_array();
	//print_r($elect_stud);

	$stud_ele = array_column($elect_stud, 'existing_student_id');
	$m = array_unique($stud_ele);
}
}

if(sizeof($elect_stud) > 0){

	$data['stu_list'] = $this->db->select('erp_existing_students.*')
											->where('erp_existing_students.main_id',$stream)
											->where('erp_existing_students.cour_id',$department)
											->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
											->where_in("erp_existing_students.id", $m)
											->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
											->get('erp_existing_students')->result();

	}else{

		$data['stu_list'] = $this->db->select('erp_existing_students.*')
												->where('erp_existing_students.main_id',$stream)
												->where('erp_existing_students.cour_id',$department)
												->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
												->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
												->get('erp_existing_students')->result();

}
/* print_r($data);
exit; */

		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/examMarksFinal',$data);
    $this->load->view('template/coe/footer');	
	}
	public function examMarksAverage()
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
		/*$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();*/
		$elect_stud =[];

			$data['all_sub_details'] = $this->db->select("*")->from("erp_subjectmaster")->where("erp_subjectmaster.id",$subject)->get()->result();

	
if($data['all_sub_details'][0]->subCatg=="Elective"){


	$elect_stud = $this->db->select("e_admit_stu_id")->from("erp_student_elective_subject")
	->where("erp_student_elective_subject.e_batch",$batch)
	->where("erp_student_elective_subject.e_sem",$sem)
	->where("erp_student_elective_subject.e_subject",$subject)
	->get()->result_array();
	//print_r($elect_stud);

	$stud_ele = array_column($elect_stud, 'e_admit_stu_id');
	$m = array_unique($stud_ele);

}else if($data['all_sub_details'][0]->part==1 || $data['all_sub_details'][0]->part==4 ){
if($stream == 5){
	$elect_stud = $this->db->select("existing_student_id")->from("erp_langallot")
	->where("erp_langallot.batch",$batch)
	->where("erp_langallot.sem",$sem)
	->where("erp_langallot.subject_id",$subject)
	->where("erp_langallot.status",1)
	->get()->result_array();
	//print_r($elect_stud);

	$stud_ele = array_column($elect_stud, 'existing_student_id');
	$m = array_unique($stud_ele);
}
}

if(sizeof($elect_stud) > 0){

	$data['stu_list'] = $this->db->select('erp_existing_students.*')
											->where('erp_existing_students.main_id',$stream)
											->where('erp_existing_students.cour_id',$department)
											->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
											->where_in("erp_existing_students.id", $m)
											->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
											->get('erp_existing_students')->result();

	}else{

		$data['stu_list'] = $this->db->select('erp_existing_students.*')
												->where('erp_existing_students.main_id',$stream)
												->where('erp_existing_students.cour_id',$department)
												->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
												->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
												->get('erp_existing_students')->result();

}
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/examMarksAverage',$data);
    $this->load->view('template/coe/footer');	
	}public function passingBordReport()
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
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/passingboardreport',$data);
    $this->load->view('template/coe/footer');	
	}
	public function icaTotalMark()
	{
	$ica=$this->input->post('ica');
	$icaval=$this->input->post('icaval');
	$main_id=$this->input->post('main_id');
	$course_id=$this->input->post('course_id');
	$subject_id=$this->input->post('subject_id');
	$ica_not=$this->input->post('ica_not');
	$batch=$this->input->post('batch');
	$sem=$this->input->post('sem');
	$user_id=$this->session->userdata('user')['user_id'];
	$add_date=date('Y-m-d H:i:s');
	
	for($i=0; $i<sizeof($ica); $i++){
		$data = array();
		$det = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$ica[$i])->where('subject_id',$subject_id)->get('erp_exammarkfinal')->row();
	 if(!isset($det)){	
	$data['batch_year']=$batch; 
	$data['sem']=$sem; 
	$data['subject_id']=$subject_id;
	$data['student_id']=$ica[$i];
	$data['ica']=$icaval[$i];
	$data['main_id']=$main_id;
	$data['course_id']=$course_id;
	$data['user_id']=$user_id;
	$data['created_at']=$add_date;
	$this->db->insert('erp_exammarkfinal',$data);
	 }else{	 
	$data['ica']=$icaval[$i];	
	 $this->db->where('id',$det->id);	
	$this->db->update('erp_exammarkfinal',$data);
	 }
	}
	
	for($ii=0; $ii<sizeof($ica_not); $ii++){
		$delete = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$ica_not[$ii])->where('subject_id',$subject_id)->get('erp_exammarkfinal')->row();
	 if(isset($delete)){	
	 $data1['ica']=null;
	$this->db->where('id',$delete->id);	
	$this->db->update('erp_exammarkfinal',$data1);
	 }
	}
	echo 'Success';
    }
	public function internalMark()
	{

	$internal=[];
	$internal=$this->input->post('internal');
	$intval=$this->input->post('intval');
	$main_id=$this->input->post('main_id');
	$course_id=$this->input->post('course_id');
	$subject_id=$this->input->post('subject_id');
	$internal_not=$this->input->post('internal_not');
	$batch=$this->input->post('batch');
	$sem=$this->input->post('sem');
	$user_id=$this->session->userdata('user')['user_id'];
	$add_date=date('Y-m-d H:i:s');
	
	for($i=0; $i<sizeof($internal); $i++){
		$data = array();
		$det = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$internal[$i])->where('subject_id',$subject_id)->get('erp_exammarkfinal')->row();
	 if(!isset($det)){	
	$data['batch_year']=$batch; 
	$data['sem']=$sem; 
	$data['subject_id']=$subject_id; 
	$data['student_id']=$internal[$i];
	$data['internal']=$intval[$i];
	$data['main_id']=$main_id;
	$data['course_id']=$course_id;
	$data['user_id']=$user_id;
	$data['created_at']=$add_date;
	$this->db->insert('erp_exammarkfinal',$data);
	 }else{
	$data['internal']=$intval[$i];	
	 $this->db->where('id',$det->id);	
	$this->db->update('erp_exammarkfinal',$data);
	 }
	}
	
	for($ii=0; $ii<sizeof($internal_not); $ii++){
		$delete = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$internal_not[$ii])->where('subject_id',$subject_id)->get('erp_exammarkfinal')->row();
	 if(isset($delete)){	
	 $data1['internal']=null;
	$this->db->where('id',$delete->id);		
	$this->db->update('erp_exammarkfinal',$data1);
	 }
	}
	echo 'Success';
    }
	public function externalMark()
	{
	$external=$this->input->post('external');
	$extval=$this->input->post('extval');
	$main_id=$this->input->post('main_id');
	$course_id=$this->input->post('course_id');
	$subject_id=$this->input->post('subject_id');
	$external_not=$this->input->post('external_not');
	$batch=$this->input->post('batch');
	$sem=$this->input->post('sem');
	$user_id=$this->session->userdata('user')['user_id'];
	$add_date=date('Y-m-d H:i:s');
	
	for($i=0; $i<sizeof($external); $i++){
		$data = array();
		$det = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$external[$i])->where('subject_id',$subject_id)->get('erp_exammarkfinal')->row();
	 if(!isset($det)){	
	$data['batch_year']=$batch; 
	$data['sem']=$sem; 
	$data['subject_id']=$subject_id; 
	$data['student_id']=$external[$i];
	$data['external']=$extval[$i];
	$data['main_id']=$main_id;
	$data['course_id']=$course_id;
	$data['user_id']=$user_id;
	$data['created_at']=$add_date;
	$this->db->insert('erp_exammarkfinal',$data);
	 }else{	 
	$data['external']=$extval[$i];	
	 $this->db->where('id',$det->id);		
	$this->db->update('erp_exammarkfinal',$data);
	 }
	}
	
	for($ii=0; $ii<sizeof($external_not); $ii++){
		$delete = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$external_not[$ii])->where('subject_id',$subject_id)->get('erp_exammarkfinal')->row();
	 if(isset($delete)){	
	 $data1['external']=null;
	$this->db->where('id',$delete->id);	
	$this->db->update('erp_exammarkfinal',$data1);
	 }
	}
	echo 'Success';
    }
	public function thirdPartyMark()
	{
	$thirdparty=$this->input->post('thirdparty');
	$tpval=$this->input->post('tpval');
	$main_id=$this->input->post('main_id');
	$course_id=$this->input->post('course_id');
	$subject_id=$this->input->post('subject_id');
	$thirdparty_not=$this->input->post('thirdparty_not');
	$batch=$this->input->post('batch');
	$sem=$this->input->post('sem');
	$user_id=$this->session->userdata('user')['user_id'];
	$add_date=date('Y-m-d H:i:s');
	
	for($i=0; $i<sizeof($thirdparty); $i++){
		$data = array();
		$det = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$thirdparty[$i])->where('subject_id',$subject_id)->get('erp_exammarkfinal')->row();
	 if(!isset($det)){	
	$data['batch_year']=$batch; 
	$data['sem']=$sem; 
	$data['subject_id']=$subject_id; 
	$data['student_id']=$thirdparty[$i];
	$data['thirdparty']=$tpval[$i];
	$data['main_id']=$main_id;
	$data['course_id']=$course_id;
	$data['user_id']=$user_id;
	$data['created_at']=$add_date;
	$this->db->insert('erp_exammarkfinal',$data);
	 }else{	 
	$data['thirdparty']=$tpval[$i];	
	 $this->db->where('id',$det->id);		
	$this->db->update('erp_exammarkfinal',$data);
	 }
	}
	
	for($ii=0; $ii<sizeof($thirdparty_not); $ii++){
		$delete = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$thirdparty_not[$ii])->where('subject_id',$subject_id)->get('erp_exammarkfinal')->row();
	 if(isset($delete)){	
	 $data1['thirdparty']=null;
	$this->db->where('id',$delete->id);	
	$this->db->update('erp_exammarkfinal',$data1);
	 }
	}
	echo 'Success';
    }
	public function averageMark1()
	{
	$average=$this->input->post('average');
	$avval=$this->input->post('avval');
	$main_id=$this->input->post('main_id');
	$course_id=$this->input->post('course_id');
	$subject_id=$this->input->post('subject_id');
	$average_not=$this->input->post('average_not');
	$batch=$this->input->post('batch');
	$sem=$this->input->post('sem');
	$user_id=$this->session->userdata('user')['user_id'];
	$add_date=date('Y-m-d H:i:s');
	
	for($i=0; $i<sizeof($average); $i++){
		$data = array();
		$det = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$average[$i])->where('subject_id',$subject_id)->get('erp_exammarkfinal')->row();
	 if(!isset($det)){	
	$data['batch_year']=$batch; 
	$data['sem']=$sem; 
	$data['subject_id']=$subject_id; 
	$data['student_id']=$average[$i];
	$data['average']=$avval[$i];
	$data['main_id']=$main_id;
	$data['course_id']=$course_id;
	$data['user_id']=$user_id;
	$data['created_at']=$add_date;
	$this->db->insert('erp_exammarkfinal',$data);
	 }else{	 
	$data['average']=$avval[$i];	
	 $this->db->where('id',$det->id);		
	$this->db->update('erp_exammarkfinal',$data);
	 }
	}
	
	for($ii=0; $ii<sizeof($average_not); $ii++){
		$delete = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$average_not[$ii])->where('subject_id',$subject_id)->get('erp_exammarkfinal')->row();
	 if(isset($delete)){	
	 $data1['average']=null;
	$this->db->where('id',$delete->id);	
	$this->db->update('erp_exammarkfinal',$data1);
	 }
	}
	echo 'Success';
    }
	public function averageMark()
	{
	$average=$this->input->post('average');
	$avval=$this->input->post('avval');
	$main_id=$this->input->post('main_id');
	$course_id=$this->input->post('course_id');
	$subject_id=$this->input->post('subject_id');
	$batch=$this->input->post('batch');
	$sem=$this->input->post('sem');
	$user_id=$this->session->userdata('user')['user_id'];
	$add_date=date('Y-m-d H:i:s');
	
	for($i=0; $i<sizeof($average); $i++){
		$data = array();
		$det = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$average[$i])->where('subject_id',$subject_id)->get('erp_exammarkfinal')->row();
	 if(!isset($det)){	
	$data['batch_year']=$batch; 
	$data['sem']=$sem; 
	$data['subject_id']=$subject_id; 
	$data['student_id']=$average[$i];
	$data['average']=$avval[$i];
	$data['main_id']=$main_id;
	$data['course_id']=$course_id;
	$data['user_id']=$user_id;
	$data['created_at']=$add_date;
	$this->db->insert('erp_exammarkfinal',$data);
	 }else{	 
	$data['average']=$avval[$i];	
	 $this->db->where('id',$det->id);		
	$this->db->update('erp_exammarkfinal',$data);
	 }
	}
	echo 'Success';
    }
	
	public function moderation1()
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
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/moderation1',$data);
    $this->load->view('template/coe/footer');	
	}
	
	public function moderationRange()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['stream'] = '';
		   
		$data['sub_list']=$this->db->get('erp_subjectmaster')->result();
		$config = array(
		array('field' => 'stream','label' => 'Stream','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'range_from','label' => 'Range From','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'range_to','label' => 'Range To','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		);
		if(isset($_POST['submit'])){
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) { 
		   $data['stream'] = $this->input->post('stream');
         $data['form_err']=$this->session->set_flashdata('form_err','Please check all the details','warning'); 
         } 
         else {
		   $data['stream'] = $this->input->post('stream');
		   $edit_id = $this->input->post('edit_id');
		
		if($edit_id == ''){
		 $data_add = array(
		  'range_from' => $this->input->post('range_from'),
		  'range_to' => $this->input->post('range_to'),
		  'main_id' => $this->input->post('stream'),
		  'user_id' => $user_id,
		  'created_at' => $add_date,
		 );
		  
		$insert = $this->db->insert('erp_moderationrange',$data_add);
		}
		else{
		 $data_add = array(
		  'range_from' => $this->input->post('range_from'),
		  'range_to' => $this->input->post('range_to'),
		 );
		  
		  $this->db->where('id',$edit_id);
		$insert = $this->db->update('erp_moderationrange',$data_add);
		}
		$data['msg']=$this->session->set_flashdata('success','Updated Successfully','success'); 
		//redirect('coe/examFeesAdd','refresh');
		}
		 }		
		
    $this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/moderationRange',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function getModerationRange()
	{
	$stream=$this->input->post('stream');
	
	$range = $this->db->where('main_id',$stream)->get('erp_moderationrange')->row();	
	
	if(isset($range)){
		$range_det = array(
		  'from' => $range->range_from,
		  'to' => $range->range_to,
		  'id' => $range->id,
		);
		}
	else{
		$range_det = array(
		);
	}
	 echo json_encode($range_det);
	}
	
	public function moderation()
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
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/moderation',$data);
    $this->load->view('template/coe/footer');	
	}
	
	public function updateModerateMark()
	{
	$id=$this->input->post('id');
	$mark=$this->input->post('mark');
	
	$data = array(
	 'moderate_status' => 1,
	 'moderated_mark' => $mark,
	);
	$this->db->where('id',$id);
	$update = $this->db->update('erp_exammarkfinal',$data);	
	
	 echo 'Success';
	}
	
	public function afterModeration()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['sem1']='';
		$data['stream']='';
		$data['department']='';
		$data['year1']='';
		$data['all_dep_details']='';
		$data['all_sub_details']='';
		$data['exam_details']='';
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
			$data['year1']=$written_year = $this->input->post('written_year');


			$data['all_dep_details'] = $this->db->select("*")->from("department_details")->where("department_details.main_id",$stream)->where("department_details.cour_id",$department)->get()->result();
		
		
			$data['all_sub_details'] = $this->db->select("*")->from("erp_subjectmaster")->where("erp_subjectmaster.id",$subject)->get()->result();
	
	
	
			if($sem == 1 ||$sem == 3 ||$sem == 5){

		$data['exam_details'] = 'November -'.date("Y",strtotime($data['all_sub_details'][0]->add_date));

	}else{

		$data['exam_details'] = 'May -'.date("Y",strtotime($data['all_sub_details'][0]->add_date));



	}

	$elect_stud =[];

			$data['all_sub_details'] = $this->db->select("*")->from("erp_subjectmaster")->where("erp_subjectmaster.id",$subject)->get()->result();
	
	
if($data['all_sub_details'][0]->subCatg=="Elective"){


	$elect_stud = $this->db->select("e_admit_stu_id")->from("erp_student_elective_subject")
	->where("erp_student_elective_subject.e_batch",$batch)
	->where("erp_student_elective_subject.e_sem",$sem)
	->where("erp_student_elective_subject.e_subject",$subject)
	->get()->result_array();
	//print_r($elect_stud);

	$stud_ele = array_column($elect_stud, 'e_admit_stu_id');
	$m = array_unique($stud_ele);

}else if($data['all_sub_details'][0]->part==1 || $data['all_sub_details'][0]->part==4 ){
	if($stream == 5){
		$elect_stud = $this->db->select("existing_student_id")->from("erp_langallot")
		->where("erp_langallot.batch",$batch)
		->where("erp_langallot.sem",$sem)
		->where("erp_langallot.subject_id",$subject)
		->where("erp_langallot.status",1)
		->get()->result_array();
		//print_r($elect_stud);
	
		$stud_ele = array_column($elect_stud, 'existing_student_id');
		$m = array_unique($stud_ele);
	}
	}

if(sizeof($elect_stud) > 0){

	$data['stu_list'] = $this->db->select('erp_existing_students.*')
											->where('erp_existing_students.main_id',$stream)
											->where('erp_existing_students.cour_id',$department)
											->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
											->where_in("erp_existing_students.id", $m)
											->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
											->get('erp_existing_students')->result();

	}else{

		$data['stu_list'] = $this->db->select('erp_existing_students.*')
												->where('erp_existing_students.main_id',$stream)
												->where('erp_existing_students.cour_id',$department)
												->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
												->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
												->get('erp_existing_students')->result();

}

		}
		
		if(isset($_POST['publish'])){
		 $data['batch1'] = $batch=$this->input->post('batch');
	     $data['stream'] = $stream=$this->input->post('stream');
	     $data['department'] = $department=$this->input->post('department');
	     $data['sem1'] = $sem=$this->input->post('sem');
	     $data['subject1'] = $subject=$this->input->post('subject');
		 $batch_id = $this->db->where('batch_from',$batch)->get('erp_batchmaster')->row();
		
		 $data_add = array(
		  'batch_id' => $batch_id->id,
		  'batch_year' => $batch,
		  'subject_id' => $subject,
		  'sem' => $sem,
		  'main_id' => $stream,
		  'course_id' => $department,
		  'status' => 1,
		  'user_id' => $user_id,
		  'created_at' => $add_date,
		 );
		  
		$insert = $this->db->insert('erp_publish_mark',$data_add);
		$data['msg']=$this->session->set_flashdata('success','Published Mark Successfully','success');
        $data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();		
		}
		$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/afterModeration',$data);
    $this->load->view('template/coe/footer');	
	}
	public function afterModerationSaveMarks()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['sem1']='';
		$data['stream']='';
		$data['department']='';
		$data['year1']='';
		$data['all_dep_details']='';
		$data['all_sub_details']='';
		$data['exam_details']='';
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
			$data['year1']=$written_year = $this->input->post('written_year');


			$data['all_dep_details'] = $this->db->select("*")->from("department_details")->where("department_details.main_id",$stream)->where("department_details.cour_id",$department)->get()->result();
		
		
			$data['all_sub_details'] = $this->db->select("*")->from("erp_subjectmaster")->where("erp_subjectmaster.id",$subject)->get()->result();
	
	
	
			if($sem == 1 ||$sem == 3 ||$sem == 5){

		$data['exam_details'] = 'November -'.date("Y",strtotime($data['all_sub_details'][0]->add_date));

	}else{

		$data['exam_details'] = 'May -'.date("Y",strtotime($data['all_sub_details'][0]->add_date));



	}

	$elect_stud =[];

			$data['all_sub_details'] = $this->db->select("*")->from("erp_subjectmaster")->where("erp_subjectmaster.id",$subject)->get()->result();
	
	
if($data['all_sub_details'][0]->subCatg=="Elective"){


	$elect_stud = $this->db->select("e_admit_stu_id")->from("erp_student_elective_subject")
	->where("erp_student_elective_subject.e_batch",$batch)
	->where("erp_student_elective_subject.e_sem",$sem)
	->where("erp_student_elective_subject.e_subject",$subject)
	->get()->result_array();
	//print_r($elect_stud);

	$stud_ele = array_column($elect_stud, 'e_admit_stu_id');
	$m = array_unique($stud_ele);

}else if($data['all_sub_details'][0]->part==1 || $data['all_sub_details'][0]->part==4 ){
	if($stream == 5){
		$elect_stud = $this->db->select("existing_student_id")->from("erp_langallot")
		->where("erp_langallot.batch",$batch)
		->where("erp_langallot.sem",$sem)
		->where("erp_langallot.subject_id",$subject)
		->where("erp_langallot.status",1)
		->get()->result_array();
		//print_r($elect_stud);
	
		$stud_ele = array_column($elect_stud, 'existing_student_id');
		$m = array_unique($stud_ele);
	}
	}

if(sizeof($elect_stud) > 0){

	$data['stu_list'] = $this->db->select('erp_existing_students.*')
											->where('erp_existing_students.main_id',$stream)
											->where('erp_existing_students.cour_id',$department)
											->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
											->where_in("erp_existing_students.id", $m)
											->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
											->get('erp_existing_students')->result();

	}else{

		$data['stu_list'] = $this->db->select('erp_existing_students.*')
												->where('erp_existing_students.main_id',$stream)
												->where('erp_existing_students.cour_id',$department)
												->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
												->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
												->get('erp_existing_students')->result();

}

		}
		
	/*  	if(isset($_POST['publish'])){
		 $data['batch1'] = $batch=$this->input->post('batch');
	     $data['stream'] = $stream=$this->input->post('stream');
	     $data['department'] = $department=$this->input->post('department');
	     $data['sem1'] = $sem=$this->input->post('sem');
	     $data['subject1'] = $subject=$this->input->post('subject');
		 $batch_id = $this->db->where('batch_from',$batch)->get('erp_batchmaster')->row();
		
		 $data_add = array(
		  'batch_id' => $batch_id->id,
		  'batch_year' => $batch,
		  'subject_id' => $subject,
		  'sem' => $sem,
		  'main_id' => $stream,
		  'course_id' => $department,
		  'status' => 1,
		  'user_id' => $user_id,
		  'created_at' => $add_date,
		 );
		  
		$insert = $this->db->insert('erp_publish_mark',$data_add);
		$data['msg']=$this->session->set_flashdata('success','Published Mark Successfully','success');
        $data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();		
		}  */
		$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/afterModerationsave',$data);
    $this->load->view('template/coe/footer');	
	}
	
	public function beforeModeration()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['sem1']='';
		$data['stream']='';
		$data['department']='';
		$data['exam_details'] ='';
		$data['all_dep_details'] = '';
		$data['all_sub_details'] = '';

		if(isset($_POST['submit'])){
			$m=[];
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');






			$data['all_dep_details'] = $this->db->select("*")->from("department_details")->where("department_details.main_id",$stream)->where("department_details.cour_id",$department)->get()->result();
		
		
			$data['all_sub_details'] = $this->db->select("*")->from("erp_subjectmaster")->where("erp_subjectmaster.id",$subject)->get()->result();
	
			$elect_stud=[];
	
if($data['all_sub_details'][0]->subCatg=="Elective"){


	$elect_stud = $this->db->select("e_admit_stu_id")->from("erp_student_elective_subject")
	->where("erp_student_elective_subject.e_batch",$batch)
	->where("erp_student_elective_subject.e_sem",$sem)
	->where("erp_student_elective_subject.e_subject",$subject)
	->get()->result_array();
	//print_r($elect_stud);

	$stud_ele = array_column($elect_stud, 'e_admit_stu_id');
	$m = array_unique($stud_ele);

}else if($data['all_sub_details'][0]->part==1 || $data['all_sub_details'][0]->part==4 ){
	if($stream == 5){
		$elect_stud = $this->db->select("existing_student_id")->from("erp_langallot")
		->where("erp_langallot.batch",$batch)
		->where("erp_langallot.sem",$sem)
		->where("erp_langallot.subject_id",$subject)
		->where("erp_langallot.status",1)
		->get()->result_array();
		//print_r($elect_stud);
	
		$stud_ele = array_column($elect_stud, 'existing_student_id');
		$m = array_unique($stud_ele);
	}
	}

if(sizeof($m) > 0){

	$data['stu_list'] = $this->db->select('erp_existing_students.*')
											->where('erp_existing_students.main_id',$stream)
											->where('erp_existing_students.cour_id',$department)
											->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
											->where_in("erp_existing_students.id", $m)
											->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
											->get('erp_existing_students')->result();

	}else{

		$data['stu_list'] = $this->db->select('erp_existing_students.*')
												->where('erp_existing_students.main_id',$stream)
												->where('erp_existing_students.cour_id',$department)
												->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
												->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
												->get('erp_existing_students')->result();

}


			if($sem == 1 ||$sem == 3 ||$sem == 5){

		$data['exam_details'] = 'November -'.date("Y",strtotime($data['all_sub_details'][0]->add_date));

	}else{

		$data['exam_details'] = 'May -'.date("Y",strtotime($data['all_sub_details'][0]->add_date));



	}

		


/* echo"<pre>";
print_r($subject);
print_r($m);
print_r($data['stu_list']);
exit; */


		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/beforeModeration',$data);
    $this->load->view('template/coe/footer');	
	}
	
	public function beforeModerationPDF()
	{
		$this->load->library("pdf");
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$date=date('Y-m-d');
		
		    $data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		
		$subj = $this->db->where('id',$subject)->get('erp_subjectmaster')->row();
		ob_start();
            $html = $this->load->view("coe/beforeModerationPDF", $data, true);
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
            $dompdf->stream("BeforeModeration_".$batch."_".$subj->subName.".pdf", ["Attachment" => 1]);
		
    //$this->load->view('coe/transferCert',$data);
	}
	
	public function examMarkPublish()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		//if(isset($_POST['submit'])){
		 $data['batch1'] = $batch=$this->input->post('batch');
	     $data['stream'] = $stream=$this->input->post('stream');
	     $data['department'] = $department=$this->input->post('department');
	     $data['sem1'] = $sem=$this->input->post('sem');
		 $batch_id = $this->db->where('batch_from',$batch)->get('erp_batchmaster')->row();
		
		 $data_add = array(
		  'batch_id' => $batch_id->id,
		  'batch_year' => $batch,
		  'sem' => $sem,
		  'main_id' => $stream,
		  'course_id' => $department,
		  'status' => 1,
		  'user_id' => $user_id,
		  'created_at' => $add_date,
		 );
		  
		$insert = $this->db->insert('erp_publish_mark',$data_add);
		/*$data['msg']=$this->session->set_flashdata('success','Published Mark Successfully','success'); 
		redirect('coe/examMarkPublish','refresh');
		}	
		
    $this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/examMarkPublish',$data);
    $this->load->view('template/coe/footer');*/
    }
	
	public function getPublishStatus()
	{
	$batch=$this->input->post('batch');
	$stream=$this->input->post('stream');
	$department=$this->input->post('department');
	$sem=$this->input->post('sem');
	
	$stat = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('main_id',$stream)->where('course_id',$department)->get('erp_publish_mark')->row();
	
	if(isset($stat)){
		$published = 1;
		}
	else{
		$published = 0;
	}
	echo $published;
	}
	
	public function roomAllocationArrear()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$year=date('Y');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['sem1']='';
		$data['stream']='';
		$data['department']='';
		$data['applied_batch1']='';
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
			$data['applied_batch1']=$applied_batch = $this->input->post('applied_batch');
		$data['stu_list'] = $this->db->select('*')
		->where('main_id',$stream)
		->where('course_id',$department)
		->where('applied_year',$year)
		->where('subject_code',$subject)
		->where('result_status','fail')
		->group_by('subject_id')
		->get('erp_arrear_detail')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/roomAllocationArrear',$data);
    $this->load->view('template/coe/footer');	
	}
	public function getSubjCodeSemwise()
	{
	$stream=$this->input->post('stream');
	$department=$this->input->post('department');
	$batch=$this->input->post('batch');
	$sem=$this->input->post('sem');
	
    $subj = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('stream',$stream)->where('department',$department)->get('erp_subjectmaster')->result();	
	
	$subject = '<option value="">Select Subject</option>';
	foreach($subj as $subj){
		$subject .= '<option value="'.$subj->subCode.'">'.$subj->subName.'</option>';
	}
	echo $subject;
    }

	public function getRowsCols()
	{
	$room_id=$this->input->post('room_id');
	
    $row_det = $this->db->where('id',$room_id)->get('erp_rooms')->row();
    $rows_no = $row_det->rows;	
    $cols_no = $row_det->columns;	
	
	$rows = '<option value="">Select Row</option>';
	$cols = '<option value="">Select Column</option>';
	
	for($i=0; $i < $rows_no; $i++){
		$rows .= '<option value="'.($i + 1).'"> '.($i + 1).' </option>';
	  }
	for($i=0; $i < $cols_no; $i++){
		$cols .= '<option value="'.($i + 1).'"> '.($i + 1).' </option>';
	}

	$data['rows'] = $rows;
	$data['cols'] = $cols;
	$data['seater'] = $row_det->seater;
	echo json_encode($data);
    }

	public function arrearRoomAllocate()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$year=date('Y');

			$batch = $this->input->post('batch');
			$subject = $this->input->post('subject');
			$sem = $this->input->post('sem');
			$stream = $this->input->post('stream');
			$department = $this->input->post('department');
			//$schedule_date = date('Y-m-d',strtotime($this->input->post('schedule_date')));
			$session = $this->input->post('section');
			$block_id = $this->input->post('block_id');
			$room_id = $this->input->post('room_id');
			$row = $this->input->post('row');
			$column = $this->input->post('column');
			$student_id = $this->input->post('student_id');
			$applied_batch = $this->input->post('applied_batch');
			
		 $seatno = $this->db->select('seat_no')
		->from('erp_rows_cols_arrear')
		->where('section',$session)
		->where('sem',$sem)
		->where('room_id',$room_id)
		->where('subject_id',$subject)
		->where('applied_year',$year)
		->order_by('seat_no','desc')
		->get()->row();
		
		if(!isset($seatno)){$seat_no=1;}
		else{$seat_no=($seatno->seat_no + 1);}

	$stu_det = $this->db
	->where('applied_year',$year)
	->where('main_id',$stream)
	->where('course_id',$department)
	->where('sem',$sem)
	->where('subject_id',$subject)
	->where('student_id',$student_id)	
	->get('erp_rows_cols_arrear')->row();
	
	if(!isset($stu_det)){
			$batch_id = $this->db->where('batch_from',$applied_batch)->get('erp_batchmaster')->row();
	$data = array(
		'applied_batch_id' => $batch_id->id,
		'applied_batch_year' => $batch,
		'applied_year' => $year,
		'main_id' => $stream,
		'course_id' => $department,
		'subject_id' => $subject,
		'student_id' => $student_id,
		'sem' => $sem,
		//'schedule_date' => $schedule_date,
		'section' => $session,
		'seat_no' => $seat_no,
		'no_of_students' => '1',
		'block_id' => $block_id,
		'room_id' => $room_id,
		'rows' => $row,
		'columns' => $column,
		'user_id' => $user_id,
		'created_at' => $add_date,
		);
		
		$insert = $this->db->insert('erp_rows_cols_arrear',$data);
	}else{
    	$data_up = array(
			'section' => $session,
			'block_id' => $block_id,
			'room_id' => $room_id,
			'rows' => $row,
			'columns' => $column,
			);
			
			$this->db
	->where('applied_year',$year)
	->where('main_id',$stream)
	->where('course_id',$department)
	->where('sem',$sem)
	->where('subject_id',$subject)
	->where('student_id',$student_id)	
	->where('section',$session);	
			$update = $this->db->update('erp_rows_cols_arrear',$data_up);
	}
		echo 'Success';
  }

  public function publishResult()
	{
	$result=$this->input->post('result');
	$rsval=$this->input->post('rsval');
	$main_id=$this->input->post('main_id');
	$course_id=$this->input->post('course_id');
	$subject_id=$this->input->post('subject_id');
	$batch=$this->input->post('batch');
	$sem=$this->input->post('sem');
	$written_year=$this->input->post('written_year');
	$user_id=$this->session->userdata('user')['user_id'];
	$add_date=date('Y-m-d H:i:s');
	
	for($i=0; $i<sizeof($result); $i++){
		$data = array();
		$det = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$result[$i])->where('subject_id',$subject_id)->get('erp_exammarkfinal')->row();
	 if(!isset($det)){	
	$data['batch_year']=$batch; 
	$data['sem']=$sem; 
	$data['subject_id']=$subject_id; 
	$data['student_id']=$result[$i];
	$data['result']=$rsval[$i];
	$data['written_year']=$written_year;
	$data['main_id']=$main_id;
	$data['course_id']=$course_id;
	$data['user_id']=$user_id;
	$data['created_at']=$add_date;
	$this->db->insert('erp_exammarkfinal',$data);
	 }else{	 
	$data['result']=$rsval[$i];	
	 $this->db->where('id',$det->id);		
	$this->db->update('erp_exammarkfinal',$data);
	 }
	}
	echo 'Success';
    }  
		public function gallySheet(){

			$data['user']=$user_id=$this->session->userdata('user')['user_id'];
			$add_date=date('Y-m-d H:i:s');
			
			$data['batch1']='';
			//$data['subject1']='';
			$data['sem1']='';
			$data['stream']='';
			$data['department']='';
			$data['all_details'] = '';
			$data['exam_details'] = '';
			
			if(isset($_POST['submit'])){
		
				$data['batch1']=$batch = $this->input->post('batch');
				//$data['subject1']=$subject = $this->input->post('subject');
				$data['sem1']=$sem = $this->input->post('sem');
				$data['stream']=$stream = $this->input->post('stream');
				$data['department']=$department = $this->input->post('department');
				$data['all_details'] = $this->db->select("*")->from("erp_subjectmaster")
															->join("department_details","erp_subjectmaster.department=department_details.dp_id")
															->where("department_details.main_id",$stream)
															->where("department_details.cour_id",$department)
															->get()->result();
			
					if($sem == 1 ||$sem == 3 ||$sem == 5){
		
						$data['exam_details'] = 'November - '.(date("Y") - 1);
		
					}else{
		
						$data['exam_details'] = 'May - '.date("Y");
		
					}
			
			$data['stu_list'] = $this->db->select('erp_existing_students.*')
			->where('erp_existing_students.main_id',$stream)
			->where('erp_existing_students.cour_id',$department)
			->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
			->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
			->get('erp_existing_students')->result();
	
		}
			
			$this->load->view('template/coe/header');
			$this->load->view('template/coe/menubar');
			$this->load->view('template/coe/headerbar');
			$this->load->view('coe/gallysheet',$data);
			$this->load->view('template/coe/footer');	
		
		
		}
		
		public function SaveMarkResult()
	{



/* 		$studid=[];
		$student_name_=[];
	 $register_number=[];
	 $ica_mark=[];
	 $ese_mark=[];
	 $tolal=[];
	 $result=[]; */

 	$p_studid=$this->input->post('studid');
 	$p_sstudent_name_=$this->input->post('student_name_');
	$p_sregister_number=$this->input->post('register_number');
	$p_sica_mark=$this->input->post('ica_mark');
	$p_sese_mark=$this->input->post('ese_mark');
	$p_stolal=$this->input->post('tolal');
	$p_sresult=$this->input->post('result');
/* 	$studid=implode(',',$p_studid);
	$student_name_=implode(',',$p_sstudent_name_);
 $register_number=implode(',',$p_sregister_number);
 $ica_mark=implode(',',$p_sica_mark);
 $ese_mark=implode(',',$p_sese_mark);
 $tolal=implode(',',$p_stolal);
 $result=implode(',',$p_sresult); */

	$main_id=$this->input->post('main_id');
	$course_id=$this->input->post('course_id');
	$subject_id=$this->input->post('subject_id');
	$batch=$this->input->post('batch');
	$sem=$this->input->post('sem');
	$written_year=$this->input->post('written_year');
	$user_id=$this->session->userdata('user')['user_id'];
	$add_date=date('Y-m-d H:i:s');
/* print_r($_POST);
	exit;  */
	for($i=0; $i<sizeof($p_studid); $i++){
		$data = array();
		
		
		
		$det = $this->db->where('batch',$batch)->where('semester',$sem)->where('stud_admit_id',$p_studid[$i])->where('subject_id',$subject_id)->get('student_gally_report')->num_rows();
		$daaa = $this->db->where('batch',$batch)->where('semester',$sem)->where('stud_admit_id',$p_studid[$i])->where('subject_id',$subject_id)->get('student_gally_report')->result();
	 
		
		if($det==0){	
	$data['stud_admit_id']=$p_studid[$i]; 
	$data['stud_reg_number']=$p_sregister_number[$i]; 
	$data['batch']=$batch; 
	$data['semester']=$sem;
	$data['stream_id']=$main_id;
	$data['course_id']=$course_id;
	$data['subject_id']=$subject_id;
	$data['student_name']=$p_sstudent_name_[$i];
	$data['ici_mark']=$p_sica_mark[$i];
	$data['ese_mark']=$p_sese_mark[$i];
	$data['total_mark']=$p_stolal[$i];
	$data['result']=$p_sresult[$i];
	$data['written_year']=$written_year;
	$this->db->insert('student_gally_report',$data);
	 }else{	 
		$data['stud_admit_id']=$p_studid[$i]; 
		$data['stud_reg_number']=$p_sregister_number[$i]; 
		$data['batch']=$batch; 
		$data['semester']=$sem;
		$data['stream_id']=$main_id;
		$data['course_id']=$course_id;
		$data['subject_id']=$subject_id;
		$data['student_name']=$p_sstudent_name_[$i];
		$data['ici_mark']=$p_sica_mark[$i];
		$data['ese_mark']=$p_sese_mark[$i];
		$data['total_mark']=$p_stolal[$i];
		$data['result']=$p_sresult[$i];
	$data['written_year']=$written_year;

	 $this->db->where('id',$daaa[0]->id);		
	/*  $this->db->where('semester',$sem);		
	 $this->db->where('stud_admit_id',$studid[$i]);		
	 $this->db->where('subject_id',$subject_id); */		
	$this->db->update('student_gally_report',$data);
//echo"Updated";
	 }
	 //print_r($data);
	}
	echo 'Success'; 


    }
	
	public function viewGReport(){

$batch = $this->uri->segment(3);
$semester = $this->uri->segment(4);
$subject = $this->uri->segment(5);
$stream = $this->uri->segment(6);
$department = $this->uri->segment(7);



$data['report'] = $this->db->select('*')->from('student_gally_report')->where('batch',$batch)->where('semester',$semester)->where('stream_id',$stream)->where('course_id',$department)->where('subject_id',$subject)->order_by('stud_reg_number','ASC')->get()->result();


 $this->load->view('template/coe/header');
$this->load->view('template/coe/menubar');
$this->load->view('template/coe/headerbar');
$this->load->view('coe/afterModerationsavedReport',$data);
$this->load->view('template/coe/footer');	



	}


	public function examMarksFinalArrear()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['sem1']='';
		$data['stream']='';
		$data['department']='';
		$data['applied_year1']='';
		$data['applied_sem1']='';
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
			$data['applied_year1']=$applied_year = $this->input->post('applied_year');
			$data['applied_sem1']=$applied_sem = $this->input->post('applied_sem');
		/*$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->join('erp_existing_students','erp_rows_cols_arrear.student_id=erp_existing_students.id','left')
		->where('erp_rows_cols_arrear.applied_year',$applied_year)
		->where('erp_rows_cols_arrear.main_id',$stream)
		->where('erp_rows_cols_arrear.course_id',$department)
		->get('erp_rows_cols_arrear')->result();*/
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->join('erp_existing_students','erp_arrear_detail.student_id=erp_existing_students.id','left')
		->where('erp_arrear_detail.applied_year',$applied_year)
		->where('erp_arrear_detail.applied_sem',$applied_sem)
		->where('erp_arrear_detail.main_id',$stream)
		->where('erp_arrear_detail.course_id',$department)
		->where('erp_arrear_detail.subject_id',$subject)
		->get('erp_arrear_detail')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/examMarksFinalArrear',$data);
    $this->load->view('template/coe/footer');	
	}
	public function icaArrear()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['sem1']='';
		$data['stream']='';
		$data['department']='';
		$data['applied_year1']='';
		$data['applied_sem1']='';
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
			$data['applied_year1']=$applied_year = $this->input->post('applied_year');
			$data['applied_sem1']=$applied_sem = $this->input->post('applied_sem');
		if($applied_sem == 1 || $applied_sem == 3 || $applied_sem == 5)
        {$this->db->where('(erp_exammarkfinal.sem=1 OR erp_exammarkfinal.sem=3 OR erp_exammarkfinal.sem=5)');}
	    else{$this->db->where('(erp_exammarkfinal.sem=2 OR erp_exammarkfinal.sem=4 OR erp_exammarkfinal.sem=6)');}	
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->join('erp_existing_students','erp_exammarkfinal.student_id=erp_existing_students.id','left')
		->where('erp_exammarkfinal.batch_year',$batch)
		->where('erp_exammarkfinal.subject_id',$subject)
		->where('erp_exammarkfinal.main_id',$stream)
		->where('erp_exammarkfinal.course_id',$department)
		->where('(erp_exammarkfinal.result = "R(I + E)" OR erp_exammarkfinal.result = "R(I)")')
		->order_by('erp_exammarkfinal.id','desc')
		->get('erp_exammarkfinal')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/icaArrear',$data);
    $this->load->view('template/coe/footer');		
	}
	public function examMarksAverageArrear()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['sem1']='';
		$data['stream']='';
		$data['department']='';
		$data['applied_year1']='';
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
			$data['applied_year1']=$applied_year = $this->input->post('applied_year');
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->join('erp_existing_students','erp_exammarkfinal.student_id=erp_existing_students.id','left')
		->where('erp_exammarkfinal.batch_year',$batch)
		->where('erp_exammarkfinal.subject_id',$subject)
		->where('erp_exammarkfinal.main_id',$stream)
		->where('erp_exammarkfinal.course_id',$department)
		->where('erp_exammarkfinal.arrear_status',1)
		->where('erp_exammarkfinal.arrear_applied_year',$applied_year)
		->order_by('erp_exammarkfinal.id','desc')
		->get('erp_exammarkfinal')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/examMarksAverageArrear',$data);
    $this->load->view('template/coe/footer');	
	}
	public function icaTotalMarkArrear()
	{
	$ica=$this->input->post('ica');
	$icaval=$this->input->post('icaval');
	$main_id=$this->input->post('main_id');
	$course_id=$this->input->post('course_id');
	$subject_id=$this->input->post('subject_id');
	//$ica_not=$this->input->post('ica_not');
	$batch=$this->input->post('batch');
	$applied_year=$this->input->post('applied_year');
	$applied_sem=$this->input->post('applied_sem');
	$sem=$this->input->post('sem');
	$user_id=$this->session->userdata('user')['user_id'];
	$add_date=date('Y-m-d H:i:s');
	
	for($i=0; $i<sizeof($ica); $i++){
		$data = array();
		$det = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$ica[$i])->where('subject_id',$subject_id)->get('erp_exammarkfinal')->row();
		if(isset($det)){
			$backup = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$ica[$i])->where('subject_id',$subject_id)->where('arrear_applied_year',$applied_year)->get('erp_arrear_backup')->row();
			if(!isset($backup)){
				$this->db->insert('erp_arrear_backup',$det);
			}
		}
	 if(!isset($det)){	
	$data['batch_year']=$batch; 
	$data['sem']=$sem; 
	$data['subject_id']=$subject_id;
	$data['student_id']=$ica[$i];
	$data['ica']=$icaval[$i];
	$data['main_id']=$main_id;
	$data['course_id']=$course_id;	
	$data['arrear_status']=1;
	$data['arrear_applied_year']=$applied_year;
	$data['arrear_applied_sem']=$applied_sem;
	$data['user_id']=$user_id;
	$data['created_at']=$add_date;
	$this->db->insert('erp_exammarkfinal',$data);
	 }else{	 
	$data['ica']=$icaval[$i];		
	$data['arrear_status']=1;
	$data['arrear_applied_year']=$applied_year;
	 $this->db->where('id',$det->id);	
	$this->db->update('erp_exammarkfinal',$data);
	 }
	}
	
	/*for($ii=0; $ii<sizeof($ica_not); $ii++){
		$delete = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$ica_not[$ii])->where('subject_id',$subject_id)->get('erp_exammarkfinal')->row();
	 if(isset($delete)){	
	 $data1['ica']=null;
	$this->db->where('id',$delete->id);	
	$this->db->update('erp_exammarkfinal',$data1);
	 }
	}*/
	echo 'Success';
    }
	public function internalMarkArrear()
	{
	$internal=$this->input->post('internal');
	$intval=$this->input->post('intval');
	$main_id=$this->input->post('main_id');
	$course_id=$this->input->post('course_id');
	$subject_id=$this->input->post('subject_id');
	//$internal_not=$this->input->post('internal_not');
	$batch=$this->input->post('batch');
	$applied_year=$this->input->post('applied_year');
	$applied_sem=$this->input->post('applied_sem');
	$sem=$this->input->post('sem');
	$user_id=$this->session->userdata('user')['user_id'];
	$add_date=date('Y-m-d H:i:s');
	
	for($i=0; $i<sizeof($internal); $i++){
		$data = array();
		$det = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$internal[$i])->where('subject_id',$subject_id)->get('erp_exammarkfinal')->row();
		if(isset($det)){
			$backup = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$ica[$i])->where('subject_id',$subject_id)->where('arrear_applied_year',$applied_year)->get('erp_arrear_backup')->row();
			if(!isset($backup)){
				$this->db->insert('erp_arrear_backup',$det);
			}
		}
	 if(!isset($det)){	
	$data['batch_year']=$batch; 
	$data['sem']=$sem; 
	$data['subject_id']=$subject_id; 
	$data['student_id']=$internal[$i];
	$data['internal']=$intval[$i];
	$data['main_id']=$main_id;
	$data['course_id']=$course_id;
	$data['arrear_status']=1;
	$data['arrear_applied_year']=$applied_year;
	$data['arrear_applied_sem']=$applied_sem;
	$data['user_id']=$user_id;
	$data['created_at']=$add_date;
	$this->db->insert('erp_exammarkfinal',$data);
	 }else{
	$data['internal']=$intval[$i];	
	$data['arrear_status']=1;
	$data['arrear_applied_year']=$applied_year;
	$data['arrear_applied_sem']=$applied_sem;
	 $this->db->where('id',$det->id);	
	$this->db->update('erp_exammarkfinal',$data);
	 }
	}
	
	/*for($ii=0; $ii<sizeof($internal_not); $ii++){
		$delete = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$internal_not[$ii])->where('subject_id',$subject_id)->get('erp_exammarkfinal')->row();
	 if(isset($delete)){	
	 $data1['internal']=null;
	$this->db->where('id',$delete->id);		
	$this->db->update('erp_exammarkfinal',$data1);
	 }
	}*/
	echo 'Success';
    }
	public function externalMarkArrear()
	{
	$external=$this->input->post('external');
	$extval=$this->input->post('extval');
	$main_id=$this->input->post('main_id');
	$course_id=$this->input->post('course_id');
	$subject_id=$this->input->post('subject_id');
	//$external_not=$this->input->post('external_not');
	$batch=$this->input->post('batch');
	$applied_year=$this->input->post('applied_year');
	$applied_sem=$this->input->post('applied_sem');
	$sem=$this->input->post('sem');
	$user_id=$this->session->userdata('user')['user_id'];
	$add_date=date('Y-m-d H:i:s');
	
	for($i=0; $i<sizeof($external); $i++){
		$data = array();
		$det = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$external[$i])->where('subject_id',$subject_id)->get('erp_exammarkfinal')->row();
		if(isset($det)){
			$backup = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$ica[$i])->where('subject_id',$subject_id)->where('arrear_applied_year',$applied_year)->get('erp_arrear_backup')->row();
			if(!isset($backup)){
				$this->db->insert('erp_arrear_backup',$det);
			}
		}
	 if(!isset($det)){	
	$data['batch_year']=$batch; 
	$data['sem']=$sem; 
	$data['subject_id']=$subject_id; 
	$data['student_id']=$external[$i];
	$data['external']=$extval[$i];
	$data['main_id']=$main_id;
	$data['course_id']=$course_id;
	$data['arrear_status']=1;
	$data['arrear_applied_year']=$applied_year;
	$data['arrear_applied_sem']=$applied_sem;
	$data['user_id']=$user_id;
	$data['created_at']=$add_date;
	$this->db->insert('erp_exammarkfinal',$data);
	 }else{	 
	$data['external']=$extval[$i];	
	$data['arrear_status']=1;
	$data['arrear_applied_year']=$applied_year;
	$data['arrear_applied_sem']=$applied_sem;
	 $this->db->where('id',$det->id);		
	$this->db->update('erp_exammarkfinal',$data);
	 }
	}
	
	/*for($ii=0; $ii<sizeof($external_not); $ii++){
		$delete = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$external_not[$ii])->where('subject_id',$subject_id)->get('erp_exammarkfinal')->row();
	 if(isset($delete)){	
	 $data1['external']=null;
	$this->db->where('id',$delete->id);	
	$this->db->update('erp_exammarkfinal',$data1);
	 }
	}*/
	echo 'Success';
    }
	public function thirdPartyMarkArrear()
	{
	$thirdparty=$this->input->post('thirdparty');
	$tpval=$this->input->post('tpval');
	$main_id=$this->input->post('main_id');
	$course_id=$this->input->post('course_id');
	$subject_id=$this->input->post('subject_id');
	//$thirdparty_not=$this->input->post('thirdparty_not');
	$batch=$this->input->post('batch');
	$applied_year=$this->input->post('applied_year');
	$applied_sem=$this->input->post('applied_sem');
	$sem=$this->input->post('sem');
	$user_id=$this->session->userdata('user')['user_id'];
	$add_date=date('Y-m-d H:i:s');
	
	for($i=0; $i<sizeof($thirdparty); $i++){
		$data = array();
		$det = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$thirdparty[$i])->where('subject_id',$subject_id)->get('erp_exammarkfinal')->row();
		if(isset($det)){
			$backup = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$ica[$i])->where('subject_id',$subject_id)->where('arrear_applied_year',$applied_year)->get('erp_arrear_backup')->row();
			if(!isset($backup)){
				$this->db->insert('erp_arrear_backup',$det);
			}
		}
	 if(!isset($det)){	
	$data['batch_year']=$batch; 
	$data['sem']=$sem; 
	$data['subject_id']=$subject_id; 
	$data['student_id']=$thirdparty[$i];
	$data['thirdparty']=$tpval[$i];
	$data['main_id']=$main_id;
	$data['course_id']=$course_id;
	$data['arrear_status']=1;
	$data['arrear_applied_year']=$applied_year;
	$data['arrear_applied_sem']=$applied_sem;
	$data['user_id']=$user_id;
	$data['created_at']=$add_date;
	$this->db->insert('erp_exammarkfinal',$data);
	 }else{	 
	$data['thirdparty']=$tpval[$i];	
	$data['arrear_status']=1;
	$data['arrear_applied_year']=$applied_year;
	$data['arrear_applied_sem']=$applied_sem;
	 $this->db->where('id',$det->id);		
	$this->db->update('erp_exammarkfinal',$data);
	 }
	}
	
	/*for($ii=0; $ii<sizeof($thirdparty_not); $ii++){
		$delete = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$thirdparty_not[$ii])->where('subject_id',$subject_id)->get('erp_exammarkfinal')->row();
	 if(isset($delete)){	
	 $data1['thirdparty']=null;
	$this->db->where('id',$delete->id);	
	$this->db->update('erp_exammarkfinal',$data1);
	 }
	}*/
	echo 'Success';
    }
	
	public function moderationArrear()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['sem1']='';
		$data['stream']='';
		$data['department']='';
		$data['applied_year1']='';
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
			$data['applied_year1']=$applied_year = $this->input->post('applied_year');
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->join('erp_existing_students','erp_exammarkfinal.student_id=erp_existing_students.id','left')
		->where('erp_exammarkfinal.batch_year',$batch)
		->where('erp_exammarkfinal.subject_id',$subject)
		->where('erp_exammarkfinal.main_id',$stream)
		->where('erp_exammarkfinal.course_id',$department)
		->where('erp_exammarkfinal.arrear_status',1)
		->where('erp_exammarkfinal.arrear_applied_year',$applied_year)
		->order_by('erp_exammarkfinal.id','desc')
		->get('erp_exammarkfinal')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/moderationArrear',$data);
    $this->load->view('template/coe/footer');	
	}
	
	public function beforeModerationArrear()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['sem1']='';
		$data['stream']='';
		$data['department']='';
		$data['applied_year1']='';
		$data['all_dep_details'] = '';
		$data['all_sub_details'] = '';
		$data['exam_details'] = '';
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
			$data['applied_year1']=$applied_year = $this->input->post('applied_year');
			
			$data['all_dep_details'] = $this->db->select("*")->from("department_details")->where("department_details.main_id",$stream)->where("department_details.cour_id",$department)->get()->result();
		
		
			$data['all_sub_details'] = $this->db->select("*")->from("erp_subjectmaster")->where("erp_subjectmaster.id",$subject)->get()->result();
			if($sem == 1 ||$sem == 3 ||$sem == 5){

		    $data['exam_details'] = 'November -'.date("Y",strtotime($data['all_sub_details'][0]->add_date));

	        }else{

		     $data['exam_details'] = 'May -'.date("Y",strtotime($data['all_sub_details'][0]->add_date));

	        }
			
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->join('erp_existing_students','erp_exammarkfinal.student_id=erp_existing_students.id','left')
		->where('erp_exammarkfinal.batch_year',$batch)
		->where('erp_exammarkfinal.subject_id',$subject)
		->where('erp_exammarkfinal.main_id',$stream)
		->where('erp_exammarkfinal.course_id',$department)
		->where('erp_exammarkfinal.arrear_status',1)
		->where('erp_exammarkfinal.arrear_applied_year',$applied_year)
		->order_by('erp_exammarkfinal.id','desc')
		->get('erp_exammarkfinal')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/beforeModerationArrear',$data);
    $this->load->view('template/coe/footer');	
	}
	
	public function beforeModerationArrearPDF()
	{
		$this->load->library("pdf");
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$date=date('Y-m-d');
		
		    $data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
			$data['applied_year1']=$applied_year = $this->input->post('applied_year');
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->join('erp_existing_students','erp_exammarkfinal.student_id=erp_existing_students.id','left')
		->where('erp_exammarkfinal.batch_year',$batch)
		->where('erp_exammarkfinal.subject_id',$subject)
		->where('erp_exammarkfinal.main_id',$stream)
		->where('erp_exammarkfinal.course_id',$department)
		->where('erp_exammarkfinal.arrear_status',1)
		->where('erp_exammarkfinal.arrear_applied_year',$applied_year)
		->order_by('erp_exammarkfinal.id','desc')
		->get('erp_exammarkfinal')->result();
		
		$subj = $this->db->where('id',$subject)->get('erp_subjectmaster')->row();
		ob_start();
            $html = $this->load->view("coe/beforeModerationPDF", $data, true);
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
            $dompdf->stream("BeforeModeration_".$batch."_".$subj->subName.".pdf", ["Attachment" => 1]);
		
    //$this->load->view('coe/transferCert',$data);
	}
	public function afterModerationArrear()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['sem1']='';
		$data['stream']='';
		$data['department']='';
		$data['applied_year1']='';
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
			$data['applied_year1']=$applied_year = $this->input->post('applied_year');
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->join('erp_existing_students','erp_exammarkfinal.student_id=erp_existing_students.id','left')
		->where('erp_exammarkfinal.batch_year',$batch)
		->where('erp_exammarkfinal.subject_id',$subject)
		->where('erp_exammarkfinal.main_id',$stream)
		->where('erp_exammarkfinal.course_id',$department)
		->where('erp_exammarkfinal.arrear_status',1)
		->where('erp_exammarkfinal.arrear_applied_year',$applied_year)
		->order_by('erp_exammarkfinal.id','desc')
		->get('erp_exammarkfinal')->result();
		}
		
		if(isset($_POST['publish'])){
		 $data['batch1'] = $batch=$this->input->post('batch');
	     $data['stream'] = $stream=$this->input->post('stream');
	     $data['department'] = $department=$this->input->post('department');
	     $data['sem1'] = $sem=$this->input->post('sem');
	     $data['subject1'] = $subject=$this->input->post('subject');
		 $data['applied_year1']=$applied_year = $this->input->post('applied_year');
		 $batch_id = $this->db->where('batch_from',$batch)->get('erp_batchmaster')->row();
		
		 $data_add = array(
		  'batch_id' => $batch_id->id,
		  'batch_year' => $batch,
		  'applied_year' => $applied_year,
		  'subject_id' => $subject,
		  'sem' => $sem,
		  'main_id' => $stream,
		  'course_id' => $department,
		  'status' => 1,
		  'user_id' => $user_id,
		  'created_at' => $add_date,
		 );
		  
		$insert = $this->db->insert('erp_publish_mark_arrear',$data_add);
		$data['msg']=$this->session->set_flashdata('success','Published Mark Successfully','success');
        $data['stu_list'] = $this->db->select('erp_existing_students.*')
		->join('erp_existing_students','erp_exammarkfinal.student_id=erp_existing_students.id','left')
		->where('erp_exammarkfinal.batch_year',$batch)
		->where('erp_exammarkfinal.subject_id',$subject)
		->where('erp_exammarkfinal.main_id',$stream)
		->where('erp_exammarkfinal.course_id',$department)
		->where('erp_exammarkfinal.arrear_status',1)
		->where('erp_exammarkfinal.arrear_applied_year',$applied_year)
		->order_by('erp_exammarkfinal.id','desc')
		->get('erp_exammarkfinal')->result();		
		}
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/afterModerationArrear',$data);
    $this->load->view('template/coe/footer');	
	}
	
	public function publishResultArrear()
	{
	$result=$this->input->post('result');
	$rsval=$this->input->post('rsval');
	$main_id=$this->input->post('main_id');
	$course_id=$this->input->post('course_id');
	$subject_id=$this->input->post('subject_id');
	$batch=$this->input->post('batch');
	$sem=$this->input->post('sem');
	$applied_year=$this->input->post('applied_year');
	$user_id=$this->session->userdata('user')['user_id'];
	$add_date=date('Y-m-d H:i:s');
	
	for($i=0; $i<sizeof($result); $i++){
		$data = array();
		$det = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$result[$i])->where('subject_id',$subject_id)->get('erp_exammarkfinal')->row();
	 if(!isset($det)){	
	$data['batch_year']=$batch; 
	$data['sem']=$sem; 
	$data['subject_id']=$subject_id; 
	$data['student_id']=$result[$i];
	$data['result']=$rsval[$i];
	$data['main_id']=$main_id;
	$data['course_id']=$course_id;
	$data['user_id']=$user_id;
	$data['created_at']=$add_date;
	$this->db->insert('erp_exammarkfinal',$data);
	 }else{	 
	$data['result']=$rsval[$i];	
	 $this->db->where('id',$det->id);		
	$this->db->update('erp_exammarkfinal',$data);
	 }
	 
	 if($rsval[$i]=='P'){
	$data_stat['result_status']	= 'pass'; 
	$this->db->where('student_id',$result[$i])->where('student_batch',$batch)->where('sem',$sem)->where('applied_year',$applied_year);		
	$this->db->update('erp_arrear_detail',$data_stat);
	 }
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
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/grievances',$data);
    $this->load->view('template/coe/footer');	
	}
	
	public function updateGrievance()
	{
	$data['coe_id']=$user_id=$this->session->userdata('user')['user_id'];
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
	
	public function retotalling()
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
		$data['stu_list'] = $this->db->select('erp_existing_students.id as student_id,erp_existing_students.student_name_,erp_retotalling.*')
		->join('erp_existing_students','erp_retotalling.student_id=erp_existing_students.id','left')
		->where('erp_retotalling.batch_year',$batch)
		->where('erp_retotalling.subject_id',$subject)
		->where('erp_retotalling.main_id',$stream)
		->where('erp_retotalling.course_id',$department)
		->where('erp_retotalling.status','open')
		->order_by('erp_retotalling.id','desc')
		->get('erp_retotalling')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/retotalling',$data);
    $this->load->view('template/coe/footer');	
	}
	
	public function updateRetotalling()
	{
	$data['coe_id']=$user_id=$this->session->userdata('user')['user_id'];
	$id=$this->input->post('retotalling_id');
	$data['solution']=$this->input->post('solution');
	$data['status']=$this->input->post('status');
	$data1['ica']=$icamrk=$this->input->post('ica');if($icamrk==''){$data1['ica']=0;}
	$data1['internal']=$internal=$this->input->post('internal');if($internal==''){$data1['internal']=0;}
	$data1['external']=$external=$this->input->post('external');if($external==''){$data1['external']=0;}
	$data1['thirdparty']=$thirdparty=$this->input->post('thirdparty');if($thirdparty==''){$data1['thirdparty']=0;}
	$data1['average']=$mark=$this->input->post('average');
	$mark_id=$this->input->post('mark_id');
	$stream=$this->input->post('stream');
	
	$this->db->where('id',$id);
    $this->db->update('erp_retotalling',$data);
	
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
	$data1['retotalling_status']=1;
		
      $this->db->where('id',$mark_id);
      $this->db->update('erp_exammarkfinal',$data1);	
	  
	echo 'Success';
    }
	
	public function do_upload_ann()
	{
		$config = array();
		$config['upload_path'] = './uploads/admin_files/';
		$config['allowed_types'] = '*';
		$config['remove_spaces'] = TRUE;
		$config['overwrite'] = TRUE;
		return $config;
	}
	public function studentannouncements()
	{
		$user = $this->session->userdata("user")["user_id"];

		date_default_timezone_get();
		$add_date = date('Y-m-d h:i:s');
		$data['announsment'] = $this->db
		->from('announcement')
		->join(
			"department_details",
			"announcement.ann_main = department_details.main_id AND announcement.ann_course = department_details.cour_id","left"
		)
		->where('ann_coe', $user)->get()->result();
		if (isset($_POST['submit'])) {
			$data_ann['ann_main'] = $main_course_id = $this->input->post('main_course_id');
			$data_ann['ann_course'] = $app_course_id = $this->input->post('app_course_id');
			$data_ann['ann_name'] = $this->input->post('title');
			$data_ann['ann_desc'] = $this->input->post('remark');
			$data_ann['ann_batch'] = $this->input->post('batch');
			$data_ann['ann_year'] = $this->input->post('year');
			$data_ann['ann_date_till'] = $this->input->post('date_till');
			$data_ann['ann_coe'] = $user;
			//$data_ann['ann_date_till'] = $add_date;

		

			if ($_FILES['upload_doc']['size'] != 0) {
				/* if (isset($get_announcement) && $get_announcement->upload_doc != '') {
					$get_path = $array = explode('-', $get_announcement->upload_doc, 2);
					if ($get_path[1] == $_FILES['upload_doc']['name']) {
						unlink(APPPATH . '../' . $get_announcement->upload_doc);
					}
				} */
				$_FILES["file"]["name"] = rand() . '-' . $_FILES["upload_doc"]["name"];
				$_FILES["file"]["type"] = $_FILES["upload_doc"]["type"];
				$_FILES["file"]["tmp_name"] = $_FILES["upload_doc"]["tmp_name"];
				$_FILES["file"]["error"] = $_FILES["upload_doc"]["error"];
				$_FILES["file"]["size"] = $_FILES["upload_doc"]["size"];
				$this->upload->initialize();
				$this->upload->initialize($this->do_upload_ann());
				if ($this->upload->do_upload('file')) {
					$file = $this->upload->data();
					$image = $file['file_name'];
					$data_ann['ann_upload'] = 'uploads/admin_files/' . $image;
				} else {
					$error = array('error' => $this->upload->display_errors());
					print_r($error);
					exit;
				}
			}

		
				$insert = $this->db->insert('announcement', $data_ann);
			
			$this->session->set_flashdata(
				"message",
				' <div class="alert alert-success alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Success !</strong> Successfully Inserted .
		</div>'
			);
			redirect('coe/studentannouncements', 'refresh');
		}

		$this->load->view('template/coe/header');
		$this->load->view('template/coe/menubar');
		$this->load->view('template/coe/headerbar');
		$this->load->view('coe/announcements',$data);
		$this->load->view('template/coe/footer');
	}
	public function get_announcement()
	{
		$main_course_id = $this->input->post('main_course_id');
		$app_course_id = $this->input->post('app_course_id');
		$get_announcement = $this->db->where('main_course_id', $main_course_id)->where('app_course_id', $app_course_id)->get('announcement')->result();
		echo json_encode($get_announcement);
	}
	public function get_app_course_id_fun()
	{
		$main_course_id = $this->input->post('main_course_id');

		if ($main_course_id == 1) {
			$pg_sf = $this->db->where('cs_id=5 or cs_id=6 or cs_id=7 or cs_id=8 or cs_id=9 or cs_id=15 or cs_id=16')->get('college_course')->result();
			$option = "<option value=''>Select an Option</option>";
			foreach ($pg_sf as $pgsf) {
				$option .= "<option value='" . $pgsf->cs_id . "'>" . $pgsf->cs_name . "</option>";
			}
			echo $option;
		} else if ($main_course_id == 2 || $main_course_id == 3) {
			$option = "<option value=''>Select an Option</option>";
			$pg_msw = array('1' => 'Community Development', '2' => 'Medical & Psychiatric Social Work', '3' => 'Human Resource Management');
			foreach ($pg_msw as $key => $pgmsw) {
				$option .= "<option value='" . $key . "'>" . $pgmsw . "</option>";
			}
			echo $option;
		} else if ($main_course_id == 4) {
			$option = "<option value=''>Select an Option</option>";
			$option .= "<option value='10'>Personnel Management & Industrial Relations (SF)</option>";
			$option .= "<option value='11'>Human Resource Management (SF)</option>";
			echo $option;
		} else if ($main_course_id == 5) {
			$option = "<option value=''>Select an Option</option>";
			$option .= "<option value='1'>B.S.W (SF)</option>";
			$option .= "<option value='2'>B.Sc Psychology (SF)</option>";
			echo $option;
		}else if ($main_course_id == 6) {
			$option = "<option value=''>Select an Option</option>";
			$option .= "<option value='0'>All</option>";
			//$option .= "<option value='2'>B.Sc Psychology (SF)</option>";
			echo $option;
		} else {
			echo $option = "<option value=''>Select an Option</option>";
		}
	}

	public function delete_announcement(){

		$id= $this->input->post('delete_id');


		$this->db->where('ann_id',$id);
		$this->db->delete('announcement');

		echo $this->session->set_flashdata(
			"message",
			' <div class="alert alert-danger alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Delete !</strong> Deleted Successfully .
		</div>'
		);


	}
	
	public function draftMarksheet()
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
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/draftMarksheet',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function draftMarksheetPDF()
	{
		$this->load->library("pdf");
		$id = $data['student_id'] = $this->uri->segment('3');
		$sem = $data['sem'] = $this->uri->segment('4');
		$batch = $data['batch'] = $this->uri->segment('5');
		//$id = $data['student_id'] = 2885;
		//$sem = $data['sem'] = 1;
		//$batch = $data['batch'] = 2022;
		
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$date=date('Y-m-d');
		
		//$data['stu_list'] = $studet = $this->db->query('select em.*,es.*,esm.* from erp_exammarkfinal em join erp_existing_students es on em.student_id=es.id join erp_subjectmaster esm on em.subject_id=esm.id  where em.student_id='.$id.' and em.sem='.$sem.' and em.batch_year='.$batch.'  ')->result();
		
		$data['stu_list'] = $studet = $this->db->query('select em.*,es.*,esm.* from erp_exammarkfinal em join erp_existing_students es on em.student_id=es.id join erp_subjectmaster esm on em.subject_id=esm.id left join erp_langallot l on (l.existing_student_id='.$id.' and l.batch='.$batch.' and l.sem='.$sem.' and l.subject_id=esm.id and l.status=1) left join erp_student_elective_subject e on (e.e_admit_stu_id='.$id.' and e.e_batch='.$batch.' and e.e_sem='.$sem.' and e.e_subject=esm.id) where em.student_id='.$id.' and em.sem='.$sem.' and em.batch_year='.$batch.' and (((esm.part=1 OR esm.part=4) AND l.subject_id is not null) or (esm.part!=1 AND esm.part!=4 AND l.subject_id is null)) and ((esm.subCatg="Elective" AND e.e_subject is not null) or (esm.subCatg!="Elective" AND e.e_subject is null)) order by (SUBSTRING_INDEX(esm.subCode, "/",-1)) asc')->result();
		
		ob_start();
            $html = $this->load->view("coe/draftMarksheetPDF", $data, true);
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
            //$dompdf->load_html($html, "mypdf", false);
            $dompdf->load_html($html);
            $dompdf->setPaper("A4", "portrait");
            $dompdf->render();
            ob_end_clean();
            $dompdf->stream("DraftMarksheet.pdf", ["Attachment" => 1]);
		
    //$this->load->view('coe/draftMarksheetPDF',$data);
	}
	
	
	
	public function draftIssue()
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
		$data['stu_list'] = $this->db->select('erp_existing_students.id as student_id,erp_existing_students.student_name_,erp_draft.*')
		->join('erp_existing_students','erp_draft.student_id=erp_existing_students.id','left')
		->where('erp_draft.batch_year',$batch)
		->where('erp_draft.subject_id',$subject)
		->where('erp_draft.main_id',$stream)
		->where('erp_draft.course_id',$department)
		->where('erp_draft.status','open')
		->order_by('erp_draft.id','desc')
		->get('erp_draft')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/draftIssue',$data);
    $this->load->view('template/coe/footer');	
	}
	
	public function updateDraftIssue()
	{
	$data['coe_id']=$user_id=$this->session->userdata('user')['user_id'];
	$id=$this->input->post('draft_id');
	$data['solution']=$this->input->post('solution');
	$data['status']=$this->input->post('status');
	$data1['ica']=$icamrk=$this->input->post('ica');if($icamrk==''){$data1['ica']=0;}
	$data1['internal']=$internal=$this->input->post('internal');if($internal==''){$data1['internal']=0;}
	$data1['external']=$external=$this->input->post('external');if($external==''){$data1['external']=0;}
	$data1['thirdparty']=$thirdparty=$this->input->post('thirdparty');if($thirdparty==''){$data1['thirdparty']=0;}
	$data1['average']=$mark=$this->input->post('average');
	$mark_id=$this->input->post('mark_id');
	$stream=$this->input->post('stream');
	
	$this->db->where('id',$id);
    $this->db->update('erp_draft',$data);
	
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
	$data1['draft_status']=1;
		
      $this->db->where('id',$mark_id);
      $this->db->update('erp_exammarkfinal',$data1);	
	  
	echo 'Success';
    }
	
	public function finalMarksheet()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['stream']='';
		$data['department']='';
		$data['sem1']='';
		
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		//->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/finalMarksheet',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function finalMarksheetPDF()
	{
		$this->load->library("pdf");
		$id = $data['student_id'] = $this->uri->segment('3');
		$sem = $data['sem'] = $this->uri->segment('4');
		$batch = $data['batch'] = $this->uri->segment('5');
		//$id = $data['student_id'] = 2045;
		//$sem = $data['sem'] = 2;
		//$batch = $data['batch'] = 2020;
		
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$date=date('Y-m-d');
		
		//$data['stu_list'] = $studet = $this->db->query('select em.*,es.*,esm.* from erp_exammarkfinal em join erp_existing_students es on em.student_id=es.id join erp_subjectmaster esm on em.subject_id=esm.id where em.student_id='.$id.' and em.sem='.$sem.' and em.batch_year='.$batch.' ')->result();
		//$data['stu_list'] = $studet = $this->db->query('select em.*,es.*,esm.* from erp_exammarkfinal em join erp_existing_students es on em.student_id=es.id join erp_subjectmaster esm on em.subject_id=esm.id left join erp_student_elective_subject e on (e.e_admit_stu_id='.$id.' and e.e_batch='.$batch.' and e.e_sem='.$sem.' and e.e_subject=esm.id) where em.student_id='.$id.' and em.sem='.$sem.' and em.batch_year='.$batch.' and ((esm.subCatg="Elective" AND e.e_subject is not null) or (esm.subCatg!="Elective" AND e.e_subject is null)) ')->result();
		$data['stu_list'] = $studet = $this->db->query('select em.*,es.*,esm.* from erp_exammarkfinal em join erp_existing_students es on em.student_id=es.id join erp_subjectmaster esm on em.subject_id=esm.id left join erp_langallot l on (l.existing_student_id='.$id.' and l.batch='.$batch.' and l.sem='.$sem.' and l.subject_id=esm.id and l.status=1) left join erp_student_elective_subject e on (e.e_admit_stu_id='.$id.' and e.e_batch='.$batch.' and e.e_sem='.$sem.' and e.e_subject=esm.id) where em.student_id='.$id.' and em.sem='.$sem.' and em.batch_year='.$batch.' and (((esm.part=1 OR esm.part=4) AND l.subject_id is not null) or (esm.part!=1 AND esm.part!=4 AND l.subject_id is null)) and ((esm.subCatg="Elective" AND e.e_subject is not null) or (esm.subCatg!="Elective" AND e.e_subject is null)) order by (SUBSTRING_INDEX(esm.subCode, "/",-1)) asc ')->result();
		
		ob_start();
            $html = $this->load->view("coe/finalMarksheetPDF", $data, true);
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
            //$dompdf->load_html($html, "mypdf", false);
            $dompdf->load_html($html);
            $dompdf->setPaper("A4", "portrait");
            $dompdf->render();
            ob_end_clean();
            $dompdf->stream("FinalMarksheet.pdf", ["Attachment" => 1]);
		
    //$this->load->view('coe/hallTicketPDF',$data);
	}
	
	public function consolidatedMarksheet()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['stream']='';
		$data['department']='';
		$data['sem1']='';
		
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		//->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/consolidatedMarksheet',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function consolidatedMarksheetPDF()
	{
		$this->load->library("pdf");
		$id = $data['student_id'] = $this->uri->segment('3');
		$sem = $data['sem'] = $this->uri->segment('4');
		$batch = $data['batch'] = $this->uri->segment('5');
		//$id = $data['student_id'] = 2045;
		//$sem = $data['sem'] = 2;
		//$batch = $data['batch'] = 2020;
		
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$date=date('Y-m-d');
		
		//$data['stu_list'] = $studet = $this->db->query('select em.*,es.*,esm.* from erp_exammarkfinal em join erp_existing_students es on em.student_id=es.id join erp_subjectmaster esm on em.subject_id=esm.id where em.student_id='.$id.' and em.sem='.$sem.' and em.batch_year='.$batch.' and em.result="P" order by em.sem asc')->result();
		//$data['stu_list'] = $studet = $this->db->query('select em.*,es.*,esm.* from erp_exammarkfinal em join erp_existing_students es on em.student_id=es.id join erp_subjectmaster esm on em.subject_id=esm.id left join erp_student_elective_subject e on (e.e_admit_stu_id='.$id.' and e.e_batch='.$batch.' and e.e_sem='.$sem.' and e.e_subject=esm.id) where em.student_id='.$id.' and em.sem='.$sem.' and em.batch_year='.$batch.' and ((esm.subCatg="Elective" AND e.e_subject is not null) or (esm.subCatg!="Elective" AND e.e_subject is null)) ')->result();
		$data['stu_list'] = $studet = $this->db->query('select em.*,es.*,esm.* from erp_exammarkfinal em join erp_existing_students es on em.student_id=es.id join erp_subjectmaster esm on em.subject_id=esm.id left join erp_langallot l on (l.existing_student_id='.$id.' and l.batch='.$batch.' and l.sem='.$sem.' and l.subject_id=esm.id and l.status=1) left join erp_student_elective_subject e on (e.e_admit_stu_id='.$id.' and e.e_batch='.$batch.' and e.e_sem='.$sem.' and e.e_subject=esm.id) where em.student_id='.$id.' and em.sem='.$sem.' and em.batch_year='.$batch.' and em.result="P" and (((esm.part=1 OR esm.part=4) AND l.subject_id is not null) or (esm.part!=1 AND esm.part!=4 AND l.subject_id is null)) and ((esm.subCatg="Elective" AND e.e_subject is not null) or (esm.subCatg!="Elective" AND e.e_subject is null)) order by (SUBSTRING_INDEX(esm.subCode, "/",-1)) asc ')->result();
		
		ob_start();
            $html = $this->load->view("coe/consolidatedMarksheetPDF", $data, true);
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
            //$dompdf->load_html($html, "mypdf", false);
            $dompdf->load_html($html);
            $dompdf->setPaper("A4", "portrait");
            $dompdf->render();
            ob_end_clean();
            $dompdf->stream("ConsolidatedMarksheet.pdf", ["Attachment" => 1]);
		
    //$this->load->view('coe/hallTicketPDF',$data);
	}
	
	public function subjectReport()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['batch_list']=$this->db->get('erp_batchmaster')->result();
		
		$data['batch1']='';
		$data['stream']='';
		$data['department']='';
		$data['sem1']='';
		
		if(isset($_POST['batch_submit'])){
			$batch = $data['batch1'] = $this->input->post('batch');
			$sem = $data['sem1'] = $this->input->post('sem');
			$department = $data['department'] = $this->input->post('department');
			$stream = $data['stream'] = $this->input->post('stream');
		
		$data['sub_list']=$this->db->where('batch_id',$batch)->where('sem',$sem)->where('stream',$stream)->where('department',$department)->order_by('subCode','asc')->get('erp_subjectmaster')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/subjectReport',$data);
    $this->load->view('template/coe/footer');	
	}
	
	public function convocationDetails()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['stream']='';
		$data['department']='';
		
		if(isset($_POST['submit'])){
			$data_in['batch']=$this->input->post('batch');
			$data_in['main_id']=$this->input->post('stream');
			$data_in['course_id']=$this->input->post('department');
			$data_in['details']=$this->input->post('details');
			$data_in['status']=1;
			$data_in['created_by']=$user_id;
			$data_in['created_at']=$add_date;
			$this->db->insert('erp_convocation_details',$data_in);
			
		$data['batch1']=$batch=$this->input->post('batch');
		$data['convocation_list'] = $this->db
		->where('erp_convocation_details.batch',$batch)
		->where('erp_convocation_details.status',1)
		->get('erp_convocation_details')->result();
		
			$data['msg']=$this->session->set_flashdata('success','Details Added Successfully!!','success'); 
			//redirect('coe/convocationDetails','refresh');
		}
		
		if(isset($_POST['list_submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
		$data['convocation_list'] = $this->db
		->where('erp_convocation_details.batch',$batch)
		->where('erp_convocation_details.status',1)
		->get('erp_convocation_details')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/convocationDetails',$data);
    $this->load->view('template/coe/footer');	
	}
	
	public function deleteConvDet()
	{
		$id = $this->input->post('id');
		$delete = $this->db->where('id',$id)->delete('erp_convocation_details');
		echo 'Success';
	}
	
	public function consolidatedAttendance()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['from_date1']='';
		$data['to_date1']='';
		$data['stream']='';
		$data['department']='';
		$data['sem1']='';
		
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['from_date1']=$from_date = $this->input->post('from_date');
			$data['to_date1']=$to_date = $this->input->post('to_date');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		//->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/consolidatedAttendance',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function consolidatedAttPDF()
	{
		$this->load->library("pdf");
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		    $data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
			$data['from_date1']=$from_date = $this->input->post('from_date');
			$data['to_date1']=$to_date = $this->input->post('to_date');
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		//->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		
		$subj = $this->db->where('id',$subject)->get('erp_subjectmaster')->row(); 
		
            $html = $this->load->view("coe/consolidatedAttPDF", $data, true);
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
            $dompdf->setPaper("A4", "portrait");
            $dompdf->render();

//fonts: "helvetica", "bold"	
//$canvas->page_text(left-right, top-bottom, "text", "bold", font-size, array(0,0,0));
$canvas = $dompdf->get_canvas();
$canvas->page_text(500, 820, "Page {PAGE_NUM} of {PAGE_COUNT}", "bold", 10, array(0,0,0));
$canvas->page_script('
  // $pdf is the variable containing a reference to the canvas object provided by dompdf
  $pdf->line(10,730,800,730,array(0,0,0),1);
');

            ob_end_clean();
            $dompdf->stream("CONSOLIDATED_ATTENDANCE_".$subj->subName."_".$batch.".pdf", ["Attachment" => 1]);
		
    //$this->load->view('coe/consolidatedAttPDF',$data);
	}
	
	public function dupSemMarksheet()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['stream']='';
		$data['department']='';
		$data['sem1']='';
		
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
		$data['stu_list'] = $this->db->select('es.*,dm.status,dm.id as dup_id')
		->join('erp_existing_students es','es.id=dm.student_id')
		->where('dm.main_id',$stream)
		->where('dm.course_id',$department)
		->where('dm.batch',$batch)
		->where('dm.sem',$sem)
		->where('dm.type',1)
		->where('dm.status',0)
		->get('erp_duplicate_marksheet dm')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/dupSemMarksheet',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function dupSemMarksheetPDF()
	{
		$this->load->library("pdf");
		$id = $data['student_id'] = $this->uri->segment('3');
		$sem = $data['sem'] = $this->uri->segment('4');
		$batch = $data['batch'] = $this->uri->segment('5');
		//$id = $data['student_id'] = 2045;
		//$sem = $data['sem'] = 2;
		//$batch = $data['batch'] = 2020;
		
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$date=date('Y-m-d');
		
		//$data['stu_list'] = $studet = $this->db->query('select em.*,es.*,esm.* from erp_exammarkfinal em join erp_existing_students es on em.student_id=es.id join erp_subjectmaster esm on em.subject_id=esm.id where em.student_id='.$id.' and em.sem='.$sem.' and em.batch_year='.$batch.' ')->result();
		//$data['stu_list'] = $studet = $this->db->query('select em.*,es.*,esm.* from erp_exammarkfinal em join erp_existing_students es on em.student_id=es.id join erp_subjectmaster esm on em.subject_id=esm.id left join erp_student_elective_subject e on (e.e_admit_stu_id='.$id.' and e.e_batch='.$batch.' and e.e_sem='.$sem.' and e.e_subject=esm.id) where em.student_id='.$id.' and em.sem='.$sem.' and em.batch_year='.$batch.' and ((esm.subCatg="Elective" AND e.e_subject is not null) or (esm.subCatg!="Elective" AND e.e_subject is null)) ')->result();
		$data['stu_list'] = $studet = $this->db->query('select em.*,es.*,esm.* from erp_exammarkfinal em join erp_existing_students es on em.student_id=es.id join erp_subjectmaster esm on em.subject_id=esm.id left join erp_langallot l on (l.existing_student_id='.$id.' and l.batch='.$batch.' and l.sem='.$sem.' and l.subject_id=esm.id and l.status=1) left join erp_student_elective_subject e on (e.e_admit_stu_id='.$id.' and e.e_batch='.$batch.' and e.e_sem='.$sem.' and e.e_subject=esm.id) where em.student_id='.$id.' and em.sem='.$sem.' and em.batch_year='.$batch.' and (((esm.part=1 OR esm.part=4) AND l.subject_id is not null) or (esm.part!=1 AND esm.part!=4 AND l.subject_id is null)) and ((esm.subCatg="Elective" AND e.e_subject is not null) or (esm.subCatg!="Elective" AND e.e_subject is null)) order by (SUBSTRING_INDEX(esm.subCode, "/",-1)) asc ')->result();
		
		ob_start();
            $html = $this->load->view("coe/dupSemMarksheetPDF", $data, true);
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
            //$dompdf->load_html($html, "mypdf", false);
            $dompdf->load_html($html);
            $dompdf->setPaper("A4", "portrait");
            $dompdf->render();
            ob_end_clean();
            $dompdf->stream("DuplicateMarksheet.pdf", ["Attachment" => 1]);
		
    //$this->load->view('coe/dupSemMarksheetPDF',$data);
	}
	
	public function dupConsolidatedMarksheet()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['stream']='';
		$data['department']='';
		$data['sem1']='';
		
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
		$data['stu_list'] = $this->db->select('es.*,dm.status,dm.id as dup_id')
		->join('erp_existing_students es','es.id=dm.student_id')
		->where('dm.main_id',$stream)
		->where('dm.course_id',$department)
		->where('dm.batch',$batch)
		->where('dm.type',2)
		->where('dm.status',0)
		->get('erp_duplicate_marksheet dm')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/dupConsolidatedMarksheet',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function dupConsolidatedMarksheetPDF()
	{
		$this->load->library("pdf");
		$id = $data['student_id'] = $this->uri->segment('3');
		$sem = $data['sem'] = $this->uri->segment('4');
		$batch = $data['batch'] = $this->uri->segment('5');
		//$id = $data['student_id'] = 2045;
		//$sem = $data['sem'] = 2;
		//$batch = $data['batch'] = 2020;
		
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$date=date('Y-m-d');
		
		//$data['stu_list'] = $studet = $this->db->query('select em.*,es.*,esm.* from erp_exammarkfinal em join erp_existing_students es on em.student_id=es.id join erp_subjectmaster esm on em.subject_id=esm.id where em.student_id='.$id.' and em.batch_year='.$batch.' and em.result="P" ')->result();
		//$data['stu_list'] = $studet = $this->db->query('select em.*,es.*,esm.* from erp_exammarkfinal em join erp_existing_students es on em.student_id=es.id join erp_subjectmaster esm on em.subject_id=esm.id left join erp_student_elective_subject e on (e.e_admit_stu_id='.$id.' and e.e_batch='.$batch.' and e.e_sem='.$sem.' and e.e_subject=esm.id) where em.student_id='.$id.' and em.sem='.$sem.' and em.batch_year='.$batch.' and ((esm.subCatg="Elective" AND e.e_subject is not null) or (esm.subCatg!="Elective" AND e.e_subject is null)) ')->result();
		$data['stu_list'] = $studet = $this->db->query('select em.*,es.*,esm.* from erp_exammarkfinal em join erp_existing_students es on em.student_id=es.id join erp_subjectmaster esm on em.subject_id=esm.id left join erp_langallot l on (l.existing_student_id='.$id.' and l.batch='.$batch.' and l.sem='.$sem.' and l.subject_id=esm.id and l.status=1) left join erp_student_elective_subject e on (e.e_admit_stu_id='.$id.' and e.e_batch='.$batch.' and e.e_sem='.$sem.' and e.e_subject=esm.id) where em.student_id='.$id.' and em.sem='.$sem.' and em.batch_year='.$batch.' and em.result="P" and (((esm.part=1 OR esm.part=4) AND l.subject_id is not null) or (esm.part!=1 AND esm.part!=4 AND l.subject_id is null)) and ((esm.subCatg="Elective" AND e.e_subject is not null) or (esm.subCatg!="Elective" AND e.e_subject is null)) order by (SUBSTRING_INDEX(esm.subCode, "/",-1)) asc ')->result();
		
		ob_start();
            $html = $this->load->view("coe/dupConsolidatedMarksheetPDF", $data, true);
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
            //$dompdf->load_html($html, "mypdf", false);
            $dompdf->load_html($html);
            $dompdf->setPaper("A4", "portrait");
            $dompdf->render();
            ob_end_clean();
            $dompdf->stream("DuplicateConsolidatedMarksheet.pdf", ["Attachment" => 1]);
		
    //$this->load->view('coe/dupConsolidatedMarksheetPDF',$data);
	}
	
	public function dupMarksheetStat()
	{
		$id = $this->input->post('id');
		$data_up['status'] = 1;
		$this->db->where('id',$id);
		$this->db->update('erp_duplicate_marksheet',$data_up);
	}
	
	public function naacReport()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['month1'] = '';
		$data['year1'] = '';
		$data['stream1'] = '';
		
		
		if(isset($_POST['submit'])){
		$month = $data['month1'] = $this->input->post('month');
		$year = $data['year1'] = $this->input->post('year');
		$stream = $data['stream1'] = $this->input->post('stream');
		
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$date=date('Y-m-d');
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/naacReport',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function condonationPaid()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$year=date('Y');
		
		$data['batch1']='';
		$data['stream']='';
		$data['department']='';
		$data['sem1']='';
		$data['fees']='';
		
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		$fees=$this->db->where('year',$year)->get('exam_condanation_fees')->row();
		$data['fees']=$fees->fine_amt;
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/condonationPaid',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function markCondPaid()
	{
		$add_date=date('Y-m-d H:i:s');
		$stream = $this->input->post('stream');
		$department = $this->input->post('department');
		$batch = $this->input->post('batch');
		$sem = $this->input->post('sem');
		$student = $this->input->post('student');
		$subject = $this->input->post('subject');
		$subcode = $this->input->post('subcode');
		$fees = $this->input->post('fees');
		$chellan = $this->input->post('chellan');
		$paid_date = date('Y-m-d',strtotime($this->input->post('paid_date')));
		if($subject==''){$subject=array();}
		if($subcode==''){$subcode=array();}
		$subj=implode(',',$subject);
		$subj_cd=implode(',',$subcode);
		
		$stu = $this->db->where('id',$student)->get('erp_existing_students')->row();
		$year = date('Y') - $batch;
		if($sem==1 OR $sem==3 OR $sem==5){$year = $year + 1;}
		
		$data_in = array(
		'student_id' => $stu->student_id,
		'add_student_id' => $student,
		'register_id' => $stu->reg_no_,
		'student_name' => $stu->student_name_,
		'subject_id' => $subj,
		'subject_code' => $subj_cd,
		'semester' => $sem,
		'stream' => $stream,
		'department' => $department,
		'batch' => $batch,
		'year' => $year,
		'amount_total' => $fees,
		'paid_amount' => $fees,
		'paid_date' => $paid_date,
		'paid_response' => 'Chellan',
		'paid_status' => 1,
		'transaction_status' => 'Offline',
		'transaction_id' => $chellan,
		'date' => $add_date,
		'payment_mode' => 1,
		);
	      $get_stu=$this->db->where('batch',$batch)->where('add_student_id',$student)->where('semester',$sem)->get('condanation_fee_transaction')->row();
		if(isset($get_stu)){
		  if($get_stu->payment_mode==0){
			  $value = 0;
		  }
		  else{
			  $this->db->where('id',$get_stu->id)->update('condanation_fee_transaction',$data_in);
			  $value=1;
		  }
		}else{
			$this->db->insert('condanation_fee_transaction',$data_in);
			$value=1;
		}
		echo $value;
	}
	
	public function deleteCondPaid()
	{
		$id = $this->input->post('id');
		$this->db->where('id',$id)->delete('condanation_fee_transaction');
	}



public function foilSheet(){


	$data['user']=$user_id=$this->session->userdata('user')['user_id'];
	$add_date=date('Y-m-d H:i:s');
	
	$data['batch1']='';
	$data['subject1']='';
	$data['sem1']='';
	$data['stream']='';
	$data['department']='';
  $data['all_details'] = '';
  $data['exam_details'] = '';
  $data['dep_details'] = '';
	
	if(isset($_POST['submit'])){



		$data['batch1']=$batch = $this->input->post('batch');
		$data['subject1']=$subject = $this->input->post('subject');
		$data['sem1']=$sem = $this->input->post('sem');
		$data['stream']=$stream = $this->input->post('stream');
		$data['department']=$department = $this->input->post('department');
		$data['all_details'] = $this->db->select("*")->from("erp_subjectmaster")->join("department_details","erp_subjectmaster.department=department_details.dp_id")->where("erp_subjectmaster.id",$subject)->get()->result();
	
	if($sem == 1 ||$sem == 3 ||$sem == 5){

		$data['exam_details'] = 'November -'.(date("Y")-1);

	}else{

		$data['exam_details'] = 'May -'.date("Y");



	}
	
	$data['dep_details'] = $this->db->select("*")->from("department_details")->where("main_id",$stream)->where("cour_id",$department)->get()->result();
	
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
	->where('erp_existing_students.main_id',$stream)
	->where('erp_existing_students.cour_id',$department)
	->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
	->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
	->order_by('id','ASC')
	->get('erp_existing_students')

	->result();
	}
	
$this->load->view('template/coe/header');
	$this->load->view('template/coe/menubar');
	$this->load->view('template/coe/headerbar');
	$this->load->view('coe/foilsheet',$data);
	$this->load->view('template/coe/footer');	



}


public function arrearPaid()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$year=date('Y');
		
		$data['batch1']='';
		$data['stream']='';
		$data['department']='';
		$data['sem1']='';
		$data['applied_year1']='';
		$data['applied_sem1']='';
		$data['fees']='';
		
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['applied_year1']=$applied_year = $this->input->post('applied_year');
			$data['applied_sem1']=$applied_sem = $this->input->post('applied_sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		$fees=$this->db->where('year',$year)->get('exam_condanation_fees')->row();
		$data['fees']=$fees->fine_amt;
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/arrearPaid',$data);
    $this->load->view('template/coe/footer');
    }
	
	public function markArrPaid()
	{
		$add_date=date('Y-m-d H:i:s');
		$stream = $this->input->post('stream');
		$department = $this->input->post('department');
		$batch = $this->input->post('batch');
		$sem = $this->input->post('sem');
		$applied_year = $this->input->post('applied_year');
		$applied_sem = $this->input->post('applied_sem');
		$student = $this->input->post('student');
		$fees_cnt = $this->input->post('fees_cnt');
		$subject = $this->input->post('subject');
		$subcode = $this->input->post('subcode');
		/*$stream = 1;
		$department = 6;
		$batch = 2021;
		$sem = 2;
		$applied_year = 2023;
		$applied_sem = 2;
		$student = 111;
		$fees_cnt = 1;
		$subject = array('50');
		$subcode = array('ddd');*/
		//$fees = $this->input->post('fees');
		$chellan = $this->input->post('chellan');
		$paid_date = date('Y-m-d',strtotime($this->input->post('paid_date')));
		if($subject==''){$subject=array();}
		if($subcode==''){$subcode=array();}
		$subj=implode(',',$subject);
		//$subj_cd=implode(',',$subcode);
		if($chellan==''){$chellan='';}
		if($paid_date==''){$paid_date=date('Y-m-d');}
		
		$stu = $this->db->where('id',$student)->get('erp_existing_students')->row();
		$stu1 = $this->db->where('as_student_id',$stu->student_id)->get('admitted_student')->row();
		$stu_id = '';$stu_ad_id = '';
		if(isset($stu1)){$stu_id = $stu1->as_student_id;$stu_ad_id = $stu1->as_id;}
		$dept = $this->db->where('main_id',$stream)->where('cour_id',$department)->get('department_details')->row();
		$year = date('Y') - $batch;
		if($sem==1 OR $sem==3 OR $sem==5){$year = $year + 1;}
		
		$get_stu1=$this->db->where('ef_batch',$batch)->where('ef_stu_ad_id',$stu1->ad)->get('erp_exam_fees_master')->row();
	$particular = 0;	
	if(isset($get_stu1)){$particular = $get_stu1->fees_particulars_id;}
		
		
		$data_in1 = array(
		'ef_stu_ad_id' => $stu_ad_id,
		'ef_stu_id' => $stu_id,
		'ef_batch' => $batch,
		'ef_main' => $stream,
		'ef_course' => $department,
		//'ef_main_exam' => $subcode[$i],
		//'ef_exam_fees' => $subcode[$i],
		'ef_arr_exam' => $subj,
		'ef_paid_date' => $paid_date . ' 00:00:00',
		'paid_through' => 2,
		'ef_paid_status' => 1,
		'ef_paid_response' => $chellan,
		'ef_department' => $dept->comp_name,
		'ef_created_date' => $add_date,
		);
		
	      if(!isset($get_stu1)){
			$this->db->insert('erp_exam_fees_master',$data_in1);
			$particular = $this->db->insert_id();
		  }
		  
		$i=0;
		foreach($subject as $subject){
		$data_in = array(
		'fees_particulars_id' => $particular,
		'student_batch' => $batch,
		'student_id' => $student,
		'reg_no' => $stu->reg_no_,
		'ref_no' => $stu1->as_shotlist_ref_number,
		'subject_id' => $subject,
		'subject_code' => $subcode[$i],
		'sem' => $sem,
		'main_id' => $stream,
		'course_id' => $department,
		'sem' => $sem,
		'applied_year' => $applied_year,
		'applied_sem' => $applied_sem,
		'created_at' => $add_date,
		);
		
		$get_stu[$i]=$this->db->where('student_batch',$batch)->where('applied_year',$applied_year)->where('applied_sem',$applied_sem)->where('student_id',$student->id)->where('subject_id',$subject)->where('sem',$sem)->get('erp_arrear_detail')->row();
	      if(!isset($get_stu[$i])){
			$this->db->insert('erp_arrear_detail',$data_in);
		  }else{
			$this->db->where('id',$get_stu[$i]->id);
			$this->db->update('erp_arrear_detail',$data_in);
		  }
			$value=1;
			$i++;
		}
		  
		echo $value;
	}
	
	public function deleteArrPaid()
	{
		$id = $this->input->post('student_id');
		$applied_year = $this->input->post('applied_year');
		$applied_sem = $this->input->post('applied_sem');
		$this->db->where('student_id',$id)->where('applied_year',$applied_year)->where('applied_sem',$applied_sem)->delete('erp_arrear_detail');
	}
	
	
	public function arrearStudents()
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
			$data['cnt'] = $cnt=0;
			if($stream == 5){$data['cnt'] = $cnt=3;}else{$data['cnt'] = $cnt=2;}
			$year = array($batch);
			$sem_cnt = array();
			for($i=1;$i<$cnt;$i++){
				array_push($year,$batch+$i);
			}
			for($ii=0;$ii<($cnt*2);$ii++){
				array_push($sem_cnt,$ii+1);
			}
			$data['yr_count']=$year;
			$data['sem_cnt']=$sem_cnt;
			
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/arrearStudents',$data);
    $this->load->view('template/coe/footer');	
	}
	
	
	public function arrearFeesPaid()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['applied_year1']='';
		//$data['applied_sem1']='';
		$data['batch1']='';
		$data['subject1']='';
		$data['sem1']='';
		$data['stream']='';
		$data['department']='';
		
		if(isset($_POST['submit'])){
			$data['applied_year1']=$applied_year = $this->input->post('applied_year');
		    //$data['applied_sem1']=$applied_sem = $this->input->post('applied_sem');
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
		$data['stu_list'] = $this->db->select('ef.*,es.student_name_,es.reg_no_,es.id as stuid')
		->join('erp_existing_students es','es.student_id=ef.ef_stu_id')
		->where('ef.ef_main',$stream)
		->where('ef.ef_course',$department)
		->where('ef.ef_batch', $batch)
		->where('ef.ef_paid_status', 1)
		->where('FIND_IN_SET('.$subject.',ef.ef_arr_exam) > 0')
		->where('ef.ef_stu_id!=0 AND ef.ef_stu_id!=1')
		->get('erp_exam_fees_master ef')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/arrearFeesPaid',$data);
    $this->load->view('template/coe/footer');	
	}
	
	
	public function SaveMarkResultArrear()
	{



/* 		$studid=[];
		$student_name_=[];
	 $register_number=[];
	 $ica_mark=[];
	 $ese_mark=[];
	 $tolal=[];
	 $result=[]; */

 	$p_studid=$this->input->post('studid');
 	$p_sstudent_name_=$this->input->post('student_name_');
	$p_sregister_number=$this->input->post('register_number');
	$p_sica_mark=$this->input->post('ica_mark');
	$p_sese_mark=$this->input->post('ese_mark');
	$p_stolal=$this->input->post('tolal');
	$p_sresult=$this->input->post('result');
/* 	$studid=implode(',',$p_studid);
	$student_name_=implode(',',$p_sstudent_name_);
 $register_number=implode(',',$p_sregister_number);
 $ica_mark=implode(',',$p_sica_mark);
 $ese_mark=implode(',',$p_sese_mark);
 $tolal=implode(',',$p_stolal);
 $result=implode(',',$p_sresult); */

	$main_id=$this->input->post('main_id');
	$course_id=$this->input->post('course_id');
	$subject_id=$this->input->post('subject_id');
	$batch=$this->input->post('batch');
	$sem=$this->input->post('sem');
	$arrear_applied_year=$this->input->post('applied_year');
	$user_id=$this->session->userdata('user')['user_id'];
	$add_date=date('Y-m-d H:i:s');
/* print_r($_POST);
	exit;  */
	for($i=0; $i<sizeof($p_studid); $i++){
		$data = array();
		
		
		
		$det = $this->db->where('batch',$batch)->where('semester',$sem)->where('stud_admit_id',$p_studid[$i])->where('arrear_status',1)->where('arrear_applied_year',$arrear_applied_year)->where('subject_id',$subject_id)->get('student_gally_report')->num_rows();
	 
		
		if($det==0){	
	$data['stud_admit_id']=$p_studid[$i]; 
	$data['stud_reg_number']=$p_sregister_number[$i]; 
	$data['batch']=$batch; 
	$data['semester']=$sem;
	$data['stream_id']=$main_id;
	$data['course_id']=$course_id;
	$data['subject_id']=$subject_id;
	$data['student_name']=$p_sstudent_name_[$i];
	$data['ici_mark']=$p_sica_mark[$i];
	$data['ese_mark']=$p_sese_mark[$i];
	$data['total_mark']=$p_stolal[$i];
	$data['result']=$p_sresult[$i];
	$data['arrear_status']=1;
	$data['arrear_applied_year']=$arrear_applied_year;
	$this->db->insert('student_gally_report',$data);
	 }else{	 
		$data['stud_admit_id']=$p_studid[$i]; 
		$data['stud_reg_number']=$p_sregister_number[$i]; 
		$data['batch']=$batch; 
		$data['semester']=$sem;
		$data['stream_id']=$main_id;
		$data['course_id']=$course_id;
		$data['subject_id']=$subject_id;
		$data['student_name']=$p_sstudent_name_[$i];
		$data['ici_mark']=$p_sica_mark[$i];
		$data['ese_mark']=$p_sese_mark[$i];
		$data['total_mark']=$p_stolal[$i];
		$data['result']=$p_sresult[$i];
		$data['arrear_status']=1;
	    $data['arrear_applied_year']=$arrear_applied_year;

	 $this->db->where('batch',$batch);		
	 $this->db->where('semester',$sem);		
	 $this->db->where('stud_admit_id',$studid[$i]);		
	 $this->db->where('subject_id',$subject_id);		
	$this->db->update('student_gally_report',$data);

	 }
	 //print_r($data);
	}
	echo 'Success'; 


    }
	
	public function manualMarkEntry()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['sem1']='';
		$data['stream']='';
		$data['department']='';
		$data['year1']='';
		$data['exam_type']='';
		$data['applied_sem1']='';
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
			$data['year1']=$written_year = $this->input->post('written_year');
			$data['exam_type']=$exam_type = $this->input->post('exam_type');
			$data['applied_sem1']=$applied_sem = $this->input->post('applied_sem');
		
        $data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();		
		}
		$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/manualMarkEntry',$data);
    $this->load->view('template/coe/footer');	
	}
	
	public function saveManualMark()
	{
	$student=$this->input->post('student');
	$ica=$this->input->post('ica');
	$ese=$this->input->post('ese');
	$total=$this->input->post('total');
	$result=$this->input->post('result');
	$main_id=$this->input->post('main_id');
	$course_id=$this->input->post('course_id');
	$subject_id=$this->input->post('subject_id');
	$batch=$this->input->post('batch');
	$sem=$this->input->post('sem');
	$written_year=$this->input->post('written_year');
	$applied_sem=$this->input->post('applied_sem');
	$exam_type=$this->input->post('exam_type');
	$user_id=$this->session->userdata('user')['user_id'];
	$add_date=date('Y-m-d H:i:s');
	
	for($i=0; $i<sizeof($student); $i++){
		$data = array();
		$det = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$student[$i])->where('subject_id',$subject_id)->get('erp_exammarkfinal')->row();
		$get_subj = $this->db->where('id',$subject)->get('erp_subjectmaster')->row();
		$get_stu = $this->db->where('id',$student[$i])->get('erp_existing_students')->row();
	$data['batch_year']=$batch; 
	$data['sem']=$sem; 
	$data['subject_id']=$subject_id; 
	$data['student_id']=$student[$i];
	$data['ica']=$ica[$i];
	$data['average']=$total[$i];
	$data['result']=$result[$i];
	$data['written_year']=$written_year;
	$data['main_id']=$main_id;
	$data['course_id']=$course_id;
	$data['manual_entry']=1;
	$data['user_id']=$user_id;
	$data['created_at']=$add_date;
	
	if($get_subj->subNature=="PRACTICAL" && $get_subj->msw_m_25==1){
		$data['internal'] = $ese[$i];
		}
	elseif($get_subj->subNature=="PRACTICAL" && $get_subj->msw_m_25==0){
		$data['internal'] = ($ese[$i]*2)/2;
		$data['external'] = ($ese[$i]*2)/2;
		}
	else{
		$data['internal'] = ($ese[$i]*4)/2;
		$data['external'] = ($ese[$i]*4)/2;
		}	
	
	 if(!isset($det)){	
	$this->db->insert('erp_exammarkfinal',$data);
	 }else{	 
	 $this->db->where('id',$det->id);		
	$this->db->update('erp_exammarkfinal',$data);
	 }
	
	$det1 = $this->db->where('batch',$batch)->where('semester',$sem)->where('stud_admit_id',$student[$i])->where('subject_id',$subject_id)->get('student_gally_report')->num_rows();
	 
		
		if($det1==0){	
	$data1['stud_admit_id']=$student[$i]; 
	$data1['stud_reg_number']=$get_stu->reg_no_; 
	$data1['batch']=$batch; 
	$data1['semester']=$sem;
	$data1['stream_id']=$main_id;
	$data1['course_id']=$course_id;
	$data1['subject_id']=$subject_id;
	$data1['student_name']=$get_stu->student_name_;
	$data1['ici_mark']=$ica[$i];
	$data1['ese_mark']=$ese[$i];
	$data1['total_mark']=$total[$i];
	$data1['result']=$result[$i];
	$data1['written_year']=$written_year;
	$this->db->insert('student_gally_report',$data1);
	 }else{	 
		$data1['stud_admit_id']=$student[$i]; 
		$data1['stud_reg_number']=$get_stu->reg_no_; 
		$data1['batch']=$batch; 
		$data1['semester']=$sem;
		$data1['stream_id']=$main_id;
		$data1['course_id']=$course_id;
		$data1['subject_id']=$subject_id;
		$data1['student_name']=$get_stu->student_name_;
		$data1['ici_mark']=$ica[$i];
		$data1['ese_mark']=$ese[$i];
		$data1['total_mark']=$total[$i];
		$data1['result']=$result[$i];
	$data1['written_year']=$written_year;

	 $this->db->where('batch',$batch);		
	 $this->db->where('semester',$sem);		
	 $this->db->where('stud_admit_id',$student[$i]);		
	 $this->db->where('subject_id',$subject);		
	$this->db->update('student_gally_report',$data1);

	 }
	}
	 
	echo 'Success';
    }  
	
	
	public function manualMarkEntryArrear()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['sem1']='';
		$data['stream']='';
		$data['department']='';
		$data['year1']='';
		$data['applied_sem1']='';
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
			$data['year1']=$written_year = $this->input->post('written_year');
			$data['applied_sem1']=$applied_sem = $this->input->post('applied_sem');
		
        $data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();		
		}
		$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/manualMarkEntryArrear',$data);
    $this->load->view('template/coe/footer');	
	}
	
	public function saveManualMarkArr()
	{
	$student=$this->input->post('student');
	$ica=$this->input->post('ica');
	$ese=$this->input->post('ese');
	$total=$this->input->post('total');
	$result=$this->input->post('result');
	$main_id=$this->input->post('main_id');
	$course_id=$this->input->post('course_id');
	$subject_id=$this->input->post('subject_id');
	$batch=$this->input->post('batch');
	$sem=$this->input->post('sem');
	$written_year=$this->input->post('written_year');
	$applied_sem=$this->input->post('applied_sem');
	$user_id=$this->session->userdata('user')['user_id'];
	$add_date=date('Y-m-d H:i:s');
	
	for($i=0; $i<sizeof($student); $i++){
		$data = array();
		$det = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$student[$i])->where('subject_id',$subject_id)->get('erp_exammarkfinal')->row();
		$get_subj = $this->db->where('id',$subject)->get('erp_subjectmaster')->row();
		$get_stu = $this->db->where('id',$student[$i])->get('erp_existing_students')->row();
	$data['batch_year']=$batch; 
	$data['sem']=$sem; 
	$data['subject_id']=$subject_id; 
	$data['student_id']=$student[$i];
	$data['ica']=$ica[$i];
	$data['average']=$total[$i];
	$data['result']=$result[$i];
	$data['written_year']=$written_year;
	$data['main_id']=$main_id;
	$data['course_id']=$course_id;
	$data['manual_entry']=1;
	$data['user_id']=$user_id;
	$data['created_at']=$add_date;
	
	if($get_subj->subNature=="PRACTICAL" && $get_subj->msw_m_25==1){
		$data['internal'] = $ese[$i];
		}
	elseif($get_subj->subNature=="PRACTICAL" && $get_subj->msw_m_25==0){
		$data['internal'] = ($ese[$i]*2)/2;
		$data['external'] = ($ese[$i]*2)/2;
		}
	else{
		$data['internal'] = ($ese[$i]*4)/2;
		$data['external'] = ($ese[$i]*4)/2;
		}	
	//if($exam_type == 'Arrear'){
		if($sem==2 OR $sem==3){$written_year1 = $batch+1;}
		  elseif($sem==4 OR $sem==5){$written_year1 = $batch+2;}
		  elseif($sem==6){$written_year1 = $batch+3;}
		  else{$written_year1 = $batch;}
		$data['arrear_status']=1;
	    $data['written_year']=$written_year1;
	    $data['arrear_applied_year']=$written_year;
	    $data['arrear_applied_sem']=$applied_sem;
	//}
	 if(!isset($det)){	
	$this->db->insert('erp_exammarkfinal',$data);
	 }else{	 
	 $this->db->where('id',$det->id);		
	$this->db->update('erp_exammarkfinal',$data);
	 }
	
	$det1 = $this->db->where('batch',$batch)->where('semester',$sem)->where('stud_admit_id',$student[$i])->where('subject_id',$subject_id)->get('student_gally_report')->num_rows();
	 
		
		if($det1==0){	
	$data1['stud_admit_id']=$student[$i]; 
	$data1['stud_reg_number']=$get_stu->reg_no_; 
	$data1['batch']=$batch; 
	$data1['semester']=$sem;
	$data1['stream_id']=$main_id;
	$data1['course_id']=$course_id;
	$data1['subject_id']=$subject_id;
	$data1['student_name']=$get_stu->student_name_;
	$data1['ici_mark']=$ica[$i];
	$data1['ese_mark']=$ese[$i];
	$data1['total_mark']=$total[$i];
	$data1['result']=$result[$i];
	$data1['written_year']=$written_year;
	$this->db->insert('student_gally_report',$data1);
	 }else{	 
		$data1['stud_admit_id']=$student[$i]; 
		$data1['stud_reg_number']=$get_stu->reg_no_; 
		$data1['batch']=$batch; 
		$data1['semester']=$sem;
		$data1['stream_id']=$main_id;
		$data1['course_id']=$course_id;
		$data1['subject_id']=$subject_id;
		$data1['student_name']=$get_stu->student_name_;
		$data1['ici_mark']=$ica[$i];
		$data1['ese_mark']=$ese[$i];
		$data1['total_mark']=$total[$i];
		$data1['result']=$result[$i];
	$data1['written_year']=$written_year;

	 $this->db->where('batch',$batch);		
	 $this->db->where('semester',$sem);		
	 $this->db->where('stud_admit_id',$student[$i]);		
	 $this->db->where('subject_id',$subject);		
	$this->db->update('student_gally_report',$data1);

	 }
	}
	 
	echo 'Success';
    }  
	
	
	public function downloadMarksheetBulk()
	{
		$this->load->library('zip');
		$sem=$this->input->post('sem');
		$batch=$this->input->post('batch');
		$stream=$this->input->post('stream');
		$department=$this->input->post('department');
		$type=$this->input->post('type');
		
		array_map('unlink', array_filter(
            (array) array_merge(glob(FCPATH . '/uploads/marksheet/*'))));
		
		$stu_list = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();	
		
		foreach($stu_list as $stu){
		$id = $stu->id;
		$data['stu_list'] = $this->db->query('select em.*,es.*,esm.* from erp_exammarkfinal em join erp_existing_students es on em.student_id=es.id join erp_subjectmaster esm on em.subject_id=esm.id left join erp_langallot l on (l.existing_student_id='.$id.' and l.batch='.$batch.' and l.sem='.$sem.' and l.subject_id=esm.id and l.status=1) left join erp_student_elective_subject e on (e.e_admit_stu_id='.$id.' and e.e_batch='.$batch.' and e.e_sem='.$sem.' and e.e_subject=esm.id) where em.student_id='.$id.' and em.sem='.$sem.' and em.batch_year='.$batch.' and (((esm.part=1 OR esm.part=4) AND l.subject_id is not null) or (esm.part!=1 AND esm.part!=4 AND l.subject_id is null)) and ((esm.subCatg="Elective" AND e.e_subject is not null) or (esm.subCatg!="Elective" AND e.e_subject is null)) order by (SUBSTRING_INDEX(esm.subCode, "/",-1)) asc ')->result();
		ob_start();
		if($type=='Finalmarksheet'){
		$html = $this->load->view("coe/finalMarksheetPDFBulk", $data, true);
		}else{
		$html = $this->load->view("coe/draftMarksheetPDFBulk", $data, true);	
		}
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
            $dompdf->setPaper("A4", "portrait");
            $dompdf->render();
            $output = $dompdf->output();
			$url = FCPATH . '/uploads/marksheet/FinalMarksheet_'.$id.'.pdf';
			file_put_contents($url,$output);ob_end_clean();
			//$this->load->view('coe/finalMarksheetPDFBulk',$data);
        $filepath.$id = FCPATH.'/uploads/marksheet/FinalMarksheet_'.$id.'.pdf';
        $this->zip->read_file($filepath.$id);
		}

        // Download
        $filename = "Marksheet.zip";
        $this->zip->download($filename);

	}
	function ConverToRoman($num){ 
    $n = intval($num); 
    $res = ''; 

    //array of roman numbers
    $romanNumber_Array = array( 
        'M'  => 1000, 
        'CM' => 900, 
        'D'  => 500, 
        'CD' => 400, 
        'C'  => 100, 
        'XC' => 90, 
        'L'  => 50, 
        'XL' => 40, 
        'X'  => 10, 
        'IX' => 9, 
        'V'  => 5, 
        'IV' => 4, 
        'I'  => 1); 

    foreach ($romanNumber_Array as $roman => $number){ 
        //divide to get  matches
        $matches = intval($n / $number); 

        //assign the roman char * $matches
        $res .= str_repeat($roman, $matches); 

        //substract from the number
        $n = $n % $number; 
    } 

    // return the result
    return $res; 
}

public function examSchedulePDF()
	{
		$this->load->library("pdf");
		$data['batch']=$batch = $this->input->post('batch');
			$data['sem']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
		$data['regular_list'] = $this->db->select('e.schedule_date,e.section,s.*')
		->join('erp_subjectmaster s','s.id=e.subject_id')
		->where('e.main_id',$stream)
		->where('e.course_id',$department)
		->where('e.batch_year',$batch)
		->where('e.sem',$sem)
		//->where('s.subNature!="PRACTICAL"')
		->order_by('(SUBSTRING_INDEX(s.subCode, "/",-1)) asc')
		->get('erp_exam_schedule e')->result();
		
		$data['arrear_list'] = $stu_list = $this->db->select('es.schedule_date,es.section,s.*')
		->join('erp_subjectmaster s','s.id=e.subject_id')
		->join('erp_exam_schedule es','s.id=es.subject_id','left')
		->join('erp_arrear_detail a','a.subject_id=s.id')
		->where('e.main_id',$stream)
		->where('e.course_id',$department)
		->where('e.batch_year',$batch)
		->where('e.result!="P"')
		->where('s.subNature!="PRACTICAL"')
		->where('a.student_batch',$batch)
		->where('a.applied_sem',$sem)
		->where('DATE_FORMAT(a.created_at,"%Y")',date('Y'))
		->group_by('e.subject_id')
		->order_by('(SUBSTRING_INDEX(s.subCode, "/",-1)) asc')
		->get('erp_exammarkfinal e')->result();	
		
		$dept=$this->db->where('main_id',$stream)->where('cour_id',$department)->get('department_details')->row();
		
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$date=date('Y-m-d');
		
		
			if($sem==1 || $sem==3 || $sem==5){
				$month = 'November';
			}else{
				$month = 'April';
			}
		
		ob_start();
            $html = $this->load->view("coe/examSchedulePDF", $data, true);
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
            $dompdf->setPaper("A4", "portrait");
            $dompdf->render();
            ob_end_clean();
            $dompdf->stream("ESETIMETABLE_".$dept->short_name." ".$batch.".pdf", ["Attachment" => 1]);
		
    //$this->load->view('coe/examSchedulePDF',$data);
	}
	
	public function arrearStudentsConsolidated()
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
			
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/arrearStudentsConsolidated',$data);
    $this->load->view('template/coe/footer');	
	}
	
	public function certificateCourse()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['batch_list']=$this->db->get('erp_batchmaster')->result();
		
		$data['sub_list']=$this->db->get('erp_certificate_course')->result();
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/certificateCourse',$data);
    $this->load->view('template/coe/footer');	
	}
	public function addCertificateCourse()
	{
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['sub_list']=$this->db->get('erp_certificate_course')->result();
		$config = array(
        array(
                'field' => 'subCode',
                'label' => 'Subject Code',
                //'rules' => 'required|is_unique[erp_certificate_course.subCode]',
                'rules' => 'required',
				'errors' => array(
                        'required' => 'You must provide a %s.',
						//'is_unique' => 'This %s already exists.'
						),
        ),
		array('field' => 'subName','label' => 'Subject Name','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'part','label' => 'Part Type','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'stream','label' => 'Stream','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'department','label' => 'Department','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		);
		if(isset($_POST['submit'])){
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) { 
         $data['form_err']=$this->session->set_flashdata('form_err','Please check all the details','warning'); 
         } 
         else {
		 $data_add = array(
		  'subCode' => $this->input->post('subCode'),
		  'subName' => $this->input->post('subName'),
		  'subCatg' => $this->input->post('subCatg'),
		  'part' => $this->input->post('part'),
		  'stream' => $this->input->post('stream'),
		  'department' => $this->input->post('department'),
		  'user_id' => $user_id,
		  'add_date' => $add_date,
		 );
		  
		$insert = $this->db->insert('erp_certificate_course',$data_add);
		$data['msg']=$this->session->set_flashdata('success','Added Successfully','success'); 
		redirect('coe/certificateCourse','refresh');
		}
		 }		
		
    $this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/add_certificateCourse',$data);
    $this->load->view('template/coe/footer');
    }
	public function editCertificateCourse()
	{
		$edit_id = $this->uri->segment(3);
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['sub_list']=$this->db->where('id',$edit_id)->get('erp_certificate_course')->row();
		$config = array(
        array(
                'field' => 'subCode',
                'label' => 'Subject Code',
                'rules' => 'required',
				'errors' => array(
                        'required' => 'You must provide a %s.',
						),
        ),
		array('field' => 'subName','label' => 'Subject Name','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'part','label' => 'Part Type','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'stream','label' => 'Stream','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		array('field' => 'department','label' => 'Department','rules' => 'required','errors' => array('required' => 'You must provide a %s.',)),
		);
		if(isset($_POST['submit'])){
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) { 
         $data['form_err']=$this->session->set_flashdata('form_err','Please check all the details','warning'); 
         } 
         else { 
		 $edit_id = $this->input->post('edit_id');
		 $data_up = array(
		  'subCode' => $this->input->post('subCode'),
		  'subName' => $this->input->post('subName'),
		  'subCatg' => $this->input->post('subCatg'),
		  'part' => $this->input->post('part'),
		  'stream' => $this->input->post('stream'),
		  'department' => $this->input->post('department'),
		 );
		  $this->db->where('id',$edit_id);
		$update = $this->db->update('erp_certificate_course',$data_up);
		$data['msg']=$this->session->set_flashdata('success','Updated Successfully','success'); 
		redirect('coe/certificateCourse','refresh');
		}
		 }		
		
    $this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/edit_certificateCourse',$data);
    $this->load->view('template/coe/footer');
    }
	public function deleteCertificateCourse()
	{
		$edit_id = $this->uri->segment(3);
		$delete = $this->db->where('id',$edit_id)->delete('erp_certificate_course');
		$data['msg']=$this->session->set_flashdata('success','Deleted Successfully','success'); 
		redirect('coe/certificateCourse','refresh');
	}
	
	public function certificateCourseMarks()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['stream']='';
		$data['department']='';
		
		$data['subject'] = $this->db->select('c.id,c.subName')->get('erp_certificate_course c')->result();	
		
		if(isset($_POST['submit'])){

			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department'); 
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		//->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->join('erp_student_cert_course','erp_student_cert_course.c_admit_stu_id=erp_existing_students.id')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
		
	}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/certificateCourseMarks',$data);
    $this->load->view('template/coe/footer');	
	}
	public function getCertCourse()
	{
	$user_id=$this->session->userdata('user')['user_id'];
	$batch=$this->input->post('batch');
	$stream=$this->input->post('stream');
	$department=$this->input->post('department');
	$sub = $this->db->select('c.id,c.subName')->where('c.batch_year',$batch)->where('c.department',$department)->where('c.stream',$stream)->get('erp_certificate_course c')->result();	
    $subject = '<option value="">Select Subject</option>';
	foreach($sub as $sub){
		$subject .= '<option value="'.$sub->id.'">'.$sub->subName.'</option>';
	}
	echo $subject; 
	}
	public function certificateCourseReport()
	{
	$cc=$this->input->post('cc');
	$main_id=$this->input->post('main_id');
	$course_id=$this->input->post('course_id');
	$subject_id=$this->input->post('subject_id');
	$cc_not=$this->input->post('cc_not');
	$batch=$this->input->post('batch');
	$user_id=$this->session->userdata('user')['user_id'];
	$add_date=date('Y-m-d H:i:s');
	
	for($i=0; $i<sizeof($cc); $i++){
		$data = array();
		$det = $this->db->where('batch',$batch)->where('student_id',$cc[$i])->where('subject_id',$subject_id)->get('erp_cert_coursemark')->row();
		$stu_id = $this->db->where('id',$cc[$i])->get('erp_existing_students')->row();
	 if(!isset($det)){	
	$data['batch']=$batch;  
	$data['subject_id']=$subject_id;
	$data['student_id']=$cc[$i];
	$data['status']=1;
	$data['main_id']=$stu_id->main_id;
	$data['course_id']=$stu_id->cour_id;
	$data['user_id']=$user_id;
	$data['created_at']=$add_date;
	$this->db->insert('erp_cert_coursemark',$data);
	 }else{	 
	$data['status']=1;	
	 $this->db->where('id',$det->id);	
	$this->db->update('erp_cert_coursemark',$data);
	 }
	}
	
	for($ii=0; $ii<sizeof($cc_not); $ii++){
		$data1 = array();
		$delete = $this->db->where('batch',$batch)->where('student_id',$cc_not[$ii])->where('subject_id',$subject_id)->get('erp_cert_coursemark')->row();
	 if(isset($delete)){	
	 $data1['status']=0;
	$this->db->where('id',$delete->id);	
	$this->db->update('erp_cert_coursemark',$data1);
	 }else{
	  $data1['batch']=$batch; 
	$data1['subject_id']=$subject_id;
	$data1['student_id']=$cc_not[$ii];
	$data1['status']=0;
	$data1['main_id']=$stu_id->main_id;
	$data1['course_id']=$stu_id->cour_id;
	$data1['user_id']=$user_id;
	$data1['created_at']=$add_date;
	$this->db->insert('erp_cert_coursemark',$data1);	 
	 }
	}
	echo 'Success';
    }
	public function certificateCourseMarksReport()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['stream']='';
		$data['department']='';
		
		$data['subject'] = $this->db->select('c.id,c.subName')->get('erp_certificate_course c')->result();	
		
		if(isset($_POST['submit'])){
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department'); 
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		->join('erp_student_cert_course','erp_student_cert_course.c_admit_stu_id=erp_existing_students.id')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();
	}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/certificateCourseReport',$data);
    $this->load->view('template/coe/footer');	
	}
	
	public function getAllotedSubj(){
		$room = $this->input->post('room_id');
		$schedule_date = date('Y-m-d',strtotime($this->input->post('schedule_date')));
		$session = $this->input->post('session');
		$get_alloted = $this->db->select('r.no_of_students,s.subName,s.subCode')->join('erp_subjectmaster s','s.id=r.subject_id')->where('r.room_id',$room)->where('r.schedule_date',$schedule_date)->where('r.section',$session)->get('erp_room_allocation r')->result();
		$allot_det = array();
		foreach($get_alloted as $key => $value){
			$subj = $value->subCode;
			$subName = $value->subName;
			$stu = $value->no_of_students;
			$allot_det[$subj] = $allot_det[$subj] + $stu;
			$allot_sub[$subj] = $subName;
		}
		$alloted = '';
		foreach($allot_det as $allotdet => $value){
			$alloted .= '<span style="width:200px;font-weight:bold;color:red;margin-right:20px;">'.$allot_sub[$allotdet].' : '.$value.'</span>';
		}
			echo $alloted;
	}
	
	public function dataImport()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['subject1']='';
		$data['sem1']='';
		$data['stream']='';
		$data['department']='';
		$data['year1']='';
		$data['exam_type']='';
		$data['applied_sem1']='';
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['subject1']=$subject = $this->input->post('subject');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
			$data['year1']=$written_year = $this->input->post('written_year');
			$data['exam_type']=$exam_type = $this->input->post('exam_type');
			$data['applied_sem1']=$applied_sem = $this->input->post('applied_sem');
		
        $data['stu_list'] = $this->db->select('erp_existing_students.*')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->where('(erp_existing_students.left_status = 0 AND erp_existing_students.long_absent = 0)')
		->get('erp_existing_students')->result();		
		}
		$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/dataImport',$data);
    $this->load->view('template/coe/footer');	
	}
	
	public function saveDataImport()
	{
	$student=$this->input->post('student');
	$ica=$this->input->post('ica');
	$ese=$this->input->post('ese');
	$total=$this->input->post('total');
	$result=$this->input->post('result');
	$main_id=$this->input->post('main_id');
	$course_id=$this->input->post('course_id');
	$subject_id=$this->input->post('subject_id');
	$batch=$this->input->post('batch');
	$sem=$this->input->post('sem');
	$written_year=$this->input->post('written_year');
	$applied_sem=$this->input->post('applied_sem');
	$exam_type=$this->input->post('exam_type');
	$user_id=$this->session->userdata('user')['user_id'];
	$add_date=date('Y-m-d H:i:s');
	
	for($i=0; $i<sizeof($student); $i++){
		$data = array();
		$det = $this->db->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$student[$i])->where('subject_id',$subject_id)->get('erp_exammarkfinal')->row();
		$get_subj = $this->db->where('id',$subject)->get('erp_subjectmaster')->row();
		$get_stu = $this->db->where('id',$student[$i])->get('erp_existing_students')->row();
	$data['batch_year']=$batch; 
	$data['sem']=$sem; 
	$data['subject_id']=$subject_id; 
	$data['student_id']=$student[$i];
	$data['ica']=$ica[$i];
	$data['average']=$total[$i];
	$data['result']=$result[$i];
	$data['written_year']=$written_year;
	$data['main_id']=$main_id;
	$data['course_id']=$course_id;
	$data['manual_entry']=1;
	$data['user_id']=$user_id;
	$data['created_at']=$add_date;
	
	if($get_subj->subNature=="PRACTICAL" && $get_subj->msw_m_25==1){
		$data['internal'] = $ese[$i];
		}
	elseif($get_subj->subNature=="PRACTICAL" && $get_subj->msw_m_25==0){
		$data['internal'] = ($ese[$i]*2)/2;
		$data['external'] = ($ese[$i]*2)/2;
		}
	else{
		$data['internal'] = ($ese[$i]*4)/2;
		$data['external'] = ($ese[$i]*4)/2;
		}	
	
	 if(!isset($det)){	
	$this->db->insert('erp_exammarkfinal',$data);
	 }else{	 
	 $this->db->where('id',$det->id);		
	$this->db->update('erp_exammarkfinal',$data);
	 }
	
	$det1 = $this->db->where('batch',$batch)->where('semester',$sem)->where('stud_admit_id',$student[$i])->where('subject_id',$subject_id)->get('student_gally_report')->num_rows();
	 
		
		if($det1==0){	
	$data1['stud_admit_id']=$student[$i]; 
	$data1['stud_reg_number']=$get_stu->reg_no_; 
	$data1['batch']=$batch; 
	$data1['semester']=$sem;
	$data1['stream_id']=$main_id;
	$data1['course_id']=$course_id;
	$data1['subject_id']=$subject_id;
	$data1['student_name']=$get_stu->student_name_;
	$data1['ici_mark']=$ica[$i];
	$data1['ese_mark']=$ese[$i];
	$data1['total_mark']=$total[$i];
	$data1['result']=$result[$i];
	$data1['written_year']=$written_year;
	$this->db->insert('student_gally_report',$data1);
	 }else{	 
		$data1['stud_admit_id']=$student[$i]; 
		$data1['stud_reg_number']=$get_stu->reg_no_; 
		$data1['batch']=$batch; 
		$data1['semester']=$sem;
		$data1['stream_id']=$main_id;
		$data1['course_id']=$course_id;
		$data1['subject_id']=$subject_id;
		$data1['student_name']=$get_stu->student_name_;
		$data1['ici_mark']=$ica[$i];
		$data1['ese_mark']=$ese[$i];
		$data1['total_mark']=$total[$i];
		$data1['result']=$result[$i];
	$data1['written_year']=$written_year;

	 $this->db->where('batch',$batch);		
	 $this->db->where('semester',$sem);		
	 $this->db->where('stud_admit_id',$student[$i]);		
	 $this->db->where('subject_id',$subject);		
	$this->db->update('student_gally_report',$data1);

	 }
	}
	 
	echo 'Success';
    } 
	
	public function arrearAttendanceSheet()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$year=date('Y');
		
		$data['block1']='';
		$data['room1']='';
		
		if(isset($_POST['submit'])){
			$data['block1']=$block_id = $this->input->post('block_id');
			$data['room1']=$room_id = $this->input->post('room_id');
			$data['schedule_date1']=$schedule_date = $this->input->post('schedule_date');
			$data['alloted_seat']=$this->db->select('e.id as stu_id,e.reg_no_,e.student_name_,e.batch_,s.subName,r.room_name,ar.*')->join('erp_rooms r','r.id=ar.room_id')->join('erp_subjectmaster s','s.id=ar.subject_id')->join('erp_existing_students e','e.id=ar.student_id')->where('ar.applied_year',$year)->where('ar.schedule_date',$schedule_date)->where('ar.room_id',$room_id)->where('ar.student_id!="" and ar.student_id!="0"')->group_by('seat_no,student_id,subject_id')->order_by('ar.seat_no','asc')->get('erp_rows_cols_arrear ar')->result();
		}
		
	$this->load->view('template/coe/header');
    $this->load->view('template/coe/menubar');
    $this->load->view('template/coe/headerbar');
    $this->load->view('coe/arrearAttendanceSheet',$data);
    $this->load->view('template/coe/footer');
	
		}
		
		public function arrearAttendanceSheetPDF()
	{
		$this->load->library("pdf");
		$room_id = $data['room_id'] = $this->uri->segment(3);
		$schedule_date = $data['schedule_date'] = $this->uri->segment(4);
		$year = date('Y');
		$data['seat_list']=$seats=$this->db->select('e.id as stu_id,e.reg_no_,e.student_name_,e.batch_,s.subName,s.subCode,r.room_name,ar.*')->join('erp_rooms r','r.id=ar.room_id')->join('erp_subjectmaster s','s.id=ar.subject_id')->join('erp_existing_students e','e.id=ar.student_id')->where('ar.applied_year',$year)->where('ar.schedule_date',$schedule_date)->where('ar.room_id',$room_id)->where('ar.student_id!="" and ar.student_id!="0"')->group_by('seat_no,student_id,subject_id')->order_by('ar.seat_no','asc')->get('erp_rows_cols_arrear ar')->result();
		$block = $this->db->where('id',$seats[0]->block_id)->get('erp_blocks')->row();
		$sched = $this->db->where('subject_id',$seats[0]->subject_id)->where('date_format(created_at,"%Y")',$year)->get('erp_exam_schedule')->row();
		$data['room_name'] = $room_name = $seats[0]->room_name;
		$data['block_name'] = $block_name = $block->block_name;
		$data['subject_name'] = $subject_name = $seats->subName;
		$data['subject_code'] = $subject_code = $seats->subCode;
		$data['session'] = $session = $sched->section;
		
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$date=date('Y-m-d');
		
		
			if($sem==1 || $sem==3 || $sem==5){
				$month = 'November';
			}else{
				$month = 'April';
			}
		
		ob_start();
            $html = $this->load->view("coe/arrearAttendanceSheetPDF", $data, true);
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
            $dompdf->setPaper("A4", "portrait");
            $dompdf->render();
            ob_end_clean();
            $dompdf->stream("ATTENDANCESHEET_".$subject_code."_".$month." ".$batch.".pdf", ["Attachment" => 1]);
		
    //$this->load->view('coe/arrearAttendanceSheetPDF',$data);
	}
	
	
}
