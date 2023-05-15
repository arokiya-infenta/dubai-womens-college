<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Useracadamic
{
    private $CI;

    function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }
	
	public function functionName($id)
    {
        $fees= $this->CI->db->select("*")->from("stu_user")->where("u_id",$id)
        ->get();
       return $fees->result();
	}

    public function studentAcadamicYear($id){

        $fees= $this->CI->db->select("*")->from("stu_user")->where("u_id",$id)->get();
        $details = $fees->result();

        $Syear =date("Y",strtotime( $details[0]->u_date));
        $Cyear =date("Y");

        $currentYear = $Cyear - $Syear;
        if($currentYear==0){
        return 1;
        }elseif($currentYear==1){
            return 2;
        }elseif($currentYear==3){
            return 3;
        }else{
            return 0;
        }
    }
    public function studentAcadamicFeesTable($id){

        $fees= $this->CI->db->select("*")->from("stu_user")->where("u_id",$id)->get();
        $details = $fees->result();

        $Syear =date("Y",strtotime( $details[0]->u_date));
        $Cyear =date("Y");

        $currentYear = $Cyear - $Syear;
        if($currentYear==0){
        return "fees_master";
        }elseif($currentYear==1){
            return "fees_master";
        }elseif($currentYear==3){
            return "fees_master2";
        }else{
            return 0;
        }
    }

    public function selectStudentTable($stuid,$short_id){

         $sortlistedC = $this->CI->db
       ->select("*")
       ->from("shotlisted_candidate")
       ->where(
           "sl_student_id",
           $stuid
       )
       ->where("principal_published", 0)
       ->where("sl_id", $short_id)
       ->get();

       if( $sortlistedC->num_rows() > 0){
        $res= $sortlistedC->result();


if($res[0]->sl_main_id == 5    && $res[0]->sl_course_id == 1){

$table_select = "name,main_5_app_1,due_date,penalty,gst_stat,gst_val,status,id";

}elseif($res[0]->sl_main_id == 5    && $res[0]->sl_course_id == 2){

    $table_select = "name,main_5_app_2,due_date,penalty,gst_stat,gst_val,status";
    
}else{
    $table_select = "";

}


return $table_select;

       }else{
           return false;
       }
    }


public function feesType($main_cour_id,$app_cours_id){

    $sortlistedC = $this->CI->db
    ->select("f_name")->from("accounts_fee_master")->where("main_id",$main_cour_id)->where("cour_id",$app_cours_id)->where("f_status",1)->get()->result_array();
return $sortlistedC;

}

public function year($main_cour_id,$app_cours_id){



    $sortlistedC = $this->CI->db
    ->select("year")->from("accounts_fee_master")->where("main_id",$main_cour_id)->where("cour_id",$app_cours_id)->group_by('year')->where("f_status",1)->get()->result_array();
return $sortlistedC;


}
public function batch($main_cour_id,$app_cours_id){


    $sortlistedC = $this->CI->db
    ->select("batch")->from("accounts_fee_master")->where("main_id",$main_cour_id)->where("cour_id",$app_cours_id)->group_by('batch')->where("f_status",1)->get()->result_array();
return $sortlistedC;




}








    
}
