<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
<!--Sweet Alert-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
    <link rel="stylesheet" href="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css" />
<style>
/* Main Classes */
.myinput[type="checkbox"]:before{
    position: relative;
    display: block;
    width: 25px;
    height: 25px;
    border: 1px solid #008000;
    content: "";
   background: #FFF; 
}
.myinput[type="checkbox"]:after{
    position: relative;
    display: block;
    left: 2px;
    top: -21px;
    width: 20px;
    height: 20px;
    border-width: 1px;
    border-style: solid;
    border-color: #B3B3B3 #dcddde #dcddde #B3B3B3;
    content: "";
    background-image: linear-gradient(135deg, #ff0000 60%,#FFF 100%);
    background-repeat: no-repeat;
    background-position:center;
}
.myinput[type="checkbox"]:checked:after{
    background-image:  url('data:image/png;base64,R0lGODlhCwAKAIABAP////3cnSH5BAEKAAEALAAAAAALAAoAAAIUjH+AC73WHIsw0UCjglraO20PNhYAOw=='), linear-gradient(135deg, #008000 60%,#FFF 100%);
}
.myinput[type="checkbox"]:disabled:after{
    -webkit-filter: opacity(0.4);
}
.myinput[type="checkbox"]:not(:disabled):checked:hover:after{
    background-image:  url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAcAAAAHCAQAAABuW59YAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAAB2SURBVHjaAGkAlv8A3QDyAP0A/QD+Dam3W+kCAAD8APYAAgTVZaZCGwwA5wr0AvcA+Dh+7UX/x24AqK3Wg/8nt6w4/5q71wAAVP9g/7rTXf9n/+9N+AAAtpJa/zf/S//DhP8H/wAA4gzWj2P4lsf0JP0A/wADAHB0Ngka6UmKAAAAAElFTkSuQmCC'), linear-gradient(135deg, #ff0000 0%,#FFF 100%);
}
.myinput[type="checkbox"]:not(:disabled):hover:after{
    background-image: linear-gradient(135deg, #008000 0%,#FFF 100%);  
    border-color: #85A9BB #92C2DA #92C2DA #85A9BB;  
}
.myinput[type="checkbox"]:not(:disabled):hover:before{
    border-color: #3D7591;
}
/* Large checkboxes */
.myinput.large{
    height:35px;
    width: 35px;
}

.myinput.large[type="checkbox"]:before{
    width: 32px;
    height: 32px;
}
.myinput.large[type="checkbox"]:after{
    top: -30px;
    width: 29px;
    height: 29px;
}
</style>
<style>
.switch {
  position: relative;
  display: inline-block;
  width: 90px;
  height: 34px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: red;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: green;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(55px);
  -ms-transform: translateX(55px);
  transform: translateX(55px);
}

/*------ ADDED CSS ---------*/
.on
{
  display: none;
}

.on, .off
{
  color: white;
  position: absolute;
  transform: translate(-50%,-50%);
  top: 50%;
  left: 50%;
  font-size: 10px;
  font-family: Verdana, sans-serif;
}

input:checked+ .slider .on
{display: block;}

input:checked + .slider .off
{display: none;}

/*--------- END --------*/

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;}
</style>
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



      <!--Start Dashboard Content-->
	  
	  
	  <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Student List
		  </div>
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
			<div class="col-lg-2">
			   <label>Sem</label>
			<select class="form-control" id="sem" name="sem" required>
			  <option value="">Select Sem</option>
			  <?php $sem=array(1,2,3,4,5,6,7,8);
			  foreach($sem as $sem){ 
			  ?>
			  <option value="<?=$sem?>" <?php if($sem1==$sem){echo 'selected';}?>><?=$sem?></option>
			  <?php } ?>
			  </select>
			</div>
			<div class="col-lg-3">
			   <label>Subject</label>
			<select class="form-control" id="subject" name="subject" required>
			  <option value="">Select Subject</option>
			  <?php if(isset($sub_list)){if(sizeof($sub_list)>0){foreach($sub_list as $sublist){ 
			  $sub_name=$this->db->where('id',$sublist->subject_id)->get('erp_subjectmaster')->row();
			  ?>
			  <option value="<?=$sublist->subject_id?>" <?php if($subject1==$sublist->subject_id){echo 'selected';}?>><?=$sub_name->subName?></option>
			  <?php }}} ?>
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
    </div>	  

	  <?php if(isset($stu_list)){?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
			  <div class="row">
			  <div class="col-lg-12">
			  <span><b><i>Note:  
			  <ul style="list-style-type:decimal;">
               <li>Attendance marked in the attendance column alone will be calculated for the overall attendance calculation.</li>
               <li>For On Duty (OD), Mark the student as present (Click the Check box) in Attendance Column and mark Yes in OD column.</li>
               <li>OD column is only for the reports and not for the calculation of attendance.</li>
               <li>Green Colour indicates Present and Red Colour indicates Absent.</li>
              </ul>  
			  </i></b></span>
			  </div>
			  </div>
			<div class="row mt-3">
			<div class="col-lg-3">
			  <!--<div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
    <input class="form-control" type="text" readonly id="date" name="date" required/>
    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
</div>-->
<input class="form-control" type="date"  id="date" name="date" required/>
			  </div>
			<div class="col-lg-2">
			<select class="form-control" id="period" name="period" required>
			  <option value="">Select Hour</option>
			  <?php $period=array(1,2,3,4,5,6);
			  foreach($period as $period){ 
			  ?>
			  <option value="<?=$period?>"><?=$period?></option>
			  <?php } ?>
			  </select>
			</div>
			  <div class="col-lg-7 mrkatt" style="display:none">
			  <button type="button" class="btn btn-sm btn-success" id="mark_att">Mark Attendance</button>
			  </div>
			  <div class="col-lg-7 mrkattt" style="display:none">
			  <p class="mrktext">Mark Attendance</p>
			  </div>
			</div>
			</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="attendance-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Reg No.</th>
                        <th>Student Name</th>
                        <th>Attendance</th>
                        <th>OD</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php $sno=1;
					foreach($stu_list as $stulist){			
					 ?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$stulist->reg_no_?></td>
                        <td><?=$stulist->student_name_?></td>
                        <td>
						<input type="checkbox" data-student="<?=$stulist->id?>" checked="checked" class="myinput large checkbox1" />
						</td>
						<td>
						<!--<input type="checkbox" data-student="<?=$stulist->id?>" class="myinput large checkbox1" />-->
						<label class="switch">
                        <input type="checkbox" data-student="<?=$stulist->id?>" id="togBtn">
                        <div class="slider round">
                        <span class="on">YES</span>
                        <span class="off">NO</span>
                        </div>
                        </label>
						</td>
                    </tr>
                    <?php } ?>
               
                </tbody>
            </table>
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
	var base_url = "<?php echo base_url(); ?>";
	$(document).ready(function(){
		$('#department').change(function(){
			$('#pgrm').css('display','block');
			$('#program').empty();
		  var dept = $(this).val();	
			if (dept!='') {
            $.ajax({
                url: base_url + "hod/getPgrm",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    dept: dept
                },
                success: function (data) {
					$('#program').append(data);
                }
            });
        }
		});
		
		$('#batch,#sem').change(function(){
			$('#subject').empty();
		  var batch = $('#batch').val();	
		  var sem = $('#sem').val();	
			if (batch!='' && sem!='') {
            $.ajax({
                url: base_url + "hod/getSubjec",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    batch: batch,
                    sem: sem,
                },
                success: function (data) {
					$('#subject').append(data);
                }
            });
        }
		});
		
		$('#date,#period').on('change', function(){
			$(".mrkatt").css('display','none');
			$(".mrkattt").css('display','none');
			$('.mrktext').empty();
			var subject = "<?php echo $subject1; ?>";
            var period=$('#period').val();
            var date=$('#date').val();
			$("td:eq(3) input[type=checkbox]", myTable.rows().nodes().to$()).prop('checked',true);
			$("td:eq(4) input[type=checkbox]", myTable.rows().nodes().to$()).prop('checked',false);
			if (period!='' && date!='') {
            $.ajax({
                url: base_url + "hod/verifyAtt",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    subject: subject,
                    period: period,
                    date: date,
                },
                success: function (data) {
					if(data == 1){
						$(".mrkatt").css('display','block');
						$.ajax({
                url: base_url + "hod/getAttendance",
                type: 'POST',
                cache: false,
                data: {
                    subject: subject,
                    period: period,
                    date: date,
                },
                success: function (data1) {
					var obj1 = jQuery.parseJSON(data1);
					$.each(obj1[0], function(key, value) {
                      $("td:eq(3) input[type=checkbox][data-student="+key+"]", myTable.rows().nodes().to$()).attr('checked', false);
                    });
					$.each(obj1[1], function(key, value) {
                      $("td:eq(4) input[type=checkbox][data-student="+key+"]", myTable.rows().nodes().to$()).attr('checked', true);
                    });
                }
                   });
					}else{
						$(".mrkattt").css('display','block');
						var obj = jQuery.parseJSON(data);
						var empname = obj.empname;
						var subname = obj.subname;
						$('.mrktext').append('<b>Attendance already marked by '+empname+' ['+subname+']</b>');
					}
                }
            });
        }
		});
	});
	</script>
	<script>
	
$("#mark_att").click(function () {
	$(this).attr('type', 'button');

	var batch = "<?php echo $batch1; ?>";
	var sem = "<?php echo $sem1; ?>";
	var subject = "<?php echo $subject1; ?>";
 var period=$('#period').val();
 var date=$('#date').val();
 var ids=Array();
 var ids1=Array();
 var ids2=Array();
 
 if(subject==''){
	 alert('Please Select a Subject');
	 return false;
 }
 if(period==''){
	 alert('Please Select a Period');
	 return false;
 }
 if(sem==''){
	 alert('Please Select Sem');
	 return false;
 }
	$("td:eq(3) input[type=checkbox]:checked", myTable.rows().nodes().to$()).each(function(){
    ids.push($(this).data('student')+'-1');
      });
	  $("td:eq(3) input:checkbox:not(:checked)", myTable.rows().nodes().to$()).each(function(){
    ids1.push($(this).data('student')+'-0');
      });
	  $("td:eq(4) input[type=checkbox]:checked", myTable.rows().nodes().to$()).each(function(){
    ids2.push($(this).data('student')+'-1');
      });
 
swal({   title: "Are you sure to mark attendance?",
 
type: "warning",
 
showCancelButton: true,
 
confirmButtonColor: "#DD6B55",
 
confirmButtonText: "Yes!",
 
cancelButtonText: "Cancel",
 
closeOnConfirm: false,
 
closeOnCancel: false },
 
function(isConfirm){
 
if (isConfirm)
 
{
	 
	$.ajax({
                url: base_url + "hod/verifyAttendance",
                type: 'POST',
                cache: false,
				//dataType: "text",
                data: {
                    id_present: ids,
                    id_absent: ids1,
                    id_od: ids2,
                    period: period,
                    subject: subject,
                    date: date,
                    batch: batch,
                    sem: sem,
                },
                success: function (data) {
					if(data==0){
	  
            $.ajax({
                url: base_url + "hod/markAttendance",
                type: 'POST',
                cache: false,
				//dataType: "text",
                data: {
                    id_present: ids,
                    id_absent: ids1,
					id_od: ids2,
                    period: period,
                    subject: subject,
                    date: date,
                    batch: batch,
                    sem: sem,
                },
                success: function (data1) {
swal("Attendance Marked!", "Attendance Marked Successfully!", "success");
				location.reload();
                }
            });
					}
				    else if(data==1){
swal("Already Marked!", "Attendance Marked already for this period!", "success");							
					}
					else {
						
						$.ajax({
                url: base_url + "hod/markAttendance",
                type: 'POST',
                cache: false,
				//dataType: "text",
                data: {
                    id: data,
                    id_present: ids,
                    id_absent: ids1,
					id_od: ids2,
                    period: period,
                    subject: subject,
                    date: date,
                    batch: batch,
                    sem: sem,
                },
                success: function (data2) {
swal("Attendance Updated!", "Attendance Updated Successfully!", "success");
				location.reload();
                }
            });									
					}
                }
            });
 
 
}
 
else {
 
swal("OOps", "Attendance Not Marked!", "error");
 
} });
 
 
    });	
	</script>