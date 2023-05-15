
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
 
<div id="">
    <div class="container">
        <div class="row">
             
                <div class="col-md-12">

                <legend class="head-one"> <h2 class="ttl">My Payments</h2></legend> 
                    
                    <div class="headings">
                    <!-- <h2 class="ttl"> <span> Your Reference Number : 21<?php echo sprintf("%'04d", $this->session->userdata('user')['user_id']); ?></span></h2>-->
                     </div>
                    <div class= "content-box well"  style="height: 800px;">
                    <!-- <legend class="head-one">My Dashboard </legend>-->


<?php //print_r($data); ?>
<table class="table">
  <thead class="thead-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Category</th>
      <th scope="col">Payment Name</th>
      <th scope="col">Date</th>
      <th scope="col">Download</th>
    </tr>
  </thead>
  <tbody>
      <?php
      
      
      $i=1;
      
      foreach ($data as $key => $value) {  ?>
         
    <tr>
      <th scope="row"><?=$i?></th>
      <td><?=$value->ac_name?></td>
      <td><?=$value->f_name?></td>
      <td><?=date("d-M-Y",strtotime($value->af_response_time))?></td>
      <td><a href="<?=base_url()?>admin/invoice/%23TNR<?=sprintf("%'06d", $value->af_id).".pdf"?>" class="btn btn-primary">View</a></td>
    </tr>
    <?php  $i++; } ?>
   
  </tbody>
</table>


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
