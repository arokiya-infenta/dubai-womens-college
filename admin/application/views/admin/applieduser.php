<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



      <!--Start Dashboard Content-->
	 

      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Applied User</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>User </th>
                        <th>Registered Date</th>
                        <th>Prefered First Course</th>
                        <th>Action</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php foreach ($applied as $key => $value) { ?>
                      <tr>
                        <td><?=$value->pr_applicant_name?></td>
                        <td><?=date('d-m-Y',strtotime($value->sa_date))?></td>
                        <td><?=$value->cs_name?></td>
                        
                        <td>
                        <a href="<?=site_url()?>/Admin/viewApplicant/<?=$value->sa_st_id?>" class="btn btn-primary" ><i class="fa fa-eye" aria-hidden="true"></i></a>
                        <a target="_blank" href="<?=site_url()?>/Admin/downloadPdF/<?=$value->sa_st_id?>" class="btn btn-danger" ><i class="fa fa-download" aria-hidden="true"></i></a>
                        <Button  value="<?=$value->sa_st_id?>" class="remove btn btn-warning" ><i class="fa fa-times" aria-hidden="true"></i></Button>
                        </td>
                    </tr>
                    <?php } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                        <th>User </th>
                        <th>Registered Date</th>
                        <th>Prefered First Course</th>
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