<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
define('BASE_URL', 	'https://admission.mssw.in/erp/');
define('DB_PREFIX', 	'wy_');
//require APPPATH . '/libraries/dompdf/autoload.inc.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
	use Dompdf\Dompdf;
	use Dompdf\Options;
class Payrolllogin extends CI_Controller {
	
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

	public function attendance()
	{
    $this->load->view('payroll/template/header');
    $this->load->view('payroll/attendance');
    $this->load->view('payroll/template/footer');
    }
	public function salaries()
	{
    $this->load->view('payroll/template/header');
    $this->load->view('payroll/salaries');
    $this->load->view('payroll/template/footer');
    }
	public function holidays()
	{
    $this->load->view('payroll/template/header');
    $this->load->view('payroll/holidays');
    $this->load->view('payroll/template/footer');
    }
	public function payheads()
	{
    $this->load->view('payroll/template/header');
    $this->load->view('payroll/payheads');
    $this->load->view('payroll/template/footer');
    }
	public function leaves()
	{
    $this->load->view('payroll/template/header');
    $this->load->view('payroll/leaves');
    $this->load->view('payroll/template/footer');
    }
	public function employees()
	{
    $this->load->view('payroll/template/header');
    $this->load->view('payroll/employees');
    $this->load->view('payroll/template/footer');
    }
	public function logOut(){
		$this->session->unset_userdata('user'); 
		redirect('employee_login', 'refresh');
	}
	function ConvertNumberToWords($number) {
    $hyphen      = ' ';
    $conjunction = ' and ';
    $separator   = ' ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'ConvertNumberToWords only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . ConvertNumberToWords(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . $this->ConvertNumberToWords($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = $this->ConvertNumberToWords($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= $this->ConvertNumberToWords($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}

function GetDataByIDAndType($ID, $Type) {
  global $db;

	if ( $Type == 'admin' ) {
		$query = mysqli_query($db, "SELECT * FROM `" . DB_PREFIX . "admin` WHERE `admin_id` = $ID LIMIT 0, 1");
		if ( $query ) {
			if ( mysqli_num_rows($query) == 1 ) {
				$userData = mysqli_fetch_assoc($query);
			}
		}
	} else {
		$query = mysqli_query($db, "SELECT * FROM `" . DB_PREFIX . "employees` WHERE `emp_id` = $ID LIMIT 0, 1");
		if ( $query ) {
			if ( mysqli_num_rows($query) == 1 ) {
				$userData = mysqli_fetch_assoc($query);
			}
		}
	}
	return $userData;
}

function GetEmployeeDataByEmpCode($EmpCode) {

	$empData = array();
	$query = $this->db->query("SELECT * FROM `erp_employee_master` WHERE `id` = '$EmpCode' LIMIT 0, 1");
	if ( $query ) {
		if ( $query->num_rows() == 1 ) {
			$empData = $query->row();
		}
	}
	return $empData;
}

function GetAdminData($Admin_ID) {
    global $db;

    $adminData = array();
    $query = mysqli_query($db, "SELECT * FROM `" . DB_PREFIX . "admin` WHERE `admin_id` = $Admin_ID LIMIT 0, 1");
    if ( $query ) {
        if ( mysqli_num_rows($query) == 1 ) {
            $adminData = mysqli_fetch_assoc($query);
        }
    }
    return $adminData;
}

function GetEmployeePayheadsByEmpCode($EmpCode) {

	$payData = array();
	$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "pay_structure` AS `pay`, `" . DB_PREFIX . "payheads` AS `head` WHERE `pay`.`payhead_id` = `head`.`payhead_id` AND `pay`.`emp_code` = '$EmpCode'");
	if ( $query ) {
		if ( $query->num_rows() > 0 ) {
			$headData = $query->result_array();
			foreach ( $headData as $headData ) {
				$payData[] = $headData;
			}
		}
	}
	return $payData;
}

function GetEmployeeSalaryByEmpCodeAndMonth($EmpCode, $month) {

	$salaryData = array();
	$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "salaries` WHERE `emp_code` = '$EmpCode' AND `pay_month` = '$month'");
	if ( $query ) {
		if ( $query->num_rows() > 0 ) {
			$payData = $query->result_array();
			foreach ( $payData as $payData ) {
				$salaryData[] = $payData;
			}
		}
	}
	return $salaryData;
}

function TotalSundaysAndSaturdays($month, $year) {
    $sundays = 0; $saturdays = 0;
    $total_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    for ( $i = 1; $i <= $total_days; $i++ ) {
        if ( date('N', strtotime($year . '-' . $month . '-' . $i)) == 7 ) {
            $sundays++;
        }
        if ( date('N', strtotime($year . '-' . $month . '-' . $i)) == 6 ) {
            $saturdays++;
        }
    }
    return $sundays + $saturdays;
}

//function GetEmployeeLWPDataByEmpCodeAndMonth() {
function GetEmployeeLWPDataByEmpCodeAndMonth($EmpCode, $month) {
    //$EmpCode =326; $month = 'October, 2022';
    $TotalSundaysAndSaturdays = $this->TotalSundaysAndSaturdays(date('m', strtotime($month)), date('Y', strtotime($month)));
    $leaveData['workingDays'] = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($month)), date('Y', strtotime($month))) - $TotalSundaysAndSaturdays;

    // Total without leaves in the payment month
    $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "leaves` WHERE `emp_code` = '$EmpCode' AND `leave_type` = 'Leave Without Pay' AND `leave_status_principal` = 'approve'");
    if ( $query ) {
        if ( $query->num_rows() > 0 ) {
			$row = $query->result_array();
            foreach ( $row as $row ) {
                if ( strpos($row['leave_dates'], ',') !== false ) {
                    $leaveDates = explode(',', $row['leave_dates']);
                    foreach ( $leaveDates as $date ) {
                        $leaveDate = date('F, Y', strtotime($date));
                        if ( $leaveDate == $month ) {
                            $withoutPay[] = 1;
                        }
                    }
                }
            }
        }
    }
    $leaveData['withoutPay'] = isset($withoutPay) ? array_sum($withoutPay) : 0;
    //====================

    // Total with pay leaves till date
    $nowMonth = date('n'); $nowYear = date('Y');
    if ( $nowMonth == 1 || $nowMonth == 2 || $nowMonth == 3 ) {
        $startYear = $nowYear - 1; $endYear = $nowYear;
    } else {
        $startYear = $nowYear; $endYear = $nowYear + 1;
    }
    $startMonth = 1; $endMonth = 12;
    $startDay = 1; $endDay = 31; $nowDay = date('j');
    $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "leaves` WHERE `emp_code` = '$EmpCode' AND `leave_type` != 'Leave Without Pay' AND `leave_status_principal` = 'approve'");
    if ( $query ) {
        if ( $query->num_rows() > 0 ) {
			$row = $query->result_array();
            foreach ( $row as $row ) {
                if ( strpos($row['leave_dates'], ',') !== false ) {
                    $leaveDates = explode(',', $row['leave_dates']);
                    foreach ( $leaveDates as $date ) {
                        $leaveDate = strtotime(date('F, Y', $date));
                        if ( $leaveDate <= strtotime($month) ) {
                            $leaves[] = 1;
                        }
                    }
                }
            }
        }
    }
    $leaveData['payLeaves'] = isset($leaves) ? array_sum($leaves) : 0;
    //====================

    // Total leaves in a financial year
	$empL = $this->db->where('id',$EmpCode)->get('erp_employee_master')->row();
	if($empL->emp_designation_==23){$earnedLeave=15;}else{$earnedLeave=30;}
	
    $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "holidays` WHERE `holiday_type` = 'compulsory' AND DATE_FORMAT(`holiday_date`, '%m/%d/%Y') BETWEEN '" . $startYear . '-' . $startMonth . '-' . $startDay . "' AND '" . $endYear . '-' . $endMonth . '-' . $endDay . "'");
    if ( $query ) {
        if ( $query->num_rows() > 0 ) {exit;
            //$leaveData['totalLeaves'] = $query->num_rows() + 7 + 12 + 12 + 6;
            $leaveData['totalLeaves'] = $query->num_rows() + 12 + $earnedLeave;
        } else {
			$leaveData['totalLeaves'] = 12 + $earnedLeave;
			}
    }

    return $leaveData;
}

function Send_Mail($subject, $message, $toName, $toMail, $fromName = FALSE, $fromMail = FALSE,  $cc = FALSE, $bcc = FALSE, $attachment = FALSE, $debug = FALSE) {
    include_once(dirname(__FILE__) . "/phpmailer/class.phpmailer.php");
    include_once(dirname(__FILE__) . "/phpmailer/class.smtp.php");
    $mail = new PHPMailer;

    $mail->isSMTP();
    $mail->Host       = PHPMAILER_HOST;
    $mail->Port       = PHPMAILER_PORT;
    $mail->SMTPAuth   = TRUE;
    $mail->Username   = PHPMAILER_USERNAME;
    $mail->Password   = PHPMAILER_PASSWORD;
    $mail->SMTPSecure = PHPMAILER_SMTPSECURE;

    if ( $fromName && $fromMail ) {
        $mail->From       = $fromMail;
        $mail->FromName   = $fromName;
    } else {
        $mail->From       = PHPMAILER_FROM;
        $mail->FromName   = PHPMAILER_FROMNAME;
    }

    if ( is_array($toName) && is_array($toMail) ) {
        for ( $i = 0; $i < count($toMail); $i++ ) {
            $mail->addAddress($toMail[$i], $toName[$i]);
        }
    } else {
        $mail->addAddress($toMail, $toName);
    }

    if ( $fromName && $fromMail ) {
        $mail->addReplyTo($fromMail, $fromName);
    } else {
        $mail->addReplyTo(PHPMAILER_FROM, PHPMAILER_FROMNAME);
    }

    if ( $cc ) {
        if ( is_array($cc) ) {
            for ( $i = 0; $i < count($cc); $i++ ) {
                $mail->addCC($cc[$i]);
            }
        } else {
            $mail->addCC($cc);
        }
    }

    if ( $bcc ) {
        if ( is_array($bcc) ) {
            for ( $i = 0; $i < count($bcc); $i++ ) {
                $mail->addBCC($bcc[$i]);
            }
        } else {
            $mail->addBCC($bcc);
        }
    }

    $mail->WordWrap = PHPMAILER_WORDWRAP;

    if ( $attachment ) {
        for ( $i = 0; $i < count($attachment); $i++ ) {
            $mail->addAttachment($attachment[$i]['src'], $attachment[$i]['name']);
        }
    }

    $mail->isHTML(TRUE);

    if ( $debug ) {
        $mail->SMTPDebug = 2;
    }

    $mail->Subject      = $subject;
    $mail->Body         = $message;

    if ( !$mail->send() ) {
        return 1;
    } else {
        return 0;
    }
}
	public function ajax(){
	//$case = $_GET['case'];
	$case = $this->uri->segment(3);
switch($case) {
	case 'LoginProcessHandler':
		LoginProcessHandler();
		break;
	case 'AttendanceProcessHandler':
		$this->AttendanceProcessHandler();
		break;
	case 'LoadingAttendance':
		$this->LoadingAttendance();
		break;
	case 'LoadingSalaries':
		$this->LoadingSalaries();
		break;
	case 'LoadingEmployees':
		$this->LoadingEmployees();
		break;
	case 'AssignPayheadsToEmployee':
		$this->AssignPayheadsToEmployee();
		break;
	case 'InsertUpdateHolidays':
		$this->InsertUpdateHolidays();
		break;
	case 'GetHolidayByID':
		$this->GetHolidayByID();
		break;
	case 'DeleteHolidayByID':
		$this->DeleteHolidayByID();
		break;
	case 'LoadingHolidays':
		$this->LoadingHolidays();
		break;
	case 'InsertUpdatePayheads':
		$this->InsertUpdatePayheads();
		break;
	case 'GetPayheadByID':
		$this->GetPayheadByID();
		break;
	case 'DeletePayheadByID':
		$this->DeletePayheadByID();
		break;
	case 'LoadingPayheads':
		$this->LoadingPayheads();
		break;
	case 'GetAllPayheadsExceptEmployeeHave':
		$this->GetAllPayheadsExceptEmployeeHave();
		break;
	case 'GetEmployeePayheadsByID':
		$this->GetEmployeePayheadsByID();
		break;
	case 'GetEmployeeByID':
		$this->GetEmployeeByID();
		break;
	case 'DeleteEmployeeByID':
		$this->DeleteEmployeeByID();
		break;
	case 'EditEmployeeDetailsByID':
		$this->EditEmployeeDetailsByID();
		break;
	case 'GeneratePaySlip':
		$this->GeneratePaySlip();
		break;
	case 'SendPaySlipByMail':
		SendPaySlipByMail();
		break;
	case 'EditProfileByID':
		EditProfileByID();
		break;
	case 'EditLoginDataByID':
		EditLoginDataByID();
		break;
	case 'LoadingAllLeaves':
		$this->LoadingAllLeaves();
		break;
	case 'LoadingMyLeaves':
		LoadingMyLeaves();
		break;
	case 'ApplyLeaveToAdminApproval':
		ApplyLeaveToAdminApproval();
		break;
	case 'ApproveLeaveApplication':
		$this->ApproveLeaveApplication();
		break;
	case 'RejectLeaveApplication':
		$this->RejectLeaveApplication();
		break;
	case 'LoadingLeaveEntry':
		$this->LoadingLeaveEntry();
		break;	
	case 'GetLeaveNoByID':
		$this->GetLeaveNoByID();
		break;
    case 'DeleteLeaveNoByID':
		$this->DeleteLeaveNoByID();
		break;	
	case 'InsertUpdateLeaves':
		$this->InsertUpdateLeaves();
		break;	
	default:
		echo '404! Page Not Found.';
		break;
}
	}

function LoginProcessHandler() {
	$result = array();
	global $db;

	$code = addslashes($_POST['code']);
    $password = addslashes($_POST['password']);
    if ( !empty($code) && !empty($password) ) {
	    $adminCheck = mysqli_query($db, "SELECT * FROM `" . DB_PREFIX . "admin` WHERE `admin_code` = '$code' AND `admin_password` = '" . sha1($password) . "' LIMIT 0, 1");
	    if ( $adminCheck ) {
	        if ( mysqli_num_rows($adminCheck) == 1 ) {
	            $adminData = mysqli_fetch_assoc($adminCheck);
	            $_SESSION['Admin_ID'] = $adminData['admin_id'];
	            $_SESSION['Login_Type'] = 'admin';
	            $result['result'] = BASE_URL . 'attendance/';
			    		$result['code'] = 0;
	        } else {
	        	$empCheck = mysqli_query($db, "SELECT * FROM `" . DB_PREFIX . "employees` WHERE `emp_code` = '$code' AND `emp_password` = '" . sha1($password) . "' LIMIT 0, 1");
			    if ( $empCheck ) {
			        if ( mysqli_num_rows($empCheck) == 1 ) {
			        	$empData = mysqli_fetch_assoc($empCheck);
			            $_SESSION['Admin_ID'] = $empData['emp_id'];
			            $_SESSION['Login_Type'] = 'emp';
			            $result['result'] = BASE_URL . 'profile/';
			    		$result['code'] = 0;
			        } else {
			        	$result['result'] = 'Invalid Login Details.';
			        	$result['code'] = 1;
			        }
			    } else {
			    	$result['result'] = 'Something went wrong, please try again.';
		    		$result['code'] = 2;
			    }
	        }
	    } else {
	    	$result['result'] = 'Something went wrong, please try again.';
		    $result['code'] = 2;
	    }
	} else {
		$result['result'] = 'Login Details should not be blank.';
		$result['code'] = 3;
	}

    echo json_encode($result);
}

function AttendanceProcessHandler() {
	$userData=$this->session->userdata('user')['user_id'];
	$result = array();

	$emp_code = $userData;
	$attendance_date = date('Y-m-d');
	$attendanceSQL = $this->db->query("SELECT * FROM `" . DB_PREFIX . "attendance` WHERE `emp_code` = '$emp_code' AND `attendance_date` = '$attendance_date'");
	if ( $attendanceSQL ) {
		$attendanceROW = $attendanceSQL->num_rows();
		if ( $attendanceROW == 0 ) {
			$action_name = 'punchin';
		} else {
			$attendanceDATA = $attendanceSQL->row();
			if ( $attendanceDATA->action_name == 'punchin' ) {
				$action_name = 'punchout';
			} else {
				$action_name = 'punchin';
			}
		}
	} else {
		$attendanceROW = 0;
		$action_name = 'punchin';
	}
	$action_time = date('H:i:s');
	$emp_desc = addslashes($_POST['desc']);

    $insertSQL = $this->db->query("INSERT INTO `" . DB_PREFIX . "attendance`(`emp_code`, `attendance_date`, `action_name`, `action_time`, `emp_desc`) VALUES ('$emp_code', '$attendance_date', '$action_name', '$action_time', '$emp_desc')");
    if ( $insertSQL ) {
    	$result['next'] = ($action_name == 'punchin' ? 'Punch Out' : 'Punch In');
    	$result['complete'] = $attendanceROW + 1;
        $result['result'] = 'You have successfully punched in.';
		$result['code'] = 0;
    } else {
    	$result['result'] = 'Something went wrong, please try again.';
	    $result['code'] = 1;
    }

    echo json_encode($result);
}

function LoadingAttendance() {
	$requestData = $_REQUEST;
	$columns = array(
		0 => 'attendance_date',
		1 => 'emp_code',
		2 => 'first_name',
		3 => 'last_name',
		4 => 'action_time',
		5 => 'emp_desc'
	);

	$sql  = "SELECT `attendance_id`, `emp_code`, `attendance_date`, GROUP_CONCAT(`action_time`) AS `times`, GROUP_CONCAT(`emp_desc`) AS `descs` FROM `" . DB_PREFIX . "attendance` GROUP BY `emp_code`, `attendance_date`";
	$query = $this->db->query($sql);
	$totalData = $query->num_rows();
	$totalFiltered = $totalData;

	$sql  = "SELECT `emp`.`employee_id_`, `emp`.`emp_name_`, `att`.`attendance_id`, `att`.`emp_code`, `att`.`attendance_date`, GROUP_CONCAT(`att`.`action_time`) AS `times`, GROUP_CONCAT(`att`.`emp_desc`) AS `descs`";
	$sql .= " FROM `erp_employee_master` AS `emp`, `" . DB_PREFIX . "attendance` AS `att` WHERE `emp`.`id` = `att`.`emp_code`";
	if ( !empty($requestData['search']['value']) ) {
		$sql .= " AND (`att`.`attendance_date` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `emp`.`emp_name_` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `att`.`times` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `att`.`descs` LIKE '" . $requestData['search']['value'] . "%')";
	}
	$sql .= " GROUP BY `emp`.`id`, `att`.`attendance_date`";

	$query = $this->db->query($sql);
	$totalFiltered = $query->num_rows();
	$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
	$query = $this->db->query($sql);

	$data = array();
	$i = 1 + $requestData['start'];
	$row = $query->result_array();
	foreach ( $row as $row ) {
		$nestedData = array();
		$nestedData[] = date('d-m-Y', strtotime($row['attendance_date']));
		$nestedData[] = $row["employee_id_"];
		$nestedData[] = '<a target="_blank" href="' . base_url() . 'payrolllogin/reports/' . $row["emp_code"] . '">' . $row["emp_name_"] . '</a>';
		$times = explode(',', $row["times"]);
		$descs = explode(',', $row["descs"]);
		$nestedData[] = isset($times[0]) ? date('h:i:s A', strtotime($times[0])) : '';
		$nestedData[] = isset($descs[0]) ? $descs[0] : '';
		$nestedData[] = isset($times[1]) ? date('h:i:s A', strtotime($times[1])) : '';
		$nestedData[] = isset($descs[1]) ? $descs[1] : '';

		$datetime1 = new DateTime($times[0]);
		$datetime2 = new DateTime($times[1]);
		$interval = $datetime1->diff($datetime2);
		$nestedData[] = (isset($times[0]) && isset($times[1])) ? $interval->format('%h') . " Hrs  |" . $interval->format('%i') . " Min" : 0 . "H";

		$data[] = $nestedData;
		$i++;
	}
	$json_data = array(
		"draw"            => intval($requestData['draw']),
		"recordsTotal"    => intval($totalData),
		"recordsFiltered" => intval($totalFiltered),
		"data"            => $data
	);

	echo json_encode($json_data);
}

function LoadingSalaries() {
	$requestData = $_REQUEST;
	if ( $this->session->userdata('user')['user_designation'] == 27 ) {
		$columns = array(
			0 => 'emp_code',
			1 => 'first_name',
			2 => 'last_name',
			3 => 'pay_month',
			4 => 'earning_total',
			5 => 'deduction_total',
			6 => 'net_salary'
		);

		$sql  = "SELECT * FROM `" . DB_PREFIX . "salaries` GROUP BY `emp_code`, `pay_month`";
		$query = $this->db->query($sql);
		$totalData = $query->num_rows();
		$totalFiltered = $totalData;

		$sql  = "SELECT `emp`.`id`, `emp`.`employee_id_`, `emp`.`emp_name_`, `salary`.*";
		$sql .= " FROM `" . DB_PREFIX . "salaries` AS `salary`, `erp_employee_master` AS `emp` WHERE `emp`.`id` = `salary`.`emp_code`";
		if ( !empty($requestData['search']['value']) ) {
			$sql .= " AND `emp`.`employee_id_` LIKE '" . $requestData['search']['value'] . "%'";
			$sql .= " OR `emp`.`emp_name_` LIKE '" . $requestData['search']['value'] . "%'";
			$sql .= " OR `salary`.`pay_month` LIKE '" . $requestData['search']['value'] . "%'";
			$sql .= " OR `salary`.`earning_total` LIKE '" . $requestData['search']['value'] . "%'";
			$sql .= " OR `salary`.`deduction_total` LIKE '" . $requestData['search']['value'] . "%'";
			$sql .= " OR `salary`.`net_salary` LIKE '" . $requestData['search']['value'] . "%')";
		}
		$sql .= " GROUP BY `salary`.`emp_code`, `salary`.`pay_month`";

		$query = $this->db->query($sql);
		$totalFiltered = $query->num_rows();

		$data = array();
		$i = 1 + $requestData['start'];
		$row = $query->result_array();
		foreach ( $row as $row ) {
			$month=explode(', ',$row['pay_month']);
			$nestedData = array();
			$nestedData[] = $row['employee_id_'];
			$nestedData[] = '<a target="_blank" href="' . base_url() . 'payrolllogin/reports/' . $row["id"] . '">' . $row["emp_name_"] . ' </a>';
			$nestedData[] = $row['pay_month'];
			$nestedData[] = number_format($row['earning_total'], 2, '.', ',');
			$nestedData[] = number_format($row['deduction_total'], 2, '.', ',');
			$nestedData[] = number_format($row['net_salary'], 2, '.', ',');
			$nestedData[] = '<button type="button" class="btn btn-success btn-xs" onclick="openInNewTab(\'' . base_url() . 'payrolllogin/GeneratePaySlipEmployee/' . $row['id'] . '/' . $month[0] . '/' . $month[1] . '/'.$row['employee_id_'].'.pdf\');"><i class="fa fa-download"></i></button> <button type="button" class="btn btn-info btn-xs" onclick="sendPaySlipByMail(\'' . $row['employee_id_'] . '\', \'' . $row['pay_month'] . '\');"><i class="fa fa-envelope"></i></button>';

			$data[] = $nestedData;
			$i++;
		}
	} else {
		$columns = array(
			0 => 'pay_month',
			1 => 'earning_total',
			2 => 'deduction_total',
			3 => 'net_salary'
		);
		$empData = GetDataByIDAndType($_SESSION['Admin_ID'], $_SESSION['Login_Type']);
		$sql  = "SELECT * FROM `" . DB_PREFIX . "salaries` GROUP BY `emp_code`, `pay_month` WHERE `emp_code` = '" . $empData['emp_code'] . "'";
		$query = mysqli_query($db, $sql);
		$totalData = mysqli_num_rows($query);
		$totalFiltered = $totalData;

		$sql  = "SELECT `emp`.`emp_code`, `emp`.`first_name`, `emp`.`last_name`, `salary`.*";
		$sql .= " FROM `" . DB_PREFIX . "salaries` AS `salary`, `" . DB_PREFIX . "employees` AS `emp` WHERE `emp`.`emp_code` = `salary`.`emp_code` AND `salary`.`emp_code` = '" . $empData['emp_code'] . "'";
		if ( !empty($requestData['search']['value']) ) {
			$sql .= " AND (`salary`.`emp_code` LIKE '" . $requestData['search']['value'] . "%'";
			$sql .= " OR CONCAT(TRIM(`emp`.`first_name`), ' ', TRIM(`emp`.`last_name`)) LIKE '" . $requestData['search']['value'] . "%'";
			$sql .= " OR `salary`.`pay_month` LIKE '" . $requestData['search']['value'] . "%'";
			$sql .= " OR `salary`.`earning_total` LIKE '" . $requestData['search']['value'] . "%'";
			$sql .= " OR `salary`.`deduction_total` LIKE '" . $requestData['search']['value'] . "%'";
			$sql .= " OR `salary`.`net_salary` LIKE '" . $requestData['search']['value'] . "%')";
		}
		$sql .= " GROUP BY `salary`.`emp_code`, `salary`.`pay_month`";

		$query = mysqli_query($db, $sql);
		$totalFiltered = mysqli_num_rows($query);

		$data = array();
		$i = 1 + $requestData['start'];
		while ( $row = mysqli_fetch_assoc($query) ) {
			$nestedData = array();
			$nestedData[] = $row['pay_month'];
			$nestedData[] = number_format($row['earning_total'], 2, '.', ',');
			$nestedData[] = number_format($row['deduction_total'], 2, '.', ',');
			$nestedData[] = number_format($row['net_salary'], 2, '.', ',');
			$nestedData[] = '<button type="button" class="btn btn-success btn-xs" onclick="openInNewTab(\'' . BASE_URL . 'payslips/' . $empData['emp_code'] . '/' . str_replace(', ', '-', $row['pay_month']) . '/' . str_replace(', ', '-', $row['pay_month']) . '.pdf\');"><i class="fa fa-download"></i></button>';

			$data[] = $nestedData;
			$i++;
		}
	}
	$json_data = array(
		"draw"            => intval($requestData['draw']),
		"recordsTotal"    => intval($totalData),
		"recordsFiltered" => intval($totalFiltered),
		"data"            => $data
	);

	echo json_encode($json_data);
}

function LoadingEmployees() {
	$requestData = $_REQUEST;
	$columns = array(
		0 => 'employee_id_',
		2 => 'emp_profile_',
		2 => 'emp_name_',
		4 => 'email',
		5 => 'mobile',
		6 => 'emp_bgroup_',
		11 => 'emp_type'
	);

	$sql  = "SELECT `employee_id_` ";
	$sql .= " FROM `erp_employee_master`";
	$query = $this->db->query($sql);
	$totalData = $query->num_rows();
	$totalFiltered = $totalData;

	$sql  = "SELECT *";
	$sql .= " FROM `erp_employee_master` WHERE 1 = 1";
	if ( !empty($requestData['search']['value']) ) {
		$sql .= " AND (`employee_id_` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `emp_profile_` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `emp_name_` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `emp_mail_` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `emp_mobile_` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `emp_bgroup_` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `emp_type` LIKE '" . $requestData['search']['value'] . "%')";
	}
	$query = $this->db->query($sql);
	$totalFiltered = $query->num_rows();
	$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
	$query = $this->db->query($sql);

	$data = array();
	$i = 1 + $requestData['start'];
	$row=$query->result_array();
	foreach ( $row as $row ) {
	 $desig=$this->db->where('id',$row['emp_designation_'])->get('erp_department')->row();	
	 if($row["emp_profile_"]==null){$url = base_url().'system/images/user.png';}
     else{$url = base_url().'system/images/employee/'.$row["emp_profile_"];
     }
		$nestedData = array();
		$nestedData[] = $row["employee_id_"].'<input type="hidden" value="'.$row["id"].'">';
		$nestedData[] = '<img width="50" src="' . $url . '" alt="' . $row["employee_id_"] . '" />';
		$nestedData[] = '<a target="_blank" href="' . base_url() . 'payrolllogin/reports/' . $row["id"] . '/">' . $row["emp_name_"] . '</a>';
		$nestedData[] = $row["emp_mail_"];
		$nestedData[] = $row["emp_mobile_"];
		$nestedData[] = strtoupper($row["emp_bgroup_"]);
		//$nestedData[] = ucwords($row["emp_type"]);
		$nestedData[] = ucwords($desig->dept_code_);
		$data[] = $nestedData;
		$i++;
	}
	$json_data = array(
		"draw"            => intval($requestData['draw']),
		"recordsTotal"    => intval($totalData),
		"recordsFiltered" => intval($totalFiltered),
		"data"            => $data
	);

	echo json_encode($json_data);
}

function AssignPayheadsToEmployee() {
	$result = array();

	$payheads = $_POST['selected_payheads'];
	$default_salary = $_POST['pay_amounts'];
	$emp_code = $_POST['empcode'];
	$checkSQL = $this->db->query("SELECT * FROM `" . DB_PREFIX . "pay_structure` WHERE `emp_code` = '$emp_code'");
	if ( $checkSQL ) {
		if ( !empty($payheads) && !empty($emp_code) ) {
			if ( $checkSQL->num_rows() == 0 ) {
				foreach ( $payheads as $payhead ) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "pay_structure`(`emp_code`, `payhead_id`, `default_salary`) VALUES ('$emp_code', $payhead, " . (!empty($default_salary[$payhead]) ? $default_salary[$payhead] : 0) . ")");
				}
				$result['result'] = 'Payheads are successfully assigned to employee.';
				$result['code'] = 0;
			} else {
				$this->db->query("DELETE FROM `" . DB_PREFIX . "pay_structure` WHERE `emp_code` = '$emp_code'");
				foreach ( $payheads as $payhead ) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "pay_structure`(`emp_code`, `payhead_id`, `default_salary`) VALUES ('$emp_code', $payhead, " . (!empty($default_salary[$payhead]) ? $default_salary[$payhead] : 0) . ")");
				}
				$result['result'] = 'Payheads are successfully re-assigned to employee.';
				$result['code'] = 0;
			}
		} else {
			$result['result'] = 'Please select payheads and employee to assign.';
			$result['code'] = 2;
		}
	} else {
		$result['result'] = 'Something went wrong, please try again.';
		$result['code'] = 1;
	}

	echo json_encode($result);
}

function InsertUpdateHolidays() {
	$result = array();

	$holiday_title = stripslashes($_POST['holiday_title']);
    $holiday_desc = stripslashes($_POST['holiday_desc']);
    $holiday_date = stripslashes($_POST['holiday_date']);
    $holiday_type = stripslashes($_POST['holiday_type']);
    if ( !empty($holiday_title) && !empty($holiday_desc) && !empty($holiday_date) && !empty($holiday_type) ) {
	    if ( !empty($_POST['holiday_id']) ) {
	    	$holiday_id = addslashes($_POST['holiday_id']);
	    	$updateHoliday = $this->db->query("UPDATE `" . DB_PREFIX . "holidays` SET `holiday_title` = '$holiday_title', `holiday_desc` = '$holiday_desc', `holiday_date` = '$holiday_date', `holiday_type` = '$holiday_type' WHERE `holiday_id` = $holiday_id");
		    if ( $updateHoliday ) {
		        $result['result'] = 'Holiday record has been successfully updated.';
		        $result['code'] = 0;
		    } else {
		    	$result['result'] = 'Something went wrong, please try again.';
		    	$result['code'] = 1;
		    }
	    } else {
	    	$insertHoliday = $this->db->query("INSERT INTO `" . DB_PREFIX . "holidays`(`holiday_title`, `holiday_desc`, `holiday_date`, `holiday_type`) VALUES ('$holiday_title', '$holiday_desc', '$holiday_date', '$holiday_type')");
		    if ( $insertHoliday ) {
		        $result['result'] = 'Holiday record has been successfully inserted.';
		        $result['code'] = 0;
		    } else {
		    	$result['result'] = 'Something went wrong, please try again.';
		    	$result['code'] = 1;
		    }
		}
	} else {
		$result['result'] = 'Holiday details should not be blank.';
		$result['code'] = 2;
	}

	echo json_encode($result);
}

function GetHolidayByID() {
	$result = array();

	$id = $_POST['id'];
	$holiSQL = $this->db->query("SELECT * FROM `" . DB_PREFIX . "holidays` WHERE `holiday_id` = $id LIMIT 0, 1");
	if ( $holiSQL ) {
		if ( $holiSQL->num_rows() == 1 ) {
			$result['result'] = $holiSQL->row();
			$result['code'] = 0;
		} else {
			$result['result'] = 'Holiday record is not found.';
			$result['code'] = 1;
		}
	} else {
		$result['result'] = 'Something went wrong, please try again.';
		$result['code'] = 2;
	}

	echo json_encode($result);
}

function DeleteHolidayByID() {
	$result = array();

	$id = $_POST['id'];
	$holiSQL = $this->db->query("DELETE FROM `" . DB_PREFIX . "holidays` WHERE `holiday_id` = $id");
	if ( $holiSQL ) {
		$result['result'] = 'Holiday record is successfully deleted.';
		$result['code'] = 0;
	} else {
		$result['result'] = 'Something went wrong, please try again.';
		$result['code'] = 1;
	}

	echo json_encode($result);
}

function LoadingHolidays() {
	$requestData = $_REQUEST;
	$columns = array(
		0 => 'holiday_id',
		1 => 'holiday_title',
		2 => 'holiday_desc',
		3 => 'holiday_date',
		4 => 'holiday_type',
	);

	$sql  = "SELECT `holiday_id` ";
	$sql .= " FROM `" . DB_PREFIX . "holidays`";
	$query = $this->db->query($sql);
	$totalData = $query->num_rows();
	$totalFiltered = $totalData;

	$sql  = "SELECT *";
	$sql .= " FROM `" . DB_PREFIX . "holidays` WHERE 1 = 1";
	if ( !empty($requestData['search']['value']) ) {
		$sql .= " AND (`holiday_id` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `holiday_title` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `holiday_desc` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `holiday_date` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `holiday_type` LIKE '" . $requestData['search']['value'] . "%')";
	}
	$query = $this->db->query($sql);
	$totalFiltered = $query->num_rows();
	$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
	$query = $this->db->query($sql);

	$data = array();
	$i = 1 + $requestData['start'];
	$row = $query->result_array();
	$sno=1;
	foreach ( $row as $row ) {
		$nestedData = array();
		$nestedData[] = $sno.'<input type="hidden" value="'.$row["holiday_id"].'">';
		$nestedData[] = $row["holiday_title"];
		$nestedData[] = $row["holiday_desc"];
		$nestedData[] = date('d-m-Y', strtotime($row["holiday_date"]));
		if ( $row["holiday_type"] == 'compulsory' ) {
			$nestedData[] = '<span class="label label-success">' . ucwords($row["holiday_type"]) . '</span>';
		} else {
			$nestedData[] = '<span class="label label-danger">' . ucwords($row["holiday_type"]) . '</span>';
		}
		$data[] = $nestedData;
		$i++;
		$sno++;
	}
	$json_data = array(
		"draw"            => intval($requestData['draw']),
		"recordsTotal"    => intval($totalData),
		"recordsFiltered" => intval($totalFiltered),
		"data"            => $data
	);

	echo json_encode($json_data);
}

function InsertUpdatePayheads() {
	$result = array();

	$payhead_name = stripslashes($_POST['payhead_name']);
    $payhead_desc = stripslashes($_POST['payhead_desc']);
    $payhead_type = stripslashes($_POST['payhead_type']);
    if ( !empty($payhead_name) && !empty($payhead_desc) && !empty($payhead_type) ) {
	    if ( !empty($_POST['payhead_id']) ) {
	    	$payhead_id = addslashes($_POST['payhead_id']);
	    	$updatePayhead = $this->db->query("UPDATE `" . DB_PREFIX . "payheads` SET `payhead_name` = '$payhead_name', `payhead_desc` = '$payhead_desc', `payhead_type` = '$payhead_type' WHERE `payhead_id` = $payhead_id");
		    if ( $updatePayhead ) {
		        $result['result'] = 'Payhead record has been successfully updated.';
		        $result['code'] = 0;
		    } else {
		    	$result['result'] = 'Something went wrong, please try again.';
		    	$result['code'] = 1;
		    }
	    } else {
	    	$insertPayhead = $this->db->query("INSERT INTO `" . DB_PREFIX . "payheads`(`payhead_name`, `payhead_desc`, `payhead_type`) VALUES ('$payhead_name', '$payhead_desc', '$payhead_type')");
		    if ( $insertPayhead ) {
		        $result['result'] = 'Payhead record has been successfully inserted.';
		        $result['code'] = 0;
		    } else {
		    	$result['result'] = 'Something went wrong, please try again.';
		    	$result['code'] = 1;
		    }
		}
	} else {
		$result['result'] = 'Payhead details should not be blank.';
		$result['code'] = 2;
	}

	echo json_encode($result);
}

function GetPayheadByID() {
	$result = array();

	$id = $_POST['id'];
	$holiSQL = $this->db->query("SELECT * FROM `" . DB_PREFIX . "payheads` WHERE `payhead_id` = $id LIMIT 0, 1");
	if ( $holiSQL ) {
		if ( $holiSQL->num_rows() == 1 ) {
			$result['result'] = $holiSQL->row();
			$result['code'] = 0;
		} else {
			$result['result'] = 'Payhead record is not found.';
			$result['code'] = 1;
		}
	} else {
		$result['result'] = 'Something went wrong, please try again.';
		$result['code'] = 2;
	}

	echo json_encode($result);
}

function DeletePayheadByID() {
	$result = array();

	$id = $_POST['id'];
	$holiSQL = $this->db->query("DELETE FROM `" . DB_PREFIX . "payheads` WHERE `payhead_id` = $id");
	if ( $holiSQL ) {
		$result['result'] = 'Payhead record is successfully deleted.';
		$result['code'] = 0;
	} else {
		$result['result'] = 'Something went wrong, please try again.';
		$result['code'] = 1;
	}

	echo json_encode($result);
}

function LoadingPayheads() {
	$requestData = $_REQUEST;
	$columns = array(
		0 => 'payhead_id',
		1 => 'payhead_name',
		2 => 'payhead_desc',
		3 => 'payhead_type'
	);

	$sql  = "SELECT `payhead_id` ";
	$sql .= " FROM `" . DB_PREFIX . "payheads`";
	$query = $this->db->query($sql);
	$totalData = $query->num_rows();
	$totalFiltered = $totalData;

	$sql  = "SELECT *";
	$sql .= " FROM `" . DB_PREFIX . "payheads` WHERE 1 = 1";
	if ( !empty($requestData['search']['value']) ) {
		$sql .= " AND (`payhead_id` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `payhead_name` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `payhead_desc` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `payhead_type` LIKE '" . $requestData['search']['value'] . "%')";
	}
	$query = $this->db->query($sql);
	$totalFiltered = $query->num_rows();
	$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
	$query = $this->db->query($sql);

	$data = array();
	$arr = 1;
	$i = 1 + $requestData['start'];
	$row = $query->result_array();
	foreach ( $row as $row ) {
		$nestedData = array();
		$nestedData[] = $arr.'<input type="hidden" value="'.$row["payhead_id"].'">';
		$nestedData[] = $row["payhead_name"];
		$nestedData[] = $row["payhead_desc"];
		if ( $row["payhead_type"] == 'earnings' ) {
			$nestedData[] = '<span class="label label-success">' . ucwords($row["payhead_type"]) . '</span>';
		} else {
			$nestedData[] = '<span class="label label-danger">' . ucwords($row["payhead_type"]) . '</span>';
		}
		$data[] = $nestedData;
		$i++;
		$arr++;
	}
	$json_data = array(
		"draw"            => intval($requestData['draw']),
		"recordsTotal"    => intval($totalData),
		"recordsFiltered" => intval($totalFiltered),
		"data"            => $data
	);

	echo json_encode($json_data);
}

function GetAllPayheadsExceptEmployeeHave() {
	$result = array();

	$emp_code = $_POST['emp_code'];
	$salarySQL = $this->db->query("SELECT * FROM `" . DB_PREFIX . "payheads` WHERE `payhead_id` NOT IN (SELECT `payhead_id` FROM `" . DB_PREFIX . "pay_structure` WHERE `emp_code` = '$emp_code')");
	if ( $salarySQL ) {
		if ( $salarySQL->num_rows() > 0 ) {
			$data = $salarySQL->result_array();
			foreach ( $data as $data ) {
				$result['result'][] = $data;
			}
			$result['code'] = 0;
		} else {
			$result['result'] = 'Salary record is not found.';
			$result['code'] = 1;
		}
	} else {
		$result['result'] = 'Something went wrong, please try again.';
		$result['code'] = 2;
	}

	echo json_encode($result);
}

function GetEmployeePayheadsByID() {
	$result = array();

	$emp_code = $_POST['emp_code'];
	$salarySQL = $this->db->query("SELECT * FROM `" . DB_PREFIX . "pay_structure` AS `pay`, `" . DB_PREFIX . "payheads` AS `head` WHERE `head`.`payhead_id` = `pay`.`payhead_id` AND `pay`.`emp_code` = '$emp_code'");
	if ( $salarySQL ) {
		if ( $salarySQL->num_rows() > 0 ) {
			$data = $salarySQL->result_array();
			foreach ( $data as $data ) {
				$result['result'][] = $data;
			}
			$result['code'] = 0;
		} else {
			$result['result'] = 'Salary record is not found.';
			$result['code'] = 1;
		}
	} else {
		$result['result'] = 'Something went wrong, please try again.';
		$result['code'] = 2;
	}

	echo json_encode($result);
}

function GetEmployeeByID() {
	$result = array();

	$emp_code = $_POST['emp_code'];
	$empSQL = $this->db->query("SELECT * FROM `erp_employee_master` WHERE `id` = '$emp_code' LIMIT 0, 1");
	if ( $empSQL ) {
		if ( $empSQL->num_rows() == 1 ) {
			$result['result'] = $empSQL->row();
			$result['code'] = 0;
		} else {
			$result['result'] = 'Employee record is not found.';
			$result['code'] = 1;
		}
	} else {
		$result['result'] = 'Something went wrong, please try again.';
		$result['code'] = 2;
	}

	echo json_encode($result);
}

function DeleteEmployeeByID() {
	$result = array();

	$emp_code = $_POST['emp_code'];
	$empSQL = $this->db->query("DELETE FROM `erp_employee_master` WHERE `id` = '$emp_code'");
	if ( $empSQL ) {
		$result['result'] = 'Employee record is successfully deleted.';
		$result['code'] = 0;
	} else {
		$result['result'] = 'Something went wrong, please try again.';
		$result['code'] = 1;
	}

	echo json_encode($result);
}

function EditEmployeeDetailsByID() {
	$result = array();

	$emp_id = stripslashes($_POST['emp_id']);
    $first_name = stripslashes($_POST['first_name']);
    //$last_name = stripslashes($_POST['last_name']);
    //$dob = stripslashes($_POST['dob']);
	$date=str_replace('-','/',$this->input->post('dob'));
	$dob=date('Y-m-d',strtotime($date));
    $gender = stripslashes($_POST['gender']);
    $merital_status = stripslashes($_POST['merital_status']);
    $nationality = stripslashes($_POST['nationality']);
    $address = stripslashes($_POST['address']);
    $city = stripslashes($_POST['city']);
    $state = stripslashes($_POST['state']);
    $country = stripslashes($_POST['country']);
    $email = stripslashes($_POST['email']);
    $mobile = stripslashes($_POST['mobile']);
    //$telephone = stripslashes($_POST['telephone']);
    //$identity_doc = stripslashes($_POST['identity_doc']);
    //$identity_no = stripslashes($_POST['identity_no']);
    //$emp_type = stripslashes($_POST['emp_type']);
	$date_j=str_replace('-','/',$this->input->post('joining_date'));
    $joining_date = date('Y-m-d',strtotime($date_j));
    $blood_group = stripslashes($_POST['blood_group']);
    //$designation = stripslashes($_POST['designation']);
    //$department = stripslashes($_POST['department']);
    //$pan_no = stripslashes($_POST['pan_no']);
    $bank_name = stripslashes($_POST['bank_name']);
    $account_no = stripslashes($_POST['account_no']);
    $ifsc_code = stripslashes($_POST['ifsc_code']);
    $pf_account = stripslashes($_POST['pf_account']);
    if ( !empty($first_name) && !empty($dob) && !empty($gender) && !empty($merital_status) && !empty($nationality) && !empty($address) && !empty($city) && !empty($state) && !empty($country) && !empty($email) && !empty($mobile) && !empty($joining_date) && !empty($joining_date) && !empty($blood_group) && !empty($bank_name) && !empty($account_no) && !empty($ifsc_code) && !empty($pf_account) ) {
    	$updateEmp = $this->db->query("UPDATE `erp_employee_master` SET `emp_name_` = '$first_name', `emp_dob_` = '$dob', `emp_gender_` = '$gender', `emp_maritalstatus_` = '$merital_status', `emp_nationality_` = '$nationality', `emp_address_` = '$address', `emp_city_` = '$city', `emp_state_` = '$state', `emp_country_` = '$country', `emp_mail_` = '$email', `emp_mobile_` = '$mobile', `emp_doj_` = '$joining_date', `emp_bgroup_` = '$blood_group', `emp_bankname_` = '$bank_name', `emp_accno_` = '$account_no', `emp_ifsc_` = '$ifsc_code', `emp_pf_` = '$pf_account' WHERE `id` = $emp_id");
	    if ( $updateEmp ) {
	        $result['result'] = 'Employee details has been successfully updated.';
	        $result['code'] = 0;
	    } else {
	    	$result['result'] = 'Something went wrong, please try again.';
	    	$result['code'] = 1;
	    }
	} else {
		$result['result'] = 'All fields are mandatory except Telephone.';
		$result['code'] = 2;
	}

	echo json_encode($result);
}

function GeneratePaySlip() {
	$result = array();

	$emp_code = $_POST['emp_code'];
    $pay_month = $_POST['pay_month'];
    $earnings_heads = $_POST['earnings_heads'];
    $earnings_amounts = $_POST['earnings_amounts'];
    $deductions_heads = $_POST['deductions_heads'];
    $deductions_amounts = $_POST['deductions_amounts'];
	/*$emp_code = '326';
    $pay_month = 'November, 2021';
    $earnings_heads = array('Basic Salary');
    $earnings_amounts = array('500');
    $deductions_heads = array('Other Deductions');
    $deductions_amounts = array('50');*/
    if ( !empty($emp_code) && !empty($pay_month) ) {
	    for ( $i = 0; $i < count($earnings_heads); $i++ ) {
	    	$checkSalSQL = $this->db->query("SELECT * FROM `" . DB_PREFIX . "salaries` WHERE `emp_code` = '$emp_code' AND `payhead_name` = '" . $earnings_heads[$i] . "' AND `pay_month` = '$pay_month' AND `pay_type` = 'earnings' LIMIT 0, 1");
	    	if ( $checkSalSQL ) {
	    		if ( $checkSalSQL->num_rows() == 0 ) {
	    			$this->db->query("INSERT INTO `" . DB_PREFIX . "salaries`(`emp_code`, `payhead_name`, `pay_amount`, `earning_total`, `deduction_total`, `net_salary`, `pay_type`, `pay_month`, `generate_date`) VALUES ('$emp_code', '" . $earnings_heads[$i] . "', " . number_format($earnings_amounts[$i], 2, '.', '') . ", " . number_format(array_sum($earnings_amounts), 2, '.', '') . ", " . number_format(array_sum($deductions_amounts), 2, '.', '') . ", " . number_format((array_sum($earnings_amounts) - array_sum($deductions_amounts)), 2, '.', '') . ", 'earnings', '$pay_month', '" . date('Y-m-d H:i:s') . "')");
	    		}
	    	}
	    }
	    for ( $i = 0; $i < count($deductions_heads); $i++ ) {
	    	$checkSalSQL = $this->db->query("SELECT * FROM `" . DB_PREFIX . "salaries` WHERE `emp_code` = '$emp_code' AND `payhead_name` = '" . $deductions_heads[$i] . "' AND `pay_month` = '$pay_month' AND `pay_type` = 'deductions' LIMIT 0, 1");
	    	if ( $checkSalSQL ) {
	    		if ( $checkSalSQL->num_rows() == 0 ) {
	    			$this->db->query("INSERT INTO `" . DB_PREFIX . "salaries`(`emp_code`, `payhead_name`, `pay_amount`, `earning_total`, `deduction_total`, `net_salary`, `pay_type`, `pay_month`, `generate_date`) VALUES ('$emp_code', '" . $deductions_heads[$i] . "', " . number_format($deductions_amounts[$i], 2, '.', '') . ", " . number_format(array_sum($earnings_amounts), 2, '.', '') . ", " . number_format(array_sum($deductions_amounts), 2, '.', '') . ", " . number_format((array_sum($earnings_amounts) - array_sum($deductions_amounts)), 2, '.', '') . ", 'deductions', '$pay_month', '" . date('Y-m-d H:i:s') . "')");
	    		}
	    	}
	    }
        $this->session->set_flashdata('PaySlipMsg','Payslip Generated Successfully!','success');
        $this->load->library('pdf');
		$dompdf = new DOMPDF();
	    $empData = $this->GetEmployeeDataByEmpCode($emp_code);
	    $empSalary = $this->GetEmployeeSalaryByEmpCodeAndMonth($emp_code, $pay_month);
	    $empLeave = $this->GetEmployeeLWPDataByEmpCodeAndMonth($emp_code, $pay_month);
	    $totalEarnings = 0;
		$totalDeductions = 0;
		$role=$this->db->where('id',$empData->emp_designation_)->get('erp_role_master')->row();
		$dept=$this->db->where('id',$empData->emp_dept_name_)->get('erp_department')->row();
		$html = '<style>
		@page{margin:20px 20px;font-family:Arial;font-size:14px;}
    	.div_half{float:left;margin:0 0 30px 0;width:50%;}
    	.logo{width:250px;padding:0;}
    	.com_title{text-align:center;font-size:16px;margin:0;}
    	.reg_no{text-align:center;font-size:12px;margin:5px 0;}
    	.subject{text-align:center;font-size:20px;font-weight:bold;}
    	.emp_info{width:100%;margin:0 0 30px 0;}
    	.table{border:1px solid #ccc;margin:0 0 30px 0;}
    	.salary_info{width:100%;margin:0;}
    	.salary_info th,.salary_info td{border:1px solid #ccc;margin:0;padding:5px;vertical-align:middle;}
    	.net_payable{margin:0;color:#050;}
    	.in_word{text-align:right;font-size:12px;margin:5px 0;}
    	.signature{margin:0 0 30px 0;}
    	.signature strong{font-size:12px;padding:5px 0 0 0;border-top:1px solid #000;}
    	.com_info{font-size:12px;text-align:center;margin:0 0 30px 0;}
    	.noseal{text-align:center;font-size:11px;}
	    </style>';
	    $html .= '<div class="div_half">';
	    $html .= '<img class="logo" src="' . base_url() . 'system/images/IDGenerate/MSSW_Logo.png" alt="Wisely Online Services Private Limited" />';
	    $html .= '</div>';
	    $html .= '<div class="div_half">';
	    $html .= '<h2 class="com_title">Madras School of Social Work</h2>';
	    $html .= '<p class="reg_no">Registration Number: 063838, Chennai</p>';
	    $html .= '</div>';

	    $html .= '<p class="subject">Salary Slip for ' . $pay_month . '</p>';

	    $html .= '<table class="emp_info">';
	    $html .= '<tr>';
	    $html .= '<td width="25%">Employee Code</td>';
	    $html .= '<td width="25%">: ' . strtoupper($empData->employee_id_) . '</td>';
	    $html .= '<td width="25%">Bank Name</td>';
	    $html .= '<td width="25%">: ' . ucwords($empData->emp_bankname_) . '</td>';
	    $html .= '</tr>';

	    $html .= '<tr>';
	    $html .= '<td>Employee Name</td>';
	    $html .= '<td>: ' . ucwords($empData->emp_name_) . '</td>';
	    $html .= '<td>Bank Account</td>';
	    $html .= '<td>: ' . $empData->emp_accno_ . '</td>';
	    $html .= '</tr>';

	    $html .= '<tr>';
	    $html .= '<td>Designation</td>';
	    $html .= '<td>: ' . ucwords($role->role_name) . '</td>';
	    $html .= '<td>IFSC Code</td>';
	    $html .= '<td>: ' . strtoupper($empData->emp_ifsc_) . '</td>';
	    $html .= '</tr>';

	    $html .= '<tr>';
	    $html .= '<td>Location</td>';
	    $html .= '<td>: ' . ucwords($empData->emp_city_) . '</td>';
	    $html .= '<td>PF Account</td>';
	    $html .= '<td>: ' . strtoupper($empData->emp_pf_) . '</td>';
	    $html .= '</tr>';

	    $html .= '<tr>';
	    $html .= '<td>Department</td>';
	    $html .= '<td>: ' . ucwords($dept->dept_name_) . '</td>';
	    $html .= '<td>Payable/Working Days</td>';
	    $html .= '<td>: ' . ($empLeave['workingDays'] - $empLeave['withoutPay']) . '/' . $empLeave['workingDays'] . ' Days</td>';
	    $html .= '</tr>';

	    $html .= '<tr>';
	    $html .= '<td>Date of Joining</td>';
	    $html .= '<td>: ' . date('d-m-Y', strtotime($empData->emp_doj_)) . '</td>';
	    $html .= '<td>Taken/Remaining Leaves</td>';
	    $html .= '<td>: ' . $empLeave['payLeaves'] . '/' . ($empLeave['totalLeaves'] - $empLeave['payLeaves']) . ' Days</td>';
	    $html .= '</tr>';
	    $html .= '</table>';

		$html .= '<table class="table" cellspacing="0" cellpadding="0" width="100%">';
			$html .= '<thead>';
				$html .= '<tr>';
					$html .= '<th width="50%" valign="top">';
						$html .= '<table class="salary_info" cellspacing="0">';
							$html .= '<tr>';
								$html .= '<th align="left">Earnings</th>';
								$html .= '<th width="110" align="right">Amount (Rs.)</th>';
							$html .= '</tr>';
						$html .= '</table>';
					$html .= '</th>';
					$html .= '<th width="50%" valign="top">';
						$html .= '<table class="salary_info" cellspacing="0">';
							$html .= '<tr>';
								$html .= '<th align="left">Deductions</th>';
								$html .= '<th width="110" align="right">Amount (Rs.)</th>';
							$html .= '</tr>';
						$html .= '</table>';
					$html .= '</th>';
				$html .= '</tr>';
			$html .= '</thead>';

			if ( !empty($empSalary) ) {
				$html .= '<tr>';
					$html .= '<td width="50%" valign="top">';
						$html .= '<table class="salary_info" cellspacing="0">';
						foreach ( $empSalary as $salary ) {
							if ( $salary['pay_type'] == 'earnings' ) {
								$totalEarnings += $salary['pay_amount'];
								$html .= '<tr>';
									$html .= '<td align="left">';
										$html .= $salary['payhead_name'];
									$html .= '</td>';
									$html .= '<td width="110" align="right">';
										$html .= number_format($salary['pay_amount'], 2, '.', ',');
									$html .= '</td>';
								$html .= '</tr>';
							}
						}
						$html .= '</table>';
					$html .= '</td>';

					$html .= '<td width="50%" valign="top">';
						$html .= '<table class="salary_info" cellspacing="0">';
						foreach ( $empSalary as $salary ) {
							if ( $salary['pay_type'] == 'deductions' ) {
								$totalDeductions += $salary['pay_amount'];
								$html .= '<tr>';
									$html .= '<td align="left">';
										$html .= $salary['payhead_name'];
									$html .= '</td>';
									$html .= '<td width="110" align="right">';
										$html .= number_format($salary['pay_amount'], 2, '.', ',');
									$html .= '</td>';
								$html .= '</tr>';
							}
						}
						$html .= '</table>';
					$html .= '</td>';
				$html .= '</tr>';
			} else {
				$html .= '<tr>';
					$html .= '<td colspan="2" width="100%">No payheads are assigned for this employee</td>';
				$html .= '</tr>';
			}

			$html .= '<tr>';
				$html .= '<td width="50%" valign="top">';
					$html .= '<table class="salary_info" cellspacing="0">';
						$html .= '<tr>';
							$html .= '<td align="left">';
								$html .= '<strong>Total Earnings</strong>';
							$html .= '</td>';
							$html .= '<td width="110" align="right">';
								$html .= '<strong>' . number_format($totalEarnings, 2, '.', ',') . '</strong>';
							$html .= '</td>';
						$html .= '</tr>';
					$html .= '</table>';
				$html .= '</td>';
				$html .= '<td width="50%" valign="top">';
					$html .= '<table class="salary_info" cellspacing="0">';
						$html .= '<tr>';
							$html .= '<td align="left">';
								$html .= '<strong>Total Deductions</strong>';
							$html .= '</td>';
							$html .= '<td width="110" align="right">';
								$html .= '<strong>' . number_format($totalDeductions, 2, '.', ',') . '</strong>';
							$html .= '</td>';
						$html .= '</tr>';
					$html .= '</table>';
				$html .= '</td>';
			$html .= '</tr>';
		$html .= '</table>';

		$html .= '<div class="div_half">';
			$html .= '<h3 class="net_payable">';
				$html .= 'Net Salary Payable: Rs.' . number_format(($totalEarnings - $totalDeductions), 2, '.', ',');
			$html .= '</h3>';
		$html .= '</div>';
		$html .= '<div class="div_half">';
			$html .= '<h3 class="net_payable">';
				$html .= '<p class="in_word">(In words: ' . ucfirst($this->ConvertNumberToWords(($totalEarnings - $totalDeductions))) . ')</p>';
			$html .= '</h3>';
		$html .= '</div>';

		$html .= '<div class="signature">';
			$html .= '<table class="emp_info">';
				$html .= '<thead>';
					$html .= '<tr>';
						$html .= '<td>Date: ' . date('d-m-Y') . '</td>';
						$html .= '<th width="200">';
							$html .= '<img width="100" src="' . base_url() . 'system/images/IDGenerate/Sign.png" alt="Principal" /><br />';
							$html .= '<strong>Nani Gopal Paul, Director</strong>';
						$html .= '</th>';
					$html .= '</tr>';
				$html .= '</thead>';
			$html .= '</table>';
		$html .= '</div>';

		$html .= '<p class="com_info">';
			$html .= 'No. 15, Alwarpet,<br/>';
			$html .= 'Chennai, 560076,<br/>';
			$html .= 'Tamilnadu, INDIA<br/>';
			$html .= 'www.mssw.in';
		$html .= '</p>';
		$html .= '<p class="noseal"><small>Note: This is an electronically generated copy & therefore doesn’t require seal.</small></p>';

	    $pay_month = str_replace(', ', '-', $pay_month);
	    /*$payslip_path = dirname(dirname(__FILE__)) . '/payslips/';
	    if ( ! file_exists($payslip_path . $emp_code . '/') ) {
	    	mkdir($payslip_path . $emp_code, 0777);
	    }
	    if ( ! file_exists($payslip_path . $emp_code . '/' . $pay_month . '/') ) {
	    	mkdir($payslip_path . $emp_code . '/' . $pay_month, 0777);
	    }
		$mpdf->Output($payslip_path . $emp_code . '/' . $pay_month . '/' . $pay_month . '.pdf', 'F');*/
		
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("".$empData->employee_id_.".pdf", array("Attachment"=>1));
    	$result['code'] = 0;
    } else {
    	$result['code'] = 1;
    	$result['result'] = 'Something went wrong, please try again.';
    }

	//echo json_encode($result);
}

function SendPaySlipByMail() {
	$result = array();
	global $db;

	$emp_code = $_POST['emp_code'];
	$month 	  = $_POST['month'];
	$empData  = GetEmployeeDataByEmpCode($emp_code);
	if ( $empData ) {
		$empName  = $empData['first_name'] . ' ' . $empData['last_name'];
		$empEmail = $empData['email'];
		$subject  = 'PaySlip for ' . $month;
		$message  = '<p>Hi ' . $empData['first_name'] . '</p>';
		$message .= '<p>Here is your attached Salary Slip for the period of ' . $month . '.</p>';
		$message .= '<hr/>';
		$message .= '<p>Thank You,<br/>Wisely Online Services Private Limited</p>';
		$attachment[0]['src'] = dirname(dirname(__FILE__)) . '/payslips/' . $emp_code . '/' . str_replace(', ', '-', $month) . '/' . str_replace(', ', '-', $month) . '.pdf';
		$attachment[0]['name'] = str_replace(', ', '-', $month);
		$send = Send_Mail($subject, $message, $empName, $empEmail, FALSE, FALSE, FALSE, FALSE, $attachment);
		if ( $send == 0 ) {
			$result['code'] = 0;
			$result['result'] = 'PaySlip for ' . $month . ' has been successfully send to ' . $empName;
		} else {
			$result['code'] = 1;
			$result['result'] = 'PaySlip is not send, please try again.';
		}
	} else {
		$result['code'] = 2;
		$result['result'] = 'No such employee found.';
	}

	echo json_encode($result);
}

function EditProfileByID() {
	$result = array();
	global $db;

	if ( $_SESSION['Login_Type'] == 'admin' ) {
		$admin_id = $_SESSION['Admin_ID'];
		$admin_name = addslashes($_POST['admin_name']);
		$admin_email = addslashes($_POST['admin_email']);
		if ( !empty($admin_name) && !empty($admin_email) ) {
			$editSQL = mysqli_query($db, "UPDATE `" . DB_PREFIX . "admin` SET `admin_name` = '$admin_name', `admin_email` = '$admin_email' WHERE `admin_id` = $admin_id");
			if ( $editSQL ) {
				$result['code'] = 0;
				$result['result'] = 'Profile data has been successfully updated.';
			} else {
				$result['code'] = 1;
				$result['result'] = 'Something went wrong, please try again.';
			}
		} else {
			$result['code'] = 2;
			$result['result'] = 'All fields are mandatory.';
		}
	} else {
		$emp_id = stripslashes($_SESSION['Admin_ID']);
	    $first_name = stripslashes($_POST['first_name']);
	    $last_name = stripslashes($_POST['last_name']);
	    $dob = stripslashes($_POST['dob']);
	    $gender = stripslashes($_POST['gender']);
	    $merital_status = stripslashes($_POST['merital_status']);
	    $nationality = stripslashes($_POST['nationality']);
	    $address = stripslashes($_POST['address']);
	    $city = stripslashes($_POST['city']);
	    $state = stripslashes($_POST['state']);
	    $country = stripslashes($_POST['country']);
	    $email = stripslashes($_POST['email']);
	    $mobile = stripslashes($_POST['mobile']);
	    $telephone = stripslashes($_POST['telephone']);
	    $identity_doc = stripslashes($_POST['identity_doc']);
	    $identity_no = stripslashes($_POST['identity_no']);
	    $emp_type = stripslashes($_POST['emp_type']);
	    $joining_date = stripslashes($_POST['joining_date']);
	    $blood_group = stripslashes($_POST['blood_group']);
	    $designation = stripslashes($_POST['designation']);
	    $department = stripslashes($_POST['department']);
	    $pan_no = stripslashes($_POST['pan_no']);
	    $bank_name = stripslashes($_POST['bank_name']);
	    $account_no = stripslashes($_POST['account_no']);
	    $ifsc_code = stripslashes($_POST['ifsc_code']);
	    $pf_account = stripslashes($_POST['pf_account']);
	    if ( !empty($first_name) && !empty($last_name) && !empty($dob) && !empty($gender) && !empty($merital_status) && !empty($nationality) && !empty($address) && !empty($city) && !empty($state) && !empty($country) && !empty($email) && !empty($mobile) && !empty($identity_doc) && !empty($identity_no) && !empty($emp_type) && !empty($joining_date) && !empty($blood_group) && !empty($designation) && !empty($department) && !empty($pan_no) && !empty($bank_name) && !empty($account_no) && !empty($ifsc_code) && !empty($pf_account) ) {
	    	$updateEmp = mysqli_query($db, "UPDATE `" . DB_PREFIX . "employees` SET `first_name` = '$first_name', `last_name` = '$last_name', `dob` = '$dob', `gender` = '$gender', `merital_status` = '$merital_status', `nationality` = '$nationality', `address` = '$address', `city` = '$city', `state` = '$state', `country` = '$country', `email` = '$email', `mobile` = '$mobile', `telephone` = '$telephone', `identity_doc` = '$identity_doc', `identity_no` = '$identity_no', `emp_type` = '$emp_type', `joining_date` = '$joining_date', `blood_group` = '$blood_group', `designation` = '$designation', `department` = '$department', `pan_no` = '$pan_no', `bank_name` = '$bank_name', `account_no` = '$account_no', `ifsc_code` = '$ifsc_code', `pf_account` = '$pf_account' WHERE `emp_id` = $emp_id");
		    if ( $updateEmp ) {
		        $result['result'] = 'Profile data has been successfully updated.';
		        $result['code'] = 0;
		    } else {
		    	$result['result'] = 'Something went wrong, please try again.';
		    	$result['code'] = 1;
		    }
		} else {
			$result['result'] = 'All fields are mandatory except Telephone.';
			$result['code'] = 2;
		}
	}

	echo json_encode($result);
}

function EditLoginDataByID() {
	$result = array();
	global $db;

	if ( $_SESSION['Login_Type'] == 'admin' ) {
		$admin_id = $_SESSION['Admin_ID'];
		$admin_code = addslashes($_POST['admin_code']);
		$admin_password = addslashes($_POST['admin_password']);
		$admin_password_conf = addslashes($_POST['admin_password_conf']);
		if ( !empty($admin_code) && !empty($admin_password) && !empty($admin_password_conf) ) {
			if ( $admin_password == $admin_password_conf ) {
				$editSQL = mysqli_query($db, "UPDATE `" . DB_PREFIX . "admin` SET `admin_code` = '$admin_code', `admin_password` = '" . sha1($admin_password) . "' WHERE `admin_id` = $admin_id");
				if ( $editSQL ) {
					$result['code'] = 0;
					$result['result'] = 'Login data has been successfully updated.';
				} else {
					$result['code'] = 1;
					$result['result'] = 'Something went wrong, please try again.';
				}
			} else {
				$result['code'] = 2;
				$result['result'] = 'Confirm password does not match.';
			}
		} else {
			$result['code'] = 3;
			$result['result'] = 'All fields are mandatory.';
		}
	} else {
		$emp_id = $_SESSION['Admin_ID'];
		$old_password = addslashes($_POST['old_password']);
		$new_password = addslashes($_POST['new_password']);
		$password_conf = addslashes($_POST['password_conf']);
		if ( !empty($old_password) && !empty($new_password) && !empty($password_conf) ) {
			$checkPassSQL = mysqli_query($db, "SELECT * FROM `" . DB_PREFIX . "employees` WHERE `emp_id` = $emp_id");
			if ( $checkPassSQL ) {
				if ( mysqli_num_rows($checkPassSQL) == 1 ) {
					$passData = mysqli_fetch_assoc($checkPassSQL);
					if ( sha1($old_password) == $passData['emp_password'] ) {
						if ( $new_password == $password_conf ) {
							$editSQL = mysqli_query($db, "UPDATE `" . DB_PREFIX . "employees` SET `emp_password` = '" . sha1($new_password) . "' WHERE `emp_id` = $emp_id");
							if ( $editSQL ) {
								$result['code'] = 0;
								$result['result'] = 'Password has been successfully updated.';
							} else {
								$result['code'] = 1;
								$result['result'] = 'Something went wrong, please try again.';
							}
						} else {
							$result['code'] = 2;
							$result['result'] = 'Confirm password does not match.';
						}
					} else {
						$result['code'] = 3;
						$result['result'] = 'Entered wrong existing password.';
					}
				} else {
					$result['code'] = 4;
					$result['result'] = 'No such employee found.';
				}
			} else {
				$result['code'] = 5;
				$result['result'] = 'Something went wrong, please try again.';
			}
		} else {
			$result['code'] = 6;
			$result['result'] = 'All fields are mandatory.';
		}
	}

	echo json_encode($result);
}

function LoadingAllLeaves() {
	//$empData = GetDataByIDAndType($_SESSION['Admin_ID'], $_SESSION['Login_Type']);
	$requestData = $_REQUEST;
	$columns = array(
		0 => 'leave_id',
		1 => 'emp_code',
		2 => 'leave_subject',
		3 => 'leave_dates',
		4 => 'leave_message',
		5 => 'leave_type',
		6 => 'leave_status'
	);

	$sql  = "SELECT `leave_id` ";
	$sql .= " FROM `" . DB_PREFIX . "leaves`";
	$query = $this->db->query($sql);
	$totalData = $query->num_rows();
	$totalFiltered = $totalData;

	$sql  = "SELECT *";
	$sql .= " FROM `" . DB_PREFIX . "leaves` WHERE 1=1";
	if ( !empty($requestData['search']['value']) ) {
		$sql .= " AND (`leave_id` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `emp_code` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `leave_subject` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `leave_dates` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `leave_message` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `leave_type` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `leave_status` LIKE '" . $requestData['search']['value'] . "%')";
	}
	$query = $this->db->query($sql);
	$totalFiltered = $query->num_rows();
	$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
	$query = $this->db->query($sql);

	$data = array();
	$i = 1 + $requestData['start'];
	$sno = 1;
	$row = $query->result_array();
	foreach ( $row as $row ) {
		$emp_id=$this->db->where('id',$row["emp_code"])->get('erp_employee_master')->row();
		$nestedData = array();
		$nestedData[] = $sno.'<input type="hidden" value="'.$row["leave_id"].'">';
		$nestedData[] = '<a target="_blank" href="' . base_url() . 'payrolllogin/reports/' . $row["emp_code"] . '/">' . $emp_id->employee_id_ . '</a>';
		$nestedData[] = $row["leave_subject"];
		$nestedData[] = $row["leave_dates"];
		$nestedData[] = $row["leave_message"];
		$nestedData[] = $row["leave_type"];
		if ( $row["leave_status"] == 'pending' ) {
			$nestedData[] = '<span class="label label-warning">' . ucwords($row["leave_status"]) . '</span>';
		} elseif ( $row['leave_status'] == 'approve' ) {
			$nestedData[] = '<span class="label label-success">' . ucwords($row["leave_status"]) . 'd</span>';
		} elseif ( $row['leave_status'] == 'reject' ) {
			$nestedData[] = '<span class="label label-danger">' . ucwords($row["leave_status"]) . 'ed</span>';
		}
		$data[] = $nestedData;
		$i++;
		$sno++;
	}
	$json_data = array(
		"draw"            => intval($requestData['draw']),
		"recordsTotal"    => intval($totalData),
		"recordsFiltered" => intval($totalFiltered),
		"data"            => $data
	);

	echo json_encode($json_data);
}

function LoadingMyLeaves() {
	global $db;
	$empData = GetDataByIDAndType($_SESSION['Admin_ID'], $_SESSION['Login_Type']);
	$requestData = $_REQUEST;
	$columns = array(
		0 => 'leave_id',
		1 => 'leave_subject',
		2 => 'leave_dates',
		3 => 'leave_message',
		4 => 'leave_type',
		5 => 'leave_status'
	);

	$sql  = "SELECT `leave_id` ";
	$sql .= " FROM `" . DB_PREFIX . "leaves` WHERE `emp_code` = '" . $empData['emp_code'] . "'";
	$query = mysqli_query($db, $sql);
	$totalData = mysqli_num_rows($query);
	$totalFiltered = $totalData;

	$sql  = "SELECT *";
	$sql .= " FROM `" . DB_PREFIX . "leaves` WHERE `emp_code` = '" . $empData['emp_code'] . "'";
	if ( !empty($requestData['search']['value']) ) {
		$sql .= " AND (`leave_id` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `leave_subject` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `leave_dates` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `leave_message` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `leave_type` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `leave_status` LIKE '" . $requestData['search']['value'] . "%')";
	}
	$query = mysqli_query($db, $sql);
	$totalFiltered = mysqli_num_rows($query);
	$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
	$query = mysqli_query($db, $sql);

	$data = array();
	$i = 1 + $requestData['start'];
	while ( $row = mysqli_fetch_assoc($query) ) {
		$nestedData = array();
		$nestedData[] = $row["leave_id"];
		$nestedData[] = $row["leave_subject"];
		$nestedData[] = $row["leave_dates"];
		$nestedData[] = $row["leave_message"];
		$nestedData[] = $row["leave_type"];
		if ( $row["leave_status"] == 'pending' ) {
			$nestedData[] = '<span class="label label-warning">' . ucwords($row["leave_status"]) . '</span>';
		} elseif ( $row['leave_status'] == 'approve' ) {
			$nestedData[] = '<span class="label label-success">' . ucwords($row["leave_status"]) . 'd</span>';
		} elseif ( $row['leave_status'] == 'reject' ) {
			$nestedData[] = '<span class="label label-danger">' . ucwords($row["leave_status"]) . 'ed</span>';
		}
		$data[] = $nestedData;
		$i++;
	}
	$json_data = array(
		"draw"            => intval($requestData['draw']),
		"recordsTotal"    => intval($totalData),
		"recordsFiltered" => intval($totalFiltered),
		"data"            => $data
	);

	echo json_encode($json_data);
}

function ApplyLeaveToAdminApproval() {
	$result = array();
	global $db;

	$adminData = GetAdminData(1);
	$empData   = GetDataByIDAndType($_SESSION['Admin_ID'], $_SESSION['Login_Type']);

	$leave_subject = addslashes($_POST['leave_subject']);
	$leave_dates   = addslashes($_POST['leave_dates']);
	$leave_message = addslashes($_POST['leave_message']);
	$leave_type    = addslashes($_POST['leave_type']);
	if ( !empty($leave_subject) && !empty($leave_dates) && !empty($leave_message) && !empty($leave_type) ) {
		$AppliedDates = '';
		if ( strpos($leave_dates, ',') !== false ) {
			$dates = explode(',', $leave_dates);
			foreach ( $dates as $date ) {
				$checkLeaveSQL = mysqli_query($db, "SELECT * FROM `" . DB_PREFIX . "leaves` WHERE `leave_dates` LIKE '%$date%' AND `emp_code` = '" . $empData['emp_code'] . "'");
				if ( $checkLeaveSQL ) {
					if ( mysqli_num_rows($checkLeaveSQL) > 0 ) {
						$AppliedDates .= $date . ', ';
					}
				}
			}
		}
		if ( empty($AppliedDates) ) {
			$leaveSQL = mysqli_query($db, "INSERT INTO `" . DB_PREFIX . "leaves` (`emp_code`, `leave_subject`, `leave_dates`, `leave_message`, `leave_type`, `apply_date`) VALUES('" . $empData['emp_code'] . "', '$leave_subject', '$leave_dates', '$leave_message', '$leave_type', '" . date('Y-m-d H:i:s') . "')");
			if ( $leaveSQL ) {
				$empName    = $empData['first_name'] . ' ' . $empData['last_name'];
				$empEmail   = $empData['email'];
				$adminEmail = $adminData['admin_email'];
				$subject 	= 'Leave Application: ' . $leave_subject;
				$message    = '<p>Employee: ' . $empName . ' (' . $empData['emp_code'] . ')' . '</p>';
				$message   .= '<p>Leave Message: ' . $leave_message . '</p>';
				$message   .= '<p>Leave Date(s): ' . $leave_dates . '</p>';
				$message   .= '<p>Leave Type: ' . $leave_type . '</p>';
				$message   .= '<hr/>';
				$message   .= '<p>Please click on the buttons below or log into the admin area to get an action:</p>';
				$message   .= '<form method="post" action="' . BASE_URL . 'ajax/?case=ApproveLeaveApplication&id=' . mysqli_insert_id() . '" style="display:inline;">';
				$message   .= '<input type="hidden" name="id" value="' . mysqli_insert_id() . '" />';
				$message   .= '<button type="submit" style="background:green; border:1px solid green; color:white; padding:0 5px 3px; cursor:pointer; margin-right:15px;">Approve</button>';
				$message   .= '</form>';
				$message   .= '<form method="post" action="' . BASE_URL . 'ajax/?case=RejectLeaveApplication&id=' . mysqli_insert_id() . '" style="display:inline;">';
				$message   .= '<input type="hidden" name="id" value="' . mysqli_insert_id() . '" />';
				$message   .= '<button type="submit" style="background:red; border:1px solid red; color:white; padding:0 5px 3px; cursor:pointer;">Reject</button>';
				$message   .= '</form>';
				$message   .= '<p style="font-size:85%;">After clicking the button, please click on OK and then Continue to make your action complete.</p>';
				$message   .= '<hr/>';
				$message   .= '<p>Thank You<br/>' . $empName . '</p>';
				$adminName 	= $adminData['admin_name'];
				$send = Send_Mail($subject, $message, $adminName, $adminEmail, $empName, $empEmail);
				if ( $send == 0 ) {
					$result['code'] = 0;
					$result['result'] = 'Leave Application has been successfully send to your employer through mail.';
				} else {
					$result['code'] = 1;
					$result['result'] = 'Notice: Leave Application not send through E-Mail, please try again.';
				}
			} else {
				$result['code'] = 1;
				$result['result'] = 'Something went wrong, please try again.';
			}
		} else {
			$alreadyDates = substr($AppliedDates, 0, -2);
			$result['code'] = 2;
			$result['result'] = 'You have already applied for leave on ' . $alreadyDates . '. Please change the leave dates.';
		}
	} else {
		$result['code'] = 3;
		$result['result'] = 'All fields are mandatory.';
	}

	echo json_encode($result);
}

function ApproveLeaveApplication() {
	$result = array();

	$leaveId = $_REQUEST['id'];
	//$leaveId = 3;
	$leaveSQL = $this->db->query("SELECT * FROM `" . DB_PREFIX . "leaves` WHERE `leave_id` = $leaveId AND `leave_status` = 'pending' LIMIT 0, 1");
	if ( $leaveSQL ) {
		if ( $leaveSQL->num_rows() == 1 ) {
			$leaveData = $leaveSQL->row();
			$update = $this->db->query("UPDATE `" . DB_PREFIX . "leaves` SET `leave_status` = 'approve' WHERE `leave_id` = $leaveId");
			if ( $update ) {
					$result['code'] = 0;
					$result['result'] = 'Leave Application is successfully approved. A notification will be send to the employee.';
				$empData  = $this->GetEmployeeDataByEmpCode($leaveData->emp_code);
				if ( $empData ) {
					$empName  = $empData->emp_name_;
					$empEmail = $empData->emp_mail_;
					$subject  = 'Leave Application Approved';
					$message  = '<p>Hi ' . $empData->emp_name_ . '</p>';
					$message .= '<p>Your leave application is approved.</p>';
					$message .= '<p>Application Details:</p>';
					$message .= '<p>Subject: ' . $leaveData->leave_subject . '</p>';
					$message .= '<p>Leave Date(s): ' . $leaveData->leave_dates . '</p>';
					$message .= '<p>Message: ' . $leaveData->leave_message . '</p>';
					$message .= '<p>Leave Type: ' . $leaveData->leave_type . '</p>';
					$message .= '<p>Status: ' . ucwords($leaveData->leave_status) . '</p>';
					$message .= '<hr/>';
					$message .= '<p>Thank You,<br/>Wisely Online Services Private Limited</p>';
			$config = array(
	 'protocol' => 'smtp',
     'smtp_host' => 'ssl://smtp.gmail.com',
     'smtp_port' => 465,
     'smtp_user' => 'admission.mssw@gmail.com',
     'smtp_pass' => 'dqamafoawpedieqn',
     'mailtype' => 'html',
	 'charset' => 'iso-8859-1',  
	 'newline' => '\r\n',  
	 );

			$this->email->initialize($config);

            $this->email->set_mailtype("html");
            $this->email->from('admission.mssw@gmail.com');
            $this->email->to($email);
            $this->email->subject($subject);
            $this->email->message($message);
					//$send = Send_Mail($subject, $message, $empName, $empEmail);
					/*if ( $send == 0 ) {
						$result['code'] = 0;
						$result['result'] = 'Leave Application is successfully approved. An email notification will be send to the employee.';
					} else {
						$result['code'] = 1;
						$result['result'] = 'Leave Application is not approved, please try again.';
					}*/
				} else {
					$result['code'] = 2;
					$result['result'] = 'No such employee found.';
				}
			} else {
				$result['code'] = 1;
				$result['result'] = 'Something went wrong, please try again.';
			}
		} else {
			$result['code'] = 2;
			$result['result'] = 'This leave application is already verified.';
		}
	} else {
		$result['code'] = 3;
		$result['result'] = 'Something went wrong, please try again.';
	}

	echo json_encode($result);
}

function RejectLeaveApplication() {
	$result = array();

	$leaveId = $_REQUEST['id'];
	//$leaveId = 3;
	$leaveSQL = $this->db->query("SELECT * FROM `" . DB_PREFIX . "leaves` WHERE `leave_id` = $leaveId AND `leave_status` = 'pending' LIMIT 0, 1");
	if ( $leaveSQL ) {
		if ( $leaveSQL->num_rows() == 1 ) {
			$leaveData = $leaveSQL->row();
			$update = $this->db->query("UPDATE `" . DB_PREFIX . "leaves` SET `leave_status` = 'reject' WHERE `leave_id` = $leaveId");
			if ( $update ) {
				$result['code'] = 0;
				$result['result'] = 'Leave Application is rejected. A notification will be send to the employee.';
				$empData  = $this->GetEmployeeDataByEmpCode($leaveData->emp_code);
				if ( $empData ) {
					$empName  = $empData->emp_name_;
					$empEmail = $empData->emp_mail_;
					$subject  = 'Leave Application Rejected';
					$message  = '<p>Hi ' . $empData->emp_name_ . '</p>';
					$message .= '<p>Your leave application is rejected.</p>';
					$message .= '<p>Application Details:</p>';
					$message .= '<p>Subject: ' . $leaveData->leave_subject . '</p>';
					$message .= '<p>Leave Date(s): ' . $leaveData->leave_dates . '</p>';
					$message .= '<p>Message: ' . $leaveData->leave_message . '</p>';
					$message .= '<p>Leave Type: ' . $leaveData->leave_type . '</p>';
					$message .= '<p>Status: ' . ucwords($leaveData->leave_status) . '</p>';
					$message .= '<hr/>';
					$message .= '<p>Thank You,<br/>Madras School of Social Work</p>';
			$config = array(
	 'protocol' => 'smtp',
     'smtp_host' => 'ssl://smtp.gmail.com',
     'smtp_port' => 465,
     'smtp_user' => 'admission.mssw@gmail.com',
     'smtp_pass' => 'dqamafoawpedieqn',
     'mailtype' => 'html',
	 'charset' => 'iso-8859-1',  
	 'newline' => '\r\n',  
	 );

			$this->email->initialize($config);

            $this->email->set_mailtype("html");
            $this->email->from('admission.mssw@gmail.com');
            $this->email->to($email);
            $this->email->subject($subject);
            $this->email->message($message);
					//$send = Send_Mail($subject, $message, $empName, $empEmail);
					/*if ( $send == 0 ) {
						$result['code'] = 0;
						$result['result'] = 'Leave Application is rejected. An email notification will be send to the employee.';
					} else {
						$result['code'] = 1;
						$result['result'] = 'Leave Application is not rejected, please try again.';
					}*/
				} else {
					$result['code'] = 2;
					$result['result'] = 'No such employee found.';
				}
			} else {
				$result['code'] = 1;
				$result['result'] = 'Something went wrong, please try again.';
			}
		} else {
			$result['code'] = 2;
			$result['result'] = 'This leave application is already verified.';
		}
	} else {
		$result['code'] = 3;
		$result['result'] = 'Something went wrong, please try again.';
	}

	echo json_encode($result);
}

public function reports(){
	$id=$this->uri->segment(3);
	$data['empDATA']=$this->db->where('id',$id)->get('erp_employee_master')->row();
	$this->load->view('payroll/report',$data);
}
public function pay_salary(){
	$data['emp_code1']=$emp_code1=$this->uri->segment(3);
	$data['month1']=$month1=$this->uri->segment(4);
	$data['year1']=$year1=$this->uri->segment(5);
	
$data['empData'] = $empL = $this->GetEmployeeDataByEmpCode($emp_code1);
$data['month'] = $month = $month1 . ', ' . $year1;
$data['empLeave'] = $this->GetEmployeeLWPDataByEmpCodeAndMonth($emp_code1, $month);
$data['service'] = date('Y') - date('Y', strtotime($empL->emp_doj_));
$data['desination'] = $empL->emp_designation_;
$data['flag'] = $flag = 0;
$data['totalEarnings'] = $totalEarnings = 0;
$data['totalDeductions'] = $totalDeductions = 0;
$checkSalarySQL = $this->db->query("SELECT * FROM `wy_salaries` WHERE `emp_code` = '" . $emp_code1 . "' AND `pay_month` = '$month'");
if ( $checkSalarySQL ) {
	$checkSalaryROW = $checkSalarySQL->num_rows();
	if ( $checkSalaryROW > 0 ) {
		$data['flag'] = 1;
		$data['empSalary'] = $this->GetEmployeeSalaryByEmpCodeAndMonth($emp_code1, $month);
	} else {
		$data['empHeads'] = $this->GetEmployeePayheadsByEmpCode($emp_code1);
	}
}
$data['ConvertNumberToWords']=$this->ConvertNumberToWords(($totalEarnings - $totalDeductions));
    $this->load->view('payroll/template/header');
    $this->load->view('payroll/manage-salary',$data);
    $this->load->view('payroll/template/footer');
}

function GeneratePaySlipEmployee() {
	$result = array();

	$emp_code = $this->uri->segment(3);
    $month = $this->uri->segment(4);
    $year = $this->uri->segment(5);
    $pay_month = $month . ', ' . $year;
	/*$emp_code = '326';
    $pay_month = 'November, 2021';
    $earnings_heads = array('Basic Salary');
    $earnings_amounts = array('500');
    $deductions_heads = array('Other Deductions');
    $deductions_amounts = array('50');*/
        $this->session->set_flashdata('PaySlipMsg','Payslip Generated Successfully!','success');
        $this->load->library('pdf');
		$dompdf = new DOMPDF();
	    $empData = $this->GetEmployeeDataByEmpCode($emp_code);
	    $empSalary = $this->GetEmployeeSalaryByEmpCodeAndMonth($emp_code, $pay_month);
	    $empLeave = $this->GetEmployeeLWPDataByEmpCodeAndMonth($emp_code, $pay_month);
	    $totalEarnings = 0;
		$totalDeductions = 0;
		$role=$this->db->where('id',$empData->emp_designation_)->get('erp_role_master')->row();
		$dept=$this->db->where('id',$empData->emp_dept_name_)->get('erp_department')->row();
		$html = '<style>
		@page{margin:20px 20px;font-family:Arial;font-size:14px;}
    	.div_half{float:left;margin:0 0 30px 0;width:50%;}
    	.logo{width:250px;padding:0;}
    	.com_title{text-align:center;font-size:16px;margin:0;}
    	.reg_no{text-align:center;font-size:12px;margin:5px 0;}
    	.subject{text-align:center;font-size:20px;font-weight:bold;}
    	.emp_info{width:100%;margin:0 0 30px 0;}
    	.table{border:1px solid #ccc;margin:0 0 30px 0;}
    	.salary_info{width:100%;margin:0;}
    	.salary_info th,.salary_info td{border:1px solid #ccc;margin:0;padding:5px;vertical-align:middle;}
    	.net_payable{margin:0;color:#050;}
    	.in_word{text-align:right;font-size:12px;margin:5px 0;}
    	.signature{margin:0 0 30px 0;}
    	.signature strong{font-size:12px;padding:5px 0 0 0;border-top:1px solid #000;}
    	.com_info{font-size:12px;text-align:center;margin:0 0 30px 0;}
    	.noseal{text-align:center;font-size:11px;}
	    </style>';
	    $html .= '<div class="div_half">';
	    $html .= '<img class="logo" src="' . base_url() . 'system/images/IDGenerate/MSSW_Logo.png" alt="Wisely Online Services Private Limited" />';
	    $html .= '</div>';
	    $html .= '<div class="div_half">';
	    $html .= '<h2 class="com_title">Madras School of Social Work</h2>';
	    $html .= '<p class="reg_no">Registration Number: 063838, Chennai</p>';
	    $html .= '</div>';

	    $html .= '<p class="subject">Salary Slip for ' . $pay_month . '</p>';

	    $html .= '<table class="emp_info">';
	    $html .= '<tr>';
	    $html .= '<td width="25%">Employee Code</td>';
	    $html .= '<td width="25%">: ' . strtoupper($empData->employee_id_) . '</td>';
	    $html .= '<td width="25%">Bank Name</td>';
	    $html .= '<td width="25%">: ' . ucwords($empData->emp_bankname_) . '</td>';
	    $html .= '</tr>';

	    $html .= '<tr>';
	    $html .= '<td>Employee Name</td>';
	    $html .= '<td>: ' . ucwords($empData->emp_name_) . '</td>';
	    $html .= '<td>Bank Account</td>';
	    $html .= '<td>: ' . $empData->emp_accno_ . '</td>';
	    $html .= '</tr>';

	    $html .= '<tr>';
	    $html .= '<td>Designation</td>';
	    $html .= '<td>: ' . ucwords($role->role_name) . '</td>';
	    $html .= '<td>IFSC Code</td>';
	    $html .= '<td>: ' . strtoupper($empData->emp_ifsc_) . '</td>';
	    $html .= '</tr>';

	    $html .= '<tr>';
	    $html .= '<td>Location</td>';
	    $html .= '<td>: ' . ucwords($empData->emp_city_) . '</td>';
	    $html .= '<td>PF Account</td>';
	    $html .= '<td>: ' . strtoupper($empData->emp_pf_) . '</td>';
	    $html .= '</tr>';

	    $html .= '<tr>';
	    $html .= '<td>Department</td>';
	    $html .= '<td>: ' . ucwords($dept->dept_name_) . '</td>';
	    $html .= '<td>Payable/Working Days</td>';
	    $html .= '<td>: ' . ($empLeave['workingDays'] - $empLeave['withoutPay']) . '/' . $empLeave['workingDays'] . ' Days</td>';
	    $html .= '</tr>';

	    $html .= '<tr>';
	    $html .= '<td>Date of Joining</td>';
	    $html .= '<td>: ' . date('d-m-Y', strtotime($empData->emp_doj_)) . '</td>';
	    $html .= '<td>Taken/Remaining Leaves</td>';
	    $html .= '<td>: ' . $empLeave['payLeaves'] . '/' . ($empLeave['totalLeaves'] - $empLeave['payLeaves']) . ' Days</td>';
	    $html .= '</tr>';
	    $html .= '</table>';

		$html .= '<table class="table" cellspacing="0" cellpadding="0" width="100%">';
			$html .= '<thead>';
				$html .= '<tr>';
					$html .= '<th width="50%" valign="top">';
						$html .= '<table class="salary_info" cellspacing="0">';
							$html .= '<tr>';
								$html .= '<th align="left">Earnings</th>';
								$html .= '<th width="110" align="right">Amount (Rs.)</th>';
							$html .= '</tr>';
						$html .= '</table>';
					$html .= '</th>';
					$html .= '<th width="50%" valign="top">';
						$html .= '<table class="salary_info" cellspacing="0">';
							$html .= '<tr>';
								$html .= '<th align="left">Deductions</th>';
								$html .= '<th width="110" align="right">Amount (Rs.)</th>';
							$html .= '</tr>';
						$html .= '</table>';
					$html .= '</th>';
				$html .= '</tr>';
			$html .= '</thead>';

			if ( !empty($empSalary) ) {
				$html .= '<tr>';
					$html .= '<td width="50%" valign="top">';
						$html .= '<table class="salary_info" cellspacing="0">';
						foreach ( $empSalary as $salary ) {
							if ( $salary['pay_type'] == 'earnings' ) {
								$totalEarnings += $salary['pay_amount'];
								$html .= '<tr>';
									$html .= '<td align="left">';
										$html .= $salary['payhead_name'];
									$html .= '</td>';
									$html .= '<td width="110" align="right">';
										$html .= number_format($salary['pay_amount'], 2, '.', ',');
									$html .= '</td>';
								$html .= '</tr>';
							}
						}
						$html .= '</table>';
					$html .= '</td>';

					$html .= '<td width="50%" valign="top">';
						$html .= '<table class="salary_info" cellspacing="0">';
						foreach ( $empSalary as $salary ) {
							if ( $salary['pay_type'] == 'deductions' ) {
								$totalDeductions += $salary['pay_amount'];
								$html .= '<tr>';
									$html .= '<td align="left">';
										$html .= $salary['payhead_name'];
									$html .= '</td>';
									$html .= '<td width="110" align="right">';
										$html .= number_format($salary['pay_amount'], 2, '.', ',');
									$html .= '</td>';
								$html .= '</tr>';
							}
						}
						$html .= '</table>';
					$html .= '</td>';
				$html .= '</tr>';
			} else {
				$html .= '<tr>';
					$html .= '<td colspan="2" width="100%">No payheads are assigned for this employee</td>';
				$html .= '</tr>';
			}

			$html .= '<tr>';
				$html .= '<td width="50%" valign="top">';
					$html .= '<table class="salary_info" cellspacing="0">';
						$html .= '<tr>';
							$html .= '<td align="left">';
								$html .= '<strong>Total Earnings</strong>';
							$html .= '</td>';
							$html .= '<td width="110" align="right">';
								$html .= '<strong>' . number_format($totalEarnings, 2, '.', ',') . '</strong>';
							$html .= '</td>';
						$html .= '</tr>';
					$html .= '</table>';
				$html .= '</td>';
				$html .= '<td width="50%" valign="top">';
					$html .= '<table class="salary_info" cellspacing="0">';
						$html .= '<tr>';
							$html .= '<td align="left">';
								$html .= '<strong>Total Deductions</strong>';
							$html .= '</td>';
							$html .= '<td width="110" align="right">';
								$html .= '<strong>' . number_format($totalDeductions, 2, '.', ',') . '</strong>';
							$html .= '</td>';
						$html .= '</tr>';
					$html .= '</table>';
				$html .= '</td>';
			$html .= '</tr>';
		$html .= '</table>';

		$html .= '<div class="div_half">';
			$html .= '<h3 class="net_payable">';
				$html .= 'Net Salary Payable: Rs.' . number_format(($totalEarnings - $totalDeductions), 2, '.', ',');
			$html .= '</h3>';
		$html .= '</div>';
		$html .= '<div class="div_half">';
			$html .= '<h3 class="net_payable">';
				$html .= '<p class="in_word">(In words: ' . ucfirst($this->ConvertNumberToWords(($totalEarnings - $totalDeductions))) . ')</p>';
			$html .= '</h3>';
		$html .= '</div>';

		$html .= '<div class="signature">';
			$html .= '<table class="emp_info">';
				$html .= '<thead>';
					$html .= '<tr>';
						$html .= '<td>Date: ' . date('d-m-Y') . '</td>';
						$html .= '<th width="200">';
							$html .= '<img width="100" src="' . base_url() . 'system/images/IDGenerate/Sign.png" alt="Principal" /><br />';
							$html .= '<strong>Nani Gopal Paul, Director</strong>';
						$html .= '</th>';
					$html .= '</tr>';
				$html .= '</thead>';
			$html .= '</table>';
		$html .= '</div>';

		$html .= '<p class="com_info">';
			$html .= 'No. 15, Alwarpet,<br/>';
			$html .= 'Chennai, 560076,<br/>';
			$html .= 'Tamilnadu, INDIA<br/>';
			$html .= 'www.mssw.in';
		$html .= '</p>';
		$html .= '<p class="noseal"><small>Note: This is an electronically generated copy & therefore doesn’t require seal.</small></p>';

	    $pay_month = str_replace(', ', '-', $pay_month);
	    /*$payslip_path = dirname(dirname(__FILE__)) . '/payslips/';
	    if ( ! file_exists($payslip_path . $emp_code . '/') ) {
	    	mkdir($payslip_path . $emp_code, 0777);
	    }
	    if ( ! file_exists($payslip_path . $emp_code . '/' . $pay_month . '/') ) {
	    	mkdir($payslip_path . $emp_code . '/' . $pay_month, 0777);
	    }
		$mpdf->Output($payslip_path . $emp_code . '/' . $pay_month . '/' . $pay_month . '.pdf', 'F');*/
		
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("".$empData->employee_id_.".pdf", array("Attachment"=>1));
    	$result['code'] = 0;
        exit;
	//echo json_encode($result);
}

function employeePayslipMail() {
	 $empData = $this->GetEmployeeDataByEmpCode($emp_code);
	    $empSalary = $this->GetEmployeeSalaryByEmpCodeAndMonth($emp_code, $pay_month);
	    $empLeave = $this->GetEmployeeLWPDataByEmpCodeAndMonth($emp_code, $pay_month);
	    $totalEarnings = 0;
		$totalDeductions = 0;
		$role=$this->db->where('id',$empData->emp_designation_)->get('erp_role_master')->row();
		$dept=$this->db->where('id',$empData->emp_dept_name_)->get('erp_department')->row();
		$html = '<style>
		@page{margin:20px 20px;font-family:Arial;font-size:14px;}
    	.div_half{float:left;margin:0 0 30px 0;width:50%;}
    	.logo{width:250px;padding:0;}
    	.com_title{text-align:center;font-size:16px;margin:0;}
    	.reg_no{text-align:center;font-size:12px;margin:5px 0;}
    	.subject{text-align:center;font-size:20px;font-weight:bold;}
    	.emp_info{width:100%;margin:0 0 30px 0;}
    	.table{border:1px solid #ccc;margin:0 0 30px 0;}
    	.salary_info{width:100%;margin:0;}
    	.salary_info th,.salary_info td{border:1px solid #ccc;margin:0;padding:5px;vertical-align:middle;}
    	.net_payable{margin:0;color:#050;}
    	.in_word{text-align:right;font-size:12px;margin:5px 0;}
    	.signature{margin:0 0 30px 0;}
    	.signature strong{font-size:12px;padding:5px 0 0 0;border-top:1px solid #000;}
    	.com_info{font-size:12px;text-align:center;margin:0 0 30px 0;}
    	.noseal{text-align:center;font-size:11px;}
	    </style>';
	    $html .= '<div class="div_half">';
	    $html .= '<img class="logo" src="' . base_url() . 'system/images/IDGenerate/MSSW_Logo.png" alt="Wisely Online Services Private Limited" />';
	    $html .= '</div>';
	    $html .= '<div class="div_half">';
	    $html .= '<h2 class="com_title">Madras School of Social Work</h2>';
	    $html .= '<p class="reg_no">Registration Number: 063838, Chennai</p>';
	    $html .= '</div>';

	    $html .= '<p class="subject">Salary Slip for ' . $pay_month . '</p>';

	    $html .= '<table class="emp_info">';
	    $html .= '<tr>';
	    $html .= '<td width="25%">Employee Code</td>';
	    $html .= '<td width="25%">: ' . strtoupper($empData->employee_id_) . '</td>';
	    $html .= '<td width="25%">Bank Name</td>';
	    $html .= '<td width="25%">: ' . ucwords($empData->emp_bankname_) . '</td>';
	    $html .= '</tr>';

	    $html .= '<tr>';
	    $html .= '<td>Employee Name</td>';
	    $html .= '<td>: ' . ucwords($empData->emp_name_) . '</td>';
	    $html .= '<td>Bank Account</td>';
	    $html .= '<td>: ' . $empData->emp_accno_ . '</td>';
	    $html .= '</tr>';

	    $html .= '<tr>';
	    $html .= '<td>Designation</td>';
	    $html .= '<td>: ' . ucwords($role->role_name) . '</td>';
	    $html .= '<td>IFSC Code</td>';
	    $html .= '<td>: ' . strtoupper($empData->emp_ifsc_) . '</td>';
	    $html .= '</tr>';

	    $html .= '<tr>';
	    $html .= '<td>Location</td>';
	    $html .= '<td>: ' . ucwords($empData->emp_city_) . '</td>';
	    $html .= '<td>PF Account</td>';
	    $html .= '<td>: ' . strtoupper($empData->emp_pf_) . '</td>';
	    $html .= '</tr>';

	    $html .= '<tr>';
	    $html .= '<td>Department</td>';
	    $html .= '<td>: ' . ucwords($dept->dept_name_) . '</td>';
	    $html .= '<td>Payable/Working Days</td>';
	    $html .= '<td>: ' . ($empLeave['workingDays'] - $empLeave['withoutPay']) . '/' . $empLeave['workingDays'] . ' Days</td>';
	    $html .= '</tr>';

	    $html .= '<tr>';
	    $html .= '<td>Date of Joining</td>';
	    $html .= '<td>: ' . date('d-m-Y', strtotime($empData->emp_doj_)) . '</td>';
	    $html .= '<td>Taken/Remaining Leaves</td>';
	    $html .= '<td>: ' . $empLeave['payLeaves'] . '/' . ($empLeave['totalLeaves'] - $empLeave['payLeaves']) . ' Days</td>';
	    $html .= '</tr>';
	    $html .= '</table>';

		$html .= '<table class="table" cellspacing="0" cellpadding="0" width="100%">';
			$html .= '<thead>';
				$html .= '<tr>';
					$html .= '<th width="50%" valign="top">';
						$html .= '<table class="salary_info" cellspacing="0">';
							$html .= '<tr>';
								$html .= '<th align="left">Earnings</th>';
								$html .= '<th width="110" align="right">Amount (Rs.)</th>';
							$html .= '</tr>';
						$html .= '</table>';
					$html .= '</th>';
					$html .= '<th width="50%" valign="top">';
						$html .= '<table class="salary_info" cellspacing="0">';
							$html .= '<tr>';
								$html .= '<th align="left">Deductions</th>';
								$html .= '<th width="110" align="right">Amount (Rs.)</th>';
							$html .= '</tr>';
						$html .= '</table>';
					$html .= '</th>';
				$html .= '</tr>';
			$html .= '</thead>';

			if ( !empty($empSalary) ) {
				$html .= '<tr>';
					$html .= '<td width="50%" valign="top">';
						$html .= '<table class="salary_info" cellspacing="0">';
						foreach ( $empSalary as $salary ) {
							if ( $salary['pay_type'] == 'earnings' ) {
								$totalEarnings += $salary['pay_amount'];
								$html .= '<tr>';
									$html .= '<td align="left">';
										$html .= $salary['payhead_name'];
									$html .= '</td>';
									$html .= '<td width="110" align="right">';
										$html .= number_format($salary['pay_amount'], 2, '.', ',');
									$html .= '</td>';
								$html .= '</tr>';
							}
						}
						$html .= '</table>';
					$html .= '</td>';

					$html .= '<td width="50%" valign="top">';
						$html .= '<table class="salary_info" cellspacing="0">';
						foreach ( $empSalary as $salary ) {
							if ( $salary['pay_type'] == 'deductions' ) {
								$totalDeductions += $salary['pay_amount'];
								$html .= '<tr>';
									$html .= '<td align="left">';
										$html .= $salary['payhead_name'];
									$html .= '</td>';
									$html .= '<td width="110" align="right">';
										$html .= number_format($salary['pay_amount'], 2, '.', ',');
									$html .= '</td>';
								$html .= '</tr>';
							}
						}
						$html .= '</table>';
					$html .= '</td>';
				$html .= '</tr>';
			} else {
				$html .= '<tr>';
					$html .= '<td colspan="2" width="100%">No payheads are assigned for this employee</td>';
				$html .= '</tr>';
			}

			$html .= '<tr>';
				$html .= '<td width="50%" valign="top">';
					$html .= '<table class="salary_info" cellspacing="0">';
						$html .= '<tr>';
							$html .= '<td align="left">';
								$html .= '<strong>Total Earnings</strong>';
							$html .= '</td>';
							$html .= '<td width="110" align="right">';
								$html .= '<strong>' . number_format($totalEarnings, 2, '.', ',') . '</strong>';
							$html .= '</td>';
						$html .= '</tr>';
					$html .= '</table>';
				$html .= '</td>';
				$html .= '<td width="50%" valign="top">';
					$html .= '<table class="salary_info" cellspacing="0">';
						$html .= '<tr>';
							$html .= '<td align="left">';
								$html .= '<strong>Total Deductions</strong>';
							$html .= '</td>';
							$html .= '<td width="110" align="right">';
								$html .= '<strong>' . number_format($totalDeductions, 2, '.', ',') . '</strong>';
							$html .= '</td>';
						$html .= '</tr>';
					$html .= '</table>';
				$html .= '</td>';
			$html .= '</tr>';
		$html .= '</table>';

		$html .= '<div class="div_half">';
			$html .= '<h3 class="net_payable">';
				$html .= 'Net Salary Payable: Rs.' . number_format(($totalEarnings - $totalDeductions), 2, '.', ',');
			$html .= '</h3>';
		$html .= '</div>';
		$html .= '<div class="div_half">';
			$html .= '<h3 class="net_payable">';
				$html .= '<p class="in_word">(In words: ' . ucfirst($this->ConvertNumberToWords(($totalEarnings - $totalDeductions))) . ')</p>';
			$html .= '</h3>';
		$html .= '</div>';

		$html .= '<div class="signature">';
			$html .= '<table class="emp_info">';
				$html .= '<thead>';
					$html .= '<tr>';
						$html .= '<td>Date: ' . date('d-m-Y') . '</td>';
						$html .= '<th width="200">';
							$html .= '<img width="100" src="' . base_url() . 'system/images/IDGenerate/Sign.png" alt="Principal" /><br />';
							$html .= '<strong>Nani Gopal Paul, Director</strong>';
						$html .= '</th>';
					$html .= '</tr>';
				$html .= '</thead>';
			$html .= '</table>';
		$html .= '</div>';

		$html .= '<p class="com_info">';
			$html .= 'No. 15, Alwarpet,<br/>';
			$html .= 'Chennai, 560076,<br/>';
			$html .= 'Tamilnadu, INDIA<br/>';
			$html .= 'www.mssw.in';
		$html .= '</p>';
		$html .= '<p class="noseal"><small>Note: This is an electronically generated copy & therefore doesn’t require seal.</small></p>';

            $this->load->library('email');
			$email='arokiya@istudiotech.com';

            $config['protocol'] = "smtp";
			$config['smtp_host'] = "mail.supremecluster.com";
			$config['smtp_port'] = "25";
			$config['smtp_user'] = "info@seoxpertise.org"; 
			$config['smtp_pass'] = "ISTadmin123*";
			$config['charset'] = "utf-8";
			$config['mailtype'] = "html";
			$config['newline'] = "\r\n";

			$this->email->initialize($config);

            $this->email->set_mailtype("html");
            $this->email->from('info@seoxpertise.org','MSSW');
            $this->email->to($email);
            $this->email->subject('Registration Success Email.');
            $this->email->message($html);
            if ($this->email->send()) {
                //return "Success";
            } else {
                //return "Notsend";
            }
    }
	
public function enterLeaves()
	{
		$data['user_id']=$user_id = $this->session->userdata('user')['user_id'];
		$data['employee']=$this->db->where('emp_working_status_','Working')->get('erp_employee_master')->result();
    $this->load->view('payroll/template/header');
    $this->load->view('payroll/enter-leaves',$data);
    $this->load->view('payroll/template/footer');
    }
	
function InsertUpdateLeaves() {
	$user_id = $this->session->userdata('user')['user_id'];
	$add_date = date('Y-m-d H:i:s');
	$result = array();

	$employee_code = stripslashes($_POST['employee_code']);
    $leave_type = stripslashes($_POST['leave_type']);
    $leave_no = stripslashes($_POST['leave_no']);
    if ( !empty($employee_code) && !empty($leave_type) && !empty($leave_no) ) {
	    if ( !empty($_POST['leave_id']) ) {
	    	$leave_id = addslashes($_POST['leave_id']);
	    	$updatePayhead = $this->db->query("UPDATE `" . DB_PREFIX . "leavecount` SET `emp_id` = '$employee_code', `type` = '$leave_type', `no_of_leave` = '$leave_no' WHERE `id` = $leave_id");
		    if ( $updatePayhead ) {
		        $result['result'] = 'Leaves record has been successfully updated.';
		        $result['code'] = 0;
		    } else {
		    	$result['result'] = 'Something went wrong, please try again.';
		    	$result['code'] = 1;
		    }
	    } else {
			$get = $this->db->where('emp_id',$employee_code)->where('type',$leave_type)->get('wy_leavecount')->row();
			if(!isset($get)){
	    	$insertPayhead = $this->db->query("INSERT INTO `" . DB_PREFIX . "leavecount`(`emp_id`, `type`, `no_of_leave`, `user_id`, `created_at`) VALUES ('$employee_code', '$leave_type', '$leave_no', '$user_id', '$add_date')");
		    if ( $insertPayhead ) {
		        $result['result'] = 'Leaves record has been successfully inserted.';
		        $result['code'] = 0;
		    } else {
		    	$result['result'] = 'Something went wrong, please try again.';
		    	$result['code'] = 1;
		    }
			} else {
				$result['result'] = 'Leave type for the employee has already been entered.';
		    	$result['code'] = 1;
			}
		}
	} else {
		$result['result'] = 'Leaves details should not be blank.';
		$result['code'] = 2;
	}

	echo json_encode($result);
}	
	
function GetLeaveNoByID() {
	$user_id = $this->session->userdata('user')['user_id'];
	$result = array();

	$id = $_POST['id'];
	$holiSQL = $this->db->query("SELECT * FROM `" . DB_PREFIX . "leavecount` WHERE `id` = $id LIMIT 0, 1");
	if ( $holiSQL ) {
		if ( $holiSQL->num_rows() == 1 ) {
			$result['result'] = $holiSQL->row();
			$result['code'] = 0;
		} else {
			$result['result'] = 'Leave record is not found.';
			$result['code'] = 1;
		}
	} else {
		$result['result'] = 'Something went wrong, please try again.';
		$result['code'] = 2;
	}

	echo json_encode($result);
}

function DeleteLeaveNoByID() {
	$result = array();

	$id = $_POST['id'];
	$holiSQL = $this->db->query("DELETE FROM `" . DB_PREFIX . "leavecount` WHERE `id` = $id");
	if ( $holiSQL ) {
		$result['result'] = 'Leave record is successfully deleted.';
		$result['code'] = 0;
	} else {
		$result['result'] = 'Something went wrong, please try again.';
		$result['code'] = 1;
	}

	echo json_encode($result);
}	

function LoadingLeaveEntry() {
	$user_id = $this->session->userdata('user')['user_id'];
	$requestData = $_REQUEST;
	$columns = array(
		0 => 'id',
		1 => 'emp_id',
		2 => 'type',
		3 => 'no_of_leave'
	);

	$sql  = "SELECT `id` ";
	$sql .= " FROM `" . DB_PREFIX . "leavecount` WHERE user_id = $user_id ";
	$query = $this->db->query($sql);
	$totalData = $query->num_rows();
	$totalFiltered = $totalData;

	$sql  = "SELECT l.*, m.emp_name_";
	$sql .= " FROM `" . DB_PREFIX . "leavecount` as l LEFT JOIN erp_employee_master as m ON l.emp_id=m.id WHERE l.user_id = $user_id ";
	if ( !empty($requestData['search']['value']) ) {
		$sql .= " AND (`id` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `emp_name_` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `type` LIKE '" . $requestData['search']['value'] . "%'";
		$sql .= " OR `no_of_leave` LIKE '" . $requestData['search']['value'] . "%')";
	}
	$query = $this->db->query($sql);
	$totalFiltered = $query->num_rows();
	$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
	$query = $this->db->query($sql);

	$data = array();
	$arr = 1;
	$i = 1 + $requestData['start'];
	$row = $query->result_array();
	foreach ( $row as $row ) {
		$nestedData = array();
		$nestedData[] = $arr.'<input type="hidden" value="'.$row["id"].'">';
		$nestedData[] = $row["emp_name_"];
		$nestedData[] = $row["type"];
		$nestedData[] = $row["no_of_leave"];
		$data[] = $nestedData;
		$i++;
		$arr++;
	}
	$json_data = array(
		"draw"            => intval($requestData['draw']),
		"recordsTotal"    => intval($totalData),
		"recordsFiltered" => intval($totalFiltered),
		"data"            => $data
	);

	echo json_encode($json_data);
}	
	
}
