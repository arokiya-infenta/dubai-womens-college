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
            <div class="card-header"><i class="fa fa-file-text"></i> Transaction History 
        
        
           <!-- <button  style="float: right;" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Add</button>
       
        -->
       
       
        </div>
            <div class="card-body">
			<?php //print_r($data); ?>
            <table id="example_th" class="table-striped table-bordered text-center display compact" style="width:100%">
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
                <th>View</th>
               
            </tr>
        </thead>
        <tbody>
            <?php 
            
            $i=1;
            foreach ($data as $key => $value) {
                
                
                if($value->af_installment_id == 1){

                    $payment = "Payment - Full Payment";
                  
                  }else{
                  
                    $payment = "Payment - Installment Payment";
                  
                  }
                  
                  if($value->year == 1){
                  
                    $year = "First Year";
                  
                  }else if($value->year == 2){
                  
                    $year = "Second Year";
                  
                  }else{
                  
                  $year = "Third Year";
                  
                  }
                
                
                if($value->af_generated_by == 0 || $value->af_generated_by ==1 ){

                  $pty = "ERP  Transaction ";
                }else if($value->af_generated_by == 2){

                  $pty = "Miscellaneous Transaction ";
                }else if($value->af_generated_by == 3){

                  $pty = "Off Line Transaction ";

                }
                
                ?>
           <tr>
      <th scope="row"><?=$i?></th>
      <?php if($value->as_name ==null){ ?>
     <td><?=$value->af_reg_number?></td>
     <?php   }else{ ?>
      <td><?=$value->u_name?></td>

     <?php } ?>
      
     
      <td><?=$value->comp_name?></td>
			<td><?=$value->application_number?></td>
      <td><?=$year?></td>
      <td><?=$value->batch?></td>
      <td><?=$value->ac_name?></td>
      <td><?=$value->f_name?></td>
      <td><?=$payment?></td>
      <td><?=$pty?></td>
      <td><?=$value->af_fees_total_amt?></td>
      <td><?=date("d-M-Y",strtotime($value->af_response_time))?></td>
    
		
		
		<?php  if($value->af_generated_by == 0 || $value->af_generated_by ==1 ){  ?>

			<td><a href="<?=base_url()?>invoice/%23TNR<?=sprintf("%'06d", $value->af_id).".pdf"?>" class="btn btn-primary btn-sm">View</a></td>
<?php }else if($value->af_generated_by == 2){ ?>

<td><a href="#" class="btn btn-primary btn-sm">No Pdf</a></td>
<?php }else if($value->af_generated_by == 3){ ?>

	<td><a href="<?=base_url()?>invoice/%23TNR<?=sprintf("%'06d", $value->af_id).".pdf"?>" class="btn btn-primary btn-sm">View</a>
	<a href="<?=base_url()?>Accounts/deleteTransaction/<?=$value->af_id?>" class="btn btn-danger btn-sm">Delete</a></td>

<?php }  ?>
		
		
    </tr>

      
        

        <?php     $i++;
            } ?>    
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
                <th>View</th>
               
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<style>

div.card-body {
        width: 100%;
    }
	</style>
	<script>
     

 </script>
