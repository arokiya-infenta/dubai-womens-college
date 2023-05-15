<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



      <!--Start Dashboard Content-->
	 

      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Application Fee Details</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="example1" class="table table-bordered">
                <thead>
                    <tr>
                        <th>User </th>
                        <th>Registered Date</th>
                        <th>Application Fees</th>
                        <th>Application Number</th>
                        <th>First Preferred Course</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php foreach ($applied as $key => $value) { ?>
                      <tr>
                        <td><?=$value->pr_applicant_name?></td>
                        <td><?=date('d-m-Y',strtotime($value->sa_date))?></td>

                        <?php if($value->sa_response_status == "0300"){


                          echo"<td>Paid</td>";

                        }else if($value->sa_response_status == "0399" || $value->sa_response_status == "NA"  || $value->sa_response_status == "0001"){

                          echo"<td>Failed</td>";

                        }else {

                          echo"<td>Un Paid</td>";


                        } ?>
                       
                       <?php if($value->sa_application_num == null || $value->sa_application_num == "" ){


echo"<td>-------</td>";

}else{

echo "<td>".$value->sa_application_num."</td>";

} ?>
                      
                        <td><?=$value->cs_name?></td>
                    </tr>
                    <?php } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                        <th>User </th>
                        <th>Registered Date</th>
                        <th>Application Fees</th>
                        <th>Application Number</th>
                        <th>First Preferred Course</th>
                    
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