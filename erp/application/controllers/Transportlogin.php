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
class Transportlogin extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	//  error_reporting(0);
	  date_default_timezone_set("Asia/Calcutta");
	  $this->load->library('upload');
	  $this->load->config('email');
		$this->load->library('email');
	    $this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('pdf');
		$this->load->library('session');
	
	}

	public function index()
	{
		$data['user']='';
    $this->load->view('transport/template/header');
    $this->load->view('transport/homepage',$data);
    $this->load->view('transport/template/footer');
    }
	public function logOut(){
		$this->session->unset_userdata('user'); 
		redirect('employee_login', 'refresh');
	}
	public function bus()
	{
		$data['user']='';
    $this->load->view('transport/template/header');
    $this->load->view('transport/bus',$data);
    $this->load->view('transport/template/footer');
    }
	public function addBus()
	{
		$row=$this->db->limit(1)->order_by('id','desc')->get('bus')->row();
		if(isset($row)){
		    $value2 = $row->BUS_ID;
            $value2 = substr($value2, 3, 13);//separating numeric part
            $value2 = $value2 + 1;//Incrementing numeric part
            $value2 = "BUS" . sprintf('%03s', $value2);//concatenating incremented value
            $data['BUS_ID'] = $value2; 
		}else{
			$data['BUS_ID'] = 'BUS001'; 
		}
		$add_date=date('Y-m-d H:i:s');
		$data['list_driver']=$this->db->get('driver')->result();
		if(isset($_POST['submit'])){
			$bid= $_POST['BUS_ID'];
			$bname= $_POST['BUS_NAME'];
			$btype= $_POST['BUS_TYPE'];
			$did= $_POST['DRIVER_ID'];
		$dup_driv=$this->db->where('DRIVER_ID',$did)->get('bus')->result();	
		if(sizeof($dup_driv)==0){
			$query = "INSERT INTO bus (BUS_ID,BUS_NAME, BUS_TYPE, DRIVER_ID, created_at) VALUES ('".$bid."','".$bname."','".$btype."','".$did."','".$add_date."')";
			$this->db->query($query);
			$this->session->set_flashdata('success','Bus Added Successfully!','success');
			redirect('transportlogin/bus','refresh');
		}else{
			echo '<script>alert("Driver Already Assigned!");</script>';
			redirect('transportlogin/bus','refresh');
		}
		}
    $this->load->view('transport/template/header');
    $this->load->view('transport/busadd',$data);
    $this->load->view('transport/template/footer');
    }
	public function editBus()
	{
		$data['list_driver']=$this->db->get('driver')->result();
		$query = 'SELECT * FROM bus WHERE id ='.$_GET['id'];
            $result = $this->db->query($query);
			$row = $result->result_array();
              foreach($row as $row)
              {   
                $data['zz']= $row['BUS_ID'];
                $data['i']= $row['BUS_NAME'];
                $data['a']=$row['BUS_TYPE'];
                $data['b']=$row['DRIVER_ID'];
              }
              
              $data['id'] = $_GET['id'];
		if(isset($_POST['submit'])){
			$edit_id = $_POST['id'];
			$bname = $_POST['BUS_NAME'];
		    $btype = $_POST['BUS_TYPE'];
			$did= $_POST['DRIVER_ID'];
			
		$dup_driv=$this->db->where('DRIVER_ID',$did)->where('id!="'.$edit_id.'"')->get('bus')->result();	
		if(sizeof($dup_driv)==0){
	 			$query = 'UPDATE bus set BUS_NAME ="'.$bname.'",
					BUS_TYPE ="'.$btype.'", DRIVER_ID="'.$did.'" WHERE
					id ="'.$edit_id.'"';
			$this->db->query($query);
			$this->session->set_flashdata('success','Bus Updated Successfully!','success');
			redirect('transportlogin/bus','refresh');
		}else{
			echo '<script>alert("Driver Already Assigned!");</script>';
			redirect('transportlogin/bus','refresh');
		}
		}
    $this->load->view('transport/template/header');
    $this->load->view('transport/busedit',$data);
    $this->load->view('transport/template/footer');
    }
	public function deleteBus()
	{
              $id = $_GET['id'];
			  $query = 'DELETE FROM bus
			  WHERE
			  id = ' . $id;
			$this->db->query($query);
			$this->session->set_flashdata('success','Bus Deleted Successfully!','success');
			redirect('transportlogin/bus','refresh');
    }
	
	public function do_upload_dri(){

    	$config = array();
		$config['upload_path'] = 'system/images/driver/';
		$config['allowed_types'] = '*';
		$config['remove_spaces'] = TRUE;
		$config['overwrite'] = TRUE;
		return $config;
		
        }
	public function driver()
	{
		$data['user']='';
    $this->load->view('transport/template/header');
    $this->load->view('transport/driver',$data);
    $this->load->view('transport/template/footer');
    }
	public function addDriver()
	{
		$row=$this->db->limit(1)->order_by('id','desc')->get('driver')->row();
		if(isset($row)){
		    $value2 = $row->DRIVER_ID;
            $value2 = substr($value2, 6, 13);//separating numeric part
            $value2 = $value2 + 1;//Incrementing numeric part
            $value2 = "DRIVER" . sprintf('%03s', $value2);//concatenating incremented value
            $data['DRIVER_ID'] = $value2; 
		}else{
			$data['DRIVER_ID'] = 'DRIVER001'; 
		}
		$add_date=date('Y-m-d H:i:s');
		$data['user']='';
		if(isset($_POST['submit'])){
			$did= $_POST['DRIVER_ID'];
			$dname= $_POST['DRIVER_NAME'];
			$edate1= $_POST['EMPLOY_DATE'];
			$edate = date('Y-m-d',strtotime($edate1));
			$dob1= $_POST['DOB'];
			$dob = date('Y-m-d',strtotime($dob1));
			$mobile= $_POST['MOBILE'];
			$email= $_POST['EMAIL'];
			$address= $_POST['ADDRESS'];
			$city= $_POST['CITY'];
			$state= $_POST['STATE'];
			$country= $_POST['COUNTRY'];
			$data_in = array(
			 'DRIVER_ID' => $did,
			 'DRIVER_NAME' => $dname,
			 'EMPLOY_DATE' => $edate,
			 'DRIVER_DOB' => $dob,
			 'DRIVER_MOBILE' => $mobile,
			 'DRIVER_EMAIL' => $email,
			 'DRIVER_ADDRESS' => $address,
			 'DRIVER_CITY' => $city,
			 'DRIVER_STATE' => $state,
			 'DRIVER_COUNTRY' => $country,
			 'created_at' => $add_date,
			);
			if($_FILES['PROFILE']['size'] != 0) {
			$file_ext = pathinfo($_FILES["PROFILE"]["name"], PATHINFO_EXTENSION);
			$NewImageName = $did.'.'.$file_ext;
			
			$_FILES["file"]["name"] = $NewImageName;
			$_FILES["file"]["type"] = $_FILES["PROFILE"]["type"];
			$_FILES["file"]["tmp_name"] = $_FILES["PROFILE"]["tmp_name"];
			$_FILES["file"]["error"] = $_FILES["PROFILE"]["error"];
			$_FILES["file"]["size"] = $_FILES["PROFILE"]["size"];

			$config = $this->do_upload_dri();
			$this->upload->initialize($config);
			if($this->upload->do_upload('file'))
			{
			 $ffff = $this->upload->data();
			  $image=$ffff['file_name'];
			  
			  $data_in['DRIVER_PROFILE'] = 'system/images/driver/'.$NewImageName;
			  }
	 }
	 if($_FILES['ADD_PROOF']['size'] != 0) {
			$file_ext = pathinfo($_FILES["ADD_PROOF"]["name"], PATHINFO_EXTENSION);
			$NewImageDoc = 'ADDR_'.$did.'.'.$file_ext;
			
			$_FILES["file"]["name"] = $NewImageDoc;
			$_FILES["file"]["type"] = $_FILES["ADD_PROOF"]["type"];
			$_FILES["file"]["tmp_name"] = $_FILES["ADD_PROOF"]["tmp_name"];
			$_FILES["file"]["error"] = $_FILES["ADD_PROOF"]["error"];
			$_FILES["file"]["size"] = $_FILES["ADD_PROOF"]["size"];

			$config = $this->do_upload_dri();
			$this->upload->initialize($config);
			if($this->upload->do_upload('file'))
			{
			 $ffff = $this->upload->data();
			  $image=$ffff['file_name'];
			  
			  $data_in['DRIVER_ADD_PROOF'] = 'system/images/driver/'.$NewImageDoc;
			  }
	 }
	 if($_FILES['LICENSE']['size'] != 0) {
			$file_ext = pathinfo($_FILES["LICENSE"]["name"], PATHINFO_EXTENSION);
			$NewImageDoc = 'LIC_'.$did.'.'.$file_ext;
			
			$_FILES["file"]["name"] = $NewImageDoc;
			$_FILES["file"]["type"] = $_FILES["LICENSE"]["type"];
			$_FILES["file"]["tmp_name"] = $_FILES["LICENSE"]["tmp_name"];
			$_FILES["file"]["error"] = $_FILES["LICENSE"]["error"];
			$_FILES["file"]["size"] = $_FILES["LICENSE"]["size"];

			$config = $this->do_upload_dri();
			$this->upload->initialize($config);
			if($this->upload->do_upload('file'))
			{
			 $ffff = $this->upload->data();
			  $image=$ffff['file_name'];
			  
			  $data_in['DRIVER_LICENSE'] = 'system/images/driver/'.$NewImageDoc;
			  }
	 }
			$this->db->insert('driver',$data_in);
			$this->session->set_flashdata('success','Driver Added Successfully!','success');
			redirect('transportlogin/driver','refresh');
		}
    $this->load->view('transport/template/header');
    $this->load->view('transport/driveradd',$data);
    $this->load->view('transport/template/footer');
    }
	public function editDriver()
	{
		$query = 'SELECT * FROM driver WHERE id ='.$_GET['id'];
            $result = $this->db->query($query);
			$row = $result->result_array();
              foreach($row as $row)
              {   
                $data['DRIVER_ID']= $row['DRIVER_ID'];
                $data['DRIVER_NAME']= $row['DRIVER_NAME'];
                $data['EMPLOY_DATE']=date('m/d/Y',strtotime($row['EMPLOY_DATE']));
				$data['DRIVER_DOB']=date('m/d/Y',strtotime($row['DRIVER_DOB']));
				$data['DRIVER_MOBILE']= $row['DRIVER_MOBILE'];
				$data['DRIVER_EMAIL']= $row['DRIVER_EMAIL'];
				$data['DRIVER_ADDRESS']= $row['DRIVER_ADDRESS'];
				$data['DRIVER_CITY']= $row['DRIVER_CITY'];
				$data['DRIVER_STATE']= $row['DRIVER_STATE'];
				$data['DRIVER_COUNTRY']= $row['DRIVER_COUNTRY'];
              }
              
              $data['id'] = $_GET['id'];
		if(isset($_POST['submit'])){
			$edit_id = $_POST['id'];
			$did= $_POST['DRIVER_ID'];
			$dname= $_POST['DRIVER_NAME'];
			$edate1= $_POST['EMPLOY_DATE'];
			$edate = date('Y-m-d',strtotime($edate1));
			$dob1= $_POST['DOB'];
			$dob = date('Y-m-d',strtotime($dob1));
			$mobile= $_POST['MOBILE'];
			$email= $_POST['EMAIL'];
			$address= $_POST['ADDRESS'];
			$city= $_POST['CITY'];
			$state= $_POST['STATE'];
			$country= $_POST['COUNTRY'];
			$data_up = array(
			 'DRIVER_NAME' => $dname,
			 'EMPLOY_DATE' => $edate,
			 'DRIVER_DOB' => $dob,
			 'DRIVER_MOBILE' => $mobile,
			 'DRIVER_EMAIL' => $email,
			 'DRIVER_ADDRESS' => $address,
			 'DRIVER_CITY' => $city,
			 'DRIVER_STATE' => $state,
			 'DRIVER_COUNTRY' => $country,
			 'created_at' => $add_date,
			);
			if($_FILES['PROFILE']['size'] != 0) {
			$file_ext = pathinfo($_FILES["PROFILE"]["name"], PATHINFO_EXTENSION);
			$NewImageName = $did.'.'.$file_ext;
			
			$_FILES["file"]["name"] = $NewImageName;
			$_FILES["file"]["type"] = $_FILES["PROFILE"]["type"];
			$_FILES["file"]["tmp_name"] = $_FILES["PROFILE"]["tmp_name"];
			$_FILES["file"]["error"] = $_FILES["PROFILE"]["error"];
			$_FILES["file"]["size"] = $_FILES["PROFILE"]["size"];

			$config = $this->do_upload_dri();
			$this->upload->initialize($config);
			if($this->upload->do_upload('file'))
			{
			 $ffff = $this->upload->data();
			  $image=$ffff['file_name'];
			  
			  $data_up['DRIVER_PROFILE'] = 'system/images/driver/'.$NewImageName;
			  }
	 }
	 if($_FILES['ADD_PROOF']['size'] != 0) {
			$file_ext = pathinfo($_FILES["ADD_PROOF"]["name"], PATHINFO_EXTENSION);
			$NewImageDoc = 'ADDR_'.$did.'.'.$file_ext;
			
			$_FILES["file"]["name"] = $NewImageDoc;
			$_FILES["file"]["type"] = $_FILES["ADD_PROOF"]["type"];
			$_FILES["file"]["tmp_name"] = $_FILES["ADD_PROOF"]["tmp_name"];
			$_FILES["file"]["error"] = $_FILES["ADD_PROOF"]["error"];
			$_FILES["file"]["size"] = $_FILES["ADD_PROOF"]["size"];

			$config = $this->do_upload_dri();
			$this->upload->initialize($config);
			if($this->upload->do_upload('file'))
			{
			 $ffff = $this->upload->data();
			  $image=$ffff['file_name'];
			  
			  $data_up['DRIVER_ADD_PROOF'] = 'system/images/driver/'.$NewImageDoc;
			  }
	 }
	 if($_FILES['LICENSE']['size'] != 0) {
			$file_ext = pathinfo($_FILES["LICENSE"]["name"], PATHINFO_EXTENSION);
			$NewImageDoc = 'LIC_'.$did.'.'.$file_ext;
			
			$_FILES["file"]["name"] = $NewImageDoc;
			$_FILES["file"]["type"] = $_FILES["LICENSE"]["type"];
			$_FILES["file"]["tmp_name"] = $_FILES["LICENSE"]["tmp_name"];
			$_FILES["file"]["error"] = $_FILES["LICENSE"]["error"];
			$_FILES["file"]["size"] = $_FILES["LICENSE"]["size"];

			$config = $this->do_upload_dri();
			$this->upload->initialize($config);
			if($this->upload->do_upload('file'))
			{
			 $ffff = $this->upload->data();
			  $image=$ffff['file_name'];
			  
			  $data_up['DRIVER_LICENSE'] = 'system/images/driver/'.$NewImageDoc;
			  }
	 }
	        $this->db->where('id',$edit_id);
			$this->db->update('driver',$data_up);
			$this->session->set_flashdata('success','Driver Updated Successfully!','success');
			redirect('transportlogin/driver','refresh');
		}
    $this->load->view('transport/template/header');
    $this->load->view('transport/driveredit',$data);
    $this->load->view('transport/template/footer');
    }
	public function deleteDriver()
	{
              $id = $_GET['id'];
			  $query = 'DELETE FROM driver
			  WHERE
			  id = ' . $id;
			$this->db->query($query);
			$this->session->set_flashdata('success','Driver Deleted Successfully!','success');
			redirect('transportlogin/driver','refresh');
    }
	
	public function route()
	{
		$data['user']='';
    $this->load->view('transport/template/header');
    $this->load->view('transport/route',$data);
    $this->load->view('transport/template/footer');
    }
	public function addRoute()
	{
		$row=$this->db->limit(1)->order_by('id','desc')->get('route')->row();
		if(isset($row)){
		    $value2 = $row->ROUTE_ID;
            $value2 = substr($value2, 5, 13);//separating numeric part
            $value2 = $value2 + 1;//Incrementing numeric part
            $value2 = "ROUTE" . sprintf('%03s', $value2);//concatenating incremented value
            $data['ROUTE_ID'] = $value2; 
		}else{
			$data['ROUTE_ID'] = 'ROUTE001'; 
		}
		$add_date=date('Y-m-d H:i:s');
		$data['user']='';
		if(isset($_POST['submit'])){
			            $rid= $_POST['ROUTE_ID'];
						$fr= $_POST['FAIR'];
						$str= $_POST['START'];
						$fsh= $_POST['FINISH'];
			$query = "INSERT INTO route
								(ROUTE_ID,FAIR,START,FINISH,created_at)
								VALUES ('".$rid."','".$fr."','".$str."','".$fsh."','".$add_date."')";
			$this->db->query($query);
			$this->session->set_flashdata('success','Route Added Successfully!','success');
			redirect('transportlogin/route','refresh');
		}
    $this->load->view('transport/template/header');
    $this->load->view('transport/routeadd',$data);
    $this->load->view('transport/template/footer');
    }
	public function editRoute()
	{
		$query = 'SELECT * FROM route WHERE id ='.$_GET['id'];
            $result = $this->db->query($query);
			$row = $result->result_array();
              foreach($row as $row)
              {   
                $data['zz']= $row['ROUTE_ID'];
                $data['i']= $row['FAIR'];
                $data['a']= $row['START'];
                $data['b']= $row['FINISH'];
              }
              
              $data['id'] = $_GET['id'];
		if(isset($_POST['submit'])){
			$edit_id = $_POST['id'];
			$fr = $_POST['FAIR'];
			$str = $_POST['START'];
		   	$fsh = $_POST['FINISH'];
			
		
	 			$query = 'UPDATE route set FAIR ="'.$fr.'",START ="'.$str.'",FINISH ="'.$fsh.'"
					WHERE
					id="'.$edit_id.'"';
			$this->db->query($query);
			$this->session->set_flashdata('success','Route Updated Successfully!','success');
			redirect('transportlogin/route','refresh');
		}
    $this->load->view('transport/template/header');
    $this->load->view('transport/routeedit',$data);
    $this->load->view('transport/template/footer');
    }
	public function deleteRoute()
	{
              $id = $_GET['id'];
			  $query = 'DELETE FROM route
			  WHERE
			  id = ' . $id;
			$this->db->query($query);
			$this->session->set_flashdata('success','Route Deleted Successfully!','success');
			redirect('transportlogin/route','refresh');
    }
	
	public function schedule()
	{
		$data['user']='';
    $this->load->view('transport/template/header');
    $this->load->view('transport/schedule',$data);
    $this->load->view('transport/template/footer');
    }
	public function addSchedule()
	{
		$row=$this->db->limit(1)->order_by('id','desc')->get('schedule')->row();
		if(isset($row)){
		    $value2 = $row->SCHEDULE_ID;
            $value2 = substr($value2, 3, 13);//separating numeric part
            $value2 = $value2 + 1;//Incrementing numeric part
            $value2 = "SCH" . sprintf('%03s', $value2);//concatenating incremented value
            $data['SCHEDULE_ID'] = $value2; 
		}else{
			$data['SCHEDULE_ID'] = 'SCH001'; 
		}
		$add_date=date('Y-m-d H:i:s');
		$data['list_bus']=$this->db->get('bus')->result();
		$data['user']='';
		if(isset($_POST['submit'])){
			            $sid= $_POST['SCHEDULE_ID'];
						$arvl= $_POST['ARRIVAL'];
					    $dpt= $_POST['DEPARTURE'];
						$bid= $_POST['BUS_ID'];
			$query = "INSERT INTO schedule
								(SCHEDULE_ID,ARRIVAL, DEPARTURE, BUS_ID, created_at)
								VALUES ('".$sid."','".$arvl."','".$dpt."','".$bid."','".$add_date."')";
			$this->db->query($query);
			$this->session->set_flashdata('success','Schedule Added Successfully!','success');
			redirect('transportlogin/schedule','refresh');
		}
    $this->load->view('transport/template/header');
    $this->load->view('transport/scheduleadd',$data);
    $this->load->view('transport/template/footer');
    }
	public function editSchedule()
	{
		$data['list_bus']=$this->db->get('bus')->result();
		$query = 'SELECT * FROM schedule WHERE id ='.$_GET['id'];
            $result = $this->db->query($query);
			$row = $result->result_array();
              foreach($row as $row)
              {   
                $data['zz']= $row['SCHEDULE_ID'];
                $data['i']= $row['ARRIVAL'];
                $data['a']=$row['DEPARTURE'];
                $data['b']=$row['BUS_ID'];
              }
              
              $data['id'] = $_GET['id'];
		if(isset($_POST['submit'])){
			$edit_id = $_POST['id'];
			$zz = $_POST['SCHEDULE_ID'];
			$arvl = $_POST['ARRIVAL'];
		    $dpt = $_POST['DEPARTURE'];
			$bid= $_POST['BUS_ID'];
			
		
	 			$query = 'UPDATE schedule set ARRIVAL ="'.$arvl.'",
					DEPARTURE ="'.$dpt.'", BUS_ID="'.$bid.'" WHERE
					id ="'.$edit_id.'"';
			$this->db->query($query);
			$this->session->set_flashdata('success','Schedule Updated Successfully!','success');
			redirect('transportlogin/schedule','refresh');
		}
    $this->load->view('transport/template/header');
    $this->load->view('transport/scheduleedit',$data);
    $this->load->view('transport/template/footer');
    }
	public function deleteSchedule()
	{
              $id = $_GET['id'];
			  $query = 'DELETE FROM schedule
			  WHERE
			  id = ' . $id;
			$this->db->query($query);
			$this->session->set_flashdata('success','Schedule Deleted Successfully!','success');
			redirect('transportlogin/schedule','refresh');
    }
	
	public function stop()
	{
		$data['user']='';
    $this->load->view('transport/template/header');
    $this->load->view('transport/stop',$data);
    $this->load->view('transport/template/footer');
    }
	public function addStop()
	{
		$add_date=date('Y-m-d H:i:s');
		$data['list_route']=$this->db->get('route')->result();
		$data['user']='';
		if(isset($_POST['submit'])){
			            $ln= $_POST['LOCATION_NAME'];
					    $rid= $_POST['ROUTE_ID'];
			$query = "INSERT INTO stop
								(LOCATION_NAME,ROUTE_ID,created_at)
								VALUES ('".$ln."','".$rid."','".$add_date."')";
			$this->db->query($query);
			$this->session->set_flashdata('success','Stop Added Successfully!','success');
			redirect('transportlogin/stop','refresh');
		}
    $this->load->view('transport/template/header');
    $this->load->view('transport/stopadd',$data);
    $this->load->view('transport/template/footer');
    }
	public function editStop()
	{
		$data['list_route']=$this->db->get('route')->result();
		$query = 'SELECT * FROM stop WHERE id ='.$_GET['id'];
            $result = $this->db->query($query);
			$row = $result->result_array();
              foreach($row as $row)
              {  
                $data['i']= $row['LOCATION_NAME'];
                $data['a']=$row['ROUTE_ID'];
              }
              
              $data['id'] = $_GET['id'];
		if(isset($_POST['submit'])){
			$edit_id = $_POST['id'];
			$ln = $_POST['LOCATION_NAME'];
		    $rid = $_POST['ROUTE_ID'];
			
		
	 			$query = 'UPDATE stop set LOCATION_NAME ="'.$ln.'",
					ROUTE_ID ="'.$rid.'"  WHERE
					id ="'.$edit_id.'"';
			$this->db->query($query);
			$this->session->set_flashdata('success','Stop Updated Successfully!','success');
			redirect('transportlogin/stop','refresh');
		}
    $this->load->view('transport/template/header');
    $this->load->view('transport/stopedit',$data);
    $this->load->view('transport/template/footer');
    }
	public function deleteStop()
	{
              $id = $_GET['id'];
			  $query = 'DELETE FROM stop
			  WHERE
			  id = ' . $id;
			$this->db->query($query);
			$this->session->set_flashdata('success','Stop Deleted Successfully!','success');
			redirect('transportlogin/stop','refresh');
    }
	
}
