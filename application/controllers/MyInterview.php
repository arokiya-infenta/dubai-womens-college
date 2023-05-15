<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MyInterview extends CI_Controller {

	public function __construct()
    {

        parent::__construct();
        error_reporting(0);
       ini_set('display_errors', 0);  
       $this->load->library('upload');

    }

    public function index(){


        $user_id = $this->session->userdata('user')['user_id'];






$m =$this->db->select("*")->from("zoom_alloc")
->join('panel', 'panel.id=zoom_alloc.panel_id','right')


->join('Applyed_Cources', 'Applyed_Cources.main_course_id=zoom_alloc.main_course_id  AND Applyed_Cources.applied_course_id=zoom_alloc.app_course_id','right')
->where("zoom_alloc.student_id",$user_id)
->where("zoom_alloc.publish_link",1)
->where("Applyed_Cources.user_id",$user_id)
->order_by('panel.start_date','ASC')

->get();

$data['interview'] = $m->result();


//print_r($data);

 $this->load->view('Home/template/head');
$this->load->view('Home/site/interview_pg',$data);
$this->load->view('Home/template/footer');  
 


    }


}
