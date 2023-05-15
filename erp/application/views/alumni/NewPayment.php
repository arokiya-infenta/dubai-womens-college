
<link rel="stylesheet" href="<?=base_url()?>alumniassets/css/header_navigationbar.css" />
<link rel="stylesheet" href="<?=base_url()?>alumniassets/css/add_forum_post.css"/>

<style>
.dropbtn {
    background-color: cornsilk;
    color: #050119;
    padding: 5px 116px;
    font-size: 15px;
	border: 2px solid #050119;
    cursor: pointer;
}

input.i1{
padding: 3px 119px;
    font-size: 15px;
}
	
</style>
<form action="<?=base_url().'alumnilogin/newPayment'?>" method="post">
<table width="710" align="center" style="border:2px hidden;" cellspacing="20">
<tr>
<th align="left" width="450" style="border:hidden;font-size:25px"> Details of Payment: </th>
<td> </td>
</tr>
<tr>
<th align="left" width="450" style="border:hidden;font-size:18px">Payment ID: </th>
<td width="450" style="border:hidden"><input class="form-control" size="45" type="text" value="" name="pid"/></td>
</tr>
<tr>
<th align="left" width="450" style="border:hidden;font-size:18px">Alumni Registration Number: </th>
<td width="450" style="border:hidden"><input class="form-control" size="45" type="text" value="" name="aid"/></td>
</tr>
<tr>
<th align="left" width="450" style="border:hidden;font-size:18px">Payment Purpose </th>
<td width="450" style="border:hidden">
		<select class="form-control dropbtn" name="pp" >
            <option value="Yearly Membership">Yearly Membership</option>
            <option value="Life-time Membership"> Life-time Membership</option>
			<option value="Cash Donation">Cash Donation</option>
			<option value="Registration Fee"> Registration Fee </option>
			</td>
</tr>
<tr>
<th align="left" width="450" style="border:hidden;font-size:18px">Payment Date: </th>
<td width="450" style="border:hidden">
<input class="i1 form-control" type="date" name="pd" max="2020-06-08"required /></td>

</tr>
<tr>
<th align="left" width="450" style="border:hidden;font-size:18px">Payment Amount: </th>
<td width="450" style="border:hidden"><input class="form-control" size="45" type="text" value="" name="pa"></td>
</tr>
<td colspan=2 align="right" style="border:hidden"><button class="btn btn-sm btn-success" type="submit" name="addpayment" >Add Payment</button></td>
</tr>
</table>
</form>