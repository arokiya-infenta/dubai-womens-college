<div class="section layout_padding padding_bottom-0" style="background:#12385b; padding-top:100px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="full">
                    <div class="heading_main text_align_center">
                 
                    </div>
                  </div>
            </div>
          </div>
       </div>
    </div>
<!-- end section -->
<!-- section -->
<div class="section contact_section" style="background:#12385b;">
	<div class="">
		    <div class="container">
		        <div class="row"> 
		            <div class="col-md-12 ">
		                    			<div class="row">
					 <div class="col-md-2 "></div>
					 <div class="col-md-8 ">
					  <?=$this->session->flashdata('message');?>
					  <?php unset($_SESSION['message']); ?>
					 </div>
					 <div class="col-md-2 "></div>
					

					</div>

		                    <div class="headings">
		                   
		                 </div>
		                    
							 	<div class="row">
							 		<div class="col-md-2 "></div>
							 		<div class="col-md-8 "></div>
							 		<div class="col-md-2 "></div>
								</div>
								<div class="a" style="
    text-align: center;
">
						
</div>
                 
<div id="invoice">

    <div class="toolbar hidden-print">
        <div class="text-right">
        
            <button id="printInvoice"  class="btn btn-info"><i class="fa fa-file-pdf-o"></i> Export as PDF</button>
        </div>
        <hr>
    </div>
    <div id="tblCustomers" class="invoice overflow-auto">
        <div style="min-width: 600px">
            <header>
                <div class="row">
                    <div class="col">
                     
                            <img src="https://admission.mssw.in//landing/images/mssw_logo.jpg"  style ="width:800px;height:150px"data-holder-rendered="true" />
                        
                    </div>
								
                    <div class="col company-details">
                        <h2 class="name">
                      
                       
                        
                          
                        
                        </h2>
                       
                    </div>
                </div>
            </header>
            <main>
						<h2 class="ttl text-center"  style="color:black;text-align: center !important;">Condonation Paid Status </h2>
							<?php 
							
							if($cond_fee[0]->semester == 1){
								$sem = "First Semester";
							}else if($cond_fee[0]->semester == 2){
								$sem ="Second Semester";
							}else if($cond_fee[0]->semester == 3){
								$sem ="Third Semester";
							}else if($cond_fee[0]->semester== 4){
								$sem ="Fourth Semester";
							}else if($cond_fee[0]->semester == 5){
								$sem ="Fifth Semester";
							}else{
								$sem ="Sixth Semester";

							}
							
							$department_details = $this->db->select("comp_name")->from("department_details")->where("main_id",$cond_fee[0]->stream)->where("cour_id",$cond_fee[0]->department)->get()->result();	
							
							
							?>
                <div class="row contacts">
                    <div class="col invoice-to">
									
                     
                        <h2 class="to">Name : <?=$cond_fee[0]->student_name?></h2>
                        <h2 class="to">Register Number : <?=$cond_fee[0]->register_id?></h2>
                        <h2 class="to"> Batch : <?=$cond_fee[0]->batch?></h2>
                        <h2 class="to">Semester : <?=$sem?></h2>
                        <h2 class="to">Department : <?=$department_details[0]->comp_name?></h2>
                    </div>
                    <div class="col invoice-details">
                       
                        <div class="date">Date of Payment : <?=date("d-M-Y",strtotime($cond_fee[0]->paid_date))?></div>
                        <div class="date">Transaction Id: <?=$cond_fee[0]->transaction_id?></div>
                    </div>
                </div>
                <table border="0" cellspacing="0" cellpadding="0">
                    <thead>
										<tr>
      <th scope="col">#</th>
      <th scope="col">Subject</th>
      <th scope="col">Subject Code</th>
      <th scope="col">Penalty Amount (₹) </th>
      
    </tr>
                    </thead>
                    <tbody>
										<?php $i=1;   
							 $tot_cur_fee=0;
					$tn =		$this->db->select("*")->from("exam_condanation_fees")->where("year",date('y'))->get()->result();
							 foreach ($condanation as $key => $svalue) { 


								$tot_cur_fee += (int)$tn[0]->fine_amt;	
							
							if($svalue->sem == 1){
								$sem = "First Semester";
							}else if($svalue->sem == 2){
								$sem ="Second Semester";
							}else if($svalue->sem == 3){
								$sem ="Third Semester";
							}else if($svalue->sem == 4){
								$sem ="Fourth Semester";
							}else if($svalue->sem == 5){
								$sem ="Fifth Semester";
							}else{
								$sem ="Sixth Semester";

							}
							
							
							
							?>
							<!-- <tr>$svalue->subCode -->
      <th class="no" scope="row"> <?=$i?></th>
      <td><?=$svalue->subName?></td>
      <td><?=$svalue->subCode?></td>
      <td  class="total"> <?=$tn[0]->fine_amt?></td>
   
    </tr>					

	
	<?php $i++; } ?>
                       
                    </tbody>
                    <tfoot>
                    
                     
										<tr>
      <td colspan="3">Total Amount</td>
     
      <td ><label id="tot_amt"><?=$tot_cur_fee?></label></td>
    </tr>
                    </tfoot>
                </table>
            
                <!--<div class="notices">
                    <div>NOTICE:</div>
                    <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
                </div>-->
            </main>
            <footer>
                Receipt was created by MSSW ERP system.
            </footer>
        </div>
        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
        <div></div>
    </div>
</div>
   
    


<!--<div class="row foot-dist">
			                    	<div class="col-lg-12 jump-side">
								
										


												

									<table class="table table-hover">
									<thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Subject</th>
      <th scope="col">Subject Code</th>
      <th scope="col">Penalty Amount (₹) </th>
      
    </tr>
  </thead>
  <tbody>
						   <?php $i=1;   
							 $tot_cur_fee=0;
					$tn =		$this->db->select("*")->from("exam_condanation_fees")->where("year",date('y'))->get()->result();
							 foreach ($condanation as $key => $svalue) { 


								$tot_cur_fee += (int)$tn[0]->fine_amt;	
							
							if($svalue->sem == 1){
								$sem = "First Semester";
							}else if($svalue->sem == 2){
								$sem ="Second Semester";
							}else if($svalue->sem == 3){
								$sem ="Third Semester";
							}else if($svalue->sem == 4){
								$sem ="Fourth Semester";
							}else if($svalue->sem == 5){
								$sem ="Fifth Semester";
							}else{
								$sem ="Sixth Semester";

							}
							
							
							
							?>
					
      <th scope="row"> <?=$i?></th>
      <td><?=$svalue->subName?></td>
      <td><?=$svalue->subCode?></td>
      <td> <?=$tn[0]->fine_amt?></td>
   
    </tr>					

	
	<?php $i++; } ?>
	<tr>
      <td colspan="3">Total Amount</td>
     
      <td ><label id="tot_amt"><?=$tot_cur_fee?></label> <input type="hidden" name="exam_fees" id="f_amt" value="0"></td>
    </tr>
	</tbody>
	</table>

	
											
			                    
		                    	</div>
			                    			
								</div>-->		
		   			</div>
		        </div>
				<!-- <div class="row">     
					<div class="col-md-12 cen text-center">
						 	<div class="stats-box border-1 pad-20">
						 		<h2> Your Reference Number : 210001</h2>
						 		<h2 style="color:red"> SMS will be delayed. Kindly check your e-mail</h2>
						 	</div>
		    		</div>
		   		</div> -->

		    </div>
	 </div>            
  </div>
<!-- end section -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script type="text/javascript">
$("body").on("click", "#printInvoice", function () {
html2canvas($('#tblCustomers')[0], {
onrendered: function (canvas) {
var data = canvas.toDataURL();
var docDefinition = {
content: [{
image: data,
width: 500
}]
};
pdfMake.createPdf(docDefinition).download("Condonation_<?=$cond_fee[0]->transaction_id?>.pdf");
}
});
});
</script>




<style>

#invoice{
    padding: 30px;
}

.invoice {
    position: relative;
    background-color: #FFF;
    min-height: 680px;
    padding: 15px
}

.invoice header {
    padding: 10px 0;
    margin-bottom: 20px;
    border-bottom: 1px solid #3989c6
}

.invoice .company-details {
    text-align: right
}

.invoice .company-details .name {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .contacts {
    margin-bottom: 20px
}

.invoice .invoice-to {
    text-align: left
}

.invoice .invoice-to .to {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .invoice-details {
    text-align: right
}

.invoice .invoice-details .invoice-id {
    margin-top: 0;
    color: #3989c6
}

.invoice main {
    padding-bottom: 50px
}

.invoice main .thanks {
    margin-top: -100px;
    font-size: 2em;
    margin-bottom: 50px
}

.invoice main .notices {
    padding-left: 6px;
    border-left: 6px solid #3989c6
}

.invoice main .notices .notice {
    font-size: 1.2em
}

.invoice table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 20px
}

.invoice table td,.invoice table th {
    padding: 15px;
    background: #eee;
    border-bottom: 1px solid #fff
}

.invoice table th {
    white-space: nowrap;
    font-weight: 400;
    font-size: 16px
}

.invoice table td h3 {
    margin: 0;
    font-weight: 400;
    color: #3989c6;
    font-size: 1.2em
}

.invoice table .qty,.invoice table .total,.invoice table .unit {
    text-align: right;
    font-size: 1.2em
}

.invoice table .no {
    color: #fff;
    font-size: 1.6em;
    background: #3989c6
}

.invoice table .unit {
    background: #ddd
}

.invoice table .total {
    background: #3989c6;
    color: #fff
}

.invoice table tbody tr:last-child td {
    border: none
}

.invoice table tfoot td {
    background: 0 0;
    border-bottom: none;
    white-space: nowrap;
    text-align: right;
    padding: 10px 20px;
    font-size: 1.2em;
    border-top: 1px solid #aaa
}

.invoice table tfoot tr:first-child td {
    border-top: none
}

.invoice table tfoot tr:last-child td {
    color: #3989c6;
    font-size: 1.4em;
    border-top: 1px solid #3989c6
}

.invoice table tfoot tr td:first-child {
    border: none
}

.invoice footer {
    width: 100%;
    text-align: center;
    color: #777;
    border-top: 1px solid #aaa;
    padding: 8px 0
}

@media print {
    .invoice {
        font-size: 11px!important;
        overflow: hidden!important
    }

    .invoice footer {
        position: absolute;
        bottom: 10px;
        page-break-after: always
    }

    .invoice>div:last-child {
        page-break-before: always
    }
}



	.invoice-title h2, .invoice-title h3 {
    display: inline-block;
}

a[disabled] {
   pointer-events: none;
   cursor: default;
}


	.annonce{
	color: #fff;
    font-weight: 600;
	}
	
	.jump-side{
box-shadow: #f8f9fa26 0px 1px 4px, #f8f9fade 0px 1px 4px;
	}
	.all-head{
		color: #fff;
		font-size: 18px;
	}
	.all-head a{
		color: #fff;
	}
	.use-color{
	color: #fff;
    border: .1px solid #ffffff5e;
	}
	.foot-dist{
		padding-bottom: 46px;
	}
	.wps{
    color: #fff;
    font-size: 14px;
    line-height: 20px;
	}
.head-one {
    text-align: center;
    padding-top: 20px;
    text-decoration-style: wavy;
    font-weight: bold;
    color: #195252;
}
.cen{padding: 8px 8px;
}
.well { min-height: 50px;box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);position: relative;margin-bottom:5px;padding-bottom: 30px;-webkit-border-radius: 2px;-moz-border-radius: 2px;-ms-border-radius: 2px;    border-radius: 2px;}
.border-1 {border:1px solid #0b1c2c;}
.pad-20 {padding:39px;}
.stats-box {min-height:115px; background: #fff; border-radius:5px;}

@media (min-width: 1200px){
.container {
    max-width: 1400px;
}}.stats-box {
    min-height: 115px;
    background: #ff8100e0;
    border-radius: 13px;
}
.top-head{
	text-align: inherit !important;
	font-weight: 600;
}
.ttl {
  
    font-weight: 600;
     text-align: inherit !important; 
}
.ttl span{
  float: right;
  font-size: 16px;
    font-weight: 400;
}
div{
	color: black;
}
</style>
