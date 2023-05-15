<div class="contanier">
<div class="card card-register mx-auto mt-5">

             <div class="card-body" style="background-image: linear-gradient(white, grey);">
                      <div class="col-lg-6">

                        <form role="form" method="post" action="">
                            <div class="form-group">
                                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="ROUTE ID" name="ROUTE_ID" value="<?php echo $zz; ?>" readonly/>
                            </div>
                            <div class="form-group">
                              <input class="form-control" placeholder="Fair" name="FAIR" value="<?php echo $i; ?>">
                            </div>
                             <div class="form-group">
                              <input class="form-control" placeholder="Start" name="START" value="<?php echo $a; ?>">
                            </div>
                             <div class="form-group">
                              <input class="form-control" placeholder="Finish" name="FINISH" value="<?php echo $b; ?>">
                            </div>
                             
                            <button type="submit" class="btn btn-success" name="submit">Update Record</button>
                         


                      </form>  
                    </div>
                </div>
                
            </div>
            <!-- /.container-fluid -->

        </div>