<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

  public $current_date;

	public function __contstruct(){

		parent :: __construct();

		$this->current_date = date('Y-m-d');

	}

 public function studentApplied(){

	$this->db->select("*");
	$this->db->from("department_details");
	
$r =		$this->db->get()->result();


foreach ($r as $key => $value) {

	$this->db->select("* ,SUM(Applyed_Cources.cour_id ='".$value->cour_id."') AS ..");
	$this->db->from("Applyed_Cources");
	$this->db->where("applied_date",">",$this->session->userdata("user")["user_aca_year"]."/04/01");
	$this->db->where("applied_date","<",$this->session->userdata("user")["user_aca_year"]+1 ."/04/01");
	$this->db->where("main_course_id",$value->main_id);
	$this->db->where("applied_course_id",$value->cour_id);
	
$r =		$this->db->get()->result();

	
}


 }






}
