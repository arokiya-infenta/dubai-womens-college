<div class="clearfix"></div>
  <div class="content-wrapper">
    <div class="container-fluid">

      <!--Start Dashboard Content-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Complete Report 
            <button id="cancel" style="float:right; margin-right: 10px;" data-direction="reverse" type="submit" class="btn btn-primary">Back</button></div>
            <div class="card-body">


            <div class="container">    
                <div class="jumbotron">
                  <div class="row">
                      <div class="col-md-4 col-xs-12 col-sm-6 col-lg-4">
                          <img src="<?=base_url()?>/uploads/<?=$applied[0]->pr_photo?>" height="350px" alt="stack photo" class="img">
                      </div>
                      <div class="col-md-8 col-xs-12 col-sm-6 col-lg-8">
                          <div class="container" style="border-bottom:1px solid black">
                            <h2><?=$applied[0]->pr_applicant_name?></h2>
                          </div>
                            <hr>
                          <ul class="container details">
                            <li><p><span class="fa fa-envelope-o" style="width:50px;"></span> Applied  :  <?=date("d - M -Y",strtotime($schdate[0]->sa_date))?></p></li>
                            <li><p><span class="fa fa-calendar" style="width:50px;"></span>Interview Scheduled : <?=date("d - M -Y",strtotime($schdate[0]->sa_interview_date))?></p></li>
                            <li><p><span class="fa fa-check" style="width:50px;"></span>Status : <?=$schdate[0]->sa_interview_attended_status?></p></li>
                            <li><p><span class="fa fa-check" style="width:50px;"></span>Course : <?=$schdate[0]->cs_name?></p></li>
                            <li><p><span class="fa fa-check" style="width:50px;"></span>Roll number  : <?=$schdate[0]->sa_roll_number?></p></li>
                            <li><p><span class="fa fa-check" style="width:50px;"></span>Comments :<?=$schdate[0]->sa_interview_comments?></p></li>
                            <li><p><span class="glyphicon glyphicon-new-window one" style="width:50px;"></span><a href="<?=base_url()?>Admin/viewStudentProfile/<?=$schdate[0]->sa_st_id?>">view complete profile</p></a>
                          </ul>
                      </div>
                  </div>
                </div>


            </div>
          </div>
        </div>
      </div><!-- End Row-->






    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <style>
        .details li {
      list-style: none;
    }
    li {
        margin-bottom:10px;
        
    }
    </style>