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
class Alumnilogin extends CI_Controller {
	

	public $user_type;
	public function __construct()
	{
		parent::__construct();
		error_reporting(0);
	  date_default_timezone_set("Asia/Calcutta");
	  $this->load->library('upload');
	  $this->load->config('email');
		$this->load->library('email');
	    $this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('pdf');
		$this->load->library('session');
		if($this->session->userdata('user')['user_id']!=''){
			$userid=$this->session->userdata('user')['user_id'];
			$this->user_type="employee";
				}else{
			$userid=$this->session->userdata('user')['id'];	
			$this->user_type="member";	
				}
	}

	public function index()
	{
		$data['alumni_admin']=$this->db->where('login_status_',1)->where('emp_designation_',25)->get('erp_employee_master')->result();
    $this->load->view('alumni/template/header');
    $this->load->view('alumni/admin_homepage',$data);
    $this->load->view('alumni/template/footer');
    }
	public function logOut(){
		$this->session->unset_userdata('user'); 
		redirect('employee_login', 'refresh');
	}public function memberlogOut(){
		$this->session->unset_userdata('user'); 
		redirect('alumnilogin/alumniLogin', 'refresh');
	}
	public function announcement()
	{
		$data['user']='';
    $this->load->view('alumni/template/header');
    $this->load->view('alumni/announcement',$data);
    $this->load->view('alumni/template/footer');
    }
		public function announcementMember()
	{
		$data['user']='';
		$this->load->view('alumni/membertemp/header');
    $this->load->view('alumni/announcementmember',$data);
    $this->load->view('alumni/template/footer');
    }
	public function addAnnouncement()
	{
		if(isset($_POST['addann']))
{
	$annid=$_POST['aid'];
	$annname=$_POST['aname'];
	$anndesc=$_POST['adesc'];
	$anntime=date("Y-m-d h:i:sa");
	
	if ($annid=='' || $annname=='' || $anndesc=='')
	{
		$data['error']=$this->session->set_flashdata('error','Please fill all the fields','success');	
		redirect('alumnilogin/addAnnouncement','refresh');
	}
	else
	{
				$sql = "INSERT INTO alumni_announcement (ann_id, ann_name, ann_desc, ann_time) VALUES('$annid', '$annname', '$anndesc', '$anntime')";
				if ($this->db->query($sql) === TRUE) 
				{
	    			$data['msg']=$this->session->set_flashdata('msg','Announcement added successfully','success');	
                    redirect('alumnilogin/announcement','refresh');
				} 
				else 
				{
					$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                    redirect('alumnilogin/announcement','refresh');
				}
		
	}	
  }
    $this->load->view('alumni/template/header');
    $this->load->view('alumni/add_announcement');
    $this->load->view('alumni/template/footer');
    }
	public function deleteAnnouncement()
	{
		$annid = $this->uri->segment(3);
				$sql = "DELETE from alumni_announcement where ann_id = '$annid' ";
				if ($this->db->query($sql) === TRUE) 
				{
	    			$data['delete']=$this->session->set_flashdata('delete','Announcement deleted successfully','success');	
                    redirect('alumnilogin/announcement','refresh');
				} 
				else 
				{
					$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                    redirect('alumnilogin/announcement','refresh');
				}
		
	}	
    
	public function events()
	{
		$data['user']='';
    $this->load->view('alumni/template/header');
    $this->load->view('alumni/events',$data);
    $this->load->view('alumni/template/footer');
    }	public function eventsMember()
	{
		$data['user']='';
		$this->load->view('alumni/membertemp/header');
    $this->load->view('alumni/eventsMember',$data);
    $this->load->view('alumni/template/footer');
    }
	public function addEvents()
	{
		if(isset($_POST['addEvent']))
{
	$EID=$_POST['eventid'];
	$ENAME=$_POST['eventname'];
	$EDATE=$_POST['eventdate'];
	$ETIME=$_POST['eventtime'];
	$EDESC=$_POST['eventdesc'];
	$EVENUE=$_POST['eventvenue'];
	$EPIC=$_POST['epic'];
	
	if ($EID==''||$ENAME=='' || $EDATE=='' || $ETIME==''|| $EDESC=='' || $EVENUE=='' || $EPIC == '')
	{
		$data['error']=$this->session->set_flashdata('error','*****Incomplete information. No Event Created.*****','success');	
                    redirect('alumnilogin/addEvents','refresh');
	}
	else
	{
				$sql = "INSERT INTO event (e_id, e_name, e_date, e_time, e_desc, e_venue, e_pic) VALUES('$EID', '$ENAME', '$EDATE', '$ETIME', '$EDESC', '$EVENUE', '$EPIC')";
				if ($this->db->query($sql) === TRUE) 
				{
	    			$data['msg']=$this->session->set_flashdata('msg','Event created successfully','success');	
                    redirect('alumnilogin/events','refresh');
				} 
				else 
				{
    				$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                    redirect('alumnilogin/events','refresh');
				}
	
	}	
}
    $this->load->view('alumni/template/header');
    $this->load->view('alumni/add_event');
    $this->load->view('alumni/template/footer');
    }
	public function deleteEvent()
	{
		$ev_id = $this->uri->segment(3);
				$sql = "DELETE FROM event WHERE e_id = '$ev_id'";
				if ($this->db->query($sql) === TRUE) 
				{
	    			$data['delete']=$this->session->set_flashdata('delete','Event deleted successfully','success');	
                    redirect('alumnilogin/events','refresh');
				} 
				else 
				{
					$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                    redirect('alumnilogin/events','refresh');
				}
		
	}
	public function listForum()
	{
		if($this->session->userdata('user')['user_id']!=''){
	$userid=$this->session->userdata('user')['user_id'];
	$type="employee";
		}else{
	$userid=$this->session->userdata('user')['id'];	
    $type="member";	
		}
		if(isset($_POST['replypost']))
{
	$fid = $_POST['id'];
	$freply = $_POST['replymessage'];
	$ftime = date("Y/m/d h:i:sa");
	if($fid == "" || $freply=="")
	{
		echo "<script>alert('Incomplete information. No reply made. Please ensure no field is left blank.');</script>";
	}
	else
	{
					$sql3 = "SELECT eforum_title FROM forumdata WHERE eforum_id=". $fid ." ORDER BY eforum_time DESC";
					$result3 = $this->db->query($sql3);
					$row3 = $result3->result();
					foreach($row3 as $row3) 
					{
						$ftopic=$row3->eforum_title;
					}	
					$sql4 ="INSERT INTO forum_reply (forum_id, forum_topic, forum_message, forum_reply_name, forum_reply_time, forum_type)
					 VALUES ('".$fid."','".$ftopic."','".$freply."', '".$userid."', '".$ftime."', '".$type."')";
					$result4 = $this->db->query($sql4);
					if ($result4 == true) 
					{
			  			$data['msg']=$this->session->set_flashdata('msg','Replied Successfully','success');	
                    redirect('alumnilogin/listForum','refresh');
					} 
					else 
					{
				    	echo "Error: <br>" . $this->db->error;
					}
	}
}
if($type=="employee"){
		$this->load->view('alumni/template/header');
        $this->load->view('alumni/forum_list');
        $this->load->view('alumni/template/footer');
}else{
		$this->load->view('alumni/membertemp/header');
        $this->load->view('alumni/forum_list');
        $this->load->view('alumni/membertemp/footer');
}
		
	}
	public function addForum()
	{
		if($this->session->userdata('user')['user_id']!=''){
		$userid=$this->session->userdata('user')['user_id'];
		$type='employee';
			$getauthor1="SELECT id,emp_name_ as name FROM erp_employee_master WHERE id='$userid'";
		}else{
		$userid=$this->session->userdata('user')['id'];
		$type='member';	
			$getauthor1="SELECT pi_register,a_name as name FROM alumnimember WHERE pi_register='$userid'";
		}



		
		if(isset($_POST['addPost']))
{
	$ftitle=$_REQUEST['title'];
	$ftags=$_REQUEST['tags'];
	$fmessage=$_REQUEST['message'];
	date_default_timezone_set("Asia/Kolkata");
	$ftime=date("Y/m/d h:i:sa");
	if ($ftitle=='' || $ftags=='' || $fmessage=='')
	{
		$data['error']=$this->session->set_flashdata('error','*****Incomplete information. No topic created.*****','success');	
        redirect('alumnilogin/listForum','refresh');
	}
	else
	{
			$result1=$this->db->query($getauthor1);
			$row = $result1->row();
			if(isset($row))
			{
					$fauthor=$row->name;
					$authorid=$row->id;
						$sql = "INSERT INTO forumdata (eforum_author, author_id, eforum_title, eforum_content, eforum_time, eforum_tags, eforum_type) 
						VALUES('$fauthor', '$userid', '$ftitle', '$fmessage', '$ftime', '$ftags', '$type' )";
						if ($this->db->query($sql) === TRUE) 
						{
		    				$data['msg']=$this->session->set_flashdata('msg','Forum Added Successfully','success');	
                            redirect('alumnilogin/listForum','refresh');
						} 
						else 
						{
							$data['error']=$this->session->set_flashdata('error',''.$this->db->error.'','success');	
                            redirect('alumnilogin/listForum','refresh');
						}
				}
		}	
	}
if($type=='employee'){	
    $this->load->view('alumni/template/header');
    $this->load->view('alumni/add_forum_post');
    $this->load->view('alumni/template/footer');
}else{
		$this->load->view('alumni/membertemp/header');
        $this->load->view('alumni/add_forum_post');
        $this->load->view('alumni/membertemp/footer');
}
		
	}
	public function deleteForum()
	{
	$sql1="SELECT eforum_title FROM forumdata";
	$data['result']=$this->db->query($sql1)->result();
		if(isset($_POST['search']))
{
	$title=$_POST['title'];
	$sql2="SELECT * FROM forumdata WHERE eforum_title='$title'";
	$data['search']=$this->db->query($sql2)->result();
}
if(isset($_POST['delete']))
{
	$eforum_id=$_POST['forumid'];
	$sql="DELETE FROM forumdata WHERE eforum_id='$eforum_id'";
	$result3=$this->db->query($sql);
				if ($result3 === TRUE) 
				{
	    			$data['delmsg']=$this->session->set_flashdata('delmsg','Forum deleted successfully','success');	
                    redirect('alumnilogin/listForum','refresh');
				} 
				else 
				{
					$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                    redirect('alumnilogin/listForum','refresh');
				}
}
	$this->load->view('alumni/template/header');
    $this->load->view('alumni/delete_forum_post',$data);
    $this->load->view('alumni/template/footer');		
		
	}
	public function alumniRegister()
	{



	/* 	print_r($_POST);
		exit; */


		if($_POST)
{
	
	
	//print_r($_POST);
	
	$name=$_POST['pi_name'];
	$gender=$_POST['pi_gender'];
	$registration=$_POST['pi_register'];
	$department=$_POST['pi_department'];
	$branch=$_POST['pi_batch'];
	$designation=$_POST['pi_designation'];
	$email=$_POST['pi_email'];
	$mobile=$_POST['pi_mobile'];
	$password=$_POST['pi_password'];
	$al_status="Not Approve";
	$r = $this->db->select("pi_register")->from("alumnimember")->where("pi_register",$registration)->get()->num_rows();
	
	if($r > 0){

		
	echo'<h4 style="Color:red;">Your Register Number is Already Registered </h4>';

	}else{


$data = array(
	"a_name"=>$name,
	"pi_register"=>$registration,
	"gender"=>$gender,
	"batch"=>$branch,
	"department"=>$department,
	"current_position"=>$designation,
	"e_mail_id"=>$email,
	"mobile_number"=>$mobile,
	"al_password"=>$password,
	"al_status"=>$al_status,
);


 $this->db->insert("alumnimember",$data);
$id = $this->db->insert_id();

if($id != 0 || $id != ""|| $id != NULL  ){

	$this->session->set_flashdata('item','<h1 style="Color:white;">Register Successfully Please Wait for approval </h1>');

	echo "1";


}else{


	echo "<h4>Please Try Later</h4>";

} 

}
	
	/* $name=$_POST['pi_name'];
	$gender=$_POST['pi_gender'];
	$registration=$_POST['pi_register'];
	$branch=$_POST['pi_branch'];
	$sessiona=$_POST['pi_session'];
	$email=$_POST['pi_email'];
	$mobile=$_POST['pi_mobile'];
	$password=$_POST['pi_password'];
	
	
	if ($name=='' || $gender=='' || $registration==""|| $branch=='' || $sessiona=="" || $password=="")
	{
		echo "<br><br>";
		echo "<span style='color:black;'>Incomplete information. Please try again.</span>";
		echo "<br/><br/>"; 
		echo "<span style='color:black;'>Redirecting you back to main page in 10 seconds.</span>";
		echo "<br/><br/>"; 
		echo "<span style='color:black;'>Or click </span><a href=index.php>here.</a>";
		header("refresh:10;url=alumniLogin" );
	}
	else
	{
		$al_status="Not Approve";
		$register_sql = "INSERT INTO alumnimember (pi_register, al_password, al_status) 
		VALUES ('$registration', '$password', '$al_status')";

		if ($this->db->query($register_sql) === TRUE) 
		{
			$register_sql = "INSERT INTO alumniinfo (pi_name,pi_gender,pi_register,pi_branch,pi_session,pi_email,pi_mobile) 
			VALUES ('$name', '$gender', '$registration','$branch', '$sessiona','$email', '$mobile')";
			$this->db->query($register_sql);
	    	echo "<br><br>";
			echo "<span style='color:black;'>Registration successful. </span>";
			echo "<br/><br/>"; 
			echo "<span style='color:black;'>Redirecting you to login page in 5 seconds.</span>";
			echo "<br/><br/>"; 
			echo "<span style='color:black;'>Or click </span><a href=login.html>here.</a>";
			header("refresh:5;url=alumniLogin" );
		} 
		else 
		{
    		echo "Error: " . $register_sql . "<br>" . $this->db->error;
			header("refresh:10;url=alumniRegister" );
		}
	} */
}else{
	$this->load->view('alumni/register');

}
       
		
	}
	public function alumniLogin()
	{
		if(isset($_POST['login'])){
			$luserid = $this->input->post('login_userid');
			$lpassword = $this->input->post('login_password');
		$al_result="SELECT * from alumnimember where 
		pi_register='$luserid' AND al_password='$lpassword'";
		$al_count=$this->db->query($al_result);
		$al_result1="SELECT * FROM alumnimember 
		WHERE alumnimember.pi_register ='$luserid'";
		$al_count1=$this->db->query($al_result1);
		$al_row = $al_count->row();
		$al_row1 = $al_count1->row();
		if (isset($al_row)) 
		{
				$al_status=$al_row->al_status;
				if($al_status=="Not Approve")
				{
					echo "<br /><br /><span style='color:black;'>Login failed. <br /><br />Please contact our administrator to check your registration status.</span><br /><br />";
					header("refresh:3;url=alumniIndex");
				}
				else
				{
					if (isset($al_row1))
					{
							$session_data=array(
							 'id'=>$al_row1->pi_register,
							 'alname'=>$al_row1->a_name,
							);
							$this->session->set_userdata('user', $session_data);
							header("location:alumniHome");
					}
   				}
			}
		else
			{
				$al_message="<span style='color:black;'>Sorry Invalid Password or UserID. Please Try Again.</span>";
				echo $al_message; 
				header("refresh:5;url=alumniLogin");
			}
	}
        $this->load->view('alumni/login');
		
	}
	public function alumniIndex()
	{
        $this->load->view('alumni/setting/index_navigation');
        $this->load->view('alumni/index');
		
	}
	public function searchAlumni()
	{
		$resultAWA =[];
		if($this->session->userdata('user')['user_id']!=''){
	$userid=$this->session->userdata('user')['user_id'];
	$type="employee";
		}else{
	$userid=$this->session->userdata('user')['id'];	
    $type="member";	
		}
		$data['resultAWA']=[];
if(isset($_POST['search']))
{
	$name=$_POST['pid'];
    $regis=$_POST['aid'];
  
  
 $this->db->select('*');	
	if($name!='')
{ $this->db->where('alumnimember.a_name',$name);}
if($regis!='')
{$this->db->where('alumnimember.pi_register',$regis);}

	$this->db->from('alumnimember');

	  $sqlshowAWA= $this->db->get();
	  $data['resultAWA']=$sqlshowAWA->result();


}
if($type=="employee"){
		$this->load->view('alumni/template/header');
        $this->load->view('alumni/search_alumni2',$data);
        $this->load->view('alumni/template/footer');
}else{
//$this->load->view('alumni/membertemp/header');
$this->load->view('alumni/membertemp/header');
$this->load->view('alumni/search_alumni2',$data);
$this->load->view('alumni/membertemp/footer');
}		
	
	}
	public function financialRecord()
	{
	$sqlshow2= "SELECT financialdata.payment_id, alumnimember.a_name, financialdata.payment_purpose, financialdata.payment_date, financialdata.total_payment FROM alumnimember, financialdata
			WHERE alumnimember.pi_register = financialdata.pi_register";
    $data['resultfin'] = $this->db->query($sqlshow2)->result();
	$this->load->view('alumni/template/header');
    $this->load->view('alumni/Financial_Record',$data);
    $this->load->view('alumni/template/footer');		
		
	}
	public function newPayment()
	{
	if(isset($_POST['addpayment']))
{
	$paymentid=$_POST['pid'];
	$paymentpurpose=$_POST['pp'];
	$paymentdate=$_POST['pd'];
	$paymentpaid=$_POST['pa'];
	$alid=$_POST['aid'];
	
	if ($paymentid=='' || $paymentpurpose=='' || $paymentdate==''|| $paymentpaid=='' || $alid=='')
	{
		$data['error']=$this->session->set_flashdata('error','*****Incomplete information. No payment done.*****','success');	
        redirect('alumnilogin/financialRecord','refresh');
	}
	else
	{
		$sql1 = "INSERT INTO financialdata (payment_id, total_payment, payment_purpose, payment_date, pi_register) VALUES('$paymentid', '$paymentpaid', '$paymentpurpose', '$paymentdate', '$alid')";

		if ($this->db->query($sql1) === TRUE) 
		{
			$data['msg']=$this->session->set_flashdata('msg','*****Payment successfully done.*****','success');	
            redirect('alumnilogin/financialRecord','refresh');
			} 
		else 
			{
				$data['error']=$this->session->set_flashdata('error',''.$this->db->error.'','success');	
                redirect('alumnilogin/financialRecord','refresh');
			}
		
	}	
}
	$this->load->view('alumni/template/header');
    $this->load->view('alumni/NewPayment');
    $this->load->view('alumni/template/footer');		
		
	}
	public function manageAlumni()
	{
	$sqlshow1 = $this->db->select("*")->from("alumnimember")->get();
    $data['result1'] = $sqlshow1->result();
	$this->load->view('alumni/template/header');
    $this->load->view('alumni/manage_alumni',$data);
    $this->load->view('alumni/template/footer');		
		
	}
	public function approve()
	{
	$sqlshowAWA= "SELECT * FROM alumnimember WHERE  alumnimember.al_status = 'Not Approve'";
    $data['resultAWA'] = $this->db->query($sqlshowAWA)->result();
	if(isset($_POST['approve']))
{
	$alid=$_REQUEST['aluid'];
	
	if ($alid=='')
	{
		$data['error']=$this->session->set_flashdata('error','*****Please insert Alumni Registration Number for membership approval.*****','success');	
        redirect('alumnilogin/approve','refresh');
	}
	else
	{
				$sql = "UPDATE alumnimember SET al_status= 'Approve' WHERE pi_register = '$alid'";
				if ($this->db->query($sql) === TRUE) 
				{
					$data['msg']=$this->session->set_flashdata('msg','*****Approval successfull.*****','success');	
                    redirect('alumnilogin/approve','refresh');
				} 
				else 
				{
    				$data['error']=$this->session->set_flashdata('error',''.$this->db->error.'','success');	
                    redirect('alumnilogin/approve','refresh');
				}
	}	
}
	$this->load->view('alumni/template/header');
    $this->load->view('alumni/approve',$data);
    $this->load->view('alumni/template/footer');		
		
	}
	
	public function alumniHome()
	{
	$userid = $this->session->userdata('user')['id'];
$sql="SELECT * FROM alumnimember WHERE pi_register='$userid'";
$result=$this->db->query($sql);
$data['row'] = $result->result_array();
    $this->load->view('alumni/membertemp/header');
    $this->load->view('alumni/alumni_home',$data);
    $this->load->view('alumni/membertemp/footer');
    }
	public function do_upload_mem(){

    	$config = array();
		$config['upload_path'] = 'system/images/alumnimember/';
		$config['allowed_types'] = '*';
		$config['remove_spaces'] = TRUE;
		$config['overwrite'] = TRUE;
		return $config;
		
        }
	public function updateMemberProfile()
	{
	$data['userid'] = $userid = $this->session->userdata('user')['id'];
	$data['profile'] = $this->db->where('pi_register',$userid)->get('alumnimember')->row();
		if(isset($_POST['update'])){




	$address=$_POST['address'];
	$name=$_POST['name'];
	$gender=$_POST['pi_gender'];
	
	$department=$_POST['pi_department'];
	$branch=$_POST['pi_batch'];
	$designation=$_POST['comp'];
	$email=$_POST['email'];
	$mobile=$_POST['contact'];

	
	if( $address=="" && $name=="" && $gender==""&& $department=="" && $branch=="" && $designation=="" && $email==""  && $mobile=="" && $_FILES['PROFILE']['size'] == 0)
	{
		echo "<script>alert('Empty field. No update made.')</script>";	
		redirect('alumnilogin/alumniHome','refresh');	
	}
	else
	{
		$data = array(
			"a_name"=>$name,
			"gender"=>$gender,
			"batch"=>$branch,
			"department"=>$department,
			"current_position"=>$designation,
			"e_mail_id"=>$email,
			"mobile_number"=>$mobile,
			"address"=>$address,
			);
		
		
		 $this->db->where("pi_register",$userid=$this->session->userdata('user')['id']);
		 $this->db->update("alumnimember",$data);
		// echo "<script>alert('Update Success.')</script>";
		redirect('alumnilogin/alumniHome','refresh');
		
	}
	if($_FILES['PROFILE']['size'] != 0) {
			$file_ext = pathinfo($_FILES["PROFILE"]["name"], PATHINFO_EXTENSION);
			$NewImageName = $userid.'.'.$file_ext;
			
			$_FILES["file"]["name"] = $NewImageName;
			$_FILES["file"]["type"] = $_FILES["PROFILE"]["type"];
			$_FILES["file"]["tmp_name"] = $_FILES["PROFILE"]["tmp_name"];
			$_FILES["file"]["error"] = $_FILES["PROFILE"]["error"];
			$_FILES["file"]["size"] = $_FILES["PROFILE"]["size"];

			$config = $this->do_upload_mem();
			$this->upload->initialize($config);
			if($this->upload->do_upload('file'))
			{
			 $ffff = $this->upload->data();
			  $image=$ffff['file_name'];
			  
			  $data_up['pi_picture'] = 'system/images/alumnimember/'.$NewImageName;
			  }
	$this->db->where('pi_register',$userid);
	$this->db->update('alumnimember',$data_up);
	//echo "<script>alert('Update Success.')</script>";
		redirect('alumnilogin/alumniHome','refresh');
	 }	
		/* if($result1==true || $result2==true || $result3==true || $result4==true || $result5==true || 
		$result6==true || $result7==true || $result8==true)
		{
			echo "<script>alert('Update Success.')</script>";
		redirect('alumnilogin/alumniHome','refresh');
		}
		else
		{
			echo "Fail";	
		} */
		//echo "<script>alert('Update Success.')</script>";
		redirect('alumnilogin/alumniHome','refresh');
		}
	$this->load->view('alumni/membertemp/header');
    $this->load->view('alumni/update_profile',$data);
    $this->load->view('alumni/membertemp/footer');
    }
	
	public function postReply()
	{
		
		$data['userid']=$userid=$this->session->userdata('user')['id'];
		if(isset($_POST['posts']))
{
	$result_p =  "<p class=pp1>My Posts:</p>";
	$result_p .= "<table class=ptb1 cellspacing=15 align=center>";
	$sql="SELECT a_name FROM alumnimember WHERE pi_register='$userid'";
	$result=$this->db->query($sql);
	if ($result->num_rows() > 0) 
	{
		$row = $result->result_array();
		foreach($row as $row)
		{
			$fullname=$row['pi_name'];
			$sql2="SELECT * FROM forumdata WHERE author_id='$userid'";
			$result2=$this->db->query($sql2);
			$row = $result2->result_array();
			foreach($row as $row )
			{
				$result_p .=  "<tr>";
			  	$result_p .=  "<td class=ptd1><span class=psp1>".$row['eforum_title']."</span><br><br><span class=psp2>
				".$row['eforum_content']."</span><br><br><span class=psp3>Tags: ".$row['eforum_tags']." | Time: ".$row['eforum_time']."</span></td>";
			  	$result_p .=  "</tr>";
			}
		}
	}
	else
	{
		$result_p .=  "<p>No post yet. Join e-forum now!</p>";	
		$result_p .=  $userid;
	}
	$result_p .=  "</table>";
	$result_p .=  "<p class=pp1>Replies to My Post:</p>";
	$result_p .=  "<table class=ptb1 cellspacing=15 align=center>";
	$sql="SELECT eforum_id,eforum_title FROM forumdata WHERE author_id='$userid'";
	$result=$this->db->query($sql);
	if ($result->num_rows() > 0) 
	{
		$row=$result->result_array();
		foreach($row as $row)
		{
			$forum_id=$row['eforum_id'];
			$sql2="SELECT * FROM forum_reply WHERE forum_id='$forum_id'";
			$result2=$this->db->query($sql2);
			$row=$result2->result_array();
			foreach($row as $row)
			{
				if($row['forum_type']=='employee'){
					$name1=$this->db->where('id',$row['forum_reply_name'])->get('erp_employee_master')->row();
					$name=$name1->emp_name_;
				}else{
					$name1=$this->db->where('pi_register',$row['forum_reply_name'])->get('alumnimember')->row();
					$name=$name1->pi_name;
				}
				$result_p .=  "<tr>";
			  	$result_p .=  "<td class=ptd1><span class=psp1>".$row['forum_topic']."</span><br><br><span class=psp2>
				".$row['forum_message']."</span><br><br><span class=psp3>Sender: ".$name." | Time: ".$row['forum_reply_time']."</span></td>";
			  	$result_p .=  "</tr>";
			}
		}
	}
	else
	{
		$result_p .=  "<p>No post yet. Join e-forum now!</p>";	
		$result_p .=  $userid;
	}
	$result_p .=  "</table>";
	$data['post'] = $result_p;
}
if(isset($_POST['replies']))
{
	$result_r = "<p class=pp1>My Replies:</p>";
	$result_r .= "<table class=ptb1 cellspacing=15 align=center>";
	$sql3="SELECT a_name FROM alumnimember WHERE pi_register='$userid'";
	$result3=$this->db->query($sql3);
	if ($result3->num_rows() > 0) 
	{
		$row=$result3->result_array();
		foreach($row as $row)
		{
			$fullname=$row['pi_name'];
			$sql4="SELECT * FROM forum_reply WHERE forum_reply_name='$userid'";
			$result4=$this->db->query($sql4);
			$row=$result4->result_array();
			foreach($row as $row)
			{
				$result_r .= "<tr>";
			  	$result_r .= "<td class=ptd1><span class=psp1>Topic: ".$row['forum_topic']."</span><br><span class=psp2>Reply:
				".$row['forum_message']."</span><br><br><span class=psp3>Date & Time: ".$row['forum_reply_time']."</span></td>";
			  	$result_r .= "</tr>";
			}
		}
	}
	else
	{
		$result_r .= "<p>No post yet. Join e-forum now!</p>";	
		$result_r .= $userid;
	}
	$result_r .= "</table>";
	$data['reply'] = $result_r;
}
		$this->load->view('alumni/membertemp/header');
        $this->load->view('alumni/alumni_mypostreply',$data);
        $this->load->view('alumni/membertemp/footer');
		
	}
	public function alumniFinancial()
	{
	$userid = $this->session->userdata('user')['id'];
$sql="SELECT * FROM financialdata where pi_register='$userid'";
	$result=$this->db->query($sql);
	$sort = "<tr>";
	$sort .= "<th>Payment ID</th>";
	$sort .= "<th>Payment Purpose</th>";
	$sort .= "<th>Total Payment</th>";
	$sort .= "<th>Payment Date</th>";
	$sort .= "</tr>";
	if(isset($_POST['sort']))
	{
		$sql="SELECT * FROM financialdata where pi_register='$userid' ORDER BY payment_purpose ASC";
		$result=$this->db->query($sql);
		$row = $result->result_array();
		foreach($row as $row)
		{
			$sort .= "<tr>";
			$sort .= "<td class=alumnifinancialtd>".$row['payment_id']."</td>";
			$sort .= "<td class=alumnifinancialtd>".$row['payment_purpose']."</td>";
			$sort .= "<td class=alumnifinancialtd>".$row['total_payment']."</td>";
			$sort .= "<td class=alumnifinancialtd>".$row['payment_date']."</td>";
			$sort .= "</tr>";
		}
		$data['sort'] = $sort;
	}
	else if(isset($_POST['unsort']))
	{
		$row = $result->result_array();
		foreach($row as $row)
		{
			$sort .= "<tr>";
			$sort .= "<td class=alumnifinancialtd>".$row['payment_id']."</td>";
			$sort .= "<td class=alumnifinancialtd>".$row['payment_purpose']."</td>";
			$sort .= "<td class=alumnifinancialtd>".$row['total_payment']."</td>";
			$sort .= "<td class=alumnifinancialtd>".$row['payment_date']."</td>";
			$sort .= "</tr>";
		}
		$data['sort'] = $sort;
	}
	else
	{
		$row = $result->result_array();
		foreach($row as $row)
		{
			$sort .= "<tr>";
			$sort .= "<td class=alumnifinancialtd>".$row['payment_id']."</td>";
			$sort .= "<td class=alumnifinancialtd>".$row['payment_purpose']."</td>";
			$sort .= "<td class=alumnifinancialtd>".$row['total_payment']."</td>";
			$sort .= "<td class=alumnifinancialtd>".$row['payment_date']."</td>";
			$sort .= "</tr>";
		}
		$data['sort'] = $sort;
	}
    $this->load->view('alumni/membertemp/header');
    $this->load->view('alumni/alumni_financial',$data);
    $this->load->view('alumni/membertemp/footer');
    }
}
