<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">





      <!--Start Dashboard Content-->
	 

      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Users Registered</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="example1" class="table table-bordered">
                <thead>
                    <tr>
                        <th>User </th>
                        <th>Register Data</th>
                        <th>E - Mail</th>
                        <th>Mobile</th>
                        <th>Course Priority</th>
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php foreach ($user as $key => $value) { ?>
                      <tr>
                        <td><?=$value->u_name?></td>
                        <td><?=date('d-m-Y',strtotime($value->u_date))?></td>
                        <td><?=$value->u_email_id?></td>
                        <td><?=$value->u_mobile?></td>


                        <?php if( $value->u_course == "" || $value->u_course == null){

echo"<td>--------</td>";

                        }else{

                          echo"<td>". $value->cs_name."<td>";


                        } ?>
                       
                       <!-- <td><button class="btn btn-danger">X</button> <a href="<?=site_url()?>/Admin/editTrust" class="btn btn-info">Edit</a></td>-->
                    </tr>
                    <?php } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                        <th>User </th>
                        <th>Register Data</th>
                        <th>E - Mail</th>
                        <th>Mobile</th>
                        <th>Course Priority</th>
                    
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