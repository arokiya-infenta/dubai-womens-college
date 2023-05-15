<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Dompdf\Dompdf;
use Dompdf\Options;  
class MswAided extends CI_Controller {
	public $Subject;
	public $asyear;
  public $aeyear;
	public $syear;
  public $eyear;
	public $department_name;
   public $acoursedate;

	public function __construct()
	{
		parent::__construct();
	//  error_reporting(0);
	  date_default_timezone_set("Asia/Calcutta");
	  $this->load->library('upload');
	  $this->load->config('email');
		$this->load->library('email');
		$this->load->library('form_validation');
	  
		$this->load->library('pdf');
		$this->Subject = "MSW"; 
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

		if ($this->session->user != "" || $this->session->user != null) {
            if ($this->session->userdata("user")["user_dep_status"] == 1) {
               
                $this->department_name = "MSW AIDED - Community Development";
            } elseif (
                $this->session->userdata("user")["user_dep_status"] == 2
            ) {
              
				$this->department_name = "MSW AIDED - Medical & Psychiatric Social Work";
            } elseif (
                $this->session->userdata("user")["user_dep_status"] == 3
            ) {
               
				$this->department_name = "MSW AIDED - Human Resource Management ";
            }  else {
                $this->Subject = "";
            }

        } else {
            redirect("Welcome/logOut", "refresh");
        }

	}
	
	public function rules_stu_comm(){
		 $config = array(
        array(
                'field' => 'community',
                'label' => 'Community',
                'rules' => 'required',
				'errors' => array(
                        'required' => 'You must provide a %s.',
						),
        ),
		array(
                'field' => 'link_id1',
                'label' => 'Zoom Link',
                'rules' => 'required',
				'errors' => array(
                        'required' => 'You must provide a %s.',
						),
        ),
		array(
                'field' => 'dpmnt',
                'label' => 'Department',
                'rules' => 'required',
				'errors' => array(
                        'required' => 'You must provide a %s.',
						),
        )
       );
     return $config;
	}
	public function rules_panel()
    {
        $config = [
            [
                "field" => "title",
                "label" => "Title",
                "rules" => "required",
                "errors" => [
                    "required" => "You must provide a %s.",
                ],
            ],
            [
                "field" => "start_date",
                "label" => "Date",
                "rules" => "required",
                "errors" => [
                    "required" => "You must provide a %s.",
                ],
            ],
			[
                "field" => "start_time",
                "label" => "Time",
                "rules" => "required",
                "errors" => [
                    "required" => "You must provide a %s.",
                ],
            ],
			[
                "field" => "venue",
                "label" => "Venue",
                "rules" => "required",
                "errors" => [
                    "required" => "You must provide a %s.",
                ],
            ],
        ];
        return $config;
    }

    public function index(){


$this->load->view('template/mswaided/header');
$this->load->view('template/mswaided/menubar');
$this->load->view('template/mswaided/headerbar');
$this->load->view('mswaided/dashbord');
$this->load->view('template/mswaided/footer');



    }
    public function NonAppliedStudent(){

$arr = [];


$sta =$this->db->select("user_id")->from("Applyed_Master")->where("main_course_priority","PG")->get();

$applied_stu =$sta->result_array();

$arr = array_column($applied_stu, "user_id");

$st =$this->db->select("*")->from("stu_user")->where("u_course",3)->where_not_in("u_id",$arr)->get();
$data['NonUser'] = $st->result();




        $this->load->view('template/mswaided/header');
        $this->load->view('template/mswaided/menubar');
        $this->load->view('template/mswaided/headerbar');
        $this->load->view('mswaided/NonApplideStudent',$data);
        $this->load->view('template/mswaided/footer'); 




    }

	public function SeatAllocation()
    {
        $std = $this->db
            ->select("*")
            ->from("resrvation_table")
            ->where("rc_main_id", 2)
            ->where(
                "rc_cource_id",
                $this->session->userdata("user")["user_dep_status"]
            )
            ->get();

        $data["reservation"] = $std->result();

        $this->load->view("template/mswaided/header");
        $this->load->view("template/mswaided/menubar");
        $this->load->view("template/mswaided/headerbar");
        $this->load->view("mswaided/seat_allocation", $data);
        $this->load->view("template/mswaided/footer");
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
$this->calculateMark();

        $std = $this->db
            ->select("*")
            ->from("resrvation_table")
            ->where("rc_main_id", 2)
            ->where(
                "rc_cource_id",
                $this->session->userdata("user")["user_dep_status"]
            )
            ->get();

        $data["reservation"] = $std->result();
        $this->load->view("template/mswaided/header");
        $this->load->view("template/mswaided/menubar");
        $this->load->view("template/mswaided/headerbar");
        $this->load->view("mswaided/temp_shot_list", $data);
        $this->load->view("template/mswaided/footer");
    }
	public function calculateMark()
    {
        $m = $this->db
            ->select("*")
            ->from("student_complete_mark")

            ->where("student_complete_mark.main_course_id", 2)
            ->where(
                "student_complete_mark.app_course_id",
                $this->session->userdata("user")["user_dep_status"]
            )
            ->get();
        $rs = $m->result();

        foreach ($rs as $val) {
            (float) ($ug = number_format((float) $val->ug_mark, 2));
            (float) ($interview = number_format(
                (float) $val->enterence_mark,
                2
            ));
            (float) ($personal = number_format((float) $val->personal_mark, 2));

            (float) ($total = $ug + $interview + $personal);

            $fn = number_format((float) $total, 2);

            $data = [
                "total_mark" => $fn,
            ];

            $this->db->where("m_id", $val->m_id);
            $this->db->update("student_complete_mark", $data);
        }

  
    } 
public function studentApplied(){


    $sta =$this->db->select("user_id")->from("Applyed_Cources")->where("main_course_id ",2)
	
	->get();




    $applied_stu =$sta->result_array();

    $arr = array_column($applied_stu, "user_id");
    

	$this->db->select('stu_user.*,Applyed_Cources.*,new_preview_pg.*,sub_preview_pg.*,shotlisted_candidate.*');
	$this->db->from('Applyed_Cources');
	$this->db->join('stu_user', 'Applyed_Cources.user_id=stu_user.u_id','right');
	$this->db->join('new_preview_pg', 'Applyed_Cources.user_id=new_preview_pg.pr_user_id','right');
	$this->db->join('sub_preview_pg', 'Applyed_Cources.user_id=sub_preview_pg.sb_u_id','right');
	$this->db->join(
		"shotlisted_candidate",
		"Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id ",
		"left"
	);
	//$this->db->join('online_exam_pannel', 'Applyed_Cources.user_id=online_exam_pannel.student_id','right');
 //   $this->db->join('student_complete_mark', 'stu_user.u_id=student_complete_mark.stu_id','left');
	$this->db->where('Applyed_Cources.main_course_id',2);
	$this->db->where('Applyed_Cources.applied_date >=',$this->asyear);
	$this->db->where('Applyed_Cources.applied_date <',$this->aeyear);
	
//	$this->db->where('online_exam_pannel.exam_category',$this->Subject);
	//$this->db->where('student_complete_mark.exam_name',$this->Subject);
	$this->db->where_in("Applyed_Cources.user_id",$arr);
	$st =	$this->db->get();







    
    $data['student'] = $st->result();

    $this->load->view('template/mswaided/header');
    $this->load->view('template/mswaided/menubar');
    $this->load->view('template/mswaided/headerbar');
    $this->load->view('mswaided/appliedStudent',$data);
    $this->load->view('template/mswaided/footer'); 


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
					$data_ann['ann_main'] = 2;
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
					redirect('mswaided/studentannouncements', 'refresh');
				}
		
				$this->load->view('template/mswaided/header');
				$this->load->view('template/mswaided/menubar');
				$this->load->view('template/mswaided/headerbar');
				$this->load->view('mswaided/announcements',$data);
				$this->load->view('template/mswaided/footer');
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
public function updateStudent(){


	$user_id = $this->uri->segment(3);
		$m_course = '2';


		$q = $this->db->select('*')->from('college_course')->where('mc_id',$m_course )->get();
		$pr_user = $this->db->select('*')->from('new_preview_pg')->where('pr_user_id',$user_id)->get();
		$pr_study = $this->db->select('*')->from('sub_preview_pg')->where('sb_u_id',$user_id)->get();
	
	
	
	
		
		$data['cc'] = $q->result();
		$data['user'] = $pr_user->result();
		$data['Study'] = $pr_study->result();




  $this->load->view('template/mswaided/header');
  $this->load->view('template/mswaided/menubar');
  $this->load->view('template/mswaided/headerbar');
  $this->load->view('mswaided/basicdetails_pg',$data);
  $this->load->view('template/mswaided/footer'); 



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


  $this->load->view('template/mswaided/header');
  $this->load->view('template/mswaided/menubar');
  $this->load->view('template/mswaided/headerbar');
  $this->load->view('studentdetails/viewStudent',$data);
  $this->load->view('template/mswaided/footer'); 



}

public function interviewAttendedStudent(){




	$rs = $this->db->select("*")->from("student_complete_mark")
	->join('stu_user', 'student_complete_mark.stu_id=stu_user.u_id')
	->join('Applyed_Cources', 'student_complete_mark.stu_id=Applyed_Cources.user_id AND student_complete_mark.main_course_id=Applyed_Cources.main_course_id AND  student_complete_mark.app_course_id=Applyed_Cources.applied_course_id')
	->join(
		"Applyed_Master",
		"Applyed_Master.id=Applyed_Cources.master_id",
		"left"
	)
	->join('new_preview_pg', 'student_complete_mark.stu_id=new_preview_pg.pr_user_id')
	->join('sub_preview_pg', 'student_complete_mark.stu_id=sub_preview_pg.sb_u_id')
	->where("student_complete_mark.main_course_id",2)
	->where("student_complete_mark.app_course_id",$this->session->userdata('user')['user_dep_status'])
	->where(
		"Applyed_Master.date >=",$this->asyear
	   
	)->where(
		"Applyed_Master.date <",$this->aeyear
	   
	)->get();
	
    $data['student'] = $rs->result();

	$this->load->view('template/mswaided/header');
    $this->load->view('template/mswaided/menubar');
    $this->load->view('template/mswaided/headerbar');
    $this->load->view('mswaided/applied_mark_list',$data);
    $this->load->view('template/mswaided/footer'); 


/* 
	echo"<pre>";
	print_r($rs);
	 */

	
	}



public function updateByDepartment(){


//print_r($_POST);


$data = [
	"dep_verified" => 1,
	"ug_mark" => $_POST["percentage"],
	"community" => $_POST["Community"],
];

$this->db->where("m_id",$_POST['up_id']);
$this->db->update("student_complete_mark",$data);



$this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong> Updated Successfully !
</div>');


redirect('mswaided/interviewAttendedStudent', 'refresh'); 



}
public function selectAllotmentcount()
{
	$std = $this->db
		->select("*")
		->from("resrvation_table")
		->where("rc_main_id", 2)
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
		->where("sl_main_id", 2)
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
			"student_complete_mark.stu_id",
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
		$where = $this->db->where("student_complete_mark.community !=", "");
	} elseif ($_POST["res"] == "OC") {
		$where = $this->db->where("student_complete_mark.community !=", "");
	} elseif ($_POST["res"] == "MANAGEMENT") {
		$where = $this->db->where("student_complete_mark.community !=", "");
	} else {
		$where = $this->db->where(
			"student_complete_mark.community",
			$_POST["res"]
		);
	}
	if ($_POST["special_res"] != "") {
		$where_spe_res = $this->db->where(
			"new_preview_pg.pr_other_special_reservation",
			$_POST["special_res"]
		);
	} else {
		$where_spe_res = "";
	}

	$this->db->select(
		"student_complete_mark.*,new_preview_pg.pr_other_special_reservation,new_preview_pg.pr_applicant_name"
	);
	$this->db->from("student_complete_mark");
	$this->db->join(
		"new_preview_pg",
		"student_complete_mark.stu_id=new_preview_pg.pr_user_id"
	);
	$this->db->where("student_complete_mark.main_course_id", 2);
	$this->db->where(
		"student_complete_mark.app_course_id",
		$this->session->userdata("user")["user_dep_status"]
	);
	$this->db->where("student_complete_mark.personal_mark !=", "A");
	$this->db->where("student_complete_mark.personal_mark !=", "AAA");
	$this->db->where('student_complete_mark.date  >',$this->syear.'-06-01');
	$this->db->where('student_complete_mark.date  <',$this->eyear.'-06-01');
	$user_not_select;
	$where;
	$where_spe_res;
	$this->db->order_by("student_complete_mark.total_mark", "DESC");
	$this->db->limit($_POST["count"]);
	$nr = $this->db->get();

	$nt = $nr->result();

	$html = "";

	foreach ($nt as $key => $value) {
		$html .=
			' <tr>
<td scope="col"><input type="checkbox"  class="check_box"  checked name="user_id[]" value="' .
			$value->stu_id .
			'"></td>
<td scope="col">' .
			$value->pr_applicant_name .
			'</td>
<td scope="col">' .
			$value->ug_mark .
			'</td>
<td scope="col">' .
			$value->enterence_mark .
			'</td>
<td scope="col">' .
			$value->personal_mark .
			'</td> 
<td scope="col">' .
sprintf ("%.2f",$value->total_mark) .
			'</td> 
<td scope="col">' .
			$value->community .
			'</td> 
<td scope="col">' .
			$value->pr_other_special_reservation .
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
				->where("sl_main_id", 2)
				->where(
					"sl_course_id",
					$this->session->userdata("user")["user_dep_status"]
				)
				->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
				->get();

			$res = $user->num_rows();

			$mark = $this->db
			->select("*")
			->from("student_complete_mark")
			
			
			->where("student_complete_mark.stu_id", $value)
			->where("student_complete_mark.main_course_id", 2)
			->where("student_complete_mark.date >", $this->syear.'-06-01')
			->where("student_complete_mark.date <", $this->eyear.'-06-01')
			->where(
				"student_complete_mark.app_course_id",
				$this->session->userdata("user")["user_dep_status"]
			)
				
			->get();

			if ($res == 0) {

				$restt = $mark->result();

				$data = [
					"sl_student_id" => $value,
					"sl_main_id" => 2,
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

		redirect("mswaided/tempShortlist", "refresh");
	} else {
		$this->session->set_flashdata(
			"message",
			' <div class="alert alert-danger alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Failed !</strong> Failed to Shotlist 
</div>'
		);

		redirect("mswaided/tempShortlist", "refresh");
	}
}
public function publishResult(){



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
   ,'right' )
 
	   ->join(
		"new_preview_pg",
		"shotlisted_candidate.sl_student_id=new_preview_pg.pr_user_id"
	) 
	->where("shotlisted_candidate.sl_main_id",2)
	->where(
		"shotlisted_candidate.sl_course_id",
		$this->session->userdata("user")["user_dep_status"]
	)
	->where("shotlisted_candidate.reservation_status",1)
	->where("shotlisted_candidate.principal_published",1)
	->where("shotlisted_candidate.published",0)
		->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
  ->order_by("student_complete_mark.total_mark", "DESC")
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
->from("new_preview_pg")

->where("pr_user_id", $value->u_id)
->get();
$user_details = $user->result();


$application = $this->db
			->select("*")
			->from("Applyed_Cources")
			->where("main_course_id", 2)
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
public function ShotlistPdf()
{
	$sl = $this->db
		->select("*")
		->from("shotlisted_candidate")
		->join(
			"new_preview_pg",
			"shotlisted_candidate.sl_student_id=new_preview_pg.pr_user_id"
		)
		->join(
			"Applyed_Cources",
			"Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id"
		)
		->join(
			"student_complete_mark",
			"student_complete_mark.stu_id=shotlisted_candidate.sl_student_id AND student_complete_mark.main_course_id=shotlisted_candidate.sl_main_id AND student_complete_mark.app_course_id=shotlisted_candidate.sl_course_id"
		)

		->where("sl_main_id", 2)
		->where("reservation_status", $_POST["status"])
		->where("selection_list_name", $_POST["reservation_type"])
		->where(
			"sl_course_id",
			$this->session->userdata("user")["user_dep_status"]
		)
		->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
		->order_by("student_complete_mark.total_mark", "DESC")
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
			$tnt["ug_mark"] .
			'</td>
<td>' .
			$tnt["enterence_mark"] .
			'</td>
<td>' .
			$tnt["personal_mark"] .
			'</td>
<td>' .
sprintf ("%.2f",$tnt["total_mark"]) .
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
		$_POST["title"] .
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
strtoupper($_POST["title"]) .
		" - " .
		$_POST["reservation_type"] .
		$status ." FOR ".
		strtoupper($Candidate[0]["course_name"]) .
		'</h3>
<table width="100%">
<tbody>
	  
	  <td width="50%"><b> Admission Name : ' .
		$_POST["reservation_type"] .
		" - " .' '.
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
	  <th  width="5%">S.No</th>
	  <th width="15%">Application Number</th>
	  <th width="26%">Student Name</th>
	  <th width="15%">Date of Birth</th>
	  <th width="5%">UG Mark</th>
	  <th width="5%">Entrance Mark</th>
	  <th width="5%">Interview Mark</th>
	  <th width="5%">Total</th>
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
  
  <div>
  <h5 align="left"> HoD/Program Head</h5>
 
  
  <h5 align="right"> Principal</h5>
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
			"new_preview_pg",
			"shotlisted_candidate.sl_student_id=new_preview_pg.pr_user_id"
		)
		->join(
			"Applyed_Cources",
			"Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id"
		)
		->join(
			"student_complete_mark",
			"student_complete_mark.stu_id=shotlisted_candidate.sl_student_id  AND student_complete_mark.app_course_id=shotlisted_candidate.sl_course_id AND student_complete_mark.main_course_id=shotlisted_candidate.sl_main_id"
		)

		->where("sl_main_id", 2)
		->where("reservation_status", $status)
		->where("selection_list_name", $reservation)
		->where(
			"sl_course_id",
			$this->session->userdata("user")["user_dep_status"]
		)
		->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
		->order_by("student_complete_mark.total_mark", "DESC")
		->get();
	$data["candidate_list"] = $sl->result();
	$data["reservation_type"] = $reservation;
	$data["status"] = $status;

	$this->load->view("template/mswaided/header");
	$this->load->view("template/mswaided/menubar");
	$this->load->view("template/mswaided/headerbar");
	$this->load->view("mswaided/selection_candidate_status", $data);
	$this->load->view("template/mswaided/footer");
}
public function publishSelectionCandidateList(){

	//print_r($_POST);
	
	$ind =  $this->db->select("*")->from("shotlisted_candidate")
	->join(
		"new_preview_pg",
		"shotlisted_candidate.sl_student_id=new_preview_pg.pr_user_id"
	)
	->join(
		"stu_user",
		"shotlisted_candidate.sl_student_id=stu_user.u_id"
	)
	
	->join(
		"Applyed_Cources",
		"Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id"
	)
	->where("sl_main_id",2)
	->where("published",0)
	->where("emailed",0)
	
	->where("sl_course_id",$this->session->userdata("user")["user_dep_status"])
	->where("selection_list_name",$_POST['reservation'])->where("reservation_status",$_POST['status'])
	->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
	->get();
	
	
	$inds = $ind->result();
	/* echo"<pre>";
	
	print_r($inds); 
	 */
	if($_POST['status'] == 1){
	
	foreach ($inds as $key => $value) {
		
	
	
		$subject = "Greetings from Madras School of Social Work!";
	 
	
	
	$email_subject = "Dear Mr./Ms. " .
	$value->pr_applicant_name .
	",<br>
	
	Greetings from Madras School of Social Work!<br><br>
	
	Application Number: " .$value->application_number ."<br>
	Quota: " .$_POST['reservation'] ."<br>
	Program: " .$value->course_name ."<br>
	
	With reference to your application, you are PROVISIONALLY SELECTED for admission to the above mentioned program. This admission is subject to your uploading of all relevant certificates in your login within the given time. Ignore, if you have uploaded it already.<br><br>
	
	After the Principal's approval, you will receive the admission letter and fee payment link in your login. You are expected to pay the program fee within the stipulated time and send the acknowledgement to the HOD/Program Head. Your provisional admission is valid only after receipt of fee acknowledgement by the Program. Your provisional admission will be cancelled if the fees is not paid within the stipulated time. Additional time will not be given for fee payment.<br><br>
	
	Fee payment indicates your willingness to join the program you have been admitted to and also abide by all the rules and regulations of the College. In case of cancellation of admission, fee paid will be refunded as per our refund policy.<br><br>
	
	This is an automatically generated email please do not reply to it. If you have any queries please write to us on admissions@mssw.in or contact the respective program head<br><br>
	
	
	Regards,<br>
	Principal,<br>
	Madras School of Social Work<br>";
	
	
	$data=array(
		'published'=>1,
		'emailed'=>1,
		'published_date'=>date("Y-m-d H:i:s"),
	);
	
	$this->db->where('sl_id',$value->sl_id);
	$this->db->update('shotlisted_candidate',$data);
	
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
	
	
	
	 $this->testEmail($value->u_email_id, $subject, $email_subject);
	
	}
	}elseif($_POST['status'] == 2){
	
	
		foreach ($inds as $key => $value) {
		
	
	
			$subject = "Greetings from Madras School of Social Work!";
		 
		
		
		$email_subject = "Dear Mr./Ms. " .
		$value->pr_applicant_name .
		",<br>
		
		Greetings from Madras School of Social Work!<br><br>
		
		Application Number: " .$value->application_number ."<br>
		Quota: " .$_POST['reservation'] ."<br>
		Program: " .$value->course_name ."<br>
		
		With reference to your application, you are PROVISIONALLY WAITLISTED for admission to the above mentioned program. You are expected to upload all relevant certificates from your login. Ignore, if you have uploaded already.<br><br>
		You will gain a seat only if any vacancy arises. Keep checking the website and your login for the updates. <br><br>
		
		This is an automatically generated email please do not reply to it. If you have any queries please write to us on admissions@mssw.in or contact the respective program head<br><br>
		Regards,<br>
		Principal,<br>
		Madras School of Social Work<br>";
		
		
		$data=array(
			'published'=>1,
			'emailed'=>1,
			'published_date'=>date("Y-m-d H:i:s"),
		);
		
		$this->db->where('sl_id',$value->sl_id);
		$this->db->update('shotlisted_candidate',$data);
		
		
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
		
		
		
		$this->testEmail($value->u_email_id, $subject, $email_subject);
		
		}
	
	   
	
	}
	 $this->session->set_flashdata(
		"message",
		' <div class="alert alert-success alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Success !</strong> Published  Successfully .
	</div>'
	);
	
	redirect("mswaided/ShotlistedCandidates/".$_POST['status']."/".$_POST['reservation'], "refresh"); 
	
	
	
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
			"student_complete_mark",
			"student_complete_mark.stu_id=shotlisted_candidate.sl_student_id AND student_complete_mark.main_course_id=shotlisted_candidate.sl_main_id  AND student_complete_mark.app_course_id=shotlisted_candidate.sl_course_id"
		) 
	 
	 
		   ->join(
			"new_preview_pg",
			"shotlisted_candidate.sl_student_id=new_preview_pg.pr_user_id"
		) 
		->where("shotlisted_candidate.sl_main_id",2)
		->where(
			"shotlisted_candidate.sl_course_id",
			$this->session->userdata("user")["user_dep_status"]
		)
		->where("shotlisted_candidate.reservation_status", $id)
		->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
	  ->order_by("student_complete_mark.total_mark", "DESC")
		->get();

        $data["student"] = $user->result();

		/* echo"<pre>";
		print_r($data); */

       $this->load->view("template/mswaided/header");
        $this->load->view("template/mswaided/menubar");
        $this->load->view("template/mswaided/headerbar");
        $this->load->view("mswaided/shortlisted_list", $data);
        $this->load->view("template/mswaided/footer"); 
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
                "student_complete_mark",
                "shotlisted_candidate.sl_student_id=student_complete_mark.stu_id AND shotlisted_candidate.sl_main_id=student_complete_mark.main_course_id AND shotlisted_candidate.sl_course_id=student_complete_mark.app_course_id"
            )
            ->join(
                "new_preview_pg",
                "shotlisted_candidate.sl_student_id=new_preview_pg.pr_user_id"
            )
            ->where("sl_main_id", 2)
          
            ->where(
                "sl_course_id",
                $this->session->userdata("user")["user_dep_status"]
            )
            ->where("reservation_status", 2)
			->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
->where(
	"student_complete_mark.personal_mark !=","A"
   
)->where(
	"student_complete_mark.personal_mark !=","AAA"
   
)
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
				->where("sl_main_id", 2)
				->where("sl_caste", $selection)
				->where(
					"sl_course_id",
					$this->session->userdata("user")["user_dep_status"]
				)
				->where("reservation_status", 2)
				->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
->where(
	"student_complete_mark.personal_mark !=","A"
   
)->where(
	"student_complete_mark.personal_mark !=","AAA"
   
)
				->order_by("student_complete_mark.total_mark", "DESC")
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

        ////////////////////////////////////////
		
		$user = $this->db
->select("sl_student_id")
->from("shotlisted_candidate")
->where("sl_main_id", 2)
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
    "student_complete_mark.stu_id",
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
$where = $this->db->where("student_complete_mark.community !=", "");
} elseif ($selection == "OC") {
$where = $this->db->where("student_complete_mark.community !=", "");
} elseif ($selection == "MANAGEMENT") {
$where = $this->db->where("student_complete_mark.community !=", "");
} else {
$where = $this->db->where(
    "student_complete_mark.community",
    $selection
);
}


$this->db->select(
"student_complete_mark.*,new_preview_pg.pr_other_special_reservation,new_preview_pg.pr_applicant_name"
);
$this->db->from("student_complete_mark");
$this->db->join(
"new_preview_pg",
"student_complete_mark.stu_id=new_preview_pg.pr_user_id"
);
$this->db->where("student_complete_mark.main_course_id",2);
$this->db->where(
"student_complete_mark.app_course_id",
$this->session->userdata("user")["user_dep_status"]
);

$user_not_select;
$where;
//$where_spe_res;
$this->db->where('student_complete_mark.date >',$this->syear.'-06-01');
$this->db->where('student_complete_mark.date <',$this->eyear.'-06-01');
$this->db->where(
	"student_complete_mark.personal_mark !=","A"
   
);$this->db->where(
	"student_complete_mark.personal_mark !=","AAA"
   
);
$this->db->order_by("student_complete_mark.total_mark", "DESC");
$this->db->limit(1);
$nr = $this->db->get();



$waitr = $nr->num_rows();

if ($waitr > 0) {
$wait= $nr->result();






$data = [
    "sl_student_id" => $wait[0]->stu_id,
    "sl_main_id" => 2,
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
                "student_complete_mark",
                "shotlisted_candidate.sl_student_id=student_complete_mark.stu_id AND shotlisted_candidate.sl_main_id=student_complete_mark.main_course_id AND shotlisted_candidate.sl_course_id=student_complete_mark.app_course_id"
            )
            ->join(
                "new_preview_pg",
                "shotlisted_candidate.sl_student_id=new_preview_pg.pr_user_id"
            )
            ->where("sl_main_id", 2)
            ->where("selection_list_name", $selection)
            ->where(
                "sl_course_id",
                $this->session->userdata("user")["user_dep_status"]
            )
            ->where("reservation_status", 1)
			->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
            ->order_by("student_complete_mark.total_mark", "ASC")
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
                "student_complete_mark",
                "student_complete_mark.stu_id=shotlisted_candidate.sl_student_id  AND student_complete_mark.app_course_id=shotlisted_candidate.sl_course_id"
            )

            ->where("sl_main_id", 2)
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
                "student_complete_mark",
                "student_complete_mark.stu_id=shotlisted_candidate.sl_student_id  AND student_complete_mark.app_course_id=shotlisted_candidate.sl_course_id"
            )

            ->where("sl_main_id", 2)
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
                "student_complete_mark",
                "student_complete_mark.stu_id=shotlisted_candidate.sl_student_id AND student_complete_mark.app_course_id=shotlisted_candidate.sl_course_id"
            )

            ->where("sl_main_id", 2)
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

        $this->load->view("template/mswaided/header");
        $this->load->view("template/mswaided/menubar");
        $this->load->view("template/mswaided/headerbar");
        $this->load->view("mswaided/shotlist_status", $data);
        $this->load->view("template/mswaided/footer");
    }
public function SaveApplicationPg(){

//print_r($_POST);

$user_id = $this->uri->segment(3);

$candidate_name = $this->input->post('candidate_name');





$course_msw_aided = $this->input->post('msw_aided');
$course_aided = implode(",",(array)$course_msw_aided);


$course_msw_self = $this->input->post('msw_self_finance');
$course_self = implode(",",(array)$course_msw_self);


$course_one = $this->input->post('course_one');
$course_pg = implode(",",(array)$course_one);

$course_two = $this->input->post('course_two');
$course_three = $this->input->post('course_three');
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





$sports_name = $this->input->post('sports_name');
$sports_psition = $this->input->post('sports_psition');
$extra_caricular_activities = $this->input->post('extra_caricular_activities');
$acknoledgement = $this->input->post('acknoledgement');




$update_details = array(
		'pr_applicant_name'=>$candidate_name,
	
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
		'pr_name_of_game'=>$sports_name,
		'pr_game_position'=>$sports_psition,
		'pr_extra_caricular_act'=>$extra_caricular_activities,
		'pr_acknoledge'=>$acknoledgement,
		'pr_other_res'=>$other_res,
		'pr_other_special_reservation'=>$other_special_reservation,
		'pr_hostel'=>$hostel,
);



//Markdheet details
//$candidate_name = $this->input->post('candidate_name');






$sslc  = $this->input->post('sslc');
$plus_one  = $this->input->post('plus_one');
$plus_two  = $this->input->post('plus_two');
$ug  = $this->input->post('ug');



$sslc_ins  = $this->input->post('sslc_ins');
$plus_one_ins  = $this->input->post('plus_one_ins');
$plus_two_ins  = $this->input->post('plus_two_ins');
$ug_ins  = $this->input->post('ug_ins');


$sslc_max_mark  = $this->input->post('sslc_max_mark');
$sslc_mark_obtain  = $this->input->post('sslc_mark_obtain');
$sslc_grade  = $this->input->post('sslc_grade');
$sslc_percentage  = $this->input->post('sslc_percentage');

$plus_one_max_mark  = $this->input->post('plus_one_max_mark');
$plus_one_mark_obtain  = $this->input->post('plus_one_mark_obtain');
$plus_one_grade  = $this->input->post('plus_one_grade');
$plus_one_percentage  = $this->input->post('plus_one_percentage');

$plus_two_max_mark  = $this->input->post('plus_two_max_mark');
$plus_two_mark_obtain  = $this->input->post('plus_two_mark_obtain');
$plus_two_grade  = $this->input->post('plus_two_grade');
$plus_two_percentage  = $this->input->post('plus_two_percentage');

$UG_max_mark  = $this->input->post('UG_max_mark');
$UG_mark_obtain  = $this->input->post('UG_mark_obtain');
$UG_grade  = $this->input->post('UG_grade');
$UG_two_percentage  = $this->input->post('UG_two_percentage');

$subject_mark = array(


	'sslc_subject'=>$sslc,
	'sslc_max_mark'=>$sslc_max_mark,
	'sslc_mark_obtain'=>$sslc_mark_obtain,
	'sslc_grade'=>$sslc_grade,
	'sslc_percentage'=>$sslc_percentage,

	'plus_one_subject'=>$plus_one,
	'plus_one_max_mark'=>$plus_one_max_mark,
	'plus_one_mark_obtain'=>$plus_one_mark_obtain,
	'plus_one_grade'=>$plus_one_grade,
	'plus_one_percentage'=>$plus_one_percentage,


	'plus_two_subjec'=>$plus_two,
	'plus_two_max_mark'=>$plus_two_max_mark,
	'plus_two_mark_obtain'=>$plus_two_mark_obtain,
	'plus_two_grade'=>$plus_two_grade,
	'plus_two_percentage'=>$plus_two_percentage,


	'UG_subject'=>$ug,
	'UG_max_mark'=>$UG_max_mark,
	'UG_mark_obtain'=>$UG_mark_obtain,
	'UG_grade'=>$UG_grade,
	'UG_two_percentage'=>$UG_two_percentage,

	'sslc_institution'=>$sslc_ins,
	'plus_one_institution'=>$plus_one_ins,
	'plus_two_institution'=>$plus_two_ins,
	'ug_institution'=>$ug_ins,
	

);

$this->db->where('pr_user_id',$user_id);
	$this->db->update('new_preview_pg',$update_details);




	$this->db->where('sb_u_id',$user_id);
	$this->db->update('sub_preview_pg',$subject_mark);

  $this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success !</strong> Update Student Record Sucessfully .
            </div>');
            
            
               redirect('mswaided/updateStudent/'.$user_id, 'refresh'); 

}

public function ExamStudent(){


	$sta =$this->db->select("user_id")->from("Applyed_Cources")->where("main_course_id ",2)->get();

   $applied_stu =$sta->result_array();

    $arr = array_column($applied_stu, "user_id");
    
    $st =$this->db->select("*")->from("online_exam_pannel")->where("status",2)->where_in("u_id",$arr)->get();
    $data['student'] = $st->result();

    $this->load->view('template/mswaided/header');
    $this->load->view('template/mswaided/menubar');
    $this->load->view('template/mswaided/headerbar');
    $this->load->view('mswaided/examStudentData',$data);
    $this->load->view('template/mswaided/footer'); 





}
public function studentPdf(){
	$user_id =$this->uri->segment(3);
	$dep_cour =$this->uri->segment(4);
	
	
	$pr_user = $this->db->select('*')->from('new_preview_pg')->where('pr_user_id',$user_id)->get();
	
	$usd = $pr_user->result();
	$pr_study = $this->db->select('*')->from('sub_preview_pg')->where('sb_u_id',$user_id)->get();
	
	$uss = $pr_study->result();
	
	
	
	
	
	
	$q = $this->db->select('*')->from('Applyed_Cources')->where('main_course_id',2)->where('user_id',$user_id)->where('applied_course_id',$dep_cour)->get();
	
	$app_id = $q->result();
	
	

	
	
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
	<img src="http://admission.mssw.in//landing/images/mssw_logo.jpg" width="60%" height="75px;" alt="image">
	</div>
	
	<h3 align="center">Application Form For The Academic Year 2021 - 2022</h3>
	
	<table width="100%">
		<tr>
			<td valign="top"><img src="'.base_url().'/uploads/'.$usd[0]->pr_photo.'" alt="" width="100"/></td>
			<td align="right">
				<h3>Name : '.$usd[0]->pr_applicant_name.'</h3>
				<h3>Reference Number : 22'.sprintf("%'04d", $usd[0]->pr_user_id ).'</h3>
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
	
	$dompdf->stream('22'.sprintf("%'04d", $usd[0]->pr_user_id ).'pdf');
	
	}
	
	public function stuCmnty(){	
	    $asyear = date('Y',strtotime($this->asyear));
		$user=$this->session->userdata('user');
		$user_id=$user['user_id'];
		$user_dep=$user['user_dep_status'];
			$data['cmnty']='';
			$data['linkid']='';
			$data['dpmnt']='';
			$data['quota']='';
        $data['sel_link']=$this->db->where('alc_by',$user_id)->where("DATE_FORMAT(start_date, '%Y') = ".$asyear."")->get('zoom')->result();
		$rules=$this->rules_stu_comm();
        $this->form_validation->set_rules($rules);		
		if(isset($_POST['submit'])){		
		 if($this->form_validation->run() == FALSE){
			 $data['form_err']=$this->session->set_flashdata('success1','Enter Details Correctly','danger');
		 }else{
        $linkid=$data['linkid']=$this->input->post('link_id1');
        $community=$data['cmnty']=$this->input->post('community');
        $dpmnt=$data['dpmnt']=$this->input->post('dpmnt');
		$quota=$data['quota']=$this->input->post('quota');
        //$link_list=$this->db->select('student_id')->where('alc_by',$user_id)->get('zoom_alloc')->result();
		$link_det=$this->db->where('id',$linkid)->get('zoom')->row();
		$start_date=date('Y-m-d',strtotime($link_det->start_date));
		$start_time=date("H:i:s", strtotime($link_det->start_time));
		$duration=$link_det->duration;
		$duration*=60;
		$endTime = date("H:i:s", strtotime($start_time)+($duration));
        $link_list=$this->db->query('select student_id from zoom_alloc where (alc_by="'.$user_id.'" and main_course_id="2" and app_course_id="'.$dpmnt.'" and DATE_FORMAT(alc_date, "%Y") = "'.$asyear.'") or (alc_time >= "'.$start_time.'" AND alc_time < "'.$endTime.'") and alc_date="'.$start_date.'" ')->result();
		$ll=array('0');
		foreach($link_list as $lili){
			array_push($ll,$lili->student_id);
		}
		$stu_dpmnt=$this->db->query('select user_id from Applyed_Cources where applied_course_id="'.$dpmnt.'" and main_course_id="2" and DATE_FORMAT(applied_date, "%Y") = "'.$asyear.'" ')->result();
		$sd=array('0');
		foreach($stu_dpmnt as $studp){
			array_push($sd,$studp->user_id);
		}
		if(($quota==''||$quota=='MGT'||$quota=='Merit')&&$community=='OC'){
		$data['stu_list']=$this->db->where_in('pr_user_id',$sd)->where_not_in('pr_user_id',$ll)->get('new_preview_pg')->result();
        $count =$this->db->where_in('pr_user_id',$sd)->where_not_in('pr_user_id',$ll)->get('new_preview_pg')->num_rows();
		}
		elseif(($quota==''||$quota=='MGT'||$quota=='Merit')&&$community!='OC'){
		$data['stu_list']=$this->db->where('pr_community',$community)->where_in('pr_user_id',$sd)->where_not_in('pr_user_id',$ll)->get('new_preview_pg')->result();
        $count =$this->db->where('pr_community',$community)->where_in('pr_user_id',$sd)->where_not_in('pr_user_id',$ll)->get('new_preview_pg')->num_rows();
		}
		elseif(($quota!=''||$quota!='MGT'||$quota!='Merit')&&$community=='OC'){
		$data['stu_list']=$this->db->where('pr_other_res','Yes')->where('pr_other_special_reservation',$quota)->where_in('pr_user_id',$sd)->where_not_in('pr_user_id',$ll)->get('new_preview_pg')->result();
        $count =$this->db->where('pr_other_res','Yes')->where('pr_other_special_reservation',$quota)->where_in('pr_user_id',$sd)->where_not_in('pr_user_id',$ll)->get('new_preview_pg')->num_rows();
		}
		else{
        $data['stu_list']=$this->db->where('pr_community',$community)->where('pr_other_res','Yes')->where('pr_other_special_reservation',$quota)->where_in('pr_user_id',$sd)->where_not_in('pr_user_id',$ll)->get('new_preview_pg')->result();
        $count =$this->db->where('pr_community',$community)->where('pr_other_res','Yes')->where('pr_other_special_reservation',$quota)->where_in('pr_user_id',$sd)->where_not_in('pr_user_id',$ll)->get('new_preview_pg')->num_rows();
		}
		$data['mesg']=$this->session->set_flashdata('success1','Listed Sucessfully for '.$count.' Students','success');
		$data['count']=$count;
		}
		}

        $this->load->view('template/mswaided/header');
        $this->load->view('template/mswaided/menubar');
        $this->load->view('template/mswaided/headerbar');
        $this->load->view('mswaided/stu_community',$data);
        $this->load->view('template/mswaided/footer');
    }
	
	public function zoom_alloc(){
		$asyear = date('Y',strtotime($this->asyear));
		$data['response']='';
		if(isset($_POST['submit_link'])){	
		$user=$this->session->userdata('user');
		$user_id=$user['user_id'];
		$stu_id=$this->input->post('stu_id');
		
		 if($stu_id==''){
			 $data['form_err']=$this->session->set_flashdata('success1','Please select a student','success');
		$community=$data['cmnty']=$this->input->post('community1');
		$linkid=$data['linkid']=$this->input->post('link_id');
		$dpmnt=$data['dpmnt']=$this->input->post('department1');
		$quota=$data['quota']=$this->input->post('quota1');
        //$link_list=$this->db->select('student_id')->get('zoom_alloc')->result();
		$link_det=$this->db->where('id',$linkid)->get('zoom')->row();
		$start_date=date('Y-m-d',strtotime($link_det->start_date));
		$start_time=date("H:i:s", strtotime($link_det->start_time));
		$duration=$link_det->duration;
		$duration*=60;
		$endTime = date("H:i:s", strtotime($start_time)+($duration));
        $link_list=$this->db->query('select student_id from zoom_alloc where (alc_by="'.$user_id.'" and main_course_id="2" and app_course_id="'.$dpmnt.'" and DATE_FORMAT(alc_date, "%Y") = "'.$asyear.'") or (alc_time >= "'.$start_time.'" AND alc_time < "'.$endTime.'") and alc_date="'.$start_date.'" ')->result();
		$ll=array('0');
		foreach($link_list as $lili){
			array_push($ll,$lili->student_id);
		}
		$stu_dpmnt=$this->db->query('select user_id from Applyed_Cources where applied_course_id="'.$dpmnt.'" and main_course_id="2" and DATE_FORMAT(applied_date, "%Y") = "'.$asyear.'" ')->result();
		$sd=array('0');
		foreach($stu_dpmnt as $studp){
			array_push($sd,$studp->user_id);
		}
        if(($quota==''||$quota=='MGT'||$quota=='Merit')&&$community=='OC'){
		$data['stu_list']=$this->db->where_in('pr_user_id',$sd)->where_not_in('pr_user_id',$ll)->get('new_preview_pg')->result();
        $count =$this->db->where_in('pr_user_id',$sd)->where_not_in('pr_user_id',$ll)->get('new_preview_pg')->num_rows();
		}
		elseif(($quota==''||$quota=='MGT'||$quota=='Merit')&&$community!='OC'){
		$data['stu_list']=$this->db->where('pr_community',$community)->where_in('pr_user_id',$sd)->where_not_in('pr_user_id',$ll)->get('new_preview_pg')->result();
        $count =$this->db->where('pr_community',$community)->where_in('pr_user_id',$sd)->where_not_in('pr_user_id',$ll)->get('new_preview_pg')->num_rows();
		}
		elseif(($quota!=''||$quota!='MGT'||$quota!='Merit')&&$community=='OC'){
		$data['stu_list']=$this->db->where('pr_other_res','Yes')->where('pr_other_special_reservation',$quota)->where_in('pr_user_id',$sd)->where_not_in('pr_user_id',$ll)->get('new_preview_pg')->result();
        $count =$this->db->where('pr_other_res','Yes')->where('pr_other_special_reservation',$quota)->where_in('pr_user_id',$sd)->where_not_in('pr_user_id',$ll)->get('new_preview_pg')->num_rows();
		}
		else{
        $data['stu_list']=$this->db->where('pr_community',$community)->where('pr_other_res','Yes')->where('pr_other_special_reservation',$quota)->where_in('pr_user_id',$sd)->where_not_in('pr_user_id',$ll)->get('new_preview_pg')->result();
        $count =$this->db->where('pr_community',$community)->where('pr_other_res','Yes')->where('pr_other_special_reservation',$quota)->where_in('pr_user_id',$sd)->where_not_in('pr_user_id',$ll)->get('new_preview_pg')->num_rows();
		}
		$data['sel_link']=$this->db->where('alc_by',$user_id)->where("DATE_FORMAT(start_date, '%Y') = ".$asyear."")->get('zoom')->result();
		$data['count']=$count;
		 }else{
		$add_date=date('Y-m-d H:i:s');	 
        $link_id=$this->input->post('link_id');
		$link_det=$this->db->where('id',$link_id)->get('zoom')->row();
		foreach($stu_id as $stuid){
        $data_st['link_id']=$this->input->post('link_id');
        $data_st['student_id']=$stuid;
        $data_st['alc_date']=$link_det->start_date;
        $data_st['alc_time']=$link_det->start_time;
        $data_st['alc_duration']=$link_det->duration;
        $data_st['alc_by']=$user_id;
		$data_st['main_course_id']='2';
        $data_st['app_course_id']=$this->input->post('department1');
        $data_st['created_at']=$add_date;
        $this->db->insert('zoom_alloc',$data_st);
		}
		$data['mesg']=$this->session->set_flashdata('success1','Link Sent Sucessfully','success');
		$community=$data['cmnty']=$this->input->post('community1');
		$linkid=$data['linkid']=$this->input->post('link_id');
		$dpmnt=$data['dpmnt']=$this->input->post('department1');
		$quota=$data['quota']=$this->input->post('quota1');
        //$link_list=$this->db->select('student_id')->get('zoom_alloc')->result();
		$link_det1=$this->db->where('id',$linkid)->get('zoom')->row();
		$start_date=date('Y-m-d',strtotime($link_det1->start_date));
		$start_time=date("H:i:s", strtotime($link_det1->start_time));
		$duration=$link_det1->duration;
		$duration*=60;
		$endTime = date("H:i:s", strtotime($start_time)+($duration));
        $link_list=$this->db->query('select student_id from zoom_alloc where (alc_by="'.$user_id.'" and main_course_id="2" and app_course_id="'.$dpmnt.'" and DATE_FORMAT(alc_date, "%Y") = "'.$asyear.'") or (alc_time >= "'.$start_time.'" AND alc_time < "'.$endTime.'") and alc_date="'.$start_date.'" ')->result();
		$ll=array();
		foreach($link_list as $lili){
			array_push($ll,$lili->student_id);
		}
		$stu_dpmnt=$this->db->query('select user_id from Applyed_Cources where applied_course_id="'.$dpmnt.'" and main_course_id="2" and DATE_FORMAT(applied_date, "%Y") = "'.$asyear.'" ')->result();
		$sd=array('0');
		foreach($stu_dpmnt as $studp){
			array_push($sd,$studp->user_id);
		}
        if(($quota==''||$quota=='MGT'||$quota=='Merit')&&$community=='OC'){
		$data['stu_list']=$this->db->where_in('pr_user_id',$sd)->where_not_in('pr_user_id',$ll)->get('new_preview_pg')->result();
        $count =$this->db->where_in('pr_user_id',$sd)->where_not_in('pr_user_id',$ll)->get('new_preview_pg')->num_rows();
		}
		elseif(($quota==''||$quota=='MGT'||$quota=='Merit')&&$community!='OC'){
		$data['stu_list']=$this->db->where('pr_community',$community)->where_in('pr_user_id',$sd)->where_not_in('pr_user_id',$ll)->get('new_preview_pg')->result();
        $count =$this->db->where('pr_community',$community)->where_in('pr_user_id',$sd)->where_not_in('pr_user_id',$ll)->get('new_preview_pg')->num_rows();
		}
		elseif(($quota!=''||$quota!='MGT'||$quota!='Merit')&&$community=='OC'){
		$data['stu_list']=$this->db->where('pr_other_res','Yes')->where('pr_other_special_reservation',$quota)->where_in('pr_user_id',$sd)->where_not_in('pr_user_id',$ll)->get('new_preview_pg')->result();
        $count =$this->db->where('pr_other_res','Yes')->where('pr_other_special_reservation',$quota)->where_in('pr_user_id',$sd)->where_not_in('pr_user_id',$ll)->get('new_preview_pg')->num_rows();
		}
		else{
        $data['stu_list']=$this->db->where('pr_community',$community)->where('pr_other_res','Yes')->where('pr_other_special_reservation',$quota)->where_in('pr_user_id',$sd)->where_not_in('pr_user_id',$ll)->get('new_preview_pg')->result();
        $count =$this->db->where('pr_community',$community)->where('pr_other_res','Yes')->where('pr_other_special_reservation',$quota)->where_in('pr_user_id',$sd)->where_not_in('pr_user_id',$ll)->get('new_preview_pg')->num_rows();
		}
		$data['sel_link']=$this->db->where('alc_by',$user_id)->where("DATE_FORMAT(start_date, '%Y') = ".$asyear."")->get('zoom')->result();
		$data['count']=$count;
		}
		}
		$this->load->view('template/mswaided/header');
        $this->load->view('template/mswaided/menubar');
        $this->load->view('template/mswaided/headerbar');
        $this->load->view('mswaided/stu_community',$data);
        $this->load->view('template/mswaided/footer');
    }
	
	public function stu_zoom_list(){
		$asyear = date('Y',strtotime($this->asyear));
		$user=$this->session->userdata('user');
		$user_id=$user['user_id'];
		$data['stu_list']=$this->db->query('select zoom_alloc.*, zoom.confirm_status as confirm_status, zoom.title as title, new_preview_pg.pr_applicant_name as stu_name, new_preview_pg.pr_dob as stu_dob, new_preview_pg.pr_community as stu_comm, sub_preview_pg.UG_two_percentage as ug_perc, online_exam_pannel.total_mark as total_mark from zoom_alloc left join zoom on zoom_alloc.link_id=zoom.id left join new_preview_pg on zoom_alloc.student_id=new_preview_pg.pr_user_id left join sub_preview_pg on sub_preview_pg.sb_u_id=zoom_alloc.student_id left join online_exam_pannel on zoom_alloc.student_id=online_exam_pannel.student_id and online_exam_pannel.exam_category="'.$this->Subject.'" where zoom_alloc.alc_by="'.$user_id.'" and DATE_FORMAT(zoom_alloc.alc_date, "%Y") = "'.$asyear.'" group by zoom_alloc.link_id')->result();
		if(isset($_GET['submit'])){	
		$user=$this->session->userdata('user');
		$user_id=$user['user_id'];
		//$stu_id=$this->input->post('stu_id');
		
		 if ( isset( $_GET ) ) {
            $search = $_GET;
        } else {
            $search = '';
        }



			$this->db->select('zoom_alloc.*,online_exam_pannel.*, zoom.confirm_status as confirm_status, zoom.title as title, new_preview_pg.pr_applicant_name as stu_name, new_preview_pg.pr_dob as stu_dob, new_preview_pg.pr_community as stu_comm, sub_preview_pg.UG_two_percentage as ug_perc, online_exam_pannel.total_mark as total_mark');
			$this->db->from('zoom_alloc');
			$this->db->join('zoom', 'zoom_alloc.link_id=zoom.id');
			$this->db->join('new_preview_pg', 'zoom_alloc.student_id=new_preview_pg.pr_user_id');
			$this->db->join('sub_preview_pg', 'zoom_alloc.student_id=sub_preview_pg.sb_u_id', 'left');
			$this->db->join('online_exam_pannel', 'zoom_alloc.student_id=online_exam_pannel.student_id and zoom_alloc.alc_by="'.$user_id.'"', 'left');
			$this->db->Where('zoom_alloc.alc_by', $user_id);
			$this->db->Where('DATE_FORMAT(zoom_alloc.alc_date, "%Y") = "'.$asyear.'"');
			$this->db->group_by('zoom_alloc.link_id');
		if($search['start_date'] != '' && $search['end_date'] != ''){
		$this->db->where('zoom_alloc.alc_date between "'.$search['start_date'].'" and "'.$search['end_date'].'" ');}
		elseif($search['start_date'] != '' && $search['end_date'] == ''){
		$this->db->where('zoom_alloc.alc_date >= "'.$search['start_date'].'" ');}
		elseif($search['start_date'] == '' && $search['end_date'] != ''){
		$this->db->where('zoom_alloc.alc_date <= "'.$search['end_date'].'" ');}
		else{}
		
		$data['stu_list']=$this->db->get()->result();
		$data['srch'] = $_REQUEST;
		}
		if(isset($_GET['submit_pdf'])){
		if ( isset( $_GET ) ) {
            $search = $_GET;
        } else {
            $search = '';
        }
		
		$this->db->select('zoom_alloc.*,online_exam_pannel.*, zoom.confirm_status as confirm_status, zoom.title as title, new_preview_pg.pr_applicant_name as stu_name, new_preview_pg.pr_dob as stu_dob, new_preview_pg.pr_community as stu_comm, sub_preview_pg.UG_two_percentage as ug_perc, online_exam_pannel.total_mark as total_mark');
			$this->db->from('zoom_alloc');
			$this->db->join('zoom', 'zoom_alloc.link_id=zoom.id');
			$this->db->join('new_preview_pg', 'zoom_alloc.student_id=new_preview_pg.pr_user_id');
			$this->db->join('sub_preview_pg', 'zoom_alloc.student_id=sub_preview_pg.sb_u_id', 'left');
			$this->db->join('online_exam_pannel', 'zoom_alloc.student_id=online_exam_pannel.student_id', 'left');
			$this->db->Where('online_exam_pannel.exam_category', $this->Subject);
			$this->db->Where('zoom_alloc.alc_by', $user_id);
			$this->db->Where('DATE_FORMAT(zoom_alloc.alc_date, "%Y") = "'.$asyear.'"');
		if($search['start_date'] != '' && $search['end_date'] != ''){
		$this->db->where('zoom_alloc.alc_date between "'.$search['start_date'].'" and "'.$search['end_date'].'" ');}
		elseif($search['start_date'] != '' && $search['end_date'] == ''){
		$this->db->where('zoom_alloc.alc_date >= "'.$search['start_date'].'" ');}
		elseif($search['start_date'] == '' && $search['end_date'] != ''){
		$this->db->where('zoom_alloc.alc_date <= "'.$search['end_date'].'" ');}
		else{}
		
		$data['stu_list']=$this->db->get()->result();
		$data['srch'] = $_REQUEST;
        $this->load->library('pdf');
        $html = $this->load->view('mswaided/stu_zoom_pdf', $data, true);
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
        $dompdf->stream("welcome.pdf", array("Attachment"=>0));
        }

/* 
echo $this->Subject;
echo"<pre>";
		print_r($data);
 */

	
		$this->load->view('template/mswaided/header');
        $this->load->view('template/mswaided/menubar');
        $this->load->view('template/mswaided/headerbar');
        $this->load->view('mswaided/stu_zoom_list',$data);
        $this->load->view('template/mswaided/footer'); 
	}
	
	public function delete_stu_zoom()
	{
		if($this->input->post('type')==2)
		{
			$id=$this->input->post('id');
			$stu_id=$this->input->post('stu_id');
			$course=$this->Subject;
			$app_course=$this->session->userdata('user')['user_dep_status'];
			$this->db->where('id',$id)->delete('zoom_alloc');	
			$this->db->where('stu_id',$stu_id)->where('exam_name',$course)->where('app_course_id',$app_course)->delete('student_complete_mark');	
			//echo json_encode(array(
				//"statusCode"=>200
			//));
			echo "Deleted Successfully";
		} 
	}
	public function stu_zoom_list_det(){
		
		$data['zoom_id']=$zoom_id=$this->uri->segment(3);
		$add_date=date('y-m-d H:i:s');
		$user=$this->session->userdata('user');
		$user_id=$user['user_id'];
		
		$data['stu_list']=$this->db->query('select zoom_alloc.*, zoom.title as title,zoom.confirm_status as publishstatus,new_preview_pg.pr_applicant_name as stu_name, new_preview_pg.pr_dob as stu_dob, new_preview_pg.pr_community as stu_comm, sub_preview_pg.UG_two_percentage as ug_perc, online_exam_pannel.total_mark as total_mark, student_complete_mark.personal_mark as per_mark from zoom_alloc left join zoom on zoom_alloc.link_id=zoom.id left join new_preview_pg on zoom_alloc.student_id=new_preview_pg.pr_user_id left join sub_preview_pg on sub_preview_pg.sb_u_id=zoom_alloc.student_id left join online_exam_pannel on zoom_alloc.student_id=online_exam_pannel.student_id and online_exam_pannel.exam_category="'.$this->Subject.'" left join student_complete_mark on zoom_alloc.student_id=student_complete_mark.stu_id and zoom_alloc.app_course_id=student_complete_mark.app_course_id and student_complete_mark.main_course_id="2" where zoom_alloc.link_id="'.$zoom_id.'" and zoom_alloc.alc_by="'.$user_id.'" group by student_id')->result();
		
		if(isset($_POST['submit'])){	
		$user=$this->session->userdata('user');
		$user_id=$user['user_id'];
		$data['zoom_id']=$zoom_id1=$this->input->post('zoom_id');
		$id=$this->input->post('id');
		$per_mark=$this->input->post('per_mark');
		$app_course_id=$this->session->userdata('user')['user_dep_status'];
		
			$det=$this->db->query('select zoom_alloc.*, zoom.title as title, new_preview_pg.pr_caste as stu_caste, new_preview_pg.pr_community as stu_comm, sub_preview_pg.UG_two_percentage as ug_perc, online_exam_pannel.total_mark as total_mark from zoom_alloc left join zoom on zoom_alloc.link_id=zoom.id left join new_preview_pg on zoom_alloc.student_id=new_preview_pg.pr_user_id left join sub_preview_pg on sub_preview_pg.sb_u_id=zoom_alloc.student_id left join online_exam_pannel on zoom_alloc.student_id=online_exam_pannel.student_id and online_exam_pannel.exam_category="'.$this->Subject.'" where zoom_alloc.id="'.$id.'" ')->row();
			
		$data_pmark=array(
		  'stu_id' => $det->student_id,
		  'exam_name' => $this->Subject,
		  'ug_mark' => $det->ug_perc,
		  'date' => $add_date,
		  'enterence_mark' => $det->total_mark,
		  'personal_mark' => $per_mark,
		  'community' => $det->stu_comm,
		  'cast' => $det->stu_caste,
		  'main_course_id' => '2',
		  'app_course_id' => $app_course_id,
		  'zoom_id' => $zoom_id1,
		);	
		
		$get_stu=$this->db->where('stu_id',$det->student_id)->where('exam_name',$this->Subject)->where('app_course_id',$app_course_id)->where('main_course_id','2')->get('student_complete_mark')->row();
		if(empty($get_stu)){
		$this->db->insert('student_complete_mark',$data_pmark);}else{
			$this->db->where('m_id',$get_stu->m_id);
		$this->db->update('student_complete_mark',$data_pmark);
		}
		$data['mesg']=$this->session->set_flashdata('success','Updated Marks Successfully');
		redirect('mswaided/stu_zoom_list_det/'.$zoom_id1.'');
		}

	
		$this->load->view('template/mswaided/header');
        $this->load->view('template/mswaided/menubar');
        $this->load->view('template/mswaided/headerbar');
        $this->load->view('mswaided/stu_zoom_list_det',$data);
        $this->load->view('template/mswaided/footer'); 
	}
	public function stu_zoom_pdf(){
		$asyear = date('Y',strtotime($this->asyear));
		$data['stu_list']=$this->db->query('select zoom_alloc.*, zoom.title as title, new_preview_pg.pr_applicant_name as stu_name, new_preview_pg.pr_dob as stu_dob, new_preview_pg.pr_community as stu_comm, sub_preview_pg.UG_two_percentage as ug_perc, (select sum(new_online_exam_answer.score) from new_online_exam_answer where new_online_exam_answer.user_id=zoom_alloc.student_id) as marks, online_exam_pannel.total_mark as total_mark from zoom_alloc left join zoom on zoom_alloc.link_id=zoom.id left join new_preview_pg on zoom_alloc.student_id=new_preview_pg.pr_user_id left join sub_preview_pg on sub_preview_pg.sb_u_id=zoom_alloc.student_id left join online_exam_pannel on zoom_alloc.student_id=online_exam_pannel.student_id where online_exam_pannel.exam_category="'.$this->Subject.'" and DATE_FORMAT(zoom_alloc.alc_date, "%Y") = "'.$asyear.'" ')->result();
        $this->load->view('mswaided/stu_zoom_pdf',$data);
    }
	
	public function stu_pdf(){


  $user_id = $this->uri->segment(3);
  $m_course = '2';


  $pr_user = $this->db->select('*')->from('new_preview_pg')->where('pr_user_id',$user_id)->get();
  $pr_study = $this->db->select('*')->from('sub_preview_pg')->where('sb_u_id',$user_id)->get();

  $q = $this->db->select('*')->from('college_course')->get();


  $data['cc'] = $q->result();

  $data['user'] = $pr_user->result();
  $data['Study'] = $pr_study->result();

  $this->load->view('mswaided/stu_pdf',$data);

}
public function UploadFile(){


	if(isset($_REQUEST["file"])){
		// Get parameters
		$file = urldecode($_REQUEST["file"]); // Decode URL-encoded string
	
		/* Test whether the file name contains illegal characters
		such as "../" using the regular expression */
		if(preg_match('/^[^.][-a-z0-9_.]+[a-z]$/i', $file)){
			$filepath = "uploads/" . $file;
	
			// Process download
			if(file_exists($filepath)) {
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . filesize($filepath));
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

$this->load->view('template/mswaided/header');
  $this->load->view('template/mswaided/menubar');
  $this->load->view('template/mswaided/headerbar');
  $this->load->view('mswaided/certificates',$data);
  $this->load->view('template/mswaided/footer'); 




}

Public function publishPanel(){


	$config = array(
		'protocol' => 'smtp', 
		'smtp_host' => 'ssl://smtp.gmail.com', 
		'smtp_port' => 465, 
		'smtp_user' => 'admission.mssw@gmail.com', 
		'smtp_pass' => 'loveindia@123', 
		'mailtype' => 'html', 
		'charset' => 'iso-8859-1'
);
	$this->email->initialize($config);
	$this->email->set_mailtype("html");
	$this->email->set_newline("\r\n");


$user_id = array();
$send_email="";

$id = $this->input->post("panel_id");
$defect = $this->db->select("*")->from("zoom")->where("id",$id)->get();
$ids = $defect->result();

$student = $this->db->select("*")->from("zoom_alloc")->where("link_id",$id)->get();
$sl = $student->result();

foreach ($sl as $key => $value) {
array_push($user_id,$value->student_id)	;
}



$zoom_panel = array(
	'confirm_status'=>1,
);
$zoom_complete = array(
	'publish_link'=>1,
	'publish_date'=>date('Y-m-d H:i:s'),
	'publish_by'=>$this->session->userdata('user')['user_id'],
);


$this->db->where("id",$id);
$this->db->Update("zoom",$zoom_panel );

foreach ($sl as $key => $values) {
	$this->db->where("id",$values->id);
$this->db->Update("zoom_alloc",$zoom_complete );
}
	

//print_r($u_email);

foreach($sl as $values){

	// $mail->u_email_id;
	$email = $this->db->select("*")->from("stu_user")->where_in("u_id",$values->student_id)->get();
$u_email =$email->result(); 
	
	
	$user = $this->db->select("*")->from("new_preview_pg")
	
	->where("pr_user_id",$u_email[0]->u_id)->get();
	$user_details =$user->result(); 
	
	$application = $this->db->select("*")->from("Applyed_Cources")
	->where("main_course_id",2)
	->where("applied_course_id",$values->app_course_id)
	->where("user_id",$values->student_id)->get();
	$app_details =$application->result(); 
	
	
	
	
	$subject="MSSW Admission - Shortlisted for Online Interview - Regarding";
	echo $msg = "Dear Mr./Ms.".$user_details[0]->pr_applicant_name." ,<br> 
	
	Greetings! <br> 
	
	With reference to your application for ".$app_details[0]->course_name.", Application Number: ".$app_details[0]->application_number.",<br> 
	 Appear for online Zoom Interview on {".date('d-m-Y',strtotime($ids[0]->start_date))."} at {".date('H:i',strtotime($ids[0]->start_time))."}.<br> 
	 
	 
	 
	 
	 <a href='https://admission.mssw.in//Home/login'>Login </a> to your account to attend the interview.<br> 
	
	Visit <a href='https://mssw.in/admissions/#PGAdmissions'>P.G.admissions</a> page and check your login for more details.<br><br>  <br> 
	
	Regards,<br><br>  
	
	Principal, MSSW.<br> 
	www.mssw.in
	";
		$this->testEmail($u_email[0]->u_email_id,$subject,$msg);
	//	$this->testEmail("yuvaraj@istudiotech.com",$subject,$msg);
	}


}



public function certificateComments(){



	//print_r($_POST);
	
	
	$user_id = $this->input->post('user_id');
	$pr_sslc = $this->input->post('pr_sslc');
	$pr_plus_one = $this->input->post('pr_plus_one');
	$pr_plus_two = $this->input->post('pr_plus_two');
	$pr_abled_certificate = $this->input->post('pr_abled_certificate');
	$pr_semester_1 = $this->input->post('pr_semester_1');
	$pr_semester_2 = $this->input->post('pr_semester_2');
	$pr_semester_3 = $this->input->post('pr_semester_3');
	$pr_semester_4 = $this->input->post('pr_semester_4');
	$pr_semester_5 = $this->input->post('pr_semester_5');
	$pr_semester_6 = $this->input->post('pr_semester_6');
	$pr_semester_7 = $this->input->post('pr_semester_7');
	$pr_semester_8 = $this->input->post('pr_semester_8');
	$pr_provisional_pg_cer = $this->input->post('pr_provisional_pg_cer');
	$pr_ug_cer = $this->input->post('pr_ug_cer');
	$pr_cummulative_cer = $this->input->post('pr_cummulative_cer');
	$pr_community_cer = $this->input->post('pr_community_cer');
	$pr_conduct_cer = $this->input->post('pr_conduct_cer');
	$pr_transfer_cer = $this->input->post('pr_transfer_cer');
	
	$data = array(
		'sslc_certificate'=>$pr_sslc,
		'plus_one_cer'=>$pr_plus_one,
		'plus_two_cer'=>$pr_plus_two,
		'abled_cert'=>$pr_abled_certificate,
		'pr_semester_1'=>$pr_semester_1,
		'pr_semester_2'=>$pr_semester_2,
		'pr_semester_3'=>$pr_semester_3,
		'pr_semester_4'=>$pr_semester_4,
		'pr_semester_5'=>$pr_semester_5,
		'pr_semester_6'=>$pr_semester_6,
		'pr_semester_7'=>$pr_semester_7,
		'pr_semester_8'=>$pr_semester_8,
		'pr_provisional_pg_cer'=>$pr_provisional_pg_cer,
		'pr_ug_cer'=>$pr_ug_cer,
		'pr_cummulative_cer'=>$pr_cummulative_cer,
		'pr_community_cer'=>$pr_community_cer,
		'pr_conduct_cer'=>$pr_conduct_cer,
		'pr_transfer_cer'=>$pr_transfer_cer,
		'status'=>1,
		
	);
	
	$this->db->where('student_id',$user_id);
	$this->db->update('Certificate_comments',$data);
	
	$this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Success !</strong> Updated Comments Successfully .
	</div>');
	
	
	redirect('mswaided/studentCertificate/'.$user_id, 'refresh');
	
	
	}
	public function UpdateMarkPercentage(){



		$user_id =$this->uri->segment(3);


		$pr_user = $this->db->select('*')->from('new_preview_pg')->where('pr_user_id',$user_id)->get();
		
		
		$data['comm_cer']  = $pr_user->result();
		
		
		$pr_user = $this->db->select('*')->from('sub_preview_pg')->where('sb_u_id',$user_id)->get();
		
		
		$data['percent']  = $pr_user->result();



		$this->load->view('template/mswaided/header');
		$this->load->view('template/mswaided/menubar');
		$this->load->view('template/mswaided/headerbar');
		$this->load->view('mswaided/update_mark_comunity',$data);
		$this->load->view('template/mswaided/footer'); 


	}
	public function updatePGPer(){



		$community = array(
			'pr_community'=>$_POST['Community'],
		);
		
		$this->db->where('pr_user_id',$_POST['student_id']);
		$this->db->update('new_preview_pg',$community );
		
		
		$percentage = array(
			'UG_two_percentage'=>$_POST['ug_percentage'],
			'verified_status'=>1,
			'verified_by_user'=>$this->session->userdata('user')['user_id'],
		);
		
		$this->db->where('sb_u_id',$_POST['student_id']);
		$this->db->update('sub_preview_pg',$percentage );
		
		$ud = $this->db->select("u_email_id,u_mobile")->from("stu_user")->where("u_id", $_POST['student_id'])->get();
		$res = $ud->result();
		
		
		$usn = $this->db->select("pr_applicant_name")->from("new_preview_pg")->where("pr_user_id", $_POST['student_id'])->get();
		$usr_name = $usn->result();
		
		
		
		
		
		$config = array(
			'protocol' => 'smtp', 
			'smtp_host' => 'ssl://smtp.gmail.com', 
			'smtp_port' => 465, 
			'smtp_user' => 'admission.mssw@gmail.com', 
			'smtp_pass' => 'loveindia@123', 
			'mailtype' => 'html', 
			'charset' => 'iso-8859-1'
		);
		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");
		
		$subject = "Percentage and Community Verified Status";
		$msg = "Dear ".$usr_name[0]->pr_applicant_name.",<br><br>
		
		
		
		Your percentage and community is verified by the department based on the details provided by you. Kindly check your login and application for the update. In case of any changes, contact the respective program head within one day after receiving this E-mail. Late requests will not be entertained.";
		$this->testEmail($res[0]->u_email_id,$subject,$msg); 
		
		//$res[0]->u_email_id
		
		$this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Success !</strong> Updated Successfully .
		</div>');
		
		
		redirect('mswaided/studentApplied', 'refresh');
		




	}
	public function panelEmail(){
		$user_id=array();
	
		$id = $this->input->post("panel_id");
		$defect = $this->db->select("*")->from("zoom")->where("id",$id)->get();
		$ids = $defect->result();
		
		$student = $this->db->select("*")->from("zoom_alloc")->where("link_id",$id)->get();
		$sl = $student->result();
		
		foreach ($sl as $key => $value) {
		array_push($user_id,$value->student_id)	;
		}
	
		$email = $this->db->select("*")->from("stu_user")->where_in("u_id",$user_id)->get();
		$u_email =$email->result(); 	
	
	
	$email_subject = $this->input->post("email_subject");
	$email_content = $this->input->post("email_content");
	
	
	
	$config = array(
		'protocol' => 'smtp', 
		'smtp_host' => 'ssl://smtp.gmail.com', 
		'smtp_port' => 465, 
		'smtp_user' => 'admission.mssw@gmail.com', 
		'smtp_pass' => 'loveindia@123', 
		'mailtype' => 'html', 
		'charset' => 'iso-8859-1'
	);
	$this->email->initialize($config);
	$this->email->set_mailtype("html");
	$this->email->set_newline("\r\n");
	
	
	foreach($u_email as $mail){
	
	
			$this->testEmail($mail->u_email_id,$email_subject ,$email_content);
		}
	
	
	$this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Success !</strong> Emailed  to '.$ids[0]->title.' Successfully
	</div>');
	
	
	redirect('mswaided/stu_zoom_list', 'refresh'); 
	
	
	
	
	
	}

	public function updateStuContactInfo(){



		$this->load->view('template/mswaided/header');
		$this->load->view('template/mswaided/menubar');
		$this->load->view('template/mswaided/headerbar');
		$this->load->view('mswaided/update_personal');
		$this->load->view('template/mswaided/footer'); 
	  
	  
	  
	  }
	  
	  public function updateStuPerInfo(){
	  
	  
	  
	  $student_id = $this->input->post("student_id");
	  $email_id = $this->input->post("email");
	  $mobile = $this->input->post("mobile");
	  
	  
	  
	  if(isset($student_id) && $student_id !=""){
	  
	  $array =array(
		  "u_email_id"=>$email_id,
		  "u_mobile"=>$mobile,
	  );
	  
	  
	  $this->db->where("u_id",$student_id);
	  $this->db->update("stu_user",$array);
	  
	  
	  $this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  <strong>Success !</strong> Update Student Record Successfully .
	  </div>');
	  
	  
		 redirect('mswaided/updateStuContactInfo/'.$student_id, 'refresh'); 
	  
	  }else{
	  
	  
		  $this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
		  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		  <strong>Failed !</strong> Failed to Student Record  .
		  </div>');
		  
		  
			 redirect('mswaided/updateStuContactInfo/'.$student_id, 'refresh'); 
	  
	  
	  
	  }
	  
	  
	  }


	public function SendPersenalEmail(){



		$user_id =$this->uri->segment(3);


		$pr_user = $this->db->select('*')->from('stu_user')->where('u_id',$user_id)->get();
		
		
		$data['email']  = $pr_user->result();
		
		
		



		$this->load->view('template/mswaided/header');
		$this->load->view('template/mswaided/menubar');
		$this->load->view('template/mswaided/headerbar');
		$this->load->view('mswaided/send_email',$data);
		$this->load->view('template/mswaided/footer'); 





	}
	public function personalMailUser(){
	

		$ud = $this->db->select("u_email_id,u_mobile")->from("stu_user")->where("u_id", $_POST['student_id'])->get();
		$res = $ud->result();
		
		
		$usn = $this->db->select("pr_applicant_name")->from("new_preview_pg")->where("pr_user_id", $_POST['student_id'])->get();
		$usr_name = $usn->result();
	
	
	$email_subject = $this->input->post("email_subject");
	$email_content = $this->input->post("email_content");
	
	
	
	$config = array(
		'protocol' => 'smtp', 
		'smtp_host' => 'ssl://smtp.gmail.com', 
		'smtp_port' => 465, 
		'smtp_user' => 'admission.mssw@gmail.com', 
		'smtp_pass' => 'loveindia@123', 
		'mailtype' => 'html', 
		'charset' => 'iso-8859-1'
	);
	$this->email->initialize($config);
	$this->email->set_mailtype("html");
	$this->email->set_newline("\r\n");
	
	
	$msg = "Dear ".$usr_name[0]->pr_applicant_name.",<br><br>".$email_content;
	
	
	
	
	$this->testEmail($res[0]->u_email_id,$email_subject ,$msg); 
	
	
	$this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Success !</strong> Emailed  to .'.$usr_name[0]->pr_applicant_name.' Successfully
	</div>');
	
	
	redirect('mswaided/studentApplied', 'refresh');
	
	
	
		
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
					$this->email->send();
		
		
		
		
		
		}



		public function panelPdf(){


			$pannel_id = $this->uri->segment(3);
			
			$pr_user = $this->db->select('*')->from('zoom')->where('id',$pannel_id)->get();
			
			$usd = $pr_user->result();
			
			
			$m = $this->db->select("*")->from("zoom_alloc")
			->join('Applyed_Cources', 'zoom_alloc.student_id=Applyed_Cources.user_id AND zoom_alloc.app_course_id=Applyed_Cources.applied_course_id')
			->join('new_preview_pg', 'zoom_alloc.student_id=new_preview_pg.pr_user_id')
			->join('sub_preview_pg', 'zoom_alloc.student_id=sub_preview_pg.sb_u_id', 'left')
			->join('online_exam_pannel', 'zoom_alloc.student_id=online_exam_pannel.student_id', 'left')
			->Where('online_exam_pannel.exam_category', $this->Subject)
			->Where('Applyed_Cources.main_course_id', 2)
			//->Where('Applyed_Cources.applied_course_id',$this->session->userdata('user')['user_dep_status'])
			->where("zoom_alloc.link_id",$pannel_id )->get();
			
			$nm = $m->result();
			
			
			
			
			$depname = $this->db->select("*")->from("college_course")->Where('mc_id', 2)
			->Where('cs_id',3)->get();
			
			$dept_name = $depname->result();
			
			/* echo"<pre>";
			print_r($nm); */
			$temp='';
			$i=1;
			foreach($nm as $key => $tnde){
			
			
				$ug = number_format((float)$tnde->UG_two_percentage, 2, '.', '');
			
			
				$ent =  number_format((float)$tnde->total_mark, 2, '.', '');
			
			$total = $ug + $ent;
			$totn =      number_format((float)$total, 2, '.', '');
			
			
		

$data = array(
    'app_no' => $tnde->application_number,
    'app_name' => strtoupper($tnde->pr_applicant_name),
    'ref_id' => $tnde->pr_user_id,
    'date' => date('d-m-Y',strtotime($tnde->pr_dob)),
    'ug_mark' => $ug,
    'pg_mark' => $ent,
    'totak_mark' => $totn,
    'community' => $tnde->pr_community,
  );


  $newArray[$key] = $data;
			}
			
	
usort($newArray,function($a,$b){
    return  $b['totak_mark'] > $a['totak_mark'] ? 1 : -1; 
});


$i=1;
foreach($newArray as $tnt){

	$temp.='   <tr align="center">
	<td>'.$i.'</td>
	<td>'.$tnt['app_no'].'</td>
	<td>'.strtoupper($tnt['app_name']).'</td>
	<td>'.'22'.sprintf("%'04d",$tnt['ref_id']).'</td>
	<td>'.date('d-m-Y',strtotime($tnt['date'])).'</td>
	<td>'.$tnt['ug_mark'].'</td>
	<td>'.$tnt['pg_mark'].'</td>
	<td>'.$tnt['totak_mark'].'</td>
	<td>'.$tnt['community'].'</td>
	
	</tr>';

	$i++;
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
			
			
				 tr:nth-child(even){background-color: #f2f2f2;}
			
			 tr:hover {background-color: #ddd;}
				  
			</style>
			
			</head>
			<body>
			<div id ="center">  
			<img  src="http://admission.mssw.in//landing/images/mssw_logo.jpg" width="60%" height="75px;">
			</div>  
			
			<br>
			<h3 align="center"> Interview Schedule For '.$nm[0]->course_name.'</h3>
			<h5>  Interview Name :'.$usd[0]->title.'</h5>
			<h5> Interview Date & Time : '.date('d-m-Y',strtotime($usd[0]->start_date)).' & '.date('H:i',strtotime($usd[0]->start_time)).' (24-hour), Duration : '.$usd[0]->duration . ' Mins</h5>
			<h5>  Zoom Link :'.$usd[0]->link.'</h5>
			  <table id="tem" width="100%">
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
			'.$temp.'
			  </tbody>
			  </table>
			
			  <br>
			  <h5 align="right"> Sd/-</h5>
			  
			  <h5 align="right"> HoD/Program Head</h5>
			
			  <br>
			  <br>
			  <h6 align="center">Generated by MSSW Campus Management System.</h6>
			  ';
			
			
			$dompdf->load_html($html);
			$dompdf->render();
			
			$dompdf->stream(($usd[0]->title).'pdf');
			
			
			
			
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
            "new_preview_pg",
            "shotlisted_candidate.sl_student_id=new_preview_pg.pr_user_id"
        )
        ->join(
            "Applyed_Cources",
            "Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id"
        )
        ->join(
            "student_complete_mark",
            "student_complete_mark.stu_id=shotlisted_candidate.sl_student_id AND student_complete_mark.main_course_id=shotlisted_candidate.sl_main_id AND student_complete_mark.app_course_id=shotlisted_candidate.sl_course_id"
        )

        ->where("sl_main_id", 2)
        ->where("reservation_status", $selection_type)
        ->where("selection_list",  $selection_list)
        ->where("selection_list_name",  $va->r_name)
        ->where(
            "sl_course_id",
            $this->session->userdata("user")["user_dep_status"]
        )
		->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
      //  ->order_by("shotlisted_candidate.selection_list_name", "ASC")
        ->order_by("student_complete_mark.total_mark", "DESC")
        ->get();

$n=$sl->num_rows();

$Candidate = $sl->result_array();


/* print_r($Candidate);

exit;
 */

if($n > 0){

    $Candidate = $sl->result_array();

    $temp .= '<h4 align="center"> ' .$va->r_name .'</h4>
    
    <table width="100%">
    <thead style="background-color: lightgray;">
      <tr>
        <th  width="5%">S.No</th>
        <th width="15%">Application Number</th>
        <th width="26%">Student Name</th>
        <th width="15%">Date of Birth</th>
        <th width="5%">UG Mark</th>
        <th width="5%">Entrance Mark</th>
        <th width="5%">Interview Mark</th>
        <th width="5%">Total</th>
        <th width="9%">Community</th>
       
           
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
            $tnt["ug_mark"] .
            '</td>
<td>' .
            $tnt["enterence_mark"] .
            '</td>
<td>' .
            $tnt["personal_mark"] .
            '</td>
<td>' .
sprintf ("%.2f",$tnt["total_mark"]) .
            '</td>
<td>' .
            $tnt["community"] .
            '</td>
          

</tr>';

        $i++;
    }
    $temp .='</tbody>
    </table>
      <br>
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
    strtoupper($list) .
        " - " .
       
        $status ." FOR ".
        strtoupper($this->department_name);

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


//echo $html;
     $dompdf->load_html($html);
    $dompdf->render();

    $dompdf->stream($filename . "pdf"); 
    }

	public function principalApproved()
    {
       

        $user = $this->db
        ->select("*")
        ->from("shotlisted_candidate")
        ->join(
            "Applyed_Cources",
            "Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id"
        )
		->join(
            "student_complete_mark",
            "student_complete_mark.stu_id=shotlisted_candidate.sl_student_id AND student_complete_mark.main_course_id=shotlisted_candidate.sl_main_id AND student_complete_mark.app_course_id=shotlisted_candidate.sl_course_id"
        )
    
           ->join(
            "new_preview_pg",
            "shotlisted_candidate.sl_student_id=new_preview_pg.pr_user_id"
        ) 
        ->where("shotlisted_candidate.sl_main_id",2)
        ->where(
            "shotlisted_candidate.sl_course_id",
            $this->session->userdata("user")["user_dep_status"]
        )
        ->where("shotlisted_candidate.reservation_status",1)
		->where('shotlisted_candidate.created >',$this->syear.'-06-01')
->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
		->group_by("shotlisted_candidate.sl_id")
        ->get();


        $std = $this->db
        ->select("*")
        ->from("resrvation_table")
        ->where("rc_main_id",2)
        ->where(
            "rc_cource_id",
            $this->session->userdata("user")["user_dep_status"]
        )
        ->get();

    $data["reservation"] = $std->result();


        $data["student"] = $user->result();
        $data['title'] = "Reports of  ".$this->session->userdata('user')['user_name']." ".date('d-M-Y');


      /*   echo $this->session->userdata("user")["user_dep_status"] ;
        echo"<pre>";

            print_r($data);
 */

       $this->load->view("template/mswaided/header");
        $this->load->view("template/mswaided/menubar");
        $this->load->view("template/mswaided/headerbar");
        $this->load->view("mswaided/principal_approved_list", $data);
        $this->load->view("template/mswaided/footer", $data); 
    }

	public function admitStudent(){



        if($this->session->userdata("user")["user_dep_status"] == 1){


            $dep ="MSWAC";
        }else if($this->session->userdata("user")["user_dep_status"] == 2){
    
            $dep ="MSWAM";
        }else if($this->session->userdata("user")["user_dep_status"] == 3){
    
          $dep ="MSWAH";
      }
    
    
    
    $m = $this->db->select("*")->from("admitted_student")->where("as_student_id",$_POST['student_id'])->where("as_shotlist_ref_number",$_POST['student_short_id'])->get();
    
    
    
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
    
    
        redirect('mswaided/principalApproved/'); 
    
    }else{
    
    
        $data = array(
            'as_name'=>$_POST['name'],
            'as_app_number'=>$_POST['app_number'],
            'as_blood_gp'=>$_POST['blood_grp'],
            'as_quata'=>$_POST['reservation'],
            'as_dep'=>$dep,
            'as_profile'=>$_POST['student_photo'],
            'year'=>date('Y'),
       
        );
    
    $this->db->where('as_student_id',$_POST['student_id']);
    $this->db->where('as_shotlist_ref_number',$_POST['student_short_id']);
    $this->db->update('admitted_student',$data);
    
    
    $this->session->set_flashdata('message', ' <div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success !</strong>Updated Successfully .
    </div>');
    
    
        redirect('mswaided/principalApproved/'); 
    
    }
    
    redirect('mswaided/principalApproved/'); 
    
    
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
            redirect('mswaided/admittedStudent/'); 
        
        }


	public function admittedStudent(){



		if($this->session->userdata("user")["user_dep_status"] == 1){


            $dep ="MSWAC";
        }else if($this->session->userdata("user")["user_dep_status"] == 2){
    
            $dep ="MSWAM";
        }else if($this->session->userdata("user")["user_dep_status"] == 3){
    
          $dep ="MSWAH";
      }




        $this->db->select('*');
		$this->db->from('admitted_student');
	
		$this->db->join(
            "shotlisted_candidate",
            "admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id"
        ) ;
		$this->db->where('admitted_student.as_dep', $dep);
		$this->db->where('shotlisted_candidate.created >', $this->syear.'-06-01');
		$this->db->where('shotlisted_candidate.created <', $this->eyear.'-06-01');
        $this->db->order_by('as_reg_num', 'asc');
      
        $query = $this->db->get();
        $res = $query->result();
        
        $data['student'] = $res;
        
        
        
        $this->load->view("template/mswaided/header");
        $this->load->view("template/mswaided/menubar");
        $this->load->view("template/mswaided/headerbar");
        $this->load->view("mswaided/admittedStudent", $data);
        $this->load->view("template/mswaided/footer");
        
        
        
        }
		public function admittedErp(){


		
			if($this->session->userdata("user")["user_dep_status"] == 1){


				$dep =$this->session->userdata("user")["user_aca_year"]." Batch/MSWACD";
			}else if($this->session->userdata("user")["user_dep_status"] == 2){
		
				$dep =$this->session->userdata("user")["user_aca_year"]." Batch/MSWAMPSW";
			}else if($this->session->userdata("user")["user_dep_status"] == 3){
		
				$dep =$this->session->userdata("user")["user_aca_year"]." Batch/MSWAHRM";
		  }


			
		
		
		$this->db->select('*');
		$this->db->from('erp_existing_students');
		$this->db->join(
			"new_preview_pg",
			"erp_existing_students.student_id=new_preview_pg.pr_user_id"
		);
		$this->db->like('erp_existing_students.batch_', $dep);
		
		$this->db->order_by('reg_no_', 'asc');
		$query = $this->db->get();
		$res = $query->result();
		
		$data['student'] = $res;
		
		//print_r($data);
		
		 $this->load->view("template/mswaided/header");
		$this->load->view("template/mswaided/menubar");
		$this->load->view("template/mswaided/headerbar");
		$this->load->view("mswaided/admittederp", $data);
		$this->load->view("template/mswaided/footer"); 
		
		
		
		}

		public function assignRegisterNumber(){

            $dept = $this->uri->segment(3);
          //  $batch = $this->uri->segment(4);
            
            
            $nt =  $this->db->select("*")->from("student_reg_number_format")->where("batch",date("y"))->where("dep",$dept)->get();
                                    
            $res = $nt->num_rows();
            
            if($res > 0){
            
                $rest = $nt->result();
            
                $reg_format =  $rest[0]->batch.$rest[0]->college_code.$rest[0]->pg_ug.$rest[0]->program_code;
            
                $this->db->select('*');
                $this->db->where('as_status',0);
                $this->db->where('as_dep',$dept);
                $this->db->where('as_reg_num',null);
				$this->db->where('year', $this->syear);
                $this->db->order_by('as_name', 'asc');
                $query = $this->db->get('admitted_student');
                $tot = $query->num_rows();
            
                if($tot > 0){
                $resulte = $query->result();
            
                $this->db->select('*');
                $this->db->where('as_status',1);
                $this->db->where('as_dep',$dept);
				$this->db->where('year', $this->syear);
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
            
               $reg_num = $reg_format.$number;
            
            
            
               $data = array(
                   'as_reg_num'=>$reg_num,
                   'as_status'=>1,
               );
            
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
                    
                    
                        redirect('mswaided/admittedStudent/'); 
                }
            
            
             $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Success !</strong>update in student record.
                </div>');
                
                
                    redirect('mswaided/admittedStudent/'); 

            }else{
            
                $this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Success !</strong>Set Register number format .
                </div>');
                
                
                    redirect('mswaided/admittedStudent/'); 
 
            }
            
            
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
        
     //   echo $reservation;
        
                /*    $sl = $this->db         
                    ->where("sl_main_id", 2)
                    ->where("reservation_status", $status)
                    ->where("selection_list_name", $reservation)
                    ->where(
                        "sl_course_id",
                        $this->session->userdata("user")["user_dep_status"]
                    )
                    ->get("shotlisted_candidate")->result();


					print_r($sl); */
                $sl = $this->db         
                    ->where("sl_main_id", 2)
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
        
                    redirect("mswaided/SelectionStatus", "refresh"); 
        
               // }
            }
			
	public function stuWOZoom()
    {
		$asyear = date('Y',strtotime($this->asyear));
        $user = $this->session->userdata("user");
        $user_id = $user["user_id"];
        $app_course_id = $data["dept"] = $user["user_dep_status"];
		
		$data['panel'] = $this->db->where('user_id', $user_id)->get('panel')->result();
		$data['panel1'] = '';
       
         if(isset($_POST['submit'])){
			 $data['panel1'] = $panel = $this->input->post('panel');
			 $data["stu_list"] = $this->db->select('np.*')
						->join("new_preview_pg np", "np.pr_user_id=zoom_alloc.student_id","left")
						//->join("panel pn", "pn.id=zoom_alloc.panel_id", "left")
                        ->where("zoom_alloc.alc_by", $user_id)
                        ->where("zoom_alloc.app_course_id", $app_course_id)
                        ->where("zoom_alloc.main_course_id", "2")
                        ->where("zoom_alloc.type", "panel")
                        ->where("zoom_alloc.panel_id", $panel)
                        ->where("DATE_FORMAT(zoom_alloc.alc_date, '%Y') = '".$asyear."'")
                        ->get("zoom_alloc")
                        ->result();
                    $data['count'] = sizeof($data["stu_list"]);
		 }

        $this->load->view("template/mswaided/header");
        $this->load->view("template/mswaided/menubar");
        $this->load->view("template/mswaided/headerbar");
        $this->load->view("mswaided/stuWOZoom", $data);
        $this->load->view("template/mswaided/footer");
    }
	
	public function allotPanel()
    {
		$asyear = date('Y',strtotime($this->asyear));
        $user = $this->session->userdata("user");
        $user_id = $user["user_id"];
        $dpmnt = $data["dept"] = $user["user_dep_status"];
		
		$data['panel'] = $this->db->where('user_id', $user_id)->get('panel')->result();
		$data['panel1'] = '';
		$data['cmnty'] = '';
		$data['quota'] = '';
		
		if(isset($_POST['submit'])){
			 $data['panel1'] = $panel = $this->input->post('panel');
			 $panel_det = $this->db->where('id', $panel)->get('panel')->row();
			 $data['limit'] = $limit = $panel_det->count;
			 $data['cmnty'] = $community = $this->input->post('community');
			 $data['quota'] = $quota = $this->input->post('quota');
       
                $stu_dpmnt = $this->db
                    ->query(
                        'select user_id from Applyed_Cources where applied_course_id="' .
                            $dpmnt .
                            '" and main_course_id="2" and DATE_FORMAT(applied_date, "%Y") = "'.$asyear.'" '
                    )
                    ->result();
                $sd = ["0"];
                foreach ($stu_dpmnt as $studp) {
                    array_push($sd, $studp->user_id);
                }
				$link_list = $this->db
                    ->query(
                        'select student_id from zoom_alloc where alc_by="' .
                            $user_id .
                            '" and main_course_id="2" and app_course_id="' .
                            $dpmnt .
                            '" and link_id=0 and type="panel" and DATE_FORMAT(alc_date, "%Y") = '.$asyear.' '
                    )
                    ->result();
                $ll = ["0"];
                foreach ($link_list as $lili) {
                    array_push($ll, $lili->student_id);
                }
				
				if($community!='' && $community!='OC'){ 
				   $this->db->where('pr_community',$community); 
				}
				if($quota!='' && $quota!='Merit' && $quota!='MGT'){ 
				   $this->db->where('pr_other_res','Yes'); 
				   $this->db->where('pr_other_special_reservation',$quota); 
				}
                    $data["stu_list"] = $this->db
                        ->where_in("pr_user_id", $sd)
                        ->where_not_in("pr_user_id", $ll)
                        ->get("new_preview_pg")
                        ->result();
						
				$data["alloted"] = $this->db
                    ->query(
                        'select student_id from zoom_alloc where alc_by="' .
                            $user_id .
                            '" and main_course_id="2" and app_course_id="' .
                            $dpmnt .
                            '" and link_id=0 and type="panel" and panel_id='.$panel.' '
                    )
                    ->num_rows();
				$data["count"] = sizeof($data["stu_list"]);	
				$data["ll"] = count($ll) - 1;
				
				$data["tot_stu"] = $tot_stu = $this->db->select("online_exam_pannel.*")->from("Applyed_Cources")->join("online_exam_pannel","Applyed_Cources.user_id=online_exam_pannel.student_id","left")->join("new_preview_pg","new_preview_pg.pr_user_id=Applyed_Cources.user_id","left")->Where("Applyed_Cources.applied_course_id",$dpmnt)->Where("Applyed_Cources.main_course_id",2)->Where("DATE_FORMAT(applied_date, '%Y') = ".$asyear." ")->Where("online_exam_pannel.exam_category",$this->Subject)->get()->num_rows();
				
				$data["eligible"] = $eligible = $this->db->select("online_exam_pannel.*")->from("Applyed_Cources")->join("online_exam_pannel","Applyed_Cources.user_id=online_exam_pannel.student_id","left")->join("new_preview_pg","new_preview_pg.pr_user_id=Applyed_Cources.user_id")->Where("Applyed_Cources.applied_course_id",$dpmnt)->Where("Applyed_Cources.main_course_id",2)->Where("DATE_FORMAT(applied_date, '%Y') = ".$asyear." ")->Where("online_exam_pannel.exam_category",$this->Subject)->Where("online_exam_pannel.total_mark != 0")->get()->num_rows();
				
				$data["not_eligible"] = $tot_stu - $eligible;
		}

        $this->load->view("template/mswaided/header");
        $this->load->view("template/mswaided/menubar");
        $this->load->view("template/mswaided/headerbar");
        $this->load->view("mswaided/allotPanel", $data);
        $this->load->view("template/mswaided/footer");
    }
	
	public function panelAllocation()
	{
		    $user = $this->session->userdata("user");
            $user_id = $user["user_id"];
            $stu_id = $this->input->post("ids_student");
            $panel_id = $this->input->post("panel");
            $app_course_id = $this->session->userdata("user")[
                "user_dep_status"
            ];
			$add_date=date('Y-m-d H:i:s');
		
    $panel = $this->db->where('id',$panel_id)->get('panel')->row();		

	foreach ($stu_id as $stuid) {
                    $data_st["link_id"] = 0;
                    $data_st["panel_id"] = $panel_id;
                    $data_st["student_id"] = $stuid;
                    $data_st["alc_date"] = $panel->start_date;
                    $data_st["alc_time"] = $panel->start_time;
                    $data_st["alc_duration"] = '';
                    $data_st["alc_by"] = $user_id;
                    $data_st["main_course_id"] = "2";
                    $data_st["app_course_id"] = $app_course_id;
                    $data_st["type"] = 'panel';
                    $data_st["created_at"] = $add_date;
                    $this->db->insert("zoom_alloc", $data_st);
                }
		echo 'success';		
       }
	
	public function updatePanelMarkWOZoom()
	{
		    $user = $this->session->userdata("user");
            $user_id = $user["user_id"];
            $stu_id = $this->input->post("ids_student");
            $per_mark = $this->input->post("per_mark");
            $panel = $this->input->post("panel");
            $app_course_id = $this->session->userdata("user")[
                "user_dep_status"
            ];
			$add_date=date('Y-m-d H:i:s');

			$i = 0;
	foreach ($stu_id as $stuid) {
            $det = $this->db
                ->query(
                    'select new_preview_pg.pr_caste as stu_caste, new_preview_pg.pr_community as stu_comm, sub_preview_pg.UG_two_percentage as ug_perc, online_exam_pannel.total_mark as total_mark from new_preview_pg left join sub_preview_pg on new_preview_pg.pr_user_id=sub_preview_pg.sb_u_id left join online_exam_pannel on online_exam_pannel.student_id=new_preview_pg.pr_user_id where online_exam_pannel.exam_category="'.$this->Subject.'" and new_preview_pg.pr_user_id="'.$stuid.'" '
                )
                ->row();
		
				$data_pmark = [
                "stu_id" => $stuid,
                "exam_name" => $this->Subject,
                "ug_mark" => $det->ug_perc,
                "date" => $add_date,
                "enterence_mark" => $det->total_mark,
                "personal_mark" => $per_mark[$i],
                "community" => $det->stu_comm,
                "cast" => $det->stu_caste,
                "main_course_id" => "2",
                "app_course_id" => $app_course_id,
                "zoom_id" => 0,
                "panel_id" => $panel,
                "type" => "panel",
            ];

            $get_stu = $this->db
                ->where("stu_id", $stuid)
                ->where("exam_name", $this->Subject)
                ->where("app_course_id", $app_course_id)
                ->where("main_course_id", "2")
                ->where("type", "panel")
                ->where("panel_id", $panel)
                ->get("student_complete_mark")
                ->row();
            if (empty($get_stu)) {
                $this->db->insert("student_complete_mark", $data_pmark);
            } else {
                $this->db->where("m_id", $get_stu->m_id);
                $this->db->update("student_complete_mark", $data_pmark);
            }
			$i++;
	}
       }
	   
	   public function createPanel()
    {
		$asyear = date('Y',strtotime($this->asyear));
        $user = $this->session->userdata("user");
        $user_id = $user["user_id"];
        $dpmnt = $data["dept"] = $user["user_dep_status"];
		$add_date=date('Y-m-d H:i:s');
		
		$data['panel'] = $this->db->where('user_id', $user_id)->get('panel')->result();
		$data['stream'] = $this->db->where('main_stream', 2)->get('msw_specialization')->result();
       
        $rules = $this->rules_panel();
        $this->form_validation->set_rules($rules);
        if (isset($_POST["submit"])) {
            if ($this->form_validation->run() == false) {
                $data["form_err"] = $this->session->set_flashdata(
                    "form_err",
                    "Enter Details Correctly",
                    "danger"
                );
            } else {
				
			$edit_id = $this->input->post('edit_id');	
			$title = $this->input->post('title');	
			$start_time = date('H:i:s',strtotime($this->input->post('start_time')));	
			$start_date = date('Y-m-d',strtotime($this->input->post('start_date')));	
			$venue = $this->input->post('venue');		
			$count = $this->input->post('count');	
				$data_in = array(
				'title' => $title,
				'start_time' => $start_time,
				'start_date' => $start_date,
				'venue' => $venue,
				'main_course_id' => 2,
				'app_course_id' => $dpmnt,
				'batch' => $asyear,
				'count' => $count,
				'confirm_status' => 0,
				'user_id' => $user_id,
				);
				
				if($edit_id == ''){
				$data_in['created_at'] =	$add_date;
			$this->db->insert('panel', $data_in);	
			$stat = 'Added';
				}else{
			 $this->db->where('id',$edit_id);		
			$this->db->update('panel', $data_in);	
            $stat = 'Updated';			
				}
				
			$data["mesg"] = $this->session->set_flashdata(
                    "success",
                    "Panel ".$stat." Successfully!!",
                    "success"
                );	
			redirect('mswaided/createPanel','refresh');	
			}
		}

        $this->load->view("template/mswaided/header");
        $this->load->view("template/mswaided/menubar");
        $this->load->view("template/mswaided/headerbar");
        $this->load->view("mswaided/createPanel", $data);
        $this->load->view("template/mswaided/footer");
    }
	public function updatePanel()
	{
            $id = $this->input->post("id");
			$panel = $this->db->select('*, CAST(start_time as time(0)) as time1')->where('id', $id)->get('panel')->row();
		echo json_encode($panel);	
	}
	public function deletePanel()
	{
		    $id = $this->input->post("id");
			$this->db->where('id', $id)->delete('panel');
			$this->db->where('panel_id', $id)->delete('zoom_alloc');
		echo 'success';	
	}
	public function publishPanelWOZoom()
    {

        $user_id = [];
        $send_email = "";

        $id = $this->input->post("panel_id");
        $defect = $this->db
            ->select("*")
            ->from("panel")
            ->where("id", $id)
            ->get();
        $ids = $defect->result();

        $student = $this->db
            ->select("*")
            ->from("zoom_alloc")
            ->where("panel_id", $id)
            ->get();
        $sl = $student->result();
if($ids[0]->confirm_status==0){

     foreach ($sl as $key => $value) {
            array_push($user_id, $value->student_id);
        }

$m = $this->db->select("*")->from("stu_user")->where_in("u_id",$user_id)->get();

$r = $m->result();

print_r($r);

foreach ($r as $key => $value) {

	$user = $this->db
	->select("*")
	->from("new_preview_pg")

	->where("pr_user_id", $value->u_id)
	->get();
$user_details = $user->result();


$application = $this->db
                ->select("*")
                ->from("Applyed_Cources")
                ->where("main_course_id", 2)
                ->where(
                    "applied_course_id",
                    $this->session->userdata("user")["user_dep_status"]
                )
                ->where("user_id", $value->u_id)
                ->get();
            $app_details = $application->result();




	$subject =
	"MSSW Admission - Shortlisted for Interview - Regarding";
	$msg =
		"Dear Mr./Ms." .
		$user_details[0]->pr_applicant_name .
		" ,<br> 

	Greetings! <br> 

	With reference to your application for " .
		$app_details[0]->course_name .
		", Application Number: " .
		$app_details[0]->application_number .
		",<br> 
	Appear for the Interview on {" .
		date("d-m-Y", strtotime($ids[0]->start_date)) .
		"} at {" .
		date("H:i", strtotime($ids[0]->start_time)) .
		"}.<br> 
	

	Visit <a href='https://mssw.in/admissions/#PGAdmissions'>P.G.admissions</a> page and check your login for more details.<br><br>  <br> 

	Regards,<br><br>  

	Principal, MSSW.<br> 
	www.mssw.in
	";


 $msg."<br>";

$panel = [
	"confirm_status" => 1,
];
$this->db->where("id", $id);
$this->db->Update("panel", $panel);


$panel_complete = [
	"publish_link" => 1,
	"publish_date" => date("Y-m-d H:i:s"),
	"publish_by" => $this->session->userdata("user")["user_id"],
];

$this->db->where("panel_id", $id);
$this->db->Update("zoom_alloc", $panel_complete);


$this->smspublishedInterview($user_details[0]->pr_applicant_name,$value->u_mobile);
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
   
//$this->testEmail($mail->u_email_id, $subject, $msg);



echo "success";
	
}
    
    }
	
	public function panelPdfWOZoom()
    {
        $pannel_id = $this->uri->segment(3);

        $pr_user = $this->db
            ->select("*")
            ->from("panel")
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
                "new_preview_pg",
                "zoom_alloc.student_id=new_preview_pg.pr_user_id"
            )
            ->join(
                "sub_preview_pg",
                "zoom_alloc.student_id=sub_preview_pg.sb_u_id",
                "left"
            )
            ->join(
                "online_exam_pannel",
                "zoom_alloc.student_id=online_exam_pannel.student_id",
                "left"
            )
            ->Where("online_exam_pannel.exam_category", $this->Subject)
            ->Where("Applyed_Cources.main_course_id", 2)
            ->Where(
                "Applyed_Cources.applied_course_id",
                $this->session->userdata("user")["user_dep_status"]
            )
            ->where("zoom_alloc.panel_id", $pannel_id)
            ->where("zoom_alloc.type", "panel")
            ->get();

        $nm = $m->result();

        $depname = $this->db
            ->select("*")
            ->from("college_course")
            ->Where("mc_id", 2)
            ->Where(
                "cs_id",
                3
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
                "22" .
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
<img  src="https://admission.mssw.in//landing/images/mssw_logo.jpg" width="60%" height="75px;">
</div>  

<br>
<h3 align="center"> Interview Schedule For ' .
            $nm[0]->course_name .
            '</h3>
<h5>  Interview Name :' .
            $usd[0]->title .
            '</h5>
<h5> Interview Date & Time : ' .
            date("d-m-Y", strtotime($usd[0]->start_date)) .
            ' & ' .
            date("H:i ", strtotime($usd[0]->start_time)) .
            ' (24-hour) Mins
			 </h5>
<h5>  Venue :' .
            $usd[0]->venue .
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
            ob_end_clean();
        $dompdf->load_html($html);
        $dompdf->render();

        $dompdf->stream($usd[0]->title . "pdf", array("Attachment" => 1));
    }
	public function smspublishedInterview($name_stud,$mobilenum){


		$name=$name_stud;
		if($name != "" || $name !=NULL){
		$thank="Thank You";
		$msg=	"Dear ".$name.", Interview list is published. Check your login %26 visit the website for more details. Regards, Principal, MSSW. ".$thank;
		
		$msg_1 = str_replace(" ","%20",$msg);
		
		//echo $msg_1;
		
		$mobile = $mobilenum;
		$sms_mob = substr($mobile,-10);
		
		$smsmsg = "http://sms.dial4sms.com:6005/api/v2/SendSMS?SenderId=MSSWAO&Is_Unicode=false&Message=".$msg_1."&MobileNumbers=".$sms_mob."&PrincipleEntityId=1001042071762463166&TemplateId=1007516732559371133&ApiKey=w6cDSY8S%2FIvqr0STG4KJhQ7itInAWx2OfNpBR%2FuyV78%3D&ClientId=3cfc5042-9835-498c-b37f-0ee1a5a8393f";
		
		
			$url = $smsmsg;
			
			$ch = curl_init();                       // initialize CURL
			curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			 $output = curl_exec($ch);
			curl_close($ch);  
			
		
		}
		
		}   

		public function convertWaitingList(){


			 $tmr = $_POST["sel"];
		
		
			$user = $this->db
			->select("*")
			->from("shotlisted_candidate")
			->join(
				"Applyed_Cources",
				"Applyed_Cources.user_id=shotlisted_candidate.sl_student_id AND Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id"
			)
			
			->where("sl_main_id", 2)
			
			->where(
				"sl_course_id",
				$this->session->userdata("user")["user_dep_status"]
			)
			->where(
				"Applyed_Cources.applied_date >=",$this->asyear
			   
			)->where(
				"Applyed_Cources.applied_date <",$this->aeyear
			   
			)
			->where("reservation_status", 2)
				->where('shotlisted_candidate.created >',$this->syear.'-06-01')
				->where('shotlisted_candidate.created <',$this->eyear.'-06-01')
			
			->get();
		
			
		
		$resul_num = $user->num_rows();
		
		if($resul_num > 0 ){
		$resul = $user->result();
		
		/* echo "<pre>";
		
		print_r($resul) */;
		
		foreach ($resul as $key => $value) {
			$data= array(
				'selection_list'=>$tmr,
			);
		
		
			$this->db->where('sl_id',$value->sl_id);
			$this->db->update('shotlisted_candidate',$data);
		}
		echo $this->session->set_flashdata(
			"message",
			' <div class="alert alert-success alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Success !</strong> List Updated Successfully !</div> ' );
		}else{
		
			echo $this->session->set_flashdata(
				"message",
				' <div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Failed !</strong> No data found to update !</div> ' );
		
		
		}
		}
		
		public function ManualSelectWaitingList()
		{
			$tmr = $_POST["id"];
			$sel = $_POST["sel"];
	

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
	
	
}
