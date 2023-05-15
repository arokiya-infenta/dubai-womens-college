

<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" href="<?=base_url()?>alumniassets/css/header_navigationbar.css" />
<!--<link rel="stylesheet" href="<?=base_url()?>alumniassets/css/event&ann.css" />-->



<div align="center">
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
<?php echo $this->session->set_flashdata('msg','','success');?>
</div>
</div>
<?php } ?>
<?php if($this->session->flashdata('delete')!="")
{?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo $this->session->flashdata('delete'); ?>
<?php echo $this->session->set_flashdata('delete','','success');?>
</div>
</div>
<?php } ?>
</div>
<br><br>
<?php
	$sql = "SELECT * FROM alumni_announcement where ann_time >= '".date("Y-m-d")."' ORDER BY ann_created DESC";
	$result = $this->db->query($sql)->result();
	$sql2 ="SELECT ann_name FROM alumni_announcement ORDER BY ann_created DESC";
	$result2 = $this->db->query($sql2);
	$rowcount=$result2->num_rows();
	$r=0;?>


<!--
<form action="<?=base_url().'alumnilogin/deleteAnnouncement'?>" method="post">
<table class="tb1" cellspacing="10">
<thead><a href="<?=base_url().'alumnilogin/addAnnouncement'?>">
<button type="button" class="btn btn-sm btn-success"> Add Announcement </button></a> 
</thead>
<tbody>
<th class="th1">Announcement</th>
<?php
	foreach($result as $row) 
	{?>
     <tr>
	 <td class="td1"><span class="sp3"><?=$row->ann_name?></span>
		<br /><span class="sp2"><?=$row->ann_desc?></span>
		<br /><br /><span class="sp1">Announcement Time: <?=$row->ann_time?></span>
		<br /><br /><a type="submit" href="<?=base_url().'alumnilogin/deleteAnnouncement/'.$row->ann_id?>" onclick="return confirm('Are you sure you want to delete?');"> Delete Announcement </a>
		<hr class="line">
		</td></tr>
   <?php } ?>
</tbody>   
</table><br /><br />
</form>-->
</div>
<div class="container">
<div class="row">

<br><br>
</div>
</div>
<div class="container">
<?php
	
	foreach($result as $row) 
	{        ?>



<div class="col-md-12">
    <h1><?=$row->ann_name?></h1>
    <p><?=$row->ann_desc?></p>
    <div>
	 <span class="badge">Announcement Time <?=date("d-M-Y",strtotime($row->ann_time))?></span>	<span class="label label-info">Announcement Id :<?=$row->ann_id?></span> 
	 <div class="pull-right">
 
</div>         
     </div>
    <hr>
   
</div>

<hr>

<!--<div class="modal fade" id="<?=$row->eforum_id?>">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Comments</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
					  
                        <div class="row">

						</div>
						
						
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" class="btn btn-primary" name="replypost"><i class="fa fa-check-square-o"></i> Reply</button>
                      </div>
                    </div>
                  </div>
                </div>->
    <!--    echo "<tr>";
		echo "<td class=td1><span class=sp3>#".$row->eforum_id."&nbsp;<strong>".$row->eforum_title."</strong></span>";
		echo "<br /><br /><span class=sp2>".$row->eforum_content."</span>";
		echo "<br /><br /><span class=sp1>Tags: ".$row->eforum_tags." | Author: ".$row->eforum_author." | Time: ".$row->eforum_time."</span></td></tr>";
		echo "<tr><td class=td3><br /> | <button style='color:blue;' class='btn btn-sm btn-success a1' data-id='".$row->eforum_id."' data-toggle='modal' data-target='#largesizemodal'>reply</button> | <td></tr>";
		echo "<tr><td><hr style='padding:1px'></td></tr>";-->
 <?php   }
?>
</div>
