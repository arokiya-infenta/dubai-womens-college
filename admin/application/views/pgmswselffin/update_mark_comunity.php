
  <div class="clearfix"></div>
	
    <div class="content-wrapper">
      <div class="container-fluid">
                  
  
  
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <form method="post" action="<?=base_url()?>PgMswSelfFin/updatePGPer">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Mark and Community</h5>
     
      </div>
      <div class="modal-body">
     
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">UG Percentage:</label>
            <input type="text" class="form-control" name="ug_percentage" required id="recipient-name" value="<?=$percent[0]->UG_two_percentage?>">
          </div>
          <div class="form-group">
        <input type ="hidden" name="student_id" value="<?=$comm_cer[0]->pr_user_id?>">
  <label class="col-form-label " required for="recipient-name">Community </label>
  <div class="col-md-12">
  <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($comm_cer[0]->pr_community=="OC"){echo"checked";} ?> value="OC" > OC
    </label>
    <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($comm_cer[0]->pr_community=="BC"){echo"checked";} ?>  value="BC" > BC
    </label>
    <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($comm_cer[0]->pr_community=="BC(M)"){echo"checked";} ?> value="BC(M)" > BC(M)
    </label>
    <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($comm_cer[0]->pr_community=="MBC / DNC"){echo"checked";} ?> value="MBC / DNC" > MBC / DNC
    </label> 
    
    
    <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($comm_cer[0]->pr_community=="MBC(V)"){echo"checked";} ?> value="MBC(V)" > MBC(V)
    </label>  
    
    <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($comm_cer[0]->pr_community=="MBC"){echo"checked";} ?> value="MBC" > MBC
    </label>
 
    <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($comm_cer[0]->pr_community=="SC"){echo"checked";} ?> value="SC" > SC
    </label>
    <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($comm_cer[0]->pr_community=="SC(A)"){echo"checked";} ?> value="SC(A)" > SC(A)
    </label>
 
    <label class="radio-inline">
      <input type="radio" name="Community" required <?php if($comm_cer[0]->pr_community=="ST"){echo"checked";} ?> value="ST" > ST
    </label>
    
   
  </div>
  </div>

            <label for="recipient-name" class="col-form-label">Community Certificate:</label>
           
<?php if($comm_cer[0]->pr_community_cer !="" || $comm_cer[0]->pr_community_cer !=NULL){ ?>


<?php

echo "<br><a target='_blank'  href='".base_url()."PgMswAided/UploadFile?file=".urlencode($comm_cer[0]->pr_community_cer)."'>Download Certificate</a>";
echo "<br><a target='_blank'  href='".base_url()."uploads/".$comm_cer[0]->pr_community_cer."'>View Certificate</a>";


?>

<?php }else{


echo"Not Uploded";



} ?>   

      </div>
      <div class="modal-footer">
      
        <button type="submit" class="btn btn-primary">Update</button>
        
      </div>
      </form>
    </div>
  </div>
  </div>
  </div>
 

