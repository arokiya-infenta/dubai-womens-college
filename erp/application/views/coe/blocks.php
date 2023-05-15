
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
		  <div class="card-header"><i class="fa fa-table"></i> Block Details</div>
            <div class="card-body">
			
			<form action="" method="post">
			   <div class="row">
			   <div class="col-lg-3">
			<label>Block ID</label>   
			<input type="text" class="form-control" name="block_id" id="block_id" value="<?=$block_id?>" readonly>
			<input type="hidden" class="form-control" name="edit_id" id="edit_id">
			<span style="color:red;"><?=form_error('block_id')?></span>
		         </div>
				 <div class="col-lg-3">
			<label>Block Name</label>   
			<input type="text" class="form-control" name="block_name" id="block_name" maxlength=25>
			<span style="color:red;"><?=form_error('block_name')?></span>
		         </div>
				 <div class="col-lg-6 mt-4">
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
              <table id="block1" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
						<th>Block ID</th>
                        <th>Block Name</th>
						<th>Action</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php if(isset($block_list)){
						$sno=1;
					foreach ($block_list as $blocks) {
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$blocks->block_id?></td>
                        <td><?=$blocks->block_name?></td>
						<td>
						<button class="btn btn-sm btn-warning update" data-id="<?=$blocks->id?>">Edit</button>
						<a href="<?=base_url(). 'coe/blocksDelete/'.$blocks->id?>">
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
		
		$('.update').click(function(){
		  var id = $(this).data('id');		
            $.ajax({
                url: base_url + "coe/blocksUpdate",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    id: id
                },
                success: function (data) {
					dataParse = JSON.parse(data);
					var block_id = dataParse.block_id;
					var block_name = dataParse.block_name;
					var edit_id = dataParse.id;
					$('#block_id').val(block_id);
					$('#edit_id').val(edit_id);
					$('#block_name').val(block_name);
                }
            });
		});
	});
	</script>