

<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" href="<?=base_url()?>alumniassets/css/index.css" />
<style>
/* .dropbtn {
    background-color: white;
    color: #red;
    padding: 5px 116px;
    font-size: 15px;
	border: 2px #050119;
    cursor: pointer;
}

input.i1{
padding: 3px 119px;
    font-size: 20px;
} */
	
</style>
<style>
	td.alumni1, th.alumni1 {
    border: 1px solid #dddddd;
    text-align: center;
    padding: 5px;
}
/* table#alumni {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 90%;
	background-color: #F9E79F;
}

td.alumni1, th.alumni1 {
    border: 1px solid #dddddd;
    text-align: center;
    padding: 5px;
}

#button1 {
	padding: 5px 20px;
    background-color: #F9E79F;
    color: black;
    border: 2px solid #FEF9E7;
} */
	
</style>
<form action="<?=base_url().'alumnilogin/searchAlumni'?>" method="post">
<center><width="450" style="border:hidden;font-size:25px"><b> Search Alumni </b></center>
<table width="710" align="center" style="border:2px hidden;" cellspacing="20">

<tr>
<th align="left" width="450" style="border:hidden;font-size:18px">Name </th>
<td width="450" style="border:hidden"><input class="form-control" size="45" type="text" value="" name="pid"/></td>
</tr>
<tr>
<th align="left" width="450" style="border:hidden;font-size:18px"> </th>
<td width="450" style="border:hidden;font-size:15px">OR</td>
</tr>
<tr>
<th align="left" width="450" style="border:hidden;font-size:18px">Registration Number </th>
<td width="450" style="border:hidden"><input class="form-control" size="45" type="text" value="" name="aid"/></td>
</tr>

<tr>
<th align="left" width="450" style="border:hidden;font-size:18px"> </th>
<td colspan=2 align="right" style="border:hidden"></td>
</tr><tr>
<th align="left" width="450" style="border:hidden;font-size:18px"> </th>
<td colspan=2 align="right" style="border:hidden">
<br>
<br>
<button class="btn btn-sm btn-success" type="submit" name="search" >Submit</button></td>
</tr>
</table>
<br><br><br><br>
<?php 
//$resultAWA =[];




//print_r($resultAWA);
if(sizeof($resultAWA) > 0){?>
<center><b><h3 style="padding-left:100px"> View Alumni Members </h3></b></center>
<br>
<div class="container">
<div class="row">
<table class="table">
  <thead class="thead-dark">
<tr>
    <th > Serial Number </th>     
    <th class="alumni1"> Registration Number </th>
    <th class="alumni1"> Name </th>
    <th class="alumni1"> Gender</th>
    <th class="alumni1"> Department</th>
    <th class="alumni1"> Batch </th>
    <th class="alumni1"> Email </th>
    <th class="alumni1"> Mobile </th>
    <th class="alumni1"> Designation </th>
</tr>
  </thead>
  <tbody>
<?php

$no = 1;
foreach ($resultAWA as $row)
{ ?>
<tr>
<td class="alumni1"><?= $no++ ?></td>
<td class="alumni1"><?= $row->pi_register?></td>
<td class="alumni1"><?= $row->a_name?></td>
<td class="alumni1"><?= $row->gender?></td>
<td class="alumni1"><?= $row->department?></td>
<td class="alumni1"><?= $row->batch?></td>
<td class="alumni1"><?= $row->e_mail_id?></td>
<td class="alumni1"><?= $row->mobile_number?></td>
<td class="alumni1"><?= $row->current_position?></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
<?php } ?>

<br><br><br><br>
