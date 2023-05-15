<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . "/libraries/dompdf/autoload.inc.php";
use Dompdf\Dompdf;
use Dompdf\Options;
class PgDiploma extends CI_Controller {

    public $Subject;
	
	public function __construct()
	{
		parent::__construct();
	//  error_reporting(0);
	  date_default_timezone_set("Asia/Calcutta");
	  $this->load->library('upload');
	  $this->load->config('email');
		$this->load->library('email');
		$this->load->library("form_validation");
	  
		$this->load->library('pdf');
        $this->load->library('phpqrcode/qrlib');
		
		if ($this->session->user != "" || $this->session->user != null) {
            if ($this->session->userdata("user")["user_dep_status"] == 10) {
                $this->Subject = "PGDPMIR";
            }elseif($this->session->userdata("user")["user_dep_status"] == 11){
				$this->Subject = "PGDHRM";
			}  else {
                $this->Subject = "";
            }
        } else {
            redirect("Welcome/logOut", "refresh");
        }
        if ($this->Subject == "") {
            redirect("Welcome/logOut", "refresh");
        }

	}
	
	public function rules_stu_comm()
    {
        $config = [
            [
                "field" => "community",
                "label" => "Community",
                "rules" => "required",
                "errors" => [
                    "required" => "You must provide a %s.",
                ],
            ],
            [
                "field" => "link_id1",
                "label" => "Zoom Link",
                "rules" => "required",
                "errors" => [
                    "required" => "You must provide a %s.",
                ],
            ],
        ];
        return $config;
    }

    public function index(){


$this->load->view('template/diploma/header');
$this->load->view('template/diploma/menubar');
$this->load->view('template/diploma/headerbar');
$this->load->view('diploma/dashbord');
$this->load->view('template/diploma/footer');



    }
    public function NonAppliedStudent(){

$arr = [];


$sta =$this->db->select("user_id")->from("Applyed_Master")->where("main_course_priority","DIP")->get();

$applied_stu =$sta->result_array();

$arr = array_column($applied_stu, "user_id");

$st =$this->db->select("*")->from("stu_user")->where("u_course",3)->where_not_in("u_id",$arr)->get();
$data['NonUser'] = $st->result();




        $this->load->view('template/diploma/header');
        $this->load->view('template/diploma/menubar');
        $this->load->view('template/diploma/headerbar');
        $this->load->view('diploma/NonApplideStudent',$data);
        $this->load->view('template/diploma/footer'); 




    }



public function studentApplied()
{
    $sta = $this->db
        ->select("user_id")
        ->from("Applyed_Cources")
        ->where("main_course_id", 4)
        ->where(
            "applied_course_id",
            $this->session->userdata("user")["user_dep_status"]
        )
        ->get();

    $applied_stu = $sta->result_array();

    $arr = array_column($applied_stu, "user_id");
    if (sizeof($arr) == 0) {
        $arr = ["0"];
    }

    $this->db->select(
        "stu_user.*,Applyed_Cources.*,new_preview_dip.*,sub_preview_dip.*,Applyed_Master.*"
    );
    
    $this->db->from("Applyed_Cources");

    $this->db->join(
        "Applyed_Master",
        "Applyed_Master.id=Applyed_Cources.master_id",
        "left"
    ) ;
    $this->db->join(
        "stu_user",
        "Applyed_Cources.user_id=stu_user.u_id",
        "right"
    );
    $this->db->join(
        "new_preview_dip",
        "Applyed_Cources.user_id=new_preview_dip.pr_user_id",
        "right"
    );
    $this->db->join(
        "sub_preview_dip",
        "Applyed_Cources.user_id=sub_preview_dip.sb_u_id",
        "right"
    );
    //$this->db->join('online_exam_pannel', 'Applyed_Cources.user_id=online_exam_pannel.student_id','right');
    //   $this->db->join('student_complete_mark', 'stu_user.u_id=student_complete_mark.stu_id','left');
    $this->db->where(
        "Applyed_Cources.applied_course_id",
        $this->session->userdata("user")["user_dep_status"]
    );
    //	$this->db->where('online_exam_pannel.exam_category',$this->Subject);
    //$this->db->where('student_complete_mark.exam_name',$this->Subject);
    $this->db->where_in("Applyed_Cources.user_id", $arr);
    $st = $this->db->get();

    $data["student"] = $st->result();

    $this->load->view('template/diploma/header');
    $this->load->view('template/diploma/menubar');
    $this->load->view('template/diploma/headerbar');
    $this->load->view('diploma/appliedStudent',$data);
    $this->load->view('template/diploma/footer'); 

}

public function viewStudent()
{
    $user_id = $this->uri->segment(3);
    $m_course = "5";

    $pr_user = $this->db
        ->select("*")
        ->from("new_preview_dip")
        ->where("pr_user_id", $user_id)
        ->get();
    $pr_study = $this->db
        ->select("*")
        ->from("sub_preview_dip")
        ->where("sb_u_id", $user_id)
        ->get();

    $q = $this->db
        ->select("*")
        ->from("college_course")
        ->get();

    $data["cc"] = $q->result();

    $data["user"] = $pr_user->result();
    $data["Study"] = $pr_study->result();

    $this->load->view("template/diploma/header");
    $this->load->view("template/diploma/menubar");
    $this->load->view("template/diploma/headerbar");
    $this->load->view("studentdetails/preview_dip", $data);
    $this->load->view("template/diploma/footer");
}


public function updateStuContactInfo()
{
    $this->load->view("template/diploma/header");
    $this->load->view("template/diploma/menubar");
    $this->load->view("template/diploma/headerbar");
    $this->load->view("diploma/update_personal");
    $this->load->view("template/diploma/footer");
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
            "PgDiploma/updateStuContactInfo/" . $student_id,
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
            "PgDiploma/updateStuContactInfo/" . $student_id,
            "refresh"
        );
    }
}

public function studentPdf()
{
    $user_id = $this->uri->segment(3);

    $pr_user = $this->db
        ->select("*")
        ->from("new_preview_dip")
        ->where("pr_user_id", $user_id)
        ->get();

    $usd = $pr_user->result();
    $pr_study = $this->db
        ->select("*")
        ->from("sub_preview_dip")
        ->where("sb_u_id", $user_id)
        ->get();

    $uss = $pr_study->result();

    $q = $this->db
        ->select("*")
        ->from("Applyed_Cources")
        ->where("main_course_id", 4)
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
<img src="http://test.mssw.in//landing/images/mssw_logo.jpg" width="60%" height="75px;" alt="image">
</div>

<h3 align="center">Application Form For The Academic Year 2020 - 2021</h3>

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

<table width="100%">
<thead style="background-color: lightgray;">
  <tr>
    <th>#</th>
    <th>Educational Details</th>
    <th>Institution</th>
    <th>Max. Marks</th>
    <th>Marks Obtained</th>
    <th>Class / Grade</th>
    <th>Percentage</th>
  </tr>
</thead>
<tbody>
  <tr>
    <th scope="row">1</th>
 
    <td >' .
        $uss[0]->sslc_subject .
        '</td>
    <td >' .
        $uss[0]->sslc_institution .
        '</td>
    <td >' .
        $uss[0]->sslc_max_mark .
        '</td>
    <td >' .
        $uss[0]->sslc_mark_obtain .
        '</td>
    <td >' .
        $uss[0]->sslc_grade .
        '</td>
    <td >' .
        $uss[0]->sslc_percentage .
        '</td>
  </tr>
  <tr>
<th scope="row">2</th>

<td >' .
        $uss[0]->plus_one_subject .
        '</td>
<td >' .
        $uss[0]->plus_one_institution .
        '</td>
<td >' .
        $uss[0]->plus_one_max_mark .
        '</td>
<td >' .
        $uss[0]->plus_one_mark_obtain .
        '</td>
<td >' .
        $uss[0]->plus_one_grade .
        '</td>
<td >' .
        $uss[0]->plus_one_percentage .
        '</td>
  </tr>
<tr>
  <th scope="row">3</th>

<td >' .
        $uss[0]->plus_two_subjec .
        '</td>
<td >' .
        $uss[0]->plus_two_institution .
        '</td>
<td >' .
        $uss[0]->plus_two_max_mark .
        '</td>
<td >' .
        $uss[0]->plus_two_mark_obtain .
        '</td>
<td >' .
        $uss[0]->plus_two_grade .
        '</td>
<td >' .
        $uss[0]->plus_two_percentage .
        '</td>
  </tr>
<tr>
<th scope="row">4</th>

<td >' .
        $uss[0]->UG_subject .
        '</td>
<td >' .
        $uss[0]->ug_institution .
        '</td>
<td >' .
        $uss[0]->UG_max_mark .
        '</td>
<td >' .
        $uss[0]->UG_mark_obtain .
        '</td>
<td >' .
        $uss[0]->UG_grade .
        '</td>
<td >' .
        $uss[0]->UG_two_percentage .
        '</td>
  </tr>
</tbody>


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

public function updatePGPer()
{
    $community = [
        "pr_community" => $_POST["Community"],
    ];

    $this->db->where("pr_user_id", $_POST["student_id"]);
    $this->db->update("new_preview_dip", $community);

    $percentage = [
        "UG_two_percentage" => $_POST["ug_percentage"],
        "verified_status" => 1,
        "verified_by_user" => $this->session->userdata("user")["user_id"],
    ];

    $this->db->where("sb_u_id", $_POST["student_id"]);
    $this->db->update("sub_preview_dip", $percentage);

    $ud = $this->db
        ->select("u_email_id,u_mobile")
        ->from("stu_user")
        ->where("u_id", $_POST["student_id"])
        ->get();
    $res = $ud->result();

    $usn = $this->db
        ->select("pr_applicant_name")
        ->from("new_preview_dip")
        ->where("pr_user_id", $_POST["student_id"])
        ->get();
    $usr_name = $usn->result();

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
        $usr_name[0]->pr_applicant_name .
        ",<br><br>



Your percentage and community is verified by the department based on the details provided by you. Kindly check your login and application for the update. In case of any changes, contact the respective program head within one day after receiving this E-mail. Late requests will not be entertained.";
    $this->testEmail($res[0]->u_email_id, $subject, $msg);

    $this->session->set_flashdata(
        "message",
        ' <div class="alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong> Updated Successfully .
</div>'
    );

    redirect("PgDiploma/studentApplied", "refresh");
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
        ->from("new_preview_dip")
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

    $msg =
        "Dear " .
        $usr_name[0]->pr_applicant_name .
        ",<br><br>" .
        $email_content;

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

    redirect("PgDiploma/studentApplied", "refresh");
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



public function stuCmnty()
    {
        $user = $this->session->userdata("user");
        $user_id = $user["user_id"];
        $dpmnt = $data["dept"] = $user["user_dep_status"];
        $data["cmnty"] = "";
        $data["linkid"] = "";
        $data["quota"] = "";
        $data["sel_link"] = $this->db
            ->where("alc_by", $user_id)
            ->get("zoom")
            ->result();
        $rules = $this->rules_stu_comm();
        $this->form_validation->set_rules($rules);
        if (isset($_POST["submit"])) {
            if ($this->form_validation->run() == false) {
                $data["form_err"] = $this->session->set_flashdata(
                    "success1",
                    "Enter Details Correctly",
                    "danger"
                );
            } else {
                $linkid = $data["linkid"] = $this->input->post("link_id1");
                $community = $data["cmnty"] = $this->input->post("community");
                $quota = $data["quota"] = $this->input->post("quota");
                //$link_list=$this->db->select('student_id')->where('alc_by',$user_id)->get('zoom_alloc')->result();
                $link_det = $this->db
                    ->where("id", $linkid)
                    ->get("zoom")
                    ->row();
                $start_date = date("Y-m-d", strtotime($link_det->start_date));
                $start_time = date("H:i:s", strtotime($link_det->start_time));
                $duration = $link_det->duration;
                $duration *= 60;
                $endTime = date("H:i:s", strtotime($start_time) + $duration);
                $link_list = $this->db
                    ->query(
                        'select student_id from zoom_alloc where (alc_by="' .
                            $user_id .
                            '" and main_course_id="4" and app_course_id="' .
                            $dpmnt .
                            '") or (alc_by!="' .
                            $user_id .
                            '" and (alc_time >= "' .
                            $start_time .
                            '" AND alc_time < "' .
                            $endTime .
                            '") and alc_date="' .
                            $start_date .
                            '") '
                    )
                    ->result();
                $ll = ["0"];
                foreach ($link_list as $lili) {
                    array_push($ll, $lili->student_id);
                }
                $stu_dpmnt = $this->db
                    ->query(
                        'select user_id from Applyed_Cources where applied_course_id="' .
                            $dpmnt .
                            '" and main_course_id="4" '
                    )
                    ->result();
                $sd = ["0"];
                foreach ($stu_dpmnt as $studp) {
                    array_push($sd, $studp->user_id);
                }
                if (($quota == "" || $quota == "MGT") && $community == "OC") {
                    $data["stu_list"] = $this->db
                        ->where_in("pr_user_id", $sd)
                        ->where_not_in("pr_user_id", $ll)
                        ->get("new_preview_dip")
                        ->result();
                    $count = $this->db
                        ->where_in("pr_user_id", $sd)
                        ->where_not_in("pr_user_id", $ll)
                        ->get("new_preview_dip")
                        ->num_rows();
                } elseif (
                    ($quota == "" || $quota == "MGT") &&
                    $community != "OC"
                ) {
                    $data["stu_list"] = $this->db
                        ->where("pr_community", $community)
                        ->where_in("pr_user_id", $sd)
                        ->where_not_in("pr_user_id", $ll)
                        ->get("new_preview_dip")
                        ->result();
                    $count = $this->db
                        ->where("pr_community", $community)
                        ->where_in("pr_user_id", $sd)
                        ->where_not_in("pr_user_id", $ll)
                        ->get("new_preview_dip")
                        ->num_rows();
                } elseif (
                    ($quota != "" || $quota != "MGT") &&
                    $community == "OC"
                ) {
                    $data["stu_list"] = $this->db
                        ->where("pr_other_res", "Yes")
                        ->where("pr_other_special_reservation", $quota)
                        ->where_in("pr_user_id", $sd)
                        ->where_not_in("pr_user_id", $ll)
                        ->get("new_preview_dip")
                        ->result();
                    $count = $this->db
                        ->where("pr_other_res", "Yes")
                        ->where("pr_other_special_reservation", $quota)
                        ->where_in("pr_user_id", $sd)
                        ->where_not_in("pr_user_id", $ll)
                        ->get("new_preview_dip")
                        ->num_rows();
                } else {
                    $data["stu_list"] = $this->db
                        ->where("pr_community", $community)
                        ->where("pr_other_res", "Yes")
                        ->where("pr_other_special_reservation", $quota)
                        ->where_in("pr_user_id", $sd)
                        ->where_not_in("pr_user_id", $ll)
                        ->get("new_preview_dip")
                        ->result();
                    $count = $this->db
                        ->where("pr_community", $community)
                        ->where("pr_other_res", "Yes")
                        ->where("pr_other_special_reservation", $quota)
                        ->where_in("pr_user_id", $sd)
                        ->where_not_in("pr_user_id", $ll)
                        ->get("new_preview_dip")
                        ->num_rows();
                }
                $data["mesg"] = $this->session->set_flashdata(
                    "success1",
                    "Listed Sucessfully for  Students",
                    "success"
                );
                $data["count"] = $count;
            }
        }

        $this->load->view("template/diploma/header");
        $this->load->view("template/diploma/menubar");
        $this->load->view("template/diploma/headerbar");
        $this->load->view("diploma/stu_community", $data);
        $this->load->view("template/diploma/footer");
    }

    public function zoom_alloc()
    {
        $data["response"] = "";
        if (isset($_POST["submit_link"])) {
            $user = $this->session->userdata("user");
            $user_id = $user["user_id"];
            $dpmnt = $data["dept"] = $user["user_dep_status"];
            $stu_id = $this->input->post("stu_id");

            if ($stu_id == "") {
                $data["form_err"] = $this->session->set_flashdata(
                    "success1",
                    "Please select a student",
                    "success"
                );
                $community = $data["cmnty"] = $this->input->post("community1");
                $linkid = $data["linkid"] = $this->input->post("link_id");
                $quota = $data["quota"] = $this->input->post("quota1");
                //$link_list=$this->db->select('student_id')->get('zoom_alloc')->result();
                $link_det = $this->db
                    ->where("id", $linkid)
                    ->get("zoom")
                    ->row();
                $start_date = date("Y-m-d", strtotime($link_det->start_date));
                $start_time = date("H:i:s", strtotime($link_det->start_time));
                $duration = $link_det->duration;
                $duration *= 60;
                $endTime = date("H:i:s", strtotime($start_time) + $duration);
                $link_list = $this->db
                    ->query(
                        'select student_id from zoom_alloc where (alc_by="' .
                            $user_id .
                            '" and main_course_id="4" and app_course_id="' .
                            $dpmnt .
                            '") or (alc_by!="' .
                            $user_id .
                            '" and (alc_time >= "' .
                            $start_time .
                            '" AND alc_time < "' .
                            $endTime .
                            '") and alc_date="' .
                            $start_date .
                            '") '
                    )
                    ->result();
                $ll = ["0"];
                foreach ($link_list as $lili) {
                    array_push($ll, $lili->student_id);
                }
                $stu_dpmnt = $this->db
                    ->query(
                        'select user_id from Applyed_Cources where applied_course_id="' .
                            $dpmnt .
                            '" and main_course_id="4" '
                    )
                    ->result();
                $sd = ["0"];
                foreach ($stu_dpmnt as $studp) {
                    array_push($sd, $studp->user_id);
                }
                if (($quota == "" || $quota == "MGT") && $community == "OC") {
                    $data["stu_list"] = $this->db
                        ->where_in("pr_user_id", $sd)
                        ->where_not_in("pr_user_id", $ll)
                        ->get("new_preview_dip")
                        ->result();
                    $count = $this->db
                        ->where_in("pr_user_id", $sd)
                        ->where_not_in("pr_user_id", $ll)
                        ->get("new_preview_dip")
                        ->num_rows();
                } elseif (
                    ($quota == "" || $quota == "MGT") &&
                    $community != "OC"
                ) {
                    $data["stu_list"] = $this->db
                        ->where("pr_community", $community)
                        ->where_in("pr_user_id", $sd)
                        ->where_not_in("pr_user_id", $ll)
                        ->get("new_preview_dip")
                        ->result();
                    $count = $this->db
                        ->where("pr_community", $community)
                        ->where_in("pr_user_id", $sd)
                        ->where_not_in("pr_user_id", $ll)
                        ->get("new_preview_dip")
                        ->num_rows();
                } elseif (
                    ($quota != "" || $quota != "MGT") &&
                    $community == "OC"
                ) {
                    $data["stu_list"] = $this->db
                        ->where("pr_other_res", "Yes")
                        ->where("pr_other_special_reservation", $quota)
                        ->where_in("pr_user_id", $sd)
                        ->where_not_in("pr_user_id", $ll)
                        ->get("new_preview_dip")
                        ->result();
                    $count = $this->db
                        ->where("pr_other_res", "Yes")
                        ->where("pr_other_special_reservation", $quota)
                        ->where_in("pr_user_id", $sd)
                        ->where_not_in("pr_user_id", $ll)
                        ->get("new_preview_dip")
                        ->num_rows();
                } else {
                    $data["stu_list"] = $this->db
                        ->where("pr_community", $community)
                        ->where("pr_other_res", "Yes")
                        ->where("pr_other_special_reservation", $quota)
                        ->where_in("pr_user_id", $sd)
                        ->where_not_in("pr_user_id", $ll)
                        ->get("new_preview_dip")
                        ->result();
                    $count = $this->db
                        ->where("pr_community", $community)
                        ->where("pr_other_res", "Yes")
                        ->where("pr_other_special_reservation", $quota)
                        ->where_in("pr_user_id", $sd)
                        ->where_not_in("pr_user_id", $ll)
                        ->get("new_preview_dip")
                        ->num_rows();
                }
                $data["sel_link"] = $this->db
                    ->where("alc_by", $user_id)
                    ->get("zoom")
                    ->result();
                $data["count"] = $count;
            } else {
                $add_date = date("Y-m-d H:i:s");
                $link_id = $this->input->post("link_id");
                $link_det = $this->db
                    ->where("id", $link_id)
                    ->get("zoom")
                    ->row();
                foreach ($stu_id as $stuid) {
                    $data_st["link_id"] = $this->input->post("link_id");
                    $data_st["student_id"] = $stuid;
                    $data_st["alc_date"] = $link_det->start_date;
                    $data_st["alc_time"] = $link_det->start_time;
                    $data_st["alc_duration"] = $link_det->duration;
                    $data_st["alc_by"] = $user_id;
                    $data_st["main_course_id"] = "4";
                    $data_st["app_course_id"] = $dpmnt;
                    $data_st["created_at"] = $add_date;
                    $this->db->insert("zoom_alloc", $data_st);
                }
                $data["mesg"] = $this->session->set_flashdata(
                    "success1",
                    "Link Sent Sucessfully",
                    "success"
                );
                $community = $data["cmnty"] = $this->input->post("community1");
                $linkid = $data["linkid"] = $this->input->post("link_id");
                $quota = $data["quota"] = $this->input->post("quota1");
                //$link_list=$this->db->select('student_id')->get('zoom_alloc')->result();
                $link_det1 = $this->db
                    ->where("id", $linkid)
                    ->get("zoom")
                    ->row();
                $start_date = date("Y-m-d", strtotime($link_det1->start_date));
                $start_time = date("H:i:s", strtotime($link_det1->start_time));
                $duration = $link_det1->duration;
                $duration *= 60;
                $endTime = date("H:i:s", strtotime($start_time) + $duration);
                $link_list = $this->db
                    ->query(
                        'select student_id from zoom_alloc where (alc_by="' .
                            $user_id .
                            '" and main_course_id="4" and app_course_id="' .
                            $dpmnt .
                            '") or (alc_by!="' .
                            $user_id .
                            '" and (alc_time >= "' .
                            $start_time .
                            '" AND alc_time < "' .
                            $endTime .
                            '") and alc_date="' .
                            $start_date .
                            '") '
                    )
                    ->result();
                $ll = [];
                foreach ($link_list as $lili) {
                    array_push($ll, $lili->student_id);
                }
                $stu_dpmnt = $this->db
                    ->query(
                        'select user_id from Applyed_Cources where applied_course_id="' .
                            $dpmnt .
                            '" and main_course_id="4" '
                    )
                    ->result();
                $sd = ["0"];
                foreach ($stu_dpmnt as $studp) {
                    array_push($sd, $studp->user_id);
                }
                if (($quota == "" || $quota == "MGT") && $community == "OC") {
                    $data["stu_list"] = $this->db
                        ->where_in("pr_user_id", $sd)
                        ->where_not_in("pr_user_id", $ll)
                        ->get("new_preview_dip")
                        ->result();
                    $count = $this->db
                        ->where_in("pr_user_id", $sd)
                        ->where_not_in("pr_user_id", $ll)
                        ->get("new_preview_dip")
                        ->num_rows();
                } elseif (
                    ($quota == "" || $quota == "MGT") &&
                    $community != "OC"
                ) {
                    $data["stu_list"] = $this->db
                        ->where("pr_community", $community)
                        ->where_in("pr_user_id", $sd)
                        ->where_not_in("pr_user_id", $ll)
                        ->get("new_preview_dip")
                        ->result();
                    $count = $this->db
                        ->where("pr_community", $community)
                        ->where_in("pr_user_id", $sd)
                        ->where_not_in("pr_user_id", $ll)
                        ->get("new_preview_dip")
                        ->num_rows();
                } elseif (
                    ($quota != "" || $quota != "MGT") &&
                    $community == "OC"
                ) {
                    $data["stu_list"] = $this->db
                        ->where("pr_other_res", "Yes")
                        ->where("pr_other_special_reservation", $quota)
                        ->where_in("pr_user_id", $sd)
                        ->where_not_in("pr_user_id", $ll)
                        ->get("new_preview_dip")
                        ->result();
                    $count = $this->db
                        ->where("pr_other_res", "Yes")
                        ->where("pr_other_special_reservation", $quota)
                        ->where_in("pr_user_id", $sd)
                        ->where_not_in("pr_user_id", $ll)
                        ->get("new_preview_dip")
                        ->num_rows();
                } else {
                    $data["stu_list"] = $this->db
                        ->where("pr_community", $community)
                        ->where("pr_other_res", "Yes")
                        ->where("pr_other_special_reservation", $quota)
                        ->where_in("pr_user_id", $sd)
                        ->where_not_in("pr_user_id", $ll)
                        ->get("new_preview_dip")
                        ->result();
                    $count = $this->db
                        ->where("pr_community", $community)
                        ->where("pr_other_res", "Yes")
                        ->where("pr_other_special_reservation", $quota)
                        ->where_in("pr_user_id", $sd)
                        ->where_not_in("pr_user_id", $ll)
                        ->get("new_preview_dip")
                        ->num_rows();
                }
                $data["sel_link"] = $this->db
                    ->where("alc_by", $user_id)
                    ->get("zoom")
                    ->result();
                $data["count"] = $count;
            }
        }
        $this->load->view("template/diploma/header");
        $this->load->view("template/diploma/menubar");
        $this->load->view("template/diploma/headerbar");
        $this->load->view("diploma/stu_community", $data);
        $this->load->view("template/diploma/footer");
    }

    public function stu_zoom_list()
    {
        $user = $this->session->userdata("user");
        $user_id = $user["user_id"];
        $data["stu_list"] = $this->db
            ->query(
                'select zoom_alloc.*, zoom.id as zoom_id, zoom.confirm_status as confirm_status, zoom.title as title, new_preview_dip.pr_applicant_name as stu_name, new_preview_dip.pr_dob as stu_dob, new_preview_dip.pr_community as stu_comm, sub_preview_dip.UG_two_percentage as ug_perc, online_exam_pannel.total_mark as total_mark from zoom_alloc left join zoom on zoom_alloc.link_id=zoom.id left join new_preview_dip on zoom_alloc.student_id=new_preview_dip.pr_user_id left join sub_preview_dip on sub_preview_dip.sb_u_id=zoom_alloc.student_id left join online_exam_pannel on zoom_alloc.student_id=online_exam_pannel.student_id and online_exam_pannel.exam_category="' .
                    $this->Subject .
                    '" where zoom_alloc.alc_by="' .
                    $user_id .
                    '" group by zoom_alloc.link_id'
            )
            ->result();
        if (isset($_GET["submit"])) {
            $user = $this->session->userdata("user");
            $user_id = $user["user_id"];
            //$stu_id=$this->input->post('stu_id');

            if (isset($_GET)) {
                $search = $_GET;
            } else {
                $search = "";
            }

            $this->db->select(
                "zoom_alloc.*,online_exam_pannel.*, zoom.id as zoom_id, zoom.confirm_status as confirm_status, zoom.title as title, zoom.title as title, new_preview_dip.pr_applicant_name as stu_name, new_preview_dip.pr_dob as stu_dob, new_preview_dip.pr_community as stu_comm, sub_preview_dip.UG_two_percentage as ug_perc, online_exam_pannel.total_mark as total_mark"
            );
            $this->db->from("zoom_alloc");
            $this->db->join("zoom", "zoom_alloc.link_id=zoom.id");
            $this->db->join(
                "new_preview_dip",
                "zoom_alloc.student_id=new_preview_dip.pr_user_id"
            );
            $this->db->join(
                "sub_preview_dip",
                "zoom_alloc.student_id=sub_preview_dip.sb_u_id",
                "left"
            );
            $this->db->join(
                "online_exam_pannel",
                'zoom_alloc.student_id=online_exam_pannel.student_id and zoom_alloc.alc_by="' .
                    $user_id .
                    '"',
                "left"
            );
            $this->db->Where("zoom_alloc.alc_by", $user_id);
            $this->db->group_by("zoom_alloc.link_id");
            if ($search["start_date"] != "" && $search["end_date"] != "") {
                $this->db->where(
                    'zoom_alloc.alc_date between "' .
                        $search["start_date"] .
                        '" and "' .
                        $search["end_date"] .
                        '" '
                );
            } elseif (
                $search["start_date"] != "" &&
                $search["end_date"] == ""
            ) {
                $this->db->where(
                    'zoom_alloc.alc_date >= "' . $search["start_date"] . '" '
                );
            } elseif (
                $search["start_date"] == "" &&
                $search["end_date"] != ""
            ) {
                $this->db->where(
                    'zoom_alloc.alc_date <= "' . $search["end_date"] . '" '
                );
            } else {
            }

            $data["stu_list"] = $this->db->get()->result();
            $data["srch"] = $_REQUEST;
        }
        if (isset($_GET["submit_pdf"])) {
            if (isset($_GET)) {
                $search = $_GET;
            } else {
                $search = "";
            }

            $this->db->select(
                "zoom_alloc.*,online_exam_pannel.*, zoom.id as zoom_id, zoom.confirm_status as confirm_status, zoom.title as title, new_preview_dip.pr_applicant_name as stu_name, new_preview_dip.pr_dob as stu_dob, new_preview_dip.pr_community as stu_comm, sub_preview_dip.UG_two_percentage as ug_perc, online_exam_pannel.total_mark as total_mark"
            );
            $this->db->from("zoom_alloc");
            $this->db->join("zoom", "zoom_alloc.link_id=zoom.id");
            $this->db->join(
                "new_preview_dip",
                "zoom_alloc.student_id=new_preview_dip.pr_user_id"
            );
            $this->db->join(
                "sub_preview_dip",
                "zoom_alloc.student_id=sub_preview_dip.sb_u_id",
                "left"
            );
            $this->db->join(
                "online_exam_pannel",
                "zoom_alloc.student_id=online_exam_pannel.student_id",
                "left"
            );
            $this->db->Where(
                "online_exam_pannel.exam_category",
                $this->Subject
            );
            $this->db->Where("zoom_alloc.alc_by", $user_id);
            if ($search["start_date"] != "" && $search["end_date"] != "") {
                $this->db->where(
                    'zoom_alloc.alc_date between "' .
                        $search["start_date"] .
                        '" and "' .
                        $search["end_date"] .
                        '" '
                );
            } elseif (
                $search["start_date"] != "" &&
                $search["end_date"] == ""
            ) {
                $this->db->where(
                    'zoom_alloc.alc_date >= "' . $search["start_date"] . '" '
                );
            } elseif (
                $search["start_date"] == "" &&
                $search["end_date"] != ""
            ) {
                $this->db->where(
                    'zoom_alloc.alc_date <= "' . $search["end_date"] . '" '
                );
            } else {
            }

            $data["stu_list"] = $this->db->get()->result();
            $data["srch"] = $_REQUEST;
            $this->load->library("pdf");
            $html = $this->load->view("selffinance/stu_zoom_pdf", $data, true);
            //$this->pdf->createPDF($html, 'mypdf', false);
            // Get output html

            $options = new Options();
            $options->set("isRemoteEnabled", true);

            $dompdf = new \Dompdf\Dompdf($options);
            $contxt = stream_context_create([
                "ssl" => [
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                    "allow_self_signed" => true,
                ],
            ]);
            $dompdf->setHttpContext($contxt);
            $dompdf->load_html($html, "mypdf", false);
            $dompdf->setPaper("A4", "landscape");
            $dompdf->render();
            ob_end_clean();
            $dompdf->stream("welcome.pdf", ["Attachment" => 0]);
        }

        /* 
echo $this->Subject;
echo"<pre>";
		print_r($data);
 */

        $this->load->view("template/diploma/header");
        $this->load->view("template/diploma/menubar");
        $this->load->view("template/diploma/headerbar");
        $this->load->view("diploma/stu_zoom_list", $data);
        $this->load->view("template/diploma/footer");
    }

    public function delete_stu_zoom()
    {
        if ($this->input->post("type") == 2) {
            $id = $this->input->post("id");
            $stu_id = $this->input->post("stu_id");
            $course = $this->Subject;
            $app_course = $this->session->userdata("user")["user_dep_status"];
            $this->db->where("id", $id)->delete("zoom_alloc");
            $this->db
                ->where("stu_id", $stu_id)
                ->where("exam_name", $course)
                ->where("app_course_id", $app_course)
                ->delete("student_complete_mark");
            //echo json_encode(array(
            //"statusCode"=>200
            //));
            echo "Deleted Successfully";
        }
    }
    public function stu_zoom_list_det()
    {
        $data["zoom_id"] = $zoom_id = $this->uri->segment(3);
        $add_date = date("y-m-d H:i:s");
        $user = $this->session->userdata("user");
        $user_id = $user["user_id"];

        $data["stu_list"] = $this->db
            ->query(
                'select zoom_alloc.*, zoom.title as title, zoom.confirm_status as publishstatus ,new_preview_dip.pr_applicant_name as stu_name, new_preview_dip.pr_dob as stu_dob, new_preview_dip.pr_community as stu_comm, sub_preview_dip.UG_two_percentage as ug_perc, online_exam_pannel.total_mark as total_mark, student_complete_mark.personal_mark as per_mark from zoom_alloc left join zoom on zoom_alloc.link_id=zoom.id left join new_preview_dip on zoom_alloc.student_id=new_preview_dip.pr_user_id left join sub_preview_dip on sub_preview_dip.sb_u_id=zoom_alloc.student_id left join online_exam_pannel on zoom_alloc.student_id=online_exam_pannel.student_id and online_exam_pannel.exam_category="' .
                    $this->Subject .
                    '" left join student_complete_mark on zoom_alloc.student_id=student_complete_mark.stu_id and zoom_alloc.app_course_id=student_complete_mark.app_course_id and student_complete_mark.main_course_id="4" where zoom_alloc.link_id="' .
                    $zoom_id .
                    '" and zoom_alloc.alc_by="' .
                    $user_id .
                    '" group by student_id '
            )
            ->result();

        if (isset($_POST["submit"])) {
            $user = $this->session->userdata("user");
            $user_id = $user["user_id"];
            $data["zoom_id"] = $zoom_id1 = $this->input->post("zoom_id");
            $id = $this->input->post("id");
            $per_mark = $this->input->post("per_mark");
            $app_course_id = $this->session->userdata("user")[
                "user_dep_status"
            ];

            $det = $this->db
                ->query(
                    'select zoom_alloc.*, zoom.title as title, new_preview_dip.pr_caste as stu_caste, new_preview_dip.pr_community as stu_comm, sub_preview_dip.UG_two_percentage as ug_perc, online_exam_pannel.total_mark as total_mark from zoom_alloc left join zoom on zoom_alloc.link_id=zoom.id left join new_preview_dip on zoom_alloc.student_id=new_preview_dip.pr_user_id left join sub_preview_dip on sub_preview_dip.sb_u_id=zoom_alloc.student_id left join online_exam_pannel on zoom_alloc.student_id=online_exam_pannel.student_id where online_exam_pannel.exam_category="' .
                        $this->Subject .
                        '" and zoom_alloc.id="' .
                        $id .
                        '" '
                )
                ->row();

            $data_pmark = [
                "stu_id" => $det->student_id,
                "exam_name" => $this->Subject,
                "ug_mark" => $det->ug_perc,
                "date" => $add_date,
                "enterence_mark" => $det->total_mark,
                "personal_mark" => $per_mark,
                "community" => $det->stu_comm,
                "cast" => $det->stu_caste,
                "main_course_id" => "4",
                "app_course_id" => $app_course_id,
                "zoom_id" => $zoom_id1,
            ];

            $get_stu = $this->db
                ->where("stu_id", $det->student_id)
                ->where("exam_name", $this->Subject)
                ->where("app_course_id", $app_course_id)
                ->where("main_course_id", "4")
                ->get("student_complete_mark")
                ->row();
            if (empty($get_stu)) {
                $this->db->insert("student_complete_mark", $data_pmark);
            } else {
                $this->db->where("m_id", $get_stu->m_id);
                $this->db->update("student_complete_mark", $data_pmark);
            }
            $data["mesg"] = $this->session->set_flashdata(
                "success",
                "Updated Marks Successfully"
            );
            redirect("pgDiploma/stu_zoom_list_det/" . $zoom_id1 . "");
        }

        $this->load->view("template/diploma/header");
        $this->load->view("template/diploma/menubar");
        $this->load->view("template/diploma/headerbar");
        $this->load->view("diploma/stu_zoom_list_det", $data);
        $this->load->view("template/diploma/footer");
    }
    public function stu_zoom_pdf()
    {
        $data["stu_list"] = $this->db
            ->query(
                'select zoom_alloc.*, zoom.title as title, new_preview_dip.pr_applicant_name as stu_name, new_preview_dip.pr_dob as stu_dob, new_preview_dip.pr_community as stu_comm, sub_preview_dip.UG_two_percentage as ug_perc, (select sum(new_online_exam_answer.score) from new_online_exam_answer where new_online_exam_answer.user_id=zoom_alloc.student_id) as marks, online_exam_pannel.total_mark as total_mark from zoom_alloc left join zoom on zoom_alloc.link_id=zoom.id left join new_preview_dip on zoom_alloc.student_id=new_preview_dip.pr_user_id left join sub_preview_dip on sub_preview_dip.sb_u_id=zoom_alloc.student_id left join online_exam_pannel on zoom_alloc.student_id=online_exam_pannel.student_id where online_exam_pannel.exam_category="' .
                    $this->Subject .
                    '" '
            )
            ->result();
        $this->load->view("diploma/stu_zoom_pdf", $data);
    }

    public function stu_pdf()
    {
        $user_id = $this->uri->segment(3);
        $m_course = "3";

        $pr_user = $this->db
            ->select("*")
            ->from("new_preview_dip")
            ->where("pr_user_id", $user_id)
            ->get();
        $pr_study = $this->db
            ->select("*")
            ->from("sub_preview_dip")
            ->where("sb_u_id", $user_id)
            ->get();

        $q = $this->db
            ->select("*")
            ->from("college_course")
            ->get();

        $data["cc"] = $q->result();

        $data["user"] = $pr_user->result();
        $data["Study"] = $pr_study->result();

        $this->load->view("diploma/stu_pdf", $data);
    }


	
	public function panelPdf()
    {
        $pannel_id = $this->uri->segment(3);

        $pr_user = $this->db
            ->select("*")
            ->from("zoom")
            ->where("id", $pannel_id)
            ->get();

        $usd = $pr_user->result();

        $m = $this->db
            ->select("*")
            ->from("zoom_alloc")
            ->join(
                "Applyed_Cources",
                "zoom_alloc.student_id=Applyed_Cources.user_id"
            )
            ->join(
                "new_preview_dip",
                "zoom_alloc.student_id=new_preview_dip.pr_user_id"
            )
            ->join(
                "sub_preview_dip",
                "zoom_alloc.student_id=sub_preview_dip.sb_u_id",
                "left"
            )
            ->join(
                "online_exam_pannel",
                "zoom_alloc.student_id=online_exam_pannel.student_id",
                "left"
            )
            ->Where("online_exam_pannel.exam_category", $this->Subject)
            ->Where("Applyed_Cources.main_course_id", 4)
            ->Where(
                "Applyed_Cources.applied_course_id",
                $this->session->userdata("user")["user_dep_status"]
            )
            ->where("zoom_alloc.link_id", $pannel_id)
            ->get();

        $nm = $m->result();

        $depname = $this->db
            ->select("*")
            ->from("college_course")
            ->Where("mc_id", 3)
            ->Where(
                "cs_id",
                $this->session->userdata("user")["user_dep_status"]
            )
            ->get();

        $dept_name = $depname->result();

        /* echo"<pre>";
         print_r($nm); */
        $temp = "";

        foreach ($nm as $key => $tnde) {
            $ug = number_format((float) $tnde->UG_two_percentage, 2, ".", "");

            $ent = number_format((float) $tnde->total_mark, 2, ".", "");

            $total = $ug + $ent;
            $totn = number_format((float) $total, 2, ".", "");

            $data = [
                "app_no" => $tnde->application_number,
                "app_name" => strtoupper($tnde->pr_applicant_name),
                "ref_id" => $tnde->pr_user_id,
                "date" => date("d-m-Y", strtotime($tnde->pr_dob)),
                "ug_mark" => $ug,
                "pg_mark" => $ent,
                "totak_mark" => $totn,
                "community" => $tnde->pr_community,
            ];

            $newArray[$key] = $data;
        }
        //$data = array_column($data, 'totak_mark');

        usort($newArray, function ($a, $b) {
            return $b["totak_mark"] > $a["totak_mark"] ? 1 : -1;
        });

        $i = 1;
        foreach ($newArray as $tnt) {
            $temp .=
                '   <tr align="center">
	<td>' .
                $i .
                '</td>
	<td>' .
                $tnt["app_no"] .
                '</td>
	<td>' .
                strtoupper($tnt["app_name"]) .
                '</td>
	<td>' .
                "21" .
                sprintf("%'04d", $tnt["ref_id"]) .
                '</td>
	<td>' .
                date("d-m-Y", strtotime($tnt["date"])) .
                '</td>
	<td>' .
                $tnt["ug_mark"] .
                '</td>
	<td>' .
                $tnt["pg_mark"] .
                '</td>
	<td>' .
                $tnt["totak_mark"] .
                '</td>
	<td>' .
                $tnt["community"] .
                '</td>
	
	</tr>';

            $i++;
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


	 tr:nth-child(even){background-color: #f2f2f2;}

 tr:hover {background-color: #ddd;}
	  
</style>

</head>
<body>
<div id ="center">  
<img  src="http://test.mssw.in//landing/images/mssw_logo.jpg" width="60%" height="75px;">
</div>  

<br>
<h3 align="center"> Interview Schedule For ' .
            $dept_name[0]->cs_name .
            '</h3>
<h5>  Interview Name :' .
            $usd[0]->title .
            '</h5>
<h5> Interview Date & Time : ' .
            date("d-m-Y", strtotime($usd[0]->start_date)) .
            " & " .
            date("H:i ", strtotime($usd[0]->start_time)) .
            " (24-hour), Duration : " .
            $usd[0]->duration .
            ' Mins</h5>
<h5>  Zoom Link :' .
            $usd[0]->link .
            '</h5>
  <table width="100%">
  <thead style="background-color: lightgray;">
	<tr>
	  <th  width="5%">Sno.</th>
	  <th width="15%">Application Number</th>
	  <th width="26%">Student Name</th>
	  <th width="9%">Reference Id</th>
	  <th width="15%">Date of Birth</th>
	  <th width="7%">UG Mark</th>
	  <th width="7%">Entrance Mark</th>
	  <th width="7%">Total</th>
	  <th width="9%">Community</th>
		 
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
  <h5 align="right"> Sd/-</h5>
  
  <h5 align="right"> HoD/Program Head</h5>
  <br>
  <br>
  <br>
  <h6 align="center">Generated by MSSW Campus Management System.</h6>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
  $( document ).ready(function() {
  var $tbody = $("table tbody");
  $tbody.find("tr").sort(function(a,b){ 
	  var tda = $(a).find("td:eq(7)").text(); // can replace 1 with the column you want to sort on
	  var tdb = $(b).find("td:eq(7)").text(); // this will sort on the second column
			  
	  return tda > tdb ? 1 
			
			 : tda < tdb ? -1 
			
			 : 0;           
  }).appendTo($tbody);
});
  </script>
';

        $dompdf->load_html($html);
        $dompdf->render();

        $dompdf->stream($usd[0]->title);
    }
	
	public function publishPanel()
    {
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

        $user_id = [];
        $send_email = "";

        $id = $this->input->post("panel_id");
        $defect = $this->db
            ->select("*")
            ->from("zoom")
            ->where("id", $id)
            ->get();
        $ids = $defect->result();

        $student = $this->db
            ->select("*")
            ->from("zoom_alloc")
            ->where("link_id", $id)
            ->get();
        $sl = $student->result();

        foreach ($sl as $key => $value) {
            array_push($user_id, $value->student_id);
        }

        $zoom_panel = [
            "confirm_status" => 1,
        ];
        $zoom_complete = [
            "publish_link" => 1,
            "publish_date" => date("Y-m-d H:i:s"),
            "publish_by" => $this->session->userdata("user")["user_id"],
        ];

        $this->db->where("id", $id);
        $this->db->Update("zoom", $zoom_panel);

        foreach ($sl as $key => $values) {
            $this->db->where("id", $values->id);
            $this->db->Update("zoom_alloc", $zoom_complete);
        }

        $email = $this->db
            ->select("*")
            ->from("stu_user")
            ->where_in("u_id", $user_id)
            ->get();
        $u_email = $email->result();
        //print_r($u_email);

        foreach ($u_email as $mail) {
            // $mail->u_email_id;

            $user = $this->db
                ->select("*")
                ->from("new_preview_pg")

                ->where("pr_user_id", $mail->u_id)
                ->get();
            $user_details = $user->result();

            $application = $this->db
                ->select("*")
                ->from("Applyed_Cources")
                ->where("main_course_id", 4)
                ->where(
                    "applied_course_id",
                    $this->session->userdata("user")["user_dep_status"]
                )
                ->where("user_id", $mail->u_id)
                ->get();
            $app_details = $application->result();

            $subject =
                "MSSW Admission - Shortlisted for Online Interview - Regarding";
            echo $msg =
                "Dear Mr./Ms." .
                $user_details[0]->pr_applicant_name .
                " ,<br> 
	
	Greetings! <br> 
	
	With reference to your application for " .
                $app_details[0]->course_name .
                ", Application Number: " .
                $app_details[0]->application_number .
                ",<br> 
	 Appear for online Zoom Interview on {" .
                date("d-m-Y", strtotime($ids[0]->start_date)) .
                "} at {" .
                date("H:i", strtotime($ids[0]->start_time)) .
                "}.<br> 
	 
	 
	 
	 
	 <a href='https://admission.mssw.in//Home/login'>Login </a> to your account to attend the interview.<br> 
	
	Visit <a href='https://mssw.in/admissions/#PGAdmissions'>P.G.admissions</a> page and check your login for more details.<br><br>  <br> 
	
	Regards,<br><br>  
	
	Principal, MSSW.<br> 
	www.mssw.in
	";
            $this->testEmail($mail->u_email_id, $subject, $msg);
        }
    }

    public function panelEmail()
    {
        $user_id = [];

        $id = $this->input->post("panel_id");
        $defect = $this->db
            ->select("*")
            ->from("zoom")
            ->where("id", $id)
            ->get();
        $ids = $defect->result();

        $student = $this->db
            ->select("*")
            ->from("zoom_alloc")
            ->where("link_id", $id)
            ->get();
        $sl = $student->result();

        foreach ($sl as $key => $value) {
            array_push($user_id, $value->student_id);
        }

        $email = $this->db
            ->select("*")
            ->from("stu_user")
            ->where_in("u_id", $user_id)
            ->get();
        $u_email = $email->result();

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

        foreach ($u_email as $mail) {
            $this->testEmail($mail->u_email_id, $email_subject, $email_content);
        }

        $this->session->set_flashdata(
            "message",
            ' <div class="alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong> Emailed  to ' .
                $ids[0]->title .
                ' Successfully
</div>'
        );

        redirect("PgDiploma/stu_zoom_list", "refresh");
    }

    public function OnlineExamMark(){

/*         print_r($_GET );

exit; */
$update_status = $_GET['update'];
$existing = $_GET['existing'];
$student_id = $_GET['student_id'];
$total_mark = $_GET['total_mark'];
$assign_mark = $_GET['assign_mark'];


if($existing == 1){



$update = array(
    'student_id'=>$student_id,
    'exam_category'=>$this->Subject,
    'question_type'=>1,
  
    'status'=>1,
    'question_attended'=>$total_mark,
    'total_mark'=>$assign_mark,
    'exam_mode'=>1,
);


$this->db->where("e_id",$update_status);
$this->db->update("online_exam_pannel",$update);

}else{

    $insert = array(
        'student_id'=>$student_id,
    'exam_category'=>$this->Subject,
    'question_type'=>1,
   
    'status'=>1,
    'question_attended'=>$total_mark,
    'total_mark'=>$assign_mark,
    'exam_mode'=>1,
    );
    $this->db->insert("online_exam_pannel",$insert);  


}

$this->session->set_flashdata(
    "message",
    ' <div class="alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong>  Successfully Inserted or updated
</div>'
);

redirect("PgDiploma/studentApplied", "refresh");

    }

    public function interviewAttendedStudent()
    {
        $m = $this->db
            ->select("*")
            ->from("student_complete_mark")
            ->join(
                "stu_user",
                "student_complete_mark.stu_id=stu_user.u_id",
                "right"
            )
            ->join(
                "Applyed_Cources",
                "student_complete_mark.stu_id=Applyed_Cources.user_id AND student_complete_mark.main_course_id=Applyed_Cources.main_course_id AND student_complete_mark.app_course_id=Applyed_Cources.applied_course_id"
            )
            ->join(
                "new_preview_dip",
                "student_complete_mark.stu_id=new_preview_dip.pr_user_id"
            )
            ->join(
                "sub_preview_dip",
                "student_complete_mark.stu_id=sub_preview_dip.sb_u_id",
                "left"
            )
            ->where("student_complete_mark.main_course_id", 4)
            ->where(
                "student_complete_mark.app_course_id",
                $this->session->userdata("user")["user_dep_status"]
            )
            ->get();
        $rs = $m->result();

        $data["student"] = $m->result();

        $this->load->view("template/diploma/header");
        $this->load->view("template/diploma/menubar");
        $this->load->view("template/diploma/headerbar");
        $this->load->view("diploma/applied_mark_list", $data);
        $this->load->view("template/diploma/footer");

        /* 
	echo"<pre>";
	print_r($rs);
	 */
    }


    public function SeatAllocation()
    {
        $std = $this->db
            ->select("*")
            ->from("resrvation_table")
            ->where("rc_main_id", 4)
            ->where(
                "rc_cource_id",
                $this->session->userdata("user")["user_dep_status"]
            )
            ->get();

        $data["reservation"] = $std->result();

        $this->load->view("template/diploma/header");
        $this->load->view("template/diploma/menubar");
        $this->load->view("template/diploma/headerbar");
        $this->load->view("diploma/seat_allocation", $data);
        $this->load->view("template/diploma/footer");
    }
    public function studentCertificate(){


        $user_id =$this->uri->segment(3);
    
    
        $pr_user = $this->db->select('*')->from('new_preview_dip')->where('pr_user_id',$user_id)->get();
        
        
        $data['user']  = $pr_user->result();
    
    
        $cer_com = $this->db->select('*')->from('Certificate_comments')->where('student_id',$user_id)->get();
        $cer = $cer_com->num_rows();
    
    
        if($cer == 0){
    $insert= array(
        'student_id'=>$user_id,
        'date'=>date('Y-m-d'),
        //'status'=>1,
    );
    $this->db->insert('Certificate_comments',$insert);
    
    }
    $cer_comm = $this->db->select('*')->from('Certificate_comments')->where('student_id',$user_id)->get();
    $data['user_certificate']  = $cer_comm->result();
    
        //$data['certificate'] = array($cer[0]->pr_semester_1, $cer[0]->pr_semester_2, $cer[0]->pr_semester_3, $cer[0]->pr_semester_4, $cer[0]->pr_semester_5, $cer[0]->pr_semester_6, $cer[0]->pr_semester_7, $cer[0]->pr_semester_8, $cer[0]->pr_provisional_pg_cer, $cer[0]->pr_ug_cer, $cer[0]->pr_cummulative_cer, $cer[0]->pr_community_cer, $cer[0]->pr_conduct_cer, $cer[0]->pr_transfer_cer, $cer[0]->pr_abled_certificate);
    
    
    //print_r($certificates);
    
    $this->load->view('template/diploma/header');
      $this->load->view('template/diploma/menubar');
      $this->load->view('template/diploma/headerbar');
      $this->load->view('diploma/certificates',$data);
      $this->load->view('template/diploma/footer'); 
    
    
    
    
    }

    public function createBatch(){

        $dep_id = $this->session->userdata("user")["user_dep_status"];

       $data['batch'] =  $this->db->select('*')->from('acadamic_year')->get()->result();
       $data['createdbatch'] =  $this->db->select('*')->from('pg_dip_batch')->where('dep_id',$dep_id)->get()->result();
  
  
        $this->load->view('template/diploma/header');
        $this->load->view('template/diploma/menubar');
        $this->load->view('template/diploma/headerbar');
        $this->load->view('diploma/createbatch',$data);
        $this->load->view('template/diploma/footer');

    } public function addBatch(){

        $batch = $this->input->post("batch");
        $sem = $this->input->post("sem");
        $dep_id = $this->session->userdata("user")["user_dep_status"];

      $num =  $this->db->select('*')->from('pg_dip_batch')->where('batch',$batch)->where('semester',$sem)->where('dep_id',$dep_id)->get()->num_rows();
  

      if($num == 0){

        $data = array(
            'batch'=>$batch,
            'semester'=>$sem,
            'dep_id'=>$dep_id,
        );

$this->db->insert('pg_dip_batch',$data);
        $this->session->set_flashdata(
            "message",
            ' <div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success !</strong>  Successfully Batch created
    </div>'
        );
    
        redirect("PgDiploma/createBatch", "refresh");

      }else{

        $this->session->set_flashdata(
            "message",
            ' <div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Failed !</strong>  Already Batch created
    </div>'
        );
    
        redirect("PgDiploma/createBatch", "refresh");

      }
        
    }
    public function addstudent(){

$year = $this->uri->segment('3');
$semester = $this->uri->segment('4');
        $sta = $this->db
        ->select("user_id")
        ->from("Applyed_Cources")
        ->where("main_course_id", 4)
        ->where(
            "applied_course_id",
            $this->session->userdata("user")["user_dep_status"]
        )
        ->get();

    $applied_stu = $sta->result_array();

    $arr = array_column($applied_stu, "user_id");
    if (sizeof($arr) == 0) {
        $arr = ["0"];
    }

    $this->db->select(
        "stu_user.*,Applyed_Cources.*,new_preview_dip.*,sub_preview_dip.*,Applyed_Master.*"
    );
    
    $this->db->from("Applyed_Cources");

    $this->db->join(
        "Applyed_Master",
        "Applyed_Master.id=Applyed_Cources.master_id",
        "left"
    ) ;
    $this->db->join(
        "stu_user",
        "Applyed_Cources.user_id=stu_user.u_id",
        "right"
    );
    $this->db->join(
        "new_preview_dip",
        "Applyed_Cources.user_id=new_preview_dip.pr_user_id",
        "right"
    );
    $this->db->join(
        "sub_preview_dip",
        "Applyed_Cources.user_id=sub_preview_dip.sb_u_id",
        "right"
    );
    //$this->db->join('online_exam_pannel', 'Applyed_Cources.user_id=online_exam_pannel.student_id','right');
    //   $this->db->join('student_complete_mark', 'stu_user.u_id=student_complete_mark.stu_id','left');
    $this->db->where(
        "Applyed_Cources.applied_course_id",
        $this->session->userdata("user")["user_dep_status"]
    );$this->db->where(
        "stu_user.u_year",
        $year
    );
    //	$this->db->where('online_exam_pannel.exam_category',$this->Subject);
    //$this->db->where('student_complete_mark.exam_name',$this->Subject);
    $this->db->where_in("Applyed_Cources.user_id", $arr);
    $st = $this->db->get();

    $data["student"] = $st->result();
/* echo"<pre>";
print_r($data);
 */

 $this->load->view('template/diploma/header');
 $this->load->view('template/diploma/menubar');
 $this->load->view('template/diploma/headerbar');
 $this->load->view('diploma/admitedstudent',$data);
 $this->load->view('template/diploma/footer');


    }

}
