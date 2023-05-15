<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    <br/>
<br/>
    <form method="post" action="<?=base_url()?>Admin/viewQuesionBank"> <div class="row">
       
	<div class="col-lg-4">	<label>Select the Department</label></div>
        <div class="col-md-4">
<div class="input-group input-group-lg">
<select class="form-control" required id="sel1" name="sellist1">
      <option value="">Select Department</option>
      <option value="MSW">MSW</option>
      <option value="MAHRM">MAHRM and MAHROD</option>
      <option  value="MADM">MADM</option>
      <option  value="MASE">MASE</option>
      <option  value="MSCCF">MSC PSY</option>
    </select>
</div>
</div>
<div class="col-lg-4">
<div class="input-group input-group-lg">
<input type="submit" class="btn btn-primary" name="Submit" value="Submit">
</div>
</div>

</div>
</form>
    
<br/>
<br/>
      <!--Start Dashboard Content-->
	 

      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Online Question</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sno </th>
                        <th>Qno </th>
                        <th>Question</th>
                    
                        <th>Answer 1</th>
                        <th>Answer 2</th>
                        <th>Answer 3</th>
                        <th>Answer 4</th>
                        <th>Answer Option</th>
                        <th>Action</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php 
                    
                    $i=1;
                    foreach ($applicationactive as $key => $value) { ?>
                  
                      <tr>
                        <th><?=$i?> </th>
                        <th><?=$value->q_id?></th>
                        <th><?=$value->question?></th>
                        <th><?=$value->answer_1?></th>
                        <th><?=$value->answer_2?></th>
                        <th><?=$value->answer_3?></th>
                        <th><?=$value->answer_4?></th>
                        <th><?=$value->option_ans?></th>
                    
                       
                        <th>  <a href="<?=site_url()?>/Admin/deleteQuestion/<?=$value->q_id?>" class="btn btn-danger" ><i class="fa fa-trash-o" aria-hidden="true"></i></a></th>
                       
                       
                 
                    </tr>
                    <?php 
                $i++;
                
                
                } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                        <th>Sno </th>
                        <th>Qno </th>
                        <th>Question</th>
                    
                        <th>Answer 1</th>
                        <th>Answer 2</th>
                        <th>Answer 3</th>
                        <th>Answer 4</th>
                        <th>Answer Option</th>
                        <th>Action</th>
                       
                       
                    </tr>
                </tfoot>
            </table>

     
            </div>
            </div>
          </div>
        </div>
      </div><!-- End Row-->






    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
   