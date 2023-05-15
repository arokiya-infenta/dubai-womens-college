<!DOCTYPE html>

<html>

<head>

<title></title>

</head>

<body>
<?php

$str = 'KVBAVICHI|KVB001|NA|2.00|NA|NA|NA|INR|NA|R|kvbavichi|NA|NA|F|NA|NA|NA|NA|NA|NA|NA|';

$checksum = hash_hmac('sha256',$str,'checksum-key', false);
//$checksum = hash_hmac('sha256',$str,'PsbbPl3dR6HCRz432un1XozZkyuwNiBn', false);
$checksum = strtoupper($checksum);
echo $checksum; 
$Strr = $str ."|". $checksum;



?>
<form name="billdesk_pg" method="POST" action="https://pgi.billdesk.com/pgidsk/PGIMerchantPayment" enctype="application/x-www-form-urlencoded">

                              <input type="hidden" name="msg" value="<?=$Strr?>">
<?php //secho $msg ; ?>
                              <input type="submit" name="Save">

               </form>

 

</body>

</html>