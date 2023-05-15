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
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

      <!--Start Dashboard Content-->
	  
	  <!--Start Row-->
	  <form action="" method="post" enctype="multipart/form-data">
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
              </div>
            </div>
	 
	  <!-- End Row-->
	  
	  <!--Start Row-->
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
				<select class="form-control single-select iqac_textbox" name="activities">
				<option value="">Choose</option>
				<option>Conference</option>
				<option>Seminar</option>
				<option>Webinar</option>
				<option>Certificate Course</option>
				<option>Refresher Course</option>
				<option>Workshop</option>
				<option>Seed Money</option>
				<option>Consultancy / Projects</option>
				<option>Department Meetings</option>
				<option>Board of Studies</option>
				<option>Admission Committee Meetings</option>
				<option>Extension Activities</option>
				<option>Field Work & Internship Letters</option>
				<option>Placed Students Appointment Letters</option>
				<option>Students Participation</option>
				<option>Mentor Mentee Circulars</option>
				<option>Budget and Expenditure Statement from FO</option>
				<option>FDP</option>
				<option>Guest Lecture</option>
				<option>Others</option>
				</select>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-4 mt-3">
                <label class="iqac_label">Name of the Event</label>
				<input type="text" class="form-control iqac_textbox" placeholder="Event Name" name="event_name">
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-6 mt-3">
                <label class="iqac_label">Funded By</label>
				<br/>
				<input type="radio" class="iqac_radio" name="funded_by" value="UGC"> UGC 
				&nbsp;&nbsp;<input type="radio" class="iqac_radio" name="funded_by" value="Central Government"> Central Government
				&nbsp;&nbsp;<input type="radio" class="iqac_radio" name="funded_by" value="State Government"> State Government
				&nbsp;&nbsp;<input type="radio" class="iqac_radio" name="funded_by" value="MSSW"> MSSW
				&nbsp;&nbsp;<input type="radio" class="iqac_radio" name="funded_by" value="Others"> Others
				</div>
				<div class="col-3 mt-3">
				<input type="text" class="form-control iqac_textbox" style="margin-top: 21px;margin-left: -131px;" placeholder="Mention if there are others" name="funded_by_other"> 
				
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-4 mt-3">
                <label class="iqac_label">Nature of the Event</label>
				<select class="form-control single-select iqac_textbox" name="event_nature">
				<option value="">Choose</option>
				<option>Academic</option>
				<option>Culturals</option>
				<option>Sports</option>
				<option>Extra Curricular</option>
				</select>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-4 mt-3">
                <label class="iqac_label">Date of the Event</label>
				<input type="date" class="form-control iqac_textbox" name="event_date">
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-4 mt-3">
                <label class="iqac_label">Time of the Event</label>
				<input type="time" class="form-control iqac_textbox" name="event_time">
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-12 mt-3">
                <label class="iqac_label">Venue of the Event</label><br/>
				<input type="radio" class="iqac_radio" name="event_venue" value="MSSW Auditorium"> MSSW Auditorium
				&nbsp;&nbsp;<input type="radio" class="iqac_radio" name="event_venue" value="MSSW Conference Hall"> MSSW Conference Hall
				&nbsp;&nbsp;<input type="radio" class="iqac_radio" name="event_venue" value="MSSW Video Conferencing Hall"> MSSW Video Conferencing Hall
				&nbsp;&nbsp;<input type="radio" class="iqac_radio" name="event_venue" value="MSSW Mini Conference Hall"> MSSW Mini Conference Hall
				&nbsp;&nbsp;<input type="radio" class="iqac_radio" name="event_venue" value="Department"> Department
				&nbsp;&nbsp;<input type="radio" class="iqac_radio" name="event_venue" value="Class Room"> Class Room
				</div>
				<div class="col-1 mt-2">
				<input type="radio" class="iqac_radio" name="event_venue" value="Others"> Others
				</div>
				<div class="col-4 mt-2">
				<input type="text" class="form-control iqac_textbox" placeholder="Mention if there are others" name="event_venue_other"> 
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-4 mt-3">
                <label class="iqac_label">Invitation / Brochure of the Event</label>
				<input type="file" class="form-control iqac_textbox" name="invitation" accept=".pdf,.doc">
              </div>
            </div>
			
			<div class="row mt-5">
			<div class="col-12 mt-3">
                <label class="iqac_label">Resource Person / Chief Guest Details (Name, Designation and Organization)</label>
				</div>
                <div class="col-4">
				<input type="text" class="form-control iqac_textbox" placeholder="Guest Name" name="resource_name">
				</div>
				<div class="col-4">
				<input type="text" class="form-control iqac_textbox" placeholder="Guest Designation" name="resource_desig">
				</div>
				<div class="col-4">
				<input type="text" class="form-control iqac_textbox" placeholder="Guest Organization" name="resource_org">
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-12 mt-3">
                <label class="iqac_label">Total Seed Money Utilized by the Department Year wise</label>
				</div>
                <div class="col-4">
				<input type="number" class="form-control iqac_textbox" placeholder="Mention Numbers" name="dept_seed">
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-12 mt-3">
                <label class="iqac_label">Total Seed Money - Faculty wise utilized amount</label>
				<input type="number" class="form-control iqac_textbox" placeholder="Mention Numbers" name="faculty_seed">
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-12 mt-3">
                <label class="iqac_label">Responsibility - Name of the Programme Head / Coordinator</label>
				</div>
                <div class="col-4">
				<input type="text" class="form-control iqac_textbox" placeholder="Head/Coordinator Name" name="head_name">
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-4 mt-3">
                <label class="iqac_label">Accountability - Name of the Faculty Secretary</label>
				<input type="text" class="form-control iqac_textbox" placeholder="Faculty Name" name="secretary_name">
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-4 mt-3">
                <label class="iqac_label">Support - AO / Name of the Office Staff</label>
				<input type="text" class="form-control iqac_textbox" placeholder="Staff Name" name="staff_name">
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-4 mt-3">
                <label class="iqac_label">Consulted With</label><br>
				<input type="checkbox" class="iqac_checkbox" name="consulted[]" value="hod"> HOD
				&nbsp;&nbsp;<input type="checkbox" class="iqac_checkbox" name="consulted[]" value="principal"> Principal
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-4 mt-3">
                <label class="iqac_label">Informed IQAC</label>
				<select class="form-control iqac_textbox" name="informed_iqac">
				<option value="">Choose</option>
				<option>Yes</option>
				<option>No</option>
				</select>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-12 mt-3">
                <label class="iqac_label">Reports (Within 5 Days from the Date of the Event Conducted)</label>
				</div>
                <div class="col-4">
				<input type="file" class="form-control iqac_textbox" name="reports[]" multiple accept=".doc,.docx,.xml,application/msword,.pdf,.csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-12 mt-3">
                <label class="iqac_label">GPS Photos of the Event Conducted (10 Selected Photos)</label>
				</div>
                <div class="col-4">
				<input type="file" class="form-control iqac_textbox" name="photos[]" multiple accept="image/*">
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-4 mt-3">
                <label class="iqac_label">Videos of the Event Conducted</label>
				<input type="file" class="form-control iqac_textbox" name="videos[]" multiple accept="video/*">
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-4 mt-3">
                <label class="iqac_label">Documents to be uploaded</label>
				<input type="file" class="form-control iqac_textbox" name="docs[]" multiple accept=".doc,.docx,.xml,application/msword,.pdf,.csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
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
				<select class="form-control single-select iqac_textbox" name="fac_sanctioned">
				<option value="">Choose</option>
				<option>1</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
				<option>6</option>
				<option>7</option>
				<option>8</option>
				<option>9</option>
				<option>10</option>
				</select>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-12">
                <label class="iqac_label">Number of Full time Faculty Appointed for the Department</label>
				</div>
                <div class="col-4">
				<select class="form-control single-select iqac_textbox" name="fac_appointed">
				<option value="">Choose</option>
				<option>1</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
				<option>6</option>
				<option>7</option>
				<option>8</option>
				<option>9</option>
				<option>10</option>
				</select>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-12">
                <label class="iqac_label">Appointment Letter of the New Faculty appointed in the Department to be uploaded</label>
				</div>
                <div class="col-4">
				<input type="file" class="form-control iqac_textbox" name="letter">
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-12 mt-3">
                <label class="iqac_label">Name, Designation and Experience of the Full time Faculty working in the Department</label>
				</div>
                <div class="col-4">
				<input type="text" class="form-control iqac_textbox" placeholder="Faculty Name" name="fac_name">
				</div>
                <div class="col-4">
				<input type="text" class="form-control iqac_textbox" placeholder="Faculty Designation" name="fac_designation">
				</div>
                <div class="col-4">
				<input type="text" class="form-control iqac_textbox" placeholder="Faculty Experience" name="fac_experience">
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-4">
                <label class="iqac_label">No. of Guest Faculty in the Department</label>
				<select class="form-control single-select iqac_textbox" name="guests">
				<option value="">Choose</option>
				<option>1</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
				</select>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-4">
                <label class="iqac_label">Number of Full time Faculty with PhD</label>
				<select class="form-control single-select iqac_textbox" name="fac_phd_no">
				<option value="">Choose</option>
				<option>1</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
				<option>6</option>
				<option>7</option>
				<option>8</option>
				<option>9</option>
				<option>10</option>
				</select>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-4">
                <label class="iqac_label">Number of Full time Faculty with M.Phil</label>
				<select class="form-control single-select iqac_textbox" name="fac_mphil_no">
				<option value="">Choose</option>
				<option>1</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
				<option>6</option>
				<option>7</option>
				<option>8</option>
				<option>9</option>
				<option>10</option>
				</select>
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-12">
                <label class="iqac_label">Total Number of Resource persons visiting the Department</label>
				</div>
                <div class="col-4">
				<input type="number" class="form-control iqac_textbox" placeholder="Mention Numbers" name="resource_no">
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-12">
                <label class="iqac_label">Total Number of Final Year Students appeared for the Exams in the Department</label>
				</div>
                <div class="col-4">
				<input type="number" class="form-control iqac_textbox" placeholder="Mention Numbers" name="final_stu_appeared">
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-12">
                <label class="iqac_label">Total Number of Final Year Students passed the exam in the Department</label>
				</div>
                <div class="col-4">
				<input type="number" class="form-control iqac_textbox" placeholder="Mention Numbers" name="final_stu_passed">
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-12">
                <label class="iqac_label">Total Number of Students placed in the Department</label>
				</div>
                <div class="col-4">
				<input type="number" class="form-control iqac_textbox" placeholder="Mention Numbers" name="stu_placed_no">
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-12">
                <label class="iqac_label">Number of Students gone for Higher Studies</label>
				</div>
                <div class="col-4">
				<input type="number" class="form-control iqac_textbox" placeholder="Mention Numbers" name="higher_studies_no">
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-4">
                <label class="iqac_label">Mentor Mentee Ratio in the Department</label>
				<input type="text" class="form-control iqac_textbox" placeholder="Mention Ratio" name="mentor_ratio">
              </div>
            </div>
			
			<div class="row mt-5">
                <div class="col-12">
                <button type="submit" class="btn btn-lg btn-success" name="upload">Upload</button>
				</div>
            </div>
			
		</div>
	 </div>
</div>
	  <!-- End Row-->
	  
            </div>
          </div>
        </div>
      </div>
	  </form>

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