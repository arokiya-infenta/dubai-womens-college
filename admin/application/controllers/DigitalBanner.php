<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DigitalBanner extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	//  error_reporting(0);
	  date_default_timezone_set("Asia/Calcutta");
	  
	
	}

    public function index(){


        $anc = $this->db->select('*')->from("digital_board_announcement")->where("status",1)->get();
        $data['announcements'] = $anc->result();
        $countano= $anc->num_rows();
    
        $not = $this->db->select('*')->from("digital_board_notification")->where('status',1)->get();
        $data['notification'] = $not->result();

        $countnot= $not->num_rows();
    
        $gal = $this->db->select('*')->from("digital_board_image")->where('image_status',1)->get();
        $data['gallery'] = $gal->result();
        

        
        $vid = $this->db->select('*')->from("digital_board_video")->where('status',1)->get();
        $data['videos'] = $vid->result();
  $countvid= $vid->num_rows();


        if( $countano ==0 && $countnot == 0 && $countvid==0 ){

        	redirect("DigitalBanner/imaGe/" , "refresh");
      }else{
        $this->load->view('digital/index',$data);
      
      }


      


    }

    public function imaGe(){


    
  
      $gal = $this->db->select('*')->from("digital_board_image")->where('image_status',1)->get();
      $data['gallery'] = $gal->result();
      
      
   

      $this->load->view('digital/image',$data);


  }
}
