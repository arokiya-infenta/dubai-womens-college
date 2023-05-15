<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
//require APPPATH . '/libraries/dompdf/autoload.inc.php';
require FCPATH . 'barcode/vendor/autoload.php';
require APPPATH . '/libraries/PDFlib.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
	use Dompdf\Dompdf;
	use Dompdf\Options;
class Subadmin extends CI_Controller {
	
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
    $this->load->view('template/subadmin/header');
    $this->load->view('template/subadmin/menubar');
    $this->load->view('template/subadmin/headerbar');
    $this->load->view('subadmin/dashbord');
    $this->load->view('template/subadmin/footer');
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
				 redirect('subadmin/updatePassword','refresh');
			 }else{
				 $data['mesg']=$this->session->set_flashdata('form_err','New Password and Confirm Password does not match!!','danger');
				 redirect('subadmin/updatePassword','refresh');
			 }
		 }else{
			$data['mesg']=$this->session->set_flashdata('form_err','Old Password does not match!!','danger'); 
			redirect('subadmin/updatePassword','refresh');
		 }
		}
    $this->load->view('template/subadmin/header');
    $this->load->view('template/subadmin/menubar');
    $this->load->view('template/subadmin/headerbar');
    $this->load->view('subadmin/update_password',$data);
    $this->load->view('template/subadmin/footer');
    }
	public function employeeList()
	{
		$data['emp_list']=$this->db->where('emp_working_status_','Working')->get('erp_employee_master')->result();
		
    $this->load->view('template/subadmin/header');
    $this->load->view('template/subadmin/menubar');
    $this->load->view('template/subadmin/headerbar');
    $this->load->view('subadmin/employeelist',$data);
    $this->load->view('template/subadmin/footer');
    }
public function do_upload(){

    	$config = array();
		$config['upload_path'] = './system/image/accounts/';
		$config['allowed_types'] = '*';
		$config['remove_spaces'] = TRUE;
		$config['overwrite'] = TRUE;
		return $config;
		
        }

public function empLoginStatus(){
	
$emp_id = $this->input->post('emp_id');
$status = $this->input->post('status');
if($status==1){
	$data['login_status_']=0;
}else{
	$data['login_status_']=1;
}
$this->db->where('id',$emp_id);
$this->db->update('erp_employee_master',$data);
  $login_status=$this->db->where('id',$emp_id)->get('erp_employee_master')->row();
echo $login_status->login_status_;
}
public function setEmpPassword(){
	
$emp_id = $this->input->post('emp_id');
$new_pwd = $this->input->post('new_pwd');
$conf_pwd = $this->input->post('conf_pwd');
	$data['password_']=$conf_pwd;
$this->db->where('id',$emp_id);
$this->db->update('erp_employee_master',$data);
  $set_pwd=$this->db->where('id',$emp_id)->get('erp_employee_master')->row();
echo $set_pwd->password_;
}

public function get_students(){
    $main_course_id = $this->input->post('main_course_id');
    $applied_course_id = $this->input->post('app_course_id');

    
	$get_stu=$this->db->where('main_course_id',$main_course_id)->where('applied_course_id',$applied_course_id)->get('Applyed_Cources')->result();
       $option = "<option value=''>Select an Option</option>";
       foreach ($get_stu as $students){
		$student   = $this->db->where('u_id',$students->user_id)->get('stu_user')->row();
           $option .= "<option value='".$student->u_id."'>".$student->u_name."</option>";             
       }
       echo $option;
}

public function employeeDeniedList()
	{
		$data['emp_list']=$this->db->where('emp_working_status_','Denied')->get('erp_employee_master')->result();
		
    $this->load->view('template/subadmin/header');
    $this->load->view('template/subadmin/menubar');
    $this->load->view('template/subadmin/headerbar');
    $this->load->view('subadmin/denied_employeelist',$data);
    $this->load->view('template/subadmin/footer');
    }
	public function do_upload_emp(){

    	$config = array();
		$config['upload_path'] = 'system/images/employee/';
		$config['allowed_types'] = '*';
		$config['remove_spaces'] = TRUE;
		$config['overwrite'] = TRUE;
		return $config;
		
        }
	public function addEmployee()
	{
		$add_date=date("Y-m-d H:i:s");
		$data['department']=$this->db->get('erp_department')->result();
		$data['dept_type']=$this->db->get('erp_dept_type')->result();
		$data['role']=$this->db->get('erp_role_master')->result();
		
	if(isset($_POST['submit'])){
	  $employee_id_=$this->input->post('emp_id');
	  $emp_name_=$this->input->post('emp_name');	
	  $emp_designation_=$this->input->post('role');	
	  $emp_dept_type_=$this->input->post('type');	
	  $emp_dept_name_=$this->input->post('department');	
	  $stream=$this->input->post('stream');	
	  $emp_college_type_=$this->input->post('department');	
	  //if($stream==1){$emp_college_type_='AIDED';}if($stream==2){$emp_college_type_='SELF FINANCE';}if($stream==3){$emp_college_type_='ADMISSION DEPARTMENT';}	
	  $empdob=str_replace('-','/',$this->input->post('dob'));	
	  $emp_dob_=date('Y-m-d',strtotime($empdob));
	  $emp_mobile_=$this->input->post('mobile');	
	  $emp_mail_=$this->input->post('email');	
	  $emp_gender_=$this->input->post('gender');	
	  $emp_maritalstatus_=$this->input->post('merital_status');	
	  $emp_bgroup_=$this->input->post('blood_group');	
	  $emp_nationality_=$this->input->post('nationality');	
	  $emp_city_=$this->input->post('city');	
	  $emp_state_=$this->input->post('state');	
	  $emp_country_=$this->input->post('country');	
	  $emp_document_=$this->input->post('identity_doc');	
	  $emp_accno_=$this->input->post('account_no');	
	  $emp_ifsc_=$this->input->post('ifsc_code');	
	  $emp_bankname_=$this->input->post('bank_name');	
	  $emp_pf_=$this->input->post('pf_account');
if($emp_pf_!=''){$emp_pf_=$emp_pf_;}else{$emp_pf_='';}	  
	  $emp_address_=$this->input->post('address');		
	  $empdoj=str_replace('-','/',$this->input->post('doj'));	
	  $emp_doj_=date('Y-m-d',strtotime($empdoj));
	  $emp_working_status_=$this->input->post('status');
		$data_in=array(
		'employee_id_' => $employee_id_,
		'emp_name_' => $emp_name_,
		'emp_designation_' => $emp_designation_,
		'emp_dept_type_' => $emp_dept_type_,
		'emp_dept_name_' => $emp_dept_name_,
		'emp_college_type_' => $stream,
		'emp_dob_' => $emp_dob_,
		'emp_mobile_' => $emp_mobile_,
		'emp_mail_' => $emp_mail_,
		'emp_gender_' => $emp_gender_,
		'emp_maritalstatus_' => $emp_maritalstatus_,
		'emp_bgroup_' => $emp_bgroup_,
		'emp_nationality_' => $emp_nationality_,
		'emp_city_' => $emp_city_,
		'emp_state_' => $emp_state_,
		'emp_country_' => $emp_country_,
		'emp_address_' => $emp_address_,
		'emp_doj_' => $emp_doj_,
		'emp_document_' => $emp_document_,
		'emp_bankname_' => $emp_bankname_,
		'emp_accno_' => $emp_accno_,
		'emp_ifsc_' => $emp_ifsc_,
		'emp_pf_' => $emp_pf_,
		'emp_working_status_' => $emp_working_status_,
		'created_at' => $add_date,
		);
		if($_FILES['perPhoto']['size'] != 0) {
			$file_ext = pathinfo($_FILES["perPhoto"]["name"], PATHINFO_EXTENSION);
			$NewImageName = $employee_id_.'.'.$file_ext;
			
			$_FILES["file"]["name"] = $NewImageName;
			$_FILES["file"]["type"] = $_FILES["perPhoto"]["type"];
			$_FILES["file"]["tmp_name"] = $_FILES["perPhoto"]["tmp_name"];
			$_FILES["file"]["error"] = $_FILES["perPhoto"]["error"];
			$_FILES["file"]["size"] = $_FILES["perPhoto"]["size"];

			$config = $this->do_upload_emp();
			$this->upload->initialize($config);
			if($this->upload->do_upload('file'))
			{
			 $ffff = $this->upload->data();
			  $image=$ffff['file_name'];
			  
			  $data_in['emp_profile_'] = 'system/images/employee/'.$NewImageName;
			  }
	 }
	 if($_FILES['document']['size'] != 0) {
			$file_ext = pathinfo($_FILES["document"]["name"], PATHINFO_EXTENSION);
			$NewImageDoc = 'DOC_'.$employee_id_.'.'.$file_ext;
			
			$_FILES["file"]["name"] = $NewImageDoc;
			$_FILES["file"]["type"] = $_FILES["document"]["type"];
			$_FILES["file"]["tmp_name"] = $_FILES["document"]["tmp_name"];
			$_FILES["file"]["error"] = $_FILES["document"]["error"];
			$_FILES["file"]["size"] = $_FILES["document"]["size"];

			$config = $this->do_upload_emp();
			$this->upload->initialize($config);
			if($this->upload->do_upload('file'))
			{
			 $ffff = $this->upload->data();
			  $image=$ffff['file_name'];
			  
			  $data_in['emp_doc_'] = 'system/images/employee/'.$NewImageDoc;
			  }
	 }
		$insert = $this->db->insert('erp_employee_master',$data_in);
		if($insert){
			$data['mesg']=$this->session->set_flashdata('success','Added Successfully!!');
			redirect('subadmin/employeeList','refresh');
		}
	}	
		
    $this->load->view('template/subadmin/header');
    $this->load->view('template/subadmin/menubar');
    $this->load->view('template/subadmin/headerbar');
    $this->load->view('subadmin/add_employee',$data);
    $this->load->view('template/subadmin/footer');
    }
	
	public function editEmployee()
	{
		$add_date=date("Y-m-d H:i:s");
		$id=$this->uri->segment(3);
		
		$data['department']=$this->db->get('erp_department')->result();
		$data['dept_type']=$this->db->get('erp_dept_type')->result();
		$data['role']=$this->db->get('erp_role_master')->result();
		$data['single_employee']=$this->db->where('id',$id)->get('erp_employee_master')->row();
		
	if(isset($_POST['submit'])){
	  $edit_id=	$this->input->post('edit_id');
	  $employee_id_=$this->input->post('emp_id');
	  $emp_name_=$this->input->post('emp_name');	
	  $emp_designation_=$this->input->post('role');	
	  $emp_dept_type_=$this->input->post('type');	
	  $emp_dept_name_=$this->input->post('department');	
	  $stream=$this->input->post('stream');	
	  //$emp_college_type_=$this->input->post('department');	
	  //if($stream==1){$emp_college_type_='AIDED';}if($stream==2){$emp_college_type_='SELF FINANCE';}if($stream==3){$emp_college_type_='ADMISSION DEPARTMENT';}	
	  $empdob=str_replace('-','/',$this->input->post('dob'));	
	  $emp_dob_=date('Y-m-d',strtotime($empdob));
	  $emp_mobile_=$this->input->post('mobile');	
	  $emp_mail_=$this->input->post('email');	
	  $emp_gender_=$this->input->post('gender');	
	  $emp_maritalstatus_=$this->input->post('merital_status');	
	  $emp_bgroup_=$this->input->post('blood_group');	
	  $emp_nationality_=$this->input->post('nationality');	
	  $emp_city_=$this->input->post('city');	
	  $emp_state_=$this->input->post('state');	
	  $emp_country_=$this->input->post('country');	
	  $emp_document_=$this->input->post('identity_doc');	
	  $emp_accno_=$this->input->post('account_no');	
	  $emp_ifsc_=$this->input->post('ifsc_code');	
	  $emp_bankname_=$this->input->post('bank_name');	
	  $emp_pf_=$this->input->post('pf_account');
if($emp_pf_!=''){$emp_pf_=$emp_pf_;}else{$emp_pf_='';}	  
	  $emp_address_=$this->input->post('address');		
	  $empdoj=str_replace('-','/',$this->input->post('doj'));	
	  $emp_doj_=date('Y-m-d',strtotime($empdoj));
	  $emp_working_status_=$this->input->post('status');
		$data_up=array(
		'employee_id_' => $employee_id_,
		'emp_name_' => $emp_name_,
		'emp_designation_' => $emp_designation_,
		'emp_dept_type_' => $emp_dept_type_,
		'emp_dept_name_' => $emp_dept_name_,
		'emp_college_type_' => $stream,
		'emp_dob_' => $emp_dob_,
		'emp_mobile_' => $emp_mobile_,
		'emp_mail_' => $emp_mail_,
		'emp_gender_' => $emp_gender_,
		'emp_maritalstatus_' => $emp_maritalstatus_,
		'emp_bgroup_' => $emp_bgroup_,
		'emp_nationality_' => $emp_nationality_,
		'emp_city_' => $emp_city_,
		'emp_state_' => $emp_state_,
		'emp_country_' => $emp_country_,
		'emp_address_' => $emp_address_,
		'emp_doj_' => $emp_doj_,
		'emp_document_' => $emp_document_,
		'emp_bankname_' => $emp_bankname_,
		'emp_accno_' => $emp_accno_,
		'emp_ifsc_' => $emp_ifsc_,
		'emp_pf_' => $emp_pf_,
		'emp_working_status_' => $emp_working_status_,
		);
		if($_FILES['perPhoto']['size'] != 0) {
			$file_ext = pathinfo($_FILES["perPhoto"]["name"], PATHINFO_EXTENSION);
			$NewImageName = $employee_id_.'.'.$file_ext;
			
			$_FILES["file"]["name"] = $NewImageName;
			$_FILES["file"]["type"] = $_FILES["perPhoto"]["type"];
			$_FILES["file"]["tmp_name"] = $_FILES["perPhoto"]["tmp_name"];
			$_FILES["file"]["error"] = $_FILES["perPhoto"]["error"];
			$_FILES["file"]["size"] = $_FILES["perPhoto"]["size"];

			$config = $this->do_upload_emp();
			$this->upload->initialize($config);
			if($this->upload->do_upload('file'))
			{
			 $ffff = $this->upload->data();
			  $image=$ffff['file_name'];
			  
			  $data_up['emp_profile_'] = 'system/images/employee/'.$NewImageName;
			  }
	 }
	 if($_FILES['document']['size'] != 0) {
			$file_ext = pathinfo($_FILES["document"]["name"], PATHINFO_EXTENSION);
			$NewImageDoc = 'DOC_'.$employee_id_.'.'.$file_ext;
			
			$_FILES["file"]["name"] = $NewImageDoc;
			$_FILES["file"]["type"] = $_FILES["document"]["type"];
			$_FILES["file"]["tmp_name"] = $_FILES["document"]["tmp_name"];
			$_FILES["file"]["error"] = $_FILES["document"]["error"];
			$_FILES["file"]["size"] = $_FILES["document"]["size"];

			$config = $this->do_upload_emp();
			$this->upload->initialize($config);
			if($this->upload->do_upload('file'))
			{
			 $ffff = $this->upload->data();
			  $image=$ffff['file_name'];
			  
			  $data_up['emp_doc_'] = 'system/images/employee/'.$NewImageDoc;
			  }
	 }
		$this->db->where('id',$edit_id);
		$update = $this->db->update('erp_employee_master',$data_up);
		if($update){
			$data['mesg']=$this->session->set_flashdata('success','Edited Successfully!!');
			redirect('subadmin/employeeList','refresh');
		}
	}	
		
    $this->load->view('template/subadmin/header');
    $this->load->view('template/subadmin/menubar');
    $this->load->view('template/subadmin/headerbar');
    $this->load->view('subadmin/edit_employee',$data);
    $this->load->view('template/subadmin/footer');
    }
	
	public function getPgrm()
	{
	$stream=$this->input->post('stream');
	if($stream==1){
    $progrm = $this->db->where('college_type_','Aided')->where('status',1)->get('erp_department')->result();	}
	else{
	$progrm = $this->db->where('college_type_','Self Finance')->where('status',1)->get('erp_department')->result();	
	}
	$program = '<option value="">Select Program</option>';
	foreach($progrm as $progrm){
		$program .= '<option value="'.$progrm->id.'">'.$progrm->dept_name_.'</option>';
	}
	echo $program;
    }
	
	public function IDGenerate()
	{
		$data['department']='';
		$data['program']='';
	if(isset($_POST['submit'])){
	  $department=$data['department']=$this->input->post('department');	
	  $program=$data['program']=$this->input->post('program');	
	   if($department==1){
       $data['programm'] = $this->db->where('college_type_','Aided')->get('erp_department')->result();	}
	   else{
	   $data['programm'] = $this->db->where('college_type_','Self Finance')->get('erp_department')->result();	
	   }
	  $dept = $this->db->where('id',$program)->get('erp_department')->row(); 
	  $data['stu_list']=$this->db->where('as_dep',$dept->dept_code_)->where('as_status',1)->get('admitted_student')->result();
	}
	$this->load->view('template/subadmin/header');
    $this->load->view('template/subadmin/menubar');
    $this->load->view('template/subadmin/headerbar');
    $this->load->view('subadmin/ID_generate',$data);
    $this->load->view('template/subadmin/footer');
    }
	public function upload_studentID()
	{
		//echo '<a class="rem_id_'.$id.'" href="http://localhost/mssw/erp/system/images/IDGenerate/sample.pdf" download><button class="down_id_'.$id.'"></button></a>';
$id=$this->input->post('id');
$data['stu_list']=$stu_list=$this->db->where('id',$id)->get('erp_studentdetails')->row();
$html_f = $this->load->view('subadmin/ID_front_pdf', $data, true);
$rand = rand();		
    $output_dir = FCPATH."system/images/GenerateID/"; 
	
$dompdf = new DOMPDF();
$dompdf->load_html($html_f);
$dompdf->render();
$output_f = $dompdf->output();
$filename_f = "front_student_".$rand.".pdf";
file_put_contents("".$output_dir.$filename_f."", $output_f);
$pdf_file_f   = $output_dir . $filename_f;
$save_file_f   = FCPATH.'/system/images/GenerateID/'.$rand.'-student_front_'.$id.'.png';
$op_path_f   = base_url().'/system/images/GenerateID/'.$rand.'-student_front_'.$id.'.png';
$cmd_f = '"C:\Program Files\ImageMagick-7.1.0-Q16\magick.exe" '.$pdf_file_f.' '.$save_file_f.' 2>&1';
$output_f = shell_exec($cmd_f);

$html_b = $this->load->view('subadmin/ID_back_pdf', $data, true);
$rand = rand();		
    $output_dir_b = FCPATH."system/images/GenerateID/"; 
	
$dompdf = new DOMPDF();
$dompdf->load_html($html_b);
$dompdf->render();
$output_b = $dompdf->output();
$filename_b = "back_student_".$rand.".pdf";
file_put_contents("".$output_dir.$filename_b."", $output_b);
$pdf_file_b   = $output_dir . $filename_b;
$save_file_b   = FCPATH.'/system/images/GenerateID/'.$rand.'-student_back_'.$id.'.png';
$op_path_b   = base_url().'/system/images/GenerateID/'.$rand.'-student_back_'.$id.'.png';
$cmd_b = '"C:\Program Files\ImageMagick-7.1.0-Q16\magick.exe" '.$pdf_file_b.' '.$save_file_b.' 2>&1';
$output_b = shell_exec($cmd_b);
echo '<a class="front_rem_id_'.$id.'" href="'.$op_path_f.'" download="front_'.$stu_list->student_name_.'.jpg"><button class="front_down_id_'.$id.'"></button></a><a class="back_rem_id_'.$id.'" href="'.$op_path_b.'" download="back_'.$stu_list->student_name_.'.jpg"><button class="back_down_id_'.$id.'"></button></a>';

/*$id=388;
$data['stu_list']=$this->db->where('id',$id)->get('erp_studentdetails')->row();
$output_dir = FCPATH."system/images/GenerateID/"; 
	
//$html = $this->load->view('subadmin/ID_front_pdf', $data, true);
$html = $this->load->view('subadmin/ID_back_pdf', $data, true);
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream("sample.pdf",array("Attachment" => false));*/
	}
	
	public function IDFront()
	{
		
	$this->load->view('template/subadmin/header');
    $this->load->view('template/subadmin/menubar');
    $this->load->view('template/subadmin/headerbar');
    $this->load->view('subadmin/ID_front');
    $this->load->view('template/subadmin/footer');
    }
	public function IDBack()
	{
		
	$this->load->view('template/subadmin/header');
    $this->load->view('template/subadmin/menubar');
    $this->load->view('template/subadmin/headerbar');
    $this->load->view('subadmin/ID_back');
    $this->load->view('template/subadmin/footer');
    }
	public function do_upload1(){

    	$config = array();
		$config['upload_path'] = 'system/images/';
		$config['allowed_types'] = '*';
		$config['remove_spaces'] = TRUE;
		$config['overwrite'] = FALSE;
		return $config;
		
        }
	public function download_img() {
		
    /*$pdfAbsolutePath = FCPATH."/system/images/IDGenerate/sample.pdf[0]";
    
    
          $im             = new imagick($pdfAbsolutePath);
    
          $noOfPagesInPDF = $im->getNumberImages(); 
    
          if ($noOfPagesInPDF) { 
    
              for ($i = 0; $i < $noOfPagesInPDF; $i++) { 
    
                  $url = $pdfAbsolutePath.'['.$i.']'; 
    
                  $image = new Imagick($url);
    
                  $image->setImageFormat("jpg"); 
    
                  $image->writeImage(FCPATH."/system/images/IDGenerate/".($i+1).'-'.rand().'.jpg'); 
    
              }
    
              echo "All pages of PDF is converted to images";
    
          }
          echo "PDF doesn't have any pages";*/
/*$message = "";
$display = "";
		  if($_FILES)
{    
    $output_dir = FCPATH."system/images/";    
    ini_set("display_errors",1);
    if(isset($_FILES["myfile"]))
    {
        $RandomNum   = time();
        
        $ImageName      = str_replace(' ','-',strtolower($_FILES['myfile']['name']));
        $ImageType      = $_FILES['myfile']['type']; //"image/png", image/jpeg etc.
     
        $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
        $ImageExt       = str_replace('.','',$ImageExt);
        if($ImageExt != "pdf")
        {
            $message = "Invalid file format only <b>\"PDF\"</b> allowed.";
        }
        else
        {
            $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
            $NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;         
            
             if($_FILES['myfile']['size'] != 0) {

			           $_FILES["file"]["name"] = $NewImageName;
					   $_FILES["file"]["type"] = $_FILES["myfile"]["type"];
					   $_FILES["file"]["tmp_name"] = $_FILES["myfile"]["tmp_name"];
					   $_FILES["file"]["error"] = $_FILES["myfile"]["error"];
					   $_FILES["file"]["size"] = $_FILES["myfile"]["size"];

					   $this->upload->initialize($this->do_upload1());
					   if($this->upload->do_upload('file'))
					   {
						$ffff = $this->upload->data();
						 //$image=$ffff['file_name'];
						 //$data['image'] = 'uploads/'.$NewImageName;
					   }
					}
					
            $location= $output_dir;
            $name       = $output_dir. $NewImageName;
            $num = $this->count_pages($name);
            $RandomNum   = time();
            $nameto     = $output_dir.$RandomNum.".jpg";        
            $location . " " .  $convert    = $location . " " . $name . " ".$nameto;
            exec("convert ".$convert);
            for($i = 0; $i<$num;$i++)
            {
              $display .= "<img src='$output_dir$RandomNum-$i.jpg' title='Page-$i' /><br>";  	  
            }
            $message = "PDF converted to JPEG sucessfully!!";
        }
    }
}
          $data['display']=$display;
          $data['message']=$message;
		  $this->load->view('subadmin/IDtest',$data);
		 //$url = 'http://localhost/mssw/erp/system/images/'; 
	
	// Example path override for Windows systems:
	 $config['imagemagick_path'] = 'C:\Program Files\ImageMagick-7.1.0-Q16\\';
	 $this->load->library( 'image_lib',$config );
		 $url = FCPATH . '/system/images/'; 
		  $pdflib = new ImalH\PDFLib\PDFLib();
$result1 = $pdflib->setPdfPath($url.'sample.pdf');
$pdflib->setOutputPath($url);
$result = $pdflib->convert();*/
/*$output=null;
$retval=null;
exec('magick '.$pdf_file.' '.$save_to.'', $output, $retval);
$cmd = 'export PATH="http://localhost/mssw/erp/system/images"; magick '.$pdf_file.' '.$save_to.' 2>&1';
$cmd = '"C:\Program Files\ImageMagick-7.1.0-Q16\magick.exe" '.$pdf_file.' '.$save_to.' C:\xampp\htdocs\mssw\erp\system\images\demo.png 2>&1';*/

$this->load->helper('download');
$pdf_file   = FCPATH.'/system/images/sample.pdf';
$save_file   = FCPATH.'/system/images/test-0.png';
//$cmd = '"C:\Program Files\ImageMagick-7.1.0-Q16\magick.exe" -density 300 '.$pdf_file.' -quality 90 -colorspace RGB  C:\xampp\htdocs\mssw\erp\system\images\test.png 2>&1';
$cmd = '"C:\Program Files\ImageMagick-7.1.0-Q16\magick.exe" '.$pdf_file.' C:\xampp\htdocs\mssw\erp\system\images\test.png 2>&1';
$output = shell_exec($cmd);
    force_download($save_file, NULL);
echo "<pre>$output</pre>";
    }
    function count_pages($pdfname) {
          $pdftext = file_get_contents($pdfname);
          $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);
          return $num;
        }
		
		public function IDGenerate1()
	{
		$data['department']='';
		$data['program']='';
	if(isset($_POST['submit'])){
	  $department=$data['department']=$this->input->post('department');	
	  $program=$data['program']=$this->input->post('program');
	   if($department==1){
       $data['programm'] = $this->db->where('college_type_','Aided')->get('erp_department')->result();	}
	   else{
	   $data['programm'] = $this->db->where('college_type_','Self Finance')->get('erp_department')->result();	
	   }
	   $dept = $this->db->where('id',$program)->get('erp_department')->row(); 
	   //$data['stu_list']=$this->db->where('as_dep',$dept->dept_code_)->where('as_status',1)->where('as_reg_num!='.null.'')->get('admitted_student')->result();
	   $data['stu_list']=$this->db->where('as_dep',$dept->dept_code_)->where('as_reg_num!='.null.'')->get('admitted_student')->result();
	}
	$this->load->view('template/subadmin/header');
    $this->load->view('template/subadmin/menubar');
    $this->load->view('template/subadmin/headerbar');
    $this->load->view('subadmin/ID_generate1',$data);
    $this->load->view('template/subadmin/footer');
    }
	public function getStudentID()
	{
		$id=$this->input->post('id');
        $data['stu_list']=$stu_list=$this->db->where('as_id',$id)->get('admitted_student')->row();
		$dept=$this->db->where('dept_code_',$stu_list->as_dep)->get('erp_department')->row();
		if($dept->degree_=='UG'){
		$stu_det = $this->db->where('pr_user_id',$stu_list->as_student_id)->get('new_preview')->row();
		}elseif($dept->degree_=='PG'){
		$stu_det = $this->db->where('pr_user_id',$stu_list->as_student_id)->get('new_preview_pg')->row();
        $stu_mob = $this->db->where('u_id',$stu_list->as_student_id)->get('stu_user')->row();	
		}else{
		$stu_det = $this->db->where('pr_user_id',$stu_list->as_student_id)->get('new_preview_dip')->row();	
        $stu_mob = $this->db->where('u_id',$stu_list->as_student_id)->get('stu_user')->row();	
		}
		$name = $stu_list->as_name;
		$reg_no = $stu_list->as_reg_num;
		$dept_name = $dept->dept_name_;
        $mobile = $stu_mob->u_mobile;
		$address = $stu_det->pr_local_address;
		$blood_grp = $stu_list->as_blood_gp;
		//$batch=$this->db->where('sl_id',$stu_list->as_shotlist_ref_number)->get('shotlisted_candidate')->row();
		$batch=explode('-',$stu_list->as_app_number);
		//$doj=$batch->created; $deg_p=date('Y',strtotime($doj));
		$doj='01-01-20'.$batch[1]; $deg_p=date('Y',strtotime($doj));
if($dept->degree_=='UG'){$deg_period=date("Y", strtotime(date("Y-m-d", strtotime($doj)) . " + 3 year"));} 
else{$deg_period=date("Y", strtotime(date("Y-m-d", strtotime($doj)) . " + 2 year"));}
  $file_headers = @get_headers('https://admission.mssw.in/admin/uploads/'.$stu_list->as_profile .'');
if($file_headers[0] == 'HTTP/1.1 404 Not Found'){$url = base_url().'system/images/IDGenerate/male-avator.jpg';}
else{
$url = 'https://admission.mssw.in/admin/uploads/'.$stu_list->as_profile;
}

$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
	  $result = 'Reg.no:'.$reg_no.'&&Name:'.$name.'&&Batch:'.$deg_p.'-'.$deg_period.'&&Dept:'.$stu_list->as_dep.'&&Address:'.$address.'';
	  //$result = $reg_no;
        $img = '<img style="width:250px;height:50px;" src="data:image/png;base64,' . base64_encode($generator->getBarcode($result, $generator::TYPE_CODE_128)) . '">';
		
	echo '<div id="html-content-holder_'.$id.'">
	<div class="row">
	<div class="col-lg-6">
	<div class="id-card-front">
<img class="mssw-logo" src="'.base_url().'system/images/IDGenerate/MSSW_Logo.png">
<img class="stud-img" src="'.$url.'">
<h3>'.$name.'</h3>
<table width="100%">
<tbody>
<tr>
<td>Regn. No.</td>
<td>'.$reg_no.'</td>
</tr>
<tr>
<td>Program</td>
<td>'.$dept_name.'</td>
</tr>
<tr>
<td>Batch</td>
<td>'.$deg_p.'-'.$deg_period.'</td>
</tr>
</tbody>
</table>
<div class="bar-code">'.$img.'</div>
</div>
</div>
<div class="col-lg-6">
<div class="id-card-back">

<table width="100%">
<tbody>
<tr>
<td>Blood Group</td>
<td>'.$blood_grp.'</td>
</tr>
<tr>
<td>Phone No.</td>
<td>'.$mobile.'</td>
</tr>
<tr>
<td>Address</td>
<td>'.$address.'</td>
</tr>
</tbody>
</table>
<div class="ins">
<p><strong>Instructions:</strong></p>
<ol>
<li>The card should always be displayed by the holder
while on campus.</li>
<li>Loss of card should be reported to Administrative
officer (AO) immediately.</li>
<li>If found, please return to MSSW.</li>

</ol>
</div>
<div class="sign"><img src="'.base_url().'system/images/IDGenerate/Sign.png"></div>
<div class="btm">
<h5>MADRAS SCHOOL OF SOCIAL WORK
(AUTONOMOUS)</h5>
<p>32, Casa Major Road,
<br>Egmore, Chennai – 600 008</p>
<p>Ph: 044 28194566</p>
</div>
</div>
</div>
</div>
<input type="hidden" id="reg_'.$id.'" value="'.$reg_no.'">
<a id="btn-Convert-Html2Image_'.$id.'" href="#"><button id="btn-Convert_'.$id.'" style="visibility:hidden">convertto image</button></a>';
    }
	
 public function barCodeGenrator(){

        $redColor = [255, 0, 0];
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
      //  file_put_contents('barcode.png', $generator->getBarcode('081231723897', $generator::TYPE_CODE_128, 3, 50, $redColor));
	  $result = 'Name:9626643846';
        echo '<img style="width:250px;height:50px;" src="data:image/png;base64,' . base64_encode($generator->getBarcode($result, $generator::TYPE_CODE_128, 3, 50)) . '">';

    }
	
public function IDGenerateDip()
	{
		$query="select Applyed_Cources.application_number,new_preview_dip.* from Applyed_Cources left join new_preview_dip on new_preview_dip.pr_user_id=Applyed_Cources.user_id where Applyed_Cources.main_course_id=4 group by new_preview_dip.pr_id";
        $data['stu_list']=$stu_list=$this->db->query($query)->result();
	$this->load->view('template/subadmin/header');
    $this->load->view('template/subadmin/menubar');
    $this->load->view('template/subadmin/headerbar');
    $this->load->view('subadmin/ID_generate_dip',$data);
    $this->load->view('template/subadmin/footer');
    }
	public function getStudentDipID()
	{
		$id=$this->input->post('id');
		$reg_no = $this->input->post('regno');
		$query="select stu_user.u_mobile,Applyed_Cources.application_number,new_preview_dip.* from new_preview_dip left join Applyed_Cources on new_preview_dip.pr_user_id=Applyed_Cources.user_id left join stu_user on stu_user.u_id=new_preview_dip.pr_user_id where new_preview_dip.pr_id='$id'";
        $stu_list=$this->db->query($query)->row();
		$name = $stu_list->pr_applicant_name;
        $mobile = $stu_list->u_mobile;
		$address = $stu_list->pr_local_address;
		$blood_grp = $stu_list->pr_blood_group;
		//$batch=$this->db->where('sl_id',$stu_list->as_shotlist_ref_number)->get('shotlisted_candidate')->row();
		$batch=explode('-',$stu_list->application_number);
		$dept_name = $batch[0];
		$doj='01-01-20'.$batch[1]; $deg_p=date('Y',strtotime($doj));
        $deg_period=date("Y", strtotime(date("Y-m-d", strtotime($doj)) . " + 2 year"));
$file_headers = @get_headers('https://admission.mssw.in/admin/uploads/'.$stu_list->pr_photo .'');
if($stu_list->pr_photo==null||$stu_list->pr_photo==''){
$url = base_url().'system/images/IDGenerate/male-avator.jpg';}
else{
  if($file_headers[0] != 'HTTP/1.1 404 Not Found'){	
  $url = 'https://admission.mssw.in/admin/uploads/'.$stu_list->pr_photo;}else{
	 $url = base_url().'system/images/IDGenerate/male-avator.jpg'; 
  }
}

$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
	  //$result = 'Reg.no:'.$reg_no.'&&Name:'.$name.'&&Batch:'.$deg_p.'-'.$deg_period.'&&Dept:'.$stu_list->as_dep.'&&Address:'.$address.'';
	    $result = $reg_no;
        $img = '<img style="width:250px;height:50px;" src="data:image/png;base64,' . base64_encode($generator->getBarcode($result, $generator::TYPE_CODE_128)) . '">';
		
	echo '<div id="html-content-holder_'.$id.'">
	<div class="row">
	<div class="col-lg-6">
	<div class="id-card-front">
<img class="mssw-logo" src="'.base_url().'system/images/IDGenerate/MSSW_Logo.png">
<img class="stud-img" src="'.$url.'">
<h3>'.$name.'</h3>
<table width="100%">
<tbody>
<tr>
<td>Regn. No.</td>
<td>'.$reg_no.'</td>
</tr>
<tr>
<td>Program</td>
<td>'.$dept_name.'</td>
</tr>
<tr>
<td>Batch</td>
<td>'.$deg_p.'-'.$deg_period.'</td>
</tr>
</tbody>
</table>
<div class="bar-code">'.$img.'</div>
</div>
</div>
<div class="col-lg-6">
<div class="id-card-back">

<table width="100%">
<tbody>
<tr>
<td>Blood Group</td>
<td>'.$blood_grp.'</td>
</tr>
<tr>
<td>Phone No.</td>
<td>'.$mobile.'</td>
</tr>
<tr>
<td>Address</td>
<td>'.$address.'</td>
</tr>
</tbody>
</table>
<div class="ins">
<p><strong>Instructions:</strong></p>
<ol>
<li>The card should always be displayed by the holder
while on campus.</li>
<li>Loss of card should be reported to Administrative
officer (AO) immediately.</li>
<li>If found, please return to MSSW.</li>

</ol>
</div>
<div class="sign"><img src="'.base_url().'system/images/IDGenerate/Sign.png"></div>
<div class="btm">
<h5>MADRAS SCHOOL OF SOCIAL WORK
(AUTONOMOUS)</h5>
<p>32, Casa Major Road,
<br>Egmore, Chennai – 600 008</p>
<p>Ph: 044 28194566</p>
</div>
</div>
</div>
</div>
<input type="hidden" id="reg_'.$id.'" value="'.$reg_no.'">
<a id="btn-Convert-Html2Image_'.$id.'" href="#"><button id="btn-Convert_'.$id.'" style="visibility:hidden">convertto image</button></a>';
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
	
	
	public function IDGenerate2()
	{
		$data['department']='';
		$data['program']='';
		$data['batch1']='';
	if(isset($_POST['submit'])){
	  $department=$data['department']=$this->input->post('department');	
	  $program=$data['program']=$this->input->post('program');
	  $batch=$data['batch1']=$this->input->post('batch');
	   if($department==1){
       $data['programm'] = $this->db->where('college_type_','Aided')->get('erp_department')->result();	}
	   else{
	   $data['programm'] = $this->db->where('college_type_','Self Finance')->get('erp_department')->result();	
	   }
	   $dept = $this->db->where('id',$program)->get('erp_department')->row(); 
	   //$data['stu_list']=$this->db->where('as_dep',$dept->dept_code_)->where('as_status',1)->where('as_reg_num!='.null.'')->get('admitted_student')->result();
	   $yr = substr($batch,-2);
	   $data['stu_list']=$this->db->select('admitted_student.*')->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')->where('RIGHT(SUBSTRING_INDEX(as_app_number, "-", 2),2)='.$yr.'')->where('shotlisted_candidate.sl_main_id',$department)->where('shotlisted_candidate.sl_course_id',$program)->where('as_reg_num!='.null.'')->get('admitted_student')->result();
	}
	$this->load->view('template/subadmin/header');
    $this->load->view('template/subadmin/menubar');
    $this->load->view('template/subadmin/headerbar');
    $this->load->view('subadmin/ID_generate2',$data);
    $this->load->view('template/subadmin/footer');
    }
	
	public function IDGeneratePDF(){
		$data['id']=$id=$this->uri->segment(3);
		//$data['id']=$id=978;
        $data['stu_list']=$stu_list=$this->db->join('shotlisted_candidate s','a.as_shotlist_ref_number=s.sl_id')->where('a.as_id',$id)->get('admitted_student a')->row();
		$dept=$this->db->where('main_id',$stu_list->sl_main_id)->where('cour_id',$stu_list->sl_course_id)->get('department_details')->row();
		if($dept->main_id==5){
		$stu_det = $this->db->where('pr_user_id',$stu_list->as_student_id)->get('new_preview')->row();
		$stu_mob = $this->db->where('u_id',$stu_list->as_student_id)->get('stu_user')->row();	
		}
		//elseif($dept->main_id=='PG'){
		else{
		$stu_det = $this->db->where('pr_user_id',$stu_list->as_student_id)->get('new_preview_pg')->row();
        $stu_mob = $this->db->where('u_id',$stu_list->as_student_id)->get('stu_user')->row();	
		}
		/*else{
		$stu_det = $this->db->where('pr_user_id',$stu_list->as_student_id)->get('new_preview_dip')->row();	
        $stu_mob = $this->db->where('u_id',$stu_list->as_student_id)->get('stu_user')->row();	
		}*/
		$data['name']=$name = $stu_list->as_name;
		$data['reg_no']=$reg_no = $stu_list->as_reg_num;
		$data['dept_name']=$dept_name = $dept->comp_name;
        $data['mobile']=$mobile = $stu_mob->u_mobile;
		$data['address']=$address = $stu_det->pr_local_address;
		$data['blood_grp']=$blood_grp = $stu_list->as_blood_gp;
		//$batch=$this->db->where('sl_id',$stu_list->as_shotlist_ref_number)->get('shotlisted_candidate')->row();
		$batch=explode('-',$stu_list->as_app_number);
		//$doj=$batch->created; $deg_p=date('Y',strtotime($doj));
		$doj='01-01-20'.$batch[1]; $deg_p=date('Y',strtotime($doj));
if($dept->main_id==5){$deg_period=date("Y", strtotime(date("Y-m-d", strtotime($doj)) . " + 3 year"));} 
else{$deg_period=date("Y", strtotime(date("Y-m-d", strtotime($doj)) . " + 2 year"));}
  $file_headers = @get_headers('https://admission.mssw.in/admin/uploads/'.$stu_list->as_profile .'');
if($file_headers[0] == 'HTTP/1.1 404 Not Found'){$url = base_url().'system/images/IDGenerate/male-avator.jpg';}
else{
$url = 'https://admission.mssw.in/admin/uploads/'.$stu_list->as_profile;
}
$data['deg_p']=$deg_p;
$data['deg_period']=$deg_period;
$data['url']=$url;

$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
	  //$result = 'Reg.no:'.$reg_no.'&&Name:'.$name.'&&Batch:'.$deg_p.'-'.$deg_period.'&&Dept:'.$stu_list->as_dep.'&&Address:'.$address.'';
	  $result = $reg_no;
        $data['img']=$img = '<img style="width:250px;height:50px;" src="data:image/png;base64,' . base64_encode($generator->getBarcode($result, $generator::TYPE_CODE_128)) . '">';

		$this->load->library("pdf");
            $html = $this->load->view("subadmin/IDtestPDF", $data, true);
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
        //   $dompdf->setPaper("A4", "landscape");
		   $dompdf->setPaper(array(0,0,154,243));
            $dompdf->render();
            if (ob_get_contents()) ob_end_clean();
            $dompdf->stream("".$reg_no.".pdf", ["Attachment" => 0]);
	}
	
	public function IDTest2()
	{
		$data['id']=3;
    $this->load->view('subadmin/IDtestPDF',$data);
    }
	
	public function IDGenerateDip2()
	{
		$data['batch1']='';
	if(isset($_POST['submit'])){
		$batch=$data['batch1']=$this->input->post('batch');
		$yr = substr($batch,-2);
		$query="select Applyed_Cources.application_number,new_preview_dip.* from Applyed_Cources left join new_preview_dip on new_preview_dip.pr_user_id=Applyed_Cources.user_id where Applyed_Cources.main_course_id=4 and RIGHT(SUBSTRING_INDEX(Applyed_Cources.application_number, '-', 2),2)=".$yr." group by new_preview_dip.pr_id";
        $data['stu_list']=$stu_list=$this->db->query($query)->result();
	}
	$this->load->view('template/subadmin/header');
    $this->load->view('template/subadmin/menubar');
    $this->load->view('template/subadmin/headerbar');
    $this->load->view('subadmin/ID_generate_dip2',$data);
    $this->load->view('template/subadmin/footer');
    }
	
	public function IDGenerateDipPDF(){
		$data['id']=$id=$this->uri->segment(3);
		$data['reg_no']=$reg_no=$this->uri->segment(4);
		//$data['id']=$id=4;
		//$data['reg_no']=$reg_no=222;
		$query="select stu_user.u_mobile,Applyed_Cources.application_number,new_preview_dip.* from new_preview_dip left join Applyed_Cources on new_preview_dip.pr_user_id=Applyed_Cources.user_id left join stu_user on stu_user.u_id=new_preview_dip.pr_user_id where new_preview_dip.pr_id='$id'";
		$data['stu_list']=$stu_list=$this->db->query($query)->row();
		$data['name']=$name = $stu_list->pr_applicant_name;
        $data['mobile']=$mobile = $stu_list->u_mobile;
		$data['address']=$address = $stu_list->pr_local_address;
		$data['blood_grp']=$blood_grp = $stu_list->pr_blood_group;
		//$batch=$this->db->where('sl_id',$stu_list->as_shotlist_ref_number)->get('shotlisted_candidate')->row();
		$batch=explode('-',$stu_list->application_number);
		$data['dept_name']=$dept_name = $batch[0];
		$doj='01-01-20'.$batch[1]; $deg_p=date('Y',strtotime($doj));
        $deg_period=date("Y", strtotime(date("Y-m-d", strtotime($doj)) . " + 2 year"));
  $file_headers = @get_headers('https://admission.mssw.in/admin/uploads/'.$stu_list->pr_photo .'');
if($file_headers[0] == 'HTTP/1.1 404 Not Found'){$url = base_url().'system/images/IDGenerate/male-avator.jpg';}
else{
$url = 'https://admission.mssw.in/admin/uploads/'.$stu_list->pr_photo;
}
$data['deg_p']=$deg_p;
$data['deg_period']=$deg_period;
$data['url']=$url;

$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
	  //$result = 'Reg.no:'.$reg_no.'&&Name:'.$name.'&&Batch:'.$deg_p.'-'.$deg_period.'&&Dept:'.$dept_name.'&&Address:'.$address.'';
	  $result = $reg_no;
        $data['img']=$img = '<img style="width:250px;height:50px;" src="data:image/png;base64,' . base64_encode($generator->getBarcode($result, $generator::TYPE_CODE_128)) . '">';

		$this->load->library("pdf");
            $html = $this->load->view("subadmin/IDtestPDF", $data, true);
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
            //$dompdf->setPaper("A4", "landscape");
			$dompdf->setPaper(array(0,0,154,243));
            $dompdf->render();
            if (ob_get_contents()) ob_end_clean();
            $dompdf->stream("".$reg_no.".pdf", ["Attachment" => 1]);
	}
	
	public function IDGeneratePDFtest(){
		//$data['id']=$id=$this->uri->segment(3);
		$data['id']=$id=4;
        $data['stu_list']=$stu_list=$this->db->where('as_id',$id)->get('admitted_student')->row();
		$dept=$this->db->where('dept_code_',$stu_list->as_dep)->get('erp_department')->row();
		if($dept->degree_=='UG'){
		$stu_det = $this->db->where('pr_user_id',$stu_list->as_student_id)->get('new_preview')->row();
		$stu_mob = $this->db->where('u_id',$stu_list->as_student_id)->get('stu_user')->row();	
		}elseif($dept->degree_=='PG'){
		$stu_det = $this->db->where('pr_user_id',$stu_list->as_student_id)->get('new_preview_pg')->row();
        $stu_mob = $this->db->where('u_id',$stu_list->as_student_id)->get('stu_user')->row();	
		}else{
		$stu_det = $this->db->where('pr_user_id',$stu_list->as_student_id)->get('new_preview_dip')->row();	
        $stu_mob = $this->db->where('u_id',$stu_list->as_student_id)->get('stu_user')->row();	
		}
		$data['name']=$name = $stu_list->as_name;
		$data['reg_no']=$reg_no = $stu_list->as_reg_num;
		$data['dept_name']=$dept_name = $dept->dept_name_;
        $data['mobile']=$mobile = $stu_mob->u_mobile;
		$data['address']=$address = $stu_det->pr_local_address;
		$data['blood_grp']=$blood_grp = $stu_list->as_blood_gp;
		//$batch=$this->db->where('sl_id',$stu_list->as_shotlist_ref_number)->get('shotlisted_candidate')->row();
		$batch=explode('-',$stu_list->as_app_number);
		//$doj=$batch->created; $deg_p=date('Y',strtotime($doj));
		$doj='01-01-20'.$batch[1]; $deg_p=date('Y',strtotime($doj));
if($dept->degree_=='UG'){$deg_period=date("Y", strtotime(date("Y-m-d", strtotime($doj)) . " + 3 year"));} 
else{$deg_period=date("Y", strtotime(date("Y-m-d", strtotime($doj)) . " + 2 year"));}
  $file_headers = @get_headers('https://admission.mssw.in/admin/uploads/'.$stu_list->as_profile .'');
if($file_headers[0] == 'HTTP/1.1 404 Not Found'){$url = base_url().'system/images/IDGenerate/male-avator.jpg';}
else{
$url = 'https://admission.mssw.in/admin/uploads/'.$stu_list->as_profile;
}
$data['deg_p']=$deg_p;
$data['deg_period']=$deg_period;
$data['url']=$url;

$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
	  $result = 'Reg.no:'.$reg_no.'&&Name:'.$name.'&&Batch:'.$deg_p.'-'.$deg_period.'&&Dept:'.$stu_list->as_dep.'&&Address:'.$address.'';
	  //$result = $reg_no;
        $data['img']=$img = '<img style="width:250px;height:50px;" src="data:image/png;base64,' . base64_encode($generator->getBarcode($result, $generator::TYPE_CODE_128)) . '">';

		$this->load->library("pdf");
            $html = $this->load->view("subadmin/IDtestPDF", $data, true);
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
			$this->load->view('subadmin/IDtestPDF',$data);
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
		->where('ann_ao', $user)->get()->result();
		if (isset($_POST['submit'])) {
			$data_ann['ann_main'] = $main_course_id = $this->input->post('main_course_id');
			$data_ann['ann_course'] = $app_course_id = $this->input->post('app_course_id');
			$data_ann['ann_name'] = $this->input->post('title');
			$data_ann['ann_desc'] = $this->input->post('remark');
			$data_ann['ann_batch'] = $this->input->post('batch');
			$data_ann['ann_year'] = $this->input->post('year');
			$data_ann['ann_date_till'] = $this->input->post('date_till');
			$data_ann['ann_ao'] = $user;
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
			redirect('subadmin/studentannouncements', 'refresh');
		}

		$this->load->view('template/subadmin/header');
		$this->load->view('template/subadmin/menubar');
		$this->load->view('template/subadmin/headerbar');
		$this->load->view('subadmin/announcements',$data);
		$this->load->view('template/subadmin/footer');
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
		->get('admitted_student')->result();
		}
		
	$this->load->view('template/subadmin/header');
    $this->load->view('template/subadmin/menubar');
    $this->load->view('template/subadmin/headerbar');
    $this->load->view('subadmin/generateTransferCert',$data);
    $this->load->view('template/subadmin/footer');	
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
            $html = $this->load->view("subadmin/transferCert", $data, true);
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
		->get('admitted_student')->result();
		}
		
	$this->load->view('template/subadmin/header');
    $this->load->view('template/subadmin/menubar');
    $this->load->view('template/subadmin/headerbar');
    $this->load->view('subadmin/generateCourseCompletion',$data);
    $this->load->view('template/subadmin/footer');	
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
            $html = $this->load->view("subadmin/crsCompltnCert", $data, true);
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
	
	public function generateBonafide()
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
		->get('admitted_student')->result();
		}
		
	$this->load->view('template/subadmin/header');
    $this->load->view('template/subadmin/menubar');
    $this->load->view('template/subadmin/headerbar');
    $this->load->view('subadmin/generateBonafide',$data);
    $this->load->view('template/subadmin/footer');	
	}
	public function bonafideCertificate()
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
            $html = $this->load->view("subadmin/bonfdCert", $data, true);
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
            $dompdf->stream("Bonafide.pdf", ["Attachment" => 1]);
		
    //$this->load->view('coe/transferCert',$data);
	}
	
	public function studentMail()
	{
		$user = $this->session->userdata("user")["user_id"];

		date_default_timezone_get();
		$add_date = date('Y-m-d h:i:s');
		$data['student_mail'] = $this->db
		->from('student_mail')
		->join(
			"department_details",
			"student_mail.main_id = department_details.main_id AND student_mail.course_id = department_details.cour_id","left"
		)
		->where('created_by', $user)->get()->result();
		if (isset($_POST['submit'])) {
			$data_ma['main_id'] = $main_course_id = $this->input->post('main_course_id');
			$data_ma['course_id'] = $app_course_id = $this->input->post('app_course_id');
			$data_ma['subject'] = $subject = $this->input->post('subject');
			$data_ma['message'] = $msg = $this->input->post('message');
			$data_ma['batch'] = $batch = $this->input->post('batch');
			$data_ma['year'] = $year = $this->input->post('year');
			$data_ma['created_by'] = $user;
			$data_ma['created_at'] = $add_date;

		
				$insert = $this->db->insert('student_mail', $data_ma);
				
		$yr = substr($batch,-2);
		$cur = date('Y');
		$curr = substr( $cur, -2);
		$stu_list = $this->db->select('stu_user.u_email_id as email')
		->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->join('stu_user','admitted_student.as_student_id=stu_user.u_id')
		->where('shotlisted_candidate.sl_main_id',$main_course_id)
		->where('shotlisted_candidate.sl_course_id',$app_course_id)
		->where('RIGHT(SUBSTRING_INDEX(admitted_student.as_app_number, "-", 2),2)='.$yr.'')
		->where('(ABS('.$curr.' - (RIGHT(SUBSTRING_INDEX(admitted_student.as_app_number, "-", 2),2))) = '.$year.')')
		->get('admitted_student')->result();
		
		foreach($stu_list as $stulist){
		$this->stuEmail($stulist->email,$subject,$msg);
		}
			
			$this->session->set_flashdata('success','Mail Sent Successfully!!','success');
			redirect('subadmin/studentMail', 'refresh');
		}

		$this->load->view('template/subadmin/header');
		$this->load->view('template/subadmin/menubar');
		$this->load->view('template/subadmin/headerbar');
		$this->load->view('subadmin/studentMail',$data);
		$this->load->view('template/subadmin/footer');
	}
	
	public function delete_mail(){

		$id= $this->input->post('delete_id');


		$this->db->where('id',$id);
		$this->db->delete('student_mail');

		echo $this->session->set_flashdata('success','Deleted Successfully!!','success');


	}
	
	public function stuEmail($emailto,$subject,$msg){
        ob_start();
		$html = '<html>
		<head>
		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		
		<!--[if !mso]><!-->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
		<!--<![endif]-->
		<style>
		body {
		margin: 0 !important;
		padding: 0 !important;
		-webkit-text-size-adjust: 100% !important;
		-ms-text-size-adjust: 100% !important;
		-webkit-font-smoothing: antialiased !important; /*style only recognised by some browsers*/
		}
		img {
		border: 0 !important;
		outline: none !important;
		width: 500px !important;
		height: 100px !important;
		}
		
		</style>
		</style>
		</head>
		<body class="em_body" style="margin:0px; padding:0px;" bgcolor="#efefef" align="left">
		<table class="em_main_table" width="700" cellspacing="0" cellpadding="0" border="0">
		<!--Header section-->
		<tbody>
		
		<!--//Header section ends-->
		
		<!--Banner section-->
		<tr>
		<td valign="top">
		<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" style="background:white;">
		<tbody>
		<tr>
		<td valign="top">
		<img class="em_img" alt="Welcome to Email" src="'.base_url().'system/images/mssw_logo.jpg" border="0">
		</td>
		</tr>
		</tbody>
		</table>
		</td>
		</tr>
		<!--//Banner section ends-->
		
		<!--Content Text Section-->
		<tr>
		<td style="padding:35px 11px;" class="em_padd" valign="top" bgcolor="#fff">
		<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
		<tr>
		<td style="font-family: Arial, sans-serif; font-size:18px; line-height:30px; " valign="top">
		'.$msg.'
			
		</td>
		</tr>
		<tr>
		<td style="font-size:0px; line-height:0px; height:15px;" height="15">&nbsp;</td>
		<!--—this is space of 15px to separate two paragraphs ---->
		</tr>
		<tr>
		<td style="font-family: Arial, sans-serif; font-size:18px; line-height:22px; color:#2f2483; letter-spacing:2px; padding-bottom:12px;" valign="top" align="center">
		
		</td>
		</tr>
		<tr>
		<td class="em_h20" style="font-size:0px; line-height:0px; height:25px;" height="25">&nbsp;</td>
		<!--—this is space of 25px to separate two paragraphs ---->
		</tr>
		
		</tbody>
		</table>
		</td>
		</tr>
		</tbody>
		</table>
		</body>
		</html>
		';
		
		$config = array(
	 'protocol' => 'smtp',
     'smtp_host' => 'ssl://smtp.gmail.com',
     'smtp_port' => 465,
     'smtp_user' => 'admission.mssw@gmail.com',
     'smtp_pass' => 'dqamafoawpedieqn',
     'mailtype' => 'html',
	 'charset' => 'iso-8859-1',  
	 );
                    $this->email->initialize($config);
                    $this->email->set_newline("\r\n");
					$this->email->from("admission.mssw@gmail.com");
					$this->email->to($emailto);
					$this->email->subject($subject);
					$this->email->message($html);
			$mail =	$this->email->send();
		
		ob_clean();
         /*if( $mail == true ) {
            echo "Message sent successfully...";
         }else {
            echo "Message could not be sent...";
         }*/
		
		return true;
		
		}
		
		public function IDGenerateStaff()
	{
		$user = $this->session->userdata("user")["user_id"];
		
		$data['department']='';
		$data['program']='';
	if(isset($_POST['submit'])){
	  $department=$data['department']=$this->input->post('department');	
	  $program=$data['program']=$this->input->post('program');
	   
	   $data['staff_list']=$this->db->select('*')->where('emp_college_type_',$department)->where('emp_dept_name_',$program)->where('emp_working_status_','Working')->get('erp_employee_master')->result();
	}
	$this->load->view('template/subadmin/header');
    $this->load->view('template/subadmin/menubar');
    $this->load->view('template/subadmin/headerbar');
    $this->load->view('subadmin/ID_generate_staff',$data);
    $this->load->view('template/subadmin/footer');
    }
	
	public function IDGenerateStaffPDF(){
		$data['id']=$id=$this->uri->segment(3);
		//$data['id']=$id=1;
       $det=$this->db->select('*')->where('id',$id)->get('erp_employee_master')->row();
	   $dept_s=$this->db->where('main_id',$det->emp_college_type_)->where('cour_id',$det->emp_dept_name_)->get('department_details')->row();
	   $desig=$this->db->where('id',$det->emp_designation_)->get('erp_role_master')->row();
		
$file_headers = @get_headers(base_url().$det->emp_profile_);
if($file_headers[0] == 'HTTP/1.1 404 Not Found'){$url = base_url().'system/images/IDGenerate/male-avator.jpg';}
else{
$url = base_url().$det->emp_profile_;
}
$data['name']=$det->emp_name_;
$data['doj']=date("Y-m-d", strtotime($det->emp_doj_));
$data['url']=$url;
$data['emp_id']=$emp_id=$det->employee_id_;
$data['dept_name']=$dept_s->short_name;
$data['designation']=$desig->role_name;
$data['blood_grp']=$det->emp_bgroup_;
$data['mobile']=$det->emp_mobile_;
$data['address']=$det->emp_address_;

$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
	  //$result = 'Reg.no:'.$reg_no.'&&Name:'.$name.'&&Batch:'.$deg_p.'-'.$deg_period.'&&Dept:'.$stu_list->as_dep.'&&Address:'.$address.'';
	  $result = $emp_id;
        $data['img']=$img = '<img style="width:250px;height:50px;" src="data:image/png;base64,' . base64_encode($generator->getBarcode($result, $generator::TYPE_CODE_128)) . '">';

		$this->load->library("pdf");
            $html = $this->load->view("subadmin/IDStaffPDF", $data, true);
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
        //   $dompdf->setPaper("A4", "landscape");
		   $dompdf->setPaper(array(0,0,154,243));
            $dompdf->render();
            if (ob_get_contents()) ob_end_clean();
            $dompdf->stream("".$emp_id.".pdf", ["Attachment" => 0]);
	}

}

