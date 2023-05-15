<?php $program = isset($program) ? $program : '';
$department = isset($department) ? $department : '';
?> 
<!--HTML to image-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<style>
/* Main Classes */
.myinput[type="checkbox"]:before{
    position: relative;
    display: block;
    width: 15px;
    height: 15px;
    border: 1px solid #808080;
    content: "";
   background: #FFF; 
}
.myinput[type="checkbox"]:after{
    position: relative;
    display: block;
    left: 2px;
    top: -11px;
    width: 10px;
    height: 10px;
    border-width: 1px;
    border-style: solid;
    border-color: #B3B3B3 #dcddde #dcddde #B3B3B3;
    content: "";
    background-image: linear-gradient(135deg, #B1B6BE 0%,#FFF 100%);
    background-repeat: no-repeat;
    background-position:center;
}
.myinput[type="checkbox"]:checked:after{
    background-image:  url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAcAAAAHCAQAAABuW59YAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAAB2SURBVHjaAGkAlv8A3QDyAP0A/QD+Dam3W+kCAAD8APYAAgTVZaZCGwwA5wr0AvcA+Dh+7UX/x24AqK3Wg/8nt6w4/5q71wAAVP9g/7rTXf9n/+9N+AAAtpJa/zf/S//DhP8H/wAA4gzWj2P4lsf0JP0A/wADAHB0Ngka6UmKAAAAAElFTkSuQmCC'), linear-gradient(135deg, #B1B6BE 0%,#FFF 100%);
}
.myinput[type="checkbox"]:disabled:after{
    -webkit-filter: opacity(0.4);
}
.myinput[type="checkbox"]:not(:disabled):checked:hover:after{
    background-image:  url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAcAAAAHCAQAAABuW59YAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAAB2SURBVHjaAGkAlv8A3QDyAP0A/QD+Dam3W+kCAAD8APYAAgTVZaZCGwwA5wr0AvcA+Dh+7UX/x24AqK3Wg/8nt6w4/5q71wAAVP9g/7rTXf9n/+9N+AAAtpJa/zf/S//DhP8H/wAA4gzWj2P4lsf0JP0A/wADAHB0Ngka6UmKAAAAAElFTkSuQmCC'), linear-gradient(135deg, #8BB0C2 0%,#FFF 100%);
}
.myinput[type="checkbox"]:not(:disabled):hover:after{
    background-image: linear-gradient(135deg, #8BB0C2 0%,#FFF 100%);  
    border-color: #85A9BB #92C2DA #92C2DA #85A9BB;  
}
.myinput[type="checkbox"]:not(:disabled):hover:before{
    border-color: #3D7591;
}
/* Large checkboxes */
.myinput.large{
    height:25px;
    width: 25px;
}

.myinput.large[type="checkbox"]:before{
    width: 22px;
    height: 22px;
}
.myinput.large[type="checkbox"]:after{
    top: -20px;
    width: 19px;
    height: 19px;
}
</style>
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



      <!--Start Dashboard Content-->	  
	 <!-- Start Row-->
	 <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> ID Generate
			</div>
            <div class="card-body">
			<form action="" method="post">
              <div class="row">
			  <div class="col-lg-3">
			  <label>Stream</label>
			  <select class="form-control" id="department" name="department">
			  <option value="">Select Stream</option>
			  <option value="">Select Stream</option>
			<option value="5" <?php if($department=='5'){echo 'selected';}?>>UG</option>
			<option value="2" <?php if($department=='2'){echo 'selected';}?>>PG - MSW Aided</option>
			<option value="1" <?php if($department=='1'){echo 'selected';}?>>PG - Self Finance</option>
			<option value="3" <?php if($department=='3'){echo 'selected';}?>>PG - MSW Self Finance</option>
			<option value="4" <?php if($department=='4'){echo 'selected';}?>>PG Diploma</option>
			  </select>
			  </div>
			  <?php if($program!=''){$style='style="display:block"';}else{$style='style="display:none"';}; ?>
			  <div class="col-lg-3" id="pgrm" <?=$style?>>
			  <label>Department</label>
			  <select class="form-control" id="program" name="program">
			  <option value="">Select Department</option>
			  <?php if(isset($department)){ $dept = $this->db->where('main_id',$department)->get('department_details')->result();
			foreach($dept as $dept){?>
			<option value="<?=$dept->cour_id?>" <?php if($program==$dept->cour_id){echo 'selected';}?>><?=$dept->comp_name?></option>
			<?php }} ?>
			  </select>
			  </div>
			  <div class="col-lg-1 mt-3">
			  <div class="form-group" style="float:right;">
			  <button type="submit" class="btn btn-primary btn-sm" name="submit">Submit</button>
			  </div>
			  </div>
			  </div>
			  </form>
            </div>
          </div>
        </div>
      </div><!-- End Row-->

	  <?php if(isset($staff_list)){?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Student List
			<div class="row">
			  <div class="col-lg-12">
			    <div class="form-group" style="float:right;">
				<button id="select_all_stf" class="btn btn-sm btn-primary">SelectAll</button>
				<button id="idgeneratestaff" class="btn btn-sm btn-success" name="gen_id">Generate ID</button>
				</div>
			  </div>
			</div>
			</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="idgenerate-staff-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Register No</th>
                        <th>Student Name</th>
                        <th>Batch</th>
                        <th>Department</th>
                        <th>Blood Group</th>
                        <th>Mobile</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php $sno=1;
					foreach($staff_list as $stafflist){	
					$dept_s=$this->db->where('main_id',$stafflist->emp_college_type_)->where('cour_id',$stafflist->emp_dept_name_)->get('department_details')->row();
					 ?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$stafflist->employee_id_?></td>
                        <td><?=$stafflist->emp_name_?></td>
                        <td><?=$stafflist->emp_doj_?></td>
                        <td><?=$dept_s->comp_name?></td>
                        <td><?=$stafflist->emp_bgroup_?></td>
                        <td><?=$stafflist->emp_mobile_?></td>
						<td><input name="stu_id[]" type="checkbox" value="" data-staff="<?=$stafflist->id?>" data-dept="<?=$dept_s->short_name?>" class="myinput large checkbox1">
			<div class="downld download_class_<?=$stafflist->id?>" style="visibility: hidden;height:2px;"></div>
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
	  
	  <!-- Student ID front and back div start -->
	  <div class="idcard_download">
	  
	  </div>
	  <!-- Student ID front and back div end -->

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
		  var stream = $(this).val();	
			if (stream!='') {
            $.ajax({
                url: base_url + "subadmin/getProgram",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    stream: stream
                },
                success: function (data) {
					$('#program').append(data);
                }
            });
        }else{
			$('#pgrm').css('display','none');
		}
		});
	});			
</script>		