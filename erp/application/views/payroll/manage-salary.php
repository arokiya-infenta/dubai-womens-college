
		<div class="content-wrapper">
			<section class="content-header">
				<h1>Salary for <?php echo $month; ?></h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">Salary for <?php echo $month; ?></li>
				</ol>
			</section>

			<section class="content">
				<div class="row">
        			<div class="col-xs-12">
						<div class="box">
							<div class="box-body">
								<?php if ( $flag == 0 ) { ?>
									<form method="POST" role="form" id="payslip-form1" action="<?=base_url().'payrolllogin/GeneratePaySlip'?>">
										<input type="hidden" name="emp_code" value="<?php echo $empData->id; ?>" />
										<input type="hidden" name="pay_month" value="<?php echo $month; ?>" />
										<div class="table-responsive">
											<table class="table table-bordered">
										    	<tr>
										    		<td width="20%">Employee Code</td>
										    		<td width="30%"><?php echo strtoupper($empData->employee_id_); ?></td>
										    		<td width="20%">Bank Name</td>
										    		<td width="30%"><?php echo ucwords($empData->emp_bankname_); ?></td>
										    	</tr>
											    <tr>
										    		<td>Employee Name</td>
										    		<td><?php echo ucwords($empData->emp_name_); ?></td>
												    <td>Gender</td>
												    <td><?php echo ucwords($empData->emp_gender_); ?></td>
										    	</tr>
											    <tr>
												    <td>Marital Status</td>
												    <td><?php echo strtoupper($empData->emp_maritalstatus_); ?></td>
												    <td>Designation</td>
													<?php $role=$this->db->where('id',$empData->emp_designation_)->get('erp_role_master')->row();?>
												    <td><?php echo ucwords($role->role_name); ?></td>
											    </tr>
											    <tr>
										    		<td>Bank Account</td>
										    		<td><?php echo $empData->emp_accno_; ?></td>
												    <td>IFSC Code</td>
												    <td><?php echo strtoupper($empData->emp_ifsc_); ?></td>
											    </tr>
											    <tr>
												    <td>Location</td>
												    <td><?php echo ucwords($empData->emp_city_); ?></td>
												    <td>PF Account</td>
												    <td><?php echo strtoupper($empData->emp_pf_); ?></td>
											    </tr>
											    <tr>
												    <td>Department</td>
													<?php $dept=$this->db->where('id',$empData->emp_dept_name_)->get('erp_department')->row();?>
												    <td><?php echo ucwords($dept->dept_name_); ?></td>
												    <td>Payable/Working Days</td>
												    <td><?php echo ($empLeave['workingDays'] - $empLeave['withoutPay']); ?>/<?php echo $empLeave['workingDays']; ?> Days</td>
											    </tr>
											    <tr>
												    <td>Date of Joining</td>
												    <td><?php echo date('d-m-Y', strtotime($empData->emp_dj_)); ?></td>
												    <td>Taken/Remaining Leaves</td>
												    <td><?php $casu = $this->db->query("SELECT * FROM `" . DB_PREFIX . "leavecount` WHERE `emp_id` = '$emp_code1' AND `type` = 'Casual Leave' ")->row();
													$c_ta = isset($casu) ? $casu->no_of_leave : 0;
													echo $empLeave['payLeaves']; ?>/<?php echo ($empLeave['totalLeaves'] - $empLeave['payLeaves'] - $c_ta); ?> Days</td>
											    </tr>
										    </table>
											<table class="table table-bordered">
												<thead>
													<tr>
														<th width="35%">Earnings</th>
														<th width="15%" class="text-right">Amount (Rs.)</th>
														<th width="35%">Deductions</th>
														<th width="15%" class="text-right">Amount (Rs.)</th>
													</tr>
												</thead>
												<tbody>
													<?php if ( !empty($empHeads) ) { $lfp=0;?>
														<tr>
															<td colspan="2" style="padding:0">
																<table class="table table-bordered table-striped" style="margin:0">
																	<?php foreach ( $empHeads as $head ) { 
																if($head['payhead_name'] == 'Basic Salary'){ $lfp = $lfp+$head['default_salary']; }
																	?>
																		<?php if ( $head['payhead_type'] == 'earnings' ) { ?>
																			<?php $totalEarnings += $head['default_salary']; ?>
																			<tr>
																				<td width="70%">
																					<?php echo $head['payhead_name']; ?>
																				</td>
																				<td width="30%" class="text-right">
																					<input type="hidden" name="earnings_heads[]" value="<?php echo $head['payhead_name']; ?>" />
																					<input type="text" name="earnings_amounts[]" value="<?php echo number_format($head['default_salary'], 2, '.', ''); ?>" class="form-control text-right" />
																				</td>
																			</tr>
																		<?php } ?>
																	<?php } ?>
																</table>
															</td>
															<td colspan="2" style="padding:0">
																<table class="table table-bordered table-striped" style="margin:0">
																	<?php foreach ( $empHeads as $head ) {
														if($head['payhead_name'] == 'Medical Allowance'){ $lfp = $lfp-$head['default_salary']; } ?>
																		<?php if ( $head['payhead_type'] == 'deductions' ) { ?>
																			<?php $totalDeductions += $head['default_salary']; ?>
																			<tr>
																				<td width="70%">
																					<?php echo $head['payhead_name']; ?>
																				</td>
																				<td width="30%" class="text-right">
																					<input type="hidden" name="deductions_heads[]" value="<?php echo $head['payhead_name']; ?>" />
																					<input type="text" name="deductions_amounts[]" value="<?php echo number_format($head['default_salary'], 2, '.', ''); ?>" class="form-control text-right" />
																				</td>
																			</tr>
																		<?php } ?>
																	<?php } ?>
																</table>
															</td>
														</tr>
													<?php } else { ?>
														<tr>
															<td colspan="4">No payheads are assigned for this employee</td>
														</tr>
													<?php } ?>
												</tbody>
												<tfoot>
													<tr>
														<td><strong>Total Earnings</strong></td>
														<td class="text-right">
															<strong id="totalEarnings">
																<?php echo number_format($totalEarnings, 2, '.', ''); ?>
															</strong>
														</td>
														<td><strong>Total Deductions</strong></td>
														<td class="text-right">
															<strong id="totalDeductions">
																<?php echo number_format($totalDeductions, 2, '.', ''); ?>
															</strong>
														</td>
													</tr>
												</tfoot>
											</table>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<h3 class="text-success" style="margin-top:0">
													Net Salary Payable:
													<span id="netSalary">
													<?php 
	$med_taken = $this->db->query("SELECT * FROM `" . DB_PREFIX . "leavecount` WHERE `emp_id` = '$emp_code1' AND `type` = 'Sick Leave' ")->row();	$l_ta = isset($med_taken) ? $med_taken->no_of_leave : 0;											
	$lfp_per_day = ($lfp != 0) ? ($lfp/30) : 0;
	if($service < 3){
		$m_lea = $this->db->query("SELECT * FROM `" . DB_PREFIX . "leaves` WHERE `emp_code` = '$emp_code1' AND `leave_type` = 'Sick Leave' AND `leave_status_principal` = 'approve' AND DATE_FORMAT(`apply_date`, '%m') = '" . date('m', strtotime($month1)) . "' ")->result();	
	foreach($m_lea as $m_lea){
	  $m_lea_n = explode(',',$m_lea->leave_dates);
	  foreach($m_lea_n as $m_lea_n){
		  $m_leav_n[] = 1;
	  }
	}
	$lfp_m = isset($m_leav_n) ? array_sum($m_leav_n) : 0;
		$lfp_amn = $lfp_m * $lfp_per_day;
	}elseif($service >=3 && $service < 5){
		$m_lea = $this->db->query("SELECT * FROM `" . DB_PREFIX . "leaves` WHERE `emp_code` = '$emp_code1' AND `leave_type` = 'Sick Leave' AND `leave_status_principal` = 'approve' ")->result();	
	foreach($m_lea as $m_lea){
	  $m_lea_n = explode(',',$m_lea->leave_dates);
	  foreach($m_lea_n as $m_lea_n){
		  $m_leav_n[] = 1;
	  }
	}
	$lfp_m = isset($m_leav_n) ? array_sum($m_leav_n) : 0;
	if($designation == 23){ $l_da = 15 - $l_ta; }else { $l_da = 7 - $l_ta; }
	$lfp_amn = ($lfp_m > $l_da) ? ($lfp_m * $lfp_per_day) : 0;
		
	}else{
		$m_lea = $this->db->query("SELECT * FROM `" . DB_PREFIX . "leaves` WHERE `emp_code` = '$emp_code1' AND `leave_type` = 'Sick Leave' AND `leave_status_principal` = 'approve' AND DATE_FORMAT(`apply_date`, '%Y') = '" . date('Y', strtotime($year1)) . "' ")->result();	
	foreach($m_lea as $m_lea){
	  $m_lea_n = explode(',',$m_lea->leave_dates);
	  foreach($m_lea_n as $m_lea_n){
		  $m_leav_n[] = 1;
	  }
	}
	$lfp_m = isset($m_leav_n) ? array_sum($m_leav_n) : 0;
	if($designation == 23){ $l_da = 15 - $l_ta; }else { $l_da = 10 - $l_ta; }
	$lfp_amn = ($lfp_m > $l_da) ? ($lfp_m * $lfp_per_day) : 0;
		
	}
	
													echo number_format(($totalEarnings - $totalDeductions - $lfp_amn), 2, '.', ''); ?>
													</span>
												</h3>
											</div>
											<div class="col-sm-6 text-right">
												<?php if ( !empty($empHeads) ) { ?>
													<button type="submit" class="btn btn-info">
													 	<i class="fa fa-plus"></i> Generate PaySlip
													</button>
												<?php } ?>
											</div>
										</div>
									</form>
								<?php } else { ?>
									<div class="table-responsive">
										<table class="table table-bordered">
											<thead>
												<tr>
													<th width="35%">Earnings</th>
													<th width="15%" class="text-right">Amount (Rs.)</th>
													<th width="35%">Deductions</th>
													<th width="15%" class="text-right">Amount (Rs.)</th>
												</tr>
											</thead>
											<tbody>
												<?php if ( !empty($empSalary) ) { ?>
													<tr>
														<td colspan="2" style="padding:0">
															<table class="table table-bordered table-striped" style="margin:0">
																<?php foreach ( $empSalary as $salary ) { ?>
																	<?php if ( $salary['pay_type'] == 'earnings' ) { ?>
																		<?php $totalEarnings += $salary['pay_amount']; ?>
																		<tr>
																			<td width="70%">
																				<?php echo $salary['payhead_name']; ?>
																			</td>
																			<td width="30%" class="text-right">
																				<?php echo number_format($salary['pay_amount'], 2, '.', ','); ?>
																			</td>
																		</tr>
																	<?php } ?>
																<?php } ?>
															</table>
														</td>
														<td colspan="2" style="padding:0">
															<table class="table table-bordered table-striped" style="margin:0">
																<?php foreach ( $empSalary as $salary ) { ?>
																	<?php if ( $salary['pay_type'] == 'deductions' ) { ?>
																		<?php $totalDeductions += $salary['pay_amount']; ?>
																		<tr>
																			<td width="70%">
																				<?php echo $salary['payhead_name']; ?>
																			</td>
																			<td width="30%" class="text-right">
																				<?php echo number_format($salary['pay_amount'], 2, '.', ','); ?>
																			</td>
																		</tr>
																	<?php } ?>
																<?php } ?>
															</table>
														</td>
													</tr>
												<?php } else { ?>
													<tr>
														<td colspan="4">No payheads are assigned for this employee</td>
													</tr>
												<?php } ?>
											</tbody>
											<tfoot>
												<tr>
													<td><strong>Total Earnings</strong></td>
													<td class="text-right">
														<strong id="totalEarnings">
															<?php echo number_format($totalEarnings, 2, '.', ','); ?>
														</strong>
													</td>
													<td><strong>Total Deductions</strong></td>
													<td class="text-right">
														<strong id="totalDeductions">
															<?php echo number_format($totalDeductions, 2, '.', ','); ?>
														</strong>
													</td>
												</tr>
											</tfoot>
										</table>
									</div>
									<div class="row">
										<div class="col-sm-6">
											<h3 class="text-success" style="margin-top:0">
												Net Salary Payable:
												Rs.<?php echo number_format(($totalEarnings - $totalDeductions), 2, '.', ','); ?>
												<small>(In words: <?php echo ucfirst($ConvertNumberToWords); ?>)</small>
											</h3>
										</div>
										<div class="col-sm-6 text-right">
											<button type="button" class="btn btn-success" onclick="openInNewTab('<?php echo base_url(); ?>payrolllogin/GeneratePaySlipEmployee/<?php echo $empData->id; ?>/<?php echo $month1; ?>/<?php echo $year1; ?>/<?php echo $empData->employee_id_; ?>.pdf');">
												<i class="fa fa-download"></i> Show PaySlip (PDF Version)
											</button>
											<button type="button" class="btn btn-info" onclick="sendPaySlipByMail('<?php echo $emp_code1; ?>', '<?php echo $month; ?>');">
												<i class="fa fa-envelope"></i> Send to Employee
											</button>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>

	<?php if ( $this->session->flashdata('PaySlipMsg') ) { ?>
		<script type="text/javascript">
		$.notify({
            icon: 'glyphicon glyphicon-ok-circle',
            message: '<?php echo $this->session->flashdata("PaySlipMsg"); ?>',
        },{
            allow_dismiss: false,
            type: "success",
            placement: {
                from: "top",
                align: "right"
            },
            z_index: 9999,
        });
		</script>
	<?php } ?>