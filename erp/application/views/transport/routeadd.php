
<div class="contanier">
<div class="card">
<div class="card-header"> <h2>Add New Record</h2> </div>
<div class="card-body" style="background-image: linear-gradient(white, grey);">


                        <form role="form" method="post" action="<?=base_url().'transportlogin/addRoute'?>">
                        
						    <div class="row">
						    <div class="col-lg-3">
                            <div class="form-group">
                              <input class="form-control" placeholder="Route ID" name="ROUTE_ID" value="<?=$ROUTE_ID?>" readonly>
                            </div> 
                            </div> 
							<div class="col-lg-3">
                            <div class="form-group">
                              <input class="form-control" placeholder="Fair/month" name="FAIR">
                            </div> 
                            </div> 
							<div class="col-lg-3">
                            <div class="form-group">
                              <input class="form-control" placeholder="Start Location" name="START">
                            </div> 
                            </div> 
							<div class="col-lg-3">
                            <div class="form-group">
                              <input class="form-control" placeholder="Finish Location" name="FINISH">
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

