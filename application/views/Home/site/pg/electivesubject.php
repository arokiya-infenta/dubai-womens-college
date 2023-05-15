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
<div class="section contact_section" style="background:#12385b; ">
<div class="">
        <div class="container">
        <div class="row">
             <div class="col-md-2 "></div>
             <div class="col-md-8 ">
              <?=$this->session->flashdata('message');?>
              <?php unset($_SESSION['message']); ?>
             </div>
             <div class="col-md-2 "></div>
            
</div>
            <div class="row"> 
            <div class="col-md-12"> 
    <br />
    <h2 align="center" style="color:white;">Elective Subjects  </h2>   
    <br />
    <div class="container" >
    <div class="row"> 
            <div class="col-md-12"> 

<?php

/* print_r($my_elective);
print_r($select_elective);
 */
if(sizeof($my_elective) == 0){
?>

<form method="post" action="<?=base_url()?>Academics/selectElective">
  

 
    <div class="form-group row" style="color:white;">
	<label style="color:white;" class="col-sm-6 col-form-label" for="inlineFormCustomSelect">Select Elective Subject </label>
      <div class="col-sm-6">
	  <select class="form-control" name="elective_id" required id="inlineFormCustomSelect">
        <option value="">Choose...</option>
		<?php foreach ($select_elective as $key => $value) { ?>
			
        <option value="<?=$value->id?>"><?=$value->subCode?> - <?=$value->subName?></option>

		<?php	}  ?>
       
      </select>
      </div>
    </div>

   <div class="form-group row">
    <div class="col-sm-10">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </div>
</form>
  

<?php  }else{ ?>

	<h2 align="center">Selected Elective Subject</h2> 

	<table id="example" class="table" style="width:100%">
<thead>
    <tr>
        <th>SUBJECT CODE</th>
        <th>SUBJECT NAME</th>
        <th>CATEGORY</th>
       
    </tr>
</thead>
<tbody>
<tr>
        <th><?=$my_elective[0]->subCode?></th>
        <th><?=$my_elective[0]->subName?></th>
        <th><?=$my_elective[0]->subCatg?></th>
       
    </tr>

</tbody>

</table>




<?php }  ?>

      
    </div>
    </div>
    </div>
	<div class="container" style="padding-top:300px;">
    </div>
    </div>
   
    </div>
    </div>
    </div>
    </div>
	<style>
		div {

  color: white;
}
	</style>
  
