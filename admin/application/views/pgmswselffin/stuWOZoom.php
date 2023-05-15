<style>
        .input-icons i {
            position: absolute;
        }
          
        .input-icons {
            width: 100%;
            margin-bottom: 10px;
        }
          
        .icon {
            padding: 10px;
            min-width: 40px;
        }
          
        .input-field {
            width: 100%;
            padding: 10px;
			padding-left:40px;
            text-align: left;
        }
    </style>
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">





      <!--Start Dashboard Content-->
	  
	  <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
			<form action="" method="post">
			   <div class="row">
			   <div class="col-lg-3 mt-4">
				 <select class="form-control" name="panel" id="panel" required>
				 <option value="">Select Panel</option>
				 <?php foreach($panel as $panel){?>
				 <option value="<?=$panel->id?>" <?php if($panel1 == $panel->id){echo 'selected';}?>><?=$panel->title?></option>
				 <?php } ?>
				 </select>
				 <?php
				 $panel_name = $this->db->where('id',$panel1)->get('panel')->row();
				 if(isset($panel_name)){
					 $pn = $panel_name->title;
					 $pd = date('d-m-Y', strtotime($panel_name->start_date));
					 $pt = date('h:i A', strtotime($panel_name->start_time));
					 $pv = $panel_name->venue;
					 }else{
						$pn = '';
						$pd = '';
						$pt = '';
						$pv = '';
						 }
				 ?>
				 <input type="hidden" id="panel_name" value="<?=$pn?>">
				 <input type="hidden" id="panel_date" value="<?=$pd?>">
				 <input type="hidden" id="panel_time" value="<?=$pt?>">
				 <input type="hidden" id="panel_venue" value="<?=$pv?>">
				 </div>
				 <div class="col-lg-3 mt-4">
				 <button type="submit" class="btn btn-sm btn-success" name="submit" style="margin-left:20px;">Submit</button>
				 </div>
				</div>
				</form>
              </div>
             </div>
            </div>
          </div>			

	 <?php if($_POST){?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
			<div class="row">
			  <div class="col-lg-12 mt-4">
			    <div class="form-group" style="float:right;">
			<span class="align-right"> <?php $panel_det = $this->db->where('id',$panel1)->get('panel')->row();
			if($panel_det->confirm_status == 0){ ?>
               <button id="publish" value="<?=$panel1?>" class="text-right btn btn-success">Publish and SMS Panel </button>
               
               <?php }
               else{ ?>

                <button  class="text-right btn btn-danger">Already Published</button>

            <?php   }?><a class="text-right btn btn-primary" href = "<?=base_url()?>PgMswSelfFin/panelPdfWOZoom/<?=$panel1?>"><i class="fa fa-file-text" aria-hidden="true"></i> Download Panel Report</a></span>
			</div>
			</div>
			</div>
			   <div class="row">
				 <div class="col-lg-8 mt-4">
				 <div class="form-group">
				 <h5>Total Students : <?=$count?></h5>
			     </div>
			     </div>
				 <div class="col-lg-2 mt-4">
				 <div class="form-group" style="float:right;">
				 <input type="checkbox" id="ckbCheckAll" style="width:25px;height:25px;margin-top: 4px;"/>
				 </div>
				 </div>
				 <div class="col-lg-2 mt-4">
				 <div class="form-group" style="float:left;margin-left: -25px;">
				 <span style="font-weight:bold;">Select All</span>
				 <button type="submit" id="submit" class="btn btn-sm btn-primary" name="submit_link" style="margin-left:20px;">Save Marks</button>
			     </div>
			     </div>
			   </div>
			</div>
            <div class="card-body">

		
              <div class="table-responsive">
              <table id="wozoom" class="table table-bordered">
                <thead>
                    <tr>
                        <th></th> 
                        <th>S No</th> 
                        <th>Student Name </th> 
                        <th>Reference No </th> 
                        <th>UG </th> 
                        <th>Entrance Mark </th> 
                        <th>Total Mark </th> 
                        <th>Community</th> 
                        <th>Panel Marks </th> 
                       
                    </tr>
                </thead>
                <tbody>
				<?php foreach($stu_list as $slist) { 
				$get_stu = $this->db->where("stu_id", $slist->pr_user_id)->where("exam_name", $this->Subject)->where("app_course_id", $dept)->where("main_course_id", "3")->where("type", "panel")->where("panel_id", $panel1)->get("student_complete_mark")->row();
				if(isset($get_stu)){$stu_marks = $get_stu->personal_mark;}else{$stu_marks = '';}
				?>


					<?php 
                    $ent =  $this->db->select("online_exam_pannel.*,sub_preview_pg.UG_two_percentage")->from("online_exam_pannel")->join("sub_preview_pg","sub_preview_pg.sb_u_id=online_exam_pannel.student_id","left")->Where("online_exam_pannel.student_id",$slist->pr_user_id)->Where("online_exam_pannel.exam_category",$this->Subject)->get();
					$app_no= $this->db->select("*")->from("Applyed_Cources")->Where("user_id",$slist->pr_user_id)->Where("applied_course_id",$dept)->where('main_course_id','3')->get()->row();
                      
                      $m = $ent->num_rows();
                      if($m > 0 ){

                          $mark  = $ent->result();
                          $ma_emt = $mark[0]->total_mark;
                          $cal = $mark[0]->total_mark;
                          $ugm = $mark[0]->UG_two_percentage;

                      }else{


                        $ma_emt = "A";
                        $cal = 0;
						$ugm = "";
                      }
                      $total =  $cal + (float)$ugm;

					  if($cal  !=0 ){
                      ?>
					  
                      <tr>
                        <td>
						<input class="checkBoxClass" type="checkbox" value="<?php echo $slist->pr_user_id; ?>" name="stu_id[]" style="width:25px;height:25px;"></td>
						<td><?=$sno?></td>
						<td>
						<?php echo $slist->pr_applicant_name; ?>
						</td>
					
					  <td><?=$app_no->application_number?></td>
					  <td><?=$ugm?></td>
                      
                      
                      <td><?=$ma_emt?></td>
                    
                      <td><?= number_format((float)$total, 2, '.', '')?></td>
                      <td><?php echo $slist->pr_community ?></td>
                      <td><input type="text" class="form-control marks" value="<?=$stu_marks?>"></td>
                    </tr>
					<?php }?>
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






    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

	  <script>
	   setTimeout(function() {
            $('.hide-it').hide('fast');
        }, 3000);
</script>
<script>
$(document).ready(function (){
	$(document).on('change','#community',function(){
		var comm=$(this).val();
		$('#community1').val(comm);
	});
	$(document).on('change','#link_id',function(){
		var linkid=$(this).val();
		$('#linkid').val(linkid);
	});
});
</script>
<script>
var $rows = $('#example1 tr');
$('#search').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
    
    $rows.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
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
	
	var myTable = $('#wozoom').DataTable({
		    aaSorting: [[ 6, "desc" ]],
		    "fnRowCallback" : function(nRow, aData, iDisplayIndex){
                $("td:nth-child(2)", nRow).html(iDisplayIndex +1);
                //$(nRow).css("textAlign", "center");
               return nRow;
            },
			dom: 'Bfrtip', 
			buttons: 
			[{ 
				extend: 'excelHtml5',
				//title: 'Shortlisted Candidates ' + currentDate + '',
				title: '',
				text:'<i class="fa fa-table fainfo" aria-hidden="true" > Excel</i>',
				titleAttr: 'Export Excel',
                "oSelectorOpts": {filter: 'applied', order: 'current'},
				filename: 'Shortlisted Candidates_ '+currentDate+'',
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
					
	            var panel_name=$('#panel_name').val();
	            var pdate=$('#panel_date').val();
	            var ptime=$('#panel_time').val();
	            var pvenue=$('#panel_venue').val();
				//insert
                    var r1 = Addrow(1, [{ key: 'A', value: 'SHORTLISTED CANDIDATES', style: '51' }], colRange, sheet);
                    var r2 = Addrow(2, [{ key: 'A', value: 'Panel Name: '+panel_name+'', style: greyBoldCentered }], colRange, sheet);
                    var r3 = Addrow(3, [{ key: 'A', value: 'Date: '+pdate+' / Time: '+ptime+'', style: greyBoldCentered }], colRange, sheet);
                    var r4 = Addrow(4, [{ key: 'A', value: 'Venue: '+pvenue+'', style: greyBoldCentered }], colRange, sheet);
 
                    sheet.childNodes[0].childNodes[1].innerHTML = r1 + r2 + r3 + r4 + sheet.childNodes[0].childNodes[1].innerHTML;	

                },
				exportOptions: {
				 columns: [1, 2, 3, 4, 5, 6, 7, 8],	

                 format: {
                   header: function ( data, columnIdx ) {
                                if(columnIdx==8){
                                return 'INTERVIEW MARKS';
                                }
                                else{
                                return data.toUpperCase();
                                }
                            },
				   body: function ( data, row, column, node ) {
                   if(column==7){
                     return '';
                    }
				   if(column==0){
                     return row + 1;
                    }	
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
		
		$('#submit').click(function(){
		var panel='<?=$panel1?>';	
		var ids_student=Array();	
		var per_mark=Array();	
			allPages.each(function(){
			$(this).closest('tr').find('td:eq(0) input[class=checkBoxClass]:checked').each(function(){
            ids_student.push($(this).val());
			var mark = $(this).closest('tr').find('td:eq(8) input[type=text]').val();
            if(mark!=''){
            per_mark.push(mark);
			}else{
				alert("Please fill all the selected students' marks!!");
				exit;
			}
            });
		});
		if (confirm('Are you sure to add the Marks?')) {
            $.ajax({
                url: base_url + "pgMswSelfFin/updatePanelMarkWOZoom",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    ids_student: ids_student,
                    per_mark: per_mark,
                    panel: panel,
                },
                success: function (data) {
                }
            });
					alert('Marks Added Successfully!!');
		}
		});
		
	$("#ckbCheckAll").click(function () {
      $(".checkBoxClass",allPages).prop('checked', $(this).prop('checked'));
    });

	$("#publish").click(function(){

    var r = confirm("Are you sure to Publish this Interview Panel List? Once you publish, Notifications will be sent to the candidates.");

if (r == true) {

    var panel_id = $(this).val();
    //alert("yes");
   $.ajax({
			url: "<?php echo base_url();?>pgMswSelfFin/publishPanelWOZoom",
			method: "POST",
			cache: false,
			data:{
				panel_id: panel_id,
			
			},
			success: function(dataResult){
				if(dataResult=="success"){
				swal("Published!", "Panel Published Successfully.", "success");
				if(dataResult){
					$ele.fadeOut().remove();
				}
				location.reload();
			}else{
				swal("Failed!", "Failed to publish pannel.", "danger");
				location.reload();
			}
			}
		}); 
} else {
   // alert("no");
 return false;
}



});
	
	});
	</script>
