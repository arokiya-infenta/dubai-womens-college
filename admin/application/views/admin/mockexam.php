<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



      <!--Start Dashboard Content-->
	 

      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Mock Exam</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Course </th>
                        <th>application</th>
                    
                        <th>Action</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php foreach ($applicationactive as $key => $value) { ?>
                      <tr>
                        <td><?=$value->comp_name?></td>
                        <td><?php if($value->demo_active ==1 ){echo"Active";}else{echo"In-active";}?></td>
                       
                        
                        <td>
                     
  <input type="checkbox" name="mock" class="mock" <?php if($value->demo_active ==1 ){echo"checked";} ?> value="<?=$value->dp_id?>" data-toggle="toggle" data-on="Enabled" data-off="Disabled"> 
 </td>
                    </tr>
                    <?php } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                <th>Course </th>
                        <th>application</th>
                    
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
  