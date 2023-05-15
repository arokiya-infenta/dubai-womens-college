<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



      <div class="row">
        <div class="col-lg-12">
          <div class="card">
		  <div class="card-header"><i class="fa fa-file-text"></i>Digital Board</div>
            <div class="card-body">
            <?php if(!empty($this->session->flashdata('message'))){

echo $this->session->flashdata('message');

            } ?>

            <div class="row">
        <div class="col-lg-12">
           <div class="card">
              <div class="card-body"> 
                <ul class="nav nav-tabs nav-tabs-primary">
                  <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#tabe-1"><i class="fa fa-comments"></i> <span class="hidden-xs">Announcements</span></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tabe-4"><i class="fa fa-file-image-o"></i> <span class="hidden-xs">Events</span></a>
                  </li>
                  
                  
                  
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tabe-2"><i class="fa fa-file-image-o"></i> <span class="hidden-xs">Gallery</span></a>
                  </li>
                 
                  <li class="nav-item ">
                    <a class="nav-link " data-toggle="tab"  href="#tabe-3"><i class="fa fa-file-video-o"></i> <span class="hidden-xs">Video</span></a>
                   
                  </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                  <div id="tabe-1" class="container tab-pane active">


                  <form method ="post" action="<?=base_url()?>Admin/announcementAdd">
                  <div class="row">
  <div class="col-12 col-md-10"><textarea class="form-control" required name="announcement" id="summernoteEditor"></textarea></div>
  <div class="col-6 col-md-2"><input type="submit" class="btn btn-primary btn_align"  name="post" value="Post"></div>
</div>   
        
</form>    


<div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th >Content</th>
                        <th >Action</th>
                    
                    </tr>
                </thead>
                <tbody>

               <?php foreach ($announcements as $key => $value) { ?>
                
         
                    <tr>
                        <td style="width:80%"><?=$value->content?></td>
                        <td style="width:20%"> 
                        <input type="checkbox" <?php if($value->status == 1){echo"checked";}  ?>  class="anun js-switch" data-color="#008cff"/> &nbsp;&nbsp;
                        <button type="button"  value="<?=$value->an_id?>"  class="del_anun btn btn-danger" value="" >X</button>
                      </td>
               
                    </tr>
                    <?php   }   ?>
                    
                </tbody>
                <tfoot>
                    <tr>
                        <th>Content</th>
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



        <div id="tabe-4" class="container tab-pane fade">


<form method ="post" action="<?=base_url()?>Admin/notificationAdd">

<div class="row">
<div class = " col-md-4"><label>Title </label></div>
<div class = " col-md-8"><input type="text" required name="title" class="form-control"></div>
</div> <div class="row">
<div class = " col-md-4"><label>Start Date </label></div>
<div class = " col-md-8"><input type="date" required name="startdate" class="form-control"></div>
</div>  <div class="row">
<div class = " col-md-4"><label>End Date </label></div>
<div class = " col-md-8"><input type="date" required name="enddate" class="form-control"></div>
</div>   <div class="row">
<div class = " col-md-4"><label>Start Time </label></div>
<div class = " col-md-8"><input type="time" required name="starttime" class="form-control"></div>
</div>  
<div class="row">
<div class = " col-md-4"><label>End Time </label></div>
<div class = " col-md-8"><input type="time" required name="endtime" class="form-control"></div>
</div> 
<div class="row">
<div class = " col-md-4"><label>Discription </label></div>
<div class = " col-md-8"><textarea class="form-control" required name="discription" id="summernoteNotif"></textarea></div>
</div> <div class="row">
<div class = " col-md-10"><label> </label></div>
<div class = " col-md-2"><input type="submit" class="btn btn-primary"  name="post" value="Post"></div>
</div> 

</form>    


<div class="row">
<div class="col-lg-12">
<div class="card">
<div class="card-header"></div>
<div class="card-body">
<div class="table-responsive">
<table id="default-datatable-event" class="table table-bordered">
<thead>
  <tr>
      <th >Content</th>
      <th >Action</th>
  
  </tr>
</thead>
<tbody>
<?php foreach ($notification as $key => $value) { ?>
                
         
                <tr>
                    <td style="width:80%"><?=$value->title?></td>
                    <td style="width:20%"> 
                 
                    <label class="switch">
  <input id="<?=$value->db_n_id?>" <?php if($value->status == 1){echo"checked";}  ?>  type="checkbox" class ="noti" >
  <span  class="slider round"></span>
  </label>
  <button type="button"  value="<?=$value->db_n_id?>"  class="del_not btn btn-danger" value="" >X</button>
 


                    
                  </td>
           
                </tr>
                <?php   }   ?>

</tbody>
<tfoot>
  <tr>
      <th>Content</th>
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


                  <div id="tabe-2" class="container tab-pane fade">
                    
<?php echo $error; ?>
                  <form method ="post" action="<?=base_url()?>Admin/digitalImageAdd" enctype="multipart/form-data">
                  <div class="row">
  <div class="col-12 col-md-10"><input type="file" required name="userfile" class="form-control" />(1260 PX * 500 PX)</div>
  <div class="col-6 col-md-2"><input type="submit" class="btn btn-primary"  name="post" value="Post"></div>
</div>   
        
</form>    


<div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable-image" class="table table-bordered">
                <thead>
                    <tr>
                        <th >Image </th>
                        <th >Action</th>
                    
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($gallery as $key => $value) { ?>
                
         
                <tr>
                    <td style="width:80%"><img style="height: 100px; width: 100px;" src="<?=base_url()?>digitalBanner/<?=$value->image_name?>" ></td>
                    <td style="width:20%"> 
                 
                    <label class="switch">
  <input id="<?=$value->i_id?>" <?php if($value->image_status == 1){echo"checked";}  ?>  type="checkbox" class ="image" >
  <span  class="slider round"></span>
  </label>
  <button type="button"  value="<?=$value->i_id?>"  class="del_image btn btn-danger" value="" >X</button>
 


                    
                  </td>
           
                </tr>
                <?php   }   ?>

                  
                </tbody>
                <tfoot>
                    <tr>
                        <th>Image </th>
                        <th>Action</th>
                   
                    </tr>
                </tfoot>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>
                  </div>
                  <div id="tabe-3" class="container tab-pane fade">
  <form method ="post" action="<?=base_url()?>Admin/videoAdd"  enctype="multipart/form-data">
                 
 <div class="row">
<div class = " col-md-4"><label>Title </label></div>
<div class = " col-md-8"><input type="text" name="title" class="form-control"></div>
</div>
   


<div class="row">
<div class = " col-md-4"><label>Video Upload </label></div>
<div class = " col-md-4"><input type="file" required name="image" class="form-control" /></div>
<div class = " col-md-4"><input style="position: absolute;right: 25px;" type="submit" class="btn btn-primary"  name="post" value="Upload"></div>
</div>



    <!--              <div class="row">
  <div class="col-12 col-md-10"><input type="file" name="image" class="form-control" /></div>
  <div class="col-6 col-md-2"><input type="submit" class="btn btn-primary"  name="post" value="Upload"></div>
</div>   -->
        
</form>    


<div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable-Video" class="table table-bordered">
                <thead>
                    <tr>
                        <th >Video Title </th>
                        <th >Action</th>
                    
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($videos as $key => $value) { ?>
                
         
                <tr>
                    <td style="width:80%"><?=$value->v_text?></td>
                    <td style="width:20%"> 
                 
                    <label class="switch">
  <input id="<?=$value->v_id?>" <?php if($value->status == 1){echo"checked";}  ?>  type="checkbox" class ="video" >
  <span  class="slider round"></span>
  </label>
  <button type="button"  value="<?=$value->v_id?>"  class="del_video btn btn-danger" value="" >X</button>
 


                    
                  </td>
           
                </tr>
                <?php   }   ?>
                  
                </tbody>
                <tfoot>
                    <tr>
                        <th>Video Title </th>
                        <th>Action</th>
                   
                    </tr>
                </tfoot>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>


                  </div>
                </div>
              </div>
           </div>

        </div>
       





            </div>
          </div>
        </div>
      </div>
			

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
   <style>
#paste
{width:100%; height:200px; padding:0px;}
.row {
    padding-top: 10px;
}
.btn_align{
position: absolute;
    right: 0;
    bottom: 27px;

}

.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #9ba09f;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: green;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
   </style>
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
  
    