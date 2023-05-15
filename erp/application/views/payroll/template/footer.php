
		<footer class="main-footer">
			<strong> &copy; <?php echo date("Y");?> Payroll Management System | </strong> Developed By iStudio Technologies
		</footer>
	</div>

	<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>payrollassets/plugins/jQuery/jquery-2.2.3.min.js"></script>-->
	<script src="<?php echo base_url(); ?>payrollassets/plugins/jQuery/jquery-3.6.0.min.js"></script>
	<script src="<?php echo base_url(); ?>payrollassets/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>payrollassets/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url(); ?>payrollassets/plugins/datatables/dataTables.bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>payrollassets/plugins/jquery-validator/validator.min.js"></script>
	<script src="<?php echo base_url(); ?>payrollassets/plugins/datepicker/bootstrap-datepicker.js"></script>
	<script src="<?php echo base_url(); ?>payrollassets/plugins/iCheck/icheck.min.js"></script>
	<script src="<?php echo base_url(); ?>payrollassets/plugins/bootstrap-notify/bootstrap-notify.min.js"></script>
	<script src="<?php echo base_url(); ?>payrollassets/dist/js/app.min.js"></script>
	<script type="text/javascript">var baseurl = '<?php echo base_url(); ?>';</script>
	<script src="<?php echo base_url(); ?>payrollassets/dist/js/script.js?rand=<?php echo rand(); ?>"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>-->
    <script src="<?php echo base_url(); ?>payrollassets/plugins/select2/select2.min.js"></script>
	<script>
	$(document).ready(function() {
		var baseurl = '<?php echo base_url();?>';
    $('#employee_code').select2();
	});
	</script>	
</body>
</html>