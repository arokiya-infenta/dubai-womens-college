<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Others extends CI_Controller
{

	private $CI;
	protected $user_department;
	protected $user_main_stream;
	protected $user_course_stream;
	protected $user_register_number;
	protected $user_ref_number;
	protected $user_number;
	protected $user_semester;
	protected $user_batch;
	protected $user_ad_id;

    public function __construct()
    {
        parent::__construct();
		$this->CI =& get_instance();
      //  $this->CI->load->database();
      // ini_set('display_errors', 0);
	   $this->CI->load->library("useracadamic");
       date_default_timezone_set('Asia/Calcutta');
       $this->load->library('Pdf');
	   $this->load->helper('form');
	  // $this->load->library('calendar');
	   if ($this->session->userdata("user")["user_year"] == "" || $this->session->userdata("user")["user_year"] == "0000" ) {
		$this->asyear = "2021/04/01 00:00:00";
		$this->aeyear = "2022/04/01  00:00:00";
	} else {
		$this->asyear = $this->session->userdata("user")["user_year"]."/04/01  00:00:00";
		$this->aeyear = $this->session->userdata("user")["user_year"]+ 1 ."/04/01  00:00:00";
		$this->syear = $this->session->userdata("user")["user_year"];
		$this->eyear = $this->session->userdata("user")["user_year"]+1;
	}
	  
	
	
	$stud_id = $this->db->select("admitted_student.*,shotlisted_candidate.*,department_details.*,erp_existing_students.id AS sid")->from("shotlisted_candidate")
    
	->join('department_details', 'shotlisted_candidate.sl_main_id = department_details.main_id AND shotlisted_candidate.sl_course_id = department_details.cour_id')
	->join('admitted_student', 'shotlisted_candidate.sl_id = admitted_student.as_shotlist_ref_number ')
	->join('erp_existing_students', 'shotlisted_candidate.sl_student_id = erp_existing_students.student_id ')
	->where("sl_student_id",$this->session->userdata("user")["user_id"])
		->where("shotlisted_candidate.principal_published",1)
		->where("shotlisted_candidate.reservation_status",1)
	//->where("sl_student_id",$this->session->userdata("user")["user_id"])
		->get();
		$rests = $stud_id->num_rows();


		if($rests > 0){
$user_d = $stud_id->result();

//print_r($user_d);



$this->user_department = $user_d[0]->comp_name;
$this->user_main_stream = $user_d[0]->sl_main_id;
$this->user_course_stream = $user_d[0]->sl_course_id;
$this->user_register_number = $user_d[0]->as_reg_num;
$this->user_ref_number = date("y",strtotime($this->session->userdata("user")["user_year"]."-01-01")).$this->session->userdata("user")["user_id"];
$this->user_number =$this->session->userdata("user")["user_id"];
$this->user_semester =(int)$this->session->userdata("user")["user_semester"];
$this->user_batch =$this->session->userdata("user")["user_year"];
$this->user_ad_id =$user_d[0]->sid;


if($this->user_semester == 0 ||$this->user_semester=="" ){


	$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">
   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
   <strong>Failed!</strong> Please Select the Semester.
 </div>');


	redirect('Academics', 'refresh');


}

		}else{

			redirect('Home/logOut', 'refresh');




		}
	
	}
	public function index(){


		//print_r($_SESSION);


		$stud_id = $this->db->select("admitted_student.*,shotlisted_candidate.*,department_details.*")->from("shotlisted_candidate")
    
		->join('department_details', 'shotlisted_candidate.sl_main_id = department_details.main_id AND shotlisted_candidate.sl_course_id = department_details.cour_id')
		->join('admitted_student', 'shotlisted_candidate.sl_id = admitted_student.as_shotlist_ref_number ')
		->where("sl_student_id",$this->session->userdata("user")["user_id"])
			->where("shotlisted_candidate.principal_published",1)
			->where("shotlisted_candidate.reservation_status",1)
		//->where("sl_student_id",$this->session->userdata("user")["user_id"])
			->get();
	   
			$rests = $stud_id->num_rows();


			if($rests > 0){
	
				$rest = $stud_id->result();



				if($rest[0]->sl_main_id == 5){

					$data['selected'] = $rest;
					$this->load->view("Home/template/head_ug");
					$this->load->view("Home/site/ug/others", $data);
					$this->load->view("Home/template/footer_ug");
			
				}elseif($rest[0]->sl_main_id == 1){
			
				  $data['selected'] = $rest;
				  $this->load->view("Home/template/head");
				  $this->load->view("Home/site/pg/others", $data);
				  $this->load->view("Home/template/footer");
			
				}else if($rest[0]->sl_main_id == 2){
			
						$data['selected'] = $rest;
				  $this->load->view("Home/template/head");
				  $this->load->view("Home/site/pg/others", $data);
				  $this->load->view("Home/template/footer");
			
			
			
			
				}else if($rest[0]->sl_main_id == 3){
			
			
						$data['selected'] = $rest;
				  $this->load->view("Home/template/head");
				  $this->load->view("Home/site/pg/others", $data);
				  $this->load->view("Home/template/footer");
			
			
			
				}else if($rest[0]->sl_main_id == 4){
			
			
			
			
			
			
						
				}else{
			
			
					redirect('Home/logOut', 'refresh');
			
			
			
				} 
			
				
			}else{


				redirect('Home/logOut', 'refresh');


			}




		//echo $this->useracadamic->studentAcadamicYear($this->session->userdata("user")["user_id"]);

		//print_r($this->useracadamic->myBatch());

	


	}


	public function resumeUpload(){



		if($this->user_main_stream == 5){



			$rest = $this->db->select("*")->from("upload_stu_resume")->where("r_stu_id",$this->user_number)->get()->result();


			$data['resume'] = $rest;
			$this->load->view("Home/template/head_ug");
			$this->load->view("Home/site/ug/upload_resume", $data);
			$this->load->view("Home/template/footer_ug");
	
		}elseif($this->user_main_stream == 1){
	
			$rest = $this->db->select("*")->from("upload_stu_resume")->where("r_stu_id",$this->user_number)->get()->result();

		  $data['resume'] = $rest;
		  $this->load->view("Home/template/head");
		  $this->load->view("Home/site/pg/upload_resume", $data);
		  $this->load->view("Home/template/footer");
	
		}else if($this->user_main_stream == 2){

			$rest = $this->db->select("*")->from("upload_stu_resume")->where("r_stu_id",$this->user_number)->get()->result();
	
				$data['resume'] = $rest;
		  $this->load->view("Home/template/head");
		  $this->load->view("Home/site/pg/upload_resume", $data);
		  $this->load->view("Home/template/footer");
	
	
	
	
		}else if($this->user_main_stream == 3){
	
			$rest = $this->db->select("*")->from("upload_stu_resume")->where("r_stu_id",$this->user_number)->get()->result();
	
				$data['resume'] = $rest;
		  $this->load->view("Home/template/head");
		  $this->load->view("Home/site/pg/upload_resume", $data);
		  $this->load->view("Home/template/footer");
	
	
	
		}else if($this->user_main_stream == 4){
	
	
	
	
	
	
				
		}else if($this->user_main_stream == 5){
	
	
	
		
	
	
		} else{



			redirect('Home/logOut', 'refresh');
	



		}
	
	}
public function saveResume(){

	$this->load->library('upload');




	$config['upload_path']          = 'admin/resume_uploads/';
	$config['allowed_types']        = '*';
	$config['remove_spaces'] = TRUE;
	$config['encrypt_name'] = TRUE;
		//$image_P = $this->input->post('ppimage');
		//$stu_certificate = $this->input->post('stu_certificate');
		$this->load->library('upload', $config);
			$this->upload->initialize($config);
		
			if ( ! $this->upload->do_upload('ppimage'))
			{
	
				$error = array('error' => $this->upload->display_errors());
	
	
	
				print_r($error);
				exit;
				$filename = "";
			}else{
				$file_data = $this->upload->data();
				$filename =$file_data['file_name'];
	
			}

		$rest = $this->db->select("*")->from("upload_stu_resume")->where("r_stu_id",$this->user_number)->get()->num_rows();

		if($rest > 0){

			$array = array(
				'r_resume'=>$filename,
				'r_last_updated'=>date("Y-m-d H:i:s"),
				
			);

$this->db->where("r_stu_id",$this->user_number);
$this->db->update('upload_stu_resume', $array);
		

		}else{

			$array = array(
				'r_stu_id'=>$this->user_number,
				'r_main_id'=>$this->user_main_stream,
				'r_cour_id'=>$this->user_course_stream,
				'r_resume'=>$filename,
				'r_last_updated'=>date("Y-m-d H:i:s"),
				
			);
		
		
			$this->db->insert('upload_stu_resume', $array);
		


		}
	
	
	
	
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Success ! </strong> Enquirey Successfull submitted. 
	  </div>');
		redirect('Others/resumeUpload', 'refresh');
	
	
	



}
public function grievance(){


	if($this->user_main_stream == 5){



		$rest = $this->db->select("*")->from("erp_grievance")->where("student_id",$this->user_ad_id)->get()->result();


		$data['grievance'] = $rest;
		$this->load->view("Home/template/head_ug");
		$this->load->view("Home/site/ug/upload_grievance", $data);
		$this->load->view("Home/template/footer_ug");

	}elseif($this->user_main_stream == 1){

		$rest = $this->db->select("*")->from("erp_grievance")->where("student_id",$this->user_ad_id)->get()->result();

	  $data['grievance'] = $rest;
	  $this->load->view("Home/template/head");
	  $this->load->view("Home/site/pg/upload_grievance", $data);
	  $this->load->view("Home/template/footer");

	}else if($this->user_main_stream == 2){

		$rest = $this->db->select("*")->from("erp_grievance")->where("student_id",$this->user_ad_id)->get()->result();

			$data['grievance'] = $rest;
	  $this->load->view("Home/template/head");
	  $this->load->view("Home/site/pg/upload_grievance", $data);
	  $this->load->view("Home/template/footer");




	}else if($this->user_main_stream == 3){

		$rest = $this->db->select("*")->from("erp_grievance")->where("student_id",$this->user_number)->get()->result();

			$data['grievance'] = $rest;
	  $this->load->view("Home/template/head");
	  $this->load->view("Home/site/pg/upload_grievance", $data);
	  $this->load->view("Home/template/footer");



	}else if($this->user_main_stream == 4){






			
	} else{



		redirect('Home/logOut', 'refresh');




	}

}

public function saveGrievance(){

/* print_r($_SESSION);

echo $this->user_semester;
echo $this->user_batch;
exit;
 */
$rest = $this->db->select("*")->from("erp_grievance")->where("student_id",$this->user_number)->where("grievance",$this->input->post('Grievance'))->get()->num_rows();

if($rest > 0)	{


	$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Failed ! </strong> Already Grievance  submitted. 
  </div>');
	redirect('Others/grievance', 'refresh');


}else{




$this->load->library('upload');




$config['upload_path']          = 'admin/resume_uploads/';
$config['allowed_types']        = '*';
$config['remove_spaces'] = TRUE;
$config['encrypt_name'] = TRUE;
	//$image_P = $this->input->post('ppimage');
	//$stu_certificate = $this->input->post('stu_certificate');
	$this->load->library('upload', $config);
		$this->upload->initialize($config);
	
		if ( ! $this->upload->do_upload('ppimage'))
		{

			$error = array('error' => $this->upload->display_errors());



			print_r($error);
			exit;
			$filename = "";
		}else{
			$file_data = $this->upload->data();
			$filename =$file_data['file_name'];

		}
		

		$array = array(
			'main_id'=>$this->user_main_stream,
			'course_id'=>$this->user_course_stream,
			'student_id'=>$this->user_ad_id,
			'register_id'=>$this->user_number,
			'batch_year'=>$this->user_batch,
			'sem'=>$this->user_semester,
			//'subject_id'=>$filename,
			'grievance'=>$this->input->post('Grievance'),
			'attachment_file'=>$filename,
			'status'=>"open",
			'created_at'=>date("Y-m-d H:i:s"),
			
		);
	
	
		$this->db->insert('erp_grievance', $array);
	
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Success ! </strong> Grievance  Successfull submitted. 
	  </div>');
		redirect('Others/grievance', 'refresh');
	
	}

}


/* public function do_upload($image_P){


	$config = array();
	$config['upload_path'] = 'admin/resume_uploads/';
	$config['allowed_types'] = '*';
	$config['remove_spaces'] = TRUE;
	$config['encrypt_name'] = TRUE;
	$config['file_name']=$image_P;
	return $config;
	
	} */


	/* public function do_upload(){


    

		$config = array();
		$config['upload_path'] = 'admin/resume_uploads/';
		$config['allowed_types'] = '*';
		$config['remove_spaces'] = TRUE;
		$config['encrypt_name'] = TRUE;
		return $config;
		
		}*/
} 
