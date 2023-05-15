<div class="clearfix"></div>
  <div class="content-wrapper">
    <div class="container-fluid">

      <!--Start Dashboard Content-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Applied User
            
            
            <button id="cancel" style="float:right; margin-right: 10px;" data-direction="reverse" type="submit" class="btn btn-primary">Back</button></div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>User </th>
                        <th>Registered Date</th>
                        <th>Interview Date</th>
                        <th>Course Finalised</th>
                        <th>Action</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php foreach ($applied as $key => $value) { ?>
                      <tr>
                        <td><?=$value->pr_applicant_name?></td>
                        <td><?=date('d-m-Y',strtotime($value->sa_date))?></td>
                        <td><?=date('d-m-Y',strtotime($value->sa_interview_date))?></td>
                        <td><?=$value->cs_name?></td>
                        
                        <td>
                        <a href="<?=site_url()?>/Admin/admitProfile/<?=$value->sa_st_id?>" class="btn btn-primary">View Complete Details</a>
                       <!-- <div style="float:right; " class="checkbox">
      <input type="checkbox" style="float:right;" name="gender" id="gender" checked />
     </div>
     <input type="hidden" name="hidden_gender" id="hidden_gender" value="<?=$applied[0]->sa_fees?>" />
     <input type="hidden" name="user_id" id="user_id" value="<?=$applied[0]->sa_st_id?>" />-->
                        </td>
                    </tr>
                    <?php } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                        <th>User </th>
                        <th>Registered Date</th>
                        <th>Interview Date</th>
                        <th>Course Finalised</th>
                        <th>Action</th>
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