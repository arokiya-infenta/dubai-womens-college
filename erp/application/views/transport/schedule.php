<?php if($this->session->flashdata('success')!=''){ ?>
		<div class="hide-it" align="center"><h4 style="color:#15ca20;"><?php echo $this->session->flashdata('success'); ?></h4></div>
        <?php echo $this->session->set_flashdata('success','','success');?>
        <?php } ?>

         <div class="col-lg-12">
                       <div>
            <i class="fas fa-table"></i>

            Schedule Records  <a href="<?=base_url().'transportlogin/addSchedule'?>"  style="background-image: linear-gradient(black, #014923);> type="button" class="btn btn-xs btn-info">Add New</a>
            </div>    

                        <br> </br>       
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Schedule ID</th>
                                        <th>Arrival</th>
                                        <th>Departure</th>
                                        <th>Bus ID</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 <?php                  
                $query = 'SELECT * FROM schedule';
                    $result = $this->db->query($query);
					$row = $result->result_array();
                  $sno=1;
                        foreach ($row as $row) {
							$conf = "return confirm('Are you sure you want to delete?');"; 
                            $bus = $this->db->where('id',$row['BUS_ID'])->get('bus')->row();	
                                             
                            echo '<tr>';
							echo '<td>'. $sno.'</td>';
                            echo '<td>'. $row['SCHEDULE_ID'].'</td>';
                            echo '<td>'. $row['ARRIVAL'].'</td>';
                            echo '<td>'. $row['DEPARTURE'].'</td>';
                            echo '<td>'. $bus->BUS_ID.'</td>';
                            
                            echo '<td>';
                            echo ' <a  type="button" class="btn btn-xs btn-warning" href="'.base_url().'transportlogin/editSchedule?id='.$row['id'] . '"> EDIT </a> ';
                            echo ' <a  type="button" class="btn btn-xs btn-danger" href="'.base_url().'transportlogin/deleteSchedule?id='.$row['id'] . '" onClick="'.$conf.'">DELETE </a> </td>';
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