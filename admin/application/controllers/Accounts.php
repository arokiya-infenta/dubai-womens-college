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

class Accounts extends CI_Controller
{
	public $asyear;
	public $aeyear;
	public $syear;
	public $eyear;
	public function __construct()
	{
		parent::__construct();
	  error_reporting(0);
		date_default_timezone_set("Asia/Calcutta");
		$this->load->library('upload');
		$this->load->config('email');
		$this->load->library('email');
		$this->load->helper(array('form', 'url'));
		$this->load->library('pdf');
		$this->load->library('useracadamic');
		if ($this->session->userdata("user")["user_aca_year"] == "" || $this->session->userdata("user")["user_aca_year"] == "0000") {
			$this->asyear = "2021/04/01 00:00:00";
			$this->aeyear = "2022/04/01  00:00:00";
		} else {
			$this->asyear = $this->session->userdata("user")["user_aca_year"] . "/04/01  00:00:00";
			$this->aeyear = $this->session->userdata("user")["user_aca_year"] + 1 . "/04/01  00:00:00";
			$this->syear = $this->session->userdata("user")["user_aca_year"];
			$this->eyear = $this->session->userdata("user")["user_aca_year"] + 1;
		}
	}

	public function index()
	{
		$this->load->view('template/accounts/header');
		$this->load->view('template/accounts/menubar');
		$this->load->view('template/accounts/headerbar');
		$this->load->view('accounts/dashbord');
		$this->load->view('template/accounts/footer');
	}

	public function categoryManage()
	{
		$data['category'] = $this->db->select("*")->from("accounts_category")->get()->result();

		$this->load->view('template/accounts/header');
		$this->load->view('template/accounts/menubar');
		$this->load->view('template/accounts/headerbar');
		$this->load->view('accounts/managecategory', $data);
		$this->load->view('template/accounts/footer');
	}

	public function addCategory()
	{
		$name = $this->input->post("name");

		$data = array(
			'ac_name' => $name,
		);

		$this->db->insert("accounts_category", $data);

		$this->session->set_flashdata(
			"message",
			' <div class="alert alert-success alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Success !</strong> Category Inserted Successfully .
	</div>'
		);

		redirect("Accounts/categoryManage/", "refresh");
	}
	public function editCategory()
	{
		$name = $this->input->post("name");
		$id = $this->input->post("id");

		$data = array(
			'ac_name' => $name,
		);

		$this->db->Where("ac_id", $id);
		$this->db->update("accounts_category", $data);

		$this->session->set_flashdata(
			"message",
			' <div class="alert alert-success alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Success !</strong> Category Updated Successfully .
		</div>'
		);

		redirect("Accounts/categoryManage/", "refresh");
	}

	public function do_upload()
	{
		$config = array();
		$config['upload_path'] = './system/image/accounts/';
		$config['allowed_types'] = '*';
		$config['remove_spaces'] = TRUE;
		$config['overwrite'] = TRUE;
		return $config;
	}
	public function selectionDashbord()
	{
		$this->load->view('template/accounts/header');
		$this->load->view('template/accounts/menubar');
		$this->load->view('template/accounts/headerbar');
		$this->load->view('accounts/selectiondashboard');
		$this->load->view('template/accounts/footer');
	}
	public function accademicFees()
	{
		$data['get_fees_type'] = $get_fees_type = $this->db->where('status', 1)->get('fees_master')->result();
		$user = $this->session->userdata("user")["user_id"];

		date_default_timezone_get();
		$add_date = date('Y-m-d h:i:s');

		if (isset($_POST['submit'])) {
			$main_course_id = $this->input->post('main_course_id');
			$app_course_id = $this->input->post('app_course_id');
			$year = $this->input->post('year');
			if ($year == 1) {
				$fees_master = 'fees_master';
			}
			if ($year == 2) {
				$fees_master = 'fees_master2';
			}
			if ($year == 3) {
				$fees_master = 'fees_master3';
			}
			foreach ($get_fees_type as $getfeestype) {
				if ($this->input->post('' . $getfeestype->id . '') != '') {
					$course = 'main_' . $main_course_id . '_app_' . $app_course_id . '';
					$data_upd['' . $course . ''] = $this->input->post('' . $getfeestype->id . '');
					$data_upd['created_by'] = $user;
					$this->db->where('id', $getfeestype->id);
					$update = $this->db->update($fees_master, $data_upd);
				}
			}
			if ($this->input->post('penalty') != '') {
				$data_pen['created_by'] = $user;
				$course1 = 'main_' . $main_course_id . '_app_' . $app_course_id . '';
				$data_pen['' . $course1 . ''] = $this->input->post('penalty');
				$this->db->where('name', 'Penalty');
				$update = $this->db->update($fees_master, $data_pen);
			}
			if ($this->input->post('due_date') != '') {
				$data_due['created_by'] = $user;
				$course2 = 'main_' . $main_course_id . '_app_' . $app_course_id . '';
				$data_due['' . $course2 . ''] = date('Y-m-d', strtotime($this->input->post('due_date')));
				$this->db->where('name', 'Due Date');
				$update = $this->db->update($fees_master, $data_due);
			}
			if ($this->input->post('gst_stat') != '') {
				$data_gstat['created_by'] = $user;
				$course3 = 'main_' . $main_course_id . '_app_' . $app_course_id . '';
				$data_gstat['' . $course3 . ''] = $this->input->post('gst_stat');
				$this->db->where('name', 'GST Status');
				$update = $this->db->update($fees_master, $data_gstat);
			}
			if ($this->input->post('gst_val') != '') {
				$data_gval['created_by'] = $user;
				$course4 = 'main_' . $main_course_id . '_app_' . $app_course_id . '';
				if ($this->input->post('gst_stat') != 0) {
					$data_gval['' . $course4 . ''] = $this->input->post('gst_val');
				} else {
					$data_gval['' . $course4 . ''] = 0;
				}
				$this->db->where('name', 'GST Value');
				$update = $this->db->update($fees_master, $data_gval);
			}
			if ($this->input->post('gst_amt') != '') {
				$data_gamt['created_by'] = $user;
				$course5 = 'main_' . $main_course_id . '_app_' . $app_course_id . '';
				if ($this->input->post('gst_stat') != 0) {
					$data_gamt['' . $course5 . ''] = $this->input->post('gst_amt');
				} else {
					$data_gamt['' . $course5 . ''] = 0;
				}
				$this->db->where('name', 'GST Amount');
				$update = $this->db->update($fees_master, $data_gamt);
			}
			if ($this->input->post('total') != '') {
				$data_tot['created_by'] = $user;
				$course5 = 'main_' . $main_course_id . '_app_' . $app_course_id . '';
				$data_tot['' . $course5 . ''] = $this->input->post('total');
				$this->db->where('name', 'Total');
				$update = $this->db->update($fees_master, $data_tot);
			}
			if ($this->input->post('installment_status') != '') {
				$data_ins_stat['created_by'] = $user;
				$course_ins_stat = 'main_' . $main_course_id . '_app_' . $app_course_id . '';
				$data_ins_stat['' . $course_ins_stat . ''] = $this->input->post('installment_status');
				$this->db->where('name', 'Installment Status');
				$update = $this->db->update($fees_master, $data_ins_stat);
			}
			$coursen = 'main_' . $main_course_id . '_app_' . $app_course_id . '';
			$data_n['' . $coursen . ''] = null;
			$this->db->where('name', 'Installment1');
			$update = $this->db->update($fees_master, $data_n);
			$this->db->where('name', 'Installment2');
			$update = $this->db->update($fees_master, $data_n);
			$this->db->where('name', 'Installment3');
			$update = $this->db->update($fees_master, $data_n);
			$this->db->where('name', 'Installment4');
			$update = $this->db->update($fees_master, $data_n);
			$this->db->where('name', 'Installment5');
			$update = $this->db->update($fees_master, $data_n);
			$this->db->where('name', 'Installment_perc1');
			$update = $this->db->update($fees_master, $data_n);
			$this->db->where('name', 'Installment_perc2');
			$update = $this->db->update($fees_master, $data_n);
			$this->db->where('name', 'Installment_perc3');
			$update = $this->db->update($fees_master, $data_n);
			$this->db->where('name', 'Installment_perc4');
			$update = $this->db->update($fees_master, $data_n);
			$this->db->where('name', 'Installment_perc5');
			$update = $this->db->update($fees_master, $data_n);
			$this->db->where('name', 'Installment_date1');
			$update = $this->db->update($fees_master, $data_n);
			$this->db->where('name', 'Installment_date2');
			$update = $this->db->update($fees_master, $data_n);
			$this->db->where('name', 'Installment_date3');
			$update = $this->db->update($fees_master, $data_n);
			$this->db->where('name', 'Installment_date4');
			$update = $this->db->update($fees_master, $data_n);
			$this->db->where('name', 'Installment_date5');
			$update = $this->db->update($fees_master, $data_n);
			$this->db->where('name', 'Interest');
			$update = $this->db->update($fees_master, $data_n);
			if ($this->input->post('installment1') != '') {
				$data_inst1['created_by'] = $user;
				$course6 = 'main_' . $main_course_id . '_app_' . $app_course_id . '';
				$data_inst1['' . $course6 . ''] = $this->input->post('installment1');
				$this->db->where('name', 'Installment1');
				$update = $this->db->update($fees_master, $data_inst1);
			}
			if ($this->input->post('installment2') != '') {
				$data_inst2['created_by'] = $user;
				$course7 = 'main_' . $main_course_id . '_app_' . $app_course_id . '';
				$data_inst2['' . $course7 . ''] = $this->input->post('installment2');
				$this->db->where('name', 'Installment2');
				$update = $this->db->update($fees_master, $data_inst2);
			}
			if ($this->input->post('installment3') != '') {
				$data_inst3['created_by'] = $user;
				$course8 = 'main_' . $main_course_id . '_app_' . $app_course_id . '';
				$data_inst3['' . $course8 . ''] = $this->input->post('installment3');
				$this->db->where('name', 'Installment3');
				$update = $this->db->update($fees_master, $data_inst3);
			}
			if ($this->input->post('installment4') != '') {
				$data_inst4['created_by'] = $user;
				$course9 = 'main_' . $main_course_id . '_app_' . $app_course_id . '';
				$data_inst4['' . $course9 . ''] = $this->input->post('installment4');
				$this->db->where('name', 'Installment4');
				$update = $this->db->update($fees_master, $data_inst4);
			}
			if ($this->input->post('installment5') != '') {
				$data_inst5['created_by'] = $user;
				$course10 = 'main_' . $main_course_id . '_app_' . $app_course_id . '';
				$data_inst5['' . $course10 . ''] = $this->input->post('installment5');
				$this->db->where('name', 'Installment5');
				$update = $this->db->update($fees_master, $data_inst5);
			}
			if ($this->input->post('installment_perc1') != '') {
				$data_instp1['created_by'] = $user;
				$course11 = 'main_' . $main_course_id . '_app_' . $app_course_id . '';
				$data_instp1['' . $course11 . ''] = $this->input->post('installment_perc1');
				$this->db->where('name', 'Installment_perc1');
				$update = $this->db->update($fees_master, $data_instp1);
			}
			if ($this->input->post('installment_perc2') != '') {
				$data_instp2['created_by'] = $user;
				$course12 = 'main_' . $main_course_id . '_app_' . $app_course_id . '';
				$data_instp2['' . $course12 . ''] = $this->input->post('installment_perc2');
				$this->db->where('name', 'Installment_perc2');
				$update = $this->db->update($fees_master, $data_instp2);
			}
			if ($this->input->post('installment_perc3') != '') {
				$data_instp3['created_by'] = $user;
				$course13 = 'main_' . $main_course_id . '_app_' . $app_course_id . '';
				$data_instp3['' . $course13 . ''] = $this->input->post('installment_perc3');
				$this->db->where('name', 'Installment_perc3');
				$update = $this->db->update($fees_master, $data_instp3);
			}
			if ($this->input->post('installment_perc4') != '') {
				$data_instp4['created_by'] = $user;
				$course14 = 'main_' . $main_course_id . '_app_' . $app_course_id . '';
				$data_instp4['' . $course14 . ''] = $this->input->post('installment_perc4');
				$this->db->where('name', 'Installment_perc4');
				$update = $this->db->update($fees_master, $data_instp4);
			}
			if ($this->input->post('installment_perc5') != '') {
				$data_instp5['created_by'] = $user;
				$course15 = 'main_' . $main_course_id . '_app_' . $app_course_id . '';
				$data_instp5['' . $course15 . ''] = $this->input->post('installment_perc5');
				$this->db->where('name', 'Installment_perc5');
				$update = $this->db->update($fees_master, $data_instp5);
			}
			if ($this->input->post('installment_date1') != '') {
				$data_instd1['created_by'] = $user;
				$course18 = 'main_' . $main_course_id . '_app_' . $app_course_id . '';
				$data_instd1['' . $course18 . ''] = date('Y-m-d', strtotime($this->input->post('installment_date1')));
				$this->db->where('name', 'Installment_date1');
				$update = $this->db->update($fees_master, $data_instd1);
			}
			if ($this->input->post('installment_date2') != '') {
				$data_instd2['created_by'] = $user;
				$course19 = 'main_' . $main_course_id . '_app_' . $app_course_id . '';
				$data_instd2['' . $course19 . ''] = date('Y-m-d', strtotime($this->input->post('installment_date2')));
				$this->db->where('name', 'Installment_date2');
				$update = $this->db->update($fees_master, $data_instd2);
			}
			if ($this->input->post('installment_date3') != '') {
				$data_instd3['created_by'] = $user;
				$course20 = 'main_' . $main_course_id . '_app_' . $app_course_id . '';
				$data_instd3['' . $course20 . ''] = date('Y-m-d', strtotime($this->input->post('installment_date3')));
				$this->db->where('name', 'Installment_date3');
				$update = $this->db->update($fees_master, $data_instd3);
			}
			if ($this->input->post('installment_date4') != '') {
				$data_instd4['created_by'] = $user;
				$course21 = 'main_' . $main_course_id . '_app_' . $app_course_id . '';
				$data_instd4['' . $course21 . ''] = date('Y-m-d', strtotime($this->input->post('installment_date4')));
				$this->db->where('name', 'Installment_date4');
				$update = $this->db->update($fees_master, $data_instd4);
			}
			if ($this->input->post('installment_date5') != '') {
				$data_instd5['created_by'] = $user;
				$course22 = 'main_' . $main_course_id . '_app_' . $app_course_id . '';
				$data_instd5['' . $course22 . ''] = date('Y-m-d', strtotime($this->input->post('installment_date5')));
				$this->db->where('name', 'Installment_date5');
				$update = $this->db->update($fees_master, $data_instd5);
			}
			if ($this->input->post('interest') != '') {
				$data_int['created_by'] = $user;
				$course16 = 'main_' . $main_course_id . '_app_' . $app_course_id . '';
				$data_int['' . $course16 . ''] = $this->input->post('interest');
				$this->db->where('name', 'Interest');
				$update = $this->db->update($fees_master, $data_int);
			}
			if ($this->input->post('batch') != '') {
				$data_bat['created_by'] = $user;
				$course17 = 'main_' . $main_course_id . '_app_' . $app_course_id . '';
				$data_bat['' . $course17 . ''] = $this->input->post('batch');
				$this->db->where('name', 'Batch');
				$update = $this->db->update($fees_master, $data_bat);
			}
			redirect('accounts/accademicFees', 'refresh');
		}
		$this->load->view('template/accounts/header');
		$this->load->view('template/accounts/menubar');
		$this->load->view('template/accounts/headerbar');
		$this->load->view('accounts/accademicfees', $data);
		$this->load->view('template/accounts/footer');
	}
	public function get_fees()
	{
		$main_course_id = $this->input->post('main_course_id');
		$app_course_id = $this->input->post('app_course_id');
		$year = $this->input->post('year');
		if ($year == 1) {
			$get_fees_type = $this->db->get('fees_master')->result();
		}
		if ($year == 2) {
			$get_fees_type = $this->db->get('fees_master2')->result();
		}
		if ($year == 3) {
			$get_fees_type = $this->db->get('fees_master3')->result();
		}
		echo json_encode($get_fees_type);
	}

	public function concession()
	{
		$data['get_fees_type'] = $this->db->where('status', 1)->get('fees_master')->result();
		$user = $this->session->userdata("user")["user_id"];

		date_default_timezone_get();
		$add_date = date('Y-m-d h:i:s');

		if (isset($_POST['submit'])) {
			$data_con['stu_id'] = $stu_id = $this->input->post('students');
			$data_con['main_course_id'] = $main_course_id = $this->input->post('main_course_id');
			$data_con['app_course_id'] = $app_course_id = $this->input->post('app_course_id');
			$data_con['concession'] = $this->input->post('concession');
			$data_con['penalty'] = $this->input->post('penalty');
			$data_con['scholarship'] = $this->input->post('scholarship');
			$data_con['refund'] = $this->input->post('refund');
			if ($this->input->post('exemption') != '') {
				$data_con['exemption'] = implode(',', $this->input->post('exemption'));
			}
			$data_con['announcement'] = $this->input->post('announcement');
			$data_con['created_by'] = $user;
			$data_con['created_at'] = $add_date;

			$get_concession = $this->db->where('main_course_id', $main_course_id)->where('app_course_id', $app_course_id)->where('stu_id', $stu_id)->get('concession')->row();

			if ($_FILES['concession_doc']['size'] != 0) {
				if (isset($get_concession) && $get_concession->concession_doc != '') {
					$get_path = $array = explode('-', $get_concession->concession_doc, 2);
					if ($get_path[1] == $_FILES['concession_doc']['name']) {
						unlink(APPPATH . '../' . $get_concession->concession_doc);
					}
				}
				$_FILES["file"]["name"] = rand() . '-' . $_FILES["concession_doc"]["name"];
				$_FILES["file"]["type"] = $_FILES["concession_doc"]["type"];
				$_FILES["file"]["tmp_name"] = $_FILES["concession_doc"]["tmp_name"];
				$_FILES["file"]["error"] = $_FILES["concession_doc"]["error"];
				$_FILES["file"]["size"] = $_FILES["concession_doc"]["size"];

				$this->upload->initialize($this->do_upload());
				if ($pic = $this->upload->do_upload('file')) {
					$file = $this->upload->data();
					$image = $file['file_name'];
					$data_con['concession_doc'] = 'system/image/accounts/' . $image;
				} else {
					$error = array('error' => $this->upload->display_errors());
					print_r($error);
					exit;
				}
			}

			if ($_FILES['penalty_doc']['size'] != 0) {
				if (isset($get_concession) && $get_concession->penalty_doc != '') {
					$get_path = $array = explode('-', $get_concession->penalty_doc, 2);
					if ($get_path[1] == $_FILES['penalty_doc']['name']) {
						unlink(APPPATH . '../' . $get_concession->penalty_doc);
					}
				}
				$_FILES["file"]["name"] = rand() . '-' . $_FILES["penalty_doc"]["name"];
				$_FILES["file"]["type"] = $_FILES["penalty_doc"]["type"];
				$_FILES["file"]["tmp_name"] = $_FILES["penalty_doc"]["tmp_name"];
				$_FILES["file"]["error"] = $_FILES["penalty_doc"]["error"];
				$_FILES["file"]["size"] = $_FILES["penalty_doc"]["size"];

				$this->upload->initialize($this->do_upload());
				if ($pic = $this->upload->do_upload('file')) {
					$file = $this->upload->data();
					$image = $file['file_name'];
					$data_con['penalty_doc'] = 'system/image/accounts/' . $image;
				} else {
					$error = array('error' => $this->upload->display_errors());
					print_r($error);
					exit;
				}
			}

			if ($_FILES['scholarship_doc']['size'] != 0) {
				if (isset($get_concession) && $get_concession->scholarship_doc != '') {
					$get_path = $array = explode('-', $get_concession->scholarship_doc, 2);
					if ($get_path[1] == $_FILES['scholarship_doc']['name']) {
						unlink(APPPATH . '../' . $get_concession->scholarship_doc);
					}
				}
				$_FILES["file"]["name"] = rand() . '-' . $_FILES["scholarship_doc"]["name"];
				$_FILES["file"]["type"] = $_FILES["scholarship_doc"]["type"];
				$_FILES["file"]["tmp_name"] = $_FILES["scholarship_doc"]["tmp_name"];
				$_FILES["file"]["error"] = $_FILES["scholarship_doc"]["error"];
				$_FILES["file"]["size"] = $_FILES["scholarship_doc"]["size"];

				$this->upload->initialize($this->do_upload());
				if ($pic = $this->upload->do_upload('file')) {
					$file = $this->upload->data();
					$image = $file['file_name'];
					$data_con['scholarship_doc'] = 'system/image/accounts/' . $image;
				} else {
					$error = array('error' => $this->upload->display_errors());
					print_r($error);
					exit;
				}
			}

			if ($_FILES['refund_doc']['size'] != 0) {
				if (isset($get_concession) && $get_concession->refund_doc != '') {
					$get_path = $array = explode('-', $get_concession->refund_doc, 2);
					if ($get_path[1] == $_FILES['refund_doc']['name']) {
						unlink(APPPATH . '../' . $get_concession->refund_doc);
					}
				}
				$_FILES["file"]["name"] = rand() . '-' . $_FILES["refund_doc"]["name"];
				$_FILES["file"]["type"] = $_FILES["refund_doc"]["type"];
				$_FILES["file"]["tmp_name"] = $_FILES["refund_doc"]["tmp_name"];
				$_FILES["file"]["error"] = $_FILES["refund_doc"]["error"];
				$_FILES["file"]["size"] = $_FILES["refund_doc"]["size"];

				$this->upload->initialize($this->do_upload());
				if ($pic = $this->upload->do_upload('file')) {
					$file = $this->upload->data();
					$image = $file['file_name'];
					$data_con['refund_doc'] = 'system/image/accounts/' . $image;
				} else {
					$error = array('error' => $this->upload->display_errors());
					print_r($error);
					exit;
				}
			}

			if (!isset($get_concession)) {
				$insert = $this->db->insert('concession', $data_con);
			} else {
				$this->db->where('id', $get_concession->id);
				$update = $this->db->update('concession', $data_con);
			}
			redirect('accounts/concession', 'refresh');
		}

		$this->load->view('template/accounts/header');
		$this->load->view('template/accounts/menubar');
		$this->load->view('template/accounts/headerbar');
		$this->load->view('accounts/concession', $data);
		$this->load->view('template/accounts/footer');
	}

	public function get_concession()
	{
		$main_course_id = $this->input->post('main_course_id');
		$app_course_id = $this->input->post('app_course_id');
		$stu_id = $this->input->post('stu_id');
		$get_concession = $this->db->where('main_course_id', $main_course_id)->where('app_course_id', $app_course_id)->where('stu_id', $stu_id)->get('concession')->result();
		echo json_encode($get_concession);
	}

	public function get_app_course_id()
	{
		$main_course_id = $this->input->post('main_course_id');

		if ($main_course_id == 1) {
			$pg_sf = $this->db->where('cs_id=5 or cs_id=6 or cs_id=7 or cs_id=8 or cs_id=9 or cs_id=15 or cs_id=16')->get('college_course')->result();
			$option = "<option value=''>Select an Option</option>";
			foreach ($pg_sf as $pgsf) {
				$option .= "<option value='" . $pgsf->cs_id . "'>" . $pgsf->cs_name . "</option>";
			}
			echo $option;
		} else if ($main_course_id == 2 || $main_course_id == 3) {
			$option = "<option value=''>Select an Option</option>";
			$pg_msw = array('1' => 'Community Development', '2' => 'Medical & Psychiatric Social Work', '3' => 'Human Resource Management');
			foreach ($pg_msw as $key => $pgmsw) {
				$option .= "<option value='" . $key . "'>" . $pgmsw . "</option>";
			}
			echo $option;
		} else if ($main_course_id == 4) {
			$option = "<option value=''>Select an Option</option>";
			$option .= "<option value='10'>Personnel Management & Industrial Relations (SF)</option>";
			$option .= "<option value='11'>Human Resource Management (SF)</option>";
			echo $option;
		} else if ($main_course_id == 5) {
			$option = "<option value=''>Select an Option</option>";
			$option .= "<option value='1'>B.S.W (SF)</option>";
			$option .= "<option value='2'>B.Sc Psychology (SF)</option>";
			echo $option;
		} else {
			echo $option = "<option value=''>Select an Option</option>";
		}
	}
	public function get_app_course_add_id()
	{
		$main_course_id = $this->input->post('main_course_id');

		if ($main_course_id == 1) {
			$pg_sf = $this->db->where('cs_id=5 or cs_id=6 or cs_id=7 or cs_id=8 or cs_id=9 or cs_id=15 or cs_id=16')->get('college_course')->result();
			$option = "<option value=''>Select an Option</option>";
			foreach ($pg_sf as $pgsf) {
				$option .= "<option value='" . $pgsf->cs_id . "'>" . $pgsf->cs_name . "</option>";
			}
			echo $option;
		} else if ($main_course_id == 2 || $main_course_id == 3) {
			$option = "<option value=''>Select an Option</option>";
			$pg_msw = array('1' => 'Community Development', '2' => 'Medical & Psychiatric Social Work', '3' => 'Human Resource Management');
			foreach ($pg_msw as $key => $pgmsw) {
				$option .= "<option value='" . $key . "'>" . $pgmsw . "</option>";
			}
			echo $option;
		} else if ($main_course_id == 4) {
			$option = "<option value=''>Select an Option</option>";
			$option .= "<option value='10'>Personnel Management & Industrial Relations (SF)</option>";
			$option .= "<option value='11'>Human Resource Management (SF)</option>";
			echo $option;
		} else if ($main_course_id == 5) {
			$option = "<option value=''>Select an Option</option>";
			$option .= "<option value='1'>B.S.W (SF)</option>";
			$option .= "<option value='2'>B.Sc Psychology (SF)</option>";
			echo $option;
		} else {
			echo $option = "<option value=''>Select an Option</option>";
		}
	}
	public function get_app_course_id_fun()
	{
		$main_course_id = $this->input->post('main_course_id');

		if ($main_course_id == 1) {
			$pg_sf = $this->db->where('cs_id=5 or cs_id=6 or cs_id=7 or cs_id=8 or cs_id=9 or cs_id=15 or cs_id=16')->get('college_course')->result();
			$option = "<option value=''>Select an Option</option>";
			foreach ($pg_sf as $pgsf) {
				$option .= "<option value='" . $pgsf->cs_id . "'>" . $pgsf->cs_name . "</option>";
			}
			echo $option;
		} else if ($main_course_id == 2 || $main_course_id == 3) {
			$option = "<option value=''>Select an Option</option>";
			$pg_msw = array('1' => 'Community Development', '2' => 'Medical & Psychiatric Social Work', '3' => 'Human Resource Management');
			foreach ($pg_msw as $key => $pgmsw) {
				$option .= "<option value='" . $key . "'>" . $pgmsw . "</option>";
			}
			echo $option;
		} else if ($main_course_id == 4) {
			$option = "<option value=''>Select an Option</option>";
			$option .= "<option value='10'>Personnel Management & Industrial Relations (SF)</option>";
			$option .= "<option value='11'>Human Resource Management (SF)</option>";
			echo $option;
		} else if ($main_course_id == 5) {
			$option = "<option value=''>Select an Option</option>";
			$option .= "<option value='1'>B.S.W (SF)</option>";
			$option .= "<option value='2'>B.Sc Psychology (SF)</option>";
			echo $option;
		}else if ($main_course_id == 6) {
			$option = "<option value=''>Select an Option</option>";
			$option .= "<option value='0'>All</option>";
			//$option .= "<option value='2'>B.Sc Psychology (SF)</option>";
			echo $option;
		} else {
			echo $option = "<option value=''>Select an Option</option>";
		}
	}
	public function get_selected_app_course_id()
	{
		$main_course_id = $this->input->post('main_course_id');
		$crsid = $this->input->post('crsid');

		if ($main_course_id == 1) {
			$pg_sf = $this->db->where('cs_id=5 or cs_id=6 or cs_id=7 or cs_id=8 or cs_id=9 or cs_id=15 or cs_id=16')->get('college_course')->result();
			$option = "<option value=''>Select an Option</option>";
			foreach ($pg_sf as $pgsf) {
				if ($crsid == $pgsf->cs_id) {
					$option .= "<option value='" . $pgsf->cs_id . "' selected >" . $pgsf->cs_name . "</option>";
				} else {
					$option .= "<option value='" . $pgsf->cs_id . "'>" . $pgsf->cs_name . "</option>";
				}
			}
			echo $option;
		} else if ($main_course_id == 2 || $main_course_id == 3) {
			$option = "<option value=''>Select an Option</option>";
			$pg_msw = array('1' => 'Community Development', '2' => 'Medical & Psychiatric Social Work', '3' => 'Human Resource Management');
			foreach ($pg_msw as $key => $pgmsw) {
				if ($crsid == $key) {
					$option .= "<option value='" . $key . "' selected >" . $pgmsw . "</option>";
				} else {
					$option .= "<option value='" . $key . "'>" . $pgmsw . "</option>";
				}
			}
			echo $option;
		} else if ($main_course_id == 4) {
			$option = "<option value=''>Select an Option</option>";
			if ($crsid == 10) {
				$option .= "<option  value='10 selected'>Personnel Management & Industrial Relations (SF)</option>";
			} else {
				$option .= "<option  value='10'>Personnel Management & Industrial Relations (SF)</option>";
			}
			if ($crsid == 11) {
				$option .= "<option value='11' selected >Human Resource Management (SF)</option>";
			} else {
				$option .= "<option value='11'>Human Resource Management (SF)</option>";
			}
			echo $option;
		} else if ($main_course_id == 5) {
			$option = "<option value=''>Select an Option</option>";
			if ($crsid == 1) {
				$option .= "<option value='1' selected >B.S.W (SF)</option>";
			} else {
				$option .= "<option value='1'>B.S.W (SF)</option>";
			}
			if ($crsid == 2) {
				$option .= "<option value='2' selected >B.Sc Psychology (SF)</option>";
			} else {
				$option .= "<option value='2'>B.Sc Psychology (SF)</option>";
			}
			echo $option;
		} else {
			echo $option = "<option value=''>Select an Option</option>";
		}
	}

	public function get_students()
	{
		$main_course_id = $this->input->post('main_course_id');
		$applied_course_id = $this->input->post('app_course_id');

		$get_stu = $this->db->where('main_course_id', $main_course_id)->where('applied_course_id', $applied_course_id)->get('Applyed_Cources')->result();
		$option = "<option value=''>Select an Option</option>";
		foreach ($get_stu as $students) {
			$student   = $this->db->where('u_id', $students->user_id)->get('stu_user')->row();
			$option .= "<option value='" . $student->u_id . "'>" . $student->u_name . "</option>";
		}
		echo $option;
	}

	public function announcements()
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
			$data_ann['ann_main'] = $main_course_id = $this->input->post('main_course_id');
			$data_ann['ann_course'] = $app_course_id = $this->input->post('app_course_id');
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
			redirect('accounts/announcements', 'refresh');
		}

		$this->load->view('template/accounts/header');
		$this->load->view('template/accounts/menubar');
		$this->load->view('template/accounts/headerbar');
		$this->load->view('accounts/announcements',$data);
		$this->load->view('template/accounts/footer');
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
	public function get_announcement()
	{
		$main_course_id = $this->input->post('main_course_id');
		$app_course_id = $this->input->post('app_course_id');
		$get_announcement = $this->db->where('main_course_id', $main_course_id)->where('app_course_id', $app_course_id)->get('announcement')->result();
		echo json_encode($get_announcement);
	}

	public function feesMaster() {

					/* date_default_timezone_get();
$add_date=date('Y-m-d h:i:s');

$data['feesdetails']=$this->db->where('name !="Penalty" and name !="Due Date" and name !="GST Status" and name !="GST Value" and name !="GST Amount" and name !="Total" and name !="Installment Status" and name !="Installment1" and name !="Installment2" and name !="Installment3" and name !="Installment4" and name !="Installment5" and name !="Installment_perc1" and name !="Installment_perc2" and name !="Installment_perc3" and name !="Installment_perc4" and name !="Installment_perc5" and name !="Interest" and name !="Batch"')->get('fees_master')->result();

if(isset($_POST['submit'])){
	$data_ins['name']=$this->input->post('name');
	$data_ins['status']=1;
	$data_ins['created_at']=$add_date;
  
   $insert=$this->db->insert('fees_master',$data_ins);  
   $insert1=$this->db->insert('fees_master2',$data_ins);  
   $insert2=$this->db->insert('fees_master3',$data_ins);  
   redirect('accounts/feesMaster','refresh');
}
if(isset($_POST['submit_edit'])){
	$data_upd['name']=$this->input->post('edit_name');
	$edit_id=$this->input->post('edit_id');
  
  $this->db->where('id',$edit_id);
   $update=$this->db->update('fees_master',$data_upd);  
   redirect('accounts/feesMaster','refresh');
}
	$this->load->view('template/accounts/header');
    $this->load->view('template/accounts/menubar');
    $this->load->view('template/accounts/headerbar');
    $this->load->view('accounts/feesmaster',$data);
    $this->load->view('template/accounts/footer');
 */}
	public function feesManage()
	{
		$q = $this->db->select("*")
			->from("accounts_fee_master")
			->join(
				"department_details",
				"accounts_fee_master.main_id = department_details.main_id AND accounts_fee_master.cour_id = department_details.cour_id"
			)
//	->where("accounts_fee_master.f_status",1)
			->get();

		$data['fees'] = $q->result();

		$this->load->view('template/accounts/header');
		$this->load->view('template/accounts/menubar');
		$this->load->view('template/accounts/headerbar');
		$this->load->view('accounts/master_fees', $data);
		$this->load->view('template/accounts/footer');
	}
	public function feesMasterStatus()
	{
		$status = $this->input->post('status');
		$id = $this->input->post('id');
		if ($status == 0) {
			$data_stat['status'] = 1;
		} else {
			$data_stat['status'] = 0;
		}
		$this->db->where('id', $id);
		$this->db->update('fees_master', $data_stat);
		$get_status = $this->db->where('id', $id)->get('fees_master')->row();
		echo $get_status->status;
	}
	public function acadamicfees()
	{
		try {
			$data['get_fees_type'] = $this->db->where('status', 1)->get('fees_master')->result();
			$data['category'] = $this->db->where('ac_status', 1)->get('accounts_category')->result();
			$this->load->view('template/accounts/header');
			$this->load->view('template/accounts/menubar');
			$this->load->view('template/accounts/headerbar');
			$this->load->view('accounts/fees_manage', $data);
			$this->load->view('template/accounts/footer');
		} catch (Exception $e) {
        // this will not catch DB related errors. But it will include them, because this is more general. 
			log_message('error: ', $e->getMessage());
			return;
		}
	}

	public function EditMaster()
	{
		$id = $this->uri->segment(3);

		$q = $this->db->select("*")
			->from("accounts_fee_master")
			->join(
				"department_details",
				"accounts_fee_master.main_id = department_details.main_id AND accounts_fee_master.cour_id = department_details.cour_id"
			)
//	->where("accounts_fee_master.f_status")
			->where("accounts_fee_master.f_id", $id)
			->get();

		$data['fees'] = $q->result();
		$data['category'] = $this->db->where('ac_status', 1)->get('accounts_category')->result();
		$data['get_fees_type'] = $this->db->where('status', 1)->get('fees_master')->result();
		$this->load->view('template/accounts/header');
		$this->load->view('template/accounts/menubar');
		$this->load->view('template/accounts/headerbar');
		$this->load->view('accounts/edit_manage', $data);
		$this->load->view('template/accounts/footer');
	}
	public function addAcadamicFees()
	{
		$main_course_id = $this->input->post("main_course_id");
		$app_course_id = $this->input->post("app_course_id");
		$year = $this->input->post("year");
		$batch = $this->input->post("batch");
		$category = $this->input->post("category");

		$fees_name = $this->input->post("fees_name");
		$payment_type = $this->input->post("payment_type");
		$fees_amount = $this->input->post("fees_amount");
		$gst = $this->input->post("gst");
		$gst_per = $this->input->post("gst_per");
		$gst_amount = $this->input->post("gst_amount");
		$start_date = $this->input->post("start_date");
		$end_Date = $this->input->post("end_Date");
		$fine_s = $this->input->post("fine_s");
		$fine_amount = $this->input->post("fine_amount");
		$total = $this->input->post("total");

		$fees_discription = $this->input->post("fees_discription");
		$instalment_status = $this->input->post("instalment_status");
		$installment_fees = $this->input->post("installment_fees");

		$insert = array(
			'main_id' => $main_course_id,
			'cour_id' => $app_course_id,
			'year' => $year,
			'batch' => $batch,
			'f_category' => $category,
			'f_name' => $fees_name,
			'payment_type' => $payment_type,
			'f_amount' => $fees_amount,
			'f_discription' => $fees_discription,
			'f_gst' => $gst,
			'f_perc' => $gst_per,
			'f_gst_amt' => $gst_amount,
			'f_instalment' => $instalment_status,
			'f_instalment_fees' => $installment_fees,
			'f_s_date' => $start_date,
			'f_e_date' => $end_Date,
			'f_fine_status' => $fine_s,
			'f_fine_amount' => $fine_amount,
			'f_total' => $total,
		);

		$this->db->insert("accounts_fee_master", $insert);

		$this->session->set_flashdata(
			"message",
			' <div class="alert alert-success alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Success !</strong> Insert Fees Successfully .
	</div>'
		);

		redirect("Accounts/feesManage/", "refresh");
	}
	public function updateAcadamicFees()
	{
		$f_id = $this->input->post("fees_id");
		$main_course_id = $this->input->post("main_course_id");
		$app_course_id = $this->input->post("app_course_id");
		$year = $this->input->post("year");
		$batch = $this->input->post("batch");
		$category = $this->input->post("category");
		$fees_name = $this->input->post("fees_name");
		$payment_type = $this->input->post("payment_type");
		$fees_amount = $this->input->post("fees_amount");
		$gst = $this->input->post("gst");
		$gst_per = $this->input->post("gst_per");
		$gst_amount = $this->input->post("gst_amount");
		$start_date = $this->input->post("start_date");
		$end_Date = $this->input->post("end_Date");
		$fine_s = $this->input->post("fine_s");
		$fine_amount = $this->input->post("fine_amount");
		$total = $this->input->post("total");
		$active_s = $this->input->post("active_s");

		$fees_discription = $this->input->post("fees_discription");
		$instalment_status = $this->input->post("instalment_status");
		$installment_fees = $this->input->post("installment_fees");

		$insert = array(
			'main_id' => $main_course_id,
			'cour_id' => $app_course_id,
			'year' => $year,
			'batch' => $batch,
			'f_category' => $category,
			'f_name' => $fees_name,
			'f_discription' => $fees_discription,
			'payment_type' => $payment_type,
			'f_amount' => $fees_amount,
			'f_gst' => $gst,
			'f_perc' => $gst_per,
			'f_gst_amt' => $gst_amount,
			'f_instalment' => $instalment_status,
			'f_instalment_fees' => $installment_fees,
			'f_s_date' => $start_date,
			'f_e_date' => $end_Date,
			'f_fine_status' => $fine_s,
			'f_fine_amount' => $fine_amount,
			'f_total' => $total,
			'f_status' => $active_s,
		);

		$this->db->where("f_id", $f_id);
		$this->db->update("accounts_fee_master", $insert);

		$this->session->set_flashdata(
			"message",
			' <div class="alert alert-success alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Success !</strong> Insert Fees Successfully .
	</div>'
		);

		redirect("Accounts/feesManage/", "refresh");
	}
	public function SameFeesStructure()
	{
		$main_course_id = $this->input->post("main_c_id");
		$app_course_id = $this->input->post("app_c_id");
		$year = $this->input->post("aayear");
		$batch = $this->input->post("battach");
		$category = $this->input->post("cat");
		$html = "";

		$where = "accounts_fee_master.main_id='" . $main_course_id . "' AND accounts_fee_master.cour_id='" . $app_course_id . "' AND accounts_fee_master.year='" . $year . "' AND accounts_fee_master.batch='" . $batch . "'  AND accounts_fee_master.f_category='" . $category . "'";

		$q = $this->db->select("*")
			->from("accounts_fee_master")
			->join(
				"department_details",
				"accounts_fee_master.main_id = department_details.main_id AND accounts_fee_master.cour_id = department_details.cour_id"
			)
			->where("accounts_fee_master.f_status", 1)
			->where($where)
			->get();
		$quer = $q->num_rows();

		if ($quer > 0) {
			$html .= '<table class="table table-striped">
	<thead>
	  <tr>
		<th scope="col">#</th>
		<th scope="col">Name</th>
		<th scope="col">Payment Type</th>
		<th scope="col">Total amount</th>
		<th scope="col">Action</th>
	  </tr>
	</thead>
	<tbody>';
			$r = $q->result();

			$i = 1;
			foreach ($r as $key => $value) {
				if ($value->payment_type == 1) {
					$p_t = "Full Payment";
				} else {
					$p_t = "Installment Payment";
				}

				$html .= ' <tr>
	<th scope="' . $i . '">1</th>
	<td>' . $value->f_name . '</td>
	<td>' . $p_t . '</td>
	<td>' . $value->f_total . '</td>
	<td><a href="' . base_url() . 'Accounts/EditMaster/' . $value->f_id . '">View / Edit</a></td>
	
  </tr>';

				$i++;
			}

			$html .= ' </tbody>
</table>';

			echo $html;
		} else {
			$html .= 'No Fees Created in Same Category';

			echo $html;
		}
	}
	public function SamePaymentMethod()
	{
		$main_course_id = $this->input->post("main_c_id");
		$app_course_id = $this->input->post("app_c_id");
		$year = $this->input->post("aayear");
		$batch = $this->input->post("battach");
		$category = $this->input->post("cat");
		$html = "";

		$where = "accounts_fee_master.main_id='" . $main_course_id . "' AND accounts_fee_master.cour_id='" . $app_course_id . "' AND accounts_fee_master.year='" . $year . "' AND accounts_fee_master.batch='" . $batch . "'  AND accounts_fee_master.f_category='" . $category . "'";

		$q = $this->db->select("DISTINCT(payment_type)")
			->from("accounts_fee_master")
			->join(
				"department_details",
				"accounts_fee_master.main_id = department_details.main_id AND accounts_fee_master.cour_id = department_details.cour_id"
			)
			->where("accounts_fee_master.f_status", 1)
	//->distinct("accounts_fee_master.payment_type")
			->where($where)
			->get();
		$quer = $q->num_rows();

		if ($quer > 0) {
			$html .= '<option value="">Select Payment type</option>';
			$r = $q->result();

			foreach ($r as $key => $value) {
				if ($value->payment_type == 1) {
					$payment = "Full Payment";
				} else {
					$payment = "Installment Payment";
				}

				$html .= ' <option value="' . $value->payment_type . '">' . $payment . '</option>';
			}

			echo $html;
		} else {
			$html .= '<option value="">No Payment Created </option>';

			echo $html;
		}
	}

	public function SamePaymentName()
	{
		$main_course_id = $this->input->post("main_c_id");
		$app_course_id = $this->input->post("app_c_id");
		$year = $this->input->post("aayear");
		$batch = $this->input->post("battach");
		$category = $this->input->post("cat");
		$payment_type = $this->input->post("payment_type");
		$html = "";

		$where = "accounts_fee_master.payment_type='" . $payment_type . "' AND accounts_fee_master.main_id='" . $main_course_id . "' AND accounts_fee_master.cour_id='" . $app_course_id . "' AND accounts_fee_master.year='" . $year . "' AND accounts_fee_master.batch='" . $batch . "'  AND accounts_fee_master.f_category='" . $category . "'";

		$q = $this->db->select("f_name")
			->from("accounts_fee_master")
			->join(
				"department_details",
				"accounts_fee_master.main_id = department_details.main_id AND accounts_fee_master.cour_id = department_details.cour_id"
			)
			->where("accounts_fee_master.f_status", 1)
			->where($where)
			->get();
		$quer = $q->num_rows();

		if ($quer > 0) {
			$html .= '<option value="">Select Payment Name</option>';
			$r = $q->result();

			foreach ($r as $key => $value) {
				$html .= ' <option value="' . $value->f_name . '">' . $value->f_name . '</option>';
			}

			echo $html;
		} else {
			$html .= '<option value="">No Payment Created </option>';

			echo $html;
		}
	}
	public function selectCompleteDetails()
	{
		$main_course_id = $this->input->post("main_c_id");
		$app_course_id = $this->input->post("app_c_id");
		$year = $this->input->post("aayear");
		$batch = $this->input->post("battach");
		$category = $this->input->post("cat");
		$payment_type = $this->input->post("payment_type");
		$payment_name = $this->input->post("payment_name");
		$html = "";

		$where = "accounts_fee_master.f_name='" . $payment_name . "' AND accounts_fee_master.payment_type='" . $payment_type . "' AND accounts_fee_master.main_id='" . $main_course_id . "' AND accounts_fee_master.cour_id='" . $app_course_id . "' AND accounts_fee_master.year='" . $year . "' AND accounts_fee_master.batch='" . $batch . "'  AND accounts_fee_master.f_category='" . $category . "'";

		$q = $this->db->select("*")
			->from("accounts_fee_master")
			->join(
				"department_details",
				"accounts_fee_master.main_id = department_details.main_id AND accounts_fee_master.cour_id = department_details.cour_id"
			)
			->where("accounts_fee_master.f_status", 1)
			->where($where)
			->get();
		$quer = $q->num_rows();

		if ($quer == 1) {
			$r = $q->result();

			/* $m = $this->db->select("*")
	->from("accounts_fees_transaction")
	//->join("department_details","accounts_fee_master.main_id = department_details.main_id AND accounts_fee_master.cour_id = department_details.cour_id")
	->where("accounts_fee_master.af_fees_id",$r[0]->f_discription)
	//->where($where)
	->get();
	$rest	 = $m->result(); */


															/*	print_r($r); */

															$html .= '<div class="col-md-4">
<label>Discription</label><br>
' . $r[0]->f_discription . '
	</div>
	
	<div class="col-md-2">
	<label>Amount</label><br>
	' . $r[0]->f_amount . '
		</div>
		
	<div class="col-md-2">
		<label>GST Amount</label><br>
		' . $r[0]->f_gst_amt . '
			</div>
			
			<div class="col-md-2">
			<label>Grand  Total</label><br>
			<input type="text" class="form-control" name="off_amount" value="'.$r[0]->f_total.'">
			
				</div>
				
				<div class="col-md-2">
				<label>last Date </label><br>
				' . $r[0]->f_e_date . '
					</div>
			<input type="hidden" id="payment_id" name="payment_id" value="' . $r[0]->f_id . '"> ';
		} else {
			$html .= '<div class="col-md-12">
<label>Error</label><br>
Please Check the account master 
	</div>';
		}
		echo $html;
	}

	public function SelectPaidCategory()
	{
		$last_names = [];
		$m = [];
		$t = [];
		$main_course_id = $this->input->post("main_c_id");
		$app_course_id = $this->input->post("app_c_id");
		$year = $this->input->post("aayear");
		$batch = $this->input->post("battach");

		$html = "";

		$where = "accounts_fee_master.main_id='" . $main_course_id . "' AND accounts_fee_master.cour_id='" . $app_course_id . "' AND accounts_fee_master.year='" . $year . "' AND accounts_fee_master.batch='" . $batch . "'";

		$q = $this->db->select("f_category")
			->from("accounts_fee_master")
			->join(
				"department_details",
				"accounts_fee_master.main_id = department_details.main_id AND accounts_fee_master.cour_id = department_details.cour_id"
			)
			->where("accounts_fee_master.f_status", 1)
			->where($where)
			->get();
		$quer = $q->num_rows();

		if ($quer > 0) {
			$r = $q->result_array();
			$last_names = array_column($r, 'f_category');
			$m = array_unique($last_names);

//print_r($m);

			$q = $this->db->select("*")
				->from("accounts_category")
				->where_in("accounts_category.ac_id", $m)
				->get();
			$t = $q->result_array();

			$html = "<option value=''>Select Category</option>";
			foreach ($t as $key => $value) {
				$html .= "<option value='" . $value['ac_id'] . "'>" . $value['ac_name'] . "</option>";
			}
		} else {
			$html = "<option value=''>No Category found</option>";
		}
		echo $html;
	}

	public function transactionHistory()
	{
		$q = $this->db->select("*,admitted_student.*")->from("accounts_fees_transaction")
			->join(
				"department_details",
				"accounts_fees_transaction.af_main_id = department_details.main_id AND accounts_fees_transaction.af_course_id = department_details.cour_id"
			)
			->join(
				"Applyed_Cources",
				"accounts_fees_transaction.af_main_id = Applyed_Cources.main_course_id AND accounts_fees_transaction.af_course_id = Applyed_Cources.applied_course_id AND accounts_fees_transaction.af_student_id = Applyed_Cources.user_id",
				"left"
			)
			->join("accounts_fee_master", "accounts_fees_transaction.af_fees_id = accounts_fee_master.f_id")
			->join("accounts_category", "accounts_fees_transaction.af_category_id = accounts_category.ac_id")
			->join("stu_user", "accounts_fees_transaction.af_student_id = stu_user.u_id ", 'left')
			->join("admitted_student", "accounts_fees_transaction.af_student_id = admitted_student.as_student_id ", 'left')
			->where("accounts_fees_transaction.af_paid_status", 1)
			->order_by("accounts_fees_transaction.af_id", "DESC")
			->get();

		$data['data'] = $q->result();

		$this->load->view('template/accounts/header');
		$this->load->view('template/accounts/menubar');
		$this->load->view('template/accounts/headerbar');
		$this->load->view('accounts/transactionhistory', $data);
		$this->load->view('template/accounts/footer');
	}

	public function testMessiApp()
	{
		/* $m = $this->Messi->totalTrans();
*/
										$m =   $this->db->select("af_messi_reference")->from("accounts_fees_transaction")->where("af_generated_by", 2)->get()->result_array();
		$arr = array_column($m, "af_messi_reference");

		$array = array_values($m);
		echo "<pre>";
		print_r($m);
		print_r($arr);
	}

	public function transactionid()
	{
		$id = $this->input->post('id');
		$m = $this->Messi->messiTransiD($id);

		echo $m;
//	print_r($m);

	}

	public function missiAppTransaction()
	{
		$data['transaction'] = $this->Messi->totalTrans();

		$this->load->view('template/accounts/header');
		$this->load->view('template/accounts/menubar');
		$this->load->view('template/accounts/headerbar');
		$this->load->view('accounts/messileniousappTrans', $data);
		$this->load->view('template/accounts/footer');
	}

	public function SelectCategory()
	{
		$year = $this->input->post("aayear");
		$main_c_id = $this->input->post("main_c_id");
		$apply_c_id = $this->input->post("app_c_id");
		$batch = $this->input->post("battach");

		$q = $this->db->select("f_category")->from("accounts_fee_master")->where("year", $year)->where("main_id", $main_c_id)
			->where("batch", $batch)->where("cour_id", $apply_c_id)->where("f_status", 1)->group_by('f_category')->get();

		$m = $q->num_rows();
		if ($m > 0) {
			$r = $q->result_array();
  
  //print_r($r);
			$arr = array_column($r, "f_category");
			$cat = $this->db->select("*")->from("accounts_category")->where_in("ac_id", $arr)->get();

			$cats = $cat->num_rows();

			if ($cats > 0) {
				$cat_edt = $cat->result_array();

				$html = "<option value=''>Select Category</option>";
				foreach ($cat_edt as $key => $value) {
					$html .= "<option value='" . $value['ac_id'] . "'>" . $value['ac_name'] . "</option>";
				}
  //echo $html;

			} else {
				$html = "<option value=''>No Category Created </option>";
			}
		} else {
			$html = "<option value=''>No Category Created </option>";
		}
		echo $html;
	}
	public function SelectPayment()
	{
		$year = $this->input->post("aayear");
		$main_c_id = $this->input->post("main_c_id");
		$apply_c_id = $this->input->post("app_c_id");
		$batch = $this->input->post("battach");
		$category = $this->input->post("category");

		$q =  $this->db->select("payment_type")->from("accounts_fee_master")->where("year", $year)->where("batch", $batch)->where("f_category", $category)
			->where("main_id", $main_c_id)->where("cour_id", $apply_c_id)->where("f_status", 1)->group_by('payment_type')->get();

		$m = $q->num_rows();
		if ($m > 0) {
			$r = $q->result_array();

			$html = "<option value=''>Select Fees</option>";

			foreach ($r as $key => $value) {
				if ($value['payment_type'] == 1) {
					$var = "Full Payment";
				} else {
					$var = "Installment Payment";
				}
				$html .= "<option value='" . $value['payment_type'] . "'>" . $var . "</option>";
			}

			echo $html;
		} else {
			$html = "<option value=''>No Payment Type created </option>";
		}
	}
	public function SelectPaymentfees()
	{
		$year = $this->input->post("aayear");
		$main_c_id = $this->input->post("main_c_id");
		$apply_c_id = $this->input->post("app_c_id");
		$batch = $this->input->post("battach");
		$category = $this->input->post("category");
		$payment = $this->input->post("payment");

		$q = $this->db->select("*")->from("accounts_fee_master")->where("year", $year)->where("batch", $batch)->where("f_category", $category)
			->where("main_id", $main_c_id)->where("cour_id", $apply_c_id)->where("payment_type", $payment)->where("f_status", 1)->get();

		$m = $q->num_rows();
		if ($m > 0) {
			$r = $q->result_array();

			$html = "<option value=''>Select Fees</option>";

			foreach ($r as $key => $value) {
				$html .= "<option value='" . $value['f_id'] . "'>" . $value['f_name'] . "</option>";
			}

			echo $html;
		} else {
			$html = "<option value=''>No Fees Created </option>";
		}
	}
	public function messiAdd()
	{
		$m = $this->Messi->messiTransIiD($_POST['missi_id']);
		$c = $this->Messi->accountFees($_POST['feename']);

		$arrays = array(
			"af_main_id" => $c[0]->main_id,
			"af_course_id" => $c[0]->cour_id,
			"af_category_id" => $c[0]->f_category,
			"af_installment_id" => $c[0]->payment_type,
			//"af_student_id"=>$_POST["regnumber"],
			"af_reg_number" => $_POST["regnumber"],
			"af_fees_id" => $c[0]->f_id,
			"af_fees_name" => $c[0]->f_name,
			"af_request" => $m[0]->tran_id,
			"af_fees_total_amt" => $m[0]->samounts,
			"af_paid_status" => 1,
			"af_response" => json_encode($m[0]->response),
			"af_response_time" => $m[0]->paid_date_time,
			"af_generated_by" => 2,
			"af_messi_reference" => $_POST['missi_id'],
		);
		$this->db->insert('accounts_fees_transaction', $arrays);
		$this->session->set_flashdata(
			"message",
			' <div class="alert alert-success alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Success !</strong> Insert Miscellaneous Transaction .
			</div>'
		);

		redirect("Accounts/missiAppTransaction/", "refresh");
	}

	public function studentAnnouncements()
	{
		$data['announcement'] = $this->db->select("*")->from("stu_announcements")->where("sa_soft", 1)->where("sa_user_created_by", $this->session->userdata("user")["user_id"])->get()->result();

		$this->load->view('template/accounts/header');
		$this->load->view('template/accounts/menubar');
		$this->load->view('template/accounts/headerbar');
		$this->load->view('accounts/announcements_student', $data);
		$this->load->view('template/accounts/footer');
	}

	public function postAnnouncements()
	{
		$data_ann['sa_main_course'] = $main_course_id = $this->input->post('main_course_id');
		$data_ann['sa_app_course'] = $app_course_id = $this->input->post('app_course_id');
		$data_ann['sa_title'] = $this->input->post('title');
		$data_ann['sa_content'] = $this->input->post('remark');
		$data_ann['sa_date_till'] = $this->input->post('date');
		$data_ann['sa_soft'] = 1;
		$data_ann['sa_user_created_by'] = $this->session->userdata("user")["user_id"];

		$this->db->insert("stu_announcements", $data_ann);

		$this->session->set_flashdata(
			"message",
			' <div class="alert alert-success alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Success !</strong> Student Announcements successfully inserted .
		</div>'
		);

		redirect("Accounts/studentAnnouncements/", "refresh");
	}
	public function onOffPayment()
	{
		$pid = $this->input->post('p_id');

		$m = $this->db->select("*")->from("accounts_fee_master")->where("f_id", $pid)->get()->result_array();

		if (is_array($m)) {
			$n = $m[0]['f_status'];

//print_r($m);
			if ($n == 1) {
				$data = array(
					"f_status" => 0,
				);
			} else {
				$data = array(
					"f_status" => 1,
				);
			}

			$this->db->where("f_id", $pid);
			$this->db->update("accounts_fee_master", $data);

			$this->session->set_flashdata(
				"message",
				' <div class="alert alert-success alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Success !</strong> Updated Successfully.
	</div>'
			);
		} else {
			$this->session->set_flashdata(
				"message",
				' <div class="alert alert-success alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Failed !</strong>Failed to Update Status
		</div>'
			);
		}
	}

	public function offlinePayment()
	{
	//$data['announcement'] = $this->db->select("*")->from("stu_announcements")->where("sa_soft",1)->where("sa_user_created_by",$this->session->userdata("user")["user_id"])->get()->result();

		try {
			$data['get_fees_type'] = $this->db->where('status', 1)->get('fees_master')->result();
			$data['category'] = $this->db->where('ac_status', 1)->get('accounts_category')->result();
			$this->load->view('template/accounts/header');
			$this->load->view('template/accounts/menubar');
			$this->load->view('template/accounts/headerbar');
			$this->load->view('accounts/offline_payment_admission', $data);
			$this->load->view('template/accounts/footer');
		} catch (Exception $e) {
        // this will not catch DB related errors. But it will include them, because this is more general. 
			log_message('error: ', $e->getMessage());
			return;
		}
	}

	public function admittedOfflinePayment()
	{
		try {
			$data['get_fees_type'] = $this->db->where('status', 1)->get('fees_master')->result();
			$data['category'] = $this->db->where('ac_status', 1)->get('accounts_category')->result();
			$this->load->view('template/accounts/header');
			$this->load->view('template/accounts/menubar');
			$this->load->view('template/accounts/headerbar');
			$this->load->view('accounts/offline_payment_admitted_erp', $data);
			$this->load->view('template/accounts/footer');



		} catch (Exception $e) {
			log_message('error: ', $e->getMessage());
			return;
		}
	}

	public function paidReports()
	{
		$this->load->view('template/accounts/header');
		$this->load->view('template/accounts/menubar');
		$this->load->view('template/accounts/headerbar');
		$this->load->view('accounts/paid_status');
		$this->load->view('template/accounts/footer');
	}

	public function unPaidReports()
	{
		$this->load->view('template/accounts/header');
		$this->load->view('template/accounts/menubar');
		$this->load->view('template/accounts/headerbar');
		$this->load->view('accounts/un_paid_status');
		$this->load->view('template/accounts/footer');
	}
	public function selectPaidUser()
	{
		$main_c_id = $this->input->post("main_course_id");
		$apply_c_id = $this->input->post("app_course_id");
		$year = $this->input->post("year");

		$batch = $this->input->post("batch");
		$category = $this->input->post("category");

		$q =  $this->db->select("*")->from("accounts_fee_master")->where("main_id", $main_c_id)->where("cour_id", $apply_c_id)->where("year", $year)->where("batch", $batch)->where("f_category", $category)
			->get()->result_array();

		$att = array_column($q, "f_id");
  


		$data['main_id'] = $main_c_id;
		$data['course_id'] = $apply_c_id;
		$data['year'] = $year;
		$data['batch'] = $batch;
		$data['category'] = $category;
	//$m = $q->num_rows();

	//print_r($att);




//foreach ($q as $key => $value) {

		$t = $this->db->select("*")->from("accounts_fees_transaction")->join(
			"department_details",
			"accounts_fees_transaction.af_main_id = department_details.main_id AND accounts_fees_transaction.af_course_id = department_details.cour_id"
		)
			->join(
				"Applyed_Cources",
				"accounts_fees_transaction.af_main_id = Applyed_Cources.main_course_id AND accounts_fees_transaction.af_course_id = Applyed_Cources.applied_course_id AND accounts_fees_transaction.af_student_id = Applyed_Cources.user_id",
				"left"
			)
			->join("accounts_fee_master", "accounts_fees_transaction.af_fees_id = accounts_fee_master.f_id")
			->join("accounts_category", "accounts_fees_transaction.af_category_id = accounts_category.ac_id")
			->join("stu_user", "accounts_fees_transaction.af_student_id = stu_user.u_id ", 'left')
			->where("accounts_fees_transaction.af_paid_status", 1)
			->where_in("accounts_fees_transaction.af_fees_id", $att)
			->order_by("accounts_fees_transaction.af_id", "DESC")
			->order_by("accounts_fees_transaction.af_installment_id", "ASC")
			->get();

		$data['data'] = $t->result();

		$this->load->view('template/accounts/header');
		$this->load->view('template/accounts/menubar');
		$this->load->view('template/accounts/headerbar');
		$this->load->view('accounts/paid_users', $data);
		$this->load->view('template/accounts/footer');
	}

	public function selectPaidUsers()
	{
		$main_c_id = $this->input->post("main_c_id");
		$apply_c_id = $this->input->post("app_c_id");
		$year = $this->input->post("aayear");

		$batch = $this->input->post("battach");
		$category = $this->input->post("cat");

		$q =  $this->db->select("*")->from("accounts_fee_master")->where("main_id", $main_c_id)->where("cour_id", $apply_c_id)->where("year", $year)->where("batch", $batch)->where("f_category", $category)
			->get()->num_rows();

		echo $q;
	}

	public function searchStudentShotlisted()
	{
		$student_name = $this->input->post("student_name");
		$payment_id = $this->input->post("payment_id");

		$d =  $this->db->select("*")->from("accounts_fee_master")->where("f_id", $payment_id)->get();

		$m = $d->result_array();

		if (sizeof($m) > 0) {
			$main = $m[0]['main_id'];
			$cour = $m[0]['cour_id'];
			$year = $m[0]['year'];
			$bat = $m[0]['batch'];
			$cat = $m[0]['f_category'];
		}

		$s = $this->db->select("*")
			->from("Applyed_Cources")
			->join(
				"shotlisted_candidate",
				"Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id AND Applyed_Cources.user_id=shotlisted_candidate.sl_student_id "
			)
			->where("Applyed_Cources.main_course_id", $main)
			->where("Applyed_Cources.applied_course_id", $cour)
			->where("shotlisted_candidate.reservation_status", 1)
			->where("Applyed_Cources.application_number", $student_name)
			->get();

		$s_no = $s->num_rows();
		if ($s_no > 0) {
			$s_det = $s->result();
			/* print_r($s_det);
	exit; */

																$q = $this->db->select("*")->from("accounts_fee_master")->where("main_id", $main)->where("cour_id", $cour)->where("year", $year)->where("batch", $bat)->where("f_category", $cat)
				->get()->result_array();

			$att = array_column($q, "f_id");

			$t = $this->db->select("*")->from("accounts_fees_transaction")
	// ->join("department_details","accounts_fees_transaction.af_main_id = department_details.main_id AND accounts_fees_transaction.af_course_id = department_details.cour_id",'right')
	//->join("Applyed_Cources","accounts_fees_transaction.af_main_id = Applyed_Cources.main_course_id AND accounts_fees_transaction.af_course_id = Applyed_Cources.applied_course_id AND accounts_fees_transaction.af_student_id = ". $s_det[0]->user_id,'right')
				->join("accounts_fee_master", "accounts_fees_transaction.af_fees_id = accounts_fee_master.f_id", 'right')
				->join("accounts_category", "accounts_fees_transaction.af_category_id = accounts_category.ac_id", 'right')
				->join("stu_user", "accounts_fees_transaction.af_student_id = stu_user.u_id ", 'right')
				->where("accounts_fees_transaction.af_paid_status", 1)
				->where_in("accounts_fees_transaction.af_fees_id", $att)
				->where("accounts_fees_transaction.af_student_id", $s_det[0]->user_id)
				->order_by("accounts_fees_transaction.af_id", "DESC")
	//->order_by("accounts_fees_transaction.af_installment_id","ASC")
				->get();

			$dat = $t->num_rows();
			$html = "<br><br><label >Fee Payment Status</label><input type='hidden' name='user_id' value='" . $s_det[0]->user_id . "'>";

			if ($dat > 0) {
				$val = $t->result();

				/* print_r($val);

exit; */

				foreach ($val as $key => $value) {
					if ($value->af_generated_by == 0 || $value->af_generated_by == 1) {
						$ind = "On-Line";
					} else if ($value->af_generated_by == 2) {
						$ind = "Missi";
					} else if ($value->af_generated_by == 3) {
						$ind = "Off-Line";
					}
					$html .= '<br><br><div class="row"> 
	
	<div class="col-md-2"><label>Category</label><br>' . $value->ac_name . '</div>
	<div class="col-md-4"><label>Fees Name</label><br>' . $value->af_fees_name . '</div>
	
	<div class="col-md-2"><label>Date</label><br>' . $value->af_created . '</div>
	<div class="col-md-2"><label>Amount</label><br>' . $value->af_fees_total_amt . '</div>
	<div class="col-md-2"><label>Paid Through</label><br>' . $ind . '</div>
	
	</div>';
				}
			} else {
				$html .= '<br><br><div class="row"> 
		
		<div class="col-md-12"><h1 style="color:red;">Fees Not Paid</h1><br></div>
		</div>';
			}

			echo $html;
		} else {
			echo "<h1 style='color:red;'>He is not in selection List</h1>";
		}
	}

	public function payOfflinePayment()
	{


/* echo"<pre>";

		print_r($_POST);
exit; */

		$main_course_id = $this->input->post("ssmain");
		$app_course_id = $this->input->post("sscour");
		$year = $this->input->post("ssyear");
		$batch = $this->input->post("ssbatch");
		$category = $this->input->post("category");
		$payment = $this->input->post("payment");
		$payment_name = $this->input->post("payment_name");
		$payment_id = $this->input->post("payment_id");
		$student_name = $this->input->post("student_name");
		$chalon_num = $this->input->post("chalon_num");
		$chalon_remark = $this->input->post("chalon_remark");
		$off_amount = $this->input->post("off_amount");




		$s = $this->db->select("*")
		->from("admitted_student")
		->join("shotlisted_candidate", "admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id ")
		->join(
			"Applyed_Cources",
			"Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id AND Applyed_Cources.user_id=shotlisted_candidate.sl_student_id "
		)
		//->join("shotlisted_candidate", "admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id ")
		->where("shotlisted_candidate.sl_main_id", $main_course_id)
	->where("shotlisted_candidate.sl_course_id", $app_course_id)
		->where("shotlisted_candidate.reservation_status", 1)
//->where("shotlisted_candidate.reservation_status",1)
		->where("admitted_student.as_reg_num", $student_name)
		->get();








	/* 	$stu = $this->db->select("*")->from("Applyed_Cources")
			->join(
				"shotlisted_candidate",
				"Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id AND Applyed_Cources.user_id=shotlisted_candidate.sl_student_id "
			)
			->where("Applyed_Cources.main_course_id", $main_course_id)
			->where("Applyed_Cources.applied_course_id", $app_course_id)
			->where("shotlisted_candidate.reservation_status", 1)
			->where("shotlisted_candidate.application_number", $student_name)->get(); */

		$stu_dete = $s->num_rows();

		if ($stu_dete > 0) {
			$stu_det = $s->result();

			$user_id = $stu_det[0]->as_student_id;

			$t = $this->db->select("*")->from("accounts_fees_transaction")
				->join("accounts_fee_master", "accounts_fees_transaction.af_fees_id = accounts_fee_master.f_id", 'right')
				->join("accounts_category", "accounts_fees_transaction.af_category_id = accounts_category.ac_id", 'right')
				->join("stu_user", "accounts_fees_transaction.af_student_id = stu_user.u_id ", 'right')
				->where("accounts_fees_transaction.af_paid_status", 1)
				->where("accounts_fees_transaction.af_fees_id", $payment_id)
				->where("accounts_fees_transaction.af_student_id", $user_id)
				->order_by("accounts_fees_transaction.af_id", "DESC")
//->order_by("accounts_fees_transaction.af_installment_id","ASC")
				->get();
			$payment = $t->num_rows();

			if ($payment > 0) {
				echo 0;
			} else {

				$admit = $this->db->select("*")->from("admitted_student")->where("as_student_id",$user_id)->get();

				$i = $admit->num_rows();

				if($i > 0){


					$res = $admit->result();

				//	$student_name = $res[0]->as_name;

					$student_number =$res[0]->as_reg_num;

				}else{
					$student_number =$user_id;

				}

				$q = $this->db->select("*")->from("accounts_fee_master")->where("f_id", $payment_id)->get()->result();

				$payment_type = $q[0]->payment_type;
				$f_name = $q[0]->f_name;
				$f_total = $q[0]->f_total;

				$arrays = array(
					"af_main_id" => $main_course_id,
					"af_course_id" => $app_course_id,
					"af_category_id" => $category,
					"af_installment_id" => $payment_type,
					"af_student_id" => $user_id,
					"af_reg_number" => $student_number,
					"af_fees_id" => $payment_id,
					"af_fees_name" => $f_name,
        //"af_request"=>$reqjj,
					"af_fees_total_amt" => $off_amount,
					"af_paid_status" => 1,
       // "af_response"=>$respj,
					"af_response_time" => $this->input->post('date_paid'),
					"af_generated_by" => 3,
					"off_line_challon_number" => $chalon_num,
					"off_line_remarks" => $chalon_remark,
				);

				$this->db->insert('accounts_fees_transaction', $arrays);
				 $insert_id = $this->db->insert_id();

				

				redirect("Accounts/ResponsePaymentStatusss/".$insert_id, "refresh");
			}
		} else {
			$this->session->set_flashdata(
				"message",
				' <div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Failed !</strong>  Transaction Failed Student Not Found .
			</div>'
			);
			
			redirect("Accounts/admittedOfflinePayment/", "refresh");
		}
	}
public function deleteTransaction(){

$id = $this->uri->segment(3);


$this->db->where('af_id',$id);
$this->db->delete('accounts_fees_transaction');


$this->session->set_flashdata(
	"message",
	' <div class="alert alert-danger alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong>  successfully Deleted .
</div>'
);

redirect("Accounts/transactionHistory/", "refresh");


}

public function ResponsePaymentStatusss(){

  $id = $this->uri->segment(3);

$q = $this->db->select("*")->from("accounts_fees_transaction")
->join("department_details","accounts_fees_transaction.af_main_id = department_details.main_id AND accounts_fees_transaction.af_course_id = department_details.cour_id")
->join("accounts_fee_master","accounts_fees_transaction.af_fees_id = accounts_fee_master.f_id")
->join("accounts_category","accounts_fees_transaction.af_category_id = accounts_category.ac_id")
//->join("Applyed_Cources","accounts_fees_transaction.af_main_id = Applyed_Cources.main_course_id AND accounts_fees_transaction.af_course_id = Applyed_Cources.applied_course_id")

->where("accounts_fees_transaction.af_id",$id)->get();

$r =$q->result();



/* echo"<pre>";

print_r($r);

exit;
 */


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

 $r[0]->af_student_id;
$reg = $this->db->select("*")->from("admitted_student")->where("as_student_id",$r[0]->af_student_id)->get();

echo $r_mum = $reg->num_rows();


if($r_mum > 0){
$r_mumr = $reg->result();

$r_number = $r_mumr[0]->as_reg_num;
$r_year = $r_mumr[0]->year;
$r_appnum = $r_mumr[0]->as_app_number;


}



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
             
              <h3 style="text-align: center;" >Offline Fees Payment Receipt</h3>
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
              <td>'.$r_year.'</td>
              
              </tr>  <tr>
              <td>Year</td>
              <td>'.$year.'</td>
              
              </tr>  <tr>
              <td>Register No / Ref No</td>
              <td>'.$r_number.'</td>
              
              </tr><tr>
              <td>Application No</td>
              <td>'.$r_appnum.'</td>
              
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
  
    file_put_contents("invoice/".$Referance.".pdf",$file);
	//	file_put_contents("admin/invoice/".$Referance.".pdf",$file);
 // $path_file= "invoice/".$Referance.".pdf";
 $this->session->set_flashdata(
	"message",
	' <div class="alert alert-success alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong>Fee Generated Successfully .
</div>'
);

redirect("Accounts/transactionHistory/", "refresh");

	}
}



	public function searchStudentShotlistedAdmitted()
	{
		$student_name = $this->input->post("student_name");
		$payment_id = $this->input->post("payment_id");

		$d =  $this->db->select("*")->from("accounts_fee_master")->where("f_id", $payment_id)->get();

		$m = $d->result_array();

		if (sizeof($m) > 0) {
			$main = $m[0]['main_id'];
			$cour = $m[0]['cour_id'];
			$year = $m[0]['year'];
			$bat = $m[0]['batch'];
			$cat = $m[0]['f_category'];
		}

		$s = $this->db->select("*")
			->from("admitted_student")
			->join("shotlisted_candidate", "admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id ")
			->join(
				"Applyed_Cources",
				"Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id AND Applyed_Cources.user_id=shotlisted_candidate.sl_student_id "
			)
			//->join("shotlisted_candidate", "admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id ")
			//->where("shotlisted_candidate.sl_main_id", $main)
			//->where("shotlisted_candidate.sl_course_id", $cour)
			->where("shotlisted_candidate.reservation_status", 1)
	//->where("shotlisted_candidate.reservation_status",1)
			->where("admitted_student.as_reg_num", $student_name)
			->get();

		$s_no = $s->num_rows();
		if ($s_no > 0) {
			$s_det = $s->result();
			/* print_r($s_det);
	exit; */

																$q = $this->db->select("*")->from("accounts_fee_master")->where("main_id", $main)->where("cour_id", $cour)->where("year", $year)->where("batch", $bat)->where("f_category", $cat)
				->get()->result_array();

			$att = array_column($q, "f_id");



			/*  print_r($att);
			 echo $student_name;
			exit;  */

			$t = $this->db->select("*")->from("accounts_fees_transaction")
	// ->join("department_details","accounts_fees_transaction.af_main_id = department_details.main_id AND accounts_fees_transaction.af_course_id = department_details.cour_id",'right')
	//->join("Applyed_Cources","accounts_fees_transaction.af_main_id = Applyed_Cources.main_course_id AND accounts_fees_transaction.af_course_id = Applyed_Cources.applied_course_id AND accounts_fees_transaction.af_student_id = ". $s_det[0]->user_id,'right')
				->join("accounts_fee_master", "accounts_fees_transaction.af_fees_id = accounts_fee_master.f_id", 'right')
				->join("accounts_category", "accounts_fees_transaction.af_category_id = accounts_category.ac_id", 'right')
				//->join("stu_user", "accounts_fees_transaction.af_student_id = stu_user.u_id ", 'right')
				->where("accounts_fees_transaction.af_paid_status", 1)
				//->where("accounts_fees_transaction.af_category_id", $cat)
				->where_in("accounts_fees_transaction.af_fees_id", $att)
				->where("accounts_fees_transaction.af_reg_number", $student_name)
				->order_by("accounts_fees_transaction.af_id", "DESC")
	//->order_by("accounts_fees_transaction.af_installment_id","ASC")
				->get();

			$dat = $t->num_rows();
			$html = "<br><br><label >Fee Payment Status</label><input type='hidden' name='user_id' value='" . $s_det[0]->user_id . "'>";

			if ($dat > 0) {
				$val = $t->result();

				/* print_r($val);

exit; */

				foreach ($val as $key => $value) {
					if ($value->af_generated_by == 0 || $value->af_generated_by == 1) {
						$ind = "On-Line";
					} else if ($value->af_generated_by == 2) {
						$ind = "Missi";
					} else if ($value->af_generated_by == 3) {
						$ind = "Off-Line";
					}
					$html .= '<br><br><div class="row text-success"> 
	
	<div class="col-md-2"><label>Category</label><br>' . $value->ac_name . '</div>
	<div class="col-md-4"><label>Fees Name</label><br>' . $value->af_fees_name . '</div>
	
	<div class="col-md-2"><label>Date</label><br>' . $value->af_created . '</div>
	<div class="col-md-2"><label>Amount</label><br>' . $value->af_fees_total_amt . '</div>
	<div class="col-md-2"><label>Paid Through</label><br>' . $ind . '</div>
	
	</div>';
				}
			} else {
				$html .= '<br><br><div class="row"> 
		
		<div class="col-md-12"><h1 style="color:red;">Fees Not Paid</h1><br></div>
		</div>';
			}

			echo $html;
		} else {
			echo "<h1 style='color:red;'>He is not in selection List</h1>";
		}
	}
	public function searchStudentShotlistedNumberAdmitted()
	{
		$student_name = $this->input->post("student_name");
		

		$s = $this->db->select("*")
			->from("admitted_student")
			->join("shotlisted_candidate", "admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id ")
			->join(
				"Applyed_Cources",
				"Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id AND Applyed_Cources.user_id=shotlisted_candidate.sl_student_id "
			)
			->join(
				"department_details",
				"Applyed_Cources.main_course_id = department_details.main_id AND Applyed_Cources.applied_course_id = department_details.cour_id","left"
			)
			->where("shotlisted_candidate.reservation_status", 1)
	
			->where("admitted_student.as_reg_num", $student_name)
			->get();


			$rest = $s->result_array();
if( sizeof($rest) > 0){

		echo	json_encode($rest);

}else{

	echo "No data Found";
}

	}

/* 	public function blockHallTicket(){



		$data['student'] = $this->db->select("*")
		->from("erp_block_halltickets")
	
		->where("erp_block_halltickets.type","ACCOUNTS")
		->where("erp_block_halltickets.status", 1)

		
		->get()->result();


		$this->load->view('template/accounts/header');
		$this->load->view('template/accounts/menubar');
		$this->load->view('template/accounts/headerbar');
		$this->load->view('accounts/blockhallticket',$data);
		$this->load->view('template/accounts/footer');

	} */

	public function getStudentlist(){
$main = $this->input->post('main');
$app = $this->input->post('app');
$batch = $this->input->post('batch');
$year = $this->input->post('year');
$sem = $this->input->post('sem');

$query = $this->db->select("*")->from("shotlisted_candidate")
->join("admitted_student","shotlisted_candidate.sl_id=admitted_student.as_shotlist_ref_number")
->where("shotlisted_candidate.sl_main_id",$main)
->where("shotlisted_candidate.sl_course_id",$app)
->where("shotlisted_candidate.reservation_status",1)
->where("shotlisted_candidate.selection_list",1)
->where("admitted_student.year",$batch)
->get();

$res = $query->result();


$html = "<table class='table'>
<tr>
<th>#</th>
<th>Name</th>
<th>Register Number</th>
<th>Application Number</th>
<th>Image</th>
</tr>";


foreach ($res as $key => $value) {
	
$html .="<tr>
<td><input type='checkbox' class ='stuid'  name='student[]' value='".$value->as_student_id."'></td>
<td>".$value->as_name."</td>
<td>".$value->as_reg_num."</td>
<td>".$value->as_app_number."</td>
<td><img src='".base_url()."/uploads/".$value->as_profile."' width='100px'></td>


</tr>";

}
$html .="</table>
<br>
<br>
<button type='submit' class='btn btn-primary'>Submit</button>
";
echo $html;
	}

public function addBlockHallTicket(){


print_r($_POST);


$maincou = $this->input->post('main_course_id');
$app_course_id = $this->input->post('app_course_id');
//$year = $this->input->post('year');
$batch = $this->input->post('batch');
$semester = $this->input->post('semester');
$student = $this->input->post('student');




$res = $this->db->select("*")->from("erp_existing_students")->where_in("student_id",$student)->get()->result_array();

print_r($res);

$i=0;
foreach ($res as $key => $value) {



	$data=array(
		'student_id'=>$value['id'],
		'batch_year'=>$batch,
		'main_id'=>$maincou,
		'course_id'=>$app_course_id,
		'sem'=>$semester,
		'type'=>"ACCOUNTS",
		'status'=>1,
		'user_id'=>$value['id'],
	);

$this->db->insert('erp_block_halltickets',$data);
$i++;
	
}
if($i > 0){

	$this->session->set_flashdata(
		"message",
		' <div class="alert alert-success alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Success !</strong>Successfully Blocked .
	</div>'
	);
	
	redirect("Accounts/consolidatedReports/", "refresh");

}else{

	
	$this->session->set_flashdata(
		"message",
		' <div class="alert alert-danger alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Failed !</strong>Failed to Blocked .
	</div>'
	);
	
	redirect("Accounts/consolidatedReports/", "refresh");

}


}

	public function studentSearchReports(){

		$this->load->view('template/accounts/header');
		$this->load->view('template/accounts/menubar');
		$this->load->view('template/accounts/headerbar');
		$this->load->view('accounts/student_search');
		$this->load->view('template/accounts/footer');

	}

	public function consolidatedReports(){

		$data['category'] = $this->db->select("*")->from("accounts_category")->get()->result();

		$this->load->view('template/accounts/header');
		$this->load->view('template/accounts/menubar');
		$this->load->view('template/accounts/headerbar');
		$this->load->view('accounts/consolidated_report_1',$data);
		$this->load->view('template/accounts/footer');

	}

	public function consolidatedPaidReports(){

		$data['category'] = $this->db->select("*")->from("accounts_category")->get()->result();

		 $categorys = $_POST['category'];
		 $main_course_id = $_POST['main_course_id'];
		 $app_course_id = $_POST['app_course_id'];
		 $year = $_POST['year'];
		 $batch = $_POST['batch'];
		 $datef = date("Y-m-d H:i:s",strtotime($_POST['datef']));
		 $datet = date("Y-m-d H:i:s",strtotime($_POST['datet']));



		 
		 $data['categorys'] = $categorys;
		 $data['main_course_id'] = $main_course_id;
		 $data['app_course_id'] = $app_course_id;
		 $data['year'] = $year;
		 $data['batch'] = $batch;
		 $data['fdate'] = $_POST['datef'];
		 $data['tdate'] = $_POST['datet'];

		if(!isset($datef) || !isset($datet) ){

 $this->session->set_flashdata(
	"message",
	' <div class="alert alert-danger alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong>Please select the date .
</div>'
);

redirect("Accounts/consolidatedReports/", "refresh");
 
		}else{

		

			if($categorys !="" ){

				$where_cat = $this->db->where("accounts_fees_transaction.af_category_id", $categorys);
			 }else{
				$where_cat ="";

			 }


			 if($main_course_id !="" ){

				$where_stream = $this->db->where("accounts_fees_transaction.af_main_id", $main_course_id);
			 }else{
				$where_stream ="";

			 }	 
			 
			 if($app_course_id !="" ){

				$where_cour = $this->db->where("accounts_fees_transaction.af_course_id", $app_course_id);
			 }else{
				$where_cour ="";

			 } 
			 
			 
			 
			 if($year !="" ){

				$where_year= $this->db->where("accounts_fee_master.year", $year);
			 }else{
				$where_year="";

			 }

			 if($batch !="" ){

				$where_batch = $this->db->where("accounts_fee_master.batch", $batch);
			 }else{
				$where_batch ="";

			 }
			 
			 
			 if($datef !="" ){

				$where_date_from = $this->db->where("accounts_fees_transaction.af_response_time >=", $datef);
			 }else{
				$where_date_from ="";

			 }if($datet !="" ){

				$where_date_to = $this->db->where("accounts_fees_transaction.af_response_time <=", $datet);
			 }else{
				$where_date_to ="";

			 }



$this->db->select("*")->from("accounts_fees_transaction");
$this->db->join("admitted_student", "accounts_fees_transaction.af_reg_number = admitted_student.as_reg_num");
$this->db->join("accounts_fee_master", "accounts_fees_transaction.af_fees_id = accounts_fee_master.f_id", 'right');
$this->db->join("accounts_category", "accounts_fees_transaction.af_category_id = accounts_category.ac_id", 'right');
$this->db->join("stu_user", "accounts_fees_transaction.af_student_id = stu_user.u_id ", 'left');
$this->db->where("accounts_fees_transaction.af_paid_status", 1);
			
$where_cat;			
$where_stream;			
$where_cour;			
$where_year;			
$where_batch;			
$where_date_from;			
$where_date_to;			


		
$this->db->order_by("accounts_fees_transaction.af_id", "DESC");
$t =$this->db->get();

			$m = $t->result();
			
			$data['transaction']=$m;
/*  echo"<pre>";

print_r($_POST); 
print_r($m); 
 */
	  	$this->load->view('template/accounts/header');
		$this->load->view('template/accounts/menubar');
		$this->load->view('template/accounts/headerbar');
		$this->load->view('accounts/student_consolidated_report',$data);
		$this->load->view('template/accounts/footer');  
	}

	}

	public function studentPaidReports(){



		$ref_num = $_POST['ref_number'];


		if(!isset($ref_num)){

 $this->session->set_flashdata(
	"message",
	' <div class="alert alert-danger alert-dismissible">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong>Please enter Register Student number .
</div>'
);

redirect("Accounts/studentSearchReports/", "refresh");
 
		}else{



	

		$s = $this->db->select("*")
		->from("admitted_student")
		->join("shotlisted_candidate", "admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id ")
		->join(
			"Applyed_Cources",
			"Applyed_Cources.main_course_id=shotlisted_candidate.sl_main_id AND Applyed_Cources.applied_course_id=shotlisted_candidate.sl_course_id AND Applyed_Cources.user_id=shotlisted_candidate.sl_student_id "
		)
	
		->where("shotlisted_candidate.reservation_status", 1)
//->where("shotlisted_candidate.reservation_status",1)
		->where("admitted_student.as_reg_num", $ref_num)
		->get();


		$pr = $s->num_rows();

if($pr > 0){

	$prt = $s->result();


$registernum = $prt[0]->as_reg_num;
$as_app_number = $prt[0]->as_app_number;
$name = $prt[0]->as_name;
$admitted_year = $prt[0]->year;
$sl_student_id = $prt[0]->sl_student_id;
$as_profile = $prt[0]->as_profile;
$department = $prt[0]->course_name;

$datastudent = array(

	'name'=>$name,
	'year'=>$admitted_year,
	'department'=>$department,
	'studentid'=>$sl_student_id,
	'register_number'=>$registernum ,
	'application_number'=>$as_app_number ,
	'profile_image'=>$as_profile,
);

$refnum = date('y',strtotime($admitted_year."-01-01")).$sl_student_id;

$t = $this->db->select("*")->from("accounts_fees_transaction")

			->join("accounts_fee_master", "accounts_fees_transaction.af_fees_id = accounts_fee_master.f_id", 'right')
			->join("accounts_category", "accounts_fees_transaction.af_category_id = accounts_category.ac_id", 'right')
			//->join("stu_user", "accounts_fees_transaction.af_student_id = stu_user.u_id ", 'right')
			->where("accounts_fees_transaction.af_paid_status", 1)
			
			->where("accounts_fees_transaction.af_reg_number", $registernum)
			->or_where("accounts_fees_transaction.af_reg_number", $refnum)
			->order_by("accounts_fees_transaction.af_id", "DESC")->get();

			$m = $t->result();
			$data['student_info']=$datastudent;
			$data['transaction']=$m;

}

	 	$this->load->view('template/accounts/header');
		$this->load->view('template/accounts/menubar');
		$this->load->view('template/accounts/headerbar');
		$this->load->view('accounts/student_fees_report',$data);
		$this->load->view('template/accounts/footer'); 
	}

	}
	public function selectunPaidUser()
	{
		
		
		$items=[];
		$main_c_id = $this->input->post("main_course_id");
		$apply_c_id = $this->input->post("app_course_id");
		$year = $this->input->post("year");

		$batch = $this->input->post("batch");
		$category = $this->input->post("category");

		$complete_master =  $this->db->select("*")->from("accounts_fee_master")->where("main_id", $main_c_id)->where("cour_id", $apply_c_id)->where("year", $year)->where("batch", $batch)->where("f_category", $category)
			->get()->result_array();

		$att = array_column($complete_master, "f_id");
  
	
		$installment =  $this->db->select("*")->from("accounts_fee_master")->where("main_id", $main_c_id)->where("cour_id", $apply_c_id)->where("year", $year)->where("batch", $batch)->where("f_category", $category)->where("payment_type", 2)
			->get()->result_array();
			//$installment_fee_paid[$value['f_id']]=$data[0]->as_student_id;

			$installment_fee_paid=array();
			
		echo"<pre>";
		if(sizeof($att) > 0){
		//print_r($att);
		$i=1;
		foreach ($installment as $key => $value) {

			$t = $this->db->select("*")->from("accounts_fees_transaction")->join(
				"department_details",
				"accounts_fees_transaction.af_main_id = department_details.main_id AND accounts_fees_transaction.af_course_id = department_details.cour_id"
			)
				/* ->join(
					"Applyed_Cources",
					"accounts_fees_transaction.af_main_id = Applyed_Cources.main_course_id AND accounts_fees_transaction.af_course_id = Applyed_Cources.applied_course_id AND accounts_fees_transaction.af_student_id = Applyed_Cources.user_id",
					"left"
				) */
				->join("admitted_student", "accounts_fees_transaction.af_reg_number = admitted_student.as_reg_num")
				->join("accounts_fee_master", "accounts_fees_transaction.af_fees_id = accounts_fee_master.f_id")
				->join("accounts_category", "accounts_fees_transaction.af_category_id = accounts_category.ac_id")
				->join("stu_user", "accounts_fees_transaction.af_student_id = stu_user.u_id ", 'left')
				->where("accounts_fees_transaction.af_paid_status", 1)
				->where("accounts_fees_transaction.af_fees_id", $value['f_id'])
				->order_by("accounts_fees_transaction.af_id", "DESC")
				->order_by("accounts_fees_transaction.af_installment_id", "ASC")
				->get();
	
			$data = $t->result();
			foreach ($data as $key => $test) {
				 
			$items[$value['f_id']][$key]=$test->as_student_id;
			}
			print_r($items[$value['f_id']]);
			// = $array;
			//$md_array["recipe_type"][] = $newdata;
		$i++;

		}

		$tn = $this->db->select("*")->from("accounts_fees_transaction")->join(
			"department_details",
			"accounts_fees_transaction.af_main_id = department_details.main_id AND accounts_fees_transaction.af_course_id = department_details.cour_id"
		)
		
			->join("admitted_student", "accounts_fees_transaction.af_reg_number = admitted_student.as_reg_num")
			->join("accounts_fee_master", "accounts_fees_transaction.af_fees_id = accounts_fee_master.f_id")
			->join("accounts_category", "accounts_fees_transaction.af_category_id = accounts_category.ac_id")
			->join("stu_user", "accounts_fees_transaction.af_student_id = stu_user.u_id ", "left") 
			->where_in("accounts_fees_transaction.af_fees_id", $att)
			->order_by("accounts_fees_transaction.af_id", "DESC")
			->order_by("accounts_fees_transaction.af_installment_id", "ASC")
			->get();

		$dataa = $tn->result();


		echo"<pre>";
	//	print_r($items);
	$full_Payment=[];
		$install_ment=[];
  foreach ($dataa as $key => $value) {
			if($value->payment_type == 1){

				array_push($full_Payment,$value->as_student_id);
	
			}else{

				array_push($install_ment,$value->as_student_id);
			}
		} 

		$tot_student = $this->db->select("as_student_id")
		->from("admitted_student")
		->join("shotlisted_candidate", "admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id ","right")
		->where("shotlisted_candidate.reservation_status", 1)
		->where("shotlisted_candidate.sl_main_id", $main_c_id)
		->where("shotlisted_candidate.sl_course_id", $apply_c_id)
		//->where("shotlisted_candidate.principal_published", 1)
		->where("admitted_student.year",$batch )
		->get();
		$tot_s = $tot_student->result();
		$tot_sn = array_column($tot_s,'as_student_id');

		$arr_1_final = array_diff($tot_sn, $full_Payment);

		print_r($tot_sn);
		print_r($full_Payment);
		//$arr_1_final = array_column($arr_1_final,"");
		$arr_1_final = array_values($arr_1_final);
		print_r($arr_1_final);
		echo sizeof($items);
		print_r($items);
	
	
	$install_ment=[];
		
	}else{

echo"No data Found";

	}

		/* $this->load->view('template/accounts/header');
		$this->load->view('template/accounts/menubar');
		$this->load->view('template/accounts/headerbar');
		$this->load->view('accounts/paid_users', $data);
		$this->load->view('template/accounts/footer'); */
	}

	public function selectClassReport()
	{
			

		$array_student_details = [];
		$array_report = [];
		$dataaa = [];
		$items=[];
		$main_c_id = $this->input->post("main_course_id");
		$apply_c_id = $this->input->post("app_course_id");
		$year = $this->input->post("year");

		$batch = $this->input->post("batch");
		$category = $this->input->post("category");

		$complete_master =  $this->db->select("*")->from("accounts_fee_master")->where("main_id", $main_c_id)->where("cour_id", $apply_c_id)->where("year", $year)->where("batch", $batch)->where("f_category", $category)
			->get()->result_array();

		$att = array_column($complete_master, "f_id");
  
	

	
		$tot_student = $this->db->select("*")
		->from("admitted_student")
		->join("shotlisted_candidate", "admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id ","right")
		//->join("accounts_fees_transaction", "admitted_student.as_reg_num=accounts_fees_transaction.af_reg_number ","right")
		//->join("accounts_fee_master", "accounts_fees_transaction.af_fees_id = accounts_fee_master.f_id")
		//->join("accounts_category", "accounts_fees_transaction.af_category_id = accounts_category.ac_id")
			->where("shotlisted_candidate.reservation_status", 1)
		->where("shotlisted_candidate.sl_main_id", $main_c_id)
		->where("shotlisted_candidate.sl_course_id", $apply_c_id)
		//->where_in("accounts_fees_transaction.af_fees_id", $att)
		->where("admitted_student.year",$batch )
		->get();



	
		$tot_stud = $tot_student->result();
		//echo"<pre>";

foreach ($tot_stud as $key => $value) {

	$student_details = array(
'Student_Register_Number'=>$value->as_reg_num,
'Student_Name'=>$value->as_name,
'Student_Application_Number'=>$value->as_app_number,
'Student_Batch'=>$value->year,
	);

	//$array_student_details[] = $student_details;
	array_push($array_student_details,$student_details);

	foreach ($att as $key => $fid) {
		$complete_master =  $this->db->select("*")->from("accounts_fee_master")->where("main_id", $main_c_id)->where("cour_id", $apply_c_id)->where("year", $year)->where("batch", $batch)->where("f_category", $category)->where("f_id", $fid)
		->get()->result_array();
	

		
	$tn = $this->db->select("*")->from("accounts_fees_transaction")->join(
		"department_details",
		"accounts_fees_transaction.af_main_id = department_details.main_id AND accounts_fees_transaction.af_course_id = department_details.cour_id"
	)
	
		//->join("admitted_student", "accounts_fees_transaction.af_reg_number = admitted_student.as_reg_num")
		->join("accounts_fee_master", "accounts_fees_transaction.af_fees_id = accounts_fee_master.f_id",'left')
		->join("accounts_category", "accounts_fees_transaction.af_category_id = accounts_category.ac_id")
		//->join("stu_user", "accounts_fees_transaction.af_student_id = stu_user.u_id ", "left") 
		->where("accounts_fees_transaction.af_fees_id", $fid)
		->where("accounts_fees_transaction.af_reg_number", $value->as_reg_num)
		->or_where("accounts_fees_transaction.af_reg_number", date('y',strtotime($batch."-01-01")).$value->as_student_id)
		->order_by("accounts_fees_transaction.af_id", "DESC")
		//->order_by("admitted_student.as_reg_num", "ASC")
		->get();

	$dataa = $tn->num_rows();
	
	
	
	
if($complete_master[0]['payment_type'] == 1){

	$payment_ty = "Full Payment";
}else{
	$payment_ty = "Installment Payment";

}

	//print_r($dataaa);
	if( $dataa == 0){
		$array_reportes =array(
			'Payment_Student'=>$value->as_reg_num,
			'Payment_mode'=>$complete_master[0]['f_name'],
			'Payment_type'=>$payment_ty ,
			'Payment_amount'=>"--No-----",
			'Payment_discription'=>$complete_master[0]['f_discription'],
			'Payment_date'=>"-----NO------",
			'Payed_through'=>"----NO-------",
		);

		/* echo $complete_master[0]['f_name']."<br>";
		print_r($dataaa); */
	
		//array_push($array_report,$array_reportes);
	}else{
		$dataaa = $tn->result_array();

		if($dataaa[0]['af_generated_by'] == 0 || $dataaa[0]['af_generated_by']== 1){

$pay_thyough = "ERP APP";
		}else if($dataaa[0]['af_generated_by'] == 2){
			$pay_thyough = "MESSI APP";

		}else{
			$pay_thyough = "OFF - LINE";

		}


		$array_reportes =array(
			'Payment_Student'=>$value->as_reg_num,
			'Payment_mode'=>$complete_master[0]['f_name'],
			'Payment_type'=>$payment_ty ,
			'Payment_amount'=>$dataaa[0]['af_fees_total_amt'],
			'Payment_discription'=>$complete_master[0]['f_discription'],
			'Payment_date'=>$dataaa[0]['af_response_time'],
			'Payed_through'=>$pay_thyough,
		);
		/* echo $complete_master[0]['f_name']."<br>";
		echo "No------------Data---------Found-----"."<br>"; */

	}
	array_push($array_report,$array_reportes);
	//array_push($items,$array_reportes,$array_student_details);
	
}

	

}
	$data['Student_l']=$array_student_details;
	$data['paid_l']=$array_report;


		$this->load->view('template/accounts/header');
		$this->load->view('template/accounts/menubar');
		$this->load->view('template/accounts/headerbar');
		$this->load->view('accounts/paid_student_report_class', $data);
		$this->load->view('template/accounts/footer');
	}
	
	
	public function unPaidGenReport()
	{
			$full_payment =[];
			$install =[];
			$first_install =[];
			//$second_install =[];

		$array_student_details = [];
		$array_report = [];
		$dataaa = [];
		$items=[];
		$main_c_id = $this->input->post("main_course_id");
		$apply_c_id = $this->input->post("app_course_id");
		$year = $this->input->post("year");

		$batch = $this->input->post("batch");
		$category = $this->input->post("category");

		$complete_master =  $this->db->select("*")->from("accounts_fee_master")->where("main_id", $main_c_id)->where("cour_id", $apply_c_id)->where("year", $year)->where("batch", $batch)->where("f_category", $category)
			->get()->result_array();

		$att = array_column($complete_master, "f_id");
  
	

		$tot_student = $this->db->select("*")
		->from("admitted_student")
		->join("shotlisted_candidate", "admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id ","right")
		
			->where("shotlisted_candidate.reservation_status", 1)
		->where("shotlisted_candidate.sl_main_id", $main_c_id)
		->where("shotlisted_candidate.sl_course_id", $apply_c_id)

		->where("admitted_student.year",$batch )
		->order_by("admitted_student.as_reg_num","ASC" )
		->get();

		$tedd = $tot_student->result();
		
		$user_array = $tot_student->result_array();


		$user_arr = array_column($user_array, "as_student_id");



		$unpaid['fee_cat']=$complete_master;
		$unpaid['full_cat']= $this->db->select("*")->from("accounts_fee_master")->where("main_id", $main_c_id)
		->where("cour_id", $apply_c_id)->where("year", $year)->where("batch", $batch)
		->where("payment_type", 1)
		->where("f_category", $category)
		->get()->result_array();


$array_paid =[];
$array_Complete =[];
$i=1;
		foreach ($tedd as $key => $value) {



//

$array_paid[$i]['user_id']=$value->as_student_id;
$array_paid[$i]['user_name']=$value->as_name;
$array_paid[$i]['user_reg_no']=$value->as_reg_num;
$array_paid[$i]['user_app_no']=$value->as_app_number;

		foreach ($att as $key => $value_pay) {



	$tn = $this->db->select("*")->from("accounts_fees_transaction")->join(
				"department_details",
				"accounts_fees_transaction.af_main_id = department_details.main_id AND accounts_fees_transaction.af_course_id = department_details.cour_id"
			)->where("accounts_fees_transaction.af_fees_id", $value_pay)
			
				->where("accounts_fees_transaction.af_paid_status", 1)
				->where("accounts_fees_transaction.af_student_id", $value->as_student_id)
				->order_by("accounts_fees_transaction.af_id", "DESC")
				//->order_by("admitted_student.as_reg_num", "ASC")
				->get();


			$num_row=	$tn->num_rows();

			//echo $num_row.PHP_EOL;



			if($num_row == 0){


			$array_paid[$i][$value_pay]="0";
		//	$array_paid[$i][$value_pay][]="0";
			}else{
				$num_ans=	$tn->result();
		
				
					$array_paid[$i][$value_pay]=$num_ans[0]->af_fees_total_amt;
				

			}



		}


		$i++;

	
}

$unpaid['unpaid']=$array_paid;



$this->load->view('template/accounts/header');
$this->load->view('template/accounts/menubar');
$this->load->view('template/accounts/headerbar');
$this->load->view('accounts/un_paid_report_one_line', $unpaid);
$this->load->view('template/accounts/footer');




	
}

public function unPaidGenReportStd()
	{
			$full_payment =[];
			$install =[];
			$first_install =[];
			//$second_install =[];

		$array_student_details = [];
		$array_report = [];
		$dataaa = [];
		$items=[];
		$main_c_id = $this->input->post("main_course_id");
		$apply_c_id = $this->input->post("app_course_id");
		$year = $this->input->post("year");

		$batch = $this->input->post("batch");
		$category = $this->input->post("category");

		$complete_master =  $this->db->select("*")->from("accounts_fee_master")->where("main_id", $main_c_id)->where("cour_id", $apply_c_id)->where("year", $year)->where("batch", $batch)->where("f_category", $category)
			->get()->result_array();

		$att = array_column($complete_master, "f_id");
  
	

		$tot_student = $this->db->select("*")
		->from("admitted_student")
		->join("shotlisted_candidate", "admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id ","right")
		
			->where("shotlisted_candidate.reservation_status", 1)
		->where("shotlisted_candidate.sl_main_id", $main_c_id)
		->where("shotlisted_candidate.sl_course_id", $apply_c_id)

		->where("admitted_student.year",$batch )
		->get();

		$tedd = $tot_student->result();
		$user_array = $tot_student->result_array();


		$user_arr = array_column($user_array, "as_student_id");

		foreach ($tedd as $key => $value) {



			$tn = $this->db->select("*")->from("accounts_fees_transaction")->join(
				"department_details",
				"accounts_fees_transaction.af_main_id = department_details.main_id AND accounts_fees_transaction.af_course_id = department_details.cour_id"
			)
			

				->where_in("accounts_fees_transaction.af_fees_id", $att)
			//	->where_in("accounts_fees_transaction.af_installment_id", 1)
				->where("accounts_fees_transaction.af_reg_number", $value->as_reg_num)
				->or_where("accounts_fees_transaction.af_reg_number", date('y',strtotime($batch."-01-01")).$value->as_student_id)
				->order_by("accounts_fees_transaction.af_id", "DESC")
				//->order_by("admitted_student.as_reg_num", "ASC")
				->get()->result();

if(sizeof($tn) > 0 ){
	if($tn[0]->af_installment_id ==1){

		array_push($full_payment,$tn[0]->af_student_id);

	}else{

		array_push($install,$tn[0]->af_student_id);
	}
	
}

		$dups = array();
		foreach(array_count_values($install) as $val => $c)
				if($c > 1) $dups[] = $val;
				if($c > 1) $full_payment[] = $val;
				if($c == 1) $first_install[] = $val;

	
$unpaid_user=[];

$unpaid_user=array_diff($user_arr,$full_payment);


$unpais_first_install=[];

$unpais_first_install=array_diff($unpaid_user,$install);


$upaid_first_student = $this->db->select("*")
->from("admitted_student")
->join("shotlisted_candidate", "admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id ","right")

	->where_in("admitted_student.as_student_id",$unpais_first_install)
	->where("shotlisted_candidate.reservation_status", 1)
->where("shotlisted_candidate.sl_main_id", $main_c_id)
->where("shotlisted_candidate.sl_course_id", $apply_c_id)

->where("admitted_student.year",$batch )
->get()->result();

$data=[];


$complete_master =  $this->db->select("*")->from("accounts_fee_master")->where("main_id", $main_c_id)->where("cour_id", $apply_c_id)->where("year", $year)->where("batch", $batch)->where("f_category", $category)
			->get()->result_array();

			
foreach ($upaid_first_student as $key => $value) {



	$data[] = array(
		"app_no"=>$value->as_app_number,
		"stud_name"=>$value->as_name,
		"stud_id"=>$value->as_student_id,
		"register_no"=>$value->as_reg_num,
	'installment'=>1, 
);   
}
$upaid_remain = $this->db->select("*")
->from("admitted_student")
->join("shotlisted_candidate", "admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id ","right")
->where_in("admitted_student.as_student_id",$unpaid_user)
->where("shotlisted_candidate.reservation_status", 1)
->where("shotlisted_candidate.sl_main_id", $main_c_id)
->where("shotlisted_candidate.sl_course_id", $apply_c_id)
->where("admitted_student.year",$batch )
->get()->result();

foreach ($upaid_remain as $key => $value) {
	$data[] = array(
		"app_no"=>$value->as_app_number,
		"stud_name"=>$value->as_name,
		"stud_id"=>$value->as_student_id,
		"register_no"=>$value->as_reg_num,
	'installment'=>2, 
);   
}

$unpaid['unpaid']=$data;

$this->load->view('template/accounts/header');
$this->load->view('template/accounts/menubar');
$this->load->view('template/accounts/headerbar');
$this->load->view('accounts/un_paid_report', $unpaid);
$this->load->view('template/accounts/footer');
	

	}
	
}
	public function applicationFeesCollected(){


		
		//echo $this->asyear;
	
		/* echo date('Y',strtotime($this->asyear));
		
		
		exit */;
		
			$mahrm = 0; 
			$mahrmod = 0; 
			$mase = 0; 
			$madm = 0; 
			$msccp = 0; 
			$mswde = 0; 
	
	
	
				$m = $this->db->select("*")->from("Applyed_Cources")
				->join(
					"Applyed_Master",
					"Applyed_Master.id=Applyed_Cources.master_id",
					"left"
				) ->where("Applyed_Cources.main_course_id",1)->where("Applyed_Cources.applied_course_id",5)->where(
					"Applyed_Master.date >=",$this->asyear
				   
				)->where(
					"Applyed_Master.date <",$this->aeyear
				   
				)->get();
				$mahrm = $m->num_rows();
	
				$mod = $this->db->select("*")->from("Applyed_Cources")
				->join(
					"Applyed_Master",
					"Applyed_Master.id=Applyed_Cources.master_id",
					"left"
				) ->where("Applyed_Cources.main_course_id",1)->where("Applyed_Cources.applied_course_id",6)->where(
					"Applyed_Master.date >=",$this->asyear
				   
				)->where(
					"Applyed_Master.date <",$this->aeyear
				   
				)->get();
				$mahrmod = $mod->num_rows();
	
				$mse = $this->db->select("*")->from("Applyed_Cources")
				->join(
					"Applyed_Master",
					"Applyed_Master.id=Applyed_Cources.master_id",
					"left"
				) ->where("Applyed_Cources.main_course_id",1)->where("Applyed_Cources.applied_course_id",7)->where(
					"Applyed_Master.date >=",$this->asyear
				   
				)->where(
					"Applyed_Master.date <",$this->aeyear
				   
				)->get();
				$mase = $mse->num_rows();
	
				$mdm = $this->db->select("*")->from("Applyed_Cources") ->join(
					"Applyed_Master",
					"Applyed_Master.id=Applyed_Cources.master_id",
					"left"
				) ->where("Applyed_Cources.main_course_id",1)->where("Applyed_Cources.applied_course_id",8)->where(
					"Applyed_Master.date >=",$this->asyear
				   
				)->where(
					"Applyed_Master.date <",$this->aeyear
				   
				)->get();
				$madm = $mdm->num_rows();
	
				$mscc = $this->db->select("*")->from("Applyed_Cources") ->join(
					"Applyed_Master",
					"Applyed_Master.id=Applyed_Cources.master_id",
					"left"
				) ->where("Applyed_Cources.main_course_id",1)->where("Applyed_Cources.applied_course_id",9)->where(
					"Applyed_Master.date >=",$this->asyear
				   
				)->where(
					"Applyed_Master.date <",$this->aeyear
				   
				)->get();
				$msccp = $mscc->num_rows();
	
				$mde = $this->db->select("*")->from("Applyed_Cources") ->join(
					"Applyed_Master",
					"Applyed_Master.id=Applyed_Cources.master_id",
					"left"
				)-> where("Applyed_Cources.main_course_id",1)->where("Applyed_Cources.applied_course_id",15)->where(
					"Applyed_Master.date >=",$this->asyear
				   
				)->where(
					"Applyed_Master.date <",$this->aeyear
				   
				)->get();
				$mswde = $mde->num_rows();
				
				
				$msccpf = $this->db->select("*")->from("Applyed_Cources") ->join(
					"Applyed_Master",
					"Applyed_Master.id=Applyed_Cources.master_id",
					"left"
				) ->where("Applyed_Cources.main_course_id",1)->where("Applyed_Cources.applied_course_id",16)
				->where(
					"Applyed_Master.date >=",$this->asyear
				   
				)->where(
					"Applyed_Master.date <",$this->aeyear
				   
				)->get();
				$msccpfd = $msccpf->num_rows();
	
	
			$data['mahrm'] = $mahrm * 500;
			$data['mahrmod'] = $mahrmod * 500;
			$data['mase'] = $mase * 500;
			$data['madm'] = $madm * 500;
			$data['msccp'] = $msccp * 500;
			$data['mswde'] = $mswde * 500;
			$data['msccpf'] = $msccpfd * 500;
	
	
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
	
	
			$q = $this->db->select("*")->from("Applyed_Master")->where("main_course_priority","PG")->where(
				"Applyed_Master.date >=",$this->asyear
			   
			)->where(
				"Applyed_Master.date <",$this->aeyear
			   
			)->get();
	
	
			$s = $q->result();
	
	
	
	foreach ($s as $key => $value) {
	
	
		$m = $this->db->select("*")->from("Applyed_Cources") ->join(
			"Applyed_Master",
			"Applyed_Master.id=Applyed_Cources.master_id",
			"left"
		)->where("Applyed_Cources.master_id",$value->id)->where(
			"Applyed_Master.date >=",$this->asyear
		   
		)->where(
			"Applyed_Master.date <",$this->aeyear
		   
		)->get();
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
	
	
	
				$ug_bsw = $this->db->select("*")->from("Applyed_Cources")->join(
					"Applyed_Master",
					"Applyed_Master.id=Applyed_Cources.master_id",
					"left"
				)->where("Applyed_Cources.main_course_id",5)->where("Applyed_Cources.applied_course_id",1)->where(
					"Applyed_Master.date >=",$this->asyear
				   
				)->where(
					"Applyed_Master.date <",$this->aeyear
				   
				)->get();
				$ugbsw = $ug_bsw->num_rows();
	
				$ug_bsc = $this->db->select("*")->from("Applyed_Cources")->join(
					"Applyed_Master",
					"Applyed_Master.id=Applyed_Cources.master_id",
					"left"
				)->where("Applyed_Cources.main_course_id",5)->where("Applyed_Cources.applied_course_id",2)->where(
					"Applyed_Master.date >=",$this->asyear
				   
				)->where(
					"Applyed_Master.date <",$this->aeyear
				   
				)->get();
				$ugbsc = $ug_bsc->num_rows();
	
				$pg_dip_ir = $this->db->select("*")->from("Applyed_Cources")->join(
					"Applyed_Master",
					"Applyed_Master.id=Applyed_Cources.master_id",
					"left"
				)->where("Applyed_Cources.main_course_id",4)->where("Applyed_Cources.applied_course_id",10)->where(
					"Applyed_Master.date >=",$this->asyear
				   
				)->where(
					"Applyed_Master.date <",$this->aeyear
				   
				)->get();
				$pgdipir = $pg_dip_ir->num_rows();
	
				$pg_dip_hr = $this->db->select("*")->from("Applyed_Cources")->join(
					"Applyed_Master",
					"Applyed_Master.id=Applyed_Cources.master_id",
					"left"
				)->where("Applyed_Cources.main_course_id",4)->where("Applyed_Cources.applied_course_id",11)->where(
					"Applyed_Master.date >=",$this->asyear
				   
				)->where(
					"Applyed_Master.date <",$this->aeyear
				   
				)->get();
				$pgdiphr = $pg_dip_hr->num_rows();
	
	
			$data['ugbsw1'] = $ugbsw * 350;
			$data['ugbsc1'] = $ugbsc * 350;
			$data['pgdipir1'] = $pgdipir * 500;
			$data['pgdiphr1'] = $pgdiphr * 500;
	
	
	
	$this->load->view('template/accounts/header');
	$this->load->view('template/accounts/menubar');
	$this->load->view('template/accounts/headerbar');
	$this->load->view('accounts/applicationfeescollected',$data);
	$this->load->view('template/accounts/footer'); 
	
	
	/* print_r($data); */
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
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
				
					$this->db->select('stu_user.*,shotlisted_candidate.*,Applyed_Cources.*,new_preview_pg.*,sub_preview_pg.*,student_complete_mark.personal_mark');
					$this->db->from('shotlisted_candidate');
					//$this->db->from('Applyed_Cources');
					$this->db->join('Applyed_Cources','shotlisted_candidate.sl_student_id=Applyed_Cources.user_id AND shotlisted_candidate.sl_main_id=Applyed_Cources.main_course_id and shotlisted_candidate.sl_course_id=Applyed_Cources.applied_course_id');
					$this->db->join('stu_user', 'shotlisted_candidate.sl_student_id=stu_user.u_id','right');
					$this->db->join('new_preview_pg', 'shotlisted_candidate.sl_student_id=new_preview_pg.pr_user_id','right');
					$this->db->join('admitted_student', 'shotlisted_candidate.sl_id=admitted_student.as_shotlist_ref_number','right');
					$this->db->join('sub_preview_pg', 'shotlisted_candidate.sl_student_id=sub_preview_pg.sb_u_id','right');
					$this->db->join('student_complete_mark', 'shotlisted_candidate.sl_main_id=student_complete_mark.main_course_id and shotlisted_candidate.sl_course_id=student_complete_mark.app_course_id and shotlisted_candidate.sl_student_id=student_complete_mark.stu_id','left');
					$this->db->where('shotlisted_candidate.reservation_status',1);
					$this->db->where('shotlisted_candidate.sl_main_id',$main_cour_id);
					$this->db->where('shotlisted_candidate.sl_course_id',$app_cour_id);
					
					
					
					$this->db->where('shotlisted_candidate.created >',$this->asyear);
					$this->db->where('shotlisted_candidate.created <',$this->aeyear);
					
				//	$this->db->where_in("Applyed_Cources.user_id",$arrma_dm );
					$st_dm =	$this->db->get();
				
					$data['applied'] = $st_dm->result();
					$data['course'] = 2;
		
			if($main_cour_id == 1){
		
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
					case "16":
						$data['subject']='MSCCF';
						$data['department']='M.Sc. Family Theropy (SF)';
					break;
		
					default:
					$data['subject']='MSW';
					$data['department']='';
					}
		
			}else if($main_cour_id == 2){
				switch ($app_cour_id) {
			
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
		
		
			}else{
		
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
		
		
		
			}
				
		
			
			
					$this->load->view('template/accounts/header');
					$this->load->view('template/accounts/menubar');
					$this->load->view('template/accounts/headerbar');
					//$this->load->view('admin/student_applied',$data);
					$this->load->view('accounts/student_export',$data);
					$this->load->view('template/accounts/footer',$data);
				
		
		}public function importExcelUg(){
		
			//$main_cour_id = $this->uri->segment(3);
			$app_cour_id = $this->uri->segment(4);
		
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
		
		
		
		
		
			$this->db->select('stu_user.*,shotlisted_candidate.*,Applyed_Cources.*,new_preview.*,sub_preview.*');
					$this->db->from('shotlisted_candidate');
					//$this->db->from('Applyed_Cources');
					$this->db->join('Applyed_Cources','shotlisted_candidate.sl_student_id=Applyed_Cources.user_id AND shotlisted_candidate.sl_main_id=Applyed_Cources.main_course_id and shotlisted_candidate.sl_course_id=Applyed_Cources.applied_course_id');
					$this->db->join('stu_user', 'shotlisted_candidate.sl_student_id=stu_user.u_id','right');
					$this->db->join('admitted_student', 'shotlisted_candidate.sl_id=admitted_student.as_shotlist_ref_number','right');
		
					$this->db->join(
						"new_preview",
						"shotlisted_candidate.sl_student_id=new_preview.pr_user_id",
						"right"
					);
					$this->db->join(
						"sub_preview",
						"shotlisted_candidate.sl_student_id=sub_preview.sb_u_id",
						"right");
		
		
			
					$this->db->where('shotlisted_candidate.reservation_status',1);
					$this->db->where('shotlisted_candidate.sl_main_id',5);
					$this->db->where('shotlisted_candidate.sl_course_id',$app_cour_id);
					$this->db->where('shotlisted_candidate.created >',$this->asyear);
					$this->db->where('shotlisted_candidate.created <',$this->aeyear);
				//	$this->db->where_in("Applyed_Cources.user_id",$arrma_dm );
					$user =	$this->db->get();
		
		
			 
			 $data['count'] =$user->num_rows();
					$data['student'] =$user->result();
		
					$data['title'] = "Reports of Student Applied ".$this->session->userdata('user')['user_name']." ".date('d-M-Y');
			 
				
				
				
			
				
			 
					$this->load->view('template/accounts/header');
					 $this->load->view('template/accounts/menubar');
					 $this->load->view('template/accounts/headerbar');
					 $this->load->view('accounts/student_export_ug',$data);
					 $this->load->view('template/accounts/footer',$data);  
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
		
		
		
				
				$m = $this->db->select("*")->from("Applyed_Cources")
				->join(
					"Applyed_Master",
					"Applyed_Master.id=Applyed_Cources.master_id",
					"left"
				) ->where("Applyed_Cources.main_course_id",1)->where("Applyed_Cources.applied_course_id",5)->where(
					"Applyed_Master.date >=",$this->asyear
				   
				)->where(
					"Applyed_Master.date <",$this->aeyear
				   
				)->get();
				$mahrm = $m->num_rows();
	
				$mod = $this->db->select("*")->from("Applyed_Cources")
				->join(
					"Applyed_Master",
					"Applyed_Master.id=Applyed_Cources.master_id",
					"left"
				) ->where("Applyed_Cources.main_course_id",1)->where("Applyed_Cources.applied_course_id",6)->where(
					"Applyed_Master.date >=",$this->asyear
				   
				)->where(
					"Applyed_Master.date <",$this->aeyear
				   
				)->get();
				$mahrmod = $mod->num_rows();
	
				$mse = $this->db->select("*")->from("Applyed_Cources")
				->join(
					"Applyed_Master",
					"Applyed_Master.id=Applyed_Cources.master_id",
					"left"
				) ->where("Applyed_Cources.main_course_id",1)->where("Applyed_Cources.applied_course_id",7)->where(
					"Applyed_Master.date >=",$this->asyear
				   
				)->where(
					"Applyed_Master.date <",$this->aeyear
				   
				)->get();
				$mase = $mse->num_rows();
	
				$mdm = $this->db->select("*")->from("Applyed_Cources") ->join(
					"Applyed_Master",
					"Applyed_Master.id=Applyed_Cources.master_id",
					"left"
				) ->where("Applyed_Cources.main_course_id",1)->where("Applyed_Cources.applied_course_id",8)->where(
					"Applyed_Master.date >=",$this->asyear
				   
				)->where(
					"Applyed_Master.date <",$this->aeyear
				   
				)->get();
				$madm = $mdm->num_rows();
	
				$mscc = $this->db->select("*")->from("Applyed_Cources") ->join(
					"Applyed_Master",
					"Applyed_Master.id=Applyed_Cources.master_id",
					"left"
				) ->where("Applyed_Cources.main_course_id",1)->where("Applyed_Cources.applied_course_id",9)->where(
					"Applyed_Master.date >=",$this->asyear
				   
				)->where(
					"Applyed_Master.date <",$this->aeyear
				   
				)->get();
				$msccp = $mscc->num_rows();
	
				$mde = $this->db->select("*")->from("Applyed_Cources") ->join(
					"Applyed_Master",
					"Applyed_Master.id=Applyed_Cources.master_id",
					"left"
				)-> where("Applyed_Cources.main_course_id",1)->where("Applyed_Cources.applied_course_id",15)->where(
					"Applyed_Master.date >=",$this->asyear
				   
				)->where(
					"Applyed_Master.date <",$this->aeyear
				   
				)->get();
				$mswde = $mde->num_rows();
				
				
				$msccpf = $this->db->select("*")->from("Applyed_Cources") ->join(
					"Applyed_Master",
					"Applyed_Master.id=Applyed_Cources.master_id",
					"left"
				) ->where("Applyed_Cources.main_course_id",1)->where("Applyed_Cources.applied_course_id",16)->where(
					"Applyed_Master.date >=",$this->asyear
				   
				)->where(
					"Applyed_Master.date <",$this->aeyear
				   
				)->get();
				$msccpfd = $msccpf->num_rows();
		
		
				$mahrm1 = $mahrm * 500;
				$mahrmod1 = $mahrmod * 500;
				$mase1 = $mase * 500;
				$madm1 = $madm * 500;
				$msccp1 = $msccp * 500;
				$mswde1 = $mswde * 500;
				$msccpf = $msccpfd * 500;
		
		
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
		
		
			$m = $this->db->select("*")->from("Applyed_Cources") ->join(
				"Applyed_Master",
				"Applyed_Master.id=Applyed_Cources.master_id",
				"left"
			)->where("Applyed_Cources.master_id",$value->id)->where(
				"Applyed_Master.date >=",$this->asyear
			   
			)->where(
				"Applyed_Master.date <",$this->aeyear
			   
			)->get();
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
		
		
		
				$ug_bsw = $this->db->select("*")->from("Applyed_Cources")->join(
					"Applyed_Master",
					"Applyed_Master.id=Applyed_Cources.master_id",
					"left"
				)->where("Applyed_Cources.main_course_id",5)->where("Applyed_Cources.applied_course_id",1)->where(
					"Applyed_Master.date >=",$this->asyear
				   
				)->where(
					"Applyed_Master.date <",$this->aeyear
				   
				)->get();
				$ugbsw = $ug_bsw->num_rows();
	
				$ug_bsc = $this->db->select("*")->from("Applyed_Cources")->join(
					"Applyed_Master",
					"Applyed_Master.id=Applyed_Cources.master_id",
					"left"
				)->where("Applyed_Cources.main_course_id",5)->where("Applyed_Cources.applied_course_id",2)->where(
					"Applyed_Master.date >=",$this->asyear
				   
				)->where(
					"Applyed_Master.date <",$this->aeyear
				   
				)->get();
				$ugbsc = $ug_bsc->num_rows();
	
				$pg_dip_ir = $this->db->select("*")->from("Applyed_Cources")->join(
					"Applyed_Master",
					"Applyed_Master.id=Applyed_Cources.master_id",
					"left"
				)->where("Applyed_Cources.main_course_id",4)->where("Applyed_Cources.applied_course_id",10)->where(
					"Applyed_Master.date >=",$this->asyear
				   
				)->where(
					"Applyed_Master.date <",$this->aeyear
				   
				)->get();
				$pgdipir = $pg_dip_ir->num_rows();
	
				$pg_dip_hr = $this->db->select("*")->from("Applyed_Cources")->join(
					"Applyed_Master",
					"Applyed_Master.id=Applyed_Cources.master_id",
					"left"
				)->where("Applyed_Cources.main_course_id",4)->where("Applyed_Cources.applied_course_id",11)->where(
					"Applyed_Master.date >=",$this->asyear
				   
				)->where(
					"Applyed_Master.date <",$this->aeyear
				   
				)->get();
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
		 ->setCellValue('A3', 'Admission '.$this->asyear.'')
		 ->setCellValue('A4', 'Application Fees as on '.$date.'');
		$spreadsheet->setActiveSheetIndex(0)
		 ->setCellValue('A6', 'S.No')
		 ->setCellValue('B6', 'Program Name')
		 ->setCellValue('C6', 'Fees')
		 ->setCellValue('D6', 'NO. Of Application');
		
		$spreadsheet->setActiveSheetIndex(0)
		 ->setCellValue('B7', 'UG');
		 
		$spreadsheet->setActiveSheetIndex(0)
		 ->setCellValue('A8', '1')
		 ->setCellValue('B8', 'B.S.W (SF)')
		 ->setCellValue('C8', ''.$ugbsw1.'')
		 ->setCellValue('D8', ''.$ugbsw.'')
		 ->setCellValue('A9', '2')
		 ->setCellValue('B9', 'B.Sc Psychology (SF)')
		 ->setCellValue('C9', ''.$ugbsc1.'')
		 ->setCellValue('D9', ''.$ugbsc.'')
		 ->setCellValue('B11', 'PG')
		 ->setCellValue('B12', 'MSW Aided')
		 ->setCellValue('A13', '3')
		 ->setCellValue('B13', 'MSW Community Development')
		 ->setCellValue('C13', ''.$msw_aid_cm.'')
		 ->setCellValue('D13', ''.$mswaidcm.'')
		 ->setCellValue('A14', '4')
		 ->setCellValue('B14', 'MSW Medical & Psychiatric Social Work')
		 ->setCellValue('C14', ''.$msw_aid_mepy.'')
		 ->setCellValue('D14', ''.$mswaidmedphy.'')
		 ->setCellValue('A15', '5')
		 ->setCellValue('B15', 'MSW Human Resource Management')
		 ->setCellValue('C15', ''.$msw_aid_hrm.'')
		 ->setCellValue('D15', ''.$mswaidhrm.'')
		 ->setCellValue('B17', 'Self Finance')
		 ->setCellValue('A18', '6')
		 ->setCellValue('B18', 'MAHRM')
		 ->setCellValue('C18', ''.$mahrm1.'')
		 ->setCellValue('D18', ''.$mahrm.'')
		 ->setCellValue('A19', '7')
		 ->setCellValue('B19', 'MAHRMOD')
		 ->setCellValue('C19', ''.$mahrmod1.'')
		 ->setCellValue('D19', ''.$mahrmod.'')
		 ->setCellValue('A20', '8')
		 ->setCellValue('B20', 'MASE')
		 ->setCellValue('C20', ''.$mase1.'')
		 ->setCellValue('D20', ''.$mase.'')
		 ->setCellValue('A21', '9')
		 ->setCellValue('B21', 'MADM')
		 ->setCellValue('C21', ''.$madm1.'')
		 ->setCellValue('D21', ''.$madm.'')
		 ->setCellValue('A22', '10')
		 ->setCellValue('B22', 'M.SC CP')
		 ->setCellValue('C22', ''.$msccp1.'')
		 ->setCellValue('D22', ''.$msccp.'')
		 ->setCellValue('A23', '11')
		 ->setCellValue('B23', 'MSWDE')
		 ->setCellValue('C23', ''.$mswde1.'')
		 ->setCellValue('D23', ''.$mswde.'')
		 ->setCellValue('A24', '12')
		 ->setCellValue('B24', 'MSW Community Development')
		 ->setCellValue('C24', ''.$msw_self_cm.'')
		 ->setCellValue('D24', ''.$mswselfcm.'')
		 ->setCellValue('A25', '13')
		 ->setCellValue('B25', 'MSW Medical & Psychiatric Social Work')
		 ->setCellValue('C25', ''.$msw_self_mepy.'')
		 ->setCellValue('D25', ''.$mswselfmedphy.'')
		 ->setCellValue('A26', '14')
		 ->setCellValue('B26', 'MSW Human Resource Management')
		 ->setCellValue('C26', ''.$msw_self_hrm.'')
		 ->setCellValue('D26', ''.$mswselfhrm.'')
		 ->setCellValue('B28', 'PG-Diploma')
		 ->setCellValue('A29', '15')
		 ->setCellValue('B29', 'Personnel Management & Industrial Relations (SF)')
		 ->setCellValue('C29', ''.$pgdipir1.'')
		 ->setCellValue('D29', ''.$pgdipir.'')
		 ->setCellValue('A30', '16')
		 ->setCellValue('B30', 'Human Resource Management (SF)')
		 ->setCellValue('C30', ''.$pgdiphr1.'')
		 ->setCellValue('D30', ''.$pgdiphr.'')
		 ->setCellValue('B32', 'Total')
		 ->setCellValue('C32', ''.$total.'');
		




		/*  $mahrm1 = $mahrm * 500;
		 $mahrmod1 = $mahrmod * 500;
		 $mase1 = $mase * 500;
		 $madm1 = $madm * 500;
		 $msccp1 = $msccp * 500;
		 $mswde1 = $mswde * 500;
		 $msccpf = $msccpfd * 500;
 */

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
		$spreadsheet->getActiveSheet()->getStyle('D6')->applyFromArray(array('font' => $cell_st['font'], 'alignment' => $cell_st['alignment']));
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


			public function do_upload_ann()
	{
		$config = array();
		$config['upload_path'] = './uploads/admin_files/';
		$config['allowed_types'] = '*';
		$config['remove_spaces'] = TRUE;
		$config['overwrite'] = TRUE;
		return $config;
	}

	public function unPaidUserReport(){

		$main_c_id = $this->uri->segment(3);
		$apply_c_id = $this->uri->segment(4);
		$year = $this->uri->segment(5);
		$batch = $this->uri->segment(6);
		$category = $this->uri->segment(7);


		$q =  $this->db->select("*")->from("accounts_fee_master")->where("main_id", $main_c_id)->where("cour_id", $apply_c_id)->where("year", $year)->where("batch", $batch)->where("f_category", $category)
		->get()->result_array();

	$att = array_column($q, "f_id");



	$data['main_id'] = $main_c_id;
	$data['course_id'] = $apply_c_id;
	$data['year'] = $year;
	$data['batch'] = $batch;
	$data['category'] = $category;
//$m = $q->num_rows();

//print_r($att);




//foreach ($q as $key => $value) {

	$t = $this->db->select("*")->from("accounts_fees_transaction")->join(
		"department_details",
		"accounts_fees_transaction.af_main_id = department_details.main_id AND accounts_fees_transaction.af_course_id = department_details.cour_id"
	)
		->join(
			"Applyed_Cources",
			"accounts_fees_transaction.af_main_id = Applyed_Cources.main_course_id AND accounts_fees_transaction.af_course_id = Applyed_Cources.applied_course_id AND accounts_fees_transaction.af_student_id = Applyed_Cources.user_id",
			"left"
		)
		->join("accounts_fee_master", "accounts_fees_transaction.af_fees_id = accounts_fee_master.f_id")
		->join("accounts_category", "accounts_fees_transaction.af_category_id = accounts_category.ac_id")
		->join("stu_user", "accounts_fees_transaction.af_student_id = stu_user.u_id ", 'left')
		->where("accounts_fees_transaction.af_paid_status", 1)
		->where_in("accounts_fees_transaction.af_fees_id", $att)
		->order_by("accounts_fees_transaction.af_id", "DESC")
		->order_by("accounts_fees_transaction.af_installment_id", "ASC")
		->get();


		$m =$t->result();


		$spreadsheet = new Spreadsheet();
		
		//add some data in excel cells
		$spreadsheet->setActiveSheetIndex(0);

		$writer = new Xlsx($spreadsheet);
		$fxls ='Paid Reports.xlsx';
				header('Content-Type: application/vnd.ms-excel'); // generate excel file
				header('Content-Disposition: attachment;filename="'. $fxls .'"'); 
				header('Cache-Control: max-age=0');
				$writer->save('php://output');	// download file 


	}

	public function updateCondonationFees(){
		$a_year = $this->input->post('a_year');
		$a_amount = $this->input->post('a_amount');


		$data = array(
			'year'=>$a_year,
			'fine_amt'=>$a_amount,
		);

$this->db->where('id',1);
$this->db->update('exam_condanation_fees',$data);


$this->session->set_flashdata(
	"message",
	'<div class="alert alert-success alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Success !</strong> Updated Successfully .
	</div>'
);

redirect("Accounts/condonationReport" , "refresh"); 


	}
	public function condonationReport(){

		$data['category'] = $this->db->select("*")->from("accounts_category")->get()->result();
		$data['condonation'] = $this->db->select("*")->from("condanation_fee_transaction")
		->join("department_details","department_details.main_id=condanation_fee_transaction.stream AND 	department_details.cour_id=condanation_fee_transaction.department",'left')
		->get()->result();


/* echo"<pre>";
		print_r($data); */

		$this->load->view('template/accounts/header');
		$this->load->view('template/accounts/menubar');
		$this->load->view('template/accounts/headerbar');
		$this->load->view('accounts/condonation_payment',$data);
		$this->load->view('template/accounts/footer');

	}
	public function condonationPaidReports(){




$main_course_id = $this->input->post('main_course_id');
$app_course_id = $this->input->post('app_course_id');
$semester = $this->input->post('semester');
$batch = $this->input->post('batch');
$datef = $this->input->post('datef');
$datet = $this->input->post('datet');



 
		$data['category'] = $this->db->select("*")->from("accounts_category")->get()->result();
		$data['condonation'] = $this->db->select("*")->from("condanation_fee_transaction")
		->join("department_details","department_details.main_id=condanation_fee_transaction.stream AND 	department_details.cour_id=condanation_fee_transaction.department",'left')
		->where("condanation_fee_transaction.stream",$main_course_id)
		->where("condanation_fee_transaction.department",$app_course_id)
		->where("condanation_fee_transaction.semester",$semester)
		->where("condanation_fee_transaction.batch",$batch)
		->where("condanation_fee_transaction.date >=",$datef)
		->where("condanation_fee_transaction.date <=",$datet)
		->get()
		->result();

		$data['main_course_id'] = $main_course_id;
		$data['app_course_id'] = $app_course_id;
		$data['semester'] = $semester;
		$data['batch'] = $batch;
		$data['datef'] = $datef;
		$data['datet'] = $datet;


		$this->load->view('template/accounts/header');
		$this->load->view('template/accounts/menubar');
		$this->load->view('template/accounts/headerbar');
		$this->load->view('accounts/condonation_payment_search',$data);
		$this->load->view('template/accounts/footer');




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
	public function blockHallTicket()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$data['batch1']='';
		$data['stream']='';
		$data['department']='';
		$data['sem1']='';
		
		
		if(isset($_POST['submit'])){
			$data['batch1']=$batch = $this->input->post('batch');
			$data['sem1']=$sem = $this->input->post('sem');
			$data['stream']=$stream = $this->input->post('stream');
			$data['department']=$department = $this->input->post('department');
		$data['stu_list'] = $this->db->select('erp_existing_students.*')
		//->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->where('erp_existing_students.main_id',$stream)
		->where('erp_existing_students.cour_id',$department)
		->where('LEFT(erp_existing_students.batch_, 4)="'.$batch.'"')
		->get('erp_existing_students')->result();
		}
		
	$this->load->view('template/accounts/header');
    $this->load->view('template/accounts/menubar');
    $this->load->view('template/accounts/headerbar');
    $this->load->view('accounts/block_hallTicket',$data);
    $this->load->view('template/accounts/footer');
    }
	
	public function blockHt()
	{
		
		$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		
		$batch = $this->input->post('batch');
		$batch_id = $this->db->where('batch_from',$batch)->get('erp_batchmaster')->row();
		    $data['batch_id']=$batch_id->id;
		    $data['batch_year']=$batch;
			$data['type']='ACCOUNTS';
			$data['sem']=$sem = $this->input->post('sem');
			$data['main_id']=$stream = $this->input->post('stream');
			$data['course_id']=$department = $this->input->post('department');
			$data['student_id']=$student = $this->input->post('student');
			$data['status']= $this->input->post('status');
			$data['user_id']=$user_id;
			$data['created_at']=$add_date;
			
		$block_det = $this->db->where('type','ACCOUNTS')->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$student)->get('erp_block_halltickets')->row();
		if(isset($block_det)){
		$data_edit['status']= $this->input->post('status');	
		$this->db->where('id',$block_det->id);
		$update = $this->db->update('erp_block_halltickets',$data_edit);
		}else{
		$insert = $this->db->insert('erp_block_halltickets',$data);
		}
		echo 'Success';
    }
		public function getProgram()
		{
		$stream=$this->input->post('stream');
		
		$dept = $this->db->where('main_id',$stream)->get('department_details')->result();	
		
		$department = '<option value="">Select Department</option>';
		foreach($dept as $dept){
			$department .= '<option value="'.$dept->cour_id.'">'.$dept->comp_name.'</option>';
		}
		echo $department;
			}

			
			
}

