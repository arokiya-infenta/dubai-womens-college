<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <style>
   input[type=checkbox]{
     height: 20px!important;
     width: 20px!important;
   }
   </style>
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

      <!--Start Dashboard Content-->
	 <!--Start Row-->
	 <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i>Subject Policy</div>
            <div class="card-body">
              <form action="" method="POST">
            <div class="row">
			  <div class="col-lg-3">
          <label>Policy Name</label>
			  <input type="text" class="form-control" name="name" value="<?=$policy_list->name?>">
			  <input type="hidden" class="form-control" name="edit_id" value="<?=$policy_list->id?>">
			  <span style="color:red;"><?php echo form_error('name'); ?></span>
			  </div>
        <div class="col-lg-3">
          <label>Minimum Pass Mark</label>
			  <input type="text" class="form-control" name="minMark" value="<?=$policy_list->minMark?>">
			  <span style="color:red;"><?php echo form_error('minMark'); ?></span>
			  </div>
            </div>
            <div class="row mt-3">
        <div class="col-lg-3 mt-3">
			  <input type="checkbox" name="hasESE" value="<?=$policy_list->hasESE?>"> Has ESE
			  </div>
        <div class="col-lg-3">
          <label>Maximum Mark</label>
			  <input type="text" class="form-control intMark" name="eseMaxMark" data-initial-value="<?=$policy_list->eseMaxMark?>" value="<?=$policy_list->eseMaxMark?>">
			  <span style="color:red;"><?php echo form_error('eseMaxMark'); ?></span>
			  </div>
        <div class="col-lg-3">
          <label>Minimum Pass Mark</label>
			  <input type="text" class="form-control intMark" name="eseMinMark" data-initial-value="<?=$policy_list->eseMinMark?>" value="<?=$policy_list->eseMinMark?>">
        <span style="color:red;"><?php echo form_error('eseMinMark'); ?></span>
			  </div>
        <div class="col-lg-3">
          <label>Mark Entry For</label>
			  <input type="text" class="form-control intMark" name="eseMarkEntry" data-initial-value="<?=$policy_list->eseMarkEntry?>" value="<?=$policy_list->eseMarkEntry?>">
        <span style="color:red;"><?php echo form_error('eseMarkEntry'); ?></span>
			  </div>
            </div>
            <div class="row mt-3">
			  <div class="col-lg-3 mt-3">
			  <input type="checkbox" name="hasICA" value="<?=$policy_list->hasICA?>"> Has ICA
			  </div>
        <div class="col-lg-3">
          <label>Maximum Mark</label>
			  <input type="text" class="form-control intMark" name="icaMaxMark" data-initial-value="<?=$policy_list->icaMaxMark?>" value="<?=$policy_list->icaMaxMark?>">
			  <span style="color:red;"><?php echo form_error('icaMaxMark'); ?></span>
			  </div>
        <div class="col-lg-3">
          <label>Minimum Pass Mark</label>
			  <input type="text" class="form-control intMark" name="icaMinMark" data-initial-value="<?=$policy_list->icaMinMark?>" value="<?=$policy_list->icaMinMark?>">
        <span style="color:red;"><?php echo form_error('icaMinMark'); ?></span>
			  </div>
        <div class="col-lg-3">
          <label>Mark Entry For</label>
			  <input type="text" class="form-control intMark" name="icaMarkEntry" data-initial-value="<?=$policy_list->icaMarkEntry?>" value="<?=$policy_list->icaMarkEntry?>">
        <span style="color:red;"><?php echo form_error('icaMarkEntry'); ?></span>
			  </div>
            </div>
            <div class="row mt-5">
			  <div class="col-lg-7">
			  <input type="checkbox" name="intMark" value="<?=$policy_list->intMark?>"> Is System Calculate Internal Marks
			  </div>
            </div>
            <div class="sysCalc">
            <div class="row mt-3">
        <div class="col-lg-4 mt-4">
			  <input type="checkbox" name="inCls" data-initial-value="<?=$policy_list->inCls?>" value="<?=$policy_list->inCls?>"> In-Class Test
			  </div>
        <div class="col-lg-4">
			  <label>Alloted Mark</label><input type="text" class="form-control intMark" name="clsTestAlc" data-initial-value="<?=$policy_list->clsTestAlc?>" value="<?=$policy_list->clsTestAlc?>">
			  </div>
        <div class="col-lg-4">
			  <label>Minimum Pass Mark</label><input type="text" class="form-control intMark" name="clsTestMin" data-initial-value="<?=$policy_list->clsTestMin?>" value="<?=$policy_list->clsTestMin?>">
			  </div>
            </div>
            <div class="row">
        <div class="col-lg-4 mt-4">
			  <input type="checkbox" name="intExam" data-initial-value="<?=$policy_list->intExam?>" value="<?=$policy_list->intExam?>"> Internal Exams
			  </div>
        <div class="col-lg-4">
			  <label>Alloted Mark</label><input type="text" class="form-control intMark" name="intAlc" data-initial-value="<?=$policy_list->intAlc?>" value="<?=$policy_list->intAlc?>">
			  </div>
        <div class="col-lg-4">
			  <label>Pass Mark</label><input type="text" class="form-control intMark" name="intMin" data-initial-value="<?=$policy_list->intMin?>" value="<?=$policy_list->intMin?>">
			  </div>
            </div>
            <div class="row">
        <div class="col-lg-4 mt-4">
			  <input type="checkbox" name="attendance" data-initial-value="<?=$policy_list->attendance?>" value="<?=$policy_list->attendance?>"> Attendance
			  </div>
        <div class="col-lg-4">
			  <label>Alloted Mark</label><input type="text" class="form-control intMark" name="attAlc" data-initial-value="<?=$policy_list->attAlc?>" value="<?=$policy_list->attAlc?>">
			  </div>
        <div class="col-lg-4">
			  <label>Minimum Pass Mark</label><input type="text" class="form-control intMark" name="attMin" data-initial-value="<?=$policy_list->attMin?>" value="<?=$policy_list->attMin?>">
			  </div>
            </div>
            <div class="row">
        <div class="col-lg-4 mt-4">
			  <input type="checkbox" name="takeHome" data-initial-value="<?=$policy_list->takeHome?>" value="<?=$policy_list->takeHome?>"> Take-Home Assignment
			  </div>
        <div class="col-lg-4">
			  <label>Alloted Mark</label><input type="text" class="form-control intMark" name="THassAlc" data-initial-value="<?=$policy_list->THassAlc?>" value="<?=$policy_list->THassAlc?>">
			  </div>
        <div class="col-lg-4">
			  <label>Minimum Pass Mark</label><input type="text" class="form-control intMark" name="THassMin" data-initial-value="<?=$policy_list->THassMin?>" value="<?=$policy_list->THassMin?>">
			  </div>
            </div>
            <div class="row">
        <div class="col-lg-4 mt-4">
			  <input type="checkbox" name="onlyICA" data-initial-value="<?=$policy_list->onlyICA?>" value="<?=$policy_list->onlyICA?>"> Only ICA
			  </div>
        <div class="col-lg-4">
			  <label>Alloted Mark</label><input type="text" class="form-control intMark" name="icaAlc" data-initial-value="<?=$policy_list->icaAlc?>" value="<?=$policy_list->icaAlc?>">
			  </div>
        <div class="col-lg-4">
			  <label>Minimum Pass Mark</label><input type="text" class="form-control intMark" name="icaMin" data-initial-value="<?=$policy_list->icaMin?>" value="<?=$policy_list->icaMin?>">
			  </div>
            </div>
            <div class="row">
        <div class="col-lg-4 mt-4">
			  <input type="checkbox" name="clsQuiz" data-initial-value="<?=$policy_list->clsQuiz?>" value="<?=$policy_list->clsQuiz?>"> Class Quiz
			  </div>
        <div class="col-lg-4">
			  <label>Alloted Mark</label><input type="text" class="form-control intMark" name="quizAlc" data-initial-value="<?=$policy_list->quizAlc?>" value="<?=$policy_list->quizAlc?>">
			  </div>
        <div class="col-lg-4">
			  <label>Minimum Pass Mark</label><input type="text" class="form-control intMark" name="quizMin" data-initial-value="<?=$policy_list->quizMin?>" value="<?=$policy_list->quizMin?>">
			  </div>
            </div>
            <div class="row">
        <div class="col-lg-4 mt-4">
			  <input type="checkbox" name="grpProj" data-initial-value="<?=$policy_list->grpProj?>" value="<?=$policy_list->grpProj?>"> Group Project
			  </div>
        <div class="col-lg-4">
			  <label>Alloted Mark</label><input type="text" class="form-control intMark" name="projAlc" data-initial-value="<?=$policy_list->projAlc?>" value="<?=$policy_list->projAlc?>">
			  </div>
        <div class="col-lg-4">
			  <label>Minimum Pass Mark</label><input type="text" class="form-control intMark" name="projMin" data-initial-value="<?=$policy_list->projMin?>" value="<?=$policy_list->projMin?>">
			  </div>
            </div>
            <div class="row">
        <div class="col-lg-4 mt-4">
			  <input type="checkbox" name="assgnmnts" data-initial-value="<?=$policy_list->assgnmnts?>" value="<?=$policy_list->assgnmnts?>"> Assignments
			  </div>
        <div class="col-lg-4">
			  <label>Alloted Mark</label><input type="text" class="form-control intMark" name="assignAlc" data-initial-value="<?=$policy_list->assignAlc?>" value="<?=$policy_list->assignAlc?>">
			  </div>
        <div class="col-lg-4">
			  <label>Minimum Pass Mark</label><input type="text" class="form-control intMark" name="assignMin" data-initial-value="<?=$policy_list->assignMin?>" value="<?=$policy_list->assignMin?>">
			  </div>
            </div>
            <div class="row">
        <div class="col-lg-4 mt-4">
			  <input type="checkbox" name="exam" data-initial-value="<?=$policy_list->exam?>" value="<?=$policy_list->exam?>"> Exam
			  </div>
        <div class="col-lg-4">
			  <label>Alloted Mark</label><input type="text" class="form-control intMark" name="examAlc" data-initial-value="<?=$policy_list->examAlc?>" value="<?=$policy_list->examAlc?>">
			  </div>
        <div class="col-lg-4">
			  <label>Minimum Pass Mark</label><input type="text" class="form-control intMark" name="examMin" data-initial-value="<?=$policy_list->examMin?>" value="<?=$policy_list->examMin?>">
			  </div>
            </div>
            <div class="row">
        <div class="col-lg-4 mt-4">
			  <input type="checkbox" name="midTerm" data-initial-value="<?=$policy_list->midTerm?>" value="<?=$policy_list->midTerm?>"> Mid Term Exam
			  </div>
        <div class="col-lg-4">
			  <label>Alloted Mark</label><input type="text" class="form-control intMark" name="midTermAlc" data-initial-value="<?=$policy_list->midTermAlc?>" value="<?=$policy_list->midTermAlc?>">
			  </div>
        <div class="col-lg-4">
			  <label>Minimum Pass Mark</label><input type="text" class="form-control intMark" name="minTermMin" data-initial-value="<?=$policy_list->minTermMin?>" value="<?=$policy_list->minTermMin?>">
			  </div>
            </div>
            <div class="row">
        <div class="col-lg-4 mt-4">
			  <input type="checkbox" name="semExxam" data-initial-value="<?=$policy_list->semExxam?>" value="<?=$policy_list->semExxam?>"> Semester Examination
			  </div>
        <div class="col-lg-4">
			  <label>Alloted Mark</label><input type="text" class="form-control intMark" name="semAlc" data-initial-value="<?=$policy_list->semAlc?>" value="<?=$policy_list->semAlc?>">
			  </div>
        <div class="col-lg-4">
			  <label>Minimum Pass Mark</label><input type="text" class="form-control intMark" name="semMin" data-initial-value="<?=$policy_list->semMin?>" value="<?=$policy_list->semMin?>">
			  </div>
            </div>
            </div>

            <hr/>
            <button id="addRow" type="button" class="btn btn-info">Add Row</button>
            <div class="row">
                     <div class="col-lg-3">
                    <label>Mark</label>
                     </div>
                     <div class="col-sm-3">
                    <label style="margin-left: -65px;">Percentage From</label>
                     </div>
                     <div class="col-sm-3">
                    <label style="margin-left: -130px;">Percentage To</label>
                     </div>
            </div>
			<?php $get_pol = $this->db->where('policy_id',$policy_list->id)->get('erp_subpolicymark')->result();
			foreach($get_pol as $getPolcy){
			?>
            <div id="inputFormRow">
                <div class="input-group mb-3">
                  <div class="row">
                     <div class="col-sm-3">
                    <input type="text" name="mark[]" class="form-control m-input" placeholder="Mark" autocomplete="off" value="<?=$getPolcy->mark?>" required>
                     </div>
                     <div class="col-sm-3">
                    <input type="text" name="percFrom[]" class="form-control m-input" placeholder="Percentage From" value="<?=$getPolcy->percFrom?>" required>
                     </div>
                     <div class="col-sm-3">
                    <input type="text" name="percTo[]" class="form-control m-input" placeholder="Percentage To" value="<?=$getPolcy->percTo?>" required>
                     </div>
                     <div class="col-sm-1">
                    <div class="input-group-append">                
                        <button id="removeRow" type="button" class="btn btn-sm btn-danger">Delete</button>
                    </div>
                    </div>
                    </div>
                </div>
            </div>
			<?php } ?>

            <div id="newRow"></div>

          <div class="row mt-3">  
			  <div class="col-lg-11">
          <div class="form-group" style="float: right;">
			  <button class="btn btn-sm btn-success" name="submit">Submit</button>
        </div>
			  </div>
			  </div>	
              </form>
            </div>
          </div>
        </div>
      </div><!-- End Row-->

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
	var base_url = "<?php echo base_url(); ?>";
	$(document).ready(function(){
    $('.intMark').prop('readonly',true);
    $('.sysCalc').css('display','none');

    $("input[type=checkbox]").each(function () {
      $(this).val() == 'yes' ? $(this).prop('checked',true):$(this).prop('checked',false);
      $(this).is(':checked') ? $(this).val('yes'):$(this).val('no');
      var a = $(this).parent().parent().find('.intMark');
      $(this).is(':checked') ? a.prop('readonly',false) : a.prop('readonly',true);
    });
    $('input[name=intMark]').is(':checked') ?$('.sysCalc').css('display','block'):$('.sysCalc').css('display','none');
	
    $("input[type=checkbox]").click(function () {
      $(this).is(':checked') ? $(this).val('yes'):$(this).val('no');
      var a = $(this).parent().parent().find('.intMark');
      $(this).is(':checked') ? a.prop('readonly',false) : a.prop('readonly',true);
      
      $(this).is(':checked') ? a.each(function () {
      var oldValue = $(this).attr("data-initial-value");
      $(this).val(oldValue);
    }) : a.each(function () {
      $(this).val('');
    }) ;

    });

    $("input[name=intMark]").click(function () {
      var b = $('.sysCalc');
      $(this).is(':checked') ? b.css('display','block') : b.css('display','none');

      var a = b.find('input[type=checkbox]');
      $(this).is(':checked') ? a.each(function () {
        $(this).attr("data-initial-value") == 'yes' ? $(this).prop('checked',true):$(this).prop('checked',false);
        $(this).val($(this).attr("data-initial-value"));
      var c = $(this).parent().parent().find('.intMark');
      $(this).is(':checked') ? 
      c.each(function () {
      var oldValue1 = $(this).attr("data-initial-value");
      $(this).val(oldValue1);
      $(this).prop('readonly',false);
    }) : c.each(function () {
      $(this).val('');
    });
    }) : a.each(function () {
      $(this).prop('checked',false);
      $(this).val('no');
      var c = $(this).parent().parent().find('.intMark');
      c.each(function () {
        $(this).val('');
    });
    }) ;

    });
	});
	</script>
  <script type="text/javascript">
    // add row
    $("#addRow").click(function () {
        var html = '';
        html += '<div id="inputFormRow">';
        html += '<div class="input-group mb-3">';
        html += '<div class="row">';
        html += '<div class="col-sm-3">';
        html += '<input type="text" name="mark[]" class="form-control m-input" placeholder="Mark" autocomplete="off">';
        html += '</div>';
        html += '<div class="col-sm-3">';
        html += '<input type="text" name="percFrom[]" class="form-control m-input" placeholder="Percentage From" autocomplete="off">';
        html += '</div>';
        html += '<div class="col-sm-3">';
        html += '<input type="text" name="percTo[]" class="form-control m-input" placeholder="Percentage To" autocomplete="off">';
        html += '</div>';
        html += '<div class="col-sm-1">';
        html += '<div class="input-group-append">';                
        html += '<button id="removeRow" type="button" class="btn btn-sm btn-danger">Delete</button>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        $('#newRow').append(html);
    });

    // remove row
    $(document).on('click', '#removeRow', function () {
        $(this).closest('#inputFormRow').remove();
    });
</script>