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
        <div class="section contact_section" style="background:#12385b;">
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
            <h2 align="center">Certificate Request </h2><button type="button"  style="float: right;" class="btn btn-primary text-right"  data-toggle="modal" data-target=".bd-example-modal-lg">Add</button>
            <br />
            <div class="container">
			<div class="row"> 
                    <div class="col-md-12"> 




					<table id="example" class="table" style="width:100%">
        <thead>
            <tr>
                <th>Requested Certificate</th>
                <th>Title</th>
                <th>Request Date</th>
                <th>Status</th>
                <th>Response Date</th>
                <th>Comment</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

		<?php foreach ($requested_certificate as $key => $value) { 
			
			if($value->sr_status == 0 ){
				$status= "<b class='text-danger'>Pending</b>";
				$response_date="Pending";

			}else{

				$status= "<b class='text-success'>Updated</b>";
				$response_date=date("d-M-y",strtotime($value->sr_res_date));
			}
			if($value->sr_upload == "" ){

$dowanload="In - Progress";


			}else{
$dowanload="<a href='".base_url()."/admin/student_document_upload/".$value->sr_upload."'>Download</a>";

			}
			?>
			
            <tr>
                <td><?=$value->sc_name?></td>
                <td><?=$value->sr_title?></td>
                <td><?=date("d-M-y",strtotime($value->sr_req_date))?></td>
                <td><?=$status?></td>
                <td><?=$response_date?></td>
                <td><?=$value->sr_comments?></td>
               
                <td><?=$dowanload?></td>
            </tr>
			<?php	} ?>  
        </tbody>
       
    </table>



              
            </div>
            </div>
            </div>
            </div>
           
            </div>
            </div>
            </div>
            </div>
          
       
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
	<div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Request Certificate</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

	  <form method="post" action="<?=base_url()?>Academics/postCertificate">
  
  <div class="form-group row">
    <label for="inputPassword3" class="col-sm-2 col-form-label">Purpose</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputPassword3" name="title" placeholder="Purpose">
    </div>
  </div>
 
    <div class="form-group row">
	<label class="col-sm-2 col-form-label" for="inlineFormCustomSelect">Certificate</label>
      <div class="col-sm-10">
	  <select class="form-control" name="certificate" required id="inlineFormCustomSelect">
        <option value="">Choose...</option>
		<?php foreach ($certificate as $key => $value) { ?>
			
        <option value="<?=$value->cs_id?>"><?=$value->sc_name?></option>

		<?php	}  ?>
       
      </select>
      </div>
    </div>

   <div class="form-group row">
    <div class="col-sm-10">
      <button type="submit" class="btn btn-primary">Request</button>
    </div>
  </div>
</form>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>
