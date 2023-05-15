<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!--<link rel="stylesheet" href="<?=base_url()?>alumniassets/css/forum_list.css" />-->
<br /><br /><br />
<div class="container">
<div class="col-md-12">
<div class="pull-right">
<a type="button" href="<?=base_url().'alumnilogin/addForum'?>" class="btn btn-success"> Add Post</a>
</div>
</div>
</div>
<div class="row">
    <?php if($this->session->flashdata('msg')!="")
    {?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo htmlentities($this->session->flashdata('msg'));?>
<?php echo $this->session->set_flashdata('msg','','success');?>
</div>
</div>
<?php } ?>
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
<?php if($this->session->flashdata('delmsg')!="")
    {?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Delete :</strong> 
 <?php echo htmlentities($this->session->flashdata('delmsg'));?>
<?php echo $this->session->set_flashdata('delmsg','','success');?>
</div>
</div>
<?php } ?>
</div>

<div class="container">
<?php
	$sql = "SELECT * FROM forumdata ORDER BY eforum_time DESC";
	$result = $this->db->query($sql);
	$row = $result->result();
	foreach($row as $row) 
	{        ?>



<div class="col-md-12">
    <h1><?=$row->eforum_title?></h1>
    <p><?=$row->eforum_content?></p>
    <div>
	 <span class="badge">Posted <?=date("d-M-Y",strtotime($row->eforum_time))?></span>	<span class="label label-info">Tags :<?=$row->eforum_tags?></span> 
	 <div class="pull-right">


	 | <i class="icon-comment"></i> <a   data-toggle='modal' data-target='#<?=$row->eforum_id?>' href="#">Comments</a> | <span class="label label-success">Author :<?=$row->eforum_author?></span> 
</div>         
     </div>
    <hr>
   
</div>

<hr>


    
   

  
  
    <!--    echo "<tr>";
		echo "<td class=td1><span class=sp3>#".$row->eforum_id."&nbsp;<strong>".$row->eforum_title."</strong></span>";
		echo "<br /><br /><span class=sp2>".$row->eforum_content."</span>";
		echo "<br /><br /><span class=sp1>Tags: ".$row->eforum_tags." | Author: ".$row->eforum_author." | Time: ".$row->eforum_time."</span></td></tr>";
		echo "<tr><td class=td3><br /> | <button style='color:blue;' class='btn btn-sm btn-success a1' data-id='".$row->eforum_id."' data-toggle='modal' data-target='#largesizemodal'>reply</button> | <td></tr>";
		echo "<tr><td><hr style='padding:1px'></td></tr>";-->
 <?php   }
?>
</div>

 <!-- Modal -->
            <!-- <form action="<?php echo base_url('alumnilogin/listForum'); ?>" method="post">
                <div class="modal fade" id="largesizemodal">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Reply Forum</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
					  
                        <div class="row">
                         <div class="col-sm-6">
                  <div id="replyhere">
<table class="tb1" cellspacing="10px" style="border:hidden;border-radius:2px;border-color:sienna" width="500px">
<tr>
<th colspan="2" align="center" style="font-size:26px;text-decoration:underline">Reply:</th>
</tr>
<tr>
<td style="border:hidden;font-size:16px;font-weight:bold" width="150">Message:</td>
<td style="border:hidden"><textarea class="form-control ta1" type="text" name="replymessage" rows="5" cols="40"></textarea>
<input type="hidden" name="id" class="forum_id"/>
</td>
</tr>
<br />
</table>
</div>
                </div>
						</div>
						
						
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" class="btn btn-primary" name="replypost"><i class="fa fa-check-square-o"></i> Reply</button>
                      </div>
                    </div>
                  </div>
                </div>
				</form>-->
			<!--Modal Ends-->	

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
	var base_url = "<?php echo base_url(); ?>";
	$(document).ready(function(){
	



	});
	</script>
