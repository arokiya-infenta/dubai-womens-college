
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
		  <div class="card-header"><i class="fa fa-table"></i>Student Details</div>
            <div class="card-body">
			
			<form action="" method="post">
			   <div class="row">
			   <div class="col-lg-3">
			<select class="form-control" name="batch" id="batch" required>
			<option value="">Select Batch</option>
			<?php $batch = $this->db->get('erp_batchmaster')->result();
			foreach($batch as $batch){?>
			<option value="<?=$batch->batch_from?>" <?php if($batch1==$batch->batch_from){echo 'selected';}?>><?=$batch->batch_from?></option>
			<?php } ?>
			</select>
		         </div>
                 <div class="col-lg-3">
			<select class="form-control" name="stream" id="stream" required>
			<option value="">Select Stream</option>
			<option value="5" <?php if($stream1=='5'){echo 'selected';}?>>UG</option>
			<option value="2" <?php if($stream1=='2'){echo 'selected';}?>>PG - MSW Aided</option>
			<option value="1" <?php if($stream1=='1'){echo 'selected';}?>>PG - Self Finance</option>
			<option value="3" <?php if($stream1=='3'){echo 'selected';}?>>PG - MSW Self Finance</option>
			<option value="4" <?php if($stream1=='4'){echo 'selected';}?>>PG Diploma</option>
			</select>
		         </div>
				 <div class="col-lg-3">
			<select class="form-control" name="department" id="department" required>
			<option value="">Select Department</option>
			<?php if(isset($department1)){ $dept = $this->db->where('main_id',$stream1)->get('department_details')->result();
			foreach($dept as $dept){?>
			<option value="<?=$dept->cour_id?>" <?php if($department1==$dept->cour_id){echo 'selected';}?>><?=$dept->comp_name?></option>
			<?php }} ?>
			</select>
			<?php if(isset($department1)){ $dept1 = $this->db->where('main_id',$stream1)->where('cour_id',$department1)->get('department_details')->row(); ?>
			<input type="hidden" value="<?=$dept1->comp_name?>" id="dept_name">
			<?php } ?>
		         </div>
				 <div class="col-lg-3 mt-1">
			<button type="submit" class="btn btn-sm btn-success" name="submit">Submit</button>
		         </div>
		        </div>
            </form>				
		
			</div>
		   </div>
         </div>
        </div>		 
			
	  <?php if(isset($stu_list)){?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
              <table id="student-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No </th>
                        <th>REGISTER NO</th>
                        <th>STUDENT NAME</th>
                        <th>FATHER NAME</th>
                        <th>DOB</th>
                        <th>GENDER</th>
                        <th>RELIGION</th>
                        <th>COMMUNITY</th>
                        <th>BLOOD GROUP</th>
                        <th>MOBILE NO</th>
                        <th>ADDRESS</th>
                        <th>PHOTO</th>
                        <th>ACTION</th>
                       
                       
                    </tr>
                </thead>
                <tbody>


                    
                    <?php $sno=1;
					foreach ($stu_list as $student) {
					if($student->left_status==1 || $student->long_absent==1){$style='style="background-color:#f0b7c1;"';}else{$style='';}	
					if($student->pr_photo!=null){$profile='<img src="https://admission.mssw.in/admin/uploads/'.$student->pr_photo.'" style="height:150px;width:150px;"';}else{$profile='';}	
					?>
                      <tr <?=$style?>>
                        <td><?=$sno++?></td>
                        <td><?=$student->as_reg_num?></td>
                        <td><?=$student->as_name?></td>
                        <td><?=$student->pr_father_name?></td>
                        <td><?=date('d-m-Y',strtotime($student->pr_dob))?></td>
                        <td><?=$student->pr_gender?></td>
                        <td><?=$student->pr_religion?></td>
                        <td><?=$student->pr_community?></td>
                        <td><?=$student->as_blood_gp?></td>
                        <!--<td><?=$student->as_app_number?></td>
                        <td><?=$student->as_quata?></td>-->
                        <td><?=$student->u_mobile?></td>
                        <td><?=$student->pr_permanent_address?></td>
                        <td><?=$profile?></td>
                        <td>
						<?php if($student->left_status==0){ ?>
						<a href="<?=base_url().'coe/studentEdit/'.$student->as_id?>">
						<button class="btn btn-sm btn-info">Edit</button>
						</a>
						<?php } else {?>
						<strong>Left</strong>
						<?php } ?>
						</td>
                    </tr>
                    <?php } ?>
                 
               
                </tbody>
                <tfoot>
                <tr>
                        <th>S.No </th>
                        <th>Name</th>
                        <th>Register No.</th>
                        <th>Application No.</th>
                        <th>Quota</th>
                        <th>Blood Group</th>
                        <th>Parent Name</th>
                        <th>DOB</th>
                        <th>Profile</th>
                        <th>Address</th>
                        <th>Action</th>
                        
                    
                    </tr>
                </tfoot>
            </table>
            </div>
            </div>
          </div>
        </div>
      </div>
	  <?php } ?>
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
    //var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
    var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : (fullDate.getMonth()+1);
    var currentDate = fullDate.getDate() + "_" + twoDigitMonth + "_" + fullDate.getFullYear();

var dept_st = $('#dept_name').val();	
var batch_st = $('#batch').val();	
       $('#student-datatable').DataTable({ 
		"bSortCellsTop": true,
			dom: 'Bfrtip', 
			buttons: 
			[{ 
				extend: 'excelHtml5',
				title: '',
				//text:'<i class="fa fa-table fainfo" aria-hidden="true" > Excel</i>',
                "oSelectorOpts": {filter: 'applied', order: 'current'},
				filename: ''+dept_st+'_'+currentDate+'',
				orientation:'landscape',
			
				exportOptions: {
					alignment: 'right',
					format: {
				   body: function ( data, row, column, node ) {
					if(column == 11 || column == 12){
						   return '';
					   }else{
                                return data;
					   }
                   }
                 },
				
				},
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
                    var numrows = 4;
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
                        $('row:eq('+(row-1)+') c', sheet).attr( 's', '51' ); // centre
                    };
 
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
					
				//insert
                    var r1 = Addrow(1, [{ key: 'A', value: 'MADRAS SCHOOL OF SOCIAL WORK (AUTONOMOUS)', style: '51' }], colRange, sheet);
                    var r2 = Addrow(2, [{ key: 'A', value: '32, Casa Major Road, Egmore, Chennai-600008', style: '51' }], colRange, sheet);
                    var r3 = Addrow(3, [{ key: 'A', value: 'Department: '+dept_st+'', style: greyBoldCentered }], colRange, sheet);
                    var r4 = Addrow(4, [{ key: 'A', value: 'Batch: '+batch_st+'', style: greyBoldCentered }], colRange, sheet);

                    sheet.childNodes[0].childNodes[1].innerHTML = r1 + r2 + r3 + r4 + sheet.childNodes[0].childNodes[1].innerHTML;	

                }
			},
			{ 
				extend: 'pdfHtml5',
				//title: 'Subjectwise Assessment - ' + month + ' ' + month2[0] + '\n' + stu_name + ' (' + std + ') - ' + subj,
				filename: ''+dept_st+'_'+currentDate+'',
				orientation:'landscape',
				pageSize: 'A3', 
                alignment: "left",
			
				exportOptions: {
					columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
					alignment: 'right',
				
				},
				customize: function (doc) {
				   
				   doc.styles.tableHeader.fontSize = 8;    
				   doc.defaultStyle.alignment = 'center';
				   doc.styles.tableHeader.alignment = 'center';
				   doc.content[1].margin = [ -10, 0, 0, 0 ] //left, top, right, bottom
					 
				        var objLayout = {};
                        objLayout['hLineWidth'] = function(i) { return .13; };
                        objLayout['vLineWidth'] = function(i) { return .13; };
                        objLayout['hLineColor'] = function(i) { return '#aaa'; };
                        objLayout['vLineColor'] = function(i) { return '#aaa'; };
                        objLayout['paddingLeft'] = function(i) { return 4; };
                        objLayout['paddingRight'] = function(i) { return 4; };
                        objLayout['paddingTop'] = function(i) { return 4; };
                        objLayout['paddingBottom'] = function(i) { return 4; };
                        doc.content[1].layout = objLayout;
                        var obj = {};
                        obj['hLineWidth'] =  function(i) { return .13; };
                        obj['hLineColor'] = function(i) { return '#aaa'; };
					 
					doc.content.splice( 0, 0, {
                        margin: [ 0, -35, 0, 15 ],
                        alignment: 'left',
                        image: getBase64Image(myGlyph)
                    } );
					
					doc.content.splice(1, 1, {
                        margin: [ 0, 10, 0, 0 ],
                        alignment: 'left',
                        bold: true,
                        fontSize: 10,
                        text: [  {text: 'DEPARTMENT: \t'+dept_st+'', bold: true, fontSize: 10, margin: 30}
                                    , {text: '\n BATCH:  \t\t\t\t'+batch_st+'', bold: true, fontSize: 10, margin: 30}
                                        ],
                    });
					
					// Create a footer
        doc['footer']=(function(page, pages) {
            return {
                columns: [
                    'Generated by iStudio Technologies Pvt Ltd.',
                    {
                        // This is the right column
                        alignment: 'right',
                        text: ['page ', { text: page.toString() },  ' of ', { text: pages.toString() }]
                    }
                ],
				alignment: 'left',
                margin: [10, 0]
            }
        });
		

                }
			}]
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