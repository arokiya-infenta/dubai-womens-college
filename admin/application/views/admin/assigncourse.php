<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

<?php
    $string = base_url();  
$search = 'admin';  
$replace = 'uploads';  
  
$newstr = str_replace($search, $replace, $string );  
 $newstr;
?>
      <!--Start Dashboard Content-->
	 

      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Assign  Course <a class="btn btn-primary"  data-toggle="modal" data-target="#myModal" style="float:right" href="">Status Update</a>
            <a class="btn btn-primary"  href="<?=base_url()?>Admin/editApplicant/<?=$applied[0]->pr_user_id?>" style="float:right; margin-right: 10px;" href="">Edit Record</a>
           <!-- <a class="btn btn-primary"  data-toggle="modal" data-target="#myModalDate" style="float:right; margin-right: 10px;" href="">Reschedule Date</a>-->
           
            <button id="cancel" style="float:right; margin-right: 10px;" data-direction="reverse" type="submit" class="btn btn-primary">Back</button></div>
           
            <div class="card-body">


 <div class=""> 
 <div class=""> 
                <ul class="nav nav-tabs nav-tabs-primary">
                  <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#tabe-1"><i class="icon-home"></i> <span class="hidden-xs"> Basic Details</span></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tabe-2"><i class="icon-user"></i> <span class="hidden-xs">Educational details</span></a>
                  </li>
                 
                  <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="tab" href="#tabe-3" ><i class="icon-settings"></i> <span class="hidden-xs"> Marks details</span></a>
                   
                  </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                  <div id="tabe-1" class="container tab-pane active">

                  <div class="row">
                  <div class="col-lg-4">
                  <div style="margin-bottom: 30px;">
          <img src="<?=$string?>/uploads/<?=$applied[0]->pr_photo?>" height="200px;" width="150px;" alt="Card image cap">
        
        </div>
        </div><div class="col-lg-8"></div>
        </div>



              
                         <div style="overflow-x:auto;">
                 <table class="table" id="myTable">
                 <tr>      
                 <th>Name</th>
                                 <td><?=$applied[0]->pr_applicant_name?></td>
                             </tr> 
                             
                             <tr>
                                 <th>Preferred First Course</th>
                                 <td><?php 
                                 $q = $this->db->select('*')->from('college_course')->where('cs_id',$applied[0]->pr_course_1)->get();
                                 $sub_1 = $q->result();
                                 if($sub_1){
                                   echo $sub_1[0]->cs_name;
                                   }
                               
                                 ?></td>
                             </tr>
                             <tr>
                                 <th>Preferred Second Course</th>
                                 <td><?php 
                                 $q = $this->db->select('*')->from('college_course')->where('cs_id',$applied[0]->pr_course_2)->get();
                                 $sub_2 = $q->result();
         
         
                                 if($sub_2){
                                 echo $sub_2[0]->cs_name;
                                 }
                                 ?></td>
                             </tr>
                             <tr>
                                 <th>Preferred Three Course</th>
                                 <td><?php 
                                 $q = $this->db->select('*')->from('college_course')->where('cs_id',$applied[0]->pr_course_3)->get();
                                 $sub_3 = $q->result();
                                 if($sub_3){
                                   echo $sub_3[0]->cs_name;
                                   }
                                 ?></td>
                             </tr>
                             <tr>
                                 <th>Language</th>
                                 <td><?=$applied[0]->pr_language?></td>
                             </tr>
                             <tr>
                                 <th>Date of Birth</th>
                                 <td><?=date('d-M-Y',strtotime($applied[0]->pr_dob))?></td>
                             </tr>
                             <tr>
                                 <th>Age</th>
                                 <td><?=$applied[0]->pr_age?></td>
                             </tr>
                             <tr>
                                 <th>Gender</th>
                                 <td><?=$applied[0]->pr_gender?></td>
                             </tr>
                             <tr>
                                 <th>Nationality</th>
                                 <td><?=$applied[0]->pr_nationality?></td>
                             </tr> 
                             <tr>
                                 <th>Religion</th>
                                 <td><?=$applied[0]->pr_religion?></td>
                             </tr>  <tr>
                                 <th>Caste</th>
                                 <td><?=$applied[0]->pr_caste?></td>
                             </tr>  <tr>
                                 <th>Community</th>
                                 <td><?=$applied[0]->pr_community?></td>
                             </tr>  
                         </table>
                         
                         <h4>Parent's / Guardian's Details</h4>
                         <table class="table" id="myTable">
                         <tr>
               <th>#</th>
               <th>Father</th>
               <th>Mother</th>
               <th>Guardian</th>
               
             <tr>
             <th>Name</th>
               <td><?=$applied[0]->pr_father_name?></td>
               <td><?=$applied[0]->pr_mother_name?></td>
               <td><?=$applied[0]->pr_gaurdion_name?></td>
               
             </tr>
             <tr>
             <th>Mobile No.</th>
             <td><?=$applied[0]->pr_father_mobnum?></td>
               <td><?=$applied[0]->pr_mother_mobnum?></td>
               <td><?=$applied[0]->pr_gaurdion_mobnum?></td>
              
              
             </tr>
             <tr>
             <th>Occupation</th>
             <td><?=$applied[0]->pr_father_accu?></td>
               <td><?=$applied[0]->pr_mother_accu?></td>
               <td><?=$applied[0]->pr_gaurdion_accu?></td>
              
              
             </tr>
             <tr>
             <th>Annual
         Income</th>
         <td><?=$applied[0]->pr_father_anuval_income?></td>
               <td><?=$applied[0]->pr_mother_anuval_income?></td>
               <td><?=$applied[0]->pr_gaurdion_anuval_income?></td>
              
              
             </tr>   
         
                         </table>
         
                         <h4>Address</h4>
                         <table class="table" id="myTable">
                         <tr>
               <th>#</th>
               <th>Local Address</th>
               <th>Permanant</th>
               
               
             <tr>
             <th>Address</th>
               <td><?=$applied[0]->pr_local_address?></td>
               <td><?=$applied[0]->pr_permanent_address?></td>
              
               
             </tr>
             <tr>
             <th>Area</th>
             <td><?=$applied[0]->pr_local_area?></td>
               <td><?=$applied[0]->pr_permanent_area?></td>
               
              
              
             </tr>
             <tr>
             <th>City</th>
             <td><?=$applied[0]->pr_local_city?></td>
               <td><?=$applied[0]->pr_permanent_city?></td>
              
             </tr>
             <tr>
             <th>State</th>
             <td><?=$applied[0]->pr_local_state?></td>
               <td><?=$applied[0]->pr_permanent_state?></td>
               
              
              
             </tr>    
             <tr>
             <th>Country</th>
             <td><?=$applied[0]->pr_local_country?></td>
               <td><?=$applied[0]->pr_permanent_country?></td>
              
              
             </tr>   
             <tr>
             <th>Pincode</th>
             <td><?=$applied[0]->pr_local_pincode?></td>
               <td><?=$applied[0]->pr_permanent_pincode?></td>
              
             </tr>   
         
                         </table>
                       
                         <h4>Identification Marks</h4>
                         <table class="table" id="myTable">
                          
                                
                             
                         
                          <tr>
                              <th>1</th>
                              <td><?=$applied[0]->pr_identification_one?></td>
                          </tr>
                          <tr>
                              <th>2</th>
                              <td><?=$applied[0]->pr_identification_two?></td>
                          </tr>
                        
                         
                      </table>
          
                      <h4>Differently Abled </h4>
                         <table class="table" id="myTable">
                          
                                
                             
                         <?php  if($applied[0]->pr_differently_abled == "" || $applied[0]->pr_differently_abled == NULL){echo"";}
                         
                         else if($applied[0]->pr_differently_abled=="NO"){
                   echo"<tr>
                   <th>No</th>
                   <td></td>
                   </tr>";
         
                         }else if($applied[0]->pr_differently_abled=="YES"){
         
                           echo"<tr>
                           <th>".$applied[0]->pr_differently_abled."</th>
                           <td>".$applied[0]->pr_differently_abled_reson."</td>
                           </tr>";
         
         
                         }
                            ?>
           
                      </table>
         
         </div>
         </div>
                  <div id="tabe-2" class="container tab-pane fade">
            
            <div style="overflow-x:auto;">
         
            <h4> Educational Details</h4>
			

    
   
            <table class="table edu-tbl" id="myTable">

                         

<?php  if($applied[0]->pr_sslc_mark =="" || $applied[0]->pr_sslc_mark ==Null){



echo"<tr><th>SSLC Mark Sheet</th><td>Not Uploded</td></tr>";



}else{







 echo"<tr><th>SSLC Mark Sheet</th><td><a target='_blank' href='".base_url()."uploads/".$applied[0]->pr_sslc_mark."'>Download</a></td></tr>";





}  ?>





<?php  if($applied[0]->pr_hse_certificate =="" || $applied[0]->pr_hse_certificate ==Null){



echo"<tr><th>Higher Secondary First Year Mark Sheet</th><td>Not Uploded</td></tr>";



}else{







 echo"<tr><th>Higher Secondary First Year Mark Sheet</th><td><a target='_blank' href='".base_url()."uploads/".$applied[0]->pr_hse_certificate."'>Download</a></td></tr>";





}  ?>







<?php  if($applied[0]->pr_hse2_certificate =="" || $applied[0]->pr_hse2_certificate ==Null){



echo"<tr><th>Higher Secondary Second Year Mark Sheet</th><td>Not Uploded</td></tr>";



}else{







 echo"<tr><th>Higher Secondary Second Year Mark Sheet</th><td><a target='_blank' href='".base_url()."uploads/".$applied[0]->pr_hse2_certificate."'>Download</a></td></tr>";





}  ?>





<?php  if($applied[0]->pr_comunity_cert =="" || $applied[0]->pr_comunity_cert ==Null){



echo"<tr><th>Community Certificate</th><td>Not Uploded</td></tr>";



}else{







 echo"<tr><th>Community Certificate</th><td><a target='_blank' class='text-right' href='".base_url()."uploads/".$applied[0]->pr_comunity_cert."'>Download</a></td></tr>";





}  ?>



<tr>

 <th> +2 Register No</th>

 <td><?=$applied[0]->pr_certificate_regist_numb?></td>

</tr>

</table>
                 <h4>School / Institution last attended</h4>
                    <table class="table" id="myTable">
                       <tr>
                         <th>Institution</th>
                         <td><?=$applied[0]->pr_institute_last_attanded?></td>
                     </tr>
                     <tr>
                         <th>Institution Name</th>
                         <td><?=$applied[0]->pr_insti_name?></td>
                     </tr>
                     <tr>
                         <th>Medium of Instruction (in+2)</th>
                         <td><?=$applied[0]->pr_medium_of_instruct?></td>
                     </tr>
                     <tr>
                         <th>Month and Year of Passing</th>
                         <td><?=$applied[0]->pr_month_year_pass?></td>
                     </tr>
                     <tr>
                         <th>Stream</th>
                         <td><?=$applied[0]->pr_Stream?></td>
                     </tr>
                     <tr>
                         <th>Passed in FIRST attempt</th>
                         <td><?=$applied[0]->pr_passed_in_first_attemt?></td>
                     </tr>
                      <tr>
                         <th>Break in Studies</th>
                         <td><?=$applied[0]->pr_break_in_syudy?></td>
                     </tr>
                     <tr>
                         <th> Reason</th>
                         <td><?=$applied[0]->pr_break_reason?></td>
                     </tr> 
                      <tr>
                         <th>Language Studied in School</th>
                         <td><?=$applied[0]->pr_languvage_studied?></td>
                     </tr>
                     <tr>
                         <th>Sports Category : Name of the Game(s)</th>
                         <td><?=$applied[0]->pr_name_of_game?></td>
                     </tr>
                     <tr>
                         <th>Position</th>
                         <td><?=$applied[0]->pr_game_position?></td>
                     </tr>
                      <tr>
                         <th>Extra - Curricular Activities</th>
                         <td><?=$applied[0]->pr_extra_caricular_act?></td>
                     </tr>
 </table>

    </div>      </div>
                  <div id="tabe-3" class="container tab-pane fade">
               

            <div style="overflow-x:auto;">
         
                    <h4>Marks</h4>
                    <table class="table" id="myTable">
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
                   <th>Status</th>
                   <th >Max. Marks</th>
                   <th>Marks Obtained</th>
                   <th>Class / Grade</th>
               </tr>
               <tr>
                   <td><?=$applied[0]->lang_1?></td>
                   <td ><?=$applied[0]->lang_1_max_mark_plus_1?></td>
                   <td><?=$applied[0]->lang_1_mark__obtained_plus_1?></td>
                   <td><?=$applied[0]->lang_1_class_grade_plus_1?></td>
                   <td><?=$applied[0]->lang_1_status?></td>
                   <td><?=$applied[0]->lang_1_max_mark_plus_2?></td>
                   
                   <td><?=$applied[0]->lang_1_mark__obtained_plus_2?></td>
                  
                   <td><?=$applied[0]->lang_1_class_grade_plus_2?></td>
               </tr>
               <tr>
               <td><?=$applied[0]->lang_2?></td>
                   <td ><?=$applied[0]->lang_2_max_mark_plus_1?></td>
                   <td><?=$applied[0]->lang_2_mark__obtained_plus_1?></td>
                   <td><?=$applied[0]->lang_2_class_grade_plus_1?></td>
                   <td><?=$applied[0]->lang_2_status?></td>
                   <td><?=$applied[0]->lang_2_max_mark_plus_2?></td>
                   <td><?=$applied[0]->lang_2_mark__obtained_plus_2?></td>
                    <td><?=$applied[0]->lang_2_class_grade_plus_2?></td>
               </tr>
               <tr>
                   <td><?=$applied[0]->subj_1?></td>
                   <td ><?=$applied[0]->subj_1_max_mark_plus_1?></td>
                   <td><?=$applied[0]->subj_1_mark__obtained_plus_1?></td>
                   <td><?=$applied[0]->subj_1_class_grade_plus_1?></td>
                   <td><?=$applied[0]->subj_1_status?></td>
                   <td><?=$applied[0]->subj_1_max_mark_plus_2?></td>
                  
                   <td><?=$applied[0]->subj_1_mark__obtained_plus_2?></td>
                  
                   <td><?=$applied[0]->subj_1_class_grade_plus_2?></td>
               </tr>
               <tr>
               <td><?=$applied[0]->subj_2?></td>
                   <td ><?=$applied[0]->subj_2_max_mark_plus_1?></td>
                   <td><?=$applied[0]->subj_2_mark__obtained_plus_1?></td>
                   <td><?=$applied[0]->subj_2_class_grade_plus_1?></td>
                   <td><?=$applied[0]->subj_2_status?></td>
                   <td><?=$applied[0]->subj_2_max_mark_plus_2?></td>
                  
                   <td><?=$applied[0]->subj_2_mark__obtained_plus_2?></td>
                  
                   <td><?=$applied[0]->subj_2_class_grade_plus_2?></td>
               </tr>
               <tr>
                   <td><?=$applied[0]->subj_3?></td>
                   <td ><?=$applied[0]->subj_3_max_mark_plus_1?></td>
                   <td><?=$applied[0]->subj_3_mark__obtained_plus_1?></td>
                   <td><?=$applied[0]->subj_3_class_grade_plus_1?></td>
                   <td><?=$applied[0]->subj_3_status?></td>
                   <td><?=$applied[0]->subj_3_max_mark_plus_2?></td>
                   <td><?=$applied[0]->subj_3_mark__obtained_plus_2?></td>
                   <td><?=$applied[0]->subj_3_class_grade_plus_2?></td>
               </tr> 
               <tr>
               <td><?=$applied[0]->subj_4?></td>
                   <td ><?=$applied[0]->subj_4_max_mark_plus_1?></td>
                   <td><?=$applied[0]->subj_4_mark__obtained_plus_1?></td>
                   <td><?=$applied[0]->subj_4_class_grade_plus_1?></td>
                   <td><?=$applied[0]->subj_4_status?></td>
                   <td><?=$applied[0]->subj_4_max_mark_plus_2?></td>
                   <td><?=$applied[0]->subj_4_mark__obtained_plus_2?></td>
                   <td><?=$applied[0]->subj_4_class_grade_plus_2?></td>
               </tr>
               <tr>
                   <td><?=$applied[0]->g_total?></td>
                   <td ><?=$applied[0]->g_total_max_mark_plus_1?></td>
                   <td><?=$applied[0]->g_total_mark__obtained_plus_1?></td>
                   <td><?=$applied[0]->g_total_class_grade_plus_1?></td>
                   <td></td>
                   <td><?=$applied[0]->g_total_max_mark_plus_2?></td>
                    <td><?=$applied[0]->g_total_mark__obtained_plus_2?></td>
                   <td><?=$applied[0]->g_total_class_grade_plus_2?></td>
               </tr>
               <tr>
                   <td><?=$applied[0]->m_total?></td>
                   <td ><?=$applied[0]->m_total_max_mark_plus_1?></td>
                   <td><?=$applied[0]->m_total_mark__obtained_plus_1?></td>
                   <td><?=$applied[0]->m_total_class_grade_plus_1?></td>
                   <td></td>
                   <td><?=$applied[0]->m_total_max_mark_plus_2?></td>
                   <td><?=$applied[0]->m_total_mark__obtained_plus_2?></td>
                   <td><?=$applied[0]->m_total_class_grade_plus_2?></td>
               </tr>
           </table>
         
      
      </div> </div>
                </div>
              </div>
              </div>
           </div>




        
           <div id="myModalDate" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title">Update Appointment</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       
      </div>
    <form method="post" action="<?=base_url()?>Admin/updateInterviewApplied">

      <div class="modal-body">
      <div class="modal-body">
       <label>Interview Date </label>
       <input type="date" name="int_date" required value="<?=date("Y-m-d",strtotime($schdate[0]->sa_interview_date))?>" class="form-control">
       <label>Interview Time </label>
       <input type="time" name="int_time" required value="<?=date("H:i", strtotime($schdate[0]->sa_interview_time))?>"  class="form-control">
    

       <input type="hidden" name="user_id" value="<?=$applied[0]->pr_user_id?>" >


<br>
<br>
       <input type="submit" name="submit" class="btn btn-info" value="submit">
      </div>


      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
</div>




<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title">Status Update</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       
      </div>
    <form method="post" action="<?=base_url()?>Admin/updateCourse">

      <div class="modal-body">
       <label class ="text-aa">Status </label>
      

       <select  required id="inter-status" name="status_one" class="form-control">
        <option value="">select</option>
        <option value="Interview attended">Interview attended</option>
        <option value="Rejected by Student">Rejected by Student</option>
        <option value="Rejected by Staff">Rejected by Staff</option>
        <option value="Approved">Approved</option>
        <option value="Interview not attended">Interview not attended</option>
    


     </select>






     <div class="menu" style="display: none;">
  


    <!-- <label  class ="text-aa">Assign Roll Number   </label>

                        <input type="text" class="form-control" name="rollnumber" id="rollnumber">-->




                        <label  class ="text-aa">Reschedule Interview Date </label>
       <input type="date" id="intdate" name="int_date" required value="<?=date("Y-m-d",strtotime($schdate[0]->sa_interview_date))?>" class="form-control">
       <label  class ="text-aa">Reschedule Interview Time </label>
       <input type="time" id="inttime" name="int_time" required value="<?=date("H:i", strtotime($schdate[0]->sa_interview_time))?>"  class="form-control">
 </div>









     <label  class ="text-aa">Comments   </label>
<textarea name="comments"  class="form-control">
</textarea>
    
     <label  class ="text-aa">Select Course   </label>
      




       <select id="course-assign"  name="course_one" class="form-control">
    <option value="">select</option>
    
<?php foreach($course as $val){?>
<option value="<?=$val->cs_id?>"><?=$val->cs_name?></option>

<?php } ?>

     </select>

 
     
     <input type="hidden" name="user_id" value="<?=$applied[0]->pr_user_id?>" >

<br>
<br>




       <input type="submit" name="submit" class="btn btn-info" value="submit">
      </div>


      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

        


          
<?php


//print_r($applied[0]);


?>





            </div>
          </div>
        </div>
      </div><!-- End Row-->






    </div>
    <!-- End container-fluid-->
    
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <style>
    label.text-aa {
    color: black;
    padding-top: 17px;
}

</style>