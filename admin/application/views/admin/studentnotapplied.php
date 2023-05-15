<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



     <!-- Start Row-->
	  
					<?php if(isset($studentnotapplied)){ ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
		  <div class="card-header"><i class="fa fa-file-text"></i> Student Not Applied</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="example5" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>User Name </th>
                        <th>User Mobile</th>
                        <th>User Email</th>
                        <th>Register Date</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php $sno=1;
					foreach ($studentnotapplied as $key => $value) { ?>
                        <tr>
                        <th><?=$sno++?> </th>
                        <th><?=$value->u_name.' '.$value->u_lastname?> </th>
                        <th><?=$value->u_mobile?></th>
                        <th><?=$value->u_email_id?></th>
                        <th><?=date("d-m-Y",strtotime($value->u_date))?></th>
                       
                       
                    </tr>
                    <?php } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                <th>S.No</th>
                        <th>User Name </th>
                        <th>User Mobile</th>
                        <th>User Email</th>
                        <th>Register Date</th>
                    
                    </tr>
                </tfoot>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>
					<?php } ?>
				<!-- End Row-->

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    