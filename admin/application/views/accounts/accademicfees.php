<style>
label.gst_la, label.inst {
            float: left;
        }	
          
 span.gst, span.insta {
            display: block;
            overflow: hidden;
            padding: 0px 4px 0px 20px;
			margin-top: -11px;
        }
 span.instd {
            display: block;
            overflow: hidden;
            padding: 0px 4px 0px -1px;
			margin-top: -11px;
        }		
</style>		
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">


    



     <!-- Start Row-->
        <div class="row">
					 <div class="col-md-2 "></div>
					 <div class="col-md-8 ">
					  <?php if(!empty($this->session->flashdata('message'))){

echo $this->session->flashdata('message');

            } ?>
					 </div>
					 <div class="col-md-2 "></div>
					</div>	
			
	 <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-file-text"></i> Fees Structure</div>
            <div class="card-body">
			
    <form id="myForm" action="<?=base_url().'accounts/accademicFees'?>" method="post">	
	        <div class="row">
			<div class="col-md-3">
			<label>Stream</label>
			<select class="form-control" name="main_course_id" id="main_course_id" required>
			<option value="">Select Stream</option>
			<option value="5">UG</option>
			<option value="2">PG - MSW Aided</option>
			<option value="1">PG - Self Finance</option>
			<option value="3">PG - MSW Self Finance</option>
			<option value="4">PG Diploma</option>
			</select>
			</div>
			<div class="col-md-3" id="app_course" style="display:none;">
			<label>Program</label>
			<select class="form-control" id="app_course_id" name="app_course_id" required>
			</select>
			</div>
			<div class="col-md-2" id="year" style="display:none;">
			<label>Year</label>
			<select class="form-control year" name="year">
			<!--<option value="">Select Year</option>
			<option value="1">1 Year</option>
			<option value="2">2 Year</option>
			<option value="3">3 Year</option>-->
			</select>
			</div>
			<?php 
			$date = date('Y');
            $newdate = date("Y",strtotime ( '+1 year' , strtotime ( $date ) )) ;
			?>
			<div class="col-md-2" id="batch" style="display:none;">
			<label>Batch</label>
			<select class="form-control batch" name="batch">
			<option value="<?php echo $date;?>"><?php echo $date;?></option>
			<option value="<?php echo $newdate;?>"><?php echo $newdate;?></option>
			</select>
			</div>
			<div class="col-md-2" id="due_date" style="display:none;">
			<label>Due Date</label>
			<input type="date" class="form-control due_date" name="due_date">
			</div>
			</div>
			
			<div id="fee_struc" style="display:none;">
			<!--Fees Structure-->
			<div class="row mt-3">
			<?php $f=0; foreach($get_fees_type as $fees_type){ 
			if($fees_type->name=='Tuition'){$name='tuition_fee';}
			if($fees_type->name=='Exam'){$name='exam_fee';}
			if($fees_type->name=='Infrastructure'){$name='infrastructure_fee';}
			?>
			<div class="col-md-3">
			<label><?=$fees_type->name?> Fees</label>
			<input type="number" class="form-control fees fees_<?=$fees_type->id?>" name="<?=$fees_type->id?>" autocomplete="off">
			</div>
			<?php $f++;} ?>
			<div class="col-md-3">
			<label>Penalty Fees</label>
			<input type="number" class="form-control penalty" name="penalty" autocomplete="off">
			</div>
			</div>
			
			<div class="row mt-5" style="margin-bottom:-10px;">
			<div class="col-md-3">
			<label><h6>Subtotal<span style="text-transform: capitalize;"> (Rs.)</span></h6></label>
			</div>
			<div class="col-md-8">
			<div class="form-group" style="float:right!important">
			<label><h6><b><span class="subtot"></span></b></h6></label>
			</div>
			</div>
			</div>
			<div class="row" style="margin-bottom:-11px;">
			<div class="col-sm-3">
			<label for="test" class="gst_la"><h6>GST (%)
			&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" class="gst_stat" value="1" name="gst_stat">&nbsp;Yes&nbsp;<input type="radio" class="gst_stat" value="0" name="gst_stat">&nbsp;No</h6></label>
            <span class="gst">
            
           </span>
			</div>
			<div class="col-md-8">
			<div class="form-group" style="float:right!important">
			<label><h6><b><input name="gst_val" id="gst" type="number" class="form-control gst_val" style="display:none;width:100px;height:25px;" value="0"/></b></h6></label>
			</div>
			</div>
			</div>
			<div class="row" style="margin-bottom:-10px;">
			<div class="col-md-3">
			<label><h6>GST<span style="text-transform: capitalize;"> (Rs.)</span></h6></label>
			</div>
			<div class="col-md-8">
			<div class="form-group" style="float:right!important">
			<label><h6><b><input type="hidden" name="gst_amt" class="form-control gstamt" style="width:100px;"><span class="gstamt1"></span></b></h6></label>
			</div>
			</div>
			</div>
			<div class="row">
			<div class="col-md-3">
			<label><h6>Total<span style="text-transform: capitalize;"> (Rs.)</span></h6></label>
			</div>
			<div class="col-md-8">
			<div class="form-group" style="float:right!important">
			<label><h6><b><input type="hidden" name="total" class="form-control total" style="width:100px;"><span class="total1"></span></b></h6></label>
			</div>
			</div>
			</div>
			
			<!-- Installment Status -->
			<div class="row mt-3">
			 <div class="col-md-3">
              <label class="inst">Installment Status</label><input name="installment_status" type="checkbox" class="installment_status" style="width:20px;height:20px;margin-left:5px;" value="0"></span>
            </div>
            </div>
			
			<!-- Installments -->
			<div class="inst_stat">
			<hr><div class="row mb-4">
			<div class="col-md-8">
			Add Installments
			<button type="button" class="btn btn-sm btn-success" id="addButton" style="margin-left:27px;"><i class="fa fa-plus"></i></button>
            &nbsp;&nbsp;<button type="button" class="btn btn-sm btn-danger" id='removeButton'><i class="fa fa-trash"></i></button>
            <!--<input type='button' value='Get TextBox Value' id='getButtonValue'>-->
			</div>
			</div>
			
			<div id='TextBoxesGroup'>
             <!--<div id="TextBoxDiv1">
			 <div class="row">
			 <div class="col-md-3">
              <label class="inst">Installment #1 (%): </label><span class="insta"><input name="installment_perc1" type="number" id="textbox1" class="form-control instlmnt"></span>
            </div>
			<div class="col-md-8">
			<div class="form-group" style="float:right!important">
			<label><h6><b><input type="hidden" name="installment1" class="form-control inslmnt installment1" style="width:100px;"><span class="installment11"></span></b></h6></label>
			</div>
			</div>
            </div>
            </div>-->
            </div>
			
			<!-- Interest -->
			<div class="row mt-3">
			 <div class="col-md-3">
              <label class="inst">Charges<span style="text-transform: capitalize;"> (Rs.):</span> </label><span class="insta"><input name="interest" type="number" id="interest" class="form-control interest" style="margin-left: 36px;width: 129px;"></span>
            </div>
			<!--<div class="col-md-8">
			<div class="form-group" style="float:right!important">
			<label><h6><b><span class="interest1"></span></b></h6></label>
			</div>
			</div>-->
            </div>
			
			<div class="row mt-3">
			 <div class="col-md-3">
              <label class="inst">Total With Charges<span style="text-transform: capitalize;"> (Rs.):</span> </label>
            </div>
			<div class="col-md-8">
			<div class="form-group" style="float:right!important">
			<label><h6><b><span class="interest1"></span></b></h6></label>
			</div>
			</div>
            </div>
			</div>
			
			<div class="row mt-3">
			<div class="col-md-11">
			<div class="form-group" style="float:right;">
			<input type="hidden" id="count">
			<button type="submit" class="btn btn-sm btn-success submit" name="submit">Submit</button>
			</div>
			</div>
			</div>
			</div>
		</form>
			
            </div>
          </div>
        </div>
      </div>
	  

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
	var base_url = "<?php echo base_url(); ?>";
$("#main_course_id").change(function () {
	$('#fee_struc').css('display','none');
	$("#due_date").css('display','none');
	$("#year").css('display','none');
	$("#batch").css('display','none');
	$('.year').empty(); 
	//$("#stu").css('display','none');
        if ($('#main_course_id').val() != "") {
            $.ajax({
                url: base_url + "accounts/get_app_course_id",
                type: 'POST',
                cache: false,
                data: {
                    main_course_id: $('#main_course_id').val()
                },
                success: function (data) {
					$("#app_course").css('display','block');
                       $("#app_course_id").html(data);
                }
            });
        }else{
			$("#app_course").css('display','none');
			$("#fee_struc").css('display','none');
			$("#due_date").css('display','none');
			$("#year").css('display','none');
			$("#batch").css('display','none');
		}
    });
	</script>
	<script>
	$("#app_course_id").on('change', function (e) {
		$('.year').empty(); 
		var html = '<option>Select Year</option>';
		    html += '<option value="1">1 Year</option>';
		    html += '<option value="2">2 Year</option>';
		  if($("#main_course_id").val()==5){
			  html += '<option value="3">3 Year</option>';
			 $('.year').append(html); 
		  }	else{
			 $('.year').append(html);  
		  }
		$("#year").css('display','block');
		$('select.year>option[value=""]').prop('selected', true);
		$('#fee_struc').css('display','none');
	  $("#due_date").css('display','none');
	  $("#batch").css('display','none');
	});
var cnt1=0;	
  $(".year").on('change', function (e) {
		 var cnt=0;
	  $('.gstamt').val('');
	  $('.gstamt1').text('');
	  $('.total').val('');
	  $('.total1').text('');
	  $('.subtot').text('');
	  $('#count').val('');	
	  $('#TextBoxDiv1,#TextBoxDiv2,#TextBoxDiv3,#TextBoxDiv4,#TextBoxDiv5').remove();
	  $('.installment11,.installment21,.installment31,.installment41,.installment51,.interest1').text('');
	  $('.inslmnt,.instlmnt,.instlmntd,.interest').val('');
  if($('#app_course_id').val() != "" && $('#main_course_id').val() != "" && $('.year').val() != "")	{
	  $('#fee_struc').css('display','block');
	  $("#due_date").css('display','block');
	  $("#year").css('display','block');
	  $("#batch").css('display','block');
	var main_course_id = $('#main_course_id').val();
	var app_course_id = $('#app_course_id').val();
	var year = $('.year').val();
	  $.ajax({
                url: base_url + "accounts/get_fees",
                type: 'POST',
                cache: false,
				data: {year:year},
				//dataType: json,
                success: function (dataResult) {
					var dataResult = JSON.parse(dataResult);
				 var len = dataResult.length;
				 var fees_len = $('.fees').length;
                //$('#role_id_edit').val('');
	   
       if(len > 0){
		 var a;
		 var tota=0;
		 var inst1=0;
		 var inst2=0;
		 var inst3=0;
		 var inst4=0;
		 var inst5=0;
		 var instp1=0;
		 var instp2=0;
		 var instp3=0;
		 var instp4=0;
		 var instp5=0;
		 var inst11=0;
		 var inst21=0;
		 var inst31=0;
		 var inst41=0;
		 var inst51=0;
		 var instd1=0;
		 var instd2=0;
		 var instd3=0;
		 var instd4=0;
		 var instd5=0;
		 var intrs=0;
		 for(a=0; a<len; a++){
         var fee = 'main_'+main_course_id+'_app_'+app_course_id+'';
           var fees = dataResult[a][''+fee+''];
         // Read values
		 if(dataResult[a].status != 0){
          $( '.fees_'+dataResult[a].id+'' ).val(fees);
		  if(fees != '' && fees != null){
		  tota+=parseInt(fees);}
		 }
		 else if(dataResult[a].name == 'Penalty'){
             $( '.penalty' ).val(fees);
			 /*if(fees != '' && fees != null){
			 tota+=parseInt(fees);}	 */
		   $('.total').val(tota);
		   $('.total1').text(tota);
		 }
		 else if(dataResult[a].name == 'Due Date'){
             $( '.due_date' ).val(fees);
		 }
		 else if(dataResult[a].name == 'Batch'){
             $('select.batch>option[value="' + fees + '"]').prop('selected', true);
		 }
		 else if(dataResult[a].name == 'GST Status'){
	      if(fees == 1)	{
			 $('input[name=gst_stat][value="0"]').removeAttr('checked');
             $('input[name=gst_stat][value="'+fees+'"]').prop('checked',true);
	         $('#gst').css('display','block');
           }  else {
			 $('input[name=gst_stat][value="1"]').removeAttr('checked');
			 $('input[name=gst_stat][value="0"]').prop('checked',true);
	         $('#gst').css('display','none');
	        //$('#gst').val('0');
           }  	
		 }
		 else if(dataResult[a].name == 'GST Value'){
             $( '.gst_val' ).val(fees);
			if($('input[name=gst_stat]').val()==1) {
			 var gst = (fees/100);
             var tot = (gst * tota).toFixed();
	           $('.total').val(parseInt(tot)+parseInt(tota));
			   $('.total1').text(parseInt(tot)+parseInt(tota));
	           $('.gstamt').val(tot);
	           $('.gstamt1').text(tot);
		    }
		 }
		 else if(dataResult[a].name == 'Total'){
             $( '.total' ).val(fees);
		 }
		 else if(dataResult[a].name == 'Installment Status'){
			 if(fees!=''&&fees!=0&&fees!=null){
				 $('.inst_stat').css('display','block');
				 $('.installment_status').prop('checked',true);
				 $('.installment_status').val('1');
				 }else{
				 $('.inst_stat').css('display','none');	 
				 $('.installment_status').prop('checked',false);
				 $('.installment_status').val('0');
				 }
		 }
		 else if(dataResult[a].name == 'Installment1'){
              inst1=fees;
              inst11=fees;
			 if(fees!=''&&fees!=0&&fees!=null){
			//$('.installment1').val(inst1); 
			//$('.installment11').text(inst1); 
				 cnt+=parseInt(1);intrs+=parseInt(fees);
				 }
		 }
		 else if(dataResult[a].name == 'Installment2'){
              inst2=fees;
              inst21=fees;
			 if(fees!=''&&fees!=0&&fees!=null){cnt+=parseInt(1);intrs+=parseInt(fees);}
		 }
		 else if(dataResult[a].name == 'Installment3'){
              inst3=fees;
              inst31=fees;
			 if(fees!=''&&fees!=0&&fees!=null){cnt+=parseInt(1);intrs+=parseInt(fees);}
		 }
		 else if(dataResult[a].name == 'Installment4'){
              inst4=fees;
              inst41=fees;
			 if(fees!=''&&fees!=0&&fees!=null){cnt+=parseInt(1);intrs+=parseInt(fees);}
		 }
		 else if(dataResult[a].name == 'Installment5'){
              inst5=fees;
              inst51=fees;
			 if(fees!=''&&fees!=0&&fees!=null){cnt+=parseInt(1);}
		 }
		 else if(dataResult[a].name == 'Installment_perc1'){
              instp1=fees;
			  if(fees!=''&&fees!=0&&fees!=null){
			$('#textbox1').val(instp1);
				 }
		 }
		 else if(dataResult[a].name == 'Installment_perc2'){
              instp2=fees;
		 }
		 else if(dataResult[a].name == 'Installment_perc3'){
              instp3=fees;
		 }
		 else if(dataResult[a].name == 'Installment_perc4'){
              instp4=fees;
		 }
		 else if(dataResult[a].name == 'Installment_perc5'){
              instp5=fees;
		 }
		 else if(dataResult[a].name == 'Installment_date1'){
              instd1=fees;
		 }
		 else if(dataResult[a].name == 'Installment_date2'){
              instd2=fees;
		 }
		 else if(dataResult[a].name == 'Installment_date3'){
              instd3=fees;
		 }
		 else if(dataResult[a].name == 'Installment_date4'){
              instd4=fees;
		 }
		 else if(dataResult[a].name == 'Installment_date5'){
              instd5=fees;
		 }
		 else if(dataResult[a].name == 'Interest'){
              $('.interest').val(fees);
              $('.interest1').text(fees);
			  if(fees!=''&&fees!=0&&fees!=null){intrs+=parseInt(fees);}
			  else{$('.interest').val('0');}
		 }
		   $('.subtot').text(tota);
		   $('select.year>option[value="' + year + '"]').prop('selected', true);
		 }
		 if(cnt>0){
		 for(var c=1; c<(cnt+1); c++){
			var newTextBoxDiv = $(document.createElement('div'))
         .attr("id", 'TextBoxDiv' + c);
		 
	var html = '';
    html += '<div class="row">';	
    html += '<div class="col-md-3">';	
    html += '<label class="inst">Installment #'+ c + ' (%): </label>';	
    html += '<span class="insta"><input type="number" class="form-control instlmnt" name="installment_perc' + c + '" id="textbox' + c + '" value="" ></span>';	
    html += '</div>';	
	html += '<div class="col-md-2">';
	html += '<span class="instd"><input type="date" class="form-control instlmntd" name="installment_date' + c + '" id="textboxd' + c + '" value="" ></span>';	
    html += '</div>';	
	html += '<div class="col-md-6">';
	html += '<div class="form-group" style="float:right!important">';
	html += '<label><h6><b><input type="hidden" name="installment'+ c + '" class="form-control inslmnt installment'+ c + '" style="width:100px;"><span class="installment'+ c + '1"></span></b></h6></label>';
	html += '</div>';
	html += '</div>';
    html += '</div>';	
                
    newTextBoxDiv.after().html(html);
            
    newTextBoxDiv.appendTo("#TextBoxesGroup"); 
	      if(c==1){ins=inst1;ins1=inst11;insp=instp1;insd=instd1;}
	      if(c==2){ins=inst2;ins1=inst21;insp=instp2;insd=instd2;}
	      if(c==3){ins=inst3;ins1=inst31;insp=instp3;insd=instd3;}
	      if(c==4){ins=inst4;ins1=inst41;insp=instp4;insd=instd4;}
	      if(c==5){ins=inst5;ins1=inst51;insp=instp5;insd=instd5;}
	        $('.installment'+c+'').val(ins); 
			$('.installment'+c+'1').text(ins1); 
			$('#textbox'+c+'').val(insp);
			$('#textboxd'+c+'').val(insd);
		 }
		 }
		 /*cnt1+=parseInt(cnt);
		 if(cnt>0){
		 $('#count').val(cnt1);	 
		 }*/
		 $('#count').val(cnt);
		 $('.interest1').text(intrs);
       }
                }
            });
  }  else{
	  $('#fee_struc').css('display','none');
	  $("#due_date").css('display','none');
	  $("#year").css('display','none');
	  $("#batch").css('display','none');
  }
   });
   $("input[type=radio]").on('click', function (e) {
  if($('input[type=radio]:checked').val() == 1)	{
	  $('#gst').css('display','block');
	  var gst = ($('.gst_val').val()/100);
      var tot = (gst * $('.subtot').text()).toFixed();
	  $('.total').val(parseInt(tot)+parseInt($('.subtot').text()));
	  $('.total1').text(parseInt(tot)+parseInt($('.subtot').text()));
	  $('.gstamt').val(tot);
	  $('.gstamt1').text(tot);
	  
	  var inst=0;
  $('.instlmnt').each(function(){
		 if($('.instlmnt').val() != ''){
		 var tot = $('.total').val();
  var inst = ($(this).val()/100);
  var tota = (inst * tot).toFixed();
  var inp = $(this).parent().parent().parent().find('input:last').val(tota);
  $(this).parent().parent().parent().find('span:last').text(tota);
		 inst+=parseInt(tota);}
	 });
	 var inst1=0;
	   if($('.interest').val()!=''){
		   $('.inslmnt').each(function(){
		 if($(this).val() != ''){
		 inst1+=parseInt($(this).val());}
	 });
  var interest=$('.interest').val();
  var total=parseInt(inst1)+parseInt(interest);	
    $('.interest1').text(total);
	}
	
  }  else {
	  $('#gst').css('display','none');
	  $('.total').val($('.subtot').text());
	  $('.total1').text($('.subtot').text());
	  $('.gstamt').val('0');
	  $('.gstamt1').text('0');
	  //$('#gst').val('0');
	  
	  var inst=0;
  $('.instlmnt').each(function(){
		 if($('.instlmnt').val() != ''){
		 var tot = $('.total').val();
  var inst = ($(this).val()/100);
  var tota = (inst * tot).toFixed();
  var inp = $(this).parent().parent().parent().find('input:last').val(tota);
  $(this).parent().parent().parent().find('span:last').text(tota);
		 inst+=parseInt(tota);}
	 });
	 var inst1=0;
	   if($('.interest').val()!=''){
		   $('.inslmnt').each(function(){
		 if($(this).val() != ''){
		 inst1+=parseInt($(this).val());}
	 });
  var interest=$('.interest').val();
  var total=parseInt(inst1)+parseInt(interest);	
    $('.interest1').text(total);
	}
  }
   });
	</script>
	<script>
	$(".gst_val").on('keyup', function (e) {
		$('.gstamt').val('');
		$('.gstamt1').text('');
		$('.total').val('');
		$('.total1').text('');
		var sub_tot=0;
	 $('.fees').each(function(){
		 if($(this).val() != '' && $(this).val() != null){
		 sub_tot+=parseInt($(this).val());}
	 });
	  /*if($('.penalty').val() != '' && $('.penalty').val() != null){
	     sub_tot+=parseInt($('.penalty').val());
	  }*/
	  var gst = ($(this).val()/100);
       var tot = (gst * sub_tot).toFixed();
	   $('.total').val(parseInt(tot)+parseInt(sub_tot));
	   $('.total1').text(parseInt(tot)+parseInt(sub_tot));
	   $('.gstamt').val(tot);
	   $('.gstamt1').text(tot);
	   
	   var inst=0;
  $('.instlmnt').each(function(){
		 if($('.instlmnt').val() != ''){
		 var tot = $('.total').val();
  var inst = ($(this).val()/100);
  var tota = (inst * tot).toFixed();
  var inp = $(this).parent().parent().parent().find('input:last').val(tota);
  $(this).parent().parent().parent().find('span:last').text(tota);
		 inst+=parseInt(tota);}
	 });
	 var inst1=0;
	   if($('.interest').val()!=''){
		   $('.inslmnt').each(function(){
		 if($(this).val() != ''){
		 inst1+=parseInt($(this).val());}
	 });
  var interest=$('.interest').val();
  var total=parseInt(inst1)+parseInt(interest);	
    $('.interest1').text(total);
	}
	});
	</script>
	<script>
	$('.fees').add('.penalty').on('keyup',function() {
	  //$('.installment11,.installment21,.installment31,.installment41,.installment51,.interest1').text('');
	  //$('.inslmnt,.interest').val('');
		var sub_tot=0;
		$('.gstamt').val('');
		$('.gstamt1').text('');
		$('.total').val('');
		$('.total1').text('');
		$('.subtot').text('');
	 $('.fees').each(function(){
		 if($(this).val() != ''){
		 sub_tot+=parseInt($(this).val());}
	 });
	 /*if($('.penalty').val() != ''){
	 sub_tot+=parseInt($('.penalty').val());}*/
	   
	   if($('.gst_stat').val() == 1){
	  var gst = ($('.gst_val').val()/100);
       var tot = (gst * sub_tot).toFixed();
	   $('.total').val(parseInt(tot)+parseInt(sub_tot));
	   $('.total1').text(parseInt(tot)+parseInt(sub_tot));
	   $('.gstamt').val(tot);
	   $('.gstamt1').text(tot);
	   $('.subtot').text(sub_tot);
	   }else{
	   $('.total').val(parseInt(sub_tot));
	   $('.total1').text(parseInt(sub_tot));
	   $('.subtot').text(sub_tot);}
	   
		var inst=0;
  $('.instlmnt').each(function(){
		 if($(this).val() != ''){
		 var tot = $('.total').val();
  var inst = ($(this).val()/100);
  var tota = (inst * tot).toFixed();
  var inp = $(this).parent().parent().parent().find('input:last').val(tota);
  $(this).parent().parent().parent().find('span:last').text(tota);
		 inst+=parseInt(tota);}
	 });
	 var inst1=0;
	   if($('.interest').val()!=''){
		   $('.inslmnt').each(function(){
		 if($(this).val() != ''){
		 inst1+=parseInt($(this).val());}
	 });
  var interest=$('.interest').val();
  var total=parseInt(inst1)+parseInt(interest);	
    $('.interest1').text(total);
	}
	
	 });
	</script>
	<script type="text/javascript">

$(document).ready(function(){
    
       //var counter = cnt1; 
       var counter = 0; 
    $("#addButton").click(function () {
		counter1= +$('#count').val() +1;
		$('#count').val(counter1);
		counter=$('#count').val();
		if(counter>5){
		$('#count').val('5');	
		}
                
    if(counter>5){
            alert("Only 5 installments allowed");
            return false;
    }   
        
    var newTextBoxDiv = $(document.createElement('div'))
         .attr("id", 'TextBoxDiv' + counter);
		 
	var html = '';
    html += '<div class="row">';	
    html += '<div class="col-md-3">';	
    html += '<label class="inst">Installment #'+ counter + ' (%): </label>';	
    html += '<span class="insta"><input type="number" class="form-control instlmnt" name="installment_perc' + counter + '" id="textbox' + counter + '" value="" ></span>';	
    html += '</div>';	
	html += '<div class="col-md-2">';
	html += '<span class="instd"><input type="date" class="form-control instlmntd" name="installment_date' + counter + '" id="textboxd' + counter + '" data-date="" data-date-format="DD MMMM YYYY" value="" ></span>';
    html += '</div>';	
	html += '<div class="col-md-6">';
	html += '<div class="form-group" style="float:right!important">';
	html += '<label><h6><b><input type="hidden" name="installment'+ counter + '" class="form-control inslmnt installment'+ counter + '" style="width:100px;"><span class="installment'+ counter + '1"></span></b></h6></label>';
	html += '</div>';
	html += '</div>';
    html += '</div>';	
                
    newTextBoxDiv.after().html(html);
            
    newTextBoxDiv.appendTo("#TextBoxesGroup");

                
    //counter++;
     });

     $("#removeButton").click(function () {
    if(counter==1){
          alert("No more textbox to remove");
          return false;
       }   
        
    //counter--;
	    if($('#count').val()==5){counter=5;}
	    if($('#count').val()<5){
		counter=$('#count').val();}
		 counter1= +$('#count').val() -1;
		$('#count').val(counter1);
		if(counter<1){
		$('#count').val('0');	
		}
            
        $("#TextBoxDiv" + counter).remove();
		
		$('.interest1').text(''); 
		 if($('.interest').val()!=''){
		var inst=0;
  $('.inslmnt').each(function(){
		 if($(this).val() != ''){
		 inst+=parseInt($(this).val());}
	 });
  var interest=$('.interest').val();	
  var total=parseInt(inst)+parseInt(interest);	
    $('.interest1').text(total);
	}
            
     });
        
     $("#getButtonValue").click(function () {
        
    var msg = '';
    for(i=1; i<counter; i++){
   	  msg += "\n Textbox #" + i + " : " + $('#textbox' + i).val();
    }
    	  alert(msg);
     });
  });
</script>
<script>
$(document.body).on('keyup', '.instlmnt', function(){
  var ins_id=$(this).attr('id');  
  var suffix = ins_id.match(/\d+/); 
	$('.installment'+ suffix + '').val('');
    $('.installment'+ suffix + '1').text('');
    $('.interest1').text('');
  var tot = $('.total').val();
  var inst = ($(this).val()/100);
  var tota = (inst * tot).toFixed();
    $('.installment'+ suffix + '').val(tota);
    $('.installment'+ suffix + '1').text(tota);
	if($('.interest').val()!=''){
		var inst=0;
  $('.inslmnt').each(function(){
		 if($(this).val() != ''){
		 inst+=parseInt($(this).val());}
	 });
  var interest=$('.interest').val();	
  var total=parseInt(inst)+parseInt(interest);	
    $('.interest1').text(total);
	}
     });
</script>
<script>
$(document.body).on('keyup', '.interest', function(){
  var inst=0;
  $('.inslmnt').each(function(){
		 if($(this).val() != ''){
		 inst+=parseInt($(this).val());}
	 });
  var interest=$(this).val();	
  var total=parseInt(inst)+parseInt(interest);	
    $('.interest1').text(total);
     });
</script>
<script>
$(document.body).on('click', '.submit', function(e){
  var inst=0;
  if($('.inslmnt').length>0){
  $('.inslmnt').each(function(){
		 if($(this).val() != ''){
		 inst+=parseInt($(this).val());}
	 });
  var total=$('.total').val();	 
  if(total==inst)	{
	  $('#myForm').submit();
  } else{
      e.preventDefault();
	  alert('Please Check the Total and Installments!!');
	  return false;
  }
  }else{
	  $('#myForm').submit();
  }
     });
</script>
<script>
$(document.body).on('click', '.installment_status', function(e){
  var inst_stat=$(this).prop('checked');
  if(inst_stat){
	  $('.inst_stat').css('display','block');
	  $(this).val('1');
  } else{
      $('.inst_stat').css('display','none');
	  $(this).val('0');
  }
     });
</script>