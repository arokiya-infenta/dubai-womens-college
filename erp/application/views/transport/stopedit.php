
<div class="contanier">
<div class="card">
<div class="card-header"><h2>Edit Records</h2> </div>


             <div class="card-body" style="background-image: linear-gradient(white, grey);">
                      <div class="col-lg-12"> 

                        <form role="form" method="post" action="">
                            <div class="row">
							<div class="col-lg-3"> 
                            <div class="form-group">
                              <input class="form-control" placeholder="Location Name" name="LOCATION_NAME" value="<?php echo $i; ?>">
                                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                            </div>
                            </div>
							<div class="col-lg-3"> 
                            <div class="form-group">
							<select class="form-control" name="ROUTE_ID">
							  <option value="">Select Route</option>
							  <?php foreach($list_route as $listrou){?>
							  <option value="<?=$listrou->id?>" <?php if($listrou->id==$a){echo 'selected';}?>><?=$listrou->ROUTE_ID?></option>
							  <?php } ?>
							  </select>
                            </div>
                            </div>
                            </div>

                         
                            <button type="submit" class="btn btn-success" name="submit">Update Record</button>
                              <br></br>
                         


                      </form>  
                    </div>
                </div>
                
            </div>
            <!-- /.container-fluid -->

        </div>
        