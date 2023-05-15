<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
//require APPPATH . '/libraries/dompdf/autoload.inc.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
	use Dompdf\Dompdf;
	use Dompdf\Options;
class Librarylogin extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	//  error_reporting(0);
	error_reporting(1);

	  date_default_timezone_set("Asia/Calcutta");
	  $this->load->library('upload');
	  $this->load->config('email');
		$this->load->library('email');
	    $this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('pdf');
	
	}

	public function index()
	{
		$data['user']='';
		if(isset($_POST['login']))
{
$username=$_POST['username'];
$password=md5($_POST['password']);
$sql ="SELECT UserName,Password FROM lib_admin WHERE UserName='".$username."' and Password='".$password."'";
$query= $this->db->query($sql);
if($query->num_rows() > 0)
{
	$session_data = array(
			   'alogin'=> $_POST['username'],
			   );
$this->session->set_userdata('user',$session_data);
redirect('librarylogin/admin_dashboard','refresh');
} else{
echo "<script>alert('Invalid Details');</script>";
}
}
    $this->load->view('library/template/header');
    $this->load->view('library/adminlogin',$data);
    $this->load->view('library/template/footer');
    }
	public function logOut(){
		$this->session->unset_userdata('user'); 
		redirect('employee_login', 'refresh');
	}
	public function admin_dashboard()
	{
	$this->load->view('library/template/libraryadmin/header');
    $this->load->view('library/libraryadmin/dashboard');
    $this->load->view('library/template/libraryadmin/footer');
    }
	public function manageCategory()
	{
		if(isset($_POST['del']))
{
$id=$this->input->post('edit_id');
$edit_id = array_values(array_filter($id));
$sql = "delete from tblcategory  WHERE id='".$edit_id[0]."'";
$query = $this->db->query($sql);
$data['delmsg']=$this->session->set_flashdata('delmsg','Category deleted scuccessfully ','success');
redirect('librarylogin/manageCategory','refresh');

}
	$this->load->view('library/template/libraryadmin/header');
    $this->load->view('library/libraryadmin/manage-categories');
    $this->load->view('library/template/libraryadmin/footer');
    }
	public function addCategory()
	{
		if(isset($_POST['create']))
{
$category=$_POST['category'];
$status=$_POST['status'];
$sql="INSERT INTO  tblcategory(CategoryName,Status) VALUES('".$category."','".$status."')";
$query = $this->db->query($sql);
$lastInsertId = $this->db->insert_id();
if($lastInsertId)
{
$data['msg']=$this->session->set_flashdata('success','Category added successfully','success');	
redirect('librarylogin/manageCategory','refresh');
}
else 
{
$data['error']=$this->session->set_flashdata('form_err','Something went wrong. Please try again','success');
redirect('librarylogin/manageCategory','refresh');
}

}
	$this->load->view('library/template/libraryadmin/header');
    $this->load->view('library/libraryadmin/add-category');
    $this->load->view('library/template/libraryadmin/footer');
    }
	public function editCategory()
	{
$data['catid']=$catid=$this->uri->segment(3);
$sql="SELECT * from tblcategory where id='".$catid."'";
$query=$this->db->query($sql);
$data['results']=$query->result();
		if(isset($_POST['update']))
{
$category=$_POST['category'];
$status=$_POST['status'];
$editid=$_POST['edit_id'];
$sql="update  tblcategory set CategoryName='".$category."',Status='".$status."' where id='".$editid."'";
$query = $this->db->query($sql);
$data['msg']=$this->session->set_flashdata('msg','Category updated successfully','success');
redirect('librarylogin/manageCategory');

}
	$this->load->view('library/template/libraryadmin/header');
    $this->load->view('library/libraryadmin/edit-category',$data);
    $this->load->view('library/template/libraryadmin/footer');
    }
	
	public function manageAuthor()
	{
		if(isset($_POST['del']))
{
$id=$this->input->post('edit_id');
$edit_id = array_values(array_filter($id));
$sql = "delete from tblauthors  WHERE id='".$edit_id[0]."'";
$query = $this->db->query($sql);
$data['delmsg']=$this->session->set_flashdata('delmsg','Author deleted scuccessfully ','success');
redirect('librarylogin/manageAuthor','refresh');

}
	$this->load->view('library/template/libraryadmin/header');
    $this->load->view('library/libraryadmin/manage-authors');
    $this->load->view('library/template/libraryadmin/footer');
    }
	public function addAuthor()
	{
		if(isset($_POST['create']))
{
$author=$_POST['author'];
$sql="INSERT INTO  tblauthors(AuthorName) VALUES('".$author."')";
$query = $this->db->query($sql);
$lastInsertId = $this->db->insert_id();
if($lastInsertId)
{
$data['msg']=$this->session->set_flashdata('success','Author added successfully','success');	
redirect('librarylogin/manageAuthor','refresh');
}
else 
{
$data['error']=$this->session->set_flashdata('form_err','Something went wrong. Please try again','success');
redirect('librarylogin/manageAuthor','refresh');
}

}
	$this->load->view('library/template/libraryadmin/header');
    $this->load->view('library/libraryadmin/add-author');
    $this->load->view('library/template/libraryadmin/footer');
    }
	public function editAuthor()
	{
$data['athrid']=$athrid=$this->uri->segment(3);
$sql="SELECT * from tblauthors where id='".$athrid."'";
$query=$this->db->query($sql);
$data['results']=$query->result();
		if(isset($_POST['update']))
{
$author=$_POST['author'];
$editid=$_POST['edit_id'];
$sql="update  tblauthors set AuthorName='".$author."' where id='".$editid."'";
$query = $this->db->query($sql);
$data['msg']=$this->session->set_flashdata('msg','Author updated successfully','success');
redirect('librarylogin/manageAuthor');

}
	$this->load->view('library/template/libraryadmin/header');
    $this->load->view('library/libraryadmin/edit-author',$data);
    $this->load->view('library/template/libraryadmin/footer');
    }
	
	public function manageBook()
	{
		if(isset($_POST['del']))
{
$id=$this->input->post('edit_id');
$edit_id = array_values(array_filter($id));
$sql = "delete from tblbooks  WHERE id='".$edit_id[0]."'";
$query = $this->db->query($sql);
$data['delmsg']=$this->session->set_flashdata('delmsg','Book deleted scuccessfully ','success');
redirect('librarylogin/manageBook','refresh');

}
	$this->load->view('library/template/libraryadmin/header');
    $this->load->view('library/libraryadmin/manage-books');
    $this->load->view('library/template/libraryadmin/footer');
    }
	public function addBook()
	{
		if(isset($_POST['create']))
{
$bookname=$_POST['bookname'];
$category=$_POST['category'];
$author=$_POST['author'];
$isbn=$_POST['isbn'];
$price=$_POST['price'];
$sql="INSERT INTO  tblbooks(BookName,CatId,AuthorId,ISBNNumber,BookPrice) VALUES('".$bookname."','".$category."','".$author."','".$isbn."','".$price."')";
$query = $this->db->query($sql);
$lastInsertId = $this->db->insert_id();
if($lastInsertId)
{
$data['msg']=$this->session->set_flashdata('success','Book added successfully','success');	
redirect('librarylogin/manageBook','refresh');
}
else 
{
$data['error']=$this->session->set_flashdata('form_err','Something went wrong. Please try again','success');
redirect('librarylogin/manageBook','refresh');
}

}
	$this->load->view('library/template/libraryadmin/header');
    $this->load->view('library/libraryadmin/add-book');
    $this->load->view('library/template/libraryadmin/footer');
    }
	public function editBook()
	{
$data['bookid']=$bookid=$this->uri->segment(3);
$sql="SELECT tblbooks.BookName,tblcategory.CategoryName,tblcategory.id as cid,tblauthors.AuthorName,tblauthors.id as athrid,tblbooks.ISBNNumber,tblbooks.BookPrice,tblbooks.id as bookid from  tblbooks join tblcategory on tblcategory.id=tblbooks.CatId join tblauthors on tblauthors.id=tblbooks.AuthorId where tblbooks.id='".$bookid."'";
$query=$this->db->query($sql);
$data['results']=$query->result();
		if(isset($_POST['update']))
{
$bookname=$_POST['bookname'];
$category=$_POST['category'];
$author=$_POST['author'];
$isbn=$_POST['isbn'];
$price=$_POST['price'];
$editid=$_POST['edit_id'];
$sql="update  tblbooks set BookName='".$bookname."',CatId='".$category."',AuthorId='".$author."',ISBNNumber='".$isbn."',BookPrice='".$price."' where id='".$editid."'";
$query = $this->db->query($sql);
$data['msg']=$this->session->set_flashdata('msg','Book updated successfully','success');
redirect('librarylogin/manageBook');

}
	$this->load->view('library/template/libraryadmin/header');
    $this->load->view('library/libraryadmin/edit-book',$data);
    $this->load->view('library/template/libraryadmin/footer');
    }
	
	public function manageIssuedBooks()
	{
		if(isset($_POST['del']))
{
$id=$this->input->post('edit_id');
$edit_id = array_values(array_filter($id));
$sql = "delete from tblauthors  WHERE id='".$edit_id[0]."'";
$query = $this->db->query($sql);
$data['delmsg']=$this->session->set_flashdata('delmsg','Author deleted scuccessfully ','success');
redirect('librarylogin/manageIssuedBooks','refresh');

}
	$this->load->view('library/template/libraryadmin/header');
    $this->load->view('library/libraryadmin/manage-issued-books');
    $this->load->view('library/template/libraryadmin/footer');
    }
	public function issueBooks()
	{
		if(isset($_POST['issue']))
{
$studentid=strtoupper($_POST['studentid']);
$bookid=$_POST['bookdetails'];
$sql="INSERT INTO  tblissuedbookdetails(StudentID,BookId) VALUES('".$studentid."','".$bookid."')";
$query = $this->db->query($sql);
$lastInsertId = $this->db->insert_id();
if($lastInsertId)
{
$data['msg']=$this->session->set_flashdata('success','Book Issued successfully','success');	
redirect('librarylogin/manageIssuedBooks','refresh');
}
else 
{
$data['error']=$this->session->set_flashdata('form_err','Something went wrong. Please try again','success');
redirect('librarylogin/manageIssuedBooks','refresh');
}

}
	$this->load->view('library/template/libraryadmin/header');
    $this->load->view('library/libraryadmin/issue-book');
    $this->load->view('library/template/libraryadmin/footer');
    }
	public function editIssuedBooks()
	{
		$add_date=date('Y-m-d H:i:s');
$data['rid']=$rid=$this->uri->segment(3);
$sql="SELECT erp_studentdetails.student_name_,tblbooks.BookName,tblbooks.ISBNNumber,tblissuedbookdetails.IssuesDate,tblissuedbookdetails.ReturnDate,tblissuedbookdetails.id as rid,tblissuedbookdetails.fine,tblissuedbookdetails.RetrunStatus from  tblissuedbookdetails join erp_studentdetails on erp_studentdetails.reg_no_=tblissuedbookdetails.StudentId join tblbooks on tblbooks.id=tblissuedbookdetails.BookId where tblissuedbookdetails.id='".$rid."'";
$query=$this->db->query($sql);
$data['results']=$query->result();
		if(isset($_POST['update']))
{
$fine=$_POST['fine'];
$rstatus=1;
$editid=$_POST['edit_id'];
$sql="update tblissuedbookdetails set fine='".$fine."',ReturnDate='".$add_date."',RetrunStatus='".$rstatus."' where id='".$editid."'";
$query = $this->db->query($sql);
$data['msg']=$this->session->set_flashdata('msg','Book Returned successfully','success');
redirect('librarylogin/manageIssuedBooks');

}
		if(isset($_POST['renew']))
{
$editid=$_POST['edit_id'];
$sql="update tblissuedbookdetails set IssuesDate='".date('Y-m-d H:i:s')."' where id='".$editid."'";
$query = $this->db->query($sql);
$data['msg']=$this->session->set_flashdata('msg','Book Renewed successfully','success');
redirect('librarylogin/manageIssuedBooks');

}
	$this->load->view('library/template/libraryadmin/header');
    $this->load->view('library/libraryadmin/update-issue-bookdeails',$data);
    $this->load->view('library/template/libraryadmin/footer');
    }
	public function getStudent()
	{
		$regno= strtoupper($_POST["studentid"]);
 
    $sql ="SELECT student_name_,dept_ FROM erp_studentdetails WHERE reg_no_='".$regno."'";
$query= $this->db->query($sql);
$results = $query -> result();
$cnt=1;
if($query -> num_rows() > 0)
{
foreach ($results as $result) {
$student = $result->student_name_;
$student .= "<script>$('#submit').prop('disabled',false);</script>";
}
}
 else{
  
  $student = "<span style='color:red'> Invaid Student Id. Please Enter Valid Student id .</span>";
 $student .= "<script>$('#submit').prop('disabled',true);</script>";
}
echo  $student;
	}
	public function getBook()
	{
		$bookid=$_POST["bookid"];
 
    $sql ="SELECT BookName,id FROM tblbooks WHERE (ISBNNumber='".$bookid."')";
$query= $this->db->query($sql);
$results = $query -> result();
$cnt=1;
if($query -> num_rows() > 0)
{
  foreach ($results as $result) {
$book = '<option value="'.htmlentities($result->id).'">'.$result->BookName.'</option>';
$book .= '<b>Book Name :</b>' . $result->BookName; 
$book .= "<script>$('#submit').prop('disabled',false);</script>";
}
}
 else{
  
$book = '<option class="others"> Invalid ISBN Number</option>';

 $book .= "<script>$('#submit').prop('disabled',true);</script>";
}
echo $book;
	}
	
	public function changePassword()
	{
		if(isset($_POST['change']))
  {
$password=$_POST['password'];
$newpassword=$_POST['newpassword'];
$userid=$this->session->userdata('user')['user_id'];
  $sql ="SELECT password_ FROM erp_employee_master where id='".$userid."' and password_='".$password."' and login_status_=1";
$query= $this->db->query($sql);
$results = $query -> result();
if($query -> num_rows() > 0)
{
$con="update erp_employee_master set password_='".$newpassword."' where id='".$userid."'";
$chngpwd1 = $this->db->query($con);
$data['msg']="Your Password succesfully changed";
}
else {
$data['error']="Your current password is wrong";  
}
}
	$this->load->view('library/template/libraryadmin/header');
    $this->load->view('library/libraryadmin/change-password',$data);
    $this->load->view('library/template/libraryadmin/footer');
    }
	
	public function updateSettings()
	{
$sql="SELECT * FROM tblsettings LIMIT 1";
$query=$this->db->query($sql);
$data['results']=$query->result();
		if(isset($_POST['update']))
{
	$data = array(
	'ReturnDays' => $_POST['return_days'],
	'Fine' => $_POST['fine'],
	'created_at' => date('Y-m-d H:i:s'),
	);
	$edit_id=$_POST['edit_id'];
	if($edit_id==''){
		$this->db->insert('tblsettings',$data);
	}else{
		$this->db->where('id',$edit_id);
		$this->db->update('tblsettings',$data);
	}
$data['msg']=$this->session->set_flashdata('msg','Settings updated successfully','success');
redirect('librarylogin/updateSettings');

}
	$this->load->view('library/template/libraryadmin/header');
    $this->load->view('library/libraryadmin/update-settings',$data);
    $this->load->view('library/template/libraryadmin/footer');
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
	
    $this->load->view('library/template/libraryadmin/header');
    $this->load->view('library/libraryadmin/block_hallTicket',$data);
    $this->load->view('library/template/libraryadmin/footer');	
    }
	
	public function blockHt()
	{
		

		$user_id=24;
		$add_date=date('Y-m-d H:i:s');
		
		$batch = $this->input->post('batch');
		$batch_id = $this->db->where('batch_from',$batch)->get('erp_batchmaster')->row();
		    $data['batch_id']=$batch_id->id;
		    $data['batch_year']=$batch;
			$data['type']='LIBRARY';
			$data['sem']=$sem = $this->input->post('sem');
			$data['main_id']=$stream = $this->input->post('stream');
			$data['course_id']=$department = $this->input->post('department');
			$data['student_id']=$student = $this->input->post('student');
			$data['status']= $this->input->post('status');
			$data['user_id']=$user_id;
			$data['created_at']=$add_date;
			
		$block_det = $this->db->where('type','LIBRARY')->where('batch_year',$batch)->where('sem',$sem)->where('student_id',$student)->get('erp_block_halltickets')->row();
		if(isset($block_det)){
		$data_edit['status']= $this->input->post('status');	
		$this->db->where('id',$block_det->id);
		$update = $this->db->update('erp_block_halltickets',$data_edit);
		}else{
		$insert = $this->db->insert('erp_block_halltickets',$data);
		}
 

		//print_r($data);
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
		public function getSubj()
		{
		$stream=$this->input->post('stream');
		$department=$this->input->post('department');
		$batch=$this->input->post('batch');
		
			$subj = $this->db->where('batch_year',$batch)->where('stream',$stream)->where('department',$department)->get('erp_subjectmaster')->result();	
		
		$subject = '<option value="">Select Subject</option>';
		foreach($subj as $subj){
			$subject .= '<option value="'.$subj->id.'">'.$subj->subName.'</option>';
		}
		echo $subject;
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
		->where('ann_library', $user)->get()->result();
		if (isset($_POST['submit'])) {
			$data_ann['ann_main'] = $main_course_id = $this->input->post('main_course_id');
			$data_ann['ann_course'] = $app_course_id = $this->input->post('app_course_id');
			$data_ann['ann_name'] = $this->input->post('title');
			$data_ann['ann_desc'] = $this->input->post('remark');
			$data_ann['ann_batch'] = $this->input->post('batch');
			$data_ann['ann_year'] = $this->input->post('year');
			$data_ann['ann_date_till'] = $this->input->post('date_till');
			$data_ann['ann_library'] = $user;
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
			
			$data['msg']=$this->session->set_flashdata('msg','Announcements added successfully','success');
			redirect('librarylogin/studentannouncements', 'refresh');
		}

	$this->load->view('library/template/libraryadmin/header');
    $this->load->view('library/libraryadmin/announcements',$data);
    $this->load->view('library/template/libraryadmin/footer');	
	}
	public function get_announcement()
	{
		$main_course_id = $this->input->post('main_course_id');
		$app_course_id = $this->input->post('app_course_id');
		$get_announcement = $this->db->where('main_course_id', $main_course_id)->where('app_course_id', $app_course_id)->get('announcement')->result();
		echo json_encode($get_announcement);
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

}
