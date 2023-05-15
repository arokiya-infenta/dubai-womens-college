
<div class="contanier"> 

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
<div class="card">
<div class="card-header"><h2>Add new Record</h2> </div>
<div class="card-body" style="background-image: linear-gradient(white, grey);">
                 

                        <form role="form" method="post" action="<?=base_url().'transportlogin/addDriver'?>" enctype="multipart/form-data">
                            
                            <div class="row">
                             <div class="col-lg-3">
                              <div class="form-group">
							  <label>DRIVER ID</label>
                              <input class="form-control" placeholder="Driver ID" name="DRIVER_ID" value="<?=$DRIVER_ID?>" readonly>
                              </div>  
                             </div>
                             <div class="col-lg-3">							
                              <div class="form-group">
							  <label>Name</label>
                              <input class="form-control" placeholder="Driver Name" name="DRIVER_NAME">
                              </div>
							 </div>
                             <div class="col-lg-3">							
                              <div class="form-group">
							  <label>Mobile</label>
                              <input type="text" class="form-control" name="MOBILE">
                              </div>
							 </div>
                             <div class="col-lg-3">							
                              <div class="form-group">
							  <label>Email</label>
                              <input type="text" class="form-control" name="EMAIL">
                              </div>
							 </div>
							</div>
							<div class="row">
							 <div class="col-lg-3">
                              <div class="form-group">
							  <label>Date of Birth</label>
                              <input type="text" class="form-control datepicker" placeholder="mm/dd/YYYY" name="DOB" autocomplete="off">
                              </div>
                             </div>
							 <div class="col-lg-3">
                              <div class="form-group">
							  <label>Date of Joining</label>
                              <input type="text" class="form-control datepicker" placeholder="mm/dd/YYYY" name="EMPLOY_DATE" autocomplete="off">
                              </div>
                             </div>
                             <div class="col-lg-3">
                              <div class="form-group">
							  <label>Profile</label>
                              <input type="file" class="form-control" name="PROFILE">
                              </div>  
                             </div>
                             <div class="col-lg-3">							
                              <div class="form-group">
							  <label>Address Proof</label>
                              <input type="file" class="form-control" name="ADD_PROOF">
                              </div>
							 </div>
                            </div>
							<div class="row">
                             <div class="col-lg-3">							
                              <div class="form-group">
							  <label>License</label>
                              <input type="file" class="form-control" name="LICENSE">
                              </div>
							 </div>
							 <div class="col-lg-3">
                              <div class="form-group">
							  <label>City</label>
                              <input type="text" class="form-control" placeholder="CITY" name="CITY">
                              </div>
                             </div>
							 <div class="col-lg-3">
                              <div class="form-group">
							  <label>State</label>
                              <input type="text" class="form-control" placeholder="STATE" name="STATE">
                              </div>
                             </div>
                             <div class="col-lg-3">
                              <div class="form-group">
							  <label>Country</label>
                              <input type="text" class="form-control" placeholder="COUNTRY" name="COUNTRY">
                              </div>  
                             </div>
                            </div>
							<div class="row">
                             <div class="col-lg-12">							
                              <div class="form-group">
							  <label>Address</label>
                              <textarea class="form-control" name="ADDRESS"></textarea>
                              </div>  
                             </div>
                            </div>
                           
                            <button type="submit" class="btn btn-success" name="submit"> <h6> Save Record </h6> </button>
                            <button type="reset" class="btn btn-default"> <h6> Clear Entry </h6> </button>


                      </form>  
                </div>

        </div>
        </div>
        <!-- /.container-fluid -->