
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" href="<?=base_url()?>alumniassets/css/header_navigationbar.css" />
<link rel="stylesheet" href="<?=base_url()?>alumniassets/css/add_forum_post.css"/>

<style>
/* table, th, td {
    border: 2px solid #050119;
    border-collapse: collapse;
	font-size: 20px;
	width : 900px;
	text-align: center;
} */
</style>
<div class="row" style="padding-top: 40px;">
<?php if($this->session->flashdata('error')!="") {?>
	<div class="col-md-3"></div>
<div class="col-md-6">
<div class="alert alert-danger" style="
    line-height: 44px;text-align: center;
">
 <strong>Error :</strong> 
 <?php echo htmlentities($this->session->flashdata('error'));?>
<?php echo $this->session->set_flashdata('error','','success');?>
</div>
</div>
<div class="col-md-3"></div>
<?php } ?>
<?php if($this->session->flashdata('msg')!="") {?>
<div class="col-md-3"></div>
<div class="col-md-6">
<div class="alert alert-success" style="
    line-height: 44px;text-align: center;
">
 <strong>Success :</strong> 
 <?php echo htmlentities($this->session->flashdata('msg'));?>
<?php echo $this->session->set_flashdata('msg','','success');?>
</div>
</div>
<div class="col-md-3"></div>
<?php } ?>
</div>
<br><br>
<form action="<?=base_url().'alumnilogin/approve'?>" method="post">
<table align="center" style="border:2px hidden;" cellspacing="20">
<caption style= "font-size:25px"> <b>Insert Alumni Registration Number for approval:</b> </caption>
<tr>
<th align="left" width="250" style="border:hidden;font-size:20px">Alumni Registration Number: </th>
<td width="150" style="border:hidden"><input class="form-control" size="45" type="text" value="" name="aluid"/></td>
</tr>
<tr>
<td  align="right" style="border:hidden">
<br><button class="btn btn-sm btn-success text-right" type="submit" name="approve" onclick="return confirm('Are you sure to approve?');">Approve</button></td>
</tr>
</table>
</form>
<br></br><br></br>
<div class="container">
<div class="row">
<table class="table" style="color:aliceblue;" align="center">
<caption> Alumni without Approval </caption>
<tr>
	<th>NO </th>
	<th> Alumni Registration Number</th>
	<th> Alumni Name </th>
	<th> Department </th>
	<th> Batch</th>
	<th> Designation</th>
	<th> Approval Status </th>
</tr>

<?php

$no = 1;

foreach ($resultAWA as $row)
{ ?>
<tr>
<td><?=$no?></td>
<td><?=$row->pi_register?></td>
<td><?=$row->a_name?></td>
<td><?=$row->department?></td>
<td><?=$row->batch?></td>
<td><?=$row->current_position?></td>
<td><?=$row->al_status?></td>
</tr>
<?php	$no++;
 }
?>
</table>
</div></div>
<br><br><br><br><br><br>
