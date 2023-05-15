<?php
defined("BASEPATH") or exit("No direct script access allowed");

class PayFees extends CI_Controller
{
    private $CI;
    public function __construct()
    {
        parent::__construct();
        //.error_reporting(0);
        //ini_set('display_errors', 0);
       $this->load->helper("useracadamic");
       $this->CI = & get_instance();
       $this->CI->load->library("useracadamic");
      
       date_default_timezone_set('Asia/Calcutta');

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

    $stud_id = $this->db->select("shotlisted_candidate.*,department_details.*")->from("shotlisted_candidate")
    
    ->join('department_details', 'shotlisted_candidate.sl_main_id = department_details.main_id AND shotlisted_candidate.sl_course_id = department_details.cour_id')
    ->where("sl_student_id",$this->session->userdata("user")["user_id"])->where("principal_published",0)->get();
    $rest = $stud_id->result();

/*  print_r($rest);
exit; */

    if($rest[0]->sl_main_id == 5){

        $data['selected'] = $rest;
        $this->load->view("Home/template/head");
        $this->load->view("Home/site/fees/fees_details", $data);
        $this->load->view("Home/template/footer_ug");

    }elseif($rest[0]->sl_main_id == 1){





    }elseif($rest[0]->sl_main_id == 2){





    }elseif($rest[0]->sl_main_id == 3){





    }elseif($rest[0]->sl_main_id == 4){





    }else{





    }
    




    }
    public function CompletepayUg()
    {
$user_id = $this->uri->segment(3);
$selection_id = $this->uri->segment(4);
        
        if($user_id == $this->session->userdata("user")["user_id"]){


/* 
    echo  $fees_table = $this->CI->useracadamic->studentAcadamicFeesTable($this->session->userdata("user")["user_id"]);
       
     print_r( $this->CI->useracadamic->selectStudentTable($this->session->userdata("user")["user_id"],$selection_id));

    $table = feestable($this->CI->useracadamic->selectStudentTable($this->session->userdata("user")["user_id"],$selection_id));


 */

         $where_fee_type = "fees_type is  NOT NULL OR fees_type !=''";
          $fees =  $this->db->select("*")->from("student_fees_details")->where("stu_id",$this->session->userdata("user")["user_id"])
        ->where($where_fee_type)->get();
         $fees_paid =  $fees->num_rows();
  if($fees_paid == 0){

        $qta = $this->db
            ->select("*")
            ->from("shotlisted_candidate")
            ->where(
                "sl_student_id",
                $this->session->userdata("user")["user_id"]
            )
          
            ->where("principal_published", 0)
            ->get();

        $data["fees"] = $qta->result();

       /*  print_r($data);
 */
        $this->load->view("Home/template/head");
        $this->load->view("Home/site/fees/fees_ug", $data);
        $this->load->view("Home/template/footer_ug");
 
    }else{


        $fees_paid =  $fees->result();

if($fees_paid[0]->fees_type ==1){

    redirect('PayFees/fullPaymentUg/'.$selection_id, 'refresh');

}elseif($fees_paid[0]->fees_type ==2){

    redirect('PayFees/installmentPaymentUg/'.$selection_id, 'refresh');

}else{

    redirect('Home', 'refresh');  
}
} 







        }else{




        }
}
public function findAcadamicYear(){








}
/*     public function payPg()
    {


    


        $qta = $this->db
            ->select("*")
            ->from("shotlisted_candidate")
            ->where(
                "sl_student_id",
                $this->session->userdata("user")["user_id"]
            )
            ->where("published", 1)
            ->where("principal_published", 1)
            ->get();
        $qtr = $qta->result();
        if ($qtr[0]->sl_main_id == "5" && $qtr[0]->sl_course_id == 1) {
            $field = "name,main_5_app_1,status";
            $data["fees_name"] = "main_5_app_1";
        } else {
            $field = "name,main_5_app_2,status";
            $data["fees_name"] = "main_5_app_2";
        }

        $mt = $this->db
            ->select("*")
            ->from("new_master_fees")
            ->where("nm_main_course_id", 5)
            ->where("nm_applied_course_id", $qtr[0]->sl_course_id)
            ->get();

        $tst = $mt->num_rows();

        if ($tst == 0) {
            $data = [
                "nm_main_course_id" => 5,
                "nm_applied_course_id" => $qtr[0]->sl_course_id,
                "nm_user_id" => $this->session->userdata("user")["user_id"],
            ];

            $this->db->insert("new_master_fees", $data);
        }

        $test = $this->db
            ->select($field)
            ->from("fees_master")
            ->get();

        $data["fees"] = $test->result();

        //print_r($data['fees']);

        $this->load->view("Home/template/head");
        $this->load->view("Home/site/pg_tution_fees", $data);
        $this->load->view("Home/template/footer_ug");



  
    } */

  /*   public function paymentModePg()
    {
        $data = [];

        $payment_mode = $this->uri->segment(3);
        $user_id = $this->uri->segment(4);

        $qta = $this->db
            ->select("*")
            ->from("shotlisted_candidate")
            ->where(
                "sl_student_id",
                $this->session->userdata("user")["user_id"]
            )
            ->where("published", 1)
            ->where("principal_published", 1)
            ->get();
        $qtr = $qta->result();

        if ($qtr[0]->sl_main_id == "5" && $qtr[0]->sl_course_id == 1) {
            $field = "name,main_5_app_1,status";
            $data["fees_name"] = "main_5_app_1";
        } else {
            $field = "name,main_5_app_2,status";
            $data["fees_name"] = "main_5_app_2";
        }

        $test = $this->db
            ->select($field)
            ->from("fees_master")
            ->get();
        $data["fees"] = $test->result();

        /* echo"<pre>";
         var_dump($data); */
/*
        $this->load->view("Home/template/head");
        $this->load->view("Home/site/pg_complete_fees", $data);
        $this->load->view("Home/template/footer_ug");
    } */

   /*  public function payUg()
    {
        $qta = $this->db
            ->select("*")
            ->from("shotlisted_candidate")
            ->where(
                "sl_student_id",
                $this->session->userdata("user")["user_id"]
            )
            ->where("published", 1)
            ->where("principal_published", 1)
            ->get();
        $qtr = $qta->result();
        $num = $qta->num_rows();

        if ($num > 0) {
            if ($qtr[0]->sl_main_id == "5" && $qtr[0]->sl_course_id == 1) {
                $field = "name,main_5_app_1,status";
                $data["fees_name"] = "main_5_app_1";

                $mt = $this->db
                    ->select("*")
                    ->from("new_master_fees")
                    ->where("nm_main_course_id", 5)
                    ->where("nm_applied_course_id", $qtr[0]->sl_course_id)
                    ->get();

                $tst = $mt->num_rows();

                if ($tst == 0) {
                    $data = [
                        "nm_main_course_id" => 5,
                        "nm_applied_course_id" => $qtr[0]->sl_course_id,
                        "nm_user_id" => $this->session->userdata("user")[
                            "user_id"
                        ],
                    ];

                    $this->db->insert("new_master_fees", $data);
                }

                $test = $this->db
                    ->select($field)
                    ->from("fees_master")
                    ->get();

                $data["fees"] = $test->result();
            }

            //print_r($data['fees']);

            $this->load->view("Home/template/head");
            $this->load->view("Home/site/ug_tution_fees", $data);
            $this->load->view("Home/template/footer_ug");
        } else {
        }
    }
 */
    public function paymentModeUg()
    {
        
        $shot_id = $this->uri->segment(3);
        $payment_mode = $this->uri->segment(4);

        

        
        
        $qta = $this->db
            ->select("*")
            ->from("shotlisted_candidate")
            ->where(
                "sl_student_id",
                $this->session->userdata("user")["user_id"]
            )
            ->where("sl_id", $shot_id)
             ->where("principal_published", 0)
            ->get();

            $qtr = $qta->result();



         /*    echo"<pre>";


            print_r($qtr); */

            $date=date("Y-m-d");
            $where_fee_type = "fees_type is  NOT NULL OR fees_type !=''";
    $fees =  $this->db->select("*")->from("student_fees_details")->where("stu_id",$this->session->userdata("user")["user_id"])
      ->where($where_fee_type)->where("paid_date",$date)->get();
        
        
      $fees_paid =  $fees->num_rows();

      if($fees_paid == 0){

            $fees_details = array(
                "stu_id"=>$this->session->userdata("user")["user_id"],
                "main_cource_id"=>$qtr[0]->sl_main_id,
                "applied_course_id"=>$qtr[0]->sl_course_id,
                "shortlisted_candidate"=>$qtr[0]->sl_id,
                "paid_date"=>$date,
                
                "fees_type"=>$payment_mode,
            );


$this->db->insert("student_fees_details",$fees_details);

$this->session->set_userdata('fees',  $fees_details);
      }else{
        $fees_paid_m =  $fees->result();
      
if($fees_paid_m[0]->fees_type == 1 ){
    redirect('PayFees/fullPaymentUg', 'refresh');

}elseif($fees_paid_m[0]->fees_type == 2){

    redirect('PayFees/installmentPaymentUg/'.$shot_id, 'refresh');

}else{

    redirect('Home', 'refresh'); 
}


      }
        
       

   
    }
    public function fullPaymentUg(){


     /*    print_r($_SESSION); */

   $us_id = $this->uri->segment(3);

      /*

        print_r($_SESSION); */
  /*       $us_id= $_SESSION['fees']['shortlisted_candidate']; */

        $fees_master =  $this->db->select("*")->from("student_fees_details")
        ->where("shortlisted_candidate",$us_id)->get();
        $data['fees_master'] = $fees_master->result_array();

         $fees_table = $this->CI->useracadamic->studentAcadamicFeesTable($this->session->userdata("user")["user_id"]);
       

         $select=$this->CI->useracadamic->selectStudentTable($this->session->userdata("user")["user_id"],$us_id);
       $data['table_name'] = feestable($this->CI->useracadamic->selectStudentTable($this->session->userdata("user")["user_id"],$us_id));

       $fees =  $this->db->select($select)->from($fees_table)->where_not_in("id",installment_details())->get();
       $data['fees_details'] = $fees->result_array();


/* 
echo"<pre>";

print_r($data); */






      $this->load->view("Home/template/head");
       $this->load->view("Home/site/ug_complete_fees",$data);
      //$this->load->view("Home/site/fees/test_payment",$data);
       $this->load->view("Home/template/footer_ug");

    }
    public function installmentPaymentUg(){

        $us_id = $this->uri->segment(3);

        $fees_master =  $this->db->select("*")->from("student_fees_details")
        ->where("shortlisted_candidate",$us_id)->get();
        $data['fees_master'] = $fees_master->result_array();

        $fees_table = $this->CI->useracadamic->studentAcadamicFeesTable($this->session->userdata("user")["user_id"]);
       

         $select=$this->CI->useracadamic->selectStudentTable($this->session->userdata("user")["user_id"],$us_id);
       $data['table_name'] = feestable($this->CI->useracadamic->selectStudentTable($this->session->userdata("user")["user_id"],$us_id));

      /*  $fees =  $this->db->select($select)->from($fees_table)->where_in("id",installment_details())->get();
       $data['fees_details'] = $fees->result_array(); */



      $install_arr = installment_fees_details();



       $dst = $this->db->select("*")->from("student_fees_details_complete")->where("payment_type",2)->where_in("installment_id",installment_fees_details())
       ->where("paid_status",1)->where("student_id",$this->session->userdata("user")["user_id"])->get();
       echo $dat = $dst->num_rows();


    if($dat == 0){ 
        $fees =  $this->db->select($select)->from($fees_table)->where("id",$install_arr[0],)->get();
        $data['fees_details'] = $fees->result_array();
     }else if($dat == 1){
        $fees =  $this->db->select($select)->from($fees_table)->where("id",$install_arr[1])->get();
        $data['fees_details'] = $fees->result_array();
     }else if($dat == 2){
        $fees =  $this->db->select($select)->from($fees_table)->where("id",$install_arr[2])->get();
        $data['fees_details'] = $fees->result_array();
     }else if($dat == 3){
        $fees =  $this->db->select($select)->from($fees_table)->where("id",$install_arr[3])->get();
        $data['fees_details'] = $fees->result_array();
     }else if($dat == 4){
        $fees =  $this->db->select($select)->from($fees_table)->where("id",$install_arr[4])->get();
        $data['fees_details'] = $fees->result_array();
    }

/* print_r($select);
print_r($dst->result());
echo $install_arr[0];
echo $fees_table;
 */


 

        $this->load->view("Home/template/head");
       $this->load->view("Home/site/ug_complete_fees",$data);
       $this->load->view("Home/template/footer_ug"); 


    }


    public function testPayment(){


$this->load->view("Home/site/fees/payment/Worldline");



    }





}
