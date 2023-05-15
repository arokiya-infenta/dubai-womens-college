
<!-- end section -->
<!-- section -->

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
<!-- end section -->
<!-- section -->
<div class="section contact_section" style="background:#12385b;">
 
<div id="online_exm">
    <div class="container">
        <div class="row">
             
                <div class="col-md-12 ">

                <legend class="head-one"> <h2 class="ttl">Download your Application</h2></legend> 
                    
                    <div class="headings">
                     <h2 class="ttl"> <!--<span> Your Reference Number : 21<?php echo sprintf("%'04d", $this->session->userdata('user')['user_id']); ?></span>--></h2>
                     </div>
                    <div class= "content-box well">
                    <!-- <legend class="head-one">My Dashboard </legend>-->

		
    <br>
<br>

<?php foreach($result as $rest){ ?>
    <div class="row">

<div class="rond col-md-5">

<h5 style="color: white;">
<b>
<?=$rest->course_name?>

</b>
</h5>
</div>
<div class="rond col-md-4">
<h5 style="color: white;">
Application Number : <?=$rest->application_number?>
</h5>
</div>
<div class="rond col-md-3">

<a href="<?=base_url()?>Home/studentUgPdf/<?=$this->session->userdata('user')['user_id']?>/<?=$rest->id?>"><h5 style="color: white;">Download Application</h5></a>

</div>









</div>

<br>
<br>
<?php
}
?>



                    </div>
    </div>
        </div>
     
    </div>

    
                       
         




 </div>            

           </div>			  
       </div>
    </div>
<!-- end section -->


<script type="text/javascript">

</script>
<style>


.rond {
    padding-top: 7px;
  border: 2px solid white;
  border-radius: 5px;
}
h5{

    font-size: revert;
}

.clr-change{
  color: #fff;
      font-size: 20px;
    font-weight: 600;
}
.clr-changee{
  color: #fff;
      font-size: 20px;
    font-weight: 600;
    text-align: end;
}
.clr-changeee{
  color: #fff;
      font-size: 20px;
    font-weight: 600;
    text-align: center;
}
video {
              max-width: 250px;
              max-height: 250px;
              border: 2px solid orangered;
              border-radius: 9px;
              position: relative;
    left: 77px;
            }
            

            .radio-inline input:checked ~ .ui-corner-top{
background: red !important;
}
.red {
  background: red;
}
.head-one {
    text-align: center;
    padding-top: 20px;
    text-decoration-style: wavy;
    font-weight: bold;
    color: #195252;
}
.cen{padding: 41px;
}
.first-bord{
  border: 1px solid #e9ecef;
    padding: 13px;
        margin: 0px;
            border-radius: 12px;
}
.nxt{
  margin: 10px 0px;
}
.pre{
  margin: 10px 6px;
}
.clr-change{
  color: #fff;
}
.ui-widget-content{
 background: none !important;
  border:0px !important;
   color: #fff !important;
}
/* .ui-state-active a, .ui-state-active a:link, .ui-state-active a:visited {
  color: #fff !important;
} */
.ui-tabs .ui-tabs-nav li.ui-tabs-selected {
    margin-bottom: 0;
    padding-bottom: 0px !important;
}
/* .ui-widget-header a {
  color: #fff !important;
} */
.ui-tabs .ui-tabs-panel {
   background: #21212191 !important;
       border-radius: 12px;
}
.ui-widget-header {
  background: none !important;
  border: 0px !important;
}
.ui-tabs .ui-tabs-nav li {
      margin: 20px 3px 1px 0px !important;
      border-radius: 15px 15px 0px 0px !important;
}
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default {
  border: 1px solid #d3d3d385 !important;
}
.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active {
  background: #ff8400 !important;
}

li.ui-state-default.ui-corner-top {
    background: none;
}
.ttl {
  
    font-weight: 600;
     text-align: inherit !important; 
}
input[type="radio" i] {
  --background-color: red;
}
label.radio-inline {
    font-size: 13px;
    font-weight: 100;
}
.ttl span{
  float: right;
  font-size: 16px;
    font-weight: 400;
}
/*.well { min-height: 50px;box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);position: relative;margin-bottom:5px;padding-bottom: 30px;-webkit-border-radius: 2px;-moz-border-radius: 2px;-ms-border-radius: 2px;    border-radius: 2px;}*/
.border-1 {border:1px solid #0b1c2c;}
.pad-20 {padding:39px;}
.stats-box {min-height:115px; background: #fff; border-radius:5px;}
.stats-box:hover {background:#f2f2f2;color:#dd0000;}
@media (min-width: 1200px){
.container {
    max-width: 1400px;
}
}
</style>
