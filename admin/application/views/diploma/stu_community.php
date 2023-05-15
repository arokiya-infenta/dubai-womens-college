<style>
        .input-icons i {
            position: absolute;
        }
          
        .input-icons {
            width: 100%;
            margin-bottom: 10px;
        }
          
        .icon {
            padding: 10px;
            min-width: 40px;
        }
          
        .input-field {
            width: 100%;
            padding: 10px;
			padding-left:40px;
            text-align: left;
        }
    </style>
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">





      <!--Start Dashboard Content-->
	  
	  <div class="row">
        <div class="col-lg-12">
          <div class="card">
		  <div class="hide-it" align = "center" ><h4 style="color:#15ca20;"><?php echo $this->session->flashdata('success1'); ?></h4></div>
	      <div class="hide-it" align = "center" ><h4 style="color:#15ca20;"><?php echo $this->session->flashdata('form_err'); ?></h4></div>
            <div class="card-header"> Allot Zoom Link : </div>
            <div class="card-body">
			
			<form action="<?php echo base_url().'pgDiploma/stuCmnty'; ?>" method="post">
			  <div class="row">
			  <div class="col-lg-3">
			   <div class="form-group">
			   <label>Zoom Link</label>
			   <select class="form-control" name="link_id1" id="link_id">
			   <option value="">Select Link</option>
			   <?php foreach($sel_link as $slink) { ?>
			   <option value="<?php echo $slink->id; ?>" <?php if($slink->id==$linkid){echo 'selected';}?>><?php echo $slink->title; ?></option>
			   <?php } ?>
			   </select>
			   <span style="color:red;"><?php echo form_error('link_id1'); ?></span>
			   </div>
			     </div>
               <div class="col-lg-3">
			   <div class="form-group">
			   <label>Community</label>
			   <?php $commnity=array('OC','BC','BC(M)','MBC / DNC','MBC(V)','MBC','SC','SC(A)','ST'); ?>
			   <select class="form-control" name="community" id="community">
			   <option value="">Select Community</option>
			   <?php foreach($commnity as $cmnty1) { ?>
			   <option value="<?php echo $cmnty1 ?>" <?php if($cmnty==$cmnty1){echo 'selected';}?>><?php echo $cmnty1 ?></option>
			   <?php } ?>
			   </select>
			   <span style="color:red;"><?php echo form_error('community'); ?></span>
			   </div>
			   </div>
			   <div class="col-lg-3">
			   <div class="form-group">
			   <label>Quota</label>
			   <select class="form-control" name="quota" id="quota">
			   <option value="">Select Quota</option>
			   <option value="Merit" <?php if($quota=="Merit"){echo 'selected';}?>>Merit</option>
			   <option value="MGT" <?php if($quota=="MGT"){echo 'selected';}?>>MGT</option>
			   <option value="Disability" <?php if($quota=="Disability"){echo 'selected';}?>>Disabled</option>
			   <option value="Child of Ex-Service Man" <?php if($quota=="Child of Ex-Service Man"){echo 'selected';}?>>Child of Ex-Servicemen</option>
			   <option value="Sports" <?php if($quota=="Sports"){echo 'selected';}?>>Sports</option>
			   </select>
			   <span style="color:red;"><?php echo form_error('quota'); ?></span>
			   </div>
			   </div>
			   <div class="col-lg-3 mt-4">
			   <div class="form-group">
			   <button class="btn btn-sm btn-success" name="submit">Submit</button>
			   </div>
			   </div>
			  </div> 
			 </form> 
			  
			</div>
		   </div>
		</div>
	  </div>	
	 

	 <?php if(isset($stu_list)){?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
		  <form action="<?php echo base_url().'pgDiploma/zoom_alloc'; ?>" method="post">
            <div class="card-header">
			   <div class="row">
			   <input type="hidden" name="link_id" id="linkid" value="<?php echo $linkid; ?>">
			   <input type="hidden" name="community1" value="<?php echo $cmnty; ?>" id="community1">
			   <input type="hidden" name="quota1" value="<?php echo $quota; ?>" id="quota1">
				 <div class="col-lg-5 mt-4">
				 <div class="form-group input-icons">
				 <i class="fa fa-search icon"></i>
			  <input class="form-control input-field" type="text" id="search" placeholder="Type names to search" autocomplete="off" style="width: 300px;">
			     </div>
			     </div>
				 <div class="col-lg-3 mt-4">
				 <div class="form-group">
				 <!--<h5>Total Students : <?=$count?></h5>-->
			     </div>
			     </div>
				 <div class="col-lg-4 mt-4">
				 <div class="form-group" style="float:right;">
				 <button type="submit" class="btn btn-sm btn-primary" name="submit_link">Save Link</button>
			     </div>
			     </div>
			   </div>
			</div>
            <div class="card-body">

		
              <div class="table-responsive">
              <table id="examplezoomview" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S </th> 
                        <th>Student Name </th> 
                        <th>Reference No </th> 
                        <th>UG </th> 
                        <th>Entrance Mark </th> 
                        <th>Total Mark </th> 
                        <th>Community</th> 
                       
                    </tr>
                </thead>
                <tbody>
				<?php foreach($stu_list as $slist) { ?>


					<?php 
                    $ent =  $this->db->select("online_exam_pannel.*,sub_preview_dip.UG_two_percentage")->from("online_exam_pannel")->join("sub_preview_dip","sub_preview_dip.sb_u_id=online_exam_pannel.student_id","left")->Where("online_exam_pannel.student_id",$slist->pr_user_id)->Where("online_exam_pannel.exam_category",$this->Subject)->get();
					$app_no= $this->db->select("*")->from("Applyed_Cources")->Where("user_id",$slist->pr_user_id)->Where("applied_course_id",$dept)->where('main_course_id','4')->get()->row();
                      
                      $m = $ent->num_rows();
                      if($m > 0 ){

                          $mark  = $ent->result();
                          $ma_emt = $mark[0]->total_mark;
                          $cal = $mark[0]->total_mark;
                          $ugm = $mark[0]->UG_two_percentage;

                      }else{


                        $ma_emt = "A";
                        $cal = 0;
						$ugm = "";
                      }
                      $total =  $cal + (float)$ugm;

					  if($cal  !=0 ){
                      ?>
					  
                      <tr>
                        <td>
						<input type="checkbox" value="<?php echo $slist->pr_user_id; ?>" name="stu_id[]" style="width:25px;height:25px;"></td>
						<td>
						<?php echo $slist->pr_applicant_name; ?>
						</td>
					
					  <td><?=$app_no->application_number?></td>
					  <td><?=$ugm?></td>
                      
                      
                      <td><?=$ma_emt?></td>
                    
                      <td><?= number_format((float)$total, 2, '.', '')?></td>
                      <td><?php echo $slist->pr_community ?></td>
                    </tr>
					<?php }?>
				<?php } ?>	
               
                </tbody>
            </table>
            </div>
            </div>
			</form>
          </div>
        </div>
      </div>
	 <?php } ?>
	  <!-- End Row-->






    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

	  <script>
	   setTimeout(function() {
            $('.hide-it').hide('fast');
        }, 3000);
</script>
<script>
$(document).ready(function (){
	$(document).on('change','#community',function(){
		var comm=$(this).val();
		$('#community1').val(comm);
	});
	$(document).on('change','#link_id',function(){
		var linkid=$(this).val();
		$('#linkid').val(linkid);
	});
});
</script>
<script>
var $rows = $('#example1 tr');
$('#search').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
    
    $rows.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
});
</script>