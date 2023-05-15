
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
            <div class="card-header">
			<i class="fa fa-table"></i> Other Closing Dates
			<br/><br/>
              <form action="" method="POST">
            <div class="row">
			<div class="col-lg-3">
			   <label>Batch</label>
			<select class="form-control" name="batch" id="batch">
			<option value="">Select Batch</option>
			<?php $batch = $this->db->get('erp_batchmaster')->result();
			foreach($batch as $batch){?>
			<option value="<?=$batch->id?>" <?php if($batch->id==$batch1) {echo 'selected';}?>><?=$batch->batch_from?></option>
			<?php } ?>
			</select>
			<span style="color:red;"><?php echo form_error('batch'); ?></span>
		         </div>
			  <div class="col-lg-3">
          <label>Semester</label>
			  <select class="form-control" name="sem" id="sem">
			  <option value="">Select Semester</option>
		  <?php $sem = array('1','2','3','4','5','6','7','8');
		  foreach($sem as $sem){?>
			  <option value="<?=$sem?>" <?php if($sem==$sem1) {echo 'selected';}?>><?=$sem?></option>
		  <?php } ?>
		  </select>
		  <span style="color:red;"><?php echo form_error('sem'); ?></span>
			  </div>
			  <div class="col-lg-1 mt-4">
          <div class="form-group" style="float: right;">
			  <button class="btn btn-sm btn-success" name="submit">Submit</button>
        </div>
			  </div>	
			  </div>	
              </form>
            </div>
			<div class="card-body">
			<?php if($_POST){?>
			<div class="table-responsive">
			<form action="" method="post">
              <table id="default-datatable" class="table table-bordered">
                <tbody>


                    
                    <?php if(isset($date_list)){
		  $online_arrear = $date_list->online_arrear;
		  $result_publish = $date_list->result_publish;
		  $online_pay_start = $date_list->online_pay_start;
		  $online_pay_end_wo_penalty = $date_list->online_pay_end_wo_penalty;
		  $online_pay_end = $date_list->online_pay_end;
		  $payment_coe = $date_list->payment_coe;
		  $hallticket_issue = $date_list->hallticket_issue;
		  $revaluation_end = $date_list->revaluation_end;
		  $exam_conduction_mnth = $date_list->exam_conduction_mnth;
		  $exam_mode = $date_list->exam_mode;
		  $exam_conduction_year = $date_list->exam_conduction_year;
		  $result_dspl_date = $date_list->result_dspl_date;
		  $result_dspl_time = date('H:i:s',strtotime($date_list->result_dspl_time));
		  $reval_dspl_date = $date_list->reval_dspl_date;
		  $reval_dspl_time = date('H:i:s',strtotime($date_list->reval_dspl_time));
		  $edit_id = $date_list->id;
					}else{
		  $online_arrear = '';
		  $result_publish = '';
		  $online_pay_start = '';
		  $online_pay_end_wo_penalty = '';
		  $online_pay_end = '';
		  $payment_coe = '';
		  $hallticket_issue = '';
		  $revaluation_end = '';
		  $exam_conduction_mnth = '';
		  $exam_mode = '';
		  $exam_conduction_year = '';
		  $result_dspl_date = '';
		  $result_dspl_time = '';
		  $reval_dspl_date = '';
		  $reval_dspl_time = '';
          $edit_id =  '';		  
					}
					?>
					<tr>
                        <td>Online Arrear Payment</td>
                        <td><input type="date" class="form-control col-sm-6" value="<?=$online_arrear?>" name="online_arrear"></td>
                    </tr>
                      <tr>
                        <td>Result Publish Date</td>
                        <td><input type="date" class="form-control col-sm-6" value="<?=$result_publish?>" name="result_publish">
                        <input type="hidden" value="<?=$batch1?>" name="batch">
                        <input type="hidden" value="<?=$sem1?>" name="sem">
                        <input type="hidden" value="<?=$edit_id?>" name="edit_id"></td>
                    </tr>
					<tr>
                        <td>Online Payment Start Date</td>
                        <td><input type="date" class="form-control col-sm-6" value="<?=$online_pay_start?>" name="online_pay_start"></td>
                    </tr>
					<tr>
                        <td>Online Payment End Date (Without penalty)</td>
                        <td><input type="date" class="form-control col-sm-6" value="<?=$online_pay_end_wo_penalty?>" name="online_pay_end_wo_penalty"></td>
                    </tr>
					<tr>
                        <td>Online Payment Closing Date</td>
                        <td><input type="date" class="form-control col-sm-6" value="<?=$online_pay_end?>" name="online_pay_end"></td>
                    </tr>
					<tr>
                        <td>Payment COE Date</td>
                        <td><input type="date" class="form-control col-sm-6" value="<?=$payment_coe?>" name="payment_coe"></td>
                    </tr>
					<tr>
                        <td>Hall Ticket Issue Date</td>
                        <td><input type="date" class="form-control col-sm-6" value="<?=$hallticket_issue?>" name="hallticket_issue"></td>
                    </tr>
					<tr>
                        <td>Revaluation End Date</td>
                        <td><input type="date" class="form-control col-sm-6" value="<?=$revaluation_end?>" name="revaluation_end"></td>
                    </tr>
					<tr>
                        <td>Exam Conduction Month</td>
                        <td>
						<select class="form-control col-sm-6" name="exam_conduction_mnth" id="exam_conduction_mnth">
			  <option value="">Select Month</option>
		  <?php $month = array('1','2','3','4','5','6','7','8','9','10','11','12');
		  foreach($month as $month){?>
			  <option value="<?=$month?>" <?php if($month==$exam_conduction_mnth) {echo 'selected';}?>><?=$month?></option>
		  <?php } ?>
		  </select>
		            </td>
                    </tr>
					<tr>
                        <td>Exam Mode</td>
                        <td>
						<select class="form-control col-sm-6" name="exam_mode" id="exam_mode">
			  <option value="">Select Mode</option>
		  <?php $mode = array('Regular','Arrear');
		  foreach($mode as $mode){?>
			  <option value="<?=$mode?>" <?php if($mode==$exam_mode) {echo 'selected';}?>><?=$mode?></option>
		  <?php } ?>
		  </select>
		            </td>
                    </tr>
					<tr>
                        <td>Exam Conduction Year</td>
                        <td><input type="number" class="form-control col-sm-6" value="<?=$exam_conduction_year?>" name="exam_conduction_year" maxlength="4" minlength="4"></td>
                    </tr>
					<tr>
                        <td>Result Display Date for Students</td>
                        <td><input type="date" class="form-control col-sm-6" value="<?=$result_dspl_date?>" name="result_dspl_date"></td>
                    </tr>
					<tr>
                        <td>Result Display Time for Students</td>
                        <td><input type="time" class="form-control col-sm-6" value="<?=$result_dspl_time?>" name="result_dspl_time"></td>
                    </tr>
					<tr>
                        <td>Revaluation Display Date for Students</td>
                        <td><input type="date" class="form-control col-sm-6" value="<?=$reval_dspl_date?>" name="reval_dspl_date"></td>
                    </tr>
					<tr>
                        <td>Revaluation Display Time for Students</td>
                        <td><input type="time" class="form-control col-sm-6" value="<?=$reval_dspl_time?>" name="reval_dspl_time"></td>
                    </tr>
					<tr>
					<td colspan=2>
					<button type="submit" class="btn btn-sm btn-success" name="submit_edit" style="float:right;">Update</button>
					</td>
                    </tr>
                 
               
                </tbody>
            </table>
			</form>
            </div>
			<?php } ?>
			</div>
          </div>
        </div>
      </div><!-- End Row-->
	  
	  
	  

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
		
		
	});
	</script>
	<script>
	   setTimeout(function() {
            $('.hide-it').hide('fast');
        }, 3000);
</script>