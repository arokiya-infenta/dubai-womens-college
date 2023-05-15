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
        
        .material-switch > input[type="checkbox"] {
    display: none;   
}


.toggle-switch {
    position: relative;
    background: #fff;
    width: 65px;
    height: 30px;
    line-height: 30px;
    border-radius: 40px;
    border: 1px solid #767272;
    display: inline-block;
    cursor: pointer;
    overflow: hidden;
}
.toggle-switch input[type="checkbox"] {
    position: absolute;
    width: 100%;
    height: 100%;
    left: 0;
    top: 0;
    opacity: 0;
    z-index: 1;
    cursor: pointer;
}
.toggle-switch span.circle {
    display: inline-block;
    margin: 0 !important;
    width: 22px;
    height: 22px;
    background: #ddd;
    border: 1px solid #ddd;
    border-radius: 40px;
    transition: 0.1s linear;
    position: absolute;
    top: 50%;
    left: 3px;
    transform: translateY(-50%);
}
.toggle-switch span.circle::after {
    content: "OFF";
    position: absolute;
    left: 27px;
    top: -4px;
    font-weight: 500;
    font-size: 12px;
    color: #ddd;
}
.toggle-switch input[type="checkbox"]:checked + span.circle {
    transform: translate(34px, -50%);
    background: #333;
    border: 1px solid #333;
}
.toggle-switch input[type="checkbox"]:checked + span.circle::before {
    content: "ON";
    position: absolute;
    right: 30px;
    top: -4px;
    font-weight: 500;
    font-size: 12px;
    color: #333;
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
            <div class="card-header"><i class="fa fa-file-text"></i> Fees Manage 
        
        
            <a href="<?=base_url()?>Accounts/acadamicfees" style="float: right;" class="btn btn-success" role="button" aria-pressed="true">Add</a>
        </div>
            <div class="card-body">
			
            <table id="example_fees" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Department</th>
                <th>Year</th>
                <th>Batch</th>
                <th>Fees Name</th>
                <th>Amount</th>
                <th>Gst</th>
                <th>Start date</th>
                <th>End date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

        <?php foreach ($fees as $key => $value) {
            # code...
       ?>
            <tr>
                <td><?=$value->short_name?></td>
                <td><?php if($value->year==1){
                    echo"First Year";
                }else if($value->year==2){
                    echo"Second Year"; 
                }else if($value->year==3){

                    echo"Third Year";   
                }else{
                    echo"None"; 
                }
                
                
                
                ?></td>
                  <td><?=$value->batch?></td>
                <td><?=$value->f_name?></td>
              
                <td><?=$value->f_total?></td>
                <td><?php  
                
                if($value->f_gst==1){
                    echo"With GST";
                }else{
                    echo"With Out GSt"; 
                }
                
                
                ?></td>
                <td><?=date("d-M-Y",strtotime($value->f_s_date));?></td>
                <td><?=date("d-M-Y",strtotime($value->f_e_date))?></td>
                <td> 
                    
                <a href="<?=base_url()?>Accounts/EditMaster/<?=$value->f_id?>" class="btn btn-primary  btn-sm" role="button" aria-pressed="true">Edit</a>
              <!--  <button value="<?=$value->f_id?>" class="delete_fees_master btn btn-danger" role="button" aria-pressed="true">Delete</button>-->
          	<span class="toggle-switch">
            <input type="checkbox" class="onoff" value="<?=$value->f_id?>" <?php if($value->f_status == 1){echo"checked";}   ?> />
            <span class="circle"></span>
        </span>
                </td>
            </tr>

        <?php  }  ?>    
          
        </tbody>
        <tfoot>
        <tr>
                <th>Department</th>
                <th>Year</th>
                <th>Batch</th>
                <th>Fees Name</th>
                <th>Amount</th>
                <th>Gst</th>
                <th>Start date</th>
                <th>End date</th>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function(){

var base_url = "<?= base_url();?>";


  $(".onoff").click(function(){
   // alert($(this).val());


    $.ajax({
                url: base_url + "accounts/onOffPayment",
                type: 'POST',
                cache: false,
                data: {
                    p_id: $(this).val(),
                },
                success: function (data) {
					location.reload();
                }
            });


  });
});
</script>