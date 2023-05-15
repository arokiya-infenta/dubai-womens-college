<!DOCTYPE HTML>
<html>
<head>
<meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta charset="utf-8">
    <title>Create PDF</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
</head>
<body>	
<div class="clearfix"></div>
  <div class="content-wrapper">
    <div class="container-fluid">
	<div class="profile-main">
		<div class="profile-header">
			<div class="user-detail">
				<div class="user-image">
<?php if($user[0]->pr_photo == "" || $user[0]->pr_photo == NULL ){echo"<h3>Image not uploaded";}else{?>
					<img src="<?=base_url()?>admin/uploads/<?=$user[0]->pr_photo?>">
<?php } ?>      
				</div>
				<!--<div class="user-data">
					<h2><?=$user[0]->pr_applicant_name?></h2>
				</div>-->
			</div>
			<div class="tab-panel-main">
<?php
//$qta =	$this->db->select("*")->from("Applyed_Master")->where("user_id",$user[0]->pr_user_id)->where("main_course_priority",'PG')->get();
$studreg =	$this->db->select("u_email_id,u_mobile")->from("stu_user")->where("u_id",$user[0]->pr_user_id)->get();
$stuser = $studreg->result();		
 ?>
 



				<div id="Basic-detail" class="tab-content current">
						 <h2><i class="fa fa-user" aria-hidden="true"></i> Basic Details</h2>
				<div style="overflow-x:auto;">
        <table class="table" id="myTable">

    
           <tr>
                        <th>Name </th>
                        <td><?=$user[0]->pr_applicant_name?></td>
                    </tr><tr>
                        <th>Email Id </th>
                        <td><?=$stuser[0]->u_email_id?></td>
                    </tr><tr>
                        <th>Mobile Number </th>
                        <td><?=$stuser[0]->u_mobile?></td>
                    </tr>
                  <tr>
                        <th>Mother Tongue </th>
                        <td><?=$user[0]->pr_mother_toung?></td>
                    </tr>
                    <tr>
                        <th>Place of Birth </th>
                        <td><?=$user[0]->pr_place_of_birth?></td>
                    </tr>
                    <tr>
                        <th>Date of Birth</th>
                        <td><?=date('d-M-Y',strtotime($user[0]->pr_dob))?></td>
                    </tr>
                    <tr>
                        <th>Age</th>
                        <td><?=$user[0]->pr_age?></td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td><?=$user[0]->pr_gender?></td>
                    </tr>
                    <tr>
                        <th>Nationality</th>
                        <td><?=$user[0]->pr_nationality?></td>
                    </tr> 
                    <tr>
                        <th>Religion</th>
                        <td><?=$user[0]->pr_religion?></td>
                    </tr>  <tr>
                        <th>Caste</th>
                        <td><?=$user[0]->pr_caste?></td>
                    </tr>  <tr>
                        <th>Community</th>
                        <td><?=$user[0]->pr_community?></td>
                    </tr>  
                </table>
                <h3>Parent's / Guardian's Details</h3>
                <table class="table" id="myTable">
                <tr>
      <th>#</th>
      <th>Father</th>
      <th>Mother</th>
      <th>Guardian</th>
    <tr>
    <th>Name</th>
      <td><?=$user[0]->pr_father_name?></td>
      <td><?=$user[0]->pr_mother_name?></td>
      <td><?=$user[0]->pr_gaurdion_name?></td>
    </tr>
    <tr>
    <th>E-Mail Id</th>
    <td><?=$user[0]->pr_father_email?></td>
      <td><?=$user[0]->pr_mother_email?></td>
      <td><?=$user[0]->pr_gaurdion_email?></td>
    </tr>
    <tr>
    <th>Mobile No.</th>
    <td><?=$user[0]->pr_father_mobnum?></td>
      <td><?=$user[0]->pr_mother_mobnum?></td>
      <td><?=$user[0]->pr_gaurdion_mobnum?></td>
    </tr>
    <tr>
    <th>Occupation</th>
    <td><?=$user[0]->pr_father_accu?></td>
      <td><?=$user[0]->pr_mother_accu?></td>
      <td><?=$user[0]->pr_gaurdion_accu?></td>
    </tr>
    <tr>
    <th>Annual
Income</th>
<td><?=$user[0]->pr_father_anuval_income?></td>
      <td><?=$user[0]->pr_mother_anuval_income?></td>
      <td><?=$user[0]->pr_gaurdion_anuval_income?></td>
    </tr>   
                </table>
                <h3>Address</h3>
                <table class="table" id="myTable">
                <tr>
      <th>#</th>
      <th>Local Address</th>
      <th>Permanant</th>
    <tr>
    <th>Address</th>
      <td><?=$user[0]->pr_local_address?></td>
      <td><?=$user[0]->pr_permanent_address?></td>
    </tr>
   
    <tr>
    <th>City</th>
    <td><?=$user[0]->pr_local_city?></td>
      <td><?=$user[0]->pr_permanent_city?></td>
    </tr>
    <tr>
    <th>State</th>
    <td><?=$user[0]->pr_local_state?></td>
      <td><?=$user[0]->pr_permanent_state?></td>
    </tr>    
    <tr>
    <th>Country</th>
    <td><?=$user[0]->pr_local_country?></td>
      <td><?=$user[0]->pr_permanent_country?></td>
    </tr>   
    <tr>
    <th>Pincode</th>
    <td><?=$user[0]->pr_local_pincode?></td>
      <td><?=$user[0]->pr_permanent_pincode?></td>
    </tr>   
                </table>
                <h3>Identification Marks</h3>
                <table class="table" id="myTable">
                 <tr>
                     <th>1</th>
                     <td><?=$user[0]->pr_identification_one?></td>
                 </tr>
                 <tr>
                     <th>2</th>
                     <td><?=$user[0]->pr_identification_two?></td>
                 </tr>
             </table>
             <h3>Differently Abled </h3>
                <table class="table" id="myTable">
                <?php  if($user[0]->pr_differently_abled == "" || $user[0]->pr_differently_abled == NULL){echo"";}
                else if($user[0]->pr_differently_abled=="NO"){
          echo"<tr>
          <th>No</th>
          <td></td>
          </tr>";
                }else if($user[0]->pr_differently_abled=="YES"){
                  echo"<tr>
                  <th>".$user[0]->pr_differently_abled."</th>
                  <td>".$user[0]->pr_differently_abled_reson."</td>
                  </tr>";
                  if($user[0]->pr_abled_certificate =="" || $user[0]->pr_abled_certificate ==Null){
                    echo"<tr><th>Disabled  Certificate</th><td>Not Uploaded</td></tr>";
                                             }else{
                  echo"<tr><th>Disabled  Certificate</th><td><a target='_blank' href='".base_url()."Home/UploadFile?file=".urlencode($user[0]->pr_abled_certificate)."' >Download</a></td></tr>";
                                             } 
                }
                   ?>
             </table>
</div>
				</div>
			</div>
		</div>
		<div style="clear: both;"></div>
	</div>
	</div>
	</div>
	
<style>

table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}
th, td {
  text-align: left;
padding: 12px 25px;
}
.profile-main{
  width: 100%;
  margin: 0 auto;
 /* border: 1px solid #aed5e2; */
  padding-bottom: 10px;
}
.bio-box{
  float: left;
  width: 56%;
  border:1px solid #ededed;
  border-radius: 4px;
}
tr:nth-child(even) {
background-color: #f2f2f2;
}
.detail-box{
  float: right;
  width: 32%;
  border:1px solid #ededed;
  padding: 13px;
  border-radius: 4px;
}
.bio-box .desc{
  padding: 10px 10px 10px 10px;
  text-align: justify;
  color: #838383;
  font-size: 13px;
}
.detail-box{
  padding: 10px;
  font-size: 13px;
}
#Portfolio{
  float: left;
  padding-left: 0px;
  padding-right: 0px; 
  width: 100%;  
}
.portfolio-box{
  border: 1px solid #ededed;
  border-radius: 4px;
  padding: 0px 20px;
  float: left;
  height: 220px;
}
#Basic-detail{
/*  height: 210px;   */
  float: left;
  padding-left: 0px;
  padding-right: 0px; 
  width: 100%;
}
@media (min-width: 320px) and (max-width: 640px){
  .profile-main{
    width: 100%;
  }
  .user-detail{
    width: 95%;
  }
  .user-data{
    width: 51%;
    margin-bottom: 27px;
  }
  .msg-btn{
    float: left;
    height: 18px;
    margin-right: 10px;
  }
  .bio-box{
    width: 100%;
    margin-bottom: 10px;
  }
  .detail-box{
    width: 100%;
    float: left;
    padding: 0;
  }
  .detail-box p{
    padding: 10px;
    padding-bottom: 10px;
    padding-bottom: 0;
  }
  #Portfolio, #Edu-detail, #Basic-detail{
    height: auto;
  }
}
</style>	

</body>
</html>
