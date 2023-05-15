<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StudentPreview extends CI_Controller {


	public function __construct()
    {
    parent::__construct();
    error_reporting(0);
    ini_set('display_errors', 0);  
	
    }


    public function index(){


        $this->load->view('Home/template/head');
        $this->load->view('Home/searchstudent');
        $this->load->view('Home/template/footer');




    }
    public function viewStudent(){


$studnum = [];

$user_unmber = substr($this->input->post('first_name'),2);

$studnum = sscanf($user_unmber,"%d");


//print_r($studnum);
 $stu_num = $studnum[0];


 $reg_stu = $this->db->select('*')->from('stu_user')->where('u_id',$stu_num)->get();

 $row = $reg_stu->num_rows();

 if($row > 0){

$result_st = $reg_stu->result();


if($result_st[0]->u_course == 2){


	$user_id = $studnum[0];
		$pr_user = $this->db->select('*')->from('new_preview_pg')->where('pr_user_id',$user_id)->get();
		$pr_study = $this->db->select('*')->from('sub_preview_pg')->where('sb_u_id',$user_id)->get();
	
		$q = $this->db->select('*')->from('college_course')->get();
	
	
		$data['cc'] = $q->result();
	
		$data['user'] = $pr_user->result();
		$data['Study'] = $pr_study->result();
		
		
		
		$this->load->view('Home/site/preview_pg',$data);




}else if($result_st[0]->u_course == 3){


    $user_id = $studnum[0];
    $pr_user = $this->db->select('*')->from('new_preview_dip')->where('pr_user_id',$user_id)->get();
    $pr_study = $this->db->select('*')->from('sub_preview_dip')->where('sb_u_id',$user_id)->get();

    $q = $this->db->select('*')->from('college_course')->get();


    $data['cc'] = $q->result();

    $data['user'] = $pr_user->result();
    $data['Study'] = $pr_study->result();
    
    
    
    $this->load->view('Home/site/preview_dip',$data); 





}




 }else{


	$this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Student ! </strong>Not Found .
			</div>');
			
			
				redirect('StudentPreview', 'refresh');


 }




      



    }









}