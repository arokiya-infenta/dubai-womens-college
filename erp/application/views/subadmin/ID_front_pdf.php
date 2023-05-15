<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0"><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><meta name="format-detection" content="telephone=no">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
<title>ID</title>
</head>
<body>
<style>
body {
    background: #d7d7d7;
}
.id-card-front img {
    width: 88%;
    margin: 0 20px;
}
.id-card-front {
    width: 366px !important;
    height: 540px !important;
    margin: 40px auto;
    padding-top: 28px;
    box-shadow: 0 0 12px 0 #22222230;
    border-radius: 16px;
	background:#fff;
}
.id-card-front h3 {
    text-align: center;
    font-family: 'Roboto', sans-serif;
    letter-spacing: 6px;
    font-size: 24px;
    font-weight: 800;
	margin-left: 5px;
}
img.stud-img {
    width: 100px;
    margin: 40px 0px 10px -230px;
    padding-top: 20px;
}
.id-card-front table tr td:nth-child(1) {
    font-weight: 600;
}
.id-card-front table tr td {
    padding-bottom: 12px;
    color: #101010;
    font-size: 13px;
    line-height: 21px;
    font-weight: 500;
}
.id-card-front table {
    padding-left: 20px;
    font-family: 'Roboto' !important;
    font-size: 15px !important;
}

.id-card-front {
    width: 366px !important;
    height: 540px !important;
    margin: 40px auto;
    padding-top: 28px;
    box-shadow: 0 0 12px 0 #22222230;
    border-radius: 16px;
}
.ins ol li {
    font-family: 'Roboto' !important;
    margin-bottom: 8px;
    font-size: 13px;
    color: #101010 !important;
    margin-right: 10px;
    font-weight: 500;
}

.ins p {
    font-family: 'Roboto' !important;
    padding-left: 23px;
	font-size: 14px;
}
.btm p {
    line-height: 22px;
    font-size: 14px;
}

.btm {
    background: #f2f2f2;
    padding: 2px;
    text-align: center;
    font-family: 'Roboto' !important;
    font-weight: 500;
	border-bottom-left-radius: 16px;
	border-bottom-right-radius: 16px;
}
.btm h5 {
    font-size: 15px !important;
    margin-bottom: 0;
}
.sign {
    text-align: right;
    position: relative;
    left: -18px;
    bottom: 14px;
}
.bar-code {
    text-align: center;
}

.bar-code img {
    width: 169px;
}
.id-card-front {
    /*background-image: url(http://localhost/mssw/erp/system/images/IDGenerate/Btm-bar.png);
    background-repeat: no-repeat;
    background-position: bottom;*/
}
</style>
<div class="id-card-front">
<img class="mssw-logo" src="<?php echo base_url().'system/images/IDGenerate/MSSW_Logo.png'?>" style="padding-bottom:100px;">
<?php if($stu_list->student_image==null){$url = base_url().'system/images/IDGenerate/male-avator.jpg';}
else{$url = base_url().'system/images/IDGenerate/male-avator.jpg';}
?>
<img class="stud-img" src="<?php echo $url?>">
<h3><?=$stu_list->student_name_?></h3>
<table width="100%">
<tbody>
<tr>
<td>Regn. No.</td>
<td><?=$stu_list->reg_no_?></td>
</tr>
<tr>
<td>Program</td>
<?php $dept=$this->db->where('id',$stu_list->dept_)->get('erp_department')->row(); ?>
<td><?=$dept->dept_name_?></td>
</tr>
<tr>
<td>Batch</td>
<?php $doj=str_replace('/','-',$stu_list->doj_); $deg_p=date('Y',strtotime($doj));
if($dept->degree_=='UG'){$deg_period=date("Y", strtotime(date("Y-m-d", strtotime($doj)) . " + 3 year"));} 
else{$deg_period=date("Y", strtotime(date("Y-m-d", strtotime($doj)) . " + 2 year"));}
?>
<td><?=$deg_p?>-<?=$deg_period?></td>
</tr>
</tbody>
</table>
<div class="bar-code"><img src="<?php echo base_url().'system/images/IDGenerate/Bar-Code.png'?>"></div>
<div class="back_btm"><img src="<?php echo base_url().'system/images/IDGenerate/Btm-bar.png'?>"></div>
</div>
	<!--End content-wrapper-->
   <!--Start Back To Top Button-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	</body>
</html>