
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" href="<?=base_url()?>alumniassets/css/header_navigationbar.css" />
<!--<link rel="stylesheet" href="<?=base_url()?>alumniassets/css/event&ann.css" />-->

<div align="center">
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
<?php if($this->session->flashdata('delete')!="")
{?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo $this->session->flashdata('delete'); ?>
<?php echo $this->session->set_flashdata('delete','','success');?>
</div>
</div>
<?php } ?>
</div>

<br><br><br>
<?php
	$sql = "SELECT * FROM event WHERE e_date >='".date("Y-m-d")."' ORDER BY e_date ASC  ";
	$result = $this->db->query($sql)->result();
	$sql2 ="SELECT e_name FROM event";
	$result2 = $this->db->query($sql2);
	$rowcount=$result2->num_rows();
	$r=0;?>
<!--<table class="tb1" cellspacing=10>
<thead><a href="<?=base_url().'alumnilogin/addEvents'?>">
<button type="button" class="btn btn-sm btn-success"> Add Event </button></a> 
</thead>
<tbody>
<th class="th1">Events</th>
<?php 
	foreach($result as $row) 
	{ ?>
<tr>
<td class="td1"><span class="sp3"><strong><?=$row->e_name?></strong></span>
<br /><span class="sp2"><?=$row->e_desc?></span>
<br /><br /><span class="sp1">Event date: <?=$row->e_date?> | Event Time: <?=$row->e_time?></span>
<br /><br /><span class="sp1">Event Venue: <?=$row->e_venue?></span>
<br /><br /><span class="sp1">Person in charge: <?=$row->e_pic?></span>
<br /><br /><a type="submit" href="<?=base_url().'alumnilogin/deleteEvent/'.$row->e_id?>" onclick="return confirm('Are you sure you want to delete?');"> Delete Event </a>
<hr class="line">
</td></tr>
<?php  } ?>

</table><br /><br />-->
<div class="container">
		<div class="row">
		<a href="<?=base_url().'alumnilogin/addEvents'?>">
                    
		</div>
</div>
		<div class="container">
		<div class="row">
			<div class="[ col-xs-12 col-sm-offset-2 col-sm-8 ]">
				<ul class="event-list">

				<?php 
	foreach($result as $row) 
	{ ?>

					<li>
						<time datetime="<?=date("Y-m-d",strtotime($row->e_date))?>">
							<span class="day"><?=date("d",strtotime($row->e_date))?></span>
							<span class="month"><?=date("M",strtotime($row->e_date))?></span>
							<span class="year"><?=date("Y",strtotime($row->e_date))?></span>
							<span class="time"><?=$row->e_time?></span>
						</time>
						<img alt="Independence Day" src="https://farm4.staticflickr.com/3100/2693171833_3545fb852c_q.jpg" />
						<div class="info">
							<h2 class="title"><?=$row->e_name?></h2>
							<p class="desc"><?=$row->e_desc?></p>
							
							<ul>
								<li style="width:25%;"><?=$row->e_venue?> <span class="glyphicon glyphicon-ok"></span></li>
								<li style="width:25%;"><?=$row->e_time?> <span class="glyphicon glyphicon-ok"></span></li>
								<li style="width:25%;"><?=$row->e_pic?> <span class="fa fa-question"></span></li>
								<li style="width:25%;"> </li>
							</ul>
						</div>
						
					</li>
					<?php  } ?>
				
				</ul>
			</div>
		</div>
	</div>
	<style>

@import url("http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,400italic");
    @import url("//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css");
    body {
	
		background-color: rgb(220, 220, 220);
	}
    
    .event-list {
		list-style: none;
		font-family: 'Lato', sans-serif;
		margin: 0px;
		padding: 0px;
	}
	.event-list > li {
		background-color: rgb(255, 255, 255);
		box-shadow: 0px 0px 5px rgb(51, 51, 51);
		box-shadow: 0px 0px 5px rgba(51, 51, 51, 0.7);
		padding: 0px;
		margin: 0px 0px 20px;
	}
	.event-list > li > time {
		display: inline-block;
		width: 100%;
		color: rgb(255, 255, 255);
		background-color: rgb(197, 44, 102);
		padding: 5px;
		text-align: center;
		text-transform: uppercase;
	}
	.event-list > li:nth-child(even) > time {
		background-color: rgb(165, 82, 167);
	}
	.event-list > li > time > span {
		display: none;
	}
	.event-list > li > time > .day {
		display: block;
		font-size: 56pt;
		font-weight: 100;
		line-height: 1;
	}
	.event-list > li time > .month {
		display: block;
		font-size: 24pt;
		font-weight: 900;
		line-height: 1;
	}
	.event-list > li > img {
		width: 100%;
	}
	.event-list > li > .info {
		padding-top: 5px;
		text-align: center;
	}
	.event-list > li > .info > .title {
		font-size: 17pt;
		font-weight: 700;
		margin: 0px;
	}
	.event-list > li > .info > .desc {
		font-size: 13pt;
		font-weight: 300;
		margin: 0px;
	}
	.event-list > li > .info > ul,
	.event-list > li > .social > ul {
		display: table;
		list-style: none;
		margin: 10px 0px 0px;
		padding: 0px;
		width: 100%;
		text-align: center;
	}
	.event-list > li > .social > ul {
		margin: 0px;
	}
	.event-list > li > .info > ul > li,
	.event-list > li > .social > ul > li {
		display: table-cell;
		cursor: pointer;
		color: rgb(30, 30, 30);
		font-size: 11pt;
		font-weight: 300;
        padding: 3px 0px;
	}
    .event-list > li > .info > ul > li > a {
		display: block;
		width: 100%;
		color: rgb(30, 30, 30);
		text-decoration: none;
	} 
    .event-list > li > .social > ul > li {    
        padding: 0px;
    }
    .event-list > li > .social > ul > li > a {
        padding: 3px 0px;
	} 
	.event-list > li > .info > ul > li:hover,
	.event-list > li > .social > ul > li:hover {
		color: rgb(30, 30, 30);
		background-color: rgb(200, 200, 200);
	}
	.facebook a,
	.twitter a,
	.google-plus a {
		display: block;
		width: 100%;
		color: rgb(75, 110, 168) !important;
	}
	.twitter a {
		color: rgb(79, 213, 248) !important;
	}
	.google-plus a {
		color: rgb(221, 75, 57) !important;
	}
	.facebook:hover a {
		color: rgb(255, 255, 255) !important;
		background-color: rgb(75, 110, 168) !important;
	}
	.twitter:hover a {
		color: rgb(255, 255, 255) !important;
		background-color: rgb(79, 213, 248) !important;
	}
	.google-plus:hover a {
		color: rgb(255, 255, 255) !important;
		background-color: rgb(221, 75, 57) !important;
	}

	@media (min-width: 768px) {
		.event-list > li {
			position: relative;
			display: block;
			width: 100%;
			height: 120px;
			padding: 0px;
		}
		.event-list > li > time,
		.event-list > li > img  {
			display: inline-block;
		}
		.event-list > li > time,
		.event-list > li > img {
			width: 120px;
			float: left;
		}
		.event-list > li > .info {
			background-color: rgb(245, 245, 245);
			overflow: hidden;
		}
		.event-list > li > time,
		.event-list > li > img {
			width: 120px;
			height: 120px;
			padding: 0px;
			margin: 0px;
		}
		.event-list > li > .info {
			position: relative;
			height: 120px;
			text-align: left;
			padding-right: 40px;
		}	
		.event-list > li > .info > .title, 
		.event-list > li > .info > .desc {
			padding: 0px 10px;
		}
		.event-list > li > .info > ul {
			position: absolute;
			left: 0px;
			bottom: 0px;
		}
		.event-list > li > .social {
			position: absolute;
			top: 0px;
			right: 0px;
			display: block;
			width: 40px;
		}
        .event-list > li > .social > ul {
            border-left: 1px solid rgb(230, 230, 230);
        }
		.event-list > li > .social > ul > li {			
			display: block;
            padding: 0px;
		}
		.event-list > li > .social > ul > li > a {
			display: block;
			width: 40px;
			padding: 10px 0px 9px;
		}
	}
	</style>
