<style>
.iqac_label{
	font-size:16px!important;
}
.iqac_textbox{
	height:50px!important;
}
.iqac_radio{
	width:25px;
	height:25px;
}
.iqac_checkbox{
	width:25px;
	height:25px;
}
/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #a6dcb2;
  background-color: #a6dcb2;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #d0ead6;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #6e9a78;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  /*border: 1px solid #ccc;*/
  border-top: none;
}
</style>
<style>
* {
  box-sizing: border-box;
}

ul.iqac {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

ul.iqac li {
  border: 1px solid #ddd;
  margin-top: -1px; /* Prevent double borders */
  background-color: #f6f6f6;
  padding: 12px;
  text-decoration: none;
  font-size: 18px;
  color: black;
  display: block;
  position: relative;
}

ul.iqac li:hover {
  background-color: #eee;
}

.close {
  cursor: pointer;
  position: absolute;
  top: 50%;
  right: 0%;
  padding: 12px 16px;
  transform: translate(0%, -50%);
}

.close:hover {background: #bbb;}
</style>
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

      <!--Start Dashboard Content-->
	  
	  <!--Start Row-->
      <div class="row mt-3">
        <div class="col-12">
		<div class="hide-it" align="center"><h4 style="color:#15ca20;"><?php echo $this->session->flashdata('success'); ?></h4></div>
		<?php $this->session->set_flashdata('success',''); ?>
		<div class="hide-it" align="center"><h4 style="color:#8B0000;"><?php echo $this->session->flashdata('form_err'); ?></h4></div>
		<?php $this->session->set_flashdata('form_err',''); ?>
          <div class="card border-success border-top-sm">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-success">Event Details from the Department</h4>
				<div style="float:right;margin-top:-25px;">
				<a href="<?=base_url().'principal/iqac'?>">
			<button class="btn btn-sm btn-success">Back</button></a>
			</div>
              </div>
            </div>
	 
	  <!-- End Row-->
	  
	  <!--Start Row-->
	  <form action="" method="post" enctype="multipart/form-data">
<p>Click on the buttons to enter the details:</p>

	  <div class="tab">
  <button type="button" class="tablinks active" onclick="openCity(event, 'Page1')">Page 1</button>
  <button type="button" class="tablinks" onclick="openCity(event, 'Page2')">Page 2</button>
     </div>
	  
      <div id="Page1" class="tabcontent" style="display:block;">
      <div class="row mt-3">
        <div class="col-12">
			
              <div class="row mt-3">
                <div class="col-4">
                <label class="iqac_label">Activities of the Department</label>
				<select class="form-control single-select iqac_textbox" name="activities" disabled>
				<option value="">Choose</option>
				<option <?php if($iqac->activities == 'Conference'){echo 'selected';}?>>Conference</option>
				<option <?php if($iqac->activities == 'Seminar'){echo 'selected';}?>>Seminar</option>
				<option <?php if($iqac->activities == 'Webinar'){echo 'selected';}?>>Webinar</option>
				<option <?php if($iqac->activities == 'Certificate Course'){echo 'selected';}?>>Certificate Course</option>
				<option <?php if($iqac->activities == 'Refresher Course'){echo 'selected';}?>>Refresher Course</option>
				<option <?php if($iqac->activities == 'Workshop'){echo 'selected';}?>>Workshop</option>
				<option <?php if($iqac->activities == 'Seed Money'){echo 'selected';}?>>Seed Money</option>
				<option <?php if($iqac->activities == 'Consultancy / Projects'){echo 'selected';}?>>Consultancy / Projects</option>
				<option <?php if($iqac->activities == 'Department Meetings'){echo 'selected';}?>>Department Meetings</option>
				<option <?php if($iqac->activities == 'Board of Studies'){echo 'selected';}?>>Board of Studies</option>
				<option <?php if($iqac->activities == 'Admission Committee Meetings'){echo 'selected';}?>>Admission Committee Meetings</option>
				<option <?php if($iqac->activities == 'Extension Activities'){echo 'selected';}?>>Extension Activities</option>
				<option <?php if($iqac->activities == 'Field Work & Internship Letters'){echo 'selected';}?>>Field Work & Internship Letters</option>
				<option <?php if($iqac->activities == 'Placed Students Appointment Letters'){echo 'selected';}?>>Placed Students Appointment Letters</option>
				<option <?php if($iqac->activities == 'Students Participation'){echo 'selected';}?>>Students Participation</option>
				<option <?php if($iqac->activities == 'Mentor Mentee Circulars'){echo 'selected';}?>>Mentor Mentee Circulars</option>
				<option <?php if($iqac->activities == 'Budget and Expenditure Statement from FO'){echo 'selected';}?>>Budget and Expenditure Statement from FO</option>
				<option <?php if($iqac->activities == 'FDP'){echo 'selected';}?>>FDP</option>
				<option <?php if($iqac->activities == 'Guest Lecture'){echo 'selected';}?>>Guest Lecture</option>
				<option <?php if($iqac->activities == 'Others'){echo 'selected';}?>>Others</option>
				</select>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-4 mt-3">
                <label class="iqac_label">Name of the Event</label>
				<input type="text" class="form-control iqac_textbox" placeholder="Event Name" name="event_name" value="<?=$iqac->event_name?>" readonly>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-6 mt-3">
                <label class="iqac_label">Funded By</label>
				<br/>
				<input type="radio" class="iqac_radio" name="funded_by" value="UGC" <?php if($iqac->funded_by == 'UGC'){echo 'checked';}?> readonly> UGC 
				&nbsp;&nbsp;<input type="radio" class="iqac_radio" name="funded_by" value="Central Government" <?php if($iqac->funded_by == 'Central Government'){echo 'checked';}?> readonly> Central Government
				&nbsp;&nbsp;<input type="radio" class="iqac_radio" name="funded_by" value="State Government" <?php if($iqac->funded_by == 'State Government'){echo 'checked';}?> readonly> State Government
				&nbsp;&nbsp;<input type="radio" class="iqac_radio" name="funded_by" value="MSSW" <?php if($iqac->funded_by == 'MSSW'){echo 'checked';}?> readonly> MSSW
				&nbsp;&nbsp;<input type="radio" class="iqac_radio" name="funded_by" value="Others" <?php if($iqac->funded_by == 'Others'){echo 'checked';}?> readonly> Others
				</div>
				<div class="col-3 mt-3">
				<input type="text" class="form-control iqac_textbox" style="margin-top: 21px;margin-left: -131px;" placeholder="Mention if there are others" name="funded_by_other" value="<?=$iqac->funded_by_other?>" readonly> 
				
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-4 mt-3">
                <label class="iqac_label">Nature of the Event</label>
				<select class="form-control single-select iqac_textbox" name="event_nature" disabled>
				<option value="">Choose</option>
				<option <?php if($iqac->event_nature == 'Academic'){echo 'selected';}?>>Academic</option>
				<option <?php if($iqac->event_nature == 'Culturals'){echo 'selected';}?>>Culturals</option>
				<option <?php if($iqac->event_nature == 'Sports'){echo 'selected';}?>>Sports</option>
				<option <?php if($iqac->event_nature == 'Extra Curricular'){echo 'selected';}?>>Extra Curricular</option>
				</select>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-4 mt-3">
                <label class="iqac_label">Date of the Event</label>
				<input type="date" class="form-control iqac_textbox" name="event_date" value="<?=$iqac->event_date?>">
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-4 mt-3">
                <label class="iqac_label">Time of the Event</label>
				<input type="time" class="form-control iqac_textbox" name="event_time" value="<?=date('H:i',strtotime($iqac->event_time))?>">
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-12 mt-3">
                <label class="iqac_label">Venue of the Event</label><br/>
				<input type="radio" class="iqac_radio" name="event_venue" value="MSSW Auditorium" <?php if($iqac->event_venue == 'MSSW Auditorium'){echo 'checked';}?> readonly> MSSW Auditorium
				&nbsp;&nbsp;<input type="radio" class="iqac_radio" name="event_venue" value="MSSW Conference Hall" <?php if($iqac->event_venue == 'MSSW Conference Hall'){echo 'checked';}?> readonly> MSSW Conference Hall
				&nbsp;&nbsp;<input type="radio" class="iqac_radio" name="event_venue" value="MSSW Video Conferencing Hall" <?php if($iqac->event_venue == 'MSSW Video Conferencing Hall'){echo 'checked';}?> readonly> MSSW Video Conferencing Hall
				&nbsp;&nbsp;<input type="radio" class="iqac_radio" name="event_venue" value="MSSW Mini Conference Hall" <?php if($iqac->event_venue == 'MSSW Mini Conference Hall'){echo 'checked';}?> readonly> MSSW Mini Conference Hall
				&nbsp;&nbsp;<input type="radio" class="iqac_radio" name="event_venue" value="Department" <?php if($iqac->event_venue == 'Department'){echo 'checked';}?> readonly> Department
				&nbsp;&nbsp;<input type="radio" class="iqac_radio" name="event_venue" value="Class Room" <?php if($iqac->event_venue == 'Class Room'){echo 'checked';}?> readonly> Class Room
				</div>
				<div class="col-1 mt-2">
				<input type="radio" class="iqac_radio" name="event_venue" value="Others" <?php if($iqac->event_venue == 'Others'){echo 'checked';}?> readonly> Others
				</div>
				<div class="col-4 mt-2">
				<input type="text" class="form-control iqac_textbox" placeholder="Mention if there are others" name="event_venue_other" value="<?=$iqac->event_venue_other?>" readonly> 
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-4 mt-3">
                <label class="iqac_label">Invitation / Brochure of the Event</label>
				<?php if($iqac->event_invitation != ''){
				$inv = explode('/',$iqac->event_invitation);
				$invi = explode('_',$inv[3]);
				$invitation = $invi[1].'_'.$invi[2];
				?>
				<a href="<?=base_url().$iqac->event_invitation?>" style="color:blue;cursor:pointer;" download><p><?=$invitation?></p></a>
				<?php } ?>
              </div>
              </div>
			
			<div class="row mt-5">
			<div class="col-12 mt-3">
                <label class="iqac_label">Resource Person / Chief Guest Details (Name, Designation and Organization)</label>
				</div>
                <div class="col-4">
				<input type="text" class="form-control iqac_textbox" placeholder="Guest Name" name="resource_name" value="<?=$iqac->resource_name?>" readonly>
				</div>
				<div class="col-4">
				<input type="text" class="form-control iqac_textbox" placeholder="Guest Designation" name="resource_desig" value="<?=$iqac->resource_desig?>" readonly>
				</div>
				<div class="col-4">
				<input type="text" class="form-control iqac_textbox" placeholder="Guest Organization" name="resource_org" value="<?=$iqac->resource_org?>" readonly>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-12 mt-3">
                <label class="iqac_label">Total Seed Money Utilized by the Department Year wise</label>
				</div>
                <div class="col-4">
				<input type="number" class="form-control iqac_textbox" placeholder="Mention Numbers" name="dept_seed" value="<?=$iqac->dept_seed?>" readonly>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-12 mt-3">
                <label class="iqac_label">Total Seed Money - Faculty wise utilized amount</label>
				<input type="number" class="form-control iqac_textbox" placeholder="Mention Numbers" name="faculty_seed" value="<?=$iqac->faculty_seed?>" readonly>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-12 mt-3">
                <label class="iqac_label">Responsibility - Name of the Programme Head / Coordinator</label>
				</div>
                <div class="col-4">
				<input type="text" class="form-control iqac_textbox" placeholder="Head/Coordinator Name" name="head_name" value="<?=$iqac->head_name?>" readonly>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-4 mt-3">
                <label class="iqac_label">Accountability - Name of the Faculty Secretary</label>
				<input type="text" class="form-control iqac_textbox" placeholder="Faculty Name" name="secretary_name" value="<?=$iqac->secretary_name?>" readonly>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-4 mt-3">
                <label class="iqac_label">Support - AO / Name of the Office Staff</label>
				<input type="text" class="form-control iqac_textbox" placeholder="Staff Name" name="staff_name" value="<?=$iqac->staff_name?>" readonly>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-4 mt-3">
                <label class="iqac_label">Consulted With</label><br>
				<?php $consulted = explode(',',$iqac->consulted); ?>
				<input type="checkbox" class="iqac_checkbox" name="consulted[]" value="hod" <?php if(in_array('hod',$consulted)){echo 'checked';}?> disabled> HOD
				&nbsp;&nbsp;<input type="checkbox" class="iqac_checkbox" name="consulted[]" value="principal" <?php if(in_array('principal',$consulted)){echo 'checked';}?> disabled> Principal
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-4 mt-3">
                <label class="iqac_label">Informed IQAC</label>
				<select class="form-control iqac_textbox" name="informed_iqac" disabled>
				<option value="">Choose</option>
				<option <?php if($iqac->informed_iqac == 'Yes'){echo 'selected';}?>>Yes</option>
				<option <?php if($iqac->informed_iqac == 'No'){echo 'selected';}?>>No</option>
				</select>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-12 mt-3">
                <label class="iqac_label">Reports (Within 5 Days from the Date of the Event Conducted)</label>
				</div>
            </div>
              <div class="row">
			  <div class="col-3">
               <ul class="iqac">
			  <?php $get_rep = $this->db->where('iqac_id',$iqac->id)->where('type','reports')->get('iqac_docs')->result();
			  foreach($get_rep as $getrep){
			  if($getrep->path != ''){
				$rep = explode('/',$getrep->path);
				$repo = explode('_',$rep[3]);
				$report = $repo[1].'_'.$repo[2];
				?>
               <a href="<?=base_url().$getrep->path?>" style="color:blue;cursor:pointer;" download><li><?=$report?><span class="close" data-id="<?=$getrep->id?>"><i class="fa fa-download"></i></span></li></a>
			  <?php }} ?>
               </ul>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-12 mt-3">
                <label class="iqac_label">GPS Photos of the Event Conducted (10 Selected Photos)</label>
				</div>
            </div>
              <div class="row">
			  <div class="col-3">
               <ul class="iqac">
               <?php $get_pho = $this->db->where('iqac_id',$iqac->id)->where('type','photos')->get('iqac_docs')->result();
			  foreach($get_pho as $getpho){
			  if($getpho->path != ''){
				$pho = explode('/',$getpho->path);
				$phot = explode('_',$pho[3]);
				$photo = $phot[1].'_'.$phot[2];
				?>
               <a href="<?=base_url().$getpho->path?>" style="color:blue;cursor:pointer;" download><li><?=$photo?><span class="close" data-id="<?=$getpho->id?>"><i class="fa fa-download"></i></span></li></a>
			  <?php }} ?>
               </ul>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-4 mt-3">
                <label class="iqac_label">Videos of the Event Conducted</label>
              </div>
            </div>
              <div class="row">
			  <div class="col-3">
               <ul class="iqac">
               <?php $get_vid = $this->db->where('iqac_id',$iqac->id)->where('type','videos')->get('iqac_docs')->result();
			  foreach($get_vid as $getvid){
			  if($getvid->path != ''){
				$vid = explode('/',$getvid->path);
				$vide = explode('_',$vid[3]);
				$video = $vide[1].'_'.$vide[2];
				?>
               <a href="<?=base_url().$getvid->path?>" style="color:blue;cursor:pointer;" download><li><?=$video?><span class="close" data-id="<?=$getvid->id?>"><i class="fa fa-download"></i></span></li></a>
			  <?php }} ?>
               </ul>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-4 mt-3">
                <label class="iqac_label">Documents to be uploaded</label>
              </div>
            </div>
              <div class="row">
			  <div class="col-3">
               <ul class="iqac">
               <?php $get_doc = $this->db->where('iqac_id',$iqac->id)->where('type','docs')->get('iqac_docs')->result();
			  foreach($get_doc as $getdoc){
			  if($getdoc->path != ''){
				$doc = explode('/',$getdoc->path);
				$docu = explode('_',$doc[3]);
				$document = $docu[1].'_'.$docu[2];
				?>
               <a href="<?=base_url().$getdoc->path?>" style="color:blue;cursor:pointer;" download><li><?=$document?><span class="close" data-id="<?=$getdoc->id?>"><i class="fa fa-download"></i></span></li></a>
			  <?php }} ?>
               </ul>
              </div>
            </div>
			
        </div>
      </div>
      </div>
	 
	  <!-- End Row-->
	  
	  <!-- Start Row-->
	  <div id="Page2" class="tabcontent">
   <div class="row mt-3">
        <div class="col-12">
			
              <div class="row mt-3">
                <div class="col-12">
                <label class="iqac_label">Number of Full time Faculty Sanctioned for the Department</label>
				</div>
                <div class="col-4">
				<select class="form-control single-select iqac_textbox" name="fac_sanctioned" disabled>
				<option value="">Choose</option>
				<?php for($fs=1; $fs<=10; $fs++){ ?>
				<option <?php if($iqac->fac_sanctioned == $fs){echo 'selected';}?>><?=$fs?></option>
				<?php } ?>
				</select>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-12">
                <label class="iqac_label">Number of Full time Faculty Appointed for the Department</label>
				</div>
                <div class="col-4">
				<select class="form-control single-select iqac_textbox" name="fac_appointed" disabled>
				<option value="">Choose</option>
				<?php for($fa=1; $fa<=10; $fa++){ ?>
				<option <?php if($iqac->fac_appointed == $fa){echo 'selected';}?>><?=$fa?></option>
				<?php } ?>
				</select>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-12">
                <label class="iqac_label">Appointment Letter of the New Faculty appointed in the Department to be uploaded</label>
				</div>
                <div class="col-4">
				<!--<input type="file" class="form-control iqac_textbox" name="letter">-->
				<?php if($iqac->app_letter != ''){
				$let = explode('/',$iqac->app_letter);
				$lett = explode('_',$let[3]);
				$letter = $lett[1].'_'.$lett[2];
				?>
				<a href="<?=base_url().$iqac->app_letter?>" style="color:blue;cursor:pointer;" download><p><?=$letter?></p></a>
				<?php } ?>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-12 mt-3">
                <label class="iqac_label">Name, Designation and Experience of the Full time Faculty working in the Department</label>
				</div>
                <div class="col-4">
				<input type="text" class="form-control iqac_textbox" placeholder="Faculty Name" name="fac_name" value="<?=$iqac->fac_name?>" readonly>
				</div>
                <div class="col-4">
				<input type="text" class="form-control iqac_textbox" placeholder="Faculty Designation" name="fac_designation" value="<?=$iqac->fac_designation?>" readonly>
				</div>
                <div class="col-4">
				<input type="text" class="form-control iqac_textbox" placeholder="Faculty Experience" name="fac_experience" value="<?=$iqac->fac_experience?>" readonly>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-4">
                <label class="iqac_label">No. of Guest Faculty in the Department</label>
				<select class="form-control single-select iqac_textbox" name="guests" disabled>
				<option value="">Choose</option>
				<?php for($fd=1; $fd<=5; $fd++){ ?>
				<option <?php if($iqac->guests == $fd){echo 'selected';}?>><?=$fd?></option>
				<?php } ?>
				</select>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-4">
                <label class="iqac_label">Number of Full time Faculty with PhD</label>
				<select class="form-control single-select iqac_textbox" name="fac_phd_no" disabled>
				<option value="">Choose</option>
				<?php for($fp=1; $fp<=10; $fp++){ ?>
				<option <?php if($iqac->fac_phd_no == $fp){echo 'selected';}?>><?=$fp?></option>
				<?php } ?>
				</select>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-4">
                <label class="iqac_label">Number of Full time Faculty with M.Phil</label>
				<select class="form-control single-select iqac_textbox" name="fac_mphil_no" disabled>
				<option value="">Choose</option>
				<<?php for($fm=1; $fm<=10; $fm++){ ?>
				<option <?php if($iqac->fac_mphil_no == $fm){echo 'selected';}?>><?=$fm?></option>
				<?php } ?>
				</select>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-12">
                <label class="iqac_label">Total Number of Resource persons visiting the Department</label>
				</div>
                <div class="col-4">
				<input type="number" class="form-control iqac_textbox" placeholder="Mention Numbers" name="resource_no" value="<?=$iqac->resource_no?>" readonly>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-12">
                <label class="iqac_label">Total Number of Final Year Students appeared for the Exams in the Department</label>
				</div>
                <div class="col-4">
				<input type="number" class="form-control iqac_textbox" placeholder="Mention Numbers" name="final_stu_appeared" value="<?=$iqac->final_stu_appeared?>" readonly>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-12">
                <label class="iqac_label">Total Number of Final Year Students passed the exam in the Department</label>
				</div>
                <div class="col-4">
				<input type="number" class="form-control iqac_textbox" placeholder="Mention Numbers" name="final_stu_passed" value="<?=$iqac->final_stu_passed?>" readonly>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-12">
                <label class="iqac_label">Total Number of Students placed in the Department</label>
				</div>
                <div class="col-4">
				<input type="number" class="form-control iqac_textbox" placeholder="Mention Numbers" name="stu_placed_no" value="<?=$iqac->stu_placed_no?>" readonly>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-12">
                <label class="iqac_label">Number of Students gone for Higher Studies</label>
				</div>
                <div class="col-4">
				<input type="number" class="form-control iqac_textbox" placeholder="Mention Numbers" name="higher_studies_no" value="<?=$iqac->higher_studies_no?>" readonly>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-4">
                <label class="iqac_label">Mentor Mentee Ratio in the Department</label>
				<input type="text" class="form-control iqac_textbox" placeholder="Mention Ratio" name="mentor_ratio" value="<?=$iqac->mentor_ratio?>" readonly>
              </div>
            </div>
			
			<!--<div class="row mt-5">
                <div class="col-12">
                <button type="submit" class="btn btn-lg btn-success" name="upload">Upload</button>
				</div>
            </div>-->
			
		</div>
	 </div>
</div>
	  </form>
	  <!-- End Row-->
	  
            </div>
          </div>
        </div>
      </div>

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
var base_url = "<?php echo base_url(); ?>";
	$(document).ready(function(){
	
	});
	</script>
	<script>
	   setTimeout(function() {
            $('.hide-it').hide('fast');
        }, 3000);
</script>
<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>
<script>
$('.close').click(function(){
	var id= $(this).data('id');
	var ele=$(this).parent();
	if (confirm('Are you sure to delete?')) {
            $.ajax({
                url: base_url + "hod/iqacUpdateDoc",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    id: id,
                },
                success: function (data) {
					alert('Deleted Successfully!!');
					ele.remove();
                }
            });
		}
});
</script>