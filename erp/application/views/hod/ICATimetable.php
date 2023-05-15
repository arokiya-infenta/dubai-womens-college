<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
<!--Sweet Alert-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
    <link rel="stylesheet" href="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css" />
	
 
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



      <!--Start Dashboard Content-->
	 

		
        <div class="row">
					 <div class="col-md-2 "></div>
					 <div class="col-md-8 ">
					  <?php if(!empty($this->session->flashdata('message'))){

echo $this->session->flashdata('message');
$this->session->set_flashdata("message","");
            } ?>
					 </div>
					 <div class="col-md-2 "></div>
					</div>	

      <div class="row">



   
        <div class="col-lg-12">
		<div class="hide-it" align="center"><h4 style="color:#15ca20;"><?php echo $this->session->flashdata('success'); ?></h4></div>
          <div class="card">
            <div class="card-header"><i class="fa fa-file-text"></i> Allocate Subject </div>
            <div class="card-body">





          <form action="" method="post">
                   <div class="row mt-3">
				   <div class="col-lg-2">
          <label>ICA</label>
		  <select class="form-control" name="ica" id="ica">
		  <option value="">Select ICA</option>
		  <?php $ica = array('1'=>'ICA 1','2'=>'ICA 2');foreach($ica as $ica=>$value){
			  ?>
			  <option value="<?=$ica?>" <?php if($ica1==$ica){echo 'selected';}?>><?=$value?></option>
		  <?php } ?>
		  </select>
		  <span style="color:red;"><?php echo form_error('ica');?></span>
			  </div>
			 <div class="col-lg-2">
          <label>Batch</label>
		  <select class="form-control" name="batch" id="batch">
		  <option value="">Select Batch</option>
		  <?php $batch = $this->db->get('erp_batchmaster')->result();foreach($batch as $batch){?>
			  <option value="<?=$batch->id?>" <?php if($batch1==$batch->id){echo 'selected';}?>><?=$batch->batch_from?></option>
		  <?php } ?>
		  </select>
		  <span style="color:red;"><?php echo form_error('batch');?></span>
			  </div> 
			<div class="col-lg-2">
          <label>Semester</label>
		  <select class="form-control" name="sem" id="sem">
		  <option value="">Select Sem</option>
		  <?php $semst = array('1','2','3','4','5','6');foreach($semst as $semst){?>
			  <option value="<?=$semst?>" <?php if($sem1==$semst){echo 'selected';}?>><?=$semst?></option>
		  <?php } ?>
		  </select>
		  <span style="color:red;"><?php echo form_error('sem');?></span>
		  <input type="hidden" value="<?=$main_id?>" id="stream" name="stream">
		  <input type="hidden" value="<?=$course_id?>" id="department" name="department">
			  </div>
			  <?php //if($subject1!=''){$style1='style="display:block"';}else{$style1='style="display:none"';}; ?>
			  <div class="col-lg-3" id="sub" >
			  <label>Subject</label>
			  <select class="form-control single-select" id="subject" name="subject">
			  <option value="">Select Subject</option>
			  <?php if($subject1!=''){
				  foreach($subject as $subject){ ?>
			  <option value="<?=$subject->id?>" <?php if($subject1==$subject->id){echo 'selected';}?>><?=$subject->subName?></option>
			  <?php }} ?>
			  </select>
			  <span style="color:red;"><?php echo form_error('subject');?></span>
			  </div>
			  <div class="col-lg-2" id="date">
			  <label>Date</label>
			  <input type="date" class="form-control" name="date" value="<?=$date1?>">
			  <span style="color:red;"><?php echo form_error('date');?></span>
			  </div>
					 <div class="col-md-1 mt-4">
					 <div class="form-group" style="float:right;">
           <input  type="Submit" id="submit" name="submit" class="btn btn-sm btn-primary text-right" value="Submit" >
           
           </div>
           </div>
			  </div>
					</form>

   



            </div>
          </div>
        </div>


        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-file-text"></i> ICA Time Table 
			<hr>
			<form action="" method="post">
			<div class="row">
            <div class="col-lg-2">
			<label>Batch</label>
			<select class="form-control" name="batch" id="batch" required>
			<option value="">Select Batch</option>
			<?php $batch_b = $this->db->get('erp_batchmaster')->result();
			foreach($batch_b as $batch_b){?>
			<option value="<?=$batch_b->id?>" <?php if($batch2==$batch_b->id){echo 'selected';}?>><?=$batch_b->batch_from?></option>
			<?php } ?>
			</select>
		         </div>
			  <div class="col-lg-2">
			<label>Sem</label>
			  <select class="form-control" id="sem" name="sem" required>
			  <option value="">Select Semester</option>
			  <?php $sem_b = array('1','2','3','4','5','6');
			  foreach($sem_b as $sem_b){ ?>
			  <option value="<?=$sem_b?>" <?php if($sem2==$sem_b){echo 'selected';}?>><?=$sem_b?></option>
			  <?php } ?>
			  </select>
			  </div>
			  <div class="col-lg-2">
          <label>ICA</label>
		  <select class="form-control" name="ica">
		  <option value="">Select ICA</option>
		  <?php $ica_b = array('1'=>'ICA 1','2'=>'ICA 2');foreach($ica_b as $ica_b=>$value_b){
			  ?>
			  <option value="<?=$ica_b?>" <?php if($ica2==$ica_b){echo 'selected';}?>><?=$value_b?></option>
		  <?php } ?>
		  </select>
			  </div>
			  <div class="col-md-6 mt-3">
					 <div class="form-group" style="float:right;">
           <input  type="Submit" id="submit" name="list_tt" class="btn btn-primary text-right" value="Submit" >
           
           </div>
           </div>
			  </div>
			  </form>
			</div>
            <div class="card-body">
<?php if(isset($timetable)){ ?>
            <table id="icatimetable-datatable"  class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>S.No</th>
      <th>ICA</th>
      <th>Subject</th>
      <th>Date</th>
      <th>Action</th> 
    </tr>
  </thead>
  <tbody>
  <?php $sno=1;
  foreach($timetable as $timetable){
	$subje_nm=$this->db->where('id',$timetable->subject_id)->get('erp_subjectmaster')->row();  
	  ?>
  <tr>
  <td><?=$sno++?></td>
  <td>ICA <?=$timetable->ICA?></td>
  <td><?=$subje_nm->subName?></td>
  <td class="date_<?=$timetable->id?>"><?=date('d-m-Y',strtotime($timetable->date))?></td>
  <td>
  <button type="button" class="btn btn-success btn-sm edit" data-target="#myModal" data-toggle="modal" data-id="<?=$timetable->id?>"><i class="fa fa-pencil"></i></button>
  <button type="button" class="btn btn-danger btn-sm delete" data-id="<?=$timetable->id?>"><i class="fa fa-trash"></i></button>
  </td>
  </tr>
  <?php } ?>
  </tbody>
</table>   
<?php } ?>  

				
      </div>
      </div>
      </div>


      </div>
	
  
 <!-- Modal Add-->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Timetable</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
		<!--<form action="<?php echo base_url().'pgSelfFinance/allocateSubjectEdit'?>" method="post">-->
        <div class="modal-body">
          
		  <div class="row">
			<div class="col-md-12">
			<label>Date</label>
			<input type="date" class="form-control" id="edit_date">
			<input type="hidden" id="edit_id">
			</div>
			</div>	
			
        </div>
        <div class="modal-footer">
          <button type="submit" name="submit_edit" class="btn btn-success update">Update</button>
          <button type="button" class="btn btn-default close" data-dismiss="modal">Close</button>
        </div>
      </div>
	  <!--</form>-->
      
    </div>
  </div>
  

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <style>
    .anc {
  position: relative;
  float: right;
}
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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

var myTable = $('#icatimetable-datatable').DataTable({ 
		"bSortCellsTop": true,
			dom: 'Bfrtip',
			buttons: 
			[{ 
				extend: 'excelHtml5',
				title: 'ICA Timetable ' + currentDate + '',
				//text:'<i class="fa fa-table fainfo" aria-hidden="true" > Excel</i>',
                "oSelectorOpts": {filter: 'applied', order: 'current'},
				filename: 'ICA Timetable_ '+currentDate+'',
				orientation:'portrait',
				exportOptions: {
				 columns: [0,1,2,3],
                }
			},
			{ 
				extend: 'pdfHtml5', 
				filename: 'ICA Timetable_'+currentDate+'',
				exportOptions: {
					columns: [0, 1,2,3],
				},
				orientation:'portrait',
				pageSize: 'A4', 
                alignment: "center",
				customize: function (doc) {
					doc.content[1].margin = [ 0, 0, 0, 0 ] //left, top, right, bottom
					 
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
			$('#sem').val('');
		});			
		
		$('#sem').change(function(){
			$('#sub').css('display','block');
			$('#subject').empty();
		  var stream = $('#stream').val();	
		  var dept = $('#department').val();	
		  var batch = $('#batch').val();	
		  var sem = $(this).val();	
			if (sem!='' && batch!='') {
            $.ajax({
                url: base_url + "hod/getSubjectSemwise",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    stream: stream,
                    batch: batch,
                    dept: dept,
                    sem: sem,
                },
                success: function (data) {
					$('#subject').append(data);
                }
            });
        }else{
			$('#sub').css('display','none');
		}
		});
		
		$('.edit',allPages).click(function(){
			$('#edit_id').empty();
			$('#edit_date').empty();
		  var id = $(this).data('id');
            $.ajax({
                url: base_url + "hod/getICATimetable",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    id: id,
                },
                success: function (data) {
					var data1 = JSON.parse(data);
					var edit_id = data1.id;
					var edit_date = data1.date;
					$('#edit_id').val(edit_id);
					$('#edit_date').val(edit_date);
                }
            });
		});
		
		$('.update',allPages).click(function(){
		  var id = $('#edit_id').val();	
		  var date = $('#edit_date').val();	
		  if(confirm('Are you sure to update?')){
            $.ajax({
                url: base_url + "hod/updateICATimetable",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    id: id,
                    date: date,
                },
                success: function (data) {
					alert('Updated Successfully');
                    var dateAr = date.split('-');
                    var newDate = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0];
					$('#myModal .close').click();
					$('.date_'+id+'').text(newDate);
                }
            });
		  }
		});
		
	$(document).on('click', '.delete', allPages, function(event){
	var id1 = $(this).attr("data-id");
	var $ele = $(this).parent().parent();
	swal({
        title: "Are you sure?",
        text: "You will not be able to recover this file!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger btn-sm",
        cancelButtonClass: "btn-secondary btn-sm",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel!",
        closeOnConfirm: false,
        closeOnCancel: false
      },
	  function(isConfirm) {
	    if(isConfirm){
		$.ajax({
			url: "<?php echo base_url();?>hod/delete_ica_timetable",
			method: "POST",
			cache: false,
			data:{
				type: 2,
				id: id1
			},
			success: function(dataResult){
				$ele.fadeOut().remove();
				swal("Deleted!", "Your file has been deleted.", "success");
				
			}
		});
		}else{
		swal("Cancelled", "Your file is safe :)", "error");
		}
	});
	});
		
	});
    
    
    </script>
	
    <script>
	   setTimeout(function() {
            $('.hide-it').hide('fast');
        }, 3000);
    </script>
    