
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />

    
<div class="section layout_padding padding_bottom-0" style="background:#12385b; padding-top:100px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="full">
                    <div class="heading_main text_align_center">
                 
                    </div>
                  </div>
            </div>
          </div>
       </div>
    </div>
	<div class="section contact_section" style="background:#12385b;">
	<div class="">
		    <div class="">
		        <div class="row"> 
		        <div class="col-md-7"> 
        <br />
        <h2 style='color:white' align="center">My Attendance  </h2>
        <br />
        <div class="">
            <div id="calendar"></div>
        </div>
        </div>
		<div class="col-md-5"> 
		<h2 style='color:white' align="center">My  Attendance  Status</h2>
		<div id="datt"></div>
		<div class="">
       
            <br>
            <br>
            <br>
            <br>
            <br>


            <table style="background-color:#FFFFE0;" class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Subject</th>
      <th scope="col">Total</th>
      <th scope="col">Present</th>
      <th scope="col">Absent</th>
      <th scope="col">Percentage</th>
      <th scope="col">Eligible Status</th>
    </tr>
  </thead>
  <tbody>

<?php 

/* echo"<pre>";

print_r($total_id);


echo $admiteduserid;
exit; */
$i=1;


$i=1;
foreach ($total_name as $keys => $values) { 
foreach ($total_hour as $key => $value) { 
foreach ($my_total_id as $keyid => $valueid) { 

    
    if($keys == $key ){
    if($keys == $keyid ){
    
    
    ?>
	            
    <tr>
      <th scope="row"><?=$i?></th>
      <td><?=$values?></td>
      <td><?=$value?></td>
      <td><?=$valueid?></td>
      <td><?=$value-$valueid?></td>
      <td><?php if($value !=0){echo $percentage = round($valueid * 100 / $value) ;}else{ echo $percentage = 0; } ?></td>
      <td><?php if($percentage >=75){$status='Eligible';}
					 elseif($percentage >= 64 && $percentage < 75){$status='Condonation';}
					 elseif($percentage >= 49 && $percentage < 66){$status='Not Eligible';}
					 else{$status='Redo';}
                     
                     echo $status;
                     
                     
                     ?></td>
    </tr>

<?php  }} }}
$i++;
}

//print_r($attandance);

?>
 </tbody>
</table>
        </div>
	
        </div>

		<!--<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
       
        <h3 id="myModalLabel">Daily Attendence</h3>
    </div>
    <div class="modal-body">
       <div id="datt"></div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
     
    </div>
</div>-->
       <!-- <div class="col-md-"> 
		<h2 align="center"><a href="#">My Attendance  </a></h2>
		<div class="">
       
            <br>
            <br>
            <br>
            <br>
            <br>
<?php //echo"<pre>";

//print_r($my_total_id);
foreach ($my_total_id as $keys => $values) { 
?>

    
  
	
<h3 style='color:white'>: <?=$values." Hours"?> <br><br></h3>


<?php   }

//print_r($attandance);

?>

        </div>
        </div>-->

        </div>
        </div>
        </div>
        </div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

	<script>







	</script>
   <style>
	.fc-day-number{

		color: white;
	}
	.fc-unthemed td.fc-today {
    background: #0e4ef1;
	}
	.fc-day-grid-event .fc-content {
	
		color: white;
	}
	.fc-toolbar .fc-state-active, .fc-toolbar .ui-state-active {
		z-index: -1 !important;
	}
.fade:not(.show) {
    opacity: 1;
}
   </style>
