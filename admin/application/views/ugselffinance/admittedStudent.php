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
           
         <button class="btn btn-primary m-1" data-toggle="modal" data-target="#defaultsizemodal" >Assign Register Number format</button> 
      
         <div class="modal fade" id="defaultsizemodal">
                  <div class="modal-dialog">
                    <div class="modal-content">
                    <form method="post" action="<?=base_url()?>UgSelfFinance/registerNumberFormat">
                      <div class="modal-header">
                        <h5 class="modal-title"><i class="fa fa-star"></i> Register Number Format</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">

                        <?php 


if($this->session->userdata("user")["user_dep_status"] == 1){


  $dep ="BSW";
}else if($this->session->userdata("user")["user_dep_status"] == 2){

  $dep ="PSY";
}

                        
                       $nt =  $this->db->select("*")->from("student_reg_number_format")->where("batch",date('y'))->where("dep",$dep)->get();
                        
                        $res = $nt->num_rows();


                        if($res > 0){

                          $result = $nt->result();


$batch = $result[0]->batch;
$dept = $result[0]->dep;
$college_code = $result[0]->college_code;
$pg_ug = $result[0]->pg_ug;
$program_code = $result[0]->program_code;
$reg_no_start = $result[0]->reg_no_start;
$reg_no_end = $result[0]->reg_no_end;

                        }else{

                          $college_code =   $pg_ug =  $program_code =   $reg_no_start =   $reg_no_end = "";
                         $dept =$dep;
                         $batch = date('y');
                        }

                        ?>


<label>Batch</label>
                       <input type="text" class="form-control" value="<?=$batch?>" name="batch">
                        <label>Department</label>
                       <input type="text" class="form-control" readonly value="<?=$dept?>" name="department">
                       <label>College Code</label>
                       <input type="text" class="form-control"  value="<?= $college_code?>" name="college_code">
                        <label>PG / UG</label>
                       <input type="text" class="form-control"  value="<?=$pg_ug?>" name="ug_pg"> 
                       <label>Program Code</label>
                       <input type="text" class="form-control"  value="<?=$program_code?>" name="prog_code"> 
                       <label>Reg No Start</label>
                       <input type="text" class="form-control"  value="<?=$reg_no_start?>" name="start_reg_num">
                       <label>Reg No End</label>
                       <input type="text" class="form-control"  value="<?=$reg_no_end?>" name="end_reg_num">
                       
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Save Number Format</button>
                      </div>
                      </form>
                    </div>
                  </div>
                </div>
</div>
        
<div class="col-lg-2"> <a href="<?=base_url()?>UgSelfFinance/assignRegisterNumber/<?=$dep?>/21" class="btn btn-secondary"> Assign Regfister number</a></div>            
         
<div class="col-lg-2">
              
<button value="<?=$dep?>" class="delete_all btn btn-danger"> Delete All</button>
</div>



</div>
          </div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="example_reg"   class="table table-bordered table-hover">
                <thead>
                <tr>
                <th>S.No</th>
                                           
                                         
                                           <th>Candidate Name</th>
                                           <th>Application Number</th>
                                           <th>Reservation</th>
                                          
                                           <th>Register Number</th>
                                           <th>Board</th>
                                           <th>Edit</th>
                                          
                                           
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
                        <td><?=$i?>   </td>
                        <td><?=$value->as_name?></td>
                        <td><?=$value->as_app_number?></td>
                        <td><?=$value->as_quata?> </td>
                        <td><?=$value->as_reg_num?> </td>
                        <td><?=$value->pr_board_study?> </td>
                       
                                    
                     
                        <td>    
                      <a href="#"   data-toggle="modal" data-target="#myModalReg<?=$value->as_id?>" value="<?=$value->as_id?>" class="btn btn-primary a-btn-slide-text">
        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
        <span><strong>Edit</strong></span>            
    </a>

    <div id="myModalReg<?=$value->as_id?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
      
        <h4 class="modal-title">Register Number</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
      <input type="text"  class="form-control" name="regnumber" value="<?=$value->as_reg_num?>" id="Reg<?=$value->as_id?>" >
      </div>
      <div class="modal-footer">
        <button type="button" class="updatereg btn btn-primary" id="<?=$value->as_id?>" >Update</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


      <button href="#" value="<?=$value->as_id?>" class="delete-admited-student btn btn-danger a-btn-slide-text">
       <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
        <span><strong>Delete</strong></span>            
    </button>
                      
                      
                  
                    
                </td>
                

                    





                       
                    </tr>









                    <?php $i++; } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                <th>S.No</th>
                                           
                                         
                                           <th>Candidate Name</th>
                                           <th>Application Number</th>
                                           <th>Reservation</th>
                                          
                                           <th>Register Number</th>
                                           <th></th>
                                           <th>Edit</th>
                                           
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



 $(".delete_all").click(function(e){

var cr_val = $(this).val();



var saveData = $.ajax({
      type: 'POST',
      url: "<?=base_url()?>CommonFunction/deleteAllAdmitedStudent",
      data: {reg_id:cr_val},
      dataType: "text",
      success: function(resultData) { 
//alert(resultData);
       console.log(resultData);

       location.reload()
       }
});
saveData.error(function() { alert("Something went wrong"); });

 });


 $(".updatereg").click(function(e){



var csl = $(this).attr('id');
var reg_id = "Reg"+csl;



var value = $("#"+reg_id).val();



var saveData = $.ajax({
      type: 'POST',
      url: "<?=base_url()?>CommonFunction/updateRegNumber",
      data: {reg_id:csl,value:value},
      dataType: "text",
      success: function(resultData) { 
//alert(resultData);
       console.log(resultData);

       location.reload()
       }
});
saveData.error(function() { alert("Something went wrong"); });


});
 


$(".delete-admited-student").click(function(e){



var csl = $(this).val();


var saveData = $.ajax({
      type: 'POST',
      url: "<?=base_url()?>CommonFunction/deleteAdmitedStudent",
      data: {reg_id:csl},
      dataType: "text",
      success: function(resultData) { 
//alert(resultData);
       console.log(resultData);

       location.reload()
       }
});
saveData.error(function() { alert("Something went wrong"); });



});



$('#admitedstudent').DataTable( {
        lengthChange: false,
        buttons: [ 'excel', 'pdf', ],
        "order": [[ 4, "asc" ]],
        
      } );
 


});
    
    
    </script>
