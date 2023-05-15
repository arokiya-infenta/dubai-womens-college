
<link rel="stylesheet" href="<?=base_url()?>alumniassets/css/header_navigationbar.css" />

<style>
table {
	align: center;
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 70%;
	background-color: white;
}
td, th {
    border: 2px solid #050119;
    text-align: center;
    padding: 8px;
}

</style>


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
<h3><center> Alumni Financial Record </center></h3>
<table align="center" id="Payment">
<tr>
	<th> No. </th>
	<th> Payment ID</th>
	<th> Alumni Name</th>
	<th> Payment Purpose</th>
	<th> Payment Date </th>
	<th> Total Payment </th>
</tr>

<?php

$no = 1;

foreach ($resultfin as $row)
{ ?>
<tr>
<td><?=$no?></td>
<td><?=$row->payment_id?></td>
<td><?=$row->pi_name?></td>
<td><?=$row->payment_purpose?></td>
<td><?=$row->payment_date?></td>
<td><?=$row->total_payment?></td>
</tr>
<?php	$no++; } ?>

</table>
<br><br><br><br>