<?php
defined("BASEPATH") or exit("No direct script access allowed");
use Dompdf\Dompdf;
use Dompdf\Options;

class UgSelfFinance extends CI_Controller
{
    public $Subject;
    public $asyear;
    public $aeyear;
	public $syear;
    public $eyear;
    public $acoursedate	;
	public function __construct()
	{
		parent::__construct();
	  //error_reporting(0);
	  date_default_timezone_set("Asia/Calcutta");
	  $this->load->library('upload');
	  $this->load->config('email');
		$this->load->library('email');
		$this->load->library('form_validation');
	  
		$this->load->library('pdf');
        $this->load->library('phpqrcode/qrlib');
        $this->load->library('useracadamic');



        if ($this->session->userdata("user")["user_aca_year"] == "" || $this->session->userdata("user")["user_aca_year"] == "0000" ) {
            $this->asyear = "2021/04/01 00:00:00";
            $this->aeyear = "2022/04/01  00:00:00";
        } else {
            $this->asyear = $this->session->userdata("user")["user_aca_year"]."/04/01  00:00:00";
            $this->aeyear = $this->session->userdata("user")["user_aca_year"]+ 1 ."/04/01  00:00:00";
			$this->syear = $this->session->userdata("user")["user_aca_year"];
			$this->eyear = $this->session->userdata("user")["user_aca_year"]+1;
        }
		
	}
    public function index(){


//echo"test";
$data['title'] = "Reports of  ".$this->session->userdata('user')['user_name']." ".date('d-M-Y');

$this->load->view("template/ugselffinance/header");
$this->load->view("template/ugselffinance/menubar");
$this->load->view("template/ugselffinance/headerbar");
$this->load->view("ugselffinance/dashbord");
$this->load->view("template/ugselffinance/footer",$data);

    }

	public function updateStuContactInfo()
    {

		$data['title'] = "Reports of  ".$this->session->userdata('user')['user_name']." ".date('d-M-Y');
        $this->load->view("template/ugselffinance/header");
        $this->load->view("template/ugselffinance/menubar");
        $this->load->view("template/ugselffinance/headerbar");
        $this->load->view("ugselffinance/update_personal");
		$this->load->view("template/ugselffinance/footer",$data);
    }

    public function principalApproved()
    {
       

        $user = $this->db
        ->select("*")
        ->from("shotlisted_candidate")
        ->join(
            "Applyed_Cources",
            "Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id" ,'right'
        )

        ->join(
            "verified_ug",
            "verified_ug.stu_id=shotlisted_candidate.sl_student_id  AND verified_ug.applied_id=shotlisted_candidate.sl_course_id"
       ,'right' )
     
           ->join(
            "new_preview",
            "shotlisted_candidate.sl_student_id=new_preview.pr_user_id"
        ) 
        ->where("shotlisted_candidate.sl_main_id",5)
        ->where(
            "shotlisted_candidate.sl_course_id",
            $this->session->userdata("user")["user_dep_status"]
        )
        ->where("shotlisted_candidate.reservation_status",1)
			->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
      ->order_by("verified_ug.percentage_obtained", "DESC")
      ->group_by("shotlisted_candidate.sl_id")
        ->get();


        $std = $this->db
        ->select("*")
        ->from("resrvation_table")
        ->where("rc_main_id", 5)
        ->where(
            "rc_cource_id",
            $this->session->userdata("user")["user_dep_status"]
        )
        ->get();

    $data["reservation"] = $std->result();


        $data["student"] = $user->result();
        $data['title'] = "Reports of  ".$this->session->userdata('user')['user_name']." ".date('d-M-Y');
        $this->load->view("template/ugselffinance/header");
        $this->load->view("template/ugselffinance/menubar");
        $this->load->view("template/selffinance/headerbar");
        $this->load->view("ugselffinance/principal_approved_list", $data);
        $this->load->view("template/ugselffinance/footer", $data);
    }

   /*  public function publishResult(){



        $user = $this->db
        ->select("*")
        ->from("shotlisted_candidate")
        ->join(
            "Applyed_Cources",
            "Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id"
        )

        ->join(
            "verified_ug",
            "verified_ug.stu_id=shotlisted_candidate.sl_student_id  AND verified_ug.applied_id=shotlisted_candidate.sl_course_id"
       ,'right' )
     
           ->join(
            "new_preview",
            "shotlisted_candidate.sl_student_id=new_preview.pr_user_id"
        ) 
        ->where("shotlisted_candidate.sl_main_id",5)
        ->where(
            "shotlisted_candidate.sl_course_id",
            $this->session->userdata("user")["user_dep_status"]
        )
        ->where("shotlisted_candidate.reservation_status",1)
        ->where("shotlisted_candidate.principal_published",1)
        ->where("shotlisted_candidate.published",0)
			->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
      ->order_by("verified_ug.percentage_obtained", "DESC")
        ->get();

        $res = $user->result_array();

        $arr = array_column($res, "sl_id");  


//print_r($arr);

$rec = $user->num_rows();

if($rec > 0){

$data = array(
    'published'=>1,
    'published_date'=>date('Y-m-d H:i:s'),
    'published_by'=>$this->session->userdata("user")["user_id"],
);


$this->db->where_in('sl_id', $arr);
$this->db->update('shotlisted_candidate', $data);





$this->session->set_flashdata(
    "message",
    ' <div class="alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong> '.$rec.' Record Published Successfully !
</div>'
);


redirect("UgSelfFinance/principalApproved/","refresh");
}else{

    $this->session->set_flashdata(
        "message",
        ' <div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Failed !</strong>  No record to Published !
    </div>'
    );
    
    
    redirect("UgSelfFinance/principalApproved/","refresh");




}

    } */
	public function publishResult(){



        $user = $this->db
		->select("*")
        ->from("shotlisted_candidate")
        ->join(
            "Applyed_Cources",
            "Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id"
        )

        ->join(
            "verified_ug",
            "verified_ug.stu_id=shotlisted_candidate.sl_student_id  AND verified_ug.applied_id=shotlisted_candidate.sl_course_id"
       ,'right' )
     
           ->join(
            "new_preview",
            "shotlisted_candidate.sl_student_id=new_preview.pr_user_id"
        ) 
        ->where("shotlisted_candidate.sl_main_id",5)
        ->where(
            "shotlisted_candidate.sl_course_id",
            $this->session->userdata("user")["user_dep_status"]
        )
        ->where("shotlisted_candidate.reservation_status",1)
        ->where("shotlisted_candidate.principal_published",1)
        ->where("shotlisted_candidate.published",0)
			->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
      ->order_by("verified_ug.percentage_obtained", "DESC")
        ->get();

        $res = $user->result_array();

        $arr = array_column($res, "sl_id");  
        $sl_student_id = array_column($res, "sl_student_id");  

		$m = $this->db->select("*")->from("stu_user")->where_in("u_id",$sl_student_id)->get()->result();
/* print_r($arr);
print_r($sl_student_id); */

$rec = $user->num_rows();

 if($rec > 0){

$data = array(
    'published'=>1,
    'published_date'=>date('Y-m-d H:i:s'),
    'published_by'=>$this->session->userdata("user")["user_id"],
);


$this->db->where_in('sl_id', $arr);
$this->db->update('shotlisted_candidate', $data); 


//////////////////////////
 foreach ($m as $key => $value) {

	$user = $this->db
	->select("*")
	->from("new_preview")

	->where("pr_user_id", $value->u_id)
	->get();
$user_details = $user->result();


$application = $this->db
                ->select("*")
                ->from("Applyed_Cources")
                ->where("main_course_id", 5)
                ->where(
                    "applied_course_id",
                    $this->session->userdata("user")["user_dep_status"]
                )
                ->where("user_id", $value->u_id)
                ->get();
            $app_details = $application->result();




	$subject =
	"MSSW Admission - Shortlisted for Selection list - Regarding";
	$msg =
		"Dear Mr./Ms." .
		$user_details[0]->pr_applicant_name .
		" ,<br> 

	Greetings! <br> 

	With reference to your application for " .
		$app_details[0]->course_name .
		", Application Number: " .
		$app_details[0]->application_number .
		",<br> You are SELECTED. Kindly pay the fee from your login.<br>                                                                                                                                         .
	
	Visit <a href='https://mssw.in/admissions/#PGAdmissions'>P.G.admissions</a> page and check your login for more details.<br><br>  <br> 

	Regards,<br><br>  

	Principal, MSSW.<br> 
	www.mssw.in
	";


 $msg."<br>";


//////////////////////////////////////



//$this->smspublishedSelectionList($user_details[0]->pr_applicant_name,$value->u_mobile);
  $config = [
            "protocol" => "smtp",
            "smtp_host" => "ssl://smtp.gmail.com",
            "smtp_port" => 465,
            "smtp_user" => "admission.mssw@gmail.com",
            "smtp_pass" => "dqamafoawpedieqn",
            "mailtype" => "html",
            "charset" => "iso-8859-1",
        ];
        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");


$this->testEmail($value->u_email_id, $subject, $msg);
}
   
 



$this->session->set_flashdata(
    "message",
    ' <div class="alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong> '.$rec.' Record Published Successfully !
</div>'
);


redirect("PgSelfFinance/principalApproved/","refresh");
}else{

    $this->session->set_flashdata(
        "message",
        ' <div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Failed !</strong>  No record to Published !
    </div>'
    );
    
    
    redirect("PgSelfFinance/principalApproved/","refresh");




} 

    }

	public function updateStuPerInfo()
    {
        $student_id = $this->input->post("student_id");
        $email_id = $this->input->post("email");
        $mobile = $this->input->post("mobile");

        if (isset($student_id) && $student_id != "") {
            $array = [
                "u_email_id" => $email_id,
                "u_mobile" => $mobile,
            ];

            $this->db->where("u_id", $student_id);
            $this->db->update("stu_user", $array);

            $this->session->set_flashdata(
                "message",
                ' <div class="alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong> Update Student Record Successfully .
</div>'
            );

            redirect(
                "UgSelfFinance/updateStuContactInfo/" . $student_id,
                "refresh"
            );
        } else {
            $this->session->set_flashdata(
                "message",
                ' <div class="alert alert-danger alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Failed !</strong> Failed to Student Record  .
	</div>'
            );

            redirect(
                "UgSelfFinance/updateStuContactInfo/" . $student_id,
                "refresh"
            );
        }
    }

	public function studentApplied(){


		$sta = $this->db->select("user_id")->from("Applyed_Cources")->where("applied_course_id",$this->session->userdata('user')['user_dep_status'])->get();
	
	





$user  = $this->db->select("*")->from("Applyed_Cources")
 ->join(
	"Applyed_Master",
	"Applyed_Master.id=Applyed_Cources.master_id",
	"left"
) ->join(
	"stu_user",
	"stu_user.u_id=Applyed_Cources.user_id",
	"left"
)
->join(
	"new_preview",
	"new_preview.pr_user_id=Applyed_Cources.user_id",
	"left"
)->join(
	"sub_preview",
	"sub_preview.sb_u_id=Applyed_Cources.user_id",
	"left"
) 
->join(
	"shotlisted_candidate",
	"Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id ",
	"left"
)
->where("Applyed_Cources.main_course_id",5)
->where("Applyed_Cources.applied_course_id",$this->session->userdata('user')['user_dep_status'])
->where(
    "Applyed_Master.date >=",$this->asyear
   
)->where(
    "Applyed_Master.date <",$this->aeyear
   
)
->get();

$data['count'] =$user->num_rows();
	   $data['student'] =$user->result();
	

/* 
print_r($data);
 */


	   $data['title'] = "Reports of Student Applied ".$this->session->userdata('user')['user_name']." ".date('d-M-Y');
	
	 	$this->load->view('template/ugselffinance/header');
		$this->load->view('template/ugselffinance/menubar');
		$this->load->view('template/ugselffinance/headerbar');
		$this->load->view('ugselffinance/appliedStudent',$data);
		$this->load->view('template/ugselffinance/footer',$data); 
	
	
	}	
	
	
	public function verifiedApplied(){


		$sta = $this->db->select("user_id")->from("Applyed_Cources")->where("applied_course_id",$this->session->userdata('user')['user_dep_status'])->get();
	
	





$user  = $this->db->select("*")->from("verified_ug")->where("applied_id",$this->session->userdata('user')['user_dep_status'])->join(
	"Applyed_Cources",
	"Applyed_Cources.user_id=verified_ug.stu_id",
	"right"
)
->join(
	"Applyed_Master",
	"Applyed_Master.id=Applyed_Cources.master_id",
	"left"
)
->join(
	"new_preview",
	"new_preview.pr_user_id=verified_ug.stu_id",
	"right"
)->join(
	"sub_preview",
	"sub_preview.sb_u_id=verified_ug.stu_id",
	"right"
)->where("Applyed_Cources.applied_course_id",$this->session->userdata('user')['user_dep_status'])->group_by('verified_ug.stu_id')->where(
    "Applyed_Master.date >=",$this->asyear
   
)->where(
    "Applyed_Master.date <",$this->aeyear
   
)->get();

	
	   $data['student'] =$user->result();



$data['title'] = "Reports of Verified Student ".$this->session->userdata('user')['user_name']." ".date('d-M-Y');

	
 	$this->load->view('template/ugselffinance/header');
		$this->load->view('template/ugselffinance/menubar');
		$this->load->view('template/ugselffinance/headerbar');
		$this->load->view('ugselffinance/verifiedapplicant',$data);
		$this->load->view('template/ugselffinance/footer',$data); 
	 
	
	}
public function viewApplicationMark(){


	$user_id = $this->uri->segment(3);

	$user  = $this->db->select("*")->from("stu_user")->where("u_course",1)->join(
		"Applyed_Cources",
		"Applyed_Cources.user_id=stu_user.u_id",
		"right"
	)
	->join(
		"new_preview",
		"new_preview.pr_user_id=stu_user.u_id",
		"right"
	)->join(
		"sub_preview",
		"sub_preview.sb_u_id=stu_user.u_id",
		"right"
	)
	->where("Applyed_Cources.applied_course_id",$this->session->userdata('user')['user_dep_status'])
	->where("stu_user.u_id",$user_id)
	->get();
	
		
		   $data['student'] =$user->result();

		   $data['title'] = "Reports of  ".$this->session->userdata('user')['user_name']." ".date('d-M-Y');
 	$this->load->view('template/ugselffinance/header');
	$this->load->view('template/ugselffinance/menubar');
	$this->load->view('template/ugselffinance/headerbar');
	$this->load->view('ugselffinance/view_mark',$data);
	$this->load->view("template/ugselffinance/footer",$data);




}

	public function updateStudent(){

		$user_id = $this->uri->segment(3);

		$in_pr = $this->db->select('*')->from('new_preview')->where('pr_user_id',$user_id)->get();
	$r = $in_pr->num_rows();






	//	$q = $this->db->select('*')->from('college_course')->where('mc_id',$m_course )->get();
		$pr_user = $this->db->select('*')->from('new_preview')->where('pr_user_id',$user_id)->get();
		$pr_study = $this->db->select('*')->from('sub_preview')->where('sb_u_id',$user_id)->get();
	
	
	
	
		$pr_study_app = $this->db->select('*')->from('stu_applied')->where('sa_st_id',$user_id)->get();
	
		$ren = $pr_study_app->num_rows();
	//	$data['cc'] = $q->result();
		$data['user'] = $pr_user->result();
		$data['Study'] = $pr_study->result();


		$data['title'] = "Reports of  ".$this->session->userdata('user')['user_name']." ".date('d-M-Y');

		$this->load->view('template/ugselffinance/header');
		$this->load->view('template/ugselffinance/menubar');
		$this->load->view('template/ugselffinance/headerbar');
		$this->load->view('ugselffinance/update_ug',$data);
		$this->load->view("template/ugselffinance/footer",$data);
	




	}



	public function UploadFile()
    {
        if (isset($_REQUEST["file"])) {
            // Get parameters
            $file = urldecode($_REQUEST["file"]); // Decode URL-encoded string

            /* Test whether the file name contains illegal characters
             such as "../" using the regular expression */
            if (preg_match('/^[^.][-a-z0-9_.]+[a-z]$/i', $file)) {
                $filepath = "uploads/" . $file;

                // Process download
                if (file_exists($filepath)) {
                    header("Content-Description: File Transfer");
                    header("Content-Type: application/octet-stream");
                    header(
                        'Content-Disposition: attachment; filename="' .
                            basename($filepath) .
                            '"'
                    );
                    header("Expires: 0");
                    header("Cache-Control: must-revalidate");
                    header("Pragma: public");
                    header("Content-Length: " . filesize($filepath));
                    flush(); // Flush system output buffer
                    readfile($filepath);
                    die();
                } else {
                    http_response_code(404);
                    die();
                }
            } else {
                die("Invalid file name!");
            }
        }
    }

	public function SeatAllocation()
    {
        $std = $this->db
            ->select("*")
            ->from("resrvation_table")
            ->where("rc_main_id", 5)
            ->where(
                "rc_cource_id",
                $this->session->userdata("user")["user_dep_status"]
            )
            ->get();

        $data["reservation"] = $std->result();

        $this->load->view("template/ugselffinance/header");
        $this->load->view("template/ugselffinance/menubar");
        $this->load->view("template/ugselffinance/headerbar");
        $this->load->view("ugselffinance/seat_allocation", $data);
        $this->load->view("template/ugselffinance/footer");
    }

	public function updateSeatAllocation()
    {
        $uid = $_POST["u_id"];
        $count = $_POST["count"];

        $data = [
            "rc_count" => $count,
        ];

        $this->db->where("rs_id", $uid);
        $this->db->update("resrvation_table", $data);

        echo $this->session->set_flashdata(
            "message",
            ' <div class="alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong> Updated Successfully !
</div>'
        );
    }
	public function tempShortlist()
    {


        $std = $this->db
            ->select("*")
            ->from("resrvation_table")
            ->where("rc_main_id", 5)
            ->where(
                "rc_cource_id",
                $this->session->userdata("user")["user_dep_status"]
            )
            ->get();

        $data["reservation"] = $std->result();
        $this->load->view("template/ugselffinance/header");
        $this->load->view("template/ugselffinance/menubar");
        $this->load->view("template/ugselffinance/headerbar");
        $this->load->view("ugselffinance/temp_shot_list", $data);
        $this->load->view("template/ugselffinance/footer");
    }



	public function selectAllotmentcount()
    {
        $std = $this->db
            ->select("*")
            ->from("resrvation_table")
            ->where("rc_main_id", 5)
            ->where("rs_name", $_POST["m"])
            ->where(
                "rc_cource_id",
                $this->session->userdata("user")["user_dep_status"]
            )
            ->get();

        $M = $std->result();

        echo $M[0]->rc_count;
    }

	public function selectAllotmentType()
    {
        //print_r($_POST);
        $user = $this->db
            ->select("sl_student_id")
            ->from("shotlisted_candidate")
            ->where("sl_main_id", 5)
            ->where(
                "sl_course_id",
                $this->session->userdata("user")["user_dep_status"]
            )
				->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
            ->get();

        $res = $user->result_array();

        $arr = array_column($res, "sl_student_id");

        if (sizeof($arr) > 0) {
            $user_not_select = $this->db->where_not_in(
                "verified_ug.stu_id",
                $arr
            );
        } else {
            $user_not_select = "";
        }

        /* 
 echo"<pre>";
print_r($arr);
 */

        if ($_POST["res"] == "MERIT") {
            $where = $this->db->where("verified_ug.community !=", "");
        } elseif ($_POST["res"] == "OC") {
            $where = $this->db->where("verified_ug.community !=", "");
        } elseif ($_POST["res"] == "MANAGEMENT") {
            $where = $this->db->where("verified_ug.community !=", "");
        } else {
            $where = $this->db->where(
                "verified_ug.community",
                $_POST["res"]
            );
        }
        if ($_POST["special_res"] != "") {
            $where_spe_res = $this->db->where(
                "new_preview.pr_other_special_reservation",
                $_POST["special_res"]
            );
        } else {
            $where_spe_res = "";

			 
        } if ($_POST["board"] != "") {
            $where_board_res = $this->db->where(
                "new_preview.pr_board_study",
                $_POST["board"]
            );
        } else {
            $where_board_res = "";
        }

        $this->db->select(
            "verified_ug.*,new_preview.pr_other_special_reservation,new_preview.pr_board_study,new_preview.pr_applicant_name"
        );
        $this->db->from("verified_ug");
        $this->db->join(
            "new_preview",
            "verified_ug.stu_id=new_preview.pr_user_id","left"
        );
        $this->db->where("verified_ug.main_id",5);
        $this->db->where(
            "verified_ug.applied_id",
            $this->session->userdata("user")["user_dep_status"]
        );
       $this->db->where(
            "verified_ug.verified_date  >",
            $this->syear.'-06-01'
        ); 
		
       $this->db->where(
            "verified_ug.verified_date <",
			$this->eyear.'-06-01'
        );
		$where_board_res;
        $user_not_select;
        $where;
        $where_spe_res;
        $this->db->group_by('verified_ug.stu_id'); 
        $this->db->order_by("verified_ug.percentage_obtained", "DESC");
        $this->db->limit($_POST["count"]);
        $nr = $this->db->get();

        $nt = $nr->result();

        $html = "";


/* echo"<pre>";
        print_r($nt); */

        foreach ($nt as $key => $value) {
            $html .=
                ' <tr>
	<td scope="col"><input type="checkbox" class="check_box"  checked name="user_id[]" value="' .
                $value->stu_id .
                '"></td>
	<td scope="col">' .
                $value->pr_applicant_name .
                '</td>
		<td scope="col">' .
    sprintf ("%.2f",$value->percentage_obtained) .
                '</td> 
	<td scope="col">' .
                $value->community .
                '</td> 
	<td scope="col">' .
                $value->special_reservation .
                '</td> <td scope="col">' .
                $value->pr_board_study .
                '</td> 
  </tr>';
        } 
        echo $html;
    }

	public function registerAllocation()
    {
        //print_r($_POST);
        if (isset($_POST["user_id"])) {
            foreach ($_POST["user_id"] as $key => $value) {
                $user = $this->db
                    ->select("*")
                    ->from("shotlisted_candidate")
                    ->where("sl_student_id", $value)
                    ->where("sl_main_id", 5)
                    ->where(
                        "sl_course_id",
                        $this->session->userdata("user")["user_dep_status"]
                    )
						->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
                    ->get();


					$mark = $this->db
                    ->select("*")
                    ->from("verified_ug")
					
					
                    ->where("verified_ug.stu_id", $value)
                    ->where("verified_ug.main_id", 5)
                    ->where("verified_ug.verified_date >", $this->syear.'-06-01')
                    ->where("verified_ug.verified_date <", $this->eyear.'-06-01')
                    ->where(
                        "verified_ug.applied_id",
                        $this->session->userdata("user")["user_dep_status"]
                    )
						
                    ->get();

                $res = $user->num_rows();

                if ($res == 0) {

					$restt = $mark->result();


					$data = [
						"sl_student_id" => $value,
						"sl_main_id" => 5,
						"sl_course_id" => $this->session->userdata("user")[
							"user_dep_status"
						],
						"sl_caste" => $restt[0]->community,
						"selection_list_name" => $_POST["reservation"],
						"sl_reservation" => $_POST["other_res"],
						"reservation_status" => $_POST["Allotment"],
					];
	




                    $this->db->insert("shotlisted_candidate", $data);
                }
            }
            $this->session->set_flashdata(
                "message",
                ' <div class="alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong> Shortlisted Success !
</div>'
            );

            redirect("UgSelfFinance/tempShortlist", "refresh");
        } else {
            $this->session->set_flashdata(
                "message",
                ' <div class="alert alert-danger alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Failed !</strong> Failed to Shotlist 
	</div>'
            );

            redirect("UgSelfFinance/tempShortlist", "refresh");
        }
    }
	public function viewAllotment()
    {
        $id = $this->uri->segment(3);

        $user = $this->db
        ->select("*")
        ->from("shotlisted_candidate")
        ->join(
            "Applyed_Cources",
            "Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id"
        )

        ->join(
            "verified_ug",
            "verified_ug.stu_id=shotlisted_candidate.sl_student_id  AND verified_ug.applied_id=shotlisted_candidate.sl_course_id"
       ,'right' )
	   ->join("accounts_fees_transaction","accounts_fees_transaction.af_main_id = shotlisted_candidate.sl_main_id AND accounts_fees_transaction.af_course_id = shotlisted_candidate.sl_course_id AND accounts_fees_transaction.af_student_id = shotlisted_candidate.sl_student_id AND accounts_fees_transaction.af_paid_status =1" ,"left")
           ->join(
            "new_preview",
            "shotlisted_candidate.sl_student_id=new_preview.pr_user_id"
        ) 
        ->where("shotlisted_candidate.sl_main_id",5)
		//->where("accounts_fees_transaction.af_paid_status",1)
        ->where(
            "shotlisted_candidate.sl_course_id",
            $this->session->userdata("user")["user_dep_status"]
        )
        ->where("shotlisted_candidate.reservation_status", $id)
			->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
      ->order_by("verified_ug.percentage_obtained", "DESC")
        ->get();

        $data["student"] = $user->result();
        $data['title'] = "Reports of  ".$this->session->userdata('user')['user_name']." ".date('d-M-Y');
        $this->load->view("template/ugselffinance/header");
        $this->load->view("template/ugselffinance/menubar");
        $this->load->view("template/selffinance/headerbar");
        $this->load->view("ugselffinance/shortlisted_list", $data);
        $this->load->view("template/ugselffinance/footer", $data);
    }

	public function SelectWaitingList()
    {
        $tmr = $_POST["id"];
        $sel = $_POST["sel"];

        $res = $this->db
            ->select("*")
            ->from("shotlisted_candidate")
            ->where("sl_id", $tmr)
				->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
            ->get();

        $out = $res->result();

        $main_course = $out[0]->sl_main_id;
        $applied_course = $out[0]->sl_course_id;
        $selection = $out[0]->selection_list_name;

   

if($selection == "MERIT" || $selection == "OC" || $selection == "MANAGEMENT" ){

    $user = $this->db
    ->select("*")
    ->from("shotlisted_candidate")
    ->join(
        "Applyed_Cources",
        "Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id"
    )
	->join(
		"verified_ug",
		"verified_ug.stu_id=shotlisted_candidate.sl_student_id  AND verified_ug.applied_id=shotlisted_candidate.sl_course_id"
    )
 
    ->join(
        "new_preview",
        "shotlisted_candidate.sl_student_id=new_preview.pr_user_id"
    )
    ->where("sl_main_id", 5)
   
    ->where(
        "sl_course_id",
        $this->session->userdata("user")["user_dep_status"]
    )
    ->where("reservation_status", 2)
		->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
	->order_by("verified_ug.percentage_obtained", "DESC")
    ->limit(1)
    ->get();

}else{


    $user = $this->db
    ->select("*")
    ->from("shotlisted_candidate")
    ->join(
        "Applyed_Cources",
        "Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id"
    )
	->join(
		"verified_ug",
		"verified_ug.stu_id=shotlisted_candidate.sl_student_id  AND verified_ug.applied_id=shotlisted_candidate.sl_course_id"
    )
 
    ->join(
        "new_preview",
        "shotlisted_candidate.sl_student_id=new_preview.pr_user_id"
    )
    ->where("sl_main_id", 5)
	->where("sl_caste", $selection)
    ->where(
        "sl_course_id",
        $this->session->userdata("user")["user_dep_status"]
    )
    ->where("reservation_status", 2)
		->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
	->order_by("verified_ug.percentage_obtained", "DESC")
    ->limit(1)
    ->get();


}


     

        $resul = $user->num_rows();

        if ($resul > 0) {
            //echo $resul = $user->num_rows();
            $m_n = $user->result();

            $conform = [
                "reservation_status" => 1,
                "selection_list_name" => $selection,
                "selection_list" => $sel
            ];

            $this->db->where("sl_id", $m_n[0]->sl_id);
            $this->db->update("shotlisted_candidate", $conform);

            $reject = [
                "reservation_status" => 3,
                "selection_list" => $sel
            ];

            $this->db->where("sl_id", $tmr);
            $this->db->update("shotlisted_candidate", $reject);


//////////////////////////
$user = $this->db
->select("sl_student_id")
->from("shotlisted_candidate")
->where("sl_main_id", 5)
->where(
    "sl_course_id",
    $this->session->userdata("user")["user_dep_status"]
)
	->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
->get();

$res = $user->result_array();

$arr = array_column($res, "sl_student_id");

if (sizeof($arr) > 0) {
$user_not_select = $this->db->where_not_in(
    "verified_ug.stu_id",
    $arr
);
} else {
$user_not_select = "";
}

/* 
echo"<pre>";
print_r($arr);
*/

if ($selection == "MERIT") {
$where = $this->db->where("verified_ug.community !=", "");
} elseif ($selection == "OC") {
$where = $this->db->where("verified_ug.community !=", "");
} elseif ($selection == "MANAGEMENT") {
$where = $this->db->where("verified_ug.community !=", "");
} else {
$where = $this->db->where(
    "verified_ug.community",
    $selection
);
}
/* if ($_POST["special_res"] != "") {
$where_spe_res = $this->db->where(
    "new_preview.pr_other_special_reservation",
    $_POST["special_res"]
);
} else {
$where_spe_res = "";
} */

$this->db->select(
"verified_ug.*,new_preview.pr_other_special_reservation,new_preview.pr_applicant_name"
);
$this->db->from("verified_ug");
$this->db->join(
"new_preview",
"verified_ug.stu_id=new_preview.pr_user_id"
);
$this->db->where("verified_ug.main_id", 5);
$this->db->where(
"verified_ug.applied_id",
$this->session->userdata("user")["user_dep_status"]
);

$user_not_select;
$where;
//$where_spe_res;
$this->db->where('verified_ug.verified_date >',$this->syear.'-06-01');
$this->db->where('verified_ug.verified_date <',$this->eyear.'-06-01');
$this->db->order_by("verified_ug.percentage_obtained", "DESC");
$this->db->limit(1);
$nr = $this->db->get();



$waitr = $nr->num_rows();

if ($waitr > 0) {
$wait= $nr->result();


$data = [
    "sl_student_id" => $wait[0]->stu_id,
    "sl_main_id" => 5,
    "sl_course_id" => $this->session->userdata("user")[
        "user_dep_status"
    ],
                "reservation_status" => 2,
                "sl_caste" => $wait[0]->community,
                "selection_list_name" => $selection,
                "selection_list" => $sel
];


    $this->db->insert("shotlisted_candidate", $data);
}


            echo $this->session->set_flashdata(
                "message",
                ' <div class="alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong> successfully Updated !
</div>'
            );
        } else {
            echo $this->session->set_flashdata(
                "message",
                ' <div class="alert alert-danger alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Failed to Update !</strong> No Records found to Updatein waiting list ' .
                    $selection .
                    '
	</div>'
            );

            //echo $resul = $user->num_rows();
        }
    }

    public function rejectSelectionList()
    {
        $tmr = $_POST["id"];

        $res = $this->db
            ->select("*")
            ->from("shotlisted_candidate")
            ->where("sl_id", $tmr)
				->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
            ->get();

        $out = $res->result();

        $main_course = $out[0]->sl_main_id;
        $applied_course = $out[0]->sl_course_id;
        $selection = $out[0]->selection_list_name;

        $wait = $this->db
            ->select("*")
            ->from("shotlisted_candidate")
            ->where("sl_main_id", $main_course)
            ->where("sl_course_id", $applied_course)
            ->where("selection_list_name", $selection)
            ->where("reservation_status", 2)
				->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
            ->get();

        $rest = $wait->num_rows();

        $user = $this->db
            ->select("*")
            ->from("shotlisted_candidate")
            ->join(
                "Applyed_Cources",
                "Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id"
            )
        	->join(
                "verified_ug",
                "verified_ug.stu_id=shotlisted_candidate.sl_student_id  AND verified_ug.applied_id=shotlisted_candidate.sl_course_id"
            )
            ->join(
                "new_preview",
                "shotlisted_candidate.sl_student_id=new_preview.pr_user_id"
            )
            ->where("sl_main_id", 5)
            ->where("selection_list_name", $selection)
            ->where(
                "sl_course_id",
                $this->session->userdata("user")["user_dep_status"]
            )
            ->where("reservation_status", 1)
				->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
            ->order_by("verified_ug.percentage_obtained", "ASC")
            ->limit(1)
            ->get();

        $resul = $user->num_rows();

        if ($resul > 0) {
            //echo $resul = $user->num_rows();
            $m_n = $user->result();

          /*   $conform = [
                "reservation_status" => 2,
            ];

            $this->db->where("sl_id", $m_n[0]->sl_id);
            $this->db->update("shotlisted_candidate", $conform); */

            $reject = [
                "reservation_status" => 2,
            ];

            $this->db->where("sl_id", $tmr);
            $this->db->update("shotlisted_candidate", $reject);

            echo $this->session->set_flashdata(
                "message",
                ' <div class="alert alert-warning alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong> successfully Moved to Waiting List!
</div>'
            );
        } 
    }
    public function SelectionStatus()
    {
        $sl = $this->db
            ->select("*")
            ->from("shotlisted_candidate")

            ->join(
                "verified_ug",
                "verified_ug.stu_id=shotlisted_candidate.sl_student_id  AND verified_ug.applied_id=shotlisted_candidate.sl_course_id"
            )

            ->where("sl_main_id", 5)
            ->where("reservation_status", 1)
            ->where(
                "sl_course_id",
                $this->session->userdata("user")["user_dep_status"]
            )
				->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
            ->group_by("selection_list_name")
            ->get();

        $data["selection_list"] = $sl->result();

        $wt = $this->db
            ->select("*")
            ->from("shotlisted_candidate")

            ->join(
                "verified_ug",
                "verified_ug.stu_id=shotlisted_candidate.sl_student_id  AND verified_ug.applied_id=shotlisted_candidate.sl_course_id"
            )

            ->where("sl_main_id",5)
            ->where("reservation_status", 2)
            ->where(
                "sl_course_id",
                $this->session->userdata("user")["user_dep_status"]
            )
				->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
            ->group_by("selection_list_name")
            ->get();

        $data["Waitinglist_list"] = $wt->result();

        $rj = $this->db
            ->select("*")
            ->from("shotlisted_candidate")

            ->join(
                "verified_ug",
                "verified_ug.stu_id=shotlisted_candidate.sl_student_id  AND verified_ug.applied_id=shotlisted_candidate.sl_course_id"
            )

            ->where("sl_main_id", 5)
            ->where("reservation_status", 3)
            ->where(
                "sl_course_id",
                $this->session->userdata("user")["user_dep_status"]
            )
				->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
            ->group_by("selection_list_name")
            ->get();

        $data["rejection_list"] = $rj->result();

        /* echo"<pre>";
         print_r($data); */

        $this->load->view("template/ugselffinance/header");
        $this->load->view("template/ugselffinance/menubar");
        $this->load->view("template/ugselffinance/headerbar");
        $this->load->view("ugselffinance/shotlist_status", $data);
        $this->load->view("template/ugselffinance/footer");
    }


    public function ShotlistedCandidates()
    {
        $status = $this->uri->segment(3);
        $res = str_replace("%20", " ", $this->uri->segment(4));

        if ($res == "MBC ") {
            $reservation = "MBC / DNC";
        } else {
            $reservation = $this->uri->segment(4);
        }

        $sl = $this->db
            ->select("*,selection_list_name")
            ->from("shotlisted_candidate")
            ->join(
                "new_preview",
                "shotlisted_candidate.sl_student_id=new_preview.pr_user_id"
            )
            ->join(
                "Applyed_Cources",
                "Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id"
            )
            ->join(
                "verified_ug",
                "verified_ug.stu_id=shotlisted_candidate.sl_student_id  AND verified_ug.applied_id=shotlisted_candidate.sl_course_id"
            )

            ->where("sl_main_id", 5)
            ->where("reservation_status", $status)
            ->where("selection_list_name", $reservation)
            ->where(
                "sl_course_id",
                $this->session->userdata("user")["user_dep_status"]
            )
				->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
            ->order_by("verified_ug.percentage_obtained", "DESC")
            ->get();
        $data["candidate_list"] = $sl->result();
        $data["reservation_type"] = $reservation;
        $data["status"] = $status;

        $this->load->view("template/ugselffinance/header");
        $this->load->view("template/ugselffinance/menubar");
        $this->load->view("template/ugselffinance/headerbar");
        $this->load->view("ugselffinance/selection_candidate_status", $data);
        $this->load->view("template/ugselffinance/footer");
    }





    public function deleteShotlistedCandidates()
    {
        $status = $this->uri->segment(3);
        $res = str_replace("%20", " ", $this->uri->segment(4));

        if ($res == "MBC ") {
            $reservation = "MBC / DNC";
        } else {
            $reservation = $this->uri->segment(4);


        }


            $sl = $this->db         
            ->where("sl_main_id", 5)
            ->where("reservation_status", $status)
            ->where("selection_list_name", $reservation)
            ->where(
                "sl_course_id",
                $this->session->userdata("user")["user_dep_status"]
            )
				->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
            ->delete("shotlisted_candidate");


            $this->session->set_flashdata(
                "message",
                ' <div class="alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong> Deleted Successfully !
</div>'
            );

            redirect("UgSelfFinance/SelectionStatus", "refresh");

    }

    public function studentCertificate()
    {
        $user_id = $this->uri->segment(3);

        $pr_user = $this->db
            ->select("*")
            ->from("new_preview")
            ->where("pr_user_id", $user_id)
            ->get();

        $data["user"] = $pr_user->result();

        $cer_com = $this->db
            ->select("*")
            ->from("Certificate_comments_ug")
            ->where("student_id", $user_id)
            ->get();
        $cer = $cer_com->num_rows();

        if ($cer == 0) {
            $insert = [
                "student_id" => $user_id,
                "date" => date("Y-m-d"),
                //'status'=>1,
            ];
            $this->db->insert("Certificate_comments_ug", $insert);
        }
        $cer_comm = $this->db
            ->select("*")
            ->from("Certificate_comments_ug")
            ->where("student_id", $user_id)
            ->get();
        $data["user_certificate"] = $cer_comm->result();

        //$data['certificate'] = array($cer[0]->pr_semester_1, $cer[0]->pr_semester_2, $cer[0]->pr_semester_3, $cer[0]->pr_semester_4, $cer[0]->pr_semester_5, $cer[0]->pr_semester_6, $cer[0]->pr_semester_7, $cer[0]->pr_semester_8, $cer[0]->pr_provisional_pg_cer, $cer[0]->pr_ug_cer, $cer[0]->pr_cummulative_cer, $cer[0]->pr_community_cer, $cer[0]->pr_conduct_cer, $cer[0]->pr_transfer_cer, $cer[0]->pr_abled_certificate);

        //print_r($certificates);

        $this->load->view("template/ugselffinance/header");
        $this->load->view("template/ugselffinance/menubar");
        $this->load->view("template/ugselffinance/headerbar");
        $this->load->view("ugselffinance/certificates", $data);
        $this->load->view("template/ugselffinance/footer");
    }

    public function certificateComments(){




        print_r($_POST);




    }
    public function ShotlistPdf()
    {
         
        $sl = $this->db
        ->select("*")
        ->from("shotlisted_candidate")
        ->join(
            "new_preview",
            "shotlisted_candidate.sl_student_id=new_preview.pr_user_id"
        )
        ->join(
            "Applyed_Cources",
            "Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id"
        )
        ->join(
            "verified_ug",
            "verified_ug.stu_id=shotlisted_candidate.sl_student_id  AND verified_ug.applied_id=shotlisted_candidate.sl_course_id"
        )

        ->where("sl_main_id", 5)
        ->where("reservation_status", $_POST["status"])
        ->where("selection_list_name", $_POST["reservation_type"])
        ->where("selection_list", $_POST["csl"])
        ->where(
            "sl_course_id",
            $this->session->userdata("user")["user_dep_status"]
        )
			->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
        ->order_by("verified_ug.percentage_obtained", "DESC")
        ->get();
    $Candidate = $sl->result_array();
    //print_r(	$Candidate);print_r(	$_POST);

    $temp = "";

    $i = 1;
    foreach ($Candidate as $tnt) {
        $temp .=
            '   <tr align="center">
<td>' .
            $i .
            '</td>
<td>' .
            $tnt["application_number"] .
            '</td>
<td>' .
            strtoupper($tnt["pr_applicant_name"]) .
            '</td>

<td>' .
            date("d-m-Y", strtotime($tnt["pr_dob"])) .
            '</td>

<td>' .
sprintf ("%.2f",$tnt["percentage_obtained"]) .
            '</td>
<td>' .
            $tnt["community"] .
            '</td>

</tr>';

        $i++;
    }

    if ($_POST["status"] == 1) {
        $status = "SELECTION LIST";
    } elseif ($_POST["status"] == 2) {
        $status = "WAITING LIST";
    } else {
        $status = "REJECTION LIST";
    }
    if ($_POST["venue"] != "") {
        $venue = "<b> Admission Venue  : " . $_POST["venue"] . "</b> ";
    } else {
        $venue = "";
    }

    $filename =
    strtoupper($_POST["title"]) .
        " - " .
        $_POST["reservation_type"] .
        $status ." FOR ".
        strtoupper($Candidate[0]["course_name"]);

    $dompdf = new DOMPDF();
    $html =
        '
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>MSSW</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: x-small;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }
    .gray {
        background-color: lightgray
    }
    .center {
        display: block;
        margin: 10px auto 20px;
        
      }
      #center {  
        text-align: center;  
        border: 2px solid blue;  
        }  


     tr:nth-child(even){background-color: #f2f2f2;}

 tr:hover {background-color: #ddd;}
      
</style>

</head>
<body>
<div id ="center">  
<img  src="http://admission.mssw.in//landing/images/mssw_logo.jpg" width="60%" height="75px;">
</div>  

<br>
<h3 align="center"> ' .
        $_POST["title"] .
        " - " .
        $_POST["reservation_type"] .' '.
        
        $status ." FOR ".
        strtoupper($Candidate[0]["course_name"]) .
        '</h3>
<table width="100%">
<tbody>
      
      <td width="50%"><b> Admission Name : ' .
        $_POST["reservation_type"] .
        " - " .
        $status .
        '</b></td>
      <td  width="50%"> <b> Admission Date  : ' .
        date("d-m-Y", strtotime($_POST["Date"])) .
        '</b></td>

    
</tbody>
</table>
<table width="100%">
<tbody>
      
     <td width="50%">  ' .
        $venue .
        ' </td>
     <td width="50%"> <b> Admission Time  : ' .
        date("h:i A", strtotime($_POST["time"])) .
        '</b></td>
</tbody>
</table>
<br>
  <table width="100%">
  <thead style="background-color: lightgray;">
    <tr>
      <th  width="15%">S.No</th>
      <th width="15%">Application Number</th>
      <th width="25%">Student Name</th>
      <th width="15%">Date of Birth</th>
          <th width="15%">+2 Percentage</th>
      <th width="15%">Community</th>
         
    </tr>
  </thead>
  <tbody>
' .
        $temp .
        '
  </tbody>
  </table>
  
  <br>
  <br>
  <br>
  <br>
  
  <div>
  <div align="left"> HoD/Program Head</div>
 
  
  <div align="right"> Principal</div>
  </div>
  <br>
  <br>
  <br>
  <footer>
  <h6 align="center">Generated by MSSW Campus Management System.</h6>
  </footer>
'; 

    $dompdf->load_html($html);
    $dompdf->render();

    $dompdf->stream($filename . "pdf");
  $file =  $dompdf->output($filename . "pdf");

$folder = $this->session->userdata('user')['user_name'];
$rootfold = "uploads/UG/" . $folder . "/";

if (!file_exists($rootfold)) {
    mkdir("uploads/UG/" . $folder, 0777);
   
} 
	
			file_put_contents($rootfold.$filename.".pdf",$file);

    }

	public function personalMailUser()
    {
        $ud = $this->db
            ->select("u_email_id,u_mobile")
            ->from("stu_user")
            ->where("u_id", $_POST["student_id"])
            ->get();
        $res = $ud->result();

        $usn = $this->db
            ->select("pr_applicant_name")
            ->from("new_preview")
            ->where("pr_user_id", $_POST["student_id"])
            ->get();
        $usr_name = $usn->result();

        $email_subject = $this->input->post("email_subject");
        $email_content = $this->input->post("email_content");

        $config = [
            "protocol" => "smtp",
            "smtp_host" => "ssl://smtp.gmail.com",
            "smtp_port" => 465,
            "smtp_user" => "admission.mssw@gmail.com",
            "smtp_pass" => "loveindia@123",
            "mailtype" => "html",
            "charset" => "iso-8859-1",
        ];
        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");




//print_r($_POST);

        $msg =
            "Dear " .
            $usr_name[0]->pr_applicant_name .
            ",<br><br>" .
            $email_content;






      //  $this->testEmail("yuvaraj@istudiotech.com", $email_subject, $msg);
        $this->testEmail($res[0]->u_email_id, $email_subject, $msg);

        $this->session->set_flashdata(
            "message",
            ' <div class="alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong> Emailed  to .' .
                $usr_name[0]->pr_applicant_name .
                ' Successfully
</div>'
        );

        redirect("UgSelfFinance/studentApplied", "refresh"); 
    }











	public function SaveApplication(){

		//$image_P=NULL;
	
	$payed=$this->uri->segment(3);
	$apply = $this->input->post('appli');
	
	
	
	
	//--------------------------------basic------------------//
	
	$candidate_name = $this->input->post('candidate_name');
	$candidate_email = $this->input->post('candidate_email');
	$candidate_mobile = $this->input->post('candidate_mobile');
	
	
	/* $course_one = $this->input->post('course_one');
	$course_ug = implode(",",$course_one); */
	
	
	$language_offered = $this->input->post('language_offered');
	$dob = $this->input->post('dob');
	$age = $this->input->post('age');
	$m_tounge = $this->input->post('m_tounge');
	$place_of_birth = $this->input->post('place_of_birth');
	$gender = $this->input->post('gender');
	$Nationality = $this->input->post('Nationality');
	
	//new --entery //
	$country = $this->input->post('country');
	$passportnumber = $this->input->post('passportnumber');
	$pp_exp = $this->input->post('pp_exp');
	$blood_group = $this->input->post('blood_group');
	
	
	$Religion = $this->input->post('Religion');
	$Caste = $this->input->post('Caste');
	$Community = $this->input->post('Community');
	$father_name = $this->input->post('father_name');
	$mother_name = $this->input->post('mother_name');
	$guardion_name = $this->input->post('guardion_name');
	$father_mob_num = $this->input->post('father_mob_num');
	$mother_mob_num = $this->input->post('mother_mob_num');
	$guardion_mob_num = $this->input->post('guardion_mob_num');
	
	//new --entery //
	$father_email = $this->input->post('father_email');
	$mother_email = $this->input->post('mother_email');
	$guardion_email = $this->input->post('guardion_email');
	$other_res = $this->input->post('other_res');
	$other_special_reservation = $this->input->post('other_special_reservation');
	$hostel = $this->input->post('hostel');
	
	
	$father_accupation = $this->input->post('father_accupation');
	$mother_accupation = $this->input->post('mother_accupation');
	$guardion_accupation = $this->input->post('guardion_accupation');
	$father_anuval_income = $this->input->post('father_anuval_income');
	$mother_anuval_income = $this->input->post('mother_anuval_income');
	$guardion_anuval_income = $this->input->post('guardion_anuval_income');
	$local_address = $this->input->post('local_address');
	$local_area = $this->input->post('local_area');
	$local_city = $this->input->post('local_city');
	$local_state = $this->input->post('local_state');
	$local_country = $this->input->post('local_country');
	$local_pincode = $this->input->post('local_pincode');
	$pr_address = $this->input->post('pr_address');
	$pr_area = $this->input->post('pr_area');
	$pr_city = $this->input->post('pr_city');
	$pr_state = $this->input->post('pr_state');
	$pr_country = $this->input->post('pr_country');
	$pr_pincode = $this->input->post('pr_pincode');
	$identification_one = $this->input->post('identification_one');
	$identification_two = $this->input->post('identification_two');
	$abled = $this->input->post('abled');
	$abled_reason = $this->input->post('abled_reason');
	$regnumber = $this->input->post('regnumber');
	$institute = $this->input->post('institute');
	$institutionname = $this->input->post('institutionname');
	$study_bord = $this->input->post('study_bord');
	$other_bord = $this->input->post('other_bord');
	$medium = $this->input->post('medium');
	$year_of_passing = $this->input->post('year_of_passing');
	$break_in_study = $this->input->post('break_in_study');
	$break_reason = $this->input->post('break_reason');
	$stream = $this->input->post('stream');
	$pass_in_first_att = $this->input->post('pass_in_first_att');
	$lang_studied = $this->input->post('lang_studied');
	$lang_others = $this->input->post('lang_others');
	$sports_name = $this->input->post('sports_name');
	$sports_psition = $this->input->post('sports_psition');
	$extra_caricular_activities = $this->input->post('extra_caricular_activities');
	$acknoledgement = $this->input->post('acknoledgement');
	
	
	
	$sslc_institution = $this->input->post('sslc_institution');
	$sslc_medium = $this->input->post('sslc_medium');
	$year_of_passing_sslc = $this->input->post('year_of_passing_sslc');
	$sslc_lang_under_part_two = $this->input->post('sslc_lang_under_part_two');
	
	$plus2_institution = $this->input->post('plus2_institution');
	$plus2_medium = $this->input->post('plus2_medium');
	$year_of_passing_plus2 = $this->input->post('year_of_passing_plus2');
	$plus2_lang_under_part_two = $this->input->post('plus2_lang_under_part_two');
	
	
	$update_details = array(
			'pr_applicant_name'=>$candidate_name,
			'candidate_email'=>$candidate_email,
			'candidate_mobile'=>$candidate_mobile,
		//	'pr_course_1'=>$course_ug,
			'pr_language'=>$language_offered,
			'pr_dob'=>$dob,
			'pr_age'=>$age,
			'pr_mother_toung'=>$m_tounge,
			'pr_place_of_birth'=>$place_of_birth,
			'pr_gender'=>$gender,
			'pr_nationality'=>$Nationality,
			'pr_country'=>$country,
			'pr_passportnumber'=>$passportnumber,
			'pr_pp_exp'=>$pp_exp,
			'pr_blood_group'=>$blood_group,
			'pr_religion'=>$Religion,
			'pr_caste'=>$Caste,
			'pr_community'=>$Community,
		
			'pr_father_name'=>$father_name,
			'pr_mother_name'=>$mother_name,
			'pr_gaurdion_name'=>$guardion_name,
			'pr_father_mobnum'=>$father_mob_num,
			'pr_mother_mobnum'=>$mother_mob_num,
			'pr_gaurdion_mobnum'=>$guardion_mob_num,
			
			'pr_father_email'=>$father_email,
			'pr_mother_email'=>$mother_email,
			'pr_gaurdion_email'=>$guardion_email,
	
	
			'pr_father_anuval_income'=>$father_anuval_income,
			'pr_mother_anuval_income'=>$mother_anuval_income,
			'pr_gaurdion_anuval_income'=>$guardion_anuval_income,
			'pr_father_accu'=>$father_accupation,
			'pr_mother_accu'=>$mother_accupation,
			'pr_gaurdion_accu'=>$guardion_accupation,
			'pr_local_address'=>$local_address,
			'pr_local_area'=>$local_area,
			'pr_local_city'=>$local_city,
			'pr_local_state'=>$local_state,
			'pr_local_country'=>$local_country,
			'pr_local_pincode'=>$local_pincode,
			'pr_permanent_address'=>$pr_address,
			'pr_permanent_area'=>$pr_area,
			'pr_permanent_city'=>$pr_city,
			'pr_permanent_state'=>$pr_state,
			'pr_permanent_country'=>$pr_country,
			'pr_permanent_pincode'=>$pr_pincode,
			'pr_identification_one'=>$identification_one,
			'pr_identification_two'=>$identification_two,
			'pr_differently_abled'=>$abled,
			'pr_differently_abled_reson'=>$abled_reason,
		
			'pr_certificate_regist_numb'=>$regnumber,
			////////////////////////
			'pr_institute_last_attanded'=>$institute,
			'pr_insti_name'=>$institutionname,
			'pr_board_study'=>$study_bord,
			'pr_bord_other'=>$other_bord,
			'pr_medium_of_instruct'=>$medium,
			'pr_month_year_pass'=>$year_of_passing,
			'pr_break_in_syudy'=>$break_in_study,
			'pr_break_reason'=>$break_reason,
			'pr_Stream'=>$stream,
			'pr_passed_in_first_attemt'=>$pass_in_first_att,
			'pr_languvage_studied'=>$lang_studied,
			'pr_others_lang'=>$lang_others,
			'pr_name_of_game'=>$sports_name,
			'pr_game_position'=>$sports_psition,
			'pr_extra_caricular_act'=>$extra_caricular_activities,
			'pr_acknoledge'=>$acknoledgement,
			'pr_other_res'=>$other_res,
			'pr_other_special_reservation'=>$other_special_reservation,
			'pr_hostel'=>$hostel,
	
	
	
	
			'pr_sslc_school'=>$sslc_institution,
			'pr_sslc_year_of_passing'=>$year_of_passing_sslc,
			'pr_sslc_medium_of_inst'=>$sslc_medium,
			'pr_sslc_lang_under_2'=>$sslc_lang_under_part_two,
			
			
			'pr_plus2_school'=>$plus2_institution,
			'pr_plus2_year_of_passing'=>$year_of_passing_plus2,
			'pr_plus2_medium_of_inst'=>$plus2_medium,
			'pr_plus2_lang_under_2'=>$plus2_lang_under_part_two,
	
	
	
	);
	
	
	
	//Markdheet details
	//$candidate_name = $this->input->post('candidate_name');
	
	
	
	
	
	
	
	
	
/* 	
	$part_lang_1  = $this->input->post('part_lang_1');
	$part_lang_2  = $this->input->post('part_lang_2');
	$max_mark_lang_1  = $this->input->post('max_mark_lang_1');
	$mark_lang_1  = $this->input->post('mark_lang_1');
	$max_mark_lang_2  = $this->input->post('max_mark_lang_2');
	$mark_lang_2  = $this->input->post('mark_lang_2');
	$max_mark_pg  = $this->input->post('max_mark');
	$total_subject  = $this->input->post('total_subject');
	$total_mark_obt  = $this->input->post('total_mark');
	$tot_percent  = $this->input->post('over_all_percentage');
	
	
	
	$subject_mark = array(
	
	
		
		'lang_1'=>$part_lang_1,
		'lang_2'=>$part_lang_2,
		'lang_1_max_mark'=>$max_mark_lang_1,
		'lang_2_max_mark'=>$max_mark_lang_2,
		'lang_1_obt_mark'=>$mark_lang_1,
		'lang_2_obt_mark'=>$mark_lang_2,
		'ug_max_mark'=>$max_mark_pg,
		'total_subject'=>$total_subject,
		'total_mark_obt'=>$total_mark_obt,
		'tot_percent'=>$tot_percent,
	
	
	);
	
	$sub_name = $this->input->post("subject_name");
	$obt_mark = $this->input->post("obt_mark");
	$percentage = $this->input->post("percentage");
	
	echo sizeof($sub_name);
	print_r($sub_name);
	
	if(!empty( $sub_name)){
	
	
	
	for ($i=0; $i < sizeof($sub_name); $i++) { 
		
		$main_mark = array(
			'student_id'=>$this->session->userdata('user')['user_id'],
			'ug_subject_name'=>$sub_name[$i],
			'ug_max_mark'=>$max_mark_pg[$i],
			'ug_mark_obtained'=>$obt_mark[$i],
			'ud_percentage'=>$percentage[$i],
		);
	
		$this->db->insert('sub_preview_ug_main_sub',$main_mark);
		
	}
	
	}
	 */
	
	
	 

		
		$this->db->where('pr_user_id',$payed);
		$this->db->update('new_preview',$update_details);
	
	
	
	
/* 		$this->db->where('sb_u_id',$this->session->userdata('user')['user_id']);
		$this->db->update('sub_preview',$subject_mark); */
	
	
		$this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Success !</strong> Application Updated Successfully .
		</div>');
		
		
			redirect('UgSelfFinance/updateStudent/'.$payed);
	
		
	

	}

	public function deleteSubject(){


		$id = $this->input->post('id');
		
		$this->db->where('ug_ms_id',$id);
		$this->db->delete('sub_preview_ug_main_sub');
		
		echo $this->session->set_flashdata('message_del', ' <div class="alert alert-danger alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Deleted !</strong>  Deleted  Successfully .
		</div>');
		
		}

	public function studentPdf()
    {



        $user_id = $this->uri->segment(3);



		$Sub = $this->db->select("*")->from("sub_preview")->where("sb_u_id",$user_id)->get();


$lang_mark = $Sub->result();

	$lang_table= '<table class="table" width="100%">
	<thead>
	  <tr style="background-color: lightgray;">
		<th>Part One & Two Name</th>
		
		<th>Max Mark</th>
		<th>Mark Obtained</th>
	
	  </tr>
	</thead>
	<tbody id="append">
	<tr align="center">
	<td>'.$lang_mark[0]->lang_1.'</td>
	<td>'.$lang_mark[0]->lang_1_max_mark.'</td>
	<td>'.$lang_mark[0]->lang_1_obt_mark.'</td>
	
	</tr><tr align="center">
	<td>'.$lang_mark[0]->lang_2.'</td>
	<td>'.$lang_mark[0]->lang_2_max_mark.'</td>
	<td>'.$lang_mark[0]->lang_2_obt_mark.'</td>
	
	</tr>
	
	</tbody>
	</table>';



		$ind = $this->db->select("*")->from("sub_preview_ug_main_sub")->where("student_id",$user_id)->get();

$res_num = $ind->num_rows();


if($res_num > 0){

$mark = $ind->result();

$mm='<table class="table" width="100%">
<thead>
  <tr style="background-color: lightgray;">
	<th>Subject</th>
	
	<th>Marks Obtained</th>
	<th>Percentage</th>

  </tr>
</thead>
<tbody id="append">';

foreach ($mark as $key => $value) {
	$mm.='<tr align="center">
	<td>'.$value->ug_subject_name.'</td>

	<td>'.$value->ug_mark_obtained.'</td>
	<td>'.$value->ud_percentage.'</td>

  </tr>';
}

$mm .='  </tbody>
</table>';


}else{

	$mm="";



}









        $pr_user = $this->db
            ->select("*")
            ->from("new_preview")
            ->where("pr_user_id", $user_id)
            ->get();

        $usd = $pr_user->result();
        $pr_study = $this->db
            ->select("*")
            ->from("sub_preview")
            ->where("sb_u_id", $user_id)
            ->get();

        $uss = $pr_study->result();

        $q = $this->db
            ->select("*")
            ->from("Applyed_Cources")
            ->where("main_course_id", 5)
            ->where("user_id", $user_id)
            ->where(
                "applied_course_id",
                $this->session->userdata("user")["user_dep_status"]
            )
            ->get();

        $app_id = $q->result();

        if (
            $usd[0]->pr_differently_abled == "" ||
            $usd[0]->pr_differently_abled == null
        ) {
            $abled = "<tr>
	<th>No</th>
	<td>-</td>
	</tr>";
        } elseif ($usd[0]->pr_differently_abled == "NO") {
            $abled = "<tr>
<th>No</th>
<td>-</td>
</tr>";
        } elseif ($usd[0]->pr_differently_abled == "YES") {
            $abled =
                "<tr>
  <th>" .
                $usd[0]->pr_differently_abled .
                "</th>
  <td>" .
                $usd[0]->pr_differently_abled_reson .
                "</td>
  </tr>";
        } else {
            $abled = "<tr>
<th>No</th>
<td>-</td>
</tr>";
        }

        if ($usd[0]->pr_other_res == "" || $usd[0]->pr_other_res == null) {
            $reservation = "<tr>
	<th>No</th>
	<td>-</td>
	</tr>";
        } elseif ($usd[0]->pr_other_res == "NO") {
            $reservation = "<tr>
<th>No</th>
<td>-</td>
</tr>";
        } elseif ($usd[0]->pr_other_res == "YES") {
            $reservation =
                "<tr>
  <th>" .
                $usd[0]->pr_other_res .
                "</th>
  <td>" .
                $usd[0]->pr_other_special_reservation .
                "</td>
  </tr>";
        } else {
            $reservation = "<tr>
	<th>No</th>
	<td>-</td>
	</tr>";
        }

        $dompdf = new DOMPDF();
        $html =
            '
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>MSSW</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: x-small;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }
    .gray {
        background-color: lightgray
    }
	.center {
		display: block;
		margin: 10px auto 20px;
		
	  }

	  #center {  
		text-align: center;  
		border: 2px solid blue;  
		}  
	    
</style>

</head>
<body>
<div id ="center">  
<img src="http://admission.mssw.in//landing/images/mssw_logo.jpg" width="60%" height="75px;" alt="image">
</div>

<h3 align="center">UG Application Form For The Academic Year 2022 - 2021</h3>

<table width="100%">
    <tr>
        <td valign="top"><img src="' .
            base_url() .
            "/uploads/" .
            $usd[0]->pr_photo .
            '" alt="" width="100"/></td>
        <td align="right">
            <h3>Name : ' .
            $usd[0]->pr_applicant_name .
            '</h3>
            <h3>Reference Number : 22' .
            sprintf("%'04d", $usd[0]->pr_user_id) .
            '</h3>
            <h3>Application Number : ' .
            $app_id[0]->application_number .
            '</h3>
         
        </td>
    </tr>

  </table>

   <table width="100%">
    <thead style="background-color: lightgray;">
      <tr>
     
        <th>Mother Tongue</th>
        <th>Place of Birth </th>
        <th>Date of Birth</th>
        <th>Age</th>
        <th>Gender</th>
      
      </tr>
    </thead>
    <tbody>
      <tr align="center">
	  <td>' .
            $usd[0]->pr_mother_toung .
            '</td>
	  <td>' .
            $usd[0]->pr_place_of_birth .
            '</td>
	  <td>' .
            date("d-M-Y", strtotime($usd[0]->pr_dob)) .
            '</td>
	  <td>' .
            $usd[0]->pr_age .
            '</td>
	  <td>' .
            $usd[0]->pr_gender .
            '</td>
</tr>
</tbody>

</table>

<table width="100%">
    <thead style="background-color: lightgray;">
      <tr >
     
        <th>Nationality</th>
        <th>Religion</th>
        <th>Caste</th>
        <th>Community</th>
     
      
      </tr>
    </thead>
    <tbody>
      <tr align="center">
	  <td>' .
            $usd[0]->pr_nationality .
            '</td>
	  <td>' .
            $usd[0]->pr_religion .
            '</td>
	  <td>' .
            $usd[0]->pr_caste .
            '</td>
	  <td>' .
            $usd[0]->pr_community .
            '</td>
	
</tr>
</tbody>
</table>

<table width="100%">
    <thead style="background-color: lightgray;">
      <tr>
     
        <th>SSLC School Name</th>
        <th>SSLC Medium of Instruction </th>
		<th>SSLC Year of Passing</th>
   
        <th>SSLC Language under Part II</th>
       
      
      </tr>
    </thead>
    <tbody>
      <tr align="center">
	  <td>' .
            $usd[0]->pr_sslc_school .
            '</td>
	  <td>' .
            $usd[0]->pr_sslc_medium_of_inst .
            '</td>
	  <td>' .
	  $usd[0]->pr_sslc_year_of_passing  .
     
			'<td>' .
            $usd[0]->pr_sslc_lang_under_2 .
            '</td>
</tr>
</tbody>

</table>

<table width="100%">
    <thead style="background-color: lightgray;">
      <tr>
     
        <th>+2 School Name</th>
        <th>+2 Medium of Instruction </th>
		<th>+2 Year of Passing</th>
        <th>+2 BOARD</th>
		<th>+2 If Others Board </th>
        <th>+2 Language under Part II</th>
       
      
      </tr>
    </thead>
    <tbody>
      <tr align="center">
	  <td>' .
            $usd[0]->pr_plus2_school .
            '</td>
	  <td>' .
            $usd[0]->pr_plus2_medium_of_inst .
            '</td>
	  <td>' .
	  $usd[0]->pr_plus2_year_of_passing  .
            '</td>
	  <td>' .
            $usd[0]->pr_board_study .
            '</td>
	  <td>' .
            $usd[0]->pr_bord_other .
            '</td>  
			
			<td>' .
            $usd[0]->pr_plus2_lang_under_2 .
            '</td>
</tr>
</tbody>

</table>'.$lang_table.''.$mm.'



















<table class="table" width="100%">
<tr>
<th style="background-color: lightgray;">#</th>
<th style="background-color: lightgray;">Local Address</th>
<th style="background-color: lightgray;">Permanant Address</th>
<tr>
<th align="left">Address</th>
<td>' .
            $usd[0]->pr_local_address .
            '</td>
<td>' .
            $usd[0]->pr_permanent_address .
            '</td>
</tr>

<tr>
<th align="left">City</th>
<td>' .
            $usd[0]->pr_local_city .
            '</td>
<td>' .
            $usd[0]->pr_permanent_city .
            '</td>
</tr>
<tr>
<th align="left">State</th>
<td>' .
            $usd[0]->pr_local_state .
            '</td>
<td>' .
            $usd[0]->pr_permanent_state .
            '</td>
</tr>    
<tr>
<th align="left">Country</th>
<td>' .
            $usd[0]->pr_local_country .
            '</td>
<td>' .
            $usd[0]->pr_permanent_country .
            '</td>
</tr>   
<tr>
<th align="left">Pincode</th>
<td>' .
            $usd[0]->pr_local_pincode .
            '</td>
<td>' .
            $usd[0]->pr_permanent_pincode .
            '</td>
</tr>   
</table>

  

  <table  width="100%">
   <thead style="background-color: lightgray;">
      <tr style="background-color: lightgray;">
     
        <th>Differently Abled Person</th>
        <th>Differently Abled Details</th>
            
      </tr>
    </thead>
    <tbody>
      <tr align="center">
	  <td>' .
            $usd[0]->pr_differently_abled .
            '</td>
	  <td>' .
            $usd[0]->pr_differently_abled_reson .
            '</td>
	 
	</tr>
	</tbody>
  </table>
   <table  width="100%">
  
  <thead style="background-color: lightgray;">
      <tr style="background-color: lightgray;">
     
        <th>Reservation Required</th>
        <th>Reservation Required Details</th>
            
      </tr>
    </thead>
    <tbody>
      <tr align="center">
	  <td>' .
            $usd[0]->pr_other_res .
            '</td>
	  <td>' .
            $usd[0]->pr_other_special_reservation .
            '</td>
	 
	</tr>
	</tbody>
  </table>
  <table  width="100%">
  
  <thead style="background-color: lightgray;">
      <tr style="background-color: lightgray;">
     
        <th>Hostel Required</th>
        <th>IDENTIFICATION 1</th>
        <th>IDENTIFICATION 2</th>
    
            
      </tr>
    </thead>
    <tbody>
      <tr align="center">
	  <td>' .
            $usd[0]->pr_hostel .
            '</td>
	  <td>' .
            $usd[0]->pr_identification_one .
            '</td>
	  <td>' .
            $usd[0]->pr_identification_two .
            '</td>

	
	 
	</tr>
	</tbody>
  </table>

    <table class="table"  width="100%">
						
  <tr  style="background-color: lightgray;">
	  <th>Sports Category : Name of the Game(s)</th>
	  <th>Position</th>
	  <th>Extra - Curricular Activities</th>
	  </tr>
	  
  <tr>
  <td align="center">' .
            $usd[0]->pr_name_of_game .
            '</td>
	  <td  align="center">' .
            $usd[0]->pr_game_position .
            '</td>
	  <td  align="center">' .
            $usd[0]->pr_extra_caricular_act .
            '</td>	
  
  </tr>
  
  </table>
    <table class="table"  width="100%">
  <tr style="background-color: lightgray;">
<th>#</th>
<th>Father</th>
<th>Mother</th>
<th>Guardian</th>
<tr>
<th align="left">Name</th>
<td>' .
            $usd[0]->pr_father_name .
            '</td>
<td>' .
            $usd[0]->pr_mother_name .
            '</td>
<td>' .
            $usd[0]->pr_gaurdion_name .
            '</td>
</tr>
<tr>
<th align="left">E-Mail Id</th>
<td>' .
            $usd[0]->pr_father_email .
            '</td>
<td>' .
            $usd[0]->pr_mother_email .
            '</td>
<td>' .
            $usd[0]->pr_gaurdion_email .
            '</td>
</tr>
<tr>
<th align="left">Mobile No.</th>
<td>' .
            $usd[0]->pr_father_mobnum .
            '</td>
<td>' .
            $usd[0]->pr_mother_mobnum .
            '</td>
<td>' .
            $usd[0]->pr_gaurdion_mobnum .
            '</td>
</tr>
<tr>
<th align="left">Occupation</th>
<td>' .
            $usd[0]->pr_father_accu .
            '</td>
<td>' .
            $usd[0]->pr_mother_accu .
            '</td>
<td>' .
            $usd[0]->pr_gaurdion_accu .
            '</td>
</tr>
<tr>
<th align="left">Annual
Income</th>
<td>' .
            $usd[0]->pr_father_anuval_income .
            '</td>
<td>' .
            $usd[0]->pr_mother_anuval_income .
            '</td>
<td>' .
            $usd[0]->pr_gaurdion_anuval_income .
            '</td>
</tr>   
  </table>
</body>
</html>';

        $dompdf->load_html($html);
        $dompdf->render();

        $dompdf->stream("22" . sprintf("%'04d", $usd[0]->pr_user_id) . "pdf");
    }
public function updateMarkUser(){


 $user_id = $this->uri->segment(3);



 $in_pr = $this->db->select('*')->from('new_preview')->where('pr_user_id',$user_id)->get();
 $r = $in_pr->num_rows();




 if($r == 0){
     $pre = array(
         'pr_user_id'=>$user_id,
     );
     
     $sub_pre = array(
         'sb_u_id'=>$user_id,
     );
     
     $this->db->insert('new_preview',$pre);
     $this->db->insert('sub_preview',$sub_pre);

 }














 $Community  = $this->input->post('Community');
$part_lang_1  = $this->input->post('part_lang_1');
$part_lang_2  = $this->input->post('part_lang_2');
$max_mark_lang_1  = $this->input->post('max_mark_lang_1');
$mark_lang_1  = $this->input->post('mark_lang_1');
$max_mark_lang_2  = $this->input->post('max_mark_lang_2');
$mark_lang_2  = $this->input->post('mark_lang_2');
$max_mark_pg  = $this->input->post('max_mark');
$total_subject  = $this->input->post('total_subject');
$total_mark_obt  = $this->input->post('total_mark');
$tot_percent  = $this->input->post('over_all_percentage');



$sub_name = $this->input->post("subject_name");
$obt_mark = $this->input->post("obt_mark");
$percentage = $this->input->post("percentage");
 /* echo"<pre>";
print_r($_POST); */

if($_POST['submit']=="Update"){





$subject_mark = array(


	
	'lang_1'=>$part_lang_1,
	'lang_2'=>$part_lang_2,
	'lang_1_max_mark'=>$max_mark_lang_1,
	'lang_2_max_mark'=>$max_mark_lang_2,
	'lang_1_obt_mark'=>$mark_lang_1,
	'lang_2_obt_mark'=>$mark_lang_2,
	'ug_max_mark'=>$max_mark_pg,
	'total_subject'=>$total_subject,
	'total_mark_obt'=>$total_mark_obt,
	'tot_percent'=>$tot_percent,


);



/* echo sizeof($sub_name);
print_r($sub_name); */


$stu_id = $this->db->select("*")->from("sub_preview_ug_main_sub")->where("student_id",$user_id)->get();
 $count_sub = $stu_id->num_rows();
if($count_sub == 0){
if(sizeof($sub_name) > 0){



for ($i=0; $i < sizeof($sub_name); $i++) { 
	if($sub_name[$i] !=""){	
	$main_mark = array(
		'student_id'=>$user_id,
		'ug_subject_name'=>$sub_name[$i],
		'ug_max_mark'=>$max_mark_pg,
		'ug_mark_obtained'=>$obt_mark[$i],
		'ud_percentage'=>$percentage[$i],
	);
//	print_r($main_mark);
	$this->db->insert('sub_preview_ug_main_sub',$main_mark);
	}	
}

}
}

$commu = array(
	'pr_community'=>$Community,
);
//print_r($commu);
	$this->db->where('sb_u_id',$user_id);
	$this->db->update('sub_preview',$subject_mark);

	$this->db->where('pr_user_id',$user_id);
	$this->db->update('new_preview',$commu);





	
	$this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Success !</strong> Marks Updated Successfully .
		</div>');
		
		
			redirect('UgSelfFinance/viewApplicationMark/'.$user_id); 


}else if($_POST['submit']=="Verify"){

	$pr_user = $this->db->select('*')->from('new_preview')->where('pr_user_id',$user_id)->get();
$res = $pr_user->result();

if($res[0]->pr_other_special_reservation==null || $res[0]->pr_other_special_reservation==""){


$reser = "NO";


}else{
	$reser = $res[0]->pr_other_special_reservation;

}






$insert = array(
	'stu_id'=>$user_id,
	'main_id'=>5,
	'applied_id'=>$this->session->userdata('user')['user_dep_status'],
	'mark_obtained'=>$total_mark_obt,
	'percentage_obtained'=>$tot_percent,
	'community'=>$Community,
	'special_reservation'=>$reser,
	
);



$this->db->insert('verified_ug',$insert);











$config = [
	"protocol" => "smtp",
	"smtp_host" => "ssl://smtp.gmail.com",
	"smtp_port" => 465,
	"smtp_user" => "admission.mssw@gmail.com",
	"smtp_pass" => "loveindia@123",
	"mailtype" => "html",
	"charset" => "iso-8859-1",
];
$this->email->initialize($config);
$this->email->set_mailtype("html");
$this->email->set_newline("\r\n");

$subject = "Percentage and Community Verified Status";
$msg =
	"Dear " .
	$res[0]->pr_applicant_name .
	",<br><br>



Your percentage and community is verified by the department based on the details provided by you. Kindly check your login and application for the update. In case of any changes, contact the respective program head within one day after receiving this E-mail. Late requests will not be entertained.";
$this->testEmail($res[0]->candidate_email, $subject, $msg);
















$this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong> Verified Successfully .
</div>');


	redirect('UgSelfFinance/viewApplicationMark/'.$user_id); 



}else if($_POST['submit']=="Verify Update"){

	$pr_user = $this->db->select('*')->from('new_preview')->where('pr_user_id',$user_id)->get();
$res = $pr_user->result();

if($res[0]->pr_other_special_reservation==null || $res[0]->pr_other_special_reservation==""){


$reser = "NO";


}else{
	$reser = $res[0]->pr_other_special_reservation;

}
	$Update_ver = array(
		

		'mark_obtained'=>$total_mark_obt,
		'percentage_obtained'=>$tot_percent,
		'community'=>$Community,
		'special_reservation'=>$reser,
		
	);

	$this->db->where('stu_id',$user_id);
	$this->db->update('verified_ug',$Update_ver);

	$this->session->set_flashdata('message', ' <div class="alert alert-warning alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Success !</strong> Verified Updated Successfully .
	</div>');
	
	
		redirect('UgSelfFinance/viewApplicationMark/'.$user_id); 

}




}


public function testone(){


	$config = [
		"protocol" => "smtp",
		"smtp_host" => "ssl://smtp.gmail.com",
		"smtp_port" => 465,
		"smtp_user" => "admission.mssw@gmail.com",
		"smtp_pass" => "loveindia@123",
		"mailtype" => "html",
		"charset" => "iso-8859-1",
	];
	$this->email->initialize($config);
	$this->email->set_mailtype("html");
	$this->email->set_newline("\r\n");
	
	$subject = "Percentage and Community Verified Status";
	$msg =
		"Dear Yuvan".
		",<br><br>
	
	
	
	Your percentage and community is verified by the department based on the details provided by you. Kindly check your login and application for the update. In case of any changes, contact the respective program head within one day after receiving this E-mail. Late requests will not be entertained.";
	$this->testEmail("be.yuvaraj@gmail.com", $subject, $msg);
	




}


	public function testEmail($emailto, $subject, $msg)
    {
        $html =
            '<html>
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
	<img class="em_img" alt="Welcome to Email" src="http://isteducationerp.com/admission//landing/images/mssw_logo.jpg" width="700" border="0" height="110px">
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
	' .
            $msg .
            '
		
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
        $this->email->send();
    }



    public function SelectionlistPdf()
    {
        $temp ="";       

      $selection_type =  $this->uri->segment(3);
      $selection_list =  $this->uri->segment(4);



$ord_er = $this->db->select("*")->from('resrvation_order')->order_by('r_id','ASC')->get();

$ord_err = $ord_er->result();


foreach($ord_err as $va){


        $sl = $this->db
        ->select("*")
        ->from("shotlisted_candidate")
        ->join(
            "new_preview",
            "shotlisted_candidate.sl_student_id=new_preview.pr_user_id"
        )
        ->join(
            "Applyed_Cources",
            "Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id"
        )
        ->join(
            "verified_ug",
            "verified_ug.stu_id=shotlisted_candidate.sl_student_id  AND verified_ug.applied_id=shotlisted_candidate.sl_course_id"
        )

        ->where("sl_main_id", 5)
        ->where("reservation_status", $selection_type)
        ->where("selection_list",  $selection_list)
        ->where("selection_list_name",  $va->r_name)
        ->where(
            "sl_course_id",
            $this->session->userdata("user")["user_dep_status"]
        )
			->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
        ->order_by("verified_ug.percentage_obtained", "DESC")
       // ->order_by("student_complete_mark.total_mark", "DESC")
        ->get();

$n=$sl->num_rows();




if($n > 0){

    $Candidate = $sl->result_array();

    $temp .= '<h4 align="center"> ' .$va->r_name .' LIST</h4>
    
    <table width="100%">
    <thead style="background-color: lightgray;">
      <tr>
        <th  width="5%">S.No</th>
        <th width="20%">Application Number</th>
        <th width="25%">Student Name</th>
        <th width="15%">Date of Birth</th>
  
        <th width="10%">+2 Percentage</th>
        <th width="12%">Community</th>
        <th width="13%">Board</th>
       
           
      </tr>
    </thead>
    <tbody>';

    $i = 1;
    foreach ($Candidate as $tnt) {
        $temp .=
            '   <tr align="center">
<td>' .
            $i .
            '</td>
<td>' .
            $tnt["application_number"] .
            '</td>
<td>' .
            strtoupper($tnt["pr_applicant_name"]) .
            '</td>

<td>' .
            date("d-m-Y", strtotime($tnt["pr_dob"])) .
            '</td>

<td>' .
sprintf ("%.2f",$tnt["percentage_obtained"]) .
            '</td>
<td>' .
            $tnt["community"] .
            '</td>
			<td>' .
            $tnt["pr_board_study"] .
            '</td>
          

</tr>';

        $i++;
    }
    $temp .='</tbody>
    </table>
    
   ';
}
   









        }
    //print_r(	$Candidate);print_r(	$_POST);

    

    if ($selection_type == 1) {
        $status = "SELECTION LIST";
    } elseif ($selection_type == 2) {
        $status = "WAITING LIST";
    } else {
        $status = "REJECTION LIST";
    } 
    
    
    
    
    
    if ($selection_list == 1) {
        $list = "FIRST ";
    } elseif ($selection_list == 2) {
        $list = "SECOND ";
    } elseif ($selection_list == 3) {
        $list = "THIRD ";
    }elseif ($selection_list == 4) {
        $list = "FOURTH ";
    }elseif ($selection_list == 5) {
        $list = "FIFTH ";
    }elseif ($selection_list == 6) {
        $list = "SIXTH ";
    }elseif ($selection_list == 7) {
        $list = "SEVENTH ";
    }elseif ($selection_list == 8) {
        $list = "EIGHTH ";
    }elseif ($selection_list == 9) {
        $list = "NINGTH ";
    }elseif ($selection_list == 10) {
        $list = "TENTH ";
    }
  

    $filename =
  
       
	$list." - ".$status ." FOR ".
        strtoupper($Candidate[0]["course_name"]);

    $dompdf = new DOMPDF();
    $html =
        '
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>MSSW</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: x-small;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }
    .gray {
        background-color: lightgray
    }
    .center {
        display: block;
        margin: 10px auto 20px;
        
      }
      #center {  
        text-align: center;  
        border: 2px solid blue;  
        }  


     tr:nth-child(even){background-color: #f2f2f2;}

 tr:hover {background-color: #ddd;}
      
</style>

</head>
<body>
<div id ="center">  
<img  src="http://admission.mssw.in//landing/images/mssw_logo.jpg" width="60%" height="75px;">
</div>  

<br>
<h3 align="center"> ' .$filename .'</h3>
 '.$temp.'
  <br>
  <br>
  
  <div>
  <div align="left"> HoD/Program Head</div>
 
  
  <div align="right"> Principal</div>
  </div>
  <br>
  <br>
  <br>
  <footer>
  <h6 align="center">Generated by MSSW Campus Management System.</h6>
  </footer>
'; 

    $dompdf->load_html($html);
    $dompdf->render();

    $dompdf->stream($filename . "pdf");
    }


    public function completeSelectionlistPdf()
    {
        $temp ="";       

      $selection_type =  $this->uri->segment(3);
   



$ord_er = $this->db->select("*")->from('resrvation_order')->order_by('r_id','ASC')->get();

$ord_err = $ord_er->result();


foreach($ord_err as $va){


        $sl = $this->db
        ->select("*")
        ->from("shotlisted_candidate")
        ->join(
            "new_preview",
            "shotlisted_candidate.sl_student_id=new_preview.pr_user_id"
        )
        ->join(
            "Applyed_Cources",
            "Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id"
        )
        ->join(
            "verified_ug",
            "verified_ug.stu_id=shotlisted_candidate.sl_student_id  AND verified_ug.applied_id=shotlisted_candidate.sl_course_id"
        )

        ->where("sl_main_id", 5)
        ->where("reservation_status", $selection_type)
      
        ->where("selection_list_name",  $va->r_name)
        ->where(
            "sl_course_id",
            $this->session->userdata("user")["user_dep_status"]
        )
			->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
        ->order_by("verified_ug.percentage_obtained", "DESC")
       // ->order_by("student_complete_mark.total_mark", "DESC")
        ->get();

$n=$sl->num_rows();




if($n > 0){

    $Candidate = $sl->result_array();

    $temp .= '<h4 align="center"> ' .$va->r_name .' LIST</h4>
    
    <table width="100%">
    <thead style="background-color: lightgray;">
      <tr>
        <th  width="5%">S.No</th>
        <th width="20%">Application Number</th>
        <th width="25%">Student Name</th>
        <th width="15%">Date of Birth</th>
  
        <th width="15%">+2 Percentage</th>
        <th width="20%">Community</th>
       
           
      </tr>
    </thead>
    <tbody>';

    $i = 1;
    foreach ($Candidate as $tnt) {
        $temp .=
            '   <tr align="center">
<td>' .
            $i .
            '</td>
<td>' .
            $tnt["application_number"] .
            '</td>
<td>' .
            strtoupper($tnt["pr_applicant_name"]) .
            '</td>

<td>' .
            date("d-m-Y", strtotime($tnt["pr_dob"])) .
            '</td>

<td>' .
sprintf ("%.2f",$tnt["percentage_obtained"]) .
            '</td>
<td>' .
            $tnt["community"] .
            '</td>
          

</tr>';

        $i++;
    }
    $temp .='</tbody>
    </table>
    
   ';
}
   









        }
    //print_r(	$Candidate);print_r(	$_POST);

    

    if ($selection_type == 1) {
        $status = "SELECTION LIST";
    } elseif ($selection_type == 2) {
        $status = "WAITING LIST";
    } else {
        $status = "REJECTION LIST";
    } 
    
    
    
    
/*     
 if ($selection_list == 1) {
        $list = "FIRST ";
    } elseif ($selection_list == 2) {
        $list = "SECOND ";
    } elseif ($selection_list == 3) {
        $list = "THIRD ";
    }elseif ($selection_list == 4) {
        $list = "FOURTH ";
    }elseif ($selection_list == 5) {
        $list = "FIFTH ";
    }elseif ($selection_list == 6) {
        $list = "SIXTH ";
    }elseif ($selection_list == 7) {
        $list = "SEVENTH ";
    }elseif ($selection_list == 8) {
        $list = "EIGHTH ";
    }elseif ($selection_list == 9) {
        $list = "NINGTH ";
    }elseif ($selection_list == 10) {
        $list = "TENTH ";
    } 
  */

    $filename =
    strtoupper($list) .
        " - " .
       
        $status ." FOR ".
        strtoupper($Candidate[0]["course_name"]);

    $dompdf = new DOMPDF();
    $html =
        '
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>MSSW</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: x-small;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }
    .gray {
        background-color: lightgray
    }
    .center {
        display: block;
        margin: 10px auto 20px;
        
      }
      #center {  
        text-align: center;  
        border: 2px solid blue;  
        }  


     tr:nth-child(even){background-color: #f2f2f2;}

 tr:hover {background-color: #ddd;}
      
</style>

</head>
<body>
<div id ="center">  
<img  src="http://admission.mssw.in//landing/images/mssw_logo.jpg" width="60%" height="75px;">
</div>  

<br>
<h3 align="center"> ' .$filename .'</h3>
 '.$temp.'
  <br>
  <br>
  
  <div>
  <div align="left"> HoD/Program Head</div>
 
  
  <div align="right"> Principal</div>
  </div>
  <br>
  <br>
  <br>
  <footer>
  <h6 align="center">Generated by MSSW Campus Management System.</h6>
  </footer>
'; 

    $dompdf->load_html($html);
    $dompdf->render();

    $dompdf->stream($filename . "pdf");
    }
	


public function admitStudent(){



    if($this->session->userdata("user")["user_dep_status"] == 1){


        $dep ="BSW";
    }else if($this->session->userdata("user")["user_dep_status"] == 2){

        $dep ="PSY";
    }




$m = $this->db->select("*")->from("admitted_student")->where("as_student_id",$_POST['student_id'])->where("as_shotlist_ref_number",$_POST['student_short_id'])->where("year",$this->session->userdata("user")["user_aca_year"])->get();



$y = $m->num_rows();


if($y == 0){


$data = array(
    'as_name'=>$_POST['name'],
    'as_app_number'=>$_POST['app_number'],
    'as_blood_gp'=>$_POST['blood_grp'],
    'as_quata'=>$_POST['reservation'],
    'as_dep'=>$dep,
    'as_profile'=>$_POST['student_photo'],
    'as_student_id'=>$_POST['student_id'],
    'as_shotlist_ref_number'=>$_POST['student_short_id'],
	'year'=>date('Y'),
);


$this->db->insert('admitted_student',$data);

$this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong> Admitted Successfully .
</div>');


    redirect('UgSelfFinance/principalApproved/'); 

}else{


    $data = array(
        'as_name'=>$_POST['name'],
        'as_app_number'=>$_POST['app_number'],
        'as_blood_gp'=>$_POST['blood_grp'],
        'as_quata'=>$_POST['reservation'],
        'as_dep'=>$dep,
        'as_profile'=>$_POST['student_photo'],
   
    );

$this->db->where('as_student_id',$_POST['student_id']);
$this->db->where('as_shotlist_ref_number',$_POST['student_short_id']);
$this->db->update('admitted_student',$data);


$this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong>Updated Successfully .
</div>');


    redirect('UgSelfFinance/principalApproved/'); 

}

//redirect('UgSelfFinance/principalApproved/'); 


}

public function admittedStudent(){


    if($this->session->userdata("user")["user_dep_status"] == 1){


        $dep ="BSW";
    }else if($this->session->userdata("user")["user_dep_status"] == 2){

        $dep ="PSY";
    }



$this->db->select('*');
$this->db->from('admitted_student');
$this->db->join(
	"new_preview",
	"admitted_student.as_student_id=new_preview.pr_user_id"
);
$this->db->where('as_dep', $dep);
$this->db->where('year', $this->session->userdata("user")["user_aca_year"]);
$this->db->order_by('as_name', 'asc');
$query = $this->db->get();
$res = $query->result();

$data['student'] = $res;

$data['title'] = "Reports of Verified Student ".$this->session->userdata('user')['user_name']." ".date('d-M-Y');

$this->load->view("template/ugselffinance/header");
$this->load->view("template/ugselffinance/menubar");
$this->load->view("template/ugselffinance/headerbar");
$this->load->view("ugselffinance/admittedStudent", $data);
$this->load->view("template/ugselffinance/footer",$data);



}

public function admittedErp(){


    if($this->session->userdata("user")["user_dep_status"] == 1){


        $dep =$this->session->userdata("user")["user_aca_year"]." Batch/BSW-";
    }else if($this->session->userdata("user")["user_dep_status"] == 2){

	   $dep =$this->session->userdata("user")["user_aca_year"]." Batch/BSCPY-";
    }



$this->db->select('*');
$this->db->from('erp_existing_students');
$this->db->join(
	"new_preview",
	"erp_existing_students.student_id=new_preview.pr_user_id"
);
$this->db->like('erp_existing_students.batch_', $dep);

$this->db->order_by('reg_no_', 'asc');
$query = $this->db->get();
$res = $query->result();

$data['student'] = $res;

//print_r($data);

 $this->load->view("template/ugselffinance/header");
$this->load->view("template/ugselffinance/menubar");
$this->load->view("template/ugselffinance/headerbar");
$this->load->view("ugselffinance/admittederp", $data);
$this->load->view("template/ugselffinance/footer"); 



}
public function registerNumberFormat(){


$nt =  $this->db->select("*")->from("student_reg_number_format")->where("batch",$_POST['batch'])->where("dep",$_POST['department'])->get();
                        
$res = $nt->num_rows();


if($res > 0 ){
$update  = array(
  
    'college_code'=>$_POST['college_code'],
    'pg_ug'=>$_POST['ug_pg'],
    'program_code'=>$_POST['prog_code'],
    'reg_no_start'=>$_POST['start_reg_num'],
    'reg_no_end'=>$_POST['end_reg_num'],
);

$this->db->where("batch",$_POST['batch']);
$this->db->where("dep",$_POST['department']);
$this->db->update('student_reg_number_format',$update);

}else{

    $insert  = array(
  
        'batch'=>$_POST['batch'],
        'dep'=>$_POST['department'],
        'college_code'=>$_POST['college_code'],
        'pg_ug'=>$_POST['ug_pg'],
        'program_code'=>$_POST['prog_code'],
        'reg_no_start'=>$_POST['start_reg_num'],
        'reg_no_end'=>$_POST['end_reg_num'],
    );
 
    $this->db->insert('student_reg_number_format',$insert);


}
$this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong>Updated Successfully .
</div>');
    redirect('UgSelfFinance/admittedStudent/'); 

}
public function assignRegisterNumber(){

$dept = $this->uri->segment(3);
$batch = $this->uri->segment(4);


$nt =  $this->db->select("*")->from("student_reg_number_format")->where("batch",date("y"))->where("dep",$dept)->get();
                        
$res = $nt->num_rows();

if($res > 0){

    $rest = $nt->result();

    $reg_format =  $rest[0]->batch.$rest[0]->college_code.$rest[0]->pg_ug.$rest[0]->program_code;

    $this->db->select('*');
    $this->db->where('as_status',0);
    $this->db->where('as_dep',$dept);
    $this->db->where('as_reg_num',null);
    $this->db->or_where('as_reg_num',"");
    $this->db->order_by('as_name', 'asc');
    $query = $this->db->get('admitted_student');
    $tot = $query->num_rows();

    if($tot > 0){
    $resulte = $query->result();




    $this->db->select('*');
    $this->db->where('as_status',1);
    $this->db->where('as_dep',$dept);
    $this->db->order_by('as_name', 'asc');
    $df = $this->db->get('admitted_student');
    $tn = $df->num_rows();

            if($tn > 0){

                $nt =  $this->db->select("as_reg_num")->from("admitted_student")->where("as_dep",$dept)->order_by("as_reg_num", "desc")->limit(1)->get();



                $res = $nt->result();
                
                
             $res[0]->as_reg_num;



               $resnum=  str_replace($reg_format, "",$res[0]->as_reg_num);


               $number = $resnum+1;
               foreach($resulte as $val){
               
                  
                    $number = sprintf('%03d',$number);
               
                  $reg_num = $reg_format.$number;
               
               
               
                  $data = array(
                      'as_reg_num'=>$reg_num,
                      'as_status'=>1,
                  );
               
                  $this->db->where('as_id',$val->as_id);
                  $this->db->update('admitted_student',$data); 
               
               
               
                   $number++;
                  
               }



            }else{

    $number = 1;
foreach($resulte as $val){

   
     $number = sprintf('%03d',$number);

  echo $reg_num = $reg_format.$number;



   $data = array(
       'as_reg_num'=>$reg_num,
       'as_status'=>1,
   );
   //print_r($data);
    $this->db->where('as_id',$val->as_id);
   $this->db->update('admitted_student',$data); 



    $number++;
   
}

}






    }else{

      $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success !</strong>Student Not Found.
        </div>');
        
        
            redirect('UgSelfFinance/admittedStudent/'); 
    }


 $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success !</strong>update in student record.
    </div>');
    
    
       redirect('UgSelfFinance/admittedStudent/'); 

}else{

    $this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success !</strong>Set Register number format .
    </div>');
    
    
        redirect('UgSelfFinance/admittedStudent/'); 



}


}
public function ManualSelectWaitingList()
    {
        $tmr = $_POST["id"];
        $sel = $_POST["sel"];

        $res = $this->db
            ->select("*")
            ->from("shotlisted_candidate")
            ->where("sl_id", $tmr)
				->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
            ->get();

        $out = $res->result();

        $main_course = $out[0]->sl_main_id;
        $applied_course = $out[0]->sl_course_id;
        $selection = $out[0]->selection_list_name;

  

if($selection == "MERIT" || $selection == "OC" || $selection == "MANAGEMENT" ){

    $user = $this->db
    ->select("*")
    ->from("shotlisted_candidate")
    ->join(
        "Applyed_Cources",
        "Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id"
    )
    ->join(
        "student_complete_mark",
        "shotlisted_candidate.sl_student_id=student_complete_mark.stu_id AND shotlisted_candidate.sl_main_id=student_complete_mark.main_course_id AND shotlisted_candidate.sl_course_id=student_complete_mark.app_course_id"
    )
    ->join(
        "new_preview_pg",
        "shotlisted_candidate.sl_student_id=new_preview_pg.pr_user_id"
    )
    ->where("sl_main_id", 1)
   
    ->where(
        "sl_course_id",
        $this->session->userdata("user")["user_dep_status"]
    )
    ->where("reservation_status", 2)
		->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
    ->order_by("student_complete_mark.total_mark", "DESC")
    ->limit(1)
    ->get();

}else{


    $user = $this->db
    ->select("*")
    ->from("shotlisted_candidate")
    ->join(
        "Applyed_Cources",
        "Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id"
    )
    ->join(
        "student_complete_mark",
        "shotlisted_candidate.sl_student_id=student_complete_mark.stu_id AND shotlisted_candidate.sl_main_id=student_complete_mark.main_course_id AND shotlisted_candidate.sl_course_id=student_complete_mark.app_course_id"
    )
    ->join(
        "new_preview_pg",
        "shotlisted_candidate.sl_student_id=new_preview_pg.pr_user_id"
    )
    ->where("sl_main_id", 1)
    ->where("selection_list_name", $selection)
    ->where(
        "sl_course_id",
        $this->session->userdata("user")["user_dep_status"]
    )
    ->where("reservation_status", 2)
		->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
    ->order_by("student_complete_mark.total_mark", "DESC")
    ->limit(1)
    ->get();


}


     

     
            //echo $resul = $user->num_rows();
            $m_n = $user->result();


            $reject = [
                "reservation_status" => 3,
                "selection_list" => $sel
            ];

            $this->db->where("sl_id", $tmr);
            $this->db->update("shotlisted_candidate", $reject);


            echo $this->session->set_flashdata(
                "message",
                ' <div class="alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong> successfully Updated !
</div>'
            );


    }
	public function studentannouncements()
			{
				$user = $this->session->userdata("user")["user_id"];
		
				date_default_timezone_get();
				$add_date = date('Y-m-d h:i:s');
				$data['announsment'] = $this->db
				->from('announcement')
				->join(
					"department_details",
					"announcement.ann_main = department_details.main_id AND announcement.ann_course = department_details.cour_id","left"
				)
				->where('ann_role_published', $user)->get()->result();
				if (isset($_POST['submit'])) {
					$data_ann['ann_main'] = 5;
					$data_ann['ann_course'] = $this->session->userdata('user')['user_dep_status'];
					$data_ann['ann_name'] = $this->input->post('title');
					$data_ann['ann_desc'] = $this->input->post('remark');
					$data_ann['ann_batch'] = $this->input->post('batch');
					$data_ann['ann_year'] = $this->input->post('year');
					$data_ann['ann_date_till'] = $this->input->post('date_till');
					$data_ann['ann_role_published'] = $user;
					//$data_ann['ann_date_till'] = $add_date;
		
				
		
					if ($_FILES['upload_doc']['size'] != 0) {
						/* if (isset($get_announcement) && $get_announcement->upload_doc != '') {
							$get_path = $array = explode('-', $get_announcement->upload_doc, 2);
							if ($get_path[1] == $_FILES['upload_doc']['name']) {
								unlink(APPPATH . '../' . $get_announcement->upload_doc);
							}
						} */
						$_FILES["file"]["name"] = rand() . '-' . $_FILES["upload_doc"]["name"];
						$_FILES["file"]["type"] = $_FILES["upload_doc"]["type"];
						$_FILES["file"]["tmp_name"] = $_FILES["upload_doc"]["tmp_name"];
						$_FILES["file"]["error"] = $_FILES["upload_doc"]["error"];
						$_FILES["file"]["size"] = $_FILES["upload_doc"]["size"];
						$this->upload->initialize();
						$this->upload->initialize($this->do_upload_ann());
						if ($this->upload->do_upload('file')) {
							$file = $this->upload->data();
							$image = $file['file_name'];
							$data_ann['ann_upload'] = 'uploads/admin_files/' . $image;
						} else {
							$error = array('error' => $this->upload->display_errors());
							print_r($error);
							exit;
						}
					}
		
				
						$insert = $this->db->insert('announcement', $data_ann);
					
					$this->session->set_flashdata(
						"message",
						' <div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Success !</strong> Successfully Inserted .
				</div>'
					);
					redirect('UgSelfFinance/studentannouncements', 'refresh');
				}
		
				$this->load->view('template/ugselffinance/header');
				$this->load->view('template/ugselffinance/menubar');
				$this->load->view('template/ugselffinance/headerbar');
				$this->load->view('ugselffinance/announcements',$data);
				$this->load->view('template/ugselffinance/footer');
			}
			public function delete_announcement(){
	
				$id= $this->input->post('delete_id');
		
		
				$this->db->where('ann_id',$id);
				$this->db->delete('announcement');
		
				echo $this->session->set_flashdata(
					"message",
					' <div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Delete !</strong> Deleted Successfully .
				</div>'
				);
		
		
			}
	
			public function do_upload_ann()
			{
				$config = array();
				$config['upload_path'] = './uploads/admin_files/';
				$config['allowed_types'] = '*';
				$config['remove_spaces'] = TRUE;
				$config['overwrite'] = TRUE;
				return $config;
			}

}
