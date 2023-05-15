
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
            <div class="card-header"><i class="fa fa-table"></i>Subject Report</div>
			<div class="card-body">
              <form action="" method="POST">
            <div class="row">
			  <div class="col-lg-3">
          <label>Batch</label>
		  <select class="form-control" id="batch" name="batch">
		  <option value="">Select Batch</option>
		  <?php foreach($batch_list as $batch){?>
			  <option value="<?=$batch->id?>" <?php if($batch1==$batch->id){echo 'selected';}?>><?=$batch->batch_from?></option>
		  <?php } ?>
		  </select>
			  </div>
			  <?php if(isset($batch1)){if($batch1 != ''){ $bat = $this->db->where('id',$batch1)->get('erp_batchmaster')->row();
			  if($stream == 5){ $batch_to = $bat->batch_from + 3; } else { $batch_to = $bat->batch_from + 2;}
			  $batc = $bat->batch_from .'-'. $batch_to;
			  ?>
			<input type="hidden" id="bat" value="<?=$batc?>">
			  <?php }} ?>
          <div class="col-lg-3">
          <label>Semester</label>
		  <select class="form-control" id="sem" name="sem">
		  <option value="">Select Sem</option>
		  <?php $semst = array('1','2','3','4','5','6');foreach($semst as $semst){?>
			  <option value="<?=$semst?>" <?php if($sem1==$semst){echo 'selected';}?>><?=$semst?></option>
		  <?php } ?>
		  </select>
			  </div>	
			  <div class="col-lg-3">
			<label>Stream</label>   
			<select class="form-control" name="stream" id="stream" required>
			<option value="">Select Stream</option>
			<option value="5" <?php if($stream=='5'){echo 'selected';}?>>UG</option>
			<option value="2" <?php if($stream=='2'){echo 'selected';}?>>PG - MSW Aided</option>
			<option value="1" <?php if($stream=='1'){echo 'selected';}?>>PG - Self Finance</option>
			<option value="3" <?php if($stream=='3'){echo 'selected';}?>>PG - MSW Self Finance</option>
			<option value="4" <?php if($stream=='4'){echo 'selected';}?>>PG Diploma</option>
			</select>
		         </div>
				 <div class="col-lg-3">
			<label>Department</label>   
			<select class="form-control" name="department" id="department" required>
			<option value="">Select Department</option>
			<?php if(isset($department) && $department!=''){ $dept = $this->db->where('main_id',$stream)->get('department_details')->result();
			foreach($dept as $dept){?>
			<option value="<?=$dept->cour_id?>" <?php if($department==$dept->cour_id){echo 'selected';}?>><?=$dept->comp_name?></option>
			<?php }} ?>
			</select>
			<?php if(isset($department) && $department!=''){ 
			$deptt = $this->db->where('main_id',$stream)->where('cour_id',$department)->get('department_details')->row(); ?>
			<input type="hidden" id="dept" value="<?=$deptt->comp_name?>">
			<?php } ?>
		         </div>		  
			  <div class="col-lg-12 mt-3">
          <div class="form-group" style="float: right;">
			  <button class="btn btn-sm btn-success" name="batch_submit">Submit</button>
        </div>
			  </div>
            </div>
	
              </form>
			</div>  
			</div>
		  </div>
      </div>
	  
	  <!--Start Row-->
			
	  <?php if($_POST){if(sizeof($sub_list)>0){?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
              <table id="subject-report" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>Part Type</th>
                        <th>Subject Code</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Faculty Allocated</th>
                        <th>Credits</th>
                        <th>ICA Test</th>
                        <th>THA</th>
                        <th>ICT</th>
                        <th>Total</th>
                        <th>MAX ESE</th>
                        <th>MAX Total</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php $sno=1;
					foreach ($sub_list as $subject) {
						$reg = $this->db->where('id',$subject->regulation)->get('erp_regulation')->row();
						$pol = $this->db->where('id',$subject->policy)->get('erp_subpolicy')->row();
						
						$emp_subj=$this->db->query('SELECT em.emp_name_ FROM erp_employee_subject es INNER JOIN erp_employee_master em ON em.id = es.employee_id where es.subject_id='.$subject->id.' ')->result();
						$e_subj = array_column($emp_subj, 'emp_name_');
						$faculty = implode(',', $e_subj);
						
						$ica=0; $th=0; $inc=0; $ica_tot=50; $ese=50; $total=100;
						if($subject->subNature!='PRACTICAL'){$ica=25; $th=15; $inc=10;}
						if($subject->part==5){$ica='NA'; $th='NA'; $inc='NA'; $ica_tot='NA'; $ese='NA'; $total='NA';}
					?>
                      <tr>
                        <td><?=$sno++?></td>
                        <td><?=$subject->part?></td>
                        <td><?=$subject->subCode?></td>
                        <td><?=$subject->subName?></td>
                        <td><?=$subject->subCatg?></td>
                        <td><?=$subject->subNature?></td>
                        <td><?=$faculty?></td>
                        <td><?=$subject->creditPnt?></td>
                        <td><?=$ica?></td>
                        <td><?=$th?></td>
                        <td><?=$inc?></td>
                        <td><?=$ica_tot?></td>
                        <td><?=$ese?></td>
                        <td><?=$total?></td>
                    </tr>
                    <?php } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                        <th>S.No </th>
                        <th>Part Type</th>
                        <th>Subject Code</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Faculty Allocated</th>
                        <th>Credits</th>
                        <th>ICA Test</th>
                        <th>THA</th>
                        <th>ICT</th>
                        <th>Total</th>
                        <th>MAX ESE</th>
                        <th>MAX Total</th>
                        
                    
                    </tr>
                </tfoot>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>
	  <?php }} ?>
	  <!-- End Row-->

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
		  var stream = $(this).val();	
			if (stream!='') {
            $.ajax({
                url: base_url + "coe/getProgram",
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
	});	
</script>	

<script>
var base_url = "<?php echo base_url(); ?>";

$(document).ready(function(){
	 var myGlyph = new Image();
     myGlyph.src = base_url + 'system/images/logo1.png';

	function getBase64Image(img) {
    var canvas = document.createElement("canvas");
    canvas.width = img.width;
    canvas.height = img.height;
    var ctx = canvas.getContext("2d");
    ctx.drawImage(img, 0, 0);
    return canvas.toDataURL("image/png");
    }
	var fullDate = new Date()
    var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
    var currentDate = fullDate.getDate() + "_" + twoDigitMonth + "_" + fullDate.getFullYear();
	const monthNames = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
	var month = monthNames[fullDate.getMonth()+1];
	
	var myTable = $('#subject-report').DataTable({
		    aaSorting: [[ 0, "asc" ]],
			dom: 'Bfrtip', 
			buttons: 
			[{ 
				extend: 'excelHtml5',
				//title: 'Shortlisted Candidates ' + currentDate + '',
				title: '',
				text:'<i class="fa fa-table fainfo" aria-hidden="true" > Excel</i>',
				titleAttr: 'Export Excel',
                "oSelectorOpts": {filter: 'applied', order: 'current'},
				filename: 'SUBJECT REPORT_ '+currentDate+'',
				orientation:'landscape',
				pageSize: 'A4', 
                alignment: "center",
				customize: function (xlsx) {
					
			var sSh = xlsx.xl['styles.xml'];
			
   var sheet = xlsx.xl.worksheets['sheet1.xml'];
   // $('c[r=B2] t', sheet).text( 'Status: Green means go' );
   $('row c', sheet).attr( 's', '51' ); // centre
   var lastXfIndex = sheet.getElementsByTagName('col').length - 1;
   var greyBoldCentered = lastXfIndex + 2;
   //$('row:eq(0) c', sheet).attr( 's', greyBoldCentered );  //grey background bold and centered

                    var colRange = sheet.getElementsByTagName('col').length - 1;
                    //var colRange = createCellPos( lastCol ) + '1';
                    var numrows = 5;
                    var clR = $('row', sheet);
 
                    //update Row
                    clR.each(function () {
                        var attr = $(this).attr('r');
                        var ind = parseInt(attr);
                        ind = ind + numrows;
                        $(this).attr("r",ind);
                    });
 
                    // Create row before data
                    $('row c ', sheet).each(function () {
                        var attr = $(this).attr('r');
                        var pre = attr.substring(0, 1);
                        var ind = parseInt(attr.substring(1, attr.length));
                        ind = ind + numrows;
                        $(this).attr("r", pre + ind);
                    });
                function Addrow(index,data, colRange, sheet) {
                        msg='<row r="'+index+'">'
                        for(i=0;i<data.length;i++){
                            var key=data[i].key;
                            var value=data[i].value;
                            var style=data[i].style;
                            mergeCells( index, colRange, sheet );
                            msg += '<c t="inlineStr" s="'+ style +'" r="' + key + index + '">';
                            msg += '<is>';
                            msg +=  '<t>'+value+'</t>';
                            msg+=  '</is>';
                            msg+='</c>';
                        }
                        msg += '</row>';
                        return msg;
                    }
							
						var mergeCells = function ( row, colspan, sheet ) {
                        var mergeCells = $('mergeCells', sheet);
 
                        mergeCells[0].appendChild( _createNode( sheet, 'mergeCell', {
                            attr: {
                                ref: 'A'+row+':'+createCellPos(colspan)+row
                            }
                        } ) );
                        mergeCells.attr( 'count', mergeCells.attr( 'count' )+1 );
                        $('row c', sheet).attr( 's', '50' ); // left
                        $('row:eq(0) c', sheet).attr( 's', '32' ); // greyBold
						//$('row c[r^="A"]', sheet).attr( 's', '51' ); //First column center
                    };
					//51 - center
 
                    function createCellPos( n ){
                        var ordA = 'A'.charCodeAt(0);
                        var ordZ = 'Z'.charCodeAt(0);
                        var len = ordZ - ordA + 1;
                        var s = "";
                      
                        while( n >= 0 ) {
                            s = String.fromCharCode(n % len + ordA) + s;
                            n = Math.floor(n / len) - 1;
                        }
                      
                        return s;
                    }
                    function _createNode( doc, nodeName, opts ) {
                        var tempNode = doc.createElement( nodeName );
 
                        if ( opts ) {
                            if ( opts.attr ) {
                                $(tempNode).attr( opts.attr );
                            }
 
                            if ( opts.children ) {
                                $.each( opts.children, function ( key, value ) {
                                    tempNode.appendChild( value );
                                } );
                            }
 
                            if ( opts.text !== null && opts.text !== undefined ) {
                                tempNode.appendChild( doc.createTextNode( opts.text ) );
                            }
                        }
                        return tempNode;
                    }
				
	var sem_s = $('#sem').val();	
    var batch_s = $('#bat').val();	
    var dept_s = $('#dept').val();		
				//insert
                    var r1 = Addrow(1, [{ key: 'A', value: 'MADRAS SCHOOL OF SOCIAL WORK (AUTONOMOUS)', style: '51' }], colRange, sheet);
                    var r2 = Addrow(2, [{ key: 'A', value: '32, Casa Major Road, Egmore, Chennai-600008', style: '51' }], colRange, sheet);
                    var r3 = Addrow(3, [{ key: 'A', value: 'SUBJECT REPORT', style: '51' }], colRange, sheet);
                    var r4 = Addrow(4, [{ key: 'A', value: 'Department: '+dept_s+'  \t\t\t\t\t\t\t\t\t\t   Batch: '+batch_s+'', style: '50' }], colRange, sheet);
                    var r5 = Addrow(5, [{ key: 'A', value: 'Semester: '+sem_s+'', style: '50' }], colRange, sheet);

                    sheet.childNodes[0].childNodes[1].innerHTML = r1 + r2 + r3 + r4 + r5 + sheet.childNodes[0].childNodes[1].innerHTML;	

                },
				exportOptions: {

                 format: {
                   header: function ( data, columnIdx ) {
                                return data.toUpperCase();
                            },
				   body: function ( data, row, column, node ) {
					return data;
                   }
                 },

                 modifier: {
                   pageMargins: [0, 0, 0, 0], // try #3 setting margins
                   margin: [0, 0, 0, 0], // try #4 setting margins
                   alignment: 'center'
                   },
                }
			}]
		} );
		
var allPages = myTable.rows().nodes().to$();

		
   } );		
</script>