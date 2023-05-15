<?php
  if(isset( $_POST['excel'])){
define('UPLOAD_DIR', 'C:\xampp\htdocs\mssw\erp\uploads');
$image_parts = explode(";base64,", $_POST['file']);
$image_type_aux = explode("image/", $image_parts[0]);
$image_type = $image_type_aux[1];
$image_base64 = base64_decode($image_parts[1]);
$file = UPLOAD_DIR . '\image.png';
file_put_contents($file, $image_base64);
  }
?>
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

      <!--Start Dashboard Content-->
	  
	  <!--Start Row-->
	  
	   <div class="row">
        <div class="col-lg-12">
		<div class="hide-it" align="center"><h4 style="color:#15ca20;"><?php echo $this->session->flashdata('success'); ?></h4></div>
		<?php $this->session->set_flashdata('success',''); ?>
		<div class="hide-it" align="center"><h4 style="color:#8B0000;"><?php echo $this->session->flashdata('form_err'); ?></h4></div>
		<?php $this->session->set_flashdata('form_err',''); ?>
          <div class="card">
		  <div class="card-header"><i class="fa fa-table"></i>Feedback Facilities Report in College</div>
            <div class="card-body">
			
			<form action="" method="post">
			   <div class="row">
			   <div class="col-lg-3">
			<label>Batch</label>   
			<select class="form-control" name="batch" id="batch" required>
			<option value="">Select Batch</option>
			<?php $batch = $this->db->get('erp_batchmaster')->result();
			foreach($batch as $batch){?>
			<option value="<?=$batch->batch_from?>" <?php if($batch1==$batch->batch_from){echo 'selected';}?>><?=$batch->batch_from?></option>
			<?php } ?>
			</select>
		         </div>
			  <div class="col-lg-3">
			<label>Semester</label>   
			  <select class="form-control" id="sem" name="sem" required>
			  <option value="">Select Semester</option>
			  <?php $sem = array('1','2','3','4','5','6');
			  foreach($sem as $sem){ ?>
			  <option value="<?=$sem?>" <?php if($sem1==$sem){echo 'selected';}?>><?=$sem?></option>
			  <?php } ?>
			  </select>
			  </div>
				 <div class="col-lg-3 mt-4">
			<button type="submit" class="btn btn-sm btn-success" name="submit">Submit</button>
		         </div>
		        </div>
            </form>				
		
			</div>
		   </div>
         </div>
        </div>		 
			
	  <?php if(isset($feedbacks)){
		  ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
		  <div class="card-header">
		  <div class="row">
		    <div class="col-lg-12">
			<!--<form action="" method="POST">
			<input type="text" name="file" id="file">
			<button type="submit" name="excel" id="feedback-facilities" class="btn btn-sm btn-success">Excel Download</button>
			</form>-->
			</div>
		  </div>
		  </div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="feedbackfacilities" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Components</th>
                        <th>Excellent</th>
                        <th>Satisfactory</th>
                        <th>Average</th>
                        <th>Poor</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php $sno=1; 
						$fb[1] = array();$fb[2] = array();$fb[3] = array();$fb[4] = array();
					foreach ($feedbacks as $feedbacks) {
						$exc = 0;
						$sat = 0;
						$avg = 0;
						$poor = 0;
						$tot = 0;
						$values = array();
						$get_fb = $this->db->select('fr_'.$feedbacks->id_f.' as value')->where('fr_batch',$batch1)->where('fr_sem',$sem1)->group_by('fr_stud_ad_id')->get('feedback_course_report')->result();
						foreach($get_fb as $get_fb){
							array_push($values,$get_fb->value);
						}
						$cnt = array_count_values($values);
						if(isset($cnt[1])){$exc=$cnt[1];}
						if(isset($cnt[2])){$sat=$cnt[2];}
						if(isset($cnt[3])){$avg=$cnt[3];}
						if(isset($cnt[4])){$poor=$cnt[4];}
						$tot = $exc + $sat + $avg + $poor;
						
						array_push($fb[1],$exc);
						array_push($fb[2],$sat);
						array_push($fb[3],$avg);
						array_push($fb[4],$poor);
						
					?>
                      <tr>
                        <td><?=$sno?></td>
                        <td><?=$feedbacks->name?></td>
                        <td><?=$exc?></td>
                        <td><?=$sat?></td>
                        <td><?=$avg?></td>
                        <td><?=$poor?></td>
                        <td><?=$tot?></td>
                    </tr>
						<?php $sno++;} ?>
                 
               
                </tbody>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>
	  <!-- End Row-->
	  
	  <div id="chart-container" style="background: #fff;">
			<button type="submit" name="excel" id="feedback-facilities" class="btn btn-sm btn-success">Image Download</button>
	 <canvas id="MyChart" width="400" height="200"></canvas>
	 </div>
	  <?php } ?>
	  
	  
  

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
	   setTimeout(function() {
            $('.hide-it').hide('fast');
        }, 3000);
</script>
<script>
var base_url = "<?php echo base_url(); ?>";
	$(document).ready(function(){
var myTable = $('#exammarks-datatable').DataTable();
var allPages = myTable.rows().nodes().to$();
		
		$('#batch').change(function(){
			$('#department').val('');
			$('#subject').empty();
		});
	$('#stream').change(function(){
			$('#dept').css('display','block');
			$('#department').empty();
			$('#subject').empty();
		  var stream = $(this).val();	
			if (stream!='') {
            $.ajax({
                url: base_url + "principal/getProgram",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    stream: stream
                },
                success: function (data) {
					$('#department').append(data);
                }
            });
        }else{
			$('#dept').css('display','none');
		}
		});
    $('#department,#sem,#batch').change(function(){
			$('#sub').css('display','block');
			$('#subject').empty();
		  var stream = $('#stream').val();	
		  var department = $('#department').val();	
		  var batch = $('#batch').val();	
		  var sem = $('#sem').val();	
			if (stream!='' && department!='' && batch!='' && sem!='') {
            $.ajax({
                url: base_url + "principal/getSubjSemwise",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    stream: stream,
                    department: department,
                    batch: batch,
                    sem: sem,
                },
                success: function (data) {
					$('#subject').append(data);
                }
            });
        }
		});	
	
});
	</script>
	
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
<script>
var exc = <?php echo json_encode($fb[1]); ?>;	
var sat = <?php echo json_encode($fb[2]); ?>;	
var avg = <?php echo json_encode($fb[3]); ?>;	
var poor = <?php echo json_encode($fb[4]); ?>;

new Chart(document.getElementById("MyChart"), {
  type: 'bar',
  data: {
    labels: ['Feedback-1','Feedback-2','Feedback-3','Feedback-4'],
    datasets: [{
      label: "Excellent",
      type: "bar",
      stack: "Excellent",
      backgroundColor: "#eece01",
      data: exc,
    }, {
      label: "Satisfactory",
      type: "bar",
      stack: "Satisfactory",
      backgroundColor: "#87d84d",
      data: sat,
    }, {
      label: "Average",
      type: "bar",
      stack: "Average",
      backgroundColor: "#f8981f",      
      data: avg,
    }, {
      label: "Poor",
      type: "bar",
      stack: "Poor",
      backgroundColor: "#00b300",
      backgroundColorHover: "#3e95cd",
      data: poor
    }]
  },
  options: {
    scales: {
      xAxes: [{
        //stacked: true,
        stacked: false,
        ticks: {
          beginAtZero: true,
          maxRotation: 0,
          minRotation: 0
        }
      }],
      yAxes: [{
        stacked: false,
		ticks: {
          beginAtZero: true,
          maxRotation: 0,
          minRotation: 0
        }
      }]
    },
  }
});
var canvas = document.getElementById("MyChart");
  var canvas_url = canvas.toDataURL();
  $('#file').val(canvas_url);
</script>
<script>
 var sem_f = $('#sem').val();
 var batch_f = $('#batch').val();	
		$('#feedback-facilities').click(function() {
		download_image()
	});
	
	function download_image(){
  var canvas = document.getElementById("MyChart");
  //image = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
  image = canvas.toDataURL("image/png").replace("image/png", "application/vnd.ms-excel");
  var link = document.createElement('a');
  link.download = "Facilities-Report.png";
  link.href = image;
  link.click();
}

function download_image1() {

    var template = { excel: '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><meta name=ProgId content=Excel.Sheet> <meta name=Generator content="Microsoft Excel 11"><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>' };

    var format = function (s, c) {
        return s.replace(new RegExp("{(\\w+)}", "g"), function (m, p) {
            return c[p];
        });
    };

    var base64 = function (s) {
        return window.btoa(window.unescape(encodeURIComponent(s)));
    };
	
	
	 var canvas = document.getElementById("MyChart");
  var canvas_url = canvas.toDataURL();
  $('#file').val(canvas_url);
  var canvas_url = base_url + 'uploads/image.png';

	function getBase64Image(img) {
    var canvas = document.createElement("canvas");
    canvas.width = img.width;
    canvas.height = img.height;
    var ctx = canvas.getContext("2d");
    ctx.drawImage(img, 0, 0);
    return canvas.toDataURL("image/png");
    }

    var ctx = { worksheet: 'Worksheet', table: '<img src="'+canvas_url+'" alt="" />' };

    var b64 = base64(format(template.excel, ctx));

    blob = b64toBlob(b64, 'application/vnd.ms-excel');
    var blobUrl = window.URL.createObjectURL(blob);

    var saveLink = document.createElement('a');

    saveLink.download = 'export.xls';
    saveLink.href = blobUrl;
    saveLink.click();
}


function b64toBlob(b64Data, contentType, sliceSize) {
    contentType = contentType || '';
    sliceSize = sliceSize || 512;

    var byteCharacters = window.atob(b64Data);
    var byteArrays = [];

    var offset;
    for (offset = 0; offset < byteCharacters.length; offset += sliceSize) {
        var slice = byteCharacters.slice(offset, offset + sliceSize);

        var byteNumbers = new Array(slice.length);
        var i;
        for (i = 0; i < slice.length; i = i + 1) {
            byteNumbers[i] = slice.charCodeAt(i);
        }

        var byteArray = new window.Uint8Array(byteNumbers);

        byteArrays.push(byteArray);
    }

    var blob = new window.Blob(byteArrays, {
        type: contentType
    });
    return blob;
}
</script>