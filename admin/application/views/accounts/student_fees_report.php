<style>
label.gst_la, label.inst {
            float: left;
        }	
          
 span.gst, span.insta {
            display: block;
            overflow: hidden;
            padding: 0px 4px 0px 20px;
			margin-top: -11px;
        }
 span.instd {
            display: block;
            overflow: hidden;
            padding: 0px 4px 0px -1px;
			margin-top: -11px;
        }		
</style>		
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



     <!-- Start Row-->
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
        <div class="col-lg-12 " style="overflow:scroll;">
          <div class="card">
            <div class="card-header"><i class="fa fa-file-text"></i> Search Student Payment 
        
        
           <!-- <button  style="float: right;" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Add</button>
       
        -->
       
       
        </div>
            <div class="card-body">
						<form method="post" action="<?=base_url()?>Accounts/studentPaidReports">
            <div class="row">
						
            <div class="col-md-4">
			<h3>Student Referance Number</h3>
            </div><div class="col-md-4">
			<input type="text" class="form-control" name="ref_number" value="<?=$student_info['register_number']?>">
            </div><div class="col-md-4">
			<button type="submit" class="btn btn-primary" value="">Submit</button>
            </div>
					
            </div>
          	</form>
          </div>
        </div>
      </div>
	  

    </div>
	 <div class="row">
        <div class="col-lg-12 " style="overflow:scroll;">
          <div class="card">
            <div class="card-header"><i class="fa fa-file-text"></i> Student Transaction - <?=$student_info['name']?> (<?=$student_info['application_number']?>) - <?=$student_info['department']?> - Batch : <?=$student_info['year']?>
        
        
           <!-- <button  style="float: right;" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Add</button>
       
        -->
       
       
        </div>
            <div class="card-body">
			<?php //print_r($data); ?>
            <table id="example_paid" class="table-striped table-bordered text-center display compact" style="width:100%">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Name</th>
                <th>Department</th>
                <th>Application No.</th>
                <th>Year</th>
                <th>Batch</th>
                <th>Category</th>
                <th>Fee Name</th>
                <th>Payment Type</th>
                <th>Payment Mode</th>
                <th>Amount</th>
                <th>Date</th>
              <!--  <th>View</th>-->
               
            </tr>
        </thead>
        <tbody>
           <?php 
					 
/* echo"<pre>";
print_r($transaction); */
//print_r($student_info);


					 $i=1;
					 
					 foreach ($transaction as $key => $value) { 
						
						
						if($value->year ==1){
							$year_s ="First Year";
						}else if($value->year ==2){
							$year_s ="Second Year";

						}else{
							$year_s ="Third Year";

						}if($value->payment_type ==1){
							$payment_type ="Full Payment";
						}else{
							$payment_type ="Installment Payment";

						}	
						if($value->af_generated_by ==1||$value->af_generated_by ==0){
							$p_mode ="ERP";
						}else if($value->af_generated_by ==2){
							$p_mode ="MISSI APP";
						}else{
							$p_mode ="OFF Line";

						}
						
						?>
					
			
           <tr>

					  <td><?=$i?></td>
					  <td><?=$student_info['name']?></td>
					  <td><?=$student_info['department']?></td>
					  <td><?=$student_info['application_number']?></td>
					 
					  <td><?=$year_s?></td>
						<td><?=$student_info['year']?></td>
					  <td><?=$value->ac_name?></td>
					  <td><?=$value->af_fees_name?></td>
					  <td><?=$payment_type?></td>
					  <td><?=$p_mode?></td>
					  <td><?=$value->af_fees_total_amt?></td>
					  <td><?=date('d-M-Y',strtotime($value->af_created))?></td>
					 <!-- <td><a href="<?=$value->af_fees_name?>">View</a></td>-->
					 


					 </tr>
      

      
					 <?php	$i++; } ?> 

          
        </tbody>
        <tfoot>
				<tr>
                <th>Sno</th>
                <th>Name</th>
                <th>Department</th>
                <th>Application No.</th>
                <th>Year</th>
                <th>Batch</th>
                <th>Category</th>
                <th>Fee Name</th>
                <th>Payment Type</th>
                <th>Payment Mode</th>
                <th>Amount</th>
                <th>Date</th>
              <!--  <th>View</th>-->
               
            </tr>
        </tfoot>
    </table>

            </div>
          
          </div>
        </div>
      </div>
	  

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
	<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
	<style>

div.card-body {
        width: 100%;
    }
	</style>
	<script>
     

 </script>
