<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Messi_App_model extends CI_Model {
	
	public $current_date;
    public $db2;
	public function __contstruct(){

		parent :: __construct();
      
		$this->current_date = date('Y-m-d');
        $this->db2 = $this->load->database('database2', TRUE);
	}

    public function totalTrans(){
        $db2 = $this->load->database('database2', TRUE);
        $arr=array();
        /*  $query = $this->db2->select("trans_details.*,fees.name AS fees_name")->from("trans_details")
        ->join("category", 'category.id = trans_details.category_id','right')
        ->join("fees", 'fees.id = trans_details.fees_id','right')->where('trans_details.paid_status',1)
        ->order_by('id','DESC')
        ->get(); 
       return  $query->result(); */
       $m =   $this->db->select("af_messi_reference")->from("accounts_fees_transaction")->where("af_generated_by",2)->get()->result_array();
       $arr = array_column($m,"af_messi_reference");


/* 
       print_r($arr);
       exit;  */
       if(is_array($arr) && count($arr) > 0){
        $q = $db2->select("trans_details.id AS tran_id,trans_details.name AS studentname,trans_details.*,fees.name AS fees_name,category.name,category.id AS cat_id")->from("trans_details")
        ->join("category", 'category.id = trans_details.category_id','left')
        ->join("fees", 'fees.id = trans_details.fees_id','right')
        ->where_not_in("trans_details.id",$arr)
        ->where('trans_details.paid_status',1)
       ->order_by('trans_details.id','DESC')
       ->get(); 
    }else{

        $q = $db2->select("trans_details.id AS tran_id,trans_details.name AS studentname,trans_details.*,fees.name AS fees_name,category.name,category.id AS cat_id")->from("trans_details")
        ->join("category", 'category.id = trans_details.category_id','left')
        ->join("fees", 'fees.id = trans_details.fees_id','right')
        ->where('trans_details.paid_status',1)
       ->order_by('trans_details.id','DESC')
       ->get(); 



    }
       

    
      
       
       
        
       return  $q->result();

    }
    public function messiTransiD($id){


         
    $db2 = $this->load->database('database2', TRUE);

       $q = $db2->select("trans_details.id AS tran_id,trans_details.name AS studentname,trans_details.*,fees.name AS fees_name,category.name,category.id AS cat_id")->from("trans_details")
       ->join("category", 'category.id = trans_details.category_id','left')
       ->join("fees", 'fees.id = trans_details.fees_id','right')->where('trans_details.paid_status',1)
       //->order_by('trans_details.id','DESC')
       ->where('trans_details.id',$id)
       ->get(); 
        
       return  json_encode($q->result());

    }
    public function messiTransIiD($id){


         
        $db2 = $this->load->database('database2', TRUE);



     
     
     
     $q = $db2->select("trans_details.id AS tran_id,trans_details.name AS studentname,trans_details.*,fees.name AS fees_name,category.name,category.id AS cat_id")->from("trans_details")
           ->join("category", 'category.id = trans_details.category_id','left')
           ->join("fees", 'fees.id = trans_details.fees_id','right')->where('trans_details.paid_status',1)
           //->order_by('trans_details.id','DESC')
           ->where('trans_details.id',$id)
           ->get(); 
            
           return  $q->result();
    
        }

        public function accountFees($id){


            $q = $this->db->select("*")
            ->from("accounts_fee_master")
            ->join("department_details","accounts_fee_master.main_id = department_details.main_id AND accounts_fee_master.cour_id = department_details.cour_id")
           // ->where("accounts_fee_master.f_status",1)
            ->where("accounts_fee_master.f_id",$id)
            ->get(); 
                
               return  $q->result();
        
            }





}
