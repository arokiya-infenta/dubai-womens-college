
    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Manage Categories</h4>
    </div>
     <div class="row">
    <?php if($this->session->flashdata('error')!="")
    {?>
<div class="col-md-6">
<div class="alert alert-danger" >
 <strong>Error :</strong> 
 <?php echo htmlentities($this->session->flashdata('error'));?>
<?php echo $this->session->set_flashdata('error','','success');?>
</div>
</div>
<?php } ?>
<?php if($this->session->flashdata('msg')!="")
{?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo $this->session->flashdata('msg'); ?>
<?php echo $this->session->set_flashdata('form_err','','success');?>
</div>
</div>
<?php } ?>
<?php if($this->session->flashdata('updatemsg')!="")
{?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo $this->session->flashdata('updatemsg'); ?>
<?php echo $this->session->set_flashdata('updatemsg','','success');?>
</div>
</div>
<?php } ?>


   <?php if($this->session->flashdata('delmsg')!="")
    {?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo $this->session->flashdata('delmsg'); ?>
<?php echo $this->session->set_flashdata('delmsg','','success');?>
</div>
</div>
<?php } ?>

</div>


        </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Categories Listing
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
							<form role="form" action="<?php echo base_url().'librarylogin/manageCategory'?>" method="post">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Creation Date</th>
                                            <th>Updation Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php $sql = "SELECT * from  tblcategory";
$query = $this->db->query($sql);
$results=$query->result();
$cnt=1;
if($query->num_rows() > 0)
{
foreach($results as $result)
{               ?>                                      
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo htmlentities($cnt);?></td>
                                            <td class="center"><?php echo htmlentities($result->CategoryName);?></td>
                                            <td class="center"><?php if($result->Status==1) {?>
                                            <a href="#" class="btn btn-success btn-xs">Active</a>
                                            <?php } else {?>
                                            <a href="#" class="btn btn-danger btn-xs">Inactive</a>
                                            <?php } ?></td>
                                            <td class="center"><?php echo htmlentities($result->CreationDate);?></td>
                                            <td class="center"><?php echo htmlentities($result->UpdationDate);?></td>
                                            <td class="center">
                                            <a href="<?php echo base_url().'librarylogin/editCategory/'.$result->id?>">
                                            <button type="button" class="btn btn-primary"><i class="fa fa-edit "></i> Edit</button> </a>
											<input type="hidden" class="edit_id" name="edit_id[]" value="<?=$result->id?>">
                                          <button type="submit" class="btn btn-danger delete" name="del" onclick="return confirm('Are you sure you want to delete?');"><i class="fa fa-pencil"></i> Delete</button>
                                            </td>
                                        </tr>
 <?php $cnt=$cnt+1;}} ?>                                      
                                    </tbody>
                                </table>
								</form>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>


            
    </div>
    </div>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
$(document).ready(function(){
	$('.delete').click(function(){
	  var del_btn = $(this).parent().find('.edit_id').val();	
		$('.delete').each(function(){
			var editid = $(this).parent().find('.edit_id');
		if(editid.val() != del_btn){
			editid.val('');
		}
		});
	});
});
</script>