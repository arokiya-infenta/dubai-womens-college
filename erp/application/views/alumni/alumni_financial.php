
<link rel="stylesheet" href="<?=base_url()?>alumniassets/css/alumni_financial.css">

<div>
<br />
<h2>Financial Record</h2>
<br />
<form method="post">
<table class="alumnifinancialtable" align="center" cellspacing="15px">
<?php
	if(isset($sort)){
		echo $sort;
	}
?>
<tr>
	<td align="right" colspan="4">
    	<br /><button class="alumnifinancialbt" type="submit" name="unsort">Unsort</button>&nbsp;&nbsp;&nbsp;
		<button class="alumnifinancialbt" type="submit" name="sort">Sort by Payment Purpose</button><br /> 
	</td>
</tr>
</table>
</form>
</div>
<br /><br /><br /><br />
</body>
</html>