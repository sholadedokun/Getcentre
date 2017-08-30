   <?php
		error_reporting(E_ALL);
	ini_set('display_errors', 0);
	require_once '../server/fun_connect2.php';
	$response_code=JSON_encode("{
		{remark:'The amount requested is above the limit permitted by your bank, please contact your bank', code:''},
{remark:'File Update File Locked', code:'28'},
{remark:'File Update Field Edit Error', code:'27'},
{remark:'Duplicate Record', code:'26'},
{remark:'File Update not Supported', code:'24'},
{remark:'Unacceptable Transaction Fee', code:'23'},
{remark:'Suspected Malfunction', code:'22'},
{remark:'No Action Taken by Financial Institution', code:'21'},
{remark:'Invalid Response from Financial Institution', code:'20'},
{remark:'Re-enter Transaction', code:'19'},
{remark:'Customer Dispute', code:'18'},
{remark:'Customer Cancellation', code:'17'},
{remark:'Approved by Financial Institution, Update Track 3', code:'16'},
{remark:'No Such Financial Institution', code:'15'},
{remark:'Invalid Amount', code:'13'},
{remark:'Invalid Transaction', code:'12'},
{remark:'Approved by Financial Institution, VIP', code:'11'},
{remark:'Approved by Financial Institution, Partial', code:'10'},
{remark:'Request in Progress', code:'09'},
{remark:'Honor with Identification', code:'08'},
{remark:'Pick-Up Card, Special Condition', code:'07'},
{remark:'Error', code:'06'},
{remark:'Do Not Honor', code:'05'},
{remark:'Pick-up card', code:'04'},
{remark:'Invalid Merchant', code:'03'},
{remark:'Refer to Financial Institution, Special Condition', code:'02'},
{remark:'Refer to Financial Institution', code:'01'},
{remark:'Approved by Financial Institution', code:'00'},
{remark:'Incorrect security details provided. Pin tries exceeded.', code:'75'},
{remark:'Your bank has prevented your card from carrying out this transaction, please contact your bank', code:'61'},
{remark:'Your bank has prevented your card from carrying out this transaction, please contact your bank', code:'57'},
{remark:'Incorrect card details, please verify that the expiry date inputted is correct', code:'56'},
{remark:'Incorrect security details provided.', code:'55'},
{remark:'Incorrect security details provided. Pin tries exceeded.', code:'38'},
{remark:'The card number inputted is invalid, please re-try with a valid card number', code:'14'},
{remark:'The amount requested is above the limit permitted by your bank, please contact your bank', code:'X05'},
{remark:'The amount requested is too low', code:'X04'},
{remark:'File Update Failed', code:'29'},
{remark:'Format Error', code:'30'},
{remark:'Bank Not Supported', code:'31'},
{remark:'Completed Partially by Financial Institution', code:'32'},
{remark:'Expired Card, Pick-Up', code:'33'},
{remark:'Suspected Fraud, Pick-Up', code:'34'},
{remark:'Contact Acquirer, Pick-Up', code:'35'},
{remark:'Restricted Card, Pick-Up', code:'36'},
{remark:'Call Acquirer Security, Pick-Up', code:'37'},
{remark:'PIN Tries Exceeded, Pick-Up', code:'38'},
{remark:'No Credit Account', code:'39'},
{remark:'Function not supported', code:'40'},
{remark:'Lost Card, Pick-Up', code:'41'},
{remark:'No Universal Account', code:'42'},
{remark:'No Investment Account', code:'44'},
{remark:'Insufficient Funds', code:'51'},
{remark:'No Check Account', code:'52'},
{remark:'No Savings Account', code:'53'},
{remark:'Expired Card', code:'54'},
{remark:'Incorrect PIN', code:'55'},
{remark:'No Card Record', code:'56'},
{remark:'Suspected Fraud', code:'59'},
{remark:'Contact Acquirer', code:'60'},
{remark:'Restricted Card', code:'62'},
{remark:'Security Violation', code:'63'},
{remark:'Original Amount Incorrect', code:'64'},
{remark:'Exceeds withdrawal frequency', code:'65'},
{remark:'Call Acquirer Security', code:'66'},
{remark:'Hard Capture', code:'67'},
{remark:'Response Received Too Late', code:'68'},
{remark:'PIN tries exceeded', code:'75'},
{remark:'Intervene, Bank Approval Required', code:'77'},
{remark:'Intervene, Bank Approval Required for Partial Amount', code:'78'},
{remark:'Cut-off in Progress', code:'90'},
{remark:'Issuer or Switch Inoperative', code:'91'},
{remark:'Routing Error', code:'92'},
{remark:'Violation of law', code:'93'},
{remark:'Duplicate Transaction', code:'94'},
{remark:'Reconcile Error', code:'95'},
{remark:'System Malfunction', code:'96'},
{remark:'Exceeds Cash Limit', code:'98'}
}");

	 if($_GET["action"]=='get_amount'){
			$sql="select * FROM pay_log WHERE transaction_ref='".$_GET["txnref"]."'";
			$res= mysql_query($sql);
			while($row=mysql_fetch_array($res)){
				$amount=$row[2]*100;
			}
			$sql="Update user_transaction SET `transactionCodeDescription`='Pending',transactionPaymentType='Interswitch' where `transactionBasketId`='".$_GET["txnref"]."'";
			$res= mysql_query($sql);
			echo $_GET['callback'].json_encode($amount);

    }
		else{

			$curl = curl_init();
			$hash=$_GET["hash"];
			curl_setopt ($curl, CURLOPT_URL, 'https://webpay.interswitchng.com/paydirect/api/v1/gettransaction.json?productid='.$_GET["p_id"].'&transactionreference='.$_GET["txnref"].'&amount='.$_GET["amount"]);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: multipart/form-data", "Hash:$hash",));
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			// Send the request & save response to $resp
			$resp=curl_exec($curl);
			$resp = JSON_decode($resp);

			if($resp==''){$ref=$_GET["txnref"]; $code_descript='Failed'; $res_code='I.N.R';  }
			else{ $ref=$resp->PaymentReference; $code_descript=$resp->ResponseDescription; $res_code= $resp->ResponseCode; }
			$sql="Update user_transaction SET `transactionConfirmationCode`='".$ref."', transactionCodeDescription='".$code_descript."',
			 transactionResponseCode='".$res_code."',  transactionChannel='Web' where `transactionBasketId`='".$_GET["txnref"]."'";
			$res= mysql_query($sql);

			if($resp->ResponseCode=='00'){
			$sql="select * FROM user_transaction WHERE transactionBasketId='".$_GET["txnref"]."'";
			$res= mysql_query($sql);
			$row=mysql_fetch_array($res);
			$to=$row[5];
			$subject = "GETCentre Payment Receipt";
			$message= '<b>Dear</b> '.$row[2].' '.$row[3].' '.$row[4].' <br/><br/>';
			$message.="We've received a payment for your recent transaction on our website<br/>";
			$message.= '<b>Amount:</b> N'.$row[10].' <br>';
			$message.= '<b>Payment Chanel:</b> Interswitch <br>';
			$message.= '<b>Payment Reference:</b> '.$ref.' <br>';
			$message.= '<b>Date:</b> '.gmdate("Y-m-d\TH:i:s\Z", $row[21]).' <br><br>';
			$message.='For further inquiries please contact info@getcentre.com<br><br>';
			$message.= "<b>Best Regards,<br> The GetCentre Team.</b><br>";
			$headers = "MIME-Version: 1.0"."\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers .= "From:Getcentre.com\r\n";
			//$message = nl2br($message);
			$a = mail($to, $subject, $message, $headers);
			}
			curl_close($curl);
			echo $_GET['callback'].json_encode($resp);

		}

	?>
