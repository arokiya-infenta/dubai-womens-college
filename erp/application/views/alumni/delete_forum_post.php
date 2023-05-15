
<link rel="stylesheet" href="<?=base_url()?>css/delete_forum_post.css" />

<form action="<?=base_url().'alumnilogin/deleteForum'?>" method="post">
<table class="tb1" align="center">
<tr>
<td>
<h2>Select Post: &nbsp;&nbsp;&nbsp;&nbsp;</h2>
</td>
<td>
<select class="form-control" name="title">
<option value="">Select Forum</option>
<?php if (sizeof($result) > 0) 
	{
		foreach($result as $row1) 
		{ ?>
	<option value="<?=$row1->eforum_title?>"><?=$row1->eforum_title?></option>
	<?php	}} ?>
</select>
</td>
</tr>
<tr>
<td colspan=2 align="right"><button class="btn btn-sm btn-primary bt1" type="submit">Refresh</button>
	&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-sm btn-success bt1" type="submit" name="search">Search</button></td>
	</tr>
	</table>
<br /><br />
<hr color="peru" size="3"/>
<br />
<?php
if(isset($search))
{ ?>
<h2 class="dh2" align="center">Search Result: </h2>
<br />
<table class="tb2" align="center" cellspacing=10>
<?php	foreach($search as $row)
	{ ?>
<tr><th class="th1">Post Title:  </th><td class="td1"><?=$row->eforum_title?><input class="i1" type="hidden" readonly="readonly" name="forumid" size="45" value="<?=$row->eforum_id?>"></td></tr>
<tr><th class="th1">Post Author:  </th><td class="td1"><?=$row->eforum_author?></td></tr>
<tr><th class="th1">Post Content: </th><td class="td1"><?=$row->eforum_content?></td></tr>
<tr><th class="th1">Post Tags:  </th><td class="td1"><?=$row->eforum_tags?></td></tr>
<tr><th class="th1">Post Time:  </th><td class="td1"><?=$row->eforum_time?></td></tr>
<tr><td colspan=2 align="right"><button class="btn btn-sm btn-danger bt1" type="submit" name="delete" onClick="return confirm('Are you sure you want to delete?');">Delete</button></td>
<?php	} ?>
</table>
<?php } ?>
</form>