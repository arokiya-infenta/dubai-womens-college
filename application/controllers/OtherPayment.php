<?php
defined("BASEPATH") or exit("No direct script access allowed");
use Dompdf\Dompdf;
use Dompdf\Options;
class OtherPayment extends CI_Controller
{

  public function __construct()
  {
      parent::__construct();
			date_default_timezone_set('Asia/Calcutta');
			ini_set('display_errors', 0);
			
			if($this->user_agent() != "pc"){


				$this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
				 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				 <strong> Sorry ! '.$this->session->userdata('user')['user_name'].'</strong> Please Login Through your Laptop or Personal Computer To complete the online transaction.
			 </div>');
				 redirect('MyExamination/', 'refresh');
				 exit;
		 
				}
  }
	public function condanationMakePayment(){

		$id= $this->uri->segment(3);
		
		
		if($id==0 || $id=="" || $id==null){
		
			redirect('MyExamination/CondonationFees');
		
		}else{
		
			$sub_imp =[];
		
			$nd = $this->db->select("*")->from('condanation_fee_transaction')->where('id',$id)->get()->result();
		
		$sub = $nd[0]->subject_id;


		$sub_imp = explode(',',$sub);
		$att_tot =$this->db->select("*")
				->from("erp_subjectmaster")
				
				->where_in("erp_subjectmaster.id",$sub_imp)
					->get()->result();
		
		$department_details = $this->db->select("comp_name")->from("department_details")->where("main_id",$nd[0]->stream)->where("cour_id",$nd[0]->department)->get()->result();
			
		
					$data['transaction'] = $nd;
					$data['subject'] = $att_tot;
					$data['department'] = $department_details[0]->comp_name;
		
		
		}
		
		
		$this->load->view("Home/template/head");
		$this->load->view("Home/site/pg/condanation_transaction",$data);
		$this->load->view("Home/template/footer"); 
		
		
		
		
		
			}
			public function user_agent(){
				$iPod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
				$iPhone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
				$iPad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
				$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
				file_put_contents('./public/upload/install_log/agent',$_SERVER['HTTP_USER_AGENT']);
				if($iPad||$iPhone||$iPod){
						return 'ios';
				}else if($android){
						return 'android';
				}else{
						return 'pc';
				}
		}
		
}
