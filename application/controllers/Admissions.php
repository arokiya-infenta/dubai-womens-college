<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Admissions extends CI_Controller
{
    private $CI;
    public function __construct()
    {
        parent::__construct();
        //.error_reporting(0);
        //ini_set('display_errors', 0);
       $this->load->helper("useracadamic");
  /*      $this->CI = & get_instance();
       $this->CI->load->library("useracadamic"); */
      
       date_default_timezone_set('Asia/Calcutta');

   
    }
    public function index()
    {

        if(!isset($this->session->userdata('user')['user_id'])){
            redirect('Home/logOut', 'refresh');
            exit;
        } 
        $user_id = $this->session->userdata('user')['user_id'];
        $m_course = $this->session->userdata('user')['user_m_course'];
       
    
        if($m_course == 1){
                
            $this->load->view('Home/template/head_ug');
            $this->load->view('Home/site/ug/admission');
            $this->load->view('Home/template/footer');
        
        }else if($m_course == 2){
        
            $this->load->view('Home/template/head');
            $this->load->view('Home/site/pg/admission');
            $this->load->view('Home/template/footer');
      
        }else if($m_course == 3){
    
    
       
		$this->load->view('Home/template/head');
		$this->load->view('Home/site/dip/admission');
		$this->load->view('Home/template/footer');
	
    
    
    
    
        }else{
    
    
            
    
    
    
        }
    
    

    }
   





}
