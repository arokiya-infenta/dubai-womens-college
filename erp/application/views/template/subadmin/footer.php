	
	<!--Start footer-->
	<footer class="footer">
      <div class="container">
        <div class="text-center">
      
        </div>
      </div>
    </footer>
	<!--End footer-->
   
  </div><!--End wrapper-->

  <!-- Bootstrap core JavaScript-->
  
  <script src="<?=base_url()?>white-version/assets/js/jquery.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/js/popper.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/js/bootstrap.min.js"></script>
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
  
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
	<!-- simplebar js -->
	<script src="<?=base_url()?>white-version/assets/plugins/simplebar/js/simplebar.js"></script>
  <!-- waves effect js -->
  <script src="<?=base_url()?>white-version/assets/js/waves.js"></script>
	<!-- sidebar-menu js -->
	<script src="<?=base_url()?>white-version/assets/js/sidebar-menu.js"></script>
  <!-- Custom scripts -->
  <script src="<?=base_url()?>white-version/assets/js/app-script.js"></script>

  <!--Data Tables js-->
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/buttons.bootstrap4.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/jszip.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/pdfmake.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/vfs_fonts.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/buttons.html5.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/buttons.print.min.js"></script>
  <script src="<?=base_url()?>white-version/assets/plugins/bootstrap-datatable/js/buttons.colVis.min.js"></script>
	
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>


    <script>
 $(document).ready(function() {



$('#example1').DataTable();
       $('#default-datatable').DataTable();

       var table = $('#example').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ],
        "order": [[ 8, "desc" ]],
        
      } ); 
      
      var shotlisted = $('#shortlisted').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ],
        "order": [[ 0, "asc" ]],
        "paging":   false,
        
      } );
      
      var zoom = $('#examplezoomview').DataTable( {
        lengthChange: false,
		paginate: false,
        buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ],
        "order": [[ 5, "desc" ]],
        
      } );
 
     table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
      
      } );
	 
$('#example_fees_master').DataTable( {	 
} );
var base_url = "<?php echo base_url(); ?>";
var myTable = $('#idgenerate-datatable').DataTable();
var allPages = myTable.rows().nodes().to$();

    $('body').on('click', '#select_all', function () {
        if ($(this).hasClass('allChecked')) {
            $('input[type="checkbox"]', allPages).prop('checked', false);
        } else {
            $('input[type="checkbox"]', allPages).prop('checked', true);
        }
        $(this).toggleClass('allChecked');
    });
$("#idgenerate").click(function () {
	$('.downld').empty();
 var ids=Array();
 
	$("input[type=checkbox]:checked", myTable.rows().nodes().to$()).each(function(){
    ids.push($(this).data('student'));
      });
	  
	  $.each(ids, function(index, value){
	$.ajax({
                url: base_url + "subadmin/upload_studentID",
                type: 'POST',
                cache: false,
				//dataType: "text",
                data: {
                    id: ids[index],
                },
                success: function (data) {
					//$('.download_class_'+ids[index]+'').append(data);
					//$('.down_id_'+ids[index]+'').click();
					$('.download_class_'+ids[index]+'', myTable.rows().nodes().to$()).append(data);
					$('.front_down_id_'+ids[index]+'', myTable.rows().nodes().to$()).click();
					$('.back_down_id_'+ids[index]+'', myTable.rows().nodes().to$()).click();
                }
            });
     });
 
  });
  
  
  $(document).ready(function(){
  var element; // global variable
  var getCanvas; //global variable
  var imgageData;
  var newData;
  $("#idgenerate1").click(function () {
	$('.idcard_download').empty();
 var ids=Array();
 
	$("input[type=checkbox]:checked", myTable.rows().nodes().to$()).each(function(){
    ids.push($(this).data('student'));
      });
	  
					// Take a timestamp at the beginning.
                   var start = performance.now();
	  $.each(ids, function(index, value){
	$.ajax({
                url: base_url + "subadmin/getStudentID",
                type: 'POST',
                cache: false,
				//dataType: "text",
                data: {
                    id: ids[index],
                },
                success: function (data) {
					$('.idcard_download').append(data);
		            $('body').addClass('pageCover');
					var stu_reg = $("#reg_"+ids[index]+"").val();
					element = $("#html-content-holder_"+ids[index]+"");
            html2canvas(element, {
                onrendered: function (canvas) {
                    getCanvas = canvas;
			imgageData = getCanvas.toDataURL("image/png");
                newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
                $("#btn-Convert-Html2Image_"+ids[index]+"").attr("download", "student_"+stu_reg+".png").attr("href", newData);
				$("#btn-Convert_"+ids[index]+"").click();
                }
            });
			element.addClass('display_it');
                }
            });
     });
			// Take a final timestamp.
            var end = performance.now();
			// Calculate the time taken and output the result in the console
            var time = (end - start);
            var secs = (time * 1000).toFixed();
			setTimeout(function(){ $(".display_it").remove();$('body').removeClass('pageCover'); }, secs);
		            
  });
  });
  
  
  $(document).ready(function(){
  var element; // global variable
  var getCanvas; //global variable
  var imgageData;
  var newData;
  $("#idgenerate2").click(function () {
	  $('.idcard_download').empty();
     var ids=Array();
 
	$("input[type=checkbox]:checked", myTable.rows().nodes().to$()).each(function(){
    ids.push($(this).data('student'));
      });
	  
	  // Take a timestamp at the beginning.
                   var start = performance.now();
	  $.each(ids, function(index, value){
		  $('.idcard_download').append('<a id="genn_'+ids[index]+'"><button id="gen_'+ids[index]+'">Gen</button></a>');
		  $('body').addClass('pageCover');
		  var url = '<?=base_url().'subadmin/IDGeneratePDF/'?>'+ids[index]+'';
		  $("#genn_"+ids[index]+"").attr("download", "student_.pdf").attr("href", url);
		  $("#gen_"+ids[index]+"").click();
	  });
	  $('.idcard_download').empty();
	  // Take a final timestamp.
            var end = performance.now();
			// Calculate the time taken and output the result in the console
            var time = (end - start);
            var secs = (time * 1000).toFixed();
			setTimeout(function(){ $('body').removeClass('pageCover'); }, secs);          
  });
  });
  
  $(document).ready(function(){
  var element; // global variable
  var getCanvas; //global variable
  var imgageData;
  var newData;
  $("#idgeneratedip2").click(function () {
	  $('.idcard_download').empty();
     var ids=Array();
     var reg=Array();
 
	$("input[type=checkbox]:checked", myTableDip.rows().nodes().to$()).each(function(){
		var data1 = $(this).parents('tr').find("td:eq(3) input[type='text']").val();
		if(data1==''){alert('Please Give Reg.No to all Students!');exit;}
		$(this).attr("data-regno",data1);
    ids.push($(this).data('student'));
    reg.push($(this).data('regno'));
      });
	  
	  // Take a timestamp at the beginning.
                   var start = performance.now();
	  $.each(ids, function(index, value){
		  $('.idcard_download').append('<a id="genn_'+ids[index]+'"><button id="gen_'+ids[index]+'">Gen</button></a>');
		  $('body').addClass('pageCover');
		  var url = '<?=base_url().'subadmin/IDGenerateDipPDF/'?>'+ids[index]+'/'+reg[index]+'';
		  $("#genn_"+ids[index]+"").attr("download", "student_.pdf").attr("href", url);
		  $("#gen_"+ids[index]+"").click();
	  });
	  $('.idcard_download').empty();
	  // Take a final timestamp.
            var end = performance.now();
			// Calculate the time taken and output the result in the console
            var time = (end - start);
            var secs = (time * 1000).toFixed();
			setTimeout(function(){ $('body').removeClass('pageCover'); }, secs);          
  });
  });
  
  var myTableDip = $('#idgeneratedip-datatable').DataTable();
var allPagesDip = myTableDip.rows().nodes().to$();

    $('body').on('click', '#select_all_dip', function () {
        if ($(this).hasClass('allChecked')) {
            $('input[type="checkbox"]', allPagesDip).prop('checked', false);
			$("input[type=checkbox]:not(:checked)", allPagesDip).each(function(){
		$(this).attr("data-regno","");
      });
        } else {
            $('input[type="checkbox"]', allPagesDip).prop('checked', true);
			$("input[type=checkbox]:checked", allPagesDip).each(function(){
		var data1 = $(this).parents('tr').find("td:eq(3) input[type='text']").val();
		$(this).attr("data-regno",data1);
      });
        }
        $(this).toggleClass('allChecked');
    });
	
	$(document).ready(function(){
  var element; // global variable
  var getCanvas; //global variable
  var imgageData;
  var newData;
  $("#idgeneratedip1").click(function () {
	$('.idcard_download').empty();
 var ids=Array();
 var reg=Array();
 
	$("input[type=checkbox]:checked", myTableDip.rows().nodes().to$()).each(function(){
		var data1 = $(this).parents('tr').find("td:eq(3) input[type='text']").val();
		if(data1==''){alert('Please Give Reg.No to all Students!');exit;}
		$(this).attr("data-regno",data1);
    ids.push($(this).data('student'));
    reg.push($(this).data('regno'));
      });
	  
					// Take a timestamp at the beginning.
                   var start = performance.now();
	  $.each(ids, function(index, value){
	  $.ajax({
                url: base_url + "subadmin/getStudentDipID",
                type: 'POST',
                cache: false,
				//dataType: "text",
                data: {
                    id: ids[index],
                    regno: reg[index],
                },
                success: function (data) {
					$('.idcard_download').append(data);
		            $('body').addClass('pageCover');
					var stu_reg = $("#reg_"+ids[index]+"").val();
					element = $("#html-content-holder_"+ids[index]+"");
            html2canvas(element, {
                onrendered: function (canvas) {
                    getCanvas = canvas;
			imgageData = getCanvas.toDataURL("image/png");
                newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
                $("#btn-Convert-Html2Image_"+ids[index]+"").attr("download", "student_"+stu_reg+".png").attr("href", newData);
				$("#btn-Convert_"+ids[index]+"").click();
                }
            });
			element.addClass('display_it');
                }
            });
     });
			// Take a final timestamp.
            var end = performance.now();
			// Calculate the time taken and output the result in the console
            var time = (end - start);
            var secs = (time * 1000).toFixed();
			setTimeout(function(){ $(".display_it").remove();$('body').removeClass('pageCover'); }, secs);
		            
  });
  });
  
  var base_url = "<?php echo base_url(); ?>";
var myTableStf = $('#idgenerate-staff-datatable').DataTable();
var allPagesStf = myTableStf.rows().nodes().to$();

    $('body').on('click', '#select_all_stf', function () {
        if ($(this).hasClass('allChecked')) {
            $('input[type="checkbox"]', allPagesStf).prop('checked', false);
        } else {
            $('input[type="checkbox"]', allPagesStf).prop('checked', true);
        }
        $(this).toggleClass('allChecked');
    });
	
	 $(document).ready(function(){
  var element; // global variable
  var getCanvas; //global variable
  var imgageData;
  var newData;
  $("#idgeneratestaff").click(function () {
	  $('.idcard_download').empty();
     var ids=Array();
 
	$("input[type=checkbox]:checked", myTableStf.rows().nodes().to$()).each(function(){
    ids.push($(this).data('staff'));
      });
	  
	  // Take a timestamp at the beginning.
                   var start = performance.now();
	  $.each(ids, function(index, value){
		  $('.idcard_download').append('<a id="genn_'+ids[index]+'"><button id="gen_'+ids[index]+'">Gen</button></a>');
		  //$('body').addClass('pageCover');
		  var url = '<?=base_url().'subadmin/IDGenerateStaffPDF/'?>'+ids[index]+'';
		  $("#genn_"+ids[index]+"").attr("download", "staff_.pdf").attr("href", url);
		  $("#gen_"+ids[index]+"").click();
	  });
	  $('.idcard_download').empty();
	  // Take a final timestamp.
            var end = performance.now();
			// Calculate the time taken and output the result in the console
            var time = (end - start);
            var secs = (time * 1000).toFixed();
			setTimeout(function(){ $('body').removeClass('pageCover'); }, secs);          
  });
  });
    </script>
	<script>
	$(function () {
  $("#datepicker").datepicker({ 
        autoclose: true, 
        todayHighlight: true
  }).datepicker('update', new Date());
});
$(function () {
  $("#datepicker1").datepicker({ 
        autoclose: true, 
        todayHighlight: true
  }).datepicker('update', new Date());
});
$(function () {
  $("#datepicker2").datepicker({ 
        autoclose: true, 
        todayHighlight: true
  }).datepicker();
});
$(function () {
  $("#datepicker3").datepicker({ 
        autoclose: true, 
        todayHighlight: true
  }).datepicker();
});
	</script>
</body>
</html>
