
<div class="contanier"> 
<div class="card">
<div class="card-header"><h2>Add Stop</h2> </div>
<div class="card-body" style="background-image: linear-gradient(white, grey);">
<div class="col-lg-12"> 
                 

                        <form role="form" method="post" action="<?=base_url().'transportlogin/addStop'?>">
                            
                            <div class="row">
                            <div class="col-lg-3">   
                            <div class="form-group">
                              <input class="form-control" placeholder="Stop Name" name="LOCATION_NAME">
                            </div>
                            </div>
							<div class="col-lg-3"> 
                            <div class="form-group">
							<select class="form-control" name="ROUTE_ID">
							   <option value="">Select Route</option>
							  <?php foreach($list_route as $listrou){?>
							  <option value="<?=$listrou->id?>"><?=$listrou->ROUTE_ID?></option>
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