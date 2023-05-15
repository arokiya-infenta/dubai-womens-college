<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Useracadamic
{
    private $CI;

    function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }
	
	public function acadamicYear()
    {
        $fees= $this->CI->db->select("*")->from("acadamic_year")
        ->get();
       return $fees->result();
	}

   








    
}