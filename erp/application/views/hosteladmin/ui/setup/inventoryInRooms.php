	<style>
	input[type=checkbox]{
		height:25px;width:25px;
	}
	p{
		font-size: 19px;font-weight:bold;
	}
	ul.inventory {  
list-style-type: none;  
font-weight: bold;  
font-size: 20px;  
}  

	</style>
<div id="page-wrapper">
<div class="row">
<?php if($this->session->flashdata('error')!="") {?>
<div class="col-md-6">
<div class="alert alert-danger" >
 <strong>Error :</strong> 
 <?php echo htmlentities($this->session->flashdata('error'));?>
<?php echo $this->session->set_flashdata('error','','success');?>
</div>
</div>
<?php } ?>
<?php if($this->session->flashdata('msg')!="") {?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo htmlentities($this->session->flashdata('msg'));?>
<?php echo $this->session->set_flashdata('msg','','success');?>
</div>
</div>
<?php } ?>
</div>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>Inventories In Room</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-info-circle fa-fw"></i> Hostel Inventory Information
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form name="fees" action="<?=base_url()?>hosteladminlogin/inventoryInRooms"  accept-charset="utf-8" method="post" enctype="multipart/form-data">


                                <div class="row">
                                    <div class="col-lg-12">
									<div class="col-lg-4">
                                            <div class="form-group ">
                                                <label>Room Name</label>
                                                <div class="input-group">

                                                    <span class="input-group-addon"><i class="fa fa-info"></i> </span>
                                                    <select class="form-control" name="room" id="room" required <?php if($rooms1!=''){echo 'disabled';}?>>
			                                         <option value="">Select Room</option>
			                                         <?php foreach($rooms as $rooms){?>
			                                         <option value="<?=$rooms->roomId?>" <?php if($rooms1==$rooms->roomId){echo 'selected';}?>><?=$rooms->roomNo?></option>
			                                         <?php } ?>
			                                        </select>
													<input type="hidden" value="<?=$edit_id?>" name="edit_id">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
									<hr />
                                                <p>Inventories</p>
									<ul class="inventory">
			                          <?php foreach($inventories as $inventories){?>
									<li>
			                        <input type="checkbox" name="inventories[]" value="<?=$inventories->id?>" <?php if(in_array($inventories->id,$inventories1)){echo 'checked';}?>>&nbsp;&nbsp;<?=$inventories->name?>
									</li>
			                          <?php } ?>
									</ul>
                                        </div>


                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="col-lg-5"></div>
                                        <div class="col-lg-2">
                                            <div class="form-group ">
                                                <button type="submit" class="btn btn-success" name="btnSave" ><i class="fa fa-2x fa-check"></i>Save</button>
                                                <a title='Back' href='<?=base_url()."hosteladminlogin/inventoryInRooms"?>'><button type="button" class="btn btn-secondary btn-lg" >Clear</button></a>
                                            </div>

                                        </div>
                                        <div class="col-lg-5">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <hr />
                            <?php  if(sizeof($inv_list) > 0) { ?>				
<div class="table-responsive">
 <table id="inventoryRm-report" class="table table-striped table-bordered table-hover">
  <thead>
  <tr>
                                            <th>S.No</th>
                                            <th>Room</th>
                                            <th>Inventories</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
      <?php  $sno=1;  foreach($inv_list as $row ) { $isData="1";
	  $roomnm = $this->db->where('roomId',$row->room_id)->get('rooms')->row();
	  $inve=explode(',',$row->inventories);
	  $inven = array();
	  $invent = '';
	  foreach($inve as $inve){
		  $getin=$this->db->where('id',$inve)->get('inventories')->row();
		  array_push($inven,$getin->name);
	  }
	  $invent = implode(',',$inven);
	  ?>
                <tr>
                <td><?=$sno++;?></td>
                <td><?=$roomnm->roomNo?></td>
                <td><?=$invent?></td>
				<td><a title='Edit' class='btn btn-success btn-circle' href='<?=base_url()."hosteladminlogin/inventoryInRooms/".$row->id?>'><i class='fa fa-pencil'></i></a>&nbsp&nbsp<a title='Delete' class='btn btn-danger btn-circle' href='<?=base_url()."hosteladminlogin/deleteInventoryRm/".$row->id?>' onclick="return confirm('Are you sure to delete?');"><i class='fa fa-trash-o'></i></a></td>
                </tr>
   <?php } ?>
    </tbody>
                                </table>
                            </div>
		<?php } else
                             {
                                 echo "<h1 class='text-warning'>Inventory Details Not Found!!!</h1>";
                             }
							 ?>
                        </div>
                    </div>


                </div>
                <!-- /.panel-body -->
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>

</div>
<!-- /#page-wrapper -->


<!-- jQuery Script-->
<script src="<?php echo base_url();?>hostelassets/dist/js/jquery.min.js"></script>
<script type="text/javascript">
var base_url = "<?php echo base_url(); ?>";
    $( document ).ready(function() {

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

var myTable = $('#inventoryRm-report'). DataTable( { 
		"bSortCellsTop": true,
			dom: 'Bfrtip', 
			buttons: 
			[{ 
				extend: 'excelHtml5',
				title: ''+currentDate+'',
				//text:'<i class="fa fa-table fainfo" aria-hidden="true" > Excel</i>',
				exportOptions: {
                    columns: [ 0, 1, 2 ]
                },
                "oSelectorOpts": {filter: 'applied', order: 'current'},
				filename: ''+currentDate+'',
				orientation:'landscape'
			},
			{ 
				extend: 'pdfHtml5',
				//title: 'Subjectwise Assessment - ' + month + ' ' + month2[0] + '\n' + stu_name + ' (' + std + ') - ' + subj,
				exportOptions: {
                    columns: [ 0, 1, 2 ]
                },
				filename: ''+currentDate+'',
				orientation:'landscape',
				pageSize: 'A4', 
                alignment: "center",
				customize: function (doc) {
				   
				   doc.styles.tableHeader.fontSize = 8;    
				   doc.defaultStyle.alignment = 'center';
				   doc.styles.tableHeader.alignment = 'center';
				   var rowCount = doc.content[1].table.body.length;
                     for (i = 1; i < rowCount; i++) {
                       doc.content[1].table.body[i][1].alignment = 'left';
                       doc.content[1].table.body[i][2].alignment = 'left';
				       doc.content[1].table.body[i][2].uppercase = true;
                     };
					 
				        var objLayout = {};
                        objLayout['hLineWidth'] = function(i) { return .13; };
                        objLayout['vLineWidth'] = function(i) { return .13; };
                        objLayout['hLineColor'] = function(i) { return '#aaa'; };
                        objLayout['vLineColor'] = function(i) { return '#aaa'; };
                        objLayout['paddingLeft'] = function(i) { return 12; };
                        objLayout['paddingRight'] = function(i) { return 12; };
                        objLayout['paddingTop'] = function(i) { return 12; };
                        objLayout['paddingBottom'] = function(i) { return 12; };
                        doc.content[1].layout = objLayout;
                        var obj = {};
                        obj['hLineWidth'] =  function(i) { return .13; };
                        obj['hLineColor'] = function(i) { return '#aaa'; };
					 
					doc.content.splice( 0, 0, {
                        margin: [ 0, -35, 0, 15 ],
                        alignment: 'center',
                        image: getBase64Image(myGlyph)
                    } );
					
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
		

                },
			}]
		} );
var allPages = myTable.rows().nodes().to$();

    });



</script>