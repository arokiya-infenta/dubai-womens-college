
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
            <h1 class="page-header titlehms"><i class="fa fa-hand-o-right"></i>Bill Update</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading text-success">
                    <i class="fa fa-info-circle fa-fw"></i>Bill Update <label class="text-success">[<?php echo $billId?>]</label>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <form name="bill" action="action.php"  accept-charset="utf-8" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-8"></div>
                                <div class="col-lg-4">
                                    <div class="form-group pull-right ">
                                        <button type="button" class="btn btn-success" id="btnAddRow"  onClick="addRow('billingTable')"><i class="fa fa-2x fa-plus"></i>Row</button>
                                        <button type="button" class="btn btn-danger" id="btnDeleteRow" onClick="deleteRow('billingTable')" ><i class="fa fa-2x fa-trash"></i>Row</button>
                                    </div>

                                </div>

                            </div>
                        </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="billingTable" class="table table-striped table-bordered table-hover">
								<input type="hidden" name="edit_id" value="<?php echo $billId;?>" readonly>
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Bill Type</th>
                                        <th>Amount</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                   <?php foreach ($billaction as $row) {
                                      // $ses->Set("userId",$row[userId]);
                                      echo '<tr> <td><input type="checkbox" name="chk"/></td><td> <input type="text" name="type[]" class="form-control" placeholder="Bill Type I.E. establish,paper,meal" value="'.$row->type.'"/> </td>';
                                       echo  '<td> <input type="text" name="amount[]" class="form-control" placeholder="Amount" value="'.$row->amount.'"/> </td></tr>';
									   echo '<input type="hidden" name="bill_to" value="'.$row->billTo.'">';
                                    }
                                   ?>
                                     
                                    <tbody>
                                </table>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-5"></div>
                                <div class="col-lg-2">
                                    <div class="form-group ">
                                        <button type="submit" class="btn btn-success" name="btnSave" ><i class="fa fa-2x fa-check"></i>Save</button>
                                    </div>

                                </div>
                                <div class="col-lg-5">

                                </div>
                            </div>
                        </div>
                        </form>


                </div>
            </div>

        </div>

    </div>



<!-- jQuery Script-->
<script src="<?php echo base_url();?>hostelassets/dist/js/jquery.min.js"></script>
    <SCRIPT language="javascript">
        function addRow(tableID) {

            var table = document.getElementById(tableID);

            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);

            var cell1 = row.insertCell(0);
            var element1 = document.createElement("input");
            element1.type = "checkbox";
            element1.name="chkbox[]";
            cell1.appendChild(element1);



            var cell2 = row.insertCell(1);
            var element2 = document.createElement("input");
            element2.type = "text";
            element2.name = "type[]";
            element2.className ="form-control";
            cell2.appendChild(element2);

            var cell3 = row.insertCell(2);
            var element3 = document.createElement("input");
            element3.type = "text";
            element3.name = "amount[]";
            element3.className ="form-control";
            cell3.appendChild(element3);


        }

        function deleteRow(tableID) {
            try {
                var table = document.getElementById(tableID);
                var rowCount = table.rows.length;

                for(var i=0; i<rowCount; i++) {
                    var row = table.rows[i];
                    var chkbox = row.cells[0].childNodes[0];
                    if(null != chkbox && true == chkbox.checked) {
                        table.deleteRow(i);
                        rowCount--;
                        i--;
                    }



                }
            }catch(e) {
                alert(e);
            }
        }

    </SCRIPT>