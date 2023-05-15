<style>
@charset "utf-8";
/* CSS Document */

body
{
	background-color:white;

}
.alumnihometable1
{
	font-size:18px;
	font-weight:bold;
	width:520px;
	border:2px solid;
	text-align:center;
	border-color:#050119;
	border-radius:8px;
}
input , textarea
{	
	font-family:"Times New Roman", Times, serif;
	font-size:16px;
	font-weight:bold;
	padding:5px;
	border-color:#050119;
	border:2px solid;
	background-color:white;
}
input:focus , textarea:focus
{	
	background-color:#050119;
	color:white;
}
th
{
	text-align:left;
	width:180px;
	border:hidden;
}
.alumnihometd1
{
	text-align:left;
	padding:5px;
}
.profile
{
	width:200px; 
	height:200px; 
	border:2px solid;
	border-radius:8px;
    border-color:#050119;
}
</style>
<h2 style="text-align:center">My Profile</h2>
<br />
<table class=" alumnihometable1 " align="center" style="background-color:#fff;
	border:none;

" cellspacing="15px">
<?php
foreach($row as $row) 
	{
		if($row["pi_picture"]!="" ||$row["pi_picture"]!=NULL){
		echo "<tr>";
		echo "<td colspan=2 align=center><img class=profile src='".base_url().$row["pi_picture"]."' align=center /></td>";
		echo "</tr>";


		}
        echo "<tr>";
		echo "<th>Name:</th>";
		echo "<td class=alumnihometd1>".$row["a_name"]."</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<th>Registration Number:</th>";
		echo "<td class=alumnihometd1>".$row["pi_register"]."</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<th>Gender:</th>";
		echo "<td class=alumnihometd1>".$row["gender"]."</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<th>Address:</th>";
		echo "<td class=alumnihometd1>".$row["address"]."</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<th>Mobile Number:</th>";
		echo "<td class=alumnihometd1>".$row["mobile_number"]."</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<th>Email:</th>";
		echo "<td class=alumnihometd1>".$row["e_mail_id"]."</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<th>Batch:</th>";
		echo "<td class=alumnihometd1>".$row["batch"]."</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<th>Department:</th>";
		echo "<td class=alumnihometd1>".$row["department"]."</td>";
		echo "</tr>";
		echo "<tr>";
    }

?>
</table><br /><br /><br /><br />
