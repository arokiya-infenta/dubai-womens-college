<div class="clearfix"></div>
	
    <div class="content-wrapper">
      <div class="container-fluid">
                   <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <form method="post" action="<?=base_url()?>PgMswAided/personalMailUser">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Send Personal Email : <?=$email[0]->u_email_id?></h5>
      
      </div>
      <div class="modal-body">
      <input type ="hidden" name="student_id" value="<?=$email[0]->u_id?>">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Email Subject</label>
            <input type="text" class="form-control" name="email_subject" required id="recipient-name">
          </div>
          <div class="form-group">
       
  <label class="col-form-label " required for="recipient-name">Email Content </label>
  <div class="col-md-12">
 <textarea  class="form-control" required name="email_content"></textarea>
   
  </div>
  </div>

      </div>
      <div class="modal-footer">
     
        <button type="submit" class="btn btn-primary">Send Email</button>
        
      </div>
      </form>
    </div>
  </div>
</div>
</div>
