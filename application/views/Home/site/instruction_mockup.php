
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
<div class=""style="">
<!-- <div id="container">
  <video autoplay="true" id="videoElement">
  
  </video>
</div> -->
    <div class="container">
        <div class="row">
           
                <div class="col-md-12 ">
                    <div class="headings">
                     <h2 class="ttl">Students Online Examination Instructions <!--<span>Your Reference Number : 21<?php echo sprintf("%'04d", $this->session->userdata('user')['user_id']); ?></span>--></h2>
                      <!-- <h2>Your Reference Number : 21<?php echo sprintf("%'04d", $this->session->userdata('user')['user_id']); ?></h2> -->
                     </div>
                     <h2 class="ttl">Students Should participate Online Examination only through your Laptop or Personal Computer <!--<span>Your Reference Number : 21<?php echo sprintf("%'04d", $this->session->userdata('user')['user_id']); ?></span>--></h2>
                    <!-- <legend class="head-one">My Dashboard </legend>-->
                    <?php 	 $time = date("G");
		if($time >= 22){ ?>

<h2 class="ttl">You con't write Mock exam after 10 PM</h2>

<?php }else{ ?>
           <div class="row">
           <div class="col-md-2 "></div>
           <div class="col-md-8 ">
            <?=$this->session->flashdata('message');?>
           </div>
           <div class="col-md-2 "></div>
          

          </div>

          <div class="row">
             
                <div class="col-md-12 cen ">
                    <div class="stats-box border-1 pad-20">
                           <h2 class="instruct">Technical Details</h2>
                          <ul class="points">
                              <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>Use proper internet connectivity – Recommended 4G Internet connection, BroadBand
                                Connection and Internet Dongle</li>
                              <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>Use chrome, firefox, Mozilla browser latest versions</li>
                              <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>Close all other applications, browsers and browser tabs before staring the exam</li>
                              <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>Have a good light source to have a clear video recordings</li>
                              <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>Ad blocker should be switched off and auto password save has to be disabled</li>
                              <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>Enable cookies settings in browser</li>
                              <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>Popup blocker should be turned off</li>
                              <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>Clear the browser cache before staring the exam</li>
                          </ul>
                    </div>
                </div>
          </div>
          <div class="row">
             
                <div class="col-md-12 cen ">
                    <div class="stats-box border-1 pad-20">
                           <h2 class="instruct">Hardware Specifications</h2>
                          <ul class="points">
                              <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>Web Browser: Latest version of Chrome, Firefox  &amp; Microsoft edge</li>
                              <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>Operating system: Windows 7 &amp; Above</li>
                              <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>Processor – Min 2 cores</li>
                              <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>RAM: 2-4 GB</li>
                              <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>Web Camera– 640*480 Pixels, 15 fps</li>
                              <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>Microphone</li>
                              <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>Screen  resolution – 1024 * 768 and Above</li>
                              <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>Network Bandwidth Min 256 Kbit/s, Preferred 512 Kbit/s</li>
                          </ul>
                    </div>
                </div>
          </div>
          <div class="row">
             
             <div class="col-md-12 cen ">
                 <div class="stats-box border-1 pad-20">
                        <h2 class="instruct">Violation & Recording Policies</h2>
                       <ul class="points">
                           <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>This Artificial Intelligence (AI) based system will check your</li>
                           <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>Lip movement</li>
                           <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>Eye tracking</li>
                           <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>Face tracking</li>
                           <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>The following activities are not permitted and If found involved, it will result in rejection of your application</li>
                           <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>Taking your mobile phone</li>
                           <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>Presence or movement of any other person in the room</li>
                           <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>Movement of the candidate from one place to another</li>
                           <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>Referring any textbooks or any other material</li>
                           <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>Network Bandwidth Min 256 Kbit/s, Preferred 512 Kbit/s</li>
                       </ul>
                       <p class="omga">You will get 4 chances for any unexpected mistakes. If you exhaust it and continue to violate more than 4 times, then your exam session will be logged out.  This exam will be proctored using (Artificial Intelligence) AI and the session will be completely recorded for further review and analysis.
</p>
                 </div>
             </div>
       </div>
               <div class="row">
             
                <div class="col-md-12 cen ">
                    <div class="stats-box border-1 pad-20">
                           <h2 class="instruct">Instructions</h2>
                          <ul class="points">
                              <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>If the exam closes unexpectedly, you can start it again</li>
                              <!-- <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>If the exam is closed due to internet and power problem, you can start your</li> -->
                              <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>Charge the laptop/tablet with a battery backup of atleast 2 hrs</li>
                              <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>The system must have continuous internet connectivity, don’t use phone hotspot or share your hotspot with any others</li>
                              <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>Sit in a closed room with proper light</li>
                              <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>There should be no background noise</li>
                              <li class="items"><i class="fa fa-map changecl" aria-hidden="true"></i>Allow webcam &amp; microphone access in browser notification</li>
                             
                          </ul>
                    </div>
                </div>
          </div>
          <div class="row">
            <h4 class="pro-guid">Process flow and Guildlines</h4>
            <div class="col-md-12 widp">
              <div class="sp-img">
                  <img src="/landing/images/1.png">
              </div>
            </div>
            <div class="col-md-12 widp">
              <div class="sp-img">
                  <img src="/landing/images/2.png">
              </div>
            </div>
           <!--  <div class="col-md-12 widp">
              <div class="sp-img">
                  <img src="/landing/images/3.png">
              </div>
            </div> -->
            <div class="col-md-12 widp">
              <div class="sp-img">
                <img src="/landing/images/12.png">
              </div>
            </div>
            <div class="col-md-12 widp">
              <div class="sp-img">
                <img src="/landing/images/11.png">
              </div>
            </div>
            <!-- <div class="col-md-12 widp">
              <div class="sp-img">
                <img src="/landing/images/4.png">
              </div>
            </div> -->
            <div class="col-md-12 widp">
              <div class="sp-img">
                  <img src="/landing/images/5.png">
              </div>
            </div>
            <div class="col-md-12 widp">
              <div class="sp-img">
                  <img src="/landing/images/9.png">
              </div>
            </div>
            <div class="col-md-12 widp">
              <div class="sp-img">
                  <img src="/landing/images/6.png">
              </div>
            </div>
             <div class="col-md-12 widp">
              <div class="sp-img">
                  <img src="/landing/images/7.png">
              </div>
            </div>
             <div class="col-md-12 widp">
              <div class="sp-img">
                  <img src="/landing/images/8.png">
              </div>
            </div>

           
          </div>
<div class="start-exam">
  
    <h4 class="srt"><span><a href="" id="mock_exam"  style="cursor: pointer;">Mock Examination Dashboard</a></span></h4>

</div>










                    </div>
    </div>
        </div>
  
    
 </div>            

           </div>       
       </div>
    </div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #060a3d;">
   
        <h2 class="modal-title" style="color: white;" id="myModalLabel">Declaration</h2>
      </div>
      <div class="modal-body">
     <ol>  
    <li>I have read and understood the instructions for taking entrance test.</li>  
    <li>I am aware that this is an Artificial Intelligence (AI) based entrance test and the session will close automatically if involved in any kind of malpractice.</li>  
    <li>I am aware that my audio and video will be recorded and reviewed before releasing the entrance test Marks. </li>  
    <li>I am aware that my application will be rejected immediately during the review, if found involving in malpractice.</li>  
    <li>I declare that I will not involve in any kind of malpractice</li>  
   
</ol>
      </div>
      <div class="modal-footer">
       
    <button type="button" class="btn btn-primary" data-dismiss="modal">No</button><a href="<?=base_url()?>DemoExam" class="btn btn-primary">I Agree</a>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<script>
  document.getElementById("mock_exam").addEventListener("click", function(event){
  event.preventDefault();
  $('#myModal').modal({
  backdrop: 'static',
    keyboard: false},
  'show');
});
</script>
<!-- end section -->
<style>
#container {
  margin: 0px auto;
  width: 500px;
  height: 375px;
  border: 10px #333 solid;
}
#videoElement {
  width: 500px;
  height: 375px;
  background-color: #666;
}
.head-one {
    text-align: center;
    padding-top: 20px;
    text-decoration-style: wavy;
    font-weight: bold;
    color: #195252;
}
.sp-img img{
      width: 1370px;
    padding: 31px;
}
.pro-guid{
    color: #fff;
    font-weight: 500;
    font-size: 20px;
    margin: 10px 19px;
}
.srt span{
  background: #ff8507;
  
    border-radius: 11px;
    padding: 10px;
}
.sp-img{
          box-shadow: rgb(0 0 0 / 44%) 0px 0px 5px 0px, rgb(0 0 0 / 60%) 0px 0px 1px 0px;
}
.widp{
  margin: 15px 0px;
}
.omga{
  color: #fff;
  text-align: justify;
}

.well { min-height: 50px;box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);position: relative;margin-bottom:5px;padding-bottom: 30px;-webkit-border-radius: 2px;-moz-border-radius: 2px;-ms-border-radius: 2px;    border-radius: 2px;}
.border-1 {border:1px solid #0b1c2c;}
.pad-20 {padding:39px;}
.stats-box {min-height:115px; background: #fff; border-radius:5px;}
.stats-box:hover {background:#f2f2f2;color:#dd0000;}
@media (min-width: 1200px)
{
.container {
    max-width: 1400px;
}}
.adjust{
  text-align: center;;
}
.oreal{
      padding-bottom: 40px;
}
.bg-clr{
  background-color:#ff8100;
      border-color: #ff8100;
          border-radius: 20px;
}
.bg-clr h2{
  color: #fff;
}
.start-exam h4{
  text-align: center;
    color: #fff;
    font-weight: 600;
}
.start-exam{
  margin: 80px 0px;
}
.ttl {
  
    font-weight: 600;
     text-align: inherit !important; 
}
.ttl span{
  float: right;
  font-size: 16px;
    font-weight: 400;
}
.cen{
  margin: 15px 0px;
}
.stats-box{
  background: none;
  box-shadow: rgb(0 0 0 / 35%) 0px 5px 15px;
  border-radius: 20px !important;
}
.stats-box:hover {
  background: none;
  color: #fff;
}
.items{
  color: #fff;
}
.instruct{
  color: #fff;
}
.points{
  list-style: none;
}
.changecl{
  color: #ff8507;
  padding-right: 20px;
}
.pad-20 {
    padding: 10px 20px;
}
.items{
  margin: 10px 0px;
}
ul{
  margin: 0px;
}
.top-header .navbar .navbar-collapse ul li a {
  font-weight: 500 !important;

}
.nav-link:active {
  color: #ff8100;
}
</style>
<script>




</script>