
<link rel="stylesheet" href="<?=base_url()?>alumniassets/css/header_navigationbar.css" />
<!--<link rel="stylesheet" href="<?=base_url()?>alumniassets/css/add_forum_post.css" />-->

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

<!--<form action="<?=base_url().'alumnilogin/addAnnouncement'?>" method="post">
<div class="row">
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
</div>
<table width="910" align="center" style="border:2px hidden;" cellspacing="20">
<tr>
<th align="left" width="450" style="border:hidden;font-size:25px"> Details of the Announcement:</th>
<td> </td>
</tr>
<tr>
<th align="left" width="350" style="border:hidden;font-size:18px">Announcement ID: </th>
<td width="450" style="border:hidden"><input class="form-control" size="59" type="text" value="" name="aid"/></td>
</tr>
<tr>
<th align="left" width="350" style="border:hidden;font-size:18px">Announcement Name: </th>
<td width="450" style="border:hidden"><input class="form-control" type="text" value="" name="aname" size="59" /></td>
<tr>
<th align="left"  width="350" style="border:hidden;font-size:18px">Announcement Description: </label></th>
<td width="450" style="border:hidden"><textarea class="form-control" name="adesc" cols="60" rows="6" size="60"></textarea></td>
<tr>
<td colspan=2 align="right" style="border:hidden"><button class="bt1" type="submit" name="addann" >Add Announcement</button></td>
</tr>
</table>
</form>-->
<div class="container contact-form">
            <div class="contact-image">
              
            </div>
<form action="<?=base_url().'alumnilogin/addAnnouncement'?>" method="post">
                <h3>Post Announcement</h3>
               <div class="row">
                    <div class="col-md-6">
                       
										<div class="form-group">
						<label>Announcement ID:</label>
                            <input  class="form-control"  class="form-control"  type="text" required  placeholder="Announcement ID"  name="aid" />
                        </div>
												<br>
                        <div class="form-group">
							<label>Announcement Name:</label>
                            <input class="form-control"  class="form-control"  size="59" type="text" required   placeholder="Announcement Name" name="aname"  />
                        </div>
						
						
                      
                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
						<label>Announcement Description:</label>
                            <textarea  name="adesc" class="form-control" required placeholder="Announcement Description *" style="width: 100%; height: 150px;"></textarea>
                        </div>
						<div class="form-group">
                            <input style=" float: right;" type="submit" name="addann" class="btnContact" value="Add Post" />
                        </div>
                    </div>
                </div>
            </form>
		</div>
</body>
</html>
