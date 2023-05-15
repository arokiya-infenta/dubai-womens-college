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
    /*$transactionResponseBean->key = $_SESSION['key'];
    $transactionResponseBean->iv = $_SESSION['iv'];*/

    $transactionResponseBean->key = '1954988003KTWAQS';
    $transactionResponseBean->iv = '2319966707XGLFIW';

    $response = $transactionResponseBean->getResponsePayload();

    //$response = explode('|',$response);
    $response_data = array();
    /*foreach($response as $key=>$val){        
        $firstToken = explode('=', $val);
        $response_data[$firstToken[0]] = $firstToken[1];
    }*/
   /*  echo "<pre>";
    print_r($response);
     */
    echo "<br><br><br><br>";

    $myresp = array();


    
    //echo "<br><br><br><br>";

    //session_destroy();
    
    $myresp = explode("|",$response);
   /// session_destroy();
  
    
$respj=json_encode($myresp);

$arr_usd = array();
    
    
    $arr_usd = explode("~",$myresp[7]);
  

  //  print_r($arr_usd);

    $table =  $arr_usd[1];
    $user_id =  $arr_usd[2];

   // exit;



   if($myresp[0] =='txn_status=0300'){

  $data = array(
		'paid_through'=>1,
		'ef_paid_status'=>1,
		'ef_paid_response'=>$respj,
		'ef_paid_date'=>date('Y-m-d H:i:s'),
	);
   




    }else{

			$data = array(
				'paid_through'=>1,
				'ef_paid_status'=>0,
				'ef_paid_response'=>$respj,
				'ef_paid_date'=>date('Y-m-d H:i:s'),
			);



		} 

$this->db->where('ef_id',$table);
$this->db->update('erp_exam_fees_master',$data);

redirect('PayFees/arrExamStatus/'.$table); 







    ?>

   <!-- <a href='<?php echo "http://".$_SERVER["HTTP_HOST"].$_SERVER['SCRIPT_NAME'];?>'>GO TO HOME</a>-->

    <?php
   // exit;
}

$ra=[];

$m = $this->db->select("*")->from("erp_exam_fees_master")->where("ef_id",$fees_id)->get()->result_array();


$ra = explode(",",$m[0]['ef_arr_exam']);





//print_r($ra);
if(sizeof($ra)>0){

$q = $this->db->select("erp_exammarkfinal.*,erp_subjectmaster.*,erp_exammarkfinal.sem AS semester,erp_exam_fees.*,erp_particulars.*")
	
	->from("erp_exammarkfinal")
	->join("erp_subjectmaster","erp_exammarkfinal.subject_id=erp_subjectmaster.id")
	->join("erp_particulars","erp_subjectmaster.subNature = erp_particulars.particular_name")
	->join("erp_exam_fees","erp_particulars.id = erp_exam_fees.particular_id AND erp_exam_fees.main_id =".$main)

	->where_in("erp_subjectmaster.id ",$ra)
  ->group_by('erp_subjectmaster.subCode')
	->get();

/* print_r($ra);
print_r($q->result());


exit; */
	$html="";



$html.='<br><br><br><br><br><br><br><br>
<div class="container">';


$m=$q->num_rows();
  if($m > 0){
    $r =$q->result();
$detail = json_encode($r);


    $html .='<div class="row"><table class="table">
		<thead>
		<tr align= "center">
				
				<td colspan="6"> Current Exam</td>
			</tr> 
			<tr>
				<th scope="col">#</th>
				<th scope="col">Subject</th>
			 
				<th scope="col">Code</th>
			<th scope="col">Semester</th>
				<th scope="col">Nature</th>
				<th scope="col">Exam Fees</th>
			</tr>
		</thead>
		<tbody>';
  $amount=0; 
		$i= 1;
		$tot_cur_fee = 0;
		foreach ($r as $key => $svalue) { 
$amount+=(int)$svalue->fees;

			if($svalue->semester == 1){
				$sem = "First Semester";
			}else if($svalue->semester == 2){
				$sem ="Second Semester";
			}else if($svalue->semester == 3){
				$sem ="Third Semester";
			}else if($svalue->semester == 4){
				$sem ="Fourth Semester";
			}else if($svalue->semester == 5){
				$sem ="Fifth Semester";
			}else{
				$sem ="Sixth Semester";

			}

			$html .='<tr>
			<th scope="row">'.$i.'
	</th>
			<td>'.$svalue->subName.'</td>
			<td>'.$svalue->subCode.'</td>
			<td>'.$sem.'</td>
			<td>'.strtoupper($svalue->subNature).'</td>
			<td ><label class="fees_v">'.$svalue->fees.'</label></td>
		</tr>';

		$i++;

		}


   
    $html .='<tbody> </table>
   
    </div>';


  }else{

    $html .="No Arrear Found";
  }




  }else{

    $html .="No Data Found";

  }

  $html .="</div>";


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
    
        <input type="hidden" name="amount" value="<?=$amount?>.00"/>
    
        <input type="hidden" name="itc" value="~<?=$fees_id?>~<?=$this->session->userdata('user')['user_id']?>~"/>
    
        <input type="hidden" name="reqDetail" value="MSSW_<?=$amount?>.0_0.0"/>
    
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

     <input type="hidden" name="returnURL" value='<?=base_url();?>PayFees/payArrearFees/<?=$this->uri->segment(3)?>/<?=$this->uri->segment(4)?>'/>
     <br>

<br>
<br>
<br><br>

<div class="container">
  <div class="vertical-center">
  <button class="btn btn-secondary onclick="history.go(-1);">Back </button>
   <!--  <input type="submit" class="btn btn-success" name="submit" value="Accept and Proceed to pay ₹ <?=$amount?>" />-->
</div>
</div>
</form>
