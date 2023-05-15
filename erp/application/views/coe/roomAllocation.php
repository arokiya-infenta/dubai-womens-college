
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
		  <div class="card-header"><i class="fa fa-table"></i>Room Allocation</div>
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
			<span style="color:red;"><?=form_error('batch')?></span>
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
			<span style="color:red;"><?=form_error('sem')?></span>
			  </div>
				 <div class="col-lg-3">
			<label>Section</label>   
			  <select class="form-control" id="section" name="section">
			  <option value="">Select Section</option>
			  <?php $section = array('Forenoon','Afternoon');
			  foreach($section as $section){ ?>
			  <option value="<?=$section?>" <?php if($section1==$section){echo 'selected';}?>><?=$section?></option>
			  <?php } ?>
			  </select>
			<span style="color:red;"><?=form_error('section')?></span>
			  </div>
				 <div class="col-lg-3 mt-4">
				 <div class="form-group" style="float:right;">
			<button type="submit" class="btn btn-sm btn-success" name="submit">Submit</button>
		         </div>
		         </div>
		        </div>
            </form>				
		
			</div>
		   </div>
         </div>
        </div>		 
			
	  
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
			<div class="row">
			   <div class="col-lg-3">
			   <div class="form-group">
			   <a href="<?=base_url().'coe/roomAllocationAdd'?>">
			   <button class="btn btn-sm btn-success">Add Room</button>
			   </a>
			   </div>
			   </div>
			  </div> 
			</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="roomallot-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
						<td>Block</td>
                        <th>Room</th>
                        <th>No of Students</th>
                        <th>No of Arrear Students</th>
						<td>Action</td>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php if(isset($room_list)){
						$sno=1;
					foreach ($room_list as $roomlist) {
						$block = $this->db->where('id',$roomlist->block_id)->get('erp_blocks')->row();
						$room = $this->db->where('id',$roomlist->room_id)->get('erp_rooms')->row();
         $arrear_stu = $this->db
		->where('applied_year',$roomlist->batch_year)
		->where('sem',$roomlist->sem)
		->where('section',$roomlist->section)
		->where('room_id',$roomlist->room_id)
		->get('erp_rows_cols_arrear')->num_rows();
		
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$block->block_name?></td>
                        <td><?=$room->room_name?></td>
						<td><?=$roomlist->total_students?></td>
						<td><?=$arrear_stu?></td>
						<td>
						<a href="<?=base_url(). 'coe/roomAllocationView/'.$roomlist->room_id.'/'.$roomlist->section.'/'.$roomlist->batch_year.'/'.$roomlist->sem.'/'.$roomlist->schedule_date.'/'.$roomlist->subject_id?>">
						<button class="btn btn-sm btn-secondary">View</button></a>
						</td>
                    </tr>
                    <?php }} ?>
                 
               
                </tbody>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>
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

var myTable = $('#roomallot-datatable').DataTable({ 
		"bSortCellsTop": true,
			dom: 'Bfrtip',
			buttons: 
			[{ 
				extend: 'excelHtml5',
				title: 'Room Allocation ' + currentDate + '',
				//text:'<i class="fa fa-table fainfo" aria-hidden="true" > Excel</i>',
                "oSelectorOpts": {filter: 'applied', order: 'current'},
				filename: 'Room Allocation_ '+currentDate+'',
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
				filename: 'Room Allocation_'+currentDate+'',
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
	});
	</script>