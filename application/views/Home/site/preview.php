<!DOCTYPE html>
<html>
<head>
	<title>Professional profile</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
	<div class="profile-main">
		<div class="profile-header">
			<div class="user-detail">
				<div class="user-image">
<?php if($user[0]->pr_photo == "" || $user[0]->pr_photo == NULL ){echo"<h3>Image not uploaded";}else{?>
					<img src="<?=base_url()?>admin/uploads/<?=$user[0]->pr_photo?>">
<?php } ?>      
				</div>
				<div class="user-data">
					<h2><?=$user[0]->pr_applicant_name?></h2>
         <!-- <a style="float:right;" target="_blank" href="<?=base_url()?>Home/downloadPdF" >Download PDF</a> -->
				</div>
			</div>
			<div class="tab-panel-main">
				<ul class="tabs">
					<li class="tab-link current" data-tab="Basic-detail">Basic Details</li>
					<li class="tab-link" data-tab="Edu-detail">Educational Details</li>
					<li class="tab-link" data-tab="Portfolio">Mark Details</li>
				</ul>
				<div id="Basic-detail" class="tab-content current">
						 <h2><i class="fa fa-user" aria-hidden="true"></i> Basic Details</h2>
				<div style="overflow-x:auto;">
        <table class="table" id="myTable">
                    <tr>
                        <th>Preferred  Course</th>
                        <td><?php 
                       

echo"<h3>Other PG Cources</h3>";

$arrt = explode(",",$user[0]->pr_course_1);


$q = $this->db->select('*')->from('college_course')->where_in('cs_id',$arrt)->get();
                        $sub_1 = $q->result();

foreach ($sub_1 as $value) {  
  
  
                          echo $value->cs_name . "<br>";
                          }
                        ?></td>
                    </tr>
                 
                
                    <tr>
                        <th>Mother Tongue </th>
                        <td><?=$user[0]->pr_mother_toung?></td>
                    </tr>
                    <tr>
                        <th>Place of Birth </th>
                        <td><?=$user[0]->pr_place_of_birth?></td>
                    </tr>
                    <tr>
                        <th>Date of Birth</th>
                        <td><?=date('d-M-Y',strtotime($user[0]->pr_dob))?></td>
                    </tr>
                    <tr>
                        <th>Age</th>
                        <td><?=$user[0]->pr_age?></td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td><?=$user[0]->pr_gender?></td>
                    </tr>
                    <tr>
                        <th>Nationality</th>
                        <td><?=$user[0]->pr_nationality?></td>
                    </tr> 
                    <tr>
                        <th>Religion</th>
                        <td><?=$user[0]->pr_religion?></td>
                    </tr>  <tr>
                        <th>Caste</th>
                        <td><?=$user[0]->pr_caste?></td>
                    </tr>  <tr>
                        <th>Community</th>
                        <td><?=$user[0]->pr_community?></td>
                    </tr>  
                </table>
                <h3>Parent's / Guardian's Details</h3>
                <table class="table" id="myTable">
                <tr>
      <th>#</th>
      <th>Father</th>
      <th>Mother</th>
      <th>Guardian</th>
    <tr>
    <th>Name</th>
      <td><?=$user[0]->pr_father_name?></td>
      <td><?=$user[0]->pr_mother_name?></td>
      <td><?=$user[0]->pr_gaurdion_name?></td>
    </tr>
    <tr>
    <th>E-Mail Id</th>
    <td><?=$user[0]->pr_father_email?></td>
      <td><?=$user[0]->pr_mother_email?></td>
      <td><?=$user[0]->pr_gaurdion_email?></td>
    </tr>
    <tr>
    <th>Mobile No.</th>
    <td><?=$user[0]->pr_father_mobnum?></td>
      <td><?=$user[0]->pr_mother_mobnum?></td>
      <td><?=$user[0]->pr_gaurdion_mobnum?></td>
    </tr>
    <tr>
    <th>Occupation</th>
    <td><?=$user[0]->pr_father_accu?></td>
      <td><?=$user[0]->pr_mother_accu?></td>
      <td><?=$user[0]->pr_gaurdion_accu?></td>
    </tr>
    <tr>
    <th>Annual
Income</th>
<td><?=$user[0]->pr_father_anuval_income?></td>
      <td><?=$user[0]->pr_mother_anuval_income?></td>
      <td><?=$user[0]->pr_gaurdion_anuval_income?></td>
    </tr>   
                </table>
                <h3>Address</h3>
                <table class="table" id="myTable">
                <tr>
      <th>#</th>
      <th>Local Address</th>
      <th>Permanant</th>
    <tr>
    <th>Address</th>
      <td><?=$user[0]->pr_local_address?></td>
      <td><?=$user[0]->pr_permanent_address?></td>
    </tr>
   
    <tr>
    <th>City</th>
    <td><?=$user[0]->pr_local_city?></td>
      <td><?=$user[0]->pr_permanent_city?></td>
    </tr>
    <tr>
    <th>State</th>
    <td><?=$user[0]->pr_local_state?></td>
      <td><?=$user[0]->pr_permanent_state?></td>
    </tr>    
    <tr>
    <th>Country</th>
    <td><?=$user[0]->pr_local_country?></td>
      <td><?=$user[0]->pr_permanent_country?></td>
    </tr>   
    <tr>
    <th>Pincode</th>
    <td><?=$user[0]->pr_local_pincode?></td>
      <td><?=$user[0]->pr_permanent_pincode?></td>
    </tr>   
                </table>
                <h3>Identification Marks</h3>
                <table class="table" id="myTable">
                 <tr>
                     <th>1</th>
                     <td><?=$user[0]->pr_identification_one?></td>
                 </tr>
                 <tr>
                     <th>2</th>
                     <td><?=$user[0]->pr_identification_two?></td>
                 </tr>
             </table>
             <h3>Differently Abled </h3>
                <table class="table" id="myTable">
                <?php  if($user[0]->pr_differently_abled == "" || $user[0]->pr_differently_abled == NULL){echo"";}
                else if($user[0]->pr_differently_abled=="NO"){
          echo"<tr>
          <th>No</th>
          <td></td>
          </tr>";
                }else if($user[0]->pr_differently_abled=="YES"){
                  echo"<tr>
                  <th>".$user[0]->pr_differently_abled."</th>
                  <td>".$user[0]->pr_differently_abled_reson."</td>
                  </tr>";
                  if($user[0]->pr_abled_certificate =="" || $user[0]->pr_abled_certificate ==Null){
                    echo"<tr><th>Disabled  Certificate</th><td>Not Uploded</td></tr>";
                                             }else{
                  echo"<tr><th>Disabled  Certificate</th><td><a target='_blank' href='".base_url()."Home/UploadFile?file=".urlencode($user[0]->pr_abled_certificate)."' >Download</a></td></tr>";
                                             } 
                }
                   ?>
             </table>
</div>
				</div>
				<div id="Edu-detail" class="tab-content">
        <h2><i class="fa fa-user" aria-hidden="true"></i> Educational Details</h2>
             <div style="overflow-x:auto;">
                     <table class="table edu-tbl" id="myTable">
                         <?php  if($user[0]->pr_sslc_mark =="" || $user[0]->pr_sslc_mark ==Null){
echo"<tr><th>SSLC Mark Sheet</th><td>Not Uploded</td></tr>";
                         }else{
                          echo"<tr><th>SSLC Mark Sheet</th><td><a target='_blank' href='".base_url()."Home/UploadFile?file=".urlencode($user[0]->pr_sslc_mark)."'>Download</a></td></tr>";
                         }  ?>
                         <?php  if($user[0]->pr_hse_certificate =="" || $user[0]->pr_hse_certificate ==Null){
echo"<tr><th>Higher Secondary First Year Mark Sheet</th><td>Not Uploded</td></tr>";
                         }else{
                          echo"<tr><th>Higher Secondary First Year Mark Sheet</th><td><a target='_blank' href='".base_url()."Home/UploadFile?file=".urlencode($user[0]->pr_hse_certificate)."'>Download</a></td></tr>";
                         }  ?>
 <?php  if($user[0]->pr_hse2_certificate =="" || $user[0]->pr_hse2_certificate ==Null){
                  echo"<tr><th>Higher Secondary Second Year Mark Sheet </th><td>Not Uploded</td></tr>";
                                                   }else{
  echo"<tr><th>Higher Secondary Second Year Mark Sheet </th><td><a target='_blank' href='".base_url()."Home/UploadFile?file=".urlencode($user[0]->pr_hse2_certificate)."'>Download</a></td></tr>";
    }  ?>


<?php  if($user[0]->pr_provisional_mark_sheet =="" || $user[0]->pr_provisional_mark_sheet ==Null){
                  echo"<tr><th>+2 Provisional Mark Sheet </th><td>Not Uploded</td></tr>";
                                                   }else{
  echo"<tr><th>+2 Provisional Mark Sheet </th><td><a target='_blank' href='".base_url()."Home/UploadFile?file=".urlencode($user[0]->pr_provisional_mark_sheet)."'>Download</a></td></tr>";
    }  ?>



<?php  if($user[0]->pr_comunity_cert =="" || $user[0]->pr_comunity_cert ==Null){
                  echo"<tr><th>Community Certificate </th><td>Not Uploded</td></tr>";
                                                   }else{
  echo"<tr><th>Community Certificate </th><td><a target='_blank' href='".base_url()."Home/UploadFile?file=".urlencode($user[0]->pr_comunity_cert)."'>Download</a></td></tr>";
    }  ?>




<?php  if($user[0]->pr_transfer_cert =="" || $user[0]->pr_transfer_cert ==Null){
                  echo"<tr><th>Transfer Certificate</th><td>Not Uploded</td></tr>";
                                                   }else{
  echo"<tr><th>Transfer Certificate</th><td><a target='_blank' href='".base_url()."Home/UploadFile?file=".urlencode($user[0]->pr_transfer_cert)."'>Download</a></td></tr>";
    }  ?>




<?php  if($user[0]->pr_conduct_certificate =="" || $user[0]->pr_conduct_certificate ==Null){
                  echo"<tr><th>Conduct Certificate</th><td>Not Uploded</td></tr>";
                                                   }else{
  echo"<tr><th>Conduct Certificate</th><td><a target='_blank' href='".base_url()."Home/UploadFile?file=".urlencode($user[0]->pr_conduct_certificate)."'>Download</a></td></tr>";
    }  ?>



<?php  if($user[0]->pr_eligibility_certificate =="" || $user[0]->pr_eligibility_certificate ==Null){
                  echo"<tr><th>Eligibility Certificate</th><td>Not Uploded</td></tr>";
                                                   }else{
  echo"<tr><th>Eligibility Certificate</th><td><a target='_blank' href='".base_url()."Home/UploadFile?file=".urlencode($user[0]->pr_eligibility_certificate)."'>Download</a></td></tr>";
    }  ?>



<?php  if($user[0]->pr_migration_certificate =="" || $user[0]->pr_migration_certificate ==Null){
                  echo"<tr><th>Migration certificate</th><td>Not Uploded</td></tr>";
                                                   }else{
  echo"<tr><th>Migration certificate</th><td><a target='_blank' href='".base_url()."Home/UploadFile?file=".urlencode($user[0]->pr_migration_certificate)."'>Download</a></td></tr>";
    }  ?>

         <tr>
                          <th>+2 Register No</th>
                          <td><?=$user[0]->pr_certificate_regist_numb?></td>
                      </tr>
                  </table>
                  <h3>School / Institution last attended</h3>
                     <table class="table" id="myTable">
                        <tr>
                          <th>Institution</th>
                          <td><?=$user[0]->pr_institute_last_attanded?></td>
                      </tr>
                      <tr>
                          <th>Institution Name</th>
                          <td><?=$user[0]->pr_insti_name?></td>
                      </tr>
                      <tr>
                          <th>Medium of Instruction (in +2)</th>
                          <td><?=$user[0]->pr_medium_of_instruct?></td>
                      </tr>
                      <tr>
                          <th>Month and Year of Passing</th>
                          <td><?=$user[0]->pr_month_year_pass?></td>
                      </tr>
                      <tr>
                          <th>Stream</th>
                          <td><?=$user[0]->pr_Stream?></td>
                      </tr>
                      <tr>
                          <th>Passed in FIRST attempt</th>
                          <td><?=$user[0]->pr_passed_in_first_attemt?></td>
                      </tr>
                       <tr>
                          <th>Break in Studies</th>
                          <td><?=$user[0]->pr_break_in_syudy?></td>
                      </tr>
                      <tr>
                          <th> Reason</th>
                          <td><?=$user[0]->pr_break_reason?></td>
                      </tr> 
                       <tr>
                          <th>Language Studied in School</th>
                          <td><?=$user[0]->pr_languvage_studied?></td>
                      </tr>
                      <tr>
                          <th>Sports Category : Name of the Game(s)</th>
                          <td><?=$user[0]->pr_name_of_game?></td>
                      </tr>
                      <tr>
                          <th>Position</th>
                          <td><?=$user[0]->pr_game_position?></td>
                      </tr>
                       <tr>
                          <th>Extra - Curricular Activities</th>
                          <td><?=$user[0]->pr_extra_caricular_act?></td>
                      </tr>
  </table>
  <table class="table" id="myTable">

<?php  


if($user[0]->pr_other_res == "No"){ ?>
        <tr>
        <th>Other Reservation</th>
        <td>No</td>
        </tr>
       <?php       }else if($user[0]->pr_other_res == "Yes"){
                echo"<tr>
                <th>Other Reservation</th>
                <td>".$user[0]->pr_other_special_reservation."</td>
                </tr>";

              }
              
              
              if($user[0]->pr_hostel == "No"){
        echo"<tr>
        <th>Hostel Required</th>
        <td>No</td>
        </tr>";
              }else if($user[0]->pr_hostel == "Yes"){
                echo"<tr>
                <th>Hostel Required</th>
                <td>YES</td>
                </tr>";

              }
                
                 ?>
</table>

     </div>
				</div>
				<div id="Portfolio" class="tab-content">
        <h2><i class="fa fa-user" aria-hidden="true"></i> Marks Details</h2>
      <div style="overflow-x:auto;">
              <h3>Marks</h3>
              <table class="table mark-table" id="myTable">
                    <tr>
                   <th>Subjects</th>
                   <th colspan="4">Plus One</th>
                   <th colspan="3">Plus Two</th>
                   </tr>
               <tr>
                   <th>#</th>
                   <th >Max. Marks</th>
                   <th>Marks Obtained</th>
                   <th>Class / Grade</th>
            
                   <th >Max. Marks</th>
                   <th>Marks Obtained</th>
                   <th>Class / Grade</th>
               
               </tr>
               <tr>
                   <td><?=$Study[0]->lang_1?></td>
                   <td ><?=$Study[0]->lang_1_max_mark_plus_1?></td>
                   <td><?=$Study[0]->lang_1_mark__obtained_plus_1?></td>
                   <td><?=$Study[0]->lang_1_class_grade_plus_1?></td>
                  
                   <td><?=$Study[0]->lang_1_max_mark_plus_2?></td>
                   <td><?=$Study[0]->lang_1_mark__obtained_plus_2?></td>
                   <td><?=$Study[0]->lang_1_class_grade_plus_2?></td>
                   
               </tr>
               <tr>
               <td><?=$Study[0]->lang_2?></td>
                   <td ><?=$Study[0]->lang_2_max_mark_plus_1?></td>
                   <td><?=$Study[0]->lang_2_mark__obtained_plus_1?></td>
                   <td><?=$Study[0]->lang_2_class_grade_plus_1?></td>
                 
                   <td><?=$Study[0]->lang_2_max_mark_plus_2?></td>
                   <td><?=$Study[0]->lang_2_mark__obtained_plus_2?></td>
                    <td><?=$Study[0]->lang_2_class_grade_plus_2?></td>
                    
               </tr>
               <tr>
                   <td><?=$Study[0]->subj_1?></td>
                   <td ><?=$Study[0]->subj_1_max_mark_plus_1?></td>
                   <td><?=$Study[0]->subj_1_mark__obtained_plus_1?></td>
                   <td><?=$Study[0]->subj_1_class_grade_plus_1?></td>
                
                   <td><?=$Study[0]->subj_1_max_mark_plus_2?></td>
                   <td><?=$Study[0]->subj_1_mark__obtained_plus_2?></td>
                   <td><?=$Study[0]->subj_1_class_grade_plus_2?></td>
               </tr>
               <tr>
               <td><?=$Study[0]->subj_2?></td>
                   <td ><?=$Study[0]->subj_2_max_mark_plus_1?></td>
                   <td><?=$Study[0]->subj_2_mark__obtained_plus_1?></td>
                   <td><?=$Study[0]->subj_2_class_grade_plus_1?></td>
                  
                   <td><?=$Study[0]->subj_2_max_mark_plus_2?></td>
                   <td><?=$Study[0]->subj_2_mark__obtained_plus_2?></td>
                   <td><?=$Study[0]->subj_2_class_grade_plus_2?></td>
               </tr>
               <tr>
                   <td><?=$Study[0]->subj_3?></td>
                   <td ><?=$Study[0]->subj_3_max_mark_plus_1?></td>
                   <td><?=$Study[0]->subj_3_mark__obtained_plus_1?></td>
                   <td><?=$Study[0]->subj_3_class_grade_plus_1?></td>
                
                   <td><?=$Study[0]->subj_3_max_mark_plus_2?></td>
                   <td><?=$Study[0]->subj_3_mark__obtained_plus_2?></td>
                   <td><?=$Study[0]->subj_3_class_grade_plus_2?></td>
               </tr> 
               <tr>
               <td><?=$Study[0]->subj_4?></td>
                   <td ><?=$Study[0]->subj_4_max_mark_plus_1?></td>
                   <td><?=$Study[0]->subj_4_mark__obtained_plus_1?></td>
                   <td><?=$Study[0]->subj_4_class_grade_plus_1?></td>
                 
                   <td><?=$Study[0]->subj_4_max_mark_plus_2?></td>
                   <td><?=$Study[0]->subj_4_mark__obtained_plus_2?></td>
                   <td><?=$Study[0]->subj_4_class_grade_plus_2?></td>
               </tr>
               <tr>
                   <td><?=$Study[0]->g_total?></td>
                   <td ><?=$Study[0]->g_total_max_mark_plus_1?></td>
                   <td><?=$Study[0]->g_total_mark__obtained_plus_1?></td>
                   <td><?=$Study[0]->g_total_class_grade_plus_1?></td>
                
                   <td><?=$Study[0]->g_total_max_mark_plus_2?></td>
                    <td><?=$Study[0]->g_total_mark__obtained_plus_2?></td>
                   <td><?=$Study[0]->g_total_class_grade_plus_2?></td>
               </tr>
               <tr>
                   <td><?=$Study[0]->m_total?></td>
                   <td ><?=$Study[0]->m_total_max_mark_plus_1?></td>
                   <td><?=$Study[0]->m_total_mark__obtained_plus_1?></td>
                   <td><?=$Study[0]->m_total_class_grade_plus_1?></td>
                 
                   <td><?=$Study[0]->m_total_max_mark_plus_2?></td>
                   <td><?=$Study[0]->m_total_mark__obtained_plus_2?></td>
                   <td><?=$Study[0]->m_total_class_grade_plus_2?></td>
               </tr> <tr>
               <td>Main Sub. Percentage</td>
                   <td ><?=$Study[0]->percentage_max_plus_one?></td>
                   <td><?=$Study[0]->main_percentage_plus_1?></td>
                   <td></td>
                 
                   <td><?=$Study[0]->percentage_max_plus_two?></td>
                   <td><?=$Study[0]->main_percentage_plus_2?></td>
                   <td></td>
               </tr>
           </table>
</div>
				</div>
			</div>
		</div>
		<div style="clear: both;"></div>
	</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('ul.tabs li').click(function(){
			var tab_id = $(this).attr('data-tab');
			$('ul.tabs li').removeClass('current');
			$('.tab-content').removeClass('current');
			$(this).addClass('current');
			$("#"+tab_id).addClass('current');
		});
	});
</script>
<style>
body{
	font-family: calibri;
  margin-top: 50px;
}
table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}
th, td {
  text-align: left;
padding: 12px 25px;
}
.profile-main{
  width: 750px;
  margin: 0 auto;
  border: 1px solid #aed5e2;
  padding-bottom: 10px;
}
.profile-header{
  height: 200px;
  width: 100%;
  background-color: #EBF6FA;
  border-bottom: 2px solid #E2F3FB;
}
.user-detail{
  position: relative;
  width: 75%;
  margin: 0 auto;
  height: 100%;
}
.user-image{
  float: left;
  position: relative;
  width: 23%;
  height: 135px;
}
.user-image img{
  width: 100%;
  height: 100%;
  border-radius: 50%;
  margin-top: 35px;
}
.prof-label{
  position: absolute;
  background: #8C13A0;
  color: #fff;
  padding: 9px 4px;
  border-radius: 50%;
  top: 155px;
  left: 42px;
  font-size: 12px;
}
.user-data{
  float: left;
  width: 46%;
  padding-left: 27px;
  margin-bottom: 20px;
}
.user-data h2{ 
  margin-bottom: 0px;
  margin-top: 35px;
  font-size: 20px;
  font-weight: 600;
}
.user-data .post-label{
  font-size: 10px;
  border: 1px solid #C3CECB;
  padding: 0px 4px;
  border-radius: 4px;
  background: #F3F5F5;
  margin-right: 5px;
}
.user-data .post-label:hover{
  background-color: #F8EDE7;
  border-color: #F2D4BA;
}
.user-data p{
  font-size: 12px;
  color: #404040;
}
.social-icons{
  float: right;
  width: 25%;
  text-align: right;
}
.social-icons i{
  margin-top: 35px;
  margin-bottom: 15px;
  color: #fff;
  padding: 5px 5px 1px 0px;
  border-radius: 50%;
  font-size: 11px;
  margin-right: 2px;
  height: 14px;
  width: 14px;
}
.social-icons .fa-facebook{
  background-color: #365597;
}
.social-icons .fa-twitter{
  background-color: #01B0F4;
}
.social-icons .fa-linkedin{
  background-color: #0F80BB;
}
.social-icons .fa-google{
  background-color: #D53B1F;
}
.social-icons .fa-instagram{
  background-color: #CF3594;
}
.msg-btn{ 
  background: #fff;
  padding: 5px 11px;
  color: black;
  text-decoration: none;
  font-size: 13px;
}
.msg-btn i{ 
  padding: 0;
  color: black;
  margin-right: 7px;
}
/*tab*/
.tab-panel-main{
  width: 85%;
  margin: 0 auto;
}
#Edu-detail th
{
width:55% !important;
}
ul.tabs{
  margin: 0px;
  padding: 0px;
  list-style: none;
  display: flex;
  position: absolute;
  top: 207px;
  right: 400px;
}
ul.tabs li{
  color: #222;
  display: inline-block;
  padding: 10px 15px;
  border-right: 1px solid #E2F3FB;
  border-top: 2px solid #E2F3FB;
  cursor: pointer;
  background: #FAFBFB;
}
ul.tabs li:last-child{
  border-right: 2px solid #E2F3FB;
}
ul.tabs li:first-child{
  border-left: 2px solid #E2F3FB;
}
ul.tabs li.current{
  background: #10A3FF;
  color: #fff;
  font-weight: 600;
}
.tab-content{
  display: none;
  padding: 15px 5px;
}
.tab-content.current{
  display: inherit;
}
.skill-box{
  border:1px solid #ededed;
  border-radius: 3px;
  padding: 11px 15px;
  margin-bottom: 20px;
}
.mark-table th, td {
    padding: 12px !important;
}
.skill-box ul li strong{
  font-size: 12px;
}
.skill-box ul{ 
  margin: 0;
  padding: 0;
  list-style: none;
}
.skill-box ul li{
  display: inline-block;
  font-size: 11px;
  margin-right: 4px;
  padding: 4px 4px;
  border-radius: 2px;
}
.skill-box ul li:hover{
  background-color: #FF6E00;
  color: #fff !important;
}
.skill-box ul li:first-child:hover{
  background-color: #fff;
  color: black !important;
}
.skill-box ul li i{
  margin-left: 4px;
  margin-right: 1px;
}
.bio-box{
  float: left;
  width: 56%;
  border:1px solid #ededed;
  border-radius: 4px;
}
tr:nth-child(even) {
background-color: #f2f2f2;
}
.detail-box{
  float: right;
  width: 32%;
  border:1px solid #ededed;
  padding: 13px;
  border-radius: 4px;
}
.bio-box .heading{
  padding: 10px 0px 10px 10px;
}
.bio-box .heading p{
  margin: 0px;
  font-weight: 600;
  font-size: 13px;
}
.bio-box .heading label{
  float: right;
  font-size: 9px;
  font-weight: normal;
  border: 1px solid #ededed;
  border-right: none;
  padding: 2px 1px 2px 5px;
}
.bio-box .desc{
  padding: 10px 10px 10px 10px;
  text-align: justify;
  color: #838383;
  font-size: 13px;
}
.detail-box{
  padding: 10px;
  font-size: 13px;
}
.detail-box p{
  font-weight: 600;
  margin: 0px;
}
.detail-box .ul-first{
  padding: 0px;
  list-style: none;
  float: left;
}
.detail-box .ul-second{
  float: left;
  list-style: none;
  color: #767676;
}
#Portfolio{
  float: left;
  padding-left: 0px;
  padding-right: 0px; 
  width: 100%;  
}
.portfolio-box{
  border: 1px solid #ededed;
  border-radius: 4px;
  padding: 0px 20px;
  float: left;
  height: 220px;
}
.portfolio-img-box{
  width: 30%;
  height: 145px;
  float: left;
  margin-right: 25px;
  border-radius: 3px;
}
.portfolio-img-box:last-child{
  margin-right: 0px;
}
.portfolio-img-box h3{
  text-align: center;
  color: #969696;
}
.portfolio-img-box img{
  border:1px solid #c1c1c1;
  width: 100%;
  height: 100%;
  padding: 2px;
}
#Edu-detail{
  float: left;
  padding-left: 0px;
  padding-right: 0px; 
  width: 100%;  
}
.Edu-box-main h2{
  margin: 0;
  margin-bottom: 0px;
  text-align: center;
  margin-bottom: 25px;
  color: #969696;
}
.Edu-box-main h2 i{
  color: #42A8BF;
}
.Edu-box-main{
  float: left;
  border-radius: 4px;
  border: 1px solid #ededed;
  padding: 10px 0px;
}
.Edu-box{
  width: 38%;
  float: left;
  margin-left: 20px;
  margin-right: 40px;
  margin-bottom: 10px;
  border-radius: 3px;
  border: 1px solid #E0E0E1;
  padding: 10px;
}
.Edu-box:last-child{
  margin-left: 0px;
  margin-right: 20px;
}
.Edu-box h5{
  margin: 0;
  font-weight: normal;
  font-weight: 600;
}
.Edu-box h5 span{
  color: #42A8BF;
  font-size: 15px;
}
.Edu-box p{
  padding: 10px 0px 0px 0px;
  text-align: justify;
  font-size: 13px;
  color: #8E8E8E;
  margin: 0;
}
.footer, .footer strong{
  text-align: center;
}
.footer p{
  margin-bottom: 0px;
}
.footer-box-main{
  width: 80%;
  background-color: red;
  margin: 0 auto;
}
.footer-box{
  height: 50px;
  width: 50px;
  border: 1px solid #939393;
  border-radius: 50%;
  display: inline-block;
  margin-right: 20px;
}
.footer-box:last-child{
  margin-right: 0px;
}
.footer-box i{
  line-height: 50px;
  font-size: 20px;
}
.footer-box .fa-facebook{
  color: #365597;  
}
.footer-box .fa-twitter{
  color: #01B0F4;  
}
.footer-box .fa-linkedin{
  color: #0F80BB;  
}
.footer-box .fa-google{
  color: #D53B1F;  
}
.footer-box .fa-instagram{
  color: #CF3594;  
}
#Basic-detail{
/*  height: 210px;   */
  float: left;
  padding-left: 0px;
  padding-right: 0px; 
  width: 100%;
}
@media (min-width: 320px) and (max-width: 640px){
  .profile-main{
    width: 100%;
  }
  .user-detail{
    width: 95%;
  }
  .user-image {
    width: 33%;
    height: 100px;
  }
  .user-data{
    width: 51%;
    margin-bottom: 27px;
  }
  .social-icons{
    width: 90%;
    float: left;
  }
  .social-icons i{
    margin-top: 0px;
  }
  .msg-btn{
    float: left;
    height: 18px;
    margin-right: 10px;
  }
  ul.tabs{
    width: 97%;
    font-size: 13.5px;
    right: 0px;
    top: 261px;
    left: 7px;
  }
  .profile-header{
    height: 250px;
  }
  .bio-box{
    width: 100%;
    margin-bottom: 10px;
  }
  .detail-box{
    width: 100%;
    float: left;
    padding: 0;
  }
  .detail-box p{
    padding: 10px;
    padding-bottom: 10px;
    padding-bottom: 0;
  }
  .detail-box ul.ul-first{
    padding-left: 10px;
  }
  .Edu-box{
    width: 80%;
    margin: 0px;
    margin-bottom: 0px;
    margin-left: 11px;
    margin-bottom: 15px;
  }
  .Edu-box:last-child{
    margin-left: 11px;
  }
  .portfolio-box, .portfolio-img-box{
    height: auto;
  }
  .portfolio-img-box{
    width: 100%;
  }
  .footer-box i{
    line-height: 40px;
  }
  .footer-box {
    height: 42px;
    width: 35px;
  }
  #Portfolio, #Edu-detail, #Basic-detail{
    height: auto;
  }
}
</style>
</body>
</html>