<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

        <div class="row">
					 <div class="col-md-2 "></div>
					 <div class="col-md-8 ">
					  <?php if(!empty($this->session->flashdata('message'))){

echo $this->session->flashdata('message');

            } ?>
					 </div>
					 <div class="col-md-2 "></div>
					</div>	

      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"> 
            <div class="row">
        
            <div class="col-lg-4"><i class="fa fa-file-text"></i> Publish Details</div>
            <div class="col-lg-4">
              
        
          </div>
            <div class="col-lg-4">    
            <form id="target" action="<?=base_url()?>PgMswAided/publishResult">
         <button type="submit" id="allsele_pdf" class="text-right btn btn-success" >Publish</button> 
          </form>

</div>
        
           
          </div>
          </div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="shortlisted"   class="table table-bordered table-hover">
                <thead>
                <tr>
								<th>S.No</th>
                                           
                                           <th>Application Number</th>
                                           <th>Candidate Name</th>
                                           <th>Date of Birth </th>
                                           <th>Total Marks</th>
                                           <th>Reservation</th>
                                           <th>Community</th>
                                           <th>Selection Status</th>
                                           <th>Selection List</th>
                                           <th>Principal Approval</th>
                                           <th>Publish Details</th>
                                           <th>Action</th>
                                          
                                           
                                        </tr>
                    </tr>
                </thead>
                <tbody>


                    
                    <?php 
            


                                   //   print_r($dep); 

$i=1;


                    foreach ($student as $key => $value) { 
                      
                      
                      
                   
                      ?>
                        <tr>
                        <td><?=$i?>  <!--<input type="hidden" name="publishedstatus[]" value="<?=$value->sl_id?>" id="isAgeSelected"/>--> </td>
                        <td><?=$value->application_number?></td>
                        <td><a href="#"><?=$value->pr_applicant_name?> </a></td>
                       
                        <td><?=date("d-m-Y",strtotime($value->pr_dob))?></td>
                
                        
                        <td><?=sprintf ("%.2f",$value->total_mark)?></td>
                        <td><?=$value->selection_list_name?></td>

                        <td><?=$value->pr_community?></td>
                       

                        <td>
                          
                          
                          <?php
                          if($value->reservation_status == 1) { echo"Selected"; }else if($value->reservation_status == 2){ echo"Waiting"; }else{ echo"rejected";}?>
                        </td>          
                        
                        
                        
                        <td>
                          
                          
                          <?php
                          if($value->selection_list == 1) { echo"First List"; }else if($value->selection_list == 2){ echo"Second List"; }
                          else if($value->selection_list == 3){
                             echo"Third List";
                             }else if($value->selection_list == 4){
                             echo"Fourth List";
                             }else if($value->selection_list == 5){
                             echo"Fifth List";
                             }else if($value->selection_list == 6){
                             echo"Sixth List";
                             }else if($value->selection_list == 7){
                             echo"Seventh List";
                             }else if($value->selection_list == 8){
                             echo"Eigth List";
                             }else if($value->selection_list == 9){
                             echo"Ninth List";
                             }else if($value->selection_list == 10){
                             echo"Tenth List";
                             };
                             
                             ?>
                        </td>
                       <td><?php   if($value->principal_published == 1) { echo"<p style='color:green'>Approved</p>"; }else if($value->principal_published == 0){ echo"<p style='color:red'>Not Approved</p>"; }; ?></td>
                        <td><?php   if($value->published == 1) { echo"<p style='color:green'>Published</p>"; }else if($value->published == 0){ echo"<p style='color:red'>Not Published</p>"; };  ?></td>
                 
                      
                      
                      
                      
                        <?php if($value->reservation_status == 1 && $value->principal_published == 1 ){ ?>
                      <td><button class="btn btn-primary m-1" data-toggle="modal" data-target="#largesizemodal-<?=$value->sl_id?>" type="submit" value="<?=$value->sl_id?>" ><i class="fa fa-check" aria-hidden="true"></i></button>
                    
                    
                      <div class="modal fade" id="largesizemodal-<?=$value->sl_id?>">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title"> <?php 
  if($this->session->userdata("user")["user_dep_status"] == 1){


    $dep ="MSWAC";
}else if($this->session->userdata("user")["user_dep_status"] == 2){

    $dep ="MSWAM";
}else if($this->session->userdata("user")["user_dep_status"] == 3){

  $dep ="MSWAH";
}

                  
                       $m =  $this->db->select('*')->from('admitted_student')->where('as_quata',$value->selection_list_name)->where('as_dep',$dep)->get();
                        
                        $n = $m->num_rows();



                        $s =  $this->db->select('*')->from('admitted_student')->where('as_student_id',$value->sl_student_id)->where('as_reg_num !=',null)->where('as_dep',$dep)->get();
                        
                         $t = $s->num_rows();


if($t == 1){

  $st = "<p style='color:green;'>Register Number Assigned Allready</p>";

}else{

  $st = "";

}
                        
                        ?>Admitted in <?=$value->selection_list_name?> ( <?=$n?> ) <br> <?=$st?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form method="POST" action="<?=base_url()?>PgMswAided/admitStudent">
                      <div class="modal-body">


                      <div class="row">
                      <div class="col-md-8">
                      <!--<label>Register Number</label>
                       <input type="text" class="form-control" name="regnumber">-->
                       <label>Student Name</label>
                       <input type="text" class="form-control" value="<?=$value->pr_applicant_name?>" name="name">
                        <label>Application Number</label>
                       <input type="text" class="form-control" readonly value="<?=$value->application_number?>" name="app_number">
                       <label>Reservation</label>
                       <select class="form-control" name="reservation" id="sel1">
    <option value = "" >Select Option</option>

 

           <?php 
           foreach ($reservation as $key => $values) { ?>
            <option  <?php  if($value->selection_list_name == $values->rs_name ){ echo"selected";}  ?>  value="<?=$values->rs_name?>"><?=$values->rs_name?></option>
        <?php   }
           
           
           ?>
           </select>  
                       <label>Date Of Birth</label>

                       <input type="text" readonly class="form-control" value="<?=$value->pr_dob?>" name="dob"> 
                       <label>Blood Group</label>

                       <input type="text" readonly class="form-control" value="<?=$value->pr_blood_group?>" name="blood_grp">


                       <label>Address</label>

<text type="text"  class="form-control" value="<?=$value->pr_permanent_address?>" name="app_address"><?=$value->pr_permanent_address?></text>



                       <input type="hidden" name="student_photo" value="<?=$value->pr_photo?>">
                       <input type="hidden" name="student_short_id" value="<?=$value->sl_id?>">
                       <input type="hidden" name="student_id" value="<?=$value->sl_student_id?>">
                      </div>
                      <div class="col-md-4">
                      <label>Student Photo</label>  
                      <img src="<?=base_url()?>/uploads/<?=$value->pr_photo?>" ></div>
                      </div>
                      <div class="modal-footer">
                       
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i>Admit Student</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                      </div>
                      



                      </div>
                      </form>
                    </div>
                  </div>
                </div>
                    
                </td>
                    
                    <?php }else{ ?>
<td><button type="submit" value="<?=$value->sl_id?>" class="btn btn-danger"><i class="fa fa-ban" aria-hidden="true"></i></button></td>

                     <?php  } ?>

                    





                       
                    </tr>









                    <?php $i++; } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
								<th>S.No</th>
                                           
                                           <th>Application Number</th>
                                           <th>Candidate Name</th>
                                           <th>Date of Birth </th>
                                           <th>Total Marks</th>
                                           <th>Reservation</th>
                                           <th>Community</th>
                                           <th>Selection Status</th>
                                           <th>Selection List</th>
                                           <th>Principal Approval</th>
                                           <th>Publish Details</th>
                                           <th>Action</th>
                                           
                                        </tr>
                </tfoot>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>
	
    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
$(document).ready(function(){
 

});
    
    
    </script>
