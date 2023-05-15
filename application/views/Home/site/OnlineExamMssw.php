<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OnlineExamMssw extends CI_Controller {


	public function __construct()
    {
    parent::__construct();
    error_reporting(0);
    ini_set('display_errors', 0);  

    date_default_timezone_set('Asia/Kolkata');
  

	
    }


    public function index(){


        if(!isset($this->session->userdata('user')['user_id'])){
            redirect('Home/logOut', 'refresh');
            exit;
        } 

        if($this->user_agent() != "pc"){


            $this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
             <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
             <strong>Sorry ! '.$this->session->userdata('user')['user_name'].'</strong> Please Login Through your Laptop or Personal Computer To complete the examination.
           </div>');
             redirect('Admissions/', 'refresh');
             exit;
         
            }
  

  


    
  

       $m =  $this->db->select('*')->from('Applyed_Cources')->where('user_id',$this->session->userdata('user')['user_id'])->get();

       $applied  = $m->result();

        $exam_mode = [];
        $exam_subject = [];
        
        foreach($applied as $ecam){
            //  echo $ecam->main_course_id."<br>";
      
            if($ecam->main_course_id == 2 || $ecam->main_course_id == 3){
                  array_push($exam_mode,"MSW");
              }else 
              
              if($ecam->main_course_id == 1){
      
              if($ecam->applied_course_id == 15){
      
                  array_push($exam_mode,"MSW");
      
              }
              
            else if($ecam->applied_course_id == 5){
      
                  array_push($exam_mode,"MAHRM");
      
              }else if($ecam->applied_course_id == 6){
      
                  array_push($exam_mode,"MAHRM");
      
              } 
              
              else if($ecam->applied_course_id == 7){
      
                  array_push($exam_mode,"MASE");
      
              }else if($ecam->applied_course_id == 8){
      
                  array_push($exam_mode,"MADM");
      
              }
              
              else if($ecam->applied_course_id == 9){
      
                  array_push($exam_mode,"MSCCF");
      
              }   else if($ecam->applied_course_id == 16){
      
                  array_push($exam_mode,"MSCCF");
      
              } 
      
          }
        }
  array_unique($exam_mode);        

        foreach($exam_mode as $mode){
            $ra = rand(1,3);

        $m = $this->db->select('*')->from('online_exam_pannel')->where('exam_category',$mode)->where('student_id',$this->session->userdata('user')['user_id'])->get();

        $s = $m->num_rows();
$year = date('Y');
        if($s == 0){

                $data = array(
                    'exam_category'=>$mode,
                    'student_id'=>$this->session->userdata('user')['user_id'],
                    'question_type'=>$ra,
                    'year'=>$year,
                );
                $this->db->insert('online_exam_pannel',$data);
        }
    }
        redirect('OnlineExamMssw/examDashbord');
}

/* public function examIndex(){
	
	
	 $m =  $this->db->select('*')->from('Applyed_Cources')->where('user_id',$this->session->userdata('user')['user_id'])->get();

       $applied  = $m->result();

        $exam_mode = [];
        $exam_subject = [];
        
        foreach($applied as $ecam){
      //  echo $ecam->main_course_id."<br>";

        if($ecam->main_course_id == 2 || $ecam->main_course_id == 3){
            array_push($exam_mode,"MSW");
        }else if($ecam->main_course_id == 1){

        if($ecam->applied_course_id == 15){

            array_push($exam_mode,"MSW");

        }else if($ecam->applied_course_id == 5){

            array_push($exam_mode,"MAHRM");

        }else if($ecam->applied_course_id == 6){

            array_push($exam_mode,"MAHRM");

        }else if($ecam->applied_course_id == 7){

            array_push($exam_mode,"MASE");

        }else if($ecam->applied_course_id == 8){

            array_push($exam_mode,"MADM");

        }else if($ecam->applied_course_id == 9){

            array_push($exam_mode,"MSCCF");

        }

    }
  }
  array_unique($exam_mode);        

        foreach($exam_mode as $mode){
            $ra = rand(1,3);

        $m = $this->db->select('*')->from('online_exam_pannel')->where('exam_category',$mode)->where('student_id',$this->session->userdata('user')['user_id'])->get();

        $s = $m->num_rows();

        if($s == 0){

                $data = array(
                    'exam_category'=>$mode,
                    'student_id'=>$this->session->userdata('user')['user_id'],
                    'question_type'=>$ra,
                );
                $this->db->insert('online_exam_pannel',$data);
        }
    } 
	
	
	
	 redirect('OnlineExamMssw/examDashbord');
	
} */
public function examDashbord(){


    if($this->user_agent() != "pc"){


        $this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
         <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
         <strong>Sorry ! '.$this->session->userdata('user')['user_name'].'</strong> Please Login Through your Laptop or Personal Computer To complete the examination.
       </div>');
         redirect('Admissions/', 'refresh');
     exit;
        }

    $devicecheck= is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']),"mobile"));
    $devicecheck_android= is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']),"android"));
    
    if($devicecheck==1 OR $devicecheck_android==1)
    {
   


     $this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     <strong>Sorry ! '.$this->session->userdata('user')['user_name'].'</strong> Please Login Through Laptop or Personal Computer.
   </div>');
     redirect('Admissions/', 'refresh');


    }
    else{


    $current_date_time = date('Y-m-d H:i:s');
    $d1 = strtotime($this->session->userdata('user_exam')['exam_time_end']);
    $d2 = strtotime($current_date_time);
    if($d2 <= $d1){


        redirect('OnlineExamMssw/myExam/', 'refresh');



    } 

    $m = $this->db->select('*')->from('online_exam_pannel')->where('student_id',$this->session->userdata('user')['user_id'])->where('status',0)->get();

    $data['myexam'] = $m->result();

     $this->load->view('Home/template/head');
    $this->load->view('Home/site/online_exam_pg_dashbord',$data);
    $this->load->view('Home/template/footer'); 


}

}

public function myExam($n =null){
    $n = $this->uri->segment(3);
    
   $current_date_time = date('Y-m-d H:i:s');
    $d1 = strtotime($this->session->userdata('user_exam')['exam_time_end']);
    $d2 = strtotime($current_date_time);

    $numrows = $this->db->select('*')->from('online_exam_pannel')->where('student_id',$this->session->userdata('user')['user_id'])->where('exam_category',$n)->get();
    $count = $numrows->num_rows();

        if($count > 0 ){

            if($this->session->userdata('user_exam')['exam_time_start'] == "" || $this->session->userdata('user_exam')['exam_time_start'] == null ){



    $exam = array(
        'exam_details'=>$n,
        'exam_user'=>$this->session->userdata('user')['user_id'],
        'exam_time_start'=>date('Y-m-d H:i:s'),
        'exam_time_end'=>date('Y-m-d H:i:s',strtotime("+60 minutes")),
    );
    
    $this->session->set_userdata('user_exam', $exam);

    $data = array(
        'start_date'=>date('Y-m-d'),
        'start_time'=>date('H:i:s'),
        'status'=>1,
    );

    $this->db->where('student_id',$this->session->userdata('user')['user_id']);
    $this->db->where('exam_category',$n);
    $this->db->where('status',0);
    $this->db->update('online_exam_pannel',$data);
    redirect('OnlineExamMssw/myExam/', 'refresh');
//print_r($_SESSION);
 
}else if($d2 <= $d1){
    $qid = $this->db->select("question_type")->from("online_exam_pannel")->where("student_id",$this->session->userdata('user')['user_id'])->where('exam_category',$this->session->userdata('user_exam')['exam_details'])->get();
 
  
  
  $q_ida = $qid->result();
  
  if($q_ida[0]->question_type == 1){

    $order = "ASC";
    $odd_eve =0;

  }else if($q_ida[0]->question_type == 2){

    $order = "DESC";
    $odd_eve =1;

  }else{


    $order = "ASC";
    $odd_eve =1;

  }
    // print_r($_SESSION);
   $m = $this->db->select('*')->from('online_exam_question_bank_answe')->where('main_course',$this->session->userdata('user_exam')['exam_details'])->limit(50)->order_by('q_id', $order)->where("q_type",$odd_eve)->get();

$data['myexam'] = $m->result();

    $this->load->view('Home/template/head');
    $this->load->view('Home/site/online_exam_current',$data);
    $this->load->view('Home/template/footer'); 
   redirect('OnlineExamMssw/myExam/', 'refresh');

}

}else{


    if( $d2 <= $d1 ){

      //   print_r($_SESSION);


      $qid = $this->db->select("question_type")->from("online_exam_pannel")->where("student_id",$this->session->userdata('user')['user_id'])->where('exam_category',$this->session->userdata('user_exam')['exam_details'])->get();
 
  
  
      $q_ida = $qid->result();
      
      if($q_ida[0]->question_type == 1){
    
        $order = "ASC";
        $odd_eve =0;
    
      }else if($q_ida[0]->question_type == 2){
    
        $order = "DESC";
        $odd_eve =1;
    
      }else{
        
        $order = "ASC";
      $odd_eve =1;
    
      }



      $m = $this->db->select('*')->from('online_exam_question_bank_answe')->where('main_course',$this->session->userdata('user_exam')['exam_details'])->limit(50)->order_by('q_id', $order)->where("q_type",$odd_eve)->get();

      $data['myexam'] = $m->result();
     
         $this->load->view('Home/template/head');
         $this->load->view('Home/site/online_exam_current',$data);
         $this->load->view('Home/template/footer');  
      
     
     }else{

        $this->session->unset_userdata('user_exam');
    $this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Sorry ! '.$this->session->userdata('user')['user_name'].'</strong> You already wrote the exam .
  </div>');
    redirect('OnlineExamMssw/examDashbord', 'refresh'); 
     }
}
}
public function postAnswers(){



//print_r($_POST);


$subjet=$this->input->post('subject');
$end_date=$this->input->post('end_date');
$end_time=$this->input->post('end_time');
$online_q_id=null;
$online_a_id=null;

foreach($_POST as  $question_id => $user_inputted_option){

  



  //  echo $question_id ." => " . $user_inputted_option ."<br><br>";




if($question_id != 'subject' || $question_id != 'end_date' || $question_id != 'end_time'){

/* 


$online_q_id = $question_id;
$online_a_id = $user_inputted_option;
$data = array(
    'user_id'=>$this->session->userdata('user')['user_id'],
    'exam_'=>$subjet,
    'q_id'=>$online_q_id,
    'answer_id'=>$online_a_id,
    'date_ans'=>$end_date,
    'time_ans'=>$end_time,
);
if(is_numeric($online_q_id)){
$md = $this->db->select("*")->from("new_online_exam_answer")->where('exam_',$subjet)->where('user_id',$this->session->userdata('user')['user_id'])->where('q_id',$online_q_id )->get();

$num = $md->num_rows();


if($num > 0){

    $this->db->where('exam_',$subjet);
    $this->db->where('user_id',$this->session->userdata('user')['user_id']);
    $this->db->where('q_id',$online_q_id);
    $this->db->update('new_online_exam_answer',$data);
}else{


    $this->db->insert('new_online_exam_answer',$data);

}

} */

$this->db->where('exam_',$subjet);
$this->db->where('user_id',$this->session->userdata('user')['user_id']);
$this->db->where('q_id',0);
$this->db->delete('new_online_exam_answer');

}


}
redirect('OnlineExamMssw/answeredPage/'.$subjet, 'refresh'); 
}



public function postAnswersTimeout(){

$subjet=$this->input->post('subject');
$end_date=$this->input->post('end_date');
$end_time=$this->input->post('end_time');
$online_q_id=null;
$online_a_id=null;

foreach($_POST as  $question_id => $user_inputted_option){

  
if($question_id != 'subject' || $question_id != 'end_date' || $question_id != 'end_time'){


$online_q_id = $question_id;
$online_a_id = $user_inputted_option;
$data = array(
    'user_id'=>$this->session->userdata('user')['user_id'],
    'exam_'=>$subjet,
    'q_id'=>$online_q_id,
    'answer_id'=>$online_a_id,
    'date_ans'=>$end_date,
    'time_ans'=>$end_time,
);
if(is_numeric($online_q_id)){
$md = $this->db->select("*")->from("new_online_exam_answer")->where('exam_',$subjet)->where('user_id',$this->session->userdata('user_exam')['exam_user'])->where('q_id',$online_q_id )->get();

$num = $md->num_rows();


if($num > 0){

    $this->db->where('exam_',$subjet);
    $this->db->where('user_id',$this->session->userdata('user')['user_id']);
    $this->db->where('q_id',$online_q_id);
    $this->db->update('new_online_exam_answer',$data);
}else{


    $this->db->insert('new_online_exam_answer',$data);

    

}

}

$this->db->where('exam_',$subjet);
$this->db->where('user_id',$this->session->userdata('user')['user_id']);
$this->db->where('q_id',0);
$this->db->delete('new_online_exam_answer');

}
$this->AnswerOnlineExam($this->session->userdata('user')['user_id']);
echo 1;

}
}
public function answeredPage($sub = null){

 $sub = $this->session->userdata('user_exam')['exam_details'];

$md = $this->db->select("*")->from("new_online_exam_answer")->where('exam_',$sub)->where('user_id',$this->session->userdata('user')['user_id'])->get();


$update = array(
    'end_date'=>date('Y-m-d'),
    'end_time'=>date('H:i:s'),
    'completed_status'=>1,
);

$this->db->where('student_id',$this->session->userdata('user')['user_id']);
$this->db->where('exam_category',$sub);
$this->db->update('online_exam_pannel',$update);


$data['total_answered'] = $md->num_rows();
$data['total_questions'] = 50;
$data['subject'] = $sub;


$this->load->view('Home/template/head');
$this->load->view('Home/site/main_final_page',$data);
$this->load->view('Home/template/footer'); 


//$this->session->unset_userdata('user_exam');

}
public function AnswerOnlineExam($userid){


    $n = $this->db->select('*')->from("new_online_exam_answer")->where("score",NULL)->where("user_id",$userid)->get();
    
    $m = $n->result();
    
    
    foreach($m as $d){
    
    $qan = $this->db->select('*')->from('online_exam_question_bank_answe')->where('q_id',$d->q_id)->get();
    $dres = $qan->result();
    
    if($d->answer_id ==  $dres[0]->option_ans ){
    
    $mar = 1;
    
    }else{
    
    $mar = 0;
    
    }
    $data = array(
        'score'=>$mar
    );
    
    $this->db->where('id_',$d->id_)->update('new_online_exam_answer',$data);
    
    
    
    
    
    }

    
    }
    
public function logoutExam(){

 $this->session->set_flashdata('message', ' <div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Sorry ! '.$this->session->userdata('user')['user_name'].'</strong> You already wrote the exam .
  </div>');
    $this->session->unset_userdata('user_exam');
    redirect('Home/', 'refresh');

}


public function saveVideo(){


    if (!isset($_POST['audio-filename']) && !isset($_POST['video-filename'])) {
        echo 'Empty file name.';
        return;
    }

    // do NOT allow empty file names
    if (empty($_POST['audio-filename']) && empty($_POST['video-filename'])) {
        echo 'Empty file name.';
        return;
    }

    // do NOT allow third party audio uploads
    if (false && isset($_POST['audio-filename']) && strrpos($_POST['audio-filename'], "RecordRTC-") !== 0) {
        echo 'File name must start with "RecordRTC-"';
        return;
    }

    // do NOT allow third party video uploads
    if (false && isset($_POST['video-filename']) && strrpos($_POST['video-filename'], "RecordRTC-") !== 0) {
        echo 'File name must start with "RecordRTC-"';
        return;
    }
    
    $fileName = '';
    $tempName = '';
    $file_idx = '';
    
    if (!empty($_FILES['audio-blob'])) {
        $file_idx = 'audio-blob';
        $fileName = $_POST['audio-filename'];
        $tempName = $_FILES[$file_idx]['tmp_name'];
    } else {
        $file_idx = 'video-blob';
        $fileName = $_POST['video-filename'];
        $tempName = $_FILES[$file_idx]['tmp_name'];
    }
    
    if (empty($fileName) || empty($tempName)) {
        if(empty($tempName)) {
            echo 'Invalid temp_name: '.$tempName;
            return;
        }

        echo 'Invalid file name: '.$fileName;
        return;
    }

    
    $upload_max_filesize = ini_get('upload_max_filesize');
    if ($_FILES[$file_idx]['size'] > $upload_max_filesize) {
       echo 'upload_max_filesize exceeded.';
       return;
    }
    $post_max_size = ini_get('post_max_size');
    if ($_FILES[$file_idx]['size'] > $post_max_size) {
       echo 'post_max_size exceeded.';
       return;
    }
    

    $filePath = 'onlineExamVideo/' . $fileName;
    
    // make sure that one can upload only allowed audio/video files
    $allowed = array(
        'webm',
        'wav',
        'mp4',
        'mkv',
        'mp3',
        'ogg'
    );
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    if (!$extension || empty($extension) || !in_array($extension, $allowed)) {
        echo 'Invalid file extension: '.$extension;
        return;
    }
    
    if (!move_uploaded_file($tempName, $filePath)) {
        if(!empty($_FILES["file"]["error"])) {
            $listOfErrors = array(
                '1' => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
                '2' => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
                '3' => 'The uploaded file was only partially uploaded.',
                '4' => 'No file was uploaded.',
                '6' => 'Missing a temporary folder. Introduced in PHP 5.0.3.',
                '7' => 'Failed to write file to disk. Introduced in PHP 5.1.0.',
                '8' => 'A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded extensions with phpinfo() may help.'
            );
            $error = $_FILES["file"]["error"];

            if(!empty($listOfErrors[$error])) {
                echo $listOfErrors[$error];
            }
            else {
                echo 'Not uploaded because of error #'.$_FILES["file"]["error"];
            }
        }
        else {
            echo 'Problem saving file: '.$tempName;
        }
        return;
    }


$res = $this->db->select("*")->from("online_exam_video_tracker")->where("student_id",$this->session->userdata('user')['user_id'])->where("exam_name",$this->session->userdata('user_exam')['exam_details'])->where("video_name",$fileName)->get();

$count_res = $res->num_rows();

if($count_res == 0){

    $data = array(
        'student_id'=>$this->session->userdata('user')['user_id'],
        'exam_name'=>$this->session->userdata('user_exam')['exam_details'],
        'video_name'=>$fileName,
        'date_time'=>date('Y-m-d H:i:s'),
    );


    $this->db->insert('online_exam_video_tracker',$data);
}

  
    echo 'success';



}
public function myResults(){



$th = $this->db->select("*")->from("online_exam_pannel")->where("student_id",$this->session->userdata('user')['user_id'])->get();
$data['result'] = $th->result();
    $this->load->view('Home/template/head');
    $this->load->view('Home/site/enterence_mark',$data);
    $this->load->view('Home/template/footer');  
 








}


public function user_agent(){
    $iPod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
    $iPhone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
    $iPad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
    $android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
    file_put_contents('./public/upload/install_log/agent',$_SERVER['HTTP_USER_AGENT']);
    if($iPad||$iPhone||$iPod){
        return 'ios';
    }else if($android){
        return 'android';
    }else{
        return 'pc';
    }
}





}