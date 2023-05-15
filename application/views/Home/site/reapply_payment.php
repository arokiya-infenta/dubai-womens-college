<?php


//phpinfo();exit;
/**
 * @author     Sonali Dhepse.
 * @copyright  2018 STS
 */
//ob_start();
error_reporting(E_ALL);
$strNo = rand(1,1000000);

date_default_timezone_set('Asia/Calcutta');

//echo date_default_timezone_get();

$strCurDate = date('d-m-Y');

/* require_once 'TransactionRequestBean.php';

require_once 'TransactionResponseBean.php'; */

//session_start();

if($_POST && isset($_POST['submit'])){
    $val = $_POST;
   

    $_SESSION['iv'] = $val['iv'];
    $_SESSION['key']   = $val['key'];

    $transactionRequestBean = new TransactionRequestBean();

    //Setting all values here
    //$transactionRequestBean->setMerchantCode($val['mrctCode']);
    $transactionRequestBean->merchantCode = $val['mrctCode'];
    $transactionRequestBean->accountNo = $val['tpvAccntNo'];
    $transactionRequestBean->ITC = $val['itc'];
    $transactionRequestBean->mobileNumber = $val['mobNo'];
    $transactionRequestBean->customerName = $val['custname'];
    $transactionRequestBean->requestType = $val['reqType'];
    $transactionRequestBean->merchantTxnRefNumber = $val['mrctTxtID'];
    $transactionRequestBean->amount = $val['amount'];
    $transactionRequestBean->currencyCode = $val['currencyType'];
    $transactionRequestBean->returnURL = $val['returnURL'];
  //  $transactionRequestBean->s2SReturnURL = $val['s2SReturnURL'];
    $transactionRequestBean->shoppingCartDetails = $val['reqDetail'];
    $transactionRequestBean->txnDate = $val['txnDate'];
    $transactionRequestBean->bankCode = $val['bankCode'];
    $transactionRequestBean->TPSLTxnID = $val['tpsl_txn_id']; 
    $transactionRequestBean->custId = $val['custID'];
    $transactionRequestBean->cardId = $val['cardID'];
    $transactionRequestBean->key = $val['key'];
    $transactionRequestBean->iv = $val['iv'];
    $transactionRequestBean->webServiceLocator = $val['locatorURL'];
    $transactionRequestBean->MMID = $val['mmid'];
    $transactionRequestBean->OTP = $val['otp'];
    $transactionRequestBean->cardName = $val['cardName'];
    $transactionRequestBean->cardNo = $val['cardNo'];
    $transactionRequestBean->cardCVV = $val['cardCVV'];
    $transactionRequestBean->cardExpMM = $val['cardExpMM'];
    $transactionRequestBean->cardExpYY = $val['cardExpYY'];
    $transactionRequestBean->timeOut = (!empty($val['timeOut']) ? $val['timeOut'] : 30 );
 //exit('here');
    $url = $transactionRequestBean->getTransactionToken();
//print_r($url);exit;

    $responseDetails = $transactionRequestBean->getTransactionToken();
    $responseDetails = (array)$responseDetails;
    $response = $responseDetails[0];
    //print_r($response); exit;
    
    if(is_string($response) && preg_match('/^msg=/',$response)){
        //exit('here');
        $outputStr = str_replace('msg=', '', $response);
        $outputArr = explode('&', $outputStr);
        $str = $outputArr[0];

        $transactionResponseBean = new TransactionResponseBean();
        $transactionResponseBean->setResponsePayload($str);
        $transactionResponseBean->setKey($val['key']);
        $transactionResponseBean->setIv($val['iv']);

        $response = $transactionResponseBean->getResponsePayload();
       /*  echo "<pre>";
        print_r($response); */
       exit;
    }elseif(is_string($response) && preg_match('/^txn_status=/',$response)){
        //exit('txn');
     /*  echo "<pre>";
      print_r($response); */
      exit;
  }

  echo "<script>window.location = '".$response."'</script>";
  //echo "<script>window.open('".$response."', '_blank')</script>";
 // ob_flush();

}else if($_POST){

    $response = $_POST;

    if(is_array($response)){
       
        $str = $response['msg'];
    }else if(is_string($response) && strstr($response, 'msg=')){
      
        $outputStr = str_replace('msg=', '', $response);
        $outputArr = explode('&', $outputStr);
        $str = $outputArr[0];
    }else {
      
        $str = $response;
    }

    $transactionResponseBean = new TransactionResponseBean();

    $transactionResponseBean->setResponsePayload($str);
    $transactionResponseBean->key = '1954988003KTWAQS';
    $transactionResponseBean->iv = '2319966707XGLFIW';

    $response = $transactionResponseBean->getResponsePayload();
   /*  echo "<pre>";
    print_r($response); */



$myresp = array();


    
    //echo "<br><br><br><br>";

    //session_destroy();
    
    $myresp = explode("|",$response);



//print_r($myresp);

//echo $myresp[0];



if($myresp[0] =='txn_status=0300'){


//echo "process ".$response;




/* echo $myresp[7];
echo"<br>";
echo chop(strval($myresp[7]),"clnt_rqst_meta={itc:");
 */

$arr_usd = array();


$arr_usd = explode("~",$myresp[7]);
  //  print_r ($arr_usd);
  $array = array(

    'user_id'=>$arr_usd[1],
    'main_course_priority'=>'PG',
    'complete_response'=>$response,
    'date'=>date("Y-m-d H:i:s") ,
    'status'=>'1',
   
    'pg_primary_course'=>$arr_usd[2],
    'pg_mssw_aided'=>$arr_usd[3],
    'pg_mssw_self'=>$arr_usd[4],
);


$this->db->insert('Applyed_Master', $array);
$insert_id = $this->db->insert_id(); 



redirect('Home/ResponsePaymentPg/'.$insert_id);



//print_r($_SESSION);



}else{


   
  redirect('Home/ResponsePaymentPg/0');









}  ?>

    <!--<a href='<?=base_url();?>Home/'>GO TO HOME</a>-->

    <?php


/* echo "<pre>";
print_r($response); */
   // exit;
}

$user_id = $this->session->userdata('user')['user_id'];

        
        $htyml ="<h2>Application Fees Details</h2><table>
        <tr>
          <th>S.No</th>
          <th>Details</th>
          <th>Fees</th>
        </tr>";
       
    
        

$htyml .="<tr>
<td>1</td>
<td>Application Fee</td>
<td>   ".$user[0]->balance_fees." ₹ </td>
</tr>";
        $res_charge = 0;
  

       
        $htyml .="<tr>
        <td><b>#</b></td>
        <td><b>Total</b></td>
        <td><b>   ".$user[0]->balance_fees." ₹ </b></td>
        </tr></table>";

?>




<div class="container">


<div class="row">
    <form method="post">
    <!--<select name="reqType">
                 <option select value="T">T</option>
                 <option value="S">S</option>
                 <option value="O">O</option>
                 <option value="R">R</option>
                 <option value="TNR">TNR</option>
                 <option value="TCI">TCI</option>
                 <option value="TWC">TWC</option>
                 <option value="TRC">TRC</option>
                 <option value="TCC">TCC</option>
                 <option value="TWI">TWI</option>
                 <option value="TIC">TIC</option>
                 <option value="TIO">TIO</option>
                 <option value="TWD">TWD</option>
             </select>-->

             <input type="hidden" name="reqType" value="T"/>
     
        <input type="hidden" name="mrctCode" value="L74264"/>
   
        <input type="hidden" name="mrctTxtID" value="<?php echo $strNo; ?>"/>
     
        <input type="hidden" name="currencyType" value="INR"/>
    
        <input type="hidden" name="amount" value="<?php echo $user[0]->balance_fees; ?>.00"/>
    
        <input type="hidden" name="itc" value="~<?=$user[0]->pr_user_id?>~<?=$user[0]->pr_course_1?>~<?=$user[0]->pr_course_2?>~<?=$user[0]->pr_course_3?>~"/>
    
        <input type="hidden" name="reqDetail" value="MSSW_<?php echo $user[0]->balance_fees; ?>.0_0.0"/>
    
        <input type="hidden" name="txnDate" value="<?php echo $strCurDate;?>"/>
    
       <input type="hidden" name="bankCode" value=""/>
     
       <!-- <select name="locatorURL">
          <option  value="https://www.tekprocess.co.in/PaymentGateway/TransactionDetailsNew.wsdl">TEST</option>
          <option value="http://10.10.60.46:8080/PaymentGateway/services/TransactionDetailsNew">E2EWithIP</option>
          <option value="https://tpslvksrv6046/PaymentGateway/services/TransactionDetailsNew">E2EWithDomain</option>
          <option value="https://www.tekprocess.co.in/PaymentGateway/services/TransactionDetailsNew">UATWithDomain</option>
          <option value="http://10.10.102.157:8081/PaymentGateway/services/TransactionDetailsNew">UATWithIP</option>
          <option value="http://10.10.102.158:8081/PaymentGateway/services/TransactionDetailsNew">EAP UATWithIP</option>
          <option selected value="https://www.tpsl-india.in/PaymentGateway/TransactionDetailsNew.wsdl">LIVE</option>
          <option value="http://10.10.60.247:8080/PaymentGateway/services/TransactionDetailsNew">Linux E2E</option>
      </select>-->  


    <input type="hidden" name="locatorURL" value="https://www.tpsl-india.in/PaymentGateway/TransactionDetailsNew.wsdl"/>
   <!--<input type="hidden" name="s2SReturnURL" value="https://tpslvksrv6046/LoginModule/Test.jsp"/>-->


<input type="hidden" name="tpsl_txn_id" value="<?php echo 'TXN00'.rand(1,10000); ?>"/>

<input type="hidden" name="cardID" value="<?=$user[0]->pr_user_id?>"/>

<input type="hidden" name="custID" value="<?=$user[0]->pr_user_id?>"/>

<input type="hidden" name="custname" value="<?=$this->session->userdata('user')['user_name']?>"/>

<input type="hidden" name="timeOut" value=""/>

<input type="hidden" name="mobNo" value=""/>

<input type="hidden" name="accNo" value=""/>

<input type="hidden" name="tpvAccntNo" value=""/>

<input type="hidden" name="mmid" value=""/>

<input type="hidden" name="otp" value=""/>

<input type="hidden" name="TxnType" value=""/>

<input type="hidden" name="TxnSubType" value=""/>

<input type="hidden" name="cardName" value=""/>

<input type="hidden" name="cardNo" value=""/>

<input type="hidden" name="cardCVV" value=""/>

<input type="hidden" name="cardExpMM" value=""/>

<input type="hidden" name="cardExpYY" value=""/>

<input type="hidden" name="key" value="1954988003KTWAQS"/>

<input type="hidden" name="iv" value="2319966707XGLFIW"/>

     <input type="hidden" name="returnURL" value='<?=base_url();?>Home/reApplyFeesPg'/>
     <br>

<br>
<br>
<br><br>

<div class="container">
  <div class="vertical-center">

     <input type="submit" class="button" name="submit" value="Pay Fees <?php echo $user[0]->balance_fees; ?> ₹" />
</div>
</div>
</form>

</div>

<div class="row">
<?php
/* echo "<pre>";
print_r($_SESSION);
echo "</pre>"; */

echo $htyml; ?>
</div>
</div>

<br>
<br>

<br>
<br>
<br>
<br>
<style>


.vertical-center {
  margin: 0;
  position: absolute;
  top: 50%;
  -ms-transform: translateY(-50%);
  transform: translateY(-50%);
}
.button {
  background-color: #655692; /* Green */
  border: none;
  color: white;
  position: absolute;
    top: 50%;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>