<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dataimport extends CI_Controller {

	public function __construct()
	{
	parent::__construct();
	}


	public function index(){


		
	}
  public function erpstudentMerge(){

$arr =array(15,16);

    $resu = $this->db->select("*")->from("erp_existing_students")->where_in('dp_id',$arr)->where('admitted_batch',2020)->get()->result();
    
  /*   echo"<pre>";
   print_r($resu);
   exit; */
    
    $ug = 1;
    $pg =1;
    $pgd =1;
    $other =1;
    foreach($resu as $res){
    
    if($res->main_id == 1 ||$res->main_id == 2 || $res->main_id == 3 ){
    
    $pg++;
    
    if($res->mobile_number_ != ""){
    
      $mobile= $res->mobile_number_;
    
    }else{
    
      $mobile= rand(0,9999999999);
    
    }
    
    $array =array(
    "u_course"=>2,
    "u_name"=>$res->student_name_,
    "u_pass"=>md5("123456"),
    "u_email_id"=>$res->email_,
    "u_mobile"=>$mobile,
    "u_year"=>substr($res->batch_,0,4),
    
    );
    
    print_r($array);
    
    
    
    }else if( $res->main_id == 4){
      if($res->mobile_number_ != ""){
    
        $mobile= $res->mobile_number_;
      
      }else{
      
        $mobile= rand(0,9999999999);
      
      }
      $array =array(
        "u_course"=>3,
        "u_name"=>$res->student_name_,
        "u_pass"=>md5("123456"),
        "u_email_id"=>$res->email_,
        "u_mobile"=>$mobile,
        "u_year"=>substr($res->batch_,0,4),
        
        );
     
     
        print_r($array);
     
     
     
      $pgd++;
    
    
    }else if( $res->main_id == 5){
    
      if($res->mobile_number_ != ""){
    
        $mobile= $res->mobile_number_;
      
      }else{
      
        $mobile= rand(0,9999999999);
      
      }
      $array =array(
        "u_course"=>1,
        "u_name"=>$res->student_name_,
        "u_pass"=>md5($mobile),
        "u_email_id"=>$res->email_,
        "u_mobile"=>$mobile,
        "u_year"=>substr($res->batch_,0,4),
        "u_semester"=>5,
        
        );
    
    
        $this->db->insert('stu_user', $array); 
        $lastId = $this->db->insert_id();
    
    
        echo"<pre>";
        print_r($resu);
        
        $pre = array(
          'pr_user_id'=>$lastId,
          'pr_created'=>date("Y-m-d H:i:s"),
          'pr_applicant_name'=>$res->student_name_,
        );
        
        $sub_pre = array(
          'sb_u_id'=>$lastId,
        );
        
        $this->db->insert('new_preview',$pre);
        $this->db->insert('sub_preview',$sub_pre);




    
    $sortlisted = array(
      'sl_student_id'=>$lastId,
      'sl_main_id'=>5,
    
      'sl_course_id'=>$res->cour_id,
      'sl_caste'=>$res->community_,


      'selection_list_name'=>"MERIT",
      'reservation_status'=>1,
      'selection_list'=>1,
      'published'=>1,
      'principal_published'=>1,
      'created'=>date('2020-7-11 09:00:00'),
      'published_date'=>date('2020-7-11 09:00:00'),
      'principal_date'=>date('2020-7-11 09:00:00'),
    );
    $this->db->insert('shotlisted_candidate', $sortlisted); 
    $lastIdsort = $this->db->insert_id();
if($lastIdsort){
    $admitted = array(
      'as_name'=>$res->student_name_,
      'as_app_number'=>substr($res->batch_,-9),
      //'as_blood_gp'=>,
      'as_quata'=>"MERIT",
      'as_reg_num'=>$res->reg_no_,
      'as_dep'=>$res->short_name,
      'as_status'=>1,
    
      'as_student_id'=>$lastId,
      'as_shotlist_ref_number'=>$lastIdsort,
      'year'=>2020,
    );
    $this->db->insert('admitted_student', $admitted); 
  } 
        print_r($array);
      $ug++;
    
    }else{
    
    
    $other++;
    
    
    }
    
    
    
    
    
    
    }
    echo $ug."<br>";
    echo $pg ."<br>";
    echo $pgd ."<br>";
    echo $other."<br>";
    
    }


    public function updateuserId(){

      $arr =array(15,16);
      $resu = $this->db->select("*")->from("erp_existing_students")->where_in('dp_id',$arr)->where('admitted_batch',2020)->get()->result();

foreach ($resu as $key => $value) {



  $us = $this->db->select("*")->from("admitted_student")->where_in('as_reg_num',$value->reg_no_)->where('year',2020)->get()->result();


$data = array(
  'student_id'=>$us[0]->as_student_id,

);

 $this->db->where('id',$value->id);
 $this->db->update('erp_existing_students',$data);
}



    }

}