<div class="container-fluid">
<div class="row admsn_rw">

    <div class="admisn">
	<div class="row  w-100">
				
					 <div class="col-md-12 ">
					  <?=$this->session->flashdata('message');?>
					  <?php unset($_SESSION['message']); ?>
					 </div>
					
					 </div>



					 <div class="row w-100">
					 
<div class="col-md-12">

    <p class="admsn_ttl">Enquiry</p>
<p class="admsn_ttl1"></p>
<form class="form-horizontal" method="post" action="<?=base_url()?>Welcome/saveEnquirey">
<fieldset>

<!-- Form Name -->


<!-- Text input-->
<div class="form-group row">
  <label class="col-md-6 control-label" for="textinput">Name</label>  
  <div class="col-md-6">
  <input id="textinput" name="name" type="text" placeholder="Name" class="form-control input-md" required="">

  </div>
</div>

<!-- Text input-->
<div class="form-group row">
  <label class="col-md-6 control-label" for="mobile">Mobile No</label>  
  <div class="col-md-6">
  <input id="mobile" name="mobile" type="text" placeholder="Mobile No" class="form-control input-md" required="">
    
  </div>
</div>
<div class="form-group row">
  <label class="col-md-6 control-label" for="email">E mail Id</label>  
  <div class="col-md-6">
  <input id="email" name="email" type="text" placeholder="E mail id" class="form-control input-md" required="">
  
  </div>
</div>
<!-- Text input-->
<div class="form-group row">
  <label class="col-md-6 control-label" for="title">Title</label>  
  <div class="col-md-6">
  <input id="title" name="title" type="text" placeholder="Title" class="form-control input-md" required="">
 
  </div>
</div>

<!-- Textarea -->
<div class="form-group row">
  <label class="col-md-6 control-label" for="description">Description</label>
  <div class="col-md-6">                     
    <textarea class="form-control" id="description" required="" name="description"></textarea>
  </div>
</div><div class="form-group row">
  <label class="col-md-6 control-label" for="description">Upload</label>
  <div class="col-md-6">                     
  <input type="file" class="form-control upld-file" name="ppimage">
  </div>
</div>

<div class="form-group row">
  <label class="col-md-6 control-label" for="description"></label>
  <div class="col-md-6">                     
    <button class="btn btn-primary" id="submit_enq" style="float: inline-end;" name="submit">Send</button>
  </div>
</div>

</fieldset>
</form>
  
 
    </div>
    </div>
    <!-- .pogoSlider -->
</div>
</div>
</div>



<style>

p.reg_btn {
text-align: center;
margin-top: 30px;
}
p.reg_btn a {
background: #2f2483;
padding: 10px 20px;
border-radius: 5px;
color: #fff;
}
p.reg_btn a:hover {
background: #6358ba;
}
p.tck {
text-align: center;
color: #fd0000;
margin-top: 20px;
}
label{
content: '\f00c';
font-family: fontawesome;
/*padding-right: 10px;*/
font-weight: bold;
font-size: 21px;
}
ul.admsn_lis {
background: #f1f1f1;
padding: 20px 70px 20px 50px;
border-radius: 5px;
font-size: 21px;
}
p.admsn_ttl1 {
color: #2f2483;
text-align: center;
font-size: 20px;
font-weight: 600;
font-size: 24px;
}
p.admsn_cn {
font-weight: 500;
color: #222;
font-size: 24px;
/* text-align: center; */
}
ul.admsn_lis li {
position: relative;
left: 20px;
line-height: 30px;
color: #222;
text-align: justify;
}
ul.admsn_lis li:before {
content: '\f0a9';
font-family: fontawesome;
position: absolute;
color: #2f2483;
left: -20px;
}
p.admsn_ttl {
text-align: center;
font-size: 30px;
background: #2f2483;
padding: 10px;
color: #fff;
font-weight: 600;
}
.admisn {
margin-left: 200px;
margin-right: 200px;
box-shadow: 0px 0px 3px 0px #939393;
padding: 40px 70px;
border-radius: 3px;
width: 60%;
display: flex;
justify-content: center;
}
.admsn_rw {
margin-top: 150px;
margin-bottom: 100px;
display: flex;
justify-content: center;

}
.top-header {
position: absolute;
top: 0px;
left: 0px;
z-index: 20;
background-position: left;
background-repeat: no-repeat;
background-color: #2f2483;
background-size: auto 100%;
width: 90%;
margin: 0 5%;
}
a {
color: #2f2483;
}
</style>
