
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
			<i class="fa fa-table"></i>Exam Fees
			</div>
            <div class="card-body">
              <form action="" method="POST">
            <div class="row">
			<!--<div class="col-lg-3">
			   <label>Batch</label>
			<select class="form-control" name="batch" id="batch">
			<option value="">Select Batch</option>
			<?php $batch = $this->db->get('erp_batchmaster')->result();
			foreach($batch as $batch){?>
			<option value="<?=$batch->batch_from?>"><?=$batch->batch_from?></option>
			<?php } ?>
			</select>
			<span style="color:red;"><?php echo form_error('batch'); ?></span>
		         </div>
			  <div class="col-lg-3">
          <label>Semester</label>
			  <select class="form-control" name="sem">
			  <option value="">Select Semester</option>
		  <?php $sem = array('1','2','3','4','5','6','7','8');
		  foreach($sem as $sem){?>
			  <option value="<?=$sem?>"><?=$sem?></option>
		  <?php } ?>
		  </select>
		  <span style="color:red;"><?php echo form_error('sem'); ?></span>
			  </div>
			<div class="col-lg-3">
          <label>Stream</label>
			  <select class="form-control" id="stream" name="stream">
			  <option value="">Select Stream</option>
			  <option value="5">UG</option>
			<option value="2">PG - MSW Aided</option>
			<option value="1">PG - Self Finance</option>
			<option value="3">PG - MSW Self Finance</option>
			<option value="4">PG Diploma</option>
			  </select>
			  <span style="color:red;"><?php echo form_error('stream'); ?></span>
			  </div>
			  <div class="col-lg-3" id="dept">
          <label>Department</label>
			  <select class="form-control" id="department" name="department" required>
			  <option value="">Select Department</option>
			  </select>
			  <span style="color:red;"><?php echo form_error('department'); ?></span>
			  </div>-->
			  <div class="col-lg-3">
          <label>Stream</label>
			  <select class="form-control" id="stream" name="stream">
			  <option value="">Select Stream</option>
			  <option value="1" <?php if(set_value('stream') == 1){echo 'selected';}?>>PG</option>
			<option value="2" <?php if(set_value('stream') == 2){echo 'selected';}?>>PG - Diploma</option>
			  <option value="3" <?php if(set_value('stream') == 3){echo 'selected';}?>>UG</option>
			  </select>
			  <span style="color:red;"><?php echo form_error('stream'); ?></span>
			  </div>
			  <div class="col-lg-3">
			<label>Particular</label> 
			<?php $array_partc[''] = 'Select Particular';
			$particular = $this->db->get('erp_particulars')->result();
			foreach($particular as $particular){
				$array_partc[$particular->id] = $particular->particular_name; 
			}
			echo form_dropdown('particular', $array_partc, set_value('particular'), 'class="form-control" id="particular" required'); ?>
			<span style="color:red;"><?=form_error('particular')?></span>
		         </div>
			  <div class="col-lg-3">
			<label>Exam Fees</label>   
			<input type="number" class="form-control" name="fees" id="fees" value="<?=set_value('fees')?>">
			<input type="hidden" class="form-control" name="edit_id" id="edit_id" value="<?=set_value('edit_id')?>">
			<span style="color:red;"><?=form_error('fees')?></span>
		         </div> 
			  <div class="col-lg-3 mt-3">
          <div class="form-group" style="float: right;">
			  <button class="btn btn-sm btn-success" name="submit">Update</button>
        </div>
			  </div>
            </div>


              </form>
            </div>
          </div>
        </div>
      </div><!-- End Row-->
	  
	  <!-- Start Table-->
	  <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
              <table id="particular-fees" class="table table-bordered">
                <thead>
            <tr>
                <th>Sno</th>
                <th>Particular</th>
                <th>UG</th>
                <th>PG</th>
                <th>MPHIL</th>
                <th>PG-Diploma</th>
                <th>PMIR</th>
                <th>ph D</th>
            </tr>
        </thead>
        <tbody>
<?php $i=1; foreach($fees_list as $fees){ 
$part = $this->db->where('id',$fees->particular_id)->get('erp_particulars')->row();
$str = array('ug','pg','mphil','pgdiploma','pmir','phd');
for($s=0; $s < count($str); $s++){
$str_part = $this->db->where('particular_id',$fees->particular_id)->where('main_id',$str[$s])->get('erp_exam_fees')->row();
$strpart[$s] = 0;
if(isset($str_part)){
$strpart[$s] = $str_part->fees;}
}
?>
		<tr>
	<td><?=$i?></td> 
      <td><?=$part->particular_name	?></td> 
      <td><?=$strpart[0]?></td>
      <td><?=$strpart[1]?></td>
      <td><?=$strpart[2]?></td>
      <td><?=$strpart[3]?></td>
      <td><?=$strpart[4]?></td>
      <td><?=$strpart[5]?></td>
     
		</tr>  


		<?php

		$i++;
}
?>
        </tbody>
		<tfoot>
            <tr>
                <th>Sno</th>
                <th>Particular</th>
                <th>UG</th>
                <th>PG</th>
                <th>MPHIL</th>
                <th>PG-Diploma</th>
                <th>PMIR</th>
                <th>ph D</th>
            </tr>
        </tfoot>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>
	  
			
	  <!-- End Table-->
	  

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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

var myTable = $('#particular-fees').DataTable({ 
		"bSortCellsTop": true,
			dom: 'Bfrtip',
			buttons: 
			[{ 
				extend: 'excelHtml5',
				title: 'Exam Fees ' + currentDate + '',
				//text:'<i class="fa fa-table fainfo" aria-hidden="true" > Excel</i>',
                "oSelectorOpts": {filter: 'applied', order: 'current'},
				filename: 'Exam Fees_ '+currentDate+'',
				orientation:'landscape',
				exportOptions: {
				 columns: [0,1, 2, 3, 4, 5, 6, 7],
                }
			},
			{ 
				extend: 'pdfHtml5', 
				filename: 'Exam Fees_'+currentDate+'',
				exportOptions: {
					columns: [0, 1, 2, 3, 4, 5, 6, 7],
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
	/*$('#stream').change(function(){
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
		});*/
		
		$('#particular,#stream').change(function(){
			$('#fees').val('');
			$('#edit_id').val('');
		  var particular = $('#particular').val();	
		  var stream = $('#stream').val();	
			if (particular!='' && stream!='') {
            $.ajax({
                url: base_url + "coe/getParticularFees",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    particular: particular,stream: stream
                },
                success: function (data) {
					 var data1 = jQuery.parseJSON(data);
					$('#fees').val(data1.fees);
					$('#edit_id').val(data1.id);
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