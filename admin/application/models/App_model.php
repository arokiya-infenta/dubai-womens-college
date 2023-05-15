<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_model extends CI_Model {
	
	public $current_date;

	public function __contstruct(){

		parent :: __construct();

		$this->current_date = date('Y-m-d');

	}
	public function login($user,$pass){
		
	$query =$this->db->select('*')
          ->from('admin')
        //  ->where("(user.u_mobile = '$user' OR user.u_email = '$user')")
         // ->where("(user.u_mobile = '$user' OR user.u_email = '$user')")
          ->where('ad_email', $user)
          ->where('ad_password', $pass)
         // ->where('ad_status', 1)
		  ->get();
		$query_r = $query->num_rows();
		$result = $query->result();
		
		if($query_r > 0) {

			return $result;
		}else{
			
			return false;
		}
	}}