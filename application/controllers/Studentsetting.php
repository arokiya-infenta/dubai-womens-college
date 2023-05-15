<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Studentsetting extends CI_Controller {

    public $prev_table;
	public function __construct()
    {
    parent::__construct();
 //	error_reporting(0);
	//ini_set('display_errors', 0);  
	$this->load->library('upload');
	//$this->load->library('pdf');
	$this->load->helper('download');
	$this->load->library('email');
	$this->load->config('email');
	
	
		date_default_timezone_set('Asia/Calcutta');

		if($this->session->userdata('user')['user_m_course'] == 1){
		
            $this->prev_table =	"new_preview";
        
    }else if($this->session->userdata('user')['user_m_course']==2){
    
        $this->prev_table =	"new_preview_pg";
        
    
    }else if($this->session->userdata('user')['user_m_course']==3){
    
        $this->prev_table =	"new_preview_dip";
        
    }else{
    
        redirect('Home/logOut', 'refresh');
        exit;
    }

	}

function index(){


	$this->load->view('Home/template/head');
		$this->load->view('Home/site/setting');
		$this->load->view('Home/template/footer_common');



}

public function UploadPhoto(){
    
	$image_P = $this->input->post('ppimage');
    $this->upload->initialize($this->do_upload());
	$hh =$this->upload->do_upload('profile-img');
	$dataInfo = $this->upload->data();
		
	
			if($hh){
	
          
				 $filename =$dataInfo['file_name'];

			}else{
              
				if($image_P == null){
							$image_P = null;
				}else{
	
					$filename = $image_P;
	
				}
			}
$data=array(
    'pr_photo'=>$filename,
);



$this->db->where('pr_user_id',$this->session->userdata('user')['user_id']);
	$this->db->update( $this->prev_table,$data);



	$m = $this->db->select("*")->from("erp_existing_students")->where('student_id',$this->session->userdata('user')['user_id'])->get()->num_rows();

if($m > 0){

	$ext_data=array(
    'student_image'=>$filename,
);


$this->db->where('student_id',$this->session->userdata('user')['user_id']);
	$this->db->update('erp_existing_students',$ext_data);
	
	$admitted_data=array(
    'as_profile'=>$filename,
);
$this->db->where('as_student_id',$this->session->userdata('user')['user_id']);
	$this->db->update('admitted_student',$admitted_data);
	
}



	
	$this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Success !</strong> Photo Updated Successfully .
	</div>');
	


	
		redirect('Studentsetting');

}
public function do_upload(){
   

	$config = array();
	$config['upload_path'] = 'admin/uploads/';
	$config['allowed_types'] = '*';
	$config['remove_spaces'] = TRUE;
	$config['encrypt_name'] = TRUE;
    $this->load->library('upload', $config);
	return $config;
	
	}


}
