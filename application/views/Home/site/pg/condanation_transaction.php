<?php

ob_start();
error_reporting(E_ALL);
$strNo = rand(1,1000000);



//echo date_default_timezone_get();

$strCurDate = date('d-m-Y');

//this is the file you pls proceed     .okay let me check 
require_once 'payment/TransactionRequestBean.php';

require_once 'payment/TransactionResponseBean.php';
//session_start();


if($_POST && isset($_POST['submit'])){
    $val = $_POST;

    //print_r($_POST); exit;
   

    $_SESSION['iv'] = $val['iv'];
    $_SESSION['key']   = $val['key'];

    $transactionRequestBean = new TransactionRequestBean();
    //print_r($val['itc']);exit;
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
//    $transactionRequestBean->city = $val['city'];
 //exit('here');
    $url = $transactionRequestBean->getTransactionToken();
    //print_r($url);exit;

    $responseDetails = $transactionRequestBean->getTransactionToken();
    
    $responseDetails = (array)$responseDetails;
    $response = $responseDetails[0];
        
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
        echo "<pre>";
        print_r($response);
        exit;
    }elseif(is_string($response) && preg_match('/^txn_status=/',$response)){
        //exit('txn');
      echo "<pre>";
      print_r($response);
      exit; 
  }

  echo "<script>window.location = '".$response."'</script>";
  ob_flush();

}else if($_POST){
	echo "<pre>";
   

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

    //$response = explode('|',$response);
    $response_data = array();
  
    echo "<pre>";
    print_r($response);
    
    echo "<br><br><br><br>"; 
    $myresp = array();


    
    //echo "<br><br><br><br>";

    //session_destroy();
    
    $myresp = explode("|",$response);
   /// session_destroy();
  // print_r($myresp);
    
$respj=json_encode($myresp);

$arr_usd = array();
$paid_amt = array();
$trans_id = array();


$arr_usd = explode("~",$myresp[7]);
$paid_amt = explode("=",$myresp[6]);
$trans_id = explode("=",$myresp[5]);
  
$que =  $this->db->select("*")->from("condanation_fee_transaction")

->where("id",$arr_usd[1])->get();
$rresult =$que->result();




$user = $this->db->select("*")->from("stu_user")->where("u_id",$rresult[0]->student_id)->get();

$res = $user->result();

$session_data = array(


'user_id'=> $res[0]->u_id,
'user_m_course'=> $res[0]->u_course,
'user_name'=> $res[0]->u_name,
'user_email_id'=> $res[0]->u_email_id,
'user_mobile'=> $res[0]->u_mobile,
'user_email_valid'=> $res[0]->u_email_valid,
'user_mobile_valid'=> $res[0]->u_mobile_valid,

'user_year'=>$res[0]->u_year,
'user_semester'=>$rresult[0]->semester,
);

$this->session->set_userdata('user', $session_data);


if($myresp[0] =='txn_status=0300'){




$array = array(
			
	'paid_status'=>1,
	'paid_response'=>$respj,
	'transaction_id'=> $trans_id[1],
	'paid_amount'=>$paid_amt[1],
	'transaction_status'=>$myresp[1],
	'paid_date'=>date("Y-m-d H:i:s"),

);


$this->db->where("id",$arr_usd[1]);
$this->db->update("condanation_fee_transaction",$array);

$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong> </strong> Transaction Success'.$myresp[1].'.
</div>');

redirect('MyExamination/CondonationFees');

}else{

	$array = array(
			
		
		'paid_response'=>$respj,
	
		'paid_amount'=>$paid_amt[0],
		'transaction_status'=>$myresp[1],
		'paid_date'=>date("Y-m-d H:i:s"),
		
	
	);
	
	
	$this->db->where("id",$arr_usd[1]);
	$this->db->update("condanation_fee_transaction",$array);

	$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong> </strong> Transaction failed'.$myresp[1].'.
</div>');

redirect('MyExamination/CondonationFees');



}









exit;
   
 ?>

   

<?php

}


/* echo"<pre>";
print_r($department);
print_r($transaction);
print_r($subject); */

$id = $transaction[0]->id;
$name = $transaction[0]->student_name;
$register_id = $transaction[0]->register_id;
$amount = $transaction[0]->amount_total;
$semester = $transaction[0]->semester;
$subject_code = $transaction[0]->subject_code;
$totalpaper = sizeof($subject);
$batch = $transaction[0]->batch;
$tn =		$this->db->select("*")->from("exam_condanation_fees")->where("year",date('y'))->get()->result();
$html ='<br><br><br><br><h3></h3><br><br><table class="table"><thead>
<tr>
  <th scope="col">#</th>
  <th scope="col">Subject</th>
  <th scope="col">Subject Code</th>
  <th scope="col">Price</th>
</tr>
</thead>
<tbody>';

$i=1;

foreach ($subject as $key => $value) {

	$html .='<tr>
	<th scope="row">'.$i.'</th>
	<td>'.$value->subName.'</td>
	<td>'.$value->subCode.'</td>
	
	<td>'.$tn[0]->fine_amt.'</td>
  </tr>';
	$i++;
}

$html .='</tbody></table>';

echo $html;
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
    
        <input type="hidden" name="amount" value="<?=$amount ?>.00"/>
    
        <input type="hidden" name="itc" value="~<?=$id?>~<?=$name?>~<?=$department?>~<?=$register_id?>~<?=$amount?>~<?=$subject_code?>~<?=$totalpaper?>~<?=$batch?>"/>
    
        <input type="hidden" name="reqDetail" value="MSSW_<?=$amount ?>.0_0.0"/>
    
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

     <input type="hidden" name="returnURL" value='<?=base_url();?>OtherPayment/condanationMakePayment/<?=$id?>'/>
     <br>

<br>
<br>
<br><br>

<div class="container">
  <div class="vertical-center">
  <a class="btn btn-secondary" href="<?=base_url();?>MyExamination/CondonationFees">Back </a>
     <input type="submit" class="btn btn-success" name="submit" value="Accept and Proceed to pay ₹ <?=$amount ?>" />
</div>
</div>
</form>
<script>

window.history.pushState(null, "", window.location.href);        

window.onpopstate = function() {

		window.history.pushState(null, "", window.location.href);

};

</script>
<style>



</style>


