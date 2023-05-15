
<style>
.table td, .table th {
    padding: 0.5rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
    font-size: 14px;
}
ul li {
  list-style-type: none;
  background: #ffffff;
   color: black;
	 margin: 15px;
    font-size: x-large;
    font-family: ui-serif;
}
ul li:hover {
  background-color: #6e6eff;
}
.containers{
    float: left;
    margin: 10px;
}
.right{
    float: left;
    margin: 10px;
	color: blue;
	font-size: 20px;
    font-weight:bold;
}
.radio {
    width: 20px;
    position: relative;
}
.radio label {
    width: 20px;
    height: 20px;
    cursor: pointer;
    position: absolute;
    top: 0;
    left: 0;
    background: white;
    border-radius: 50px;
    box-shadow: inset 0px 1px 1px white, 3px 3px 9px rgba(0,0,0,0.5);
    border: 1px solid black;
}
.radio label:after {
    content: '';
    position: absolute;
    top: 4px;
    left: 4px;
    border: 6px solid blue;
    border-radius: 50px;
    opacity: 0;
    }
.radio label:hover::after {
    opacity: 0.3;
    }
.radio input[type=radio] {
    visibility: hidden;
}
.radio input[type=radio]:checked + label:after {
     opacity: 1;
    } 
</style>
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

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
            <div class="card-header"><i class="fa fa-file-text"></i>Enquiry</div>
            <div class="card-body">
						<h3 class="text-center font-weight-bold mb-1"><?=$en_form[0]->eq_name?></h3>
					<p class="text-center font-weight-bold mb-0"> <?=$en_form[0]->eq_title?></p>
					<p class="text-center font-weight-bold"><small class="font-weight-bold"></small></p>
                    <div class="row pb-2 p-2">
                        <div class="col-md-6">
                         <p class="mb-0"><strong>Mobile Number</strong>: <?=$en_form[0]->eq_mobile?></p>
                         <p><strong>Email Id</strong>: <?=$en_form[0]->eq_email?></p>						 
                        </div>
                        <?php  
                        if($en_form[0]->eq_upload=="" || $en_form[0]->eq_upload ==null){

                        $file="File Not Uploded";
                        }else{
                          $file="<a href='".base_url()."uploads/".$en_form[0]->eq_upload."'>Download</a>";
                        }
                        ?>
                        <div class="col-md-6 text-right">
                         <p class="mb-0"><strong>Date Enquired:</strong>: <?=date("d-M-Y",strtotime($en_form[0]->eq_recived))?></p>
                        <p><strong>Download</strong>: <?=	$file?></p>
                        </div>
                    </div>

										<div class="row pb-2 p-2">
                        <div class="col-md-6">
                        
                        			 
                        </div>
                   <div class="col-md-6 text-right">
                        <button data-toggle="modal" data-target="#exampleModalenq" class="btn btn-primary">Forward</button>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-12">
										<h3><?=$en_form[0]->eq_discription?></h3>
                    </div>
                    </div>


										<?php if($en_form[0]->eq_status == 1) {  ?>
		
		<hr>

				<div class="row">
				 <div class="col-md-4 "><h4>Last Forward : <?=$en_form[0]->eq_last_forword_?></h4> </div>
				 <div class="col-md-4 "><h4>Designation : <?=$en_form[0]->eq_last_forword_designation?></h4>
									 </div>
				 <div class="col-md-4 "><h4>Last Forward Date : <?=date("d-M-Y",strtotime($en_form[0]->eg_last_frd_Date))?></h4></div>
				</div>	
				

				<hr>


		<?php } ?>




					      </div>
          </div>
        </div>
      </div>

		

	   </div>
  </div>
	

	
	
	<div class="content-wrapper">
    <div class="container-fluid">
	 <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-file-text"></i>Enquiry Response</div>
            <div class="card-body">
						<form method="post" action="<?=base_url()?>Admin/answerEnquiry">
                    <div class="row pb-2 p-2">
                    
                    </div>

										<div class="row pb-2 p-2">
                        <div class="col-md-6">
												<textarea  name ="answer" class="form-control"></textarea>
                        			 
                        </div>
												<div class="col-md-4">




												<div class="containers">
<div class="radio">
<input type="radio" value="1" <?php if($en_form[0]->eq_status_comp == 1){echo "checked";} ?> name='f_stats' id='male' />
<label for="male"></label>
</div>
</div>
<div class="right">Open</div>
 
<div class="containers">
<div class="radio">
<input type="radio" value="2" <?php if($en_form[0]->eq_status_comp == 2){echo "checked";} ?> name='f_stats' id='female' />
<label for="female"></label>
</div>
</div>
<div class="right">Close</div>
										<!---		<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="inlineRadioOptions" <?php if($en_form[0]->eq_status_comp == 1){echo "checked";}   ?> id="inlineRadio1" value="1" />
  <label class="form-check-label" for="inlineRadio1">Open</label>
</div>

<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="inlineRadioOptions" <?php if($en_form[0]->eq_status_comp == 2){echo "checked";}   ?> id="inlineRadio2" value="2" />
  <label class="form-check-label" for="inlineRadio2">close</label>
</div>-->
<input type="hidden" name="eq_id" value="<?=$en_form[0]->eq_id?>">			 
                        </div>
                   <div class="col-md-2 text-right">
                        <button type="submit" class="btn btn-primary">submit</button>
                        </div>
                    </div>
											</form>
					      </div>
          </div>
        </div>
      </div>
	   </div>
  </div>
	
	.<div class="modal fade bd-example-modal-lg" id="exampleModalenq" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">

    <form method="post" action="<?=base_url()?>Admin/forwordEnquiry">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Forword To</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
			Search User : <input class="typeahead form-control" name="user_name" id="skill_input" type="text">
<input type="hidden" name="eq_id" value="<?=$en_form[0]->eq_id?>">
    <br><br>
		<div id="suggesstion-box"></div>
		<div id="user_details"></div>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">forward</button>
      </div>

      </form>
    </div>
  </div>
</div>




   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
		
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

	<script>
	var base_url = "<?php echo base_url(); ?>";
	$(document).ready(function(){

	
		$("#skill_input").keyup(function() {

      if($(this).val()!=""){
		$.ajax({
			type: "POST",
			url: "<?php echo base_url('Admin/getUsers'); ?>",
			data: 'keyword=' + $(this).val(),
			beforeSend: function() {
				$("#search-box").css("background", "#FFF url(LoaderIcon.gif) no-repeat 165px");
			},
			success: function(data) {
				$("#suggesstion-box").show();
				$("#suggesstion-box").html(data);
				$("#search-box").css("background", "#FFF");


				$(".names_emp").click(function() {

var tnt = $(this).text();

$("#skill_input").val(tnt);
	$("#suggesstion-box").hide()
//alert(tnt);
	});
			}
		});

  }else{
    $("#suggesstion-box").show();
				$("#suggesstion-box").html("");

  }

	});

});


$(".delete_post").click(function(e){
e.preventDefault();
var mnt = $(this).val();


$.ajax({
                url: base_url + "admin/delete_enquiry",
                type: 'POST',
                cache: false,
                data: {
                    delete_id: mnt,
                },
                success: function (dataResult) {
					location.reload();
                }
            });
});


	</script>
