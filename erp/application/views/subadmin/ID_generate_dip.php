<?php $program = isset($program) ? $program : '';
$department = isset($department) ? $department : '';
?> 
<!--HTML to image-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<style>
/* Main Classes */
.myinput[type="checkbox"]:before{
    position: relative;
    display: block;
    width: 15px;
    height: 15px;
    border: 1px solid #808080;
    content: "";
   background: #FFF; 
}
.myinput[type="checkbox"]:after{
    position: relative;
    display: block;
    left: 2px;
    top: -11px;
    width: 10px;
    height: 10px;
    border-width: 1px;
    border-style: solid;
    border-color: #B3B3B3 #dcddde #dcddde #B3B3B3;
    content: "";
    background-image: linear-gradient(135deg, #B1B6BE 0%,#FFF 100%);
    background-repeat: no-repeat;
    background-position:center;
}
.myinput[type="checkbox"]:checked:after{
    background-image:  url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAcAAAAHCAQAAABuW59YAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAAB2SURBVHjaAGkAlv8A3QDyAP0A/QD+Dam3W+kCAAD8APYAAgTVZaZCGwwA5wr0AvcA+Dh+7UX/x24AqK3Wg/8nt6w4/5q71wAAVP9g/7rTXf9n/+9N+AAAtpJa/zf/S//DhP8H/wAA4gzWj2P4lsf0JP0A/wADAHB0Ngka6UmKAAAAAElFTkSuQmCC'), linear-gradient(135deg, #B1B6BE 0%,#FFF 100%);
}
.myinput[type="checkbox"]:disabled:after{
    -webkit-filter: opacity(0.4);
}
.myinput[type="checkbox"]:not(:disabled):checked:hover:after{
    background-image:  url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAcAAAAHCAQAAABuW59YAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAAB2SURBVHjaAGkAlv8A3QDyAP0A/QD+Dam3W+kCAAD8APYAAgTVZaZCGwwA5wr0AvcA+Dh+7UX/x24AqK3Wg/8nt6w4/5q71wAAVP9g/7rTXf9n/+9N+AAAtpJa/zf/S//DhP8H/wAA4gzWj2P4lsf0JP0A/wADAHB0Ngka6UmKAAAAAElFTkSuQmCC'), linear-gradient(135deg, #8BB0C2 0%,#FFF 100%);
}
.myinput[type="checkbox"]:not(:disabled):hover:after{
    background-image: linear-gradient(135deg, #8BB0C2 0%,#FFF 100%);  
    border-color: #85A9BB #92C2DA #92C2DA #85A9BB;  
}
.myinput[type="checkbox"]:not(:disabled):hover:before{
    border-color: #3D7591;
}
/* Large checkboxes */
.myinput.large{
    height:25px;
    width: 25px;
}

.myinput.large[type="checkbox"]:before{
    width: 22px;
    height: 22px;
}
.myinput.large[type="checkbox"]:after{
    top: -20px;
    width: 19px;
    height: 19px;
}
</style>
<style>
.id-card-front img {
    width: 88%;
    margin: 0 20px;
}
.id-card-front {
    width: 366px !important;
    height: 540px !important;
    margin: 40px auto;
    padding-top: 28px;
    box-shadow: 0 0 12px 0 #22222230;
    border-radius: 16px;
	background:#fff;
}
.id-card-front h3 {
    text-align: center;
    font-family: 'Roboto', sans-serif;
    letter-spacing: 6px;
    font-size: 24px;
    font-weight: 800;
}
img.stud-img {
    width: 179px;
    margin: 0 80px;
    padding-top: 20px;
}
.id-card-front table tr td:nth-child(1) {
    font-weight: 600;
}
.id-card-front table tr td {
    padding-bottom: 12px;
    color: #101010;
    font-size: 13px;
    line-height: 16px;
    font-weight: 500;
}
.id-card-front table {
    padding-left: 20px;
    font-family: 'Roboto' !important;
    font-size: 15px !important;
	margin-left: 15px;
}

.id-card-front {
    width: 366px !important;
    height: 540px !important;
    margin: 40px auto;
    padding-top: 28px;
    box-shadow: 0 0 12px 0 #22222230;
    border-radius: 16px;
}
.ins ol li {
    font-family: 'Roboto' !important;
    margin-bottom: 8px;
    font-size: 13px;
    color: #101010 !important;
    margin-right: 10px;
    font-weight: 500;
}

.ins p {
    font-family: 'Roboto' !important;
    padding-left: 23px;
	font-size: 14px;
}
.bar-code {
    text-align: center;
}

.bar-code img {
    width: 150px;
}
.id-card-front {
    background-image: url(http://localhost/mssw/erp/system/images/IDGenerate/Btm-bar.png);
    background-repeat: no-repeat;
    background-position: bottom;
    padding-bottom: 40px;
}

.id-card-back {
    width: 366px !important;
    height: 540px !important;
    margin: 40px auto;
    padding-top: 28px;
    box-shadow: 0 0 12px 0 #22222230;
    border-radius: 16px;
	background:#fff;
}
img.stud-img {
    width: 100px;
    margin: 0px 20px 20px 130px;
    padding-top: 20px;
}
.id-card-back table tr td:nth-child(1) {
    font-weight: 600;
	width: 28%;
}
.id-card-back table tr td {
    padding-bottom: 12px;
    color: #101010;
    font-size: 13px;
    line-height: 16px;
    font-weight: 500;
}
.id-card-back table {
    padding-left: 20px;
    font-family: 'Roboto' !important;
    font-size: 15px !important;
	margin-left: 15px;
}
.btm p {
    line-height: 19px;
    font-size: 14px;
}

.btm {
    background: #f2f2f2;
    padding: 2px;
    text-align: center;
    font-family: 'Roboto' !important;
    font-weight: 500;
	border-bottom-left-radius: 16px;
	border-bottom-right-radius: 16px;
}
.btm h5 {
    font-size: 15px !important;
    margin-bottom: 0;
}
.sign {
    text-align: right;
    position: relative;
    left: -18px;
    bottom: 0px;
	margin-top: 0px;
}
.id-card-back {
    background-image: url(http://localhost/mssw/erp/system/images/IDGenerate/Curve.png);
    background-repeat: no-repeat;
    background-position-y: -4px;
	padding-top: 90px;
}
.pageCover { 
  position:fixed; 
  z-index:10; 
  background-color:rgba(0,0,0,.25); 
  width:100vw; 
  height:100vh; 
  top:0; 
  left:0;
}

</style>
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



      <!--Start Dashboard Content-->
	  <!-- Start Row-->
	 <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
			<a href="<?=base_url().'subadmin/IDGenerateDip'?>"><button class="btn btn-sm btn-success">ID For Diploma</button></a>
			</div>
		   </div>
          </div>
        </div>		  
	 <!-- Start Row-->

	  <?php if(isset($stu_list)){?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Student List
			<div class="row">
			  <div class="col-lg-12">
			    <div class="form-group" style="float:right;">
				<button id="select_all_dip" class="btn btn-sm btn-primary">SelectAll</button>
				<button id="idgeneratedip1" class="btn btn-sm btn-success" name="gen_id">Generate ID</button>
				</div>
			  </div>
			</div>
			</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="idgeneratedip-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Application No</th>
                        <th>Student Name</th>
                        <th>Register No</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php $sno=1;
					foreach($stu_list as $stulist){		
					 ?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$stulist->application_number?></td>
                        <td><?=$stulist->pr_applicant_name?></td>
                        <td><input type="text" class="form-control regnumbr" id="regnumbr"></td>
						<td><input name="stu_id[]" type="checkbox" value="" data-student="<?=$stulist->pr_id?>" data-regno="" class="myinput large checkbox1">
			<div class="downld download_class_<?=$stulist->pr_id?>" style="visibility: hidden;height:2px;"></div>
						</td>
                    </tr>
                    <?php } ?>
               
                </tbody>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>
	  <?php } ?>
	  <!-- End Row-->
	  
	  <!-- Student ID front and back div start -->
	  <div class="idcard_download">
	  
	  </div>
	  <!-- Student ID front and back div end -->

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
	/*$(document).ready(function(){
	$(document).on('change', '.checkbox1', function() {
		var data1 = $(this).parents('tr').find("td:eq(2) input[type='text']").val();
		var this1 = $(this);
		 assReg(data1,this1);
     function assReg(data,this1){
		 this1.data('student','dfdsf');
	 }
	});
	});*/
	</script>