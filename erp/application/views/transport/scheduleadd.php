
<div class="contanier">
<div class="card">
<div class="card-header"><h2>Add Schedule Record</h2> </div>
<div class="card-body" style="background-image: linear-gradient(white, grey);">


                        <form role="form" method="post" action="<?=base_url().'transportlogin/addSchedule'?>">
                            <div class="row">
                            <div class="col-lg-3">
                            <div class="form-group">
							<label>SCHEDULE ID</label>
                              <input class="form-control" placeholder="Schedule ID" name="SCHEDULE_ID" value="<?php echo $SCHEDULE_ID; ?>" readonly>
                            </div>
                            </div>
							<div class="col-lg-3">
                            <div class="form-group">
							<label>Arrival Time</label>
                              <input type="time" class="form-control" placeholder="Arrival" name="ARRIVAL">
                            </div>
                            </div>
							<div class="col-lg-3">
                            <div class="form-group">
							<label>Departure Time</label>
                              <input type="time" class="form-control" placeholder="Departure" name="DEPARTURE">
                            </div> 
                            </div> 
							<div class="col-lg-3">
                            <div class="form-group">
							<label>BUS</label>
							<select class="form-control" name="BUS_ID">
							   <option value="">Select Bus</option>
							  <?php foreach($list_bus as $listbus){?>
							  <option value="<?=$listbus->id?>"><?=$listbus->BUS_ID?></option>
							  <?php } ?>
							  </select>
                            </div>
                            </div>
                            </div>
                           
                            <button type="submit" class="btn btn-success" name="submit">Save Record</button>
                            <button type="reset" class="btn btn-default">Clear Entry</button>


                      </form>  
                    </div>
                </div>

        </div>
        <!-- /.container-fluid -->
