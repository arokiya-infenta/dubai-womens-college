
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
		  <div class="card-header"><i class="fa fa-table"></i> Condonation Fee</div>
            <div class="card-body">
			
			<form action="" method="post">
			   <div class="row">
			   <div class="col-lg-3">
			<label>Fee Amount</label>   
			<input type="number" class="form-control" name="fees" value="<?=$fees?>">
			<input type="hidden" class="form-control" name="edit_id" value="<?=$edit_id?>">
		         </div>
				 <div class="col-lg-12 mt-4">
				 <div class="form-group" style="float:right;">
			<button type="submit" class="btn btn-sm btn-success" name="submit">Update</button>
		         </div>
		         </div>
			  </div>
            </form>				
		
			</div>
		   </div>
         </div>
        </div>	
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
$("input[type=checkbox]",allPages).each(function () {
	$(this).css('display','none');
	$(this).siblings().attr('readonly', 'readonly');
	});	
	$('#batch').change(function(){
			$('#department').val('');
			$('#subject').empty();
		});
	$('#stream').change(function(){
			$('#dept').css('display','block');
			$('#department').empty();
			$('#subject').empty();
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
    $('#department').change(function(){
			$('#sub').css('display','block');
			$('#subject').empty();
		  var stream = $('#stream').val();	
		  var department = $(this).val();	
		  var batch = $('#batch').val();	
			if (stream!='' && department!='' && batch!='') {
            $.ajax({
                url: base_url + "coe/getSubj",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    stream: stream,
                    department: department,
                    batch: batch
                },
                success: function (data) {
					$('#subject').append(data);
                }
            });
        }else{
			alert('Select all the fields');
		}
		});	
		
		
/*$("input[type=checkbox]",allPages).each(function () {
	$(this).attr('checked','checked');
	$(this).siblings().removeAttr('readonly');
	});
	
	
		$(".ica1",allPages).change(function () {
           if(!this.checked) {
			   $(this).siblings().val('');
			   $(this).siblings().attr('readonly', 'readonly');
			   }else{
				$(this).siblings().removeAttr('readonly');   
			   }
	});
	$(".ica2",allPages).change(function () {
           if(!this.checked) {
			   $(this).siblings().val('');
			   $(this).siblings().attr('readonly', 'readonly');
			   }else{
				$(this).siblings().removeAttr('readonly');   
			   }
	});
	$(".inclass",allPages).change(function () {
           if(!this.checked) {
			   $(this).siblings().val('');
			   $(this).siblings().attr('readonly', 'readonly');
			   }else{
				$(this).siblings().removeAttr('readonly');   
			   }
	});
	$(".takehome",allPages).change(function () {
           if(!this.checked) {
			   $(this).siblings().val('');
			   $(this).siblings().attr('readonly', 'readonly');
			   }else{
				$(this).siblings().removeAttr('readonly');   
			   }
	});
	
		$('#ica1_submit').click(function(){
		var ica1=Array();	
		var ica1_not=Array();	
		var icaval1=Array();	
		var main_id=$('#stream').val();	
		var course_id=$('#department').val();	
		var subject_id=$('#subject').val();	
		var batch=$('#batch').val();	
			allPages.each(function(){
			$(this).closest('tr').find('td:eq(2) input[class=ica1]:checked').each(function(){
            ica1.push($(this).data('student'));
            icaval1.push($(this).siblings().val());
            });
		});
		allPages.each(function(){
			$(this).closest('tr').find('td:eq(2) input[class=ica1]:not(:checked)').each(function(){
            ica1_not.push($(this).data('student'));
            });
		});
		if (confirm('Are you sure to add the Marks?')) {
            $.ajax({
                url: base_url + "employee/ICA1Mark",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    ica1: ica1,icaval1: icaval1,main_id: main_id,course_id: course_id,ica1_not: ica1_not,subject_id: subject_id,batch: batch,
                },
                success: function (data) {
                }
            });
					alert('ICA1 Marks Added Successfully!!');
		}
		});
		
		$('#ica2_submit').click(function(){
		var ica2=Array();	
		var ica2_not=Array();	
		var icaval2=Array();	
		var main_id=$('#stream').val();	
		var course_id=$('#department').val();
        var subject_id=$('#subject').val();	
        var batch=$('#batch').val();			
			allPages.each(function(){
			$(this).closest('tr').find('td:eq(3) input[class=ica2]:checked').each(function(){
            ica2.push($(this).data('student'));
            icaval2.push($(this).siblings().val());
            });
		});
		allPages.each(function(){
			$(this).closest('tr').find('td:eq(3) input[class=ica2]:not(:checked)').each(function(){
            ica2_not.push($(this).data('student'));
            });
		});
		if (confirm('Are you sure to add the Marks?')) {
            $.ajax({
                url: base_url + "employee/ICA2Mark",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    ica2: ica2,icaval2: icaval2,main_id: main_id,course_id: course_id,ica2_not: ica2_not,subject_id: subject_id,batch: batch,
                },
                success: function (data) {
                }
            });
					alert('ICA2 Marks Added Successfully!!');
		}
		});
		
		$('#ic_submit').click(function(){
		var inclass=Array();	
		var inclass_not=Array();	
		var icval=Array();	
		var main_id=$('#stream').val();	
		var course_id=$('#department').val();
        var subject_id=$('#subject').val();	
        var batch=$('#batch').val();			
			allPages.each(function(){
			$(this).closest('tr').find('td:eq(4) input[class=inclass]:checked').each(function(){
            inclass.push($(this).data('student'));
            icval.push($(this).siblings().val());
            });
		});
		allPages.each(function(){
			$(this).closest('tr').find('td:eq(4) input[class=inclass]:not(:checked)').each(function(){
            inclass_not.push($(this).data('student'));
            });
		});
		if (confirm('Are you sure to add the Marks?')) {
            $.ajax({
                url: base_url + "employee/inClassMark",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    inclass: inclass,icval: icval,main_id: main_id,course_id: course_id,inclass_not: inclass_not,subject_id: subject_id,batch: batch,
                },
                success: function (data) {
                }
            });
					alert('In Class Marks Added Successfully!!');
		}
		});
		
		$('#th_submit').click(function(){
		var takehome=Array();	
		var takehome_not=Array();	
		var thval=Array();	
		var main_id=$('#stream').val();	
		var course_id=$('#department').val();
        var subject_id=$('#subject').val();		
        var batch=$('#batch').val();			
			allPages.each(function(){
			$(this).closest('tr').find('td:eq(5) input[class=takehome]:checked').each(function(){
            takehome.push($(this).data('student'));
            thval.push($(this).siblings().val());
            });
		});
		allPages.each(function(){
			$(this).closest('tr').find('td:eq(5) input[class=takehome]:not(:checked)').each(function(){
            takehome_not.push($(this).data('student'));
            });
		});
		if (confirm('Are you sure to add the Marks?')) {
            $.ajax({
                url: base_url + "employee/takeHomeMark",
                type: 'POST',
                cache: false,
				//dataType: "html",
                data: {
                    takehome: takehome,thval: thval,main_id: main_id,course_id: course_id,takehome_not: takehome_not,subject_id: subject_id,batch: batch,
                },
                success: function (data) {
                }
            });
					alert('Take Home Marks Added Successfully!!');
		}
		});*/
	});
	</script>