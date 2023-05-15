<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



      <!--Start Dashboard Content-->
	 

			
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
            <div class="card-header"><i class="fa fa-file-text"></i> Interviewed List</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="example"  style="width: 650px;" class="table table-bordered table-hover">
                <thead>
                    <tr>
                    <th>Candidate Name </th>
                       
                       <th>Application Number </th>
                    <!--   <th>Mobile</th>-->
                       <th>Date Of Birth</th>
                       <th>Gender</th>
                       <th>Reservation  Status</th>

                      
                     
                       <th>UG Percentage</th>
                       <th>Entrance Mark</th>
                       <th>Interview Mark</th>
                       <th>Total Mark</th>
                       <th>Original Community </th>
                       <th>Verified Community </th>
                       <th>Old Verified  Status</th>
                       <th>New Verified  Status</th>
                       <th>Action</th>
                      
                     
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php 
                    
          
                    $dep =array(
                      '4'=>"MSW-AIDED",
                      '5'=>"MSW-SF",
                      '6'=>"MAHRM",
                      '7'=>"MAHROD",
                      '10'=>"MSCCF",
                      '8'=>"MADM",
                      '9'=>"MASE",
                      '11'=>"MSW DE",
                      '12'=>"MSW-AIDED",
                      '13'=>"MSW-AIDED",
                      '14'=>"MSW-SF",
                      '15'=>"MSW-SF",
                    );
   




                    foreach ($student as $key => $value) { 
                      
                      
                      $total = number_format((float)$value->ug_mark, 2, '.', '') + number_format((float)$value->enterence_mark, 2, '.', '') +number_format((float)$value->personal_mark, 2, '.', '')
                      
                
                      ?>
                        <tr>
                        <td><a href="<?=base_url()?>PgMswAided/viewStudent/<?=$value->u_id?>"><?=$value->pr_applicant_name?> </a></td>
                        <td><?=$value->application_number?></td>
                      <!--  <td><?=$value->u_mobile?></td>-->
                        <td><?=date("d-m-Y",strtotime($value->pr_dob))?></td>
                        <td><?=$value->pr_gender?></td>
                        <td><?php if($value->pr_other_res =="Yes"){
echo $value->pr_other_special_reservation;

                      }else{
                        echo "No";
                      }?></td>
                      
                     
                      <td><?=$value->ug_mark?></td>
                      
                      
                      <td><?=$value->enterence_mark?></td>
                      <td><?=$value->personal_mark?></td>
                    
                      <td><?= number_format((float)$total, 2, '.', '')?></td>

                      <td><?=$value->pr_community?></td>
                      <td><?=$value->community?></td>
                                      
                      <td><?php if($value->verified_status == 0){


echo"<p style='color: red'> Not Verified </p>";

                        }else{

                          echo"<p style='color: green'>Already Verified By : ".  $dep[$value->verified_by_user]." as ".$value->UG_two_percentage." %</p>"; }?></td>
                      <td><?php if($value->dep_verified == 1) {
                        echo "<p style='color:green'>Verified</p>";
                      }else{
                        echo "<p style='color:red'>Not Verified</p>";
                      } ?></td>
                  <td><button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal<?=$key?>">Update</button></td>
           
                       
                    </tr>


                    <div id="myModal<?=$key?>" class="modal fade" role="dialog">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Percentage for <?=$value->pr_applicant_name?> :<?php if($value->verified_status == 0){


echo"<p style='color: red'> Not Verified </p>";

                        }else{

                          echo"<p style='color: green'>Already Verified By : ".  $dep[$value->verified_by_user]." as ".$value->UG_two_percentage." %</p>"; }?>

</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form method = "POST" action="<?=base_url()?>PgMswAided/updateByDepartment">
      <div class="modal-body">
      
   
      <div class="row">
					 <div class="col-md-6 "> UG Percentage :</div>
					 <div class="col-md-6 "> <input type="text" class="form-control" name="percentage" value = "<?=$value->ug_mark?>"></div>
     <input type="hidden" name="up_id" value="<?=$value->m_id?>">
     

      </div>
      
      <div class="row">
    
    

    <div class="col-md-12">
    <label class="col-form-label " required for="recipient-name">Community </label><br>
    <label class="radio-inline">
        <input type="radio" name="Community" required <?php if($value->pr_community=="OC"){echo"checked";} ?> value="OC" > OC
      </label>
      <label class="radio-inline">
        <input type="radio" name="Community" required <?php if($value->pr_community=="BC"){echo"checked";} ?>  value="BC" > BC
      </label>
      <label class="radio-inline">
        <input type="radio" name="Community" required <?php if($value->pr_community=="BC(M)"){echo"checked";} ?> value="BC(M)" > BC(M)
      </label>
      <label class="radio-inline">
        <input type="radio" name="Community" required <?php if($value->pr_community=="MBC / DNC"){echo"checked";} ?> value="MBC / DNC" > MBC / DNC
      </label> 
      
      
      <label class="radio-inline">
        <input type="radio" name="Community" required <?php if($value->pr_community=="MBC(V)"){echo"checked";} ?> value="MBC(V)" > MBC(V)
      </label>  
      
      <label class="radio-inline">
        <input type="radio" name="Community" required <?php if($value->pr_community=="MBC"){echo"checked";} ?> value="MBC" > MBC
      </label>
   
      <label class="radio-inline">
        <input type="radio" name="Community" required <?php if($value->pr_community=="SC"){echo"checked";} ?> value="SC" > SC
      </label>
      <label class="radio-inline">
        <input type="radio" name="Community" required <?php if($value->pr_community=="SC(A)"){echo"checked";} ?> value="SC(A)" > SC(A)
      </label>
   
      <label class="radio-inline">
        <input type="radio" name="Community" required <?php if($value->pr_community=="ST"){echo"checked";} ?> value="ST" > ST
      </label>
      
     
    </div>
   </div>
      
      
     
       
      
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary">Update</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>






                    <?php } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                <th>Candidate Name </th>
                       
                       <th>Application Number </th>
                    <!--   <th>Mobile</th>-->
                       <th>Date Of Birth</th>
                       <th>Gender</th>
                       <th>Reservation  Status</th>

                      
                     
                       <th>UG Percentage</th>
                       <th>Entrance Mark</th>
                       <th>Interview Mark</th>
                       <th>Total Mark</th>
                       <th>Original Community </th>
                       <th>Verified Community </th>
                       <th>Old Verified  Status</th>
                       <th>New Verified  Status</th>
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
    