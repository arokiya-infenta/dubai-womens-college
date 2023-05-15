<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PgDiploma extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	//  error_reporting(0);
	  date_default_timezone_set("Asia/Calcutta");
	  $this->load->library('upload');
	  $this->load->config('email');
		$this->load->library('email');
	  
		$this->load->library('pdf');

	}

    public function index(){


$this->load->view('template/diploma/header');
$this->load->view('template/diploma/menubar');
$this->load->view('template/diploma/headerbar');
$this->load->view('diploma/dashbord');
$this->load->view('template/diploma/footer');



    }
    public function NonAppliedStudent(){

$arr = [];


$sta =$this->db->select("user_id")->from("Applyed_Master")->where("main_course_priority","DIP")->get();

$applied_stu =$sta->result_array();

$arr = array_column($applied_stu, "user_id");

$st =$this->db->select("*")->from("stu_user")->where("u_course",3)->where_not_in("u_id",$arr)->get();
$data['NonUser'] = $st->result();




        $this->load->view('template/diploma/header');
        $this->load->view('template/diploma/menubar');
        $this->load->view('template/diploma/headerbar');
        $this->load->view('diploma/NonApplideStudent',$data);
        $this->load->view('template/diploma/footer'); 




    }



public function studentApplied(){


    $sta =$this->db->select("user_id")->from("Applyed_Cources")->where("applied_course_id",$this->session->userdata('user')['user_dep_status'])->get();




    $applied_stu =$sta->result_array();

    $arr = array_column($applied_stu, "user_id");
    
    $st =$this->db->select("*")->from("stu_user")->where("u_course",3)->where_in("u_id",$arr)->get();
    $data['student'] = $st->result();





  //  $data['student'] =$sta->result();

    $this->load->view('template/diploma/header');
    $this->load->view('template/diploma/menubar');
    $this->load->view('template/diploma/headerbar');
    $this->load->view('diploma/appliedStudent',$data);
    $this->load->view('template/diploma/footer'); 


}



}
