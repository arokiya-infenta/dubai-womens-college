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
.id-card-back {
    width: 366px !important;
    height: 547px !important;
    margin: 40px auto;
    padding-top: 0px;
    box-shadow: 0 0 12px 0 #22222230;
    border-radius: 16px;
	background:#fff;
}
.id-card-back table tr td:nth-child(1) {
    font-weight: 600;
	width: 28%;
}
.id-card-back table tr td {
    padding-bottom: 12px;
    color: #101010;
    font-size: 13px;
    line-height: 16px;
    font-weight: 500;
}
.id-card-back table {
    padding-left: 20px;
    font-family: 'Roboto' !important;
    font-size: 15px !important;
	margin-left: 15px;
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
    line-height: 16px;
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
</style>
<div class="id-card-back">
<div class="back_btm"><img src="<?php echo base_url().'system/images/IDGenerate/Curve.png'?>"></div>

<table width="100%">
<tbody>
<tr>
<td>Blood Group</td>
<td>A1+ve</td>
</tr>
<tr>
<td>Phone No.</td>
<td><?=$stu_list->mobile_number_?></td>
</tr>
<tr>
<td style="
    position: relative;
    top: -21px;
">Address</td>
<td><?=$stu_list->address_?></td>
</tr>
</tbody>
</table>
<div class="ins">
<p><strong>Instructions:</strong></p>
<ol>
<li>The card should always be displayed by the holder
while on campus.</li>
<li>Loss of card should be reported to Administrative
officer (AO) immediately.</li>
<li>If found, please return to MSSW.</li>

</ol>
</div>
<div class="sign"><img src="<?php echo base_url().'system/images/IDGenerate/Sign.png'?>"></div>
<div class="btm">
<h5>MADRAS SCHOOL OF SOCIAL WORK
(AUTONOMOUS)</h5>
<p>32, Casa Major Road,
<br>Egmore, Chennai – 600 008</p>
<p>Ph: 044 28194566</p>
</div>
</div>
	<!--End content-wrapper-->
   <!--Start Back To Top Button-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	</body>
</html>