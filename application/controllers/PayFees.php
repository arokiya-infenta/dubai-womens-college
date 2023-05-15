<?php
defined("BASEPATH") or exit("No direct script access allowed");

class PayFees extends CI_Controller
{
    private $CI;
    public function __construct()
    {
        parent::__construct();
        //.error_reporting(0);
        ini_set('display_errors', 0);
       $this->load->helper("useracadamic");
  /*      $this->CI = & get_instance();
       $this->CI->load->library("useracadamic"); */
      
       date_default_timezone_set('Asia/Calcutta');
       $this->load->library('Pdf');
     /*   include APPPATH . 'third_party/payment/TransactionRequestBean.php';	
       include APPPATH . 'third_party/payment/TransactionResponseBean.php'; */

       /*  if (!isset($this->session->userdata("user")["user_id"])) {
            $this->session->unset_userdata("user");
            $this->session->unset_userdata("user_exam");
            redirect("Home", "refresh");
        } */
    }
    public function index()
    {
      if (!isset($this->session->userdata("user")["user_id"])) {
        $this->session->unset_userdata("user");
        //$this->session->unset_userdata("user_exam");
        redirect("Home/dashBoard", "refresh");
    }
		
		$stu_fee = $this->db->select("shotlisted_candidate.*,department_details.*")->from("shotlisted_candidate")
    
			->join('department_details', 'shotlisted_candidate.sl_main_id = department_details.main_id AND shotlisted_candidate.sl_course_id = department_details.cour_id')
			->where("sl_student_id",$this->session->userdata("user")["user_id"])
			->where("shotlisted_candidate.principal_published",1)
			->where("shotlisted_candidate.reservation_status",1)
			->get();
			$eligble_stud = $stu_fee->num_rows();


			if($eligble_stud  > 0){


		$stud_id = $this->db->select("admitted_student.*,shotlisted_candidate.*,department_details.*")->from("shotlisted_candidate")
    
    ->join('department_details', 'shotlisted_candidate.sl_main_id = department_details.main_id AND shotlisted_candidate.sl_course_id = department_details.cour_id')
    ->join('admitted_student', 'shotlisted_candidate.sl_id = admitted_student.as_shotlist_ref_number ')
    ->where("sl_student_id",$this->session->userdata("user")["user_id"])
		->where("shotlisted_candidate.principal_published",1)
		->where("shotlisted_candidate.reservation_status",1)
    //->where("sl_student_id",$this->session->userdata("user")["user_id"])
		->get();
   
     $rests = $stud_id->num_rows();


		if($rests > 0){

			$rest = $stud_id->result();
			
		}else{


			$stud_id = $this->db->select("shotlisted_candidate.*,department_details.*")->from("shotlisted_candidate")
    
			->join('department_details', 'shotlisted_candidate.sl_main_id = department_details.main_id AND shotlisted_candidate.sl_course_id = department_details.cour_id')
			->where("sl_student_id",$this->session->userdata("user")["user_id"])
			->where("shotlisted_candidate.reservation_status",1)
			->where("shotlisted_candidate.principal_published",1)
			->get();
			$rest = $stud_id->result();
	

		}
	//	print_r($rest);

		

 /*   $stud_id = $this->db->select("shotlisted_candidate.*,department_details.*")->from("shotlisted_candidate")
    
    ->join('department_details', 'shotlisted_candidate.sl_main_id = department_details.main_id AND shotlisted_candidate.sl_course_id = department_details.cour_id')
    ->where("sl_student_id",$this->session->userdata("user")["user_id"])->get();
    $rest = $stud_id->result();

//   print_r($rest);
// exit; 


*/
    if($rest[0]->sl_main_id == 5){

        $data['selected'] = $rest;
        $this->load->view("Home/template/head_ug");
        $this->load->view("Home/site/fees/fees_details", $data);
        $this->load->view("Home/template/footer_ug");

    }elseif($rest[0]->sl_main_id == 1){

      $data['selected'] = $rest;
      $this->load->view("Home/template/head");
      $this->load->view("Home/site/fees/fees_details", $data);
      $this->load->view("Home/template/footer");

    }else if($rest[0]->sl_main_id == 2){

			$data['selected'] = $rest;
      $this->load->view("Home/template/head");
      $this->load->view("Home/site/fees/fees_details", $data);
      $this->load->view("Home/template/footer");




    }else if($rest[0]->sl_main_id == 3){


			$data['selected'] = $rest;
      $this->load->view("Home/template/head");
      $this->load->view("Home/site/fees/fees_details", $data);
      $this->load->view("Home/template/footer");



    }else if($rest[0]->sl_main_id == 4){






			
    }else{






    } 

	}else{
		$this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>You cannot pay Fees Now !</strong> Only Shortlisted and admitted student can pay fees.
		</div>');
		

		redirect("Home/dashBoard", "refresh");

	}

    }
public function CompletepayUg()
{
if (!isset($this->session->userdata("user")["user_id"])) {
            $this->session->unset_userdata("user");
            //$this->session->unset_userdata("user_exam");
            redirect("Home/dashBoard", "refresh");
}

$mainid = $this->uri->segment(3);
$courid = $this->uri->segment(4);




$data['batch']= $this->db
->select("batch")->from("accounts_fee_master")->where("main_id",$mainid)->where("cour_id",$courid)->order_by('batch','DESC')->group_by('batch')->where("f_status",1)->get()->result();



$data['year']= $this->db
->select("year")->from("accounts_fee_master")->where("main_id",$mainid)->where("cour_id",$courid)->group_by('year')->where("f_status",1)->get()->result_array();

$this->load->view("Home/template/head");
$this->load->view("Home/site/fees/dep_fees", $data);
$this->load->view("Home/template/footer_ug"); 

}


public function SelectYear(){
  if (!isset($this->session->userdata("user")["user_id"])) {
      $this->session->unset_userdata("user");
      $this->session->unset_userdata("user_exam");
      redirect("Home/dashBoard", "refresh");
  }

$batch = $this->input->post("batch");

$main_c_id =$this->input->post("main_c_id");
$apply_c_id =$this->input->post("apply_c_id");

$q =  $this->db->select("year")->from("accounts_fee_master")->where("batch",$batch)->where("main_id",$main_c_id)->where("cour_id",$apply_c_id)->where("f_status",1)->group_by('year')->get();

$m=$q->num_rows();
if($m > 0){
  $r =$q->result_array();

$html ="<option value=''>Select Year</option>";

foreach ($r as $key => $value) {

   
  if($value['year'] == 1 ){
    $year = "First Year";
    
        }else if($value['year'] == 2){
    
            $year = "Second Year";
    
        }else{
            $year = "Third Year";
    
        }


 $html .= "<option value='".$value['year']."'>".$year."</option>";
}

echo $html;
}else{

  $html ="<option value=''>No year Created </option>";

}
}public function SelectAcadamicBatch(){
  if (!isset($this->session->userdata("user")["user_id"])) {
      $this->session->unset_userdata("user");
      $this->session->unset_userdata("user_exam");
      redirect("Home/dashBoard", "refresh");
  }

$year = $this->input->post("year");

$main_c_id =$this->input->post("main_c_id");
$apply_c_id =$this->input->post("apply_c_id");

$q =  $this->db->select("batch")->from("accounts_fee_master")->where("year",$year)->where("main_id",$main_c_id)->where("cour_id",$apply_c_id)->where("f_status",1)->group_by('batch')->get();

$m=$q->num_rows();
if($m > 0){
  $r =$q->result_array();

$html ="<option value=''>Select batch</option>";

foreach ($r as $key => $value) {
 $html .= "<option value='".$value['batch']."'>".$value['batch']."</option>";
}

echo $html;
}else{

  $html ="<option value=''>No batch Created </option>";

}
}
public function SelectCategory(){
  if (!isset($this->session->userdata("user")["user_id"])) {
      $this->session->unset_userdata("user");
      $this->session->unset_userdata("user_exam");
      redirect("Home/dashBoard", "refresh");
  }

$year = $this->input->post("year");
$main_c_id =$this->input->post("main_c_id");
$apply_c_id =$this->input->post("apply_c_id");
$batch =$this->input->post("batch");


$q =  $this->db->select("f_category")->from("accounts_fee_master")->where("year",$year)->where("main_id",$main_c_id)
->where("batch",$batch)->where("cour_id",$apply_c_id)->where("f_status",1)->group_by('f_category')->get();

$m=$q->num_rows();
if($m > 0){

  $r =$q->result_array();

//print_r($r);
$arr = array_column($r, "f_category");
$cat = $this->db->select("*")->from("accounts_category")->where_in("ac_id",$arr)->get();

$cats = $cat->num_rows();

if($cats > 0 ){

  $cat_edt = $cat->result_array();


  $html ="<option value=''>Select Category</option>";
foreach ($cat_edt as $key => $value) {
 $html .= "<option value='".$value['ac_id']."'>".$value['ac_name']."</option>";
}
//echo $html;


}else{

  $html ="<option value=''>No Category Created </option>";
}


}else{

  $html ="<option value=''>No Category Created </option>";

}
echo $html;
}
public function selectPaymentType(){

  if (!isset($this->session->userdata("user")["user_id"])) {
    $this->session->unset_userdata("user");
    $this->session->unset_userdata("user_exam");
    redirect("Home/dashBoard", "refresh");
}

$year = $this->input->post("year");
$main_c_id =$this->input->post("main_c_id");
$apply_c_id =$this->input->post("apply_c_id");
$batch =$this->input->post("batch");
$category =$this->input->post("category");

$q =  $this->db->select("f_name")->from("accounts_fee_master")->where("year",$year)->where("batch",$batch)->where("main_id",$main_c_id)->where("cour_id",$apply_c_id)->where("f_status",1)->get();

$m=$q->num_rows();


}
public function SelectPayment(){
  if (!isset($this->session->userdata("user")["user_id"])) {
    $this->session->unset_userdata("user");
    $this->session->unset_userdata("user_exam");
    redirect("Home/dashBoard", "refresh");
}

  $year = $this->input->post("year");
  $batch =$this->input->post("batch");
  $main_c_id =$this->input->post("main_c_id");
  $apply_c_id =$this->input->post("apply_c_id");
  $category =$this->input->post("category");

  $q =  $this->db->select("payment_type")->from("accounts_fee_master")->where("year",$year)->where("batch",$batch)->where("f_category",$category)
  ->where("main_id",$main_c_id)->where("cour_id",$apply_c_id)->where("f_status",1)->group_by('payment_type')->get();

  $m=$q->num_rows();
    if($m > 0){
      $r =$q->result_array();
  
  $html ="<option value=''>Select Fees</option>";
  
  foreach ($r as $key => $value) {
    if($value['payment_type']==1){

      $var = "Full Payment";

    }else{
      $var = "Installment Payment";

    }
     $html .= "<option value='".$value['payment_type']."'>".$var."</option>";
  }
  
  echo $html;
    }else{
  
      $html ="<option value=''>No Payment Type created </option>";
  
    }

}

public function SelectPaymentfees(){
  if (!isset($this->session->userdata("user")["user_id"])) {
    $this->session->unset_userdata("user");
    $this->session->unset_userdata("user_exam");
    redirect("Home/dashBoard", "refresh");
}

  $year = $this->input->post("year");
  $batch =$this->input->post("batch");
  $main_c_id =$this->input->post("main_c_id");
  $apply_c_id =$this->input->post("apply_c_id");
  $category =$this->input->post("category");
  $payment =$this->input->post("payment");




  
  
  
  
  $install =  $this->db->select("*")->from("accounts_fees_transaction")->where("af_category_id",$category)
  ->where("af_main_id",$main_c_id)->where("af_course_id",$apply_c_id)->where("af_student_id",$this->session->userdata("user")["user_id"])->where("af_paid_status",1)->get();

$inss =$install->num_rows();

if($inss == 0){
  $q =  $this->db->select("*")->from("accounts_fee_master")->where("year",$year)->where("batch",$batch)->where("f_category",$category)
  ->where("main_id",$main_c_id)->where("cour_id",$apply_c_id)->where("payment_type",$payment)->where("f_status",1)->get();  
  $m=$q->num_rows();
  if($m > 0){
    $r =$q->result_array();

$html ="<option value=''>Select Fees</option>";

foreach ($r as $key => $value) {
   $html .= "<option value='".$value['f_name']."'>".$value['f_name']."</option>";
}

echo $html;
  }else{

    $html ="<option value=''>No Fees Created </option>";

  }

}else{

  $inssm =$install->result();
  $q =  $this->db->select("*")->from("accounts_fee_master")->where("year",$year)->where("batch",$batch)->where("f_category",$category)
  ->where("main_id",$main_c_id)->where("cour_id",$apply_c_id)->where("payment_type",$inssm[0]->af_installment_id)->where("f_status",1)->get();  
  $m=$q->num_rows();
  if($m > 0){
    $r =$q->result_array();

$html ="<option value=''>Select Fees</option>";

foreach ($r as $key => $value) {
   $html .= "<option value='".$value['f_name']."'>".$value['f_name']."</option>";
}

echo $html;
  }else{

    $html ="<option value=''>No Fees Created </option>";

  }
}

}


public function SelectAcadamicFees(){
    if (!isset($this->session->userdata("user")["user_id"])) {
        $this->session->unset_userdata("user");
        $this->session->unset_userdata("user_exam");
        redirect("Home/dashBoard", "refresh");
    }

$year = $this->input->post("year");
$batch =$this->input->post("batch");
$main_c_id =$this->input->post("main_c_id");
$apply_c_id =$this->input->post("apply_c_id");

  $q =  $this->db->select("f_name")->from("accounts_fee_master")->where("year",$year)->where("batch",$batch)->where("main_id",$main_c_id)->where("cour_id",$apply_c_id)->where("f_status",1)->get();

$m=$q->num_rows();
  if($m > 0){
    $r =$q->result_array();

$html ="<option value=''>Select Fees</option>";

foreach ($r as $key => $value) {
   $html .= "<option value='".$value['f_name']."'>".$value['f_name']."</option>";
}

echo $html;
  }else{

    $html ="<option value=''>No Fees Created </option>";

  }
}


public function SelectFeesToPaid(){


    if (!isset($this->session->userdata("user")["user_id"])) {
        $this->session->unset_userdata("user");
        $this->session->unset_userdata("user_exam");
        redirect("Home/dashBoard", "refresh");
    }
    $html ="";
$year = $this->input->post("year");
$batch =$this->input->post("batch");
$main_c_id =$this->input->post("main_c_id");
$apply_c_id =$this->input->post("apply_c_id");
$fees =$this->input->post("fees");

  $q =  $this->db->select("*")->from("accounts_fee_master")->where("year",$year)
  ->where("batch",$batch)->where("main_id",$main_c_id)
  ->where("cour_id",$apply_c_id)
  ->where("f_name",$fees)
  ->where("f_status",1)->get();

    $m=$q->num_rows();



  if($m > 0){





    $r =$q->result();


   $t = $this->db->select("*")->from("accounts_fees_transaction")->where("af_paid_status",1)->where("af_fees_id",$r[0]->f_id)->where("af_student_id",$this->session->userdata("user")["user_id"])->or_where('af_reg_number',$this->session->userdata("user")["user_id"])->get();

   $me = $t->num_rows();

    if($me == 1 ){


      $html .='<div class="row">
      
      <div class="col-md-12 text-center text-uppercase font-weight-bold text-success text_s"> <a class="text-success" href="'.base_url().'PayFees/viewMyReciept"> Fees Already Paid </a>
      </div>
      </div>';


    }else{


      $html .='<div class="row">
      <label class="col-md-6 mb-3"  for="validationCustom04">Discription :</label>
      <div class="col-md-6 mb-9 text_s">  '.
      $r[0]->f_discription.' 
      </div>
      </div>';
$html .='<div class="row">
<label class="col-md-6 mb-3"  for="validationCustom04">Amount :</label>
<div class="col-md-6 mb-9 text_s"> ₹ '.
$r[0]->f_amount.' 
</div>
</div>';

if($r[0]->f_gst == 1 && $r[0]->f_perc != 0  && $r[0]->f_gst_amt != 0 ){
    
$html .='<div class="row">

<label class="col-md-6 mb-3"  for="validationCustom04">GST Percentage :</label>
<div class="col-md-6 mb-9 text_s">'.
$r[0]->f_perc .' % 
</div>
</div>';$html .='<div class="row">

<label class="col-md-6 mb-3"  for="validationCustom04">GST Amount :</label>
<div class="col-md-6 mb-9 text_s"> ₹ '.
$r[0]->f_gst_amt.'
</div>
</div>';


}

if($r[0]->f_instalment == 1  ){
    
 $html .='<div class="row">
  
  <label class="col-md-6 mb-3"  for="validationCustom04">Installment Amount :</label>
  <div class="col-md-6 mb-9 text_s"> ₹ '.
  $r[0]->f_instalment_fees.'
  </div>
  </div>';
  
  
  }
if($r[0]->f_fine_status == 1 && $r[0]->f_e_date < date("Y-m-d") ){


$startdate =date_create($r[0]->f_e_date); 


$date2 = date_create(date("Y-m-d"));
    $diff = date_diff($startdate , $date2);
  $rupees_fine =$diff->format("%a");
 $fine_amount = $r[0]->f_fine_amount * $rupees_fine;
    $html .='<div class="row">
   
    <label class="col-md-6 mb-3"  for="validationCustom04"> Last Date Without Fine  :</label>
    <div class="col-md-6 mb-9 text_s">'.
    date("d-M-Y",strtotime($r[0]->f_e_date)) .'
    </div>
    </div>';
    
    $html .='<div class="row">
    <label class="col-md-6 mb-3"  for="validationCustom04"> Fine Amount Days :</label>
    <div class="col-md-6 mb-9 text_s">'.
    $rupees_fine.' Days
    </div>
    </div>';

    $html .='<div class="row">
    <label class="col-md-6 mb-3"  for="validationCustom04"> Total Fine Amount:</label>
    <div class="col-md-6 mb-9 text_s"> ₹ '.
    $fine_amount.'
    </div>
    </div>';
    $total = $fine_amount + $r[0]->f_gst_amt + $r[0]->f_amount + $r[0]->f_instalment_fees;
    }else{

        $total =$r[0]->f_gst_amt + $r[0]->f_amount + $r[0]->f_instalment_fees ;
        
    }

    $html .='<div class="row">
    <label class="col-md-6 mb-3"  for="validationCustom04"> Total Fee Amount  :</label>
    <div class="col-md-6 mb-9 text_s"> ₹ '.$total .'
    </div>
    </div>';

    $html .='<div class="row">
    <label class="col-md-6 mb-3"  for="validationCustom04"> <input type="hidden" name="fees_id" value="'.$r[0]->f_id.'"></label>
    <div class="col-md-6 mb-9"><a href="'.base_url().'PayFees/payTransaction/'.$r[0]->f_id.'" type="submit" class="btn btn-primary">Pay '.$total .'</a>
    </div>
    </div>';
  }
    echo $html;

  }else{

    $html ="No Data Found";

  }





}

    public function payTransaction(){

        $id = $this->uri->segment(3);
//print_r($_POST);

$data['fees_details']=$id;

$this->load->view("Home/template/head");
$this->load->view("Home/site/fees/fees_transaction", $data);
$this->load->view("Home/template/footer_ug");

    }
    public function testPayment(){


$this->load->view("Home/site/fees/payment/Worldline");



    }

    public function ResponsePayment(){


      $id = $this->uri->segment(3);


$q = $this->db->select("*")->from("accounts_fees_transaction")
->join("department_details","accounts_fees_transaction.af_main_id = department_details.main_id AND accounts_fees_transaction.af_course_id = department_details.cour_id")
->join("accounts_fee_master","accounts_fees_transaction.af_fees_id = accounts_fee_master.f_id")
->join("accounts_category","accounts_fees_transaction.af_category_id = accounts_category.ac_id")

->where("af_id",$id)->get();

$r =$q->result();


$user = $this->db->select("*")->from("stu_user")->where("u_id",$r[0]->af_student_id)->get();

$res = $user->result();

$session_data = array(
		
	
  'user_id'=> $res[0]->u_id,
  'user_m_course'=> $res[0]->u_course,
  'user_name'=> $res[0]->u_name,
  'user_email_id'=> $res[0]->u_email_id,
  'user_mobile'=> $res[0]->u_mobile,
  'user_email_valid'=> $res[0]->u_email_valid,
  'user_mobile_valid'=> $res[0]->u_mobile_valid,
  'user_mobile_valid'=> $res[0]->u_mobile_valid,
  'user_year'=>$res[0]->u_year,
  );

 $this->session->set_userdata('user', $session_data);





if($r[0]->af_main_id == 5){
  $f_user = $this->db->select("*")->from("new_preview")->where("pr_user_id",$r[0]->af_student_id)->get();
  $dp_user = $f_user->result();
}else if($r[0]->af_main_id == 1 || $r[0]->af_main_id == 2 || $r[0]->af_main_id == 1){

  $f_user = $this->db->select("*")->from("new_preview_pg")->where("pr_user_id",$r[0]->af_student_id)->get();
  $dp_user = $f_user->result();
}else if($r[0]->af_main_id == 4){

  $f_user = $this->db->select("*")->from("new_preview_dip")->where("pr_user_id",$r[0]->af_student_id)->get();
  $dp_user = $f_user->result();

}else{
  if(!isset($this->session->userdata('user')['user_id'])){
		redirect('Home/logOut', 'refresh');
		exit;
} 


}


$reg = $this->db->select("as_reg_num")->from("admitted_student")->where("as_student_id",$r[0]->af_student_id)->get();

$r_mum = $reg->num_rows();


if($r_mum > 0){
  $r_mumr = $reg->result();

$r_number = $r_mumr[0]->as_reg_num;


}else{

  $r_number = date('y',strtotime($this->session->userdata('user')['user_year'])).sprintf("%'04d", $this->session->userdata('user')['user_id']);

}

$update_user = array(
  'af_reg_number'=>$r_number,
);

$this->db->where("af_id",$id);
$this->db->update("accounts_fees_transaction",$update_user);

$Referance="#TNR".sprintf("%'06d", $r[0]->af_id);
if($id != 0){

 
  
  


if($r[0]->af_paid_status == 1){

  $status = "Payment - Success";

}else{

  $status = "Payment - Failed";

}
if($r[0]->af_installment_id == 1){

  $payment = "Payment - Full Payment";

}else{

  $payment = "Payment - Installment Payment";

}

if($r[0]->year == 1){

  $year = "First Year";

}else if($r[0]->year == 2){

  $year = "Second Year";

}else{

$year = "Third Year";

}
$this->load->library('Pdf');
      $thml='
      <HTML>
      <head>
      <style>
      
      body {
        margin-top: 60px;
        margin-bottom: 60px;
      }
      .center {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 100%;
        
        }
  
        footer {
        position: fixed; 
        bottom: 30px; 
        left: 0px; 
        right: 0px;
        height: 50px; 
        }
      </style>
      </head>
          <body class="em_body" style="margin:0px; padding:0px;">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body p-0">
      
      
              
                
                  <div class="col-md-6">
                  <img class="center" src="http://admission.mssw.in//landing/images/mssw_logo.jpg"  height = "100px;">
                  </div>
                
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <h3 style="text-align: center;" >Online Fees Payment Receipt</h3>
                  <br>


                  <br>
                 
                  <p style="text-align: center;"><b>OFFICIAL RECEIPT</b></p>
                  <hr class="my-5">
           




                  <div class="row p-5">
                  <div class="col-md-12">
                    <table class="table" width ="100%">
                    
                        
                   
                      <tbody>
                      <tr>
                          <td><b>Category Fees</b></td>
                          <td><b>Fee Name</b></td>
                         
                        </tr>
                        <tr>
                          <td>'.$r[0]->ac_name.'</td>
                          <td>'.$r[0]->f_name.'</td>
                        </tr>
                        <tr>
                        <td><b>Date</b></td>
                        <td><b>Ref No</b></td>
                       
                      </tr>
                          <tr>
                            <td>'.date("d-M-Y H:i A",strtotime($r[0]->ac_created)).'</td>
                            <td>'.$Referance.'</td>
                          </tr>
                      </tbody>
                    </table>
                
             
                   
                  </div>
                </div>   
                



             
                <p style="text-align: center;"><b>PAYEE DETAILS</b></p>
                <hr class="my-5">
                
                <div class="row p-5">
                <div class="col-md-12">
                  <table class="table" width ="100%">
                
                    <tbody>
                    <tr>
                    <td><b>Student Reg No</b> </td>
                    <td><b>Student Name</b></td>
                   
                  </tr>
                      <tr>
                        <td>'.$r_number.'</td>
                        <td>'.$dp_user[0]->pr_applicant_name.'</td>
                      </tr>
                      <tr>
                      <td ><b>Department</b></td>
                      <td ><b>Batch</b> </td>
                     
                    </tr>
                        <tr>
                          <td>'.$r[0]->comp_name.'</td>
                          <td>'.$year.'</td>
                        </tr>
                    </tbody>
                  </table>
               
                
                 
                </div>
              </div> 
              <p style="text-align: center;"><b>PAYMENT DETAILS </b></p>
                  <hr class="my-5">

              <div class="row p-5">
              <div class="col-md-12">
                <table class="table" width ="100%">
                 
                  <tbody>
                  <tr>
                  <td width="10%" ><b>S No</b> </td>
            
                  <td width="30%" ><b>Payment Type</b></td>
                  <td width="30%" ><b>Payment Status</b></td>
                  <td  width="30%" ><b>Payment Amount</b></td>
                 
                </tr>
                    <tr>
                      <td>1</td>
                      <td>'.$payment.'</td>
                      <td>'.$status.'</td>
                      <td>'.$r[0]->af_fees_total_amt.'</td>
                    </tr>
                  
                  </tbody>
                </table>
              
                <br>
               
              </div>
            </div>

           
                <br>
         
                    <br>
                    <br>
                    <br>
                    <table class="table" width ="100%">
                  
                    <tbody>
                      
                    
                    <tr>
                      <td><b>Amount in Words :'.ucwords($this->convert_number_to_words($r[0]->af_fees_total_amt)).' Only</b></td>
                      
                    </tr>  
                    <tr>
                      <td><p style="text-align: center;">** This official receipt is a digital receipt, no signature is required. All payments done are non-refundable nor transferable.</p></td>
                      
                    </tr>
                    
      
                    </tbody>
                  </table>
                  </div>
                </div>
 
              </div>
            </div>
          </div>
        </div>
  
        <br>
        <br>
  
        <div  style="float: right">
        Treasurer<br>
        MSSW
        </div>
        <br>
        
      </div>
      <footer>
      <p style="text-align: center;">This Receipt is Automatically Generated by MSSW Campus Management System</p>
      </footer>
      </body>
      </HTML>
      ';
          $this->pdf->loadHtml($thml);
          $this->pdf->render();
        $file =	$this->pdf->output();
      
     // $user_name=rand();
      
        file_put_contents("admin/invoice/".$Referance.".pdf",$file);
  
      $path_file= "admin/invoice/".$Referance.".pdf";
  


   $config = array(
        'protocol' => 'smtp', 
        'smtp_host' => 'ssl://smtp.gmail.com', 
        'smtp_port' => 465, 
        'smtp_user' => 'admission.mssw@gmail.com', 
       "smtp_pass" => "dqamafoawpedieqn",
        'mailtype' => 'html', 
        'charset' => 'iso-8859-1'
    );
        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
  
  
  $rupe_s = (float)$r[0]->af_fees_total_amt;
  
  $rupsse = ucwords($this->convert_number_to_words($r[0]->af_fees_total_amt));
  
  $subjecttt ='MSSW - Online Payment Status - Regarding';
  $msg ='Dear '.$dp_user[0]->pr_applicant_name.' ,<br>
  
  You have paid Rs.'.$rupe_s.'(Rupees '. $rupsse.' only) on '.date("d-M-Y H:i A",strtotime($r[0]->ac_created)).' towards '.$r[0]->f_name.'.<br>
  
  The receipt is attached along with this E-mail.<br><br>
  
  For any queries contact:<br><br>
  
  Phone: +91 44 28195126 / 28194566 (10 AM to 4 PM)<br>
  E-Mail: accounts@mssw.in<br>
  
  E-Mail queries will be responded to in two - three working days.<br>';
  
  
        $this->testEmail("yuvaraj@istudiotech.com",$subjecttt,$msg,$path_file);


        $this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Payment Success !</strong> Payment Success.
        </div>');
  
  
    redirect('PayFees', 'refresh');


}else{

	$this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Payment Failed !</strong> Please Try Later .
					</div>');
		
		
			redirect('PayFees', 'refresh');


}

}

public function ResponsePaymentStatus(){

  $id = $this->uri->segment(3);

$q = $this->db->select("*")->from("accounts_fees_transaction")
->join("department_details","accounts_fees_transaction.af_main_id = department_details.main_id AND accounts_fees_transaction.af_course_id = department_details.cour_id")
->join("accounts_fee_master","accounts_fees_transaction.af_fees_id = accounts_fee_master.f_id")
->join("accounts_category","accounts_fees_transaction.af_category_id = accounts_category.ac_id")
->join("Applyed_Cources","accounts_fees_transaction.af_main_id = Applyed_Cources.main_course_id AND accounts_fees_transaction.af_course_id = Applyed_Cources.applied_course_id AND accounts_fees_transaction.af_student_id = Applyed_Cources.user_id")

->where("af_id",$id)->get();

$r =$q->result();


$user = $this->db->select("*")->from("stu_user")->where("u_id",$r[0]->af_student_id)->get();

$res = $user->result();

$session_data = array(


'user_id'=> $res[0]->u_id,
'user_m_course'=> $res[0]->u_course,
'user_name'=> $res[0]->u_name,
'user_email_id'=> $res[0]->u_email_id,
'user_mobile'=> $res[0]->u_mobile,
'user_email_valid'=> $res[0]->u_email_valid,
'user_mobile_valid'=> $res[0]->u_mobile_valid,
'user_mobile_valid'=> $res[0]->u_mobile_valid,
'user_year'=>$res[0]->u_year,
);

$this->session->set_userdata('user', $session_data);





if($r[0]->af_main_id == 5){
$f_user = $this->db->select("*")->from("new_preview")->where("pr_user_id",$r[0]->af_student_id)->get();
$dp_user = $f_user->result();
}else if($r[0]->af_main_id == 1 || $r[0]->af_main_id == 2 || $r[0]->af_main_id == 3){

$f_user = $this->db->select("*")->from("new_preview_pg")->where("pr_user_id",$r[0]->af_student_id)->get();
$dp_user = $f_user->result();
}else if($r[0]->af_main_id == 4){

$f_user = $this->db->select("*")->from("new_preview_dip")->where("pr_user_id",$r[0]->af_student_id)->get();
$dp_user = $f_user->result();

}else{
if(!isset($this->session->userdata('user')['user_id'])){
redirect('Home/logOut', 'refresh');
exit;
} 


}


$reg = $this->db->select("as_reg_num")->from("admitted_student")->where("as_student_id",$r[0]->af_student_id)->get();

$r_mum = $reg->num_rows();


if($r_mum > 0){
$r_mumr = $reg->result();

$r_number = $r_mumr[0]->as_reg_num;


}else{

$r_number = substr( $this->session->userdata('user')['user_year'], -2).sprintf("%'04d", $this->session->userdata('user')['user_id']);

}

$update_user = array(
'af_reg_number'=>$r_number,
);

$this->db->where("af_id",$id);
$this->db->update("accounts_fees_transaction",$update_user);

$Referance="#TNR".sprintf("%'06d", $r[0]->af_id);
if($id != 0){


if($r[0]->af_paid_status == 1){

$status = "Payment - Success";

}else{

$status = "Payment - Failed";

}

if($r[0]->f_perc == 0){

$Gst_per = "N/A";
$Gst_amount = "N/A";

}else{

  $Gst_per = $r[0]->f_perc;
  $Gst_amount = $r[0]->f_gst_amt;

}
if($r[0]->af_installment_id == 1){

$payment = "Payment - Full Payment";

}else{

$payment = "Payment - Installment Payment";

}

if($r[0]->year == 1){

$year = "First Year";

}else if($r[0]->year == 2){

$year = "Second Year";

}else{

$year = "Third Year";

}


if((int)$r[0]->f_fine_status == 1 && $r[0]->f_e_date < date("Y-m-d") ){


  $startdate =date_create($r[0]->f_e_date); 
  
  
  $date2 = date_create(date("Y-m-d"));
      $diff = date_diff($startdate , $date2);
    $rupees_fine =$diff->format("%a");
    (int)$fine_amount = $r[0]->f_fine_amount * $rupees_fine;
   
      
    
      (int)$total = (int)$fine_amount + (int)$r[0]->f_gst_amt + (int)$r[0]->f_amount + (int)$r[0]->f_instalment_fees;
      }else{
        $rupees_fine =0;
          (int) $total = (int)$r[0]->f_gst_amt + (int)$r[0]->f_amount+ (int)$r[0]->f_instalment_fees;
          
      }










$this->load->library('Pdf');
  $thml='
  <HTML>
  <head>
  <style>
  
  body {
    margin-top: 60px;
    margin-bottom: 60px;
  }
  .center {
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 100%;
    
    }
table{
  width:100%;
}

.table td {

  padding :2px;
}
    footer {
    position: fixed; 
    bottom: 30px; 
    left: 0px; 
    right: 0px;
    height: 50px; 
    }
    .alg_r{
      left: 50%; 


    }
    li{
      list-style: none;
    }
  </style>
  </head>
      <body class="em_body" style="margin:0px; padding:0px;">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body p-0">
  
  
          
            
              <div class="col-md-6">
              <img class="center" src="https://admission.mssw.in//landing/images/mssw_logo.jpg"  height = "100px;">
              </div>
            
              <br>
             
              <br>
              <br>
              <h3 style="text-align: center;" >Online Fees Payment Receipt</h3>
              <br/>
              <p style="text-align: center;"><b>PAYEE DETAILS</b></p>
              <hr class="my-5"/>
       

              <div class="row p-5">
              <div class="col-md-12">
              <table>
              <tr>
              <td>Name of the Student</td>
              <td>'.$dp_user[0]->pr_applicant_name.'</td>
              
              </tr>  <tr>
              <td>Department</td>
              <td>'.$r[0]->department.'</td>
              
              </tr>  <tr>
              <td>Program</td>
              <td>'.$r[0]->comp_name.'</td>
              
              </tr>  <tr>
              <td>Batch</td>
              <td>'.$this->session->userdata("user")['user_year'].'</td>
              
              </tr>  <tr>
              <td>Year</td>
              <td>'.date("Y").'</td>
              
              </tr>  <tr>
              <td>Register No / Ref No</td>
              <td>'.$r_number.'</td>
              
              </tr><tr>
              <td>Application No</td>
              <td>'.$r[0]->application_number.'</td>
              
              </tr>
							<tr>
							<td><b>Complete Details</b></td>
							<td>'.$r[0]->f_discription.' Only</td>
							
						</tr>  
              </table>
              
            
         
               
              </div>
            </div>   


              
          <p style="text-align: center;"><b>PAYMENT DETAILS </b></p>
              <hr class="my-5">

          <div class="row p-5">
          <div class="col-md-12">
            <table class="table" width ="100%">
             
              <tbody>
              <tr>
              <td width="25%" ><b>PAYMENT DATE</b> </td>
        
              <td width="25%" ><b>PAYMENT TYPE</b></td>
              <td width="25%" ><b>PAYMENT STATUS</b></td>
              <td  width="25%" ><b>PAYMENT AMOUNT</b></td>
             
            </tr>
                <tr>
                  <td>'.date("d-M-Y",strtotime($r[0]->af_response_time)).'</td>
                  <td>'.$payment.'</td>
                  <td>'.$status.'</td>
                  <td>'.$r[0]->af_fees_total_amt.'</td>
                </tr>
                <tr>
                  <td><b>GST PERCENTAGE</b></td>
                  <td><b>GST AMOUNT</b></td>
                  <td><b>DUE DATE</b></td>
                  <td><b>FINE AMOUNT DAY</b></td>
                </tr>  <tr>
               
                <td>'.$Gst_per.'</td>
                <td>'.$Gst_amount.'</td>
               
                <td>'.date("d-M-Y",strtotime($r[0]->f_e_date)).'</td>

                <td>'.$r[0]->f_fine_amount.'</td>
              </tr>
              <tr>
              <td colspan="2"><b>FINE AMOUNT</b></td>
              <td colspan="2"><b>TOTAL AMOUNT</b></td>
              
            </tr>
            <tr>
            <td colspan="2">'.$rupees_fine.'</td>
            <td colspan="2">'.$total.'</td>
            
          </tr>  
              </tbody>
            </table>
          
            <br>
           
          </div>
        </div>

       
                <br>
                <br>
                <table class="table" width ="100%">
              
                <tbody>
                  
                
                <tr>
                  <td><b>Amount in Words :'.ucwords($this->convert_number_to_words($r[0]->af_fees_total_amt)).' Only</b></td>
                  
                </tr>  
                <tr>
                  <td><p style="text-align: center;">** This official receipt is a digital receipt, no signature is required. All payments done are non-refundable nor transferable.</p></td>
                  
                </tr>
                
  
                </tbody>
              </table>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <br>

    <div  style="float: right">
    Treasurer MSSW
    </div>
    <br>
    
  </div>
  <footer>
  <p style="text-align: center;">This Receipt is Automatically Generated by MSSW Campus Management System</p>
  </footer>
  </body>
  </HTML>
  ';
      $this->pdf->loadHtml($thml);
      $this->pdf->render();
    $file =	$this->pdf->output();
  
 // $user_name=rand();
  
    file_put_contents("admin/invoice/".$Referance.".pdf",$file);

  $path_file= "admin/invoice/".$Referance.".pdf";


/* 
$config = array(
    'protocol' => 'smtp', 
    'smtp_host' => 'ssl://smtp.gmail.com', 
    'smtp_port' => 465, 
    'smtp_user' => 'admission.mssw@gmail.com', 
   "smtp_pass" => "dqamafoawpedieqn",
    'mailtype' => 'html', 
    'charset' => 'iso-8859-1'
); */




$config = array(    
   
  'protocol'  => 'smtp', 
  'smtp_host' => 'ssl://smtp.gmail.com', 
  'smtp_port' => '465',    
  'smtp_user' => 'admission.mssw@gmail.com',   
  'smtp_pass' => 'loveindia@123',
  'smtp_crypto' => 'security',
  'mailtype'  => 'html',    
 // 'charset'   => 'utf-8',
  'charset'   => 'iso-8859-1',
  'newline'   => '\r\n',
  'wordwrap' => TRUE
);
    $this->email->initialize($config);
    $this->email->set_mailtype("html");
    $this->email->set_newline("\r\n");


$rupe_s = (float)$r[0]->af_fees_total_amt;

$rupsse = ucwords($this->convert_number_to_words($r[0]->af_fees_total_amt));

$subjecttt ='MSSW - Online Payment Status - Regarding';
$msg ='Dear '.$dp_user[0]->pr_applicant_name.' ,<br>

You have paid Rs.'.$rupe_s.'(Rupees '. $rupsse.' only) on '.date("d-M-Y H:i A",strtotime($r[0]->ac_created)).' towards '.$r[0]->f_name.'.<br>

The receipt is attached along with this E-mail.<br><br>

For any queries contact:<br><br>

Phone: +91 44 28195126 / 28194566 (10 AM to 4 PM)<br>
E-Mail: accounts@mssw.in<br>

E-Mail queries will be responded to in two - three working days.<br>';


    $this->testEmail($res[0]->u_email_id,$subjecttt,$msg,$path_file);





    if($r[0]->af_paid_status == 1){

      $this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Payment Success !</strong> Payment Success.
      </div>');
  
  
  redirect('PayFees', 'refresh');
      
      }else{
      
 
        $this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Payment Failed !</strong> Payment Failed Pls Try after sometimes or with different Payment Mode.
        </div>');
    
    
    redirect('PayFees', 'refresh');
      
      }



     $this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Payment Success !</strong> Payment Success.
    </div>');


redirect('PayFees', 'refresh'); 


}else{

$this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Payment Failed !</strong> Payment Failed Pls Try after sometimes or with different Payment Mode.
      </div>');


  redirect('PayFees', 'refresh');


}

}


public function ResponsePaymentStatusss(){

  $id = $this->uri->segment(3);

$q = $this->db->select("*")->from("accounts_fees_transaction")
->join("department_details","accounts_fees_transaction.af_main_id = department_details.main_id AND accounts_fees_transaction.af_course_id = department_details.cour_id")
->join("accounts_fee_master","accounts_fees_transaction.af_fees_id = accounts_fee_master.f_id")
->join("accounts_category","accounts_fees_transaction.af_category_id = accounts_category.ac_id")
->join("Applyed_Cources","accounts_fees_transaction.af_main_id = Applyed_Cources.main_course_id AND accounts_fees_transaction.af_course_id = Applyed_Cources.applied_course_id AND accounts_fees_transaction.af_student_id = Applyed_Cources.user_id")

->where("af_id",$id)->get();

$r =$q->result();


$user = $this->db->select("*")->from("stu_user")->where("u_id",$r[0]->af_student_id)->get();

$res = $user->result();

$session_data = array(


'user_id'=> $res[0]->u_id,
'user_m_course'=> $res[0]->u_course,
'user_name'=> $res[0]->u_name,
'user_email_id'=> $res[0]->u_email_id,
'user_mobile'=> $res[0]->u_mobile,
'user_email_valid'=> $res[0]->u_email_valid,
'user_mobile_valid'=> $res[0]->u_mobile_valid,
'user_mobile_valid'=> $res[0]->u_mobile_valid,
'user_year'=>$res[0]->u_year,
);

$this->session->set_userdata('user', $session_data);





if($r[0]->af_main_id == 5){
$f_user = $this->db->select("*")->from("new_preview")->where("pr_user_id",$r[0]->af_student_id)->get();
$dp_user = $f_user->result();
}else if($r[0]->af_main_id == 1 || $r[0]->af_main_id == 2 || $r[0]->af_main_id == 3){

$f_user = $this->db->select("*")->from("new_preview_pg")->where("pr_user_id",$r[0]->af_student_id)->get();
$dp_user = $f_user->result();
}else if($r[0]->af_main_id == 4){

$f_user = $this->db->select("*")->from("new_preview_dip")->where("pr_user_id",$r[0]->af_student_id)->get();
$dp_user = $f_user->result();

}else{
if(!isset($this->session->userdata('user')['user_id'])){
redirect('Home/logOut', 'refresh');
exit;
} 


}


$reg = $this->db->select("as_reg_num")->from("admitted_student")->where("as_student_id",$r[0]->af_student_id)->get();

$r_mum = $reg->num_rows();


if($r_mum > 0){
$r_mumr = $reg->result();

$r_number = $r_mumr[0]->as_reg_num;


}else{

$r_number = substr( $this->session->userdata('user')['user_year'], -2).sprintf("%'04d", $this->session->userdata('user')['user_id']);

}

$update_user = array(
'af_reg_number'=>$r_number,
);

$this->db->where("af_id",$id);
$this->db->update("accounts_fees_transaction",$update_user);

$Referance="#TNR".sprintf("%'06d", $r[0]->af_id);
if($id != 0){


if($r[0]->af_paid_status == 1){

$status = "Payment - Success";

}else{

$status = "Payment - Failed";

}

if($r[0]->f_perc == 0){

$Gst_per = "N/A";
$Gst_amount = "N/A";

}else{

  $Gst_per = $r[0]->f_perc;
  $Gst_amount = $r[0]->f_gst_amt;

}
if($r[0]->af_installment_id == 1){

$payment = "Payment - Full Payment";

}else{

$payment = "Payment - Installment Payment";

}

if($r[0]->year == 1){

$year = "First Year";

}else if($r[0]->year == 2){

$year = "Second Year";

}else{

$year = "Third Year";

}


if((int)$r[0]->f_fine_status == 1 && $r[0]->f_e_date < date("Y-m-d") ){


  $startdate =date_create($r[0]->f_e_date); 
  
  
  $date2 = date_create(date("Y-m-d"));
      $diff = date_diff($startdate , $date2);
    $rupees_fine =$diff->format("%a");
    (int)$fine_amount = $r[0]->f_fine_amount * $rupees_fine;
   
      
    
      (int)$total = (int)$fine_amount + (int)$r[0]->f_gst_amt + (int)$r[0]->f_amount + (int)$r[0]->f_instalment_fees;
      }else{
        $rupees_fine =0;
          (int) $total = (int)$r[0]->f_gst_amt + (int)$r[0]->f_amount+ (int)$r[0]->f_instalment_fees;
          
      }










$this->load->library('Pdf');
  $thml='
  <HTML>
  <head>
  <style>
  
  body {
    margin-top: 60px;
    margin-bottom: 60px;
  }
  .center {
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 100%;
    
    }
table{
  width:100%;
}

.table td {

  padding :2px;
}
    footer {
    position: fixed; 
    bottom: 30px; 
    left: 0px; 
    right: 0px;
    height: 50px; 
    }
    .alg_r{
      left: 50%; 


    }
    li{
      list-style: none;
    }
  </style>
  </head>
      <body class="em_body" style="margin:0px; padding:0px;">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body p-0">
  
  
          
            
              <div class="col-md-6">
              <img class="center" src="https://admission.mssw.in//landing/images/mssw_logo.jpg"  height = "100px;">
              </div>
            
              <br>
              <br>
              <br>
             
              <h3 style="text-align: center;" >Online Fees Payment Receipt</h3>
              <br/>
              <p style="text-align: center;"><b>PAYEE DETAILS</b></p>
              <hr class="my-5"/>
       

              <div class="row p-5">
              <div class="col-md-12">
              <table>
              <tr>
              <td>Name of the Student</td>
              <td>'.$dp_user[0]->pr_applicant_name.'</td>
              
              </tr>  <tr>
              <td>Department</td>
              <td>'.$r[0]->department.'</td>
              
              </tr>  <tr>
              <td>Program</td>
              <td>'.$r[0]->comp_name.'</td>
              
              </tr>  <tr>
              <td>Batch</td>
              <td>'.$this->session->userdata("user")['user_year'].'</td>
              
              </tr>  <tr>
              <td>Year</td>
              <td>'.date("Y").'</td>
              
              </tr>  <tr>
              <td>Register No / Ref No</td>
              <td>'.$r_number.'</td>
              
              </tr><tr>
              <td>Application No</td>
              <td>'.$r[0]->application_number.'</td>
              
              </tr>
							<tr>
							<td><b>Complete Details</b></td>
							<td>'.$r[0]->f_discription.' Only</td>
							
						</tr> 
              </table>
              
            
         
               
              </div>
            </div>   


              
          <p style="text-align: center;"><b>PAYMENT DETAILS </b></p>
              <hr class="my-5">

          <div class="row p-5">
          <div class="col-md-12">
            <table class="table" width ="100%">
             
              <tbody>
              <tr>
              <td width="25%" ><b>PAYMENT DATE</b> </td>
        
              <td width="25%" ><b>PAYMENT TYPE</b></td>
              <td width="25%" ><b>PAYMENT STATUS</b></td>
              <td  width="25%" ><b>PAYMENT AMOUNT</b></td>
             
            </tr>
                <tr>
                  <td>'.date("d-M-Y",strtotime($r[0]->af_response_time)).'</td>
                  <td>'.$payment.'</td>
                  <td>'.$status.'</td>
                  <td>'.$r[0]->af_fees_total_amt.'</td>
                </tr>
                <tr>
                  <td><b>GST PERCENTAGE</b></td>
                  <td><b>GST AMOUNT</b></td>
                  <td><b>DUE DATE</b></td>
                  <td><b>FINE AMOUNT DAY</b></td>
                </tr>  <tr>
               
                <td>'.$Gst_per.'</td>
                <td>'.$Gst_amount.'</td>
               
                <td>'.date("d-M-Y",strtotime($r[0]->f_e_date)).'</td>

                <td>'.$r[0]->f_fine_amount.'</td>
              </tr>
              <tr>
              <td colspan="2"><b>FINE AMOUNT</b></td>
              <td colspan="2"><b>TOTAL AMOUNT</b></td>
              
            </tr>
            <tr>
            <td colspan="2">'.$rupees_fine.'</td>
            <td colspan="2">'.$total.'</td>
            
          </tr>  
              </tbody>
            </table>
          
            <br>
           
          </div>
        </div>

       
                <br>
                <br>
                <table class="table" width ="100%">
              
                <tbody>
                  
                
                <tr>
                  <td><b>Amount in Words :'.ucwords($this->convert_number_to_words($r[0]->af_fees_total_amt)).' Only</b></td>
                  
                </tr>  
                <tr>
                  <td><p style="text-align: center;">** This official receipt is a digital receipt, no signature is required. All payments done are non-refundable nor transferable.</p></td>
                  
                </tr>
                
  
                </tbody>
              </table>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <br>
    

    <div  style="float: right">
    Treasurer MSSW
    </div>
   
    
  </div>
  <footer>
  <p style="text-align: center;">This Receipt is Automatically Generated by MSSW Campus Management System</p>
  </footer>
  </body>
  </HTML>
  ';
      $this->pdf->loadHtml($thml);
      $this->pdf->render();
    $file =	$this->pdf->output();
  
 // $user_name=rand();
  
    file_put_contents("admin/".$Referance.".pdf",$file);

  $path_file= "admin/".$Referance.".pdf";

	}
}
    public function testEmail( $emailto,$subject,$msg,$email_attachment){

      $html ='<html>
      <head>
      
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      
      <!--[if !mso]><!-->
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
      <!--<![endif]-->
      <style>
      body {
      margin: 0 !important;
      padding: 0 !important;
      -webkit-text-size-adjust: 100% !important;
      -ms-text-size-adjust: 100% !important;
      -webkit-font-smoothing: antialiased !important;
      }
      img {
      border: 0 !important;
      outline: none !important;
      }
      p {
      Margin: 0px !important; 
      padding: 0px !important;
      }
      table {
      border-collapse: collapse;
      mso-table-lspace: 0px; 
      mso-table-rspace: 0px; 
      }
      table.em_main_table {
      box-shadow: 2px 2px 11px 2px #b2acac;
      }
      td, a, span {
      border-collapse: collapse;
      mso-line-height-rule: exactly;
      }
      .ExternalClass * {
      line-height: 100%;
      }
      @media yahoo {
      .em_img {
      min-width:700px !important;
      }
      }
      .em_img {
      width: 300px !important;
      height: auto !important;
      }
    
      .em_defaultlink a {
      color: inherit !important;
      text-decoration: none !important;
      }
      span.MsoHyperlink {
      mso-style-priority: 99; 
      color: inherit;
      }
      span.MsoHyperlinkFollowed {
      mso-style-priority: 99; 
      color: inherit;
      }
    
      @media only screen and (min-width:481px) and (max-width:699px) {
      .em_main_table {
      width: 100% !important;
      }
      .em_wrapper {
      width: 100% !important;
      }
      .em_hide {
      display: none !important;
      }
      .em_img {
      width: 100% !important;
      height: auto !important;
      }
      .em_h20 {
      height: 20px !important;
      }
      .em_padd {
      padding: 20px 10px !important;
      }
      }
      
      @media screen and (max-width: 480px) {
      .em_main_table {
      width: 100% !important;
      }
      .em_wrapper {
      width: 100% !important;
      }
      .em_hide {
      display: none !important;
      }
      .em_img {
      width: 100% !important;
      height: auto !important;
      }
      .em_h20 {
      height: 20px !important;
      }
      .em_padd {
      padding: 20px 10px !important;
      }
      .em_text1 {
      font-size: 16px !important;
      line-height: 24px !important;
      }
      u + .em_body .em_full_wrap {
      width: 100% !important;
      width: 100vw !important;
      }
      }
      </style>
      </style>
      </head>
      <body class="em_body" style="margin:0px; padding:0px;" bgcolor="#efefef">
      <table class="em_full_wrap" valign="top" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#efefef" align="center">
      <tbody>
      <tr>
      <td valign="top" align="center">
      <table class="em_main_table" style="width:700px;" width="700" cellspacing="0" cellpadding="0" border="0" align="center">
      <!--Header section-->
      <tbody>
      
      <!--//Header section ends-->
      
      <!--Banner section-->
      <tr>
      <td valign="top" align="center">
      <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" style="background:#eae8f9;">
      <tbody>
      <tr>
      <td valign="top" align="center">
      <img class="em_img" alt="Welcome to Email" src="http://admission.mssw.in//landing/images/mssw_logo.jpg" width="700" border="0" height="110px">
      </td>
      </tr>
      </tbody>
      </table>
      </td>
      </tr>
      <!--//Banner section ends-->
      
      <!--Content Text Section-->
      <tr>
      <td style="padding:35px 70px 30px;" class="em_padd" valign="top" bgcolor="#fff" align="center">
      <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
      <tbody>
      <tr>
      <td style="font-family: Arial, sans-serif; font-size:16px; line-height:30px; " valign="top" align="">
      '.$msg.'
        
      </td>
      </tr>
      <tr>
      <td style="font-size:0px; line-height:0px; height:15px;" height="15">&nbsp;</td>
      <!--—this is space of 15px to separate two paragraphs ---->
      </tr>
      <tr>
      <td style="font-family: Arial, sans-serif; font-size:18px; line-height:22px; color:#2f2483; letter-spacing:2px; padding-bottom:12px;" valign="top" align="center">
      
      </td>
      </tr>
      <tr>
      <td class="em_h20" style="font-size:0px; line-height:0px; height:25px;" height="25">&nbsp;</td>
      <!--—this is space of 25px to separate two paragraphs ---->
      </tr>
      
      </tbody>
      </table>
      </td>
      </tr>
      
      
      <tr>
      </body>
      </html>
      ';
      
        //$this->email->set_newline("\r\n");
            $this->email->from("admission.mssw@gmail.com");
            $this->email->to($emailto);
            $this->email->subject($subject);
            $this->email->message($html);
            $this->email->attach($email_attachment);
            $this->email->send();
      
      
      
      
      
      }
  

    function convert_number_to_words($number) {

			
			$no = floor($number);
			$point = round($number - $no, 2) * 100;
			$hundred = null;
			$digits_1 = strlen($no);
			$i = 0;
			$str = array();
			$words = array('0' => '', '1' => 'one', '2' => 'two',
			 '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
			 '7' => 'seven', '8' => 'eight', '9' => 'nine',
			 '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
			 '13' => 'thirteen', '14' => 'fourteen',
			 '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
			 '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
			 '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
			 '60' => 'sixty', '70' => 'seventy',
			 '80' => 'eighty', '90' => 'ninety');
			$digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
			while ($i < $digits_1) {
			  $divider = ($i == 2) ? 10 : 100;
			  $number = floor($no % $divider);
			  $no = floor($no / $divider);
			  $i += ($divider == 10) ? 1 : 2;
			  if ($number) {
				 $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
				 $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
				 $str [] = ($number < 21) ? $words[$number] .
					 " " . $digits[$counter] . $plural . " " . $hundred
					 :
					 $words[floor($number / 10) * 10]
					 . " " . $words[$number % 10] . " "
					 . $digits[$counter] . $plural . " " . $hundred;
			  } else $str[] = null;
		   }
		   $str = array_reverse($str);
		   $result = implode('', $str);
		   $points = ($point) ?
			 "." . $words[$point / 10] . " " . 
				   $words[$point = $point % 10] : '';
		   return $result . "Rupees  ";
		}

public function viewMyReciept(){

  $q = $this->db->select("*")->from("accounts_fees_transaction")
  ->join("department_details","accounts_fees_transaction.af_main_id = department_details.main_id AND accounts_fees_transaction.af_course_id = department_details.cour_id")
  ->join("accounts_fee_master","accounts_fees_transaction.af_fees_id = accounts_fee_master.f_id")
  ->join("accounts_category","accounts_fees_transaction.af_category_id = accounts_category.ac_id")
  ->where("accounts_fees_transaction.af_paid_status",1)
  ->where("accounts_fees_transaction.af_student_id",$this->session->userdata('user')['user_id'])
  ->get();
  
  $data['data'] =$q->result();
  
  $this->load->view("Home/template/head_ug");
  $this->load->view("Home/site/fees/my_payment_details", $data);
  $this->load->view("Home/template/footer_ug");


}
public function examPayment(){


  if($this->user_main_stream == 1 || $this->user_main_stream == 2 || $this->user_main_stream  == 3){
  
  $main = 1;
  
  
    $data['current_paper'] = $this->db->select("erp_subjectmaster.*,erp_subjectmaster.sem AS semester,erp_subjectmaster.id AS sub_id,erp_exam_fees.*,erp_particulars.*")->from("erp_subjectmaster")
    ->join("erp_particulars","erp_subjectmaster.subNature = erp_particulars.particular_name","left")
    ->join("erp_exam_fees","erp_particulars.id = erp_exam_fees.particular_id AND erp_exam_fees.main_id =".$main,"left")
    ->where("erp_subjectmaster.batch_year",$this->user_batch)
    ->where("erp_subjectmaster.stream",$this->user_main_stream)
    ->where("erp_subjectmaster.department",$this->user_course_stream)
    ->where("erp_subjectmaster.sem",$this->session->userdata("user")["user_semester"])
    
    ->get()->result();
  
     $data['arr_paper'] =
    
    $this->db->select("erp_exammarkfinal.*,erp_subjectmaster.*,erp_exammarkfinal.sem AS semester,erp_particulars.*,erp_exam_fees.*")
    
    ->from("erp_exammarkfinal")
    ->join("erp_subjectmaster","erp_exammarkfinal.subject_id=erp_subjectmaster.id","left")
    ->join("erp_particulars","erp_subjectmaster.subNature=erp_particulars.particular_name","left")
    ->join("erp_exam_fees","erp_particulars.id=erp_exam_fees.particular_id","right")
    ->where("erp_exammarkfinal.batch_year",$this->user_batch)
    ->where("erp_exammarkfinal.main_id",$this->user_main_stream)
    ->where("erp_exammarkfinal.course_id",$this->user_course_stream)
    ->where("erp_exammarkfinal.student_id",$this->user_ad_id)
    ->where("erp_exammarkfinal.sem !=",$this->user_semester)
    ->where("erp_exammarkfinal.result !=","P")
    ->where("erp_exammarkfinal.result !=","")
      ->group_by('erp_subjectmaster.subCode')
    ->get()->result(); 
  
    $this->load->view("Home/template/head");
    $this->load->view("Home/site/pg/examination_payment", $data);
    $this->load->view("Home/template/footer");
  
  
    }else if($this->user_main_stream == 4){
  
      $main = 2;
  
  
  
    }else{
  
      $main = 3;
  
  
  
  
  
  
  
    }
  }
  public function payArrearFees(){

    $data['fees_id']=$this->uri->segment(3);
    $data['main']=$this->uri->segment(4);
    $this->load->view("Home/template/head");
    $this->load->view("Home/site/fees/arr_fees", $data);
    $this->load->view("Home/template/footer_ug");
   
  
  }

  public function arrExamStatus($id){

      $id = $this->uri->segment(3);

      $val = $this->db->select('*')->from('erp_exam_fees_master')->where('ef_paid_status',1)->where('ef_id',$id)->get()->result();


      if(sizeof($val)>0){

$user_admited =$this->db->select('*')->from('erp_existing_students')->where_in('id',$val[0]->ef_stu_ad_id)->get()->result();

      $ind = explode(",",$val[0]->ef_arr_exam);

      
    $sub=  $this->db->select('*')->from('erp_subjectmaster')->where_in('id',$ind)->get()->result();

      foreach ($sub as $key => $value) {
       

$data= array(
  'fees_particulars_id'=>$id,
  'student_batch'=>$value->batch_year,
  'sem'=>$value->sem,
  'student_id'=>$val[0]->ef_stu_ad_id,
  'subject_code'=>$value->subCode,
  'reg_no'=>$user_admited[0]->reg_no_,
  'subject_id'=>$value->id,
  'main_id'=>$value->stream,
  'course_id'=>$value->department,
  'applied_year'=>date('Y'),
  'applied_sem'=>$val[0]->ef_curr_sem,
  'created_at'=>date('Y-m-d H:i'),
);


$this->db->insert('erp_arrear_detail',$data);


      }

      $user = $this->db->select("*")->from("stu_user")->where("u_id",$val[0]->ef_stu_id)->get();

      $res = $user->result();
      
      $session_data = array(
          
        
        'user_id'=> $res[0]->u_id,
        'user_m_course'=> $res[0]->u_course,
        'user_name'=> $res[0]->u_name,
        'user_email_id'=> $res[0]->u_email_id,
        'user_mobile'=> $res[0]->u_mobile,
        'user_email_valid'=> $res[0]->u_email_valid,
        'user_mobile_valid'=> $res[0]->u_mobile_valid,
        'user_mobile_valid'=> $res[0]->u_mobile_valid,
        'user_year'=>$res[0]->u_year,
        'user_semester'=>$res[0]->u_semester,
        );
      
       $this->session->set_userdata('user', $session_data);

      $this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
      <a href="#" class="close" data-dismiss="success" aria-label="close">&times;</a>
      <strong>Payment Success !</strong> '.$val[0]->ef_paid_response.'.
      </div>');


  redirect('MyExamination', 'refresh');


      }else{

        $failed = $this->db->select('*')->from('erp_exam_fees_master')->where('ef_id',$id)->get()->result();


        $this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Payment Failed !</strong> '.$failed[0]->ef_paid_response.'.
        </div>');
  
  
    redirect('MyExamination', 'refresh');


      }







      

  }
}
