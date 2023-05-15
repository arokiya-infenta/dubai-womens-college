<style>
 .panel-title {
  position: relative;
}
  
.panel-title::after {
  content: "\f107";
  color: #333;
  top: -2px;
  right: 0px;
  position: absolute;
  font-family: "FontAwesome"
}

.panel-title[aria-expanded="true"]::after {
  content: "\f106";
}
</style>

<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

      <!--Start Dashboard Content-->
	  
  <!-- Horizontal - start --> 
  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">  
   <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><h4 class="text-center panel-title"> Semester 1</h4></div>
  
</div>
</div>
</div>
</a>
	
  <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
    <div class="panel-body">	
	
        <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header bg-info text-white">
            <div class="row">
             <div class="col-lg-2">Regulation</div>
             <div class="col-lg-2">Code</div>
             <div class="col-lg-3">Name</div>
             <div class="col-lg-2">Policy</div>
             <div class="col-lg-2">Category</div>
             <div class="col-lg-1">Credits</div>
             </div>
            </div>
            <div class="card-body">
              <?php foreach($sub_list as $sub1){ 
                if($sub1->sem=='1'){
                ?>
            <div class="row">
             <div class="col-lg-2"><?=$sub1->regulatn?></div>
             <div class="col-lg-2"><?=$sub1->subCode?></div>
             <div class="col-lg-3"><?=$sub1->subName?></div>
             <div class="col-lg-2"><?=$sub1->plcy?></div>
             <div class="col-lg-2"><?=$sub1->subCatg?></div>
             <div class="col-lg-1"><?=$sub1->creditPnt?></div>
             </div>
             <?php }} ?>
            </div>
          </div>
          </div>
          </div>
	  
	      </div>	
        </div>
	 </div> 

	 
<!-- Waiting List Starts-->
<div class="panel-group" id="accordion1" role="tablist" aria-multiselectable="true">
  <a data-toggle="collapse" data-parent="#accordion1" href="#collapseOne1" aria-expanded="false" aria-controls="collapseOne">	 
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><h4 class="text-center panel-title"> Semester 2</h4></div>
  
</div>
</div>
</div>
</a>		  
  <div id="collapseOne1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
   <div class="panel-body">
      
   <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header bg-info text-white">
            <div class="row">
             <div class="col-lg-2">Regulation</div>
             <div class="col-lg-2">Code</div>
             <div class="col-lg-3">Name</div>
             <div class="col-lg-2">Policy</div>
             <div class="col-lg-2">Category</div>
             <div class="col-lg-1">Credits</div>
             </div>
            </div>
            <div class="card-body">
              <?php foreach($sub_list as $sub1){ 
                if($sub1->sem=='2'){
                ?>
            <div class="row">
             <div class="col-lg-2"><?=$sub1->regulatn?></div>
             <div class="col-lg-2"><?=$sub1->subCode?></div>
             <div class="col-lg-3"><?=$sub1->subName?></div>
             <div class="col-lg-2"><?=$sub1->plcy?></div>
             <div class="col-lg-2"><?=$sub1->subCatg?></div>
             <div class="col-lg-1"><?=$sub1->creditPnt?></div>
             </div>
             <?php }} ?>
            </div>
          </div>
          </div>
          </div>

	  </div>
         </div>
          </div>
							  
	<!-- Not Eligible Starts --> 
<div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
  <a data-toggle="collapse" data-parent="#accordion2" href="#collapseOne2" aria-expanded="false" aria-controls="collapseOne">	
	  <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><h4 class="text-center panel-title"> Semester 3</h4></div>
  
</div>
</div>
</div>
</a>		  
  <div id="collapseOne2" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
    <div class="panel-body">
      
    <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header bg-info text-white">
            <div class="row">
             <div class="col-lg-2">Regulation</div>
             <div class="col-lg-2">Code</div>
             <div class="col-lg-3">Name</div>
             <div class="col-lg-2">Policy</div>
             <div class="col-lg-2">Category</div>
             <div class="col-lg-1">Credits</div>
             </div>
            </div>
            <div class="card-body">
              <?php foreach($sub_list as $sub1){ 
                if($sub1->sem=='3'){
                ?>
            <div class="row">
             <div class="col-lg-2"><?=$sub1->regulatn?></div>
             <div class="col-lg-2"><?=$sub1->subCode?></div>
             <div class="col-lg-3"><?=$sub1->subName?></div>
             <div class="col-lg-2"><?=$sub1->plcy?></div>
             <div class="col-lg-2"><?=$sub1->subCatg?></div>
             <div class="col-lg-1"><?=$sub1->creditPnt?></div>
             </div>
             <?php }} ?>
            </div>
          </div>
          </div>
          </div>

	  </div>
       </div>
        </div>

     
       <!--End Dashboard Content-->

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <style>
    
   .ls-view {
    float: right;
    color: black;
}
    </style>