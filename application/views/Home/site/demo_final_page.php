
<!-- end section -->
<!-- section -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.8.3/themes/base/jquery-ui.css" />

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
    <div class="odap"style="height: 30.7rem">
        <div class="container">
            <div class="row">
                    <div class="col-md-12 ">
                        <div class="headings">
                          <h2 class="ttl">Exam Details  </h2>
                        </div>
                    </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <p class="succ"><i class="fa fa-check-circle" aria-hidden="true"></i></p>
                <h2 class="thank">You have completed the Mock Test Successfully. All the best for your Main Test.</h2>  <h2 class="thank">Thank you</h2>
              </div>
            </div>
            <div class="row addme">
                <div class="once">
                <h2 class="ttl pad"><span style="float: left !important;font-size: 20px;
    font-weight: 600;">Total. No. of Questions : <?=$total_questions?></h2>
                   <h2 class="ttl"><span style="font-size: 20px;
    font-weight: 600;">Total. No. of Questions Answered : <?=$total_answered?></h2>
                </div>
                <div class="twice">
               
                </div>
                <!-- <h2 class="ttl"><span></h2>   -->
                 
            </div>
        </div>
    </div>            

</div>			  
<style>
.head-one {
    text-align: center;
    padding-top: 20px;
    text-decoration-style: wavy;
    font-weight: bold;
    color: #195252;
}
.cen{padding: 41px;
}
.well { min-height: 50px;box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);position: relative;margin-bottom:5px;padding-bottom: 30px;-webkit-border-radius: 2px;-moz-border-radius: 2px;-ms-border-radius: 2px;    border-radius: 2px;}
.border-1 {border:1px solid #0b1c2c;}
.pad-20 {padding:39px;}
.stats-box {min-height:115px; background: #fff; border-radius:5px;}
.stats-box:hover {background:#f2f2f2;color:#dd0000;}
.ttl span{
  float: right;
  font-size: 16px;
    font-weight: 400;
}
.pad{
      margin: 0px 13px 0px 0px;
}
.thank{
      text-align: center;
    color: #fff;
    font-size: 30px;
    font-weight: 600;
}
.succ{
      text-align: center;
    color: green;
    font-size: 60px;
}
.addme{
      /*padding: 10em 33em;*/
          margin: 154px 0px 100px 0px;
}
.ttl {
  
    font-weight: 600;
     text-align: inherit !important; 
}
ul.navbar-nav {
  margin: 0;
}
@media (min-width: 1200px){
.container {
    max-width: 1400px;
}
}
</style>
<script>

setTimeout(function(){
  window.location.href = "<?=base_url()?>Welcome/";
}, 30000);

</script>