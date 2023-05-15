
<div>
<br /><br />
<h2 style="text-align: center;">Update Profile</h2>
<br />
<form action="" method="post" enctype="multipart/form-data">
<table class="updatetable1" cellspacing="20px" align="center">
<tr>
    <th>Name:</th>
    <td class="updatetd1"><input class="form-control" type="text" name="name" required value="<?=$profile->a_name?>"></td>
  </tr>  
<tr>
    <th>Gender:</th>
    <td class="updatetd1"><select id="select"  class ="form-control" name="pi_gender" required>
				<option value="">Gender</option>
				<option  <?php if($profile->gender == "Male"){echo"selected";} ?> value="Male">Male</option>							
				<option  <?php if($profile->gender == "Female"){echo"selected";} ?>  value="Female">Female</option>
				<option  <?php if($profile->gender == "Others"){echo"selected";} ?>  value="Others">Others</option>
			</select></td>
  </tr> 
  <tr>
    <th>Mobile Number:</th>
    <td class="updatetd1"><input class="form-control" type="text" name="contact" size="38" maxlength="10" pattern="[0-9]{10}"required value="<?=$profile->mobile_number?>"></td>
  </tr>
  <tr>
    <th>Designation:</th>
    <td class="updatetd1"><input class="form-control" type="text" name="comp" size="38" value="<?=$profile->current_position?>" /></td>
  </tr>
  <tr>
    <th>Email:</th>
	<td class="updatetd1"><input class="form-control" type="email" name="email" size="38" value="<?=$profile->e_mail_id?>" /></td>
  </tr>
  <tr>
     <th>Batch</th>
	<td><select id="select"  class ="form-control" name="pi_batch" required>
									
				
				<?php 

 $year_from = "2014";
 $year_till = date("Y");
for ($i = $year_from; $i<=$year_till-1; $i++) { ?>
	<option <?php if($profile->batch == $i){echo"selected";} ?> value="<?=$i?>"><?=$i?></option>	
<?php }

?>	


			</select></td>
  </tr>
  <tr>
    <th>Branch:</th>
    <td><select id="select"  class ="form-control" name="pi_department" required>
				
				<?php 


				$select = $this->db->select("*")->from("department_details")->get()->result();
				foreach ($select as $key => $value) { ?>
					<option  <?php if($profile->short_name == $value->department){echo"selected";} ?>  value="<?=$value->short_name?>"><?=$value->comp_name?></option>	
				<?php }
				
				?>						
			
			</select></td>
  </tr>
	<tr>
    <th>Address:</th>
    <td class="updatetd1"><textarea class="form-control" name="address" cols="40" rows="6"><?=$profile->address?></textarea></td>
  </tr>
  <tr>
    <th>Profile Picture:</th>
    <td class="updatetd1"><input type="file" name="PROFILE" size="38" /></td>
  </tr>
  <tr>
    <td class="updatetd1" colspan="2" align="right">
	<button class="btn btn-sm btn-success updatebt" type="submit" name="update" onclick="check()">Update</button></td>
  </tr>
</table>
</form>
</div>
<br /><br /><br /><br /><br /><br />

<script>
	function check(){
	var phoneno=/^\d{10}$/;
	var my=document.getElementById('mobile')
	if(my.value.match(phoneno))
	{
		return true;
	}
	else
	{
		alert ("ENTER VALID MOBILE NUMBER");
		return false;
	}
	}
</script>
