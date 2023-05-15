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
						<form method="post" action="<?=base_url()?>Accounts/consolidatedPaidReports">
						<div class="row">
						<div class="col-md-3">
			<label>Stream</label>
			<select class="form-control" require name="main_course_id" id="main_course_id" >
			<option value="">Select Stream</option>
			<option <?php if($main_course_id == 5){echo "selected";} ?> value="5">UG</option>
			<option  <?php if($main_course_id == 2){echo "selected";} ?> value="2">PG - MSW Aided</option>
			<option <?php if($main_course_id == 1){echo "selected";} ?> value="1">PG - Self Finance</option>
			<option <?php if($main_course_id == 3){echo "selected";} ?>  value="3">PG - MSW Self Finance</option>
			<option <?php if($main_course_id == 4){echo "selected";} ?>  value="4">PG Diploma</option>
			</select>
			</div>
			<div class="col-md-3" id="app_course" >
			<?php 
			
			if ($main_course_id == 1) {
				$pg_sf = $this->db->where('cs_id=5 or cs_id=6 or cs_id=7 or cs_id=8 or cs_id=9 or cs_id=15 or cs_id=16')->get('college_course')->result();
				$option = "<option value=''>Select an Option</option>";
				foreach ($pg_sf as $pgsf) {
					$option .= "<option value='" . $pgsf->cs_id . "'>" . $pgsf->cs_name . "</option>";
				}
			//	echo $option;
			} else if ($main_course_id == 2 || $main_course_id == 3) {
				$option = "<option value=''>Select an Option</option>";
				$pg_msw = array('1' => 'Community Development', '2' => 'Medical & Psychiatric Social Work', '3' => 'Human Resource Management');
				foreach ($pg_msw as $key => $pgmsw) {
					$option .= "<option value='" . $key . "'>" . $pgmsw . "</option>";
				}
				//echo $option;
			} else if ($main_course_id == 4) {
				$option = "<option value=''>Select an Option</option>";
				$option .= "<option value='10'>Personnel Management & Industrial Relations (SF)</option>";
				$option .= "<option value='11'>Human Resource Management (SF)</option>";
			//	echo $option;
			} else if ($main_course_id == 5) {
				$option = "<option value=''>Select an Option</option>";
				$option .= "<option value='1'>B.S.W (SF)</option>";
				$option .= "<option value='2'>B.Sc Psychology (SF)</option>";
				//echo $option;
			} else {
				//echo $option = "<option value=''>Select an Option</option>";
			}
			

			?>


			<label>Program</label>
			<select class="form-control" require id="app_course_id" name="app_course_id" >
			<option value="">Select Program</option>
			<?=$option?>
			</select>
			</div>


			<div class="col-md-3" id="year" >
			
			<label>Year</label>
			<select class="form-control year" id="aayear" require name="year">
			<option value="">Select Year</option>
			<option <?php if($year == 1){echo "selected";} ?> value="1">First Year</option>
			<option <?php if($year == 2){echo "selected";} ?> value="2">Second Year</option>
			<option  <?php if($year == 3){echo "selected";} ?> value="3">Third Year</option>
			</select>
			</div>
			<?php
            $date = date('Y'); 
              $olddate2 = date("Y",strtotime ( '-3 year' , strtotime ( $date ) )) ;
              $olddate1 = date("Y",strtotime ( '-2 year' , strtotime ( $date ) )) ;
              $olddate = date("Y",strtotime ( '-1 year' , strtotime ( $date ) )) ;
			
          
            $newdate = date("Y",strtotime ( '+1 year' , strtotime ( $date ) )) ;
			?>
			<div class="col-md-3" id="batch" >
			<label>Batch</label>
			<select class="form-control batch"  id="battach"  name="batch">
			<option value="">Select Batch</option>
			<option <?php if($batch == $olddate1){echo "selected";} ?> value="<?php echo $olddate2;?>"><?php echo $olddate2;?></option>
			<option <?php if($batch == $olddate1){echo "selected";} ?> value="<?php echo $olddate1;?>"><?php echo $olddate1;?></option>
			<option <?php if($batch == $olddate1){echo "selected";} ?> value="<?php echo $olddate;?>"><?php echo $olddate;?></option>
			<option <?php if($batch == $olddate1){echo "selected";} ?> value="<?php echo $date;?>"><?php echo $date;?></option>
			<option <?php if($batch == $olddate1){echo "selected";} ?> value="<?php echo $newdate;?>"><?php echo $newdate;?></option>
			</select>
			</div>



			<div class="col-md-3" >
			<label>Category</label>
			<select class="form-control" require name="category">
			<option value="">Select Category</option>
			<?php  foreach ($category as $key => $value) {   ?>
			
<option <?php if($categorys == $value->ac_id ){echo"selected";} ?> value="<?=$value->ac_id?>"><?=$value->ac_name?></option>



		<?php	}   ?>
	
			</select>
			</div>
			
		
			
		
		
						
            <div class="col-md-3">
			<label>Date From</label>
           
			<input type="date" class="form-control" value="<?=$fdate?>" name="datef" required>
            </div><div class="col-md-3">
			<label>Date To</label>
            
			<input type="date" class="form-control" value="<?=$tdate?>" name="datet" required>
            </div>
						
						<div class="col-md-3">
						<h3> </h3>
			<button type="submit" class="btn btn-primary" value="">Submit</button>
            </div>
					
            </div>
          	</form>

						<!--<form id="myForm" action="<?=base_url().'accounts/consolidatedPaidReports'?>" method="post">	
	        <div class="row">
			<div class="col-md-3">
			<label>Stream</label>
			<select class="form-control" require name="main_course_id" id="main_course_id" >
			<option value="">Select Stream</option>
			<option value="5">UG</option>
			<option value="2">PG - MSW Aided</option>
			<option value="1">PG - Self Finance</option>
			<option value="3">PG - MSW Self Finance</option>
			<option value="4">PG Diploma</option>
			</select>
			</div>
			<div class="col-md-3" id="app_course" >
			<label>Program</label>
			<select class="form-control" require id="app_course_id" name="app_course_id" >
			<option value="">Select Program</option>
			</select>
			</div>
			<div class="col-md-3" id="year" >
			
			<label>Year</label>
			<select class="form-control year" id="aayear" require name="year">
			<option value="">Select Year</option>
			</select>
			</div>
			<?php
            $date = date('Y'); 
              $olddate2 = date("Y",strtotime ( '-3 year' , strtotime ( $date ) )) ;
              $olddate1 = date("Y",strtotime ( '-2 year' , strtotime ( $date ) )) ;
              $olddate = date("Y",strtotime ( '-1 year' , strtotime ( $date ) )) ;
			
          
            $newdate = date("Y",strtotime ( '+1 year' , strtotime ( $date ) )) ;
			?>
			<div class="col-md-3" id="batch" >
			<label>Batch</label>
			<select class="form-control batch"  id="battach"  name="batch">
			<option value="">Select Batch</option>
			<option value="<?php echo $olddate2;?>"><?php echo $olddate2;?></option>
			<option value="<?php echo $olddate1;?>"><?php echo $olddate1;?></option>
			<option value="<?php echo $olddate;?>"><?php echo $olddate;?></option>
			<option value="<?php echo $date;?>"><?php echo $date;?></option>
			<option value="<?php echo $newdate;?>"><?php echo $newdate;?></option>
			</select>
			</div>
			
			</div>
            <br>
            <br>
            <div id="main" >
			<div class="row">
            <div class="col-md-3">
			<label>Select Category</label>
        
		<select class="form-control batch" id="category" require name="category">
			<option value="">Select Category</option>
			<?php foreach ($category as $key => $value) { ?>
				<option value="<?=$value->ac_id?>"><?=$value->ac_name?></option>
		<?php	} ?>
		
		
			</select>

            </div>
			<div class="col-md-3">
			<label>Date From</label>
           
			<input type="date" class="form-control" name="datef"  >
            </div><div class="col-md-3">
			<label>Date To</label>
            
			<input type="date" class="form-control" name="datet" >
            </div>
			<div class="col-md-3">
			<label>Action</label><br>
			<button type="submit" class="btn btn-primary">Find Report </button>
			</div>
            </div>

			
			
		</form>-->





          </div>
        </div>
      </div>
	  

    </div>
	 <div class="row">
        <div class="col-lg-12 " style="overflow:scroll;">
          <div class="card">
            <div class="card-header"><i class="fa fa-file-text"></i>Consolidated Report
        
        
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
                <th>Register Number</th>
                <th>Department</th>
                <th>Application No.</th>
                <th>Year</th>
                <th>Batch</th>
                <th>Category</th>
                <th>Discription</th>
                <th>Fee Name</th>
                <th>Payment Type</th>
                <th>Payment Mode</th>
                <th>Actual Fee </th>
                <th>Paid Fee </th>
               
                <th>Date</th>
              <!--  <th>View</th>-->
               
            </tr>
        </thead>
        <tbody>
           <?php 
					 
/*  echo"<pre>";
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
					  <td><?=$value->as_name?></td>
					  <td><?=$value->as_reg_num?></td>
					  <td><?=$value->as_dep?></td>
					  <td><?=$value->as_app_number?></td>
					  
					  <td><?=$year_s?></td>
						<td><?=$value->u_year?></td>
					  <td><?=$value->ac_name?></td>
					  <td><?=$value->f_discription?></td>
					  <td><?=$value->af_fees_name?></td>
					  <td><?=$payment_type?></td>
					  <td><?=$p_mode?></td>
					  <td><?=$value->f_amount?></td>
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
								<th>Register Number</th>
                <th>Department</th>
                <th>Application No.</th>
                <th>Year</th>
                <th>Batch</th>
                <th>Category</th>
								<th>Discription</th>
                <th>Fee Name</th>
                <th>Payment Type</th>
                <th>Payment Mode</th>
                <th>Actual Fee </th>
                <th>Paid Fee </th>
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
