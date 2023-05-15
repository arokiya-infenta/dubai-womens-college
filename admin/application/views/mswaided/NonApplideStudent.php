<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



      <!--Start Dashboard Content-->
	 

      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i>Non Applied Students</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="example1" class="table table-bordered">
                <thead>
                    <tr>
                        <th>User Name </th>
                        <th>User Mobile</th>
                        <th>User Email</th>
                        <th>Register Date</th>
                        <th>Reference Number</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php foreach ($NonUser as $key => $value) { ?>
                        <tr>
                        <th><?=$value->u_name?> </th>
                        <th><?=$value->u_mobile?></th>
                        <th><?=$value->u_email_id?></th>
                        <th><?=date("d-m-Y",strtotime($value->u_date))?></th>
                        <th>
                        
                        <a href="#">21<?=$value->u_id?></a>
                        </th>
                       
                       
                    </tr>
                    <?php } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                <th>User Name </th>
                        <th>User Mobile</th>
                        <th>User Email</th>
                        <th>Register Date</th>
                        <th>View Info</th>
                    
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