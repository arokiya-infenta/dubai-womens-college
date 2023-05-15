<?php

ob_start();
error_reporting(E_ALL);
$strNo = rand(1,1000000);


require_once 'payment/TransactionRequestBean.php';

require_once 'payment/TransactionResponseBean.php';
//echo date_default_timezone_get();

$strCurDate = date('d-m-Y');

//this is the file you pls proceed     .okay let me check 

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
    //$transactionRequestBean->s2SReturnURL = $val['s2SReturnURL'];
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

    $url = $transactionRequestBean->getTransactionToken();

    $responseDetails = $transactionRequestBean->getTransactionToken();
    $responseDetails = (array)$responseDetails;
    $response = $responseDetails[0];

    if(is_string($response) && preg_match('/^msg=/',$response)){
        $outputStr = str_replace('msg=', '', $response);
        $outputArr = explode('&', $outputStr);
        $str = $outputArr[0];

        $transactionResponseBean = new TransactionResponseBean();
        $transactionResponseBean->setResponsePayload($str);
        $transactionResponseBean->setKey($val['key']);
        $transactionResponseBean->setIv($val['iv']);

        $response = $transactionResponseBean->getResponsePayload();
        echo "<pre>";
        print_r($response);
        exit;
    }elseif(is_string($response) && preg_match('/^txn_status=/',$response)){
		echo "<pre>";
        print_r($response);
        exit;
	}

   // echo "<script>window.location = '".$response."'</script>";
    ob_flush();

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
    echo "<pre>";
    print_r($response);
    echo "<br><br><br><br>";

    //session_destroy();
	
	
	
	
	
	
    exit;
	
	?>

    <a href='<?php echo "http://".$_SERVER["HTTP_HOST"].$_SERVER['SCRIPT_NAME'];?>'>GO TO HOME</a>

    <?php
    exit;
}

?>


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
    
        <input type="hidden" name="amount" value="2.00"/>
    
        <input type="hidden" name="itc" value="~Test 2~"/>
    
        <input type="hidden" name="reqDetail" value="MSSW_2.0_0.0"/>
    
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

<input type="hidden" name="cardID" value=""/>

<input type="hidden" name="custID" value=""/>

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

     <input type="hidden" name="returnURL" value='<?=base_url();?>PayFees/fullPaymentUg'/>
     <br>

<br>
<br>
<br><br>

<div class="container">
  <div class="vertical-center">

     <input type="submit" class="button" name="submit" value="Pay Fees 2 ₹" />
</div>
</div>
</form>


