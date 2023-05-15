
<div id="page-wrapper">
<div class="row">
<?php if($this->session->flashdata('error')!="") {?>
<div class="col-md-6">
<div class="alert alert-danger" >
 <strong>Error :</strong> 
 <?php echo htmlentities($this->session->flashdata('error'));?>
<?php echo $this->session->set_flashdata('error','','success');?>
</div>
</div>
<?php } ?>
<?php if($this->session->flashdata('msg')!="") {?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo htmlentities($this->session->flashdata('msg'));?>
<?php echo $this->session->set_flashdata('msg','','success');?>
</div>
</div>
<?php } ?>
</div>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header titlehms">Notice Board</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-info-circle fa-fw"></i> Hostel Notice Information
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form name="notice" action="<?=base_url()?>hosteladminlogin/listNotice"   accept-charset="utf-8" method="post" enctype="multipart/form-data">


                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <div class="form-group ">
                                                <label>Title</label>
                                                <div class="input-group">

                                                    <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                                    <input type="text" placeholder="Notice Title" class="form-control" name="title" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group ">
                                                <label>Description</label>
                                                <div class="input-group">

                                                    <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                                    <textarea rows="1" placeholder="Description" class="form-control" name="description" required></textarea>
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-lg-12">

                                        <div class="col-lg-2">
                                            <div class="form-group ">
                                                <button type="submit" class="btn btn-success" name="btnSave" ><i class="fa fa-2x fa-check"></i>Save</button>
                                            </div>

                                        </div>
                                        <div class="col-lg-7">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <hr />
                            <?php  if(sizeof($notice_list) > 0) { ?>
<div class="table-responsive">
 <table id="noticeList" class="table table-striped table-bordered table-hover">
  <thead>
  <tr>
                                            <th>Title</th>
                                            <th>Description</th>
                                             <th>Sumited Date</th>
                                              <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
      <?php    foreach($notice_list as $row ) { $isData="1";?>
                <tr>
                <td><?=$row->title?></td>
                <td><?=$row->description?></td>
                <td><?=$row->createdDate?></td>
				<td><a title='Edit' class='btn btn-success btn-circle' href='<?=base_url()."hosteladminlogin/updateNotice/".$row->serial?>'><i class='fa fa-pencil'></i></a>&nbsp&nbsp<a title='Delete' class='btn btn-danger btn-circle' href='<?=base_url()."hosteladminlogin/deleteNotice/".$row->serial?>' onclick="return confirm('Are you sure to delete?');"><i class='fa fa-trash-o'></i></a></td>
                </tr>
   <?php } ?>
    </tbody>
                                </table>
                            </div>
		<?php } else
                             {
                                 echo "<h1 class='text-warning'>Notice Not Found!!!</h1>";
                             }
							 ?>
                        </div>
                    </div>


                </div>
                <!-- /.panel-body -->
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>

</div>
<!-- /#page-wrapper -->


<!-- jQuery Script-->
<script src="<?php echo base_url();?>hostelassets/dist/js/jquery.min.js"></script>
<script type="text/javascript">
    $( document ).ready(function() {



        $('#noticeList').dataTable();
    });




</script>