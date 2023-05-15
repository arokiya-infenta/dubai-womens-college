<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



      <!--Start Dashboard Content-->
	 

				<form action="" method="GET">
        <div class="row">
					 <div class="col-md-2 "></div>
					 <div class="col-md-8 ">
					  <?php if(!empty($this->session->flashdata('message'))){

echo $this->session->flashdata('message');

            } ?>
					 </div>
					 <div class="col-md-2 "></div>
					</div>	

      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-file-text"></i>Admit Student</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="example"  style="width: 650px;" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Candidate Name </th>
                        <th>Application Number </th>
                        <th>Applied Date </th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Date Of Birth</th>
                        <th>Gender</th>
                        

                        <th>Community</th>
                        <th>Admitted Status</th>
                        <th>Action</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php 
                    
                    $dep =array(
                      '2'=>"PGD-PMIR (SF)",
                      '3'=>"PGD-HRM (SF)",
                     
                    );



                                   //   print_r($dep); 




                    foreach ($student as $key => $value) { 
                      
                      
                      
                      
                    $ent =  $this->db->select("*")->from("online_exam_pannel")->Where("student_id",$value->u_id)->get();
                      
                      $m = $ent->num_rows();
                      if($m > 0 ){

                          $mark  = $ent->result();
                          $ma_emt = $mark[0]->total_mark;
                          $cal = $mark[0]->total_mark;

                      }else{


                        $ma_emt = "A";
                        $cal = 0;
                      }
                      $total =  $cal + (float)$value->UG_two_percentage;
                      ?>
                        <tr>
                        <td><a href="<?=base_url()?>PgDiploma/viewStudent/<?=$value->u_id?>"><?=$value->pr_applicant_name?> </a></td>
                        <td><?=$value->application_number?></td>
                        <td><?=date("d-m-Y",strtotime($value->date))?></td>
                        <td><?=$value->u_mobile?></td>
                        <td><?=$value->u_email_id?></td>
                        <td><?=date("d-m-Y",strtotime($value->pr_dob))?></td>
                        <td><?=$value->pr_gender?></td>
                        <td><?=$value->pr_community?></td>
                        <td>Yes</td>
                     
                     
                        <td>
            <a data-toggle="modal" data-target="#exampleModal<?=$value->u_id?>" class="btn btn-primary">Add</a>
                      
                        </td>
                       
                       
                    </tr>

                    <div class="modal fade" id="exampleModal<?=$value->u_id?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <form method="post" action="<?=base_url()?>PgDiploma/admitStudent">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Admit Student : <?=$value->pr_applicant_name?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
     
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Register Number:</label>
            <input type="text" class="form-control" name="registernumber" required id="recipient-name" value="">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Admit:</label>
          <div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="admit" id="inlineRadio1" value="1">
  <label class="form-check-label" for="inlineRadio1">Yes</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="admit" id="inlineRadio2" value="0">
  <label class="form-check-label" for="inlineRadio2">No</label>
</div>
</div>
          <div class="form-group">
        <input type ="hidden" name="student_id" value="<?=$value->u_id?>">
        <input type ="hidden" name="batch" value="<?=$value->u_year?>">
       
        <button type="submit" class="btn btn-primary">Save</button>
  </div>
  </div>

  </form>

      </div>
   
    
    </div>
  </div>



                    <?php } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                        <th>Candidate Name </th>
                        <th>Application Number </th>
                        <th>Applied Date </th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Date Of Birth</th>
                        <th>Gender</th>
                        

                        <th>Community</th>
                      
                      
                        <th>Admitted Status</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>
				</form><!-- End Row-->

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
 