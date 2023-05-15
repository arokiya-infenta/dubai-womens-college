<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>



<style>
/* table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 70%;
	background-color: white;
}

td, th {
    border: 1px solid #050119;
    text-align: center;
    padding: 8px;
}
 */
#button1 {
	padding: 5px 20px;
    background-color: #F9E79F;
    color: black;
    border: 2px solid #FEF9E7;
}
	
</style>

<h4 style="padding-left:100px; text-align: center;"><b>View Alumni Registered</b>  </h4>
<br>
<div class="container">
<div class="row">
<table class="table table-striped">
  <thead class="thead-dark">
<tr>
	<th>NO </th>
	<th> Alumni Registration Number</th>
	<th> Alumni Name </th>
	<th> Department </th>
	<th> Batch</th>
	<th> Designation</th>
	<th> Approval Status </th>
</tr>
  </thead>
  <tbody>
<?php

$no = 1;

foreach ($result1 as $row)
{ ?>
<tr>
<td><?=$no++?></td>
<td><?=$row->pi_register?></td>
<td><?=$row->a_name?></td>
<td><?=$row->department?></td>
<td><?=$row->batch?></td>
<td><?=$row->current_position?></td>
<td><?=$row->al_status?></td>
</tr>
<?php }
?>
<tr>
<td colspan="7" style= 'text-align:right'><a href="<?=base_url().'alumnilogin/approve'?>"> Approve Membership </a> </td>
</tr>
</table>
</tbody>
</div>
</div>
<br><br><br><br>
