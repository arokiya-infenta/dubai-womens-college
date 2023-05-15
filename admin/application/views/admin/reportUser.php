<div class="clearfix"></div>
  <div class="content-wrapper">
    <div class="container-fluid">

      <!--Start Dashboard Content-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> User Reports
            
            <button id="cancel" style="float:right; margin-right: 10px;" data-direction="reverse" type="submit" class="btn btn-primary">Back</button></div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="example1" class="table table-bordered">
                <thead>
                    <tr>
                       
                        <th>Name </th>
                        <th>Gender </th>
                        <th>Community </th>
                        <th>Preferred Course </th>
                        <th>Approved Course </th>
                        <th>Date</th>
                        <th >User Status</th>
                      
                    </tr>
                </thead>
                <tbody>


                    
                    <?php foreach ($applied as $key => $value) { 
                      
                      
                      
                     $qq =  $this->db->select("*")->from("college_course")->where("cs_id",$value->pr_course_1)->get();
                      
                      
                      $courres = $qq->result();
                      
                      
                      ?>
                      <tr>
                        <td> <a href="<?=base_url()?>Admin/viewCompleteReports/<?=$value->sa_st_id?>" >  <?=$value->pr_applicant_name?></a></td>
                        <td><?=$value->pr_gender?></td>
                        <td><?=$value->pr_community?></td>
                        <td><?=$courres[0]->cs_name?></td>
                       
                       

                        <?php if($value->cs_name =="" || $value->cs_name ==null ){ ?>

<td>------Nil-------</td>

<?php  }else{ ?>
    <td><?=$value->cs_name?></td>
<?php  } ?>
<?php if($value->sa_interview_date == null){ ?>

  <td>not Scheduled</td>

<?php }else{ ?>
<td><?=date('d-m-Y',strtotime($value->sa_interview_date))?></td>

<?php } ?>
                        <?php if($value->sa_interview_attended_status =="" || $value->sa_interview_attended_status ==null ){ ?>

                            <td>New</td>

                        <?php  }else{ ?>
                        <td><?=$value->sa_interview_attended_status?></td>
                        <?php  } ?>
                       
                      
                      
                    </tr>
                    <?php } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                <th>Name </th>
                        <th>Gender </th>
                        <th>community </th>
                        <th>Preferred Course </th>
                        <th>Approved Course </th>
                        <th>Date</th>
                        <th >User Status</th>
                       
                </tr>
                </tfoot>
            </table>
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