
<link rel="stylesheet" href="<?=base_url()?>alumniassets/css/header_navigationbar.css" />
<link rel="stylesheet" href="<?=base_url()?>alumniassets/css/add_forum_post.css"/>
<link rel="stylesheet" href="<?=base_url()?>alumniassets/css/event&ann.css">
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
<!--<form action="<?=base_url().'alumnilogin/addEvents'?>" method="post">
<div class="form-group" align="center">
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
<h3>Details of the event:</h3></div>
<table width="850" align="center" style="border:2px hidden;" cellspacing="10">
<tr>
<th align="left" width="6000" style="border:hidden;font-size:18px">Event ID: </th>
<td width="350" style="border:hidden"><input class="form-control" size="59" type="text" value="" name="eventid"/></td>
</tr>
<tr>
<th align="left" width="300" style="border:hidden;font-size:18px">Event Name:</th>
<td width="350" style="border:hidden"><input class="form-control" type="text" value="" name="eventname" size="59" /></td>
<tr>
<th align="left"  width="300" style="border:hidden;font-size:18px">Event Date: </label></th>
<td width="350" style="border:hidden"><input class="i2 form-control" type="date" value="" name="eventdate" size="59"min="2020-06-06"required /></td>
<tr>
<tr>
<th align="left"  width="300" style="border:hidden;font-size:18px">Event Time:</label></th>
<td width="350" style="border:hidden"><input class="i3 form-control" type="time" value="" name="eventtime" size="59" /></td>
<tr> 
<tr>
<th align="left"  width="300" style="border:hidden;font-size:18px">Event Description: </label></th>
<td width="350" style="border:hidden"><textarea class="form-control" name="eventdesc" cols="60" rows="6" size="60"></textarea></td>
<tr>
<tr>
<th align="left"  width="300" style="border:hidden;font-size:18px">Event Venue: </label></th>
<td width="350" style="border:hidden"><input class="form-control" type="text" value="" name="eventvenue" size="59" /></td>
<tr>
<tr>
<th align="left"  width="300" style="border:hidden;font-size:18px">Person in charge of the event: </label></th>
<td width="350" style="border:hidden"><input class="form-control" type="text" value="" name="epic" size="59" /></td>
<tr>
<td colspan=2 align="right" style="border:hidden"><button class="bt1" type="submit" name="addEvent" >Post Event</button></td>
</tr>
</table>
</form>-->
<div class="container contact-form">
            <div class="contact-image">
              
            </div>
			<form action="<?=base_url().'alumnilogin/addEvents'?>" method="post">
                <h3>Post Event</h3>
               <div class="row">
                    <div class="col-md-6">
                       
                        <div class="form-group">
							<label>Event ID:</label>
                            
							<input class="form-control" size="59" type="text" value="" name="eventid"/>
                        </div>
						<br>  <div class="form-group">
							<label>Event Name:</label>
                            
							<input class="form-control" type="text" value="" name="eventname" size="59" />
                        </div>
						<br>  <div class="form-group">
							<label>Event Date:</label>
                            
							<input class="i2 form-control" type="date" value="" name="eventdate" size="59" min="2022-06-06"required />
                        </div>
						<br> <div class="form-group">
							<label>Event Time:</label>
                         	<input class="i3 form-control" type="time" value="" name="eventtime" size="59" />
                        </div>
						<br>
						
                      
                        
                    </div>
                    <div class="col-md-6">
					
					<div class="form-group">
						<label>Event Venue:</label>
						<input class="form-control" type="text" value="" name="eventvenue" size="59" />
                        </div><br>
                        <div class="form-group">
						<label>Person in charge:</label>
						<input class="form-control" type="text" value="" name="epic" size="59" />
                        </div>
						<br>
                        <div class="form-group">
						<label>Event Description:</label>
						<textarea class="form-control" name="eventdesc" cols="60" rows="6" size="60"></textarea>
                        </div>
						<div class="form-group">
                            <input style=" float: right;" type="submit" name="addEvent" class="btnContact" value="Add Event" />
                        </div>
                    </div>
                </div>
            </form>
</div>
