<?php
require FCPATH.'hostelassets/inc/handyCam.php';
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
class Hosteladminlogin extends CI_Controller {
	
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
        $this->load->library('encryption');
	
	}

	public function index()
	{
		$GLOBALS['title']="Dashboard-ERP";
	    $data['data'] = array();
        $result = $this->db->query("SELECT CASE WHEN COUNT(*)  is NULL THEN 0 ELSE COUNT(*) END as totals from studentinfo WHERE isActive='Y' UNION ALL SELECT CASE WHEN COUNT(*)  is NULL THEN 0 ELSE COUNT(*) END as totalE from employee WHERE isActive='Y' UNION ALL  SELECT CASE WHEN COUNT(*)  is NULL THEN 0 ELSE COUNT(*) END  as totalRoom from rooms where isActive='Y' UNION ALL SELECT CASE WHEN SUM(noOfMeal) IS NULL THEN 0 ELSE SUM(noOfMeal) end from meal WHERE DATE(date)=DATE(NOW())")->result();
        $data['totals']=array();

            foreach ($result as $row) {

                array_push($data['totals'],$row->totals);
            }

        $result1 = $this->db->query("SELECT serial,title,description,DATE_FORMAT(createdDate,'%D %M,%Y %h:%i:%s %p') as date FROM notice ORDER BY serial DESC LIMIT 4");
        
            $data['data']=$result1->result();
	
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/dashboard',$data);
    $this->load->view('hosteladmin/template/footer');
    }
	public function logOut(){
		$this->session->unset_userdata('user'); 
		redirect('employee_login', 'refresh');
	}
	public function listAttendance()
	{
		$GLOBALS['title']="Attendence-ERP";
		$GLOBALS['att_list'] = $this->db->query("SELECT a.serial,b.name,a.date,a.isAbsence ,a.isLeave,a.remark FROM attendence as a,studentinfo as b where a.userId=b.userId and b.isActive='Y'")->result();
		$GLOBALS['handyCam'] = new \handyCam\handyCam();
    
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/attendence/list',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');
    }
	public function addAttendance()
	{
		$GLOBALS['title']="Attendence-ERP";
		$studentinfo = $this->db->query("SELECT userId,name FROM studentinfo  where isActive='Y'")->result();
		$GLOBALS['output']='';
        foreach ($studentinfo as $row) {
            $GLOBALS['isData']="1";
            $GLOBALS['output'] .= '<option value="'.$row->userId.'">'.$row->name.'</option>';

        }
        if (isset($_POST["btnSave"])) {
			
                $userIdf =$_POST['person'];
                $result=$this->db->query("SELECT * FROM attendence WHERE userId='".$userIdf."' and date=CURDATE()");
                if($result->num_rows()<1) {
                    $handyCam = new \handyCam\handyCam();
                    $data = array(
                        'userId' => $_POST['person'],
                        'date' => $handyCam->parseAppDate($_POST['attendDate']),
                        'isAbsence' => $_POST['isabs'],
                        'isLeave' => $_POST['isLeave'],
                        'remark' => $_POST['remark'],


                    );
                    $result = $this->db->insert("attendence", $data);
                    // var_dump($result);
                    if ($result) {

                        //  $db->close();
						$data['msg']=$this->session->set_flashdata('msg','Attendence Added Successfully.','success');	
                        redirect('hosteladminlogin/addAttendance','refresh');
                    } elseif (strpos($result, 'Duplicate') !== false) {
						$data['error']=$this->session->set_flashdata('error','Attendence Already Exits for today!','success');	
                        redirect('hosteladminlogin/addAttendance','refresh');
                    } else {
						$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                        redirect('hosteladminlogin/addAttendance','refresh');
                    }
                }
                else
                {
                    $data['error']=$this->session->set_flashdata('error','Attendence Already Exits for today!','success');	
                        redirect('hosteladminlogin/addAttendance','refresh');
                }
        }
    
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/attendence/add',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');
    }
	public function updateAttendance()
	{
		$GLOBALS['title']="Attendence-ERP";
        if (isset($_POST["btnUpdate"])) {
            $serialFor = $this->input->post('edit_id');
                        $handyCam = new \handyCam\handyCam();
                        $data = array(


                            'isAbsence' => $_POST['isabs'],
                            'isLeave' => $_POST['isLeave'],
                            'remark' => $_POST['remark'],

                        );
                        $this->db->where('serial',$serialFor);
                        $result = $this->db->update("attendence", $data);
                        if ($result) {
							$data['msg']=$this->session->set_flashdata('msg','Attendence Updated Successfully.','success');	
                            redirect('hosteladminlogin/listAttendance','refresh');
                        } else {
                            $data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                            redirect('hosteladminlogin/listAttendance','refresh');
                        }
                    }
                else
                {
					$data['error']=$this->session->set_flashdata('error','Please Select attendence from below table!!!','success');	
                    redirect('hosteladminlogin/listAttendance','refresh');
                }
    }
	public function deleteAttendance()
	{
		$attid = $this->uri->segment(3);
				$sql = "delete from attendence where serial='".$attid."'";
				if ($this->db->query($sql) === TRUE) 
				{
	    			$data['msg']=$this->session->set_flashdata('msg','Attendence deleted successfully','success');	
                    redirect('hosteladminlogin/listAttendance','refresh');
				} 
				else 
				{
					$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                    redirect('hosteladminlogin/listAttendance','refresh');
				}
		
	}	
	
	public function listMeal()
	{
		$GLOBALS['title']="Meal-ERP";
		$GLOBALS['meal_list'] = $this->db->query("SELECT a.serial,b.name,a.noOfMeal,DATE_FORMAT(a.date, '%D %M,%Y') as mealDate FROM meal as a,studentinfo as b where a.userId=b.userId and b.isActive='Y'")->result();
		$GLOBALS['handyCam'] = new \handyCam\handyCam();
    
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/meal/view',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');
    }
	public function addMeal()
	{
		$GLOBALS['title']="Meal-ERP";
		$studentinfo = $this->db->query("SELECT userId,name FROM studentinfo  where isActive='Y'")->result();
		$GLOBALS['output']='';
        foreach ($studentinfo as $row) {
            $GLOBALS['isData']="1";
            $GLOBALS['output'] .= '<option value="'.$row->userId.'">'.$row->name.'</option>';

        }
        if (isset($_POST["btnSave"])) {
			
                if($result->num_rows()<1) {
                    $handyCam = new \handyCam\handyCam();
                    $data = array(
                    'userId' => $_POST['person'],
                    'noOfMeal' => floatval($_POST['noOfMeal']),
                     'date' =>date("Y-m-d")
                );
                    $result = $this->db->insert("meal", $data);
                    // var_dump($result);
                    if ($result) {

                        //  $db->close();
						$data['msg']=$this->session->set_flashdata('msg','Meal Added Successfully.','success');	
                        redirect('hosteladminlogin/addMeal','refresh');
                    } elseif (strpos($result, 'Duplicate') !== false) {
						$data['error']=$this->session->set_flashdata('error','Meal Already Exits!','success');	
                        redirect('hosteladminlogin/addMeal','refresh');
                    } else {
						$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                        redirect('hosteladminlogin/addMeal','refresh');
                    }
                }
                else
                {
                    $data['error']=$this->session->set_flashdata('error','Meal Already Exits!','success');	
                        redirect('hosteladminlogin/addMeal','refresh');
                }
        }
    
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/meal/add',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');
    }
	public function updateMeal()
	{
		$GLOBALS['title']="Meal-ERP";
		$serial = $this->uri->segment(3);
		$GLOBALS['data'] = array();
            $result = $this->db->query("SELECT a.serial,b.name,a.userId,a.noOfMeal,a.date FROM meal as a,studentinfo as b where a.serial='".$serial."' and a.userId=b.userId ")->result();
		$handyCam = new \handyCam\handyCam();	
		$GLOBALS['data'] = array();
                foreach ($result as $row) {
                    array_push($GLOBALS['data'],$row->name.'['.$row->userId.']');
                    array_push($GLOBALS['data'],$row->noOfMeal);
                    array_push($GLOBALS['data'],$handyCam->getAppDate($row->date));
                    array_push($GLOBALS['data'],$row->serial);

                }
        if (isset($_POST["btnUpdate"])) {
            $serialFor = $_POST['edit_id'];
                        $handyCam = new \handyCam\handyCam();
                       $data = array(

                    'noOfMeal' => $_POST['noOfMeal'],

                    'date' =>$handyCam->parseAppDate($_POST['date'])

                );
                        $this->db->where('serial',$serialFor);
                        $result = $this->db->update("meal", $data);
                        if ($result) {
							$data['msg']=$this->session->set_flashdata('msg','Meal Updated Successfully.','success');	
                            redirect('hosteladminlogin/listMeal','refresh');
                        } else {
                            $data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                            redirect('hosteladminlogin/listMeal','refresh');
                        }
                    }
	$this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/meal/edit',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');			
    }
	public function deleteMeal()
	{
		$mealid = $this->uri->segment(3);
				$sql = "delete from meal where serial='".$mealid."'";
				if ($this->db->query($sql) === TRUE) 
				{
	    			$data['msg']=$this->session->set_flashdata('msg','Meal deleted successfully','success');	
                    redirect('hosteladminlogin/listMeal','refresh');
				} 
				else 
				{
					$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                    redirect('hosteladminlogin/listMeal','refresh');
				}
		
	}
	
	public function listCost()
	{
		$GLOBALS['title']="Cost-ERP";
		$GLOBALS['cost_list'] = $this->db->query("SELECT * FROM cost")->result();
		$GLOBALS['handyCam'] = new \handyCam\handyCam();
		
		if (isset($_POST["btnPrint"])) {
        $this->printData($GLOBALS);
       // header( 'Location: view.php');
    }
    
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/cost/view',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');
    }
	public function addCost()
	{
		$GLOBALS['title']="Cost-ERP";
        if (isset($_POST["btnSave"])) {
                    $handyCam = new \handyCam\handyCam();
                    $$amount = (float)$_POST['amount'];
                $data = array(
                    'type' => $_POST['type'],
                    'amount' => floatval($_POST['amount']),
                    'date' =>date("Y-m-d"),

                    'description' => $_POST['description']

                );
                $result = $this->db->insert("cost",$data);
                    // var_dump($result);
                    if ($result>=0) {
						$data['msg']=$this->session->set_flashdata('msg','Cost Added Successfully.','success');	
                        redirect('hosteladminlogin/addCost','refresh');
                    } elseif (strpos($result, 'Duplicate') !== false) {
						$data['error']=$this->session->set_flashdata('error','Cost Already Exits!','success');	
                        redirect('hosteladminlogin/addCost','refresh');
                    } else {
						$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                        redirect('hosteladminlogin/addCost','refresh');
                    }
        }
    
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/cost/add',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');
    }
	public function updateCost()
	{
		$GLOBALS['title']="Cost-ERP";
		$serial = $this->uri->segment(3);
		$GLOBALS['data'] = array();
            $result = $this->db->query("SELECT * FROM cost where serial='".$serial."' ")->result();
		$handyCam = new \handyCam\handyCam();	
		$GLOBALS['data'] = array();
                foreach ($result as $row) {
                    array_push($GLOBALS['data'],$row->type);
                    array_push($GLOBALS['data'],$row->amount);
                    array_push($GLOBALS['data'],$row->description);
                    array_push($GLOBALS['data'],$row->serial);

                }
        if (isset($_POST["btnUpdate"])) {
            $serialFor = $_POST['edit_id'];
                        $handyCam = new \handyCam\handyCam();
                       $data = array(

                    'type' => $_POST['type'],
                    'amount' => floatval($_POST['amount']),
                    'date' =>date("Y-m-d"),

                    'description' => $_POST['description']

                );
                        $this->db->where('serial',$serialFor);
                        $result = $this->db->update("cost", $data);
                        if ($result) {
							$data['msg']=$this->session->set_flashdata('msg','Cost Updated Successfully.','success');	
                            redirect('hosteladminlogin/listCost','refresh');
                        } else {
                            $data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                            redirect('hosteladminlogin/listCost','refresh');
                        }
                    }
	$this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/cost/edit',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');			
    }
	public function deleteCost()
	{
		$costid = $this->uri->segment(3);
				$sql = "delete from cost where serial='".$costid."'";
				if ($this->db->query($sql) === TRUE) 
				{
	    			$data['msg']=$this->session->set_flashdata('msg','Cost deleted successfully','success');	
                    redirect('hosteladminlogin/listCost','refresh');
				} 
				else 
				{
					$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                    redirect('hosteladminlogin/listCost','refresh');
				}
		
	}
	function  printData()
{
	$GLOBALS['title']="Cost-ERP";
		$GLOBALS['cost_list'] = $this->db->query("SELECT * FROM cost")->result();
		$GLOBALS['handyCam'] = new \handyCam\handyCam();
    $html = $this->load->view('hosteladmin/ui/cost/viewPDF',$GLOBALS,true);
$dompdf = new \Dompdf\Dompdf(); 
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("Cost_".date('d-m-Y').".pdf", array("Attachment"=>1));

}

public function do_upload1(){

    	$config = array();
		//$config['upload_path'] = 'hostelassets/files/student/';
		$config['allowed_types'] = '*';
		$config['remove_spaces'] = TRUE;
		$config['overwrite'] = FALSE;
		return $config;
		
        }
	public function listStudentAdmission()
	{
		$GLOBALS['title']="Student-ERP";
		$GLOBALS['batch1'] = '';
		
		if(isset($_POST['submit'])){
			$GLOBALS['batch1'] = $batch = $this->input->post('batch');
		$GLOBALS['adm_list'] = $this->db->query("SELECT * from studentinfo where batchNo=".$batch." and isActive='Y'")->result();
		$GLOBALS['handyCam'] = new \handyCam\handyCam();
		}
    
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/studentManage/studentlist',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');
    }
public function viewStudentAdmission()
	{
		$GLOBALS['title']="Student-ERP";
		$userId = $this->uri->segment(3);
		$GLOBALS['data'] = array();
            $result = $this->db->query("SELECT * FROM studentinfo where userId='".$userId."' ")->result_array();
		$handyCam = new \handyCam\handyCam();	
		$GLOBALS['data'] = array();
                foreach ($result as $row) {
                    array_push($GLOBALS['data'],$row['name']);
                    array_push($GLOBALS['data'],$row['studentId']);
                    array_push($GLOBALS['data'],$row['cellNo']);
                    array_push($GLOBALS['data'],$row['email']);
                    array_push($GLOBALS['data'],$row['nameOfInst']);
                    array_push($GLOBALS['data'],$row['program']);
                    array_push($GLOBALS['data'],$row['batchNo']);
                    array_push($GLOBALS['data'],$row['gender']);
                    array_push($GLOBALS['data'],$handyCam->getAppDate($row['dob']));
                    array_push($GLOBALS['data'],$row['bloodGroup']);
                    array_push($GLOBALS['data'],$row['nationality']);
                    array_push($GLOBALS['data'],$row['nationalId']);
                    array_push($GLOBALS['data'],$row['passportNo']);
                    array_push($GLOBALS['data'],$row['fatherName']);
                    array_push($GLOBALS['data'],$row['fatherCellNo']);
                    array_push($GLOBALS['data'],$row['motherName']);
                    array_push($GLOBALS['data'],$row['motherCellNo']);
                    array_push($GLOBALS['data'],$row['localGuardian']);
                    array_push($GLOBALS['data'],$row['localGuardianCell']);
                    array_push($GLOBALS['data'],$row['presentAddress']);
                    array_push($GLOBALS['data'],$row['parmanentAddress']);
                    array_push($GLOBALS['data'],$row['userId']);
                    array_push($GLOBALS['data'],$row['perPhoto']);

                }
    
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/studentManage/studentview',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');
    }	
public function studentAdmission()
	{
		$GLOBALS['title']="Admission-ERP";
        if (isset($_POST["btnSave"])) {
		$uid2 = $this->db->order_by('serial','desc')->get('studentinfo')->row();	
		$uid1 = explode('U',$uid2->userId);
        $prefix = 'U';
		$index = $uid1[1]+1;
        $userIds = sprintf("%s%09s", $prefix, $index);
                    $handyCam = new \handyCam\handyCam();
                    $$amount = (float)$_POST['amount'];
                $dateNow=date("Y-m-d");
                $data = array(
                    'userId' => $userIds,
                    'userGroupId' => "UG004",
                    'name' => $_POST['name'],
                    'studentId' => $_POST['stdId'],
                    'cellNo' => $_POST['cellNo'],
                    'email' => $_POST['email'],
                    'nameOfInst' => $_POST['nameOfInst'],
                    'program' => $_POST['program'],
                    'batchNo' => $_POST['batchNo'],
                    'gender' => $_POST['gender'],
                    'dob' => $handyCam->parseAppDate($_POST['dob']),
                    'bloodGroup' => $_POST['bloodGroup'],
                    'nationality' => $_POST['nationality'],
                    'nationalId' => $_POST['nationalId'],
                    'passportNo' => $_POST['passportNo'],
                    'fatherName' => $_POST['fatherName'],
                    'motherName' => $_POST['motherName'],
                    'fatherCellNo' => $_POST['fatherCellNo'],
                    'motherCellNo' => $_POST['motherCellNo'],
                    'localGuardian' => $_POST['localGuardian'],
                    'localGuardianCell' => $_POST['localGuardianCell'],
                    'presentAddress' => $_POST['presentAddress'],
                    'parmanentAddress' =>$_POST['parmanentAddress'],
                    'admitDate' => $dateNow,
                    'isActive' => 'Y'
                );
				if($_FILES['perPhoto']['size'] != 0) {
                       $file_ext = pathinfo($_FILES["perPhoto"]["name"], PATHINFO_EXTENSION);
					   $NewImageName = $userIds.'.'.$file_ext;
					   
			           $_FILES["file"]["name"] = $NewImageName;
					   $_FILES["file"]["type"] = $_FILES["perPhoto"]["type"];
					   $_FILES["file"]["tmp_name"] = $_FILES["perPhoto"]["tmp_name"];
					   $_FILES["file"]["error"] = $_FILES["perPhoto"]["error"];
					   $_FILES["file"]["size"] = $_FILES["perPhoto"]["size"];

					   $config = $this->do_upload1();
					   $config['upload_path'] = 'hostelassets/files/student/';
					   $this->upload->initialize($config);
					   if($this->upload->do_upload('file'))
					   {
						$ffff = $this->upload->data();
						 $image=$ffff['file_name'];
						 
						 $data['perPhoto'] = 'hostelassets/files/student/'.$NewImageName;
						 }
                $result = $this->db->insert("studentinfo",$data);
				if($result>=0) {
                    $userPass = $this->encryption->encrypt($_POST['password']);
                    $data = array(
                        'userId' => $userIds,
                        'userGroupId' => "UG004",
                        'name' => $_POST['name'],
                        'loginId' => $_POST['stdId'],
                        'password' => $userPass,
                        'verifyCode' => "mssw2025",
                        'expireDate' => "2025-01-01",
                        'isVerifed' => 'Y'
                    );
                    $result=$this->db->insert("users",$data);
                    if($result>0)
                    {
                        $id =intval($index);

                        $query="UPDATE auto_id set number=".$id." where prefix='U';";
                        $result=$this->db->query($query);
                        $data['msg']=$this->session->set_flashdata('msg','Admitted Successfully.','success');	
                        redirect('hosteladminlogin/studentAdmission','refresh');
                    }
					elseif (strpos($result, 'Duplicate') !== false) {
						$data['error']=$this->session->set_flashdata('error','Student Already Exits!','success');	
                        redirect('hosteladminlogin/studentAdmission','refresh');
                    } else {
						$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                        redirect('hosteladminlogin/studentAdmission','refresh');
                    }
					   }
        }
		}
    
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/studentManage/admission',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');
    }
public function updateStudentAdmission()
	{
		$GLOBALS['title']="Admission-ERP";
		$userId = $this->uri->segment(3);
		$GLOBALS['data'] = array();
            $result = $this->db->query("SELECT studentinfo.*, users.password FROM studentinfo join users on users.userId=studentinfo.userId where studentinfo.userId='".$userId."' ")->result_array();
		$handyCam = new \handyCam\handyCam();	
		$GLOBALS['data'] = array();
                foreach ($result as $row) {
                    array_push($GLOBALS['data'],$row['name']);
                    array_push($GLOBALS['data'],$row['studentId']);
                    array_push($GLOBALS['data'],$row['cellNo']);
                    array_push($GLOBALS['data'],$row['email']);
                    array_push($GLOBALS['data'],$row['nameOfInst']);
                    array_push($GLOBALS['data'],$row['program']);
                    array_push($GLOBALS['data'],$row['batchNo']);
                    array_push($GLOBALS['data'],$row['gender']);
                    array_push($GLOBALS['data'],$handyCam->getAppDate($row['dob']));
                    array_push($GLOBALS['data'],$row['bloodGroup']);
                    array_push($GLOBALS['data'],$row['nationality']);
                    array_push($GLOBALS['data'],$row['nationalId']);
                    array_push($GLOBALS['data'],$row['passportNo']);
                    array_push($GLOBALS['data'],$row['fatherName']);
                    array_push($GLOBALS['data'],$row['motherName']);
                    array_push($GLOBALS['data'],$row['fatherCellNo']);
                    array_push($GLOBALS['data'],$row['motherCellNo']);
                    array_push($GLOBALS['data'],$row['localGuardian']);
                    array_push($GLOBALS['data'],$row['localGuardianCell']);
                    array_push($GLOBALS['data'],$row['presentAddress']);
                    array_push($GLOBALS['data'],$row['parmanentAddress']);
                    array_push($GLOBALS['data'],$row['userId']);
                    array_push($GLOBALS['data'],$this->encryption->decrypt($row['password']));

                }
        if (isset($_POST["btnUpdate"])) {
            $user_Id = $_POST['edit_id'];
                        $handyCam = new \handyCam\handyCam();
                       $data = array(

                    'name' => $_POST['name'],
                    'studentId' => $_POST['stdId'],
                    'cellNo' => $_POST['cellNo'],
                    'email' => $_POST['email'],
                    'nameOfInst' => $_POST['nameOfInst'],
                    'program' => $_POST['program'],
                    'batchNo' => $_POST['batchNo'],
                    'gender' => $_POST['gender'],
                    'dob' => $handyCam->parseAppDate($_POST['dob']),
                    'bloodGroup' => $_POST['bloodGroup'],
                    'nationality' => $_POST['nationality'],
                    'nationalId' => $_POST['nationalId'],
                    'passportNo' => $_POST['passportNo'],
                    'fatherName' => $_POST['fatherName'],
                    'motherName' => $_POST['motherName'],
                    'fatherCellNo' => $_POST['fatherCellNo'],
                    'motherCellNo' => $_POST['motherCellNo'],
                    'localGuardian' => $_POST['localGuardian'],
                    'localGuardianCell' => $_POST['localGuardianCell'],
                    'presentAddress' => $_POST['presentAddress'],
                    'parmanentAddress' =>$_POST['parmanentAddress']


                );
				if($_FILES['perPhoto']['size'] != 0) {
                       $file_ext = pathinfo($_FILES["perPhoto"]["name"], PATHINFO_EXTENSION);
					   $NewImageName = $user_Id.'.'.$file_ext;
					   
			           $_FILES["file"]["name"] = $NewImageName;
					   $_FILES["file"]["type"] = $_FILES["perPhoto"]["type"];
					   $_FILES["file"]["tmp_name"] = $_FILES["perPhoto"]["tmp_name"];
					   $_FILES["file"]["error"] = $_FILES["perPhoto"]["error"];
					   $_FILES["file"]["size"] = $_FILES["perPhoto"]["size"];

					   $config = $this->do_upload1();
					   $config['upload_path'] = 'hostelassets/files/student/';
					   $this->upload->initialize($config);
					   if($this->upload->do_upload('file'))
					   {
						$ffff = $this->upload->data();
						 $image=$ffff['file_name'];
						 
						 $data['perPhoto'] = 'hostelassets/files/student/'.$NewImageName;
						 }
				}
                        $this->db->where('userId',$user_Id);
                        $result = $this->db->update("studentinfo", $data);
					if ($result) {
                    $userPass = $this->encryption->encrypt($_POST['password']);
                    $data = array(
                        'loginId' => $_POST['stdId'],
                        'password' => $userPass
                    );
                    $this->db->where('userId',$user_Id);
                    $result = $this->db->update("users", $data);	
					}
                        if ($result) {
							$data['msg']=$this->session->set_flashdata('msg','Student Updated Successfully.','success');	
                            redirect('hosteladminlogin/listStudentAdmission','refresh');
                        } else {
                            $data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                            redirect('hosteladminlogin/listStudentAdmission','refresh');
                        }
		}
	$this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/studentManage/studentedit',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');			
    }
	public function deleteStudentAdmission()
	{
		$userId = $this->uri->segment(3);
		    $data = array(

                'isActive' => 'N'
            );
				$this->db->where('userId',$userId);
                $result = $this->db->update("studentinfo", $data);
					if ($result===TRUE) {
                    $data = array(
                        'isVerifed' => 'N'
                    );
                    $this->db->where('userId',$userId);
                    $result = $this->db->update("users", $data);
					}
				if ($result === TRUE) 
				{
	    			$data['msg']=$this->session->set_flashdata('msg','Student deleted successfully','success');	
                    redirect('hosteladminlogin/listStudentAdmission','refresh');
				} 
				else 
				{
					$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                    redirect('hosteladminlogin/listStudentAdmission','refresh');
				}
		
	}
	public function listDeposit()
	{
		$GLOBALS['title']="Deposit-ERP";
		$studentinfo = $this->db->query("SELECT userId,name FROM studentinfo  where isActive='Y'")->result();
		$GLOBALS['output']='';
        foreach ($studentinfo as $row) {
            $GLOBALS['isData']="1";
            $GLOBALS['output'] .= '<option value="'.$row->userId.'">'.$row->name.'</option>';

        }
		$GLOBALS['dep_list'] = $this->db->query("SELECT a.serial,b.name,a.amount,DATE_FORMAT(a.depositDate, '%D %M,%Y') as date from deposit as a, studentinfo as b where a.userId = b.userId and b.isActive='Y'")->result();
		$GLOBALS['handyCam'] = new \handyCam\handyCam();
		if (isset($_POST["btnSave"])) {
                    $handyCam = new \handyCam\handyCam();
                
                $data = array(
                    'userId' => $_POST['person'],
                    'amount' => floatval($_POST['amount']),
                    'depositDate' =>date("Y-m-d")


                );
                    $result=$this->db->insert("deposit",$data);
					if($result){
						$data['msg']=$this->session->set_flashdata('msg','Money Deposit Successfull!','success');	
                        redirect('hosteladminlogin/listDeposit','refresh');
					}
					elseif (strpos($result, 'Duplicate') !== false) {
						$data['error']=$this->session->set_flashdata('error','Deposit Already Exits!','success');	
                        redirect('hosteladminlogin/listDeposit','refresh');
                    } else {
						$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                        redirect('hosteladminlogin/listDeposit','refresh');
                    }
					   }
		if (isset($_POST["btnPrint"])) {
        $this->printDeposit($GLOBALS);
       // header( 'Location: view.php');
    }
    
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/studentManage/deposit',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');
    }
	function  printDeposit()
{
	$GLOBALS['title']="Deposit-ERP";
		$GLOBALS['dep_list'] = $this->db->query("SELECT a.serial,b.name,a.amount,DATE_FORMAT(a.depositDate, '%D %M,%Y') as date from deposit as a, studentinfo as b where a.userId = b.userId and b.isActive='Y'")->result();
		$GLOBALS['handyCam'] = new \handyCam\handyCam();
    $html = $this->load->view('hosteladmin/ui/studentManage/depositPDF',$GLOBALS,true);
$dompdf = new \Dompdf\Dompdf(); 
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("Deposit_".date('d-m-Y').".pdf", array("Attachment"=>1));

}
public function updateDeposit()
	{
		$GLOBALS['title']="Deposit-ERP";
		$serial = $this->uri->segment(3);
		$GLOBALS['data'] = array();
            $result = $this->db->query("SELECT * FROM deposit where serial='".$serial."' ")->result_array();
		$handyCam = new \handyCam\handyCam();	
		$GLOBALS['data'] = array();
                foreach ($result as $row) {
					array_push($GLOBALS['data'],$row['userId']);
                    array_push($GLOBALS['data'],$row['amount']);
                    array_push($GLOBALS['data'],$row['serial']);
                }
        if (isset($_POST["btnUpdate"])) {
            $user_Id = $_POST['edit_id'];
                        $handyCam = new \handyCam\handyCam();
                       $data = array(

                    'amount' => $_POST['amount'],

                    'depositDate' =>date("Y-m-d")

                );
				$this->db->where('serial',$user_Id);
                $result = $this->db->update("deposit", $data);
                        if ($result) {
							$data['msg']=$this->session->set_flashdata('msg','Deposit Updated Successfully.','success');	
                            redirect('hosteladminlogin/listDeposit','refresh');
                        } else {
                            $data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                            redirect('hosteladminlogin/listDeposit','refresh');
                        }
		}
	$this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/studentManage/depositaction',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');			
    }
	public function deleteDeposit()
	{
		$depositid = $this->uri->segment(3);
				$sql = "delete from deposit where serial='".$depositid."'";
				if ($this->db->query($sql) === TRUE) 
				{
	    			$data['msg']=$this->session->set_flashdata('msg','Deposit deleted successfully','success');	
                    redirect('hosteladminlogin/listDeposit','refresh');
				} 
				else 
				{
					$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                    redirect('hosteladminlogin/listDeposit','refresh');
				}
		
	}
	
	public function listSeatAllocation()
	{
		$GLOBALS['title']="Seat Allocation - ERP";
		$GLOBALS['handyCam'] = new \handyCam\handyCam();
		
		$GLOBALS['stream1']="";
		$GLOBALS['department1']="";
		$GLOBALS['batch1']="";
		
		$studentinfo = $this->db->query("SELECT userId,name FROM studentinfo  where isActive='Y'")->result();
		$GLOBALS['output']='';
        foreach ($studentinfo as $row) {
            $GLOBALS['isData']="1";
            $GLOBALS['output'] .= '<option value="'.$row->userId.'">'.$row->name.'</option>';

        }
		$blockinfo = $this->db->query("SELECT blockId,blockNo FROM blocks  where isActive='Y'")->result();
		$GLOBALS['output1']='';
        foreach ($blockinfo as $row1) {
            $GLOBALS['isData2']="1";
            $GLOBALS['output1'] .= '<option value="'.$row1->blockId.'">'.$row1->blockNo.'</option>';

        }
		$roominfo = $this->db->query("SELECT roomId,roomNo FROM rooms  where isActive='Y'")->result();
		$GLOBALS['output2']='';
        foreach ($roominfo as $row2) {
            $GLOBALS['isData3']="1";
            $GLOBALS['output2'] .= '<option value="'.$row2->roomId.'">'.$row2->roomNo.'</option>';

        }
        if (isset($_POST["btnSave"])) {
			$result=$this->db->where('userId',$_POST['person'])->get('seataloc');
			
                if($result->num_rows()<1) {
                    $handyCam = new \handyCam\handyCam();
                    $data = array(
                    'userId' => $_POST['person'],
                    'monthlyRent' => floatval($_POST['mrent']),
                    'blockNo' => $_POST['blockNo'],
                    'roomNo' => $_POST['roomNo']


                );
                    $result = $this->db->insert("seataloc", $data);
                    // var_dump($result);
                    if ($result) {

                        //  $db->close();
						$data['msg']=$this->session->set_flashdata('msg','Seat Alocation Successfully.','success');	
                        redirect('hosteladminlogin/listSeatAllocation','refresh');
                    } else {
						$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                        redirect('hosteladminlogin/listSeatAllocation','refresh');
                    }
                }
                else
                {
                    $data['error']=$this->session->set_flashdata('error','Seat Alocation Already Exits!','success');	
                        redirect('hosteladminlogin/listSeatAllocation','refresh');
                }
        }
		
		if (isset($_POST["btnList"])) {
		$GLOBALS['stream1']=$stream=$this->input->post('stream');
		$GLOBALS['department1']=$department=$this->input->post('department');
		$GLOBALS['batch1']=$batch=$this->input->post('batch');
		$GLOBALS['seat_list'] = $this->db->query("SELECT a.userId,b.name,a.blockNo,a.roomNo,a.monthlyRent from seataloc as a, studentinfo as b where a.userId = b.userId and b.isActive='Y' and b.batchNo='".$batch."' and b.main_id='".$stream."' and b.course_id='".$department."' ")->result();
		}
    
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/studentManage/seatalocation',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');
    }
	public function updateSeatAllocation()
	{
		$GLOBALS['title']="Seat Allocation - ERP";
		$userId = $this->uri->segment(3);
		$GLOBALS['data'] = array();
            $result = $this->db->query("SELECT * FROM seataloc where userId='".$userId."'")->result();
		$handyCam = new \handyCam\handyCam();	
		$GLOBALS['data'] = array();
                foreach ($result as $row) {
                    array_push($GLOBALS['data'],$row->blockNo);
                    array_push($GLOBALS['data'],$row->roomNo);
                    array_push($GLOBALS['data'],$row->monthlyRent);
                    array_push($GLOBALS['data'],$row->userId);

                }
		$studentinfo = $this->db->query("SELECT userId,name FROM studentinfo  where isActive='Y'")->result();
		$GLOBALS['output']='';
        foreach ($studentinfo as $row) {
            $GLOBALS['isData']="1";
            $GLOBALS['output'] .= '<option value="'.$row->userId.'">'.$row->name.'</option>';

        }
		$blockinfo = $this->db->query("SELECT blockId,blockNo FROM blocks  where isActive='Y'")->result();
		$GLOBALS['output1']='';
        foreach ($blockinfo as $row1) {
			if($row1->blockId==$GLOBALS['data'][0]){$selected='selected';}else{$selected='';}
            $GLOBALS['isData2']="1";
            $GLOBALS['output1'] .= '<option value="'.$row1->blockId.'" '.$selected.'>'.$row1->blockNo.'</option>';

        }
		$roominfo = $this->db->query("SELECT roomId,roomNo FROM rooms  where isActive='Y'")->result();
		$GLOBALS['output2']='';
        foreach ($roominfo as $row2) {
			if($row2->roomId==$GLOBALS['data'][1]){$selected1='selected';}else{$selected1='';}
            $GLOBALS['isData3']="1";
            $GLOBALS['output2'] .= '<option value="'.$row2->roomId.'" '.$selected1.'>'.$row2->roomNo.'</option>';

        }		
        if (isset($_POST["btnUpdate"])) {
            $user_Id = $_POST['edit_id'];
                        $handyCam = new \handyCam\handyCam();
                       $data = array(

                    'blockNo' => $_POST['blockNo'],
                    'roomNo' => $_POST['roomNo'],
                    'monthlyRent' =>$_POST['mrent']

                );
                        $this->db->where('userId',$user_Id);
                        $result = $this->db->update("seataloc", $data);
                        if ($result) {
							$data['msg']=$this->session->set_flashdata('msg','Seat Alocation Updated Successfully.','success');	
                            redirect('hosteladminlogin/listSeatAllocation','refresh');
                        } else {
                            $data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                            redirect('hosteladminlogin/listSeatAllocation','refresh');
                        }
                    }
	$this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/studentManage/seatalaction',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');			
    }
	public function deleteSeatAllocation()
	{
		$seatid = $this->uri->segment(3);
				$sql = "delete from seataloc where userId='".$seatid."'";
				if ($this->db->query($sql) === TRUE) 
				{
	    			$data['msg']=$this->session->set_flashdata('msg','Seat Alocation deleted successfully','success');	
                    redirect('hosteladminlogin/listSeatAllocation','refresh');
				} 
				else 
				{
					$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                    redirect('hosteladminlogin/listSeatAllocation','refresh');
				}
		
	}
	
	public function listStudentPayment()
	{
		$GLOBALS['title']="Payment - ERP";
		$userId=$GLOBALS['loginGrp']=$this->session->userdata('user')['user_id'];
		if (isset($_POST["btnUpdate"])) {
			$user_Id=$_POST['person'];
		$GLOBALS['pay_list'] = $this->db->query("SELECT a.userId,a.serial,b.name,a.transDate,a.paymentBy ,a.transNo,a.amount,a.remark FROM stdpayment as a,studentinfo as b where a.userId='" . $user_Id . "' and a.userId=b.userId and a.isApprove='Yes' and b.isActive='Y'")->result();
		$GLOBALS['handyCam'] = new \handyCam\handyCam();
		}
		
		$studentinfo = $this->db->query("SELECT userId,name FROM studentinfo  where isActive='Y'")->result();
		$GLOBALS['output']='';
        foreach ($studentinfo as $row) {
            $GLOBALS['isData']="1";
            $GLOBALS['output'] .= '<option value="'.$row->userId.'">'.$row->name.'</option>';

        }
        if (isset($_POST["btnUpdatePay"])) {
			$serial = $_POST['edit_id'];
			$stu_id = $_POST['stu_id'];
                    $handyCam = new \handyCam\handyCam();
                    $data = array(

                    'transDate' => $handyCam->parseAppDate($_POST['paydate']),
                    'paymentBy' => $_POST['paidby'],
                    'transNo' => $_POST['transno'],
                    'amount' => floatval($_POST['amount']),
                    'remark' => $_POST['remark'],
                    'isApprove' => "Yes",


                );
                    $this->db->where("serial", $serial);
                    $result = $this->db->update("stdpayment", $data);
                    // var_dump($result);
                    if ($result) {

                        //  $db->close();
						$data['msg']=$this->session->set_flashdata('msg','Payment Updated Successfully.','success');	
                        $GLOBALS['pay_list'] = $this->db->query("SELECT a.userId,a.serial,b.name,a.transDate,a.paymentBy ,a.transNo,a.amount,a.remark FROM stdpayment as a,studentinfo as b where a.userId='" . $stu_id . "' and a.userId=b.userId and a.isApprove='Yes' and b.isActive='Y'")->result();
		                $GLOBALS['handyCam'] = new \handyCam\handyCam();
                    } else {
						$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                        $GLOBALS['pay_list'] = $this->db->query("SELECT a.userId,a.serial,b.name,a.transDate,a.paymentBy ,a.transNo,a.amount,a.remark FROM stdpayment as a,studentinfo as b where a.userId='" . $stu_id . "' and a.userId=b.userId and a.isApprove='Yes' and b.isActive='Y'")->result();
		                $GLOBALS['handyCam'] = new \handyCam\handyCam();
                    }
        }
		if (isset($_POST["btnPrint"])) {
        $this->printPayment($GLOBALS);
       // header( 'Location: view.php');
    }
    
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/stdpayment/view',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');
    }
	function  printPayment()
{
	$GLOBALS['title']="Payment-ERP";
	$user_Id=$_POST['person'];
		$GLOBALS['pay_list'] = $this->db->query("SELECT a.serial,b.name,a.transDate,a.paymentBy ,a.transNo,a.amount,a.remark,a.isApprove FROM stdpayment as a,studentinfo as b where a.userId='" . $user_Id . "' and a.userId=b.userId and b.isActive='Y'")->result();
		$GLOBALS['handyCam'] = new \handyCam\handyCam();
    $html = $this->load->view('hosteladmin/ui/stdpayment/paymentPDF',$GLOBALS,true);
$dompdf = new \Dompdf\Dompdf(); 
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("Payment_".date('d-m-Y').".pdf", array("Attachment"=>1));

}
public function addStudentPayment()
	{
		$GLOBALS['title']="Payment - ERP";
		
		$studentinfo = $this->db->query("SELECT userId,name FROM studentinfo  where isActive='Y'")->result();
		$GLOBALS['output']='';
        foreach ($studentinfo as $row) {
            $GLOBALS['isData']="1";
            $GLOBALS['output'] .= '<option value="'.$row->userId.'">'.$row->name.'</option>';

        }
        if (isset($_POST["btnSave"])) {
                    $handyCam = new \handyCam\handyCam();
                    $data = array(
                        'userId' => $_POST['person'],
                        'transDate' => $handyCam->parseAppDate($_POST['paydate']),
                        'paymentBy' => $_POST['paidby'],
                        'transNo' => $_POST['transno'],
                        'amount' => floatval($_POST['amount']),
                        'remark' => $_POST['remark'],
                        'isApprove'=>'Yes',


                    );
                    $result = $this->db->insert("stdpayment", $data);
                    // var_dump($result);
                    if ($result) {

                        //  $db->close();
						$data['msg']=$this->session->set_flashdata('msg','Payment Added Successfully.','success');	
                        redirect('hosteladminlogin/listStudentPayment','refresh');
                    } 
                elseif(strpos($result, 'Duplicate') !== false)
                {
                    $data['error']=$this->session->set_flashdata('error','Payment Already Exits!','success');	
                        redirect('hosteladminlogin/listStudentPayment','refresh');
                }else {
						$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                        redirect('hosteladminlogin/listStudentPayment','refresh');
                    }
        }
    
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/stdpayment/add',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');
    }
	public function approvePayment()
	{
		$GLOBALS['title']="Payment - ERP";
		$GLOBALS['appr_list'] = $this->db->query("SELECT a.serial,b.name,a.transDate,a.paymentBy ,a.transNo,a.amount,a.remark FROM stdpayment as a,studentinfo as b where a.userId=b.userId and a.isApprove='No' and b.isActive='Y'")->result();
		$GLOBALS['handyCam'] = new \handyCam\handyCam();
        if (isset($_POST["approve"])) {
			$serial = $_POST['edit_id'];
			$result = $this->db->query("update stdpayment set isApprove='Yes' where serial='".$serial."'");
                    // var_dump($result);
                    if ($result) {

                        //  $db->close();
						$data['msg']=$this->session->set_flashdata('msg','Payment Aprroved Successfully.','success');
						redirect('hosteladminlogin/approvePayment','refresh');
                    } else {
						$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
						redirect('hosteladminlogin/approvePayment','refresh');
                    }
        }
    
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/stdpayment/approvallist',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');
    }
  public function deleteStudentPayment()
	{
		$payid = $this->uri->segment(3);
				$sql = "delete from stdpayment where serial='".$payid."'";
				if ($this->db->query($sql) === TRUE) 
				{
	    			$data['msg']=$this->session->set_flashdata('msg','Payment deleted successfully','success');	
                    redirect('hosteladminlogin/listStudentPayment','refresh');
				} 
				else 
				{
					$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                    redirect('hosteladminlogin/listStudentPayment','refresh');
				}
		
	}
	
	public function listEmployee()
	{
		$GLOBALS['title']="Employee-ERP";
		$GLOBALS['emp_list'] = $this->db->query("SELECT * FROM employee where isActive='Y'")->result();
		$GLOBALS['handyCam'] = new \handyCam\handyCam();
    
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/employee/view',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');
    }
	public function addEmployee()
	{
		$GLOBALS['title']="Employee-ERP";
		$blockinfo = $this->db->query("SELECT blockId,blockNo FROM blocks  where isActive='Y'")->result();
		$GLOBALS['output1']='';
        foreach ($blockinfo as $row1) {
            $GLOBALS['isData2']="1";
            $GLOBALS['output1'] .= '<option value="'.$row1->blockId.'">'.$row1->blockNo.'</option>';

        }
        if (isset($_POST["btnSave"])) {
		$uid2 = $this->db->order_by('serial','desc')->get('employee')->row();	
		$uid1 = explode('EMP',$uid2->empId);
        $prefix = 'EMP';
		$index = $uid1[1]+1;
        $userIds = sprintf("%s%09s", $prefix, $index);
                    $handyCam = new \handyCam\handyCam();
					$sal = (float)$_POST['salary'];
                    $data = array(
                    'empId' => $userIds,
                    'userGroupId' => "UG003",
                    'name' => $_POST['name'],
                    'empType' => $_POST['empType'],
                    'designation' => $_POST['designation'],
                    'cellNo' => $_POST['cellNo'],
                    'gender' => $_POST['gender'],
                    'dob' =>$handyCam->parseAppDate($_POST['dob']),
                    'doj' =>$handyCam->parseAppDate($_POST['doj']),
                    'address' => $_POST['presentAddress'],
                    'blockNo' => $_POST['blockNo'],
                    'salary' => $sal,
                    'isActive' => 'Y'
                );
				if($_FILES['perPhoto']['size'] != 0) {
                       $file_ext = pathinfo($_FILES["perPhoto"]["name"], PATHINFO_EXTENSION);
					   $NewImageName = $userIds.'.'.$file_ext;
					   
			           $_FILES["file"]["name"] = $NewImageName;
					   $_FILES["file"]["type"] = $_FILES["perPhoto"]["type"];
					   $_FILES["file"]["tmp_name"] = $_FILES["perPhoto"]["tmp_name"];
					   $_FILES["file"]["error"] = $_FILES["perPhoto"]["error"];
					   $_FILES["file"]["size"] = $_FILES["perPhoto"]["size"];

					   $config = $this->do_upload1();
					   $config['upload_path'] = 'hostelassets/files/employee/';
					   $this->upload->initialize($config);
					   if($this->upload->do_upload('file'))
					   {
						$ffff = $this->upload->data();
						 $image=$ffff['file_name'];
						 
						 $data['perPhoto'] = 'hostelassets/files/employee/'.$NewImageName;
						 }
				}
                    $result = $this->db->insert("employee", $data);
					if($result) {
                    $userPass = $this->encryption->encrypt($_POST['password']);
                    $data = array(
                        'userId' => $userIds,
                        'userGroupId' => "UG003",
                        'name' => $_POST['name'],
                        'loginId' => $_POST['cellNo'],
                        'password' => $userPass,
                        'verifyCode' => "vhms2115",
                        'expireDate' => "2115-01-4",
                        'isVerifed' => 'Y'
                    );
                    $result=$this->db->insert("users",$data);
                    if($result>=0)
                    {
                        $id =intval($index);

                        $query="UPDATE auto_id set number=".$id." where prefix='EMP';";
                        $result=$this->db->query($query);
                       // $db->close();
                        echo '<script type="text/javascript"> alert("Employee Added Successfully.");</script>';
                    }
                    // var_dump($result);
                    if ($result) {

                        //  $db->close();
						$data['msg']=$this->session->set_flashdata('msg','Employee Added Successfully.','success');	
                        redirect('hosteladminlogin/listEmployee','refresh');
                    }
					}
					elseif (strpos($result, 'Duplicate') !== false) {
						$data['error']=$this->session->set_flashdata('error','Employee Already Exits!','success');	
                        redirect('hosteladminlogin/listEmployee','refresh');
                    } else {
						$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                        redirect('hosteladminlogin/listEmployee','refresh');
                    }
		}
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/employee/add',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');
    }
	public function updateEmployee()
	{
		$GLOBALS['title']="Employee-ERP";
		$emp_Id = $this->uri->segment(3);
		$GLOBALS['data'] = array();
            $result = $this->db->query("SELECT * FROM employee where empId='".$emp_Id."'and isActive='Y'")->result();
		$handyCam = new \handyCam\handyCam();	
		$GLOBALS['data'] = array();
                foreach ($result as $row) {
					$pwd = $this->db->where('userId',$row->empId)->get('users')->row();
					array_push($GLOBALS['data'],$row->name);
                    array_push($GLOBALS['data'],$row->cellNo);
                    array_push($GLOBALS['data'],$row->empType);
                    array_push($GLOBALS['data'],$row->designation);
                    array_push($GLOBALS['data'],$row->gender);
                    array_push($GLOBALS['data'],$handyCam->getAppDate($row->dob));
                    array_push($GLOBALS['data'],$handyCam->getAppDate($row->doj));
                    array_push($GLOBALS['data'],$row->blockNo);
                    array_push($GLOBALS['data'],$row->salary);
                    array_push($GLOBALS['data'],$row->address);
                    array_push($GLOBALS['data'],$this->encryption->decrypt($pwd->password));
                    array_push($GLOBALS['data'],$row->empId);

                }
		$blockinfo = $this->db->query("SELECT blockId,blockNo FROM blocks  where isActive='Y'")->result();
		$GLOBALS['output1']='';
        foreach ($blockinfo as $row1) {
			if($row1->blockId==$GLOBALS['data'][7]){$selected='selected';}else{$selected='';}
            $GLOBALS['isData2']="1";
            $GLOBALS['output1'] .= '<option value="'.$row1->blockId.'" '.$selected.'>'.$row1->blockNo.'</option>';

        }	
        if (isset($_POST["btnUpdate"])) {
            $empId = $_POST['edit_id'];
                        $sal = (float)$_POST['salary'];
                    $handyCam = new \handyCam\handyCam();
                    $dob = $handyCam->parseAppDate($_POST['dob']);
                    $doj = $handyCam->parseAppDate($_POST['doj']);
                    $data = array(
                        'name' => $_POST['name'],
                        'empType' => $_POST['empType'],
                        'designation' => $_POST['designation'],
                        'cellNo' => $_POST['cellNo'],
                        'gender' => $_POST['gender'],
                        'dob' =>$dob,
                        'doj' => $doj,
                        'address' => $_POST['presentAddress'],
                        'blockNo' => $_POST['blockNo'],
                        'salary' => $sal,

                        'isActive' => 'Y'
                    );
					if($_FILES['perPhoto']['size'] != 0) {
                       $file_ext = pathinfo($_FILES["perPhoto"]["name"], PATHINFO_EXTENSION);
					   $NewImageName = $empId.'.'.$file_ext;
					   
			           $_FILES["file"]["name"] = $NewImageName;
					   $_FILES["file"]["type"] = $_FILES["perPhoto"]["type"];
					   $_FILES["file"]["tmp_name"] = $_FILES["perPhoto"]["tmp_name"];
					   $_FILES["file"]["error"] = $_FILES["perPhoto"]["error"];
					   $_FILES["file"]["size"] = $_FILES["perPhoto"]["size"];

					   $config = $this->do_upload1();
					   $config['upload_path'] = 'hostelassets/files/employee/';
					   $this->upload->initialize($config);
					   if($this->upload->do_upload('file'))
					   {
						$ffff = $this->upload->data();
						 $image=$ffff['file_name'];
						 
						 $data['perPhoto'] = 'hostelassets/files/employee/'.$NewImageName;
						 }
				}
                        $this->db->where('empId',$empId);
                        $result = $this->db->update("employee", $data);
						if($result) {
                        $userPass = $this->encryption->encrypt($_POST['password']);
                        $data = array(
                            'password' => $userPass,

                        );
						$this->db->where('userId',$empId);
                        $result=$this->db->update("users",$data);
						}
                        if ($result) {
							$data['msg']=$this->session->set_flashdata('msg','Employee Updated Successfully.','success');	
                            redirect('hosteladminlogin/listEmployee','refresh');
                        } else {
                            $data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                            redirect('hosteladminlogin/listEmployee','refresh');
                        }
                    }
	$this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/employee/edit',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');			
    }
	public function deleteEmployee()
	{
		$empId = $this->uri->segment(3);
		$data = array(

                'isActive' => 'N'
            );
		$this->db->where('empId',$empId);	
		$query=$this->db->update('employee',$data);	
				if ($query) 
				{
	    			$data['msg']=$this->session->set_flashdata('msg','Employee deleted successfully','success');	
                    redirect('hosteladminlogin/listEmployee','refresh');
				} 
				else 
				{
					$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                    redirect('hosteladminlogin/listEmployee','refresh');
				}
		
	}
	
	public function listSalary()
	{
		$GLOBALS['title']="Employee-ERP";
		$GLOBALS['sal_list'] = $this->db->query("SELECT a.serial,a.empId,b.name,a.monthyear,a.amount,DATE_FORMAT(a.addedDate, '%D %M,%Y') as date from salary as a, employee as b where a.empId = b.empId")->result();
		$GLOBALS['handyCam'] = new \handyCam\handyCam();
    
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/employee/salaryview',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');
    }
	public function addSalary()
	{
		$GLOBALS['title']="Salary-ERP";
		$empinfo = $this->db->query("SELECT empId,name FROM employee  where isActive='Y'")->result();
		$GLOBALS['output1']='';
        foreach ($empinfo as $row1) {
            $GLOBALS['isData2']="1";
            $GLOBALS['output1'] .= '<option value="'.$row1->empId.'">'.$row1->name.'</option>';

        }
        if (isset($_POST["btnSave"])) {
                    $handyCam = new \handyCam\handyCam();
                    $data = array(
                    'empId' => $_POST['empId'],

                    'monthyear' => $_POST['monthyear'],
                    'amount' => floatval($_POST['amount']),
                    'addedDate' =>date("Y-m-d"),

                );
                    $result = $this->db->insert("salary", $data);
                    if ($result) {

                        //  $db->close();
						$data['msg']=$this->session->set_flashdata('msg','Salary Added Successfully.','success');	
                        redirect('hosteladminlogin/listSalary','refresh');
                    }else {
						$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                        redirect('hosteladminlogin/listSalary','refresh');
                    }
		}
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/employee/salaryadd',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');
    }
	public function updateSalary()
	{
		$GLOBALS['title']="Salary-ERP";
		$serial = $this->uri->segment(3);
		$GLOBALS['data'] = array();
            $result = $this->db->query("SELECT * FROM salary where serial='".$serial."'")->result();
		$handyCam = new \handyCam\handyCam();	
		$GLOBALS['data'] = array();
                foreach ($result as $row) {
					array_push($GLOBALS['data'],$row->empId);
                    array_push($GLOBALS['data'],$row->monthYear);
                    array_push($GLOBALS['data'],$row->amount);
                    array_push($GLOBALS['data'],$row->serial);

                }
		$empinfo = $this->db->query("SELECT empId,name FROM employee  where isActive='Y'")->result();
		$GLOBALS['output1']='';
        foreach ($empinfo as $row1) {
			if($row1->empId==$GLOBALS['data'][3]){$selected='selected';}else{$selected='';}
            $GLOBALS['isData2']="1";
            $GLOBALS['output1'] .= '<option value="'.$row1->empId.'" '.$selected.'>'.$row1->name.'</option>';

        }	
        if (isset($_POST["btnUpdate"])) {
            $userId = $_POST['edit_id'];
                    $handyCam = new \handyCam\handyCam();
                    $data = array(

                    'monthYear' => $_POST['monthyear'],
                    'amount' => floatval($_POST['amount']),
                    'addedDate' =>date("Y-m-d"),


                );
                        $this->db->where('serial',$userId);
                        $result = $this->db->update("salary", $data);
                        if ($result) {
							$data['msg']=$this->session->set_flashdata('msg','Salary Updated Successfully.','success');	
                            redirect('hosteladminlogin/listSalary','refresh');
                        } else {
                            $data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                            redirect('hosteladminlogin/listSalary','refresh');
                        }
                    }
	$this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/employee/salaryedit',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');			
    }
	public function deleteSalary()
	{
		$serial = $this->uri->segment(3);
		$sql="delete from salary where serial='".$serial."'";	
				if ($this->db->query($sql)) 
				{
	    			$data['msg']=$this->session->set_flashdata('msg','Salary deleted successfully','success');	
                    redirect('hosteladminlogin/listSalary','refresh');
				} 
				else 
				{
					$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                    redirect('hosteladminlogin/listSalary','refresh');
				}
		
	}
	
	public function listVendorPayment()
	{
		$GLOBALS['title']="Employee-ERP";
		$GLOBALS['vendorpay_list'] = $this->db->query("SELECT * FROM payment")->result();
		$GLOBALS['handyCam'] = new \handyCam\handyCam();
    
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/payment/view',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');
    }
	public function addVendorPayment()
	{
		$GLOBALS['title']="Salary-ERP";
		$empinfo = $this->db->query("SELECT empId,name FROM employee  where isActive='Y'")->result();
		$GLOBALS['output1']='';
        foreach ($empinfo as $row1) {
            $GLOBALS['isData2']="1";
            $GLOBALS['output1'] .= '<option value="'.$row1->empId.'">'.$row1->name.'</option>';

        }
        if (isset($_POST["btnSave"])) {
                    $handyCam = new \handyCam\handyCam();
                    $data = array(
                    'paymentTo' => $_POST['paymentTo'],
                    'amount' => floatval($_POST['amount']),
                    'paymentDate' =>date("Y-m-d"),
                    'paymentBy'     => $_POST['paymentBy'],
                    'description' => $_POST['description']

                );
                    $result = $this->db->insert("payment", $data);
                    if ($result) {

                        //  $db->close();
						$data['msg']=$this->session->set_flashdata('msg','Payment Added Successfully.','success');	
                        redirect('hosteladminlogin/listVendorPayment','refresh');
                    }elseif (strpos($result, 'Duplicate') !== false) {
						$data['error']=$this->session->set_flashdata('error','Payment Already Exits!','success');	
                        redirect('hosteladminlogin/listEmployee','refresh');
                    } else {
						$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                        redirect('hosteladminlogin/listVendorPayment','refresh');
                    }
		}
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/payment/create',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');
    }
	public function updateVendorPayment()
	{
		$GLOBALS['title']="Salary-ERP";
		$serial = $this->uri->segment(3);
		$GLOBALS['data'] = array();
            $result = $this->db->query("SELECT * FROM payment where serial='".$serial."'")->result();
		$handyCam = new \handyCam\handyCam();	
		$GLOBALS['data'] = array();
                foreach ($result as $row) {
					array_push($GLOBALS['data'],$row->paymentTo);
                    array_push($GLOBALS['data'],$row->amount);
                    array_push($GLOBALS['data'],$row->paymentBy);
                    array_push($GLOBALS['data'],$row->description);
                    array_push($GLOBALS['data'],$row->serial);

                }
        if (isset($_POST["btnUpdate"])) {
            $userId = $_POST['edit_id'];
                    $handyCam = new \handyCam\handyCam();
                    $data = array(

                    'paymentTo' => $_POST['paymentTo'],
                    'amount' => floatval($_POST['amount']),
                    'paymentDate' =>date("Y-m-d"),
                    'paymentBy'     => $_POST['paymentBy'],
                    'description' => $_POST['description']

                );
                        $this->db->where('serial',$userId);
                        $result = $this->db->update("payment", $data);
                        if ($result) {
							$data['msg']=$this->session->set_flashdata('msg','Payment Updated Successfully.','success');	
                            redirect('hosteladminlogin/listVendorPayment','refresh');
                        } else {
                            $data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                            redirect('hosteladminlogin/listVendorPayment','refresh');
                        }
                    }
	$this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/payment/edit',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');			
    }
	public function deleteVendorPayment()
	{
		$serial = $this->uri->segment(3);
		$sql="delete from payment where serial='".$serial."'";	
				if ($this->db->query($sql)) 
				{
	    			$data['msg']=$this->session->set_flashdata('msg','Payment deleted successfully','success');	
                    redirect('hosteladminlogin/listVendorPayment','refresh');
				} 
				else 
				{
					$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                    redirect('hosteladminlogin/listVendorPayment','refresh');
				}
		
	}
	
	public function listBill()
	{
		$GLOBALS['title']="Bill-ERP";
		$GLOBALS['bill_list'] = $this->db->query("SELECT a.billId,b.name,sum(a.amount) as amount,DATE_FORMAT(a.billingDate,'%D %M,%Y') as date from billing as a,studentinfo as b where a.billTo=b.userId and b.isActive='Y' group by billId")->result();
		$GLOBALS['handyCam'] = new \handyCam\handyCam();
    
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/bill/view',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');
    }
	public function addBill()
	{
		$GLOBALS['title']="Bill-ERP";
		$studentinfo = $this->db->query("SELECT userId,name FROM studentinfo  where isActive='Y'")->result();
		$GLOBALS['output']='';
        foreach ($studentinfo as $row) {
            $GLOBALS['isData']="1";
            $GLOBALS['output'] .= '<option value="'.$row->userId.'">'.$row->name.'</option>';

        }
        if (isset($_POST["btnSave"])) {
		$uid2 = $this->db->order_by('id','desc')->get('billing')->row();	
		$uid1 = explode('BIL',$uid2->billId);
        $prefix = 'BIL';
		$index = $uid1[1]+1;
        $userIds = sprintf("%s%09s", $prefix, $index);
                    $handyCam = new \handyCam\handyCam();
					$userId = $_POST['person'];

            $rows = sizeof($_POST['type']);
            $count = 0;
            for ($i = 0; $i < $rows; $i++) {
                if ($_POST['type'][$i] !== "" && $_POST['amount'][$i] !== "") {

                    $data = array(
                        'billId' => $userIds,
                        'type' => $_POST['type'][$i],
                        'amount' => $_POST['amount'][$i],
                        'billTo' => $userId,
                        'billingDate' => date("Y-m-d")
                    );

                    $result = $this->db->insert("billing", $data);
                    if ($result >= 0) {
                        $count++;
                    }
                }


            }
					
                    if($result)
                    {
                        $id =intval($index);

                        $query="UPDATE auto_id set number=" . $id . " where prefix='BIL'";
                        $result=$this->db->query($query);
                       // $db->close();
                        $data['msg']=$this->session->set_flashdata('msg','Bill ['.$userIds.'] added successfully.','success');	
                        redirect('hosteladminlogin/listBill','refresh');
                    }
                    // var_dump($result);
					elseif (strpos($result, 'Duplicate') !== false) {
						$data['error']=$this->session->set_flashdata('error','Bill Already Exits!','success');	
                        redirect('hosteladminlogin/listBill','refresh');
                    } else {
						$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                        redirect('hosteladminlogin/listBill','refresh');
                    }
		}
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/bill/add',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');
    }
	public function singleBill()
	{
		$GLOBALS['title']="Bill-ERP";
		$billId = $GLOBALS['billId'] = $this->uri->segment(3);
		$userId = $this->session->userdata('user')['user_id'];
		$GLOBALS['bill_single']=$bill_single=$this->db->query("SELECT a.billId,b.name,a.type,a.amount,DATE_FORMAT(a.billingDate,'%D %M,%Y') as date from billing as a,studentinfo as b where a.billTo=b.userId and  a.billId='" . $billId . "'")->result();
		$result = $this->db->query("SELECT a.billId,b.name,sum(a.amount) as total,DATE_FORMAT(a.billingDate,'%D %M,%Y') as date from billing as a,studentinfo as b where a.billTo=b.userId and  a.billId='" . $billId . "'")->result();
		$handyCam = new \handyCam\handyCam();	
		$GLOBALS['billInfo'] = array();
                foreach ($result as $row) {
					array_push($GLOBALS['billInfo'],$row->name);
                    array_push($GLOBALS['billInfo'],$row->date);
                    array_push($GLOBALS['billInfo'],$row->total);

                }
		if(isset($_POST["btnPrint"])) {
			$bill_Id = $this->input->post('bill_id');
			$this->printBill($bill_Id);
		}			
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/bill/single',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');
	}
	public function actionBill()
	{
		$GLOBALS['title']="Bill-ERP";
		$billId = $GLOBALS['billId'] = $this->uri->segment(3);
		$userId = $this->session->userdata('user')['user_id'];
		$GLOBALS['billaction']=$this->db->where('billId',$billId)->get('billing')->result();
        if (isset($_POST["btnSave"])) {
			$bill_Id = $_POST['edit_id'];
			$bill_to = $_POST['bill_to'];
                    $handyCam = new \handyCam\handyCam();
		$this->db->where('billId',$bill_Id)->delete('billing');			
        $rows = sizeof($_POST['type']);
                    for ($i = 0; $i < $rows; $i++) {
            if ($_POST['type'][$i] !== "" && $_POST['amount'][$i] !== "") {

                $data = array(
                     'billId' => $bill_Id,
                    'type' => $_POST['type'][$i],
                    'amount' => $_POST['amount'][$i],
                    'billTo' => $bill_to,
                    //'userId'    =>$userId,
                    'billingDate' => date("Y-m-d")
                );

                $result = $this->db->insert("billing", $data);
                if ($result) {
                    $count++;
                }
             //echo  $_POST['type'][$i].'='.$_POST['amount'][$i];
            }


        }
                    if ($rows == $count) {

                        //  $db->close();
						$data['msg']=$this->session->set_flashdata('msg','Bill ['.$bill_Id.'] updated successfull.','success');	
                        redirect('hosteladminlogin/listBill','refresh');
                    }else {
						$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                        redirect('hosteladminlogin/listBill','refresh');
                    }
		}
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/bill/action',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');
    }
	public function deleteBill()
	{
		$billId = $this->uri->segment(3);
		$sql="delete from billing where billId='".$billId."'";	
				if ($this->db->query($sql)) 
				{
	    			$data['msg']=$this->session->set_flashdata('msg','Bill deleted successfully','success');	
                    redirect('hosteladminlogin/listBill','refresh');
				} 
				else 
				{
					$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                    redirect('hosteladminlogin/listBill','refresh');
				}
		
	}
	function  printBill($billId)
{
	    $GLOBALS['billId'] = $billId;
		$GLOBALS['bill_single']=$bill_single=$this->db->query("SELECT a.billId,b.name,a.type,a.amount,DATE_FORMAT(a.billingDate,'%D %M,%Y') as date from billing as a,studentinfo as b where a.billTo=b.userId and  a.billId='" . $billId . "'")->result();
		$result = $this->db->query("SELECT a.billId,b.name,sum(a.amount) as total,DATE_FORMAT(a.billingDate,'%D %M,%Y') as date from billing as a,studentinfo as b where a.billTo=b.userId and  a.billId='" . $billId . "'")->result();
		$handyCam = new \handyCam\handyCam();	
		$GLOBALS['billInfo'] = array();
                foreach ($result as $row) {
					array_push($GLOBALS['billInfo'],$row->name);
                    array_push($GLOBALS['billInfo'],$row->date);
                    array_push($GLOBALS['billInfo'],$row->total);

                }
    $html = $this->load->view('hosteladmin/ui/bill/billPDF',$GLOBALS,true);
$dompdf = new \Dompdf\Dompdf(); 
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("Billing_".date('d-m-Y').".pdf", array("Attachment"=>1));

}

public function listNotice()
	{
		$GLOBALS['title']="Notice-ERP";
		$GLOBALS['notice_list'] = $this->db->query("SELECT * FROM notice")->result();
		$GLOBALS['handyCam'] = new \handyCam\handyCam();
    
        if (isset($_POST["btnSave"])) {
                    $handyCam = new \handyCam\handyCam();
                    $data = array(


                    'title' => $_POST['title'],
                    'description' => $_POST['description'],

                    'createdDate' =>$dateNow=date("Y-m-d H:i:s")

                );
                    $result = $this->db->insert("notice", $data);
                    // var_dump($result);
                    if ($result) {

                        //  $db->close();
						$data['msg']=$this->session->set_flashdata('msg','Notice Added Successfully.','success');	
                        redirect('hosteladminlogin/listNotice','refresh');
                    } else {
						$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                        redirect('hosteladminlogin/listNotice','refresh');
                    }
        }
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/notice/create',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');
    }
	public function updateNotice()
	{
		$GLOBALS['title']="Notice-ERP";
		$serial = $this->uri->segment(3);
		$GLOBALS['data'] = array();
            $result = $this->db->query("SELECT * FROM notice where serial='".$serial."' ")->result();
		$handyCam = new \handyCam\handyCam();	
		$GLOBALS['data'] = array();
                foreach ($result as $row) {
                    array_push($GLOBALS['data'],$row->title);
                    array_push($GLOBALS['data'],$row->description);
                    array_push($GLOBALS['data'],$row->serial);

                }
        if (isset($_POST["btnUpdate"])) {
            $serialFor = $_POST['edit_id'];
                        $handyCam = new \handyCam\handyCam();
                       $data = array(

                    'title' => $_POST['title'],
                    'description' => $_POST['description'],
                    'createdDate' => $dateNow=date("Y-m-d H:i:s")


                );
                        $this->db->where('serial',$serialFor);
                        $result = $this->db->update("notice", $data);
                        if ($result) {
							$data['msg']=$this->session->set_flashdata('msg','Notice Info Updated Successfully.','success');	
                            redirect('hosteladminlogin/listNotice','refresh');
                        } else {
                            $data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                            redirect('hosteladminlogin/listNotice','refresh');
                        }
                    }
	$this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/notice/noticeaction',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');			
    }
	public function deleteNotice()
	{
		$noticeid = $this->uri->segment(3);
				$sql = "delete from notice where serial='".$noticeid."'";
				if ($this->db->query($sql) === TRUE) 
				{
	    			$data['msg']=$this->session->set_flashdata('msg','Notice deleted successfully','success');	
                    redirect('hosteladminlogin/listNotice','refresh');
				} 
				else 
				{
					$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                    redirect('hosteladminlogin/listNotice','refresh');
				}
		
	}
	
	public function listFees()
	{
		$GLOBALS['title']="Fees-ERP";
		$GLOBALS['fees_list'] = $this->db->query("SELECT * FROM feesinfo")->result();
		$GLOBALS['handyCam'] = new \handyCam\handyCam();
    
        if (isset($_POST["btnSave"])) {
                    $handyCam = new \handyCam\handyCam();
					$amount = (float)$_POST['amount'];
                    $data = array(

                    'type' => $_POST['type'],
                    'description' => $_POST['description'],
                    'amount' => $amount,

                );
                    $result = $this->db->insert("feesinfo", $data);
                    // var_dump($result);
                    if ($result) {

                        //  $db->close();
						$data['msg']=$this->session->set_flashdata('msg','Fees Added Successfully.','success');	
                        redirect('hosteladminlogin/listFees','refresh');
                    } else {
						$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                        redirect('hosteladminlogin/listFees','refresh');
                    }
        }
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/setup/fees',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');
    }
	public function updateFees()
	{
		$GLOBALS['title']="Fees-ERP";
		$serial = $this->uri->segment(3);
		$GLOBALS['data'] = array();
            $result = $this->db->query("SELECT * FROM feesinfo where serial='".$serial."' ")->result();
		$handyCam = new \handyCam\handyCam();	
		$GLOBALS['data'] = array();
                foreach ($result as $row) {
                    array_push($GLOBALS['data'],$row->type);
                    array_push($GLOBALS['data'],$row->description);
                    array_push($GLOBALS['data'],$row->amount);
                    array_push($GLOBALS['data'],$row->serial);

                }
        if (isset($_POST["btnUpdate"])) {
            $serialFor = $_POST['edit_id'];
                        $handyCam = new \handyCam\handyCam();
                       $amount = (float)$_POST['amount'];
                $data = array(

                    'type' => $_POST['type'],
                    'description' => $_POST['description'],
                    'amount' => $amount,

                );
                        $this->db->where('serial',$serialFor);
                        $result = $this->db->update("feesinfo", $data);
                        if ($result) {
							$data['msg']=$this->session->set_flashdata('msg','Fees Info Updated Successfully.','success');	
                            redirect('hosteladminlogin/listFees','refresh');
                        } else {
                            $data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                            redirect('hosteladminlogin/listFees','refresh');
                        }
                    }
	$this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/setup/feesaction',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');			
    }
	public function deleteFees()
	{
		$feesid = $this->uri->segment(3);
				$sql = "delete from feesinfo where serial='".$feesid."'";
				if ($this->db->query($sql) === TRUE) 
				{
	    			$data['msg']=$this->session->set_flashdata('msg','Fees deleted successfully','success');	
                    redirect('hosteladminlogin/listFees','refresh');
				} 
				else 
				{
					$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                    redirect('hosteladminlogin/listFees','refresh');
				}
		
	}
	
	public function listRoom()
	{
		$GLOBALS['title']="Room-ERP";
		$GLOBALS['room_list'] = $this->db->query("SELECT * FROM rooms where isActive='Y'")->result();
		$GLOBALS['handyCam'] = new \handyCam\handyCam();
		$blockinfo = $this->db->query("SELECT blockId,blockNo FROM blocks  where isActive='Y'")->result();
		$GLOBALS['output1']='';
        foreach ($blockinfo as $row1) {
            $GLOBALS['isData2']="1";
            $GLOBALS['output1'] .= '<option value="'.$row1->blockId.'">'.$row1->blockNo.'</option>';

        }
    
        if (isset($_POST["btnSave"])) {
		$uid2 = $this->db->order_by('roomId','desc')->get('rooms')->row();	
		$uid1 = explode('RM',$uid2->roomId);
        $prefix = 'RM';
		$index = $uid1[1]+1;
        $userIds = sprintf("%s%09s", $prefix, $index);
                    $handyCam = new \handyCam\handyCam();
					$data = array(

                    'roomId' => $userIds,
                    'roomNo' => $_POST['roomNo'],
                    'blockId' => $_POST['blockId'],
                    'description' => $_POST['description'],
                    'noOfSeat' => $_POST['noOfSeat'],
                    'isActive'      => 'Y'

                );
                    $result = $this->db->insert("rooms", $data);
                    // var_dump($result);
                    if ($result) {

                        $id =intval($index);

                    $query="UPDATE auto_id set number=".$id." where prefix='RM'";
                    $result=$this->db->query($query);
						$data['msg']=$this->session->set_flashdata('msg','Room Added Successfully.','success');	
                        redirect('hosteladminlogin/listRoom','refresh');
                    } else {
						$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                        redirect('hosteladminlogin/listRoom','refresh');
                    }
        }
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/setup/room',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');
    }
	public function updateRoom()
	{
		$GLOBALS['title']="Room-ERP";
		$roomid = $this->uri->segment(3);
		$GLOBALS['data'] = array();
            $result = $this->db->query("SELECT * FROM rooms where roomId='".$roomid."' ")->result();
		$handyCam = new \handyCam\handyCam();
		$GLOBALS['data'] = array();
                foreach ($result as $row) {
                    array_push($GLOBALS['data'],$row->roomNo);
                    array_push($GLOBALS['data'],$row->noOfSeat);
                    array_push($GLOBALS['data'],$row->blockId);
                    array_push($GLOBALS['data'],$row->description);
                    array_push($GLOBALS['data'],$row->roomId);

                }
		$blockinfo = $this->db->query("SELECT blockId,blockNo FROM blocks  where isActive='Y'")->result();
		$GLOBALS['output1']='';
        foreach ($blockinfo as $row1) {
			if($row1->blockId==$GLOBALS['data'][2]){$selected='selected';}else{$selected='';}
            $GLOBALS['isData2']="1";
            $GLOBALS['output1'] .= '<option value="'.$row1->blockId.'" '.$selected.'>'.$row1->blockNo.'</option>';

        }		
        if (isset($_POST["btnUpdate"])) {
            $roomId = $_POST['edit_id'];
                        $handyCam = new \handyCam\handyCam();
                $data = array(
                    'roomNo' => $_POST['roomNo'],
                    'blockId' => $_POST['blockId'],
                    'description' => $_POST['description'],
                    'noOfSeat' => $_POST['noOfSeat'],

                );
                        $this->db->where('roomId',$roomId);
                        $result = $this->db->update("rooms", $data);
                        if ($result) {
							$data['msg']=$this->session->set_flashdata('msg','Room Info Updated Successfully.','success');	
                            redirect('hosteladminlogin/listRoom','refresh');
                        } else {
                            $data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                            redirect('hosteladminlogin/listRoom','refresh');
                        }
                    }
	$this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/setup/roomaction',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');			
    }
	public function deleteRoom()
	{
		$roomId = $this->uri->segment(3);
				$sql = "delete from rooms where roomId='".$roomId."'";
				if ($this->db->query($sql) === TRUE) 
				{
	    			$data['msg']=$this->session->set_flashdata('msg','Room deleted successfully','success');	
                    redirect('hosteladminlogin/listRoom','refresh');
				} 
				else 
				{
					$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                    redirect('hosteladminlogin/listRoom','refresh');
				}
		
	}
	
	public function listBlock()
	{
		$GLOBALS['title']="Block-ERP";
		$GLOBALS['block_list'] = $this->db->query("SELECT * FROM blocks where isActive='Y'")->result();
		$GLOBALS['handyCam'] = new \handyCam\handyCam();
    
        if (isset($_POST["btnSave"])) {
		$uid2 = $this->db->order_by('blockId','desc')->get('blocks')->row();	
		$uid1 = explode('BL',$uid2->blockId);
        $prefix = 'BL';
		$index = $uid1[1]+1;
        $userIds = sprintf("%s%09s", $prefix, $index);
                    $handyCam = new \handyCam\handyCam();
					$data = array(

                    'blockId' => $userIds,
                    'blockNo' => $_POST['blockNo'],
                    'blockName' => $_POST['blockName'],
                    'description' => $_POST['description'],
                    'isActive'      => 'Y'

                );
                    $result = $this->db->insert("blocks", $data);
                    // var_dump($result);
                    if ($result) {

                        $id =intval($index);

                    $query="UPDATE auto_id set number=".$id." where prefix='BL'";
                    $result=$this->db->query($query);
						$data['msg']=$this->session->set_flashdata('msg','Block Added Successfully.','success');	
                        redirect('hosteladminlogin/listBlock','refresh');
                    } else {
						$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                        redirect('hosteladminlogin/listBlock','refresh');
                    }
        }
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/setup/block',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');
    }
	public function updateBlock()
	{
		$GLOBALS['title']="Block-ERP";
		$blockId = $this->uri->segment(3);
		$GLOBALS['data'] = array();
            $result = $this->db->query("SELECT * FROM blocks where blockId='".$blockId."'")->result();
		$handyCam = new \handyCam\handyCam();
		$GLOBALS['data'] = array();
                foreach ($result as $row) {
                    array_push($GLOBALS['data'],$row->blockNo);
                    array_push($GLOBALS['data'],$row->blockName);
                    array_push($GLOBALS['data'],$row->description);
                    array_push($GLOBALS['data'],$row->blockId);

                }
        if (isset($_POST["btnUpdate"])) {
            $blockId = $_POST['edit_id'];
                        $handyCam = new \handyCam\handyCam();
                $data = array(

                    'blockNo' => $_POST['blockNo'],
                    'description' => $_POST['description'],
                    'blockName' =>$_POST['blockName']

                );
                        $this->db->where('blockId',$blockId);
                        $result = $this->db->update("blocks", $data);
                        if ($result) {
							$data['msg']=$this->session->set_flashdata('msg','Block Info Updated Successfully.','success');	
                            redirect('hosteladminlogin/listBlock','refresh');
                        } else {
                            $data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                            redirect('hosteladminlogin/listBlock','refresh');
                        }
                    }
	$this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/setup/blockaction',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');			
    }
	public function deleteBlock()
	{
		$blockId = $this->uri->segment(3);
				$sql = "delete from blocks where blockId='".$blockId."'";
				if ($this->db->query($sql) === TRUE) 
				{
	    			$data['msg']=$this->session->set_flashdata('msg','Block deleted successfully','success');	
                    redirect('hosteladminlogin/listBlock','refresh');
				} 
				else 
				{
					$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                    redirect('hosteladminlogin/listBlock','refresh');
				}
		
	}
	
	public function addMealRate()
	{
		$GLOBALS['title']="Meal Rate - ERP";
		$GLOBALS['data'] = array();
            $result = $this->db->query("SELECT * FROM mealrate")->result();
		$handyCam = new \handyCam\handyCam();
		$GLOBALS['data'] = array();
		if(sizeof($result)>0){
                foreach ($result as $row) {
                    array_push($GLOBALS['data'],$row->rate);
                    array_push($GLOBALS['data'],$row->note);

                }
		}else{
			array_push($GLOBALS['data'],"");
            array_push($GLOBALS['data'],"");}
			
        if (isset($_POST["btnSave"])) {
                        $handyCam = new \handyCam\handyCam();
                $data = array(

                    'rate' => $_POST['rate'],
                    'note' => $_POST['note'],

                );
				
			if(sizeof($result)>0){
                        $result = $this->db->update("mealrate", $data);
			}else{
				        $result = $this->db->insert("mealrate", $data);
			}
                        if ($result) {
							$data['msg']=$this->session->set_flashdata('msg','Meal Rate Updated Successfully.','success');	
                            redirect('hosteladminlogin/addMealRate','refresh');
                        } else {
                            $data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                            redirect('hosteladminlogin/addMealRate','refresh');
                        }
                    }
	$this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/setup/mealrate',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');			
    }
	
	public function addInstallmentRate()
	{
		$GLOBALS['title']="Installment Rate - ERP";
		$GLOBALS['data'] = array();
            $result = $this->db->query("SELECT * FROM installmentrate")->result();
		$handyCam = new \handyCam\handyCam();
		$GLOBALS['data'] = array();
		if(sizeof($result)>0){
                foreach ($result as $row) {
                    array_push($GLOBALS['data'],$row->installment1);
                    array_push($GLOBALS['data'],$row->installment2);

                }
		}else{
			array_push($GLOBALS['data'],"");
            array_push($GLOBALS['data'],"");}
			
        if (isset($_POST["btnSave"])) {
                        $handyCam = new \handyCam\handyCam();
                $data = array(

                    'installment1' => $_POST['installment1'],
                    'installment2' => $_POST['installment2'],

                );
				
			if(sizeof($result)>0){
                        $result = $this->db->update("installmentrate", $data);
			}else{
				        $result = $this->db->insert("installmentrate", $data);
			}
                        if ($result) {
							$data['msg']=$this->session->set_flashdata('msg','Installment Rate Updated Successfully.','success');	
                            redirect('hosteladminlogin/addInstallmentRate','refresh');
                        } else {
                            $data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                            redirect('hosteladminlogin/addInstallmentRate','refresh');
                        }
                    }
	$this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/setup/installmentrate',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');			
    }
	
	public function addTimeset()
	{
		$GLOBALS['title']="Timeset-ERP";
		$GLOBALS['data'] = array();
            $result = $this->db->query("SELECT * FROM timeset")->result();
		$handyCam = new \handyCam\handyCam();
		$GLOBALS['data'] = array();
		if(sizeof($result)>0){
                foreach ($result as $row) {
                    array_push($GLOBALS['data'],$row->inTime);
                    array_push($GLOBALS['data'],$row->outTime);

                }
		}else{
			array_push($GLOBALS['data'],"");
            array_push($GLOBALS['data'],"");}
			
        if (isset($_POST["btnSave"])) {
                        $handyCam = new \handyCam\handyCam();
                $data = array(

                    'inTime' => $_POST['start_time'],
                    'outTime' => $_POST['end_time'],

                );
				
			if(sizeof($result)>0){
                        $result = $this->db->update("timeset", $data);
			}else{
				        $result = $this->db->insert("timeset", $data);
			}
                        if ($result) {
							$data['msg']=$this->session->set_flashdata('msg','Timeset Updated Successfully.','success');	
                            redirect('hosteladminlogin/addTimeset','refresh');
                        } else {
                            $data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                            redirect('hosteladminlogin/addTimeset','refresh');
                        }
                    }
	$this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/setup/timeset',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');			
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
		$GLOBALS['title']="Student Announcements";
		$user = $this->session->userdata("user")["user_id"];

		date_default_timezone_get();
		$add_date = date('Y-m-d h:i:s');
		$data['announsment'] = $this->db
		->from('announcement')
		->join(
			"department_details",
			"announcement.ann_main = department_details.main_id AND announcement.ann_course = department_details.cour_id","left"
		)
		->where('ann_hostel', $user)->get()->result();
		if (isset($_POST['submit'])) {
			$data_ann['ann_main'] = $main_course_id = $this->input->post('main_course_id');
			$data_ann['ann_course'] = $app_course_id = $this->input->post('app_course_id');
			$data_ann['ann_name'] = $this->input->post('title');
			$data_ann['ann_desc'] = $this->input->post('remark');
			$data_ann['ann_batch'] = $this->input->post('batch');
			$data_ann['ann_year'] = $this->input->post('year');
			$data_ann['ann_date_till'] = $this->input->post('date_till');
			$data_ann['ann_hostel'] = $user;
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
			
			$data['msg']=$this->session->set_flashdata('msg','Announcements Updated Successfully.','success');
			redirect('hosteladminlogin/studentannouncements', 'refresh');
		}

	$this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/announcements',$data);
    $this->load->view('hosteladmin/template/footer');	
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
	
	public function studentHostel()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['stream1']='';
		$data['department1']='';
		$data['batch1']='';
		
		if(isset($_POST['submit'])){
			$data['stream1']=$stream = $this->input->post('stream');
			$data['department1']=$department = $this->input->post('department');
			$data['batch1']=$batch = $this->input->post('batch');
			$yr = substr($batch,-2);
		$data['stu_list'] = $this->db->select('admitted_student.*')
		->join('shotlisted_candidate','admitted_student.as_shotlist_ref_number=shotlisted_candidate.sl_id')
		->where('shotlisted_candidate.sl_main_id',$stream)
		->where('shotlisted_candidate.sl_course_id',$department)
		->where('RIGHT(SUBSTRING_INDEX(admitted_student.as_app_number, "-", 2),2)='.$yr.'')
		->get('admitted_student')->result();
		}
		
	$this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/studentManage/studentHostel',$data);
    $this->load->view('hosteladmin/template/footer');		
	}
	public function markHostel()
	{
		$add_date = date('Y-m-d');
	$hostel=$this->input->post('ids_hostel');
	$not_hostel=$this->input->post('ids_not_hostel');
	if($hostel==''){$hostel=array();}
	if($not_hostel==''){$not_hostel=array();}
	$stream = $this->input->post('stream');
	$department = $this->input->post('department');
	$batch = $this->input->post('batch');
	//$hostel=array('117');
	//$not_hostel=array('');
	//$stream = 1;
	//$department = 6;
	//$batch = 2021;
	
	for($i=0; $i<sizeof($hostel); $i++){
	$data['hostel_status']='1';
	 $this->db->where('as_id',$hostel[$i]);	
	$this->db->update('admitted_student',$data);
	if($stream=='5'){
				$this->db->select('admitted_student.*,new_preview.*,department_details.short_name,stu_user.*');
				$this->db->join('new_preview','admitted_student.as_student_id=new_preview.pr_user_id', 'left');
			}
			elseif($stream=='4'){
				$this->db->select('admitted_student.*,new_preview_dip.*,department_details.short_name,stu_user.*');
				$this->db->join('new_preview_dip','admitted_student.as_student_id=new_preview_dip.pr_user_id', 'left');
			}else{
				$this->db->select('admitted_student.*,new_preview_pg.*,department_details.short_name,stu_user.*');
				$this->db->join('new_preview_pg','admitted_student.as_student_id=new_preview_pg.pr_user_id', 'left');
			}
	$get_stu = $this->db->join('department_details','(department_details.main_id='.$stream.' AND department_details.cour_id='.$department.')')->join('stu_user','admitted_student.as_student_id=stu_user.u_id', 'left')->where('admitted_student.as_id',$hostel[$i])->get('admitted_student')->row();
	if(isset($get_stu)){
	$uid2 = $this->db->order_by('serial','desc')->get('studentinfo')->row();	
		$uid1 = explode('U',$uid2->userId);
        $prefix = 'U';
		$index = $uid1[1]+1;
        $userIds = sprintf("%s%09s", $prefix, $index);
                    $handyCam = new \handyCam\handyCam();
                $dateNow=date("Y-m-d");
				
			$stu_hos = $this->db->where('admitId',$get_stu->as_id)->get('studentinfo')->row();
            if(!isset($stu_hos)){	
                $data2 = array(
                    'userId' => $userIds,
                    'userGroupId' => "UG004",
                    'name' => $get_stu->pr_applicant_name,
                    'studentId' => $get_stu->as_student_id,
                    'cellNo' => $get_stu->u_mobile,
                    'email' => $get_stu->u_email_id,
                    //'nameOfInst' => $get_stu->as_id,
                    'program' => $get_stu->short_name,
                    'batchNo' => $batch,
                    'gender' => $get_stu->pr_gender,
                    'dob' => $get_stu->pr_dob,
                    'bloodGroup' => $get_stu->pr_blood_group,
                    'nationality' => $get_stu->pr_nationality,
                    //'nationalId' => $get_stu->as_id,
                    'passportNo' => $get_stu->pr_passportnumber,
                    'fatherName' => $get_stu->pr_father_name,
                    'motherName' => $get_stu->pr_mother_name,
                    'fatherCellNo' => $get_stu->pr_father_mobnum,
                    'motherCellNo' => $get_stu->pr_mother_mobnum,
                    'localGuardian' => $get_stu->pr_gaurdion_name,
                    'localGuardianCell' => $get_stu->pr_gaurdion_mobnum,
                    'presentAddress' => $get_stu->pr_local_address,
                    'parmanentAddress' =>$get_stu->pr_permanent_address,
                    'admitDate' => $dateNow,
                    'admitId' => $get_stu->as_id,
                    'main_id' => $stream,
                    'course_id' => $department,
                    'perPhoto' => $get_stu->pr_photo,
                    'isActive' => 'Y'
                );		
				$this->db->insert('studentinfo',$data2);
			}else{
				$data2_e['isActive'] = 'Y';			
				$this->db->where('admitId',$hostel[$i]);
				$this->db->update('studentinfo',$data2_e);
			}
	}
	}
	for($ii=0; $ii<sizeof($not_hostel); $ii++){
	$data1['hostel_status']='0';
	 $this->db->where('as_id',$not_hostel[$ii]);	
	$this->db->update('admitted_student',$data1);
	$stu_hos1 = $this->db->where('admitId',$not_hostel[$ii])->get('studentinfo')->row();
            if(isset($stu_hos1)){		
                $data3['isActive'] = 'N';			
				$this->db->where('admitId',$not_hostel[$ii]);
				$this->db->update('studentinfo',$data3);
			}
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
	public function getStudents()
	{
	$stream=$this->input->post('stream');
	$department=$this->input->post('department');
	$batch=$this->input->post('batch');
	
	$stud = $this->db->where('batchNo',$batch)->where('main_id',$stream)->where('course_id',$department)->where('isActive','Y')->get('studentinfo')->result();	
	
	$student = '<option value="">Select Students</option>';
	foreach($stud as $stud){
		$student .= '<option value="'.$stud->userId.'">'.$stud->name.'</option>';
	}
	echo $student;
    }
	
	public function studentAttendance()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['stream1']='';
		$data['department1']='';
		$data['batch1']='';
		$data['date1']='';
		
		if(isset($_POST['submit'])){
			$data['stream1']=$stream = $this->input->post('stream');
			$data['department1']=$department = $this->input->post('department');
			$data['batch1']=$batch = $this->input->post('batch');
			$data['date1']=$date = date('Y-m-d',strtotime($this->input->post('date')));
			$yr = substr($batch,-2);
		$data['stu_list'] = $this->db->select('studentinfo.*,admitted_student.as_id,admitted_student.as_app_number,admitted_student.as_name,attendence.isAbsence,attendence.isLeave')
		->join('attendence','(attendence.admitId=studentinfo.admitId AND DATE_FORMAT(attendence.date,"%Y-%m-%d")="'.$date.'")','left')
		->join('admitted_student','admitted_student.as_id=studentinfo.admitId')
		->where('studentinfo.batchNo',$batch)
		->where('studentinfo.main_id',$stream)
		->where('studentinfo.course_id',$department)
		->where('studentinfo.isActive','Y')
		->get('studentinfo')->result();
		}
		
	$this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/studentManage/studentAttendance',$data);
    $this->load->view('hosteladmin/template/footer');		
	}
	public function markAttendance()
	{
		$add_date = date('Y-m-d');
	$att=$this->input->post('ids_att');
	$op=$this->input->post('ids_op');
	$att_not=$this->input->post('ids_att_not');
	$op_not=$this->input->post('ids_op_not');
	if($att==''){$att=array();}
	if($op==''){$op=array();}
	if($att_not==''){$att_not=array();}
	if($op_not==''){$op_not=array();}
	$stream = $this->input->post('stream');
	$department = $this->input->post('department');
	$batch = $this->input->post('batch');
	$date1=str_replace('-','/',$this->input->post('date'));
	$date = date('Y-m-d',strtotime($date1));
	
	/*$att=array();
	$op=array();
	$att_not=array('117');
	$op_not=array('117');
	$stream = 1;
	$department = 6;
	$batch = 2021;
	$date = '2022-12-05';*/
	
	for($i=0; $i<sizeof($att); $i++){
                $dateNow=date("Y-m-d H:i:s");
				
			$stu_att = $this->db->where('admitId',$att[$i])->where('DATE_FORMAT(date,"%Y-%m-%d")',$date)->get('attendence')->row();
			$get_stuid = $this->db->where('admitId',$att[$i])->get('studentinfo')->row();	
                $data1 = array(
                    'userId' => $get_stuid->userId,
                    'admitId' => $att[$i],
                    'studentId' => $get_stuid->studentId,
                    'batch' => $batch,
                    'main_id' => $stream,
                    'course_id' => $department,
                    'date' => $date,
                    'isAbsence' => 1,
                    'created_at	' => $dateNow,
                );	
				if(in_array($att[$i],$op)){$data1['isLeave']=1;}else{$data1['isLeave']=0;}
            if(!isset($stu_att)){	
				$this->db->insert('attendence',$data1);
			}else{	
				$this->db->where('serial',$stu_att->serial);
				$this->db->update('attendence',$data1);
			}
	}
	for($ii=0; $ii<sizeof($att_not); $ii++){
                $dateNow=date("Y-m-d H:i:s");
				
			$stu_att = $this->db->where('admitId',$att_not[$ii])->where('DATE_FORMAT(date,"%Y-%m-%d")',$date)->get('attendence')->row();
			$get_stuid = $this->db->where('admitId',$att_not[$ii])->get('studentinfo')->row();	
                $data2 = array(
                    'userId' => $get_stuid->userId,
                    'admitId' => $att_not[$ii],
                    'studentId' => $get_stuid->studentId,
                    'batch' => $batch,
                    'main_id' => $stream,
                    'course_id' => $department,
                    'date' => $date,
                    'isAbsence' => 0,
                    'created_at	' => $dateNow,
                );	
				if(in_array($att_not[$ii],$op_not)){$data2['isLeave']=0;}else{$data2['isLeave']=1;}
            if(!isset($stu_att)){	
				$this->db->insert('attendence',$data2);
			}else{	
				$this->db->where('serial',$stu_att->serial);
				$this->db->update('attendence',$data2);
			}
	}
	echo 'Success';
    }
	
	public function studentPayments()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['stream1']='';
		$data['department1']='';
		$data['batch1']='';
		$data['year1']='';
		
		if(isset($_POST['submit'])){
			$data['stream1']=$stream = $this->input->post('stream');
			$data['department1']=$department = $this->input->post('department');
			$data['batch1']=$batch = $this->input->post('batch');
			$data['year1']=$year = $this->input->post('year');
			$yr = substr($batch,-2);
		$data['stu_list'] = $this->db->select('studentinfo.*,admitted_student.as_id,admitted_student.as_app_number,admitted_student.as_name,hostel_payments.installment1,hostel_payments.installment2')
		->join('hostel_payments','(hostel_payments.admitId=studentinfo.admitId AND hostel_payments.year="'.$year.'")','left')
		->join('admitted_student','admitted_student.as_id=studentinfo.admitId')
		->where('studentinfo.batchNo',$batch)
		->where('studentinfo.main_id',$stream)
		->where('studentinfo.course_id',$department)
		->where('studentinfo.isActive','Y')
		->get('studentinfo')->result();
		}
		
	$this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/studentManage/studentPayments',$data);
    $this->load->view('hosteladmin/template/footer');		
	}
	public function markPayments()
	{
		$add_date = date('Y-m-d');
	$inst1=$this->input->post('ids_inst1');
	$inst2=$this->input->post('ids_inst2');
	$inst1_not=$this->input->post('ids_inst1_not');
	$inst2_not=$this->input->post('ids_inst2_not');
	if($inst1==''){$inst1=array();}
	if($inst2==''){$inst2=array();}
	if($inst1_not==''){$inst1_not=array();}
	if($inst2_not==''){$inst2_not=array();}
	$stream = $this->input->post('stream');
	$department = $this->input->post('department');
	$batch = $this->input->post('batch');
	$year=$this->input->post('year');
	
	/*$att=array();
	$op=array();
	$att_not=array('117');
	$op_not=array('117');
	$stream = 1;
	$department = 6;
	$batch = 2021;
	$date = '2022-12-05';*/
	
	for($i=0; $i<sizeof($inst1); $i++){
                $dateNow=date("Y-m-d H:i:s");
				
			$stu_inst = $this->db->where('admitId',$inst1[$i])->where('year',$year)->get('hostel_payments')->row();
			$get_stuid = $this->db->where('admitId',$inst1[$i])->get('studentinfo')->row();	
                $data1 = array(
                    'userId' => $get_stuid->userId,
                    'admitId' => $inst1[$i],
                    'studentId' => $get_stuid->studentId,
                    'batch' => $batch,
                    'main_id' => $stream,
                    'course_id' => $department,
                    'year' => $year,
                    'installment1' => 1,
                    'created_at	' => $dateNow,
                );	
				if(in_array($inst1[$i],$inst2)){$data1['installment2']=1;}else{$data1['installment2']=0;}
            if(!isset($stu_inst)){	
				$this->db->insert('hostel_payments',$data1);
			}else{	
				$this->db->where('serial',$stu_inst->serial);
				$this->db->update('hostel_payments',$data1);
			}
	}
	for($ii=0; $ii<sizeof($inst1_not); $ii++){
                $dateNow=date("Y-m-d H:i:s");
				
			$stu_inst = $this->db->where('admitId',$inst1_not[$ii])->where('year',$year)->get('hostel_payments')->row();
			$get_stuid = $this->db->where('admitId',$inst1_not[$ii])->get('studentinfo')->row();	
                $data2 = array(
                    'userId' => $get_stuid->userId,
                    'admitId' => $inst1_not[$ii],
                    'studentId' => $get_stuid->studentId,
                    'batch' => $batch,
                    'main_id' => $stream,
                    'course_id' => $department,
                    'year' => $year,
                    'installment1' => 0,
                    'created_at	' => $dateNow,
                );	
				if(in_array($inst1_not[$ii],$inst2_not)){$data2['installment2']=0;}else{$data2['installment2']=1;}
            if(!isset($stu_inst)){	
				$this->db->insert('hostel_payments',$data2);
			}else{	
				$this->db->where('serial',$stu_inst->serial);
				$this->db->update('hostel_payments',$data2);
			}
	}
	echo 'Success';
    }
	
	public function studentPaymentsReport()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['stream1']='';
		$data['department1']='';
		$data['batch1']='';
		$data['year1']='';
		
		if(isset($_POST['submit'])){
			$data['stream1']=$stream = $this->input->post('stream');
			$data['department1']=$department = $this->input->post('department');
			$data['batch1']=$batch = $this->input->post('batch');
			$data['year1']=$year = $this->input->post('year');
			$yr = substr($batch,-2);
		$data['stu_list'] = $this->db->select('studentinfo.*,admitted_student.as_id,admitted_student.as_app_number,admitted_student.as_name,hostel_payments.installment1,hostel_payments.installment2')
		->join('hostel_payments','(hostel_payments.admitId=studentinfo.admitId AND hostel_payments.year="'.$year.'")','left')
		->join('admitted_student','admitted_student.as_id=studentinfo.admitId')
		->where('studentinfo.batchNo',$batch)
		->where('studentinfo.main_id',$stream)
		->where('studentinfo.course_id',$department)
		->where('studentinfo.isActive','Y')
		->get('studentinfo')->result();
		}
		
	$this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/studentManage/studentPaymentsReport',$data);
    $this->load->view('hosteladmin/template/footer');		
	}
	
	public function studentMealReport()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['stream1']='';
		$data['department1']='';
		$data['batch1']='';
		$data['date1']='';
		
		if(isset($_POST['submit'])){
			$data['stream1']=$stream = $this->input->post('stream');
			$data['department1']=$department = $this->input->post('department');
			$data['batch1']=$batch = $this->input->post('batch');
			$data['date1']=$date = date('Y-m',strtotime($this->input->post('date')));
			$yr = substr($batch,-2);
		$data['stu_list'] = $this->db->select('studentinfo.*,admitted_student.as_id,admitted_student.as_app_number,admitted_student.as_name')
		->join('admitted_student','admitted_student.as_id=studentinfo.admitId')
		->where('studentinfo.batchNo',$batch)
		->where('studentinfo.main_id',$stream)
		->where('studentinfo.course_id',$department)
		->where('studentinfo.isActive','Y')
		->get('studentinfo')->result();
		
		$data['mealrate']=$this->db->get('mealrate')->row();
		}
		
	$this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/studentManage/studentMealReport',$data);
    $this->load->view('hosteladmin/template/footer');		
	}
	
	public function studentAttendanceReport()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['stream1']='';
		$data['department1']='';
		$data['batch1']='';
		$data['date1']='';
		
		if(isset($_POST['submit'])){
			$data['stream1']=$stream = $this->input->post('stream');
			$data['department1']=$department = $this->input->post('department');
			$data['batch1']=$batch = $this->input->post('batch');
			$data['date1']=$date = date('Y-m-d',strtotime($this->input->post('date')));
			$yr = substr($batch,-2);
		$data['stu_list'] = $this->db->select('studentinfo.*,admitted_student.as_id,admitted_student.as_app_number,admitted_student.as_name,attendence.isAbsence,attendence.isLeave')
		->join('attendence','(attendence.admitId=studentinfo.admitId AND DATE_FORMAT(attendence.date,"%Y-%m-%d")="'.$date.'")','left')
		->join('admitted_student','admitted_student.as_id=studentinfo.admitId')
		->where('studentinfo.batchNo',$batch)
		->where('studentinfo.main_id',$stream)
		->where('studentinfo.course_id',$department)
		->where('studentinfo.isActive','Y')
		->get('studentinfo')->result();
		}
		
	$this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/studentManage/studentAttendanceReport',$data);
    $this->load->view('hosteladmin/template/footer');		
	}
	
	public function studentReport()
	{
		$data['user']=$user_id=$this->session->userdata('user')['user_id'];
		$add_date=date('Y-m-d H:i:s');
		$data['stream1']='';
		$data['department1']='';
		$data['batch1']='';
		
		if(isset($_POST['submit'])){
			$data['stream1']=$stream = $this->input->post('stream');
			$data['department1']=$department = $this->input->post('department');
			$data['batch1']=$batch = $this->input->post('batch');
			$yr = substr($batch,-2);
		$data['stu_list'] = $this->db->select('studentinfo.*,admitted_student.as_id,admitted_student.as_app_number,admitted_student.as_name')
		->join('admitted_student','admitted_student.as_id=studentinfo.admitId')
		->where('studentinfo.batchNo',$batch)
		->where('studentinfo.main_id',$stream)
		->where('studentinfo.course_id',$department)
		->where('studentinfo.isActive','Y')
		->get('studentinfo')->result();
		}
		
	$this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/studentManage/studentReport',$data);
    $this->load->view('hosteladmin/template/footer');		
	}
	
	public function listInventory()
	{
		$GLOBALS['title']="Inventory-ERP";
		$GLOBALS['inv_list'] = $this->db->query("SELECT * FROM inventories")->result();
		$GLOBALS['handyCam'] = new \handyCam\handyCam();
		
		$add_date = date('Y-m-d H:i:s');
    
        if (isset($_POST["btnSave"])) {
		$uid2 = $this->db->order_by('id','desc')->get('inventories')->row();	
		$uid1 = explode('IN',$uid2->inventoryId);
        $prefix = 'IN';
		$index = $uid1[1]+1;
        $userIds = sprintf("%s%04s", $prefix, $index);
                    $handyCam = new \handyCam\handyCam();
					$data = array(

                    'inventoryId' => $userIds,
                    'name' => $_POST['name'],
                    'description' => $_POST['description'],
                    'created_at'      => $add_date

                );
                    $result = $this->db->insert("inventories", $data);
                    // var_dump($result);
                    if ($result) {

                        $id1 =intval($index);

                    $query="UPDATE auto_id set number=".$id1." where prefix='IN'";
                    $result=$this->db->query($query);
						$data['msg']=$this->session->set_flashdata('msg','Inventory Added Successfully.','success');	
                        redirect('hosteladminlogin/listInventory','refresh');
                    } else {
						$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                        redirect('hosteladminlogin/listInventory','refresh');
                    }
        }
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/setup/inventory',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');
    }
	public function updateInventory()
	{
		$GLOBALS['title']="Inventory-ERP";
		$id = $this->uri->segment(3);
		$GLOBALS['data'] = array();
            $result = $this->db->query("SELECT * FROM inventories where id='".$id."'")->result();
		$handyCam = new \handyCam\handyCam();
		$GLOBALS['data'] = array();
                foreach ($result as $row) {
                    array_push($GLOBALS['data'],$row->id);
                    array_push($GLOBALS['data'],$row->inventoryId);
                    array_push($GLOBALS['data'],$row->name);
                    array_push($GLOBALS['data'],$row->description);
                    array_push($GLOBALS['data'],$row->created_at);

                }
        if (isset($_POST["btnUpdate"])) {
            $id = $_POST['edit_id'];
                        $handyCam = new \handyCam\handyCam();
                $data = array(

                    'description' => $_POST['description'],
                    'name' =>$_POST['name']

                );
                        $this->db->where('id',$id);
                        $result = $this->db->update("inventories", $data);
                        if ($result) {
							$data['msg']=$this->session->set_flashdata('msg','Inventory Info Updated Successfully.','success');	
                            redirect('hosteladminlogin/listInventory','refresh');
                        } else {
                            $data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                            redirect('hosteladminlogin/listInventory','refresh');
                        }
                    }
	$this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/setup/inventoryaction',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');			
    }
	public function deleteInventory()
	{
		$id = $this->uri->segment(3);
				$sql = "delete from inventories where id='".$id."'";
				if ($this->db->query($sql) === TRUE) 
				{
	    			$data['msg']=$this->session->set_flashdata('msg','Inventory deleted successfully','success');	
                    redirect('hosteladminlogin/listInventory','refresh');
				} 
				else 
				{
					$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                    redirect('hosteladminlogin/listInventory','refresh');
				}
		
	}
	
	public function inventoryInRooms()
	{
		$GLOBALS['title']="Inventory-ERP";
		$GLOBALS['inventories'] = $this->db->query("SELECT * FROM inventories")->result();
		$GLOBALS['rooms'] = $this->db->query("SELECT * FROM rooms")->result();
		$GLOBALS['inv_list'] = $this->db->query("SELECT * FROM inventories_in_room")->result();
		$GLOBALS['inventories1'] = array();
		$GLOBALS['rooms1'] = '';
		$GLOBALS['edit_id'] = '';
		$GLOBALS['handyCam'] = new \handyCam\handyCam();
		
		$add_date = date('Y-m-d H:i:s');
    
        if (isset($_POST["btnSave"])) {
                    $handyCam = new \handyCam\handyCam();
					$edit_id = $_POST['edit_id'];
					$inventories = implode(',',$_POST['inventories']);
					$room = $_POST['room'];
					$data = array(
                    'room_id' => $room,
                    'inventories' => $inventories,
                    'created_at'      => $add_date
                );
				if($edit_id == ''){
					$get_in = $this->db->where('room_id',$room)->get("inventories_in_room")->row();
					if(!isset($get_in)){
                    $result = $this->db->insert("inventories_in_room", $data);
					}else{
					$data['msg']=$this->session->set_flashdata('error','Inventory for the room is already added!!','success');	
                    redirect('hosteladminlogin/inventoryInRooms','refresh');	
					}
				}else{
					$data_e = array(
                    'inventories' => $inventories,
                );
					$this->db->where('id',$edit_id);
					$result1 = $this->db->update("inventories_in_room", $data_e);
				}
                    // var_dump($result);
                    if ($result) {
						$data['msg']=$this->session->set_flashdata('msg','Inventory Added Successfully.','success');	
                        redirect('hosteladminlogin/inventoryInRooms','refresh');
                    } elseif ($result1) {
						$data['msg']=$this->session->set_flashdata('msg','Inventory Updated Successfully.','success');	
                        redirect('hosteladminlogin/inventoryInRooms','refresh');
                    }
					else {
						$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                        redirect('hosteladminlogin/inventoryInRooms','refresh');
                    }
        }
		if ($this->uri->segment(3) != '') {
			$id = $this->uri->segment(3);
			$GLOBALS['inv_edit'] = $inv_edit = $this->db->query("SELECT * FROM inventories_in_room where id=".$id." ")->row();
			$GLOBALS['inventories1'] = explode(',',$inv_edit->inventories);
		    $GLOBALS['rooms1'] = $inv_edit->room_id;
		    $GLOBALS['edit_id'] = $inv_edit->id;
		}
    $this->load->view('hosteladmin/template/header',$GLOBALS);
    $this->load->view('hosteladmin/ui/setup/inventoryInRooms',$GLOBALS);
    $this->load->view('hosteladmin/template/footer');
    }
	public function deleteInventoryRm()
	{
		$id = $this->uri->segment(3);
				$sql = "delete from inventories_in_room where id='".$id."'";
				if ($this->db->query($sql) === TRUE) 
				{
	    			$data['msg']=$this->session->set_flashdata('msg','Inventory deleted successfully','success');	
                    redirect('hosteladminlogin/inventoryInRooms','refresh');
				} 
				else 
				{
					$data['error']=$this->session->set_flashdata('error',''.$this->db->error['message'].'','success');	
                    redirect('hosteladminlogin/inventoryInRooms','refresh');
				}
		
	}
}
