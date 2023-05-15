<?php if($this->session->flashdata('success')!=''){ ?>
		<div class="hide-it" align="center"><h4 style="color:#15ca20;"><?php echo $this->session->flashdata('success'); ?></h4></div>
        <?php echo $this->session->set_flashdata('success','','success');?>
        <?php } ?>
 	
           <div class="col-lg-12">

            <div>
            <i class="fas fa-table"></i>

            Driver Records  <a href="<?=base_url().'transportlogin/addDriver'?>"  type="button" class="btn btn-xs btn-info">Add New</a>
            </div>    

          <br> </br>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Driver ID</th>
                                        <th>Driver Name</th>
                                        <th>Driver Mobile</th>
                                        <th>Driver Email</th>
                                        <th>Employ Date</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 <?php                  
                $query = 'SELECT * FROM driver';
                    $result = $this->db->query($query);
                    $row = $result->result_array();
					$sno=1;
                        foreach ($row as $row) {
                            $conf = "return confirm('Are you sure you want to delete?');"; 
                            $date=date('d-m-Y',strtotime($row['EMPLOY_DATE']));							
                            echo '<tr>';
							echo '<td>'. $sno.'</td>';
                            echo '<td>'. $row['DRIVER_ID'].'</td>';
                            echo '<td>'. $row['DRIVER_NAME'].'</td>';
							echo '<td>'. $row['DRIVER_MOBILE'].'</td>';
							echo '<td>'. $row['DRIVER_EMAIL'].'</td>';
                            echo '<td>'. $date.'</td>';
                            echo '<td>';
                            echo ' <a  type="button" class="btn btn-xs btn-warning" href="'.base_url().'transportlogin/editDriver?id='.$row['id'] . '"> EDIT </a> ';
                            echo ' <a  type="button" class="btn btn-xs btn-danger" href="'.base_url().'transportlogin/deleteDriver?id='.$row['id'] . '" onClick="'.$conf.'">DELETE </a> </td>';
                            echo '</tr> ';
							$sno++;
                }
            ?> 
                                    
                                </tbody>
                            </table>
                        </div>
                        	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

	  <script>
	   setTimeout(function() {
            $('.hide-it').hide('fast');
        }, 3000);
</script>	