
<div class="contanier"> 
<div class="card">
<div class="card-header"><h2>Add new Record</h2> </div>
<div class="card-body" style="background-image: linear-gradient(white, grey);">
                 

                        <form role="form" method="post" action="<?=base_url().'transportlogin/addBus'?>">
                            <div class="row">
                            <div class="col-lg-3">
                            <div class="form-group">
                            <input class="form-control" placeholder="BUS ID" name="BUS_ID" value="<?=$BUS_ID?>" readonly>
                            </div>
                            </div>
							<div class="col-lg-3">
                            <div class="form-group">
                            <input class="form-control" placeholder="BUS Name" name="BUS_NAME">
                            </div>
                            </div>
							<div class="col-lg-3">
                            <div class="form-group">
                              <input class="form-control" placeholder="BUS Type" name="BUS_TYPE">
                            </div> 
                            </div>
                            <div class="col-lg-3">							
                            <div class="form-group">
							  <select class="form-control" name="DRIVER_ID">
							   <option value="">Select Driver</option>
							  <?php foreach($list_driver as $listdri){?>
							  <option value="<?=$listdri->id?>"><?=$listdri->DRIVER_NAME?></option>
							  <?php } ?>
							  </select>
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