<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



      <!--Start Dashboard Content-->
	 

      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Student Marks - Online</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="example1" class="table table-bordered">
                <thead>
                    <tr>
                        <th>SNo </th>
                        <th>Referance Number </th>
                        <th>Name </th>
                        <th>Department</th>
                        <th>Attended Questions</th>
                        <th>Marks</th>
                        <th>Date Time</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php 
                    
                    $i =1 ;
                    foreach ($student as $key => $value) { ?>
                      <tr>
                        <td><?=$i?></td>
                        <td><?=date("y",strtotime($value->u_date)).sprintf("%'04d",$value->pr_user_id)?></td>
                        <td><?=$value->pr_applicant_name?></td>
                        <td><?=$value->exam_category?></td>
                        <td><?=$value->question_attended?></td>
                        <td><?=$value->total_mark?></td>
                        <td><?=date('d-m-Y',strtotime($value->created_date))?></td>
                      

                        
                    </tr>
                    <?php $i++; } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
            
                        <th>SNo </th>
                        <th>Name </th>
                        <th>Department</th>
                        <th>Attended Questions</th>
                        <th>Marks</th>
                        <th>Date Time</th>
                       
                       
                  
                    
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