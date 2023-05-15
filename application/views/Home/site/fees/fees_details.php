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
 
<div id="">
    <div class="container">
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
             
                <div class="col-md-6 ">

                <legend class="head-one"> <h2 class="ttl">Pay Program Fee </h2></legend> 
                    
                    <div class="headings">
                    <!-- <h2 class="ttl"> <span> Your Reference Number : 21<?php echo sprintf("%'04d", $this->session->userdata('user')['user_id']); ?></span></h2>-->
                     </div>
                    <div class= "content-box well">
                    <!-- <legend class="head-one">My Dashboard </legend>-->


<div class="section layout_padding padding_bottom-0" style="background:#12385b; padding-top:100px;">
    <div class="container">
        <div class="row" >
        <div class="cent" style="height: 600px;">

      
      
      
      
      <?php  
//print_r($selected);


foreach ($selected as $key => $value) {    ?>

<a href="<?=base_url()?>PayFees/CompletepayUg/<?=$value->sl_main_id ?>/<?=$value->sl_course_id?>" type="button" class="btn btn-primary ribbon">Pay Fees for <?= $value->comp_name?></a>

<br>
<br>
<br>
<a href="<?=base_url()?>PayFees/CompletepayUg/<?=$value->sl_main_id ?>/<?=$value->sl_course_id?>" type="button" class="btn btn-primary ribbon">Pay Hostel Fees </a>


<?php
  
}

?>
 </div>
 </div>
 </div>
 </div>
 </div>
    </div>
    <div class="col-md-6 ">

<legend class="head-one"> <h2 class="ttl">Paid Program Fee </h2></legend> 
    
    <div class="headings">
    <!-- <h2 class="ttl"> <span> Your Reference Number : 21<?php echo sprintf("%'04d", $this->session->userdata('user')['user_id']); ?></span></h2>-->
     </div>
    <div class= "content-box well">
    <!-- <legend class="head-one">My Dashboard </legend>-->


<div class="section layout_padding padding_bottom-0" style="background:#12385b; padding-top:100px;">
<div class="container">
<div class="row" >
<div class="col-md-3" ></div>
<div class="col-md-6" >
<div class="cent" style="height: 600px;">
<?php  

$q = $this->db->select("*")->from("accounts_fees_transaction")
->join("department_details","accounts_fees_transaction.af_main_id = department_details.main_id AND accounts_fees_transaction.af_course_id = department_details.cour_id")
->join("accounts_fee_master","accounts_fees_transaction.af_fees_id = accounts_fee_master.f_id")
->join("accounts_category","accounts_fees_transaction.af_category_id = accounts_category.ac_id")
->where("accounts_fees_transaction.af_paid_status",1)
->where("accounts_fees_transaction.af_student_id",$this->session->userdata('user')['user_id'])
->get();

$r =$q->num_rows();

if($r > 0){


    echo"<a  class='btn btn-primary' href='".base_url()."PayFees/viewMyReciept'>View Reciept</a>";

}else{

echo"<a href='#' class='btn btn-primary'>No Reciept Found</a>";



}


?>
</div>
</div>
<div class="col-md-3" ></div>
</div>
</div>
</div>
</div>
</div>
        </div>
    </div>
 </div>            

           </div>			  
       </div>
    </div>
<!-- end section -->


<script type="text/javascript">

</script>
<style>
  

</style>
