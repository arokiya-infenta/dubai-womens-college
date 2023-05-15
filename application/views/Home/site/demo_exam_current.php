
<!-- end section -->
<!-- section -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.8.3/themes/base/jquery-ui.css" />
<script src="https://www.webrtc-experiment.com/RecordRTC.js"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<div class="section layout_padding padding_bottom-0" style="background:#12385b; padding-top:100px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="full">
                    <div class="heading_main text_align_center">
                 
                    </div>
                  </div>
            </div>
          </div>
       </div>
    </div>
   <!-- <video autoplay></video> -->
<!-- end section -->
<!-- section -->
<div class="section contact_section" style="background:#12385b;">
<video id="your-video-id"  autoplay playsinline></video>
<div id="demo_exm">
    <div class="container">
        <div class="row">
             
                <div class="col-md-12 ">
                    <div class="headings">
                     <h2 class="ttl">Mock Exam Dashboard </h2>
                      <!-- <h2>Your Reference Number : 21<?php echo sprintf("%'04d", $this->session->userdata('user')['user_id']); ?></h2> -->
                     </div>
                     <div class= "content-box well">
                    <!-- <legend class="head-one">My Dashboard </legend>-->

           <div class="row first-bord">


                     <?php //print_r($_SESSION); ?>
           
           <div class="col-md-4 clr-change">
           Exam Start Time : <span class="badge badge-warning p-2"><?= date('G:i:s',strtotime( $this->session->userdata('user_exam')['exam_time_start'])) ?></span>
           </div>
           <div class="col-md-4 clr-changeee">Current Time  : <span class="badge badge-warning p-2" id="ct"></span>  
          </div><div class="col-md-4 clr-changee">Exam End Time : <span class="badge badge-warning p-2" id="et"><?php echo $et= date('G:i:s',strtotime( $this->session->userdata('user_exam')['exam_time_end']));
        ?></span></div>
          

          </div>

   




                    </div>
    </div>
        </div>
        <div class="row">
             
      
             <div id="tabs" style="width: 100%;">



<form method="post" id="online_exam" action="<?=base_url()?>DemoExam/postAnswers">

<input type="hidden" id="subject" name="subject" value="<?=$this->session->userdata('user_exam')['exam_details']?>"/>
<input type="hidden" name="end_date" value="<?=date('Y-m-d')?>"/>

<input type="hidden" name="end_time" value="<?=date('h:i:s')?>"/>
<input type="hidden" name="controller" id="controller" value="<?php echo $this->uri->segment(1) ;?>"/>
            
             <ul>

             <?php  $i=1; foreach($myexam as $exam){  ?>
                 <li><a href="#tabs-<?=$i?>"><?=$i?></a></li>

                 <?php $i++; } ?>
                 
             </ul>


             <?php  $i=1; foreach($myexam as $exam){  
               
               
               
              $checked = $this->db->select("*")->from("new_demo_exam_answer")->where("user_id",$this->session->userdata('user_exam')['exam_user'])->where("q_id",$exam->q_id)->get();
               $ansche = $checked->num_rows();
               

                if($ansche > 0){
                  $mtans = $checked->result();


$anss=$mtans[0]->answer_id;




                }else{

                  $anss = 0;



                }


               
               ?>
                <div id="tabs-<?=$i?>">
                <?=$i?>) <?=str_replace("�"," ",$exam->question)?> 
                 <br><br>
                 Answer(s) : 
                 <br>         
                 <br>         
    <label class="radio-inline">
      <input type="radio"  class="answer" <?php if($anss == 1){echo"checked";} ?> name="<?=$exam->q_id?>" value="1" > <?=str_replace("�"," ",$exam->answer_1)?>
    </label><br>
    <label class="radio-inline">
      <input type="radio"  class="answer" <?php if($anss == 2){echo"checked";} ?> name="<?=$exam->q_id?>"  value="2"> <?=str_replace("�"," ",$exam->answer_2)?>
    </label><br>
    <label class="radio-inline">
      <input type="radio"  class="answer" <?php if($anss == 3){echo"checked";} ?> name="<?=$exam->q_id?>"  value="3"> <?=str_replace("�"," ",$exam->answer_3)?>
    </label><br>
    
    <label class="radio-inline">
      <input type="radio"  class="answer" <?php if($anss == 4){echo"checked";} ?> name="<?=$exam->q_id?>"  value="4"> <?=str_replace("�"," ",$exam->answer_4)?>
    </label><br>


<?php if($i == 25){ ?>

<input type="submit" value="Submit your answer" name="submit" >

<?php } ?>
 </div>

<?php $i++; } ?>

</form>    
         </div> 
         <br />
         <br />
         <br />
         <br />
         <br />
         <div class="pre">
         <input class="btn btn-primary" type="button" id="btnPrevious" value="Previous" style = "display:none"/></div>
         <div class="nxt">
         <input class="btn btn-info" type="button" id="btnNext" value="Next" /></div>
             
             </div>
    </div>

    
                       
         




 </div>            

           </div>    
<!-- end section -->

 
<script type="text/javascript">
var time = 1;

var interval = setInterval(function() { 
   if (time <= 30) { 


navigator.mediaDevices.getUserMedia({ video: true, audio: true }).then(function(camera) {

// preview camera during recording
document.getElementById('your-video-id').muted = true;
document.getElementById('your-video-id').srcObject = camera;

// recording configuration/hints/parameters
var recordingHints = {
    type: 'video'
};

// initiating the recorder
var recorder = RecordRTC(camera, recordingHints);

// starting recording here
recorder.startRecording();







/* 
setTimeout(function() {

// stop recording
recorder.stopRecording(function() {
    
    // get recorded blob
    var blob = recorder.getBlob();

    // generating a random file name
    var fileName = getFileName('webm');

    // we need to upload "File" --- not "Blob"
    var fileObject = new File([blob], fileName, {
        type: 'video/webm'
    });

    var formData = new FormData();

    // recorded data
    formData.append('video-blob', fileObject);

    // file name
    formData.append('video-filename', fileObject.name);

 //   document.getElementById('header').innerHTML = 'Uploading to PHP using jQuery.... file size: (' +  bytesToSize(fileObject.size) + ')';

    var upload_url = '<?=base_url()?>/DemoExam/saveVideo/';
// var upload_url = 'RecordRTC-to-PHP/save.php';

var upload_directory = '<?=base_url()?>/demo/';
    // var upload_directory = 'RecordRTC-to-PHP/uploads/';

    // upload using jQuery
    $.ajax({
        url: upload_url, // replace with your own server URL
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(response) {
            if (response === 'success') {
             //   alert('successfully uploaded recorded blob');

                // file path on server
                var fileDownloadURL = upload_directory + fileObject.name;


            } else {
               // alert(response); // error/failure
            }
        }
    }); 

    // release camera
    document.getElementById('your-video-id').srcObject = document.getElementById('your-video-id').src = null;
    camera.getTracks().forEach(function(track) {
        track.stop();
    });

});

},55000); */


});

// this function is used to generate random file name
function getFileName(fileExtension) {
var d = new Date();
var year = d.getUTCFullYear();
var month = d.getUTCMonth();
var date = d.getUTCDate();
var ttt = d.getTime();
return '<?=$this->session->userdata('user')['user_id']?>-<?=$this->session->userdata('user_exam')['exam_details']?>-' + year + month + date + '-'+ ttt +'-' + getRandomString() + '.' + fileExtension;
}

 function getRandomString() {
if (window.crypto && window.crypto.getRandomValues && navigator.userAgent.indexOf('Safari') === -1) {
    var a = window.crypto.getRandomValues(new Uint32Array(3)),
        token = '';
    for (var i = 0, l = a.length; i < l; i++) {
        token += a[i].toString(36);
    }
    return token;
} else {
    return (Math.random() * new Date().getTime()).toString(36).replace(/\./g, '');
}
} 

     
time++;
   }
   else { 
      clearInterval(interval);
   }
}, 60000);
        </script>

        <footer style="margin-top: 20px;"><small id="send-message"></small></footer>
        <script src="https://www.webrtc-experiment.com/common.js"></script>
   
<style>
.clr-change{
  color: #fff;
      font-size: 20px;
    font-weight: 600;
}
.clr-changee{
	color: #fff;
      font-size: 20px;
    font-weight: 600;
    text-align: end;
}
.clr-changeee{
	color: #fff;
      font-size: 20px;
    font-weight: 600;
    text-align: center;
}
video {
              max-width: 250px;
              max-height: 250px;
              border: 2px solid orangered;
              border-radius: 9px;
              position: relative;
    left: 77px;
            }
            

            .radio-inline input:checked ~ .ui-corner-top{
background: red !important;
}
.red {
  background: red;
}
.head-one {
    text-align: center;
    padding-top: 20px;
    text-decoration-style: wavy;
    font-weight: bold;
    color: #195252;
}
.cen{padding: 41px;
}
.first-bord{
  border: 1px solid #e9ecef;
    padding: 13px;
        margin: 0px;
            border-radius: 12px;
}
.nxt{
  margin: 10px 0px;
}
.pre{
  margin: 10px 6px;
}
.clr-change{
  color: #fff;
}
.ui-widget-content{
 background: none !important;
  border:0px !important;
   color: #fff !important;
}
.ui-state-active a, .ui-state-active a:link, .ui-state-active a:visited {
  color: #fff !important;
}
.ui-tabs .ui-tabs-nav li.ui-tabs-selected {
    margin-bottom: 0;
    padding-bottom: 0px !important;
}
.ui-widget-header a {
  color: #fff !important;
}
.ui-tabs .ui-tabs-panel {
   background: #21212191 !important;
       border-radius: 12px;
}
.ui-widget-header {
  background: none !important;
  border: 0px !important;
}
.ui-tabs .ui-tabs-nav li {
      margin: 20px 3px 1px 0px !important;
      border-radius: 15px 15px 0px 0px !important;
}
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default {
  border: 1px solid #d3d3d385 !important;
}
.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active {
  background: #ff8400 !important;
}

li.ui-state-default.ui-corner-top {
    background: none;
}
.ttl {
  
    font-weight: 600;
     text-align: inherit !important; 
}
input[type="radio" i] {
  --background-color: red;
}
label.radio-inline {
    font-size: 13px;
    font-weight: 100;
}
.ttl span{
  float: right;
  font-size: 16px;
    font-weight: 400;
}
/*.well { min-height: 50px;box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);position: relative;margin-bottom:5px;padding-bottom: 30px;-webkit-border-radius: 2px;-moz-border-radius: 2px;-ms-border-radius: 2px;    border-radius: 2px;}*/
.border-1 {border:1px solid #0b1c2c;}
.pad-20 {padding:39px;}
.stats-box {min-height:115px; background: #fff; border-radius:5px;}
.stats-box:hover {background:#f2f2f2;color:#dd0000;}
@media (min-width: 1200px){
.container {
    max-width: 1400px;
}
}
</style>

  