
<!-- end section -->
<!-- section -->
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
<!-- end section -->
<!-- section -->

<div class="section contact_section" style="background:#12385b;">
<div class=""style="">
<!-- <div id="container">
  <video autoplay="true" id="videoElement">
  
  </video>
</div> -->
    <div class="container">
        <div class="row">
             
                <div class="col-md-12 ">
                    <div class="headings">
                     <h2 class="ttl">Mock Exam Dashboard  </h2>
                      <!-- <h2>Your Reference Number : 21<?php echo sprintf("%'04d", $this->session->userdata('user')['user_id']); ?></h2> -->
                     </div>
                 
                    <!-- <legend class="head-one">My Dashboard </legend>-->

           <div class="row">
           <div class="col-md-2 "></div>
           <div class="col-md-8 ">
            <?=$this->session->flashdata('message');?>
           </div>
           <div class="col-md-2 "></div>
          

          </div>

                  <!--  <div class="row">
             
       <div class="col-md-12 cen ">
       <div class="stats-box border-1 pad-20">
             <h2 class="instruct"> Instruction </h2>
             <ul class="points">
  <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>If the exam closes unexpectedly,you can start it again</li>
  <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>If the exam is closed due to internet and power problem, you can start your exam again</li>
  <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>Please contact thus number for further assistance:9999999</li>
</ul>
       </div>
    </div>
    </div>-->
<div class="start-exam">
  
    <h4>Start Exam</h4>
    
</div>
<div id="time">

<input type="hidden" id="st" value="" >
<input type="hidden" id="server_time" value="<?php echo date("H:i"); ?>" >

</div>
<p id="time_d"></p>
<?php



?>








<div class="row oreal">
  <div class="col-lg-1"></div>
  <div class="col-lg-10">
    <div class="row">
	
	<?php 

$pr_sfcourse = $this->db->select('cour_id,demo_active')->from('department_details')->where('main_id',1)->get();
$pr_mswsfcourse = $this->db->select('cour_id,demo_active')->from('department_details')->where('main_id',3)->get();
$pr_mswadcourse = $this->db->select('cour_id,demo_active')->from('department_details')->where('main_id',2)->get();

$active_sf = $pr_sfcourse->result_array();
$active_mswsf = $pr_mswsfcourse->result_array();
$active_mswad = $pr_mswadcourse->result_array();

$act_mswaid_course = [];
$exam_code = [];
$exam_code_active = [];



foreach ($active_mswad as $key => $value) {

  if($value['demo_active']==1 ){
    array_push($act_mswaid_course, $value['cour_id']);
    array_push($exam_code,"MSW");

  }

}
$act_mswsf_course = [];



foreach ($active_mswsf as $key => $value) {

  if($value['demo_active']==1 ){
    array_push($act_mswsf_course, $value['cour_id']);
    array_push($exam_code,"MSW");

  }

}
$act_sf_course = [];



foreach ($active_sf as $key => $value) {

  if($value['demo_active']==1){
    array_push($act_sf_course, $value['cour_id']);

    if($value['cour_id'] == 5){
      array_push($exam_code,"MAHRM");
    }elseif($value['cour_id'] == 6){
      array_push($exam_code,"MAHRM");
    } 
    elseif($value['cour_id'] == 7){
      array_push($exam_code,"MASE");
    }
    elseif($value['cour_id'] == 8){
      array_push($exam_code,"MADM");
    }
    elseif($value['cour_id'] == 9){
      array_push($exam_code,"MSCCF");
    }
    elseif($value['cour_id'] == 15){
      array_push($exam_code,"MSW");
    }
    elseif($value['cour_id'] == 16){
      array_push($exam_code,"MSCCF");
    }


  }

}
$exam_code_active = array_unique($exam_code);

$exam_code_active = array_values($exam_code_active);
 /* echo"<pre>";
  print_r($exam_code_active);
  print_r($act_mswaid_course);
  print_r($act_mswsf_course);
  print_r($act_sf_course);
  print_r($myexam); */
  //print_r($active_mswad);





  foreach($myexam as $exam){
    
    
    if($exam->exam_category == 'MSW'){

   
        $name = 'M.S.W.(Aided), M.S.W.(SF), M.S.W.(D&E)';

    }else if($exam->exam_category == 'MAHRM'){


        $name = 'M.A.HRM & M.A.HR & OD';


    }else if($exam->exam_category == 'MASE'){


        $name = 'M.A.SE';


    }else if($exam->exam_category == 'MADM'){


        $name = 'M.A.DM';


    }else if($exam->exam_category == 'MSCCF'){


        $name = 'M.Sc Psychology, M.Sc CFT(SF)';


    }
    
    
  
    if(in_array($exam->exam_category,$exam_code_active)){
    
    ?>
	
      <div class="col-sm-4 adjust">
	  
	  <a href="<?=base_url()?>DemoExam/myExam/<?=$exam->exam_category?>" class="btn btn-primary bg-clr" ><?=$name?></a>
	
  </div>
  
  
  
  
  
  
  
  
  <?php } } ?>    
    </div>
  </div>
  <div class="col-lg-1"></div>
</div>



  
              





                    </div>
    </div>
        </div>
  
    
 </div>            

           </div>       
     
<!-- end section -->
<style>
#container {
  margin: 0px auto;
  width: 500px;
  height: 375px;
  border: 10px #333 solid;
}
#videoElement {
  width: 500px;
  height: 375px;
  background-color: #666;
}
.head-one {
    text-align: center;
    padding-top: 20px;
    text-decoration-style: wavy;
    font-weight: bold;
    color: #195252;
}
.well { min-height: 50px;box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);position: relative;margin-bottom:5px;padding-bottom: 30px;-webkit-border-radius: 2px;-moz-border-radius: 2px;-ms-border-radius: 2px;    border-radius: 2px;}
.border-1 {border:1px solid #0b1c2c;}
.pad-20 {padding:39px;}
.stats-box {min-height:115px; background: #fff; border-radius:5px;}
.stats-box:hover {background:#f2f2f2;color:#dd0000;}
@media (min-width: 1200px)
{
.container {
    max-width: 1400px;
}
}
.adjust{
  text-align: center;;
}
.oreal{
      padding-bottom: 40px;
}
.bg-clr{
  background-color:#ff8100;
      border-color: #ff8100;
          border-radius: 20px;
}
.bg-clr h2{
  color: #fff;
}
.start-exam h4{
  text-align: center;
    color: #fff;
    font-weight: 600;
}
.start-exam{
  margin: 80px 0px;
}
.ttl {
  
    font-weight: 600;
     text-align: inherit !important; 
}
.ttl span{
  float: right;
  font-size: 16px;
    font-weight: 400;
}

.stats-box{
  background: none;
  box-shadow: #f8f9fa 0px 1px 3px 0px, rgb(27 31 35 / 15%) 0px 0px 0px 1px;
  border-radius: 20px !important;
}
.stats-box:hover {
  background: none;
  color: #fff;
}
.items{
  color: #fff;
}
.instruct{
  color: #fff;
}
.points{
  list-style: none;
}
.changecl{
  color: #ff8507;
  padding-right: 20px;
}
.pad-20 {
    padding: 10px 20px;
}
.items{
  margin: 10px 0px;
}
ul{
  margin: 0px;
}
.top-header .navbar .navbar-collapse ul li a {
  font-weight: 500 !important;

}
.nav-link:active {
  color: #ff8100;
}
</style>
<script>
	sttime();

//alert(dateTime);
function sttime(){
  var timex = new Date();
var time =  ((timex.getHours()<10?'0':'') + timex.getHours()) + ":" + ((timex.getMinutes()<10?'0':'') + timex.getMinutes()) ;
var dateTime = time;
document.getElementById("st").innerHTML = time;





 var st_time = time;
 var server_time = document.getElementById("server_time").value ;




if(st_time != server_time){
//  alert(st_time);
//alert(server_time);
//document.getElementsByClassName("adjust").style.visibility = 'hidden';
var appBanners = document.getElementsByClassName('adjust');

for (var i = 0; i < appBanners.length; i ++) {
    appBanners[i].style.display = 'none';
}
document.getElementById("time_d").innerHTML = "<h2 class='ttl'>Your machine time and the server time dosenot match .Server time is  " + server_time +" Set your time as 'AUTOMATIC' before starting the exam</h2>";
}



}
</script>
