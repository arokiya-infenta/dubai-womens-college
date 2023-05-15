<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

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
            <div class="card-header"> 
            <div class="row">
        
            <div class="col-lg-4"><i class="fa fa-file-text"></i> Admitted Student list</div>
            <div class="col-lg-2">
              
        
          </div>
           
            <div class="col-lg-2">    
      
</div>
        
<div class="col-lg-2"> <a href="<?=base_url()?>CommonFunction/admitStudentErp/2/<?=$this->session->userdata("user")["user_dep_status"]?>" class="btn btn-secondary"> Admit ERP</a></div>            
         

<div class="col-lg-2">

</div>


</div>
          </div>
            <div class="card-body">
              <div class="table-responsive">
              <table  id="example_reg"    class="table table-bordered table-hover">
                <thead>
                <tr>
                <th>S.No</th>
                                           
                                         
                                           <th>Student Name</th>
                                           <th>Batch</th>
                                           <th>Reg No</th>
                                          
                                           <th>D.O.B</th>
                                         
                                          
                                           
                                        </tr>
                    </tr>
                </thead>
                <tbody>


                    
                    <?php 
            


                                   //   print_r($dep); 

$i=1;


                    foreach ($student as $key => $value) { 
                      
                      
                      
                   
                      ?>
                        <tr>
                        <td><?=$i?>  <!--<input type="hidden" name="publishedstatus[]" value="<?=$value->sl_id?>" id="isAgeSelected"/>--> </td>
                        <td><?=$value->student_name_?></td>
                        <td><?=$value->batch_?></td>
                        <td><?=$value->reg_no_?> </td>
                        <td><?=date("d-M-Y",strtotime($value->dob_))?> </td>
                      
                       
                     
                    </tr>









                    <?php $i++; } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                <th>S.No</th>
                                           
								<th>Student Name</th>
                                         <!--  <th>Batch</th>-->
                                           <th>Reg No</th>
                                          
                                           <th>D.O.B</th>
                                           <th>Photo</th>
                                           
                                        </tr>
                </tfoot>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>
	
    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
$(document).ready(function(){
 // alert();




$('#admitedstudent').DataTable( {
        lengthChange: false,
        buttons: [ 'excel', 'pdf', ],
        "order": [[ 4, "asc" ]],
        
      } );
 


});
    
    
    </script>
