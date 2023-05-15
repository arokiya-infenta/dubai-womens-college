<link rel="stylesheet" href="<?=base_url()?>alumniassets/css/alumni_mypostreply.css" />
<form action="" method="post">
<center>
<h3>Click to view:</h3>
<button class="bt1" type="submit" name="posts">My Posts</button>
<button class="bt1" type="submit" name="replies">My Replies</button>
</center>
</form>
<br /><br />
<hr color="#050119" size="2" />
<?php
if(isset($post)){
	echo $post;
}
?>
<?php
if(isset($reply)){
	echo $reply;
}
?>
<br /><br /><br /><br />