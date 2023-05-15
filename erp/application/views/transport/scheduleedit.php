
<div class="contanier">
<div class="card">
<div class="card-header"><h2>Edit Records</h2> </div>

             <div class="card-body" style="background-image: linear-gradient(white, grey);">
                      <div class="col-lg-12">

                        <form role="form" method="post" action="">
							<div class="row">
							<div class="col-lg-3">
							<div class="form-group">
							<label>SCHEDULE ID</label>
                                <input class="form-control" placeholder="SCHEDULE ID" name="SCHEDULE_ID" value="<?php echo $zz; ?>" readonly>
                                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                            </div>
                            </div>
							<div class="col-lg-3">
                            <div class="form-group">
							<label>Arrival Time</label>
                              <input type="time" class="form-control" placeholder="Arrival" name="ARRIVAL" value="<?php echo $i; ?>">
                            </div>
                            </div>
							<div class="col-lg-3">
                            <div class="form-group">
							<label>Departure Time</label>
                              <input type="time" class="form-control" placeholder="Departure" name="DEPARTURE" value="<?php echo $a; ?>">
                            </div> 
                            </div> 
							<div class="col-lg-3">
                            <div class="form-group">
							<label>BUS</label>
							<select class="form-control" name="BUS_ID">
							  <option value="">Select Bus</option>
							  <?php foreach($list_bus as $listbus){?>
							  <option value="<?=$listbus->id?>" <?php if($listbus->id==$b){echo 'selected';}?>><?=$listbus->BUS_ID?></option>
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