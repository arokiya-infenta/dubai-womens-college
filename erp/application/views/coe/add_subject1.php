 
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



      <!--Start Dashboard Content-->
	 <!--Start Row-->
	 <div class="row">
        <div class="col-lg-12">
		<div class="hide-it" align="center"><h4 style="color:#15ca20;"><?php echo $this->session->flashdata('form_err'); ?></h4></div>
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i>Subject</div>
            <div class="card-body">
              <div class="row">
              <div class="col-lg-3">
			  <button class="btn btn-sm btn-success" data-target="#myModalAdd" data-toggle="modal">Add Subject</button>
			  </div>
            </div>
            </div>
          </div>
        </div>
      </div><!-- End Row-->

	  <?php if(isset($subject_list)){?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Stream</th>
                        <th>Department</th>
                        <th>Subject</th>
                        <th>Action</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php $sno=1;
					foreach ($subject_list as $subject) { 
					$dept=$this->db->where('id',$subject->dept_)->get('erp_department')->row();
					if($subject->shift_==1){$stream='Aided';}else{$stream='Self Finance';}
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$stream?></td>
                        <td><?=$dept->dept_name_?></td>
                        <td><?=$subject->sub_name_?></td>
                        <td><button class="btn btn-sm btn-success edit_subject" data-dept="<?=$subject->dept_?>" data-subject="<?=$subject->sub_name_?>" data-stream="<?=$subject->shift_?>" data-id=<?=$subject->id?> data-target="#myModalEdit" data-toggle="modal">Edit</button></td>
                    </tr>
                    <?php } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                        <th>S.No </th>
                        <th>Stream</th>
                        <th>Department</th>
                        <th>Subject</th>
                        <th>Action</th>
                        
                    
                    </tr>
                </tfoot>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>
	  <?php } ?>
	  <!-- End Row-->
	  
	  <!-- Modal Add-->
  <div class="modal fade" id="myModalAdd" role="dialog">
    <div class="modal-dialog" style="max-width: 60%;">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add Subject</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
		  <form action="<?=base_url().'coe/addSubject'?>" method="post">
        <div class="modal-body">
          
              <div class="row">
			  <div class="col-lg-4">
			  <select class="form-control" id="stream" name="stream" required>
			  <option value="">Select Stream</option>
			  <option value="1">Aided</option>
			  <option value="2">Self Finance</option>
			  </select>
			  </div>
			  <div class="col-lg-4" id="dept" style="display:none;">
			  <select class="form-control" id="department" name="department" required>
			  <option value="">Select Program</option>
			  </select>
			  </div>
			  <div class="col-lg-4">
			  <input type="text" class="form-control" name="subject" required>
			  <span style="color:red;"><?php echo form_error('subject'); ?></span>
			  </div>
			  </div>	
			
        </div>
        <div class="modal-footer">
          <button type="submit" name="submit_add" class="btn btn-success">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
			  </form>
      </div>
      
    </div>
  </div>
  
  <!-- Modal Edit-->
  <div class="modal fade" id="myModalEdit" role="dialog">
    <div class="modal-dialog" style="max-width: 60%;">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Password</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
          
		  <form action="<?=base_url().'coe/addSubject'?>" method="post">
        <div class="modal-body">
          
              <div class="row">
			  <div class="col-lg-4">
			  <select class="form-control stream1" name="stream_edit" required>
			  <option value="">Select Stream</option>
			  <option value="1">Aided</option>
			  <option value="2">Self Finance</option>
			  </select>
			  <input type="hidden" class="edit_id" name="edit_id">
			  </div>
			  <div class="col-lg-4 dept1" id="dept1">
			  <select class="form-control department1" name="department_edit" required>
			  <option value="">Select Program</option>
			  </select>
			  </div>
			  <div class="col-lg-4">
			  <input type="text" class="form-control subject1" id="subject1" name="subject_edit" required>
			  </div>
			  </div>	
			
        </div>
        <div class="modal-footer">
          <button type="submit" name="submit_edit" class="btn btn-success">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
			  </form>
      </div>
      
    </div>
  </div>

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
	var base_url = "<?php echo base_url(); ?>";
	$(document).ready(function(){
		$('#stream').change(function(){
			$('#dept').css('display','block');
			$('#department').empty();
		  var stream = $(this).val();	
			if (stream!='') {
            $.ajax({
                url: base_url + "coe/getPgrm",
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
		
		$('.stream1').change(function(){
			$('.dept1').css('display','block');
			$('.department1').empty();
		  var stream = $(this).val();	
			if (stream!='') {
            $.ajax({
                url: base_url + "coe/getPgrm",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    stream: stream
                },
                success: function (data) {
					$('.department1').append(data);
                }
            });
        }else{
			$('.dept1').css('display','none');
		}
		});
	
    $(".edit_subject").click(function () {
		var status = $(this).attr('data-status');
		$('.dept1').css('display','block');
			$('.department1').empty();
			$('select.stream1').attr('selected',false);
		  var stream = $(this).data('stream');	
		  var dept = $(this).data('dept');
		  var subject = $(this).data('subject');
		var id = $(this).data('id');
			if (stream!='') {
            $.ajax({
                url: base_url + "coe/getPgrm",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    stream: stream
                },
                success: function (data1) {
					$('.department1').append(data1);
					$('select.stream1 option[value='+stream+']').attr('selected',true);
					$('select.department1 option[value='+dept+']').attr('selected',true);
					$('.subject1').val(subject);
					$('.edit_id').val(id);
                }
            });
        }
    });
	});
	
	</script>
	<script>
	   setTimeout(function() {
            $('.hide-it').hide('fast');
        }, 3000);
</script>