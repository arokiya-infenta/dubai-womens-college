<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require APPPATH . '/libraries/dompdf/autoload.inc.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
	use Dompdf\Dompdf;
	use Dompdf\Options;
class Admin extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	//  error_reporting(0);
	  date_default_timezone_set("Asia/Calcutta");
	  $this->load->library('upload');
	  $this->load->config('email');
		$this->load->library('email');
	  
		$this->load->library('pdf');

	
	}



	public function index()
	{
    $this->load->view('template/admin/header');
    $this->load->view('template/admin/menubar');
    $this->load->view('template/admin/headerbar');
    $this->load->view('admin/dashbord');
    $this->load->view('template/admin/footer');
    }
public function selectionDashbord(){


	$this->load->view('template/admin/header');
    $this->load->view('template/admin/menubar');
    $this->load->view('template/admin/headerbar');
    $this->load->view('admin/selectiondashboard');
    $this->load->view('template/admin/footer');


}




public function StudentSelectionList(){

$maincourse = $this->uri->segment(3);
$department_course = $this->uri->segment(4);

if($maincourse==4){$new_preview='new_preview_dip';}
elseif($maincourse==5){$new_preview='new_preview';}
else{$new_preview='new_preview_pg';}



$user = $this->db
->select("*")
->from("shotlisted_candidate")
->join(
	"Applyed_Cources",
	"Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id"
)

->join(
	"student_complete_mark",
	"student_complete_mark.stu_id=shotlisted_candidate.sl_student_id  AND student_complete_mark.app_course_id=shotlisted_candidate.sl_course_id"
,'left' )

->join(
	"stu_user",
	"stu_user.u_id=shotlisted_candidate.sl_student_id"
,'left' )

->join(
	"verified_ug",
	"verified_ug.stu_id=shotlisted_candidate.sl_student_id AND verified_ug.main_id=shotlisted_candidate.sl_main_id AND verified_ug.applied_id=shotlisted_candidate.sl_course_id"
,'left' )

   ->join(
	$new_preview,
	"shotlisted_candidate.sl_student_id=".$new_preview.".pr_user_id"
) 
->where("shotlisted_candidate.sl_main_id",$maincourse)
->where(
	"shotlisted_candidate.sl_course_id",
	$department_course
)
->where("shotlisted_candidate.reservation_status",1)
->order_by("student_complete_mark.total_mark", "DESC")
->get();


if($maincourse==4){$data["student_dip"] = $user->result();}
elseif($maincourse==5){$data["student_ug"] = $user->result();}
else{$data["student_pg"] = $user->result();}

$published = $this->db
->select("*")
->from("shotlisted_candidate")
->join(
	"Applyed_Cources",
	"Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id"
)

->join(
	"student_complete_mark",
	"student_complete_mark.stu_id=shotlisted_candidate.sl_student_id  AND student_complete_mark.app_course_id=shotlisted_candidate.sl_course_id"
,'left' )

->join(
	"stu_user",
	"stu_user.u_id=shotlisted_candidate.sl_student_id"
,'left' )

   ->join(
	$new_preview,
	"shotlisted_candidate.sl_student_id=".$new_preview.".pr_user_id"
) 
->where("shotlisted_candidate.sl_main_id",$maincourse)
->where("shotlisted_candidate.principal_published",1)
->where(
	"shotlisted_candidate.sl_course_id",
	$department_course
)
->where("shotlisted_candidate.reservation_status",1)
->order_by("student_complete_mark.total_mark", "DESC")
->get();


$data['approved'] =$published->num_rows();
$not_published = $this->db
->select("*")
->from("shotlisted_candidate")
->join(
	"Applyed_Cources",
	"Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id"
)

->join(
	"student_complete_mark",
	"student_complete_mark.stu_id=shotlisted_candidate.sl_student_id  AND student_complete_mark.app_course_id=shotlisted_candidate.sl_course_id"
,'left' )

->join(
	"stu_user",
	"stu_user.u_id=shotlisted_candidate.sl_student_id"
,'left' )

   ->join(
	$new_preview,
	"shotlisted_candidate.sl_student_id=".$new_preview.".pr_user_id"
) 
->where("shotlisted_candidate.sl_main_id",$maincourse)
->where("shotlisted_candidate.principal_published",0)
->where(
	"shotlisted_candidate.sl_course_id",
	$department_course
)
->where("shotlisted_candidate.reservation_status",1)
->order_by("student_complete_mark.total_mark", "DESC")
->get();
$data['not_approved'] =$not_published->num_rows();



$this->load->view("template/admin/header");
$this->load->view("template/admin/menubar");
$this->load->view("template/admin/headerbar");
$this->load->view("admin/shortlisted_list", $data);
$this->load->view("template/admin/footer");





}
public function StudentWaitingList(){

$maincourse = $this->uri->segment(3);
$department_course = $this->uri->segment(4);

if($maincourse==4){$new_preview='new_preview_dip';}
elseif($maincourse==5){$new_preview='new_preview';}
else{$new_preview='new_preview_pg';}

$user = $this->db
->select("*")
->from("shotlisted_candidate")
->join(
	"Applyed_Cources",
	"Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id"
)

->join(
	"student_complete_mark",
	"student_complete_mark.stu_id=shotlisted_candidate.sl_student_id  AND student_complete_mark.app_course_id=shotlisted_candidate.sl_course_id"
,'left' )

->join(
	"stu_user",
	"stu_user.u_id=shotlisted_candidate.sl_student_id"
,'left' )

->join(
	"verified_ug",
	"verified_ug.stu_id=shotlisted_candidate.sl_student_id AND verified_ug.main_id=shotlisted_candidate.sl_main_id AND verified_ug.applied_id=shotlisted_candidate.sl_course_id"
,'left' )

   ->join(
	$new_preview,
	"shotlisted_candidate.sl_student_id=".$new_preview.".pr_user_id"
) 
->where("shotlisted_candidate.sl_main_id",$maincourse)
->where(
	"shotlisted_candidate.sl_course_id",
	$department_course
)
->where("shotlisted_candidate.reservation_status",2)
->order_by("student_complete_mark.total_mark", "DESC")
->get();


if($maincourse==4){$data["student_dip"] = $user->result();}
elseif($maincourse==5){$data["student_ug"] = $user->result();}
else{$data["student_pg"] = $user->result();}

$published = $this->db
->select("*")
->from("shotlisted_candidate")
->join(
	"Applyed_Cources",
	"Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id"
)

->join(
	"student_complete_mark",
	"student_complete_mark.stu_id=shotlisted_candidate.sl_student_id  AND student_complete_mark.app_course_id=shotlisted_candidate.sl_course_id"
,'left' )

->join(
	"stu_user",
	"stu_user.u_id=shotlisted_candidate.sl_student_id"
,'left' )

   ->join(
	$new_preview,
	"shotlisted_candidate.sl_student_id=".$new_preview.".pr_user_id"
) 
->where("shotlisted_candidate.sl_main_id",$maincourse)
->where("shotlisted_candidate.principal_published",1)
->where(
	"shotlisted_candidate.sl_course_id",
	$department_course
)
->where("shotlisted_candidate.reservation_status",2)
->order_by("student_complete_mark.total_mark", "DESC")
->get();


$data['approved'] =$published->num_rows();
$not_published = $this->db
->select("*")
->from("shotlisted_candidate")
->join(
	"Applyed_Cources",
	"Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id"
)

->join(
	"student_complete_mark",
	"student_complete_mark.stu_id=shotlisted_candidate.sl_student_id  AND student_complete_mark.app_course_id=shotlisted_candidate.sl_course_id"
,'left' )

->join(
	"stu_user",
	"stu_user.u_id=shotlisted_candidate.sl_student_id"
,'left' )

   ->join(
	$new_preview,
	"shotlisted_candidate.sl_student_id=".$new_preview.".pr_user_id"
) 
->where("shotlisted_candidate.sl_main_id",$maincourse)
->where("shotlisted_candidate.principal_published",0)
->where(
	"shotlisted_candidate.sl_course_id",
	$department_course
)
->where("shotlisted_candidate.reservation_status",2)
->order_by("student_complete_mark.total_mark", "DESC")
->get();
$data['not_approved'] =$not_published->num_rows();



$this->load->view("template/admin/header");
$this->load->view("template/admin/menubar");
$this->load->view("template/admin/headerbar");
$this->load->view("admin/waiting_list", $data);
$this->load->view("template/admin/footer");





}
public function StudentNotEligibleList(){

$maincourse = $this->uri->segment(3);
$department_course = $this->uri->segment(4);

if($maincourse==4){$new_preview='new_preview_dip';}
elseif($maincourse==5){$new_preview='new_preview';}
else{$new_preview='new_preview_pg';}

$user = $this->db
->select("*")
->from("shotlisted_candidate")
->join(
	"Applyed_Cources",
	"Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id"
)

->join(
	"student_complete_mark",
	"student_complete_mark.stu_id=shotlisted_candidate.sl_student_id  AND student_complete_mark.app_course_id=shotlisted_candidate.sl_course_id"
,'left' )

->join(
	"stu_user",
	"stu_user.u_id=shotlisted_candidate.sl_student_id"
,'left' )

->join(
	"verified_ug",
	"verified_ug.stu_id=shotlisted_candidate.sl_student_id AND verified_ug.main_id=shotlisted_candidate.sl_main_id AND verified_ug.applied_id=shotlisted_candidate.sl_course_id"
,'left' )

   ->join(
	$new_preview,
	"shotlisted_candidate.sl_student_id=".$new_preview.".pr_user_id"
) 
->where("shotlisted_candidate.sl_main_id",$maincourse)
->where(
	"shotlisted_candidate.sl_course_id",
	$department_course
)
->where("shotlisted_candidate.reservation_status",3)
->order_by("student_complete_mark.total_mark", "DESC")
->get();


if($maincourse==4){$data["student_dip"] = $user->result();}
elseif($maincourse==5){$data["student_ug"] = $user->result();}
else{$data["student_pg"] = $user->result();}

$published = $this->db
->select("*")
->from("shotlisted_candidate")
->join(
	"Applyed_Cources",
	"Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id"
)

->join(
	"student_complete_mark",
	"student_complete_mark.stu_id=shotlisted_candidate.sl_student_id  AND student_complete_mark.app_course_id=shotlisted_candidate.sl_course_id"
,'left' )

->join(
	"stu_user",
	"stu_user.u_id=shotlisted_candidate.sl_student_id"
,'left' )

   ->join(
	$new_preview,
	"shotlisted_candidate.sl_student_id=".$new_preview.".pr_user_id"
) 
->where("shotlisted_candidate.sl_main_id",$maincourse)
->where("shotlisted_candidate.principal_published",1)
->where(
	"shotlisted_candidate.sl_course_id",
	$department_course
)
->where("shotlisted_candidate.reservation_status",3)
->order_by("student_complete_mark.total_mark", "DESC")
->get();


$data['approved'] =$published->num_rows();
$not_published = $this->db
->select("*")
->from("shotlisted_candidate")
->join(
	"Applyed_Cources",
	"Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id"
)

->join(
	"student_complete_mark",
	"student_complete_mark.stu_id=shotlisted_candidate.sl_student_id  AND student_complete_mark.app_course_id=shotlisted_candidate.sl_course_id"
,'left' )

->join(
	"stu_user",
	"stu_user.u_id=shotlisted_candidate.sl_student_id"
,'left' )

   ->join(
	$new_preview,
	"shotlisted_candidate.sl_student_id=".$new_preview.".pr_user_id"
) 
->where("shotlisted_candidate.sl_main_id",$maincourse)
->where("shotlisted_candidate.principal_published",0)
->where(
	"shotlisted_candidate.sl_course_id",
	$department_course
)
->where("shotlisted_candidate.reservation_status",3)
->order_by("student_complete_mark.total_mark", "DESC")
->get();
$data['not_approved'] =$not_published->num_rows();



$this->load->view("template/admin/header");
$this->load->view("template/admin/menubar");
$this->load->view("template/admin/headerbar");
$this->load->view("admin/not_eligible_list", $data);
$this->load->view("template/admin/footer");





}


public function approveStudentAll(){

	$tmr = $_POST["id"];

    foreach($tmr as $ids){
	$approve_all = [
		"principal_published" => 1,
		"principal_date" => date("Y-m-d H:i"),
	];

	$this->db->where("sl_id", $ids);
	$this->db->update("shotlisted_candidate", $approve_all);
	}


	echo $this->session->set_flashdata(
		"message",
		' <div class="alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong> successfully Approved to make Payment!
</div>'
	);

}

public function approveStudent(){

	$tmr = $_POST["id"];



	$reject = [
		"principal_published" => 1,
		"principal_date" => date("Y-m-d H:i"),
	];

	$this->db->where("sl_id", $tmr);
	$this->db->update("shotlisted_candidate", $reject);


	echo $this->session->set_flashdata(
		"message",
		' <div class="alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong> successfully Approved to make Payment!
</div>'
	);


}public function notApproveStudent(){

	$tmr = $_POST["id"];



	$reject = [
		"principal_published" => 0,
		"principal_date" => date("Y-m-d H:i"),
	];

	$this->db->where("sl_id", $tmr);
	$this->db->update("shotlisted_candidate", $reject);


	echo $this->session->set_flashdata(
		"message",
		' <div class="alert alert-warning alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Removed !</strong> Removed Candidate to make Payment!
</div>'
	);


}







	public function studentApplied(){





		$ma_hr=$this->db->select("user_id")->from("Applyed_Cources")->where("main_course_id",1)->where("applied_course_id",5)->get();
		$applied_ma_hr =$ma_hr->result_array();
		$arrma_hr = array_column($applied_ma_hr, "user_id");
		if( sizeof($arrma_hr) == 0 ){
		$arrma_hr = array('0');}



		$this->db->select('stu_user.*,Applyed_Cources.*,new_preview_pg.*,sub_preview_pg.*');
		$this->db->from('Applyed_Cources');
		$this->db->join('stu_user', 'Applyed_Cources.user_id=stu_user.u_id','right');
		$this->db->join('new_preview_pg', 'Applyed_Cources.user_id=new_preview_pg.pr_user_id','right');
		$this->db->join('sub_preview_pg', 'Applyed_Cources.user_id=sub_preview_pg.sb_u_id','right');
		$this->db->where('Applyed_Cources.applied_course_id',5);
		$this->db->where_in("Applyed_Cources.user_id",$arrma_hr);
		$st =	$this->db->get();
	
		$data['ma_hrm'] = $st->num_rows();
//-----------------------------------------------------------//
		$ma_hrod=$this->db->select("user_id")->from("Applyed_Cources")->where("main_course_id",1)->where("applied_course_id",6)->get();
		$applied_ma_hrod =$ma_hrod->result_array();
		$arrma_hrod = array_column($applied_ma_hrod, "user_id");
		if( sizeof($arrma_hrod) == 0 ){
		$arrma_hrod = array('0');}



		$this->db->select('stu_user.*,Applyed_Cources.*,new_preview_pg.*,sub_preview_pg.*');
		$this->db->from('Applyed_Cources');
		$this->db->join('stu_user', 'Applyed_Cources.user_id=stu_user.u_id','right');
		$this->db->join('new_preview_pg', 'Applyed_Cources.user_id=new_preview_pg.pr_user_id','right');
		$this->db->join('sub_preview_pg', 'Applyed_Cources.user_id=sub_preview_pg.sb_u_id','right');
		$this->db->where('Applyed_Cources.applied_course_id',6);
		$this->db->where_in("Applyed_Cources.user_id",$arrma_hrod );
		$st_od =	$this->db->get();
	
		$data['ma_hr_od'] = $st_od->num_rows();

//-----------------------------------------------------------//


$ma_se=$this->db->select("user_id")->from("Applyed_Cources")->where("main_course_id",1)->where("applied_course_id",7)->get();
		$applied_ma_se =$ma_se->result_array();
		$arrma_se = array_column($applied_ma_se, "user_id");
		if( sizeof($arrma_se) == 0 ){
		$arrma_se = array('0');}



		$this->db->select('stu_user.*,Applyed_Cources.*,new_preview_pg.*,sub_preview_pg.*');
		$this->db->from('Applyed_Cources');
		$this->db->join('stu_user', 'Applyed_Cources.user_id=stu_user.u_id','right');
		$this->db->join('new_preview_pg', 'Applyed_Cources.user_id=new_preview_pg.pr_user_id','right');
		$this->db->join('sub_preview_pg', 'Applyed_Cources.user_id=sub_preview_pg.sb_u_id','right');
		$this->db->where('Applyed_Cources.applied_course_id',7);
		$this->db->where_in("Applyed_Cources.user_id",$arrma_se );
		$st_se =	$this->db->get();
	
		$data['ma_hr_se'] = $st_se->num_rows();

//-----------------------------------------------------------//


$ma_dm=$this->db->select("user_id")->from("Applyed_Cources")->where("main_course_id",1)->where("applied_course_id",8)->get();
		$applied_ma_dm =$ma_dm->result_array();
		$arrma_dm = array_column($applied_ma_dm, "user_id");
		if( sizeof($arrma_dm) == 0 ){
		$arrma_dm = array('0');}



		$this->db->select('stu_user.*,Applyed_Cources.*,new_preview_pg.*,sub_preview_pg.*');
		$this->db->from('Applyed_Cources');
		$this->db->join('stu_user', 'Applyed_Cources.user_id=stu_user.u_id','right');
		$this->db->join('new_preview_pg', 'Applyed_Cources.user_id=new_preview_pg.pr_user_id','right');
		$this->db->join('sub_preview_pg', 'Applyed_Cources.user_id=sub_preview_pg.sb_u_id','right');
		$this->db->where('Applyed_Cources.applied_course_id',8);
		$this->db->where_in("Applyed_Cources.user_id",$arrma_dm );
		$st_dm =	$this->db->get();
	
		$data['ma_hr_dm'] = $st_dm->num_rows();
		
		
		//-----------------------------------------------------------//


$ma_phy=$this->db->select("user_id")->from("Applyed_Cources")->where("main_course_id",1)->where("applied_course_id",9)->get();
		$applied_ma_phy =$ma_phy->result_array();
		$arrma_phy = array_column($applied_ma_phy, "user_id");
		if( sizeof($arrma_phy) == 0 ){
		$arrma_phy = array('0');}



		$this->db->select('stu_user.*,Applyed_Cources.*,new_preview_pg.*,sub_preview_pg.*');
		$this->db->from('Applyed_Cources');
		$this->db->join('stu_user', 'Applyed_Cources.user_id=stu_user.u_id','right');
		$this->db->join('new_preview_pg', 'Applyed_Cources.user_id=new_preview_pg.pr_user_id','right');
		$this->db->join('sub_preview_pg', 'Applyed_Cources.user_id=sub_preview_pg.sb_u_id','right');
		$this->db->where('Applyed_Cources.applied_course_id',9);
		$this->db->where_in("Applyed_Cources.user_id",$arrma_phy );
		$st_phy =	$this->db->get();
	
		$data['ma_hr_phy'] = $st_phy->num_rows();

		//-----------------------------------------------------------//


		$ma_de = $this->db->select("user_id")->from("Applyed_Cources")->where("main_course_id",1)->where("applied_course_id",15)->get();
		$applied_ma_ma_de =$ma_de->result_array();
		$arrma_de = array_column($applied_ma_ma_de, "user_id");
		if( sizeof($arrma_de) == 0 ){
		$arrma_de = array('0');}



		$this->db->select('stu_user.*,Applyed_Cources.*,new_preview_pg.*,sub_preview_pg.*');
		$this->db->from('Applyed_Cources');
		$this->db->join('stu_user', 'Applyed_Cources.user_id=stu_user.u_id','right');
		$this->db->join('new_preview_pg', 'Applyed_Cources.user_id=new_preview_pg.pr_user_id','right');
		$this->db->join('sub_preview_pg', 'Applyed_Cources.user_id=sub_preview_pg.sb_u_id','right');
		$this->db->where('Applyed_Cources.applied_course_id',15);
		$this->db->where_in("Applyed_Cources.user_id",$arrma_de );
		$st_de =	$this->db->get();
	
		$data['ma_de'] = $st_de->num_rows();


	//-----------------------------------------------------------//


	$msw_aided =$this->db->select("user_id")->from("Applyed_Cources")->where("main_course_id ",2)->get();




    $applied_msw =$msw_aided->result_array();

    $arr_msw_aid = array_column($applied_msw, "user_id");
    

	$this->db->select('stu_user.*,Applyed_Cources.*,new_preview_pg.*,sub_preview_pg.*');
	$this->db->from('Applyed_Cources');
	$this->db->join('stu_user', 'Applyed_Cources.user_id=stu_user.u_id','right');
	$this->db->join('new_preview_pg', 'Applyed_Cources.user_id=new_preview_pg.pr_user_id','right');
	$this->db->join('sub_preview_pg', 'Applyed_Cources.user_id=sub_preview_pg.sb_u_id','right');
	//$this->db->join('online_exam_pannel', 'Applyed_Cources.user_id=online_exam_pannel.student_id','right');
 //   $this->db->join('student_complete_mark', 'stu_user.u_id=student_complete_mark.stu_id','left');
	$this->db->where('Applyed_Cources.main_course_id',2);
//	$this->db->where('online_exam_pannel.exam_category',$this->Subject);
	//$this->db->where('student_complete_mark.exam_name',$this->Subject);
	$this->db->where_in("Applyed_Cources.user_id",$arr_msw_aid);
	$st_msw_aid =	$this->db->get();

	$data['msw_aided'] = $st_msw_aid->num_rows();



	//-----------------------------------------------------------//


	$msw_self_fin =$this->db->select("user_id")->from("Applyed_Cources")->where("main_course_id ",3)->get();




    $self_fin =$msw_self_fin->result_array();

    $arr_msw_self = array_column($self_fin, "user_id");
    

	$this->db->select('stu_user.*,Applyed_Cources.*,new_preview_pg.*,sub_preview_pg.*');
	$this->db->from('Applyed_Cources');
	$this->db->join('stu_user', 'Applyed_Cources.user_id=stu_user.u_id','right');
	$this->db->join('new_preview_pg', 'Applyed_Cources.user_id=new_preview_pg.pr_user_id','right');
	$this->db->join('sub_preview_pg', 'Applyed_Cources.user_id=sub_preview_pg.sb_u_id','right');
	//$this->db->join('online_exam_pannel', 'Applyed_Cources.user_id=online_exam_pannel.student_id','right');
 //   $this->db->join('student_complete_mark', 'stu_user.u_id=student_complete_mark.stu_id','left');
	$this->db->where('Applyed_Cources.main_course_id',3);
//	$this->db->where('online_exam_pannel.exam_category',$this->Subject);
	//$this->db->where('student_complete_mark.exam_name',$this->Subject);
	$this->db->where_in("Applyed_Cources.user_id",$arr_msw_self);
	$st_msw_self =	$this->db->get();

	$data['msw_self_fin'] = $st_msw_self->num_rows();


	$this->load->view('template/admin/header');
    $this->load->view('template/admin/menubar');
    $this->load->view('template/admin/headerbar');
    $this->load->view('admin/student_applied');
    $this->load->view('template/admin/footer');





	}

public function StudentAppliedCources(){


$main_cour_id = $this->uri->segment(3);
$app_cour_id = $this->uri->segment(4);









$ma_dm=$this->db->select("user_id")->from("Applyed_Cources")->where("main_course_id",$main_cour_id)->where("applied_course_id",$app_cour_id)->get();
		$applied_ma_dm =$ma_dm->result_array();
		$arrma_dm = array_column($applied_ma_dm, "user_id");
		if( sizeof($arrma_dm) == 0 ){
		$arrma_dm = array('0');}



		$this->db->select('stu_user.*,Applyed_Cources.*,new_preview_pg.*,sub_preview_pg.*,student_complete_mark.personal_mark');
		$this->db->from('Applyed_Cources');
		$this->db->join('stu_user', 'Applyed_Cources.user_id=stu_user.u_id','right');
		$this->db->join('new_preview_pg', 'Applyed_Cources.user_id=new_preview_pg.pr_user_id','right');
		$this->db->join('sub_preview_pg', 'Applyed_Cources.user_id=sub_preview_pg.sb_u_id','right');
		$this->db->join('student_complete_mark', 'Applyed_Cources.main_course_id=student_complete_mark.main_course_id and Applyed_Cources.applied_course_id=student_complete_mark.app_course_id and Applyed_Cources.user_id=student_complete_mark.stu_id','left');
		$this->db->where('Applyed_Cources.applied_course_id',$app_cour_id);
		$this->db->where_in("Applyed_Cources.user_id",$arrma_dm );
		$st_dm =	$this->db->get();
	
		$data['applied'] = $st_dm->result();
		$data['course'] = 2;

	

		switch ($app_cour_id) {

		    case "5":
		$data['subject']='MAHRM';
		$data['department']='M.A. Human Resource Management (SF)';
			break;
		    case "6":
				$data['subject']='MAHRM';
				$data['department']='M.A. Human Resource And Organization Development (SF)';
			break;
		    case "7":
				$data['subject']='MASE';
				$data['department']='M.A. Social Entrepreneurship (SF)';
			break;
			case "8":
				$data['subject']='MADM';
				$data['department']='M.A. Development Management (SF)';
			break;
			case "9":
				$data['subject']='MSCCF';
				$data['department']='M.Sc. Counselling Psychology (SF)';
			break;
			case "15":
				$data['subject']='MSW';
				$data['department']='M.S.W. Disability and Empowerment (SF)';
			break;

		  default:
		  $data['subject']='MSW';
		  $data['department']='';
		}


		$this->load->view('template/admin/header');
		$this->load->view('template/admin/menubar');
		$this->load->view('template/admin/headerbar');
		$this->load->view('admin/student_applied',$data);
		$this->load->view('template/admin/footer');
	
}

public function StudentAppliedMswAidedCources(){


	$main_cour_id = $this->uri->segment(3);
	$app_cour_id = $this->uri->segment(4);
	
	
	
	
	
	
	
	
	
	$ma_dm=$this->db->select("user_id")->from("Applyed_Cources")->where("main_course_id",$main_cour_id)->where("applied_course_id",$app_cour_id)->get();
			$applied_ma_dm =$ma_dm->result_array();
			$arrma_dm = array_column($applied_ma_dm, "user_id");
			if( sizeof($arrma_dm) == 0 ){
			$arrma_dm = array('0');}
	
	
	
			$this->db->select('stu_user.*,Applyed_Cources.*,new_preview_pg.*,sub_preview_pg.*,student_complete_mark.personal_mark');
			$this->db->from('Applyed_Cources');
			$this->db->join('stu_user', 'Applyed_Cources.user_id=stu_user.u_id','right');
			$this->db->join('new_preview_pg', 'Applyed_Cources.user_id=new_preview_pg.pr_user_id','right');
			$this->db->join('sub_preview_pg', 'Applyed_Cources.user_id=sub_preview_pg.sb_u_id','right');
			$this->db->join('student_complete_mark', 'Applyed_Cources.main_course_id=student_complete_mark.main_course_id and Applyed_Cources.applied_course_id=student_complete_mark.app_course_id and Applyed_Cources.user_id=student_complete_mark.stu_id','left');
			$this->db->where('Applyed_Cources.main_course_id',$main_cour_id);
			$this->db->where('Applyed_Cources.applied_course_id',$app_cour_id);
			$this->db->where_in("Applyed_Cources.user_id",$arrma_dm );
			$st_dm =	$this->db->get();
		
			$data['applied'] = $st_dm->result();
			$data['course'] = 2;
	
		
	
			switch ($app_cour_id) {
	
				case "1":
			$data['subject']='MSW';
			$data['department']='MSW Community Development';
				break;
				case "2":
					$data['subject']='MSW';
					$data['department']='MSW Medical & Psychiatric Social Work';
				break;
				case "3":
					$data['subject']='MSW';
					$data['department']='MSW Human Resource Management';
				break;
			
	
			  default:
			  $data['subject']='MSW';
			  $data['department']='';
			}
	
	
			$this->load->view('template/admin/header');
			$this->load->view('template/admin/menubar');
			$this->load->view('template/admin/headerbar');
			$this->load->view('admin/student_applied',$data);
			$this->load->view('template/admin/footer');
		
	}

	public function StudentAppliedMswSelfFinanceCources(){


		$main_cour_id = $this->uri->segment(3);
		$app_cour_id = $this->uri->segment(4);
		
		
		
		
		
		
		
		
		
		$ma_dm=$this->db->select("user_id")->from("Applyed_Cources")->where("main_course_id",$main_cour_id)->where("applied_course_id",$app_cour_id)->get();
				$applied_ma_dm =$ma_dm->result_array();
				$arrma_dm = array_column($applied_ma_dm, "user_id");
				if( sizeof($arrma_dm) == 0 ){
				$arrma_dm = array('0');}
		
		
		
				$this->db->select('stu_user.*,Applyed_Cources.*,new_preview_pg.*,sub_preview_pg.*,student_complete_mark.personal_mark');
				$this->db->from('Applyed_Cources');
				$this->db->join('stu_user', 'Applyed_Cources.user_id=stu_user.u_id','right');
				$this->db->join('new_preview_pg', 'Applyed_Cources.user_id=new_preview_pg.pr_user_id','right');
				$this->db->join('sub_preview_pg', 'Applyed_Cources.user_id=sub_preview_pg.sb_u_id','right');
				$this->db->join('student_complete_mark', 'Applyed_Cources.main_course_id=student_complete_mark.main_course_id and Applyed_Cources.applied_course_id=student_complete_mark.app_course_id and Applyed_Cources.user_id=student_complete_mark.stu_id','left');
				$this->db->where('Applyed_Cources.main_course_id',$main_cour_id);
				$this->db->where('Applyed_Cources.applied_course_id',$app_cour_id);
				$this->db->where_in("Applyed_Cources.user_id",$arrma_dm );
				$st_dm =	$this->db->get();
			
				$data['applied'] = $st_dm->result();
				$data['course'] = 2;
		
			
		
				switch ($app_cour_id) {
		
					case "1":
				$data['subject']='MSW';
				$data['department']='MSW Community Development';
					break;
					case "2":
						$data['subject']='MSW';
						$data['department']='MSW Medical & Psychiatric Social Work';
					break;
					case "3":
						$data['subject']='MSW';
						$data['department']='MSW Human Resource Management';
					break;
				
		
				  default:
				  $data['subject']='MSW';
				  $data['department']='';
				}
		
		
				$this->load->view('template/admin/header');
				$this->load->view('template/admin/menubar');
				$this->load->view('template/admin/headerbar');
				$this->load->view('admin/student_applied',$data);
				$this->load->view('template/admin/footer');
			
		}
		
		public function StudentAppliedUgCources(){


		$main_cour_id = $this->uri->segment(3);
		$app_cour_id = $this->uri->segment(4);
		
		
		
		
		
		
		
		
		
		$ma_dm=$this->db->select("user_id")->from("Applyed_Cources")->where("main_course_id",$main_cour_id)->where("applied_course_id",$app_cour_id)->get();
				$applied_ma_dm =$ma_dm->result_array();
				$arrma_dm = array_column($applied_ma_dm, "user_id");
				if( sizeof($arrma_dm) == 0 ){
				$arrma_dm = array('0');}
		
		
		
				$this->db->select('stu_user.*,Applyed_Cources.*,new_preview.*,sub_preview.*,student_complete_mark.personal_mark');
				$this->db->from('Applyed_Cources');
				$this->db->join('stu_user', 'Applyed_Cources.user_id=stu_user.u_id','right');
				$this->db->join('new_preview', 'Applyed_Cources.user_id=new_preview.pr_user_id','right');
				$this->db->join('sub_preview', 'Applyed_Cources.user_id=sub_preview.sb_u_id','right');
				$this->db->join('student_complete_mark', 'Applyed_Cources.main_course_id=student_complete_mark.main_course_id and Applyed_Cources.applied_course_id=student_complete_mark.app_course_id and Applyed_Cources.user_id=student_complete_mark.stu_id','left');
				$this->db->where('Applyed_Cources.main_course_id',$main_cour_id);
				$this->db->where('Applyed_Cources.applied_course_id',$app_cour_id);
				$this->db->where_in("Applyed_Cources.user_id",$arrma_dm );
				$st_dm =	$this->db->get();
			
				$data['applied'] = $st_dm->result();
				$data['course'] = 1;
		
			
		
				switch ($app_cour_id) {
		
					case "1":
				$data['subject']='MSW';
				$data['department']='B.S.W (SF)';
					break;
					case "2":
						$data['subject']='MSW';
						$data['department']='B.Sc Psychology (SF)';
					break;
				
		
				  default:
				  $data['subject']='MSW';
				  $data['department']='';
				}
		
		
				$this->load->view('template/admin/header');
				$this->load->view('template/admin/menubar');
				$this->load->view('template/admin/headerbar');
				$this->load->view('admin/student_applied',$data);
				$this->load->view('template/admin/footer');
			
		}
		
		public function StudentAppliedPgDiplomaCources(){


		$main_cour_id = $this->uri->segment(3);
		$app_cour_id = $this->uri->segment(4);
		
		
		
		
		
		
		
		
		
		$ma_dm=$this->db->select("user_id")->from("Applyed_Cources")->where("main_course_id",$main_cour_id)->where("applied_course_id",$app_cour_id)->get();
				$applied_ma_dm =$ma_dm->result_array();
				$arrma_dm = array_column($applied_ma_dm, "user_id");
				if( sizeof($arrma_dm) == 0 ){
				$arrma_dm = array('0');}
		
		
		
				$this->db->select('stu_user.*,Applyed_Cources.*,new_preview_dip.*,sub_preview_dip.*,student_complete_mark.personal_mark');
				$this->db->from('Applyed_Cources');
				$this->db->join('stu_user', 'Applyed_Cources.user_id=stu_user.u_id','right');
				$this->db->join('new_preview_dip', 'Applyed_Cources.user_id=new_preview_dip.pr_user_id','right');
				$this->db->join('sub_preview_dip', 'Applyed_Cources.user_id=sub_preview_dip.sb_u_id','right');
				$this->db->join('student_complete_mark', 'Applyed_Cources.main_course_id=student_complete_mark.main_course_id and Applyed_Cources.applied_course_id=student_complete_mark.app_course_id and Applyed_Cources.user_id=student_complete_mark.stu_id','left');
				$this->db->where('Applyed_Cources.main_course_id',$main_cour_id);
				$this->db->where('Applyed_Cources.applied_course_id',$app_cour_id);
				$this->db->where_in("Applyed_Cources.user_id",$arrma_dm );
				$st_dm =	$this->db->get();
			
				$data['applied'] = $st_dm->result();
				$data['course'] = 3;
		
			
		
				switch ($app_cour_id) {
		
					case "10":
				$data['subject']='MSW';
				$data['department']='Personnel Management & Industrial Relations (SF)';
					break;
					case "11":
						$data['subject']='MSW';
						$data['department']='Human Resource Management (SF)';
					break;
				
		
				  default:
				  $data['subject']='MSW';
				  $data['department']='';
				}
		
		
				$this->load->view('template/admin/header');
				$this->load->view('template/admin/menubar');
				$this->load->view('template/admin/headerbar');
				$this->load->view('admin/student_applied',$data);
				$this->load->view('template/admin/footer');
			
		}
	
public function viewStudent(){


	$user_id = $this->uri->segment(3);
	$m_course = '2';
  
  
	$pr_user = $this->db->select('*')->from('new_preview_pg')->where('pr_user_id',$user_id)->get();
	$pr_study = $this->db->select('*')->from('sub_preview_pg')->where('sb_u_id',$user_id)->get();
  
	$q = $this->db->select('*')->from('college_course')->get();
	$pr_study_app = $this->db->select('*')->from('Applyed_Cources')->where('user_id',$user_id)->where('main_course_id',2)->get();
	  
	$data['cdetails'] = $pr_study_app->result();
  
	$data['cc'] = $q->result();
  
	$data['user'] = $pr_user->result();
	$data['Study'] = $pr_study->result();
  
  
	$this->load->view('template/admin/header');
	$this->load->view('template/admin/menubar');
	$this->load->view('template/admin/headerbar');
	$this->load->view('studentdetails/preview_pg',$data);
	$this->load->view('template/admin/footer'); 
  
  
  
  }
  public function studentCertificate(){


	$user_id =$this->uri->segment(3);


	$pr_user = $this->db->select('*')->from('new_preview_pg')->where('pr_user_id',$user_id)->get();
	
	
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

$this->load->view('template/admin/header');
  $this->load->view('template/admin/menubar');
  $this->load->view('template/admin/headerbar');
  $this->load->view('admin/certificates',$data);
  $this->load->view('template/admin/footer'); 




}
  public function applicationFeesCollected(){


		$mahrm = 0; 
		$mahrmod = 0; 
		$mase = 0; 
		$madm = 0; 
		$msccp = 0; 
		$mswde = 0; 



			$m = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",1)->where("applied_course_id",5)->get();
			$mahrm = $m->num_rows();

			$mod = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",1)->where("applied_course_id",6)->get();
			$mahrmod = $mod->num_rows();

			$mse = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",1)->where("applied_course_id",7)->get();
			$mase = $mse->num_rows();

			$mdm = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",1)->where("applied_course_id",8)->get();
			$madm = $mdm->num_rows();

			$mscc = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",1)->where("applied_course_id",9)->get();
			$msccp = $mscc->num_rows();

			$mde = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",1)->where("applied_course_id",15)->get();
			$mswde = $mde->num_rows();


		$data['mahrm'] = $mahrm * 500;
		$data['mahrmod'] = $mahrmod * 500;
		$data['mase'] = $mase * 500;
		$data['madm'] = $madm * 500;
		$data['msccp'] = $msccp * 500;
		$data['mswde'] = $mswde * 500;


$mswaidcm=0;
$mswaidmedphy=0;
$mswaidhrm=0;


$rsmswaidcm  =0;
$rsmswaidmedphy=0;
$rsmswaidhrm=0;


$mswselfcm=0;
$mswselfmedphy=0;
$mswselfhrm=0;


$rsmswselfcm  =0;
$rsmswselfmedphy=0;
$rsmswselfhrm=0;


		$q = $this->db->select("*")->from("Applyed_Master")->where("main_course_priority","PG")->get();


		$s = $q->result();



foreach ($s as $key => $value) {


	$m = $this->db->select("*")->from("Applyed_Cources")->where("master_id",$value->id)->get();
$ran = $m->result();



	$myArray = explode(',', $value->pg_mssw_aided);
	//print_r($myArray);
foreach ($myArray as $kes =>  $valuee) {
	if ( $valuee == 1)
	{
		 $mswaidcm += 1; 

if($kes == 0){

$rsmswaidcm  += 500;

}elseif($kes == 1){


	$rsmswaidcm  += 50;

}
elseif($kes == 2){


	$rsmswaidcm  += 50;

}



	}else if( $valuee ==2 ){

		$mswaidmedphy += 1;


		if($kes == 0){

			$rsmswaidmedphy  += 500;
			
			}elseif($kes == 1){
			
			
				$rsmswaidmedphy  += 50;
			
			}
			elseif($kes == 2){
			
			
				$rsmswaidmedphy  += 50;
			
			}




	}else if( $valuee ==3 ){

		$mswaidhrm += 1;


		if($kes == 0){

			$rsmswaidhrm  += 500;
			
			}elseif($kes == 1){
			
			
				$rsmswaidhrm  += 50;
			
			}
			elseif($kes == 2){
			
			
				$rsmswaidhrm  += 50;
			
			}




	}
	
}



$myArraySelf = explode(',', $value->pg_mssw_self);



foreach ($myArraySelf as $kes =>  $valuee) {
	if ( $valuee == 1)
	{
		 $mswselfcm += 1; 

if($kes == 0){

$rsmswselfcm  += 500;

}elseif($kes == 1){


	$rsmswselfcm  += 50;

}
elseif($kes == 2){


	$rsmswselfcm  += 50;

}



	}else if( $valuee ==2 ){

		$mswselfmedphy += 1;


		if($kes == 0){

			$rsmswselfmedphy  += 500;
			
			}elseif($kes == 1){
			
			
				$rsmswselfmedphy  += 50;
			
			}
			elseif($kes == 2){
			
			
				$rsmswselfmedphy  += 50;
			
			}




	}else if( $valuee ==3 ){

		$mswselfhrm += 1;


		if($kes == 0){

			$rsmswselfhrm  += 500;
			
			}elseif($kes == 1){
			
			
				$rsmswselfhrm  += 50;
			
			}
			elseif($kes == 2){
			
			
				$rsmswselfhrm  += 50;
			
			}




	}
	
}


}




$data['msw_aid_cm'] = $rsmswaidcm;
$data['msw_aid_mepy'] = $rsmswaidmedphy;
$data['msw_aid_hrm'] = $rsmswaidhrm;
$data['msw_self_cm'] = $rsmswselfcm;
$data['msw_self_mepy'] = $rsmswselfmedphy;
$data['msw_self_hrm'] = $rsmswselfhrm;

$ugbsw = 0; 
		$ugbsc = 0; 
		$pgdipir = 0; 
		$pgdiphr = 0; 



			$ug_bsw = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",5)->where("applied_course_id",1)->get();
			$ugbsw = $ug_bsw->num_rows();

			$ug_bsc = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",5)->where("applied_course_id",2)->get();
			$ugbsc = $ug_bsc->num_rows();

			$pg_dip_ir = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",4)->where("applied_course_id",10)->get();
			$pgdipir = $pg_dip_ir->num_rows();

			$pg_dip_hr = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",4)->where("applied_course_id",11)->get();
			$pgdiphr = $pg_dip_hr->num_rows();


		$data['ugbsw1'] = $ugbsw * 350;
		$data['ugbsc1'] = $ugbsc * 350;
		$data['pgdipir1'] = $pgdipir * 500;
		$data['pgdiphr1'] = $pgdiphr * 500;



$this->load->view('template/admin/header');
$this->load->view('template/admin/menubar');
$this->load->view('template/admin/headerbar');
$this->load->view('admin/applicationfeescollected',$data);
$this->load->view('template/admin/footer'); 


/* print_r($data); */



















  }



	public function CourseFeesCollected(){









$user = $this->db->select("pg_primary_course,pg_mssw_aided,pg_mssw_self")->from("Applyed_Master")->get();
$twst = $user->result();


/* echo"<pre>";
print_r($twst); */

$main_course = 0;
$main_msw = 0;
$msw_aid_rs =0;
$sum_msw_aid_rs =0;
$sum_msw_self_rs=0;
foreach($twst as $tnt){

	
if($tnt->pg_primary_course !=""){
	$myprimary = explode(',', $tnt->pg_primary_course);

	//sizeof($myprimary);
	//print_r($myprimary);
	echo"<br><br>";
	$main_course +=sizeof($myprimary);
echo"<br><br>";
}



if($tnt->pg_mssw_aided !=""){
	$main_msw = 0;
	$mswaided = explode(',', $tnt->pg_mssw_aided);
	echo"<br><br>";
	//echo sizeof($mswaided);
	print_r($mswaided);
	echo"<br><br>";
echo	$main_msw +=sizeof($mswaided);
echo"<br><br>";




switch ($main_msw) {
	case "1":
	 $msw_aid_rs = 500;
	  break;
	case "2":
		$msw_aid_rs = 550;
	  break;
	case "3":
		$msw_aid_rs = 600;
	  break;
	default:
	$msw_aid_rs = 0;
  }
  echo"<br><br>";
 echo $msw_aid_rs;
 $sum_msw_aid_rs +=  $msw_aid_rs;

echo"<br><br>";
}


if($tnt->pg_mssw_self !=""){
	$main_swlf = 0;
	$mswself = explode(',', $tnt->pg_mssw_self);
	echo"<br><br>";
	//echo sizeof($mswaided);
	print_r($mswself);
	echo"<br><br>";
echo	$main_swlf +=sizeof($mswaided);
echo"<br><br>";




switch ($main_swlf) {
	case "1":
	 $msw_slf_rs = 500;
	  break;
	case "2":
		$msw_slf_rs = 550;
	  break;
	case "3":
		$msw_slf_rs = 600;
	  break;
	default:
	$msw_slf_rs = 0;
  }
  echo"<br><br>";
 echo $msw_slf_rs;
 $sum_msw_self_rs +=  $msw_slf_rs;

echo"<br><br>";
}










 $total = $main_course *500;

}


echo $total;
echo"<br><br>";
echo $sum_msw_aid_rs;
echo"<br><br>";
echo  $sum_msw_self_rs;
	/* 	$this->load->view('template/admin/header');
		$this->load->view('template/admin/menubar');
		$this->load->view('template/admin/headerbar');
		$this->load->view('admin/fees_collected');
		$this->load->view('template/admin/footer');
 */




	}
 
    public function trustManage(){



         $this->db->select('*');
		$this->db->from('stu_user a'); 
		$this->db->join('college_course b', 'b.cs_id = a.u_course', 'left');
		$q = $this->db->get(); 
        $data['user'] = $q->result();


        $this->load->view('template/admin/header');
        $this->load->view('template/admin/menubar');
        $this->load->view('template/admin/headerbar');
        $this->load->view('admin/managetrust',$data);
        $this->load->view('template/admin/footer');




    }

public function userApplied(){


	$qd = $this->db->select('*')->from('stu_applied')
	->join('new_preview','stu_applied.sa_st_id = new_preview.pr_user_id')
	->join('college_course','new_preview.pr_course_1 = college_course.cs_id','left')
	->where('sa_interview_status',0)->get();

    $data['applied'] = $qd->result();

    $this->load->view('template/admin/header');
    $this->load->view('template/admin/menubar');
    $this->load->view('template/admin/headerbar');
    $this->load->view('admin/applieduser',$data);
    $this->load->view('template/admin/footer');

}


public function removeUser(){



$id = $this->input->post('id');




$array = array(
	'sa_interview_date'=>null,
	'sa_interview_time'=>null,
	'sa_interview_status'=>1,
	'sa_interview_attended_status'=>"Student Not intrested",
);



$this->db->where('sa_st_id',$id);
$q = $this->db->update('stu_applied',$array);



}


public function userFeesStatus(){

	$id = $this->input->post('id');
	$status = $this->input->post('status');
print_r($_POST);
$array = array(
	'sa_fees'=>$status,
);



$this->db->where('sa_st_id',$id);
$q = $this->db->update('stu_applied',$array);


}




public function downloadPdF(){

	

	

	

	$header = '<h2>Aavici college Application</h2>';





	$user_id = $this->uri->segment(3);

	$pr_user = $this->db->select('*')->from('new_preview')->where('pr_user_id',$user_id)->get();

	$pr_study = $this->db->select('*')->from('sub_preview')->where('sb_u_id',$user_id)->get();



	$q = $this->db->select('*')->from('college_course')->get();



	$cc = $q->result();

	$user = $pr_user->result();

	$Study = $pr_study->result();



			$cour_1 = $this->db->select("*")->from("college_course")->where("cs_id",$user[0]->pr_course_1)->get();

			$cour_2 = $this->db->select("*")->from("college_course")->where("cs_id",$user[0]->pr_course_2)->get();

			$cour_3 = $this->db->select("*")->from("college_course")->where("cs_id",$user[0]->pr_course_3)->get();



			$valid_cor_1 = $cour_1->num_rows();

			$valid_cor_2 = $cour_2->num_rows();

			$valid_cor_3 = $cour_3->num_rows();


			$r_cor_1 = $cour_1->result();

				$r_cor_2 = $cour_2->result();

				$r_cor_3 = $cour_3->result();


if($valid_cor_1 > 0){


$course_na_1 = $r_cor_1[0]->cs_name;


}else{

	$course_na_1 = "Not Selected";


}



if($valid_cor_2 > 0){


	$course_na_2 = $r_cor_2[0]->cs_name;
	
	
	}else{
	
		$course_na_2 = "Not Selected";
	
	
	}
					

	if($valid_cor_3 > 0){


		$course_na_3 = $r_cor_3[0]->cs_name;
		
		
		}else{
		
			$course_na_3 = "Not Selected";
		
		
		}
		









$app = $this->db->select("*")->from("stu_applied")->where("sa_st_id",$user_id)->get();



$appli =$app->num_rows();


$reg = $this->db->select("*")->from("stu_user")->where("u_id",$user_id)->get();



$reg_user =$reg->result();








if($appli > 0){

	$applin =$app->result();



	$status = "<h3> ".$user[0]->pr_applicant_name."<br></br> Applied Sucessfully on ".date('d-m-Y',strtotime($applin[0]->sa_date))."</h3>";







	if($applin[0]->sa_interview_date == "" || $applin[0]->sa_interview_date==null){

	$status .= "<h3> Interview Date Not scheduled Yet </h3>";





	}else{



		$status .= "<h3> Interview Date ".date('d-m-Y',strtotime($applin[0]->sa_interview_date))." And Time ".date('h : i A',strtotime($applin[0]->sa_interview_time))." </h3>";



	}





}else{



	$status = "<h3> ".$user[0]->pr_applicant_name." Have Not Applied Yet ,Its a Preview </h3>";



}

$profile_image = 'uploads/'.$user[0]->pr_photo;
	
$pr_img = file_exists($profile_image);

if($pr_img == 1){

$image = '<img style="float:right" width="100px" src="'.$profile_image.'">';


}else{


	$image = "Photo not uploded";

}

	$this->pdf->loadHtml('

	<!DOCTYPE html>

	<html lang="en">

	  <head>

		<meta charset="utf-8">

		<title>Application Status Avichi College : '.$this->session->userdata('user')['user_name'].'</title>

		<link rel="stylesheet" href="style.css" media="all" />

	  </head>

	  <body style="margin:0px; padding:0px;">

		<header class="clearfix pdf-logo">

		<img src="'.base_url().'white-version/image/header.jpg" / width="300">						

		

		</header>

		

		<div class="main-status">

		<table class="tbl">

		<tr>

		<td style=" width="50%;" >

		'.$status.'</td>

		<td style="float:right; width="50%;" >'.$image.'</td>			

		</tr>

		</table>

		</div>

	

		

	

		

		<main>













		<h2 class="ttl"> Basic Details</h2>





		

		<table class="table" id="myTable">

			 
		<tr>

		<th>Name</th>

		<td>'.$user[0]->pr_applicant_name.'</td>

	</tr>
	<tr>

		<th>Mobile</th>

		<td>'.$reg_user[0]->u_mobile.'</td>

	</tr>
	<tr>

		<th>Email</th>

		<td>'.$reg_user[0]->u_email_id.'</td>

	</tr>
				   
	
				

		<tr>

			<th>Preferred First Course</th>

			<td>'.$course_na_1.'</td>

		</tr>

		<tr>

			<th>Preferred Second Course</th>

			<td>'.$course_na_2.'</td>

		</tr>

		<tr>

			<th>Preferred Third Course</th>

			<td>'.$course_na_3.'</td>

		</tr>

		<tr>

			<th>Language</th>

			<td>'.$user[0]->pr_language.'</td>

		</tr>

		<tr>

			<th>Date of Birth</th>

			<td>'.date('d-M-Y',strtotime($user[0]->pr_dob)).'</td>

		</tr>

		<tr>

			<th>Age</th>

			<td>'.$user[0]->pr_age.'</td>

		</tr>

		<tr>

			<th>Gender</th>

			<td>'.$user[0]->pr_gender.'</td>

		</tr>

		<tr>

			<th>Nationality</th>

			<td>'.$user[0]->pr_nationality.'</td>

		</tr> 

		<tr>

			<th>Religion</th>

			<td>'.$user[0]->pr_religion.'</td>

		</tr>  <tr>

			<th>Caste</th>

			<td>'.$user[0]->pr_caste.'</td>

		</tr>  <tr>

			<th>Community</th>

			<td>'.$user[0]->pr_community.'</td>

		</tr>  

	</table>

	

	<h2 class="ttl">Parents / Guardians Details</h2>

	<table class="table" id="myTable">

	<tr>

<th>#</th>

<th>Father</th>

<th>Mother</th>

<th>Guardian</th>



<tr>

<th>Name</th>

<td>'.$user[0]->pr_father_name.'</td>

<td>'.$user[0]->pr_mother_name.'</td>

<td>'.$user[0]->pr_gaurdion_name.'</td>



</tr>

<tr>

<th>Mobile No.</th>

<td>'.$user[0]->pr_father_mobnum.'</td>

<td>'.$user[0]->pr_mother_mobnum.'</td>

<td>'.$user[0]->pr_gaurdion_mobnum.'</td>





</tr>

<tr>

<th>Occupation</th>

<td>'.$user[0]->pr_father_accu.'</td>

<td>'.$user[0]->pr_mother_accu.'</td>

<td>'.$user[0]->pr_gaurdion_accu.'</td>





</tr>

<tr>

<th>Annual

Income</th>

<td>'.$user[0]->pr_father_anuval_income.'</td>

<td>'.$user[0]->pr_mother_anuval_income.'</td>

<td>'.$user[0]->pr_gaurdion_anuval_income.'</td>





</tr>   



	</table>



	<h2 class="ttl">Address</h2>

	<table class="table" id="myTable">

	<tr>

<th>#</th>

<th>Local Address</th>

<th>Permanant</th>





<tr>

<th>Address</th>

<td>'.$user[0]->pr_local_address.'</td>

<td>'.$user[0]->pr_permanent_address.'</td>





</tr>

<tr>

<th>Area</th>

<td>'.$user[0]->pr_local_area.'</td>

<td>'.$user[0]->pr_permanent_area.'</td>







</tr>

<tr>

<th>City</th>

<td>'.$user[0]->pr_local_city.'</td>

<td>'.$user[0]->pr_permanent_city.'</td>



</tr>

<tr>

<th>State</th>

<td>'.$user[0]->pr_local_state.'</td>

<td>'.$user[0]->pr_permanent_state.'</td>







</tr>    

<tr>

<th>Country</th>

<td>'.$user[0]->pr_local_country.'</td>

<td>'.$user[0]->pr_permanent_country.'</td>





</tr>   

<tr>

<th>Pincode</th>

<td>'.$user[0]->pr_local_pincode.'</td>

<td>'.$user[0]->pr_permanent_pincode.'</td>



</tr>   



	</table>

  

	<h2 class="ttl">Identification Marks</h2>

	<table class="table" id="myTable">

	 

		   

		

	

	 <tr>

		 <th>1</th>

		 <td>'.$user[0]->pr_identification_one.'</td>

	 </tr>

	 <tr>

		 <th>2</th>

		 <td>'.$user[0]->pr_identification_two.'</td>

	 </tr>

   

	

 </table>
 <h2 class="ttl">Differently Abled</h2>
 <table class="table" id="myTable">

	 

 <tr>

	 <th>'.$user[0]->pr_differently_abled.'</th>

	 <td>'.$user[0]->pr_differently_abled_reson.'</td>

 </tr>

 
</table>



		<h2 class="ttl">School / Institution last attended</h2>

		<table class="table" id="myTable">

		   <tr>

			 <th>Institution</th>

			 

			 <td>'.$user[0]->pr_institute_last_attanded.'</td>

		 </tr>

		 <tr>

			 <th>Institution Name</th>

			 <td>'.$user[0]->pr_insti_name.'</td>

		 </tr>

		 <tr>

			 <th>Medium of Instruction (in+2)</th>

			 <td>'.$user[0]->pr_medium_of_instruct.'</td>

		 </tr>

		 <tr>

			 <th>Month and Year of Passing</th>

			 <td>'.$user[0]->pr_month_year_pass.'</td>

		 </tr>

		 <tr>

			 <th>Stream</th>

			 <td>'.$user[0]->pr_Stream.'</td>

		 </tr>

		 <tr>

			 <th>Passed in FIRST attempt</th>

			 <td>'.$user[0]->pr_passed_in_first_attemt.'</td>

		 </tr>

		  <tr>

			 <th>Break in Studies</th>

			 <td>'.$user[0]->pr_break_in_syudy.'</td>

		 </tr>

		 <tr>

			 <th> Reason</th>

			 <td>'.$user[0]->pr_break_reason.'</td>

		 </tr> 

		  <tr>

			 <th>Language Studied in School</th>

			 <td>'.$user[0]->pr_languvage_studied.'</td>

		 </tr>

		 <tr>

			 <th>Sports Category : Name of the Game(s)</th>

			 <td>'.$user[0]->pr_name_of_game.'</td>

		 </tr>

		 <tr>

			 <th>Position</th>

			 <td>'.$user[0]->pr_game_position.'</td>

		 </tr>

		  <tr>

			 <th>Extra - Curricular Activities</th>

			 <td>'.$user[0]->pr_extra_caricular_act.'</td>

		 </tr>

		 </table>



		 <h2 class="ttl">Mark Details</h2>

		 <table class="mark" id="myTable">

		 <tr>

		<th>Subjects</th>

		<th colspan="4">Plus One</th>

		<th colspan="3">Plus Two</th>

		

		</tr>

	<tr>

		<th>#</th>

		<th >Max. Marks</th>

		<th>Marks Obtained</th>

		<th>Class / Grade</th>

		<th>Status</th>

		<th >Max. Marks</th>

		<th>Marks Obtained</th>

		<th>Class / Grade</th>

	</tr>

	<tr>

		<td>'.$Study[0]->lang_1.'</td>

		<td >'.$Study[0]->lang_1_max_mark_plus_1.'</td>

		<td>'.$Study[0]->lang_1_mark__obtained_plus_1.'</td>

		<td>'.$Study[0]->lang_1_class_grade_plus_1.'</td>

		<td>'.$Study[0]->lang_1_status.'</td>

		<td>'.$Study[0]->lang_1_max_mark_plus_2.'</td>

		

		<td>'.$Study[0]->lang_1_mark__obtained_plus_2.'</td>

	   

		<td>'.$Study[0]->lang_1_class_grade_plus_2.'</td>

	</tr>

	<tr>

	<td>'.$Study[0]->lang_2.'</td>

		<td >'.$Study[0]->lang_2_max_mark_plus_1.'</td>

		<td>'.$Study[0]->lang_2_mark__obtained_plus_1.'</td>

		<td>'.$Study[0]->lang_2_class_grade_plus_1.'</td>

		<td>'.$Study[0]->lang_2_status.'</td>

		<td>'.$Study[0]->lang_2_max_mark_plus_2.'</td>

		<td>'.$Study[0]->lang_2_mark__obtained_plus_2.'</td>

		 <td>'.$Study[0]->lang_2_class_grade_plus_2.'</td>

	</tr>

	<tr>

		<td>'.$Study[0]->subj_1.'</td>

		<td >'.$Study[0]->subj_1_max_mark_plus_1.'</td>

		<td>'.$Study[0]->subj_1_mark__obtained_plus_1.'</td>

		<td>'.$Study[0]->subj_1_class_grade_plus_1.'</td>

		<td>'.$Study[0]->subj_1_status.'</td>

		<td>'.$Study[0]->subj_1_max_mark_plus_2.'</td>

	   

		<td>'.$Study[0]->subj_1_mark__obtained_plus_2.'</td>

	   

		<td>'.$Study[0]->subj_1_class_grade_plus_2.'</td>

	</tr>

	<tr>

	<td>'.$Study[0]->subj_2.'</td>

		<td >'.$Study[0]->subj_2_max_mark_plus_1.'</td>

		<td>'.$Study[0]->subj_2_mark__obtained_plus_1.'</td>

		<td>'.$Study[0]->subj_2_class_grade_plus_1.'</td>

		<td>'.$Study[0]->subj_2_status.'</td>

		<td>'.$Study[0]->subj_2_max_mark_plus_2.'</td>

	   

		<td>'.$Study[0]->subj_2_mark__obtained_plus_2.'</td>

	   

		<td>'.$Study[0]->subj_2_class_grade_plus_2.'</td>

	</tr>

	<tr>

		<td>'.$Study[0]->subj_3.'</td>

		<td >'.$Study[0]->subj_3_max_mark_plus_1.'</td>

		<td>'.$Study[0]->subj_3_mark__obtained_plus_1.'</td>

		<td>'.$Study[0]->subj_3_class_grade_plus_1.'</td>

		<td>'.$Study[0]->subj_3_status.'</td>

		<td>'.$Study[0]->subj_3_max_mark_plus_2.'</td>

		<td>'.$Study[0]->subj_3_mark__obtained_plus_2.'</td>

		<td>'.$Study[0]->subj_3_class_grade_plus_2.'</td>

	</tr> 

	<tr>

	<td>'.$Study[0]->subj_4.'</td>

		<td >'.$Study[0]->subj_4_max_mark_plus_1.'</td>

		<td>'.$Study[0]->subj_4_mark__obtained_plus_1.'</td>

		<td>'.$Study[0]->subj_4_class_grade_plus_1.'</td>

		<td>'.$Study[0]->subj_4_status.'</td>

		<td>'.$Study[0]->subj_4_max_mark_plus_2.'</td>

		<td>'.$Study[0]->subj_4_mark__obtained_plus_2.'</td>

		<td>'.$Study[0]->subj_4_class_grade_plus_2.'</td>

	</tr>

	<tr>

		<td>'.$Study[0]->g_total.'</td>

		<td >'.$Study[0]->g_total_max_mark_plus_1.'</td>

		<td>'.$Study[0]->g_total_mark__obtained_plus_1.'</td>

		<td>'.$Study[0]->g_total_class_grade_plus_1.'</td>

		<td></td>

		<td>'.$Study[0]->g_total_max_mark_plus_2.'</td>

		 <td>'.$Study[0]->g_total_mark__obtained_plus_2.'</td>

		<td>'.$Study[0]->g_total_class_grade_plus_2.'</td>

	</tr>

	<tr>

		<td>'.$Study[0]->m_total.'</td>

		<td >'.$Study[0]->m_total_max_mark_plus_1.'</td>

		<td>'.$Study[0]->m_total_mark__obtained_plus_1.'</td>

		<td>'.$Study[0]->m_total_class_grade_plus_1.'</td>

		<td></td>

		<td>'.$Study[0]->m_total_max_mark_plus_2.'</td>

		<td>'.$Study[0]->m_total_mark__obtained_plus_2.'</td>

		<td>'.$Study[0]->m_total_class_grade_plus_2.'</td>

	</tr>

</table>



		 

		</main>


	  </body>

	</html>

	

	<style>

	table {

		border-collapse: collapse;

		border-spacing: 0;

		//width: 100%;

		border: 1px solid #ddd;

	  }

	  body {

			margin: 0 !important;

			padding: 0 !important;

		  font-family: Open Sans !important; 				

		}



	  th, td {

		text-align: left;

	  padding: 12px 25px;

	  }

	  .mark,th, td {

		text-align: left;

	  padding: 12px 10px;

	  }

	  .pdf-logo 

	  {

	  background: #2F2481;

	  text-align :center;

	  padding:10px 20px;

	  }

	  .ttl 

	   {

	  color:#e3000f;

	  font-size:18px;

	  text-transform:uppercase;	     

	 

	   }

	   tr:nth-child(even) {

background-color: #f2f2f2;

}

.tbl

{

border:0px !important;

width:100%;

}



#myTable

{

width:100%;

}

footer

{

color:#fff;

padding:30px;

Line-height:34px !important; 

}

h3

{

font-size:20px !important; 

}

	</style>

	

	

	

	

	');

	$this->pdf->render();

	$this->pdf->stream("DownloadApplication.pdf", array("Attachment"=>0));



}
public function viewApplicant($id= null){

$id = $this->uri->segment(3);
$qd = $this->db->select('*')->from('sub_preview')->join('new_preview','sub_preview.sb_u_id = new_preview.pr_user_id')->where('sub_preview.sb_u_id',$id)->get();

	$data['applied'] = $qd->result();
	
	$dnd = $this->db->select("*")->from("stu_user")->where("u_id",$id)->get();
	$data['user'] = $dnd->result();

    $this->load->view('template/admin/header');
    $this->load->view('template/admin/menubar');
    $this->load->view('template/admin/headerbar');
    $this->load->view('admin/viewapplicant',$data);
    $this->load->view('template/admin/footer');



}







public function editApplicant(){



    $id = $this->uri->segment(3);
   
    $q = $this->db->select('*')->from('college_course')->get();
	$pr_user = $this->db->select('*')->from('new_preview')->where('pr_user_id',$id)->get();
	$pr_study = $this->db->select('*')->from('sub_preview')->where('sb_u_id',$id)->get();


	$data['cc'] = $q->result();
	$data['user'] = $pr_user->result();
	$data['Study'] = $pr_study->result();
       // print_r($data);


        $this->load->view('template/admin/header');
        $this->load->view('template/admin/menubar');
        $this->load->view('template/admin/headerbar');
        $this->load->view('admin/editapplicant',$data);
        $this->load->view('template/admin/footer');
 
}


public function SaveApplication(){

	//$image_P=NULL;
	$image_P = $this->input->post('ppimage');
	$stu_certificate = $this->input->post('stu_certificate');


	$this->upload->initialize($this->do_upload());
	$hh =$this->upload->do_upload('profile-img');
	$dataInfo = $this->upload->data();
	

		if($hh){

		

			$filename =$dataInfo['file_name'];
		}else{
			if($image_P == null){
						$filename = null;
			}else{

				$filename = $image_P;

			}
		}
	///==================sslc=======================//
	$image_sslc = $this->input->post('stu_sslccert');
	$sslccert =$this->upload->do_upload('sslccert');
	$datasslccert = $this->upload->data();
	

		if($sslccert){

		

			$sslc =$datasslccert['file_name'];
		}else{
			if($image_sslc == null){
						$sslc = null;
			}else{

				$sslc = $image_sslc;

			}
		}

////=======================HSC FIRST=====================//
		$image_hs1 = $this->input->post('stu_hs_fir_certi');
		$hsc1 =$this->upload->do_upload('hs_fir_certi');
		$datahsc1 = $this->upload->data();
	

		if($hsc1){

		

			$certhsc1 =$datahsc1['file_name'];
		}else{
			if($image_hs1 == null){
						$certhsc1 = null;
			}else{

				$certhsc1 = $image_hs1;

			}
		}


////=======================HSC Second=====================//

$image_hs2 = $this->input->post('stu_hs_sec_certi');
$hsc2 =$this->upload->do_upload('hs_sec_certi');
$datahsc2 = $this->upload->data();


if($hsc2){



$certhsc2 =$datahsc2['file_name'];
}else{
if($image_hs2 == null){
			$certhsc2 = null;
}else{

	$certhsc2 = $image_hs2;

}
}





////=======================Comunity=====================//
		$image_cc = $this->input->post('stud_commcert');
		$ccc =$this->upload->do_upload('commcert');
		$dataInfod = $this->upload->data();
	

		if($ccc){

		

			$ccname =$dataInfod['file_name'];
		}else{
			if($image_cc == null){
						$ccname = null;
			}else{

				$ccname = $image_cc;

			}
		}

	
/* echo"<pre>";
print_r($dataInfo); */
//print_r($_POST);

//--------------------------------basic------------------//

$user_id = $this->input->post('user_id');

$candidate_name = $this->input->post('candidate_name');
$course_one = $this->input->post('course_one');
$course_two = $this->input->post('course_two');
$course_three = $this->input->post('course_three');
$language_offered = $this->input->post('language_offered');
$dob = $this->input->post('dob');
$age = $this->input->post('age');
$gender = $this->input->post('gender');
$Nationality = $this->input->post('Nationality');
$Religion = $this->input->post('Religion');
$Caste = $this->input->post('Caste');
$Community = $this->input->post('Community');
$father_name = $this->input->post('father_name');
$mother_name = $this->input->post('mother_name');
$guardion_name = $this->input->post('guardion_name');
$father_mob_num = $this->input->post('father_mob_num');
$mother_mob_num = $this->input->post('mother_mob_num');
$guardion_mob_num = $this->input->post('guardion_mob_num');
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




$update_details = array(
		'pr_applicant_name'=>$candidate_name,
		'pr_course_1'=>$course_one,
		'pr_course_2'=>$course_two,
		'pr_course_3'=>$course_three,
		'pr_language'=>$language_offered,
		'pr_dob'=>$dob,
		'pr_age'=>$age,
		'pr_gender'=>$gender,
		'pr_nationality'=>$Nationality,
		'pr_religion'=>$Religion,
		'pr_caste'=>$Caste,
		'pr_community'=>$Community,
		'pr_photo'=>$filename,
		'pr_father_name'=>$father_name,
		'pr_mother_name'=>$mother_name,
		'pr_gaurdion_name'=>$guardion_name,
		'pr_father_mobnum'=>$father_mob_num,
		'pr_mother_mobnum'=>$mother_mob_num,
		'pr_gaurdion_mobnum'=>$guardion_mob_num,
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
		'pr_sslc_mark'=>$sslc,
		'pr_hse_certificate'=>$certhsc1,
		'pr_hse2_certificate'=>$certhsc2,
		'pr_comunity_cert'=>$ccname,
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

//

		
		'pr_Stream'=>$stream,
		'pr_passed_in_first_attemt'=>$pass_in_first_att,
		'pr_languvage_studied'=>$lang_studied,
		'pr_others_lang'=>$lang_others,
		'pr_name_of_game'=>$sports_name,
		'pr_game_position'=>$sports_psition,
		'pr_extra_caricular_act'=>$extra_caricular_activities,
		'pr_acknoledge'=>$acknoledgement,
);


$this->db->where('pr_user_id',$user_id);
$this->db->update('new_preview',$update_details);

//Markdheet details
//$candidate_name = $this->input->post('candidate_name');







$result_lang_one  = $this->input->post('result_lang_one');
$result_lang_two  = $this->input->post('result_lang_two');
$result_sub_1  = $this->input->post('result_sub_1');
$result_sub_2  = $this->input->post('result_sub_2');
$result_sub_3  = $this->input->post('result_sub_3');
$result_sub_4  = $this->input->post('result_sub_4');





$lang_1  = $this->input->post('lang_1');
$lang_1_max_mark_plus_1  = $this->input->post('lang_1_max_mark_plus_1');
$lang_1_max_mark_plus_2  = $this->input->post('lang_1_max_mark_plus_2');
$lang_1_mark__obtained_plus_1  = $this->input->post('lang_1_mark__obtained_plus_1');
$lang_1_mark__obtained_plus_2  = $this->input->post('lang_1_mark__obtained_plus_2');
$lang_1_class_grade_plus_1  = $this->input->post('lang_1_class_grade_plus_1');
$lang_1_class_grade_plus_2  = $this->input->post('lang_1_class_grade_plus_2');



$lang_2  = $this->input->post('lang_2');
$lang_2_max_mark_plus_1  = $this->input->post('lang_2_max_mark_plus_1');
$lang_2_max_mark_plus_2  = $this->input->post('lang_2_max_mark_plus_2');
$lang_2_mark__obtained_plus_1  = $this->input->post('lang_2_mark__obtained_plus_1');
$lang_2_mark__obtained_plus_2  = $this->input->post('lang_2_mark__obtained_plus_2');
$lang_2_class_grade_plus_1  = $this->input->post('lang_2_class_grade_plus_1');
$lang_2_class_grade_plus_2  = $this->input->post('lang_2_class_grade_plus_2');

$subj_1  = $this->input->post('subj_1');
$subj_1_max_mark_plus_1  = $this->input->post('subj_1_max_mark_plus_1');
$subj_1_max_mark_plus_2  = $this->input->post('subj_1_max_mark_plus_2');
$subj_1_mark__obtained_plus_1  = $this->input->post('subj_1_mark__obtained_plus_1');
$subj_1_mark__obtained_plus_2  = $this->input->post('subj_1_mark__obtained_plus_2');
$subj_1_class_grade_plus_1  = $this->input->post('subj_1_class_grade_plus_1');
$subj_1_class_grade_plus_2  = $this->input->post('subj_1_class_grade_plus_2');

$subj_2  = $this->input->post('subj_2');
$subj_2_max_mark_plus_1  = $this->input->post('subj_2_max_mark_plus_1');
$subj_2_max_mark_plus_2  = $this->input->post('subj_2_max_mark_plus_2');
$subj_2_mark__obtained_plus_1  = $this->input->post('subj_2_mark__obtained_plus_1');
$subj_2_mark__obtained_plus_2  = $this->input->post('subj_2_mark__obtained_plus_2');
$subj_2_class_grade_plus_1  = $this->input->post('subj_2_class_grade_plus_1');
$subj_2_class_grade_plus_2  = $this->input->post('subj_2_class_grade_plus_2');

$subj_3  = $this->input->post('subj_3');
$subj_3_max_mark_plus_1  = $this->input->post('subj_3_max_mark_plus_1');
$subj_3_max_mark_plus_2  = $this->input->post('subj_3_max_mark_plus_2');
$subj_3_mark__obtained_plus_1  = $this->input->post('subj_3_mark__obtained_plus_1');
$subj_3_mark__obtained_plus_2  = $this->input->post('subj_3_mark__obtained_plus_2');
$subj_3_class_grade_plus_1  = $this->input->post('subj_3_class_grade_plus_1');
$subj_3_class_grade_plus_2  = $this->input->post('subj_3_class_grade_plus_2');


$subj_4  = $this->input->post('subj_4');
$subj_4_max_mark_plus_1  = $this->input->post('subj_4_max_mark_plus_1');
$subj_4_max_mark_plus_2  = $this->input->post('subj_4_max_mark_plus_2');
$subj_4_mark__obtained_plus_1  = $this->input->post('subj_4_mark__obtained_plus_1');
$subj_4_mark__obtained_plus_2  = $this->input->post('subj_4_mark__obtained_plus_2');
$subj_4_class_grade_plus_1  = $this->input->post('subj_4_class_grade_plus_1');
$subj_4_class_grade_plus_2  = $this->input->post('subj_4_class_grade_plus_2');


$g_total  = $this->input->post('g_total');
$g_total_max_mark_plus_1  = $this->input->post('g_total_max_mark_plus_1');
$g_total_max_mark_plus_2  = $this->input->post('g_total_max_mark_plus_2');
$g_total_mark__obtained_plus_1  = $this->input->post('g_total_mark__obtained_plus_1');
$g_total_mark__obtained_plus_2  = $this->input->post('g_total_mark__obtained_plus_2');
$g_total_class_grade_plus_1  = $this->input->post('g_total_class_grade_plus_1');
$g_total_class_grade_plus_2  = $this->input->post('g_total_class_grade_plus_2');

$m_total  = $this->input->post('m_total');
$m_total_max_mark_plus_1  = $this->input->post('m_total_max_mark_plus_1');
$m_total_max_mark_plus_2  = $this->input->post('m_total_max_mark_plus_2');
$m_total_mark__obtained_plus_1  = $this->input->post('m_total_mark__obtained_plus_1');
$m_total_mark__obtained_plus_2  = $this->input->post('m_total_mark__obtained_plus_2');
$m_total_class_grade_plus_1  = $this->input->post('m_total_class_grade_plus_1');
$m_total_class_grade_plus_2  = $this->input->post('m_total_class_grade_plus_2');



$subject_mark = array(


	'lang_1'=>$lang_1,
	'lang_1_max_mark_plus_1'=>$lang_1_max_mark_plus_1,
	'lang_1_max_mark_plus_2'=>$lang_1_max_mark_plus_2,
	'lang_1_mark__obtained_plus_1'=>$lang_1_mark__obtained_plus_1,
	'lang_1_mark__obtained_plus_2'=>$lang_1_mark__obtained_plus_2,
	'lang_1_class_grade_plus_1'=>$lang_1_class_grade_plus_1,
	'lang_1_class_grade_plus_2'=>$lang_1_class_grade_plus_2,

	'lang_2'=>$lang_2,
	'lang_2_max_mark_plus_1'=>$lang_2_max_mark_plus_1,
	'lang_2_max_mark_plus_2'=>$lang_2_max_mark_plus_2,
	'lang_2_mark__obtained_plus_1'=>$lang_2_mark__obtained_plus_1,
	'lang_2_mark__obtained_plus_2'=>$lang_2_mark__obtained_plus_2,
	'lang_2_class_grade_plus_1'=>$lang_2_class_grade_plus_1,
	'lang_2_class_grade_plus_2'=>$lang_2_class_grade_plus_2,

	'subj_1'=>$subj_1,
	'subj_1_max_mark_plus_1'=>$subj_1_max_mark_plus_1,
	'subj_1_max_mark_plus_2'=>$subj_1_max_mark_plus_2,
	'subj_1_mark__obtained_plus_1'=>$subj_1_mark__obtained_plus_1,
	'subj_1_mark__obtained_plus_2'=>$subj_1_mark__obtained_plus_2,
	'subj_1_class_grade_plus_1'=>$subj_1_class_grade_plus_1,
	'subj_1_class_grade_plus_2'=>$subj_1_class_grade_plus_2,


	'subj_2'=>$subj_2,
	'subj_2_max_mark_plus_1'=>$subj_2_max_mark_plus_1,
	'subj_2_max_mark_plus_2'=>$subj_2_max_mark_plus_2,
	'subj_2_mark__obtained_plus_1'=>$subj_2_mark__obtained_plus_1,
	'subj_2_mark__obtained_plus_2'=>$subj_2_mark__obtained_plus_2,
	'subj_2_class_grade_plus_1'=>$subj_2_class_grade_plus_1,
	'subj_2_class_grade_plus_2'=>$subj_2_class_grade_plus_2,

	'subj_3'=>$subj_3,
	'subj_3_max_mark_plus_1'=>$subj_3_max_mark_plus_1,
	'subj_3_max_mark_plus_2'=>$subj_3_max_mark_plus_2,
	'subj_3_mark__obtained_plus_1'=>$subj_3_mark__obtained_plus_1,
	'subj_3_mark__obtained_plus_2'=>$subj_3_mark__obtained_plus_2,
	'subj_3_class_grade_plus_1'=>$subj_3_class_grade_plus_1,
	'subj_3_class_grade_plus_2'=>$subj_3_class_grade_plus_2,

	'subj_4'=>$subj_4,
	'subj_4_max_mark_plus_1'=>$subj_4_max_mark_plus_1,
	'subj_4_max_mark_plus_2'=>$subj_4_max_mark_plus_2,
	'subj_4_mark__obtained_plus_1'=>$subj_4_mark__obtained_plus_1,
	'subj_4_mark__obtained_plus_2'=>$subj_4_mark__obtained_plus_2,
	'subj_4_class_grade_plus_1'=>$subj_4_class_grade_plus_1,
	'subj_4_class_grade_plus_2'=>$subj_4_class_grade_plus_2,

	'g_total'=>$g_total,
	'g_total_max_mark_plus_1'=>$g_total_max_mark_plus_1,
	'g_total_max_mark_plus_2'=>$g_total_max_mark_plus_2,
	'g_total_mark__obtained_plus_1'=>$g_total_mark__obtained_plus_1,
	'g_total_mark__obtained_plus_2'=>$g_total_mark__obtained_plus_2,
	'g_total_class_grade_plus_1'=>$g_total_class_grade_plus_1,
	'g_total_class_grade_plus_2'=>$g_total_class_grade_plus_2,

	'm_total'=>$m_total,
	'm_total_max_mark_plus_1'=>$m_total_max_mark_plus_1,
	'm_total_max_mark_plus_2'=>$m_total_max_mark_plus_2,
	'm_total_mark__obtained_plus_1'=>$m_total_mark__obtained_plus_1,
	'm_total_mark__obtained_plus_2'=>$m_total_mark__obtained_plus_2,
	'm_total_class_grade_plus_1'=>$m_total_class_grade_plus_1,
	'm_total_class_grade_plus_2'=>$m_total_class_grade_plus_2,


	'lang_1_status'=>$result_lang_one,
	'lang_2_status'=>$result_lang_two,
	'subj_1_status'=>$result_sub_1,
	'subj_2_status'=>$result_sub_2,
	'subj_3_status'=>$result_sub_3,
	'subj_4_status'=>$result_sub_4,

);



$this->db->where('sb_u_id',$user_id);
$this->db->update('sub_preview',$subject_mark);


$this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong> Application Updated Successfully .
</div>');


	redirect('Admin/editApplicant/'.$user_id, 'refresh');


}



public function do_upload(){


    

	$config = array();
	$config['upload_path'] = 'uploads/';
	$config['allowed_types'] = '*';
	$config['remove_spaces'] = TRUE;
	$config['encrypt_name'] = TRUE;
	return $config;
	
	}

public function updateInterview(){


    //print_r($_POST);
    $date = $this->input->post('int_date');
    $time = $this->input->post('int_time');
    $user_id = $this->input->post('user_id');

$user = $this->db->select("*")->from("stu_user")->where("u_id",$user_id)->get();

$us_value = $user->result();

    $array = array(
        'sa_interview_date'=>$date,
        'sa_interview_time'=>$time,
        'sa_interview_status'=>1,
    );



    $this->db->where('sa_st_id',$user_id);
	$q = $this->db->update('stu_applied',$array);
	


if($q){



	$emailsignature = "<br><br><b class='signature'>Regards,<br>

	Major Dr. I. Babu Rathinam <br>
	Principal<br>
	Avichi College of Arts and Science,<br>
	130A, Arcot Road, Virugambakkam,<br>
	Chennai – 600 092.<br>
	Ph - +91 44 2376 4227.</br>";
	
			$smssignature="Avichi  College(ACAS)";


			$subject="Avichi College Of Arts And Science  - Application Submission";
			$msg ="Dear ".$us_value[0]->u_name ." ,<br><br>Congratulations! You have been shortlisted for the online interview with the panel of Subject Matter Experts and your interview got scheduled on (Date : ".date('d-M-Y',strtotime($date))." and Time : ".date('h:i A',strtotime($time))."). ".$emailsignature;
			$msg1 ="Dear ".$us_value[0]->u_name ." , Congratulations! You have been shortlisted for the online interview with the panel of Subject Matter Experts and your interview got scheduled on (Date : ".date('d-M-Y',strtotime($date))." and Time : ".date('h:i A',strtotime($time)).").  ".$smssignature;
	
	
			$this->testEmail( $us_value[0]->u_email_id,$subject,$msg);
			$this->smsInterface($us_value[0]->u_mobile,$msg1);
	


	
}


    $this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success !</strong> Interview scheduled Successfully .
    </div>');


	redirect('Admin/appliedApproved', 'refresh');

    }


	public function updateInterviewApplied(){


		//print_r($_POST);
		$date = $this->input->post('int_date');
		$time = $this->input->post('int_time');
		$user_id = $this->input->post('user_id');
	
	
		$array = array(
			'sa_interview_date'=>$date,
			'sa_interview_time'=>$time,
			'sa_interview_status'=>1,
		);
	
	
	
		$this->db->where('sa_st_id',$user_id);
		$this->db->update('stu_applied',$array);
	
		$this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Success !</strong> Interview scheduled Successfully .
		</div>');
	
	
		redirect('Admin/viewProfile/'.$user_id, 'refresh');
	
		}
	

    public function appliedApproved(){




        $qd = $this->db->select('*')->from('stu_applied')->join('new_preview','stu_applied.sa_st_id = new_preview.pr_user_id')->where('sa_interview_status',1)->where("sa_interview_attended_status ",null)->or_where("sa_interview_attended_status ","Interview not attended")->get();

        $data['applied'] = $qd->result();
    
        $this->load->view('template/admin/header');
        $this->load->view('template/admin/menubar');
        $this->load->view('template/admin/headerbar');
        $this->load->view('admin/scheduleduser',$data);
        $this->load->view('template/admin/footer');




        
    }



    public function viewProfile($id= null){

        $id = $this->uri->segment(3);
        $applied = $this->db->select('*')->from('stu_applied')->where('sa_st_id',$id)->get();
        $qd = $this->db->select('*')->from('sub_preview')->join('new_preview','sub_preview.sb_u_id = new_preview.pr_user_id')->where('sub_preview.sb_u_id',$id)->get();
        $cou = $this->db->select('*')->from('college_course')->get(); 
            
            
            $data['schdate'] = $applied->result();
            $data['course'] = $cou->result();
            $data['applied'] = $qd->result();
        
            $this->load->view('template/admin/header');
            $this->load->view('template/admin/menubar');
            $this->load->view('template/admin/headerbar');
            $this->load->view('admin/assigncourse',$data);
            $this->load->view('template/admin/footer');
        
        
        
		}
		

		public function viewStudentProfile($id= null){

			$id = $this->uri->segment(3);
			$applied = $this->db->select('*')->from('stu_applied')->where('sa_st_id',$id)->get();
			$qd = $this->db->select('*')->from('sub_preview')->join('new_preview','sub_preview.sb_u_id = new_preview.pr_user_id')->where('sub_preview.sb_u_id',$id)->get();
			$cou = $this->db->select('*')->from('college_course')->get(); 
				
				
				$data['schdate'] = $applied->result();
				$data['course'] = $cou->result();
				$data['applied'] = $qd->result();
			
				$this->load->view('template/admin/header');
				$this->load->view('template/admin/menubar');
				$this->load->view('template/admin/headerbar');
				$this->load->view('admin/viewprofile',$data);
				$this->load->view('template/admin/footer');
			
			
			
			}
	

        public function updateCourse(){





//print_r($_POST);




           $course_one = $this->input->post('course_one');
         $user_id = $this->input->post('user_id');
         $Status_att = $this->input->post('status_one');
       //  $rollnumber = $this->input->post('rollnumber');
         $int_date = $this->input->post('int_date');
         $int_time = $this->input->post('int_time');
         $comments = $this->input->post('comments');
                
            
            if($Status_att  == "Interview not attended"){




				$array = array(
					
					'sa_interview_attended_status'=>$Status_att,
					'sa_interview_comments'=>$comments,
					'sa_interview_date'=>$int_date,
					'sa_interview_time'=>$int_time,
				);




			}else{
            
          $array = array(
                'sa_course_comformed'=>$course_one,
                'sa_interview_attended_status'=>$Status_att,
               // 'sa_roll_number'=>$rollnumber,
                'sa_interview_comments'=>$comments,
               // 'sa_interview_status'=>1,
            );
            
		} 
            
             $this->db->where('sa_st_id',$user_id);
            $this->db->update('stu_applied',$array);
            
            $this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success !</strong> Course Allocated Successfully .
            </div>');
            
            
               redirect('Admin/appliedApproved', 'refresh'); 
             

        }

        public function courseApproved(){


          
        $qd = $this->db->select('*')->from('stu_applied')->join('new_preview','stu_applied.sa_st_id = new_preview.pr_user_id')
        ->join('college_course','stu_applied.sa_course_comformed = college_course.cs_id')
        
        ->where('sa_interview_status',1)->where('sa_course_comformed != ',NULL)->get();

        $data['applied'] = $qd->result();
    
        $this->load->view('template/admin/header');
        $this->load->view('template/admin/menubar');
        $this->load->view('template/admin/headerbar');
        $this->load->view('admin/courseapproved',$data);
        $this->load->view('template/admin/footer');




		}
		
		public function updateAdmit(){



			//print_r($_POST);

					$status  = $this->input->post("status_one");
					$rollnumber  = $this->input->post("rollnumber");
					$course_one  = $this->input->post("course_one");
					$comments  = $this->input->post("comments");
					$user_id  = $this->input->post("user_id");



					if($status == "Admitted"){


					$data = array(
						'sa_interview_attended_status'=>$status,
						'sa_roll_number'=>$rollnumber,
						'sa_interview_comments'=>$comments,
						'sa_course_comformed'=>$course_one,
					);

					$user = $this->db->select("*")->from("stu_user")->where("u_id",$user_id)->get();
					$us_value = $user->result();
					
					$appl = $this->db->select("*")->from("new_preview")->where("pr_user_id",$user_id)->get();
					$us_appl = $appl->result();

					$cour = $this->db->select("*")->from("college_course")->where("cs_id",$course_one)->get();
					$us_cour = $cour->result();









	$emailsignature = "<br><br><b class='signature'>Regards,<br>

	Major Dr. I. Babu Rathinam <br>
	Principal<br>
	Avichi College of Arts and Science,<br>
	130A, Arcot Road, Virugambakkam,<br>
	Chennai – 600 092.<br>
	Ph - +91 44 2376 4227.</br>";
	
			$smssignature="Avichi  College(ACAS)";


			$subject="Avichi College Of Arts And Science  - Applied Status";
			$msg ="Dear ".$us_value[0]->u_name ." ,<br><br>Hearty Congratulations! Mr or Ms ".$us_appl[0]->pr_applicant_name." you have got enrolled into the Avichi educational institute for the ". $us_cour[0]->cs_name ." program, kindly fill up the required details by clicking this link to proceed further with your admission".	$emailsignature;
			$msg1 ="Dear ".$us_value[0]->u_name ." , Hearty Congratulations! Mr or Ms ".$us_appl[0]->pr_applicant_name." you have got enrolled into the Avichi educational institute for the ". $us_cour[0]->cs_name ." program, kindly fill up the required details by clicking this link to proceed further with your admission".$smssignature;
	
	
			$this->testEmail( $us_value[0]->u_email_id,$subject,$msg);
			$this->smsInterface($us_value[0]->u_mobile,$msg1);
	

					}else{

						$data = array(
							'sa_interview_attended_status'=>$status,
							'sa_roll_number'=>null,
							'sa_interview_comments'=>$comments,
							'sa_course_comformed'=>null,
						);

						/* $subject="Avichi Educational Institute ";
						$msg ="Congratulations! You have been shortlisted for the online interview with the panel of Subject Matter Experts and your interview got scheduled on (Date : ".date('d-M-Y',strtotime($date))." and Time : ".date('h:i A',strtotime($time)).").";
						$this->testEmail( $us_value[0]->u_email_id,$subject,$msg);
						$this->smsInterface($us_value[0]->u_mobile,$msg); */
					

					}


					$this->db->where("sa_st_id",$user_id);
					$this->db->update("stu_applied",$data);


					redirect('Admin/ReportsUser/'.$user_id, 'refresh');


		}

		public function admitProfile($id= null){

			$id = $this->uri->segment(3);
			$applied = $this->db->select('*')->from('stu_applied')->where('sa_st_id',$id)->get();
			$qd = $this->db->select('*')->from('sub_preview')->join('new_preview','sub_preview.sb_u_id = new_preview.pr_user_id')->where('sub_preview.sb_u_id',$id)->get();
			$cou = $this->db->select('*')->from('college_course')->get(); 
				
				
				$data['schdate'] = $applied->result();
				$data['course'] = $cou->result();
				$data['applied'] = $qd->result();
			
				$this->load->view('template/admin/header');
				$this->load->view('template/admin/menubar');
				$this->load->view('template/admin/headerbar');
				$this->load->view('admin/admitprofile',$data);
				$this->load->view('template/admin/footer');
			
			
			
			}



		public function ReportsUser(){

			$qd = $this->db->select('*')->from('stu_applied')->join('new_preview','stu_applied.sa_st_id = new_preview.pr_user_id')
			->join('college_course','stu_applied.sa_course_comformed = college_course.cs_id' ,'left')->get();
			
			
	
			$data['applied'] = $qd->result();


			$this->load->view('template/admin/header');
			$this->load->view('template/admin/menubar');
			$this->load->view('template/admin/headerbar');
			$this->load->view('admin/reportUser',$data);
			$this->load->view('template/admin/footer');




		}

	public function viewCompleteReports(){


		$id = $this->uri->segment(3);
        $applied = $this->db->select('*')->from('stu_applied')->join('college_course','stu_applied.sa_course_comformed = college_course.cs_id',"left")->where('sa_st_id',$id)->get();
        $qd = $this->db->select('*')->from('sub_preview')->join('new_preview','sub_preview.sb_u_id = new_preview.pr_user_id')->where('sub_preview.sb_u_id',$id)->get();
        $cou = $this->db->select('*')->from('college_course')->get(); 
            
            
            $data['schdate'] = $applied->result();
            $data['course'] = $cou->result();
            $data['applied'] = $qd->result();

				//print_r($data);
			$this->load->view('template/admin/header');
			$this->load->view('template/admin/menubar');
			$this->load->view('template/admin/headerbar');
			$this->load->view('admin/viewcompletereport',$data);
			$this->load->view('template/admin/footer');

		
	}

    public function addTrust(){

        $this->load->view('template/admin/header');
        $this->load->view('template/admin/menubar');
        $this->load->view('template/admin/headerbar');
        $this->load->view('admin/addtrust.php');
        $this->load->view('template/admin/footer');


    }

    public function editTrust(){

        $this->load->view('template/admin/header');
        $this->load->view('template/admin/menubar');
        $this->load->view('template/admin/headerbar');
        $this->load->view('admin/edittrust.php');
        $this->load->view('template/admin/footer');


    }


	
	public function testEmail( $emailto,$subject,$msg){

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
		-webkit-font-smoothing: antialiased !important; /*style only recognised by some browsers*/
		}
		img {
		border: 0 !important;
		outline: none !important;
		}
		p {
		Margin: 0px !important; /*Old versions of Outlook ignore margin if it is lower case as usual*/
		padding: 0px !important;
		}
		table {
		border-collapse: collapse;
		mso-table-lspace: 0px; /*Microsoft Office only styling*/
		mso-table-rspace: 0px; /*Microsoft Office only styling*/
		}
		table.em_main_table {
		box-shadow: 2px 2px 11px 2px #b2acac;
		}
		td, a, span {
		border-collapse: collapse;
		mso-line-height-rule: exactly; /*Microsoft Office only styling*/
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
		/* Text decoration removed */
		.em_defaultlink a {
		color: inherit !important;
		text-decoration: none !important;
		}
		span.MsoHyperlink {
		mso-style-priority: 99; /*Microsoft Office only styling*/
		color: inherit;
		}
		span.MsoHyperlinkFollowed {
		mso-style-priority: 99; /*Microsoft Office only styling*/
		color: inherit;
		}
		/* Media Query for desktop layout */
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
		/* Media Query for mobile layout */
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
		<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" style="background:#2f2483;">
		<tbody>
		<tr>
		<td valign="top" align="center">
		<img class="em_img" alt="Welcome to Email" src="http://admission.avichicollege.edu.in//landing/images/logo.png" width="700" border="0" height="230">
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
		<td style="font-family: Arial, sans-serif; font-size:16px; line-height:30px; " valign="top" align="center">
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
					$this->email->from("noreply@avichicollege.edu.in");
					$this->email->to($emailto);
					$this->email->subject($subject);
					$this->email->message($html);
					$this->email->send();
		
		
		
		
		
		}
		public function smsInterface($mobile,$msg){
	
	
			
			$stripped = str_replace(' ','%20',$msg);
			//$msg ="Thanks for Registering with us on Gamin Inztinct. OTP for mobile number verification is ". $mobile_rand;
					
			$url = "http://hpapi.dial4sms.com/SendSMS/sendmsg.php?uname=avichi&pass=Avichi@1&send=SMSINf&dest=".$mobile."&msg=".$stripped;
	
			$ch = curl_init();
			$timeout = 30;
			curl_setopt ($ch,CURLOPT_URL, $url) ;
			curl_setopt ($ch,CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch,CURLOPT_CONNECTTIMEOUT, $timeout) ;
			$response = curl_exec($ch) ;
			curl_close($ch) ;
	
		}

		public function userPaidStatus(){


			$qd = $this->db->select('*')->from('stu_applied')
			->join('new_preview','stu_applied.sa_st_id = new_preview.pr_user_id')
			->join('college_course','new_preview.pr_course_1 = college_course.cs_id','left')
			->get();
		
			$data['applied'] = $qd->result();
		
			$this->load->view('template/admin/header');
			$this->load->view('template/admin/menubar');
			$this->load->view('template/admin/headerbar');
			$this->load->view('admin/feeuser',$data);
			$this->load->view('template/admin/footer');
		
		}
		public function studentPdf(){
			$user_id =$this->uri->segment(3);
			$app_course_id=$this->uri->segment(4);
			
			
			$pr_user = $this->db->select('*')->from('new_preview_pg')->where('pr_user_id',$user_id)->get();
			
			$usd = $pr_user->result();
			$pr_study = $this->db->select('*')->from('sub_preview_pg')->where('sb_u_id',$user_id)->get();
			
			$uss = $pr_study->result();
			
			
			
			
			
			
			$q = $this->db->select('*')->from('Applyed_Cources')->where('main_course_id',1)->where('user_id',$user_id)->where('applied_course_id',$app_course_id)->get();
			
			$app_id = $q->result();
			
			
			if($usd[0]->pr_differently_abled == "" || $usd[0]->pr_differently_abled == NULL){
				
				$abled ="<tr>
				<th>No</th>
				<td>-</td>
				</tr>";
			
			
			}
			else if($usd[0]->pr_differently_abled=="NO"){
				$abled ="<tr>
			<th>No</th>
			<td>-</td>
			</tr>";
			}else if($usd[0]->pr_differently_abled=="YES"){
				$abled ="<tr>
			  <th>".$usd[0]->pr_differently_abled."</th>
			  <td>".$usd[0]->pr_differently_abled_reson."</td>
			  </tr>";
			}else{
			
				$abled ="<tr>
			<th>No</th>
			<td>-</td>
			</tr>";
			
			
			}
			
			
			 if($usd[0]->pr_other_res == "" || $usd[0]->pr_other_res == NULL){
				 
				
				$reservation ="<tr>
				<th>No</th>
				<td>-</td>
				</tr>";
			
			}else if($usd[0]->pr_other_res=="NO"){
				
				$reservation ="<tr>
			<th>No</th>
			<td>-</td>
			</tr>";
			
			}else if($usd[0]->pr_other_res=="YES"){
				
				$reservation ="<tr>
			  <th>".$usd[0]->pr_other_res."</th>
			  <td>".$usd[0]->pr_other_special_reservation."</td>
			  </tr>";
			} else{
			
				$reservation ="<tr>
				<th>No</th>
				<td>-</td>
				</tr>";
			
			
			}
			
			
			$dompdf = new DOMPDF();
			$html = '
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
			<img src="http://test.mssw.in//landing/images/logo.png" width="60%" height="75px;" alt="image">
			</div>
			
			<h3 align="center">Application Form For The Academic Year 2020 - 2021</h3>
			
			<table width="100%">
				<tr>
					<td valign="top"><img src="'.base_url().'/uploads/'.$usd[0]->pr_photo.'" alt="" width="100"/></td>
					<td align="right">
						<h3>Name : '.$usd[0]->pr_applicant_name.'</h3>
						<h3>Reference Number : 21'.sprintf("%'04d", $usd[0]->pr_user_id ).'</h3>
						<h3>Application Number : '.$app_id[0]->application_number.'</h3>
					 
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
				  <td>'.$usd[0]->pr_mother_toung.'</td>
				  <td>'.$usd[0]->pr_place_of_birth.'</td>
				  <td>'.date('d-M-Y',strtotime($usd[0]->pr_dob)).'</td>
				  <td>'.$usd[0]->pr_age.'</td>
				  <td>'.$usd[0]->pr_gender.'</td>
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
				  <td>'.$usd[0]->pr_nationality.'</td>
				  <td>'.$usd[0]->pr_religion.'</td>
				  <td>'.$usd[0]->pr_caste.'</td>
				  <td>'.$usd[0]->pr_community.'</td>
				
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
			<td>'.$usd[0]->pr_local_address.'</td>
			<td>'.$usd[0]->pr_permanent_address.'</td>
			</tr>
			
			<tr>
			<th align="left">City</th>
			<td>'.$usd[0]->pr_local_city.'</td>
			<td>'.$usd[0]->pr_permanent_city.'</td>
			</tr>
			<tr>
			<th align="left">State</th>
			<td>'.$usd[0]->pr_local_state.'</td>
			<td>'.$usd[0]->pr_permanent_state.'</td>
			</tr>    
			<tr>
			<th align="left">Country</th>
			<td>'.$usd[0]->pr_local_country.'</td>
			<td>'.$usd[0]->pr_permanent_country.'</td>
			</tr>   
			<tr>
			<th align="left">Pincode</th>
			<td>'.$usd[0]->pr_local_pincode.'</td>
			<td>'.$usd[0]->pr_permanent_pincode.'</td>
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
				 
					<td >'.$uss[0]->sslc_subject.'</td>
					<td >'.$uss[0]->sslc_institution.'</td>
					<td >'.$uss[0]->sslc_max_mark.'</td>
					<td >'.$uss[0]->sslc_mark_obtain.'</td>
					<td >'.$uss[0]->sslc_grade.'</td>
					<td >'.$uss[0]->sslc_percentage.'</td>
				  </tr>
				  <tr>
				  <th scope="row">2</th>
				
				  <td >'.$uss[0]->plus_one_subject.'</td>
				  <td >'.$uss[0]->plus_one_institution.'</td>
				  <td >'.$uss[0]->plus_one_max_mark.'</td>
				  <td >'.$uss[0]->plus_one_mark_obtain.'</td>
				  <td >'.$uss[0]->plus_one_grade.'</td>
				  <td >'.$uss[0]->plus_one_percentage.'</td>
				  </tr>
				  <tr>
				  <th scope="row">3</th>
				
				  <td >'.$uss[0]->plus_two_subjec.'</td>
				  <td >'.$uss[0]->plus_two_institution.'</td>
				  <td >'.$uss[0]->plus_two_max_mark.'</td>
				  <td >'.$uss[0]->plus_two_mark_obtain.'</td>
				  <td >'.$uss[0]->plus_two_grade.'</td>
				  <td >'.$uss[0]->plus_two_percentage.'</td>
				  </tr>
				  <tr>
				  <th scope="row">4</th>
				
				  <td >'.$uss[0]->UG_subject.'</td>
				  <td >'.$uss[0]->ug_institution.'</td>
				  <td >'.$uss[0]->UG_max_mark.'</td>
				  <td >'.$uss[0]->UG_mark_obtain.'</td>
				  <td >'.$uss[0]->UG_grade.'</td>
				  <td >'.$uss[0]->UG_two_percentage.'</td>
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
				  <td>'.$usd[0]->pr_differently_abled.'</td>
				  <td>'.$usd[0]->pr_differently_abled_reson.'</td>
				 
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
				  <td>'.$usd[0]->pr_other_res.'</td>
				  <td>'.$usd[0]->pr_other_special_reservation.'</td>
				 
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
				  <td>'.$usd[0]->pr_hostel.'</td>
				  <td>'.$usd[0]->pr_identification_one.'</td>
				  <td>'.$usd[0]->pr_identification_two.'</td>
			
				
				 
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
			  <td align="center">'.$usd[0]->pr_name_of_game.'</td>
				  <td  align="center">'.$usd[0]->pr_game_position.'</td>
				  <td  align="center">'.$usd[0]->pr_extra_caricular_act.'</td>	
			  
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
			<td>'.$usd[0]->pr_father_name.'</td>
			<td>'.$usd[0]->pr_mother_name.'</td>
			<td>'.$usd[0]->pr_gaurdion_name.'</td>
			</tr>
			<tr>
			<th align="left">E-Mail Id</th>
			<td>'.$usd[0]->pr_father_email.'</td>
			<td>'.$usd[0]->pr_mother_email.'</td>
			<td>'.$usd[0]->pr_gaurdion_email.'</td>
			</tr>
			<tr>
			<th align="left">Mobile No.</th>
			<td>'.$usd[0]->pr_father_mobnum.'</td>
			<td>'.$usd[0]->pr_mother_mobnum.'</td>
			<td>'.$usd[0]->pr_gaurdion_mobnum.'</td>
			</tr>
			<tr>
			<th align="left">Occupation</th>
			<td>'.$usd[0]->pr_father_accu.'</td>
			<td>'.$usd[0]->pr_mother_accu.'</td>
			<td>'.$usd[0]->pr_gaurdion_accu.'</td>
			</tr>
			<tr>
			<th align="left">Annual
			Income</th>
			<td>'.$usd[0]->pr_father_anuval_income.'</td>
			<td>'.$usd[0]->pr_mother_anuval_income.'</td>
			<td>'.$usd[0]->pr_gaurdion_anuval_income.'</td>
			</tr>   
			  </table>
			</body>
			</html>';
			
			$dompdf->load_html($html);
			$dompdf->render();
			
			$dompdf->stream('21'.sprintf("%'04d", $usd[0]->pr_user_id ).'.pdf');
			
			}
			
public function studentSearchPdf(){
			$user_id =$this->uri->segment(3);
			$app_course_id =$this->uri->segment(4);
			
			
			$pr_user = $this->db->select('*')->from('new_preview_pg')->where('pr_user_id',$user_id)->get();
			
			$usd = $pr_user->result();
			$pr_study = $this->db->select('*')->from('sub_preview_pg')->where('sb_u_id',$user_id)->get();
			
			$uss = $pr_study->result();
			
			
			
			
			
			
			$q = $this->db->select('*')->from('Applyed_Cources')->where('main_course_id',1)->where('user_id',$user_id)->where('applied_course_id',$app_course_id)->get();
			
			$app_id = $q->result();
			
			
			if($usd[0]->pr_differently_abled == "" || $usd[0]->pr_differently_abled == NULL){
				
				$abled ="<tr>
				<th>No</th>
				<td>-</td>
				</tr>";
			
			
			}
			else if($usd[0]->pr_differently_abled=="NO"){
				$abled ="<tr>
			<th>No</th>
			<td>-</td>
			</tr>";
			}else if($usd[0]->pr_differently_abled=="YES"){
				$abled ="<tr>
			  <th>".$usd[0]->pr_differently_abled."</th>
			  <td>".$usd[0]->pr_differently_abled_reson."</td>
			  </tr>";
			}else{
			
				$abled ="<tr>
			<th>No</th>
			<td>-</td>
			</tr>";
			
			
			}
			
			
			 if($usd[0]->pr_other_res == "" || $usd[0]->pr_other_res == NULL){
				 
				
				$reservation ="<tr>
				<th>No</th>
				<td>-</td>
				</tr>";
			
			}else if($usd[0]->pr_other_res=="NO"){
				
				$reservation ="<tr>
			<th>No</th>
			<td>-</td>
			</tr>";
			
			}else if($usd[0]->pr_other_res=="YES"){
				
				$reservation ="<tr>
			  <th>".$usd[0]->pr_other_res."</th>
			  <td>".$usd[0]->pr_other_special_reservation."</td>
			  </tr>";
			} else{
			
				$reservation ="<tr>
				<th>No</th>
				<td>-</td>
				</tr>";
			
			
			}
			
			
			$dompdf = new DOMPDF();
			$html = '
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
			<img src="http://test.mssw.in//landing/images/logo.png" width="60%" height="75px;" alt="image">
			</div>
			
			<h3 align="center">Application Form For The Academic Year 2020 - 2021</h3>
			
			<table width="100%">
				<tr>
					<td valign="top"><img src="'.base_url().'/uploads/'.$usd[0]->pr_photo.'" alt="" width="100"/></td>
					<td align="right">
						<h3>Name : '.$usd[0]->pr_applicant_name.'</h3>
						<h3>Reference Number : 21'.sprintf("%'04d", $usd[0]->pr_user_id ).'</h3>
						<h3>Application Number : '.$app_id[0]->application_number.'</h3>
					 
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
				  <td>'.$usd[0]->pr_mother_toung.'</td>
				  <td>'.$usd[0]->pr_place_of_birth.'</td>
				  <td>'.date('d-M-Y',strtotime($usd[0]->pr_dob)).'</td>
				  <td>'.$usd[0]->pr_age.'</td>
				  <td>'.$usd[0]->pr_gender.'</td>
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
				  <td>'.$usd[0]->pr_nationality.'</td>
				  <td>'.$usd[0]->pr_religion.'</td>
				  <td>'.$usd[0]->pr_caste.'</td>
				  <td>'.$usd[0]->pr_community.'</td>
				
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
			<td>'.$usd[0]->pr_local_address.'</td>
			<td>'.$usd[0]->pr_permanent_address.'</td>
			</tr>
			
			<tr>
			<th align="left">City</th>
			<td>'.$usd[0]->pr_local_city.'</td>
			<td>'.$usd[0]->pr_permanent_city.'</td>
			</tr>
			<tr>
			<th align="left">State</th>
			<td>'.$usd[0]->pr_local_state.'</td>
			<td>'.$usd[0]->pr_permanent_state.'</td>
			</tr>    
			<tr>
			<th align="left">Country</th>
			<td>'.$usd[0]->pr_local_country.'</td>
			<td>'.$usd[0]->pr_permanent_country.'</td>
			</tr>   
			<tr>
			<th align="left">Pincode</th>
			<td>'.$usd[0]->pr_local_pincode.'</td>
			<td>'.$usd[0]->pr_permanent_pincode.'</td>
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
				 
					<td >'.$uss[0]->sslc_subject.'</td>
					<td >'.$uss[0]->sslc_institution.'</td>
					<td >'.$uss[0]->sslc_max_mark.'</td>
					<td >'.$uss[0]->sslc_mark_obtain.'</td>
					<td >'.$uss[0]->sslc_grade.'</td>
					<td >'.$uss[0]->sslc_percentage.'</td>
				  </tr>
				  <tr>
				  <th scope="row">2</th>
				
				  <td >'.$uss[0]->plus_one_subject.'</td>
				  <td >'.$uss[0]->plus_one_institution.'</td>
				  <td >'.$uss[0]->plus_one_max_mark.'</td>
				  <td >'.$uss[0]->plus_one_mark_obtain.'</td>
				  <td >'.$uss[0]->plus_one_grade.'</td>
				  <td >'.$uss[0]->plus_one_percentage.'</td>
				  </tr>
				  <tr>
				  <th scope="row">3</th>
				
				  <td >'.$uss[0]->plus_two_subjec.'</td>
				  <td >'.$uss[0]->plus_two_institution.'</td>
				  <td >'.$uss[0]->plus_two_max_mark.'</td>
				  <td >'.$uss[0]->plus_two_mark_obtain.'</td>
				  <td >'.$uss[0]->plus_two_grade.'</td>
				  <td >'.$uss[0]->plus_two_percentage.'</td>
				  </tr>
				  <tr>
				  <th scope="row">4</th>
				
				  <td >'.$uss[0]->UG_subject.'</td>
				  <td >'.$uss[0]->ug_institution.'</td>
				  <td >'.$uss[0]->UG_max_mark.'</td>
				  <td >'.$uss[0]->UG_mark_obtain.'</td>
				  <td >'.$uss[0]->UG_grade.'</td>
				  <td >'.$uss[0]->UG_two_percentage.'</td>
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
				  <td>'.$usd[0]->pr_differently_abled.'</td>
				  <td>'.$usd[0]->pr_differently_abled_reson.'</td>
				 
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
				  <td>'.$usd[0]->pr_other_res.'</td>
				  <td>'.$usd[0]->pr_other_special_reservation.'</td>
				 
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
				  <td>'.$usd[0]->pr_hostel.'</td>
				  <td>'.$usd[0]->pr_identification_one.'</td>
				  <td>'.$usd[0]->pr_identification_two.'</td>
			
				
				 
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
			  <td align="center">'.$usd[0]->pr_name_of_game.'</td>
				  <td  align="center">'.$usd[0]->pr_game_position.'</td>
				  <td  align="center">'.$usd[0]->pr_extra_caricular_act.'</td>	
			  
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
			<td>'.$usd[0]->pr_father_name.'</td>
			<td>'.$usd[0]->pr_mother_name.'</td>
			<td>'.$usd[0]->pr_gaurdion_name.'</td>
			</tr>
			<tr>
			<th align="left">E-Mail Id</th>
			<td>'.$usd[0]->pr_father_email.'</td>
			<td>'.$usd[0]->pr_mother_email.'</td>
			<td>'.$usd[0]->pr_gaurdion_email.'</td>
			</tr>
			<tr>
			<th align="left">Mobile No.</th>
			<td>'.$usd[0]->pr_father_mobnum.'</td>
			<td>'.$usd[0]->pr_mother_mobnum.'</td>
			<td>'.$usd[0]->pr_gaurdion_mobnum.'</td>
			</tr>
			<tr>
			<th align="left">Occupation</th>
			<td>'.$usd[0]->pr_father_accu.'</td>
			<td>'.$usd[0]->pr_mother_accu.'</td>
			<td>'.$usd[0]->pr_gaurdion_accu.'</td>
			</tr>
			<tr>
			<th align="left">Annual
			Income</th>
			<td>'.$usd[0]->pr_father_anuval_income.'</td>
			<td>'.$usd[0]->pr_mother_anuval_income.'</td>
			<td>'.$usd[0]->pr_gaurdion_anuval_income.'</td>
			</tr>   
			  </table>
			</body>
			</html>';
			
			$dompdf->load_html($html);
			$dompdf->render();
			
			$dompdf->stream('21'.sprintf("%'04d", $usd[0]->pr_user_id ).'pdf');
			
			}			

public function studentSearch(){

$data=array(
'course' => 1,
'searchres' => '',
);
     if(isset($_POST['submit'])){
		 $searchres = $data['searchres'] = $this->input->post('searchres');
		 $course = $data['course'] = $this->input->post('course');
		if($course==1){
				$st_dm=$this->db->query('select new_preview.*,stu_user.*,Applyed_Cources.*,sub_preview.*,student_complete_mark.personal_mark from new_preview left join Applyed_Cources on Applyed_Cources.user_id=new_preview.pr_user_id left join stu_user on new_preview.pr_user_id=stu_user.u_id left join sub_preview on new_preview.pr_user_id=sub_preview.sb_u_id left join student_complete_mark on new_preview.pr_user_id=student_complete_mark.stu_id and Applyed_Cources.main_course_id=student_complete_mark.main_course_id and Applyed_Cources.applied_course_id=student_complete_mark.app_course_id where (new_preview.pr_applicant_name like "%'.$searchres.'%" or (concat("21", new_preview.pr_user_id) like "%'.$searchres.'%") or Applyed_Cources.application_number like "%'.$searchres.'%") and stu_user.u_course="1" ');
		}
		if($course==2){
				$st_dm=$this->db->query('select new_preview_pg.*,stu_user.*,Applyed_Cources.*,sub_preview_pg.*,student_complete_mark.personal_mark from new_preview_pg left join Applyed_Cources on Applyed_Cources.user_id=new_preview_pg.pr_user_id left join stu_user on new_preview_pg.pr_user_id=stu_user.u_id left join sub_preview_pg on new_preview_pg.pr_user_id=sub_preview_pg.sb_u_id left join student_complete_mark on new_preview_pg.pr_user_id=student_complete_mark.stu_id and Applyed_Cources.main_course_id=student_complete_mark.main_course_id and Applyed_Cources.applied_course_id=student_complete_mark.app_course_id where (new_preview_pg.pr_applicant_name like "%'.$searchres.'%" or (concat("21", new_preview_pg.pr_user_id) like "%'.$searchres.'%") or Applyed_Cources.application_number like "%'.$searchres.'%") and stu_user.u_course="2" ');
		}
		if($course==3){
				$st_dm=$this->db->query('select new_preview_dip.*,stu_user.*,Applyed_Cources.*,sub_preview_dip.*,student_complete_mark.personal_mark from new_preview_dip left join Applyed_Cources on Applyed_Cources.user_id=new_preview_dip.pr_user_id left join stu_user on new_preview_dip.pr_user_id=stu_user.u_id left join sub_preview_dip on new_preview_dip.pr_user_id=sub_preview_dip.sb_u_id left join student_complete_mark on new_preview_dip.pr_user_id=student_complete_mark.stu_id and Applyed_Cources.main_course_id=student_complete_mark.main_course_id and Applyed_Cources.applied_course_id=student_complete_mark.app_course_id where (new_preview_dip.pr_applicant_name like "%'.$searchres.'%" or (concat("21", new_preview_dip.pr_user_id) like "%'.$searchres.'%") or Applyed_Cources.application_number like "%'.$searchres.'%") and stu_user.u_course="3" ');
		}
				$data['studentsearch'] = $st_dm->result();
				//print_r(json_encode($data['studentsearch']));exit;
		
			
          }	
		
		
				$this->load->view('template/admin/header');
				$this->load->view('template/admin/menubar');
				$this->load->view('template/admin/headerbar');
				$this->load->view('admin/studentsearch',$data);
				$this->load->view('template/admin/footer');
			
		}
		
public function adm_fees_generateXls() {
	date_default_timezone_get();
	$date=date('d-M-Y');
	//Get Fees Details
	$mahrm = 0; 
		$mahrmod = 0; 
		$mase = 0; 
		$madm = 0; 
		$msccp = 0; 
		$mswde = 0; 



			$m = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",1)->where("applied_course_id",5)->get();
			$mahrm = $m->num_rows();

			$mod = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",1)->where("applied_course_id",6)->get();
			$mahrmod = $mod->num_rows();

			$mse = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",1)->where("applied_course_id",7)->get();
			$mase = $mse->num_rows();

			$mdm = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",1)->where("applied_course_id",8)->get();
			$madm = $mdm->num_rows();

			$mscc = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",1)->where("applied_course_id",9)->get();
			$msccp = $mscc->num_rows();

			$mde = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",1)->where("applied_course_id",15)->get();
			$mswde = $mde->num_rows();


		$mahrm1 = $mahrm * 500;
		$mahrmod1 = $mahrmod * 500;
		$mase1 = $mase * 500;
		$madm1 = $madm * 500;
		$msccp1 = $msccp * 500;
		$mswde1 = $mswde * 500;


$mswaidcm=0;
$mswaidmedphy=0;
$mswaidhrm=0;


$rsmswaidcm  =0;
$rsmswaidmedphy=0;
$rsmswaidhrm=0;


$mswselfcm=0;
$mswselfmedphy=0;
$mswselfhrm=0;


$rsmswselfcm  =0;
$rsmswselfmedphy=0;
$rsmswselfhrm=0;


		$q = $this->db->select("*")->from("Applyed_Master")->where("main_course_priority","PG")->get();


		$s = $q->result();



foreach ($s as $key => $value) {


	$m = $this->db->select("*")->from("Applyed_Cources")->where("master_id",$value->id)->get();
$ran = $m->result();



	$myArray = explode(',', $value->pg_mssw_aided);
	//print_r($myArray);
foreach ($myArray as $kes =>  $valuee) {
	if ( $valuee == 1)
	{
		 $mswaidcm += 1; 

if($kes == 0){

$rsmswaidcm  += 500;

}elseif($kes == 1){


	$rsmswaidcm  += 50;

}
elseif($kes == 2){


	$rsmswaidcm  += 50;

}



	}else if( $valuee ==2 ){

		$mswaidmedphy += 1;


		if($kes == 0){

			$rsmswaidmedphy  += 500;
			
			}elseif($kes == 1){
			
			
				$rsmswaidmedphy  += 50;
			
			}
			elseif($kes == 2){
			
			
				$rsmswaidmedphy  += 50;
			
			}




	}else if( $valuee ==3 ){

		$mswaidhrm += 1;


		if($kes == 0){

			$rsmswaidhrm  += 500;
			
			}elseif($kes == 1){
			
			
				$rsmswaidhrm  += 50;
			
			}
			elseif($kes == 2){
			
			
				$rsmswaidhrm  += 50;
			
			}




	}
	
}



$myArraySelf = explode(',', $value->pg_mssw_self);



foreach ($myArraySelf as $kes =>  $valuee) {
	if ( $valuee == 1)
	{
		 $mswselfcm += 1; 

if($kes == 0){

$rsmswselfcm  += 500;

}elseif($kes == 1){


	$rsmswselfcm  += 50;

}
elseif($kes == 2){


	$rsmswselfcm  += 50;

}



	}else if( $valuee ==2 ){

		$mswselfmedphy += 1;


		if($kes == 0){

			$rsmswselfmedphy  += 500;
			
			}elseif($kes == 1){
			
			
				$rsmswselfmedphy  += 50;
			
			}
			elseif($kes == 2){
			
			
				$rsmswselfmedphy  += 50;
			
			}




	}else if( $valuee ==3 ){

		$mswselfhrm += 1;


		if($kes == 0){

			$rsmswselfhrm  += 500;
			
			}elseif($kes == 1){
			
			
				$rsmswselfhrm  += 50;
			
			}
			elseif($kes == 2){
			
			
				$rsmswselfhrm  += 50;
			
			}




	}
	
}


}

$msw_aid_cm = $rsmswaidcm;
$msw_aid_mepy = $rsmswaidmedphy;
$msw_aid_hrm = $rsmswaidhrm;
$msw_self_cm = $rsmswselfcm;
$msw_self_mepy = $rsmswselfmedphy;
$msw_self_hrm = $rsmswselfhrm;

        $ugbsw = 0; 
		$ugbsc = 0; 
		$pgdipir = 0; 
		$pgdiphr = 0; 



			$ug_bsw = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",5)->where("applied_course_id",1)->get();
			$ugbsw = $ug_bsw->num_rows();

			$ug_bsc = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",5)->where("applied_course_id",2)->get();
			$ugbsc = $ug_bsc->num_rows();

			$pg_dip_ir = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",4)->where("applied_course_id",10)->get();
			$pgdipir = $pg_dip_ir->num_rows();

			$pg_dip_hr = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",4)->where("applied_course_id",11)->get();
			$pgdiphr = $pg_dip_hr->num_rows();


		$ugbsw1 = $ugbsw * 350;
		$ugbsc1 = $ugbsc * 350;
		$pgdipir1 = $pgdipir * 500;
		$pgdiphr1 = $pgdiphr * 500;

        // create file name
        $fileName = 'data-'.time().'.xls';  
        // load excel library
        $this->load->library('excel');
        //$listInfo = $this->principal_model->list_students();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
		$style = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
		'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'FFE699')
        ),
		'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('rgb' => '000000'),
            )
        )
        );
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style);
		//unset($style); 
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'MSW Aided');
        $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'MSW Community Development');
        $objPHPExcel->getActiveSheet()->SetCellValue('B2', 'MSW Medical & Psychiatric Social Work');
        $objPHPExcel->getActiveSheet()->SetCellValue('C2', 'MSW Human Resource Management');
        $objPHPExcel->getActiveSheet()->SetCellValue('A3', ''.$msw_aid_cm.'');
        $objPHPExcel->getActiveSheet()->SetCellValue('B3', ''.$msw_aid_mepy.'');
        $objPHPExcel->getActiveSheet()->SetCellValue('C3', ''.$msw_aid_hrm.'');
		$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'MSW Self Finance');
        $objPHPExcel->getActiveSheet()->SetCellValue('A6', 'MSW Community Development');
        $objPHPExcel->getActiveSheet()->SetCellValue('B6', 'MSW Medical & Psychiatric Social Work');
        $objPHPExcel->getActiveSheet()->SetCellValue('C6', 'MSW Human Resource Management');
        $objPHPExcel->getActiveSheet()->SetCellValue('A7', ''.$msw_self_cm.'');
        $objPHPExcel->getActiveSheet()->SetCellValue('B7', ''.$msw_self_mepy.'');
        $objPHPExcel->getActiveSheet()->SetCellValue('C7', ''.$msw_self_hrm.'');
		$objPHPExcel->getActiveSheet()->SetCellValue('A9', 'Self Finance');
        $objPHPExcel->getActiveSheet()->SetCellValue('A10', 'MAHRM');
        $objPHPExcel->getActiveSheet()->SetCellValue('B10', 'MAHRMOD');
        $objPHPExcel->getActiveSheet()->SetCellValue('C10', 'MASE');
        $objPHPExcel->getActiveSheet()->SetCellValue('D10', 'MADM');
        $objPHPExcel->getActiveSheet()->SetCellValue('E10', 'M.SC CP');
        $objPHPExcel->getActiveSheet()->SetCellValue('F10', 'MSWDE');
        $objPHPExcel->getActiveSheet()->SetCellValue('A11', ''.$mahrm1.'');
        $objPHPExcel->getActiveSheet()->SetCellValue('B11', ''.$mahrmod1.'');
        $objPHPExcel->getActiveSheet()->SetCellValue('C11', ''.$mase1.'');
		$objPHPExcel->getActiveSheet()->SetCellValue('D11', ''.$madm1.'');
        $objPHPExcel->getActiveSheet()->SetCellValue('E11', ''.$msccp1.'');
        $objPHPExcel->getActiveSheet()->SetCellValue('F11', ''.$mswde1.'');
		$objPHPExcel->getActiveSheet()->SetCellValue('A13', 'UG');
        $objPHPExcel->getActiveSheet()->SetCellValue('A14', 'B.S.W (SF)');
        $objPHPExcel->getActiveSheet()->SetCellValue('B14', 'B.Sc Psychology (SF)');
        $objPHPExcel->getActiveSheet()->SetCellValue('A15', ''.$ugbsw1.'');
        $objPHPExcel->getActiveSheet()->SetCellValue('B15', ''.$ugbsc1.'');
		$objPHPExcel->getActiveSheet()->SetCellValue('A17', 'PG-Diploma');
        $objPHPExcel->getActiveSheet()->SetCellValue('A18', 'Personnel Management & Industrial Relations (SF)');
        $objPHPExcel->getActiveSheet()->SetCellValue('B18', 'Human Resource Management (SF)');
        $objPHPExcel->getActiveSheet()->SetCellValue('A19', ''.$pgdipir1.'');
        $objPHPExcel->getActiveSheet()->SetCellValue('B19', ''.$pgdiphr1.'');
        // set Row
        $rowCount = 2;
        /*foreach ($listInfo as $list) {*/
            //$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $list->first_name);
            //$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $list->last_name);
            //$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $list->email);
            //$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $list->dob);
            //$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $list->contact_no);
            //$rowCount++;
        /*}*/
        //$filename = "tutsmake". date("Y-m-d-H-i-s").".csv";
        $filename = "Application_fees ".$date.".csv";
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=1'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
        $objWriter->save('php://output'); 
 
    }	
	
	public function createExcel1() {
		//include the file that loads the PhpSpreadsheet classes

//object of the Spreadsheet class to create the excel data
$spreadsheet = new Spreadsheet();

//add some data in excel cells
$spreadsheet->setActiveSheetIndex(0)
 ->setCellValue('A1', 'Domain')
 ->setCellValue('B1', 'Category')
 ->setCellValue('C1', 'Nr. Pages');


$spreadsheet->setActiveSheetIndex(0)
 ->setCellValue('A2', 'CoursesWeb.net')
 ->setCellValue('B2', 'Web Development')
 ->setCellValue('C2', '4000');

$spreadsheet->setActiveSheetIndex(0)
 ->setCellValue('A3', 'MarPlo.net')
 ->setCellValue('B3', 'Courses & Games')
 ->setCellValue('C3', '15000');

//set style for A1,B1,C1 cells
$cell_st =[
 'font' =>['bold' => true],
 'alignment' =>['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
 'borders'=>['bottom' =>['style'=> \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM]]
];
$spreadsheet->getActiveSheet()->getStyle('A1:C1')->applyFromArray($cell_st);

//set columns width
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(16);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(18);

$spreadsheet->getActiveSheet()->setTitle('Simple'); //set a title for Worksheet

//make object of the Xlsx class to save the excel file
$writer = new Xlsx($spreadsheet);
$fxls ='excel-file_1.xlsx';
        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="'. $fxls .'"'); 
        header('Cache-Control: max-age=0');
        $writer->save('php://output');	// download file 		
    } 

public function applicationFeesCreateExcel() {
	
date_default_timezone_get();
	$date=date('d-M-Y');
	//Get Fees Details
	$mahrm = 0; 
		$mahrmod = 0; 
		$mase = 0; 
		$madm = 0; 
		$msccp = 0; 
		$mswde = 0; 



			$m = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",1)->where("applied_course_id",5)->get();
			$mahrm = $m->num_rows();

			$mod = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",1)->where("applied_course_id",6)->get();
			$mahrmod = $mod->num_rows();

			$mse = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",1)->where("applied_course_id",7)->get();
			$mase = $mse->num_rows();

			$mdm = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",1)->where("applied_course_id",8)->get();
			$madm = $mdm->num_rows();

			$mscc = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",1)->where("applied_course_id",9)->get();
			$msccp = $mscc->num_rows();

			$mde = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",1)->where("applied_course_id",15)->get();
			$mswde = $mde->num_rows();


		$mahrm1 = $mahrm * 500;
		$mahrmod1 = $mahrmod * 500;
		$mase1 = $mase * 500;
		$madm1 = $madm * 500;
		$msccp1 = $msccp * 500;
		$mswde1 = $mswde * 500;


$mswaidcm=0;
$mswaidmedphy=0;
$mswaidhrm=0;


$rsmswaidcm  =0;
$rsmswaidmedphy=0;
$rsmswaidhrm=0;


$mswselfcm=0;
$mswselfmedphy=0;
$mswselfhrm=0;


$rsmswselfcm  =0;
$rsmswselfmedphy=0;
$rsmswselfhrm=0;


		$q = $this->db->select("*")->from("Applyed_Master")->where("main_course_priority","PG")->get();


		$s = $q->result();



foreach ($s as $key => $value) {


	$m = $this->db->select("*")->from("Applyed_Cources")->where("master_id",$value->id)->get();
$ran = $m->result();



	$myArray = explode(',', $value->pg_mssw_aided);
	//print_r($myArray);
foreach ($myArray as $kes =>  $valuee) {
	if ( $valuee == 1)
	{
		 $mswaidcm += 1; 

if($kes == 0){

$rsmswaidcm  += 500;

}elseif($kes == 1){


	$rsmswaidcm  += 50;

}
elseif($kes == 2){


	$rsmswaidcm  += 50;

}



	}else if( $valuee ==2 ){

		$mswaidmedphy += 1;


		if($kes == 0){

			$rsmswaidmedphy  += 500;
			
			}elseif($kes == 1){
			
			
				$rsmswaidmedphy  += 50;
			
			}
			elseif($kes == 2){
			
			
				$rsmswaidmedphy  += 50;
			
			}




	}else if( $valuee ==3 ){

		$mswaidhrm += 1;


		if($kes == 0){

			$rsmswaidhrm  += 500;
			
			}elseif($kes == 1){
			
			
				$rsmswaidhrm  += 50;
			
			}
			elseif($kes == 2){
			
			
				$rsmswaidhrm  += 50;
			
			}




	}
	
}



$myArraySelf = explode(',', $value->pg_mssw_self);



foreach ($myArraySelf as $kes =>  $valuee) {
	if ( $valuee == 1)
	{
		 $mswselfcm += 1; 

if($kes == 0){

$rsmswselfcm  += 500;

}elseif($kes == 1){


	$rsmswselfcm  += 50;

}
elseif($kes == 2){


	$rsmswselfcm  += 50;

}



	}else if( $valuee ==2 ){

		$mswselfmedphy += 1;


		if($kes == 0){

			$rsmswselfmedphy  += 500;
			
			}elseif($kes == 1){
			
			
				$rsmswselfmedphy  += 50;
			
			}
			elseif($kes == 2){
			
			
				$rsmswselfmedphy  += 50;
			
			}




	}else if( $valuee ==3 ){

		$mswselfhrm += 1;


		if($kes == 0){

			$rsmswselfhrm  += 500;
			
			}elseif($kes == 1){
			
			
				$rsmswselfhrm  += 50;
			
			}
			elseif($kes == 2){
			
			
				$rsmswselfhrm  += 50;
			
			}




	}
	
}


}

$msw_aid_cm = $rsmswaidcm;
$msw_aid_mepy = $rsmswaidmedphy;
$msw_aid_hrm = $rsmswaidhrm;
$msw_self_cm = $rsmswselfcm;
$msw_self_mepy = $rsmswselfmedphy;
$msw_self_hrm = $rsmswselfhrm;

        $ugbsw = 0; 
		$ugbsc = 0; 
		$pgdipir = 0; 
		$pgdiphr = 0; 



			$ug_bsw = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",5)->where("applied_course_id",1)->get();
			$ugbsw = $ug_bsw->num_rows();

			$ug_bsc = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",5)->where("applied_course_id",2)->get();
			$ugbsc = $ug_bsc->num_rows();

			$pg_dip_ir = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",4)->where("applied_course_id",10)->get();
			$pgdipir = $pg_dip_ir->num_rows();

			$pg_dip_hr = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",4)->where("applied_course_id",11)->get();
			$pgdiphr = $pg_dip_hr->num_rows();


		$ugbsw1 = $ugbsw * 350;
		$ugbsc1 = $ugbsc * 350;
		$pgdipir1 = $pgdipir * 500;
		$pgdiphr1 = $pgdiphr * 500;		

		
		$total=$mahrm1+$mahrmod1+$mase1+$madm1+$msccp1+$mswde1+$msw_aid_cm+$msw_aid_mepy+$msw_aid_hrm+$msw_self_cm+$msw_self_mepy+$msw_self_hrm+$ugbsw1+$ugbsc1+$pgdipir1+$pgdiphr1;
//object of the Spreadsheet class to create the excel data
$spreadsheet = new Spreadsheet();

//add some data in excel cells
$spreadsheet->setActiveSheetIndex(0)
 ->setCellValue('A1', 'MADRAS SCHOOL OF SOCIAL WORK')
 ->setCellValue('A3', 'Admission 2021')
 ->setCellValue('A4', 'Application Fees as on '.$date.'');
$spreadsheet->setActiveSheetIndex(0)
 ->setCellValue('A6', 'S.No')
 ->setCellValue('B6', 'Program Name')
 ->setCellValue('C6', 'Fees');

$spreadsheet->setActiveSheetIndex(0)
 ->setCellValue('B7', 'UG');
 
$spreadsheet->setActiveSheetIndex(0)
 ->setCellValue('A8', '1')
 ->setCellValue('B8', 'B.S.W (SF)')
 ->setCellValue('C8', ''.$ugbsw1.'')
 ->setCellValue('A9', '2')
 ->setCellValue('B9', 'B.Sc Psychology (SF)')
 ->setCellValue('C9', ''.$ugbsc1.'')
 ->setCellValue('B11', 'PG')
 ->setCellValue('B12', 'MSW Aided')
 ->setCellValue('A13', '3')
 ->setCellValue('B13', 'MSW Community Development')
 ->setCellValue('C13', ''.$msw_aid_cm.'')
 ->setCellValue('A14', '4')
 ->setCellValue('B14', 'MSW Medical & Psychiatric Social Work')
 ->setCellValue('C14', ''.$msw_aid_mepy.'')
 ->setCellValue('A15', '5')
 ->setCellValue('B15', 'MSW Human Resource Management')
 ->setCellValue('C15', ''.$msw_aid_hrm.'')
 ->setCellValue('B17', 'Self Finance')
 ->setCellValue('A18', '6')
 ->setCellValue('B18', 'MAHRM')
 ->setCellValue('C18', ''.$mahrm1.'')
 ->setCellValue('A19', '7')
 ->setCellValue('B19', 'MAHRMOD')
 ->setCellValue('C19', ''.$mahrmod1.'')
 ->setCellValue('A20', '8')
 ->setCellValue('B20', 'MASE')
 ->setCellValue('C20', ''.$mase1.'')
 ->setCellValue('A21', '9')
 ->setCellValue('B21', 'MADM')
 ->setCellValue('C21', ''.$madm1.'')
 ->setCellValue('A22', '10')
 ->setCellValue('B22', 'M.SC CP')
 ->setCellValue('C22', ''.$msccp1.'')
 ->setCellValue('A23', '11')
 ->setCellValue('B23', 'MSWDE')
 ->setCellValue('C23', ''.$mswde1.'')
 ->setCellValue('A24', '12')
 ->setCellValue('B24', 'MSW Community Development')
 ->setCellValue('C24', ''.$msw_self_cm.'')
 ->setCellValue('A25', '13')
 ->setCellValue('B25', 'MSW Medical & Psychiatric Social Work')
 ->setCellValue('C25', ''.$msw_self_mepy.'')
 ->setCellValue('A26', '14')
 ->setCellValue('B26', 'MSW Human Resource Management')
 ->setCellValue('C26', ''.$msw_self_hrm.'')
 ->setCellValue('B28', 'PG-Diploma')
 ->setCellValue('A29', '15')
 ->setCellValue('B29', 'Personnel Management & Industrial Relations (SF)')
 ->setCellValue('C29', ''.$pgdipir1.'')
 ->setCellValue('A30', '16')
 ->setCellValue('B30', 'Human Resource Management (SF)')
 ->setCellValue('C30', ''.$pgdiphr1.'')
 ->setCellValue('B32', 'Total')
 ->setCellValue('C32', ''.$total.'');

//set style for A1,B1,C1 cells
/*$cell_st =[
 'font' =>['bold' => true],
 'fill' =>['type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'color' => ['rgb' => 'FFE699']],
 'alignment' =>['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
 'borders'=>['bottom' =>['style'=> \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM]]
];*/
$cell_st = array(
            'font' => array(
			 'bold' => true,
			),
            'alignment' => array(
              'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
              'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                  ),
            'borders' => array(
                'outline' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => array('argb' => '00000000'),
                ),
            ),
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => 'EBF5FB')
            )
        );	
$spreadsheet->getActiveSheet()->mergeCells('A1:C1');
$spreadsheet->getActiveSheet()->getStyle('A1:C1')->applyFromArray($cell_st);
$spreadsheet->getActiveSheet()->mergeCells('A3:C3');
$spreadsheet->getActiveSheet()->getStyle('A3:C3')->applyFromArray(array('alignment' => $cell_st['alignment']));
$spreadsheet->getActiveSheet()->mergeCells('A4:C4');
$spreadsheet->getActiveSheet()->getStyle('A4:C4')->applyFromArray(array('alignment' => $cell_st['alignment']));
$spreadsheet->getActiveSheet()->getStyle('A3')->applyFromArray(array('font' => $cell_st['font']));
$spreadsheet->getActiveSheet()->getStyle('A4')->applyFromArray(array('font' => $cell_st['font']));
$spreadsheet->getActiveSheet()->getStyle('A6')->applyFromArray(array('font' => $cell_st['font'], 'alignment' => $cell_st['alignment']));
$spreadsheet->getActiveSheet()->getStyle('B6')->applyFromArray(array('font' => $cell_st['font'], 'alignment' => $cell_st['alignment']));
$spreadsheet->getActiveSheet()->getStyle('C6')->applyFromArray(array('font' => $cell_st['font'], 'alignment' => $cell_st['alignment']));
$spreadsheet->getActiveSheet()->getStyle('B7')->applyFromArray(array('font' => $cell_st['font'], 'alignment' => $cell_st['alignment']));
$spreadsheet->getActiveSheet()->getStyle('B11')->applyFromArray(array('font' => $cell_st['font'], 'alignment' => $cell_st['alignment']));
$spreadsheet->getActiveSheet()->getStyle('B12')->applyFromArray(array('font' => $cell_st['font']));
$spreadsheet->getActiveSheet()->getStyle('B17')->applyFromArray(array('font' => $cell_st['font']));
$spreadsheet->getActiveSheet()->getStyle('B28')->applyFromArray(array('font' => $cell_st['font'], 'alignment' => $cell_st['alignment']));
$spreadsheet->getActiveSheet()->getStyle('B32')->applyFromArray(array('font' => $cell_st['font']));
$spreadsheet->getActiveSheet()->getStyle('C32')->applyFromArray(array('font' => $cell_st['font']));

//set columns width
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(16);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(18);

$spreadsheet->getActiveSheet()->setTitle('Simple'); //set a title for Worksheet

//make object of the Xlsx class to save the excel file
$writer = new Xlsx($spreadsheet);
$fxls ='ApplicationFees_'.$date.'.xlsx';
        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="'. $fxls .'"'); 
        header('Cache-Control: max-age=0');
        $writer->save('php://output');	// download file 		
    } 	

public function applicationFeesPdf(){
	
	date_default_timezone_get();
	$date=date('d-M-Y');
	$mahrm = 0; 
		$mahrmod = 0; 
		$mase = 0; 
		$madm = 0; 
		$msccp = 0; 
		$mswde = 0; 



			$m = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",1)->where("applied_course_id",5)->get();
			$mahrm = $m->num_rows();

			$mod = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",1)->where("applied_course_id",6)->get();
			$mahrmod = $mod->num_rows();

			$mse = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",1)->where("applied_course_id",7)->get();
			$mase = $mse->num_rows();

			$mdm = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",1)->where("applied_course_id",8)->get();
			$madm = $mdm->num_rows();

			$mscc = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",1)->where("applied_course_id",9)->get();
			$msccp = $mscc->num_rows();

			$mde = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",1)->where("applied_course_id",15)->get();
			$mswde = $mde->num_rows();


		$data['mahrm1'] = $mahrm1 = $mahrm * 500;
		$data['mahrmod1'] = $mahrmod1 = $mahrmod * 500;
		$data['mase1'] = $mase1 = $mase * 500;
		$data['madm1'] = $madm1 = $madm * 500;
		$data['msccp1'] = $msccp1 = $msccp * 500;
		$data['mswde1'] = $mswde1 = $mswde * 500;


$mswaidcm=0;
$mswaidmedphy=0;
$mswaidhrm=0;


$rsmswaidcm  =0;
$rsmswaidmedphy=0;
$rsmswaidhrm=0;


$mswselfcm=0;
$mswselfmedphy=0;
$mswselfhrm=0;


$rsmswselfcm  =0;
$rsmswselfmedphy=0;
$rsmswselfhrm=0;


		$q = $this->db->select("*")->from("Applyed_Master")->where("main_course_priority","PG")->get();


		$s = $q->result();



foreach ($s as $key => $value) {


	$m = $this->db->select("*")->from("Applyed_Cources")->where("master_id",$value->id)->get();
$ran = $m->result();



	$myArray = explode(',', $value->pg_mssw_aided);
	//print_r($myArray);
foreach ($myArray as $kes =>  $valuee) {
	if ( $valuee == 1)
	{
		 $mswaidcm += 1; 

if($kes == 0){

$rsmswaidcm  += 500;

}elseif($kes == 1){


	$rsmswaidcm  += 50;

}
elseif($kes == 2){


	$rsmswaidcm  += 50;

}



	}else if( $valuee ==2 ){

		$mswaidmedphy += 1;


		if($kes == 0){

			$rsmswaidmedphy  += 500;
			
			}elseif($kes == 1){
			
			
				$rsmswaidmedphy  += 50;
			
			}
			elseif($kes == 2){
			
			
				$rsmswaidmedphy  += 50;
			
			}




	}else if( $valuee ==3 ){

		$mswaidhrm += 1;


		if($kes == 0){

			$rsmswaidhrm  += 500;
			
			}elseif($kes == 1){
			
			
				$rsmswaidhrm  += 50;
			
			}
			elseif($kes == 2){
			
			
				$rsmswaidhrm  += 50;
			
			}




	}
	
}



$myArraySelf = explode(',', $value->pg_mssw_self);



foreach ($myArraySelf as $kes =>  $valuee) {
	if ( $valuee == 1)
	{
		 $mswselfcm += 1; 

if($kes == 0){

$rsmswselfcm  += 500;

}elseif($kes == 1){


	$rsmswselfcm  += 50;

}
elseif($kes == 2){


	$rsmswselfcm  += 50;

}



	}else if( $valuee ==2 ){

		$mswselfmedphy += 1;


		if($kes == 0){

			$rsmswselfmedphy  += 500;
			
			}elseif($kes == 1){
			
			
				$rsmswselfmedphy  += 50;
			
			}
			elseif($kes == 2){
			
			
				$rsmswselfmedphy  += 50;
			
			}




	}else if( $valuee ==3 ){

		$mswselfhrm += 1;


		if($kes == 0){

			$rsmswselfhrm  += 500;
			
			}elseif($kes == 1){
			
			
				$rsmswselfhrm  += 50;
			
			}
			elseif($kes == 2){
			
			
				$rsmswselfhrm  += 50;
			
			}




	}
	
}


}

$data['msw_aid_cm'] = $msw_aid_cm = $rsmswaidcm;
$data['msw_aid_mepy'] = $msw_aid_mepy = $rsmswaidmedphy;
$data['msw_aid_hrm'] = $msw_aid_hrm = $rsmswaidhrm;
$data['msw_self_cm'] = $msw_self_cm = $rsmswselfcm;
$data['msw_self_mepy'] = $msw_self_mepy = $rsmswselfmedphy;
$data['msw_self_hrm'] = $msw_self_hrm = $rsmswselfhrm;

        $ugbsw = 0; 
		$ugbsc = 0; 
		$pgdipir = 0; 
		$pgdiphr = 0; 



			$ug_bsw = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",5)->where("applied_course_id",1)->get();
			$ugbsw = $ug_bsw->num_rows();

			$ug_bsc = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",5)->where("applied_course_id",2)->get();
			$ugbsc = $ug_bsc->num_rows();

			$pg_dip_ir = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",4)->where("applied_course_id",10)->get();
			$pgdipir = $pg_dip_ir->num_rows();

			$pg_dip_hr = $this->db->select("*")->from("Applyed_Cources")->where("main_course_id",4)->where("applied_course_id",11)->get();
			$pgdiphr = $pg_dip_hr->num_rows();


		$data['ugbsw1'] = $ugbsw1 = $ugbsw * 350;
		$data['ugbsc1'] = $ugbsc1 = $ugbsc * 350;
		$data['pgdipir1'] = $pgdipir1 = $pgdipir * 500;
		$data['pgdiphr1'] = $pgdiphr1 = $pgdiphr * 500;
		
			$data['total']=$mahrm1+$mahrmod1+$mase1+$madm1+$msccp1+$mswde1+$msw_aid_cm+$msw_aid_mepy+$msw_aid_hrm+$msw_self_cm+$msw_self_mepy+$msw_self_hrm+$ugbsw1+$ugbsc1+$pgdipir1+$pgdiphr1;		
			
			$this->load->library('pdf');
        $html = $this->load->view('admin/app_fees_pdf', $data, true);
        //$this->pdf->createPDF($html, 'mypdf', false);
		// Get output html
		
		$options = new Options();
        $options->set('isRemoteEnabled', TRUE);

        $dompdf = new \Dompdf\Dompdf($options);
		$contxt = stream_context_create([ 
    'ssl' => [ 
        'verify_peer' => FALSE, 
        'verify_peer_name' => FALSE,
        'allow_self_signed'=> TRUE
             ] 
       ]);
        $dompdf->setHttpContext($contxt);
        $dompdf->load_html($html, 'mypdf', false); 
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
		ob_end_clean();
        $dompdf->stream("ApplicationFees_".$date.".pdf", array("Attachment"=>1));
			//$dompdf->load_html($html);
			//$dompdf->render();
			
			//$dompdf->stream('ApplicationFees_'.$date.'.pdf', array("Attachment" => false));
			
        //$this->load->view("admin/app_fees_pdf", $data);
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
            ->from("new_preview_pg")
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

        redirect("admin/StudentAppliedCources", "refresh");
    }	

public function updateStuContactInfo()
    {
        $this->load->view("template/admin/header");
        $this->load->view("template/admin/menubar");
        $this->load->view("template/admin/headerbar");
        $this->load->view("admin/update_personal");
        $this->load->view("template/admin/footer");
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
                "admin/updateStuContactInfo/" . $student_id,
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
                "admin/updateStuContactInfo/" . $student_id,
                "refresh"
            );
        }
    }

public function updateStudent()
    {
        $user_id = $this->uri->segment(3);
        $app_course_id = $this->uri->segment(4);
        $m_course = "2";

        $q = $this->db
            ->select("*")
            ->from("college_course")
            ->where("mc_id", $m_course)
            ->get();
        $pr_user = $this->db
            ->select("*")
            ->from("new_preview_pg")
            ->where("pr_user_id", $user_id)
            ->get();
        $pr_study = $this->db
            ->select("*")
            ->from("sub_preview_pg")
            ->where("sb_u_id", $user_id)
            ->get();

        $pr_study_app = $this->db
            ->select("*")
            ->from("Applyed_Cources")
            ->where("user_id", $user_id)
            ->where("main_course_id", 1)
            ->where(
                "applied_course_id",
                $app_course_id
            )
            ->get();

        $data["cdetails"] = $pr_study_app->result();
        $data["cc"] = $q->result();
        $data["user"] = $pr_user->result();
        $data["Study"] = $pr_study->result();

        $this->load->view("template/admin/header");
        $this->load->view("template/admin/menubar");
        $this->load->view("template/admin/headerbar");
        $this->load->view("admin/basicdetails_pg", $data);
        $this->load->view("template/admin/footer");
    }

public function SaveApplicationPg()
    {
        //print_r($_POST);

        $user_id = $this->uri->segment(3);

        $candidate_name = $this->input->post("candidate_name");

        $course_msw_aided = $this->input->post("msw_aided");
        $course_aided = implode(",", (array) $course_msw_aided);

        $course_msw_self = $this->input->post("msw_self_finance");
        $course_self = implode(",", (array) $course_msw_self);

        $course_one = $this->input->post("course_one");
        $course_pg = implode(",", (array) $course_one);

        $course_two = $this->input->post("course_two");
        $course_three = $this->input->post("course_three");
        $language_offered = $this->input->post("language_offered");
        $dob = $this->input->post("dob");
        $age = $this->input->post("age");
        $m_tounge = $this->input->post("m_tounge");
        $place_of_birth = $this->input->post("place_of_birth");
        $gender = $this->input->post("gender");
        $Nationality = $this->input->post("Nationality");

        //new --entery //
        $country = $this->input->post("country");
        $passportnumber = $this->input->post("passportnumber");
        $pp_exp = $this->input->post("pp_exp");
        $blood_group = $this->input->post("blood_group");

        $Religion = $this->input->post("Religion");
        $Caste = $this->input->post("Caste");
        $Community = $this->input->post("Community");
        $father_name = $this->input->post("father_name");
        $mother_name = $this->input->post("mother_name");
        $guardion_name = $this->input->post("guardion_name");
        $father_mob_num = $this->input->post("father_mob_num");
        $mother_mob_num = $this->input->post("mother_mob_num");
        $guardion_mob_num = $this->input->post("guardion_mob_num");

        //new --entery //
        $father_email = $this->input->post("father_email");
        $mother_email = $this->input->post("mother_email");
        $guardion_email = $this->input->post("guardion_email");
        $other_res = $this->input->post("other_res");
        $other_special_reservation = $this->input->post(
            "other_special_reservation"
        );
        $hostel = $this->input->post("hostel");

        $father_accupation = $this->input->post("father_accupation");
        $mother_accupation = $this->input->post("mother_accupation");
        $guardion_accupation = $this->input->post("guardion_accupation");
        $father_anuval_income = $this->input->post("father_anuval_income");
        $mother_anuval_income = $this->input->post("mother_anuval_income");
        $guardion_anuval_income = $this->input->post("guardion_anuval_income");
        $local_address = $this->input->post("local_address");
        $local_area = $this->input->post("local_area");
        $local_city = $this->input->post("local_city");
        $local_state = $this->input->post("local_state");
        $local_country = $this->input->post("local_country");
        $local_pincode = $this->input->post("local_pincode");
        $pr_address = $this->input->post("pr_address");
        $pr_area = $this->input->post("pr_area");
        $pr_city = $this->input->post("pr_city");
        $pr_state = $this->input->post("pr_state");
        $pr_country = $this->input->post("pr_country");
        $pr_pincode = $this->input->post("pr_pincode");
        $identification_one = $this->input->post("identification_one");
        $identification_two = $this->input->post("identification_two");
        $abled = $this->input->post("abled");
        $abled_reason = $this->input->post("abled_reason");

        $sports_name = $this->input->post("sports_name");
        $sports_psition = $this->input->post("sports_psition");
        $extra_caricular_activities = $this->input->post(
            "extra_caricular_activities"
        );
        $acknoledgement = $this->input->post("acknoledgement");

        $update_details = [
            "pr_applicant_name" => $candidate_name,

            "pr_language" => $language_offered,
            "pr_dob" => $dob,
            "pr_age" => $age,
            "pr_mother_toung" => $m_tounge,
            "pr_place_of_birth" => $place_of_birth,
            "pr_gender" => $gender,
            "pr_nationality" => $Nationality,
            "pr_country" => $country,
            "pr_passportnumber" => $passportnumber,
            "pr_pp_exp" => $pp_exp,
            "pr_blood_group" => $blood_group,
            "pr_religion" => $Religion,
            "pr_caste" => $Caste,
            "pr_community" => $Community,

            "pr_father_name" => $father_name,
            "pr_mother_name" => $mother_name,
            "pr_gaurdion_name" => $guardion_name,
            "pr_father_mobnum" => $father_mob_num,
            "pr_mother_mobnum" => $mother_mob_num,
            "pr_gaurdion_mobnum" => $guardion_mob_num,

            "pr_father_email" => $father_email,
            "pr_mother_email" => $mother_email,
            "pr_gaurdion_email" => $guardion_email,

            "pr_father_anuval_income" => $father_anuval_income,
            "pr_mother_anuval_income" => $mother_anuval_income,
            "pr_gaurdion_anuval_income" => $guardion_anuval_income,
            "pr_father_accu" => $father_accupation,
            "pr_mother_accu" => $mother_accupation,
            "pr_gaurdion_accu" => $guardion_accupation,
            "pr_local_address" => $local_address,
            "pr_local_area" => $local_area,
            "pr_local_city" => $local_city,
            "pr_local_state" => $local_state,
            "pr_local_country" => $local_country,
            "pr_local_pincode" => $local_pincode,
            "pr_permanent_address" => $pr_address,
            "pr_permanent_area" => $pr_area,
            "pr_permanent_city" => $pr_city,
            "pr_permanent_state" => $pr_state,
            "pr_permanent_country" => $pr_country,
            "pr_permanent_pincode" => $pr_pincode,
            "pr_identification_one" => $identification_one,
            "pr_identification_two" => $identification_two,
            "pr_differently_abled" => $abled,
            "pr_differently_abled_reson" => $abled_reason,
            "pr_name_of_game" => $sports_name,
            "pr_game_position" => $sports_psition,
            "pr_extra_caricular_act" => $extra_caricular_activities,
            "pr_acknoledge" => $acknoledgement,
            "pr_other_res" => $other_res,
            "pr_other_special_reservation" => $other_special_reservation,
            "pr_hostel" => $hostel,
        ];

        //Markdheet details
        //$candidate_name = $this->input->post('candidate_name');

        $sslc = $this->input->post("sslc");
        $plus_one = $this->input->post("plus_one");
        $plus_two = $this->input->post("plus_two");
        $ug = $this->input->post("ug");

        $sslc_ins = $this->input->post("sslc_ins");
        $plus_one_ins = $this->input->post("plus_one_ins");
        $plus_two_ins = $this->input->post("plus_two_ins");
        $ug_ins = $this->input->post("ug_ins");

        $sslc_max_mark = $this->input->post("sslc_max_mark");
        $sslc_mark_obtain = $this->input->post("sslc_mark_obtain");
        $sslc_grade = $this->input->post("sslc_grade");
        $sslc_percentage = $this->input->post("sslc_percentage");

        $plus_one_max_mark = $this->input->post("plus_one_max_mark");
        $plus_one_mark_obtain = $this->input->post("plus_one_mark_obtain");
        $plus_one_grade = $this->input->post("plus_one_grade");
        $plus_one_percentage = $this->input->post("plus_one_percentage");

        $plus_two_max_mark = $this->input->post("plus_two_max_mark");
        $plus_two_mark_obtain = $this->input->post("plus_two_mark_obtain");
        $plus_two_grade = $this->input->post("plus_two_grade");
        $plus_two_percentage = $this->input->post("plus_two_percentage");

        $UG_max_mark = $this->input->post("UG_max_mark");
        $UG_mark_obtain = $this->input->post("UG_mark_obtain");
        $UG_grade = $this->input->post("UG_grade");
        $UG_two_percentage = $this->input->post("UG_two_percentage");

        $subject_mark = [
            "sslc_subject" => $sslc,
            "sslc_max_mark" => $sslc_max_mark,
            "sslc_mark_obtain" => $sslc_mark_obtain,
            "sslc_grade" => $sslc_grade,
            "sslc_percentage" => $sslc_percentage,

            "plus_one_subject" => $plus_one,
            "plus_one_max_mark" => $plus_one_max_mark,
            "plus_one_mark_obtain" => $plus_one_mark_obtain,
            "plus_one_grade" => $plus_one_grade,
            "plus_one_percentage" => $plus_one_percentage,

            "plus_two_subjec" => $plus_two,
            "plus_two_max_mark" => $plus_two_max_mark,
            "plus_two_mark_obtain" => $plus_two_mark_obtain,
            "plus_two_grade" => $plus_two_grade,
            "plus_two_percentage" => $plus_two_percentage,

            "UG_subject" => $ug,
            "UG_max_mark" => $UG_max_mark,
            "UG_mark_obtain" => $UG_mark_obtain,
            "UG_grade" => $UG_grade,
            "UG_two_percentage" => $UG_two_percentage,

            "sslc_institution" => $sslc_ins,
            "plus_one_institution" => $plus_one_ins,
            "plus_two_institution" => $plus_two_ins,
            "ug_institution" => $ug_ins,
        ];

        $this->db->where("pr_user_id", $user_id);
        $this->db->update("new_preview_pg", $update_details);

        $this->db->where("sb_u_id", $user_id);
        $this->db->update("sub_preview_pg", $subject_mark);

        $this->session->set_flashdata(
            "message",
            ' <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success !</strong> Update Student Record Successfully .
            </div>'
        );

        redirect("admin/updateStudent/" . $user_id, "refresh");
    }	
	
	public function studentNotApplied(){

		$stu_appl = $this->db->select('*')->from('Applyed_Master')->get()->result();
		$stu_id = array_column($stu_appl, 'user_id');
		$data['studentnotapplied'] = $this->db->select('*')->from('stu_user')->where_not_in('u_id',$stu_id)->get()->result();
		
				$this->load->view('template/admin/header');
				$this->load->view('template/admin/menubar');
				$this->load->view('template/admin/headerbar');
				$this->load->view('admin/studentnotapplied',$data);
				$this->load->view('template/admin/footer');
			
		}


public function UploadImageNot(){

	$anc = $this->db->select('*')->from("digital_board_announcement")->get();
	$data['announcements'] = $anc->result();

	$not = $this->db->select('*')->from("digital_board_notification")->get();
	$data['notification'] = $not->result();

	$gal = $this->db->select('*')->from("digital_board_image")->get();
	$data['gallery'] = $gal->result();
	
	
	$vid = $this->db->select('*')->from("digital_board_video")->get();
	$data['videos'] = $vid->result();

	$data['error']="";
		$this->load->view('template/admin/header');
		$this->load->view('template/admin/menubar');
		$this->load->view('template/admin/headerbar');
		$this->load->view('admin/digitalbord',$data);
		$this->load->view('template/admin/footer');

}

public function announcementAdd(){

		$data = array(
			'content'=>$_POST['announcement'],
		);

$this->db->insert("digital_board_announcement",$data);
$this->session->set_flashdata(
	"message",
	' <div class="alert alert-success alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Success !</strong> Update Student Record Successfully .
	</div>'
);

redirect("Admin/UploadImageNot/" , "refresh");
}

public function anunsStatus(){

		$n = $this->db->select("*")->from("digital_board_announcement")->where("an_id",$_POST['id'])->get();
		$getr = $n->result();

		if($getr[0]->status == 1){
		$data = array(
			'status'=>0,
		);
		}else{
			$data = array(
				'status'=>1,
			);	
		}
		$this->db->where("an_id",$_POST['id']);
		$this->db->update("digital_board_announcement",$data);
}
	
public function imageStatus(){

		$n = $this->db->select("*")->from("digital_board_image")->where("i_id",$_POST['id'])->get();
		$getr = $n->result();

		if($getr[0]->image_status == 1){
		$data = array(
			'image_status'=>0,
		);
		}else{
			$data = array(
				'image_status'=>1,
			);	
		}
		$this->db->where("i_id",$_POST['id']);
		$this->db->update("digital_board_image",$data);
}

	
public function notiStatus(){


		$n = $this->db->select("*")->from("digital_board_notification")->where("db_n_id",$_POST['id'])->get();
		$getr = $n->result();

		if($getr[0]->status == 1){
		$data = array(
			'status'=>0,
		);
		}else{
		$data = array(
				'status'=>1,
		);	
		}
	
		$this->db->where("db_n_id",$_POST['id']);
		$this->db->update("digital_board_notification",$data);
}
public function videoStatus(){


		$n = $this->db->select("*")->from("digital_board_video")->where("v_id",$_POST['id'])->get();
		$getr = $n->result();

		if($getr[0]->status == 1){
		$data = array(
			'status'=>0,
		);
		}else{
		$data = array(
				'status'=>1,
		);	
		}
	
		$this->db->where("v_id",$_POST['id']);
		$this->db->update("digital_board_video",$data);
}

public function anunsDelete(){

			$this->db->where("an_id",$_POST['id']);
     		$this->db->delete("digital_board_announcement");
}	
public function notisDelete(){

		$this->db->where("db_n_id",$_POST['id']);
		$this->db->delete("digital_board_notification");
		
}public function galleryDelete(){

		$this->db->where("i_id",$_POST['id']);
		$this->db->delete("digital_board_image");
		
}public function videoDelete(){

		$this->db->where("v_id",$_POST['id']);
		$this->db->delete("digital_board_video");
		
}
public function notificationAdd(){

				$data = array(
					'title'=>$_POST['title'],
					'start_date'=>$_POST['startdate'],
					'end_date'=>$_POST['enddate'],
					'start_time'=>$_POST['starttime'],
					'end_time'=>$_POST['endtime'],
					'discription'=>$_POST['discription'],
					
				);
		$this->db->insert("digital_board_notification",$data);
		$this->session->set_flashdata(
			"message",
			' <div class="alert alert-success alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Success !</strong> Update Student Record Successfully .
			</div>'
		);
		
		redirect("Admin/UploadImageNot/" , "refresh");
}
public function digitalImageAdd(){

                $config['upload_path']          = 'digitalBanner/';
                $config['allowed_types']        = 'gif|jpg|png';
				$config['max_size']             = 10024;
                $config['max_width']            = 1260;
                $config['max_height']           = 500;
				$config['remove_spaces'] = TRUE;
				$config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);
				$this->upload->initialize($config);
                if ( ! $this->upload->do_upload('userfile'))
                {
                       // $data['error'] = array('error' => $this->upload->display_errors());

					//print_r($data);
					$this->session->set_flashdata(
						"message",
						'<div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Failed !</strong> Failed to insert Image .
						</div>'
					);
	
					redirect("Admin/UploadImageNot/" , "refresh");
                }else{

					$file_data = $this->upload->data();

					$file_name = $file_data['file_name'];			
					$inset = array(
						'image_name'=>$file_name,
					);

					//print_r($file_name);
				 	$this->db->insert("digital_board_image",$inset);
  				    $this->session->set_flashdata(
						"message",
						'<div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Success !</strong> Insert Record Successfully .
						</div>'
					);
					
					redirect("Admin/UploadImageNot/" , "refresh"); 

				}
 }public function videoAdd(){

                $config['upload_path']          = 'digitalBanner/';
                $config['allowed_types']        = 'mp4';
				$config['max_size']             = 10024;
                $config['max_width']            = 6000;
                $config['max_height']           = 6000;
				$config['remove_spaces'] = TRUE;
				$config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);
				$this->upload->initialize($config);
                if ( ! $this->upload->do_upload('image'))
                {
                       // $data['error'] = array('error' => $this->upload->display_errors());

					//print_r($data);
					$this->session->set_flashdata(
						"message",
						'<div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Failed !</strong> Failed to insert Image .
						</div>'
					);
	
					redirect("Admin/UploadImageNot/" , "refresh");
                }else{

					$file_data = $this->upload->data();

					$file_name = $file_data['file_name'];			
					$inset = array(
						'v_text'=>$_POST['title'],
						'v_video_name'=>$file_name,
					);

					//print_r($file_name);
				 	$this->db->insert("digital_board_video",$inset);
  				    $this->session->set_flashdata(
						"message",
						'<div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Success !</strong> Insert Record Successfully .
						</div>'
					);
					
					redirect("Admin/UploadImageNot/" , "refresh"); 

				}
 }
public function excelImport($main_cour_id,$app_cour_id){



	$main_cour_id = $this->uri->segment(3);
	$app_cour_id = $this->uri->segment(4);
	
	
	
		/*$ma_dm=$this->db->select("user_id")->from("Applyed_Cources")->where("main_course_id",$main_cour_id)->where("applied_course_id",$app_cour_id)->get();
	 	$applied_ma_dm =$ma_dm->result_array();
			$arrma_dm = array_column($applied_ma_dm, "user_id");
			if( sizeof($arrma_dm) == 0 ){
			$arrma_dm = array('0');}
	 */
		
			$this->db->select('stu_user.*,Applyed_Cources.*,new_preview_pg.*,sub_preview_pg.*,student_complete_mark.personal_mark');
			$this->db->from('Applyed_Cources');
			$this->db->join('stu_user', 'Applyed_Cources.user_id=stu_user.u_id','right');
			$this->db->join('new_preview_pg', 'Applyed_Cources.user_id=new_preview_pg.pr_user_id','right');
			$this->db->join('sub_preview_pg', 'Applyed_Cources.user_id=sub_preview_pg.sb_u_id','right');
			$this->db->join('student_complete_mark', 'Applyed_Cources.main_course_id=student_complete_mark.main_course_id and Applyed_Cources.applied_course_id=student_complete_mark.app_course_id and Applyed_Cources.user_id=student_complete_mark.stu_id','left');
			$this->db->where('Applyed_Cources.main_course_id',$main_cour_id);
			$this->db->where('Applyed_Cources.applied_course_id',$app_cour_id);
		//	$this->db->where_in("Applyed_Cources.user_id",$arrma_dm );
			$st_dm =	$this->db->get();
		
			$data['applied'] = $st_dm->result();
			$data['course'] = 2;
	
		
	
			switch ($app_cour_id) {
	
				case "1":
			$data['subject']='MSW SELF FIN';
			$data['department']='Community Development';
				break;
				case "2":
					$data['subject']='MSW SELF FIN';
					$data['department']='Medical & Psychiatric Social Work';
				break;
				case "3":
					$data['subject']='MSW SELF FIN';
					$data['department']='Human Resource Management';
				break;
			
	
			  default:
			  $data['subject']='MSW';
			  $data['department']='';
			}	
			
/* 			switch ($app_cour_id) {
	
				case "1":
			$data['subject']='MSW AIDED';
			$data['department']='Community Development';
				break;
				case "2":
					$data['subject']='MSW AIDED';
					$data['department']='Medical & Psychiatric Social Work';
				break;
				case "3":
					$data['subject']='MSW AIDED';
					$data['department']='Human Resource Management';
				break;
			
	
			  default:
			  $data['subject']='MSW';
			  $data['department']='';
			}
			 */
			
			
			
			
			
			/* 		switch ($app_cour_id) {
	
				case "5":
			$data['subject']='MAHRM';
			$data['department']='M.A. Human Resource Management (SF)';
				break;
				case "6":
					$data['subject']='MAHRM';
					$data['department']='M.A. Human Resource And Organization Development (SF)';
				break;
				case "7":
					$data['subject']='MASE';
					$data['department']='M.A. Social Entrepreneurship (SF)';
				break;
				case "8":
					$data['subject']='MADM';
					$data['department']='M.A. Development Management (SF)';
				break;
				case "9":
					$data['subject']='MSCCF';
					$data['department']='M.Sc. Counselling Psychology (SF)';
				break;
				case "15":
					$data['subject']='MSW';
					$data['department']='M.S.W. Disability and Empowerment (SF)';
				break;
	
			  default:
			  $data['subject']='MSW';
			  $data['department']='';
			} */
	
	
			$this->load->view('template/admin/header');
			$this->load->view('template/admin/menubar');
			$this->load->view('template/admin/headerbar');
			//$this->load->view('admin/student_applied',$data);
			$this->load->view('admin/student_export',$data);
			$this->load->view('template/admin/footer',$data);
		

}public function importExcelUg(){

	//$main_cour_id = $this->uri->segment(3);
	$app_cour_id = $this->uri->segment(3);

	switch ($app_cour_id) {
	
		case "1":
	$data['subject']='U.G.-B.S.W';
	$data['department']='Bachelor of Social Work (SF)';
		break;
		case "2":
			$data['subject']='U.G.-B.Sc';
			$data['department']='B.Sc Psychology (SF)';
		break;
	

	  default:
	  $data['subject']='MSW';
	  $data['department']='';
	}	


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
   ->where("Applyed_Cources.main_course_id",5)
   ->where("Applyed_Cources.applied_course_id",$app_cour_id)
   ->get();
   
   $data['count'] =$user->num_rows();
		  $data['student'] =$user->result();

		  $data['title'] = "Reports of Student Applied ".$this->session->userdata('user')['user_name']." ".date('d-M-Y');
	   
			$this->load->view('template/admin/header');
		   $this->load->view('template/admin/menubar');
		   $this->load->view('template/admin/headerbar');
		   $this->load->view('admin/student_export_ug',$data);
		   $this->load->view('template/admin/footer',$data); 
}
		
}