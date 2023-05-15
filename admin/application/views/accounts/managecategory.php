<style>
label.gst_la, label.inst {
            float: left;
        }	
          
 span.gst, span.insta {
            display: block;
            overflow: hidden;
            padding: 0px 4px 0px 20px;
			margin-top: -11px;
        }
 span.instd {
            display: block;
            overflow: hidden;
            padding: 0px 4px 0px -1px;
			margin-top: -11px;
        }		
</style>		
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



     <!-- Start Row-->
        <div class="row">
					 <div class="col-md-2 "></div>
					 <div class="col-md-8 ">
					  <?php if(!empty($this->session->flashdata('message'))){

echo $this->session->flashdata('message');

            } ?>
					 </div>
					 <div class="col-md-2 "></div>
					</div>	
			
	 <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-file-text"></i> Manage Category 
        
        
            <button  style="float: right;" class="btn btn-success" data-toggle="modal" data-target="#exampleModalAdd">Add</button>
       
       
            <div class="modal fade" id="exampleModalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   <form method="post" action="<?=base_url()?>Accounts/addCategory">

                   <div class="row">
			<div class="col-md-4">
			<label>Category Name</label>
			</div><div class="col-md-8">
			<input type="text" class="form-control" placeholder="Enter Fees Type" name="name">
			</div>
			</div> 
            <br>
<br>  
            <div class="row">
			<div class="col-md-4">
		
			</div><div class="col-md-8">
            <button style="float: right;" type="submit" class="btn btn-primary">Save</button>
			</div>
			</div>


                   </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                 
                </div>
                </div>
            </div>
            </div>
       
       
       
       
       
        </div>
            <div class="card-body">
			
            <table id="example_fees" class="table table-striped table-bordered text-center">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Category</th>
                <th>Action</th>
               
            </tr>
        </thead>
        <tbody>
            <?php 
            
            $i=1;
            foreach ($category as $key => $value) { ?>
            <tr>
            <td><?=$i?></td>
            <td><?=$value->ac_name?></td>
            <td><button  class="btn btn-primary"  data-toggle="modal" data-target="#exampleModal<?=$value->ac_id?>">Edit</button></td>
        </tr>

        <div class="modal fade" id="exampleModal<?=$value->ac_id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   <form method="post" action="<?=base_url()?>Accounts/editCategory">
<input type="hidden" name="id" value="<?=$value->ac_id?>">
                   <div class="row">
			<div class="col-md-4">
			<label>Category Name</label>
			</div><div class="col-md-8">
			<input type="text" class="form-control" placeholder="Enter Fees Type" name="name" value="<?=$value->ac_name?>">
			</div>
			</div>
<br>
<br>
            <div class="row">
			<div class="col-md-4">
		
			</div><div class="col-md-8">
            <button style="float: right;" type="submit" class="btn btn-primary">Update</button>
			</div>
			</div>

                   </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                 
                </div>
                </div>
            </div>
            </div>
       
        

        <?php     $i++;
            } ?>    
        </tbody>
        <tfoot>
        <tr>
                <th>Sno</th>
                <th>Category</th>
                <th>Action</th>
               
            </tr>
        </tfoot>
    </table>

            </div>
          
          </div>
        </div>
      </div>
	  

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
	<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
	<script>
     

 </script>
