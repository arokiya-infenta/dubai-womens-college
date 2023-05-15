<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wapcos extends CI_Controller {


	public function __construct(){
		
		parent::__construct();
	
		date_default_timezone_set("Asia/Calcutta"); 
		$this->load->config('email');
		$this->load->library('email');
			$this->load->library('pdf');
		//	ob_start();

	}
	public function masterTest(){
				
			$this->email->set_newline("\r\n");
			$this->email->from('admin@iitmanagement.co.in');
			$this->email->to('yuvaraj@istudiotech.com');
			$this->email->subject('Observation Closed Successfully ');
			$this->email->message('New email config in server');
			$this->email->send();
	}
	
	public function masterSms(){
	$url = 'http://hpapi.dial4sms.com/SendSMS/sendmsg.php?uname=wapcost&pass=wapcost&send=WAPCOS&dest=9444909420&msg=hi%20Yuvan%2CVerify%20you%20mobile%2E%20Your%20verification%20code%20is%201407%22';	
		
/* $url ='https://hp.dial4sms.com/SendSMS/sendmsg.php?uname=wapcost&pass=wapcost&send=WAPCOS&dest=9444909420&msg='.'Welcome yuva'; */
		
		
/* 		
		
$curl_handle=curl_init();
curl_setopt($curl_handle, CURLOPT_URL,$url);
curl_setopt($curl_handle, CURLOPT_TIMEOUT,500);
curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Your application name');
curl_setopt($curl_handle, CURLOPT_FAILONERROR, true);
curl_setopt($curl_handle, CURLOPT_FOLLOWLOCATION, false);
 
$query = curl_exec($curl_handle);
//curl_close($curl_handle); 

if (curl_errno($curl_handle)) {
    $error_msg = curl_error($curl_handle);
}
curl_close($curl_handle);

if (isset($error_msg)) {
	
	print_r($error_msg);
    // TODO - Handle cURL error accordingly
} */


		
 /* 		$ch=curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);  */

 echo file_get_contents($url);  
		
		
	}
	public function manageFcastProject(){
		
		$pr_id = $this->uri->segment(3);
		
		
	$project  = $this->db->select('*')->from('project_details')->where('p_id',$pr_id)->get();
		
	$data['project'] = $project->result();	
		

	$this->db->select('*');
	$this->db->from('add_forcasting');
	//$this->db->->where('af_sed_id',$pr_id)

	$this->db->join('mile_stone', 'mile_stone.ms_id = add_forcasting.af_milstone_id');
	$this->db->join('activities', 'activities.act_id = add_forcasting.af_act_id');
	$this->db->join('task__s', 'task__s.ts_id = add_forcasting.af_task_id');
	$this->db->join('forcasting_work', 'forcasting_work.fsw_id = add_forcasting.af_workid');
	$this->db->where('add_forcasting.af_sed_id',$pr_id);
	$this->db->order_by('add_forcasting.af_task_id','ASC');

	$project  = $this->db->get();
		
	$data['forcast'] = $project->result();

		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/mastermanageforcasting',$data);
		$this->load->view('wapcos/template/footer');
	}

public function AddForcastingDet(){
		
		$pr_id = $this->uri->segment(3);
		$data['pr_id'] = $pr_id;
		$milestone = $this->db->select('*')->from('mile_stone')->where('ms_s_id',$pr_id)->get();
		$data['milestone'] = $milestone->result();
		
		
		/* $activities = $this->db->select('*')->from('activities')->where('act_sc_id',$pr_id)->get();
		$data['activities'] = $activities->result(); */
		
		
		$forcasting_work = $this->db->select('*')->from('forcasting_work')->get();
		$data['forcasting_work'] = $forcasting_work->result();
		
		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/masteraddforcasting',$data);
		$this->load->view('wapcos/template/footer');
	
	}
	public function calForcasting(){
		
			
		$id = $_POST['act_id'];
		
	
		$this->db->select('*');
		$this->db->from('forcasting');
		$this->db->join('forcasting_work', 'forcasting_work.fsw_id = forcasting.fs_task_name');
		$this->db->where('forcasting_work.fsw_status',1);
		$this->db->where('forcasting_work.fsw_id',$id);
		$append = $this->db->get();
		
		
		
		
		//$append = $this->db->select('*')->from('forcasting')->where('fs_task_name',$id)->get();
		
		$result = $append->result();
		
		$html = "";
		
		
		foreach($result as $val){
	$html .= '<tr class="acc"><td>'.$val->fsw_unit .'</td><td><input type="text" class="form-control testure" name="test"></td><td>'.$val->fs_Machinery .'</td><td><input class="form-control" value="'.$val->fs_mac_qty .'"><input type="hidden" class="raj" value="'.$val->fs_mac_qty .'"></td>
	<td>'.$val->fs_material .'</td><td>'.$val->fs_mat_qty .'</td>
	
	
	
	<td>'.$val->fs_manpower .'</td><td><input class="form-control" value="'.$val->fs_man_qty .'"></td></tr>';	
			
			
			
			
			
			
		}
		
		
		
	echo $html;	
		
		
		
		
	}

	public function calForcastingRes(){

			$id = $_POST['act_id'];
			
			
			
			$this->db->select('*');
			$this->db->from('forcasting_work');
		//	$this->db->join('forcasting_work', 'forcasting_work.fsw_id = forcasting.fs_task_name');
			$this->db->where('fsw_status',1);
			$this->db->where('fsw_id',$id);
			$append = $this->db->get();
			$resultt = $append->result(); 

			
			echo json_encode( $resultt);

	}
	
	public function calForcastingTakeRes(){


				$id= $_POST['id'];




		$this->db->select('*');
		$this->db->from('forcasting');
		//$this->db->join('forcasting_work', 'forcasting_work.fsw_id = forcasting.fs_task_name');
		//$this->db->where('forcasting_work.fsw_status',1);
		$this->db->where('fs_task_name',$id);
		$append = $this->db->get();
		
		
		
		
		//$append = $this->db->select('*')->from('forcasting')->where('fs_task_name',$id)->get();
		
		$result = $append->result();











echo json_encode( $result);





}
public function CreateFourcasting(){



			//print_r($_POST);

			
			$proj_id = $this->input->post('proj_id');
			$milstone = $this->input->post('milstone');
			$activity = $this->input->post('activity');
			$task_id = $this->input->post('task_id');
			$work_id = $this->input->post('workid');
			$input_units = $this->input->post('input_units');
			



		$result =	$this->db->select('*')
			->from('add_forcasting')
			->where('af_sed_id',$proj_id)
			->where('af_milstone_id',$milstone)
			->where('af_act_id',$activity)
			->where('af_task_id',$task_id)
			->where('af_workid',$work_id)
		//	->where('af_workid',$work_id)
			->get();


			$val = $result->num_rows();


			if($val > 0 ){


				echo 1;

				exit;

			}else{


		$data = array(

				'af_sed_id'=>$proj_id,
				'af_milstone_id'=>$milstone,
				'af_act_id'=>$activity,
				'af_task_id'=>$task_id,
				'af_input_units'=>$input_units,
				'af_workid'=>$work_id,

		);

			$this->db->insert('add_forcasting',$data);
			$insert_id = $this->db->insert_id();


		$forcas_id = $this->input->post('forcastinfo');
		$machine = $this->input->post('machine');
		$material = $this->input->post('material');
		$man = $this->input->post('man');


		for($i=0;$i<=sizeof($forcas_id)-1;$i++){


		$resut = array(
			
			'ad_f_id'=>$insert_id,
			'forcastinfo_id'=>$forcas_id[$i],
			'machine_value'=>$machine[$i],
			'material_value'=>$material[$i],
			'manqty_value'=>$man[$i],
			
		);
			$this->db->insert('add_forcasting_dependancy',$resut);

		}
		}
	}

	public function selectTask(){
		
		$id = $_POST['act_id'];
		
		
		$task = $this->db->select('*')->from('task__s')->where('ts_ac_id',$id)->get();
		
		$data = $task->result();
		
		$html ='<option   value="">Select Task<option>';
		foreach($data as $val){
			
			
			$html .='<option   value="'.$val->ts_id .'">'.$val->ts_name .'</option>';
			
			
			
		}
		echo $html;
		
	}
	public function manageForcasting(){
		
		
		
		/* $this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/mastermanageforcasting');
		$this->load->view('wapcos/template/footer'); */
		
		
		
		
	}
	
	
	public function criticalpath(){
		
		
		
		echo $id = 4;
		
		
		$task = $this->db->select('*')->from('task__s')->where('ts_pr_id',$id)->get();		
		$tssk = $task->result();
		
		$activity = $this->db->select('*')->from('activities')->where('act_sc_id',$id)->get();		
		$actta = $activity->result();
		
		
		//print_r($actta);
		
		$a = array();
		
		foreach($actta as $cva){
		echo"act : ". $ac_id = $cva->act_id;
			
			
		 foreach ($tssk as $var){
			
		$tid = $var->ts_id;
				
		 $tad = $this->db->select('*')->from('task__s')->where('ts_id',$tid)->get();
		
		$restu = $tad->result(); 
		
		$actt = $this->db->select('ts_id')->from('task__s')->where('ts_id !=',$tid)->where('ts_end <=',$restu[0]->ts_start)->where('ts_ac_id',$ac_id)->get();
		$varr = $actt->result_array();	
		//echo $tid;
		/*  echo "<pre>";
		print_r($varr); */ 
		/* $crick_path = 	implode(",",$varr);
		
		print_r( $crick_path); */
		
		
		 foreach($varr as $test ){
			
			
			
			array_push($a,$test['ts_id']);
			
			//echo $test->ts_id ."<br>";
				
		} 
	/* 	 echo "<pre>";
		print_r((array_unique($a))); */
		
		
		} 
		}
		/* echo"<pre>";
		print_r($varr); */
			
	//$crick_path = 	implode(",",$_POST['checkbox']);
	
	
	
	/* if($_POST['checkbox']== ""){
		
		
		$vid = null;
		
	}else{
		
	$vid = $crick_path;	
		
	}
	
	
	$id= $_POST['tas_id'];
		
		
		$data =array(
		'ts_critical'=>$vid,
		);
		
		$this->db->where('ts_id',$id);
		$this->db->update('task__s',$data); */
		
		
		
		/* $id = $_POST['crit'];
				
		$tad = $this->db->select('*')->from('task__s')->where('ts_id',$id)->get();
		
		$restu = $tad->result();
		
		$actt = $this->db->select('*')->from('task__s')->where('ts_id !=',$id)->where('ts_end <=',$restu[0]->ts_start)->where('ts_ac_id',$restu[0]->ts_ac_id)->get();
		$varr=$actt->result(); */

	/* $html="";
	
	foreach($varr as $test){
		
	$html.=	'<div class="checkbox">
	<input type="checkbox" name="checkbox[]" value="'.$test->ts_id .'"> ' . $test->ts_name .'
	</div>';
		
	}
	
	echo $html;	 */

	}
	public function manageMaterialising(){
		
		
		$this->db->select('*');
		$this->db->from('forcasting');
		$this->db->join('forcasting_work', 'forcasting_work.fsw_id = forcasting.fs_task_name');
		$this->db->where('forcasting_work.fsw_status',1);
		$query = $this->db->get();
		
		$data['forcasting'] = $query->result();
		
		
		$forcasting_work = $this->db->select('*')->from('forcasting_work')->get();
		$data['forcasting_work'] = $forcasting_work->result();
		
		
		
		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/manageforcasting',$data);
		$this->load->view('wapcos/template/footer');
		
	}
	public function manageWork(){
		
		$work = $this->db->select('*')->from('forcasting_work')->where('fsw_status',1)->get();
		
		$data['work'] = $work->result();
		
		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/manageworkdetails',$data);
		$this->load->view('wapcos/template/footer');
	
	}
	
	
	public function addWork(){
		
		
		
	$name  = $this->input->post('details');	
	$quant  = $this->input->post('quqntity');	
	$units  = $this->input->post('units');	
		
		
		$data = array(
		
				'fsw_name'=>$name,
				'fsw_unit'=>$quant,
				'fsw_unit_value'=>$units,
		);
		
		$this->db->insert('forcasting_work',$data);
		
		
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Success!</strong> Work added successfully.
			</div>');
		
	redirect('Wapcos/manageWork');
		
		
		
	}
	
	public function editWork(){
		
	//	print_r($_POST);
		
		$name  = $this->input->post('mac_name');	
		$quant  = $this->input->post('mac_unit');	
		$quantunit  = $this->input->post('units_ass');	
		$id  = $this->input->post('id');	
		
		
		$data = array(
		
				'fsw_name'=>$name,
				'fsw_unit'=>$quant,
				'fsw_unit_value'=>$quantunit,
		);
		
		
		$this->db->where('fsw_id',$id);
		$this->db->update('forcasting_work',$data);
		
		
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Success!</strong> Work Updated successfully.
			</div>');
		
	redirect('Wapcos/manageWork'); 
		
			
	}
	public function deleteWork(){
		
		
		$work_id = $this->input->post('id');
		
		
		
		$data = array(
		
				'fsw_status'=>0,
				
		);
		
		
		$this->db->where('fsw_id',$work_id);
		$this->db->update('forcasting_work',$data);
		
		
		
		
		
		
		
	}
	public function forCastingSchedule(){
		
		$result = $this->db->select('*')->from('project_details')->get();
		$data['result'] =$result->result(); 
		
		
		
		
		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/forCastingSchedule',$data);
		$this->load->view('wapcos/template/footer');
		
		
		
	}
	public function addFourcasting(){
		
	

		$mile_stone = $this->db->select('*')->from('mile_stone')->get();
		$data['mile_stone'] = $mile_stone->result();
		
		
		$forcasting_work = $this->db->select('*')->from('forcasting_work')->get();
		$data['forcasting_work'] = $forcasting_work->result();
		
		/* $activities = $this->db->select('*')->from('activities')->where('act_sc_id',$uri)->get();
		$data['activities'] = $activities->result(); */
		
		
		$this->db->select('*');
		$this->db->from('activities');
		$this->db->join('mile_stone', 'mile_stone.ms_id = activities.act_mi_id');
	//	$this->db->where('activities.act_sc_id',$uri);
		$query = $this->db->get();
		
		$data['activities'] = $query->result();
	
		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/addforcasting',$data);
		$this->load->view('wapcos/template/footer');
	
	}
	
	public function manageFcastProjectUpdate(){
		
		
		
			$id = $this->uri->segment(3);

	$res = $this->db->select('*')->from('mile_stone')->where('ms_s_id',$id)->get();
	$data['milstone'] = $res->result();


$schedule =	$this->db->select('*')->from('project_details')->where('p_id',$id)->get();
		$data['schedule'] = $schedule->result();


		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/viewforcastingupdate',$data);
		$this->load->view('wapcos/template/footer'); 

	}
	
	public function mileStoneForcastingUpdate(){
		
		$uri=$this->uri->segment(3);
		$mil=$this->uri->segment(4);
		
		
		$fosId=array();
			$schedule =	$this->db->select('*')->from('project_details')->where('p_id',$uri)->get();
			$data['schedule'] = $schedule->result();
		
			$mile_stone = $this->db->select('*')->from('mile_stone')->where('ms_s_id',$uri)->where('ms_id',$mil)->order_by('ms_id','ASC')->get();
			$data['mile_stone'] = $mile_stone->result();
		
		/* $activities = $this->db->select('*')->from('activities')->where('act_sc_id',$uri)->get();
		$data['activities'] = $activities->result(); */
		
		
		$this->db->select('*');
		$this->db->from('activities');
		$this->db->join('mile_stone', 'mile_stone.ms_id = activities.act_mi_id');
		$this->db->where('activities.act_sc_id',$uri);
		$this->db->order_by('activities.act_id','ASC');
		$query = $this->db->get();
		
		$data['activities'] = $query->result();
		
		
			$this->db->select('*');
			$this->db->from('task__s');
			$this->db->join('activities', 'activities.act_id = task__s.ts_ac_id');
			$this->db->join('mile_stone', 'mile_stone.ms_id = task__s.ts_mi_id');
			//$this->db->join('mile_stone', 'mile_stone.ms_id = activities.act_mi_id');
			$this->db->where('task__s.ts_pr_id',$uri);
			$this->db->where('task__s.ts_mi_id',$mil);
			$this->db->order_by('task__s.ts_mi_id','ASC');
			$tasks = $this->db->get();
		
			$data['tasks'] = $tasks->result();
					
		 	$forcasting = $this->db->select('af_task_id')->from('add_forcasting')->get();
			
			$rest=$forcasting->result();
	
			foreach($rest as $val){
				
			array_push($fosId, $val->af_task_id);
		
			}
		
		$data['fosId'] = $fosId; 

		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/milestoneforcastupdate',$data);
		$this->load->view('wapcos/template/footer'); 
		
	}
	public function viewAndUpdateForcast(){
		
		$uri = $this->uri->segment(3);
		
		
			$this->db->select('*');
			$this->db->from('task__s');
			$this->db->join('activities', 'activities.act_id = task__s.ts_ac_id');
			$this->db->join('mile_stone', 'mile_stone.ms_id = task__s.ts_mi_id');
			//$this->db->join('mile_stone', 'mile_stone.ms_id = activities.act_mi_id');
			$this->db->where('task__s.ts_id',$uri);
		$pjinfo = $this->db->get();
			
			
			
			$data['Project_info'] = $pjinfo->result();
			
			
		
		
		
		$this->db->select('*');
		$this->db->from('add_forcasting');
		
		$this->db->where('af_task_id',$uri);
		
		$result = $this->db->get();
		
		$data['forcast_details'] = $result->result();
		$intt = $result->result();
		
		foreach($intt as $van){
			
	$varname = $this->db->select('*')->from('add_forcasting_dependancy')->where('ad_f_id',$van->af_id)->get();
	$data['planed_forcast_task'] = $varname->result();	


	$base_forcast = $this->db->select('*')->from('forcasting_work')->where('fsw_id',$van->af_workid)->get();
	
	$data['forcasting_work'] = $base_forcast->result();
	
	$base_forcast_det = $this->db->select('*')->from('forcasting')->where('fs_task_name',$van->af_workid)->get();
	
	
	$data['forcasting_default'] = $base_forcast_det->result();
	
		}
		
		
	/* 	echo"<pre>";
		
		print_r($data); */
	/* 	print_r($dataa);
		print_r($tasked);
		print_r($forcast_day); */
		
		
		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/calculateactuvalforcast',$data);
		$this->load->view('wapcos/template/footer'); 
		
	}
	
	public function forcastUpDateTask(){
		
		$task_id = $this->input->post('task_id');
		$insertupdate = $this->input->post('insertupdate');
		$pland_forcast_id = $this->input->post('pland_forcast_id');
		$Actuvalmachine = $this->input->post('Actuvalmachine');
		$Resultmachine = $this->input->post('Resultmachine');
		$actualmaterial = $this->input->post('actualmaterial');
		$resultmaterial = $this->input->post('resultmaterial');
		$actualman = $this->input->post('actualman');
		$resultman = $this->input->post('resultman');
		
		/* print_r($_POST);
		print_r($insertupdate); */
		
		
		if($insertupdate[0]){
			
			
			//echo"update";
			for($i = 0 ;$i<=sizeof($pland_forcast_id)-1;$i++ ){
			$data = array(
		
			//	'ac_fc_pland_id'=>$pland_forcast_id[$i],
				'ac_fc_machin'=>$Actuvalmachine[$i],
				'ac_fc_res_matchin'=>$Resultmachine[$i],
				'ac_fc_material'=>$actualmaterial[$i],
				'ac_fc_res_material'=>$resultmaterial[$i],
				'ac_fc_man'=>$actualman[$i],
				'ac_fc_res_man'=>$resultman[$i],
			);
		$this->db->where('ac_fc_pland_id',$pland_forcast_id[$i]);
		$this->db->update('actual_forcastindg',$data);
			
			}
			
		}else{
			
			//echo "insert";
			
				for($i = 0 ;$i<=sizeof($pland_forcast_id)-1;$i++ ){
			
			$data = array(
		
				'ac_fc_pland_id'=>$pland_forcast_id[$i],
				'ac_fc_machin'=>$Actuvalmachine[$i],
				'ac_fc_res_matchin'=>$Resultmachine[$i],
				'ac_fc_material'=>$actualmaterial[$i],
				'ac_fc_res_material'=>$resultmaterial[$i],
				'ac_fc_man'=>$actualman[$i],
				'ac_fc_res_man'=>$resultman[$i],
			);
		
		$this->db->insert('actual_forcastindg',$data);
				
		} 
		}

			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Success!</strong> Actual forcasting Updated.
			</div>');
		
	redirect('Wapcos/viewAndUpdateForcast/'.$task_id);
		
		
	}
	
	public function selectTaskModel(){
		
		$id = $_POST['crit'];
		
		$task = $this->db->select('*')->from('task__s')->where('ts_ac_id',$id)->get();
		
		$data = $task->result();
		
		$html = "";
		
		
		foreach($data as $test){
		
			$html .="<option value='".$test->ts_id ."'>".$test->ts_name ."</option>";
		
		}
		
		
		echo $html;
		
	}
	public function viewForcastReport(){
		
		
		$result = $this->db->select('*')->from('project_details')->get();
		$data['result'] =$result->result(); 
		
		
		
		
		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/viewforcastingreport',$data);
		$this->load->view('wapcos/template/footer');
		
		
		
	}
	
	
	public function forcastingReport(){
		
		
		
		$id = $this->uri->segment(3);

		$res = $this->db->select('*')->from('mile_stone')->where('ms_s_id',$id)->get();
		$data['milstone'] = $res->result();

		$schedule =	$this->db->select('*')->from('project_details')->where('p_id',$id)->get();
		$data['schedule'] = $schedule->result();

		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/viewforcastimgmilestonereport',$data);
		$this->load->view('wapcos/template/footer'); 
			
	}
	public function mileStoneForcastingReport(){
		
		
		$uri=$this->uri->segment(3);
		$mil=$this->uri->segment(4);
		
		
		$fosId=array();
		
		
			$schedule =	$this->db->select('*')->from('project_details')->where('p_id',$uri)->get();
			$data['schedule'] = $schedule->result();
		
			$mile_stone = $this->db->select('*')->from('mile_stone')->where('ms_s_id',$uri)->where('ms_id',$mil)->order_by('ms_id','ASC')->get();
			$data['mile_stone'] = $mile_stone->result();
		
		/* $activities = $this->db->select('*')->from('activities')->where('act_sc_id',$uri)->get();
		$data['activities'] = $activities->result(); */
		
		
		$this->db->select('*');
		$this->db->from('activities');
		$this->db->join('mile_stone', 'mile_stone.ms_id = activities.act_mi_id');
		$this->db->where('activities.act_sc_id',$uri);
		$this->db->order_by('activities.act_id','ASC');
		$query = $this->db->get();
		
		$data['activities'] = $query->result();
		
		
			$this->db->select('*');
			$this->db->from('task__s');
			$this->db->join('activities', 'activities.act_id = task__s.ts_ac_id');
			$this->db->join('mile_stone', 'mile_stone.ms_id = task__s.ts_mi_id');
			//$this->db->join('mile_stone', 'mile_stone.ms_id = activities.act_mi_id');
			$this->db->where('task__s.ts_pr_id',$uri);
			$this->db->where('task__s.ts_mi_id',$mil);
			$this->db->order_by('task__s.ts_mi_id','ASC');
			$tasks = $this->db->get();
		
			$data['tasks'] = $tasks->result();
					
			$forcasting = $this->db->select('af_task_id')->from('add_forcasting')->get();
			
			$rest=$forcasting->result();
	
			foreach($rest as $val){
				
			array_push($fosId, $val->af_task_id);
		
			}
		
		$data['fosId'] = $fosId;

		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/viewmailstoneforcastreport',$data);
		$this->load->view('wapcos/template/footer'); 

	}
	public function masterResource(){
		
		$wid = $this->input->post('work_id');
		$mac_name = $this->input->post('mac_name');
		$mac_unit = $this->input->post('mac_unit');
		$mac_quant = $this->input->post('mac_quant');
		$mate_name = $this->input->post('mate_name');
		$mate_unit = $this->input->post('mate_unit');
		$mate_quant = $this->input->post('mate_quant');
		$man_name = $this->input->post('man_name');
		$man_unit = $this->input->post('man_unit');
		$man_quant = $this->input->post('man_quant');
		
		//print_r($_POST);
		
		$data = array(
				'fs_task_name'=>$wid,
				'fs_Machinery'=>$mac_name,
				'fs_mac_unit_day'=>$mac_unit,
				'fs_mac_qty'=>$mac_quant,
				'fs_material'=>$mate_name,
				'fs_mat_unit'=>$mate_unit,
				'fs_mat_qty'=>$mate_quant,
				'fs_manpower'=>$man_name,
				'fs_man_unit'=>$man_unit,
				'fs_man_qty'=>$man_quant
		
		);
		
		$this->db->insert('forcasting',$data);
		
		
		
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Success!</strong> Material resources added successfully.
			</div>');
		
	redirect('Wapcos/addFourcasting');
		
	}

public function forcastEdit(){



		$fs_id = $this->input->post('fs_id');
		$wid = $this->input->post('work_id');
		$mac_name = $this->input->post('mac_name');
		$mac_unit = $this->input->post('mac_unit');
		$mac_quant = $this->input->post('mac_quant');
		$mate_name = $this->input->post('mate_name');
		$mate_unit = $this->input->post('mate_unit');
		$mate_quant = $this->input->post('mate_quant');
		$man_name = $this->input->post('man_name');
		$man_unit = $this->input->post('man_unit');
		$man_quant = $this->input->post('man_quant');

$data = array(
				'fs_task_name'=>$wid,
				'fs_Machinery'=>$mac_name,
				'fs_mac_unit_day'=>$mac_unit,
				'fs_mac_qty'=>$mac_quant,
				'fs_material'=>$mate_name,
				'fs_mat_unit'=>$mate_unit,
				'fs_mat_qty'=>$mate_quant,
				'fs_manpower'=>$man_name,
				'fs_man_unit'=>$man_unit,
				'fs_man_qty'=>$man_quant
		);

		$this->db->where('fs_id',$fs_id);
		$this->db->update('forcasting',$data);



		
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Success!</strong> Material resources updated successfully.
			</div>');
		
	redirect('Wapcos/manageMaterialising');


}
	public function deleteMaterial(){

		$uri = $this->uri->segment(3);

		
		$this->db->delete('forcasting', array('fs_id' => $uri)); 
		
$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Success!</strong> Material resources deleted successfully.
			</div>');
		
	redirect('Wapcos/manageMaterialising');





	}
	public function testEmail(){
		
		
		
		   $subject="New CA Created";
      
      $this->email->set_newline("\r\n");
      $this->email->from("yuvarajselvamtnj");
      $this->email->to("nkvgopi@gmail.com");
      $this->email->subject("test F");
      $this->email->message("Hello gobi");
      $this->email->send();

	}
	

	public function index()
	{
        $this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/dashboard1');
		$this->load->view('wapcos/template/footer');
    }

    public function projects(){


		$schedules = $this->db->select('*')->from('project_details')->where('p_status',1)->get();

		$data['schedules']=$schedules->result();


        $this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/manageprojects',$data);
		$this->load->view('wapcos/template/footer');

    }
	public function viewFcastDetails(){

	$id = $this->uri->segment(3);

	$res = $this->db->select('*')->from('mile_stone')->where('ms_s_id',$id)->get();
	$data['milstone'] = $res->result();

	$schedule =	$this->db->select('*')->from('project_details')->where('p_id',$id)->get();
	$data['schedule'] = $schedule->result();

		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/viewforcasting',$data);
		$this->load->view('wapcos/template/footer'); 

	}

	public function mileStoneForcasting(){

		$uri=$this->uri->segment(3);
		$mil=$this->uri->segment(4);
		
		
		$fosId=array();
			$schedule =	$this->db->select('*')->from('project_details')->where('p_id',$uri)->get();
			$data['schedule'] = $schedule->result();
		
			$mile_stone = $this->db->select('*')->from('mile_stone')->where('ms_s_id',$uri)->where('ms_id',$mil)->order_by('ms_id','ASC')->get();
			$data['mile_stone'] = $mile_stone->result();
		
		/* $activities = $this->db->select('*')->from('activities')->where('act_sc_id',$uri)->get();
		$data['activities'] = $activities->result(); */
		
		
		$this->db->select('*');
		$this->db->from('activities');
		$this->db->join('mile_stone', 'mile_stone.ms_id = activities.act_mi_id');
		$this->db->where('activities.act_sc_id',$uri);
		$this->db->order_by('activities.act_id','ASC');
		$query = $this->db->get();
		
		$data['activities'] = $query->result();
		
		
			$this->db->select('*');
			$this->db->from('task__s');
			$this->db->join('activities', 'activities.act_id = task__s.ts_ac_id');
			$this->db->join('mile_stone', 'mile_stone.ms_id = task__s.ts_mi_id');
			//$this->db->join('mile_stone', 'mile_stone.ms_id = activities.act_mi_id');
			$this->db->where('task__s.ts_pr_id',$uri);
			$this->db->where('task__s.ts_mi_id',$mil);
			$this->db->order_by('task__s.ts_mi_id','ASC');
			$tasks = $this->db->get();
		
			$data['tasks'] = $tasks->result();
					
			$forcasting = $this->db->select('af_task_id')->from('add_forcasting')->get();
			
			$rest=$forcasting->result();
	
			foreach($rest as $val){
				
			array_push($fosId, $val->af_task_id);
		
			}
		
		$data['fosId'] = $fosId;

		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/milestoneforcast',$data);
		$this->load->view('wapcos/template/footer'); 
	}

    public function addProject(){

        $this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/addproject');
		$this->load->view('wapcos/template/footer'); 

    }
	
	
	public function editSchedule(){
		
	
		$uri  =	$this->uri->segment(3);
		
		$schedule =	$this->db->select('*')->from('project_details')->where('p_id',$uri)->get();
		$data['schedule'] = $schedule->result();
			
		$mile_stone = $this->db->select('*')->from('mile_stone')->where('ms_s_id',$uri)->get();
		$data['mile_stone'] = $mile_stone->result();
		
		/* $activities = $this->db->select('*')->from('activities')->where('act_sc_id',$uri)->get();
		$data['activities'] = $activities->result(); */
		
		
		$this->db->select('*');
		$this->db->from('activities');
		$this->db->join('mile_stone', 'mile_stone.ms_id = activities.act_mi_id');
		$this->db->where('activities.act_sc_id',$uri);
		$query = $this->db->get();
		
		$data['activities'] = $query->result();
		
		
		
		
			$this->db->select('*');
			$this->db->from('task__s');
			$this->db->join('activities', 'activities.act_id = task__s.ts_ac_id');
			$this->db->join('mile_stone', 'mile_stone.ms_id = task__s.ts_mi_id');
			//$this->db->join('mile_stone', 'mile_stone.ms_id = activities.act_mi_id');
			$this->db->where('task__s.ts_pr_id',$uri);
			$this->db->order_by('task__s.ts_mi_id','ASC');
			$tasks = $this->db->get();
		
			$data['tasks'] = $tasks->result();
		
		
		
		
		
		
		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/editprojects',$data);
		$this->load->view('wapcos/template/footer'); 

	}
	
	public function manageUser(){
		
		
		$user  = $this->db->select('*')->from('user_table')->get();
		
		$data['user'] = $user->result();
		
		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/manageuser',$data);
		$this->load->view('wapcos/template/footer');

	}
	
	public function addUser(){
		
		
		$proj = $this->db->select('*')->from('project_details')->get();
		
		$data['proj']=$proj->result();
		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/adduser',$data);
		$this->load->view('wapcos/template/footer');
		
	
	}
	
	
	public function createUser(){
		
		
		//print_r($_POST);
		
		$user = $this->input->post('user');
		$emailid = $this->input->post('emailid');
		$mobile = $this->input->post('mobile');
		$password = $this->input->post('password');
		$auth = $this->input->post('auth');
		$schedule_id = $this->input->post('selectSm');
		
		
		
		$data = array(
		
			'u_name'=>$user,
			'u_email_id'=>$emailid,
			'u_mobile'=>$mobile,
			'u_password'=>$password,
			'u_created_date'=>date('Y-m-d'),
			'u_created_by'=>1,
			'u_auth'=>$auth,
			'u_pj_id'=>$schedule_id,
		);
		
		$this->db->insert('user_table',$data);
		
		
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Success!</strong> User added successfully.
			</div>');
		
	redirect('Wapcos/manageUser');
		
		
	}
	public function editUser(){
		
		
		$id = $this->uri->segment(3);
		
		
		$user = $this->db->select('*')->from('user_table')->where('u_id',$id)->get();
		
		$data['user'] = $user->result();
		$proj = $this->db->select('*')->from('project_details')->get();
		
		$data['proj']=$proj->result();
		
		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/edituser',$data);
		$this->load->view('wapcos/template/footer');
		
	}
	public function updateUser(){
		
		
		$id = $this->uri->segment(3);
		
		$user = $this->input->post('user');
		$emailid = $this->input->post('emailid');
		$mobile = $this->input->post('mobile');
		$personalmail = $this->input->post('personalmail');
		$password = $this->input->post('password');
		$auth = $this->input->post('auth');
		$schedule_id = $this->input->post('selectSm');
		
		$data = array(
		
			'u_name'=>$user,
			'u_email_id'=>$emailid,
			'u_mobile'=>$mobile,
			'u_password'=>$password,
			'u_created_date'=>date('Y-m-d'),
			'u_created_by'=>1,
			'u_auth'=>$auth,
			'u_pj_id'=>$schedule_id,
			'u_personal_email_id'=>$personalmail,
			
		);
		
		$this->db->where('u_id',$id);
		$this->db->update('user_table',$data);
		
		
			
		$this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Updated!</strong> User updated successfully.
			</div>');
		
	redirect('Wapcos/manageUser');
			
	}
	public function deleteUser(){
		
		
			$id = $this->uri->segment(3);
		
		
			$this->db->where('u_id',$id);
			$this->db->delete('user_table');
		
		
		
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Deleted!</strong> User deleted successfully.
			</div>');
		
	redirect('Wapcos/manageUser');
		
	}
	
	public function gGannChatt(){
		
		
		
		
		$this->load->view('wapcos/site/ggchatt');
		
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function editActivities(){
		
		
		$ea_id = $this->input->post('ea_id');
		$milestoneid = $this->input->post('milestoneid');
		$m_name = $this->input->post('m_name');
		$m_from_d = $this->input->post('m_from_d');
		$m_to_d = $this->input->post('m_to_d');
		//$days = $this->input->post('days');
		
		
		$update = array(
				'act_mi_id'=>$milestoneid,
				'act_act_name'=>$m_name,
				'act_from_date'=>$m_from_d,
				'act_to_date'=>$m_to_d,
				//'act_act_days'=>$days,
		);
		
	
		$this->db->where('act_id',$ea_id);
		$this->db->update('activities',$update);
		
		
		
			echo "success";
	
	}
	
	public function selectActivities(){
		
		
		$mil_id = $this->input->post('value');
		
		$data_result = $this->db->select('*')->from('activities')->where('act_mi_id',$mil_id)->get();
		
		$res = $data_result->result();
		
			$html = "<option value=''>Select Activity</option>";
		
		foreach($res as $val){
		
		$html .= "<option value='$val->act_id'>$val->act_act_name</option>"; 
		
		}
	
		echo trim($html);
	
	}
	public function addMileStone(){
		
		//print_r($_POST);
		
		
		
		$pr_id = $this->input->post('Pr_id');	
		$mstone_name = $this->input->post('mstone_name');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$days = $this->input->post('days');
		
		
		$data = array(
		
				'ms_s_id'=>$pr_id,
				'ms_s_name'=>$mstone_name,
				'ms_s_date'=>$from_date,
				'ms_e_date'=>$to_date,
				'ms_total_days'=>$days,
			
		);
		
		$this->db->insert('mile_stone',$data);
		
		echo "success";
		
	}
	
	public function editMileStone(){
		
		$m_id = $this->input->post('m_id');	
		$m_name = $this->input->post('m_name');
		$m_from_d = $this->input->post('m_from_d');
		$m_to_d = $this->input->post('m_to_d');
		$days = $this->input->post('days');
		
			$data = array(
		
				'ms_s_name'=>$m_name,
				'ms_s_date'=>$m_from_d,
				'ms_e_date'=>$m_to_d,
				'ms_total_days'=>$days,
		);
		
		$this->db->where('ms_id',$m_id);
		$this->db->update('mile_stone',$data);
		
		echo "success";
		
	}
	public function selectMileStone(){
		
		$id = $this->input->post('pr_id');
		
		$project = $this->db->select('*')->from('mile_stone')->where('ms_s_id',$id)->get();
		
		$sch = $project->result();
		
		$html = "<option value=''>Select Milestone</option>";
		
		foreach($sch as $val){
			
			
		$html .= "<option value='$val->ms_id'>$val->ms_s_name</option>"; 
		
		}
		
			
		echo trim($html);
			
	}
	public function addActivities(){
		
		
		
		
		//print_r($_POST);
		
		
		$milstone_id = $this->input->post('milstone_id');
		$proj_id = $this->input->post('proj_id');
		$act_name = $this->input->post('activity');
		$from_date = $this->input->post('a_from_date');
		$to_date = $this->input->post('a_to_date');
		
		
		
		$array_size = sizeof($milstone_id);
		
		
		
		for($i = 0; $i<=$array_size-1;$i++){
			
			//$totdays = (($from_date[$i] - $to_date[$i])/60/60/24); 
			
			$data = array(
			
				'act_sc_id'=>$proj_id[$i],
				'act_mi_id'=>$milstone_id[$i],
				'act_act_name'=>$act_name[$i],
				'act_from_date'=>$from_date[$i],
				'act_to_date'=>$to_date[$i],
				//'act_act_days'=>$totdays,
			
			
			
			);
			
		$this->db->insert('activities',$data);
			
			
		}
		
			
		
	
  echo'<script type="text/javascript"> alert("Activity added successfully"); </script>';
	
		//print_r($dataInfo);
		
		redirect('Wapcos/editSchedule/'.$proj_id[0]);
			
	}
	public function addTask(){
		
	$pr_id = $this->input->post('pr_id');
	$mil_stone = $this->input->post('select_mil');
	$activities = $this->input->post('activity');
	$taskname = $this->input->post('taskname');
	$from_date = $this->input->post('tstart_date');
	$to_date = $this->input->post('tend_date');
	$days = $this->input->post('days');
		
		
		
		$data = array(
		
				'ts_pr_id' =>$pr_id,
				'ts_mi_id' =>$mil_stone,
				'ts_ac_id' =>$activities,
				'ts_name' =>$taskname,
				'ts_start' =>$from_date,
				'ts_end' =>$to_date,
				'ts_days' =>$days,
		);
		
		$this->db->insert('task__s',$data);
		
		echo "successs";
		
	}
	
	public function updateTask(){
		
		
		$select_mil = $this->input->post('select_mil');
		$activity = $this->input->post('activity');
		$taskname = $this->input->post('taskname');
		$tstart_date = $this->input->post('tstart_date');
		$tend_date = $this->input->post('tend_date');
		$days = $this->input->post('days');
		$edit = $this->input->post('edit');
		//$edit = $this->input->post('edit');
		
		 	$data = array(
		
				'ts_mi_id' =>$select_mil,
				'ts_ac_id' =>$activity,
				'ts_name' =>$taskname,
				'ts_start' =>$tstart_date,
				'ts_end' =>$tend_date,
				'ts_days' =>$days,
		);
		
		
		$this->db->where('ts_id',$edit);
		$this->db->update('task__s',$data); 
		
		echo "success";
		
	}
	
	public function updateSchedule(){
		
			
		$id = $this->input->post('project_id');
		$sc_name = $this->input->post('schedule_name');
		$sdate = $this->input->post('start_date');
		$plinth_area = $this->input->post('plinth_area');
		$duration = $this->input->post('duration');
		$ecp = $this->input->post('ecp');
		$avg_value = $this->input->post('avg_value');
		$comp_date = $this->input->post('comp_date');
		$contr_name = $this->input->post('contr_name');
		$contr_email = $this->input->post('contr_email');
		$contr_mobile = $this->input->post('contr_mobile');
		$proj_amt = $this->input->post('proj_amt');
		$paid_amt = $this->input->post('paid_amt');
		$und_prog_amt = $this->input->post('und_prog_amt');
		$last_update_date = $this->input->post('last_update_date');
		$pdf_sched_name = $this->input->post('pdf_schedule_name');
		if($pdf_sched_name == "" or $pdf_sched_name == null ){
			
			$pdf_sched_name = null;
			
		}
			$config['upload_path'] = 'uploads/';
			$config['allowed_types'] = 'pdf';
			$config['remove_spaces'] = TRUE;
            $config['encrypt_name'] = TRUE;

		
		
		
		  $this->load->library('upload', $config);

        if (!$this->upload->do_upload('schedule_pdf')) {
            $error = array('error' => $this->upload->display_errors());
//print_r($error);
   $pdf_scheduled =   $pdf_sched_name;     
        } else {
            $file_details = array('image_metadata' => $this->upload->data());
//print_r($file_details);
 $pdf_scheduled = $file_details['image_metadata']['file_name'];
            
        }
		
		$data = array(
		
					'p_name'=>$sc_name,
					'p_start_date'=>$sdate,
					'p_end_date'=>$comp_date,
					'p_plinth_area'=>$plinth_area,
					'p_duration'=>$duration,
					'p_ecp'=>$ecp,
					'p_avg_value'=>$avg_value,
					'p_contr_name'=>$contr_name,
					'p_contr_email_id'=>$contr_email,
					'p_contr_m_num'=>$contr_mobile,
					'p_proj_amt'=>$proj_amt,
					'p_paid_amt'=>$paid_amt,
					'p_under_prog_amt'=>$und_prog_amt,
					'p_last_updated'=>$last_update_date,
					'p_schedule_name'=>$pdf_scheduled,
					//'p_date_creatd'=>,
					//'p_status'=>,
		
		);
		 

		$this->db->where('p_id',$id);
		$this->db->update('project_details',$data);
		
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Success!</strong> Sucessfull updated the project details.
			</div>');
		
		//print_r($dataInfo);
		
		redirect('Wapcos/editSchedule/'.$id); 
	

	}
	public function removeSchedule(){
		
		$id = $this->uri->segment(3);
		$result = $this->db->select('p_schedule_name')->from('project_details')->where('p_id',$id)->get()->result();
			unlink ( 'uploads/'.$result[0]->p_schedule_name );
			$data = array(
					'p_schedule_name'=>Null,
				);
			$this->db->where('p_id',$id);
			$this->db->update('project_details',$data);
		$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Success!</strong> Schedule pdf deleted successfully.
			</div>');

		redirect('Wapcos/editSchedule/'.$id); 
	
	}
	public function selectProject(){
		
		
		$id=$this->input->post('value');
		$data = $this->db->select('*')->from('project_details')->where('p_cat_id',$id)->get();
		
		$val = $data->result();
		$vaue="<option value='' >Select Project</option>";
		foreach($val as $spro){
		
			 $vaue.= "<option value='".$spro->p_id."' >".$spro->p_name."</option>";
		
		}
		//print_r($val);
		
		
		echo $vaue;
	}
    
    public function uploads(){

	$project = $this->db->select('*')->from('project_details')->where('p_status',1)->get();
	$data['project'] = $project->result();
	
				
	$services = $this->db->select('*')->from('project_category')->get();
	$data['service'] = $services->result();
	
	
	
	
        $this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/uploads',$data);
		$this->load->view('wapcos/template/footer'); 
    }
	
	
	public function uploadsSedule(){
		
		$sh_id = $this->uri->segment(3);
		
	$project = $this->db->select('*')->from('project_details')->where('p_id',$sh_id)->get();
	$data['project'] = $project->result();
		
		
		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/sheduleupload',$data);
		$this->load->view('wapcos/template/footer'); 	
	
		
	}
	public function doUpload(){
		
		$file_tot =count($_FILES['userfile']['name']);
		
		$proj= $this->input->post('project');
		$date= $this->input->post('date');
		$doc_name= $this->input->post('documentname');
		$doc_type= $this->input->post('document_type');
		$remarks= $this->input->post('remarks');
		$services= $this->input->post('services');
		
		$data = array(
				'up_project_id'=>$proj,
				'up_date'=>$date,
				'up_name_document'=>$doc_name,
				'up_services'=>$services,
				'up_doc_type'=>$doc_type,
				'up_remarks'=>$remarks,
				'up_upload_name'=>$file_tot,
		
		);
	
	 $this->db->insert('uploads',$data);
	 $insert_id = $this->db->insert_id();
	
		$this->load->library('upload');
		$dataInfo = array();
        $files = $_FILES;
        $cpt = count($_FILES['userfile']['name']);
		
		for($i=0; $i<$cpt; $i++)
		{           
			$_FILES['userfile']['name']= $files['userfile']['name'][$i];
			$_FILES['userfile']['type']= $files['userfile']['type'][$i];
			$_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
			//$_FILES['userfile']['filename']= $files['userfile']['filename'][$i];
			$_FILES['userfile']['error']= $files['userfile']['error'][$i];
			$_FILES['userfile']['size']= $files['userfile']['size'][$i];    

			$this->upload->initialize($this->set_upload_options());
			$hh =$this->upload->do_upload('userfile');
			$dataInfo[$i] = $this->upload->data();
			//echo $_FILES['userfile']['filename'];
			
			
			
			$data_up = array(
			
						'upf_up_id'=>$insert_id,
						'upf_name'=>$dataInfo[$i]['file_name'],
						'upf_pr_id'=>$proj,
	
			);
	
			$this->db->insert('upload_files',$data_up);
		} 
		
		
		
		
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Success!</strong> Sucessfull uploaded the file.
			</div>');
		
		//print_r($dataInfo);
		
		redirect('Wapcos/viewUploads');
		
	}
	
	private function set_upload_options()
	{   
    //upload an image options
    $config = array();
    $config['upload_path'] = 'uploads/';
    $config['allowed_types'] = '*';
    $config['remove_spaces'] = TRUE;
    $config['overwrite'] = FALSE;
    return $config;
	}


	public function upload_img($user_name){
  if($_FILES['userfile']['name']!=''){
   $config['upload_path'] = 'uploads/';
   $config['allowed_types'] = 'mp4';
   $config['max_size']='10000';
   $config['file_name']=$user_name;
   $this->load->library('upload', $config);
   if($this->upload->do_upload('userfile')){
    //@unlink('admin_assets/images/users/'.$this->input->post('old_picture'));
    return $this->upload->data();
   }else{
    return $this->upload->display_errors();
   }
  }     
    }
	
    public function viewUploads(){

		//$doctype = $this->db->select('*')->from('uploads')->where('up_status',1)->get();
		
		
		
		$this->db->select('*');
		$this->db->from('uploads');
		$this->db->join('project_details', 'project_details.p_id = uploads.up_project_id');
		//$this->db->join('comments', 'comments.id = uploads.id');
		 $this->db->where('uploads.up_status',1);
		$doctype = $this->db->get();
		
		
		
		
		
		$data['doctype']=$doctype->result();

        $this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/viewuploads',$data);
		$this->load->view('wapcos/template/footer'); 

    }
	public function viewProjectUploads(){

		
		$proj_id = $this->uri->segment(3);
	
		$this->db->select('*');
		$this->db->from('uploads');
		$this->db->join('project_details', 'project_details.p_id = uploads.up_project_id');
	
		 $this->db->where('uploads.up_project_id',$proj_id);
		 $this->db->where('uploads.up_status',1);
		$doctype = $this->db->get();
		
		
		
		
		
		$data['doctype']=$doctype->result();

        $this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/viewuploads',$data);
		$this->load->view('wapcos/template/footer'); 

    }
	
	
	
	
	
	
	
	public function editUploads(){
		
		$id = $this->uri->segment(3);
		
		
		$this->db->select('*');
		$this->db->from('uploads');
		$this->db->join('project_details', 'project_details.p_id = uploads.up_project_id');
		//$this->db->join('comments', 'comments.id = uploads.id');
		 $this->db->where('uploads.up_id',$id);
		$doctype = $this->db->get();
		$data['doctype']=$doctype->result();
		
		
		$this->db->select('*');
		$this->db->from('upload_files');
		$this->db->where('upf_name !=',"");
		$this->db->where('upf_up_id',$id);
		$files = $this->db->get();
		
		$data['files'] = $files->result();
		
		$project = $this->db->select('*')->from('project_details')->where('p_status',1)->get();
	$data['project'] = $project->result();
		
		 $this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/edituploads',$data);
		$this->load->view('wapcos/template/footer');
		
	}
	
	public function deleteUploadedFile(){
		
		$id = $this->input->post('value');
		
		
		
		$this->db->where('upf_id', $id);
		$this->db->delete('upload_files');
		
		
		echo"success";
		
		
	}
	
	
	
	
	public function deleteCompUploadedFile(){
		
		
		$id = $this->input->post('value');
		
		$this->db->where('oacf_id', $id);
		$this->db->delete('oacf_files');
		
		echo"success";
	}
	
	public function editUpload(){
		
		
		//print_r($_POST);
		
		
		$file_tot =count($_FILES['userfile']['name']);
		
		$proj= $this->input->post('project');
		$date= $this->input->post('date');
		$doc_name= $this->input->post('documentname');
		$doc_type= $this->input->post('document_type');
		$remarks= $this->input->post('remarks');
		$id= $this->input->post('id');
		$services= $this->input->post('services');
		
		$data = array(
				'up_project_id'=>$proj,
				'up_date'=>$date,
				'up_name_document'=>$doc_name,
				'up_doc_type'=>$doc_type,
				'up_services'=>$services,
				'up_remarks'=>$remarks,
				'up_upload_name'=>$file_tot,
		
		);
		
		
	$this->db->where('up_id',$id);
	$this->db->update('uploads',$data);
	
		
		
		
	   $this->load->library('upload');
		  $dataInfo = array();
          $files = $_FILES;
         $cpt = count($_FILES['userfile']['name']);
		for($i=0; $i<$cpt; $i++)
		{           
			$_FILES['userfile']['name']= $files['userfile']['name'][$i];
			$_FILES['userfile']['type']= $files['userfile']['type'][$i];
			$_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
			//$_FILES['userfile']['filename']= $files['userfile']['filename'][$i];
			$_FILES['userfile']['error']= $files['userfile']['error'][$i];
			$_FILES['userfile']['size']= $files['userfile']['size'][$i];    

			$this->upload->initialize($this->set_upload_options());
			$hh =$this->upload->do_upload('userfile');
			$dataInfo[$i] = $this->upload->data();
			//echo $_FILES['userfile']['filename'];
			
			
			
			$data_up = array(
			
						'upf_up_id'=>$id,
						'upf_name'=>$dataInfo[$i]['file_name'],
						'upf_pr_id'=>$proj,
						
			);
		
			$this->db->insert('upload_files',$data_up);
			
			
			
		} 
		
		
		
		
		$this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success!</strong> Updated Uploads Successfully.
</div>');
		
		//print_r($dataInfo);
		
		redirect('Wapcos/editUploads/'.$id);
	
	}
	
	
	public function viewDeatilsUploads(){
		
		$id =  $this->uri->segment(3);
		
		
		$this->db->select('*');
		$this->db->from('uploads');
		$this->db->join('project_details', 'project_details.p_id = uploads.up_project_id');
		//$this->db->join('comments', 'comments.id = uploads.id');
		 $this->db->where('uploads.up_id',$id);
		$doctype = $this->db->get();
		$data['doctype']=$doctype->result();
		
		$this->db->select('*');
		$this->db->from('upload_files');
		$this->db->where('upf_name !=',"");
		$this->db->where('upf_up_id',$id);
		$files = $this->db->get();
		
		$data['files'] = $files->result();
		
		
		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/viewdetailuploads',$data);
		$this->load->view('wapcos/template/footer');
		
	}
	
	
	public function deleteCompUpload(){
		
		$id = $this->input->post('value');
		
				$data = array(
				'up_status'=>0,
	
		);
	
	$this->db->where('up_id',$id);
	$this->db->update('uploads',$data);
		
		echo "success";
	}
	
	
	
	
	
	
	
	public function observationAndComplaince(){
		
		
	$project = $this->db->select('*')->from('project_details')->where('p_status',1)->get();
	$data['project'] = $project->result();
	
	
	$services = $this->db->select('*')->from('project_category')->get();
	$data['service'] = $services->result();
	
	
	$services = $this->db->select('*')->from('observation_type')->where('ob_status',1)->get();
	$data['observation'] = $services->result(); 
	
	    $this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/observationandcomplince',$data);
		$this->load->view('wapcos/template/footer'); 
		
				
	}
	


	
	
	public function scheduleobservationandcomplaince(){
		
	$sc_id = $this->uri->segment(3);
		
	$project = $this->db->select('*')->from('project_details')->where('p_id',$sc_id)->get();
	$data['project'] = $project->result();
	
	
	 $services = $this->db->select('*')->from('observation_type')->get();
	
	$data['observation'] = $services->result(); 
	
	    $this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/scheduleobservationandcomplaince',$data);
		$this->load->view('wapcos/template/footer'); 
		
				
	}
	
	
	public function doObserAndComp(){
		
		
		$file_tot =count($_FILES['userfile']['name']);
		$proj= $this->input->post('project');
		$date= $this->input->post('date');
		$doc_name= $this->input->post('documentname');
		$observation_type= $this->input->post('document_type');
		$sub_obser= $this->input->post('sub_obser');
	
		$remarks= $this->input->post('remarks');
		$services= $this->input->post('services');
		$tg_date= $this->input->post('tg_date');
		 $critical = $this->input->post('critical');


		 if($critical){

			$crit = 1;
			$crmess ="Yes";

		 }else{

			$crit = 0;
			$crmess ="No";
		 }
		
		$data = array(
				'oc_project_id'=>$proj,
				'oc_service_id'=>$services,
				'oc_date'=>$date,
				'oc_name_doc'=>$doc_name,
				'oc_doc_type'=>$observation_type,
				'oc_doc_sub_type'=>$sub_obser,
				'oc_remarks'=>$remarks,
				'oc_upload_name'=>$file_tot,
				'oc_date_created'=>date('Y-m-d'),
				'oc_tardated_date'=>$tg_date,
				'oc_critical_status'=>$crit,
		);
		
		$this->db->insert('observation_and_comp',$data);
		$insert_id = $this->db->insert_id();
	
		$this->load->library('upload');
		  $dataInfo = array();
          $files = $_FILES;
         $cpt = count($_FILES['userfile']['name']);
		for($i=0; $i<$cpt; $i++)
		{           
			$_FILES['userfile']['name']= $files['userfile']['name'][$i];
			$_FILES['userfile']['type']= $files['userfile']['type'][$i];
			$_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
			//$_FILES['userfile']['filename']= $files['userfile']['filename'][$i];
			$_FILES['userfile']['error']= $files['userfile']['error'][$i];
			$_FILES['userfile']['size']= $files['userfile']['size'][$i];    

			$this->upload->initialize($this->set_upload_options());
			$hh =$this->upload->do_upload('userfile');
			$dataInfo[$i] = $this->upload->data();
			//echo $_FILES['userfile']['filename'];
			$data_up = array(
			
						'oacf_oac_id'=>$insert_id,
						'oac_name'=>$dataInfo[$i]['file_name'],
						'oac_pr_id'=>$proj,
						//''=>,
			);
			
				$this->db->insert('oacf_files',$data_up);
	} 



			$action_taken = array(
				
				'champ_id'=>$insert_id,
				'ch_auth_id'=>$this->session->userdata['userdata']['user_auth'],
				'ch_message'=>'Observations Created ',
				//'ch_file_name'=>$filename,
				'ch_date_time'=>date('Y-m-d :H:i:sa'),
				'ch_user_id'=>$this->session->userdata['userdata']['user_id'],
				'ch_status'=>1,
		);  

		$this->db->insert('compliance_history',$action_taken);



		$observation = 	$this->db->select('*')->from('observation_type')->where('ob_id',$observation_type)->get();
		$obstype = $observation->result();

		if($sub_obser){
			$ods = $this->db->select('*')->from('observation_sub_type')->where('obs_id',$sub_obser)->get();
			$resu = $ods->result();

			$sub_type = '%0aOBS sub-type : '.$resu[0]->obs_name;
			$email_sub_type = $resu[0]->obs_name;
			
		}else{
			
			$sub_type = "";
			$email_sub_type ="Nill";
		}
		
		$select_user = $this->db->select('*')->from('user_table')->where('u_auth',5)->where('u_pj_id',$proj)->get();
		
		$iitm_manager = $select_user->result();
		
		$mmsg = 'OBS from WAPCOS %0aOBS Name : '.$doc_name.' %0aOBS Type: '.$obstype[0]->ob_name .$sub_type.' %0aCritical Stage : '.$crmess .' %0aTarget Date : '.date('d-m-Y',strtotime($tg_date));
		
 	$stripped = str_replace(' ','%20',$mmsg);
 $url ='http://hpapi.dial4sms.com/SendSMS/sendmsg.php?uname=wapcost&pass=wapcost&send=WAPCOS&dest='.$iitm_manager[0]->u_mobile .'&msg='.$stripped;

$base = base_url();
		
					$ch = curl_init();
					$timeout = 30;
					curl_setopt ($ch,CURLOPT_URL, $url) ;
					curl_setopt ($ch,CURLOPT_RETURNTRANSFER, 1);
					 curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
					curl_setopt ($ch,CURLOPT_CONNECTTIMEOUT, $timeout) ;
					$response = curl_exec($ch) ;
					curl_close($ch) ;  


$htmltemplate=' <!DOCTYPE html>
<html>
<head>
<style>
table {
font-family: arial, sans-serif;
border-collapse: collapse;
width: 100%;
}
.em{box-shadow: 0px 5px 20px 0px #cfd3ff; width:600px; margin:0 auto;}
.em .log { background-color: #e3bdb8; }
.em .log th{padding:10px;}
.em .tb td{padding:20px 20px;}
.em .tb td:first-child{width:40%; font-weight:bold; color:#2c3879;}
.em .fot{background-color: #e3bdb8; height:3px;}
.em .fot td{padding:3px;}
.em img
{
width:100px;
height:100px;
}
</style>
</head>
<body>
<div class="em">
<table>
<tr class="log">
<th><img src="http://wapcos.istudiotech.in/admin_template/images/1200px-IIT_Madras_Logo.svg.png"></th>
<th>(TPQAS) Observation</th>
<th><img src="http://wapcos.istudiotech.in/admin_template/images/WAPCOS-Limited-1.png"></th>
</tr>
</table>
<table class="tb">
<tr>
<td>Observation Name :</td>
<td>'.$doc_name.'</td>
</tr>
<tr>
<td>Observation Date :</td>
<td>'.$date.'</td>
</tr>
<tr>
<td>Observation Type :</td>
<td>'.$obstype[0]->ob_name .'</td>
</tr>
<tr>
<td>Observation Sub Type :</td>
<td>'.$email_sub_type.'</td>
</tr>
<tr>
<td>Targeted Date for Compliance :</td>
<td>'.date('d-m-Y',strtotime($tg_date)).'</td>
</tr>
<tr>
<td>Observation Stage :</td>
<td>'.$crmess.'</td>
</tr>
<tr>
<td>Login to View Observation</td>
<td><a href="'.$base.'">login</a></td>
</tr>
<tr class="fot"><td></td> <td></td></tr>
</table>
</div>
</body>
</html> ';
		

		$this->email->set_newline("\r\n");
		$this->email->from('admin@iitmanagement.co.in');
		$this->email->to($iitm_manager[0]->u_personal_email_id);
		$this->email->subject('Observation From WAPCOS');
		$this->email->message($htmltemplate);
		$this->email->send();

		
		 $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Success!</strong> Observation and Complaince Register successfully.
		</div>');
		
		//print_r($dataInfo);
		
			redirect('Wapcos/observationAndComplaince');

	}
	
	public function stringReplace(){
		
		$doc_name ="Teat sms";
		$crmess ="We for ind sms";
		$tg_date ="11-09-1999";
		//$doc_name ="Teat sms";
		
			
		$mmsg = 'OBS from WAPCOS  OBS Name : '.$doc_name.' OBS Type: Critical State : '.$crmess .' Targated Date : '.$tg_date;
		
		$stripped = str_replace(' ','%20',$mmsg);
		
		
		
	}
	
	public function editCompliance(){
		
		//print_r($_POST);
		
		$file_tot =count($_FILES['userfile']['name']);
		$proj= $this->input->post('project');
		$date= $this->input->post('date');
		$doc_name= $this->input->post('documentname');
		$observation_type= $this->input->post('document_type');
		$remarks= $this->input->post('remarks');
		$services= $this->input->post('services');
		$id= $this->input->post('id');
		$sub_obser= $this->input->post('sub_obser');
		$tg_date= $this->input->post('tg_date');
		$critical = $this->input->post('critical');

		if($critical){

		   $crit = 1;
		   $crmess ="Yes";

		}else{

		   $crit = 0;
		   $crmess ="No";

		}
		
	 	$data = array(
				'oc_project_id'=>$proj,
				'oc_service_id'=>$services,
				'oc_date'=>$date,
				'oc_name_doc'=>$doc_name,
				'oc_doc_type'=>$observation_type,
				'oc_doc_sub_type'=>$sub_obser,
				'oc_remarks'=>$remarks,
				'oc_upload_name'=>$file_tot,
				'oc_date_created'=>date('Y-m-d'),
				'oc_tardated_date'=>$tg_date,
				'oc_critical_status'=>$crit,
		);
		
			
		$this->db->where('oc_id',$id);	
		$this->db->update('observation_and_comp',$data);
		//$insert_id = $this->db->insert_id();
		
		$this->load->library('upload');
        $dataInfo = array();
        $files = $_FILES;
        $cpt = count($_FILES['userfile']['name']);
		for($i=0; $i<$cpt; $i++)
		{           
			$_FILES['userfile']['name']= $files['userfile']['name'][$i];
			$_FILES['userfile']['type']= $files['userfile']['type'][$i];
			$_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
			//$_FILES['userfile']['filename']= $files['userfile']['filename'][$i];
			$_FILES['userfile']['error']= $files['userfile']['error'][$i];
			$_FILES['userfile']['size']= $files['userfile']['size'][$i];    

			$this->upload->initialize($this->set_upload_options());
			$hh =$this->upload->do_upload('userfile');
			$dataInfo[$i] = $this->upload->data();
			//echo $_FILES['userfile']['filename'];
			
			
			
			$data_up = array(
			
						'oacf_oac_id'=>$id,
						'oac_name'=>$dataInfo[$i]['file_name'],
						'oac_pr_id'=>$proj,
						//''=>,
			
			
			);
			
			$this->db->insert('oacf_files',$data_up);
		
		} 
			
		


		$observation = 	$this->db->select('*')->from('observation_type')->where('ob_id',$observation_type)->get();
		$obstype = $observation->result();
		
		
		if($sub_obser){
			
			
			$ods = $this->db->select('*')->from('observation_sub_type')->where('obs_id',$sub_obser)->get();
			
			$resu = $ods->result();
			
			$sub_type = '%0aOBS sub-type : '.$resu[0]->obs_name;
			$email_sub_type = $resu[0]->obs_name;
			
		}else{
			
			$sub_type = "";
			$email_sub_type ="Nill";
		}
		
		$select_user = $this->db->select('*')->from('user_table')->where('u_auth',5)->where('u_pj_id',$proj)->get();
		
		$iitm_manager = $select_user->result();
		
		$mmsg = 'Update the OBS  %0aOBS Name : '.$doc_name.' %0aOBS Type: '.$obstype[0]->ob_name .$sub_type.' %0aCritical Stage : '.$crmess .' %0aTarget Date : '.date('d-m-Y',strtotime($tg_date));
		
 	$stripped = str_replace(' ','%20',$mmsg);
 $url ='http://hpapi.dial4sms.com/SendSMS/sendmsg.php?uname=wapcost&pass=wapcost&send=WAPCOS&dest='.$iitm_manager[0]->u_mobile .'&msg='.$stripped;

$base = base_url();
		
					$ch = curl_init();
					$timeout = 30;
					curl_setopt ($ch,CURLOPT_URL, $url) ;
					curl_setopt ($ch,CURLOPT_RETURNTRANSFER, 1);
					 curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
					curl_setopt ($ch,CURLOPT_CONNECTTIMEOUT, $timeout) ;
					$response = curl_exec($ch) ;
					curl_close($ch) ;  
		
		$htmltemplate=' <!DOCTYPE html>
<html>
<head>
<style>
table {
font-family: arial, sans-serif;
border-collapse: collapse;
width: 100%;
}
.em{box-shadow: 0px 5px 20px 0px #cfd3ff; width:600px; margin:0 auto;}
.em .log { background-color: #e3bdb8; }
.em .log th{padding:10px;}
.em .tb td{padding:20px 20px;}
.em .tb td:first-child{width:40%; font-weight:bold; color:#2c3879;}
.em .fot{background-color: #e3bdb8; height:3px;}
.em .fot td{padding:3px;}
.em img
{
width:100px;
height:100px;
}
</style>
</head>
<body>
<div class="em">
<table>
<tr class="log">
<th><img src="http://wapcos.istudiotech.in/admin_template/images/1200px-IIT_Madras_Logo.svg.png"></th>
<th>(TPQAS) Observation</th>
<th><img src="http://wapcos.istudiotech.in/admin_template/images/WAPCOS-Limited-1.png"></th>
</tr>
</table>
<table class="tb">
<tr>
<td>Observation Name :</td>
<td>'.$doc_name.'</td>
</tr>
<tr>
<td>Observation Date :</td>
<td>'.$date.'</td>
</tr>
<tr>
<td>Observation Type :</td>
<td>'.$obstype[0]->ob_name .'</td>
</tr>
<tr>
<td>Observation Sub Type :</td>
<td>'.$email_sub_type.'</td>
</tr>
<tr>
<td>Targeted Date for Compliance :</td>
<td>'.date('d-m-Y',strtotime($tg_date)).'</td>
</tr>
<tr>
<td>Observation Stage :</td>
<td>'.$crmess.'</td>
</tr>
<tr>
<td>Login to View Observation</td>
<td><a href="'.$base.'">login</a></td>
</tr>
<tr class="fot"><td></td> <td></td></tr>
</table>
</div>
</body>
</html> ';
		

		$this->email->set_newline("\r\n");
		$this->email->from('admin@iitmanagement.co.in');
		$this->email->to($iitm_manager[0]->u_personal_email_id);
		$this->email->subject('Update the Observation');
		$this->email->message($htmltemplate);
		$this->email->send();


		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Success!</strong> Observation  Updated successfully.
		</div>');
		
		//print_r($dataInfo);
		
		redirect('Wapcos/editObservationAndComplainceDetails/'.$id); 
		
	}
	
	public function viewobservationAndCompaints(){

		$this->db->select('*');
		$this->db->from('observation_and_comp');
		$this->db->join('project_details', 'project_details.p_id = observation_and_comp.oc_project_id');
		$this->db->join('observation_type', 'observation_type.ob_id = observation_and_comp.oc_doc_type');
		/* $this->db->join('observation_sub_type', 'observation_sub_type.obs_id = observation_and_comp.oc_doc_sub_type'); */ 
		//$this->db->join('observation_sub_type', 'observation_sub_type.obs_id = observation_and_comp.oc_doc_sub_type');
		//$this->db->join('comments', 'comments.id = uploads.id');
		 $this->db->where('observation_and_comp.oc_delete_status',0);
		 $this->db->order_by('observation_and_comp.oc_id',"DESC");
		$doctype = $this->db->get();
		
		$data['doctype']=$doctype->result();
	
		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/viewobservationandcomplaince',$data);
		$this->load->view('wapcos/template/footer'); 
	
	}

	public function viewobservationAndCompaintsProject(){
		
		$pr_id = $this->uri->segment(3);
		$st_id = $this->uri->segment(4);
			
		$this->db->select('*');
		$this->db->from('observation_and_comp');
		$this->db->join('project_details', 'project_details.p_id = observation_and_comp.oc_project_id');
		//$this->db->join('project_details', 'project_details.p_id = observation_and_comp.oc_project_id');
		$this->db->join('observation_type', 'observation_type.ob_id = observation_and_comp.oc_doc_type');
		 $this->db->where('observation_and_comp.oc_project_id',$pr_id);
		 $this->db->where('observation_and_comp.oc_status',$st_id);
		 $this->db->where('observation_and_comp.oc_delete_status',0);
		 $this->db->order_by('observation_and_comp.oc_id','DESC');
		$doctype = $this->db->get();
		
		$data['doctype']=$doctype->result();
		
		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/viewobservationandcomplaince',$data);
		$this->load->view('wapcos/template/footer'); 
		
	
	}
	
		public function viewobservationAndCompaintsProjectInd(){
		
		$pr_id = $this->uri->segment(3);
		
			
		$this->db->select('*');
		$this->db->from('observation_and_comp');
		$this->db->join('project_details', 'project_details.p_id = observation_and_comp.oc_project_id');
		$this->db->join('observation_type', 'observation_type.ob_id = observation_and_comp.oc_doc_type');
		
		 $this->db->where('observation_and_comp.oc_project_id',$pr_id);
		 $this->db->where('observation_and_comp.oc_delete_status',0);
		// $this->db->order_by('observation_and_comp.oc_id','DESC');
		$doctype = $this->db->get();
		
		
		
		$data['doctype']=$doctype->result();
		
		
		
		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/viewobservationandcomplaince',$data);
		$this->load->view('wapcos/template/footer'); 
		
	
	}

	public function editObservationAndComplainceDetails(){
	
		$id = $this->uri->segment(3);
		
		$this->db->select('*');
		$this->db->from('observation_and_comp');
		$this->db->join('project_details', 'project_details.p_id = observation_and_comp.oc_project_id');
		$this->db->join('project_category', 'project_category.pc_id = project_details.p_cat_id');
		//$this->db->join('comments', 'comments.id = uploads.id');
	    $this->db->where('observation_and_comp.oc_id',$id);
		$this->db->where('observation_and_comp.oc_delete_status',0);
		$doctype = $this->db->get();
		
		$data['doctype']=$doctype->result();
		
		
	/* 	$this->db->select('*');
		$this->db->from('upload_files');
		$this->db->where('upf_name !=',"");
		$this->db->where('upf_up_id',$id);
		$files = $this->db->get();
		
		$data['files'] = $files->result();
		 */
		
	$services = $this->db->select('*')->from('project_category')->get();
	$data['service'] = $services->result();
		
		
		$this->db->select('*');
		$this->db->from('oacf_files');
		$this->db->where('oac_name !=',"");
		$this->db->where('oacf_oac_id',$id);
		$files = $this->db->get();
		$data['files'] = $files->result();

		
	$project = $this->db->select('*')->from('project_details')->where('p_status',1)->get();
	$data['project'] = $project->result();
	
		
	 $services = $this->db->select('*')->from('observation_type')->where('ob_status',1)->get();
	
	$data['observation'] = $services->result(); 


		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/editobservationandcomplaince',$data);
		$this->load->view('wapcos/template/footer');
	
			
	}
	public function observationAndComplainceDetails(){
		
	$over_all_data = array();
	$id =  $this->uri->segment(3);
		
		
		$this->db->select('*');
		$this->db->from('observation_and_comp');
		$this->db->join('project_details', 'project_details.p_id = observation_and_comp.oc_project_id');
		$this->db->join('observation_type', 'observation_type.ob_id = observation_and_comp.oc_doc_type');
		//$this->db->join('comments', 'comments.id = uploads.id');
		$this->db->where('observation_and_comp.oc_id',$id);
		$doctype = $this->db->get();
		$data['doctype']=$doctype->result();
		
		
		$this->db->select('*');
		$this->db->from('oacf_files');
		$this->db->where('oac_name !=',"");
		$this->db->where('oacf_oac_id',$id);
		$files = $this->db->get();
		
		$data['files'] = $files->result();
	
		$this->db->select('*');
		$this->db->from('compliance_history');
		$this->db->join('user_table', 'user_table.u_id = compliance_history.ch_user_id');
		//$this->db->join('comments', 'comments.id = uploads.id');
		$this->db->where('compliance_history.champ_id',$id);
		$this->db->order_by('compliance_history.ch_id','DESC');
		$history = $this->db->get();
		$data['history']=$history->result();


		$this->db->select('*');
		$this->db->from('compliance_history_cpwd');
		$this->db->join('user_table', 'user_table.u_id = compliance_history_cpwd.ch_user_id');
		//$this->db->join('comments', 'comments.id = uploads.id');
		$this->db->where('compliance_history_cpwd.champ_cpwd_id',$id);
		$this->db->order_by('compliance_history_cpwd.ch_cpw_id','DESC');
		$history = $this->db->get();
		$data['history_cpwd']=$history->result(); 

		$this->db->select('*');
		$this->db->from('acob_history');
		$this->db->join('user_table', 'user_table.u_id = acob_history. 	ach_user_id');
		//$this->db->join('comments', 'comments.id = uploads.id');
		$this->db->where('acob_history.ach_pr_id',$id);
		$this->db->where('acob_history.ach_auth_iitm_cpwd',2);
		$this->db->order_by('acob_history.ach_id','DESC');
		$history = $this->db->get();
		$data['history_others']=$history->result(); 


		$this->db->select('*');
		$this->db->from('acob_history');
		$this->db->join('user_table', 'user_table.u_id = acob_history. 	ach_user_id');
		//$this->db->join('comments', 'comments.id = uploads.id');
		$this->db->where('acob_history.ach_pr_id',$id);
		$this->db->where('acob_history.ach_auth_iitm_cpwd',1);
		$this->db->order_by('acob_history.ach_id','DESC');
		$history = $this->db->get();
		$data['history_others_user']=$history->result(); 


		foreach($data['history'] as $test){

			//echo  $test->ch_message;
			$data_all = array(
				'user_id'=>$test->u_name,
				'message'=>$test->ch_message,
				'file_name'=>$test->ch_file_name,
				'm_date_time'=>$test->ch_date_time,
			
			);
			


		array_push($over_all_data ,$data_all)	;

		}

		foreach($data['history_others'] as $test){

			//echo  $test->ch_message;
			$data_all = array(
				'user_id'=>$test->u_name,
				'message'=>$test->ach_message,
				'file_name'=>$test->ach_file_name,
				'm_date_time'=>$test->ach_date_time,
			
			);
	
		array_push($over_all_data ,$data_all)	;

		}
		foreach($data['history_others_user'] as $test){

			//echo  $test->ch_message;
			$data_all = array(
				'user_id'=>$test->u_name,
				'message'=>$test->ach_message,
				'file_name'=>$test->ach_file_name,
				'm_date_time'=>$test->ach_date_time,
			
			);
	
		array_push($over_all_data ,$data_all)	;

		}

		foreach($data['history_cpwd'] as $test){

		
			//echo  $test->ch_message;
			$data_all = array(
				'user_id'=>$test->u_name,
				'message'=>$test->ch_message,
				'file_name'=>$test->ch_file_name,
				'm_date_time'=>$test->ch_date_time,
			
			);
			


		array_push($over_all_data ,$data_all)	;

		}
		usort($over_all_data, array($this, "date_compare")); 
	//	usort($over_all_data,'date_compare');
	//	usort($over_all_data, 'date_compare');

	 	/* echo"<pre>";
		print_r($over_all_data);  */

$data['over_all_status'] =$over_all_data;
	
	 
		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/viewobservationandcomplaincedetails',$data);
		$this->load->view('wapcos/template/footer'); 
	 
	}


	public function date_compare($a, $b)
	{
		$t1 = strtotime($a['m_date_time']);
		$t2 = strtotime($b['m_date_time']);
		return $t1 - $t2;
	}   
	
	public function addActionTaken(){
		

		$config = array();
					$config['upload_path'] = 'uploads/';
					$config['allowed_types'] = '*';
					$config['remove_spaces'] = TRUE;
					$config['overwrite'] = FALSE;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('filename'))
                {
                  

                    $error = array('error' => $this->upload->display_errors());
				$filename = null;
				//	print_r($error);

                   // $this->load->view('upload', $error);
                }
                else
                {
                    $data = array('upload_data' => $this->upload->data());

					$filename = $data['upload_data']['file_name'];
					//	print_r($data);

                   // $this->load->view('success', $data);
                }


			$action_taken = array(
		
					'champ_id'=>$_POST['project_id'],
					'ch_auth_id'=>$this->session->userdata['userdata']['user_auth'],
					'ch_message'=>$_POST['message'],
					'ch_file_name'=>$filename,
					'ch_date_time'=>date('Y-m-d :H:i:sa'),
					'ch_user_id'=>$this->session->userdata['userdata']['user_id'],
					'ch_status'=>1,
		);  
		
		$this->db->insert('compliance_history',$action_taken);
		
		
	//	PRINT_R($action_taken);
		
		
	
		$user = $this->Wapcos->select_project_iitm($_POST['project_id']);
		
	//	print_r($user);
			
		if($user[0]->oc_doc_sub_type !="" ||$user[0]->oc_doc_sub_type !=null ){
			
			$sub_obs = $this->db->select('*')->from('observation_sub_type')->where('obs_id',$user[0]->oc_doc_sub_type)->get();
			
			$sub_obser = $sub_obs->result(); 
			
			if($sub_obser){
				
				$sub_type = $sub_obser[0]->obs_name;

				$sub_type_msg = '%0aSub Type'.$sub_obser[0]->obs_name;


			}else{
				
				$sub_type = "Nill";
				$sub_type_msg ="";
			}
			
			
			
		}else{
			
			$sub_type = "Nill";
		}
		
		
		if($user[0]->oc_critical_status == 1){
			
			
			$crmess ='Yes';
						
		}else{
			
			$crmess ='NO';
		}






		$mmsg = 'OBS Msg WAPCOS %0aOBS Date : '.date('d-m-Y',strtotime($user[0]->oc_date_created)).' %0aOBS Type: '.$user[0]->ob_name .$sub_type_msg.' %0aComments Given on the OBS ';
		
		$stripped = str_replace(' ','%20',$mmsg);
	$url ='http://hpapi.dial4sms.com/SendSMS/sendmsg.php?uname=wapcost&pass=wapcost&send=WAPCOS&dest='.$user[0]->u_mobile.'&msg='.$stripped;
   
   $base = base_url();
		   
					   $ch = curl_init();
					   $timeout = 30;
					   curl_setopt ($ch,CURLOPT_URL, $url) ;
					   curl_setopt ($ch,CURLOPT_RETURNTRANSFER, 1);
						curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
					   curl_setopt ($ch,CURLOPT_CONNECTTIMEOUT, $timeout) ;
					   $response = curl_exec($ch) ;
					   curl_close($ch) ;  


		$base = base_url();
		
				$htmltemplate=' <!DOCTYPE html>
							<html>
							<head>
							<style>
							table {
							font-family: arial, sans-serif;
							border-collapse: collapse;
							width: 100%;
							}
							.em{box-shadow: 0px 5px 20px 0px #cfd3ff; width:600px; margin:0 auto;}
							.em .log { background-color: #e3bdb8; }
							.em .log th{padding:10px;}
							.em .tb td{padding:20px 20px;}
							.em .tb td:first-child{width:40%; font-weight:bold; color:#2c3879;}
							.em .fot{background-color: #e3bdb8; height:3px;}
							.em .fot td{padding:3px;}
							.em img
							{
							width:100px;
							height:100px;
							}
							</style>
							</head>
							<body>
							<div class="em">
							<table>
							<tr class="log">
							<th><img src="http://wapcos.istudiotech.in/admin_template/images/1200px-IIT_Madras_Logo.svg.png"></th>
							<th>(TPQAS) Observation</th>
							<th><img src="http://wapcos.istudiotech.in/admin_template/images/WAPCOS-Limited-1.png"></th>
							</tr>
							</table>
							<table class="tb">
							<tr>
							<td>Projectname Name :</td>
							<td>'.$user[0]->p_short_name .'</td>
							</tr>
							<tr>
							<td>Observation Date :</td>
							<td>'.date('d-m-Y',strtotime($user[0]->oc_date_created)).'</td>
							</tr>
							<tr>
							<td>Observation Type :</td>
							<td>'.$user[0]->ob_name .'</td>
							</tr>
							<tr>
							<td>Observation Sub Type :</td>
							<td>'.$sub_type .'</td>
							</tr>
							<tr>
							<td>Observation Message :</td>
							<td>'.$_POST['message'].'</td>
							</tr>
							<tr>
							<td>Targeted Date for Compliance :</td>
							<td>'.date('d-m-Y',strtotime($user[0]->oc_tardated_date)).'</td>
							</tr>
							<tr>
							<td>Observation Stage :</td>
							<td>'.$crmess.'</td>
							</tr>
							<tr>
							<td>Login to View Observation</td>
							<td><a href="'.$base.'">login</a></td>
							</tr>
							<tr class="fot"><td></td> <td></td></tr>
							</table>
							</div>
							</body>
							</html> ';
							
							if($filename){
							$uploads = base_url().'uploads/'.$filename;	
								
							}else{
								
							$uploads="";	
							}
							
		

				$this->email->set_newline("\r\n");
				$this->email->from('admin@iitmanagement.co.in');
				$this->email->to($user[0]->u_personal_email_id);
				$this->email->subject('Observation Comments ');
				$this->email->message($htmltemplate);
				$this->email->attach($uploads);
				$this->email->send();
		
			
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Success !</strong> message successfully.
		</div>');
		
		//print_r($dataInfo);
		
		redirect('Wapcos/observationAndComplainceDetails/'.$_POST['project_id']);
	
		
	}public function mahtest(){
		
		
		$RESULT =   0x11;

echo "$RESULT";
	}
	
	
	public function updateStatusComp(){
		
		
		//	print_r($_POST);
		
		if($_POST['Proj_status'] == 2){

			$updateData = array(
				'oc_status'=>$_POST['Proj_status'],
				'oc_delete_request_iitm'=>$_POST['Proj_status'],
		);



		}else{


			$updateData = array(
				'oc_status'=>$_POST['Proj_status'],
				'oc_delete_request_iitm'=>$_POST['Proj_status'],
		);


		}


		$this->db->where('oc_status',1);
		$this->db->where('oc_id',$_POST['comp_proj_id']);
		$this->db->update('observation_and_comp', $updateData);



		$action_taken = array(
		
			'champ_id'=>$_POST['comp_proj_id'],
			'ch_auth_id'=>$this->session->userdata['userdata']['user_auth'],
			'ch_message'=>"Observations closed",
		//	'ch_file_name'=>$filename,
			'ch_date_time'=>date('Y-m-d :H:i:sa'),
			'ch_user_id'=>$this->session->userdata['userdata']['user_id'],
			'ch_status'=>1,
	);  
	
	$this->db->insert('compliance_history',$action_taken);

		$observation =	$this->db->select('t1.*,t2.*')
		->from('observation_and_comp as t1')
		->where('t1.oc_id',$_POST['comp_proj_id'])
		->join('observation_type as t2', 't1.oc_doc_type = t2.ob_id', 'LEFT')
		->get();

		$obs = $observation->result();

		$user = $this->db->select('*')->from('user_table')->where('u_pj_id',$obs[0]->oc_project_id)->where('u_auth',5)->get();
		$user_details = $user->result();

		$project=$this->db->select('*')->from('project_details')->where('p_id',$obs[0]->oc_project_id)->get();

		$pro = $project->result();
	
	
		if($obs[0]->oc_doc_sub_type !=""){
				
				
			$ods = $this->db->select('*')->from('observation_sub_type')->where('obs_id',$obs[0]->oc_doc_sub_type)->get();
			
			$resu = $ods->result();
			
			$sub_type = '%0aOBS sub-type : '.$resu[0]->obs_name;
			$email_sub_type = $resu[0]->obs_name;
			
		}else{
			
			$sub_type = "";
			$email_sub_type ="Nill";
		}
		
	
		if($obs[0]->oc_critical_status==1){
	
			$crit = 1;
			$crmess ="Yes";
	
		 }else{
	
			$crit = 0;
			$crmess ="No";
		 }
	
		
			$mmsg = 'OBS closed Successfully : '.$pro[0]->p_m_s_name.' %0aOBS Name : '.$obs[0]->oc_name_doc.' %0aOBS Type: '.$obs[0]->ob_name .$sub_type.' %0aCritical Stage : '.$crmess .' %0aTarget Date : '.date('d-m-Y',strtotime($obs[0]->oc_tardated_date));
			
		 $stripped = str_replace(' ','%20',$mmsg);
	 $url ='http://hpapi.dial4sms.com/SendSMS/sendmsg.php?uname=wapcost&pass=wapcost&send=WAPCOS&dest='.$user_details[0]->u_mobile.'&msg='.$stripped;
	
	$base = base_url();
			
						$ch = curl_init();
						$timeout = 30;
						curl_setopt ($ch,CURLOPT_URL, $url) ;
						curl_setopt ($ch,CURLOPT_RETURNTRANSFER, 1);
						 curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
						curl_setopt ($ch,CURLOPT_CONNECTTIMEOUT, $timeout) ;
						$response = curl_exec($ch) ;
						curl_close($ch) ;  
	 
	
			
	$htmltemplate=' <!DOCTYPE html>
	<html>
	<head>
	<style>
	table {
	font-family: arial, sans-serif;
	border-collapse: collapse;
	width: 100%;
	}
	.em{box-shadow: 0px 5px 20px 0px #cfd3ff; width:600px; margin:0 auto;}
	.em .log { background-color: #e3bdb8; }
	.em .log th{padding:10px;}
	.em .tb td{padding:20px 20px;}
	.em .tb td:first-child{width:40%; font-weight:bold; color:#2c3879;}
	.em .fot{background-color: #e3bdb8; height:3px;}
	.em .fot td{padding:3px;}
	.em img
	{
	width:100px;
	height:100px;
	}
	</style>
	</head>
	<body>
	<div class="em">
	<table>
	<tr class="log">
	<th><img src="http://wapcos.istudiotech.in/admin_template/images/1200px-IIT_Madras_Logo.svg.png"></th>
	<th>(TPQAS) Observation</th>
	<th><img src="http://wapcos.istudiotech.in/admin_template/images/WAPCOS-Limited-1.png"></th>
	</tr>
	</table>
	<table class="tb">
	<tr>
	<td>Observation Name :</td>
	<td>'.$obs[0]->oc_name_doc .'</td>
	</tr>
	<tr>
	<td>Observation Date :</td>
	<td>'.date('d-m-Y',strtotime($obs[0]->oc_date)).'</td>
	</tr>
	<tr>
	<td>Observation Type :</td>
	<td>'.$obs[0]->ob_name.'</td>
	</tr>
	<tr>
	<td>Observation Sub Type :</td>
	<td>'.$email_sub_type.'</td>
	</tr>
	<tr>
	<td>Targeted Date for Compliance :</td>
	<td>'.date('d-m-Y',strtotime($obs[0]->oc_tardated_date)).'</td>
	</tr>
	<tr>
	<td>Observation Stage :</td>
	<td>'.$crmess.'</td>
	</tr>
	<tr>
	<td>Login to View Observation</td>
	<td><a href="'.$base.'">login</a></td>
	</tr>
	<tr class="fot"><td></td> <td></td></tr>
	</table>
	</div>
	</body>
	</html> ';
			
	
			$this->email->set_newline("\r\n");
			$this->email->from('admin@iitmanagement.co.in');
			$this->email->to($user_details[0]->u_personal_email_id);
			$this->email->subject('Observation Closed Successfully : '.$pro[0]->p_m_s_name);
			$this->email->message($htmltemplate);
			$this->email->send();




		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Success ! </strong> Status successfully Updated.
		</div>');
		
		//print_r($dataInfo);
		
		redirect('Wapcos/observationAndComplainceDetails/'.$_POST['comp_proj_id']);
		
	}
	
	public function deleteComplieance(){
		
		
		$id = $this->input->post('value');
		
		
		
					$data = array(
					'oc_delete_status'=>1,
					);
	
	$this->db->where('oc_id',$id);
	$this->db->update('observation_and_comp',$data);
		
		echo "success";
	
	}
	//---------------------------------------------view schedule ----------------------------------//
	
	
	
	public function viewSchedule(){
		
			$uri = $this->uri->segment(3);
	
			$schedule =	$this->db->select('*')->from('project_details')->where('p_id',$uri)->get();
			$data['schedule'] = $schedule->result();
		
			$mile_stone = $this->db->select('*')->from('mile_stone')->where('ms_s_id',$uri)->order_by('ms_id','ASC')->get();
			$data['mile_stone'] = $mile_stone->result();
		
		/* $activities = $this->db->select('*')->from('activities')->where('act_sc_id',$uri)->get();
		$data['activities'] = $activities->result(); */
		
		
		$this->db->select('*');
		$this->db->from('activities');
		$this->db->join('mile_stone', 'mile_stone.ms_id = activities.act_mi_id');
		$this->db->where('activities.act_sc_id',$uri);
		$query = $this->db->get();
		
		$data['activities'] = $query->result();
		
			$this->db->select('*');
			$this->db->from('task__s');
			$this->db->join('activities', 'activities.act_id = task__s.ts_ac_id');
			$this->db->join('mile_stone', 'mile_stone.ms_id = task__s.ts_mi_id');
			//$this->db->join('mile_stone', 'mile_stone.ms_id = activities.act_mi_id');
			$this->db->where('task__s.ts_pr_id',$uri);
			$this->db->order_by('task__s.ts_mi_id','ASC');
			$this->db->order_by('task__s.ts_start','ASC');
			$tasks = $this->db->get();
			$data['tasks'] = $tasks->result();
		
		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/viewschedule',$data);
		$this->load->view('wapcos/template/footer');
		
		
		
		
		
	}
	
	public function cptTest(){
		$uri = 4;
		$mil = 10;
		
			$this->db->select('*');
			$this->db->from('task__s');
			
			$this->db->where('task__s.ts_pr_id',$uri);
			$this->db->where('task__s.ts_mi_id',$mil);
			$this->db->order_by('task__s.ts_id','ASC');
			$tasks = $this->db->get();
		
			$data = $tasks->result();
			$data2 = $tasks->result_array();
			$removed = array_shift($data2);
		//echo"<pre>"	;
		//print_r($data2);	
 			foreach($data2 as $vast){
				
				
				 $vast['ts_id'];
			

$qq = $this->db->select('ts_id')->from('task__s')->where('ts_mi_id',10)->where('ts_id <',$vast['ts_id'])->where('ts_end >=',$vast['ts_start'])->limit(1)->get();

$rer = $qq->result();

//echo"<pre>";
	//print_r($rer);	
	
			}
			 
			
			
			
		
	}
	public function mileStoneView(){
		
		$uri=$this->uri->segment(3);
		$mil=$this->uri->segment(4);
		
		
		
			$schedule =	$this->db->select('*')->from('project_details')->where('p_id',$uri)->get();
			$data['schedule'] = $schedule->result();
		
			$mile_stone = $this->db->select('*')->from('mile_stone')->where('ms_s_id',$uri)->where('ms_id',$mil)->order_by('ms_id','ASC')->get();
			$data['mile_stone'] = $mile_stone->result();
		
		/* $activities = $this->db->select('*')->from('activities')->where('act_sc_id',$uri)->get();
		$data['activities'] = $activities->result(); */
		
		
		$this->db->select('*');
		$this->db->from('activities');
		$this->db->join('mile_stone', 'mile_stone.ms_id = activities.act_mi_id');
		$this->db->where('activities.act_sc_id',$uri);
		$this->db->where('activities.act_mi_id',$mil);
		$this->db->order_by('activities.act_id','ASC');
		$query = $this->db->get();
		
		$data['activities'] = $query->result();
		
		
			$this->db->select('*');
			$this->db->from('task__s');
			$this->db->join('activities', 'activities.act_id = task__s.ts_ac_id');
			$this->db->join('mile_stone', 'mile_stone.ms_id = task__s.ts_mi_id');
			//$this->db->join('mile_stone', 'mile_stone.ms_id = activities.act_mi_id');
			$this->db->where('task__s.ts_pr_id',$uri);
			$this->db->where('task__s.ts_mi_id',$mil);
			$this->db->order_by('task__s.ts_id','ASC');
			$tasks = $this->db->get();
		
			$data['tasks'] = $tasks->result();
			$data['crit'] = $tasks->result();
	
		//$this->load->view('wapcos/site/googleganttchat',$data);
	//	$this->load->view('wapcos/site/createganttchart',$data);
		//$this->load->view('wapcos/site/newgantt',$data);
		$this->load->view('wapcos/site/newgantt_parallel',$data);
			
	}
	
	public function selectTaskForCri(){
		
		$id = $_POST['crit'];
		
		
		$tad = $this->db->select('*')->from('task__s')->where('ts_id',$id)->get();
		
		$restu = $tad->result();
		
		$actt = $this->db->select('*')->from('task__s')->where('ts_id !=',$id)->where('ts_end <',$restu[0]->ts_start)->where('ts_ac_id',$restu[0]->ts_ac_id)->order_by('ts_end', 'DESC')->limit(1)->get();
		$varr=$actt->result();

	$html="";
	
	foreach($varr as $test){
		
	$html.=	'<div class="checkbox">
	<input type="checkbox" name="checkbox[]" value="'.$test->ts_id .'"> ' . $test->ts_name .'
	</div>';
		
	}
	
	echo $html;	

	}
	public function UpdateCriticalPath(){
		
		//print_r($_POST['checkbox']);
		
	$crick_path = 	implode(",",$_POST['checkbox']);
	
	
	
	if($_POST['checkbox']== ""){
		
		
		$vid = null;
		
	}else{
		
	$vid = $crick_path;	
		
	}
	
	
	$id= $_POST['tas_id'];
		
		
		$data =array(
		'ts_critical'=>$vid,
		);
		
		$this->db->where('ts_id',$id);
		$this->db->update('task__s',$data);
		
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Success ! </strong> Critical path Updated successfully.
		</div>');

 redirect('Wapcos/editSchedule/'.$_POST['proj_idd']);
		
		
	}
	
	public function mileStoneReport(){
		
		
			$uri=$this->uri->segment(3);
		$mil=$this->uri->segment(4);
		
		
		
			$schedule =	$this->db->select('*')->from('project_details')->where('p_id',$uri)->get();
			$data['schedule'] = $schedule->result();
		
			$mile_stone = $this->db->select('*')->from('mile_stone')->where('ms_s_id',$uri)->where('ms_id',$mil)->order_by('ms_id','ASC')->get();
			$data['mile_stone'] = $mile_stone->result();
		
		/* $activities = $this->db->select('*')->from('activities')->where('act_sc_id',$uri)->get();
		$data['activities'] = $activities->result(); */
		
		
		$this->db->select('*');
		$this->db->from('activities');
		$this->db->join('mile_stone', 'mile_stone.ms_id = activities.act_mi_id');
		$this->db->where('activities.act_sc_id',$uri);
		$this->db->order_by('activities.act_id','ASC');
		$query = $this->db->get();
		
		$data['activities'] = $query->result();
		
		
			$this->db->select('*');
			$this->db->from('task__s');
			$this->db->join('activities', 'activities.act_id = task__s.ts_ac_id');
			$this->db->join('mile_stone', 'mile_stone.ms_id = task__s.ts_mi_id');
			//$this->db->join('mile_stone', 'mile_stone.ms_id = activities.act_mi_id');
			$this->db->where('task__s.ts_pr_id',$uri);
			$this->db->where('task__s.ts_mi_id',$mil);
			$this->db->order_by('task__s.ts_mi_id','DESC');
			$tasks = $this->db->get();
		
			$data['tasks'] = $tasks->result();
		
		
		$this->load->view('wapcos/site/milstone_report',$data);
		
	}
	
	public function UpdateMiAct(){
		
		
			$sch=$this->uri->segment(3);
			$mil=$this->uri->segment(4);
		
		
			$sched = $this->db->select('*')->from('project_details')->where('p_id',$sch)->get();
			$data['schedule'] = $sched->result();
		
		
			$mile_stone = $this->db->select('*')->from('mile_stone')->where('ms_id',$mil)->get();
			$data['mile_stone'] = $mile_stone->result();
		
		$this->db->select('*');
		$this->db->from('activities');
		$this->db->join('mile_stone', 'mile_stone.ms_id = activities.act_mi_id');
		$this->db->where('activities.act_mi_id',$mil);
		$this->db->where('activities.act_sc_id',$sch);
		$this->db->order_by('activities.act_id','ASC');
		$query = $this->db->get();
		
		$data['activities'] = $query->result();
		
		
			$this->db->select('*');
			$this->db->from('task__s');
			$this->db->join('activities', 'activities.act_id = task__s.ts_ac_id');
			$this->db->join('mile_stone', 'mile_stone.ms_id = task__s.ts_mi_id');
			//$this->db->join('mile_stone', 'mile_stone.ms_id = activities.act_mi_id');
			$this->db->where('task__s.ts_pr_id',$sch);
			$this->db->where('task__s.ts_mi_id',$mil);
			$this->db->order_by('task__s.ts_mi_id','DESC');
			$tasks = $this->db->get();
		
			$data['tasks'] = $tasks->result();
		
		
		
			
		  $this->load->view('wapcos/template/header');
		  $this->load->view('wapcos/template/sidebar');
		  $this->load->view('wapcos/template/navbar');
		  $this->load->view('wapcos/site/actandtask',$data);
		  $this->load->view('wapcos/template/footer');
		
		
	}
	
	public function activityUpdate(){
		
		
		$mi_id = $this->input->post('id');
		$pr_id = $this->input->post('pr_id');
		$sdate = $this->input->post('Updatedates');
		$edate = $this->input->post('Updatedatee');
		$comm = $this->input->post('comments');
		$plannedcost = $this->input->post('plannedcost');
		$updatedcost = $this->input->post('updatedcost');
		$billunderprog = $this->input->post('billunderprog');
		
		
		$data = array(
				'ms_s_updated_date'=>$sdate,
				'ms_e_update_date'=>$edate,
				'mi_plan_cost'=>$plannedcost,
				'mi_update_cost'=>$updatedcost,
				'mi_prog_bill_cost'=>$billunderprog,
				'ms_comment'=>$comm,
		);
		
		$this->db->where('ms_id',$mi_id);
		$this->db->update('mile_stone',$data);
	
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Success ! </strong> Milestone Updated successfully.
		</div>');

 redirect('Wapcos/UpdateMiAct/'.$pr_id.'/'.$mi_id);
	
	}
	
	
	public function updateOverallActivities(){
		
		
	$act_id =   $this->input->post('intt');
	$start_date = 	$this->input->post('supdate_date');
	$completed_date = 	$this->input->post('fupdate_date');
	$comments = 	$this->input->post('update_comments');
		
		
		
		if($start_date==""){
			
			$act_start =  null;
			
		}else{
			
			$act_start = $start_date;
					
		}
		if($completed_date==""){
			
			$act_end   = null;
			
		}else{
			
			$act_end = $completed_date;
	
		}
		
		
		
		
		
		$data = array(
		       'act_act_days'=>$act_start,
		       'act_update_date'=>$act_end,
		       'act_comments'=>$comments,
		    );
			
		$this->db->where('act_id',$act_id);
		$this->db->update('activities',$data);
		
		echo"success";
		
	}
	
	public function updateOverAllTask(){
		
		
	$task_id =   $this->input->post('intt');
	$task_s_date = 	$this->input->post('task_s_date');
	$task_end_date = 	$this->input->post('task_end_date');
	$task_comm = 	$this->input->post('task_comm');
	$task_per = 	$this->input->post('per_comp');
		
		
		
		
		if($task_s_date==""){
			
			$task_start =  null;
			
		}else{
			
			$task_start = $task_s_date;
					
		}
		if($task_end_date==""){
			
			$task_end   = null;
			
		}else{
			
			$task_end = $task_end_date;
	
		}
	
		$data = array(
			
		'ts_actu_s_date'=>$task_start,
		'ts_actu_e_date'=>$task_end,
		'ts_comments'=>$task_comm,
		'ts_perc_compv'=>$task_per,
			
		);
			
		$this->db->where('ts_id',$task_id);
		$this->db->update('task__s',$data); 
			
		echo"success";
	
	}
	
	
	public function deleteTask(){
		
		
	$id = $this->input->post('task');
		
		
		
		
		
		$this->db->delete('task__s', array('ts_id' => $id)); 
		
		echo"success";
		
	}
	
	
	public function deleteActivity(){
		
		
	$id = $this->input->post('act_id'); 
	$query = $this->db->select('ts_id')->from('task__s')->where('ts_ac_id',$id)->get();	
		
	$data = $query->result_array();
		
		
	$arrayTemp = array();
    $i = 0;
	
	if($data){
	
    foreach ($data as $key => $val) {
        $arrayTemp[$i] = $val['ts_id'];
		
		
		
		$this->db->delete('task__s', array('ts_id' => $val['ts_id'])); 
		
		
		
        $i++;
    }
	}
	
		$this->db->delete('activities', array('act_id' => $id)); 
	
		
	echo"success";

	}
	
	public function deleteMilestone(){
		
		$mil_id = $this->input->post('mil_id');
	    $act_id = $this->db->select('act_id')->from('activities')->where('act_mi_id',$mil_id)->get();
	
		$data = $act_id->result_array();	
			
			
			if($data){
				
				 foreach ($data as $key => $val) {
				
				  $task = $this->db->select('ts_id')->from('task__s')->where('ts_ac_id',$val['act_id'])->get();
	              $t_id = $task->result_array();	
				
				
					 foreach ($t_id as  $tval) {
						 
					
												
								$this->db->delete('task__s', array('ts_id' => $tval['ts_id'])); 
							
							
					 }
				
				
					$this->db->delete('activities', array('act_id' => $val['act_id'])); 
				
				 }
			}	
			
		$this->db->delete('mile_stone', array('ms_id' => $mil_id)); 
	
	
		echo"success";
		
	}
	
	
		public function viewIITobservationAndCompaints(){
		
		
		$proj_id = $this->uri->segment(3);
		
		//$proj_id = $this->user_detail[0]->u_pj_id;
		
		
		$this->db->select('*');
		$this->db->from('arct_contract_obs_comp');
		$this->db->join('project_details', 'project_details.p_id = arct_contract_obs_comp.acoc_pr_id');
		//$this->db->join('comments', 'comments.id = uploads.id');
		$this->db->where('arct_contract_obs_comp.acoc_delete_status',0);
		$this->db->where('arct_contract_obs_comp.acoc_pr_id',$proj_id);
		$doctype = $this->db->get();
			
		 $data['doctype']=$doctype->result();
		/* echo"<pre>";
		print_r($data);  */
		
		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/viewarccont_observation',$data);
		$this->load->view('wapcos/template/footer'); 
		 
	}
	
	public function viewArcContComp(){
		
		$id = $this->uri->segment(3);
		$obs = $this->db->select('*')->from('arct_contract_obs_comp')->where('acoc_id',$id)->get();
		$result = $obs->result();
		$auth = $result[0]->acoc_auth;
 
		if($auth == 6){
			 
		$arc = $this->db->select('*')->from('arc_observation_type')->get(); 
			 
		$data['observation_type'] = $arc->result_array(); 
			 
		 }
		 else if($auth == 7){
	 
			$contr = $this->db->select('*')->from('observation_type')->get(); 
			$data['observation_type'] = $contr->result_array();  
			 
		 }
		
	//	print_r($result);
		
		
	 	$this->db->select('*');
		$this->db->from('arct_contract_obs_comp');
		$this->db->join('project_details', 'project_details.p_id = arct_contract_obs_comp.acoc_pr_id');
		/* $this->db->join('observation_type', 'observation_type.ob_id = arct_contract_obs_comp.oc_doc_type'); */
		//$this->db->join('comments', 'comments.id = uploads.id');
		$this->db->where('arct_contract_obs_comp.acoc_id',$id);
		$doctype = $this->db->get();
		$data['doctype']=$doctype->result(); 
		
		
		 $this->db->select('*');
		$this->db->from('arc_files');
		$this->db->where('arc_name !=',"");
		$this->db->where('arc_obc_id',$id);
		$files = $this->db->get();
		
		$data['files'] = $files->result(); 
	
	
	
	
		 $this->db->select('*');
		$this->db->from('acob_history');
		$this->db->join('user_table', 'user_table.u_id = acob_history.ach_user_id');
		//$this->db->join('comments', 'comments.id = uploads.id');
		$this->db->where('acob_history.ach_pr_id',$id);
		$this->db->order_by('acob_history.ach_date_time','DESC');
		$history = $this->db->get();
		$data['history']=$history->result(); 
	
	
		 $this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/arc_cont_observation_details',$data);
		$this->load->view('wapcos/template/footer'); 
	
		
	}
	
	
	
	public function manageObservationType(){


		$observation = $this->db->select('*')->from('observation_type')->where('ob_status',1)->get();
		$data['observation'] = $observation->result();



		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/manageobservationtype',$data);
		$this->load->view('wapcos/template/footer'); 




	}
	
	public function editObservationType(){



	//	print_r($_POST);


				$obs_name = $this->input->post('obder_name');
				$obs_id = $this->input->post('obder_id');


			$data = array(
				'ob_name'=>$obs_name,
			
			);

			$this->db->where('ob_id',$obs_id);
			$this->db->update('observation_type',$data);




			$this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Update !</strong> Successfully Updated .
			</div>');
		
	
		
		redirect('Wapcos/manageObservationType');

	}
	
	public function addObservationType(){


		$obs_name = $this->input->post('obder_name');


		$data = array(
			'ob_name'=>$obs_name,
		
		);
	
		$this->db->insert('observation_type',$data);

		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Success ! </strong> Successfully Added observation type.
		</div>');
	
	
	
	redirect('Wapcos/manageObservationType');

	}


	public function deleteObservationType(){


		$obs_id = $this->uri->segment(3);


		$data = array(
			'ob_status'=>0,
		
		);
	
		$this->db->where('ob_id',$obs_id);
			$this->db->update('observation_type',$data);


		$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Success ! </strong>  deleted observation type.
		</div>');
	
	
	
	redirect('Wapcos/manageObservationType');

	}
	public function manageObservationSubType(){



		$observation = $this->db->select('*')->from('observation_type')->where('ob_status',1)->get();
		$data['observation'] = $observation->result();


		$observation = $this->db->select('*')->from('observation_sub_type')->join('observation_type', 'observation_sub_type.obs_master_id = observation_type.ob_id')->where('obs_status',1)->get();
		$data['subobservation'] = $observation->result();	




		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/managesubobservationtype',$data);
		$this->load->view('wapcos/template/footer'); 






	}

	public function addSubObservationType(){


		//print_r($_POST);

				$sub_obs_name = $this->input->post('sub_obs_type');
				$obs_id = $this->input->post('observation');


			$data = array(
				'obs_name'=>$sub_obs_name,
				'obs_master_id'=>$obs_id,
			
			);
		
			$this->db->insert('observation_sub_type',$data);


			$this->session->set_flashdata('message', '<div class="alert alert-success alert-success">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Success ! </strong> successfully Added sub observation type.
			</div>');
		
		
		
		redirect('Wapcos/manageObservationSubType');


	}


	public function editSubObservationType(){


		//print_r($_POST);

		$sub_obs_name = $this->input->post('sub_obs_type');
		$ob_id = $this->input->post('observation');
		$obs_id = $this->input->post('sub_obs_id');

		$data = array(
			'obs_name'=>$sub_obs_name,
			'obs_master_id'=>$ob_id,
		
		);

		$this->db->where('obs_id',$obs_id);
		$this->db->update('observation_sub_type',$data);

		$this->session->set_flashdata('message', '<div class="alert alert-info alert-success">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Success ! </strong> successfully Updated sub observation type.
		</div>');
	
	
	redirect('Wapcos/manageObservationSubType');

	}

	public function selectSubObservationType(){

$is =$_POST['id'];
//echo $is;


$mas_id = $this->db->select('*')->from('observation_sub_type')->where('obs_master_id',$is)->get();


$result = $mas_id->result();

$html = "<option value=''>Select sub observation type</option>";

foreach($result as $abs){


$html .= "<option value='".$abs->obs_id."'>$abs->obs_name</option>";

}

echo $html;

}


public function selectSubObservationTypeInObc(){


		$obs_type_id = $this->input->post("ob_type");



		$obs_id = $this->input->post("obscid");


		$sub_type =	$this->db->select('*')->from('observation_sub_type')->where('obs_master_id',$obs_type_id)->get();

		$res = $sub_type->result();
		
		$html ="";
		foreach($res as $val){




			if($val->obs_id == $obs_id){	

			$html .= "<option selected value='".$val->obs_id."'>$val->obs_name</option>";

			}


		}


		echo $html;

	}

	public function mileStoneReportStatus(){




		$uri=$this->uri->segment(3);
		$mil=$this->uri->segment(4);
		
		
		
			$schedule =	$this->db->select('*')->from('project_details')->where('p_id',$uri)->get();
			$data['schedule'] = $schedule->result();
		
			$mile_stone = $this->db->select('*')->from('mile_stone')->where('ms_s_id',$uri)->where('ms_id',$mil)->order_by('ms_id','ASC')->get();
			$data['mile_stone'] = $mile_stone->result();
		
		/* $activities = $this->db->select('*')->from('activities')->where('act_sc_id',$uri)->get();
		$data['activities'] = $activities->result(); */
		
		
		$this->db->select('*');
		$this->db->from('activities');
		$this->db->join('mile_stone', 'mile_stone.ms_id = activities.act_mi_id');
		$this->db->where('activities.act_sc_id',$uri);
		$this->db->order_by('activities.act_id','ASC');
		$query = $this->db->get();
		
		$data['activities'] = $query->result();
		
		
			$this->db->select('*');
			$this->db->from('task__s');
			$this->db->join('activities', 'activities.act_id = task__s.ts_ac_id');
			$this->db->join('mile_stone', 'mile_stone.ms_id = task__s.ts_mi_id');
			//$this->db->join('mile_stone', 'mile_stone.ms_id = activities.act_mi_id');
			$this->db->where('task__s.ts_pr_id',$uri);
			$this->db->where('task__s.ts_mi_id',$mil);
			$this->db->order_by('task__s.ts_id','ASC');
			$tasks = $this->db->get();
		
			$data['tasks'] = $tasks->result();








/* 
		$proj_id = $this->uri->segment(3);
		$milestone_id = $this->uri->segment(4);



	$rest = $this->db->select('*')->from('task__s')->where('ts_mi_id',$milestone_id)->where('ts_actu_e_date !='," ")->where('ts_actu_e_date !=',"0000-00-00 00:00:00 ")->order_by('ts_actu_e_date',' ASC')->get();
	$data = $rest->result();


	$data['res']= $data;

Echo"<pre>";
	//print_r($data);


	 count($data) -1;



	$actual_start_date =  date('d-m-Y',strtotime($data[0]->ts_start)); 

	$actual_end_date =  date('d-m-Y',strtotime($data[16]->ts_end)); 
	
$start_date =  date('d-m-Y',strtotime($startdate = $data[0]->ts_actu_s_date)); 

	 $end_date =  date('d-m-Y',strtotime($end_date = $data[16]->ts_actu_e_date)); 


	$act_earlier = new DateTime($actual_start_date);
	$act_later = new DateTime($actual_end_date);
	$diff = $act_later->diff($act_earlier)->format("%a");


	$earlier = new DateTime( $start_date);
	$later = new DateTime($end_date);
	
 	$diff = $later->diff($earlier)->format("%a"); */
	  
	// Calculates the difference between DateTime objects 
	//echo $days_between = ceil(abs($start_date - $end_date) / 86400);

//	$this->load->view('wapcos/site/report_delay',$data);
	$this->load->view('wapcos/site/reportdelayd3',$data);
	}
	public function overAllReport(){

		 $uri=$this->uri->segment(3);
		 $mil=$this->uri->segment(4);


		$project =  $this->db->select('*')->from('project_details')->where('p_id',$uri)->get();
		$data['project_details'] = $project->result();

		$milstone =  $this->db->select('*')->from('mile_stone')->where('ms_s_id',$uri)->get();
		$data['milestone_details'] = $milstone->result();

/* 
		$milestone = $this->db->select('*')->from('mile_stone')->where('ms_id',$mil)->get();
		$data['milestone'] = $milestone->result(); */

		$tasks = $this->db->select('*')->from('task__s')->where('ts_pr_id',$uri)->where('ts_actu_e_date != ','0000-00-00 00:00:00')->where('ts_actu_e_date != ',NULL)->get();
		$data['tasks'] = $tasks->result();
		$total_task = $tasks->result();


	


	$this->load->view('wapcos/template/header');
	$this->load->view('wapcos/template/sidebar');
	$this->load->view('wapcos/template/navbar');
	$this->load->view('wapcos/site/overallreports',$data);	
	$this->load->view('wapcos/template/footer'); 


	}


	public function overAllProgress(){

		$uri=$this->uri->segment(3);

		
		$project =  $this->db->select('*')->from('project_details')->where('p_id',$uri)->get();
		$data['project_details'] = $project->result();
		
		
		
		$milestone =  $this->db->select('*')->from('mile_stone')->where('ms_s_id',$uri)->get();
		$data['milestone'] = $milestone->result();

		$tasks = $this->db->select('*')->from('task__s')->where('ts_pr_id',$uri)->where('ts_actu_e_date != ','0000-00-00 00:00:00')->where('ts_actu_e_date != ',NULL)->get();
		$data['tasks'] = $tasks->result();
	/* 	$total_task = $tasks->result();


		echo"<pre>";
		print_r($data); */

		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/overallprogress',$data);
		$this->load->view('wapcos/template/footer'); 

	}

	public function gendrateMileStoneActivity(){

		$uri=$this->uri->segment(3);


	
		$project =  $this->db->select('*')->from('project_details')->where('p_id',$uri)->get();
		$data_project_details = $project->result();

	
		$milestone =  $this->db->select('*')->from('mile_stone')->where('ms_s_id',$uri)->get();
		$data_milestone = $milestone->result();



		foreach($data_milestone as $value){

			$task =  $this->db->select('*')->from('task__s')->where('ts_mi_id',$value->ms_id)->where('ts_actu_e_date != ','0000-00-00 00:00:00')->where('ts_actu_e_date != ',NULL)->get();
                                
			$result = $task->result();
			
			
			 $raj=  sizeof($result)-1;

			 foreach ($result as $key => $value) {
                                      
                                    
				$data =  $this->db->select('*')->from('add_forcasting')->where('af_task_id',$value->ts_id)->get();
				 

				 $forcast = $data->result();
			   //  print_r($forcast);

				 $actual_start_date =  date('d-m-Y',strtotime($value->ts_actu_s_date)); 

				 $actual_end_date =  date('d-m-Y',strtotime($value->ts_actu_e_date)); 
				 $act_earlier = new DateTime($actual_start_date);
				 $act_later = new DateTime($actual_end_date);
				  (int)$diff = $act_later->diff($act_earlier)->format("%a");
				$value_total = $value->ts_days - $diff;



			 }
			
		}

	/* 	$this->pdf->loadHtml($result);
		$this->pdf->render();
		$this->pdf->stream("".$customer_id.".pdf", array("Attachment"=>0)); */

	}
	public function overALLStatus(){

	   $uri=$this->uri->segment(3);
	//	$mil=$this->uri->segment(4);


	   $project =  $this->db->select('*')->from('project_details')->where('p_id',$uri)->get();
	   $data['schedule'] = $project->result();

	   $milestone = $this->db->select('*')->from('mile_stone')->where('ms_s_id',$uri)->get();
	   $data['milestone'] = $milestone->result(); 

	   $tasks = $this->db->select('*')->from('task__s')->where('ts_pr_id',$uri)->where('ts_actu_e_date != ','0000-00-00 00:00:00')->where('ts_actu_e_date != ',NULL)->get();
	   $data['tasks'] = $tasks->result();
 	   $size = sizeof($data['tasks'])-1;

	//echo"<pre>";
	//	print_r($data['tasks']);
		if($size > 0){
		$Start_task =  date('Y-m-d',strtotime($data['tasks'][0]->ts_start));
		 $planned_end = $data['tasks'][$size]->ts_end;
		 $actuval_end = $data['tasks'][$size]->ts_actu_e_date;
		
		if($planned_end == $actuval_end){
			
			$data['Expected_end'] =  $data['schedule'][0]->p_end_date;
			
			
		}else if($planned_end < $actuval_end){
			
			
			$planned_end_task =  date('Y-m-d',strtotime($planned_end));
			$actual_end_task =  date('Y-m-d',strtotime($actuval_end));

			//$s_date =  strtotime($Start_task);
			$p_e_date =  strtotime($planned_end_task);
			$a_e_date =  strtotime($actual_end_task);


		 	$s_date =  strtotime($Start_task);
		//	$your_date = strtotime("2010-01-31"); 
			$datediff_palnned =  $p_e_date - $s_date ;
			$datediff_actual =  $a_e_date - $s_date ;

			(int)$planned_da =  round($datediff_palnned / (60 * 60 * 24));
			(int)$actuval_da =  round($datediff_actual / (60 * 60 * 24));
			 $diffrencr = $actuval_da - $planned_da;
		 	$data['Expected_end'] = date('Y-m-d H:i:s', strtotime($data['schedule'][0]->p_end_date . "+".$diffrencr.' day'));			

		}else{
			
			
			
			$planned_end_task =  date('Y-m-d',strtotime($planned_end));
			$actual_end_task =  date('Y-m-d',strtotime($actuval_end));

			//$s_date =  strtotime($Start_task);
			$p_e_date =  strtotime($planned_end_task);
			$a_e_date =  strtotime($actual_end_task);


		 	$s_date =  strtotime($Start_task);
		//	$your_date = strtotime("2010-01-31"); 
			$datediff_palnned =  $p_e_date - $s_date ;
			$datediff_actual =  $a_e_date - $s_date ;

			(int)$planned_da =  round($datediff_palnned / (60 * 60 * 24));
			(int)$actuval_da =  round($datediff_actual / (60 * 60 * 24));
			 $diffrencr = $actuval_da - $planned_da;
		 	$data['Expected_end'] = date('Y-m-d H:i:s', strtotime($data['schedule'][0]->p_end_date . "-".$diffrencr.' day'));			
		}
		}else{
			$data['Expected_end'] = $data['schedule'][0]->p_end_date;
		}
			
		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/overallstatus',$data);
		$this->load->view('wapcos/template/footer');  


	}
	public function externalDelays(){

		 $this->db->select('*')
		->from('external_delays')
		->join('project_details', 'external_delays.de_pr_id = project_details.p_id');
		$delay_resons =$this->db->get();
		$data['externaldelays']=$delay_resons->result();


		$projects = $this->db->select('*')->from('project_details')->get();
		$data['projects']=$projects->result();


		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/externaldelays',$data);
		$this->load->view('wapcos/template/footer');

		
	}
	public function addDelayReson(){

	$proj_id = $this->input->post('auth');
	$sdate = $this->input->post('s_date');
	$edate = $this->input->post('e_date');
	$delreason = $this->input->post('del_reson');



	$now = strtotime($edate); // or your date as well
	$your_date = strtotime($sdate);
	$datediff = $now - $your_date;

	$total_days =  round($datediff / (60 * 60 * 24));



 //print_r($_POST);
	$data = array(

	'de_pr_id'=>$proj_id,
	'de_start_date'=>$sdate,
	'de_end_date'=>$edate,
	'de_total_number_of_days'=>$total_days,
	'de_resons'=>$delreason,

	);

	$this->db->insert('external_delays',$data);
	$this->session->set_flashdata('message', '<div class="alert alert-success alert-info">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Success ! </strong> Inserted  Successfully.
	</div>');



redirect('Wapcos/externalDelays'); 

	}


	public function editDelayReson(){

		$uri=$this->uri->segment(3);

		$this->db->select('*')
		->from('external_delays')
		->join('project_details', 'external_delays.de_pr_id = project_details.p_id')
		->where('de_id',$uri);
		$delay_resons =$this->db->get();
		$data['externaldelays']=$delay_resons->result();


		$projects = $this->db->select('*')->from('project_details')->get();
		$data['projects']=$projects->result();


		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/editexternaldelays',$data);
		$this->load->view('wapcos/template/footer');


	}
	public function updateDelayReson(){


		$id = $this->input->post('delay_id');
		$proj_id = $this->input->post('auth');
		$sdate = $this->input->post('s_date');
		$edate = $this->input->post('e_date');
		$delreason = $this->input->post('del_reson');
	
		$now = strtotime($edate); // or your date as well
		$your_date = strtotime($sdate);
		$datediff = $now - $your_date;
	
		$total_days =  round($datediff / (60 * 60 * 24));
	
	 //print_r($_POST);
		$data = array(
	
		'de_pr_id'=>$proj_id,
		'de_start_date'=>$sdate,
		'de_end_date'=>$edate,
		'de_total_number_of_days'=>$total_days,
		'de_resons'=>$delreason,
	
		);
		
		$this->db->where('de_id',$id);
		$this->db->update('external_delays',$data); 
		
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-success">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Success ! </strong> Updated  Successfully.
		</div>');
	
	
	
	redirect('Wapcos/externalDelays');
	
	}
	public function deleteDelayReson(){
		$uri=$this->uri->segment(3);


		$this->db->where('de_id',$uri);
		$this->db->delete('external_delays');

		$this->session->set_flashdata('message', '<div class="alert alert-danger alert-success">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Delete ! </strong> Deleted  Successfully.
		</div>');
	
	
	
	redirect('Wapcos/externalDelays');


	}
	public function emailTest(){
		/* $this->load->config('email');
		$this->load->library('email'); */

		$this->email->set_newline("\r\n");
		$this->email->from('admin@iitmanagement.co.in');
		$this->email->to('yuvaraj@istudiotech.com');
		$this->email->subject('Demo');
		$this->email->message('test ');
	//	$this->email->send();
		if($this->email->send()){

			echo"successfully send";
			
			}else{
				echo $this->email->print_debugger();
				echo"failed";
			
		}
	}
	public function deleteForcast(){


		$id = $this->input->post('id');


		$this->db->where('af_id', $id);
		$this->db->delete('add_forcasting');

		$this->db->where('ad_f_id', $id);
		$this->db->delete('add_forcasting_dependancy');

	}

	public function viewUpdateForcasting(){

	$id = 	$this->uri->segment(3);


	$this->db->select('*');
	$this->db->from('add_forcasting');
	//$this->db->->where('af_sed_id',$pr_id)

	$this->db->join('mile_stone', 'mile_stone.ms_id = add_forcasting.af_milstone_id');
	$this->db->join('activities', 'activities.act_id = add_forcasting.af_act_id');
	$this->db->join('task__s', 'task__s.ts_id = add_forcasting.af_task_id');
	$this->db->join('forcasting_work', 'forcasting_work.fsw_id = add_forcasting.af_workid');
	$this->db->where('add_forcasting.af_id',$id);

	$project  = $this->db->get();
		
	$data['forcast'] = $project->result();

$iid = $this->db->select('*')
->from('add_forcasting_dependancy')
->join('forcasting', 'forcasting.fs_id = add_forcasting_dependancy.forcastinfo_id')

->where('ad_f_id',$id)
->get();


$data['add_fc'] = $iid->result();

$this->db->select('*');
$this->db->from('actual_forcasting_progress');
//$this->db->->where('af_sed_id',$pr_id)

$this->db->join('forcasting', 'forcasting.fs_id = actual_forcasting_progress.ac_forc_mast_info');
/* $this->db->join('activities', 'activities.act_id = add_forcasting.af_act_id');
$this->db->join('task__s', 'task__s.ts_id = add_forcasting.af_task_id');
$this->db->join('forcasting_work', 'forcasting_work.fsw_id = add_forcasting.af_workid'); */
$this->db->where('actual_forcasting_progress.ac_forc_id',$id);

$actual_forcasting_progress  = $this->db->get();
	
$data['actual_forcasting_progress'] = $actual_forcasting_progress->result();

		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/forcastviewupdate',$data);
		$this->load->view('wapcos/template/footer');





/* 
echo"<pre>";
print_r($data);
 */





	}
	public function actualFcReport(){


	$forcast_id = $this->input->post('forc_id');
	$forcast_dependancy_id = $this->input->post('for_dep_id');
	$forcast_info_id = $this->input->post('master_info_id');
	$forcast_unit_type = $this->input->post('unit_type');
	$forcast_date = $this->input->post('date');
	$forcast_unit = $this->input->post('unit');
	//$forcast_unit = $this->input->post('unit');

	$data = array(

		'ac_forc_id'=>$forcast_id,
		'ac_add_for_dep_id'=>$forcast_dependancy_id,
		'ac_forc_mast_info'=>$forcast_info_id,
		'ac_date'=>$forcast_date,
		'ac_unit_model'=>$forcast_unit_type,
		'ac_value'=>$forcast_unit,
	);


	$this->db->insert('actual_forcasting_progress',$data);


	$this->session->set_flashdata('message', '<div class="alert alert-success alert-success">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Inserted  ! </strong> Inserted  Successfully.
	</div>');



redirect('Wapcos/viewUpdateForcasting/'.$forcast_id);


	}

	public function deleteActForcastData(){


		$id = $this->input->post('id');

		$this->db->where('ac_f_P_id',$id);
		$this->db->delete('actual_forcasting_progress');




	}

	public function plannedVsActual(){




		$uri=$this->uri->segment(3);
		//	$mil=$this->uri->segment(4);
		$this->db->select('*');
		$this->db->from('add_forcasting');
		//$this->db->->where('af_sed_id',$pr_id)
	
		$this->db->join('mile_stone', 'mile_stone.ms_id = add_forcasting.af_milstone_id');
		$this->db->join('activities', 'activities.act_id = add_forcasting.af_act_id');
		$this->db->join('task__s', 'task__s.ts_id = add_forcasting.af_task_id');
		$this->db->join('forcasting_work', 'forcasting_work.fsw_id = add_forcasting.af_workid');
		$this->db->where('add_forcasting.af_sed_id',$uri);
	
		$project  = $this->db->get();
		$data['project_id'] = $uri;	
		$data['forcast'] = $project->result();
		  
				
			$this->load->view('wapcos/template/header');
			$this->load->view('wapcos/template/sidebar');
			$this->load->view('wapcos/template/navbar');
			$this->load->view('wapcos/site/plannedvsactual',$data);
			$this->load->view('wapcos/template/footer');  

	}

	public function manageBill(){
		$prid = $this->uri->segment(3);
		$milid = $this->uri->segment(4);

			$user = 	$this->db->select('*')->from('mile_stone')->join('project_details','project_details.p_id = mile_stone.ms_s_id')->where('ms_id',$milid)->get();
			$data['details']=$user->result();
	


		$bill = $this->db->select('*')->from('bill_id')->where('bl_pr_id',$prid)->where('bl_ml_id',$milid)->get();
		$data['bills_detail'] = $bill->result();

		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/managebills',$data);
		$this->load->view('wapcos/template/footer');  




	}
	public function addBills(){



	//	print_r($_POST);

		$Projetid = $this->input->post('projid');
		$milstone = $this->input->post('milstoneid');
		$details = $this->input->post('details');
		$amount = $this->input->post('amount');
		$Submited_date = $this->input->post('sub_date');
		$paid_date = $this->input->post('pd_date');
		$status = $this->input->post('status');



		$data =array(
			'bl_pr_id'=>$Projetid,
			'bl_ml_id'=>$milstone,
			'bl_details'=>$details,
			'bl_amount'=>$amount,
			'bl_submission_date'=>$Submited_date,
			'bl_paid_date'=>$paid_date,
			'bl_status'=>$status,
		);

		$this->db->insert('bill_id',$data);

		$this->session->set_flashdata('message', '<div class="alert alert-success alert-success">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Inserted  ! </strong> Inserted  Successfully.
		</div>');



		redirect('Wapcos/manageBill/'.$Projetid.'/'.$milstone);


	}

	public function updateBill(){
$b_id = $this->uri->segment(3);
$proj_id = $this->uri->segment(4);
$mil_id = $this->uri->segment(5);

$rest = $this->db->select('*')->from('bill_id')->where('bill_id',$b_id)->get();
$data['result'] = $rest->result();



		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/editbill',$data);
		$this->load->view('wapcos/template/footer');  


	}

	public function editBills(){

		$Billid = $this->input->post('bill_id');
		$Projetid = $this->input->post('projid');
		$milstone = $this->input->post('milstoneid');
		$details = $this->input->post('details');
		$amount = $this->input->post('amount');
		$Submited_date = $this->input->post('sub_date');
		$paid_date = $this->input->post('pd_date');
		$status = $this->input->post('status');



		$data =array(
			'bl_pr_id'=>$Projetid,
			'bl_ml_id'=>$milstone,
			'bl_details'=>$details,
			'bl_amount'=>$amount,
			'bl_submission_date'=>$Submited_date,
			'bl_paid_date'=>$paid_date,
			'bl_status'=>$status,
		);



		$this->db->where('bill_id',$Billid)->update('bill_id',$data);

		$this->session->set_flashdata('message', '<div class="alert alert-success alert-success">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Inserted  ! </strong> Updated Successfully.
				</div>');
		redirect('Wapcos/manageBill/'.$Projetid.'/'.$milstone);

	}
	public function galary(){





		$this->load->view('wapcos/template/header');
		$this->load->view('wapcos/template/sidebar');
		$this->load->view('wapcos/template/navbar');
		$this->load->view('wapcos/site/gallery');
		$this->load->view('wapcos/template/footer');  


	}

	public function imageGallery(){

		$id = $this->uri->segment(3);
		$g_all_id = array();
		$gall = $this->db->select('*')->from('uploads')->where('up_doc_type','Photographs')->where('up_status',1)->where('up_project_id',$id)->get();

				$data_gall = $gall->result();
				$data['gall'] = $gall->result();
	//	print_r($data_gall);		
				
				
 if($data_gall){
		foreach ($data_gall as $key => $value) {
			array_push($g_all_id,$value->up_id);
		}
		$gallery = $this->db->select('*')->from('upload_files')->where('upf_name != ""')->where_in('upf_up_id',$g_all_id)->get();
		$data['all_gall'] = $gallery->result();
	}else{

		$data['all_gall'] = null;


	} 
	

	

	//print_r($all_gall);




	$this->load->view('wapcos/template/header');
	$this->load->view('wapcos/template/sidebar');
	$this->load->view('wapcos/template/navbar');
	$this->load->view('wapcos/site/gallery_view',$data);
	$this->load->view('wapcos/template/footer');  



	}
	public function logOut(){


        $user_data = $this->session->all_userdata();
       /*  foreach ($user_data as $key => $value) {
            if ($key != 'username' && $key != 'email' && $key != 'mobile' && $key != 'user_auth') {
                $this->session->unset_userdata($key);
            }
        } */
    $this->session->sess_destroy();
    redirect('Admin');



	}
	public function timeNow(){


echo"date :".date('d-m-Y H:i:s');


	}
} 