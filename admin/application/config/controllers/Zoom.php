<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once (APPPATH.'libraries/php-jwt-master/src/BeforeValidException.php');
require_once (APPPATH.'libraries/php-jwt-master/src/ExpiredException.php');
require_once (APPPATH.'libraries/php-jwt-master/src/SignatureInvalidException.php');
require_once (APPPATH.'libraries/php-jwt-master/src/JWT.php');

use \Firebase\JWT\JWT;

class Zoom extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
	 public function __construct()
        {
                parent::__construct();
                // Your own constructor code
				
				$this->load->database();
				$this->load->library('session');
				$this->load->helper(array('form', 'url'));
                $this->load->library('form_validation');
        }
		
	public function rules_zoom(){
		 $config = array(
        array(
                'field' => 'start_date',
                'label' => 'Start Date',
                'rules' => 'required',
				'errors' => array(
                        'required' => 'You must provide a %s.',
						),
        ),
		array(
                'field' => 'start_time',
                'label' => 'Start Time',
                'rules' => 'required',
				'errors' => array(
                        'required' => 'You must provide a %s.',
						),
        ),
		array(
                'field' => 'title',
                'label' => 'Title',
                'rules' => 'required',
				'errors' => array(
                        'required' => 'You must provide a %s.',
						),
        ),
		array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required',
				'errors' => array(
                        'required' => 'You must provide a %s.',
						),
        ),
		array(
                'field' => 'duration',
                'label' => 'Duration',
                'rules' => 'required',
				'errors' => array(
                        'required' => 'You must provide a %s.',
						),
        )
       );
     return $config;
	}	
		
	
	private $zoom_api_key = 'a6fg1LFzRzu2kgPjOgulpg';
	private $zoom_api_secret = 'yXZQlLPOCTmYFjwspaQbWDVkSNbjP1usthQj';
	
	public function index()
	{
		$user=$this->session->userdata('user');
		$user_id=$user['user_id'];
		$usr=$this->db->where('ad_id',$user_id)->get('admin')->row();
		
	$data1['get_links']=$this->db->where('alc_by',$user_id)->get('zoom')->result();	
		$data1['response'] = '';
		$rules=$this->rules_zoom();
		$this->form_validation->set_rules($rules);
		
		if(isset($_POST['submit']))
		{
			if ($this->form_validation->run() == FALSE)
                {
					$data['form_err']=$this->session->set_flashdata('form_err','Enter Details correctly','success');
				}
				else{
	$data_in['start_date']=$start_date=date("Y-m-d", strtotime($this->input->post('start_date')));	
	$data_in['start_time']=$start_time=date("H:i:s", strtotime($this->input->post('start_time')));	
	$data_in['title']=$title=$this->input->post('title');	
	$data_in['duration']=$duration=$this->input->post('duration');	
	$data_in['password']=$password=$this->input->post('password');	
	$data_in['alc_by']=$user_id;	
	$data_in['created_at']=$add_date=date("Y-m-d h:i:s");	
    $insert=$this->db->insert('zoom',$data_in);	
	$insert_id=$this->db->insert_id();
		$data = array();
$data['topic'] 		= $title;
//$data['start_date'] = date("Y-m-d h:i:s", strtotime('tomorrow'));
$data['start_date'] = $start_date.' '.$start_time;
$data['duration'] 	= $duration;
$data['type'] 		= 2;
$data['password'] 	= $password;

try {
	$data1['response'] = $response = $this->createMeeting($data);
	$data_li['meeting_id']=$response->id;	
	$data_li['link']=$response->join_url;	
	$this->db->where('id',$insert_id);
	$update=$this->db->update('zoom',$data_li);	
	if($data1['response']){
			$data['mesg']=$this->session->set_flashdata('success','Added Successfully');
			redirect('zoom/index','refresh');
			}
	
} catch (Exception $ex) {
    echo $ex;
}
				}
		}
		if($usr->ad_auth==2){
		$this->load->view('template/selffinance/header');
        $this->load->view('template/selffinance/menubar');
        $this->load->view('template/selffinance/headerbar');
        $this->load->view('selffinance/zoom',$data1);
        $this->load->view('template/selffinance/footer');
		}
		if($usr->ad_auth==4){
		$this->load->view('template/pgmswaided/header');
        $this->load->view('template/pgmswaided/menubar');
        $this->load->view('template/pgmswaided/headerbar');
        $this->load->view('pgmswaided/zoom',$data1);
        $this->load->view('template/pgmswaided/footer');
		}
		if($usr->ad_auth==5){
		$this->load->view('template/pgmswselffin/header');
        $this->load->view('template/pgmswselffin/menubar');
        $this->load->view('template/pgmswselffin/headerbar');
        $this->load->view('pgmswselffin/zoom',$data1);
        $this->load->view('template/pgmswselffin/footer');
		}
		
	}	
	public function zoom_edit()
	{
	$id=$this->uri->segment('3');
	$data1['single_link']=$this->db->where('id',$id)->get('zoom')->row();	
		$data1['response'] = '';
		$user=$this->session->userdata('user');
		$user_id=$user['user_id'];
		$usr=$this->db->where('ad_id',$user_id)->get('admin')->row();
		
		$rules=$this->rules_zoom();
		$this->form_validation->set_rules($rules);
		
		if(isset($_POST['submit']))
		{
			if ($this->form_validation->run() == FALSE)
                {
					$data['form_err']=$this->session->set_flashdata('form_err','Enter Details correctly','success');
				}
				else{
	$data_up['start_date']=$start_date=date("Y-m-d", strtotime($this->input->post('start_date')));	
	$data_up['start_time']=$start_time=date("H:i:s", strtotime($this->input->post('start_time')));	
	$data_up['title']=$title=$this->input->post('title');	
	$data_up['duration']=$duration=$this->input->post('duration');	
	$data_up['password']=$password=$this->input->post('password');	
	
	$this->db->where('id',$id);
    $update=$this->db->update('zoom',$data_up);	
	
		$data = array();
$data['topic'] 		= $title;
//$data['start_date'] = date("Y-m-d h:i:s", strtotime('tomorrow'));
$data['start_date'] = $start_date.' '.$start_time;
$data['duration'] 	= $duration;
$data['type'] 		= 2;
$data['password'] 	= $password;

try {
	$response = $this->createMeeting($data);
	$data_li['meeting_id']=$response->id;	
	$data_li['link']=$response->join_url;	
	$this->db->where('id',$id);
	$update1=$this->db->update('zoom',$data_li);	
	if($update1){
			$data['mesg']=$this->session->set_flashdata('success','Edited Successfully');
			redirect('zoom/index','refresh');
			}
	
} catch (Exception $ex) {
    echo $ex;
}
				}
		}
		if($usr->ad_auth==2){
		$this->load->view('template/selffinance/header');
        $this->load->view('template/selffinance/menubar');
        $this->load->view('template/selffinance/headerbar');
        $this->load->view('selffinance/zoom_edit',$data1);
        $this->load->view('template/selffinance/footer');
		}
		if($usr->ad_auth==4){
		$this->load->view('template/pgmswaided/header');
        $this->load->view('template/pgmswaided/menubar');
        $this->load->view('template/pgmswaided/headerbar');
        $this->load->view('pgmswaided/zoom_edit',$data1);
        $this->load->view('template/pgmswaided/footer');
		}
		if($usr->ad_auth==5){
		$this->load->view('template/pgmswselffin/header');
        $this->load->view('template/pgmswselffin/menubar');
        $this->load->view('template/pgmswselffin/headerbar');
        $this->load->view('pgmswselffin/zoom_edit',$data1);
        $this->load->view('template/pgmswselffin/footer');
		}
	}
	public function zoom_users()
	{
	$data1['get_links']=$this->db->get('zoom')->result();
		$data['srch'] = array('link_id'=>'','stu_id'=>'');
		if(isset($_GET['submit'])){	
		$user=$this->session->userdata('user');
		$user_id=$user['user_id'];
		//$stu_id=$this->input->post('stu_id');
		
		 if ( isset( $_GET ) ) {
            $search = $_GET;
        } else {
            $search = '';
        }



			$zoom=$this->db->query('select * from zoom_alloc where student_id="'.$search['stu_id'].'" ')->row();
			$zoom_id=$this->db->query('select * from zoom where id="'.$zoom->link_id.'" ');
		
		$data['stu_list']=$zoom_id->result();
		$data['srch'] = $_REQUEST;
		}
		
		//$this->load->view('frontend/admin1/header');
		$this->load->view('zoom/zoom_users',$data);
		//$this->load->view('frontend/admin1/footer');
		
	}
	public function delete_zoom()
	{
		if($this->input->post('type')==2)
		{
			$id=$this->input->post('id');
			$this->db->where('id',$id)->delete('zoom');	
			$this->db->where('link_id',$id)->delete('zoom_alloc');	
			//echo json_encode(array(
				//"statusCode"=>200
			//));
			echo "Deleted Successfully";
		} 
	}
	
	//function to generate JWT
	private function generateJWTKey() {
		$key = $this->zoom_api_key;
		$secret = $this->zoom_api_secret;
		$token = array(
			"iss" => $key,
			"exp" => time() + 3600 //60 seconds as suggested
		);
		return JWT::encode( $token, $secret );
	}	
	
	//function to create meeting
    	public function createMeeting($data = array())
    	{
		$post_time  = $data['start_date'];
		$start_time = gmdate("Y-m-d\TH:i:s", strtotime($post_time));

		$createMeetingArray = array();
		if (!empty($data['alternative_host_ids'])) {
		    if (count($data['alternative_host_ids']) > 1) {
			$alternative_host_ids = implode(",", $data['alternative_host_ids']);
		    } else {
			$alternative_host_ids = $data['alternative_host_ids'][0];
		    }
		}


		$createMeetingArray['topic']      = $data['topic'];
		$createMeetingArray['agenda']     = !empty($data['agenda']) ? $data['agenda'] : "";
		$createMeetingArray['type']       = !empty($data['type']) ? $data['type'] : 2; //Scheduled
		$createMeetingArray['start_time'] = $start_time;
		$createMeetingArray['timezone']   = 'Asia/Kolkata';
		$createMeetingArray['password']   = !empty($data['password']) ? $data['password'] : "";
		$createMeetingArray['duration']   = !empty($data['duration']) ? $data['duration'] : 60;

		$createMeetingArray['settings']   = array(
            		'join_before_host'  => !empty($data['join_before_host']) ? true : false,
            		'host_video'        => !empty($data['option_host_video']) ? true : false,
            		'participant_video' => !empty($data['option_participants_video']) ? true : false,
            		'mute_upon_entry'   => !empty($data['option_mute_participants']) ? true : false,
            		'enforce_login'     => !empty($data['option_enforce_login']) ? true : false,
            		'auto_recording'    => !empty($data['option_auto_recording']) ? $data['option_auto_recording'] : "none",
            		'alternative_hosts' => isset($alternative_host_ids) ? $alternative_host_ids : ""
        	);

		return $this->sendRequest($createMeetingArray);
	}	
	
	//function to send request
    	protected function sendRequest($data)
    	{
		$user=$this->session->userdata('user');
		$user_id=$user['user_id'];
		$user_dep=$user['user_dep_status'];
		$usr=$this->db->where('ad_id',$user_id)->get('admin')->row();
		//Enter_Your_Email
		if($usr->ad_auth==2 && $usr->ad_status==5){
		$request_url = "https://api.zoom.us/v2/users/mahrm@mssw.in/meetings";	
		}
		if($usr->ad_auth==2 && $usr->ad_status==6){
		$request_url = "https://api.zoom.us/v2/users/mahrod@mssw.in/meetings";	
		}
		if($usr->ad_auth==2 && $usr->ad_status==7){
		$request_url = "https://api.zoom.us/v2/users/mase@mssw.in/meetings";	
		}
		if($usr->ad_auth==2 && $usr->ad_status==8){
		$request_url = "https://api.zoom.us/v2/users/madm@mssw.in/meetings";	
		}
		if($usr->ad_auth==2 && $usr->ad_status==9){
		$request_url = "https://api.zoom.us/v2/users/msccp@mssw.in/meetings";	
		}
		if($usr->ad_auth==2 && $usr->ad_status==15){
		$request_url = "https://api.zoom.us/v2/users/msswzoom@mssw.in/meetings";	
		}
		if($usr->ad_auth==4 && $usr->ad_status==1){
		$request_url = "https://api.zoom.us/v2/users/mswacd@mssw.in/meetings";
		}
        if($usr->ad_auth==4 && $usr->ad_status==2){
		$request_url = "https://api.zoom.us/v2/users/mswamp@mssw.in/meetings";
		}		
        if($usr->ad_auth==4 && $usr->ad_status==3){
		     $request_url = "https://api.zoom.us/v2/users/mswahrm@mssw.in/meetings";
		}
		if($usr->ad_auth==5 && $usr->ad_status==1){
		$request_url = "https://api.zoom.us/v2/users/mswsfcd@mssw.in/meetings";
		}
        if($usr->ad_auth==5 && $usr->ad_status==2){
		$request_url = "https://api.zoom.us/v2/users/mswsfmp@mssw.in/meetings";
		}		
        if($usr->ad_auth==5 && $usr->ad_status==3){
		$request_url = "https://api.zoom.us/v2/users/mswsfhrm@mssw.in/meetings";
		}	
		//$request_url = "https://api.zoom.us/v2/users/msswzoom@mssw.in/meetings";
		
		$headers = array(
			"authorization: Bearer ".$this->generateJWTKey(),
			"content-type: application/json",
			"Accept: application/json",
		);
		
		$postFields = json_encode($data);
		
        	$ch = curl_init();
        	curl_setopt_array($ch, array(
            	CURLOPT_URL => $request_url,
	    	CURLOPT_RETURNTRANSFER => true,
	    	CURLOPT_ENCODING => "",
	    	CURLOPT_MAXREDIRS => 10,
	    	CURLOPT_TIMEOUT => 30,
	    	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	    	CURLOPT_CUSTOMREQUEST => "POST",
	    	CURLOPT_POSTFIELDS => $postFields,
	    	CURLOPT_HTTPHEADER => $headers,
        	));

        	$response = curl_exec($ch);
        	$err = curl_error($ch);
        	curl_close($ch);
        	if (!$response) {
            		return $err;
		}
        	return json_decode($response);
	}
	
}
