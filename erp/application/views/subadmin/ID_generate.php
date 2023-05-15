<?php $program = isset($program) ? $program : '';
$department = isset($department) ? $department : '';
?> 
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
            <div class="card-header"><i class="fa fa-table"></i> Student Attendance</div>
            <div class="card-body">
			<form action="<?=base_url().'subadmin/IDGenerate'?>" method="post">
              <div class="row">
			  <div class="col-lg-3">
			  <select class="form-control" id="department" name="department">
			  <option value="">Select Stream</option>
			  <option value="1" <?php if($department==1){echo 'selected';}?>>Aided</option>
			  <option value="2" <?php if($department==2){echo 'selected';}?>>Self Finance</option>
			  </select>
			  </div>
			  <?php if($program!=''){$style='style="display:block"';}else{$style='style="display:none"';}; ?>
			  <div class="col-lg-3" id="pgrm" <?=$style?>>
			  <select class="form-control" id="program" name="program">
			  <option value="">Select Department</option>
			  <?php if((sizeof($programm)>0)&&isset($programm)){foreach($programm as $programm){ ?>
			  <option value="<?=$programm->id?>" <?php if($program==$programm->id){echo 'selected';}?>><?=$programm->dept_name_?></option>
			  <?php }} ?>
			  </select>
			  </div>
			  <div class="col-lg-6">
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

	  <?php if(isset($stu_list)){?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Student List
			<div class="row">
			  <div class="col-lg-12">
			    <div class="form-group" style="float:right;">
				<button id="select_all" class="btn btn-sm btn-primary">SelectAll</button>
				<button id="idgenerate" class="btn btn-sm btn-success" name="gen_id">Generate ID</button>
				</div>
			  </div>
			</div>
			</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="idgenerate-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Register No</th>
                        <th>Student Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php $sno=1;
					foreach($stu_list as $stulist){		
					 ?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$stulist->as_reg_num?></td>
                        <td><?=$stulist->as_name?></td>
						<td><input name="stu_id[]" type="checkbox" value="" data-student="<?=$stulist->as_id?>" data-dept="<?=$stulist->as_dep?>" class="myinput large checkbox1">
			<div class="downld download_class_<?=$stulist->as_id?>" style="visibility: hidden;height:2px;"></div>
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
	var base_url = "<?php echo base_url(); ?>";
	$(document).ready(function(){
		$('#department').change(function(){
			$('#pgrm').css('display','block');
			$('#program').empty();
		  var stream = $(this).val();	
			if (stream!='') {
            $.ajax({
                url: base_url + "subadmin/getPgrm",
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