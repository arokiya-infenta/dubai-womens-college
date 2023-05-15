
<link rel="stylesheet" href="<?=base_url()?>alumniassets/css/add_forum_post.css"/>

<h2 align="center"></h2>
<br />
<!--<form action="<?=base_url().'alumnilogin/addForum'?>" method="post">
<table align="center" cellspacing="30">
<tr>
<th align="left">Title: </th>
<td><input class="form-control" size="59" type="text" value="" name="title"/></td>
</tr>
<tr>
<th align="left">Tags: </th>
<td><input class="form-control" type="text" value="" name="tags" size="59" /></td>
<tr>
<th align="left" >Content: </label></th>
<td><textarea class="form-control" name="message" cols="60" rows="6" size="60"></textarea></td>
<tr>
<td colspan=2 align="right"><button class="btn btn-sm btn-success addforumbt" type="submit" name="addPost" >Add Post</button></td>
</tr>
</table>
</form>-->
<div class="container">
<div class="row">
<div class="pull-right">
<a type="button" href="<?=base_url().'alumnilogin/listForum'?>" class="btn btn-secondary" > Back</a>
</div>
</div>
</div>
<div class="container contact-form">
            <div class="contact-image">
              
            </div>
			<form action="<?=base_url().'alumnilogin/addForum'?>" method="post">
                <h3>Add New Post</h3>
               <div class="row">
                    <div class="col-md-6">
                       
                        <div class="form-group">
							<label>Title:</label>
                            <input class="form-control" size="59" type="text" required   placeholder="Your Title" name="title"  />
                        </div>
						<br>
						
                        <div class="form-group">
						<label>Tags:</label>
                            <input  class="form-control" type="text" required  placeholder="Your Tags"  name="tags" />
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
						<label>Content:</label>
                            <textarea  name="message" class="form-control" required placeholder="Your Content *" style="width: 100%; height: 150px;"></textarea>
                        </div>
						<div class="form-group">
                            <input style=" float: right;" type="submit" name="addPost" class="btnContact" value="Add Post" />
                        </div>
                    </div>
                </div>
            </form>
</div>
<style>
	.contact-form{
    background: #fff;
    margin-top: 10%;
    margin-bottom: 5%;
    width: 70%;
}
.contact-form .form-control{
    border-radius:1rem;
}
.contact-image{
    text-align: center;
}
.contact-image img{
    border-radius: 6rem;
    width: 11%;
    margin-top: -3%;
    transform: rotate(29deg);
}
/* .contact-form form{
    padding: 14%;
} */
.contact-form form .row{
    margin-bottom: -7%;
}
.contact-form h3{
    margin-bottom: 8%;
    margin-top: -10%;
    text-align: center;
    color: #0062cc;
}
.contact-form .btnContact {
    width: 50%;
    border: none;
    border-radius: 1rem;
    padding: 1.5%;
    background: #0062cc;
    font-weight: 600;
    color: #fff;
    cursor: pointer;
}
.btnContactSubmit
{
    width: 50%;
    border-radius: 1rem;
    padding: 1.5%;
    color: #fff;
    background-color: #0062cc;
    border: none;
    cursor: pointer;
}
</style>
