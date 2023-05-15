
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

      <!--Start Dashboard Content-->
	  
	  <!--Start Row-->
	  
	   <div class="row">
        <div class="col-lg-12">
		<div class="hide-it" align="center"><h4 style="color:#15ca20;"><?php echo $this->session->flashdata('success'); ?></h4></div>
		<?php $this->session->set_flashdata('success',''); ?>
		<div class="hide-it" align="center"><h4 style="color:#8B0000;"><?php echo $this->session->flashdata('form_err'); ?></h4></div>
		<?php $this->session->set_flashdata('form_err',''); ?>
          <div class="card">
		  <div class="card-header"><i class="fa fa-table"></i>Student Details</div>
            <div class="card-body">
			
			<form action="" method="post">
			   <div class="row">
			   <div class="col-lg-3">
			<label>Applied Year</label>   
			<select class="form-control" name="applied_year" id="applied_year" required>
			<option value="">Select Year</option>
			<?php $batch = $this->db->get('erp_batchmaster')->result();
			foreach($batch as $batch2){?>
			<option value="<?=$batch2->batch_from?>" <?php if($applied_year1==$batch2->batch_from){echo 'selected';}?>><?=$batch2->batch_from?></option>
			<?php } ?>
			</select>
		         </div>
				 <div class="col-lg-3">
			<label>Applied Sem</label>   
			  <select class="form-control" id="applied_sem" name="applied_sem" required>
			  <option value="">Select Semester</option>
			  <?php $applied_sem = array('1','2','3','4','5','6','PRIVATE');
			  foreach($applied_sem as $applied_sem){ ?>
			  <option value="<?=$applied_sem?>" <?php if($applied_sem1==$applied_sem){echo 'selected';}?>><?=$applied_sem?></option>
			  <?php } ?>
			  </select>
			  </div>
			   <div class="col-lg-3">
			<label>Batch</label>   
			<select class="form-control" name="batch" id="batch" required>
			<option value="">Select Batch</option>
			<?php
			foreach($batch as $batch){?>
			<option value="<?=$batch->batch_from?>" <?php if($batch1==$batch->batch_from){echo 'selected';}?>><?=$batch->batch_from?></option>
			<?php } ?>
			</select>
		         </div>
			  <div class="col-lg-3">
			<label>Semester</label>   
			  <select class="form-control" id="sem" name="sem" required>
			  <option value="">Select Semester</option>
			  <?php $sem = array('1','2','3','4','5','6');
			  foreach($sem as $sem){ ?>
			  <option value="<?=$sem?>" <?php if($sem1==$sem){echo 'selected';}?>><?=$sem?></option>
			  <?php } ?>
			  </select>
			  </div>
				 <div class="col-lg-3">
			<label>Stream</label>   
			<select class="form-control" name="stream" id="stream" required>
			<option value="">Select Stream</option>
			<option value="5" <?php if($stream=='5'){echo 'selected';}?>>UG</option>
			<option value="2" <?php if($stream=='2'){echo 'selected';}?>>PG - MSW Aided</option>
			<option value="1" <?php if($stream=='1'){echo 'selected';}?>>PG - Self Finance</option>
			<option value="3" <?php if($stream=='3'){echo 'selected';}?>>PG - MSW Self Finance</option>
			<option value="4" <?php if($stream=='4'){echo 'selected';}?>>PG Diploma</option>
			</select>
		         </div>
				 <div class="col-lg-3">
			<label>Department</label>   
			<select class="form-control" name="department" id="department" required>
			<option value="">Select Department</option>
			<?php if(isset($department)){ $dept = $this->db->where('main_id',$stream)->get('department_details')->result();
			foreach($dept as $dept){?>
			<option value="<?=$dept->cour_id?>" <?php if($department==$dept->cour_id){echo 'selected';}?>><?=$dept->comp_name?></option>
			<?php }} ?>
			</select>
		         </div>
				 <div class="col-lg-3" id="sub" >
			<label>Subject</label>   
			  <select class="form-control" id="subject" name="subject" required>
			  <option value="">Select Subject</option>
			  <?php if(isset($subject1) && $subject1!=''){ $subject = $this->db->where('batch_year',$batch1)->where('sem',$sem1)->where('stream',$stream)->where('department',$department)->get('erp_subjectmaster')->result();
			  foreach($subject as $subject){ ?>
			  <option value="<?=$subject->id?>" <?php if($subject1==$subject->id){echo 'selected';}?>><?=$subject->subName?></option>
			  <?php }} ?>
			  </select>
			  </div>
				 <div class="col-lg-3 mt-4">
			<button type="submit" class="btn btn-sm btn-success" name="submit">Submit</button>
		         </div>
		        </div>
            </form>				
		
			</div>
		   </div>
         </div>
        </div>		 
			
	  <?php if(isset($stu_list)){
		  ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
		  <div class="card-header">
		  <button type="button" class="btn btn-sm btn-success" id="internal_submit">Save Internal</button>
		  <button type="button" class="btn btn-sm btn-success" id="external_submit">Save External</button>
		  <button type="button" class="btn btn-sm btn-success" id="thirdparty_submit">Save ThirdParty</button>
		  <!--<button type="button" class="btn btn-sm btn-success" id="average_submit">Save Average</button>-->
		  </div>
            <div class="card-body">
			<div class="row">
			  <span style="color:red;">*Null values will not be saved!</span>
			  </div><br/>
              <div class="table-responsive">
              <table id="exammarksarr-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Name</th>
                        <th>Internal Valuation</th>
                        <th>External Valuation</th>
                        <th>Third Party Valuation</th>
                       
                       
                    </tr>
                </thead>
                <tbody>   
                    <?php $sno=1;
					foreach ($stu_list as $student) {
						$mark_det = $this->db->where('batch_year',$batch1)->where('sem',$sem1)->where('student_id',$student->id)->where('subject_id',$subject1)->where('arrear_status',1)->where('arrear_applied_year',$applied_year1)->get('erp_exammarkfinal')->row();
						if(isset($mark_det)){
						if($mark_det->internal!=''&&$mark_det->internal!=null){$checked2='checked';$readonly2='';$mark2=$mark_det->internal;}else{$checked2='';$readonly2='readonly';$mark2='NULL';}
						if($mark_det->external!=''&&$mark_det->external!=null){$checked3='checked';$readonly3='';$mark3=$mark_det->external;}else{$checked3='';$readonly3='readonly';$mark3='NULL';}
						if($mark_det->thirdparty!=''&&$mark_det->thirdparty!=null){$checked4='checked';$readonly4='';$mark4=$mark_det->thirdparty;}else{$checked4='';$readonly4='readonly';$mark4='NULL';}
						}
						else{
							$checked2='';$readonly2='readonly';$mark2='NULL';
							$checked3='';$readonly3='readonly';$mark3='NULL';
							$checked4='';$readonly4='readonly';$mark4='NULL';
							}
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$student->student_name_?></td>
						<td>
						<!--<input type="checkbox" data-student="<?=$student->id?>" class="internal" style="width:20px;height:20px;" <?=$checked2?>>-->
						<input type="text" class="form-control intval" data-student="<?=$student->id?>" value="<?=$mark2?>">
						</td>
						<td>
						<!--<input type="checkbox" data-student="<?=$student->id?>" class="external" style="width:20px;height:20px;" <?=$checked3?>>-->
						<input type="text" class="form-control extval" data-student="<?=$student->id?>" value="<?=$mark3?>">
						</td>
						<td>
						<!--<input type="checkbox" data-student="<?=$student->id?>" class="thirdparty" style="width:20px;height:20px;" <?=$checked4?>>-->
						<input type="text" class="form-control tpval" data-student="<?=$student->id?>" value="<?=$mark4?>">
						</td>
                    </tr>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
	   setTimeout(function() {
            $('.hide-it').hide('fast');
        }, 3000);
</script>
<script>
var base_url = "<?php echo base_url(); ?>";
	$(document).ready(function(){
var myGlyph = new Image();
     myGlyph.src = base_url + 'system/images/logo1.png';

	function getBase64Image(img) {
    var canvas = document.createElement("canvas");
    canvas.width = img.width;
    canvas.height = img.height;
    var ctx = canvas.getContext("2d");
    ctx.drawImage(img, 0, 0);
    return canvas.toDataURL("image/png");
    }
	var fullDate = new Date()
    //var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
    var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : (fullDate.getMonth()+1);
    var currentDate = fullDate.getDate() + "_" + twoDigitMonth + "_" + fullDate.getFullYear();
	
//var myTable = $('#exammarks-datatable').DataTable();

var myTable = $('#exammarksarr-datatable').DataTable({ 
		"bSortCellsTop": true,
			dom: 'Bfrtip',
			buttons: 
			[{ 
				extend: 'excelHtml5',
				title: 'ESE Arrear ' + currentDate + '',
				//text:'<i class="fa fa-table fainfo" aria-hidden="true" > Excel</i>',
                "oSelectorOpts": {filter: 'applied', order: 'current'},
				filename: 'ESE Arrear_ '+currentDate+'',
				orientation:'landscape',
				exportOptions: {
				 columns: [0,1, 2, 3, 4],
				 format: {
              body: function ( inner, rowidx, colidx, node ) {
                if ($(node).children("input").length > 0) {
                  return $(node).children("input").first().val();
                } else {
                  return inner;
                }
			  }
				 }
                }
			},
			{ 
				extend: 'pdfHtml5', 
				filename: 'ESE Arrear_'+currentDate+'',
				exportOptions: {
					columns: [0, 1, 2, 3, 4],
				 format: {
              body: function ( inner, rowidx, colidx, node ) {
				  if ($(node).children("input").length > 0) {
                  return $(node).children("input").first().val();
                } else {
                  return inner;
                }
              }
				 }
				},
				orientation:'landscape',
				pageSize: 'A4', 
                alignment: "center",
				customize: function (doc) {
					doc.content[1].margin = [ 100, 0, 100, 0 ] //left, top, right, bottom
					 
				        var objLayout = {};
                        objLayout['hLineWidth'] = function(i) { return .13; };
                        objLayout['vLineWidth'] = function(i) { return .13; };
                        objLayout['hLineColor'] = function(i) { return '#aaa'; };
                        objLayout['vLineColor'] = function(i) { return '#aaa'; };
                        objLayout['paddingLeft'] = function(i) { return 4; };
                        objLayout['paddingRight'] = function(i) { return 4; };
                        objLayout['paddingTop'] = function(i) { return 4; };
                        objLayout['paddingBottom'] = function(i) { return 4; };
                        doc.content[1].layout = objLayout;
                        var obj = {};
                        obj['hLineWidth'] =  function(i) { return .13; };
                        obj['hLineColor'] = function(i) { return '#aaa'; };
					doc.content.splice( 0, 0, {
                        margin: [ 0, -35, 0, 15 ],
                        alignment: 'left',
                        image: getBase64Image(myGlyph)
                    } );
					doc.content.splice( 1, 1, {
                        alignment: 'center',
                        bold: true,
                        fontSize: 10,
                        text: '',
						margin: [0, 0, 0, 0],
                    } );
					
					// Create a footer
        doc['footer']=(function(page, pages) {
            return {
                columns: [
                    'Generated by iStudio Technologies Pvt Ltd.',
                    {
                        // This is the right column
                        alignment: 'right',
                        text: ['page ', { text: page.toString() },  ' of ', { text: pages.toString() }]
                    }
                ],
				alignment: 'left',
                margin: [10, 0]
            }
        });
                }
			}]
		});
var allPages = myTable.rows().nodes().to$();
		
		$('#batch').change(function(){
			$('#department').val('');
			$('#subject').empty();
		});
	$('#stream').change(function(){
			$('#dept').css('display','block');
			$('#department').empty();
			$('#subject').empty();
		  var stream = $(this).val();	
			if (stream!='') {
            $.ajax({
                url: base_url + "coe/getProgram",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    stream: stream
                },
                success: function (data) {
					$('#department').append(data);
                }
            });
        }else{
			$('#dept').css('display','none');
		}
		});
    $('#department,#stream,#sem,#batch').change(function(){
			$('#sub').css('display','block');
			$('#subject').empty();
		  var stream = $('#stream').val();	
		  var department = $('#department').val();	
		  var batch = $('#batch').val();	
		  var sem = $('#sem').val();	
			if (stream!='' && department!='' && batch!='' && sem!='') {
            $.ajax({
                url: base_url + "coe/getSubjSemwise",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    stream: stream,
                    department: department,
                    batch: batch,
                    sem: sem,
                },
                success: function (data) {
					$('#subject').append(data);
                }
            });
        }
		});	
		
		
/*$("input[type=checkbox]",allPages).each(function () {
	$(this).attr('checked','checked');
	$(this).siblings().removeAttr('readonly');
	});
	
	
		
	$(".internal",allPages).change(function () {
           if(!this.checked) {
			   $(this).siblings().val('');
			   $(this).siblings().attr('readonly', 'readonly');
			   }else{
				$(this).siblings().removeAttr('readonly');   
			   }
	});
	$(".external",allPages).change(function () {
           if(!this.checked) {
			   $(this).siblings().val('');
			   $(this).siblings().attr('readonly', 'readonly');
			   }else{
				$(this).siblings().removeAttr('readonly');   
			   }
	});
	$(".thirdparty",allPages).change(function () {
           if(!this.checked) {
			   $(this).siblings().val('');
			   $(this).siblings().attr('readonly', 'readonly');
			   }else{
				$(this).siblings().removeAttr('readonly');   
			   }
	});*/
		
		$('#internal_submit').click(function(){
		var internal=Array();	
		var intval=Array();	
		var main_id=$('#stream').val();	
		var course_id=$('#department').val();
        var subject_id=$('#subject').val();	
        var batch=$('#batch').val();		
		var sem=$('#sem').val();		
		var applied_year=$('#applied_year').val();		
		var applied_sem=$('#applied_sem').val();		
			allPages.each(function(){
			$(this).closest('tr').find('td:eq(2) input').each(function(){
				if($(this).val() != 'NULL'){
            internal.push($(this).data('student'));
            intval.push($(this).val());
				}
            });
		});
		if (confirm('Are you sure to add the Marks?')) {
            $.ajax({
                url: base_url + "coe/internalMarkArrear",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    internal: internal,intval: intval,main_id: main_id,course_id: course_id,subject_id: subject_id,batch: batch,sem: sem,applied_year: applied_year,applied_sem: applied_sem,
                },
                success: function (data) {
                }
            });
					alert('Internal Marks Added Successfully!!');
		}
		});
		
		$('#external_submit').click(function(){
		var external=Array();	
		var extval=Array();	
		var main_id=$('#stream').val();	
		var course_id=$('#department').val();
        var subject_id=$('#subject').val();	
        var batch=$('#batch').val();			
		var sem=$('#sem').val();		
		var applied_year=$('#applied_year').val();		
		var applied_sem=$('#applied_sem').val();	
			allPages.each(function(){
			$(this).closest('tr').find('td:eq(3) input').each(function(){
				if($(this).val() != 'NULL'){
            external.push($(this).data('student'));
            extval.push($(this).val());
				}
            });
		});
		if (confirm('Are you sure to add the Marks?')) {
            $.ajax({
                url: base_url + "coe/externalMarkArrear",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    external: external,extval: extval,main_id: main_id,course_id: course_id,subject_id: subject_id,batch: batch,sem: sem,applied_year: applied_year,applied_sem: applied_sem,
                },
                success: function (data) {
                }
            });
					alert('In Class Marks Added Successfully!!');
		}
		});
		
		$('#thirdparty_submit').click(function(){
		var thirdparty=Array();	
		var tpval=Array();	
		var main_id=$('#stream').val();	
		var course_id=$('#department').val();
        var subject_id=$('#subject').val();		
        var batch=$('#batch').val();			
		var sem=$('#sem').val();		
		var applied_year=$('#applied_year').val();		
		var applied_sem=$('#applied_sem').val();	
			allPages.each(function(){
			$(this).closest('tr').find('td:eq(4) input').each(function(){
				if($(this).val() != 'NULL'){
            thirdparty.push($(this).data('student'));
            tpval.push($(this).val());
				}
            });
		});
		if (confirm('Are you sure to add the Marks?')) {
            $.ajax({
                url: base_url + "coe/thirdPartyMarkArrear",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    thirdparty: thirdparty,tpval: tpval,main_id: main_id,course_id: course_id,subject_id: subject_id,batch: batch,sem: sem,applied_year: applied_year,applied_sem: applied_sem,
                },
                success: function (data) {
                }
            });
					alert('Third Party Marks Added Successfully!!');
		}
		});
	});
	</script>