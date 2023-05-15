
<!-- end section -->
<!-- section -->

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
 
<div id="online_exm">
    <div class="container">
        <div class="row">
             
                <div class="col-md-12 ">

                <legend class="head-one"> <h2 class="ttl">Fees Details </h2></legend> 
                    
                    <div class="headings">
                     <h2 class="ttl"> <span> Your Reference Number : 21<?php echo sprintf("%'04d", $this->session->userdata('user')['user_id']); ?></span></h2>
                     </div>
                    <div class= "content-box well">
                    <!-- <legend class="head-one">My Dashboard </legend>-->




                
<?php foreach ($fees as $key => $value) {
  # code...
$msub_id = 'main_'.$value->sl_main_id.'_app_'.$value->sl_course_id;
$select = 'id,name,'.'main_'.$value->sl_main_id.'_app_'.$value->sl_course_id;
$where = array('1','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26');
$fee_Struct = $this->db->select($select)->from("fees_master")->where_in('id',$where)->get();

$fee_res = $fee_Struct->result_array();


print_r($fee_res);


?>



<div class="container mb-5 mt-5">
    <div class="pricing card-deck flex-column flex-md-row mb-3">
    <div class="card card-pricing popular shadow text-center px-6 mb-8">
    
          
            <div class="card-body pt-0">
           
               
            </div>
    </div>
    
        <div class="card card-pricing text-center px-3 mb-4">
            <span class="h6 w-60 mx-auto px-4 py-1 rounded-bottom bg-primary text-white shadow-sm">Full Payment</span>
           <?php 

           $array_val=[];

$now = time();
$your_date = strtotime($fee_res[4][$msub_id]);
$datediff = $now - $your_date;
$days_tot =  round($datediff / (60 * 60 * 24));

if($fee_res[3][$msub_id] != 0 || $fee_res[3][$msub_id] !="" || $fee_res[3][$msub_id] == NULL){
$fine_atm =  $fee_res[3][$msub_id] * $days_tot;
}else{
$fine_atm = 0;
}

?>
            <div class="card-body pt-0">
                <ul class="list-unstyled mb-4">
                <li><?=$fee_res[0]['name']?> : <?=$fee_res[0][$msub_id]?> ₹ </li>
                <li><?=$fee_res[1]['name']?> : <?=$fee_res[1][$msub_id]?> ₹ </li>
                <li><?=$fee_res[2]['name']?> : <?=$fee_res[2][$msub_id]?> ₹ </li>
                <li><?=$fee_res[4]['name']?> : <?=date('d-M-Y',strtotime($fee_res[4][$msub_id]))?> </li>
                <li><?=$fee_res[3]['name']?> : <?=$fee_res[3][$msub_id]?> * <?=$days_tot?> = <?=$fine_atm?> ₹ </li>
            
<?php if( $fee_res[5][$msub_id] == 1 ){ 
  

  $array_val = array(
      $fee_res[0]['name']=>$fee_res[0][$msub_id],
      $fee_res[1]['name']=>$fee_res[1][$msub_id],
      $fee_res[2]['name']=>$fee_res[2][$msub_id],
      $fee_res[4]['name']=>$fee_res[4][$msub_id],
      $fee_res[3]['name']=>$fee_res[3][$msub_id],
      $fee_res[6]['name']=>$fee_res[6][$msub_id],
      $fee_res[7]['name']=>$fee_res[7][$msub_id],
      $fee_res[8]['name']=>$fee_res[8][$msub_id],
  );


  //    Gst Status == 1

  ?>

                <li><?=$fee_res[6]['name']?> : <?=$fee_res[6][$msub_id]?> % </li>
                <li><?=$fee_res[7]['name']?> : <?=$fee_res[7][$msub_id]?> ₹ </li>
                <li><?=$fee_res[8]['name']?> : <?=$fee_res[8][$msub_id]?> ₹ </li>
                <li>Complete Total : <?php echo $tot_amt = $fee_res[8][$msub_id] + $fine_atm?> ₹ </li>
              
                
<?php } ?>
                
                </ul>
                <a  href="<?=base_url()?>PayFees/paymentModeUg/<?=$value->sl_id?>/1/<?=$tot_amt?>" target="_blank" class="btn btn-outline-secondary mb-3">Pay <?=$tot_amt?> ₹ now</a>
            </div>
        </div>
        <div class="card card-pricing popular shadow text-center px-3 mb-4">
            <span class="h6 w-60 mx-auto px-4 py-1 rounded-bottom bg-primary text-white shadow-sm">Installment</span>
         
            <div class="card-body pt-0">
                <ul class="list-unstyled mb-4">

                <?php if( $fee_res[15][$msub_id] > 0 ){  ?>
                <li><?=$fee_res[10]['name']?> : <?=$fee_res[10][$msub_id]?> ₹ <?=$fee_res[22][$msub_id]?></li>
                <?php } ?>
                <?php if( $fee_res[16][$msub_id] > 0 ){  ?>
                <li><?=$fee_res[11]['name']?> : <?=$fee_res[11][$msub_id]?> ₹ <?=$fee_res[23][$msub_id]?></li>
                <?php } ?>
                <?php if( $fee_res[17][$msub_id] > 0 ){  ?>
                <li><?=$fee_res[12]['name']?> : <?=$fee_res[12][$msub_id]?> ₹ <?=$fee_res[24][$msub_id]?></li>
                <?php } ?>  
                <?php if( $fee_res[18][$msub_id] > 0 ){  ?>
                <li><?=$fee_res[13]['name']?> : <?=$fee_res[13][$msub_id]?> ₹ <?=$fee_res[25][$msub_id]?></li>
                <?php } ?> 
                <?php if( $fee_res[19][$msub_id] > 0 ){  ?>
                <li><?=$fee_res[14]['name']?> : <?=$fee_res[14][$msub_id]?> ₹ <?=$fee_res[26][$msub_id]?></li>
                <?php } ?>
                </ul>
                <a href="<?=base_url()?>PayFees/paymentModeUg/<?=$value->sl_id?>/2/" target="_blank" class="btn btn-primary mb-3">Pay Now</a>
            </div>
        </div>
    
    </div>
</div>


<?php



print_r($array_val);
echo json_encode($array_val);


}


?>

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
  
.shadow-sm{
margin-top: 28px;

}
  ul, li {

    list-style: initial;
    margin: 10px;
    
}
.card-pricing.popular {
    z-index: 1;
    border: 3px solid #007bff;
}
.card-pricing .list-unstyled li {
    padding: .5rem 0;
    color: #6c757d;
    text-align: left;
}
</style>
