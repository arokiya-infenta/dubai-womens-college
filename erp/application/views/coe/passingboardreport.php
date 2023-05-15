
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
		  <div class="card-header"><i class="fa fa-table"></i> Average Details</div>
            <div class="card-body">
			
			<form action="" method="post">
			   <div class="row">
			   <div class="col-lg-3">
			<label>Batch</label>   
			<select class="form-control" name="batch" id="batch" required>
			<option value="">Select Batch</option>
			<?php $batch = $this->db->get('erp_batchmaster')->result();
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
			  <?php if(isset($subject1)){ $subject = $this->db->where('batch_year',$batch1)->where('sem',$sem1)->where('stream',$stream)->where('department',$department)->get('erp_subjectmaster')->result();
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
		  
		  </div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="exammarks-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
												<th>Register No.</th>
                        <th>Name</th>
                        <th>ICA(50)</th>
                        <th>Internal Valuation(100)</th>
                        <th>External Valuation(100)</th>
                        <th>Third Valuation(100)</th>
                        <th>Total(200)</th>
                        <th>ESE(50)</th>
                        <th>ICA + ESE(100)</th>
                        <th>Result</th>
                       
                       
                    </tr>
                </thead>
                <tbody>
               <?php 
						
						
// PHP program to find element closest 
// to given target. 
  
// Returns element closest to target in arr[] 
function findClosest($arr, $n, $target) 
{ 
    // Corner cases 
    if ($target <= $arr[0]) 
        return $arr[0]; 
    if ($target >= $arr[$n - 1]) 
        return $arr[$n - 1]; 
  
    // Doing binary search 
    $i = 0;
    $j = $n;
    $mid = 0; 
    while ($i < $j) 
    { 
        $mid = ($i + $j) / 2; 
  
        if ($arr[$mid] == $target) 
            return $arr[$mid]; 
  
        /* If target is less than array element, 
            then search in left */
        if ($target < $arr[$mid]) 
        { 
  
            // If target is greater than previous 
            // to mid, return closest of two 
            if ($mid > 0 && $target > $arr[$mid - 1]) 
                return getClosest($arr[$mid - 1], 
                                  $arr[$mid], $target); 
  
            /* Repeat for left half */
            $j = $mid; 
        } 
  
        // If target is greater than mid 
        else
        { 
            if ($mid < $n - 1 && 
                $target < $arr[$mid + 1]) 
                return getClosest($arr[$mid], 
                                  $arr[$mid + 1], $target); 
            // update i 
            $i = $mid + 1; 
        } 
    } 
  
    // Only single element left after search 
    return $arr[$mid]; 
} 
  
// Method to compare which one is the more close. 
// We find the closest by taking the difference 
// between the target and both values. It assumes 
// that val2 is greater than val1 and target lies 
// between these two. 
function getClosest($val1, $val2, $target) 
{ 
    if ($target - $val1 >= $val2 - $target) 
        return $val2; 
    else
        return $val1; 
} 
  
// Driver code 
/*$arr = array( 1, 2, 4, 5, 6, 6, 8, 9 ); 
$n = sizeof($arr); 
$target = 11; 
echo (findClosest($arr, $n, $target)); */
?>

                    
                    <?php $sno=1;







					foreach ($stu_list as $student) {
						$mark_det = $this->db->where('batch_year',$batch1)->where('sem',$sem1)->where('student_id',$student->id)->where('subject_id',$subject1)->get('erp_exammarkfinal')->row();
						if(isset($mark_det)){
						if($mark_det->ica!=''&&$mark_det->ica!=null){$checked1='checked';$readonly1='';$mark1=$mark_det->ica;}else{$checked1='';$readonly1='readonly';$mark1=0;}
						if($mark_det->internal!=''&&$mark_det->internal!=null){$checked2='checked';$readonly2='';$mark2=$mark_det->internal;}else{$checked2='';$readonly2='readonly';$mark2=0;}
						if($mark_det->external!=''&&$mark_det->external!=null){$checked3='checked';$readonly3='';$mark3=$mark_det->external;}else{$checked3='';$readonly3='readonly';$mark3=0;}
						if($mark_det->thirdparty!=''&&$mark_det->thirdparty!=null){$checked4='checked';$readonly4='';$mark4=$mark_det->thirdparty;}else{$checked4='';$readonly4='readonly';$mark4=0;}
						}
						else{
							$checked1='';$readonly1='readonly';$mark1=0;
							$checked2='';$readonly2='readonly';$mark2=0;
							$checked3='';$readonly3='readonly';$mark3=0;
							$checked4='';$readonly4='readonly';$mark4=0;
							}
					$ica_mark = $this->db->select('GREATEST(ica1Mark, ica2Mark) as icaMark,inClassMark,takeHomeMark')->where('batch',$batch1)->where('student_id',$student->id)->where('subject_id',$subject1)->get('erp_exammark')->row();	
					$icaMark = 0;
					$inClassMark = 0;
					$takeHomeMark = 0;
					if(isset($ica_mark)){
					if($ica_mark->icaMark != '' || $ica_mark->icaMark != null){$icaMark = $ica_mark->icaMark;}else{$icaMark = 0;}
					if($ica_mark->inClassMark != '' || $ica_mark->inClassMark != null){$inClassMark = $ica_mark->inClassMark;}else{$inClassMark = 0;}
					if($ica_mark->takeHomeMark != '' || $ica_mark->takeHomeMark != null){$takeHomeMark = $ica_mark->takeHomeMark;}else{$takeHomeMark = 0;}
					$icamrk = (float)$icaMark + (float)$inClassMark + (float)$takeHomeMark;
					}else{
					$icamrk = 'A';	
					}
					
					$average = 0;
					$av_diff = abs((int)$mark2 - (int)$mark3);
					if($av_diff <= 15){$average = ((int)$mark2 + (int)$mark3) / 2;}
					if($av_diff > 15 && $mark4 != 0){

$arr = array($mark2, $mark3);
$n = 2;
$target = $mark4; 
$closest = findClosest($arr, $n, $target);


$ese = ($mark2 + $mark3)/4;

$average = ((int)$closest + (int)$closest) / 2;
  

	}



	$fimdMax=[];
$arre=[];

$fimdMax=array($mark2,$mark3,$mark4);

$arre = sort($fimdMax);
(int)$maxtotal = (int)$fimdMax[1]+(int)$fimdMax[2];
$ese_m = round($maxtotal/4);


$g_total = round($ese_m + $icamrk);

//echo  $mark_det->main_id;

$rpub="";
if($mark_det->main_id == 1 || $mark_det->main_id == 2 || $mark_det->main_id == 3){


	/* echo $icamrk.PHP_EOL;
	echo $ese_m.PHP_EOL."<br>"; */

  if($icamrk > 25 && $ese_m > 25 ){

	$rpub = "P";

}else if($icamrk < 25 && $ese_m < 25 ){
	$rpub ="RA-I&E";

}else if($icamrk < 25 && $ese_m >= 25 ){

	$rpub ="RA-I";
}else if($icamrk >= 25 && $ese_m < 25 ){

	$rpub = "RA-E";
} 

}
/* $internal_result = 
$external_result =  */
				
					?>
                      <tr>
                        <td><?=$sno++?></td>
						<td><?=$student->reg_no_?></td>
                        <td><?=$student->student_name_?></td>
                       
                        <td><?=$icamrk?></td>
                        <td><?=$mark2?></td>
                        <td><?=$mark3?></td>
                        <td><?=$mark4?></td>
						<td>
						<?=$maxtotal?>
						</td>
						<td>
						<?=$ese_m?>
						</td>
						<td>
						<?=$g_total?>
						</td>
						<td>
						<?=$rpub?>
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
	$(document).ready(function(){
//var myTable = $('#exammarks-datatable').DataTable();

var myTable = $('#exammarks-datatable').DataTable({ 
		"bSortCellsTop": true,
			dom: 'Bfrtip',
			buttons: 
			[{ 
				extend: 'excelHtml5',
				title: 'Exammarks ' + currentDate + '',
				//text:'<i class="fa fa-table fainfo" aria-hidden="true" > Excel</i>',
                "oSelectorOpts": {filter: 'applied', order: 'current'},
				filename: 'Exammarks_ '+currentDate+'',
				orientation:'landscape',
				exportOptions: {
				 columns: [0,1, 2, 3, 4, 5, 6,7,8,9,10],
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
				filename: 'Exammarks_'+currentDate+'',
				exportOptions: {
					columns: [0, 1, 2, 3, 4, 5, 6,7,8,9,10],
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
					doc.content[1].margin = [ 50, 0, 100, 0 ] //left, top, right, bottom
					 
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
		
		
$("input[type=checkbox]",allPages).each(function () {
	$(this).attr('checked','checked');
	$(this).siblings().removeAttr('readonly');
	});
	
	
		$('#average_submit').click(function(){
		var average=Array();
		var avval=Array();	
		var main_id=$('#stream').val();	
		var course_id=$('#department').val();
        var subject_id=$('#subject').val();		
        var batch=$('#batch').val();			
		var sem=$('#sem').val();	
			allPages.each(function(){
			$(this).closest('tr').find('td:eq(6) input[type=text]').each(function(){
            average.push($(this).data('student'));
            avval.push($(this).val());
            });
		});
		if (confirm('Are you sure to add the Marks?')) {
            $.ajax({
                url: base_url + "coe/averageMark",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    average: average,avval: avval,main_id: main_id,course_id: course_id,subject_id: subject_id,batch: batch,sem: sem,
                },
                success: function (data) {
                }
            });
					alert('Average Marks Added Successfully!!');
		}
		});
	});
	</script>
