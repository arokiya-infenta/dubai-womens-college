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
            <div class="card-header"><i class="fa fa-file-text"></i> Paid / UnPaid User
        
        
           <!-- <button  style="float: right;" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Add</button>
       
        -->
       
       
        </div>
            <div class="card-body">
						<?php  
					 
$f_amt = $full_cat[0]['f_amount'];
					 
					 
					 ?>
            <table id="example_paid" class="table-striped table-bordered text-center display compact" style="width:100%">
        <thead>
            <tr>
            <th>#</th>
            <th>Register Number</th>
                <th>Name</th>
             
                <th>Application No.</th>
                <th>Actual Fee</th>
              <?php  foreach ($fee_cat as $key => $value) { ?>

								<td> <?=$value['f_name']?></td>
								
						<?php	}  ?>
						<th>Balance</th>
               
            </tr>
        </thead>
        <tbody>
         
				<?php 
				$i=1; foreach ($unpaid as $key => $value) { ?>
<tr>

<td> <?=$i?></td>
<td> <?=$value['user_reg_no']?></td>
<td> <?=$value['user_name']?></td>
<td> <?=$value['user_app_no']?></td>
<td> <?=$f_amt?></td>


<?php

$bal=0;

foreach ($fee_cat as $key => $values) { 
	
	
	$bal +=  (int)$value[$values['f_id']];
	
	?>



<td> <?=$value[$values['f_id']]?></td>

<?php	} 

$balance = $f_amt - $bal;

?>

<td> <?=$balance?></td>
</tr>
<?php	

$i++;
}  ?>


        </tbody>
     
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
