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
            <div class="card-header">
			<form action="" method="post">
			   <div class="row">
			   <div class="col-lg-3 mt-4">
				 <select class="form-control" name="panel" id="panel" required>
				 <option value="">Select Panel</option>
				 <?php foreach($panel as $panel){?>
				 <option value="<?=$panel->id?>" <?php if($panel1 == $panel->id){echo 'selected';}?>><?=$panel->title?></option>
				 <?php } ?>
				 </select>
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
				 <button type="submit" class="btn btn-sm btn-success" name="submit" style="margin-left:20px;">Submit</button>
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
            <div class="card-header">
			   <div class="row">
				 <div class="col-lg-4 mt-4">
				 <div class="form-group">
				 <?php
				 if($limit != '' && $limit != 0){ 
				   $limt = $limit - $alloted;
				   $count1 = $limit;
				   $id = '';
				   $pcnt = $limit;
				}else{
					$limt = $count;
					$count1 = $count;	
				    $id = 'id="shortli1"';
					$pcnt = '-';
				}
				?>
				 <p style="line-height: 1.6;">Panel Count: <span <?php //$id?> style="float:right"><?=$pcnt?></span> <br/>Total No.of candidates appeared for Entrance Test: <span style="float:right"><?=$tot_stu?></span>  <br/>Total No.of Candidates Eligible for Interview: <span id="shortli" style="float:right"><?=$eligible?></span> <br/>Total No.of Candidates Not Eligible for Interview: <span id="not_shortli" style="float:right"><?=$not_eligible?></span> <br/>Total No.of Candidates Shortlisted for Interview: <span style="float:right"><?=$ll?></span> <br/>Total No.of Candidates Not Shortlisted for Interview: <span id="remaining" style="float:right"><?=$eligible - $ll?></span> <br/>Total No.of Candidates alloted for this Panel: <span style="float:right"><?=$alloted?></span><p>
			     </div>
			     </div>
				 <div class="col-lg-6 mt-4">
				 <div class="form-group" style="float:right;">
				 <input type="checkbox" id="ckbCheckAll" style="width:25px;height:25px;margin-top: 4px;"/>
				 </div>
				 </div>
				 <div class="col-lg-2 mt-4">
				 <div class="form-group" style="float:left;margin-left: -25px;">
				 <span style="font-weight:bold;">Select All</span>
				 <button type="submit" id="allocate" class="btn btn-sm btn-primary" name="submit_link" style="margin-left:20px;">Allocate</button>
			     </div>
			     </div>
			   </div>
			</div>
            <div class="card-body">

		
              <div class="table-responsive">
              <table id="wozoom" class="table table-bordered">
                <thead>
                    <tr>
                        <th></th> 
                        <th>SNo </th> 
                        <th>Student Name </th> 
                        <th>Application No </th> 
                        <th>UG </th> 
                        <th>Entrance Mark </th> 
                        <th>Total Mark </th> 
                        <th>Community</th> 
                       
                    </tr>
                </thead>
                <tbody>
				<?php foreach($stu_list as $slist) { ?>


					<?php 
                    $ent =  $this->db->select("online_exam_pannel.*,sub_preview_pg.UG_two_percentage")->from("online_exam_pannel")->join("sub_preview_pg","sub_preview_pg.sb_u_id=online_exam_pannel.student_id","left")->Where("online_exam_pannel.student_id",$slist->pr_user_id)->Where("online_exam_pannel.exam_category",$this->Subject)->get();
					$app_no= $this->db->select("*")->from("Applyed_Cources")->Where("user_id",$slist->pr_user_id)->Where("applied_course_id",$dept)->where('main_course_id','2')->get()->row();
                      
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
						<input class="checkBoxClass" type="checkbox" value="<?php echo $slist->pr_user_id; ?>" name="stu_id[]" style="width:25px;height:25px;"></td>
						<td></td>
						<td>
						<?php echo $slist->pr_applicant_name .'-'. $slist->pr_user_id; ?>
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
<script>
var base_url = "<?php echo base_url(); ?>";
	$(document).ready(function(){
   var pageLength = '<?=$limt?>';	
var myTable = $('#wozoom').DataTable({
	"aaSorting": [[ 6, "desc" ]],
	"fnRowCallback" : function(nRow, aData, iDisplayIndex){
                $("td:nth-child(2)", nRow).html(iDisplayIndex +1);
                //$(nRow).css("textAlign", "center");
               return nRow;
            },
	});
var allPages = myTable.rows().nodes().to$();

var rowCount = allPages.length;
 //$('#shortli').text(rowCount);
 //$('#shortli1').text(rowCount);
var not_shortli = <?=$count?> - rowCount; 
 //$('#not_shortli').text(not_shortli);
var remaining =  rowCount - <?=$ll?>;
 //$('#remaining').text(remaining);
 
		allPages.each(function(index, element) {
			if(index > (pageLength - 1)){
		myTable.row($(this)).remove().draw();
			}
		});
		
		$('#allocate').click(function(e){
		var ids_student=Array();	
		var panel='<?=$panel1?>';	
			allPages.each(function(){
			$(this).closest('tr').find('td:eq(0) input[class=checkBoxClass]:checked').each(function(){
            ids_student.push($(this).val());
            });
		});
			if(panel == ''){
				alert('Please select a Panel!');
				exit;
			}
			if(ids_student.length === 0){
				alert('Please select at least 1 student!');
				exit;
			}
		if (confirm('Are you sure to allocate the students?')) {
            $.ajax({
                url: base_url + "pgMswAided/panelAllocation",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    ids_student: ids_student,
                    panel: panel,
                },
                success: function (data) {
                }
            });
					alert('Students Allocated Successfully!!');
					location.reload();
			}
		});
		
	$("#ckbCheckAll").click(function () {
		var ele = $(this);
      $(".checkBoxClass",allPages).each(function(index){
		  if(index < pageLength){
	  $(this).prop('checked', ele.prop('checked'));
		  }
	  });
    });

	
	});
	</script>