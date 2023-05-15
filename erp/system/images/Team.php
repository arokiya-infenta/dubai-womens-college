<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Team extends CI_Controller {

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
				$this->load->model('team_model');
				$this->load->model('principal_model');
				$this->load->database();
				$this->load->library('session');
				$this->load->helper(array('form', 'url'));
                $this->load->library('form_validation');
				
				if($this->session->userdata('usertype')!='admin_teacher')
		        {
		        redirect('login');
		        }
        }
		
	public function index()
	{
		$this->load->view('test_message');
		
	}
	public function rules_sub(){
		 $config = array(
        array(
                'field' => 'name',
                'label' => 'Subject Name',
                'rules' => 'required'
        ),
		array(
                'field' => 'school',
                'label' => 'Subject Name',
                'rules' => 'required'
        )
       );
     return $config;
	}	
	public function rules_sub_edit(){
		 $config = array(
        array(
                'field' => 'name_edit',
                'label' => 'Subject Name',
                'rules' => 'required'
        ),
		array(
                'field' => 'school_edit',
                'label' => 'School Name',
                'rules' => 'required'
        )
       );
     return $config;
	}	
	public function rules_ques(){
		 $config = array(
        array(
                'field' => 'title',
                'label' => 'Title',
                'rules' => 'required'
        ),
		array(
                'field' => 'subject',
                'label' => 'Subject Name',
                'rules' => 'required'
        ),
		array(
                'field' => 'school',
                'label' => 'School Name',
                'rules' => 'required'
        ),
		array(
                'field' => 'unit',
                'label' => 'Unit',
                'rules' => 'required'
        ),
		array(
                'field' => 'concept',
                'label' => 'Concept',
                'rules' => 'required'
        )
       );
     return $config;
	}
	public function rules_ticket(){
		 $config = array(
		array(
                'field' => 'subject',
                'label' => 'Subject',
				'rules' => 'required'
        ),
		array(
                'field' => 'email',
                'label' => 'Email',
				'rules' => 'required'
        ),
		array(
                'field' => 'category',
                'label' => 'Category',
				'rules' => 'required'
        ),
		array(
                'field' => 'priority',
                'label' => 'Priority',
				'rules' => 'required'
        ),
		array(
                'field' => 'issues',
                'label' => 'Issue',
				'rules' => 'required'
        )
);
     return $config;
	}
	public function rules_tut(){
		 $config = array(
		array(
                'field' => 'title',
                'label' => 'Title',
				'rules' => 'required'
        ),
		/*array(
                'field' => 'link[]',
                'label' => 'Link',
				'rules' => 'required'
        ),*/
		array(
                'field' => 'standard',
                'label' => 'Standard',
				'rules' => 'required|is_unique[admin_video.standard]',
				'errors' => array(
				      'required' => 'You must provide a %s.',
				      'is_unique' => 'This %s already exists.',
				),
        )
);
     return $config;
	}
	public function rules_tut_edit(){
		 $config = array(
		array(
                'field' => 'title',
                'label' => 'Title',
				'rules' => 'required'
        )
		/*array(
                'field' => 'link[]',
                'label' => 'Link',
				'rules' => 'required'
        )*/
);
     return $config;
	}
	
	public function message()
	{
		if($_POST){
			$name1=$this->input->post('test1');
			$name2=$this->input->post('test2');
			 $name3 = $name1+$name2;
			 $data['name4']=$name3;
		$this->load->view('test_message1',$data);
			 
		}
	}
	
	public function edymi()
	{
		$this->load->helper('url');
		$this->load->view('indext');
	}
	
	public function signin()
	{
		$this->load->helper('url');
		$this->load->view('signin');
	}
	
	public function team_dashboard()
	{
		$this->load->helper('url');
		$this->load->view('frontend/team/header');
		$this->load->view('team/team_dashboard');
		$this->load->view('frontend/team/footer');
	}
	
	public function header_admin()
	{
		$this->load->helper('url');
		$this->load->view('frontend/team/header');
	}
	
	public function footer_admin()
	{
		$this->load->helper('url');
		$this->load->view('frontend/team/header');
		$this->load->view('frontend/team/footer');
	}
	public function questions()
	{
		$userid=$this->session->userdata('userid');
		$data['std_list']=$this->team_model->list_user_standard($userid);
		if(isset($_POST['submit_edit']))
		{
			$standard=$this->input->post('standard');
			$subject=$this->input->post('subject');
		$data['question_list']=$this->team_model->list_question($subject,$standard);
		}
		$this->load->view('frontend/team/header');
		$this->load->view('team/questions',$data);
		$this->load->view('frontend/team/footer');
	}
	public function add_question()
	{
		$data['stand']=$this->uri->segment('4');
		$data['subject']=$this->uri->segment('3');
		$data['school_list']=$this->team_model->list_school();
		
		$userid=$this->session->userdata('userid');
		$data['std_list']=$this->team_model->list_user_standard($userid);
		$rules=$this->rules_ques();
		$this->form_validation->set_rules($rules);
		
		if(isset($_POST['submit']))
		{
			if ($this->form_validation->run() == FALSE)
                {
					$data['form_err']=$this->session->set_flashdata('form_err','Enter Details correctly','success');
		            $data['std_list']=$this->team_model->list_user_standard($userid);
				}
				else{
			$insert=$this->team_model->add_question();
			if($insert){
			$data['mesg']=$this->session->set_flashdata('success','Added Successfully');
			redirect('team/add_question','refresh');
			}
				}
		}
		$this->load->view('frontend/team/header');
		$this->load->view('team/add_question',$data);
		$this->load->view('frontend/team/footer');
	}
	public function edit_question()
	{
		$id=$this->uri->segment('3');
		$data['school_list']=$this->team_model->list_school();
		
		$userid=$this->session->userdata('userid');
		$data['std_list']=$this->team_model->list_user_standard($userid);
		$data['question_single']=$this->team_model->list_single_question($id);
		$rules=$this->rules_ques();
		$this->form_validation->set_rules($rules);
		
		if(isset($_POST['submit']))
		{
			if ($this->form_validation->run() == FALSE)
                {
					$data['form_err']=$this->session->set_flashdata('form_err','Enter Details correctly','success');
		            $data['std_list']=$this->team_model->list_user_standard($userid);
				}
				else{
			$insert=$this->team_model->question_edit();
			if($insert){
			$data['mesg']=$this->session->set_flashdata('success','Edited Successfully');
			redirect('team/questions','refresh');
			}
				}
		}
		$this->load->view('frontend/team/header');
		$this->load->view('team/edit_question',$data);
		$this->load->view('frontend/team/footer');
	}
	public function view_question()
	{
		$id=$this->uri->segment('3');
		$data['question_view']=$this->team_model->list_single_question($id);
		$this->load->view('frontend/team/header');
		$this->load->view('team/view_question',$data);
		$this->load->view('frontend/team/footer');
	}
	public function delete_question()
	{
		if($this->input->post('type')==2)
		{
			$id=$this->input->post('id');
			$this->team_model->delete_question($id);	
			//echo json_encode(array(
				//"statusCode"=>200
			//));
			echo "Deleted Successfully";
		} 
	}
	public function subject_get()
	{
		$std=$this->input->post('std');
		$userid=$this->session->userdata('userid');
		$get_sub=$this->team_model->list_user_std($userid,$std);
		echo json_encode($get_sub);
	}
	public function concept_get()
	{
		$std=$this->input->post('std');
		$unit=$this->input->post('unit');
		$get_con=$this->team_model->list_concept($unit,$std);
		echo json_encode($get_con);
	}
	public function student_perf()
	{
		$this->load->helper('url');
		$this->load->view('frontend/team/header');
		$this->load->view('team/stu_perf');
		$this->load->view('frontend/team/footer');
	}
	public function student_perf_view()
	{
		$this->load->helper('url');
		$this->load->view('frontend/team/header');
		$this->load->view('team/stu_perf_view');
		$this->load->view('frontend/team/footer');
	}
	public function perf_history()
	{
		$this->load->helper('url');
		$this->load->view('frontend/team/header');
		$this->load->view('team/perf_history');
		$this->load->view('frontend/team/footer');
	}
	public function comparison()
	{
		$this->load->helper('url');
		$this->load->view('frontend/team/header');
		$this->load->view('team/comparison');
		$this->load->view('frontend/team/footer');
	}
	public function leaderboard()
	{
		$this->load->helper('url');
		$this->load->view('frontend/team/header');
		$this->load->view('team/leaderboard');
		$this->load->view('frontend/team/footer');
	}
	public function coordinator_perf()
	{
		$this->load->helper('url');
		$this->load->view('frontend/team/header');
		$this->load->view('team/co_perf');
		$this->load->view('frontend/team/footer');
	}
	public function coordinator_perf_view()
	{
		$this->load->helper('url');
		$this->load->view('frontend/team/header');
		$this->load->view('team/co_perf_view');
		$this->load->view('frontend/team/footer');
	}
	public function teacher_perf()
	{
		$this->load->helper('url');
		$this->load->view('frontend/team/header');
		$this->load->view('team/tea_perf');
		$this->load->view('frontend/team/footer');
	}
	public function teacher_perf_view()
	{
		$this->load->helper('url');
		$this->load->view('frontend/team/header');
		$this->load->view('team/tea_perf_view');
		$this->load->view('frontend/team/footer');
	}
	public function vid_tutorials()
	{
		$data['tutorial_list']=$this->team_model->list_tutorial();
		$rules=$this->rules_tut();
		$this->form_validation->set_rules($rules);
		
		if(isset($_POST['submit']))
		{
			if ($this->form_validation->run() == FALSE)
                {
					$data['form_err']=$this->session->set_flashdata('form_err','Enter Details correctly','success');
				}
				else{
			$insert=$this->team_model->tutorial_add();
			if($insert){
			$data['mesg']=$this->session->set_flashdata('success','Added Successfully');
			redirect('team/vid_tutorials','refresh');
			}
				}
		}
		$this->load->view('frontend/team/header');
		$this->load->view('team/tutorial',$data);
		$this->load->view('frontend/team/footer');
	}
	public function tutorial_view()
	{
		$prime_id=$this->uri->segment('3');
		$data['tutorial_view']=$this->team_model->list_single_tutorial($prime_id);
		$this->load->view('frontend/team/header');
		$this->load->view('team/tutorial_view',$data);
		$this->load->view('frontend/team/footer');
	}
	public function tutorial_edit()
	{
		$prime_id=$this->uri->segment('3');
		$data['tutorial_single']=$this->team_model->list_single_tutorial($prime_id);
		$rules=$this->rules_tut_edit();
		$this->form_validation->set_rules($rules);
		
		if(isset($_POST['submit']))
		{
			if ($this->form_validation->run() == FALSE)
                {
					$data['form_err']=$this->session->set_flashdata('form_err','Enter Details correctly','success');
				}
				else{
			$insert=$this->team_model->tutorial_edit();
			if($insert){
			$data['mesg']=$this->session->set_flashdata('success','Edited Successfully');
			redirect('team/vid_tutorials','refresh');
			}
				}
		}
		$this->load->view('frontend/team/header');
		$this->load->view('team/tutorial_edit',$data);
		$this->load->view('frontend/team/footer');
	}
	public function delete_tutorial()
	{
		if($this->input->post('type')==2)
		{
			$prime_id=$this->input->post('id');
			$this->team_model->delete_tutorial($prime_id);	
			//echo json_encode(array(
				//"statusCode"=>200
			//));
			echo "Deleted Successfully";
		} 
	}
	public function support()
	{
		$data['prio']=$priority=$this->input->post('priority');
		if(isset($_POST['list_submit']))
		{
			$data['sup_list']=$this->team_model->list_support($priority);
			//redirect('principal/add_section');
		}
		$this->load->view('frontend/team/header');
		$this->load->view('team/support',$data);
		$this->load->view('frontend/team/footer');
	}
	public function create_ticket()
	{
		$rules=$this->rules_ticket();
		$this->form_validation->set_rules($rules);
		
		if(isset($_POST['submit']))
		{
		
			if ($this->form_validation->run() == FALSE)
                {
					$data['form_err']=$this->session->set_flashdata('form_err','Enter Details correctly','success');
				}
				else{
			$insert=$this->team_model->create_ticket();
			if($insert){
			$data['mesg']=$this->session->set_flashdata('success','Added Successfully');
			redirect('team/support','refresh');
			}
				}
		}
		$this->load->view('frontend/team/header');
		$this->load->view('team/create_ticket');
		$this->load->view('frontend/team/footer');
	}
	public function ticket_status()
	{
		$tick_id=$this->input->post('id');
		$status=$this->input->post('status');
			$result=$this->team_model->ticket_status($tick_id,$status);
		echo json_decode($result);
	}
	public function support_edit()
	{
		$id=$this->uri->segment('3');
	    $data['support_single']=$this->team_model->list_support_single($id);
		$rules=$this->rules_ticket();
		$this->form_validation->set_rules($rules);
		if(isset($_POST['submit']))
		{
			if ($this->form_validation->run() == FALSE)
                {
					$data['form_err']=$this->session->set_flashdata('form_err','Enter Details correctly','success');
				}
				else{
			$update=$this->team_model->support_edit();
			if($update){
			$data['mesg']=$this->session->set_flashdata('success','Edited Successfully');
			redirect('team/support','refresh');
			}
				}
		}
		$this->load->view('frontend/team/header');
		$this->load->view('team/support_edit',$data);
		$this->load->view('frontend/team/footer');
	}
	public function support_view()
	{
		$this->load->helper('url');
		$this->load->view('frontend/team/header');
		$this->load->view('team/support_view');
		$this->load->view('frontend/team/footer');
	}
	public function delete_support()
	{
		if($this->input->post('type')==2)
		{
			$id=$this->input->post('id');
			$this->team_model->delete_support($id);	
			//echo json_encode(array(
				//"statusCode"=>200
			//));
			echo "Deleted Successfully";
		} 
	}
	public function add_package()
	{
		$this->load->helper('url');
		$this->load->view('frontend/team/header');
		$this->load->view('team/add_pack');
		$this->load->view('frontend/team/footer');
	}
	public function package_view()
	{
		$this->load->helper('url');
		$this->load->view('frontend/team/header');
		$this->load->view('team/view_pack');
		$this->load->view('frontend/team/footer');
	}
	public function package_edit()
	{
		$this->load->helper('url');
		$this->load->view('frontend/team/header');
		$this->load->view('team/edit_pack');
		$this->load->view('frontend/team/footer');
	}
	public function suggestion()
	{
		$this->load->helper('url');
		$this->load->view('frontend/team/header');
		$this->load->view('team/suggestion');
		$this->load->view('frontend/team/footer');
	}
	public function suggestion_view()
	{
		$this->load->helper('url');
		$this->load->view('frontend/team/header');
		$this->load->view('team/suggestion_view');
		$this->load->view('frontend/team/footer');
	}
	public function add_subject()
	{
		
		$data['sub_list']=$this->team_model->list_subject();
		$data['school_list']=$this->team_model->list_school();
		$rules=$this->rules_sub();
		$this->form_validation->set_rules($rules);
		
		if(isset($_POST['submit']))
		{
			if ($this->form_validation->run() == FALSE)
                {
					$data['form_err']=$this->session->set_flashdata('form_err','Enter Details correctly','success');
					$data['sub_list']=$this->team_model->list_subject();
					//redirect('principal/teacher');
					$data['actual_std']=array_filter(explode(',',$standard1));
		            $data['actual_sec']=array_unique(array_filter(explode(',',$section1)));
				}
				else{
			$insert=$this->team_model->add_subject();
			if($insert){
			$data['mesg']=$this->session->set_flashdata('success','Added Successfully');
			redirect('team/add_subject','refresh');
			}
				}
		}
		$this->load->helper('url');
		$this->load->view('frontend/team/header');
		$this->load->view('team/subject',$data);
		$this->load->view('frontend/team/footer');
	}
	public function edit_subject()
	{
		$id=$this->input->post('id');
		$get_sub=$this->team_model->list_single_subject($id);
		echo json_encode($get_sub);
	}
	public function edit_sub()
	{
		$std_sec=$this->principal_model->std_sec();
		$count=sizeof($std_sec);
		$standard1='';
		$section1='';
		for($i=0; $i<$count; $i++){
		$standard=$std_sec[$i]->std;
		$section=$std_sec[$i]->sec;
		$standard1.=$standard.',';
		$section1.=$section.',';
		}
		$data['actual_std']=array_filter(explode(',',$standard1));
		$data['actual_sec']=array_unique(array_filter(explode(',',$section1)));
		
		$data['sub_list']=$this->team_model->list_subject();
		$rules=$this->rules_sub_edit();
		$this->form_validation->set_rules($rules);
		
		if(isset($_POST['submit_edit']))
		{
			if ($this->form_validation->run() == FALSE)
                {
					$data['form_err']=$this->session->set_flashdata('form_err','Enter Details correctly','success');
					$data['sub_list']=$this->team_model->list_subject();
					//redirect('principal/teacher');
					$data['actual_std']=array_filter(explode(',',$standard1));
		            $data['actual_sec']=array_unique(array_filter(explode(',',$section1)));
				}
				else{
		     $id=$this->input->post('hid_val_edit');
		     $update=$this->team_model->edit_subject($id);
			if($update){
			$data['mesg']=$this->session->set_flashdata('success','Edited Successfully');
			redirect('team/add_subject','refresh');
			}
				}
		}
		$this->load->view('frontend/team/header');
		$this->load->view('team/subject',$data);
		$this->load->view('frontend/team/footer');
	}
	public function delete_subject()
	{
		if($this->input->post('type')==2)
		{
			$id=$this->input->post('id');
			$this->team_model->delete_subject($id);	
			//echo json_encode(array(
				//"statusCode"=>200
			//));
			echo "Deleted Successfully";
		} 
	}
	public function pen_paper_activity()
	{
		$data['user']='';
		if(isset($_POST['update'])){
			$update = $this->team_model->update_activity();
		  if($update)	{
			  $this->session->set_flashdata('success','Activity updated successfully!!', 'success');
			  redirect('team/pen_paper_activity','refresh');
		  }
		}
		$this->load->view('frontend/team/header');
		$this->load->view('team/pen_paper_activity',$data);
		$this->load->view('frontend/team/footer');
	}
	public function chapter_get()
	{
		$std=$this->input->post('std');
		$subject=$this->input->post('sub');
		$get_chap=$this->team_model->get_chapter($subject,$std);
		echo json_encode($get_chap);
	}
}
