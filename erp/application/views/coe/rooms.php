
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
		  <div class="card-header"><i class="fa fa-table"></i> Room Details</div>
            <div class="card-body">
			
			<form action="" method="post">
			   <div class="row">
			   <div class="col-lg-3">
			<label>Block</label>   
			<select class="form-control" name="block" id="block">
			<option>Select Block</option>
			<?php $blocks = $this->db->get('erp_blocks')->result();
            foreach($blocks as $blocks){			
			?>
			<option value="<?=$blocks->id?>"><?=$blocks->block_name?></option>
			<?php } ?>
			</select>
			<input type="hidden" class="form-control" name="edit_id" id="edit_id">
			<span style="color:red;"><?=form_error('block')?></span>
		         </div>
				 <div class="col-lg-3">
			<label>Room Number</label>   
			<input type="number" class="form-control" name="room_no" id="room_no" max="100">
			<span style="color:red;"><?=form_error('room_no')?></span>
		         </div>
				 <div class="col-lg-3">
			<label>Room Name</label>   
			<input type="text" class="form-control" name="room_name" id="room_name" maxlength=25>
			<span style="color:red;"><?=form_error('room_name')?></span>
		         </div>
				 <div class="col-lg-3">
			<label>Seater Type</label>   
			<select class="form-control" name="seater" id="seater">
			<option>Select Seater</option>
			<?php $seaters = array('1','2','3');
            foreach($seaters as $seaters){			
			?>
			<option value="<?=$seaters?>"><?=$seaters?></option>
			<?php } ?>
			</select>
			<span style="color:red;"><?=form_error('seater')?></span>
		         </div>
				 <div class="col-lg-3">
			<label>Capacity</label>   
			<input type="number" class="form-control" name="capacity" id="capacity" max="200">
			<span style="color:red;"><?=form_error('capacity')?></span>
		         </div>
				 <div class="col-lg-3">
			<label>Row</label>   
			<input type="rows" class="form-control" name="rows" id="rows" max="50">
			<span style="color:red;"><?=form_error('rows')?></span>
		         </div>
				 <div class="col-lg-3">
			<label>Column</label>   
			<input type="number" class="form-control" name="columns" id="columns" max="50">
			<span style="color:red;"><?=form_error('columns')?></span>
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
            <div class="card-body">
              <div class="table-responsive">
              <table id="room1" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
						<th>Block</th>
                        <th>Room Number</th>
                        <th>Room Name</th>
                        <th>Seater</th>
                        <th>Capacity</th>
                        <th>Row</th>
                        <th>Column</th>
						<th>Action</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php if(isset($room_list)){
						$sno=1;
					foreach ($room_list as $roomlist) {
						$blockdet = $this->db->where('id',$roomlist->block_id)->get('erp_blocks')->row();
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$blockdet->block_name?></td>
                        <td><?=$roomlist->room_no?></td>
                        <td><?=$roomlist->room_name?></td>
                        <td><?=$roomlist->seater?> Seater</td>
                        <td><?=$roomlist->capacity?></td>
                        <td><?=$roomlist->rows?></td>
                        <td><?=$roomlist->columns?></td>
						<td>
						<button class="btn btn-sm btn-warning update" data-id="<?=$roomlist->id?>">Edit</button>
						<a href="<?=base_url(). 'coe/roomsDelete/'.$roomlist->id?>">
						<button class="btn btn-sm btn-danger" onClick="return(confirm('Are you sure to delete?'))">Delete</button></a>
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
var myTable = $('#exammarks-datatable').DataTable();
var allPages = myTable.rows().nodes().to$();
		
		$('.update').click(function(){
		  var id = $(this).data('id');		
            $.ajax({
                url: base_url + "coe/roomsUpdate",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    id: id
                },
                success: function (data) {
					dataParse = JSON.parse(data);
					var block = dataParse.block_id;
					var room_no = dataParse.room_no;
					var room_name = dataParse.room_name;
					var seater = dataParse.seater;
					var capacity = dataParse.capacity;
					var rows = dataParse.rows;
					var columns = dataParse.columns;
					var edit_id = dataParse.id;
					$('#block').val(block);
					$('#edit_id').val(edit_id);
					$('#room_no').val(room_no);
					$('#room_name').val(room_name);
					$('#seater').val(seater);
					$('#capacity').val(capacity);
					$('#rows').val(rows);
					$('#columns').val(columns);
                }
            });
		});
	});
	</script>