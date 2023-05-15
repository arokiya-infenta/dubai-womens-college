<!DOCTYPE html>
<html>
<head>

<title>Payment Successful</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

<div class="row">
<div class="pymt_scs">
<p class="pymt_ttl">Application Successfull Submitted!</p>
<p class="pymt_cn">Payment Status : 


<?php  




if ($status == "0300") {
    echo "Success";
} else  {
    echo "Failed";
} 













?></p>
<p class="pymt_btn"><a href="<?=base_url()?>">Return Home</a></p>
</div>
</div>

</body>



</html>





<style>


.pymt_scs {
    text-align: center;
    box-shadow: 0px 0px 5px 0px #b2b2b2;
    margin: auto 26pc;
    border-radius: 3px;
    padding: 40px 100px 60px 100px;
    position: relative;
    top: 8pc;
}
p.pymt_ttl:before {
    content: '\f058';
    font-family: fontawesome;
    display: block;
    color: #00ea89;
    font-size: 70px;
    margin-bottom: 20px;
}

p.pymt_ttl {
    color: #2e2482;
    font-size: 30px;
    font-weight: 600;
    margin-bottom: 10px;
}
p.pymt_btn a:hover {
    background: #140c5d;
}
p.pymt_btn {
    margin-top: 60px;
}
p.pymt_btn a {
    background: #2e2482;
    color: #fff;
    font-size: 16px;
    padding: 10px 16px;
    border-radius: 3px;
    text-decoration: none;
}

</style>