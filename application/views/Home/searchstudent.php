
<!-- end section -->
<!-- section -->
<div class="section layout_padding padding_bottom-0">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="full">
                  
                  </div>
            </div>
          </div>
       </div>
    </div>
<!-- end section -->
<!-- section -->
<div class="section contact_section" style="background:#12385b; padding: 150px 0px;">
    <div class="container">
           <div class="">


<form class="well form-horizontal" action="<?=base_url()?>/StudentPreview/viewStudent" method="post"  id="contact_form">
<fieldset>
<?=$this->session->flashdata('message');?>
   <h2 style="text-align:center;"><span>Search</span></h2>
<!-- Form Name -->

<!-- Text input-->

<div class="form-group">
<label class="control-label"></label>  
<div class="inputGroupContainer">
<div class="full field">
<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
<input  name="first_name" required id="firstname" placeholder="Reference Number" class="form-control"  type="number">
</div>
</div>
</div>

<!-- Text input-->




<!-- Text input-->

<!--<div class="form-group">
<label class="col-md-4 control-label"></label>  
<div class="col-md-4 inputGroupContainer">
<div class="full field">
<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
<input  name="user_name" placeholder="Username" class="form-control"  type="text">
</div>
</div>
</div>-->

<!-- Text input-->


<!-- Text input-->


<!-- Select Basic -->

<!-- Success message -->
<!--<div class="alert alert-success" role="alert" id="success_message">Success <i class="glyphicon glyphicon-thumbs-up"></i> Success!.</div>
-->
<!-- Button -->
<div class="form-group">
<label class="control-label"></label>
<div class=""><br>

<button type="submit"  class="btn btn-warning" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Search Student <span class="glyphicon glyphicon-send"></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</button>

</div>
</div>

</fieldset>
</form>

</div><!-- /.container -->
        
        
        </div>            

           </div>			  
       </div>
    </div>
<!-- end section -->
<style>

</style>
