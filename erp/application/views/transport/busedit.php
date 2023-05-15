

<div class="contanier">
<div class="card">
<div class="card-header"><h2>Edit Records</h2> </div>

             <div class="card-body" style="background-image: linear-gradient(white, grey);">
                      <div class="col-lg-12"> 

                        <form role="form" method="post" action="">
						<div class="row">
                            <div class="col-lg-3">
                            <div class="form-group">
                              <input class="form-control" placeholder="Bus ID" name="BUS_ID" value="<?php echo $zz; ?>" readonly>
                                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                            </div>
                            </div>
                            <div class="col-lg-3">
                            <div class="form-group">
                              <input class="form-control" placeholder="Bus Name" name="BUS_NAME" value="<?php echo $i; ?>">
                            </div>
                            </div>
                            <div class="col-lg-3">
                            <div class="form-group">
                              <input class="form-control" placeholder="Bus Type" name="BUS_TYPE" value="<?php echo $a; ?>">
                            </div>
                            </div>
                            <div class="col-lg-3">
                              <div class="form-group">
							  <select class="form-control" name="DRIVER_ID">
							  <option value="">Select Driver</option>
							  <?php foreach($list_driver as $listdri){?>
							  <option value="<?=$listdri->id?>" <?php if($listdri->id==$b){echo 'selected';}?>><?=$listdri->DRIVER_NAME?></option>
							  <?php } ?>
							  </select>
							</div>  
							</div>  
							</div>  

                            <button type="submit" class="btn btn-success" name="submit">Update Record</button>
                         


                      </form>  
                    </div>
                </div>
                
            </div>
            <!-- /.container-fluid -->

        </div>