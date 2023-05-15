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
			  <input type="text" class="form-control" name="name">
			  <span style="color:red;"><?php echo form_error('name'); ?></span>
			  </div>
        <div class="col-lg-3">
          <label>Minimum Pass Mark</label>
			  <input type="text" class="form-control" name="minMark">
			  <span style="color:red;"><?php echo form_error('minMark'); ?></span>
			  </div>
            </div>
            <div class="row mt-3">
        <div class="col-lg-3 mt-3">
			  <input type="checkbox" name="hasESE" value="no"> Has ESE
			  </div>
        <div class="col-lg-3">
          <label>Maximum Mark</label>
			  <input type="text" class="form-control intMark" name="eseMaxMark">
			  <span style="color:red;"><?php echo form_error('eseMaxMark'); ?></span>
			  </div>
        <div class="col-lg-3">
          <label>Minimum Pass Mark</label>
			  <input type="text" class="form-control intMark" name="eseMinMark">
        <span style="color:red;"><?php echo form_error('eseMinMark'); ?></span>
			  </div>
        <div class="col-lg-3">
          <label>Mark Entry For</label>
			  <input type="text" class="form-control intMark" name="eseMarkEntry">
        <span style="color:red;"><?php echo form_error('eseMarkEntry'); ?></span>
			  </div>
            </div>
            <div class="row mt-3">
			  <div class="col-lg-3 mt-3">
			  <input type="checkbox" name="hasICA"> Has ICA
			  </div>
        <div class="col-lg-3">
          <label>Maximum Mark</label>
			  <input type="text" class="form-control intMark" name="icaMaxMark">
			  <span style="color:red;"><?php echo form_error('icaMaxMark'); ?></span>
			  </div>
        <div class="col-lg-3">
          <label>Minimum Pass Mark</label>
			  <input type="text" class="form-control intMark" name="icaMinMark">
        <span style="color:red;"><?php echo form_error('icaMinMark'); ?></span>
			  </div>
        <div class="col-lg-3">
          <label>Mark Entry For</label>
			  <input type="text" class="form-control intMark" name="icaMarkEntry">
        <span style="color:red;"><?php echo form_error('icaMarkEntry'); ?></span>
			  </div>
            </div>
            <div class="row mt-5">
			  <div class="col-lg-7">
			  <input type="checkbox" name="intMark"> Is System Calculate Internal Marks
			  </div>
            </div>
            <div class="sysCalc">
            <div class="row mt-3">
        <div class="col-lg-4 mt-4">
			  <input type="checkbox" name="inCls"> In-Class Test
			  </div>
        <div class="col-lg-4">
			  <label>Alloted Mark</label><input type="text" class="form-control intMark" name="clsTestAlc">
			  </div>
        <div class="col-lg-4">
			  <label>Minimum Pass Mark</label><input type="text" class="form-control intMark" name="clsTestMin">
			  </div>
            </div>
            <div class="row">
        <div class="col-lg-4 mt-4">
			  <input type="checkbox" name="intExam"> Internal Exams
			  </div>
        <div class="col-lg-4">
			  <label>Alloted Mark</label><input type="text" class="form-control intMark" name="intAlc">
			  </div>
        <div class="col-lg-4">
			  <label>Pass Mark</label><input type="text" class="form-control intMark" name="intMin">
			  </div>
            </div>
            <div class="row">
        <div class="col-lg-4 mt-4">
			  <input type="checkbox" name="attendance"> Attendance
			  </div>
        <div class="col-lg-4">
			  <label>Alloted Mark</label><input type="text" class="form-control intMark" name="attAlc">
			  </div>
        <div class="col-lg-4">
			  <label>Minimum Pass Mark</label><input type="text" class="form-control intMark" name="attMin">
			  </div>
            </div>
            <div class="row">
        <div class="col-lg-4 mt-4">
			  <input type="checkbox" name="takeHome"> Take-Home Assignment
			  </div>
        <div class="col-lg-4">
			  <label>Alloted Mark</label><input type="text" class="form-control intMark" name="THassAlc">
			  </div>
        <div class="col-lg-4">
			  <label>Minimum Pass Mark</label><input type="text" class="form-control intMark" name="THassMin">
			  </div>
            </div>
            <div class="row">
        <div class="col-lg-4 mt-4">
			  <input type="checkbox" name="onlyICA"> Only ICA
			  </div>
        <div class="col-lg-4">
			  <label>Alloted Mark</label><input type="text" class="form-control intMark" name="icaAlc">
			  </div>
        <div class="col-lg-4">
			  <label>Minimum Pass Mark</label><input type="text" class="form-control intMark" name="icaMin">
			  </div>
            </div>
            <div class="row">
        <div class="col-lg-4 mt-4">
			  <input type="checkbox" name="clsQuiz"> Class Quiz
			  </div>
        <div class="col-lg-4">
			  <label>Alloted Mark</label><input type="text" class="form-control intMark" name="quizAlc">
			  </div>
        <div class="col-lg-4">
			  <label>Minimum Pass Mark</label><input type="text" class="form-control intMark" name="quizMin">
			  </div>
            </div>
            <div class="row">
        <div class="col-lg-4 mt-4">
			  <input type="checkbox" name="grpProj"> Group Project
			  </div>
        <div class="col-lg-4">
			  <label>Alloted Mark</label><input type="text" class="form-control intMark" name="projAlc">
			  </div>
        <div class="col-lg-4">
			  <label>Minimum Pass Mark</label><input type="text" class="form-control intMark" name="projMin">
			  </div>
            </div>
            <div class="row">
        <div class="col-lg-4 mt-4">
			  <input type="checkbox" name="assgnmnts"> Assignments
			  </div>
        <div class="col-lg-4">
			  <label>Alloted Mark</label><input type="text" class="form-control intMark" name="assignAlc">
			  </div>
        <div class="col-lg-4">
			  <label>Minimum Pass Mark</label><input type="text" class="form-control intMark" name="assignMin">
			  </div>
            </div>
            <div class="row">
        <div class="col-lg-4 mt-4">
			  <input type="checkbox" name="exam"> Exam
			  </div>
        <div class="col-lg-4">
			  <label>Alloted Mark</label><input type="text" class="form-control intMark" name="examAlc">
			  </div>
        <div class="col-lg-4">
			  <label>Minimum Pass Mark</label><input type="text" class="form-control intMark" name="examMin">
			  </div>
            </div>
            <div class="row">
        <div class="col-lg-4 mt-4">
			  <input type="checkbox" name="midTerm"> Mid Term Exam
			  </div>
        <div class="col-lg-4">
			  <label>Alloted Mark</label><input type="text" class="form-control intMark" name="midTermAlc">
			  </div>
        <div class="col-lg-4">
			  <label>Minimum Pass Mark</label><input type="text" class="form-control intMark" name="minTermMin">
			  </div>
            </div>
            <div class="row">
        <div class="col-lg-4 mt-4">
			  <input type="checkbox" name="semExxam"> Semester Examination
			  </div>
        <div class="col-lg-4">
			  <label>Alloted Mark</label><input type="text" class="form-control intMark" name="semAlc">
			  </div>
        <div class="col-lg-4">
			  <label>Minimum Pass Mark</label><input type="text" class="form-control intMark" name="semMin">
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
            <div id="inputFormRow">
                <div class="input-group mb-3">
                  <div class="row">
                     <div class="col-sm-3">
                    <input type="text" name="mark[]" class="form-control m-input" placeholder="Mark" autocomplete="off" required>
                     </div>
                     <div class="col-sm-3">
                    <input type="text" name="percFrom[]" class="form-control m-input" placeholder="Percentage From" autocomplete="off" required>
                     </div>
                     <div class="col-sm-3">
                    <input type="text" name="percTo[]" class="form-control m-input" placeholder="Percentage To" autocomplete="off" required>
                     </div>
                     <div class="col-sm-1">
                    <div class="input-group-append">                
                        <button id="removeRow" type="button" class="btn btn-sm btn-danger">Delete</button>
                    </div>
                    </div>
                    </div>
                </div>
            </div>

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
		$('input[type=checkbox]').val('no');
    $('.intMark').prop('readonly',true);
    $('.sysCalc').css('display','none');
	
    $("input[type=checkbox]").click(function () {
      $(this).is(':checked') ? $(this).val('yes'):$(this).val('no');
      var a = $(this).parent().parent().find('.intMark');
      $(this).is(':checked') ? a.prop('readonly',false) : a.prop('readonly',true);
      $(this).is(':checked') ? a.val('') : a.val('');
    });

    $("input[name=intMark]").click(function () {
      var b = $('.sysCalc');
      $(this).is(':checked') ? b.css('display','block') : b.css('display','none');
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